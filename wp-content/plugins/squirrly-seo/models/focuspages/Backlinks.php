<?php

class SQ_Models_Focuspages_Backlinks extends SQ_Models_Abstract_Assistant {

    protected $_category = 'backlinks';

    protected $_moz_page_backlinks = false;
    protected $_majestic_page_backlinks = false;
    protected $_majestic_unique_domain = false;

    const BACKLINKS_MINVAL = 100;
    const DOMAINS_MINVAL = 30;
    const MAJESTIC_MINVAL = 100;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if (!isset($this->_audit->data->sq_analytics_moz->page_backlinks) &&
            !isset($this->_audit->data->sq_analytics_majestic->page_backlinks) &&
            !isset($this->_audit->data->sq_analytics_majestic->page_backlinks)) {
            $this->_error = true;
        }

        if (isset($this->_audit->data->sq_analytics_moz->page_backlinks)) {
            $this->_moz_page_backlinks = $this->_audit->data->sq_analytics_moz->page_backlinks;
        }
        if (isset($this->_audit->data->sq_analytics_majestic->unique_domain)) {
            $this->_majestic_unique_domain = $this->_audit->data->sq_analytics_majestic->unique_domain;
        }
        if (isset($this->_audit->data->sq_analytics_majestic->page_backlinks)) {
            $this->_majestic_page_backlinks = $this->_audit->data->sq_analytics_majestic->page_backlinks;
        }
    }

    /**
     * Customize the tasks header
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__("Current URL", _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        return $header;
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'backlinks' => array(
                'title' => sprintf(esc_html__("At Least %s MOZ BackLinks", _SQ_PLUGIN_NAME_), self::BACKLINKS_MINVAL),
                'value' => number_format($this->_moz_page_backlinks, 0, '.', ',') . ' ' . esc_html__("backlinks", _SQ_PLUGIN_NAME_),
                'penalty' => 10,
                'description' => "",
            ),
            'domains' => array(
                'title' => sprintf(esc_html__("At Least %s Referring Domains", _SQ_PLUGIN_NAME_), self::DOMAINS_MINVAL),
                'value' => number_format($this->_majestic_unique_domain, 0, '.', ',') . ' ' . esc_html__("unique domains", _SQ_PLUGIN_NAME_),
                'description' => "",
            ),
            'majestic' => array(
                'title' => sprintf(esc_html__("At Least %s Majestic SEO Links", _SQ_PLUGIN_NAME_), self::MAJESTIC_MINVAL),
                'value' => number_format($this->_majestic_page_backlinks, 0, '.', ',') . ' ' . esc_html__("backlinks", _SQ_PLUGIN_NAME_),
                'description' => "",
            ),
        );
    }

    public function getTitle($title) {

        if (!$this->_completed && !$this->_indexed) {
            foreach ($this->_tasks[$this->_category] as $task) {
                if ($task['completed'] === false) {
                    return esc_html__("Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
                }
            }
        }

        return parent::getTitle($title);
    }
    /*********************************************/

    /**
     * Check the moz found backlinks to be grather than BACKLINKS_MINVAL
     * @return bool|WP_Error
     */
    public function checkBacklinks($task) {
        if ($this->_moz_page_backlinks !== false) {
            $task['completed'] = ($this->_moz_page_backlinks >= self::BACKLINKS_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * Check the makestic referral domains to be greater than DOMAINS_MINVAL
     * @return bool|WP_Error
     */
    public function checkDomains($task) {
        if ($this->_majestic_unique_domain !== false) {
            $task['completed'] = ($this->_majestic_unique_domain >= self::DOMAINS_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * Check the makestic found links to be grather than MAJESTIC_MINVAL
     * @return bool|WP_Error
     */
    public function checkMajestic($task) {
        if ($this->_majestic_page_backlinks !== false) {
            $task['completed'] = ($this->_majestic_page_backlinks >= self::MAJESTIC_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }
}