<?php 
/* Plugin Name: Groups Engine 
Plugin URI: http://groupsengine.com
Description: Groups Engine is powerful group search that actually works. To get started, activate the plugin and open the new "Groups Engine" menu. Follow the instructions on the <a href="admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide">User Guide page</a> to embed a groups page, change the color scheme and more.
Version: 1.2.8
Author: Eric Murrell (Volacious) 
Author URI: http://groupsengine.com */ 



global $wp_version;
/* ----- Plugin Updates ----- */
require 'plugin-updates/plugin-update-checker.php';
$ENMGEUpdateChecker = PucFactory::buildUpdateChecker(
	'http://pluginupdates.groupsengine.com/newupdater.json',
	__FILE__,
	'groupsengine_plugin'
);

/* ----- Install the Plugin ----- */
define ( 'ENMGE_CURRENT_VERSION', '1.2.8' );

$enmge_options = get_option( 'enm_groupsengine_options' );

register_activation_hook( __FILE__, 'enm_groupsengine_install_ms' ); 

function enm_groupsengine_install_ms( $network_wide ) { // Check for multisite

	global $wpdb;
	if ( $network_wide ) {
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			enm_groupsengine_install();

			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it
		}
		switch_to_blog($wpdb->blogid);
	} else {
		enm_groupsengine_install();
	}	

}

add_action( 'wpmu_new_blog', 'enmge_new_blog', 10, 6); // Multisite - If a new site is added		
 
function enmge_new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;
 
	if (is_plugin_active_for_network('groupsengine_plugin/groupsengine_plugin.php')) {
		$old_blog = $wpdb->blogid;
		switch_to_blog($blog_id);
		enm_groupsengine_install();

		$data = get_option( 'enm_groupsengine_options' ); ;	
		$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
		ob_start(); // Capture all output (output buffering)
		include($css_dir . 'ge_styles_generate.php'); // Generate CSS
		$css = ob_get_clean(); // Get generated CSS (output buffering)
		file_put_contents($css_dir . 'ge_' . $blog_id . '_styles.css', $css, LOCK_EX); // Save it
		switch_to_blog($old_blog);
	}
}

function enm_groupsengine_install() { 
	if ( version_compare( get_bloginfo( 'version' ), '3.8', '<' ) ) { // Don't activate plugin if WordPress version is less than 3.5
		$enmge_old_version_message = "WordPress 3.8 or greater is required to use Groups Engine. Please upgrade!";
		exit ($enmge_old_version_message);
	}

	// Create GE database tables
	global $wpdb;

	// Define DB version
	global $enmge_db_version;
	$enmge_db_version = "1.20";
	if( !defined(get_option( 'enmge_db_version' )) ) {
		add_option("enmge_db_version", $enmge_db_version);
	} else {
		update_option("enmge_db_version", $enmge_db_version);
	}
	
	$contact_notes = $wpdb->prefix . "ge_contact_notes"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$contact_notes'") != $contact_notes ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $contact_notes ( 
				contact_note_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				contact_id int(11) NOT NULL,
				contact_note_date datetime DEFAULT NULL,
	  			contact_note_user varchar(255) DEFAULT NULL,
				contact_note text) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstcontactnote = array( 
				'contact_note_id' => '1', 
				'contact_id' => '1', 
				'contact_note_date' => '2014-07-02 16:15:26', 
				'contact_note_user' => 'Eric Murrell', 
				'contact_note' => 'This is a sample note for a contact.'
			); 
			$wpdb->insert( $contact_notes, $firstcontactnote );		
	}

	$contacts = $wpdb->prefix . "ge_contacts"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$contacts'") != $contacts ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $contacts ( 
				contact_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				contact_name varchar(100) DEFAULT NULL,
				contact_email varchar(255) DEFAULT NULL,
				contact_phone varchar(40) DEFAULT NULL,
				contact_message text,
				contact_modcode char(32) DEFAULT NULL,
				contact_status varchar(50) DEFAULT NULL,
				contact_date datetime DEFAULT NULL,
				contact_group_title varchar(255) DEFAULT NULL,
				contact_group_id int(11) NOT NULL,
				contact_group_leader varchar(255) DEFAULT NULL,
				contact_group_leader_email varchar(255) DEFAULT NULL,
				contact_last_update varchar(100) DEFAULT NULL,
				contact_last_update_day date DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstcontact = array( 
				'contact_id' => '1', 
				'contact_name' => 'Lauren Murrell', 
				'contact_email' => 'noreply@groupsengine.com',
				'contact_phone' => '6155555555',
				'contact_message' => 'This is an example of the kind of contacts you will see coming in from group search.',
				'contact_modcode' => '696a9a6125050969aec0edd46895f242',
				'contact_status' => 'Initial Followup Needed',
				'contact_date' => '2014-07-02 16:14:30',
				'contact_group_id' => '1',
				'contact_group_title' => 'Sample Group',
				'contact_group_leader' => 'Eric Murrell',
				'contact_group_leader_email' => 'noreply@groupsengine.com',
				'contact_last_update' => '',
				'contact_last_update_day' => ''
			); 
			$wpdb->insert( $contacts, $firstcontact );		
	}

	$files = $wpdb->prefix . "ge_files"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$files'") != $files ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $files ( 
				file_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				file_name varchar(255) DEFAULT NULL,
				file_url varchar(255) DEFAULT NULL,
				file_username varchar(255) DEFAULT NULL,
				sort_id int(11) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstfile = array( 
				'file_id' => '1', 
				'file_name' => 'This is a Sample Link/File', 
				'file_url' => 'http://groupsengine.com',
				'file_username' => 'admin',
				'sort_id' => '1'
			); 
			$wpdb->insert( $files, $firstfile );		
	}

	$group_file_matches = $wpdb->prefix . "ge_group_file_matches"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$group_file_matches'") != $group_file_matches ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $group_file_matches ( 
				gf_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				group_id int(11) NOT NULL,
				file_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstgroupfile = array( 
				'gf_match_id' => '1', 
				'group_id' => '1', 
				'file_id' => '1'
			); 
			$wpdb->insert( $group_file_matches, $firstgroupfile );		
	}

	$leaders = $wpdb->prefix . "ge_leaders"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$leaders'") != $leaders ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $leaders ( 
				leader_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				leader_name varchar(255) DEFAULT NULL,
				leader_email varchar(255) DEFAULT NULL,
				leader_username varchar(255) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstleader = array( 
				'leader_id' => '1', 
				'leader_name' => 'Eric Murrell', 
				'leader_email' => 'noreply@groupsengine.com',
				'leader_username' => 'admin'
			); 
			$wpdb->insert( $leaders, $firstleader );		
	}

	$group_leader_matches = $wpdb->prefix . "ge_group_leader_matches"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$group_leader_matches'") != $group_leader_matches ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $group_leader_matches ( 
				gle_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				group_id int(11) NOT NULL,
				leader_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstgroupleader = array( 
				'gle_match_id' => '1', 
				'group_id' => '1', 
				'leader_id' => '1'
			); 
			$wpdb->insert( $group_leader_matches, $firstgroupleader );		
	}

	$group_group_type_matches = $wpdb->prefix . "ge_group_group_type_matches"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$group_group_type_matches'") != $group_group_type_matches ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $group_group_type_matches ( 
				ggtm_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				group_id int(11) DEFAULT NULL,
				group_type_id int(11) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstgroupgrouptype = array( 
				'ggtm_id' => '1', 
				'group_id' => '1', 
				'group_type_id' => '1'
			); 
			$wpdb->insert( $group_group_type_matches, $firstgroupgrouptype );		
	}

	$group_location_matches = $wpdb->prefix . "ge_group_location_matches"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$group_location_matches'") != $group_location_matches ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $group_location_matches ( 
				gl_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				group_id int(11) NOT NULL,
				location_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstgrouplocation = array( 
				'gl_match_id' => '1', 
				'group_id' => '1', 
				'location_id' => '1'
			); 
			$wpdb->insert( $group_location_matches, $firstgrouplocation );		
	}

	$group_topic_matches = $wpdb->prefix . "ge_group_topic_matches"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$group_topic_matches'") != $group_topic_matches ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $group_topic_matches ( 
				gt_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				group_id int(11) DEFAULT NULL,
				topic_id int(11) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstgrouptopic = array( 
				'gt_match_id' => '1', 
				'group_id' => '1', 
				'topic_id' => '1'
			); 
			$wpdb->insert( $group_topic_matches, $firstgrouptopic );		
	}

	$group_types = $wpdb->prefix . "ge_group_types"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$group_types'") != $group_types ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $group_types ( 
				group_type_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				group_type_title varchar(255) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstgrouptype = array( 
				'group_type_id' => '1', 
				'group_type_title' => 'Small Group'
			); 
			$wpdb->insert( $group_types, $firstgrouptype );		
	}

	$groups = $wpdb->prefix . "ge_groups"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$groups'") != $groups ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $groups ( 
				group_id int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
				group_title varchar(255) DEFAULT NULL,
				group_description text,
				group_leaders varchar(255) DEFAULT NULL,
				group_leaders_email varchar(255) DEFAULT NULL,
				group_onsite int(2) DEFAULT NULL,
				group_campus_name varchar(255) DEFAULT NULL,
				group_childcare int(2) DEFAULT NULL,
				group_childcare_details varchar(255) DEFAULT NULL,
				group_address1 varchar(255) DEFAULT NULL,
				group_address2 varchar(255) DEFAULT NULL,
				group_city varchar(255) DEFAULT NULL,
				group_state varchar(255) DEFAULT NULL,
				group_zip varchar(255) DEFAULT NULL,
				group_lat varchar(40) DEFAULT NULL,
				group_long varchar(40) DEFAULT NULL,
				group_manedit int(2) DEFAULT NULL,
				group_location_privacy int(1) DEFAULT NULL,
				group_photo varchar(255) DEFAULT NULL,
				group_day int(1) DEFAULT NULL,
				group_starttime time DEFAULT NULL,
				group_endtime time DEFAULT NULL,
				group_begins date DEFAULT NULL,
				group_ends date DEFAULT NULL,
				group_noend int(1) DEFAULT NULL,
				group_modcode varchar(32) DEFAULT NULL,
				group_privacy int(2) DEFAULT NULL,
				group_location_label varchar(255) DEFAULT NULL,
				group_startage int(3) DEFAULT NULL,
				group_endage int(3) DEFAULT NULL,
				group_frequency varchar(50) DEFAULT NULL,
				group_status int(2) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstgroup = array( 
				'group_id' => '1', 
				'group_title' => 'Sample Group',
				'group_description' => 'This is just a sample group to help you see Groups Engine in action. Log in to WordPress to delete it. If you\'re just getting started, you\'ll want to visit Settings > Groups Engine to set up defaults for your maps, customize colors, change text, and more.',
				'group_leaders' => 'Eric Murrell',
				'group_leaders_email' => 'noreply@groupsengine.com',
				'group_onsite' => '0',
				'group_campus_name' => '',
				'group_childcare' => '1',
				'group_childcare_details' => 'Babysitter onsite.',
				'group_address1' => '',
				'group_address2' => '',
				'group_city' => 'Nashville',
				'group_state' => 'Tennessee',
				'group_zip' => '37202',
				'group_lat' => '36.1888361',
				'group_long' => '-86.7731582',
				'group_manedit' => '0',
				'group_location_privacy' => '1',
				'group_photo' => '',
				'group_day' => '1',
				'group_starttime' => '09:00:00',
				'group_endtime' => '10:00:00',
				'group_begins' => '2014-07-02',
				'group_ends' => '2024-07-02',
				'group_noend' => '1',
				'group_modcode' => '',
				'group_privacy' => '1',
				'group_location_label' => 'Nashville Coffee Shop',
				'group_startage' => '18',
				'group_endage' => '100',
				'group_frequency' => 'Every',
				'group_status' => '1'
			); 
			$wpdb->insert( $groups, $firstgroup );		
	}

	$locations = $wpdb->prefix . "ge_locations"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$locations'") != $locations ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $locations ( 
				location_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				location_name varchar(255) DEFAULT NULL,
				location_address1 varchar(255) DEFAULT NULL,
				location_address2 varchar(255) DEFAULT NULL,
				location_city varchar(255) DEFAULT NULL,
				location_state varchar(255) DEFAULT NULL,
				location_zip int(30) DEFAULT NULL,
				location_lat varchar(30) DEFAULT NULL,
				location_long varchar(30) DEFAULT NULL,
				location_manedit int(2) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firstlocation = array( 
				'location_id' => '1', 
				'location_name' => 'Main Campus',
				'location_address1' => '',
				'location_address2' => '',
				'location_city' => 'Nashville',
				'location_state' => 'TN',
				'location_zip' => '37202',
				'location_lat' => '36.1888361',
				'location_long' => '-86.7731582',
				'location_manedit' => '0'
			); 
			$wpdb->insert( $locations, $firstlocation );		
	}

	$topics = $wpdb->prefix . "ge_topics"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$topics'") != $topics ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $topics ( 
				topic_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				topic_name varchar(255) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
			$firsttopic = array( 
				'topic_id' => '1', 
				'topic_name' => 'General Study'
			); 
			$wpdb->insert( $topics, $firsttopic );		
	}

	register_uninstall_hook( __FILE__, 'enm_groupsengine_uninstall_ms' );

	// Set default options
	$enm_groupsengine_options = array( 
		'ministryname' => 'Your Ministry Name Here',
		'spamprotection' => '0',
		'ajax' => '1',
		'emailname' => 'Groups Engine',
		'emailaddress' => 'noreply@emailaddress.com',
		'imagewidth' => '300',
		'apikey' => '',
		'serverapikey' => '',
		'zoom' => '11',
		'pag' => '10',
		'mapcenter' => '37202',
		'maplat' => '36.1888361',
		'maplong' => '-86.7731582',
		'groupsearchmap' => '400',
		'singlegroupmap' => '400',
		'pointer' => '',
		'explorerbg' => 'd4d4d4',
		'exploreactionbg' => 'CA9E2C',
		'exploreactiontext' => 'EAD8AA',
		'exploreactionicon' => 'light',
		'explorebuttonbg' => 'f1f1f1',
		'explorebuttonbgroll' => 'ffffff',
		'explorebuttontext' => 'A8A8A8',
		'explorebuttonicon' => 'dark',
		'filterbg' => 'f1f1f1',
		'filtertext' => '000000',
		'filterfieldbg' => 'ffffff',
		'filterfieldborder' => 'ffffff',
		'filterfieldtext' => '000000',
		'filtersubmitbg' => 'CA9E2C',
		'filtersubmittext' => 'EAD8AA',
		'grouplistheadertext' => '000000',
		'grouplisttext' => '000000',
		'grouplistlink' => 'CA9E2C',
		'grouplistrow' => 'f1f1f1',
		'pagebuttonbg' => 'CA9E2C',
		'pagebuttontext' => 'ffffff',
		'pagenumber' => 'D4D4D4',
		'pagenumberselectedbg' => 'f1f1f1',
		'pagenumberselectedtext' => 'D4D4D4',
		'singletitle' => '000000',
		'singledetails' => '000000',
		'singledetailsbg' => 'f1f1f1',
		'singledetailstext' => '000000',
		'singledetailslink' => 'CA9E2C',
		'singledetailslabel' => '000000',
		'singledetailssharebg' => 'D4D4D4',
		'singledetailssharebgroll' => 'dcdbdb',
		'singledetailssharetext' => '848484',
		'singledetailsshareicon' => 'dark',
		'relatedbg' => 'd9d9d9',
		'relatedtext' => '000000',
		'relatedlink' => 'CA9E2C',
		'contacttitle' => '000000',
		'contactinstructionstext' => '000000',
		'contactinstructions' => 'Please fill out the form below to get more information about this group. Someone will be in touch with you as soon as possible.',
		'contactformlabel' => '000000',
		'contactformfieldbg' => 'f1f1f1',
		'contactformfieldtext' => '000000',
		'contactformsubmitbg' => 'CA9E2C',
		'contactformsubmittext' => 'EAD8AA',
		'errorbg' => 'EAD8AA',
		'errortext' => '000000',
		'successbg' => 'EAD8AA',
		'successtext' => '000000',
		'shareboxbg' => 'd4d4d4',
		'shareboxtext' => '444444',
		'shareboxbuttonbg' => 'CA9E2C',
		'shareboxbuttontext' => 'EAD8AA',
		'updatebg' => 'ffffff',
		'updatetext' => '000000',
		'updatestatustext' => 'CA9E2C',
		'updatelink' => 'CA9E2C',
		'updatenotebg' => 'fafafa',
		'updatenotetext' => '000000',
		'updateformfieldbg' => 'f1f1f1',
		'updateformfieldtext' => '000000',
		'updateformsubmitbg' => 'CA9E2C',
		'updateformsubmittext' => 'EAD8AA',
		'loadingbg' => 'd4d4d4',
		'loadingtext' => '444444',
		'loadingicon' => 'dark',
		'customloading' => '',
		'customloadingretina' => '',
		'credits' => 'light',
		'creditstext' => 'f1f1f1',
		'contactsuccess' => 'Your message has been sent to the group leader. Someone will be in touch with you as soon as possible.',
		'grouptitle' => 'Group',
		'groupptitle' => 'Groups',
		'grouptypetitle' => 'Group Type',
		'grouptypeptitle' => 'Group Types',
		'locationtitle' => 'Location',
		'locationptitle' => 'Locations',
		'topictitle' => 'Topic',
		'topicptitle' => 'Topics',
		'searchwidth' => '210',
		'backsearchwidth' => '134',
		'contactwidth' => '192',
		'backgroupwidth' => '130',
		'showday' => '1',
		'showtime' => '1',
		'showages' => '1',
		'showlocations' => '0',
		'showlocation' => '1',
		'showtopic' => '1',
		'showchildcare' => '0',
		'showstatus' => '0',
		'offsite' => 'Offsite',
		'childcare' => 'Childcare Available?',
		'offsitelabel' => '1',
		'showstart' => '0',
		'nogroups' => 'No Groups are currently available that match this search criteria. Please search again using the options above.',
		'searchbuttonlabel' => 'Available Groups',
		'contactbuttonlabel' => 'Group Leader'
		);
	add_option( 'enm_groupsengine_options', $enm_groupsengine_options ); 
}

/* ----- Uninstall the Plugin ----- */

function enm_groupsengine_uninstall_ms() { // Check for multisite

	global $wpdb;
	if (function_exists('is_multisite') && is_multisite()) {
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			enm_groupsengine_uninstall();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		enm_groupsengine_uninstall();
	}	

}

function enm_groupsengine_uninstall() { 
	delete_option('enm_groupsengine_options'); 
	delete_option('enmge_db_version');
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
}; 

/* ----- Create the Admin Menus ----- */

add_action( 'admin_menu', 'enm_groupsengine_create_menu' );

function enm_groupsengine_create_menu() { 

	$ge_options = get_option( 'enm_groupsengine_options' );

	$locationptitle = $ge_options['locationptitle'];

	$topicptitle = $ge_options['topicptitle'];

	$grouptypeptitle = $ge_options['grouptypeptitle'];

	add_menu_page( 
		'Add and Edit Groups', 
		'Groups Engine', 
		'edit_posts', 
		__FILE__, 
		'enm_groupsengine_groups_page', 
		plugins_url( '/images/blank.png', __FILE__ )
	); 

	add_submenu_page( __FILE__, 'Add and Edit ' . $locationptitle, 'Edit ' . $locationptitle, 'edit_posts', __FILE__ . '_locations', 'enm_groupsengine_locations_page'); 
	add_submenu_page( __FILE__, 'Add and Edit ' . $topicptitle, 'Edit ' . $topicptitle, 'edit_posts', __FILE__ . '_topics', 'enm_groupsengine_topics_page'); 
	add_submenu_page( __FILE__, 'Add and Edit ' . $grouptypeptitle, 'Edit ' . $grouptypeptitle, 'edit_posts', __FILE__ . '_grouptypes', 'enm_groupsengine_grouptypes_page'); 
	add_submenu_page( __FILE__, 'View and Update Contacts', 'View Contacts', 'edit_posts', __FILE__ . '_contacts', 'enm_groupsengine_contacts_page'); 
	add_submenu_page( __FILE__, 'Embed Groups Engine on a Page', 'Get Shortcodes', 'edit_pages', __FILE__ . '_embed', 'enm_groupsengine_embedcode_page'); 
	add_submenu_page( __FILE__, 'Report Library', 'Report Library', 'edit_posts', __FILE__ . '_reports', 'enm_groupsengine_reportlibrary_page'); 
	add_submenu_page( __FILE__, 'User Guide', 'User Guide', 'edit_posts', __FILE__ . '_userguide', 'enm_groupsengine_userguide_page'); 
	//add_submenu_page( __FILE__, 'Check for Updates to the Groups Engine Plugin', 'Check for Updates', 'edit_pages', __FILE__ . '_updates', 'enm_groupsengine_update_page'); 
}

/* Admin Menu - Groups Page */

function enm_groupsengine_groups_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/groups.php'); 
}

/* Admin Menu - Locations Page */

function enm_groupsengine_locations_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/locations.php'); 
}

/* Admin Menu - Topics Page */

function enm_groupsengine_topics_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/topics.php'); 
}

/* Admin Menu - Group Types Page */

function enm_groupsengine_grouptypes_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/grouptypes.php'); 
}

/* Admin Menu - Contacts Page */

function enm_groupsengine_contacts_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/contacts.php'); 
}

/* Admin Menu - Embed Code */

function enm_groupsengine_embedcode_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed.php'); 
}

/* Admin Menu - Report Library */

function enm_groupsengine_reportlibrary_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/reports.php'); 
}

/* Admin Menu - User Guide */

function enm_groupsengine_userguide_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/userguide.php'); 
}

/* Admin Menu - Check for Updates */

function enm_groupsengine_update_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/update.php'); 
}



/* Setup admin panel */

add_action('admin_enqueue_scripts', 'enm_groupsengine_admin_enqueue');

function enm_groupsengine_admin_enqueue() {
	wp_enqueue_media();
	// Add stylesheet
	global $wp_version;

	wp_register_style( 'GroupsengineAdminStylesheet', plugins_url('/css/ge_backend.css', __FILE__) );
	wp_enqueue_style( 'GroupsengineAdminStylesheet' );
	
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-ui-droppable' );

}

add_action('init', 'enm_groupsengine_add_jquery'); 

function enm_groupsengine_add_jquery() {
	wp_enqueue_script( 'jquery' );
}

/* ----- Generate Static Stylesheet ----- */

function generate_ge_options_css($newdata) {

	$data = $newdata;	
	$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
	ob_start(); // Capture all output (output buffering)

	include($css_dir . 'ge_styles_generate.php'); // Generate CSS

	$css = ob_get_clean(); // Get generated CSS (output buffering)

	if(is_multisite()) { 
		global $current_blog;
		file_put_contents($css_dir . 'ge_' . $current_blog->blog_id . '_styles.css', $css, LOCK_EX); // Save it
	} else {
		file_put_contents($css_dir . 'ge_styles.css', $css, LOCK_EX); // Save it
	}
	
}

/* ----- Modify User Theme to Add Stylesheets and JavaScript ----- */

add_action('template_redirect', 'enm_groupsengine_frontend_styles'); 

function enm_groupsengine_frontend_styles() {
	$ge_options = get_option( 'enm_groupsengine_options' );
	if ( isset($ge_options['ajax']) ) {
		$ge_noajax = $ge_options['ajax'];
	} else {
		$ge_noajax = 0;
	}
	if ( $ge_noajax == 0 ) {
		wp_register_script( 'GroupsEngineFrontendJavascript', plugins_url('/js/groupsenginefrontendnoajax.js', __FILE__) );
		wp_enqueue_script( 'GroupsEngineFrontendJavascript' );
	} else {
		wp_register_script( 'GroupsEngineFrontendJavascript', plugins_url('/js/groupsenginefrontend127.js', __FILE__) );
		wp_enqueue_script( 'GroupsEngineFrontendJavascript' );
	}

	if(is_multisite()) { 
		global $current_blog;
		wp_register_style( 'GroupsEngineFrontendStyles', plugins_url('/css/ge_' . $current_blog->blog_id . '_styles.css', __FILE__) );
		wp_enqueue_style( 'GroupsEngineFrontendStyles' );
	} else {
		wp_register_style( 'GroupsEngineFrontendStyles', plugins_url('/css/ge_styles.css', __FILE__) );
		wp_enqueue_style( 'GroupsEngineFrontendStyles' );
	}
	

}

/* ----- Add IE Code to Header ----- */

add_action ( 'wp_head', 'enmge_ie_compatibility' );

function enmge_ie_compatibility()
{
    echo '<!-- Display fixes for Internet Explorer -->
	<!--[if IE 8]>
	<link href="' . plugins_url() .'/groupsengine_plugin/css/ie8_fix.css' . '" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!-- end display fixes for Internet Explorer -->';
}

/* ----- Additional Image Sizes ----- */

$ge_options = get_option( 'enm_groupsengine_options' );
$ge_image_width = $ge_options['imagewidth'];

add_image_size('Groups Engine Image', $ge_image_width);
/*update_option('image_default_link_type' , '');
*/

function enmge_insert_custom_image_sizes( $sizes ) {
    // get the custom image sizes
    global $_wp_additional_image_sizes;
    // if there are none, just return the built-in sizes
    if ( empty( $_wp_additional_image_sizes ) )
        return $sizes;

    // add all the custom sizes to the built-in sizes
    foreach ( $_wp_additional_image_sizes as $id => $data ) {
        // take the size ID (e.g., 'my-name'), replace hyphens with spaces,
        // and capitalise the first letter of each word
        if ( !isset($sizes[$id]) )
            $sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
    }

    return $sizes;
}

add_filter( 'image_size_names_choose', 'enmge_insert_custom_image_sizes' );

 /* ----- Override for Crazy Theme Styles ----- */

/*function enmge_formatter($content) { // Override WordPress's Crazy default insertion of elements using [geraw]

		remove_filter('the_content', 'wpautop');
		remove_filter('the_content', 'wptexturize');
	   	$new_content = '';
       	$pattern_full = '{(\[geraw\].*?\[/geraw\])}is';
       	$pattern_contents = '{\[geraw\](.*?)\[/geraw\]}is';
       	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

       	foreach ($pieces as $piece) {
        	if (preg_match($pattern_contents, $piece, $matches)) {
            	$new_content .= $matches[1];
        	} else {
                $new_content .= wptexturize(wpautop($piece));
            }
		}

       	return $new_content;

}

add_filter('the_content', 'enmge_formatter', 99);*/

/* ----- Register Group Shortcodes ----- */

// Register a new shortcode: [groupsengine] 
add_shortcode( 'groupsengine', 'enm_groupsengine_embedgroups' ); // The callback function that will replace [groupsengine] 

function enm_groupsengine_embedgroups() {
	ob_start(); // do it this way to render within page content
	$enmge_lo = 0;
	$enmge_a = 0;
	$enmge_de = 0;
	$enmge_xd = 0;
	include(plugin_dir_path( __FILE__ ) . 'includes/displaygroups.php'); 
	$content = ob_get_clean();
	return $content; 
}

// Register a new shortcode: [groupsengine_wo] 
add_shortcode( 'groupsengine_wo', 'enm_groupsengine_embedgroups_options' ); // The callback function that will replace [groupsengine_wo] 

function enm_groupsengine_embedgroups_options( $attr ) {
	ob_start(); // do it this way to render within page content
	$enmge_lo = 1;

	if ( isset($attr['enmge_gid']) ) { 
		$enmge_fgid = $attr['enmge_gid'];
	} else {
		$enmge_fgid = 0;
	}
	
	if ( isset($attr['enmge_gtid']) ) { 
		$enmge_fgtid = $attr['enmge_gtid'];
	} else {
		$enmge_fgtid = 0;
	}

	if ( isset($attr['enmge_tid']) ) { 
		$enmge_ftid = $attr['enmge_tid'];
	} else {
		$enmge_ftid = 0;
	}

	if ( isset($attr['enmge_lid']) ) { 
		$enmge_flid = $attr['enmge_lid'];
	} else {
		$enmge_flid = 0;
	}

	if ( isset($attr['enmge_m']) ) { 
		$enmge_fm = $attr['enmge_m'];
	} else {
		$enmge_fm = 2;
	}

	if ( isset($attr['enmge_d']) ) { 
		$enmge_fd = $attr['enmge_d'];
	} else {
		$enmge_fd = 0;
	}

	if ( isset($attr['enmge_st']) ) { 
		$enmge_fst = $attr['enmge_st'];
	} else {
		$enmge_fst = 0;
	}

	if ( isset($attr['enmge_et']) ) { 
		$enmge_fet = $attr['enmge_et'];
	} else {
		$enmge_fet = 0;
	}

	if ( isset($attr['enmge_sa']) ) { 
		$enmge_fsa = $attr['enmge_sa'];
	} else {
		$enmge_fsa = 0;
	}

	if ( isset($attr['enmge_ea']) ) { 
		$enmge_fea = $attr['enmge_ea'];
	} else {
		$enmge_fea = 0;
	}

	if ( isset($attr['enmge_z']) ) { 
		$enmge_fz = $attr['enmge_z'];
	} else {
		$enmge_fz = 0;
	}

	if ( isset($attr['enmge_v']) ) { 
		$enmge_fv = $attr['enmge_v'];
	} else {
		$enmge_fv = 0;
	}

	// Center zoom

	if ( isset($attr['enmge_cz']) ) { 
		$enmge_fcz = $attr['enmge_cz'];
	} else {
		$enmge_fcz = 0;
	}

	if ( isset($attr['enmge_zl']) ) { 
		$enmge_fzl = $attr['enmge_zl'];
	} else {
		$enmge_fzl = 0;
	}

	// Disable options

	if ( isset($attr['enmge_vo']) ) { // view toggle
		$enmge_fvo = 0;
	} else {
		$enmge_fvo = 1;
	}

	if ( isset($attr['enmge_cl']) ) { // contact group leader
		$enmge_fcl = 0;
	} else {
		$enmge_fcl = 1;
	}

	if ( isset($attr['enmge_gl']) ) { // group list from single group
		$enmge_fgl = 0;
	} else {
		$enmge_fgl = 1;
	}

	if ( isset($attr['enmge_fo']) ) { // search
		$enmge_ffo = 2;
	} else {
		$enmge_ffo = 0;
	}

	if ( isset($attr['enmge_sm']) ) { // show individual maps
		$enmge_fsm = 0;
	} else {
		$enmge_fsm = 1;
	}

	if ( isset($attr['enmge_pag']) ) { // number of groups per page
		$enmge_fpag = $attr['enmge_pag'];
	} else {
		$enmge_fpag = 0;
	}

	if ( isset($attr['enmge_start']) ) { // limit search depending on group start date.
		$enmge_fstart = $attr['enmge_start'];
	} else {
		$enmge_fstart = 0;
	}

	if ( isset($attr['enmge_sort']) ) { // group list sorting
		$enmge_fsort = $attr['enmge_sort'];
	} else {
		$enmge_fsort = 0;
	}

	if ( isset($attr['enmge_status']) ) { // group status
		$enmge_fstatus = $attr['enmge_status'];
	} else {
		$enmge_fstatus = 'n';
	}

	if ( isset($attr['enmge_xgt']) ) { // limit group type search
		$enmge_fxgt = 1;
	} else {
		$enmge_fxgt = 0;
	}

	if ( isset($attr['enmge_xt']) ) { // limit topic search
		$enmge_fxt = 1;
	} else {
		$enmge_fxt = 0;
	}

	if ( isset($attr['enmge_xl']) ) { // limit location search
		$enmge_fxl = 1;
	} else {
		$enmge_fxl = 0;
	}

	if ( isset($attr['enmge_xm']) ) { // limit meeting search
		$enmge_fxm = 1;
	} else {
		$enmge_fxm = 0;
	}

	if ( isset($attr['enmge_xd']) ) { // limit day search
		$enmge_fxd = 1;
	} else {
		$enmge_fxd = 0;
	}

	if ( isset($attr['enmge_xst']) ) { // limit time search
		$enmge_fxst = 1;
	} else {
		$enmge_fxst = 0;
	}

	if ( isset($attr['enmge_xsa']) ) { // limit age search
		$enmge_fxsa = 1;
	} else {
		$enmge_fxsa = 0;
	}

	if ( isset($attr['enmge_xz']) ) { // limit zip search
		$enmge_fxz = 1;
	} else {
		$enmge_fxz = 0;
	}
	
	include(plugin_dir_path( __FILE__ ) . 'includes/displaygroups.php'); 
	$content = ob_get_clean();
	return $content; 
}

/* ----- Add Groups Engine Settings to User Page ----- */

add_action( 'show_user_profile', 'enm_groupsengine_user_settings' ); 
add_action( 'edit_user_profile', 'enm_groupsengine_user_settings' ); 

function enm_groupsengine_user_settings( $user ) { // show prayer engine form on admin
	global $wp_version;

	// Get All Group Types
	global $wpdb;
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_id ASC"; 
	$enmge_grouptypes = $wpdb->get_results( $enmge_preparredsql );
	foreach ($enmge_grouptypes as $grouptype) {
		${'enmge_gtvalue' . $grouptype->group_type_id} = get_user_meta( $user->ID, 'groupsengine_admin_grouptype' . $grouptype->group_type_id, true ); 
	}
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/admin_user_settings.php'); 
}

add_action( 'personal_options_update', 'enm_groupsengine_update_user_settings' ); 
add_action( 'edit_user_profile_update', 'enm_groupsengine_update_user_settings' ); 

function enm_groupsengine_update_user_settings( $user_id ) { // show groups engine form on admin
	if ( !current_user_can( 'edit_user', $user_id ) ) 
	return false; 
	// Get All Group Types
	global $wpdb;
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_id ASC"; 
	$enmge_grouptypes = $wpdb->get_results( $enmge_preparredsql );
	foreach ($enmge_grouptypes as $grouptype) {
		if ( isset($_POST['groupsengine_admin_grouptype' . $grouptype->group_type_id]) ) {
			$enmge_savevalue = $_POST['groupsengine_admin_grouptype' . $grouptype->group_type_id];
		} else {
			$enmge_savevalue = 0;
		}
		global $wp_version;
		update_user_meta( $user_id, 'groupsengine_admin_grouptype' . $grouptype->group_type_id, $enmge_savevalue ); 
	}
}

/* ----- Pointer Image ----- */

add_image_size('Groups Engine Pointer', 48, 48);

/* ----- Groups Engine Settings Page ----- */

add_action('admin_menu', 'enm_groupsengine_add_page'); 

function enm_groupsengine_add_page() { 
	add_options_page( 'Groups Engine', 'Groups Engine', 'manage_options', 'enm_groupsengine', 'enm_groupsengine_options_page' ); 
} 

function enm_groupsengine_options_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/settings.php'); 
}

add_action('admin_init', 'enm_groupsengine_admin_init'); 

function enm_groupsengine_admin_init() {
	
	if ( version_compare( get_bloginfo( 'version' ), '4.7', '<' ) ) {
		register_setting( 
			'enm_groupsengine_options', 
			'enm_groupsengine_options',
			'enm_groupsengine_validate_options' 
		); 
	} else {
		register_setting( 
			'enm_groupsengine_options', 
			'enm_groupsengine_options',
			array( 'sanitize_callback' => 'enm_groupsengine_validate_options') 
		); 
	};
	
	// General Settings
	add_settings_section( 
		'enm_groupsengine_settings', 
		'', 
		'enm_groupsengine_settings_text', 
		'groupsengine_plugin' 
	); 

	// Style Settings
	add_settings_section( 
		'enm_groupsengine_style_settings', 
		'', 
		'enm_groupsengine_style_text', 
		'groupsengine_plugin' 
	); 

	add_settings_section( 
		'enm_groupsengine_search_settings', 
		'', 
		'enm_groupsengine_search_text', 
		'groupsengine_plugin' 
	); 

	add_settings_section( 
		'enm_groupsengine_grouplist_settings', 
		'', 
		'enm_groupsengine_grouplist_text', 
		'groupsengine_plugin' 
	); 

	add_settings_section( 
		'enm_groupsengine_pagination_settings', 
		'', 
		'enm_groupsengine_pagination_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_singlegroup_settings', 
		'', 
		'enm_groupsengine_singlegroup_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_contact_settings', 
		'', 
		'enm_groupsengine_contact_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_sharebox_settings', 
		'', 
		'enm_groupsengine_sharebox_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_update_settings', 
		'', 
		'enm_groupsengine_update_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_loading_settings', 
		'', 
		'enm_groupsengine_loading_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_credits_settings', 
		'', 
		'enm_groupsengine_credits_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_label_settings', 
		'', 
		'enm_groupsengine_label_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_rename_settings', 
		'', 
		'enm_groupsengine_rename_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_advanced_settings', 
		'', 
		'enm_groupsengine_advanced_text', 
		'groupsengine_plugin' 
	);

	add_settings_section( 
		'enm_groupsengine_column_settings', 
		'', 
		'enm_groupsengine_column_text', 
		'groupsengine_plugin' 
	);
	
	// Blank
	add_settings_section( 
		'enm_groupsengine_blank_settings', 
		'', 
		'enm_groupsengine_blank_text', 
		'groupsengine_plugin' 
	);
	
	function enm_groupsengine_settings_text() {
		echo '<div id="enmge-general-settings"><h3>General Settings</h3><p>Use the fields below to modify the core settings of the Groups Engine.</p>';
	};

	function enm_groupsengine_style_text() {
		echo '</div><div id="enmge-style-settings" style="display: none"><h3>Explorer Bar</h3><p>Change styles for the navigation bar and buttons at the top of the Groups Engine browser.</p>';
	};

	function enm_groupsengine_search_text() {
		echo '<h3>Group Search</h3><p>Change styles for the dropdown search menu in the Groups Engine browser.</p>';
	};

	function enm_groupsengine_grouplist_text() {
		echo '<h3>Group List</h3><p>Change styles for the list of groups in the Groups Engine browser.</p>';
	};

	function enm_groupsengine_pagination_text() {
		echo '<h3>Pagination</h3><p>Change styles for the page numbers and navigation at the bottom of the Groups Engine browser.</p>';
	};

	function enm_groupsengine_singlegroup_text() {
		echo '<h3>Single Group</h3><p>Change styles related to the group details view in the Groups Engine browser.</p>';
	};

	function enm_groupsengine_contact_text() {
		echo '<h3>Contact Leader Form</h3><p>Change styles for the contact leader form, error message, and sucess message.</p>';
	};

	function enm_groupsengine_sharebox_text() {
		echo '<h3>Share Link Box</h3><p>Change styles for the "Share Link" popover box from the group details view of the Groups Engine browser.</p>';
	};

	function enm_groupsengine_update_text() {
		echo '<h3>Contact Update Page</h3><p>Change styles for contact update page a group leader sees when clicking a link from their email notification.</p>';
	};

	function enm_groupsengine_loading_text() {
		echo '<h3>Loading Popover</h3><p>Change styles for the loading graphic that appears when AJAX is enabled for the Groups Engine explorer.</p>';
	};

	function enm_groupsengine_credits_text() {
		echo '<h3>Groups Engine Credits</h3><p>Change styles for the Groups Engine credits that appear at the bottom of the Groups Engine browser.</p>';
	};

	function enm_groupsengine_label_text() {
		echo '</div><div id="enmge-label-settings" style="display: none"><h3>Contact Leader Instructions/Success</h3><p>Modify the instructions and success message that users see when contacting a group leader.</p>';
	};

	function enm_groupsengine_rename_text() {
		echo '<h3>Rename Various Elements</h3><p>Rename basic components of the Groups Engine (ie: Groups to Classes, Locations to Campuses, etc). Keep in mind that <strong>this may result in rendering issues</strong> if you switch to longer titles for certain elements.</p>';
	};

	function enm_groupsengine_advanced_text() {
		echo '</div><div id="enmge-archivesection-settings" style="display: none"><h3>Button Widths</h3><p>If you\'ve changed the labels in the plugin, or have overridden the default font with CSS, you may need to change the width of these buttons. Keep in mind that this only effects the desktop view.</p>';
	};

	function enm_groupsengine_column_text() {
		echo '<h3>Group Search Options</h3><p>Specify which columns appear in the Group Search list view and the height of maps on various pages.</p>';
	};
	
	function enm_groupsengine_blank_text() {
		echo '</div>';
	};

	add_settings_field( //Ministry Name
		'enm_groupsengine_ministryname', 
		'Your Ministry\'s Name: <p class="ge-form-instructions">For use on reports and other places throughout the plugin.</p>', 
		'enm_groupsengine_ministryname_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_ministryname_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$ministryname = stripslashes($ge_options['ministryname']);
		echo "<input id=\"ministryname\" name=\"enm_groupsengine_options[ministryname]\" type=\"text\" value=\"{$ministryname}\" size=\"35\" />";
	};

	add_settings_field( //Spam Protection
		'enm_groupsengine_spamprotection', 
		'Enable Spam Protection: <p class="ge-form-instructions">Use a captcha for the leader contact form?</p>', 
		'enm_groupsengine_spamprotection_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_spamprotection_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$spamprotection = $ge_options['spamprotection'];
		if ($spamprotection == 1) {
			echo "<select id='spamprotection' name='enm_groupsengine_options[spamprotection]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($spamprotection == 0 ) {
			echo "<select id='spamprotection' name='enm_groupsengine_options[spamprotection]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='spamprotection' name='enm_groupsengine_options[spamprotection]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( //Enable AJAX
		'enm_groupsengine_ajax', 
		'Enable AJAX Loading?: <p class="ge-form-instructions">Browse groups without reloading the entire page?</p>', 
		'enm_groupsengine_ajax_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_ajax_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$ajax = $ge_options['ajax'];
		if ($ajax == 1) {
			echo "<select id='ajax' name='enm_groupsengine_options[ajax]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($ajax == 0 ) {
			echo "<select id='ajax' name='enm_groupsengine_options[ajax]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='ajax' name='enm_groupsengine_options[ajax]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( //Ministry Name
		'enm_groupsengine_imagewidth', 
		'Group Photo Width: <p class="ge-form-instructions">How wide should photos be in the individual group view?</p>', 
		'enm_groupsengine_imagewidth_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_imagewidth_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$imagewidth = stripslashes($ge_options['imagewidth']);
		echo "<input id=\"imagewidth\" name=\"enm_groupsengine_options[imagewidth]\" type=\"text\" value=\"{$imagewidth}\" size=\"8\" />px";
	};

	add_settings_field( //Email Notifications
		'enm_groupsengine_emailname', 
		'Automated Email Name: <p class="ge-form-instructions">Who should email notifications come from?</p>', 
		'enm_groupsengine_emailname_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_emailname_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$emailname = stripslashes($ge_options['emailname']);
		echo "<input id=\"emailname\" name=\"enm_groupsengine_options[emailname]\" type=\"text\" value=\"{$emailname}\" size=\"35\" />";
	};

	add_settings_field(
		'enm_groupsengine_emailaddress', 
		'Automated Email Address: <p class="ge-form-instructions">Specify a reply-to address. Most use "noreply@..."</p>', 
		'enm_groupsengine_emailaddress_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_emailaddress_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$emailaddress = $ge_options['emailaddress'];
		echo "<input id='emailaddress' name='enm_groupsengine_options[emailaddress]' type='text' value='{$ge_options['emailaddress']}' size='35' />";
	};
	
	add_settings_field( //Google Maps API Key
		'enm_groupsengine_apikey', 
		'Google Maps API Key: <p class="ge-form-instructions">You can get a Google Maps JavaScript <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">API key here</a>.</p>', 
		'enm_groupsengine_apikey_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_apikey_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$apikey = $ge_options['apikey'];
		echo "<input id='apikey' name='enm_groupsengine_options[apikey]' type='text' value='{$ge_options['apikey']}' size='35' />";
	};

	add_settings_field( //Google Maps Server API Key
		'enm_groupsengine_serverapikey', 
		'Google Geocoding API Key: <p class="ge-form-instructions">ADVANCED: Provide a <a href="https://developers.google.com/maps/documentation/geocoding/start#get-a-key" target="_blank">Google Maps API key with the Geocoding API enabled</a> if you\'re <a href="' . admin_url() . 'admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-server' . '">unable to add locations</a> in Groups Engine. (This can be the same key as above).</p>', 
		'enm_groupsengine_serverapikey_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_serverapikey_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$serverapikey = $ge_options['serverapikey'];
		echo "<input id='serverapikey' name='enm_groupsengine_options[serverapikey]' type='text' value='{$ge_options['serverapikey']}' size='35' />";
	};

	add_settings_field( //Default Map Zoom Level
		'enm_groupsengine_zoom', 
		'Default Map Zoom: <p class="ge-form-instructions">Set the default zoom level for your maps, at 1-15.</p>', 
		'enm_groupsengine_zoom_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_zoom_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$zoom = $ge_options['zoom'];
		echo "<input id='zoom' name='enm_groupsengine_options[zoom]' type='text' value='{$ge_options['zoom']}' size='3' />";
	};

	add_settings_field( //Groups Per Page
		'enm_groupsengine_pag', 
		'Number of Groups Page: <p class="ge-form-instructions">How many groups to display per page in group search. You can override this in your embed code.</p>', 
		'enm_groupsengine_pag_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_pag_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$pag = $ge_options['pag'];
		echo "<input id='pag' name='enm_groupsengine_options[pag]' type='text' value='{$ge_options['pag']}' size='3' />";
	};

	add_settings_field( //Default Map Center
		'enm_groupsengine_pointer', 
		'Custom Map Pointer: <p class="ge-form-instructions">Upload a 48x48px .png with a transparent background to use instead of the default red map pin.</p>', 
		'enm_groupsengine_pointer_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_pointer_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$pointer = $ge_options['pointer'];
		if ( $pointer != null ) {
			$pointerimage = "<img src='" . $pointer . "' alt='current pointer image' />";
		} else {
			$pointerimage = null;
		}
		echo "<input id='pointer' name='enm_groupsengine_options[pointer]' type='text' value='{$ge_options['pointer']}' /> &nbsp;<a href='#'' class='enmge-upload-pointer ge-upload-link' id='content-add_media' title='Add Media'><img src='" .  admin_url() . "/images/media-button.png?ver=20111005' width='15' height='15' class='ge-media-button' /> &nbsp;Upload Image</a><input type='hidden' name='enmgearchivethumb' value='48' id='enmgearchivethumb' /> <div id='pointer-load'><br />" . $pointerimage . "</div>";
	};

	add_settings_field( //Default Map Center
		'enm_groupsengine_mapcenter', 
		'Default Map Center: <p class="ge-form-instructions">Postal code for where you want your map to be centered. Will automatically generate lat/long values for the fields below.</p>', 
		'enm_groupsengine_mapcenter_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_mapcenter_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$mapcenter = $ge_options['mapcenter'];
		echo "<input id='mapcenter' name='enm_groupsengine_options[mapcenter]' type='text' value='{$ge_options['mapcenter']}' size='8' /><input id='mapcenterold' name='enm_groupsengine_options[mapcenterold]' type='hidden' value='{$ge_options['mapcenter']}' />";
	};

	add_settings_field( //Map Lat
		'enm_groupsengine_maplat', 
		'Default Map Latitude: <p class="ge-form-instructions">Advanced: Manually edit the map center latitude value if necessary. Changing the postal code will overwrite these edits.</p>', 
		'enm_groupsengine_maplat_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_maplat_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$maplat = $ge_options['maplat'];
		echo "<input id='maplat' name='enm_groupsengine_options[maplat]' type='text' value='{$ge_options['maplat']}' size='12' />";
	};

	add_settings_field( //Map Long
		'enm_groupsengine_maplong', 
		'Default Map Longitude: <p class="ge-form-instructions">Advanced: Manually edit the map center longitude if necessary. Changing the postal code will overwrite these edits.</p>', 
		'enm_groupsengine_maplong_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_settings' 
	);

	function enm_groupsengine_maplong_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$maplong = $ge_options['maplong'];
		echo "<input id='maplong' name='enm_groupsengine_options[maplong]' type='text' value='{$ge_options['maplong']}' size='12' />";
	};

	// General and Group List

	add_settings_field( // Explorer Bar Colors
		'enm_groupsengine_explorerbg_style', 
		'Explore Bar Background:', 
		'enm_groupsengine_explorerbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_style_settings' 
	);
	
	function enm_groupsengine_explorerbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$explorerbg = stripslashes($ge_options['explorerbg']);
		echo "<div id='c-explorerbg' class='ge-colorpicker' style='background-color: #{$explorerbg}'></div>#<input id='explorerbg' name='enm_groupsengine_options[explorerbg]' type='text' value=\"{$explorerbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_exploreactionbg_style', 
		'Search/Contact Background:', 
		'enm_groupsengine_exploreactionbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_style_settings' 
	);
	
	function enm_groupsengine_exploreactionbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$exploreactionbg = stripslashes($ge_options['exploreactionbg']);
		echo "<div id='c-exploreactionbg' class='ge-colorpicker' style='background-color: #{$exploreactionbg}'></div>#<input id='exploreactionbg' name='enm_groupsengine_options[exploreactionbg]' type='text' value=\"{$exploreactionbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_exploreactiontext_style', 
		'Search/Contact Text:', 
		'enm_groupsengine_exploreactiontext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_style_settings' 
	);
	
	function enm_groupsengine_exploreactiontext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$exploreactiontext = stripslashes($ge_options['exploreactiontext']);
		echo "<div id='c-exploreactiontext' class='ge-colorpicker' style='background-color: #{$exploreactiontext}'></div>#<input id='exploreactiontext' name='enm_groupsengine_options[exploreactiontext]' type='text' value=\"{$exploreactiontext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_exploreactionicon_style', 
		'Search/Contact Icon:', 
		'enm_groupsengine_exploreactionicon_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_style_settings' 
	);

	function enm_groupsengine_exploreactionicon_input() { 
		$ge_options = get_option( 'enm_groupsengine_options' );
		$exploreactionicon = $ge_options['exploreactionicon'];
		if ($exploreactionicon == "light") {
			echo "<select id='exploreactionicon' name='enm_groupsengine_options[exploreactionicon]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option></select>";
		} elseif ($exploreactionicon == "dark" ) {
			echo "<select id='exploreactionicon' name='enm_groupsengine_options[exploreactionicon]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option></select>";
		} else {
			echo "<select id='exploreactionicon' name='enm_groupsengine_options[exploreactionicon]'><option value='light'>Light</option><option value='dark'>Dark</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_explorebuttonbg_style', 
		'View/Back Background:', 
		'enm_groupsengine_explorebuttonbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_style_settings' 
	);
	
	function enm_groupsengine_explorebuttonbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$explorebuttonbg = stripslashes($ge_options['explorebuttonbg']);
		echo "<div id='c-explorebuttonbg' class='ge-colorpicker' style='background-color: #{$explorebuttonbg}'></div>#<input id='explorebuttonbg' name='enm_groupsengine_options[explorebuttonbg]' type='text' value=\"{$explorebuttonbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_explorebuttonbgroll_style', 
		'View/Back Background Rollover:', 
		'enm_groupsengine_explorebuttonbgroll_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_style_settings' 
	);
	
	function enm_groupsengine_explorebuttonbgroll_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$explorebuttonbgroll = stripslashes($ge_options['explorebuttonbgroll']);
		echo "<div id='c-explorebuttonbgroll' class='ge-colorpicker' style='background-color: #{$explorebuttonbgroll}'></div>#<input id='explorebuttonbgroll' name='enm_groupsengine_options[explorebuttonbgroll]' type='text' value=\"{$explorebuttonbgroll}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_explorebuttontext_style', 
		'View/Back Text:', 
		'enm_groupsengine_explorebuttontext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_style_settings' 
	);
	
	function enm_groupsengine_explorebuttontext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$explorebuttontext = stripslashes($ge_options['explorebuttontext']);
		echo "<div id='c-explorebuttontext' class='ge-colorpicker' style='background-color: #{$explorebuttontext}'></div>#<input id='explorebuttontext' name='enm_groupsengine_options[explorebuttontext]' type='text' value=\"{$explorebuttontext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_explorebuttonicon_style', 
		'View/Back Icon:', 
		'enm_groupsengine_explorebuttonicon_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_style_settings' 
	);

	function enm_groupsengine_explorebuttonicon_input() { 
		$ge_options = get_option( 'enm_groupsengine_options' );
		$explorebuttonicon = $ge_options['explorebuttonicon'];
		if ($explorebuttonicon == "light") {
			echo "<select id='explorebuttonicon' name='enm_groupsengine_options[explorebuttonicon]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option></select><br /><br />";
		} elseif ($explorebuttonicon == "dark" ) {
			echo "<select id='explorebuttonicon' name='enm_groupsengine_options[explorebuttonicon]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option></select><br /><br />";
		} else {
			echo "<select id='explorebuttonicon' name='enm_groupsengine_options[explorebuttonicon]'><option value='light'>Light</option><option value='dark'>Dark</option></select><br /><br />";
		}
	};

	add_settings_field( // Filter Form Colors
		'enm_groupsengine_filterbg_style', 
		'Search Form Background:', 
		'enm_groupsengine_filterbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_search_settings' 
	);
	
	function enm_groupsengine_filterbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$filterbg = stripslashes($ge_options['filterbg']);
		echo "<div id='c-filterbg' class='ge-colorpicker' style='background-color: #{$filterbg}'></div>#<input id='filterbg' name='enm_groupsengine_options[filterbg]' type='text' value=\"{$filterbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_filtertext_style', 
		'Search Form Label:', 
		'enm_groupsengine_filtertext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_search_settings' 
	);
	
	function enm_groupsengine_filtertext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$filtertext = stripslashes($ge_options['filtertext']);
		echo "<div id='c-filtertext' class='ge-colorpicker' style='background-color: #{$filtertext}'></div>#<input id='filtertext' name='enm_groupsengine_options[filtertext]' type='text' value=\"{$filtertext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_filterfieldbg_style', 
		'Search Form Field Background:', 
		'enm_groupsengine_filterfieldbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_search_settings' 
	);
	
	function enm_groupsengine_filterfieldbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$filterfieldbg = stripslashes($ge_options['filterfieldbg']);
		echo "<div id='c-filterfieldbg' class='ge-colorpicker' style='background-color: #{$filterfieldbg}'></div>#<input id='filterfieldbg' name='enm_groupsengine_options[filterfieldbg]' type='text' value=\"{$filterfieldbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_filterfieldborder_style', 
		'Search Form Field Border:', 
		'enm_groupsengine_filterfieldborder_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_search_settings' 
	);
	
	function enm_groupsengine_filterfieldborder_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$filterfieldborder = stripslashes($ge_options['filterfieldborder']);
		echo "<div id='c-filterfieldborder' class='ge-colorpicker' style='background-color: #{$filterfieldborder}'></div>#<input id='filterfieldborder' name='enm_groupsengine_options[filterfieldborder]' type='text' value=\"{$filterfieldborder}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_filterfieldtext_style', 
		'Search Form Field Text:', 
		'enm_groupsengine_filterfieldtext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_search_settings' 
	);
	
	function enm_groupsengine_filterfieldtext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$filterfieldtext = stripslashes($ge_options['filterfieldtext']);
		echo "<div id='c-filterfieldtext' class='ge-colorpicker' style='background-color: #{$filterfieldtext}'></div>#<input id='filterfieldtext' name='enm_groupsengine_options[filterfieldtext]' type='text' value=\"{$filterfieldtext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_filtersubmitbg_style', 
		'Search Form Submit Background:', 
		'enm_groupsengine_filtersubmitbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_search_settings' 
	);
	
	function enm_groupsengine_filtersubmitbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$filtersubmitbg = stripslashes($ge_options['filtersubmitbg']);
		echo "<div id='c-filtersubmitbg' class='ge-colorpicker' style='background-color: #{$filtersubmitbg}'></div>#<input id='filtersubmitbg' name='enm_groupsengine_options[filtersubmitbg]' type='text' value=\"{$filtersubmitbg}\" size='10' class='ge-colorsubmit' />";
	};

	add_settings_field( 
		'enm_groupsengine_filtersubmittext_style', 
		'Search Form Submit Text:', 
		'enm_groupsengine_filtersubmittext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_search_settings' 
	);
	
	function enm_groupsengine_filtersubmittext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$filtersubmittext = stripslashes($ge_options['filtersubmittext']);
		echo "<div id='c-filtersubmittext' class='ge-colorpicker' style='background-color: #{$filtersubmittext}'></div>#<input id='filtersubmittext' name='enm_groupsengine_options[filtersubmittext]' type='text' value=\"{$filtersubmittext}\" size='10' class='ge-colorfield' /><br /><br />";
	};

	add_settings_field( // Group List
		'enm_groupsengine_grouplistheadertext_style', 
		'Group List Header Text:', 
		'enm_groupsengine_grouplistheadertext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_grouplist_settings' 
	);
	
	function enm_groupsengine_grouplistheadertext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$grouplistheadertext = stripslashes($ge_options['grouplistheadertext']);
		echo "<div id='c-grouplistheadertext' class='ge-colorpicker' style='background-color: #{$grouplistheadertext}'></div>#<input id='grouplistheadertext' name='enm_groupsengine_options[grouplistheadertext]' type='text' value=\"{$grouplistheadertext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_grouplisttext_style', 
		'Group List Text:', 
		'enm_groupsengine_grouplisttext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_grouplist_settings' 
	);
	
	function enm_groupsengine_grouplisttext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$grouplisttext = stripslashes($ge_options['grouplisttext']);
		echo "<div id='c-grouplisttext' class='ge-colorpicker' style='background-color: #{$grouplisttext}'></div>#<input id='grouplisttext' name='enm_groupsengine_options[grouplisttext]' type='text' value=\"{$grouplisttext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_grouplistlink_style', 
		'Group List link:', 
		'enm_groupsengine_grouplistlink_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_grouplist_settings' 
	);
	
	function enm_groupsengine_grouplistlink_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$grouplistlink = stripslashes($ge_options['grouplistlink']);
		echo "<div id='c-grouplistlink' class='ge-colorpicker' style='background-color: #{$grouplistlink}'></div>#<input id='grouplistlink' name='enm_groupsengine_options[grouplistlink]' type='text' value=\"{$grouplistlink}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_grouplistrow_style', 
		'Group List Row:', 
		'enm_groupsengine_grouplistrow_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_grouplist_settings' 
	);
	
	function enm_groupsengine_grouplistrow_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$grouplistrow = stripslashes($ge_options['grouplistrow']);
		echo "<div id='c-grouplistrow' class='ge-colorpicker' style='background-color: #{$grouplistrow}'></div>#<input id='grouplistrow' name='enm_groupsengine_options[grouplistrow]' type='text' value=\"{$grouplistrow}\" size='10' class='ge-colorfield' /><br /><br />";
	};

	add_settings_field( // Pagination
		'enm_groupsengine_pagebuttonbg_style', 
		'Pagination Next/Back Background:', 
		'enm_groupsengine_pagebuttonbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_pagination_settings' 
	);
	
	function enm_groupsengine_pagebuttonbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$pagebuttonbg = stripslashes($ge_options['pagebuttonbg']);
		echo "<div id='c-pagebuttonbg' class='ge-colorpicker' style='background-color: #{$pagebuttonbg}'></div>#<input id='pagebuttonbg' name='enm_groupsengine_options[pagebuttonbg]' type='text' value=\"{$pagebuttonbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_pagebuttontext_style', 
		'Pagination Next/Back Text:', 
		'enm_groupsengine_pagebuttontext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_pagination_settings' 
	);
	
	function enm_groupsengine_pagebuttontext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$pagebuttontext = stripslashes($ge_options['pagebuttontext']);
		echo "<div id='c-pagebuttontext' class='ge-colorpicker' style='background-color: #{$pagebuttontext}'></div>#<input id='pagebuttontext' name='enm_groupsengine_options[pagebuttontext]' type='text' value=\"{$pagebuttontext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_pagenumber_style', 
		'Pagination Page:', 
		'enm_groupsengine_pagenumber_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_pagination_settings' 
	);
	
	function enm_groupsengine_pagenumber_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$pagenumber = stripslashes($ge_options['pagenumber']);
		echo "<div id='c-pagenumber' class='ge-colorpicker' style='background-color: #{$pagenumber}'></div>#<input id='pagenumber' name='enm_groupsengine_options[pagenumber]' type='text' value=\"{$pagenumber}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_pagenumberselectedbg_style', 
		'Pagination Page Selected Background:', 
		'enm_groupsengine_pagenumberselectedbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_pagination_settings' 
	);
	
	function enm_groupsengine_pagenumberselectedbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$pagenumberselectedbg = stripslashes($ge_options['pagenumberselectedbg']);
		echo "<div id='c-pagenumberselectedbg' class='ge-colorpicker' style='background-color: #{$pagenumberselectedbg}'></div>#<input id='pagenumberselectedbg' name='enm_groupsengine_options[pagenumberselectedbg]' type='text' value=\"{$pagenumberselectedbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_pagenumberselectedtext_style', 
		'Pagination Page Selected Text:', 
		'enm_groupsengine_pagenumberselectedtext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_pagination_settings' 
	);
	
	function enm_groupsengine_pagenumberselectedtext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$pagenumberselectedtext = stripslashes($ge_options['pagenumberselectedtext']);
		echo "<div id='c-pagenumberselectedtext' class='ge-colorpicker' style='background-color: #{$pagenumberselectedtext}'></div>#<input id='pagenumberselectedtext' name='enm_groupsengine_options[pagenumberselectedtext]' type='text' value=\"{$pagenumberselectedtext}\" size='10' class='ge-colorfield' /><br /><br />";
	};

	// Single Group

	add_settings_field( // Title and Details
		'enm_groupsengine_singletitle_style', 
		'Single Group Title Text:', 
		'enm_groupsengine_singletitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_singletitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singletitle = stripslashes($ge_options['singletitle']);
		echo "<div id='c-singletitle' class='ge-colorpicker' style='background-color: #{$singletitle}'></div>#<input id='singletitle' name='enm_groupsengine_options[singletitle]' type='text' value=\"{$singletitle}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_singledetails_style', 
		'Single Group Description Text:', 
		'enm_groupsengine_singledetails_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_singledetails_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetails = stripslashes($ge_options['singledetails']);
		echo "<div id='c-singledetails' class='ge-colorpicker' style='background-color: #{$singledetails}'></div>#<input id='singledetails' name='enm_groupsengine_options[singledetails]' type='text' value=\"{$singledetails}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_singledetailsbg_style', 
		'Single Group Details Background:', 
		'enm_groupsengine_singledetailsbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);

	function enm_groupsengine_singledetailsbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetailsbg = stripslashes($ge_options['singledetailsbg']);
		echo "<div id='c-singledetailsbg' class='ge-colorpicker' style='background-color: #{$singledetailsbg}'></div>#<input id='singledetailsbg' name='enm_groupsengine_options[singledetailsbg]' type='text' value=\"{$singledetailsbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_singledetailstext_style', 
		'Single Group Details Text:', 
		'enm_groupsengine_singledetailstext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_singledetailstext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetailstext = stripslashes($ge_options['singledetailstext']);
		echo "<div id='c-singledetailstext' class='ge-colorpicker' style='background-color: #{$singledetailstext}'></div>#<input id='singledetailstext' name='enm_groupsengine_options[singledetailstext]' type='text' value=\"{$singledetailstext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_singledetailslink_style', 
		'Single Group Details Link:', 
		'enm_groupsengine_singledetailslink_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_singledetailslink_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetailslink = stripslashes($ge_options['singledetailslink']);
		echo "<div id='c-singledetailslink' class='ge-colorpicker' style='background-color: #{$singledetailslink}'></div>#<input id='singledetailslink' name='enm_groupsengine_options[singledetailslink]' type='text' value=\"{$singledetailslink}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_singledetailslabel_style', 
		'Single Group Details Label:', 
		'enm_groupsengine_singledetailslabel_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_singledetailslabel_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetailslabel = stripslashes($ge_options['singledetailslabel']);
		echo "<div id='c-singledetailslabel' class='ge-colorpicker' style='background-color: #{$singledetailslabel}'></div>#<input id='singledetailslabel' name='enm_groupsengine_options[singledetailslabel]' type='text' value=\"{$singledetailslabel}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( // Share Buttons
		'enm_groupsengine_singledetailssharebg_style', 
		'Single Group Share Button Background:', 
		'enm_groupsengine_singledetailssharebg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_singledetailssharebg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetailssharebg = stripslashes($ge_options['singledetailssharebg']);
		echo "<div id='c-singledetailssharebg' class='ge-colorpicker' style='background-color: #{$singledetailssharebg}'></div>#<input id='singledetailssharebg' name='enm_groupsengine_options[singledetailssharebg]' type='text' value=\"{$singledetailssharebg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field(
		'enm_groupsengine_singledetailssharebgroll_style', 
		'Single Group Share Button Background Rollover:', 
		'enm_groupsengine_singledetailssharebgroll_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_singledetailssharebgroll_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetailssharebgroll = stripslashes($ge_options['singledetailssharebgroll']);
		echo "<div id='c-singledetailssharebgroll' class='ge-colorpicker' style='background-color: #{$singledetailssharebgroll}'></div>#<input id='singledetailssharebgroll' name='enm_groupsengine_options[singledetailssharebgroll]' type='text' value=\"{$singledetailssharebgroll}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_singledetailssharetext_style', 
		'Single Group Share Button Text:', 
		'enm_groupsengine_singledetailssharetext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_singledetailssharetext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetailssharetext = stripslashes($ge_options['singledetailssharetext']);
		echo "<div id='c-singledetailssharetext' class='ge-colorpicker' style='background-color: #{$singledetailssharetext}'></div>#<input id='singledetailssharetext' name='enm_groupsengine_options[singledetailssharetext]' type='text' value=\"{$singledetailssharetext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_singledetailsshareicon_style', 
		'Single Group Share Button Icon:', 
		'enm_groupsengine_singledetailsshareicon_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);

	function enm_groupsengine_singledetailsshareicon_input() { 
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singledetailsshareicon = $ge_options['singledetailsshareicon'];
		if ($singledetailsshareicon == "light") {
			echo "<select id='singledetailsshareicon' name='enm_groupsengine_options[singledetailsshareicon]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option></select>";
		} elseif ($singledetailsshareicon == "dark" ) {
			echo "<select id='singledetailsshareicon' name='enm_groupsengine_options[singledetailsshareicon]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option></select>";
		} else {
			echo "<select id='singledetailsshareicon' name='enm_groupsengine_options[singledetailsshareicon]'><option value='light'>Light</option><option value='dark'>Dark</option></select>";
		}
	};

	add_settings_field( // Related items
		'enm_groupsengine_relatedbg_style', 
		'Related Items Background:', 
		'enm_groupsengine_relatedbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_relatedbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$relatedbg = stripslashes($ge_options['relatedbg']);
		echo "<div id='c-relatedbg' class='ge-colorpicker' style='background-color: #{$relatedbg}'></div>#<input id='relatedbg' name='enm_groupsengine_options[relatedbg]' type='text' value=\"{$relatedbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_relatedtext_style', 
		'Related Items Text:', 
		'enm_groupsengine_relatedtext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_relatedtext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$relatedtext = stripslashes($ge_options['relatedtext']);
		echo "<div id='c-relatedtext' class='ge-colorpicker' style='background-color: #{$relatedtext}'></div>#<input id='relatedtext' name='enm_groupsengine_options[relatedtext]' type='text' value=\"{$relatedtext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_relatedlink_style', 
		'Related Items Links:', 
		'enm_groupsengine_relatedlink_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_singlegroup_settings' 
	);
	
	function enm_groupsengine_relatedlink_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$relatedlink = stripslashes($ge_options['relatedlink']);
		echo "<div id='c-relatedlink' class='ge-colorpicker' style='background-color: #{$relatedlink}'></div>#<input id='relatedlink' name='enm_groupsengine_options[relatedlink]' type='text' value=\"{$relatedlink}\" size='10' class='ge-colorfield' /><br /><br />";
	};

	// Contact Leader Page

	add_settings_field( 
		'enm_groupsengine_contacttitle_style', 
		'Contact Leader Title Text:', 
		'enm_groupsengine_contacttitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_contacttitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contacttitle = stripslashes($ge_options['contacttitle']);
		echo "<div id='c-contacttitle' class='ge-colorpicker' style='background-color: #{$contacttitle}'></div>#<input id='contacttitle' name='enm_groupsengine_options[contacttitle]' type='text' value=\"{$contacttitle}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_contactinstructionstext_style', 
		'Contact Leader Instructions Text:', 
		'enm_groupsengine_contactinstructionstext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_contactinstructionstext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactinstructionstext = stripslashes($ge_options['contactinstructionstext']);
		echo "<div id='c-contactinstructionstext' class='ge-colorpicker' style='background-color: #{$contactinstructionstext}'></div>#<input id='contactinstructionstext' name='enm_groupsengine_options[contactinstructionstext]' type='text' value=\"{$contactinstructionstext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_contactformlabel_style', 
		'Contact Leader Form Label:', 
		'enm_groupsengine_contactformlabel_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_contactformlabel_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactformlabel = stripslashes($ge_options['contactformlabel']);
		echo "<div id='c-contactformlabel' class='ge-colorpicker' style='background-color: #{$contactformlabel}'></div>#<input id='contactformlabel' name='enm_groupsengine_options[contactformlabel]' type='text' value=\"{$contactformlabel}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_contactformfieldbg_style', 
		'Contact Leader Form Field Background:', 
		'enm_groupsengine_contactformfieldbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_contactformfieldbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactformfieldbg = stripslashes($ge_options['contactformfieldbg']);
		echo "<div id='c-contactformfieldbg' class='ge-colorpicker' style='background-color: #{$contactformfieldbg}'></div>#<input id='contactformfieldbg' name='enm_groupsengine_options[contactformfieldbg]' type='text' value=\"{$contactformfieldbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_contactformfieldtext_style', 
		'Contact Leader Form Field Text:', 
		'enm_groupsengine_contactformfieldtext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_contactformfieldtext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactformfieldtext = stripslashes($ge_options['contactformfieldtext']);
		echo "<div id='c-contactformfieldtext' class='ge-colorpicker' style='background-color: #{$contactformfieldtext}'></div>#<input id='contactformfieldtext' name='enm_groupsengine_options[contactformfieldtext]' type='text' value=\"{$contactformfieldtext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_contactformsubmitbg_style', 
		'Contact Leader Form Submit Background:', 
		'enm_groupsengine_contactformsubmitbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_contactformsubmitbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactformsubmitbg = stripslashes($ge_options['contactformsubmitbg']);
		echo "<div id='c-contactformsubmitbg' class='ge-colorpicker' style='background-color: #{$contactformsubmitbg}'></div>#<input id='contactformsubmitbg' name='enm_groupsengine_options[contactformsubmitbg]' type='text' value=\"{$contactformsubmitbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_contactformsubmittext_style', 
		'Contact Leader Form Submit Text:', 
		'enm_groupsengine_contactformsubmittext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_contactformsubmittext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactformsubmittext = stripslashes($ge_options['contactformsubmittext']);
		echo "<div id='c-contactformsubmittext' class='ge-colorpicker' style='background-color: #{$contactformsubmittext}'></div>#<input id='contactformsubmittext' name='enm_groupsengine_options[contactformsubmittext]' type='text' value=\"{$contactformsubmittext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_errorbg_style', 
		'Contact Leader Error Background:', 
		'enm_groupsengine_errorbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_errorbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$errorbg = stripslashes($ge_options['errorbg']);
		echo "<div id='c-errorbg' class='ge-colorpicker' style='background-color: #{$errorbg}'></div>#<input id='errorbg' name='enm_groupsengine_options[errorbg]' type='text' value=\"{$errorbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_errortext_style', 
		'Contact Leader Error Text:', 
		'enm_groupsengine_errortext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_errortext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$errortext = stripslashes($ge_options['errortext']);
		echo "<div id='c-errortext' class='ge-colorpicker' style='background-color: #{$errortext}'></div>#<input id='errortext' name='enm_groupsengine_options[errortext]' type='text' value=\"{$errortext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_successbg_style', 
		'Contact Leader Success Background:', 
		'enm_groupsengine_successbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_successbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$successbg = stripslashes($ge_options['successbg']);
		echo "<div id='c-successbg' class='ge-colorpicker' style='background-color: #{$successbg}'></div>#<input id='successbg' name='enm_groupsengine_options[successbg]' type='text' value=\"{$successbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_successtext_style', 
		'Contact Leader Success Text:', 
		'enm_groupsengine_successtext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_contact_settings' 
	);
	
	function enm_groupsengine_successtext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$successtext = stripslashes($ge_options['successtext']);
		echo "<div id='c-successtext' class='ge-colorpicker' style='background-color: #{$successtext}'></div>#<input id='successtext' name='enm_groupsengine_options[successtext]' type='text' value=\"{$successtext}\" size='10' class='ge-colorfield' /><br /><br />";
	};

	add_settings_field( // Share Link Box
		'enm_groupsengine_shareboxbg_style', 
		'Share Link Background:', 
		'enm_groupsengine_shareboxbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_sharebox_settings' 
	);
	
	function enm_groupsengine_shareboxbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$shareboxbg = stripslashes($ge_options['shareboxbg']);
		echo "<div id='c-shareboxbg' class='ge-colorpicker' style='background-color: #{$shareboxbg}'></div>#<input id='shareboxbg' name='enm_groupsengine_options[shareboxbg]' type='text' value=\"{$shareboxbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field(
		'enm_groupsengine_shareboxtext_style', 
		'Share Link Text:', 
		'enm_groupsengine_shareboxtext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_sharebox_settings' 
	);
	
	function enm_groupsengine_shareboxtext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$shareboxtext = stripslashes($ge_options['shareboxtext']);
		echo "<div id='c-shareboxtext' class='ge-colorpicker' style='background-color: #{$shareboxtext}'></div>#<input id='shareboxtext' name='enm_groupsengine_options[shareboxtext]' type='text' value=\"{$shareboxtext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field(
		'enm_groupsengine_shareboxbuttonbg_style', 
		'Share Link Confirm Background:', 
		'enm_groupsengine_shareboxbuttonbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_sharebox_settings' 
	);
	
	function enm_groupsengine_shareboxbuttonbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$shareboxbuttonbg = stripslashes($ge_options['shareboxbuttonbg']);
		echo "<div id='c-shareboxbuttonbg' class='ge-colorpicker' style='background-color: #{$shareboxbuttonbg}'></div>#<input id='shareboxbuttonbg' name='enm_groupsengine_options[shareboxbuttonbg]' type='text' value=\"{$shareboxbuttonbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field(
		'enm_groupsengine_shareboxbuttontext_style', 
		'Share Link Confirm Text:', 
		'enm_groupsengine_shareboxbuttontext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_sharebox_settings' 
	);
	
	function enm_groupsengine_shareboxbuttontext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$shareboxbuttontext = stripslashes($ge_options['shareboxbuttontext']);
		echo "<div id='c-shareboxbuttontext' class='ge-colorpicker' style='background-color: #{$shareboxbuttontext}'></div>#<input id='shareboxbuttontext' name='enm_groupsengine_options[shareboxbuttontext]' type='text' value=\"{$shareboxbuttontext}\" size='10' class='ge-colorfield' /><br /><br />";
	};

	add_settings_field( // Update Group Contact
		'enm_groupsengine_updatebg_style', 
		'Page Background:', 
		'enm_groupsengine_updatebg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updatebg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updatebg = stripslashes($ge_options['updatebg']);
		echo "<div id='c-updatebg' class='ge-colorpicker' style='background-color: #{$updatebg}'></div>#<input id='updatebg' name='enm_groupsengine_options[updatebg]' type='text' value=\"{$updatebg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updatetext_style', 
		'Page Text:', 
		'enm_groupsengine_updatetext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updatetext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updatetext = stripslashes($ge_options['updatetext']);
		echo "<div id='c-updatetext' class='ge-colorpicker' style='background-color: #{$updatetext}'></div>#<input id='updatetext' name='enm_groupsengine_options[updatetext]' type='text' value=\"{$updatetext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updatestatustext_style', 
		'Status Color:', 
		'enm_groupsengine_updatestatustext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updatestatustext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updatestatustext = stripslashes($ge_options['updatestatustext']);
		echo "<div id='c-updatestatustext' class='ge-colorpicker' style='background-color: #{$updatestatustext}'></div>#<input id='updatestatustext' name='enm_groupsengine_options[updatestatustext]' type='text' value=\"{$updatestatustext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updatelink_style', 
		'Link Colors:', 
		'enm_groupsengine_updatelink_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updatelink_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updatelink = stripslashes($ge_options['updatelink']);
		echo "<div id='c-updatelink' class='ge-colorpicker' style='background-color: #{$updatelink}'></div>#<input id='updatelink' name='enm_groupsengine_options[updatelink]' type='text' value=\"{$updatelink}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updatenotebg_style', 
		'Notes Box Background:', 
		'enm_groupsengine_updatenotebg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updatenotebg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updatenotebg = stripslashes($ge_options['updatenotebg']);
		echo "<div id='c-updatenotebg' class='ge-colorpicker' style='background-color: #{$updatenotebg}'></div>#<input id='updatenotebg' name='enm_groupsengine_options[updatenotebg]' type='text' value=\"{$updatenotebg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updatenotetext_style', 
		'Notes Box Text:', 
		'enm_groupsengine_updatenotetext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updatenotetext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updatenotetext = stripslashes($ge_options['updatenotetext']);
		echo "<div id='c-updatenotetext' class='ge-colorpicker' style='background-color: #{$updatenotetext}'></div>#<input id='updatenotetext' name='enm_groupsengine_options[updatenotetext]' type='text' value=\"{$updatenotetext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updateformfieldbg_style', 
		'Update Form Field Background:', 
		'enm_groupsengine_updateformfieldbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updateformfieldbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updateformfieldbg = stripslashes($ge_options['updateformfieldbg']);
		echo "<div id='c-updateformfieldbg' class='ge-colorpicker' style='background-color: #{$updateformfieldbg}'></div>#<input id='updateformfieldbg' name='enm_groupsengine_options[updateformfieldbg]' type='text' value=\"{$updateformfieldbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updateformfieldtext_style', 
		'Update Form Field Text:', 
		'enm_groupsengine_updateformfieldtext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updateformfieldtext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updateformfieldtext = stripslashes($ge_options['updateformfieldtext']);
		echo "<div id='c-updateformfieldtext' class='ge-colorpicker' style='background-color: #{$updateformfieldtext}'></div>#<input id='updateformfieldtext' name='enm_groupsengine_options[updateformfieldtext]' type='text' value=\"{$updateformfieldtext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updateformsubmitbg_style', 
		'Update Form Submit Background:', 
		'enm_groupsengine_updateformsubmitbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updateformsubmitbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updateformsubmitbg = stripslashes($ge_options['updateformsubmitbg']);
		echo "<div id='c-updateformsubmitbg' class='ge-colorpicker' style='background-color: #{$updateformsubmitbg}'></div>#<input id='updateformsubmitbg' name='enm_groupsengine_options[updateformsubmitbg]' type='text' value=\"{$updateformsubmitbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_updateformsubmittext_style', 
		'Update Form Submit Text:', 
		'enm_groupsengine_updateformsubmittext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_update_settings' 
	);
	
	function enm_groupsengine_updateformsubmittext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$updateformsubmittext = stripslashes($ge_options['updateformsubmittext']);
		echo "<div id='c-updateformsubmittext' class='ge-colorpicker' style='background-color: #{$updateformsubmittext}'></div>#<input id='updateformsubmittext' name='enm_groupsengine_options[updateformsubmittext]' type='text' value=\"{$updateformsubmittext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( // Loading Icon
		'enm_groupsengine_loadingbg_style', 
		'Loading Popover Background:', 
		'enm_groupsengine_loadingbg_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_loading_settings' 
	);
	
	function enm_groupsengine_loadingbg_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$loadingbg = stripslashes($ge_options['loadingbg']);
		echo "<div id='c-loadingbg' class='ge-colorpicker' style='background-color: #{$loadingbg}'></div>#<input id='loadingbg' name='enm_groupsengine_options[loadingbg]' type='text' value=\"{$loadingbg}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_loadingtext_style', 
		'Loading Popover Text:', 
		'enm_groupsengine_loadingtext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_loading_settings' 
	);
	
	function enm_groupsengine_loadingtext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$loadingtext = stripslashes($ge_options['loadingtext']);
		echo "<div id='c-loadingtext' class='ge-colorpicker' style='background-color: #{$loadingtext}'></div>#<input id='loadingtext' name='enm_groupsengine_options[loadingtext]' type='text' value=\"{$loadingtext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( 
		'enm_groupsengine_loadingicon_style', 
		'Loading Popover Icon:', 
		'enm_groupsengine_loadingicon_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_loading_settings' 
	);

	function enm_groupsengine_loadingicon_input() { 
		$ge_options = get_option( 'enm_groupsengine_options' );
		$loadingicon = $ge_options['loadingicon'];
		if ($loadingicon == "light") {
			echo "<select id='loadingicon' name='enm_groupsengine_options[loadingicon]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option></select>";
		} elseif ($loadingicon == "dark" ) {
			echo "<select id='loadingicon' name='enm_groupsengine_options[loadingicon]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option></select>";
		} else {
			echo "<select id='loadingicon' name='enm_groupsengine_options[loadingicon]'><option value='light'>Light</option><option value='dark'>Dark</option></select>";
		}
	};

	add_settings_field( //Default Map Center
		'enm_groupsengine_customloading', 
		'Custom Loading Icon: <p class="ge-form-instructions">Upload a 54x55 PNG with a transparent background.</p>', 
		'enm_groupsengine_customloading_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_loading_settings' 
	);

	function enm_groupsengine_customloading_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$customloading = $ge_options['customloading'];
		if ( $customloading != null ) {
			$customloadingimage = "<img src='" . $customloading . "' alt='current customloading image' />";
		} else {
			$customloadingimage = null;
		}
		echo "<input id='customloading' name='enm_groupsengine_options[customloading]' type='text' value='{$ge_options['customloading']}' /> &nbsp;<a href='#'' class='enmge-upload-customloading ge-upload-link' id='content-add_media' title='Add Media'><img src='" .  admin_url() . "/images/media-button.png?ver=20111005' width='15' height='15' class='ge-media-button' /> &nbsp;Upload Image</a> <div id='customloading-load'><br />" . $customloadingimage . "</div>";
	};

	add_settings_field( //Default Map Center
		'enm_groupsengine_customloadingretina', 
		'Custom Loading Icon (Retina): <p class="ge-form-instructions">Upload a 108x110 PNG with a transparent background for users with high density displays.</p>', 
		'enm_groupsengine_customloadingretina_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_loading_settings' 
	);

	function enm_groupsengine_customloadingretina_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$customloadingretina = $ge_options['customloadingretina'];
		if ( $customloadingretina != null ) {
			$customloadingretinaimage = "<img src='" . $customloadingretina . "' alt='current customloadingretina image' />";
		} else {
			$customloadingretinaimage = null;
		}
		echo "<input id='customloadingretina' name='enm_groupsengine_options[customloadingretina]' type='text' value='{$ge_options['customloadingretina']}' /> &nbsp;<a href='#'' class='enmge-upload-customloadingretina ge-upload-link' id='content-add_media' title='Add Media'><img src='" .  admin_url() . "/images/media-button.png?ver=20111005' width='15' height='15' class='ge-media-button' /> &nbsp;Upload Image</a> <div id='customloadingretina-load'><br />" . $customloadingretinaimage . "</div>";
	};

	add_settings_field( 
		'enm_groupsengine_credits_style', 
		'Groups Engine Icon:', 
		'enm_groupsengine_credits_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_credits_settings' 
	);

	function enm_groupsengine_credits_input() { 
		$ge_options = get_option( 'enm_groupsengine_options' );
		$credits = $ge_options['credits'];
		if ($credits == "light") {
			echo "<select id='credits' name='enm_groupsengine_options[credits]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option><option value='text'>Text Only</option></select>";
		} elseif ($credits == "dark" ) {
			echo "<select id='credits' name='enm_groupsengine_options[credits]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option><option value='text'>Text Only</option></select>";
		} else {
			echo "<select id='credits' name='enm_groupsengine_options[credits]'><option value='light'>Light</option><option value='dark'>Dark</option><option value='text' selected='selected'>Text Only</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_creditstext_style', 
		'Credits Text:', 
		'enm_groupsengine_creditstext_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_credits_settings' 
	);
	
	function enm_groupsengine_creditstext_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$creditstext = stripslashes($ge_options['creditstext']);
		echo "<div id='c-creditstext' class='ge-colorpicker' style='background-color: #{$creditstext}'></div>#<input id='creditstext' name='enm_groupsengine_options[creditstext]' type='text' value=\"{$creditstext}\" size='10' class='ge-colorfield' />";
	};

	add_settings_field( // Labels
		'enm_groupsengine_contact_instructions', 
		'Instructions for Contacting Group Leaders:', 
		'enm_groupsengine_contact_instructions_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_label_settings' 
	);

	function enm_groupsengine_contact_instructions_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactinstructions = stripslashes($ge_options['contactinstructions']);
		echo "<textarea name=\"enm_groupsengine_options[contactinstructions]\" rows=\"5\" cols=\"40\">{$contactinstructions}</textarea><br /><br />";
	};

	add_settings_field(
		'enm_groupsengine_contact_success', 
		'Contact Sent Success Message:', 
		'enm_groupsengine_contact_success_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_label_settings' 
	);

	function enm_groupsengine_contact_success_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactsuccess = stripslashes($ge_options['contactsuccess']);
		echo "<textarea name=\"enm_groupsengine_options[contactsuccess]\" rows=\"5\" cols=\"40\">{$contactsuccess}</textarea><br /><br />";
	};

	add_settings_field(
		'enm_groupsengine_nogroups', 
		'No Results Found Message:', 
		'enm_groupsengine_nogroups_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_label_settings' 
	);

	function enm_groupsengine_nogroups_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$nogroups = stripslashes($ge_options['nogroups']);
		if ( !isset($ge_options['nogroups']) ) {
			echo "<textarea name=\"enm_groupsengine_options[nogroups]\" rows=\"5\" cols=\"40\">No Groups are currently available that match this search criteria. Please search again using the options above.</textarea><br /><br />";
		} else {
			echo "<textarea name=\"enm_groupsengine_options[nogroups]\" rows=\"5\" cols=\"40\">{$nogroups}</textarea><br /><br />";
		};
	};

	add_settings_field( // Group Title
		'enm_groupsengine_grouptitle', 
		'Group: <p class="ge-form-instructions">Labels longer than <strong>10 characters</strong> might cause rendering issues.</p>', 
		'enm_groupsengine_grouptitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_grouptitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$grouptitle = stripslashes($ge_options['grouptitle']);
		echo "<input id=\"grouptitle\" name=\"enm_groupsengine_options[grouptitle]\" type=\"text\" value=\"{$grouptitle}\" size=\"10\" />";
	};

	add_settings_field( 
		'enm_groupsengine_groupptitle', 
		'Groups: <p class="ge-form-instructions">Labels longer than <strong>10 characters</strong> might cause rendering issues.</p>', 
		'enm_groupsengine_groupptitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_groupptitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$groupptitle = stripslashes($ge_options['groupptitle']);
		echo "<input id=\"groupptitle\" name=\"enm_groupsengine_options[groupptitle]\" type=\"text\" value=\"{$groupptitle}\" size=\"10\" />";
	};

	add_settings_field( // Group Type
		'enm_groupsengine_grouptypetitle', 
		'Group Type: <p class="ge-form-instructions">Labels longer than <strong>10 characters</strong> might cause rendering issues.</p>', 
		'enm_groupsengine_grouptypetitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_grouptypetitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$grouptypetitle = stripslashes($ge_options['grouptypetitle']);
		echo "<input id=\"grouptypetitle\" name=\"enm_groupsengine_options[grouptypetitle]\" type=\"text\" value=\"{$grouptypetitle}\" size=\"10\" />";
	};

	add_settings_field( 
		'enm_groupsengine_grouptypeptitle', 
		'Group Types: <p class="ge-form-instructions">Labels longer than <strong>11 characters</strong> might cause rendering issues.</p>', 
		'enm_groupsengine_grouptypeptitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_grouptypeptitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$grouptypeptitle = stripslashes($ge_options['grouptypeptitle']);
		echo "<input id=\"grouptypeptitle\" name=\"enm_groupsengine_options[grouptypeptitle]\" type=\"text\" value=\"{$grouptypeptitle}\" size=\"10\" />";
	};

	add_settings_field( // Locations
		'enm_groupsengine_locationtitle', 
		'Location: <p class="ge-form-instructions">Labels longer than <strong>10 characters</strong> might cause rendering issues.</p>', 
		'enm_groupsengine_locationtitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_locationtitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$locationtitle = stripslashes($ge_options['locationtitle']);
		echo "<input id=\"locationtitle\" name=\"enm_groupsengine_options[locationtitle]\" type=\"text\" value=\"{$locationtitle}\" size=\"10\" />";
	};

	add_settings_field( 
		'enm_groupsengine_locationptitle', 
		'Locations: <p class="ge-form-instructions">Labels longer than <strong>10 characters</strong> might cause rendering issues.</p>', 
		'enm_groupsengine_locationptitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_locationptitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$locationptitle = stripslashes($ge_options['locationptitle']);
		echo "<input id=\"locationptitle\" name=\"enm_groupsengine_options[locationptitle]\" type=\"text\" value=\"{$locationptitle}\" size=\"10\" />";
	};

	add_settings_field( // Topics
		'enm_groupsengine_topictitle', 
		'Topic: <p class="ge-form-instructions">Labels longer than <strong>10 characters</strong> might cause rendering issues.</p>', 
		'enm_groupsengine_topictitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_topictitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$topictitle = stripslashes($ge_options['topictitle']);
		echo "<input id=\"topictitle\" name=\"enm_groupsengine_options[topictitle]\" type=\"text\" value=\"{$topictitle}\" size=\"10\" />";
	};

	add_settings_field( 
		'enm_groupsengine_topicptitle', 
		'Topics: <p class="ge-form-instructions">Labels longer than <strong>10 characters</strong> might cause rendering issues.</p>', 
		'enm_groupsengine_topicptitle_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_topicptitle_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$topicptitle = stripslashes($ge_options['topicptitle']);
		echo "<input id=\"topicptitle\" name=\"enm_groupsengine_options[topicptitle]\" type=\"text\" value=\"{$topicptitle}\" size=\"10\" />";
	};

	add_settings_field( 
		'enm_groupsengine_offsite', 
		'Offsite: <p class="ge-form-instructions">The label that appears in parenthesis beside offsite groups in the group list.</p>', 
		'enm_groupsengine_offsite_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_offsite_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$offsite = stripslashes($ge_options['offsite']);
		echo "<input id=\"offsite\" name=\"enm_groupsengine_options[offsite]\" type=\"text\" value=\"{$offsite}\" size=\"10\" />";
	};

	add_settings_field( 
		'enm_groupsengine_childcare', 
		'Childcare Available?: <p class="ge-form-instructions">The text that appears beside childcare details in the single group view.</p>', 
		'enm_groupsengine_childcare_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_childcare_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$childcare = stripslashes($ge_options['childcare']);
		echo "<input id=\"childcare\" name=\"enm_groupsengine_options[childcare]\" type=\"text\" value=\"{$childcare}\" size=\"18\" />";
	};

	add_settings_field( 
		'enm_groupsengine_searchbuttonlabel', 
		'Search Available Groups: <p class="ge-form-instructions">The button that reveals the group search form. Part of this label is fixed. You may also need to change the width of this button.</p>', 
		'enm_groupsengine_searchbuttonlabel_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_searchbuttonlabel_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$searchbuttonlabel = stripslashes($ge_options['searchbuttonlabel']);
		if ( !isset($ge_options['searchbuttonlabel']) ) {
			echo "Search <input id=\"searchbuttonlabel\" name=\"enm_groupsengine_options[searchbuttonlabel]\" type=\"text\" value=\"Available Groups\" size=\"18\" />";
		} else {
			echo "Search <input id=\"searchbuttonlabel\" name=\"enm_groupsengine_options[searchbuttonlabel]\" type=\"text\" value=\"{$searchbuttonlabel}\" size=\"18\" />";
		}
	};

	add_settings_field( 
		'enm_groupsengine_contactbuttonlabel', 
		'Contact Group Leader: <p class="ge-form-instructions">The button that opens the leader contact form, and the title on that page. Part of this label is fixed. You may also need to change the width of this button.</p>', 
		'enm_groupsengine_contactbuttonlabel_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_rename_settings' 
	);

	function enm_groupsengine_contactbuttonlabel_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactbuttonlabel = stripslashes($ge_options['contactbuttonlabel']);
		if ( !isset($ge_options['contactbuttonlabel']) ) {
			echo "Contact <input id=\"contactbuttonlabel\" name=\"enm_groupsengine_options[contactbuttonlabel]\" type=\"text\" value=\"Group Leader\" size=\"18\" />";
		} else {
			echo "Contact <input id=\"contactbuttonlabel\" name=\"enm_groupsengine_options[contactbuttonlabel]\" type=\"text\" value=\"{$contactbuttonlabel}\" size=\"18\" />";
		}
	};

	add_settings_field( // Button Widths
		'enm_groupsengine_searchwidth', 
		'Search Button: <p class="ge-form-instructions">The button that toggles the group search form.</p>', 
		'enm_groupsengine_searchwidth_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_advanced_settings' 
	);

	function enm_groupsengine_searchwidth_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$searchwidth = $ge_options['searchwidth'];
		echo "<input id='searchwidth' name='enm_groupsengine_options[searchwidth]' type='text' value='{$ge_options['searchwidth']}' size='5' />px";
	};

	add_settings_field( 
		'enm_groupsengine_backsearchwidth', 
		'Back to Search Button: <p class="ge-form-instructions">The button that returns users to search from the group details view.</p>', 
		'enm_groupsengine_backsearchwidth_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_advanced_settings' 
	);

	function enm_groupsengine_backsearchwidth_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$backsearchwidth = $ge_options['backsearchwidth'];
		echo "<input id='backsearchwidth' name='enm_groupsengine_options[backsearchwidth]' type='text' value='{$ge_options['backsearchwidth']}' size='5' />px";
	};

	add_settings_field( 
		'enm_groupsengine_contactwidth', 
		'Contact Group Leader Button: <p class="ge-form-instructions">The button seen in the top right of the group details view.</p>', 
		'enm_groupsengine_contactwidth_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_advanced_settings' 
	);

	function enm_groupsengine_contactwidth_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$contactwidth = $ge_options['contactwidth'];
		echo "<input id='contactwidth' name='enm_groupsengine_options[contactwidth]' type='text' value='{$ge_options['contactwidth']}' size='5' />px";
	};

	add_settings_field( 
		'enm_groupsengine_backgroupwidth', 
		'Back to Group Button: <p class="ge-form-instructions">The button that returns users to the group details view from the contact leader view.</p>', 
		'enm_groupsengine_backgroupwidth_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_advanced_settings' 
	);

	function enm_groupsengine_backgroupwidth_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$backgroupwidth = $ge_options['backgroupwidth'];
		echo "<input id='backgroupwidth' name='enm_groupsengine_options[backgroupwidth]' type='text' value='{$ge_options['backgroupwidth']}' size='5' />px";
	};

	add_settings_field( //Show Columns in Group Search
		'enm_groupsengine_showday', 
		'Show Day Column?: <p class="ge-form-instructions">Display the Day column in the Group Search list.</p>', 
		'enm_groupsengine_showday_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showday_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showday = $ge_options['showday'];
		if ($showday == 1) {
			echo "<select id='showday' name='enm_groupsengine_options[showday]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showday == 0 ) {
			echo "<select id='showday' name='enm_groupsengine_options[showday]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showday' name='enm_groupsengine_options[showday]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_showtime', 
		'Show Time Column?: <p class="ge-form-instructions">Display the Time column in the Group Search list.</p>', 
		'enm_groupsengine_showtime_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showtime_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showtime = $ge_options['showtime'];
		if ($showtime == 1) {
			echo "<select id='showtime' name='enm_groupsengine_options[showtime]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showtime == 0 ) {
			echo "<select id='showtime' name='enm_groupsengine_options[showtime]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showtime' name='enm_groupsengine_options[showtime]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_showages', 
		'Show Ages Column?: <p class="ge-form-instructions">Display the Ages column in the Group Search list.</p>', 
		'enm_groupsengine_showages_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showages_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showages = $ge_options['showages'];
		if ($showages == 1) {
			echo "<select id='showages' name='enm_groupsengine_options[showages]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showages == 0 ) {
			echo "<select id='showages' name='enm_groupsengine_options[showages]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showages' name='enm_groupsengine_options[showages]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_showlocations', 
		'Show Location Column?: <p class="ge-form-instructions">Display the Location (places the Group is associated with) column in the Group Search list.</p>', 
		'enm_groupsengine_showlocations_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showlocations_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showlocations = $ge_options['showlocations'];
		if ($showlocations == 1) {
			echo "<select id='showlocations' name='enm_groupsengine_options[showlocations]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showlocations == 0 ) {
			echo "<select id='showlocations' name='enm_groupsengine_options[showlocations]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showlocations' name='enm_groupsengine_options[showlocations]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_showlocation', 
		'Show Location (Meeting at) Column?: <p class="ge-form-instructions">Display the Location (specific place where the Group meets) column in the Group Search list.</p>', 
		'enm_groupsengine_showlocation_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showlocation_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showlocation = $ge_options['showlocation'];
		if ($showlocation == 1) {
			echo "<select id='showlocation' name='enm_groupsengine_options[showlocation]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showlocation == 0 ) {
			echo "<select id='showlocation' name='enm_groupsengine_options[showlocation]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showlocation' name='enm_groupsengine_options[showlocation]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_showtopic', 
		'Show Topic Column?: <p class="ge-form-instructions">Display the Topic column in the Group Search list.</p>', 
		'enm_groupsengine_showtopic_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showtopic_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showtopic = $ge_options['showtopic'];
		if ($showtopic == 1) {
			echo "<select id='showtopic' name='enm_groupsengine_options[showtopic]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showtopic == 0 ) {
			echo "<select id='showtopic' name='enm_groupsengine_options[showtopic]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showtopic' name='enm_groupsengine_options[showtopic]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_showchildcare', 
		'Show Childcare Column?: <p class="ge-form-instructions">Display the Childcare column in the Group Search list.</p>', 
		'enm_groupsengine_showchildcare_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showchildcare_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showchildcare = $ge_options['showchildcare'];
		if ($showchildcare == 1) {
			echo "<select id='showchildcare' name='enm_groupsengine_options[showchildcare]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showchildcare == 0 ) {
			echo "<select id='showchildcare' name='enm_groupsengine_options[showchildcare]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showchildcare' name='enm_groupsengine_options[showchildcare]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_showstatus', 
		'Show Status Column?: <p class="ge-form-instructions">Display the Status column in the Group Search list.</p>', 
		'enm_groupsengine_showstatus_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showstatus_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showstatus = $ge_options['showstatus'];
		if ($showstatus == 1) {
			echo "<select id='showstatus' name='enm_groupsengine_options[showstatus]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showstatus == 0 ) {
			echo "<select id='showstatus' name='enm_groupsengine_options[showstatus]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showstatus' name='enm_groupsengine_options[showstatus]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( //Default Map Zoom Level
		'enm_groupsengine_groupsearchmap', 
		'Map Height (Group Search):', 
		'enm_groupsengine_groupsearchmap_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_groupsearchmap_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$groupsearchmap = $ge_options['groupsearchmap'];
		echo "<input id='groupsearchmap' name='enm_groupsengine_options[groupsearchmap]' type='text' value='{$ge_options['groupsearchmap']}' size='3' />px";
	};

	add_settings_field( //Default Map Zoom Level
		'enm_groupsengine_singlegroupmap', 
		'Map Height (Single Group):', 
		'enm_groupsengine_singlegroupmap_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_singlegroupmap_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$singlegroupmap = $ge_options['singlegroupmap'];
		echo "<input id='singlegroupmap' name='enm_groupsengine_options[singlegroupmap]' type='text' value='{$ge_options['singlegroupmap']}' size='3' />px";
	};

	add_settings_field( 
		'enm_groupsengine_offsitelabel', 
		'Show Offsite Label?: <p class="ge-form-instructions">Display the offsite label beside offsite groups in the group list?</p>', 
		'enm_groupsengine_offsitelabel_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_offsitelabel_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$offsitelabel = $ge_options['offsitelabel'];
		if ($offsitelabel == 1) {
			echo "<select id='offsitelabel' name='enm_groupsengine_options[offsitelabel]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($offsitelabel == 0 ) {
			echo "<select id='offsitelabel' name='enm_groupsengine_options[offsitelabel]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='offsitelabel' name='enm_groupsengine_options[offsitelabel]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( 
		'enm_groupsengine_showstart', 
		'Show Group Start Date?: <p class="ge-form-instructions">Show the group start date in the group details view?</p>', 
		'enm_groupsengine_showstart_input', 
		'groupsengine_plugin', 
		'enm_groupsengine_column_settings' 
	);

	function enm_groupsengine_showstart_input() {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$showstart = $ge_options['showstart'];
		if ($showstart == 1) {
			echo "<select id='showstart' name='enm_groupsengine_options[showstart]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($showstart == 0 ) {
			echo "<select id='showstart' name='enm_groupsengine_options[showstart]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='showstart' name='enm_groupsengine_options[showstart]'><option value='1'>Yes</option><option value='0'>No</option></select>";
		}
	};

	// Validate Groups Engine Settings
	function enm_groupsengine_validate_options($input) {
		$ge_options = get_option( 'enm_groupsengine_options' );
		$valid['ministryname'] = strip_tags( $input['ministryname'] );
		$valid['spamprotection'] = strip_tags( $input['spamprotection'] );
		$valid['emailname'] = strip_tags( $input['emailname'] );
		$valid['emailaddress'] = strip_tags( $input['emailaddress'] );
		$valid['ajax'] = strip_tags( $input['ajax'] );
		$valid['imagewidth'] = strip_tags( $input['imagewidth'] );
		$valid['apikey'] = strip_tags( $input['apikey'] );
		$valid['serverapikey'] = strip_tags( $input['serverapikey'] );
		$valid['zoom'] = strip_tags( $input['zoom'] );
		$valid['groupsearchmap'] = strip_tags( $input['groupsearchmap'] );
		$valid['singlegroupmap'] = strip_tags( $input['singlegroupmap'] );
		$valid['pag'] = strip_tags( $input['pag'] );
		$valid['mapcenter'] = strip_tags( $input['mapcenter'] );
		$valid['maplat'] = strip_tags( $input['maplat'] );
		$valid['maplong'] = strip_tags( $input['maplong'] );
		$valid['pointer'] = strip_tags( $input['pointer'] );

		$valid['explorerbg'] = strip_tags( $input['explorerbg'] );
		$valid['exploreactionbg'] = strip_tags( $input['exploreactionbg'] );
		$valid['exploreactiontext'] = strip_tags( $input['exploreactiontext'] );
		$valid['exploreactionicon'] = strip_tags( $input['exploreactionicon'] );
		$valid['explorebuttonbg'] = strip_tags( $input['explorebuttonbg'] );
		$valid['explorebuttonbgroll'] = strip_tags( $input['explorebuttonbgroll'] );
		$valid['explorebuttontext'] = strip_tags( $input['explorebuttontext'] );
		$valid['explorebuttonicon'] = strip_tags( $input['explorebuttonicon'] );

		$valid['filterbg'] = strip_tags( $input['filterbg'] );
		$valid['filtertext'] = strip_tags( $input['filtertext'] );
		$valid['filterfieldbg'] = strip_tags( $input['filterfieldbg'] );
		$valid['filterfieldborder'] = strip_tags( $input['filterfieldborder'] );
		$valid['filterfieldtext'] = strip_tags( $input['filterfieldtext'] );
		$valid['filtersubmitbg'] = strip_tags( $input['filtersubmitbg'] );
		$valid['filtersubmittext'] = strip_tags( $input['filtersubmittext'] );

		$valid['grouplistheadertext'] = strip_tags( $input['grouplistheadertext'] );
		$valid['grouplisttext'] = strip_tags( $input['grouplisttext'] );
		$valid['grouplistlink'] = strip_tags( $input['grouplistlink'] );
		$valid['grouplistrow'] = strip_tags( $input['grouplistrow'] );

		$valid['pagebuttonbg'] = strip_tags( $input['pagebuttonbg'] );
		$valid['pagebuttontext'] = strip_tags( $input['pagebuttontext'] );
		$valid['pagenumber'] = strip_tags( $input['pagenumber'] );
		$valid['pagenumberselectedbg'] = strip_tags( $input['pagenumberselectedbg'] );
		$valid['pagenumberselectedtext'] = strip_tags( $input['pagenumberselectedtext'] );

		$valid['singletitle'] = strip_tags( $input['singletitle'] );
		$valid['singledetails'] = strip_tags( $input['singledetails'] );
		$valid['singledetailsbg'] = strip_tags( $input['singledetailsbg'] );
		$valid['singledetailstext'] = strip_tags( $input['singledetailstext'] );
		$valid['singledetailslink'] = strip_tags( $input['singledetailslink'] );
		$valid['singledetailslabel'] = strip_tags( $input['singledetailslabel'] );

		$valid['singledetailssharebg'] = strip_tags( $input['singledetailssharebg'] );
		$valid['singledetailssharebgroll'] = strip_tags( $input['singledetailssharebgroll'] );
		$valid['singledetailssharetext'] = strip_tags( $input['singledetailssharetext'] );
		$valid['singledetailsshareicon'] = strip_tags( $input['singledetailsshareicon'] );

		$valid['relatedbg'] = strip_tags( $input['relatedbg'] );
		$valid['relatedtext'] = strip_tags( $input['relatedtext'] );
		$valid['relatedlink'] = strip_tags( $input['relatedlink'] );

		$valid['contacttitle'] = strip_tags( $input['contacttitle'] );
		$valid['contactinstructionstext'] = strip_tags( $input['contactinstructionstext'] );
		$valid['contactformlabel'] = strip_tags( $input['contactformlabel'] );
		$valid['contactformfieldbg'] = strip_tags( $input['contactformfieldbg'] );
		$valid['contactformfieldtext'] = strip_tags( $input['contactformfieldtext'] );
		$valid['contactformsubmitbg'] = strip_tags( $input['contactformsubmitbg'] );
		$valid['contactformsubmittext'] = strip_tags( $input['contactformsubmittext'] );
		$valid['errorbg'] = strip_tags( $input['errorbg'] );
		$valid['errortext'] = strip_tags( $input['errortext'] );
		$valid['successbg'] = strip_tags( $input['successbg'] );
		$valid['successtext'] = strip_tags( $input['successtext'] );

		$valid['shareboxbg'] = strip_tags( $input['shareboxbg'] );
		$valid['shareboxtext'] = strip_tags( $input['shareboxtext'] );
		$valid['shareboxbuttonbg'] = strip_tags( $input['shareboxbuttonbg'] );
		$valid['shareboxbuttontext'] = strip_tags( $input['shareboxbuttontext'] );

		$valid['updatebg'] = strip_tags( $input['updatebg'] );
		$valid['updatetext'] = strip_tags( $input['updatetext'] );
		$valid['updatestatustext'] = strip_tags( $input['updatestatustext'] );
		$valid['updatelink'] = strip_tags( $input['updatelink'] );
		$valid['updatenotebg'] = strip_tags( $input['updatenotebg'] );
		$valid['updatenotetext'] = strip_tags( $input['updatenotetext'] );
		$valid['updateformfieldbg'] = strip_tags( $input['updateformfieldbg'] );
		$valid['updateformfieldtext'] = strip_tags( $input['updateformfieldtext'] );
		$valid['updateformsubmitbg'] = strip_tags( $input['updateformsubmitbg'] );
		$valid['updateformsubmittext'] = strip_tags( $input['updateformsubmittext'] );

		$valid['loadingbg'] = strip_tags( $input['loadingbg'] );
		$valid['loadingtext'] = strip_tags( $input['loadingtext'] );
		$valid['loadingicon'] = strip_tags( $input['loadingicon'] );
		$valid['customloading'] = addslashes(strip_tags($input['customloading']));
		$valid['customloadingretina'] = addslashes(strip_tags($input['customloadingretina']));

		$valid['credits'] = strip_tags( $input['credits'] );
		$valid['creditstext'] = strip_tags( $input['creditstext'] );

		$valid['contactinstructions'] = addslashes(strip_tags($input['contactinstructions']));
		$valid['contactsuccess'] = addslashes(strip_tags($input['contactsuccess']));
		$valid['nogroups'] = addslashes(strip_tags($input['nogroups']));

		$valid['grouptitle'] = addslashes(strip_tags($input['grouptitle']));
		$valid['groupptitle'] = addslashes(strip_tags($input['groupptitle']));
		$valid['grouptypetitle'] = addslashes(strip_tags($input['grouptypetitle']));
		$valid['grouptypeptitle'] = addslashes(strip_tags($input['grouptypeptitle']));
		$valid['locationtitle'] = addslashes(strip_tags($input['locationtitle']));
		$valid['locationptitle'] = addslashes(strip_tags($input['locationptitle']));
		$valid['topictitle'] = addslashes(strip_tags($input['topictitle']));
		$valid['topicptitle'] = addslashes(strip_tags($input['topicptitle']));
		$valid['searchbuttonlabel'] = addslashes(strip_tags($input['searchbuttonlabel']));
		$valid['contactbuttonlabel'] = addslashes(strip_tags($input['contactbuttonlabel']));

		$valid['searchwidth'] = addslashes(strip_tags($input['searchwidth']));
		$valid['backsearchwidth'] = addslashes(strip_tags($input['backsearchwidth']));
		$valid['contactwidth'] = addslashes(strip_tags($input['contactwidth']));
		$valid['backgroupwidth'] = addslashes(strip_tags($input['backgroupwidth']));

		$valid['showday'] = addslashes(strip_tags($input['showday']));
		$valid['showtime'] = addslashes(strip_tags($input['showtime']));
		$valid['showages'] = addslashes(strip_tags($input['showages']));
		$valid['showlocations'] = addslashes(strip_tags($input['showlocations']));
		$valid['showlocation'] = addslashes(strip_tags($input['showlocation']));
		$valid['showtopic'] = addslashes(strip_tags($input['showtopic']));
		$valid['showchildcare'] = addslashes(strip_tags($input['showchildcare']));
		$valid['showstatus'] = addslashes(strip_tags($input['showstatus']));

		$valid['childcare'] = addslashes(strip_tags($input['childcare']));
		$valid['offsite'] = addslashes(strip_tags($input['offsite']));
		$valid['offsitelabel'] = addslashes(strip_tags($input['offsitelabel']));
		$valid['showstart'] = addslashes(strip_tags($input['showstart']));
		
		if ( empty( $input['ministryname'] ) ) {
			add_settings_error( 'enm_groupsengine_ministryname_input', 'enm_groupsengine_texterror', 'You must enter a ministry name!', 'error' );
			$valid['ministryname'] = 'Your Ministry Name Here';
		}

		if ( empty( $input['emailname'] ) ) {
			add_settings_error( 'enm_groupsengine_emailname_input', 'enm_groupsengine_texterror', 'You must enter a name for automated emails!', 'error' );
			$valid['emailname'] = 'Groups Engine';
		}

		if ( empty( $input['emailaddress'] ) ) {
			add_settings_error( 'enm_groupsengine_emailaddress_input', 'enm_groupsengine_texterror', 'You must enter a reply-to address for automated emails!', 'error' );
			$valid['emailaddress'] = 'noreply@groupsengine.com';
		}

		if ( empty( $input['zoom'] ) ) { 
			$valid['zoom'] = '11';
		}

		if ( empty( $input['groupsearchmap'] ) ) { 
			$valid['groupsearchmap'] = '400';
		}

		if ( empty( $input['singlegroupmap'] ) ) { 
			$valid['singlegroupmap'] = '400';
		}

		if ( empty( $input['pag'] ) ) { 
			$valid['pag'] = '10';
		}

		if ( empty( $input['imagewidth'] ) ) { 
			$valid['imagewidth'] = '300';
		}

		if ( empty( $input['mapcenter'] ) ) { 
			$valid['mapcenter'] = '37075';
			$valid['maplat'] = '36.3047735';
			$valid['maplong'] = '-86.6199957';
			add_settings_error( 'enm_groupsengine_mapcenter_input', 'enm_groupsengine_texterror', 'You must enter a postal code to center your maps view!', 'error' );
		} elseif ( !empty( $input['mapcenter'] ) && ( $input['mapcenter'] != $input['mapcenterold'] ) ) {
			$valid['mapcenter'] = $input['mapcenter'];
			
			$enmge_g_addr_str = $input['mapcenter'];
			if ( $input['serverapikey'] != null ) {
			    $enmge_g_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false&key=" . $input['serverapikey'];
			} else {
				$enmge_g_url = "http://maps.googleapis.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false";
			}      
			

			$enmgech = curl_init();
			curl_setopt($enmgech, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($enmgech, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($enmgech, CURLOPT_URL,$enmge_g_url);
			$enmge_g_jsonData=curl_exec($enmgech);
			curl_close($enmgech);
			$enmge_g_data = json_decode($enmge_g_jsonData);

			if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ) {
				add_settings_error( 'enm_groupsengine_mapcenter_input', 'enm_groupsengine_texterror', 'Postal code for map center is invalid... Can you try another one? (You may also need to provide a Geocoding API key for address lookups.)', 'error' );
			} else {
				$valid['maplat'] = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			}

			if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ) {
			} else {
				$valid['maplong'] = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
			}
		} else {
			$valid['mapcenter'] = $input['mapcenter'];
			$valid['maplat'] = $input['maplat'];
			$valid['maplong'] = $input['maplong'];
		}

		if ( empty( $input['explorerbg'] ) ) { 
			$valid['explorerbg'] = 'd4d4d4';
		}

		if ( empty( $input['exploreactionbg'] ) ) { 
			$valid['exploreactionbg'] = 'CA9E2C';
		}

		if ( empty( $input['exploreactiontext'] ) ) { 
			$valid['exploreactiontext'] = 'EAD8AA';
		}

		if ( empty( $input['exploreactionicon'] ) ) {
			$valid['exploreactionicon'] = 'light';
		}

		if ( empty( $input['explorebuttonbg'] ) ) { 
			$valid['explorebuttonbg'] = 'f1f1f1';
		}

		if ( empty( $input['explorebuttonbgroll'] ) ) { 
			$valid['explorebuttonbgroll'] = 'ffffff';
		}

		if ( empty( $input['explorebuttontext'] ) ) { 
			$valid['explorebuttontext'] = 'A8A8A8';
		}

		if ( empty( $input['explorebuttonicon'] ) ) {
			$valid['explorebuttonicon'] = 'dark';
		}


		if ( empty( $input['filterbg'] ) ) { 
			$valid['filterbg'] = 'f1f1f1';
		}

		if ( empty( $input['filtertext'] ) ) { 
			$valid['filtertext'] = '000000';
		}

		if ( empty( $input['filterfieldbg'] ) ) { 
			$valid['filterfieldbg'] = 'ffffff';
		}

		if ( empty( $input['filterfieldborder'] ) ) { 
			$valid['filterfieldborder'] = 'ffffff';
		}

		if ( empty( $input['filterfieldtext'] ) ) { 
			$valid['filterfieldtext'] = '000000';
		}

		if ( empty( $input['filtersubmitbg'] ) ) { 
			$valid['filtersubmitbg'] = 'CA9E2C';
		}

		if ( empty( $input['filtersubmittext'] ) ) { 
			$valid['filtersubmittext'] = 'EAD8AA';
		}


		if ( empty( $input['grouplistheadertext'] ) ) { 
			$valid['grouplistheadertext'] = '000000';
		}

		if ( empty( $input['grouplisttext'] ) ) { 
			$valid['grouplisttext'] = '000000';
		}

		if ( empty( $input['grouplistlink'] ) ) { 
			$valid['grouplistlink'] = 'CA9E2C';
		}

		if ( empty( $input['grouplistrow'] ) ) { 
			$valid['grouplistrow'] = 'f1f1f1';
		}


		if ( empty( $input['pagebuttonbg'] ) ) { 
			$valid['pagebuttonbg'] = 'CA9E2C';
		}

		if ( empty( $input['pagebuttontext'] ) ) { 
			$valid['pagebuttontext'] = 'EAD8AA';
		}

		if ( empty( $input['pagenumber'] ) ) { 
			$valid['pagenumber'] = 'D4D4D4';
		}

		if ( empty( $input['pagenumberselectedbg'] ) ) { 
			$valid['pagenumberselectedbg'] = 'f1f1f1';
		}

		if ( empty( $input['pagenumberselectedtext'] ) ) { 
			$valid['pagenumberselectedtext'] = 'D4D4D4';
		}


		if ( empty( $input['singletitle'] ) ) { 
			$valid['singletitle'] = '000000';
		}

		if ( empty( $input['singledetails'] ) ) { 
			$valid['singledetails'] = '000000';
		}

		if ( empty( $input['singledetailsbg'] ) ) { 
			$valid['singledetailsbg'] = 'f1f1f1';
		}

		if ( empty( $input['singledetailstext'] ) ) { 
			$valid['singledetailstext'] = '000000';
		}

		if ( empty( $input['singledetailslink'] ) ) { 
			$valid['singledetailslink'] = 'CA9E2C';
		}

		if ( empty( $input['singledetailslabel'] ) ) { 
			$valid['singledetailslabel'] = '000000';
		}


		if ( empty( $input['singledetailssharebg'] ) ) { 
			$valid['singledetailssharebg'] = 'D4D4D4';
		}

		if ( empty( $input['singledetailssharebgroll'] ) ) { 
			$valid['singledetailssharebgroll'] = 'dcdbdb';
		}

		if ( empty( $input['singledetailssharetext'] ) ) { 
			$valid['singledetailssharetext'] = '848484';
		}

		if ( empty( $input['singledetailsshareicon'] ) ) { 
			$valid['singledetailsshareicon'] = 'dark';
		}


		if ( empty( $input['relatedbg'] ) ) { 
			$valid['relatedbg'] = 'd9d9d9';
		}

		if ( empty( $input['relatedtext'] ) ) { 
			$valid['relatedtext'] = '000000';
		}

		if ( empty( $input['relatedlink'] ) ) { 
			$valid['relatedlink'] = 'CA9E2C';
		}


		if ( empty( $input['contacttitle'] ) ) { 
			$valid['contacttitle'] = '000000';
		}

		if ( empty( $input['contactinstructionstext'] ) ) { 
			$valid['contactinstructionstext'] = '000000';
		}

		if ( empty( $input['contactformlabel'] ) ) { 
			$valid['contactformlabel'] = '000000';
		}

		if ( empty( $input['contactformfieldbg'] ) ) { 
			$valid['contactformfieldbg'] = 'f1f1f1';
		}

		if ( empty( $input['contactformfieldtext'] ) ) { 
			$valid['contactformfieldtext'] = '000000';
		}

		if ( empty( $input['contactformsubmitbg'] ) ) { 
			$valid['contactformsubmitbg'] = 'CA9E2C';
		}

		if ( empty( $input['contactformsubmittext'] ) ) { 
			$valid['contactformsubmittext'] = 'EAD8AA';
		}

		if ( empty( $input['errorbg'] ) ) { 
			$valid['errorbg'] = 'EAD8AA';
		}

		if ( empty( $input['errortext'] ) ) { 
			$valid['errortext'] = '000000';
		}

		if ( empty( $input['successbg'] ) ) { 
			$valid['successbg'] = 'EAD8AA';
		}

		if ( empty( $input['successtext'] ) ) { 
			$valid['successtext'] = '000000';
		}


		if ( empty( $input['shareboxbg'] ) ) { 
			$valid['shareboxbg'] = 'd4d4d4';
		}

		if ( empty( $input['shareboxtext'] ) ) { 
			$valid['shareboxtext'] = '444444';
		}

		if ( empty( $input['shareboxbuttonbg'] ) ) { 
			$valid['shareboxbuttonbg'] = 'CA9E2C';
		}

		if ( empty( $input['shareboxbuttontext'] ) ) { 
			$valid['shareboxbuttontext'] = 'EAD8AA';
		}


		if ( empty( $input['updatebg'] ) ) { 
			$valid['updatebg'] = 'ffffff';
		}

		if ( empty( $input['updatetext'] ) ) { 
			$valid['updatetext'] = '000000';
		}

		if ( empty( $input['updatestatustext'] ) ) { 
			$valid['updatestatustext'] = 'CA9E2C';
		}

		if ( empty( $input['updatelink'] ) ) { 
			$valid['updatelink'] = 'CA9E2C';
		}

		if ( empty( $input['updatenotebg'] ) ) { 
			$valid['updatenotebg'] = 'fafafa';
		}

		if ( empty( $input['updatenotetext'] ) ) { 
			$valid['updatenotetext'] = '000000';
		}

		if ( empty( $input['updateformfieldbg'] ) ) { 
			$valid['updateformfieldbg'] = 'f1f1f1';
		}

		if ( empty( $input['updateformfieldtext'] ) ) { 
			$valid['updateformfieldtext'] = '000000';
		}

		if ( empty( $input['updateformsubmitbg'] ) ) { 
			$valid['updateformsubmitbg'] = 'CA9E2C';
		}

		if ( empty( $input['updateformsubmittext'] ) ) { 
			$valid['updateformsubmittext'] = 'EAD8AA';
		}


		if ( empty( $input['loadingbg'] ) ) { 
			$valid['loadingbg'] = 'd4d4d4';
		}

		if ( empty( $input['loadingtext'] ) ) { 
			$valid['loadingtext'] = '444444';
		}

		if ( empty( $input['loadingicon'] ) ) { 
			$valid['loadingicon'] = 'dark';
		}


		if ( empty( $input['creditstext'] ) ) { 
			$valid['creditstext'] = 'f1f1f1';
		}


		if ( empty( $input['grouptitle'] ) ) { 
			$valid['grouptitle'] = 'Group';
		}

		if ( empty( $input['groupptitle'] ) ) { 
			$valid['groupptitle'] = 'Groups';
		}

		if ( empty( $input['grouptypetitle'] ) ) { 
			$valid['grouptypetitle'] = 'Group Type';
		}

		if ( empty( $input['grouptypeptitle'] ) ) { 
			$valid['grouptypeptitle'] = 'Group Types';
		}

		if ( empty( $input['locationtitle'] ) ) { 
			$valid['locationtitle'] = 'Location';
		}

		if ( empty( $input['locationptitle'] ) ) { 
			$valid['locationptitle'] = 'Locations';
		}

		if ( empty( $input['topictitle'] ) ) { 
			$valid['topictitle'] = 'Topic';
		}

		if ( empty( $input['topicptitle'] ) ) { 
			$valid['topicptitle'] = 'Topics';
		}


		if ( empty( $input['searchwidth'] ) ) { 
			$valid['searchwidth'] = '210';
		}

		if ( empty( $input['backsearchwidth'] ) ) { 
			$valid['backsearchwidth'] = '134';
		}

		if ( empty( $input['contactwidth'] ) ) { 
			$valid['contactwidth'] = '192';
		}

		if ( empty( $input['backgroupwidth'] ) ) { 
			$valid['backgroupwidth'] = '130';
		}


		if ( empty( $input['offsite'] ) ) { 
			$valid['offsite'] = 'Offsite';
		}

		if ( empty( $input['childcare'] ) ) { 
			$valid['childcare'] = 'Childcare Available?';
		}

		return $valid; 
	};
};

/* Old Plugin Updater

function enmge_trigger_force_updates_check() {

	if( ! isset( $_GET['action'] ) || 'groups_engine_update' != $_GET['action'] ) {
		return;
	}

	if( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	set_site_transient( 'update_plugins', null );

	wp_safe_redirect( admin_url( 'index.php' ) ); exit;

}
add_action( 'admin_init', 'enmge_trigger_force_updates_check' );



define( 'ENMGE_ALT_API', 'http://pluginupdates.groupsengine.com' );

add_filter('pre_set_site_transient_update_plugins', 'enmge_altapi_check');

function enmge_altapi_check( $transient ) {

    if( empty( $transient->checked ) )
        return $transient;
    
    $plugin_slug = plugin_basename( __FILE__ );
    
    $args = array(
        'action' => 'update-check',
        'plugin_name' => $plugin_slug,
        'version' => $transient->checked[$plugin_slug]
    );
    
    $response = enmge_altapi_request( $args );
    
    if( false !== $response ) {
        $transient->response[$plugin_slug] = $response;
    }
    
    return $transient;
}

// Send a request to the alternative API, return an object
function enmge_altapi_request( $args ) {

    $request = wp_remote_post( ENMGE_ALT_API, array( 'body' => $args ) );
    
    if( is_wp_error( $request )
    or
    wp_remote_retrieve_response_code( $request ) != 200
    ) {
        return false;
    }
    
    $response = unserialize( wp_remote_retrieve_body( $request ) );
    if( is_object( $response ) ) {
        return $response;
    } else {
        return false;
    }
}

// Plugin details screen

add_filter('plugins_api', 'enmge_altapi_information', 10, 3);

function enmge_altapi_information( $false, $action, $args ) {

    $plugin_slug = plugin_basename( __FILE__ );

    if( $args->slug != $plugin_slug ) {
        return $false;
    }
        
    $args = array(
        'action' => 'plugin_information',
        'plugin_name' => $plugin_slug,
        'version' => ENMGE_CURRENT_VERSION
    );
    
    $response = enmge_altapi_request( $args );
    
    $request = wp_remote_post( ENMGE_ALT_API, array( 'body' => $args ) );

    return $response;
} */

/*if ( get_option('enmge_db_version') == "1.0" ) {

	$ge_options = get_option( 'enm_groupsengine_options' );
	generate_ge_options_css($ge_options);

}*/

if ( get_option('enmge_db_version') == "1.0" ) { // First Update for beta users

	function enmge_zeroone() {
		global $wpdb;
		$groupcheck = $wpdb->prefix . "ge_groups";
	
			if( $wpdb->get_var("SHOW TABLES LIKE '$groupcheck'") == $groupcheck ) {
			
				$sql = "ALTER TABLE " . $groupcheck .
					" ADD group_noend int(1) DEFAULT NULL,
					 ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$groupcheck = $wpdb->prefix . "ge_groups";
	
			if( $wpdb->get_var("SHOW TABLES LIKE '$groupcheck'") == $groupcheck ) {
			
				$sql = "ALTER TABLE " . $groupcheck .
					" ADD group_noend int(1) DEFAULT NULL,
					 ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeroone();
	}

} elseif ( get_option('enmge_db_version') == "1.01" ) { // First Update for beta users
	function enmge_zerotwo() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerotwo();
	}
} elseif ( get_option('enmge_db_version') == "1.02" ) { // First Update
	function enmge_zerothree() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerothree();
	}
} elseif ( get_option('enmge_db_version') == "1.03" ) { // 1.0.2
	function enmge_zerothree() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerothree();
	}
} elseif ( get_option('enmge_db_version') == "1.04" ) { // 1.0.3
	function enmge_zerofour() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerofour();
	}
} elseif ( get_option('enmge_db_version') == "1.05" ) { // 1.0.4
	function enmge_zerofive() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerofive();
	}
} elseif ( get_option('enmge_db_version') == "1.06" ) { // 1.0.5
	function enmge_zerosix() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerosix();
	}
} elseif ( get_option('enmge_db_version') == "1.07" ) { // 1.0.6
	function enmge_zeroseven() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeroseven();
	}
} elseif ( get_option('enmge_db_version') == "1.08" ) { // 1.0.7
	function enmge_zeroeight() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeroeight();
	}
} elseif ( get_option('enmge_db_version') == "1.09" ) { // 1.0.8
	function enmge_zeronine() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeronine();
	}
} elseif ( get_option('enmge_db_version') == "1.10" ) { // 1.0.9
	function enmge_zeroten() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeroten();
	}
} elseif ( get_option('enmge_db_version') == "1.11" ) { // 1.1
	function enmge_one() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
		if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

			$sql = "ALTER TABLE " . $gcheck .
				" ADD group_manedit int(2) DEFAULT NULL";
			$wpdb->query($sql);
		}
		$lcheck = $wpdb->prefix . "ge_locations";
		if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

			$sqltwo = "ALTER TABLE " . $lcheck .
				" ADD location_manedit int(2) DEFAULT NULL";
			$wpdb->query($sqltwo);
		}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_one();
	}
} elseif ( get_option('enmge_db_version') == "1.12" ) { // 1.1.1
	function enmge_oneone() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_oneone();
	}
} elseif ( get_option('enmge_db_version') == "1.13" || get_option('enmge_db_version') == "1.14" || get_option('enmge_db_version') == "1.15" || get_option('enmge_db_version') == "1.16" || get_option('enmge_db_version') == "1.17" || get_option('enmge_db_version') == "1.18" || get_option('enmge_db_version') == "1.19" ) { // 1.2.1
	function enmge_oneonetwo() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.20";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.20";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_oneonetwo();
	}
}

 ?>