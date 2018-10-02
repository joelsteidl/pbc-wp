jQuery(document).ready(function() { /* ----- Series Engine - Widget JavaScript ----- */
	 jQuery(".enmse_wtd").on("change", function() {
	 	if ( jQuery(this).val() == "mostrecent" ) {
	 		jQuery(this).parent().siblings(".enmse_se").hide();
	 		jQuery(this).parent().siblings(".enmse_al").hide();
	 		jQuery(this).parent().siblings(".enmse_num").hide();
	 	} else {
	 		jQuery(this).parent().siblings(".enmse_se").show();
	 		jQuery(this).parent().siblings(".enmse_al").show();
	 		jQuery(this).parent().siblings(".enmse_num").show();
	 	};
	 });
});