jQuery(document).ready(function(){ /* ----- Series Engine - Generate Custom Embed Code ----- */
	
	jQuery('#enmse-embed-start').change(function() { // Choose a starting point
		var startvalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
		if (startvalue > 0) {
			jQuery('#enmse-embed-one').load(pluginurl+"embed_seriestypes.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-one").show();
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			});
		} else {
			jQuery("#enmse-embed-one").hide();
			jQuery("#enmse-embed-two").hide();
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		};
	});
	
	jQuery('#enmse-embed-st').live("change", function() { // Next after choosing Series Type
		var startvalue = jQuery('#enmse-embed-start').val();
		var stvalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
		if (startvalue == 0) {
			alert("Please choose an option in Step 1!");
		} else if (startvalue == 1) { // Most Recent Message
			jQuery('#enmse-embed-four').load(pluginurl+"embed_options.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-four").show();
				jQuery("#enmse-embed-code").hide();
			});
		} else if (startvalue == 2) { // Specific Series
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery('#enmse-embed-two').load(pluginurl+"embed_series.php?enmse_stid="+stvalue+"&enmse_random="+serandom, function() {
					jQuery("#enmse-embed-two").show();
					jQuery("#enmse-embed-three").hide();
					jQuery("#enmse-embed-four").hide();
					jQuery("#enmse-embed-code").hide();
				});
			}
		} else if (startvalue == 3) { // Specific Topic
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery('#enmse-embed-two').load(pluginurl+"embed_topic.php?enmse_stid="+stvalue+"&enmse_random="+serandom, function() {
					jQuery("#enmse-embed-two").show();
					jQuery("#enmse-embed-three").hide();
					jQuery("#enmse-embed-four").hide();
					jQuery("#enmse-embed-code").hide();
				});
			}
		} else if (startvalue == 6) { // Specific Topic
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery('#enmse-embed-two').load(pluginurl+"embed_speaker.php?enmse_stid="+stvalue+"&enmse_random="+serandom, function() {
					jQuery("#enmse-embed-two").show();
					jQuery("#enmse-embed-three").hide();
					jQuery("#enmse-embed-four").hide();
					jQuery("#enmse-embed-code").hide();
				});
			}
		} else if (startvalue == 8) { // Specific Book
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery('#enmse-embed-two').load(pluginurl+"embed_book.php?enmse_stid="+stvalue+"&enmse_random="+serandom, function() {
					jQuery("#enmse-embed-two").show();
					jQuery("#enmse-embed-three").hide();
					jQuery("#enmse-embed-four").hide();
					jQuery("#enmse-embed-code").hide();
				});
			}
		} else if (startvalue == 4) { // Specific Message
			if (stvalue < 0) {
				jQuery("#enmse-embed-two").hide();
				jQuery("#enmse-embed-three").hide();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			} else {
				jQuery('#enmse-embed-two').load(pluginurl+"embed_series.php?enmse_stid="+stvalue+"&enmse_message=1"+"&enmse_random="+serandom, function() {
					jQuery("#enmse-embed-two").show();
					jQuery("#enmse-embed-three").hide();
					jQuery("#enmse-embed-four").hide();
					jQuery("#enmse-embed-code").hide();
				});
			}
		} else if (startvalue == 5) { // Display Series Archives
			jQuery('#enmse-embed-four').load(pluginurl+"embed_options.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-four").show();
			});
		} else if (startvalue == 7) { // Display All Messages
			jQuery('#enmse-embed-four').load(pluginurl+"embed_options.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-four").show();
			});
		};
	});
	
	jQuery('#enmse-embed-s').live("change", function() { // Specific Series
		var svalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
		if (svalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery('#enmse-embed-four').load(pluginurl+"embed_options.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-four").show();
				jQuery("#enmse-embed-code").hide();
			});
			
		};
	});
	
	jQuery('#enmse-embed-t').live("change", function() { // Specific Topic
		var tvalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
		if (tvalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery('#enmse-embed-four').load(pluginurl+"embed_options.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-four").show();
				jQuery("#enmse-embed-code").hide();
			});
		};
	});

		jQuery('#enmse-embed-b').live("change", function() { // Specific Book
		var bvalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
		if (bvalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery('#enmse-embed-four').load(pluginurl+"embed_options.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-four").show();
				jQuery("#enmse-embed-code").hide();
			});
		};
	});
	
	jQuery('#enmse-embed-sp').live("change", function() { // Specific Speaker
		var spvalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
		if (spvalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery('#enmse-embed-four').load(pluginurl+"embed_options.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-four").show();
				jQuery("#enmse-embed-code").hide();
			});
		};
	});
	
	jQuery('#enmse-embed-ms').live("change", function() { // Specific Message, Choose Series First
		var msvalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
		if (msvalue == 0) {
			jQuery("#enmse-embed-three").hide();
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery('#enmse-embed-three').load(pluginurl+"embed_message.php?enmse_sid="+msvalue+"&enmse_random="+serandom, function() {
				jQuery("#enmse-embed-three").show();
				jQuery("#enmse-embed-four").hide();
				jQuery("#enmse-embed-code").hide();
			});
		};
	});
	
	jQuery('#enmse-embed-m').live("change", function() { // Specific Message
		var mvalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
		if (mvalue == 0) {
			jQuery("#enmse-embed-four").hide();
			jQuery("#enmse-embed-code").hide();
		} else {
			jQuery('#enmse-embed-four').load(pluginurl+"embed_options.php"+"?enmse_random="+serandom, function() {
				jQuery("#enmse-embed-four").show();
				jQuery("#enmse-embed-code").hide();
			});			
		};
	});
	
	jQuery('#enmse-embed-explorer').live("change", function() { // Specific Message
		if ( jQuery(this).val() == 0 ) {
			jQuery("#dropdownoptions").hide();
		} else {
			jQuery("#dropdownoptions").show();
		};
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery('#enmse-embed-details').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-cardview').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-seriesmenu').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-speakermenu').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-topicmenu').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-bookmenu').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery('#enmse-embed-related').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery('#enmse-embed-related-sort').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery('#enmse-embed-initial').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-pag').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-apag').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-st').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-seriesinfo').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-sharinglinks').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});

	jQuery('#enmse-embed-download').live("change", function() { // Specific Message
		jQuery("#enmse-embed-code").hide();
	});
	
	jQuery("#enmse-generate-embed-code").live("click", function() {
		var startvalue = jQuery('#enmse-embed-start').val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var serandom = Math.floor(Math.random()*1001);
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
		jQuery('#enmse-embed-code').load(pluginurl+"embed_generate_code.php?enmse_stid="+stvalue+"&enmse_download="+download+"&enmse_sharinglinks="+sharinglinks+"&enmse_seriesinfo="+seriesinfo+"&enmse_sid="+svalue+"&enmse_tid="+tvalue+"&enmse_spid="+spvalue+"&enmse_mid="+mvalue+"&enmse_bid="+bvalue+"&enmse_explorer="+explorervalue+"&enmse_cardview="+cardviewvalue+"&enmse_details="+detailsvalue+"&enmse_related="+relatedvalue+"&enmse_sort="+sortvalue+"&enmse_sim="+initialvalue+"&enmse_a="+avalue+"&enmse_am="+amvalue+"&enmse_pag="+pagvalue+"&enmse_apag="+apagvalue+"&enmse_seriesmenu="+seriesmenu+"&enmse_speakermenu="+speakermenu+"&enmse_topicmenu="+topicmenu+"&enmse_bookmenu="+bookmenu+"&enmse_random="+serandom, function() {
			jQuery("#enmse-embed-code").show();
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