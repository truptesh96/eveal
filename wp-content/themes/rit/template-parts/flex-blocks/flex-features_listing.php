<?php
    $section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
    $section_class = get_sub_field('section_class');
    $section_color_schema = get_sub_field('section_color_schema');
    $features = get_sub_field('features');
    if ($features):
?>

<section id="<?php echo esc_attr($section_id); ?>" class="usp anim <?php echo esc_attr($section_class . ' ' . $section_color_schema); ?>">

    <div class="dflex inwrap">
        <?php while(have_rows('features')): the_row(); ?>
        <div class="block anim">
            <h3 class="h3 head "><?php echo get_sub_field('feature'); ?></h3>
            <p><?php echo get_sub_field('description'); ?></p>
        </div>
        <?php endwhile; ?>
   
    </div>
</section>
<?php endif; ?>