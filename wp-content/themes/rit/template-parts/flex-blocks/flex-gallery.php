<?php
	$section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
	$section_class = get_sub_field('section_class');
	$section_color_schema = get_sub_field('section_color_schema');
    $gallery_images = get_sub_field('gallery_images');
    if($gallery_images):
?>

<div class="animatedText h1">
    <div class="marqueElem">
        <div class="inner">
            <span class="tieOne transText">• BEST PRICE • <mark>CREATIVITY</mark>DESIGNED PRODUCTS • LARGE SKUs • <mark>BEST DEALS</mark>365 DAYS • HANDCRAFTED • GIFTS FOR YOUR <mark>LOVED</mark> ONES </span> 
            <span class="tieTwo transText">• BEST PRICE • <mark>CREATIVITY</mark>DESIGNED PRODUCTS • LARGE SKUs • <mark>BEST DEALS</mark>365 DAYS • HANDCRAFTED • GIFTS FOR YOUR <mark>LOVED</mark> ONES </span>
        </div>
    </div>
    <div class="marqueElem toLeft">
        <div class="inner">
            <span class="tieOne transText">• BEST PRICE • <mark>CREATIVITY</mark>DESIGNED PRODUCTS • LARGE SKUs • <mark>BEST DEALS</mark>365 DAYS • HANDCRAFTED • GIFTS FOR YOUR <mark>LOVED</mark> ONES </span> 
            <span class="tieTwo transText">• BEST PRICE • <mark>CREATIVITY</mark>DESIGNED PRODUCTS • LARGE SKUs • <mark>BEST DEALS</mark>365 DAYS • HANDCRAFTED • GIFTS FOR YOUR <mark>LOVED</mark> ONES </span>
        </div>
    </div>
</div>


<div id="<?php echo esc_attr($section_id); ?>" class="gallery <?php echo esc_attr($section_class.' '.$section_color_schema); ?>">
    <div class="wrap dflex">
        <?php while(have_rows('gallery_images')): the_row(); ?>
            <?php $image = get_sub_field('image'); ?>
            <?php $image_url = wp_get_attachment_image_url($image, 'full'); ?>
            <?php $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true); ?>

            <div class="galleryItem column">
                <a href="<?php echo esc_url($image_url); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr($image_alt); ?>">
                    <?php echo wp_get_attachment_image($image, 'full', false, array('alt' => esc_attr($image_alt))); ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>