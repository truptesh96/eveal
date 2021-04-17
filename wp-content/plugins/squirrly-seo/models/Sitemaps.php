<?php

/**
 * Squirrly SEO - Sitemap Model
 *
 * Used to get the sitemap format for each type
 *
 * @class        SQ_Models_Sitemaps
 */
class SQ_Models_Sitemaps extends SQ_Models_Abstract_Seo {

    public $args = array();
    public $frequency;
    public $type;
    public $language; //plugins language
    protected $postmodified;

    public function __construct() {

        //For sitemap ping
        $this->args['timeout'] = 5;

        $this->frequency = array();
        $this->frequency['hourly'] = array('sitemap-home' => array(1, 'hourly'), 'sitemap-product' => array(1, 'hourly'), 'sitemap-post' => array(1, 'hourly'), 'sitemap-page' => array(0.6, 'hourly'), 'sitemap-category' => array(0.5, 'daily'), 'sitemap-post_tag' => array(0.5, 'daily'), 'sitemap-archive' => array(0.3, 'monthly'), 'sitemap-author' => array(0.3, 'daily'), 'sitemap-custom-tax' => array(0.3, 'hourly'), 'sitemap-custom-post' => array(1, 'hourly'), 'sitemap-attachment' => array(0.3, 'hourly'));
        $this->frequency['daily'] = array('sitemap-home' => array(1, 'daily'), 'sitemap-product' => array(0.8, 'daily'), 'sitemap-post' => array(0.8, 'daily'), 'sitemap-page' => array(0.6, 'weekly'), 'sitemap-category' => array(0.5, 'weekly'), 'sitemap-post_tag' => array(0.5, 'daily'), 'sitemap-archive' => array(0.3, 'monthly'), 'sitemap-author' => array(0.3, 'weekly'), 'sitemap-custom-tax' => array(0.3, 'weekly'), 'sitemap-custom-post' => array(0.8, 'daily'), 'sitemap-attachment' => array(0.3, 'weekly'));
        $this->frequency['weekly'] = array('sitemap-home' => array(1, 'weekly'), 'sitemap-product' => array(0.8, 'weekly'), 'sitemap-post' => array(0.8, 'weekly'), 'sitemap-page' => array(0.6, 'monthly'), 'sitemap-category' => array(0.3, 'monthly'), 'sitemap-post_tag' => array(0.5, 'weekly'), 'sitemap-archive' => array(0.3, 'monthly'), 'sitemap-author' => array(0.3, 'weekly'), 'sitemap-custom-tax' => array(0.3, 'weekly'), 'sitemap-custom-post' => array(0.8, 'weekly'), 'sitemap-attachment' => array(0.3, 'monthly'));
        $this->frequency['monthly'] = array('sitemap-home' => array(1, 'monthly'), 'sitemap-product' => array(0.8, 'weekly'), 'sitemap-post' => array(0.8, 'monthly'), 'sitemap-page' => array(0.6, 'monthly'), 'sitemap-category' => array(0.3, 'monthly'), 'sitemap-post_tag' => array(0.5, 'monthly'), 'sitemap-archive' => array(0.3, 'monthly'), 'sitemap-author' => array(0.3, 'monthly'), 'sitemap-custom-tax' => array(0.3, 'monthly'), 'sitemap-custom-post' => array(0.8, 'monthly'), 'sitemap-attachment' => array(0.3, 'monthly'));
        $this->frequency['yearly'] = array('sitemap-home' => array(1, 'monthly'), 'sitemap-product' => array(0.8, 'weekly'), 'sitemap-post' => array(0.8, 'monthly'), 'sitemap-page' => array(0.6, 'yearly'), 'sitemap-category' => array(0.3, 'yearly'), 'sitemap-post_tag' => array(0.5, 'monthly'), 'sitemap-archive' => array(0.3, 'yearly'), 'sitemap-author' => array(0.3, 'yearly'), 'sitemap-custom-tax' => array(0.3, 'yearly'), 'sitemap-custom-post' => array(0.8, 'monthly'), 'sitemap-attachment' => array(0.3, 'monthly'));


    }

    public function setCurrentLanguage() {
        //Set the local language
        global $polylang;
        $this->language = get_locale();
        if ($polylang && function_exists('pll_default_language') && isset($polylang->links_model)) {
            if (!$this->language = $polylang->links_model->get_language_from_url()) {
                $this->language = pll_default_language();
            }
        }
    }

    /**
     * Add the Sitemap Index
     * @global  $polylang
     * @return array
     */
    public function getHomeLink() {
        $homes = array();
        $homes['contains'] = array();

        if (function_exists('pll_languages_list') && function_exists('pll_home_url')) {
            if (SQ_Classes_Helpers_Tools::getOption('sq_sitemap_combinelangs')) {
                // print_R(PLL()->model->get_languages_list());
                foreach (pll_languages_list() as $term) {
                    $xml = array();
                    $xml['loc'] = esc_url(pll_home_url($term));
                    $xml['lastmod'] = trim(mysql2date('Y-m-d\TH:i:s+00:00', date('Y-m-d', strtotime(get_lastpostmodified('gmt'))), false));
                    $xml['changefreq'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')]['sitemap-home'][1];
                    $xml['priority'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')]['sitemap-home'][0];
                    $homes[] = $xml;
                }
            } else {

                $xml = array();
                $xml['loc'] = esc_url(pll_home_url($this->language));
                $xml['lastmod'] = trim(mysql2date('Y-m-d\TH:i:s+00:00', date('Y-m-d', strtotime(get_lastpostmodified('gmt'))), false));
                $xml['changefreq'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')]['sitemap-home'][1];
                $xml['priority'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')]['sitemap-home'][0];
                $homes[] = $xml;

            }
        } else {

            if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setHomePage()) {
                if ($post->sq->nositemap || !$post->sq->do_sitemap) {
                    return $homes;
                }

                $xml = array();
                $xml['loc'] = $post->url;
                $xml['lastmod'] = trim(mysql2date('Y-m-d\TH:i:s+00:00', $this->lastModified($post), false));
                $xml['changefreq'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')][$this->type][1];
                $xml['priority'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')][$this->type][0];
            }
            $homes[] = $xml;
            unset($xml);
        }

        return $homes;
    }

    /**
     * Add posts/pages in sitemap
     * @return array
     */
    public function getListPosts() {
        global $wp_query, $sq_query;

        $wp_query = new WP_Query($sq_query);
        $wp_query->is_paged = false; //remove pagination

        $posts = $post_ids = array();
        $posts['contains'] = array();
        if (have_posts()) {
            //get all the post ids
            //$post_ids = wp_list_pluck(get_posts(), 'ID');

            while (have_posts()) {
                the_post();
                $currentpost = get_post();

                //do not incude password protected pages in sitemap
                if (post_password_required()) {
                    continue;
                }

                if (function_exists('pll_get_post_translations')) {
                    if (SQ_Classes_Helpers_Tools::getOption('sq_sitemap_combinelangs')) {
                        $translates = pll_get_post_translations($currentpost->ID);
                        if (!empty($translates)) {
                            foreach ($translates as $post_id) {
                                if (!in_array($post_id, $post_ids)) { //prevent from showing duplicates
                                    if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($post_id)) {
                                        if ($post->sq->nositemap || !$post->sq->do_sitemap) {
                                            continue;
                                        }
                                        $posts[] = $this->_getXml($post);
                                        array_push($post_ids, $post_id);
                                    }
                                }
                                //always add the current post ID as processed
                                array_push($post_ids, $currentpost->ID);
                            }
                        }
                    } else {
                        if ($post_id = pll_get_post($currentpost->ID)) {
                            if (!in_array($post_id, $post_ids)) { //prevent from showing duplicates
                                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($post_id)) {
                                    if ($post->sq->nositemap || !$post->sq->do_sitemap) {
                                        continue;
                                    }
                                    $posts[] = $this->_getXml($post);

                                    array_push($post_ids, $post_id);

                                }
                            }
                            //always add the current post ID as processed
                            array_push($post_ids, $currentpost->ID);
                        }
                    }
                }

                if (!in_array($currentpost->ID, $post_ids)) { //prevent from showing duplicates
                    if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($currentpost)) {
                        if ($post->sq->nositemap || !$post->sq->do_sitemap) {
                            continue;
                        }

                        $posts[] = $this->_getXml($post);
                        array_push($post_ids, $post->ID);
                    }
                }
            }
        }

        if (!empty($posts)) {
            foreach ($posts as $post) {
                if (array_key_exists('image:image', $post)) {
                    array_push($posts['contains'], 'image');
                }
                if (array_key_exists('video:video', $post)) {
                    array_push($posts['contains'], 'video');
                }
            }
        }

        return $posts;
    }

    public function getListAttachments() {
        global $wp_query, $sq_query;

        $wp_query = new WP_Query($sq_query);
        $wp_query->is_paged = false; //remove pagination

        $posts = array();
        $posts['contains'] = array();
        if (have_posts()) {
            while (have_posts()) {
                the_post();

                //do not incude password protected pages in sitemap
                if (post_password_required()) {
                    continue;
                }

                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID(get_post())) {
                    if ($post->sq->nositemap || !$post->sq->do_sitemap) {
                        continue;
                    }
                    $xml = $this->_getXml($post);
                    if (strpos($xml['loc'], '?') !== false) {
                        $xml['loc'] = wp_get_attachment_url($post->ID);
                    }
                    $posts[] = $xml;
                }


            }
        }

        foreach ($posts as $post) {
            if (array_key_exists('image:image', $post)) {
                array_push($posts['contains'], 'image');
            }
            if (array_key_exists('video:video', $post)) {
                array_push($posts['contains'], 'video');
            }
        }

        return $posts;
    }

    /**
     * Add the post news in sitemap
     * If the site is registeres for google news
     * @return array
     */
    public function getListNews() {
        global $wp_query, $sq_query;
        $wp_query = new WP_Query($sq_query);
        $wp_query->is_paged = false; //remove pagination

        $posts = array();
        $posts['contains'] = array();

        if (have_posts()) {
            while (have_posts()) {
                the_post();

                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost(get_post())->getPost()) {
                    if ($post->sq->nositemap || !$post->sq->do_sitemap) {
                        continue;
                    }

                    $xml = array();
                    $xml['loc'] = esc_url($post->url);

                    $language = convert_chars(strip_tags(get_bloginfo('language')));
                    if (strpos($language, '-')) {
                        $language = substr($language, 0, strpos($language, '-'));
                    }
                    if ($language == '') {
                        $language = 'en';
                    }

                    $xml['news:news'][$post->ID] = array(
                        'news:publication' => array(
                            'news:name' => SQ_Classes_Helpers_Sanitize::clearTitle(get_bloginfo('name')),
                            'news:language' => $language
                        )
                    );

                    $xml['news:news'][$post->ID]['news:publication_date'] = trim(mysql2date('Y-m-d\TH:i:s+00:00', $this->lastModified($post), false));
                    $xml['news:news'][$post->ID]['news:title'] = SQ_Classes_Helpers_Sanitize::clearTitle($post->sq->title);
                    $xml['news:news'][$post->ID]['news:keywords'] = SQ_Classes_Helpers_Sanitize::clearKeywords($post->sq->keywords);


                    if (SQ_Classes_Helpers_Tools::$options['sq_sitemap_show']['images'] == 1) {
                        if ($images = $this->getPostImages($post->ID, true)) {
                            array_push($posts['contains'], 'image');
                            $xml['image:image'] = array();
                            foreach ($images as $image) {
                                if (empty($image['src'])) {
                                    continue;
                                }

                                $xml['image:image'][] = array(
                                    'image:loc' => esc_url($image['src']),
                                    'image:title' => SQ_Classes_Helpers_Sanitize::clearTitle($image['title']),
                                    'image:caption' => SQ_Classes_Helpers_Sanitize::clearDescription($image['description']),
                                );
                            }
                        }
                    }

                    if (SQ_Classes_Helpers_Tools::$options['sq_sitemap_show']['videos'] == 1) {
                        $images = $this->getPostImages($post->ID, true);
                        if (isset($images[0]['src']) && $videos = $this->getPostVideos($post->ID)) {
                            array_push($posts['contains'], 'video');
                            $xml['video:video'] = array();
                            foreach ($videos as $video) {
                                if ($video == '') {
                                    continue;
                                }


                                $xml['video:video'][$post->ID] = array(
                                    'video:player_loc' => $video,
                                    'video:thumbnail_loc' => $images[0]['src'],
                                    'video:title' => SQ_Classes_Helpers_Sanitize::clearTitle($post->sq->title),
                                    'video:description' => SQ_Classes_Helpers_Sanitize::clearDescription($post->sq->description),
                                );

                                //set the first keyword for this video
                                $keywords = $post->sq->keywords;
                                $keywords = preg_split('/,/', $keywords);
                                if (is_array($keywords)) {
                                    $xml['video:video'][$post->ID]['video:tag'] = SQ_Classes_Helpers_Sanitize::clearKeywords($keywords[0]);
                                }
                            }
                        }
                    }
                    $posts[] = $xml;
                    unset($xml);
                }
            }
        }

        return $posts;
    }

    /**
     * Add the Taxonomies in sitemap
     * @param string $type
     * @return array
     */
    public function getListTerms($type = null) {
        if (!isset($type)) {
            $type = $this->type;
        }

        $terms = $array = array();
        $array['contains'] = array();

        //Get only custom post types
        if ($type == 'sitemap-custom-tax') {
            $excludelist = array(
                'category',
                'post_tag',
                'nav_menu',
                'link_category',
                'post_format',
                'ngg_tag',
            );

            $args = array(
                'public' => true,
                '_builtin' => false
            );

            $taxonomies = $this->excludeTypes(get_taxonomies($args), $excludelist);
            if (!empty($taxonomies)) {
                $taxonomies = array_unique($taxonomies);
            }
            foreach ($taxonomies as $taxonomy) {
                $array = array_merge($array, $this->getListTerms($taxonomy));

            }
        } else {
            $terms = get_terms(str_replace('sitemap-', '', $type), array(
                'hide_empty' => true,
                'number' => 500
            ));
        }

        if (!isset(SQ_Classes_Helpers_Tools::$options['sq_sitemap'][$type])) {
            $this->type = 'sitemap-custom-tax';
        }

        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms AS $term) {
                //make sure it has a language
                if (function_exists('pll_get_post_translations') && function_exists('pll_get_term')) {
                    if (!$term->term_id = pll_get_term($term->term_id, $this->language)) {
                        continue;
                    }
                }

                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByTaxID($term->term_id, $term->taxonomy)) {
                    if ($post->sq->nositemap || !$post->sq->do_sitemap || !$post->url) {
                        continue;
                    }
                    $array[] = $this->_getXml($post);

                }

            }
        }

        return $array;
    }

    /**
     * Add the authors in sitemap
     * @return array
     */
    public function getListAuthors() {
        $array = array();
        $authors = apply_filters('sq-sitemap-authors', $this->type);

        if (!empty($authors)) {
            foreach ($authors AS $author) {
                $xml = array();

                $xml['loc'] = get_author_posts_url($author->ID, $author->user_nicename);
                if (isset($author->lastmod) && $author->lastmod <> '')
                    $xml['lastmod'] = date('Y-m-d\TH:i:s+00:00', strtotime($author->lastmod));
                $xml['changefreq'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')][$this->type][1];
                $xml['priority'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')][$this->type][0];

                $array[] = $xml;
            }
        }
        return $array;
    }

    /**
     * Add the archive in sitemap
     * @return array
     */
    public function getListArchive() {
        $array = array();
        $archives = apply_filters('sq-sitemap-archive', $this->type);
        if (!empty($archives)) {
            foreach ($archives as $archive) {
                $xml = array();

                $xml['loc'] = get_month_link($archive->year, $archive->month);
                if (isset($archive->lastmod) && $archive->lastmod <> '')
                    $xml['lastmod'] = date('Y-m-d\TH:i:s+00:00', strtotime($archive->lastmod));

                $xml['changefreq'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')][$this->type][1];
                $xml['priority'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')][$this->type][0];

                $array[] = $xml;
            }
        }

        return $array;
    }

    /**
     * Generate the KML file contents.
     *
     * @return array $kml KML file content.
     */
    public function getKmlXML() {
        $xml = array();
        $jsonld = SQ_Classes_Helpers_Tools::getOption('sq_jsonld');

        if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_type') == 'Organization') {
            if ($jsonld['Organization']['place']['geo']['latitude'] <> '' && $jsonld['Organization']['place']['geo']['longitude'] <> '') {

                $xml['name'] = 'Locations for ' . $jsonld['Organization']['name'];
                $xml['description'] = $jsonld['Organization']['description'];
                $xml['open'] = 1;

                $xml['Folder']['Placemark']['name'] = $jsonld['Organization']['name'];
                $xml['Folder']['Placemark']['description'] = $jsonld['Organization']['description'];

                //Add business address
                $xml['Folder']['Placemark']['address'] = '';
                if ($jsonld['Organization']['address']['streetAddress'] <> '') {
                    $xml['Folder']['Placemark']['address'] .= $jsonld['Organization']['address']['streetAddress'];
                }
                if ($jsonld['Organization']['address']['addressLocality'] <> '') {
                    $xml['Folder']['Placemark']['address'] .= ',' . $jsonld['Organization']['address']['addressLocality'];
                }
                if ($jsonld['Organization']['address']['postalCode'] <> '') {
                    $xml['Folder']['Placemark']['address'] .= ',' . $jsonld['Organization']['address']['postalCode'];
                }
                if ($jsonld['Organization']['address']['addressCountry'] <> '') {
                    $xml['Folder']['Placemark']['address'] .= ',' . $jsonld['Organization']['address']['addressCountry'];
                }


                $xml['Folder']['Placemark']['phoneNumber'] = $jsonld['Organization']['contactPoint']['telephone'];
                //$xml['Folder']['Placemark']['atom:link href="' . get_bloginfo('url') . '"'] = false;
                $xml['Folder']['Placemark']['LookAt']['latitude'] = $jsonld['Organization']['place']['geo']['latitude'];
                $xml['Folder']['Placemark']['LookAt']['longitude'] = $jsonld['Organization']['place']['geo']['longitude'];
                $xml['Folder']['Placemark']['LookAt']['altitude'] = 0;
                $xml['Folder']['Placemark']['LookAt']['range'] = 0;
                $xml['Folder']['Placemark']['LookAt']['tilt'] = 0;
                $xml['Folder']['Placemark']['LookAt']['altitudeMode'] = 'relativeToGround';
                $xml['Folder']['Placemark']['Point']['altitudeMode'] = 'relativeToGround';
                $xml['Folder']['Placemark']['Point']['coordinates'] = $jsonld['Organization']['place']['geo']['longitude'];
                $xml['Folder']['Placemark']['Point']['coordinates'] .= ',' . $jsonld['Organization']['place']['geo']['latitude'];
                $xml['Folder']['Placemark']['Point']['coordinates'] .= ',0';
            }
        }

        return $xml;
    }

    /**
     * Get the XML of the URL
     * @param $post
     * @return array
     */
    private function _getXml($post) {
        $xml = array();

        if (!isset($post->url) || !$post->url) {
            return $xml;
        }

        //Prevent sitemap from braking due to & in URLs
        $xml['loc'] = esc_url($post->url);
        $xml['lastmod'] = trim(mysql2date('Y-m-d\TH:i:s+00:00', $this->lastModified($post), false));
        $xml['changefreq'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')][$this->type][1];
        $xml['priority'] = $this->frequency[SQ_Classes_Helpers_Tools::getOption('sq_sitemap_frequency')][$this->type][0];

        //Get Post Images
        if ((int)$post->ID > 0 && SQ_Classes_Helpers_Tools::$options['sq_sitemap_show']['images'] == 1) {
            if ($images = $this->getPostImages($post->ID, true)) {
                $xml['image:image'] = array();
                foreach ($images as $image) {
                    if (empty($image['src'])) {
                        continue;
                    }

                    $xml['image:image'][] = array(
                        'image:loc' => esc_url($image['src']),
                        'image:title' => SQ_Classes_Helpers_Sanitize::clearTitle($image['title']),
                        'image:caption' => SQ_Classes_Helpers_Sanitize::clearDescription($image['description']),
                    );
                }
            }
        }
        //Get Post Video
        if ((int)$post->ID > 0 && SQ_Classes_Helpers_Tools::$options['sq_sitemap_show']['videos'] == 1) {
            $images = $this->getPostImages($post->ID, true);
            if (isset($images[0]['src']) && $videos = $this->getPostVideos($post->ID)) {
                $xml['video:video'] = array();
                foreach ($videos as $video) {
                    if ($video == '') {
                        continue;
                    }

                    $xml['video:video'][$post->ID] = array(
                        'video:player_loc' => esc_url($video),
                        'video:thumbnail_loc' => $images[0]['src'],
                        'video:title' => SQ_Classes_Helpers_Sanitize::clearTitle($post->sq->title),
                        'video:description' => SQ_Classes_Helpers_Sanitize::clearDescription($post->sq->description),
                    );

                    //set the first keyword for this video
                    $keywords = $post->sq->keywords;
                    $keywords = preg_split('/,/', $keywords);
                    if (is_array($keywords)) {
                        $xml['video:video'][$post->ID]['video:tag'] = SQ_Classes_Helpers_Sanitize::clearKeywords($keywords[0]);
                    }
                }
            }
        }

        return $xml;
    }

    /**
     * Get the last modified date for the specific post/page
     *
     * @global SQ_Models_Domain_Post $post
     * @return string
     */
    public function lastModified($post) {
        if ($post instanceof SQ_Models_Domain_Post) {
            if (isset($post->ID) && $post->ID > 0) {

                return get_post_modified_time('Y-m-d H:i:s', true, $post->ID);

            } elseif (isset($post->term_id) && $post->term_id > 0 && $post->taxonomy <> '') {

                // get the latest post in this taxonomy item, to use its post_date as lastmod
                $posts = get_posts(array(
                        'post_type' => 'any',
                        'numberposts' => 1,
                        'no_found_rows' => true,
                        'update_post_meta_cache' => false,
                        'update_post_term_cache' => false,
                        'update_cache' => false,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $post->taxonomy,
                                'field' => 'term_id',
                                'terms' => $post->term_id
                            )
                        )
                    )
                );

                if (isset($posts[0]->post_date_gmt) && $posts[0]->post_date_gmt <> '') {
                    return $posts[0]->post_date_gmt;
                }
            }
        }

        return date('Y-m-d H:i:s', strtotime(get_lastpostmodified('gmt')));
    }

    /**
     * Excude types from array
     * @param array $types
     * @param array $exclude
     * @return array
     */
    public function excludeTypes($types, $exclude) {
        foreach ($exclude as $value) {
            if (in_array($value, $types)) {
                unset($types[$value]);
            }
        }
        return $types;
    }

}