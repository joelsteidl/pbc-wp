<?php /* Series Engine - Uninstall the Plugin */

// If uninstall not called from WordPress exit 

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit (); 

	global $wpdb;
	if (function_exists('is_multisite') && is_multisite()) {
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog['blog_id']);
			enm_seriesengine_uninstall();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		enm_seriesengine_uninstall();
	}	

function enm_seriesengine_uninstall() { 
	// Delete option from options table 

	delete_option( 'enm_seriesengine_options' ); 
	delete_option('enmse_db_version');

	//remove any additional options and custom tables 

	global $wpdb;
	$dmtmatches = $wpdb->prefix . "se_message_topic_matches";
	$dmessages = $wpdb->prefix . "se_messages";
	$dpodcasts = $wpdb->prefix . "se_podcasts";
	$dseries = $wpdb->prefix . "se_series";
	$dsmmatches = $wpdb->prefix . "se_series_message_matches";
	$dstmatches = $wpdb->prefix . "se_series_type_matches";
	$dseriestypes = $wpdb->prefix . "se_series_types";
	$dtopics = $wpdb->prefix . "se_topics";
	$dspeakers = $wpdb->prefix . "se_speakers";
	$dmspmatches = $wpdb->prefix . "se_message_speaker_matches";
	$dmfmatches = $wpdb->prefix . "se_message_file_matches";
	$dfiles = $wpdb->prefix . "se_files";
	$dbooks = $wpdb->prefix . "se_books";
	$dbmmatches = $wpdb->prefix . "se_book_message_matches";
	$dscriptures = $wpdb->prefix . "se_scriptures";
	$dscmmatches = $wpdb->prefix . "se_scripture_message_matches";
	$wpdb->query("DROP TABLE IF EXISTS $dbooks, $dbmmatches, $dscriptures, $dscmmatches, $dmtmatches, $dmessages, $dpodcasts, $dseries, $dsmmatches, $dstmatches, $dseriestypes, $dtopics, $dspeakers, $dmspmatches, $dfiles, $dmfmatches");

	$enmse_cptdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'enmse_message'";
	$enmse_cptdeleted = $wpdb->query( $enmse_cptdelete_query_preparred );

	$enmse_ctpmdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "postmeta" . " WHERE meta_key = 'enmse_mid'"; 
	$enmse_ctpmdeleted = $wpdb->query( $enmse_ctpmdelete_query );
}
?>