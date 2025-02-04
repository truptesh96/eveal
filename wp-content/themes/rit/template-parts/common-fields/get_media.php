<?php 
if (isset($args) && is_array($args)) {
    extract($args);
}

$media_type = get_sub_field('media_type');
$image = get_sub_field('image');
$class = !empty($class) ? esc_attr($class) : '';
?>

<div class="media anim zoomover <?php echo $class . ' ' . esc_attr($media_type); ?> ">
    <?php 
    if ($media_type == "image") {
        if (is_array($image)) {
            echo wp_get_attachment_image($image['ID'], 'full');
        } else {
            echo wp_get_attachment_image($image, 'full');
        }
    }
    ?>
    
    <?php if($media_type == "video"): ?>
        <video autoplay loop muted>
          <source src="<?php echo esc_url(get_sub_field('video')); ?>" type="video/mp4">
          <source src="<?php echo esc_url(get_sub_field('video_compressed')); ?>" type="video/webm">
          Your browser does not support the video tag.
        </video>
    <?php endif; ?>

    <?php 
        if($media_type == "thirdParty"):
            echo get_sub_field('third_party_url');
        endif; 
    ?>
</div>