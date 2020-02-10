<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Qusq_Lite
 */

?>

<div class="ish-row ish-results">
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'ish-result ish-col-xs-12 ish-col-sm-11' ); ?>>
		<span class="ish-result-number"><?php echo esc_html( qusq_lite_search_results_number() ); ?></span>
		<?php the_title( sprintf( '<h4 class="ish-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
		<p class="entry-summary"><?php qusq_lite_check_read_more_tag_and_excerpt(); ?></p>
	</div>
</div>
