<?php

class SQ_Models_Services_Title extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if (!$this->_post->sq->do_metas) {
                add_filter('sq_title', array($this, 'returnFalse'));
                return;
            }

            add_filter('sq_title', array($this, 'generateTitle'));
            add_filter('sq_title', array($this, 'clearTitle'), 98);
            add_filter('sq_title', array($this, 'packTitle'), 99);
        } else {
            add_filter('sq_title', array($this, 'returnFalse'));
        }

    }

    public function generateTitle($title = '') {
        if ($this->_post->sq->title <> '') {
            $title = $this->_post->sq->title;
        } else {
            $title = $this->_post->post_title = get_the_title();
        }

        return $title ;
    }

    public function packTitle($title = '') {
        if ($title <> '') {
            return sprintf("<title>%s</title>", $title);
        }

        return false;
    }

}