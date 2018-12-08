<?php /* Groups Engine - Uninstall the Plugin */

// If uninstall not called from WordPress exit 

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit (); 

	global $wpdb;
	if (function_exists('is_multisite') && is_multisite()) {
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog['blog_id']);
			enm_groupsengine_uninstall();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		enm_groupsengine_uninstall();
	}	

function enm_groupsengine_uninstall() { 
	// Delete option from options table 

	delete_option( 'enm_groupsengine_options' ); 
	delete_option('enmge_db_version');

	//remove any additional options and custom tables 

	global $wpdb;
	$dcnmatches = $wpdb->prefix . "ge_contact_notes";
	$dcontacts = $wpdb->prefix . "ge_contacts";
	$dfiles = $wpdb->prefix . "ge_files";
	$dgfmatches = $wpdb->prefix . "ge_group_file_matches";
	$dggtmatches = $wpdb->prefix . "ge_group_group_type_matches";
	$dglmatches = $wpdb->prefix . "ge_group_location_matches";
	$dgtmatches = $wpdb->prefix . "ge_group_topic_matches";
	$dgrouptypes = $wpdb->prefix . "ge_group_types";
	$dgroups = $wpdb->prefix . "ge_groups";
	$dlocations = $wpdb->prefix . "ge_locations";
	$dtopics = $wpdb->prefix . "ge_topics";
	$dleaders = $wpdb->prefix . "ge_leaders";
	$dlematches = $wpdb->prefix . "ge_group_leader_matches";
	$wpdb->query("DROP TABLE IF EXISTS $dcnmatches, $dcontacts, $dfiles, $dgfmatches, $dggtmatches, $dglmatches, $dgtmatches, $dgrouptypes, $dgroups, $dlocations, $dtopics, $dleaders, $dlematches");
}
?>