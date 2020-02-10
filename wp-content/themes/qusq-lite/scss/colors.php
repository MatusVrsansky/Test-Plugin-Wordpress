<?php
/**
 * Dynamic colors based on Customizer options
 *
 * @package Qusq_Lite
 */

if ( ! function_exists( 'qusq_lite_dynamic_css_func' ) ) {
	/**
	 * Outputs the whole dynamic CSS
	 */
	function qusq_lite_dynamic_css_func() {

		// EMPTY THE VARIABLE WHICH WILL HOLD THE OUTPUT.
		$return = '';
		$empty = '';

		$colors = qusq_lite_get_theme_colors_array();

		/**
		 * Colors Classes - Text & Background
		 */
		$colors_count = count( $colors );
		for ( $i = 1; $i < $colors_count + 1; $i ++ ) {

			// Set the current color.
			$c = $colors[ $i ];

			// Prepare the output.
			$return .= "
		.ish--tc$i {
			color: $c;
		}
		
		.ish--tc$i .ish-darken {
			color: " . qusq_lite_sass_lighten_darken( $c, '-5%' ) . " !important;
		}
		
		.ish--bc$i {
			background-color: $c;
		}";
		}

		/**
		 * Colors Loop - 1 ... N
		 */
		$colors_count = count( $colors );
		for ( $i = 1; $i < $colors_count + 1; $i ++ ) {

			// Set the current color.
			$c = $colors[ $i ];

			// Prepare the output.
			$return .= "
		.ish-color$i .ish-sticky-on .ish-logo-container .ish-logo-box,
		.ish-color$i .ish-sticky-on .ish-menu-container .ish-icon-nav,
		.ish-result.ish-color$i .ish-result-number,
		.ish-blog .ish-color$i .ish-underline:before,
		.ish-color$i .ish-underline:before,
		.ish-color$i .site-header .ish-container-fluid,
		.ish-color$i .site-header .ish-decor-container > div,
		.ish-color$i .site-header .ish-container-fluid.ish--bc$i,
		.ish-color$i .ish-sidebar input,
		.ish-color$i .ish-sidebar button,
		.ish-color$i blockquote:before,
		.ish-color$i blockquote:after,
		.ish-color$i .comment-respond input.submit,
		.ish-color$i .ish-post-navigation a:hover span:before,
		.ish-color$i .post-password-form input[type='submit']
		{
			background-color: $c;
		}

		.ish-result.ish-color$i .ish-title a,
		.ish-color$i .ish-blog-post-title a,
		.ish-blog .ish-color$i .ish-blog-post-title a,
		.ish-color$i .ish-sidebar .widget-title,
		.ish-color$i .ish-sidebar .widget-title a,
		.ish-color$i .ish-sidebar .rsswidget,
		.ish-color$i .ish-sidebar a:not( .ish-read-more ):not( .time ):not( .social-icon ):hover,
		.ish-color$i .comments-title,
		.ish-color$i .comment-reply-title,
		header .site-branding span.ish--tc$i
		{
			color: $c;
		}

		.ish-color$i .ish-main-content h1,
		.ish-color$i .ish-main-content h2,
		.ish-color$i .ish-main-content h3,
		.ish-color$i .ish-main-content h4,
		.ish-color$i .ish-main-content h5,
		.ish-color$i .ish-main-content h6,
		.ish-color$i:not( .search-results ) .ish-main-content a:not( .ish-underline ):not( .ish-sc-element ):not( .ish-sc-title ):hover,
		.ish-color$i .ish-main-content .bypostauthor .comment-author
		{
			color: $c;
		}

		body.ish-color$i .ish-pflo-content .post-meta .post-meta-key,
		body.ish-color$i .ish-pflo-meta .post-meta .post-meta-key 
		{
			color: $c;
		}

		.ish-color$i .ish-sidebar button:hover,
		.ish-color$i .post-password-form input[type='submit']:hover,
		a:hover.ish--bc$i
		{
			background-color: " . qusq_lite_sass_lighten_darken( $c, '15%' ) . ";
		}

		.ish-color$i .comment-respond input.submit:hover 
		{
			background-color: " . qusq_lite_sass_lighten_darken( $c, '-15%' ) . ";
		}
		
		.ish--tc$i a:hover,
		a:hover.ish--tc$i 
		{
			color: " . qusq_lite_sass_lighten_darken( $c, '15%' ) . ";
			$empty
		}";
		} // End for().

		/**
		 * Color 1
		 */

		// Set the current color.
		$c = $colors[1];

		// Prepare the output.
		$return .= "
	.ish-nav-container .ish-search-submit:hover,
	.ish-navigation .ish-social-box a:hover,
	.ish-footer .ish-social-box a:hover,
	.ish-social-box a:hover 
	{
		color: $c;
	}
	
	.ish-sticky-on .ish-logo-container .ish-logo-box,
	.ish-sticky-on .ish-menu-container .ish-icon-nav,
	.ish-navigation ul li.ish-active-item span:before,
	.ish-navigation ul li.current-menu-item span:before,
	.ish-navigation ul li.current-menu-ancestor span:before,
	.ish-navigation ul li.ish-hover > a span:before,
	.ish-page-numbers:hover,
	.ish-page-numbers.ish-next,
	.ish-page-numbers.ish-prev.ish-disabled,
	.ish-page-numbers.ish-prev.ish-disabled:hover,
	#infinite-handle,
	.ish-footer a:hover:before,
	.ish-back-to-top a.ish-hover span:before,
	.ish-footer .ish-underline:before,
	.ish-navigation .ish-underline:before 
	{
		background-color: $c;
	}
	";

		/**
		 * Color 2
		 */
		// Set the current color.
		$c = $colors[2];

		// Prepare the output.
		$return .= "
	html,
	a,
	.ish-title,
	.ish-main-content .no-results .page-title,
	form input::placeholder,
	form textarea::placeholder,
	#content .ish-social-box a
	{
	  color: $c;
	}
	
	.ish-contact-form-box h3 
	{
		color: $c !important;
	}
	
	.ish-navigation .ish-nav-close,
	.ish-navigation ul ul a,
	.ish-navigation .ish-social-box a,
	.ish-footer,
	.ish-social-box a,
	.ish-footer .ish-social-box a,
	#content .ish-social-box a:hover,
	.ish-widget-element input::placeholder,
	.ish-widget-element textarea::placeholder,
	#ish-contact-form button[type=\"submit\"]:hover,
	.contact-form input[type=\"submit\"]:hover,
	.wpcf7-form input[type=\"submit\"]:hover 
	{
		color: " . qusq_lite_sass_lighten_darken( $c, '34%' ) . ";
	}
	
	.ish-navigation .ish-nav-container-bg,
	.ish-navigation .ish-nav-bg,
	.ish-page-numbers,
	.ish-page-numbers.ish-next:hover,
	.ish-page-numbers.ish-next.ish-disabled,
	.ish-page-numbers.ish-next.ish-disabled:hover,
	#infinite-handle:hover,
	.ish-navigation .ish-nav-close,
	pre, hr,
	.ish-blurred-overlay
	{
		background-color: $c;
	}
	
	.comment-respond input,
	.comment-respond textarea,
	select,
	.ish-widget-element input[type=\"submit\"] 
	{
		background-color: " . qusq_lite_sass_lighten_darken( $c, '15%' ) . ";
	}
	$empty
	
	.comment-respond input:hover,
	.comment-respond textarea:hover,
	.ish-widget-element input[type=\"submit\"]:hover 
	{
		background-color: " . qusq_lite_sass_lighten_darken( $c, '20%' ) . ";
	}
	$empty
	
	.ish-shadow-image .ish-item .ish-img .ish-placeholder,
	.ish-item .ish-img .ish-placeholder 
	{
		background-color: " . qusq_lite_sass_lighten_darken( $c, '63%' ) . ";
	}
	$empty
	
	.sharedaddy h3.sd-title 
	{
		border-color: " . qusq_lite_sass_lighten_darken( $c, '15%' ) . ";
	}
	$empty
	
	.ish-sidebar
	{
		border-color: " . qusq_lite_sass_lighten_darken( $c, '60%' ) . ";
	}
	$empty
	";

		/**
		 * Color 3
		 */
		// Set the current color.
		$c = $colors[3];

		// Prepare the output.
		$return .= "
	.ish--tc3 a,
	.ish-navigation a,
	.ish-navigation,
	.ish-page-numbers,
	#infinite-handle,
	.ish-footer a,
	.ish-result .ish-result-number,
	.ish-sidebar .ish-widget-element input::placeholder,
	.ish-sidebar .ish-widget-element textarea::placeholder,
	pre,
	.comment-respond input,
	.comment-respond textarea,
	.comment-respond input::placeholder,
	.comment-respond textarea::placeholder,
	header .site-branding span,
	header .site-branding .ish-underline,
	.post-password-form input[type='submit']
	{
		color: $c;
	}
	
	.ish-portfolio-navigation a:hover span:before,
	header .site-branding .ish-underline:before 
	{
		background-color: $c;
	}
	";

		/**
		 * Color 4
		 */
		// Set the current color.
		$c = $colors[4];

		// Prepare the output.
		$return .= "
	mark,
	.ish-sidebar input,
	.ish-sidebar button 
	{
		color: $c;
	}
	
	.tiled-gallery-caption 
	{
		color: $c !important;
	}
	";

		/**
		 * Color 14
		 */
		// Set the current color.
		$c = $colors[14];

		// Prepare the output.
		$return .= "
	mark 
	{
		background-color: $c;
	}
	";

		/**
		 * Color Black
		 */

		// Prepare the output.
		$return .= "
	.tiled-gallery-caption 
	{
		background-color: #000000 !important;
	}
	$empty
	";

		/**
		 * Form colors
		 */
		// Prepare the output.
		$return .= "
	form input.invalid,
	form textarea.invalid 
	{
		border-top-color: #ff0000;
	}
	
	.required-error:before,
	.required-error:after 
	{
		color: #ff0000;
	}
	
	div.wpcf7-validation-errors 
	{
		border-color: #ff0000;
	}
	$empty
	";

		/**
		 * Keyframe Animations
		 */
		// Prepare the output.
		$return .= "
	@keyframes animateBgColor
	{
		25%  {background: $colors[5];}
		50%  {background: $colors[13];}
		75%  {background: $colors[6];}
	}
	";

		// THE OUTPUT NEEDS TO BE RETURNED.
		return apply_filters( 'qusq_lite_dynamic_colors_css', $return, $colors );
	}
} // End if().

return call_user_func( 'qusq_lite_dynamic_css_func' );
