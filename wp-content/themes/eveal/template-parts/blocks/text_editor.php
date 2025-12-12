<?php 
    $sec_id = get_sub_field('sec_id');
    $sec_classes = get_sub_field('sec_classes');
    $sec_bg_color = get_sub_field('sec_bg_color');

    $wysiwyg_text_editor = get_sub_field('editor');
?>

<?php if($wysiwyg_text_editor): ?>
<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>" style="<?php echo $sec_bg_color ? '--bg-color: ' . esc_attr($sec_bg_color) : ''; ?>" class="ptb0 text-editor <?php echo esc_attr($sec_classes); ?>">
       <div class="wrapper">
            <div class="cont">
                <?php echo $wysiwyg_text_editor; ?>
            </div>
       </div>
</section>
<?php endif; ?>