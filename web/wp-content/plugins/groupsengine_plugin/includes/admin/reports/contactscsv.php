<?php /* Groups Engine - CSV Report for Contacts */
	require_once 'report_header.php';

	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=contacts.csv');

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');

	// output the column headings
	fputcsv($output, array('Name', stripslashes($enmge_grouptitle) . ' Title', 'Email', 'Phone', 'Date Received', 'Last Updated By', 'Status', 'Message', 'Additional Notes'));

// loop over the rows, outputting them

	
	if ( current_user_can( 'edit_posts' ) ) { 
		
		if ( $_POST ) {
			global $wpdb;
		
			$enmge_contact_date = strip_tags($_POST['enmge_contactrange']);
			$enmge_contact_options = strip_tags($_POST['enmge_contactoptions']);

			if ( $enmge_contact_options == '0' ) {
				$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts WHERE (contact_date >= %s OR contact_last_update_day >= %s) ORDER BY contact_date DESC";
				$enmge_findthecontacts = $wpdb->prepare( $enmge_preparredsql, $enmge_contact_date, $enmge_contact_date ); 	
				$enmge_contacts = $wpdb->get_results( $enmge_findthecontacts );
			} else {
				$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts WHERE (contact_date >= %s OR contact_last_update_day >= %s) AND contact_status = %s ORDER BY contact_date DESC";
				$enmge_findthecontacts = $wpdb->prepare( $enmge_preparredsql, $enmge_contact_date, $enmge_contact_date, $enmge_contact_options ); 	
				$enmge_contacts = $wpdb->get_results( $enmge_findthecontacts );
			}
			

			$enmge_preparredsqln = "SELECT * FROM " . $wpdb->prefix . "ge_contact_notes ORDER BY contact_note_date DESC"; 	
			$enmge_notes = $wpdb->get_results( $enmge_preparredsqln );
		}
	
foreach ($enmge_contacts as $contact) { 
	/* Name */ $contactrow[] = stripslashes($contact->contact_name);
	/* Group Title */ $contactrow[] = stripslashes($contact->contact_group_title);
	/* Email */ $contactrow[] = stripslashes($contact->contact_email);
	/* Phone */ $contactrow[] = stripslashes($contact->contact_phone);
	/* Date Received */ $contactrow[] = date('F j, Y', strtotime($contact->contact_date)) . ' at ' . date('g:i A', strtotime($contact->contact_date));
	/* Last Updated By */ $contactrow[] = stripslashes($contact->contact_last_update);
	/* Status */ $contactrow[] = $contact->contact_status;
	/* Message */ $contactrow[] = stripslashes($contact->contact_message);
	$notegroup = '';
	foreach ($enmge_notes as $note) { 
		if ($note->contact_id == $contact->contact_id) { 
	  		$notegroup .= stripslashes($note->contact_note_user) . ' on ' . date('F j', strtotime($note->contact_note_date)) . ' at ' . date('g:i A', strtotime($note->contact_note_date)) . ': ' . stripslashes($note->contact_note) . ' | ';
		} 
	} 
	/* Notes */ $contactrow[] = $notegroup;
	fputcsv($output, $contactrow);
	unset($contactrow);
}

} else {
	$enmge_redirecturl = home_url();
	header("Location: $enmge_redirecturl");
} ?>