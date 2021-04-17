<?php

class SQ_Models_Services_Keywords extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if(!$this->_post->sq->do_metas){
                add_filter('sq_description', array($this, 'returnFalse'));
                return;
            }

            add_filter('sq_keywords', array($this, 'generateKeywords'));
            add_filter('sq_keywords', array($this, 'generateTags'),20);
            add_filter('sq_keywords', array($this, 'clearKeywords'), 98);
            add_filter('sq_keywords', array($this, 'packKeywords'), 99);
        } else {
            add_filter('sq_keywords', array($this, 'returnFalse'));
        }
    }

    public function generateKeywords($keywords = '') {

        if (($this->_post->sq->keywords <> -1) && $this->_post->sq->keywords <> '') {
            $keywords = $this->_post->sq->keywords;
        }

        return $keywords;
    }

    public function generateTags($keywords = '') {

        if (SQ_Classes_Helpers_Tools::getOption('sq_keywordtag')) {

            $posttags = get_the_tags($this->_post->post_id);
            if (!empty($posttags)) {
                foreach ($posttags as $tag) {
                    $tags[] = $tag->name;
                }
                $keywords .= ($keywords <> '' ? ',' : '') . join(',', $tags);
            }
        }

        return $keywords;
    }

    public function packKeywords($keywords = '') {
        if ($keywords <> '') {

            $array_keywords = preg_split('/,/', $keywords);
            if (!empty($array_keywords)) {
                $array_keywords = array_unique($array_keywords);
                $keywords = join(',', $array_keywords);
            }

            return sprintf("<meta name=\"keywords\" content=\"%s\" />", $keywords);
        }
        return '';
    }
}