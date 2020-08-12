<?php /* ----- Series Engine - Sort Topics in admin ----- */

global $wpdb;

if ($_POST) {
	parse_str($_REQUEST['row'], $utopics);

	$ccount = 1;
	foreach ($utopics['row'] as $topic) {
		$enmse_new_values = array( 'sort_id' => $ccount ); 
		$enmse_where = array( 'topic_id' => $topic ); 			
		$wpdb->update( $wpdb->prefix . "se_topics", $enmse_new_values, $enmse_where );
		$ccount = $ccount + 1; 
	}
}

die();

?>