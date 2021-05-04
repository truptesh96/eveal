<?php
/**
 * The Home Page for our theme
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eveal
 */

get_header();
?>

<!-- Baner Slides -->
<?php if( have_rows('banner_slides') ) : ?>
	<section class="hero-banner sslider anim <?php the_field('slider_style'); ?>">
		<div class="swiper-wrapper">
		<?php while ( have_rows('banner_slides') ) : the_row(); ?>
		<div class="swiper-slide">
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
								<a href="<?php echo esc_url( $link_url ); ?>" class="button" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
								<?php endif; ?>
						<?php endwhile; ?>
					</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
		<?php endwhile; ?>
		</div>
		<div class="swiper-nav"></div>
		<span class="swiper-arrow next"></span>
		<span class="swiper-arrow prev"></span>
	</section>
<?php endif; ?>
<!-- Baner Slides Ends -->

<!-- About Section -->
<section class="about-home paddTb72" id="about">
	<div class="wrapper">
		<div class="dflex wrap vcenter">
			<div class="left text-content xtabWid40 toRight anim">
				<h2><?php the_field('about_section_heading'); ?></h2>
				<p class="f30"><?php the_field('about_section_description'); ?></p>
				<?php 
					$link = get_field('about_page_link');
					if( $link ): 
					    $link_url = $link['url'];
					    $link_title = $link['title'];
					    $link_target = $link['target'] ? $link['target'] : '_self';
					    ?>
					<a href="<?php echo esc_url( $link_url ); ?>" class="arrow-link" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php endif; ?>
			</div>
			<div class="right anim toLeft xtabWid60">
				<div class="dflex wrap">
					<div class="vision xmobCol2 anim toTop">
						<?php $about_img = get_field('about_vision_image'); if( !empty( $about_img ) ) : ?>
						<figure>
							<figcaption><?php the_field('about_vision_heading'); ?></figcaption>
							<p><?php the_field('about_vision_description'); ?></p>
							<img class="fit" src="<?php echo $about_img['url']; ?>" alt="<?php echo esc_attr($about_img['alt']); ?>" >
						</figure>
						<?php endif; ?>
					</div>
					<div class="mission xmobCol2 anim toBottom">
						<?php $about_img = get_field('about_mission_image'); if( !empty( $about_img ) ) : ?>
						<figure>
							<img class="fit" src="<?php echo $about_img['url']; ?>" alt="<?php echo esc_attr($about_img['alt']); ?>" >
							<figcaption><?php the_field('about_mission_heading'); ?></figcaption>
							<p><?php the_field('about_mission_description'); ?></p>
						</figure>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- About Section Ends -->


<!-- Services Section -->
<?php if( have_rows('home_services') ) : ?>
<section class="services paddTb100" id="services">
	<h2 class="paddTb40 upCase textCenter">Our Services</h2>
	<div class="wrapper">
		<div class="servicesWrap dflex wrap">
		<?php while ( have_rows('home_services') ) : the_row(); ?>
			<div class="service tabCol2 xxtabCol3 hoverCursor anim toTop" onclick="window.location = '<?php the_sub_field("service_link"); ?>'" >
				<?php $service_image = get_sub_field('service_image'); if( !empty( $service_image ) ) : ?>
					<picture>
					  	<source media="(max-width:768px)" srcset="<?php echo $service_image['sizes']['medium_large']; ?>" alt="<?php echo esc_attr($service_image['alt']); ?>">
					  	<source media="(max-width:1024px)" srcset="<?php echo $service_image['sizes']['large']; ?>" alt="<?php echo esc_attr($service_image['alt']); ?>">
					  	<source media="(min-width:1025px)" srcset="<?php echo $service_image['url']; ?>" alt="<?php echo esc_attr($service_image['alt']); ?>">
					  <img src="<?php echo $service_image['url']; ?>" alt="<?php echo esc_attr($service_image['alt']); ?>" >
					</picture>
				<?php endif; ?>
				<div class="content">
					<h3 class="h4 title"><?php the_sub_field("service_name"); ?></h3>
					<p><?php the_sub_field("service_description"); ?></p>
				</div>
			</div>
		<?php endwhile; ?>			
		</div>
	</div>
</section>
<?php endif; ?>
<!-- Services Section Ends -->

<!-- Portfolio Section -->
<?php if( have_rows('testimonials') ) : ?>
<section class="testimonials paddTb100" id="testimonials">
	<div class="wrapper">
		<div class="reviewsWrap zigzagRows dflex wrap vcenter">
			<div class="left tabCol2">
				<div class="sslider">
	   				<div class="swiper-wrapper">
						<?php while ( have_rows('testimonials') ) : the_row(); ?>
							<div class="testimonial anim swiper-slide anim toTop">
								<h3 class="h4 quote"><?php the_sub_field('testimonial_text'); ?></h3>
								<p><?php the_sub_field('testimonial_author'); ?> - <?php the_sub_field('testimonial_author_designation'); ?></p>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
			<div class="right tabCol2 anim toLeft">
				<h2><?php the_field('testimonials_section_title'); ?></h2>
				<p><?php the_field('testimonials_section_text'); ?></p>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
<!-- Portfolio Section Ends -->

<script type="text/javascript">

	var swiper = new Swiper('.sslider', { pagination: { el: '.swiper-nav', clickable: true, }, navigation: {
    nextEl: '.swiper-arrow.next', prevEl: '.swiper-arrow.prev', }, loop: false, autoplay: { delay: 3000, disableOnInteraction: true, }, });

</script>


<?php get_footer(); 