<?php

class SQ_Models_Domain_AuditPage extends SQ_Models_Abstract_Domain {

    protected $_id;
    protected $_user_post_id;
    protected $_post_id;
    protected $_hash;
    protected $_permalink;
    protected $_audit;
    protected $_stats;

    protected $_incomplete = 0;
    protected $_score = 'N/A';
    protected $_indexed;
    //--
    protected $_audit_datetime;
    protected $_audit_error;
    protected $_datetime;

    protected $_wppost;

    /**
     * Get the Local Post ID
     * @return bool
     */
    public function getId() {
        if (!isset($this->_id)) {
            if ($post = $this->getWppost()) {
                $this->_id = $post->hash;
            }
        }
        return $this->_id;
    }

    public function getAudit() {
        if (!isset($this->_audit)) {
            $this->_audit = (object)array();
        }

        $this->_audit->permalink = $this->_permalink;
        return $this->_audit;
    }

    /**
     * Get the local post
     * @param $url
     * @return SQ_Models_Domain_Post|false
     */
    public function getWppost() {

        if (!isset($this->_wppost->hash)) {
            if (isset($this->hash) && $this->hash <> '') {
                if ($this->_wppost = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByHash($this->hash)) {
                    $this->_wppost->sq_adm; //call the sq to populate
                }
            }

            if (!isset($this->_wppost->ID)) {
                if (isset($this->_permalink) && $this->_permalink <> '') {
                    if ($this->_wppost = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByURL($this->_permalink)) {
                        $this->_wppost->sq_adm; //call the sq to populate
                    }
                }
            }
        } elseif (rtrim($this->_permalink, '/') == rtrim(home_url(), '/')) {
            if ($this->_wppost = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setHomePage()) {
                $this->_wppost->sq_adm; //call the sq to populate
            }
        }

        //In case the page was not found, don't show error
        SQ_Classes_Error::clearErrors();

        //All params for the hook $post_id, $term_id, $taxonomy, $post_type
        return apply_filters('sq_wppost', $this->_wppost, $this->_post_id, 0, '', '');
    }
}
