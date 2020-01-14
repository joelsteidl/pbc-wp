<?php  /* Series Engine - Import Content from the Church Content Plugin Plugin */


			// Make Church Content Plugin Series Types
			$enmse_newst = array(
				'series_type_id' => '600', 
				'name' => 'Church Content Plugin Content', 
				'description' => 'Content imported from the Church Content Plugin on this site.'
			);
			$wpdb->get_results("SELECT series_type_id FROM " . $wpdb->prefix . "se_series_types WHERE series_type_id = 600");
			if($wpdb->num_rows == 0) {
				$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newst );
			}

			// Import Church Content Plugin Series
			$enmse_findsbseriessql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'ctc_sermon_series' GROUP BY term_taxonomy_id"; 
			$enmse_ccseries = $wpdb->get_results( $enmse_findsbseriessql );

			$ccscount = 0;
			if ( !empty($enmse_ccseries) ) {
				foreach ( $enmse_ccseries as $s ) {
					$id = $s->term_id+$poffset;
					$title = $s->name;
					$description = $s->description;
					$enmse_newccs = array(
						'series_id' => $id, 
						's_title' => $title,
						's_description' => $description,
						'archived' => 0
					);
					$wpdb->get_results("SELECT series_id FROM " . $wpdb->prefix . "se_series WHERE series_id = " . $id);
					if($wpdb->num_rows == 0) {  
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newccs );

						$enmse_newccst = array(
							'series_id' => $id, 
							'series_type_id' => '600'
						); 
 
						$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newccst );
						$ccscount = $ccscount+1;
						
					}
					
				}
			}

			if ( $ccscount == 1 ) {
				$enmse_messages[] = "<strong>" . $ccscount . " Church Content Plugin Series</strong> was imported.";
			} elseif ( $ccscount > 1 ) {
				$enmse_messages[] = "<strong>" . $ccscount . " Church Content Plugin Series</strong> were imported.";
			}

			

			// Import Church Content Plugin Sermon Series Matches
			$enmse_findccseriesmsql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'ctc_sermon_series' AND object_id IS NOT NULL"; 
			$enmse_ccseriesms = $wpdb->get_results( $enmse_findccseriesmsql );

			if ( !empty($enmse_ccseriesms) ) {
				foreach ( $enmse_ccseriesms as $sm ) {
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



			// Import Church Content Plugin Topics
			$enmse_findcctopicssql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'ctc_sermon_topic' GROUP BY term_taxonomy_id"; 
			$enmse_cctopics = $wpdb->get_results( $enmse_findcctopicssql );

			$smtcount = 0;
			if ( !empty($enmse_cctopics) ) {
				foreach ( $enmse_cctopics as $t ) {
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
				$enmse_messages[] = "<strong>" . $smtcount . " Church Content Plugin Topic</strong> was imported.";
			} elseif ( $smtcount > 1 ) {
				$enmse_messages[] = "<strong>" . $smtcount . " Church Content Plugin Topics</strong> were imported.";
			}

			// Import Church Content Plugin Sermon Topic Matches (Topics)
			$enmse_findcctopicsmsql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'ctc_sermon_topic' AND object_id IS NOT NULL"; 
			$enmse_cctopicsms = $wpdb->get_results( $enmse_findcctopicsmsql );

			if ( !empty($enmse_cctopicsms) ) {
				foreach ( $enmse_cctopicsms as $t ) {
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



			// Import Church Content Plugin Speakers
			$enmse_findccpreacherssql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'ctc_sermon_speaker' GROUP BY term_taxonomy_id"; 
			$enmse_ccpreachers = $wpdb->get_results( $enmse_findccpreacherssql );

			$smspcount = 0;
			if ( !empty($enmse_ccpreachers) ) {
				foreach ( $enmse_ccpreachers as $p ) {
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
				$enmse_messages[] = "<strong>" . $smspcount . " Church Content Plugin Speaker</strong> was imported (as a Speaker).";
			} elseif ( $smspcount > 1 ) {
				$enmse_messages[] = "<strong>" . $smspcount . " Church Content Plugin Speakers</strong> were imported (as Speakers).";
			}

			// Import Church Content Plugin Sermon Speaker Matches
			$enmse_findccspeakermsql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'ctc_sermon_speaker' AND object_id IS NOT NULL"; 
			$enmse_ccspeakerms = $wpdb->get_results( $enmse_findccspeakermsql );

			if ( !empty($enmse_ccspeakerms) ) {
				foreach ( $enmse_ccspeakerms as $spm ) {
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

			// Import Church Content Plugin Messages
			$enmse_findccsermonssql = "SELECT * FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'ctc_sermon' AND post_status = 'publish'";
			$enmse_ccsermons = $wpdb->get_results( $enmse_findccsermonssql );

			$smsncount = 0;

			function enmse_vimeo($link){
				
				$regexstr = '~
					(?:<iframe [^>]*src=")?		
					(?:							
						https?:\/\/				
						(?:[\w]+\.)*			
						vimeo\.com				
						(?:[\/\w]*\/videos?)?	
						\/						
						([0-9]+)				
						[^\s]*					
					)							
					"?							
					(?:[^>]*></iframe>)?		
					(?:<p>.*</p>)?		        
					~ix';
				
				preg_match($regexstr, $link, $matches);
				
				return $matches[1];
				
			}

			function enmse_youtube($link){
				
				$regexstr = '~
					(?:				 				
						(?:<iframe [^>]*src=")?	 	
						|(?:				 		
							(?:<object .*>)?		
							(?:<param .*</param>)*  
							(?:<embed [^>]*src=")?  
						)?				 			
					)?				 				
					(?:				 				
						https?:\/\/		         	
						(?:[\w]+\.)*		        
						(?:               	        
						youtu\.be/      	        
						| youtube\.com		 		
						| youtube-nocookie\.com	 	
						)				 			
						(?:\S*[^\w\-\s])?       	
						([\w\-]{11})		        
						[^\s]*			 			
					)				 				
					"?				 				
					(?:[^>]*>)?			 			
					(?:				 				
						</iframe>		         	
						|</embed></object>	        
					)?				 				
					~ix';
				
				preg_match($regexstr, $link, $matches);
				
				return $matches[1];
				
			}


			if ( !empty($enmse_ccsermons) ) {
				foreach ( $enmse_ccsermons as $sn ) {
					$id = $sn->ID+$poffset;
					$title = $sn->post_title;
					$date = date("Y-m-d", strtotime($sn->post_date));
					$description = strip_tags($sn->post_content);

					// Get Sermon Details
					$enmse_preparredsmsndsql = "SELECT * FROM " . $wpdb->prefix . "postmeta" . " WHERE post_id = %d"; 
					$enmse_ccsndsql = $wpdb->prepare( $enmse_preparredsmsndsql, $sn->ID );
					$enmse_ccsnd = $wpdb->get_results( $enmse_ccsndsql );


					$audio_url = 0;
					$video_embed_url = 0;
					$embed_code = 0;
					$featured_file = "";
					$featured_title = "";
					$message_image = "";
					$findimage = null;
					$viewcount = 0; 
					foreach ( $enmse_ccsnd as $d) { 
						if ( $d->meta_key == "_ctc_sermon_audio" ) { // Audio 
							if (preg_match('/(\iframe)+/i', $d->meta_value)) {
								$audio_url = null;
							} elseif (preg_match('/(\.mp3|\.aac|\.m4a|\.wma)+/i', $d->meta_value)) { 
								if (preg_match('/=["\']?([^"\'>]+)["\']?/', $d->meta_value)) {
									preg_match('/=["\']?([^"\'>]+)["\']?/', $d->meta_value, $match);
									$finalurl = parse_url($match[1]);
									$audio_url = $finalurl['scheme'].'://'.$finalurl['host'] . $finalurl["path"];
								} else {
									$audio_url = $d->meta_value;
								}
							} else {
								$audio_url = null;
							}
						} elseif ( $d->meta_key == "_ctc_sermon_video" ) { // Video Link
							if (preg_match('/(\iframe)+/i', $d->meta_value)) {
								$embed_code = $d->meta_value;
							} elseif (preg_match('/(faceboo)\w+/', $d->meta_value)) { // Facebook 
								$embed_code = '<div id="fb-root"></div><script async="1" defer="1" crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script><div class="fb-video" data-href="' . $d->meta_value . '"></div>';
							} elseif (preg_match('/(youtube\.co|youtu\.b)\w+/', $d->meta_value)) { // YouTube 
								$videoid = enmse_youtube($d->meta_value);
								$embed_code = '<iframe src="https://www.youtube.com/embed/' . $videoid . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
							} elseif (preg_match('/(vimeo\.co)\w+/', $d->meta_value)) { // Vimeo 
								$videoid = enmse_vimeo($d->meta_value);
								$embed_code = '<iframe src="https://player.vimeo.com/video/' . $videoid . '?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
							} elseif (preg_match('/(\.mp4|\.m4v|\.mov|\.wmv)+/i', $d->meta_value)) { // video 
								if (preg_match('/=["\']?([^"\'>]+)["\']?/', $d->meta_value)) {
									preg_match('/=["\']?([^"\'>]+)["\']?/', $d->meta_value, $match);
									$finalurl = parse_url($match[1]);
									$video_embed_url = $finalurl['scheme'].'://'.$finalurl['host'] . $finalurl["path"];
								} else {
									$video_embed_url = $d->meta_value;
								}
							}
						} elseif ( $d->meta_key == "_ctc_sermon_pdf" ) { // PDF
							if ( $d->meta_value != '' ) {
								$featured_title = "PDF";
								$featured_file = $d->meta_value;
							}
						} elseif ( $d->meta_key == "_thumbnail_id" ) { // Image ID
							if ( $d->meta_value != '' ) {
								$findimage = $d->meta_value; 
							}
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

					}

				}
			}

			if ( $smsncount == 1 ) {
				$enmse_messages[] = "<strong>" . $smsncount . " Church Content Plugin Sermon</strong> was imported (as a Message).";
			} elseif ( $smsncount > 1 ) {
				$enmse_messages[] = "<strong>" . $smsncount . " Church Content Plugin Sermons</strong> were imported (as Messages).";
			}


			// Correct Series Dates 

			$enmse_findseriessql = "SELECT * FROM " . $wpdb->prefix . "term_taxonomy" . " LEFT JOIN " . $wpdb->prefix . "term_relationships" . " USING (term_taxonomy_id) LEFT JOIN " . $wpdb->prefix . "terms" . " USING (term_id) WHERE taxonomy = 'ctc_sermon_series' GROUP BY term_taxonomy_id"; 
			$enmse_series = $wpdb->get_results( $enmse_findseriessql );

			if ( !empty($enmse_series) ) {
				foreach ($enmse_series as $s) {

					$enmse_ccpreparredsql = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d GROUP BY title ORDER BY date ASC LIMIT 1"; 		
					$enmse_findthemessage = $wpdb->prepare( $enmse_ccpreparredsql, $s->term_id+$poffset );
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
				$enmse_messages[] = "The importer ran sucessfully, but it looks like you've already imported everything from the Church Content Plugin before. Good job!";
			}


?>