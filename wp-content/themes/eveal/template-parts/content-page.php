<?php if( have_rows('page_content') ): ?>
    
    <?php while( have_rows('page_content') ): the_row(); 
        $layout = get_row_layout();
        $hide_section = get_sub_field('hide_section');
        ( $layout && !$hide_section ) ? get_template_part( 'template-parts/blocks/' . $layout ) : '';      
    endwhile; ?>
<?php endif; ?>
