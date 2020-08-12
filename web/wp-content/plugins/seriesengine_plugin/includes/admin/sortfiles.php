<?php /* ----- Series Engine - Sort Files in admin ----- */

global $wpdb;

if ($_POST) {
	parse_str($_REQUEST['frow'], $ufiles);

	$ccount = 1;
	foreach ($ufiles['frow'] as $file) {
		$enmse_new_values = array( 'sort_id' => $ccount ); 
		$enmse_where = array( 'file_id' => $file ); 			
		$wpdb->update( $wpdb->prefix . "se_files", $enmse_new_values, $enmse_where );
		$ccount = $ccount + 1; 
	}
}

die();

?>