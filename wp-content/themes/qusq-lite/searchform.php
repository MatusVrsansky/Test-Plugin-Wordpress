<?php
/**
 * Template for displaying search forms in Qusq Lite theme
 *
 * @package Qusq_Lite
 */

?>
<form role="search" method="get" class="ish-search-form ish-widget-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<p>
			<input type="text" value="<?php echo get_search_query(); ?>" name="s" class="ish-search-input" placeholder="<?php esc_attr_e( 'Search', 'qusq-lite' );?>">
		</p>
		<button type="submit" class="ish-search-submit"><i class="ish-icon-search"></i></button>
	</div>
</form>
