<?php
/**
 * Template Name: Contact Page
 *
 * This is the template that displays contact form and contact details in two columns.
 *
 * @package Qusq_Lite
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">


			<div class="ish-container-fluid">
				<div class="ish-container-inner">

					<div id="ish-main-content" class="<?php echo esc_attr( qusq_lite_main_content_classes( array( 'ish-content-parallax' ) ) ); ?>">

						<div class="ish-row">
							<div class="ish-contact-info-container ish-col-xs-12 ish-col-sm-6">
								<div class="ish-contact-info-box">
									<div class="ish-row">
										<div class="ish-col-sm-10">
											<?php the_content(); ?>
										</div>
									</div>
								</div>
							</div>

							<div class="ish-contact-form-container ish-col-xs-12 ish-col-sm-6">
								<div class="ish-contact-form-box">
									<h3><span class="ish--tc2"><?php echo esc_html__( 'Send a Message', 'qusq-lite' ); ?></span></h3>
									<?php qusq_lite_shortcode_from_content( array( 'contact-form', 'contact-form-7' ) ); ?>
								</div>
							</div>
						</div>

						<?php if ( has_nav_menu( 'social' ) ) { ?>
							<div class="ish-social-box ish-social-box-contact ish-row ish-center-xs">
								<?php wp_nav_menu(
									array(
										'theme_location' => 'social',
										'menu_id' => 'social-menu-contact',
									)
								); ?>
							</div>
						<?php } ?>

					</div>

				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
