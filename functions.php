<?php
/**
 * eveal functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package eveal
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'eveal_setup' ) ) :
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
		 * If you're building a theme based on eveal, use a find and replace
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
endif;
add_action( 'after_setup_theme', 'eveal_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eveal_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
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
			'before_widget' => '<section id="%1$s" class="sidebar widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'eveal_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eveal_scripts() {
	wp_enqueue_style( 'eveal-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'eveal-style', 'rtl', 'replace' );
	wp_enqueue_script( 'eveal-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eveal_scripts' );

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

/*---- Include Jquery -----*/
wp_enqueue_script("jquery");


/*Remove empty paragraph tags from the_content*/
function paragraphFilter($content) {
    $content = str_replace("<p>&nbsp</p>","",$content);
    return $content;
}

add_filter('the_content', 'paragraphFilter');


/*------------------- Creating Custom Post without Plugin -----------------------*/
/* 
	Step1: Create CPT for News
	Step2: 
*/

function our_team() {
  $labels = array(
    'name'               => _x( 'Team', 'post type general name' ),
    'singular_name'      => _x( 'Team', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'Member' ),
    'add_new_item'       => __( 'Add New Member' ),
    'edit_item'          => __( 'Edit Member' ),
    'new_item'           => __( 'New Member' ),
    'all_items'          => __( 'Our Team' ),
    'view_item'          => __( 'View Team' ),
    'search_items'       => __( 'Search Team' ),
    'not_found'          => __( 'No Member found' ),
    'not_found_in_trash' => __( 'No Member found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Our team'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => '',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'thumbnail', 'excerpt', 'comments', 'custom_fields' ),
    'has_archive'   => true,
  );
  register_post_type( 'Team', $args ); 
}
add_action( 'init', 'our_team' );


function taxonomies_News() {
  $labels = array(
    'name'              => _x( 'News Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'News Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search News Categories' ),
    'all_items'         => __( 'All News Categories' ),
    'parent_item'       => __( 'Parent News Category' ),
    'parent_item_colon' => __( 'Parent News Category:' ),
    'edit_item'         => __( 'Edit News Category' ), 
    'update_item'       => __( 'Update News Category' ),
    'add_new_item'      => __( 'Add New News Category' ),
    'new_item_name'     => __( 'New News Category' ),
    'menu_name'         => __( 'News Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'article' , 'news', $args );
}
add_action( 'init', 'taxonomies_News', 0 );
/*------------------- Creating Custom Post without Plugin Ends -----------------------*/


/*--------------------------- Code For Upcoming future posts ---------------*/
function wpb_upcoming_posts() { 
    $the_query = new WP_Query(array( 
        'post_status' => 'future',
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'ASC'
    ));
 if ( $the_query->have_posts() ) {
    echo '<ul>';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $output .= '<li>' . get_the_title() .' ('.  get_the_time('d-M-Y') . ')</li>';
    }
    echo '</ul>';
} else { $output .= 'No Future Posts'; }
wp_reset_postdata(); return $output; }
add_shortcode('upcoming_posts', 'wpb_upcoming_posts');
add_filter('widget_text', 'do_shortcode');
/*----------------- Code For Upcoming future posts Ends -----------------*/

/*-------------------- Shortcode with Argument -------------------*/
function latestPosts($atts){
   extract(shortcode_atts(array(
      'posts' => 1,
   ), $atts));
   $return_string = '<ul>';
   query_posts(array('orderby' => 'date', 'order' => 'DESC' , 'showposts' => $posts));
   if (have_posts()) :
      while (have_posts()) : the_post();
        $return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
      endwhile;
   endif;
   $return_string .= '</ul>';
   wp_reset_query();
   return $return_string;
}
add_shortcode('latest-posts', 'latestPosts');
/*--------- Application [recent-posts posts="5"] --------*/
/*-------------------- Shortcode with Argument Ends -------------------*/

/*--------------- Get Categories Post with Shortcodes -----------------*/
function catPosts($atts){
   extract(shortcode_atts(array( 'categoryId' => 1, 'posts' => 1), $atts));
   $return_string = '<ul>';
   query_posts(array('orderby' => 'date', 'order' => 'DESC' , 'cat' => $categoryId,'showposts' => $posts ));
	if (have_posts()) :
      while (have_posts()) : the_post();
        $return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
      endwhile;
   endif;
   $return_string .= '</ul>';
   wp_reset_query();
   return $return_string;
}
add_shortcode('category-posts', 'catPosts');
/*--------------- Get Categories Post with Shortcodes Ends -----------------*/



/* Theme Option Custom Fields */
if(function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Custom Code Snippets Settings',
		'menu_title'	=> 'Custom Code Snippets',
		'parent_slug'	=> 'theme-general-settings',
		'redirect'		=> false
	));
    
    acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'parent_slug'	=> 'theme-general-settings',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Mobile Navigation',
		'menu_title'	=> 'Mobile Main Navigation',
		'parent_slug'	=> 'theme-general-settings',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Inner Page Settings',
		'menu_title'	=> 'Inner Page',
		'parent_slug'	=> 'theme-general-settings',
		'redirect'		=> false
	));
}
/* Theme Option Custom Fields Ends */


/*-------- Header Hook --------*/
function addStyle(){
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/fonts/icons.css">';
}
add_action('wp_head', 'addStyle');



/*---------- Remove All empty Paragraphs from Content of the Posts ----------*/
add_filter('the_content', 'contentFilter', 20, 1);
function contentFilter($content){
    $content = force_balance_tags($content);
    return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
}

/*---------- Creating Custom Endpoints for WP REST APi ---------*/
function vt_posts(){

	$category = $_GET['category'];
	if(isset($category)){
		$args = ['post_status' => 'publish', 'posttype' => 'posts',
		'category_name' => $category ];
	}else{
		$args = ['post_status' => 'publish', 'posttype' => 'posts'];	
	}

	$posts = get_posts($args);
	$data = [];
	$i = 0;

	function cats($n){ return get_cat_name($n -> cat_ID); }

	foreach($posts as $post) {
		$data[$i]['title'] = $post->post_title.' '.$slice;
		$data[$i]['url'] = get_permalink($post->ID);
		$data[$i]['thumbnail'] = get_the_post_thumbnail_url($post->ID);
		$data[$i]['content'] = wp_strip_all_tags($post->post_content, $remove_breaks = true);
		$data[$i]['Categories'] = array_map('cats', get_the_category($post->ID));
		$i++;
	}
	return $data;
}

add_action('rest_api_init', function(){
	register_rest_route('vt/v1','posts',[ 'methods' => 'GET', 'callback' => 'vt_posts' ]);
});


/*--------- Disable woocommerce all styleseets ----------*/
add_filter( 'woocommerce_enqueue_styles', '__return_false' );