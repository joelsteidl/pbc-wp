jQuery(document).ready(function() { /* ----- Groups Engine - Frontend JavaScript ----- */
	var docwidth = jQuery( document ).width();
	var embedwidth = jQuery('.enmge-content-container').width();

	function gescroll(bla){
	    var tag = jQuery("#enmge-top"+bla);
	    jQuery("body").animate({scrollTop: tag.offset().top}, 400, function() {
	    	jQuery("body").clearQueue();
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
		var randval = jQuery(this).parent().parent().siblings(".enmge-random").val();
		var searchform = jQuery(this).serialize();
		var loadurl = jQuery(this).parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().siblings(".xxge").val();
		var ajaxoptions = jQuery(this).parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+ajaxoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		
		var posting = jQuery.post( loadthis, searchform );
		jQuery(this).parent().parent().addClass("enmge-opaque");
		gescroll(randval);
		jQuery(this).parent().parent().siblings(".enmge-loading-icon").show();
		var container = jQuery(this).parent().parent();
		posting.done(function( data ) {
	    	var content = jQuery( data );
	    	container.empty().append( content );
	    	container.removeClass("enmge-opaque");
			container.siblings(".enmge-loading-icon").hide();
	  	});
		return false; 
	});	

	jQuery(document).on("click", "a.enmge-ajax-link", function() {
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-random").val();
		var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
			var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
			var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
			var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
			var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
		};	
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+ajaxvalues+sortoptions+ajaxoptions+embedoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});

    jQuery(document).on("click", "a.enmge-ajax-back", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		//var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().siblings(".enmge-sort-options").val();
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
					var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
					var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
				};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+getthisurl+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
		};
		jQuery(this).parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmge-first-ajax-back", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		//var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
					var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
					var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
				};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+sortoptions+ajaxoptions+embedoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
		};
		jQuery(this).parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-page", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("name");
		//var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().siblings(".enmge-sort-options").val();
		var embedoptions = jQuery(this).parent().siblings(".enmge-embed-options").val();
		var ajaxoptions = jQuery(this).parent().siblings(".enmge-ajax-options").val();
		var permalinkurl = jQuery(this).parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
			var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
			var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
			var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
			var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
		};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+getthisurl+embedoptions+ajaxoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
		};
		jQuery(this).parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-view", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(getthis).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("name");
		//var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().siblings(".xxge").val();
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
					var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
					var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
					var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
					var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
				};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+getthisurl+embedoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
		};
		jQuery(this).parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-contact", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		//var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
			var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
			var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
			var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
			var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
		};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+getthisurl+sortoptions+ajaxoptions+embedoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
		};
		jQuery(this).parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-details-contact", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		//var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().parent().parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
			var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
			var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
			var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
			var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
		};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+getthisurl+sortoptions+ajaxoptions+embedoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
		};
		jQuery(this).parent().parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-pointer-contact", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		//var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
			var loadurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
			var xxge = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings().children(".xxge").val();
			var embedoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
			var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
		};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+getthisurl+sortoptions+ajaxoptions+embedoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
		};
		jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("click", "a.enmge-ajax-contact-back", function() {
    	var getthis = jQuery(this);
    	var randval = jQuery(this).parent().parent().parent().siblings(".enmge-random").val();
		var getthisurl = jQuery(this).attr("href");
		//var ajaxvalues = jQuery(this).siblings(".enmge-ajax-values").val();
		var loadurl = jQuery(this).parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
			var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
			var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
			var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
			var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
		};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+getthisurl+sortoptions+ajaxoptions+embedoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
		};
		jQuery(this).parent().parent().parent().load(loadthis, completeload);
		return false;
	});

	jQuery(document).on("submit", ".enmge-ajax-contact-form", function(event) { // Submit Leader Contact Form
		event.preventDefault();
		var contactform = jQuery(this).serialize();
		var randval = jQuery(this).parent().parent().siblings(".enmge-random").val();
		var loadurl = jQuery(this).parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().siblings(".xxge").val();
		var permalinkurl = jQuery(this).parent().siblings(".enmge-permalink").val();
		var groupid = jQuery(this).parent().siblings(".enmge-group-id").val();
		var gerandom = Math.floor(Math.random()*1001);
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1&enmge_gid="+groupid+"&enmge_cl=1&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		var posting = jQuery.post( loadthis, contactform );
		jQuery(this).parent().parent().addClass("enmge-opaque");
		gescroll(randval);
		jQuery(this).parent().parent().siblings(".enmge-loading-icon").show();
		var container = jQuery(this).parent().parent();
		posting.done(function( data ) {
	    	var content = jQuery( data );
	    	container.empty().append( content );
	    	container.removeClass("enmge-opaque");
			container.siblings(".enmge-loading-icon").hide();
	  	});
		return false; 
	});

	jQuery(document).on("click", "a.enmge-ajax-pointer", function() { // Map Markers
		var getthis = jQuery(this);
		var randval = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-random").val();
		var ajaxvalues = jQuery(this).attr("name");
		var loadurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-plugin-url").val();
		var xxge = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".xxge").val();
		var sortoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-sort-options").val();
		var ajaxoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-ajax-options").val();
		var embedoptions = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-embed-options").val();
		var permalinkurl = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-permalink").val();
		var gerandom = Math.floor(Math.random()*1001);
		if (loadurl==null) {
			var loadurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-plugin-url").val();
			var xxge = jQuery(this).parent().parent().parent().parent().siblings().children(".xxge").val();
			var embedoptions = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-embed-options").val();
			var permalinkurl = jQuery(this).parent().parent().parent().parent().siblings().children(".enmge-permalink").val();
		};		
		var loadthis = loadurl+"/includes/displaygroupsajax.php?enmge=1"+ajaxvalues+sortoptions+ajaxoptions+embedoptions+"&enmge_permalink="+permalinkurl+"&xxge="+xxge+"&enmge_random="+gerandom;
		jQuery(document).ajaxSend(function(){
			jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().addClass("enmge-opaque");
			gescroll(randval);
			jQuery(getthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().siblings(".enmge-loading-icon").show();
		});
		function completeload(){
			jQuery(this).removeClass("enmge-opaque");
			jQuery(this).siblings(".enmge-loading-icon").hide();
			jQuery(this).unbind("ajaxSend");
			jQuery(document).off('ajaxSend');
			jQuery(this).off();
		};
		jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().load(loadthis, completeload);
		return false;
	});
});