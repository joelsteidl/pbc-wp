<?php /* ----- Series Engine - Add, edit and remove Messages ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		
		$enmse_dateformat = get_option( 'date_format' ); 
		$enmse_options = get_option( 'enm_seriesengine_options' ); 
		if ( isset($enmse_options['newgraphicwidth']) ) { // Find the width of the series graphics
			$enmse_embedwidth = $enmse_options['newgraphicwidth'];
		} else {
			$enmse_embedwidth = 1000;
		}

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

		if ( isset($enmse_options['bookt']) ) { // Find Message Title
			$enmsebookt = $enmse_options['bookt'];
		} else {
			$enmsebookt = "Book";
		}

		if ( isset($enmse_options['booktp']) ) { // Find Message Title (plural)
			$enmsebooktp = $enmse_options['booktp'];
		} else {
			$enmsebooktp = "Books";
		}

		if ( isset($enmse_options['id3']) ) { // Get podcast details from files
			$enmseid3 = $enmse_options['id3'];
		} else {
			$enmseid3 = 1;
		}

		if ( isset($enmse_options['topicsort']) ) { // Sort Topics Manually?
			$enmsetopicsort = $enmse_options['topicsort'];
		} else {
			$enmsetopicsort = 1;
		}

		if ( isset($enmse_options['deftrans']) ) { // Sort Topics Manually?
			$deftrans = $enmse_options['deftrans'];
		} else {
			$deftrans = 59;
		}

		if ( isset($enmse_options['bibleoption']) ) { // Is Scripture Enabled?
			$bibleoption = $enmse_options['bibleoption'];
		} else {
			$bibleoption = 0;
		}

		if ( isset($enmse_options['permalinkslug']) ) { // Permalink Slug
			$permalinkslug = $enmse_options['permalinkslug'];
		} else {
			$permalinkslug = "messages";
		}

		if ( isset($enmse_options['default_permalink_prefix']) ) { // Permalink Prefix
			$default_permalink_prefix = $enmse_options['default_permalink_prefix'];
		} else {
			$default_permalink_prefix = 1;
		}

		if ( isset($enmse_options['default_permalink_speaker']) ) { // Permalink Prefix
			$default_permalink_speaker = $enmse_options['default_permalink_speaker'];
		} else {
			$default_permalink_speaker = 1;
		}

		if ( isset($enmse_options['default_podcast_series']) ) { // Podcast Series in Titles
			$default_podcast_series = $enmse_options['default_podcast_series'];
		} else {
			$default_podcast_series = 1;
		}

		if ( isset($enmse_options['language']) ) { // Find the Language
			$enmse_language = $enmse_options['language'];
		} else {
			$enmse_language = 1;
		}

		if ( $enmse_language == 10 ) { 
			include(dirname(__FILE__) . '/../lang/fre_bible_books.php');
			$enmse_from =  "de";
		} elseif ( $enmse_language == 9 ) { 
			include(dirname(__FILE__) . '/../lang/rus_bible_books.php');
			$enmse_from =  "когда";
		} elseif ( $enmse_language == 8 ) { 
			include(dirname(__FILE__) . '/../lang/jap_bible_books.php');
			$enmse_from =  "いつ";
		} elseif ( $enmse_language == 7 ) { 
			include(dirname(__FILE__) . '/../lang/dut_bible_books.php');
			$enmse_from =  "wanneer";
		} elseif ( $enmse_language == 6 ) { 
			include(dirname(__FILE__) . '/../lang/chint_bible_books.php');
			$enmse_from =  "來自";
		} elseif ( $enmse_language == 5 ) { 
			include(dirname(__FILE__) . '/../lang/chins_bible_books.php');
			$enmse_from =  "什么时候";
		} elseif ( $enmse_language == 4 ) { 
			include(dirname(__FILE__) . '/../lang/turk_bible_books.php');
			$enmse_from =  "itibaren";
		} elseif ( $enmse_language == 3 ) { 
			include(dirname(__FILE__) . '/../lang/ger_bible_books.php');
			$enmse_from =  "von";
		} elseif ( $enmse_language == 2 ) { 
			include(dirname(__FILE__) . '/../lang/spa_bible_books.php');
			$enmse_from =  "de";
		} else {
			include(dirname(__FILE__) . '/../lang/eng_bible_books.php');
			$enmse_from =  "from";
		}

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
		
		$enmse_errors = array(); //Set up errors array
		$enmse_messages = array(); //Set up messages array
		
		if ( $_POST && isset($_GET['enmse_did']) ) { // If deleting a topic
			$enmse_deleted_id = strip_tags($_POST['message_delete']);

			$enmse_findthedmessagesql = "SELECT wp_post_id FROM " . $wpdb->prefix . "se_messages" . " WHERE message_id = %d"; 
			$enmse_findthedmessage = $wpdb->prepare( $enmse_findthedmessagesql, $enmse_deleted_id );
			$enmse_single = $wpdb->get_row( $enmse_findthedmessage, OBJECT );

			$enmse_post_id = $enmse_single->wp_post_id;

			$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_messages" . " WHERE message_id=%d";
			$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_deleted_id ); 
			$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
			
			$enmse_smdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_series_message_matches" . " WHERE message_id=%d";
			$enmse_smdelete_query = $wpdb->prepare( $enmse_smdelete_query_preparred, $enmse_deleted_id ); 
			$enmse_smdeleted = $wpdb->query( $enmse_smdelete_query );
			
			$enmse_stdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_message_topic_matches" . " WHERE message_id=%d";
			$enmse_stdelete_query = $wpdb->prepare( $enmse_stdelete_query_preparred, $enmse_deleted_id ); 
			$enmse_stdeleted = $wpdb->query( $enmse_stdelete_query );
			
			$enmse_sspdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_message_speaker_matches" . " WHERE message_id=%d";
			$enmse_sspdelete_query = $wpdb->prepare( $enmse_sspdelete_query_preparred, $enmse_deleted_id ); 
			$enmse_sspdeleted = $wpdb->query( $enmse_sspdelete_query );

			$enmse_cptdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "posts" . " WHERE ID=%d";
			$enmse_cptdelete_query = $wpdb->prepare( $enmse_cptdelete_query_preparred, $enmse_post_id ); 
			$enmse_cptdeleted = $wpdb->query( $enmse_cptdelete_query );

			$enmse_ctpmdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "postmeta" . " WHERE meta_key = 'enmse_mid' AND meta_value=%d";
			$enmse_ctpmdelete_query = $wpdb->prepare( $enmse_ctpmdelete_query_preparred, $enmse_deleted_id ); 
			$enmse_ctpmdeleted = $wpdb->query( $enmse_ctpmdelete_query );
			
			$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d GROUP BY file_name ORDER BY file_name ASC"; 
			$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_deleted_id );
			$enmse_dfiles = $wpdb->get_results( $enmse_fsql );
			
			foreach ($enmse_dfiles as $enmse_f) {
				$enmse_nfid = $enmse_f->file_id;
				$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_files" . "  WHERE file_id = %d";
				$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_nfid ); 
				$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
				
				$matchid = $enmse_f->mf_match_id;
				$enmse_deletetwo_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_message_file_matches" . "  WHERE mf_match_id=%d";
				$enmse_deletetwo_query = $wpdb->prepare( $enmse_deletetwo_query_preparred, $matchid ); 
				$enmse_deletedtwo = $wpdb->query( $enmse_deletetwo_query );
			}

			$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
			$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_deleted_id );
			$enmse_dscriptures = $wpdb->get_results( $enmse_scsql  );
			
			foreach ($enmse_dscriptures as $enmse_sc) {
				$enmse_nscid = $enmse_sc->scripture_id;
				$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_scriptures" . "  WHERE scripture_id = %d";
				$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_nscid ); 
				$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
				
				$matchid = $enmse_sc->scm_match_id;
				$enmse_deletetwo_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_scripture_message_matches" . "  WHERE scm_match_id=%d";
				$enmse_deletetwo_query = $wpdb->prepare( $enmse_deletetwo_query_preparred, $matchid ); 
				$enmse_deletedtwo = $wpdb->query( $enmse_deletetwo_query );
			}
			
			$enmse_messages[] = "The message was successfully deleted.";
		}
		
		if ( isset($_GET['enmse_action']) ) {
			$enmse_single_created = null;

			if ( $_GET['enmse_action'] == 'edit' ) { // Edit Message
				$enmse_userdetails = wp_get_current_user(); 
				if ( $_POST ) {
					if (empty($_POST['message_title'])) { 
						$enmse_errors[] = '- You must name the new message.';
					} else {
						$enmse_title = strip_tags($_POST['message_title']);
						$enmse_cpt_title = stripslashes(strip_tags($_POST['message_title']));
					}
					
					if (($_POST['message_speaker'] == 0) || ($_POST['message_speaker'] == 'n')) {  
						$enmse_errors[] = '- You must pick a speaker for the message.';
					} else {
						$enmse_speaker = strip_tags($_POST['message_speaker']);
					}
					
					if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['message_date'])) { 
						$enmse_date = strip_tags($_POST['message_date']);
					} else {
						$enmse_errors[] = '- You must provide a valid message date.';
					};
					
					if ( $_POST['message_alternate_date'] != NULL ) {
						if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['message_alternate_date'])) { 
							$enmse_alternate_date = strip_tags($_POST['message_alternate_date']);
						} else {
							$enmse_errors[] = '- You must provide a valid message date.';
						};
					} else {
						$enmse_alternate_date = '0000-00-00';
					}
					

					$enmse_description = $_POST['message_description'];
					$enmse_cpt_description = stripslashes(strip_tags($_POST['message_description']));
					
					if ( ($_POST['message_audio_url'] != $_POST['enmseexistingaudio']) || ($_POST['message_audio_url_dummy'] != $_POST['enmseexistingaudio']) ) {
						if ( $_POST['message_audio_url'] == $_POST['enmseexistingaudio'] ) {
							$enmsegetaudio = $_POST['message_audio_url_dummy'];
						} else {
							$enmsegetaudio = $_POST['message_audio_url'];
						}
						
						if ( $enmsegetaudio != null ) {
							if ( $enmseid3 == 1 ) { // if enabled
								if (preg_match('/(.mp3)/', $enmsegetaudio)) {
									$enmse_f = $enmsegetaudio;
									$enmse_m = new mp3file($enmse_f);
									$enmse_a = $enmse_m->get_metadata();
							
									if ( isset($enmse_a['Filesize']) ) {
										if ($enmse_a['Encoding']=='Unknown') {
											$enmse_audio_file_size = $enmse_a['Filesize'];
											$enmse_length = null;
										} elseif ($enmse_a['Encoding']=='VBR') {
											$enmse_audio_file_size = $enmse_a['Filesize'];
											$enmse_length = null;
										} elseif ($enmse_a['Encoding']=='CBR') {
											$enmse_audio_file_size = $enmse_a['Filesize'];
											$enmse_length = $enmse_a['Length mm:ss'];
										} 
									} else {
										$enmse_audio_file_size = $_POST['message_audio_file_size'];
										$enmse_length = strip_tags($_POST['message_length']);
									}
								} else {
									$enmseaparts=parse_url($enmsegetaudio);
									if (ini_get('open_basedir') == '' && isset($enmseaparts['host'])){
										$ach = curl_init();
										curl_setopt($ach, CURLOPT_URL, $enmsegetaudio);
										curl_setopt($ach, CURLOPT_FOLLOWLOCATION, true);
										curl_setopt($ach, CURLOPT_RETURNTRANSFER, true);
										curl_setopt($ach, CURLOPT_HEADER, true);
										curl_setopt($ach, CURLOPT_NOBODY, true);
										curl_exec($ach);
										$enmse_audio_file_size = curl_getinfo($ach, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
										$enmse_asizetest = $_POST['message_length'];
										if ( $enmse_asizetest != null || $enmse_asizetest != 0 ) {
											$enmse_length = strip_tags($_POST['message_length']);
										} else {
											$enmse_length = null;
										}
									} else {
										$enmse_asizetest = $_POST['message_audio_file_size'];
										if ( $enmse_asizetest != null || $enmse_asizetest != 0 ) {
											$enmse_audio_file_size = $_POST['message_audio_file_size'];
											$enmse_length = strip_tags($_POST['message_length']);
										} else {
											$enmse_audio_file_size = 0;
											$enmse_length = null;
										}
									}
								}
							} else { // if not enabled
								$enmse_audio_file_size = $_POST['message_audio_file_size'];
								$enmse_length = strip_tags($_POST['message_length']);
							}
						} else {
							$enmse_audio_file_size = 0;
							$enmse_length = null;	
						}
					} else {
						$enmse_audio_file_size = $_POST['message_audio_file_size'];
						$enmse_length = strip_tags($_POST['message_length']);
					}
					
					if ( $_POST['message_video_url'] != $_POST['enmseexistingvideo'] ) {
						$enmsegetvideo = $_POST['message_video_url'];
						if ( $enmsegetvideo != null ) {
							if ( $enmseid3 == 1 ) { // if enabled
								$enmseparts=parse_url($enmsegetvideo);
								if (ini_get('open_basedir') == '' && isset($enmseparts['host'])){
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $enmsegetvideo);
									curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_HEADER, true);
									curl_setopt($ch, CURLOPT_NOBODY, true);
									curl_exec($ch);
									$enmse_video_file_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
								} else {
									$enmse_sizetest = $_POST['message_video_file_size'];
									if ( $enmse_sizetest != null || $enmse_sizetest != 0 ) {
										$enmse_video_file_size = $_POST['message_video_file_size'];
									} else {
										$enmse_video_file_size = 0;
									}
								}
							} else { // if not enabled
								$enmse_video_file_size = $_POST['message_video_file_size'];
							}
						} else {
							$enmse_video_file_size = 0;
						}
					} else {
						$enmse_video_file_size = $_POST['message_video_file_size'];
					}
					
					$enmse_video_length = strip_tags($_POST['message_video_length']);

					
					$enmse_message_thumbnail = $_POST['message_thumbnail'];
					
					if ( strlen($_POST['message_audio_url']) < 1 ) {
						$enmse_audio_url = 0;
					} else {
						$enmse_audio_url = $_POST['message_audio_url'];
					}
					
					if ( strlen($_POST['message_video_url']) < 1 ) {
						$enmse_video_url = 0;
					} else {
						$enmse_video_url = $_POST['message_video_url'];
					}
					
					if ( strlen($_POST['message_embed_code']) < 1 ) { //here
						$enmse_embed_code = 0;
					} else {
						if (preg_match('/(iframe)+/i', $_POST['message_embed_code']) || preg_match('/(fb-roo)\w+/', $_POST['message_embed_code'])) {
							$enmse_embed_code = $_POST['message_embed_code'];
						} elseif (preg_match('/(faceboo)\w+/', $_POST['message_embed_code'])) { // Facebook 
							$enmse_embed_code = '<div id="fb-root"></div><script async="1" defer="0" crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script><div class="fb-video" data-href="' . $_POST['message_embed_code'] . '"></div>';
						} elseif (preg_match('/(youtube\.co|youtu\.b)\w+/', $_POST['message_embed_code'])) { // YouTube 
							$videoid = enmse_youtube($_POST['message_embed_code']);
							$enmse_embed_code = '<iframe src="https://www.youtube.com/embed/' . $videoid . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
						} elseif (preg_match('/(vimeo\.co)\w+/', $_POST['message_embed_code'])) { // Vimeo 
							$videoid = enmse_vimeo($_POST['message_embed_code']);
							$enmse_embed_code = '<iframe src="https://player.vimeo.com/video/' . $videoid . '?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
						} else {
							$enmse_embed_code = $_POST['message_embed_code'];
						}
					}

					if ( strlen($_POST['message_video_embed_url']) < 1 ) {
						$enmse_video_embed_url = 0;
					} else {
						$enmse_video_embed_url = $_POST['message_video_embed_url'];
					}

					if ( strlen($_POST['message_additional_video_embed_url']) < 1 ) {
						$enmse_additional_video_embed_url = 0;
					} else {
						$enmse_additional_video_embed_url = $_POST['message_additional_video_embed_url'];
					}
					
					$enmse_alternate_toggle = strip_tags($_POST['message_alternate_toggle']);
					
					if ( strlen($_POST['message_alternate_embed']) < 1 ) {
						$enmse_alternate_embed = 0;
					} else {
						if (preg_match('/(iframe)+/i', $_POST['message_alternate_embed']) || preg_match('/(fb-roo)\w+/', $_POST['message_alternate_embed'])) {
							$enmse_alternate_embed = $_POST['message_alternate_embed'];
						} elseif (preg_match('/(faceboo)\w+/', $_POST['message_alternate_embed'])) { // Facebook 
							$enmse_alternate_embed = '<div id="fb-root"></div><script async="1" defer="0" crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script><div class="fb-video" data-href="' . $_POST['message_alternate_embed'] . '"></div>';
						} elseif (preg_match('/(youtube\.co|youtu\.b)\w+/', $_POST['message_alternate_embed'])) { // YouTube 
							$videoid = enmse_youtube($_POST['message_alternate_embed']);
							$enmse_alternate_embed = '<iframe src="https://www.youtube.com/embed/' . $videoid . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
						} elseif (preg_match('/(vimeo\.co)\w+/', $_POST['message_alternate_embed'])) { // Vimeo 
							$videoid = enmse_vimeo($_POST['message_alternate_embed']);
							$enmse_alternate_embed = '<iframe src="https://player.vimeo.com/video/' . $videoid . '?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
						} else {
							$enmse_alternate_embed = $_POST['message_alternate_embed'];
						}
					}
					
					$enmse_alternate_label = $_POST['message_alternate_label'];
					
					if ( !empty($_POST['series']) ) {
						$enmse_series = $_POST['series'];
					} else {
						$enmse_series = NULL;
					}
					
					if ( !empty($_POST['topics']) ) {
						$enmse_topics = $_POST['topics'];
					} else {
						$enmse_topics = NULL;
					}

					$enmse_primary_series = $_POST['message_primary_series'];
					$enmse_podcast_image = strip_tags($_POST['message_podcast_image']);

					if ( !isset($_POST['message_permalink']) ) {
						$enmse_permalink = "";
					} else {
						$enmse_permalink = strip_tags($_POST['message_permalink']);	
					}

					$enmse_old_permalink = strip_tags($_POST['message_old_permalink']);
					$enmse_comments = $_POST['message_permalink_comments'];
					$enmse_cptid = $_POST['message_wp_post_id'];

					$enmse_permalink_prefix = $_POST['message_permalink_prefix'];
					$enmse_permalink_speaker = $_POST['message_permalink_speaker'];
					$enmse_podcast_series = $_POST['message_podcast_series'];

					
					if (empty($enmse_errors)) {
						if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) {
							$enmse_mid = strip_tags($_GET['enmse_mid']);
						}
						
						// Delete old Series Message Matches
						$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_series_message_matches" . " WHERE message_id=%d";
						$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_mid ); 
						$enmse_deleted = $wpdb->query( $enmse_delete_query );
						
						// Add series message relations in the DB
						if ( !empty($enmse_series) ) {
							foreach ($enmse_series as $s) {
								$enmse_newsmm = array(
									'message_id' => $enmse_mid, 
									'series_id' => $s
									); 
								$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newsmm );
							}
						}
						
						// Delete old Message Topic Matches
						$enmse_delete_query_preparredt = "DELETE FROM " . $wpdb->prefix . "se_message_topic_matches" . " WHERE message_id=%d";
						$enmse_delete_queryt = $wpdb->prepare( $enmse_delete_query_preparredt, $enmse_mid ); 
						$enmse_deletedt = $wpdb->query( $enmse_delete_queryt );
						
						// Add message topic relations in the DB
						if ( !empty($enmse_topics) ) {
							foreach ($enmse_topics as $t) {
								$enmse_newmtm = array(
									'message_id' => $enmse_mid, 
									'topic_id' => $t
									); 
								$wpdb->insert( $wpdb->prefix . "se_message_topic_matches", $enmse_newmtm );
							}
						}
						
						// Delete old Message Speaker Matches
						$enmse_delete_query_preparredsp = "DELETE FROM " . $wpdb->prefix . "se_message_speaker_matches" . " WHERE message_id=%d";
						$enmse_delete_querysp = $wpdb->prepare( $enmse_delete_query_preparredsp, $enmse_mid ); 
						$enmse_deletedsp = $wpdb->query( $enmse_delete_querysp );
						
						// Add speaker relation in the DB
						$enmse_newmspm = array(
							'message_id' => $enmse_mid, 
							'speaker_id' => $enmse_speaker
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_speaker_matches", $enmse_newmspm );

						// Get the SpeakerXX
						$enmse_findthespeakersql = "SELECT speaker_id, first_name, last_name FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches USING (speaker_id) WHERE message_id = %d GROUP BY speaker_id LIMIT 1"; 
						$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_mid );
						$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
						$enmse_speaker_name = stripslashes($enmse_speaker->first_name) . ' ' . stripslashes($enmse_speaker->last_name);

						// Get the Primary Series Info
						if ( $enmse_primary_series != 0 ) {
							$enmse_findtheprimarysql = "SELECT s_title, graphic_thumb, thumbnail_url, podcast_image FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d LIMIT 1"; 
							$enmse_findtheprimary = $wpdb->prepare( $enmse_findtheprimarysql, $enmse_primary_series );
							$enmse_primary = $wpdb->get_row( $enmse_findtheprimary, OBJECT );
							$enmse_noseries = 1;
							$enmse_series_thumb = $enmse_primary->graphic_thumb;
							$enmse_series_image = $enmse_primary->thumbnail_url;
							$enmse_series_podcast_image = $enmse_primary->podcast_image;
						} else {
							$enmse_noseries = 0;
							$enmse_series_thumb = null;
							$enmse_series_image = null;
							$enmse_series_podcast_image = null;
						}

						$enmse_new_values = array( 'title' => $enmse_title, 'date' => $enmse_date, 'speaker' => $enmse_speaker_name, 'alternate_date' => $enmse_alternate_date, 'description' => $enmse_description, 'message_length' => $enmse_length, 'message_thumbnail' => $enmse_message_thumbnail, 'audio_url' => $enmse_audio_url, 'video_embed_url' => $enmse_video_embed_url, 'additional_video_embed_url' => $enmse_additional_video_embed_url, 'message_video_length' => $enmse_video_length, 'video_url' => $enmse_video_url, 'audio_file_size' => $enmse_audio_file_size, 'video_file_size' => $enmse_video_file_size, 'embed_code' => $enmse_embed_code, 'alternate_toggle' => $enmse_alternate_toggle, 'alternate_embed' => $enmse_alternate_embed, 'alternate_label' => $enmse_alternate_label, 'primary_series' => $enmse_primary_series, 'series_thumbnail' => $enmse_series_thumb, 'series_image' => $enmse_series_image, 'series_podcast_image' => $enmse_series_podcast_image, 'podcast_image' => $enmse_podcast_image, 'permalink_prefix' => $enmse_permalink_prefix, 'permalink_speaker' => $enmse_permalink_speaker, 'podcast_series' => $enmse_podcast_series ); 
						$enmse_where = array( 'message_id' => $enmse_mid ); 
						$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_values, $enmse_where ); 

						// Update Permalinks

						if ( ($enmse_cptid != null && $enmse_permalink != "") || ($enmse_cptid != "" && $enmse_permalink != "") ) {
							
							if ( $enmse_permalink == $enmse_old_permalink ) {
								$newpermalink = $enmse_permalink;
							} else {
								function enmsedashes($str) {
									$stepone = str_replace("'", "", $str);
									$steptwo = str_replace("\"", "", $stepone);
									$stepthree = preg_replace("/[^A-Za-z0-9]+/", "-", $steptwo);
									$stepfour = preg_replace("/^-*|-*$/", "", $stepthree);
									$finalstring = strtolower($stepfour);
									return $finalstring;
								}

								$newpermalink = enmsedashes($enmse_permalink);

								$enmse_permachecksql = "SELECT ID FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'enmse_message' AND post_name = %s"; 
								$enmse_permacheckp = $wpdb->prepare( $enmse_permachecksql, $newpermalink );
								$enmse_permacheck = $wpdb->get_results( $enmse_permacheckp );

								if ( !empty($enmse_permacheck) ) {
									$newpermalink = rand(1,99) . "-" . $newpermalink;
								}
							}

							$cptgettitle = str_replace("\"", "", $enmse_cpt_title);
							if ( $enmse_permalink_prefix == 1 && $enmse_permalink_speaker == 1 ) {
								$cpttitle = $enmsemessaget . ": \"" . $cptgettitle . "\" " . $enmse_from . " " . $enmse_speaker_name;
							} elseif ( $enmse_permalink_prefix == 1 && $enmse_permalink_speaker == 0 ) {
								$cpttitle = $enmsemessaget . ": \"" . $cptgettitle . "\"";
							} elseif ( $enmse_permalink_prefix == 0 && $enmse_permalink_speaker == 1 ) {
								$cpttitle = "\"" . $cptgettitle . "\" " . $enmse_from . " " . $enmse_speaker_name;
							} else {
								$cpttitle = $cptgettitle;
							}
							

							if ( $enmse_noseries == 1 ) {
								$finalexcerpt = $enmse_permalinkblankexcerpt . " \"" . $enmse_primary->s_title . ".\" " . $enmse_cpt_description;
							} else {
								$finalexcerpt = $enmse_cpt_description;
							}

							$enmse_new_cpt_values = array( 'post_title' => $cpttitle, 'post_excerpt' => $finalexcerpt, 'post_name' => $newpermalink, 'post_modified' => current_time( 'mysql' ), 'post_modified_gmt' => current_time( 'mysql', 1 ), 'comment_status' => $enmse_comments ); 
							$enmse_cpt_where = array( 'ID' => $enmse_cptid ); 
							$wpdb->update( $wpdb->prefix . "posts", $enmse_new_cpt_values, $enmse_cpt_where );

						} else {

							// New Custom Post Type Message 
							function enmsedashes($str) {
								$stepone = str_replace("'", "", $str);
								$steptwo = str_replace("\"", "", $stepone);
								$stepthree = preg_replace("/[^A-Za-z0-9]+/", "-", $steptwo);
								$stepfour = preg_replace("/^-*|-*$/", "", $stepthree);
								$finalstring = strtolower($stepfour);
								return $finalstring;
							}

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
							if ( $enmse_permalink_prefix == 1 && $enmse_permalink_speaker == 1 ) {
								$cpttitle = $enmsemessaget . ": \"" . $cptgettitle . "\" " . $enmse_from . " " . $enmse_speaker_name;
							} elseif ( $enmse_permalink_prefix == 1 && $enmse_permalink_speaker == 0 ) {
								$cpttitle = $enmsemessaget . ": \"" . $cptgettitle . "\"";
							} elseif ( $enmse_permalink_prefix == 0 && $enmse_permalink_speaker == 1 ) {
								$cpttitle = "\"" . $cptgettitle . "\" " . $enmse_from . " " . $enmse_speaker_name;
							} else {
								$cpttitle = $cptgettitle;
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
								'comment_status' => $enmse_comments,
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


						// Done Updating
						$enmse_messages[] = "Message successfully updated!";

						$enmse_findthemessagesql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " WHERE message_id = %d"; 
						$enmse_findthemessage = $wpdb->prepare( $enmse_findthemessagesql, $enmse_mid );
						$enmse_single = $wpdb->get_row( $enmse_findthemessage, OBJECT );
						$enmse_singlecount = $wpdb->num_rows;

						$permaid = $enmse_single->wp_post_id;

						$enmse_singlecptsql = "SELECT post_name, comment_status FROM " . $wpdb->prefix . "posts" . " WHERE ID = %d"; 
						$enmse_singlecptp = $wpdb->prepare( $enmse_singlecptsql, $permaid );
						$enmse_singlecpt = $wpdb->get_row( $enmse_singlecptp, OBJECT );

						// Get All Series Message Matches
						$enmse_preparredmsmmsql = "SELECT series_id, message_id FROM " . $wpdb->prefix . "se_series_message_matches" . " WHERE message_id = %d"; 
						$enmse_msmmsql = $wpdb->prepare( $enmse_preparredmsmmsql, $enmse_single->message_id );
						$enmse_msmm = $wpdb->get_results( $enmse_msmmsql );

						// Get All Message Topic Matches
						$enmse_preparredmmtmsql = "SELECT topic_id, message_id FROM " . $wpdb->prefix . "se_message_topic_matches" . " WHERE message_id = %d"; 
						$enmse_mmtmsql = $wpdb->prepare( $enmse_preparredmmtmsql, $enmse_single->message_id );
						$enmse_mmtm = $wpdb->get_results( $enmse_mmtmsql );
						
						// Get All Files
						$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
						$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_mid );
						$enmse_files = $wpdb->get_results( $enmse_fsql );

						// Get All Scriptures
						$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
						$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_mid );
						$enmse_scriptures = $wpdb->get_results( $enmse_scsql );
					} else {
						if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) {
							$enmse_mid = strip_tags($_GET['enmse_mid']);
						}
						
						$enmse_findthemessagesql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " WHERE message_id = %d"; 
						$enmse_findthemessage = $wpdb->prepare( $enmse_findthemessagesql, $enmse_mid );
						$enmse_single = $wpdb->get_row( $enmse_findthemessage, OBJECT );
						$enmse_singlecount = $wpdb->num_rows;

						$permaid = $enmse_single->wp_post_id;

						$enmse_singlecptsql = "SELECT post_name, comment_status FROM " . $wpdb->prefix . "posts" . " WHERE ID = %d"; 
						$enmse_singlecptp = $wpdb->prepare( $enmse_singlecptsql, $permaid );
						$enmse_singlecpt = $wpdb->get_row( $enmse_singlecptp, OBJECT );

						// Get All Series Message Matches
						$enmse_preparredmsmmsql = "SELECT series_id, message_id FROM " . $wpdb->prefix . "se_series_message_matches" . " WHERE message_id = %d"; 
						$enmse_msmmsql = $wpdb->prepare( $enmse_preparredmsmmsql, $enmse_single->message_id );
						$enmse_msmm = $wpdb->get_results( $enmse_msmmsql );

						// Get All Message Topic Matches
						$enmse_preparredmmtmsql = "SELECT topic_id, message_id FROM " . $wpdb->prefix . "se_message_topic_matches" . " WHERE message_id = %d"; 
						$enmse_mmtmsql = $wpdb->prepare( $enmse_preparredmmtmsql, $enmse_single->message_id );
						$enmse_mmtm = $wpdb->get_results( $enmse_mmtmsql );
						
						// Get the Speaker
						$enmse_findthespeakersql = "SELECT speaker_id FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches USING (speaker_id) WHERE message_id = %d GROUP BY speaker_id LIMIT 1"; 
						$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_mid );
						$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
						
						// Get All Files
						$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
						$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_mid );
						$enmse_files = $wpdb->get_results( $enmse_fsql );

						// Get All Scriptures
						$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
						$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_mid );
						$enmse_scriptures = $wpdb->get_results( $enmse_scsql );
					}

					
				} else {
					if ( isset($_GET['enmse_mid']) && is_numeric($_GET['enmse_mid']) ) {
						$enmse_mid = strip_tags($_GET['enmse_mid']);
					}

					$enmse_findthemessagesql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " WHERE message_id = %d"; 
					$enmse_findthemessage = $wpdb->prepare( $enmse_findthemessagesql, $enmse_mid );
					$enmse_single = $wpdb->get_row( $enmse_findthemessage, OBJECT );
					$enmse_singlecount = $wpdb->num_rows;

					$permaid = $enmse_single->wp_post_id;

					$enmse_singlecptsql = "SELECT post_name, comment_status FROM " . $wpdb->prefix . "posts" . " WHERE ID = %d"; 
					$enmse_singlecptp = $wpdb->prepare( $enmse_singlecptsql, $permaid );
					$enmse_singlecpt = $wpdb->get_row( $enmse_singlecptp, OBJECT );
					
					// Get All Series Message Matches
					$enmse_preparredmsmmsql = "SELECT series_id, message_id FROM " . $wpdb->prefix . "se_series_message_matches" . " WHERE message_id = %d"; 
					$enmse_msmmsql = $wpdb->prepare( $enmse_preparredmsmmsql, $enmse_single->message_id );
					$enmse_msmm = $wpdb->get_results( $enmse_msmmsql );
					
					// Get All Message Topic Matches
					$enmse_preparredmmtmsql = "SELECT topic_id, message_id FROM " . $wpdb->prefix . "se_message_topic_matches" . " WHERE message_id = %d"; 
					$enmse_mmtmsql = $wpdb->prepare( $enmse_preparredmmtmsql, $enmse_single->message_id );
					$enmse_mmtm = $wpdb->get_results( $enmse_mmtmsql );
					
					// Get the Speaker
					$enmse_findthespeakersql = "SELECT speaker_id FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches USING (speaker_id) WHERE message_id = %d GROUP BY speaker_id LIMIT 1"; 
					$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_mid );
					$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
					
					// Get All Files
					$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
					$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_mid );
					$enmse_files = $wpdb->get_results( $enmse_fsql );

					// Get All Scriptures
					$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
					$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_mid );
					$enmse_scriptures = $wpdb->get_results( $enmse_scsql );
				}	
			}
			
			if ( $_GET['enmse_action'] == 'new' && !isset($_GET['enmse_did']) ) { // New Message
				
				$enmse_userdetails = wp_get_current_user(); 
				
				if ( $_POST ) {
					if (empty($_POST['message_title'])) { 
						$enmse_errors[] = '- You must name the new message.';
					} else {
						$enmse_title = strip_tags($_POST['message_title']);
						$enmse_cpt_title = stripslashes(strip_tags($_POST['message_title']));
					}
					
					if (($_POST['message_speaker'] == 0) || ($_POST['message_speaker'] == 'n')) { 
						$enmse_errors[] = '- You must pick a speaker for the message.';
					} else {
						$enmse_speaker = strip_tags($_POST['message_speaker']);
					}
					
					if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['message_date'])) { 
						$enmse_date = strip_tags($_POST['message_date']);
					} else {
						$enmse_errors[] = '- You must provide a valid message date.';
					};
					
					if ( $_POST['message_alternate_date'] != NULL ) {
						if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['message_alternate_date'])) { 
							$enmse_alternate_date = strip_tags($_POST['message_alternate_date']);
						} else {
							$enmse_errors[] = '- You must provide a valid message date.';
						};
					} else {
						$enmse_alternate_date = '0000-00-00';
					}
					
					$enmse_description = $_POST['message_description'];
					$enmse_cpt_description = stripslashes(strip_tags($_POST['message_description']));
					
					$enmse_message_thumbnail = $_POST['message_thumbnail'];
					
					if ( strlen($_POST['message_audio_url']) < 1 ) {
						$enmse_audio_url = 0;
					} else {
						$enmse_audio_url = $_POST['message_audio_url'];
					}
					
					//Set Audio File Size and Length
						if ( $_POST['message_audio_url'] == $_POST['message_audio_url_dummy'] ) {
							$enmsegetaudio = $_POST['message_audio_url_dummy'];
						} else {
							$enmsegetaudio = $_POST['message_audio_url'];
						}
						
						if ( $enmsegetaudio != null ) {
							if ( $enmseid3 == 1 ) { // if enabled
								if (preg_match('/(.mp3)/', $enmsegetaudio)) {
									$enmse_f = $enmsegetaudio;
									$enmse_m = new mp3file($enmse_f);
									$enmse_a = $enmse_m->get_metadata();
							
									if ( isset($enmse_a['Filesize']) ) {
										if ($enmse_a['Encoding']=='Unknown') {
											$enmse_audio_file_size = $enmse_a['Filesize'];
											$enmse_length = null;
										} elseif ($enmse_a['Encoding']=='VBR') {
											$enmse_audio_file_size = $enmse_a['Filesize'];
											$enmse_length = null;
										} elseif ($enmse_a['Encoding']=='CBR') {
											$enmse_audio_file_size = $enmse_a['Filesize'];
											$enmse_length = $enmse_a['Length mm:ss'];
										} 
									} else {
										$enmse_audio_file_size = 0;
										$enmse_length = null;	
									}
								} else {
									$enmseaparts=parse_url($enmsegetaudio);
									if (ini_get('open_basedir') == '' && isset($enmseaparts['host'])){
										$ach = curl_init();
										curl_setopt($ach, CURLOPT_URL, $enmsegetaudio);
										curl_setopt($ach, CURLOPT_FOLLOWLOCATION, true);
										curl_setopt($ach, CURLOPT_RETURNTRANSFER, true);
										curl_setopt($ach, CURLOPT_HEADER, true);
										curl_setopt($ach, CURLOPT_NOBODY, true);
										curl_exec($ach);
										$enmse_audio_file_size = curl_getinfo($ach, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
										$enmse_length = null;
									} else {
										$enmse_audio_file_size = 0;
										$enmse_length = null;
									}	
								}
							} else {
								$enmse_audio_file_size = $_POST['message_audio_file_size'];
								$enmse_length = strip_tags($_POST['message_length']);
							}
						} else {
							$enmse_audio_file_size = 0;
							$enmse_length = null;	
						}
						
					 // Set Video File Size
					 $enmsegetvideo = $_POST['message_video_url'];
					 if ( $enmsegetvideo != null ) {
					 	if ( $enmseid3 == 1 ) { // if enabled
							$enmseparts=parse_url($enmsegetvideo);
						 	if (ini_get('open_basedir') == '' && isset($enmseparts['host'])){
						 		$ch = curl_init();
						 		curl_setopt($ch, CURLOPT_URL, $enmsegetvideo);
						 		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
						 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						 		curl_setopt($ch, CURLOPT_HEADER, true);
						 		curl_setopt($ch, CURLOPT_NOBODY, true);
						 		curl_exec($ch);
						 		$enmse_video_file_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
						 	} else {
						 		$enmse_video_file_size = 0;
						 	}
						 } else {
						 	$enmse_video_file_size = $_POST['message_video_file_size'];
						 }
					 } else {
					 	$enmse_video_file_size = 0;
					 }
					
					$enmse_video_length = strip_tags($_POST['message_video_length']);
					
					if ( strlen($_POST['message_video_url']) < 1 ) {
						$enmse_video_url = 0;
					} else {
						$enmse_video_url = $_POST['message_video_url'];
					}
					
					if ( strlen($_POST['message_embed_code']) < 1 ) {
						$enmse_embed_code = 0;
					} else {
						if (preg_match('/(iframe)+/i', $_POST['message_embed_code']) || preg_match('/(fb-roo)\w+/', $_POST['message_embed_code'])) {
							$enmse_embed_code = $_POST['message_embed_code'];
						} elseif (preg_match('/(faceboo)\w+/', $_POST['message_embed_code'])) { // Facebook 
							$enmse_embed_code = '<div id="fb-root"></div><script async="1" defer="0" crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script><div class="fb-video" data-href="' . $_POST['message_embed_code'] . '"></div>';
						} elseif (preg_match('/(youtube\.co|youtu\.b)\w+/', $_POST['message_embed_code'])) { // YouTube 
							$videoid = enmse_youtube($_POST['message_embed_code']);
							$enmse_embed_code = '<iframe src="https://www.youtube.com/embed/' . $videoid . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
						} elseif (preg_match('/(vimeo\.co)\w+/', $_POST['message_embed_code'])) { // Vimeo 
							$videoid = enmse_vimeo($_POST['message_embed_code']);
							$enmse_embed_code = '<iframe src="https://player.vimeo.com/video/' . $videoid . '?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
						} else {
							$enmse_embed_code = $_POST['message_embed_code'];
						}
					}

					if ( strlen($_POST['message_video_embed_url']) < 1 ) {
						$enmse_video_embed_url = 0;
					} else {
						$enmse_video_embed_url = $_POST['message_video_embed_url'];
					}

					if ( strlen($_POST['message_additional_video_embed_url']) < 1 ) {
						$enmse_additional_video_embed_url = 0;
					} else {
						$enmse_additional_video_embed_url = $_POST['message_additional_video_embed_url'];
					}
					
					$enmse_alternate_toggle = strip_tags($_POST['message_alternate_toggle']);
					
					if ( strlen($_POST['message_alternate_embed']) < 1 ) {
						$enmse_alternate_embed = 0;
					} else {
						if (preg_match('/(iframe)+/i', $_POST['message_alternate_embed']) || preg_match('/(fb-roo)\w+/', $_POST['message_alternate_embed'])) {
							$enmse_alternate_embed = $_POST['message_alternate_embed'];
						} elseif (preg_match('/(faceboo)\w+/', $_POST['message_alternate_embed'])) { // Facebook 
							$enmse_alternate_embed = '<div id="fb-root"></div><script async="1" defer="0" crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script><div class="fb-video" data-href="' . $_POST['message_alternate_embed'] . '"></div>';
						} elseif (preg_match('/(youtube\.co|youtu\.b)\w+/', $_POST['message_alternate_embed'])) { // YouTube 
							$videoid = enmse_youtube($_POST['message_alternate_embed']);
							$enmse_alternate_embed = '<iframe src="https://www.youtube.com/embed/' . $videoid . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
						} elseif (preg_match('/(vimeo\.co)\w+/', $_POST['message_alternate_embed'])) { // Vimeo 
							$videoid = enmse_vimeo($_POST['message_alternate_embed']);
							$enmse_alternate_embed = '<iframe src="https://player.vimeo.com/video/' . $videoid . '?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
						} else {
							$enmse_alternate_embed = $_POST['message_alternate_embed'];
						}
					}
					
					$enmse_alternate_label = $_POST['message_alternate_label'];
					
					if ( !empty($_POST['series']) ) {
						$enmse_series = $_POST['series'];
					} else {
						$enmse_series = NULL;
					}
					
					if ( !empty($_POST['topics']) ) {
						$enmse_topics = $_POST['topics'];
					} else {
						$enmse_topics = NULL;
					}

					$enmse_primary_series = $_POST['message_primary_series'];
					$enmse_podcast_image = strip_tags($_POST['message_podcast_image']);
					$enmse_comments = $_POST['message_permalink_comments'];
					$enmse_permalink_prefix = $_POST['message_permalink_prefix'];
					$enmse_permalink_speaker = $_POST['message_permalink_speaker'];
					$enmse_podcast_series = $_POST['message_podcast_series'];
					
					if (empty($enmse_errors)) {
						$enmse_single_created = "yes";

						// Get the Primary Series Info
						if ( $enmse_primary_series != 0 ) {
							$enmse_findtheprimarysql = "SELECT s_title, graphic_thumb, thumbnail_url, podcast_image FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d LIMIT 1"; 
							$enmse_findtheprimary = $wpdb->prepare( $enmse_findtheprimarysql, $enmse_primary_series );
							$enmse_primary = $wpdb->get_row( $enmse_findtheprimary, OBJECT );
							$enmse_noseries = 1;
							$enmse_series_thumb = $enmse_primary->graphic_thumb;
							$enmse_series_image = $enmse_primary->thumbnail_url;
							$enmse_series_podcast_image = $enmse_primary->podcast_image;
						} else {
							$enmse_noseries = 0;
							$enmse_series_thumb = null;
							$enmse_series_image = null;
							$enmse_series_podcast_image = null;
						}

						$enmse_nfindthespeakersql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id = %d"; 
						$enmse_nfindthespeaker = $wpdb->prepare( $enmse_nfindthespeakersql, $enmse_speaker );
						$enmse_speakerrow = $wpdb->get_row( $enmse_nfindthespeaker, OBJECT );
						$enmse_speaker_name = stripslashes($enmse_speakerrow->first_name) . ' ' . stripslashes($enmse_speakerrow->last_name);

						$enmse_newmessage = array(
							'title' => $enmse_title, 
							'date' => $enmse_date,
							'speaker' => $enmse_speaker_name,
							'alternate_date' => $enmse_alternate_date,
							'description' => $enmse_description,
							'message_length' => $enmse_length,
							'message_thumbnail' => $enmse_message_thumbnail,
							'audio_url' => $enmse_audio_url,
							'message_video_length' => $enmse_video_length,
							'video_url' => $enmse_video_url,
							'video_embed_url' => $enmse_video_embed_url,
							'additional_video_embed_url' => $enmse_additional_video_embed_url,
							'audio_file_size' => $enmse_audio_file_size,
							'video_file_size' => $enmse_video_file_size,
							'embed_code' => $enmse_embed_code,
							'alternate_toggle' => $enmse_alternate_toggle,
							'alternate_embed' => $enmse_alternate_embed,
							'alternate_label' => $enmse_alternate_label,
							'primary_series' => $enmse_primary_series,
							'series_thumbnail' => $enmse_series_thumb,
							'series_image' => $enmse_series_image,
							'series_podcast_image' => $enmse_series_podcast_image,
							'podcast_image' => $enmse_podcast_image,
							'audio_count' => 0,
							'video_count' => 0,
							'alternate_count' => 0,
							'permalink_prefix' => $enmse_permalink_prefix,
							'permalink_speaker' => $enmse_permalink_speaker,
							'podcast_series' => $enmse_podcast_series
							); 
						$wpdb->insert( $wpdb->prefix . "se_messages", $enmse_newmessage );
						$enmpe_new_message_id = $wpdb->insert_id; 
						
						// Add speaker relation in the DB
						
						$enmse_newmspm = array(
							'message_id' => $enmpe_new_message_id, 
							'speaker_id' => $enmse_speaker
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_speaker_matches", $enmse_newmspm );
						
						// Add series relations in the DB
						if ( !empty($enmse_series) ) {
							foreach ($enmse_series as $s) {
								$enmse_newsmm = array(
									'message_id' => $enmpe_new_message_id, 
									'series_id' => $s
									); 
								$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newsmm );
							}
						}
						
						
						// Add series relations in the DB
						if ( !empty($enmse_topics) ) {
							foreach ($enmse_topics as $t) {
								$enmse_newmtm = array(
									'message_id' => $enmpe_new_message_id, 
									'topic_id' => $t
									); 
								$wpdb->insert( $wpdb->prefix . "se_message_topic_matches", $enmse_newmtm );
							}
						}

						// Update uploaded files and change message relations in DB
						$enmse_displayname = $enmse_userdetails->user_login;

						// Save Scriptures
						$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = 0 AND scripture_username = '" . $enmse_displayname . "' GROUP BY scm_match_id ORDER BY scm_match_id ASC"; 
						$enmse_uscriptures = $wpdb->get_results( $enmse_preparredscsql );
						
						foreach ( $enmse_uscriptures as $enmse_sc ) {
							$enmse_username = null;
							$enmse_scid = $enmse_sc->scripture_id;
							$enmse_scmid = $enmse_sc->scm_match_id;
							
							$enmse_new_values = array( 'scripture_username' => $enmse_username ); 
							$enmse_where = array( 'scripture_id' => $enmse_scid ); 
							$wpdb->update( $wpdb->prefix . "se_scriptures", $enmse_new_values, $enmse_where ); 
							
							$enmse_new_valuestwo = array( 'message_id' => $enmpe_new_message_id ); 
							$enmse_wheretwo = array( 'scm_match_id' => $enmse_scmid ); 
							$wpdb->update( $wpdb->prefix . "se_scripture_message_matches", $enmse_new_valuestwo, $enmse_wheretwo ); 
						}

						// Add Scripture Relations
						$enmse_preparredscmsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND focus = 1 GROUP BY scm_match_id ORDER BY sort_id ASC"; 
						$enmse_scmsql = $wpdb->prepare( $enmse_preparredscmsql, $enmpe_new_message_id );
						$enmse_mscriptures = $wpdb->get_results( $enmse_scmsql );

						$scomma = 0;
						foreach ( $enmse_mscriptures as $s ) {
							$enmse_start_book = $s->start_book;
							if ( $scomma == 0 ) {
								$scripturetext = $s->text;
							} else {
								$scripturetext = $scripturetext . ", " . $s->text;
							}
							$scomma = $scomma + 1;

							$enmse_preparreddscmsql = "SELECT bm_match_id FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id = %d AND book_id = %d GROUP BY bm_match_id ORDER BY bm_match_id ASC"; 
							$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $enmpe_new_message_id, $enmse_start_book );
							$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
							$enmse_countrec = $wpdb->num_rows;

							if ( $enmse_countrec > 1 || empty($enmse_dmscriptures) ) {
								$enmse_newbmm = array(
									'message_id' => $enmpe_new_message_id, 
									'book_id' => $enmse_start_book
								); 
								$wpdb->insert( $wpdb->prefix . "se_book_message_matches", $enmse_newbmm );
							}
						}

						if ( isset($scripturetext)  ) {
							$enmse_new_mvalues = array( 'focus_scripture' => $scripturetext ); 
							$enmse_mwhere = array( 'message_id' => $enmpe_new_message_id ); 
							$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );
						}


						
						// Associate Files with This Message
						$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = 0 AND file_username = '" . $enmse_displayname . "' GROUP BY file_name ORDER BY file_name ASC"; 
						$enmse_ufiles = $wpdb->get_results( $enmse_preparredfsql );
						
						foreach ( $enmse_ufiles as $enmse_f ) {
							$enmse_username = null;
							$enmse_fid = $enmse_f->file_id;
							$enmse_mfid = $enmse_f->mf_match_id;
							
							$enmse_new_values = array( 'file_username' => $enmse_username ); 
							$enmse_where = array( 'file_id' => $enmse_fid ); 
							$wpdb->update( $wpdb->prefix . "se_files", $enmse_new_values, $enmse_where ); 
							
							$enmse_new_valuestwo = array( 'message_id' => $enmpe_new_message_id ); 
							$enmse_wheretwo = array( 'mf_match_id' => $enmse_mfid ); 
							$wpdb->update( $wpdb->prefix . "se_message_file_matches", $enmse_new_valuestwo, $enmse_wheretwo ); 

							if ( $enmse_f->featured == 1 ) {
								$enmse_new_mvalues = array( 'file_name' => $enmse_f->file_name, 'file_url' => $enmse_f->file_url, 'file_new_window' => $enmse_f->file_new_window ); 
								$enmse_mwhere = array( 'message_id' => $enmpe_new_message_id ); 
								$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere ); 
							}
						}

						// New Custom Post Type Message 

						function enmsedashes($str) {
							$stepone = str_replace("'", "", $str);
							$steptwo = str_replace("\"", "", $stepone);
							$stepthree = preg_replace("/[^A-Za-z0-9]+/", "-", $steptwo);
							$stepfour = preg_replace("/^-*|-*$/", "", $stepthree);
							$finalstring = strtolower($stepfour);
							return $finalstring;
						}

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
						if ( $enmse_permalink_prefix == 1 && $enmse_permalink_speaker == 1 ) {
							$cpttitle = $enmsemessaget . ": \"" . $cptgettitle . "\" " . $enmse_from . " " . $enmse_speaker_name;
						} elseif ( $enmse_permalink_prefix == 1 && $enmse_permalink_speaker == 0 ) {
							$cpttitle = $enmsemessaget . ": \"" . $cptgettitle . "\"";
						} elseif ( $enmse_permalink_prefix == 0 && $enmse_permalink_speaker == 1 ) {
							$cpttitle = "\"" . $cptgettitle . "\" " . $enmse_from . " " . $enmse_speaker_name;
						} else {
							$cpttitle = $cptgettitle;
						}

						$convertdate = date('Y-m-d', strtotime($enmse_date)) . ' 13:46:46';

						if ( $enmse_noseries == 1 ) {
							$finalexcerpt = $enmse_permalinkblankexcerpt . " \"" . stripslashes($enmse_primary->s_title) . ".\" " . $enmse_cpt_description;
						} else {
							$finalexcerpt = $enmse_cpt_description;
						}

						$enmse_newcptmessage = array(
							'post_author' => get_current_user_id(), 
							'post_date' => current_time( 'mysql' ),
							'post_date_gmt' => current_time( 'mysql', 1 ),
							'post_title' => $cpttitle,
							'post_excerpt' => $finalexcerpt,
							'post_status' => 'publish',
							'post_content' => '&nbsp;',
							'comment_status' => $enmse_comments,
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
						$enmse_mmwhere = array( 'message_id' => $enmpe_new_message_id ); 
						$wpdb->update( $wpdb->prefix . "se_messages", $enmse_newmm_values, $enmse_mmwhere ); 

						// CPT - Make Post Meta match for Series Engine Message
						$enmse_newcptmatch = array(
							'post_id' => $enmse_new_cptmessage_id, 
							'meta_key' => 'enmse_mid',
							'meta_value' => $enmpe_new_message_id
							); 
						$wpdb->insert( $wpdb->prefix . "postmeta", $enmse_newcptmatch );
						
						// Success message
						$enmse_messages[] = "You have successfully added a new message to Series Engine!";
					} else {
						// Get temporarily uploaded files
						$enmse_displayname = $enmse_userdetails->user_login;
						
						// Get All Files
						$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = 0 AND file_username = '" . $enmse_displayname . "' GROUP BY file_name ORDER BY sort_id ASC"; 
						$enmse_files = $wpdb->get_results( $enmse_preparredfsql );

						// Get All Scriptures
						$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = 0 AND scripture_username = '" . $enmse_displayname . "' GROUP BY scm_match_id ORDER BY sort_id ASC"; 
						$enmse_scriptures = $wpdb->get_results( $enmse_preparredscsql );
					}
				} else {
					// Delete any temporary files and scripture if the message was abandoned
					$enmse_displayname = $enmse_userdetails->user_login;
					
					$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = 0 AND file_username = '" . $enmse_displayname . "' GROUP BY file_name ORDER BY file_name ASC"; 
					$enmse_dfiles = $wpdb->get_results( $enmse_preparredfsql );
					
					foreach ($enmse_dfiles as $enmse_f) {
						$enmse_nfid = $enmse_f->file_id;
						$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_files" . "  WHERE file_id = %d";
						$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_nfid ); 
						$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
						
						$matchid = $enmse_f->mf_match_id;
						$enmse_deletetwo_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_message_file_matches" . "  WHERE mf_match_id=%d";
						$enmse_deletetwo_query = $wpdb->prepare( $enmse_deletetwo_query_preparred, $matchid ); 
						$enmse_deletedtwo = $wpdb->query( $enmse_deletetwo_query );
					}

					$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = 0 AND scripture_username = '" . $enmse_displayname . "' GROUP BY scm_match_id ORDER BY sort_id ASC"; 
					$enmse_dscriptures = $wpdb->get_results( $enmse_preparredscsql );
					
					foreach ($enmse_dscriptures as $enmse_sc) {
						$enmse_nscid = $enmse_sc->scripture_id;
						$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_scriptures" . "  WHERE scripture_id = %d";
						$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_nscid ); 
						$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
						
						$matchid = $enmse_sc->scm_match_id;
						$enmse_deletetwo_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_scripture_message_matches" . "  WHERE scm_match_id=%d";
						$enmse_deletetwo_query = $wpdb->prepare( $enmse_deletetwo_query_preparred, $matchid ); 
						$enmse_deletedtwo = $wpdb->query( $enmse_deletetwo_query );
					}
				}

			}
		}
		
		include ('paginated_messages.php'); // Get all series

		if ( isset($_GET['enmse_action']) && $_GET['enmse_action'] == "edit"  ) {
		} else {
			if ( isset($_GET['enmse_sid']) ) { // If results are sorted by Series
				$enmse_findtheseriessql = "SELECT s_title FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 
				$enmse_findtheseries = $wpdb->prepare( $enmse_findtheseriessql, $enmse_sid );
				$enmse_series = $wpdb->get_row( $enmse_findtheseries, OBJECT );
			}
			
			if ( isset($_GET['enmse_tid']) ) { // If results are sorted by topic
				$enmse_findthetopicsql = "SELECT name FROM " . $wpdb->prefix . "se_topics" . " WHERE topic_id = %d"; 
				$enmse_findthetopic = $wpdb->prepare( $enmse_findthetopicsql, $enmse_tid );
				$enmse_topic = $wpdb->get_row( $enmse_findthetopic, OBJECT );
			}
			
			if ( isset($_GET['enmse_spid']) ) { // If results are sorted by speaker
				$enmse_findthespeakersql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id = %d"; 
				$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_spid );
				$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
			}

			if ( isset($_GET['enmse_bid']) ) { // If results are sorted by book
				$enmse_findthebooksql = "SELECT * FROM " . $wpdb->prefix . "se_books" . " WHERE book_id = %d"; 
				$enmse_findthebook = $wpdb->prepare( $enmse_findthebooksql, $enmse_bid );
				$enmse_book = $wpdb->get_row( $enmse_findthebook, OBJECT );
			}
		}
		
		
		
		
		// Get All Series
		$enmse_preparredssql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " WHERE archived = 0 ORDER BY start_date ASC"; 
		$enmse_s = $wpdb->get_results( $enmse_preparredssql );

		$enmse_preparredsssql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " ORDER BY start_date ASC"; 
		$enmse_ss = $wpdb->get_results( $enmse_preparredsssql );

		// Get All Series
		$enmse_preparredbsql = "SELECT * FROM " . $wpdb->prefix . "se_books" . " ORDER BY book_id ASC"; 
		$enmse_b = $wpdb->get_results( $enmse_preparredbsql );
		
		// Get All Topics
		if ( $enmsetopicsort == 1 ) {
			$enmse_preparredtsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
		} else {
            $enmse_preparredtsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " ORDER BY name ASC"; 
		}
		$enmse_t = $wpdb->get_results( $enmse_preparredtsql );
		
		// Get All Speakers
		$enmse_preparredspsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name ASC"; 
		$enmse_sp = $wpdb->get_results( $enmse_preparredspsql );

		$enmse_fsppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE message_id IS NOT NULL GROUP BY speaker_id ORDER BY last_name ASC"; 	
		$enmse_fspeakers = $wpdb->get_results( $enmse_fsppreparredsql );
		
		// Get All Topic Matches
		$enmse_preparredmtmsql = "SELECT topic_id, message_id FROM " . $wpdb->prefix . "se_message_topic_matches"; 
		$enmse_mtm = $wpdb->get_results( $enmse_preparredmtmsql );

		$enmse_ftpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE message_id IS NOT NULL GROUP BY name ORDER BY name ASC";
		$enmse_ftopics = $wpdb->get_results( $enmse_ftpreparredsql );

		// Get All Book Matches
		$enmse_preparredmbmsql = "SELECT book_id, message_id FROM " . $wpdb->prefix . "se_book_message_matches"; 
		$enmse_mbm = $wpdb->get_results( $enmse_preparredmbmsql );

		$enmse_fbpreparredsql = "SELECT book_id, book_name FROM " . $wpdb->prefix . "se_books" . " LEFT JOIN " . $wpdb->prefix . "se_book_message_matches" . " USING (book_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE message_id IS NOT NULL GROUP BY book_name ORDER BY book_id ASC";	
		$enmse_fbooks = $wpdb->get_results( $enmse_fbpreparredsql );
		
		// Get All Series Message Matches
		$enmse_preparredsmmsql = "SELECT series_id, message_id FROM " . $wpdb->prefix . "se_series_message_matches"; 
		$enmse_smm = $wpdb->get_results( $enmse_preparredsmmsql );

		$enmse_fspreparredsql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE message_id IS NOT NULL GROUP BY s_title ORDER BY start_date DESC"; 	
		$enmse_fseries = $wpdb->get_results( $enmse_fspreparredsql );
		
		// Get All Series Speaker Matches
		$enmse_preparredmspmsql = "SELECT speaker_id, message_id FROM " . $wpdb->prefix . "se_message_speaker_matches"; 
		$enmse_mspm = $wpdb->get_results( $enmse_preparredmspmsql );

		// Get All Permalinks
		$enmse_getpermalinksql = "SELECT ID, post_name FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'enmse_message'"; 
		$enmse_allpermalinks = $wpdb->get_results( $enmse_getpermalinksql );
	} else {
		exit("Access Denied");
	}
	
?>

<div class="wrap"> 
<?php if ( isset($_GET['enmse_action']) && ( $enmse_single_created == null && !isset($_GET['enmse_did']) ) ) { if ( $_GET['enmse_action'] == 'new' ) { // If they're adding a new Message ?>
		<link rel='stylesheet' href='<?php echo plugins_url() .'/seriesengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
		
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#message_date").datepicker({ dateFormat: 'yy-mm-dd' });
				jQuery("#message_alternate_date").datepicker({ dateFormat: 'yy-mm-dd' });
			});
		</script>
		<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/message_options283.js'; ?>"></script>
		<h2 class="enmse">Add a New <?php echo $enmsemessaget; ?></h2>
		<?php include ('errorbox.php'); ?>
		<p>Fill out the form fields below to enter a new <?php echo $enmsemessaget; ?> into the Series Engine. Remember that a <?php echo $enmsemessaget; ?> will not be publicly available unless you supply a video embed, audio file or alternate video embed. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-messages"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmsemessagetp; ?>...</a></p>
		
		<ul id="enmse-message-options">
			<li class="selected"><a href="#" id="enmse-message-general">General</a></li>
			<li><a href="#" id="enmse-message-video">Advanced Settings</a></li>
			<li <?php if ( $bibleoption == 0 ) { echo "style=\"display: none\""; }; ?>><a href="#" id="enmse-message-scripture">Scripture</a></li>
			<li><a href="#" id="enmse-message-podcast">Podcast Details</a></li>
			<li><a href="#" id="enmse-message-files">Links/Downloads</a></li>
		</ul>
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmseform">
			<div id="enmse-basic-information">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><strong>Title:</strong></th>
						<td><input id='message_title' name='message_title' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['message_title']));} ?>" tabindex="1" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><strong><?php echo $enmsespeakert; ?>:</strong></th>
						<td>
							<select name="message_speaker" id="message_speaker" tabindex="2">
								<option value="0">- Select a <?php echo $enmsespeakert; ?> -</option>
								<option value="0">-----------------</option>
								<option value="n">Add a New <?php echo $enmsespeakert; ?></option>
								<option value="0">-----------------</option>
								<?php foreach ($enmse_sp as $sp) {  ?>
								<option value="<?php echo $sp->speaker_id; ?>" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_speaker'] == $sp->speaker_id) { ?>selected="selected"<?php }} ?>><?php echo stripslashes($sp->first_name) . " " . stripslashes($sp->last_name); ?></option>
								<?php } ?>
							</select><br />
							<div id="newspeakersection" style="display: none">
								<input id='speaker_first_name' name='speaker_first_name' size='10' type='text' style="color: #cbcbcb" value='First' />
								<input id='speaker_last_name' name='speaker_last_name' size='10' type='text' style="color: #cbcbcb" value='Last' />
								<a href="#" id="addnewspeaker" class="button">Add New <?php echo $enmsespeakert; ?></a>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><strong>Date:</strong></th>
						<td><input id='message_date' name='message_date' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_date'];} ?>' tabindex="3" /> <span class="se-form-instructions">ex: 2012-01-01</span></td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Description:
							<p class="se-form-instructions">A brief description of the <?php echo $enmsemessaget; ?> for your viewers.</p>
						</th>
						<td>
							<textarea name="message_description" id="message_description" rows="4" cols="40" tabindex="4"><?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['message_description']));} ?></textarea><br />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Audio URL:</th>
						<td><input id='message_audio_url' name='message_audio_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_audio_url']);} ?>" tabindex="5" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=file&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-audio se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Video Embed Code:
							<p class="se-form-instructions">Paste an iframe embed code, or just the URL if you're using Vimeo, YouTube, or Facebook.<br /><br />
							<em>This will override the Video URL below and display this embed instead.</em><br /><br />
							<em>Choose a large or responsive width for your embed code; Series Engine will automatically size it down for mobile devices.</em></p>
						</th>
						<td>
							<textarea name="message_embed_code" id="message_embed_code" rows="6" cols="40" tabindex="6"><?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_embed_code']);} ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							(or) Video URL:
							<p class="se-form-instructions"><em>Direct file paths to .mp4 files only; NO embed codes.</em></p>
						</th>
						<td><input id='message_video_embed_url' name='message_video_embed_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_video_embed_url']);} ?>" tabindex="7" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=file&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-video se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
					</tr>
					<tr valign="top">
						<th scope="row">Add to <?php echo $enmseseriest; ?>:</th>
						<td>
							<?php if ( !empty($enmse_s) ) { ?>
							<ul class="enmse-series-topic">
							<?php foreach ($enmse_s as $s) {  ?>
								<li><input name="series[]" type="checkbox" value="<?php echo $s->series_id; ?>" <?php if ($_POST && !empty($enmse_errors)) {if (isset($_POST['series']) && $_POST['series'] != NULL) {foreach ($_POST['series'] as $ps) { if ($ps == $s->series_id) { ?>checked="checked"<?php }}}} ?> class="check seriescheck" title="<?php echo stripslashes($s->s_title); ?>" /> <label for="series[]"> <?php echo stripslashes($s->s_title); ?></label></li>
							<?php }; ?>
							</ul>
							<?php } else { echo '<p>Add ' . $enmseseriest . ' in the "Edit ' . $enmseseriest . '" menu.</p>'; } ?>
							<br /><br />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Primary <?php echo $enmseseriest; ?>:
							<p class="se-form-instructions">The graphic for this <?php echo $enmseseriest; ?> will be shown in Related <?php echo $enmsemessagetp; ?> lists and as the podcast image for this <?php echo $enmsemessaget; ?>.</p>
						</th>
						<td>
							<select name="message_primary_series" id="message_primary_series" tabindex="8">
								<?php if ( $_POST && $_POST['series'] != NULL ) {} else { ?><option value="0">- No <?php echo $enmseseriest; ?> Assigned -</option><?php } ?>
								<?php  
									if ($_POST && !empty($enmse_errors)) {
										if ($_POST['series'] != NULL) {
											foreach ($enmse_s as $s) { 
												foreach ($_POST['series'] as $msmm) { 
													if ( $msmm == $s->series_id ) { ?>
													<option value="<?php echo $s->series_id; ?>" <?php if ($_POST && !empty($enmse_errors)) {if ($msmm == $_POST['message_primary_series'])  { ?>selected="selected"<?php }} ?>><?php echo stripslashes($s->s_title); ?></option>
								<?php }}}}} ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Associate with <?php echo $enmsetopictp; ?>:</th>
						<td>
							<input id='topic_name' name='topic_name' type='text' value='' />
							<a href="#" id="addnewtopic" class="button">Add New <?php echo $enmsetopict; ?></a>
							<?php if ( !empty($enmse_t) ) { ?>
							<ul id="enmse-topiclist" class="enmse-series-topic">
							<?php foreach ($enmse_t as $t) {  ?>
								<li><input name="topics[]" type="checkbox" value="<?php echo $t->topic_id; ?>" <?php if ($_POST && !empty($enmse_errors)) {if (isset($_POST['topics']) && $_POST['topics'] != NULL) {foreach ($_POST['topics'] as $pt) { if ($pt == $t->topic_id) { ?>checked="checked"<?php }}}} ?> class="check" /> <label for="topics[]"> <?php echo stripslashes($t->name); ?></label></li>
							<?php }; ?>
							</ul>
							<?php } else { echo '<p>Add a ' . $enmsetopict . ' above or in the "Edit ' . $enmsetopictp . '" menu.</p>'; } ?>
						</td>
					</tr>

				</table>
			</div>
			
			<div id="enmse-additional-video" style="display: none">
				<p>Add an alternate date, override the <?php echo $enmseseriest; ?> thumbnail, or add an additional piece of video to the <?php echo $enmsemessaget; ?>.</p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Alternate Date:</th>
						<td><input id='message_alternate_date' name='message_alternate_date' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_alternate_date'];} ?>' tabindex="9" /> <span class="se-form-instructions">ex: 2012-01-08</span></td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php echo $enmsemessaget; ?> Thumbnail:
							<p class="se-form-instructions">Optional override to <?php echo $enmseseriest; ?> graphic. According to your settings, design the graphic to be <strong><?php echo $enmse_embedwidth; ?>px</strong> wide.</p>	
						</th>
						<td><input id='message_thumbnail' name='message_thumbnail' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_thumbnail'];} ?>' tabindex="10" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=image&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-graphic se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="message-thumb-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['message_thumbnail'])) { ?><br /><img src="<?php echo $_POST['message_thumbnail']; ?>" /><?php }; ?></div></td>
					</tr>
					<tr valign="top">
						<th scope="row">Additional Video?:</th>
						<td>
							<select name="message_alternate_toggle" id="message_alternate_toggle" tabindex="11">
								<option value="No" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_alternate_toggle'] == "No") { ?>selected="selected"<?php }} ?>>No</option>
								<option value="Yes" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_alternate_toggle'] == "Yes") { ?>selected="selected"<?php }} ?>>Yes</option>
							</select>
							<span class="se-form-instructions">&nbsp;</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Label:</th>
						<td>
							<input id='message_alternate_label' name='message_alternate_label' type='text' onKeyDown="limitText(this.form.limitedtextfield,this.form.countdown,10);" onKeyUp="limitText(this.form.limitedtextfield,this.form.countdown,10);" maxlength="10" value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['message_alternate_label']));} ?>" tabindex="12" />
							<span class="se-form-instructions">&nbsp;Ex: Trailer, Music, etc.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Additional Embed Code:
							<p class="se-form-instructions">Paste an iframe embed code, or just the URL if you're using Vimeo, YouTube, or Facebook.<br /><br />
							<em>Choose a large width for your embed code; Series Engine will automatically size it down for mobile devices.</em></p>
						</th>
						<td>
							<textarea name="message_alternate_embed" id="message_alternate_embed" rows="6" cols="40" tabindex="13"><?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_alternate_embed'];} ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							(or) Additional Video URL:
							<p class="se-form-instructions">This will override the embed code above and embed this video clip instead.<br /><br />
							<em>Direct file paths to .mp4 files only; NO embed codes.</em></p>
						</th>
						<td><input id='message_additional_video_embed_url' name='message_additional_video_embed_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_additional_video_embed_url']);} ?>" tabindex="14" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=file&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-additional-video se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Display Prefix in Permalink Title?:
							<p class="se-form-instructions">Do you want the "<?php echo $enmsemessaget; ?>:" prefix displayed in the permalink title?</p>
						</th>
						<td>
							<select name="message_permalink_prefix" id="message_permalink_prefix" tabindex="16">
								<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_prefix'] == "1") { ?>selected="selected"<?php }} elseif ($default_permalink_prefix == 1) { ?>selected="selected"<?php } ?>>Yes</option>
								<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_prefix'] == "0") { ?>selected="selected"<?php }} elseif ($default_permalink_prefix == 0) { ?>selected="selected"<?php } ?>>No</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Display Speaker in Permalink Title?:
							<p class="se-form-instructions">Do you want to append "by Speaker Name" at the end of the permalink title?</p>
						</th>
						<td>
							<select name="message_permalink_speaker" id="message_permalink_speaker" tabindex="17">
								<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_speaker'] == "1") { ?>selected="selected"<?php }} elseif ($default_permalink_speaker == 1) { ?>selected="selected"<?php } ?>>Yes</option>
								<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_speaker'] == "0") { ?>selected="selected"<?php }} elseif ($default_permalink_speaker == 0) { ?>selected="selected"<?php } ?>>No</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Allow Permalink Comments?:
							<p class="se-form-instructions">Do you want to allow comments on the permalink page for this <?php echo $enmsemessaget; ?>?</p>
						</th>
						<td>
							<select name="message_permalink_comments" id="message_permalink_comments" tabindex="15">
								<option value="closed" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_comments'] == "closed") { ?>selected="selected"<?php }} ?>>No</option>
								<option value="open" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_comments'] == "open") { ?>selected="selected"<?php }} ?>>Yes</option>
							</select>
							
						</td>
					</tr>
				</table>
			</div>

			<div id="enmse-scripture" style="display: none">
				<p>Add scripture references which will appear in this <?php echo $enmsemessaget; ?>'s "Details" section. "Focus" passages will also appear in the Related <?php echo $enmsemessagetp ?> lists, and the <?php echo $enmsemessaget; ?> will be associated with the chosen book when users filter <?php echo $enmsemessagetp; ?> by Book. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-scripture"; ?>" class="enmse-learn-more">Learn more about this feature...</a></p>
				
				<div id="enmsescripturearea">
					<?php if ( !empty($enmse_scriptures) ) { ?>
						<script type="text/javascript">
						jQuery(document).ready(function(){
							var fixHelper = function(e, ui) {
								ui.children().each(function() {
									jQuery(this).width(jQuery(this).width());
								});
								return ui;
							};
							jQuery("#scripturetable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
								var order = jQuery(this).sortable("serialize");
								jQuery.ajax({
									method: "POST",
							        url: seajax.ajaxurl, 
							        data: {
							            'action': 'seriesengine_ajaxsortscripture',
							            'row': order
							        },
							        success:function(data) {

							        },
							        error: function(errorThrown){
							            console.log(errorThrown);
							        }
							    });
							}});
						});
						</script>
					<br />
					<h3>Scripture References Currently Associated with This <?php echo $enmsemessaget; ?>...</h3>
					<table class="widefat" id="scripturetable"> 
						<thead> 
							<tr> 
								<th>Sort</th> 
								<th>Reference</th> 
								<th>URL</th>
								<th>Focus Passage?</th>
								<th>Delete?</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($enmse_scriptures as $scripture) {  ?>
							<tr id="row_<?php echo $scripture->scripture_id; ?>">
								<td class="enmse-sort"></td>
								<td><a href="#" class="seriesengine_editscripture" name="<?php echo $scripture->scripture_id; ?>"><?php echo stripslashes($scripture->text . $scripture->transtext); ?></a></td>
								<td><a href="<?php echo $scripture->link; ?>" target="_blank">Open on <em>bible.com</em></a></td>
								<td><?php if ( $scripture->focus == 1 ) { echo "Yes"; }; ?></td>
								<td class="enmse-delete"><a href="#" class="seriesengine_scripturedelete" name="<?php echo $scripture->scripture_id; ?>" rel="<?php echo $scripture->focus; ?>">Delete</a></td>				
							</tr>
						<?php } ?>
						</tbody>
					</table>
					<br />
					<br />
					<?php } ?>
				</div>

				<div id="enmsescriptureform">
					<h3>Add a New Scripture Reference</h3>		
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Start Verse:</th>
							<td>
								<select name="scripture_start_book" id="scripture_start_book" tabindex="15">
									<option value="1"><?php echo $enmse_booknames[1]; ?></option>
									<option value="2"><?php echo $enmse_booknames[2]; ?></option>
									<option value="3"><?php echo $enmse_booknames[3]; ?></option>
									<option value="4"><?php echo $enmse_booknames[4]; ?></option>
									<option value="5"><?php echo $enmse_booknames[5]; ?></option>
									<option value="6"><?php echo $enmse_booknames[6]; ?></option>
									<option value="7"><?php echo $enmse_booknames[7]; ?></option>
									<option value="8"><?php echo $enmse_booknames[8]; ?></option>
									<option value="9"><?php echo $enmse_booknames[9]; ?></option>
									<option value="10"><?php echo $enmse_booknames[10]; ?></option>
									<option value="11"><?php echo $enmse_booknames[11]; ?></option>
									<option value="12"><?php echo $enmse_booknames[12]; ?></option>
									<option value="13"><?php echo $enmse_booknames[13]; ?></option>
									<option value="14"><?php echo $enmse_booknames[14]; ?></option>
									<option value="15"><?php echo $enmse_booknames[15]; ?></option>
									<option value="16"><?php echo $enmse_booknames[16]; ?></option>
									<option value="17"><?php echo $enmse_booknames[17]; ?></option>
									<option value="18"><?php echo $enmse_booknames[18]; ?></option>
									<option value="19"><?php echo $enmse_booknames[19]; ?></option>
									<option value="20"><?php echo $enmse_booknames[20]; ?></option>
									<option value="21"><?php echo $enmse_booknames[21]; ?></option>
									<option value="22"><?php echo $enmse_booknames[22]; ?></option>
									<option value="23"><?php echo $enmse_booknames[23]; ?></option>
									<option value="24"><?php echo $enmse_booknames[24]; ?></option>
									<option value="25"><?php echo $enmse_booknames[25]; ?></option>
									<option value="26"><?php echo $enmse_booknames[26]; ?></option>
									<option value="27"><?php echo $enmse_booknames[27]; ?></option>
									<option value="28"><?php echo $enmse_booknames[28]; ?></option>
									<option value="29"><?php echo $enmse_booknames[29]; ?></option>
									<option value="30"><?php echo $enmse_booknames[30]; ?></option>
									<option value="31"><?php echo $enmse_booknames[31]; ?></option>
									<option value="32"><?php echo $enmse_booknames[32]; ?></option>
									<option value="33"><?php echo $enmse_booknames[33]; ?></option>
									<option value="34"><?php echo $enmse_booknames[34]; ?></option>
									<option value="35"><?php echo $enmse_booknames[35]; ?></option>
									<option value="36"><?php echo $enmse_booknames[36]; ?></option>
									<option value="37"><?php echo $enmse_booknames[37]; ?></option>
									<option value="38"><?php echo $enmse_booknames[38]; ?></option>
									<option value="39"><?php echo $enmse_booknames[39]; ?></option>
									<option value="40"><?php echo $enmse_booknames[40]; ?></option>
									<option value="41"><?php echo $enmse_booknames[41]; ?></option>
									<option value="42"><?php echo $enmse_booknames[42]; ?></option>
									<option value="43"><?php echo $enmse_booknames[43]; ?></option>
									<option value="44"><?php echo $enmse_booknames[44]; ?></option>
									<option value="45"><?php echo $enmse_booknames[45]; ?></option>
									<option value="46"><?php echo $enmse_booknames[46]; ?></option>
									<option value="47"><?php echo $enmse_booknames[47]; ?></option>
									<option value="48"><?php echo $enmse_booknames[48]; ?></option>
									<option value="49"><?php echo $enmse_booknames[49]; ?></option>
									<option value="50"><?php echo $enmse_booknames[50]; ?></option>
									<option value="51"><?php echo $enmse_booknames[51]; ?></option>
									<option value="52"><?php echo $enmse_booknames[52]; ?></option>
									<option value="53"><?php echo $enmse_booknames[53]; ?></option>
									<option value="54"><?php echo $enmse_booknames[54]; ?></option>
									<option value="55"><?php echo $enmse_booknames[55]; ?></option>
									<option value="56"><?php echo $enmse_booknames[56]; ?></option>
									<option value="57"><?php echo $enmse_booknames[57]; ?></option>
									<option value="58"><?php echo $enmse_booknames[58]; ?></option>
									<option value="59"><?php echo $enmse_booknames[59]; ?></option>
									<option value="60"><?php echo $enmse_booknames[60]; ?></option>
									<option value="61"><?php echo $enmse_booknames[61]; ?></option>
									<option value="62"><?php echo $enmse_booknames[62]; ?></option>
									<option value="63"><?php echo $enmse_booknames[63]; ?></option>
									<option value="64"><?php echo $enmse_booknames[64]; ?></option>
									<option value="65"><?php echo $enmse_booknames[65]; ?></option>
									<option value="66"><?php echo $enmse_booknames[66]; ?></option>
								</select>
								<input id='scripture_start_chapter' name='scripture_start_chapter' type='text' value='Chapter' tabindex="16" size="10" /> :
								<input id='scripture_start_verse' name='scripture_start_verse' type='text' value='Verse' tabindex="17" size="10" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">End Verse:</th>
							<td>
								<select name="scripture_end_book" id="scripture_end_book" class="enmse-disabled" disabled>
									<option value="1"><?php echo $enmse_booknames[1]; ?></option>
									<option value="2"><?php echo $enmse_booknames[2]; ?></option>
									<option value="3"><?php echo $enmse_booknames[3]; ?></option>
									<option value="4"><?php echo $enmse_booknames[4]; ?></option>
									<option value="5"><?php echo $enmse_booknames[5]; ?></option>
									<option value="6"><?php echo $enmse_booknames[6]; ?></option>
									<option value="7"><?php echo $enmse_booknames[7]; ?></option>
									<option value="8"><?php echo $enmse_booknames[8]; ?></option>
									<option value="9"><?php echo $enmse_booknames[9]; ?></option>
									<option value="10"><?php echo $enmse_booknames[10]; ?></option>
									<option value="11"><?php echo $enmse_booknames[11]; ?></option>
									<option value="12"><?php echo $enmse_booknames[12]; ?></option>
									<option value="13"><?php echo $enmse_booknames[13]; ?></option>
									<option value="14"><?php echo $enmse_booknames[14]; ?></option>
									<option value="15"><?php echo $enmse_booknames[15]; ?></option>
									<option value="16"><?php echo $enmse_booknames[16]; ?></option>
									<option value="17"><?php echo $enmse_booknames[17]; ?></option>
									<option value="18"><?php echo $enmse_booknames[18]; ?></option>
									<option value="19"><?php echo $enmse_booknames[19]; ?></option>
									<option value="20"><?php echo $enmse_booknames[20]; ?></option>
									<option value="21"><?php echo $enmse_booknames[21]; ?></option>
									<option value="22"><?php echo $enmse_booknames[22]; ?></option>
									<option value="23"><?php echo $enmse_booknames[23]; ?></option>
									<option value="24"><?php echo $enmse_booknames[24]; ?></option>
									<option value="25"><?php echo $enmse_booknames[25]; ?></option>
									<option value="26"><?php echo $enmse_booknames[26]; ?></option>
									<option value="27"><?php echo $enmse_booknames[27]; ?></option>
									<option value="28"><?php echo $enmse_booknames[28]; ?></option>
									<option value="29"><?php echo $enmse_booknames[29]; ?></option>
									<option value="30"><?php echo $enmse_booknames[30]; ?></option>
									<option value="31"><?php echo $enmse_booknames[31]; ?></option>
									<option value="32"><?php echo $enmse_booknames[32]; ?></option>
									<option value="33"><?php echo $enmse_booknames[33]; ?></option>
									<option value="34"><?php echo $enmse_booknames[34]; ?></option>
									<option value="35"><?php echo $enmse_booknames[35]; ?></option>
									<option value="36"><?php echo $enmse_booknames[36]; ?></option>
									<option value="37"><?php echo $enmse_booknames[37]; ?></option>
									<option value="38"><?php echo $enmse_booknames[38]; ?></option>
									<option value="39"><?php echo $enmse_booknames[39]; ?></option>
									<option value="40"><?php echo $enmse_booknames[40]; ?></option>
									<option value="41"><?php echo $enmse_booknames[41]; ?></option>
									<option value="42"><?php echo $enmse_booknames[42]; ?></option>
									<option value="43"><?php echo $enmse_booknames[43]; ?></option>
									<option value="44"><?php echo $enmse_booknames[44]; ?></option>
									<option value="45"><?php echo $enmse_booknames[45]; ?></option>
									<option value="46"><?php echo $enmse_booknames[46]; ?></option>
									<option value="47"><?php echo $enmse_booknames[47]; ?></option>
									<option value="48"><?php echo $enmse_booknames[48]; ?></option>
									<option value="49"><?php echo $enmse_booknames[49]; ?></option>
									<option value="50"><?php echo $enmse_booknames[50]; ?></option>
									<option value="51"><?php echo $enmse_booknames[51]; ?></option>
									<option value="52"><?php echo $enmse_booknames[52]; ?></option>
									<option value="53"><?php echo $enmse_booknames[53]; ?></option>
									<option value="54"><?php echo $enmse_booknames[54]; ?></option>
									<option value="55"><?php echo $enmse_booknames[55]; ?></option>
									<option value="56"><?php echo $enmse_booknames[56]; ?></option>
									<option value="57"><?php echo $enmse_booknames[57]; ?></option>
									<option value="58"><?php echo $enmse_booknames[58]; ?></option>
									<option value="59"><?php echo $enmse_booknames[59]; ?></option>
									<option value="60"><?php echo $enmse_booknames[60]; ?></option>
									<option value="61"><?php echo $enmse_booknames[61]; ?></option>
									<option value="62"><?php echo $enmse_booknames[62]; ?></option>
									<option value="63"><?php echo $enmse_booknames[63]; ?></option>
									<option value="64"><?php echo $enmse_booknames[64]; ?></option>
									<option value="65"><?php echo $enmse_booknames[65]; ?></option>
									<option value="66"><?php echo $enmse_booknames[66]; ?></option>
								</select>
								<input id='scripture_end_chapter' name='scripture_end_chapter' type='text' value='Chapter' size="10" class="enmse-disabled" disabled /> :
								<input id='scripture_end_verse' name='scripture_end_verse' type='text' value='Verse' tabindex="18" size="10" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Translation:</th>
							<td>
								<select name="scripture_trans" id="scripture_trans" tabindex="19">
									<option value="<?php echo $deftrans; ?>">------ ENGLISH ------</option>
									<option value="1588"<?php if ( $deftrans == 1588 ) { echo " selected=\"selected\""; } ?>>AMP - Amplified Bible</option>
									<option value="12"<?php if ( $deftrans == 12 ) { echo " selected=\"selected\""; } ?>>ASV - American Standard Version</option>
									<option value="1713"<?php if ( $deftrans == 1713 ) { echo " selected=\"selected\""; } ?>>CSB - Christian Standard Bible</option>
									<option value="37"<?php if ( $deftrans == 37 ) { echo " selected=\"selected\""; } ?>>CEB - Common English Bible</option>
									<option value="59"<?php if ( $deftrans == 59 ) { echo " selected=\"selected\""; } ?>>ESV - English Standard Version</option>
									<option value="72"<?php if ( $deftrans == 72 ) { echo " selected=\"selected\""; } ?>>HCSB - Holman Christian Standard Bible</option>
									<option value="1359"<?php if ( $deftrans == 1359 ) { echo " selected=\"selected\""; } ?>>ICB - International Childrens Bible</option>
									<option value="1"<?php if ( $deftrans == 1 ) { echo " selected=\"selected\""; } ?>>KJV - King James Version</option>
									<option value="1171"<?php if ( $deftrans == 1171 ) { echo " selected=\"selected\""; } ?>>MEV - Modern English Version</option>
									<option value="97"<?php if ( $deftrans == 97 ) { echo " selected=\"selected\""; } ?>>MSG - The Message</option>
									<option value="100"<?php if ( $deftrans == 100 ) { echo " selected=\"selected\""; } ?>>NASB - New American Standard Bible</option>
									<option value="111"<?php if ( $deftrans == 111 ) { echo " selected=\"selected\""; } ?>>NIV - New International Version</option>
									<option value="114"<?php if ( $deftrans == 114 ) { echo " selected=\"selected\""; } ?>>NKJV - New King James Version</option>
									<option value="116"<?php if ( $deftrans == 116 ) { echo " selected=\"selected\""; } ?>>NLT - New Living Translation</option>
									<option value="2016"<?php if ( $deftrans == 2016 ) { echo " selected=\"selected\""; } ?>>NRSV - New Revised Standard Version</option>
									<option value="<?php echo $deftrans; ?>">------ CHINESE ------</option>
									<option value="48"<?php if ( $deftrans == 48 ) { echo " selected=\"selected\""; } ?>>CUNPSS-神 - 新标点和合本, 神版</option>
									<option value="414"<?php if ( $deftrans == 414 ) { echo " selected=\"selected\""; } ?>>CUNP-上帝 - 新標點和合本, 神版</option>
									<option value="<?php echo $deftrans; ?>">------ CZECH ------</option>
									<option value="15"<?php if ( $deftrans == 15 ) { echo " selected=\"selected\""; } ?>>B21 - Bible 21</option>
									<option value="162"<?php if ( $deftrans == 162 ) { echo " selected=\"selected\""; } ?>>BCZ - Slovo na cestu</option>
									<option value="44"<?php if ( $deftrans == 44 ) { echo " selected=\"selected\""; } ?>>BKR - Bible Kralica 1613</option>
									<option value="509"<?php if ( $deftrans == 509 ) { echo " selected=\"selected\""; } ?>>CSP - Cesky studijni preklad</option>
									<option value="<?php echo $deftrans; ?>">------ DUTCH ------</option>
									<option value="1276"<?php if ( $deftrans == 1276 ) { echo " selected=\"selected\""; } ?>>BB - BasisBijbel</option>
									<option value="1990"<?php if ( $deftrans == 1990 ) { echo " selected=\"selected\""; } ?>>HSV - Herziene Statenvertaling</option>
									<option value="75"<?php if ( $deftrans == 75 ) { echo " selected=\"selected\""; } ?>>HTB - Het Boek</option>
									<option value="328"<?php if ( $deftrans == 328 ) { echo " selected=\"selected\""; } ?>>NBG51 - NBG-vertaling 1951</option>
									<option value="165"<?php if ( $deftrans == 165 ) { echo " selected=\"selected\""; } ?>>SV-RJ - Statenvertaling</option>
									<option value="<?php echo $deftrans; ?>">------ FRENCH ------</option>
									<option value="2367"<?php if ( $deftrans == 2367 ) { echo " selected=\"selected\""; } ?>>NFC - Nouvelle Français Courant</option>
									<option value="133"<?php if ( $deftrans == 133 ) { echo " selected=\"selected\""; } ?>>PDV2017 - Parole de Vie 2017</option>
									<option value="<?php echo $deftrans; ?>">------ GERMAN ------</option>
									<option value="57"<?php if ( $deftrans == 57 ) { echo " selected=\"selected\""; } ?>>ELB - Elberfelder 1905</option>
									<option value="51"<?php if ( $deftrans == 51 ) { echo " selected=\"selected\""; } ?>>DELUT - Lutherbibel 1912</option>
									<option value="73"<?php if ( $deftrans == 73 ) { echo " selected=\"selected\""; } ?>>HFA - Hoffnung für alle</option>
									<option value="877"<?php if ( $deftrans == 877 ) { echo " selected=\"selected\""; } ?>>NBH - NeÜ Bibel.heute</option>
									<option value="108"<?php if ( $deftrans == 108 ) { echo " selected=\"selected\""; } ?>>NGU2011 - Neue Genfer Übersetzung</option>
									<option value="157"<?php if ( $deftrans == 157 ) { echo " selected=\"selected\""; } ?>>SCH2000 - Schlachter 2000</option>
									<option value="<?php echo $deftrans; ?>">------ JAPANESE ------</option>
									<option value="83"<?php if ( $deftrans == 83 ) { echo " selected=\"selected\""; } ?>>JCB - リビングバイブル</option>
									<option value="1819"<?php if ( $deftrans == 1819 ) { echo " selected=\"selected\""; } ?>>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
									<option value="1820"<?php if ( $deftrans == 1820 ) { echo " selected=\"selected\""; } ?>>口語訳 Japanese: 聖書　口語訳</option>
									<option value="<?php echo $deftrans; ?>">------ RUSSIAN ------</option>
									<option value="400"<?php if ( $deftrans == 400 ) { echo " selected=\"selected\""; } ?>>SYNO - Синодальный Перевод</option>
									<option value="143"<?php if ( $deftrans == 143 ) { echo " selected=\"selected\""; } ?>>НРП - Новый Русский Перевод</option>
									<option value="1999"<?php if ( $deftrans == 1999 ) { echo " selected=\"selected\""; } ?>>СРП-2 - Современный Русский Перевод</option>
									<option value="<?php echo $deftrans; ?>">------ SPANISH ------</option>
									<option value="149"<?php if ( $deftrans == 149 ) { echo " selected=\"selected\""; } ?>>RVR1960 - Biblia Reina Valera 1960</option>
									<option value="128"<?php if ( $deftrans == 128 ) { echo " selected=\"selected\""; } ?>>NVI - La Santa Biblia, Nueva Version Internacional</option>
									<option value="<?php echo $deftrans; ?>">------ TURKISH ------</option>
									<option value="170"<?php if ( $deftrans == 170 ) { echo " selected=\"selected\""; } ?>>TCL02 - Kutsal Kitap Yeni Ceviri</option>
									<option value="<?php echo $deftrans; ?>">------ OTHER ------</option>
									<option value="6"<?php if ( $deftrans == 6 ) { echo " selected=\"selected\""; } ?>>AFR83 - Afrikaans 1983</option>
								</select>
							</td>
						</tr>
							<tr valign="top">
							<th scope="row">Focus Passage?:
								<p class="se-form-instructions">Is this the main (or one of the main) passages for this <?php echo $enmsemessaget; ?>?</p>
							</th>
							<td>
								<input name="scripture_focus" id="scripture_focus" type="checkbox" class="check" tabindex="20" />
							</td>
						</tr>
					</table>
					<input type="hidden" name="scripture_username" value="<?php echo $enmse_userdetails->user_login; ?>" id="scripture_username" />
			
					<a href="#" id="addnewscripture" class="button">Attach New Scripture Reference</a>
				</div>
				<br />
				<br />
			</div>
			
			<div id="enmse-podcast-content" style="display: none">
				<p>Upload an audio or video file to use for your podcasts. If your server supports it, Series Engine will automatically populate the "length" and "file size" fields for most media. Learn more about <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-podcasts"; ?>" class="enmse-learn-more">Podcasting with the Series Engine...</a></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Audio Length:</th>
						<td><input id='message_length' name='message_length' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_length'];} ?>' tabindex="21" /> <span class="se-form-instructions">ex: 31:46</span></td>
					</tr>
					<tr valign="top">
						<th scope="row">Audio URL:</th>
						<td><input id='message_audio_url_dummy' name='message_audio_url_dummy' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_audio_url']);} ?>" tabindex="22" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;TB_iframe=1', __FILE__ ); ?>" class="thickbox se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
					</tr>
					<tr valign="top">
						<th scope="row">Audio File Size:</th>
						<td><input id='message_audio_file_size' name='message_audio_file_size' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_audio_file_size'];} ?>' tabindex="23" /> <span class="se-form-instructions">In bytes, ex: 123456789</span><br /><br /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Video Length:</th>
						<td><input id='message_video_length' name='message_video_length' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_video_length'];} ?>' tabindex="24" /> <span class="se-form-instructions">ex: 31:46</span></td>
					</tr>
					<tr valign="top">
						<th scope="row">Video URL:</th>
						<td><input id='message_video_url' name='message_video_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_video_url']);} ?>" tabindex="25" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Video File Size:</th>
						<td><input id='message_video_file_size' name='message_video_file_size' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_video_file_size'];} ?>' tabindex="26" /> <span class="se-form-instructions">In bytes, ex: 123456789</span></td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Podcast Image:
							<p class="se-form-instructions">Use a specific image just for this <?php echo $enmsemessaget; ?> in your podcast feeds (overriding the image of the associated <?php echo $enmseseriest; ?>, if set). The image must be at least 1400px x 1400px with a max size of 3000px x 3000px.</p>	
						</th>
						<td><input id='message_podcast_image' name='message_podcast_image' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_podcast_image'];} ?>' tabindex="27" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=image&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-podcast-image se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="message-podcast-image-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['message_podcast_image'])) { ?><br /><img src="<?php echo $_POST['message_podcast_image']; ?>" /><?php } ?></div></td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Include <?php echo $enmseseriest; ?> Info in Podcast Title?:
							<p class="se-form-instructions">Do you want "- <?php echo $enmseseriest; ?> Name" appended to the end of your podcast title?</p>
						</th>
						<td>
							<select name="message_podcast_series" id="message_podcast_series" tabindex="16">
								<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_podcast_series'] == "1") { ?>selected="selected"<?php }} elseif ($default_podcast_series == 1) { ?>selected="selected"<?php } ?>>Yes</option>
								<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_podcast_series'] == "0") { ?>selected="selected"<?php }} elseif ($default_podcast_series == 0) { ?>selected="selected"<?php } ?>>No</option>
							</select>
						</td>
					</tr>
				</table>
			</div>
			
			<div id="enmse-related-files" style="display: none">
				<p>Attach a link or file download to appear in the <?php echo $enmsemessaget; ?>'s "Details" section. This is great for sign up links, study guides, etc. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-uploadfiles"; ?>" class="enmse-learn-more">Learn more about this feature...</a></p>
				
					<div id="enmsefilearea">
					<?php if ( !empty($enmse_files) ) { ?>
						<script type="text/javascript">
						jQuery(document).ready(function(){
							var fixHelper = function(e, ui) {
								ui.children().each(function() {
									jQuery(this).width(jQuery(this).width());
								});
								return ui;
							};
							jQuery("#filestable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
								var order = jQuery(this).sortable("serialize");
								jQuery.ajax({
									method: "POST",
							        url: seajax.ajaxurl, 
							        data: {
							            'action': 'seriesengine_ajaxsortfiles',
							            'frow': order
							        },
							        success:function(data) {

							        },
							        error: function(errorThrown){
							            console.log(errorThrown);
							        }
							    });
							}});
						});
						</script>
					<br />
					<h3>Links and Downloads Currently Associated with This <?php echo $enmsemessaget; ?>...</h3>
					<table class="widefat" id="filestable"> 
						<thead> 
							<tr> 
								<th>Sort</th> 
								<th>Name</th> 
								<th>URL</th>
								<th>Opens In...</th>
								<th>Featured?</th>
								<th>Delete?</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($enmse_files as $file) {  ?>
							<tr id="row_<?php echo $file->file_id; ?>">
								<td class="enmse-sort"></td>
								<td><a href="#" class="seriesengine_editfile" name="<?php echo $file->file_id; ?>"><?php echo $file->file_name; ?></a></td>
								<td><a href="<?php echo $file->file_url; ?>" target="_blank"><?php echo $file->file_url; ?></a></td>
								<td><?php if ( $file->file_new_window == 0 ) { echo "Same Window"; } else { echo "New Window"; } ?></td>
								<td><?php if ( $file->featured == 1 ) { echo "Yes"; }; ?></td>
								<td class="enmse-delete"><a href="#" class="seriesengine_filedelete" name="<?php echo $file->file_id; ?>" rel="<?php echo $file->featured; ?>">Delete</a></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
					<br />
					<br />
					<?php } ?>
				</div>

				<div id="enmsefileform">
					<h3>Attach a Link or Download</h3>		
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Name:</th>
							<td><input id='file_name' name='file_name' type='text' value="" tabindex="28" /></td>
						</tr>
						<tr valign="top">
							<th scope="row">Link/File URL:</th>
							<td><input id='file_url' name='file_url' type='text' value='' tabindex="29" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-file se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
						</tr>
						<tr valign="top">
							<th scope="row">How to Open Link:</th>
							<td>
								<select name="file_new_window" id="file_new_window" tabindex="30">
									<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['file_new_window'] == 0) { ?>selected="selected"<?php }} ?>>Same Window</option>
									<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['file_new_window'] == 1) { ?>selected="selected"<?php }} ?>>New Window</option>
								</select>
							</td>
						</tr>
							<tr valign="top">
							<th scope="row">Featured?:
								<p class="se-form-instructions">Featured Attachments/Links will be shown in the Related <?php echo $enmsemessagetp; ?> views. Only ONE can be featured per <?php echo $enmsemessaget; ?>.</p>
							</th>
							<td>
								<input name="file_featured" id="file_featured" type="checkbox" class="check" tabindex="31" />
							</td>
						</tr>
					</table>
					<input type="hidden" name="file_username" value="<?php echo $enmse_userdetails->user_login; ?>" id="file_username" />
			
					<a href="#" id="addnewfile" class="button">Attach New Link/Download</a>
				</div>

				<br />
				<br />
			</div>
			
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add New <?php echo $enmsemessaget; ?>" tabindex="32" /></p>
		</form>		
		<input type="hidden" name="enmsepluginurl" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/newtopicslist.php" id="enmsepluginurl" />
		<input type="hidden" name="enmsespeakerurl" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/newspeakerslist.php" id="enmsespeakerurl" />
		<input type="hidden" name="enmsemid" value="0" id="enmsemid" />
		<input type="hidden" name="enmsefileurl" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/newfile.php" id="enmsefileurl" />
		<input type="hidden" name="enmsefiledelete" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/filedelete.php" id="enmsefiledelete" />
		<input type="hidden" name="enmsefileedit" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/fileedit.php" id="enmsefileedit" />
		<input type="hidden" name="enmsescriptureurl" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/newscripture.php" id="enmsescriptureurl" />
		<input type="hidden" name="xxse" value="<?php echo base64_encode(ABSPATH); ?>" id="xxse" />
		<input type="hidden" name="enmsescripturedelete" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/scripturedelete.php" id="enmsescripturedelete" />
		<input type="hidden" name="enmsescriptureedit" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/scriptureedit.php" id="enmsescriptureedit" />
		<input type="hidden" name="enmsethumb" value="<?php echo $enmse_embedwidth; ?>" id="enmsethumb" />
		<input type="hidden" name="message_current_primary_series" value="<?php if ($_POST) { echo $_POST['message_primary_series']; } else { echo 0; } ?>" id="current_primary_series" />
		<input type="hidden" name="series_title_text" value="<?php echo $enmseseriest; ?>" id="series_title_text" />

		<p><a href="<?php if ( isset($_GET['enmse_p']) ) { if ( isset($_GET['enmse_mid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_mid=' . $enmse_mid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ );} } else { if ( isset($_GET['enmse_mid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_mid=' . $enmse_mid, __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php', __FILE__ ); }} ?>">&laquo; All Messages</a></p>
		<?php include ('secredits.php'); ?>
<?php } elseif ( ($_GET['enmse_action'] == 'edit') && ( $enmse_singlecount == 1 ) ) { // Edit Message ?>
	<link rel='stylesheet' href='<?php echo plugins_url() .'/seriesengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#message_date").datepicker({ dateFormat: 'yy-mm-dd' });
			jQuery("#message_alternate_date").datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/message_options283.js'; ?>"></script>

	<h2 class="enmse">Edit <?php echo $enmsemessaget; ?> <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Fill out the form fields below to update the <?php echo $enmsemessaget; ?> in the Series Engine. Remember that a <?php echo $enmsemessaget; ?> will not be publicly available unless you supply a video embed, audio file or alternate video embed. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-messages"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmsemessagetp; ?>...</a></p>
	
	<ul id="enmse-message-options">
		<li class="selected"><a href="#" id="enmse-message-general">General Information</a></li>
		<li><a href="#" id="enmse-message-video">Advanced Settings</a></li>
		<li <?php if ( $bibleoption == 0 ) { echo "style=\"display: none\""; }; ?>><a href="#" id="enmse-message-scripture">Scripture</a></li>
		<li><a href="#" id="enmse-message-podcast">Podcast Details</a></li>
		<li><a href="#" id="enmse-message-files">Links/Downloads</a></li>
	</ul>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmseform">
		<div id="enmse-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Title:</strong></th>
					<td><input id='message_title' name='message_title' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['message_title']));} else {echo htmlspecialchars(stripslashes($enmse_single->title));} ?>" tabindex='1' /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong><?php echo $enmsespeakert; ?>:</strong></th>
					<td>
						<select name="message_speaker" id="message_speaker" tabindex="2">
							<option value="0">- Select a <?php echo $enmsespeakert; ?> -</option>
							<option value="0">-----------------</option>
							<option value="n">Add a New <?php echo $enmsespeakert; ?></option>
							<option value="0">-----------------</option>
							<?php foreach ($enmse_sp as $sp) {  ?>
							<option value="<?php echo $sp->speaker_id; ?>" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_speaker'] == $sp->speaker_id) { ?>selected="selected"<?php }} else { if ( $enmse_speaker->speaker_id == $sp->speaker_id ) { ?>selected="selected"<?php }} ?>><?php echo stripslashes($sp->first_name) . " " . stripslashes($sp->last_name); ?></option>
							<?php } ?>
						</select><br />
						<div id="newspeakersection" style="display: none">
							<input id='speaker_first_name' name='speaker_first_name' size='10' type='text' style="color: #cbcbcb" value='First' />
							<input id='speaker_last_name' name='speaker_last_name' size='10' type='text' style="color: #cbcbcb" value='Last' />
							<a href="#" id="addnewspeaker" class="button">Add New Speaker</a>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Date:</strong></th>
					<td><input id='message_date' name='message_date' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_date'];} else {echo $enmse_single->date;} ?>' tabindex="3" /> <span class="se-form-instructions">ex: 2012-01-01</span></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Description:
						<p class="se-form-instructions">A brief description of the <?php echo $enmsemessaget; ?> for your viewers.</p>
					</th>
					<td>
						<textarea name="message_description" id="message_description" rows="4" cols="40" tabindex="4"><?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['message_description']));} else {echo htmlspecialchars(stripslashes($enmse_single->description));} ?></textarea><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Audio URL:</th>
					<td><input id='message_audio_url' name='message_audio_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_audio_url']);} else {if ($enmse_single->audio_url != "0") {echo stripslashes($enmse_single->audio_url);}} ?>" tabindex="5" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=file&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-audio se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Video Embed Code:
						<p class="se-form-instructions">Paste an iframe embed code, or just the URL if you're using Vimeo, YouTube, or Facebook.<br /><br />
						<em>This will override the Video URL below and display this embed instead.</em><br /><br />
						<em>Choose a large or responsive width for your embed code; Series Engine will automatically size it down for mobile devices.</em></p>
					</th>
					<td>
						<textarea name="message_embed_code" id="message_embed_code" rows="6" cols="40" tabindex="6"><?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_embed_code']);} else {if ($enmse_single->embed_code != "0") {echo stripslashes($enmse_single->embed_code);}} ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						(or) Video URL:
						<p class="se-form-instructions"><em>Direct file paths to .mp4 files only; NO embed codes.</em></p>
					</th>
					<td><input id='message_video_embed_url' name='message_video_embed_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_video_embed_url']);} else {if ($enmse_single->video_embed_url != "0") {echo stripslashes($enmse_single->video_embed_url);}} ?>" tabindex="7" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=file&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-video se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
				</tr>
				<tr valign="top">
					<th scope="row">Add to <?php echo $enmseseriest; ?>:</th>
					<td>
						<?php if ( !empty($enmse_s) ) { ?>
						<ul class="enmse-series-topic">
						<?php foreach ($enmse_s as $s) {  ?>
							<?php if ( $_POST && !empty($enmse_errors) ) { ?>
							<li><input name="series[]" type="checkbox" value="<?php echo $s->series_id; ?>" <?php if (isset($_POST['series']) && $_POST['series'] != NULL) {foreach ($_POST['series'] as $ps) { if ($ps == $s->series_id) { ?>checked="checked"<?php }}} ?> class="check seriescheck" title="<?php echo stripslashes($s->s_title); ?>" /> <label for="series[]"> <?php echo stripslashes($s->s_title); ?></label></li>
							<?php } else { ?>
							<li><input name="series[]" type="checkbox" value="<?php echo $s->series_id; ?>" <?php if ($enmse_msmm != NULL) {foreach ($enmse_msmm as $msmm) { if ($msmm->series_id == $s->series_id) { ?>checked="checked"<?php }}} ?> class="check seriescheck" title="<?php echo stripslashes($s->s_title); ?>" /> <label for="series[]"> <?php echo stripslashes($s->s_title); ?></label></li>	
							<?php } ?>
						<?php }; ?>
						</ul>
						<?php } else { echo '<p>Add a ' . $enmseseriest . ' in the "Edit ' . $enmseseriestp . '" menu.</p>'; } ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Primary <?php echo $enmseseriest; ?>:
						<p class="se-form-instructions">The graphic for this <?php echo $enmseseriest; ?> will be shown in Related <?php echo $enmsemessagetp; ?> lists and as the podcast image for this <?php echo $enmsemessaget; ?>.</p>
					</th>
					<td>
						<select name="message_primary_series" id="message_primary_series" tabindex="8">
							<?php if ( $_POST && !empty($enmse_errors) ) { ?>
							<?php if ( !isset($_POST['series']) ) { ?><option value="0">- No <?php echo $enmseseriest; ?> Assigned -</option><?php } ?>
							<?php foreach ($enmse_ss as $s) {  
								if ( isset($_POST['series']) && $_POST['series'] != NULL) {
									foreach ($_POST['series'] as $msmm) { 
										if ($msmm == $s->series_id) { ?>
							<option value="<?php echo $s->series_id; ?>" <?php if ($_POST['message_primary_series'] == $s->series_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($s->s_title); ?></option>
							<?php }}}} ?>
							<?php } else { ?>
							<?php if ( empty($enmse_msmm) ) { ?><option value="0">- No <?php echo $enmseseriest; ?> Assigned -</option><?php } ?>
							<?php foreach ($enmse_ss as $s) {  
								if ($enmse_msmm != NULL) {
									foreach ($enmse_msmm as $msmm) { 
										if ($msmm->series_id == $s->series_id) { ?>
							<option value="<?php echo $s->series_id; ?>" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_primary_series'] == $s->series_id) { ?>selected="selected"<?php }} else { if ( $enmse_single->primary_series == $s->series_id ) { ?>selected="selected"<?php }} ?>><?php echo stripslashes($s->s_title); ?></option>
							<?php }}}} ?>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Associate with <?php echo $enmsetopict; ?>:</th>
					<td>
						<input id='topic_name' name='topic_name' type='text' value='' />
						<a href="#" id="addnewtopic" class="button">Add New <?php echo $enmsetopict; ?></a>
						<?php if ( !empty($enmse_t) ) { ?>
						<ul id="enmse-topiclist" class="enmse-series-topic">
						<?php foreach ($enmse_t as $t) {  ?>
							<?php if ( $_POST && !empty($enmse_errors) ) { ?>
							<li><input name="topics[]" type="checkbox" value="<?php echo $t->topic_id; ?>" <?php if (isset($_POST['topics']) && $_POST['topics'] != NULL) {foreach ($_POST['topics'] as $pt) { if ($pt == $t->topic_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="topics[]"> <?php echo stripslashes($t->name); ?></label></li>
							<?php } else { ?>
							<li><input name="topics[]" type="checkbox" value="<?php echo $t->topic_id; ?>" <?php if ($enmse_mmtm != NULL) {foreach ($enmse_mmtm as $mmtm) { if ($mmtm->topic_id == $t->topic_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="topics[]"> <?php echo stripslashes($t->name); ?></label></li>	
							<?php } ?>
						<?php }; ?>
						</ul>
						<?php } else { echo '<p>Add a ' . $enmsetopict . ' above or in the "Edit ' . $enmsetopictp . '" menu.</p>'; } ?>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="enmse-additional-video" style="display: none">
			<p>Add an alternate date, override the <?php echo $enmseseriest; ?> thumbnail, or add an additional piece of video to the <?php echo $enmsemessaget; ?>.</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Alternate Date:</th>
					<td><input id='message_alternate_date' name='message_alternate_date' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_alternate_date'];} else {if ($enmse_single->alternate_date != '0000-00-00') {echo $enmse_single->alternate_date;}} ?>' tabindex="9" /> <span class="se-form-instructions">ex: 2012-01-08</span></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php echo $enmsemessaget; ?> Thumbnail:
						<p class="se-form-instructions">Optional override to <?php echo $enmseseriest; ?> graphic. According to your settings, design the graphic to be <strong><?php echo $enmse_embedwidth; ?>px</strong> wide.</p>	
					</th>
					<td><input id='message_thumbnail' name='message_thumbnail' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_thumbnail'];} else {echo $enmse_single->message_thumbnail;} ?>' tabindex="10" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=image&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-graphic se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="message-thumb-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['message_thumbnail'])) { ?><br /><img src="<?php echo $_POST['message_thumbnail']; ?>" /><?php } elseif ( $enmse_single->message_thumbnail != NULL ) { ?><br /><img src="<?php echo $enmse_single->message_thumbnail ?>" /><?php }; ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row">Additional Video?:</th>
					<td>
						<select name="message_alternate_toggle" id="message_alternate_toggle" tabindex="11">
							<option value="No" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_alternate_toggle'] == "No") { ?>selected="selected"<?php }} else {if ($enmse_single->alternate_toggle == "No") { ?>selected="selected"<?php }} ?>>No</option>
							<option value="Yes" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_alternate_toggle'] == "Yes") { ?>selected="selected"<?php }} else {if ($enmse_single->alternate_toggle == "Yes") { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Label:</th>
					<td>
						<input id='message_alternate_label' name='message_alternate_label' type='text' onKeyDown="limitText(this.form.limitedtextfield,this.form.countdown,10);" onKeyUp="limitText(this.form.limitedtextfield,this.form.countdown,10);" maxlength="10" value="<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_alternate_label'];} else {echo htmlspecialchars(stripslashes($enmse_single->alternate_label));} ?>" tabindex="12" />
						<span class="se-form-instructions">&nbsp;Ex: Trailer, Music, etc.</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Additional Embed Code:
						<p class="se-form-instructions">Paste an iframe embed code, or just the URL if you're using Vimeo, YouTube, or Facebook.<br /><br />
						<em>Choose a large width for your embed code; Series Engine will automatically size it down for mobile devices.</em></p>
					</th>
					<td>
						<textarea name="message_alternate_embed" id="message_alternate_embed" rows="6" cols="40" tabindex="13"><?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_alternate_embed'];} else {if ($enmse_single->alternate_embed != "0") {echo stripslashes($enmse_single->alternate_embed);}} ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						(or) Additional Video URL:
						<p class="se-form-instructions">This will override the embed code above and embed this video clip instead.<br /><br />
						<em>Direct file paths to .mp4 files only; NO embed codes.</em></p>
					</th>
					<td><input id='message_additional_video_embed_url' name='message_additional_video_embed_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_additional_video_embed_url']);} else {if ($enmse_single->additional_video_embed_url != "0") {echo stripslashes($enmse_single->additional_video_embed_url);}} ?>" tabindex="14" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=file&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-additional-video se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Adjust Permalink: 
						<p class="se-form-instructions">Adjust the pretty, SEO friendly URL for this <?php echo $enmsemessaget; ?>. If changed, <em>the old permalink will no longer work</em>.</p>
					</th>
					<td>
						<?php echo "/" . $permalinkslug . "/"; ?><input id='message_permalink' name='message_permalink' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_permalink'];} elseif ( !empty($enmse_singlecpt) ) {echo stripslashes($enmse_singlecpt->post_name);} ?>" tabindex="15" <?php if ( empty($enmse_singlecpt) ) { echo "disabled=\"disabled\""; } ?> />/
						<?php if ( empty($enmse_singlecpt) ) { echo "<span style=\"font-size: 11px\"><br />(Save this " . $enmsemessaget . " or run the permalink updater on the Import/Export page to generate a permalink for this " . $enmsemessaget . ".)</span>"; } ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Display Prefix in Permalink Title?:
						<p class="se-form-instructions">Do you want the "<?php echo $enmsemessaget; ?>:" prefix displayed in the permalink title?</p>
					</th>
					<td>
						<select name="message_permalink_prefix" id="message_permalink_prefix" tabindex="16">
							<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_prefix'] == "1") { ?>selected="selected"<?php }} elseif ( $enmse_single->permalink_prefix == 1 || $enmse_single->permalink_prefix == NULL ) { ?>selected="selected"<?php } ?>>Yes</option>
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_prefix'] == "0") { ?>selected="selected"<?php }} elseif ( $enmse_single->permalink_prefix == 0 && $enmse_single->permalink_prefix != NULL ) { ?>selected="selected"<?php } ?>>No</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Display Speaker in Permalink Title?:
						<p class="se-form-instructions">Do you want to append "by Speaker Name" at the end of the permalink title?</p>
					</th>
					<td>
						<select name="message_permalink_speaker" id="message_permalink_speaker" tabindex="17">
							<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_speaker'] == "1") { ?>selected="selected"<?php }} elseif ( $enmse_single->permalink_speaker == 1 || $enmse_single->permalink_speaker == NULL ) { ?>selected="selected"<?php } ?>>Yes</option>
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_speaker'] == "0") { ?>selected="selected"<?php }} elseif ( $enmse_single->permalink_speaker == 0 && $enmse_single->permalink_speaker != NULL ) { ?>selected="selected"<?php } ?>>No</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Allow Permalink Comments?:
						<p class="se-form-instructions">Do you want to allow comments on the permalink page for this <?php echo $enmsemessaget; ?>?</p>
					</th>
					<td>
						<select name="message_permalink_comments" id="message_permalink_comments" tabindex="18">
							<option value="closed" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_comments'] == "closed") { ?>selected="selected"<?php }} ?>>No</option>
							<option value="open" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_permalink_comments'] == "open") { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
			</table>
		</div>

		<div id="enmse-scripture" style="display: none">
			<p>Add scripture references which will appear in this <?php echo $enmsemessaget; ?>'s "Details" section. "Focus" passages will also appear in the Related <?php echo $enmsemessagetp ?> lists, and the <?php echo $enmsemessaget; ?> will be associated with the chosen book when users filter <?php echo $enmsemessagetp; ?> by Book. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-scripture"; ?>" class="enmse-learn-more">Learn more about this feature...</a></p>
			<div id="enmsescripturearea">
				<?php if ( !empty($enmse_scriptures) ) { ?>
					<script type="text/javascript">
					jQuery(document).ready(function(){
						var fixHelper = function(e, ui) {
							ui.children().each(function() {
								jQuery(this).width(jQuery(this).width());
							});
							return ui;
						};
						jQuery("#scripturetable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
							var order = jQuery(this).sortable("serialize");
							jQuery.ajax({
								method: "POST",
						        url: seajax.ajaxurl, 
						        data: {
						            'action': 'seriesengine_ajaxsortscripture',
						            'row': order
						        },
						        success:function(data) {
						        },
						        error: function(errorThrown){
						            console.log(errorThrown);
						        }
						    });
						}});
					});
					</script>
				<br />
				<h3>Scripture References Currently Associated with This <?php echo $enmsemessaget; ?>...</h3>
				<table class="widefat" id="scripturetable"> 
					<thead> 
						<tr> 
							<th>Sort</th> 
							<th>Reference</th> 
							<th>URL</th>
							<th>Focus Passage?</th>
							<th>Delete?</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($enmse_scriptures as $scripture) {  ?>
						<tr id="row_<?php echo $scripture->scripture_id; ?>">
							<td class="enmse-sort"></td>
							<td><a href="#" class="seriesengine_editscripture" name="<?php echo $scripture->scripture_id; ?>"><?php echo stripslashes($scripture->text . $scripture->transtext); ?></a></td>
							<td><a href="<?php echo $scripture->link; ?>" target="_blank">Preview on <em>bible.com</em></a></td>
							<td><?php if ( $scripture->focus == 1 ) { echo "Yes"; }; ?></td>
							<td class="enmse-delete"><a href="#" class="seriesengine_scripturedelete" name="<?php echo $scripture->scripture_id; ?>" rel="<?php echo $scripture->focus; ?>">Delete</a></td>				
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php } ?>
				<br />
				<br />
			</div>

			<div id="enmsescriptureform">
				<h3>Add a New Scripture Reference</h3>		
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Start Verse:</th>
						<td>
							<select name="scripture_start_book" id="scripture_start_book" tabindex="15">
									<option value="1"><?php echo $enmse_booknames[1]; ?></option>
									<option value="2"><?php echo $enmse_booknames[2]; ?></option>
									<option value="3"><?php echo $enmse_booknames[3]; ?></option>
									<option value="4"><?php echo $enmse_booknames[4]; ?></option>
									<option value="5"><?php echo $enmse_booknames[5]; ?></option>
									<option value="6"><?php echo $enmse_booknames[6]; ?></option>
									<option value="7"><?php echo $enmse_booknames[7]; ?></option>
									<option value="8"><?php echo $enmse_booknames[8]; ?></option>
									<option value="9"><?php echo $enmse_booknames[9]; ?></option>
									<option value="10"><?php echo $enmse_booknames[10]; ?></option>
									<option value="11"><?php echo $enmse_booknames[11]; ?></option>
									<option value="12"><?php echo $enmse_booknames[12]; ?></option>
									<option value="13"><?php echo $enmse_booknames[13]; ?></option>
									<option value="14"><?php echo $enmse_booknames[14]; ?></option>
									<option value="15"><?php echo $enmse_booknames[15]; ?></option>
									<option value="16"><?php echo $enmse_booknames[16]; ?></option>
									<option value="17"><?php echo $enmse_booknames[17]; ?></option>
									<option value="18"><?php echo $enmse_booknames[18]; ?></option>
									<option value="19"><?php echo $enmse_booknames[19]; ?></option>
									<option value="20"><?php echo $enmse_booknames[20]; ?></option>
									<option value="21"><?php echo $enmse_booknames[21]; ?></option>
									<option value="22"><?php echo $enmse_booknames[22]; ?></option>
									<option value="23"><?php echo $enmse_booknames[23]; ?></option>
									<option value="24"><?php echo $enmse_booknames[24]; ?></option>
									<option value="25"><?php echo $enmse_booknames[25]; ?></option>
									<option value="26"><?php echo $enmse_booknames[26]; ?></option>
									<option value="27"><?php echo $enmse_booknames[27]; ?></option>
									<option value="28"><?php echo $enmse_booknames[28]; ?></option>
									<option value="29"><?php echo $enmse_booknames[29]; ?></option>
									<option value="30"><?php echo $enmse_booknames[30]; ?></option>
									<option value="31"><?php echo $enmse_booknames[31]; ?></option>
									<option value="32"><?php echo $enmse_booknames[32]; ?></option>
									<option value="33"><?php echo $enmse_booknames[33]; ?></option>
									<option value="34"><?php echo $enmse_booknames[34]; ?></option>
									<option value="35"><?php echo $enmse_booknames[35]; ?></option>
									<option value="36"><?php echo $enmse_booknames[36]; ?></option>
									<option value="37"><?php echo $enmse_booknames[37]; ?></option>
									<option value="38"><?php echo $enmse_booknames[38]; ?></option>
									<option value="39"><?php echo $enmse_booknames[39]; ?></option>
									<option value="40"><?php echo $enmse_booknames[40]; ?></option>
									<option value="41"><?php echo $enmse_booknames[41]; ?></option>
									<option value="42"><?php echo $enmse_booknames[42]; ?></option>
									<option value="43"><?php echo $enmse_booknames[43]; ?></option>
									<option value="44"><?php echo $enmse_booknames[44]; ?></option>
									<option value="45"><?php echo $enmse_booknames[45]; ?></option>
									<option value="46"><?php echo $enmse_booknames[46]; ?></option>
									<option value="47"><?php echo $enmse_booknames[47]; ?></option>
									<option value="48"><?php echo $enmse_booknames[48]; ?></option>
									<option value="49"><?php echo $enmse_booknames[49]; ?></option>
									<option value="50"><?php echo $enmse_booknames[50]; ?></option>
									<option value="51"><?php echo $enmse_booknames[51]; ?></option>
									<option value="52"><?php echo $enmse_booknames[52]; ?></option>
									<option value="53"><?php echo $enmse_booknames[53]; ?></option>
									<option value="54"><?php echo $enmse_booknames[54]; ?></option>
									<option value="55"><?php echo $enmse_booknames[55]; ?></option>
									<option value="56"><?php echo $enmse_booknames[56]; ?></option>
									<option value="57"><?php echo $enmse_booknames[57]; ?></option>
									<option value="58"><?php echo $enmse_booknames[58]; ?></option>
									<option value="59"><?php echo $enmse_booknames[59]; ?></option>
									<option value="60"><?php echo $enmse_booknames[60]; ?></option>
									<option value="61"><?php echo $enmse_booknames[61]; ?></option>
									<option value="62"><?php echo $enmse_booknames[62]; ?></option>
									<option value="63"><?php echo $enmse_booknames[63]; ?></option>
									<option value="64"><?php echo $enmse_booknames[64]; ?></option>
									<option value="65"><?php echo $enmse_booknames[65]; ?></option>
									<option value="66"><?php echo $enmse_booknames[66]; ?></option>
							</select>
							<input id='scripture_start_chapter' name='scripture_start_chapter' type='text' value='Chapter' tabindex="16" size="10" /> :
							<input id='scripture_start_verse' name='scripture_start_verse' type='text' value='Verse' tabindex="17" size="10" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">End Verse:</th>
						<td>
							<select name="scripture_end_book" id="scripture_end_book" class="enmse-disabled" disabled>
									<option value="1"><?php echo $enmse_booknames[1]; ?></option>
									<option value="2"><?php echo $enmse_booknames[2]; ?></option>
									<option value="3"><?php echo $enmse_booknames[3]; ?></option>
									<option value="4"><?php echo $enmse_booknames[4]; ?></option>
									<option value="5"><?php echo $enmse_booknames[5]; ?></option>
									<option value="6"><?php echo $enmse_booknames[6]; ?></option>
									<option value="7"><?php echo $enmse_booknames[7]; ?></option>
									<option value="8"><?php echo $enmse_booknames[8]; ?></option>
									<option value="9"><?php echo $enmse_booknames[9]; ?></option>
									<option value="10"><?php echo $enmse_booknames[10]; ?></option>
									<option value="11"><?php echo $enmse_booknames[11]; ?></option>
									<option value="12"><?php echo $enmse_booknames[12]; ?></option>
									<option value="13"><?php echo $enmse_booknames[13]; ?></option>
									<option value="14"><?php echo $enmse_booknames[14]; ?></option>
									<option value="15"><?php echo $enmse_booknames[15]; ?></option>
									<option value="16"><?php echo $enmse_booknames[16]; ?></option>
									<option value="17"><?php echo $enmse_booknames[17]; ?></option>
									<option value="18"><?php echo $enmse_booknames[18]; ?></option>
									<option value="19"><?php echo $enmse_booknames[19]; ?></option>
									<option value="20"><?php echo $enmse_booknames[20]; ?></option>
									<option value="21"><?php echo $enmse_booknames[21]; ?></option>
									<option value="22"><?php echo $enmse_booknames[22]; ?></option>
									<option value="23"><?php echo $enmse_booknames[23]; ?></option>
									<option value="24"><?php echo $enmse_booknames[24]; ?></option>
									<option value="25"><?php echo $enmse_booknames[25]; ?></option>
									<option value="26"><?php echo $enmse_booknames[26]; ?></option>
									<option value="27"><?php echo $enmse_booknames[27]; ?></option>
									<option value="28"><?php echo $enmse_booknames[28]; ?></option>
									<option value="29"><?php echo $enmse_booknames[29]; ?></option>
									<option value="30"><?php echo $enmse_booknames[30]; ?></option>
									<option value="31"><?php echo $enmse_booknames[31]; ?></option>
									<option value="32"><?php echo $enmse_booknames[32]; ?></option>
									<option value="33"><?php echo $enmse_booknames[33]; ?></option>
									<option value="34"><?php echo $enmse_booknames[34]; ?></option>
									<option value="35"><?php echo $enmse_booknames[35]; ?></option>
									<option value="36"><?php echo $enmse_booknames[36]; ?></option>
									<option value="37"><?php echo $enmse_booknames[37]; ?></option>
									<option value="38"><?php echo $enmse_booknames[38]; ?></option>
									<option value="39"><?php echo $enmse_booknames[39]; ?></option>
									<option value="40"><?php echo $enmse_booknames[40]; ?></option>
									<option value="41"><?php echo $enmse_booknames[41]; ?></option>
									<option value="42"><?php echo $enmse_booknames[42]; ?></option>
									<option value="43"><?php echo $enmse_booknames[43]; ?></option>
									<option value="44"><?php echo $enmse_booknames[44]; ?></option>
									<option value="45"><?php echo $enmse_booknames[45]; ?></option>
									<option value="46"><?php echo $enmse_booknames[46]; ?></option>
									<option value="47"><?php echo $enmse_booknames[47]; ?></option>
									<option value="48"><?php echo $enmse_booknames[48]; ?></option>
									<option value="49"><?php echo $enmse_booknames[49]; ?></option>
									<option value="50"><?php echo $enmse_booknames[50]; ?></option>
									<option value="51"><?php echo $enmse_booknames[51]; ?></option>
									<option value="52"><?php echo $enmse_booknames[52]; ?></option>
									<option value="53"><?php echo $enmse_booknames[53]; ?></option>
									<option value="54"><?php echo $enmse_booknames[54]; ?></option>
									<option value="55"><?php echo $enmse_booknames[55]; ?></option>
									<option value="56"><?php echo $enmse_booknames[56]; ?></option>
									<option value="57"><?php echo $enmse_booknames[57]; ?></option>
									<option value="58"><?php echo $enmse_booknames[58]; ?></option>
									<option value="59"><?php echo $enmse_booknames[59]; ?></option>
									<option value="60"><?php echo $enmse_booknames[60]; ?></option>
									<option value="61"><?php echo $enmse_booknames[61]; ?></option>
									<option value="62"><?php echo $enmse_booknames[62]; ?></option>
									<option value="63"><?php echo $enmse_booknames[63]; ?></option>
									<option value="64"><?php echo $enmse_booknames[64]; ?></option>
									<option value="65"><?php echo $enmse_booknames[65]; ?></option>
									<option value="66"><?php echo $enmse_booknames[66]; ?></option>
							</select>
							<input id='scripture_end_chapter' name='scripture_end_chapter' type='text' value='Chapter' size="10" class="enmse-disabled" disabled /> :
							<input id='scripture_end_verse' name='scripture_end_verse' type='text' value='Verse' tabindex="18" size="10" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Translation:</th>
						<td>
							<select name="scripture_trans" id="scripture_trans" tabindex="19">
								<option value="<?php echo $deftrans; ?>">------ ENGLISH ------</option>
								<option value="1588"<?php if ( $deftrans == 1588 ) { echo " selected=\"selected\""; } ?>>AMP - Amplified Bible</option>
								<option value="12"<?php if ( $deftrans == 12 ) { echo " selected=\"selected\""; } ?>>ASV - American Standard Version</option>
								<option value="1713"<?php if ( $deftrans == 1713 ) { echo " selected=\"selected\""; } ?>>CSB - Christian Standard Bible</option>
								<option value="37"<?php if ( $deftrans == 37 ) { echo " selected=\"selected\""; } ?>>CEB - Common English Bible</option>
								<option value="59"<?php if ( $deftrans == 59 ) { echo " selected=\"selected\""; } ?>>ESV - English Standard Version</option>
								<option value="72"<?php if ( $deftrans == 72 ) { echo " selected=\"selected\""; } ?>>HCSB - Holman Christian Standard Bible</option>
								<option value="1359"<?php if ( $deftrans == 1359 ) { echo " selected=\"selected\""; } ?>>ICB - International Childrens Bible</option>
								<option value="1"<?php if ( $deftrans == 1 ) { echo " selected=\"selected\""; } ?>>KJV - King James Version</option>
								<option value="1171"<?php if ( $deftrans == 1171 ) { echo " selected=\"selected\""; } ?>>MEV - Modern English Version</option>
								<option value="97"<?php if ( $deftrans == 97 ) { echo " selected=\"selected\""; } ?>>MSG - The Message</option>
								<option value="100"<?php if ( $deftrans == 100 ) { echo " selected=\"selected\""; } ?>>NASB - New American Standard Bible</option>
								<option value="111"<?php if ( $deftrans == 111 ) { echo " selected=\"selected\""; } ?>>NIV - New International Version</option>
								<option value="114"<?php if ( $deftrans == 114 ) { echo " selected=\"selected\""; } ?>>NKJV - New King James Version</option>
								<option value="116"<?php if ( $deftrans == 116 ) { echo " selected=\"selected\""; } ?>>NLT - New Living Translation</option>
								<option value="2016"<?php if ( $deftrans == 2016 ) { echo " selected=\"selected\""; } ?>>NRSV - New Revised Standard Version</option>
								<option value="<?php echo $deftrans; ?>">------ CHINESE ------</option>
								<option value="48"<?php if ( $deftrans == 48 ) { echo " selected=\"selected\""; } ?>>CUNPSS-神 - 新标点和合本, 神版</option>
								<option value="414"<?php if ( $deftrans == 414 ) { echo " selected=\"selected\""; } ?>>CUNP-上帝 - 新標點和合本, 神版</option>
								<option value="<?php echo $deftrans; ?>">------ CZECH ------</option>
								<option value="15"<?php if ( $deftrans == 15 ) { echo " selected=\"selected\""; } ?>>B21 - Bible 21</option>
								<option value="162"<?php if ( $deftrans == 162 ) { echo " selected=\"selected\""; } ?>>BCZ - Slovo na cestu</option>
								<option value="44"<?php if ( $deftrans == 44 ) { echo " selected=\"selected\""; } ?>>BKR - Bible Kralica 1613</option>
								<option value="509"<?php if ( $deftrans == 509 ) { echo " selected=\"selected\""; } ?>>CSP - Cesky studijni preklad</option>
								<option value="<?php echo $deftrans; ?>">------ DUTCH ------</option>
								<option value="1276"<?php if ( $deftrans == 1276 ) { echo " selected=\"selected\""; } ?>>BB - BasisBijbel</option>
								<option value="1990"<?php if ( $deftrans == 1990 ) { echo " selected=\"selected\""; } ?>>HSV - Herziene Statenvertaling</option>
								<option value="75"<?php if ( $deftrans == 75 ) { echo " selected=\"selected\""; } ?>>HTB - Het Boek</option>
								<option value="328"<?php if ( $deftrans == 328 ) { echo " selected=\"selected\""; } ?>>NBG51 - NBG-vertaling 1951</option>
								<option value="165"<?php if ( $deftrans == 165 ) { echo " selected=\"selected\""; } ?>>SV-RJ - Statenvertaling</option>
								<option value="<?php echo $deftrans; ?>">------ FRENCH ------</option>
								<option value="2367"<?php if ( $deftrans == 2367 ) { echo " selected=\"selected\""; } ?>>NFC - Nouvelle Français Courant</option>
								<option value="133"<?php if ( $deftrans == 133 ) { echo " selected=\"selected\""; } ?>>PDV2017 - Parole de Vie 2017</option>
								<option value="<?php echo $deftrans; ?>">------ GERMAN ------</option>
								<option value="57"<?php if ( $deftrans == 57 ) { echo " selected=\"selected\""; } ?>>ELB - Elberfelder 1905</option>
								<option value="51"<?php if ( $deftrans == 51 ) { echo " selected=\"selected\""; } ?>>DELUT - Lutherbibel 1912</option>
								<option value="73"<?php if ( $deftrans == 73 ) { echo " selected=\"selected\""; } ?>>HFA - Hoffnung für alle</option>
								<option value="877"<?php if ( $deftrans == 877 ) { echo " selected=\"selected\""; } ?>>NBH - NeÜ Bibel.heute</option>
								<option value="108"<?php if ( $deftrans == 108 ) { echo " selected=\"selected\""; } ?>>NGU2011 - Neue Genfer Übersetzung</option>
								<option value="157"<?php if ( $deftrans == 157 ) { echo " selected=\"selected\""; } ?>>SCH2000 - Schlachter 2000</option>
								<option value="<?php echo $deftrans; ?>">------ JAPANESE ------</option>
								<option value="83"<?php if ( $deftrans == 83 ) { echo " selected=\"selected\""; } ?>>JCB - リビングバイブル</option>
								<option value="1819"<?php if ( $deftrans == 1819 ) { echo " selected=\"selected\""; } ?>>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
								<option value="1820"<?php if ( $deftrans == 1820 ) { echo " selected=\"selected\""; } ?>>口語訳 Japanese: 聖書　口語訳</option>
								<option value="<?php echo $deftrans; ?>">------ RUSSIAN ------</option>
								<option value="400"<?php if ( $deftrans == 400 ) { echo " selected=\"selected\""; } ?>>SYNO - Синодальный Перевод</option>
								<option value="143"<?php if ( $deftrans == 143 ) { echo " selected=\"selected\""; } ?>>НРП - Новый Русский Перевод</option>
								<option value="1999"<?php if ( $deftrans == 1999 ) { echo " selected=\"selected\""; } ?>>СРП-2 - Современный Русский Перевод</option>
								<option value="<?php echo $deftrans; ?>">------ SPANISH ------</option>
								<option value="149"<?php if ( $deftrans == 149 ) { echo " selected=\"selected\""; } ?>>RVR1960 - Biblia Reina Valera 1960</option>
								<option value="128"<?php if ( $deftrans == 128 ) { echo " selected=\"selected\""; } ?>>NVI - La Santa Biblia, Nueva Version Internacional</option>
								<option value="<?php echo $deftrans; ?>">------ TURKISH ------</option>
								<option value="170"<?php if ( $deftrans == 170 ) { echo " selected=\"selected\""; } ?>>TCL02 - Kutsal Kitap Yeni Ceviri</option>
								<option value="<?php echo $deftrans; ?>">------ OTHER ------</option>
								<option value="6"<?php if ( $deftrans == 6 ) { echo " selected=\"selected\""; } ?>>AFR83 - Afrikaans 1983</option>
							</select>
						</td>
					</tr>
						<tr valign="top">
						<th scope="row">Focus Passage?:
							<p class="se-form-instructions">Is this the main (or one of the main) passages for this <?php echo $enmsemessaget; ?>?</p>
						</th>
						<td>
							<input name="scripture_focus" id="scripture_focus" type="checkbox" class="check" tabindex="20" />
						</td>
					</tr>
				</table>
				<br />
				<input type="hidden" name="scripture_username" value="" id="scripture_username" />
		
				<a href="#" id="addnewscripture" class="button">Attach New Scripture Reference</a>
			</div>
			<br />
			<br />
		</div>
		
		<div id="enmse-podcast-content" style="display: none">
			<p>Upload an audio or video file to use for your podcasts. If your server supports it, Series Engine will automatically populate the "length" and "file size" fields for most media. Learn more about <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-podcasts"; ?>" class="enmse-learn-more">Podcasting with the Series Engine...</a></p>
			<table class="form-table">
				<tr valign="top" <?php if ($enmseid3 == 1 && $enmse_single->audio_url == "0") { ?>style="display: none"<?php } ?>>
					<th scope="row">Audio Length:</th>
					<td><input id='message_length' name='message_length' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_length'];} else {echo $enmse_single->message_length;} ?>' tabindex="21" /> <span class="se-form-instructions">ex: 31:46</span></td>
				</tr>
				<tr valign="top">
					<th scope="row">Audio URL:</th>
					<td><input id='message_audio_url_dummy' name='message_audio_url_dummy' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_audio_url']);} else {if ($enmse_single->audio_url != "0") {echo stripslashes($enmse_single->audio_url);}} ?>" tabindex="22" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-podcast-audio se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
				</tr>
				<tr valign="top" <?php if ($enmseid3 == 1 && $enmse_single->audio_url == "0") { ?>style="display: none"<?php } ?>>
					<th scope="row">Audio File Size:</th>
					<td><input id='message_audio_file_size' name='message_audio_file_size' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_audio_file_size'];} else { if ( $enmse_single->audio_file_size != 0 ) { echo $enmse_single->audio_file_size; } } ?>' tabindex="23" /> <span class="se-form-instructions">In bytes, ex: 123456789</span><br /><br /></td>
				</tr>
				
				<tr valign="top" <?php if ($enmseid3 == 1 && $enmse_single->video_url == "0") { ?>style="display: none"<?php } ?>>
					<th scope="row">Video Length:</th>
					<td><input id='message_video_length' name='message_video_length' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_video_length'];} else {echo $enmse_single->message_video_length;} ?>' tabindex="24" /> <span class="se-form-instructions">ex: 31:46</span></td>
				</tr>
				<tr valign="top">
					<th scope="row">Video URL:</th>
					<td><input id='message_video_url' name='message_video_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['message_video_url']);} else {if ($enmse_single->video_url != "0") {echo stripslashes($enmse_single->video_url);}} ?>" tabindex="25" /></td>
				</tr>
				<tr valign="top" <?php if ($enmseid3 == 1 && $enmse_single->video_url == "0") { ?>style="display: none"<?php } ?>>
					<th scope="row">Video File Size:</th>
					<td><input id='message_video_file_size' name='message_video_file_size' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_video_file_size'];} else { if ( $enmse_single->video_file_size != 0 ) { echo $enmse_single->video_file_size; } } ?>' tabindex="26" /> <span class="se-form-instructions">In bytes, ex: 123456789</span></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Podcast Image:
						<p class="se-form-instructions">Use a specific image just for this <?php echo $enmsemessaget; ?> in your podcast feeds (overriding the image of the associated <?php echo $enmseseriest; ?>, if set). The image must be at least 1400px x 1400px with a max size of 3000px x 3000px.</p>	
					</th>
					<td><input id='message_podcast_image' name='message_podcast_image' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['message_podcast_image'];} else {echo $enmse_single->podcast_image;} ?>' tabindex="27" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=image&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-podcast-image se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="message-podcast-image-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['message_podcast_image'])) { ?><br /><img src="<?php echo $_POST['message_podcast_image']; ?>" /><?php } elseif ( $enmse_single->podcast_image != NULL ) { ?><br /><img src="<?php echo $enmse_single->podcast_image ?>" /><?php }; ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Include <?php echo $enmseseriest; ?> Info in Podcast Title?:
						<p class="se-form-instructions">Do you want "- <?php echo $enmseseriest; ?> Name" appended to the end of your podcast title?</p>
					</th>
					<td>
						<select name="message_podcast_series" id="message_podcast_series" tabindex="16">
							<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_podcast_series'] == "1") { ?>selected="selected"<?php }} elseif ( $enmse_single->podcast_series == 1 || $enmse_single->podcast_series == NULL  ) { ?>selected="selected"<?php } ?>>Yes</option>
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['message_podcast_series'] == "0") { ?>selected="selected"<?php }} elseif ( $enmse_single->podcast_series == 0 && $enmse_single->podcast_series != NULL ) { ?>selected="selected"<?php } ?>>No</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="enmse-related-files" style="display: none">
			<p>Attach a link or file download to appear in the <?php echo $enmsemessaget; ?>'s "Details" section. Featured files/downloads will also display in the card and row views for Related <?php echo $enmsemessagetp; ?>. This is great for sign up links, bulletins, study guides, etc. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-uploadfiles"; ?>" class="enmse-learn-more">Learn more about this feature...</a></p>

				<div id="enmsefilearea">
				<?php if ( !empty($enmse_files) ) { ?>
					<script type="text/javascript">
					jQuery(document).ready(function(){
						var fixHelper = function(e, ui) {
							ui.children().each(function() {
								jQuery(this).width(jQuery(this).width());
							});
							return ui;
						};
						jQuery("#filestable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
							var order = jQuery(this).sortable("serialize");
							jQuery.ajax({
								method: "POST",
						        url: seajax.ajaxurl, 
						        data: {
						            'action': 'seriesengine_ajaxsortfiles',
						            'frow': order
						        },
						        success:function(data) {
						        },
						        error: function(errorThrown){
						            console.log(errorThrown);
						        }
						    });
						}});
					});
					</script>
				<br />
				<h3>Links and Downloads Currently Associated with This <?php echo $enmsemessaget; ?>...</h3>
				<table class="widefat" id="filestable"> 
					<thead> 
						<tr> 
							<th>Sort</th> 
							<th>Name</th> 
							<th>URL</th>
							<th>Opens In...</th>
							<th>Featured?</th>
							<th>Delete?</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($enmse_files as $file) {  ?>
						<tr id="frow_<?php echo $file->file_id; ?>">
							<td class="enmse-sort"></td>
							<td><a href="#" class="seriesengine_editfile" name="<?php echo $file->file_id; ?>"><?php echo stripslashes($file->file_name); ?></a></td>
							<td><a href="<?php echo $file->file_url; ?>" target="_blank"><?php echo $file->file_url; ?></a></td>
							<td><?php if ( $file->file_new_window == 0 ) { echo "Same Window"; } else { echo "New Window"; } ?></td>
							<td><?php if ( $file->featured == 1 ) { echo "Yes"; }; ?></td>
							<td class="enmse-delete"><a href="#" class="seriesengine_filedelete" name="<?php echo $file->file_id; ?>" rel="<?php echo $file->featured; ?>">Delete</a></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php } ?>
				<br />
				<br />
			</div>
			<div id="enmsefileform">
				<h3>Attach a Link or Download</h3>		
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Name:</th>
						<td><input id='file_name' name='file_name' type='text' value="" tabindex="28" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Link/File URL:</th>
						<td><input id='file_url' name='file_url' type='text' value='' tabindex="29" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-message-file se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
					</tr>
					<tr valign="top">
						<th scope="row">How to Open Link:</th>
						<td>
							<select name="file_new_window" id="file_new_window" tabindex="30">
								<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['file_new_window'] == 0) { ?>selected="selected"<?php }} ?>>Same Window</option>
								<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['file_new_window'] == 1) { ?>selected="selected"<?php }} ?>>New Window</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Featured?:
							<p class="se-form-instructions">Featured Attachments/Links will be shown in the Related <?php echo $enmsemessagetp; ?> views. Only ONE can be featured per <?php echo $enmsemessaget; ?>.</p>
						</th>
						<td>
							<input name="file_featured" id="file_featured" type="checkbox" class="check" tabindex="31" />
						</td>
					</tr>
				</table>
				<input type="hidden" name="file_username" value="<?php echo $enmse_userdetails->user_login; ?>" id="file_username" />
				<a href="#" id="addnewfile" class="button">Attach New Link/Download</a>
			</div>
			<br />
			<br />
		</div>
		<input type="hidden" name="enmseexistingaudio" value="<?php echo $enmse_single->audio_url; ?>" id="enmseexistingaudio" />
		<input type="hidden" name="enmseexistingvideo" value="<?php echo $enmse_single->video_url; ?>" id="enmseexistingvideo" />
		<input type="hidden" name="message_wp_post_id" value="<?php echo $enmse_single->wp_post_id; ?>" id="message_wp_post_id" />
		<input type="hidden" name="message_old_permalink" value="<?php echo $enmse_singlecpt->post_name; ?>" id="message_old_permalink" />
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Update <?php echo $enmsemessaget; ?>" tabindex="32" /></p>
	</form>
	<input type="hidden" name="enmsemid" value="<?php echo $enmse_single->message_id; ?>" id="enmsemid" />
	<input type="hidden" name="enmsepluginurl" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/newtopicslist.php" id="enmsepluginurl" />
	<input type="hidden" name="enmsespeakerurl" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/newspeakerslist.php" id="enmsespeakerurl" />
	<input type="hidden" name="enmsefileurl" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/newfile.php" id="enmsefileurl" />
	<input type="hidden" name="enmsefiledelete" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/filedelete.php" id="enmsefiledelete" />
	<input type="hidden" name="enmsefileedit" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/fileedit.php" id="enmsefileedit" />
	<input type="hidden" name="enmsescriptureurl" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/newscripture.php" id="enmsescriptureurl" />
	<input type="hidden" name="xxse" value="<?php echo base64_encode(ABSPATH); ?>" id="xxse" />
	<input type="hidden" name="enmsescripturedelete" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/scripturedelete.php" id="enmsescripturedelete" />
	<input type="hidden" name="enmsescriptureedit" value="<?php echo plugins_url(); ?>/seriesengine_plugin/includes/admin/scriptureedit.php" id="enmsescriptureedit" />
	<input type="hidden" name="enmsethumb" value="<?php echo $enmse_embedwidth; ?>" id="enmsethumb" />
	<input type="hidden" name="message_current_primary_series" value="<?php if ($_POST) { echo $_POST['message_primary_series']; } else { echo $enmse_single->primary_series;} ?>" id="current_primary_series" />
	<input type="hidden" name="series_title_text" value="<?php echo $enmseseriest; ?>" id="series_title_text" />

	<p><a href="<?php if ( isset($_GET['enmse_p']) ) { if ( isset($_GET['enmse_sid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_sid=' . $enmse_sid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } elseif ( isset($_GET['enmse_tid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_tid=' . $enmse_tid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } elseif ( isset($_GET['enmse_bid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_bid=' . $enmse_bid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } elseif ( isset($_GET['enmse_spid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_spid=' . $enmse_spid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ );} } else { if ( isset($_GET['enmse_sid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_sid=' . $enmse_sid, __FILE__ ); } elseif ( isset($_GET['enmse_tid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_tid=' . $enmse_tid, __FILE__ ); } elseif ( isset($_GET['enmse_bid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_bid=' . $enmse_bid, __FILE__ ); } elseif ( isset($_GET['enmse_spid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_spid=' . $enmse_spid, __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php', __FILE__ ); }} ?>">&laquo; All Messages</a></p>
	<?php include ('secredits.php'); ?>
<?php }} else { // Display the main listing of Messages ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/deletemessage.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/message_options283.js'; ?>"></script>
	<h2 class="enmse">Create and Edit <?php echo $enmsemessagetp; ?> <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>

	<p>All Series Engine <?php echo $enmsemessagetp; ?> are listed in the table below. Click on the title to edit a <?php echo $enmsemessaget; ?>, or click a <?php echo $enmseseriest; ?> title or <?php echo $enmsetopict; ?> to view groups of similar <?php echo $enmsemessagetp; ?>. You can permanently delete a <?php echo $enmsemessaget; ?> from Series Engine by clicking the red "Delete" link on the right. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-messages"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmsemessagetp; ?>...</a></p>

	<div id="enmsefilter">
		<strong>Filter By:</strong>
		<select name="enmse_filter" id="enmse_filter">
			<option value="0">- No Filter -</option>
			<option value="1" <?php if ( isset($_GET['enmse_sid']) ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmseseriest); ?></option>
			<option value="2" <?php if ( isset($_GET['enmse_spid']) ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmsespeakert); ?></option>
			<option value="3" <?php if ( isset($_GET['enmse_tid']) ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmsetopict); ?></option>
			<option value="4" <?php if ( isset($_GET['enmse_bid']) ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmsebookt); ?></option>
		</select>
		<select name="enmse_series" id="enmse_series" <?php if ( !isset($_GET['enmse_sid']) ) { ?>style="display: none"<?php } ?>>
			<option value="0">- Select -</option>
			<?php foreach ( $enmse_fseries as $s) { ?>
			<option value="<?php echo $s->series_id; ?>" <?php if ( isset($_GET['enmse_sid']) && $_GET['enmse_sid'] == $s->series_id ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($s->s_title); ?></option>
			<?php } ?>
		</select>
		<select name="enmse_speakers" id="enmse_speakers" <?php if ( !isset($_GET['enmse_spid']) ) { ?>style="display: none"<?php } ?>>
			<option value="0">- Select -</option>
			<?php foreach ( $enmse_fspeakers as $sp) { ?>
			<option value="<?php echo $sp->speaker_id; ?>" <?php if ( isset($_GET['enmse_spid']) && $_GET['enmse_spid'] == $sp->speaker_id ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($sp->first_name) . " " . stripslashes($sp->last_name); ?></option>
			<?php } ?>
		</select>
		<select name="enmse_topic" id="enmse_topic" <?php if ( !isset($_GET['enmse_tid']) ) { ?>style="display: none"<?php } ?>>
			<option value="0">- Select -</option>
			<?php foreach ( $enmse_ftopics as $t) { ?>
			<option value="<?php echo $t->topic_id; ?>" <?php if ( isset($_GET['enmse_tid']) && $_GET['enmse_tid'] == $t->topic_id ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($t->name); ?></option>
			<?php } ?>
		</select>
		<select name="enmse_book" id="enmse_book" <?php if ( !isset($_GET['enmse_bid']) ) { ?>style="display: none"<?php } ?>>
			<option value="0">- Select -</option>
			<?php foreach ( $enmse_fbooks as $b) { ?>
			<option value="<?php echo $b->book_id; ?>" <?php if ( isset($_GET['enmse_bid']) && $_GET['enmse_bid'] == $b->book_id ) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[$b->book_id]; ?></option>
			<?php } ?>
		</select>
	</div>
	<?php include ('messagepagination.php'); ?>
	<table class="widefat"> 
		<thead> 
			<tr> 
				<th>Title</th> 
				<th><?php echo $enmsespeakert; ?></th>
				<th>Date</th>
				<th><?php echo $enmseseriest; ?></th>
				<th><?php echo $enmsetopictp; ?></th>
				<th><?php echo $enmsebooktp; ?></th>
				<th>Plays</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmse_message as $enmse_single ) { ?>
			<tr>
				<td><a href="<?php if ( isset($_GET['enmse_p']) ) { if ( isset($_GET['enmse_sid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_sid=' . $enmse_sid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } elseif ( isset($_GET['enmse_tid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_tid=' . $enmse_tid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } elseif ( isset($_GET['enmse_bid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_bid=' . $enmse_bid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } elseif ( isset($_GET['enmse_spid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_spid=' . $enmse_spid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ );} } else { if ( isset($_GET['enmse_sid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_sid=' . $enmse_sid, __FILE__ ); } elseif ( isset($_GET['enmse_tid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_tid=' . $enmse_tid, __FILE__ ); } elseif ( isset($_GET['enmse_bid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_bid=' . $enmse_bid, __FILE__ ); } elseif ( isset($_GET['enmse_spid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id . '&amp;enmse_spid=' . $enmse_spid, __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_action=edit&amp;enmse_mid=' . $enmse_single->message_id, __FILE__ ); }} ?>"><?php echo stripslashes($enmse_single->title) ?></a> <?php foreach ($enmse_allpermalinks as $pl) { if ( $pl->ID == $enmse_single->wp_post_id ) { echo "<a href=\"" . site_url() . "/" . $permalinkslug . "/" . $pl->post_name . "\" target=\"_blank\" class=\"enmse-permalink-link\"></a>"; }; } ?></td>
				<td><?php $enmse_sp_comma = 1; foreach ( $enmse_sp as $sp) { ?><?php foreach ( $enmse_mspm as $mspm) { ?><?php if ( ($mspm->message_id == $enmse_single->message_id) && ($mspm->speaker_id == $sp->speaker_id) ) { if ( $enmse_sp_comma == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_spid=' . $sp->speaker_id, __FILE__ ) . "\">" . stripslashes($sp->first_name) . " " . stripslashes($sp->last_name) . "</a>"; $enmse_sp_comma = $enmse_sp_comma+1; }} ?><?php } ?><?php } ?><?php if ( $enmse_sp_comma == 1 ) { echo $enmse_single->speaker; } ?></td>
				<td><?php echo date_i18n($enmse_dateformat, strtotime($enmse_single->date)) ?></td>
				<td><?php $enmse_s_comma = 1; foreach ( $enmse_ss as $s) { ?><?php foreach ( $enmse_smm as $smm) { ?><?php if ( ($smm->message_id == $enmse_single->message_id) && ($smm->series_id == $s->series_id) ) { if ( $enmse_s_comma == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_sid=' . $s->series_id, __FILE__ ) . "\">" . stripslashes($s->s_title) . "</a>"; $enmse_s_comma = $enmse_s_comma+1; } else { echo ", <a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_sid=' . $s->series_id, __FILE__ ) . "\">" . stripslashes($s->s_title) . "</a>"; $enmse_s_comma = $enmse_s_comma+1; } } ?><?php } ?><?php } ?></td>
				<td><?php $enmse_t_comma = 1; foreach ( $enmse_t as $t) { ?><?php foreach ( $enmse_mtm as $mtm) { ?><?php if ( ($mtm->message_id == $enmse_single->message_id) && ($mtm->topic_id == $t->topic_id) ) { if ( $enmse_t_comma == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_tid=' . $t->topic_id, __FILE__ ) . "\">" . stripslashes($t->name) . "</a>"; $enmse_t_comma = $enmse_t_comma+1; } else { echo ", <a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_tid=' . $t->topic_id, __FILE__ ) . "\">" . stripslashes($t->name) . "</a>"; $enmse_t_comma = $enmse_t_comma+1; } } ?><?php } ?><?php } ?></td>
				<td><?php $enmse_b_comma = 1; foreach ( $enmse_b as $b) { ?><?php foreach ( $enmse_mbm as $mbm) { ?><?php if ( ($mbm->message_id == $enmse_single->message_id) && ($mbm->book_id == $b->book_id) ) { if ( $enmse_b_comma == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_bid=' . $b->book_id, __FILE__ ) . "\">" . $enmse_booknames[$b->book_id] . "</a>"; $enmse_b_comma = $enmse_b_comma+1; } else { echo ", <a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_bid=' . $b->book_id, __FILE__ ) . "\">" . $enmse_booknames[$b->book_id] . "</a>"; $enmse_b_comma = $enmse_b_comma+1; } } ?><?php } ?><?php } ?></td>
				<td><?php $enmse_plays = $enmse_single->audio_count + $enmse_single->video_count; if ( $enmse_plays != 0 ) { echo "<span class=\"enmseplaycount\" title=\"Audio: " . $enmse_single->audio_count . ", Video: " . $enmse_single->video_count . ", Other Video: " . $enmse_single->alternate_count . "\">" . $enmse_plays . "</span>"; } ?></td>
				<td class="enmse-delete"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmse_did=1" method="post" id="seriesengine-deleteform<?php echo $enmse_single->message_id ?>"><input type="hidden" name="message_delete" value="<?php echo $enmse_single->message_id ?>"></form><a href="#" class="seriesengine_delete" name="<?php echo $enmse_single->message_id ?>">Delete</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<input type="hidden" name="xxse" value="<?php echo base64_encode(ABSPATH); ?>" id="xxse" />
	<?php include ('secredits.php'); ?>	
	<input type="hidden" name="enmsepluginurl" value="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php', __FILE__ ); ?>" id="enmsepluginurl" />
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
