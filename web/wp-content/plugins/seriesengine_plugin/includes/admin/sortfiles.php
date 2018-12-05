<?php /* ----- Series Engine - Sort Files in admin ----- */

require_once( '../loadwpfiles.php' );
header('HTTP/1.1 200 OK');

global $wpdb;

if ($_POST) {
	$ufiles = $_POST['frow'];

	$ccount = 1;
	foreach ($ufiles as $file) {
		$enmse_new_values = array( 'sort_id' => $ccount ); 
		$enmse_where = array( 'file_id' => $file ); 			
		$wpdb->update( $wpdb->prefix . "se_files", $enmse_new_values, $enmse_where );
		$ccount = $ccount + 1; 
	}
}

?>