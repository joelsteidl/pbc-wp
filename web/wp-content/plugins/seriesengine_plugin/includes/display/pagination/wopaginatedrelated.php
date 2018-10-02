<?php /* Series Engine - Paginate related messages from custom embed codes */

global $wpdb;
if ( $wpdb != null ) { // Verify that user is allowed to access this page

	if ( $enmse_pag != 0 ) {
		$enmse_display = $enmse_pag;
	} else {
		$enmse_display = $enmse_dpag; // How many records to display
	}

	if ( (isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid'])) || ($enmse_dst > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { /* Is a specific topic requested? */
		// Find all other Messages from that Topic

		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_type_id = " . $enmse_dsst . " AND topic_id = " . $enmse_tid . " GROUP BY message_id ORDER BY date " . $enmse_sort; 
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_type_id = %d AND topic_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_dsst, $enmse_tid, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		} elseif ( $enmse_dsst == "n" ) {
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND topic_id = " . $enmse_tid . " GROUP BY message_id ORDER BY date " . $enmse_sort;
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND topic_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_tid, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		} else {
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND topic_id = " . $enmse_tid . " GROUP BY message_id ORDER BY date " . $enmse_sort;
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND topic_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_tid, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		}

		
	} elseif ( (isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid'])) || ($enmse_dsb > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_spid'])) ) { /* Is a specific book requested? */
		// Find all other Messages from that Topic

		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_type_id = " . $enmse_dsst . " AND book_id = " . $enmse_bid . " GROUP BY message_id ORDER BY date " . $enmse_sort; 
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_type_id = %d AND book_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_dsst, $enmse_bid, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		} elseif ( $enmse_dsst == "n" ) {
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND book_id = " . $enmse_bid . " GROUP BY message_id ORDER BY date " . $enmse_sort;
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND book_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_bid, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		} else {
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND book_id = " . $enmse_bid . " GROUP BY message_id ORDER BY date " . $enmse_sort;
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND book_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_bid, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		}

		
	} elseif ( (isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid'])) || ($enmse_dssp > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid'])) ) { /* Is a specific speaker requested? */
		// Find all other Messages from that Speaker

		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type

			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_type_id = " . $enmse_dsst . " AND speaker_id = " . $enmse_spid . " GROUP BY message_id ORDER BY date " . $enmse_sort;
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_type_id = %d AND speaker_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_dsst, $enmse_spid, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		} elseif ( $enmse_dsst == "n" ) {  // Display speakers of Every Series Type	
			
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND speaker_id = " . $enmse_spid . " GROUP BY message_id ORDER BY date " . $enmse_sort; 
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND speaker_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_spid, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		}

	} elseif ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) || ($enmse_dam > 0 && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid']) )) { // Display All Messages

		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type

			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_type_id = " . $enmse_dsst . " GROUP BY message_id ORDER BY date " . $enmse_sort;
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_type_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_dsst, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		} elseif ( $enmse_dsst == "n" ) {  // Display speakers of Every Series Type	
			
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() GROUP BY message_id ORDER BY date " . $enmse_sort; 
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		}

	} else { /* REGULAR SORT */
		if ( !empty($enmse_singlemessage) && $enmse_singlemessage->series_id  != null ) {
			// Find out how many related messages there are
			$enmse_countsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_id = " . $enmse_singlemessage->series_id . " GROUP BY message_id ORDER BY date ASC";	
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

			// Pull the correct related messages from the database
			$enmse_sempreparredsql = "SELECT message_id, title, date, speaker, alternate_date, embed_code, audio_url, alternate_toggle, alternate_label, alternate_embed, video_embed_url, additional_video_embed_url, message_thumbnail, series_thumbnail, file_name, file_url, file_new_window, focus_scripture FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' )))AND date <= CURDATE() AND series_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT %d, %d"; 	
			$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $enmse_singlemessage->series_id, $enmse_start, $enmse_display );
			$enmse_seriesmessages = $wpdb->get_results( $enmse_semsql );
		}
	}

	

// Deny access to sneaky people!
} else {
	exit("Access Denied");
}

 ?>