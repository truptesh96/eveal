<?php 
     
    $sec_id = get_sub_field('sec_id');
    $sec_classes = get_sub_field('sec_classes');
    $sec_bg_color = get_sub_field('sec_bg_color');

    $gallery = get_sub_field('gallery');
    if (!empty($gallery) && is_array($gallery)) {
?>        
 
<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>" style="<?php echo $sec_bg_color ? '--bg-color: ' . esc_attr($sec_bg_color) : ''; ?>" class="imgList <?php echo esc_attr($sec_classes); ?>">

        <div class="dflex wrapper">
        <?php foreach ($gallery as $image_id) { ?>
            <div class="imgWrap">
                <?php echo wp_get_attachment_image($image_id, 'full'); ?>
            </div>
        <?php } ?>
        </div>
</section>
<?php } ?>