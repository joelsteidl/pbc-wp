<?php /* Series Engine - Export Series Engine Styles and Settings */
	require_once( '../../loadwpfiles.php' );

	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8', true, 200);
	header('Content-Disposition: attachment; filename=series_engine_settings.csv');

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');

	// output the column headings
	//fputcsv($output, array('Name', 'Email Address'));

// loop over the rows, outputting them

	
	if ( current_user_can( 'edit_posts' ) ) { 
		
		if ( $_POST ) {
			global $wpdb;

			$enmse_options = get_option( 'enm_seriesengine_options' );
			$optionsrow[] = "options";
			$optionsrow[] = serialize($enmse_options);
			fputcsv($output, $optionsrow);
			unset($optionsrow);
		}

	} else {
		exit("Access Denied");
	} 
?>