<?php 

	if ( version_compare( get_bloginfo( 'version' ), '3.5', '<' ) ) { // Don't activate plugin if WordPress version is less than 3.5
		$enmse_old_version_message = "WordPress 3.5 or greater is required to use Series Engine. Please upgrade!";
		exit ($enmse_old_version_message);
	}

	// Create PE database tables
	global $wpdb;
	
	// Define DB version
	global $enmse_db_version;
	$enmse_db_version = "2.8.5";
	if( !defined(get_option( 'enmse_db_version' )) ) {
		add_option("enmse_db_version", $enmse_db_version);
	} else {
		update_option("enmse_db_version", $enmse_db_version);
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
			
			
				$firstfile = array( // Add a sample scripture to the database
					'scripture_id' => '1', 
					'start_book' => '43', 
					'start_chapter' => '3',
					'start_verse' => '16',
					'end_verse' => '16',
					'trans' => '59',
					'transtext' => ' (ESV)',
					'focus' => '1',
					'sort_id' => '1',
					'link' => 'https://bible.com/bible/59/JHN.3.16',
					'text' => 'John 3:16',
					'short_text' => 'Jn 3:16'
				); 
				$wpdb->insert( $scriptures, $firstfile );
			
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
			
				$firstmfmatch = array( // Match sample topic to sample message
					'bm_match_id' => '1', 
					'book_id' => '43', 
					'message_id' => '1'
				); 
				$wpdb->insert( $book_message_matches, $firstmfmatch );
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
			
				$firstmfmatch = array( // Match sample topic to sample message
					'scm_match_id' => '1', 
					'scripture_id' => '1', 
					'message_id' => '1'
				); 
				$wpdb->insert( $scripture_message_matches, $firstmfmatch );
		}

	$files = $wpdb->prefix . "se_files"; 
		if( $wpdb->get_var("SHOW TABLES LIKE '$files'") != $files ) { // Create and populate the table if it doesn't already exist
	
			$sql = "CREATE TABLE $files ( 
				file_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  			file_name varchar(255) DEFAULT NULL,
				file_url varchar(255) DEFAULT NULL,
				file_username varchar(255) DEFAULT NULL,
				file_new_window int(2) NULL,
				sort_id int(11) NULL,
				featured int(2) NULL) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
			);"; 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
			dbDelta($sql); 
			
			
				$firstfile = array( // Add a sample file to the database
					'file_id' => '1', 
					'file_name' => 'This is a Sample Link/Download', 
					'file_url' => 'http://seriesengine.com/',
					'file_username' => '',
					'file_new_window' => '0',
					'sort_id' => '0',
					'featured' => '0'
				); 
				$wpdb->insert( $files, $firstfile );

				$secondfile = array( // Add a sample file to the database
					'file_id' => '2', 
					'file_name' => 'This is a Sample Featured Link', 
					'file_url' => 'http://seriesengine.com/',
					'file_username' => '',
					'file_new_window' => '1',
					'sort_id' => '0',
					'featured' => '1'
				); 
				$wpdb->insert( $files, $secondfile );

				$thirdfile = array( // Add a sample file to the database
					'file_id' => '3', 
					'file_name' => 'You Can Link to Any Webpage', 
					'file_url' => 'http://seriesengine.com/',
					'file_username' => '',
					'file_new_window' => '0',
					'sort_id' => '0',
					'featured' => '0'
				); 
				$wpdb->insert( $files, $thirdfile );
			
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
			
				$firstmfmatch = array( // Match sample topic to sample message
					'mf_match_id' => '1', 
					'message_id' => '1', 
					'file_id' => '1'
				); 
				$wpdb->insert( $message_file_matches, $firstmfmatch );
		}
	
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
	
	$messages = $wpdb->prefix . "se_messages"; 
	if( $wpdb->get_var("SHOW TABLES LIKE '$messages'") != $messages ) { // Create and populate the table if it doesn't already exist

		$sql = "CREATE TABLE $messages ( 
			message_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			title varchar(150) DEFAULT NULL,
			speaker varchar(75) DEFAULT NULL,
			date date DEFAULT NULL,
			alternate_date date DEFAULT NULL,
			description text,
			message_length varchar(50) DEFAULT NULL,
			message_thumbnail varchar(255) DEFAULT NULL,
			audio_url varchar(255) DEFAULT NULL,
			message_video_length varchar(50) DEFAULT NULL,
			video_url varchar(255) DEFAULT NULL,
			embed_code text,
			video_embed_url varchar(255) DEFAULT NULL,
			additional_video_embed_url varchar(255) DEFAULT NULL,
			alternate_toggle varchar(3) DEFAULT NULL,
			alternate_embed text,
			alternate_label varchar(10) DEFAULT NULL,
			audio_file_size int(11) NULL,
			video_file_size int(11) NULL,
			audio_count int(11) NULL,
			video_count int(11) NULL,
			alternate_count int(11) NULL,
			primary_series int(11) NULL,
			series_thumbnail varchar(255) NULL,
			series_image varchar(255) NULL,
			series_podcast_image varchar(255) NULL,
			file_name varchar(255) NULL,
			file_url varchar(255) NULL,
			file_new_window int(2) NULL,
			podcast_image varchar(255) NULL,
			focus_scripture varchar(255) NULL,
			wp_post_id int(11) NULL,
			permalink_prefix int(2) NULL,
			permalink_speaker int(2) NULL,
			podcast_series int(2) NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		);"; 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
		dbDelta($sql); 
	
		$firstmessage = array( // Add a sample prayer to the database
			'message_id' => '1', 
			'title' => 'A Demo Message', 
			'speaker' => 'Eric Murrell',
			'date' => '2017-07-18',
			'alternate_date' => '0000-00-00',
			'description' => 'This is a message that demonstrates how the Series Engine works. You can delete this message and other demo data in the Series Engine section of the WordPress admin portal.',
			'message_length' => '01:46',
			'message_thumbnail' => '',
			'audio_url' => 'http://seriesengine.com/samplefiles/newsample.mp3',
			'message_video_length' => '01:46',
			'video_url' => '0',
			'video_embed_url' => '0',
			'additional_video_embed_url' => '0',
			'embed_code' => '<iframe width=\"492\" height=\"277\" src=\"https://www.youtube.com/embed/4ti-pd9MB_U?rel=0\" frameborder=\"0\" allowfullscreen></iframe>',
			'alternate_toggle' => 'No',
			'alternate_embed' => '0',
			'alternate_label' => 'Alternate',
			'audio_file_size' => '123456789',
			'video_file_size' => '123456789',
			'audio_count' => '34',
			'video_count' => '',
			'alternate_count' => '',
			'primary_series' => '1',
			'series_thumbnail' => 'http://seriesengine.com/samplefiles/se_series_sample.jpg',
			'series_image' => 'http://seriesengine.com/samplefiles/se_series_sample.jpg',
			'series_podcast_image' => 'http://seriesengine.com/samplefiles/se_sample_podcast.jpg',
			'file_name' => 'This is a Sample Featured File',
			'file_url' => 'http://seriesengine.com',
			'file_new_window' => '1',
			'podcast_image' => '',
			'focus_scripture' => 'John 3:16',
			'wp_post_id' => NULL,
			'permalink_prefix' => '1',
			'permalink_speaker' => '1',
			'podcast_series' => '1'

		); 
		$wpdb->insert( $messages, $firstmessage );
	}
	
	$topics = $wpdb->prefix . "se_topics"; 
	if( $wpdb->get_var("SHOW TABLES LIKE '$topics'") != $topics ) { // Create and populate the table if it doesn't already exist

		$sql = "CREATE TABLE $topics ( 
			topic_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			name varchar(50) DEFAULT NULL,
			sort_id int(11) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		);"; 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
		dbDelta($sql); 
		
		$firsttopic = array( // Add a sample topic to the database
			'topic_id' => '1', 
			'name' => 'Demonstration', 
			'sort_id' => '1'
		); 
		$wpdb->insert( $topics, $firsttopic );
	}
	
	$message_topic_matches = $wpdb->prefix . "se_message_topic_matches"; 
	if( $wpdb->get_var("SHOW TABLES LIKE '$message_topic_matches'") != $message_topic_matches ) { // Create and populate the table if it doesn't already exist

		$sql = "CREATE TABLE $message_topic_matches ( 
			mt_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			message_id int(11) NOT NULL,
			topic_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		);"; 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
		dbDelta($sql); 
		
		$firstmtmatch = array( // Match sample topic to sample message
			'mt_match_id' => '1', 
			'message_id' => '1', 
			'topic_id' => '1'
		); 
		$wpdb->insert( $message_topic_matches, $firstmtmatch );
	}
	
	$series = $wpdb->prefix . "se_series"; 
	if( $wpdb->get_var("SHOW TABLES LIKE '$series'") != $series ) { // Create and populate the table if it doesn't already exist

		$sql = "CREATE TABLE $series ( 
			series_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			s_title varchar(150) DEFAULT NULL,
			s_description text,
			thumbnail_url varchar(255) DEFAULT NULL,
			graphic_thumb varchar(255) DEFAULT NULL,
			widget_thumb varchar(255) DEFAULT NULL,
			archived varchar(2) DEFAULT NULL,
			start_date date DEFAULT NULL,
			podcast_image varchar(255) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		);"; 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
		dbDelta($sql); 
		
		$firstseries = array( // Add a sample Series to the database
			'series_id' => '1', 
			's_title' => 'Demo Series', 
			's_description' => 'This is a description of the Demo Series. You can delete this Series and other demo data in the Series Engine section of the WordPress admin portal.',
			'thumbnail_url' => 'http://seriesengine.com/samplefiles/se_series_sample.jpg',
			'graphic_thumb' => 'http://seriesengine.com/samplefiles/se_series_thumb_sample.jpg',
			'widget_thumb' => 'http://seriesengine.com/samplefiles/se_series_widget_sample.jpg',
			'archived' => '0',
			'start_date' => '2012-06-30',
			'podcast_image' => 'http://seriesengine.com/samplefiles/se_sample_podcast.jpg'
		); 
		$wpdb->insert( $series, $firstseries );
	}
	
	$series_message_matches = $wpdb->prefix . "se_series_message_matches"; 
	if( $wpdb->get_var("SHOW TABLES LIKE '$series_message_matches'") != $series_message_matches ) { // Create and populate the table if it doesn't already exist

		$sql = "CREATE TABLE $series_message_matches ( 
			sm_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			message_id int(11) NOT NULL,
			series_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		);"; 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
		dbDelta($sql); 
		
		$firstsmmatch = array( // Match the sample Series with a Sample message.
			'sm_match_id' => '1', 
			'message_id' => '1', 
			'series_id' => '1'
		); 
		$wpdb->insert( $series_message_matches, $firstsmmatch );
	}
	
	$series_types = $wpdb->prefix . "se_series_types"; 
	if( $wpdb->get_var("SHOW TABLES LIKE '$series_types'") != $series_types ) { // Create and populate the table if it doesn't already exist

		$sql = "CREATE TABLE $series_types ( 
			series_type_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name varchar(150) DEFAULT NULL,
			description text,
			sort_id int(11) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		);"; 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
		dbDelta($sql); 
		
		$firstseriestype = array( // Set up an intial Series Type
			'series_type_id' => '1', 
			'name' => 'Main Series', 
			'description' => 'This is the Series Type that Series will most commonly be assigned to.',
			'sort_id' => '1'
		); 
		$wpdb->insert( $series_types, $firstseriestype );
	}
	
	$series_type_matches = $wpdb->prefix . "se_series_type_matches"; 
	if( $wpdb->get_var("SHOW TABLES LIKE '$series_type_matches'") != $series_type_matches ) { // Create and populate the table if it doesn't already exist

		$sql = "CREATE TABLE $series_type_matches ( 
			st_match_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			series_id int(11) NOT NULL,
			series_type_id int(11) NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		);"; 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
		dbDelta($sql); 
		
		$firststmatch = array( // Match the demo Series to the default Series Type
			'st_match_id' => '1', 
			'series_id' => '1', 
			'series_type_id' => '1'
		); 
		$wpdb->insert( $series_type_matches, $firststmatch );
	}
	
	$se_podcasts = $wpdb->prefix . "se_podcasts"; 
	if( $wpdb->get_var("SHOW TABLES LIKE '$se_podcasts'") != $se_podcasts ) { // Create and populate the table if it doesn't already exist

		$sql = "CREATE TABLE $se_podcasts ( 
			se_podcast_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			series_id int(11) NOT NULL,
			topic_id int(11) NOT NULL,
			speaker_id int(11) NOT NULL,
			series_type_id int(11) NOT NULL,
			title varchar(150) DEFAULT NULL,
			description text,
			author varchar(150) DEFAULT NULL,
			email varchar(150) DEFAULT NULL,
			logo_url varchar(150) DEFAULT NULL,
			link_url varchar(150) DEFAULT NULL,
			category varchar(150) DEFAULT NULL,
			subcategory varchar(150) DEFAULT NULL,
			audio_video varchar(50) DEFAULT NULL,
			podcast_display int(11) NOT NULL,
			explicit int(11) DEFAULT NULL,
			redirect_podcast int(2) DEFAULT NULL,
			redirect_url varchar(255) DEFAULT NULL,
			book_id int(11) NOT NULL,
			custom_lang varchar(10) DEFAULT NULL) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
		);"; 
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
		dbDelta($sql); 
		
		$firstpodcast = array( // Set up the Default Podcast
			'se_podcast_id' => '1', 
			'series_id' => '-1', 
			'topic_id' => '-1', 
			'speaker_id' => '-1', 
			'series_type_id' => '0', 
			'title' => 'Default Podcast', 
			'description' => 'This is the description for the default Podcast generated with Series Engine. You\'ll probably want to change it before you make it live.', 
			'author' => 'Your Name Here', 
			'email' => 'youremail@address.com', 
			'logo_url' => 'http://seriesengine.com/samplefiles/se_sample_podcast.jpg', 
			'category' => 'Religion & Spirituality', 
			'subcategory' => 'Christianity', 
			'audio_video' => 'Audio', 
			'podcast_display' => '10',
			'explicit' => '0',
			'redirect_podcast' => '0',
			'redirect_url' => '',
			'custom_lang' => ''
		); 
		$wpdb->insert( $se_podcasts, $firstpodcast );
	}

	include('speedboost.php');
	
	register_uninstall_hook( __FILE__, 'enm_seriesengine_uninstall_ms' ); 
	
	// Set default options
	$enm_seriesengine_options = array( 
		'newarchiveswidth' => '600',
		'responsivefull' => '900', 
		'responsivemobile' => '700',
		'responsivecondensed' => '600',
		'widgetwidth' => '200', 
		'maxwidth' => '1000',
		'newgraphicwidth' => '1000', 
		'placeholderimage' => '',
		'imagearchivetext' => '1',
		'pag' => '10',
		'apag' => '12',
		'archiveliststyle' => '1',
		'primaryst' => '1',
		'videotablabel' => 'Watch', 
		'audiotablabel' => 'Listen',
		'noajax' => '0',
		'forcedownload' => '0',
		'timely' => '0',
		'nofonta' => '0',
		'id3' => '1',
		'topicsort' => '0',
		'font' => 'arial',
		'customfont' => '',
		'explorertitletext' => '000000',
		'explorerbackground' => 'f7f7f7',
		'explorerselectborder' => 'ffffff',
		'explorerselect' => 'ffffff',
		'explorerselecttext' => '000000',
		'explorerbutton' => '486d7d',
		'explorerbuttontext' => 'ffffff',
		'mstitletext' => '000000',
		'msdatetext' => '000000',
		'borderoption' => '1',
		'playerbordercolor' => 'b6b5b5',
		'playerselectedtabbackground' => 'b6b5b5',
		'playerselectedtabtext' => '000000',
		'playertabbackground' => 'dcdbdb',
		'playertabtext' => '929292',
		'playerdetailsbackground' => 'f7f7f7',
		'audiobg' => '000000',
		'audioprog' => 'cccccc',
		'playeroptions' => 'dark',
		'detailstext' => '000000',
		'detailstitletext' => '000000',
		'detailsrelatedtext' => '000000',
		'detailslinks' => 'b6b5b5',
		'downloadsbg' => 'e6e6e6',
		'downloadsspacer' => '000000',
		'downloadlinks' => 'b6b5b5',
		'shareoptions' => 'dark',
		'sharebuttonbackground' => 'DCDBDB',
		'sharebuttontext' => '959494',
		'sharelinkbackground' => 'd4d4d4',
		'sharelinktext' => '000000',
		'sharelinkbuttonbackground' => 'b6b5b5',
		'sharelinkbuttontext' => 'e8e8e8',
		'comptitletext' => '000000',
		'compoddrow' => 'f7f7f7',
		'comprowtitletext' => '000000',
		'compaltrowtitletext' => '000000',
		'comprowdatetext' => '000000',
		'compaltrowdatetext' => '000000',
		'complinks' => 'b6b5b5',
		'gridrowbg' => 'f7f7f7',
		'gridrowtitle' => '000000',
		'gridrowbible' => '000000',
		'gridrowfile' => 'b6b5b5',
		'gridrowmediabg' => 'b6b5b5',
		'gridrowmediatext' => 'e8e8e8',
		'loadingbackground' => 'd4d4d4',
		'loadingtext' => '444444',
		'loadingicon' => 'dark',
		'archivetitle' => '000000',
		'archiverow' => 'f7f7f7',
		'archiveseriestitle' => '000000',
		'archivedatecount' => '000000',
		'archivelinks' => 'b6b5b5',
		'poweredby' => 'light',
		'poweredbytext' => 'd2d2d2',
		'seriest' => 'Series',
		'seriestp' => 'Series',
		'topict' => 'Topic',
		'topictp' => 'Topics',
		'speakert' => 'Speaker',
		'speakertp' => 'Speakers',
		'messaget' => 'Message',
		'messagetp' => 'Messages',
		'bookt' => 'Book',
		'booktp' => 'Books',
		'scripturelabel' => 'Scripture References',
		'pagebuttonbg' => 'b6b5b5',
		'pagebuttontext' => 'dbdbdb',
		'pagenumber' => 'D4D4D4',
		'pagenumberselectedbg' => 'f7f7f7',
		'pagenumberselectedtext' => 'D4D4D4',
		'cardview' => '1',
		'bibleoption' => '1',
		'playerstyle' => '1',
		'deftrans' => '59',
		'usepermalinks' => '1',
		'permalinkslug' => 'messages',
		'permalink_ogtags' => '1',
		//'permalink_single_seriestype' => '0',
		'permalink_single_explorer' => '0',
		'permalink_single_explorer_series' => '1',
		'permalink_single_explorer_speaker' => '1',
		'permalink_single_explorer_topics' => '1',
		'permalink_single_explorer_books' => '1',
		'permalink_single_related' => '1',
		'permalink_single_related_cardview' => '1',
		'permalink_single_pag' => '10',
		'permalink_single_apag' => '12',
		'permalink_single_blurb' => '',
		'permalink_show_post_type' => '0',
		'default_permalink_prefix' => '1',
		'default_permalink_speaker' => '1',
		'default_podcast_series' => '1',
		'language' => '1',
		'lang_loading' => 'Loading Content...',
		'lang_sharelinktitle' => 'Share a Link to this MESSAGE_LABEL',
		'lang_sharelinkinstructions' => 'The link has been copied to your clipboard; paste it anywhere you would like to share it.',
		'lang_sharelinkclosebutton' => 'Close',
		'lang_archiveexplore' => 'Explore This SERIES_LABEL',
		'lang_explorerbrowseseries' => 'Browse PLURAL_SERIES_LABEL',
		'lang_explorerbrowsespeakers' => 'Browse PLURAL_SPEAKERS_LABEL',
		'lang_explorerbrowsetopics' => 'Browse PLURAL_TOPICS_LABEL',
		'lang_explorerbrowsebooks' => 'Browse PLURAL_BOOKS_LABEL',
		'lang_explorerarchives' => 'View SERIES_LABEL Archives',
		'lang_explorermessages' => 'View All PLURAL_MESSAGE_LABEL',
		'lang_relatedtopics' => 'Related PLURAL_TOPICS_LABEL:',
		'lang_moremessagesfrom' => 'More PLURAL_MESSAGES_LABEL from',
		'lang_downloadaudio' => 'Download Audio',
		'lang_fromseries' => 'From SERIES_LABEL:',
		'lang_sharefb' => 'Facebook',
		'lang_sharetw' => 'Tweet Link',
		'lang_sharepop' => 'Share Link',
		'lang_shareemail' => 'Send Email',
		'lang_morefromtopics' => 'More PLURAL_MESSAGES_LABEL Associated With',
		'lang_morefrombooks' => 'More From the BOOK_LABEL of',
		'lang_morefromspeakers' => 'More PLURAL_MESSAGES_LABEL from',
		'lang_morefromgeneric' => 'More PLURAL_MESSAGES_LABEL',
		'lang_morefromseries' => 'More From',
		'lang_pagemore' => 'More',
		'lang_pageback' => 'Back',
		'lang_podcastmessagefrom' => 'MESSAGE_LABEL from',
		'lang_permaclicktoview' => 'Click to view more.',
		'lang_permalinkblankexcerpt' => 'A MESSAGE_LABEL from the SERIES_LABEL'
		);
	add_option( 'enm_seriesengine_options', $enm_seriesengine_options ); 

	//include('makepermalinks.php');

 ?>