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
<?php if( have_rows('banner_slides') ) : ?>
	<section class="hero-banner inner sslider anim <?php the_field('slider_style'); ?>">
		<?php while ( have_rows('banner_slides') ) : the_row(); ?>
		<div class="slide">
			<?php $slide_image = get_sub_field('slide_image'); if( !empty( $slide_image ) ) : ?>
			<picture>
			  	<source media="(max-width:768px)" srcset="<?php echo $slide_image['sizes']['medium_large']; ?>" alt="<?php echo esc_attr($slide_image['alt']); ?>">
			  	<source media="(max-width:1024px)" srcset="<?php echo $slide_image['sizes']['large']; ?>" alt="<?php echo esc_attr($slide_image['alt']); ?>">
			  	<source media="(min-width:1025px)" srcset="<?php echo $slide_image['url']; ?>" alt="<?php echo esc_attr($slide_image['alt']); ?>">
			  <img src="<?php echo $slide_image['url']; ?>" alt="<?php echo esc_attr($slide_image['alt']); ?>" >
			</picture>
			<?php endif; ?>
			<div class="wrapper">
				<div class="content">				
					<h2 class="h1"><?php the_sub_field('slide_title'); ?></h2>
					<p><?php the_sub_field('slide_description'); ?></p>
					<?php if( have_rows('slide_ctas') ) : ?>
					<div class="button-wrap">
						<?php while ( have_rows('slide_ctas') ) : the_row(); ?>
							<?php 
								$link = get_sub_field('cta_item');
								if( $link ): 
								    $link_url = $link['url'];
								    $link_title = $link['title'];
								    $link_target = $link['target'] ? $link['target'] : '_self';
								    ?>
								<a href="<?php echo esc_url( $link_url ); ?>" class="dlink" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
								<?php endif; ?>
						<?php endwhile; ?>
					</div>
					<?php endif; ?>

				</div>
			</div> 
		</div>
		<?php endwhile; ?>
	</section>
<?php endif; ?>
<!-- Baner Slides Ends -->

<section class="text-content">
	<div class="wrapper">
		<?php the_content(); ?>
	</div>
</section>


<?php get_footer(); 