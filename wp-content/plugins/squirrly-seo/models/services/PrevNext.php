<?php

class SQ_Models_Services_PrevNext extends SQ_Models_Abstract_Seo {

    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if(!$this->_post->sq->do_metas){
                add_filter('sq_prevnext', array($this, 'returnFalse'));
                return;
            }

            add_filter('sq_prevnext', array($this, 'generateMeta'));
            add_filter('sq_prevnext', array($this, 'packMeta'), 99);
        } else {
            add_filter('sq_prevnext', array($this, 'returnFalse'));
        }

    }

    public function generateMeta($meta = array()) {
        global $paged;

        if (!$this->isHomePage()) {
            if (get_previous_posts_link()) {
                $meta['prev'] = get_pagenum_link($paged - 1);
            }
            if (get_next_posts_link()) {
                $meta['next'] = get_pagenum_link($paged + 1);
            }
        }

        return $meta;
    }

    public function packMeta($metas = array()) {
        if (!empty($metas)) {
            foreach ($metas as $key => &$value) {
                $value = '<link rel="' . $key . '" href="' . $value . '" />';
            }
            return "\n" . join("\n", array_values($metas));
        }

        return false;
    }

}