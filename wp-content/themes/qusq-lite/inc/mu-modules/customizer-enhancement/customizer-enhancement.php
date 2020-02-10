<?php
/**
 * Qusq Lite Theme Customizer.
 *
 * @package Qusq_Lite
 */

/**
 * Action to enable module's functionality
 */
function qusq_lite_customizer_enhancement_setup() {

	// Customizer HTML.
	add_action( 'customize_render_control', 'qusq_lite_customizer_enhancement_add_nag' );

	// Admin Edit Screens Metabox HTML.
	add_action( 'qusq_lite_before_metabox_field', 'qusq_lite_customizer_enhancement_add_metabox_nag' );

	// Customizer CSS.
	add_action( 'customize_controls_print_styles', 'qusq_lite_customizer_enhancement_be_stylesheet' );

	// Customizer JS - Cuztomizer colors need the HTML output via JS.
	add_action( 'customize_controls_enqueue_scripts', 'qusq_lite_customizer_enhancement_customizer_script' );

	// Admin Screens JS.
	add_action( 'admin_enqueue_scripts', 'qusq_lite_customizer_enhancement_admin_script' );

	// Admin Edit screens CSS.
	add_action( 'admin_enqueue_scripts', 'qusq_lite_customizer_enhancement_admin_style' );

	// remember the activation date.
	add_action( 'after_switch_theme', 'qusq_lite_customizer_enhancement_after_switch_theme' );

	// Enable admin notices.
	add_action( 'admin_notices', 'qusq_lite_customizer_enhancement_pro_version_notices' );

	// Make Notices dismissible.
	add_action( 'wp_ajax_nopriv_qusq_lite_dismiss_notice', 'qusq_lite_dismiss_notice' );
	add_action( 'wp_ajax_qusq_lite_dismiss_notice', 'qusq_lite_dismiss_notice' );

}
add_action( 'after_setup_theme', 'qusq_lite_customizer_enhancement_setup' );


/**
 * Action which enqueues a CSS to modify the customizer's layout a little
 */
function qusq_lite_customizer_enhancement_be_stylesheet() {
	wp_enqueue_style( 'qusq-lite-customizer-enhancement', get_template_directory_uri() . '/inc/mu-modules/customizer-enhancement/css/customizer.css', array(), '20151215' );
}

/**
 * Registers FE script
 */
function qusq_lite_customizer_enhancement_customizer_script() {
	// Register the script.
	wp_register_script( 'qusq-lite-customizer-enhancement', get_template_directory_uri() . '/inc/mu-modules/customizer-enhancement/js/customizer.js', array( 'jquery' ), '20151215' );

	// Localize the script with new data.
	$translation_array = array(
		'nag_html' => qusq_lite_customizer_enhancement_get_nag_html(),
	);
	wp_localize_script( 'qusq-lite-customizer-enhancement', 'data', $translation_array );

	// Enqueued script with localized data.
	wp_enqueue_script( 'qusq-lite-customizer-enhancement' );
}

/**
 * Registers Admin script
 */
function qusq_lite_customizer_enhancement_admin_script() {
	wp_enqueue_script( 'qusq-lite-customizer-enhancement-admin', get_template_directory_uri() . '/inc/mu-modules/customizer-enhancement/js/admin.js', array( 'jquery' ), '20151215', true );
}

/**
 * Returns the Nag HTML for Profile
 */
function qusq_lite_customizer_enhancement_get_profile_nag_html() {
	return '<span class="ish-profile-nag"><a href="https://' . esc_attr( 'ishyoboy.com' ) . '/themes/qusq-pro/" target="_blank" title="' . esc_attr__( 'Setting available only in Pro Version', 'qusq-lite' ) . '">' . esc_html__( 'Pro', 'qusq-lite' ) . '</a></span>';
}

/**
 * Returns the Nag HTML for Dashboard
 */
function qusq_lite_customizer_enhancement_get_dashboard_nag_html() {
	return '<span class="ish-profile-nag"><a href="https://' . esc_attr( 'ishyoboy.com' ) . '/themes/qusq-pro/" target="_blank" title="' . esc_attr__( 'Get Pro Version', 'qusq-lite' ) . '">' . esc_html__( 'Pro', 'qusq-lite' ) . '</a></span>';
}

/**
 * Returns the Nag HTML
 */
function qusq_lite_customizer_enhancement_get_nag_html() {
	return '<li class="customize-control customize-control-ish-nag"><a href="https://' . esc_attr( 'ishyoboy.com' ) . '/themes/qusq-pro/" target="_blank" title="' . esc_attr__( 'Setting available only in Pro Version', 'qusq-lite' ) . '">' . esc_html__( 'Pro', 'qusq-lite' ) . '</a></li>';
}

/**
 * Adds nag HTML for "lite-promo" options
 *
 * @param object $control The current customizer control.
 */
function qusq_lite_customizer_enhancement_add_nag( $control ) {
	if ( false !== strpos( $control->id, '-lite-promo' ) && 'color' !== $control->type ) {
		echo wp_kses_post( qusq_lite_customizer_enhancement_get_nag_html() );
	}
}

/**
 * Adds nag HTML to "lite-promo" metaboxes
 *
 * @param array $options The options of the metabox.
 */
function qusq_lite_customizer_enhancement_add_metabox_nag( $options ) {
	if ( false !== strpos( $options['id'], '-lite-promo' ) ) {
		?>
		<div class="metabox-nag"><a href="<?php echo esc_html( 'https' ); ?>://ishyoboy.com/themes/qusq-pro/" target="_blank" title="<?php esc_attr_e( 'Setting available only in Pro Version', 'qusq-lite' ); ?>"><?php esc_html_e( 'Pro', 'qusq-lite' ); ?></a></div>
		<?php
	}
}

/**
 * Enqueues the admin css on the right pages
 *
 * @param string $hook the name of the current file.
 */
function qusq_lite_customizer_enhancement_admin_style( $hook ) {
	if ( 'post.php' === $hook ||  'post-new.php' === $hook ||  'profile.php' === $hook ||  'appearance_page_qusq-lite' === $hook ) {
		wp_enqueue_style( 'qusq-lite-customizer-enhancement-edit', get_template_directory_uri() . '/inc/mu-modules/customizer-enhancement/css/admin.css', array(), '20151215' );
	}
}

/**
 * Activates all Notices.
 */
function qusq_lite_customizer_enhancement_pro_version_notices() {
	qusq_lite_customizer_enhancement_pro_version_notice( 1, 'help' );
	qusq_lite_customizer_enhancement_pro_version_notice( 14, 'promo' );
	qusq_lite_customizer_enhancement_pro_version_notice( 30, 'promo' );
	qusq_lite_customizer_enhancement_pro_version_notice( 60, 'promo' );
}

/**
 * Outputs notices.
 *
 * @param int    $days the amount of days from activation to display notice.
 * @param string $type the notice type 'help', 'promo'.
 */
function qusq_lite_customizer_enhancement_pro_version_notice( $days, $type = 'promo' ) {

	$activation_date = get_option( 'qusq_lite_activation_date', false );
	$now    = new DateTime();

	if ( $activation_date ) {
		if ( $activation_date->modify( '+' . $days . ' days' ) < $now ) {

			// Only show message after the given amount of days.
			$option = get_option( 'pro_version_notice_' . $days );

			if ( empty( $option ) ) {

				switch ( $type ) {
					case 'help' :
						?>
						<div class="notice notice-info qusq-lite-notice is-dismissible" data-notice-type="<?php echo esc_attr( $days ); ?>">
						<p>
							<?php printf(
								/* translators: Theme Name with link to online page and Support Forum link */
								esc_html__( 'Need help with Qusq? All %1$s users have free support. Come and join us in the %2$s', 'qusq-lite' ),
								'<a href="https://' . esc_attr( 'ishyoboy.com' ) . '/themes/qusq-pro/" target="_blank"><strong>' . esc_html__( 'Qusq Pro' , 'qusq-lite' ) . '</strong></a>',
								'<a href="https://' . esc_attr( 'ishyoboy.com' ) . '/themes/qusq-pro/" target="_blank"><strong>' . esc_html__( 'Pro Club!' , 'qusq-lite' ) . '</strong></a>'
							);
							?>
						</p>
						</div>
						<?php
						break;
					default :
						?>
						<div class="notice notice-info qusq-lite-notice is-dismissible" data-notice-type="<?php echo esc_attr( $days ); ?>">
							<p>
								<?php printf(
									/* translators: Theme Name with link to online page */
									esc_html__( 'Enjoying Qusq? Get %1$s and enjoy many more features & professional support! Learn more about %2$s', 'qusq-lite' ),
									'<a href="https://' . esc_attr( 'ishyoboy.com' ) . '/themes/qusq-pro/" target="_blank"><strong>' . esc_html__( 'Qusq Pro' , 'qusq-lite' ) . '</strong></a>',
									'<a href="https://' . esc_attr( 'ishyoboy.com' ) . '/themes/qusq-pro/" target="_blank"><strong>' . esc_html__( 'Qusq Pro' , 'qusq-lite' ) . ' &rarr;</strong></a>'
								); ?>
							</p>
						</div>
						<?php
						break;
				}
			} // End if().
		} // End if().
	} else {
		// In case there is no date saved, save it.
		update_option( 'qusq_lite_activation_date', new DateTime() );
	} // End if().
}

/**
 * Makes notices dismissable.
 */
function qusq_lite_dismiss_notice() {

	if ( isset( $_GET['days'] ) ) {
		$days = (int) $_GET['days'];
		update_option( 'pro_version_notice_' . $days , 1 );
	}

}

/**
 * Updates activation date on theme activation.
 */
function qusq_lite_customizer_enhancement_after_switch_theme() {
	// Update activation date on every theme activation.
	update_option( 'qusq_lite_activation_date', new DateTime() );
}
