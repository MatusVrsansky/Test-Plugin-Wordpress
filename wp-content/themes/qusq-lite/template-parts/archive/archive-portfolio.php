<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Qusq_Lite
 */

?>
<div id="post-<?php the_ID(); ?>" class="ish-item">
	<div class="ish-item-container">
		<div class="ish-caption-container">
			<div class="ish-caption">
				<?php if ( function_exists( 'qusq_lite_get_main_text_color_class' ) ) { ?>
					<span class="ish-h4 <?php echo esc_attr( qusq_lite_get_main_text_color_class() ); ?>"><?php echo get_the_title(); ?></span>
				<?php } else { ?>
					<span class="ish-h4 ish--tc7"><?php echo get_the_title(); ?></span>
				<?php } ?>
				<span><?php qusq_lite_get_first_portfolio_category(); ?></span>
			</div>
		</div>

		<?php if ( qusq_lite_is_portfolio_popup() ) { ?>

			<?php if ( has_post_thumbnail() ) { ?>
				<div class="ish-img">
					<a href="<?php echo esc_url( get_the_post_thumbnail_url( null, 'large' ) ); ?>" class="ish-lightbox ish-img-scale ish-img-shadow" data-sub-html="<?php echo esc_attr( qusq_lite_get_post_thumbnail_caption() ); ?>" style="background-image: url( '<?php echo esc_url( get_the_post_thumbnail_url( null, 'large' ) ); ?>' );">
						<?php the_post_thumbnail( 'medium_large' ); ?>
					</a>
				</div>
			<?php } else { ?>
				<div class="ish-img ish-no-img">
					<span class="ish-placeholder"></span>
				</div>
			<?php } ?>

		<?php } else { ?>

			<?php if ( has_post_thumbnail() ) { ?>
				<div class="ish-img">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="ish-img-scale ish-img-shadow" data-sub-html="<?php echo esc_attr( qusq_lite_get_post_thumbnail_caption() ); ?>" style="background-image: url( '<?php echo esc_url( get_the_post_thumbnail_url( null, 'large' ) ); ?>' );">
						<?php the_post_thumbnail( 'medium_large' ); ?>
					</a>
				</div>
			<?php } else { ?>
				<div class="ish-img">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="ish-placeholder"></a>
				</div>
			<?php } ?>

		<?php } ?>


	</div>
</div>
