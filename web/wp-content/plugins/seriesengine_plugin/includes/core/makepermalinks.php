<?php 

			$enmse_options = get_option( 'enm_seriesengine_options' ); 

			if ( isset($enmse_options['messaget']) ) { // Find Message Title
				$enmsemessaget = $enmse_options['messaget'];
			} else {
				$enmsemessaget = "Message";
			}

			if ( isset($enmse_options['seriest']) ) { // Find series Title
				$enmseseriest = $enmse_options['seriest'];
			} else {
				$enmseseriest = "Series";
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

			$enmse_findpermamessagesql = "SELECT message_id, date, title, speaker, primary_series, description FROM " . $wpdb->prefix . "se_messages" . " WHERE wp_post_id IS NULL"; 
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
					'post_content' => '<span style="display: none"></span>',
					'post_status' => 'publish',
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

 ?>