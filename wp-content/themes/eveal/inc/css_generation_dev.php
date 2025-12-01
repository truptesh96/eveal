<?php

add_action('wp_after_insert_post', 'generate_post_css_file');
function generate_post_css_file($post_id) {

    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }

    $post_type = get_post_type($post_id);
    if ($post_type !== 'page') {
        return;
    }

    $post_slug = get_post_field('post_name', $post_id);

    // Correct theme directory path
    $css_dir  = get_stylesheet_directory() . '/assets/css/generated/';
    $css_file = $css_dir . 'post-' . $post_slug . '.css';

    // Ensure directory exists
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }

    $sections = [];
    $used_blocks = [];

    // Helper
    $has_value = function($v) {
        return $v !== '' && $v !== null && $v !== false;
    };

    if (have_rows('flexible_content', $post_id)) {
        while (have_rows('flexible_content', $post_id)) {
            the_row();

            $section_id = get_sub_field('sec_id') ?: 'sec_' . get_row_index();
            if (!$section_id) continue;

            // Track used FC blocks
            $layout = get_row_layout();
            if ($layout) {
                $used_blocks[$layout] = true;
            }

            $sections[$section_id] = [
                'base'   => [],
                '768px'  => [],
                '1200px' => [],
                '1400px' => [],
            ];

            // Base
            if ($has_value($bg = get_sub_field('sec_bg_color'))) {
                $sections[$section_id]['base'][] = "--bg-color:{$bg};";
            }

            if ($has_value($color = get_sub_field('section_text_color'))) {
                $sections[$section_id]['base'][] = "--color:{$color};";
            }

            if ($has_value($pt = get_sub_field('sec_top_mobile'))) {
                $sections[$section_id]['base'][] = "--pt:{$pt}px;";
            }

            if ($has_value($pb = get_sub_field('sec_btm_mobile'))) {
                $sections[$section_id]['base'][] = "--pb:{$pb}px;";
            }

            if ($has_value($bg = get_sub_field('mobile_background'))) {
                $sections[$section_id]['base'][] = "background:{$bg};";
            }

            // Tablet
            if ($has_value($pt = get_sub_field('sec_top_tablet'))) {
                $sections[$section_id]['768px'][] = "--pt:{$pt}px;";
            }

            if ($has_value($pb = get_sub_field('sec_btm_tablet'))) {
                $sections[$section_id]['768px'][] = "--pb:{$pb}px;";
            }

            // Desktop
            if ($has_value($pt = get_sub_field('sec_top_desktop'))) {
                $sections[$section_id]['1200px'][] = "--pt:{$pt}px;";
            }

            if ($has_value($pb = get_sub_field('sec_btm_desktop'))) {
                $sections[$section_id]['1200px'][] = "--pb:{$pb}px;";
            }
        }
    }

    /* ---------------------------------------------
       Build section CSS
    --------------------------------------------- */
    $css = "";

    foreach ($sections as $id => $rules) {

        if (!empty($rules['base'])) {
            $css .= "#{$id}{" . implode('', $rules['base']) . "}\n";
        }

        foreach (['768px','1200px','1400px'] as $bp) {
            if (!empty($rules[$bp])) {
                $css .= "@media (min-width: {$bp}) { #{$id}{" . implode('', $rules[$bp]) . "} }\n";
            }
        }
    }


    $dev_mode = get_option('my_dev_mode', 'off');
    $block_css = "";
    if ( $dev_mode != 'on' ) {
        /* ------- Merge block CSS --------------- */
        

        foreach ($used_blocks as $block_slug => $val) {
            $file_path = get_stylesheet_directory() . "/assets/css/{$block_slug}.css";

            if (file_exists($file_path)) {
                $block_css .= "\n/* Block: {$block_slug} */\n";
                $block_css .= file_get_contents($file_path) . "\n";
            }
        }
    }

    $final_css = $block_css . "\n" . $css;



    // Save CSS
    file_put_contents($css_file, $final_css);
}



/**
 * Delete CSS file when page is deleted
 */
add_action('before_delete_post', 'delete_post_css_file');
function delete_post_css_file($post_id) {

    if (get_post_type($post_id) !== 'page') return;

    $post_slug = get_post_field('post_name', $post_id);
    $css_file  = get_stylesheet_directory() . '/assets/css/generated/post-' . $post_slug . '.css';

    if (file_exists($css_file)) {
        unlink($css_file);
    }
}


/**
 * Delete CSS file when page is trashed
 */
add_action('wp_trash_post', 'trash_post_css_file');
function trash_post_css_file($post_id) {

    if (get_post_type($post_id) !== 'page') return;

    $post_slug = get_post_field('post_name', $post_id);
    $css_file  = get_stylesheet_directory() . '/assets/css/generated/post-' . $post_slug . '.css';

    if (file_exists($css_file)) {
        unlink($css_file);
    }
}
