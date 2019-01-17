<?php /* ----- Groups Engine - Add a new leader straight from the Groups admin page ----- */

	require_once( '../loadwpfiles.php' );
	header('HTTP/1.1 200 OK');

	if ( current_user_can( 'edit_posts' ) ) { 

		// ***** Get Labels
		$enmge_options = get_option( 'enm_groupsengine_options' ); 

		global $wpdb;

		if ( $_POST ) {
			$enmge_leader_name = strip_tags($_POST['leader_name']);
			$enmge_leader_email = strip_tags($_POST['leader_email']);
			$enmge_leader_username = $_POST['leader_username'];
			$enmge_group_id = $_GET['group_id'];

			$enmge_newleader = array(
				'leader_name' => $enmge_leader_name, 
				'leader_email' => $enmge_leader_email,
				'leader_username' => $enmge_leader_username
				); 
			$wpdb->insert( $wpdb->prefix . "ge_leaders", $enmge_newleader );
			$enmge_new_leader_id = $wpdb->insert_id; 
			
			// Add file relation in the DB
			$enmge_newglm = array(
				'group_id' => $enmge_group_id, 
				'leader_id' => $enmge_new_leader_id
			); 
			$wpdb->insert( $wpdb->prefix . "ge_group_leader_matches", $enmge_newglm );
		} else {
			$enmge_group_id = $_GET['group_id'];
			$enmge_leader_username = $_GET['leader_username'];
			
			if ( $enmge_group_id > 0 ) {
				// Get All Files
				$enmge_preparredlsql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
				$enmge_lsql = $wpdb->prepare( $enmge_preparredlsql, $enmge_group_id );
				$enmge_leaders = $wpdb->get_results( $enmge_lsql );
			} else {
				// Get All Files
				$enmge_preparredlsql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d AND leader_username = %d GROUP BY leader_id"; 
				$enmge_lsql = $wpdb->prepare( $enmge_preparredlsql, $enmge_group_id, $enmge_leader_username );
				$enmge_leaders = $wpdb->get_results( $enmge_lsql );
			}
			
		}

?>
<?php if ($_POST) { ?>
<?php } else { ?>
	<?php if ( isset($_GET['done']) ) { ?>
		<table cellpadding="0" cellspacing="0" class="leadertable"> 
		<?php foreach ($enmge_leaders as $leader) {  ?>
			<tr id="lrow_<?php echo $leader->leader_id; ?>">
				<td><?php echo $leader->leader_name; ?></td>
				<td>(<em><?php echo $leader->leader_email; ?></em>)</td>
				<td class="enmge-delete"><a href="#" class="groupsengine_leaderdelete" name="<?php echo $leader->leader_id; ?>">(X)</a></td>				
			</tr>
		<?php } ?>
		</table>
	<?php } else { ?>
		<table cellpadding="0" cellspacing="0" class="leadertable"> 
		<?php foreach ($enmge_leaders as $leader) {  ?>
			<tr id="lrow_<?php echo $leader->leader_id; ?>">
				<td><?php echo $leader->leader_name; ?></td>
				<td>(<em><?php echo $leader->leader_email; ?></em>)</td>
				<td class="enmge-delete"><a href="#" class="groupsengine_leaderdelete" name="<?php echo $leader->leader_id; ?>">(X)</a></td>				
			</tr>
		<?php } ?>
		</table>
	<?php } ?>
<?php } ?>
<?php } else {
	exit("Access Denied");
} ?>