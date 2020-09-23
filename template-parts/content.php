<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eveal
 */
?>
<?php if ( !is_singular() ) : ?>
<article class="blog">
	<a href="<?php echo get_permalink(); ?>" rel="bookmark">
		
		<?php if( has_post_thumbnail() ) { the_post_thumbnail( 'medium' ); }else{ ?>
		<img src='<?php echo get_template_directory_uri()."/img/dummy-mobile.png"; ?>' alt="">
		<?php } ?>

		<h2><?php echo the_title(); ?></h2>
		<p><?php echo the_excerpt(); ?></p>
	</a>
</article>
<?php else: ?>
<article>
	<h1><?php echo the_title(); ?></h1>
	<div class="entry-content">
		<?php
		the_content( sprintf( wp_kses(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'eveal' ),
			array(
				'span' => array( 'class' => array(), ),
			)),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eveal' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
	<footer class="entry-footer">
		<?php eveal_entry_footer(); ?>
	</footer>
</article>
<?php endif ?>