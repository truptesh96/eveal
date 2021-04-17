<?php

class SQ_Models_Services_Canonical extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if(!$this->_post->sq->do_metas){
                add_filter('sq_canonical', array($this, 'returnFalse'));
                return;
            }

            add_filter('sq_canonical', array($this, 'generateCanonical'));
            add_filter('sq_canonical', array($this, 'packCanonical'), 99);
        } else {
            add_filter('sq_canonical', array($this, 'returnFalse'));
        }
    }

    public function generateCanonical($canonical = '') {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical') && isset($this->_post->sq->canonical) && $this->_post->sq->canonical <> '') {
            $canonical = esc_url($this->_post->sq->canonical);
        }else{
            $canonical = urldecode(esc_url($this->_post->url));
        }

        return $canonical;
    }

    public function packCanonical($canonical = '') {
        if ($canonical <> '') {
            return sprintf("<link rel=\"canonical\" href=\"%s\" />", $canonical);
        }

        return false;
    }
}