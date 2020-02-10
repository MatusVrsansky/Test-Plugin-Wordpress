<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Qusq_Lite
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'ish-row' ); ?>>

	<div class="ish-col-xs-12">
		<?php
		if ( get_post_gallery( get_the_ID(), false ) ) {
			qusq_lite_output_the_first_post_gallery();
		} elseif ( has_post_thumbnail() ) { ?>
			<div class="ish-row ish-item ish-featured-image">
				<div class="ish-item-container">
					<div class="ish-caption-container">
						<div class="ish-caption">
							<span><?php echo esc_html( qusq_lite_get_post_thumbnail_caption() ); ?></span>
						</div>
					</div>
					<div class="ish-img">
						<a href="<?php echo esc_url( get_the_post_thumbnail_url( null, 'large' ) ); ?>" class="ish-lightbox ish-img-scale ish-img-shadow" data-sub-html="<?php echo esc_attr( qusq_lite_get_post_thumbnail_caption() ); ?>">
							<?php the_post_thumbnail( 'medium_large' ); ?>
						</a>
					</div>
				</div>
			</div>
		<?php } ?>

	</div>

	<div class="ish-col-xs-12">
		<h3 class="ish--tc18">
			<?php qusq_lite_output_the_first_post_headline( true ); ?>
		</h3>
	</div>

	<div class="ish-col-xs-12">
		<div class="ish-row">
			<div class="ish-col-xs-12 ish-col-sm-8">

				<?php

				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. */
						__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'qusq-lite' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<hr><div class="page-links ish-theme-element">' . esc_html__( 'Pages:', 'qusq-lite' ),
					'after'  => '</div>',
				) );

				?>

			</div>
			<div class="ish-col-xs-12 ish-col-sm-4 ish-pflo-meta">

				<?php the_meta(); ?>

			</div>
		</div>
	</div>
</div>
