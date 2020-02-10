<?php
/**
 * Register Metabox to select About Template user
 *
 * @package Qusq_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Action to enable module's functionality
 */
function qusq_lite_metabox_about_user_setup() {

	if ( ! is_admin() ) {
		// Register Metabox for the given template on front end.
		add_action( 'init', 'qusq_lite_metabox_about_user_register' );
	} else {
		// Register Metabox for the given template in the admin area
		// Needs to be during "posts_selection" as it must be before "add_meta_boxes" & after current post is loaded
		// so we can use "get_page_template_slug" function.
		add_action( 'posts_selection', 'qusq_lite_metabox_about_user_admin_register' );
	}

	// Modify the user id based on the back-end selection.
	add_action( 'qusq_lite_get_selected_about_user_id', 'qusq_lite_metabox_about_user_get_selected_about_user_id' );

}
add_action( 'after_setup_theme', 'qusq_lite_metabox_about_user_setup' );


/**
 * Action to register metabox on about template
 */
function qusq_lite_metabox_about_user_admin_register() {

	if ( 'templates/about.php' === get_page_template_slug() ) {
		qusq_lite_metabox_about_user_register();
	}

}

/**
 * Action to register metabox on front-end
 */
function qusq_lite_metabox_about_user_register() {

	if ( function_exists( 'add_ishyo_meta_box' ) ) {

		$options           = array();
		$options['none']   = esc_html__( 'Disable', 'qusq-lite' );
		$options['author'] = esc_html__( 'Page Author', 'qusq-lite' );

		foreach ( get_users( array() ) as $user ) {
			if ( is_object( $user ) ) {
				$options[ $user->data->ID ] = $user->data->display_name . ' - ' . $user->data->user_email;
			}
		}

		add_ishyo_meta_box( 'about_template_settings', array(
			'title'    => esc_html__( 'About Template Settings', 'qusq-lite' ),
			'pages'    => apply_filters( 'qusq_lite_metabox_posttypes', array( 'page' ), 'about_template_settings' ),
			'context'  => 'side',
			'priority' => 'default',
			'fields'   => array(
				array(
					'name'    => esc_html__( 'Display User Info', 'qusq-lite' ),
					'id'      => 'selected_about_user',
					'default' => 'author',
					'desc'    => esc_html__( "Choose the user who's data will be loaded and displayed before the content.", 'qusq-lite' ),
					'type'    => 'select',
					'options' => apply_filters( 'qusq_lite_about_users_array', $options ),
				),
			),
		) );
	}

}

/**
 * Modify the user id based on the back-end selection
 *
 * @param int $id The user id.
 *
 * @return int
 */
function qusq_lite_metabox_about_user_get_selected_about_user_id( $id ) {

	$val = IshYoMetaBox::get( 'selected_about_user', true, get_the_ID() );

	if ( is_numeric( $val ) ) {
		$id = (int) $val;
	} elseif ( 'author' !== $val ) {
		// leave $id as is if it is author.
		$id = false;
	}

	return $id;
}

