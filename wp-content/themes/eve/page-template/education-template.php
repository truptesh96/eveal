<?php
/**
 * Template part for Landing Page Template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpbase
 *
 * Template Name: Educational Flexible Template
 */

get_header();

?>

<div class="landing-content anim">
<?php if( have_rows('flexible_blocks') ): ?>
	<div class="flex-landing">
   	<?php while ( have_rows('flexible_blocks') ) : the_row(); ?>
    
        <?php  if( get_row_layout() == 'landing_page_banner_section'): ?>
        	<!-- Hero Banner Section -->
				<section class="landing-hero-banner" style='background-image:url(<?php the_sub_field('landing_banner_bg_image'); ?>);'
					>
					<div class="landing-wrapper">
						<div class="dflex wrap">
							<div class="left anim left-pull120">
								<h1 class="title fonts114 white-txt"><?php the_sub_field('landing_banner_title'); ?></h1>
								<p class="description fonts23 white-txt"><?php the_sub_field('landing_banner_description'); ?></p>
								<div class="button-wrap">
									<a href="javascript:void(0)" class="button videoTrigger" data-video="<?php the_sub_field('landing_form_video_link'); ?>">
										<span class="video-icon">Play Video</span>
									</a>
								</div>
							</div>
							<div class="right anim">
								
								<div class="formWrapper">
									<p class="dark-blue-txt formTitle fonts34"><?php the_sub_field('landing_banner_form_title'); ?></p>
									<?php echo do_shortcode(get_sub_field("landing_form_shortcode") ); ?>
								</div>
							</div>
						</div>
					</div>
				</section>
			<!-- Hero Banner Section Ends -->
        <?php endif; ?>

        <?php  if( get_row_layout() == 'image_content_two_columns'): ?>
        	<!-- Two Columns Layout Section -->
				<section class="two-columns ">
					<div class="landing-wrapper">
						<?php if(get_sub_field('image_content_two_columns_title')): ?>
							<h2 class="left-pull120 main-heading dark-blue-txt <?php echo (get_sub_field('image_content_two_columns_title_style') == 'medium') ? "fonts43" : "fonts70" ; ?>">
							<?php the_sub_field('image_content_two_columns_title'); ?></h2>
						<?php endif; ?>
						<?php if( have_rows('content_rows') ): ?>
						 <?php while ( have_rows('content_rows') ) : the_row(); ?>
						 <div class="two-cols-row">
							<div class="dflex <?php echo (get_sub_field('image_position') == 'left') ? "wrap" : "wrap swap" ; ?>">
								<figure class="wid50 anim">
									<img src="<?php the_sub_field('two_columns_section_image'); ?>" alt="FST Edu">
								</figure>
								<div class="content wid50 fonts23 anim">
									<?php the_sub_field('two_columns_section_content'); ?>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</section>
			<!-- Two Columns Layout Ends -->
        <?php endif; ?>


        <?php  if( get_row_layout() == 'featured_content_with_image'): ?>
        	<!-- Featured Content With Image Section -->
				<section class="featured-section anim">
					<div class="landing-wrapper">
						<div class="dflex <?php echo (get_sub_field('featured_image_position') == 'left') ? "wrap" : "wrap swap" ; ?>">
							
							<figure class="wid50">
								<img src="<?php the_sub_field('featured_section_image'); ?>" alt="<?php the_sub_field('featured_section_title'); ?>">
							</figure>

							<div class="content wid50 <?php echo (get_sub_field('featured_image_position') == 'left') ? "" : "left-pull120" ; ?>" >
								<?php if(get_sub_field('featured_section_title')): ?>
									<h2 class="title dark-blue-txt fonts70"><?php the_sub_field('featured_section_title'); ?></h2>
								<?php endif; ?>
								<div class="text fonts23"><?php the_sub_field('featured_section_content'); ?></div>
								<?php if( have_rows('promotion_logos') ): ?>
									<div class="logos">
										<?php while ( have_rows('promotion_logos') ) : the_row(); ?>
											<div class="logo">
											<img src="<?php the_sub_field('logo_image'); ?>" alt="FST Edu Promotion Logo">
											</div>
										<?php endwhile; ?>
									</div>
								<?php endif; ?>
								<div class="button-wrap">
									<?php 
										$link = get_sub_field('featured_cta_link');
										if( $link ): 
										    $link_url = $link['url'];
										    $link_title = $link['title'];
										    $link_target = $link['target'] ? $link['target'] : '_self';
										?>
										<a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
									<?php endif; ?>

									<?php 
										$link = get_sub_field('featured_call_link');
										if( $link ): 
										    $link_url = $link['url'];
										    $link_title = $link['title'];
										    $link_target = $link['target'] ? $link['target'] : '_self';
										?>
										<div class="call-link dark-blue-txt fonts23"><span>Call</span><a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</section>
			<!-- Featured Content With Image Section Ends -->
		<?php endif; ?>

        <?php  if( get_row_layout() == 'marketing_section'): ?>
        	<!-- Marketing Section -->
				<section class="marketing-cta anim" style="background-image: url('<?php the_sub_field('marketing_section_background') ?>');">
					<div class="landing-wrapper">
						<div class="content-wrap dflex wrap">
							<div class="content left-pull120">
								<h2 class="cta-title white-txt fonts114"><?php the_sub_field('marketing_section_title') ?></h2>
								<p class="cta-text white-txt fonts23"><?php the_sub_field('marketing_section_description') ?></p>
								<div class="button-wrap">
									<?php 
										$link = get_sub_field('marketing_section__cta_button');
										if( $link ): 
										    $link_url = $link['url'];
										    $link_title = $link['title'];
										    $link_target = $link['target'] ? $link['target'] : '_self';
										?>
										<a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
									<?php endif; ?>

									<?php 
										$link = get_sub_field('marketing_section__call_link');
										if( $link ): 
										    $link_url = $link['url'];
										    $link_title = $link['title'];
										    $link_target = $link['target'] ? $link['target'] : '_self';
										?>
										<div class="call-link white-txt fonts23"><span>Call</span><a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="marketing-logo <?php the_sub_field('marketing_section_logo_position') ?>">
								<img src="<?php the_sub_field('marketing_section_logo') ?>" alt="marketing-logo">
							</div>
						</div>
					</div>
				</section>
			<!-- Marketing Ends -->

        <?php endif; ?>

        <?php  if( get_row_layout() == 'testimonials_slider_section'): ?>
        	<!-- Testimonials Section -->
				<section class="testimonials anim" style="background-image: url('<?php the_sub_field('testimonials_section_background_image') ?>');">
						<?php $testimonials_title = get_sub_field('testimonials_section_title');  ?>
						<?php if( have_rows('testimonial_slides') ): ?>
						<div class="sslider">
							 <?php while ( have_rows('testimonial_slides') ) : the_row(); ?>
							 <div class="test-slide">
							 	<div class="landing-wrapper">
								<div class="dflex wrap">
									<figure class="wid50 left-pull120">
										<?php if( get_sub_field('testimonial_person_image') ): ?>
										<img src="<?php the_sub_field('testimonial_person_image'); ?>" alt="<?php the_sub_field('testimonial_person_name'); ?>">
										<?php endif; ?>
									</figure>
									<div class="content wid50 fonts23">
										<h4 class="section-head white-txt"><?php echo $testimonials_title ?></h4>
										<h2 class="name fonts43 white-txt"><?php the_sub_field('testimonial_person_name'); ?></h2>
										<p class="designation fonts23 white-txt"><?php the_sub_field('testimonial_person_designation'); ?></p>
										<?php if(get_sub_field('testimonial_text')): ?>
											<p class="review fonts23 white-txt"><?php the_sub_field('testimonial_text'); ?></p>
										<?php endif; ?>
									</div>
									</div>
								</div>
							</div>
							<?php endwhile; ?>
						</div>
						<?php endif; ?>					
				</section>
			<!-- Testimonials Ends -->
        <?php endif; ?>


        <?php  if( get_row_layout() == 'team_members_section'): ?>
        	<!-- Team Members Section -->
				<section class="anim team-members" style="background-image: url('<?php the_sub_field('team_members_background') ?>');">
					<div class="landing-wrapper">
						<?php if( have_rows('team_member') ): ?>
							<div class="sslider">
								<?php while ( have_rows('team_member') ) : the_row(); ?>
								<div class="test-slide member">
									<div class="content-wrap dflex wrap">
										<div class="left wid50">
											<figure class="personal" >
												<img class="profile-img" src="<?php the_sub_field('team_members_profile_image') ?>" alt="<?php the_sub_field('team_members_name') ?>" />
												<figcaption class="name white-txt fonts43"><?php the_sub_field('team_members_name') ?></figcaption>
											</figure>

											<?php if(get_sub_field('team_members_designations')) : ?>
												<div class="designation fonts23 white-txt"><?php the_sub_field('team_members_designations') ?></div>
											<?php endif; ?>

											<?php if(get_sub_field('team_members_degrees')) : ?>
												<div class="degrees">
													<h4 class="green-txt fonts23">DEGREES</h4>
													<div class="text fonts23 white-txt">
														<?php the_sub_field('team_members_degrees') ?>
													</div>
												</div>
											<?php endif; ?>

											<?php if(get_sub_field('team_members_specializations')) : ?>
												<div class="specifications">
													<h4 class="green-txt fonts23">SPECIALIZATION</h4>
													<div class="text fonts23 white-txt">
														<?php the_sub_field('team_members_specializations') ?>
													</div>
												</div>
											<?php endif; ?>
										</div>
										
										<div class="right wid50">
											<?php if(get_sub_field('about_team_member')) : ?>
											<div class="white-txt content fonts23">
												<?php the_sub_field('about_team_member') ?>
											</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<?php endwhile; ?>
							</div>
						<?php endif; ?>	
					</div>
				</section>
			<!-- Team Members Ends -->
        <?php endif; ?>


        <?php  if( get_row_layout() == 'cta_section'): ?>
        	<!-- Landing Page Simple CTA Section -->
				<section class="anim landing-cta" style="background-image: url('<?php the_sub_field('cta_background') ?>');">
					<div class="landing-wrapper">
						<div class="content-wrap">
							<h2 class="cta-title white-txt fonts70"><?php the_sub_field('cta_title'); ?></h2>
							<p class="cta-text white-txt fonts23"><?php the_sub_field('cta_description'); ?></p>
							
							<div class="button-wrap">
								<?php 
									$link = get_sub_field('cta_button');
									if( $link ): 
									    $link_url = $link['url'];
									    $link_title = $link['title'];
									    $link_target = $link['target'] ? $link['target'] : '_self';
									?>
									<a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
								<?php endif;?>

								<?php 
									$link = get_sub_field('cta_call_link');
									if( $link ): 
									    $link_url = $link['url'];
									    $link_title = $link['title'];
									    $link_target = $link['target'] ? $link['target'] : '_self';
									?>
									<div class="call-link white-txt fonts23"><span>Call</span><a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
								<?php endif; ?>
							</div>
							</div>
						</div>
				</section>
			<!-- Landing Page Simple CTA Ends -->
        <?php endif; ?>

	<?php endwhile; ?>
	</div>
<?php endif; ?>
</div>

<section class="landing-foot anim">
	<div class="landing-wrapper">
		<a class="footer-logo" href="<?php echo site_url(); ?>"><img src="<?php the_field('landing_footer_logo'); ?>" alt="FSTEDU Logo" /></a>
		
		<address class="footer-text address fonts23"><?php the_field('landing_footer_address'); ?></address>
		
		<div>							    
			<?php 
			$email = get_field('landing_footer_email');
			if( $email ): 
			    $link_url = $email['url'];
			    $link_title = $email['title'];
			    $link_target = $email['target'] ? $email['target'] : '_self';
			?>
			<a class="footer-text email fonts23" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
			<?php endif;?>
		</div>
		<?php 
			$call = get_field('landing_footer_call_link');
			if( $call ): 
			    $link_url = $call['url'];
			    $link_title = $call['title'];
			    $link_target = $call['target'] ? $call['target'] : '_self';
			?>
			<a class="footer-text call fonts23" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
			<?php endif;?>
	</div>
</section>

	<!-- Video Popup -->
	<div id="video-modal" class="modal video-modal">
	    <div><div class="modal-close"><span>✕</span></div><div class="embed-container"><iframe src="" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div></div>
	</div>
	<!-- Video Popup Ends -->

<script type="text/javascript">
	
	jQuery(function($){

		$(document).ready(function() {

			/*------------------- Video Popup -------------------*/
			$('.videoTrigger').click(function(){
				$('.modal.video-modal').addClass('active');
				var videoUrl = $(this).attr('data-video');
				$("#video-modal iframe").attr('src',videoUrl);
			});

			$(".modal-close").click(function(){
				$(this).parents('.modal').removeClass('active');
				$("#video-modal iframe").attr('src','');
			});
			/*------------------- Video Popup Ends-------------------*/


		});
	});
</script>

<?php get_footer(); ?>