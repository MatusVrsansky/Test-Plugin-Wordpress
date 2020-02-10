/**
 * Module's JavaScript
 *
 * @package Qusq_Lite
 */

jQuery( document ).on( 'click', '.qusq-lite-notice .notice-dismiss', function() {

	var days = jQuery( this ).parents( '.qusq-lite-notice' ).attr( 'data-notice-type' );

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'qusq_lite_dismiss_notice',
			days: days
		}
	})

});
