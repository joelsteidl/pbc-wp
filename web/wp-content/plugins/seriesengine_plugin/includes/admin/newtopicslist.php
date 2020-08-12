<?php /* ----- Series Engine - Add a new topic straight from the Messages admin page ----- */
	
	if ( current_user_can( 'edit_pages' ) ) { 

		global $wpdb;
		

		$enmse_name = strip_tags($_REQUEST['topicname']);
		
		$enmse_find_highest = "SELECT sort_id FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id DESC LIMIT 1";
		$enmse_highest = $wpdb->get_row( $enmse_find_highest, OBJECT );
		
		if ( $enmse_highest == null ) {
			$enmse_sort_id = 1;
		} else {
			$enmse_makenumber = intval($enmse_highest->sort_id);
			$enmse_sort_id = $enmse_makenumber+1;
		}
		
		$enmse_newtopic = array(
			'name' => $enmse_name, 
			'sort_id' => $enmse_sort_id
			); 
		$wpdb->insert( $wpdb->prefix . "se_topics", $enmse_newtopic );

		$enmse_find_highest = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id DESC LIMIT 1";
		$enmse_newest = $wpdb->get_row( $enmse_find_highest, OBJECT );

	
?>
	<li><input name="topics[]" type="checkbox" value="<?php echo $enmse_newest->topic_id; ?>" checked="checked" class="check" /> <label for="topics[]"> <?php echo stripslashes($enmse_newest->name); ?></label></li>
<?php } else {
	exit("Access Denied");
} die(); ?>