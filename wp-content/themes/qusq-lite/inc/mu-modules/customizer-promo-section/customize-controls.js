/**
 * Module's JavaScript
 *
 * @package Qusq_Lite
 */

( function( api ) {

	// Extends our custom "qusq-lite" section.
	api.sectionConstructor['qusq-lite'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
