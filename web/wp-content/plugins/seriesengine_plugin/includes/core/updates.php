<?php 

// Running less than version 1.1?
if ( !get_option( 'enmse_db_version' ) ) {
	
	global $wpdb;

		$speakers = $wpdb->prefix . "se_speakers"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$speakers'") != $speakers ) { // Create and populate the table if it doesn't already exist

				$sql = "CREATE TABLE $speakers ( 
					speaker_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  				first_name varchar(50) DEFAULT NULL,
					last_name varchar(50) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 

					$firstspeaker = array( // Add a sample prayer to the database
						'speaker_id' => '1', 
						'first_name' => 'Eric', 
						'last_name' => 'Murrell'
						); 
					$wpdb->insert( $speakers, $firstspeaker );
			}

			$message_speaker_matches = $wpdb->prefix . "se_message_speaker_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$message_speaker_matches'") != $message_speaker_matches ) { // Create and populate the table if it doesn't already exist

				$sql = "CREATE TABLE $message_speaker_matches ( 
					msp_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  				message_id int(11) NOT NULL,
					speaker_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 

					$firstmspmatch = array( // Match sample topic to sample message
						'msp_match_id' => '1', 
						'message_id' => '1', 
						'speaker_id' => '1'
					); 
					$wpdb->insert( $message_speaker_matches, $firstmspmatch );
			}
		
			$files = $wpdb->prefix . "se_files"; 
				if( $wpdb->get_var("SHOW TABLES LIKE '$files'") != $files ) { // Create and populate the table if it doesn't already exist

					$sql = "CREATE TABLE $files ( 
						file_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  			file_name varchar(255) DEFAULT NULL,
						file_url varchar(255) DEFAULT NULL,
						file_username varchar(255) DEFAULT NULL,
						file_new_window int(2) NULL,
						sort_id int(11) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
					);"; 
					require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
					dbDelta($sql); 
			}

			$message_file_matches = $wpdb->prefix . "se_message_file_matches"; 
				if( $wpdb->get_var("SHOW TABLES LIKE '$message_file_matches'") != $message_file_matches ) { // Create and populate the table if it doesn't already exist

					$sql = "CREATE TABLE $message_file_matches ( 
						mf_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  			message_id int(11) NOT NULL,
						file_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
					);"; 
					require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
					dbDelta($sql); 
				}

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"   ADD speaker_id int(11) NOT NULL,
					ADD link_url varchar(150) DEFAULT NULL, 
					ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD graphic_thumb varchar(255) DEFAULT NULL, 
					ADD widget_thumb varchar(255) DEFAULT NULL,
					ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$se_options = get_option( 'enm_seriesengine_options' );
			generate_se_options_css($se_options);
		
			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			add_option("enmse_db_version", $enmse_db_version);
		
// Upgrade 1.1 users to 1.7	
} elseif ( get_option('enmse_db_version') == "1.1" ) {
			global $wpdb;
			
			$files = $wpdb->prefix . "se_files"; 
				if( $wpdb->get_var("SHOW TABLES LIKE '$files'") != $files ) { // Create and populate the table if it doesn't already exist

					$sql = "CREATE TABLE $files ( 
						file_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  			file_name varchar(255) DEFAULT NULL,
						file_url varchar(255) DEFAULT NULL,
						file_username varchar(255) DEFAULT NULL,
						file_new_window int(2) NULL,
						sort_id int(11) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
					);"; 
					require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
					dbDelta($sql); 
			}

			$message_file_matches = $wpdb->prefix . "se_message_file_matches"; 
				if( $wpdb->get_var("SHOW TABLES LIKE '$message_file_matches'") != $message_file_matches ) { // Create and populate the table if it doesn't already exist

					$sql = "CREATE TABLE $message_file_matches ( 
						mf_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  			message_id int(11) NOT NULL,
						file_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
					);"; 
					require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
					dbDelta($sql); 
				}

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD link_url varchar(150) DEFAULT NULL, 
					ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD graphic_thumb varchar(255) DEFAULT NULL, 
					ADD widget_thumb varchar(255) DEFAULT NULL,
					ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$se_options = get_option( 'enm_seriesengine_options' );
			generate_se_options_css($se_options);
			
			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
// Upgrade 1.2 users to 1.7		
} elseif ( get_option('enmse_db_version') == "1.2" ) {

	global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD link_url varchar(150) DEFAULT NULL, 
					ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD graphic_thumb varchar(255) DEFAULT NULL, 
					ADD widget_thumb varchar(255) DEFAULT NULL,
					ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

	// Define DB version
	global $enmse_db_version;
	$enmse_db_version = "2.8.7";
	update_option("enmse_db_version", $enmse_db_version);
// Upgrade 1.3 users to 1.7	
} elseif ( get_option('enmse_db_version') == "1.3" ) {

	function enmse_onethreeone() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD link_url varchar(150) DEFAULT NULL, 
					ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD graphic_thumb varchar(255) DEFAULT NULL, 
					ADD widget_thumb varchar(255) DEFAULT NULL,
					ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD link_url varchar(150) DEFAULT NULL, 
					ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD graphic_thumb varchar(255) DEFAULT NULL, 
					ADD widget_thumb varchar(255) DEFAULT NULL,
					ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_onethreeone();
	}
// Upgrade 1.3.1 users or later to 1.7
} elseif ( get_option('enmse_db_version') == "1.3.1" ) {

	function enmse_onefivezero() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD graphic_thumb varchar(255) DEFAULT NULL, 
					ADD widget_thumb varchar(255) DEFAULT NULL,
					ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$data = get_option( 'enm_seriesengine_options' ); ;	
		$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
		ob_start(); // Capture all output (output buffering)
		include($css_dir . 'se_styles_generate.php'); // Generate CSS
		$css = ob_get_clean(); // Get generated CSS (output buffering)
		file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD graphic_thumb varchar(255) DEFAULT NULL, 
					ADD widget_thumb varchar(255) DEFAULT NULL,
					ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_onefivezero();
	}
} elseif ( get_option('enmse_db_version') == "1.5" ) { //Upgrade 1.5 users or later to 1.7

	function enmse_onesevenzero() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_onesevenzero();
	}
	
} elseif ( get_option('enmse_db_version') == "1.7" ) { //Upgrade 1.7 users to 1.7.2

	function enmse_onesevenone() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_onesevenone();
	}
	
} elseif ( get_option('enmse_db_version') == "1.7.1" ) { //Upgrade 1.7.1 users to 1.7.2

	function enmse_oneseventwo() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneseventwo();
	}
	
} elseif ( get_option('enmse_db_version') == "1.7.2" ) { //Upgrade 1.7.2 users to 1.7.3

	function enmse_oneseventhree() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneseventhree();
	}
	
} elseif ( get_option('enmse_db_version') == "1.7.3" ) { //Upgrade 1.7.3 users to 1.8

	function enmse_oneeight() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneeight();
	}
	
} elseif ( get_option('enmse_db_version') == "1.8" ) { //Upgrade 1.8 users to 1.8.1

	function enmse_oneeightone() {
		global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneeightone();
	}
	
} elseif ( get_option('enmse_db_version') == "1.8.1" ) { //Upgrade 1.8.1 users to 1.8.2

	function enmse_oneeighttwo() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					"  ADD explicit int(11) DEFAULT NULL,
					ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneeighttwo();
	}
	
} elseif ( get_option('enmse_db_version') == "1.8.2" ) { //Upgrade 1.8.2 users to 1.8.3

	function enmse_oneeightthree() {
		global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneeightthree();
	}
	
} elseif ( get_option('enmse_db_version') == "1.8.3" ) { //Upgrade 1.8.3 users to 1.8.4

	function enmse_oneeightfour() {
		global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					"  ADD file_new_window int(2) NULL,
					ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneeightfour();
	}
	
} elseif ( get_option('enmse_db_version') == "1.8.4" ) { //Upgrade 1.8.3 users to 1.8.5

	function enmse_oneeightfive() {
		global $wpdb;


			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					" ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					" ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneeightfive();
	}
	
} elseif ( get_option('enmse_db_version') == "1.8.5" ) { //Upgrade 1.8.5 users to 1.8.6

	function enmse_oneeightsix() {
		global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					" ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD video_embed_url varchar(255) DEFAULT NULL,
					ADD additional_video_embed_url varchar(255) DEFAULT NULL,
					ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					" ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_oneeightsix();
	}
	
}  elseif ( get_option('enmse_db_version') == "1.8.6" ) { //Upgrade 1.8.6 users to 1.9

	function enmse_onenine() {
		global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					" ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					ADD redirect_podcast int(2) DEFAULT NULL,
					ADD redirect_url varchar(255) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					" ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_onenine();
	}
	
}  elseif ( get_option('enmse_db_version') == "1.9" || get_option('enmse_db_version') == "1.9.1" || get_option('enmse_db_version') == "1.9.5" || get_option('enmse_db_version') == "1.9.6"  ) { //Upgrade 1.9.6 to 2.5

	function enmse_twozero() {
		global $wpdb;

		$newpodtest = $wpdb->prefix . "se_podcasts";
		if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
			$sql = "ALTER TABLE " . $newpodtest .
				" ADD book_id int(11) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
			$wpdb->query($sql);
		}

		$newseriestest = $wpdb->prefix . "se_series";
		if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
			$sql = "ALTER TABLE " . $newseriestest .
				" ADD podcast_image varchar(255) DEFAULT NULL";
			$wpdb->query($sql);
		}

		$newmessagetest = $wpdb->prefix . "se_messages";
		if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
			$sql = "ALTER TABLE " . $newmessagetest .
				" ADD audio_count int(11) NULL,
				ADD video_count int(11) NULL,
				ADD alternate_count int(11) NULL,
				ADD primary_series int(11) NULL,
				ADD series_thumbnail varchar(255) NULL,
				ADD series_image varchar(255) NULL,
				ADD series_podcast_image varchar(255) NULL,
				ADD file_name varchar(255) NULL,
				ADD file_url varchar(255) NULL,
				ADD file_new_window int(2) NULL,
				ADD podcast_image varchar(255) NULL,
				ADD focus_scripture varchar(255) NULL,
				ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
			$wpdb->query($sql);
		}

		$newfiletest = $wpdb->prefix . "se_files";
		if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
			$sql = "ALTER TABLE " . $newfiletest .
				" ADD featured int(2) NULL";
			$wpdb->query($sql);
		}

		$books = $wpdb->prefix . "se_books"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $books ( 
				book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			include('biblebooks.php');					
		}

		$scriptures = $wpdb->prefix . "se_scriptures"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $scriptures ( 
				scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  			start_book int(2) DEFAULT NULL,
				start_chapter int(3) DEFAULT NULL,
				start_verse int(3) DEFAULT NULL,
				end_verse int(3) NULL,
				trans int(4) NULL,
				transtext varchar(10) NULL,
				focus int(2) NULL,
				sort_id int(6) NULL,
				link varchar(255) NULL,
				text varchar(100) NULL,
				short_text varchar(100) NULL,
				scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
		}

		$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $book_message_matches ( 
				bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  			book_id int(11) NOT NULL,
				message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
		}

		$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $scripture_message_matches ( 
				scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  			scripture_id int(11) NOT NULL,
				message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
		}

		include('speedboost.php');

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$newpodtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newpodtest'") == $newpodtest ) {
				$sql = "ALTER TABLE " . $newpodtest .
					" ADD book_id int(11) DEFAULT NULL,
					 ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newseriestest = $wpdb->prefix . "se_series";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newseriestest'") == $newseriestest ) {
				$sql = "ALTER TABLE " . $newseriestest .
					" ADD podcast_image varchar(255) DEFAULT NULL";
				$wpdb->query($sql);
			}

			$newmessagetest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newmessagetest'") == $newmessagetest ) {
				$sql = "ALTER TABLE " . $newmessagetest .
					" ADD audio_count int(11) NULL,
					ADD video_count int(11) NULL,
					ADD alternate_count int(11) NULL,
					ADD primary_series int(11) NULL,
					ADD series_thumbnail varchar(255) NULL,
					ADD series_image varchar(255) NULL,
					ADD series_podcast_image varchar(255) NULL,
					ADD file_name varchar(255) NULL,
					ADD file_url varchar(255) NULL,
					ADD file_new_window int(2) NULL,
					ADD podcast_image varchar(255) NULL,
					ADD focus_scripture varchar(255) NULL,
					ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$newfiletest = $wpdb->prefix . "se_files";
			if( $wpdb->get_var("SHOW TABLES LIKE '$newfiletest'") == $newfiletest ) {
				$sql = "ALTER TABLE " . $newfiletest .
					" ADD featured int(2) NULL";
				$wpdb->query($sql);
			}

			$books = $wpdb->prefix . "se_books"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$books'") != $books ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $books ( 
					book_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_name varchar(100) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
				include('biblebooks.php');					
			}

			$scriptures = $wpdb->prefix . "se_scriptures"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scriptures'") != $scriptures ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scriptures ( 
					scripture_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			start_book int(2) DEFAULT NULL,
					start_chapter int(3) DEFAULT NULL,
					start_verse int(3) DEFAULT NULL,
					end_verse int(3) NULL,
					trans int(4) NULL,
					transtext varchar(10) NULL,
					focus int(2) NULL,
					sort_id int(6) NULL,
					link varchar(255) NULL,
					text varchar(100) NULL,
					short_text varchar(100) NULL,
					scripture_username varchar(100) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$book_message_matches = $wpdb->prefix . "se_book_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$book_message_matches'") != $book_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $book_message_matches ( 
					bm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			book_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			$scripture_message_matches = $wpdb->prefix . "se_scripture_message_matches"; 
			if( $wpdb->get_var("SHOW TABLES LIKE '$scripture_message_matches'") != $scripture_message_matches ) { // Create and populate the table if it doesn't already exist
		
				$sql = "CREATE TABLE $scripture_message_matches ( 
					scm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  			scripture_id int(11) NOT NULL,
					message_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
				);"; 
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
				dbDelta($sql); 
			}

			include('speedboost.php');
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_twozero();
	}
	
}  elseif ( get_option('enmse_db_version') == "2.0"  ) { //Upgrade 2.0 to 2.5

	function enmse_twozerofive() {
		global $wpdb;

		include('speedboost.php');

		$messagestest = $wpdb->prefix . "se_messages";
		if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
			$sql = "ALTER TABLE " . $messagestest .
				" ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
			$wpdb->query($sql);
		}

		$customlangtest = $wpdb->prefix . "se_podcasts";
		if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
			$sql = "ALTER TABLE " . $customlangtest .
				" ADD custom_lang varchar(10) DEFAULT NULL";
			$wpdb->query($sql);
		}

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			include('speedboost.php');

			$messagestest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
				$sql = "ALTER TABLE " . $messagestest .
					" ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$customlangtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
				$sql = "ALTER TABLE " . $customlangtest .
					" ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_twozerofive();
	}
	
}  elseif ( get_option('enmse_db_version') == "2.0.5"  ) { //Upgrade 2.0.5 to 2.5

	function enmse_twoone() {
		global $wpdb;

		include('speedboost.php');

		$messagestest = $wpdb->prefix . "se_messages";
		if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
			$sql = "ALTER TABLE " . $messagestest .
				" ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
			$wpdb->query($sql);
		}

		$customlangtest = $wpdb->prefix . "se_podcasts";
		if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
			$sql = "ALTER TABLE " . $customlangtest .
				" ADD custom_lang varchar(10) DEFAULT NULL";
			$wpdb->query($sql);
		}

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			include('speedboost.php');

			$messagestest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
				$sql = "ALTER TABLE " . $messagestest .
					" ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$customlangtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
				$sql = "ALTER TABLE " . $customlangtest .
					" ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_twoone();
	}
	
}  elseif ( get_option('enmse_db_version') == "2.1" || get_option('enmse_db_version') == "2.1.1"  ) { //Upgrade 2.1 to 2.1.1

	function enmse_twooneone() {
		global $wpdb;

		$messagestest = $wpdb->prefix . "se_messages";
		if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
			$sql = "ALTER TABLE " . $messagestest .
				" ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
			$wpdb->query($sql);
		}

		$customlangtest = $wpdb->prefix . "se_podcasts";
		if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
			$sql = "ALTER TABLE " . $customlangtest .
				" ADD custom_lang varchar(10) DEFAULT NULL";
			$wpdb->query($sql);
		}

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$messagestest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
				$sql = "ALTER TABLE " . $messagestest .
					" ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$customlangtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
				$sql = "ALTER TABLE " . $customlangtest .
					" ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_twooneone();
	}
	
}  elseif ( get_option('enmse_db_version') == "2.1.2"  ) { //Upgrade 2.1.2 to 2.5

	function enmse_twotwo() {
		global $wpdb;

		$messagestest = $wpdb->prefix . "se_messages";
		if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
			$sql = "ALTER TABLE " . $messagestest .
				" ADD wp_post_id int(11) NULL,
				ADD permalink_prefix int(2) NULL,
				ADD permalink_speaker int(2) NULL,
				ADD podcast_series int(2) NULL";
			$wpdb->query($sql);
		}

		$customlangtest = $wpdb->prefix . "se_podcasts";
		if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
			$sql = "ALTER TABLE " . $customlangtest .
				" ADD custom_lang varchar(10) DEFAULT NULL";
			$wpdb->query($sql);
		}

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$messagestest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
				$sql = "ALTER TABLE " . $messagestest .
					" ADD wp_post_id int(11) NULL,
					ADD permalink_prefix int(2) NULL,
				 	ADD permalink_speaker int(2) NULL,
				 	ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$customlangtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
				$sql = "ALTER TABLE " . $customlangtest .
					" ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_twotwo();
	}
	
}  elseif ( get_option('enmse_db_version') == "2.2" || get_option('enmse_db_version') == "2.2.1" || get_option('enmse_db_version') == "2.2.2" || get_option('enmse_db_version') == "2.2.3" || get_option('enmse_db_version') == "2.2.4" || get_option('enmse_db_version') == "2.2.5" ) { //Upgrade 2.2 to 2.2.1

	function enmse_twofive() {
		global $wpdb;

		$messagestest = $wpdb->prefix . "se_messages";
		if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
			$sql = "ALTER TABLE " . $messagestest .
				" ADD permalink_prefix int(2) NULL,
				 ADD permalink_speaker int(2) NULL,
				 ADD podcast_series int(2) NULL";
			$wpdb->query($sql);
		}

		$customlangtest = $wpdb->prefix . "se_podcasts";
		if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
			$sql = "ALTER TABLE " . $customlangtest .
				" ADD custom_lang varchar(10) DEFAULT NULL";
			$wpdb->query($sql);
		}

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$messagestest = $wpdb->prefix . "se_messages";
			if( $wpdb->get_var("SHOW TABLES LIKE '$messagestest'") == $messagestest ) {
				$sql = "ALTER TABLE " . $messagestest .
					" ADD permalink_prefix int(2) NULL,
					 ADD permalink_speaker int(2) NULL,
					 ADD podcast_series int(2) NULL";
				$wpdb->query($sql);
			}

			$customlangtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
				$sql = "ALTER TABLE " . $customlangtest .
					" ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_twofive();
	}
	
}  elseif ( get_option('enmse_db_version') == "2.5" || get_option('enmse_db_version') == "2.5.1" || get_option('enmse_db_version') == "2.5.2" || get_option('enmse_db_version') == "2.5.5" || get_option('enmse_db_version') == "2.5.6" || get_option('enmse_db_version') == "2.5.7" || get_option('enmse_db_version') == "2.6" || get_option('enmse_db_version') == "2.6.1" || get_option('enmse_db_version') == "2.6.2" || get_option('enmse_db_version') == "2.7" || get_option('enmse_db_version') == "2.7.1" || get_option('enmse_db_version') == "2.7.2" || get_option('enmse_db_version') == "2.7.3" || get_option('enmse_db_version') == "2.7.4" || get_option('enmse_db_version') == "2.7.5" || get_option('enmse_db_version') == "2.7.6" || get_option('enmse_db_version') == "2.7.7" || get_option('enmse_db_version') == "2.7.8" || get_option('enmse_db_version') == "2.7.9" || get_option('enmse_db_version') == "2.7.9.1" || get_option('enmse_db_version') == "2.7.9.2"  ) { //Upgrade 2.5 to 2.7

	function enmse_twofiveone() {
		global $wpdb;

		$customlangtest = $wpdb->prefix . "se_podcasts";
		if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
			$sql = "ALTER TABLE " . $customlangtest .
				" ADD custom_lang varchar(10) DEFAULT NULL";
			$wpdb->query($sql);
		}

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;

			$customlangtest = $wpdb->prefix . "se_podcasts";
			if( $wpdb->get_var("SHOW TABLES LIKE '$customlangtest'") == $customlangtest ) {
				$sql = "ALTER TABLE " . $customlangtest .
					" ADD custom_lang varchar(10) DEFAULT NULL";
				$wpdb->query($sql);
			}
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_twofiveone();
	}
	
}  elseif ( get_option('enmse_db_version') == "2.7.9.3" || get_option('enmse_db_version') == "2.7.9.4" || get_option('enmse_db_version') == "2.7.9.5" || get_option('enmse_db_version') == "2.8.0" || get_option('enmse_db_version') == "2.8.1" || get_option('enmse_db_version') == "2.8.1.1" || get_option('enmse_db_version') == "2.8.2" || get_option('enmse_db_version') == "2.8.3" || get_option('enmse_db_version') == "2.8.3.1" || get_option('enmse_db_version') == "2.8.3.2" || get_option('enmse_db_version') == "2.8.4" || get_option('enmse_db_version') == "2.8.5" || get_option('enmse_db_version') == "2.8.5.1" || get_option('enmse_db_version') == "2.8.6" ) { 

	function enmse_twosevennine() {
		global $wpdb;

		$se_options = get_option( 'enm_seriesengine_options' );
		generate_se_options_css($se_options);

		// Define DB version
		global $enmse_db_version;
		$enmse_db_version = "2.8.7";
		update_option("enmse_db_version", $enmse_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			global $wpdb;
			
			$data = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = WP_PLUGIN_DIR . '/seriesengine_plugin/css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmse_db_version;
			$enmse_db_version = "2.8.7";
			update_option("enmse_db_version", $enmse_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmse_twosevennine();
	}
	
}

 ?>