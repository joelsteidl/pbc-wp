jQuery(document).ready(function() { /* ----- Groups Engine - Delete a Topic ----- */
	jQuery('.groupsengine_delete').click(function() {
		var answer = confirm("Are you SURE you want to delete this topic? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			jQuery("#groupsengine-deleteform"+id).submit();
		};
	});
});