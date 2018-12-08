<?php header("Content-type: text/css"); 

require_once '../../../../wp-load.php'; // ADJUST THIS PATH if using a non-standard WordPress install
$enmge_options = get_option( 'enm_groupsengine_options' );
$explorerbg = $enmge_options['explorerbg'];
$exploreactionbg = $enmge_options['exploreactionbg'];
$exploreactiontext = $enmge_options['exploreactiontext'];
$exploreactionicon = $enmge_options['exploreactionicon'];
$explorebuttonbg = $enmge_options['explorebuttonbg'];
$explorebuttonbgroll = $enmge_options['explorebuttonbgroll'];
$explorebuttontext = $enmge_options['explorebuttontext'];
$explorebuttonicon = $enmge_options['explorebuttonicon'];
$filterbg = $enmge_options['filterbg'];
$filtertext = $enmge_options['filtertext'];
$filterfieldbg = $enmge_options['filterfieldbg'];
$filterfieldborder = $enmge_options['filterfieldborder'];
$filterfieldtext = $enmge_options['filterfieldtext'];
$filtersubmitbg = $enmge_options['filtersubmitbg'];
$filtersubmittext = $enmge_options['filtersubmittext'];
$grouplistheadertext = $enmge_options['grouplistheadertext'];
$grouplisttext = $enmge_options['grouplisttext'];
$grouplistlink = $enmge_options['grouplistlink'];
$grouplistrow = $enmge_options['grouplistrow'];
$pagebuttonbg = $enmge_options['pagebuttonbg'];
$pagebuttontext = $enmge_options['pagebuttontext'];
$pagenumber = $enmge_options['pagenumber'];
$pagenumberselectedbg = $enmge_options['pagenumberselectedbg'];
$pagenumberselectedtext = $enmge_options['pagenumberselectedtext'];
$singletitle = $enmge_options['singletitle'];
$singledetails = $enmge_options['singledetails'];
$singledetailsbg = $enmge_options['singledetailsbg'];
$singledetailstext = $enmge_options['singledetailstext'];
$singledetailslink = $enmge_options['singledetailslink'];
$singledetailslabel = $enmge_options['singledetailslabel'];
$singledetailssharebg = $enmge_options['singledetailssharebg'];
$singledetailssharebgroll = $enmge_options['singledetailssharebgroll'];
$singledetailssharetext = $enmge_options['singledetailssharetext'];
$singledetailsshareicon = $enmge_options['singledetailsshareicon'];
$relatedbg = $enmge_options['relatedbg'];
$relatedtext = $enmge_options['relatedtext'];
$relatedlink = $enmge_options['relatedlink'];
$contacttitle = $enmge_options['contacttitle'];
$contactinstructionstext = $enmge_options['contactinstructionstext'];
$contactformlabel = $enmge_options['contactformlabel'];
$contactformfieldbg = $enmge_options['contactformfieldbg'];
$contactformfieldtext = $enmge_options['contactformfieldtext'];
$contactformsubmitbg = $enmge_options['contactformsubmitbg'];
$contactformsubmittext = $enmge_options['contactformsubmittext'];
$errorbg = $enmge_options['errorbg'];
$errortext = $enmge_options['errortext'];
$successbg = $enmge_options['successbg'];
$successtext = $enmge_options['successtext'];
$shareboxbg = $enmge_options['shareboxbg'];
$shareboxtext = $enmge_options['shareboxtext'];
$shareboxbuttonbg = $enmge_options['shareboxbuttonbg'];
$shareboxbuttontext = $enmge_options['shareboxbuttontext'];
$loadingbg = $enmge_options['loadingbg'];
$loadingtext = $enmge_options['loadingtext'];
$loadingicon = $enmge_options['loadingicon'];
$customloading = $enmge_options['customloading'];
$customloadingretina = $enmge_options['customloadingretina'];
$creditstext = $enmge_options['creditstext'];
$credits = $enmge_options['credits'];

$enmge_grouptitle = $enmge_options['grouptitle'];
$enmge_groupptitle = $enmge_options['groupptitle']; 
$enmge_grouptypetitle = $enmge_options['grouptypetitle'];
$enmge_grouptypeptitle = $enmge_options['grouptypeptitle'];
$enmge_locationtitle = $enmge_options['locationtitle'];
$enmge_locationptitle = $enmge_options['locationptitle'];
$enmge_topictitle = $enmge_options['topictitle'];

$enmge_searchwidth = $enmge_options['searchwidth'];
$enmge_backsearchwidth = $enmge_options['backsearchwidth'];
$enmge_contactwidth = $enmge_options['contactwidth'];
$enmge_backgroupwidth = $enmge_options['backgroupwidth'];
$enmge_imagewidth = $enmge_options['imagewidth'];

$enmge_showday = $enmge_options['showday'];
$enmge_showtime = $enmge_options['showtime'];
$enmge_showages = $enmge_options['showages'];
$enmge_showlocations = $enmge_options['showlocations'];
$enmge_showlocation = $enmge_options['showlocation'];
$enmge_showtopic = $enmge_options['showtopic'];
$enmge_showchildcare = $enmge_options['showchildcare'];
$enmge_showstatus = $enmge_options['showstatus'];

$enmge_searchheight = $enmge_options['groupsearchmap'];
$enmge_singleheight = $enmge_options['singlegroupmap'];

?>
/* ----- Groups Engine ----- */

#groupsengine {
	margin: 0 auto;
	padding: 0%;
	width: 100;
	position: relative;
}

#groupsengine * {
	-webkit-box-sizing: content-box !important;
	-moz-box-sizing:    content-box !important;
	box-sizing:         content-box !important;
}

#groupsengine h1, #groupsengine h2, #groupsengine h3, #groupsengine h4, #groupsengine h5, #groupsengine h6, #groupsengine p, #groupsengine form, #groupsengine ul, #groupsengine ol, #groupsengine li, #groupsengine ol li, #groupsengine ul li, #groupsengine blockquote, #groupsengine input, #groupsengine input[type="submit"], #groupsengine textarea, #groupsengine select, #groupsengine select:focus, #groupsengine label, #groupsengine table, #groupsengine table tr, #groupsengine table tr td, #groupsengine table tr th, #groupsengine iframe, #groupsengine object, #groupsengine embed, #groupsengine img { /* resets most browser styles to enhance cross-browser compatibility */
	margin: 0;
	padding: 0;
	font-size: 1em !important;
	text-transform: none;
	letter-spacing: 0;
	line-height: 1;
	clear: none;
	font-weight: 300;
	font-family: Arial, Helvetica, sans-serif !important;
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
	text-indent: 0;
	box-shadow: none;
	text-shadow: none !important;
	font-style: normal !important;
}

#main #groupsengine table, #main #groupsengine table tr, #main #groupsengine table tr td {
	border: none;
	-moz-border-radius: 0;
	-webkit-border-radius: 0;
	border-radius: 0;
}

#groupsengine br {
	line-height: 0;
}

#groupsengine iframe, #groupsengine object, #groupsengine embed {
	width: 100%;
}

#groupsengine ul li:before {
	content: normal;
}

#groupsengine form div {
	margin: 0 !important;
}

#groupsengine a {
	font-family: Arial, Helvetica, sans-serif !important;
	text-transform: none;
}

#groupsengine a:link {color: #<?php echo $grouplistlink; ?>; text-decoration: underline; font-weight: 300; border: none; background: none;}
#groupsengine a:visited {color: #<?php echo $grouplistlink; ?>; text-decoration: underline; font-weight: 300; border: none; background: none;}
#groupsengine a:hover {color: #<?php echo $grouplistlink; ?>; text-decoration: none; font-weight: 300; border: none; background: none;}
#groupsengine a:active {color: #<?php echo $grouplistlink; ?>; text-decoration: underline; font-weight: 300; border: none; background: none;}

#groupsengine img { max-width: none !important; } /* Google Maps Fixes */
#groupsengine label { width: auto; display: inline; }
.entry-content #groupsengine img, #groupsengine img.wp-post-image {
	border-radius: 0;
	box-shadow: none;
}

.gm-style img { max-width: none !important; }
.gm-style label { width: auto; display: inline; }

#groupsengine img.ge-image {
	float: right;
	margin: 0 0 15px 15px;
}

/* ----- Explore Bar/Navigation ----- */

#groupsengine .ge-explore-bar {
	background-color: #<?php echo $explorerbg; ?>;
	height: 40px;
	padding: 10px;
}

#groupsengine .ge-explore-bar h4.ge-view-toggle {
	margin: 0;
	padding: 0;
	position: relative;
}

#groupsengine .ge-explore-bar h4.ge-view-toggle a {
	display: block;
	width: 106px;
	padding: 0 0 0 40px;
	height: 40px;
	border-radius: 20px;
	background-color: #<?php echo $explorebuttonbg; ?>;
	float: right;
	text-decoration: none;
	line-height: 40px;
	text-transform: uppercase;
	color: #<?php echo $explorebuttontext; ?>;
	font-size: 14px !important;
}

#groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-map-toggle:link, #groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-map-toggle:visited {
	<?php if ( $explorebuttonicon == "light" ) { ?>
	background: url('../images/interface/light_map.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_map.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $explorebuttonbg; ?>;
	background-size: 18px 18px;
	background-position: 14px 10px;
}

#groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-map-toggle:hover, #groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-map-toggle:active {
	<?php if ( $explorebuttonicon == "light" ) { ?>
	background: url('../images/interface/light_map.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_map.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $explorebuttonbgroll; ?>;
	background-size: 18px 18px;
	background-position: 14px 10px;
}

#groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-list-toggle:link, #groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-list-toggle:visited {
	<?php if ( $explorebuttonicon == "light" ) { ?>
	background: url('../images/interface/light_list.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_list.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $explorebuttonbg; ?>;
	background-size: 18px 18px;
	background-position: 14px 11px;
}

#groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-list-toggle:hover, #groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-list-toggle:active {
	<?php if ( $explorebuttonicon == "light" ) { ?>
	background: url('../images/interface/light_list.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_list.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $explorebuttonbgroll; ?>;
	background-size: 18px 18px;
	background-position: 14px 11px;
}

#groupsengine .ge-explore-bar h4.ge-explore-toggle {
	margin: 0;
	padding: 0;
	position: absolute;
}

#groupsengine .ge-explore-bar h4.ge-explore-toggle a {
	display: block;
	width: <?php echo $enmge_searchwidth; ?>px;
	padding: 0 0 0 35px;
	height: 40px;
	border-radius: 20px;
	<?php if ( $exploreactionicon == "light" ) { ?>
	background: url('../images/interface/light_search.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_search.png') no-repeat;
	<?php } ?>
	background-size: 18px 18px;
	background-position: 10px 11px;
	background-color: #<?php echo $exploreactionbg; ?>;
	float: left;
	text-decoration: none;
	line-height: 40px;
	text-transform: uppercase;
	color: #<?php echo $exploreactiontext; ?>;
	font-size: 14px !important;
}

#groupsengine .ge-explore-bar h4.ge-explore-back, #groupsengine .ge-explore-bar h4.ge-explore-contact-back {
	margin: 0;
	padding: 0;
	position: absolute;
}

#groupsengine .ge-explore-bar h4.ge-explore-back a {
	display: block;
	width: <?php echo $enmge_backsearchwidth; ?>px;
	padding: 0 0 0 35px;
	height: 40px;
	border-radius: 20px;
	<?php if ( $explorebuttonicon == "light" ) { ?>
	background: url('../images/interface/light_back.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_back.png') no-repeat;
	<?php } ?>
	background-size: 18px 18px;
	background-position: 10px 11px;
	background-color: #<?php echo $explorebuttonbg; ?>;
	float: left;
	text-decoration: none;
	line-height: 40px;
	text-transform: uppercase;
	color: #<?php echo $explorebuttontext; ?>;
	font-size: 14px !important;
}

#groupsengine .ge-explore-bar h4.ge-explore-contact-back a {
	display: block;
	width: <?php echo $enmge_backgroupwidth; ?>px;
	padding: 0 0 0 35px;
	height: 40px;
	border-radius: 20px;
	<?php if ( $explorebuttonicon == "light" ) { ?>
	background: url('../images/interface/light_back.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_back.png') no-repeat;
	<?php } ?>
	background-size: 18px 18px;
	background-position: 10px 11px;
	background-color: #<?php echo $explorebuttonbg; ?>;
	float: left;
	text-decoration: none;
	line-height: 40px;
	text-transform: uppercase;
	color: #<?php echo $explorebuttontext; ?>;
	font-size: 14px !important;
}

#groupsengine .ge-explore-bar h4.ge-contact-leader { 
	margin: 0;
	padding: 0 !important;
}

#groupsengine .ge-explore-bar h4.ge-contact-leader a {
	display: block;
	width: <?php echo $enmge_contactwidth; ?>px;
	padding: 0 0 0 38px;
	height: 40px;
	border-radius: 20px;
	float: right;
	text-decoration: none;
	line-height: 40px;
	text-transform: uppercase;
	color: #<?php echo $exploreactiontext; ?>;
	<?php if ( $exploreactionicon == "light" ) { ?>
	background: url('../images/interface/light_contact.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_contact.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $exploreactionbg; ?>;
	background-size: 18px 18px;
	background-position: 10px 10px;
	font-size: 14px !important;
}


/* ----- Filter Options ----- */

#groupsengine .ge-explore-options {
	background-color: #<?php echo $filterbg; ?>;
}

#groupsengine .ge-explore-options form {
	padding: 15px 0 15px 0;
}

#groupsengine .ge-explore-options .ge-option-container {
	width: 47%;
	float: left;
	padding: 10px;
}

#groupsengine .ge-explore-options span.ge-filter-label {
	min-width: 88px;
	width: 20%;
	font-weight: 700;
	font-size: 14px !important;
	display: inline-block;
	text-align: right;
	padding: 0 10px 0 0;
	margin: 0 important!;
	color: #<?php echo $filtertext; ?>;
}

#groupsengine .ge-explore-options input.ge-zip {
	border: 1px solid #<?php echo $filterfieldborder; ?>;
	width: 68%;	
	background-color: #<?php echo $filterfieldbg; ?>;
	padding: 5px;
	margin: 0;
	color: #<?php echo $filterfieldtext; ?>
	font-size: 14px !important;
	-webkit-appearance: none;
}

#groupsengine .ge-explore-options input.ge-zip:focus {
	outline: none; 
}

#groupsengine .ge-explore-options select {
	border: 1px solid #<?php echo $filterfieldborder; ?>;
	background-color: #<?php echo $filterfieldbg; ?>;
	color: #<?php echo $filterfieldtext; ?>;
	display: inline;
	width: 72%;
	font-size: 14px !important;
	margin: 0 !important;
	/*width: 31%;
	font-size: 13px !important;
	vertical-align: middle;
	height: 20px;
	*/	
}

#groupsengine .ge-explore-options select:focus {
	outline: none; 
}

#groupsengine .ge-explore-options select.time {
	border: 1px solid #<?php echo $filterfieldborder; ?>;
	background-color: #<?php echo $filterfieldbg; ?>;
	color: #<?php echo $filterfieldtext; ?>;
	display: inline;
	width: 32%;
	font-size: 14px !important;
	/*width: 31%;
	font-size: 13px !important;
	vertical-align: middle;
	height: 20px;
	*/	
}

#groupsengine .ge-explore-options select.time:focus {
	outline: none; 
}

#groupsengine .ge-explore-options input.ge-filter-submit {
	display: block;
	width: 20%;
	height: 30px;
	line-height: 30px;
	background-color: #<?php echo $filtersubmitbg; ?>;
	color: #<?php echo $filtersubmittext; ?>;
	text-align: center;
	text-transform: uppercase;
	margin: 0 auto;
	border-radius: 15px;
	font-size: 14px !important;
	-webkit-appearance: none;
	cursor: pointer;
}

#groupsengine .ge-explore-options .ge-submit-padding {
	clear: both;
	padding: 10px 0 0 0;
}

#groupsengine .deskhide {
	display: none;
}

#groupsengine .ge-explore-options.ge-small .ge-option-container {
	width: 100%;
	float: none;
}

#groupsengine .ge-explore-options.ge-small select {
	width: 64%;
	font-size: 16px; !important
	-webkit-appearance: none;
	font-size: 50px;
	height: 22px;
}

#groupsengine .ge-explore-options.ge-small select.time {
	width: 30%;
	height: 22px;
}

#groupsengine .ge-explore-options.ge-small input.ge-zip {
	width: 61%;	
	font-size: 16px !important;
	-webkit-appearance: none;
}

#groupsengine .ge-explore-options.ge-small input.ge-filter-submit {
	width: 60%;
	-webkit-appearance: none;
}

#groupsengine .ge-explore-options.ge-medium .ge-option-container {
	width: 46%;
	float: left;
	padding: 10px;
}

#groupsengine .ge-explore-options.ge-medium select {
	width: 62%;
}

#groupsengine .ge-explore-options.ge-medium select.time {
	width: 28%;
}

#groupsengine .ge-explore-options.ge-medium input.ge-zip {
	width: 56%;	
}

/* ----- Table Listing of Groups ----- */

#groupsengine p.nogroups {
	padding: 30px 20px 20px 20px;
	text-align: center;
	font-size: 18px !important;
	color: #<?php echo $grouplistheadertext; ?>;
	font-style: italic !important;
}

#groupsengine .ge-groups-table {
	width: 100%;
	border: none;
	margin: 0 0 10px 0;
}

#groupsengine .ge-groups-table tr.ge-odd {
	background-color: #<?php echo $grouplistrow; ?>;
}

#groupsengine .ge-groups-table th {
	border: none;
	text-align: left;
	font-weight: 700;
	text-transform: none;
	font-size: 15px !important;
	padding: 18px 10px 10px 10px;
	color: #<?php echo $grouplistheadertext; ?>;
}

#groupsengine .ge-groups-table td {
	border: none;
	padding: 15px 10px 15px 10px;
	font-size: 14px !important;
	color: #<?php echo $grouplisttext; ?>;
}

<?php if ( $enmge_showday != 1 ) { ?>
#groupsengine .ge-groups-table td.ge-group-day, #groupsengine .ge-groups-table th.ge-group-day {
	display: none;
}
<?php } ?>

<?php if ( $enmge_showtime != 1 ) { ?>
#groupsengine .ge-groups-table td.ge-group-time, #groupsengine .ge-groups-table th.ge-group-time {
	display: none;
}
<?php } ?>

<?php if ( $enmge_showages != 1 ) { ?>
#groupsengine .ge-groups-table td.ge-group-ages, #groupsengine .ge-groups-table th.ge-group-ages {
	display: none;
}
<?php } ?>

<?php if ( $enmge_showlocations != 1 ) { ?>
#groupsengine .ge-groups-table td.ge-group-locations, #groupsengine .ge-groups-table th.ge-group-locations {
	display: none;
}
<?php } ?>

<?php if ( $enmge_showlocation != 1 ) { ?>
#groupsengine .ge-groups-table td.ge-group-location, #groupsengine .ge-groups-table th.ge-group-location {
	display: none;
}
<?php } ?>

<?php if ( $enmge_showtopic != 1 ) { ?>
#groupsengine .ge-groups-table td.ge-group-topic, #groupsengine .ge-groups-table th.ge-group-topic {
	display: none;
}
<?php } ?>

<?php if ( $enmge_showchildcare != 1 ) { ?>
#groupsengine .ge-groups-table td.ge-group-childcare, #groupsengine .ge-groups-table th.ge-group-childcare {
	display: none;
}
<?php } ?>

<?php if ( $enmge_showstatus != 1 ) { ?>
#groupsengine .ge-groups-table td.ge-group-status, #groupsengine .ge-groups-table th.ge-group-status {
	display: none;
}
<?php } ?>

/* ----- Map Markers ----- */

#groupsengine .enmge-marker {
	height: 190px;
	color: #000;
}

#groupsengine .enmge-marker p {
	margin: 0;
	padding: 0;
	line-height: 100%;
}

#groupsengine p.enmge-marker-title {
	width: 200px;
	padding: 6px 0 8px 0 !important;
}

#groupsengine p.enmge-marker-title a {
	font-size: 19px !important;
}

#groupsengine p.enmge-marker-ages {
	font-size: 15px !important;
	padding: 0 0 5px 0 !important;
}

#groupsengine p.enmge-marker-topics {
	font-size: 15px !important;
	padding: 0 0 5px 0 !important;
}

#groupsengine p.enmge-marker-status {
	font-size: 15px !important;
	padding: 0 0 5px 0 !important;
}

#groupsengine p.enmge-marker-location {
	font-size: 15px !important;
	padding: 0 0 5px 0 !important;
}

#groupsengine p.enmge-marker-meets {
	font-size: 15px !important;
	padding: 0 !important;
}

/* Individual Group Marker */

#groupsengine .enmge-individual-marker {
	height: 90px;
	color: #000;
}

#groupsengine .enmge-individual-marker p {
	width: 200px;
	margin: 0;
	padding: 0;
	color: #<?php echo $singledetails; ?>;
	line-height: 100%;
}

#groupsengine .enmge-individual-marker p.title {
	display: block;
	font-weight: 700 !important;
	font-size: 15px !important;
	padding: 0 0 6px 0 !important;
}

#groupsengine .enmge-individual-marker p.address {
	display: block;
	padding: 0 0 6px 0 !important;
}

/* ----- Single Group ----- */

#groupsengine .ge-single-group {
	padding: 0 0 15px 0;
}

#groupsengine .ge-single-group h3 {
	font-size: 38px !important;
	padding: 15px 0 15px 0;
	color: #<?php echo $singletitle; ?>
}

#groupsengine .ge-single-group .ge-group-description {
	margin: 0 0 15px 0;
}

#groupsengine .ge-single-group .ge-group-description p {
	font-size: 14px !important;
	line-height: 140%;
	color: #<?php echo $singledetails; ?>;
}

#groupsengine .ge-single-group .ge-group-related {
	padding: 12px;
	background-color: #<?php echo $relatedbg; ?>;
	margin: 0;
}

#groupsengine .ge-single-group .ge-group-related p {
	text-align: center;
	color: #<?php echo $relatedtext; ?>;
	font-size: 14px !important;
}

#groupsengine .ge-single-group .ge-group-related p a {
	color: #<?php echo $relatedlink; ?>;
}

#groupsengine .ge-single-group .ge-social {
	background-color: #<?php echo $singledetailsbg; ?>;
	height: 30px;
	padding: 10px;
	clear: right;
}

#groupsengine .ge-single-group .ge-social.ge-small {
	padding: 10px 0 10px 0;
}

#groupsengine .ge-single-group .ge-social ul {
	width: 510px;
	margin: 0 auto;
}

#groupsengine .ge-single-group .ge-social.ge-small ul {
	width: 450px;
}

#groupsengine .ge-single-group .ge-social ul li {
	list-style-type: none;
	float: left;
	margin: 0 0 0 10px;
	font-size: 14px !important;
}

#groupsengine .ge-single-group .ge-social.ge-small ul li {
	margin: 0 0 0 7px;
	font-size: 12px !important;
}

#groupsengine .ge-single-group .ge-social ul li:first-child {
	list-style-type: none;
	float: left;
	margin: 0;
}

#groupsengine .ge-single-group .ge-social a:link, #groupsengine .ge-single-group .ge-social a:visited {
	display: block;
	width: 88px;
	height: 30px;
	padding: 0 0 0 32px;
	line-height: 30px;
	background-color: #<?php echo $singledetailssharebg; ?>;
	color: #<?php echo $singledetailssharetext; ?>;
	border-radius: 15px;
	text-align: left;
	text-decoration: none;
	text-transform: uppercase;
}

#groupsengine .ge-single-group .ge-social a:hover, #groupsengine .ge-single-group .ge-social a:active {
	display: block;
	width: 88px;
	height: 30px;
	padding: 0 0 0 32px;
	line-height: 30px;
	background-color: #<?php echo $singledetailssharebg; ?>;
	color: #<?php echo $singledetailssharetext; ?>;
	border-radius: 15px;
	text-align: left;
	text-decoration: none;
	text-transform: uppercase;
}

#groupsengine .ge-single-group .ge-social.ge-small a:link, #groupsengine .ge-single-group .ge-social.ge-small a:visited {
	width: 75px;
}

#groupsengine .ge-single-group .ge-social.ge-small a:hover, #groupsengine .ge-single-group .ge-social.ge-small a:active {
	width: 75px;
}


#groupsengine .ge-single-group .ge-social .ge-facebook a:link, #groupsengine .ge-single-group .ge-social .ge-facebook a:visited {
	<?php if ( $singledetailsshareicon == "light" ) { ?>
	background: url('../images/interface/light_facebook.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_facebook.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $singledetailssharebg; ?>;
	background-position: 12px 7px;
}

#groupsengine .ge-single-group .ge-social .ge-facebook a:hover, #groupsengine .ge-single-group .ge-social .ge-facebook a:active {
	<?php if ( $singledetailsshareicon == "light" ) { ?>
	background: url('../images/interface/light_facebook.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_facebook.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $singledetailssharebg; ?>;
	background-position: 12px 7px;
}

#groupsengine .ge-single-group .ge-social .ge-twitter a:link, #groupsengine .ge-single-group .ge-social .ge-twitter a:visited {
	<?php if ( $singledetailsshareicon == "light" ) { ?>
	background: url('../images/interface/light_twitter.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_twitter.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $singledetailssharebg; ?>;
	background-position: 12px 7px;
}

#groupsengine .ge-single-group .ge-social .ge-twitter a:hover, #groupsengine .ge-single-group .ge-social .ge-twitter a:active {
	<?php if ( $singledetailsshareicon == "light" ) { ?>
	background: url('../images/interface/light_twitter.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_twitter.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $singledetailssharebg; ?>;
	background-position: 12px 7px;
}

#groupsengine .ge-single-group .ge-social .ge-share a:link, #groupsengine .ge-single-group .ge-social .ge-share a:visited {
	<?php if ( $singledetailsshareicon == "light" ) { ?>
	background: url('../images/interface/light_link.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_link.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $singledetailssharebg; ?>;
	background-position: 12px 7px;
}

#groupsengine .ge-single-group .ge-social .ge-share a:hover, #groupsengine .ge-single-group .ge-social .ge-share a:active {
	<?php if ( $singledetailsshareicon == "light" ) { ?>
	background: url('../images/interface/light_link.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_link.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $singledetailssharebg; ?>;
	background-position: 12px 7px;
}

#groupsengine .ge-single-group .ge-social .ge-email a:link, #groupsengine .ge-single-group .ge-social .ge-email a:visited {
	<?php if ( $singledetailsshareicon == "light" ) { ?>
	background: url('../images/interface/light_email.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_email.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $singledetailssharebg; ?>;
	background-position: 12px 7px;
}

#groupsengine .ge-single-group .ge-social .ge-email a:hover, #groupsengine .ge-single-group .ge-social .ge-email a:active {
	<?php if ( $singledetailsshareicon == "light" ) { ?>
	background: url('../images/interface/light_email.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/dark_email.png') no-repeat;
	<?php } ?>
	background-color: #<?php echo $singledetailssharebg; ?>;
	background-position: 12px 7px;
}

#groupsengine table.ge-detailstable {
	width: 100%;
	background-color: #<?php echo $singledetailsbg; ?>;
	color: #<?php echo $singledetailstext; ?>;
}

#groupsengine table.ge-detailstable a {
	color: #<?php echo $singledetailslink; ?>;
}

#groupsengine .ge-single-group td.ge-group-details {
	padding: 12px;
	font-size: 14px !important;
}

#groupsengine table.ge-detailstable td {
	color: #<?php echo $singledetailstext; ?>;
}

#groupsengine table.ge-detailstable .ge-top td {
	padding: 20px 12px 12px 12px !important;
}

#groupsengine table.ge-detailstable .ge-bottom td {
	padding: 12px 12px 20px 12px !important;
}

#groupsengine table.ge-detailstable td.left {
	padding-left: 20px !important;
}

#groupsengine table.ge-detailstable td.right {
	padding-right: 20px !important;
}

#groupsengine span.ge-label {
	font-weight: 700;
	color: #<?php echo $singledetailslabel; ?>;
}

#groupsengine #ge-map-canvas {
	width: 100%; 
	height: <?php echo $enmge_singleheight ?>px;
	margin: 0;
}

#groupsengine #ge-big-map-canvas {
	width: 100%; 
	height: <?php echo $enmge_searchheight ?>px; 
	margin: 0 0 10px 0;
}

#groupsengine #ge-big-map-canvas .gm-style-cc > div { word-wrap: normal; }

#groupsengine #ge-map-canvas .gm-style-cc > div { word-wrap: normal; }

/* ----- Contact Group Leader ----- */

#groupsengine .ge-leader-contact {
	padding: 15px 0 15px 0;
}

#groupsengine .ge-leader-contact h3 {
	font-size: 38px !important;
	padding: 5px 0 15px 0;
	color: #<?php echo $contacttitle; ?>;
}

#groupsengine .ge-leader-contact .ge-instructions {
	margin: 0 0 15px 0;
	color: #<?php echo $contactinstructionstext; ?> !important;
}

body #groupsengine .ge-leader-contact .ge-instructions p {
	font-size: 14px !important;
	line-height: 140%;
	color: #<?php echo $contactinstructionstext; ?> !important;
}

#groupsengine .ge-leader-contact .ge-error-message {
	padding: 15px;
	background-color: #<?php echo $errorbg; ?>;
	font-size: 1.1em;
	line-height: 140%;
	margin: 0 0 15px 0;
}

#groupsengine .ge-leader-contact .ge-error-message p {
	font-size: 15px !important;
	line-height: 140%;
	padding: 0 0 10px 0;
	color: #<?php echo $errortext; ?>;
}

#groupsengine .ge-leader-contact .ge-error-message ul {
	font-size: 15px !important;
	margin: 0
}

#groupsengine .ge-leader-contact .ge-error-message ul li {
	font-size: 15px !important;
	margin: 0 0 4px 20px;
	color: #<?php echo $errortext; ?>;
}

#groupsengine .ge-single-group .ge-success-message {
	padding: 15px 15px 5px 15px;
	background-color: #<?php echo $successbg; ?>;
	font-size: 14px !important;
	line-height: 140%;
	margin: 0 0 15px 0;
}

#groupsengine .ge-single-group .ge-success-message p {
	font-size: 14px !important;
	line-height: 130%;
	padding: 0 0 10px 0;
	color: #<?php echo $successtext; ?>;
}

#groupsengine form.ge-contact-form {

}

#groupsengine table.ge-leader-contact-form {
	
}

#groupsengine table.ge-leader-contact-form td {
	padding: 5px;
}

#groupsengine table.ge-leader-contact-form td.ge-contact-label {
	padding: 18px 10px 0 0;
	width: 10%;
	vertical-align: top;
	text-align: right;
	font-size: 14px !important;
}

#groupsengine table.ge-leader-contact-form td.ge-contact-label label {
	font-weight: 700;
	font-size: 14px !important;
	color: #<?php echo $contactformlabel; ?>
}

#groupsengine table.ge-leader-contact-form td.ge-contact-input {
	padding: 5px;
	width: 90%;
	font-size: 14px !important;
}

#groupsengine table.ge-leader-contact-form input.ge {
	background-color: #<?php echo $contactformfieldbg; ?>;
	font-size: 15px !important;
	padding: 5px 10px 5px 10px;
	height: 30px;
	width: 60%;
	color: #<?php echo $contactformfieldtext; ?>;
}

#groupsengine table.ge-leader-contact-form textarea {
	background-color: #<?php echo $contactformfieldbg; ?>;
	font-size: 15px !important;
	padding: 10px;
	height: 150px;
	width: 95%;
	color: #<?php echo $contactformfieldtext; ?>;
}

#groupsengine table.ge-leader-contact-form input:focus, #groupsengine table.ge-leader-contact-form textarea:focus { 
	outline: none; 
}

#groupsengine .ge-leader-contact input.ge-leader-contact-submit {
	display: block;
	width: 180px;
	height: 40px;
	line-height: 40px;
	background-color: #<?php echo $contactformsubmitbg; ?>;
	color: #<?php echo $contactformsubmittext; ?>;
	text-align: center;
	text-transform: uppercase;
	margin: 0;
	border-radius: 20px;
	font-size: 14px !important;
	-webkit-appearance: none;
}

#groupsengine .ge-leader-contact table tr td.spamcell  { 
	font-size: 15px !important;
	margin: 0;
	padding: 15px 0 15px 5px;
	text-transform: none;
	letter-spacing: 0;
	line-height: 1;
	clear: none;
	font-weight: 300;
	font-family: Arial, Helvetica, sans-serif;
	font-variant: normal;
	float: none;
	border: none;
	-moz-border-radius: 0;
	-webkit-border-radius: 0;
	min-height: 0;
	text-align: left;
	color: #<?php echo $contactformlabel; ?>;
}

/* ----------- reCAPTCHA STYLES ---------- */

#groupsengine #perecaptcha_widget {
	width: 200px;
}

#groupsengine #perecaptcha_widget #recaptcha_image {
	margin: 0 0 10px 0;
	width: 180px !important;
}

#groupsengine #perecaptcha_widget span.recaptcha_only_if_image, #groupsengine #perecaptcha_widget span.recaptcha_only_if_audio {
	font-size: 15px !important;
	display: block;
	margin: 0 0 4px 0;
}

#groupsengine #perecaptcha_widget #recaptcha_response_field {
	width: 170px;
	background-color: #<?php echo $contactformfieldbg; ?>;
	font-size: 15px !important;
	padding: 5px 10px 5px 10px;
	height: 30px;
	color: #<?php echo $contactformfieldtext; ?>;
}

span.perecaptcha_options {
	font-size: 15px !important;
	padding: 6px 0 1px 0;
	font-weight: 700;
	display: block;
}

div.recaptcha_only_if_image a, div.recaptcha_only_if_audio a, div.perecaptcha_link a {
	font-size: 15px !important;
	text-decoration: underline;
	color: #<?php echo $grouplistlink; ?>;
}

#groupsengine .ge-leader-contact table tr td.spamcell iframe {
	width: 180px !important;
}

#recaptcha_image img { width: 180px; } 

.recaptchaajax .recaptcha_only_if_privacy {
	display: none;
}

.recaptchaajax #recaptcha_area {
	width: 200px !important;
}

.recaptchaajax #recaptcha_image {
	margin: 0 0 10px 0;
	width: 180px !important;
}

.recaptchaajax .recaptcha_image_cell center {
	text-align: left;
}

.recaptchaajax input#recaptcha_response_field {
	border: none !important;
	padding: 5px 10px 5px 10px !important;
	width: 170px !important;
	background-color: #<?php echo $contactformfieldbg; ?>;
	color: #<?php echo $contactformfieldtext; ?> !important;
}

.recaptchaajax input#recaptcha_response_field::-webkit-input-placeholder  {
   color: #<?php echo $contactformfieldtext; ?> !important;
}

.recaptchaajax input#recaptcha_response_field:-moz-placeholder  {
   color: #<?php echo $contactformfieldtext; ?> !important;
}

.recaptchaajax input#recaptcha_response_field::-moz-placeholder  {
   color: #<?php echo $contactformfieldtext; ?> !important;
}

.recaptchaajax input#recaptcha_response_field:-ms-input-placeholder  {
   color: #<?php echo $contactformfieldtext; ?> !important;
}

.recaptchaajax #recaptcha_reload_btn, .recaptchaajax #recaptcha_switch_audio_btn, .recaptchaajax #recaptcha_switch_img_btn, .recaptchaajax #recaptcha_whatsthis_btn {
	display: none;
}

.recaptchaajax #recaptcha_table {
	width: 200px !important;
}

.recaptchaajax a.recaptcha-link {
	display: block;
	margin: 10px 0 0 5px;
	font-size: 12px !important;	
}

/* ----- Pagination ----- */

#groupsengine .ge-pagination {
	text-align: center;
	padding: 10px 0 0 0;
	font-family: Arial, Helvetica, San-serif;
}

#groupsengine .page-numbers.current {
	display: inline-block;
	width: 30px;
	height: 30px;
	line-height: 30px;
	text-align: center;
	background-color: #<?php echo $pagenumberselectedbg; ?>;
	text-decoration: none;
	color: #<?php echo $pagenumberselectedtext; ?>;
	border-radius: 15px;
	padding: 0;
	font-size: 14px !important;
}

#groupsengine a.page-numbers {
	display: inline-block;
	width: 30px;
	height: 30px;
	line-height: 30px;
	text-align: center;
	text-decoration: none;
	color: #<?php echo $pagenumber; ?>;
	border-radius: 15px;
	padding: 0;
	font-size: 14px !important;
}

#groupsengine a.page-numbers span {
	display: none;
}

#groupsengine a.page-numbers.wide {
	display: inline-block;
	width: 45px;
	height: 30px;
	line-height: 30px;
	text-align: center;
	text-decoration: none;
	color: #<?php echo $pagenumber; ?>;
	border-radius: 15px;
	padding: 0;
	font-size: 14px !important;
}

#groupsengine .displaying-num {
	display: none;
}

#groupsengine a.next.page-numbers, #groupsengine a.previous.page-numbers {
	display: inline-block;
	width: 30px;
	height: 30px;
	line-height: 30px;
	text-align: center;
	background-color: #<?php echo $pagebuttonbg; ?>;
	text-decoration: none;
	color: #<?php echo $pagebuttontext; ?>;
	border-radius: 15px;
	padding: 0;
	font-size: 14px !important;
}

#groupsengine .ge-pagination.ge-small .page-numbers.current, #groupsengine .ge-pagination.ge-small .page-numbers.number, #groupsengine .ge-pagination.ge-small a.page-numbers.wide {
	display: none;
}

#groupsengine .ge-pagination.ge-small a.next.page-numbers, #groupsengine .ge-pagination.ge-small a.previous.page-numbers {
	display: inline-block;
	width: 70px;
	height: 30px;
	line-height: 30px;
	text-align: center;
	text-decoration: none;
	border-radius: 15px;
	padding: 0;
	text-transform: uppercase;
}

#groupsengine .ge-pagination.ge-small a.page-numbers span {
	display: inline;
}

/* ----- AJAX Loading Indicator ----- */

#groupsengine .enmge-content-container {
	z-index: 5; 
	padding: 15px 0 0 0;
	/*line-height: 0;*/
}

#groupsengine .enmge-content-container.enmge-opaque {
	opacity: 0.2; 
}

#groupsengine .enmge-loading-icon {
	width: 170px;
	height: 96px;
	position: absolute;
	z-index: 100;
	border-radius: 10px;
	<?php if ( $customloading == null ) { ?>
	<?php if ( $loadingicon == "light" ) { ?>
	background: url('../images/interface/ge_light_load.png') no-repeat;
	<?php } else { ?>
	background: url('../images/interface/ge_dark_load.png') no-repeat;
	<?php } ?>
	<?php } else { ?>
	background: url('<?php echo $customloading; ?>') no-repeat;
	<?php } ?>
	background-position: center 30px;
	background-color: #<?php echo $loadingbg; ?>;
	color: #<?php echo $loadingtext; ?>;
	margin: 100px 0 0 -85px;
	left: 50%;
	line-height: 0;
}

#groupsengine .enmge-loading-icon p {
	-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
	margin: 10px 0 0 0;
	width: 150px;
	padding: 0 10px 0 10px;
	font-size: 14px !important;
	text-align: center;
	word-wrap: break-word !important;
	color: #<?php echo $loadingtext; ?>;
}

#groupsengine .enmge-loading-icon img {
	width: 54px;
	height: 55px;
	margin: 5px 0 0 58px;
	box-shadow: none;
}

/* ----- Share Link Box ----- */

#groupsengine .enmge-copy-link-box {
	position: absolute;
	margin: 0 0 0 -160px;
	background-color: #<?php echo $shareboxbg; ?>;
	width: 320px;
    left: 50%;
	padding: 10px 10px 14px 10px;
	border-radius: 10px;
	z-index: 100;
	line-height: 0;
}

#groupsengine .enmge-copy-link-box h4 {
	color: #<?php echo $shareboxtext; ?>;
	font-size: 15px !important;
	font-weight: 700;
	text-align: center;
	margin: 0 0 15px 0;
	padding: 0
}

#groupsengine .enmge-copy-link-box p {
	color: #<?php echo $shareboxtext; ?>;
	font-size: 14px !important;
	text-align: center;
	margin: 0 0 20px 0;
	padding: 0;
}

#groupsengine .enmge-copy-link-box a.enmge-copy-link-done {
	background-color: #<?php echo $shareboxbuttonbg; ?>;
	color: #<?php echo $shareboxbuttontext; ?>;
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

/* ----- Powered By ----- */

#groupsengine h3.enmge-poweredby {
	margin: 5px 0 0 0 !important;
	text-indent: -9000px;
	width: 148px;
	height: 40px;
	<?php if ( $credits == "light" ) { ?>
	background: url('../images/interface/ge_light_poweredby.png') no-repeat;	
	<?php } elseif ( $credits == "dark" ) { ?>
	background: url('../images/interface/ge_dark_poweredby.png') no-repeat;
	<?php } ?>
	float: right;
	padding: 0;
}

#groupsengine h3.enmge-poweredby a {
	display: block;
	width: 148px;
	height: 40px;
}

#groupsengine p.enmge-poweredbytext {
	margin: 5px 0 10px 0;
	text-align: right;
	font-size: 13px !important;
	color: #<?php echo $creditstext; ?>;
}

#groupsengine p.enmge-poweredbytext a:link, #groupsengine p.enmge-poweredbytext a:visited, #groupsengine p.enmge-poweredbytext a:hover, #groupsengine p.enmge-poweredbytext a:active {
	color: #<?php echo $creditstext; ?>;
}


/* ----- Responsive Desktop/iPad ----- */

@media (min-width:875px) and (max-width: 977px) { 
	#groupsengine .ge-explore-options select {
		width: 64%;
	}

	#groupsengine .ge-explore-options select.time {
		width: 24%;
	}

	#groupsengine .ge-explore-options input.ge-zip {
		width: 60%;	
	}

	#groupsengine .ge-explore-options.ge-medium .ge-option-container {
		width: 44%;
		float: left;
		padding: 10px;
	}

	#groupsengine .ge-explore-options.ge-medium select {
		width: 55%;
	}

	#groupsengine .ge-explore-options.ge-medium select.time {
		width: 23%;
	}

	#groupsengine .ge-explore-options.ge-medium input.ge-zip {
		width: 48%;	
	}

	#groupsengine .ge-single-group .ge-social.ge-medium {
		padding: 10px 0 10px 0;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium ul {
		width: 460px;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium ul li {
		margin: 0 0 0 7px;
		font-size: 12px !important;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium a:link, #groupsengine .ge-single-group .ge-social.ge-medium a:visited {
		width: 75px;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium a:hover, #groupsengine .ge-single-group .ge-social.ge-medium a:active {
		width: 75px;
	}

}

@media (min-width: 800px) and (max-width: 874px) { 
	#groupsengine .ge-explore-options select {
		width: 64%;
	}

	#groupsengine .ge-explore-options select.time {
		width: 24%;
	}

	#groupsengine .ge-explore-options input.ge-zip {
		width: 60%;	
	}

	#groupsengine .ge-explore-options.ge-medium .ge-option-container {
		width: 100%;
		float: none;
	}

	#groupsengine .ge-explore-options.ge-medium select {
		width: 68%;
		font-size: 16px; !important
		-webkit-appearance: none;
		font-size: 50px;
		height: 22px;
		white-space: nowrap;
	}

	#groupsengine .ge-explore-options.ge-medium select.time {
		width: 31%;
		height: 22px;
		white-space: nowrap;
	}

	#groupsengine .ge-explore-options.ge-medium input.ge-zip {
		width: 65%;	
		font-size: 16px !important;
		-webkit-appearance: none;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium {
		padding: 10px 0 10px 0;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium ul {
		width: 460px;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium ul li {
		margin: 0 0 0 7px;
		font-size: 12px !important;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium a:link, #groupsengine .ge-single-group .ge-social.ge-medium a:visited {
		width: 75px;
	}

	#groupsengine .ge-single-group .ge-social.ge-medium a:hover, #groupsengine .ge-single-group .ge-social.ge-medium a:active {
		width: 75px;
	}
}


@media (min-width:715px) and (max-width: 799px) { 
	#groupsengine .ge-explore-options select {
		width: 64%;
	}

	#groupsengine .ge-explore-options select.time {
		width: 24%;
	}

	#groupsengine .ge-explore-options input.ge-zip {
		width: 60%;	
	}

	#groupsengine .ge-explore-options.ge-medium .ge-option-container {
		width: 100%;
		float: none;
	}

	#groupsengine .ge-explore-options.ge-medium select {
		width: 68%;
		font-size: 16px; !important
		-webkit-appearance: none;
		font-size: 50px;
		height: 22px;
		white-space: nowrap;
	}

	#groupsengine .ge-explore-options.ge-medium select.time {
		width: 31%;
		height: 22px;
		white-space: nowrap;
	}

	#groupsengine .ge-explore-options.ge-medium input.ge-zip {
		width: 65%;	
		font-size: 16px !important;
		-webkit-appearance: none;
	}

	#groupsengine .ge-single-group .ge-social ul, #groupsengine .ge-single-group .ge-social.ge-small ul, #groupsengine .ge-single-group .ge-social.ge-medium ul {
		width: 186px;
		margin: 0 auto;
	}

	#groupsengine .ge-single-group .ge-social a:link, #groupsengine .ge-single-group .ge-social a:visited, #groupsengine .ge-single-group .ge-social a:hover, #groupsengine .ge-single-group .ge-social a:active, #groupsengine .ge-single-group .ge-social.ge-small a:link, #groupsengine .ge-single-group .ge-social.ge-small a:visited, #groupsengine .ge-single-group .ge-social.ge-small a:hover, #groupsengine .ge-single-group .ge-social.ge-small a:active, #groupsengine .ge-single-group .ge-social.ge-medium a:link, #groupsengine .ge-single-group .ge-social.ge-medium a:visited, #groupsengine .ge-single-group .ge-social.ge-medium a:hover, #groupsengine .ge-single-group .ge-social.ge-medium a:active {
		display: block;
		width: 39px;
		height: 30px;
		padding: 0;
		line-height: 30px;
		border-radius: 15px;
		text-indent: -9000px;
	}
}

/* ----- Responsive Mobile ----- */

@media (max-width:714px) { 

	#groupsengine img.ge-image {
		float: none;
		max-width: 100%;
		margin: 0 auto 15px auto;
	}

	#groupsengine .ge-imagecontainer {
		text-align: center !important;
	}

	#groupsengine .ge-explore-bar h4.ge-explore-toggle a {
		width: 70px;
	}

	#groupsengine .ge-explore-bar h4.ge-view-toggle a {
		width: 40px;
	}

	#groupsengine .ge-explore-bar h4.ge-explore-back a {
		width: 70px;
	}

	#groupsengine .ge-explore-bar h4.ge-explore-contact-back a {
		width: 52px;
	}

	#groupsengine .ge-explore-bar h4.ge-contact-leader a {
		width: 80px;
	}

	#groupsengine .deskhide {
		display: inline;
	}

	#groupsengine .mobhide {
		display: none;
	}

	#groupsengine .ge-explore-options .ge-option-container {
		width: 100%;
		float: none;
		padding: 10px 0 10px 10px;
	}

	#groupsengine .ge-explore-options select {
		width: 49%;
		font-size: 16px !important;
		height: 22px;
		white-space: nowrap;
	}

	#groupsengine .ge-explore-options select.time {
		width: 19%;
		font-size: 16px !important;
		height: 22px;
		white-space: nowrap;
	}

	#groupsengine .ge-explore-options input.ge-zip {
		width: 49%;	
		font-size: 16px !important;
		-webkit-appearance: none;
	}

	#groupsengine .ge-explore-options.ge-medium .ge-option-container {
		width: 100%;
		float: none;
	}

	#groupsengine .ge-explore-options.ge-medium select {
		width: 60%;
		font-size: 16px; !important
		-webkit-appearance: none;
		font-size: 50px;
		height: 22px;
		white-space: nowrap;
	}

	#groupsengine .ge-explore-options.ge-medium select.time {
		width: 26%;
		height: 22px;
		white-space: nowrap;
	}

	#groupsengine .ge-explore-options.ge-medium input.ge-zip {
		width: 55%;	
		font-size: 16px !important;
		-webkit-appearance: none;
	}

	#groupsengine .ge-explore-options input.ge-filter-submit {
		width: 60%;
		-webkit-appearance: none;
	}

	#groupsengine .ge-groups-table {
		width: 100%;
		border: none;
	}

	#groupsengine .ge-groups-table tr {
		display: block;
		padding: 14px 10px 14px 10px;
	}

	#groupsengine .ge-groups-table tr.ge-title-row {
		display: none;
	}

	#groupsengine .ge-groups-table tr.ge-odd {
		background-color: #f1f1f1
	}

	#groupsengine .ge-groups-table th {
		display: none;
	}

	#groupsengine .ge-groups-table td {
		display: block;
		text-align: left;
		margin: 0;
		padding: 3px 6px 3px 6px;
		font-size: 14px !important;
	}

	#groupsengine .ge-groups-table td.ge-group-title {
		text-align: center;
		padding: 3px 6px 8px 6px;
	}

	#groupsengine .ge-groups-table td.ge-group-title a {
		font-size: 24px !important;
		padding: 0 6px 6px 6px;
	}

	#groupsengine .ge-groups-table td.ge-group-day::before {
		content: "Day: ";
		font-weight: 700;
	}

	#groupsengine .ge-groups-table td.ge-group-time::before {
		content: "Time: ";
		font-weight: 700;
	}

	#groupsengine .ge-groups-table td.ge-group-ages::before {
		content: "For Ages: ";
		font-weight: 700;
	}

	#groupsengine .ge-groups-table td.ge-group-locations::before {
		content: "<?php echo $enmge_locationtitle; ?>: ";
		font-weight: 700;
	}

	#groupsengine .ge-groups-table td.ge-group-location::before {
		content: "Location: ";
		font-weight: 700;
	}

	#groupsengine .ge-groups-table td.ge-group-topic::before {
		content: "<?php echo $enmge_topictitle; ?>: ";
		font-weight: 700;
	}

	#groupsengine .ge-groups-table td.ge-group-childcare::before {
		content: "Childcare: ";
		font-weight: 700;
	}

	#groupsengine .ge-groups-table td.ge-group-status::before {
		content: "Status: ";
		font-weight: 700;
	}

	#groupsengine table.ge-detailstable td {
		display: block;
	}

	#groupsengine .ge-single-group td.ge-group-details, #groupsengine table.ge-detailstable .ge-top td, #groupsengine table.ge-detailstable .ge-bottom td, #groupsengine table.ge-detailstable td.left, #groupsengine table.ge-detailstable td.right {
		padding: 8px 12px 8px 12px !important;
	}

	#groupsengine .ge-single-group td.ge-group-details.status {
		padding: 8px 12px 18px 12px !important;
	}

	#groupsengine .ge-single-group .ge-social ul, #groupsengine .ge-single-group .ge-social.ge-small ul, #groupsengine .ge-single-group .ge-social.ge-medium ul {
		width: 186px;
		margin: 0 auto;
	}

	#groupsengine .ge-single-group .ge-social a:link, #groupsengine .ge-single-group .ge-social a:visited, #groupsengine .ge-single-group .ge-social a:hover, #groupsengine .ge-single-group .ge-social a:active, #groupsengine .ge-single-group .ge-social.ge-small a:link, #groupsengine .ge-single-group .ge-social.ge-small a:visited, #groupsengine .ge-single-group .ge-social.ge-small a:hover, #groupsengine .ge-single-group .ge-social.ge-small a:active, #groupsengine .ge-single-group .ge-social.ge-medium a:link, #groupsengine .ge-single-group .ge-social.ge-medium a:visited, #groupsengine .ge-single-group .ge-social.ge-medium a:hover, #groupsengine .ge-single-group .ge-social.ge-medium a:active {
		display: block;
		width: 39px;
		height: 30px;
		padding: 0;
		line-height: 30px;
		border-radius: 15px;
		text-indent: -9000px;
	}

	#groupsengine table.ge-leader-contact-form td {
		padding: 5px;
	}

	#groupsengine table.ge-leader-contact-form td.ge-contact-label {
		padding: 18px 10px 0 0;
		width: 28%;
		vertical-align: top;
		text-align: right;
	}

	#groupsengine table.ge-leader-contact-form td.ge-contact-label label {
		font-weight: 700;
		font-size: 13px !important;
	}

	#groupsengine table.ge-leader-contact-form td.ge-contact-input {
		padding: 5px;
		width: 72%;
	}

	#groupsengine table.ge-leader-contact-form input.ge {
		font-size: 14px !important;
		padding: 5px 10px 5px 10px;
		height: 30px;
		width: 80%;
	}

	#groupsengine table.ge-leader-contact-form textarea {
		font-size: 14px !important;
		padding: 10px;
		height: 150px;
		width: 95%;
	}

	#groupsengine table.ge-leader-contact-form input:focus, #groupsengine table.ge-leader-contact-form textarea:focus { 
		outline: none; 
	}

	#groupsengine .ge-leader-contact input.ge-leader-contact-submit {
		display: block;
		width: 160px;
		height: 40px;
		line-height: 40px;
		text-align: center;
		text-transform: uppercase;
		margin: 0;
		padding: 0;
		-webkit-appearance: none;
		border-radius: 20px;
	}

	#groupsengine .page-numbers.current, #groupsengine .page-numbers.number, #groupsengine a.page-numbers.wide {
		display: none;
	}

	#groupsengine a.next.page-numbers, #groupsengine a.previous.page-numbers {
		display: inline-block;
		width: 70px;
		height: 30px;
		line-height: 30px;
		text-align: center;
		text-decoration: none;
		border-radius: 15px;
		padding: 0;
		text-transform: uppercase;
	}

	#groupsengine a.page-numbers span {
		display: inline;
	}

	#groupsengine .enmge-copy-link-box {
		position: absolute;
		margin: 0 0 0 -115px;
		width: 230px;
	    left:46%;
		padding: 10px 10px 14px 10px;
		border-radius: 10px;
		z-index: 100;
		line-height: 0;
	}

	#groupsengine h3.enmge-poweredby {
		margin: 20px auto 10px auto !important;
		float: none;
	}
	
	#groupsengine p.enmge-poweredbytext {
		margin: 20px 0 10px 0 !important;
		text-align: center;
		float: none;
	}
}

@media (-webkit-min-device-pixel-ratio: 2) {
	#groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-map-toggle:link, #groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-map-toggle:visited {
		<?php if ( $explorebuttonicon == "light" ) { ?>
		background: url('../images/interface/light_map2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_map2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $explorebuttonbg; ?>;
		background-size: 18px 18px;
		background-position: 14px 10px;
	}

	#groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-map-toggle:hover, #groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-map-toggle:active {
		<?php if ( $explorebuttonicon == "light" ) { ?>
		background: url('../images/interface/light_map2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_map2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $explorebuttonbgroll; ?>;
		background-size: 18px 18px;
		background-position: 14px 10px;
	}

	#groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-list-toggle:link, #groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-list-toggle:visited {
		<?php if ( $explorebuttonicon == "light" ) { ?>
		background: url('../images/interface/light_list2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_list2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $explorebuttonbg; ?>;
		background-size: 18px 18px;
		background-position: 14px 10px;
	}

	#groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-list-toggle:hover, #groupsengine .ge-explore-bar h4.ge-view-toggle a.ge-list-toggle:active {
		<?php if ( $explorebuttonicon == "light" ) { ?>
		background: url('../images/interface/light_list2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_list2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $explorebuttonbgroll; ?>;
		background-size: 18px 18px;
		background-position: 14px 10px;
	}

	#groupsengine .ge-explore-bar h4.ge-explore-toggle a {
		<?php if ( $exploreactionicon == "light" ) { ?>
		background: url('../images/interface/light_search2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_search2x.png') no-repeat;
		<?php } ?>
		background-size: 18px 18px;
		background-position: 10px 11px;
		background-color: #<?php echo $exploreactionbg; ?>;
	}

	#groupsengine .ge-explore-bar h4.ge-contact-leader a {
		<?php if ( $exploreactionicon == "light" ) { ?>
		background: url('../images/interface/light_contact2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_contact2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $exploreactionbg; ?>;
		background-size: 18px 18px;
		background-position: 10px 11px;
	}

	#groupsengine .ge-explore-bar h4.ge-explore-back a:link, #groupsengine .ge-explore-bar h4.ge-explore-back a:visited, #groupsengine .ge-explore-bar h4.ge-explore-contact-back a:link, #groupsengine .ge-explore-bar h4.ge-explore-contact-back a:visited {
		<?php if ( $explorebuttonicon == "light" ) { ?>
		background: url('../images/interface/light_back2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_back2x.png') no-repeat;
		<?php } ?>
		background-size: 18px 18px;
		background-position: 10px 10px;
		background-color: #<?php echo $explorebuttonbg; ?>;
	}

	#groupsengine .ge-explore-bar h4.ge-explore-back a:hover, #groupsengine .ge-explore-bar h4.ge-explore-back a:active, #groupsengine .ge-explore-bar h4.ge-explore-contact-back a:hover, #groupsengine .ge-explore-bar h4.ge-explore-contact-back a:active {
		<?php if ( $explorebuttonicon == "light" ) { ?>
		background: url('../images/interface/light_back2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_back2x.png') no-repeat;
		<?php } ?>
		background-size: 18px 18px;
		background-position: 10px 10px;
		background-color: #<?php echo $explorebuttonbgroll; ?>;
	}

	#groupsengine .ge-single-group .ge-social .ge-facebook a:link, #groupsengine .ge-single-group .ge-social .ge-facebook a:visited {
		<?php if ( $singledetailsshareicon == "light" ) { ?>
		background: url('../images/interface/light_facebook2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_facebook2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $singledetailssharebg; ?>;
		background-size: 15px 15px;
		background-position: 12px 7px;
	}

	#groupsengine .ge-single-group .ge-social .ge-facebook a:hover, #groupsengine .ge-single-group .ge-social .ge-facebook a:active {
		<?php if ( $singledetailsshareicon == "light" ) { ?>
		background: url('../images/interface/light_facebook2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_facebook2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $singledetailssharebgroll; ?>;
		background-size: 15px 15px;
		background-position: 12px 7px;
	}

	#groupsengine .ge-single-group .ge-social .ge-twitter a:link, #groupsengine .ge-single-group .ge-social .ge-twitter a:visited  {
		<?php if ( $singledetailsshareicon == "light" ) { ?>
		background: url('../images/interface/light_twitter2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_twitter2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $singledetailssharebg; ?>;
		background-size: 15px 15px;
		background-position: 12px 7px;
	}

	#groupsengine .ge-single-group .ge-social .ge-twitter a:hover, #groupsengine .ge-single-group .ge-social .ge-twitter a:active  {
		<?php if ( $singledetailsshareicon == "light" ) { ?>
		background: url('../images/interface/light_twitter2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_twitter2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $singledetailssharebgroll; ?>;
		background-size: 15px 15px;
		background-position: 12px 7px;
	}

	#groupsengine .ge-single-group .ge-social .ge-share a:link, #groupsengine .ge-single-group .ge-social .ge-share a:visited {
		<?php if ( $singledetailsshareicon == "light" ) { ?>
		background: url('../images/interface/light_link2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_link2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $singledetailssharebg; ?>;
		background-size: 15px 15px;
		background-position: 12px 7px;
	}

	#groupsengine .ge-single-group .ge-social .ge-share a:hover, #groupsengine .ge-single-group .ge-social .ge-share a:active {
		<?php if ( $singledetailsshareicon == "light" ) { ?>
		background: url('../images/interface/light_link2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_link2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $singledetailssharebgroll; ?>;
		background-size: 15px 15px;
		background-position: 12px 7px;
	}

	#groupsengine .ge-single-group .ge-social .ge-email a:link, #groupsengine .ge-single-group .ge-social .ge-email a:visited {
		<?php if ( $singledetailsshareicon == "light" ) { ?>
		background: url('../images/interface/light_email2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_email2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $singledetailssharebg; ?>;
		background-size: 15px 15px;
		background-position: 12px 7px;
	}

	#groupsengine .ge-single-group .ge-social .ge-email a:hover, #groupsengine .ge-single-group .ge-social .ge-email a:active {
		<?php if ( $singledetailsshareicon == "light" ) { ?>
		background: url('../images/interface/light_email2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/dark_email2x.png') no-repeat;
		<?php } ?>
		background-color: #<?php echo $singledetailssharebgroll; ?>;
		background-size: 15px 15px;
		background-position: 12px 7px;
	}

	#groupsengine .enmge-loading-icon {
		<?php if ( $customloadingretina == null ) { ?>
		<?php if ( $loadingicon == "light" ) { ?>
		background: url('../images/interface/ge_light_load2x.png') no-repeat;
		<?php } else { ?>
		background: url('../images/interface/ge_dark_load2x.png') no-repeat;
		<?php } ?>
		<?php } else { ?>
		background: url('<?php echo $customloadingretina; ?>') no-repeat;
		<?php } ?>
		background-size: 54px 55px;
		background-position: center 30px;
		background-color: #<?php echo $loadingbg; ?>;
	}

	#groupsengine h3.enmge-poweredby {
		<?php if ( $credits == "light" ) { ?>
		background: url('../images/interface/ge_light_poweredby2x.png') no-repeat;	
		<?php } elseif ( $credits == "dark" ) { ?>
		background: url('../images/interface/ge_dark_poweredby2x.png') no-repeat;
		<?php } ?>
		background-size: 148px 40px;
	}
}