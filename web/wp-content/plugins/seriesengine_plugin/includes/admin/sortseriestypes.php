<?php /* ----- Series Engine - Sort Series Types in admin ----- */

require_once( '../loadwpfiles.php' );
header('HTTP/1.1 200 OK');

global $wpdb;

if ($_POST) {
	$useriestypes = $_POST['row'];

	$ccount = 1;
	foreach ($useriestypes as $seriestype) {
		$enmse_new_values = array( 'sort_id' => $ccount ); 
		$enmse_where = array( 'series_type_id' => $seriestype ); 			
		$wpdb->update( $wpdb->prefix . "se_series_types", $enmse_new_values, $enmse_where );
		$ccount = $ccount + 1; 
	}
}

?>