<?php
	$section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
	$section_class = get_sub_field('section_class');	 
?>
<section class="o-section <?php echo $section_class; ?> u-relative" id="<?php echo $section_id; ?>"> 
	 
</section>
 