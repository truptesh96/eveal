<?php if(have_rows('buttons')): ?>

<div class="btnWrap dflex">
	<?php while(have_rows('buttons')): the_row(); 
		$button = get_sub_field('button');
		if($button):
		$url = $button['url'];
		$button_text = $button['title'];
		$target = $button['target'] ? $button['target'] : '_self';
		$button_type = get_sub_field('button_type');
		$button_schema = get_sub_field('button_schema');
	?>
		
		<a href="<?php echo $url; ?>" target="<?php echo $target; ?>" aria-label="<?php echo $button_text; echo ( $target != '_self' ) ? ' (Open in new tab)' : ''; ?>" class="button anim <?php echo $button_type.' '.$button_schema; ?>"><?php echo $button_text; ?></a>
	
	<?php endif; endwhile; ?>
</div>


<?php endif; ?>