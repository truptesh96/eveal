<?php 
if (isset($args) && is_array($args)) {
    extract($args);
}

$media_type = get_sub_field('media_type');
$image = get_sub_field('image');
$class = !empty($class) ? esc_attr($class) : '';
$fetch_priority = !empty($fetch_priority) ? esc_attr($fetch_priority) : 'low';
$orientation = !empty($orientation) ? esc_attr($orientation) : '';

?>

<div class="media anim zoomover <?php echo $class . ' ' . esc_attr($media_type) . ' ' . esc_attr($orientation); ?> " >
    <?php 
        if ($media_type == "image") {
    
        if (is_array($image)) {
            $image_tag = wp_get_attachment_image($image['ID'], 'full');
        } else {
            $image_tag = wp_get_attachment_image($image, 'full');
        }
 
        if ($image_tag) {
            $image_tag = str_replace('<img ', '<img fetchpriority="' . esc_attr($fetch_priority) . '" ', $image_tag);
        }

        echo $image_tag;
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