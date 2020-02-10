<?php
/**
 * Activate/Deactivate some Jetpack modules
 *
 * @package Qusq_Lite
 */

/**
 * Action to enable module's functionality
 */
function qusq_lite_jetpack_modules_enabler_setup() {

	// Activate theme necessary JetPack Plugins on JetPack Activation.
	add_action( 'activated_plugin', 'qusq_lite_jetpack_modules_enabler_activated_plugin' );

	// Activate theme necessary JetPack Plugins after Theme Activation.
	add_action( 'after_switch_theme', 'qusq_lite_jetpack_modules_enabler_after_switch_theme' );
}
add_action( 'after_setup_theme', 'qusq_lite_jetpack_modules_enabler_setup' );


/**
 * Activate theme necessary JetPack Plugins on JetPack Activation
 *
 * @param string $plugin - name of the plugin file along with directory.
 */
function qusq_lite_jetpack_modules_enabler_activated_plugin( $plugin ) {

	if ( 'jetpack/jetpack.php' === $plugin && current_user_can( 'jetpack_activate_modules' ) ) {
		qusq_lite_jetpack_modules_enabler_run();
	}

}

/**
 * Activate theme necessary JetPack Plugins after Theme Activation
 */
function qusq_lite_jetpack_modules_enabler_after_switch_theme() {

	if ( class_exists( 'Jetpack' ) && current_user_can( 'jetpack_activate_modules' ) ) {
		qusq_lite_jetpack_modules_enabler_run();
	}

}

/**
 * The function which actually runs the activation
 */
function qusq_lite_jetpack_modules_enabler_run() {

	$modules_to_activate = apply_filters( 'qusq_lite_jetpack_modules_enabler_default_plugins_to_activate', array(
		'contact-form',
		'custom-content-types',
		'widgets',
		'sharedaddy',
		'tiled-gallery',
		'carousel',
	) );

	$modules_to_deactivate = apply_filters( 'qusq_lite_jetpack_modules_enabler_default_plugins_to_deactivate', array(
		'minileven', // Mobile Theme template.
	) );

	// Activate modules.
	if ( class_exists( 'Jetpack' ) ) {

		// Enable some modules.
		foreach ( $modules_to_activate as $module_name ) {

			if ( ! Jetpack::is_module_active( $module_name ) ) {
				Jetpack::log( 'activate', $module_name );
				Jetpack::activate_module( $module_name, false );
			}
		}

		// Disable some modules.
		foreach ( $modules_to_deactivate as $module_name ) {

			if ( Jetpack::is_module_active( $module_name ) ) {
				Jetpack::log( 'deactivate', $module_name );
				Jetpack::deactivate_module( $module_name );
			}
		}
	}
}
