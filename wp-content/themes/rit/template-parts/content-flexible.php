<?php
 if( have_rows('flexible_content', get_the_ID() ) ):
    while( have_rows('flexible_content', get_the_ID()) ): the_row();
    
      get_template_part('template-parts/flex-blocks/flex-' . get_row_layout());

    endwhile;
endif;
?>