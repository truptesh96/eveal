<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eveal
 *
 * Template Name: Home Template
 */
get_header();
?>

<section class="home-app"></section>


<script>
jQuery(function($){
	$(window).ready(function(){
		$('.icn-sdown').click(function(){ var target = '.'+$(this).attr('data-scroll');
			$('html, body').animate({ scrollTop: $(target).offset().top }, 1000);
		});
	});
});
</script>
<?php get_footer(); ?>