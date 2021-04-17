<?php

class SQ_Models_PostsList {

    /**
     * Process the API data and return the optimization
     *
     * @param $response
     * @return mixed
     */
    public function processPost($json, $post_type) {
        $response = array();
        if (isset($json->posts)) {
            foreach ($json->posts as $post_id => $row) {
                if (isset($row->error_message) && $row->error_message <> '') {
                    $response[$post_id] = '<span class="sq_no_rank" ref="' . $post_id . '"><a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank">' . $row->error_message . '</a></span>';
                    continue;
                }

                if (isset($row->optimized) && (int)$row->optimized > 0) {
                    $html = '<progress class="sq_post_progress" max="100" value="' . $row->optimized . '" title="' . esc_html__("Optimized", _SQ_PLUGIN_NAME_) . ': ' . $row->optimized . '% ' . '" ></progress>';
                    $html .= '<div class="sq_post_keyword" >' . $row->keyword . '</div>';
                } else {
                    $html = '<a class="sq_optimize" href="' . admin_url('post.php?action=edit&post_type=' . $post_type . '&post=' . $post_id) . '">' . esc_html__("Optimize it with Squirrly Live Assistant", _SQ_PLUGIN_NAME_) . '</span>';
                }

                $response[$post_id] = $html;
            }

        }

        return $response;
    }

    /**
     * Show SEO Button
     *
     * @param int $post_id
     * @param string $post_type
     * @return string
     */
    public function getPostButton($post_id = 0, $post_type = 'post') {
        $button = '';
        if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->getCurrentSnippet($post_id, 0, '', $post_type)) {
            $post = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->parsePage($post)->getPage();
            $post->tasks_completed = ($post->tasks_completed ? $post->tasks_completed : 1);
            $completed = number_format(($post->tasks_completed * 100) / $post->tasks, 0);
            $title = esc_html__("Snippet optimized", _SQ_PLUGIN_NAME_) . ': ' . $completed . '%. ' . ($post->tasks - $post->tasks_completed) . ' ' . esc_html__("task(s) remained.", _SQ_PLUGIN_NAME_);

            $button .= '<progress class="sq_post_progress" max="' . $post->tasks . '" value="' . $post->tasks_completed . '" title="' . $title . '"></progress>';
        } else {
            $button .= '<progress class="sq_post_progress" max="10" value="1" title="' . esc_html__("Can't get snippet data", _SQ_PLUGIN_NAME_) . '"></progress>';
        }

        $button .= '<a class="sq_column_button" href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo', array('sid=' . $post_id, 'stype=' . $post_type)) . '"  target="_blank">' . esc_html__("Edit Snippet", _SQ_PLUGIN_NAME_) . '</a>';


        return $button;
    }

    /**
     * Show SEO Button
     *
     * @param int $term_id
     * @param string $taxonomy
     * @return string
     */
    public function getTaxButton($term_id = 0, $taxonomy = 'post') {
        $button = '';
        if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->getCurrentSnippet(0, $term_id, str_replace('tax-', '', $taxonomy), '')) {
            $post = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->parsePage($post)->getPage();
            $post->tasks_completed = ($post->tasks_completed ? $post->tasks_completed : 1);
            $completed = number_format(($post->tasks_completed * 100) / $post->tasks, 0);
            $title = esc_html__("Snippet optimized", _SQ_PLUGIN_NAME_) . ': ' . $completed . '%. ' . ($post->tasks - $post->tasks_completed) . ' ' . esc_html__("task(s) remained.", _SQ_PLUGIN_NAME_);

            $button .= '<progress class="sq_post_progress" max="' . $post->tasks . '" value="' . $post->tasks_completed . '" title="' . $title . '"></progress>';
        } else {
            $button .= '<progress class="sq_post_progress" max="10" value="1" title="' . esc_html__("Can't get snippet data", _SQ_PLUGIN_NAME_) . '"></progress>';
        }
        $button .= '<a class="sq_column_button" href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo', array('sid=' . $term_id, 'stype=' . $taxonomy)) . '"  target="_blank">' . esc_html__("Edit Snippet", _SQ_PLUGIN_NAME_) . '</a>';


        return $button;
    }

    public function hookUpdateStatus($post_id) {
        if ($post_id > 0) {
            $status = get_post_status($post_id);

            $args = array();
            $args['status'] = ($status ? $status : 'deleted');
            $args['post_id'] = $post_id;
            $args['referer'] = 'posts';

            SQ_Classes_RemoteController::savePost($args);
        }
    }

}
