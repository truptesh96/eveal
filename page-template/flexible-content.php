<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eveal
 *
 * Template Name: Flexible Content Template
 */
get_header();
?>

<?php if( have_rows('pages_blocks') ): ?>
    <?php while( have_rows('pages_blocks') ): the_row(); ?>
        
        <?php if( get_row_layout() == 'section_heading' ): ?>
        	<!--  Block -->
        	<div class="flexible">
    	    	<div class="container">
    	    		
	        	</div>    
        	</div>
        	<!--  Ends -->
        <?php endif; ?>

       
        <?php if( get_row_layout() == 'testimonials_block' ): ?>
        	 <!-- Testimonials Block -->
        	<?php if( have_rows('testimonials') ): ?>
        		<div class="flexible testimonials main"> 	
		        	<div class="container slider" data-slick= '{ "dots":true, "infinite":true,
					   "speed":500, "slidesToShow":1, "arrows":false}' >
		        	<?php while( have_rows('testimonials') ) : the_row(); ?>
		        		<article class="testimonial">
		        			<p><i><?php the_sub_field('review_text'); ?></i>	</p>
		        			<span class="ratings" data-ratings="<?php the_sub_field('review_ratings'); ?>"></span>	
		            		<h3><?php the_sub_field('name'); ?></h3>
		            		<img src="<?php the_sub_field('image'); ?>" alt=''>
		     			</article>
		        	<?php endwhile; ?>
		        	</div>
	        	</div>
        	<?php endif; ?>
        	<!-- Testimonials Block Ends -->
        <?php endif; ?>
        

         
        <?php if( get_row_layout() == 'accordion_tabs' ): ?>
        	<!-- Accordion Block -->
        	<div class="flexible accordion main" multiple-open ="<?php echo the_sub_field('multiple_tabs') ?>" >
        	<?php if( have_rows('accodion_item') == true ): ?>
		        	<div class="container">
			        	<?php while( have_rows('accodion_item') ) : the_row(); ?>
			        		<article class="item">
			            		<h3 class="title"><?php the_sub_field('accordion_title'); ?></h3>
			        			<div class="content"><?php the_sub_field('accordion_content'); ?></div>
			     			</article>
			        	<?php endwhile; ?>
		        	</div>    	
        	<?php endif; ?>
        	</div>
        	<!-- Accordion Block Ends -->
        <?php endif; ?>



        <?php if( get_row_layout() == 'skill_bar' ): ?>
        	<!-- skills Block -->
        	<div class="flexible skills main" >
        	<?php if( have_rows('skill') == true ): ?>
		        	<div class="container">
			        	<?php while( have_rows('skill') ) : the_row(); ?>
			        		<div class="skill">
			            		<p><?php the_sub_field('name'); ?></p>
			            		<div class="bar">
			            		<span style="background:<?php the_sub_field('color_of_the_bar') ?>;width:<?php the_sub_field('percentage'); ?>%;"></span>
			     				</div>
			     			</div>
			        	<?php endwhile; ?>
		        	</div>	
        	<?php endif; ?>
        	</div>
        	<!-- skills Block Ends -->
        <?php endif; ?>


        <?php if( get_row_layout() == 'two_columns_layout' ): ?>
        	<!-- Notification Bar Block -->
        	<div class="flexible two_col_layout main">
    	    	<div class="container">
		        	<div class="notification dgrid mob-col2 vcenter wrap">
		        		<div class="left">
		        			<?php the_sub_field('left_column'); ?>
		        		</div>
		        		<div class="right">
		        			<?php the_sub_field('right_column'); ?>
	     				</div>
	     			</div>
	        	</div>    
        	</div>
        	<!--  Notification Bar Ends -->
        <?php endif; ?>


        <?php if( get_row_layout() == 'notification_bar' ): ?>
        	<!-- Notification Bar Block -->
        	<div class="flexible notification_bar">
    	    	<div class="container">
		        	<div class="notification dgrid vcenter wrap">
		        		<img src="<?php the_sub_field('icon'); ?>" alt="">
	        			<p><?php the_sub_field('notification_text'); ?></p>
	     			</div>
	        	</div>    
        	</div>
        	<!--  Notification Bar Ends -->
        <?php endif; ?>


        <?php if( get_row_layout() == 'image_gallery' ): ?>
        	<!-- Image Galley Block -->
        	<div class="flexible main img_gallery">
    	    	<div class="container">
    	    		<?php $images = get_sub_field('slider-gallery');
					if( $images ): ?>
				    <ul class="slider" data-slick= '{ "dots":false, "infinite":true, "speed":500, "slidesToShow":1.10, "arrows":true}'>
				        <?php foreach( $images as $image ): ?>
				            <li class="slide"><img src="<?php echo $image; ?>" alt="" /></li>
				        <?php endforeach; ?>
				    </ul>
					<?php endif; ?>
	        	</div>
        	</div>
        	<!-- Image Galley Ends -->
        <?php endif; ?>

        <?php if( get_row_layout() == 'vertical_processes' ): ?>
        	<!-- Vertical Processes Block -->
        	<div class="flexible processes main">
        	<?php if( have_rows('process') == true ): ?>
		        	<div class="container">
		        		<?php $n = 1; ?>
			        	<?php while( have_rows('process') ) : the_row(); ?>
			        		<div class="count"><?php echo $n; ?></div>
			        		<?php if($n%2 != 0): ?>
				        		<article class="process dgrid wrap vcenter">
				            		<img src="<?php the_sub_field('process_image'); ?>" alt=''>
				        			<div class="content"><?php the_sub_field('process_description');?></div>
				     			</article>
				     		<?php else: ?>
				     				<article class="process dgrid wrap vcenter">
				            		<div class="content"><?php the_sub_field('process_description'); ?>
				            		</div>
				            		<img src="<?php the_sub_field('process_image'); ?>" alt=''>
				     				</article>
				     			<?php endif; ?>
			     			<?php $n++; ?>
			        	<?php endwhile; ?>
		        	</div>    	
        	<?php endif; ?>
        	</div>
        	<!-- Vertical Processes Ends -->
        <?php endif; ?>


        <?php if( get_row_layout() == 'name_of_block' ): ?>
        	<!--  Block -->
        	<div class="flexible">
    	    	<div class="container">
    	    		
	        	</div>    
        	</div>
        	<!--  Ends -->
        <?php endif; ?>



	<?php endwhile; ?>
<?php endif; ?>



<script>
	jQuery(function($){
		$('.ratings').each(function(){
			console.log($(this).attr('data-ratings'));
		});

		/*-------- Accordion JS --------*/
		$('.accordion[multiple-open="False"] .item').click(function(){ $(this).toggleClass('open').siblings('.item').removeClass('open'); });
		$('.accordion[multiple-open="True"] .item').click(function(){ $(this).toggleClass('open'); });

		$(".flexible").each(function(){			
			$(this).attr('vdist', $(this).offset().top);
		});

		$(window).scroll(function() { 
			if($(window).scrollTop() > $('.element').attr('vdist') - $(window).height() ){
				$('.element').addClass('load');
			}
		});

});
</script>
<?php get_footer(); ?>