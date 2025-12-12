<?php 
    $media_type = get_sub_field('media_type');
    $video_type = get_sub_field('video_type');
    $image = get_sub_field('image');
    $mobile_img = get_sub_field('mobile_image');
    $custom_video = get_sub_field('custom_video');
    $third_party_url = get_sub_field('third_party_url');

    
    $imgSize = isset($args['imgSize']) ? $args['imgSize'] : 'full';
    $class = isset($args['class']) ? $args['class'] : 'full';
?>



<div class="imageWrap <?php echo esc_attr($class); ?>">
    <?php echo wp_get_attachment_image($image, $imgSize); ?>
</div>