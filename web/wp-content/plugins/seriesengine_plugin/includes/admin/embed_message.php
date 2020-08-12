<?php /* ----- Series Engine - Load the relevant message to embed ----- */
	
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
		
		$enmse_sid = strip_tags($_REQUEST['enmse_sid']);
		
		// Get All Messages
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d GROUP BY title ORDER BY date ASC"; 
		$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_sid );
		$enmse_messages = $wpdb->get_results( $enmse_sql );
		$enmse_message_count = $wpdb->num_rows;		
	
?>

<?php if ( $enmse_message_count > 0 ) { ?>
	<h2>...Choose a <?php echo $enmsemessaget; ?>...</h2>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Choose an Option:</th>
			<td><select name="enmse-embed-m" id="enmse-embed-m" size="1">
				<option value="">-- Select the <?php echo $enmsemessaget; ?> to Display --</option>
				<?php foreach ( $enmse_messages as $enmse_single ) { ?>
				<option value="<?php echo $enmse_single->message_id ?>"><?php echo stripslashes($enmse_single->title) ?></option>
				<?php } ?>
			</select>
			</td>
		</tr>
	</table><br />
<?php } else { ?>
	<h3 class="embed-error">There are no <?php echo $enmsemessagetp; ?> currently associated with that <?php echo $enmseseriest; ?>. Please choose another one.</h3>
<?php } ?>

<?php } else {
	exit("Access Denied");
} die(); ?>