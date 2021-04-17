<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * Class for Sitemap Generator
 */
class SQ_Controllers_Sitemaps extends SQ_Classes_FrontController {
    /* @var string root name */
    var $root = 'sitemap';

    /* @var string post limit */
    var $posts_limit;
    var $news_limit;

    public function __construct() {
        parent::__construct();
        $this->posts_limit = SQ_Classes_Helpers_Tools::getOption('sq_sitemap_perpage');
        $this->news_limit = SQ_Classes_Helpers_Tools::getOption('sq_sitemap_perpage');
        add_filter('sq_sitemap_style', array($this, 'getSquirrlyHeader'));
        add_action('wp', array($this, 'hookPreventRedirect'), 9);

        add_filter('user_trailingslashit', array($this, 'untrailingslashit'));

        //Process the cron if created
        add_action('sq_processPing', array($this, 'processCron'));

    }

    public function hookPreventRedirect() {
        global $wp_query;

        if (isset($_SERVER['REQUEST_URI'])) {
            if (strpos($_SERVER['REQUEST_URI'], 'sq_feed') !== false) {
                $parseurl = parse_url($_SERVER['REQUEST_URI']);
                $sitemap = 'sitemap';
                $page = 0;

                if (isset($parseurl['query'])) {
                    parse_str($parseurl['query'], $query);
                    $sitemap = (isset($query['sq_feed']) ? $query['sq_feed'] : 'sitemap');
                    $page = (isset($query['page']) ? $query['page'] : 0);
                }

                $wp_query->is_404 = false;
                $wp_query->is_feed = true;

                $this->feedRequest($sitemap, $page);
                apply_filters('sq_sitemapxml', $this->showSitemap());
                die();

            } elseif (strpos($_SERVER['REQUEST_URI'], '.xml') !== false) {
                $parseurl = parse_url($_SERVER['REQUEST_URI']);
                $stemaplist = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');
                $page = 0;

                foreach ($stemaplist as $request => $sitemap) {
                    if (isset($sitemap[0]) && $sitemap[1] && substr($parseurl['path'], (strrpos($parseurl['path'], '/') + 1)) == $sitemap[0]) {

                        $wp_query->is_404 = false;
                        $wp_query->is_feed = true;

                        if (isset($parseurl['query'])) {
                            parse_str($parseurl['query'], $query);
                            $page = (isset($query['page']) ? $query['page'] : 0);
                        }

                        $this->feedRequest($request, $page);
                        apply_filters('sq_sitemapxml', $this->showSitemap());
                        die();
                    }
                }
            } elseif (strpos($_SERVER['REQUEST_URI'], 'locations.kml') !== false) {
                if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_type') == 'Organization') {
                    $wp_query->is_404 = false;
                    $wp_query->is_feed = true;
                    $this->model->type = 'locations';
                    apply_filters('sq_sitemapxml', $this->showSitemap());
                    die();
                }
            }
        }
    }

    /**
     * Send the sitemap to Search Engines only if a page is freshly posted
     *
     * @param $new_status
     * @param $old_status
     * @param $post
     */
    public function refreshSitemap($new_status, $old_status, $post) {
        if ($old_status <> $new_status && $new_status = 'publish') {
            if (SQ_Classes_Helpers_Tools::getOption('sq_sitemap_ping')) {
                wp_schedule_single_event(time() + 5, 'sq_processPing');
            }
        }
    }

    /**
     * Listen the feed call from wordpress
     * @param string $request
     * @param integer $page
     */
    public function feedRequest($request = null, $page = 1) {
        global $sq_query;
        $sq_query = array();

        if (!isset($request)) {
            return;
        }

        $this->model->type = $request;

        if (strpos($request, 'sitemap') !== false) {
            $sq_sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');

            //reset the previous query
            wp_reset_query();

            if ($request == 'sitemap') { //if sitemapindex, return
                return;
            }

            if ($this->model->type == 'sitemap-news') {
                $this->posts_limit = $this->news_limit;
            }

            remove_all_actions('pre_get_posts');
            remove_all_actions('parse_query');
            remove_all_actions('posts_where');

            //init the query
            $sq_query = array(
                'post_type' => array('post'),
                'tax_query' => array(),
                'post_status' => 'publish',
                'posts_per_page' => 1000,
                'paged' => $page,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $this->model->setCurrentLanguage();
            if ($this->model->language <> '') {
                if (!SQ_Classes_Helpers_Tools::getOption('sq_sitemap_combinelangs')) {
                    $sq_query['lang'] = $this->model->language;
                }
            }

            //show products
            if ($this->model->type == 'sitemap-product') {
                if (SQ_Classes_Helpers_Tools::isEcommerce() && $sq_sitemap[$this->model->type][1] == 2) {
                    $sq_sitemap[$this->model->type][1] = 1;
                }
            }

            if (isset($sq_sitemap[$this->model->type]) && $sq_sitemap[$this->model->type][1]) {

                //PREPARE CUSTOM QUERIES
                switch ($this->model->type) {
                    case 'sitemap-news':
                    case 'sitemap-post':
                        $sq_query['posts_per_page'] = $this->posts_limit;
                        break;
                    case 'sitemap-category':
                    case 'sitemap-post_tag':
                    case 'sitemap-custom-tax':
                        remove_all_filters('terms_clauses'); //prevent language filters
                        add_filter('get_terms_fields', array($this, 'customTaxFilter'), 5, 2);
                        break;
                    case 'sitemap-page':
                        $sq_query['post_type'] = array('page');
                        $sq_query['posts_per_page'] = $this->posts_limit;
                        break;
                    case 'sitemap-attachment':
                        $sq_query['post_type'] = array('attachment');
                        $sq_query['post_status'] = array('publish', 'inherit');
                        break;
                    case 'sitemap-author':
                        add_filter('sq-sitemap-authors', array($this, 'authorFilter'), 5);
                        break;
                    case 'sitemap-custom-post':
                        $types = get_post_types(array('public' => true));
                        foreach (array('post', 'page', 'attachment', 'revision', 'nav_menu_item', 'product', 'wpsc-product', 'ngg_tag') as $exclude) {
                            if (in_array($exclude, $types)) {
                                unset($types[$exclude]);
                            }
                        }

                        foreach ($types as $type) {
                            $type_data = get_post_type_object($type);
                            if ((isset($type_data->rewrite['publicly_queryable']) && $type_data->rewrite['publicly_queryable'] == 1) || (isset($type_data->publicly_queryable) && $type_data->publicly_queryable == 1)) {
                                continue;
                            }
                            unset($types[$type]);
                        }

                        if (empty($types)) {
                            array_push($types, 'custom-post');
                        }

                        $sq_query['post_type'] = $types;
                        break;
                    case 'sitemap-product':
                        if (SQ_Classes_Helpers_Tools::isEcommerce()) {
                            $types = array('product', 'wpsc-product');
                        } else {
                            $types = array('custom-post');
                        }
                        $sq_query['post_type'] = $types;
                        $sq_query['posts_per_page'] = $this->posts_limit;

                        break;
                    case 'sitemap-archive':
                        add_filter('sq-sitemap-archive', array($this, 'archiveFilter'), 5);
                        break;
                }

                //add custom filter
                do_action('do_feed_' . $this->model->type);
            }
        }

    }

    public function getSquirrlyHeader($header) {
        if ($this->model->type <> 'locations') {
            $header = '<?xml-stylesheet type="text/xsl" href="/' . _SQ_ASSETS_RELATIVE_URL_ . 'css/sitemap' . ($this->model->type == 'sitemap' ? 'index' : '') . '.xsl"?>' . "\n";
            $header .= '<!-- generated-on="' . date('Y-m-d\TH:i:s+00:00') . '" -->' . "\n";
            $header .= '<!-- generator="Squirrly SEO Sitemap" -->' . "\n";
            $header .= '<!-- generator-url="https://wordpress.org/plugins/squirrly-seo/" -->' . "\n";
            $header .= '<!-- generator-version="' . SQ_VERSION . '" -->' . "\n";
        }

        return $header;
    }

    /**
     * Show the Sitemap Header
     * @param array $include Include schema
     */
    public function showSitemapHeader($include = array()) {
        @ini_set('memory_limit', apply_filters('admin_memory_limit', WP_MAX_MEMORY_LIMIT));

        header('Status: 200 OK', true, 200);
        header('Content-Type: text/xml; charset=' . get_bloginfo('charset'), true);
        //Generate header
        echo '<?xml version="1.0" encoding="' . get_bloginfo('charset') . '"?>' . "\n";
        echo apply_filters('sq_sitemap_style', false);

        echo '' . "\n";

        $schema = array(
            'image' => 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"',
            'video' => 'xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"',
            'news' => 'xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"',
            'mobile' => 'xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0"',
        );

        if (!empty($include))
            $include = array_unique($include);

        switch ($this->model->type) {
            case 'locations':
                echo '<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
                echo '<Document>' . "\n";
                break;
            case 'sitemap':
                echo '<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
                    . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" '
                    . 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
                foreach ($include as $value) {
                    echo ' ' . $schema[$value] . "\n";
                }
                echo '>' . "\n";
                break;
            case 'sitemap-news':
                array_push($include, 'news');
                $include = array_unique($include);
            default:
                echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
                    . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" '
                    . 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
                if (!empty($include))
                    foreach ($include as $value) {
                        echo " " . $schema[$value] . " ";
                    }
                echo '>' . "\n";
                break;
        }
    }

    /**
     * Show the Sitemap Footer
     */
    private function showSitemapFooter() {
        switch ($this->model->type) {
            case 'locations':
                echo '</Document>' . "\n";
                echo '</kml>' . "\n";
                break;
            case 'sitemap':
                echo '</sitemapindex>' . "\n";
                break;
            default :
                echo '</urlset>' . "\n";
                break;
        }
    }

    /**
     * Create the XML sitemap
     * @return string
     */
    public function showSitemap() {
        switch ($this->model->type) {
            case 'sitemap':
                $this->showSitemapHeader();
                $sq_sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');
                $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');

                if (!empty($sq_sitemap))
                    foreach ($sq_sitemap as $name => $value) {

                        //check if available from SEO Automation
                        $pname = str_replace(array('sitemap-', 'post_'), '', $name);
                        if (isset($patterns[$pname]['do_sitemap']) && !$patterns[$pname]['do_sitemap']) {
                            continue;
                        }

                        //force to show products if not preset
                        if ($name == 'sitemap-product' && !SQ_Classes_Helpers_Tools::isEcommerce()) {
                            continue;
                        }

                        if ($name !== 'sitemap' && ($value[1] == 1 || $value[1] == 2)) {
                            echo "\t" . '<sitemap>' . "\n";
                            echo "\t" . '<loc>' . $this->getXmlUrl($name) . '</loc>' . "\n";
                            echo "\t" . '<lastmod>' . mysql2date('Y-m-d\TH:i:s+00:00', get_lastpostmodified('gmt'), false) . '</lastmod>' . "\n";
                            echo "\t" . '</sitemap>' . "\n";


                            if ($name == 'sitemap-post' && $count_posts = wp_count_posts()) {
                                if (isset($count_posts->publish) && $count_posts->publish > 0 && $count_posts->publish > $this->posts_limit) {
                                    $pages = ceil($count_posts->publish / $this->posts_limit);
                                    for ($page = 2; $page <= $pages; $page++) {
                                        echo "\t" . '<sitemap>' . "\n";
                                        echo "\t" . '<loc>' . $this->getXmlUrl($name, $page) . '</loc>' . "\n";
                                        echo "\t" . '<lastmod>' . mysql2date('Y-m-d\TH:i:s+00:00', get_lastpostmodified('gmt'), false) . '</lastmod>' . "\n";
                                        echo "\t" . '</sitemap>' . "\n";
                                    }
                                }
                            }
                            if ($name == 'sitemap-page' && $count_posts = wp_count_posts('page')) {
                                if (isset($count_posts->publish) && $count_posts->publish > 0 && $count_posts->publish > $this->posts_limit) {
                                    $pages = ceil($count_posts->publish / $this->posts_limit);
                                    for ($page = 2; $page <= $pages; $page++) {
                                        echo "\t" . '<sitemap>' . "\n";
                                        echo "\t" . '<loc>' . $this->getXmlUrl($name, $page) . '</loc>' . "\n";
                                        echo "\t" . '<lastmod>' . mysql2date('Y-m-d\TH:i:s+00:00', get_lastpostmodified('gmt'), false) . '</lastmod>' . "\n";
                                        echo "\t" . '</sitemap>' . "\n";
                                    }
                                }
                            }
                            if ($name == 'sitemap-product' && $count_posts = wp_count_posts('product')) {
                                if (isset($count_posts->publish) && $count_posts->publish > 0 && $count_posts->publish > $this->posts_limit) {
                                    $pages = ceil($count_posts->publish / $this->posts_limit);
                                    for ($page = 2; $page <= $pages; $page++) {
                                        echo "\t" . '<sitemap>' . "\n";
                                        echo "\t" . '<loc>' . $this->getXmlUrl($name, $page) . '</loc>' . "\n";
                                        echo "\t" . '<lastmod>' . mysql2date('Y-m-d\TH:i:s+00:00', get_lastpostmodified('gmt'), false) . '</lastmod>' . "\n";
                                        echo "\t" . '</sitemap>' . "\n";
                                    }
                                }
                            }

                        }
                    }
                $this->showSitemapFooter();
                break;
            case 'sitemap-home':
                $this->showPackXml($this->model->getHomeLink());
                break;
            case 'sitemap-news':
                $this->showPackXml($this->model->getListNews());
                break;
            case 'sitemap-category':
            case 'sitemap-post_tag':
            case 'sitemap-custom-tax':
                $this->showPackXml($this->model->getListTerms());
                break;
            case 'sitemap-author':
                $this->showPackXml($this->model->getListAuthors());
                break;
            case 'sitemap-archive':
                $this->showPackXml($this->model->getListArchive());
                break;
            case 'sitemap-attachment':
                $this->showPackXml($this->model->getListAttachments());
                break;
            case 'locations':
                $this->showPackKml($this->model->getKmlXML());
                break;
            default:
                $this->showPackXml($this->model->getListPosts());
                break;
        }
    }

    /**
     * Pach the XML for each sitemap
     * @param array $xml
     * @return void
     */
    public function showPackXml($xml = array()) {
        if (empty($xml)) {
            $xml['contains'] = '';
        }
        if (!isset($xml['contains'])) {
            $xml['contains'] = '';
        }
        $this->showSitemapHeader($xml['contains']);

        unset($xml['contains']);
        foreach ($xml as $row) {
            echo "\t" . '<url>' . "\n";

            if (is_array($row)) {
                echo $this->getRecursiveXml($row);
            }
            echo "\t" . '</url>' . "\n";
        }
        $this->showSitemapFooter();
        unset($xml);
    }

    /**
     * Pach the XML for each sitemap
     * @param array $kml
     * @return void
     */
    public function showPackKml($kml = array()) {

        $this->showSitemapHeader();
        header('Content-Type: application/vnd.google-earth.kml+xml; charset=' . get_bloginfo('charset'), true);
        echo $this->getRecursiveXml($kml);
        $this->showSitemapFooter();

        unset($kml);
    }

    public function getRecursiveXml($xml, $pkey = '', $level = 2) {
        $str = '';
        $tab = str_repeat("\t", $level);
        if (is_array($xml)) {
            $cnt = 0;
            foreach ($xml as $key => $data) {
                if ($data === false) {
                    $str .= $tab . '<' . $key . '>' . "\n";
                } elseif (!is_array($data) && $data <> '') {
                    $str .= $tab . '<' . $key . ($key == 'video:player_loc' ? ' allow_embed="yes"' : '') . '>' . $data . ((strpos($data, '?') == false && $key == 'video:player_loc') ? '' : '') . '</' . $key . '>' . "\n";
                } else {
                    if ($this->getRecursiveXml($data) <> '') {
                        if (!$this->_ckeckIntergerArray($data)) {
                            $str .= $tab . '<' . (!is_numeric($key) ? $key : $pkey) . '>' . "\n";
                        }
                        $str .= $this->getRecursiveXml($data, $key, ($this->_ckeckIntergerArray($data) ? $level : $level + 1));
                        if (!$this->_ckeckIntergerArray($data)) {
                            $str .= $tab . '</' . (!is_numeric($key) ? $key : $pkey) . '>' . "\n";
                        }
                    }
                }
                $cnt++;
            }
        }
        return $str;
    }

    private function _ckeckIntergerArray($data) {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                return true;
            }
            break;
        }
        return false;
    }

    /**
     * Set the query limit
     * @param integer $limits
     * @return string
     */
    public function setLimits($limits) {
        if (isset($this->posts_limit) && $this->posts_limit > 0) {
            return 'LIMIT 0, ' . $this->posts_limit;
        }

        return '';
    }

    /**
     * Get the url for each sitemap
     * @param string $sitemap
     * @param integer $page
     * @return string
     */
    public function getXmlUrl($sitemap, $page = null) {
        $sq_sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');

        if (!get_option('permalink_structure')) {
            $sitemap = '?sq_feed=' . str_replace('.xml', '', $sitemap) . (isset($page) ? '&amp;page=' . $page : '');
        } else {
            if (isset($sq_sitemap[$sitemap])) {
                $sitemap = $sq_sitemap[$sitemap][0] . (isset($page) ? '?page=' . $page : '');
            }

            if (strpos($sitemap, '.xml') === false) {
                $sitemap .= '.xml';
            }
        }

        $this->model->setCurrentLanguage();
        if ($this->model->language <> '' && function_exists('pll_home_url')) {
            return pll_home_url($this->model->language) . $sitemap;
        }

        return esc_url(trailingslashit(home_url())) . $sitemap;
    }

    public function getKmlUrl($sitemap, $page = null) {
        $sq_sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');

        if (!get_option('permalink_structure')) {
            $sitemap = '?sq_feed=' . str_replace('.kml', '', $sitemap) . (isset($page) ? '&amp;page=' . $page : '');
        } else {
            if (isset($sq_sitemap[$sitemap])) {
                $sitemap = $sq_sitemap[$sitemap][0] . (isset($page) ? '?page=' . $page : '');
            }

            if (strpos($sitemap, '.kml') === false) {
                $sitemap .= '.kml';
            }
        }

        return esc_url(trailingslashit(home_url())) . $sitemap;
    }


    /**
     * Process the on-time cron if called
     */
    public function processCron() {
        SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_Tools');

        $sq_sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');
        if (!empty($sq_sitemap)) {
            foreach ($sq_sitemap as $name => $sitemap) {
                if ($sitemap[1] == 1) { //is the default sitemap
                    $this->SendPing($this->getXmlUrl($name));
                }
            }
        }
    }

    /**
     * Ping the sitemap to Google and Bing
     * @param string $sitemapUrl
     * @return boolean
     */
    protected function SendPing($sitemapUrl) {
        $success = true;
        $urls = array(
            "https://www.google.com/ping?sitemap=%s",
            "http://www.bing.com/ping?sitemap=%s",
        );

        $options = array(
            'method' => 'get',
            'sslverify' => false,
            'timeout' => 10
        );

        foreach ($urls as $url) {
            if ($responce = SQ_Classes_ObjController::getClass('SQ_Classes_RemoteController')->sq_wpcall(sprintf($url, $sitemapUrl), $options)) {
                $success = true;
            }
        }

        return $success;
    }

    /**
     * Delete the fizical file if exists
     * @return boolean
     */
    public function deleteSitemapFile() {
        $sq_sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');
        if (isset($sq_sitemap[$this->root])) {
            if (file_exists(ABSPATH . $sq_sitemap[$this->root])) {
                @unlink(ABSPATH . $sq_sitemap[$this->root]);
                return true;
            }
        }
        return false;
    }

    /**
     * Remove the trailing slash from permalinks that have an extension,
     * such as /sitemap.xml
     *
     * @param string $request
     */
    public function untrailingslashit($request) {
        if (pathinfo($request, PATHINFO_EXTENSION)) {
            return untrailingslashit($request);
        }
        return $request; // trailingslashit($request);
    }

    public function postFilter(&$query) {
        $query->set('tax_query', array());
    }

    /**
     * Filter the Custom Taxonomy
     * @param $query
     * @param $args
     * @return array
     */
    public function customTaxFilter($query, $args) {
        global $wpdb;
        $query[] = $wpdb->prepare("(SELECT
                        UNIX_TIMESTAMP(MAX(p.post_date_gmt)) as _mod_date
                 FROM `$wpdb->posts` p, `$wpdb->term_relationships` r
                 WHERE p.ID = r.object_id  
                 AND p.post_status = %s  
                 AND p.post_password = ''  
                 AND r.term_taxonomy_id = tt.term_taxonomy_id 
                ) as lastmod", 'publish');


        return $query;
    }

    public function pageFilter(&$query) {
        $query->set('post_type', array('page'));
        $query->set('tax_query', array());
    }

    public function authorFilter() {
        //get only the author with posts
        add_filter('pre_user_query', array($this, 'userFilter'));
        return get_users();
    }

    public function userFilter($query) {
        global $wpdb;

        $query->query_fields .= ',p.lastmod';
        $query->query_from .= ' LEFT OUTER JOIN (
            SELECT MAX(post_modified) as lastmod, post_author, COUNT(*) as post_count
            FROM `' . $wpdb->posts . '`
            WHERE post_type = "post" AND post_status = "publish"
            GROUP BY post_author
        ) p ON (wp_users.ID = p.post_author)';
        $query->query_where .= ' AND post_count  > 0 ';
    }

    public function customPostFilter(&$query) {
        $types = get_post_types(array('public' => true));
        foreach (array('post', 'page', 'attachment', 'revision', 'nav_menu_item', 'product', 'wpsc-product') as $exclude) {
            if (in_array($exclude, $types)) {
                unset($types[$exclude]);
            }
        }

        foreach ($types as $type) {
            $type_data = get_post_type_object($type);
            if ((isset($type_data->rewrite['feeds']) && $type_data->rewrite['feeds'] == 1) || (isset($type_data->feeds) && $type_data->feeds == 1)) {
                continue;
            }
            unset($types[$type]);
        }

        if (empty($types)) {
            array_push($types, 'custom-post');
        }

        $query->set('post_type', $types); // id of page or post
        $query->set('tax_query', array());
    }

    public function productFilter(&$query) {

        if (!$types = SQ_Classes_Helpers_Tools::isEcommerce()) {
            $types = array('custom-post');
        }
        $query->set('post_type', $types); // id of page or post
        $query->set('tax_query', array());
    }

    public function archiveFilter() {
        global $wpdb;
        $archives = $wpdb->get_results($wpdb->prepare("
                        SELECT DISTINCT YEAR(post_date_gmt) as `year`, MONTH(post_date_gmt) as `month`, max(post_date_gmt) as lastmod, count(ID) as posts
                        FROM `$wpdb->posts`
                        WHERE post_date_gmt < NOW()  AND post_status = %s  AND post_type = %s
                        GROUP BY YEAR(post_date_gmt),  MONTH(post_date_gmt)
                        ORDER BY  post_date_gmt DESC
                    ", 'publish', 'post'));
        return $archives;
    }

}
