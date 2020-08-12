<?php /* ----- Series Engine - Add a new speaker straight from the Messages admin page ----- */
    
	if ( current_user_can( 'edit_pages' ) ) { 

		// ***** Get Labels
		$enmse_options = get_option( 'enm_seriesengine_options' ); 

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

		global $wpdb;


		$enmse_first_name = strip_tags($_REQUEST['firstname']);
		$enmse_last_name = strip_tags($_REQUEST['lastname']);

		$enmse_newspeaker = array(
			'first_name' => $enmse_first_name, 
			'last_name' => $enmse_last_name
			); 
		$wpdb->insert( $wpdb->prefix . "se_speakers", $enmse_newspeaker );

		$enmse_find_highest = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY speaker_id DESC LIMIT 1";
		$enmse_newest = $wpdb->get_row( $enmse_find_highest, OBJECT );
		
		// Get All Speakers
		$enmse_preparredspsql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY last_name ASC"; 
		$enmse_sp = $wpdb->get_results( $enmse_preparredspsql );


?>
	<option value="0">- Select a <?php echo $enmsespeakert; ?> -</option>
	<?php foreach ($enmse_sp as $sp) {  ?>
	<option value="<?php echo $sp->speaker_id; ?>" <?php if ($enmse_newest->speaker_id == $sp->speaker_id) { ?>selected="selected"<?php } ?>><?php echo stripslashes($sp->first_name) . " " . stripslashes($sp->last_name); ?></option>
	<?php } ?>
	<option value="0">-----------------</option>
	<option value="n">Add a New <?php echo $enmsespeakert; ?></option>
<?php } else {
	exit("Access Denied");
} die(); ?>