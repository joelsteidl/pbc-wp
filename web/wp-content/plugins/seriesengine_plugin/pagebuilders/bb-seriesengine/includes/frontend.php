<?php

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

$enmse_stid = $settings->from_series_type;
$enmse_sid = $settings->from_series;
$enmse_tid = $settings->from_topic;
$enmse_spid = $settings->from_speaker;
$enmse_mid = $settings->from_message;
$enmse_bid = $settings->from_book;
$enmse_explorer = $settings->show_message_explorer;
$enmse_related = $settings->show_related_messages;
$enmse_related_sort = $settings->sort_order;
$enmse_initial = $settings->show_initial_message;
$enmse_sharinglinks = $settings->show_sharinglinks;
$enmse_seriesinfo = $settings->show_seriesinfo;
$enmse_audiodownload = $settings->show_audiodownload;
if ( $settings->what_to_display == 1 ) { // normal display
	$enmse_sid = 0;
	$enmse_tid = 0;
	$enmse_spid = 0;
	$enmse_mid = 0;
	$enmse_bid = 0;
}
if ( $settings->what_to_display == 2 ) { // display all messages
	$enmse_am = 1;
	$enmse_sid = 0;
	$enmse_tid = 0;
	$enmse_spid = 0;
	$enmse_mid = 0;
	$enmse_bid = 0;
} else {
	$enmse_am = 0;
}
if ( $settings->what_to_display == 3 ) { // specific message
	$enmse_sid = 0;
	$enmse_tid = 0;
	$enmse_spid = 0;
	$enmse_bid = 0;
}
if ( $settings->what_to_display == 4 ) { // specific series
	$enmse_mid = 0;
	$enmse_tid = 0;
	$enmse_spid = 0;
	$enmse_bid = 0;
}
if ( $settings->what_to_display == 5 ) { // specific topic
	$enmse_mid = 0;
	$enmse_sid = 0;
	$enmse_spid = 0;
	$enmse_bid = 0;
}
if ( $settings->what_to_display == 6 ) { // specific speaker
	$enmse_mid = 0;
	$enmse_sid = 0;
	$enmse_tid = 0;
	$enmse_bid = 0;
}
if ( $settings->what_to_display == 7 ) { // specific book
	$enmse_mid = 0;
	$enmse_sid = 0;
	$enmse_tid = 0;
	$enmse_spid = 0;
}
if ( $settings->what_to_display == 8 ) { // series archives
	$enmse_a = 1;
	$enmse_sid = 0;
	$enmse_tid = 0;
	$enmse_spid = 0;
	$enmse_mid = 0;
	$enmse_bid = 0;
} else {
	$enmse_a = 0;
}
$enmse_pag = $settings->pag;
$enmse_apag = $settings->apag;
$enmse_cardview = $settings->style_of_related;
$enmse_seriesmenu = $settings->show_browse_series;
$enmse_speakermenu = $settings->show_browse_speakers;
$enmse_topicmenu = $settings->show_browse_topics;
$enmse_bookmenu = $settings->show_browse_books;

?>
<div class="bb-seriesengine">
<?php if ( $settings->what_to_display == 3 && $settings->from_message == 0 ) {
	echo '<h3>Please select a ' . $enmsemessaget . ' to display, or change your display settings.</h3>';
} elseif ( $settings->what_to_display == 4 && $settings->from_series == 0 ) {
	echo '<h3>Please select a ' . $enmseseriest . ' to display, or change your display settings.</h3>';
} elseif ( $settings->what_to_display == 5 && $settings->from_topic == 0 ) {
	echo '<h3>Please select a ' . $enmsetopict . ' to display, or change your display settings.</h3>';
} elseif ( $settings->what_to_display == 6 && $settings->from_speaker == 0 ) {
	echo '<h3>Please select a ' . $enmsespeakert . ' to display, or change your display settings.</h3>';
} elseif ( $settings->what_to_display == 7 && $settings->from_book == 0 ) {
	echo '<h3>Please select a ' . $enmsebookt . ' to display, or change your display settings.</h3>';
} else { ?>
[seriesengine_wo<?php if ( $enmse_sharinglinks == 0 ) { echo " enmse_hsh=1"; } if ( $enmse_seriesinfo == 0 ) { echo " enmse_hs=1"; } if ( $enmse_audiodownload == 0 ) { echo " enmse_had=1"; } if ( $enmse_cardview > 0 ) { echo " enmse_cv=" . $enmse_cardview; } if ( $enmse_stid > 0 ) { echo " enmse_dsst=" . $enmse_stid; }; if ( $enmse_sid > 0 ) { echo " enmse_dss=" . $enmse_sid; }; if ( $enmse_tid > 0 ) { echo " enmse_dst=" . $enmse_tid; }; if ( $enmse_bid > 0 ) { echo " enmse_dsb=" . $enmse_bid; }; if ( $enmse_spid > 0 ) { echo " enmse_dssp=" . $enmse_spid; }; if ( $enmse_pag != 0 ) { echo " enmse_pag=" . $enmse_pag; }; if ( $enmse_apag != 0 ) { echo " enmse_apag=" . $enmse_apag; };  if ( $enmse_mid > 0 ) { echo " enmse_dsm=" . $enmse_mid; }; if ( $enmse_explorer == 1 ) { echo " enmse_e=1"; }; if ( $enmse_related == 1 ) { echo " enmse_r=1"; }; if ( $enmse_related_sort == 1 ) { echo " enmse_sort=1"; }; if ( $enmse_initial == 0 ) { echo " enmse_sim=0"; };  if ( $enmse_a == 1 ) { echo " enmse_a=1"; }; if ( $enmse_am == 1 ) { echo " enmse_am=1"; }; if ( $enmse_explorer == 1 && $enmse_seriesmenu == 0 ) { echo " enmse_hsd=1"; }; if ( $enmse_explorer == 1 && $enmse_speakermenu == 0 ) { echo " enmse_hspd=1"; }; if ( $enmse_explorer == 1 && $enmse_topicmenu == 0 ) { echo " enmse_htd=1"; }; if ( $enmse_explorer == 1 && $enmse_bookmenu == 0 ) { echo " enmse_hbd=1"; }; ?>]
<?php } ?>
</div>