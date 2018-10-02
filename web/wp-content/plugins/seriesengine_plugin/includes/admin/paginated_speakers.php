<?php /* ----- Series Engine - Admin, return paginated Speakers ----- */

global $wpdb;
if ( $wpdb != null ) { // Verify that user is allowed to access this page

$enmse_display = 15; // How many records to display


$enmse_countsql = "SELECT speaker_id FROM " . $wpdb->prefix . "se_speakers"; 	

$enmse_runsqlcount = $wpdb->get_results( $enmse_countsql );
$enmse_speakerscount = $wpdb->num_rows;

if ( isset($_GET['enmse_p']) && isset($_GET['enmse_did']) ) { // # of pages already been determined.
	if ($enmse_speakerscount > $enmse_display) { // More than 1 page.
		$enmse_pages = ceil($enmse_speakerscount/$enmse_display);
	} else {
		$enmse_pages = 1;
	}
} elseif ( isset($_GET['enmse_p']) && is_numeric($_GET['enmse_p']) ) {
	$enmse_pages = strip_tags($_GET['enmse_p']);
} else { // Need to determine # of pages.
	if ($enmse_speakerscount > $enmse_display) { // More than 1 page.
		$enmse_pages = ceil($enmse_speakerscount/$enmse_display);
	} else {
		$enmse_pages = 1;
	}
}

// Determine where in the database to start returning results...
if (isset($_GET['enmse_c']) && is_numeric($_GET['enmse_c'])) {
	if ( strip_tags($_GET['enmse_c']) >= $enmse_speakerscount ) {
		$enmse_start = strip_tags($_GET['enmse_c']) - $enmse_display;
	} else {
		$enmse_start = strip_tags($_GET['enmse_c']);
	}
} else {
	$enmse_start = 0;
}

// Get records from database according to the page and display count


$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name ASC LIMIT %d, %d"; 	
$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_start, $enmse_display );
$enmse_speakers = $wpdb->get_results( $enmse_sql );

// Deny access to sneaky people!
} else {
	exit("Access Denied");
}
?>