<?php /* ----- Series Engine - Sort Series Types in admin ----- */

global $wpdb;

if ($_POST) {
	parse_str($_REQUEST['row'], $useriestypes);

	$ccount = 1;
	foreach ($useriestypes['row'] as $seriestype) {
		$enmse_new_values = array( 'sort_id' => $ccount ); 
		$enmse_where = array( 'series_type_id' => $seriestype ); 			
		$wpdb->update( $wpdb->prefix . "se_series_types", $enmse_new_values, $enmse_where );
		$ccount = $ccount + 1; 
	}
}

die();

?>