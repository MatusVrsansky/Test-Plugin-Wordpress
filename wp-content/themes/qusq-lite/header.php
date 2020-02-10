<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Qusq_Lite
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="ish-blurred-overlay"></div>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'qusq-lite' ); ?></a>

	<header id="masthead" class="site-header">

		<div class="ish-container-fluid">
			<div class="ish-container-inner">
				<div class="ish-row">

					<div class="ish-header">

						<!-- Main Logo & Tagline -->
						<div class="ish-logo-container ish--tc3">

							<!-- Main Logo -->
							<?php qusq_lite_the_custom_logo(); ?>

							<!-- Header Tagline Area -->
							<?php if ( qusq_lite_has_tagline() ) : ?>
								<div class="<?php qusq_lite_output_classes( 'qusq_lite_output_classes_tagline', 'ish-theme-tagline ish-vertical' ); ?>">

									<!-- Site Title -->
									<?php if ( ! function_exists( 'has_custom_logo' ) || ! has_custom_logo() ) { ?>
										<div class="site-title-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
									<?php } ?>

									<!-- Site Tagline -->
									<span class="ish-tagline-text"><?php qusq_lite_the_tagline(); ?></span>
								</div>
							<?php endif; ?>

						</div>

						<!-- Menu open Button -->
						<div class="ish-menu-container ish--tc3">
							<a href="#"><span class="ish-icon-nav"><i class="ish-icon-menu"></i></span><span class="ish-menu-desc ish-vertical"><?php echo esc_html__( 'Menu', 'qusq-lite' ); ?></span></a>
						</div>

					</div>

					<div class="site-branding">

						<?php qusq_lite_the_advanced_title(); ?>

					</div><!-- .site-branding -->
				</div>

				<!-- Menu Container -->
				<div class="ish-navigation">

					<!-- Menu Decoration -->
					<div class="ish-nav-bg ish-theme-rotate"></div>


					<!-- Close Button -->
					<a href="#" class="ish-nav-close"><i class="ish-icon-cancel-1"></i><span><?php esc_html_e( 'Close', 'qusq-lite' ); ?></span></a>

					<div class="ish-nav-container-bg">
						<div class="ish-nav-container">

							<!-- Menu: Logo & Tagline -->
							<div class="ish-widget-element">
								<?php

								if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
									the_custom_logo();
								} else { ?>
									<!-- Site Title -->
									<div class="site-title-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
								<?php } ?>

								<!-- Site Tagline -->
								<?php if ( qusq_lite_has_tagline() ) : ?>
									<div class="ish-tagline-widget ish--tc1"><?php qusq_lite_the_tagline(); ?></div>
								<?php endif; ?>

							</div>

							<!-- Menu: Main Navigation -->
							<nav id="site-navigation" class="main-navigation ish-widget-element">
								<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'qusq-lite' ); ?></button> -->
								<?php wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_id' => 'primary-menu',
										'link_before' => '<span>',
										'link_after' => '</span>',
									)
								); ?>
							</nav><!-- #site-navigation -->

							<!-- Menu: Search Form -->
							<div class="ish-widget-element">
								<?php get_search_form(); ?>
							</div>

							<!-- Menu: Social icons -->
							<?php if ( has_nav_menu( 'social' ) ) { ?>
								<div class="ish-social-box ish-widget-element ish-row">
									<?php wp_nav_menu(
										array(
											'theme_location' => 'social',
											'menu_id' => 'social-menu-header',
										)
									); ?>
								</div>
							<?php } ?>


							<?php if ( qusq_lite_has_sidenav_legals() ) { ?>
								<!-- Menu: About Template -->
								<div class="ish-widget-element ish-sidenav-legals">
									<?php echo wp_kses_post( qusq_lite_get_sidenav_legals() ); ?>
								</div>
							<?php } else { ?>
								<!-- Menu: About Template -->
								<div class="ish-widget-element ish-sidenav-legals">
									<p><?php esc_html_e( 'Another amazing template by IshYoBoy', 'qusq-lite' ); ?></p>
								</div>
							<?php } ?>

						</div>
					</div> <!-- .ish-nav-container-bg-->
				</div><!-- .ish-navigation -->

			</div>

		</div>

		<div class="ish-decor-container"><div class="ish-decor-bottom ish-theme-rotate"></div></div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
