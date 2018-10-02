jQuery(document).ready(function() { /* ----- Series Engine - Delete a Series ----- */
	jQuery('.seriesengine_delete').click(function() {
		var answer = confirm("Are you SURE you want to delete this series? Some messages will no longer be displayed on your site unless they're associated with another series. Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			jQuery("#seriesengine-deleteform"+id).submit();
		};
	});
});