jQuery(document).ready(function() { /* ----- Groups Engine - Delete a Contact ----- */
	jQuery('.groupsengine_delete').click(function() {
		var answer = confirm("Are you SURE you want to delete this contact and its notes? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			jQuery("#groupsengine-deleteform"+id).submit();
		};
	});
	jQuery(document).on("change", "#enmge_cs", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmgepluginurl").val();
		window.location.assign(url + "&enmge_cs=" + selectval);
	});

});