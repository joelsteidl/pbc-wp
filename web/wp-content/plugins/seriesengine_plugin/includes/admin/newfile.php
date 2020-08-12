<?php /* ----- Series Engine - Add a new file straight from the Messages admin page ----- */

	if ( current_user_can( 'edit_pages' ) ) { 

		// ***** Get Labels
		$enmse_options = get_option( 'enm_seriesengine_options' ); 

		if ( isset($enmse_options['messaget']) ) { // Find Message Title
			$enmsemessaget = $enmse_options['messaget'];
		} else {
			$enmsemessaget = "Message";
		}

		if ( isset($enmse_options['messagetp']) ) { // Find Message Title (plural)
			$enmsemessagetp = $enmse_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		}

		global $wpdb;

		if ( isset($_REQUEST['new']) && $_REQUEST['new'] == 1 ) {
			$enmse_file_name = strip_tags($_REQUEST['file_name']);
			$enmse_file_url = strip_tags($_REQUEST['file_url']);
			$enmse_file_new_window = strip_tags($_REQUEST['file_new_window']);
			$enmse_file_username = strip_tags($_REQUEST['file_username']);
			$enmse_message_id = strip_tags($_REQUEST['message_id']);
			$enmse_featured = strip_tags($_REQUEST['featured']);

			if ( $enmse_featured == 1 ) {
				$enmse_preparredcfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d AND featured = 1 GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmse_cfsql = $wpdb->prepare( $enmse_preparredcfsql, $enmse_message_id );
				$enmse_cfiles = $wpdb->get_results( $enmse_cfsql );

				foreach ($enmse_cfiles as $cf) {
					$enmse_new_fvalues = array( 'featured' => "0" ); 
					$enmse_fwhere = array( 'file_id' => $cf->file_id ); 
					$wpdb->update( $wpdb->prefix . "se_files", $enmse_new_fvalues, $enmse_fwhere ); 
				}

				if ( $enmse_message_id > 0 ) {
					$enmse_new_mvalues = array( 'file_name' => $enmse_file_name, 'file_url' => $enmse_file_url, 'file_new_window' => $enmse_file_new_window ); 
					$enmse_mwhere = array( 'message_id' => $enmse_message_id ); 
					$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere ); 
				}
			}

			$enmse_newfile = array(
				'file_name' => $enmse_file_name, 
				'file_url' => $enmse_file_url,
				'file_new_window' => $enmse_file_new_window,
				'file_username' => $enmse_file_username,
				'featured' => $enmse_featured
				); 
			$wpdb->insert( $wpdb->prefix . "se_files", $enmse_newfile );
			$enmse_new_file_id = $wpdb->insert_id; 
			
			// Add file relation in the DB
			$enmse_newmfm = array(
				'message_id' => $enmse_message_id, 
				'file_id' => $enmse_new_file_id
			); 
			$wpdb->insert( $wpdb->prefix . "se_message_file_matches", $enmse_newmfm );

			if ( $enmse_message_id > 0 ) {
				// Get All Files
				$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_message_id );
				$enmse_files = $wpdb->get_results( $enmse_fsql );
			} else {
				// Get All Files
				$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d AND file_username = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_message_id, $enmse_file_username );
				$enmse_files = $wpdb->get_results( $enmse_fsql );
			}
		} else {
			$enmse_message_id = strip_tags($_REQUEST['message_id']);
			$enmse_file_username = strip_tags($_REQUEST['file_username']);
			
			if ( $enmse_message_id > 0 ) {
				// Get All Files
				$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_message_id );
				$enmse_files = $wpdb->get_results( $enmse_fsql );
			} else {
				// Get All Files
				$enmse_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " LEFT JOIN " . $wpdb->prefix . "se_message_file_matches" . " USING (file_id) WHERE message_id = %d AND file_username = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmse_fsql = $wpdb->prepare( $enmse_preparredfsql, $enmse_message_id, $enmse_file_username );
				$enmse_files = $wpdb->get_results( $enmse_fsql );
			}
			
		}

?>
	<?php if ( isset($_REQUEST['new']) ) { ?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#enmsesmessage").delay(4000).slideUp();
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					jQuery(this).width(jQuery(this).width());
				});
				return ui;
			};
			jQuery("#filestable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
				var order = jQuery(this).sortable("serialize");
				jQuery.ajax({
					method: "POST",
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxsortfiles',
			            'frow': order
			        },
			        success:function(data) {
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}});
		});
		</script>
		<br />
		<h3>Links and Downloads Currently Associated with This <?php echo $enmsemessaget; ?>...</h3>
		<p id="enmsesmessage"><em>Your link/download was sucessfully added.</em></p>
		<table class="widefat" id="filestable"> 
		<thead> 
			<tr> 
				<th>Sort</th> 
				<th>Name</th> 
				<th>URL</th>
				<th>Opens In...</th>
				<th>Featured?</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($enmse_files as $file) {  ?>
			<tr id="frow_<?php echo $file->file_id; ?>">
				<td class="enmse-sort"></td>
				<td><a href="#" class="seriesengine_editfile" name="<?php echo $file->file_id; ?>"><?php echo stripslashes($file->file_name); ?></a></td>
				<td><a href="<?php echo $file->file_url; ?>" target="_blank"><?php echo $file->file_url; ?></a></td>
				<td><?php if ( $file->file_new_window == 0 ) { echo "Same Window"; } else { echo "New Window"; } ?></td>
				<td><?php if ( $file->featured == 1 ) { echo "Yes"; }; ?></td>
				<td class="enmse-delete"><a href="#" class="seriesengine_filedelete" name="<?php echo $file->file_id; ?>" rel="<?php echo $file->featured; ?>">Delete</a></td>			</tr>
		<?php } ?>
		</tbody>
		</table>
		<br />
		<br />
	<?php } else { ?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#enmsesmessage").delay(4000).slideUp();
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					jQuery(this).width(jQuery(this).width());
				});
				return ui;
			};
			jQuery("#filestable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
				var order = jQuery(this).sortable("serialize");
				jQuery.ajax({
					method: "POST",
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxsortfiles',
			            'frow': order
			        },
			        success:function(data) {
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}});
		});
		</script>
		<br />
		<h3>Links and Downloads Currently Associated with This <?php echo $enmsemessaget; ?>...</h3>
		<p id="enmsesmessage"><em>Your link/download was sucessfully edited.</em></p>
		<table class="widefat" id="filestable"> 
		<thead> 
			<tr>
				<th>Sort</th> 	
				<th>Name</th> 
				<th>URL</th>
				<th>Opens In...</th>
				<th>Featured?</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($enmse_files as $file) {  ?>
			<tr id="frow_<?php echo $file->file_id; ?>">
				<td class="enmse-sort"></td>
				<td><a href="#" class="seriesengine_editfile" name="<?php echo $file->file_id; ?>"><?php echo stripslashes($file->file_name); ?></a></td>
				<td><a href="<?php echo $file->file_url; ?>" target="_blank"><?php echo $file->file_url; ?></a></td>
				<td><?php if ( $file->file_new_window == 0 ) { echo "Same Window"; } else { echo "New Window"; } ?></td>
				<td><?php if ( $file->featured == 1 ) { echo "Yes"; }; ?></td>
				<td class="enmse-delete"><a href="#" class="seriesengine_filedelete" name="<?php echo $file->file_id; ?>" rel="<?php echo $file->featured; ?>">Delete</a></td>			</tr>
		<?php } ?>
		</tbody>
		</table>
		<br />
		<br />
	<?php } ?>
<?php } else {
	exit("Access Denied");
} die(); ?>