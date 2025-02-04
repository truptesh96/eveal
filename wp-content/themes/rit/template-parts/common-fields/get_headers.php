<?php 
	$head_tag = get_sub_field('head_tag') ? get_sub_field('head_tag') : "h2";
	$heading = get_sub_field('heading');
	$sub_head_tag = get_sub_field('sub_head_tag') ? get_sub_field('sub_head_tag') : "h2";
	$sub_heading = get_sub_field('sub_heading');
	$content = get_sub_field('content');

	if (isset($args) && is_array($args)) {
		extract($args);
	}

	$classHead = !empty($classHead) ? esc_attr($classHead) : '';
	$classSubhead = !empty($classSubhead) ? esc_attr($classSubhead) : '';
	$classContent = !empty($classContent) ? esc_attr($classContent) : '';
?>

<?php if($heading): ?>
	<<?php echo esc_attr($head_tag); ?> class="head anim <?php echo esc_attr($classHead); ?>">
		<?php echo esc_html($heading); ?>
	</<?php echo esc_attr($head_tag); ?>>
<?php endif; ?>

<?php if($sub_heading): ?>
	<<?php echo esc_attr($sub_head_tag); ?> class="subHead anim <?php echo esc_attr($classSubhead); ?>">
		<?php echo esc_html($sub_heading); ?>
	</<?php echo esc_attr($sub_head_tag); ?>>
<?php endif; ?>

<?php if($content): ?>
	<div class="siteCont anim <?php echo esc_attr($classContent); ?>">
		<?php echo wp_kses_post($content); ?>
	</div>
<?php endif; ?>