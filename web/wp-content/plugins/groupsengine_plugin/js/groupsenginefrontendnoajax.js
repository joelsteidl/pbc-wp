jQuery(document).ready(function() { /* ----- Groups Engine - Frontend JavaScript ----- */
	var docwidth = jQuery( document ).width();
	var embedwidth = jQuery('.enmge-content-container').width();

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

});