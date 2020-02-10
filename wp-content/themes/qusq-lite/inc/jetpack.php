<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 *
 * @package Qusq_Lite
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function qusq_lite_jetpack_setup() {

	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'footer_widgets'    => false,
		'container'         => 'ish-main-content',
		'wrapper'           => false,
		'render'            => 'qusq_lite_infinite_scroll_render',
		'footer'            => false,
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Portfolio Custom Post Type.
	add_theme_support( 'jetpack-portfolio' );

	// Enable Custom Fields.
	add_post_type_support( 'jetpack-portfolio', 'custom-fields' );

	// Disable outputting the default JetPack custom field.
	add_filter( 'the_meta_key', 'qusq_lite_filter_portfolio_meta_fields', 10, 3 );

	// Disable outputting the default archives title.
	add_filter( 'qusq_lite_archive_title_enabled', 'qusq_lite_disable_regular_archive_title_on_portolio' );

	// Return titles for Archive Pages.
	add_action( 'qusq_lite_archive_title_before', 'qusq_lite_portfolio_archive_title' );

	// Remove Gallery Shortcode from the content on Portfolio Single.
	add_filter( 'the_content', 'qusq_lite_remove_gallery_from_content', 6 );

	// Remove First Headline from the content on Portfolio Single Default.
	add_filter( 'the_content', 'qusq_lite_remove_first_headline_from_content' );

	// Output the Portfolio Single navigation.
	add_action( 'qusq_lite_the_advanced_title_after', 'qusq_lite_single_portfolio_navigation' );

	// Add the correct content overlay class.
	add_filter( 'body_class', 'qusq_lite_portfolio_content_overlay_classes', 11 );

	// Add the correct portfolio archive classes.
	add_filter( 'qusq_lite_main_content_classes', 'qusq_lite_portfolio_archive_classes', 11 );

	// Adjust the HTML of the Contact Form.
	add_filter( 'grunion_contact_form_field_html', 'qusq_lite_grunion_contact_form_field_html', 10, 3 );

	// Activate modules in development mode.
	if ( class_exists( 'Jetpack' ) && Jetpack::is_development_mode() ) {

		// Enable Tiled Galleries Module.
		if ( ! Jetpack::is_module_active( 'tiled-gallery' ) ) {
			Jetpack::activate_module( 'tiled-gallery' );
		}
	}

	// Disable JetPack Carousel Completely.
	add_filter( 'jp_carousel_maybe_disable', 'qusq_lite_disable_jetpack_carousel' );

	// Disable JetPack Carousel again on a later time as it gets initiated from widget.
	add_action( 'jp_carousel_enqueue_assets', 'qusq_lite_disable_jetpack_carousel_after_widget' );

	// Adding gallery link type class into gallery after JetPack's filter.
	add_filter( 'post_gallery', 'qusq_lite_post_gallery_link_class', 1002, 3 );

	// Load script which enables LightGallery for the disabled JetPack Carousel.
	add_action( 'wp_enqueue_scripts', 'qusq_lite_lightgallery_jetpack_scripts' );

	// Enable infinite Scroll on non-standard queries as well.
	add_filter( 'infinite_scroll_archive_supported', 'qusq_lite_infinite_scroll_archive_supported', 10, 2 );

	// Load correct number of posts as set for the portfolio.
	add_filter( 'infinite_scroll_settings', 'qusq_lite_infinite_scroll_settings', 20 );

	// Load correct number of posts in AJAX.
	add_filter( 'infinite_scroll_query_args', 'qusq_lite_infinite_scroll_query_args', 20 );

	// Change the WP_Query object for Custom Loop to work.
	add_filter( 'infinite_scroll_query_object', 'qusq_lite_infinite_scroll_query_object', 20 );

	// Make Infinite scroll test the last batch for the custom query as well.
	add_filter( 'infinite_scroll_is_last_batch', 'qusq_lite_infinite_scroll_is_last_batch', 20, 3 );

	// Highlight Portfolio Archive page in wp_nav_menu.
	add_action( 'nav_menu_css_class', 'qusq_lite_highlight_portfolio_archive_in_menu', 10, 2 );

}
add_action( 'after_setup_theme', 'qusq_lite_jetpack_setup' );


if ( ! function_exists( 'qusq_lite_lightgallery_jetpack_scripts' ) ) {
	/**
	 * Action to load script which enables LightGallery for the disabled JetPack Carousel
	 */
	function qusq_lite_lightgallery_jetpack_scripts() {
		wp_enqueue_script( 'qusq-lite-lightgallery-jetpack', get_template_directory_uri() . '/js/lightgallery-jetpack.js', array( 'qusq-lite-main' ), '20151215', true );
	}
}


if ( ! function_exists( 'qusq_lite_disable_jetpack_carousel' ) ) {
	/**
	 * Filter to disable JetPack Carousel
	 *
	 * @param bool $disable the default value.
	 * @return bool
	 */
	function qusq_lite_disable_jetpack_carousel( $disable ) {
		return true;
	}
}


if ( ! function_exists( 'qusq_lite_disable_jetpack_carousel_after_widget' ) ) {
	/**
	 * Action to disable JetPack Carousel
	 */
	function qusq_lite_disable_jetpack_carousel_after_widget() {
		wp_dequeue_script( 'jetpack-carousel' );
	}
}


if ( ! function_exists( 'qusq_lite_post_gallery_link_class' ) ) {
	/**
	 * Adding class into gallery that inform about gallery link
	 *
	 * @param string $output the string to be output.
	 * @param array  $attr link attributes.
	 * @param string $instance unused.
	 * @return string
	 */
	function qusq_lite_post_gallery_link_class( $output, $attr, $instance = null ) {

		if ( isset( $attr['link'] ) ) {
			$output = str_replace( 'tiled-gallery ', 'tiled-gallery tiled-gallery-' . esc_attr( $attr['link'] ) . ' ', $output );
		}

		return $output;
	}
}


/**
 * Custom render function for Infinite Scroll.
 */
function qusq_lite_infinite_scroll_render() {

	while ( have_posts() ) {
		the_post();

		if ( is_search() ) {
			get_template_part( 'template-parts/content', 'search' );
		} elseif ( ( 'jetpack-portfolio' === get_post_type() ) || is_page_template( 'templates/homepage-portfolio.php' ) ) {
			get_template_part( 'template-parts/archive/archive-portfolio' );
		} else {
			get_template_part( 'template-parts/archive/archive', get_post_format() );
		};
	}

}



if ( ! function_exists( 'qusq_lite_infinite_scroll_archive_supported' ) ) {
	/**
	 * Filter to enable Infinite Scroll on other parts of web as well.
	 *
	 * @param bool   $supported Does the Archive page support Infinite Scroll.
	 * @param object $settings IS settings provided by theme.
	 *
	 * @return bool $supported enable or not
	 */
	function qusq_lite_infinite_scroll_archive_supported( $supported, $settings ) {

		// Enable Infinite Scroll on Homepage Portfolio Template.
		if ( current_theme_supports( 'infinite-scroll' ) && ( is_page_template( 'templates/homepage-portfolio.php' ) ) ) {
			$supported = true;
		}

		return $supported;
	}
}


if ( ! function_exists( 'qusq_lite_infinite_scroll_settings' ) ) {
	/**
	 * Filter to change the posts_per_page Infinite Scroll setting on portfolio
	 *
	 * @param object $settings infinite scroll settings.
	 *
	 * @return object
	 */
	function qusq_lite_infinite_scroll_settings( $settings ) {

		// Use Portfolio Settings' posts_per_page on Homepage Portfolio Template.
		if ( ( is_post_type_archive( 'jetpack-portfolio' ) || is_page_template( 'templates/homepage-portfolio.php' ) ) && isset( $settings ) ) {
			$settings['posts_per_page'] = get_option( 'jetpack_portfolio_posts_per_page', 10 );
		}

		return $settings;
	}
}


if ( ! function_exists( 'qusq_lite_infinite_scroll_query_args' ) ) {
	/**
	 * Filter to change the posts_per_page Infinite Scroll setting on portfolio during AJAX
	 *
	 * @param object $query_args the arguments of the query.
	 *
	 * @return object
	 */
	function qusq_lite_infinite_scroll_query_args( $query_args ) {

		// Use Portfolio Settings' posts_per_page on Homepage Portfolio Template.
		if ( isset( $query_args ) && isset( $query_args['post_type'] ) && 'jetpack-portfolio' === $query_args['post_type'] ) {
			$query_args['posts_per_page'] = get_option( 'jetpack_portfolio_posts_per_page', 10 );
		}

		return $query_args;
	}
}


if ( ! function_exists( 'qusq_lite_infinite_scroll_query_object' ) ) {
	/**
	 * Change the WP_Query object for Custom Loop to work
	 *
	 * @param object $wp_the_query the arguments of the query.
	 *
	 * @return object
	 */
	function qusq_lite_infinite_scroll_query_object( $wp_the_query ) {

		// Modify the query to use the loop inside the template.
		if ( is_page_template( 'templates/homepage-portfolio.php' ) ) {
			return qusq_lite_get_homepage_portfolio_query();
		}

		return $wp_the_query;
	}
}


if ( ! function_exists( 'qusq_lite_infinite_scroll_is_last_batch' ) ) {
	/**
	 * Check whether its the last batch
	 *
	 * @param bool   $override whether to override or not.
	 * @param object $query The Query itself.
	 * @param object $settings the settings of the query.
	 *
	 * @return bool
	 */
	function qusq_lite_infinite_scroll_is_last_batch( $override, $query, $settings ) {

		if ( is_page_template( 'templates/homepage-portfolio.php' ) && isset( $settings ) ) {

			$query = qusq_lite_get_homepage_portfolio_query();

			// Same code as in the plugin but using custom query.
			$entries = (int) $query->found_posts;
			$posts_per_page = $settings->posts_per_page;

			// This is to cope with an issue in certain themes or setups where posts are returned but found_posts is 0.
			if ( 0 === $entries ) {
				return (bool) ( count( $query->posts ) < $posts_per_page );
			}
			$paged = $query->get( 'paged' );

			// Are there enough posts for more than the first page?
			if ( $entries <= $posts_per_page ) {
				return true;
			}

			// Calculate entries left after a certain number of pages.
			if ( $paged && $paged > 1 ) {
				$entries -= $posts_per_page * $paged;
			}

			// Are there some entries left to display?
			return $entries <= 0;

		} // End if().

		return $override;
	}
} // End if().


/**
 * Filter the output for Custom Fields and remove some of them
 *
 * @param bool   $output whether to output the field or not.
 * @param string $key the key of the custom field.
 * @param string $value the value of the custom field.
 *
 * @return bool
 */
function qusq_lite_filter_portfolio_meta_fields( $output, $key, $value ) {

	if ( 'inline_featured_image' === $key ) {
		return false;
	}

	return $output;
}

if ( ! function_exists( 'qusq_lite_single_portfolio_navigation' ) ) {
	/**
	 * Outputs the Portfolio Single navigation
	 */
	function qusq_lite_single_portfolio_navigation() {

		// Output Portolio Single Navigation.
		if ( is_singular( 'jetpack-portfolio' ) ) { ?>
			<div class="ish-portfolio-navigation ish--tc3">
				<?php

				$return = get_the_post_navigation( array(
					'prev_text' => '<i class="ish-icon-left-small"></i><span>' . esc_html__( 'Previous Project', 'qusq-lite' ) . '</span>',
					'next_text' => '<span>' . esc_html__( 'Next Project', 'qusq-lite' ) . '</span><i class="ish-icon-right-small"></i>',
				) );

				// Add separator and output content.
				echo wp_kses_post( str_replace( '<div class="nav-next', ' <span class="ish-separator">/</span> <div class="nav-next', $return ) );

				?>
			</div>
		<?php }

	}
}


if ( ! function_exists( 'qusq_lite_portfolio_archive_title' ) ) {
	/**
	 * Returns titles for Archive Pages
	 */
	function qusq_lite_portfolio_archive_title() {

		if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
			$qusq_lite_portfolio_slug = get_post_type_object( 'jetpack-portfolio' )->rewrite['slug'];
			$qusq_lite_portfolio_page = get_page_by_path( $qusq_lite_portfolio_slug );

			if ( $qusq_lite_portfolio_page ) {

				// Set current post so we can use in_loop data.
				setup_postdata( $qusq_lite_portfolio_page->ID );

				// Split content if there are two separators right after each other ( with empty lines in between ).
				$qusq_lite_post_content = preg_split( '#<hr \/>\s*<hr \/>#', get_the_content(), 2 );

				if ( isset( $qusq_lite_post_content[1] ) ) {
					// Get titles from content.
					echo wp_kses_post( wpautop( $qusq_lite_post_content[0] ) );
				} else { ?>
					<h1 class="site-title"><?php echo wp_kses_post( get_the_title( $qusq_lite_portfolio_page->ID ) ); ?></h1>
				<?php }

				// Reset Loop to the previous state.
				wp_reset_postdata();

			} else {
				remove_filter( 'qusq_lite_archive_title_enabled', 'qusq_lite_disable_regular_archive_title_on_portolio' );
			}
		}
	}
}

if ( ! function_exists( 'qusq_lite_remove_gallery_from_content' ) ) {
	/**
	 * Remove Gallery Shortcode from the content on Portfolio Single
	 *
	 * @param string $content the string to be output.
	 *
	 * @return string $content
	 */
	function qusq_lite_remove_gallery_from_content( $content ) {

		if ( is_singular( 'jetpack-portfolio' ) || is_page_template( 'templates/about.php' ) ) {
			$pattern = get_shortcode_regex( array( 'gallery' ) );
			preg_match_all( '/' . $pattern . '/s', $content, $shortcodes );

			if ( isset( $shortcodes[0][0] ) ) {
				$content = str_replace( $shortcodes[0][0], '', $content );
			}
		}

		return $content;
	}
}

if ( ! function_exists( 'qusq_lite_output_the_first_post_gallery' ) ) {
	/**
	 * Output the first content gallery
	 */
	function qusq_lite_output_the_first_post_gallery() {

		$pattern = get_shortcode_regex( array( 'gallery' ) );
		preg_match_all( '/' . $pattern . '/s', get_the_content(), $shortcodes );

		if ( isset( $shortcodes[0][0] ) ) {
			echo do_shortcode( $shortcodes[0][0] );
		}

	}
}

if ( ! function_exists( 'qusq_lite_output_the_first_post_headline' ) ) {
	/**
	 * Output the first portfolio content headline
	 *
	 * @param bool $strip_html Whether to strip_html.
	 */
	function qusq_lite_output_the_first_post_headline( $strip_html = false ) {

		$content = '';

		// Split content if there are two separators right after each other ( with empty lines in between ).
		$qusq_lite_post_content = preg_split( '#<hr \/>\s*<hr \/>#', get_the_content(), 2 );

		if ( isset( $qusq_lite_post_content[1] ) ) {
			$content = $qusq_lite_post_content[1];
		} else {
			$content = $qusq_lite_post_content[0];
		}

		$pattern = '<h( [1-6] ).*?>.*?<\/h[1-6]>';
		preg_match_all( '/' . $pattern . '/s', $content, $headlines );

		if ( isset( $headlines[0][0] ) ) {

			if ( $strip_html ) {
				echo esc_html( strip_tags( $headlines[0][0] ) );
			} else {
				echo wp_kses_post( $headlines[0][0] );
			}
		}
	}
}

if ( ! function_exists( 'qusq_lite_post_has_headline' ) ) {
	/**
	 * Checks whether post has a headline in content
	 */
	function qusq_lite_post_has_headline() {

		$content = '';

		// Split content if there are two separators right after each other ( with empty lines in between ).
		$qusq_lite_post_content = preg_split( '#<hr \/>\s*<hr \/>#', get_the_content(), 2 );

		if ( isset( $qusq_lite_post_content[1] ) ) {
			$content = $qusq_lite_post_content[1];
		} else {
			$content = $qusq_lite_post_content[0];
		}

		$pattern = '<h( [1-6] ).*?>.*?<\/h[1-6]>';
		preg_match_all( '/' . $pattern . '/s', $content, $headlines );

		if ( isset( $headlines[0][0] ) ) {
			return true;
		}

		return false;

	}
}


if ( ! function_exists( 'qusq_lite_remove_first_headline_from_content' ) ) {
	/**
	 * Removes First headline from content
	 *
	 * @param string $content the string to be output.
	 *
	 * @return string $content
	 */
	function qusq_lite_remove_first_headline_from_content( $content ) {

		if ( is_singular( 'jetpack-portfolio' ) && ! is_page_template() || is_page_template( 'templates/about.php' ) ) {

			$pattern = '<h( [1-6] ).*?>.*?<\/h[1-6]>';
			preg_match_all( '/' . $pattern . '/s', $content, $headlines );

			if ( isset( $headlines[0][0] ) ) {
				$content = str_replace( $headlines[0][0], '', $content );
			}
		}

		return $content;
	}
}


if ( ! function_exists( 'qusq_lite_disable_regular_archive_title_on_portolio' ) ) {
	/**
	 * Disable outputting the default archives title
	 *
	 * @param array $allow_output - already added classes.
	 *
	 * @return array $classes
	 */
	function qusq_lite_disable_regular_archive_title_on_portolio( $allow_output ) {

		if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
			$allow_output = false;
		}

		return $allow_output;
	}
}


if ( ! function_exists( 'qusq_lite_portfolio_content_overlay_classes' ) ) {
	/**
	 * Adds the correct content overlay class to body
	 *
	 * @param array $classes - already added classes.
	 *
	 * @return array $classes
	 */
	function qusq_lite_portfolio_content_overlay_classes( $classes ) {

		if ( is_singular( 'jetpack-portfolio' ) ) {

			// First remove all already added content overlay classes.
			foreach ( $classes as $key => $value ) {
				if ( false !== strpos( $value, 'ish-content-overlay-' ) ) {
					unset( $classes[ $key ] );
				}
			}

			// Then add the correct one.
			if ( ! is_page_template( 'templates/jetpack-portfolio-single-right.php' ) ) {
				$classes[] = 'ish-content-overlay-small';
			}
		}

		return $classes;
	}
}


if ( ! function_exists( 'qusq_lite_portfolio_archive_classes' ) ) {
	/**
	 * Adds the correct Portfolio Archive classes
	 *
	 * @param array $classes - already added classes.
	 *
	 * @return array $classes
	 */
	function qusq_lite_portfolio_archive_classes( $classes ) {

		if ( is_post_type_archive( 'jetpack-portfolio' ) || is_page_template( 'templates/homepage-portfolio.php' ) ) {

			// First remove all unnecessary classes.
			foreach ( $classes as $key => $value ) {
				if ( false !== strpos( $value, 'ish-blog' ) ) {
					unset( $classes[ $key ] );
				}
			}

			// Then add the correct ones.
			$classes[] = 'ish-pflo-gal';
			$classes[] = 'ish-scroll-anim';
			$classes[] = 'ish-2col';
		}

		return $classes;
	}
}


if ( ! function_exists( 'qusq_lite_get_first_portfolio_category' ) ) {
	/**
	 * Return first category of portfolio post.
	 *
	 * @return void
	 */
	function qusq_lite_get_first_portfolio_category() {
		$categories = get_the_terms( get_the_ID(), 'jetpack-portfolio-type' );
		if ( ! empty( $categories ) && is_object( $categories[0] ) ) {
			// Separator.
			echo '<span class="ish-separator">/</span>';
			// Category name.
			echo esc_html( $categories[0]->name );
		}
	}
}


if ( ! function_exists( 'qusq_lite_grunion_contact_form_field_html' ) ) {
	/**
	 * Return placeholders and * for required fields
	 *
	 * @param string $r             Contact Form HTML output.
	 * @param string $field_label   Field label.
	 * @param int    $id               Post ID.
	 * @return string
	 */
	function qusq_lite_grunion_contact_form_field_html( $r, $field_label, $id ) {

		// Check if field is required.
		$required = strpos( $r, 'required' );
		// Add * into placeholder for required field.
		$field_label = ( $required ) ? $field_label . ' *' : $field_label;

		$search_string_array = array( '<input ', '<textarea ' );
		$replace_string_array = array( '<input placeholder="' . $field_label . '" ', '<textarea placeholder="' . $field_label . '" ' );

		// Adjustment of generated string.
		$r = str_replace( 'div>', 'p>', $r );
		$r = str_replace( $search_string_array, $replace_string_array, $r );

		return $r;

	}
}

if ( ! function_exists( 'qusq_lite_highlight_portfolio_archive_in_menu' ) ) {
	/**
	 * Filters the CSS class( es ) applied to a menu item's list item element and highlight Portfolio Archive page
	 *
	 * @param array   $classes The CSS classes that are applied to the menu item's `<li>` element.
	 * @param WP_Post $item    The current menu item.
	 *
	 * @return array  $classes The updated classes array
	 */
	function qusq_lite_highlight_portfolio_archive_in_menu( $classes, $item ) {
		// Getting the current query details.
		global $wp_query;

		// Only apply on archive pages.
		if ( is_post_type_archive( array( 'jetpack-portfolio' ) ) ) {

			// Getting the post type of the current post.
			$current_post_type_object = $wp_query->get_queried_object();
			$current_post_type_slug = home_url( $current_post_type_object->rewrite['slug'] );

			// Getting the URL of the menu item.
			$menu_slug = untrailingslashit( strtolower( trim( $item->url ) ) );

			// If the menu item URL is the same as the Portfolio Archive's one.
			if ( $menu_slug === $current_post_type_slug ) {
				$classes[] = 'current-menu-item';
			}
		}

		// Return the corrected set of classes to be added to the menu item.
		return $classes;
	}
}
