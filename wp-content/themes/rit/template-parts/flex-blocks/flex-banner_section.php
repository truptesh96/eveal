<?php
	$section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
	$section_class = get_sub_field('section_class');
	$section_color_schema = get_sub_field('section_color_schema');

	$getSlideCount = get_field('slide_count') ? get_field('slide_count') : 1;

	if(have_rows('banner_slides')): 
?>
<section class="heroBanner slickSlides ptb0 <?php echo $section_class.' '.$section_color_schema; ?>" id="<?php echo $section_id; ?>" data-minslides="1" data-slick='{ 
	"slidesToShow": 1, "slidesToScroll": 1,
    "arrows": false, "infinite": true, "dots": true, "autoplay": true, "autoplaySpeed": 5000, "speed": 1000, "fade": true,
	    "responsive": [
	    {
	    	"breakpoint": 1280,
	        "settings": {
	        "slidesToShow": <?php echo $getSlideCount; ?>
	        }
	    }
    ]
    }' >
	<?php while (have_rows('banner_slides')) { the_row(); ?>

		<div class="slide hasBg">
			<?php $fetch_priority = get_row_index() == 1 ? "high" : "low"; ?>
			<?php get_template_part('template-parts/common-fields/get_media', false, array( 'class' => 'bgItem zoomover', 'fetch_priority' => $fetch_priority )); ?>

			<div class="contWrap z2">
				<?php get_template_part('template-parts/common-fields/get_headers'); ?>
				<?php get_template_part('template-parts/common-fields/get_buttons'); ?>
			</div>
		 </div>
	
	<?php } ?>
</section>
<?php endif; ?>