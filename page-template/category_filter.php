<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eveal
 *
 * Template Name: Filter Category Template
 */
get_header();
?>

<div class="container">

<ul class="categories cat-filter">
<li data-filter="blog" class="cat active">All Posts</li>
<?php foreach (get_categories() as $category){
	if ($category->count > 0){
		echo '<li data-filter="cat'.$category->cat_ID.'" class="cat">'.$category->cat_name.'</li>';
	}
} ?>
</ul>
<div class="posts-data"></div>

<script>
jQuery(function($){
	$(document).ready(
		function(){
		/* 

		Particular Category Post
		var url = window.location.origin+'/eveal/wp-json/wp/v2/posts?categories=2';
	    
		For Two Multiple categories Posts
		 var url = window.location.origin+'/eveal/wp-json/wp/v2/posts?categories=4,6';

	    var url = window.location.origin+'/eveal/wp-json/wp/v2/posts?per_page=4'; */
	    
	    var url = window.location.origin+'/eveal/wp-json/wp/v2/posts/';

	    var request = $.ajax({
	        url: url ,
	        method: "GET",
	        dataType: "json",
	    });
	    request.done(function(data) {
	        var response = data;
	        if(response.length > 0){
		   		$('.posts-data').append("<div class='blogs dgrid mob-col2 tab-col3 filter'></div>");
		   		response.map(function(row){
		   			var categories = row.categories.join(' cat');
		   			var template_row = `<article class="blog cat${categories}"><a href="${row.link}"><h2>${row.title.rendered}</h2>${row.excerpt.rendered}</a></article>`;
		   			$('.posts-data .blogs').append(template_row);
		   		});
	   		}
	    });
	    request.fail(function(jqXHR, textStatus) {
	       console.log( "Request failed: " + textStatus );
	    });
	});

	$('.cat-filter .cat').click(function(){
		$(this).addClass('active').siblings('.cat').removeClass('active');
		$('.filter .blog').hide();
		$('.filter').find('.'+$(this).attr('data-filter')).fadeIn('300');
	});

});
</script>

</div>
<?php get_footer(); ?>

<!--
User-agent: *
Disallow: /wp-admin/
Allow: /wp-admin/admin-ajax.php

sitemap: https://www.midcoasttech.com/robots.txt -->