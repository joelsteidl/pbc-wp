<?php /* ----- Groups Engine - Add, edit and remove Groups ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		
		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		$enmge_locationtitle = $enmge_options['locationtitle'];
		$enmge_locationptitle = $enmge_options['locationptitle'];
		$enmge_groupptitle = $enmge_options['groupptitle'];
		if ( isset($enmge_options['serverapikey']) ) {
			$enmge_serverapikey = stripslashes($enmge_options['serverapikey']);
		} else {
			$enmge_serverapikey = null;
		}
		
		$enmge_errors = array(); //Set up errors array
		$enmge_messages = array(); //Set up messages array
		
		if ( $_POST && isset($_GET['enmge_did']) ) { // If deleting a location
			$enmge_deleted_id = strip_tags($_POST['location_delete']);
			$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id=%d";
			$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_deleted_id ); 
			$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
			
			$enmge_stdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE location_id=%d";
			$enmge_stdelete_query = $wpdb->prepare( $enmge_stdelete_query_preparred, $enmge_deleted_id ); 
			$enmge_stdeleted = $wpdb->query( $enmge_stdelete_query );
			
			$enmge_messages[] = "The " . stripslashes($enmge_locationtitle) . " was successfully deleted.";
		}
		
		if ( isset($_GET['enmge_action']) ) {
			$enmge_single_created = null;

			if ( $_GET['enmge_action'] == 'edit' ) { // Edit Location
				$enmge_userdetails = wp_get_current_user(); 

				if ( $_POST ) {

					if (empty($_POST['location_name'])) { 
						$enmge_errors[] = '- You must name the ' . stripslashes($enmge_locationtitle) . '.';
					} else {
						$enmge_name = strip_tags($_POST['location_name']);
					}

					$enmge_location_address1 = strip_tags($_POST['location_address1']);
					$enmge_location_address2 = strip_tags($_POST['location_address2']);
					$enmge_location_city = strip_tags($_POST['location_city']);
					$enmge_location_state = strip_tags($_POST['location_state']);
					$enmge_location_zip = strip_tags($_POST['location_zip']);

					// Find Lat and Long
					if ( $_POST['location_manedit'] == 0 ) {
						if ( ($_POST['location_address1'] != $_POST['enmge_oldaddress1']) || ($_POST['location_address2'] != $_POST['enmge_oldaddress2']) || ($_POST['location_city'] != $_POST['enmge_oldcity']) || ($_POST['location_state'] != $_POST['enmge_oldstate']) || ($_POST['location_zip'] != $_POST['enmge_oldzip']) ) {
							$enmge_l_address1 = str_replace(' ', '+', trim($enmge_location_address1)).",";
							$enmge_l_address2 = str_replace(' ', '+', trim($enmge_location_address2)).",";
		    				$enmge_l_city    = '+'.str_replace(' ', '+', trim($enmge_location_city)).",";
						    $enmge_l_state   = '+'.str_replace(' ', '+', trim($enmge_location_state));
						    $enmge_l_zip     = isset($enmge_location_zip)? '+'.str_replace(' ', '', trim($enmge_location_zip)) : '';

							$enmge_l_addr_str = $enmge_l_address1.$enmge_l_address2.$enmge_l_city.$enmge_l_state.$enmge_l_zip;
							if ( $enmge_serverapikey != null ) {
								$enmge_l_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$enmge_l_addr_str&sensor=false&key=" . $enmge_serverapikey;
							} else {
								$enmge_l_url = "http://maps.googleapis.com/maps/api/geocode/json?address=$enmge_l_addr_str&sensor=false";
							}         
							

							$enmgech = curl_init();
							curl_setopt($enmgech, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($enmgech, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($enmgech, CURLOPT_URL,$enmge_l_url);
							$enmge_l_jsonData=curl_exec($enmgech);
							curl_close($enmgech);

							$enmge_l_data = json_decode($enmge_l_jsonData);


							if ( empty($enmge_l_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ) {
								$enmge_errors[] = '- Please double-check your location information. (If you\'re seeing this error repeatedly, you probably need to provide a Geocoding API key for address lookups in Settings > Groups Engine. Refer to the troubleshooting section of the User Guide.)';
							} else {
								$enmge_location_lat = $enmge_l_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
							}

							if ( empty($enmge_l_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ) {
							} else {
								$enmge_location_long = $enmge_l_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
							}
							
						} else {
							$enmge_location_lat = strip_tags($_POST['enmge_oldlat']);
							$enmge_location_long = strip_tags($_POST['enmge_oldlong']);
						}
					} else {
						$enmge_location_lat = strip_tags($_POST['location_lat']);
						$enmge_location_long = strip_tags($_POST['location_long']);
					}

					$enmge_location_manedit = strip_tags($_POST['location_manedit']);
					
					
					if (empty($enmge_errors)) {
						if ( isset($_GET['enmge_lid']) && is_numeric($_GET['enmge_lid']) ) {
							$enmge_lid = strip_tags($_GET['enmge_lid']);
						}
						
						$enmge_new_values = array( 'location_name' => $enmge_name, 'location_address1' => $enmge_location_address1, 'location_address2' => $enmge_location_address2, 'location_city' => $enmge_location_city, 'location_state' => $enmge_location_state, 'location_zip' => $enmge_location_zip, 'location_lat' => $enmge_location_lat, 'location_long' => $enmge_location_long, 'location_manedit' => $enmge_location_manedit  ); 
						$enmge_where = array( 'location_id' => $enmge_lid ); 
						$wpdb->update( $wpdb->prefix . "ge_locations", $enmge_new_values, $enmge_where ); 
						$enmge_messages[] = stripslashes($enmge_locationtitle) . " successfully updated!";

						if ( ($enmge_location_lat != $_POST['enmge_oldlat']) || ($enmge_location_long != $_POST['enmge_oldlong']) || ($enmge_name != $_POST['enmge_oldname']) ) {
							$enmge_preparredusql = "SELECT group_id FROM " . $wpdb->prefix . "ge_groups WHERE group_onsite = " . $enmge_lid  .  " ORDER BY group_id ASC"; 
							$enmge_groups = $wpdb->get_results( $enmge_preparredusql );
							foreach ( $enmge_groups as $enmge_group ) { 
								$enmge_group_values = array( 'group_campus_name' => $enmge_name, 'group_lat' => $enmge_location_lat, 'group_long' => $enmge_location_long  ); 
								$enmge_group_where = array( 'group_id' => $enmge_group->group_id ); 
								$wpdb->update( $wpdb->prefix . "ge_groups", $enmge_group_values, $enmge_group_where );
							}
						}


						$enmge_findthelocationsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d"; 
						$enmge_findthelocation = $wpdb->prepare( $enmge_findthelocationsql, $enmge_lid );
						$enmge_single = $wpdb->get_row( $enmge_findthelocation, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;


					} else {
						if ( isset($_GET['enmge_lid']) && is_numeric($_GET['enmge_lid']) ) {
							$enmge_lid = strip_tags($_GET['enmge_lid']);
						}
						
						$enmge_findthelocationsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d"; 
						$enmge_findthelocation = $wpdb->prepare( $enmge_findthelocationsql, $enmge_lid );
						$enmge_single = $wpdb->get_row( $enmge_findthelocation, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;

					}

					
				} else {
					if ( isset($_GET['enmge_lid']) && is_numeric($_GET['enmge_lid']) ) {
						$enmge_lid = strip_tags($_GET['enmge_lid']);
					}

					$enmge_findthelocationsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d"; 
					$enmge_findthelocation = $wpdb->prepare( $enmge_findthelocationsql, $enmge_lid );
					$enmge_single = $wpdb->get_row( $enmge_findthelocation, OBJECT );
					$enmge_singlecount = $wpdb->num_rows;
					
				}	
			}
			
			if ( $_GET['enmge_action'] == 'new' && !isset($_GET['enmge_did']) ) { // New Location
				
				$enmge_userdetails = wp_get_current_user(); 
				
				if ( $_POST ) {
					
					if (empty($_POST['location_name'])) { 
						$enmge_errors[] = '- You must name the ' . stripslashes($enmge_locationtitle) . '.';
					} else {
						$enmge_name = strip_tags($_POST['location_name']);
					}

					$enmge_location_address1 = strip_tags($_POST['location_address1']);
					$enmge_location_address2 = strip_tags($_POST['location_address2']);

					if (empty($_POST['location_city'])) { 
						$enmge_errors[] = '- You must at least provide a city for your ' . stripslashes($enmge_locationtitle) . '.';
					} else {
						$enmge_location_city = strip_tags($_POST['location_city']);
					}

					if (empty($_POST['location_state'])) { 
						$enmge_errors[] = '- You must at least provide a state/province for your ' . stripslashes($enmge_locationtitle) . '.';
					} else {
						$enmge_location_state = strip_tags($_POST['location_state']);
					}

					$enmge_location_zip = strip_tags($_POST['location_zip']);

					$enmge_location_manedit = strip_tags($_POST['location_manedit']);

					if (empty($enmge_errors)) {
						if ( $_POST['location_manedit'] == 0 ) {
							$enmge_l_address1 = str_replace(' ', '+', trim($enmge_location_address1)).",";
							$enmge_l_address2 = str_replace(' ', '+', trim($enmge_location_address2)).",";
		    				$enmge_l_city    = '+'.str_replace(' ', '+', trim($enmge_location_city)).",";
						    $enmge_l_state   = '+'.str_replace(' ', '+', trim($enmge_location_state));
						    $enmge_l_zip     = isset($enmge_location_zip)? '+'.str_replace(' ', '', trim($enmge_location_zip)) : '';

							$enmge_l_addr_str = $enmge_l_address1.$enmge_l_address2.$enmge_l_city.$enmge_l_state.$enmge_l_zip;       
							if ( $enmge_serverapikey != null ) {
								$enmge_l_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$enmge_l_addr_str&sensor=false&key=" . $enmge_serverapikey;
							} else {
								$enmge_l_url = "http://maps.googleapis.com/maps/api/geocode/json?address=$enmge_l_addr_str&sensor=false";
							}  

							$enmgech = curl_init();
							curl_setopt($enmgech, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($enmgech, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($enmgech, CURLOPT_URL,$enmge_l_url);
							$enmge_l_jsonData=curl_exec($enmgech);
							curl_close($enmgech);

							$enmge_l_data = json_decode($enmge_l_jsonData);


							if ( empty($enmge_l_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ) {
								$enmge_errors[] = '- Please double-check your location information. (If you\'re seeing this error repeatedly, you probably need to provide a Geocoding API key for address lookups in Settings > Groups Engine. Refer to the troubleshooting section of the User Guide.)';
							} else {
								$enmge_location_lat = $enmge_l_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
							}

							if ( empty($enmge_l_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ) {
							} else {
								$enmge_location_long = $enmge_l_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
							}
						} else {
							$enmge_location_lat = strip_tags($_POST['location_lat']);
							$enmge_location_long = strip_tags($_POST['location_long']);
						}
					}


					
					
					if (empty($enmge_errors)) {

						$enmge_single_created = "yes";

						$enmge_newlocation = array(
							'location_name' => $enmge_name, 
							'location_address1' => $enmge_location_address1,
							'location_address2' => $enmge_location_address2,
							'location_city' => $enmge_location_city,
							'location_state' => $enmge_location_state,
							'location_zip' => $enmge_location_zip,
							'location_lat' => $enmge_location_lat,
							'location_long' => $enmge_location_long,
							'location_manedit' => $enmge_location_manedit
							); 
						$wpdb->insert( $wpdb->prefix . "ge_locations", $enmge_newlocation );
						$enmge_new_location_id = $wpdb->insert_id; 
						
						$enmge_messages[] = "You have successfully added a new " . stripslashes($enmge_locationtitle) . " to Groups Engine!";
					} else {
						
					}
				}

			}
		}
		
		// Get All Locations
		$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " ORDER BY location_id ASC"; 
		$enmge_locations = $wpdb->get_results( $enmge_preparredsql );

		// Get All Group Location Matches
		$enmge_preparredglmsql = "SELECT group_id, location_id FROM " . $wpdb->prefix . "ge_group_location_matches"; 
		$enmge_glm = $wpdb->get_results( $enmge_preparredglmsql );
		

	} else {
		exit("Access Denied");
	}
	
?>

<div class="wrap"> 
<?php if ( isset($_GET['enmge_action']) && ( $enmge_single_created == null && !isset($_GET['enmge_did']) ) ) { if ( $_GET['enmge_action'] == 'new' ) { // If they're adding a new Location ?>
		<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
		<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/datepicker.js'; ?>" ></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#location_manedit").on("change", function() {
					var manedit = jQuery(this).val();
					if (manedit == 0) {
						jQuery("#latrow").hide();
						jQuery("#longrow").hide();
					} else {
						jQuery("#latrow").show();
						jQuery("#longrow").show();
					};
				});
			});
		</script>

		<h2 class="enmge">Add a New <?php echo stripslashes($enmge_locationtitle); ?></h2>
		<?php include ('errorbox.php'); ?>
		<p>Complete the form below to add a new <?php echo stripslashes($enmge_locationtitle); ?> to Groups Engine. Be sure to enter an accurate address for the best results. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-locations"; ?>">User Guide</a>.</p>
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Title:</strong></th>
					<td><input id='location_name' name='location_name' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_name']);} ?>" tabindex="1" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Address:<p class="ge-form-instructions">Consider street names without numbers, or even just city or postal code if you prefer more privacy.</p></th>
					<td><input id='location_address1' name='location_address1' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_address1']);} ?>" tabindex="2" /><br /><input id='location_address2' name='location_address2' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_address2']);} ?>" tabindex="3" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">City:</th>
					<td><input id='location_city' name='location_city' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_city']);} ?>" tabindex="4" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">State/Province:</th>
					<td><input id='location_state' name='location_state' type='text' size="3" value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_state']);} ?>" tabindex="5" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Postal Code:</th>
					<td><input id='location_zip' name='location_zip' type='text' size="5" value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_zip']);} ?>" tabindex="6" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Manually Edit Lat/Long?: <p class="ge-form-instructions">Overwrite the coordinates generated by the address above.</p></th>
					<td>
						<select name="location_manedit" id="location_manedit" tabindex="6">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['location_manedit'] == 0) { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['location_manedit'] == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['location_manedit'] == 0) { ?>style="display: none"<?php }} else { ?>style="display: none"<?php } ?> id="latrow">
					<th scope="row">Latitude:</th>
					<td><input id='location_lat' name='location_lat' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_lat']);} ?>" tabindex="7" /></td>
				</tr>
				<tr valign="top" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['location_manedit'] == 0) { ?>style="display: none"<?php }} else { ?>style="display: none"<?php } ?> id="longrow">
					<th scope="row">Longitude:</th>
					<td><input id='location_long' name='location_long' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_long']);} ?>" tabindex="8" /></td>
				</tr>
			</table>
		</div>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add <?php echo stripslashes($enmge_locationtitle); ?>" tabindex="7" /></p>
	</form>	

		<p><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_locations', __FILE__ ) ?>">&laquo; All Locations</a></p>
		<?php include ('gecredits.php'); ?>
<?php } elseif ( ($_GET['enmge_action'] == 'edit') && ( $enmge_singlecount == 1 ) ) { // Edit Location ?>
	<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/datepicker.js'; ?>" ></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#location_manedit").on("change", function() {
				var manedit = jQuery(this).val();
				if (manedit == 0) {
					jQuery("#latrow").hide();
					jQuery("#longrow").hide();
				} else {
					jQuery("#latrow").show();
					jQuery("#longrow").show();
				};
			});
		});
	</script>
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/group_options127.js'; ?>"></script>
	<h2 class="enmge">Edit <?php echo stripslashes($enmge_locationtitle); ?> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_locations&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Modify the information below to adjust this <?php echo stripslashes($enmge_locationtitle); ?> in Groups Engine. Be sure to enter an accurate address for the best results. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-locations"; ?>">User Guide</a>.</p>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Title:</strong></th>
					<td><input id='location_name' name='location_name' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_name']);} else {echo stripslashes($enmge_single->location_name);} ?>" tabindex="1" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Address:<p class="ge-form-instructions">Consider street names without numbers, or even just city or postal code if you prefer more privacy.</p></th>
					<td><input id='location_address1' name='location_address1' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_address1']);} else {echo stripslashes($enmge_single->location_address1);} ?>" tabindex="2" /><br /><input id='location_address2' name='location_address2' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_address2']);} else {echo stripslashes($enmge_single->location_address2);} ?>" tabindex="3" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">City:</th>
					<td><input id='location_city' name='location_city' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_city']);} else {echo stripslashes($enmge_single->location_city);} ?>" tabindex="4" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">State/Province:</th>
					<td><input id='location_state' name='location_state' type='text' size="3" value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_state']);} else {echo stripslashes($enmge_single->location_state);} ?>" tabindex="5" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Postal Code:</th>
					<td><input id='location_zip' name='location_zip' type='text' size="5" value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_zip']);} else {if ($enmge_single->location_zip != 0) {echo stripslashes($enmge_single->location_zip);}} ?>" tabindex="6" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Manually Edit Lat/Long?: <p class="ge-form-instructions">Overwrite the coordinates generated by the address above.</p></th>
					<td>
						<select name="location_manedit" id="location_manedit" tabindex="6">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['location_manedit'] == 0) { ?>selected="selected"<?php }} else {if ($enmge_single->location_manedit == 0) { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['location_manedit'] == 1) { ?>selected="selected"<?php }} else {if ($enmge_single->location_manedit == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['location_manedit'] == 0) { ?>style="display: none"<?php }} else {if ($enmge_single->location_manedit == 0) { ?>style="display: none"<?php }} ?> id="latrow">
					<th scope="row">Latitude:</th>
					<td><input id='location_lat' name='location_lat' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_lat']);} else {echo stripslashes($enmge_single->location_lat);} ?>" tabindex="7" /></td>
				</tr>
				<tr valign="top" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['location_manedit'] == 0) { ?>style="display: none"<?php }} else {if ($enmge_single->location_manedit == 0) { ?>style="display: none"<?php }} ?> id="longrow">
					<th scope="row">Longitude:</th>
					<td><input id='location_long' name='location_long' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['location_long']);} else {echo stripslashes($enmge_single->location_long);} ?>" tabindex="8" /></td>
				</tr>
			</table>
		</div>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Update <?php echo stripslashes($enmge_locationtitle); ?>" tabindex="7" /></p>
		<input type="hidden" name="enmgelid" value="<?php echo $enmge_single->location_id; ?>" id="enmgelid" />
		<input type="hidden" name="enmge_oldname" value="<?php echo $enmge_single->location_name; ?>" id="enmge_oldname" />
		<input type="hidden" name="enmge_oldaddress1" value="<?php echo $enmge_single->location_address1; ?>" id="enmge_oldaddress1" />
		<input type="hidden" name="enmge_oldaddress2" value="<?php echo $enmge_single->location_address2; ?>" id="enmge_oldaddress2" />
		<input type="hidden" name="enmge_oldcity" value="<?php echo $enmge_single->location_city; ?>" id="enmge_oldcity" />
		<input type="hidden" name="enmge_oldstate" value="<?php echo $enmge_single->location_state; ?>" id="enmge_oldstate" />
		<input type="hidden" name="enmge_oldzip" value="<?php echo $enmge_single->location_zip; ?>" id="enmge_oldzip" />
		<input type="hidden" name="enmge_oldlat" value="<?php echo $enmge_single->location_lat; ?>" id="enmge_oldlat" />
		<input type="hidden" name="enmge_oldlong" value="<?php echo $enmge_single->location_long; ?>" id="enmge_oldlong" />
	</form>
	

	<p><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_locations', __FILE__ ) ?>">&laquo; All Locations</a></p>
	<?php include ('gecredits.php'); ?>
<?php }} else { // Display the main listing of Locations ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/deletelocations.js'; ?>"></script>

	<h2 class="enmge">Create and Edit <?php echo stripslashes($enmge_locationptitle); ?> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_locations&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>

	<p>Click a <?php echo stripslashes($enmge_locationtitle); ?> name below to edit the <?php echo stripslashes($enmge_locationtitle); ?>. Click the number of <?php echo stripslashes($enmge_groupptitle); ?> to view a list of <?php echo stripslashes($enmge_groupptitle); ?> currently associated with the <?php echo stripslashes($enmge_locationtitle); ?>. Click "Add New" above to add a new <?php echo stripslashes($enmge_locationtitle); ?> to Groups Engine. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-locations"; ?>">User Guide</a>.</p>
	
	<?php // include ('grouppagination.php'); ?>
	<table class="widefat"> 
		<thead> 
			<tr> 
				<th>Name</th> 
				<th>Num. <?php echo stripslashes($enmge_groupptitle); ?></th> 
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmge_locations as $enmge_single ) { ?>
			<tr>
				<td><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_locations&amp;enmge_action=edit&amp;enmge_lid=' . $enmge_single->location_id, __FILE__ ); ?>"><?php echo stripslashes($enmge_single->location_name) ?></a></td>
				<td><?php $enmge_glm_count = 0; foreach ( $enmge_glm as $glm ) { ?><?php if ( $glm->location_id == $enmge_single->location_id ) { $enmge_glm_count = $enmge_glm_count+1; } ?><?php } ?><?php if ( $enmge_glm_count > 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_lid=' . $enmge_single->location_id, __FILE__ ) . "\">" . $enmge_glm_count . " Groups</a>";} elseif ( $enmge_glm_count == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_lid=' . $enmge_single->location_id, __FILE__ ) . "\">1 Group</a>"; } ?></td>				
				<td class="enmge-delete"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmge_did=1" method="post" id="groupsengine-deleteform<?php echo $enmge_single->location_id ?>"><input type="hidden" name="location_delete" value="<?php echo $enmge_single->location_id ?>"></form><a href="#" class="groupsengine_delete" name="<?php echo $enmge_single->location_id ?>">Delete</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php include ('gecredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
