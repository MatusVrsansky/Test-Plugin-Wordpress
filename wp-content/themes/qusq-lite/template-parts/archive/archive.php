<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Qusq_Lite
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ish-item' ); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="ish-blog-post-media">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="ish-img-scale ish-img-shadow">
				<?php
				if ( qusq_lite_display_sidebar() || ( 'classic' !== qusq_lite_get_blog_layout() ) ) {
					the_post_thumbnail( 'medium_large' );
				} else {
					the_post_thumbnail( 'large' );
				}
				?>
			</a>
		</div>
	<?php } ?>
	<div class="ish-blog-post-title">
		<h4><a href="<?php echo esc_url( get_permalink() ); ?>" class="ish-underline">
				<?php if ( is_sticky() ) { ?>
					<i class="ish-icon-pin"></i>
				<?php } ?>
				<?php echo get_the_title(); ?>
			</a>
		</h4>
	</div>
	<div class="ish-row">
		<div class="ish-blog-post-details ish-col-xs-12 ish-col-sm-4">
			<div class="ish-label"><?php esc_html_e( 'on', 'qusq-lite' ); ?></div>
			<div><a href="<?php qusq_lite_get_day_link(); ?>" class="ish-underline"><?php echo get_the_date(); ?></a></div>
			<div class="ish-label"><?php esc_html_e( 'in', 'qusq-lite' ); ?></div>
			<div><?php qusq_lite_get_first_post_category(); ?></div>
			<div class="ish-read-more"><a href="<?php echo esc_url( get_permalink() ); ?>" class="ish-underline ish-underline-visible"><?php esc_html_e( 'Read More', 'qusq-lite' ) ?></a></div>
		</div>
		<div class="ish-blog-post-content ish-col-xs-12 ish-col-sm-8">
			<?php qusq_lite_check_read_more_tag_and_excerpt(); ?>
		</div>
	</div>
</article>
