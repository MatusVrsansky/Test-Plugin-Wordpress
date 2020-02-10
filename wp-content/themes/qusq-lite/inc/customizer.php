<?php
/**
 * Qusq Lite Theme Customizer.
 *
 * @package Qusq_Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function qusq_lite_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_panel( 'qusq_lite_theme_options', array(
		'title' => esc_html__( 'Theme Options', 'qusq-lite' ),
	) );

	$wp_customize->add_section( 'qusq_lite_general', array(
		'title' => esc_html__( 'General Options', 'qusq-lite' ),
		'panel' => 'qusq_lite_theme_options',
		'priority' => 10,
	) );

	$wp_customize->add_section( 'qusq_lite_sidenav', array(
		'title' => esc_html__( 'Side Nav Area', 'qusq-lite' ),
		'panel' => 'qusq_lite_theme_options',
		'priority' => 20,
	) );

	$wp_customize->add_section( 'qusq_lite_portfolio', array(
		'title' => esc_html__( 'Portfolio', 'qusq-lite' ),
		'panel' => 'qusq_lite_theme_options',
		'priority' => 30,
	) );

	$wp_customize->add_section( 'qusq_lite_blog', array(
		'title'    => esc_html__( 'Blog', 'qusq-lite' ),
		'panel'    => 'qusq_lite_theme_options',
		'priority' => 40,
	) );

	$wp_customize->add_section( 'qusq_lite_colors', array(
		'title' => esc_html__( 'Theme Colors', 'qusq-lite' ),
		'panel' => 'qusq_lite_theme_options',
		'priority' => 50,
	) );

	$wp_customize->add_section( 'qusq_lite_footer', array(
		'title' => esc_html__( 'Footer', 'qusq-lite' ),
		'panel' => 'qusq_lite_theme_options',
		'priority' => 90,
	) );

}
add_action( 'customize_register', 'qusq_lite_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function qusq_lite_customize_preview_js() {
	wp_enqueue_script( 'qusq_lite_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'qusq_lite_customize_preview_js' );
