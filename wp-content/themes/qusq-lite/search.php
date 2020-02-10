<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Qusq_Lite
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">


			<div class="ish-container-fluid">
				<div class="ish-container-inner">

					<div id="ish-main-content" class="<?php echo esc_attr( qusq_lite_main_content_classes( array() ) ); ?>">

						<?php
						if ( have_posts() ) : ?>

							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'search' );

							endwhile;

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>

					</div>
				</div>
			</div>

			<div class="ish-container-fluid ish-pagination-container">
				<div class="ish-container-inner">
					<?php qusq_lite_the_posts_navigation(); ?>
				</div>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
