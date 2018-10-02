<?php /* Series Engine - Paginated Series for Archives */

global $wpdb;
if ( $wpdb != null ) { // Verify that user is allowed to access this page

	if ( $enmse_apag != 0 ) {
		$enmse_adisplay = $enmse_apag;
	} else {
		$enmse_adisplay = $enmse_dapag; // How many records to display
	}

	if ( $enmse_lo == 1 ) { //Custom Embed?
		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type

			// Find out how many series there are
			$enmse_acountsql = "SELECT series_id FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = " . $enmse_dsst . " AND message_id IS NOT NULL GROUP BY series_id ORDER BY start_date DESC";  
			$enmse_arunsqlcount = $wpdb->get_results( $enmse_acountsql );
			$enmse_archivecount = $wpdb->num_rows;

			if ( isset($_GET['enmse_ap']) && isset($_GET['enmse_did']) ) { // # of pages already been determined.
				if ($enmse_archivecount > $enmse_adisplay) { // More than 1 page.
					$enmse_apages = ceil($enmse_archivecount/$enmse_adisplay);
				} else {
					$enmse_apages = 1;
				}
			} elseif ( isset($_GET['enmse_ap']) && is_numeric($_GET['enmse_ap']) ) {
				$enmse_apages = strip_tags($_GET['enmse_ap']);
			} else { // Need to determine # of pages.
				if ($enmse_archivecount > $enmse_adisplay) { // More than 1 page.
					$enmse_apages = ceil($enmse_archivecount/$enmse_adisplay);
				} else {
					$enmse_apages = 1;
				}
			}

			// Determine where in the database to start returning results...
			if (isset($_GET['enmse_ac']) && is_numeric($_GET['enmse_ac'])) {
				if ( strip_tags($_GET['enmse_ac']) >= $enmse_archivecount ) {
					$enmse_astart = strip_tags($_GET['enmse_ac']) - $enmse_adisplay;
				} else {
					$enmse_astart = strip_tags($_GET['enmse_ac']);
				}
			} else {
				$enmse_astart = 0;
			}

			// Pull the correct series from the database
			$enmse_spreparredsql = "SELECT series_id, s_title, start_date, graphic_thumb FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY series_id ORDER BY start_date DESC LIMIT %d, %d"; 	
			$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_dsst, $enmse_astart, $enmse_adisplay );
			$enmse_series = $wpdb->get_results( $enmse_ssql );
		} elseif ( $enmse_dsst == "n" ) { // Display all Series Types

			// Find out how many series there are
			$enmse_acountsql = "SELECT series_id FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL GROUP BY series_id ORDER BY start_date DESC";  
			$enmse_arunsqlcount = $wpdb->get_results( $enmse_acountsql );
			$enmse_archivecount = $wpdb->num_rows;

			if ( isset($_GET['enmse_ap']) && isset($_GET['enmse_did']) ) { // # of pages already been determined.
				if ($enmse_archivecount > $enmse_adisplay) { // More than 1 page.
					$enmse_apages = ceil($enmse_archivecount/$enmse_adisplay);
				} else {
					$enmse_apages = 1;
				}
			} elseif ( isset($_GET['enmse_ap']) && is_numeric($_GET['enmse_ap']) ) {
				$enmse_apages = strip_tags($_GET['enmse_ap']);
			} else { // Need to determine # of pages.
				if ($enmse_archivecount > $enmse_adisplay) { // More than 1 page.
					$enmse_apages = ceil($enmse_archivecount/$enmse_adisplay);
				} else {
					$enmse_apages = 1;
				}
			}

			// Determine where in the database to start returning results...
			if (isset($_GET['enmse_ac']) && is_numeric($_GET['enmse_ac'])) {
				if ( strip_tags($_GET['enmse_ac']) >= $enmse_archivecount ) {
					$enmse_astart = strip_tags($_GET['enmse_ac']) - $enmse_adisplay;
				} else {
					$enmse_astart = strip_tags($_GET['enmse_ac']);
				}
			} else {
				$enmse_astart = 0;
			}

			// Pull the correct series from the database
			$enmse_spreparredsql = "SELECT series_id, s_title, start_date, graphic_thumb FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL GROUP BY series_id ORDER BY start_date DESC LIMIT %d, %d"; 	
			$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_astart, $enmse_adisplay );
			$enmse_series = $wpdb->get_results( $enmse_ssql );
		}
	} else { // Normal Embed Code
		$enmse_dsst = $enmse_primaryst;
		
		// Find out how many series there are
		$enmse_acountsql = "SELECT series_id, s_title, start_date, graphic_thumb FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = " . $enmse_primaryst . " AND message_id IS NOT NULL GROUP BY series_id ORDER BY start_date DESC";
		$enmse_arunsqlcount = $wpdb->get_results( $enmse_acountsql );
		$enmse_archivecount = $wpdb->num_rows;

		if ( isset($_GET['enmse_ap']) && isset($_GET['enmse_did']) ) { // # of pages already been determined.
			if ($enmse_archivecount > $enmse_adisplay) { // More than 1 page.
				$enmse_apages = ceil($enmse_archivecount/$enmse_adisplay);
			} else {
				$enmse_apages = 1;
			}
		} elseif ( isset($_GET['enmse_ap']) && is_numeric($_GET['enmse_ap']) ) {
			$enmse_apages = strip_tags($_GET['enmse_ap']);
		} else { // Need to determine # of pages.
			if ($enmse_archivecount > $enmse_adisplay) { // More than 1 page.
				$enmse_apages = ceil($enmse_archivecount/$enmse_adisplay);
			} else {
				$enmse_apages = 1;
			}
		}

		// Determine where in the database to start returning results...
		if (isset($_GET['enmse_ac']) && is_numeric($_GET['enmse_ac'])) {
			if ( strip_tags($_GET['enmse_ac']) >= $enmse_archivecount ) {
				$enmse_astart = strip_tags($_GET['enmse_ac']) - $enmse_adisplay;
			} else {
				$enmse_astart = strip_tags($_GET['enmse_ac']);
			}
		} else {
			$enmse_astart = 0;
		}

			// Pull the correct series from the database
		$enmse_spreparredsql = "SELECT series_id, s_title, start_date, graphic_thumb FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY series_id ORDER BY start_date DESC LIMIT %d, %d"; 	
		$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_primaryst, $enmse_astart, $enmse_adisplay );
		$enmse_series = $wpdb->get_results( $enmse_ssql );
	}

// Deny access to sneaky people!
} else {
	exit("Access Denied");
}

?>