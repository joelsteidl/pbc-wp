<?php header("Content-type: text/css"); 

require_once '../../../../wp-load.php'; // ADJUST THIS PATH if using a non-standard WordPress install
$enmse_options = get_option( 'enm_seriesengine_options' );
$enmse_embedwidth = $enmse_options['embedwidth'];
if ( isset($enmse_options['archivewidth']) ) { 
	$enmse_archivewidth = $enmse_options['archivewidth'] - 20;
} else {
	$enmse_archivewidth = 135;
}
$enmse_font = $enmse_options['font'];
$enmse_explorertitletext = $enmse_options['explorertitletext'];
$enmse_explorerbackground = $enmse_options['explorerbackground'];
$enmse_explorerselectborder = $enmse_options['explorerselectborder'];
$enmse_explorerselect = $enmse_options['explorerselect'];
$enmse_explorerselecttext = $enmse_options['explorerselecttext'];
$enmse_mstitletext = $enmse_options['mstitletext'];
$enmse_msdatetext = $enmse_options['msdatetext'];
$enmse_playerselectedtabbackground = $enmse_options['playerselectedtabbackground'];
$enmse_playerselectedtabtext = $enmse_options['playerselectedtabtext'];
$enmse_playertabbackground = $enmse_options['playertabbackground'];
$enmse_playertabtext = $enmse_options['playertabtext'];
$enmse_playerdetailsbackground = $enmse_options['playerdetailsbackground'];
$enmse_playeroptions = $enmse_options['playeroptions'];
$enmse_detailstext = $enmse_options['detailstext'];
$enmse_detailstitletext = $enmse_options['detailstitletext'];
$enmse_detailsrelatedtext = $enmse_options['detailsrelatedtext'];
$enmse_detailslinks = $enmse_options['detailslinks'];
if ( isset($enmse_options['downloadsbg']) ) {
	$enmse_downloadsbg = $enmse_options['downloadsbg'];
} else {
	$enmse_downloadsbg = 'e6e6e6';
}
if ( isset($enmse_options['downloadsspacer']) ) {
	$enmse_downloadsspacer = $enmse_options['downloadsspacer'];
} else {
	$enmse_downloadsspacer = '000000';
}
if ( isset($enmse_options['downloadlinks']) ) {
	$enmse_downloadlinks = $enmse_options['downloadlinks'];
} else {
	$enmse_downloadlinks = '486d7d';
}
$enmse_shareoptions = $enmse_options['shareoptions'];
$enmse_sharebuttonbackground = $enmse_options['sharebuttonbackground'];
$enmse_sharebuttontext = $enmse_options['sharebuttontext'];
$enmse_sharelinkbackground = $enmse_options['sharelinkbackground'];
$enmse_sharelinktext = $enmse_options['sharelinktext'];
$enmse_sharelinkbuttonbackground = $enmse_options['sharelinkbuttonbackground'];
$enmse_sharelinkbuttontext = $enmse_options['sharelinkbuttontext'];
$enmse_comptitletext = $enmse_options['comptitletext'];
$enmse_compoddrow = $enmse_options['compoddrow'];
$enmse_comprowtitletext = $enmse_options['comprowtitletext'];
$enmse_comprowdatetext = $enmse_options['comprowdatetext'];
$enmse_complinks = $enmse_options['complinks'];
$enmse_loadingbackground = $enmse_options['loadingbackground'];
$enmse_loadingtext = $enmse_options['loadingtext'];
$enmse_loadingicon = $enmse_options['loadingicon'];
$enmse_archivetitle = $enmse_options['archivetitle'];
$enmse_archiverow = $enmse_options['archiverow'];
$enmse_archiveseriestitle = $enmse_options['archiveseriestitle'];
$enmse_archivedatecount = $enmse_options['archivedatecount'];
$enmse_archivelinks = $enmse_options['archivelinks'];
$enmse_poweredby = $enmse_options['poweredby'];
$enmse_poweredbytext = $enmse_options['poweredbytext'];

if ( isset($enmse_options['audiobg']) ) {
	$enmse_audiobg = $enmse_options['audiobg'];
} else {
	$enmse_audiobg = '000000';
}

?>
/* ----- Series Engine ----- */

#seriesengine {
	margin: 0 auto;
	padding: 0;
	width: <?php echo $enmse_embedwidth; ?>px;
	position: relative;
}

#seriesengine * {
	-webkit-box-sizing: content-box !important;
	-moz-box-sizing: content-box !important;
	box-sizing: content-box !important;
}

#seriesengine h1, #seriesengine h2, #seriesengine h3, #seriesengine h4, #seriesengine h5, #seriesengine h6, #seriesengine p, #seriesengine form, #seriesengine ul, #seriesengine ol, #seriesengine li, #seriesengine ol li, #seriesengine ul li, #seriesengine blockquote, #seriesengine input, #seriesengine input[type="submit"], #seriesengine textarea, #seriesengine select, #seriesengine select:focus, #seriesengine label, #seriesengine table, #seriesengine table tr, #seriesengine table tr td, #seriesengine iframe, #seriesengine object, #seriesengine embed, #seriesengine img { /* resets most browser styles to enhance cross-browser compatibility */
	margin: 0;
	padding: 0;
	font-size: 16px !important;
	text-transform: none;
	letter-spacing: 0;
	line-height: 1;
	clear: none;
	font-weight: 300;
	<?php if ( $enmse_font == "arial" ) { 
		echo "font-family: Arial, Helvetica, sans-serif !important;";
	} elseif ( $enmse_font == "times" ) {
		echo "font-family: Times New Roman, Times New Roman, serif !important;";
	} elseif ( $enmse_font == "georgia" ) {
		echo "font-family: Georgia, Georgia, serif !important;";
	} elseif ( $enmse_font == "verdana" ) {
		echo "font-family: Verdana, Geneva, sans-serif !important;";
	} elseif ( $enmse_font == "lucida" ) {
		echo "font-family: Lucida Sans Unicode, Lucida Grande, sans-serif !important;";
	} elseif ( $enmse_font == "tahoma" ) {
		echo "font-family: Tahoma, Geneva, sans-serif !important;";
	} elseif ( $enmse_font == "trebuchet" ) {
		echo "font-family: Trebuchet MS, Trebuchet MS, sans-serif !important;";
	} ?>
	font-variant: normal;
	float: none;
	border: none;
	-moz-border-radius: 0;
	-webkit-border-radius: 0;
	border-radius: 0;
	background: none;
	min-height: 0;
	text-align: left;
	max-width: 100%;
	text-indent: 0
	box-shadow: none
}

#main #seriesengine table, #main #seriesengine table tr, #main #seriesengine table tr td {
	border: none;
	-moz-border-radius: 0;
	-webkit-border-radius: 0;
	border-radius: 0;
}

#seriesengine br {
	line-height: 0;
}

#seriesengine iframe, #seriesengine object, #seriesengine embed, #seriesengine img {
	width: 100%;
}

#seriesengine ul li:before {
	content: normal;
}

#seriesengine a {
	<?php if ( $enmse_font == "arial" ) { 
		echo "font-family: Arial, Helvetica, sans-serif !important;";
	} elseif ( $enmse_font == "times" ) {
		echo "font-family: Times New Roman, Times New Roman, serif !important;";
	} elseif ( $enmse_font == "georgia" ) {
		echo "font-family: Georgia, Georgia, serif !important;";
	} elseif ( $enmse_font == "verdana" ) {
		echo "font-family: Verdana, Geneva, sans-serif !important;";
	} elseif ( $enmse_font == "lucida" ) {
		echo "font-family: Lucida Sans Unicode, Lucida Grande, sans-serif !important;";
	} elseif ( $enmse_font == "tahoma" ) {
		echo "font-family: Tahoma, Geneva, sans-serif !important;";
	} elseif ( $enmse_font == "trebuchet" ) {
		echo "font-family: Trebuchet MS, Trebuchet MS, sans-serif !important;";
	} ?>
}

#seriesengine a:link {color: #<?php echo $enmse_complinks; ?>; text-decoration: underline; font-weight: 300}
#seriesengine a:visited {color: #<?php echo $enmse_complinks; ?>; text-decoration: underline; font-weight: 300}
#seriesengine a:hover {color: #<?php echo $enmse_complinks; ?>; text-decoration: none; font-weight: 300}
#seriesengine a:active {color: #<?php echo $enmse_complinks; ?>; text-decoration: underline; font-weight: 300}

/* ----- Series/Topic Selector ----- */

#seriesengine h4.enmse-more-messages-title {
	color: #<?php echo $enmse_explorertitletext; ?>;
	font-size: 16px !important;
	<?php if ( $enmse_font == "arial" ) { 
		echo "font-family: Arial, Helvetica, sans-serif !important;";
	} elseif ( $enmse_font == "times" ) {
		echo "font-family: Times New Roman, Times New Roman, serif !important;";
	} elseif ( $enmse_font == "georgia" ) {
		echo "font-family: Georgia, Georgia, serif !important;";
	} elseif ( $enmse_font == "verdana" ) {
		echo "font-family: Verdana, Geneva, sans-serif !important;";
	} elseif ( $enmse_font == "lucida" ) {
		echo "font-family: Lucida Sans Unicode, Lucida Grande, sans-serif !important;";
	} elseif ( $enmse_font == "tahoma" ) {
		echo "font-family: Tahoma, Geneva, sans-serif !important;";
	} elseif ( $enmse_font == "trebuchet" ) {
		echo "font-family: Trebuchet MS, Trebuchet MS, sans-serif !important;";
	} ?>
	margin: 0 0 10px 0;
}

#seriesengine .enmse-selector {
	background-color: #<?php echo $enmse_explorerbackground; ?>;
	width: 100%;
	margin: 0 0 25px 0;
	text-align: center;
	padding: 8px 0 8px 0;
	line-height: 0;
}

#seriesengine .enmse-selector h4 {
	display: inline;
	font-size: 15px !important;
}

#seriesengine .enmse-selector select {
	border: 1px solid #<?php echo $enmse_explorerselectborder; ?>;
	background-color: #<?php echo $enmse_explorerselect; ?>;
	color: #<?php echo $enmse_explorerselecttext; ?>;
	width: 31%;
	font-size: 13px !important;
	vertical-align: middle;
	height: 20px;
	display: inline;
}

#seriesengine .enmse-selector a.enmse-selector-button {
	background-color: #<?php echo $enmse_explorerbutton; ?>;
	color: #<?php echo $enmse_explorerbuttontext; ?>;
	text-decoration: none;
	text-align: center;
	font-size: 13px !important;
	display: inline-block;
	width: 36px;
	height: 22px;
	line-height: 22px;
	border-radius: 5px;
	-moz-border-radius: 5px;
}

/* ----- Message Title/Speaker ----- */

#seriesengine h2.enmse-message-title {
	color: #<?php echo $enmse_mstitletext; ?>;
	font-size: 19px !important;
	font-weight: 700;
	margin: 0 0 12px 0;
}

#seriesengine h3.enmse-message-meta {
	color: #<?php echo $enmse_msdatetext; ?>;
	float: right;
	font-size: 15px !important;
	font-style: italic;
	margin: 4px 0 0 0;
	padding: 0 0 0 10px;
}

/* ----- Media Section ----- */

#seriesengine .enmse-listen {
	padding: 0;
	line-height: 0;
}

#seriesengine .enmse-listen img {
	box-shadow: none;
}

#seriesengine .enmse-audio {
	background: none;
	background-color: #<?php echo $enmse_audiobg; ?>;
}

#seriesengine .enmse-audio audio {
}

#seriesengine .enmse-audio .mejs__container {
	background: none;
	width: 78% !important;
	box-sizing: border-box !important;
	padding: 0 !important;
}

#seriesengine video {
	margin: 0;
	padding: 0;
}

#seriesengine .mejs__video .mejs__controls {
	/*background: none;*/
	width: 100% !important;
	box-sizing: border-box !important;
}

#seriesengine .enmse-audio .mejs__controls:not([style*="display: none"]) {
    background: #<?php echo $enmse_audiobg; ?> !important;
}

#seriesengine .mejs__play > button:hover {
    background: transparent url("../js/mediaelement/build2/mejs-controls.svg");
    background-position: 0 0;
}

#seriesengine .mejs__pause > button:hover {
    background: transparent url("../js/mediaelement/build2/mejs-controls.svg");
    background-position: -20px 0;
}

#seriesengine .mejs__replay > button:hover {
    background: transparent url("../js/mediaelement/build2/mejs-controls.svg");
    background-position: -160px 0;
}

#seriesengine .mejs__mute > button:hover {
    background: transparent url("../js/mediaelement/build2/mejs-controls.svg");
    background-position: -60px 0;
}

#seriesengine .mejs__unmute > button:hover {
    background: transparent url("../js/mediaelement/build2/mejs-controls.svg");
    background-position: -40px 0;
}

#seriesengine .mejs__fullscreen-button > button {
    background: transparent url("../js/mediaelement/build2/mejs-controls.svg");
    background-position: -80px 0;
}

#seriesengine .mejs__unfullscreen > button {
    background: transparent url("../js/mediaelement/build2/mejs-controls.svg");
    background-position: -100px 0;
}

#seriesengine .enmse-player {
	background-color: #<?php echo $enmse_playerdetailsbackground; ?>;
	padding: 0 0 8px 0;
	margin: 0 0 15px 0;
	line-height: 0 !important;
	clear: both;
}

#seriesengine .enmse-media-container {
	background-color: #<?php echo $enmse_playerselectedtabbackground; ?>;
	width: <?php echo $enmse_embedwidth - 8; ?>px;
	padding: 4px;
	line-height: 0 !important;
}

#seriesengine .fluid-width-video-wrapper { /* Fix for FitVid/Standard Theme */  
	margin: 0 !important;                          
}

#seriesengine .enmse-audio a#enmse-download { /* MP3 Download Button */
	background-color: #fff;
	color: #<?php echo $enmse_audiobg; ?>;
	display: block;
	width: 63px;
	height: 16px;
	line-height: 16px;
	text-align: center;
	text-decoration: none;
	margin: 12px 10px 0 0;
	font-size: 11px !important;
	float: right;
	border-radius: 3px;
	-moz-border-radius: 3px;
}

/* ----- Tabs and Buttons ----- */

#seriesengine ul.enmse-player-tabs { /* Tabs */
	margin: 0 auto;
	text-align: left;
	padding: 0 0 0 15px;
	height: 26px;
	position: static;
}

#seriesengine ul.enmse-player-tabs li {
	display: inline-block;
	list-style-type: none;
	<?php if ( $enmse_font == "lucida" || $enmse_font == "trebuchet"|| $enmse_font == "verdana" ) { 
		echo "margin: 0 2px 0 0;";
	} else {
		echo "margin: 0 4px 0 0;";
	}; ?>
	width: 94px;
	height: 26px;
	font-size: 13px !important;
}

#seriesengine ul.enmse-player-tabs li a {
	background-color: #<?php echo $enmse_playertabbackground; ?>;
	color: #<?php echo $enmse_playertabtext; ?>;
	display: block;
	width: 94px;
	height: 26px;
	line-height: 26px;
	text-decoration: none;
	text-align: center;
}

#seriesengine ul.enmse-player-tabs li.enmse-tab-selected a {
	background-color: #<?php echo $enmse_playerselectedtabbackground; ?>;
	color: #<?php echo $enmse_playerselectedtabtext; ?>;
} 

#seriesengine ul.enmse-player-options { /* Options */
	margin: -26px auto 0 auto;
	text-align: right;
	padding: 0;
	position: static;
}

#seriesengine ul.enmse-player-options li.enmse-details {
	display: inline-block;
	list-style-type: none;
	margin: 0 4px 0 0;
	width: 70px;
	height: 26px;
	<?php if ( $enmse_font == "lucida" || $enmse_font == "courier" || $enmse_font == "verdana" ) { 
		echo "font-size: 12px !important;";
	} else {
		echo "font-size: 13px !important;";
	}; ?>	
}

#seriesengine ul.enmse-player-options li.enmse-extras {
	display: inline-block;
	list-style-type: none;
	margin: 0 4px 0 0;
	width: 66px;
	height: 26px;
	<?php if ( $enmse_font == "lucida" || $enmse_font == "courier" || $enmse_font == "verdana" ) { 
		echo "font-size: 12px !important;";
	} else {
		echo "font-size: 13px !important;";
	}; ?>	
}

#seriesengine ul.enmse-player-options li.enmse-share-this {
	display: inline-block;
	list-style-type: none;
	width: 70px;
	height: 26px;
	<?php if ( $enmse_font == "lucida" || $enmse_font == "courier" || $enmse_font == "verdana" ) { 
		echo "font-size: 12px !important;";
	} else {
		echo "font-size: 13px !important;";
	}; ?>
	margin: 0;
}

#seriesengine ul.enmse-player-options li.enmse-details a {
	display: block;
	width: 70px;
	height: 30px;
	line-height: 30px;
	text-decoration: none;
	text-align: center;
}

#seriesengine ul.enmse-player-options li.enmse-details a.enmse-hide-details {
	<?php if ( $enmse_playeroptions == "dark" ) { ?>
	background: url('../images/interface/dark_up.png') no-repeat;
	background-position: 0 9px;		
	color: #4e4e4e;
	<?php } else { ?>
	background: url('../images/interface/light_up.png') no-repeat;
	background-position: 0 9px;
	color: #d9d9d9;
	<?php } ?>
}

#seriesengine ul.enmse-player-options li.enmse-details a.enmse-show-details {
	<?php if ( $enmse_playeroptions == "dark" ) { ?>
	background: url('../images/interface/dark_down.png') no-repeat;
	background-position: 0 9px;		
	color: #4e4e4e;
	<?php } else { ?>
	background: url('../images/interface/light_down.png') no-repeat;
	background-position: 0 9px;		
	color: #d9d9d9;
	<?php } ?>
}

#seriesengine ul.enmse-player-options li.enmse-extras a {
	display: block;
	width: 66px;
	height: 30px;
	line-height: 30px;
	text-decoration: none;
	text-align: center;
	<?php if ( $enmse_playeroptions == "dark" ) { ?>
	background: url('../images/interface/dark_download.png') no-repeat;
	background-position: 0 9px;		
	color: #4e4e4e;
	<?php } else { ?>
	background: url('../images/interface/light_download.png') no-repeat;
	background-position: 0 9px;
	color: #d9d9d9;
	<?php } ?>
}

#seriesengine ul.enmse-player-options li.enmse-share-this a, #seriesengine ul.enmse-player-options li.enmse-hide-share-this a {
	display: block;
	width: 70px;
	height: 30px;
	line-height: 30px;
	text-decoration: none;
	text-align: center;
	<?php if ( $enmse_playeroptions == "dark" ) { ?>
	color: #4e4e4e;
	background: url('../images/interface/dark_share.png') no-repeat;
	background-position: 0 9px;
	<?php } else { ?>
	color: #d9d9d9;
	background: url('../images/interface/light_share.png') no-repeat;
	background-position: 0 9px;	
	<?php } ?>
}

/* ----- Message Details ----- */

#seriesengine .enmse-player .enmse-player-details {
	margin: 0 14px 0 14px;
	line-height: 0;
}

#seriesengine .enmse-player .enmse-player-details h3 {
	color: #<?php echo $enmse_detailstitletext; ?>;
	font-weight: 700;
	font-size: 15px !important;
	margin: 12px 0 10px 0;
}

#seriesengine .enmse-player .enmse-player-details p {
	color: #<?php echo $enmse_detailstext; ?>;
	font-size: 13px !important;
	line-height: 120%;
	margin: 0;
}

#seriesengine .enmse-player .enmse-player-details p.enmse-message-description {
	font-size: 13px !important;
	line-height: 120%;
	margin: 12px 0 0 0;
}

#seriesengine .enmse-player .enmse-player-details p.enmse-related-topics {
	color: #<?php echo $enmse_detailsrelatedtext; ?>;
	font-size: 12px !important;
	margin: 12px 0 6px 0;
}

#seriesengine .enmse-player .enmse-player-details p.enmse-related-topics strong {
	color: #<?php echo $enmse_detailsrelatedtext; ?>;
	font-weight: 700;
}

#seriesengine .enmse-player .enmse-player-details p.enmse-related-topics a {
	color: #<?php echo $enmse_detailslinks; ?>;
}

#seriesengine .enmse-player .enmse-player-details p.enmse-downloads {
	color: #<?php echo $enmse_downloadsspacer; ?>;
	text-align: center;
	font-size: 12px !important;
	margin: 10px 0 10px 0;
	padding: 8px 10px 8px 10px;
	background-color: #<?php echo $enmse_downloadsbg; ?>;
}

#seriesengine .enmse-player .enmse-player-extras p.enmse-downloads {
	color: #<?php echo $enmse_downloadsspacer; ?>;
	text-align: center;
	font-size: 12px !important;
	margin: 10px 14px 4px 14px;
	padding: 8px 10px 8px 10px;
	background-color: #<?php echo $enmse_downloadsbg; ?>;
}

#seriesengine .enmse-player .enmse-player-details p.enmse-downloads a, #seriesengine .enmse-player .enmse-player-extras p.enmse-downloads a {
	color: #<?php echo $enmse_downloadlinks; ?>;
}

/* ----- Share Options ----- */

#seriesengine .enmse-share-details {
	padding: 0 8px 0 8px;
	margin: 0 14px 0 14px;
	height: 42px;
	line-height: 0;
}

#seriesengine .enmse-share-details ul {
	width: 430px;
	margin: 0 auto;
}

#seriesengine .enmse-share-details ul li {
	list-style-type: none;
	float: left;
	font-size: 12px !important;
	margin: 12px 10px 8px 0;
}

#seriesengine .enmse-share-details ul li.enmse-email {
	margin: 12px 0 8px 0;
}

#seriesengine .enmse-share-details ul li a {
	-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
	text-decoration: none;
	text-align: left;
	display: block;
	<?php if ( $enmse_font == "verdana" ) { 
		echo "width: 68px;";
	} else {
		echo "width: 66px;";
	}; ?>
	height: 26px;
	line-height: 26px;
	<?php if ( $enmse_font == "verdana" ) { 
		echo "padding: 0 8px 0 24px;";
	} else {
		echo "padding: 0 8px 0 26px;";
	}; ?>
	border-radius: 13px;
	-moz-border-radius: 13px;
	color: #<?php echo $enmse_sharebuttontext; ?>;
}

#seriesengine .enmse-share-details ul li.enmse-facebook a {
	<?php if ( $enmse_shareoptions == "light" ) { ?>
	background: url('../images/interface/se_facebook_light.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/se_facebook_dark.png') no-repeat;
	<?php } ?>
	<?php if ( $enmse_font == "verdana" ) { 
		echo "background-position: 6px 6px;";
	} else {
		echo "background-position: 8px 6px;";
	}; ?>
	background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
}

#seriesengine .enmse-share-details ul li.enmse-twitter a {
	<?php if ( $enmse_shareoptions == "light" ) { ?>
	background: url('../images/interface/se_twitter_light.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/se_twitter_dark.png') no-repeat;
	<?php } ?>
	<?php if ( $enmse_font == "verdana" ) { 
		echo "background-position: 6px 6px;";
	} else {
		echo "background-position: 8px 6px;";
	}; ?>
	background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
}

#seriesengine .enmse-share-details ul li.enmse-share-link a {
	<?php if ( $enmse_shareoptions == "light" ) { ?>
	background: url('../images/interface/se_link_light.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/se_link_dark.png') no-repeat;
	<?php } ?>
	<?php if ( $enmse_font == "verdana" ) { 
		echo "background-position: 6px 6px;";
	} else {
		echo "background-position: 8px 6px;";
	}; ?>
	background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
}

#seriesengine .enmse-share-details ul li.enmse-email a {
	<?php if ( $enmse_shareoptions == "light" ) { ?>
	background: url('../images/interface/se_env_light.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/se_env_dark.png') no-repeat;
	<?php } ?>
	<?php if ( $enmse_font == "verdana" ) { 
		echo "background-position: 6px 6px;";
	} else {
		echo "background-position: 8px 6px;";
	}; ?>
	background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
}

/* ----- Related Messages Section ----- */

#seriesengine h3.enmse-more-title {
	color: #<?php echo $enmse_comptitletext; ?>;
	font-size: 16px !important;
}

#seriesengine table.enmse-more-messages {
	width: 100%;
	margin: 15px 0 0 0;
}

#seriesengine table.enmse-more-messages tr {
	border: 0;
	border-radius: 0;
}

#seriesengine table.enmse-more-messages tr.enmse-odd {
	background-color: #<?php echo $enmse_compoddrow; ?>;
}

#seriesengine table.enmse-more-messages td.enmse-title-cell {
	color: #<?php echo $enmse_comprowtitletext; ?>;
	font-size: 13px !important;
	font-weight: 700;
	text-align: left;
	padding: 7px 7px 7px 12px;
}

#seriesengine table.enmse-more-messages td.enmse-date-cell {
	color: #<?php echo $enmse_comprowdatetext; ?>;
	font-size: 13px !important;
	font-weight: 300;
	text-align: left;
	padding: 7px;
}

#seriesengine table.enmse-more-messages td.enmse-alternate-cell, #seriesengine table.enmse-more-messages td.enmse-watch-cell {
	font-size: 13px !important;
	font-weight: 300;
	width: 53px;
	text-align: center;
	padding: 7px 7px 7px 0;
}

#seriesengine table.enmse-more-messages td.enmse-listen-cell {
	font-size: 13px !important;
	font-weight: 300;
	width: 48px;
	text-align: center;
	padding: 7px 12px 7px 0;
}

/* ----- AJAX Loading Indicator ----- */

#seriesengine .enmse-content-container {
	z-index: 5; 
	line-height: 0;
}

#seriesengine .enmse-content-container.enmse-opaque, #seriesengine .enmse-related-area.enmse-opaque, #seriesengine .enmse-archive-container.enmse-opaque {
	opacity: 0.2; 
}

#seriesengine .enmse-loading-icon {
	width: 170px;
	height: 96px;
	position: absolute;
	background-color: #e1e1e1;
	z-index: 100;
	border-radius: 10px;
	<?php if ( $enmse_loadingicon == "light" ) { ?>
	background: url('../images/interface/light_load.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_load.png') no-repeat;
	<?php } ?>
	background-position: center 30px;
	background-color: #<?php echo $enmse_loadingbackground; ?>;
	color: #<?php echo $enmse_loadingtext; ?>;
	margin: 100px 0 0 -85px;
	left: 50%;
	line-height: 0;
}

#seriesengine .enmse-loading-icon p {
	-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
	margin: 10px 0 0 0;
	width: 150px;
	padding: 0 10px 0 10px;
	font-size: 14px !important;
	text-align: center;
	word-wrap: break-word !important;
}

#seriesengine .enmse-loading-icon img {
	width: 54px;
	height: 55px;
	margin: 5px 0 0 58px;
	box-shadow: none;
}

/* ----- Share Link Box ----- */

#seriesengine .enmse-copy-link-box {
	background-color: #<?php echo $enmse_sharelinkbackground; ?>;
	position: absolute;
	margin: 0 0 0 -160px;
	width: 320px;
    left: 50%;
	padding: 10px 10px 14px 10px;
	border-radius: 10px;
	z-index: 100;
	line-height: 0;
}

#seriesengine .enmse-copy-link-box h4 {
	color: #<?php echo $enmse_sharelinktext; ?>;
	font-size: 15px !important;
	font-weight: 700;
	text-align: center;
	margin: 0 0 15px 0;
}

#seriesengine .enmse-copy-link-box p {
	color: #<?php echo $enmse_sharelinktext; ?>;
	font-size: 14px !important;
	text-align: center;
	margin: 0 0 20px 0;
}

#seriesengine .enmse-copy-link-box a.enmse-copy-link-done {
	background-color: #<?php echo $enmse_sharelinkbuttonbackground; ?>;
	color: #<?php echo $enmse_sharelinkbuttontext; ?>;
	text-decoration: none;
	text-align: center;
	font-size: 13px !important;
	display: block;
	width: 120px;
	height: 26px;
	line-height: 26px;
	border-radius: 13px;
	margin: 0 auto;
	text-transform: uppercase;
}

/* ----- Series Archives ----- */

#seriesengine h3.enmse-archive-title {
	color: #<?php echo $enmse_archivetitle; ?>;
	font-size: 19px !important;
}

#seriesengine table.enmse-archive-table {
	width: 100%;
	margin: 15px 0 0 0;
}

#seriesengine table.enmse-archive-table tr.enmse-archive-odd {
	background-color: #<?php echo $enmse_archiverow; ?>;
}

#seriesengine table.enmse-archive-table td.enmse-archive-title-cell {
	color: #<?php echo $enmse_archiveseriestitle; ?>;
	font-size: 13px !important;
	font-weight: 700;
	text-align: left;
	padding: 14px 7px 14px 12px;
}

#seriesengine table.enmse-archive-table td.enmse-archive-date-cell {
	color: #<?php echo $enmse_archivedatecount; ?>;
	font-size: 13px !important;
	font-weight: 300;
	text-align: left;
	padding: 14px 7px 14px 7px;
}

#seriesengine table.enmse-archive-table td.enmse-archive-count-cell {
	color: #<?php echo $enmse_archivedatecount; ?>;
	font-size: 13px !important;
	font-weight: 300;
	text-align: left;
	padding: 14px 7px 14px 7px;
}

#seriesengine table.enmse-archive-table td.enmse-explore-cell {
	color: #<?php echo $enmse_archivelinks; ?>;
	font-size: 13px !important;
	font-weight: 300;
	text-align: right;
	padding: 14px 12px 14px 7px;
}

#seriesengine #enmse-archive-thumbnails {
	padding: 20px 0 20px 0;
	margin: 0;
}

#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb {
	display: inline-block; 
	vertical-align: top;
	width: <?php echo $enmse_archivewidth; ?>px;
	padding: 10px;
	margin: 0 0 8px 8px;
}

#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb img {
	padding: 0 0 10px 0;
	width: 100%;
	height: auto;
}

#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb h4 {
	text-align: center;
	font-size: 13px !important;
	padding: 0 0 4px 0;
	font-weight: 700;
	color: #<?php echo $enmse_archiveseriestitle; ?>
}

#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb h5 {
	text-align: center;
	font-size: 13px !important;
	padding: 0 0 4px 0;
	font-weight: 300;
	color: #<?php echo $enmse_archivedatecount; ?>
}

#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb p {
	text-align: center;
	font-size: 13px !important;
	font-weight: 300;
	font-style: italic;
	padding: 0 0 4px 0;
	color: #<?php echo $enmse_archivedatecount; ?>
}

#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb p.enmse-archive-link {
	text-align: center;
	font-size: 13px !important;
	font-weight: 300;
	font-style: normal;
	padding: 0;
}

#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb p.enmse-archive-link a {
	color: #<?php echo $enmse_archivelinks; ?>
}

/* ----- Powered By ----- */

#seriesengine h3.enmse-poweredby {
	margin: 20px auto 0 auto !important;
	text-indent: -9000px;
	width: 148px;
	height: 40px;
	<?php if ( $enmse_poweredby == "light" ) { ?>
	background: url('../images/interface/se_light_poweredby.png') no-repeat;	
	<?php } elseif ( $enmse_poweredby == "dark" ) { ?>
	background: url('../images/interface/se_dark_poweredby.png') no-repeat;
	<?php } ?>
	float: right;
}

#seriesengine h3.enmse-poweredby a {
	display: block;
	width: 148px;
	height: 40px;
}

#seriesengine p.enmse-poweredbytext {
	margin: 20px 0 20px 0;
	text-align: right;
	font-size: 12px !important;
	color: #<?php echo $enmse_poweredbytext; ?>;
}

#seriesengine p.enmse-poweredbytext a {
	color: #<?php echo $enmse_poweredbytext; ?>;
}

@media 
(-webkit-min-device-pixel-ratio: 2) {

#seriesengine ul.enmse-player-options li.enmse-share-this a, #seriesengine ul.enmse-player-options li.enmse-hide-share-this a {
	<?php if ( $enmse_playeroptions == "dark" ) { ?>
	color: #4e4e4e;
	background: url('../images/interface/dark_share2x.png') no-repeat;
	background-size: 13px 12px;
	background-position: 0 9px;
	<?php } else { ?>
	color: #d9d9d9;
	background: url('../images/interface/light_share2x.png') no-repeat;
	background-size: 13px 12px;
	background-position: 0 9px;	
	<?php } ?>
}

#seriesengine ul.enmse-player-options li.enmse-extras a {
	<?php if ( $enmse_playeroptions == "dark" ) { ?>
	background: url('../images/interface/dark_download2x.png') no-repeat;
	background-size: 11px 11px;
	background-position: 0 9px;		
	color: #4e4e4e;
	<?php } else { ?>
	background: url('../images/interface/light_download2x.png') no-repeat;
	background-size: 11px 11px;
	background-position: 0 9px;
	color: #d9d9d9;
	<?php } ?>
}

#seriesengine ul.enmse-player-options li.enmse-details a.enmse-hide-details {
	<?php if ( $enmse_playeroptions == "dark" ) { ?>
	background: url('../images/interface/dark_up2x.png') no-repeat;
	background-size: 11px 11px;
	background-position: 0 9px;		
	color: #4e4e4e;
	<?php } else { ?>
	background: url('../images/interface/light_up2x.png') no-repeat;
	background-size: 11px 11px;
	background-position: 0 9px;
	color: #d9d9d9;
	<?php } ?>
}

#seriesengine ul.enmse-player-options li.enmse-details a.enmse-show-details {
	<?php if ( $enmse_playeroptions == "dark" ) { ?>
	background: url('../images/interface/dark_down2x.png') no-repeat;
	background-size: 11px 11px;
	background-position: 0 9px;		
	color: #4e4e4e;
	<?php } else { ?>
	background: url('../images/interface/light_down2x.png') no-repeat;
	background-size: 11px 11px;
	background-position: 0 9px;		
	color: #d9d9d9;
	<?php } ?>
}

#seriesengine .enmse-share-details ul li.enmse-email a {
	<?php if ( $enmse_shareoptions == "light" ) { ?>
	background: url('../images/interface/se_env_light2x.png') no-repeat;
	background-size: 13px 13px;
	<?php } else { ?>
	background: url('../images/interface/se_env_dark2x.png') no-repeat;
	background-size: 13px 13px;
	<?php } ?>
	<?php if ( $enmse_font == "verdana" ) { 
		echo "background-position: 6px 6px;";
	} else {
		echo "background-position: 8px 6px;";
	}; ?>
	background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
}

#seriesengine .enmse-share-details ul li.enmse-share-link a {
	<?php if ( $enmse_shareoptions == "light" ) { ?>
	background: url('../images/interface/se_link_light2x.png') no-repeat;
	background-size: 13px 13px;
	<?php } else { ?>
	background: url('../images/interface/se_link_dark2x.png') no-repeat;
	background-size: 13px 13px;
	<?php } ?>
	<?php if ( $enmse_font == "verdana" ) { 
		echo "background-position: 6px 6px;";
	} else {
		echo "background-position: 8px 6px;";
	}; ?>
	background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
}

#seriesengine .enmse-share-details ul li.enmse-twitter a {
	<?php if ( $enmse_shareoptions == "light" ) { ?>
	background: url('../images/interface/se_twitter_light2x.png') no-repeat;
	background-size: 13px 13px;
	<?php } else { ?>
	background: url('../images/interface/se_twitter_dark2x.png') no-repeat;
	background-size: 13px 13px;
	<?php } ?>
	<?php if ( $enmse_font == "verdana" ) { 
		echo "background-position: 6px 6px;";
	} else {
		echo "background-position: 8px 6px;";
	}; ?>
	background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
}

#seriesengine .enmse-share-details ul li.enmse-facebook a {
	<?php if ( $enmse_shareoptions == "light" ) { ?>
	background: url('../images/interface/se_facebook_light2x.png') no-repeat;
	background-size: 13px 13px;
	<?php } else { ?>
	background: url('../images/interface/se_facebook_dark2x.png') no-repeat;
	background-size: 13px 13px;
	<?php } ?>
	<?php if ( $enmse_font == "verdana" ) { 
		echo "background-position: 6px 6px;";
	} else {
		echo "background-position: 8px 6px;";
	}; ?>
	background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
}

#seriesengine h3.enmse-poweredby {
	<?php if ( $enmse_poweredby == "light" ) { ?>
	background: url('../images/interface/se_light_poweredby2x.png') no-repeat;
	background-size: 148px 40px;	
	<?php } elseif ( $enmse_poweredby == "dark" ) { ?>
	background: url('../images/interface/se_dark_poweredby2x.png') no-repeat;
	background-size: 148px 40px;
	<?php } ?>
}

#seriesengine .enmse-loading-icon {
	<?php if ( $enmse_loadingicon == "light" ) { ?>
	background: url('../images/interface/light_load2x.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_load2x.png') no-repeat;
	<?php } ?>
	background-size: 54px 55px;
	background-position: center 30px;
	background-color: #<?php echo $enmse_loadingbackground; ?>;
}
}

/* ----- For Themes with Mobile Views ----- */

@media (max-width: 700px) {
	#seriesengine {
		margin: 0;
		padding: 0;
		width: inherit;
	}

	#seriesengine iframe, #seriesengine object, #seriesengine embed, #seriesengine img {
		width: 100%;
		height: auto;
	}

	#seriesengine h4.enmse-more-messages-title {
		display: none;
	}

	#seriesengine .enmse-selector {
		text-align: center;
	}

	#seriesengine .enmse-selector select:first-child {
		border: 1px solid #<?php echo $enmse_explorerselectborder; ?>;
		background-color: #<?php echo $enmse_explorerselect; ?>;
		color: #<?php echo $enmse_explorerselecttext; ?>;
		width: 90%;
		font-size: 16px !important;
		vertical-align: middle;
		height: 20px;
		display: inline-block;
		margin: 0;
	}

	#seriesengine .enmse-selector select {
		border: 1px solid #<?php echo $enmse_explorerselectborder; ?>;
		background-color: #<?php echo $enmse_explorerselect; ?>;
		color: #<?php echo $enmse_explorerselecttext; ?>;
		width: 90%;
		font-size: 16px !important;
		vertical-align: middle;
		height: 20px;
		display: inline-block;
		margin: 6px 0 0 0;
	}
	
	#seriesengine h2.enmse-message-title {
		color: #<?php echo $enmse_mstitletext; ?>;
		font-size: inherit;
		font-weight: inherit;
		margin: 10px 0 10px 0;
		text-align: center;
	}

	#seriesengine h3.enmse-message-meta {
		color: #<?php echo $enmse_msdatetext; ?>;
		float: none;
		font-size: inherit;
		font-style: inherit;
		margin: 10px 0 10px 0;
		padding: 0;
		text-align: center;
	}
	
	#seriesengine h3.enmse-archive-title {
		color: #<?php echo $enmse_archivetitle; ?>;
		font-size: inherit;
		margin: 10px 0 10px 0;
		padding: 0;
	}
	
	/*#seriesengine h3.enmse-more-title {
		display: none;
	}

	#seriesengine table.enmse-more-messages {
		display: none;
	}*/
	
	#seriesengine .enmse-player {
		
		padding: 0;
		margin: 15px 0 15px 0;
		line-height: 0;
		clear: both;
	}
	
	#seriesengine ul.enmse-player-tabs { /* Tabs */
		
	}

	#seriesengine .enmse-copy-link-box {
		position: absolute;
		margin: 0 0 0 -115px;
		width: 230px;
	    left:46%;
		padding: 10px 10px 14px 10px;
		border-radius: 10px;
		z-index: 100;
		line-height: 0;
	}

	/* ----- Tabs and Buttons ----- */

	#seriesengine ul.enmse-player-tabs { /* Tabs */
		margin: 0 auto;
		text-align: center;
		padding: 0;
		height: 26px;
		position: static;
	}

	#seriesengine ul.enmse-player-tabs li:first-child {
		display: inline-block;
		list-style-type: none;
		margin: 0;
		width: 28%;
		height: 26px;
		font-size: 13px !important;
	}

	#seriesengine ul.enmse-player-tabs li {
		display: inline-block;
		list-style-type: none;
		<?php if ( $enmse_font == "lucida" || $enmse_font == "trebuchet"|| $enmse_font == "verdana" ) { 
			echo "margin: 0 0 0 2px;";
		} else {
			echo "margin: 0 0 0 4px;";
		}; ?>
		width: 28%;
		height: 26px;
		font-size: 13px !important;
	}

	#seriesengine ul.enmse-player-tabs li a {
		background-color: #<?php echo $enmse_playertabbackground; ?>;
		color: #<?php echo $enmse_playertabtext; ?>;
		display: block;
		width: 100%;
		height: 26px;
		line-height: 26px;
		text-decoration: none;
		text-align: center;
	}

	#seriesengine ul.enmse-player-tabs li.enmse-tab-selected a {
		background-color: #<?php echo $enmse_playerselectedtabbackground; ?>;
		color: #<?php echo $enmse_playerselectedtabtext; ?>;
	} 

	#seriesengine ul.enmse-player-options { /* Options */
		margin: 0;
		text-align: center;
		padding: 0;
		position: static;
		height: 35px;
		padding: 8px 0 0 7px;
	}

	#seriesengine ul.enmse-player-options li.enmse-details {
		display: inline-block;
		list-style-type: none;
		margin: 0 4px 0 0;
		width: 70px;
		height: 26px;
		<?php if ( $enmse_font == "lucida" || $enmse_font == "courier" || $enmse_font == "verdana" ) { 
			echo "font-size: 12px !important;";
		} else {
			echo "font-size: 13px !important;";
		}; ?>
	}

	#seriesengine ul.enmse-player-options li.enmse-extras {
		display: inline-block;
		list-style-type: none;
		margin: 0 4px 0 0;
		width: 66px;
		height: 26px;
		<?php if ( $enmse_font == "lucida" || $enmse_font == "courier" || $enmse_font == "verdana" ) { 
			echo "font-size: 12px !important;";
		} else {
			echo "font-size: 13px !important;";
		}; ?>	
	}

	#seriesengine ul.enmse-player-options li.enmse-share-this {
		display: inline-block;
		list-style-type: none;
		width: 60px;
		height: 26px;
		<?php if ( $enmse_font == "lucida" || $enmse_font == "courier" || $enmse_font == "verdana" ) { 
			echo "font-size: 12px !important;";
		} else {
			echo "font-size: 13px !important;";
		}; ?>
		margin: 0;
	}

	#seriesengine ul.enmse-player-options li.enmse-details a {
		display: block;
		width: 70px;
		height: 30px;
		line-height: 30px;
		text-decoration: none;
		text-align: center;
	}

	#seriesengine ul.enmse-player-options li.enmse-details a.enmse-hide-details {
		<?php if ( $enmse_playeroptions == "dark" ) { ?>
		background: url('../images/interface/dark_up.png') no-repeat;
		background-position: 0 9px;		
		color: #4e4e4e;
		<?php } else { ?>
		background: url('../images/interface/light_up.png') no-repeat;
		background-position: 0 9px;
		color: #d9d9d9;
		<?php } ?>
	}

	#seriesengine ul.enmse-player-options li.enmse-details a.enmse-show-details {
		<?php if ( $enmse_playeroptions == "dark" ) { ?>
		background: url('../images/interface/dark_down.png') no-repeat;
		background-position: 0 9px;		
		color: #4e4e4e;
		<?php } else { ?>
		background: url('../images/interface/light_down.png') no-repeat;
		background-position: 0 9px;		
		color: #d9d9d9;
		<?php } ?>
	}

	#seriesengine ul.enmse-player-options li.enmse-extras a {
		display: block;
		width: 66px;
		height: 30px;
		line-height: 30px;
		text-decoration: none;
		text-align: center;
		<?php if ( $enmse_playeroptions == "dark" ) { ?>
		background: url('../images/interface/dark_download.png') no-repeat;
		background-position: 0 9px;		
		color: #4e4e4e;
		<?php } else { ?>
		background: url('../images/interface/light_download.png') no-repeat;
		background-position: 0 9px;
		color: #d9d9d9;
		<?php } ?>
	}

	#seriesengine ul.enmse-player-options li.enmse-share-this a, #seriesengine ul.enmse-player-options li.enmse-hide-share-this a {
		display: block;
		width: 43px;
		height: 30px;
		line-height: 30px;
		text-decoration: none;
		text-align: left;
		padding: 0 0 0 17px;
		<?php if ( $enmse_playeroptions == "dark" ) { ?>
		color: #4e4e4e;
		background: url('../images/interface/dark_share.png') no-repeat;
		background-position: 0 9px;
		<?php } else { ?>
		color: #d9d9d9;
		background: url('../images/interface/light_share.png') no-repeat;
		background-position: 0 9px;	
		<?php } ?>
	}

	#seriesengine .enmse-player .enmse-player-details {
		padding: 0 0 10px 0;
	}

	#seriesengine .enmse-player .enmse-player-extras {
		padding: 0 0 10px 0;
	}

	/* ----- Share Options ----- */

	#seriesengine .enmse-share-details {
		padding: 0 8px 0 8px;
		margin: 0 14px 0 14px;
		height: 42px;
		line-height: 0;
		text-align: center;
	}

	#seriesengine .enmse-share-details ul {
		width: 186px;
		text-align: center;
		margin: 12px auto 8px auto;
	}

	#seriesengine .enmse-share-details ul li:first-child {
		list-style-type: none;
		display: inline-block;
		font-size: 12px !important;
		margin: 0;
		width: 39px;
		float: left;
	}

	#seriesengine .enmse-share-details ul li {
		list-style-type: none;
		display: inline-block;
		font-size: 12px !important;
		margin: 0 0 0 10px;
		width: 39px;
		float: left;
	}

	#seriesengine .enmse-share-details ul li.enmse-email {
		margin: 0 0 0 10px;
	}

	#seriesengine .enmse-share-details ul li a {
		width: 39px;
		height: 26px;
		line-height: 26px;
		padding: 0;
		border-radius: 13px;
		-moz-border-radius: 13px;
		color: #<?php echo $enmse_sharebuttontext; ?>;
	}

	#seriesengine .enmse-share-details ul li a span {
		display: none;
	}

	#seriesengine .enmse-share-details ul li.enmse-facebook a {
		<?php if ( $enmse_shareoptions == "light" ) { ?>
		background: url('../images/interface/se_facebook_light.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/se_facebook_dark.png') no-repeat;
		<?php } ?>
		<?php if ( $enmse_font == "verdana" ) { 
			echo "background-position: 6px 6px;";
		} else {
			echo "background-position: 8px 6px;";
		}; ?>
		background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
	}

	#seriesengine .enmse-share-details ul li.enmse-twitter a {
		<?php if ( $enmse_shareoptions == "light" ) { ?>
		background: url('../images/interface/se_twitter_light.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/se_twitter_dark.png') no-repeat;
		<?php } ?>
		<?php if ( $enmse_font == "verdana" ) { 
			echo "background-position: 6px 6px;";
		} else {
			echo "background-position: 8px 6px;";
		}; ?>
		background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
	}

	#seriesengine .enmse-share-details ul li.enmse-share-link a {
		<?php if ( $enmse_shareoptions == "light" ) { ?>
		background: url('../images/interface/se_link_light.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/se_link_dark.png') no-repeat;
		<?php } ?>
		<?php if ( $enmse_font == "verdana" ) { 
			echo "background-position: 6px 6px;";
		} else {
			echo "background-position: 8px 6px;";
		}; ?>
		background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
	}

	#seriesengine .enmse-share-details ul li.enmse-email a {
		<?php if ( $enmse_shareoptions == "light" ) { ?>
		background: url('../images/interface/se_env_light.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/se_env_dark.png') no-repeat;
		<?php } ?>
		<?php if ( $enmse_font == "verdana" ) { 
			echo "background-position: 6px 6px;";
		} else {
			echo "background-position: 8px 6px;";
		}; ?>
		background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
	}
	
	#seriesengine .enmse-media-container {
		width: inherit;
	}
	
	#seriesengine h3.enmse-poweredby {
		margin: 10px auto 10px auto;
		float: none;
	}
	
	#seriesengine p.enmse-poweredbytext {
		margin: 10px 0 10px 0;
		float: none;
	}
	
	#seriesengine h3.enmse-more-title {
		color: #<?php echo $enmse_comptitletext; ?>;
		font-size: inherit;
	}
	
	#seriesengine table.enmse-more-messages {
		width: 100%;
		margin: 10px 0 0 0;
	}
	
	#seriesengine table.enmse-more-messages td.enmse-title-cell {
		color: #<?php echo $enmse_comprowtitletext; ?>;
		font-size: 13px !important;
		font-weight: 700;
		text-align: left;
		padding: 7px 7px 7px 12px;
	}
	
	#seriesengine table.enmse-more-messages td.enmse-date-cell {
		display: none;
	}
	
	#seriesengine table.enmse-more-messages td.enmse-alternate-cell, #seriesengine table.enmse-more-messages td.enmse-watch-cell {
		font-size: 13px !important;
		font-weight: 300;
		width: auto;
		text-align: center;
		padding: 7px 7px 7px 0;
	}
	
	#seriesengine table.enmse-more-messages td.enmse-listen-cell {
		font-size: 13px !important;
		font-weight: 300;
		width: auto;
		text-align: center;
		padding: 7px 12px 7px 0;
	}

	#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb {
		display: block;
		width: 95%;
		padding: 10px;
		margin: 0 0 8px 0;
	}

	#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb h4 {
		font-size: 17px !important;
	}

	#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb h5 {
		font-size: 17px !important;
	}

	#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb p {
		font-size: 17px !important;
	}

	#seriesengine #enmse-archive-thumbnails .enmse-archive-thumb p.enmse-archive-link {
		font-size: 17px !important;
	}

	#seriesengine .enmse-audio a#enmse-download {
		display: none;
	}

	#seriesengine .enmse-audio .mejs__container {
		width: 92% !important;
	}

	#seriesengine .mejs__video .mejs__controls {
		display: none;
	}
}

@media 
(-webkit-min-device-pixel-ratio: 2) and (max-width: 700px) {

	#seriesengine ul.enmse-player-options li.enmse-share-this a, #seriesengine ul.enmse-player-options li.enmse-hide-share-this a {
		<?php if ( $enmse_playeroptions == "dark" ) { ?>
		color: #4e4e4e;
		background: url('../images/interface/dark_share2x.png') no-repeat;
		background-size: 13px 12px;
		background-position: 0 9px;
		<?php } else { ?>
		color: #d9d9d9;
		background: url('../images/interface/light_share2x.png') no-repeat;
		background-size: 13px 12px;
		background-position: 0 9px;	
		<?php } ?>
	}

	#seriesengine ul.enmse-player-options li.enmse-extras a {
		<?php if ( $enmse_playeroptions == "dark" ) { ?>
		background: url('../images/interface/dark_download2x.png') no-repeat;
		background-size: 11px 11px;
		background-position: 0 9px;		
		color: #4e4e4e;
		<?php } else { ?>
		background: url('../images/interface/light_download2x.png') no-repeat;
		background-size: 11px 11px;
		background-position: 0 9px;
		color: #d9d9d9;
		<?php } ?>
	}

	#seriesengine ul.enmse-player-options li.enmse-details a.enmse-hide-details {
		<?php if ( $enmse_playeroptions == "dark" ) { ?>
		background: url('../images/interface/dark_up2x.png') no-repeat;
		background-size: 11px 11px;
		background-position: 0 9px;		
		color: #4e4e4e;
		<?php } else { ?>
		background: url('../images/interface/light_up2x.png') no-repeat;
		background-size: 11px 11px;
		background-position: 0 9px;
		color: #d9d9d9;
		<?php } ?>
	}

	#seriesengine ul.enmse-player-options li.enmse-details a.enmse-show-details {
		<?php if ( $enmse_playeroptions == "dark" ) { ?>
		background: url('../images/interface/dark_down2x.png') no-repeat;
		background-size: 11px 11px;
		background-position: 0 9px;		
		color: #4e4e4e;
		<?php } else { ?>
		background: url('../images/interface/light_down2x.png') no-repeat;
		background-size: 11px 11px;
		background-position: 0 9px;		
		color: #d9d9d9;
		<?php } ?>
	}

	#seriesengine .enmse-share-details ul li.enmse-email a {
		<?php if ( $enmse_shareoptions == "light" ) { ?>
		background: url('../images/interface/se_env_light2x.png') no-repeat;
		background-size: 13px 13px;
		<?php } else { ?>
		background: url('../images/interface/se_env_dark2x.png') no-repeat;
		background-size: 13px 13px;
		<?php } ?>
		background-position: center center;
		background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
	}

	#seriesengine .enmse-share-details ul li.enmse-share-link a {
		<?php if ( $enmse_shareoptions == "light" ) { ?>
		background: url('../images/interface/se_link_light2x.png') no-repeat;
		background-size: 13px 13px;
		<?php } else { ?>
		background: url('../images/interface/se_link_dark2x.png') no-repeat;
		background-size: 13px 13px;
		<?php } ?>
		background-position: center center;
		background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
	}

	#seriesengine .enmse-share-details ul li.enmse-twitter a {
		<?php if ( $enmse_shareoptions == "light" ) { ?>
		background: url('../images/interface/se_twitter_light2x.png') no-repeat;
		background-size: 13px 13px;
		<?php } else { ?>
		background: url('../images/interface/se_twitter_dark2x.png') no-repeat;
		background-size: 13px 13px;
		<?php } ?>
		background-position: center center;
		background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
	}

	#seriesengine .enmse-share-details ul li.enmse-facebook a {
		<?php if ( $enmse_shareoptions == "light" ) { ?>
		background: url('../images/interface/se_facebook_light2x.png') no-repeat;
		background-size: 13px 13px;
		<?php } else { ?>
		background: url('../images/interface/se_facebook_dark2x.png') no-repeat;
		background-size: 13px 13px;
		<?php } ?>
		background-position: center center;
		background-color: #<?php echo $enmse_sharebuttonbackground; ?>;
	}

	#seriesengine h3.enmse-poweredby {
		<?php if ( $enmse_poweredby == "light" ) { ?>
		background: url('../images/interface/se_light_poweredby2x.png') no-repeat;
		background-size: 148px 40px;	
		<?php } elseif ( $enmse_poweredby == "dark" ) { ?>
		background: url('../images/interface/se_dark_poweredby2x.png') no-repeat;
		background-size: 148px 40px;
		<?php } ?>
	}

	#seriesengine .enmse-loading-icon {
		<?php if ( $enmse_loadingicon == "light" ) { ?>
		background: url('../images/interface/light_load2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_load2x.png') no-repeat;
		<?php } ?>
		background-size: 54px 55px;
		background-position: center 30px;
		background-color: #<?php echo $enmse_loadingbackground; ?>;
	}
}