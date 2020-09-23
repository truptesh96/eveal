<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eveal
 */

?>
<article>
	
	<article class="blog">
	<a href="<?php echo get_permalink(); ?>" rel="bookmark">
		<?php the_post_thumbnail( 'medium' ); ?>
		<h2><?php echo the_title(); ?></h2>
		<p><?php echo the_excerpt(); ?></p>
	</a>
	</article>

</article>