<?php

class SQ_Models_Focuspages_Traffic extends SQ_Models_Abstract_Assistant {

    protected $_category = 'traffic';

    protected $_bounce_rate = false;
    protected $_page_views = false;
    protected $_page_sessions = false;
    protected $_page_newvisits = false;
    protected $_page_time = false;
    protected $_gacode_duplicate = false;

    const BOUNCE_MAXVAL = 50;
    const AVGTIME_MINVAL = 2;
    const EXIT_MAXVAL = 70;
    const VISITS_MINVAL = 70;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if ($this->_audit->sq_analytics_google_connected) {
            if (isset($this->_audit->data->sq_analytics_google->page_bouce)) {
                $this->_bounce_rate = $this->_audit->data->sq_analytics_google->page_bouce;
                $this->_bounce_rate = (int)$this->_bounce_rate;
            }
            if (isset($this->_audit->data->sq_analytics_google->page_views)) {
                $this->_page_views = $this->_audit->data->sq_analytics_google->page_views;
                if($this->_page_views > 0){
                    $this->_page_views = ceil(($this->_page_views / 7));
                }
            }
            if (isset($this->_audit->data->sq_analytics_google->page_sessions)) {
                $this->_page_sessions = $this->_audit->data->sq_analytics_google->page_sessions;
                if($this->_page_sessions > 0){
                    $this->_page_sessions = ceil(($this->_page_sessions / 7));
                }
            }
            if (isset($this->_audit->data->sq_analytics_google->page_newvisits)) {
                $this->_page_newvisits = $this->_audit->data->sq_analytics_google->page_newvisits;
                if($this->_page_newvisits > 0){
                    $this->_page_newvisits = ceil(($this->_page_newvisits / 7));
                }
            }
            if (isset($this->_audit->data->sq_analytics_google->page_time)) {
                $this->_page_time = $this->_audit->data->sq_analytics_google->page_time;
                $this->_page_time = number_format(($this->_page_time / 60), 1,'.', ',');
            }
        }

        if (isset($this->_audit->data->sq_seo_body->ga_duplicate)) {
            $this->_gacode_duplicate = $this->_audit->data->sq_seo_body->ga_duplicate;
        }
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'bounce' => array(
                'title' => sprintf(esc_html__("Below %s Bounce Rate", _SQ_PLUGIN_NAME_), self::BOUNCE_MAXVAL . '%'),
                'value' => $this->_bounce_rate. '%' . ' ' . esc_html__("bounce rate", _SQ_PLUGIN_NAME_),
                'description' => sprintf(esc_html__("Make sure this number is below %s  %s Why? %s A high bounce rate means that your users just click on your search listing, visit the page and then decide they've seen enough and bounce off to another page on the web. %s This is, for Google, an indicator of the quality of the search result it displayed. And if many of your users bounce off your pages, it means (to Google) that your page is not worth displaying in search results, because it has low performance with the user groups it sends your way. %s Easy way to complete this task: give users pages to click and send them to other pages from your site.", _SQ_PLUGIN_NAME_), self::BOUNCE_MAXVAL . '%', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'avgtime' => array(
                'title' => sprintf(esc_html__("Time on page is %s minutes", _SQ_PLUGIN_NAME_), self::AVGTIME_MINVAL),
                'value' => ($this->_page_time > 0 ? $this->_page_time : 0) . ' ' . esc_html__("minutes avg.", _SQ_PLUGIN_NAME_),
                'penalty' => 10,
                'description' => sprintf(esc_html__("Make sure that visitors spend on average at least %s minutes on your site. %s Get an average time on page of minimum %s minutes for this focus page. You can do this by editing the content and making it more appealing to visitors. %s If your visitors don't spend at least 2 minutes on your Focus Page, it can mean that the page is not important enough for them, or that the content from the page is boring, or hard to read, or the page just loads too slow.", _SQ_PLUGIN_NAME_), self::AVGTIME_MINVAL, '<br /><br />',self::AVGTIME_MINVAL, '<br /><br />', '<br /><br />'),
            ),
            'visits' => array(
                'title' => sprintf(esc_html__("%s visitors / day / page", _SQ_PLUGIN_NAME_), self::VISITS_MINVAL),
                'value' => $this->_page_sessions . ' ' . esc_html__("unique views avg.", _SQ_PLUGIN_NAME_),
                'description' => sprintf(esc_html__("For this task, we're looking at unique page views from your %sGoogle Analytics%s. %s If you don't get an average of %s visitors / day / page, then this Focus Page is not yet popular enough on your site. %s You should make sure that more people end up visiting it.", _SQ_PLUGIN_NAME_), '<a href="https://analytics.google.com/analytics/web/" target="_blank">', '</a>','<br /><br />', self::VISITS_MINVAL, '<br /><br />'),
            ),
            'gacode' => array(
                'title' => sprintf(esc_html__("Just one Google Analytics tracking code", _SQ_PLUGIN_NAME_), self::VISITS_MINVAL),
                'description' => sprintf(esc_html__("We've seen many sites where there were multiple google analytics codes placed by different employees, themes or plugins. %s With this check, we're helping you make sure that your tracker is setup properly and that there will be no errors with your Google Analytics account. %s To turn this green, you'll have to investigate your theme, custom code that you may have placed in your theme, other plugins, header settings. Once you have a clear view of all the tracking codes, make sure that only one remains and that the one code is the one linked to your Google Analytics account. %s These problems happen more often than you would think.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
        );
    }

    /*********************************************/
    /**
     * Check if the Google Analytics is connected
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
     * Keyword optimization required
     * @param $title
     * @return string
     */
    public function getTitle($title) {


        if (!$this->_audit->sq_analytics_google_connected) {
            return esc_html__("Connect Google Analytics first", _SQ_PLUGIN_NAME_);
        } elseif ($this->_error) {
            return esc_html__("Not enough traffic to show relevant stats", _SQ_PLUGIN_NAME_);
        } elseif (!$this->_completed && !$this->_indexed) {
            foreach ($this->_tasks[$this->_category] as $task) {
                if ($task['completed'] === false) {
                    return esc_html__("Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
                }
            }
        }
        return parent::getTitle($title);
    }

    /**
     * API Google Analytics Bounce rate
     * @return bool|WP_Error
     */
    public function checkBounce($task) {
        if ($this->_bounce_rate !== false) {
            $task['completed'] = ($this->_bounce_rate <= self::BOUNCE_MAXVAL);
            return $task;
        }
        if(!$this->_audit->sq_analytics_google_connected){
            $task['error_message'] = esc_html__("Connect Google Analytics first.", _SQ_PLUGIN_NAME_);
        }
        $task['error'] = true;
        return $task;
    }

    /**
     * API Google Analytics Avg Time rate
     * @return bool|WP_Error
     */
    public function checkAvgtime($task) {
        if ($this->_page_time !== false) {
            $task['completed'] = ($this->_page_time >= self::AVGTIME_MINVAL);
            return $task;
        }
        if(!$this->_audit->sq_analytics_google_connected){
            $task['error_message'] = esc_html__("Connect Google Analytics first.", _SQ_PLUGIN_NAME_);
        }
        $task['error'] = true;
        return $task;
    }

    /**
     * API Google Analytics Visits rate. Unique page views
     * @return bool|WP_Error
     */
    public function checkVisits($task) {
        if ($this->_page_sessions !== false) {
            $task['completed'] = ($this->_page_sessions >= self::VISITS_MINVAL);
            return $task;
        }
        if(!$this->_audit->sq_analytics_google_connected){
            $task['error_message'] = esc_html__("Connect Google Analytics first.", _SQ_PLUGIN_NAME_);
        }
        $task['error'] = true;
        return $task;
    }

    /**
     * API Google Analytics GA code duplicate
     * @return bool|WP_Error
     */
    public function checkGacode($task) {
        $task['completed'] = !$this->_gacode_duplicate;
        return $task;
    }
}