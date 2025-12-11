<?php
/**
 * Eveal functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Eveal
 */


if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eveal_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Eveal, use a find and replace
		* to change 'eveal' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'eveal', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'eveal' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'eveal_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'eveal_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eveal_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eveal_content_width', 640 );
}
add_action( 'after_setup_theme', 'eveal_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eveal_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'eveal' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'eveal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'eveal_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eveal_scripts() {
    wp_enqueue_style('eveal-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('eveal-style', 'rtl', 'replace');

    wp_enqueue_script(
        'eveal-theme',
        get_template_directory_uri() . '/js/theme.js',
        array(),
        filemtime(get_template_directory() . '/js/theme.js'),
        true
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'eveal_scripts');


// Force theme.js to be loaded as a module
add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if ($handle === 'eveal-theme') {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}, 10, 3);


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*----------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------
Custom Functions
----------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------*/


require get_template_directory() . '/inc/custom_functions.php';
// For admin Use
if ( is_user_logged_in() ) {
	require get_template_directory() . '/inc/acf-sync.php';
	require get_template_directory() . '/inc/custom_functions.php';
}

// Theme Specific
function enqueue_post_css() {
	global $post;
	// Check if $post is set and not null before accessing its properties
	if ( isset( $post ) && is_object( $post ) ) {
		$post_slug = $post->post_name;
		$file_path = get_template_directory_uri(). '/assets/css/generated/post-' . $post_slug . '.css';
		$file_url  = get_template_directory_uri() . '/assets/css/generated/post-' . $post_slug . '.css';
		wp_enqueue_style( 'post-' . $post_slug, $file_url, array(), false );
	}
}
 


function auto_load_css() {

    $css_dir      = get_stylesheet_directory() . '/assets/css/';
    $merged_file  = $css_dir . 'allblocks.css';
    $css_files    = glob($css_dir . '*.css');

    $merged_output = "";

    foreach ($css_files as $file) {
        if (basename($file) === 'allblocks.css') {
            continue; // avoid merging the output file again
        }

        $merged_output .= "/* " . basename($file) . " */\n";
        $merged_output .= file_get_contents($file) . "\n\n";
    }

    // Write merged output to allblocks.css
    file_put_contents($merged_file, $merged_output);

    // Enqueue merged CSS file
    wp_enqueue_style(
        'allblocks',
        get_stylesheet_directory_uri() . '/assets/css/allblocks.css',
        [],
        filemtime($merged_file)
    );
}


if ( is_user_logged_in() ) {
	require get_template_directory() . '/inc/css_generation_dev.php';
}


$dev_mode = get_option('my_dev_mode', 'off'); 
if ( $dev_mode == 'on' ) {
	add_action('wp_enqueue_scripts', 'auto_load_css');
}
add_action( 'wp_enqueue_scripts', 'enqueue_post_css' );
 

/*-------- Regenerate All CSS ------------*/

add_action('admin_bar_menu', function($wp_admin_bar) {

    if ( ! current_user_can('manage_options') ) {
        return;
    }

    $dev_mode = get_option('my_dev_mode', 'off'); // Default OFF
    $label    = ($dev_mode === 'on') ? 'Dev Mode: ON' : 'Dev Mode: OFF';
    $toggle   = ($dev_mode === 'on') ? 'off' : 'on';

    $wp_admin_bar->add_node([
        'id'    => 'my-dev-mode-toggle',
        'title' => $label,
        'href'  => wp_nonce_url(admin_url('?toggle_dev_mode=' . $toggle), 'toggle_dev_mode'),
        'meta'  => ['class' => 'my-dev-mode-toggle']
    ]);

}, 100);

add_action('init', function() {

    if ( ! isset($_GET['toggle_dev_mode']) ) {
        return;
    }

    if ( ! current_user_can('manage_options') ) {
        return;
    }

    check_admin_referer('toggle_dev_mode');

    $new_val = ($_GET['toggle_dev_mode'] === 'on') ? 'on' : 'off';

    update_option('my_dev_mode', $new_val);

    wp_redirect(remove_query_arg(['toggle_dev_mode', '_wpnonce']));
    exit;
});
 
/**
 * Generate CSS for ALL posts & pages
 * and delete unused CSS files based on post-slug.css format
 */
function cg_generate_all_pages_css() {

    $css_dir = get_stylesheet_directory() . '/assets/css/generated/';

    // Ensure directory exists
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }

    // Get all pages + posts
    $posts = get_posts([
        'post_type'      => ['page', 'post'],
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);

    if (empty($posts)) {
        return 0;
    }

    /**
     * 1. Generate CSS for each post
     */
    $valid_files = [];

    foreach ($posts as $post) {

        $slug = $post->post_name;

        // expected file format
        $filename = "post-{$slug}.css";

        $valid_files[] = $filename;

        // your generator function must also save as post-slug.css
        generate_post_css_file($post->ID);
    }

    /**
     * 2. Cleanup: remove any css file NOT in $valid_files
     */
    $all_css_files = glob($css_dir . '*.css');

    if (!empty($all_css_files)) {
        foreach ($all_css_files as $file_path) {

            $basename = basename($file_path);

            // If not in valid list → delete
            if (!in_array($basename, $valid_files, true)) {
                unlink($file_path);
            }
        }
    }

    return count($posts);
}


/**
 * Add Regenerate Button to WP Admin Bar
 */
add_action('admin_bar_menu', 'cg_register_adminbar_button', 100);
function cg_register_adminbar_button($admin_bar) {

    if (!current_user_can('manage_options')) {
        return;
    }

    $nonce = wp_create_nonce('cg-generate-css');

    $link = add_query_arg(
        [
            'cg_generate_all_css' => 1,
            'cg_nonce'            => $nonce,
        ],
        admin_url()
    );

    $admin_bar->add_node([
        'id'    => 'cg-regenerate-css',
        'title' => __('Regenerate CSS', 'cg'),
        'href'  => $link,
        'meta'  => [
            'title' => __('Generate CSS for all posts and pages', 'cg'),
        ],
    ]);
}


/**
 * Handle CSS regeneration and show notice
 */
add_action('admin_init', 'cg_process_css_regeneration');
function cg_process_css_regeneration() {

    if (!isset($_GET['cg_generate_all_css'])) {
        return;
    }

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have permission to do this.', 'cg'));
    }

    if (!isset($_GET['cg_nonce']) || !wp_verify_nonce($_GET['cg_nonce'], 'cg-generate-css')) {
        wp_die(__('Invalid request. Nonce verification failed.', 'cg'));
    }

    // Generate CSS + cleanup
    $count = cg_generate_all_pages_css();

    set_transient('cg_css_regen_count', $count, 30);

    wp_safe_redirect(remove_query_arg(['cg_generate_all_css', 'cg_nonce']));
    exit;
}


/**
 * Show Admin Notice
 */
add_action('admin_notices', 'cg_css_regen_notice');
function cg_css_regen_notice() {

    $count = get_transient('cg_css_regen_count');

    if ($count === false) {
        return;
    }

    delete_transient('cg_css_regen_count');

    echo '<div class="notice notice-success is-dismissible">
            <p><strong>CSS regenerated for ' . intval($count) . ' posts/pages.</strong><br>
            Unused CSS files were cleaned up.</p>
          </div>';
}


/*-------- Regenerate All CSS Ends ------------*/

/**
*  ACF Option pages
**/
add_action('init', 'register_acf_options_pages');
function register_acf_options_pages() {
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page(array(
            'page_title'    => 'Theme General Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Theme Header Settings',
            'menu_title'    => 'Header',
            'parent_slug'   => 'theme-general-settings',
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Theme Footer Settings',
            'menu_title'    => 'Footer',
            'parent_slug'   => 'theme-general-settings',
        ));
    }
}

// Removing Unwanted defualt Wordpress style and JS
add_action( 'wp_enqueue_scripts', function() {
	wp_dequeue_style( 'global-styles-inline-css' );
    wp_dequeue_style( 'classic-theme-styles' ); 
    wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style('global-styles');
    wp_dequeue_style('global-styles-inline');
    wp_dequeue_style('global-styles-inline-css');
    wp_deregister_style('global-styles');
    wp_deregister_style('global-styles-inline');
    wp_deregister_style('global-styles-inline-css');
}, 100);

add_action( 'init', function() {
    // Disable emoji scripts and styles
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', function( $plugins ) {
        return is_array( $plugins ) ? array_diff( $plugins, [ 'wpemoji' ] ) : [];
    } );
    add_filter( 'emoji_svg_url', '__return_false' );
} );

 