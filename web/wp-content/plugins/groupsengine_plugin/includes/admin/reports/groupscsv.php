<?php /* Groups Engine - CSV Report for Groups */
	require_once 'report_header.php';

	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8', true, 200);
	header('Content-Disposition: attachment; filename=groups.csv');

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');

	// output the column headings
	fputcsv($output, array(stripslashes($enmge_grouptitle) . ' Title', 'Day', 'Time', 'Ages', 'Leader(s)', stripslashes($enmge_locationtitle), 'Meets at', stripslashes($enmge_grouptypetitle), stripslashes($enmge_topictitle), 'Description', 'Childcare?', 'Status'));

// loop over the rows, outputting them

	
	if ( current_user_can( 'edit_posts' ) ) { 
		
		if ( $_POST ) {
			global $wpdb;
		
			if ($_POST['enmge_grouptype'] != 0) { // Are they viewing groups by group type?
				$enmge_gt = strip_tags($_POST['enmge_grouptype']);
			} else {
				$enmge_gt = 0;
			}

			if ($_POST['enmge_topic'] != 0) { // Are they viewing groups by topic?
				$enmge_t = strip_tags($_POST['enmge_topic']);
			} else {
				$enmge_t = 0;
			}

			if ($_POST['enmge_location'] != 0) { // Are they viewing groups by location?
				$enmge_l = strip_tags($_POST['enmge_location']);
			}  else {
				$enmge_l = 0;
			}

			if ($_POST['enmge_day'] != 0) { // Are they viewing groups by day?
				$enmge_d = strip_tags($_POST['enmge_day']);
			}  else {
				$enmge_d = 0;
			}

			if ($_POST['enmge_st'] != 24) { // Did they specify a start time?
				$enmge_ust = strip_tags($_POST['enmge_st']);
				$enmge_st = $enmge_ust . ":00:00";
			}  else {
				$enmge_st = 24;
			}

			if ($_POST['enmge_et'] != 24) { // Did they specify an end time?
				$enmge_uet = strip_tags($_POST['enmge_et']);
				$enmge_et = $enmge_uet . ":00:00";
			} else {
				$enmge_et = 24;
			}

			if ($_POST['enmge_sa'] != 101) { // Did they specify a start age?
				$enmge_sa = strip_tags($_POST['enmge_sa']);
			} else {
				$enmge_sa = 101;
			}

			if ($_POST['enmge_ea'] != 101) { // Did they specify an end age?
				$enmge_ea = strip_tags($_POST['enmge_ea']);
			} else {
				$enmge_ea = 101;
			}

			if ($_POST['enmge_zip'] != null) { // Did they specify a zip?
				$enmge_z = strip_tags($_POST['enmge_zip']);
			} else {
				$enmge_z = 0;
			}

			if ($_POST['enmge_status'] != 'n') { // Group status
				$enmge_status = strip_tags($_POST['enmge_status']);
			} else {
				$enmge_status = 'n';
			}

			if ($_POST['enmge_private'] != null) { // Public and private?
				$enmge_pr = strip_tags($_POST['enmge_private']);
			} else {
				$enmge_pr = 0;
			}

			if ($_POST['enmge_meeting'] != null) { // Currently meeting?
				$enmge_cu = strip_tags($_POST['enmge_meeting']);
			} else {
				$enmge_cu = 0;
			}

			if ($_POST['enmge_onsite'] != null) { // Onsite?
				$enmge_onsite = strip_tags($_POST['enmge_onsite']);
			} else {
				$enmge_onsite = 0;
			}

			$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups";  
			if ( $enmge_gt != 0 ) { // grouptype
				$enmge_preparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_id)";
			}
			if ( $enmge_t != NULL ) { // topic
				$enmge_preparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (group_id)";
			}
			if ( $enmge_l != NULL ) { // location
				$enmge_preparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (group_id)";
			}
			if ( $enmge_cu == 0 ) { // currently meeting
				$enmge_preparredsql .= " WHERE ((group_begins <= CURDATE() AND group_ends >= CURDATE()) OR (group_begins <= CURDATE() AND group_noend = 1))";
			} else {
				$enmge_preparredsql .= " WHERE group_id > 0";
			}
			if ( $enmge_status != 'n' ) {
				$enmge_preparredsql .= " AND group_status = " . $enmge_status;
			}
			if ( $enmge_d != NULL ) { // day
				$enmge_preparredsql .= " AND group_day = " . $enmge_d;
			}
			if ( $enmge_st < 24 && $enmge_et < 24 ) { 
				$enmge_preparredsql .= " AND (((group_starttime >= \"" . $enmge_st . "\" AND group_starttime <= \"" . $enmge_et . "\") OR (group_endtime <= \"" . $enmge_et . "\" AND group_endtime >= \"" . $enmge_st . "\")) OR (group_starttime <= \"" . $enmge_st . "\" AND group_endtime >= \"" . $enmge_et . "\"))";
			} elseif ( $enmge_st < 24 ) {
				$enmge_preparredsql .= " AND (group_starttime >= \"" . $enmge_st . "\" OR group_endtime >= \"" . $enmge_st . "\")";
			} elseif ( $enmge_et < 24 ) {
				$enmge_preparredsql .= " AND (group_starttime <= \"" . $enmge_et . "\" OR group_endtime <= \"" . $enmge_et . "\")";
			}
			if ( $enmge_sa < 101 && $enmge_ea < 101 ) { // start age
				$enmge_preparredsql .= " AND (((group_startage >= " . $enmge_sa . " AND group_startage <= " . $enmge_ea . ") OR (group_endage <= " . $enmge_ea . " AND group_endage >= " . $enmge_sa . ")) OR (group_startage <= " . $enmge_sa . " AND group_endage >= " . $enmge_ea . "))";
			} elseif ( $enmge_sa < 101 ) {
				$enmge_preparredsql .= " AND (group_startage >= " . $enmge_sa . " OR group_endage >= " . $enmge_sa . ")";
			} elseif ( $enmge_ea < 101 ) {
				$enmge_preparredsql .= " AND (group_startage <= " . $enmge_ea . " OR group_endage <= " . $enmge_ea . ")";
			}
			if ( $enmge_z != NULL ) { // end age
				$enmge_preparredsql .= " AND group_zip = " . $enmge_z ;
			}
			if ( $enmge_gt != NULL ) { // grouptype
				$enmge_preparredsql .= " AND group_type_id = " . $enmge_gt;
			}
			if ( $enmge_t != NULL ) { // topic
				$enmge_preparredsql .= " AND topic_id = " . $enmge_t;
			}
			if ( $enmge_l != NULL ) { // location
				$enmge_preparredsql .= " AND location_id = " . $enmge_l;
			}
			if ( $enmge_pr == 0 ) { // privacy
				$enmge_preparredsql .= " AND group_privacy = 1";
			} 
			if ( $enmge_onsite == 1 ) { // onsite/offsite
				$enmge_preparredsql .= " AND group_onsite > 0";
			} elseif ( $enmge_onsite == 2 ) {
				$enmge_preparredsql .= " AND group_onsite = 0";
			}
			$enmge_preparredsql .= " GROUP BY group_id ORDER BY group_day, group_starttime ASC";
			$enmge_groups = $wpdb->get_results( $enmge_preparredsql  );

			// Get All Topics
			$enmge_preparredtsql = "SELECT topic_id, topic_name FROM " . $wpdb->prefix . "ge_topics" . " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_id IS NOT NULL GROUP BY topic_id ORDER BY topic_name ASC"; 
			$enmge_ts = $wpdb->get_results( $enmge_preparredtsql );

			// Get All Group Topic Matches
			$enmge_preparredgtmsql = "SELECT topic_id, group_id FROM " . $wpdb->prefix . "ge_group_topic_matches"; 
			$enmge_gtm = $wpdb->get_results( $enmge_preparredgtmsql );

			// Get All Locations
			$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (location_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_id IS NOT NULL GROUP BY location_id ORDER BY location_id DESC"; 	
			$enmge_locations = $wpdb->get_results( $enmge_lpreparredsql );

			// Get All Group Location Matches
			$enmge_preparredglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches"; 
			$enmge_glm = $wpdb->get_results( $enmge_preparredglmsql );

			// Get All Group Types
			$enmge_preparredgtsql = "SELECT group_type_id, group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_type_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_id IS NOT NULL GROUP BY group_type_id ORDER BY group_type_title ASC"; 
			$enmge_gts = $wpdb->get_results( $enmge_preparredgtsql );

			// Get All Group Group Type Matches
			$enmge_preparredggtmmsql = "SELECT group_type_id, group_id FROM " . $wpdb->prefix . "ge_group_group_type_matches"; 
			$enmge_ggtm = $wpdb->get_results( $enmge_preparredggtmmsql );

			// Get All Leaders
			$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " GROUP BY leader_id ORDER BY leader_name ASC"; 
			$enmge_les = $wpdb->get_results( $enmge_preparredlesql );

			// Get All Group Leader Matches
			$enmge_preparredlemsql = "SELECT leader_id, group_id FROM " . $wpdb->prefix . "ge_group_leader_matches"; 
			$enmge_glem = $wpdb->get_results( $enmge_preparredlemsql );
		}
	
foreach ($enmge_groups as $g) { 
	unset($topics);
	unset($leaders);
	unset($locations);
	unset($grouptypes);
	$grouprow[] = stripslashes($g->group_title);
	if ( $g->group_day == 8 ) { $grouprow[] = "Var";  } if ( $g->group_day == 1 ) { $grouprow[] = "Sun";  }  if ( $g->group_day == 2 ) { $grouprow[] = "Mon";  }  if ( $g->group_day == 3 ) { $grouprow[] = "Tue";  }  if ( $g->group_day == 4 ) { $grouprow[] = "Wed";  }  if ( $g->group_day == 5 ) { $grouprow[] = "Thu";  }  if ( $g->group_day == 6 ) { $grouprow[] = "Fri";  }  if ( $g->group_day == 7 ) { $grouprow[] = "Sat";  }
	if ( date('a', strtotime($g->group_starttime)) == date('a', strtotime($g->group_endtime)) ) { $grouprow[] = date('g:i', strtotime($g->group_starttime)) . '-' . date('g:ia', strtotime($g->group_endtime)); } else { $grouprow[] = date('g:ia', strtotime($g->group_starttime)) . '-' . date('g:ia', strtotime($g->group_endtime)); };
	if ( $g->group_endage == 100 ) { $grouprow[] = $g->group_startage . "+"; } else { $grouprow[] = $g->group_startage . "-" . $g->group_endage; }; 
	$le_comma = 1; foreach ( $enmge_les as $le) {  foreach ( $enmge_glem as $glem) {  if ( ($glem->group_id == $g->group_id) && ($glem->leader_id == $le->leader_id) ) { if ( $le_comma == 1 ) { $leaders = stripslashes($le->leader_name) . " (" . stripslashes($le->leader_email) . ")"; $le_comma = $le_comma+1; } else { $leaders .= ", " . stripslashes($le->leader_name) . " (" . stripslashes($le->leader_email) . ")"; $le_comma = $le_comma+1; }}}} if ( !empty($leaders) ) { $grouprow[] = $leaders; } else { $grouprow[] = ''; };
	$l_comma = 1; foreach ( $enmge_locations as $l) {  foreach ( $enmge_glm as $glm) {  if ( ($glm->group_id == $g->group_id) && ($glm->location_id == $l->location_id) ) { if ( $l_comma == 1 ) { $locations = stripslashes($l->location_name); $l_comma = $l_comma+1; } else { $locations .= ", " . stripslashes($l->location_name); $l_comma = $l_comma+1; }}}} if ( !empty($locations) ) { $grouprow[] = $locations; } else { $grouprow[] = ''; };
	if ( $g->group_onsite > 0 ) { $grouprow[] = stripslashes($g->group_campus_name) . " - " . stripslashes($g->group_location_label); } else { if ($enmge_offsitelabel == 1) {$grouprow[] = "(" . $enmge_offsite . ") " . stripslashes($g->group_location_label);} else {$grouprow[] = stripslashes($g->group_location_label);} }
	$gt_comma = 1; foreach ( $enmge_gts as $gt) {  foreach ( $enmge_ggtm as $ggtm) {  if ( ($ggtm->group_id == $g->group_id) && ($ggtm->group_type_id == $gt->group_type_id) ) { if ( $gt_comma == 1 ) { $grouptypes = stripslashes($gt->group_type_title); $gt_comma = $gt_comma+1; } else { $grouptypes .= ", " . stripslashes($gt->group_type_title); $gt_comma = $gt_comma+1; }}}} if ( !empty($grouptypes) ) { $grouprow[] = $grouptypes; } else { $grouprow[] = ''; };
	$t_comma = 1; foreach ( $enmge_ts as $t) {  foreach ( $enmge_gtm as $gtm) {  if ( ($gtm->group_id == $g->group_id) && ($gtm->topic_id == $t->topic_id) ) { if ( $t_comma == 1 ) { $topics = stripslashes($t->topic_name); $t_comma = $t_comma+1; } else { $topics .= ", " . stripslashes($t->topic_name); $t_comma = $t_comma+1; }}}} if ( !empty($topics) ) { $grouprow[] = $topics; } else { $grouprow[] = ''; };
	$grouprow[] = stripslashes(strip_tags($g->group_description));
	if ( $g->group_childcare == 0 ) { $grouprow[] = 'No';} else { $grouprow[] = 'Yes';}
	if ( $g->group_status == 1 ) { $grouprow[] = 'Open'; } elseif ( $g->group_status == 0 ) { $grouprow[] = 'Closed'; } else { $grouprow[] = 'Full'; }
	fputcsv($output, $grouprow);
	unset($grouprow);
}

} else {
	$enmge_redirecturl = home_url();
	header("Location: $enmge_redirecturl");
} ?>