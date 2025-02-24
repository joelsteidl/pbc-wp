<?php /* ----- Groups Engine - Edit a file straight from the Groups admin page ----- */

	if ( current_user_can( 'edit_posts' ) ) { 

		global $wpdb;

		if ( isset($_REQUEST['update']) && $_REQUEST['update'] == 1 ) {
			$enmge_file_name = $_REQUEST['file_name'];
			$enmge_file_url = $_REQUEST['file_url'];
			$enmge_fid = $_REQUEST['fid'];
			
			$enmge_new_values = array( 'file_name' => $enmge_file_name, 'file_url' => $enmge_file_url ); 
			$enmge_where = array( 'file_id' => $enmge_fid ); 
			$wpdb->update( $wpdb->prefix . "ge_files", $enmge_new_values, $enmge_where ); 
		} else {
			$enmge_fid = $_REQUEST['fid'];

			$enmge_findthefilesql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " WHERE file_id = %d"; 
			$enmge_findthefile = $wpdb->prepare( $enmge_findthefilesql, $enmge_fid );
			$enmge_single = $wpdb->get_row( $enmge_findthefile, OBJECT );		
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
				<td><input id='file_url' name='file_url' type='text' value='' tabindex="2" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=1&#038;TB_iframe=1', __FILE__ ); ?>" class="thickbox ge-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="ge-media-button" /> &nbsp;Upload File</a></td>
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
				<td><input id='file_name' name='file_name' type='text' value="<?php echo $enmge_single->file_name; ?>" tabindex="1" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Link/File URL:</th>
				<td><input id='file_url' name='file_url' type='text' value='<?php echo $enmge_single->file_url; ?>' tabindex="2" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=1&#038;TB_iframe=1', __FILE__ ); ?>" class="thickbox ge-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="ge-media-button" /> &nbsp;Upload File</a></td>
			</tr>
		</table>
		<br />
		<input type="hidden" name="file_username" value="<?php echo $_REQUEST['file_username']; ?>" id="file_username" />
		<input type="hidden" name="file_id" value="<?php echo $enmge_single->file_id; ?>" id="file_id" />
		<a href="#" id="editfile" class="button">Save Changes</a>
	<?php } ?>
<?php } else {
	exit("Access Denied");
} die(); ?>