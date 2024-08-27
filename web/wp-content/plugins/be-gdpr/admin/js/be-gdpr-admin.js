(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	document.addEventListener("DOMContentLoaded", function(){
		function ready() {
			toggle_multi_language_translation();
		}
		//on toggle Multi Language Translation keep predefined options only 
		function toggle_multi_language_translation(){
			var checkbox_multi_lang = document.getElementById('be-gdpr-multi-language-translation');
			var settings_single_lang = document.getElementById('be-settings-page-for-single-language');
			if ( 'undefined' === typeof checkbox_multi_lang || null === checkbox_multi_lang || 'undefined' === typeof settings_single_lang || null === settings_single_lang ) {
				return false;
			}
			checkbox_multi_lang.addEventListener( 'click', function ( e ) {
				//select all textarea and input boxes
				var input_boxes = settings_single_lang.querySelectorAll('textarea, input');
				if ( 'undefined' === typeof input_boxes || null === input_boxes  ) {
					return false;
				}
				settings_single_lang.style.display = ( checkbox_multi_lang.checked ) ? 'none': 'block';
				//disable or enable input 
				for (let index = 0; index < input_boxes.length; index++) {
					input_boxes[index].disabled = ( checkbox_multi_lang.checked ) ? true: false;
				}
			});
		}

		ready();
	});
})( jQuery );
