<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rit
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<p class="title h3">
			<?php
			$rit_comment_count = get_comments_number();
			echo $rit_comment_count > 1 ? 'Comments ( '. esc_html($rit_comment_count).' )' :'Comment ( '. esc_html($rit_comment_count).' )';"";	 
			 
			?>
		</p><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comments" id="reviews">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="noComments"><?php esc_html_e( 'Comments are closed.', 'rit' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
