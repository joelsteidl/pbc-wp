<?php /* ----- Groups Engine - Delete a file ----- */

if ( current_user_can( 'edit_posts' ) ) { 

	global $wpdb;
	
	if ( isset($_REQUEST['did']) ) { // If deleting a file
		$enmge_deleted_id = strip_tags($_REQUEST['did']);
		$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_files" . " WHERE file_id=%d";
		$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_deleted_id ); 
		$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
	
		$enmge_sfdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_file_matches" . " WHERE file_id=%d";
		$enmge_sfdelete_query = $wpdb->prepare( $enmge_sfdelete_query_preparred, $enmge_deleted_id ); 
		$enmge_sfdeleted = $wpdb->query( $enmge_sfdelete_query );
	}
} else {
	exit("Access Denied");
} die(); ?>