<?php
	$section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
	$section_class = get_sub_field('section_class');
	$section_color_schema = get_sub_field('section_color_schema');
    $faq_list = get_sub_field('faq_list');
    if($faq_list):
?>
<section class="faqs <?php echo esc_attr($section_class.' '.$section_color_schema); ?>" id="<?php echo esc_attr($section_id); ?>">
    <div class="wrap">
    <div class="mainHead">
        <?php get_template_part('template-parts/common-fields/get_headers'); ?>    
    </div>
    
    <?php while(have_rows('faq_list')): the_row(); ?>    
        <div class="faqItem">
            <?php 
                $head_tag = get_sub_field('head_tag') ? get_sub_field('head_tag') : "h2";
                $heading = get_sub_field('heading');
                $content = get_sub_field('content');
            ?>

            <?php if($heading): ?>
                <<?php echo esc_attr($head_tag); ?> aria-expanded="false"  class="dflex vCenter spaceBetween head accordionTrig faqTrig">
                    <?php echo esc_html($heading); ?> <i class="plusIcon"></i>
                </<?php echo esc_attr($head_tag); ?>>
            <?php endif; ?>
  
            <?php if($content): ?>
                <div class="siteCont faqContent accordionContent" aria-hidden="true">
                    <?php echo wp_kses_post($content); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

    </div>
</section>

<?php endif; ?>