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
	wp_enqueue_style( 'eveal-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'eveal-theme', get_stylesheet_directory_uri()."/dest/theme.css", array(), _S_VERSION );
    wp_enqueue_script('jquery');


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



// Hook into post update or publish
add_action('save_post', 'generate_post_css_file');

function generate_post_css_file($post_id) {
    // Ensure it's not an auto-save or a revision
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    } 
	
    // Define the path to save the CSS file
    $upload_dir = wp_upload_dir();
    $css_dir = get_stylesheet_directory_uri(). '/gen-css/';
    $css_file = $css_dir . 'post' . $post_id . '.css';

    // Create the directory if it doesn't exist
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }

    // Start CSS output
    $dynamic_css = "";

    // Loop through ACF flexible content fields
    if( have_rows('flexible_sections', $post_id) ):
        while( have_rows('flexible_sections', $post_id) ): the_row();
             
            $section_id = 'section_' . get_row_index();
			

        endwhile;
    endif;
	
	// minification of css
	$dynamic_css = preg_replace('/\s+/', '', $dynamic_css);

    // Save the CSS content to the file
    file_put_contents($css_file, $dynamic_css);

}

// Enqueue the dynamically generated CSS for a specific post
add_action('wp_enqueue_scripts', 'enqueue_post_css');

function enqueue_post_css() {
   
	global $post;
	$post_id = $post->ID;
	$upload_dir = wp_upload_dir();
	$css_file_url = get_stylesheet_directory_uri(). '/gen-css/post' . $post_id . '.css';

	// Only enqueue if the CSS file exists
	if (file_exists($upload_dir['basedir'] . '/assets/css/post' . $post_id . '.css')) {
		wp_enqueue_style('post' . $post_id, $css_file_url);
		// wp_enqueue_style('page' . $post_id, $css_file_url);
	}
   
}

 
// AJAX handler for load more functionality
add_action('wp_ajax_load_more_admin_a9a4e8088_t0bk5i', 'load_more_admin_a9a4e8088_t0bk5i_handler');
add_action('wp_ajax_nopriv_load_more_admin_a9a4e8088_t0bk5i', 'load_more_admin_a9a4e8088_t0bk5i_handler');

function load_more_admin_a9a4e8088_t0bk5i_handler() {
    // Verify nonce for security
    check_ajax_referer('load_more_admin_a9a4e8088_t0bk5i_nonce', 'nonce');

    $page = intval($_POST['page']);

    $query_args = array(
        'post_type' => 'property',
        'posts_per_page' => 6,
        'paged' => $page,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );

    $query = new WP_Query($query_args);

    ob_start();
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <article class="admin_a9a4e8088_t0bk5i-post-item" data-post-id="<?php echo get_the_ID(); ?>">
                <div class="admin_a9a4e8088_t0bk5i-post-content">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="admin_a9a4e8088_t0bk5i-post-thumbnail">
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="admin_a9a4e8088_t0bk5i-post-details">
                        <h3 class="admin_a9a4e8088_t0bk5i-post-title">
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php echo esc_html(get_the_title()); ?>
                            </a>
                        </h3>

                        <div class="admin_a9a4e8088_t0bk5i-post-meta">
                            <span class="admin_a9a4e8088_t0bk5i-post-date"><?php echo get_the_date(); ?></span>
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) :
                                ?>
                                <span class="admin_a9a4e8088_t0bk5i-post-categories"><?php echo esc_html($categories[0]->name); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="admin_a9a4e8088_t0bk5i-post-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 20); ?>
                        </div>
                    </div>
                </div>
            </article>
            <?php
        endwhile;
    endif;
    wp_reset_postdata();

    $html = ob_get_clean();

    wp_send_json_success(array(
        'html' => $html,
        'has_more' => $page < $query->max_num_pages
    ));
}
