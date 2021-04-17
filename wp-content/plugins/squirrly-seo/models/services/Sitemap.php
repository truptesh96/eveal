<?php

class SQ_Models_Services_Sitemap extends SQ_Models_Abstract_Seo {

    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            add_filter('sq_sitemap', array($this, 'generateMeta'));
            add_filter('sq_sitemap', array($this, 'packMeta'), 99);
        } else {
            add_filter('sq_sitemap', array($this, 'returnFalse'));
        }

    }

    public function generateMeta() {
        return $this->_getSitemapURL();
    }

    /**
     * Get the url for each sitemap
     * @param string $sitemap
     * @return string
     */
    protected function _getSitemapURL($sitemap = 'sitemap') {
        if (class_exists('SQ_Classes_Helpers_Tools')) {
            return SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps')->getXmlUrl($sitemap);
        }
        return false;
    }

    /**
     * @param string $meta
     * @return string|false
     */
    public function packMeta($meta = '') {
        if ($meta <> '') {
            return '<link rel="alternate" type="application/rss+xml" href="' . $meta . '" />';
        }
        return false;
    }

}