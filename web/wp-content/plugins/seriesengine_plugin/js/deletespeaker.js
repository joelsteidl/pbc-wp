jQuery(document).ready(function() { /* ----- Series Engine - Delete a Topic ----- */
	jQuery('.seriesengine_delete').click(function() {
		var answer = confirm("Are you SURE you want to delete this Speaker? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			jQuery("#seriesengine-deleteform"+id).submit();
		};
	});
});