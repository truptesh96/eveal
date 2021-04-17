<?php

class SQ_Models_Services_Description extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if (!$this->_post->sq->do_metas) {
                add_filter('sq_description', array($this, 'returnFalse'));
                return;
            }

            add_filter('sq_description', array($this, 'generateDescription'));
            add_filter('sq_description', array($this, 'clearDescription'), 98);
            add_filter('sq_description', array($this, 'packDescription'), 99);
        } else {
            add_filter('sq_description', array($this, 'returnFalse'));
        }

    }

    public function generateDescription($description = '') {
        if ($this->_post->sq->description <> '') {
            $description = $this->_post->sq->description;
        }
        return $description;
    }

    public function packDescription($description) {
        if ($description <> '') {
            return sprintf("<meta name=\"description\" content=\"%s\" />", $description);
        }

        return false;
    }
}