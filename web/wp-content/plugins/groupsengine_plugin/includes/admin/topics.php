<?php /* ----- Groups Engine - Add, edit and remove Topics ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		
		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		$enmge_topictitle = $enmge_options['topictitle'];
		$enmge_topicptitle = $enmge_options['topicptitle'];
		$enmge_grouptitle = $enmge_options['grouptitle'];
		$enmge_groupptitle = $enmge_options['groupptitle'];
		
		$enmge_errors = array(); //Set up errors array
		$enmge_messages = array(); //Set up messages array
		
		if ( $_POST && isset($_GET['enmge_did']) ) { // If deleting a topic
			$enmge_deleted_id = strip_tags($_POST['topic_delete']);
			$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_topics" . " WHERE topic_id=%d";
			$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_deleted_id ); 
			$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
			
			$enmge_stdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_topic_matches" . " WHERE topic_id=%d";
			$enmge_stdelete_query = $wpdb->prepare( $enmge_stdelete_query_preparred, $enmge_deleted_id ); 
			$enmge_stdeleted = $wpdb->query( $enmge_stdelete_query );
			
			$enmge_messages[] = "The " . stripslashes($enmge_topictitle) . " was successfully deleted.";
		}
		
		if ( isset($_GET['enmge_action']) ) {
			$enmge_single_created = null;

			if ( $_GET['enmge_action'] == 'edit' ) { // Edit Location
				$enmge_userdetails = wp_get_current_user(); 

				if ( $_POST ) {

					if (empty($_POST['topic_name'])) { 
						$enmge_errors[] = '- You must name the ' . stripslashes($enmge_topictitle) . '.';
					} else {
						$enmge_name = strip_tags($_POST['topic_name']);
					}
					
					
					if (empty($enmge_errors)) {
						if ( isset($_GET['enmge_tid']) && is_numeric($_GET['enmge_tid']) ) {
							$enmge_tid = strip_tags($_GET['enmge_tid']);
						}
						
						$enmge_new_values = array( 'topic_name' => $enmge_name  ); 
						$enmge_where = array( 'topic_id' => $enmge_tid ); 
						$wpdb->update( $wpdb->prefix . "ge_topics", $enmge_new_values, $enmge_where ); 
						$enmge_messages[] = stripslashes($enmge_topictitle) . " successfully updated!";

						$enmge_findthetopicsql = "SELECT * FROM " . $wpdb->prefix . "ge_topics" . " WHERE topic_id = %d"; 
						$enmge_findthetopic = $wpdb->prepare( $enmge_findthetopicsql, $enmge_tid );
						$enmge_single = $wpdb->get_row( $enmge_findthetopic, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;


					} else {
						if ( isset($_GET['enmge_tid']) && is_numeric($_GET['enmge_tid']) ) {
							$enmge_tid = strip_tags($_GET['enmge_tid']);
						}
						
						$enmge_findthetopicsql = "SELECT * FROM " . $wpdb->prefix . "ge_topics" . " WHERE topic_id = %d"; 
						$enmge_findthetopic = $wpdb->prepare( $enmge_findthetopicsql, $enmge_tid );
						$enmge_single = $wpdb->get_row( $enmge_findthetopic, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;

					}

					
				} else {
					if ( isset($_GET['enmge_tid']) && is_numeric($_GET['enmge_tid']) ) {
						$enmge_tid = strip_tags($_GET['enmge_tid']);
					}

					$enmge_findthetopicsql = "SELECT * FROM " . $wpdb->prefix . "ge_topics" . " WHERE topic_id = %d"; 
					$enmge_findthetopic = $wpdb->prepare( $enmge_findthetopicsql, $enmge_tid );
					$enmge_single = $wpdb->get_row( $enmge_findthetopic, OBJECT );
					$enmge_singlecount = $wpdb->num_rows;
					
				}	
			}
			
			if ( $_GET['enmge_action'] == 'new' && !isset($_GET['enmge_did']) ) { // New Topic
				
				$enmge_userdetails = wp_get_current_user(); 
				
				if ( $_POST ) {
					
					if (empty($_POST['topic_name'])) { 
						$enmge_errors[] = '- You must name the topic.';
					} else {
						$enmge_name = strip_tags($_POST['topic_name']);
					}					
					
					if (empty($enmge_errors)) {

						$enmge_single_created = "yes";

						$enmge_newtopic = array(
							'topic_name' => $enmge_name
							); 
						$wpdb->insert( $wpdb->prefix . "ge_topics", $enmge_newtopic );
						$enmge_new_topic_id = $wpdb->insert_id; 
						
						$enmge_messages[] = "You have successfully added a new " . stripslashes($enmge_topictitle) . " to Groups Engine!";
					} else {
						
					}
				}

			}
		}
		
		// Get All topics
		$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_topics" . " ORDER BY topic_id ASC"; 
		$enmge_topics = $wpdb->get_results( $enmge_preparredsql );

		// Get All Group Topic Matches
		$enmge_preparredgtmsql = "SELECT group_id, topic_id FROM " . $wpdb->prefix . "ge_group_topic_matches"; 
		$enmge_gtm = $wpdb->get_results( $enmge_preparredgtmsql );
		

	} else {
		exit("Access Denied");
	}
	
?>

<div class="wrap"> 
<?php if ( isset($_GET['enmge_action']) && ( $enmge_single_created == null && !isset($_GET['enmge_did']) ) ) { if ( $_GET['enmge_action'] == 'new' ) { // If they're adding a new Location ?>
		<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
		<script type="text/javascript">
			jQuery(document).ready(function() {
				
			});
		</script>

		<h2 class="enmge">Add a New <?php echo stripslashes($enmge_topictitle); ?></h2>
		<?php include ('errorbox.php'); ?>
		<p>Complete the information below to add a new <?php echo stripslashes($enmge_topictitle); ?> to Groups Engine. The <?php echo stripslashes($enmge_topictitle); ?> will not appear in the Groups Engine browser unless it's associated with a <?php echo stripslashes($enmge_grouptitle); ?>. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-topics"; ?>">User Guide</a>.</p>
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Name:</strong></th>
					<td><input id='topic_name' name='topic_name' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['topic_name']);} ?>" tabindex="1" /></td>
				</tr>
			</table>
		</div>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add <?php echo stripslashes($enmge_topictitle); ?>" tabindex="2" /></p>
	</form>	

		<p><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_topics', __FILE__ ) ?>">&laquo; All <?php echo stripslashes($enmge_topicptitle); ?></a></p>
		<?php include ('gecredits.php'); ?>
<?php } elseif ( ($_GET['enmge_action'] == 'edit') && ( $enmge_singlecount == 1 ) ) { // Edit Location ?>
	<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
	<script type="text/javascript">
		jQuery(document).ready(function() {
			
		});
	</script>
	<h2 class="enmge">Edit <?php echo stripslashes($enmge_topictitle); ?> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_topics&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Modify the information below to change how the <?php echo stripslashes($enmge_topictitle); ?> appears in Groups Engine. Renaming a <?php echo stripslashes($enmge_topictitle); ?> will not change its association with any <?php echo stripslashes($enmge_groupptitle); ?>. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-topics"; ?>">User Guide</a>.</p>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Name:</strong></th>
					<td><input id='topic_name' name='topic_name' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['topic_name']);} else {echo stripslashes($enmge_single->topic_name);} ?>" tabindex="1" /></td>
				</tr>
			</table>
		</div>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Update <?php echo stripslashes($enmge_topictitle); ?>" tabindex="2" /></p>
		<input type="hidden" name="enmgetid" value="<?php echo $enmge_single->topic_id; ?>" id="enmgetid" />
	</form>
	

	<p><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_topics', __FILE__ ) ?>">&laquo; All <?php echo stripslashes($enmge_topicptitle); ?></a></p>
	<?php include ('gecredits.php'); ?>
<?php }} else { // Display the main listing of Locations ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/deletetopic.js'; ?>"></script>

	<h2 class="enmge">Create and Edit <?php echo stripslashes($enmge_topicptitle); ?> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_topics&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>

	<p>Click a <?php echo stripslashes($enmge_topictitle); ?> name below to edit the <?php echo stripslashes($enmge_topictitle); ?>. Click the number of <?php echo stripslashes($enmge_groupptitle); ?> to view a list of <?php echo stripslashes($enmge_groupptitle); ?> currently associated with the <?php echo stripslashes($enmge_topictitle); ?>. Click "Add New" above to add a new <?php echo stripslashes($enmge_topictitle); ?> to Groups Engine. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-topics"; ?>">User Guide</a>.</p>
	
	<table class="widefat"> 
		<thead> 
			<tr> 
				<th>Name</th> 
				<th>Num. <?php echo stripslashes($enmge_groupptitle); ?></th> 
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmge_topics as $enmge_single ) { ?>
			<tr>
				<td><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_topics&amp;enmge_action=edit&amp;enmge_tid=' . $enmge_single->topic_id, __FILE__ ); ?>"><?php echo stripslashes($enmge_single->topic_name) ?></a></td>
				<td><?php $enmge_gtm_count = 0; foreach ( $enmge_gtm as $gtm ) { ?><?php if ( $gtm->topic_id == $enmge_single->topic_id ) { $enmge_gtm_count = $enmge_gtm_count+1; } ?><?php } ?><?php if ( $enmge_gtm_count > 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_tid=' . $enmge_single->topic_id, __FILE__ ) . "\">" . $enmge_gtm_count . " " . stripslashes($enmge_groupptitle) . "</a>";} elseif ( $enmge_gtm_count == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_tid=' . $enmge_single->topic_id, __FILE__ ) . "\">1 " . stripslashes($enmge_grouptitle) . "</a>"; } ?></td>				
				<td class="enmge-delete"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmge_did=1" method="post" id="groupsengine-deleteform<?php echo $enmge_single->topic_id ?>"><input type="hidden" name="topic_delete" value="<?php echo $enmge_single->topic_id ?>"></form><a href="#" class="groupsengine_delete" name="<?php echo $enmge_single->topic_id ?>">Delete</a></td>
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
