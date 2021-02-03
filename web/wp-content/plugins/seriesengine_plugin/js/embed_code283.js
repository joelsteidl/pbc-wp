jQuery(document).ready(function(){ /* ----- Series Engine - Generate Custom Embed Code ----- */
	
	jQuery('#enmse-embed-start').change(function() { // Choose a starting point
		var startvalue = jQuery(this).val();
		if (startvalue > 0) {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedseriestypes'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-one').html(data);
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
			jQuery("#enmse-embed-one").show();
			jQuery("#enmse-embed-two").hide();
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery("#enmse-embed-one").hide();
			jQuery("#enmse-embed-two").hide();
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		};
	});
	
	jQuery(document).on("change", "#enmse-embed-st", function() { // Next after choosing Series Type
		var startvalue = jQuery('#enmse-embed-start').val();
		var stvalue = jQuery(this).val();
		if (startvalue == 0) {
			alert("Please choose an option in Step 1!");
		} else if (startvalue == 1) { // Most Recent Message
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedoptions'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-four').html(data);
					jQuery("#enmse-embed-four").show();
					jQuery("#enmse-embed-code").hide();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		} else if (startvalue == 2) { // Specific Series
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery.ajax({
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxembedseries',
			            'enmse_stid': stvalue
			        },
			        success:function(data) {
	
						jQuery('#enmse-embed-two').html(data);
						jQuery("#enmse-embed-two").show();
						jQuery("#enmse-embed-three").hide();
						jQuery("#enmse-embed-four").hide();
						jQuery("#enmse-embed-code").hide();
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}
		} else if (startvalue == 3) { // Specific Topic
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery.ajax({
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxembedtopic',
			            'enmse_stid': stvalue
			        },
			        success:function(data) {
	
						jQuery('#enmse-embed-two').html(data);
						jQuery("#enmse-embed-two").show();
						jQuery("#enmse-embed-three").hide();
						jQuery("#enmse-embed-four").hide();
						jQuery("#enmse-embed-code").hide();
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}
		} else if (startvalue == 6) { // Specific Topic
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery.ajax({
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxembedspeaker',
			            'enmse_stid': stvalue
			        },
			        success:function(data) {
	
						jQuery('#enmse-embed-two').html(data);
						jQuery("#enmse-embed-two").show();
						jQuery("#enmse-embed-three").hide();
						jQuery("#enmse-embed-four").hide();
						jQuery("#enmse-embed-code").hide();
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}
		} else if (startvalue == 8) { // Specific Book
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery.ajax({
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxembedbook',
			            'enmse_stid': stvalue
			        },
			        success:function(data) {
	
						jQuery('#enmse-embed-two').html(data);
						jQuery("#enmse-embed-two").show();
						jQuery("#enmse-embed-three").hide();
						jQuery("#enmse-embed-four").hide();
						jQuery("#enmse-embed-code").hide();
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}
		} else if (startvalue == 4) { // Specific Message
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery.ajax({
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxembedseries',
			            'enmse_stid': stvalue,
			            'enmse_message': '1'
			        },
			        success:function(data) {
	
						jQuery('#enmse-embed-two').html(data);
						jQuery("#enmse-embed-two").show();
						jQuery("#enmse-embed-three").hide();
						jQuery("#enmse-embed-four").hide();
						jQuery("#enmse-embed-code").hide();
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}
		} else if (startvalue == 5) { // Display Series Archives
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedoptions'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-four').html(data);
					jQuery("#enmse-embed-four").show();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		} else if (startvalue == 7) { // Display All Messages
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedoptions'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-four').html(data);
					jQuery("#enmse-embed-four").show();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
	});
	
	jQuery(document).on("change", "#enmse-embed-s", function() { // Specific Series
		var svalue = jQuery(this).val();
		if (svalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedoptions'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-four').html(data);
					jQuery("#enmse-embed-four").show();
					jQuery("#enmse-embed-code").hide();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
	});
	
	jQuery(document).on("change", "#enmse-embed-t", function() { // Specific Topic
		var tvalue = jQuery(this).val();
		if (tvalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedoptions'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-four').html(data);
					jQuery("#enmse-embed-four").show();
					jQuery("#enmse-embed-code").hide();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
	});

	jQuery(document).on("change", "#enmse-embed-b", function() { // Specific Book
		var bvalue = jQuery(this).val();
		if (bvalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedoptions'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-four').html(data);
					jQuery("#enmse-embed-four").show();
					jQuery("#enmse-embed-code").hide();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
	});
	
	jQuery(document).on("change", "#enmse-embed-sp", function() { // Specific Speaker
		var spvalue = jQuery(this).val();
		if (spvalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedoptions'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-four').html(data);
					jQuery("#enmse-embed-four").show();
					jQuery("#enmse-embed-code").hide();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
	});
	
	jQuery(document).on("change", "#enmse-embed-ms", function() { // Specific Message, Choose Series First
		var msvalue = jQuery(this).val();
		if (msvalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedmessage',
		            'enmse_sid': msvalue
		        },
		        success:function(data) {

					jQuery('#enmse-embed-three').html(data);
					jQuery("#enmse-embed-three").show();
					jQuery("#enmse-embed-four").hide();
					jQuery("#enmse-embed-code").hide();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
	});
	
	jQuery(document).on("change", "#enmse-embed-m", function() { // Specific Message
		var mvalue = jQuery(this).val();
		if (mvalue == 0) {
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxembedoptions'
		        },
		        success:function(data) {

					jQuery('#enmse-embed-four').html(data);
					jQuery("#enmse-embed-four").show();
					jQuery("#enmse-embed-code").hide();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });		
		};
	});
	
	jQuery(document).on("change", "#enmse-embed-explorer", function() { // Specific Message
		if ( jQuery(this).val() == 0 ) {
			jQuery("#dropdownoptions").hide();
		} else {
			jQuery("#dropdownoptions").show();
		};
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery(document).on("change", "#enmse-embed-details", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-cardview", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-seriesmenu", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-speakermenu", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-topicmenu", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-bookmenu", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery(document).on("change", "#enmse-embed-related", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery(document).on("change", "#enmse-embed-related-sort", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery(document).on("change", "#enmse-embed-initial", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-pag", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-apag", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-st", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-seriesinfo", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-sharinglinks", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery(document).on("change", "#enmse-embed-download", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});
	

	jQuery(document).on("click", "#enmse-generate-embed-code", function() {
		var startvalue = jQuery('#enmse-embed-start').val();
		var stvalue = jQuery("#enmse-embed-st").val();
		
		if (startvalue == 1) { // Most Recent Message
			var svalue = -1;
			var tvalue = -1;
			var spvalue = -1;
			var mvalue = -1;
			var avalue = -1;
			var amvalue = -1;
			var bvalue = -1;
		} else if (startvalue == 2) { // Specific Series
			var svalue = jQuery("#enmse-embed-s").val();
			var tvalue = -1;
			var spvalue = -1;
			var mvalue = -1;
			var avalue = -1;
			var amvalue = -1;
			var bvalue = -1;
		} else if (startvalue == 3) { // Specific Topic
			var svalue = -1;
			var tvalue = jQuery("#enmse-embed-t").val();
			var spvalue = -1;
			var mvalue = -1;
			var avalue = -1;
			var amvalue = -1;
			var bvalue = -1;
		} else if (startvalue == 4) { // Specific Message
			var svalue = jQuery("#enmse-embed-ms").val();
			var tvalue = -1;
			var spvalue = -1;
			var mvalue = jQuery("#enmse-embed-m").val();
			var avalue = -1;
			var amvalue = -1;
			var bvalue = -1;
		} else if (startvalue == 5) { // Specific Message
			var svalue = -1;
			var tvalue = -1;
			var spvalue = -1;
			var mvalue = -1;
			var avalue = 1;
			var amvalue = -1;
			var bvalue = -1;
		} else if (startvalue == 6) { // Specific Speaker
			var svalue = -1;
			var tvalue = -1;
			var spvalue = jQuery("#enmse-embed-sp").val();
			var mvalue = -1;
			var avalue = -1;
			var amvalue = -1;
			var bvalue = -1;
		} else if (startvalue == 8) { // Specific Book
			var svalue = -1;
			var tvalue = -1;
			var spvalue = -1;
			var mvalue = -1;
			var avalue = -1;
			var amvalue = -1;
			var bvalue =  jQuery("#enmse-embed-b").val();
		} else if (startvalue == 7) { // Display All Messages
			var svalue = -1;
			var tvalue = -1;
			var spvalue = -1;
			var mvalue = -1;
			var avalue = -1;
			var amvalue = 1;
			var bvalue = -1;
		};
		
		var explorervalue = jQuery("#enmse-embed-explorer").val();
		var cardviewvalue = jQuery("#enmse-embed-cardview").val();
		var detailsvalue = jQuery("#enmse-embed-details").val();
		var relatedvalue = jQuery("#enmse-embed-related").val();
		var sortvalue = jQuery("#enmse-embed-related-sort").val();
		var initialvalue = jQuery("#enmse-embed-initial").val();
		var pagvalue = jQuery("#enmse-embed-pag").val();
		var apagvalue = jQuery("#enmse-embed-apag").val();
		if ( jQuery("#enmse-embed-seriesmenu").is(":checked") ) {
			var seriesmenu = 1;
		} else {
			var seriesmenu = 0;
		}
		if ( jQuery("#enmse-embed-speakermenu").is(":checked") ) {
			var speakermenu = 1;
		} else {
			var speakermenu = 0;
		}
		if ( jQuery("#enmse-embed-topicmenu").is(":checked") ) {
			var topicmenu = 1;
		} else {
			var topicmenu = 0;
		}
		if ( jQuery("#enmse-embed-bookmenu").is(":checked") ) {
			var bookmenu = 1;
		} else {
			var bookmenu = 0;
		}
		var sharinglinks = jQuery("#enmse-embed-sharinglinks").val();
		var seriesinfo = jQuery("#enmse-embed-seriesinfo").val();
		var download = jQuery("#enmse-embed-download").val();
		jQuery(this).html("Generate New Code");
		jQuery.ajax({
	        url: seajax.ajaxurl, 
	        data: {
	            'action': 'seriesengine_ajaxembedcode',
	            'enmse_stid': stvalue,
	            'enmse_download': download,
	            'enmse_sharinglinks': sharinglinks,
	            'enmse_seriesinfo': seriesinfo,
	            'enmse_sid': svalue,
	            'enmse_tid': tvalue,
	            'enmse_spid': spvalue,
	            'enmse_mid': mvalue,
	            'enmse_bid': bvalue,
	            'enmse_explorer': explorervalue,
	            'enmse_cardview': cardviewvalue,
	            'enmse_details': detailsvalue,
	            'enmse_related': relatedvalue,
	            'enmse_sort': sortvalue,
	            'enmse_sim': initialvalue,
	            'enmse_a': avalue,
	            'enmse_am': amvalue,
	            'enmse_pag': pagvalue,
	            'enmse_apag': apagvalue,
	            'enmse_seriesmenu': seriesmenu,
	            'enmse_speakermenu': speakermenu,
	            'enmse_topicmenu': topicmenu,
	            'enmse_bookmenu': bookmenu
	        },
	        success:function(data) {
				jQuery('#enmse-embed-code').html(data);
				jQuery("#enmse-embed-code").show();
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});
	
	// Simple/Advanced Tabs
	jQuery('#enmse-simple-embed').click(function() {
		jQuery('#enmse-simple-embed').parent().addClass('selected');
		jQuery('#enmse-custom-embed').parent().removeClass('selected');
		jQuery("#enmse-custom").hide();
		jQuery("#enmse-simple").show();	
		return false;			
	});
	
	jQuery('#enmse-custom-embed').click(function() { 
		jQuery('#enmse-simple-embed').parent().removeClass('selected');
		jQuery('#enmse-custom-embed').parent().addClass('selected');
		jQuery("#enmse-custom").show();
		jQuery("#enmse-simple").hide();	
		return false;			
	});
});