<?php
/**
 * Template Name: Project - 2 Columns - Left Gallery
 * Template Post Type: jetpack-portfolio
 *
 * This is the template that displays all team child pages.
 *
 * @package Qusq_Lite
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="ish-container-fluid">
				<div class="ish-container-inner">

					<div id="ish-main-content" class="<?php echo esc_attr( qusq_lite_main_content_classes( array( 'ish-content-parallax' ) ) ); ?>">
						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/single/single-portfolio-left' );

						endwhile; // End of the loop.
						?>
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
