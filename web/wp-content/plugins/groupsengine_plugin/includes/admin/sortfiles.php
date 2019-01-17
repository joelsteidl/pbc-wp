<?php /* ----- Groups Engine - Sort Files in admin ----- */

require_once( '../loadwpfiles.php' );
header('HTTP/1.1 200 OK');

global $wpdb;

if ($_POST) {
	$ufiles = $_POST['row'];

	$ccount = 1;
	foreach ($ufiles as $file) {
		$enmge_new_values = array( 'sort_id' => $ccount ); 
		$enmge_where = array( 'file_id' => $file ); 			
		$wpdb->update( $wpdb->prefix . "ge_files", $enmge_new_values, $enmge_where );
		$ccount = $ccount + 1; 
	}
}

?>