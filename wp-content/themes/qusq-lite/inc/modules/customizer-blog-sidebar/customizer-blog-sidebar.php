<?php
/**
 * Qusq Lite Theme Customizer.
 *
 * @package Qusq_Lite
 */

/**
 * Action to enable module's functionality
 */
function qusq_lite_customizer_blog_sidebar_setup() {

	// Register Customizer Settings.
	add_action( 'customize_register', 'qusq_lite_customizer_blog_sidebar' );

	add_filter( 'qusq_lite_blog_detail_sidebar_active', 'qusq_lite_customizer_blog_detail_sidebar_active' );
}
add_action( 'after_setup_theme', 'qusq_lite_customizer_blog_sidebar_setup' );


/**
 * Add Blog Sidebar setting into Theme Options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function qusq_lite_customizer_blog_sidebar( $wp_customize ) {

	$wp_customize->add_setting( 'qusq_lite_blog_detail_sidebar', array(
		'default' => 1,
		'sanitize_callback' => 'qusq_lite_setting_sanitize_callback',
	) );

	$wp_customize->add_control( 'qusq_lite_blog_detail_sidebar_control', array(
		'label'       => esc_html__( 'Display Blog Sidebar in Articles', 'qusq-lite' ),
		'section'     => 'qusq_lite_blog',
		'settings'    => 'qusq_lite_blog_detail_sidebar',
		'type'        => 'select',
		'choices'     => array(
			'1'       => esc_html__( 'Yes', 'qusq-lite' ),
			'0'       => esc_html__( 'No', 'qusq-lite' ),
		),
	) );
}

/**
 * Overrides the default active state with Theme Options setting
 *
 * @param bool $active the original state.
 *
 * @return bool
 */
function qusq_lite_customizer_blog_detail_sidebar_active( $active ) {
	return (bool) get_theme_mod( 'qusq_lite_blog_detail_sidebar', true );
}





