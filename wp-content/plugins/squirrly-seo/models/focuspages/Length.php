<?php

class SQ_Models_Focuspages_Length extends SQ_Models_Abstract_Assistant {

    protected $_category = 'length';

    protected $_words = false;
    protected $_pagetime = false;

    const WORDCOUNT_MINVAL = 1500;
    const PAGETIME_MINVAL = 120; //2 min

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if (isset($this->_audit->data->sq_seo_meta->words)) {
            $this->_words = $this->_audit->data->sq_seo_meta->words;
        }


        if ($this->_audit->sq_analytics_google_connected && isset($this->_audit->data->sq_analytics_google->page_time)) {
            $this->_pagetime = $this->_audit->data->sq_analytics_google->page_time;
        }
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'wordcont' => array(
                'title' => sprintf(esc_html__("Write %s words", _SQ_PLUGIN_NAME_), self::WORDCOUNT_MINVAL),
                'value' => number_format((int)$this->_words, 0, '.', ',') . ' ' . esc_html__("words", _SQ_PLUGIN_NAME_),
                'penalty' => 5,
                'description' => sprintf(esc_html__("For Focus Pages it's mandatory, in our opinion, to have at least 1,500 words. %s Go and edit the page. %s I know: for some of you it might sound tough, but Google places longer, more valuable pages higher in search positions. %s You don't necessarily have to get 1,500 words on this page for it to rank in TOP 10 on Google. However, getting this task completed ensures that your chances of ranking will be very high.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'avgtime' => array(
                'title' => esc_html__("Reader's Experience", _SQ_PLUGIN_NAME_),
                'value' => ($this->_pagetime !== false ? number_format(($this->_pagetime / 60), 0, '.', ',') : 0) . ' ' . esc_html__("minutes average", _SQ_PLUGIN_NAME_),
                'description' => sprintf(esc_html__("Get an average time on page of minimum 2 minutes for this focus page. You can do this by editing the content and making it more appealing to visitors. %s We're looking at the Average Time On Page for this page. %s Why? %s Because, sometimes website owners can be tempted to make the pages longer in order to get many words on a page. They make them longer by increasing wordiness. %s Over 1,500 words / page can give you much better SEO results. However, making it longer does not mean you should make it boring. %s In order to check that the length of the page was increased properly, we also take into account if website visitors love this page.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
        );

    }

    /*********************************************/
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__("Current URL", _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        if (isset($this->_post->ID)) {
            $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$this->_post->ID . '&action=edit');
            if ($this->_post->post_type <> 'profile') {
                $edit_link = get_edit_post_link($this->_post->ID, false);
            }

            $header .= '<li class="completed" style="background-color:#f7f7f7">';
            if (isset($this->_post->ID)) {
                $header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 my-2">' . esc_html__("Edit Page", _SQ_PLUGIN_NAME_) . '</a>';
            }
            if (!$this->_audit->sq_analytics_google_connected) {
                $header .= '<a href="' . SQ_Classes_RemoteController::getApiLink('gaoauth') . '"  target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-1">' . esc_html__("Connect Google Analytics", _SQ_PLUGIN_NAME_) . '</a>';
            }
            $header .= '</li>';


        }
        return $header;
    }

    /**
     * Keyword optimization required
     * @param $title
     * @return string
     */
    public function getTitle($title) {

        if ($this->_error && !$this->_audit->sq_analytics_google_connected) {
            return esc_html__("Connect to Google Analytics first.", _SQ_PLUGIN_NAME_);
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
     * Check the words count from local post
     * @return bool|WP_Error
     */
    public function checkWordcont($task) {
        if ($this->_words !== false) {
            $task['completed'] = ($this->_words >= self::WORDCOUNT_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * Check the AVG time on page from traffic category
     * @return bool|WP_Error
     */
    public function checkAvgtime($task) {
        if ($this->_pagetime !== false) {
            $task['completed'] = ($this->_pagetime >= self::PAGETIME_MINVAL);
            return $task;
        }

        if (!$this->_audit->sq_analytics_google_connected) {
            $task['error_message'] = esc_html__("Connect Google Analytics first.", _SQ_PLUGIN_NAME_);
        }

        $task['error'] = true;
        return $task;
    }
}