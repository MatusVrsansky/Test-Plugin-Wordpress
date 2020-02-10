<?php
/**
 * IshYoBoy Shortcodes Plugin Colors
 *
 * @package Qusq_Lite
 */

if ( ! function_exists( 'qusq_lite_dynamic_shortcodes_css_func' ) ) {
	/**
	 * Outputs the whole dynamic CSS
	 */
	function qusq_lite_dynamic_shortcodes_css_func() {

		// EMPTY THE VARIABLE WHICH WILL HOLD THE OUTPUT.
		$return = '';
		$empty = '';

		$colors = qusq_lite_get_theme_colors_array();

		/**
		 * Colors Loop - 1 ... N
		 */
		$colors_count = count( $colors );
		for ( $i = 1; $i < $colors_count + 1; $i ++ ) {

			// Set the current color.
			$c = $colors[ $i ];

			// Prepare the output.
			$return .= "
		.ish-sc-accordion.ish--bc$i dt,
		.ish-sc-toggle.ish--bc$i dt,
		.ish-sc-tabs.ish--bc$i .ish-active-item
		{
			background-color: $c;
		}

		.ish-sc-element.ish--tc$i a:not( .ish-sc-title ),
		.ish-sc-tabs.ish--tc$i .ish-tabs-menu .ish-active-item a,
		.ish-sc-tabs.ish--tc$i .ish-tabs-menu li:hover a,
		.ish-sc-accordion.ish--tc$i dt a,
		.ish-sc-toggle.ish--tc$i dt a
		{
			color: $c;
		}

		.ish-sc-accordion.ish--bc$i dt,
		.ish-sc-accordion.ish--bc$i dd,
		.ish-sc-toggle.ish--bc$i dt,
		.ish-sc-toggle.ish--bc$i dd,
		.ish-sc-tabs.ish--bc$i .ish-tabs-menu .ish-active-item,
		.ish-sc-tabs.ish--bc$i .ish-tabs 
		{
			border-color: $c;
		}

		.ish-sc-button:hover.ish--bc$i,
		.ish-sc-accordion.ish--bc$i dt:hover,
		.ish-sc-toggle.ish--bc$i dt:hover,
		.ish-sc-tabs.ish--bc$i .ish-tabs-menu li:hover
		{
			background-color: " . qusq_lite_sass_lighten_darken( $c, '15%' ) . ";
		}
		
		.ish-sc-accordion.ish--bc$i dt:hover,
		.ish-sc-accordion.ish--bc$i dt:hover + dd,
		.ish-sc-toggle.ish--bc$i dt:hover,
		.ish-sc-toggle.ish--bc$i dt:hover + dd,
		.ish-sc-tabs.ish--bc$i .ish-tabs-menu .ish-active-item:hover 
		{
			border-color: " . qusq_lite_sass_lighten_darken( $c, '15%' ) . ";
			$empty
		}";
		} // End for().

		/**
		 * Color 1
		 */

		// Set the current color.
		$c = $colors[1];

		// Prepare the output.
		$return .= '';

		/**
		 * Color 2
		 */
		// Set the current color.
		$c = $colors[2];

		// Prepare the output.
		$return .= "
	.ish-sc-tabs .ish-tabs,
	.ish-sc-accordion dd,
	.ish-sc-toggle dd
	{
	  color: $c;
	}
	";

		/**
		 * Color 3
		 */
		// Set the current color.
		$c = $colors[3];

		// Prepare the output.
		$return .= "
	.ish-sc-button:not( [class*='ish--tc'] )
	{
		color: $c;
	}
	";

		/**
		 * Color 4
		 */
		// Set the current color.
		$c = $colors[4];

		// Prepare the output.
		$return .= "
	.ish-sc-accordion[class*='ish--bc'] dt,
	.ish-sc-accordion[class*='ish--bc']:not( [class*='ish--tc'] ) dt a,
	.ish-sc-toggle[class*='ish--bc'] dt,
	.ish-sc-toggle[class*='ish--bc']:not( [class*='ish--tc'] ) dt a,
	.ish-sc-tabs[class*='ish--bc']:not( [class*='ish--tc'] ) .ish-tabs-menu .ish-active-item a,
	.ish-sc-tabs[class*='ish--bc']:not( [class*='ish--tc'] ) .ish-tabs-menu li:hover a
	{
		color: $c;
	}
	";

		// THE OUTPUT NEEDS TO BE RETURNED.
		return apply_filters( 'qusq_lite_dynamic_colors_css', $return, $colors );
	}
} // End if().

return call_user_func( 'qusq_lite_dynamic_shortcodes_css_func' );
