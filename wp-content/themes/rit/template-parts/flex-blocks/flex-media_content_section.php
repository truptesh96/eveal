<?php
	$section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
	$section_class = get_sub_field('section_class');
	$section_color_schema = get_sub_field('section_color_schema');
    $media_alignment = get_sub_field('media_alignment');
    $wrapper_width = get_sub_field('wrapper_width');
    
?>
<section class="mediaCont <?php echo $section_class.' '.$section_color_schema; ?>" id="<?php echo $section_id; ?>">
    <div class="wrap dflex <?php echo $wrapper_width.' ';  echo ( $media_alignment == 'rightAlign' ) ? ' reverse ' : ''; ?> ">
        <div class="mediaWrap hasBg">
            <?php get_template_part('template-parts/common-fields/get_media', false, array( 'class' => 'media bgItem' )); ?>
        </div>

        <div class="contWrap">
            <?php get_template_part('template-parts/common-fields/get_headers'); ?>
            <?php get_template_part('template-parts/common-fields/get_buttons'); ?>
        </div>

    </div>
</section>
 