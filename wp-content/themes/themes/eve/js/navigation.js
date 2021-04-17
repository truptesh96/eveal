/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */

jQuery(function($){

	jQuery(document).ready(function(e) {
		
		$('.hamIcon').click(function(){
			$(this).toggleClass('open').parents('body').toggleClass('menu-open');
		});

		$('.site-header .menu-item-has-children').each(function(){
			$(this).prepend("<span class='submenuToggle'>");
		});

		$('.site-header .submenuToggle').click(function(){
			$(this).toggleClass('open').siblings('.sub-menu').slideToggle('open');
		});

	});

})