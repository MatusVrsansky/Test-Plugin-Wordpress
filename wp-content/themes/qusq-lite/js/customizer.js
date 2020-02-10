/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package Qusq_Lite
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a, .site-title-text' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.ish-tagline-text, .ish-tagline-widget' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {

			var header_el = $( '.site-title a, .site-title-text, .ish-tagline-text' );

			if ( 'blank' === to ) {
				header_el.css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				header_el.css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				header_el.css( {
					'color': to
				} );
			}
		} );
	} );

	// Homepage Taglines.
	wp.customize( 'qusq_lite_homepage_tagline', function( value ) {
		value.bind( function( to ) {
			$( '.site-branding h1 span' ).html( to );
		} );
	} );
	wp.customize( 'qusq_lite_homepage_subtagline', function( value ) {
		value.bind( function( to ) {
			$( '.site-branding h2 span' ).html( to );
		} );
	} );

	// Footer Legals.
	wp.customize( 'qusq_lite_footer_legals', function( value ) {
		value.bind( function( to ) {
			$( '.ish-legals' ).html( to );
		} );
	} );

	// Sidenav Legals Text.
	wp.customize( 'qusq_lite_sidenav_legals', function( value ) {
		value.bind( function( to ) {
			$( '.ish-sidenav-legals' ).html( to );
		} );
	} );

} )( jQuery );
