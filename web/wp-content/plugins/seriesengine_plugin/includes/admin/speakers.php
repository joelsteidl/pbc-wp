<?php /* ----- Series Engine - Add edit and remove Speakers ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;

		$enmse_options = get_option( 'enm_seriesengine_options' ); 

		$enmse_errors = array(); //Set up errors array
		$enmse_messages = array(); //Set up messages array

		if ( isset($enmse_options['speakert']) ) { // Find Series Title
			$enmsespeakert = $enmse_options['speakert'];
		} else {
			$enmsespeakert = "Speaker";
		}

		if ( isset($enmse_options['speakertp']) ) { // Find Series Title (plural)
			$enmsespeakertp = $enmse_options['speakertp'];
		} else {
			$enmsespeakertp = "Speakers";
		}
		
		if ( $_POST && isset($_GET['enmse_did']) ) { // If deleting a topic
			$enmse_deleted_id = strip_tags($_POST['speaker_delete']);
			$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id=%d";
			$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_deleted_id ); 
			$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
			
			$enmse_deletem_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_message_speaker_matches" . " WHERE speaker_id=%d";
			$enmse_deletem_query = $wpdb->prepare( $enmse_deletem_query_preparred, $enmse_deleted_id ); 
			$enmse_deletedm = $wpdb->query( $enmse_deletem_query ); 

			$enmse_messages[] = "The speaker was successfully deleted.";
		}
		
		if ( isset($_GET['enmse_action']) ) {
			$enmse_speaker_created = null;

			if ( $_GET['enmse_action'] == 'edit' ) { // Edit Topic
				if ( $_POST ) {
					if ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) {
						$enmse_spid = strip_tags($_GET['enmse_spid']);
					}
					
					if (empty($_POST['speaker_first_name'])) { 
						$enmse_errors[] = '- You must give the speaker a first name.';
					} else {
						$enmse_first_name = strip_tags($_POST['speaker_first_name']);
					}
					
					$enmse_last_name = strip_tags($_POST['speaker_last_name']);
					
					if (empty($enmse_errors)) {
						
						$enmse_messagessql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE speaker_id = " . $enmse_spid . " GROUP BY message_id"; 
						$enmse_findmessages = $wpdb->get_results( $enmse_messagessql );

						$enmse_newname = $enmse_first_name . " " . $enmse_last_name;

						foreach ($enmse_findmessages as $m) {
							$enmse_new_mvalues = array( 'speaker' => $enmse_newname ); 
							$enmse_mwhere = array( 'message_id' => $m->message_id ); 
							$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere ); 
						}

						$enmse_new_values = array( 'first_name' => $enmse_first_name, 'last_name' => $enmse_last_name  ); 
						$enmse_where = array( 'speaker_id' => $enmse_spid ); 
						$wpdb->update( $wpdb->prefix . "se_speakers", $enmse_new_values, $enmse_where ); 
						$enmse_messages[] = "Speaker successfully updated!";

						$enmse_findthespeakersql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id = %d"; 
						$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_spid );
						$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
						$enmse_speakercount = $wpdb->num_rows;
					} else {
						$enmse_findthespeakersql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id = %d"; 
						$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_spid );
						$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
						$enmse_speakercount = $wpdb->num_rows;
					}

					
				} else {
					if ( isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid']) ) {
						$enmse_spid = strip_tags($_GET['enmse_spid']);
					}

					$enmse_findthespeakersql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id = %d"; 
					$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_spid );
					$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );
					$enmse_speakercount = $wpdb->num_rows;
				}	
			}
			
			if ( ($_GET['enmse_action'] == 'new' && !isset($_GET['enmse_did']) ) && ( $_POST ) ) { // New Speaker
				if (empty($_POST['speaker_first_name'])) { 
					$enmse_errors[] = '- You must give the speaker a first name.';
				} else {
					$enmse_first_name = strip_tags($_POST['speaker_first_name']);
				}
				
				$enmse_last_name = strip_tags($_POST['speaker_last_name']);
				
				if (empty($enmse_errors)) {
					$enmse_speaker_created = "yes";
					
					$enmse_newspeaker = array(
						'first_name' => $enmse_first_name, 
						'last_name' => $enmse_last_name, 
						); 
					$wpdb->insert( $wpdb->prefix . "se_speakers", $enmse_newspeaker );
					$enmse_messages[] = "You have successfully added a new Speaker to Series Engine!";
				}
			}
		}
		
		include ('paginated_speakers.php'); // Get all series
		
		// Get All Message Speaker Matches
		$enmse_preparredmspmsql = "SELECT message_id, speaker_id FROM " . $wpdb->prefix . "se_message_speaker_matches"; 
		$enmse_mspm = $wpdb->get_results( $enmse_preparredmspmsql );
	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap"> 
<?php if ( isset($_GET['enmse_action']) && ( $enmse_speaker_created == null && !isset($_GET['enmse_did']) ) ) { if ( $_GET['enmse_action'] == 'new' ) { // If they're adding a new Speaker ?>
		<div></div>
		<h2 class="enmse">Add a New <?php echo $enmsespeakert; ?></h2>
		<?php include ('errorbox.php'); ?>
		<p>Use the form below to add a new <?php echo $enmsespeakert; ?> into the Series Engine. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-speakers"; ?>" class="enmse-learn-more">Learn more about Speakers...</a></p>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">First Name:</th>
					<td><input id='speaker_first_name' name='speaker_first_name' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['speaker_first_name']));} ?>" tabindex="1" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Last Name:</th>
					<td><input id='speaker_last_name' name='speaker_last_name' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['speaker_last_name']));} ?>" tabindex="2" /></td>
				</tr>
			</table>
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add New <?php echo $enmsespeakert; ?>" tabindex="3" /></p>
		</form>
		<p><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers', __FILE__ ) ?>">&laquo; All Topics</a></p>
		<?php include ('secredits.php'); ?>
<?php } elseif ( ($_GET['enmse_action'] == 'edit') && ( $enmse_speakercount == 1 ) ) { ?>
	<div></div>
	<h2 class="enmse">Edit <?php echo $enmsespeakert; ?> <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Use the form below to update the <?php echo $enmsespeakert; ?> within the Series Engine. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-speakers"; ?>" class="enmse-learn-more">Learn more about Speakers...</a></p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">First Name:</th>
				<td><input id='speaker_first_name' name='speaker_first_name' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['speaker_first_name']));} else {echo htmlspecialchars(stripslashes($enmse_speaker->first_name));} ?>" tabindex="1" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Last Name:</th>
				<td><input id='speaker_last_name' name='speaker_last_name' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['speaker_last_name']));} else {echo htmlspecialchars(stripslashes($enmse_speaker->last_name));} ?>" tabindex="2" /></td>
			</tr>
		</table>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Save Changes" tabindex="3" /></p>
	</form>
	<p><a href="<?php if ( isset($_GET['enmse_p']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers', __FILE__ ); } ?>">&laquo; All Speakers</a></p>
	<?php include ('secredits.php'); ?>
<?php }} else { // Display the main listing of topics ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/deletespeaker.js'; ?>"></script>
	
	<h2 class="enmse">Add and Edit <?php echo $enmsespeakertp; ?> <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>
	<p>All <?php echo $enmsespeakertp; ?> are listed in the table below. Click on the name of the <?php echo $enmsespeakert; ?> to edit it. Click on the number of Messages to view a list of Messages associated with the <?php echo $enmsespeakert; ?>. You can permanently delete the <?php echo $enmsespeakert; ?> from the Series Engine (if its not associated with a Message) by clicking the "Delete" link. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-speakers"; ?>" class="enmse-learn-more">Learn more about Speakers...</a></p>
	<?php include ('speakerpagination.php'); ?>
	<table class="widefat" id="enmse-topics"> 
		<thead> 
			<tr> 
				<th>Name</th> 
				<th>Num. Messages</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmse_speakers as $enmse_speaker ) { ?>
			<tr id="row_<?php echo $enmse_speaker->speaker_id ?>">
				<td><a href="<?php if ( isset($_GET['enmse_p']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'] . '&amp;enmse_action=edit&amp;enmse_spid=' . $enmse_speaker->speaker_id, __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers&amp;enmse_action=edit&amp;enmse_spid=' . $enmse_speaker->speaker_id, __FILE__ ); }; ?>"><?php echo stripslashes($enmse_speaker->first_name) . " " . stripslashes($enmse_speaker->last_name); ?></a></td>
				<td><?php $enmse_mspm_count = 0; foreach ( $enmse_mspm as $mspm ) { ?><?php if ( $mspm->speaker_id == $enmse_speaker->speaker_id ) { $enmse_mspm_count = $enmse_mspm_count+1; } ?><?php } ?><?php if ( $enmse_mspm_count > 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_spid=' . $enmse_speaker->speaker_id, __FILE__ ) . "\">" . $enmse_mspm_count . " Messages</a>";} elseif ( $enmse_mspm_count == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_spid=' . $enmse_speaker->speaker_id, __FILE__ ) . "\">1 Message</a>"; } ?></td>				
				<td class="enmse-delete"><?php if ( $enmse_mspm_count == 0 ) { ?><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmse_did=1" method="post" id="seriesengine-deleteform<?php echo $enmse_speaker->speaker_id ?>"><input type="hidden" name="speaker_delete" value="<?php echo $enmse_speaker->speaker_id ?>"></form><a href="#" class="seriesengine_delete" name="<?php echo $enmse_speaker->speaker_id ?>">Delete</a><?php } ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php include ('secredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
