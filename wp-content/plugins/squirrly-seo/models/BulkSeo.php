<?php

class SQ_Models_BulkSeo {

    protected $_task_categories_labels;
    protected $_task_categories;

    protected $_assistant_tasks;
    protected $_assistant_categories;

    protected $_page;

    public function init() {

        $this->_task_categories = array(
            'metas' => esc_html__("METAs", _SQ_PLUGIN_NAME_),
            'opengraph' => esc_html__("Open Graph", _SQ_PLUGIN_NAME_),
            'twittercard' => esc_html__("Twitter Card", _SQ_PLUGIN_NAME_),
            'visibility' => esc_html__("Visibility", _SQ_PLUGIN_NAME_),
        );

        foreach ($this->_task_categories as $category => $title) {
            $this->_task_categories_labels[$category] = array(
                'color' => '#dd3333',
                'name' => $title,
                'show' => false);
        }

        return $this;
    }

    public function parsePage(SQ_Models_Domain_Post $page, $labels = array()) {
        //set focus pages from API
        $this->_page = $page;
        //call  focus page tasks for all categories
        $this->parseAllTasks();
        $assistant_tasks = apply_filters('sq_assistant_tasks', array());
        $this->_assistant_categories[$this->_page->hash] = apply_filters('sq_assistant_categories', array());
        //remove the filters for the next focus page
        remove_all_filters('sq_assistant_tasks');
        remove_all_filters('sq_assistant_categories');

        $total_tasks = $total_tasks_completed = 0;
        foreach ($this->_task_categories as $category => $array) {

            //Build the tasks score
            foreach ($assistant_tasks[$category] as $task) {
                $total_tasks++;

                if ($task['completed'] || $task['error'] || !$task['active']) {
                    //add task as completed
                    $total_tasks_completed++;
                }
            }

            if (!empty($assistant_tasks[$category])) {
                $this->_assistant_categories[$this->_page->hash][$category]['assistant'] = $this->getAssistant($category, $assistant_tasks[$category], $this->_assistant_categories[$this->_page->hash][$category]);
            }

            //if the category is incomplete
            if (!$this->_assistant_categories[$this->_page->hash][$category]['completed']) {

                $this->_task_categories_labels[$category]['show'] = true;

            } elseif (is_array($labels) && !empty($labels)) {

                if (in_array($category, $labels)) {
                    $this->_page = false;
                    return $this;
                }

            }

        }
        //Set the total number of tasks
        $this->_page->setTotalTasts($total_tasks);
        $this->_page->setCompletedTasts($total_tasks_completed);

        //set the categories for this page
        add_filter('sq_assistant_categories_page', array($this, 'getAssistantCategories'));

        return $this;
    }

    public function getCategories() {
        return json_decode(wp_json_encode($this->_task_categories));
    }

    public function getAssistantCategories($hash) {
        return json_decode(wp_json_encode($this->_assistant_categories[$hash]));
    }


    public function getLabels() {
        return json_decode(wp_json_encode(apply_filters('sq_categories_labels', $this->_task_categories_labels)));
    }

    public function getPage() {
        return $this->_page;
    }

    public function getAssistant($category_name = '', $tasks = array(), $category = array()) {
        $content = '';

        if (!empty($tasks) && !empty($category)) {
            $content .= '<ul id="sq_assistant_tasks_' . $category_name . '_' . $this->_page->hash . '" class="p-0 m-0" style="display:none;">';
            $content .= (isset($category['header']) ? $category['header'] : '');

            foreach ($tasks as $name => $task) {
                $task_content = '<li class="sq_task row ' . (isset($task['status']) ? $task['status'] : '') . '" data-category="' . $category_name . '" data-name="' . $name . '" data-active="' . $task['active'] . '" data-completed="' . $task['completed'] . '"  data-dismiss="modal">
                            <i class="fa fa-check" title="' . strip_tags($task['error_message']) . '"></i>
                            <h4>' . $task['title'] . '</h4>
                            <div class="description" style="display: none">' . $task['description'] . '</div>
                            <div class="message" style="display: none">' . $task['error_message'] . '</div>
                            </li>';

                //Change task format ondemand
                $content .= apply_filters('sq_assistant_' . $category_name . '_task_' . $name, $task_content, $task, '');

                //remove the filters for the next focus page
                remove_all_filters('sq_assistant_' . $category_name . '_task_' . $name);

            }
            $content .= '</ul>';

        }

        return $content;
    }


    /**
     * Get the admin Menu Tabs
     */
    public function parseAllTasks() {
        foreach ($this->_task_categories as $category => $title) {
            if ($bulkClass = SQ_Classes_ObjController::getNewClass('SQ_Models_Bulkseo_' . ucfirst($category))) {
                $bulkClass->setPost($this->_page)->init();//set the local post in focuspage model
            }
        }
    }


}