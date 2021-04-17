<?php

class SQ_Models_Services_JsonLD extends SQ_Models_Abstract_Seo {
    private $_data = array();
    private $_types = array();
    private $_markups = array();

    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if (!$this->_post->sq->do_jsonld) {
                add_filter('sq_json_ld', array($this, 'returnFalse'));
                return;
            }

            //decode the URL for json format
            if ($this->_post->url) {
                $this->_post->url = urldecode(esc_url($this->_post->url));
            }

            //If not yet set
            $this->_post->sq->jsonld_types = array_filter((array)$this->_post->sq->jsonld_types);
            if (empty($this->_post->sq->jsonld_types)) {
                //If not set, get the type saved by Open Graph
                if ($this->_post->sq->og_type <> '') {
                    $this->_post->sq->jsonld_types = array($this->_post->sq->og_type);
                }
            }

            if (!empty($this->_post->sq->jsonld_types)) {
                add_filter('sq_json_ld', array($this, 'generateStructuredData'), 10);

                add_filter('sq_json_ld', array($this, 'generateJsonLd'));
                add_filter('sq_json_ld', array($this, 'packJsonLd'), 99);
                add_filter('sq_json_ld', array($this, 'packJsonLd'), 99);

            }
        } else {
            add_filter('sq_json_ld', array($this, 'returnFalse'));
        }

    }


    /**
     * Sanitizes, encodes and outputs structured data.
     *
     * @return array|string
     */
    public function generateJsonLd() {
        return $this->clean($this->getStructuredData($this->getDataTypes()));
    }

    /**
     * Pack the Structured Data
     */
    public function packJsonLd($data = array()) {
        if (!empty($data)) {
            //If custom JSON-LD and not Auto Draft
            if ($this->_post->sq->jsonld && strpos($this->_post->sq->jsonld, '"name":"Auto Draft"') === false) {
                //If contains script, return the custom jsonld
                if (strpos($this->_post->sq->jsonld, 'application/ld+json') !== false) {
                    return $this->_post->sq->jsonld;
                }

                return '<script type="application/ld+json">' . $this->_post->sq->jsonld . '</script>';

            } else {
                //Compatibility with ACF
                if (SQ_Classes_Helpers_Tools::isPluginInstalled('advanced-custom-fields/acf.php')) {
                    if (isset($this->_post->ID) && $this->_post->ID) {
                        if ($_sq_jsonld_custom = get_post_meta($this->_post->ID, '_sq_jsonld_custom', true)) {
                            if (strpos($_sq_jsonld_custom, 'application/ld+json') !== false) {
                                return $_sq_jsonld_custom;
                            } else {
                                return '<script type="application/ld+json">' . $_sq_jsonld_custom . '</script>';
                            }
                        }
                    }
                }

                return '<script type="application/ld+json">' . wp_json_encode($data, SQ_DEBUG && !SQ_Classes_Helpers_Tools::isAjax() ? JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES : JSON_UNESCAPED_SLASHES) . '</script>';
            }
        }

        return false;
    }

    /**
     * Sets data.
     *
     * @param  array $data Structured data.
     * @param  bool $reset Unset data (default: false).
     * @return bool
     */
    public function setData($data, $reset = false) {
        if (!isset($data['@type']) || !preg_match('|^[a-zA-Z]{1,20}$|', $data['@type'])) {
            return false;
        } else {
            if ($data['@type'] <> 'Review' && in_array(strtolower($data['@type']), $this->_types)) {
                return false;
            }

            $this->_types[] = strtolower($data['@type']);
        }

        if ($reset && isset($this->_data)) {
            unset($this->_data);
        }

        $this->_data[] = $data;
        return true;
    }

    /**
     * Gets data.
     *
     * @return array
     */
    public function getData() {
        return apply_filters('sq_json_ld_data', $this->_data);
    }

    /**
     * Structures and returns data.
     *
     * List of types available by default for specific request:
     *
     * 'product',
     * 'review',
     * 'breadcrumblist',
     * 'website',
     * 'order',
     *
     * @param  array $types Structured data types.
     * @return array
     */
    public function getStructuredData($types) {
        $data = array();
        // Put together the values of same type of structured data.
        foreach ($this->getData() as $value) {
            $data[$value['@type']][] = $value;
            $data[strtolower($value['@type'])][] = $value;
        }

        //mage array unique
        $types = array_unique($types);

        // Wrap the multiple values of each type inside a graph... Then add context to each type.
        foreach ($data as $type => $value) {
            $data[$type] = count((array)$value) > 1 ? array('@graph' => $value) : $value[0];
            $data[$type] = apply_filters('woocommerce_structured_data_context', array(), $data, $type, $value) + $data[$type];
        }

        // If requested types, pick them up... Finally change the associative array to an indexed one.
        $data = $types ? array_values(array_intersect_key($data, array_flip($types))) : array_values($data);

        if (!empty($data)) {
            $data = array('@context' => 'https://schema.org', '@graph' => $data);
        }
        return $data;
    }

    /**
     * Get data types for pages.
     *
     * @return array
     */
    public function getDataTypes() {
        return array_filter(apply_filters('sq_structured_data_type_for_page', $this->_types));
    }

    /**
     * Make sure the data is sanitized
     * @param $var
     * @return array|string
     */
    public function clean($var) {
        if (is_array($var)) {
            return array_map(array($this, 'clean'), $var);
        } else {
            return is_scalar($var) ? sanitize_text_field($var) : $var;
        }
    }

    /**
     * Set custom JsonLD from database postmeta
     * @param $markup
     * @param $post
     * @param $type
     * @return mixed
     */
    public function setCustomJsonLd($markup, $post, $type) {
        //Custom jsonld for this post id
        $sq_jsonld = get_post_meta($post->ID, '_sq_jsonld_builder', true);

        if (is_string($sq_jsonld) && !empty($sq_jsonld)) {
            $sq_jsonld = json_decode($sq_jsonld, true);
        }

        if (!empty($sq_jsonld) && isset($sq_jsonld[strtolower($type)])) {
            foreach ($sq_jsonld[strtolower($type)] as $key => $value) {

                if (is_array($value)) {
                    $value = @array_filter($value);

                    if (empty($value)) continue;

                    foreach ($value as $index => $value1) {
                        if (is_array($value1)) {
                            $value1 = @array_filter($value1);
                            if (empty($value1)) {
                                unset($value[$index]);
                            }
                        }
                    }

                    if (count($value) == 1) {
                        continue;
                    }

                    //don't let numeric indexing
                    if (current(array_keys($value)) == 0) {
                        $value = array_values($value);
                    }
                }

                if ($value) {
                    $markup[$key] = $value;
                }
            }
        }

        return $markup;

    }

    /**
     * Generate JSON-LD Structured data based on jsonld types and post type
     */
    public function generateStructuredData() {

        if ($this->_post->post_type == 'home') {
            $jsonld_type = SQ_Classes_Helpers_Tools::getOption('sq_jsonld_type');
            $this->_markups[] = $this->getPublisherMarkup($jsonld_type);
        }

        if (in_array('website', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getWebsiteMarkup();
        }

        if (in_array('newsarticle', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getArticleMarkup('NewsArticle');
        }

        if (in_array('article', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getArticleMarkup('Article');
        }

        if (in_array('QA Page', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getQAMarkup();
        }

        if (in_array('question', $this->_post->sq->jsonld_types) || in_array('FAQ page', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getQuestionMarkup();
        }

        if (in_array('movie', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getMovieMarkup();
        }

        if (in_array('recipe', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getRecipeMarkup();
        }

        if (in_array('review', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getReviewMarkup();
        }

        if (in_array('local store', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getLocalBusinessMarkup('Store');
        }

        if (in_array('local restaurant', $this->_post->sq->jsonld_types)) {
            $this->_markups[] = $this->getLocalBusinessMarkup('Restaurant');
        }

        if ($this->_post->post_type == 'profile' || in_array('profile', $this->_post->sq->jsonld_types)) {
            if ($this->_post->post_author <> '') {
                $markup['@type'] = 'Person';
                $markup['@id'] = $this->getAuthor('user_url') . '#person';
                $markup['url'] = $this->getAuthor('user_url');
                $markup['name'] = $this->cleanText($this->getAuthor('display_name'));

                $this->_markups[] = $markup;
            }
        }

        if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_woocommerce')) {
            if (SQ_Classes_Helpers_Tools::isPluginInstalled('woocommerce/woocommerce.php')) {
                // Generate structured data for Woocommerce 3+.
                if ($this->_post->post_type == 'product' || in_array('product', $this->_post->sq->jsonld_types)) {
                    $this->_markups[] = $this->getWoocommerceProductMarkup();

                }
            }
        }

        if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_breadcrumbs')) {
            $this->_markups[] = $this->getBreadcrumbsMarkup();
        }

        //register the markup
        foreach ($this->_markups as $markup) {
            $this->setData($markup);
        }
    }

    public function cleanText($text) {
        $text = str_replace(array('&#034;', '&#8220;', '&#8221;'), '"', $text);

        return $text;
    }

    /**
     * Set the markup for the Article, NewsArticle Schema
     *
     * @param $post_type
     * @return mixed
     */
    public function getArticleMarkup($post_type) {
        $markup = array();
        $markup['@type'] = $post_type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($post_type);
        $markup['url'] = $this->_post->url;

        if (isset($this->_post->sq->title)) {
            $markup['name'] = $this->cleanText($this->truncate($this->_post->sq->title, 0, $this->_post->sq->jsonld_title_maxlength));
        }

        if (isset($this->_post->sq->description)) {
            $markup['headline'] = $this->cleanText($this->truncate($this->_post->sq->description, 0, $this->_post->sq->jsonld_description_maxlength));
        }

        $markup['mainEntityOfPage'] = array(
            '@type' => 'WebPage',
            'url' => $this->_post->url
        );

        if ($this->_post->sq->og_media <> '') {
            $markup['thumbnailUrl'] = $this->_post->sq->og_media;
        }
        if (isset($this->_post->post_date)) {
            $markup['datePublished'] = date('c', strtotime($this->_post->post_date));
        }
        if (isset($this->_post->post_modified)) {
            $markup['dateModified'] = date('c', strtotime($this->_post->post_modified));
        }

        if ($this->_post->sq->og_media <> '') {
            $markup['image'] = array(
                "@type" => "ImageObject",
                "url" => $this->_post->sq->og_media,
                "height" => 500,
                "width" => 700,
            );
        } else {
            $this->_setMedia($markup);
        }

        $markup['author'] = $this->getAuthorMarkup();

        if ($publisher = $this->getPublisherMarkup('Organization')) {
            $markup['publisher'] = $publisher;
        }

        if ($this->_post->sq->keywords <> '') {
            $markup['keywords'] = $this->_post->sq->keywords;
        }

        return apply_filters('sq_jsonld_article_markup', $markup, $this->_post, $post_type);
    }

    /**
     * Get Question Markup
     *
     * @return mixed
     */
    public function getQAMarkup() {
        $type = 'QAPage';

        $markup = array();
        $markup['@type'] = $type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($type);
        $markup['url'] = $this->_post->url;

        if (isset($this->_post->sq->title) && isset($this->_post->sq->description)) {
            $markup['mainEntity'][] = array(
                "@type" => "Question",
                "name" => $this->cleanText($this->_post->sq->title),
                "text" => $this->cleanText($this->_post->sq->title),
                "answerCount" => 1,
                "upvoteCount" => 0,
                "dateCreated" => date('c', strtotime($this->_post->post_date)),
                "author" => $this->getAuthorMarkup(),
                "acceptedAnswer" => array(
                    "@type" => "Answer",
                    "text" => $this->cleanText($this->_post->sq->description),
                    "upvoteCount" => 0,
                    "url" => $this->_post->url,
                    "author" => $this->getAuthorMarkup(),
                    "dateCreated" => date('c', strtotime($this->_post->post_date)),
                )
            );
        }

        return apply_filters('sq_jsonld_' . strtolower($type) . '_markup', $markup, $this->_post, $type);
    }

    /**
     * Get Question Markup
     *
     * @return mixed
     */
    public function getQuestionMarkup() {
        $type = 'FAQPage';

        $markup = array();
        $markup['@type'] = $type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($type);
        $markup['url'] = $this->_post->url;

        if (isset($this->_post->sq->title) && isset($this->_post->sq->description)) {
            $markup['mainEntity'][] = array(
                "@type" => "Question",
                "name" => $this->cleanText($this->truncate($this->_post->sq->title, 0, $this->_post->sq->jsonld_title_maxlength)),
                "acceptedAnswer" => array(
                    "@type" => "Answer",
                    "text" => $this->cleanText($this->truncate($this->_post->sq->description, 0, $this->_post->sq->jsonld_description_maxlength)),
                )
            );
        }

        return apply_filters('sq_jsonld_' . strtolower($type) . '_markup', $markup, $this->_post, $type);
    }

    /**
     * Get Movie Markup
     * @return mixed
     */
    public function getMovieMarkup() {
        $type = 'Movie';

        $markup = array();
        $markup['@type'] = $type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($type);
        $markup['url'] = $this->_post->url;

        if (isset($this->_post->sq->title)) {
            $markup['name'] = $this->cleanText($this->truncate($this->_post->sq->title, 0, $this->_post->sq->jsonld_title_maxlength));
        }

        if (isset($this->_post->sq->description)) {
            $markup['description'] = $this->cleanText($this->truncate($this->_post->sq->description, 0, $this->_post->sq->jsonld_description_maxlength));
        }

        if (isset($this->_post->post_date)) {
            $markup['dateCreated'] = date('c', strtotime($this->_post->post_date));
        }

        if ($this->_post->sq->og_media <> '') {
            $markup['image'] = array(
                "@type" => "ImageObject",
                "url" => $this->_post->sq->og_media,
                "height" => 500,
                "width" => 700,
            );
        } else {
            $this->_setMedia($markup);
        }

        $markup['director'] = $this->getAuthorMarkup();
        $markup['publisher'] = $this->getPublisherMarkup('Organization');

        return apply_filters('sq_jsonld_' . strtolower($type) . '_markup', $markup, $this->_post, $type);
    }

    /**
     * Get Recipe Markup
     * @return mixed
     */
    public function getRecipeMarkup() {
        $type = 'Recipe';

        $markup = array();
        $markup['@type'] = $type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($type);
        $markup['url'] = $this->_post->url;

        if (isset($this->_post->sq->title)) {
            $markup['name'] = $this->cleanText($this->truncate($this->_post->sq->title, 0, $this->_post->sq->jsonld_title_maxlength));
        }

        if (isset($this->_post->sq->description)) {
            $markup['description'] = $this->cleanText($this->truncate($this->_post->sq->description, 0, $this->_post->sq->jsonld_description_maxlength));
        }

        if (isset($this->_post->post_date)) {
            $markup['datePublished'] = date('c', strtotime($this->_post->post_date));
        }

        if ($this->_post->sq->og_media <> '') {
            $markup['image'] = array(
                "@type" => "ImageObject",
                "url" => $this->_post->sq->og_media,
                "height" => 500,
                "width" => 700,
            );
        } else {
            $this->_setMedia($markup);
        }

        $markup['author'] = $this->getAuthorMarkup();
        $markup['publisher'] = $this->getPublisherMarkup('Organization');

        if ($this->_post->sq->keywords <> '') {
            $markup['keywords'] = $this->_post->sq->keywords;
        }

        return apply_filters('sq_jsonld_' . strtolower($type) . '_markup', $markup, $this->_post, $type);
    }

    /**
     * Get Review Markup
     *
     * @param array $reviewObject
     * @return mixed
     */
    public function getReviewMarkup($reviewObject = false) {
        $type = 'Review';

        $markup = array();
        $markup['@type'] = $type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($type);
        $markup['url'] = $this->_post->url;

        if (isset($this->_post->sq->title)) {
            $markup['name'] = $this->cleanText($this->truncate($this->_post->sq->title, 0, $this->_post->sq->jsonld_title_maxlength));
        }

        if (isset($this->_post->sq->description)) {
            $markup['reviewBody'] = $this->cleanText($this->truncate($this->_post->sq->description, 0, $this->_post->sq->jsonld_description_maxlength));
        }

        $markup['author'] = $this->getAuthorMarkup();
        $markup['publisher'] = $this->getPublisherMarkup('Organization');

        if (!$reviewObject) {
            $reviewObject = $this->getPublisherMarkup('Organization');
        }

        $markup['itemReviewed'] = $reviewObject;

        $markup['reviewRating'] = array(
            '@type' => 'Rating',
            'ratingValue' => 5,
        );

        return apply_filters('sq_jsonld_' . strtolower($type) . '_markup', $markup, $this->_post, $type);
    }

    /**
     * Get Local Business Markup
     *
     * @param string $type
     * @return mixed
     */
    public function getLocalBusinessMarkup($type = 'Store') {
        $organization = $this->getPublisherMarkup('Organization');

        $markup = array();
        $markup['@type'] = $type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($type);
        $markup['url'] = $this->_post->url;


        if (isset($organization['name']) && $organization['name']) {
            $markup['name'] = $organization['name'];
        } elseif (isset($this->_post->sq->title)) {
            $markup['name'] = $this->_post->sq->title;
            $markup['name'] = str_replace('"', '\"', $markup['name']);
        }

        if (isset($organization['logo']) && !empty($organization['logo'])) {
            $markup['image'] = $organization['logo'];
        }
        if (isset($organization['address']) && !empty($organization['address'])) {
            $markup['address'] = $organization['address'];
        }
        if (isset($organization['place']['geo']) && !empty($organization['place']['geo'])) {
            $markup['geo'] = $organization['place']['geo'];
        }
        if (isset($organization['contactPoint']['telephone']) && !empty($organization['contactPoint']['telephone'])) {
            $markup['telephone'] = $organization['contactPoint']['telephone'];
        }

        $markup['priceRange'] = "$";
        $markup['menu'] = $this->_post->url;

        //Set default local SEO data
        $jsonldLocal = SQ_Classes_Helpers_Tools::getOption('sq_jsonld_local');
        if (!empty($jsonldLocal)) {
            foreach ($jsonldLocal as $key => $value) {

                if (is_array($value)) {
                    $value = @array_filter($value);

                    if (empty($value)) continue;

                    foreach ($value as $index => $value1) {
                        if (is_array($value1)) {
                            $value1 = @array_filter($value1);
                            if ($key == 'openingHoursSpecification') {
                                if (count($value1) < 3) {
                                    unset($value[$index]);
                                }
                            } elseif (count($value1) < 2) {
                                unset($value[$index]);
                            }

                        }
                    }

                    if (count($value) == 1) {
                        continue;
                    }

                    if (current(array_keys($value)) == 0) {
                        $value = array_values($value);
                    }
                }

                if ($value) {
                    $markup[$key] = $value;
                }
            }
        }

        return apply_filters('sq_jsonld_' . strtolower($type) . '_markup', $markup, $this->_post, $type);
    }

    /**
     * Get the markup for the website Schema
     *
     * @return mixed
     */
    public function getWebsiteMarkup() {
        $jsonld = SQ_Classes_Helpers_Tools::getOption('sq_jsonld');
        $jsonld_type = SQ_Classes_Helpers_Tools::getOption('sq_jsonld_type');
        $type = 'WebSite';

        $markup = array();
        $markup['@type'] = $type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($type);
        $markup['url'] = $this->_post->url;

        if ($jsonld[$jsonld_type]['name']) {
            $markup['name'] = $jsonld[$jsonld_type]['name'];
        } elseif (isset($this->_post->sq->title)) {
            $markup['name'] = $this->cleanText($this->truncate($this->_post->sq->title, 0, $this->_post->sq->jsonld_title_maxlength));
        }

        if (isset($this->_post->sq->description)) {
            $markup['headline'] = $this->cleanText($this->truncate($this->_post->sq->description, 0, $this->_post->sq->jsonld_description_maxlength));
        }

        $markup['mainEntityOfPage'] = array(
            '@type' => 'WebPage',
            'url' => $this->_post->url
        );

        if ($this->_post->sq->og_media <> '') {
            $markup['thumbnailUrl'] = $this->_post->sq->og_media;
        }
        if (isset($this->_post->post_date)) {
            $markup['datePublished'] = date('c', strtotime($this->_post->post_date));
        }
        if (isset($this->_post->post_modified)) {
            $markup['dateModified'] = date('c', strtotime($this->_post->post_modified));
        }

        if ($this->_post->sq->og_media <> '') {
            $markup['image'] = array(
                "@type" => "ImageObject",
                "url" => $this->_post->sq->og_media,
                "height" => 500,
                "width" => 700,
            );
        } else {
            $this->_setMedia($markup);
        }

        //Show search bar for products and shops
        if ($this->_post->post_type == 'product' || $this->_post->post_type == 'shop') {
            $markup['potentialAction'] = array(
                '@type' => 'SearchAction',
                'target' => home_url('?s={search_term_string}&post_type=product'),
                'query-input' => 'required name=search_term_string',
            );
        } else {
            $markup['potentialAction'] = array(
                '@type' => 'SearchAction',
                'target' => home_url('?s={search_term_string}'),
                'query-input' => 'required name=search_term_string',
            );
        }

        if ($author = $this->getAuthorMarkup()) {
            $markup['author'] = $author;
        }

        if ($publisher = $this->getPublisherMarkup($jsonld_type)) {
            $markup['publisher'] = $publisher;
        }

        if ($this->_post->sq->keywords <> '') {
            $markup['keywords'] = $this->_post->sq->keywords;
        }


        return apply_filters('sq_jsonld_' . strtolower($type) . '_markup', $markup, $this->_post, $type);
    }

    /**
     * Get the markup for the Author Schema
     */
    public function getAuthorMarkup() {
        $markup = array();

        if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_global_person')) {
            $markup = $this->getPublisherMarkup('Person');
        } else {
            $user_url = $this->getAuthor('user_url');
            $display_name = $this->getAuthor('display_name');

            if ($user_url <> '' && $display_name <> '') {
                $markup = array(
                    "@type" => "Person",
                    "@id" => $user_url . "#person",
                    "url" => $user_url,
                    "name" => $display_name,
                );
            }
        }

        return apply_filters('sq_jsonld_author_markup', $markup, $this->_post, 'author', $this->_author);

    }

    /**
     * Get the publisher markup
     * @param $jsonld_type
     * @return array|bool
     */
    public function getPublisherMarkup($jsonld_type) {
        $jsonld = SQ_Classes_Helpers_Tools::getOption('sq_jsonld');

        $markup['@type'] = $jsonld_type;
        $markup['@id'] = $this->_post->url . '#' . strtolower($jsonld_type);
        $markup['url'] = $this->_post->url;

        if (isset($jsonld[$jsonld_type])) {
            $markup = array(
                "@type" => $jsonld_type,
                "@id" => $this->_post->url . "#$jsonld_type",
                "url" => $this->_post->url,
                "name" => ($jsonld[$jsonld_type]['name'] ? $jsonld[$jsonld_type]['name'] : get_bloginfo('title')),
            );

            foreach ($jsonld[$jsonld_type] as $key => $value) {

                if (is_array($value)) {
                    $value = @array_filter($value);

                    if (empty($value)) continue;

                    foreach ($value as $key1 => $value1) {
                        if (is_array($value1)) {
                            $value1 = @array_filter($value1);
                            if (count($value1) == 1) unset($value[$key1]);
                        }
                    }

                    if (count($value) == 1) {
                        continue;
                    }

                    $value['@id'] = $this->_post->url . "#" . strtolower($key);
                }

                if ($value) {

                    if ($key == 'logo' && $value['url'] <> '') {
                        if (defined('WP_CONTENT_DIR') && $imagepath = str_replace(content_url(), WP_CONTENT_DIR, $value['url'])) {
                            if (file_exists($imagepath)) {
                                list($width, $height) = @getimagesize($imagepath);
                                $value['width'] = $width;
                                $value['height'] = $height;
                            }
                        }

                        if ($jsonld[$jsonld_type]['name']) {
                            $value['caption'] = $jsonld[$jsonld_type]['name'];
                        }
                    }

                    $markup[$key] = $value;

                }
            }

            $socials = SQ_Classes_Helpers_Tools::getOption('socials');

            //Load the social media
            $jsonld_socials = array();
            if (isset($socials['facebook_site']) && $socials['facebook_site'] <> '') {
                $jsonld_socials[] = $socials['facebook_site'];
            }
            if (isset($socials['twitter_site']) && $socials['twitter_site'] <> '') {
                $jsonld_socials[] = $socials['twitter_site'];
            }
            if (isset($socials['instagram_url']) && $socials['instagram_url'] <> '') {
                $jsonld_socials[] = $socials['instagram_url'];
            }
            if (isset($socials['linkedin_url']) && $socials['linkedin_url'] <> '') {
                $jsonld_socials[] = $socials['linkedin_url'];
            }
            if (isset($socials['pinterest_url']) && $socials['pinterest_url'] <> '') {
                $jsonld_socials[] = $socials['pinterest_url'];
            }
            if (isset($socials['youtube_url']) && $socials['youtube_url'] <> '') {
                $jsonld_socials[] = $socials['youtube_url'];
            }

            if (!empty($jsonld_socials)) {
                $markup['sameAs'] = $jsonld_socials;
            }
        }

        return apply_filters('sq_jsonld_publisher_markup', $markup, $this->_post, $jsonld_type);
    }

    /**
     * Generates BreadcrumbList structured data.
     */
    public function getBreadcrumbsMarkup() {
        $root = $crumbs = $lists = $markup = array();

        //show the breadcrumbs
        if ($this->_post->post_type <> 'home') {
            ///////////////////////////// Home Page
            $post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setHomePage();

            if ($post->ID == 0 || $this->_post->ID <> $post->ID) {
                $root[] = array(
                    ($post->sq->title <> '' ? $post->sq->title : $post->post_title),
                    $post->url,
                );
            }

            if ($this->_post->post_type == 'category' && isset($this->_post->term_id) && isset($this->_post->taxonomy)) {
                $parents = get_ancestors($this->_post->term_id, $this->_post->taxonomy);
                if (!empty($parents)) {
                    $parents = array_reverse($parents);

                    foreach ($parents as $parent) {
                        $parent = get_term($parent);
                        if (!is_wp_error($parent)) {
                            $crumbs[] = array(
                                $parent->name,
                                get_term_link($parent->term_id, $this->_post->taxonomy),
                            );
                        }
                    }

                    $lists[] = $crumbs;
                }
            } elseif ($this->_post->post_type == 'product') {
                if (class_exists('WC_Product')) {
                    $product = new WC_Product($this->_post->ID);

                    //Get all categories
                    if ($product instanceof WC_Product) {
                        $categories = $product->get_category_ids();
                        $taxonomy = 'product_cat';
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                $crumbs = [];
                                $parents = get_ancestors($category, $taxonomy);

                                if (!empty($parents)) {

                                    foreach ($parents as $parent) {
                                        $parent = get_term($parent);
                                        if (!is_wp_error($parent)) {
                                            $crumbs[] = array(
                                                $parent->name,
                                                get_term_link($parent->term_id, $taxonomy),
                                            );
                                        }
                                    }

                                    $category = get_term($category, $taxonomy);
                                    if (!is_wp_error($category)) {
                                        $crumbs[] = array(
                                            $category->name,
                                            get_term_link($category->term_id, $taxonomy),
                                        );
                                    }

                                    $lists[] = $crumbs;
                                } else {

                                    $category = get_term($category, $taxonomy);
                                    if (!is_wp_error($category)) {
                                        $crumbs[] = array(
                                            $category->name,
                                            get_term_link($category->term_id, $taxonomy),
                                        );
                                    }

                                    $lists[] = $crumbs;
                                }
                            }
                        }
                    }
                }
            } else {
                /////////////////////// Parent Categories
                $categories = get_the_category($this->_post->ID);
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $crumbs = [];
                        $parents = get_ancestors($category->term_id, $category->taxonomy);

                        if (!empty($parents)) {
                            $parents = array_reverse($parents);

                            foreach ($parents as $parent) {
                                $parent = get_term($parent);
                                if (!is_wp_error($parent)) {
                                    $crumbs[] = array(
                                        $parent->name,
                                        get_term_link($parent->term_id, $category->taxonomy),
                                    );
                                }
                            }

                            if (!is_wp_error(get_term_link($category->term_id, $category->taxonomy))) {
                                $crumbs[] = array(
                                    $category->name,
                                    get_term_link($category->term_id, $category->taxonomy),
                                );
                            }

                            $lists[] = $crumbs;
                        } elseif (!is_wp_error(get_term_link($category->term_id, $category->taxonomy))) {
                            $crumbs[] = array(
                                $category->name,
                                get_term_link($category->term_id, $category->taxonomy),
                            );

                            $lists[] = $crumbs;
                        }
                    }
                }
            }


            if (!empty($crumbs)) {
                $markup['@type'] = 'BreadcrumbList';
                $markup['@id'] = $this->_post->url . '#' . 'breadcrumblist';
                $markup['itemListElement'] = array();

                foreach ($lists as $list) {
                    //merge and reset the keys
                    $list = array_merge($root, $list);
                    $list = array_values($list);

                    ////////////////////// Current post
                    $list[] = array(
                        ($this->_post->sq->title <> '' ? $this->_post->sq->title : $this->_post->post_title),
                        $this->_post->url,
                    );

                    $itemListElement = array();
                    foreach ($list as $key => $crumb) {
                        $itemListElement[$key] = array(
                            '@type' => 'ListItem',
                            'position' => $key + 1,
                            'item' => array(
                                '@id' => $crumb[1],
                                'name' => $this->cleanText($crumb[0])
                            ),
                        );
                    }

                    $markup['itemListElement'][] = $itemListElement;
                }
            }
        }

        return apply_filters('sq_jsonld_breadcrumbs_markup', $markup, $this->_post, 'breadcrumbs');

    }

    /** Set the Image from Feature image
     * @param $markup
     */
    public function _setMedia(&$markup) {
        $images = $this->getPostImages();
        if (!empty($images)) {
            $image = current($images);
            if (isset($image['src'])) {
                $markup['image'] = array(
                    "@type" => "ImageObject",
                    "url" => $image['src'],
                    "height" => 500,
                    "width" => 700,
                );
                if (isset($image['width'])) {
                    $markup['image']["width"] = $image['width'];
                }
                if (isset($image['height'])) {
                    $markup['image']["height"] = $image['height'];
                }
            }
        }
    }

    /**
     * Generates Product structured data.
     *
     */
    public function getWoocommerceProductMarkup() {
        global $product;

        if (!class_exists('WC_Product')) {
            return;
        }

        try {
            $product = new WC_Product($this->_post->ID);

            if (!$product instanceof WC_Product) {
                return;
            }

            if (!method_exists($product, 'get_id')) {
                return;
            }

            $shop_name = get_bloginfo('name');
            $shop_url = home_url();
            $currency = get_woocommerce_currency();

            $sq_woocommerce = get_post_meta($this->_post->ID, '_sq_woocommerce', true);
            $wc_fields = array('mpn' => 'mpn', 'gtin' => 'gtin', 'ean' => 'gtin13', 'upc' => 'gtin12', 'isbn' => 'isbn');

            $markup = array();
            $markup['@type'] = 'Product';
            $markup['url'] = get_permalink($product->get_id());
            $markup['@id'] = $markup['url'] . '#' . 'product';

            if (method_exists($product, 'get_name')) {
                $markup['name'] = $this->cleanText($product->get_name());
            } else {
                $markup['name'] = $this->cleanText($product->get_title());
            }

            if (method_exists($product, 'get_short_description')) {
                $markup['description'] = $this->cleanText(wp_strip_all_tags($product->get_short_description() ? $product->get_short_description() : $product->get_description()));
            }

            if (method_exists($product, 'get_image_id')) {
                if ($image = wp_get_attachment_url($product->get_image_id())) {
                    $markup['image'] = $image;
                }
            }

            //By default, set the price available for 1 year
            $price_valid_until = date('Y-m-d', strtotime('+12 Month'));
            if (method_exists($product, 'get_date_on_sale_to') && method_exists($product, 'get_date_on_sale_from')) {
                if (method_exists($product->get_date_on_sale_from(), 'getTimestamp')) {
                    if(date('Y-m-d', $product->get_date_on_sale_from()->getTimestamp()) <= gmdate('Y-m-d')){
                        if (method_exists($product->get_date_on_sale_to(), 'getTimestamp')) {
                            //Set the price available until the offer ends
                            $price_valid_until =  date('Y-m-d', $product->get_date_on_sale_to()->getTimestamp());
                        }
                    }
                }
            }

            $markup_offer = array(
                '@type' => 'Offer',
                'price' => wc_format_decimal($product->get_price(), wc_get_price_decimals()),
                'priceValidUntil' => $price_valid_until,
                'url' => get_permalink($product->get_id()),
                'priceCurrency' => $currency,
                'availability' => 'https://schema.org/' . $stock = ($product->is_in_stock() ? 'InStock' : 'OutOfStock'),
                'sku' => (method_exists($product, 'get_sku')) ? ($product->get_sku() <> '' ? $product->get_sku() : '') : '',
                'image' => (method_exists($product, 'get_image_id')) ? wp_get_attachment_url($product->get_image_id()) : '-',
                'description' => (method_exists($product, 'get_description') ? $this->cleanText($product->get_description()) : $this->cleanText($product->get_title())),
                'seller' => array(
                    '@type' => 'Organization',
                    'name' => $shop_name,
                    'url' => $shop_url,
                ),
            );



            //Get the variation prices
            if ($product->is_type('variable') && method_exists($product, 'get_variation_prices')) {
                $prices = $product->get_variation_prices();

                $markup_offer['priceSpecification'] = array(
                    'price' => wc_format_decimal($product->get_price(), wc_get_price_decimals()),
                    'minPrice' => wc_format_decimal(current($prices['price']), wc_get_price_decimals()),
                    'maxPrice' => wc_format_decimal(end($prices['price']), wc_get_price_decimals()),
                    'priceCurrency' => $currency,
                );
            }

            $markup['sku'] = (method_exists($product, 'get_sku')) ? ($product->get_sku() <> '' ? $product->get_sku() : '') : '';


            //Set default values if WooCommerce default is active
            if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_defaults')) {
                //Get all categories
                $categories = $product->get_category_ids();
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $category = get_term($category, 'product_cat');
                        if (!is_wp_error($category)) {
                            $markup['brand'] = array(
                                '@type' => 'Brand',
                                'name' => $category->name,
                            );
                        }
                    }
                }

                if ($markup['sku'] == '') $markup['sku'] = '-';
                if ($markup_offer['sku'] == '') $markup_offer['sku'] = '-';
                $markup['mpn'] = '-';
                $markup_offer['mpn'] = '-';
            }

            //Set custom values if WooCommerce custom is active
            if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_custom')) {

                foreach ($wc_fields as $field => $jsonkey) {
                    if (isset($sq_woocommerce[$field]) && $sq_woocommerce[$field] <> '') {
                        $markup[$jsonkey] = $sq_woocommerce[$field];
                        $markup_offer[$jsonkey] = $sq_woocommerce[$field];
                    }
                }

                if (isset($sq_woocommerce['brand']) && $sq_woocommerce['brand'] <> '') {
                    $markup['brand'] = array(
                        '@type' => 'Brand',
                        'name' => $sq_woocommerce['brand'],
                    );
                }
            }

            if (function_exists('wc_prices_include_tax')) {
                $markup_offer['priceSpecification']['valueAddedTaxIncluded'] = wc_prices_include_tax() ? 'true' : 'false';
            }

            //Set the offer
            $markup['offers'] = $markup_offer;

            if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_defaults')) {
                //If rating and reviews
                if (method_exists($product, 'get_rating_count') && $product->get_rating_count()) {

                    //Only if it's set in Squirrly to remove duplicates
                    //otherwise let Woocommerce show the reviews
                    if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_clearcode')) {
                        $markup['aggregateRating'] = array(
                            '@type' => 'AggregateRating',
                            'ratingValue' => $product->get_average_rating(),
                            'ratingCount' => $product->get_rating_count(),
                            'reviewCount' => $product->get_review_count(),
                        );

                        //Set the reviews
                        $markup['review'] = $this->getProductReviewMarkup($product);
                    }

                } else { //add default datas?

                    //Add data if no reviews for Google validation
                    $markup['aggregateRating'] = array(
                        '@type' => 'AggregateRating',
                        'ratingValue' => 5,
                        'ratingCount' => 1,
                        'reviewCount' => 1,
                    );

                    $markup['review'][] = array(
                        '@type' => 'Review',
                        'reviewRating' => array(
                            '@type' => 'Rating',
                            'ratingValue' => 5,
                        ),
                        'author' => array(
                            '@type' => 'Person',
                            'name' => '',
                        ),
                        'reviewBody' => '',
                        'datePublished' => (method_exists($product, 'get_date_created') && method_exists($product->get_date_created(), 'getTimestamp')) ? date('Y-m-d', $product->get_date_created()->getTimestamp()) : '',
                    );
                }
            }

            $otherbrands = array();

            //compatible with Perfect Woocommerce Brands
            if (SQ_Classes_Helpers_Tools::isPluginInstalled('perfect-woocommerce-brands/perfect-woocommerce-brands.php')) {
                $brands = wp_get_post_terms($product->get_id(), 'pwb-brand');
                foreach ($brands as $brand) {
                    $otherbrands[] = $brand->name;
                }
            }

            //compatible with YITH WooCommerce Brands Add-on
            if (SQ_Classes_Helpers_Tools::isPluginInstalled('yith-woocommerce-brands-add-on/init.php')) {
                $brands = wp_get_post_terms($product->get_id(), 'yith_product_brand');
                foreach ($brands as $brand) {
                    $otherbrands[] = $brand->name;
                }
            }

            if (!empty($otherbrands)) {
                $markup['brand'] = $otherbrands;
            }

            return $markup;

        } catch (Exception $e) {

        }
    }

    /**
     * Generates Review structured data.
     *
     * @param $product
     * @return array | false
     */
    public function getProductReviewMarkup($product) {
        global $comment;
        $markup = array();

        if (!method_exists($product, 'get_id')) {
            return false;
        }

        if (function_exists('wc_review_ratings_enabled') && wc_review_ratings_enabled() &&
            function_exists('get_comments') && function_exists('get_comment_meta')) {

            $comments = get_comments(
                array(
                    'number' => 10,
                    'post_id' => $product->get_id(),
                    'status' => 'approve',
                    'post_status' => 'publish',
                    'post_type' => 'product',
                    'parent' => 0,
                    'meta_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
                        array(
                            'key' => 'rating',
                            'type' => 'NUMERIC',
                            'compare' => '>',
                            'value' => 0,
                        ),
                    ),
                )
            );

            if ($comments) {
                foreach ($comments as $comment) {
                    $markup[] = array(
                        '@type' => 'Review',
                        'reviewRating' => array(
                            '@type' => 'Rating',
                            'bestRating' => '5',
                            'ratingValue' => get_comment_meta($comment->comment_ID, 'rating', true),
                            'worstRating' => '1',
                        ),
                        'author' => array(
                            '@type' => 'Person',
                            'name' => get_comment_author($comment),
                        ),
                        'reviewBody' => get_comment_text($comment),
                        'datePublished' => get_comment_date('c', $comment),
                    );

                }
            }
        }

        return $markup;

    }

}
