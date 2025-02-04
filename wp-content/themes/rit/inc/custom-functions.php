<?php 
// Hook into post update or publish
add_action('save_post', 'generate_post_css_file');

function generate_post_css_file($post_id) {
    // Ensure it's not an auto-save or a revision
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }
	
    // Define the path to save the CSS file
    $upload_dir = wp_upload_dir();
    $css_dir = $upload_dir['basedir'] . '/assets/css/';
    $css_file = $css_dir . 'post' . $post_id . '.css';

    // Create the directory if it doesn't exist
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }

    // // Start CSS output
    // $dynamic_css = "";

    // // Loop through ACF flexible content fields
    // if( have_rows('flexible_content', $post_id) ):
    //     while( have_rows('flexible_content', $post_id) ) { the_row();
    //     	$section_id =  get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_' . get_row_index();
           
	// 		/*-- Bg Color --*/
	// 		    $section_background = get_sub_field('section_bg_color');
    //             $padding_top_mobile = get_sub_field('padding_top_mobile');
	// 		    $dynamic_css .= "
	// 		        #{$section_id} {
    //                     if($section_background) {
    //                         background-color: {$section_background};
    //                     }

    //                     if($padding_top_mobile) {
    //                         padding-top: {$padding_top_mobile}px;
    //                     }
                         
    //                 }                       
	// 		    ";
			
    //     }
    // endif;

   // Start CSS output
    $dynamic_css = "";

    // Loop through ACF flexible content fields
    if (have_rows('flexible_content', $post_id)):
        while (have_rows('flexible_content', $post_id)) {
            the_row();

            // Get section ID
            $section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_' . get_row_index();

            // Mobile CSS Fields
            $fields = [
                'section_bg_color' => 'background-color',
                'padding_top_mobile' => 'padding-top',
            ];

            // Start mobile section CSS
            $css_properties = [];
            foreach ($fields as $field_key => $css_property) {
                $field_value = get_sub_field($field_key);
                if ($field_value) {
                    $unit = strpos($css_property, 'padding') !== false ? 'px' : '';
                    $css_properties[] = "{$css_property}: {$field_value}{$unit};";
                }
            }

            if (!empty($css_properties)) {
                $dynamic_css .= "#{$section_id} {" . implode(' ', $css_properties) . "} ";
            }

            // Tablet CSS Fields
            $tabletfields = [
                'padding_top_tablet' => 'padding-top',
                'padding_bottom_tablet' => 'padding-bottom',
            ];

            $css_properties = [];
            foreach ($tabletfields as $field_key => $css_property) {
                $field_value = get_sub_field($field_key);
                if ($field_value) {
                    $unit = strpos($css_property, 'padding') !== false ? 'px' : '';
                    $css_properties[] = "{$css_property}: {$field_value}{$unit};";
                }
            }

            if (!empty($css_properties)) {
                $dynamic_css .= "@media (min-width: 768px) { #{$section_id} {" . implode(' ', $css_properties) . "} } ";
            }

            // Desktop CSS Fields
            $desktopfields = [
                'padding_top_desktop' => 'padding-top',
                'padding_bottom_desktop' => 'padding-bottom',
            ];

            $css_properties = [];
            foreach ($desktopfields as $field_key => $css_property) {
                $field_value = get_sub_field($field_key);
                if ($field_value) {
                    $unit = strpos($css_property, 'padding') !== false ? 'px' : '';
                    $css_properties[] = "{$css_property}: {$field_value}{$unit};";
                }
            }

            if (!empty($css_properties)) {
                $dynamic_css .= "@media (min-width: 1281px) { #{$section_id} {" . implode(' ', $css_properties) . "} } ";
            }
        }
    endif;

    // Optional: Minify CSS for output
    $dynamic_css = preg_replace('/\s+/', ' ', $dynamic_css);


    // Save the CSS content to the file
    file_put_contents($css_file, $dynamic_css);
}

// Enqueue the dynamically generated CSS for a specific post
add_action('wp_enqueue_scripts', 'enqueue_post_css');

function enqueue_post_css() {
   
	global $post;
	if($post):
	$post_id = $post->ID;
	$upload_dir = wp_upload_dir();
	$css_file_url = $upload_dir['baseurl'] . '/assets/css/post' . $post_id . '.css';

	// Only enqueue if the CSS file exists
	if (file_exists($upload_dir['basedir'] . '/assets/css/post' . $post_id . '.css')) {
		wp_enqueue_style('page' . $post_id, $css_file_url);
	}
	
	endif;
   
}

?>