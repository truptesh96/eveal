<?php

class SQ_Models_Focuspages_Nofollow extends SQ_Models_Abstract_Assistant {

    protected $_category = 'nofollow';

    protected $_permalink = false;
    protected $_nofollow_links = false;
    protected $_dofollow_links = false;

    const INNERS_MINVAL = 100;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        $this->_permalink = (isset($this->_post->url) && $this->_post->url <> '' ? $this->_post->url : $this->_audit->permalink);

        $this->_dofollow_links = array();
        if (isset($this->_audit->data->sq_seo_body->links_do_follow)) {
            $dofollow_links = json_decode($this->_audit->data->sq_seo_body->links_do_follow, true);

            if (!empty($dofollow_links)) {
                foreach ($dofollow_links as $link) {
                    if (parse_url($link, PHP_URL_HOST) && parse_url(home_url(), PHP_URL_HOST)) {
                        $link = str_replace('www.', '', parse_url($link, PHP_URL_HOST));
                        $hlink = str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST));
                        $slink = str_replace('www.', '', parse_url(site_url(), PHP_URL_HOST));

                        if ($link <> $hlink && $link <> $slink && strpos($link, '.') !== false) {
                            $this->_dofollow_links[] = $link;
                        }
                    }
                }
            }

        }

    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'externallinks' => array(
                'title' => esc_html__("Maintain authority", _SQ_PLUGIN_NAME_),
                'value' => ($this->_dofollow_links && !empty($this->_dofollow_links) ? '<br />' . esc_html__("External Dofollow Links", _SQ_PLUGIN_NAME_) . ':<br />' . join('<br />', array_slice(array_unique((array)$this->_dofollow_links), 0, 50)) : esc_html__("No dofollow external links", _SQ_PLUGIN_NAME_)),
                'penalty' => 5,
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

    public function checkExternallinks($task) {
        if (is_array($this->_dofollow_links)) {
            if (empty($this->_dofollow_links)) {
                $task['completed'] = true;
            } else {
                $task['completed'] = false;
            }
            return $task;
        }

        //$task['error'] = true;
        return $task;
    }

}