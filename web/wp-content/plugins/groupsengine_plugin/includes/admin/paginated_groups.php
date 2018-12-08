<?php /* ----- Groups Engine - Pagination for admin Groups ----- */

global $wpdb;
if ( $wpdb != null ) { // Verify that user is allowed to access this page

$enmge_display = 15; // How many records to display

if ( isset($_GET['enmge_gtid']) ) { // Are they viewing groups by group type?
	$enmge_gtid = strip_tags($_GET['enmge_gtid']);
}

if ( isset($_GET['enmge_tid']) ) { // Are they viewing groups by topic?
	$enmge_tid = strip_tags($_GET['enmge_tid']);
}

if ( isset($_GET['enmge_lid']) ) { // Are they viewing groups by location?
	$enmge_lid = strip_tags($_GET['enmge_lid']);
}

if ( isset($_GET['enmge_day']) ) { // Are they viewing groups by day?
	$enmge_day = strip_tags($_GET['enmge_day']);
}

if ( isset($_GET['enmge_gtid']) ) {
	$enmge_countsql = "SELECT group_id FROM " . $wpdb->prefix . "ge_groups" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_id) WHERE group_type_id = " . $enmge_gtid . " GROUP BY group_id ORDER BY group_title ASC"; 
} elseif ( isset($_GET['enmge_tid']) ) {
	$enmge_countsql = "SELECT group_id FROM " . $wpdb->prefix . "ge_groups" . " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (group_id) WHERE topic_id = " . $enmge_tid . " GROUP BY group_id ORDER BY group_title ASC"; 
} elseif ( isset($_GET['enmge_lid']) ) {
	$enmge_countsql = "SELECT group_id FROM " . $wpdb->prefix . "ge_groups" . " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (group_id) WHERE location_id = " . $enmge_lid . " GROUP BY group_id ORDER BY group_title ASC"; 
} elseif ( isset($_GET['enmge_day']) ) {
	$enmge_countsql = "SELECT group_id FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_day = " . $enmge_day . " GROUP BY group_id ORDER BY group_title ASC"; 
} else {
	$enmge_countsql = "SELECT group_id FROM " . $wpdb->prefix . "ge_groups"; 
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

if ( isset($_GET['enmge_gtid']) ) {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_id) WHERE group_type_id = " . $enmge_gtid . " GROUP BY group_id ORDER BY group_title ASC LIMIT %d, %d"; 
} elseif ( isset($_GET['enmge_tid']) ) {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (group_id) WHERE topic_id = " . $enmge_tid . " GROUP BY group_id ORDER BY group_title ASC LIMIT %d, %d"; 
} elseif ( isset($_GET['enmge_lid']) ) {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (group_id) WHERE location_id = " . $enmge_lid . " GROUP BY group_id ORDER BY group_title ASC LIMIT %d, %d"; 
} elseif ( isset($_GET['enmge_day']) ) {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_day = " . $enmge_day . " GROUP BY group_id ORDER BY group_title ASC LIMIT %d, %d"; 
} else {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " ORDER BY group_title ASC LIMIT %d, %d"; 	
}
$enmge_sql = $wpdb->prepare( $enmge_preparredsql, $enmge_start, $enmge_display );
$enmge_groups = $wpdb->get_results( $enmge_sql );

// Deny access to sneaky people!
} else {
	exit("Access Denied");
}
?>