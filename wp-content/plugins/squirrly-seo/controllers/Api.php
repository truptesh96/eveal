<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Api extends SQ_Classes_FrontController {

    /** @var string token local key */
    private $token;

    /**
     * Initialize the TinyMCE editor for the current use
     *
     * @return void
     */
    public function hookInit() {

        if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '')
            return;

        if (!SQ_Classes_Helpers_Tools::getOption('sq_cloud_connect'))
            return;

        //the default token
        if (!SQ_Classes_Helpers_Tools::getOption('sq_cloud_token'))
            SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_token', md5(SQ_Classes_Helpers_Tools::getOption('sq_api') . parse_url(home_url(), PHP_URL_HOST)));

        $this->token = SQ_Classes_Helpers_Tools::getOption('sq_cloud_token');

        //Change the rest api if needed
        add_action('rest_api_init', array($this, 'sqApiCall'));
    }


    function sqApiCall() {
        if (function_exists('register_rest_route')) {
            register_rest_route('save', '/squirrly/', array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => array($this, 'savePost'),
                'permission_callback' => '__return_true'
            ));

            register_rest_route('test', '/squirrly/', array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => array($this, 'testConnection'),
                'permission_callback' => '__return_true'
            ));

            register_rest_route('get', '/squirrly/', array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getData'),
                'permission_callback' => '__return_true'
            ));
        }
    }

    /**
     * Test the connection
     * @param WP_REST_Request $request Full details about the request.
     */
    public function testConnection($request) {
        SQ_Classes_Helpers_Tools::setHeader('json');

        //get the token from API
        $token = $request->get_param('token');
        if ($token <> '') {
            $token = sanitize_text_field($token);
        }

        if ($this->token <> $token) {
            exit(wp_json_encode(array('connected' => false, 'error' => esc_html__("Invalid Token. Please try again", _SQ_PLUGIN_NAME_))));
        }

        echo wp_json_encode(array('connected' => true, 'error' => false));
        exit();
    }

    /**
     * Save the Post
     * @param WP_REST_Request $request Full details about the request.
     */
    public function savePost($request) {
        SQ_Classes_Helpers_Tools::setHeader('json');

        //get the token from API
        $token = $request->get_param('token');
        if ($token <> '') {
            $token = sanitize_text_field($token);
        }

        if ($this->token <> $token) {
            exit(wp_json_encode(array('error' => esc_html__("Connection expired. Please try again", _SQ_PLUGIN_NAME_))));
        }

        $post = $request->get_param('post');
        if ($post = json_decode($post)) {
            if (isset($post->ID) && $post->ID > 0) {
                $post = new WP_Post($post);
                $post->ID = 0;
                if (isset($post->post_author)) {
                    if (is_email($post->post_author)) {
                        if ($user = get_user_by('email', $post->post_author)) {
                            $post->post_author = $user->ID;
                        } else {
                            exit(wp_json_encode(array('error' => esc_html__("Author not found", _SQ_PLUGIN_NAME_))));
                        }
                    } else {
                        exit(wp_json_encode(array('error' => esc_html__("Author not found", _SQ_PLUGIN_NAME_))));
                    }
                } else {
                    exit(wp_json_encode(array('error' => esc_html__("Author not found", _SQ_PLUGIN_NAME_))));
                }

                $post_ID = wp_insert_post($post->to_array());
                if (is_wp_error($post_ID)) {
                    echo wp_json_encode(array('error' => $post_ID->get_error_message()));
                } else {
                    echo wp_json_encode(array('saved' => true, 'post_ID' => $post_ID, 'permalink' => get_permalink($post_ID)));
                }
                exit();
            }
        }
        echo wp_json_encode(array('error' => true));
        exit();
    }

    /**
     * Get data for the Focus Page Audit
     * @param \WP_REST_Request $request
     */
    public function getData($request) {

        global $wpdb;
        $response = array();
        SQ_Classes_Helpers_Tools::setHeader('json');

        //get the token from API
        $token = $request->get_param('token');
        if ($token <> '') {
            $token = sanitize_text_field($token);
        }

        if ($this->token <> $token) {
            exit(wp_json_encode(array('error' => esc_html__("Connection expired. Please try again.", _SQ_PLUGIN_NAME_))));
        }

        $select = $request->get_param('select');


        switch ($select) {
            case 'innerlinks':
                $url = $request->get_param('url');
                if ($url == '') {
                    exit(wp_json_encode(array('error' => esc_html__("Wrong Params", _SQ_PLUGIN_NAME_))));
                }

                //get post inner links
                $total_posts = 0;
                $inner_links = array();
                if ($row = $wpdb->get_row($wpdb->prepare("SELECT COUNT(`ID`) as count FROM `$wpdb->posts` WHERE `post_status` = %s", 'publish'))) {
                    $total_posts = $row->count;
                }
                if ($rows = $wpdb->get_results($wpdb->prepare("SELECT `ID` FROM `$wpdb->posts` WHERE `post_content` LIKE '%%%s%' AND `post_status` = %s", $url, 'publish'), OBJECT)) {
                    if (!empty($rows)) {
                        foreach ($rows as $row) {
                            $post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($row->ID);
                            $inner_links[] = $post->url;
                        }
                    }
                }
                $response = array('url' => $url, 'total_posts' => $total_posts, 'inner_links' => $inner_links);
                break;
            case 'post':
                $url = $request->get_param('url');
                if ($url == '') {
                    exit(wp_json_encode(array('error' => esc_html__("Wrong Params", _SQ_PLUGIN_NAME_))));
                }
                //get Squirrly SEO post metas
                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByURL($url)) {
                    $response = $post->toArray();
                }

                break;
            case 'squirrly':
                //Get Squirrly settings
                if ($options = SQ_Classes_Helpers_Tools::getOptions()) {
                    $response = (array)$options;
                }

                break;
        }
        echo wp_json_encode($response);

        exit();

    }
}
