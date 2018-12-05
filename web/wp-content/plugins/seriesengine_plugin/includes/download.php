<?php 
	require_once( 'loadwpfiles.php' );

if ( isset($_GET['enmsepath']) ) {

	$filepath = strip_tags($_GET['enmsepath']);
	$filename = basename($filepath);
	header('Content-disposition: attachment; filename=' . $filename);
	if ( preg_match('/(.mp3)/', $filepath) ) { // Find correct MIME type
		$contenttype = 'audio/mpeg';
	} elseif ( preg_match('/(.m4a)/', $filepath) || preg_match('/(.aac)/', $filepath) || preg_match('/(.m4p)/', $filepath) ) {
		$contenttype = 'audio/mp4a-latm';
	} elseif ( preg_match('/(.ogg)/', $filepath) ) {
		$contenttype = 'application/ogg';
	}
	header('Content-type: ' . $contenttype);
	readfile($filepath);
}

 ?>