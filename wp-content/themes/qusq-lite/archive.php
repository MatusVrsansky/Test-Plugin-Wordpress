<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Qusq_Lite
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="ish-container-fluid">
				<div class="ish-container-inner">

					<div id="ish-main-content" class="<?php echo esc_attr( qusq_lite_main_content_classes( array() ) ); ?>">

						<?php
						if ( have_posts() ) : ?>

							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php ( where ___ is the Post Format name ) and that will be used instead.
								 */
								get_template_part( 'template-parts/archive/archive', get_post_format() );

							endwhile;

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>

					</div>

					<?php if ( qusq_lite_display_sidebar() ) : ?>
						<div class="ish-sidebar ish-sidebar-right">
							<?php
							get_sidebar();
							?>
						</div>
					<?php endif; ?>

				</div>
			</div>

			<div class="ish-container-fluid ish-pagination-container">
				<div class="ish-container-inner">
					<?php qusq_lite_the_posts_navigation(); ?>
				</div>
			</div>



		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
