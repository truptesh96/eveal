<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Eveal
 */

get_header();
?>
<section class="error-404 not-found paddTb100">
	<div class="wrapper">
		<div class="dflex wrap vcenter">

			<div class="left anim toRight tabWid40">
				<img class="error" src="<?php echo get_template_directory_uri(); ?>/imgs/error-page.svg" alt="404 Error">
				<h1 class="page-title"><?php the_field('error_text','option'); ?></h1>
			</div>

			<div class="right anim toLeft tabWid60">
				<h2>Quick Links</h2>

				<?php if( have_rows('error_page_quick_links','option') ) : ?>
				<div class="button-wrap">
					<?php while ( have_rows('error_page_quick_links','option') ) : the_row(); ?>
						<?php 
							$link = get_sub_field('quick_link','option');
							if( $link ): 
							    $link_url = $link['url'];
							    $link_title = $link['title'];
							    $link_target = $link['target'] ? $link['target'] : '_self';
							    ?>
							<a href="<?php echo esc_url( $link_url ); ?>" class="button anim toBottom" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
						<?php endif; ?>
					<?php endwhile; ?>
				</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section><!-- .error-404 -->

<?php
get_footer();
