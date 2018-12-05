<?php /* ----- Series Engine - Add a new topic straight from the Messages admin page ----- */
	
	require_once( '../loadwpfiles.php' );
	header('HTTP/1.1 200 OK');
	
	if ( current_user_can( 'edit_pages' ) ) { 

		global $wpdb;
		
		if ( $_POST ) {
			$enmse_name = strip_tags($_GET['topicname']);
			
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
		} else {
			$enmse_find_highest = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id DESC LIMIT 1";
			$enmse_newest = $wpdb->get_row( $enmse_find_highest, OBJECT );
		}
	
?>
<?php if ($_POST) { ?>
<?php } else { ?>
		<li><input name="topics[]" type="checkbox" value="<?php echo $enmse_newest->topic_id; ?>" checked="checked" class="check" /> <label for="topics[]"> <?php echo stripslashes($enmse_newest->name); ?></label></li>
<?php } ?>
<?php } else {
	exit("Access Denied");
} ?>