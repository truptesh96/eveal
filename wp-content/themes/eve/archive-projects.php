<?php

/**

 *

 * @package WordPress
 

 */

get_header(); ?>
<section class="portfolio page-head">
    <div class="zigzag-right zigzag">
        <div class="wrapper">
            <div class="wrapper">
                <div class="page-title">
                    <span class="subtitle">Our Work.</span>
                    <h1>Changing the world,<br/>one creative brief at a time.</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="portfolio-posts dark-bg">
    <div class="wrapper">
        <div class="filter-tabs">
            <div class="taps">
            <a href="javascript:void(0)" class="tap all active" rel="nofollow">All</a>
            <?php 
                $terms = get_terms( array( 'taxonomy' => 'portfolio-category', 'hide_empty' => false));
                foreach ( $terms as $term ) { ?>
                <a href="javascript:void(0)" class="tap" rel="nofollow" data-filter="<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
               <?php } ?>
        </div>
        
            <div class="filter-content">
                <?php
                $args = array( 'post_type' => 'portfolio-items', 'paged' => 1, 'post_status' => 'publish', 'posts_per_page' => '15', );
                $blog_posts = new WP_Query( $args );
                ?>
                <?php if ( $blog_posts->have_posts() ) : ?>
                    <div class="work-posts">
                        <?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
                        <?php
                       $categoris = get_the_terms( get_the_ID() , 'portfolio-category' );
                        $slugs = array();
                        foreach ( $categoris as $term ) {
                         $slugs[] =  $term->slug;
                        } $cats_list = join( " ", $slugs ); ?>
                    <a href="<?php the_permalink(); ?>" class='work-item item show <?php echo $cats_list; ?>' >
                        <h3 class='work-post-title'><span class="font30"><?php echo get_the_title(); ?></span><i class="arrow-icon"></i></h3>
                        <figure>
                            <?php the_post_thumbnail('large'); ?>    
                        </figure>
                    </a>
                        <?php endwhile; ?>
                    </div>
                    <div><a class="common-round-button loadmore" data-offset = '<?php echo $blog_posts->max_num_pages;?>'>Load More</a></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
jQuery(function($){
    jQuery(document).ready(function(e) {
        var page = 2;
            $('body').on('click', '.portfolio-posts .loadmore', function() {
            
            var data = { 'action': 'load_posts_by_ajax', 'page': page };
            $.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response) {
                if($.trim(response) != '') {
                    $('.filter-content .work-posts').append(response);
                    page++;
                }else{ 
                    $('.portfolio-posts .loadmore').hide(); 
                }
                if(page > jQuery('.portfolio-posts .loadmore').data('offset')){
                    
                    $('.portfolio-posts .loadmore').remove(); 
               }
            });


        });
    });
});

</script>
<?php get_footer();