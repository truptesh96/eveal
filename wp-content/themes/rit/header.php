<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rit
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'rit' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="wrap dflex spaceBetween vCenter">
		<div class="site-branding">
			<a class="rigid" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Home"  rel="home">
				<?php the_custom_logo(); ?>
			</a>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menuToggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'rit' ); ?></button>
			<?php
				// wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'menu_class' => 'navig', ) );
			?>

			<?php get_template_part( 'template-parts/content', 'sitemenu' ); ?>


		</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	