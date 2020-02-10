/**
 * Module's JavaScript
 *
 * @package Qusq_Lite
 */

jQuery( window ).on( "load", function() {

	// Add pro version nag to Color Controls in Customizer.
	jQuery( '.customize-control-color' ).each( function(){
		if ( -1 !== jQuery( this ).attr( 'id' ).indexOf( '-lite-promo' ) ) {
			jQuery( data.nag_html ).insertBefore( jQuery( this ) );
		}
	});

});
