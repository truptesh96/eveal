<?php
    $section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
    $section_class = get_sub_field('section_class');
    $section_color_schema = get_sub_field('section_color_schema');
?>
<?php if (have_rows('tabs')): ?>
<div id="<?php echo esc_attr($section_id); ?>" class="locationTabs <?php echo esc_attr($section_class.' '.$section_color_schema); ?>">
    <div class="wrap">
        <div class="tabs anim" role="tablist">
            <div class="tabList dflex">
                <?php while (have_rows('tabs')): the_row(); ?>
                    <div class="tab" role="presentation">
                        <a href="#tab-<?php echo get_row_index(); ?>" id="tab-<?php echo get_row_index(); ?>-link" class="tabLink" role="tab" aria-controls="tab-<?php echo get_row_index(); ?>" aria-selected="false" tabindex="-1"><?php the_sub_field('tab_title'); ?></a>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php while (have_rows('tabs')): the_row(); ?>
                <div id="tab-<?php echo get_row_index(); ?>" class="tabContent siteCont " role="tabpanel" aria-labelledby="tab-<?php echo get_row_index(); ?>-link" aria-hidden="true">
                    <?php the_sub_field('tab_content'); ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?>