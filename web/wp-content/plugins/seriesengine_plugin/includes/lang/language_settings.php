<?php /* Series Engine English Translation */

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

if ( isset($enmse_options['scripturelabel']) ) { // Find Scripture Label
	$enmse_reftext = $enmse_options['scripturelabel'];
} else {
	$enmse_reftext = "Scripture References";
}

if ( isset($enmse_options['bibleoption']) ) { // Is Scripture Enabled?
	$bibleoption = $enmse_options['bibleoption'];
} else {
	$bibleoption = 0;
}

/* Get Language Settings from Database */

// Loading Message Popover
if ( isset($enmse_options['lang_loading']) ) { 
	$enmse_loadingmessage = $enmse_options['lang_loading'];
} else {
	$enmse_loadingmessage = "Loading Content...";
}

// Share Link Popover Title
if ( isset($enmse_options['lang_sharelinktitle']) ) { 
	$lang_sharelinktitle = $enmse_options['lang_sharelinktitle'];
	$enmse_sharelinktitle =  str_replace("MESSAGE_LABEL", $enmsemessaget, $lang_sharelinktitle);
} else {
	$lang_sharelinktitle = "Share a Link to this MESSAGE_LABEL";
	$enmse_sharelinktitle =  str_replace("MESSAGE_LABEL", $enmsemessaget, $lang_sharelinktitle);
}

// Share Link Popover Instructions
if ( isset($enmse_options['lang_sharelinkinstructions']) ) { 
	$enmse_sharelinkinstructions = $enmse_options['lang_sharelinkinstructions'];
} else {
	$enmse_sharelinkinstructions = "The link has been copied to your clipboard; paste it anywhere you would like to share it.";
}

// Share Link Popover Close Button
if ( isset($enmse_options['lang_sharelinkclosebutton']) ) { 
	$enmse_sharelinkclosebutton = $enmse_options['lang_sharelinkclosebutton'];
} else {
	$enmse_sharelinkclosebutton = "Close";
}

// Series Archives Explore Text
if ( isset($enmse_options['lang_archiveexplore']) ) { 
	$lang_archiveexplore = $enmse_options['lang_archiveexplore'];
	$enmse_archiveexplore =  str_replace("SERIES_LABEL", $enmseseriest, $lang_archiveexplore);
} else {
	$lang_archiveexplore = "Explore This SERIES_LABEL";
	$enmse_archiveexplore =  str_replace("SERIES_LABEL", $enmseseriest, $lang_archiveexplore);
}

// Browse Series Dropdown
if ( isset($enmse_options['lang_explorerbrowseseries']) ) { 
	$lang_explorerbrowseseries = $enmse_options['lang_explorerbrowseseries'];
	$enmse_explorerbrowseseries =  str_replace("PLURAL_SERIES_LABEL", $enmseseriestp, $lang_explorerbrowseseries);
} else {
	$lang_explorerbrowseseries = "Browse PLURAL_SERIES_LABEL";
	$enmse_explorerbrowseseries =  str_replace("PLURAL_SERIES_LABEL", $enmseseriestp, $lang_explorerbrowseseries);
}

// Browse Speakers Dropdown
if ( isset($enmse_options['lang_explorerbrowsespeakers']) ) { 
	$lang_explorerbrowsespeakers = $enmse_options['lang_explorerbrowsespeakers'];
	$enmse_explorerbrowsespeakers =  str_replace("PLURAL_SPEAKERS_LABEL", $enmsespeakertp, $lang_explorerbrowsespeakers);
} else {
	$lang_explorerbrowsespeakers = "Browse PLURAL_SPEAKERS_LABEL";
	$enmse_explorerbrowsespeakers =  str_replace("PLURAL_SPEAKERS_LABEL", $enmsespeakertp, $lang_explorerbrowsespeakers);
}

// Browse Topics Dropdown
if ( isset($enmse_options['lang_explorerbrowsetopics']) ) { 
	$lang_explorerbrowsetopics = $enmse_options['lang_explorerbrowsetopics'];
	$enmse_explorerbrowsetopics =  str_replace("PLURAL_TOPICS_LABEL", $enmsetopictp, $lang_explorerbrowsetopics);
} else {
	$lang_explorerbrowsetopics = "Browse PLURAL_TOPICS_LABEL";
	$enmse_explorerbrowsetopics =  str_replace("PLURAL_TOPICS_LABEL", $enmsetopictp, $lang_explorerbrowsetopics);
}

// Browse Books Dropdown
if ( isset($enmse_options['lang_explorerbrowsebooks']) ) { 
	$lang_explorerbrowsebooks = $enmse_options['lang_explorerbrowsebooks'];
	$enmse_explorerbrowsebooks =  str_replace("PLURAL_BOOKS_LABEL", $enmsebooktp, $lang_explorerbrowsebooks);
} else {
	$lang_explorerbrowsebooks = "Browse PLURAL_BOOKS_LABEL";
	$enmse_explorerbrowsebooks =  str_replace("PLURAL_BOOKS_LABEL", $enmsebooktp, $lang_explorerbrowsebooks);
}

// View Series Archives
if ( isset($enmse_options['lang_explorerarchives']) ) { 
	$lang_explorerarchives = $enmse_options['lang_explorerarchives'];
	$enmse_explorerarchives =  str_replace("SERIES_LABEL", $enmseseriest, $lang_explorerarchives);
} else {
	$lang_explorerarchives = "View SERIES_LABEL Archives";
	$enmse_explorerarchives =  str_replace("SERIES_LABEL", $enmseseriest, $lang_explorerarchives);
}

// View All Messages
if ( isset($enmse_options['lang_explorermessages']) ) { 
	$lang_explorermessages = $enmse_options['lang_explorermessages'];
	$enmse_explorermessages =  str_replace("PLURAL_MESSAGE_LABEL", $enmsemessagetp, $lang_explorermessages);
} else {
	$lang_explorermessages = "View All PLURAL_MESSAGE_LABEL";
	$enmse_explorermessages =  str_replace("PLURAL_MESSAGE_LABEL", $enmsemessagetp, $lang_explorermessages);
}

// Related Topics
if ( isset($enmse_options['lang_relatedtopics']) ) { 
	$lang_relatedtopics = $enmse_options['lang_relatedtopics'];
	$enmse_relatedtopics =  str_replace("PLURAL_TOPICS_LABEL", $enmsetopictp, $lang_relatedtopics);
} else {
	$lang_relatedtopics = "Related PLURAL_TOPICS_LABEL:";
	$enmse_relatedtopics =  str_replace("PLURAL_TOPICS_LABEL", $enmsetopictp, $lang_relatedtopics);
}

// More Messages From
if ( isset($enmse_options['lang_moremessagesfrom']) ) { 
	$lang_moremessagesfrom = $enmse_options['lang_moremessagesfrom'];
	$enmse_moremessagesfrom =  str_replace("PLURAL_MESSAGES_LABEL", $enmsemessagetp, $lang_moremessagesfrom);
} else {
	$lang_moremessagesfrom = "More PLURAL_MESSAGES_LABEL from";
	$enmse_moremessagesfrom =  str_replace("PLURAL_MESSAGES_LABEL", $enmsemessagetp, $lang_moremessagesfrom);
}

// Download Audio
if ( isset($enmse_options['lang_downloadaudio']) ) { 
	$enmse_downloadaudio = $enmse_options['lang_downloadaudio'];
} else {
	$enmse_downloadaudio = "Download Audio";
}

// From Series Label
if ( isset($enmse_options['lang_fromseries']) ) { 
	$lang_fromseries = $enmse_options['lang_fromseries'];
	$enmse_fromseries =  str_replace("SERIES_LABEL", $enmseseriest, $lang_fromseries);
} else {
	$lang_fromseries = "From SERIES_LABEL:";
	$enmse_fromseries =  str_replace("SERIES_LABEL", $enmseseriest, $lang_fromseries);
}

// Facebook Share Link
if ( isset($enmse_options['lang_sharefb']) ) { 
	$enmse_sharefb = $enmse_options['lang_sharefb'];
} else {
	$enmse_sharefb = "Facebook";
}

// Twitter Share Link
if ( isset($enmse_options['lang_sharetw']) ) { 
	$enmse_sharetw = $enmse_options['lang_sharetw'];
} else {
	$enmse_sharetw = "Tweet Link";
}

// Share Link
if ( isset($enmse_options['lang_sharepop']) ) { 
	$enmse_sharepop = $enmse_options['lang_sharepop'];
} else {
	$enmse_sharepop = "Share Link";
}

// Share Email
if ( isset($enmse_options['lang_shareemail']) ) { 
	$enmse_shareemail = $enmse_options['lang_shareemail'];
} else {
	$enmse_shareemail = "Send Email";
}

// More From Topics
if ( isset($enmse_options['lang_morefromtopics']) ) { 
	$lang_morefromtopics = $enmse_options['lang_morefromtopics'];
	$enmse_morefromtopics =  str_replace("PLURAL_MESSAGES_LABEL", $enmsemessagetp, $lang_morefromtopics);
} else {
	$lang_morefromtopics = "More PLURAL_MESSAGES_LABEL Associated With";
	$enmse_morefromtopics =  str_replace("PLURAL_MESSAGES_LABEL", $enmsemessagetp, $lang_morefromtopics);
}

// More From Books
if ( isset($enmse_options['lang_morefrombooks']) ) { 
	$lang_morefrombooks = $enmse_options['lang_morefrombooks'];
	$enmse_morefrombooks =  str_replace("BOOK_LABEL", $enmsebookt, $lang_morefrombooks);
} else {
	$lang_morefrombooks = "More From the BOOK_LABEL of";
	$enmse_morefrombooks =  str_replace("BOOK_LABEL", $enmsebookt, $lang_morefrombooks);
}

// More From Speakers
if ( isset($enmse_options['lang_morefromspeakers']) ) { 
	$lang_morefromspeakers = $enmse_options['lang_morefromspeakers'];
	$enmse_morefromspeakers =  str_replace("PLURAL_MESSAGES_LABEL", $enmsemessagetp, $lang_morefromspeakers);
} else {
	$lang_morefromspeakers = "More PLURAL_MESSAGES_LABEL From";
	$enmse_morefromspeakers =  str_replace("PLURAL_MESSAGES_LABEL", $enmsemessagetp, $lang_morefromspeakers);
}

// More From Generic
if ( isset($enmse_options['lang_morefromgeneric']) ) { 
	$lang_morefromgeneric = $enmse_options['lang_morefromgeneric'];
	$enmse_morefromgeneric =  str_replace("PLURAL_MESSAGES_LABEL", $enmsemessagetp, $lang_morefromgeneric);
} else {
	$lang_morefromgeneric = "More PLURAL_MESSAGES_LABEL";
	$enmse_morefromgeneric =  str_replace("PLURAL_MESSAGES_LABEL", $enmsemessagetp, $lang_morefromgeneric);
}

// More From Series
if ( isset($enmse_options['lang_morefromseries']) ) { 
	$enmse_morefromseries = $enmse_options['lang_morefromseries'];
} else {
	$enmse_morefromseries = "More From";
}

// Pagination More Button
if ( isset($enmse_options['lang_pagemore']) ) { 
	$enmse_pagemore = $enmse_options['lang_pagemore'];
} else {
	$enmse_pagemore = "More";
}

// Pagination Back Button
if ( isset($enmse_options['lang_pageback']) ) { 
	$enmse_pageback = $enmse_options['lang_pageback'];
} else {
	$enmse_pageback = "Back";
}


/* Front End Series Engine Display */


$enmse_poweredby = "Powered by Series Engine";
$enmse_poweredbylink = "Powered by <a href=\"http://seriesengine.com\" target=\"_blank\">Series Engine</a>";

 ?>