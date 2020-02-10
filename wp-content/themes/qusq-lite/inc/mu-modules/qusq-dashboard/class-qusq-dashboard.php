<?php
/**
 * Add theme dashboard page
 *
 * @package Qusq_Lite
 */

/**
 * Dashboard class.
 */
class Qusq_Dashboard {
	/**
	 * Store the theme data.
	 *
	 * @var WP_Theme Theme data.
	 */
	private $theme;

	/**
	 * Theme slug.
	 *
	 * @var string Theme slug.
	 */
	private $slug;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->theme = wp_get_theme();
		$this->slug  = $this->theme->template;

		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_init', array( $this, 'redirect' ) );
	}

	/**
	 * Add theme dashboard page.
	 */
	public function add_menu() {
		add_theme_page(
			$this->theme->name,
			$this->theme->name,
			'edit_theme_options',
			$this->slug,
			array( $this, 'render' )
		);
	}

	/**
	 * Show dashboard page.
	 */
	public function render() {
		?>
		<div class="wrap about-wrap">
			<?php include get_template_directory() . '/inc/mu-modules/qusq-dashboard/sections/welcome.php'; ?>
			<?php do_action( 'qusq_lite_qusq_dashboard_after_welcome' ); ?>
			<?php include get_template_directory() . '/inc/mu-modules/qusq-dashboard/sections/tabs.php'; ?>
			<?php do_action( 'qusq_lite_qusq_dashboard_after_tabs' ); ?>
			<?php include get_template_directory() . '/inc/mu-modules/qusq-dashboard/sections/getting-started.php'; ?>
			<?php do_action( 'qusq_lite_qusq_dashboard_after_fetting_started' ); ?>
			<?php include get_template_directory() . '/inc/mu-modules/qusq-dashboard/sections/pro.php'; ?>
			<?php do_action( 'qusq_lite_qusq_dashboard_after_pro' ); ?>
			<?php include get_template_directory() . '/inc/mu-modules/qusq-dashboard/sections/services.php'; ?>
			<?php do_action( 'qusq_lite_qusq_dashboard_after_services' ); ?>
		</div>
		<?php
	}

	/**
	 * Enqueue scripts for dashboard page.
	 *
	 * @param string $hook Page hook.
	 */
	public function enqueue_scripts( $hook ) {
		if ( "appearance_page_{$this->slug}" !== $hook ) {
			return;
		}
		wp_enqueue_style( "{$this->slug}-dashboard-style", get_template_directory_uri() . '/inc/mu-modules/qusq-dashboard/css/style.css' );
		wp_enqueue_script( "{$this->slug}-dashboard-script", get_template_directory_uri() . '/inc/mu-modules/qusq-dashboard/js/script.js', array( 'jquery' ), '', true );
	}

	/**
	 * Redirect to dashboard page after theme activation.
	 */
	public function redirect() {
		global $pagenow;
		if ( is_admin() && isset( $_GET['activated'] ) && 'themes.php' === $pagenow ) {
			wp_safe_redirect( admin_url( "themes.php?page={$this->slug}" ) );
			exit;
		}
	}
}
$dashboard = new Qusq_Dashboard;
