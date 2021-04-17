<?php

class SQ_Models_Services_TwitterCard extends SQ_Models_Abstract_Seo {

    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if (!$this->_post->sq->do_twc) {
                add_filter('sq_twitter_card', array($this, 'returnFalse'));
                return;
            }

            add_filter('sq_twitter_card', array($this, 'generateTwitterCard'), 9);
            add_filter('sq_twitter_card', array($this, 'generateTwitterCardAuthor'), 10);
            add_filter('sq_twitter_card', array($this, 'packTwitterCard'), 99);
        } else {
            add_filter('sq_twitter_card', array($this, 'returnFalse'));
        }

    }

    public function generateTwitterCard($tw = array()) {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) {
            if ($this->_post->url <> '') {
                $tw['twitter:url'] = urldecode(esc_url($this->_post->url));
            }

            if ($this->_post->sq->tw_title <> '') {
                $tw['twitter:title'] = SQ_Classes_Helpers_Sanitize::clearTitle($this->_post->sq->tw_title);
            } else {
                $tw['twitter:title'] = SQ_Classes_Helpers_Sanitize::clearTitle($this->_post->sq->title);
                if ($tw['twitter:title'] <> '' && strlen($tw['twitter:title']) > $this->_post->sq->tw_title_maxlength) {
                    $tw['twitter:title'] = $this->truncate($tw['twitter:title'], 10, $this->_post->sq->tw_title_maxlength);
                }
            }

            if ($this->_post->sq->tw_description <> '') {
                $tw['twitter:description'] = SQ_Classes_Helpers_Sanitize::clearDescription($this->_post->sq->tw_description);
            } else {
                $tw['twitter:description'] = SQ_Classes_Helpers_Sanitize::clearDescription($this->_post->sq->description);
                if ($tw['twitter:description'] <> '' && strlen($tw['twitter:description']) > $this->_post->sq->tw_description_maxlength) {
                    $tw['twitter:description'] = $this->truncate($tw['twitter:description'], 10, $this->_post->sq->tw_description_maxlength);
                }
            }


            if ($this->_post->sq->tw_media <> '') {
                $tw['twitter:image'] = $this->_post->sq->tw_media;
            } else {
                $this->_setMedia($tw);
            }

            //Get the default global image for Open Graph
            if (SQ_Classes_Helpers_Tools::getOption('sq_tc_image')) {
                if (!isset($tw['twitter:image'])) {
                    $tw['twitter:image'] = SQ_Classes_Helpers_Tools::getOption('sq_tc_image');
                }
            }

            $tw['twitter:domain'] = get_bloginfo('title');
            $tw['twitter:card'] = ($this->_post->sq->tw_type <> '' ? $this->_post->sq->tw_type : $this->_post->socials->twitter_card_type);

        }

        return $tw;
    }

    /**
     * Set the twitter card author
     * @param array $tw
     * @return array
     */
    public function generateTwitterCardAuthor($tw = array()) {
        $socials = SQ_Classes_Helpers_Tools::getOption('socials');
        $account = isset($socials['twitter']) ? $socials['twitter'] : '';

        if ($account == '') {
            if (class_exists('SQ_Classes_Helpers_Tools')) {
                $account = SQ_Classes_Helpers_Sanitize::checkTwitterAccountName($socials['twitter_site']);
            }
        }

        if ($account <> '') {
            if ($socials['twitter_card_type'] == 'summary_large_image') {
                $tw['twitter:creator'] = $account;
            }
            $tw['twitter:site'] = $account;
        }
        return $tw;
    }

    protected function _setMedia(&$tw) {
        $images = $this->getPostImages();
        if (!empty($images)) {
            $image = current($images);
            if (isset($image['src'])) {
                $tw['twitter:image'] = $image['src'];
            }
        }
    }

    public function packTwitterCard($tw = array()) {
        if (!empty($tw)) {
            foreach ($tw as $key => &$value) {
                $value = '<meta property="' . $key . '" content="' . $value . '" />';
            }
            return "\n" . join("\n", array_values($tw));
        }

        return false;
    }

}