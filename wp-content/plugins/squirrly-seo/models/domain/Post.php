<?php

class SQ_Models_Domain_Post extends SQ_Models_Abstract_Domain {

    protected $_ID;
    protected $_term_id;
    protected $_term_taxonomy_id;
    protected $_taxonomy;
    protected $_post_type;
    protected $_url; //set the canonical link for this post type
    protected $_hash;
    protected $_sq;
    protected $_sq_adm;
    protected $_socials;
    //
    protected $_patterns;
    //
    protected $_post_name;
    protected $_guid;
    protected $_post_author;
    protected $_post_date;
    protected $_post_title;
    protected $_post_excerpt;
    protected $_post_attachment;
    protected $_post_content;
    protected $_post_status;
    protected $_post_password;

    protected $_post_parent;
    protected $_post_created;
    protected $_post_modified;
    protected $_category;
    protected $_category_description;
    protected $_noindex;
    /** @var int Snippet Score */
    protected $_tasks = 0;
    protected $_tasks_completed = 0;

    protected $_debug;

    public function getSocials() {
        if (!isset($this->_socials)) {
            $this->_socials = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('socials')));
        }

        return $this->_socials;
    }

    public function getSq() {
        if (!isset($this->_sq) && isset($this->_post_type) && $this->_post_type <> '') {
            //Get the saved sq settings
            $this->_sq = SQ_Classes_ObjController::getClass('SQ_Models_Qss')->getSqSeo($this->_hash);
            if (!empty($this->_sq)) {
                $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
                if (!empty($patterns) && $sq_array = $this->_sq->toArray()) {

                    if (!empty($sq_array)) {
                        foreach ($sq_array as $key => $value) {

                            //if the sq value is empty or allows overwrites
                            if (in_array($key, array('sep')) || empty($value)) {

                                //If there are no patterns and no custom field, get the post values
                                if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') ||
                                    (isset($patterns[$this->_post_type]['do_pattern']) && !$patterns[$this->_post_type]['do_pattern'])) {

                                    switch ($key) {
                                        case 'title':
                                            $this->_sq->title = preg_replace('/{{[^\}]+}}/', '', $this->_sq->title);
                                            continue 2;
                                        case 'description':
                                            $this->_sq->description = preg_replace('/{{[^\}]+}}/', '', $this->_sq->description);
                                            continue 2;
                                    }
                                }

                                //check if there are patterns for this post type in automation
                                if (isset($patterns[$this->_post_type])) {
                                    if (isset($patterns[$this->_post_type][$key])) {
                                        $this->_sq->$key = $patterns[$this->_post_type][$key];
                                    }
                                } else {
                                    //get the default automation
                                    if (isset($patterns['custom'][$key])) {
                                        $this->_sq->$key = $patterns['custom'][$key];
                                    }
                                }
                            }

                        }
                    }

                    //Set the automation signals
                    foreach ($this->_sq->getAutomation() as $key => $value) {
                        if (isset($patterns[$this->_post_type])) {
                            if (isset($patterns[$this->_post_type][$key])) {
                                $this->_sq->$key = $patterns[$this->_post_type][$key];
                            }
                        } else {
                            if (isset($patterns['custom'][$key])) {
                                $this->_sq->$key = $patterns['custom'][$key];
                            }
                        }
                    }
                }
            }

        }
        return $this->_sq;
    }

    public function getSq_adm() {

        if (!isset($this->_sq_adm) && isset($this->_post_type) && $this->_post_type <> '') {
            if (is_user_logged_in()) {
                $this->_sq_adm = SQ_Classes_ObjController::getClass('SQ_Models_Qss')->getSqSeo($this->_hash);

                if (!empty($this->_sq_adm)) {
                    $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');

                    if (!empty($patterns) && $sq_array = $this->_sq_adm->toArray()) {

                        if (!empty($sq_array)) {
                            foreach ($sq_array as $key => $value) {
                                if (empty($value)) {
                                    if (SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern')) {
                                        if (isset($patterns[$this->_post_type])) {
                                            $this->_sq_adm->patterns = json_decode(wp_json_encode($patterns[$this->_post_type]));
                                        } else {
                                            $this->_sq_adm->patterns = json_decode(wp_json_encode($patterns['custom']));
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
            }
        }
        return $this->_sq_adm;
    }

    public function getID() {
        return $this->_ID;
    }

    /**
     * @return array
     */
    public function importSEO() {
        $import = array();

        if (isset($this->_ID) && (int)$this->_ID > 0) {
            $platforms = apply_filters('sq_importList', false);

            if (!empty($platforms)) {
                foreach ($platforms as $path => &$metas) {
                    if ($metas = SQ_Classes_ObjController::getClass('SQ_Models_Admin')->getDBSeo($this->_ID, $metas)) {
                        if (strpos($metas, '%%') !== false) {
                            $metas = preg_replace('/%%([^\%]+)%%/', '{{$1}}', $metas);
                        }
                        $import[SQ_Classes_ObjController::getClass('SQ_Models_Admin')->getName($path)] = $metas;
                    }
                }
            }

        }

        return $import;
    }

    public function getPost_attachment() {
        if ($this->post_type <> 'profile') { //don't load thunbnails
            if (!isset($this->_post_attachment) && isset($this->_ID) && (int)$this->_ID > 0) {
                if (has_post_thumbnail($this->_ID)) {
                    $attachment = get_post(get_post_thumbnail_id($this->_ID));
                    if (isset($attachment->ID)) {
                        $url = wp_get_attachment_image_src($attachment->ID, 'full');
                        $this->_post_attachment = esc_url($url[0]);
                    }
                }
            }
        }
        return $this->_post_attachment;
    }

    /**
     * Increase completed tasks
     */
    public function setCompletedTasts($tasks) {
        $this->_tasks_completed = $tasks;
    }

    /**
     * Set the total number of tasks
     * @param $tasks
     */
    public function setTotalTasts($tasks) {
        $this->_tasks = $tasks;
    }

}
