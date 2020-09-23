<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package eveal
 */

get_header();
?>

<div class="page-wrap container">
	<div class="site-main">
		<section class="error-404 not-found">
			<header class="page-header align-center">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'eveal' ); ?></h1>
				<h5><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'eveal' ); ?></h5>
			</header><!-- .page-header -->
		</section><!-- .error-404 -->
	</div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?> 