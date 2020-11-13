<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package eveal
 */

get_header();
?>
	<div class="single-blog">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/single-blog', get_post_type() );
		endwhile;
		?>
	</div>
<?php
get_footer();
