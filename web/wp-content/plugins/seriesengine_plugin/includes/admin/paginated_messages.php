<?php /* ----- Series Engine - Pagination for admin Messages ----- */

global $wpdb;
if ( $wpdb != null ) { // Verify that user is allowed to access this page

$enmse_display = 15; // How many records to display

if ( isset($_GET['enmse_sid']) ) { // Are they viewing messages by series?
	$enmse_sid = strip_tags($_GET['enmse_sid']);
}

if ( isset($_GET['enmse_tid']) ) { // Are they viewing messages by topics?
	$enmse_tid = strip_tags($_GET['enmse_tid']);
}

if ( isset($_GET['enmse_spid']) ) { // Are they viewing messages by speaker?
	$enmse_spid = strip_tags($_GET['enmse_spid']);
}

if ( isset($_GET['enmse_bid']) ) { // Are they viewing messages by book?
	$enmse_bid = strip_tags($_GET['enmse_bid']);
}

if ( isset($_GET['enmse_sid']) ) {
	$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = " . $enmse_sid . " GROUP BY message_id"; 
} elseif ( isset($_GET['enmse_tid']) ) {
	$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE topic_id = " . $enmse_tid . " GROUP BY message_id"; 
} elseif ( isset($_GET['enmse_bid']) ) {
	$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE book_id = " . $enmse_bid . " GROUP BY message_id"; 
} elseif ( isset($_GET['enmse_spid']) ) {
	$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE speaker_id = " . $enmse_spid . " GROUP BY message_id"; 
}else {
	$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages"; 	
}
$enmse_runsqlcount = $wpdb->get_results( $enmse_countsql );
$enmse_messagecount = $wpdb->num_rows;

if ( isset($_GET['enmse_p']) && isset($_GET['enmse_did']) ) { // # of pages already been determined.
	if ($enmse_messagecount > $enmse_display) { // More than 1 page.
		$enmse_pages = ceil($enmse_messagecount/$enmse_display);
	} else {
		$enmse_pages = 1;
	}
} elseif ( isset($_GET['enmse_p']) && is_numeric($_GET['enmse_p']) ) {
	$enmse_pages = strip_tags($_GET['enmse_p']);
} else { // Need to determine # of pages.
	if ($enmse_messagecount > $enmse_display) { // More than 1 page.
		$enmse_pages = ceil($enmse_messagecount/$enmse_display);
	} else {
		$enmse_pages = 1;
	}
}

// Determine where in the database to start returning results...
if (isset($_GET['enmse_c']) && is_numeric($_GET['enmse_c'])) {
	if ( strip_tags($_GET['enmse_c']) >= $enmse_messagecount ) {
		$enmse_start = strip_tags($_GET['enmse_c']) - $enmse_display;
	} else {
		$enmse_start = strip_tags($_GET['enmse_c']);
	}
} else {
	$enmse_start = 0;
}

// Get records from database according to the page and display count

if ( isset($_GET['enmse_sid']) ) { // Are they viewing messages by series?
	$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = " . $enmse_sid . " GROUP BY message_id ORDER BY date DESC LIMIT %d, %d"; 	
} elseif ( isset($_GET['enmse_tid']) ) { // Are they viewing messages by topic?
	$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE topic_id = " . $enmse_tid . " GROUP BY message_id ORDER BY date DESC LIMIT %d, %d"; 	
} elseif ( isset($_GET['enmse_bid']) ) { // Are they viewing messages by book?
	$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE book_id = " . $enmse_bid . " GROUP BY message_id ORDER BY date DESC LIMIT %d, %d"; 	
} elseif ( isset($_GET['enmse_spid']) ) { // Are they viewing messages by topic?
	$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE speaker_id = " . $enmse_spid . " GROUP BY message_id ORDER BY date DESC LIMIT %d, %d"; 	
}  else {
	$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " ORDER BY date DESC LIMIT %d, %d"; 	
}
$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_start, $enmse_display );
$enmse_message = $wpdb->get_results( $enmse_sql );

// Deny access to sneaky people!
} else {
	exit("Access Denied");
}
?>