<?php

class SQ_Models_Services_Publisher extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if (!$this->_post->sq->do_og) {
                add_filter('sq_publisher', array($this, 'returnFalse'));
                return;
            }

            add_filter('sq_publisher', array($this, 'generatePublisher'));
            add_filter('sq_publisher', array($this, 'packPublisher'), 99);
        } else {
            add_filter('sq_publisher', array($this, 'returnFalse'));
        }
    }

    public function generatePublisher($publisher = array()) {
        if ($this->_post->sq->og_type == 'article') {
            if (SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) {
                if (isset($this->_post->sq->og_author) && $this->_post->sq->og_author <> '') {
                    $authors = explode(',', $this->_post->sq->og_author);
                    foreach ($authors as $author) {
                        if ($author <> '') {
                            $publisher['article:author'][] = $author;
                        }
                    }
                }

                //Fix for Pinterest Rich Snippets
                if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'Pinterest') !== false){
                    //Show the author for the current post
                    $display_name = $this->getAuthor('display_name');
                    if ($display_name <> '') {
                        $publisher['article:author'] = $display_name;
                    }
                }
            }

            if (SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook') && isset($this->_post->socials->facebook_site) && $this->_post->socials->facebook_site <> '') {
                $publisher['article:publisher'] = $this->_post->socials->facebook_site;
            }
        }

        return $publisher;
    }


    public function packPublisher($publisher = array()) {
        if (!empty($publisher)) {
            foreach ($publisher as $key => &$value) {
                if (is_array($value)) {
                    $str = '';
                    foreach ($value as $subvalue) {
                        $str .= '<meta property="' . $key . '" content="' . $subvalue . '" />' . ((count((array)$value) > 1) ? "\n" : '');
                    }
                    $value = $str;
                } else {
                    $value = '<meta property="' . $key . '" content="' . $value . '" />';
                }
            }
            return "\n" . join("\n", array_values($publisher));
        }

        return false;
    }
}