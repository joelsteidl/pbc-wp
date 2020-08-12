<?php /* ----- Series Engine - Sort Scripture in admin ----- */

global $wpdb;

if ($_POST) {
	parse_str($_REQUEST['row'], $uscripture);

	$ccount = 1;
	foreach ($uscripture['row'] as $scripture) {
		$enmse_new_values = array( 'sort_id' => $ccount ); 
		$enmse_where = array( 'scripture_id' => $scripture ); 			
		$wpdb->update( $wpdb->prefix . "se_scriptures", $enmse_new_values, $enmse_where );
		$ccount = $ccount + 1; 
	}
}

die();

?>