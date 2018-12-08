<?php

require '../../../../../../wp-blog-header.php'; // ADJUST THIS PATH if using a non-standard WordPress install

if ( current_user_can( 'edit_posts' ) ) { 

	$enmge_options = get_option( 'enm_groupsengine_options' ); 
	$enmge_grouptitle = $enmge_options['grouptitle'];
	$enmge_groupptitle = $enmge_options['groupptitle']; 
	$enmge_grouptypetitle = $enmge_options['grouptypetitle'];
	$enmge_grouptypeptitle = $enmge_options['grouptypeptitle'];
	$enmge_locationtitle = $enmge_options['locationtitle'];
	$enmge_locationptitle = $enmge_options['locationptitle'];
	$enmge_topictitle = $enmge_options['topictitle'];
	$enmge_topicptitle = $enmge_options['topicptitle'];
	if ( isset($enmge_options['offsite']) ) {
		$enmge_offsite = $enmge_options['offsite'];
	} else {
		$enmge_offsite = "Offsite";
	}
	if ( isset($enmge_options['offsitelabel']) ) {
		$enmge_offsitelabel = $enmge_options['offsitelabel'];
	} else {
		$enmge_offsitelabel = 1;
	}
	

	global $wpdb;
	
}

?>