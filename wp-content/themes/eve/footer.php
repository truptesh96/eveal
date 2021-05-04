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

	<footer id="colophon" class="site-footer anim">
		<div class="footer-top">
			<div class="wrapper">
				<div class="dflex wrap vcenter">
					<div class="left xtabWid40 toRight anim ">
						<a class="footer-logo" href="<?php echo site_url(); ?>">
							<?php $footer_logo = get_field('footer_logo','option'); if( !empty( $footer_logo ) ) : ?>
							<img src="<?php echo $footer_logo['sizes']['large']; ?>" alt="<?php echo esc_attr($footer_logo['alt']); ?>" >
							<?php endif; ?>
						</a>
						<?php if(get_field('footer_address','option')) : ?>
						<address><?php the_field('footer_address','option') ?></address>
						<?php endif; ?>

						<?php if(get_field('footer_phone','option')) : ?>
							<div class="flink"><label>Call:</label> <a class="icn call" href="tel:<?php the_field('footer_phone','option') ?>"><?php the_field('footer_phone','option') ?></a>
							</div>
						<?php endif; ?>

						<?php if(get_field('footer_email','option')) : ?>
							<div class="flink"><label>Email:</label> <a class="icn email" href="mailto:<?php the_field('footer_email','option') ?>"><?php the_field('footer_email','option') ?></a>
							</div>
						<?php endif; ?>

						<div class="socials">
							<?php if(get_field('facebook_url','option')) : ?>
								<a target="_blank" class="icn facebook" href="<?php the_field('facebook_url','option') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="36.062" height="35.843" viewBox="0 0 36.062 35.843">
							  <path d="M36.062,18.031A18.031,18.031,0,1,0,15.214,35.843v-12.6H10.635V18.031h4.578V14.058c0-4.519,2.692-7.015,6.81-7.015A27.73,27.73,0,0,1,26.06,7.4v4.437H23.787a2.606,2.606,0,0,0-2.939,2.816v3.382h5s.451,3.909-.8,5.212-4.2,0-4.2,0v12.6A18.035,18.035,0,0,0,36.062,18.031Z"></path>
							</svg></a>
							<?php endif; ?>
							<?php if(get_field('instagram_url','option')) : ?>
								<a target="_blank" class="icn twitter" href="<?php the_field('instagram_url','option') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="36.065" height="36.065" viewBox="0 0 36.065 36.065">
							  <path d="M18.032,0c-4.9,0-5.51.023-7.434.108A13.3,13.3,0,0,0,6.221.947a8.831,8.831,0,0,0-3.195,2.08A8.8,8.8,0,0,0,.947,6.221,13.258,13.258,0,0,0,.108,10.6C.018,12.522,0,13.133,0,18.032s.023,5.51.108,7.434a13.3,13.3,0,0,0,.839,4.377,8.843,8.843,0,0,0,2.08,3.195,8.818,8.818,0,0,0,3.195,2.08,13.313,13.313,0,0,0,4.377.839c1.923.09,2.535.108,7.434.108s5.51-.023,7.434-.108a13.344,13.344,0,0,0,4.377-.839,9.216,9.216,0,0,0,5.274-5.274,13.3,13.3,0,0,0,.839-4.377c.09-1.923.108-2.535.108-7.434s-.023-5.51-.108-7.434a13.336,13.336,0,0,0-.839-4.377,8.85,8.85,0,0,0-2.08-3.195A8.786,8.786,0,0,0,29.843.947,13.266,13.266,0,0,0,25.466.108C23.543.018,22.931,0,18.032,0Zm0,3.246c4.813,0,5.387.024,7.288.107a9.935,9.935,0,0,1,3.346.624A5.934,5.934,0,0,1,32.09,7.4a9.956,9.956,0,0,1,.621,3.346c.086,1.9.105,2.473.105,7.288s-.023,5.387-.111,7.288a10.148,10.148,0,0,1-.633,3.346,5.726,5.726,0,0,1-1.351,2.077,5.626,5.626,0,0,1-2.074,1.346,10.029,10.029,0,0,1-3.359.621c-1.914.086-2.478.105-7.3.105s-5.389-.023-7.3-.111a10.225,10.225,0,0,1-3.36-.633,5.584,5.584,0,0,1-2.072-1.351A5.475,5.475,0,0,1,3.9,28.647a10.234,10.234,0,0,1-.631-3.359C3.2,23.4,3.178,22.811,3.178,18.01s.024-5.389.092-7.3A10.222,10.222,0,0,1,3.9,7.348,5.345,5.345,0,0,1,5.253,5.273,5.334,5.334,0,0,1,7.326,3.924a9.98,9.98,0,0,1,3.337-.633c1.916-.068,2.479-.09,7.3-.09l.068.045Zm0,5.527a9.26,9.26,0,1,0,9.26,9.26,9.259,9.259,0,0,0-9.26-9.26Zm0,15.27a6.011,6.011,0,1,1,6.011-6.011A6.009,6.009,0,0,1,18.032,24.043ZM29.822,8.408a2.164,2.164,0,1,1-2.164-2.162A2.165,2.165,0,0,1,29.822,8.408Z"></path>
							</svg></a>
							<?php endif; ?>
							<?php if(get_field('twitter_url','option')) : ?>
								<a target="_blank" class="icn twitter" href="<?php the_field('twitter_url','option') ?>"><svg width="36.065" height="36.065" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
								<path d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016  c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992  c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056  c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152  c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792  c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44  C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568  C480.224,136.96,497.728,118.496,512,97.248z"/>
								</svg></a>
							<?php endif; ?>
						</div>
					</div>
					<div class="right anim toLeft xtabWid60">
					</div>
				</div>
			</div>
		</div>
		<div class="site-info footer-bottom">
			<div class="wrapper">
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
