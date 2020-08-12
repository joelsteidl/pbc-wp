<?php /* ----- Series Engine - Choose relevant series to embed ----- */
	
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
		
		$enmse_stid = strip_tags($_REQUEST['enmse_stid']);
		
		$enmse_message = 0;
		if ( isset($_REQUEST['enmse_message']) ) {
			$enmse_message = 1;
		}
		
		if ( $enmse_stid == 0 ) {
			// Get All Series
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " WHERE archived = 0 ORDER BY start_date DESC"; 
			$enmse_series = $wpdb->get_results( $enmse_preparredsql );
			$enmse_series_count = $wpdb->num_rows;
		} else {
			// Get All Series
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND archived = 0 GROUP BY s_title ORDER BY start_date DESC"; 
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid );
			$enmse_series = $wpdb->get_results( $enmse_sql );
			$enmse_series_count = $wpdb->num_rows;
		}
		
	
?>

<?php if ( $enmse_message == 0 ) { ?>
	<?php if ( $enmse_series_count > 0 ) { ?>
		<h2>...Choose a <?php echo $enmseseriest; ?>...</h2>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Choose an Option:</th>
				<td><select name="enmse-embed-s" id="enmse-embed-s" size="1">
					<option value="">-- Select the <?php echo $enmseseriest; ?> to Display --</option>
					<?php foreach ( $enmse_series as $enmse_single ) { ?>
					<option value="<?php echo $enmse_single->series_id ?>"><?php echo stripslashes($enmse_single->s_title) ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
		</table><br />
	<?php } else { ?>
		<h3 class="embed-error">There are no <?php echo $enmseseriestp; ?> currently associated with that <?php echo $enmseseriest; ?> Type. Please choose another one.</h3>
	<?php } ?>
<?php } elseif ( $enmse_message == 1 ) { ?>
	<?php if ( $enmse_series_count > 0 ) { ?>
		<h2>...Select the Relevant <?php echo $enmseseriest; ?>...</h2>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Choose an Option:</th>
				<td><select name="enmse-embed-ms" id="enmse-embed-ms" size="1">
					<option value="0">-- Select a <?php echo $enmseseriest; ?> to Find a <?php echo $enmsemessaget; ?> --</option>
					<?php foreach ( $enmse_series as $enmse_single ) { ?>
					<option value="<?php echo $enmse_single->series_id ?>"><?php echo stripslashes($enmse_single->s_title) ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
		</table><br />
	<?php } else { ?>
		<h3 class="embed-error">There are no <?php echo $enmseseriestp; ?> currently associated with that <?php echo $enmseseriest; ?> Type. Please choose another one.</h3>
	<?php } ?>
<?php } ?>


<?php } else {
	exit("Access Denied");
} die(); ?>