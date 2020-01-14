<?php 

			
			// Make Sermon Manager Series Types
			$enmse_newst = array(
				'series_type_id' => '400', 
				'name' => 'Sermon Manager Content', 
				'description' => 'Content imported from the Sermon Manager plugin on this site.'
			);
			$wpdb->get_results("SELECT series_type_id FROM " . $wpdb->prefix . "se_series_types WHERE series_type_id = 400");
			if($wpdb->num_rows == 0) {
				$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newst );
			}
			$enmse_newsttwo = array(
				'series_type_id' => '401', 
				'name' => 'Sermon Manager Services', 
				'description' => 'Messages imported from Sermon Manager according to service time.'
			);

			$wpdb->get_results("SELECT series_type_id FROM " . $wpdb->prefix . "se_series_types WHERE series_type_id = 401");
			if($wpdb->num_rows == 0) { 
				$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newsttwo );
			}

			// Import Sermon Manager Series
			$enmse_findsbseriessql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_sermon_series' GROUP BY term_taxonomy_id"; 
			$enmse_sbseries = $wpdb->get_results( $enmse_findsbseriessql );

			$sbscount = 0;
			if ( !empty($enmse_sbseries) ) {
				foreach ( $enmse_sbseries as $s ) {
					$id = $s->term_id+$poffset;
					$title = $s->name;
					$description = $s->description;
					$enmse_newsbs = array(
						'series_id' => $id, 
						's_title' => $title,
						's_description' => $description,
						'archived' => 0
					);
					$wpdb->get_results("SELECT series_id FROM " . $wpdb->prefix . "se_series WHERE series_id = " . $id);
					if($wpdb->num_rows == 0) {  
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newsbs );

						$enmse_newsbst = array(
							'series_id' => $id, 
							'series_type_id' => '400'
						); 
 
						$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newsbst );
						$sbscount = $sbscount+1;
						
					}
					
				}
			}

			if ( $sbscount == 1 ) {
				$enmse_messages[] = "<strong>" . $sbscount . " Sermon Manager Series</strong> was imported.";
			} elseif ( $sbscount > 1 ) {
				$enmse_messages[] = "<strong>" . $sbscount . " Sermon Manager Series</strong> were imported.";
			}

			// Import Sermon Manager Sermon Series Matches
			$enmse_findsmseriesmsql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_sermon_series' AND object_id IS NOT NULL"; 
			$enmse_smseriesms = $wpdb->get_results( $enmse_findsmseriesmsql );

			if ( !empty($enmse_smseriesms) ) {
				foreach ( $enmse_smseriesms as $sm ) {
					$series_id = $sm->term_id+$poffset;
					$message_id = $sm->object_id+$poffset;

					$enmse_newsbsm = array(
						'series_id' => $series_id, 
						'message_id' => $message_id
					); 
					$wpdb->get_results("SELECT series_id FROM " . $wpdb->prefix . "se_series_message_matches WHERE series_id = " . $series_id . " AND message_id = " . $message_id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newsbsm );
					}
				}
			}


			// Import Sermon Manager Topics
			$enmse_findsmtopicssql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_sermon_topics' GROUP BY term_taxonomy_id"; 
			$enmse_smtopics = $wpdb->get_results( $enmse_findsmtopicssql );

			$smtcount = 0;
			if ( !empty($enmse_smtopics) ) {
				foreach ( $enmse_smtopics as $t ) {
					$id = $t->term_id+$poffset;
					$title = $t->name;
					$enmse_newsmt = array(
						'topic_id' => $id, 
						'name' => $title
					);
					$wpdb->get_results("SELECT topic_id FROM " . $wpdb->prefix . "se_topics WHERE topic_id = " . $id);
					if($wpdb->num_rows == 0) {  
						$wpdb->insert( $wpdb->prefix . "se_topics", $enmse_newsmt );
						$smtcount = $smtcount+1;
					}
					
				}
			}

			if ( $smtcount == 1 ) {
				$enmse_messages[] = "<strong>" . $smtcount . " Sermon Manager Topic</strong> was imported.";
			} elseif ( $smtcount > 1 ) {
				$enmse_messages[] = "<strong>" . $smtcount . " Sermon Manager Topics</strong> were imported.";
			}

			// Import Sermon Browser Sermon Topic Matches (Topics)
			$enmse_findsmtopicsmsql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_sermon_topics' AND object_id IS NOT NULL"; 
			$enmse_smtopicsms = $wpdb->get_results( $enmse_findsmtopicsmsql );

			if ( !empty($enmse_smtopicsms) ) {
				foreach ( $enmse_smtopicsms as $t ) {
					$topic_id = $t->term_id+$poffset;
					$message_id = $t->object_id+$poffset;

					$enmse_newsbtm = array(
						'topic_id' => $topic_id, 
						'message_id' => $message_id
					); 
					$wpdb->get_results("SELECT topic_id FROM " . $wpdb->prefix . "se_message_topic_matches WHERE topic_id = " . $topic_id . " AND message_id = " . $message_id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_message_topic_matches", $enmse_newsbtm );
					}
				}
			}


			// Import Sermon Manager Services
			$enmse_findsmservicessql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_service_type' GROUP BY term_taxonomy_id"; 
			$enmse_smservices = $wpdb->get_results( $enmse_findsmservicessql );

			$smsvcount = 0;
			if ( !empty($enmse_smservices) ) {
				foreach ( $enmse_smservices as $sv ) {
					$id = $sv->term_id+$poffset+200;
					$title = $sv->name;
					$description = $s->description;
					$enmse_newsmsv = array(
						'series_id' => $id, 
						's_title' => $title,
						's_description' => $description,
						'archived' => 0
					);
					$wpdb->get_results("SELECT series_id FROM " . $wpdb->prefix . "se_series WHERE series_id = " . $id);
					if($wpdb->num_rows == 0) {  
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newsmsv );

						$enmse_newsmsvt = array(
							'series_id' => $id, 
							'series_type_id' => '401'
						); 

						$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newsmsvt );
						$smsvcount = $smsvcount+1;

					}

					
				}
			}

			if ( $smsvcount == 1 ) {
				$enmse_messages[] = "<strong>" . $smsvcount . " Sermon Manager Service</strong> was imported (as a Series).";
			} elseif ( $smsvcount > 1 ) {
				$enmse_messages[] = "<strong>" . $smsvcount . " Sermon Manager Services</strong> were imported (as Series).";
			}

			// Import Sermon Manager Sermon Service Matches
			$enmse_findsmservicemsql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_service_type' AND object_id IS NOT NULL"; 
			$enmse_smservicems = $wpdb->get_results( $enmse_findsmservicemsql );

			if ( !empty($enmse_smservicems) ) {
				foreach ( $enmse_smservicems as $svm ) {
					$series_id = $svm->term_id+$poffset+200;
					$message_id = $svm->object_id+$poffset;

					$enmse_newsbsvm = array(
						'series_id' => $series_id, 
						'message_id' => $message_id
					); 
					$wpdb->get_results("SELECT series_id FROM " . $wpdb->prefix . "se_series_message_matches WHERE series_id = " . $series_id . " AND message_id = " . $message_id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newsbsvm );
					}
				}
			}

			// Import Sermon Manager Preachers
			$enmse_findsmpreacherssql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_preacher' GROUP BY term_taxonomy_id"; 
			$enmse_smpreachers = $wpdb->get_results( $enmse_findsmpreacherssql );

			$smspcount = 0;
			if ( !empty($enmse_smpreachers) ) {
				foreach ( $enmse_smpreachers as $p ) {
					$id = $p->term_id+$poffset;
					$title = $p->name;
					$enmse_newsmsp = array(
						'speaker_id' => $id, 
						'last_name' => $title
					);
					$wpdb->get_results("SELECT speaker_id FROM " . $wpdb->prefix . "se_speakers WHERE speaker_id = " . $id);
					if($wpdb->num_rows == 0) {  
						$wpdb->insert( $wpdb->prefix . "se_speakers", $enmse_newsmsp );
						$smspcount = $smspcount+1;
					}
					
				}
			}

			if ( $smspcount == 1 ) {
				$enmse_messages[] = "<strong>" . $smspcount . " Sermon Manager Preacher</strong> was imported (as a Speaker).";
			} elseif ( $smspcount > 1 ) {
				$enmse_messages[] = "<strong>" . $smspcount . " Sermon Manager Preachers</strong> were imported (as Speakers).";
			}

			// Import Sermon Manager Sermon Preacher Matches
			$enmse_findsmspeakermsql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_preacher' AND object_id IS NOT NULL"; 
			$enmse_smspeakerms = $wpdb->get_results( $enmse_findsmspeakermsql );

			if ( !empty($enmse_smspeakerms) ) {
				foreach ( $enmse_smspeakerms as $spm ) {
					$speaker_id = $spm->term_id+$poffset;
					$message_id = $spm->object_id+$poffset;

					$enmse_newsbspm = array(
						'speaker_id' => $speaker_id, 
						'message_id' => $message_id
					); 
					$wpdb->get_results("SELECT speaker_id FROM " . $wpdb->prefix . "se_message_speaker_matches WHERE speaker_id = " . $speaker_id . " AND message_id = " . $message_id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_message_speaker_matches", $enmse_newsbspm );
					}
				}
			}


			// Import Sermon Browser Messages
			$enmse_findsmsermonssql = "SELECT * FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'wpfc_sermon' AND post_status = 'publish'";
			$enmse_smsermons = $wpdb->get_results( $enmse_findsmsermonssql );

			$smsncount = 0;
			if ( !empty($enmse_smsermons) ) {
				foreach ( $enmse_smsermons as $sn ) {
					$id = $sn->ID+$poffset;
					$title = $sn->post_title;

					// Get Sermon Details
					$enmse_preparredsmsndsql = "SELECT * FROM " . $wpdb->prefix . "postmeta" . " WHERE post_id = %d"; 
					$enmse_smsndsql = $wpdb->prepare( $enmse_preparredsmsndsql, $sn->ID );
					$enmse_smsnd = $wpdb->get_results( $enmse_smsndsql );


					$audio_url = 0;
					$video_embed_url = 0;
					$embed_code = 0;
					$bulletin = "";
					$featured_file = "";
					$featured_title = "";
					$message_image = "";
					$findimage = null;
					$viewcount = 0;
					foreach ( $enmse_smsnd as $d) {
						if ( $d->meta_key == "sermon_date" ) { // Date
							$date = date("Y-m-d", $d->meta_value);
						} elseif ( $d->meta_key == "bible_passage" ) { // Bible Verse(s)
							$passage = $d->meta_value;
						} elseif ( $d->meta_key == "sermon_description" ) { // Description
							$description = strip_tags($d->meta_value);
						} elseif ( $d->meta_key == "sermon_audio" ) { // Audio Link
							$audio_url = $d->meta_value;
						} elseif ( $d->meta_key == "sermon_video_link" ) { // Video Link
							$video_embed_url = $d->meta_value;
						} elseif ( $d->meta_key == "sermon_video" ) { // Video Embed
							$embed_code = $d->meta_value;
						} elseif ( $d->meta_key == "sermon_notes" ) { // Sermon Notes
							if ( $d->meta_value != '' ) {
								$featured_title = "Sermon Notes";
								$featured_file = $d->meta_value;
							}
						} elseif ( $d->meta_key == "sermon_bulletin" ) { // Bulletin
							if ( $d->meta_value != '' ) {
								$bulletin = $d->meta_value;
							}
						} elseif ( $d->meta_key == "_wpfc_sermon_duration" ) { // Audio Length
							$message_length = $d->meta_value;
						} elseif ( $d->meta_key == "_thumbnail_id" ) { // Image ID
							if ( $d->meta_value != '' ) {
								$findimage = $d->meta_value; 
							}
						} elseif ( $d->meta_key == "Views" ) { // View Count
							$viewcount = $d->meta_value; 
						}
					}

					$uploaddir = wp_upload_dir();
					if ( $findimage != null ) {
						$enmse_preparredfindimagesql = "SELECT * FROM " . $wpdb->prefix . "postmeta" . " WHERE post_id = %d"; 
						$enmse_findimagesql = $wpdb->prepare( $enmse_preparredfindimagesql, $findimage );
						$enmse_findimage = $wpdb->get_results( $enmse_findimagesql );

						foreach ( $enmse_findimage as $image) {
							if ( $image->meta_key == "_wp_attached_file" ) {
								$message_image = $uploaddir['baseurl'] . "/" . $image->meta_value;
							}			
						}
					}
					

					$enmse_message = array( // Add Message to DB
						'message_id' => $id,
						'title' => $title, 
						'date' => $date,
						'alternate_date' => '0000-00-00',
						'embed_code' => $embed_code,
						'audio_url' => $audio_url,
						'message_length' => $message_length,
						'video_url' => 0,
						'alternate_embed' => 0,
						'video_embed_url' => $video_embed_url,
						'additional_video_embed_url' => 0,
						'description' => $description,
						'message_thumbnail' => $message_image,
						'file_name' => $featured_title,
						'file_url' => $featured_file,
						'file_new_window' => '1',
						'audio_count' => $viewcount,
						'video_count' => 0,
						'alternate_count' => 0
						); 
					$wpdb->get_results("SELECT message_id FROM " . $wpdb->prefix . "se_messages WHERE message_id = " . $id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_messages", $enmse_message );
						$smsncount = $smsncount + 1;

						// Add Files
						if ( $featured_file != "" ) {
							$enmse_file = array(
								'file_name' => $featured_title,
								'file_url' => $featured_file, 
								'file_new_window' => '1',
								'featured' => '1'
								); 

							$wpdb->insert( $wpdb->prefix . "se_files", $enmse_file );
							$enmse_new_file_id = $wpdb->insert_id; 

							$enmse_newsbmfm = array(
								'file_id' => $enmse_new_file_id, 
								'message_id' => $id
							); 
							$wpdb->insert( $wpdb->prefix . "se_message_file_matches", $enmse_newsbmfm );	
						}

						if ( $bulletin != "" ) {
							$enmse_bulletin = array(
								'file_name' => 'Bulletin',
								'file_url' => $bulletin, 
								'file_new_window' => '1',
								'featured' => '0'
								); 

							$wpdb->insert( $wpdb->prefix . "se_files", $enmse_bulletin );
							$enmse_new_bulletin_id = $wpdb->insert_id; 

							$enmse_newsmmbmm = array(
								'file_id' => $enmse_new_bulletin_id, 
								'message_id' => $id
							); 
							$wpdb->insert( $wpdb->prefix . "se_message_file_matches", $enmse_newsmmbmm );	
						}


						// Add Verses
						preg_match_all('/(?<!\d )[a-zA-Z]+( (\d+)(:\d+)?([\-–]\d+)?(, \d+[\-–]\d+)?)?/', $passage, $result, PREG_PATTERN_ORDER);

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
								} else {
									$start_verse = 0;
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
										'message_id' => $id, 
										'scripture_id' => $enmse_new_scripture_id
									); 
									$wpdb->insert( $wpdb->prefix . "se_scripture_message_matches", $enmse_newscmm );

									$enmse_new_mvalues = array( 'focus_scripture' => $passage ); 
									$enmse_mwhere = array( 'message_id' => $id ); 
									$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

									$enmse_preparreddscmsql = "SELECT bm_match_id FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id = %d AND book_id = %d GROUP BY bm_match_id ORDER BY bm_match_id ASC"; 
									$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $id, $start_book );
									$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
									$enmse_countrec = $wpdb->num_rows;

									if ( $enmse_countrec > 1 || empty($enmse_dmscriptures) ) {
										$enmse_newbmm = array(
											'message_id' => $id, 
											'book_id' => $start_book
										); 
										$wpdb->insert( $wpdb->prefix . "se_book_message_matches", $enmse_newbmm );
									}


								}

		
							}

						}

						preg_match_all('/\d+ (\w+)( (\d+)(:\d+)?([\-–]\d+)?(, \d+[\-–]\d+)?)?/', $passage, $secondresult, PREG_PATTERN_ORDER);

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
								} elseif (preg_match('/(2+\s+Peter|2 peter|2 PET|2 Pet|2 pet)+/i', $verse)) {
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
								} else {
									$start_verse = 0;
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
										'message_id' => $id, 
										'scripture_id' => $enmse_new_scripture_id
									); 
									$wpdb->insert( $wpdb->prefix . "se_scripture_message_matches", $enmse_newscmm );

									$enmse_new_mvalues = array( 'focus_scripture' => $passage ); 
									$enmse_mwhere = array( 'message_id' => $id ); 
									$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

									$enmse_preparreddscmsql = "SELECT bm_match_id FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id = %d AND book_id = %d GROUP BY bm_match_id ORDER BY bm_match_id ASC"; 
									$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $id, $start_book );
									$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
									$enmse_countrec = $wpdb->num_rows;

									if ( $enmse_countrec > 1 || empty($enmse_dmscriptures) ) {
										$enmse_newbmm = array(
											'message_id' => $id, 
											'book_id' => $start_book
										); 
										$wpdb->insert( $wpdb->prefix . "se_book_message_matches", $enmse_newbmm );
									}


								}

		
							}

						}




					}

				}
			}

			if ( $smsncount == 1 ) {
				$enmse_messages[] = "<strong>" . $smsncount . " Sermon Manager Sermon</strong> was imported (as a Message).";
			} elseif ( $smsncount > 1 ) {
				$enmse_messages[] = "<strong>" . $smsncount . " Sermon Manager Sermons</strong> were imported (as Messages).";
			}


			// Correct Series Dates 

			$enmse_findseriessql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_sermon_series' GROUP BY term_taxonomy_id"; 
			$enmse_series = $wpdb->get_results( $enmse_findseriessql );

			if ( !empty($enmse_series) ) {
				foreach ($enmse_series as $s) {

					$enmse_smpreparredsql = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d GROUP BY title ORDER BY date ASC LIMIT 1"; 		
					$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $s->term_id+$poffset );
					$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );

					if ( !empty($enmse_singlemessage) ) {
						$enmse_new_mvalues = array( 'start_date' => $enmse_singlemessage->date ); 
						$enmse_mwhere = array( 'series_id' => $s->term_id+$poffset ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_mvalues, $enmse_mwhere );
					} else {
						$enmse_new_mvalues = array( 'start_date' => current_time( 'mysql' ) ); 
						$enmse_mwhere = array( 'series_id' => $s->term_id+$poffset ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_mvalues, $enmse_mwhere );
					}

				}
			}

			$enmse_findservicessql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'wpfc_service_type' GROUP BY term_taxonomy_id";
			$enmse_services = $wpdb->get_results( $enmse_findservicessql );

			if ( !empty($enmse_services) ) {
				foreach ($enmse_services as $s) {

					$enmse_smpreparredsql = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d GROUP BY title ORDER BY date ASC LIMIT 1"; 		
					$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $s->term_id+$poffset );
					$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );

					if ( !empty($enmse_singlemessage) ) {
						$enmse_new_mvalues = array( 'start_date' => $enmse_singlemessage->date ); 
						$enmse_mwhere = array( 'series_id' => $s->term_id+$poffset+200 ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_mvalues, $enmse_mwhere );
					} else {
						$enmse_new_mvalues = array( 'start_date' => current_time( 'mysql' ) ); 
						$enmse_mwhere = array( 'series_id' => $s->term_id+$poffset+200 ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_mvalues, $enmse_mwhere );
					}

				}
			}

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

			if ( empty($enmse_messages) ) {
				$enmse_messages[] = "The importer ran sucessfully, but it looks like you've already imported everything from Sermon Manager before. Good job!";
			}


?>