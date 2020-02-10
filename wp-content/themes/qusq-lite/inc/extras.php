<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Qusq_Lite
 */

if ( ! function_exists( 'qusq_lite_google_fonts_url' ) ) {
	/**
	 * Add/link google fonts into theme.
	 * Font name: Varela Round
	 */
	function qusq_lite_google_fonts_url() {
		$qusq_lite_fonts_url = '';

		/*
		* Translators: If there are characters in your language that are not
        * supported by Varela Round, translate this to 'off'. Do not translate
        * into your own language.
        */
		$varela_round = _x( 'on', 'Varela Round font: on or off', 'qusq-lite' );

		if ( 'off' !== $varela_round ) {
			$qusq_lite_font_families[] = 'Varela+Round';

			$qusq_lite_query_args = array(
				'family' => rawurlencode( implode( '|', $qusq_lite_font_families ) ),
			);

			$qusq_lite_fonts_url = add_query_arg( $qusq_lite_query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $qusq_lite_fonts_url );
	}
}


if ( ! function_exists( 'qusq_lite_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function qusq_lite_body_classes( $classes ) {
		// Adds ish-blurred class to all pages.
		$classes[] = 'ish-blurred';

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Add sidebar class.
		if ( qusq_lite_display_sidebar() ) {
			$classes[] = 'page-with-sidebar';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'qusq_lite_body_classes' );

if ( ! function_exists( 'qusq_lite_body_color_classes' ) ) {
	/**
	 * Adds custom color classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function qusq_lite_body_color_classes( $classes ) {
		$color = '';

		// Filters Before.
		$color = apply_filters( 'qusq_lite_before_body_color_class', $color, $classes );

		// Add color class.
		if ( '' === $color ) {
			if ( is_page_template( 'templates/team.php' ) ) {
				$color = 'ish-color13';
			} elseif ( is_404() ) {
				$color = 'ish-color15';
			} else {
				if ( empty( $color ) ) {
					$color = 'ish-color1';
				}
			}
		}

		// Filters After.
		$classes[] = apply_filters( 'qusq_lite_after_body_color_class', $color, $classes );

		return apply_filters( 'qusq_lite_body_color_classes', $classes );
	}
}
add_filter( 'body_class', 'qusq_lite_body_color_classes' );


if ( ! function_exists( 'qusq_lite_body_overlay_classes' ) ) {
	/**
	 * Adds content overlay classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function qusq_lite_body_overlay_classes( $classes ) {

		// Add overlay class.
		if ( is_404() ) {
			$classes[] = 'ish-no-content';
		} elseif ( is_search() || is_page_template( 'templates/contact.php' ) ) {
			$classes[] = 'ish-content-overlay-small';
		} elseif ( is_single() ) {
			$classes[] = 'ish-content-overlay-medium';
		} elseif ( is_page() ) {
			if ( is_page_template( 'templates/page-overlay-large.php' ) ) {
				$classes[] = 'ish-content-overlay-large';
			} elseif ( is_page_template( 'templates/page-overlay-medium.php' ) ) {
				$classes[] = 'ish-content-overlay-medium';
			} elseif ( is_page_template( 'templates/page-overlay-small.php' ) ) {
				$classes[] = 'ish-content-overlay-small';
			} elseif ( is_page_template( 'templates/homepage-portfolio.php' ) ) {
				$classes[] = 'ish-content-overlay-large';
			} elseif ( is_page_template( 'templates/about.php' ) ) {
				$classes[] = 'ish-content-overlay-medium';
			} elseif ( is_page_template( 'templates/team.php' ) ) {
				$classes[] = 'ish-content-overlay-medium';
			}
		} else {
			$classes[] = 'ish-content-overlay-large';
		} // End if().

		return $classes;
	}
} // End if().
add_filter( 'body_class', 'qusq_lite_body_overlay_classes' );


/**
 * Adds custom classes to the array of content classes.
 *
 * @param array $classes Classes for the content element.
 * @return string Array of classes parsed into string as attribute class="..."
 */
function qusq_lite_main_content_classes( $classes ) {
	// Temporary variables.
	$is_content_parallax = true;
	$is_blog_classic = ( 'classic' === qusq_lite_get_blog_layout() );

	// Adds main class for each content element.
	$classes[] = 'ish-main-content';

	// Adds parallax class into content.
	if ( $is_content_parallax ) {
		$classes[] = 'ish-content-parallax';
	}

	if ( is_home() || is_archive() ) {
		// Blog and all remaining CPT.
		$classes[] = 'ish-blog';

		// Adds a class about type of post.
		if ( $is_blog_classic ) {
			$classes[] = 'ish-blog-classic';
		} else {
			$classes[] = 'ish-blog-masonry';
			$classes[] = 'ish-scroll-anim';
		}
	}

	// Adds a class regarding 2 columns layout.
	if ( ! is_search() && ! is_page() && ! $is_blog_classic && have_posts() ) {
		$classes[] = 'ish-2col';
	}

	$classes = apply_filters( 'qusq_lite_main_content_classes', $classes );

	// ID added for infinite-scroll JetPack - don't remove.
	return join( ' ', $classes );
}


if ( ! function_exists( 'qusq_lite_next_posts_link_classes' ) ) {
	/**
	 * Adds classes to page navigation - next posts link.
	 *
	 * @return string Attribute class with required classes.
	 */
	function qusq_lite_next_posts_link_classes() {
		return 'class="ish-next ish-page-numbers ish-icon-right-small"';
	}
}
add_filter( 'next_posts_link_attributes', 'qusq_lite_next_posts_link_classes' );


if ( ! function_exists( 'qusq_lite_previous_posts_link_classes' ) ) {
	/**
	 * Adds classes to page navigation - previous posts link.
	 *
	 * @return string Attribute class with required classes.
	 */
	function qusq_lite_previous_posts_link_classes() {
		return 'class="ish-prev ish-page-numbers ish-icon-left-small"';
	}
}
add_filter( 'previous_posts_link_attributes', 'qusq_lite_previous_posts_link_classes' );


if ( ! function_exists( 'qusq_lite_check_read_more_tag_and_excerpt' ) ) {
	/**
	 * Shows the_content() if the "More tag" exists and the_excerpt() with max char length if it does not.
	 */
	function qusq_lite_check_read_more_tag_and_excerpt() {

		$post = get_post();

		if ( strpos( $post->post_content, '<!--more' ) ) {
			the_content();
		} else {
			the_excerpt();
		}

	}
}


if ( ! function_exists( 'qusq_lite_get_first_post_category' ) ) {
	/**
	 * Return first category of post.
	 *
	 * @param string $additional_classes    space separated class names.
	 *
	 * @return void
	 */
	function qusq_lite_get_first_post_category( $additional_classes = '' ) {
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="ish-underline ' . esc_attr( $additional_classes ) . '">' . esc_html( $categories[0]->name ) . '</a>';
		}
	}
}


if ( ! function_exists( 'qusq_lite_get_the_post_categories' ) ) {
	/**
	 * Return all post categories.
	 *
	 * @param string  $additional_classes  Optional. Classes to be added to every item.
	 * @param string  $before  Optional. Before list.
	 * @param string  $sep  Optional. Separate items using this.
	 * @param string  $after  Optional. After list.
	 * @param integer $skip  Optional. skip N items.
	 *
	 * @return void
	 */
	function qusq_lite_get_the_post_categories( $additional_classes = '', $before = null, $sep = ', ', $after = '', $skip = 0 ) {

		$categories = get_the_category();
		$the_categories = '';

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $key => $val ) {

				if ( $key > $skip - 1 ) {
					$the_categories .= '<a href="' . esc_url( get_category_link( $val->term_id ) ) . '" class="' . esc_attr( $additional_classes ) . '">' . esc_html( $val->name ) . '</a>';

					if ( count( $categories ) - 1 !== $key ) {
						$the_categories .= $sep;
					}
				}
			}
		}

		if ( ! is_wp_error( $the_categories ) && '' !== $the_categories ) {
			echo wp_kses_post( $before . $the_categories . $after );
		}
	}
}


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function qusq_lite_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'qusq_lite_pingback_header' );

/**
 * Removes all titles from the content above two consequent "hr" elements.
 * They are used as replacement of the titles so they are not needed in the content
 *
 * @param array $content The content of the given post.
 * @return string
 */
function qusq_lite_remove_tile_replacement_from_content( $content ) {

	// Split content if there are two separators right after each other ( with empty lines in between ).
	$qusq_lite_post_content = preg_split( '#<hr \/>\s*<hr \/>#', $content, 2 );

	if ( isset( $qusq_lite_post_content[1] ) ) {
		// Get titles from content.
		$content = $qusq_lite_post_content[1];
	}

	return $content;
}
add_filter( 'the_content', 'qusq_lite_remove_tile_replacement_from_content' );


/**
 * Returns an array of supported social links ( URL and icon class name ).
 *
 * @return array $social_links_icons
 */
function qusq_lite_social_links_icons() {

	// Supported social links icons.
	$qusq_lite_social_links_icons = array(
		'behance.net'           => 'ish-icon-behance',
		'bitbucket.org'         => 'ish-icon-bitbucket',
		'codepen.io'            => 'ish-icon-codeopen',
		'deviantart.com'        => 'ish-icon-deviantart',
		'digg.com'              => 'ish-icon-digg',
		'dribbble.com'          => 'ish-icon-dribbble',
		'dropbox.com'           => 'ish-icon-dropbox',
		'facebook.com'          => 'ish-icon-facebook',
		'flickr.com'            => 'ish-icon-flickr',
		'foursquare.com'        => 'ish-icon-foursquare',
		'plus.google.com'       => 'ish-icon-gplus',
		'github.com'            => 'ish-icon-github-circled',
		'instagram.com'         => 'ish-icon-instagram',
		'jsfiddle.net'          => 'ish-icon-jsfiddle',
		'last.fm'               => 'ish-icon-lastfm',
		'linkedin.com'          => 'ish-icon-linkedin',
		'mailto:'               => 'ish-icon-mail',
		'pinterest.com'         => 'ish-icon-pinterest-circled-1',
		'reddit.com'            => 'ish-icon-reddit',
		'renren.com'            => 'ish-icon-renren',
		'skype.com'             => 'ish-icon-skype',
		'skype:'                => 'ish-icon-skype',
		'slack.com'             => 'ish-icon-slack',
		'stackexchange.com'     => 'ish-icon-stackexchange',
		'stackoverflow.com'     => 'ish-icon-stackoverflow-1',
		'slideshare.net'        => 'ish-icon-slideshare',
		'snapchat.com'          => 'ish-icon-snapchat-ghost',
		'soundcloud.com'        => 'ish-icon-soundcloud-1',
		'spotify.com'           => 'ish-icon-spotify',
		'steamcommunity.com'    => 'ish-icon-steam',
		'stumbleupon.com'       => 'ish-icon-stumbleupon',
		'tel:'                  => 'ish-icon-phone',
		'tripadvisor.com'       => 'ish-icon-tripadvisor',
		'tumblr.com'            => 'ish-icon-tumblr',
		'twitch.tv'             => 'ish-icon-twitch',
		'twitter.com'           => 'ish-icon-twitter',
		'vimeo.com'             => 'ish-icon-vimeo-squared',
		'vine.co'               => 'ish-icon-vine',
		'vk.com'                => 'ish-icon-vkontakte',
		'weibo.com'             => 'ish-icon-weibo',
		'whatsapp:'             => 'ish-icon-whatsapp',
		'wordpress.'            => 'ish-icon-wordpress',
		'yelp.com'              => 'ish-icon-yelp',
		'youtube.com'           => 'ish-icon-youtube',
		'xing.com'              => 'ish-icon-xing',
	);

	/**
	 * Filter Qusq Lite social links icons.
	 *
	 * @since Qusq Lite 1.0
	 *
	 * @param array $qusq_lite_social_links_icons
	 */
	return apply_filters( 'qusq_lite_social_links_icons', $qusq_lite_social_links_icons );
}

/**
 * Display icons in social links menu.
 *
 * @param  string  $title       The menu item's title.
 * @param  WP_Post $item        Menu item object.
 * @param  array   $args        wp_nav_menu() arguments.
 * @param  int     $depth       Depth of the menu.
 * @return array   $atts        The menu item attributes with social icon class name added.
 */
function qusq_lite_nav_menu_social_icons( $title, $item, $args, $depth ) {
	// Get supported social icons.
	$social_icons = qusq_lite_social_links_icons();

	// Add social icon class name inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {

		foreach ( $social_icons as $attr => $value ) {
			if ( ! empty( $item->url ) && false !== strpos( $item->url , $attr ) ) {
				$title = '<i class="' . esc_attr( $value ) . '"></i><span class="ish-hide-text">' . esc_html( $title ) . '</span>';
			}
		}
	}

	return $title;
}
add_filter( 'nav_menu_item_title', 'qusq_lite_nav_menu_social_icons', 10, 4 );


if ( ! function_exists( 'qusq_lite_shortcode_from_content' ) ) {
	/**
	 * Takes shortcodes from content
	 *
	 * @param array $shortcode_array  Array with names of shortcodes.
	 */
	function qusq_lite_shortcode_from_content( $shortcode_array = array() ) {

		$pattern = get_shortcode_regex( $shortcode_array );
		preg_match_all( '/' . $pattern . '/s', get_the_content(), $shortcodes );

		foreach ( $shortcodes[0] as $shortcode ) {
			if ( isset( $shortcode ) ) {
				echo do_shortcode( $shortcode ) . '<br><br>';
			}
		}
	}
}


if ( ! function_exists( 'qusq_lite_the_content_without_shortcode' ) ) {
	/**
	 * Removes shortcodes from content
	 *
	 * @param string $content   Content of page / post.
	 * @return string
	 */
	function qusq_lite_the_content_without_shortcode( $content ) {

		if ( is_page_template( array( 'templates/contact.php', 'templates/contact-map.php' ) ) ) {
			$shortcode_array = array( 'contact-form', 'contact-form-7' );

			// Remove shortcodes from content.
			$pattern = get_shortcode_regex( $shortcode_array );
			$content = preg_replace( '/' . $pattern . '/s', '', $content );
		}

		return $content;

	}
}
add_filter( 'the_content', 'qusq_lite_the_content_without_shortcode', 6 );


// Adding gallery link type class into gallery - for standard wordpress gallery.
if ( ! function_exists( 'qusq_lite_post_gallery_remember_link_attribute' ) ) {
	/**
	 * Remember the link attribute of gallery shortcode
	 *
	 * @param string $output the html to be output.
	 * @param array  $attr attributes.
	 * @param string $instance the instance if any.
	 *
	 * @return string
	 */
	function qusq_lite_post_gallery_remember_link_attribute( $output, $attr, $instance = null ) {

		if ( isset( $attr['link'] ) ) {
			global $ish_gallery_attr_links;
			$ish_gallery_attr_links[ $instance ] = $attr['link'];
		}

		return $output;
	}
}
if ( ! function_exists( 'qusq_lite_post_gallery_add_link_attribute_class' ) ) {
	/**
	 * Adding class into gallery that inform about gallery link target
	 *
	 * @param string $output the string to be output.
	 *
	 * @return string
	 */
	function qusq_lite_post_gallery_add_link_attribute_class( $output ) {

		global $ish_gallery_attr_links;

		if ( isset( $ish_gallery_attr_links ) ) {

			foreach ( $ish_gallery_attr_links as $index => $link ) {
				if ( '' !== $link ) {
					if ( false !== strpos( $output, 'gallery-' . $index ) ) {
						$output = str_replace( 'class="gallery ', 'class="gallery gallery-target-' . esc_attr( $link ) . ' ', $output );
						$output = str_replace( 'class=\'gallery ', 'class=\'gallery gallery-target-' . esc_attr( $link ) . ' ', $output );
					}
				}
			}
		}

		return $output;
	}
}
add_filter( 'post_gallery', 'qusq_lite_post_gallery_remember_link_attribute', 10, 3 );
add_filter( 'gallery_style', 'qusq_lite_post_gallery_add_link_attribute_class' );


if ( ! function_exists( 'qusq_lite_prepend_attachment' ) ) {
	/**
	 * Amend the output of attchment pages a little
	 *
	 * @param string $output the string to be output.
	 *
	 * @return string
	 */
	function qusq_lite_prepend_attachment( $output ) {

		$post = get_post();

		if ( ! wp_attachment_is( 'video', $post ) && ! wp_attachment_is( 'audio', $post ) ) {
			$output = '<p class="attachment">';
			// show the medium sized image representation of the attachment if available, and link to the raw file.
			$output .= wp_get_attachment_link( 0, 'large', false );
			$output .= '</p>';
		}

		return $output;
	}
}
add_filter( 'prepend_attachment', 'qusq_lite_prepend_attachment' );


if ( ! function_exists( 'qusq_lite_the_password_form_add_color_class' ) ) {
	/**
	 * Filter to add color class to password protected post form
	 *
	 * @param string $output the string to be output.
	 *
	 * @return string
	 */
	function qusq_lite_the_password_form_add_color_class( $output ) {

		$output = str_replace( 'post-password-form', 'post-password-form ish--bc2 ish--tc4', $output );

		return $output;
	}
}
add_filter( 'the_password_form', 'qusq_lite_the_password_form_add_color_class' );
