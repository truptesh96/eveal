<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package eveal
 */

get_header();
?>

	<div class="page-wrap container">
	<div class="site-main">
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'eveal' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			echo "<div class='blogs grid'>";
			while ( have_posts() ) :
				the_post();
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
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

<?php get_footer();
