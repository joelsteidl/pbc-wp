jQuery(document).ready(function() { /* ----- Groups Engine - Frontend JavaScript ----- */
	var docwidth = jQuery( document ).width();
	var embedwidth = jQuery('.enmge-content-container').width();

	function gescroll(bla){
	    var tag = jQuery("#enmge-top"+bla);
	    jQuery("body, html").animate({scrollTop: tag.offset().top}, 400, function() {
	    	jQuery("body, html").clearQueue();
	    });
	}

	if ( embedwidth < 640 && docwidth > 715 ) {
		jQuery('.ge-social').addClass('ge-small');
		jQuery('.ge-explore-options').addClass('ge-small');
		jQuery('.ge-pagination').addClass('ge-small');
	};

	if ( (embedwidth > 640 && embedwidth < 800) && docwidth > 715 ) {
		jQuery('.ge-explore-options').addClass('ge-medium');
		jQuery('.ge-social').addClass('ge-medium');
	};

	jQuery(document).on("click", "a.enmge-hide-filter", function() {
		jQuery(this).parent().parent().siblings('.ge-explore-options').slideUp(200);
		jQuery(this).removeClass('enmge-hide-filter');
		jQuery(this).addClass('enmge-show-filter');
		return false;
	});
	jQuery(document).on("click", "a.enmge-show-filter", function() {
		var getthis = jQuery(this);
		jQuery(getthis).parent().parent().siblings('.ge-explore-options').slideDown(200);
		jQuery(this).removeClass('enmge-show-filter');
		jQuery(this).addClass('enmge-hide-filter');
		return false;
	});

	//Share Link Button
	jQuery(document).on("click", "a.enmge-copy-link", function() {
		var findheight = jQuery(this).position();
		var correctheight = findheight.top-30;
		var thislink = jQuery(this).attr("href");
		jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-copy-link-box").css("top",correctheight+"px");
		jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-copy-link-box").children("p:first").html(thislink);
		jQuery(this).parent().parent().parent().parent().parent().addClass("enmge-opaque");
		jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-copy-link-box").show();
		return false;
	});
	
	jQuery(document).on("click", ".enmge-copy-link-box a", function() {
		var getparent = jQuery(this).parent();
		var parentname = getparent[0].tagName;
		if (parentname=="P") {
			jQuery(this).parent().parent().siblings(".enmge-content-container").removeClass("enmge-opaque");
			jQuery(this).parent().parent().hide();
		} else {
			jQuery(this).parent().siblings(".enmge-content-container").removeClass("enmge-opaque");
			jQuery(this).parent().hide();
		};
		return false;
	});

	jQuery(document).on("submit", ".enmge-ajax-form", function(event) { // Search Form
		event.preventDefault();
		var ajaxitem = jQuery(this);
		var randval = jQuery(this).parent().parent().siblings(".enmge-random").val();
		var searchform = jQuery(this).serialize();
		var ajaxoptions = jQuery(this).parent().siblings(".enmge-ajax-options").val();
		var permalinkurl = jQuery(this).parent().siblings(".enmge-permalink").val();

		jQuery(ajaxitem).parent().parent().addClass("enmge-opaque");
		gescroll(randval);
		jQuery(ajaxitem).parent().parent().siblings(".enmge-loading-icon").show();

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	        	'method': 'POST',
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': '',
	            'sortoptions': '',
	            'ajaxoptions': ajaxoptions,
	            'searchform': searchform,
	            'embedoptions': '',
	            'goption': 0,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(ajaxitem).parent().parent().removeClass("enmge-opaque");
	        	jQuery(ajaxitem).parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(ajaxitem).parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });

		return false; 
	});	

	jQuery(document).on("click", "a.enmge-ajax-link", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-random").val();
		var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var sortoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings(".enmge-permalink").val();

		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': ajaxvalues,
	            'sortoptions': sortoptions,
	            'ajaxoptions': ajaxoptions,
	            'embedoptions': embedoptions,
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().parent().parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().parent().parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().parent().parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });

		return false;
	});

    jQuery(document).on("click", "a.enmge-ajax-back", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();

		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': getthisurl,
	            'sortoptions': '',
	            'ajaxoptions': '',
	            'embedoptions': '',
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });		
		return false;
	});

	jQuery(document).on("click", "a.enmge-first-ajax-back", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		var sortoptions = jQuery(this).parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();
		alert(randval);

		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': getthisurl,
	            'sortoptions': sortoptions,
	            'ajaxoptions': ajaxoptions,
	            'embedoptions': embedoptions,
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });	
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-page", function() { 
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("name");
		var embedoptions = jQuery(this).parent().siblings(".enmge-embed-options").val();
		var ajaxoptions = jQuery(this).parent().siblings(".enmge-ajax-options").val();
		var permalinkurl = jQuery(this).parent().siblings(".enmge-permalink").val();	

		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': getthisurl,
	            'sortoptions': '',
	            'ajaxoptions': ajaxoptions,
	            'embedoptions': embedoptions,
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-view", function() { /* here */
    	var getthis = jQuery(this);
    	var randval = jQuery(getthis).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("name");
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();


		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': getthisurl,
	            'sortoptions': '',
	            'ajaxoptions': '',
	            'embedoptions': embedoptions,
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-contact", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		var sortoptions = jQuery(this).parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();

		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': getthisurl,
	            'sortoptions': sortoptions,
	            'ajaxoptions': ajaxoptions,
	            'embedoptions': embedoptions,
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-details-contact", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		var sortoptions = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-permalink").val();


		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': getthisurl,
	            'sortoptions': sortoptions,
	            'ajaxoptions': ajaxoptions,
	            'embedoptions': embedoptions,
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().parent().parent().parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().parent().parent().parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().parent().parent().parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-contact-back", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		var sortoptions = jQuery(this).parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();

		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': getthisurl,
	            'sortoptions': sortoptions,
	            'ajaxoptions': ajaxoptions,
	            'embedoptions': embedoptions,
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});

	jQuery(document).on("submit", ".enmge-ajax-contact-form", function(event) { // Submit Leader Contact Form
		event.preventDefault();
		var ajaxitem = jQuery(this);
		var contactform = jQuery(this).serialize();
		var randval = jQuery(this).parent().parent().siblings(".enmge-random").val();
		var permalinkurl = jQuery(this).parent().siblings(".enmge-permalink").val();
		var groupid = jQuery(this).parent().siblings(".enmge-group-id").val();
		var ajaxvalues = "&enmge_gid="+groupid+"&enmge_cl=1";


		jQuery(ajaxitem).parent().parent().addClass("enmge-opaque");
		gescroll(randval);
		jQuery(ajaxitem).parent().parent().siblings(".enmge-loading-icon").show();

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	        	'method': 'POST',
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': ajaxvalues,
	            'sortoptions': '',
	            'ajaxoptions': '',
	            'searchform': '',
	            'contactform': contactform,
	            'embedoptions': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(ajaxitem).parent().parent().removeClass("enmge-opaque");
	        	jQuery(ajaxitem).parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(ajaxitem).parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false; 
	});

	jQuery(document).on("click", "a.enmge-ajax-pointer", function() { // Map Markers
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-random").val();
		var ajaxvalues = jQuery(this).attr("name");
		var loadurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-permalink").val();

		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").show();
		});

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxlinks',
	            'ajaxvalues': ajaxvalues,
	            'sortoptions': sortoptions,
	            'ajaxoptions': ajaxoptions,
	            'embedoptions': embedoptions,
	            'searchform': '',
	            'contactform': '',
	            'goption': 1,
	            'enmge_permalink': permalinkurl
	        },
	        success:function(data) {
	        	jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().removeClass("enmge-opaque");
	        	jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").hide();
	        	jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().unbind("ajaxSend");
				jQuery(document).off('ajaxSend');
	        	jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });	
		return false;
	});
});