<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eveal
 */

?>

<?php
	if ( is_singular() ) : eve_post_thumbnail(); ?>
		<div class="entry-content text-content">
			<?php
			the_content( sprintf( wp_kses( /* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'eve' ),array(
				'span' => array( 'class' => array(),),)), wp_kses_post( get_the_title())));
			wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eve' ), 'after'  => '</div>',
				)) ;
			?>
		</div><!-- .entry-content -->
	<?php else : ?>
		<article class="blog">
			<a href="<?php the_permalink(); ?>" >
				
				<figure class="thumbnail">
					<img src="<?php echo the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>" >
					<figcaption><?php the_title(); ?></figcaption>
				</figure>
				<div class="content text-content">
					<span class="h2"><?php the_title(); ?></span>

					<p></p>
				</div>
			</a>
		</article><!-- #post-<?php the_ID(); ?> -->
	<?php endif; ?>
</div><!-- .entry-header -->

