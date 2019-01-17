<?php /* ----- Groups Engine - Pagination for Groups ----- */

global $wpdb;
if ( $wpdb != null ) { // Verify that user is allowed to access this page

if ( $enmge_pag != 0 ) {
	$enmge_display = $enmge_pag;
} else {
	$enmge_display = $enmge_dpag; // How many records to display
}


if ( $enmge_f == 1 ) {
	$enmge_countsql = "SELECT group_id FROM " . $wpdb->prefix . "ge_groups";  
	if ( $enmge_gt != 0 ) { // grouptype
		$enmge_countsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_id)";
	}
	if ( $enmge_t != NULL ) { // topic
		$enmge_countsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (group_id)";
	}
	if ( $enmge_l != NULL ) { // location
		$enmge_countsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (group_id)";
	}
	if ( $enmge_gstart == 1 ) { // start date
		$enmge_countsql .= " WHERE group_privacy = 1 AND (group_ends >= CURDATE() OR group_noend = 1)";
	} else {
		$enmge_countsql .= " WHERE group_privacy = 1 AND ((group_begins <= CURDATE() AND group_ends >= CURDATE()) OR (group_begins <= CURDATE() AND group_noend = 1))";
	}
	if ( $enmge_status != 'n' ) {
		$enmge_countsql .= " AND group_status = " . $enmge_status;
	}
	if ( $enmge_d != NULL ) { // day
		$enmge_countsql .= " AND (group_day = " . $enmge_d . " OR group_day = 8)";
	}
	if ( $enmge_m == 1 ) { // onsite/offsite
		$enmge_countsql .= " AND group_onsite > 0";
	} elseif ( $enmge_m == 0 ) {
		$enmge_countsql .= " AND group_onsite = 0";
	}
	if ( $enmge_st < 24 && $enmge_et < 24 ) { 
		$enmge_countsql .= " AND (((group_starttime >= \"" . $enmge_st . "\" AND group_starttime <= \"" . $enmge_et . "\") OR (group_endtime <= \"" . $enmge_et . "\" AND group_endtime >= \"" . $enmge_st . "\")) OR (group_starttime <= \"" . $enmge_st . "\" AND group_endtime >= \"" . $enmge_et . "\"))";
	} elseif ( $enmge_st < 24 ) {
		$enmge_countsql .= " AND (group_starttime >= \"" . $enmge_st . "\" OR group_endtime >= \"" . $enmge_st . "\")";
	} elseif ( $enmge_et < 24 ) {
		$enmge_countsql .= " AND (group_starttime <= \"" . $enmge_et . "\" OR group_endtime <= \"" . $enmge_et . "\")";
	}
	if ( $enmge_sa < 101 && $enmge_ea < 101 ) { // start age
		$enmge_countsql .= " AND (((group_startage >= " . $enmge_sa . " AND group_startage <= " . $enmge_ea . ") OR (group_endage <= " . $enmge_ea . " AND group_endage >= " . $enmge_sa . ")) OR (group_startage <= " . $enmge_sa . " AND group_endage >= " . $enmge_ea . "))";
	} elseif ( $enmge_sa < 101 ) {
		$enmge_countsql .= " AND (group_startage >= " . $enmge_sa . " OR group_endage >= " . $enmge_sa . ")";
	} elseif ( $enmge_ea < 101 ) {
		$enmge_countsql .= " AND (group_startage <= " . $enmge_ea . " OR group_endage <= " . $enmge_ea . ")";
	}
	if ( $enmge_ea < 101 ) { // end age
		$enmge_countsql .= " AND group_endage >= " . $enmge_ea;
	}
	if ( $enmge_z != NULL ) { // end age
		$enmge_countsql .= " AND group_zip = " . $enmge_z ;
	}
	if ( $enmge_gt != NULL ) { // grouptype
		$enmge_countsql .= " AND group_type_id = " . $enmge_gt;
	}
	if ( $enmge_t != NULL ) { // topic
		$enmge_countsql .= " AND topic_id = " . $enmge_t;
	}
	if ( $enmge_l != NULL ) { // location
		$enmge_countsql .= " AND location_id = " . $enmge_l;
	}
	$enmge_countsql .= " GROUP BY group_id";
} else {
	$enmge_countsql = "SELECT group_id FROM " . $wpdb->prefix . "ge_groups WHERE group_privacy = 1 AND (group_ends >= CURDATE() OR group_noend = 1)"; 
}	

$enmge_runsqlcount = $wpdb->get_results( $enmge_countsql );
$enmge_messagecount = $wpdb->num_rows;

if ( isset($_GET['enmge_p']) && isset($_GET['enmge_did']) ) { // # of pages already been determined.
	if ($enmge_messagecount > $enmge_display) { // More than 1 page.
		$enmge_pages = ceil($enmge_messagecount/$enmge_display);
	} else {
		$enmge_pages = 1;
	}
} elseif ( isset($_GET['enmge_p']) && is_numeric($_GET['enmge_p']) ) {
	$enmge_pages = strip_tags($_GET['enmge_p']);
} else { // Need to determine # of pages.
	if ($enmge_messagecount > $enmge_display) { // More than 1 page.
		$enmge_pages = ceil($enmge_messagecount/$enmge_display);
	} else {
		$enmge_pages = 1;
	}
}

// Determine where in the database to start returning results...
if (isset($_GET['enmge_c']) && is_numeric($_GET['enmge_c'])) {
	if ( strip_tags($_GET['enmge_c']) >= $enmge_messagecount ) {
		$enmge_start = strip_tags($_GET['enmge_c']) - $enmge_display;
	} else {
		$enmge_start = strip_tags($_GET['enmge_c']);
	}
} else {
	$enmge_start = 0;
}

// Get records from database according to the page and display count

if ( $enmge_f == 1 ) {
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
	if ( $enmge_gstart == 1 ) { // start date
		$enmge_preparredsql .= " WHERE group_privacy = 1 AND (group_ends >= CURDATE() OR group_noend = 1)";
	} else {
		$enmge_preparredsql .= " WHERE group_privacy = 1 AND ((group_begins <= CURDATE() AND group_ends >= CURDATE()) OR (group_begins <= CURDATE() AND group_noend = 1))";
	}
	if ( $enmge_status != 'n' ) {
		$enmge_preparredsql .= " AND group_status = " . $enmge_status;
	}
	if ( $enmge_d != NULL ) { // day
		$enmge_preparredsql .= " AND (group_day = " . $enmge_d . " OR group_day = 8)";
	}
	if ( $enmge_m == 1 ) { // onsite/offsite
		$enmge_preparredsql .= " AND group_onsite > 0";
	} elseif ( $enmge_m == 0 ) {
		$enmge_preparredsql .= " AND group_onsite = 0";
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
	if ( $enmge_v == 1 ) {
		$enmge_preparredsql .= " GROUP BY group_id";
		if ( $enmge_sort == 3 ) {
			$enmge_preparredsql .= " ORDER BY group_startage ASC";
		} elseif ( $enmge_sort == 2 ) {
			$enmge_preparredsql .= " ORDER BY group_title DESC";
		} elseif ( $enmge_sort == 1 ) {
			$enmge_preparredsql .= " ORDER BY group_title ASC";
		} else {
			$enmge_preparredsql .= " ORDER BY group_day, group_starttime, group_title ASC";
		}
		$enmge_groups = $wpdb->get_results( $enmge_preparredsql );
	} else {
		$enmge_preparredsql .= " GROUP BY group_id";
		if ( $enmge_sort == 3 ) {
			$enmge_preparredsql .= " ORDER BY group_startage ASC LIMIT %d, %d";
		} elseif ( $enmge_sort == 2 ) {
			$enmge_preparredsql .= " ORDER BY group_title DESC LIMIT %d, %d";
		} elseif ( $enmge_sort == 1 ) {
			$enmge_preparredsql .= " ORDER BY group_title ASC LIMIT %d, %d";
		} else {
			$enmge_preparredsql .= " ORDER BY group_day, group_starttime, group_title ASC LIMIT %d, %d";
		}
		$enmge_sql = $wpdb->prepare( $enmge_preparredsql, $enmge_start, $enmge_display );
		$enmge_groups = $wpdb->get_results( $enmge_sql );
	}
	
} else {
	if ( $enmge_v == 1 ) {
		$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_privacy = 1 AND (group_ends >= CURDATE() OR group_noend = 1) ORDER BY group_day, group_starttime ASC"; 
		$enmge_groups = $wpdb->get_results( $enmge_preparredsql );	
	} else {
		$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_privacy = 1 AND (group_ends >= CURDATE() OR group_noend = 1) ORDER BY group_day, group_starttime, group_title ASC LIMIT %d, %d"; 	
		$enmge_sql = $wpdb->prepare( $enmge_preparredsql, $enmge_start, $enmge_display );
		$enmge_groups = $wpdb->get_results( $enmge_sql );
	}
}


// Deny access to sneaky people!
} else {
	exit("Access Denied");
}
?>