<?php
	$section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
	$section_class = get_sub_field('section_class');
	$section_color_schema = get_sub_field('section_color_schema');
    $contact_details = get_sub_field('contact_details');
  
?>

<div id="<?php echo esc_attr($section_id); ?>" class="getTouch <?php echo esc_attr($section_class.' '.$section_color_schema); ?>">
 
    <div class="wrap">
        <div class="dflex">
        <div class="wid50 mainHead">
            <?php get_template_part('template-parts/common-fields/get_headers'); ?>    
        </div>
        <?php if($contact_details): ?>
         <div class="wid50 getTouchForm anim">
                <?php echo  $contact_details; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
	<div class="wavesAnim"></div>
</div>
 