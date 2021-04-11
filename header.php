<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eveal
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
	

	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css" />
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header class="site-header">
		<div class="wrapper head-wrap">
			<div class="site-branding">
				<?php the_custom_logo(); ?>			
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button aria-label="menu-trigger" class="hamIcon" aria-controls="primary-menu" aria-expanded="false"><span></span></button>
				<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', )); ?>
			</nav><!-- #site-navigation -->
		</div>
	</header>