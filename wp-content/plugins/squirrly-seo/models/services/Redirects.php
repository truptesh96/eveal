<?php

class SQ_Models_Services_Redirects extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();

        //Do not load for admin backend
        if (is_admin() || is_network_admin()) {
            return;
        }

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if (isset($this->_post->sq->redirect) && isset($this->_post->sq->redirect_type)) {
                $this->_post->sq->redirect_type = (int)$this->_post->sq->redirect_type;
                if ($this->_post->sq->redirect <> '' && in_array($this->_post->sq->redirect_type, array(301, 302, 307))) {
                    switch ($this->_post->sq->redirect_type) {
                        case 301:
                            header('HTTP/1.1 301 Moved Permanently');
                            break;
                        case 302:
                            header('HTTP/1.1 302 Moved Temporarily');
                            break;
                        case 307:
                            header('HTTP/1.1 307 Moved Temporarily');
                            break;
                    }
                    header( 'X-Redirect-By: Squirrly SEO' );
                    header('Location: ' . $this->_post->sq->redirect, true, (int)$this->_post->sq->redirect_type);
                    exit();
                }
            }
        }

    }

}