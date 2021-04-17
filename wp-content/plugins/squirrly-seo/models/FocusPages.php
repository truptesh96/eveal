<?php

class SQ_Models_FocusPages {
    protected $_task;
    //Focus pages Categories
    protected $_task_categories_labels;
    protected $_task_categories;

    //Processed Assistant Tasks and Categories
    protected $_assistant_tasks;
    protected $_assistant_categories;

    /** @var SQ_Models_Domain_FocusPage */
    protected $_focuspage;

    public function init() {

        $this->_task_categories = array(
            'indexability' => esc_html__("Visibility", _SQ_PLUGIN_NAME_),
            'keyword' => esc_html__("Keyword", _SQ_PLUGIN_NAME_),
            'strategy' => esc_html__("Strategy", _SQ_PLUGIN_NAME_),
            'content' => esc_html__("SEO Content", _SQ_PLUGIN_NAME_),
            'length' => esc_html__("Words / Page", _SQ_PLUGIN_NAME_),
            'onpage' => esc_html__("Platform SEO", _SQ_PLUGIN_NAME_),
            'snippet' => esc_html__("Snippet", _SQ_PLUGIN_NAME_),
            'image' => esc_html__("SEO Image", _SQ_PLUGIN_NAME_),
            'traffic' => esc_html__("Traffic Health", _SQ_PLUGIN_NAME_),
            'audit' => esc_html__("Platform Health", _SQ_PLUGIN_NAME_),
            'authority' => esc_html__("Page Authority", _SQ_PLUGIN_NAME_),
            'social' => esc_html__("Social Signals", _SQ_PLUGIN_NAME_),
            'backlinks' => esc_html__("Backlinks", _SQ_PLUGIN_NAME_),
            'innerlinks' => esc_html__("Inner Links", _SQ_PLUGIN_NAME_),
            'nofollow' => esc_html__("Outbound Links", _SQ_PLUGIN_NAME_),
            'accuracy' => esc_html__("Accuracy", _SQ_PLUGIN_NAME_),
            'ctr' => esc_html__("CTR", _SQ_PLUGIN_NAME_),
            'impressions' => esc_html__("Impressions", _SQ_PLUGIN_NAME_),
            'clicks' => esc_html__("Clicks", _SQ_PLUGIN_NAME_),
        );

        foreach ($this->_task_categories as $category => $title) {
            $this->_task_categories_labels[$category] = array(
                'color' => '#dd3333',
                'name' => $title,
                'show' => false);
        }

        return $this;
    }

    /**
     * Parse all categories for a single page
     * @param SQ_Models_Domain_FocusPage $focuspage
     * @param array $labels
     * @return $this
     */
    public function parseFocusPage(SQ_Models_Domain_FocusPage $focuspage, $labels = array()) {
        //set focus pages from API
        $this->_focuspage = $focuspage;

        //call  focus page tasks for all categories
        $this->parseAllTasks();
        $assistant_tasks = apply_filters('sq_assistant_tasks', array());

        $this->_assistant_categories[$this->_focuspage->id] = apply_filters('sq_assistant_categories', array());
        //remove the filters for the next focus page
        remove_all_filters('sq_assistant_tasks');
        remove_all_filters('sq_assistant_categories');

        foreach ($this->_task_categories as $category => $array) {

            if (!empty($assistant_tasks[$category])) {
                $this->_assistant_categories[$this->_focuspage->id][$category]['assistant'] = $this->getAssistant($category, $assistant_tasks[$category], $this->_assistant_categories[$this->_focuspage->id][$category]);
            }

            //if the category is NOT complete and doesn't have erros
            if (isset($this->_assistant_categories[$this->_focuspage->id][$category])) {
                if (!$this->_assistant_categories[$this->_focuspage->id][$category]['completed'] && !$this->_assistant_categories[$this->_focuspage->id][$category]['error']) {
                    $this->_task_categories_labels[$category]['show'] = true;
                }
            }

        }

        $audit = $this->_focuspage->getAudit();

        if (!isset($audit->properties) || !isset($audit->data->sq_seo_keywords->value) || $audit->data->sq_seo_keywords->value == '') {
            $this->_focuspage->visibility = 'N/A';
        } else {
            $post = $this->_focuspage->getWppost();
            if ($post->post_status <> 'publish') { //just if the Focus Page is public
                $this->_focuspage->visibility = 'N/A';
                $this->_focuspage->audit_error = 404;
            }
        }

        //set the categories for this page
        add_filter('sq_assistant_categories_page', array($this, 'getAssistantCategories'));


        return $this;
    }

    public function getCategories() {
        return json_decode(wp_json_encode($this->_task_categories));
    }

    public function getAssistantCategories($id) {
        //SQ_Debug::dump($id,array_keys($this->_assistant_categories));
        return json_decode(wp_json_encode($this->_assistant_categories[$id]));
    }

    public function getLabels() {
        return json_decode(wp_json_encode(apply_filters('sq_categories_labels', $this->_task_categories_labels)));
    }

    public function getFocusPage() {
        return $this->_focuspage;
    }

    public function getAssistant($category_name = '', $tasks = array(), $category = array()) {
        $content = '';
        if (!empty($tasks) && !empty($category)) {
            $content .= '<ul id="sq_assistant_tasks_' . $category_name . '_' . $this->_focuspage->id . '" class="p-0 m-0" style="display:none;">';
            $content .= (isset($category['header']) ? $category['header'] : '');

            foreach ($tasks as $name => $task) {
                $task_content = '<li class="sq_task row ' . (isset($task['status']) ? $task['status'] : '') . '" data-category="' . $category_name . '" data-name="' . $name . '" data-active="' . $task['active'] . '" data-completed="' . $task['completed'] . '"  data-dismiss="modal">
                            <i class="fa fa-check" title="' . strip_tags($task['error_message']) . '"></i>
                            <h4>' . $task['title'] . '</h4>
                            <div class="description" style="display: none">' . $task['description'] . '</div>
                            <div class="message" style="display: none">' . $task['error_message'] . '</div>
                            </li>';

                //Change task format ondemand
                $content .= apply_filters('sq_assistant_' . $category_name . '_task_' . $name, $task_content, $task);

                //remove the filters for the next focus page
                remove_all_filters('sq_assistant_' . $category_name . '_task_' . $name);

            }

            $content .= '</ul>';
        }

        return $content;
    }


    /**
     * Get the admin Menu Tabs
     * @return void
     */
    public function parseAllTasks() {
        foreach ($this->_task_categories as $category => $title) {

            SQ_Classes_ObjController::getNewClass('SQ_Models_Focuspages_' . ucfirst($category))
                ->setAudit($this->_focuspage->getAudit())//set the audit received from API
                ->setPost($this->_focuspage->getWppost())//set the local post in focuspage model
                ->init();
        }
    }

}