<?php 

	if ( $enmse_de == 1 ) { // Display Lising of Series?
		// --- Pull All Series That Have Messages Associated
		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
			$enmse_spreparredsql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL AND archived = 0 GROUP BY series_id ORDER BY start_date DESC"; 	
			$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_dsst );
			$enmse_series = $wpdb->get_results( $enmse_ssql );
		} elseif ( $enmse_dsst == "n" ) {  // Display Series of Every Series Type
			$enmse_spreparredsql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL AND archived = 0 GROUP BY series_id ORDER BY start_date DESC"; 	
			$enmse_series = $wpdb->get_results( $enmse_spreparredsql );
		}
	}
	
	if ( $enmse_de == 1 ) { // Display Lising of Topics?
		// --- Pull All Topics That Have Messages Associated
		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
			if ( $enmsetopicsort == 1 ) { 
				$enmse_tpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY topic_id ORDER BY sort_id ASC"; 
			} else {
				$enmse_tpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY topic_id ORDER BY name ASC"; 
			}
			$enmse_tsql = $wpdb->prepare( $enmse_tpreparredsql, $enmse_dsst );
			$enmse_topics = $wpdb->get_results( $enmse_tsql );
		} elseif ( $enmse_dsst == "n" ) {  // Display Topics of Every Series Type	
			if ( $enmsetopicsort == 1 ) { 
				$enmse_tpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL GROUP BY topic_id ORDER BY sort_id ASC";
			} else {
				$enmse_tpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL GROUP BY topic_id ORDER BY name ASC";
			}	
			$enmse_topics = $wpdb->get_results( $enmse_tpreparredsql );
		}
	}

	if ( $enmse_de == 1 ) { // Display Lising of Books?
		// --- Pull All Topics That Have Messages Associated
		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type

			$enmse_bpreparredsql = "SELECT book_id, book_name FROM " . $wpdb->prefix . "se_books" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (book_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY book_name ORDER BY book_id ASC"; 
			$enmse_bsql = $wpdb->prepare( $enmse_bpreparredsql, $enmse_dsst );
			$enmse_books = $wpdb->get_results( $enmse_bsql );
		} elseif ( $enmse_dsst == "n" ) {  // Display Topics of Every Series Type	
			$enmse_bpreparredsql = "SELECT book_id, book_name FROM " . $wpdb->prefix . "se_books" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (book_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL GROUP BY book_name ORDER BY book_id ASC";
			$enmse_books = $wpdb->get_results( $enmse_bpreparredsql );
		}
	}
	
	if ( $enmse_de == 1 ) { // Display Lising of Speakers?
		// --- Pull All Speakers That Have Messages Associated
		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
			$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY speaker_id ORDER BY last_name ASC"; 	
			$enmse_spsql = $wpdb->prepare( $enmse_sppreparredsql, $enmse_dsst );
			$enmse_speakers = $wpdb->get_results( $enmse_spsql );
		} elseif ( $enmse_dsst == "n" ) {  // Display Topics of Every Series Type	
			$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL GROUP BY speaker_id ORDER BY last_name ASC"; 	
			$enmse_speakers = $wpdb->get_results( $enmse_sppreparredsql );
		}
	}
	
	// --- Find the Single Message to Display
	if ( (isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am'])) || ($enmse_dam > 0 && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_spid'])) ) { // Are all messages requested?
		if ( (isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid'])) || $enmse_dsm > 0 ) { // Is a specific message requested?
			
			if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Override options for user request
				$enmse_mid = strip_tags($_GET['enmse_mid']);
			} else {
				$enmse_mid = $enmse_dsm;
			}
			
			// Find the message
			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid );
			$enmse_initialmessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );

			if ( empty($enmse_initialmessage) ) {
				$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " WHERE message_id = %d AND (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() ORDER BY date DESC LIMIT 1"; 		
				$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid );
				$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
			} else {
				$enmse_singlemessage = $enmse_initialmessage;
			}

		} else {

			if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display from Specific Series Type

				// Find the message			
	 			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
	 			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_dsst );
	 			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
			
			} else {

				// Find the message
				$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
				$enmse_singlemessage = $wpdb->get_row( $enmse_smpreparredsql, OBJECT );

			}
			
		}

	} elseif ( (isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid'])) || ($enmse_dst > 0 && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a specific topic requested?
		
		if ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) { // Override options for user request
			$enmse_tid = strip_tags($_GET['enmse_tid']);
		} else {
			$enmse_tid = $enmse_dst;
		}
		
		// Find Info the the Specified Topic
		$enmse_sstpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " WHERE topic_id = %d LIMIT 1"; 		
		$enmse_findthetopic = $wpdb->prepare( $enmse_sstpreparredsql, $enmse_tid );
		$enmse_singletopic = $wpdb->get_row( $enmse_findthetopic, OBJECT );
		
		if ( (isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid'])) || $enmse_dsm > 0 ) { // Is a specific message requested?
			
			if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Override options for user request
				$enmse_mid = strip_tags($_GET['enmse_mid']);
			} else {
				$enmse_mid = $enmse_dsm;
			}
			
			// Find the message
			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE message_id = %d AND topic_id = %d GROUP BY message_id"; 		
			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid, $enmse_tid );
			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
		} else {
			// Find the message
			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND topic_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_tid );
			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
		}
	} elseif ( (isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid'])) || ($enmse_dsb > 0 && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_spid'])) ) { // Is a specific book requested?
		
		if ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) { // Override options for user request
			$enmse_bid = strip_tags($_GET['enmse_bid']);
		} else {
			$enmse_bid = $enmse_dsb;
		}
		
		// Find Info the the Specified Topic
		$enmse_sbreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_books" . " WHERE book_id = %d LIMIT 1"; 		
		$enmse_findthebook = $wpdb->prepare( $enmse_sbreparredsql, $enmse_bid );
		$enmse_singlebook = $wpdb->get_row( $enmse_findthebook, OBJECT );
		
		if ( (isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid'])) || $enmse_dsm > 0 ) { // Is a specific message requested?
			
			if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Override options for user request
				$enmse_mid = strip_tags($_GET['enmse_mid']);
			} else {
				$enmse_mid = $enmse_dsm;
			}
			
			// Find the message
			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE message_id = %d AND book_id = %d GROUP BY message_id"; 		
			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid, $enmse_bid );
			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
		} else {
			// Find the message
			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND book_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_bid );
			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
		}
	} elseif ( (isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid'])) || ($enmse_dssp > 0 && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid'])) ) { // Is a specific speaker requested?
	 	
	 	if ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) { // Override options for user request
	 		$enmse_spid = strip_tags($_GET['enmse_spid']);
	 	} else {
	 		$enmse_spid = $enmse_dssp;
	 	}
	 	
	 	// Find Info the the Specified Speaker
	 	$enmse_sssppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id = %d LIMIT 1"; 		
	 	$enmse_findthespeaker = $wpdb->prepare( $enmse_sssppreparredsql, $enmse_spid );
	 	$enmse_singlespeaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
	 	
	 	if ( (isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid'])) || $enmse_dsm > 0 ) { // Is a specific message requested?
	 		
	 		if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Override options for user request
	 			$enmse_mid = strip_tags($_GET['enmse_mid']);
	 		} else {
	 			$enmse_mid = $enmse_dsm;
	 		}
	 		
	 		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
	 			// Find the message			
	 			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id = %d AND speaker_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
	 			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_dsst, $enmse_mid, $enmse_spid );
	 			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
	 		} elseif ( $enmse_dsst == "n" ) {  // Display Topics of Every Series Type	
	 			// Find the message			
	 			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id = %d AND speaker_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
	 			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid, $enmse_spid );
	 			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
	 		}
	 	} else {
	 		if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
	 			// Find the message			
	 			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND speaker_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
	 			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_dsst, $enmse_spid );
	 			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
	 		} elseif ( $enmse_dsst == "n" ) {  // Display Topics of Every Series Type	
	 			// Find the message			
	 			$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND speaker_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
	 			$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_spid );
	 			$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
	 		}
	 	}
	 } else {
		if ( (isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid'])) || $enmse_dss > 0 ) { // Is a specific series requested?

			if ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) { // Override options for user request
				$enmse_sid = strip_tags($_GET['enmse_sid']);
			} else {
				$enmse_sid = $enmse_dss;
			}
			
			if ( (isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid'])) || $enmse_dsm > 0 ) { // Is a specific message requested?
				
				if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Override options for user request
					$enmse_mid = strip_tags($_GET['enmse_mid']);
				} else {
					$enmse_mid = $enmse_dsm;
				}
				
				// Find the message
				$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE message_id = %d AND series_id = %d GROUP BY message_id"; 		
				$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid, $enmse_sid );
				$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
			} else {
				// Find the message
				$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_id = %d GROUP BY message_id ORDER BY date " . $enmse_sort . " LIMIT 1"; 		
				$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_sid );
				$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
			}
		} else {
			if ( (isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid'])) || $enmse_dsm > 0 ) { // Is a specific message requested?
				
				if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Override options for user request
					$enmse_mid = strip_tags($_GET['enmse_mid']);
				} else {
					$enmse_mid = $enmse_dsm;
				}
				
				// Find the message PERMALINK
				$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE message_id = %d GROUP BY message_id"; 		
				$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid );
				$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
			} else {
				// Find Most Recent Message 
				if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
					$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND archived = 0 GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
					$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_dsst );
					$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
				} elseif ( $enmse_dsst == "n" ) {  // Display Topics of Every Series Type	
					$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND archived = 0 GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
					$enmse_singlemessage = $wpdb->get_row( $enmse_smpreparredsql, OBJECT );
				}
			}
		}
	}
	
	// --- Find Series Info for Current Message
	if ( (isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid'])) || ($enmse_dst > 0 && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) || (isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid'])) || ($enmse_dsb > 0 && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_spid'])) ) { // Is a specific topic or book requested?
		if ( !empty($enmse_singlemessage) ) {
			// Find the Series Titles for the Message
			$enmse_stpreparredsql = "SELECT s_title, series_id FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) WHERE message_id = %d GROUP BY series_id ORDER BY start_date ASC"; 	
			$enmse_stsql = $wpdb->prepare( $enmse_stpreparredsql, $enmse_singlemessage->message_id  );
			$enmse_seriestitles = $wpdb->get_results( $enmse_stsql );
			if ( isset($enmse_singlemessage->primary_series) ) {
				// Find the Series Title/ID that corresponds to the Most Recent Message
				$enmse_sspreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 		
				$enmse_findtheseries = $wpdb->prepare( $enmse_sspreparredsql, $enmse_singlemessage->primary_series );
				$enmse_singleseries = $wpdb->get_row( $enmse_findtheseries, OBJECT );
			}
		}
	} else {
		if ( !empty($enmse_singlemessage) ) {
			if ( !isset($enmse_singlemessage->series_id) ) { // No series associated
			} else {
				// Find the Series Title/ID that corresponds to the Most Recent Message
				$enmse_sspreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 		
				$enmse_findtheseries = $wpdb->prepare( $enmse_sspreparredsql, $enmse_singlemessage->series_id );
				$enmse_singleseries = $wpdb->get_row( $enmse_findtheseries, OBJECT );
			}
		}
	}
	
	if ( $enmse_scm == 1 ) { // If complimentary messages are enabled...
		// --- Find Complimentary Messages
		include('pagination/wopaginatedrelated.php');
		
	}
	
	if ( !empty($enmse_singlemessage) ) {
		// --- Find Topics for the Most Recent Message
		if ( $enmsetopicsort == 1 ) { 
			$enmse_mtpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) WHERE message_id = %d GROUP BY topic_id ORDER BY sort_id ASC"; 
		} else {
			$enmse_mtpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) WHERE message_id = %d GROUP BY topic_id ORDER BY name ASC"; 
		}	
		$enmse_mtsql = $wpdb->prepare( $enmse_mtpreparredsql, $enmse_singlemessage->message_id );
		$enmse_messagetopics = $wpdb->get_results( $enmse_mtsql );
	}
	
	if ( !empty($enmse_singlemessage) ) {
		// Get the Speaker
		$enmse_findthespeakersql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches USING (speaker_id) WHERE message_id = %d GROUP BY first_name LIMIT 1"; 
		$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_singlemessage->message_id );
		$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
	}
	
	if ( !empty($enmse_singlemessage) ) {
		// Get All Files
		$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d GROUP BY file_id ORDER BY sort_id ASC"; 
		$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_singlemessage->message_id );
		$enmse_files = $wpdb->get_results( $enmse_fsql );
	}

	if ( !empty($enmse_singlemessage) ) {
		// Get All Scripture References
		$enmse_preparredscsql= "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
		$enmse_scsql= $wpdb->prepare( $enmse_preparredscsql, $enmse_singlemessage->message_id );
		$enmse_scriptures = $wpdb->get_results( $enmse_scsql);
	}

 ?>