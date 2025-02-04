<?php
    $section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
    $section_class = get_sub_field('section_class');
    $section_color_schema = get_sub_field('section_color_schema');
    $category_cards = get_sub_field('category_cards');
    if ($category_cards):
?>

<section id="<?php echo esc_attr($section_id); ?>" class="catGrid <?php echo esc_attr($section_class . ' ' . $section_color_schema); ?>">
    <div class="wrap dflex">

    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 64 64"><path id="Layer_9" d="M4 15.51a1 1 0 0 0 .71-.29L15.22 4.71a1 1 0 1 0-1.42-1.42L3.29 13.8a1 1 0 0 0 0 1.42 1 1 0 0 0 .71.29zm0 11.38a1 1 0 0 0 .71-.29L26.6 4.71a1 1 0 1 0-1.42-1.42L3.29 25.18a1 1 0 0 0 0 1.42 1 1 0 0 0 .71.29zm0 11.36a1 1 0 0 0 .71-.25L38 4.71a1 1 0 1 0-1.42-1.42L3.29 36.54a1 1 0 0 0 0 1.42 1 1 0 0 0 .71.29zm0 11.38a1 1 0 0 0 .71-.29L49.34 4.71a1 1 0 1 0-1.42-1.42L3.29 47.92a1 1 0 0 0 0 1.42 1 1 0 0 0 .71.29zM60.71 3.29a1 1 0 0 0-1.42 0l-56 56a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l56-56a1 1 0 0 0 0-1.42zm-1.42 11.37L14.66 59.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l44.63-44.63a1 1 0 0 0-1.42-1.42zm0 11.34L26 59.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l33.29-33.25A1 1 0 0 0 59.29 26zm0 11.4L37.4 59.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l21.89-21.89a1 1 0 0 0-1.42-1.42zm0 11.38L48.78 59.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0L60.71 50.2a1 1 0 0 0-1.42-1.42z" data-name="Layer 9" fill="url(&quot;#SvgjsLinearGradient1051&quot;)"/><defs><linearGradient id="SvgjsLinearGradient1051"><stop stop-color="#fbc2eb" offset="0"/><stop stop-color="#a6c1ee" offset="1"/></linearGradient></defs></svg>

        <div class="wid50 mainHead">
            <?php get_template_part('template-parts/common-fields/get_headers'); ?>    
        </div>
        
        <div class="catWrap dflex">
        <?php foreach ($category_cards as $card): ?>
            <?php 
                $image = $card['image']; 
                $category_link = $card['category_link'];
                if ($category_link):
                    $title = $category_link['title'];
                    $category_url = $category_link['url'];
                    $target = $category_link['target'] ? $category_link['target'] : '_self';
            ?>
            <div class="catItem column">
                <a class="imgWrap zoomover anim" href="<?php echo esc_url($category_url); ?>" data-label="<?php echo esc_attr($title); ?>" target="<?php echo esc_attr($target); ?>">
                    <?php echo wp_get_attachment_image($image, 'full'); ?>
                </a>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>