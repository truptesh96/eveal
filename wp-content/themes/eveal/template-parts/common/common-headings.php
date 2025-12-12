<?php 
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag') ?: 'h2';
    $content = get_sub_field('content');
    $link = get_sub_field('cta');

    // Use $args directly as passed from get_template_part()
    $headingClass = isset($args['headingClass']) ? $args['headingClass'] : 'heading';
    $contentClass = isset($args['contentClass']) ? $args['contentClass'] : 'content';
    $linkClass = isset($args['linkClass']) ? $args['linkClass'] : 'button';
?>

<?php if ($heading) : ?>
    <<?php echo esc_html($heading_tag); ?> class="<?php echo esc_attr($headingClass); ?>">
        <?php echo $heading; ?>
    </<?php echo esc_html($heading_tag); ?>>
<?php endif; ?>

<?php if ($content) : ?>
    <div class="content <?php echo esc_attr($contentClass); ?>">
        <?php echo $content; ?>
    </div>
<?php endif; ?>

<?php if ($link) : ?>
    <a class="<?php echo esc_attr($linkClass); ?>" href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
        <?php echo esc_html($link['title']); ?>
    </a>
<?php endif; ?>