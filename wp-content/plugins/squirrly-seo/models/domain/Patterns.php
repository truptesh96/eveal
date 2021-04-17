<?php

class SQ_Models_Domain_Patterns extends SQ_Models_Abstract_Domain {

    protected $_id; //Replaced with the post/page ID
    protected $_term_id;
    protected $_taxonomy;
    protected $_post_type;
    protected $_guid; //Replaced with the post/page slug

    public function setId($id) {
        $this->_id = $id;
    }

    /*********************************************************************************/
    protected $_date; //Replaced with the date of the post/page

    public function setPost_date($value) {
        $this->_date = $value;
    }

    //
    protected $_title; //Replaced with the title of the post/page

    public function setPost_title($value) {
        if ($value <> '') {
            $this->_title = $value;
        }
    }

    public function getTitle() {
        if (!isset($this->_title) || $this->_title == '') {
            if ((int)$this->_term_id > 0) {
                $tag = get_term_by('term_id', $this->_term_id, $this->_taxonomy);
                if (!is_wp_error($tag)) {
                    $this->_title = $tag->name;
                }
            } elseif ($post = $this->currentpost) {
                if (trim($post->post_title) <> '') {
                    $this->_title = $post->post_title;
                }
            }
        }

        $this->_title = SQ_Classes_Helpers_Sanitize::clearTitle($this->_title);
        return $this->truncate($this->_title, 10, $this->getDescription_maxlength());
    }

    //
    protected $_post_parent;
    protected $_parent_title; //Replaced with the title of the parent page of the current page

    public function getParent_title() {
        if (isset($this->_post_parent) && (int)$this->_post_parent > 0) {
            if ($post = $this->_getPost($this->_post_parent)) {
                $this->_parent_title = $post->post_title;
            }
        }

        return $this->_parent_title;
    }

    protected $_sitename; //The site's name

    public function getSitename() {
        return get_bloginfo('name');
    }

    //
    protected $_sitedesc; //The site's tag line / description

    public function getSitedesc() {
        $description = SQ_Classes_Helpers_Sanitize::clearDescription(get_bloginfo('description'));
        return $this->truncate($description, 10, $this->getDescription_maxlength());
    }

    //
    protected $_excerpt; //Replaced with the post/page excerpt (or auto-generated if it does not exist)

    public function setPost_excerpt($value) {
        if ($value <> '') {
            $this->_excerpt = trim($value);
        }
    }

    protected $_excludedText = array('This is a Page excerpt. It will be displayed for search results', 'Auto Draft');

    public function getExcerpt() {
        if (!isset($this->_excerpt) || $this->_excerpt == '') {
            if ((int)$this->_term_id > 0) {
                $tag = get_term_by('term_id', $this->_term_id, $this->_taxonomy);
                if (!is_wp_error($tag)) {
                    $this->_excerpt = $tag->description;
                }
            } elseif ($post = $this->currentpost) {
                if (isset($post->post_excerpt) && $post->post_excerpt <> '' && !in_array($post->post_excerpt, $this->_excludedText)) {
                    $this->_excerpt = $post->post_excerpt;
                } elseif ($post->post_content <> '') {
                    $this->_excerpt = $post->post_content;
                }
            }
        }

        if (isset($this->_excerpt) && in_array($this->_excerpt, $this->_excludedText)) {
            $this->_excerpt = null;
        }

        $this->_excerpt = SQ_Classes_Helpers_Sanitize::clearDescription($this->_excerpt);
        return $this->truncate($this->_excerpt, 10, $this->getDescription_maxlength());
    }

    protected $_post_description; //Replaced with the post/page content description (or auto-generated if it does not exist)

    public function getPost_description() {
        if ($post = $this->currentpost) {

            if ($post->post_content <> '') {
                $this->_excerpt = $post->post_content;
            }
        }

        $this->_excerpt = SQ_Classes_Helpers_Sanitize::clearDescription($this->_excerpt);
        return $this->truncate($post->_excerpt, 10, $this->getDescription_maxlength());
    }

    protected $_excerpt_only; //Replaced with the post/page excerpt (without auto-generation)

    public function getExcerpt_only() {
        if ($post = $this->currentpost) {

            if (isset($post->post_excerpt) && $post->post_excerpt <> '') {
                $this->_excerpt_only = $this->post_excerpt;
            }
        }

        if (isset($this->_excerpt_only) && in_array($this->_excerpt_only, $this->_excludedText)) {
            $this->_excerpt_only = null;
        }

        $this->_excerpt_only = SQ_Classes_Helpers_Sanitize::clearDescription($this->_excerpt_only);
        return $this->truncate($this->_excerpt_only, 10, $this->getDescription_maxlength());
    }

    //
    protected $_category; //Replaced with the post categories (comma separated)

    public function getCategory() {
        if (!isset($this->_category) || $this->_category == '') {
            if ($this->_post_type == 'category') {
                $this->_category = $this->title;
            } elseif ($this->_id > 0) {
                //change category title if article
                $categories = get_the_category($this->_id);
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $this->_category .= ($this->_category <> '' ? ', ' : '') . $category->name;
                    }
                } else {
                    //change category title if article
                    $all_terms = wp_get_object_terms($this->_id, get_taxonomies(array('public' => true)));
                    if (!is_wp_error($all_terms) && !empty($all_terms)) {
                        foreach ($all_terms as $term) {
                            if (strpos($term->slug, 'cat') !== false) {
                                $this->_category .= ($this->_category <> '' ? ', ' : '') . $term->name;
                            }
                        }
                    }
                }
            }
        }
        return $this->_category;
    }

    protected $_primary_category; //Replaced with the primary category of the post/page
    protected $_primary_category_id;

    public function getPrimary_category() {
        if (!isset($this->_primary_category) || $this->_primary_category == '') {
            if ($this->_id > 0) {
                //change category title if article
                $categories = get_the_category($this->_id);
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $this->_primary_category = $category->name;
                        break;
                    }
                } else {
                    //change category title if article
                    $all_terms = wp_get_object_terms($this->_id, get_taxonomies(array('public' => true)));
                    if (!is_wp_error($all_terms) && !empty($all_terms)) {
                        foreach ($all_terms as $term) {
                            if (strpos($term->slug, 'cat') !== false) {
                                $this->_primary_category = $term->name;
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $this->_primary_category;
    }

    //
    protected $_category_description; //Replaced with the category description

    public function getCategory_description() {
        if (!isset($this->_category_description) || $this->_category_description == '') {
            if ($this->_post_type == 'category') {
                $this->_category_description = $this->excerpt;
            } elseif ($this->_id > 0) {
                //change category description if article
                $categories = get_the_category($this->_id);
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $this->_category = $category->name;
                        $this->_category_description = $category->description;
                        break; //get only the first one
                    }
                } else {
                    //change category title if article
                    $all_terms = wp_get_object_terms($this->_id, get_taxonomies(array('public' => true)));
                    if (!is_wp_error($all_terms) && !empty($all_terms)) {
                        foreach ($all_terms as $term) {
                            $this->_category = $term->name;
                            $this->_category_description = $term->description;
                            break; //get only the first tag
                        }
                    }
                }


            }
        }

        $this->_category_description = SQ_Classes_Helpers_Sanitize::clearDescription($this->_category_description);
        return $this->truncate($this->_category_description, 10, $this->getDescription_maxlength());
    }

    protected $_tag; //Replaced with the current tag/tags

    public function getTag() {
        if (!isset($this->_tag) || $this->_tag == '') {
            if ($this->_post_type == 'tag') {
                $this->_tag = $this->title;
            } elseif ($this->_id > 0) {
                //change the tag title if article
                $tags = wp_get_post_tags($this->_id);
                if (!empty($tags)) {
                    $this->_tag = '';
                    foreach ($tags as $tag) {
                        $this->_tag .= ($this->_tag <> '' ? ',' : '') . $tag->name;
                    }
                } else {
                    //change category title if article
                    $all_terms = wp_get_object_terms($this->_id, get_taxonomies(array('public' => true)));
                    if (!is_wp_error($all_terms) && !empty($all_terms)) {
                        foreach ($all_terms as $term) {
                            if (strpos($term->slug, 'tag') !== false) {
                                $this->_tag .= ($this->_tag <> '' ? ',' : '') . $term->name;
                            }
                        }
                    }
                }

            }

        }
        return $this->_tag;
    }

    protected $_tag_description; //Replaced with the tag description

    public function getTag_description() {
        if (!isset($this->_tag_description) || $this->_tag_description == '') {
            if ($this->_post_type == 'tag') {
                $this->_tag_description = $this->_excerpt;
            } else {
                //change the tag description if article
                $tags = wp_get_post_tags($this->_id);
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        $this->_tag_description = $tag->description;
                        break;
                    }
                } else {
                    //change category title if article
                    $all_terms = wp_get_object_terms($this->_id, get_taxonomies(array('public' => true)));
                    if (!is_wp_error($all_terms) && !empty($all_terms)) {
                        foreach ($all_terms as $term) {
                            if (strpos($term->slug, 'tag') !== false) {
                                $this->_tag_description = $term->description;
                            }
                        }
                    }
                }
            }
        }

        $this->_tag_description = SQ_Classes_Helpers_Sanitize::clearDescription($this->_tag_description);
        return $this->truncate($this->_tag_description, 10, $this->getDescription_maxlength());
    }

    protected $_term_title; //Replaced with the term name

    public function getTerm_title() {
        if (!isset($this->_term_title) || $this->_term_title == '') {
            if ((int)$this->_term_id > 0) {
                $this->_term_title = $this->title;
            }
        }

        $this->_term_title = SQ_Classes_Helpers_Sanitize::clearTitle($this->_term_title);
        return $this->truncate($this->_term_title, 10, $this->getTitle_maxlength());
    }

    protected $_term_description; //Replaced with the term description

    public function getTerm_description() {
        if (!isset($this->_term_description) || $this->_term_description == '') {
            if ((int)$this->_term_id > 0) {
                $this->_term_description = $this->excerpt;
            }
        }

        $this->_term_description = SQ_Classes_Helpers_Sanitize::clearDescription($this->_term_description);
        return $this->truncate($this->_term_description, 10, $this->getDescription_maxlength());
    }

    //
    protected $_searchphrase; //Replaced with the current search phrase

    public function getSearchphrase() {
        if (!isset($this->_searchphrase)) {
            $search = get_query_var('s');
            if ($search !== '') {
                $this->_searchphrase = esc_html($search);
            }
            $search = SQ_Classes_Helpers_Tools::getValue('s');
            if ($search !== '') {
                $this->_searchphrase = esc_html($search);
            }
        }
        return $this->_searchphrase;
    }

    //
    protected $_sep; //The separator defined in your theme's wp_title tag

    public function setSep($sep = null) {
        if (isset($sep) && $sep <> '') {
            $this->_sep = $sep;
        }
    }

    public function getSep() {
        if (!isset($this->_sep)) {
            $this->_sep = '-';
        }

        $seps = json_decode(SQ_ALL_SEP, true);

        if (isset($seps[$this->_sep])) {
            return $seps[$this->_sep];
        } else {
            return $this->_sep;
        }
    }

    /*********************************************************************************/
    //
    protected $_page; //Replaced with the current page number with context (i.e. page 2 of 4)

    public function getPage() {
        if (is_paged()) {
            return $this->sep . ' ' . esc_html__("Page", _SQ_PLUGIN_NAME_) . ' ' . (int)get_query_var('paged') . ' ' .
                esc_html__("of", _SQ_PLUGIN_NAME_) . ' ' . $this->pagetotal;
        }
        return '';
    }

    //
    protected $_pagetotal; //Replaced with the current page total

    public function getPagetotal() {
        global $wp_query;
        if (isset($wp_query->max_num_pages))
            return (int)$wp_query->max_num_pages;

        return '';
    }

    protected $_pagenumber; //Replaced with the current page number

    //
    public function getPagenumber() {
        if (is_paged()) {
            return (int)get_query_var('paged');
        }
        return '';
    }

    //
    protected $_pt_single; //Replaced with the post type single label
    protected $_pt_plural; //Replaced with the post type plural label
    protected $_modified; //Replaced with the post/page modified time

    public function setPost_modified($value) {
        if ($value <> '') {
            $this->_modified = $value;
        }
    }


    protected $_name; //Replaced with the post/page author's 'nicename'

    public function setPost_author($value) {
        if ($value <> '') {
            if (is_numeric($value)) {
                $this->_name = get_the_author_meta('nickname', (int)$value);
            } else {
                $this->_name = $value;
            }
        }
    }

    protected $_user_description; //Replaced with the post/page author's 'Biographical Info'

    public function getUser_description() {
        if (!isset($this->_user_description) || $this->_user_description == '') {
            if ($this->_post_type == 'profile') {
                $this->_user_description = $this->excerpt;
            }
        }

        $this->_user_description = SQ_Classes_Helpers_Sanitize::clearDescription($this->_user_description);
        return $this->truncate($this->_user_description, 10, $this->getDescription_maxlength());
    }

    protected $_userid; //Replaced with the post/page author's userid
    protected $_currenttime; //Replaced with the current time

    public function getCurrenttime() {
        return date(get_option('time_format'));
    }

    protected $_currentdate; //Replaced with the current date

    public function getCurrentdate() {
        return date(get_option('date_format'));
    }

    protected $_currentday; //Replaced with the current day

    public function getCurrentday() {
        return date('d');
    }

    protected $_currentmonth; //Replaced with the current month

    public function getCurrentmonth() {
        return date('F');
    }

    protected $_currentyear; //Replaced with the current year

    public function getCurrentyear() {
        return date('Y');
    }

    protected $_caption; //Attachment caption

    //handle keywords
    protected $_keywords;
    protected $_keyword; //Replaced with the posts focus keyword
    protected $_focuskw; //Same as keyword

    public function setKeywords($value) {
        $this->_focuskw = $this->_keyword =$value;
    }

    public function getKeyword() {
        return $this->_keyword;
    }

    public function getFocuskw() {
        return $this->_focuskw;
    }

    protected $_term404; //Replaced with the slug which caused the 404
    /*********************************************************************************/

    ///////////
    public function getPatterns() {
        $patterns = array();

        try {
            foreach ($this->_getProperties() as $property => $value) {
                $patterns[$property] = '{{' . $property . '}}';
            }
        } catch (Exception $e) {
        }

        return $patterns;
    }

    protected $_currentpost;

    public function getCurrentPost() {
        if (!isset($this->_currentpost)) {
            if (isset($this->id) && (int)$this->id > 0) {
                $this->_currentpost = $this->_getPost($this->id);
            } else {
                $this->_currentpost = false;
            }
        }

        return $this->_currentpost;
    }

    private function _getPost($id = null) {
        $post = false;

        if (isset($id)) {
            if (isset($this->id) && (int)$this->id > 0) {
                $post = get_post($id);
            }
        }

        return $post;
    }

    public function truncate($text, $min = 100, $max = 110) {

        if ($text <> '' && strlen($text) > $max) {
            if ($max < strlen($text)) {
                while ($text[$max] != ' ' && $max > $min) {
                    $max--;
                }
            }
            $text = substr($text, 0, $max);
            return trim(stripcslashes($text));
        }

        return $text;
    }

    public function getTitle_maxlength() {
        $metas = SQ_Classes_Helpers_Tools::getOption('sq_metas');
        return $metas['title_maxlength'];
    }

    public function getDescription_maxlength() {
        $metas = SQ_Classes_Helpers_Tools::getOption('sq_metas');
        return $metas['description_maxlength'];
    }

    protected $_product_name;

    public function getProduct_name() {
        global $product;

        if ($this->_post_type == 'product') {
            if (!isset($this->_product_name) && $this->_id > 0) {
                if (!class_exists('WC_Product')) {
                    return '';
                }

                try {
                    $product = new WC_Product($this->_id);

                    if (!$product instanceof WC_Product) {
                        return '';
                    }

                    if (method_exists($product, 'get_name')) {
                        $this->_product_name = $product->get_name();
                    } elseif (method_exists($product, 'get_title')) {
                        $this->_product_name = $product->get_title();
                    }
                } catch (Exception $e) {

                }
            }
        }

        return $this->_product_name;
    }

    protected $_product_price;

    public function getProduct_price() {
        global $product;

        if ($this->_post_type == 'product') {
            if (!isset($this->_product_price) && $this->_id > 0) {
                if (!class_exists('WC_Product') || !function_exists('wc_format_decimal') || !function_exists('wc_get_price_decimals')) {
                    return '';
                }

                try {
                    $product = new WC_Product($this->_id);

                    if (!$product instanceof WC_Product) {
                        return '';
                    }

                    $this->_product_price = wc_format_decimal($product->get_price(), wc_get_price_decimals());
                } catch (Exception $e) {

                }
            }
        }

        return $this->_product_price;
    }

    protected $_product_sale;

    public function getProduct_sale() {
        global $product;

        if ($this->_post_type == 'product') {
            if (!isset($this->_product_sale) && $this->_id > 0) {
                if (!class_exists('WC_Product') || !function_exists('wc_format_decimal') || !function_exists('wc_get_price_decimals')) {
                    return '';
                }

                try {
                    $product = new WC_Product($this->_id);

                    if (!$product instanceof WC_Product) {
                        return '';
                    }

                    if (method_exists($product, 'get_variation_prices')) {
                        $prices = $product->get_variation_prices();
                        $this->_product_sale = wc_format_decimal(current($prices['price']), wc_get_price_decimals());
                    }
                } catch (Exception $e) {

                }
            }
        }
        return $this->_product_sale;
    }

    protected $_product_currency;

    public function getProduct_currency() {
        global $product;

        if ($this->_post_type == 'product') {
            if (!isset($this->_product_currency) && $this->_id > 0) {
                if (!class_exists('WC_Product') || !function_exists('get_woocommerce_currency')) {
                    return '';
                }

                try {
                    $product = new WC_Product($this->_id);

                    if (!$product instanceof WC_Product) {
                        return '';
                    }

                    $currency = get_woocommerce_currency();
                    $this->_product_currency = $currency;
                } catch (Exception $e) {

                }
            }
        }

        return $this->_product_currency;
    }
}
