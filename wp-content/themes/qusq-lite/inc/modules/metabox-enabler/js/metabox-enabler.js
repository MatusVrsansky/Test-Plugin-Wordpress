/**
 * Metabox enabler JS
 *
 * @package Qusq_Lite
 */

jQuery( document ).ready( function( jQuery ) {
	jQuery( '.ish_color_selector_container' ).each( function() {
		var me = jQuery( this );
		var input = me.find( 'input.ish_color_selector' );

		me.find( '.ish_btnlist_item' ).click( function(e) {
			e.preventDefault();
			var item = jQuery( this );
			input.val( item.attr( 'data-ish-value' ) );
			input.trigger( 'change' );
			me.find( 'li' ).removeClass( 'active' );
			item.parent().addClass( 'active' );
		});
	});
});
