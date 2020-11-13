<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eveal
 */

get_header();
?>

	<div class="page-wrap container has-sidebar">
	<div class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			echo "<div class='blogs dgrid tab-col2'>";
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;
			echo "</div>";
			the_posts_pagination( array( 'prev_text' => 'prev', 'next_text' => 'next'));

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
    </div>
		
        <?php get_sidebar(); ?>
	</div>
<?php
get_footer();