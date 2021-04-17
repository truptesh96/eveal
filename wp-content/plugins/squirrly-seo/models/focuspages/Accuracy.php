<?php

class SQ_Models_Focuspages_Accuracy extends SQ_Models_Abstract_Assistant {

    protected $_category = 'accuracy';

    public function init() {
        parent::init();

        if(!isset($this->_audit->data)){
            $this->_error = true;
            return;
        }
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'accuracy' => array(
                'title' => esc_html__("Rank accuracy", _SQ_PLUGIN_NAME_),
                'description' => sprintf(esc_html__("Do you need better accuracy for your ranking results? %s Look at the %sBusiness Plan%s pricing for Squirrly SEO. %s The SERP Checker Available on FREE and PRO Plans is made via Search Console integration, which means that the information is not as accurate as possible and will not clearly depict the exact position in Google. %s Why? %s Google uses an average when it comes to the position. And it's not the true position. The average is made according to the positions that the page was found on when users did click on it. %s Also, the data inside Search Console is a bit old, so if you're actively trying to increase your rankings day in and day out, you need the Business Plan. %s If you just want casually to know your rankings and not care about FULL accuracy, then you can stick with your current plan.", _SQ_PLUGIN_NAME_), '<br /><br />', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
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

        if (!$this->_audit->sq_analytics_gsc_connected) {
            $header .= '<li class="completed" style="background-color:#f7f7f7">
                    <a href="' . SQ_Classes_RemoteController::getApiLink('gscoauth') . '"  target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-1">' . esc_html__("Connect Google Search", _SQ_PLUGIN_NAME_) . '</a>
                </li>';
        }
        if (!$this->_audit->sq_analytics_google_connected) {
            $header .= '<li class="completed" style="background-color:#f7f7f7">
                    <a href="' . SQ_Classes_RemoteController::getApiLink('gaoauth') . '"  target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-1">' . esc_html__("Connect Google Analytics", _SQ_PLUGIN_NAME_) . '</a>
                </li>';
        }

        return $header;
    }

    /**
     * Notify user if the gathered data is from GSC or SERP CHEKER
     * @param $completed
     * @return string
     */
    public function getColor($completed) {
        if ($this->_audit->sq_subscription_serpcheck) {
            return self::TASK_COMPLETE;
        } elseif ($this->_audit->sq_analytics_gsc_connected) {
            return self::TASK_OBCURE;
        } else {
            return self::TASK_OBCURE;
        }
    }

    /**
     * Check if Serp Check exists. If not, return false
     * @return bool|WP_Error
     */
    public function checkAccuracy($task) {
        if (!$this->_audit->sq_subscription_serpcheck) {
            $task['completed'] = false;
            return $task;
        }

        $task['completed'] = true;
        return $task;
    }

}