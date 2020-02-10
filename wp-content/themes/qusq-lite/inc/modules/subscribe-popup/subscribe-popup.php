<?php
/**
 * Enable Subscribe Pop Up in Admin section.
 *
 * @package Qusq_Lite
 */

/**
 * Enqueue scripts and styles.
 */
function qusq_lite_subscribe_popup() {

	$screen = get_current_screen();
	$screen_base = $screen -> base;
	$theme = wp_get_theme();
	$is_on_theme_page = strpos( $screen_base, $theme -> get( 'TextDomain' ) );
	$support_provided = get_theme_mod( 'qusq-lite-free-support-provided', false );

	if ( ( false !== $is_on_theme_page || is_customize_preview() ) && ! $support_provided ) {

		// Load scripts required for subscribe popup.
		wp_enqueue_script( 'subscribe-popup', get_template_directory_uri() . '/inc/modules/subscribe-popup/js/subscribe-popup.js', array( 'jquery' ), '20151215', true );

		// Send Ajax URL to popup script.
		wp_localize_script( 'subscribe-popup', 'phpVars',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'security_nonce' => wp_create_nonce( 'qusq_lite_subscribe_popup' ),
				'theme_slug' => get_template(),
				'strings' => array(
					'popup_title' => esc_html__( '&#127881; GET 14-DAY FREE SUPPORT!', 'qusq-lite' ),
					'popup_message' => wp_kses_post( __( 'The access credentials will be <strong>sent right to your inbox</strong> after filling-in your e-mail address. You will get 14 days access with ability to open 1 new topic.', 'qusq-lite' ) ),
					'popup_email_placeholder' => esc_html__( 'Enter your email address...', 'qusq-lite' ),
					'popup_send_button' => esc_html__( 'Submit', 'qusq-lite' ),
					'popup_close_button' => esc_html__( 'Close', 'qusq-lite' ),
					'popup_disclaimer' => esc_html__( '* The e-mail address will be used to deliver the above gift. We will occasionally send news about our themes and services with ability to unsubscribe at any time.', 'qusq-lite' ),
					'success_title' => esc_html__( 'Thank you!', 'qusq-lite' ),
					'error_title' => esc_html__( 'Error!', 'qusq-lite' ),
					'error_not_object' => esc_html__( 'There was an error requesting this feature.', 'qusq-lite' ),
					'error_ajax_error' => esc_html__( 'There was an error trying to connect to server. Please, make sure you have internet access.', 'qusq-lite' ),
				),
			)
		);

		// Load styles required for subscribe popup.
		wp_enqueue_style( 'subscribe-popup-style', get_template_directory_uri() . '/inc/modules/subscribe-popup/css/ish-subscribe.css', array(), '20151215' );

		// Output CTA in Welcome page of theme dashboard.
		add_action( 'qusq_lite_qusq_dashboard_after_welcome', 'qusq_lite_subscribe_popup_in_page_cta' );
	}
}

add_action( 'admin_enqueue_scripts', 'qusq_lite_subscribe_popup' );
add_action( 'customize_controls_enqueue_scripts', 'qusq_lite_subscribe_popup' );


/**
 * Function to output the HTML for Welcome Page in dashboard
 */
function qusq_lite_subscribe_popup_in_page_cta() {
	?>

	<div id="ish-subscribe-content-cta" class="ish-subscribe-popup__box ish-subscribe-popup__box--content">
		<h2 class="ish-subscribe-title ish-subscribe-title--content"><?php echo esc_html__( '&#127881; GET 14-DAY FREE SUPPORT!', 'qusq-lite' ); ?></h2>
		<a href="#" class="ish-subscribe-form__button ish-subscribe-form__button--link"><?php echo esc_html__( 'Get It!', 'qusq-lite' ); ?></a>
	</div>

	<?php
}

/**
 * Function to be called from JavaScript, which makes the API call to get Free Support
 */
function qusq_lite_get_free_support() {

	if ( ! isset( $_POST['security_nonce'] ) || ! wp_verify_nonce( $_POST['security_nonce'], 'qusq_lite_subscribe_popup' ) ) {
		die();
	}

	if ( isset( $_POST['email'] ) && ! empty( $_POST['email'] ) ) {

		// Prepare the call arguments.
		$args = array(
			'body' => array(
				'action' => 'add_free_support',
				'email' => $_POST['email'],
				'theme' => wp_get_theme( get_template() )->get( 'Name' ),
			),
		);

		// Do the call.
		$request = wp_remote_post( 'https://ishyoboy.com/wp/wp-admin/admin-ajax.php', $args );

		if ( is_wp_error( $request ) ) {
			wp_send_json_error(
				array(
					'error' => esc_html__( 'Server Problem! The server returned an error. Please report the problem to hello@ishyoboy.com', 'qusq-lite' ),
				)
			);
			die();
		}

		$response = wp_remote_retrieve_body( $request );

		// Check if server returns a valid JSON response.
		if ( null === json_decode( $response ) ) {
			wp_send_json_error(
				array(
					'error' => esc_html__( 'Server Problem! The server returned an invalid response. Please report the problem to hello@ishyoboy.com', 'qusq-lite' ),
				)
			);
			die();
		} else {

			$data = json_decode( $response );

			// If success message received - save note to DB to not display popup again.
			if ( is_object( $data ) && isset( $data->success ) && true === $data->success ) {
				set_theme_mod( 'qusq-lite-free-support-provided', true );
			}

			// The response from the server is valid.
			wp_send_json( json_decode( $response ) );
			die();
		}
	} // End if().

	die();
}
add_action( 'wp_ajax_get_free_support', 'qusq_lite_get_free_support' );
add_action( 'wp_ajax_nopriv_get_free_support', 'qusq_lite_get_free_support' );
