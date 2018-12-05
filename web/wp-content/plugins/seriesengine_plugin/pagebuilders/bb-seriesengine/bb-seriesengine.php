<?php

class FLSeriesEngineModule extends FLBuilderModule {

    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Series Engine', 'fl-builder'),
            'description'   => __('A Beaver Builder module for the Series Engine sermon plugin.', 'fl-builder'),
            'category'		=> __('Media', 'fl-builder'),
            'dir'           => FL_MODULE_SE_DIR . 'bb-seriesengine/',
            'url'           => FL_MODULE_SE_URL . 'bb-seriesengine/',
            'editor_export' => true, 
            'enabled'       => true 
        ));
    }
}

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

// Get All Series Types
global $wpdb;
$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
$enmse_series_types = $wpdb->get_results( $enmse_preparredsql );

$sebb_seriestypes = array();
foreach ($enmse_series_types as $st) {
    $sebb_seriestypes[$st->series_type_id] = __(stripslashes($st->name), 'fl-builder');
}
$sebb_seriestypes['0'] = __('All ' . $enmseseriest . ' Types', 'fl-builder');

// Get All Series
$enmse_preparredsql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " WHERE archived = 0 ORDER BY start_date DESC"; 
$enmse_series = $wpdb->get_results( $enmse_preparredsql );

$sebb_series = array();
foreach ($enmse_series as $s) {
    $sebb_series[$s->series_id] = __(stripslashes($s->s_title), 'fl-builder');
}
$sebb_series['0'] = __('- Select a ' . $enmseseriest . ' -', 'fl-builder');

// Get All Messages
$enmse_preparredsql = "SELECT message_id, title, date FROM " . $wpdb->prefix . "se_messages" . " ORDER BY date DESC"; 
$enmse_messages = $wpdb->get_results( $enmse_preparredsql );

$sebb_messages = array();
foreach ($enmse_messages as $m) {
    $sebb_messages[$m->message_id] = __(stripslashes($m->title) . " (" . date_i18n($enmse_dateformat, strtotime($m->date)) . ")", 'fl-builder');
}
$sebb_messages['0'] = __('- Select a ' . $enmsemessaget . ' -', 'fl-builder');

// Get All Speakers
$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name ASC"; 
$enmse_speakers = $wpdb->get_results( $enmse_preparredsql );

$sebb_speakers = array();
foreach ($enmse_speakers as $sp) {
    $sebb_speakers[$sp->speaker_id] = __(stripslashes($sp->first_name) . " " . stripslashes($sp->last_name), 'fl-builder');
}
$sebb_speakers['0'] = __('- Select a ' . $enmsespeakert . ' -', 'fl-builder');

// Get All Topics
$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
$enmse_topics = $wpdb->get_results( $enmse_preparredsql );

$sebb_topics= array();
foreach ($enmse_topics as $t) {
    $sebb_topics[$t->topic_id] = __(stripslashes($t->name), 'fl-builder');
}
$sebb_topics['0'] = __('- Select a ' . $enmsetopict . ' -', 'fl-builder');

// Get All Books
$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_books" . " ORDER BY book_id ASC"; 
$enmse_books = $wpdb->get_results( $enmse_preparredsql );

$sebb_books = array();
foreach ($enmse_books as $b) {
    $sebb_books[$b->book_id] = __(stripslashes($b->book_name), 'fl-builder');
}
$sebb_books['0'] = __('- Select a ' . $enmsebookt . ' -', 'fl-builder');


FLBuilder::register_module('FLSeriesEngineModule', array(
    'general'       => array( 
        'title'         => __('Display Settings', 'fl-builder'), 
        'sections'      => array( 
            'general'       => array( 
                'title'         => __('Select What Content to Display', 'fl-builder'), 
                'description'         => __('<p style="padding-left: 10px; padding-right: 10px;">Change the options below to adjust what is initially displayed on the page, and limit the Series Engine content that the user can browse from this page. A wealth of other options are available under the <em>"Customize Player"</em> tab above.</p><p style="padding-left: 10px; padding-right: 10px;"><em><strong>Please note:</strong> Series Engine is designed to be used in a full-width page layout or in a large column. It may not look good on the desktop when placed in narrow display columns.</em></p>', 'fl-builder'), 
                'fields'        => array( 
                    'what_to_display'   => array(
                        'type'          => 'select',
                        'label'         => __('What to Display:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('The Most Recent ' . $enmsemessaget, 'fl-builder'),
                            '2'      => __('Display All ' . $enmsemessagetp . ' (Regardless of ' . $enmseseriest . ')', 'fl-builder'),
                            '3'      => __('Display a Specific ' . $enmsemessaget, 'fl-builder'),
                            '4'      => __('Display a Specific ' . $enmseseriest, 'fl-builder'),
                            '5'      => __('Display a Specific ' . $enmsetopict, 'fl-builder'),
                            '6'      => __('Display a Specific ' . $enmsespeakert, 'fl-builder'),
                            '7'      => __('Display a Specific ' . $enmsebookt, 'fl-builder'),
                            '8'      => __('Display ' . $enmseseriest . ' Archives', 'fl-builder')
                        ),
                        'help'          => 'Choose what to display on the initial page load. The default is to show the most recent ' . $enmsemessaget . ' and related ' . $enmsemessagetp . ' from its ' . $enmseseriest . '.',
                        'toggle'        => array(
                            '1'      => array(
                                'fields'        => array('from_series_type'),
                                'sections'      => array()
                            ),
                            '2'      => array(
                                'fields'        => array('from_series_type'),
                                'sections'      => array()
                            ),
                            '3'      => array(
                                'fields'        => array('from_series_type','from_message'),
                                'sections'      => array()
                            ),
                            '4'      => array(
                                'fields'        => array('from_series_type','from_series'),
                                'sections'      => array()
                            ),
                            '5'      => array(
                                'fields'        => array('from_series_type','from_topic'),
                                'sections'      => array()
                            ),
                            '6'      => array(
                                'fields'        => array('from_series_type','from_speaker'),
                                'sections'      => array()
                            ),
                            '7'      => array(
                                'fields'        => array('from_series_type','from_book'),
                                'sections'      => array()
                            ),
                            '8'      => array(
                                'fields'        => array('from_series_type'),
                                'sections'      => array()
                            )
                        )
                    ),
                    'from_series_type'   => array(
                        'type'          => 'select',
                        'label'         => __('From What ' . $enmseseriest . ' Type?:', 'fl-builder'),
                        'default'       => '0',
                        'options'       => $sebb_seriestypes,
                        'help'          => 'Choosing a ' . $enmseseriest . ' Type will limit all content displayed to the chosen type. This is useful for seperating Sunday ' . $enmsemessagetp . ' from student ' . $enmsemessagetp . ', and so on.'
 
                    ),
                    'from_series'   => array(
                        'type'          => 'select',
                        'label'         => __('From What ' . $enmseseriest . '?:', 'fl-builder'),
                        'default'       => '0',
                        'options'       => $sebb_series,
                        'description'   => '<br /><br />Make sure you choose a ' . $enmseseriest . ' from the selected ' . $enmseseriest . ' Type.' 
                    ),
                    'from_message'   => array(
                        'type'          => 'select',
                        'label'         => __('What ' . $enmsemessaget . '?:', 'fl-builder'),
                        'default'       => '0',
                        'options'       => $sebb_messages,
                        'description'   => '<br /><br />Make sure you choose a ' . $enmsemessaget . ' from the selected ' . $enmseseriest . ' Type.',
                        'size'          => '20' 
                    ),
                    'from_speaker'   => array(
                        'type'          => 'select',
                        'label'         => __('From What ' . $enmsespeakert . '?:', 'fl-builder'),
                        'default'       => '0',
                        'options'       => $sebb_speakers,
                        'description'   => '<br /><br />Make sure you choose a ' . $enmsespeakert . ' with ' . $enmsemessagetp . ' from the selected ' . $enmseseriest . ' Type.' 
                    ),
                    'from_topic'   => array(
                        'type'          => 'select',
                        'label'         => __('From What ' . $enmsetopict . '?:', 'fl-builder'),
                        'default'       => '0',
                        'options'       => $sebb_topics,
                        'description'   => '<br /><br />Make sure you choose a ' . $enmsetopict . ' with ' . $enmsemessagetp . ' from the selected ' . $enmseseriest . ' Type.' 
                    ),
                    'from_book'   => array(
                        'type'          => 'select',
                        'label'         => __('From What ' . $enmsebookt . '?:', 'fl-builder'),
                        'default'       => '0',
                        'options'       => $sebb_books,
                        'description'   => '<br /><br />Make sure you choose a ' . $enmsebookt . ' with ' . $enmsemessagetp . ' from the selected ' . $enmseseriest . ' Type.' 
                    )
                )
            )
        )
    ),
    'options'       => array( 
        'title'         => __('Customize Player', 'fl-builder'), 
        'sections'      => array( 
            'explorer'       => array( 
                'title'         => __($enmsemessaget . ' Explorer Search Menus', 'fl-builder'), 
                'description'         => __('<p style="padding-left: 10px; padding-right: 10px;">Choose to display or hide the bar at the top of the player that contains the ' . $enmsemessaget . ' explorer dropdown search filters. You can also selectively hide or display individual filters.</p>', 'fl-builder'), 
                'fields'        => array( 
                        'show_message_explorer'   => array(
                        'type'          => 'select',
                        'label'         => __('Show ' . $enmsemessaget . ' Explorer Search Bar?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        ),
                        'help'          => 'Show or hide the ' . $enmsemessaget . ' explorer bar in its entirety.',
                        'toggle'        => array(
                            '1'      => array(
                                'fields'        => array('show_browse_series', 'show_browse_speakers','show_browse_topics','show_browse_books'),
                                'sections'      => array()
                            ),
                            '0'      => array(
                                'fields'        => array(),
                                'sections'      => array()
                            )
                        )
                    ),
                        'show_browse_series'   => array(
                        'type'          => 'select',
                        'label'         => __('Show "Browse ' . $enmseseriestp . '" Menu?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    ),
                        'show_browse_speakers'   => array(
                        'type'          => 'select',
                        'label'         => __('Show "Browse ' . $enmsespeakertp . '" Menu?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    ),
                        'show_browse_topics'   => array(
                        'type'          => 'select',
                        'label'         => __('Show "Browse ' . $enmsetopictp . '" Menu?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    ),
                        'show_browse_books'   => array(
                        'type'          => 'select',
                        'label'         => __('Show "Browse ' . $enmsebooktp . '" Menu?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    )
                )
            ),
            'messages'       => array( 
                'title'         => __($enmsemessaget . ' Options', 'fl-builder'), 
                'description'         => __('<p style="padding-left: 10px; padding-right: 10px;">Choose whether you want to show an initial ' . $enmsemessaget . '\'s media and content on the page load, or require the user to select a ' . $enmsemessaget . ' to view first. You can also customize a few other details in the player area.</p>', 'fl-builder'), 
                'fields'        => array( 
                        'show_initial_message'   => array(
                        'type'          => 'select',
                        'label'         => __('Show Initial ' . $enmsemessaget . '?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    ),
                     'show_sharinglinks'   => array(
                        'type'          => 'select',
                        'label'         => __('Show Sharing Links Below Player?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    ),
                     'show_seriesinfo'   => array(
                        'type'          => 'select',
                        'label'         => __('Show ' . $enmseseriest . ' Details Below Player?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    ),
                     'show_audiodownload'   => array(
                        'type'          => 'select',
                        'label'         => __('Show Audio Download Link?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    )
                )
            ),
            'related'       => array( 
                'title'         => __('Related ' . $enmsemessagetp, 'fl-builder'), 
                'description'         => __('<p style="padding-left: 10px; padding-right: 10px;">Choose whether to display a list of related ' . $enmsemessagetp . ' on the page (other ' . $enmsemessagetp . ' from the same ' . $enmseseriest . ', ' . $enmsetopict . ', ' . $enmsespeakert . ', etc). You can also select the order order of these ' . $enmsemessagetp . ', and how you would like them to be displayed.</p>', 'fl-builder'), 
                'fields'        => array( 
                        'show_related_messages'   => array(
                        'type'          => 'select',
                        'label'         => __('Show Related ' . $enmsemessagetp . '?:', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __('Yes', 'fl-builder'),
                            '0'      => __('No', 'fl-builder')
                        )
                    ),
                        'style_of_related'   => array(
                        'type'          => 'select',
                        'label'         => __('Style of Related ' . $enmsemessagetp . ':', 'fl-builder'),
                        'default'       => '1',
                        'options'       => array(
                            '0'      => __('Classic List View', 'fl-builder'),
                            '1'      => __('Grid View', 'fl-builder'),
                            '2'      => __('Row View', 'fl-builder')
                        )
                    ),
                        'sort_order'   => array(
                        'type'          => 'select',
                        'label'         => __('Related ' . $enmsemessagetp . ' Sort Order:', 'fl-builder'),
                        'default'       => '0',
                        'options'       => array(
                            '0'      => __('Oldest First', 'fl-builder'),
                            '1'      => __('Newest First', 'fl-builder')
                        )
                    )
                )
            ),
            'pagination'       => array( 
                'title'         => __('Pagination Settings', 'fl-builder'), 
                'description'         => __('<p style="padding-left: 10px; padding-right: 10px;">Specify how many ' . $enmsemessagetp . ' or ' . $enmseseriestp . ' you want to display on each "page;" this keeps long lists of content from feeling overwhelming.</p>', 'fl-builder'), 
                'fields'        => array( 
                        'pag'   => array(
                        'type'          => 'text',
                        'label'         => __('Number of Related ' . $enmsemessagetp . ' Per Page:', 'fl-builder'),
                        'default'       => '10',
                        'size'          => '3',
                        'help'          => 'The number of related ' . $enmsemessagetp . ' that appear at a time below the selected ' . $enmsemessaget . '.'
                    ),
                        'apag'   => array(
                        'type'          => 'text',
                        'label'         => __('Number of ' . $enmseseriestp . ' Per Page in ' . $enmseseriest . ' Archives:', 'fl-builder'),
                        'default'       => '12',
                        'size'          => '3',
                        'help'          => 'The number of ' . $enmseseriestp . ' that appear at a time in the ' . $enmseseriest . ' Archives view.'
                    )
                )
            )
        )
    )
));

