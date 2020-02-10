<?php
/**
 * Handling the theme's customizer integration.
 *
 * @package Qusq_Lite
 */

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Qusq_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $manager Object for registering custom section types.
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once trailingslashit( get_template_directory() ) . 'inc/mu-modules/customizer-promo-section/class-qusq-customize-section-pro.php';

		// Register custom section types.
		$manager->register_section_type( 'Qusq_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Qusq_Customize_Section_Pro(
				$manager,
				'qusq_lite',
				array(
					'title'    => esc_html__( 'Qusq Pro', 'qusq-lite' ),
					'pro_text' => esc_html__( 'Lite vs. Pro', 'qusq-lite' ),
					'pro_url'  => admin_url( 'themes.php?page=qusq-lite#free-vs-pro' ),
					'priority' => 999,
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'qusq-lite-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/mu-modules/customizer-promo-section/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'qusq-lite-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/mu-modules/customizer-promo-section/customize-controls.css' );
	}
}

// Doing this customizer thang!
Qusq_Customize::get_instance();
