<?php
/**
 * Template part for Contact page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eveal
 *
 * Template Name: Contact Template
 */
get_header();
?>

<section class="contactPage paddTb72">
	
	<div class="wrapper">
		<div class="left anim toLeft xtabWid40">
			<h1><?php the_title(); ?></h1>
			<img class="worldMap" src="<?php echo get_template_directory_uri(); ?>/imgs/world-map.svg" alt="wordld-map">
			<?php echo do_shortcode('[contact-form-7 id="62" title="Contact form"]'); ?>
		</div>
		<div class="right anim toReft xtabWid60">

		</div>
	</div>

</section>


<?php get_footer(); ?>