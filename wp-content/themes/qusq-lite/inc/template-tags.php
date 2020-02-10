<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Qusq_Lite
 */

if ( ! function_exists( 'qusq_lite_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function qusq_lite_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: A link to the date */
			esc_html_x( 'Posted on %s', 'post date', 'qusq-lite' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: a link to author archive */
			esc_html_x( 'by %s', 'post author', 'qusq-lite' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;


if ( ! function_exists( 'qusq_lite_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function qusq_lite_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( ', ' );
			if ( $categories_list && qusq_lite_categorized_blog() ) {
				/* translators: used between list items, there is a space after the comma */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'qusq-lite' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ) {
				/* translators: used between list items, there is a space after the comma */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'qusq-lite' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'qusq-lite' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'qusq-lite' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function qusq_lite_categorized_blog() {

	$all_the_cool_cats = get_transient( 'qusq_lite_categories' );

	if ( false === ( $all_the_cool_cats ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'qusq_lite_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so qusq_lite_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so qusq_lite_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in qusq_lite_categorized_blog.
 */
function qusq_lite_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'qusq_lite_categories' );
}
add_action( 'edit_category', 'qusq_lite_category_transient_flusher' );
add_action( 'save_post',     'qusq_lite_category_transient_flusher' );


if ( ! function_exists( 'qusq_lite_the_custom_logo' ) ) {
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 */
	function qusq_lite_the_custom_logo() {
		if ( function_exists( 'has_custom_logo' ) ) {

			if ( has_custom_logo() ) {

				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$image          = wp_get_attachment_image_src( $custom_logo_id, 'full' );

				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
					<span class="ish-logo-box">
						<span class="ish-logo-middle">
							<img src="<?php echo esc_url( $image[0] ); ?>" class="ish-logo custom-logo" alt="Logo" />
						</span>
					</span>
				</a>
				<?php
			}
		}
	}
}


if ( ! function_exists( 'qusq_lite_has_tagline' ) ) {
	/**
	 * Returns true if tagline set
	 */
	function qusq_lite_has_tagline() {
		$description = get_bloginfo( 'description', 'display' );
		return ( $description || is_customize_preview() );
	}
}


if ( ! function_exists( 'qusq_lite_the_tagline' ) ) {
	/**
	 * Displays the site tagline
	 *
	 * Does nothing if tagline not available.
	 */
	function qusq_lite_the_tagline() {

		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) {
			echo esc_html( $description ); /* WPCS: xss ok. */
		}
	}
}


if ( ! function_exists( 'qusq_lite_output_classes' ) ) {
	/**
	 * Output the classes attached to the given handler
	 *
	 * @param string       $handle A handle representing part of the content.
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function qusq_lite_output_classes( $handle, $class ) {

		if ( 1 === func_num_args() ) {
			$class = $handle;
		}

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $class, $classes );
		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}

		// Apply esc_attr to the classes.
		$classes = array_map( 'esc_attr', $classes );

		// A hook to further manipulate the classes.
		$classes = apply_filters( $handle, $classes, $class );

		// Separates classes with a single space, collates classes for body element.
		echo esc_attr( join( ' ', $classes ) );
	}
}


if ( ! function_exists( 'qusq_lite_the_advanced_title' ) ) {
	/**
	 * Displays the site tagline
	 *
	 * Does nothing if tagline not available.
	 */
	function qusq_lite_the_advanced_title() {

		// Allow plugins/modules to output custom Taglines.
		do_action( 'qusq_lite_the_advanced_title_before' );

		// Allow plugins/modules to enable/disable standard taglines.
		if ( apply_filters( 'qusq_lite_the_advanced_title_continue', true ) ) {

			if ( is_home() ) {

				qusq_lite_blog_overview_title();

			} elseif ( is_archive() ) {

				qusq_lite_archive_title();

			} elseif ( is_singular( 'post' ) ) {

				qusq_lite_single_post_title();

			} elseif ( is_404() ) {

				qusq_lite_the_404_title();

			} elseif ( is_search() ) {

				qusq_lite_the_search_title();

			} elseif ( false !== get_the_ID() ) {

				// Set current post so we can use in_loop data.
				setup_postdata( get_the_ID() );

				// Split content if there are two separators right after each other ( with empty lines in between ).
				$qusq_lite_post_content = preg_split( '#<hr \/>\s*<hr \/>#', get_the_content(), 2 );

				if ( isset( $qusq_lite_post_content[1] ) ) {
					// Get titles from content.
					echo wp_kses_post( wpautop( $qusq_lite_post_content[0] ) );
				} else { ?>
					<h1 class="site-title"><?php echo wp_kses_post( get_the_title() ); ?></h1>
				<?php }

				// Reset Loop to the previous state.
				wp_reset_postdata();

			} // End if().
		} // End if().

		// Allow plugins/modules to output custom Taglines after the regular ones.
		do_action( 'qusq_lite_the_advanced_title_after' );

	}
} // End if().


if ( ! function_exists( 'qusq_lite_get_post_thumbnail_caption' ) ) {
	/**
	 * Displays the image caption of the current post Thumbnail
	 *
	 * @param int $id The id of the current Thumbnail.
	 *
	 * @return string - Returns an empty string if caption empty.
	 */
	function qusq_lite_get_post_thumbnail_caption( $id = null ) {

		// Get Thumbnail ID if no specific id provided.
		if ( null === $id ) {
			$id = get_post_thumbnail_id();
		}

		$qusq_lite_post = get_post( $id );

		return ( $qusq_lite_post ) ? $qusq_lite_post->post_excerpt : '';
	}
}


if ( ! function_exists( 'qusq_lite_theme_archive_title' ) ) {
	/**
	 * Get rid of the “Category:”, “Tag:”, “Author:”, “Archives:” and “Other taxonomy name:” in the archive title
	 *
	 * @param string $title The current Archive Title.
	 *
	 * @return string
	 */
	function qusq_lite_theme_archive_title( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_year() ) {
			$title = get_the_date( _x( 'Y', 'yearly archives date format', 'qusq-lite' ) );
		} elseif ( is_month() ) {
			$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'qusq-lite' ) );
		} elseif ( is_day() ) {
			$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'qusq-lite' ) );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		}

		return $title;
	}
}
add_filter( 'get_the_archive_title', 'qusq_lite_theme_archive_title' );



if ( ! function_exists( 'qusq_lite_custom_comment_structure' ) ) {
	/**
	 * Custom Qusq Lite comments structure.
	 *
	 * @param object $qusq_lite_comment The comment object.
	 * @param array  $qusq_lite_args The arguments used in query.
	 * @param int    $qusq_lite_depth The current depth.
	 */
	function qusq_lite_custom_comment_structure( $qusq_lite_comment, $qusq_lite_args, $qusq_lite_depth ) {
		global $post;

		if ( 'div' === $qusq_lite_args['style'] ) {
			$qusq_lite_tag       = 'div';
			$qusq_lite_add_below = 'comment';
		} else {
			$qusq_lite_tag       = 'li';
			$qusq_lite_add_below = 'div-comment';
		}
		?>
		<<?php echo esc_html( $qusq_lite_tag ); ?> <?php comment_class( empty( $qusq_lite_args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' !== $qusq_lite_args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<div class="comment-meta">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php
			if ( 0 !== $qusq_lite_args['avatar_size'] ) {
				echo get_avatar( $qusq_lite_comment, $qusq_lite_args['avatar_size'] );
			}
			?>
			<?php
			if ( ( 'pingback' === $qusq_lite_comment->comment_type || 'trackback' === $qusq_lite_comment->comment_type ) ) {
				echo esc_html( ucfirst( $qusq_lite_comment->comment_type ) . ': ' );
				comment_author_link();
			} else {
				printf( esc_html( get_comment_author() ) );
			}
			?>

			<?php
			if ( $qusq_lite_comment->user_id === $post->post_author ) {
				echo ' ( ' . esc_html__( 'Author', 'qusq-lite' ) . ' )';
			}
			?>
		</div>
		<?php if ( '0' === $qusq_lite_comment->comment_approved ) : ?>
			<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'qusq-lite' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-metadata">
			<a href="<?php echo esc_attr( get_comment_link( $qusq_lite_comment->comment_ID ) ); ?>">
				<?php
				/* translators: 1: date, 2: time */
				printf( '%1$s at %2$s', get_comment_date(),  get_comment_time() );
				?>
			</a>
			<span class="edit-link">
				<?php edit_comment_link( esc_html__( 'Edit', 'qusq-lite' ), '  ', '' ); ?>
			</span>
			<span class="reply">
				<?php
				comment_reply_link(
					array_merge(
						$qusq_lite_args,
						array(
							'add_below' => $qusq_lite_add_below,
							'depth' => $qusq_lite_depth,
							'max_depth' => $qusq_lite_args['max_depth'],
						)
					)
				); ?>
			</span>
		</div>
		</div>

		<div class="comment-content">
			<?php
			if ( ! ( ( 'pingback' === $qusq_lite_comment->comment_type || 'trackback' === $qusq_lite_comment->comment_type ) && $qusq_lite_args['short_ping'] ) ) {
				// Display only when "short_ping" not true.
				comment_text();
			}
			?>

		</div>

		<?php if ( 'div' !== $qusq_lite_args['style'] ) : ?>
			</div>
		<?php endif; ?>
		<?php
	}
} // End if().


if ( ! function_exists( 'qusq_lite_open_comment_author_link_in_new_window' ) ) {
	/**
	 * Filter to Open Comment Author link in new window.
	 *
	 * @param string $author_link The url of the Author.
	 *
	 * @return string
	 */
	function qusq_lite_open_comment_author_link_in_new_window( $author_link ) {
		return str_replace( '<a', '<a target="_blank"', $author_link );
	}
}
add_filter( 'get_comment_author_link', 'qusq_lite_open_comment_author_link_in_new_window' );


if ( ! function_exists( 'qusq_lite_move_comment_field' ) ) {
	/**
	 * Move comment field under inputs ( name, email, url ).
	 *
	 * @param array $qusq_lite_fields The field options.
	 *
	 * @return array
	 */
	function qusq_lite_move_comment_field( $qusq_lite_fields ) {
		$comment_field = $qusq_lite_fields['comment'];
		unset( $qusq_lite_fields['comment'] );
		$qusq_lite_fields['comment'] = $comment_field;
		return $qusq_lite_fields;
	}
}
add_filter( 'comment_form_fields', 'qusq_lite_move_comment_field' );


if ( ! function_exists( 'qusq_lite_get_custom_comment_form' ) ) {
	/**
	 * Create custom form with placeholders for comments.
	 */
	function qusq_lite_get_custom_comment_form() {
		$qusq_lite_commenter = wp_get_current_commenter();
		$qusq_lite_req = get_option( 'require_name_email' );
		$qusq_lite_aria_req = ( $qusq_lite_req ? " aria-required='true'" : '' );
		$qusq_lite_fields = array(
			'author' =>
				'<p class="comment-form-author">' .
				'<label for="author">' . esc_html__( 'Name', 'qusq-lite' ) . ( $qusq_lite_req ? ' *' : '' ) . '</label>' .
				'<input id="author" name="author" type="text" value="' . esc_attr( $qusq_lite_commenter['comment_author'] ) .
				'" size="30"' . $qusq_lite_aria_req . ' placeholder="' . esc_attr__( 'Name', 'qusq-lite' ) . ( $qusq_lite_req ? ' *' : '' ) . '" /></p>',

			'email' =>
				'<p class="comment-form-email">' .
				'<label for="email">' . esc_html__( 'Email', 'qusq-lite' ) . ( $qusq_lite_req ? ' *' : '' ) . '</label>' .
				'<input id="email" name="email" type="text" value="' . esc_attr( $qusq_lite_commenter['comment_author_email'] ) .
				'" size="30"' . $qusq_lite_aria_req . ' placeholder="' . esc_attr__( 'Email', 'qusq-lite' ) . ( $qusq_lite_req ? ' *' : '' ) . '" /></p>',

			'url' =>
				'<p class="comment-form-url">' .
				'<label for="url">' . esc_html__( 'Website', 'qusq-lite' ) . '</label>' .
				'<input id="url" name="url" type="text" value="' . esc_attr( $qusq_lite_commenter['comment_author_url'] ) .
				'" size="30" placeholder="' . esc_attr__( 'Website', 'qusq-lite' ) . '" /></p>',
		);
		$qusq_lite_args = array(
			'fields' => apply_filters( 'comment_form_default_fields', $qusq_lite_fields ),
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'qusq-lite' ) . ' *</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_attr__( 'Message', 'qusq-lite' ) . ' *"></textarea></p>',
			'title_reply' => esc_html__( 'Add Comment', 'qusq-lite' ),
			'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
			'title_reply_after' => '</h4>',
			'cancel_reply_link' => esc_html__( 'Cancel reply', 'qusq-lite' ),
			'cancel_reply_before' => '<small class="ish-cancel-reply">',
			'cancel_reply_after' => '</small>',
		);

		comment_form( $qusq_lite_args );
	}
} // End if().


if ( ! function_exists( 'qusq_lite_get_team_captions_position_class' ) ) {
	/**
	 * Returns captions position class
	 */
	function qusq_lite_get_team_captions_position_class() {
		global $qusq_lite_team_archive_items_output;

		if ( ! $qusq_lite_team_archive_items_output && ! is_numeric( $qusq_lite_team_archive_items_output ) ) {
			$qusq_lite_team_archive_items_output = 0;
		}

		$qusq_lite_team_archive_items_output++;

		return ( 0 !== $qusq_lite_team_archive_items_output % 2 ) ? 'ish-captions-right' : 'ish-captions-left';
	}
}


if ( ! function_exists( 'qusq_lite_the_404_title' ) ) {
	/**
	 * Returns titles for 404 Page
	 */
	function qusq_lite_the_404_title() {
		?>
		<h1 class="site-title"><?php echo wp_kses_post( __( '404 <span>Ooops!</span>', 'qusq-lite' ) ); ?></h1>
		<h2 class="site-subtitle"><?php echo wp_kses_post( __( "Seems like there's <span>no such page</span>.", 'qusq-lite' ) ); ?></h2>
		<p class="site-desc"><span><?php echo esc_html__( "We've searched more than 404 pages and none of them seems to be the one you were looking for. Why don't you have a look around? Start in the main menu...", 'qusq-lite' ); ?></span></p>
		<?php
	}
}


if ( ! function_exists( 'qusq_lite_search_request_filter' ) ) {
	/**
	 * Returns space for search value if this value is empty
	 *
	 * @param array $query_vars The Query variables.
	 *
	 * @return array
	 */
	function qusq_lite_search_request_filter( $query_vars ) {
		if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
			$query_vars['s'] = ' ';
		}

		return $query_vars;
	}
}
add_filter( 'request', 'qusq_lite_search_request_filter' );


if ( ! function_exists( 'qusq_lite_the_search_title' ) ) {
	/**
	 * Returns titles for Search Page
	 */
	function qusq_lite_the_search_title() {
		?>
		<h1 class="site-title"><span><?php esc_html_e( 'Search Results for:', 'qusq-lite' ); ?></span></h1>

		<?php if ( '' !== get_search_query() ) { ?>
			<h2 class="site-subtitle"><?php the_search_query(); ?></h2>
		<?php }

		qusq_lite_results_count( 'result found', 'results found' );
	}
}


if ( ! function_exists( 'qusq_lite_blog_overview_title' ) ) {
	/**
	 * Returns titles for Blog Overview Page
	 */
	function qusq_lite_blog_overview_title() {

		if ( is_home() ) {
			// Only if Blog overview page.
			if ( is_front_page() || ! get_option( 'page_on_front', false ) ) {

				// If we are on homepage - Show latest posts.
				// Find page with "blog" slug.
				$qusq_lite_blog_page = get_page_by_path( apply_filters( 'qusq_lite_blog_overview_title_page_slug', 'blog' ) );

				if ( $qusq_lite_blog_page ) {

					// Set current post so we can use in_loop data.
					setup_postdata( $qusq_lite_blog_page->ID );

					// Split content if there are two separators right after each other ( with empty lines in between ).
					$qusq_lite_post_content = preg_split( '#<hr \/>\s*<hr \/>#', get_the_content(), 2 );

					if ( isset( $qusq_lite_post_content[1] ) ) {
						// Get titles from content.
						echo wp_kses_post( wpautop( $qusq_lite_post_content[0] ) );
					} else { ?>
						<h1 class="site-title"><?php echo wp_kses_post( get_the_title( $qusq_lite_blog_page->ID ) ); ?></h1>
					<?php }

					qusq_lite_results_count( esc_html__( 'Post Here', 'qusq-lite' ), esc_html__( 'Posts Here', 'qusq-lite' ) );

					// Reset Loop to the previous state.
					wp_reset_postdata();

				} else {
					?>
					<h1><span><?php bloginfo( 'name' ); ?></span></h1>
					<h2><span><?php qusq_lite_the_tagline(); ?></span></h2>
					<?php

                    // currently commented
//					qusq_lite_results_count( esc_html__( 'Post Here', 'qusq-lite' ), esc_html__( 'Posts Here', 'qusq-lite' ) );
				}

				// Stop executing the standard taglines check.
				add_filter( 'qusq_lite_the_advanced_title_continue', 'qusq_lite_the_advanced_title_continue_disable' );
			} else {
				// On a different page - Page for posts.
				$id = get_option( 'page_for_posts' );

				if ( $id ) {

					// Set current post so we can use in_loop data.
					setup_postdata( $id );

					// Split content if there are two separators right after each other ( with empty lines in between ).
					$qusq_lite_post_content = preg_split( '#<hr \/>\s*<hr \/>#', get_the_content(), 2 );

					if ( isset( $qusq_lite_post_content[1] ) ) {
						// Get titles from content.
						echo wp_kses_post( wpautop( $qusq_lite_post_content[0] ) );
					} else { ?>
						<h1 class="site-title"><?php echo wp_kses_post( get_the_title() ); ?></h1>
					<?php }

					// Reset Loop to the previous state.
					wp_reset_postdata();

					qusq_lite_results_count( esc_html__( 'Post Here', 'qusq-lite' ), esc_html__( 'Posts Here', 'qusq-lite' ) );

					// Stop executing the standard taglines check.
					add_filter( 'qusq_lite_the_advanced_title_continue', 'qusq_lite_the_advanced_title_continue_disable' );
				}
			} // End if().
		} // End if().
	}
} // End if().


if ( ! function_exists( 'qusq_lite_archive_title' ) ) {
	/**
	 * Returns titles for Archive Pages
	 */
	function qusq_lite_archive_title() {

		do_action( 'qusq_lite_archive_title_before' );

		$output_title = apply_filters( 'qusq_lite_archive_title_enabled', true );

		if ( $output_title ) {
			the_archive_title( '<h1 class="site-title"><span>', '</span></h1>' );
			the_archive_description( '<h2 class="archive-description">', '</h2>' );

			if ( is_archive() && ! is_post_type_archive() ) {
				// Blog Archive only.
				qusq_lite_results_count( esc_html__( 'Post Here', 'qusq-lite' ), esc_html__( 'Posts Here', 'qusq-lite' ) );
			}
		}

		do_action( 'qusq_lite_archive_title_after' );
	}
}


if ( ! function_exists( 'qusq_lite_single_post_title' ) ) {
	/**
	 * Returns titles for Archive Pages
	 */
	function qusq_lite_single_post_title() {

		// Set current post so we can use in_loop data.
		setup_postdata( get_the_ID() );

		// Split content if there are two separators right after each other ( with empty lines in between ).
		$qusq_lite_post_content = preg_split( '#<hr \/>\s*<hr \/>#', get_the_content(), 2 );

		if ( isset( $qusq_lite_post_content[1] ) ) {
			// Get titles from content.
			echo wp_kses_post( wpautop( $qusq_lite_post_content[0] ) );
		} else { ?>
			<h1 class="site-title"><?php echo wp_kses_post( get_the_title() ); ?></h1>
		<?php }
		?>

		<span>
			<?php
			esc_html_e( 'on ', 'qusq-lite' );
			?>
			<a href="<?php qusq_lite_get_day_link(); ?>" class="ish-underline ish-underline-visible"><?php echo get_the_date(); ?></a>
			<?php
			esc_html_e( ' / ', 'qusq-lite' );
			esc_html_e( 'in ', 'qusq-lite' );
			qusq_lite_get_the_post_categories( 'ish-underline ish-underline-visible' );
			?>
		</span>

		<?php
		// Reset Loop to the previous state.
		wp_reset_postdata();
	}
} // End if().

if ( ! function_exists( 'qusq_lite_results_count' ) ) {
	/**
	 * Returns number of posts found in the current query
	 *
	 * @param string $singular_expression Singular expression of the word for results.
	 * @param string $plural_expression Plural expression of the word for results.
	 */
	function qusq_lite_results_count( $singular_expression, $plural_expression ) {
		?>
		<p class="site-desc">
			<span>
				<?php
				if ( 1 !== qusq_lite_get_results_count() ) {
					/* translators: Number: Count of results followed by the word "Posts" or "Articles", etc in singular.. */
					echo sprintf( esc_html__( '%1$d %2$s', 'qusq-lite' ), esc_html( qusq_lite_get_results_count() ), esc_html( $plural_expression ) );
				} else {
					/* translators: Number: Count of results followed by the word "Posts" or "Articles", etc in plural.. */
					echo sprintf( esc_html__( '%1$d %2$s', 'qusq-lite' ), esc_html( qusq_lite_get_results_count() ), esc_html( $singular_expression ) );
				}
				?>
			</span>
		</p>
		<?php
	}
}


if ( ! function_exists( 'qusq_lite_get_results_count' ) ) {
	/**
	 * Returns number of posts found in the current query
	 */
	function qusq_lite_get_results_count() {
		global $wp_query;

		if ( is_object( $wp_query ) && isset( $wp_query->found_posts ) ) {
			return $wp_query->found_posts;
		}

		return 0;
	}
}


if ( ! function_exists( 'qusq_lite_get_day_link' ) ) {
	/**
	 * Returns link for displaying daily archive
	 */
	function qusq_lite_get_day_link() {
		echo esc_url( get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) ) );
	}
}


if ( ! function_exists( 'qusq_lite_results_odd_even_classes' ) ) {
	/**
	 * Adds classes to Search Results to indent every even one.
	 *
	 * @param array $classes The CSS classes already attached.
	 *
	 * @return array
	 */
	function qusq_lite_results_odd_even_classes( $classes ) {
		global $qusq_lite_current_result_odd;

		if ( ! is_bool( $qusq_lite_current_result_odd ) ) {
			$qusq_lite_current_result_odd = false;
		}

		if ( is_search() ) {
			$qusq_lite_current_result_odd = ! $qusq_lite_current_result_odd;
			$qusq_lite_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 0;
			$qusq_lite_posts_per_page = ( get_query_var( 'posts_per_page' ) ) ? get_query_var( 'posts_per_page' ) : 7;

			// Switch offset for odd / even page and odd / even posts per page.
			if ( ( 0 === $qusq_lite_paged % 2 ) && ( 1 === $qusq_lite_posts_per_page % 2 ) ) {
				if ( $qusq_lite_current_result_odd ) {
					$classes[] = 'ish-col-xs-offset-0';
					$classes[] = 'ish-col-sm-offset-1';
				}
			} else {
				if ( ! $qusq_lite_current_result_odd ) {
					$classes[] = 'ish-col-xs-offset-0';
					$classes[] = 'ish-col-sm-offset-1';
				}
			}
		}

		return $classes;
	}
} // End if().
add_filter( 'post_class' , 'qusq_lite_results_odd_even_classes' );


if ( ! function_exists( 'qusq_lite_results_random_color_classes' ) ) {
	/**
	 * Adds "random" color class to Search Result. The colors are rotated.
	 *
	 * @param array $classes The CSS classes already attached.
	 *
	 * @return array
	 */
	function qusq_lite_results_random_color_classes( $classes ) {
		global $qusq_lite_results_colors_array;

		if ( is_search() ) {
			if ( ! is_array( $qusq_lite_results_colors_array ) ) {
				$qusq_lite_results_colors_array = array( 14, 6, 13, 10, 1, 5, 9 );
			}

			$qusq_lite_curent = array_shift( $qusq_lite_results_colors_array );
			array_push( $qusq_lite_results_colors_array, $qusq_lite_curent );
			$classes[] = 'ish-color' . esc_attr( $qusq_lite_curent );
		}

		return $classes;
	}
}
add_filter( 'post_class' , 'qusq_lite_results_random_color_classes' );


if ( ! function_exists( 'qusq_lite_tagline_no_logo_class' ) ) {
	/**
	 * Adds no logo class to tagline area
	 *
	 * @param array $classes The CSS classes already attached.
	 *
	 * @return array
	 */
	function qusq_lite_tagline_no_logo_class( $classes ) {

		if ( ! function_exists( 'has_custom_logo' ) || ! has_custom_logo() ) {
			$classes[] = 'ish-no-logo';
		}

		return $classes;
	}
}
add_filter( 'qusq_lite_output_classes_tagline', 'qusq_lite_tagline_no_logo_class' );


if ( ! function_exists( 'qusq_lite_adjacent_post_link' ) ) {
	/**
	 * Display disabled post link when no prev/next post exist
	 *
	 * @param string $output The html output for the adjacent post link.
	 * @param string $format The format.
	 * @param string $link The post link.
	 * @param object $post The post itself.
	 * @param object $adjacent No idea.
	 *
	 * @return string The final output
	 */
	function qusq_lite_adjacent_post_link( $output, $format, $link, $post, $adjacent ) {

		if ( '' === $output ) {
			$inlink = '<div class="ish-disabled">' . $link . '</div>';
			$output = str_replace( '%link', $inlink, $format );
		}

		return $output;
	}
}
add_filter( 'next_post_link', 'qusq_lite_adjacent_post_link', 20, 5 );
add_filter( 'previous_post_link', 'qusq_lite_adjacent_post_link', 20, 5 );


if ( ! function_exists( 'qusq_lite_the_posts_navigation' ) ) {
	/**
	 * Custom posts navigation with displaying empty prev/next pagination link
	 *
	 * @param array $args The arguments.
	 * @param int   $max_page number.
	 *
	 * @return void
	 */
	function qusq_lite_the_posts_navigation( $args = array(), $max_page = null ) {
		// Don't display navigation when infinite-scroll is enabled.
		if ( ! ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ) {
			global $wp_query, $paged;
			$navigation = '';

			if ( null === $max_page ) {
				$max_page = $wp_query->max_num_pages;
			}

			// Don't print empty markup if there's only one page.
			if ( $max_page > 1 ) {
				$args = wp_parse_args( $args, array(
					'prev_text'          => esc_html__( 'Older posts', 'qusq-lite' ),
					'next_text'          => esc_html__( 'Newer posts', 'qusq-lite' ),
					'screen_reader_text' => esc_html__( 'Posts navigation', 'qusq-lite' ),
				) );

				$next_link = get_previous_posts_link( $args['next_text'] );
				$prev_link = get_next_posts_link( $args['prev_text'], $max_page );

				$navigation .= '<div class="nav-previous">';

				if ( $prev_link ) {
					$navigation .= $prev_link;
				} else {
					$navigation .= '<div class="ish-prev ish-page-numbers ish-icon-right-small ish-disabled"></div>';
				}

				$navigation .= '</div>';
				$navigation .= '<div class="nav-next">';

				if ( $next_link ) {
					$navigation .= $next_link;
				} else {
					$navigation .= '<div class="ish-next ish-page-numbers ish-icon-left-small ish-disabled"></div>';
				}

				$navigation .= '</div>';

				$navigation = _navigation_markup( $navigation, 'posts-navigation', $args['screen_reader_text'] );
			}

			echo wp_kses_post( $navigation );
		} // End if().
	}
} // End if().


if ( ! function_exists( 'qusq_lite_search_results_number' ) ) {
	/**
	 * Return number of search result post.
	 *
	 * @return string
	 */
	function qusq_lite_search_results_number() {

		global $wp_query;

		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ) {
			$qusq_lite_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 0;
		} else {
			$qusq_lite_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$qusq_lite_paged--;
		}

		if ( is_object( $wp_query ) && isset( $wp_query->current_post ) ) {

			$qusq_lite_current_post = $wp_query->current_post + 1; // It begins from 0, but we need to begin from 1.
			$qusq_lite_posts_per_page = ( get_query_var( 'posts_per_page' ) ) ? get_query_var( 'posts_per_page' ) : 7;
			$qusq_lite_result = $qusq_lite_paged * $qusq_lite_posts_per_page + $qusq_lite_current_post;

			// Adds 0 before number when number is smaller then 10 | converting to two-digit number.
			$qusq_lite_result = ( 10 > $qusq_lite_result ) ? '0' . $qusq_lite_result : (string) $qusq_lite_result;

			return $qusq_lite_result;
		}

		return 0;

	}
}


if ( ! function_exists( 'qusq_lite_get_theme_colors_array' ) ) {
	/**
	 * Return array containing all theme colors
	 *
	 * @return array
	 */
	function qusq_lite_get_theme_colors_array() {

		$defaults = array(
			1 => '#f3317a',
			2 => '#515151',
			3 => '#fcfcfc',
			4 => '#ffffff',
			5 => '#7cd3ce',
			6 => '#1cbbe3',
			7 => '#c2bcb5',
			8 => '#5dc4be',
			9 => '#dd613b',
			10 => '#a1744f',
			11 => '#37bdb6',
			12 => '#bda949',
			13 => '#f3d600',
			14 => '#acde61',
			15 => '#f33131',
			16 => '#4be5c3',
			17 => '#d4c873',
			18 => '#f0be43',
			19 => '#502b46',
			20 => '#672943',
			21 => '#9dbc96',
			22 => '#0096BB',
		);

		$defaults = apply_filters( 'qusq_lite_default_colors_array', $defaults );

		foreach ( $defaults as $key => $value ) {
			$defaults[ $key ] = get_theme_mod( 'qusq_lite_color' . esc_html( $key ), esc_html( $value ) );
		}

		return apply_filters( 'qusq_lite_theme_colors', $defaults );
	}
} // End if().


if ( ! function_exists( 'qusq_lite_get_labeled_theme_colors_array' ) ) {
	/**
	 * Return array containing all theme colors with labels.
	 *
	 * @return string
	 */
	function qusq_lite_get_labeled_theme_colors_array() {

		$colors = array();

		foreach ( qusq_lite_get_theme_colors_array() as $key => $value ) {
			$colors[ esc_html__( 'Color ', 'qusq-lite' ) . $key ] = $value;
		}

		return apply_filters( 'qusq_lite_labeled_theme_colors', $colors );
	}
}


if ( ! function_exists( 'qusq_lite_sass_lighten_darken' ) ) {
	/**
	 * Returns the lightened / darkened color from a given value as in sass
	 *
	 * @param string $hex - The color in hex format "#ffffff".
	 * @param string $percent - The percentage.
	 *
	 * @return string $hex
	 */
	function qusq_lite_sass_lighten_darken( $hex, $percent ) {

		// Number has to be without char %.
		$percent = str_replace( '%', '', $percent );

		// Steps should be between -255 and 255. Negative = darker, positive = lighter.
		$step = 255 * ( $percent / 100 );
		$step = max( -255, min( 255, $step ) );

		// Normalize into a six character long hex string.
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) === 3 ) {
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
		}

		// Split into three parts: R, G and B.
		$color_parts = str_split( $hex, 2 );
		$return = '#';

		foreach ( $color_parts as $color ) {
			$color   = hexdec( $color ); // Convert to decimal.
			$color   = max( 0,min( 255,$color + $step ) ); // Adjust color.
			$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code.
		}

		return $return;
	}
} // End if().

if ( ! function_exists( 'qusq_lite_get_color_contrast' ) ) {
	/**
	 * Returns the contrast color for a given hex color value ( e.g. #ffffff )
	 *
	 * @param string $hexcolor - The color in hex format "#ffffff".
	 *
	 * @return string
	 */
	function qusq_lite_get_color_contrast( $hexcolor ) {
		// Remove the "#" from the beginning.
		$hexcolor = substr( $hexcolor, 1 );

		$r = hexdec( substr( $hexcolor, 0, 2 ) );
		$g = hexdec( substr( $hexcolor, 2, 2 ) );
		$b = hexdec( substr( $hexcolor, 4, 2 ) );
		$yiq = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;
		return ( $yiq >= 200 ) ? '#000000' : '#ffffff';
	}
}


if ( ! function_exists( 'qusq_lite_is_portfolio_squared' ) ) {
	/**
	 * Checks portfolio layout type
	 *
	 * @return bool
	 */
	function qusq_lite_is_portfolio_squared() {

		return apply_filters( 'qusq_lite_is_portfolio_squared', false );
	}
}


if ( ! function_exists( 'qusq_lite_is_portfolio_popup' ) ) {
	/**
	 * Checks portfolio layout type
	 *
	 * @return bool
	 */
	function qusq_lite_is_portfolio_popup() {

		return apply_filters( 'qusq_lite_is_portfolio_popup', false );
	}
}


if ( ! function_exists( 'qusq_lite_get_homepage_portfolio_query' ) ) {
	/**
	 * Checks portfolio layout type
	 *
	 * @return WP_Query
	 */
	function qusq_lite_get_homepage_portfolio_query() {

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		$qusq_lite_query = new WP_Query( array(
			'post_type' => 'jetpack-portfolio',
			'post_status' => 'publish',
			'posts_per_page' => get_option( 'jetpack_portfolio_posts_per_page', 10 ),
			'paged' => $paged,
		) );

		return $qusq_lite_query;
	}
}

if ( ! function_exists( 'qusq_lite_blog_archive_sidebar_active' ) ) {
	/**
	 * Checks whether sidebar is enabled on archive pages
	 *
	 * @return bool
	 */
	function qusq_lite_blog_archive_sidebar_active() {
		return apply_filters( 'qusq_lite_blog_archive_sidebar_active', true );
	}
}

if ( ! function_exists( 'qusq_lite_blog_detail_sidebar_active' ) ) {
	/**
	 * Checks whether sidebar is enabled for post detail
	 *
	 * @return bool
	 */
	function qusq_lite_blog_detail_sidebar_active() {
		return apply_filters( 'qusq_lite_blog_detail_sidebar_active', true );
	}
}

if ( ! function_exists( 'qusq_lite_display_sidebar' ) ) {
	/**
	 * Checks whether sidebar should be used on the current page
	 *
	 * @return bool
	 */
	function qusq_lite_display_sidebar() {

		if ( is_singular( 'post' ) ) {
			$active = qusq_lite_blog_detail_sidebar_active();
		} else {
			$active = qusq_lite_blog_archive_sidebar_active() && ( is_home() || ( is_archive() && ! is_post_type_archive() ) );
		}

		return apply_filters( 'qusq_lite_display_sidebar', $active );
	}
}


if ( ! function_exists( 'qusq_lite_get_blog_layout' ) ) {
	/**
	 * Returns the Blog Layout style
	 *
	 * @return bool
	 */
	function qusq_lite_get_blog_layout() {
		return apply_filters( 'qusq_lite_get_blog_layout', 'classic' );
	}
}

if ( ! function_exists( 'qusq_lite_has_legals' ) ) {
	/**
	 * Checks whether custom legals are set
	 *
	 * @return bool
	 */
	function qusq_lite_has_legals() {
		return apply_filters( 'qusq_lite_has_legals', false );
	}
}

if ( ! function_exists( 'qusq_lite_get_legals' ) ) {
	/**
	 * Outputs the custom legals
	 *
	 * @return bool
	 */
	function qusq_lite_get_legals() {
		return apply_filters( 'qusq_lite_get_legals', '' );
	}
}

if ( ! function_exists( 'qusq_lite_has_sidenav_legals' ) ) {
	/**
	 * Checks whether custom Sidenav legals are set
	 *
	 * @return bool
	 */
	function qusq_lite_has_sidenav_legals() {
		return apply_filters( 'qusq_lite_has_sidenav_legals', false );
	}
}

if ( ! function_exists( 'qusq_lite_get_sidenav_legals' ) ) {
	/**
	 * Outputs the custom Sidenav legals
	 *
	 * @return bool
	 */
	function qusq_lite_get_sidenav_legals() {
		return apply_filters( 'qusq_lite_get_sidenav_legals', '' );
	}
}


if ( ! function_exists( 'qusq_lite_get_selected_about_user_id' ) ) {
	/**
	 * Checks whether custom legals are set
	 *
	 * @return bool
	 */
	function qusq_lite_get_selected_about_user_id() {
		return apply_filters( 'qusq_lite_get_selected_about_user_id', get_the_author_meta( 'ID' ) );
	}
}


if ( ! function_exists( 'qusq_lite_get_author_social_icons' ) ) {
	/**
	 * Returns the HTML of User social icons
	 *
	 * @param int $id The Author id.
	 *
	 * @return bool
	 */
	function qusq_lite_get_author_social_icons( $id ) {

		$icons = array();

		// Website.
		$data = get_the_author_meta( 'url', $id );
		if ( $data && '' !== $data ) {
			$icons['url'] = array(
				'link' => $data,
				'icon_class' => 'ish-icon-globe',
			);
		}

		$icons = apply_filters( 'qusq_lite_get_author_social_icons', $icons, $id );

		$return = '<p class="ish-social-box">';

		foreach ( $icons as $key => $value ) {
			$return .=
				'<span class="ish-' . esc_attr( $key ) . ' ish-sc-element ish-sc-icon ish-icon-xs">' .
				'<a href="' . esc_url( $value['link'] ) . '" target="_blank"><i class="' . esc_attr( $value['icon_class'] ) . '"></i></a>' .
				'</span>';
		}

		$return .= '</p>';

		return $return;

	}
} // End if().

/**
 * Adds theme support for various functionalities.
 */
function qusq_lite_default_theme_supports() {
	add_theme_support( 'custom-header', array() );
	add_theme_support( 'custom-background', array() );
}

/**
 * Returns sanitized content
 *
 * @param mixed $input The input.
 *
 * @return mixed
 */
function qusq_lite_setting_sanitize_callback( $input ) {
	return $input;
}

if ( ! function_exists( 'qusq_lite_excerpt_length' ) ) {
	/**
	 * Filter to modify the length of the excerpt based on the current template
	 *
	 * @param int $length The length of the excerpt.
	 *
	 * @return int
	 */
	function qusq_lite_excerpt_length( $length ) {

		if ( is_search() ) {
			$length = 25;
		} elseif ( is_archive() || is_home() ) {
			$length = 20;
		}

		return $length;
	}
}
add_filter( 'excerpt_length', 'qusq_lite_excerpt_length' );


if ( ! function_exists( 'qusq_lite_excerpt_more' ) ) {
	/**
	 * Filters the string in the "more" link displayed after a trimmed excerpt.
	 *
	 * @param string $more_string The string shown within the more link.
	 *
	 * @return string
	 */
	function qusq_lite_excerpt_more( $more_string ) {

		$more_string = '&hellip;';

		return $more_string;
	}
}
add_filter( 'excerpt_more', 'qusq_lite_excerpt_more' );








