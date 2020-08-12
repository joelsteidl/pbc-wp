<?php /* ----- Series Engine - Delete a file ----- */

if ( current_user_can( 'edit_pages' ) ) { 

	global $wpdb;
	
	if ( isset($_REQUEST['did']) ) { // If deleting a file
		$enmse_deleted_id = strip_tags($_REQUEST['did']);
		if ( isset($_REQUEST['f']) && $_REQUEST['f'] == 1 ) {
			$mid = $_REQUEST['mid'];

			if ( $mid > 0 ) {
				$enmse_new_mvalues = array( 'file_name' => "", 'file_url' => "", 'file_new_window' => "" ); 
				$enmse_mwhere = array( 'message_id' => $mid ); 
				$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );
			}
			 
		}
		$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_files" . " WHERE file_id=%d";
		$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_deleted_id ); 
		$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
	
		$enmse_sfdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_message_file_matches" . " WHERE file_id=%d";
		$enmse_sfdelete_query = $wpdb->prepare( $enmse_sfdelete_query_preparred, $enmse_deleted_id ); 
		$enmse_sfdeleted = $wpdb->query( $enmse_sfdelete_query );
	}
} else {
	exit("Access Denied");
} die(); ?>