<?php /* Groups Engine - Send Email to Administrators When a New Contact is Received */
	
	if ( $wp_version != null ) {
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

		// Get All Leaders
		$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
		$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_gid );
		$enmge_leaders = $wpdb->get_results( $enmge_lesql );
		
		if ( is_array( $enmge_users ) ) { /* Loop through each user. */
			$enmge_moderate_url = wp_login_url( admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&enmge_action=edit&enmge_cid=" . $enmge_ciid ); 
			foreach ( $enmge_users as $user ) { 
				$enmge_admin_message = "Someone has a question about the " . stripslashes($enmge_grouptitle) . ", \"" . stripslashes($enmge_group_title) . ".\"\n\n";
				$enmge_admin_message .= "Their Name: " . stripslashes($enmge_name) . "\n";
				$enmge_admin_message .= "Their Email: " . $enmge_email . "\n";
				$enmge_admin_message .= "Their Phone Number: " . $enmge_phone . "\n\n";
				$enmge_admin_message .= "Received on " . date_i18n($enmge_dateformat, strtotime($enmge_date)) . " at " . date('g:i A', strtotime($enmge_date)) . "\n\n";
				$enmge_admin_message .= stripslashes($enmge_message) . "\n\n\n";
				$enmge_admin_message .= "Use this link to update the contact and view notes from others:\n\n";
				$enmge_admin_message .= $enmge_moderate_url . "\n\n";
				$enmge_admin_message .= "The following " . stripslashes($enmge_grouptitle) . " leaders have also been notified:\n\n";
				foreach ( $enmge_leaders as $l ) {
					$enmge_admin_message .= stripslashes($l->leader_name) . " (" . $l->leader_email . ")\n";
				}
				$enmge_admin_message .= "\nThis is an automated notification sent from " . home_url() . ". Please do not respond to this email, as this account is not monitored. You can unsubscribe from these emails in your WordPress User settings.";
				$enmge_admin_email_to = $user->user_email; 
				$enmge_admin_email_subject = 'New ' . stripslashes($enmge_grouptitle) . ' Contact'; 
				$enmge_admin_email_header = 'From: "' . stripslashes($enmge_emailname) . '" <' . stripslashes($enmge_emailaddress) . '>'; 
				wp_mail( $enmge_admin_email_to, $enmge_admin_email_subject, $enmge_admin_message, $enmge_admin_email_header ); 
			} 
		}
	// Deny access to sneaky people!
	} else {
		exit("Access Denied");
	}

?>