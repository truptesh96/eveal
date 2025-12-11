<?php
	$section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
	$section_class = get_sub_field('section_class');
    
    // Block Specific Settings
    $content_width = get_sub_field('content_width') ? get_sub_field('content_width') : '800px';
    $content_alignment = get_sub_field('content_alignment') ? get_sub_field('content_alignment') : 'u-text-center';
    $editor_content = get_sub_field('editor_content');

    if($editor_content):
?>

<section class="o-section c-text-block <?php echo $section_class; ?> u-relative" id="<?php echo $section_id; ?>" >
    <div class="o-container" style="--content-width: <?php echo esc_attr($content_width); ?>;">
        <div class="c-text-block__content <?php echo esc_attr($content_alignment); ?>">
            <?php echo $editor_content; ?>
        </div>
    </div>    	 
</section>
<?php endif; ?>