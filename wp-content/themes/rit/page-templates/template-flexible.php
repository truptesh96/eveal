<?php
/**
 * Template Name: Flexible Content Template
 * @package LSQ
 */

get_header(); ?>


<main id="primary" class="site-main flexCont">
    <?php 
        
        if ( post_password_required() ) {
           echo get_the_password_form();
        } else {
            get_template_part( 'template-parts/content', 'flexible' ); 
        }
    ?>
</main>

<?php 
get_footer();