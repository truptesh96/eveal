<?php
/**
 * Template part for Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eveal
 *
 * Template Name: Home Template
 */
get_header();
?>

<section class="banner">
    <?php if( have_rows('banner_slide') ): ?>
    <?php while( have_rows('banner_slide') ): 
    the_row(); ?>
        <img src="<?php the_sub_field('banner_image'); ?>" alt=""/>
        <div class="container">
        <div class="banner-content">
            <h2><?php the_sub_field('banner_heading'); ?></h2>
            <p><?php the_sub_field('banner_paragraph'); ?></p>
            
            <?php 
			$link = get_sub_field('banner_button');
			if( $link ): $url = $link['url']; $title = $link['title']; $tar = $link['target'] ? $link['target'] : '_self'; ?>
                <a class="btn" href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $tar ); ?>"><?php echo esc_html( $title ); ?></a>
            <?php endif; ?>
        </div>    
        </div>
    <?php endwhile; ?>
    <?php endif; ?>
</section>

<section class="about-us">
    <div class="container dgrid tab-col2">
        <div class="content">
            <?php the_field('about_us_description'); ?>
        </div>
        <figure>
            <img src='' alt="" >
        </figure>
    </div>
</section>

<section class="reviews">
    <div class="container">
    
    </div>
</section>



<script>
jQuery(function($){
	$(window).ready(function(){
		$('.icn-sdown').click(function(){ var target = '.'+$(this).attr('data-scroll');
			$('html, body').animate({ scrollTop: $(target).offset().top }, 1000);
		});
	});
});
</script>
<?php get_footer(); ?>