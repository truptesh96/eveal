<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eveal
 */

?>
	
	<div class="cta">
		<div class="container wrap dgrid">
		<div class="content">
			<h3>Got a Project or Partnership in Mind?</h3>
		</div>
		<a class="btn">Get In Touch</a>
		</div>
	</div>


	<footer id="colophon" class="site-footer">
		<div class="container">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'eveal' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'eveal' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'eveal' ), 'eveal', '<a href="http://underscores.me/">Truptesh Patel</a>' );
				?>
		</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->

	<!-- Mobile Navigation -->
	<ul class="mob-nav dgrid align-center">
		<li>
			<a href="javascript:void(0)" aria-controls="primary-menu" aria-expanded="false"
			 class="icn icon-reorder menu-toggle"></a>
			<span>Menu</span>
		</li>
		<li>
			<a href="javascript:void(0)" class="icn search icon-search5"></a>
			<span>Search</span>
		</li>
		<li>
			<a href="" class="icn call icon-phone"></a>
		</li>
		<li>
			<a href="tel:" class="icn about icon-user1"></a>
			<span>About</span>
		</li>
		<li>
			<a href="" class="icn contact icon-pencil"></a>
			<span>Contact</span>
		</li>
	</ul>


	<!-- Contact Form -->
	<section class="popup search dtab" style="display: none;">
		<div class="dcell">
			<div class="window">
			<a class="popupToggle icon-cross" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></a>
			<div class="cont">
			<h3>Contact Us Today For Help!</h3>
			<?php get_search_form(); ?>
			</div>
			</div>
		</div>
	</section>
	<!-- Contact Form Ends -->


	<!-- Mobile Navigation Ends -->

<?php wp_footer(); ?>

<script>
	jQuery(function($){
		$(window).resize(function(){

		});

		$(window).load(function(){
			
		});

		$(window).ready(function(){

			$('.slider').each(function(){
				var slider_settings = $(this).attr('data-slick');
				slider_settings = JSON.parse(slider_settings)
				$(this).slick(slider_settings);
			});



			$(".search-field").keyup(function(){
				if($(this).val().length > 0){
					$(this).siblings('.search-submit').addClass('enable');
				}else{
					$(this).siblings('.search-submit').removeClass('enable');
				}
			});

			/*----- Popups-----*/
			$('.mob-nav a.search').click(function(){ $('.popup.search').fadeIn('500'); });
			$('.popupToggle').click(function(){ $(this).parents('.popup').fadeOut('200'); });

			/*-- Accordion --*/
			$("[data='single'] .tap .tap_title").click(function(){
            	$(this).parent(".tap").addClass("open").siblings('.tap').removeClass('open');
			});
			$("[data='multiple'] .tap .tap_title").click(function(){
            	$(this).parent(".tap").toggleClass("open");
			});
			/*-- Accordion Ends --*/

			/*-- Tabbing --*/
			$(".tabs .tab").click(function(){$(this).addClass("open").siblings('.tab').removeClass("open");$(this).parents('.titles').siblings('.content').find('.tabData').removeClass('open').eq($(this).index()).addClass('open');});
			/*-- Tabbing Ends --*/

			$('.menu-toggle').click(function(){ $('body').addClass('menu-open'); });
			$('.menu-close').click(function(){ $('body').removeClass('menu-open'); });

		});
	});
</script>


<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>




<?php the_field('bottom_css', 'option'); ?>
</body>
</html>
