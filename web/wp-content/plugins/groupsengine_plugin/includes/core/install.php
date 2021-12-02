<?php 

if ( version_compare( get_bloginfo( 'version' ), '3.8', '<' ) ) { // Don't activate plugin if WordPress version is less than 3.5
		$enmge_old_version_message = "WordPress 3.8 or greater is required to use Groups Engine. Please upgrade!";
		exit ($enmge_old_version_message);
	}

	// Create GE database tables
	global $wpdb;

	// Define DB version
	global $enmge_db_version;
	$enmge_db_version = "1.3.4";
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

 ?>