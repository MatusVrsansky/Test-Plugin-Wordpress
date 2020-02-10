<?php
/**
 * Enable Editor Style
 *
 * @package Qusq_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'qusq_lite_add_editor_styles' ) ) {
	/**
	 * Registers an editor stylesheet for the theme.
	 */
	function qusq_lite_add_editor_styles() {
		add_editor_style();
	}
}
add_action( 'admin_init', 'qusq_lite_add_editor_styles' );
