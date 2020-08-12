<?php /* ----- Groups Engine - Find a Group for Contacts ----- */
	
	if ( current_user_can( 'edit_pages' ) ) { 

		global $wpdb;

		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		$enmge_grouptitle = $enmge_options['grouptitle'];
		$enmge_groupptitle = $enmge_options['groupptitle']; 
		
		$enmge_gt = strip_tags($_REQUEST['enmge_gtid']);

		if ( $enmge_gt != 0 ) {
			$enmge_preparredsql = "SELECT group_id, group_title FROM " . $wpdb->prefix . "ge_groups" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_id) WHERE group_type_id = %d GROUP BY group_id ORDER BY group_id DESC"; 
			$enmge_sql = $wpdb->prepare( $enmge_preparredsql, $enmge_gt );
			$enmge_groups = $wpdb->get_results( $enmge_sql );
		} else {
			$enmge_preparredsql = "SELECT group_id, group_title FROM " . $wpdb->prefix . "ge_groups ORDER BY group_id DESC"; 
			$enmge_groups = $wpdb->get_results( $enmge_preparredsql );
		}
		
	
?>
<br /><select id='contact_group_id' name='contact_group_id' tabindex="6">
	<option value="0">- Choose a <?php echo stripslashes($enmge_grouptitle); ?> -</option>
	<?php foreach ( $enmge_groups as $g ) { ?>
	<option value="<?php echo $g->group_id; ?>"><?php echo stripslashes($g->group_title); ?></option>
	<?php } ?>
</select>
<?php } else {
	exit("Access Denied");
} die(); ?>