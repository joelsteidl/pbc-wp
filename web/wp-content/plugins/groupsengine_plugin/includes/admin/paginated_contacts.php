<?php /* ----- Groups Engine - Pagination for admin Contacts ----- */

global $wpdb;
if ( $wpdb != null ) { // Verify that user is allowed to access this page

$enmge_display = 15; // How many records to display

if ( isset($_GET['enmge_cs']) ) { // Are they viewing groups by group type?
	$enmge_cs = strip_tags($_GET['enmge_cs']);
} else {
	$enmge_cs = 0;
}

if ( $enmge_cs == 3 ) {
	$enmge_countsql = "SELECT contact_id FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_status = 'Closed' ORDER BY contact_date DESC";
} elseif ( $enmge_cs == 2 ) {
	$enmge_countsql = "SELECT contact_id FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_status = 'Additional Followup Needed' ORDER BY contact_date DESC";
} elseif ( $enmge_cs == 1 ) {
	$enmge_countsql = "SELECT contact_id FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_status = 'Initial Followup Needed' ORDER BY contact_date DESC";
} elseif ( $enmge_cs == 0 ) {
	$enmge_countsql = "SELECT contact_id FROM " . $wpdb->prefix . "ge_contacts ORDER BY contact_date DESC"; 
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

if ( $enmge_cs == 3 ) {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_status = 'Closed' ORDER BY contact_date DESC LIMIT %d, %d";
} elseif ( $enmge_cs == 2 ) {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_status = 'Additional Followup Needed' ORDER BY contact_date DESC LIMIT %d, %d";
} elseif ( $enmge_cs == 1 ) {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_status = 'Initial Followup Needed' ORDER BY contact_date DESC LIMIT %d, %d";
} elseif ( $enmge_cs == 0 ) {
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts ORDER BY contact_date DESC LIMIT %d, %d"; 
}	
$enmge_sql = $wpdb->prepare( $enmge_preparredsql, $enmge_start, $enmge_display );
$enmge_contacts = $wpdb->get_results( $enmge_sql );

// Deny access to sneaky people!
} else {
	exit("Access Denied");
}
?>