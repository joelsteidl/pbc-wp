<?php /* ----- Groups Engine - Add a new topic straight from the Groups admin page ----- */
	
	require_once( '../loadwpfiles.php' );
	header('HTTP/1.1 200 OK');
	
	if ( current_user_can( 'edit_posts' ) ) { 

		global $wpdb;
		
		if ( $_POST ) {
			$enmge_name = strip_tags($_GET['topicname']);
			
			$enmge_newtopic = array(
				'topic_name' => $enmge_name
				); 
			$wpdb->insert( $wpdb->prefix . "ge_topics", $enmge_newtopic );
		} else {
			$enmge_find_highest = "SELECT * FROM " . $wpdb->prefix . "ge_topics" . " ORDER BY topic_id DESC LIMIT 1";
			$enmge_newest = $wpdb->get_row( $enmge_find_highest, OBJECT );
		}
	
?>
<?php if ($_POST) { ?>
<?php } else { ?>
		<li><input name="topics[]" type="checkbox" value="<?php echo $enmge_newest->topic_id; ?>" checked="checked" class="check" /> <label for="topics[]"> <?php echo $enmge_newest->topic_name; ?></label></li>
<?php } ?>
<?php } else {
	exit("Access Denied");
} ?>