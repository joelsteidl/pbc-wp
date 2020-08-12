<?php /* ----- Series Engine - Choose relevant Series Type to embed ----- */
	
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
		
		$enmse_options = get_option( 'enm_seriesengine_options' ); 
		$enmse_primaryst = $enmse_options['primaryst'];
		
		// Get All Series
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
		$enmse_series_types = $wpdb->get_results( $enmse_preparredsql );
		
	
?>


<h2>...Choose a <?php echo $enmseseriest; ?> Type...</h2>
<p>You can load content from all <?php echo $enmseseriest; ?> Types, or limit all content and searches to a specific <?php echo $enmseseriest; ?> Type for this shortcode.</p>
<table class="form-table">
	<tr valign="top">
		<th scope="row">Choose an Option:</th>
		<td><select name="enmse-embed-st" id="enmse-embed-st" size="1">
			<option value="-1">-- Select the <?php echo $enmseseriest; ?> Type to Search Within --</option>
			<option value="0">All <?php echo $enmseseriest; ?> Types</option>
			<?php foreach ( $enmse_series_types as $enmse_single ) { ?>
			<option value="<?php echo $enmse_single->series_type_id ?>"><?php echo stripslashes($enmse_single->name) ?><?php if ( $enmse_primaryst == $enmse_single->series_type_id ) { echo " (Primary)"; }; ?></option>
			<?php } ?>
		</select>
		</td>
	</tr>
</table><br />


<?php } else {
	exit("Access Denied");
} die(); ?>