<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eveal
 */

?>

	<footer id="colophon" class="site-footer">

		<div class="footer-top">

		</div>
		<div class="site-info footer-bottom">
			<div class="wrapper">
				<a class="footer-logo" href="<?php echo site_url(); ?>">
				</a>
				<p class="copyright-txt"><?php the_field('copyright_text','option'); echo " ".date(
				'Y'); ?> </p>
			</div>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/common.js"></script>

<?php echo the_field('footer_script', 'option'); ?>

</body>
</html>
