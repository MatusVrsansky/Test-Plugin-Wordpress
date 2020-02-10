<?php
/**
 * Metabox Enabler module.
 *
 * @package Qusq_Lite
 */

if ( ! function_exists( 'qusq_lite_metabox_enabler_allow_attributes' ) ) {
	/**
	 * Allows data-attribute for links in admin
	 *
	 * @param array  $allowedposttags The list of allowed HTML tags.
	 * @param string $context The current context.
	 *
	 * @return mixed
	 */
	function qusq_lite_metabox_enabler_allow_attributes( $allowedposttags, $context ) {
		if ( is_admin() && 'post' === $context ) {
			$allowedposttags['a']['data-ish-value'] = true;
		}
		return $allowedposttags;
	}
}
add_filter( 'wp_kses_allowed_html', 'qusq_lite_metabox_enabler_allow_attributes', 10, 2 );

/**
 * The Metabox Class
 */
require get_template_directory() . '/inc/modules/metabox-enabler/class-ishyometabox.php';

