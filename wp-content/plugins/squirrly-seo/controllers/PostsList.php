<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_PostsList extends SQ_Classes_FrontController {

    /** @var array Post Type in */
    private $_types = array();
    private $_taxonomies = array();

    /** @var integer Set the column index for Squirrly */
    private $_pos = 5;

    /** @var string Set the column name for Squirrly */
    private $_slacolumn_id = 'sq_slacolumn';
    private $_column_id = 'sq_column';

    /** @var array list of the posts to load the optimization for */
    public $posts = array();


    /**
     * Create the column and filter for the Posts List
     *
     */
    public function init() {
        $this->_types = get_post_types(array('public' => true));
        SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->init();

        array_push($this->_types, 'posts');
        array_push($this->_types, 'pages');
        array_push($this->_types, 'media');

        //Exclude types for SLA
        $excludes = SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types');

        if (!empty($this->_types) && !empty($excludes)) {
            foreach ($excludes as $exclude) {
                if($exclude) {
                    if (false !== $key = array_search($exclude, $this->_types)) {
                        unset($this->_types[$key]);
                    }
                    if (false !== $key = array_search($exclude . 's', $this->_types)) {
                        unset($this->_types[$key]);
                    }
                }
            }
        }

        $this->_taxonomies = get_taxonomies(array('public' => true));

        if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') {
            return;
        }

        foreach ($this->_types as $type) {
            add_filter('manage_' . $type . '_columns', array($this, 'add_post_column'), 10, 1);
            add_action('manage_' . $type . '_custom_column', array($this, 'add_post_row'), 10, 2);
        }

        foreach ($this->_taxonomies as $taxonomy) {
            add_filter('manage_edit-' . $taxonomy . '_columns', array($this, 'add_tax_column'), 10, 1);
            add_action('manage_' . $taxonomy . '_custom_column', array($this, 'add_tax_row'), 10, 3);
        }

        //Update post status on API
        add_action('before_delete_post', array($this->model, 'hookUpdateStatus'), 10, 1);
        add_action('untrashed_post', array($this->model, 'hookUpdateStatus'), 10, 1);
        add_action('trashed_post', array($this->model, 'hookUpdateStatus'), 10, 1);

    }

    /**
     * Hook the Wordpress header only on postslist header table
     */
    public function loadHead() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('postslist');
    }

    /**
     * Add the Squirrly column in the Post List
     *
     * @param array $columns
     * @return array
     */
    public function add_post_column($columns) {
        $this->loadHead(); //load the js only for post list

        $columns = $this->insert($columns, array($this->_column_id => esc_html__("SQ Snippet", _SQ_PLUGIN_NAME_)), $this->_pos);
        $columns = $this->insert($columns, array($this->_slacolumn_id => esc_html__("Optimized", _SQ_PLUGIN_NAME_)), $this->_pos);

        return $columns;
    }

    /**
     * Add row in Post list
     *
     * @param object $column
     * @param integer $post_id
     */
    public function add_post_row($column, $post_id) {
        if (!$post_type = get_post_type($post_id)) {
            $post_type = 'post';
        }

        if ($column == $this->_slacolumn_id) {
            $html = false;
            if (SQ_Classes_Helpers_Tools::isAjax()) {
                $args = array();
                $args['posts'] = $post_id;

                if ($json = SQ_Classes_RemoteController::getPostOptimization($args)) {
                    if (!is_wp_error($json)) {
                        $posts = $this->model->processPost($json, $post_type);
                        $html = $posts[$post_id];
                    }
                }
            } else {
                if (get_post_status($post_id) == 'publish')
                    array_push($this->posts, $post_id);
            }

            echo '<div class="' . $this->_slacolumn_id . '_row" ref="' . $post_id . '">' . (($html) ? $html: 'loading ...') . '</div>';
        }

        if ($column == $this->_column_id) {
            echo '<div class="' . $this->_column_id . '_row">' . $this->model->getPostButton($post_id, $post_type) . '</div>';
        }
    }

    /**
     * Add the Squirrly column in the Post List
     *
     * @param array $columns
     * @return array
     */
    public function add_tax_column($columns) {
        $this->loadHead(); //load the js only for post list

        $columns = $this->insert($columns, array($this->_column_id => esc_html__("SQ Snippet", _SQ_PLUGIN_NAME_)), $this->_pos);
        return $columns;
    }

    /**
     * Add row in Categories and Tags
     *
     * @param string $html
     * @param object $column
     * @param integer $post_id
     */
    public function add_tax_row($html = '', $column = 0, $tax_id = 0) {
        if ((int)$tax_id > 0 && (int)$column > 0) {
            $term = get_term($tax_id);

            if (!is_wp_error($term) && $column == $this->_column_id) {
                return '<div class="' . $this->_column_id . '_row">' . $this->model->getTaxButton($term->term_id, 'tax-' . $term->taxonomy) . '</div>';
            }
        }

        return $html;
    }

    /**
     * Push the array to a specific index
     * @param array $src
     * @param array $in
     * @param integer $pos
     * @return array
     */
    public function insert($src, $in, $pos) {
        $array = array();
        if (is_int($pos))
            $array = array_merge(array_slice($src, 0, $pos), $in, array_slice($src, $pos));
        else {
            foreach ($src as $k => $v) {
                if ($k == $pos)
                    $array = array_merge($array, $in);
                $array[$k] = $v;
            }
        }
        return $array;
    }

    /**
     * Hook Get/Post action
     * @return void
     */
    public function action() {
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'inline-save':
                check_ajax_referer('inlineeditnonce', '_inline_edit');
                if (isset($_POST['post_ID']) && ($post_id = (int)$_POST['post_ID']) && isset($_POST['_status']) && $_POST['_status'] <> '') {
                    $args = array();
                    $args['status'] = $_POST['_status'];
                    $args['post_id'] = $post_id;
                    $args['referer'] = 'posts';
                    SQ_Classes_RemoteController::savePost($args);
                }

                return;
        }

        parent::action();
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_ajax_postslist':
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo wp_json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                $args = array();
                $posts = SQ_Classes_Helpers_Tools::getValue('posts');
                if (is_array($posts) && !empty($posts)) {
                    $post_type = SQ_Classes_Helpers_Tools::getValue('post_type', 'post');
                    $args['posts'] = join(',', SQ_Classes_Helpers_Tools::getValue('posts', array()));

                    if ($json = SQ_Classes_RemoteController::getPostOptimization($args)) {
                        if (is_wp_error($json)) {
                            $array = array();
                            if ($json->get_error_message() == 'no_data') {
                                foreach ($posts as $post_id) {
                                    $array[$post_id] = esc_html__("Network Error. Please Refresh.", _SQ_PLUGIN_NAME_);
                                }
                            } elseif ($json->get_error_message() == 'maintenance') {
                                foreach ($posts as $post_id) {
                                    $array[$post_id] = sprintf(esc_html__("Maintenance. %sWe'll be back in a minute.", _SQ_PLUGIN_NAME_), '<br />');
                                }
                            }

                            echo wp_json_encode(array('posts' => $array));
                        } else {
                            $posts = $this->model->processPost($json, $post_type);
                            echo wp_json_encode(array('posts' => $posts));
                        }

                        exit();
                    }
                }
                echo wp_json_encode(array('posts' => array()));
                exit();
        }
    }

    /**
     * Hook the Footer
     *
     */
    public function hookFooter() {
        $posts = '';
        foreach ($this->posts as $post) {
            $posts .= '"' . $post . '",';
        }

        if (strlen($posts) > 0) $posts = substr($posts, 0, strlen($posts) - 1);

        echo '<script>
                var __sq_ranknotpublic_text = "' . esc_html__("Not Public", _SQ_PLUGIN_NAME_) . '";
                var __sq_couldnotprocess_text = "' . esc_html__("Could not process", _SQ_PLUGIN_NAME_) . '";
                var __sq_subscriptionexpired_text = "' . esc_html__("The Squirrly subscription has expired!", _SQ_PLUGIN_NAME_) . '";
                var sq_posts = new Array(' . $posts . ');
                </script>';

    }

}
