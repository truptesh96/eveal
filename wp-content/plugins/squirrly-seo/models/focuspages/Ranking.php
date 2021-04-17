<?php

class SQ_Models_Focuspages_Ranking extends SQ_Models_Abstract_Assistant {

    protected $_category = 'ranking';

    const RANKING_MINVAL = 10;

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
            'ranking' => array(
                'title' => esc_html__("Nofollow on external links", _SQ_PLUGIN_NAME_),
                'description' => sprintf(esc_html__("TLDR: All outbound links need to have no-follow attribute. %s You've worked hard on your Focus Page. %s Now make sure that you're not letting that hard work go to waste, by sending out all your authority and Link Juice over to other pages from the web. %s The Focus Page needs to be the final page that Google Follows. It's an \"All Roads Lead to Rome\" kind of scenario. %s If you want your focus pages to get ranked better and have authority make sure that ALL outbound links have a no-follow attribute attached to them.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
        );
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
    /*********************************************/

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

    public function checkExternallinks($task) {
        $task['completed'] =  true;
        return $task;
    }

}