<?php /* ----- Series Engine - Choose relevant topic to embed ----- */
	
	if ( current_user_can( 'edit_pages' ) ) { 

		// ***** Get Labels
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

		global $wpdb;

		$enmse_stid = strip_tags($_REQUEST['enmse_stid']);

		if ( $enmse_stid == 0 ) {
			// Get All Topics
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name ASC"; 
			$enmse_speakers = $wpdb->get_results( $enmse_preparredsql );
			$enmse_speaker_count = $wpdb->num_rows;
		} else {
			// Get All Topics
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND message_id IS NOT NULL GROUP BY speaker_id ORDER BY last_name ASC";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid );
			$enmse_speakers = $wpdb->get_results( $enmse_sql );
			$enmse_speaker_count = $wpdb->num_rows;
		}


?>

<?php if ( $enmse_speaker_count > 0 ) { ?>
	<h2>...Choose a <?php echo $enmsespeakert; ?>...</h2>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Choose an Option:</th>
			<td><select name="enmse-embed-sp" id="enmse-embed-sp" size="1">
				<option value="">-- Select the <?php echo $enmsespeakert; ?> to Display --</option>
				<?php foreach ( $enmse_speakers as $enmse_single ) { ?>
				<option value="<?php echo $enmse_single->speaker_id ?>"><?php echo stripslashes($enmse_single->first_name) . " " . stripslashes($enmse_single->last_name); ?></option>
				<?php } ?>
			</select>
			</td>
		</tr>
	</table><br />
<?php } else { ?>
	<h3 class="embed-error">There are no <?php echo $enmsemessagetp; ?> with <?php echo $enmsespeakertp; ?> assigned to your chosen <?php echo $enmseseriest; ?> Type. Please choose a different one.</h3>
<?php } ?>

<?php } else {
	exit("Access Denied");
} die(); ?>