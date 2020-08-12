<?php /* ----- Series Engine - Add edit and remove Series Types ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		$enmse_errors = array(); //Set up errors array
		$enmse_messages = array(); //Set up messages array

		$enmse_options = get_option( 'enm_seriesengine_options' ); 

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

		
		if ( $_POST && isset($_GET['enmse_did']) ) { // If deleting a series type
			$enmse_deleted_id = strip_tags($_POST['seriestype_delete']);
			$enmse_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_series_types" . " WHERE series_type_id=%d";
			$enmse_delete_query = $wpdb->prepare( $enmse_delete_query_preparred, $enmse_deleted_id ); 
			$enmse_deleted = $wpdb->query( $enmse_delete_query ); 

			$enmse_messages[] = "The series type was successfully deleted.";
		}
		
		if ( isset($_GET['enmse_action']) ) {
			$enmse_type_created = null;

			if ( $_GET['enmse_action'] == 'edit' ) { // Edit Series Type
				if ( $_POST ) {
					if ( isset($_GET['enmse_stid']) && is_numeric($_GET['enmse_stid']) ) {
						$enmse_stid = strip_tags($_GET['enmse_stid']);
					}
					
					if (empty($_POST['seriestype_name'])) { 
						$enmse_errors[] = '- You must name the series type.';
					} else {
						$enmse_name = strip_tags($_POST['seriestype_name']);
					}

					if (preg_match('/(href=)/', $_POST['seriestype_description']) || preg_match('/(HREF=)/', $_POST['seriestype_description'])) { // Simple check for spam hyperlinks
						$enmse_errors[] = '- Sorry, no HTML is allowed in the description.';
					} else {
						$enmse_description = strip_tags($_POST['seriestype_description']);
					}
					
					if (empty($enmse_errors)) {
						$enmse_new_values = array( 'name' => $enmse_name, 'description' => $enmse_description ); 
						$enmse_where = array( 'series_type_id' => $enmse_stid ); 
						$wpdb->update( $wpdb->prefix . "se_series_types", $enmse_new_values, $enmse_where ); 
						$enmse_messages[] = "Series type successfully updated!";

						$enmse_findthestsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " WHERE series_type_id = %d"; 
						$enmse_findthest = $wpdb->prepare( $enmse_findthestsql, $enmse_stid );
						$enmse_st = $wpdb->get_row( $enmse_findthest, OBJECT );
						$enmse_typecount = $wpdb->num_rows;
					} else {
						$enmse_findthestsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " WHERE series_type_id = %d"; 
						$enmse_findthest = $wpdb->prepare( $enmse_findthestsql, $enmse_stid );
						$enmse_st = $wpdb->get_row( $enmse_findthest, OBJECT );
						$enmse_typecount = $wpdb->num_rows;
					}

					
				} else {
					if ( isset($_GET['enmse_stid']) && is_numeric($_GET['enmse_stid']) ) {
						$enmse_stid = strip_tags($_GET['enmse_stid']);
					}

					$enmse_findthestsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " WHERE series_type_id = %d"; 
					$enmse_findthest = $wpdb->prepare( $enmse_findthestsql, $enmse_stid );
					$enmse_st = $wpdb->get_row( $enmse_findthest, OBJECT );
					$enmse_typecount = $wpdb->num_rows;
				}	
			}
			
			if ( ($_GET['enmse_action'] == 'new' && !isset($_GET['enmse_did']) ) && ( $_POST ) ) { // New Series Type
				if (empty($_POST['seriestype_name'])) { 
					$enmse_errors[] = '- You must name the new series type.';
				} else {
					$enmse_name = strip_tags($_POST['seriestype_name']);
				}
				
				if (preg_match('/(href=)/', $_POST['seriestype_description']) || preg_match('/(HREF=)/', $_POST['seriestype_description'])) { // Simple check for spam hyperlinks
					$enmse_errors[] = '- Sorry, no HTML is allowed in the description.';
				} else {
					$enmse_description = strip_tags($_POST['seriestype_description']);
				}
				
				if (empty($enmse_errors)) {
					$enmse_type_created = "yes";
					
					$enmse_find_highest = "SELECT sort_id FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id DESC LIMIT 1";
					$enmse_highest = $wpdb->get_row( $enmse_find_highest, OBJECT );
					
					if ( $enmse_highest == null ) {
						$enmse_sort_id = 1;
					} else {
						$enmse_makenumber = intval($enmse_highest->sort_id);
						$enmse_sort_id = $enmse_makenumber+1;
					}
					
					$enmse_newtype = array(
						'name' => $enmse_name, 
						'description' => $enmse_description,
						'sort_id' => $enmse_sort_id
						); 
					$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newtype );
					$enmse_messages[] = "You have successfully added a new series type to Series Engine!";
				}
			}
		}
		
		// Get All Series Types
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
		$enmse_types = $wpdb->get_results( $enmse_preparredsql );
		
		// Get All Series Type Matches
		$enmse_preparredstmsql = "SELECT series_type_id, series_id FROM " . $wpdb->prefix . "se_series_type_matches"; 
		$enmse_stm = $wpdb->get_results( $enmse_preparredstmsql );
	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap"> 
<?php if ( isset($_GET['enmse_action']) && ( $enmse_type_created == null && !isset($_GET['enmse_did']) ) ) { if ( $_GET['enmse_action'] == 'new' ) { // If they're adding a new Series Type ?>
		<div></div>
		<h2 class="enmse">Add a New <?php echo $enmseseriest; ?> Type</h2>
		<?php include ('errorbox.php'); ?>
		<p>Use the form below to enter a new <?php echo $enmseseriest; ?> Type into the Series Engine. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-seriestypes"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmseseriest; ?> Types...</a></p>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Name:</th>
					<td><input id='seriestype_name' name='seriestype_name' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['seriestype_name']));} ?>" tabindex="1" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Description:</th>
					<td>
						<textarea name="seriestype_description" id="seriestype_description" rows="8" cols="40" tabindex="2"><?php if ($_POST && !empty($enmse_errors)) {echo htmlspecialchars(stripslashes($_POST['seriestype_description']));} ?></textarea><br />
					</td>
				</tr>
			</table>
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add New <?php echo $enmseseriest; ?> Type" tabindex="3" /></p>
		</form>
		<p><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes', __FILE__ ) ?>">&laquo; All Series Types</a></p>
		<?php include ('secredits.php'); ?>
<?php } elseif ( ($_GET['enmse_action'] == 'edit') && ( $enmse_typecount == 1 ) ) { ?>
	<div></div>
	<h2 class="enmse">Edit <?php echo $enmseseriest; ?> Type <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Use the form below to update the <?php echo $enmseseriest; ?> Type within the Series Engine. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-seriestypes"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmseseriest; ?> Types...</a></p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Name:</th>
				<td><input id='seriestype_name' name='seriestype_name' type='text' value="<?php if ($_POST && !empty($enmse_errors)) {echo $_POST['seriestype_name'];} else {echo htmlspecialchars(stripslashes($enmse_st->name));} ?>" tabindex="1" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Description:</th>
				<td>
					<textarea name="seriestype_description" id="seriestype_description" rows="8" cols="40" tabindex="2"><?php if ($_POST && !empty($enmse_errors)) {echo $_POST['seriestype_description'];} else {echo htmlspecialchars(stripslashes($enmse_st->description));} ?></textarea><br />
				</td>
			</tr>
		</table>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Save Changes" tabindex="3" /></p>
	</form>
	<p><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes', __FILE__ ) ?>">&laquo; All Series Types</a></p>
	<?php include ('secredits.php'); ?>
<?php }} else { // Display the main listing of series types ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/deleteseriestype.js'; ?>"></script>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		var fixHelper = function(e, ui) {
		    ui.children().each(function() {
		        jQuery(this).width(jQuery(this).width());
		    });
		    return ui;
		};
		jQuery("#enmse-series-types tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
			var order = jQuery(this).sortable("serialize"); 
			jQuery.ajax({
				method: "POST",
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxsortseriestypes',
		            'row': order
		        },
		        success:function(data) {
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		}});
	});
	</script>
	
	<h2 class="enmse">Set <?php echo $enmseseriest; ?> Types <a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes&enmse_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>
	<p>All <?php echo $enmseseriest; ?> Types are listed in the table below. Click and drag a row to change the listed order of your <?php echo $enmseseriest; ?> Types. Click on the title of the <?php echo $enmseseriest; ?> Type to edit it. Click on the number of <?php echo $enmseseriest; ?> to view a list of <?php echo $enmseseriest; ?> associated with the <?php echo $enmseseriest; ?> Type. You can permanently delete the <?php echo $enmseseriest; ?> Type from the Series Engine by clicking the "Delete" link. <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-seriestypes"; ?>" class="enmse-learn-more">Learn more about <?php echo $enmseseriest; ?> Types...</a></p>

	<table class="widefat" id="enmse-series-types"> 
		<thead> 
			<tr> 
				<th>Sort</th>
				<th><?php echo $enmseseriest; ?> Type</th> 
				<th>Description</th> 
				<th>Num. <?php echo $enmseseriest; ?></th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmse_types as $enmse_type ) { ?>
			<tr id="row_<?php echo $enmse_type->series_type_id ?>">
				<td class="enmse-sort"></td>
				<td><a href="<?php echo admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes&amp;enmse_action=edit&amp;enmse_stid=' . $enmse_type->series_type_id, __FILE__ ) ?>"><?php echo stripslashes($enmse_type->name); ?></a></td>
				<td><?php echo $enmse_type->description ?></td>
				<td><?php $enmse_stm_count = 0; foreach ( $enmse_stm as $stm ) { ?><?php if ( $stm->series_type_id == $enmse_type->series_type_id ) { $enmse_stm_count = $enmse_stm_count+1; } ?><?php } ?><?php if ( $enmse_stm_count >= 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series&amp;enmse_stid=' . $enmse_type->series_type_id, __FILE__ ) . "\">" . $enmse_stm_count . " Series</a>";} ?></td>				
				<td class="enmse-delete"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmse_did=1" method="post" id="seriesengine-deleteform<?php echo $enmse_type->series_type_id ?>"><input type="hidden" name="seriestype_delete" value="<?php echo $enmse_type->series_type_id ?>"></form><a href="#" class="seriesengine_delete" name="<?php echo $enmse_type->series_type_id ?>">Delete</a></td>
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
