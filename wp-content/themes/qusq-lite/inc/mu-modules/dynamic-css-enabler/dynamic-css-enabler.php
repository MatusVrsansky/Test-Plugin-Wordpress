<?php
/**
 * Enable dynamic CSS based on Customizer options
 *
 * @package Qusq_Lite
 */

/**
 * Action to enable module's functionality
 */
function qusq_lite_dynamic_css_enabler_setup() {

	// Generate a CSS file on Customizer save.
	add_action( 'customize_save_after', 'qusq_lite_dynamic_css_enabler_generate_css_file' );
	add_action( 'after_switch_theme', 'qusq_lite_dynamic_css_enabler_generate_css_file' );
	add_action( 'upgrader_process_complete', 'qusq_lite_dynamic_css_enabler_generate_css_file_theme_update', 10, 2 );

	// Enqueue the generated file or load it inline.
	add_action( 'wp_enqueue_scripts', 'qusq_lite_dynamic_css_enabler_enque_css' );
}
add_action( 'after_setup_theme', 'qusq_lite_dynamic_css_enabler_setup' );


/**
 * Action to generate a CSS file on Customizer save
 */
function qusq_lite_dynamic_css_enabler_generate_css_file() {

	require_once ABSPATH . 'wp-admin/includes/file.php';
	WP_Filesystem();
	global $wp_filesystem;

	// Update the CSS file version.
	$ver = get_option( 'qusq_lite_generated_css_version' );
	$ver = ( $ver ) ? (int) $ver : 1;
	$ver++;
	update_option( 'qusq_lite_generated_css_version', $ver );

	// Prepare the variables.
	$uploads = wp_upload_dir();
	$uploads_dir = trailingslashit( $uploads['basedir'] ) . 'qusq_lite_css';
	$css_filename = 'qusq-lite-dynamic.css';

	// Get the CSS output.
	$dynamic_css = qusq_lite_dynamic_css_enabler_get_dynamic_css();

	// Create the directory.
	wp_mkdir_p( $uploads_dir );

	// Write the CSS to file.
	if ( ! $wp_filesystem->put_contents( $uploads_dir . '/' . $css_filename, $dynamic_css, 0644 ) ) {
		return true;
	}

}


/**
 * Gets the contents of all dynamic PHP files
 */
function qusq_lite_dynamic_css_enabler_get_dynamic_css() {

	$dynamic_css = '';

	// Get the CSS output.
	$dynamic_css = require get_template_directory() . '/scss/colors.php';
	$dynamic_css .= include get_template_directory() . '/scss/shortcodes-styles/colors-shortcodes.php';

	return apply_filters( 'qusq_lite_dynamic_css_enabler_get_dynamic_css', $dynamic_css );
}


/**
 * Action to generate a CSS file on theme update
 *
 * @param object $upgrader The upgrador.
 * @param array  $options  The options.
 */
function qusq_lite_dynamic_css_enabler_generate_css_file_theme_update( $upgrader, $options ) {

	if ( $options && 'theme' === $options['type'] && in_array( 'qusq-lite', $options['themes'] ) ) {
		qusq_lite_dynamic_css_enabler_generate_css_file();
	}

}


/**
 * Enqueue the generated file or load it inline
 */
function qusq_lite_dynamic_css_enabler_enque_css() {

	$uploads = wp_upload_dir();
	$uploads_dir = trailingslashit( $uploads['basedir'] ) . 'qusq_lite_css';
	$uploads_url = trailingslashit( $uploads['baseurl'] ) . 'qusq_lite_css';
	$css_filename = 'qusq-lite-dynamic.css';

	// HTTPS or SSL fix.
	if ( is_ssl() ) {
		$uploads_url = str_replace( 'http://', 'https://', $uploads_url );
	}

	if ( file_exists( $uploads_dir . '/' . $css_filename ) ) {

		// Enqueue the generated CSS file.
		wp_enqueue_style( 'qusq-lite-dynamic', $uploads_url . '/' . $css_filename, array(), get_option( 'qusq_lite_generated_css_version' ) );

	} else {

		// If no CSS file exists, load inline styles.
		qusq_lite_dynamic_css_enabler_output_inline();

	}

}


/**
 * Include the Dynamic CSS styles inline
 */
function qusq_lite_dynamic_css_enabler_output_inline() {

	// Load the contents of the dynamic file.
	$custom_css = qusq_lite_dynamic_css_enabler_get_dynamic_css();

	// Add the inline styles to the main theme CSS stylesheet.
	wp_add_inline_style( 'qusq-lite-style', apply_filters( 'qusq_lite_dynamic_css_enabler_inline_output', $custom_css ) );
}



