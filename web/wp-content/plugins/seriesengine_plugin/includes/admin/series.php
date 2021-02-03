<?php /* ----- Series Engine - Add, edit and remove Series ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		
		$enmse_dateformat = get_option( 'date_format' );
		$enmse_options = get_option( 'enm_seriesengine_options' ); 
		if ( isset($enmse_options['newgraphicwidth']) ) { // Find the width of the series graphics
			$enmse_embedwidth = $enmse_options['newgraphicwidth'];
		} else {
			$enmse_embedwidth = 1000;
		}

		if ( isset($enmse_options['seriest']) ) { // Find Series Title
			$enmseseriest = $enmse_options['seriest'];
		} else {
			$enmseseriest = "Series";
		}

		if ( isset($enmse_options['seriestp']) ) { // Find Series Title (plural)
			$enmseseriestp = $enmse_options['seriestp'];
		} else {
			$enmseseriestp = "Series";
		}

		if ( isset($enmse_options['messagetp']) ) { // Find Series Title (plural)
			$enmsemessagetp = $enmse_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		}

		if ( isset($enmse_options['newarchiveswidth']) ) { // Find the width of the archives graphic
			$enmsearchivethumb = $enmse_options['newarchiveswidth'];
		} else {
			$enmsearchivethumb = 600;
		}

		if ( isset($enmse_options['widgetwidth']) ) { // Find the width of the Series Widget
			$enmsewidgetthumb = $enmse_options['widgetwidth'];
		} else {
			$enmsewidgetthumb = 200;
		}
		
		$enmse_errors = array(); //Set up errors array
		$enmse_messages = array(); //Set up messages array
		
		if ( $_POST && isset($_GET['enmse_did']) ) { // If deleting a topic
			$enmse_deleted_id = strip_tags($_POST['series_delete']);
			$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_series" . " WHERE series_id=%d";
			$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_deleted_id ); 
			$enmse_deleted = $wpdb->query( $enmse_delete_query ); 
			
			$enmse_stdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_series_type_matches" . " WHERE series_id=%d";
			$enmse_stdelete_query = $wpdb->prepare( $enmse_stdelete_query_preparred, $enmse_deleted_id ); 
			$enmse_stdeleted = $wpdb->query( $enmse_stdelete_query );
			
			$enmse_smdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_series_message_matches" . " WHERE series_id=%d";
			$enmse_smdelete_query = $wpdb->prepare( $enmse_smdelete_query_preparred, $enmse_deleted_id ); 
			$enmse_smdeleted = $wpdb->query( $enmse_smdelete_query );

			$enmse_messages[] = "The series was successfully deleted.";
		}
		
		if ( isset($_GET['enmse_action']) ) {
			$enmse_single_created = null;

			if ( $_GET['enmse_action'] == 'edit' ) { // Edit Series
				if ( $_POST ) {
					
					$enmse_archived = strip_tags($_POST['series_archived']);
					
					if (empty($_POST['series_s_title'])) { 
						$enmse_errors[] = '- You must name the series.';
					} else {
						$enmse_s_title = strip_tags($_POST['series_s_title']);
					}
					
					$enmse_s_description = $_POST['series_s_description'];
					
					if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['series_start_date'])) { 
						$enmse_start_date = strip_tags($_POST['series_start_date']);
					} else {
						$enmse_errors[] = '- You must provide a valid start date.';
					};
					
					
					$enmse_thumbnail_url = strip_tags($_POST['series_thumbnail_url']);

					$enmse_graphic_thumb = strip_tags($_POST['series_graphic_thumb']);

					$enmse_widget_thumb = strip_tags($_POST['series_widget_thumb']);

					$enmse_podcast_image = strip_tags($_POST['series_podcast_image']);
					
					if ($_POST['series_type'] != NULL) {
						$enmse_series_types = $_POST['series_type'];
					} else {
						$enmse_errors[] = '- You must choose at least one series type.';
					}
					
					if (empty($enmse_errors)) {
						if ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) {
							$enmse_sid = strip_tags($_GET['enmse_sid']);
						}

						$enmse_findthemessagessql = "SELECT message_id FROM " . $wpdb->prefix . "se_messages" . " WHERE primary_series = %d"; 
						$enmse_findthemessages = $wpdb->prepare( $enmse_findthemessagessql, $enmse_sid );
						$enmse_allmessages = $wpdb->get_results( $enmse_findthemessages );

						foreach ($enmse_allmessages as $m) {
							$enmse_new_mvalues = array( 'series_thumbnail' => $enmse_graphic_thumb, 'series_image' => $enmse_thumbnail_url, 'series_podcast_image' => $enmse_podcast_image ); 
							$enmse_mwhere = array( 'message_id' => $m->message_id ); 
							$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere ); 
						}
						
						$enmse_new_values = array( 'archived' => $enmse_archived, 's_title' => $enmse_s_title, 's_description' => $enmse_s_description, 'start_date' => $enmse_start_date, 'thumbnail_url' => $enmse_thumbnail_url, 'graphic_thumb' => $enmse_graphic_thumb, 'widget_thumb' => $enmse_widget_thumb, 'podcast_image' => $enmse_podcast_image ); 
						$enmse_where = array( 'series_id' => $enmse_sid ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_values, $enmse_where ); 
						$enmse_messages[] = "Series successfully updated!";
						
						// Delete old Series Type Matches
						$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_series_type_matches" . " WHERE series_id=%d";
						$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_sid ); 
						$enmse_deleted = $wpdb->query( $enmse_delete_query );
						
						// Add series type relations in the DB
						foreach ($enmse_series_types as $st) {
							$enmse_newstm = array(
								'series_id' => $enmse_sid, 
								'series_type_id' => $st
								); 
							$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newstm );
						}

						$enmse_findtheseriessql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 
						$enmse_findtheseries = $wpdb->prepare( $enmse_findtheseriessql, $enmse_sid );
						$enmse_single = $wpdb->get_row( $enmse_findtheseries, OBJECT );
						$enmse_singlecount = $wpdb->num_rows;

						// Get All Series Type Matches
						$enmse_preparredsstmsql = "SELECT series_type_id, series_id FROM " . $wpdb->prefix . "se_series_type_matches" . " WHERE series_id = %d"; 
						$enmse_sstmsql = $wpdb->prepare( $enmse_preparredsstmsql, $enmse_single->series_id );
						$enmse_sstm = $wpdb->get_results( $enmse_sstmsql );
					} else {
						if ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) {
							$enmse_sid = strip_tags($_GET['enmse_sid']);
						}
						
						$enmse_findtheseriessql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 
						$enmse_findtheseries = $wpdb->prepare( $enmse_findtheseriessql, $enmse_sid );
						$enmse_single = $wpdb->get_row( $enmse_findtheseries, OBJECT );
						$enmse_singlecount = $wpdb->num_rows;

						// Get All Series Type Matches
						$enmse_preparredsstmsql = "SELECT series_type_id, series_id FROM " . $wpdb->prefix . "se_series_type_matches" . " WHERE series_id = %d"; 
						$enmse_sstmsql = $wpdb->prepare( $enmse_preparredsstmsql, $enmse_single->series_id );
						$enmse_sstm = $wpdb->get_results( $enmse_sstmsql );
					}

					
				} else {
					if ( isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid']) ) {
						$enmse_sid = strip_tags($_GET['enmse_sid']);
					}

					$enmse_findtheseriessql = "SELECT * FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 
					$enmse_findtheseries = $wpdb->prepare( $enmse_findtheseriessql, $enmse_sid );
					$enmse_single = $wpdb->get_row( $enmse_findtheseries, OBJECT );
					$enmse_singlecount = $wpdb->num_rows;
					
					// Get All Series Type Matches
					$enmse_preparredsstmsql = "SELECT series_type_id, series_id FROM " . $wpdb->prefix . "se_series_type_matches" . " WHERE series_id = %d"; 
					$enmse_sstmsql = $wpdb->prepare( $enmse_preparredsstmsql, $enmse_single->series_id );
					$enmse_sstm = $wpdb->get_results( $enmse_sstmsql );
				}	
			}
			
			if ( $_GET['enmse_action'] == 'new' && !isset($_GET['enmse_did']) ) { // New Topic
				
				if ( $_POST ) {
					if (empty($_POST['series_s_title'])) { 
						$enmse_errors[] = '- You must name the new series.';
					} else {
						$enmse_s_title = strip_tags($_POST['series_s_title']);
					}
					
					
					$enmse_s_description = $_POST['series_s_description'];
					
					
					if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['series_start_date'])) { 
						$enmse_start_date = strip_tags($_POST['series_start_date']);
					} else {
						$enmse_errors[] = '- You must provide a valid start date.';
					};
					
					
					$enmse_thumbnail_url = strip_tags($_POST['series_thumbnail_url']);

					$enmse_graphic_thumb = strip_tags($_POST['series_graphic_thumb']);

					$enmse_widget_thumb = strip_tags($_POST['series_widget_thumb']);

					$enmse_podcast_image = strip_tags($_POST['series_podcast_image']);
					
					if (isset($_POST['series_type']) && $_POST['series_type'] != NULL) {
						$enmse_series_types = $_POST['series_type'];
					} else {
						$enmse_errors[] = '- You must choose at least one series type.';
					}
					
					$enmse_archived = 0;

					if (empty($enmse_errors)) {
						$enmse_single_created = "yes";

						$enmse_newseries = array(
							's_title' => $enmse_s_title, 
							's_description' => $enmse_s_description,
							'start_date' => $enmse_start_date,
							'thumbnail_url' => $enmse_thumbnail_url,
							'archived' => $enmse_archived,
							'graphic_thumb' => $enmse_graphic_thumb,
							'widget_thumb' => $enmse_widget_thumb,
							'podcast_image' => $enmse_podcast_image
							); 
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newseries );
						$enmpe_new_series_id = $wpdb->insert_id; 
						
						// Add series type relations in the DB
						foreach ($enmse_series_types as $st) {
							$enmse_newstm = array(
								'series_id' => $enmpe_new_series_id, 
								'series_type_id' => $st
								); 
							$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newstm );
						}
						
						$enmse_messages[] = "You have successfully added a new series to Series Engine!";
					}
				}

			}
		}
		
		include ('paginated_series.php'); // Get all series
		
		if ( isset($_GET['enmse_stid']) ) {
			$enmse_findtheseriestypesql = "SELECT name FROM " . $wpdb->prefix . "se_series_types" . " WHERE series_type_id = %d"; 
			$enmse_findtheseriestype = $wpdb->prepare( $enmse_findtheseriestypesql, $enmse_stid );
			$enmse_series_type = $wpdb->get_row( $enmse_findtheseriestype, OBJECT );
		}
		
		// Get All Series Types
		$enmse_preparredstsql = "SELECT series_type_id, name FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
		$enmse_sts = $wpdb->get_results( $enmse_preparredstsql );
		
		// Get All Series Type Matches
		$enmse_preparredstmsql = "SELECT series_type_id, series_id FROM " . $wpdb->prefix . "se_series_type_matches"; 
		$enmse_stm = $wpdb->get_results( $enmse_preparredstmsql );
		
		// Get All Series Message Matches
		$enmse_preparredsmmsql = "SELECT message_id, series_id FROM " . $wpdb->prefix . "se_series_message_matches"; 
		$enmse_smm = $wpdb->get_results( $enmse_preparredsmmsql );
	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap"> 
<?php if ( isset($_GET['enmse_action']) && ( $enmse_single_created == null&& !isset($_GET['enmse_did']) ) ) { if ( $_GET['enmse_action'] == 'new' ) { // If they're adding a new Series ?>
		<link rel='stylesheet' href='<?php echo plugins_url() .'/seriesengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
		<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/series_options.js'; ?>" ></script>
		
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#series_start_date").datepicker({ dateFormat: 'yy-mm-dd' });
			});
		</script>
		
		<h2 class="enmse">Add a New <?php echo $enmseseriest; ?></h2>
		<?php include ('errorbox.php'); ?>
		<p>Use the form below to enter a new <?php echo $enmseseriest; ?> into the Series Engine. Remember that a <?php echo $enmseseriest; ?> will only be publicly visible if it has Messages associated with it that contain video, audio or an alternate video. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-series"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmseseriest; ?> (Series)...</a></p>
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Name:</strong></th>
					<td><input id='series_s_title' name='series_s_title' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['series_s_title']));} ?>" tabindex="1" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Description:</th>
					<td>
						<textarea name="series_s_description" id="series_s_description" rows="8" cols="40" tabindex="2"><?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['series_s_description']));} ?></textarea><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Start Date:</strong></th>
					<td><input id='series_start_date' name='series_start_date' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_start_date'];} ?>' tabindex="3" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						URL To <?php echo $enmseseriest; ?> Graphic:
						<p class="se-form-instructions">For best results, we recommend a 16x9 graphic that is at least 1000px wide. Yours are set to <strong><?php echo $enmse_embedwidth; ?>px</strong> wide in Settings.</p>
					</th>
					<td><input id='series_thumbnail_url' name='series_thumbnail_url' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_thumbnail_url'];} ?>' tabindex="4" /> &nbsp;<a href="#" class="enmse-upload-series-graphic se-upload-link" id="content-add_media" title="Add Media"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="series-thumb-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['series_thumbnail_url'])) { ?><br /><img src="<?php echo $_POST['series_thumbnail_url']; ?>" /><?php }; ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php echo $enmseseriest; ?> Archives Graphic:
						<p class="se-form-instructions">For best results, all archive graphics should have the same aspect ratio. We recommend a 16x9 graphic that is at least 600px wide. Yours are set to <strong><?php echo $enmsearchivethumb; ?>px</strong> wide in Settings</p>
					</th>
					<td><input id='series_graphic_thumb' name='series_graphic_thumb' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_graphic_thumb'];} ?>' tabindex="5" /> &nbsp;<a href="#" class="enmse-upload-series-graphic-thumb se-upload-link" id="content-add_media" title="Add Media"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="archive-thumb-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['series_graphic_thumb'])) { ?><br /><img src="<?php echo $_POST['series_graphic_thumb']; ?>" /><?php }; ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Widget Graphic:
						<p class="se-form-instructions">According to your settings, upload a graphic that's <strong><?php echo $enmsewidgetthumb; ?>px</strong> wide.</p>
					</th>
					<td><input id='series_widget_thumb' name='series_widget_thumb' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_widget_thumb'];} ?>' tabindex="6" /> &nbsp;<a href="#" class="enmse-upload-series-widget-thumb se-upload-link" id="content-add_media" title="Add Media"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="widget-thumb-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['series_widget_thumb'])) { ?><br /><img src="<?php echo $_POST['series_widget_thumb']; ?>" /><?php }; ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Podcast Graphic:
						<p class="se-form-instructions">This graphic will be used for <?php echo $enmsemessagetp; ?> associated with this <?php echo $enmseseriest; ?> in all podcast feeds. The image must be at least 1400px x 1400px, and a max of 3000px x 3000px.</p>
					</th>
					<td><input id='series_podcast_image' name='series_podcast_image' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_podcast_image'];} ?>' tabindex="7" /> &nbsp;<a href="#" class="enmse-upload-series-podcast-image se-upload-link" id="content-add_media" title="Add Media"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="podcast-image-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['series_podcast_image'])) { ?><br /><img src="<?php echo $_POST['series_podcast_image']; ?>" /><?php } ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong><?php echo $enmseseriest; ?> Type(s):</strong></th>
					<td>
						<ul class="enmse-series-topic">
						<?php foreach ($enmse_sts as $enmse_st) {  ?>
							<li><input name="series_type[]" type="checkbox" value="<?php echo $enmse_st->series_type_id; ?>" <?php if ($_POST && !empty($enmse_errors)) {if (isset($_POST['series_type']) && $_POST['series_type'] != NULL) {foreach ($_POST['series_type'] as $st) { if ($st == $enmse_st->series_type_id) { ?>checked="checked"<?php }}}} ?> class="check" /> <label for="series_type[]"> <?php echo stripslashes($enmse_st->name); ?></label></li>
						<?php }; ?>
						</ul>
					</td>
				</tr>
				
			</table>
			<input type="hidden" name="enmseembedwidth" value="<?php echo $enmse_embedwidth; ?>" id="enmseembedwidth" />
			<input type="hidden" name="enmsearchivethumb" value="<?php echo $enmsearchivethumb; ?>" id="enmsearchivethumb" />
			<input type="hidden" name="enmsewidgetthumb" value="<?php echo $enmsewidgetthumb; ?>" id="enmsewidgetthumb" />
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add New <?php echo $enmseseriest; ?>" tabindex="7" /></p>
		</form>
		<p><a href="<?php if ( isset($_GET['enmse_p']) ) { if ( isset($_GET['enmse_stid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_stid=' . $enmse_stid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ );} } else { if ( isset($_GET['enmse_stid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_stid=' . $enmse_stid, __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series', __FILE__ ); }} ?>">&laquo; All <?php echo $enmseseriestp; ?></a></p>
		<?php include ('secredits.php'); ?>
<?php } elseif ( ($_GET['enmse_action'] == 'edit') && ( $enmse_singlecount == 1 ) ) { // Edit Series ?>
	<link rel='stylesheet' href='<?php echo plugins_url() .'/seriesengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/series_options.js'; ?>" ></script>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#series_start_date").datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>
	
	<h2 class="enmse">Edit <?php echo $enmseseriest; ?> <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Use the form below to update the <?php echo $enmseseriest; ?> within the Series Engine. Remember that a <?php echo $enmseseriest; ?> will only be publicly visible if it has Messages associated with it that contain video, audio or an alternate video. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-series"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmseseriest; ?> (Series)...</a></p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><strong>Name:</strong></th>
				<td><input id='series_s_title' name='series_s_title' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['series_s_title']));} else { echo htmlspecialchars(stripslashes($enmse_single->s_title)); } ?>" tabindex="1" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Description:</th>
				<td>
					<textarea name="series_s_description" id="series_s_description" rows="8" cols="40" tabindex="2"><?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['series_s_description']));} else { echo htmlspecialchars(stripslashes($enmse_single->s_description)); } ?></textarea><br />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><strong>Start Date:</strong></th>
				<td><input id='series_start_date' name='series_start_date' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_start_date'];} else { echo $enmse_single->start_date; } ?>' tabindex="3" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php echo $enmseseriest; ?> Graphic:
					<p class="se-form-instructions">For best results, we recommend a 16x9 graphic that is at least 1000px wide. Yours are set to <strong><?php echo $enmse_embedwidth; ?>px</strong> wide in Settings.</p>
				</th>
				<td><input id='series_thumbnail_url' name='series_thumbnail_url' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_thumbnail_url'];} else { echo $enmse_single->thumbnail_url; } ?>' tabindex="4" /> &nbsp;<a href="#" class="enmse-upload-series-graphic se-upload-link" id="content-add_media" title="Add Media"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="series-thumb-load"><?php if ( $enmse_single->thumbnail_url != NULL ) { ?><br /><img src="<?php echo $enmse_single->thumbnail_url; ?>" /><?php }; ?></div></td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php echo $enmseseriest; ?> Archives Graphic:
					<p class="se-form-instructions">For best results, all archive graphics should have the same aspect ratio. We recommend a 16x9 graphic that is at least 600px wide. Yours are set to <strong><?php echo $enmsearchivethumb; ?>px</strong> wide in Settings</p>
				</th>
				<td><input id='series_graphic_thumb' name='series_graphic_thumb' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_graphic_thumb'];} else { echo $enmse_single->graphic_thumb; } ?>' tabindex="5" /> &nbsp;<a href="#" class="enmse-upload-series-graphic-thumb se-upload-link" id="content-add_media" title="Add Media"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="archive-thumb-load"><?php if ( $enmse_single->graphic_thumb != NULL ) { ?><br /><img src="<?php echo $enmse_single->graphic_thumb; ?>" /><?php }; ?></div></td>
			</tr>
			<tr valign="top">
				<th scope="row">
					Widget Graphic:
					<p class="se-form-instructions">According to your settings, upload a graphic that's <strong><?php echo $enmsewidgetthumb; ?>px</strong> wide.</p>
				</th>
				<td><input id='series_widget_thumb' name='series_widget_thumb' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_widget_thumb'];} else { echo $enmse_single->widget_thumb; } ?>' tabindex="6" /> &nbsp;<a href="#" class="enmse-upload-series-widget-thumb se-upload-link" id="content-add_media" title="Add Media"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="widget-thumb-load"><?php if ( $enmse_single->widget_thumb != NULL ) { ?><br /><img src="<?php echo $enmse_single->widget_thumb; ?>" /><?php }; ?></div></td>
			</tr>
			<tr valign="top">
				<th scope="row">
					Podcast Graphic:
					<p class="se-form-instructions">This graphic will be used for <?php echo $enmsemessagetp; ?> associated with this <?php echo $enmseseriest; ?> in all podcast feeds. The image must be at least 1400px x 1400px, and a max of 3000px x 3000px.</p>
				</th>
				<td><input id='series_podcast_image' name='series_podcast_image' type='text' value='<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['series_podcast_image'];} else { echo $enmse_single->podcast_image; } ?>' tabindex="7" /> &nbsp;<a href="#" class="enmse-upload-series-podcast-image se-upload-link" id="content-add_media" title="Add Media"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="se-media-button" /> &nbsp;Upload Image</a><div id="podcast-image-load"><?php if ($_POST && !empty($enmse_errors) && !empty($_POST['series_podcast_image'])) { ?><br /><img src="<?php echo $_POST['series_podcast_image']; ?>" /><?php } elseif ( $enmse_single->podcast_image != NULL ) { ?><br /><img src="<?php echo $enmse_single->podcast_image; ?>" /><?php }; ?></div></td>
			</tr>
			<tr valign="top">
				<th scope="row"><strong><?php echo $enmseseriest; ?> Type(s):</strong></th>
				<td>
					<ul class="enmse-series-topic">
					<?php foreach ($enmse_sts as $enmse_st) {  ?>
						<?php if ( $_POST && !empty($enmse_errors) ) { ?>
						<li><input name="series_type[]" type="checkbox" value="<?php echo $enmse_st->series_type_id; ?>" <?php if (isset($_POST['series_type']) && $_POST['series_type'] != NULL) {foreach ($_POST['series_type'] as $st) { if ($st == $enmse_st->series_type_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="series_type[]"> <?php echo stripslashes($enmse_st->name); ?></label></li>
						<?php } else { ?>
						<li><input name="series_type[]" type="checkbox" value="<?php echo $enmse_st->series_type_id; ?>" <?php if ($enmse_sstm != NULL) {foreach ($enmse_sstm as $st) { if ($st->series_type_id == $enmse_st->series_type_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="series_type[]"> <?php echo stripslashes($enmse_st->name); ?></label></li>	
						<?php } ?>
					<?php }; ?>
					</ul>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo $enmseseriest; ?> Archived?:</th>
				<td>
					<select name="series_archived" id="series_archived" tabindex="8">
						<option value="0" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['series_archived'] == 0) { ?>selected="selected"<?php }} else {if ($enmse_single->archived == 0) { ?>selected="selected"<?php }} ?>>No</option>
						<option value="1" <?php if ($_POST && !empty($enmse_errors)) {if ($_POST['series_archived'] == 1) { ?>selected="selected"<?php }} else {if ($enmse_single->archived == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
					</select>
				</td>
			</tr>
		</table>
		<input type="hidden" name="enmseembedwidth" value="<?php echo $enmse_embedwidth; ?>" id="enmseembedwidth" />
		<input type="hidden" name="enmsearchivethumb" value="<?php echo $enmsearchivethumb; ?>" id="enmsearchivethumb" />
		<input type="hidden" name="enmsewidgetthumb" value="<?php echo $enmsewidgetthumb; ?>" id="enmsewidgetthumb" />
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Save Changes" tabindex="8" /></p>
	</form>
	<p><a href="<?php if ( isset($_GET['enmse_p']) ) { if ( isset($_GET['enmse_stid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_stid=' . $enmse_stid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ );} } else { if ( isset($_GET['enmse_stid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_stid=' . $enmse_stid, __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series', __FILE__ ); }} ?>">&laquo; All <?php echo $enmseseriestp; ?></a></p>
	
	<?php include ('secredits.php'); ?>
<?php }} else { // Display the main listing of Series ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/deleteseries.js'; ?>"></script>

	<h2 class="enmse">Create and Edit <?php echo $enmseseriestp; ?> <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>
	<p>All <?php echo $enmseseriestp; ?> are listed in the table below. Click the name of the <?php echo $enmseseriest; ?> to edit it. Click a Series Type to view other <?php echo $enmseseriest; ?> with the same type; click the number of messages to view the Messages currently associated with the <?php echo $enmseseriest; ?>. A <?php echo $enmseseriest; ?> that <em>doesn't have any <?php echo $enmsemessagetp; ?> associated with it</em> can be permanently removed from the Series Engine by clicking "Delete" on the right. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-series"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmseseriest; ?> (Series)...</a></p>
	<?php if ( isset($_GET['enmse_stid']) ) { ?>
	<h3>Listing all <?php echo $enmseseriestp; ?> with the <?php echo $enmseseriest; ?> Type "<?php echo $enmse_series_type->name; ?>..." <span style="font-weight: 300; font-size: 12px"><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series'); ?>">(remove filter)</a></span></h3>
	<?php } ?>
	<?php include ('pagination.php'); ?>
	<table class="widefat"> 
		<thead> 
			<tr> 
				<th>Name</th> 
				<th>Start Date</th>
				<th><?php echo $enmseseriest; ?> Type</th>
				<th>Num. Messages</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmse_series as $enmse_single ) { ?>
			<tr>
				<td><a href="<?php if ( isset($_GET['enmse_p']) ) { if ( isset($_GET['enmse_stid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_action=edit&amp;enmse_sid=' . $enmse_single->series_id . '&amp;enmse_stid=' . $enmse_stid . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_action=edit&amp;enmse_sid=' . $enmse_single->series_id . '&amp;enmse_p=' . $_GET['enmse_p'] . '&amp;enmse_c=' . $_GET['enmse_c'], __FILE__ );} } else { if ( isset($_GET['enmse_stid']) ) { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_action=edit&amp;enmse_sid=' . $enmse_single->series_id . '&amp;enmse_stid=' . $enmse_stid, __FILE__ ); } else { echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_action=edit&amp;enmse_sid=' . $enmse_single->series_id, __FILE__ ); }} ?>"><?php echo stripslashes($enmse_single->s_title) ?></a> <?php if ( $enmse_single->archived == 1 ) {echo "(Archived)";} ?></td>
				<td><?php echo date_i18n($enmse_dateformat, strtotime($enmse_single->start_date)) ?></td>
				<td><?php $enmse_st_comma = 1; foreach ( $enmse_sts as $st) { ?><?php foreach ( $enmse_stm as $stm) { ?><?php if ( ($stm->series_id == $enmse_single->series_id) && ($stm->series_type_id == $st->series_type_id) ) { if ( $enmse_st_comma == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_stid=' . $st->series_type_id, __FILE__ ) . "\">" . stripslashes($st->name) . "</a>"; $enmse_st_comma = $enmse_st_comma+1; } else { echo ", <a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_stid=' . $st->series_type_id, __FILE__ ) . "\">" . stripslashes($st->name) . "</a>"; $enmse_st_comma = $enmse_st_comma+1; } } ?><?php } ?><?php } ?></td>
				<td><?php $enmse_smm_count = 0; foreach ( $enmse_smm as $smm ) { ?><?php if ( $smm->series_id == $enmse_single->series_id ) { $enmse_smm_count = $enmse_smm_count+1; } ?><?php } ?><?php if ( $enmse_smm_count == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_sid=' . $enmse_single->series_id , __FILE__ ) . "\">1 Message</a>"; } elseif ( $enmse_smm_count > 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php&amp;enmse_sid=' . $enmse_single->series_id , __FILE__ ) . "\">" . $enmse_smm_count . " Messages</a>"; } ?></td>
				<td class="enmse-delete"><?php if ( $enmse_smm_count >= 1 ) {} else { ?><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmse_did=1" method="post" id="seriesengine-deleteform<?php echo $enmse_single->series_id ?>"><input type="hidden" name="series_delete" value="<?php echo $enmse_single->series_id ?>"></form><a href="#" class="seriesengine_delete" name="<?php echo $enmse_single->series_id ?>">Delete</a><?php }; ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php include ('secredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
