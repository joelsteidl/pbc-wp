<?php /* ----- Series Engine - Sort Topics in admin ----- */

require_once( '../loadwpfiles.php' );

global $wpdb;

if ($_POST) {
	$utopics = $_POST['row'];

	$ccount = 1;
	foreach ($utopics as $topic) {
		$enmse_new_values = array( 'sort_id' => $ccount ); 
		$enmse_where = array( 'topic_id' => $topic ); 			
		$wpdb->update( $wpdb->prefix . "se_topics", $enmse_new_values, $enmse_where );
		$ccount = $ccount + 1; 
	}
}

?>