<?php /* ----- Series Engine - Admin User Guide ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		if ( $_POST ) {
			global $wpdb;
			$filename=$_FILES["file"]["tmp_name"];		

 
			 if($_FILES["file"]["size"] > 0)
			 {
			  	$file = fopen($filename, "r");
		        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		         {
		         	if ( $getData[0] == "message" ) {
		         		$enmse_newrecord = array(
							'message_id' => $getData[1], 
							'title' => $getData[2],
							'speaker' => $getData[3],
							'date' => $getData[4],
							'alternate_date' => $getData[5],
							'description' => $getData[6],
							'message_length' => $getData[7],
							'message_thumbnail' => $getData[8],
							'audio_url' => $getData[9],
							'message_video_length' => $getData[10],
							'video_url' => $getData[11],
							'embed_code' => $getData[12],
							'alternate_toggle' => $getData[13],
							'alternate_embed' => $getData[14],
							'alternate_label' => $getData[15],
							'audio_file_size' => $getData[16],
							'video_file_size' => $getData[17],
							'video_embed_url' => $getData[18],
							'additional_video_embed_url' => $getData[19]
						); 
						$wpdb->insert( $wpdb->prefix . "se_messages", $enmse_newrecord);
		         	} elseif ( $getData[0] == "series" ) {
	 					$enmse_newrecord = array(
							'series_id' => $getData[1], 
							's_title' => $getData[2],
							's_description' => $getData[3], 
							'thumbnail_url' => $getData[4], 
							'archived' => $getData[5], 
							'start_date' => $getData[6], 
							'graphic_thumb' => $getData[7], 
							'widget_thumb' => $getData[8]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newrecord);
					} elseif ( $getData[0] == "file" ) {
	 					$enmse_newrecord = array(
							'file_id' => $getData[1], 
							'file_name' => $getData[2],
							'file_url' => $getData[3], 
							'file_username' => $getData[4], 
							'sort_id' => $getData[5], 
							'file_new_window' => $getData[6]
						); 
						$wpdb->insert( $wpdb->prefix . "se_files", $enmse_newrecord);
					} elseif ( $getData[0] == "mfm" ) {
	 					$enmse_newrecord = array(
							'mf_match_id' => $getData[1], 
							'message_id' => $getData[2],
							'file_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_file_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "msp" ) {
	 					$enmse_newrecord = array(
							'msp_match_id' => $getData[1], 
							'message_id' => $getData[2],
							'speaker_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_speaker_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "mtm" ) {
	 					$enmse_newrecord = array(
							'mt_match_id' => $getData[1], 
							'message_id' => $getData[2],
							'topic_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_message_topic_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "podcast" ) {
		         		$enmse_newrecord = array(
							'se_podcast_id' => $getData[1], 
							'series_id' => $getData[2],
							'topic_id' => $getData[3],
							'speaker_id' => $getData[4],
							'series_type_id' => $getData[5],
							'title' => $getData[6],
							'description' => $getData[7],
							'author' => $getData[8],
							'email' => $getData[9],
							'logo_url' => $getData[10],
							'category' => $getData[11],
							'subcategory' => $getData[12],
							'audio_video' => $getData[13],
							'podcast_display' => $getData[14],
							'link_url' => $getData[15],
							'explicit' => $getData[16],
							'redirect_podcast' => $getData[17],
							'redirect_url' => $getData[18]
						); 
						$wpdb->insert( $wpdb->prefix . "se_podcasts", $enmse_newrecord);
		         	} elseif ( $getData[0] == "smm" ) {
	 					$enmse_newrecord = array(
							'sm_match_id' => $getData[1], 
							'message_id' => $getData[2],
							'series_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "stm" ) {
	 					$enmse_newrecord = array(
							'st_match_id' => $getData[1], 
							'series_id' => $getData[2],
							'series_type_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newrecord);
					} elseif ( $getData[0] == "seriestype" ) {
	 					$enmse_newrecord = array(
							'series_type_id' => $getData[1], 
							'name' => $getData[2],
							'description' => $getData[3],
							'sort_id' => $getData[4]
						); 
						$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newrecord);
					} elseif ( $getData[0] == "speaker" ) {
	 					$enmse_newrecord = array(
							'speaker_id' => $getData[1], 
							'first_name' => $getData[2],
							'last_name' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_speakers", $enmse_newrecord);
					} elseif ( $getData[0] == "topic" ) {
	 					$enmse_newrecord = array(
							'topic_id' => $getData[1], 
							'name' => $getData[2],
							'sort_id' => $getData[3]
						); 
						$wpdb->insert( $wpdb->prefix . "se_topics", $enmse_newrecord);
					}

		         }
				
		         fclose($file);	
			 }
		}
	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap"> 
    <div></div>
	<h2 class="enmse">Import</h2>
	<p>Here we go!</p>

	<form class="form-horizontal" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
 
                        <!-- Form Name -->
                        <legend>Form Name</legend>
 
                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Select File</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
 
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                            </div>
                        </div>
 
                    </fieldset>
                </form>

</div>
<?php  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>