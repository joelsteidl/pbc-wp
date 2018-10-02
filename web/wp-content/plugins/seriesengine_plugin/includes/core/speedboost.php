<?php 

			$newbmmx = $wpdb->prefix . "se_book_message_matches";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newbmmx'") == $newbmmx ) {
				$sql = "ALTER TABLE " . $newbmmx .
					" ADD INDEX(`message_id`),
					ADD INDEX(`book_id`)";
				$wpdb->query($sql);
			}

			$newmessagesx = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagesx'") == $newmessagesx ) {
				$sql = "ALTER TABLE " . $newmessagesx .
					" ADD INDEX(`video_embed_url`),
					ADD INDEX(`audio_url`),
					ADD INDEX(`alternate_toggle`),
					ADD INDEX(`additional_video_embed_url`),
					ADD INDEX(`date`)";
				$wpdb->query($sql);
			}

			$newmfmx = $wpdb->prefix . "se_message_file_matches";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmfmx'") == $newmfmx ) {
				$sql = "ALTER TABLE " . $newmfmx .
					" ADD INDEX(`message_id`),
					ADD INDEX(`file_id`)";
				$wpdb->query($sql);
			}

			$newmspmx = $wpdb->prefix . "se_message_speaker_matches";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmspmx'") == $newmspmx ) {
				$sql = "ALTER TABLE " . $newmspmx .
					" ADD INDEX(`message_id`),
					ADD INDEX(`speaker_id`)";
				$wpdb->query($sql);
			}

			$newmtmx = $wpdb->prefix . "se_message_topic_matches";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmtmx'") == $newmtmx ) {
				$sql = "ALTER TABLE " . $newmtmx .
					" ADD INDEX(`message_id`),
					ADD INDEX(`topic_id`)";
				$wpdb->query($sql);
			}

			$newmscmx = $wpdb->prefix . "se_scripture_message_matches";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmscmx'") == $newmscmx ) {
				$sql = "ALTER TABLE " . $newmscmx .
					" ADD INDEX(`message_id`),
					ADD INDEX(`scripture_id`)";
				$wpdb->query($sql);
			}

			$newseriesx = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriesx'") == $newseriesx ) {
				$sql = "ALTER TABLE " . $newseriesx .
					" ADD INDEX(`start_date`)";
				$wpdb->query($sql);
			}

			$newsmmx = $wpdb->prefix . "se_series_message_matches";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newsmmx'") == $newsmmx ) {
				$sql = "ALTER TABLE " . $newsmmx .
					" ADD INDEX(`message_id`),
					ADD INDEX(`series_id`)";
				$wpdb->query($sql);
			}

			$newstsmx = $wpdb->prefix . "se_series_type_matches";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newstsmx'") == $newstsmx ) {
				$sql = "ALTER TABLE " . $newstsmx .
					" ADD INDEX(`series_type_id`),
					ADD INDEX(`series_id`)";
				$wpdb->query($sql);
			}

 ?>