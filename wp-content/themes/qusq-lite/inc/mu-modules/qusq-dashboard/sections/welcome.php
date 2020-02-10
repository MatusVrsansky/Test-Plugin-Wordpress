<?php
/**
 * Welcome section.
 *
 * @package Qusq_Lite
 */

?>
<h1>
	<?php
	// Translators: %1$s - Theme name, %2$s - Theme version.
	echo esc_html( sprintf( __( 'Welcome to %1$s - Version %2$s', 'qusq-lite' ), $this->theme->name, $this->theme->version ) );
	?>
</h1>
<div class="about-text">
	<?php // Translators: %1$s - Theme name. ?>
	<?php echo sprintf( esc_html__( 'Congratulations! You have successfully installed %1$s. It is ready to serve you with its full potential. There are just a few more steps necessary to finalize the setup of the theme and to learn more about its features.', 'qusq-lite' ), $this->theme->name ); ?>
	<?php do_action( 'qusq_lite_qusq_dashboard_welcome_about' ); ?>
</div>
<a target="_blank" href="<?php echo esc_url( 'https://ishyoboy.com/' ); ?>" class="wp-badge">IshYoBoy</a>
