<?php
/**
 * Qusq Lite Theme Customizer.
 *
 * @package Qusq_Lite
 */

/**
 * Action to enable module's functionality
 */
function qusq_lite_customizer_colors_register_setup() {

	// Register Customizer Settings.
	add_action( 'customize_register', 'qusq_lite_customizer_colors_register' );

	// Output LivePreview Dynamic CSS.
	add_action( 'wp_enqueue_scripts', 'qusq_lite_customizer_colors_dynamic_css', 999 );

	// Postfix filter.
	add_filter( 'qusq_lite_customizer_colors_postfix', 'qusq_lite_customizer_colors_postfix' , 10, 2 );

}
add_action( 'after_setup_theme', 'qusq_lite_customizer_colors_register_setup' );

/**
 * Action to output the dynamic CSS with new values
 */
function qusq_lite_customizer_colors_dynamic_css() {
	global $wp_customize;

	if ( ! empty( $wp_customize )  && function_exists( 'qusq_lite_dynamic_css_enabler_get_dynamic_css' ) ) {
		// We are in customize preview mode.
		if ( wp_style_is( 'qusq-lite-dynamic', 'enqueued' ) ) {
			// If a dynamic style is registered attach the css after it.
			wp_add_inline_style( 'qusq-lite-dynamic', qusq_lite_dynamic_css_enabler_get_dynamic_css() );
		} else {
			// If not, attach it to main CSS file.
			wp_add_inline_style( 'qusq-lite-style', qusq_lite_dynamic_css_enabler_get_dynamic_css() );
		}
	}
}


/**
 * Action to add Color Settings into the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function qusq_lite_customizer_colors_register( $wp_customize ) {

	$default_colors = array_slice( qusq_lite_get_theme_colors_array(), 0, 4 );
	$default_colors = array_merge( array( '' ), $default_colors );
	unset( $default_colors[0] );

	foreach ( $default_colors as $key => $value ) {

		$postfix = apply_filters( 'qusq_lite_customizer_colors_postfix', 'qusq-lite', $key );

		$wp_customize->add_setting( 'qusq_lite_color' . esc_attr( $key ) . esc_html( $postfix ) , array(
			'default' => esc_html( $value ),
			'transport' => 'refresh',
			'sanitize_callback' => 'qusq_lite_setting_sanitize_callback',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'qusq_lite_color_control' . esc_html( $key ) . esc_html( $postfix ) , array(
			'label' => esc_html__( 'Color', 'qusq-lite' ) . ' ' . esc_html( $key ),
			'section' => 'qusq_lite_colors',
			'settings' => 'qusq_lite_color' . esc_html( $key ) . esc_html( $postfix ),
		) ) );

	}

}


/**
 * Makes Colors after Color 4 uneditable
 *
 * @param string $postfix the original postfix.
 * @param string $key the color order number.
 *
 * @return string
 */
function qusq_lite_customizer_colors_postfix( $postfix, $key ) {
	return ( $key > 4 ) ? '-lite-promo' : '';
}
