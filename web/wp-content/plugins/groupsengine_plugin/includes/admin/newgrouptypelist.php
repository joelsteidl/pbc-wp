<?php /* ----- Groups Engine - Add a new group type straight from the Groups admin page ----- */
	
	if ( current_user_can( 'edit_posts' ) ) { 

		global $wpdb;
		
			$enmge_title = strip_tags($_REQUEST['grouptypetitle']);
			
			$enmge_newgrouptype = array(
				'group_type_title' => $enmge_title
				); 
			$wpdb->insert( $wpdb->prefix . "ge_group_types", $enmge_newgrouptype );

			$enmge_find_highest = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_id DESC LIMIT 1";
			$enmge_newest = $wpdb->get_row( $enmge_find_highest, OBJECT );
	
?>
		<li><input name="grouptypes[]" type="checkbox" value="<?php echo $enmge_newest->group_type_id; ?>" checked="checked" class="check" /> <label for="grouptypes[]"> <?php echo $enmge_newest->group_type_title; ?></label></li>
<?php } else {
	exit("Access Denied");
} die(); ?>