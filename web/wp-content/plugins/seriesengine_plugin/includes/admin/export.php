<?php /* ----- Series Engine - Admin User Guide ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		$enmse_options = get_option( 'enm_seriesengine_options' ); 
		 $decoded = base64_decode(get_option( 'sermonbrowser_options' ));


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

		if ( isset($enmse_options['speakertp']) ) { // Find Speaker Title (plural)
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

		if ( isset($enmse_options['deftrans']) ) { // Sort Topics Manually?
			$deftrans = $enmse_options['deftrans'];
		} else {
			$deftrans = 59;
		}

		if ( isset($enmse_options['default_permalink_prefix']) ) { // Default Permalink Prefix
			$default_permalink_prefix = $enmse_options['default_permalink_prefix'];
		} else {
			$default_permalink_prefix = 1;
		}

		if ( isset($enmse_options['default_permalink_speaker']) ) { // Default Permalink Speaker
			$default_permalink_speaker = $enmse_options['default_permalink_speaker'];
		} else {
			$default_permalink_speaker = 1;
		}

		if ( isset($enmse_options['language']) ) { // Find the Language
			$enmse_language = $enmse_options['language'];
		} else {
			$enmse_language = 1;
		}

		if ( $enmse_language == 10 ) { 
			include(dirname(__FILE__) . '/../lang/fre_bible_books.php');
		} elseif ( $enmse_language == 9 ) { 
			include(dirname(__FILE__) . '/../lang/rus_bible_books.php');
		} elseif ( $enmse_language == 8 ) { 
			include(dirname(__FILE__) . '/../lang/jap_bible_books.php');
		} elseif ( $enmse_language == 7 ) { 
			include(dirname(__FILE__) . '/../lang/dut_bible_books.php');
		} elseif ( $enmse_language == 6 ) { 
			include(dirname(__FILE__) . '/../lang/chint_bible_books.php');
		} elseif ( $enmse_language == 5 ) { 
			include(dirname(__FILE__) . '/../lang/chins_bible_books.php');
		} elseif ( $enmse_language == 4 ) { 
			include(dirname(__FILE__) . '/../lang/turk_bible_books.php');
		} elseif ( $enmse_language == 3 ) { 
			include(dirname(__FILE__) . '/../lang/ger_bible_books.php');
		} elseif ( $enmse_language == 2 ) { 
			include(dirname(__FILE__) . '/../lang/spa_bible_books.php');
		} else {
			include(dirname(__FILE__) . '/../lang/eng_bible_books.php');
		}

		// Message from
		if ( isset($enmse_options['lang_permalinkblankexcerpt']) ) { 
			$lang_permalinkblankexcerpt = $enmse_options['lang_permalinkblankexcerpt'];
			$lang1_permalinkblankexcerpt =  str_replace("MESSAGE_LABEL", strtolower($enmsemessaget), $lang_permalinkblankexcerpt);
			$enmse_permalinkblankexcerpt =  str_replace("SERIES_LABEL", strtolower($enmseseriest), $lang1_permalinkblankexcerpt);
		} else {
			$lang_permalinkblankexcerpt = "A MESSAGE_LABEL from the SERIES_LABEL";
			$lang1_permalinkblankexcerpt =  str_replace("MESSAGE_LABEL", strtolower($enmsemessaget), $lang_permalinkblankexcerpt);
			$enmse_permalinkblankexcerpt =  str_replace("SERIES_LABEL", strtolower($enmseseriest), $lang1_permalinkblankexcerpt);
		}

		if ( $_POST && $_GET['seimport'] == "1") { // SE Archive
			global $wpdb;
			$filename=$_FILES["file"]["tmp_name"];		
 
 
			 if($_FILES["file"]["size"] > 0)
			 {
			  	$file = fopen($filename, "r");
		        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		         {
		         	if ( $getData[0] == "message" ) {
		         		$enmse_newrecord = array(
							'message_id' => $getData[1], 
							'title' => $getData[2],
							'speaker' => $getData[3],
							'date' => $getData[4],
							'alternate_date' => $getData[5],
							'description' => $getData[6],
							'message_length' => $getData[7],
							'message_thumbnail' => $getData[8],
							'audio_url' => $getData[9],
							'message_video_length' => $getData[10],
							'video_url' => $getData[11],
							'embed_code' => $getData[12],
							'alternate_toggle' => $getData[13],
							'alternate_embed' => $getData[14],
							'alternate_label' => $getData[15],
							'audio_file_size' => $getData[16],
							'video_file_size' => $getData[17],
							'video_embed_url' => $getData[18],
							'additional_video_embed_url' => $getData[19],
							'audio_count' => $getData[20],
							'video_count' => $getData[21],
							'alternate_count' => $getData[22],
							'primary_series' => $getData[23],
							'series_thumbnail' => $getData[24],
							'series_image' => $getData[25],
							'series_podcast_image' => $getData[26],
							'file_name' => $getData[27],
							'file_url' => $getData[28],
							'file_new_window' => $getData[29],
							'podcast_image' => $getData[30],
							'focus_scripture' => $getData[31],
							'permalink_prefix' => $getData[32],
							'permalink_speaker' => $getData[33],
							'podcast_series' => $getData[34]
						); 
						$wpdb->insert( $wpdb->prefix . "se_messages", $enmse_newrecord);
		         	} elseif ( $getData[0] == "series" ) {
	 					$enmse_newrecord = array(
							'series_id' => $getData[1], 
							's_title' => $getData[2],
							's_description' => $getData[3], 
							'thumbnail_url' => $getData[4], 
							'archived' => $getData[5], 
							'start_date' => $getData[6], 
							'graphic_thumb' => $getData[7], 
							'widget_thumb' => $getData[8],
							'podcast_image' => $getData[9]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newrecord);
					} elseif ( $getData[0] == "file" ) {
	 					$enmse_newrecord = array(
							'file_id' => $getData[1], 
							'file_name' => $getData[2],
							'file_url' => $getData[3], 
							'file_username' => $getData[4], 
							'sort_id' => $getData[5], 
							'file_new_window' => $getData[6],
							'featured' => $getData[7]
						); 
						$wpdb->insert( $wpdb->prefix . "se_files", $enmse_newrecord);
					} elseif ( $getData[0] == "mfm" ) {
	 					$enmse_newrecord = array(
							'mf_match_id' => $getData[1], 
							'message_id' => $getData[2],
							'file_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_file_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "msp" ) {
	 					$enmse_newrecord = array(
							'msp_match_id' => $getData[1], 
							'message_id' => $getData[2],
							'speaker_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_speaker_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "mtm" ) {
	 					$enmse_newrecord = array(
							'mt_match_id' => $getData[1], 
							'message_id' => $getData[2],
							'topic_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_topic_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "podcast" ) {
		         		$enmse_newrecord = array(
							'se_podcast_id' => $getData[1], 
							'series_id' => $getData[2],
							'topic_id' => $getData[3],
							'speaker_id' => $getData[4],
							'series_type_id' => $getData[5],
							'title' => $getData[6],
							'description' => $getData[7],
							'author' => $getData[8],
							'email' => $getData[9],
							'logo_url' => $getData[10],
							'category' => $getData[11],
							'subcategory' => $getData[12],
							'audio_video' => $getData[13],
							'podcast_display' => $getData[14],
							'link_url' => $getData[15],
							'explicit' => $getData[16],
							'redirect_podcast' => $getData[17],
							'redirect_url' => $getData[18],
							'book_id' => $getData[19]
						); 
						$wpdb->insert( $wpdb->prefix . "se_podcasts", $enmse_newrecord);
		         	} elseif ( $getData[0] == "smm" ) {
	 					$enmse_newrecord = array(
							'sm_match_id' => $getData[1], 
							'message_id' => $getData[2],
							'series_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "stm" ) {
	 					$enmse_newrecord = array(
							'st_match_id' => $getData[1], 
							'series_id' => $getData[2],
							'series_type_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "seriestype" ) {
	 					$enmse_newrecord = array(
							'series_type_id' => $getData[1], 
							'name' => $getData[2],
							'description' => $getData[3],
							'sort_id' => $getData[4]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newrecord);
					} elseif ( $getData[0] == "speaker" ) {
	 					$enmse_newrecord = array(
							'speaker_id' => $getData[1], 
							'first_name' => $getData[2],
							'last_name' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_speakers", $enmse_newrecord);
					} elseif ( $getData[0] == "topic" ) {
	 					$enmse_newrecord = array(
							'topic_id' => $getData[1], 
							'name' => $getData[2],
							'sort_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_topics", $enmse_newrecord);
					} elseif ( $getData[0] == "scripture" ) {
	 					$enmse_newrecord = array(
							'scripture_id' => $getData[1], 
							'start_book' => $getData[2],
							'start_chapter' => $getData[3],
							'start_verse' => $getData[4],
							'end_verse' => $getData[5],
							'trans' => $getData[6],
							'transtext' => $getData[7],
							'focus' => $getData[8],
							'sort_id' => $getData[9],
							'link' => $getData[10],
							'text' => $getData[11],
							'short_text' => $getData[12],
							'scripture_username' => $getData[13]
						); 
						$wpdb->insert( $wpdb->prefix . "se_scriptures", $enmse_newrecord);
					} elseif ( $getData[0] == "scm" ) {
	 					$enmse_newrecord = array(
							'scm_match_id' => $getData[1], 
							'scripture_id' => $getData[2],
							'message_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_scripture_message_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "bmm" ) {
	 					$enmse_newrecord = array(
							'bm_match_id' => $getData[1], 
							'book_id' => $getData[2],
							'message_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_book_message_matches", $enmse_newrecord);
					}

		         }
				
		         fclose($file);	

		        // Create Permalinks
		        $enmse_cptdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'enmse_message'";
				$enmse_cptdeleted = $wpdb->query( $enmse_cptdelete_query_preparred );

				$enmse_ctpmdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "postmeta" . " WHERE meta_key = 'enmse_mid'"; 
				$enmse_ctpmdeleted = $wpdb->query( $enmse_ctpmdelete_query_preparred );

			    $enmse_findpermamessagesql = "SELECT message_id, date, title, speaker, primary_series, description FROM " . $wpdb->prefix . "se_messages"; 
				$permamessages = $wpdb->get_results( $enmse_findpermamessagesql );
				
				function enmsedashes($str) {
					$stepone = str_replace("'", "", $str);
					$steptwo = str_replace("\"", "", $stepone);
					$stepthree = preg_replace("/[^A-Za-z0-9]+/", "-", $steptwo);
					$stepfour = preg_replace("/^-*|-*$/", "", $stepthree);
					$finalstring = strtolower($stepfour);
					return $finalstring;
				}		
				foreach ($permamessages as $m) {

					$enmse_date = $m->date;
					$enmse_mid = $m->message_id;
					$enmse_cpt_title = stripslashes(strip_tags($m->title));
					$enmse_cpt_description = stripslashes(strip_tags($m->description));
					$enmse_primary_series = $m->primary_series;
					$enmse_speaker = $m->speaker;
					$enmse_mid = $m->message_id;

					if ( $enmse_primary_series != 0 ) {
						$enmse_findtheprimarysql = "SELECT s_title FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d LIMIT 1"; 
						$enmse_findtheprimary = $wpdb->prepare( $enmse_findtheprimarysql, $enmse_primary_series );
						$enmse_primary = $wpdb->get_row( $enmse_findtheprimary, OBJECT );
						$enmse_noseries = 1;
					} else {
						$enmse_noseries = 0;
					}

					// New Custom Post Type Message 

					// CPT - Check for unique permalink
					$permatitle = enmsedashes($enmse_cpt_title);

					$enmse_permachecksql = "SELECT ID FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'enmse_message' AND post_name = %s"; 
					$enmse_permacheckp = $wpdb->prepare( $enmse_permachecksql, $permatitle );
					$enmse_permacheck = $wpdb->get_results( $enmse_permacheckp );

					if ( !empty($enmse_permacheck) ) {
						$permatitle = rand(1,99) . "-" . $permatitle;
					}

					// CPT - Insert
					$cptgettitle = str_replace("\"", "", $enmse_cpt_title);
					if ( $enmse_speaker != "" ) {
						$cpttitle = $enmsemessaget . ": \"" . $cptgettitle . "\" from " . $enmse_speaker;
					} else {
						$cpttitle = $enmsemessaget . ": \"" . $cptgettitle . "\"";
					}
					

					$convertdate = date('Y-m-d', strtotime($enmse_date)) . ' 13:46:46';

					if ( $enmse_noseries == 1 ) {
						$finalexcerpt = $enmse_permalinkblankexcerpt . " \"" . stripslashes($enmse_primary->s_title) . ".\" " . $enmse_cpt_description;
					} else {
						$finalexcerpt = $enmse_cpt_description;
					}

					$enmse_newcptmessage = array(
						'post_author' => get_current_user_id(), 
						'post_date' => $convertdate,
						'post_date_gmt' => $convertdate,
						'post_title' => $cpttitle,
						'post_excerpt' => $finalexcerpt,
						'post_status' => 'publish',
						'post_content' => '<span style="display: none"></span>',
						'comment_status' => 'closed',
						'ping_status' => 'closed',
						'post_name' => $permatitle,
						'post_modified' => current_time( 'mysql' ),
						'post_modified_gmt' => current_time( 'mysql', 1 ),
						'post_parent' => 0,
						'menu_order' => 0,
						'post_type' => 'enmse_message',
						'comment_count' => 0
						); 
					$wpdb->insert( $wpdb->prefix . "posts", $enmse_newcptmessage );
					$enmse_new_cptmessage_id = $wpdb->insert_id; 

					// CPT - Insert Guid and Post ID after creation
					$enmse_guid = home_url() . '/?post_type=enmse_message&#038;p=' . $enmse_new_cptmessage_id;

					$enmse_newcpt_values = array( 'guid' => $enmse_guid ); 
					$enmse_cptwhere = array( 'ID' => $enmse_new_cptmessage_id ); 
					$wpdb->update( $wpdb->prefix . "posts", $enmse_newcpt_values, $enmse_cptwhere ); 

					$enmse_newmm_values = array( 'wp_post_id' => $enmse_new_cptmessage_id ); 
					$enmse_mmwhere = array( 'message_id' => $enmse_mid ); 
					$wpdb->update( $wpdb->prefix . "se_messages", $enmse_newmm_values, $enmse_mmwhere ); 

					// CPT - Make Post Meta match for Series Engine Message
					$enmse_newcptmatch = array(
						'post_id' => $enmse_new_cptmessage_id, 
						'meta_key' => 'enmse_mid',
						'meta_value' => $enmse_mid
						); 
					$wpdb->insert( $wpdb->prefix . "postmeta", $enmse_newcptmatch );

				}
		         $enmse_messages[] = "Series Engine archive successfully loaded!";
			 } else {
			 	$enmse_errors[] = "Please upload a file for your archive import.";
			 }
		} elseif ( $_POST && $_GET['seimport'] == "2") { // Bulk Upload
			global $wpdb;
			$filename=$_FILES["file"]["tmp_name"];		
 
 
			 if($_FILES["file"]["size"] > 0)
			 {
			  	$file = fopen($filename, "r");
		        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		         {
		         	if ( $getData[0] == "speaker" ) {
	 					$enmse_newrecord = array(
							'speaker_id' => $getData[1], 
							'first_name' => $getData[2],
							'last_name' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_speakers", $enmse_newrecord);
					} elseif ( $getData[0] == "seriestype" ) {
	 					$enmse_newrecord = array(
							'series_type_id' => $getData[1], 
							'name' => $getData[2]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newrecord);
					} elseif ( $getData[0] == "series" ) {
	 					$enmse_newrecord = array(
							'series_id' => $getData[1], 
							's_title' => $getData[2],
							's_description' => $getData[3],
							'thumbnail_url' => $getData[4],  
							'graphic_thumb' => $getData[5],
							'start_date' => $getData[6],
							'archived' => 0 
						); 
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newrecord);
						$enmse_new_series_id = $wpdb->insert_id; 
						if ( $getData[7] != null || $getData[7] != 0 ) {
							$enmse_newstm = array(
								'series_id' => $enmse_new_series_id, 
								'series_type_id' => $getData[7]
								); 
							$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newstm );
						}
					} elseif ( $getData[0] == "topic" ) {
	 					$enmse_newrecord = array(
							'topic_id' => $getData[1], 
							'name' => $getData[2]
						); 
						$wpdb->insert( $wpdb->prefix . "se_topics", $enmse_newrecord);
					} elseif ( $getData[0] == "message" ) {
						if ( $getData[5] != null ) {
							$audio = $getData[5];
						} else {
							$audio = 0;
						}
						if ( $getData[8] != null ) {
							$embedcode = $getData[8];
						} else {
							$embedcode = 0;
						}
						if ( $getData[9] != null ) {
							$videoembedurl = $getData[9];
						} else {
							$videoembedurl = 0;
						}
						if ( $getData[12] != null ) {
							$series = $getData[12];
						} else {
							$series = 0;
						}
		         		$enmse_newrecord = array(
							'title' => $getData[1],
							'description' => $getData[2],
							'date' => $getData[3],
							'alternate_date' => "0000-00-00",
							'message_thumbnail' => $getData[4],
							'audio_url' => $audio,
							'video_url' => 0,
							'alternate_embed' => 0,
							'additional_video_embed_url' => 0,
							'message_length' => $getData[6],
							'audio_file_size' => $getData[7],
							'embed_code' => $embedcode,
							'video_embed_url' => $videoembedurl,
							'speaker' => $getData[10],
							'primary_series' => $series
						); 
						$wpdb->insert( $wpdb->prefix . "se_messages", $enmse_newrecord);
						$enmse_new_message_id = $wpdb->insert_id; 

						$enmse_newmspm = array( // Speaker Match
							'message_id' => $enmse_new_message_id, 
							'speaker_id' => $getData[11]
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_speaker_matches", $enmse_newmspm );

						if ( $getData[12] != null && $getData[12] != 0 ) {
							$enmse_newsmm = array( // Series Match
								'message_id' => $enmse_new_message_id, 
								'series_id' => $series
								); 
							$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newsmm );
						}
						
						if ( $getData[13] != null && $getData[13] != 0 ) {
							$enmse_newmtm = array( // Topic Match
								'message_id' => $enmse_new_message_id, 
								'topic_id' => $getData[13]
								); 
							$wpdb->insert( $wpdb->prefix . "se_message_topic_matches", $enmse_newmtm );
						}

						if ( $getData[14] != null && $getData[14] != "" ) {
							// Add Verses
							preg_match_all('/(?<!\d )[a-zA-Z]+( (\d+)(:\d+)?([\-–]\d+)?(, \d+[\-–]\d+)?)?/', $getData[14], $result, PREG_PATTERN_ORDER);

							if ( !empty($result) ) {
								foreach ($result[0] as $verse) {

									// Get Book
									$start_book = 0;
									if (preg_match('/(Genesis|genesis|GEN|Gen|gen)+/i', $verse)) {
										$start_book = 1;
										$bookname = $enmse_booknames[$start_book];
										$shortbookname = $enmse_bookabr[$start_book];
										$bookcode = "GEN";
									} elseif (preg_match('/(Exodus|exodus|EXO|Exo|exo)+/i', $verse)) {
										$start_book = 2;
										$bookname = $enmse_booknames[$start_book];
										$shortbookname = $enmse_bookabr[$start_book];
										$bookcode = "EXO";
									} elseif (preg_match('/(Leviticus|leviticus|LEV|Lev|lev)+/i', $verse)) {
										$start_book = 3;
										$bookname = $enmse_booknames[$start_book];
										$shortbookname = $enmse_bookabr[$start_book];
										$bookcode = "LEV";
									} elseif (preg_match('/(Numbers|numbers|NUM|Num|num)+/i', $verse)) {
										$start_book = 4;
										$bookname = $enmse_booknames[$start_book];
										$shortbookname = $enmse_bookabr[$start_book];
										$bookcode = "NUM";
									} elseif (preg_match('/(Deuteronomy|deuteronomy|DEUT|Deut|deut)+/i', $verse)) {
										$start_book = 5;
										$bookname = $enmse_booknames[$start_book];
										$shortbookname = $enmse_bookabr[$start_book];
										$bookcode = "DEU";
									} elseif (preg_match('/(Joshua|joshua|JOSH|Josh|josh)+/i', $verse)) {
										$start_book = 6;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "JOS";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Judges|judges|JUDG|Judg|judg)+/i', $verse)) {
										$start_book = 7;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "JDG";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Ruth|ruth)+/i', $verse)) {
										$start_book = 8;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "RUT";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(1 Samuel|1 samuel|1 SAM|1 Sam|1 sam)+/i', $verse)) {
										$start_book = 9;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "1SA";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(2 Samuel|2 samuel|2 SAM|2 Sam|2 sam)+/i', $verse)) {
										$start_book = 10;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "2SA";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(1 Kings|1 kings)+/i', $verse)) {
										$start_book = 11;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "1KI";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(2 Kings|2 kings)+/i', $verse)) {
										$start_book = 12;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "2KI";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(1 Chronicles|1 chronicles|1 CHR|1 Chr|1 chr)+/i', $verse)) {
										$start_book = 13;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "1CH";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(2 Chronicles|2 chronicles|2 CHR|2 Chr|2 chr)+/i', $verse)) {
										$start_book = 14;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "2CH";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Ezra|ezra)+/i', $verse)) {
										$start_book = 15;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "EZR";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Nehemiah|nehemiah|NEH|Neh|neh)+/i', $verse)) {
										$start_book = 16;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "NEH";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Esther|esther|ESTH|Esth|esth)+/i', $verse)) {
										$start_book = 17;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "EST";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Job|job)+/i', $verse)) {
										$start_book = 18;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "JOB";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Psalms|psalms|Psalm|psalm|PS|Ps|ps)+/i', $verse)) {
										$start_book = 19;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "PSA";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Proverbs|proverbs|PROV|Prov|prov)+/i', $verse)) {
										$start_book = 20;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "PRO";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Ecclesiastes|ecclesiastes|ECC|Ecc|ecc)+/i', $verse)) {
										$start_book = 21;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "ECC";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Song of Solomon|song of solomon|Song of Songs|song of songs|SONG|Song|song)+/i', $verse)) {
										$start_book = 22;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "SNG";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Isaiah|isaiah|ISA|Isa|isa)+/i', $verse)){
										$start_book = 23;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "ISA";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Jeremiah|jeremiah|JER|Jer|jer)+/i', $verse)) {
										$start_book = 24;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "JER";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Lamentations|lamentations|LAM|Lam|lam)+/i', $verse)) {
										$start_book = 25;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "LAM";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Ezekiel|ezekiel|EZEK|Ezek|ezek)+/i', $verse)) {
										$start_book = 26;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "EZK";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Daniel|daniel|DAN|Dan|dan)+/i', $verse)) {
										$start_book = 27;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "DAN";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Hosea|hosea|HOS|Hos|hos)+/i', $verse)) {
										$start_book = 28;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "HOS";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Joel|joel)+/i', $verse)) {
										$start_book = 29;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "JOL";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Amos|amos)+/i', $verse)) {
										$start_book = 30;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "AMO";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Obadiah|obadiah|OBAD|Obad|obad)+/i', $verse)) {
										$start_book = 31;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "OBA";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Jonah|jonah|JON|Jon|jon)+/i', $verse)) {
										$start_book = 32;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "JON";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Micah|micah|MIC|Mic|mic)+/i', $verse)) {
										$start_book = 33;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "MIC";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Nahum|nahum|NAH|Nah|nah)+/i', $verse)) {
										$start_book = 34;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "NAM";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Habakkuk|habakkuk|HAB|Hab|hab)+/i', $verse)) {
										$start_book = 35;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "HAB";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Zephaniah|zephaniah|ZEPH|Zeph|zeph)+/i', $verse)) {
										$start_book = 36;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "ZEP";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Haggai|haggai|HAG|Hag|hag)+/i', $verse)) {
										$start_book = 37;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "HAG";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Zechariah|zechariah|ZECH|Zech|zech)+/i', $verse)) {
										$start_book = 38;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "ZEC";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Malachi|malachi|MAL|Mal|mal)+/i', $verse)) {
										$start_book = 39;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "MAL";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Matthew|matthew|MATT|Matt|matt)+/i', $verse)) {
										$start_book = 40;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "MAT";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Mark|mark|MK|Mk|mk)+/i', $verse)) {
										$start_book = 41;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "MRK";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Luke|luke|LK|Lk|lk)+/i', $verse)) {
										$start_book = 42;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "LUK";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(John|john|JN|Jn|jn)+/i', $verse)) {
										if (preg_match('/(1 John|1 john|1 JN|1 Jn|1 jn)+/i', $verse)) {
											$start_book = 62;
											$bookname = $enmse_booknames[$start_book];
											$bookcode = "1JN";
											$shortbookname = $enmse_bookabr[$start_book];
										} elseif (preg_match('/(2 John|2 john|2 JN|2 Jn|2 jn)+/i', $verse)) {
											$start_book = 63;
											$bookname = $enmse_booknames[$start_book];
											$bookcode = "2JN";
											$shortbookname = $enmse_bookabr[$start_book];
										} elseif (preg_match('/(3 John|3 john|3 JN|3 Jn|3 jn)+/i', $verse)) {
											$start_book = 64;
											$bookname = $enmse_booknames[$start_book];
											$bookcode = "3JN";
											$shortbookname = $enmse_bookabr[$start_book];
										} else {
											$start_book = 43;
											$bookname = $enmse_booknames[$start_book];
											$bookcode = "JHN";
											$shortbookname = $enmse_bookabr[$start_book];
										}
									} elseif (preg_match('/(Acts|acts)+/i', $verse)) {
										$start_book = 44;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "ACT";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Romans|romans|ROM|Rom|rom)+/i', $verse)){
										$start_book = 45;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "ROM";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(1 Corinthians|1 corinthians|1 COR|1 Cor|1 cor)+/i', $verse)) {
										$start_book = 46;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "1CO";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(2 Corinthians|2 corinthians|2 COR|2 Cor|2 cor)+/i', $verse)) {
										$start_book = 47;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "2CO";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Galatians|galatians|GAL|Gal|gal)+/i', $verse)) {
										$start_book = 48;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "GAL";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Ephesians|ephesians|EPH|Eph|eph)+/i', $verse)) {
										$start_book = 49;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "EPH";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Philippians|philippians|PHIL|Phil|phil)+/i', $verse)) {
										$start_book = 50;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "PHP";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Colossians|colossians|COL|Col|col)+/i', $verse)) {
										$start_book = 51;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "COL";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(1 Thessalonians|1 thessalonians|1 THESS|1 Thess|1 thess)+/i', $verse)) {
										$start_book = 52;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "1TH";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(2 Thessalonians|2 thessalonians|2 THESS|2 Thess|2 thess)+/i', $verse)) {
										$start_book = 53;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "2TH";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(1 Timothy|1 timothy|1 TIM|1 Tim|1 tim)+/i', $verse)) {
										$start_book = 54;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "1TI";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(2 Timothy|2 timothy|2 TIM|2 Tim|2 tim)+/i', $verse)) {
										$start_book = 55;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "2TI";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Titus|titus)+/i', $verse)) {
										$start_book = 56;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "TIT";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Philemon|philemon)+/i', $verse)) {
										$start_book = 57;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "PHM";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Hebrews|hebrews|HEB|Heb|heb)+/i', $verse)) {
										$start_book = 58;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "HEB";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(James|james|JAS|Jas|jas)+/i', $verse)) {
										$start_book = 59;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "JAS";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(1 Peter|1 peter|1 PET|1 Pet|1 pet)+/i', $verse)) {
										$start_book = 60;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "1PE";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(2+\s+Peter|2 peter|2 PET|2 Pet|2 pet)+/i', $verse)) {
										$start_book = 61;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "2PE";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Jude|jude)+/i', $verse)) {
										$start_book = 65;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "JUD";
										$shortbookname = $enmse_bookabr[$start_book];
									} elseif (preg_match('/(Revelation|revelation|Revelations|revelations|REV|Rev|rev)+/i', $verse)) {
										$start_book = 66;
										$bookname = $enmse_booknames[$start_book];
										$bookcode = "REV";
										$shortbookname = $enmse_bookabr[$start_book];
									} else {
										$start_book = 0;
									}

									// Get Chapter
									if (preg_match('/([0-9]+:)+/i', $verse, $match)) {
										if ( $match[0] != null ) {
											if (preg_match('/([0-9]+)+/i', $match[0], $chaptermatch)) {
												if ( $chaptermatch[0] != null ) {
													$start_chapter = $chaptermatch[0];
												}
											}
										} else {
											$start_chapter = 0;
										}
									}

									// Get Start Verse
									if (preg_match('/(:[0-9]+)+/i', $verse, $svmatch)) {
										if ( $svmatch[0] != null ) {
											if (preg_match('/([0-9]+)+/i', $svmatch[0], $startmatch)) {
												if ( $startmatch[0] != null ) {
													$start_verse = $startmatch[0];
												}
											}
										} else {
											$start_verse = 0;
										}
									}

									// Get End Verse
									if (preg_match('/(-[0-9]+)+/i', $verse, $evmatch)) {
										if ( $evmatch[0] != null ) {
											if (preg_match('/([0-9]+)+/i', $evmatch[0], $endmatch)) {
												if ( $endmatch[0] != null ) {
													$end_verse = $endmatch[0];
												}
											}
										}
									} else {
										$end_verse = $start_verse;			
									}

									$trans = $deftrans;

									if ( $start_book != 0 && $start_chapter != 0 && $start_verse != 0 ) {

										if ( $start_verse != $end_verse ) {
											$enmse_text = $bookname . " " . $start_chapter . ":" . $start_verse . "-" . $end_verse;
											$enmse_short_text = $shortbookname . " " . $start_chapter . ":" . $start_verse . "-" . $end_verse;
											$enmse_link = "https://bible.com/bible/" . $trans . "/" . $bookcode . "." . $start_chapter . "." . $start_verse . "-" . $end_verse;
										} else {
											$enmse_text = $bookname . " " . $start_chapter . ":" . $start_verse;
											$enmse_short_text = $shortbookname . " " . $start_chapter . ":" . $start_verse;
											$enmse_link = "https://bible.com/bible/" . $trans . "/" . $bookcode . "." . $start_chapter . "." . $start_verse;
										}                                        

										$enmse_scripture = array(
											'start_book' => $start_book, 
											'start_chapter' => $start_chapter,
											'start_verse' => $start_verse,
											'end_verse' => $end_verse,
											'trans' => $trans,
											'focus' => 1,
											'text' => $enmse_text,
											'short_text' => $enmse_short_text,
											'link' => $enmse_link
											); 
										$wpdb->insert( $wpdb->prefix . "se_scriptures", $enmse_scripture );
										$enmse_new_scripture_id = $wpdb->insert_id; 
										
										// Add file relation in the DB
										$enmse_newscmm = array(
											'message_id' => $enmse_new_message_id, 
											'scripture_id' => $enmse_new_scripture_id
										); 
										$wpdb->insert( $wpdb->prefix . "se_scripture_message_matches", $enmse_newscmm );

										$enmse_new_mvalues = array( 'focus_scripture' => $getData[14] ); 
										$enmse_mwhere = array( 'message_id' => $enmse_new_message_id ); 
										$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

										$enmse_preparreddscmsql = "SELECT bm_match_id FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id = %d AND book_id = %d GROUP BY bm_match_id ORDER BY bm_match_id ASC"; 
										$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $enmse_new_message_id, $start_book );
										$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
										$enmse_countrec = $wpdb->num_rows;

										if ( $enmse_countrec > 1 || empty($enmse_dmscriptures) ) {
											$enmse_newbmm = array(
												'message_id' => $enmse_new_message_id, 
												'book_id' => $start_book
											); 
											$wpdb->insert( $wpdb->prefix . "se_book_message_matches", $enmse_newbmm );
										}


									}

			
								}

							}// end

							preg_match_all('/\d+ (\w+)( (\d+)(:\d+)?([\-–]\d+)?(, \d+[\-–]\d+)?)?/', $getData[14], $secondresult, PREG_PATTERN_ORDER);

							if ( !empty($secondresult) ) {
								foreach ($secondresult[0] as $verse) {

									// Get Book
									$start_book = 0;
									if (preg_match('/(Genesis|genesis|GEN|Gen|gen)+/i', $verse)) {
										$start_book = 1;
										$shortbookname = "Gen";
										$bookname = "Genesis";
										$bookcode = "GEN";
									} elseif (preg_match('/(Exodus|exodus|EXO|Exo|exo)+/i', $verse)) {
										$start_book = 2;
										$shortbookname = "Exo";
										$bookname = "Exodus";
										$bookcode = "EXO";
									} elseif (preg_match('/(Leviticus|leviticus|LEV|Lev|lev)+/i', $verse)) {
										$start_book = 3;
										$shortbookname = "Lev";
										$bookname = "Leviticus";
										$bookcode = "LEV";
									} elseif (preg_match('/(Numbers|numbers|NUM|Num|num)+/i', $verse)) {
										$start_book = 4;
										$shortbookname = "Num";
										$bookname = "Numbers";
										$bookcode = "NUM";
									} elseif (preg_match('/(Deuteronomy|deuteronomy|DEUT|Deut|deut)+/i', $verse)) {
										$start_book = 5;
										$shortbookname = "Deut";
										$bookname = "Deuteronomy";
										$bookcode = "DEU";
									} elseif (preg_match('/(Joshua|joshua|JOSH|Josh|josh)+/i', $verse)) {
										$start_book = 6;
										$bookname = "Joshua";
										$bookcode = "JOS";
										$shortbookname = "Josh";
									} elseif (preg_match('/(Judges|judges|JUDG|Judg|judg)+/i', $verse)) {
										$start_book = 7;
										$bookname = "Judges";
										$bookcode = "JDG";
										$shortbookname = "Judg";
									} elseif (preg_match('/(Ruth|ruth)+/i', $verse)) {
										$start_book = 8;
										$bookname = "Ruth";
										$bookcode = "RUT";
										$shortbookname = "Ruth";
									} elseif (preg_match('/(1 Samuel|1 samuel|1 SAM|1 Sam|1 sam)+/i', $verse)) {
										$start_book = 9;
										$bookname = "1 Samuel";
										$bookcode = "1SA";
										$shortbookname = "1 Sam";
									} elseif (preg_match('/(2 Samuel|2 samuel|2 SAM|2 Sam|2 sam)+/i', $verse)) {
										$start_book = 10;
										$bookname = "2 Samuel";
										$bookcode = "2SA";
										$shortbookname = "2 Sam";
									} elseif (preg_match('/(1 Kings|1 kings)+/i', $verse)) {
										$start_book = 11;
										$bookname = "1 Kings";
										$bookcode = "1KI";
										$shortbookname = "1 Kings";
									} elseif (preg_match('/(2 Kings|2 kings)+/i', $verse)) {
										$start_book = 12;
										$bookname = "2 Kings";
										$bookcode = "2KI";
										$shortbookname = "2 Kings";
									} elseif (preg_match('/(1 Chronicles|1 chronicles|1 CHR|1 Chr|1 chr)+/i', $verse)) {
										$start_book = 13;
										$bookname = "1 Chronicles";
										$bookcode = "1CH";
										$shortbookname = "1 Chr";
									} elseif (preg_match('/(2 Chronicles|2 chronicles|2 CHR|2 Chr|2 chr)+/i', $verse)) {
										$start_book = 14;
										$bookname = "2 Chronicles";
										$bookcode = "2CH";
										$shortbookname = "2 Chr";
									} elseif (preg_match('/(Ezra|ezra)+/i', $verse)) {
										$start_book = 15;
										$bookname = "Ezra";
										$bookcode = "EZR";
										$shortbookname = "Ezra";
									} elseif (preg_match('/(Nehemiah|nehemiah|NEH|Neh|neh)+/i', $verse)) {
										$start_book = 16;
										$bookname = "Nehemiah";
										$bookcode = "NEH";
										$shortbookname = "Neh";
									} elseif (preg_match('/(Esther|esther|ESTH|Esth|esth)+/i', $verse)) {
										$start_book = 17;
										$bookname = "Esther";
										$bookcode = "EST";
										$shortbookname = "Esth";
									} elseif (preg_match('/(Job|job)+/i', $verse)) {
										$start_book = 18;
										$bookname = "Job";
										$bookcode = "JOB";
										$shortbookname = "Job";
									} elseif (preg_match('/(Psalms|psalms|Psalm|psalm|PS|Ps|ps)+/i', $verse)) {
										$start_book = 19;
										$bookname = "Psalms";
										$bookcode = "PSA";
										$shortbookname = "Ps";
									} elseif (preg_match('/(Proverbs|proverbs|PROV|Prov|prov)+/i', $verse)) {
										$start_book = 20;
										$bookname = "Proverbs";
										$bookcode = "PRO";
										$shortbookname = "Prov";
									} elseif (preg_match('/(Ecclesiastes|ecclesiastes|ECC|Ecc|ecc)+/i', $verse)) {
										$start_book = 21;
										$bookname = "Ecclesiastes";
										$bookcode = "ECC";
										$shortbookname = "Ecc";
									} elseif (preg_match('/(Song of Solomon|song of solomon|Song of Songs|song of songs|SONG|Song|song)+/i', $verse)) {
										$start_book = 22;
										$bookname = "Song of Solomon";
										$bookcode = "SNG";
										$shortbookname = "Song";
									} elseif (preg_match('/(Isaiah|isaiah|ISA|Isa|isa)+/i', $verse)){
										$start_book = 23;
										$bookname = "Isaiah";
										$bookcode = "ISA";
										$shortbookname = "Isa";
									} elseif (preg_match('/(Jeremiah|jeremiah|JER|Jer|jer)+/i', $verse)) {
										$start_book = 24;
										$bookname = "Jeremiah";
										$bookcode = "JER";
										$shortbookname = "Jer";
									} elseif (preg_match('/(Lamentations|lamentations|LAM|Lam|lam)+/i', $verse)) {
										$start_book = 25;
										$bookname = "Lamentations";
										$bookcode = "LAM";
										$shortbookname = "Lam";
									} elseif (preg_match('/(Ezekiel|ezekiel|EZEK|Ezek|ezek)+/i', $verse)) {
										$start_book = 26;
										$bookname = "Ezekiel";
										$bookcode = "EZK";
										$shortbookname = "Ezek";
									} elseif (preg_match('/(Daniel|daniel|DAN|Dan|dan)+/i', $verse)) {
										$start_book = 27;
										$bookname = "Daniel";
										$bookcode = "DAN";
										$shortbookname = "Dan";
									} elseif (preg_match('/(Hosea|hosea|HOS|Hos|hos)+/i', $verse)) {
										$start_book = 28;
										$bookname = "Hosea";
										$bookcode = "HOS";
										$shortbookname = "Hos";
									} elseif (preg_match('/(Joel|joel)+/i', $verse)) {
										$start_book = 29;
										$bookname = "Joel";
										$bookcode = "JOL";
										$shortbookname = "Joel";
									} elseif (preg_match('/(Amos|amos)+/i', $verse)) {
										$start_book = 30;
										$bookname = "Amos";
										$bookcode = "AMO";
										$shortbookname = "Amos";
									} elseif (preg_match('/(Obadiah|obadiah|OBAD|Obad|obad)+/i', $verse)) {
										$start_book = 31;
										$bookname = "Obadiah";
										$bookcode = "OBA";
										$shortbookname = "Obad";
									} elseif (preg_match('/(Jonah|jonah|JON|Jon|jon)+/i', $verse)) {
										$start_book = 32;
										$bookname = "Jonah";
										$bookcode = "JON";
										$shortbookname = "Jon";
									} elseif (preg_match('/(Micah|micah|MIC|Mic|mic)+/i', $verse)) {
										$start_book = 33;
										$bookname = "Micah";
										$bookcode = "MIC";
										$shortbookname = "Mic";
									} elseif (preg_match('/(Nahum|nahum|NAH|Nah|nah)+/i', $verse)) {
										$start_book = 34;
										$bookname = "Nahum";
										$bookcode = "NAM";
										$shortbookname = "Nah";
									} elseif (preg_match('/(Habakkuk|habakkuk|HAB|Hab|hab)+/i', $verse)) {
										$start_book = 35;
										$bookname = "Habakkuk";
										$bookcode = "HAB";
										$shortbookname = "Hab";
									} elseif (preg_match('/(Zephaniah|zephaniah|ZEPH|Zeph|zeph)+/i', $verse)) {
										$start_book = 36;
										$bookname = "Zephaniah";
										$bookcode = "ZEP";
										$shortbookname = "Zeph";
									} elseif (preg_match('/(Haggai|haggai|HAG|Hag|hag)+/i', $verse)) {
										$start_book = 37;
										$bookname = "Haggai";
										$bookcode = "HAG";
										$shortbookname = "Hag";
									} elseif (preg_match('/(Zechariah|zechariah|ZECH|Zech|zech)+/i', $verse)) {
										$start_book = 38;
										$bookname = "Zechariah";
										$bookcode = "ZEC";
										$shortbookname = "Zech";
									} elseif (preg_match('/(Malachi|malachi|MAL|Mal|mal)+/i', $verse)) {
										$start_book = 39;
										$bookname = "Malachi";
										$bookcode = "MAL";
										$shortbookname = "Mal";
									} elseif (preg_match('/(Matthew|matthew|MATT|Matt|matt)+/i', $verse)) {
										$start_book = 40;
										$bookname = "Matthew";
										$bookcode = "MAT";
										$shortbookname = "Mt";
									} elseif (preg_match('/(Mark|mark|MK|Mk|mk)+/i', $verse)) {
										$start_book = 41;
										$bookname = "Mark";
										$bookcode = "MRK";
										$shortbookname = "Mk";
									} elseif (preg_match('/(Luke|luke|LK|Lk|lk)+/i', $verse)) {
										$start_book = 42;
										$bookname = "Luke";
										$bookcode = "LUK";
										$shortbookname = "Lk";
									} elseif (preg_match('/(John|john|JN|Jn|jn)+/i', $verse)) {
										if (preg_match('/(1 John|1 john|1 JN|1 Jn|1 jn)+/i', $verse)) {
											$start_book = 62;
											$bookname = "1 John";
											$bookcode = "1JN";
											$shortbookname = "1 Jn";
										} elseif (preg_match('/(2 John|2 john|2 JN|2 Jn|2 jn)+/i', $verse)) {
											$start_book = 63;
											$bookname = "2 John";
											$bookcode = "2JN";
											$shortbookname = "2 Jn";
										} elseif (preg_match('/(3 John|3 john|3 JN|3 Jn|3 jn)+/i', $verse)) {
											$start_book = 64;
											$bookname = "3 John";
											$bookcode = "3JN";
											$shortbookname = "3 Jn";
										} else {
											$start_book = 43;
											$bookname = "John";
											$bookcode = "JHN";
											$shortbookname = "Jn";
										}
									} elseif (preg_match('/(Acts|acts)+/i', $verse)) {
										$start_book = 44;
										$bookname = "Acts";
										$bookcode = "ACT";
										$shortbookname = "Acts";
									} elseif (preg_match('/(Romans|romans|ROM|Rom|rom)+/i', $verse)){
										$start_book = 45;
										$bookname = "Romans";
										$bookcode = "ROM";
										$shortbookname = "Rom";
									} elseif (preg_match('/(1 Corinthians|1 corinthians|1 COR|1 Cor|1 cor)+/i', $verse)) {
										$start_book = 46;
										$bookname = "1 Corinthians";
										$bookcode = "1CO";
										$shortbookname = "1 Cor";
									} elseif (preg_match('/(2 Corinthians|2 corinthians|2 COR|2 Cor|2 cor)+/i', $verse)) {
										$start_book = 47;
										$bookname = "2 Corinthians";
										$bookcode = "2CO";
										$shortbookname = "2 Cor";
									} elseif (preg_match('/(Galatians|galatians|GAL|Gal|gal)+/i', $verse)) {
										$start_book = 48;
										$bookname = "Galatians";
										$bookcode = "GAL";
										$shortbookname = "Gal";
									} elseif (preg_match('/(Ephesians|ephesians|EPH|Eph|eph)+/i', $verse)) {
										$start_book = 49;
										$bookname = "Ephesians";
										$bookcode = "EPH";
										$shortbookname = "Eph";
									} elseif (preg_match('/(Philippians|philippians|PHIL|Phil|phil)+/i', $verse)) {
										$start_book = 50;
										$bookname = "Philippians";
										$bookcode = "PHP";
										$shortbookname = "Phil";
									} elseif (preg_match('/(Colossians|colossians|COL|Col|col)+/i', $verse)) {
										$start_book = 51;
										$bookname = "Colossians";
										$bookcode = "COL";
										$shortbookname = "Col";
									} elseif (preg_match('/(1 Thessalonians|1 thessalonians|1 THESS|1 Thess|1 thess)+/i', $verse)) {
										$start_book = 52;
										$bookname = "1 Thessalonians";
										$bookcode = "1TH";
										$shortbookname = "1 Thess";
									} elseif (preg_match('/(2 Thessalonians|2 thessalonians|2 THESS|2 Thess|2 thess)+/i', $verse)) {
										$start_book = 53;
										$bookname = "2 Thessalonians";
										$bookcode = "2TH";
										$shortbookname = "2 Thess";
									} elseif (preg_match('/(1 Timothy|1 timothy|1 TIM|1 Tim|1 tim)+/i', $verse)) {
										$start_book = 54;
										$bookname = "1 Timothy";
										$bookcode = "1TI";
										$shortbookname = "1 Tim";
									} elseif (preg_match('/(2 Timothy|2 timothy|2 TIM|2 Tim|2 tim)+/i', $verse)) {
										$start_book = 55;
										$bookname = "2 Timothy";
										$bookcode = "2TI";
										$shortbookname = "2 Tim";
									} elseif (preg_match('/(Titus|titus)+/i', $verse)) {
										$start_book = 56;
										$bookname = "Titus";
										$bookcode = "TIT";
										$shortbookname = "Titus";
									} elseif (preg_match('/(Philemon|philemon)+/i', $verse)) {
										$start_book = 57;
										$bookname = "Philemon";
										$bookcode = "PHM";
										$shortbookname = "Philemon";
									} elseif (preg_match('/(Hebrews|hebrews|HEB|Heb|heb)+/i', $verse)) {
										$start_book = 58;
										$bookname = "Hebrews";
										$bookcode = "HEB";
										$shortbookname = "Heb";
									} elseif (preg_match('/(James|james|JAS|Jas|jas)+/i', $verse)) {
										$start_book = 59;
										$bookname = "James";
										$bookcode = "JAS";
										$shortbookname = "Jas";
									} elseif (preg_match('/(1 Peter|1 peter|1 PET|1 Pet|1 pet)+/i', $verse)) {
										$start_book = 60;
										$bookname = "1 Peter";
										$bookcode = "1PE";
										$shortbookname = "1 Pet";
									} elseif (preg_match('/(2 Peter|2 peter|2 PET|2 Pet|2 pet)+/i', $verse)) {
										$start_book = 61;
										$bookname = "2 Peter";
										$bookcode = "2PE";
										$shortbookname = "2 Pet";
									} elseif (preg_match('/(Jude|jude)+/i', $verse)) {
										$start_book = 65;
										$bookname = "Jude";
										$bookcode = "JUD";
										$shortbookname = "Jude";
									} elseif (preg_match('/(Revelation|revelation|Revelations|revelations|REV|Rev|rev)+/i', $verse)) {
										$start_book = 66;
										$bookname = "Revelation";
										$bookcode = "REV";
										$shortbookname = "Rev";
									} else {
										$start_book = 0;
									}

									// Get Chapter
									if (preg_match('/([0-9]+:)+/i', $verse, $match)) {
										if ( $match[0] != null ) {
											if (preg_match('/([0-9]+)+/i', $match[0], $chaptermatch)) {
												if ( $chaptermatch[0] != null ) {
													$start_chapter = $chaptermatch[0];
												}
											}
										} else {
											$start_chapter = 0;
										}
									}

									// Get Start Verse
									if (preg_match('/(:[0-9]+)+/i', $verse, $svmatch)) {
										if ( $svmatch[0] != null ) {
											if (preg_match('/([0-9]+)+/i', $svmatch[0], $startmatch)) {
												if ( $startmatch[0] != null ) {
													$start_verse = $startmatch[0];
												}
											}
										} else {
											$start_verse = 0;
										}
									}

									// Get End Verse
									if (preg_match('/(-[0-9]+)+/i', $verse, $evmatch)) {
										if ( $evmatch[0] != null ) {
											if (preg_match('/([0-9]+)+/i', $evmatch[0], $endmatch)) {
												if ( $endmatch[0] != null ) {
													$end_verse = $endmatch[0];
												}
											}
										}
									} else {
										$end_verse = $start_verse;			
									}

									$trans = $deftrans;

									if ( $start_book != 0 && $start_chapter != 0 && $start_verse != 0 ) {

										if ( $start_verse != $end_verse ) {
											$enmse_text = $bookname . " " . $start_chapter . ":" . $start_verse . "-" . $end_verse;
											$enmse_short_text = $shortbookname . " " . $start_chapter . ":" . $start_verse . "-" . $end_verse;
											$enmse_link = "https://bible.com/bible/" . $trans . "/" . $bookcode . "." . $start_chapter . "." . $start_verse . "-" . $end_verse;
										} else {
											$enmse_text = $bookname . " " . $start_chapter . ":" . $start_verse;
											$enmse_short_text = $shortbookname . " " . $start_chapter . ":" . $start_verse;
											$enmse_link = "https://bible.com/bible/" . $trans . "/" . $bookcode . "." . $start_chapter . "." . $start_verse;
										}                                        

										$enmse_scripture = array(
											'start_book' => $start_book, 
											'start_chapter' => $start_chapter,
											'start_verse' => $start_verse,
											'end_verse' => $end_verse,
											'trans' => $trans,
											'focus' => 1,
											'text' => $enmse_text,
											'short_text' => $enmse_short_text,
											'link' => $enmse_link
											); 
										$wpdb->insert( $wpdb->prefix . "se_scriptures", $enmse_scripture );
										$enmse_new_scripture_id = $wpdb->insert_id; 
										
										// Add file relation in the DB
										$enmse_newscmm = array(
											'message_id' => $enmse_new_message_id, 
											'scripture_id' => $enmse_new_scripture_id
										); 
										$wpdb->insert( $wpdb->prefix . "se_scripture_message_matches", $enmse_newscmm );

										$enmse_new_mvalues = array( 'focus_scripture' => $getData[14] ); 
										$enmse_mwhere = array( 'message_id' => $enmse_new_message_id ); 
										$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

										$enmse_preparreddscmsql = "SELECT bm_match_id FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id = %d AND book_id = %d GROUP BY bm_match_id ORDER BY bm_match_id ASC"; 
										$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $enmse_new_message_id, $start_book );
										$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
										$enmse_countrec = $wpdb->num_rows;

										if ( $enmse_countrec > 1 || empty($enmse_dmscriptures) ) {
											$enmse_newbmm = array(
												'message_id' => $enmse_new_message_id, 
												'book_id' => $start_book
											); 
											$wpdb->insert( $wpdb->prefix . "se_book_message_matches", $enmse_newbmm );
										}


									}

			
								}

							}// end
						}

						$enmse_findthemessagessql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " WHERE series_thumbnail IS NULL"; 
						$enmse_allmessages = $wpdb->get_results( $enmse_findthemessagessql );

						$enmse_findtheseriessql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) GROUP BY sm_match_id"; 
						$enmse_allseries = $wpdb->get_results( $enmse_findtheseriessql );

						foreach ( $enmse_allmessages as $m ) {
							foreach ( $enmse_allseries as $s ) {
								if ( $m->message_id == $s->message_id ) {
									$enmse_new_mvalues = array( 'series_thumbnail' => $s->graphic_thumb, 'series_image' => $s->thumbnail_url, 'series_podcast_image' => $s->podcast_image ); 
									$enmse_mwhere = array( 'message_id' => $m->message_id  ); 
									$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );
								}
							}
						}


		         	}
		         }
				
		         fclose($file);	

		         include('import/makepermalinks.php');
		         $enmse_messages[] = "Bulk import sucessfully completed!";
			 } else {
			 	$enmse_errors[] = "Please upload a file for your bulk import.";
			 }
		} elseif ( $_POST && $_GET['seimport'] == "3") { // SE Settings
			global $wpdb;
			$filename=$_FILES["file"]["tmp_name"];		
 
 
			 if($_FILES["file"]["size"] > 0)
			 {
			  	$file = fopen($filename, "r");
		        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		         {
		         	if ( $getData[0] == "options" ) {
		         		$enmse_newrecord = unserialize($getData[1]);
						update_option('enm_seriesengine_options', $enmse_newrecord);
					}
		         }
				
		         fclose($file);	
		         $enmse_messages[] = "Series Engine styles and settings successfully loaded!";
			 } else {
			 	$enmse_errors[] = "Please upload a file for your settings import.";
			 }
		} elseif ( $_POST && $_GET['seupdate'] == "1") { // Update Speakers
			global $wpdb;

			$enmse_findthemessagessql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " WHERE speaker IS NULL OR speaker = ''"; 
			$enmse_allmessages = $wpdb->get_results( $enmse_findthemessagessql );

			$enmse_findthespeakerssql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) GROUP BY msp_match_id"; 
			$enmse_allspeakers = $wpdb->get_results( $enmse_findthespeakerssql );

			$fixcount = 0;
			foreach ( $enmse_allmessages as $m ) {
				foreach ( $enmse_allspeakers as $s ) {
					if ( $m->message_id == $s->message_id ) {
						$newspeaker = $s->first_name . " " . $s->last_name;
						$enmse_new_mvalues = array( 'speaker' => $newspeaker ); 
						$enmse_mwhere = array( 'message_id' => $m->message_id  ); 
						$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );
						$fixcount = $fixcount + 1;
					}
				}
			}
			if ( $fixcount == 1 ) {
				$enmse_messages[] = "<strong>" . $fixcount . " " . $enmsemessaget . " was updated.</strong> Your " . $enmsespeakertp . " should all be up to date now!";
			} else {
				$enmse_messages[] = "<strong>" . $fixcount . " " . $enmsemessagetp . " were updated.</strong> Your " . $enmsespeakertp . " should all be up to date now!";
			}

		} elseif ( $_POST && $_GET['seupdate'] == "2") { // Update Series Images
			global $wpdb;

			$enmse_findthemessagessql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " WHERE primary_series IS NULL"; 
			$enmse_allmessages = $wpdb->get_results( $enmse_findthemessagessql );

			$enmse_findtheseriessql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) GROUP BY sm_match_id"; 
			$enmse_allseries = $wpdb->get_results( $enmse_findtheseriessql );

			$fixcount = 0;
			foreach ( $enmse_allmessages as $m ) {
				$matchcount = 0;
				foreach ( $enmse_allseries as $s ) {
					if ( $m->message_id == $s->message_id ) {
						$enmse_new_mvalues = array( 'primary_series' => $s->series_id, 'series_thumbnail' => $s->graphic_thumb, 'series_image' => $s->thumbnail_url, 'series_podcast_image' => $s->podcast_image ); 
						$enmse_mwhere = array( 'message_id' => $m->message_id  ); 
						$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );
						$fixcount = $fixcount + 1;
						$matchcount = 1;
					}
				}
				if ( $matchcount == 0 ) {
					$enmse_new_mvalues = array( 'primary_series' => 0 ); 
					$enmse_mwhere = array( 'message_id' => $m->message_id  ); 
					$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );
					$fixcount = $fixcount + 1;
				}
			}

			if ( $fixcount == 1 ) {
				$enmse_messages[] = "<strong>" . $fixcount . " " . $enmsemessaget . " was updated.</strong> Your " . $enmseseriestp . " images should now show up in various views throughout the plugin!";
			} else {
				$enmse_messages[] = "<strong>" . $fixcount . " " . $enmsemessagetp . " were updated.</strong> Your " . $enmseseriestp . " images should now show up in various views throughout the plugin!";
			}

		} elseif ( $_POST && $_GET['seupdate'] == "3") { // Update Permalinks
			global $wpdb;

			include('import/makepermalinks.php');

			if ( $fixcount == 1 ) {
				$enmse_messages[] = "<strong>" . $fixcount . " permalink was updated.</strong> That " . $enmsemessaget . " is now optimized for search engines, native site searches, and social sharing!";
			} else {
				$enmse_messages[] = "<strong>" . $fixcount . " permalinks were updated.</strong> Those " . $enmsemessagetp . " are now optimized for search engines, native site searches, and social sharing!";
			}

		} elseif ( $_POST && $_GET['seplugin'] == "1") { /* -------------- Sermon Browser ------------------- */
			global $wpdb;
			$poffset = 9000;

			include('import/sermonbrowser.php');
			include('import/makepermalinks.php');
			
		} elseif ( $_POST && $_GET['seplugin'] == "2") { /* -------------- Sermon Manager ------------------- */
			global $wpdb;
			$poffset = 2000;

			include('import/sermonmanager.php');
			include('import/makepermalinks.php');
			
		} elseif ( $_POST && $_GET['seplugin'] == "3") { /* -------------- Church Content ------------------- */
			global $wpdb;
			$poffset = 10000;

			include('import/churchcontent.php');
			//include('import/makepermalinks.php');
			
		}

		global $wpdb;

		$enmse_findthesmessagessql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " WHERE speaker IS NULL OR speaker = ''"; 
		$enmse_speakercheck = $wpdb->get_results( $enmse_findthesmessagessql );

		$enmse_findthesmessagesagainsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " WHERE primary_series IS NULL"; 
		$enmse_seriescheck = $wpdb->get_results( $enmse_findthesmessagesagainsql );

		$enmse_findthesmessagesyetagainsql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " WHERE wp_post_id IS NULL"; 
		$enmse_permacheck = $wpdb->get_results( $enmse_findthesmessagesyetagainsql );

		$sermonbrowser = $wpdb->prefix . "sb_sermons"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$sermonbrowser'") != $sermonbrowser ) {
			$sbcheck = 0;
		} else {
			$sbcheck = 1;
		}

		$enmse_sermonmanagersql = "SELECT ID FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'wpfc_sermon' LIMIT 1"; 
		$enmse_sermonmanager = $wpdb->get_results( $enmse_sermonmanagersql );
		if( empty($enmse_sermonmanager) ) {
			$smcheck = 0;
		} else {
			$smcheck = 1;
		}

		$enmse_churchcontentsql = "SELECT ID FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'ctc_sermon' LIMIT 1"; 
		$enmse_churchcontent = $wpdb->get_results( $enmse_churchcontentsql );
		if( empty($enmse_churchcontent) ) {
			$cccheck = 0;
		} else {
			$cccheck = 1;
		}



	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap exportpage"> 
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#bulkbutton').click(function() {
				jQuery("#bulkloading").show();				
			});
			jQuery('#settingsbutton').click(function() {
				jQuery("#settingsloading").show();				
			});
			jQuery('#importbutton').click(function() {
				jQuery("#importloading").show();				
			});
		});
	</script>
    <div></div>
	<h2 class="enmse">Export and Import Data</h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>

	<h3>Export All Series Engine Content</h3>
	
	<p>Whether you're moving sites or just want to back up your data, it's easy to export all of your Series Engine content to a simple .CSV file.</p>
	<p><a href="http://seriesengine.com/importexport.php" target="_blank">Click here to read our extensive guide</a> for migrating Series Engine content between sites.</p>
	<p><em>Exporting data <strong>will not</strong> change or delete any plugin content.</em></p>

	<form action="<?php echo plugins_url() .'/seriesengine_plugin/includes/admin/export/allcontent.php?xxse=' . base64_encode(ABSPATH); ?>" method="post" id="reportform" target="_blank">
		<table class="form-table" style="margin-bottom: -10px">
			<tr valign="top">
				<th scope="row"><strong>Offset IDs by:</strong>
					<p class="se-form-instructions">Advanced use only. See the <a href="http://seriesengine.com/importexport.php#offset" target="_blank">user guide</a>.</p></th>
				<td><input id='enmseoffset' name='enmseoffset' type='text' value='0' tabindex="1" size="6" /></td>
			</tr>
		</table>
		<input name="Submit" type="submit" class="button" value="Export All Content" tabindex="35" />
	</form><br />
	<form action="<?php echo plugins_url() .'/seriesengine_plugin/includes/admin/export/sesettings.php?xxse=' . base64_encode(ABSPATH); ?>" method="post" id="reportform" target="_blank">
		<input name="Submit" type="submit" class="button" value="Export Styles and Settings" tabindex="35" />
	</form>
	<p>&nbsp;</p>

	<h3>Import Previous Series Engine Content</h3>
	<p>If this is a fresh install of Series Engine, you can use the options below to import data from a previous Series Engine install.</p>

	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seimport=1&seplugin=0&seupdate=0" method="post" name="uploadsecsv" enctype="multipart/form-data">
		<table class="form-table" style="margin-bottom: -10px">
			<tr valign="top">
				<th scope="row"><strong>Series Engine Archive:</strong>
					<p class="se-form-instructions">Select a .CSV file from a previous Series Engine export.</p></th>
				<td><input type="file" name="file" id="file" class="input-large"></td>
			</tr>
		</table>
		<table>
			<tr>
				<td><input name="Submit" type="submit" class="button-primary" value="Upload Archive" tabindex="18" id="importbutton" /></td>
				<td><img src="<?php echo plugins_url() .'/seriesengine_plugin/images/loading.gif'; ?>" width="29" height="29" alt="Loading Icon" id="importloading" style="display: none" /></td>
			</tr>
		</table>
	</form>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seimport=3&seplugin=0&seupdate=0" method="post" name="uploadsecsv" enctype="multipart/form-data">
		<table class="form-table" style="margin-bottom: -10px">
			<tr valign="top">
				<th scope="row"><strong>Series Engine Styles/Settings:</strong>
					<p class="se-form-instructions">Select a .CSV file from a previous Series Engine export.</p></th>
				<td><input type="file" name="file" id="file" class="input-large"></td>
			</tr>
		</table>
		<table>
			<tr>
				<td><input name="Submit" type="submit" class="button-primary" value="Upload Styles and Settings" tabindex="18" id="settingsbutton" /></td>
				<td><img src="<?php echo plugins_url() .'/seriesengine_plugin/images/loading.gif'; ?>" width="29" height="29" alt="Loading Icon" id="settingsloading" style="display: none" /></td>
			</tr>
		</table>
	</form>
	<p>&nbsp;</p>

	<h3>Bulk Upload Content into This Series Engine Install</h3>
	<p><em>ADVANCED:</em> Use the fields below to bulk upload content into Series Engine. Bulk imports are only recommended for advanced users who are comfortable with data entry and a text editor.</p>
	<p><a href="http://seriesengine.com/importexport.php#bulk" target="_blank">Click here to read our extensive guide</a> for bulk importing data into Series Engine.</p>

	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seimport=2&seplugin=0&seupdate=0" method="post" name="uploadsecsv" enctype="multipart/form-data">
		<table class="form-table" style="margin-bottom: -10px">
			<tr valign="top">
				<th scope="row"><strong>Bulk Upload Script:</strong>
					<p class="se-form-instructions">Select a properly formatted .CSV file to bulk upload content to Series Engine.</p></th>
				<td><input type="file" name="file" id="file" class="input-large"></td>
			</tr>
		</table>
		<table>
			<tr>
				<td><input name="Submit" type="submit" class="button-primary" value="Bulk Upload Content" tabindex="18" id="bulkbutton" /></td>
				<td><img src="<?php echo plugins_url() .'/seriesengine_plugin/images/loading.gif'; ?>" width="29" height="29" alt="Loading Icon" id="bulkloading" style="display: none" /></td>
			</tr>
		</table>
	</form>

	<br /><br />

	<h3>Import Content from Other Sermon Plugins</h3>
	<p>We frequently add support for importing sermon archives from other sermon plugins. If you have one of the supported plugins installed, you'll see import options below.</p>
	<?php if ( $sbcheck == 1 ) { ?>
	<h3>Import from <em>Sermon Browser</em></h3>
	<p>Hey! It looks like you have <em>Sermon Browser</em> installed. Do you want to import <strong>all</strong> of your <em>Sermon Browser</em> content (Sermons, Series, Services, Preachers, Scripture, Files, etc) into Series Engine? If so, click the button below. For more about importing from <em>Sermon Browser</em>, visit <a href="http://seriesengine.com/sermonbrowser.php">this help page</a>.</p>
	<p><em>Note: Running the importer below won't do anything to change your existing <em>Sermon Browser</em> data.</em></p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seupdate=0&seimport=0&seplugin=1" method="post">
		<input name="Submit" type="submit" class="button" value="Import Sermon Browser Content" tabindex="35" />
	</form>
	<?php } ?>
	<?php if ( $smcheck == 1 ) { ?>
	<h3>Import from <em>Sermon Manager</em></h3>
	<p>Hey! It looks like you have <em>Sermon Manager</em> installed. Do you want to import <strong>all</strong> of your <em>Sermon Manager</em> content (Sermons, Series, Services, Preachers, Scripture, Notes, Bulletins, etc) into Series Engine? If so, click the button below. For more about importing from <em>Sermon Manager</em>, visit <a href="http://seriesengine.com/sermonmanager.php">this help page</a>.</p>
	<p><em>Note: Running the importer below won't do anything to change your existing <em>Sermon Manager</em> data.</em></p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seupdate=0&seimport=0&seplugin=2" method="post">
		<input name="Submit" type="submit" class="button" value="Import Sermon Manager Content" tabindex="35" />
	</form>
	<?php } ?>
	<?php if ( $cccheck == 1 ) { ?>
	<h3>Import from the <em>Church Content Plugin</em></h3>
	<p>Hey! It looks like you have the <em>Church Content Plugin</em> installed. Do you want to import <strong>all</strong> of your <em>Church Content Plugin</em> sermon content (Sermons, Series, Speakers, Notes, etc) into Series Engine? If so, click the button below. For more about importing from the <em>Church Content Plugin</em>, visit <a href="http://seriesengine.com/churchcontent.php">this help page</a>.</p>
	<p><em>Note: Running the importer below won't do anything to change your existing <em>Church Content Plugin</em> data.</em></p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seupdate=0&seimport=0&seplugin=3" method="post">
		<input name="Submit" type="submit" class="button" value="Import Church Content Plugin Content" tabindex="35" />
	</form>
	<?php } ?>

	<br /><br /><br />
	<h3>Update Series Engine Data</h3>
	<p>If you're updating from a previous version of Series Engine, you may be missing some data relationships necessary for certain features to display properly in your <?php echo $enmsemessaget; ?> archives. Use the options below to update missing information with one click.</p>
	<?php if ( empty($enmse_speakercheck) && empty($enmse_seriescheck) ) { ?><p><strong>Awesome! It looks like you're all up to date. You don't need to do anything else at this time.</strong></p><?php } ?>
	<?php if ( !empty($enmse_speakercheck) ) { ?>
	<h4>Update <?php echo $enmsespeakert; ?> Info</h4>
	<p>It looks like you're missing some information in your database that allows <?php echo $enmsespeakert; ?> info to be shown in the Related <?php echo $enmsemessagetp; ?> section. Click the button below to take care of this.</p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seupdate=1&seimport=0&seplugin=0" method="post">
		<input name="Submit" type="submit" class="button" value="Update <?php echo $enmsespeakert; ?> Info" tabindex="35" />
	</form>
	<?php } ?>
	<?php if ( !empty($enmse_seriescheck) ) { ?>
	<h4>Update <?php echo $enmseseriest; ?> Graphics</h4>
	<p>It looks like you're missing some information in your database that allows <?php echo $enmseseriest; ?> images to be shown in the Related <?php echo $enmsemessagetp; ?> section and your podcast feeds. Click the button below to take care of this.</p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seupdate=2&seimport=0&seplugin=0" method="post">
		<input name="Submit" type="submit" class="button" value="Update <?php echo $enmseseriest; ?> Images" tabindex="35" />
	</form>
	<?php } ?>
	<?php if ( !empty($enmse_permacheck) ) { ?>
	<h4>Update Permalinks</h4>
	<p>It looks like you're missing native WordPress permalinks for some of your <?php echo $enmsemessagetp; ?> (this feature was added in v2.2). Click the button below to take care of this.</p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&seupdate=3&seimport=0&seplugin=0" method="post">
		<input name="Submit" type="submit" class="button" value="Update Permalinks" tabindex="35" />
	</form>
	<?php } ?>

	<?php include ('secredits.php'); ?>	
</div>
<?php  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>