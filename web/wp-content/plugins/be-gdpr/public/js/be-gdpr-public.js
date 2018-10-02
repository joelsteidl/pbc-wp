(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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

$(function(){

	function be_gdpr_trigger_magnific_popup(){
		if($('.mfp-popup').length > 0) {
			$('.mfp-popup').magnificPopup({
				type:'inline',
				midClick: true,
				closeBtnInside:true,
			});
		}
	}

	window.be_gdpr_magnific_popup_retrigger = be_gdpr_trigger_magnific_popup;
	be_gdpr_trigger_magnific_popup();

		function readCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			}
			return null;
		}
		function createCookie(name, value) {
			
			var date = new Date();
			date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000)); //a year
			var expires = "; expires=" + date.toGMTString();         

		document.cookie = name + "=" + value + expires + "; path=/";
		}
		var checkBoxes = $('.be-gdpr-switch-input');
		var privacyPref = readCookie('be_gdpr_privacy') || [];
		
		for (var count in checkBoxes){
			var singleCheckBox = checkBoxes[count];
			if( privacyPref.indexOf(singleCheckBox.value) >= 0 ){
				singleCheckBox.checked = true;
			}
		}
		
		$('.be-gdpr-modal-save-btn').click(function(){
			var tempCookies = []
			
			for (var count in checkBoxes){
				var singleCheckBox = checkBoxes[count];
				if( singleCheckBox.checked ){
					tempCookies.push(singleCheckBox.value)
				}
			}
			createCookie( 'be_gdpr_privacy',"",-1);
			createCookie('be_gdpr_privacy',JSON.stringify(tempCookies));
			window.location.reload();
		});

		$( '.be-gdpr-cookie-notice-button' ).click(function(){
			$('.be-gdpr-cookie-notice-bar').css('bottom','-100px');
			createCookie('be_gdpr_cookie_accept','1');
		});

});


})( jQuery );
