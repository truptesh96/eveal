<?php
/**
 * Rit functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Rit
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
function rit_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Rit, use a find and replace
		* to change 'rit' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'rit', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'rit' ),
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
			'rit_custom_background_args',
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
add_action( 'after_setup_theme', 'rit_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rit_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rit_content_width', 640 );
}
add_action( 'after_setup_theme', 'rit_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rit_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'rit' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'rit' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'rit_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rit_scripts() {
	wp_enqueue_style( 'rit-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'rit-theme', get_template_directory_uri() . '/dest/css/style.min.css');
	wp_style_add_data( 'rit-style', 'rtl', 'replace' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'rit-slick', get_template_directory_uri() . '/js/slick.min', array(), _S_VERSION, true );
	wp_enqueue_script( 'rit-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script('rit-custom', get_template_directory_uri() . '/js/custom.js', array(), _S_VERSION, true);


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rit_scripts' );

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

/* Adding Custom theme functions */

require_once get_template_directory() . '/inc/custom-functions.php';
 

/*-- Woocommerce Setup --*/
function custom_dequeue_woocommerce_styles() {
    // Dequeue WooCommerce default styles
    wp_dequeue_style('woocommerce-general');   // General WooCommerce styles
    wp_dequeue_style('woocommerce-layout');    // WooCommerce layout styles
    wp_dequeue_style('woocommerce-smallscreen'); // Small screen/responsive styles	
}
add_action('wp_enqueue_scripts', 'custom_dequeue_woocommerce_styles', 20);
 

/* Enqueue Lightbox assets */
function enqueue_lightbox_assets() {
    wp_enqueue_style('lightbox-css', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css');
    wp_enqueue_script('lightbox-js', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_assets');

// Change "Related products" label
add_filter('gettext', 'change_related_products_label', 20, 3);
function change_related_products_label($translated_text, $text, $domain) {
    if ($text === 'Related products' && $domain === 'woocommerce') {
        $translated_text = 'People also buy this together'; // Replace with your desired label
    }
    return $translated_text;
}

add_action( 'woocommerce_single_product_summary', 'add_title_before_rating', 8 );
function add_title_before_rating() {
    global $product;
    echo '<h2 class="productHead" role="presentation" >' . esc_html( $product->get_name() ) . '</h2>';
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );




add_action( 'woocommerce_before_shop_loop_item_title', 'add_first_and_second_images_to_product_loop', 10 );

function add_first_and_second_images_to_product_loop() {
    global $product;

    // Get the first image (featured image)
    $first_image_id = $product->get_image_id();
    $first_image_url = wp_get_attachment_image_url( $first_image_id, 'woocommerce_thumbnail' );

    // Get the second image (from the product gallery)
    $gallery_image_ids = $product->get_gallery_image_ids();
    $second_image_url = isset( $gallery_image_ids[0] ) ? wp_get_attachment_image_url( $gallery_image_ids[0], 'woocommerce_thumbnail' ) : '';

    echo '<div class="product-image">';
	if ( $second_image_url ) {
        echo '<img src="' . esc_url( $second_image_url ) . '" alt="' . esc_attr( $product->get_name() ) . '" class="hover-image">';
    }

    if ( $first_image_url ) {
        echo '<img src="' . esc_url( $first_image_url ) . '" alt="' . esc_attr( $product->get_name() ) . '" class="default-image">';
    } 
    
    echo '</div>';
}


function enqueue_acf_flex_assets() {
    if ( ! function_exists( 'get_field' ) ) { return; }
    global $post;
    if ( have_rows( 'flexible_content', $post->ID ) ) {
        while ( have_rows( 'flexible_content', $post->ID ) ) {
           the_row();
           $layout = get_row_layout();
           $js_file = get_template_directory_uri() . "/js/flex/{$layout}.js";
			if ( file_exists( $js_file ) ) { wp_enqueue_script( "acf-{$layout}",  $js_file ); }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_acf_flex_assets' );



add_filter('gform_webhooks_request_data', 'transform_gravity_forms_payload', 10, 4);

function transform_gravity_forms_payload($request_data, $feed, $entry, $form) {
    // Convert current format to target format
    $lead_data =  $request_data;

    // Wrap the lead data in the "Lead" array
    $target_format = array(
        "Lead" => array($lead_data)
    );

    return $target_format;
}


// Register Custom Post Type: Experiences
function register_experiences_post_type() {
    $labels = array(
        'name'               => _x('Experiences', 'post type general name', 'my-custom-plugin'),
        'singular_name'      => _x('Experience', 'post type singular name', 'my-custom-plugin'),
        'menu_name'          => __('Experiences', 'my-custom-plugin'),
        'name_admin_bar'     => __('Experience', 'my-custom-plugin'),
        'add_new'            => __('Add New', 'my-custom-plugin'),
        'add_new_item'       => __('Add New Experience', 'my-custom-plugin'),
        'new_item'           => __('New Experience', 'my-custom-plugin'),
        'edit_item'          => __('Edit Experience', 'my-custom-plugin'),
        'view_item'          => __('View Experience', 'my-custom-plugin'),
        'all_items'          => __('All Experiences', 'my-custom-plugin'),
        'search_items'       => __('Search Experiences', 'my-custom-plugin'),
        'not_found'          => __('No experiences found.', 'my-custom-plugin'),
        'not_found_in_trash' => __('No experiences found in Trash.', 'my-custom-plugin'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'experiences'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'thumbnail', 'excerpt'),
    );

    register_post_type('experiences', $args);
}
add_action('init', 'register_experiences_post_type');

// Register Taxonomies: Locations and Ratings
function register_experience_taxonomies() {
    // Locations (Hierarchical)
    $location_labels = array(
        'name'              => _x('Locations', 'taxonomy general name', 'my-custom-plugin'),
        'singular_name'     => _x('Location', 'taxonomy singular name', 'my-custom-plugin'),
        'search_items'      => __('Search Locations', 'my-custom-plugin'),
        'all_items'         => __('All Locations', 'my-custom-plugin'),
        'parent_item'       => __('Parent Location', 'my-custom-plugin'),
        'parent_item_colon' => __('Parent Location:', 'my-custom-plugin'),
        'edit_item'         => __('Edit Location', 'my-custom-plugin'),
        'update_item'       => __('Update Location', 'my-custom-plugin'),
        'add_new_item'      => __('Add New Location', 'my-custom-plugin'),
        'new_item_name'     => __('New Location Name', 'my-custom-plugin'),
        'menu_name'         => __('Locations', 'my-custom-plugin'),
    );

    $location_args = array(
        'hierarchical'      => true,
        'labels'            => $location_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'location'),
    );

    register_taxonomy('location', 'experiences', $location_args);

    // Ratings (Non-Hierarchical)
    $rating_labels = array(
        'name'              => _x('Ratings', 'taxonomy general name', 'my-custom-plugin'),
        'singular_name'     => _x('Rating', 'taxonomy singular name', 'my-custom-plugin'),
        'search_items'      => __('Search Ratings', 'my-custom-plugin'),
        'all_items'         => __('All Ratings', 'my-custom-plugin'),
        'edit_item'         => __('Edit Rating', 'my-custom-plugin'),
        'update_item'       => __('Update Rating', 'my-custom-plugin'),
        'add_new_item'      => __('Add New Rating', 'my-custom-plugin'),
        'new_item_name'     => __('New Rating Name', 'my-custom-plugin'),
        'menu_name'         => __('Ratings', 'my-custom-plugin'),
    );

    $rating_args = array(
        'hierarchical'      => true,
        'labels'            => $rating_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'rating'),
    );

    register_taxonomy('rating', 'experiences', $rating_args);
}
add_action('init', 'register_experience_taxonomies');



function update_assigned_hotels_meta($post_id) {
    // Ensure this runs only for 'experiences' post type
    if (get_post_type($post_id) !== 'experiences') {
        return;
    }

    // Define the taxonomy where post IDs should be stored
    $taxonomy = 'location'; // Replace with your actual taxonomy slug
    $meta_key = 'assigned_hotels'; // Meta key to store post IDs

    // Get the terms assigned to this post
    $terms = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'ids'));

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term_id) {
            // Get existing assigned post IDs
            $existing_posts = get_term_meta($term_id, $meta_key, true);

            if (!is_array($existing_posts)) {
                $existing_posts = [];
            }

            // Add the new post ID if it's not already assigned
            if (!in_array($post_id, $existing_posts)) {
                $existing_posts[] = $post_id;
                update_term_meta($term_id, $meta_key, $existing_posts);
            }
        }
    }
}
add_action('save_post_experiences', 'update_assigned_hotels_meta');


function experiences_data_admin_menu() {
    add_menu_page(
        'Experiences Data',  // Page title
        'Experiences Data',  // Menu title
        'manage_options',    // Capability
        'experiences_data',  // Menu slug
        'render_experiences_data_page', // Callback function
        'dashicons-admin-site', // Icon
        20 // Position in menu
    );
}
add_action('admin_menu', 'experiences_data_admin_menu');

function render_experiences_data_page() {
    $location_taxonomy = 'location'; // Taxonomy for locations
    $meta_key = 'assigned_hotels'; // Meta key storing assigned Experience post IDs

    // Get all locations
    $locations = get_terms(array(
        'taxonomy' => $location_taxonomy,
        'hide_empty' => false
    ));

    echo '<div class="wrap">';
    echo '<h1>Experiences Data</h1>';
    echo '<div class="experiences-data-wrapper">';

    if (!empty($locations) && !is_wp_error($locations)) {
        foreach ($locations as $location) {
            echo '<div class="experience-item">';
            echo '<h2 class="location-title">' . esc_html($location->name) . '</h2>';

            // Retrieve experience IDs stored in the term meta
            $experience_ids = get_term_meta($location->term_id, $meta_key, true);

            echo '<div class="experience-section">';

            if (!empty($experience_ids) && is_array($experience_ids)) {
                $experiences = get_posts(array(
                    'post_type' => 'experiences',
                    'post__in' => array_unique($experience_ids),
                    'posts_per_page' => -1
                ));

                if (!empty($experiences)) {
                    echo '<ul class="experience-list">';
                    foreach ($experiences as $exp) {
                        echo '<li>' . $exp->post_title.' <a href="'.get_permalink($exp->ID).'">'. $exp->ID . '</a></li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No Experiences Found</p>';
                }
            } else {
                echo '<p>No Experiences Assigned</p>';
            }

            echo '</div>'; // Close experience-section
            echo '</div>'; // Close experience-item
        }
    } else {
        echo '<p>No Locations Found</p>';
    }

    echo '</div>'; // Close experiences-data-wrapper
    echo '</div>'; // Close wrap

    // Inline CSS for styling (can be moved to a separate admin stylesheet)
    echo '<style>
        .experiences-data-wrapper { display: flex; flex-wrap: wrap; gap: 20px; }
        .experience-item { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px; }
        .location-title { font-size: 20px; margin-bottom: 10px; }
        .experience-section { margin-top: 15px; }
        .experience-list { list-style: disc; margin-left: 20px; }
    </style>';
}
