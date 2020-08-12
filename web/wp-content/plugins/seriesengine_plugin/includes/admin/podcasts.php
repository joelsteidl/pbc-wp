<?php /* ----- Series Engine - Add, edit and remove podcasts ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		
		$enmse_options = get_option( 'enm_seriesengine_options' ); 
		$enmse_primaryst = $enmse_options['primaryst'];

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
		
		$enmse_errors = array(); //Set up errors array
		$enmse_messages = array(); //Set up messages array
		
		if ( $_POST && isset($_GET['enmse_did']) ) { // If deleting a topic
			$enmse_deleted_id = strip_tags($_POST['podcast_delete']);
			
			if ( $enmse_deleted_id > 1 ) {
				$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_podcasts" . " WHERE se_podcast_id=%d";
				$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_deleted_id ); 
				$enmse_deleted = $wpdb->query( $enmse_delete_query ); 

				$enmse_messages[] = "The podcast was successfully deleted.";
			} else {
				$enmse_messages[] = "Sorry, you may not delete the default podcast. You may edit its details, or create a new podcast to suit your needs.";
			}
			
		}
		
		if ( isset($_GET['enmse_action']) ) {
			$enmse_podcast_created = null;

			if ( $_GET['enmse_action'] == 'edit' ) { // Edit Podcast
				if ( $_POST ) {
					if ( isset($_GET['enmse_pid']) && is_numeric($_GET['enmse_pid']) ) {
						$enmse_pid = strip_tags($_GET['enmse_pid']);
					}
					
					if ( $enmse_pid == 1 ) {
						$enmse_audio_video = "Audio";
					} else {
						$enmse_audio_video = strip_tags($_POST['podcast_audio_video']);
					}
					

					if (empty($_POST['podcast_title'])) { 
						$enmse_errors[] = '- You must name the new podcast.';
					} else {
						$enmse_title = strip_tags($_POST['podcast_title']);
					}

					if (preg_match('/(href=)/', $_POST['podcast_description']) || preg_match('/(HREF=)/', $_POST['podcast_description'])) { 
						$enmse_errors[] = '- Sorry, no HTML is allowed in the description.';
					} else {
						if (empty($_POST['podcast_description'])) { 
							$enmse_errors[] = '- You must give the podcast a description.';
						} else {
							$enmse_description = strip_tags($_POST['podcast_description']);
						}
					}

					if (empty($_POST['podcast_author'])) { 
						$enmse_errors[] = '- You must supply an author.';
					} else {
						$enmse_author = strip_tags($_POST['podcast_author']);
					}

					if (empty($_POST['podcast_email'])) { 
						$enmse_errors[] = '- You must supply an author email.';
					} else {
						$enmse_author_email = strip_tags($_POST['podcast_email']);
					}

					if (empty($_POST['podcast_logo_url'])) { 
						$enmse_errors[] = '- You must supply a logo for your podcast.';
					} else {
						$enmse_logo_url = strip_tags($_POST['podcast_logo_url']);
					}

					$enmse_link_url = strip_tags($_POST['podcast_link_url']);

					if (empty($_POST['podcast_category'])) { 
						$enmse_errors[] = '- You must supply a category.';
					} else {
						$enmse_category = strip_tags($_POST['podcast_category']);
					}

					if (empty($_POST['podcast_subcategory'])) { 
						$enmse_errors[] = '- You must supply a subcategory.';
					} else {
						$enmse_subcategory = strip_tags($_POST['podcast_subcategory']);
					}

					if (empty($_POST['podcast_podcast_display'])) { 
						$enmse_errors[] = '- "How many messages?" cannot be blank.';
					} else {
						if (!is_numeric($_POST['podcast_podcast_display'])) { 
							$enmse_errors[] = '- "How many messages?" must be a number.';
						} else {
							$enmse_podcast_display = strip_tags($_POST['podcast_podcast_display']);
						}
					}
					
					if ( $enmse_pid == 1 ) {
						$enmse_podcast_option = "mostrecent";
					} else {
						$enmse_podcast_option = strip_tags($_POST['podcast_option']);
					}
					
					if ( $enmse_pid == 1 ) {
						$enmse_stid = 0;
					} else {
						$enmse_stid = strip_tags($_POST['podcast_st']);
					}

					if ( $_POST['podcast_explicit'] == 1 ) {
						$enmse_explicit = 1;
					} else {
						$enmse_explicit = 0;
					}
					
					$enmse_redirect = strip_tags($_POST['podcast_redirect']);
					$enmse_redirect_url = strip_tags($_POST['podcast_redirect_url']);
					$enmse_custom_lang = strip_tags($_POST['podcast_custom_lang']);
					

					if ( $enmse_podcast_option == "mostrecent" ) {
						$enmse_sid = -1;
						$enmse_tid = -1;
						$enmse_spid = -1;
					} elseif ( $enmse_podcast_option == "series" ) {
						if (isset($_POST['podcast_s'])) {
							$enmse_sid = strip_tags($_POST['podcast_s']);
							$enmse_tid = -1;
							$enmse_spid = -1;
						} else {
							$enmse_errors[] = '- Please choose a series to display.';
						}
					} elseif ( $enmse_podcast_option == "topic" ) {
						if (isset($_POST['podcast_t'])) {
							$enmse_sid = -1;
							$enmse_tid = strip_tags($_POST['podcast_t']);
							$enmse_spid = -1;
						} else {
							$enmse_errors[] = '- Please choose a Topic to display.';
						}
					} elseif ( $enmse_podcast_option == "speaker" ) {
						if (isset($_POST['podcast_sp'])) {
							$enmse_sid = -1;
							$enmse_tid = -1;
							$enmse_spid = strip_tags($_POST['podcast_sp']);
						} else {
							$enmse_errors[] = '- Please choose a Speaker to display.';
						}
					}
					
					if (empty($enmse_errors)) {
						$enmse_new_values = array( 'audio_video' => $enmse_audio_video, 'title' => $enmse_title, 'explicit' => $enmse_explicit, 'redirect_podcast' => $enmse_redirect, 'custom_lang' => $enmse_custom_lang, 'redirect_url' => $enmse_redirect_url, 'description' => $enmse_description, 'author' => $enmse_author, 'email' => $enmse_author_email, 'logo_url' => $enmse_logo_url, 'link_url' => $enmse_link_url, 'category' => $enmse_category, 'subcategory' => $enmse_subcategory, 'podcast_display' => $enmse_podcast_display, 'series_type_id' => $enmse_stid, 'series_id' => $enmse_sid, 'topic_id' => $enmse_tid, 'speaker_id' => $enmse_spid );						
						$enmse_where = array( 'se_podcast_id' => $enmse_pid ); 
						$wpdb->update( $wpdb->prefix . "se_podcasts", $enmse_new_values, $enmse_where ); 
						$enmse_messages[] = "Podcast successfully updated!";

						// Find Podcast to Edit
						$enmse_findthepodcastsql = "SELECT * FROM " . $wpdb->prefix . "se_podcasts" . " WHERE se_podcast_id = %d"; 
						$enmse_findthepodcast = $wpdb->prepare( $enmse_findthepodcastsql, $enmse_pid );
						$enmse_podcast = $wpdb->get_row( $enmse_findthepodcast, OBJECT );
						$enmse_podcastcount = $wpdb->num_rows;

						// Get Topics
						if ( $enmse_podcast->series_type_id == 0 ) {
							$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
							$enmse_pagetopics = $wpdb->get_results( $enmse_tpreparredsql );
						} else {
							$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND message_id IS NOT NULL GROUP BY name ORDER BY sort_id ASC";  
							$enmse_tsql = $wpdb->prepare( $enmse_tpreparredsql, $enmse_podcast->series_type_id );
							$enmse_pagetopics = $wpdb->get_results( $enmse_tsql );
						}

						// Get Series
						if ( $enmse_podcast->series_type_id == 0  ) {
							$enmse_spreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " ORDER BY start_date DESC"; 
							$enmse_pageseries = $wpdb->get_results( $enmse_spreparredsql );
						} else {
							$enmse_spreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d GROUP BY s_title ORDER BY start_date DESC"; 
							$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_podcast->series_type_id );
							$enmse_pageseries = $wpdb->get_results( $enmse_ssql );
						}
						
						// Get Speakers
						if ( $enmse_podcast->series_type_id == 0  ) {
							$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name DESC"; 
							$enmse_pagespeakers = $wpdb->get_results( $enmse_sppreparredsql );
						} else {
							$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d GROUP BY speaker_id ORDER BY last_name ASC"; 
							$enmse_spsql = $wpdb->prepare( $enmse_sppreparredsql, $enmse_podcast->series_type_id );
							$enmse_pagespeakers = $wpdb->get_results( $enmse_spsql );
						}
						
						
					} else {
						// Find Podcast to Edit
						$enmse_findthepodcastsql = "SELECT * FROM " . $wpdb->prefix . "se_podcasts" . " WHERE se_podcast_id = %d"; 
						$enmse_findthepodcast = $wpdb->prepare( $enmse_findthepodcastsql, $enmse_pid );
						$enmse_podcast = $wpdb->get_row( $enmse_findthepodcast, OBJECT );
						$enmse_podcastcount = $wpdb->num_rows;

						// Get Topics
						if ( $enmse_podcast->series_type_id == 0 ) {
							$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
							$enmse_pagetopics = $wpdb->get_results( $enmse_tpreparredsql );
						} else {
							$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND message_id IS NOT NULL GROUP BY name ORDER BY sort_id ASC";  
							$enmse_tsql = $wpdb->prepare( $enmse_tpreparredsql, $enmse_podcast->series_type_id );
							$enmse_pagetopics = $wpdb->get_results( $enmse_tsql );
						}

						// Get Series
						if ( $enmse_podcast->series_type_id == 0  ) {
							$enmse_spreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " ORDER BY start_date DESC"; 
							$enmse_pageseries = $wpdb->get_results( $enmse_spreparredsql );
						} else {
							$enmse_spreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d GROUP BY s_title ORDER BY start_date DESC"; 
							$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_podcast->series_type_id );
							$enmse_pageseries = $wpdb->get_results( $enmse_ssql );
						}
						
						// Get Speakers
						if ( $enmse_podcast->series_type_id == 0  ) {
							$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name DESC"; 
							$enmse_pagespeakers = $wpdb->get_results( $enmse_sppreparredsql );
						} else {
							$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d GROUP BY speaker_id ORDER BY last_name ASC"; 
							$enmse_spsql = $wpdb->prepare( $enmse_sppreparredsql, $enmse_podcast->series_type_id );
							$enmse_pagespeakers = $wpdb->get_results( $enmse_spsql );
						}
					}

					
				} else {
					if ( isset($_GET['enmse_pid']) && is_numeric($_GET['enmse_pid']) ) {
						$enmse_pid = strip_tags($_GET['enmse_pid']);
					}
					
					// Find Podcast to Edit
					$enmse_findthepodcastsql = "SELECT * FROM " . $wpdb->prefix . "se_podcasts" . " WHERE se_podcast_id = %d"; 
					$enmse_findthepodcast = $wpdb->prepare( $enmse_findthepodcastsql, $enmse_pid );
					$enmse_podcast = $wpdb->get_row( $enmse_findthepodcast, OBJECT );
					$enmse_podcastcount = $wpdb->num_rows;
					
					// Get Topics
					if ( $enmse_podcast->series_type_id == 0 ) {
						$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
						$enmse_pagetopics = $wpdb->get_results( $enmse_tpreparredsql );
					} else {
						$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND message_id IS NOT NULL GROUP BY name ORDER BY sort_id ASC";  
						$enmse_tsql = $wpdb->prepare( $enmse_tpreparredsql, $enmse_podcast->series_type_id );
						$enmse_pagetopics = $wpdb->get_results( $enmse_tsql );
					}
					
					// Get Series
					if ( $enmse_podcast->series_type_id == 0  ) {
						$enmse_spreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " ORDER BY start_date DESC"; 
						$enmse_pageseries = $wpdb->get_results( $enmse_spreparredsql );
					} else {
						$enmse_spreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d GROUP BY s_title ORDER BY start_date DESC"; 
						$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_podcast->series_type_id );
						$enmse_pageseries = $wpdb->get_results( $enmse_ssql );
					}
					
					// Get Speakers
					if ( $enmse_podcast->series_type_id == 0  ) {
						$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name DESC"; 
						$enmse_pagespeakers = $wpdb->get_results( $enmse_sppreparredsql );
					} else {
						$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d GROUP BY speaker_id ORDER BY last_name ASC"; 
						$enmse_spsql = $wpdb->prepare( $enmse_sppreparredsql, $enmse_podcast->series_type_id );
						$enmse_pagespeakers = $wpdb->get_results( $enmse_spsql );
					}
				}	
			}
			
			if ( ($_GET['enmse_action'] == 'new' && !isset($_GET['enmse_did']) ) && ( $_POST ) ) { // New Podcast
				
				$enmse_audio_video = strip_tags($_POST['podcast_audio_video']);
				
				if (empty($_POST['podcast_title'])) { 
					$enmse_errors[] = '- You must name the new podcast.';
				} else {
					$enmse_title = strip_tags($_POST['podcast_title']);
				}
				
				if (preg_match('/(href=)/', $_POST['podcast_description']) || preg_match('/(HREF=)/', $_POST['podcast_description'])) { 
					$enmse_errors[] = '- Sorry, no HTML is allowed in the description.';
				} else {
					if (empty($_POST['podcast_description'])) { 
						$enmse_errors[] = '- You must give the podcast a description.';
					} else {
						$enmse_description = strip_tags($_POST['podcast_description']);
					}
				}
				
				if (empty($_POST['podcast_author'])) { 
					$enmse_errors[] = '- You must supply an author.';
				} else {
					$enmse_author = strip_tags($_POST['podcast_author']);
				}
				
				if (empty($_POST['podcast_email'])) { 
					$enmse_errors[] = '- You must supply an author email.';
				} else {
					$enmse_author_email = strip_tags($_POST['podcast_email']);
				}
				
				if (empty($_POST['podcast_logo_url'])) { 
					$enmse_errors[] = '- You must supply a logo for your podcast.';
				} else {
					$enmse_logo_url = strip_tags($_POST['podcast_logo_url']);
				}
				
				$enmse_link_url = strip_tags($_POST['podcast_link_url']);

				if (empty($_POST['podcast_category'])) { 
					$enmse_errors[] = '- You must supply a category.';
				} else {
					$enmse_category = strip_tags($_POST['podcast_category']);
				}
				
				if (empty($_POST['podcast_subcategory'])) { 
					$enmse_errors[] = '- You must supply a subcategory.';
				} else {
					$enmse_subcategory = strip_tags($_POST['podcast_subcategory']);
				}
				
				if (empty($_POST['podcast_podcast_display'])) { 
					$enmse_errors[] = '- "How many messages?" cannot be blank.';
				} else {
					if (!is_numeric($_POST['podcast_podcast_display'])) { 
						$enmse_errors[] = '- "How many messages?" must be a number.';
					} else {
						$enmse_podcast_display = strip_tags($_POST['podcast_podcast_display']);
					}
				}

				if ( $_POST['podcast_explicit'] == 1 ) {
					$enmse_explicit = 1;
				} else {
					$enmse_explicit = 0;
				}

				$enmse_redirect = strip_tags($_POST['podcast_redirect']);
				$enmse_redirect_url = strip_tags($_POST['podcast_redirect_url']);
				$enmse_custom_lang = strip_tags($_POST['podcast_custom_lang']);
				
				$enmse_podcast_option = strip_tags($_POST['podcast_option']);
				
				$enmse_stid = strip_tags($_POST['podcast_st']);
				
				if ( $enmse_podcast_option == "mostrecent" ) {
					$enmse_sid = -1;
					$enmse_tid = -1;
					$enmse_spid = -1;
				} elseif ( $enmse_podcast_option == "series" ) {
					if (isset($_POST['podcast_s'])) {
						$enmse_sid = strip_tags($_POST['podcast_s']);
						$enmse_tid = -1;
						$enmse_spid = -1;
					} else {
						$enmse_errors[] = '- Please choose a Series to display.';
					}
				} elseif ( $enmse_podcast_option == "topic" ) {
					if (isset($_POST['podcast_t'])) {
						$enmse_sid = -1;
						$enmse_tid = strip_tags($_POST['podcast_t']);
						$enmse_spid = -1;
					} else {
						$enmse_errors[] = '- Please choose a Topic to display.';
					}
				} elseif ( $enmse_podcast_option == "speaker" ) {
					if (isset($_POST['podcast_sp'])) {
						$enmse_sid = -1;
						$enmse_tid = -1;
						$enmse_spid = strip_tags($_POST['podcast_sp']);
					} else {
						$enmse_errors[] = '- Please choose a Speaker to display.';
					}
				}
				
				if (empty($enmse_errors)) {
					$enmse_podcast_created = "yes";
					
					$enmse_newpodcast = array(
						'audio_video' => $enmse_audio_video, 
						'title' => $enmse_title,
						'description' => $enmse_description, 
						'author' => $enmse_author, 
						'email' => $enmse_author_email, 
						'logo_url' => $enmse_logo_url,
						'link_url' => $enmse_link_url, 
						'category' => $enmse_category, 
						'subcategory' => $enmse_subcategory, 
						'podcast_display' => $enmse_podcast_display, 
						'series_type_id' => $enmse_stid, 
						'series_id' => $enmse_sid, 
						'topic_id' => $enmse_tid,
						'speaker_id' => $enmse_spid,
						'explicit' => $enmse_explicit,  
						'redirect_podcast' => $enmse_redirect, 
						'redirect_url' => $enmse_redirect_url, 
						'custom_lang' => $enmse_custom_lang     
						); 
					$wpdb->insert( $wpdb->prefix . "se_podcasts", $enmse_newpodcast );
					$enmse_messages[] = "You have successfully added a new podcast to Series Engine!";
				} else {
					// Get Topics
					if ( $enmse_stid == 0 ) {
						$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
						$enmse_pagetopics = $wpdb->get_results( $enmse_tpreparredsql );
					} else {
						$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND message_id IS NOT NULL GROUP BY name ORDER BY sort_id ASC";  
						$enmse_tsql = $wpdb->prepare( $enmse_tpreparredsql, $enmse_stid );
						$enmse_pagetopics = $wpdb->get_results( $enmse_tsql );
					}
					
					// Get Series
					if ( $enmse_stid == 0  ) {
						$enmse_spreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " ORDER BY start_date DESC"; 
						$enmse_pageseries = $wpdb->get_results( $enmse_spreparredsql );
					} else {
						$enmse_spreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d GROUP BY s_title ORDER BY start_date DESC"; 
						$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $enmse_stid );
						$enmse_pageseries = $wpdb->get_results( $enmse_ssql );
					}
					
					// Get Speakers
					if ( $enmse_stid == 0  ) {
						$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name DESC"; 
						$enmse_pagespeakers = $wpdb->get_results( $enmse_sppreparredsql );
					} else {
						$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d GROUP BY speaker_id ORDER BY last_name ASC"; 
						$enmse_spsql = $wpdb->prepare( $enmse_sppreparredsql, $enmse_stid );
						$enmse_pagespeakers = $wpdb->get_results( $enmse_spsql );
					}
				}
			}
		}
		
		// Get All Podcasts
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_podcasts" . " ORDER BY se_podcast_id ASC"; 
		$enmse_podcasts = $wpdb->get_results( $enmse_preparredsql );
		
		// Get All Series Types
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
		$enmse_series_types = $wpdb->get_results( $enmse_preparredsql );
	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap"> 
<?php if ( isset($_GET['enmse_action']) && ( $enmse_podcast_created == null && !isset($_GET['enmse_did']) ) ) { if ( $_GET['enmse_action'] == 'new' ) { // If they're adding a new Podcast ?>
		<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/podcast_code281.js'; ?>"></script>
		
		<h2 class="enmse">Create a New Podcast</h2>
		<?php include ('errorbox.php'); ?>
		<p>Use the form below to create a new Podcast with the Series Engine. When you're finished, simply copy and paste the provided Podcast link into iTunes or another service to share it with the world! <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-podcasts"; ?>" class="enmse-learn-more">Learn more about Podcasts...</a></p>
		<p id="enmse-get-plugin-link" title="<?php echo plugins_url() .'/seriesengine_plugin/includes/admin/'; ?>"></p>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Type of Podcast?:</th>
					<td>
						<select name="podcast_audio_video" id="podcast_audio_video" tabindex="1">
							<option value="Audio" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_audio_video'] == "Audio") { ?>selected="selected"<?php }} ?>>Audio</option>
							<option value="Video" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_audio_video'] == "Video") { ?>selected="selected"<?php }} ?>>Video</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Title:</th>
					<td><input id='podcast_title' name='podcast_title' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_title']);} ?>' tabindex="2" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Description:</th>
					<td><textarea name="podcast_description" id="podcast_description" rows="8" cols="40" tabindex="3"><?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_description']);} ?></textarea><br /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Author:</th>
					<td><input id='podcast_author' name='podcast_author' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_author']);} ?>' tabindex="4" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Author Email:</th>
					<td><input id='podcast_email' name='podcast_email' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_email']);} ?>' tabindex="5" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Logo URL:
						<p class="se-form-instructions">Apple requires a JPG or PNG that is at least 1400x1400px.</p>
					</th>
					<td><input id='podcast_logo_url' name='podcast_logo_url' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_logo_url'];} ?>' tabindex="6" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=image&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-podcast-image se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="podcast-thumb-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['podcast_logo_url'])) { ?><br /><img src="<?php echo $_POST['podcast_logo_url']; ?>" /><?php } ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Link URL:
						<p class="se-form-instructions">Leave blank, or enter the permalink for a page where Series Engine is embedded (be sure to include the slash at the end).</p>
					</th>
					<td><input id='podcast_link_url' name='podcast_link_url' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_link_url'];} ?>' tabindex="7" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Category:
						<p class="se-form-instructions">Use the right side of the <a href="http://www.apple.com/itunes/podcasts/specs.html#categories" target="_blank">iTunes Category Chart</a> to select a properly formatted category and subcategory (below).</p>
					</th>
					<td><input id='podcast_category' name='podcast_category' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_category']);} ?>' tabindex="8" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Subcategory:</th>
					<td><input id='podcast_subcategory' name='podcast_subcategory' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_subcategory']);} ?>' tabindex="9" /></td>				</tr>
				<tr valign="top">
					<th scope="row">How Many <?php echo $enmsemessagetp; ?>?:</th>
					<td><input id='podcast_podcast_display' name='podcast_podcast_display' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_podcast_display'];} else { echo "10"; } ?>' tabindex="10" size="3" /></td>				</tr>
				<tr valign="top">
					<th scope="row">This Podcast Displays...:</th>
					<td>
						<select name="podcast_option" id="podcast_option" tabindex="11">
							<option value="mostrecent" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_option'] == "mostrecent") { ?>selected="selected"<?php }} ?>>The Most Recent <?php echo $enmsemessagetp; ?></option>
							<option value="series" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_option'] == "series") { ?>selected="selected"<?php }} ?>>All Messages Within a <?php echo $enmseseriest; ?></option>
							<option value="topic" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_option'] == "topic") { ?>selected="selected"<?php }} ?>>All Messages Within a <?php echo $enmsetopict; ?></option>
							<option value="speaker" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_option'] == "speaker") { ?>selected="selected"<?php }} ?>>All Messages From a <?php echo $enmsespeakert; ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">...From the <?php echo $enmseseriest; ?> Type...:</th>
					<td>
						<select name="podcast_st" id="podcast_st" tabindex="12">
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_st'] == "0") { ?>selected="selected"<?php }} ?>>All <?php echo $enmseseriest; ?> Types</option>
							<?php foreach ( $enmse_series_types as $enmse_single ) { ?>
							<option value="<?php echo $enmse_single->series_type_id ?>" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_st'] == $enmse_single->series_type_id ) { ?>selected="selected"<?php }} elseif ( $enmse_primaryst == $enmse_single->series_type_id ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->name) ?><?php if ( $enmse_primaryst == $enmse_single->series_type_id ) { echo " (Primary)"; }; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr valign="top" id="podcast_series_topic">
					<?php if ($_POST && !empty($enmse_errors)) {if ($enmse_podcast_option == "series" && isset($_POST['podcast_s'])) { ?>
						<th scope="row">...From the <?php echo $enmseseriest; ?>...:</th>
						<td>
							<select name="podcast_s" id="podcast_s" tabindex="13">
								<?php foreach ( $enmse_pageseries as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->series_id ?>" <?php if ($_POST['podcast_s'] == $enmse_single->series_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->s_title) ?></option>
								<?php } ?>
							</select>
						</td>
					<?php } elseif ($enmse_podcast_option == "series") { ?>
						<th scope="row">...From the <?php echo $enmseseriest; ?>...:</th>
						<td>
							<p><strong>There are no <?php echo $enmseseriestp; ?> associated with this <?php echo $enmseseriest; ?> Type. Please choose another <?php echo $enmseseriest; ?> Type to continue.</strong></p>

						</td>
					<?php }} ?>
					<?php if ($_POST && !empty($enmse_errors)) {if ($enmse_podcast_option == "topic" && isset($_POST['podcast_t'])) { ?>
						<th scope="row">...From the <?php echo $enmsetopict; ?>...:</th>
						<td>
							<select name="podcast_t" id="podcast_t" tabindex="13">
								<?php foreach ( $enmse_pagetopics as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->topic_id ?>" <?php if ($_POST['podcast_t'] == $enmse_single->topic_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->name) ?></option>
								<?php } ?>
							</select>
						</td>
					<?php } elseif ($enmse_podcast_option == "topic") { ?>
							<th scope="row">...From the <?php echo $enmsetopict; ?>...:</th>
							<td>
								<p><strong>There are no <?php echo $enmsetopictp; ?> associated with this <?php echo $enmseseriest; ?> Type. Please choose another <?php echo $enmseseriest; ?> Type to continue.</strong></p>

							</td>
					<?php }} ?>
					<?php if ($_POST && !empty($enmse_errors)) {if ($enmse_podcast_option == "speaker" && isset($_POST['podcast_sp'])) { ?>
						<th scope="row">...From the <?php echo $enmsespeakert; ?>...:</th>
						<td>
							<select name="podcast_sp" id="podcast_sp" tabindex="13">
								<?php foreach ( $enmse_pagespeakers as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->speaker_id ?>" <?php if ($_POST['podcast_sp'] == $enmse_single->speaker_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->first_name) . " " . stripslashes($enmse_single->last_name); ?></option>
								<?php } ?>
							</select>
						</td>
					<?php } elseif ($enmse_podcast_option == "speaker") { ?>
							<th scope="row">...From the <?php echo $enmsespeakert; ?>...:</th>
							<td>
								<p><strong>There are no <?php echo $enmsespeakertp; ?> associated with this <?php echo $enmseseriest; ?> Type. Please choose another <?php echo $enmseseriest; ?> Type to continue.</strong></p>
					
							</td>
					<?php }} ?>
				</tr>
				<tr valign="top">
					<th scope="row">Explicit Content?:</th>
					<td>
						<select name="podcast_explicit" id="podcast_explicit" tabindex="14">
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_explicit'] == 0) { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_explicit'] == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Redirect This Podcast?:
						<p class="se-form-instructions">Point those subscribed to this podcast to a different podcast feed instead.</p>
					</th>
					<td>
						<select name="podcast_redirect" id="podcast_redirect" tabindex="15">
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_redirect'] == "0") { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_redirect'] == "1") { ?>selected="selected"<?php }} ?>>Yes, with a 301 redirect</option>
							<option value="2" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_redirect'] == "2") { ?>selected="selected"<?php }} ?>>Yes, with iTunes "New Feed" Tag</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Redirect URL:
						<p class="se-form-instructions">If you're redirecting, provide the full URL of the new podcast.</p>
					</th>
					<td><input id='podcast_redirect_url' name='podcast_redirect_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_redirect_url']);} ?>" tabindex="16" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Podcast Language:
						<p class="se-form-instructions">Leave this blank unless you've manually customized the language labels of your install. You can find a list of <a href="http://www.rssboard.org/rss-language-codes" target="_blank">language codes here</a>.</p>
					</th>
					<td><input id='podcast_custom_lang' name='podcast_custom_lang' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_custom_lang']);} ?>" tabindex="17" /></td>
				</tr>
			</table>
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Create Podcast" tabindex="14" /></p>
		</form>
		<p><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts', __FILE__ ) ?>">&laquo; All Podcasts</a></p>
		<input type="hidden" name="xxse" value="<?php echo base64_encode(ABSPATH); ?>" id="xxse" />
		<?php include ('secredits.php'); ?>
<?php } elseif ( ($_GET['enmse_action'] == 'edit') && ( $enmse_podcastcount == 1 ) ) { ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/podcast_code281.js'; ?>"></script>
	
	<h2 class="enmse">Edit Podcast <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Use the form below to update Podcast with the Series Engine. When you're finished, simply copy and paste the provided Podcast link into iTunes or another service to share it with the world! <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-podcasts"; ?>" class="enmse-learn-more">Learn more about Podcasts...</a></p>

		<p id="enmse-get-plugin-link" title="<?php echo plugins_url() .'/seriesengine_plugin/includes/admin/'; ?>"></p>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<table class="form-table">

				<tr valign="top">
					<th scope="row">Type of Podcast?:</th>
					<td>
						<select name="podcast_audio_video" id="podcast_audio_video" tabindex="1" <?php if ( $enmse_pid == 1 ) { echo 'class="enmse-disabled" disabled'; } ?>>
							<option value="Audio" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_audio_video'] == "Audio") { ?>selected="selected"<?php }} else {if ($enmse_podcast->audio_video == "Audio") { ?>selected="selected"<?php }} ?>>Audio</option>
							<option value="Video" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_audio_video'] == "Video") { ?>selected="selected"<?php }} else {if ($enmse_podcast->audio_video == "Video") { ?>selected="selected"<?php }} ?>>Video</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Title:</th>
					<td><input id='podcast_title' name='podcast_title' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_title']);} else {echo stripslashes($enmse_podcast->title);} ?>" tabindex="2" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Description:</th>
					<td><textarea name="podcast_description" id="podcast_description" rows="8" cols="40" tabindex="3"><?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_description']);} else {echo stripslashes($enmse_podcast->description);} ?></textarea><br /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Author:</th>
					<td><input id='podcast_author' name='podcast_author' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_author']);} else {echo stripslashes($enmse_podcast->author);} ?>" tabindex="4" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Author Email:</th>
					<td><input id='podcast_email' name='podcast_email' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_email'];} else {echo $enmse_podcast->email;} ?>' tabindex="5" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Logo URL:
						<p class="se-form-instructions">Apple requires a JPG or PNG that is at least 1400x1400px.</p>
					</th>
					<td><input id='podcast_logo_url' name='podcast_logo_url' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_logo_url'];} else {echo $enmse_podcast->logo_url;} ?>' tabindex="6" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=image&#038;TB_iframe=1', __FILE__ ); ?>" class="enmse-upload-podcast-image se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="podcast-thumb-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['podcast_logo_url'])) { ?><br /><img src="<?php echo $_POST['podcast_logo_url']; ?>" /><?php } elseif ( $enmse_podcast->logo_url != NULL ) { ?><br /><img src="<?php echo $enmse_podcast->logo_url; ?>" style="width: 36%" /><?php }; ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Link URL:
						<p class="se-form-instructions">Leave blank, or enter the permalink for a page where Series Engine is embedded (be sure to include the slash at the end).</p>
					</th>
					<td><input id='podcast_link_url' name='podcast_link_url' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_link_url'];} else {echo $enmse_podcast->link_url;} ?>' tabindex="7" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Category:
						<p class="se-form-instructions">Use the right side of the <a href="http://www.apple.com/itunes/podcasts/specs.html#categories" target="_blank">iTunes Category Chart</a> to select a properly formatted category and subcategory (below).</p>
					</th>
					<td><input id='podcast_category' name='podcast_category' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_category'];} else {echo $enmse_podcast->category;} ?>' tabindex="8" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Subcategory:</th>
					<td><input id='podcast_subcategory' name='podcast_subcategory' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_subcategory'];} else {echo $enmse_podcast->subcategory;} ?>' tabindex="9" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">How Many <?php echo $enmsemessagetp; ?>?:</th>
					<td><input id='podcast_podcast_display' name='podcast_podcast_display' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['podcast_podcast_display'];} else {echo $enmse_podcast->podcast_display;} ?>' tabindex="10" size="3" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">This Podcast Displays...:</th>
					<td>
						<select name="podcast_option" id="podcast_option" tabindex="11" <?php if ( $enmse_pid == 1 ) { echo 'class="enmse-disabled" disabled'; } ?>>
							<option value="mostrecent" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_option'] == "mostrecent") { ?>selected="selected"<?php }} else {if ($enmse_podcast->series_id < 1 && $enmse_podcast->topic_id < 1 && $enmse_podcast->speaker_id < 1 ) { ?>selected="selected"<?php }} ?>>The Most Recent <?php echo $enmsemessagetp; ?></option>
							<option value="series" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_option'] == "series") { ?>selected="selected"<?php }} else {if ($enmse_podcast->series_id > 0 && $enmse_podcast->topic_id < 1 ) { ?>selected="selected"<?php }} ?>>All Messages Within a <?php echo $enmseseriest; ?></option>
							<option value="topic" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_option'] == "topic") { ?>selected="selected"<?php }} else {if ($enmse_podcast->series_id < 1 && $enmse_podcast->topic_id > 0 ) { ?>selected="selected"<?php }} ?>>All Messages Within a <?php echo $enmsetopict; ?></option>
							<option value="speaker" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_option'] == "speaker") { ?>selected="selected"<?php }} else {if ($enmse_podcast->speaker_id > 0 ) { ?>selected="selected"<?php }} ?>>All Messages From a <?php echo $enmsespeakert; ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">...From the <?php echo $enmseseriest; ?> Type...:</th>
					<td>
						<select name="podcast_st" id="podcast_st" tabindex="12" <?php if ( $enmse_pid == 1 ) { echo 'class="enmse-disabled" disabled'; } ?>>
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_st'] == "0") { ?>selected="selected"<?php }} else {if ($enmse_podcast->series_type_id == 0 ) { ?>selected="selected"<?php }} ?>>All <?php echo $enmseseriest; ?> Types</option>
							<?php foreach ( $enmse_series_types as $enmse_single ) { ?>
							<option value="<?php echo $enmse_single->series_type_id ?>" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_st'] == $enmse_single->series_type_id ) { ?>selected="selected"<?php }} else {if ($enmse_podcast->series_type_id == $enmse_single->series_type_id ) { ?>selected="selected"<?php }} ?>><?php echo stripslashes($enmse_single->name) ?><?php if ( $enmse_primaryst == $enmse_single->series_type_id ) { echo " (Primary)"; }; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr valign="top" id="podcast_series_topic">
					<?php if ($_POST && !empty($enmse_errors)) {if ($enmse_podcast_option == "series" && isset($_POST['podcast_s'])) { ?>
						<th scope="row">...From the <?php echo $enmseseriest; ?>...:</th>
						<td>
							<select name="podcast_s" id="podcast_s" tabindex="13">
								<?php foreach ( $enmse_pageseries as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->series_id ?>" <?php if ($_POST['podcast_s'] == $enmse_single->series_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->s_title) ?></option>
								<?php } ?>
							</select>
						</td>
					<?php } elseif ($enmse_podcast_option == "series") { ?>
						<th scope="row">...From the <?php echo $enmseseriest; ?>...:</th>
						<td>
							<p><strong>There are no <?php echo $enmseseriestp; ?> associated with this <?php echo $enmseseriest; ?> Type. Please choose another <?php echo $enmseseriest; ?> Type to continue.</strong></p>

						</td>
					<?php }} elseif ($enmse_podcast->series_id > 0 ) { ?>
						<th scope="row">...From the <?php echo $enmseseriest; ?>...:</th>
						<td>
							<select name="podcast_s" id="podcast_s" tabindex="13">
								<?php foreach ( $enmse_pageseries as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->series_id ?>" <?php if ($enmse_podcast->series_id == $enmse_single->series_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->s_title) ?></option>
								<?php } ?>
							</select>
						</td>	
					<?php } ?>
					<?php if ($_POST && !empty($enmse_errors)) {if ($enmse_podcast_option == "topic" && isset($_POST['podcast_t'])) { ?>
						<th scope="row">...From the <?php echo $enmsetopict; ?>...:</th>
						<td>
							<select name="podcast_t" id="podcast_t" tabindex="13">
								<?php foreach ( $enmse_pagetopics as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->topic_id ?>" <?php if ($_POST['podcast_t'] == $enmse_single->topic_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->name) ?></option>
								<?php } ?>
							</select>
						</td>
					<?php } elseif ($enmse_podcast_option == "topic") { ?>
							<th scope="row">...From the <?php echo $enmsetopict; ?>...:</th>
							<td>
								<p><strong>There are no <?php echo $enmsetopictp; ?> associated with this <?php echo $enmseseriest; ?> Type. Please choose another <?php echo $enmseseriest; ?> Type to continue.</strong></p>

							</td>
					<?php }} elseif ($enmse_podcast->topic_id > 0 ) { ?>
						<th scope="row">...From the <?php echo $enmsetopict; ?>...:</th>
						<td>
							<select name="podcast_t" id="podcast_t" tabindex="13">
								<?php foreach ( $enmse_pagetopics as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->topic_id ?>" <?php if ($enmse_podcast->topic_id == $enmse_single->topic_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->name) ?></option>
								<?php } ?>
							</select>
						</td>	
					<?php } ?>
					<?php if ($_POST && !empty($enmse_errors)) {if ($enmse_podcast_option == "speaker" && isset($_POST['podcast_sp'])) { ?>
						<th scope="row">...From the <?php echo $enmsespeakert; ?>...:</th>
						<td>
							<select name="podcast_sp" id="podcast_sp" tabindex="13">
								<?php foreach ( $enmse_pagespeakers as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->speaker_id ?>" <?php if ($_POST['podcast_sp'] == $enmse_single->speaker_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->first_name) . " " . stripslashes($enmse_single->last_name); ?></option>
								<?php } ?>
							</select>
						</td>
					<?php } elseif ($enmse_podcast_option == "speaker") { ?>
							<th scope="row">...From the <?php echo $enmsespeakert; ?>...:</th>
							<td>
								<p><strong>There are no <?php echo $enmsespeakertp; ?> associated with this <?php echo $enmseseriest; ?> Type. Please choose another <?php echo $enmseseriest; ?> Type to continue.</strong></p>
					
							</td>
					<?php }} elseif ($enmse_podcast->speaker_id > 0 ) { ?>
						<th scope="row">...From the <?php echo $enmsespeakert; ?>...:</th>
						<td>
							<select name="podcast_sp" id="podcast_sp" tabindex="13">
								<?php foreach ( $enmse_pagespeakers as $enmse_single ) { ?>
								<option value="<?php echo $enmse_single->speaker_id ?>" <?php if ($enmse_podcast->speaker_id == $enmse_single->speaker_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmse_single->first_name) . " " . stripslashes($enmse_single->last_name); ?></option>
								<?php } ?>
							</select>
						</td>	
					<?php } ?>
				</tr>
				<tr valign="top">
					<th scope="row">Explicit Content?:</th>
					<td>
						<select name="podcast_explicit" id="podcast_explicit" tabindex="14">
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_explicit'] == 0) { ?>selected="selected"<?php }} else {if  ( $enmse_podcast->explicit == 0 ) { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_explicit'] == 1) { ?>selected="selected"<?php }} else {if  ( $enmse_podcast->explicit == 1 ) { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Redirect This Podcast?:
						<p class="se-form-instructions">Point those subscribed to this podcast to a different podcast feed instead.</p>
					</th>
					<td>
						<select name="podcast_redirect" id="podcast_redirect" tabindex="15">
							<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_redirect'] == "0") { ?>selected="selected"<?php }} else {if ($enmse_podcast->redirect_podcast == "0") { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_redirect'] == "1") { ?>selected="selected"<?php }} else {if ($enmse_podcast->redirect_podcast == "1") { ?>selected="selected"<?php }} ?>>Yes, with a 301 redirect</option>
							<option value="2" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['podcast_redirect'] == "2") { ?>selected="selected"<?php }} else {if ($enmse_podcast->redirect_podcast == "2") { ?>selected="selected"<?php }} ?>>Yes, with iTunes "New Feed" Tag</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Redirect URL:
						<p class="se-form-instructions">If you're redirecting, provide the full URL of the new podcast.</p>
					</th>
					<td><input id='podcast_redirect_url' name='podcast_redirect_url' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_redirect_url']);} else {echo stripslashes($enmse_podcast->redirect_url);} ?>" tabindex="16" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Podcast Language:
						<p class="se-form-instructions">Leave this blank unless you've manually customized the language labels of your install. You can find a list of <a href="http://www.rssboard.org/rss-language-codes" target="_blank">language codes here</a>.</p>
					</th>
					<td><input id='podcast_custom_lang' name='podcast_custom_lang' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo stripslashes($_POST['podcast_custom_lang']);} else {echo stripslashes($enmse_podcast->custom_lang);} ?>" tabindex="17" /></td>
				</tr>
			</table>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Save Changes" tabindex="18" /></p>
	</form>
	<p><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts', __FILE__ ) ?>">&laquo; All Podcasts</a></p>
	<input type="hidden" name="xxse" value="<?php echo base64_encode(ABSPATH); ?>" id="xxse" />
	<?php include ('secredits.php'); ?>
<?php }} else { // Display the main listing of topics ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/deletepodcast.js'; ?>"></script>
	
	<h2 class="enmse">Generate Podcasts <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>
	<p>Below you'll find a list of all of the Podcasts you've created with the Series Engine. Click on the name of the Podcast to edit its settings. Copy and paste the Podcast Link to share it in a service like iTunes. You can permanently delete the Podcast from the Series Engine by clicking the "Delete" link. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-podcasts"; ?>" class="enmse-learn-more">Learn more about Podcasts...</a></p>

	<table class="widefat" id="enmse-topics"> 
		<thead> 
			<tr> 
				<th>Podcast Name</th> 
				<th>Podcast Link</th>
				<th>Type</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmse_podcasts as $enmse_podcast ) { ?>
			<tr id="row_<?php echo $enmse_podcast->se_podcast_id ?>">
				<td><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts&amp;enmse_action=edit&amp;enmse_pid=' . $enmse_podcast->se_podcast_id, __FILE__ ) ?>"><?php echo stripslashes($enmse_podcast->title) ?></a></td>
				<td><?php if ( $enmse_podcast->se_podcast_id > 1 ) { echo home_url() . "/?feed=seriesengine&amp;enmse_pid=" . $enmse_podcast->se_podcast_id; } else { echo home_url() . "/?feed=seriesengine"; }; ?></td>	
				<td><?php echo $enmse_podcast->audio_video ?></td>				
				<td class="enmse-delete"><?php if ( $enmse_podcast->se_podcast_id > 1 ) { ?><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmse_did=1" method="post" id="seriesengine-deleteform<?php echo $enmse_podcast->se_podcast_id ?>"><input type="hidden" name="podcast_delete" value="<?php echo $enmse_podcast->se_podcast_id ?>"></form><a href="#" class="seriesengine_delete" name="<?php echo $enmse_podcast->se_podcast_id ?>">Delete</a><?php } ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php include ('secredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
