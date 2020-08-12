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

	
		
		include('wopaginatedseriesarchives.php');
		
		// Get All Series Message Matches for Number of Messages
		$enmse_preparredsmmsql = "SELECT message_id, series_id FROM " . $wpdb->prefix . "se_series_message_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL"; 
		$enmse_smm = $wpdb->get_results( $enmse_preparredsmmsql );


		$enmse_thispage = $_GET['enmse_permalink'];

	?>
			<?php if ( $enmse_archivetype == 1 ) { // Display Image Grid Style Archive ?>
			<div id="enmse-archive-thumbnails">
			<?php $enmse_middlecount = 0; $enmse_oddcount = 0;
			foreach ($enmse_series as $enmse_s) { 
				if ( $enmse_middlecount < 3 ) {$enmse_middlecount = $enmse_middlecount+1;} else {$enmse_middlecount = 1;};
				if ( $enmse_oddcount == 2 ) {
				 	$enmse_oddcount = 1;
				 } else {
				 	$enmse_oddcount = $enmse_oddcount+1;
				 }
			?>
				<div class="enmse-archive-thumb<?php if ( $enmse_middlecount == 2 ) { echo " middle"; } ?><?php if ( $enmse_oddcount == 1 ) { echo " odd"; } ?>">
					<?php if ( $enmse_s->graphic_thumb != null ) { ?><a href="<?php echo $enmse_thispage . '&amp;enmse_sid=' .  $enmse_s->series_id; ?>" title="&amp;enmse_sid=<?php echo $enmse_s->series_id; ?>" class="enmse-imgarchive-ajax"><img src="<?php echo $enmse_s->graphic_thumb; ?>" alt="<?php echo stripslashes($enmse_s->s_title); ?>" border="0" /></a><?php } else { ?><a href="<?php echo $enmse_thispage . '&amp;enmse_sid=' .  $enmse_s->series_id; ?>" title="&amp;enmse_sid=<?php echo $enmse_s->series_id; ?>" class="enmse-imgarchive-ajax"><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo stripslashes($enmse_s->s_title); ?>" border="0" /></a><?php } ?>
					<h4><?php echo stripslashes($enmse_s->s_title); ?></h4>
					<h5><?php echo date_i18n($enmse_dateformat, strtotime($enmse_s->start_date)); ?></h5>
					<p><?php $enmse_smm_count = 0; foreach ( $enmse_smm as $smm ) { ?><?php if ( $smm->series_id == $enmse_s->series_id ) { $enmse_smm_count = $enmse_smm_count+1; } ?><?php } ?><?php if ( $enmse_smm_count == 1 ) { echo "1 " . $enmsemessaget; } elseif ( $enmse_smm_count > 1 ) { echo $enmse_smm_count . " " . $enmsemessagetp; } ?></p>
					<p class="enmse-archive-link"><a href="<?php echo $enmse_thispage . '&amp;enmse_sid=' .  $enmse_s->series_id; ?>" title="&amp;enmse_sid=<?php echo $enmse_s->series_id; ?>" class="enmse-imgarchivetext-ajax">Explore This <?php echo $enmseseriest; ?></a></p>
				</div>
			<?php }; ?>
				<div style="clear: both"></div>
			</div>
			<?php } else { // Display Classic List Style Archive ?>
			<table class="enmse-archive-table" cellpadding="0" cellspacing="0">
			<?php $rowcycle = 'even'; $enmse_middlecount = 0; 
			foreach ($enmse_series as $enmse_s) { 
				if ( $enmse_middlecount < 3 ) {$enmse_middlecount = $enmse_middlecount+1;} else {$enmse_middlecount = 1;};
				if ($rowcycle == 'odd') {
					$rowcycle = 'even';
				} else {
					$rowcycle = 'odd';	
				} ?>
				<tr class="enmse-archive-<?php echo $rowcycle; ?>">
					<td class="enmse-archive-title-cell"><?php echo stripslashes($enmse_s->s_title); ?></td>
					<td class="enmse-archive-date-cell"><?php echo date_i18n($enmse_dateformat, strtotime($enmse_s->start_date)); ?></td>
					<td class="enmse-archive-count-cell"><?php $enmse_smm_count = 0; foreach ( $enmse_smm as $smm ) { ?><?php if ( $smm->series_id == $enmse_s->series_id ) { $enmse_smm_count = $enmse_smm_count+1; } ?><?php } ?><?php if ( $enmse_smm_count == 1 ) { echo "1 " . $enmsemessaget; } elseif ( $enmse_smm_count > 1 ) { echo $enmse_smm_count . " " . $enmsemessagetp; } ?></td>
					<td class="enmse-explore-cell"><a href="<?php echo $enmse_thispage . '&amp;enmse_sid=' .  $enmse_s->series_id; ?>" title="&amp;enmse_sid=<?php echo $enmse_s->series_id; ?>" class="enmse-archive-ajax">Explore This <?php echo $enmseseriest; ?></a></td>
				</tr>
			<?php }; ?>
			</table>
			<?php }; ?>
			<?php include('archivepagination.php'); ?>
	<?php // Deny access to sneaky people!
	} else {
		exit("Access Denied");
	} die(); ?>