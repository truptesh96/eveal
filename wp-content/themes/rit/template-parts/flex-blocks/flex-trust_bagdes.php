<?php
	$section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
	$section_class = get_sub_field('section_class');
	$section_color_schema = get_sub_field('section_color_schema');

	if(have_rows('list_items')): 
?>
<section class="trustBadges ptb0 <?php echo $section_class.' '.$section_color_schema; ?>" id="<?php echo $section_id; ?>" >
	<?php while (have_rows('list_items')) { the_row(); 
            $icon = get_sub_field('icon');
            $label = get_sub_field('label');
        ?>
		<div class="item anim">
			<figure>
                <?php echo wp_get_attachment_image($icon, 'full', false, array('class' => 'icon')); ?>
                <figcaption><?php echo $label; ?>
            </figure>
		 </div>
	<?php } ?>
</section>
<?php endif; ?>