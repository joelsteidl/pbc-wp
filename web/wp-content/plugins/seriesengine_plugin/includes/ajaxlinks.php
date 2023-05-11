<?php /* ----- Series Engine - Pull in media browser links with AJAX ----- */

	
	global $wpdb;
	global $wp_version;

	if ( $wp_version != null ) {

	$enmse_options = get_option( 'enm_seriesengine_options' ); 
	$enmse_primaryst = $enmse_options['primaryst'];
	$enmse_videotablabel = $enmse_options['videotablabel'];
	$enmse_audiotablabel = $enmse_options['audiotablabel'];
	$enmse_playerdetailsbackground = $enmse_options['playerdetailsbackground'];
	$enmse_poweredby = $enmse_options['poweredby'];
	$enmse_dateformat = get_option( 'date_format' ); 

	$embedoptions = $_REQUEST['embedoptions']; // Parse Values via new AJAX method
	$ajaxvalues = $_REQUEST['ajaxvalues'];
	$enmse_permalink = $_REQUEST['enmse_permalink'];
	$combinedvalues = "?" . $embedoptions . $ajaxvalues;
	$ajax_query_str = parse_url($combinedvalues, PHP_URL_QUERY);
	parse_str($ajax_query_str, $ajaxvars);
	foreach ($ajaxvars as $key => $value) {
		$_GET[$key] = $value;
	}

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

	if ( isset($enmse_options['bibleoption']) ) { // Is Scripture Enabled?
		$bibleoption = $enmse_options['bibleoption'];
	} else {
		$bibleoption = 0;
	}

	if ( isset($enmse_options['playerstyle']) ) { // Style of media player and details section
		$enmseplayerstyle = $enmse_options['playerstyle'];
	} else {
		$enmseplayerstyle = 1;
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

	// ***** DEFINE EMBED OPTIONS
	$enmse_lo = strip_tags($_GET['enmse_lo']);
	$enmse_a = strip_tags($_GET['enmse_a']);

	if ( isset($enmse_options['pag']) ) { // Default pagination
		$enmse_dpag = $enmse_options['pag'];
	} else {
		$enmse_dpag = 10;
	}

	if ( isset($_GET['enmse_pag']) )  { // number of messages per page
		$enmse_pag = strip_tags($_GET['enmse_pag']);
	} else {
		$enmse_pag = 0;
	}

	if ( isset($enmse_options['apag']) ) { // Default archives pagination
		$enmse_dapag = $enmse_options['apag'];
	} else {
		$enmse_dapag = 12;
	}

	if ( isset($_GET['enmse_apag']) )  { // number of series per page in archives
		$enmse_apag = strip_tags($_GET['enmse_apag']);
	} else {
		$enmse_apag = 0;
	}

	if ( isset($_GET['enmse_dam']) )  { // display all messages?
		$enmse_dam = strip_tags($_GET['enmse_dam']);
	} else {
		$enmse_dam = 0;
	}

	if ( isset($enmse_options['topicsort']) ) { // Sort Topics Manually?
		$enmsetopicsort = $enmse_options['topicsort'];
	} else {
		$enmsetopicsort = 1;
	}

	if ( isset($enmse_options['scripturelabel']) ) { // Find Scripture Label
		$enmse_reftext = $enmse_options['scripturelabel'];
	} else {
		$enmse_reftext = "Scripture References";
	}

	if ( isset($_GET['enmse_hs']) )  { // Hide Series Details
		$enmse_hs = strip_tags($_GET['enmse_hs']);
	} else {
		$enmse_hs = 0;
	}

	if ( isset($_GET['enmse_hsh']) )  { // Hide Sharing Options
		$enmse_hsh = strip_tags($_GET['enmse_hsh']);
	} else {
		$enmse_hsh = 0;
	}

	if ( isset($_GET['enmse_had']) )  { // Hide Audio Downloads
		$enmse_had = strip_tags($_GET['enmse_had']);
	} else {
		$enmse_had = 0;
	}

	// ***** DISPLAY SERIES ARCHIVES
	if ( isset($_GET['enmse_archives']) || ($enmse_lo == 1 && $enmse_a == 1) ) {

		$enmse_cardview = strip_tags($_GET['enmse_cv']);

		include('display/pagination/wopaginatedseriesarchives.php');
		
		// Get All Series Message Matches for Number of Messages
		$enmse_preparredsmmsql = "SELECT message_id, series_id FROM " . $wpdb->prefix . "se_series_message_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL"; 
		$enmse_smm = $wpdb->get_results( $enmse_preparredsmmsql );

	// ***** ARE OPTIONS SPECIFIED? *****
	} elseif ( $enmse_lo == 1 ) {
		
		$enmse_de = strip_tags($_GET['enmse_de']);
		$enmse_d = strip_tags($_GET['enmse_d']);
		$enmse_sh = strip_tags($_GET['enmse_sh']);
		$enmse_ex = strip_tags($_GET['enmse_ex']);
		$enmse_dsm = strip_tags($_GET['enmse_dsm']);
		$enmse_dss = strip_tags($_GET['enmse_dss']);
		$enmse_dst = strip_tags($_GET['enmse_dst']);
		$enmse_dsb = strip_tags($_GET['enmse_dsb']);
		$enmse_dssp = strip_tags($_GET['enmse_dssp']);
		$enmse_dam = strip_tags($_GET['enmse_dam']);
		$enmse_scm = 1;
		$enmse_dsst = strip_tags($_GET['enmse_dsst']);
		$enmse_sort = strip_tags($_GET['enmse_sort']);
		$enmse_cardview = strip_tags($_GET['enmse_cv']);
		$enmse_ddval = strip_tags($_GET['enmse_ddval']);
		$enmse_hsd = strip_tags($_GET['enmse_hsd']);
		$enmse_hspd = strip_tags($_GET['enmse_hspd']);
		$enmse_htd = strip_tags($_GET['enmse_htd']);
		$enmse_hbd = strip_tags($_GET['enmse_hbd']);
		$enmse_sim = 1;
		$enmse_sds = 0;

		
		include('display/woquery.php');

	// ***** DISPLAY STANDARD LISTING OF MESSAGES BY RECENT MESSAGE/SERIES *****
	} else {  
		$enmse_cardview = strip_tags($_GET['enmse_cv']);
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

		$enmse_sort = "ASC";

		include('display/standardquery.php');

	}

		$enmse_thispage = strip_tags($enmse_permalink);
		$enmse_randomval = rand();

	?>
	<input type="hidden" name="enmse-rrandom" value="<?php echo $enmse_randomval; ?>" class="enmse-rrandom">
	<?php if ( isset($_GET['enmse_archives']) || ($enmse_lo == 1 && $enmse_a == 1) ) { // ***** DISPLAY SERIES ARCHIVES ?>
		<style type="text/css" media="screen">
				#seriesengine .enmse-loading-icon {
					margin-top: 50px;
				}
		</style>
		<?php include('display/archives.php'); /* Series Archives */ ?>
	<?php } elseif ( $enmse_lo == 1 ) { // ***** ARE OPTIONS SPECIFIED? ***** ?>
			<?php if ( !empty($enmse_singlemessage) ) { ?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#seriesengine audio').mediaelementplayer({stretching: 'responsive'});
						jQuery('#seriesengine video').mediaelementplayer({stretching: 'responsive'});
						
						jQuery("#seriesengine audio.enmseaplayer").bind("play", function(){
							var begcurrent = jQuery(this).attr("rel");
							if ( begcurrent == "" ) {
								begcurrent = 0;
							};
							var current = parseInt(begcurrent);
							var m = jQuery(this).attr("name");
							var newcount = current+1;
							var mtype = "audio";
							jQuery.ajax({
							        url: seajax.ajaxurl, 
							        data: {
							            'action': 'seriesengine_ajaxviewcount',
							            'count' : newcount,
							            'id' : m,
							            'type' : mtype
							        },
							        success:function(data) {
							        },
							        error: function(errorThrown){
							            console.log(errorThrown);
							        }
							    });
							jQuery(this).unbind();
						});

						jQuery("#seriesengine video.enmsevplayer").bind("play", function(){
							var begcurrent = jQuery(this).attr("rel");
							if ( begcurrent == "" ) {
								begcurrent = 0;
							};
							var current = parseInt(begcurrent);
							var m = jQuery(this).attr("name");
							var newcount = current+1;
							var mtype = "video";
							jQuery.ajax({
							        url: seajax.ajaxurl, 
							        data: {
							            'action': 'seriesengine_ajaxviewcount',
							            'count' : newcount,
							            'id' : m,
							            'type' : mtype
							        },
							        success:function(data) {
							        },
							        error: function(errorThrown){
							            console.log(errorThrown);
							        }
							    });
							jQuery(this).unbind();
						});

						jQuery("#seriesengine video.enmseaplayer").bind("play", function(){
							var begcurrent = jQuery(this).attr("rel");
							if ( begcurrent == "" ) {
								begcurrent = 0;
							};
							var current = parseInt(begcurrent);
							var m = jQuery(this).attr("name");
							var newcount = current+1;
							var mtype = "alternate";
							jQuery.ajax({
							        url: seajax.ajaxurl, 
							        data: {
							            'action': 'seriesengine_ajaxviewcount',
							            'count' : newcount,
							            'id' : m,
							            'type' : mtype
							        },
							        success:function(data) {
							        },
							        error: function(errorThrown){
							            console.log(errorThrown);
							        }
							    });
							jQuery(this).unbind();
						});
					});								
				</script>
				<?php include('display/explorer.php'); /* Message Explorer */ ?>
				<?php if ( $enmseplayerstyle == 1 ) { /* Player and Details */
					include('display/newwoplayer.php');
				} else {
					include('display/woplayer.php');
				}?>					
				<?php if ( $enmse_scm == 1 ) { // SHOW COMPLIMENTARY MESSAGES? ?>
					<?php include('display/worelatedmessages.php'); /* Related Messages */ ?>
				<?php } ?>
				<?php include('display/wooptions.php'); /* Options */ ?>
			<?php } ?>
		<?php } else { // ***** DISPLAY STANDARD LISTING OF MESSAGES BY RECENT MESSAGE/SERIES ***** ?>
			<?php if ( !empty($enmse_singlemessage) ) { ?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#seriesengine audio').mediaelementplayer({stretching: 'responsive'});
						jQuery('#seriesengine video').mediaelementplayer({stretching: 'responsive'});

						jQuery("#seriesengine audio.enmseaplayer").bind("play", function(){
							var begcurrent = jQuery(this).attr("rel");
							if ( begcurrent == "" ) {
								begcurrent = 0;
							};
							var current = parseInt(begcurrent);
							var m = jQuery(this).attr("name");
							var newcount = current+1;
							var mtype = "audio";
							jQuery.ajax({
							        url: seajax.ajaxurl, 
							        data: {
							            'action': 'seriesengine_ajaxviewcount',
							            'count' : newcount,
							            'id' : m,
							            'type' : mtype
							        },
							        success:function(data) {
							        },
							        error: function(errorThrown){
							            console.log(errorThrown);
							        }
							    });
							jQuery(this).unbind();
						});

						jQuery("#seriesengine video.enmsevplayer").bind("play", function(){
							var begcurrent = jQuery(this).attr("rel");
							if ( begcurrent == "" ) {
								begcurrent = 0;
							};
							var current = parseInt(begcurrent);
							var m = jQuery(this).attr("name");
							var newcount = current+1;
							var mtype = "video";
							jQuery.ajax({
							        url: seajax.ajaxurl, 
							        data: {
							            'action': 'seriesengine_ajaxviewcount',
							            'count' : newcount,
							            'id' : m,
							            'type' : mtype
							        },
							        success:function(data) {
							        },
							        error: function(errorThrown){
							            console.log(errorThrown);
							        }
							    });
							jQuery(this).unbind();
						});

						jQuery("#seriesengine video.enmseaplayer").bind("play", function(){
							var begcurrent = jQuery(this).attr("rel");
							if ( begcurrent == "" ) {
								begcurrent = 0;
							};
							var current = parseInt(begcurrent);
							var m = jQuery(this).attr("name");
							var newcount = current+1;
							var mtype = "alternate";
							jQuery.ajax({
							        url: seajax.ajaxurl, 
							        data: {
							            'action': 'seriesengine_ajaxviewcount',
							            'count' : newcount,
							            'id' : m,
							            'type' : mtype
							        },
							        success:function(data) {
							        },
							        error: function(errorThrown){
							            console.log(errorThrown);
							        }
							    });
							jQuery(this).unbind();
						});
					});				
				</script>
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
		<?php if ( preg_match('/(fb-roo)\w+/', $enmse_singlemessage->embed_code) || preg_match('/(fb-roo)\w+/', $enmse_singlemessage->alternate_embed) ) { ?>
		<script type="text/javascript">
			FB.XFBML.parse();
		</script>
		<?php } ?>
	<?php // Deny access to sneaky people!
	} else {
		exit("Access Denied");
	} die(); ?>