<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Qusq_Lite
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="ish-container-fluid">
				<div class="ish-container-inner">

					<div id="ish-main-content" class="<?php echo esc_attr( qusq_lite_main_content_classes( array( 'ish-blog-post-content' ) ) ); ?>">
						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/single/single', get_post_format() );

							?>
							<?php if ( ! is_attachment() ) : ?>
								<hr>
								<div class="ish-post-navigation ish-theme-element">
									<?php

									the_post_navigation(
										array(
											'prev_text'	=> '<i class="ish-icon-left-small"></i><span>' . esc_html__( 'Previous Article', 'qusq-lite' ) . '</span>',
											'next_text' => '<span>' . esc_html__( 'Next Article', 'qusq-lite' ) . '</span><i class="ish-icon-right-small"></i>',
										)
									);

									?>
								</div>
							<?php endif; ?>
							<hr>
							<?php

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
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

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
