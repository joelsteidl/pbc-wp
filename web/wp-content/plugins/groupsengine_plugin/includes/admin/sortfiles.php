<?php /* ----- Groups Engine - Sort Files in admin ----- */


global $wpdb;

if ($_POST) {
	parse_str($_REQUEST['frow'], $ufiles);

	$ccount = 1;
	foreach ($ufiles['row'] as $file) {
		$enmge_new_values = array( 'sort_id' => $ccount ); 
		$enmge_where = array( 'file_id' => $file ); 			
		$wpdb->update( $wpdb->prefix . "ge_files", $enmge_new_values, $enmge_where );
		$ccount = $ccount + 1; 
	}
}

die();

?>