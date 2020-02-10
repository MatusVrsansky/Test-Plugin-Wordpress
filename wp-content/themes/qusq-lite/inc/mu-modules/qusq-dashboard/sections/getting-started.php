<?php
/**
 * Getting started section.
 *
 * @package Qusq_Lite
 */

?>
<div id="getting-started" class="ish-tab-pane ish-is-active">
	<div class="feature-section two-col">
		<div class="col">
			<h3><?php esc_html_e( '1. Install Required Plugins', 'qusq-lite' ); ?></h3>
			<p><?php esc_html_e( 'They will add lot of cool stuff like Portfolios, Infinite Scroll, Contact Forms, Tiled Galleries, Image Carousel, Sharing buttons, Comment Likes, Widgets and many more...', 'qusq-lite' ); ?></p>
			<p>
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'View Required Plugins', 'qusq-lite' ); ?></a>
			</p>

			<?php // Translators: %1$s - Theme name. ?>
			<h3><?php printf( esc_html__( '2. Customize %1$s', 'qusq-lite' ), $this->theme->name ); ?></h3>
			<p><?php esc_html_e( 'By using the WordPress Customizer you can easily customize every aspect of the theme. Make sure to check the "Theme Options" tab.', 'qusq-lite' ); ?></p>
			<p>
				<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Start Customizer', 'qusq-lite' ); ?></a>
			</p>

			<h3><?php esc_html_e( '3. Read The Documentation', 'qusq-lite' ); ?></h3>
			<p class="about"><?php esc_html_e( 'Need any help to setup and configure the theme? Please check our full documentation for detailed information on how to use it.', 'qusq-lite' ); ?></p>
			<p>
				<a href="<?php echo esc_url( 'https://themes.ishyoboy.com/qusq/doc/' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Read Documentation', 'qusq-lite' ); ?></a>
			</p>

			<h3><?php esc_html_e( '4. Get Our Help', 'qusq-lite' ); ?> <?php echo ( function_exists( 'qusq_lite_customizer_enhancement_get_dashboard_nag_html' ) ) ? qusq_lite_customizer_enhancement_get_dashboard_nag_html() : ''; ?></h3>
			<p class="about"><?php esc_html_e( 'You have already read the documentation, but still need help with setting up and configuring the theme? We are here to help!', 'qusq-lite' ); ?></p>
			<p>
				<a href="<?php echo esc_url( 'http://support.ishyoboy.com/' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Visit Support Forum', 'qusq-lite' ); ?></a>
			</p>

			<h3><?php esc_html_e( '5. Import Demo Content', 'qusq-lite' ); ?> <?php echo ( function_exists( 'qusq_lite_customizer_enhancement_get_dashboard_nag_html' ) ) ? qusq_lite_customizer_enhancement_get_dashboard_nag_html() : ''; ?></h3>
			<?php // Translators: %1$s - Theme name. ?>
			<p class="about"><?php printf( esc_html__( 'If you\'re looking for %1$s to look exactly like the live demo, either get the Pro Version and import the content yourself or request our Premium Theme Installation & Setup service.', 'qusq-lite' ), $this->theme->name ); ?></p>
			<p>
				<a href="<?php echo esc_url( 'https://ishyoboy.com/themes/qusq-pro/' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Get Pro Version', 'qusq-lite' ); ?></a>
				<a href="<?php echo esc_url( 'https://ishyoboy.com/checkout?edd_action=add_to_cart&download_id=149&edd_options[price_id]=2' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Premium Theme Setup', 'qusq-lite' ); ?></a>
			</p>
		</div>

		<div class="col">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="">
		</div>
	</div>
</div>
