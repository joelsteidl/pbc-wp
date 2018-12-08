<?php /* Groups Engine - Email Group Leader When a Contact is Updated */

if ( $wp_version != null ) {

function set_html_content_type() {
	return 'text/html';
}

// Get All Leaders
$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_single->contact_group_id );
$enmge_leaders = $wpdb->get_results( $enmge_lesql );
	
foreach ($enmge_leaders as $l) {	
	$enmge_leader_message = "<p>This contact has been updated for your " . stripslashes($enmge_grouptitle) . ", " . stripslashes($enmge_single->contact_group_title) . "!</p>";
	$enmge_leader_message .= "<p>Contact Status: <strong>" . $enmge_status . "</strong><br />";
	$enmge_leader_message .= "Their Name: " . stripslashes($enmge_single->contact_name) . "<br />";
	$enmge_leader_message .= "Their Email: " . $enmge_single->contact_email . "<br />";
	$enmge_leader_message .= "Their Phone Number: " . $enmge_single->contact_phone . "<br />";
	$enmge_leader_message .= "Received on " . date('F j, Y', strtotime($enmge_single->contact_date)) . " at " . date('g:i A', strtotime($enmge_single->contact_date)) . "</p>";
	$enmge_leader_message .= stripslashes($enmge_single->contact_message) . "<br /><br />";
	if ( !empty($enmge_notes) ) { $enmge_leader_message .= "<strong>Notes:</strong><br /><br />"; }
	foreach ( $enmge_notes as $note ) { 
		$enmge_leader_message .= stripslashes($note->contact_note_user) . " on " . date('F j', strtotime($note->contact_note_date)) . " at " . date('g:i A', strtotime($note->contact_note_date)) . ":<br />";
		$enmge_leader_message .= stripslashes('&quot;' . $note->contact_note . '&quot;<br /><br />');
	};
	$enmge_leader_message .= "<p><strong>Update this contact with one click:</strong> (NO LOG IN REQUIRED!)</p>";
	$enmge_leader_message .= "<ul><li><a href=\"" . plugins_url() . "/groupsengine_plugin/contacts/edit.php?enmge_mc=" . $enmge_single->contact_modcode . "&enmge_n=" . urlencode($l->leader_name) . "&enmge_qc=1\">They're joining our " . stripslashes($enmge_grouptitle) . "!</a></li>";
	$enmge_leader_message .= "<li><a href=\"" . plugins_url() . "/groupsengine_plugin/contacts/edit.php?enmge_mc=" . $enmge_single->contact_modcode . "&enmge_n=" . urlencode($l->leader_name) . "&enmge_qc=2\">I answered their question... No additional followup needed.</a></li>";
	$enmge_leader_message .= "<li><a href=\"" . plugins_url() . "/groupsengine_plugin/contacts/edit.php?enmge_mc=" . $enmge_single->contact_modcode . "&enmge_n=" . urlencode($l->leader_name) . "&enmge_qc=3\">I couldn't answer their question... More followup needed.</a></li>";
	$enmge_leader_message .= "<li><a href=\"" . plugins_url() . "/groupsengine_plugin/contacts/edit.php?enmge_mc=" . $enmge_single->contact_modcode . "&enmge_n=" . urlencode($l->leader_name) . "&enmge_qc=4\">I couldn't get in touch with them.</a></li></ul>";
	$enmge_leader_message .= "<p><a href=\"" . plugins_url() . "/groupsengine_plugin/contacts/edit.php?enmge_mc=" . $enmge_single->contact_modcode . "&enmge_n=" . urlencode($l->leader_name) . "\">Click here</a> for more options and to view existing updates.</p>";
	$enmge_leader_message .= "<p>This is an automated notification sent from " . home_url() . ". Please do not respond to this email, as this account is not monitored.</p>";
	$enmge_leader_to = $l->leader_email; 
	$enmge_leader_subject = 'Contact Updated for Your ' . stripslashes($enmge_grouptitle); 
	$enmge_leader_header = 'From: "' . $enmge_emailname . '" <' . $enmge_emailaddress . '>'; 
	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	wp_mail( $enmge_leader_to, $enmge_leader_subject, $enmge_leader_message, $enmge_leader_header );

	remove_filter ( 'wp_mail_content_type', 'set_html_content_type' );
} 

// Deny access to sneaky people!
} else {
	exit("Access Denied");
}

?>