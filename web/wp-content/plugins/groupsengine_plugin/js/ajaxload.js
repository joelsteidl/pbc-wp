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
});