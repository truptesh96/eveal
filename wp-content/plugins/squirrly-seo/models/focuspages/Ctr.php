<?php

class SQ_Models_Focuspages_Ctr extends SQ_Models_Abstract_Assistant {

    protected $_category = 'ctr';
    protected $_keyword = false;
    protected $_ctr = false;

    const CTR_MINVAL = 5;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if ($this->_audit->sq_analytics_gsc_connected) {
            if (isset($this->_audit->data->sq_analytics_gsc->keyword) && $this->_audit->data->sq_analytics_gsc->keyword <> '' &&
                isset($this->_audit->data->sq_analytics_gsc->ctr)) {

                $this->_keyword = $this->_audit->data->sq_analytics_gsc->keyword;
                $this->_ctr = $this->_audit->data->sq_analytics_gsc->ctr;

            } elseif (isset($this->_audit->data->sq_seo_keywords->value)) {
                $this->_keyword = $this->_audit->data->sq_seo_keywords->value;
                $this->_ctr = 0;
            }
        } else {
            $this->_error = true;

        }
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'clickthrough' => array(
                'title' => esc_html__("Clickthrough rate", _SQ_PLUGIN_NAME_),
                'description' => sprintf(esc_html__("CTR is the number of clicks that your page receives divided by the number of times your page appeared in search results: clicks ÷ impressions = CTR. %s For example, if you had 5 clicks and 100 impressions, then your CTR would be 5%%. %s Keep the CTR above %s with enhanced headlines.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', self::CTR_MINVAL . '%'),
            ),

        );
    }

    /*********************************************/

    /**
     * Check if the Google Search Console is connected
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__("Current URL", _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        $header .= '<li class="completed" style="background-color:#f7f7f7">';
        if (!$this->_audit->sq_analytics_gsc_connected) {
            $header .= '<a href="' . SQ_Classes_RemoteController::getApiLink('gscoauth') . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-3">' . esc_html__("Connect Google Search", _SQ_PLUGIN_NAME_) . '</a>';
        } elseif ($this->_keyword) {
            $header .= $this->getUsedKeywords();
            $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research', array('keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($this->_keyword)))  . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-3">' . esc_html__("Do a research", _SQ_PLUGIN_NAME_) . '</a>';
        } else {
            if (isset($this->_post->ID)) {
                $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$this->_post->ID . '&action=edit');
                if ($this->_post->post_type <> 'profile') {
                    $edit_link = get_edit_post_link($this->_post->ID, false);
                }

                $header .= '<div class="font-weight-bold text-warning m-0  text-center">' . esc_html__("No Keyword found in Squirrly Live Assistant", _SQ_PLUGIN_NAME_) . '</div>';
                $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-3">' . esc_html__("Do a research", _SQ_PLUGIN_NAME_) . '</a>';
                if (isset($this->_post->ID)) {
                    $header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 my-2">' . esc_html__("Optimize for a keyword", _SQ_PLUGIN_NAME_) . '</a>';
                }
            }
        }
        $header .= '</li>';

        return $header;
    }

    /**
     * Customize the Color for this tasks
     * @param $completed
     * @return string
     */
    public function getColor($completed) {
        if(!$completed){
            return self::TASK_INCOMPLETE;
        }

        return parent::getColor($completed);
    }

    /**
     * Keyword optimization required
     * @param $title
     * @return string
     */
    public function getTitle($title) {

        if ($this->_error && !$this->_keyword) {
            return esc_html__("Optimize the page for a keyword. Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
        }elseif ($this->_error && !$this->_audit->sq_analytics_gsc_connected) {
            return esc_html__("Connect to Google Search Console.", _SQ_PLUGIN_NAME_);
        }elseif (!$this->_completed && !$this->_indexed) {
            foreach ($this->_tasks[$this->_category] as $task) {
                if ($task['completed'] === false) {
                    return esc_html__("Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
                }
            }
        }

        return parent::getTitle($title);
    }

    public function getValue() {
        if ($this->_ctr !== false) {
            return number_format($this->_ctr, 2, '.', ',') . '%';
        }

        return false;
    }

    public function checkClickthrough($task) {
        if ($this->_ctr !== false) {
            $task['completed'] = ((int)$this->_ctr >= self::CTR_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }
}