<?php /* ----- Groups Engine - Add a new file straight from the Groups admin page ----- */

	if ( current_user_can( 'edit_posts' ) ) { 

		// ***** Get Labels
		$enmge_options = get_option( 'enm_groupsengine_options' ); 

		global $wpdb;

		if ( isset($_REQUEST['formdata']) ) {
			parse_str($_REQUEST['formdata'], $_POST);
		}
		

		if ( isset($_REQUEST['new']) && $_REQUEST['new'] == 1 ) {

			$enmge_file_name = $_POST['file_name'];
			$enmge_file_url = $_POST['file_url'];
			$enmge_file_username = $_POST['file_username'];
			$enmge_group_id = $_REQUEST['group_id'];

			$enmge_newfile = array(
				'file_name' => $enmge_file_name, 
				'file_url' => $enmge_file_url,
				'file_username' => $enmge_file_username
				); 
			$wpdb->insert( $wpdb->prefix . "ge_files", $enmge_newfile );
			$enmge_new_file_id = $wpdb->insert_id; 
			
			// Add file relation in the DB
			$enmge_newmfm = array(
				'group_id' => $enmge_group_id, 
				'file_id' => $enmge_new_file_id
			); 
			$wpdb->insert( $wpdb->prefix . "ge_group_file_matches", $enmge_newmfm );
			
			if ( $enmge_group_id > 0 ) {
				// Get All Files
				$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_group_id );
				$enmge_files = $wpdb->get_results( $enmge_fsql );
			} else {
				// Get All Files
				$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d AND file_username = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_group_id, $enmge_file_username );
				$enmge_files = $wpdb->get_results( $enmge_fsql );
			}
		} else {
			$enmge_group_id = $_REQUEST['group_id'];
			$enmge_file_username = $_REQUEST['file_username'];
			
			if ( $enmge_group_id > 0 ) {
				// Get All Files
				$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_group_id );
				$enmge_files = $wpdb->get_results( $enmge_fsql );
			} else {
				// Get All Files
				$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d AND file_username = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_group_id, $enmge_file_username );
				$enmge_files = $wpdb->get_results( $enmge_fsql );
			}
			
		}

?>
	<?php if ( !isset($_REQUEST['new']) ) { ?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#enmgesmessage").delay(4000).slideUp();
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
			        url: geajax.ajaxurl, 
			        data: {
			            'action': 'groupsengine_ajaxsortfiles',
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
		<h3>Links and Downloads Currently Associated with This Group...</h3>
		<p id="enmgesmessage"><em>Your link/download was sucessfully edited.</em></p>
		<table class="widefat" id="filestable"> 
		<thead> 
			<tr> 
				<th>Sort</th> 
				<th>Name</th> 
				<th>URL</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($enmge_files as $file) {  ?>
			<tr id="row_<?php echo $file->file_id; ?>">
				<td class="enmge-sort"></td>
				<td><a href="#" class="groupsengine_editfile" name="<?php echo $file->file_id; ?>"><?php echo $file->file_name; ?></a></td>
				<td><a href="<?php echo $file->file_url; ?>" target="_blank"><?php echo $file->file_url; ?></a></td>
				<td class="enmge-delete"><a href="#" class="groupsengine_filedelete" name="<?php echo $file->file_id; ?>">Delete</a></td>				
			</tr>
		<?php } ?>
		</tbody>
		</table>
	<?php } else { ?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#enmgesmessage").delay(4000).slideUp();
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
			        url: geajax.ajaxurl, 
			        data: {
			            'action': 'groupsengine_ajaxsortfiles',
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
		<h3>Links and Downloads Currently Associated with This Group...</h3>
		<p id="enmgesmessage"><em>Your new link/download was added sucessfully.</em></p>
		<table class="widefat" id="filestable"> 
		<thead> 
			<tr>
				<th>Sort</th> 	
				<th>Name</th> 
				<th>URL</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($enmge_files as $file) {  ?>
			<tr id="row_<?php echo $file->file_id; ?>">
				<td class="enmge-sort"></td>
				<td><a href="#" class="groupsengine_editfile" name="<?php echo $file->file_id; ?>"><?php echo $file->file_name; ?></a></td>
				<td><a href="<?php echo $file->file_url; ?>" target="_blank"><?php echo $file->file_url; ?></a></td>
				<td class="enmge-delete"><a href="#" class="groupsengine_filedelete" name="<?php echo $file->file_id; ?>">Delete</a></td>				
			</tr>
		<?php } ?>
		</tbody>
		</table>
	<?php } ?>
<?php } else {
	exit("Access Denied");
} die(); ?>