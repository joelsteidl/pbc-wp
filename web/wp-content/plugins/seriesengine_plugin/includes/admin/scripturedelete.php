<?php /* ----- Series Engine - Delete a file ----- */

if ( current_user_can( 'edit_pages' ) ) { 

	global $wpdb;
	
	if ( isset($_REQUEST['did']) ) { // If deleting a file
		$enmse_deleted_id = strip_tags($_REQUEST['did']);
		$enmse_message_id = strip_tags($_REQUEST['mid']);

		$enmse_findthebooksql = "SELECT start_book FROM " . $wpdb->prefix . "se_scriptures" . " WHERE scripture_id = %d"; 
		$enmse_findthebook = $wpdb->prepare( $enmse_findthebooksql, $enmse_deleted_id );
		$enmse_foundbook = $wpdb->get_row( $enmse_findthebook, OBJECT );

		$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_scriptures" . " WHERE scripture_id=%d";
		$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_deleted_id ); 
		$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
	
		$enmse_sfdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_scripture_message_matches" . " WHERE scripture_id=%d";
		$enmse_sfdelete_query = $wpdb->prepare( $enmse_sfdelete_query_preparred, $enmse_deleted_id ); 
		$enmse_sfdeleted = $wpdb->query( $enmse_sfdelete_query );

		$enmse_preparreddscmsql = "SELECT scm_match_id FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND focus = 1 AND start_book=%d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
		$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $enmse_message_id, $enmse_foundbook->start_book  );
		$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
		$enmse_countrec = $wpdb->num_rows;

		if ( empty($enmse_dmscriptures) ) { // delete if there's no other focus messages from the same book and the book/message are matches?
			$enmse_bdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id=%d AND book_id=%d";
			$enmse_bdelete_query = $wpdb->prepare( $enmse_bdelete_query_preparred, $enmse_message_id, $enmse_foundbook->start_book ); 
			$enmse_bdeleted = $wpdb->query( $enmse_bdelete_query );
		}

		if ( isset($_REQUEST['f']) && $_REQUEST['f'] == 1 ) {

			if ( $enmse_message_id > 0 ) {
				$enmse_preparredscmsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND focus = 1 GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_scmsql = $wpdb->prepare( $enmse_preparredscmsql, $enmse_message_id );
				$enmse_mscriptures = $wpdb->get_results( $enmse_scmsql );

				$scomma = 0;
				foreach ( $enmse_mscriptures as $s ) {
					if ( $scomma == 0 ) {
						$scripturetext = $s->text;
					} else {
						$scripturetext = $scripturetext . ", " . $s->text;
					}
					$scomma = $scomma + 1;
				}

				$enmse_new_mvalues = array( 'focus_scripture' => $scripturetext ); 
				$enmse_mwhere = array( 'message_id' => $enmse_message_id ); 
				$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );
			}
			
		}
	}
} else {
	exit("Access Denied");
} die(); ?>