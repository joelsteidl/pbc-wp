<?php
namespace ElementorSeriesEngine\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Series Engine
 *
 * Elementor widget for Series Engine.
 *
 * @since 2.8.0
 */
class Series_Engine extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 2.8.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'series-engine';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 2.8.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Series Engine', 'elementor-series-engine' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 2.8.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-play';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 2.8.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 2.8.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'elementor-series-engine' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.8.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

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

		// Section: Series Engine Embed Options
		$this->start_controls_section(
			'section_series_engine_embed_options',
			[
				'label' => __( 'Series Engine Embed Options', 'elementor-series-engine' ),
			]
		);

		$this->add_control(
			'what_to_display',
			[
				'label' => __( 'What to Display', 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
                    '1'      => __('The Most Recent ' . $enmsemessaget, 'elementor-series-engine'),
                    '2'      => __('Display All ' . $enmsemessagetp . ' (Regardless of ' . $enmseseriest . ')', 'elementor-series-engine'),
                    '3'      => __('Display a Specific ' . $enmsemessaget, 'elementor-series-engine'),
                    '4'      => __('Display a Specific ' . $enmseseriest, 'elementor-series-engine'),
                    '5'      => __('Display a Specific ' . $enmsetopict, 'elementor-series-engine'),
                    '6'      => __('Display a Specific ' . $enmsespeakert, 'elementor-series-engine'),
                    '7'      => __('Display a Specific ' . $enmsebookt, 'elementor-series-engine'),
                    '8'      => __('Display ' . $enmseseriest . ' Archives', 'elementor-series-engine')
				],
				'description' => 'Starting by choosing what to display in this Series Engine embed.',
			]
		);

		$this->add_control(
			'series_type',
			[
				'label' => __( 'From What ' . $enmseseriest . ' Type?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $sedivi_seriestypes,
				'description' => 'Limit the content displayed to a certain ' . $enmseseriest . ' Type.',
			]
		);

		$this->add_control(
			'more_options',
			[
				'label' => __( 'Select Specific Content', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'important_note',
			[	
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( '<p>If (and only if) you selected to display a specific ' . $enmsemessaget . ', ' . $enmseseriest . ', ' . $enmsetopict . ', ' . $enmsespeakert . ', or ' . $enmsebookt . '  above, you must also select the relevant display criteria below.</p>', 'plugin-name' ),
				'content_classes' => 'your-class',
			]
		);

		$this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'message',
			[
				'label' => __( 'Choose a ' . $enmsemessaget, 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $sedivi_messages,
				'description' => 'Choose which ' . $enmsemessaget . ' you want to display (if you chose that option in the first step above).',
			]
		);

		$this->add_control(
			'series',
			[
				'label' => __( 'Choose a ' . $enmseseriest, 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $sedivi_series,
				'description' => 'Choose which ' . $enmseseriest . ' you want to display (if you chose that option in the first step above).',
			]
		);

		$this->add_control(
			'topic',
			[
				'label' => __( 'Choose a ' . $enmsetopict, 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $sedivi_topics,
				'description' => 'Choose which ' . $enmsetopict . ' you want to display (if you chose that option in the first step above).',
			]
		);

		$this->add_control(
			'speaker',
			[
				'label' => __( 'Choose a ' . $enmsespeakert, 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $sedivi_speakers,
				'description' => 'Choose which ' . $enmsespeakert . ' you want to display (if you chose that option in the first step above).',
			]
		);

		$this->add_control(
			'book',
			[
				'label' => __( 'Choose a ' . $enmsebookt, 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $sedivi_books,
				'description' => 'Choose which ' . $enmsebookt . ' you want to display (if you chose that option in the first step above).',
			]
		);

		$this->end_controls_section();

		// Section: Message Explorer
		$this->start_controls_section(
			'section_series_engine_message_explorer',
			[
				'label' => __( 'Message Explorer Search Menus', 'elementor-series-engine' ),
			]
		);

		$this->add_control(
			'show_message_explorer',
			[
				'label' => __( 'Show Message Explorer Search Bar?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on',
				'description' => 'Show or hide the Message Explorer search bar in its entirety.',
			]
		);

		$this->add_control(
			'show_browse_series',
			[
				'label' => __( 'Show "Browse ' . $enmseseriestp . '" Menu?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->add_control(
			'show_browse_speakers',
			[
				'label' => __( 'Show "Browse ' . $enmsespeakertp . '" Menu?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->add_control(
			'show_browse_topics',
			[
				'label' => __( 'Show "Browse ' . $enmsetopictp . '" Menu?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->add_control(
			'show_browse_books',
			[
				'label' => __( 'Show "Browse ' . $enmsebooktp . '" Menu?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->end_controls_section();

		// Section: Message Explorer
		$this->start_controls_section(
			'section_series_engine_message_options',
			[
				'label' => __( 'Message Options', 'elementor-series-engine' ),
			]
		);

		$this->add_control(
			'show_initial_message',
			[
				'label' => __( 'Show Initial ' . $enmsemessaget . '?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->add_control(
			'show_sharing_links',
			[
				'label' => __( 'Show Sharing Links Below Player?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->add_control(
			'show_series_details',
			[
				'label' => __( 'Show ' . $enmseseriest . ' Details Below Player?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->add_control(
			'show_audio_download',
			[
				'label' => __( 'Show Audio Download Link?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->end_controls_section();


		// Section: Related Messages
		$this->start_controls_section(
			'section_series_engine_related_messages',
			[
				'label' => __( 'Related Messages', 'elementor-series-engine' ),
			]
		);

		$this->add_control(
			'show_related_messages',
			[
				'label' => __( 'Show Related ' . $enmsemessagetp . '?', 'elementor-series-engine' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-series-engine' ),
				'label_off' => __( 'No', 'elementor-series-engine' ),
				'return_value' => 'on',
				'default' => 'on'
			]
		);

		$this->add_control(
			'style_of_related_messages',
			[
				'label' => __( 'Style of Related ' . $enmsemessagetp, 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
                    '0'      => __('Classic List View', 'enmse-series-engine'),
                    '1'      => __('Grid View', 'enmse-series-engine'),
                    '2'      => __('Row View', 'enmse-series-engine'),
				]
			]
		);

		$this->add_control(
			'related_messages_sort_order',
			[
				'label' => __( 'Related ' . $enmsemessagetp . ' Sort Order', 'elementor-series-engine' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => [
                    '0'      => __('Oldest First', 'enmse-series-engine'),
                    '1'      => __('Newest First', 'enmse-series-engine'),
				]
			]
		);

		$this->end_controls_section(); 

		$this->remove_control('hide_desktop');

		// Section: Pagination Settings
		$this->start_controls_section(
			'section_series_engine_pagination',
			[
				'label' => __( 'Pagination Settings', 'elementor-series-engine' ),
			]
		);

		$this->add_control(
			'num_related_messages',
			[
				'label' => __( 'Number of Related ' . $enmsemessagetp . ' Per Page', 'elementor-series-engine' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 5000,
				'step' => 1,
				'default' => 10,
			]
		);

		$this->add_control(
			'num_series_archives',
			[
				'label' => __( 'Number of ' . $enmseseriest . ' Per Page in the ' . $enmseseriest . ' Archives', 'plugin-domain' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 5000,
				'step' => 1,
				'default' => 12,
			]
		);

		$this->end_controls_section(); 

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.8.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

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

		$enmse_stid = $settings['series_type'];
		$enmse_sid = $settings['series'];
		$enmse_tid = $settings['topic'];
		$enmse_spid = $settings['speaker'];
		$enmse_mid = $settings['message'];
		$enmse_bid = $settings['book'];
		$enmse_explorer = $settings['show_message_explorer'];
		$enmse_related = $settings['show_related_messages'];
		$enmse_related_sort = $settings['related_messages_sort_order'];
		$enmse_initial = $settings['show_initial_message'];
		$enmse_sharinglinks = $settings['show_sharing_links'];
		$enmse_seriesinfo = $settings['show_series_details'];
		$enmse_audiodownload = $settings['show_audio_download'];
		if ( $settings['what_to_display'] == 1 ) { // normal display
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_mid = 0;
			$enmse_bid = 0;
		}
		if ( $settings['what_to_display'] == 2 ) { // display all messages
			$enmse_am = 1;
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_mid = 0;
			$enmse_bid = 0;
		} else {
			$enmse_am = 0;
		}
		if ( $settings['what_to_display'] == 3 ) { // specific message
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_bid = 0;
		}
		if ( $settings['what_to_display'] == 4 ) { // specific series
			$enmse_mid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_bid = 0;
		}
		if ( $settings['what_to_display'] == 5 ) { // specific topic
			$enmse_mid = 0;
			$enmse_sid = 0;
			$enmse_spid = 0;
			$enmse_bid = 0;
		}
		if ( $settings['what_to_display'] == 6 ) { // specific speaker
			$enmse_mid = 0;
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_bid = 0;
		}
		if ( $settings['what_to_display'] == 7 ) { // specific book
			$enmse_mid = 0;
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
		}
		if ( $settings['what_to_display'] == 8 ) { // series archives
			$enmse_a = 1;
			$enmse_sid = 0;
			$enmse_tid = 0;
			$enmse_spid = 0;
			$enmse_mid = 0;
			$enmse_bid = 0;
		} else {
			$enmse_a = 0;
		}
		$enmse_pag = $settings['num_related_messages'];
		$enmse_apag = $settings['num_series_archives'];
		$enmse_cardview = $settings['style_of_related_messages'];
		$enmse_seriesmenu = $settings['show_browse_series'];
		$enmse_speakermenu = $settings['show_browse_speakers'];
		$enmse_topicmenu = $settings['show_browse_topics'];
		$enmse_bookmenu = $settings['show_browse_books'];

		if ( $enmse_sharinglinks == "" ) { 
			$enmse_sharinglinkse = " enmse_hsh=1"; 
		} else {
			$enmse_sharinglinkse = ""; 
		}

		if ( $enmse_seriesinfo == "" ) { 
			$enmse_seriesinfoe = " enmse_hs=1"; 
		} else {
			$enmse_seriesinfoe = "";
		}

		if ( $enmse_audiodownload == "" ) { 
			$enmse_audiodownloade = " enmse_had=1"; 
		} else {
			$enmse_audiodownloade = "";
		}

		if ( $enmse_cardview != "0" ) { 
			if ( $enmse_cardview != "1" ) {
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

		if ( $enmse_related_sort == "1" ) { 
			$enmse_related_sorte = " enmse_sort=1"; 
		} else {
			$enmse_related_sorte = ""; 
		} 

		if ( $enmse_initial == "" ) { 
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

		if ( $enmse_explorer == "on" && $enmse_seriesmenu == "" ) { 
			$enmse_seriesmenue = " enmse_hsd=1"; 
		} else {
			$enmse_seriesmenue = ""; 
		} 

		if ( $enmse_explorer == "on" && $enmse_speakermenu == "" ) { 
			$enmse_speakermenue = " enmse_hspd=1"; 
		} else {
			$enmse_speakermenue = ""; 
		} 

		if ( $enmse_explorer == "on" && $enmse_topicmenu == "" ) { 
			$enmse_topicmenue = " enmse_htd=1"; 
		} else {
			$enmse_topicmenue = "";
		} 

		if ( $enmse_explorer == "on" && $enmse_bookmenu == "" ) { 
			$enmse_bookmenue = " enmse_hbd=1"; 
		} else {
			$enmse_bookmenue = ""; 
		}

		$enmse_final_shortcode = "[seriesengine_wo" . $enmse_sharinglinkse . $enmse_seriesinfoe . $enmse_audiodownloade . $enmse_cardviewe . $enmse_stide . $enmse_side . $enmse_tide . $enmse_bide . $enmse_spide . $enmse_page . $enmse_apage . $enmse_mide . $enmse_explorere . $enmse_relatede . $enmse_related_sorte . $enmse_initiale . $enmse_ae . $enmse_ame . $enmse_seriesmenue . $enmse_speakermenue . $enmse_topicmenue . $enmse_bookmenue . "]";


		if ( $settings['what_to_display'] == 3 && $settings['message'] == 0 ) {
			echo '<h3>Finish configuring Series Engine in Elementor: Please select a ' . $enmsemessaget . ' to display, or change your display settings.</h3>';
		} elseif ( $settings['what_to_display'] == 4 && $settings['series'] == 0 ) {
			echo '<h3>Finish configuring Series Engine in Elementor: Please select a ' . $enmseseriest . ' to display, or change your display settings.</h3>';
		} elseif ( $settings['what_to_display'] == 5 && $settings['topic'] == 0 ) {
			echo '<h3>Finish configuring Series Engine in Elementor: Please select a ' . $enmsetopict . ' to display, or change your display settings.</h3>';
		} elseif ( $settings['what_to_display'] == 6 && $settings['speaker'] == 0 ) {
			echo '<h3>Finish configuring Series Engine in Elementor: Please select a ' . $enmsespeakert . ' to display, or change your display settings.</h3>';
		} elseif ( $settings['what_to_display'] == 7 && $settings['book'] == 0 ) {
			echo '<h3>Finish configuring Series Engine in Elementor: Please select a ' . $enmsebookt . ' to display, or change your display settings.</h3>';
		} else { 
		 	echo do_shortcode($enmse_final_shortcode);
		}
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.8.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<h4 style="text-align: center">Please Click "Update" to Save</h4>
		<p style="text-align: center">The changes to your Series Engine embed will be reflected on the live page outside of the Elementor page builder, or when you refresh this page. You can also click the preview icon beside the Update button to view your changes as you select different Series Engine options.</p>
		<p style="text-align: center"><em>Remember to embed Series Engine in a full-width column for the best results.</em></p>
		<?php
	}
}
