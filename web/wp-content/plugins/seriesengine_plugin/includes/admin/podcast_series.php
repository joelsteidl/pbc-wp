<?php /* ----- Series Engine - Load Relevant Series for Podcast Generation ----- */
	
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

		global $wpdb;
		
		$enmse_stid = strip_tags($_REQUEST['enmse_stid']);
		
		if ( $enmse_stid == 0 ) {
			// Get All Series
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " ORDER BY start_date DESC"; 
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


	<?php if ( $enmse_series_count > 0 ) { ?>
	<th scope="row">...From the <?php echo $enmseseriest; ?>...:</th>
	<td>
		<select name="podcast_s" id="podcast_s">
			<?php foreach ( $enmse_series as $enmse_single ) { ?>
			<option value="<?php echo $enmse_single->series_id ?>"><?php echo stripslashes($enmse_single->s_title); ?></option>
			<?php } ?>
		</select>
	</td>
	<?php } else { ?>
	<th scope="row">...From the <?php echo $enmseseriest; ?>...:</th>
	<td>
		<p><strong>There are no <?php echo $enmseseriestp; ?> associated with this <?php echo $enmseseriest; ?> Type. Please choose another <?php echo $enmseseriest; ?> Type to continue.</strong></p>
		
	</td>
	<?php } ?>


<?php } else {
	exit("Access Denied");
} die(); ?>