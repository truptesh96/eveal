<?php 
    $sec_id = get_sub_field('sec_id');
    $sec_classes = get_sub_field('sec_classes');
    $sec_bg_color = get_sub_field('sec_bg_color');
?>


<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>" style="<?php echo $sec_bg_color ? '--bg-color: ' . esc_attr($sec_bg_color) : ''; ?>" class="ptb0 banner-block <?php echo esc_attr($sec_classes); ?>">
        <?php if( have_rows('banner_slides') ): ?>
        <div class="slides dflex noWrap">
            <?php while( have_rows('banner_slides') ): the_row(); ?>
                <div class="slide vh100 hasBg">
                    <div class="wrapper">
                    <div class="cont z2 darkSkin">
                        <?php get_template_part( 'template-parts/common/common', 'headings', ['headingClass' => 'fs50', 'linkClass' => 'fs16', 'contentClass' => 'fs20' ]); ?>
                    </div>
                    </div>
                    <?php get_template_part( 'template-parts/common/common', 'media', ['imgSize' => 'full', 'class' => 'bg']); ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
</section>