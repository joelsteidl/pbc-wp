<?php /* ----- Series Engine - Sort Files in admin ----- */

require_once( '../loadwpfiles.php' );
header('HTTP/1.1 200 OK');

global $wpdb;

if ($_POST) {
	$uscripture = $_POST['row'];

	$ccount = 1;
	foreach ($uscripture as $scripture) {
		$enmse_new_values = array( 'sort_id' => $ccount ); 
		$enmse_where = array( 'scripture_id' => $scripture ); 			
		$wpdb->update( $wpdb->prefix . "se_scriptures", $enmse_new_values, $enmse_where );
		$ccount = $ccount + 1; 
	}
}

?>