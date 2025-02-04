<?php
    $section_id = get_sub_field('section_id') ? get_sub_field('section_id') : 'sec_'.get_row_index();
    $section_class = get_sub_field('section_class');
    $section_color_schema = get_sub_field('section_color_schema');
    $featured_products = get_sub_field('products');
?>
<?php if( $featured_products ): ?>
<div id="<?php echo esc_attr($section_id); ?>" class="products <?php echo esc_attr($section_class.' '.$section_color_schema); ?>">
    <div class="wrap">
        <div class="wid50 mainHead">
            <?php get_template_part('template-parts/common-fields/get_headers'); ?>    
        </div>
        <ul class="products columns-4">
            <?php foreach( $featured_products as $post ): 
                // Setup this post for WP functions (variable must be named $post).
                setup_postdata($post); 
                $product = wc_get_product($post->ID);
                $add_to_cart_url = $product->add_to_cart_url();
                $button_text = $product->is_type('variable') ? __('Select options', 'woocommerce') : __('Add to cart', 'woocommerce');
                ?>
                <li class="product">
                    <a href="<?php echo get_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                        <div class="product-image">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                        <p class="woocommerce-loop-product__title font32"><?php echo get_the_title(); ?></p>
                    </a>
                    <a href="<?php echo esc_url($add_to_cart_url); ?>" class="button add_to_cart_button"><?php echo esc_html($button_text); ?></a>
                </li>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </ul>
    </div>
</div>
<?php endif; ?>