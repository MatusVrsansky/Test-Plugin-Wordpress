<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Qusq_Lite
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer">

	<div class="ish-decor-container"><div class="ish-decor-top ish-theme-rotate ish--bc2"></div></div>

	<div class="ish-container-fluid ish--bc2">
		<div class="ish-container-inner">
			<div class="ish-row">

				<div class="ish-footer ish-col-xs-offset-1 ish-col-xs-10">

					<!-- Logo -->
					<?php if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) { ?>
						<div class="ish-widget-element">
							<?php the_custom_logo(); ?>
						</div>
					<?php } else { ?>
						<!-- Site Title -->
						<div class="site-title-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
					<?php } ?>

					<!-- Tagline -->
					<?php if ( qusq_lite_has_tagline() ) : ?>
						<div class="ish-widget-element">
							<div class="ish-tagline-widget ish--tc3"><?php qusq_lite_the_tagline(); ?></div>
						</div>
					<?php endif; ?>


					<?php if ( has_nav_menu( 'social' ) ) { ?>
						<div class="ish-social-box ish-widget-element ish-center-xs">
							<?php wp_nav_menu( array(
								'theme_location' => 'social',
								'menu_id' => 'social-menu-footer',
							) ); ?>
						</div>
					<?php } ?>

					<?php if ( qusq_lite_has_legals() ) { ?>
						<div class="site-info ish-legals ish-widget-element">
							<?php echo wp_kses_post( qusq_lite_get_legals() ); ?>
						</div>
					<?php } else { ?>
						<div class="site-info ish-legals ish-widget-element">
							<?php /* translators: Theme Name with a link to website */ ?>
							<?php printf( '%s %s', '<a href="http://' . esc_url( 'ishyoboy.com' ) . '/" class="ish-underline">' . esc_html__( 'Qusq Lite', 'qusq-lite' ) . '</a>', esc_html__( 'Theme', 'qusq-lite' ) ); ?>
							<span class="ish-separator">~</span>
							<?php /* translators: WordPress with a link to website */ ?>
							<?php printf( '%s %s', esc_html__( 'Proudly powered by', 'qusq-lite' ),'<a href="https://' . esc_attr( 'wordpress.org' ) . '/" target="_blank" class="ish-underline">' . esc_html__( 'WordPress', 'qusq-lite' ) . '</a>' ); ?>
							<span class="ish-separator">~</span>
							<?php /* translators: Author Name with a link to website */ ?>
							<?php printf( '%s %s', esc_html__( 'Created by', 'qusq-lite' ),'<a href="https://' . esc_attr( 'ishyoboy.com' ) . '/" target="_blank" class="ish-underline">' . esc_html__( 'IshYoBoy.com', 'qusq-lite' ) . '</a>' ); ?>
						</div>
					<?php } ?>

				</div>

				<div class="ish-back-to-top ish-widget-element ish-col-xs-1">
					<a href="#page" class="ish--tc3"><span><?php esc_html_e( 'Back to Top', 'qusq-lite' ); ?></span><i class="ish-icon-right-small"></i></a>
				</div>

			</div>
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
