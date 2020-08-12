<?php /* ----- Series Engine - Add edit and remove Topics ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;

		$enmse_options = get_option( 'enm_seriesengine_options' ); 

		if ( isset($enmse_options['topict']) ) { // Find Topic Title
			$enmsetopict = $enmse_options['topict'];
		} else {
			$enmsetopict = "Topic";
		}

		if ( isset($enmse_options['topictp']) ) { // Find Topic Title (plural)
			$enmsetopictp = $enmse_options['topictp'];
		} else {
			$enmsetopictp = "Topics";
		}

		if ( isset($enmse_options['topicsort']) ) { // Sort Topics Manually?
			$enmsetopicsort = $enmse_options['topicsort'];
		} else {
			$enmsetopicsort = 1;
		}

		$enmse_errors = array(); //Set up errors array
		$enmse_messages = array(); //Set up messages array
		
		if ( $_POST && isset($_GET['enmse_did']) ) { // If deleting a topic
			$enmse_deleted_id = strip_tags($_POST['topic_delete']);
			$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_topics" . " WHERE topic_id=%d";
			$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_deleted_id ); 
			$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
			
			$enmse_stdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_message_topic_matches" . " WHERE topic_id=%d";
			$enmse_stdelete_query = $wpdb->prepare( $enmse_stdelete_query_preparred, $enmse_deleted_id ); 
			$enmse_stdeleted = $wpdb->query( $enmse_stdelete_query );

			$enmse_messages[] = "The topic was successfully deleted.";
		}
		
		if ( isset($_GET['enmse_action']) ) {
			$enmse_topic_created = null;

			if ( $_GET['enmse_action'] == 'edit' ) { // Edit Topic
				if ( $_POST ) {
					if ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) {
						$enmse_tid = strip_tags($_GET['enmse_tid']);
					}
					
					if (empty($_POST['topic_name'])) { 
						$enmse_errors[] = '- You must name the topic.';
					} else {
						$enmse_name = strip_tags($_POST['topic_name']);
					}
					
					if (empty($enmse_errors)) {
						$enmse_new_values = array( 'name' => $enmse_name ); 
						$enmse_where = array( 'topic_id' => $enmse_tid ); 
						$wpdb->update( $wpdb->prefix . "se_topics", $enmse_new_values, $enmse_where ); 
						$enmse_messages[] = "Topic successfully updated!";

						$enmse_findthetopicsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " WHERE topic_id = %d"; 
						$enmse_findthetopic = $wpdb->prepare( $enmse_findthetopicsql, $enmse_tid );
						$enmse_topic = $wpdb->get_row( $enmse_findthetopic, OBJECT );
						$enmse_topiccount = $wpdb->num_rows;
					} else {
						$enmse_findthetopicsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " WHERE topic_id = %d"; 
						$enmse_findthetopic = $wpdb->prepare( $enmse_findthetopicsql, $enmse_tid );
						$enmse_st = $wpdb->get_row( $enmse_findthetopic, OBJECT );
						$enmse_topiccount = $wpdb->num_rows;
					}

					
				} else {
					if ( isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid']) ) {
						$enmse_tid = strip_tags($_GET['enmse_tid']);
					}

					$enmse_findthetopicsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " WHERE topic_id = %d"; 
					$enmse_findthetopic = $wpdb->prepare( $enmse_findthetopicsql, $enmse_tid );
					$enmse_topic = $wpdb->get_row( $enmse_findthetopic, OBJECT );
					$enmse_topiccount = $wpdb->num_rows;
				}	
			}
			
			if ( ($_GET['enmse_action'] == 'new' && !isset($_GET['enmse_did']) ) && ( $_POST ) ) { // New Topic
				if (empty($_POST['topic_name'])) { 
					$enmse_errors[] = '- You must name the new topic.';
				} else {
					$enmse_name = strip_tags($_POST['topic_name']);
				}
				
				if (empty($enmse_errors)) {
					$enmse_topic_created = "yes";
					
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
					$enmse_messages[] = "You have successfully added a new topic to Series Engine!";
				}
			}
		}
		
		// Get All Topics
		if ( $enmsetopicsort == 1 ) {
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY sort_id ASC"; 
		} else {
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY name ASC"; 
		}
		
		$enmse_topics = $wpdb->get_results( $enmse_preparredsql );
		
		// Get All Message Topic Matches
		$enmse_preparredmtmsql = "SELECT message_id, topic_id FROM " . $wpdb->prefix . "se_message_topic_matches"; 
		$enmse_mtm = $wpdb->get_results( $enmse_preparredmtmsql );
	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap">
<?php if ( isset($_GET['enmse_action']) && ( $enmse_topic_created == null && !isset($_GET['enmse_did']) ) ) { if ( $_GET['enmse_action'] == 'new' ) { // If they're adding a new Topic ?>
		<div></div>
		<h2 class="enmse">Add a New Message <?php echo $enmsetopict; ?></h2>
		<?php include ('errorbox.php'); ?>
		<p>Use the form below to add a new <?php echo $enmsetopict; ?> into the Series Engine. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-topics"; ?>" class="enmse-learn-more">Learn more about Topics...</a></p>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Name:</th>
					<td><input id='topic_name' name='topic_name' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['topic_name']));} ?>" tabindex="1" /></td>
				</tr>
			</table>
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add New <?php echo $enmsetopict; ?>" tabindex="2" /></p>
		</form>
		<p><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_topics', __FILE__ ) ?>">&laquo; All <?php echo $enmsetopictp; ?></a></p>
		<?php include ('secredits.php'); ?>
	</div>
<?php } elseif ( ($_GET['enmse_action'] == 'edit') && ( $enmse_topiccount == 1 ) ) { ?>
	<div></div>
	<h2 class="enmse">Edit Message <?php echo $enmsetopict; ?> <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_topics&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Use the form below to update the <?php echo $enmsetopict; ?> within the Series Engine. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-topics"; ?>" class="enmse-learn-more">Learn more about Topics...</a></p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Name:</th>
				<td><input id='topic_name' name='topic_name' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['topic_name']));} else {echo htmlspecialchars(stripslashes($enmse_topic->name));} ?>" tabindex="1" /></td>
			</tr>
		</table>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Save Changes" tabindex="2" /></p>
	</form>
	<p><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_topics', __FILE__ ) ?>">&laquo; All <?php echo $enmsetopictp; ?></a></p>
	<?php include ('secredits.php'); ?>
</div>
<?php }} else { // Display the main listing of topics ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/deletetopic.js'; ?>"></script>
	<?php if ( $enmsetopicsort == 1 ) { ?><script type="text/javascript">
	jQuery(document).ready(function(){
		var fixHelper = function(e, ui) {
		    ui.children().each(function() {
		        jQuery(this).width(jQuery(this).width());
		    });
		    return ui;
		};
		jQuery("#enmse-topics tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
			var order = jQuery(this).sortable("serialize"); 
			jQuery.ajax({
				method: "POST",
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxsorttopics',
		            'row': order
		        },
		        success:function(data) {
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		}});
	});
	</script><?php } ?>
	
	<h2 class="enmse">Set Message <?php echo $enmsetopictp; ?> <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_topics&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>
	<p>All <?php echo $enmsetopictp; ?> are listed in the table below. Click and drag a row to change the listed order of your <?php echo $enmsetopictp; ?>. Click on the name of the <?php echo $enmsetopict; ?> to edit it. Click on the number of Messages to view a list of Messages associated with the <?php echo $enmsetopict; ?>. You can permanently delete the <?php echo $enmsetopict; ?> from the Series Engine by clicking the "Delete" link. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-topics"; ?>" class="enmse-learn-more">Learn more about Topics...</a></p>

	<table class="widefat" id="enmse-topics"> 
		<thead> 
			<tr> 
				<?php if ( $enmsetopicsort == 1 ) { ?><th>Sort</th><?php } ?>
				<th><?php echo $enmsetopict; ?> Name</th> 
				<th>Num. Messages</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmse_topics as $enmse_topic ) { ?>
			<tr id="row_<?php echo $enmse_topic->topic_id ?>">
				<?php if ( $enmsetopicsort == 1 ) { ?><td class="enmse-sort"></td><?php } ?>
				<td><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_topics&amp;enmse_action=edit&amp;enmse_tid=' . $enmse_topic->topic_id, __FILE__ ) ?>"><?php echo stripslashes($enmse_topic->name) ?></a></td>
				<td><?php $enmse_mtm_count = 0; foreach ( $enmse_mtm as $mtm ) { ?><?php if ( $mtm->topic_id == $enmse_topic->topic_id ) { $enmse_mtm_count = $enmse_mtm_count+1; } ?><?php } ?><?php if ( $enmse_mtm_count > 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_tid=' . $enmse_topic->topic_id, __FILE__ ) . "\">" . $enmse_mtm_count . " Messages</a>";} elseif ( $enmse_mtm_count == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_tid=' . $enmse_topic->topic_id, __FILE__ ) . "\">1 Message</a>"; } ?></td>				
				<td class="enmse-delete"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmse_did=1" method="post" id="seriesengine-deleteform<?php echo $enmse_topic->topic_id ?>"><input type="hidden" name="topic_delete" value="<?php echo $enmse_topic->topic_id ?>"></form><a href="#" class="seriesengine_delete" name="<?php echo $enmse_topic->topic_id ?>">Delete</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<input type="hidden" name="xxse" value="<?php echo base64_encode(ABSPATH); ?>" id="xxse" />
	<?php include ('secredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
