<?php /* ----- Series Engine - Media Browser Embed ----- */

global $wpdb;
global $wp_version;

if ( $wp_version != null ) {

$enmse_options = get_option( 'enm_seriesengine_options' ); 
$enmse_primaryst = $enmse_options['primaryst'];
$enmse_videotablabel = $enmse_options['videotablabel'];
$enmse_audiotablabel = $enmse_options['audiotablabel'];
$enmse_loadingicon = $enmse_options['loadingicon'];
$enmse_playerdetailsbackground = $enmse_options['playerdetailsbackground'];
$enmse_poweredby = $enmse_options['poweredby'];
$enmse_dateformat = get_option( 'date_format' ); 


if ( isset($enmse_options['usepermalinks']) ) { 
	$enmse_usepermalinks = $enmse_options['usepermalinks'];
} else {
	$enmse_usepermalinks = 1;
}

if ( isset($enmse_options['archiveliststyle']) ) { 
	$enmse_archivetype = $enmse_options['archiveliststyle'];
} else {
	$enmse_archivetype = 0;
}

if ( isset($enmse_options['placeholderimage']) && $enmse_options['placeholderimage'] != null ) { 
	$enmse_placeholderimage = $enmse_options['placeholderimage'];
} else {
	$enmse_placeholderimage = plugins_url() . '/seriesengine_plugin/images/series_thumb_placeholder.jpg';
}

if ( isset($enmse_options['forcedownload']) ) { 
	$enmse_force = $enmse_options['forcedownload'];
} else {
	$enmse_force = 1;
}

if ( isset($enmse_options['pag']) ) { // Default pagination
	$enmse_dpag = $enmse_options['pag'];
} else {
	$enmse_dpag = 10;
}

if ( isset($_GET['enmse_pag']) )  { // custom pagination
	$enmse_pag = strip_tags($_GET['enmse_pag']);
} elseif ( $enmse_lo == 1 && $enmse_fpag != 0 ) {
	$enmse_pag = $enmse_fpag;
} else {
	$enmse_pag = 0;
}

if ( isset($enmse_options['apag']) ) { // Default archives pagination
	$enmse_dapag = $enmse_options['apag'];
} else {
	$enmse_dapag = 12;
}

if ( isset($_GET['enmse_apag']) )  { // custom archives number per page
	$enmse_apag = strip_tags($_GET['enmse_apag']);
} elseif ( $enmse_lo == 1 && $enmse_fapag != 0 ) {
	$enmse_apag = $enmse_fapag;
} else {
	$enmse_apag = 0;
}

if ( isset($enmse_options['topicsort']) ) { // Sort Topics Manually?
	$enmsetopicsort = $enmse_options['topicsort'];
} else {
	$enmsetopicsort = 1;
}

if ( isset($enmse_options['playerstyle']) ) { // Style of media player and details section
	$enmseplayerstyle = $enmse_options['playerstyle'];
} else {
	$enmseplayerstyle = 1;
}

// ***** Get Language

include('lang/language_settings.php');

// ***** Get Labels

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

if ( isset($enmse_options['language']) ) { // Find the Language
	$enmse_language = $enmse_options['language'];
} else {
	$enmse_language = 1;
}

if ( $enmse_language == 10 ) { // French
	include('lang/fre_bible_books.php');
} elseif ( $enmse_language == 9 ) { // Russian
	include('lang/rus_bible_books.php');
} elseif ( $enmse_language == 8 ) { // Japanese
	include('lang/jap_bible_books.php');
} elseif ( $enmse_language == 7 ) { // Dutch
	include('lang/dut_bible_books.php');
} elseif ( $enmse_language == 6 ) { // Traditional Chinese
	include('lang/chint_bible_books.php');
} elseif ( $enmse_language == 5 ) { // Simplified Chinese
	include('lang/chins_bible_books.php');
} elseif ( $enmse_language == 4 ) { // Turkish
	include('lang/turk_bible_books.php');
} elseif ( $enmse_language == 3 ) { // German
	include('lang/ger_bible_books.php');
} elseif ( $enmse_language == 2 ) { // Spanish
	include('lang/spa_bible_books.php');
} else { // English
	include('lang/eng_bible_books.php');
}

if ( $enmse_language == 4 ) {
	$enmse_langswitch = 1;
} elseif ( $enmse_language == 8 ) {
	$enmse_langswitch = 2;
} else {
	$enmse_langswitch = 0;
}


// ***** DISPLAY SERIES ARCHIVES
if ( isset($_GET['enmse_archives']) || ($enmse_lo == 1 && $enmse_a == 1 && !isset($_GET['enmse_mid']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_spid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) ) ) {
	if ( $enmse_lo != 1 ) {
		$enmse_hsd = 0;
		$enmse_hspd = 0;
		$enmse_htd = 0;
		if ( $bibleoption == 0 ) {
			$enmse_hbd = 1;
		} else {
			$enmse_hbd = 0;
		}
	}	

	$enmse_ddtotal = $enmse_hsd+$enmse_hspd+$enmse_htd+$enmse_hbd;
	$enmse_number = 4-$enmse_ddtotal;

	if ( $enmse_number == 4 ) {
		$enmse_ddval = "four";
	} elseif ( $enmse_number == 3 ) {
		$enmse_ddval = "three";
	} elseif ( $enmse_number == 2 ) {
		$enmse_ddval = "two";
	} elseif ( $enmse_number == 1 ) {
		$enmse_ddval = "one";
	}

	include('display/pagination/paginatedseriesarchives.php');
	
	// Get All Series Message Matches for Number of Messages
	$enmse_preparredsmmsql = "SELECT message_id, series_id FROM " . $wpdb->prefix . "se_series_message_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL"; 
	$enmse_smm = $wpdb->get_results( $enmse_preparredsmmsql );


// ***** ARE OPTIONS SPECIFIED? *****
} elseif ( $enmse_lo == 1 ) {
	if ( $bibleoption == 0 ) {
		$enmse_hbd = 1;
	}
	$enmse_ddtotal = $enmse_hsd+$enmse_hspd+$enmse_htd+$enmse_hbd;
	$enmse_number = 4-$enmse_ddtotal;

	if ( $enmse_number == 4 ) {
		$enmse_ddval = "four";
	} elseif ( $enmse_number == 3 ) {
		$enmse_ddval = "three";
	} elseif ( $enmse_number == 2 ) {
		$enmse_ddval = "two";
	} elseif ( $enmse_number == 1 ) {
		$enmse_ddval = "one";
	}

	if ( isset($_GET['enmse']) || isset($_GET['enmse_mid']) || isset($_GET['enmse_bid']) || isset($_GET['enmse_sid']) || isset($_GET['enmse_spid']) || isset($_GET['enmse_tid']) || isset($_GET['enmse_a']) ) {
		$enmse_scm = 1;
	}

	if ( ( isset($_GET['enmse_sds']) && $_GET['enmse_sds'] == 1 ) || $enmse_sim == 0 && ( !isset($_GET['enmse_sid']) && !isset($_GET['enmse_mid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid']) && !isset($_GET['enmse_am']) ) ) {
		$enmse_sds = 1;
	} else {
		$enmse_sds = 0;
	};
	
	include('display/woquery.php');
	
// ***** DISPLAY STANDARD LISTING OF MESSAGES BY RECENT MESSAGE/SERIES *****
} else {  
	$enmse_de = 1;
	$enmse_hsd = 0;
	$enmse_hspd = 0;
	$enmse_htd = 0;
	if ( $bibleoption == 0 ) {
		$enmse_hbd = 1;
		$enmse_ddval = "three";
	} else {
		$enmse_hbd = 0;
		$enmse_ddval = "four";
	}
	

	if ( isset($enmse_options['cardview']) ) { // Default cardview
		$enmse_cardview = $enmse_options['cardview'];
	} else {
		$enmse_cardview = 0;
	}

	include('display/standardquery.php');
	
}

if ( !defined('ENMSE_FIND_PAGE') ) { // Find current page for building URLs
	function enmse_find_page() {
		define('ENMSE_FIND_PAGE', 'yes');
		$enmse_get_url = parse_url( strtok( get_permalink(), '&' ) );
		if ( !isset($enmse_get_url['query']) ) {
			return strtok( get_permalink(), '&' ) . "?enmse=1";
		} else {
			return strtok( get_permalink(), '&' );
		}
	}
}

	$enmse_thispage = enmse_find_page();
	$enmse_randomval = rand();



?>
<?php if ( $enmse_lo == 1 && $enmse_de == 0 ) { ?>
<style type="text/css" media="screen">
		#seriesengine .enmse-loading-icon {
			margin-top: 50px;
		}
</style>
<?php } ?>
<div id="seriesengine">
	<script src="https://player.vimeo.com/api/player.js"></script>
	<input type="hidden" name="enmse-random" value="<?php echo $enmse_randomval; ?>" class="enmse-random">
	<div class="enmse-loading-icon" style="display: none;">
		<p><?php echo $enmse_loadingmessage; ?></p>
	</div>
	<div class="enmse-copy-link-box" style="display: none;">
		<h4><?php echo $enmse_sharelinktitle; ?></h4>
		<p><?php echo $enmse_sharelinkinstructions; ?></p>
		<a href="#" class="enmse-copy-link-done"><?php echo $enmse_sharelinkclosebutton; ?></a>
	</div>
	<div class="enmse-content-container" id="enmse-top<?php echo $enmse_randomval; ?>">
		<input type="hidden" name="enmse-rrandom" value="<?php echo $enmse_randomval; ?>" class="enmse-rrandom">
<?php if ( isset($_GET['enmse_archives']) || ($enmse_lo == 1 && $enmse_a == 1 && !isset($_GET['enmse_mid']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_spid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) ) ) { // ***** DISPLAY SERIES ARCHIVES ?>
	<style type="text/css" media="screen">
			#seriesengine .enmse-loading-icon {
				margin-top: 50px;
			}
	</style>
	<?php include('display/archives.php'); /* Series Archives */ ?>
	<input type="hidden" name="enmse-permalinknoajax" value="<?php echo $enmse_thispage; ?>" class="enmse-permalinknoajax">
<?php } elseif ( $enmse_lo == 1 ) { // ***** ARE OPTIONS SPECIFIED? ***** ?>
	<?php if ( !empty($enmse_singlemessage) ) { ?>
		<?php include('display/explorer.php'); /* Message Explorer */ ?>
		<?php if ( $enmse_sim == 1 || $enmse_sds == 0 || ( ( isset($_GET['enmse_sds']) && $_GET['enmse_sds'] == 0 ) && ( isset($_GET['enmse_sid']) || isset($_GET['enmse_mid']) || isset($_GET['enmse_tid']) || isset($_GET['enmse_bid']) || isset($_GET['enmse_spid']) || isset($_GET['enmse_am']) ) ) ) { ?>
			<?php if ( $enmseplayerstyle == 1 ) { /* Player and Details */
				include('display/newwoplayer.php');
			} else {
				include('display/woplayer.php');
			}?>	
		<?php } ?>
		<?php if ( $enmse_scm == 1 ) { // SHOW COMPLIMENTARY MESSAGES? ?>
			<?php include('display/worelatedmessages.php'); /* Related Messages */ ?>
		<?php } ?>
		<?php include('display/wooptions.php'); /* Options */ ?>
	<?php } ?>
<?php } else { // ***** DISPLAY STANDARD LISTING OF MESSAGES BY RECENT MESSAGE/SERIES ***** ?>
	<?php if ( !empty($enmse_singlemessage) ) { ?>
		<?php include('display/explorer.php'); /* Message Explorer */ ?>
		<?php if ( $enmseplayerstyle == 1 ) { /* Player and Details */
			include('display/newplayer.php');
		} else {
			include('display/player.php');
		}?>	
		<?php include('display/relatedmessages.php'); /* Related Messages */ ?>
		<?php include('display/options.php'); /* Options */ ?>
	<?php } ?>
<?php } ?>

	<?php if ( $enmse_poweredby != "text" ) { ?>
	<h3 class="enmse-poweredby"><a href="http://seriesengine.com" target="_blank"><?php echo $enmse_poweredby; ?></a></h3>	
	<?php } else { ?>
	<p class="enmse-poweredbytext"><?php echo $enmse_poweredbylink; ?></p>
	<?php } ?>
	<div style="clear: right"></div>
	<!-- v2.8.7.080422 -->
	</div>
</div>
<?php // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>