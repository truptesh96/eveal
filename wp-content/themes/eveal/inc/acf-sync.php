<?php 
function custom_acf_json_save_paths( $paths, $post ) {
    if ( $post['title'] === 'Theme Settings' ) {
        $paths = array( get_stylesheet_directory() . '/options-pages' );
    }

    if ( $post['title'] === 'Theme Settings Fields' ) {
        $paths = array( get_stylesheet_directory() . '/field-groups' );
    }

    return $paths;
}
add_filter( 'acf/json/save_paths', 'custom_acf_json_save_paths', 10, 2 );