<?php
/**
 * Qusq Lite Theme Customizer.
 *
 * @package Qusq_Lite
 */

/**
 * Action to enable module's functionality
 */
function qusq_lite_customizer_smooth_scroll_setup() {

	// Filter to enqueue scripts.
	add_action( 'wp_enqueue_scripts', 'qusq_lite_smooth_scroll_scripts' );

}
add_action( 'after_setup_theme', 'qusq_lite_customizer_smooth_scroll_setup' );


/**
 * Enqueue scripts and styles.
 */
function qusq_lite_smooth_scroll_scripts() {
	// Load scripts required for smooth scroll.
	wp_enqueue_script( 'smoothscroll', get_template_directory_uri() . '/js/bower/smoothscroll-for-websites/SmoothScroll.js', array( 'jquery' ), '20151215', true );
	wp_enqueue_script( 'smoothscrollsettings', get_template_directory_uri() . '/inc/modules/customizer-smooth-scroll/js/customizer-smooth-scroll.js', array( 'jquery', 'smoothscroll' ), '20151215', true );
}
