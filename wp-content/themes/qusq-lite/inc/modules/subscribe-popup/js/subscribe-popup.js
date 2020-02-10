/**
 * Subscribe Pop Up Functionality.
 *
 * @package Qusq_Lite
 */

jQuery( document ).ready( function ( $ ) {

	createSubscribePopUp();
	activateSubscribePopUp();
	closeSubscribePopUp();
	displaySubscribePopUpFromPage();

} );

jQuery( window ).load( function ( $ ) {

	var subscribePopupError = getSubscribeCookie( phpVars.theme_slug + '_subscribe_error' );
	var subscribePopupClosed = getSubscribeCookie( phpVars.theme_slug + '_subscribe_closed' );

	if ( ( 'yes' !== subscribePopupClosed || 'yes' === subscribePopupError ) ) {
		displaySubscribePopUp();
	}

});

/**
 * Subscribe Pop Up.
 */
createSubscribePopUp = function () {

	var popupHtml = '' +
		'<div class="ish-subscribe-popup ish-subscribe-popup--invisible ish-subscribe-popup--message">' +
		'<div class="ish-subscribe-popup__bg"></div>' +
		'<div class="ish-subscribe-popup__box">' +
		'<div class="ish-subscribe-spinner ish-subscribe-spinner--invisible">' +
		'<div class="ish-subscribe-spinner__element"></div>' +
		'</div>' +
		'<a href="#" class="ish-subscribe-close-icon"></a>' +
		'<h2 class="ish-subscribe-title">' + phpVars.strings.popup_title + '</h2>' +
		'<p class="ish-subscribe-content">' + phpVars.strings.popup_message + '</p>' +
		'<form id="ish-subscribe-form" class="ish-subscribe-form" action="https://mvdev.ishyoboy.com/iybweb/wp/wp-admin/admin-ajax.php" method="get">' +
		'<input type="email" name="email" class="ish-subscribe-form__email" placeholder="' + phpVars.strings.popup_email_placeholder + '">' +
		'<input type="hidden" name="action" value="get_free_support">' +
		'<input type="hidden" name="security_nonce" value="' + phpVars.security_nonce + '">' +
		'<input type="submit" value="' + phpVars.strings.popup_send_button + '" class="ish-subscribe-form__submit">' +
		'</form>' +
		'<p class="ish-subscribe-disclaimer">' + phpVars.strings.popup_disclaimer + '</p>' +
		'</div>' +
		'</div>';

	jQuery( 'body' ).prepend( popupHtml );

};

/**
 * Display Subscribe Pop Up.
 */
displaySubscribePopUp = function () {

	var subscribePopUp = jQuery( '.ish-subscribe-popup' );

	if ( subscribePopUp.length > 0 ) {
		subscribePopUp.removeClass( 'ish-subscribe-popup--invisible' );
	}

	// Delete error cookie when displaying popup.
	setSubscribeCookie( phpVars.theme_slug + '_subscribe_error', '', 1 );

};

/**
 * Display Subscribe Pop Up From Page.
 */
displaySubscribePopUpFromPage = function () {

	var openButton = jQuery( '.ish-subscribe-form__button--link' );

	if ( openButton.length > 0 ) {
		openButton.on( 'click', function ( e ) {
			e.preventDefault();
			displaySubscribePopUp();
		} );
	}

};

/**
 * Return message html
 */
var getHtmlMessage = function ( messageTitle, messageContent, messageStatus ) {
	var popupHtmlMessage = '' +
		'<a href="#" class="ish-subscribe-close-icon"></a>' +
		'<h2 class="ish-subscribe-title">' + messageTitle + '</h2>' +
		'<p class="ish-subscribe-content">' +
		messageContent +
		'</p>' +
		'<form id="ish-subscribe-form" class="ish-subscribe-form">' +
		'<input type="button" value="' + phpVars.strings.popup_close_button + '" class="ish-subscribe-form__button ish-subscribe-form__button--' + messageStatus + '">' +
		'</form>';

	return popupHtmlMessage;
};

var getHtmlErrorMessage = function ( messageTitle, messageContent ) {
	return getHtmlMessage( messageTitle, messageContent, 'error' );
};

var getHtmlSuccessMessage = function ( messageTitle, messageContent ) {
	return getHtmlMessage( messageTitle, messageContent, 'success' );
};


/**
 * Enable form send functionality
 */
activateSubscribePopUp = function () {

	var popup = jQuery( '#ish-subscribe-form' );

	if ( popup.length > 0 ) {

		popup.on( 'submit', function ( event ) {

			event.preventDefault();

			// Display preloader in popup.
			jQuery( '.ish-subscribe-spinner' ).removeClass( 'ish-subscribe-spinner--invisible' );
			var boxContentClass = '.ish-subscribe-popup .ish-subscribe-popup__box';

			jQuery.ajax( {
				type: "POST",
				url: phpVars.ajaxurl,
				data: popup.serialize(), // Serializes the form's elements.
				success: function ( response ) {

					if ( typeof response === 'object' ) {
						if ( response.hasOwnProperty( 'success' ) && true === response.success ) {
							setSubscribeCookie( phpVars.theme_slug + '_subscribe_error', '', 1 );
							jQuery( boxContentClass ).html( getHtmlSuccessMessage( phpVars.strings.success_title, response.data[ 'message' ] ) );
							jQuery( '#ish-subscribe-content-cta' ).slideUp( 400 );
						} else {
							setSubscribeCookie( phpVars.theme_slug + '_subscribe_error', 'yes', 1 );
							jQuery( boxContentClass ).html( getHtmlErrorMessage( phpVars.strings.error_title, response.data[ 'error' ] ) );
						}
					} else {
						setSubscribeCookie( phpVars.theme_slug + '_subscribe_error', 'yes', 1 );
						jQuery( boxContentClass ).html( getHtmlErrorMessage( phpVars.strings.error_title, phpVars.strings.error_not_object ) );
					}

				},
				error: function () {
					setSubscribeCookie( phpVars.theme_slug + '_subscribe_error', 'yes', 1 );
					jQuery( boxContentClass ).html( getHtmlErrorMessage( phpVars.strings.error_title, phpVars.strings.error_ajax_error ) );
				}
			} );

		} );
	} // End if().

};

/**
 * Close Subscribe Pop Up.
 */
closeSubscribePopUp = function () {

	var closeButton = jQuery( '.ish-subscribe-popup' );

	if ( closeButton.length > 0 ) {

		closeButton.on( 'click', '.ish-subscribe-close-icon, .ish-subscribe-form__button', function ( e ) {

			e.preventDefault();

			setSubscribeCookie( phpVars.theme_slug + '_subscribe_closed', 'yes', 1 );

			jQuery( '.ish-subscribe-popup' ).addClass( 'ish-subscribe-popup--invisible' );

		} );

	}

};

/**
 * Create a Cookie
 */
function setSubscribeCookie( scname, scvalue, scdays ) {
	var scdate = new Date();
	scdate.setTime( scdate.getTime() + ( scdays * 24 * 60 * 60 * 1000 ) );
	var scexpires = "expires=" + scdate.toUTCString();
	document.cookie = scname + "=" + scvalue + ";" + scexpires + ";path=/";
}

/**
 * Read a Cookie
 */
function getSubscribeCookie( scname ) {
	var name = scname + "=";
	var scarray = document.cookie.split( ';' );
	var scarrayLength = scarray.length;
	for ( var i = 0; i < scarrayLength; i++ ) {
		var sc = scarray[ i ];
		while ( sc.charAt( 0 ) == ' ' ) {
			sc = sc.substring( 1 );
		}
		if ( sc.indexOf( name ) == 0 ) {
			return sc.substring( name.length, sc.length );
		}
	}
	return "";
}
