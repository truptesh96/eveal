<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eveal
 */

get_header();
?>

<!-- Baner Slides -->

<!-- Baner Slides Ends -->

<section class="text-content">
	<div class="wrapper">
		<?php the_content(); ?>
	</div>
</section>


<?php get_footer(); 