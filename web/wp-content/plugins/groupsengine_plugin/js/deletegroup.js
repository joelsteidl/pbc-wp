jQuery(document).ready(function() { /* ----- Groups Engine - Delete a Group ----- */
	jQuery('.groupsengine_delete').click(function() {
		var answer = confirm("Are you SURE you want to delete this group? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			jQuery("#groupsengine-deleteform"+id).submit();
		};
		return false;
	});

	jQuery(document).on("change", "#enmge_filter", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmgepluginurl").val();
		if ( selectval == 1 ) {
			jQuery("#enmge_grouptype").show();
			jQuery("#enmge_location").hide();
			jQuery("#enmge_topic").hide();
			jQuery("#enmge_day").hide();
		} else if ( selectval == 2 ) {
			jQuery("#enmge_grouptype").hide();
			jQuery("#enmge_location").show();
			jQuery("#enmge_topic").hide();
			jQuery("#enmge_day").hide();
		} else if ( selectval == 3 ) {
			jQuery("#enmge_grouptype").hide();
			jQuery("#enmge_location").hide();
			jQuery("#enmge_topic").show();
			jQuery("#enmge_day").hide();
		} else if ( selectval == 4 ) {
			jQuery("#enmge_grouptype").hide();
			jQuery("#enmge_location").hide();
			jQuery("#enmge_topic").hide();
			jQuery("#enmge_day").show();
		} else {
			window.location.assign(url);
		};
	});

	jQuery(document).on("change", "#enmge_grouptype", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmgepluginurl").val();
		window.location.assign(url + "&enmge_gtid=" + selectval);
	});
	jQuery(document).on("change", "#enmge_location", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmgepluginurl").val();
		window.location.assign(url + "&enmge_lid=" + selectval);
	});
	jQuery(document).on("change", "#enmge_topic", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmgepluginurl").val();
		window.location.assign(url + "&enmge_tid=" + selectval);
	});
	jQuery(document).on("change", "#enmge_day", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmgepluginurl").val();
		window.location.assign(url + "&enmge_day=" + selectval);
	});
});