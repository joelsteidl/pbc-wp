<?php /* ----- Groups Engine - Add a new topic straight from the Groups admin page ----- */
	
	if ( current_user_can( 'edit_posts' ) ) { 

		global $wpdb;
		
		$enmge_name = strip_tags($_REQUEST['topicname']);
		
		$enmge_newtopic = array(
			'topic_name' => $enmge_name
			); 
		$wpdb->insert( $wpdb->prefix . "ge_topics", $enmge_newtopic );

		$enmge_find_highest = "SELECT * FROM " . $wpdb->prefix . "ge_topics" . " ORDER BY topic_id DESC LIMIT 1";
		$enmge_newest = $wpdb->get_row( $enmge_find_highest, OBJECT );
	
?>
		<li><input name="topics[]" type="checkbox" value="<?php echo $enmge_newest->topic_id; ?>" checked="checked" class="check" /> <label for="topics[]"> <?php echo $enmge_newest->topic_name; ?></label></li>
<?php } else {
	exit("Access Denied");
} die(); ?>