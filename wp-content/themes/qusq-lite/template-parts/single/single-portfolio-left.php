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

	<div class="ish-col-xs-12 ish-col-sm-7 ish-col-md-6">

		<div class="ish-pflo-gal ish-1col">

			<?php
			if ( get_post_gallery( get_the_ID(), false ) ) {

				$qusq_lite_post_gallery = get_post_gallery( get_the_ID(), false );
				$qusq_lite_items_count = count( $qusq_lite_post_gallery );

				// Open a custom Loop to go through all gallery images.
				$qusq_lite_query = new WP_Query(
					array(
						'post_type' => 'attachment',
						'post_status' => 'any',
						'posts_per_page' => $qusq_lite_items_count,
						'orderby' => 'post__in',
						'post__in' => explode( ',', $qusq_lite_post_gallery['ids'] ),
					)
				);

				while ( $qusq_lite_query->have_posts() ) : $qusq_lite_query->the_post(); ?>
					<div class="ish-row ish-item">
						<div class="ish-item-container">
							<?php if ( '' !== qusq_lite_get_post_thumbnail_caption( get_the_ID() ) ) { ?>
								<div class="ish-caption-container">
									<div class="ish-caption">
										<span><?php echo esc_html( qusq_lite_get_post_thumbnail_caption( get_the_ID() ) ); ?></span>
									</div>
								</div>
							<?php } ?>
							<div class="ish-img">
								<a href="<?php echo esc_url( wp_get_attachment_url( get_the_ID() ) ); ?>" class="ish-lightbox ish-img-scale ish-img-shadow" data-sub-html="<?php echo esc_attr( qusq_lite_get_post_thumbnail_caption( get_the_ID() ) ); ?>">
									<?php echo wp_get_attachment_image( get_the_ID(), 'medium_large' ); ?>
								</a>
							</div>
						</div>
					</div>
				<?php endwhile;

				// Restore the original WP Query.
				wp_reset_postdata();

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
			<?php } // End if(). ?>

		</div>

	</div>
	<div class="ish-col-xs-12 ish-col-sm-offset-1 ish-col-sm-4 ish-col-md-5 ish-pflo-content">

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

		<?php the_meta(); ?>

	</div>
</div>
