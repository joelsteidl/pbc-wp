<?php /* Groups Engine - Send Email to Administrators When a Contact is Updated */
	
	if ( $wp_version != null ) {

		// Get All Group Group Type Matches
		$enmge_ggtpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_type_id) WHERE group_id = %d GROUP BY group_type_id ORDER BY group_type_title ASC"; 	
		$enmge_ggtsql = $wpdb->prepare( $enmge_ggtpreparredsql, $enmge_single->contact_group_id );
		$enmge_groupgrouptypes = $wpdb->get_results( $enmge_ggtsql );
		$enmge_gtcount = $wpdb->num_rows;

		if ( $enmge_gtcount > 1 ) {
				$multusercontent['relation'] = 'OR';
				foreach ($enmge_groupgrouptypes as $enmge_gt) { 
					$multusercontent[] = array(
						'key' => 'groupsengine_admin_grouptype' . $enmge_gt->group_type_id,
						'value' => '1',
						'compare' => '='
					);
				}		
				
				$enmge_users = get_users( 
					array(
						'meta_query' => $multusercontent

					) 
				);
				
		} else {
			foreach ($enmge_groupgrouptypes as $enmge_gt) {
				$enmge_users = get_users( 
					array( 
						'meta_key' => 'groupsengine_admin_grouptype' . $enmge_gt->group_type_id,
						'meta_value' => '1',
						'meta_compare' => '='
					) 
				);
			}
		}

		$enmge_ciid = $wpdb->insert_id; 
		
		if ( is_array( $enmge_users ) ) { /* Loop through each user. */
			$enmge_moderate_url = wp_login_url( admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&enmge_action=edit&enmge_cid=" . $enmge_cid ); 
			foreach ( $enmge_users as $user ) { 
				$enmge_admin_message = stripslashes($enmge_group_leader) . " just made an update to a recent contact for the " . stripslashes($grouptitle) . ", \"" . stripslashes($enmge_single->contact_group_title) . ".\"\n\n";
				$enmge_admin_message .= "Contact Status: " . stripslashes($enmge_single->contact_status) . "\n";
				$enmge_admin_message .= "Their Name: " . stripslashes($enmge_single->contact_name) . "\n";
				$enmge_admin_message .= "Their Email: " . $enmge_single->contact_email . "\n";
				$enmge_admin_message .= "Their Phone Number: " . $enmge_single->contact_phone . "\n\n";
				$enmge_admin_message .= "Received on " . date('F j, Y', strtotime($enmge_single->contact_date)) . " at " . date('g:i A', strtotime($enmge_single->contact_date)) . "\n\n";
				$enmge_admin_message .= stripslashes($enmge_single->contact_message) . "\n\n\n";
				if ( !empty($enmge_notes) ) { $enmge_admin_message .= "Notes:\n\n"; }
				foreach ( $enmge_notes as $note ) { 
					$enmge_admin_message .= stripslashes($note->contact_note_user) . " on " . date('F j', strtotime($note->contact_note_date)) . " at " . date('g:i A', strtotime($note->contact_note_date)) . ":\n";
					$enmge_admin_message .= stripslashes("\"" . $note->contact_note . "\"\n\n");
				};
				$enmge_admin_message .= "Use this link to update the contact and view notes from others:\n\n";
				$enmge_admin_message .= $enmge_moderate_url . "\n\n";
				$enmge_admin_message .= "This is an automated notification sent from " . home_url() . ". Please do not respond to this email, as this account is not monitored. You can unsubscribe from these emails in your WordPress User settings.";
				$enmge_admin_email_to = $user->user_email; 
				$enmge_admin_email_subject = 'Contact Update from ' . stripslashes($enmge_group_leader); 
				$enmge_admin_email_header = 'From: "' . stripslashes($emailname) . '" <' . stripslashes($emailaddress) . '>'; 
				wp_mail( $enmge_admin_email_to, $enmge_admin_email_subject, $enmge_admin_message, $enmge_admin_email_header ); 
			} 
		}
	// Deny access to sneaky people!
	} else {
		exit("Access Denied");
	}

?>