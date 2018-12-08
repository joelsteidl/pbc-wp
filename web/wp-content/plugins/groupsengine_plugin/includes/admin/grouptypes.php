<?php /* ----- Groups Engine - Add, edit and remove Group Types ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		
		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		$enmge_grouptypetitle = $enmge_options['grouptypetitle'];
		$enmge_grouptypeptitle = $enmge_options['grouptypeptitle'];
		$enmge_grouptitle = $enmge_options['grouptitle'];
		$enmge_groupptitle = $enmge_options['groupptitle']; 
		
		$enmge_errors = array(); //Set up errors array
		$enmge_messages = array(); //Set up messages array
		
		if ( $_POST && isset($_GET['enmge_did']) ) { // If deleting a group type
			$enmge_deleted_id = strip_tags($_POST['group_type_delete']);
			$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_types" . " WHERE group_type_id=%d";
			$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_deleted_id ); 
			$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
			
			$enmge_sgtdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_group_type_matches" . " WHERE group_type_id=%d";
			$enmge_sgtdelete_query = $wpdb->prepare( $enmge_sgtdelete_query_preparred, $enmge_deleted_id ); 
			$enmge_sgtdeleted = $wpdb->query( $enmge_sgtdelete_query );
			
			$enmge_messages[] = "The " . stripslashes($enmge_grouptypetitle) . " was successfully deleted.";
		}
		
		if ( isset($_GET['enmge_action']) ) {
			$enmge_single_created = null;

			if ( $_GET['enmge_action'] == 'edit' ) { // Edit Group Type
				$enmge_userdetails = wp_get_current_user(); 

				if ( $_POST ) {

					if (empty($_POST['group_type_title'])) { 
						$enmge_errors[] = '- You must name the ' . stripslashes($enmge_grouptypetitle) . '.';
					} else {
						$enmge_title = strip_tags($_POST['group_type_title']);
					}
					
					
					if (empty($enmge_errors)) {
						if ( isset($_GET['enmge_gtid']) && is_numeric($_GET['enmge_gtid']) ) {
							$enmge_gtid = strip_tags($_GET['enmge_gtid']);
						}
						
						$enmge_new_values = array( 'group_type_title' => $enmge_title  ); 
						$enmge_where = array( 'group_type_id' => $enmge_gtid ); 
						$wpdb->update( $wpdb->prefix . "ge_group_types", $enmge_new_values, $enmge_where ); 
						$enmge_messages[] = stripslashes($enmge_grouptypetitle) . " successfully updated!";

						$enmge_findthegrouptypesql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " WHERE group_type_id = %d"; 
						$enmge_findthegrouptype = $wpdb->prepare( $enmge_findthegrouptypesql, $enmge_gtid );
						$enmge_single = $wpdb->get_row( $enmge_findthegrouptype, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;


					} else {
						if ( isset($_GET['enmge_gtid']) && is_numeric($_GET['enmge_gtid']) ) {
							$enmge_gtid = strip_tags($_GET['enmge_gtid']);
						}
						
						$enmge_findthegrouptypesql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " WHERE group_type_id = %d"; 
						$enmge_findthegrouptype = $wpdb->prepare( $enmge_findthegrouptypesql, $enmge_gtid );
						$enmge_single = $wpdb->get_row( $enmge_findthegrouptype, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;

					}

					
				} else {
					if ( isset($_GET['enmge_gtid']) && is_numeric($_GET['enmge_gtid']) ) {
						$enmge_gtid = strip_tags($_GET['enmge_gtid']);
					}

					$enmge_findthegrouptypesql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " WHERE group_type_id = %d"; 
					$enmge_findthegrouptype = $wpdb->prepare( $enmge_findthegrouptypesql, $enmge_gtid );
					$enmge_single = $wpdb->get_row( $enmge_findthegrouptype, OBJECT );
					$enmge_singlecount = $wpdb->num_rows;
					
				}	
			}
			
			if ( $_GET['enmge_action'] == 'new' && !isset($_GET['enmge_did']) ) { // New Group Type
				
				$enmge_userdetails = wp_get_current_user(); 
				
				if ( $_POST ) {
					
					if (empty($_POST['group_type_title'])) { 
						$enmge_errors[] = '- You must name the ' . stripslashes($enmge_grouptypetitle) . '.';
					} else {
						$enmge_title = strip_tags($_POST['group_type_title']);
					}					
					
					if (empty($enmge_errors)) {

						$enmge_single_created = "yes";

						$enmge_newgrouptype = array(
							'group_type_title' => $enmge_title
							); 
						$wpdb->insert( $wpdb->prefix . "ge_group_types", $enmge_newgrouptype );
						$enmge_new_group_type_id = $wpdb->insert_id; 
						
						$enmge_messages[] = "You have successfully added a new " . stripslashes($enmge_grouptypetitle) . " to Groups Engine!";
					} else {
						
					}
				}

			}
		}
		
		// Get All topics
		$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_id ASC"; 
		$enmge_grouptypes = $wpdb->get_results( $enmge_preparredsql );

		// Get All Group Group Type Matches
		$enmge_preparredggtmsql = "SELECT group_id, group_type_id FROM " . $wpdb->prefix . "ge_group_group_type_matches"; 
		$enmge_ggtm = $wpdb->get_results( $enmge_preparredggtmsql );
		

	} else {
		exit("Access Denied");
	}
	
?>

<div class="wrap"> 
<?php if ( isset($_GET['enmge_action']) && ( $enmge_single_created == null && !isset($_GET['enmge_did']) ) ) { if ( $_GET['enmge_action'] == 'new' ) { // If they're adding a new Group Type ?>
		<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
		<script type="text/javascript">
			jQuery(document).ready(function() {
				
			});
		</script>

		<h2 class="enmge">Add a New <?php echo stripslashes($enmge_grouptypetitle); ?></h2>
		<?php include ('errorbox.php'); ?>
		<p>Complete the information below to add a new <?php echo stripslashes($enmge_grouptypetitle); ?> to Groups Engine. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-grouptypes"; ?>">User Guide</a>.</p>
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Title:</strong></th>
					<td><input id='group_type_title' name='group_type_title' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_type_title']);} ?>" tabindex="1" /></td>
				</tr>
			</table>
		</div>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add <?php echo stripslashes($enmge_grouptypetitle); ?>" tabindex="2" /></p>
	</form>	

		<p><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_grouptypes', __FILE__ ) ?>">&laquo; All <?php echo stripslashes($enmge_grouptypeptitle); ?></a></p>
		<?php include ('gecredits.php'); ?>
<?php } elseif ( ($_GET['enmge_action'] == 'edit') && ( $enmge_singlecount == 1 ) ) { // Edit Location ?>
	<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
	<script type="text/javascript">
		jQuery(document).ready(function() {
			
		});
	</script>
	<h2 class="enmge">Edit <?php echo stripslashes($enmge_grouptypetitle); ?> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_grouptypes&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Modify the information below to adjust how the <?php echo stripslashes($enmge_grouptypetitle); ?> appears in Groups Engine. Changing the title will not change its association with any <?php echo stripslashes($enmge_groupptitle); ?>. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-grouptypes"; ?>">User Guide</a>.</p>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Title:</strong></th>
					<td><input id='group_type_title' name='group_type_title' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_type_title']);} else {echo stripslashes($enmge_single->group_type_title);} ?>" tabindex="1" /></td>
				</tr>
			</table>
		</div>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Update <?php echo stripslashes($enmge_grouptypetitle); ?>" tabindex="2" /></p>
		<input type="hidden" name="enmgegtid" value="<?php echo $enmge_single->group_type_id; ?>" id="enmgegtid" />
	</form>
	

	<p><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_grouptypes', __FILE__ ) ?>">&laquo; All <?php echo stripslashes($enmge_grouptypeptitle); ?></a></p>
	<?php include ('gecredits.php'); ?>
<?php }} else { // Display the main listing of Locations ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/deletegrouptypes.js'; ?>"></script>

	<h2 class="enmge">Create and Edit <?php echo stripslashes($enmge_grouptypeptitle); ?> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_grouptypes&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>

	<p>Click a <?php echo stripslashes($enmge_grouptypetitle); ?> title below to edit the <?php echo stripslashes($enmge_grouptypetitle); ?>. Click the number of <?php echo stripslashes($enmge_groupptitle); ?> to view a list of <?php echo stripslashes($enmge_groupptitle); ?> currently associated with the <?php echo stripslashes($enmge_grouptypetitle); ?>. Click "Add New" above to add a new <?php echo stripslashes($enmge_grouptypetitle); ?> to Groups Engine. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-grouptypes"; ?>">User Guide</a>.</p>
	
	<?php // include ('grouppagination.php'); ?>
	<table class="widefat"> 
		<thead> 
			<tr> 
				<th>Title</th> 
				<th>Num. <?php echo stripslashes($enmge_groupptitle); ?></th> 
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmge_grouptypes as $enmge_single ) { ?>
			<tr>
				<td><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_grouptypes&amp;enmge_action=edit&amp;enmge_gtid=' . $enmge_single->group_type_id, __FILE__ ); ?>"><?php echo stripslashes($enmge_single->group_type_title) ?></a></td>
				<td><?php $enmge_ggtm_count = 0; foreach ( $enmge_ggtm as $ggtm ) { ?><?php if ( $ggtm->group_type_id == $enmge_single->group_type_id ) { $enmge_ggtm_count = $enmge_ggtm_count+1; } ?><?php } ?><?php if ( $enmge_ggtm_count > 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_gtid=' . $enmge_single->group_type_id, __FILE__ ) . "\">" . $enmge_ggtm_count . " " . stripslashes($enmge_groupptitle) . "</a>";} elseif ( $enmge_ggtm_count == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_gtid=' . $enmge_single->group_type_id, __FILE__ ) . "\">1 " . stripslashes($enmge_grouptitle) . "</a>"; } ?></td>				
				<td class="enmge-delete"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmge_did=1" method="post" id="groupsengine-deleteform<?php echo $enmge_single->group_type_id ?>"><input type="hidden" name="group_type_delete" value="<?php echo $enmge_single->group_type_id ?>"></form><a href="#" class="groupsengine_delete" name="<?php echo $enmge_single->group_type_id ?>">Delete</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php include ('gecredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
