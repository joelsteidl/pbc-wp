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
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
			$enmse_topics = $wpdb->get_results( $enmse_preparredsql );
			$enmse_topic_count = $wpdb->num_rows;
		} else {
			// Get All Topics
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND message_id IS NOT NULL GROUP BY name ORDER BY sort_id ASC";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid );
			$enmse_topics = $wpdb->get_results( $enmse_sql );
			$enmse_topic_count = $wpdb->num_rows;
		}
		
	
?>

<?php if ( $enmse_topic_count > 0 ) { ?>
	<h2>...Choose a <?php echo $enmsetopict; ?>...</h2>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Choose an Option:</th>
			<td><select name="enmse-embed-t" id="enmse-embed-t" size="1">
				<option value="">-- Select the <?php echo $enmsetopict; ?> to Display --</option>
				<?php foreach ( $enmse_topics as $enmse_single ) { ?>
				<option value="<?php echo $enmse_single->topic_id ?>"><?php echo stripslashes($enmse_single->name) ?></option>
				<?php } ?>
			</select>
			</td>
		</tr>
	</table><br />
<?php } else { ?>
	<h3 class="embed-error">There are no <?php echo $enmsemessagetp; ?> with <?php echo $enmsetopictp; ?> assigned to your chosen <?php echo $enmseseriest; ?> Type. Please choose a different one.</h3>
<?php } ?>

<?php } else {
	exit("Access Denied");
} die(); ?>