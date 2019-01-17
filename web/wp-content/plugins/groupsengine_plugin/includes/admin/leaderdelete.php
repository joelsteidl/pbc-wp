<?php /* ----- Groups Engine - Delete a leader ----- */

require_once( '../loadwpfiles.php' );
header('HTTP/1.1 200 OK');

if ( current_user_can( 'edit_pages' ) ) { 

	global $wpdb;
	
	if ( $_POST && isset($_GET['did']) ) { // If deleting a leader
		$enmge_deleted_id = strip_tags($_GET['did']);
		$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_leaders" . " WHERE leader_id=%d";
		$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_deleted_id ); 
		$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
	
		$enmge_sfdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_leader_matches" . " WHERE leader_id=%d";
		$enmge_sfdelete_query = $wpdb->prepare( $enmge_sfdelete_query_preparred, $enmge_deleted_id ); 
		$enmge_sfdeleted = $wpdb->query( $enmge_sfdelete_query );
	}
} else {
	exit("Access Denied");
} ?>