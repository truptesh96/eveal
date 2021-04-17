<?php

/**

 * 
 * @package WordPress
 

 */

global $post;

get_header(); ?>

<section class="single-hero dark-skin page-head load-bg" style="background-color: <?php the_field('text_background_color'); ?>;"
	mobile-bg="<?php the_field('hero_image_mobile'); ?>" desktop-bg="<?php the_field('hero_image'); ?>" >
	<div class="wrapper">
		<div class="content">
		<div class="crumbs">
			<a class="crumb" href="work">Our Work</a>
			<?php 
			 $terms = get_the_terms( $post->ID , 'portfolio-category' );
			if ( $terms != null ){
			 foreach( $terms as $term ) { ?>
			 	<a class="crumb" href="work/?category=<?php echo $term->slug; ?>" title="<?php echo $term->slug; ?>" ><?php echo $term->name; ?></a>
			 <?php unset($term); } } ?>
		</div>
			
		<h1 class="font115"><?php the_field('hero_title'); ?></h1>
		<div class="font40"><?php the_field('hero_text'); ?></div>

		<div class="features">
		 <?php if( have_rows('hero_feature_list_items_column1') ): ?>
			<div class="column font24">
			   <?php while( have_rows('hero_feature_list_items_column1') ): the_row(); ?>
			    	<span><?php the_sub_field('feature'); ?></span>
			   <?php endwhile; ?>
			</div>
		<?php endif; ?>
		<?php if( have_rows('hero_feature_list_items_column2') ): ?>
			<div class="column font24">
			   <?php while( have_rows('hero_feature_list_items_column2') ): the_row(); ?>
			    	<span><?php the_sub_field('feature'); ?></span>
			   <?php endwhile; ?>
			</div>
		<?php endif; ?>
		</div>

		</div>
	</div>
</section>

<section class="the-ask">
	<div class="wrapper">
		<figure><img src="<?php the_field('ask_image'); ?>" alt=""></figure>
		<div class="content left-auto square square-left">
			<h3 class=""><?php the_field('ask_title'); ?></h3>
			<div class="font30"><?php the_field('ask_description'); ?></div>
		</div>
	</div>
</section>

<?php if( get_field('solve_section_visibility') ){ ?>
	<?php $solve_image = get_field('solve_image'); ?>

	<section class="the-solve <?php if($solve_image){ echo "with-image"; } else{ echo "no-image"; } ?>">
	<div class="wrapper">
		<?php if($solve_image){  ?>
			<figure><img src="<?php the_field('solve_image'); ?>" alt=""></figure>
		<?php }  ?>

		<div class="content">
			<h3><?php the_field('solve_title'); ?></h3>
			<div class="font30"><?php the_field('solve_description'); ?></div>
		</div>
	</div>
	</section>
<?php } ?>


<?php if( have_rows('portfolio_rows') ) : ?>
<section class="portfolio-gallery">
	<!-- checking row layout -->
	<?php while( have_rows('portfolio_rows') ): the_row(); ?>
		<?php if( get_row_layout() == 'portfolio_row' ): ?>
		<div class="row">
			<div class="wrapper">
				<div class="<?php the_sub_field('slider_setting'); ?> <?php if( get_sub_field('columns_count') == 'one-column' ){ echo ' single-slider '; }else{ echo 'wrap '; 
				 echo get_sub_field('columns_count'); } ?> ">
					<?php if( have_rows('portfolio_items') ): ?>
						<?php while( have_rows('portfolio_items') ): the_row(); ?>
							<?php $media_type = get_sub_field('media_type'); ?>
							<div class="flex-item <?php echo $media_type; ?> slide">
								<?php if( $media_type == 'video') : ?>

									<?php if( get_sub_field('video_link_url') ): ?>
						    		<a data-fancybox href="<?php the_sub_field('video_link_url'); ?>" class="video_plays_btn"  >
						    			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="75" height="75" viewBox="0 0 75 75">
					                  <defs>
					                    <filter id="np_play_654294_000000" x="0" y="0" width="75" height="75" filterUnits="userSpaceOnUse">
					                     <feComposite operator="in" in2="blur"></feComposite>
					                      <feComposite in="SourceGraphic"></feComposite>
					                    </filter>
					                  </defs>
					                  <g id="np_play_654294_000000-2" data-name="np_play_654294_000000">
					                    <g transform="">
					                      <path id="np_play_654294_000000-3" data-name="np_play_654294_000000" d="M37.5,0A37.5,37.5,0,1,0,64.016,10.984,37.5,37.5,0,0,0,37.5,0ZM49.506,38.514,31.354,49A1.172,1.172,0,0,1,29.6,47.98V27.021A1.172,1.172,0,0,1,31.354,26l18.152,10.48v0a1.17,1.17,0,0,1,0,2.027Z" fill="#fff"></path>
					                      <path id="np_play_hover" data-name="np_play_hover" d="M37.5,0A37.5,37.5,0,1,0,64.016,10.984,37.5,37.5,0,0,0,37.5,0ZM49.506,38.514,31.354,49A1.172,1.172,0,0,1,29.6,47.98V27.021A1.172,1.172,0,0,1,31.354,26l18.152,10.48v0a1.17,1.17,0,0,1,0,2.027Z" fill="#0FA896"></path>
					                    </g>
					                  </g>
					                </svg>
						    			<img class="lazy video_poster" data-src="<?php the_sub_field('port_thumbnail_image'); ?>"
						    			 alt="video-thumbnail">
									</a>
									<?php else: ?>	
										<img class="lazy" data-src="<?php the_sub_field('port_thumbnail_image'); ?>"
						    			 alt="video-thumbnail">
									<?php endif; ?>
									
								<?php elseif ($media_type == 'image') : ?>
									<img class="lazy" data-src="<?php the_sub_field('port_thumbnail_image'); ?>" 
									alt="thumbnail-image">
								<?php endif; ?>
							</div>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	<?php endwhile; ?>
</section>

<?php endif; ?>


<?php if( get_field('testimonial_section_visibility') ){ ?>
<section class="portfolio-feedback feedback-section <?php if(get_field('testimonial_image')){ echo 'with-image'; }else{ echo 'no-image text-center'; } ?>">
	<?php if(get_field('testimonial_image')){ ?>
		<figure><img src="<?php the_field('testimonial_image'); ?>" alt="testimonial-image"></figure>
	<?php } ?>
	<div class="wrapper">
		<div class="content left-auto left-auto-main">
			<div class="quote quote-left"></div>
			<?php if(get_field('testimonial_section_type') == "Testimonial UI" ){ ?>
					<h3><?php the_field('testimonial_title'); ?></h3>
					<div class="font40"><?php the_field('testimonial_text'); ?></div>
					<div class="author_text"><?php the_field('author_text'); ?></div>
			<?php }elseif(get_field('testimonial_section_type') == "Advertisement UI" ){ ?>
				<div class="left-auto adv">
					<h3><?php the_field('advertisement_title'); ?></h3>
					<?php if( have_rows('advertisement_insights') ): ?>
					<div class="insights">
						<?php while( have_rows('advertisement_insights') ): the_row(); ?>
							<h4><?php the_sub_field('insight_item'); ?></h4>
						<?php endwhile; ?>
					</div>
					<?php endif; ?>
					<div class="font40"><?php the_field('advertisement_text'); ?></div>
				</div>
			<?php } ?>
			<div class="quote quote-right"></div>
		</div>
	</div>
</section>
<?php } ?>

<?php if( have_rows('project_list') ): ?>
	<section class="related-projects">
		<div class="wrapper">
			<h4 class="square square-left">Related Projects.</h4>
			<div class="projects-wrap">
			<?php while( have_rows('project_list') ): the_row(); ?>
				<div class="project">
					<figure data-url="<?php the_sub_field('project_url') ; ?>">
				    	<img src="<?php the_sub_field('project_image'); ?>" alt="" />
			    	</figure>
					<div class="content">
				    	<p class="font40"><?php the_sub_field('project_text'); ?></p>
						<a class="h6" href="<?php the_sub_field('project_url') ; ?>">See it now<i class="arrow-icon"></i></a>
			    	</div>
			    </div>
		   	<?php endwhile; ?>	
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_footer();