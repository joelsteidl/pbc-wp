jQuery(document).ready(function() { /* ----- Series Engine - Delete a Podcast ----- */
	jQuery('.seriesengine_delete').click(function() {
		var answer = confirm("Are you SURE you want to delete this podcast? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			jQuery("#seriesengine-deleteform"+id).submit();
		};
	});
});