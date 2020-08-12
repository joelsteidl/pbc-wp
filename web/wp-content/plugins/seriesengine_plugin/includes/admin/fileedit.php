<?php /* ----- Series Engine - Edit a file straight from the Messages admin page ----- */

	if ( current_user_can( 'edit_pages' ) ) { 

		global $wpdb;


		if ( isset($_REQUEST['update']) && $_REQUEST['update'] == 1 ) {
			$enmse_file_name = strip_tags($_REQUEST['file_name']);
			$enmse_file_url = strip_tags($_REQUEST['file_url']);
			$enmse_file_username = strip_tags($_REQUEST['file_username']);
			$enmse_file_new_window = strip_tags($_REQUEST['file_new_window']);
			$enmse_message_id = strip_tags($_REQUEST['mid']);
			$enmse_featured = strip_tags($_REQUEST['featured']);
			$enmse_fid = strip_tags($_REQUEST['fid']);

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
			
			$enmse_new_values = array( 'file_name' => $enmse_file_name, 'file_url' => $enmse_file_url, 'file_new_window' => $enmse_file_new_window, 'file_username' => $enmse_file_username, 'featured' => $enmse_featured); 
			$enmse_where = array( 'file_id' => $enmse_fid ); 
			$wpdb->update( $wpdb->prefix . "se_files", $enmse_new_values, $enmse_where ); 

			$enmse_findthefilesql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " WHERE file_id = %d"; 
			$enmse_findthefile = $wpdb->prepare( $enmse_findthefilesql, $enmse_fid );
			$enmse_single = $wpdb->get_row( $enmse_findthefile, OBJECT );	
		} else {
			$enmse_fid = strip_tags($_REQUEST['fid']);

			$enmse_findthefilesql = "SELECT * FROM " . $wpdb->prefix . "se_files" . " WHERE file_id = %d"; 
			$enmse_findthefile = $wpdb->prepare( $enmse_findthefilesql, $enmse_fid );
			$enmse_single = $wpdb->get_row( $enmse_findthefile, OBJECT );	
		}

?>
	<?php if ( isset($_REQUEST['update']) ) { ?>
		<h3>Attach a Link or Download</h3>		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Name:</th>
				<td><input id='file_name' name='file_name' type='text' value="" tabindex="1" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Link/File URL:</th>
				<td><input id='file_url' name='file_url' type='text' value='' tabindex="2" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=1&#038;TB_iframe=1', __FILE__ ); ?>" class="thickbox se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
			</tr>
			<tr valign="top">
				<th scope="row">How to Open Link:</th>
				<td>
					<select name="file_new_window" id="file_new_window" tabindex="3">
						<option value="0">Same Window</option>
						<option value="1">New Window</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Featured?:
					<p class="se-form-instructions">Featured Attachments/Links will be shown in the Related Messages views. Only ONE can be featured per Message.</p>
				</th>
				<td>
					<input name="file_featured" id="file_featured" type="checkbox" class="check" />
				</td>
			</tr>
		</table>
		<br />
		<input type="hidden" name="file_username" value="<?php echo $_REQUEST['file_username']; ?>" id="file_username" />
		<a href="#" id="addnewfile" class="button">Attach New Link/Download</a>
	<?php } else { ?>
		<h3>Edit Link/Download</h3>		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Name:</th>
				<td><input id='file_name' name='file_name' type='text' value="<?php echo htmlspecialchars(stripslashes($enmse_single->file_name)); ?>" tabindex="1" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Link/File URL:</th>
				<td><input id='file_url' name='file_url' type='text' value='<?php echo $enmse_single->file_url; ?>' tabindex="2" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=1&#038;TB_iframe=1', __FILE__ ); ?>" class="thickbox se-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload File</a></td>
			</tr>
			<tr valign="top">
				<th scope="row">How to Open Link:</th>
				<td>
					<select name="file_new_window" id="file_new_window" tabindex="3">
						<option value="0" <?php if ($enmse_single->file_new_window == 0) { ?>selected="selected"<?php } ?>>Same Window</option>
						<option value="1" <?php if ($enmse_single->file_new_window == 1) { ?>selected="selected"<?php } ?>>New Window</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Featured?:
					<p class="se-form-instructions">Featured Attachments/Links will be shown in the Related Messages views. Only ONE can be featured per Message.</p>
				</th>
				<td>
					<input name="file_featured" id="file_featured" type="checkbox" class="check" <?php if ( $enmse_single->featured == 1 ) { echo "checked=\"checked\""; }; ?> />
				</td>
			</tr>
		</table>
		<br />
		<input type="hidden" name="file_username" value="<?php echo $_REQUEST['file_username']; ?>" id="file_username" />
		<input type="hidden" name="file_id" value="<?php echo $enmse_single->file_id; ?>" id="file_id" />
		<a href="#" id="editfile" class="button">Save Changes</a>
	<?php } ?>
<?php } else {
	exit("Access Denied");
} die(); ?>