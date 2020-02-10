<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Qusq_Lite
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
	if ( have_comments() ) : ?>
		<h4 class="comments-title">
			<?php
			printf( // WPCS: XSS OK.
				esc_html( _nx( 'Comments', 'Comments', get_comments_number(), 'comments title', 'qusq-lite' ) ),
				number_format_i18n( get_comments_number() ),
				'<span>' . get_the_title() . '</span>'
			);
			?>
		</h4>

		<ol class="comment-list">
			<?php

			wp_list_comments( array(
				'type'       => ( 'closed' === get_option( 'default_ping_status', 'closed' ) ) ? 'comment' : 'all',
				'short_ping' => true,
				'callback'   => 'qusq_lite_custom_comment_structure',
			) );

			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'qusq-lite' ); ?></h2>
				<div class="nav-links">

					<?php paginate_comments_links(
						array(
							'prev_text' => '',
							'next_text' => '',
						)
					); ?>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->

			<hr>

			<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'qusq-lite' ); ?></p>
		<?php
	endif;

	// Display custom post comments form.
	qusq_lite_get_custom_comment_form();

	?>

</div><!-- #comments -->
