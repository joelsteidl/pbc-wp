<?php

class ENMSE_SeriesEngine extends ET_Builder_Module {

	public $slug       = 'enmse_series_engine';
	public $vb_support = 'on';

	public function init() {
		$this->name = esc_html__( 'Series Engine', 'enmse-series-engine' );
	}

	public function get_advanced_fields_config() {
		return array(
			'borders' => false,
			'box_shadow' => false,
			'filters' => false,
			'animation' => false,
			'text' => false,
			'fonts' => false,
		);
	}

	public function get_fields() {
		$enmse_dateformat = get_option( 'date_format' ); 
		$enmse_options = get_option( 'enm_seriesengine_options' ); 

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

		if ( isset($enmse_options['bookt']) ) { // Find Book Title
		    $enmsebookt = $enmse_options['bookt'];
		} else {
		    $enmsebookt = "Book";
		}

		if ( isset($enmse_options['booktp']) ) { // Find Book Title (plural)
		    $enmsebooktp = $enmse_options['booktp'];
		} else {
		    $enmsebooktp = "Books";
		}

		global $wpdb;

		// Get All Series Types
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
		$enmse_series_types = $wpdb->get_results( $enmse_preparredsql );

		$sedivi_seriestypes = array();
		foreach ($enmse_series_types as $st) {
		    $sedivi_seriestypes[$st->series_type_id] = stripslashes($st->name);
		}
		$sedivi_seriestypes['0'] = 'All ' . $enmseseriest . ' Types';

		// Get All Series 
		$enmse_spreparredsql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " WHERE archived = 0 ORDER BY start_date DESC"; 
		$enmse_series = $wpdb->get_results( $enmse_spreparredsql );

		$sedivi_series = array();
		foreach ($enmse_series as $s) {
		    $sedivi_series[$s->series_id] = stripslashes($s->s_title);
		}
		$sedivi_series['0'] = '- Select a ' . $enmseseriest . ' -';

		// Get All Messages
		$enmse_mpreparredsql = "SELECT message_id, title, date FROM " . $wpdb->prefix . "se_messages" . " ORDER BY date DESC"; 
		$enmse_messages = $wpdb->get_results( $enmse_mpreparredsql );

		$sedivi_messages = array();
		foreach ($enmse_messages as $m) {
		    $sedivi_messages[$m->message_id] = stripslashes($m->title) . ' (' . date_i18n($enmse_dateformat, strtotime($m->date)) . ')';
		}
		$sedivi_messages['0'] = '- Select a ' . $enmsemessaget . ' -';

		// Get All Topics
		$enmse_tpreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
		$enmse_topics = $wpdb->get_results( $enmse_tpreparredsql );

		$sedivi_topics= array();
		foreach ($enmse_topics as $t) {
		    $sedivi_topics[$t->topic_id] = stripslashes($t->name);
		}
		$sedivi_topics['0'] = '- Select a ' . $enmsetopict . ' -';

		// Get All Speakers
		$enmse_sppreparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name ASC"; 
		$enmse_speakers = $wpdb->get_results( $enmse_sppreparredsql );

		$sedivi_speakers = array();
		foreach ($enmse_speakers as $sp) {
		    $sedivi_speakers[$sp->speaker_id] = stripslashes($sp->first_name) . ' ' . stripslashes($sp->last_name);
		}
		$sedivi_speakers['0'] = '- Select a ' . $enmsespeakert . ' -';

		// Get All Books
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_books" . " ORDER BY book_id ASC"; 
		$enmse_books = $wpdb->get_results( $enmse_preparredsql );

		$sedivi_books = array();
		foreach ($enmse_books as $b) {
		    $sedivi_books[$b->book_id] = stripslashes($b->book_name);
		}
		$sedivi_books['0'] = '- Select a Book -';

		return array(
			'what_to_display'     => array( // Core Display Options
				'label'           => esc_html__( 'What to Display', 'enmse-series-engine' ),
				'type'            => 'select',
				'options'       => array(
                    '1'      => esc_html__('The Most Recent ' . $enmsemessaget, 'enmse-series-engine'),
                    '2'      => esc_html__('Display All ' . $enmsemessagetp . ' (Regardless of ' . $enmseseriest . ')', 'enmse-series-engine'),
                    '3'      => esc_html__('Display a Specific ' . $enmsemessaget, 'enmse-series-engine'),
                    '4'      => esc_html__('Display a Specific ' . $enmseseriest, 'enmse-series-engine'),
                    '5'      => esc_html__('Display a Specific ' . $enmsetopict, 'enmse-series-engine'),
                    '6'      => esc_html__('Display a Specific ' . $enmsespeakert, 'enmse-series-engine'),
                    '7'      => esc_html__('Display a Specific ' . $enmsebookt, 'enmse-series-engine'),
                    '8'      => esc_html__('Display ' . $enmseseriest . ' Archives', 'enmse-series-engine')
                ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Choose what to display in this Series Engine embed.', 'enmse-series-engine' ),
				'toggle_slug'     => 'segeneral',
			),
			'series_type'     => array(
				'label'           => esc_html__( 'From What ' . $enmseseriest . ' Type?', 'enmse-series-engine' ),
				'type'            => 'select',
				'options'         => $sedivi_seriestypes,
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Only display certain types of Series Engine content.', 'enmse-series-engine' ),
				'toggle_slug'     => 'segeneral',
			),
			'message'     => array(
				'label'           => esc_html__( 'Choose a ' . $enmsemessaget, 'enmse-series-engine' ),
				'type'            => 'select',
				'options'         => $sedivi_messages,
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Make sure you select a ' . $enmsemessaget . ' from the selected ' . $enmseseriest . ' Type.', 'enmse-series-engine' ),
				'toggle_slug'     => 'segeneral',
				'show_if' => array(
					'what_to_display' => '3',
				),
			),
			'series'     => array(
				'label'           => esc_html__( 'Choose a ' . $enmseseriest, 'enmse-series-engine' ),
				'type'            => 'select',
				'options'         => $sedivi_series,
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Make sure you select a ' . $enmseseriest . ' from the selected ' . $enmseseriest . ' Type.', 'enmse-series-engine' ),
				'toggle_slug'     => 'segeneral',
				'show_if' => array(
					'what_to_display' => '4',
				),
			),
			'topic'     => array(
				'label'           => esc_html__( 'Choose a ' . $enmsetopict, 'enmse-series-engine' ),
				'type'            => 'select',
				'options'         => $sedivi_topics,
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Make sure you select a ' . $enmsetopict . ' with ' . $enmsemessagetp . ' from the selected ' . $enmseseriest . ' Type.', 'enmse-series-engine' ),
				'toggle_slug'     => 'segeneral',
				'show_if' => array(
					'what_to_display' => '5',
				),
			),
			'speaker'     => array(
				'label'           => esc_html__( 'Choose a ' . $enmsespeakert, 'enmse-series-engine' ),
				'type'            => 'select',
				'options'         => $sedivi_speakers,
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Make sure you select a ' . $enmsespeakert . ' with ' . $enmsemessagetp . ' from the selected ' . $enmseseriest . ' Type.', 'enmse-series-engine' ),
				'toggle_slug'     => 'segeneral',
				'show_if' => array(
					'what_to_display' => '6',
				),
			),
			'book'     => array(
				'label'           => esc_html__( 'Choose a ' . $enmsebookt, 'enmse-series-engine' ),
				'type'            => 'select',
				'options'         => $sedivi_books,
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Make sure you select a ' . $enmsebookt . ' with ' . $enmsemessagetp . ' from the selected ' . $enmseseriest . ' Type.', 'enmse-series-engine' ),
				'toggle_slug'     => 'segeneral',
				'show_if' => array(
					'what_to_display' => '7',
				),
			),
			'show_message_explorer' => array( // Message Explorer Search Bar Options
		    	'label' => esc_html__('Show Message Explorer Search Bar?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'description' => esc_html__('Show or hide the ' . $enmsemessaget . ' explorer search bar in its entirety.', 'enmse-series-engine'),
		        'toggle_slug' => 'sesearchmenus',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
		        'default' => 'on',
		    ),
		    'show_browse_series' => array(
		    	'label' => esc_html__('Show "Browse ' . $enmseseriestp . '" Menu?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'sesearchmenus',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
				'show_if' => array(
					'show_message_explorer' => 'on',
				),
		    ),
		    'show_browse_speakers' => array(
		    	'label' => esc_html__('Show "Browse ' . $enmsespeakertp . '" Menu?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'sesearchmenus',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
				'show_if' => array(
					'show_message_explorer' => 'on',
				),
		    ),
		    'show_browse_topics' => array(
		    	'label' => esc_html__('Show "Browse ' . $enmsetopictp . '" Menu?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'sesearchmenus',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
				'show_if' => array(
					'show_message_explorer' => 'on',
				),
		    ),
		    'show_browse_books' => array(
		    	'label' => esc_html__('Show "Browse ' . $enmsebooktp . '" Menu?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'sesearchmenus',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
				'show_if' => array(
					'show_message_explorer' => 'on',
				),
		    ),
		    'show_initial_message' => array( // What Content is Displayed in the Player Area?
		    	'label' => esc_html__('Show Initial ' . $enmsemessaget . '?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'semessageoptions',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
		    ),
		    'show_sharing_links' => array(
		    	'label' => esc_html__('Show Sharing Links Below Player?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'semessageoptions',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
		    ),
		    'show_series_details' => array(
		    	'label' => esc_html__('Show ' . $enmseseriest . ' Details Below Player?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'semessageoptions',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
		    ),
		    'show_audio_download' => array(
		    	'label' => esc_html__('Show Audio Download Link?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'semessageoptions',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
		    ),
		    'show_related_messages' => array( // Related Messsages
		    	'label' => esc_html__('Show Related ' . $enmsemessagetp . '?', 'enmse-series-engine'),
		        'type' => 'yes_no_button',
		        'option_category' => 'basic_option',
		        'toggle_slug' => 'serelatedmessages',
		        'options' => array(
		        	'on'  => esc_html__( 'Yes', 'enmse-series-engine'),
		        	'off' => esc_html__( 'No', 'enmse-series-engine'),
		        ),
		    ),
		    'style_of_related_messages'     => array(
				'label'           => esc_html__( 'Style of Related ' . $enmsemessagetp, 'enmse-series-engine' ),
				'type'            => 'select',
				'options'       => array(
                    'classic'      => esc_html__('Classic List View', 'enmse-series-engine'),
                    'grid'      => esc_html__('Grid View', 'enmse-series-engine'),
                    'row'      => esc_html__('Row View', 'enmse-series-engine'),
                ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'serelatedmessages',
				'default'         => '1',
				'show_if' => array(
					'show_related_messages' => 'on',
				),
			),
			'related_messages_sort_order'     => array(
				'label'           => esc_html__( 'Related ' . $enmsemessagetp . ' Sort Order', 'enmse-series-engine' ),
				'type'            => 'select',
				'options'       => array(
                    'oldest'      => esc_html__('Oldest First', 'enmse-series-engine'),
                    'newest'      => esc_html__('Newest First', 'enmse-series-engine'),
                ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'serelatedmessages',
				'show_if' => array(
					'show_related_messages' => 'on',
				),
			),
			'num_related_messages'     => array( // Pagination Details
				'label'           => esc_html__( 'Number of Related ' . $enmsemessagetp . ' Per Page', 'enmse-series-engine' ),
				'type'            => 'range',
				'range_settings' => array(
		          'min' => '1',
		          'max' => '100',
		          'step' => '1',
		        ),
		        'default'         => '10',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'sepaginationsettings',
				'show_if' => array(
					'show_related_messages' => 'on',
				),
			),
			'num_series_archives'     => array(
				'label'           => esc_html__( 'Number of ' . $enmseseriest . ' Per Page in the ' . $enmseseriest . ' Archives', 'enmse-series-engine' ),
				'type'            => 'range',
				'range_settings' => array(
		          'min' => '1',
		          'max' => '100',
		          'step' => '1',
		        ),
		        'default'         => '10',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'sepaginationsettings',
			),
		);
	}

	public function get_settings_modal_toggles() {
		$enmse_options = get_option( 'enm_seriesengine_options' ); 

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

		if ( isset($enmse_options['bookt']) ) { // Find Book Title
		    $enmsebookt = $enmse_options['bookt'];
		} else {
		    $enmsebookt = "Book";
		}

		if ( isset($enmse_options['booktp']) ) { // Find Book Title (plural)
		    $enmsebooktp = $enmse_options['booktp'];
		} else {
		    $enmsebooktp = "Books";
		}

	  	return array(
	    	'advanced' => array(
	      		'toggles' => array(
					'segeneral' => array(
	          			'priority' => 1,
	          			'title' => 'Series Engine Embed Options',
	        		),
	        		'sesearchmenus' => array(
	          			'priority' => 2,
	          			'title' => $enmsemessaget . ' Explorer Search Menus',
	        		),
	        		'semessageoptions' => array(
	          			'priority' => 3,
	          			'title' => $enmsemessaget . ' Options',
	       			),
	        		'serelatedmessages' => array(
	          			'priority' => 4,
	          			'title' => 'Related ' . $enmsemessagetp,
	        		),
	        		'sepaginationsettings' => array(
	          			'priority' => 5,
	          			'title' => 'Pagination Settings',
	        		),
	      		),
	    	),
	  	);
	}


	public function render( $unprocessed_props, $content = null, $render_slug ) {

		$enmse_options = get_option( 'enm_seriesengine_options' ); 

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

		if ( isset($enmse_options['bookt']) ) { // Find Book Title
		    $enmsebookt = $enmse_options['bookt'];
		} else {
		    $enmsebookt = "Book";
		}

		if ( isset($enmse_options['booktp']) ) { // Find Book Title (plural)
		    $enmsebooktp = $enmse_options['booktp'];
		} else {
		    $enmsebooktp = "Books";
		}

		$enmse_stid = $this->props['series_type'];
		$enmse_sid = $this->props['series'];
		$enmse_tid = $this->props['topic'];
		$enmse_spid = $this->props['speaker'];
		$enmse_mid = $this->props['message'];
		$enmse_bid = $this->props['book'];
		$enmse_explorer = $this->props['show_message_explorer'];
		$enmse_related = $this->props['show_related_messages'];
		$enmse_related_sort = $this->props['related_messages_sort_order'];
		$enmse_initial = $this->props['show_initial_message'];
		$enmse_sharinglinks = $this->props['show_sharing_links'];
		$enmse_seriesinfo = $this->props['show_series_details'];
		$enmse_audiodownload = $this->props['show_audio_download'];
		if ( $this->props['what_to_display'] == 1 ) { // normal display
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_mid = 0;
			$enmse_bid = 0;
		}
		if ( $this->props['what_to_display'] == 2 ) { // display all messages
			$enmse_am = 1;
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_mid = 0;
			$enmse_bid = 0;
		} else {
			$enmse_am = 0;
		}
		if ( $this->props['what_to_display'] == 3 ) { // specific message
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_bid = 0;
		}
		if ( $this->props['what_to_display'] == 4 ) { // specific series
			$enmse_mid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_bid = 0;
		}
		if ( $this->props['what_to_display'] == 5 ) { // specific topic
			$enmse_mid = 0;
			$enmse_sid = 0;
			$enmse_spid = 0;
			$enmse_bid = 0;
		}
		if ( $this->props['what_to_display'] == 6 ) { // specific speaker
			$enmse_mid = 0;
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_bid = 0;
		}
		if ( $this->props['what_to_display'] == 7 ) { // specific book
			$enmse_mid = 0;
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
		}
		if ( $this->props['what_to_display'] == 8 ) { // series archives
			$enmse_a = 1;
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_mid = 0;
			$enmse_bid = 0;
		} else {
			$enmse_a = 0;
		}
		$enmse_pag = $this->props['num_related_messages'];
		$enmse_apag = $this->props['num_series_archives'];
		$enmse_cardview = $this->props['style_of_related_messages'];
		$enmse_seriesmenu = $this->props['show_browse_series'];
		$enmse_speakermenu = $this->props['show_browse_speakers'];
		$enmse_topicmenu = $this->props['show_browse_topics'];
		$enmse_bookmenu = $this->props['show_browse_books'];

		if ( $enmse_sharinglinks == "off" ) { 
			$enmse_sharinglinkse = " enmse_hsh=1"; 
		} else {
			$enmse_sharinglinkse = ""; 
		}

		if ( $enmse_seriesinfo == "off" ) { 
			$enmse_seriesinfoe = " enmse_hs=1"; 
		} else {
			$enmse_seriesinfoe = "";
		}

		if ( $enmse_audiodownload == "off" ) { 
			$enmse_audiodownloade = " enmse_had=1"; 
		} else {
			$enmse_audiodownloade = "";
		}

		if ( $enmse_cardview != "0" && $enmse_cardview != "classic"  ) { 
			if ( $enmse_cardview != "1" && $enmse_cardview != "grid" ) {
				$enmse_cardviewe = " enmse_cv=2"; 
			} else {
				$enmse_cardviewe = " enmse_cv=1"; 
			}
		} else {
			$enmse_cardviewe = "";
		}

		if ( $enmse_stid > 0 ) { 
			$enmse_stide = " enmse_dsst=" . $enmse_stid; 
		} else {
			$enmse_stide = ""; 
		}

		if ( $enmse_sid > 0 ) {
			$enmse_side = " enmse_dss=" . $enmse_sid; 
		} else {
			$enmse_side = ""; 
		}

		if ( $enmse_tid > 0 ) { 
			$enmse_tide = " enmse_dst=" . $enmse_tid; 
		} else {
			$enmse_tide = ""; 
		} 

		if ( $enmse_bid > 0 ) {
			$enmse_bide = " enmse_dsb=" . $enmse_bid; 
		} else {
			$enmse_bide = ""; 
		}


		if ( $enmse_spid > 0 ) { 
			$enmse_spide = " enmse_dssp=" . $enmse_spid; 
		} else {
			$enmse_spide = ""; 
		}

		if ( $enmse_pag != 0 ) { 
			$enmse_page = " enmse_pag=" . $enmse_pag; 
		} else {
			$enmse_page = ""; 
		} 

		if ( $enmse_apag != 0 ) { 
			$enmse_apage = " enmse_apag=" . $enmse_apag; 
		} else {
			$enmse_apage = ""; 
		}  

		if ( $enmse_mid > 0 ) { 
			$enmse_mide = " enmse_dsm=" . $enmse_mid; 
		} else {
			$enmse_mide = "";
		} 

		if ( $enmse_explorer == "on" ) { 
			$enmse_explorere = " enmse_e=1"; 
		} else {
			$enmse_explorere = ""; 
		} 

		if ( $enmse_related == "on" ) { 
			$enmse_relatede = " enmse_r=1"; 
		} else {
			$enmse_relatede = ""; 
		} 

		if ( $enmse_related_sort == "1" || $enmse_related_sort == "newest" ) { 
			$enmse_related_sorte = " enmse_sort=1"; 
		} else {
			$enmse_related_sorte = ""; 
		} 

		if ( $enmse_initial == "off" ) { 
			$enmse_initiale = " enmse_sim=0"; 
		} else {
			$enmse_initiale = ""; 
		}  

		if ( $enmse_a == 1 ) { 
			$enmse_ae = " enmse_a=1"; 
		} else {
			$enmse_ae = ""; 
		} 

		if ( $enmse_am == 1 ) { 
			$enmse_ame = " enmse_am=1"; 
		} else {
			$enmse_ame = "";
		} 

		if ( $enmse_explorer == "on" && $enmse_seriesmenu == "off" ) { 
			$enmse_seriesmenue = " enmse_hsd=1"; 
		} else {
			$enmse_seriesmenue = ""; 
		} 

		if ( $enmse_explorer == "on" && $enmse_speakermenu == "off" ) { 
			$enmse_speakermenue = " enmse_hspd=1"; 
		} else {
			$enmse_speakermenue = ""; 
		} 

		if ( $enmse_explorer == "on" && $enmse_topicmenu == "off" ) { 
			$enmse_topicmenue = " enmse_htd=1"; 
		} else {
			$enmse_topicmenue = "";
		} 

		if ( $enmse_explorer == "on" && $enmse_bookmenu == "off" ) { 
			$enmse_bookmenue = " enmse_hbd=1"; 
		} else {
			$enmse_bookmenue = ""; 
		}

		$enmse_final_shortcode = "[seriesengine_wo" . $enmse_sharinglinkse . $enmse_seriesinfoe . $enmse_audiodownloade . $enmse_cardviewe . $enmse_stide . $enmse_side . $enmse_tide . $enmse_bide . $enmse_spide . $enmse_page . $enmse_apage . $enmse_mide . $enmse_explorere . $enmse_relatede . $enmse_related_sorte . $enmse_initiale . $enmse_ae . $enmse_ame . $enmse_seriesmenue . $enmse_speakermenue . $enmse_topicmenue . $enmse_bookmenue . "]";

		if ( $this->props['what_to_display'] == 3 && $this->props['message'] == 0 ) {
			return '<h3>Finish configuring Series Engine: Please select a ' . $enmsemessaget . ' to display, or change your display settings.</h3>';
		} elseif ( $this->props['what_to_display'] == 4 && $this->props['series'] == 0 ) {
			return '<h3>Finish configuring Series Engine: Please select a ' . $enmseseriest . ' to display, or change your display settings.</h3>';
		} elseif ( $this->props['what_to_display'] == 5 && $this->props['topic'] == 0 ) {
			return '<h3>Finish configuring Series Engine: Please select a ' . $enmsetopict . ' to display, or change your display settings.</h3>';
		} elseif ( $this->props['what_to_display'] == 6 && $this->props['speaker'] == 0 ) {
			return '<h3>Finish configuring Series Engine: Please select a ' . $enmsespeakert . ' to display, or change your display settings.</h3>';
		} elseif ( $this->props['what_to_display'] == 7 && $this->props['book'] == 0 ) {
			return '<h3>Finish configuring Series Engine: Please select a ' . $enmsebookt . ' to display, or change your display settings.</h3>';
		} else { 
		 	return do_shortcode($enmse_final_shortcode);
		}
		
	} 
}

new ENMSE_SeriesEngine;