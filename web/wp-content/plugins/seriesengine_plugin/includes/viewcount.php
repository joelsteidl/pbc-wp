<?php /* Series Engine - Update View Counts */
	require '../../../../wp-blog-header.php'; // ADJUST THIS PATH if using a non-standard WordPress install
	header('HTTP/1.1 200 OK');
	
	global $wpdb;
	
	if ($_POST) {
		$enmse_newcount = strip_tags($_POST['count']);
		/*if ( $enmse_newcount == null ) {
			$enmse_newcount = 0;
		}*/
		$enmse_mid = strip_tags($_POST['id']);
		$enmse_type = strip_tags($_POST['type']);

		if ( $enmse_type == "audio" ) {
			if ( is_numeric($enmse_newcount) && is_numeric($enmse_mid) ) {
				$enmse_new_values = array( 'audio_count' => $enmse_newcount ); 
				$enmse_where = array( 'message_id' => $enmse_mid ); 
				$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_values, $enmse_where ); 
			}
		} elseif ( $enmse_type == "video") {
			if ( is_numeric($enmse_newcount) && is_numeric($enmse_mid) ) {
				$enmse_new_values = array( 'video_count' => $enmse_newcount ); 
				$enmse_where = array( 'message_id' => $enmse_mid ); 
				$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_values, $enmse_where ); 
			}
		} elseif ( $enmse_type == "alternate") {
			if ( is_numeric($enmse_newcount) && is_numeric($enmse_mid) ) {
				$enmse_new_values = array( 'alternate_count' => $enmse_newcount ); 
				$enmse_where = array( 'message_id' => $enmse_mid ); 
				$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_values, $enmse_where ); 
			}
		}

	};
?>
<?php echo $enmse_newcount ?>, <?php echo $enmse_mid; ?>, <?php echo $enmse_type; ?>