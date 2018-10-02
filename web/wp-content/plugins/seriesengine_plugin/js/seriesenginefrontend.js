jQuery(document).ready(function() { /* ----- Series Engine ----- */
var enmsevercheck = parseFloat(jQuery().jquery);
if (enmsevercheck < 1.7 && enmsevercheck > 1.3) { //IF USING JQUERY OLDER THAN 1.7
	jQuery('.enmse_series').live("change", function() {
		var ajaxvalues = jQuery(this).val();
		if (ajaxvalues != 0) {
			var loadurl = jQuery(this).parent().siblings(".enmse-plugin-url").val();
			var embedoptions = jQuery(this).parent().siblings(".enmse-embed-options").val();
			var permalinkurl = jQuery(this).parent().siblings(".enmse-permalink").val();
			var serandom = Math.floor(Math.random()*1001);
			if (loadurl==null) {
				var loadurl = jQuery(this).parent().siblings().children(".enmse-plugin-url").val();
				var embedoptions = jQuery(this).parent().siblings().children(".enmse-embed-options").val();
				var permalinkurl = jQuery(this).parent().siblings().children(".enmse-permalink").val();
			};
			var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
			jQuery(this).ajaxSend(function(){
				jQuery(this).parent().parent().addClass("enmse-opaque");
				jQuery(this).parent().parent().siblings(".enmse-loading-icon").show();
			});
			jQuery(this).ajaxSuccess(function(){
				jQuery(this).parent().parent().removeClass("enmse-opaque");
				jQuery(this).parent().parent().siblings(".enmse-loading-icon").hide();
				jQuery(this).unbind("ajaxSend");
			});
			jQuery(this).parent().parent().load(loadthis);
		}
		return false;
	});
	jQuery(".enmse_topics").live("change", function() {
		var ajaxvalues = jQuery(this).val();
		if (ajaxvalues != 0) {
			var loadurl = jQuery(this).parent().siblings(".enmse-plugin-url").val();
			var embedoptions = jQuery(this).parent().siblings(".enmse-embed-options").val();
			var permalinkurl = jQuery(this).parent().siblings(".enmse-permalink").val();
			var serandom = Math.floor(Math.random()*1001);
			if (loadurl==null) {
					var loadurl = jQuery(this).parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().siblings().children(".enmse-permalink").val();
				};	
			var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
			jQuery(this).ajaxSend(function(){
				jQuery(this).parent().parent().addClass("enmse-opaque");
				jQuery(this).parent().parent().siblings(".enmse-loading-icon").show();
			});
			jQuery(this).ajaxSuccess(function(){
				jQuery(this).parent().parent().removeClass("enmse-opaque");
				jQuery(this).parent().parent().siblings(".enmse-loading-icon").hide();
				jQuery(this).unbind("ajaxSend");
			});
			jQuery(this).parent().parent().load(loadthis);
		};
		return false;
	});
	jQuery(".enmse_speakers").live("change", function() {
		var ajaxvalues = jQuery(this).val();
		if (ajaxvalues != 0) {
			var loadurl = jQuery(this).parent().siblings(".enmse-plugin-url").val();
			var embedoptions = jQuery(this).parent().siblings(".enmse-embed-options").val();
			var permalinkurl = jQuery(this).parent().siblings(".enmse-permalink").val();
			var serandom = Math.floor(Math.random()*1001);
			if (loadurl==null) {
					var loadurl = jQuery(this).parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().siblings().children(".enmse-permalink").val();
				};	
			var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
			jQuery(this).ajaxSend(function(){
				jQuery(this).parent().parent().addClass("enmse-opaque");
				jQuery(this).parent().parent().siblings(".enmse-loading-icon").show();
			});
			jQuery(this).ajaxSuccess(function(){
				jQuery(this).parent().parent().removeClass("enmse-opaque");
				jQuery(this).parent().parent().siblings(".enmse-loading-icon").hide();
				jQuery(this).unbind("ajaxSend");
			});
			jQuery(this).parent().parent().load(loadthis);
		};
		return false;
	});
	jQuery(".enmse_books").live("change", function() {
		var ajaxvalues = jQuery(this).val();
		if (ajaxvalues != 0) {
			var loadurl = jQuery(this).parent().siblings(".enmse-plugin-url").val();
			var embedoptions = jQuery(this).parent().siblings(".enmse-embed-options").val();
			var permalinkurl = jQuery(this).parent().siblings(".enmse-permalink").val();
			var serandom = Math.floor(Math.random()*1001);
			if (loadurl==null) {
					var loadurl = jQuery(this).parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().siblings().children(".enmse-permalink").val();
				};	
			var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
			jQuery(document).ajaxSend(function(){
				jQuery(this).parent().parent().addClass("enmse-opaque");
				jQuery(this).parent().parent().siblings(".enmse-loading-icon").show();
			});
			function completeload(){
				jQuery(this).parent().parent().removeClass("enmse-opaque");
				jQuery(this).parent().parent().siblings(".enmse-loading-icon").hide();
				jQuery(this).unbind("ajaxSend");
			};
			jQuery(this).parent().parent().load(loadthis, completeload);
		};
		return false;
	});
	
	// Show/Hide Details and Sharing
	jQuery('a.enmse-hide-details').live("click", function(){
		jQuery(this).parent().parent().siblings('.enmse-player-details').slideUp(200);
		jQuery(this).removeClass('enmse-hide-details');
		jQuery(this).addClass('enmse-show-details');
		return false;
	});
	jQuery('a.enmse-show-details').live("click", function(){
		var getthis = jQuery(this);
		jQuery(this).parent().parent().siblings('.enmse-share-details').slideUp(200, function() {
			jQuery(getthis).parent().parent().siblings('.enmse-player-extras').slideUp(200, function() {
				jQuery(getthis).parent().parent().siblings('.enmse-player-details').slideDown(200);
			});
		});
		jQuery(this).parent().siblings('.enmse-share-this').children('a').removeClass('enmse-hide-share')
		jQuery(this).parent().siblings('.enmse-share-this').children('a').addClass('enmse-show-share');
		jQuery(this).parent().siblings('.enmse-extras').children('a').removeClass('enmse-hide-extras');
		jQuery(this).parent().siblings('.enmse-extras').children('a').addClass('enmse-show-extras');
		jQuery(this).removeClass('enmse-show-details');
		jQuery(this).addClass('enmse-hide-details');
		return false;
	});
	jQuery('a.enmse-hide-share').live("click", function(){
		jQuery(this).parent().parent().siblings('.enmse-share-details').slideUp(200);
		jQuery(this).removeClass('enmse-hide-share');
		jQuery(this).addClass('enmse-show-share');
		return false;
	});
	jQuery('a.enmse-show-share').live("click", function(){
		var getthis = jQuery(this);
		jQuery(this).parent().parent().siblings('.enmse-player-details').slideUp(200, function() {
			jQuery(getthis).parent().parent().siblings('.enmse-player-extras').slideUp(200, function() {
				jQuery(getthis).parent().parent().siblings('.enmse-share-details').slideDown(200);
			});
		});
		jQuery(this).parent().siblings('.enmse-details').children('a').removeClass('enmse-hide-details');
		jQuery(this).parent().siblings('.enmse-details').children('a').addClass('enmse-show-details');
		jQuery(this).parent().siblings('.enmse-extras').children('a').removeClass('enmse-hide-extras');
		jQuery(this).parent().siblings('.enmse-extras').children('a').addClass('enmse-show-extras');
		jQuery(this).removeClass('enmse-show-share');
		jQuery(this).addClass('enmse-hide-share');
		return false;
	});
	jQuery('a.enmse-hide-extras').live("click", function(){
		jQuery(this).parent().parent().siblings('.enmse-player-extras').slideUp(200);
		jQuery(this).removeClass('enmse-hide-extras');
		jQuery(this).addClass('enmse-show-extras');
		return false;
	});
	jQuery('a.enmse-show-extras').live("click", function(){
		var getthis = jQuery(this);
		jQuery(this).parent().parent().siblings('.enmse-player-details').slideUp(200, function() {
			jQuery(getthis).parent().parent().siblings('.enmse-share-details').slideUp(200, function() {
				jQuery(getthis).parent().parent().siblings('.enmse-player-extras').slideDown(200);
			});
		});
		jQuery(this).parent().siblings('.enmse-details').children('a').removeClass('enmse-hide-details');
		jQuery(this).parent().siblings('.enmse-details').children('a').addClass('enmse-show-details');
		jQuery(this).parent().siblings('.enmse-share-this').children('a').removeClass('enmse-hide-share');
		jQuery(this).parent().siblings('.enmse-share-this').children('a').addClass('enmse-show-share');
		jQuery(this).removeClass('enmse-show-extras');
		jQuery(this).addClass('enmse-hide-extras');
		return false;
	});
	
	//Show and Hide Tabs
	jQuery(".enmse-watch-tab a").live("click", function() {
		jQuery(this).parent().siblings('.enmse-listen-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().siblings('.enmse-alternate-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().addClass('enmse-tab-selected');
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-watch").show();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-listen").hide();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-alternate").hide();
		return false;
	});
	
	jQuery(".enmse-listen-tab a").live("click", function() {
		jQuery(this).parent().siblings('.enmse-watch-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().siblings('.enmse-alternate-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().addClass('enmse-tab-selected');
		jQuery('.enmse-listen .mejs-horizontal-volume-slider').show();
		jQuery('.enmse-listen .mejs-time-loaded').css('display', 'block');
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-watch").hide();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-listen").show();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-alternate").hide();
		return false;
	});
	
	jQuery(".enmse-alternate-tab a").live("click", function() {
		jQuery(this).parent().siblings('.enmse-watch-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().siblings('.enmse-listen-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().addClass('enmse-tab-selected');
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-watch").hide();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-listen").hide();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-alternate").show();
		return false;
	});
	
	//Ajax loading of more SE content
	
	jQuery("a.enmse-series-ajax").live("click", function() {
		var getthis = jQuery(this);
		var ajaxvalues = jQuery(this).children('.enmse-series-info').val();
		var loadurl = jQuery(this).parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(this).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		jQuery(this).ajaxSuccess(function(){
			jQuery(getthis).parent().parent().parent().parent().removeClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
		});
		jQuery(this).parent().parent().parent().parent().load(loadthis);
		return false;
	});
	
	jQuery("a.enmse-topic-ajax").live("click", function() {
		var getthis = jQuery(this);
		var ajaxvalues = jQuery(this).children('.enmse-topic-info').val();
		var loadurl = jQuery(this).parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(this).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		jQuery(this).ajaxSuccess(function(){
			jQuery(getthis).parent().parent().parent().parent().removeClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
		});
		jQuery(this).parent().parent().parent().parent().load(loadthis);
		return false;
	});
	
	jQuery("a.enmse-speaker-ajax").live("click", function() {
		var getthis = jQuery(this);
		var ajaxvalues = jQuery(this).children('.enmse-speaker-info').val();
		var loadurl = jQuery(this).parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(this).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		jQuery(this).ajaxSuccess(function(){
			jQuery(getthis).parent().parent().parent().parent().removeClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
		});
		jQuery(this).parent().parent().parent().parent().load(loadthis);
		return false;
	});
	
	
	
	jQuery("a.enmse-ajax-link").live("click", function() {
		var getthis = jQuery(this);
		var ajaxvalues = jQuery(this).siblings(".enmse-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(this).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		jQuery(this).ajaxSuccess(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().removeClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
		});
		jQuery(this).parent().parent().parent().parent().parent().load(loadthis);
		return false;
	});
	
	//Share Link Button
	jQuery(".enmse-share-link a").live("click", function() {
		var userAgent = navigator.userAgent || navigator.vendor || window.opera;
		var findheight = jQuery(this).position();
		var correctheight = findheight.top-30;
		var thislink = jQuery(this).attr("href");
		if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) {
			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").css("top",correctheight+"px");
			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").children("p:first").html("Copy <a href=\""+thislink+"\" target=\"_blank\">this link</a> to share it any way you like.");
			jQuery(this).parent().parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").show();
  		} else {
  			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").css("top",correctheight+"px");
			jQuery(this).parent().parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").show();
			var temp = jQuery("<input>");
			jQuery(this).append(temp);
			temp.val(thislink).select();
			document.execCommand("copy");
			temp.remove();
  		}
		return false;
	});
	
	jQuery(".enmse-copy-link-box a.enmse-copy-link-done").live("click", function() {
		var getparent = jQuery(this).parent();
		var parentname = getparent[0].tagName;
		if (parentname=="P") {
			jQuery(this).parent().parent().siblings(".enmse-content-container").removeClass("enmse-opaque");
			jQuery(this).parent().parent().hide();
		} else {
			jQuery(this).parent().siblings(".enmse-content-container").removeClass("enmse-opaque");
			jQuery(this).parent().hide();
		};
		return false;
	});
	
	//Series Archives Link
	jQuery("a.enmse-archive-ajax").live("click", function() {
		var getthis = jQuery(this);
		var ajaxvalues = jQuery(this).attr("title");
		var loadurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);	
		if (loadurl==null) {
				var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-plugin-url").val();
				var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-embed-options").val();
				var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-permalink").val();
			};	
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(this).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		jQuery(this).ajaxSuccess(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().removeClass("enmse-opaque");
			jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
		});
		jQuery(this).parent().parent().parent().parent().parent().load(loadthis);
		return false;
	});

	// Pagination links
	jQuery("a.enmse-ajax-page").live("click", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).attr("name");

		var loadurl = jQuery(this).parent().parent().siblings(".enmse-plugin-url").val();

		var embedoptions = jQuery(this).parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/display/pagination/newrelated.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().addClass("enmse-opaque");
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().load(loadthis, completeload);
		return false;
	});

	// Series Archives Pagination links
	jQuery("a.enmse-ajax-apage").live("click", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).attr("name");

		var loadurl = jQuery(this).parent().parent().siblings(".enmse-plugin-url").val();

		var embedoptions = jQuery(this).parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/display/pagination/newarchives.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().addClass("enmse-opaque");
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().load(loadthis, completeload);
		return false;
	});
	
	
	jQuery('#seriesengine audio').mediaelementplayer({stretching: 'responsive'});
	jQuery('#seriesengine video').mediaelementplayer({stretching: 'responsive'});


	jQuery("#seriesengine audio.enmseaplayer").bind("play", function(){
		var loadurl = jQuery(".enmse-plugin-url").val();
		var begcurrent = jQuery(this).attr("rel");
		if ( begcurrent == "" ) {
			begcurrent = 0;
		};
		var current = parseInt(begcurrent);
		var m = jQuery(this).attr("name");
		var newcount = current+1;
		var mtype = "audio";
		var posturl = loadurl+"/includes/viewcount.php";
		jQuery.post(posturl, { count: newcount, id: m, type: mtype });
		jQuery(this).unbind();
	});

	jQuery("#seriesengine video.enmsevplayer").bind("play", function(){
		var loadurl = jQuery(".enmse-plugin-url").val();
		var begcurrent = jQuery(this).attr("rel");
		if ( begcurrent == "" ) {
			begcurrent = 0;
		};
		var current = parseInt(begcurrent);
		var m = jQuery(this).attr("name");
		var newcount = current+1;
		var mtype = "video";
		var posturl = loadurl+"/includes/viewcount.php";
		jQuery.post(posturl, { count: newcount, id: m, type: mtype });
		jQuery(this).unbind();
	});

	jQuery("#seriesengine video.enmseaplayer").bind("play", function(){
		var loadurl = jQuery(".enmse-plugin-url").val();
		var begcurrent = jQuery(this).attr("rel");
		if ( begcurrent == "" ) {
			begcurrent = 0;
		};
		var current = parseInt(begcurrent);
		var m = jQuery(this).attr("name");
		var newcount = current+1;
		var mtype = "alternate";
		var posturl = loadurl+"/includes/viewcount.php";
		jQuery.post(posturl, { count: newcount, id: m, type: mtype });
		jQuery(this).unbind();
	});

/*    */} else { // IF GREATER THAN 1.7

	function sescroll(bla){
	    var tag = jQuery("#enmse-top"+bla);
	    if (navigator.userAgent.indexOf("Chrome") != -1 ) {
	    	jQuery("html").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("html").clearQueue();
		    });
	    } else {
	    	jQuery("body").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("body").clearQueue();
		    });
	    };
	}

	function serscroll(bla){
	    var tag = jQuery("#enmse-related"+bla);
	    if (navigator.userAgent.indexOf("Chrome") != -1 ) {
	    	jQuery("html").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("html").clearQueue();
		    });
	    } else {
	    	jQuery("body").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("body").clearQueue();
		    });
	    }
	}

	function copyToClipboard(element) {
		var temp = jQuery("<input>");
		jQuery("body").append(temp);
		temp.val(jQuery(element).text()).select();
		document.execCommand("copy");
		temp.remove();
	}

	jQuery(document).on("change", ".enmse_series", function() {
		var ajaxvalues = jQuery(this).val();
		var ajaxitem = jQuery(this);
		var randval = jQuery(this).parent().parent().siblings(".enmse-random").val();
		if (ajaxvalues != 0) {
			var loadurl = jQuery(this).parent().siblings(".enmse-plugin-url").val();
			var embedoptions = jQuery(this).parent().siblings(".enmse-embed-options").val();
			var permalinkurl = jQuery(this).parent().siblings(".enmse-permalink").val();
			var serandom = Math.floor(Math.random()*1001);
			if (loadurl==null) {
				var loadurl = jQuery(this).parent().siblings().children(".enmse-plugin-url").val();
				var embedoptions = jQuery(this).parent().siblings().children(".enmse-embed-options").val();
				var permalinkurl = jQuery(this).parent().siblings().children(".enmse-permalink").val();
			};
			var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
			jQuery(document).ajaxSend(function(){
				jQuery(ajaxitem).parent().parent().addClass("enmse-opaque");
				sescroll(randval);
				jQuery(ajaxitem).parent().parent().siblings(".enmse-loading-icon").show();
			});
			function completeload(){
				jQuery(this).removeClass("enmse-opaque");
				jQuery(this).siblings(".enmse-loading-icon").hide();
				jQuery(this).unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
				jQuery(this).off();
			};
			jQuery(this).parent().parent().load(loadthis, completeload);
		}
		return false;
	});
	jQuery(document).on("change", ".enmse_topics", function() {
		var ajaxvalues = jQuery(this).val();
		var randval = jQuery(this).parent().parent().siblings(".enmse-random").val();
		var ajaxitem = jQuery(this);
		if (ajaxvalues != 0) {
			var loadurl = jQuery(this).parent().siblings(".enmse-plugin-url").val();
			var embedoptions = jQuery(this).parent().siblings(".enmse-embed-options").val();
			var permalinkurl = jQuery(this).parent().siblings(".enmse-permalink").val();
			var serandom = Math.floor(Math.random()*1001);
			if (loadurl==null) {
					var loadurl = jQuery(this).parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().siblings().children(".enmse-permalink").val();
				};	
			var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
			jQuery(document).ajaxSend(function(){
				jQuery(ajaxitem).parent().parent().addClass("enmse-opaque");
				sescroll(randval);
				jQuery(ajaxitem).parent().parent().siblings(".enmse-loading-icon").show();
			});
			function completeload(){
				jQuery(this).removeClass("enmse-opaque");
				jQuery(this).siblings(".enmse-loading-icon").hide();
				jQuery(this).unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
				jQuery(this).off();
			};
			jQuery(this).parent().parent().load(loadthis, completeload);
		};
		return false;
	});
	jQuery(document).on("change", ".enmse_speakers", function() {
		var ajaxvalues = jQuery(this).val();
		var randval = jQuery(this).parent().parent().siblings(".enmse-random").val();
		var ajaxitem = jQuery(this);
		if (ajaxvalues != 0) {
			var loadurl = jQuery(this).parent().siblings(".enmse-plugin-url").val();
			var embedoptions = jQuery(this).parent().siblings(".enmse-embed-options").val();
			var permalinkurl = jQuery(this).parent().siblings(".enmse-permalink").val();
			var serandom = Math.floor(Math.random()*1001);
			if (loadurl==null) {
					var loadurl = jQuery(this).parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().siblings().children(".enmse-permalink").val();
				};	
			var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
			jQuery(document).ajaxSend(function(){
				jQuery(ajaxitem).parent().parent().addClass("enmse-opaque");
				sescroll(randval);
				jQuery(ajaxitem).parent().parent().siblings(".enmse-loading-icon").show();
			});
			function completeload(){
				jQuery(this).removeClass("enmse-opaque");
				jQuery(this).siblings(".enmse-loading-icon").hide();
				jQuery(this).unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
				jQuery(this).off();
			};
			jQuery(this).parent().parent().load(loadthis, completeload);
		};
		return false;
	});
	jQuery(document).on("change", ".enmse_books", function() {
		var ajaxvalues = jQuery(this).val();
		var randval = jQuery(this).parent().parent().siblings(".enmse-random").val();
		var ajaxitem = jQuery(this);
		if (ajaxvalues != 0) {
			var loadurl = jQuery(this).parent().siblings(".enmse-plugin-url").val();
			var embedoptions = jQuery(this).parent().siblings(".enmse-embed-options").val();
			var permalinkurl = jQuery(this).parent().siblings(".enmse-permalink").val();
			var serandom = Math.floor(Math.random()*1001);
			if (loadurl==null) {
					var loadurl = jQuery(this).parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().siblings().children(".enmse-permalink").val();
				};	
			var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
			jQuery(document).ajaxSend(function(){
				jQuery(ajaxitem).parent().parent().addClass("enmse-opaque");
				sescroll(randval);
				jQuery(ajaxitem).parent().parent().siblings(".enmse-loading-icon").show();
			});
			function completeload(){
				jQuery(this).removeClass("enmse-opaque");
				jQuery(this).siblings(".enmse-loading-icon").hide();
				jQuery(this).unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
				jQuery(this).off();
			};
			jQuery(this).parent().parent().load(loadthis, completeload);
		};
		return false;
	});
	
	// Show/Hide Details and Sharing
	jQuery(document).on("click", "a.enmse-hide-details", function() {
		jQuery(this).parent().parent().siblings('.enmse-player-details').slideUp(200);
		jQuery(this).removeClass('enmse-hide-details');
		jQuery(this).addClass('enmse-show-details');
		return false;
	});
	jQuery(document).on("click", "a.enmse-show-details", function() {
		var getthis = jQuery(this);
		jQuery(this).parent().parent().siblings('.enmse-share-details').slideUp(200, function() {
			jQuery(getthis).parent().parent().siblings('.enmse-player-extras').slideUp(200, function() {
				jQuery(getthis).parent().parent().siblings('.enmse-player-details').slideDown(200);
			});
		});
		jQuery(this).parent().siblings('.enmse-share-this').children('a').removeClass('enmse-hide-share')
		jQuery(this).parent().siblings('.enmse-share-this').children('a').addClass('enmse-show-share');
		jQuery(this).parent().siblings('.enmse-extras').children('a').removeClass('enmse-hide-extras');
		jQuery(this).parent().siblings('.enmse-extras').children('a').addClass('enmse-show-extras');
		jQuery(this).removeClass('enmse-show-details');
		jQuery(this).addClass('enmse-hide-details');
		return false;
	});
	jQuery(document).on("click", "a.enmse-hide-share", function() {
		jQuery(this).parent().parent().siblings('.enmse-share-details').slideUp(200);
		jQuery(this).removeClass('enmse-hide-share');
		jQuery(this).addClass('enmse-show-share');
		return false;
	});
	jQuery(document).on("click", "a.enmse-show-share", function() {
		var getthis = jQuery(this);
		jQuery(this).parent().parent().siblings('.enmse-player-details').slideUp(200, function() {
			jQuery(getthis).parent().parent().siblings('.enmse-player-extras').slideUp(200, function() {
				jQuery(getthis).parent().parent().siblings('.enmse-share-details').slideDown(200);
			});
		});
		jQuery(this).parent().siblings('.enmse-details').children('a').removeClass('enmse-hide-details');
		jQuery(this).parent().siblings('.enmse-details').children('a').addClass('enmse-show-details');
		jQuery(this).parent().siblings('.enmse-extras').children('a').removeClass('enmse-hide-extras');
		jQuery(this).parent().siblings('.enmse-extras').children('a').addClass('enmse-show-extras');
		jQuery(this).removeClass('enmse-show-share');
		jQuery(this).addClass('enmse-hide-share');
		return false;
	});
	jQuery(document).on("click", "a.enmse-hide-extras", function() {
		jQuery(this).parent().parent().siblings('.enmse-player-extras').slideUp(200);
		jQuery(this).removeClass('enmse-hide-extras');
		jQuery(this).addClass('enmse-show-extras');
		return false;
	});
	jQuery(document).on("click", "a.enmse-show-extras", function() {
		var getthis = jQuery(this);
		jQuery(this).parent().parent().siblings('.enmse-player-details').slideUp(200, function() {
			jQuery(getthis).parent().parent().siblings('.enmse-share-details').slideUp(200, function() {
				jQuery(getthis).parent().parent().siblings('.enmse-player-extras').slideDown(200);
			});
		});
		jQuery(this).parent().siblings('.enmse-details').children('a').removeClass('enmse-hide-details');
		jQuery(this).parent().siblings('.enmse-details').children('a').addClass('enmse-show-details');
		jQuery(this).parent().siblings('.enmse-share-this').children('a').removeClass('enmse-hide-share');
		jQuery(this).parent().siblings('.enmse-share-this').children('a').addClass('enmse-show-share');
		jQuery(this).removeClass('enmse-show-extras');
		jQuery(this).addClass('enmse-hide-extras');
		return false;
	});
	
	//Show and Hide Tabs
	jQuery(document).on("click", ".enmse-watch-tab a", function() {
		jQuery(this).parent().siblings('.enmse-listen-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().siblings('.enmse-alternate-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().addClass('enmse-tab-selected');
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-watch").show();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-listen").hide();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-alternate").hide();
		return false;
	});
	
	jQuery(document).on("click", ".enmse-listen-tab a", function() {
		jQuery(this).parent().siblings('.enmse-watch-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().siblings('.enmse-alternate-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().addClass('enmse-tab-selected');
		jQuery('.enmse-listen .mejs-horizontal-volume-slider').show();
		jQuery('.enmse-listen .mejs-time-loaded').css('display', 'block');
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-watch").hide();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-listen").show();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-alternate").hide();
		return false;
	});
	
	jQuery(document).on("click", ".enmse-alternate-tab a", function() {
		jQuery(this).parent().siblings('.enmse-watch-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().siblings('.enmse-listen-tab').removeClass('enmse-tab-selected');
		jQuery(this).parent().addClass('enmse-tab-selected');
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-watch").hide();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-listen").hide();
		jQuery(this).parent().parent().siblings(".enmse-media-container").children(".enmse-alternate").show();
		return false;
	});
	
	//Ajax loading of more SE content
	
	jQuery(document).on("click", "a.enmse-series-ajax", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).children('.enmse-series-info').val();
		var loadurl = jQuery(this).parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});
	
	jQuery(document).on("click", "a.enmse-topic-ajax", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).children('.enmse-topic-info').val();
		var loadurl = jQuery(this).parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});
	
	jQuery(document).on("click", "a.enmse-speaker-ajax", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).children('.enmse-speaker-info').val();
		var loadurl = jQuery(this).parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});
	
	
	jQuery(document).on("click", "a.enmse-ajax-link", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).siblings(".enmse-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmse-ajax-card-link", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).siblings(".enmse-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmse-ajax-row-link", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).siblings(".enmse-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});
	
	//Share Link Button
	jQuery(document).on("click", ".enmse-share-link a", function() {
		var userAgent = navigator.userAgent || navigator.vendor || window.opera;
		var findheight = jQuery(this).position();
		var correctheight = findheight.top-30;
		var thislink = jQuery(this).attr("href");
		if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) {
			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").css("top",correctheight+"px");
			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").children("p:first").html("Copy <a href=\""+thislink+"\" target=\"_blank\">this link</a> to share it any way you like.");
			jQuery(this).parent().parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").show();
  		} else {
  			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").css("top",correctheight+"px");
			jQuery(this).parent().parent().parent().parent().parent().addClass("enmse-opaque");
			jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-copy-link-box").show();
			var temp = jQuery("<input>");
			jQuery(this).append(temp);
			temp.val(thislink).select();
			document.execCommand("copy");
			temp.remove();
  		}
		return false;
	});
	
	jQuery(document).on("click", ".enmse-copy-link-box a.enmse-copy-link-done", function() {
		var getparent = jQuery(this).parent();
		var parentname = getparent[0].tagName;
		if (parentname=="P") {
			jQuery(this).parent().parent().siblings(".enmse-content-container").removeClass("enmse-opaque");
			jQuery(this).parent().parent().hide();
		} else {
			jQuery(this).parent().siblings(".enmse-content-container").removeClass("enmse-opaque");
			jQuery(this).parent().hide();
		};
		return false;
	});
	
	//Series Archives Link
	jQuery(document).on("click", "a.enmse-archive-ajax", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).attr("title");
		var loadurl = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);	
		if (loadurl==null) {
				var loadurl = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-plugin-url").val();
				var embedoptions = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-embed-options").val();
				var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().siblings().children(".enmse-permalink").val();
			};	
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	//Series Image Archives Link
	jQuery(document).on("click", "a.enmse-imgarchive-ajax", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).attr("title");
		var loadurl = jQuery(this).parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);	
		if (loadurl==null) {
				var loadurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-plugin-url").val();
				var embedoptions = jQuery(this).parent().parent().parent().siblings().children(".enmse-embed-options").val();
				var permalinkurl = jQuery(this).parent().parent().parent().siblings().children(".enmse-permalink").val();
			};	
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});

//Series Image Archives Link
	jQuery(document).on("click", "a.enmse-imgarchivetext-ajax", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).attr("title");
		var loadurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-plugin-url").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);	
		if (loadurl==null) {
				var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-plugin-url").val();
				var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-embed-options").val();
				var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-permalink").val();
			};	
		var loadthis = loadurl+"/includes/ajaxlinks.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	// Pagination links
	jQuery(document).on("click", "a.enmse-ajax-page", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().siblings(".enmse-rrandom").val();
		var ajaxvalues = jQuery(this).attr("name");

		var loadurl = jQuery(this).parent().parent().siblings(".enmse-plugin-url").val();

		var embedoptions = jQuery(this).parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/display/pagination/newrelated.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().addClass("enmse-opaque");
			serscroll(randval);
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().load(loadthis, completeload);
		return false;
	});

	// Series Archives Pagination links
	jQuery(document).on("click", "a.enmse-ajax-apage", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().siblings(".enmse-random").val();
		var ajaxvalues = jQuery(this).attr("name");

		var loadurl = jQuery(this).parent().parent().siblings(".enmse-plugin-url").val();

		var embedoptions = jQuery(this).parent().parent().siblings(".enmse-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmse-permalink").val();
		var serandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().siblings().children(".enmse-plugin-url").val();
					var embedoptions = jQuery(this).parent().parent().siblings().children(".enmse-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().siblings().children(".enmse-permalink").val();
				};		
		var loadthis = loadurl+"/includes/display/pagination/newarchives.php?enmse=1"+ajaxvalues+embedoptions+"&enmse_permalink="+permalinkurl+"&enmse_random="+serandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().addClass("enmse-opaque");
			sescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmse-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmse-opaque");
			jQuery(this).parent().siblings(".enmse-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().load(loadthis, completeload);
		return false;
	});
	
	jQuery('#seriesengine audio').mediaelementplayer({stretching: 'responsive'});
	jQuery('#seriesengine video').mediaelementplayer({stretching: 'responsive'});

	jQuery("#seriesengine audio.enmseaplayer").bind("play", function(){
		var loadurl = jQuery(".enmse-plugin-url").val();
		var begcurrent = jQuery(this).attr("rel");
		if ( begcurrent == "" ) {
			begcurrent = 0;
		};
		var current = parseInt(begcurrent);
		var m = jQuery(this).attr("name");
		var newcount = current+1;
		var mtype = "audio";
		var posturl = loadurl+"/includes/viewcount.php";
		jQuery.post(posturl, { count: newcount, id: m, type: mtype });
		jQuery(this).unbind();
	});

	jQuery("#seriesengine video.enmsevplayer").bind("play", function(){
		var loadurl = jQuery(".enmse-plugin-url").val();
		var begcurrent = jQuery(this).attr("rel");
		if ( begcurrent == "" ) {
			begcurrent = 0;
		};
		var current = parseInt(begcurrent);
		var m = jQuery(this).attr("name");
		var newcount = current+1;
		var mtype = "video";
		var posturl = loadurl+"/includes/viewcount.php";
		jQuery.post(posturl, { count: newcount, id: m, type: mtype });
		jQuery(this).unbind();
	});

	jQuery("#seriesengine video.enmseaplayer").bind("play", function(){
		var loadurl = jQuery(".enmse-plugin-url").val();
		var begcurrent = jQuery(this).attr("rel");
		if ( begcurrent == "" ) {
			begcurrent = 0;
		};
		var current = parseInt(begcurrent);
		var m = jQuery(this).attr("name");
		var newcount = current+1;
		var mtype = "alternate";
		var posturl = loadurl+"/includes/viewcount.php";
		jQuery.post(posturl, { count: newcount, id: m, type: mtype });
		jQuery(this).unbind();
	});

	// Force audio download links to download with one click
	jQuery(document).on("click", "a#enmse-download.enmse-force", function() {
		var getthis = jQuery(this);
		var ajaxurl = jQuery(this).attr("href");
		var ajaxvalues = jQuery(this).attr("title");
		var loadurl = jQuery(this).parent().parent().parent().parent().siblings(".enmse-plugin-url").val();
		if (loadurl==null) {
			var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmse-plugin-url").val();
		};	
		window.location.assign(loadurl+"/includes/download.php?enmsepath="+ajaxurl);
		return false;
	});

	var enmsedocwidth = jQuery( document ).width();
	var enmseembedwidth = jQuery('#seriesengine').width();

	if ( enmseembedwidth <= 650 && enmsedocwidth >= 820 ) {
		jQuery('#seriesengine').addClass('se-medium');
	};

	if ( enmseembedwidth <= 300 ) {
		jQuery('#seriesengine').addClass('se-small');
	};
	
}; 

});