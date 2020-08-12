<?php /* ----- Series Engine - Pull in media browser links with AJAX ----- */
	
	global $wpdb;
	global $wp_version;

	if ( $wp_version != null ) {

	$enmse_options = get_option( 'enm_seriesengine_options' ); 
	$enmse_primaryst = $enmse_options['primaryst'];
	$enmse_videotablabel = $enmse_options['videotablabel'];
	$enmse_audiotablabel = $enmse_options['audiotablabel'];
	$enmse_playerdetailsbackground = $enmse_options['playerdetailsbackground'];
	$enmse_poweredby = $enmse_options['poweredby'];
	$enmse_dateformat = get_option( 'date_format' ); 

	$embedoptions = $_REQUEST['embedoptions']; // Parse Values via new AJAX method
	$ajaxvalues = $_REQUEST['ajaxvalues'];
	$enmse_permalink = $_REQUEST['enmse_permalink'];
	$combinedvalues = "?" . $embedoptions . $ajaxvalues;
	$ajax_query_str = parse_url($combinedvalues, PHP_URL_QUERY);
	parse_str($ajax_query_str, $ajaxvars);
	foreach ($ajaxvars as $key => $value) {
		$_GET[$key] = $value;
	}

	if ( isset($enmse_options['archiveliststyle']) ) { 
		$enmse_archivetype = $enmse_options['archiveliststyle'];
	} else {
		$enmse_archivetype = 0;
	}

	if ( isset($enmse_options['placeholderimage']) && $enmse_options['placeholderimage'] != null ) { 
		$enmse_placeholderimage = $enmse_options['placeholderimage'];
	} else {
		$enmse_placeholderimage = plugins_url() . '/seriesengine_plugin/images/series_thumb_placeholder.jpg';
	}

	if ( isset($enmse_options['forcedownload']) ) { 
		$enmse_force = $enmse_options['forcedownload'];
	} else {
		$enmse_force = 1;
	}


	// ***** Get Labels

	if ( isset($enmse_options['seriest']) ) { // Find Series Title
		$enmseseriest = $enmse_options['seriest'];
	} else {
		$enmseseriest = "Series";
	}

	if ( isset($enmse_options['seriestp']) ) { // Find Series Title (plural)
		$enmseseriestp = $enmse_options['seriestp'];
	} else {
		$enmseseriestp = "Series";
	}

	if ( isset($enmse_options['topict']) ) { // Find Topic Title
		$enmsetopict = $enmse_options['topict'];
	} else {
		$enmsetopict = "Topic";
	}

	if ( isset($enmse_options['topictp']) ) { // Find Topic Title (plural)
		$enmsetopictp = $enmse_options['topictp'];
	} else {
		$enmsetopictp = "Topics";
	}

	if ( isset($enmse_options['speakert']) ) { // Find Speaker Title
		$enmsespeakert = $enmse_options['speakert'];
	} else {
		$enmsespeakert = "Speaker";
	}

	if ( isset($enmse_options['speakertp']) ) { // Find Speakers Title (plural)
		$enmsespeakertp = $enmse_options['speakertp'];
	} else {
		$enmsespeakertp = "Speakers";
	}

	if ( isset($enmse_options['messaget']) ) { // Find Message Title
		$enmsemessaget = $enmse_options['messaget'];
	} else {
		$enmsemessaget = "Message";
	}

	if ( isset($enmse_options['messagetp']) ) { // Find Message Title (plural)
		$enmsemessagetp = $enmse_options['messagetp'];
	} else {
		$enmsemessagetp = "Messages";
	}

	include(ENMSE_PLUGIN_PATH . 'includes/lang/language_settings.php');

	// ***** DEFINE EMBED OPTIONS
	$enmse_lo = strip_tags($_GET['enmse_lo']);
	$enmse_a = strip_tags($_GET['enmse_a']);
	$enmse_cardview = strip_tags($_GET['enmse_cv']);

	if ( isset($enmse_options['pag']) ) { // Default pagination
		$enmse_dpag = $enmse_options['pag'];
	} else {
		$enmse_dpag = 10;
	}

	if ( isset($_GET['enmse_pag']) )  { // current page number
		$enmse_pag = strip_tags($_GET['enmse_pag']);
	} else {
		$enmse_pag = 0;
	}

	if ( isset($enmse_options['topicsort']) ) { // Sort Topics Manually?
		$enmsetopicsort = $enmse_options['topicsort'];
	} else {
		$enmsetopicsort = 1;
	}

	if ( $enmse_lo == 1 ) {
			$enmse_de = strip_tags($_GET['enmse_de']);
			$enmse_d = strip_tags($_GET['enmse_d']);
			$enmse_sh = strip_tags($_GET['enmse_sh']);
			$enmse_ex = strip_tags($_GET['enmse_ex']);
			$enmse_dsm = strip_tags($_GET['enmse_dsm']);
			$enmse_dss = strip_tags($_GET['enmse_dss']);
			$enmse_dst = strip_tags($_GET['enmse_dst']);
			$enmse_dsb = strip_tags($_GET['enmse_dsb']);
			$enmse_dssp = strip_tags($_GET['enmse_dssp']);
			$enmse_scm = strip_tags($_GET['enmse_scm']);
			$enmse_dsst = strip_tags($_GET['enmse_dsst']);
			$enmse_dam = strip_tags($_GET['enmse_dam']);
			$enmse_sort = strip_tags($_GET['enmse_sort']);
			
				if ( $enmse_de == 1 ) { // Display Lising of Series?
					// --- Pull All Series That Have Messages Associated
					if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
						$enmse_spreparredsql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL AND archived = 0 GROUP BY series_id ORDER BY start_date DESC"; 	
						$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_dsst );
						$enmse_series = $wpdb->get_results( $enmse_ssql );
					} elseif ( $enmse_dsst == "n" ) { // Display according to the default Series Type
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
					} elseif ( $enmse_dsst == "n" ) { // Display according to the default Series Type
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
					} elseif ( $enmse_dsst == "n" ) { // Display according to the default Series Type
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
						$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );

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

				} elseif ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) { // Is a specific topic requested?

					if ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) { // Override options for user request
						$enmse_tid = strip_tags($_GET['enmse_tid']);
					} else {
						$enmse_tid = $enmse_dst;
					}

					// Find Info the the Specified Topic
					$enmse_sstpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " WHERE topic_id = %d LIMIT 1"; 		
					$enmse_findthetopic = $wpdb->prepare( $enmse_sstpreparredsql, $enmse_tid );
					$enmse_singletopic = $wpdb->get_row( $enmse_findthetopic, OBJECT );

					if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?

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
				} elseif ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) { // Is a specific book requested?

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
				} elseif ( (isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid'])) || ($enmse_dssp > 0  && !isset($_GET['enmse_sid'])) ) { // Is a specific speaker requested?
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
					if ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) { // Is a specific series requested?

						if ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) { // Override options for user request
							$enmse_sid = strip_tags($_GET['enmse_sid']);
						} else {
							$enmse_sid = $enmse_dss;
						}

						if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?

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
						if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?

							if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Override options for user request
								$enmse_mid = strip_tags($_GET['enmse_mid']);
							} else {
								$enmse_mid = $enmse_dsm;
							}

							// Find the message
							$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE message_id = %d GROUP BY message_id"; 		
							$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid );
							$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
						} else {
							// Find Most Recent Message - FIX TO FILTER OUT ARCHIVED SERIES?
							if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Display all with Specific Series Type
								$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND archived = 0 GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
								$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_dsst );
								$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
							} elseif ( $enmse_dsst == "n" ) { // Display according to the default Series Type
								$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND archived = 0 GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
								$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_primaryst );
								$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
							} else { // Display Topics of Every Series Type	
								$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND archived = 0 GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
								$enmse_singlemessage = $wpdb->get_row( $enmse_smpreparredsql, OBJECT );
							}
						}
					}
				}

				// --- Find Series Info for Current Message
				if ( (isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid'])) || (isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid'])) ) { // Is a specific topic requested?
					if ( !empty($enmse_singlemessage) ) {
						// Find the Series Titles for the Message
						$enmse_stpreparredsql = "SELECT s_title, series_id FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) WHERE message_id = %d GROUP BY series_id ORDER BY start_date ASC"; 	
						$enmse_stsql = $wpdb->prepare( $enmse_stpreparredsql, $enmse_singlemessage->message_id );
						$enmse_seriestitles = $wpdb->get_results( $enmse_stsql );
					}
				} else {
					if ( !empty($enmse_singlemessage) ) {
						// Find the Series Title/ID that corresponds to the Most Recent Message
						$enmse_sspreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 		
						$enmse_findtheseries = $wpdb->prepare( $enmse_sspreparredsql, $enmse_singlemessage->series_id );
						$enmse_singleseries = $wpdb->get_row( $enmse_findtheseries, OBJECT );
					}
				}

				if ( $enmse_scm == 1 ) { // If complimentary messages are enabled...
					// --- Find Complimentary Messages
					include('ajaxwopaginatedrelated.php');
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

	// ***** DISPLAY STANDARD LISTING OF MESSAGES BY RECENT MESSAGE/SERIES *****
	} else {  
				$enmse_sort = "ASC";

				// --- Pull All Series That Have Messages Associated
				$enmse_spreparredsql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL AND archived = 0 GROUP BY series_id ORDER BY start_date DESC"; 	
				$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_primaryst );
				$enmse_series = $wpdb->get_results( $enmse_ssql );
				
				// --- Pull All Topics That Have Messages Associated
				if ( $enmsetopicsort == 1 ) { 
					$enmse_tpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY topic_id ORDER BY sort_id ASC";
				} else {
					$enmse_tpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY topic_id ORDER BY name ASC";
				}	
				$enmse_tsql = $wpdb->prepare( $enmse_tpreparredsql, $enmse_primaryst );
				$enmse_topics = $wpdb->get_results( $enmse_tsql );

				// --- Pull All Books That Have Messages Associated
				$enmse_bpreparredsql = "SELECT book_id, book_name FROM " . $wpdb->prefix . "se_books" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (book_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY book_name ORDER BY book_id ASC";	
				$enmse_bsql = $wpdb->prepare( $enmse_bpreparredsql, $enmse_primaryst );
				$enmse_books = $wpdb->get_results( $enmse_bsql );
				
				// --- Pull All Speakers That Have Messages Associated	
				$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY speaker_id ORDER BY last_name ASC"; 	
				$enmse_spsql = $wpdb->prepare( $enmse_sppreparredsql, $enmse_primaryst );
				$enmse_speakers = $wpdb->get_results( $enmse_spsql );
				
				// --- Find the Single Message to Display
				if ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) ) { // Are all messages requested?
					if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?
						$enmse_mid = strip_tags($_GET['enmse_mid']);
						// Find the message			
						$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE message_id = %d AND (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
						$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid, $enmse_primaryst );
						$enmse_initialmessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );

						if ( empty($enmse_initialmessage) ) {
							$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " WHERE message_id = %d AND (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() ORDER BY date DESC LIMIT 1"; 		
							$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid );
							$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
						} else {
							$enmse_singlemessage = $enmse_initialmessage;
						}
					} else {
						// Find the message			
						$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
						$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_primaryst );
						$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
					}
				} elseif ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) { // Is a specific topic requested?
					$enmse_tid = strip_tags($_GET['enmse_tid']);
					
					// Find Info the the Specified Topic
					$enmse_sstpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " WHERE topic_id = %d LIMIT 1"; 		
					$enmse_findthetopic = $wpdb->prepare( $enmse_sstpreparredsql, $enmse_tid );
					$enmse_singletopic = $wpdb->get_row( $enmse_findthetopic, OBJECT );
					
					if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?
						$enmse_mid = strip_tags($_GET['enmse_mid']);
						// Find the message
						$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE message_id = %d AND topic_id = %d GROUP BY message_id"; 		
						$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid, $enmse_tid );
						$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
					} else {
						// Find the message
						$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND topic_id = %d GROUP BY message_id ORDER BY date ASC LIMIT 1"; 		
						$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_tid );
						$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
					}
				} elseif ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) { // Is a specific book requested?
					$enmse_bid = strip_tags($_GET['enmse_bid']);
					
					// Find Info the the Specified Book
					$enmse_sbpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_books" . " WHERE book_id = %d LIMIT 1"; 		
					$enmse_findthebook = $wpdb->prepare( $enmse_sbpreparredsql, $enmse_bid );
					$enmse_singlebook = $wpdb->get_row( $enmse_findthebook, OBJECT );
					
					if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?
						$enmse_mid = strip_tags($_GET['enmse_mid']);
						// Find the message
						$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE message_id = %d AND book_id = %d GROUP BY message_id"; 		
						$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid, $enmse_bid );
						$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
					} else {
						// Find the message
						$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND book_id = %d GROUP BY message_id ORDER BY date ASC LIMIT 1"; 		
						$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_bid );
						$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
					}
				} elseif ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) { // Is a specific speaker requested?
					$enmse_spid = strip_tags($_GET['enmse_spid']);
					
					// Find Info the the Specified Speaker
					$enmse_sssppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id = %d LIMIT 1"; 		
					$enmse_findthespeaker = $wpdb->prepare( $enmse_sssppreparredsql, $enmse_spid );
					$enmse_singlespeaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
					
					if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?
						$enmse_mid = strip_tags($_GET['enmse_mid']);
					    
						// Find the message			
						$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE message_id = %d AND (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND speaker_id = %d GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
						$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid, $enmse_primaryst, $enmse_spid );
						$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
					} else {
						// Find the message			
						$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND speaker_id = %d GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
						$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_primaryst, $enmse_spid );
						$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
					}
				} else {
					if ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) { // Is a specific series requested?
						$enmse_sid = strip_tags($_GET['enmse_sid']);
						if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?
							$enmse_mid = strip_tags($_GET['enmse_mid']);
							// Find the message
							$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE message_id = " . $enmse_mid . " AND series_id = %d GROUP BY message_id"; 		
							$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_sid );
							$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
						} else {
							// Find the message
							$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_id = %d GROUP BY message_id ORDER BY date ASC LIMIT 1"; 		
							$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_sid );
							$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
						}
					} else {
						if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) { // Is a specific message requested?
							$enmse_mid = strip_tags($_GET['enmse_mid']);
							// Find the message
							$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE message_id = %d GROUP BY message_id"; 		
							$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_mid );
							$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
						} else {
							// Find Most Recent Message With the Primary Series Type
							$enmse_smpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_series" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND archived = 0 GROUP BY message_id ORDER BY date DESC LIMIT 1"; 		
							$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $enmse_primaryst );
							$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );
						}
					}
				}
				
				// --- Find Series Info for Current Message
				if ( ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) || ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) ) { // Is a specific topic or book requested?
					if ( !empty($enmse_singlemessage) ) {
						// Find the Series Titles for the Message
						$enmse_stpreparredsql = "SELECT s_title, series_id FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) WHERE message_id = %d GROUP BY series_id ORDER BY start_date ASC"; 	
						$enmse_stsql = $wpdb->prepare( $enmse_stpreparredsql, $enmse_singlemessage->message_id );
						$enmse_seriestitles = $wpdb->get_results( $enmse_stsql );
					}
				} else {
					if ( !empty($enmse_singlemessage) ) {
						if ( !isset($enmse_singlemessage->series_id) ) {
							
						} else {
							// Find the Series Title/ID that corresponds to the Most Recent Message
							$enmse_sspreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 		
							$enmse_findtheseries = $wpdb->prepare( $enmse_sspreparredsql, $enmse_singlemessage->series_id );
							$enmse_singleseries = $wpdb->get_row( $enmse_findtheseries, OBJECT );
						}
					}
				}
				
				// --- Find Complimentary Messages
				include('paginatedrelated.php');

				
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


			}

		$enmse_thispage = $_GET['enmse_permalink'];

	?>
	<?php if ( $enmse_lo == 1 ) { // ***** ARE OPTIONS SPECIFIED? ***** ?>
			<?php if ( !empty($enmse_singlemessage) ) { ?>
				<?php if ( $enmse_cardview == 1 ) { // Card View ?>
					<?php $enmse_middlecount = 0; $enmse_oddcount = 0;
					foreach ($enmse_seriesmessages as $enmse_sm) {
						if ( $enmse_middlecount < 3 ) {$enmse_middlecount = $enmse_middlecount+1;} else {$enmse_middlecount = 1;};
						if ( $enmse_oddcount == 2 ) {
						 	$enmse_oddcount = 1;
						 } else {
						 	$enmse_oddcount = $enmse_oddcount+1;
						 } ?>
					<div class="enmse-message-card<?php if ( $enmse_middlecount == 2 ) { echo " enmse-middlecard"; } ?><?php if ( $enmse_oddcount == 1 ) { echo " enmse-oddcard"; } ?>">
						<?php /* MT */ if ( $enmse_sm->message_thumbnail != null ) { ?><img src="<?php echo $enmse_sm->message_thumbnail; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php /* AM/B/S/T */ } elseif ( ( ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) ) || $enmse_dam > 0 ) || ( ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) || $enmse_dst > 0 ) || ( ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) || $enmse_dsb > 0 ) ||  ( ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) || $enmse_dssp > 0 ) ) { ?><?php if ( $enmse_sm->series_thumbnail != null ) { ?><img src="<?php echo $enmse_sm->series_thumbnail; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } else { ?><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } ?><?php } else { ?><?php if ( isset($enmse_singleseries) ) { ?><?php if ( $enmse_singleseries->thumbnail_url != null ) { ?><img src="<?php echo $enmse_singleseries->thumbnail_url; ?>" alt="<?php echo $enmse_singleseries->s_title; ?>" border="0" /><?php } else { ?><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } ?><?php } ?><?php } ?>
						<h6><?php echo date_i18n($enmse_dateformat, strtotime($enmse_sm->date)); ?><?php if ( $enmse_sm->alternate_date != "0000-00-00" ) { echo " (also " . date_i18n('M j', strtotime($enmse_sm->alternate_date)) . ")"; } ?></h6>
						<h5><?php echo stripslashes($enmse_sm->title); ?></h5>
						<?php if ( $enmse_sm->speaker != null ) { ?><p class="enmse-speaker-name"><?php echo stripslashes($enmse_sm->speaker); ?></p><?php } ?>
						<?php if ( $enmse_sm->focus_scripture != null ) { ?><p class="enmse-scripture-info"><?php echo $enmse_sm->focus_scripture ?></p><?php } ?>
						<?php if ( $enmse_sm->file_name != null ) { ?><p class="enmse-hero-extra"><a href="<?php echo $enmse_sm->file_url; ?>" <?php if ($enmse_sm->file_new_window == 1) { echo "target=\"_blank\""; }; ?>><?php echo stripslashes($enmse_sm->file_name); ?></a></p><?php } ?>
						<p class="enmse-card-links"><?php if ( (isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid'])) || ($enmse_dst > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a topic specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( (isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid'])) || ($enmse_dsb > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid'])  && !isset($_GET['enmse_spid'])) ) { // Is a book specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( (isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid'])) || ($enmse_dss > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a series specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( (isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid'])) || ($enmse_dssp > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid'])  && !isset($_GET['enmse_tid'])) ) { // Is a speaker specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' .$enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) || ($enmse_dam > 0 && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_spid'])) ) { ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } else { ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } ?></p>
					</div>
					<?php } ?>
					<?php include('worelatedpagination.php'); ?>
				<?php } elseif ( $enmse_cardview == 2 ) { // Row View ?>
					<table cellpadding="0" cellspacing="0">
					<?php foreach ($enmse_seriesmessages as $enmse_sm) { ?>
						<tr class="enmse-message-row">
							<td class="enmse-image-cell"><?php /* MT */ if ( $enmse_sm->message_thumbnail != null ) { ?><img src="<?php echo $enmse_sm->message_thumbnail; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php /* AM/B/S/T */ } elseif ( ( ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) ) || $enmse_dam > 0 ) || ( ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) || $enmse_dst > 0 ) || ( ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) || $enmse_dsb > 0 ) ||  ( ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) || $enmse_dssp > 0 ) ) { ?><?php if ( $enmse_sm->series_thumbnail != null ) { ?><img src="<?php echo $enmse_sm->series_thumbnail; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } else { ?><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } ?><?php } else { ?><?php if ( isset($enmse_singleseries) ) { ?><?php if ( $enmse_singleseries->thumbnail_url != null ) { ?><img src="<?php echo $enmse_singleseries->thumbnail_url; ?>" alt="<?php echo $enmse_singleseries->s_title; ?>" border="0" /><?php } else { ?><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } ?><?php } ?><?php } ?></td>
							<td class="enmse-info-cell">
								<h5><?php echo stripslashes($enmse_sm->title); ?></h5>
								<h6><?php if ( $enmse_sm->speaker != null ) { ?><span class="enmse-speaker-style"><?php echo stripslashes($enmse_sm->speaker); ?></span> - <?php } ?><?php echo date_i18n($enmse_dateformat, strtotime($enmse_sm->date)); ?><?php if ( $enmse_sm->alternate_date != "0000-00-00" ) { echo " (also " . date_i18n('M j', strtotime($enmse_sm->alternate_date)) . ")"; } ?></h6>
								<?php if ( $enmse_sm->focus_scripture != null ) { ?><p class="enmse-scripture-info"><?php echo $enmse_sm->focus_scripture ?></p><?php } ?>
								<?php if ( $enmse_sm->file_name != null ) { ?><p class="enmse-hero-extra"><a href="<?php echo $enmse_sm->file_url; ?>" <?php if ($enmse_sm->file_new_window == 1) { echo "target=\"_blank\""; }; ?>><?php echo stripslashes($enmse_sm->file_name); ?></a></p><?php } ?>
							</td>
							<td class="enmse-links-cell"><p class="enmse-card-links"><?php if ( (isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid'])) || ($enmse_dst > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a topic specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( (isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid'])) || ($enmse_dsb > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_spid'])) ) { // Is a book specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( (isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid'])) || ($enmse_dss > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a series specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( (isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid'])) || ($enmse_dssp > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid'])) ) { // Is a speaker specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' .$enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) || ($enmse_dam > 0 && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_spid'])) ) { ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } else { ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } ?></p></td>
						</tr>
						<tr class="enmse-spacer-row"></tr>
					<?php } ?>
					</table>
					<?php include('worelatedpagination.php'); ?>
				<?php } else { // Classic List View ?>
					<table class="enmse-more-messages" cellpadding="0" cellspacing="0">
						<?php $rowcycle = 'even';
						foreach ($enmse_seriesmessages as $enmse_sm) { 
							if ($rowcycle == 'odd') {
								$rowcycle = 'even';
							} else {
								$rowcycle = 'odd';	
							} ?>
				    	<tr class="enmse-<?php echo $rowcycle; ?>">
				            <td class="enmse-title-cell"><?php echo stripslashes($enmse_sm->title); ?></td>
				            <td class="enmse-date-cell enmse-speaker-cell"><?php echo stripslashes($enmse_sm->speaker); ?></td>
				            <td class="enmse-date-cell"><?php echo date_i18n($enmse_dateformat, strtotime($enmse_sm->date)); ?><?php if ( $enmse_sm->alternate_date != "0000-00-00" ) { echo " (also " . date_i18n('M j', strtotime($enmse_sm->alternate_date)) . ")"; } ?></td>
							<?php if ( (isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid'])) || ($enmse_dst > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a topic specified? ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } elseif ( (isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid'])) || ($enmse_dsb > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_spid'])) ) { // Is a book specified? ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } elseif ( (isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid'])) || ($enmse_dss > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a series specified? ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } elseif ( (isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid'])) || ($enmse_dssp > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid'])) ) { // Is a speaker specified? ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' .$enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } elseif ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) || ($enmse_dam > 0 && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } else { ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } ?>
						</tr>
						<?php } ?>
				   	</table>
				   	<?php include('worelatedpagination.php'); ?>
				<?php } ?>
			<?php } ?>
		<?php } else { // ***** DISPLAY STANDARD LISTING OF MESSAGES BY RECENT MESSAGE/SERIES ***** ?>
			<?php if ( !empty($enmse_singlemessage) ) { ?>
				<?php if ( $enmse_cardview == 1 ) { // Card View ?>
					<?php $enmse_middlecount = 0; $enmse_oddcount = 0;
					foreach ($enmse_seriesmessages as $enmse_sm) {
						if ( $enmse_middlecount < 3 ) {$enmse_middlecount = $enmse_middlecount+1;} else {$enmse_middlecount = 1;};
						if ( $enmse_oddcount == 2 ) {
						 	$enmse_oddcount = 1;
						 } else {
						 	$enmse_oddcount = $enmse_oddcount+1;
						 } ?>
					<div class="enmse-message-card<?php if ( $enmse_middlecount == 2 ) { echo " enmse-middlecard"; } ?><?php if ( $enmse_oddcount == 1 ) { echo " enmse-oddcard"; } ?>">
						<?php /* MT */ if ( $enmse_sm->message_thumbnail != null ) { ?><img src="<?php echo $enmse_sm->message_thumbnail; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php /* AM/B/S/T */ } elseif ( ( ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) ) || (isset($enmse_dam) && $enmse_dam > 0) ) || ( ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) || (isset($enmse_dst) && $enmse_dst > 0) ) || ( ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) || (isset($enmse_dsb) && $enmse_dsb > 0) ) ||  ( ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) || (isset($enmse_dssp) && $enmse_dssp > 0) ) ) { ?><?php if ( $enmse_sm->series_thumbnail != null ) { ?><img src="<?php echo $enmse_sm->series_thumbnail; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } else { ?><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } ?><?php } else { ?><?php if ( isset($enmse_singleseries) ) { ?><?php if ( $enmse_singleseries->thumbnail_url != null ) { ?><img src="<?php echo $enmse_singleseries->thumbnail_url; ?>" alt="<?php echo $enmse_singleseries->s_title; ?>" border="0" /><?php } else { ?><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } ?><?php } ?><?php } ?>
						<h6><?php echo date('M j, Y', strtotime($enmse_sm->date)); ?></h6>
						<h5><?php echo stripslashes($enmse_sm->title); ?></h5>
						<?php if ( $enmse_sm->speaker != null ) { ?><p class="enmse-speaker-name"><?php echo stripslashes($enmse_sm->speaker); ?></p><?php } ?>
						<?php if ( $enmse_sm->focus_scripture != null ) { ?><p class="enmse-scripture-info"><?php echo $enmse_sm->focus_scripture ?></p><?php } ?>
						<?php if ( $enmse_sm->file_name != null ) { ?><p class="enmse-hero-extra"><a href="<?php echo $enmse_sm->file_url; ?>" <?php if ($enmse_sm->file_new_window == 1) { echo "target=\"_blank\""; }; ?>><?php echo stripslashes($enmse_sm->file_name); ?></a></p><?php } ?>
						<p class="enmse-card-links"><?php if ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) { // Is a topic specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) { // Is a book specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id  . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id  . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id  . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) { // Is a series specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) { // Is a speaker specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) ) { ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } else { ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-card-link" class="enmse-ajax-card-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-card-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-card-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } ?></p>
					</div>
					<?php } ?>
					<?php include('relatedpagination.php'); ?>
				<?php } elseif ( $enmse_cardview == 2 ) { // Row View ?>
					<table cellpadding="0" cellspacing="0">
					<?php foreach ($enmse_seriesmessages as $enmse_sm) { ?>
						<tr class="enmse-message-row">
							<td class="enmse-image-cell"><?php /* MT */ if ( $enmse_sm->message_thumbnail != null ) { ?><img src="<?php echo $enmse_sm->message_thumbnail; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php /* AM/B/S/T */ } elseif ( ( ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) ) || ( isset($enmse_dam) && $enmse_dam > 0) ) || ( ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) || ( isset($enmse_dst) && $enmse_dst > 0 ) ) || ( ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) || ( isset($enmse_dsb) && $enmse_dsb > 0 ) ) ||  ( ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) || ( isset($enmse_dssp) && $enmse_dssp > 0 ) ) ) { ?><?php if ( $enmse_sm->series_thumbnail != null ) { ?><img src="<?php echo $enmse_sm->series_thumbnail; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } else { ?><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } ?><?php } else { ?><?php if ( isset($enmse_singleseries) ) { ?><?php if ( $enmse_singleseries->thumbnail_url != null ) { ?><img src="<?php echo $enmse_singleseries->thumbnail_url; ?>" alt="<?php echo $enmse_singleseries->s_title; ?>" border="0" /><?php } else { ?><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo $enmse_sm->title; ?> Image" border="0" /><?php } ?><?php } ?><?php } ?></td>
							<td class="enmse-info-cell">
								<h5><?php echo stripslashes($enmse_sm->title); ?></h5>
								<h6><?php if ( $enmse_sm->speaker != null ) { ?><span class="enmse-speaker-style"><?php echo stripslashes($enmse_sm->speaker); ?></span> - <?php } ?><?php echo date('M j, Y', strtotime($enmse_sm->date)); ?></h6>
								<?php if ( $enmse_sm->focus_scripture != null ) { ?><p class="enmse-scripture-info"><?php echo $enmse_sm->focus_scripture ?></p><?php } ?>
								<?php if ( $enmse_sm->file_name != null ) { ?><p class="enmse-hero-extra"><a href="<?php echo $enmse_sm->file_url; ?>" <?php if ($enmse_sm->file_new_window == 1) { echo "target=\"_blank\""; }; ?>><?php echo stripslashes($enmse_sm->file_name); ?></a></p><?php } ?>
							</td>
							<td class="enmse-links-cell"><p class="enmse-card-links"><?php if ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) { // Is a topic specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) { // Is a book specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id. '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) { // Is a series specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) { // Is a speaker specified? ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } elseif ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) ) { ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } else { ?><span class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-row-link" class="enmse-ajax-row-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></span><span class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-row-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></span><span class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-row-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></span><?php } ?></p></td>
						</tr>
						<tr class="enmse-spacer-row"></tr>
					<?php } ?>
					</table>
					<?php include('relatedpagination.php'); ?>
				<?php } else { // Classic List View ?>
					<table class="enmse-more-messages" cellpadding="0" cellspacing="0">
						<?php $rowcycle = 'even';
						foreach ($enmse_seriesmessages as $enmse_sm) { 
							if ($rowcycle == 'odd') {
								$rowcycle = 'even';
							} else {
								$rowcycle = 'odd';	
							} ?>
				    	<tr class="enmse-<?php echo $rowcycle; ?>">
				            <td class="enmse-title-cell"><?php echo stripslashes($enmse_sm->title); ?></td>
				            <td class="enmse-date-cell enmse-speaker-cell"><?php echo stripslashes($enmse_sm->speaker); ?></td>
				            <td class="enmse-date-cell"><?php echo date('M j, Y', strtotime($enmse_sm->date)); ?><?php if ( $enmse_sm->alternate_date != "0000-00-00" ) { echo " (also " . date('M j', strtotime($enmse_sm->alternate_date)) . ")"; } ?></td>
	            			<?php if ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) { // Is a topic specified? ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_tid=' . $enmse_singletopic->topic_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } elseif ( isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid']) ) { // Is a book specified? ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_bid=' . $enmse_singlebook->book_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } elseif ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) { // Is a series specified? ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } elseif ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) { // Is a speaker specified? ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } elseif ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) ) { // All Messages ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_am=1&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } else { ?><td class="enmse-alternate-cell"><?php if ( $enmse_sm->alternate_toggle == "Yes" && ( $enmse_sm->alternate_embed != '0' || ( $enmse_sm->additional_video_embed_url != '0' && $enmse_sm->additional_video_embed_url != NULL ) ) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1" class="enmse-ajax-link" class="enmse-ajax-link">' . stripslashes($enmse_sm->alternate_label) . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_xv=1'; ?>" class="enmse-ajax-values"></td><td class="enmse-watch-cell"><?php if ( $enmse_sm->embed_code != '0' || ($enmse_sm->video_embed_url != '0' && $enmse_sm->video_embed_url != NULL) ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '" class="enmse-ajax-link">' . $enmse_videotablabel . '</a><span class="enmse-spacer">&nbsp;&nbsp;&nbsp;</span>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id; ?>" class="enmse-ajax-values"></td><td class="enmse-listen-cell"><?php if ( $enmse_sm->audio_url != '0' ) { echo '<a href="' . $enmse_thispage . '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1" class="enmse-ajax-link">' . $enmse_audiotablabel . '</a>'; } ?><input type="hidden" name="enmse-ajax-values" value="<?php echo '&amp;enmse_sid=' . $enmse_singleseries->series_id . '&amp;enmse_mid=' . $enmse_sm->message_id . '&amp;enmse_av=1'; ?>" class="enmse-ajax-values"></td><?php } ?>
						</tr>
						<?php } ?>
				   	</table>
				  	<?php include('relatedpagination.php'); ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	<?php // Deny access to sneaky people!
	} else {
		exit("Access Denied");
	} die(); ?>