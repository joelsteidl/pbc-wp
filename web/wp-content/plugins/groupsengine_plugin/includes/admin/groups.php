<?php /* ----- Groups Engine - Add, edit and remove Groups ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		
		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		$enmge_grouptitle = $enmge_options['grouptitle'];
		$enmge_groupptitle = $enmge_options['groupptitle']; 
		$enmge_grouptypetitle = $enmge_options['grouptypetitle'];
		$enmge_grouptypeptitle = $enmge_options['grouptypeptitle'];
		$enmge_locationtitle = $enmge_options['locationtitle'];
		$enmge_locationptitle = $enmge_options['locationptitle'];
		$enmge_topictitle = $enmge_options['topictitle'];
		$enmge_topicptitle = $enmge_options['topicptitle'];
		$enmge_imagewidth = $enmge_options['imagewidth'];
		if ( isset($enmge_options['childcare']) ) {
			$enmge_childcarelabel = stripslashes($enmge_options['childcare']);
		} else {
			$enmge_childcarelabel = "Childcare Available?";
		}
		if ( isset($enmge_options['serverapikey']) ) {
			$enmge_serverapikey = stripslashes($enmge_options['serverapikey']);
		} else {
			$enmge_serverapikey = null;
		}
		
		$enmge_errors = array(); //Set up errors array
		$enmge_messages = array(); //Set up messages array
		
		if ( $_POST && isset($_GET['enmge_did']) ) { // If deleting a group
			$enmge_deleted_id = strip_tags($_POST['group_delete']);
			$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_id=%d";
			$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_deleted_id ); 
			$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
			
			$enmge_ggtdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_group_type_matches" . " WHERE group_id=%d";
			$enmge_ggtdelete_query = $wpdb->prepare( $enmge_ggtdelete_query_preparred, $enmge_deleted_id ); 
			$enmge_ggtdeleted = $wpdb->query( $enmge_ggtdelete_query );
			
			$enmge_gtdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_topic_matches" . " WHERE group_id=%d";
			$enmge_gtdelete_query = $wpdb->prepare( $enmge_gtdelete_query_preparred, $enmge_deleted_id ); 
			$enmge_gtdeleted = $wpdb->query( $enmge_gtdelete_query );
			
			$enmge_gldelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE group_id=%d";
			$enmge_gldelete_query = $wpdb->prepare( $enmge_gldelete_query_preparred, $enmge_deleted_id ); 
			$enmge_gldeleted = $wpdb->query( $enmge_gldelete_query );
			
			$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_id ORDER BY file_name ASC"; 
			$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_deleted_id );
			$enmge_dfiles = $wpdb->get_results( $enmge_fsql );
			
			foreach ($enmge_dfiles as $enmge_f) {
				$enmge_nfid = $enmge_f->file_id;
				$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_files" . "  WHERE file_id = %d";
				$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_nfid ); 
				$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
				
				$matchid = $enmge_f->gf_match_id;
				$enmge_deletetwo_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_file_matches" . "  WHERE gf_match_id=%d";
				$enmge_deletetwo_query = $wpdb->prepare( $enmge_deletetwo_query_preparred, $matchid ); 
				$enmge_deletedtwo = $wpdb->query( $enmge_deletetwo_query );
			}

			$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id ORDER BY leader_name ASC"; 
			$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_deleted_id );
			$enmge_dleaders = $wpdb->get_results( $enmge_lesql );
			
			foreach ($enmge_dleaders as $enmge_l) {
				$enmge_nlid = $enmge_l->leader_id;
				$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_leaders" . "  WHERE leader_id = %d";
				$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_nlid ); 
				$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
				
				$matchid = $enmge_l->gle_match_id;
				$enmge_deletetwo_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_leader_matches" . "  WHERE gle_match_id=%d";
				$enmge_deletetwo_query = $wpdb->prepare( $enmge_deletetwo_query_preparred, $matchid ); 
				$enmge_deletedtwo = $wpdb->query( $enmge_deletetwo_query );
			}
			
			$enmge_messages[] = "The " . stripslashes($enmge_grouptitle) . " was successfully deleted.";
		}
		
		if ( isset($_GET['enmge_action']) ) {
			$enmge_single_created = null;

			if ( $_GET['enmge_action'] == 'edit' ) { // Edit Group
				$enmge_userdetails = wp_get_current_user(); 

				if ( $_POST ) {

					// Get All Locations
					$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " ORDER BY location_id DESC"; 	
					$enmge_locations = $wpdb->get_results( $enmge_lpreparredsql );

					if (empty($_POST['group_title'])) { 
						$enmge_errors[] = '- You must name the ' . stripslashes($enmge_grouptitle) . '.';
					} else {
						$enmge_title = strip_tags($_POST['group_title']);
					}

					$enmge_description = $_POST['group_description'];

					$enmge_day = strip_tags($_POST['group_day']);
					$enmge_frequency = strip_tags($_POST['group_frequency']);

					$enmge_startage = strip_tags($_POST['group_startage']);
					$enmge_endage = strip_tags($_POST['group_endage']);

					$enmge_childcare = strip_tags($_POST['group_childcare']);
					$enmge_childcare_details = strip_tags($_POST['group_childcare_details']);

					$enmge_privacy = strip_tags($_POST['group_privacy']);
					$enmge_location_privacy = strip_tags($_POST['group_location_privacy']);
					$enmge_status = strip_tags($_POST['group_status']);

					if ( $enmge_startage > $enmge_endage ) {
						$enmge_errors[] = '- Please choose a valid age range.';
					}

					if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['group_begins'])) { 
						$enmge_group_begins = strip_tags($_POST['group_begins']);
					} else {
						$enmge_group_begins = '0000-00-00';
						$enmge_errors[] = '- You must provide a valid start date for the ' . stripslashes($enmge_grouptitle) . '.';
					};

					if ( isset($_POST['group_noend']) ) {
						$enmge_noend = 1;
					} else {
						$enmge_noend = 0;
					}

					if ( $enmge_noend == 1 ) {
						$enmge_group_ends = (date("Y", time())+1) . date("-m-d", time());
					} else {
						if ( $_POST['group_ends'] != NULL ) {
						if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['group_ends'])) { 
								$enmge_group_ends = strip_tags($_POST['group_ends']);
							} else {
								$enmge_errors[] = '- You must provide a valid end date for your ' . stripslashes($enmge_grouptitle) . '.';
							};
						} else {
							$enmge_group_ends = '0000-00-00';
						}
					}

					if ( ($enmge_noend != 1) && ($enmge_group_begins > $enmge_group_ends) ) {
						$enmge_errors[] = '- Please choose a valid start and end date.';
					}

					if ( $_POST['group_starttime1'] == "n" ) {
						$enmge_errors[] = '- Please select a valid start time for this ' . stripslashes($enmge_grouptitle) . '.';
					} else {
						$enmge_group_starttime = $_POST['group_starttime1'].":".$_POST['group_starttime2'].":00";
					}

					if ( $_POST['group_endtime1'] == "n" ) {
						$enmge_errors[] = '- Please select a valid end time for this ' . stripslashes($enmge_grouptitle) . '.';
					} else {
						$enmge_group_endtime = $_POST['group_endtime1'].":".$_POST['group_endtime2'].":00";
					}

					if ( $enmge_group_endtime < $enmge_group_starttime ) {
						$enmge_errors[] = '- Please choose a valid start and end time.';
					}

					$enmge_group_location_label = strip_tags($_POST['group_location_label']);

					$enmge_group_onsite = strip_tags($_POST['group_onsite']);

					$enmge_photo = strip_tags($_POST['group_photo']);

					if ( $enmge_group_onsite > 0 ) {
						$enmge_findthelocationsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d"; 
						$enmge_findthelocation = $wpdb->prepare( $enmge_findthelocationsql, $enmge_group_onsite);
						$enmge_location = $wpdb->get_row( $enmge_findthelocation, OBJECT );

						$enmge_group_address1 = null;
						$enmge_group_address2 = null;
						$enmge_group_city = null;
						$enmge_group_state = null;
						$enmge_group_zip = $enmge_location->location_zip;
						$enmge_group_lat = $enmge_location->location_lat;
						$enmge_group_long = $enmge_location->location_long;
						$enmge_group_campus_name = $enmge_location->location_name;
					} else {
						$enmge_group_address1 = strip_tags($_POST['group_address1']);
						$enmge_group_address2 = strip_tags($_POST['group_address2']);
						if (empty($_POST['group_city'])) { 
							$enmge_errors[] = '- You must at least provide a city for your ' . stripslashes($enmge_grouptitle) . '.';
						} else {
							$enmge_group_city = strip_tags($_POST['group_city']);
						}
						if (empty($_POST['group_state'])) { 
							$enmge_errors[] = '- You must at least provide a state/province for your ' . stripslashes($enmge_grouptitle) . '.';
						} else {
							$enmge_group_state = strip_tags($_POST['group_state']);
						}
						
						$enmge_group_zip = strip_tags($_POST['group_zip']);
						$enmge_group_campus_name = null;

						// Find Lat and Long
						if (empty($enmge_errors)) {
							if ( $_POST['group_manedit'] == 0 ) {
								if ( ($_POST['group_address1'] != $_POST['enmge_oldaddress1']) || ($_POST['group_address2'] != $_POST['enmge_oldaddress2']) || ($_POST['group_city'] != $_POST['enmge_oldcity']) || ($_POST['group_state'] != $_POST['enmge_oldstate']) || ($_POST['group_zip'] != $_POST['enmge_oldzip']) ) {
									$enmge_g_address1 = str_replace(' ', '+', trim($enmge_group_address1)).",";
									$enmge_g_address2 = str_replace(' ', '+', trim($enmge_group_address2)).",";
				    				$enmge_g_city    = '+'.str_replace(' ', '+', trim($enmge_group_city)).",";
								    $enmge_g_state   = '+'.str_replace(' ', '+', trim($enmge_group_state));
								    $enmge_g_zip     = isset($enmge_group_zip)? '+'.str_replace(' ', '', trim($enmge_group_zip)) : '';

									$enmge_g_addr_str = $enmge_g_address1.$enmge_g_address2.$enmge_g_city.$enmge_g_state.$enmge_g_zip; 
									if ( $enmge_serverapikey != null ) {
									    $enmge_g_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false&key=" . $enmge_serverapikey;
									} else {
									    $enmge_g_url = "http://maps.googleapis.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false";
									}     
									

									$enmgech = curl_init();
									curl_setopt($enmgech, CURLOPT_SSL_VERIFYPEER, false);
									curl_setopt($enmgech, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($enmgech, CURLOPT_URL,$enmge_g_url);
									$enmge_g_jsonData=curl_exec($enmgech);
									curl_close($enmgech);

									$enmge_g_data = json_decode($enmge_g_jsonData);

									if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ) {
										$enmge_errors[] = '- Please double-check your location information. (If you\'re seeing this error repeatedly, you probably need to provide a Geocoding API key for address lookups in Settings > Groups Engine. Refer to the troubleshooting section of the User Guide.)';
									} else {
										$enmge_group_lat = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
									}

									if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ) {
									} else {
										$enmge_group_long = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
									}

								} else {
									$enmge_group_lat = strip_tags($_POST['enmge_oldlat']);
									$enmge_group_long = strip_tags($_POST['enmge_oldlong']);
								}
							} else {
								$enmge_group_lat = strip_tags($_POST['group_lat']);
								$enmge_group_long = strip_tags($_POST['group_long']);
							}
						}
					}

					$enmge_manedit = strip_tags($_POST['group_manedit']);

					if ( !empty($_POST['topics']) ) {
						$enmge_topics = $_POST['topics'];
					} else {
						$enmge_topics = NULL;
					}

					if ( !empty($_POST['grouptypes']) ) {
						$enmge_group_types = $_POST['grouptypes'];
					} else {
						$enmge_group_types = NULL;
					}

					if ( !empty($_POST['locations']) ) {
						$enmge_locations = $_POST['locations'];
					} else {
						$enmge_locations = NULL;
					}

					// Check for Group Leaders
					$enmge_preparredlecsql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
					$enmge_lecsql = $wpdb->prepare( $enmge_preparredlecsql, strip_tags($_GET['enmge_gid']) );
					$enmge_leadercheck = $wpdb->get_results( $enmge_lecsql );

					if ( empty($enmge_leadercheck) ) {
						$enmge_errors[] = '- You must add at least one leader for this ' . stripslashes($enmge_grouptitle) . '.';
					}

					
					
					if (empty($enmge_errors)) {
						if ( isset($_GET['enmge_gid']) && is_numeric($_GET['enmge_gid']) ) {
							$enmge_gid = strip_tags($_GET['enmge_gid']);
						}
						
						$enmge_new_values = array( 'group_title' => $enmge_title, 'group_photo' => $enmge_photo, 'group_noend' => $enmge_noend, 'group_location_privacy' => $enmge_location_privacy, 'group_status' => $enmge_status, 'group_description' => $enmge_description, 'group_day' => $enmge_day, 'group_begins' => $enmge_group_begins, 'group_ends' => $enmge_group_ends, 'group_starttime' => $enmge_group_starttime, 'group_endtime' => $enmge_group_endtime, 'group_address1' => $enmge_group_address1, 'group_address2' => $enmge_group_address2, 'group_city' => $enmge_group_city, 'group_state' => $enmge_group_state, 'group_zip' => $enmge_group_zip, 'group_lat' => $enmge_group_lat, 'group_long' => $enmge_group_long, 'group_location_label' => $enmge_group_location_label, 'group_onsite' => $enmge_group_onsite, 'group_campus_name' => $enmge_group_campus_name, 'group_startage' => $enmge_startage, 'group_endage' => $enmge_endage, 'group_childcare' => $enmge_childcare, 'group_childcare_details' => $enmge_childcare_details, 'group_privacy' => $enmge_privacy, 'group_frequency' => $enmge_frequency, 'group_manedit' => $enmge_manedit ); 
						$enmge_where = array( 'group_id' => $enmge_gid ); 
						$wpdb->update( $wpdb->prefix . "ge_groups", $enmge_new_values, $enmge_where ); 
						$enmge_messages[] = stripslashes($enmge_grouptitle) . " successfully updated!";


						$enmge_findthegroupsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_id = %d"; 
						$enmge_findthegroup = $wpdb->prepare( $enmge_findthegroupsql, $enmge_gid );
						$enmge_single = $wpdb->get_row( $enmge_findthegroup, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;

						// Get All Files
						$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
						$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_gid );
						$enmge_files = $wpdb->get_results( $enmge_fsql );

						// Get All Leaders
						$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
						$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_gid );
						$enmge_leaders = $wpdb->get_results( $enmge_lesql );

						// Delete old Group Topic Matches
						$enmge_delete_query_preparredt = "DELETE FROM " . $wpdb->prefix . "ge_group_topic_matches" . " WHERE group_id=%d";
						$enmge_delete_queryt = $wpdb->prepare( $enmge_delete_query_preparredt, $enmge_gid ); 
						$enmge_deletedt = $wpdb->query( $enmge_delete_queryt );
						
						// Add group topic relations in the DB
						if ( !empty($enmge_topics) ) {
							foreach ($enmge_topics as $t) {
								$enmge_newgtm = array(
									'group_id' => $enmge_gid, 
									'topic_id' => $t
									); 
								$wpdb->insert( $wpdb->prefix . "ge_group_topic_matches", $enmge_newgtm );
							}
						}

						// Delete old Group Group Type Matches
						$enmge_delete_query_preparredgt = "DELETE FROM " . $wpdb->prefix . "ge_group_group_type_matches" . " WHERE group_id=%d";
						$enmge_delete_querygt = $wpdb->prepare( $enmge_delete_query_preparredgt, $enmge_gid ); 
						$enmge_deletedgt = $wpdb->query( $enmge_delete_querygt );
						
						// Add group group type relations in the DB
						if ( !empty($enmge_group_types) ) {
							foreach ($enmge_group_types as $gt) {
								$enmge_newggtm = array(
									'group_id' => $enmge_gid, 
									'group_type_id' => $gt
									); 
								$wpdb->insert( $wpdb->prefix . "ge_group_group_type_matches", $enmge_newggtm );
							}
						}

						// Delete old Group Location Matches
						$enmge_delete_query_preparredl = "DELETE FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE group_id=%d";
						$enmge_delete_queryl = $wpdb->prepare( $enmge_delete_query_preparredl, $enmge_gid ); 
						$enmge_deletedl = $wpdb->query( $enmge_delete_queryl );
						
						// Add group location relations in the DB
						if ( !empty($enmge_locations) ) {
							foreach ($enmge_locations as $l) {
								$enmge_newglm = array(
									'group_id' => $enmge_gid, 
									'location_id' => $l
									); 
								$wpdb->insert( $wpdb->prefix . "ge_group_location_matches", $enmge_newglm );
							}
						}

						// Get All Message Topic Matches
						$enmge_preparredggtmsql = "SELECT topic_id, group_id FROM " . $wpdb->prefix . "ge_group_topic_matches" . " WHERE group_id = %d"; 
						$enmge_ggtmsql = $wpdb->prepare( $enmge_preparredggtmsql, $enmge_single->group_id );
						$enmge_ggtm = $wpdb->get_results( $enmge_ggtmsql );

						// Get All Group Group Type Matches
						$enmge_preparredggggtmsql = "SELECT group_type_id, group_id FROM " . $wpdb->prefix . "ge_group_group_type_matches" . " WHERE group_id = %d"; 
						$enmge_ggggtmsql = $wpdb->prepare( $enmge_preparredggggtmsql, $enmge_single->group_id );
						$enmge_ggggtm = $wpdb->get_results( $enmge_ggggtmsql );

						// Get All Group Location Matches
						$enmge_preparredgglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE group_id = %d"; 
						$enmge_gglmsql = $wpdb->prepare( $enmge_preparredgglmsql, $enmge_single->group_id );
						$enmge_gglm = $wpdb->get_results( $enmge_gglmsql );


					} else {
						if ( isset($_GET['enmge_gid']) && is_numeric($_GET['enmge_gid']) ) {
							$enmge_gid = strip_tags($_GET['enmge_gid']);
						}
						
						$enmge_findthemessagesql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_id = %d"; 
						$enmge_findthemessage = $wpdb->prepare( $enmge_findthemessagesql, $enmge_gid );
						$enmge_single = $wpdb->get_row( $enmge_findthemessage, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;

						// Get All Files
						$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
						$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_gid );
						$enmge_files = $wpdb->get_results( $enmge_fsql );

						// Get All Leaders
						$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
						$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_gid );
						$enmge_leaders = $wpdb->get_results( $enmge_lesql );

						// Get All Message Topic Matches
						$enmge_preparredggtmsql = "SELECT topic_id, group_id FROM " . $wpdb->prefix . "ge_group_topic_matches" . " WHERE group_id = %d"; 
						$enmge_ggtmsql = $wpdb->prepare( $enmge_preparredggtmsql, $enmge_single->group_id );
						$enmge_ggtm = $wpdb->get_results( $enmge_ggtmsql );

						// Get All Group Group Type Matches
						$enmge_preparredggggtmsql = "SELECT group_type_id, group_id FROM " . $wpdb->prefix . "ge_group_group_type_matches" . " WHERE group_id = %d"; 
						$enmge_ggggtmsql = $wpdb->prepare( $enmge_preparredggggtmsql, $enmge_single->group_id );
						$enmge_ggggtm = $wpdb->get_results( $enmge_ggggtmsql );

						// Get All Group Location Matches
						$enmge_preparredgglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE group_id = %d"; 
						$enmge_gglmsql = $wpdb->prepare( $enmge_preparredgglmsql, $enmge_single->group_id );
						$enmge_gglm = $wpdb->get_results( $enmge_gglmsql );

					}

					
				} else {
					if ( isset($_GET['enmge_gid']) && is_numeric($_GET['enmge_gid']) ) {
						$enmge_gid = strip_tags($_GET['enmge_gid']);
					}

					$enmge_findthemessagesql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_id = %d"; 
					$enmge_findthemessage = $wpdb->prepare( $enmge_findthemessagesql, $enmge_gid );
					$enmge_single = $wpdb->get_row( $enmge_findthemessage, OBJECT );
					$enmge_singlecount = $wpdb->num_rows;

					// Get All Files
					$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_id ORDER BY sort_id ASC"; 
					$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_gid );
					$enmge_files = $wpdb->get_results( $enmge_fsql );

					// Get All Leaders
					$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
					$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_gid );
					$enmge_leaders = $wpdb->get_results( $enmge_lesql );

					// Get All Message Topic Matches
					$enmge_preparredggtmsql = "SELECT topic_id, group_id FROM " . $wpdb->prefix . "ge_group_topic_matches" . " WHERE group_id = %d"; 
					$enmge_ggtmsql = $wpdb->prepare( $enmge_preparredggtmsql, $enmge_single->group_id );
					$enmge_ggtm = $wpdb->get_results( $enmge_ggtmsql );

					// Get All Group Group Type Matches
					$enmge_preparredggggtmsql = "SELECT group_type_id, group_id FROM " . $wpdb->prefix . "ge_group_group_type_matches" . " WHERE group_id = %d"; 
					$enmge_ggggtmsql = $wpdb->prepare( $enmge_preparredggggtmsql, $enmge_single->group_id );
					$enmge_ggggtm = $wpdb->get_results( $enmge_ggggtmsql );

					// Get All Group Location Matches
					$enmge_preparredgglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE group_id = %d"; 
					$enmge_gglmsql = $wpdb->prepare( $enmge_preparredgglmsql, $enmge_single->group_id );
					$enmge_gglm = $wpdb->get_results( $enmge_gglmsql );

					
				}	
			}
			
			if ( $_GET['enmge_action'] == 'new' && !isset($_GET['enmge_did']) ) { // New Group
				
				$enmge_userdetails = wp_get_current_user(); 
				
				if ( $_POST ) {
					// Get All Locations
					$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " ORDER BY location_id DESC"; 	
					$enmge_locations = $wpdb->get_results( $enmge_lpreparredsql );

					if (empty($_POST['group_title'])) { 
						$enmge_errors[] = '- You must name the ' . stripslashes($enmge_grouptitle) . '.';
					} else {
						$enmge_title = strip_tags($_POST['group_title']);
					}

					$enmge_description = $_POST['group_description'];

					$enmge_photo = $_POST['group_photo'];

					$enmge_day = strip_tags($_POST['group_day']);
					$enmge_frequency = strip_tags($_POST['group_frequency']);


					$enmge_startage  = strip_tags($_POST['group_startage']);
					$enmge_endage = strip_tags($_POST['group_endage']);

					$enmge_childcare = strip_tags($_POST['group_childcare']);
					$enmge_childcare_details = strip_tags($_POST['group_childcare_details']);

					$enmge_privacy = strip_tags($_POST['group_privacy']);
					$enmge_location_privacy = strip_tags($_POST['group_location_privacy']);
					$enmge_status = strip_tags($_POST['group_status']);

					if ( $enmge_startage > $enmge_endage ) {
						$enmge_errors[] = '- Please choose a valid age range.';
					}

					
					if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['group_begins'])) { 
						$enmge_group_begins = strip_tags($_POST['group_begins']);
					} else {
						$enmge_group_begins = '0000-00-00';
						$enmge_errors[] = '- You must provide a valid start date for the ' . stripslashes($enmge_grouptitle) . '.';
					};

					if ( isset($_POST['group_noend']) ) {
						$enmge_noend = 1;
					} else {
						$enmge_noend = 0;
					}

					if ( $enmge_noend == 1 ) {
						$enmge_group_ends = (date("Y", time())+1) . date("-m-d", time());
					} else {
						if ( $_POST['group_ends'] != NULL ) {
						if (preg_match('^\d{4}[\-\/\s]?((((0[13578])|(1[02]))[\-\/\s]?(([0-2][0-9])|(3[01])))|(((0[469])|(11))[\-\/\s]?(([0-2][0-9])|(30)))|(02[\-\/\s]?[0-2][0-9]))$^', $_POST['group_ends'])) { 
								$enmge_group_ends = strip_tags($_POST['group_ends']);
							} else {
								$enmge_errors[] = '- You must provide a valid end date for your ' . stripslashes($enmge_grouptitle) . '.';
							};
						} else {
							$enmge_group_ends = '0000-00-00';
						}
					}

					if ( ($enmge_noend != 1) && ($enmge_group_begins > $enmge_group_ends) ) {
						$enmge_errors[] = '- Please choose a valid start and end date.';
					}

					if ( $_POST['group_starttime1'] == "n" ) {
						$enmge_errors[] = '- Please select a valid start time for this ' . stripslashes($enmge_grouptitle) . '.';
					} else {
						$enmge_group_starttime = $_POST['group_starttime1'].":".$_POST['group_starttime2'].":00";
					}

					if ( $_POST['group_endtime1'] == "n" ) {
						$enmge_errors[] = '- Please select a valid end time for this ' . stripslashes($enmge_grouptitle) . '.';
					} else {
						$enmge_group_endtime = $_POST['group_endtime1'].":".$_POST['group_endtime2'].":00";
					}

					if ( $enmge_group_endtime < $enmge_group_starttime ) {
						$enmge_errors[] = '- Please choose a valid start and end time.';
					}

					$enmge_group_location_label = strip_tags($_POST['group_location_label']);

					if ( $_POST['group_onsite'] == "n" ) {
						$enmge_errors[] = '- Please select a valid meeting location.';
						$enmge_group_onsite = "n";
					} else {
						$enmge_group_onsite = strip_tags($_POST['group_onsite']);
					}

					if ( $enmge_group_onsite != "n" && $enmge_group_onsite > 0 ) {
						$enmge_findthelocationsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d"; 
						$enmge_findthelocation = $wpdb->prepare( $enmge_findthelocationsql, $enmge_group_onsite);
						$enmge_location = $wpdb->get_row( $enmge_findthelocation, OBJECT );

						$enmge_group_address1 = null;
						$enmge_group_address2 = null;
						$enmge_group_city = null;
						$enmge_group_state = null;
						$enmge_group_zip = $enmge_location->location_zip;
						$enmge_group_lat = $enmge_location->location_lat;
						$enmge_group_long = $enmge_location->location_long;
						$enmge_group_campus_name = $enmge_location->location_name;
					} else {
						$enmge_group_address1 = strip_tags($_POST['group_address1']);
						$enmge_group_address2 = strip_tags($_POST['group_address2']);
						if (empty($_POST['group_city'])) { 
							$enmge_errors[] = '- You must at least provide a city for your ' . stripslashes($enmge_grouptitle) . '.';
						} else {
							$enmge_group_city = strip_tags($_POST['group_city']);
						}
						if (empty($_POST['group_state'])) { 
							$enmge_errors[] = '- You must at least provide a state/province for your ' . stripslashes($enmge_grouptitle) . '.';
						} else {
							$enmge_group_state = strip_tags($_POST['group_state']);
						}
						
						$enmge_group_zip = strip_tags($_POST['group_zip']);
						$enmge_group_campus_name = null;

						// Find Lat and Long
						if (empty($enmge_errors)) {
							if ( $_POST['group_manedit'] == 0 ) {
								$enmge_g_address1 = str_replace(' ', '+', trim($enmge_group_address1)).",";
								$enmge_g_address2 = str_replace(' ', '+', trim($enmge_group_address2)).",";
				    			$enmge_g_city    = '+'.str_replace(' ', '+', trim($enmge_group_city)).",";
							    $enmge_g_state   = '+'.str_replace(' ', '+', trim($enmge_group_state));
							    $enmge_g_zip     = isset($enmge_group_zip)? '+'.str_replace(' ', '', trim($enmge_group_zip)) : '';

								$enmge_g_addr_str = $enmge_g_address1.$enmge_g_address2.$enmge_g_city.$enmge_g_state.$enmge_g_zip;       
								if ( $enmge_serverapikey != null ) {
								    $enmge_g_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false&key=" . $enmge_serverapikey;
								} else {
								    $enmge_g_url = "http://maps.googleapis.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false";
								} 

								$enmgech = curl_init();
								curl_setopt($enmgech, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($enmgech, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($enmgech, CURLOPT_URL,$enmge_g_url);
								$enmge_g_jsonData=curl_exec($enmgech);
								curl_close($enmgech);

								$enmge_g_data = json_decode($enmge_g_jsonData);

								if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ) {
									$enmge_errors[] = '- Please double-check your location information. (If you\'re seeing this error repeatedly, you probably need to provide a Geocoding API key for address lookups in Settings > Groups Engine. Refer to the troubleshooting section of the User Guide.)';
								} else {									
									$enmge_group_lat = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
								}

								if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ) {
								} else {
									$enmge_group_long = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
								}
							} else {
								$enmge_group_lat = strip_tags($_POST['group_lat']);
								$enmge_group_long = strip_tags($_POST['group_long']);
							}
						}
					}

					$enmge_manedit = strip_tags($_POST['group_manedit']);

					if ( !empty($_POST['topics']) ) {
						$enmge_topics = $_POST['topics'];
					} else {
						$enmge_topics = NULL;
					}

					if ( !empty($_POST['grouptypes']) ) {
						$enmge_group_types = $_POST['grouptypes'];
					} else {
						$enmge_group_types = NULL;
					}

					if ( !empty($_POST['locations']) ) {
						$enmge_locations = $_POST['locations'];
					} else {
						$enmge_locations = NULL;
					}

					// Check for Group Leaders
					$enmge_preparredlecsql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d AND leader_username = %d GROUP BY leader_id"; 
					$enmge_lecsql = $wpdb->prepare( $enmge_preparredlecsql, 0, $enmge_userdetails->user_login );
					$enmge_leadercheck = $wpdb->get_results( $enmge_lecsql );

					if ( empty($enmge_leadercheck) ) {
						$enmge_errors[] = '- You must add at least one leader for this ' . stripslashes($enmge_grouptitle) . '.';
					}
					
					if (empty($enmge_errors)) {
						$enmge_single_created = "yes";

						$enmge_newgroup = array(
							'group_status' => $enmge_status, 
							'group_title' => $enmge_title, 
							'group_description' => $enmge_description, 
							'group_photo' => $enmge_photo, 
							'group_day' => $enmge_day, 
							'group_begins' => $enmge_group_begins, 
							'group_ends' => $enmge_group_ends, 
							'group_noend' => $enmge_noend,
							'group_starttime' => $enmge_group_starttime, 
							'group_endtime' => $enmge_group_endtime, 
							'group_address1' => $enmge_group_address1, 
							'group_address2' => $enmge_group_address2, 
							'group_city' => $enmge_group_city, 
							'group_state' => $enmge_group_state, 
							'group_zip' => $enmge_group_zip, 
							'group_lat' => $enmge_group_lat, 
							'group_long' => $enmge_group_long, 
							'group_location_privacy' => $enmge_location_privacy,
							'group_location_label' => $enmge_group_location_label, 
							'group_onsite' => $enmge_group_onsite, 
							'group_campus_name' => $enmge_group_campus_name, 
							'group_startage' => $enmge_startage, 
							'group_endage' => $enmge_endage, 
							'group_childcare' => $enmge_childcare, 
							'group_childcare_details' => $enmge_childcare_details, 
							'group_privacy' => $enmge_privacy,
							'group_frequency' => $enmge_frequency,
							'group_manedit' => $enmge_manedit
							); 
						$wpdb->insert( $wpdb->prefix . "ge_groups", $enmge_newgroup );
						$enmge_new_group_id = $wpdb->insert_id; 
						
						// Add group type matches in the DB
						if ( !empty($enmge_group_types) ) {
							foreach ($enmge_group_types as $gt) {
								$enmge_newggtm = array(
									'group_id' => $enmge_new_group_id, 
									'group_type_id' => $gt
									); 
								$wpdb->insert( $wpdb->prefix . "ge_group_group_type_matches", $enmge_newggtm );
							}
						}
						
						// Add topic matches in the DB
						if ( !empty($enmge_topics) ) {
							foreach ($enmge_topics as $t) {
								$enmge_newgtm = array(
									'group_id' => $enmge_new_group_id, 
									'topic_id' => $t
									); 
								$wpdb->insert( $wpdb->prefix . "ge_group_topic_matches", $enmge_newgtm );
							}
						}
						
						
						// Add location matches in the DB
						if ( !empty($enmge_locations) ) {
							foreach ($enmge_locations as $l) {
								$enmge_newglm = array(
									'group_id' => $enmge_new_group_id, 
									'location_id' => $l
									); 
								$wpdb->insert( $wpdb->prefix . "ge_group_location_matches", $enmge_newglm );
							}
						}
						
						// Update uploaded files and change group relations in DB
						$enmge_displayname = $enmge_userdetails->user_login;
						
						
						$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = 0 AND file_username = '" . $enmge_displayname . "' GROUP BY file_id ORDER BY file_name ASC"; 
						$enmge_ufiles = $wpdb->get_results( $enmge_preparredfsql );
						
						foreach ( $enmge_ufiles as $enmge_f ) {
							$enmge_username = null;
							$enmge_fid = $enmge_f->file_id;
							$enmge_gfid = $enmge_f->gf_match_id;
							
							$enmge_new_values = array( 'file_username' => $enmge_username ); 
							$enmge_where = array( 'file_id' => $enmge_fid ); 
							$wpdb->update( $wpdb->prefix . "ge_files", $enmge_new_values, $enmge_where ); 
							
							$enmge_new_valuestwo = array( 'group_id' => $enmge_new_group_id ); 
							$enmge_wheretwo = array( 'gf_match_id' => $enmge_gfid ); 
							$wpdb->update( $wpdb->prefix . "ge_group_file_matches", $enmge_new_valuestwo, $enmge_wheretwo ); 
						}

						$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = 0 AND leader_username = '" . $enmge_displayname . "' GROUP BY leader_id ORDER BY leader_name ASC"; 
						$enmge_uleaders = $wpdb->get_results( $enmge_preparredlesql );
						
						foreach ( $enmge_uleaders as $enmge_l ) {
							$enmge_username = null;
							$enmge_leid = $enmge_l->leader_id;
							$enmge_gleid = $enmge_l->gle_match_id;
							
							$enmge_new_values = array( 'leader_username' => $enmge_username ); 
							$enmge_where = array( 'leader_id' => $enmge_leid ); 
							$wpdb->update( $wpdb->prefix . "ge_leaders", $enmge_new_values, $enmge_where ); 
							
							$enmge_new_valuestwo = array( 'group_id' => $enmge_new_group_id ); 
							$enmge_wheretwo = array( 'gle_match_id' => $enmge_gleid ); 
							$wpdb->update( $wpdb->prefix . "ge_group_leader_matches", $enmge_new_valuestwo, $enmge_wheretwo ); 
						}
						
						$enmge_messages[] = "You have successfully added a new " . stripslashes($enmge_grouptitle) . " to Groups Engine!";
					} else {
						// Get temporarily uploaded files
						$enmge_displayname = $enmge_userdetails->user_login;
						
						// Get All Files
						$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = 0 AND file_username = '" . $enmge_displayname . "' GROUP BY file_id ORDER BY sort_id ASC"; 
						$enmge_files = $wpdb->get_results( $enmge_preparredfsql );

						// Get All Leaders
						$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = 0 AND leader_username = '" . $enmge_displayname . "' GROUP BY leader_id"; 
						$enmge_leaders = $wpdb->get_results( $enmge_preparredlesql );
					}
				} else {
					// Delete any temporary files and leaders if the message was abandoned
					$enmge_displayname = $enmge_userdetails->user_login;
					
					$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = 0 AND file_username = '" . $enmge_displayname . "' GROUP BY file_id ORDER BY file_name ASC"; 
					$enmge_dfiles = $wpdb->get_results( $enmge_preparredfsql );
					
					foreach ($enmge_dfiles as $enmge_f) {
						$enmge_nfid = $enmge_f->file_id;
						$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_files" . "  WHERE file_id = %d";
						$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_nfid ); 
						$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
						
						$matchid = $enmge_f->gf_match_id;
						$enmge_deletetwo_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_file_matches" . "  WHERE gf_match_id=%d";
						$enmge_deletetwo_query = $wpdb->prepare( $enmge_deletetwo_query_preparred, $matchid ); 
						$enmge_deletedtwo = $wpdb->query( $enmge_deletetwo_query );
					}

					$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = 0 AND leader_username = '" . $enmge_displayname . "' GROUP BY leader_id"; 
					$enmge_dleaders = $wpdb->get_results( $enmge_preparredlesql );
					
					foreach ($enmge_dleaders as $enmge_le) {
						$enmge_nlid = $enmge_le->leader_id;
						$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_leaders" . "  WHERE leader_id = %d";
						$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_nlid ); 
						$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
						
						$matchid = $enmge_le->gle_match_id;
						$enmge_deletetwo_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_group_leader_matches" . "  WHERE gle_match_id=%d";
						$enmge_deletetwo_query = $wpdb->prepare( $enmge_deletetwo_query_preparred, $matchid ); 
						$enmge_deletedtwo = $wpdb->query( $enmge_deletetwo_query );
					}
				}

			}

		}

		if ( isset($_GET['enmge_duplicate']) && $_GET['enmge_duplicate'] == '1' ) { // Duplicate Group
				$enmge_userdetails = wp_get_current_user(); 

				if ( isset($_GET['enmge_gid']) && is_numeric($_GET['enmge_gid']) ) {
					$enmge_gid = strip_tags($_GET['enmge_gid']);
				}
				
				$enmge_findthemessagesql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_id = %d"; 
				$enmge_findthemessage = $wpdb->prepare( $enmge_findthemessagesql, $enmge_gid );
				$enmge_single = $wpdb->get_row( $enmge_findthemessage, OBJECT );
				$enmge_singlecount = $wpdb->num_rows;

				// Get All Files
				$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_name ORDER BY sort_id ASC"; 
				$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_gid );
				$enmge_files = $wpdb->get_results( $enmge_fsql );

				// Get All Leaders
				$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
				$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_gid );
				$enmge_dupleaders = $wpdb->get_results( $enmge_lesql );

				// Get All Message Topic Matches
				$enmge_preparredggtmsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_topic_matches" . " WHERE group_id = %d"; 
				$enmge_ggtmsql = $wpdb->prepare( $enmge_preparredggtmsql, $enmge_single->group_id );
				$enmge_ggtm = $wpdb->get_results( $enmge_ggtmsql );

				// Get All Group Group Type Matches
				$enmge_preparredggggtmsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_group_type_matches" . " WHERE group_id = %d"; 
				$enmge_ggggtmsql = $wpdb->prepare( $enmge_preparredggggtmsql, $enmge_single->group_id );
				$enmge_ggggtm = $wpdb->get_results( $enmge_ggggtmsql );

				// Get All Group Location Matches
				$enmge_preparredgglmsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE group_id = %d"; 
				$enmge_gglmsql = $wpdb->prepare( $enmge_preparredgglmsql, $enmge_single->group_id );
				$enmge_gglm = $wpdb->get_results( $enmge_gglmsql );

				
				$enmge_status = $enmge_single->group_status;
				$enmge_title = "(Duplicate) " . $enmge_single->group_title;
				$enmge_description = $enmge_single->group_description;
				$enmge_photo = $enmge_single->group_photo;
				$enmge_leaders = $enmge_single->group_leaders;
				$enmge_leaders_email = $enmge_single->group_leaders_email;
				$enmge_day = $enmge_single->group_day;
				$enmge_frequency = $enmge_single->group_frequency;
				$enmge_startage = $enmge_single->group_startage;
				$enmge_endage = $enmge_single->group_endage;
				$enmge_childcare = $enmge_single->group_childcare;
				$enmge_childcare_details = $enmge_single->group_childcare_details;
				$enmge_privacy = $enmge_single->group_privacy;
				$enmge_location_privacy = $enmge_single->group_location_privacy;
				$enmge_group_begins = $enmge_single->group_begins;
				$enmge_group_ends = $enmge_single->group_ends;
				$enmge_group_starttime = $enmge_single->group_starttime;
				$enmge_group_noend = $enmge_single->group_noend;
				$enmge_group_endtime = $enmge_single->group_endtime;
				$enmge_group_location_label = $enmge_single->group_location_label;
				$enmge_group_onsite = $enmge_single->group_onsite;
				$enmge_group_address1 = $enmge_single->group_address1;
				$enmge_group_address2 = $enmge_single->group_address2;
				$enmge_group_city = $enmge_single->group_city;
				$enmge_group_state = $enmge_single->group_state;
				$enmge_group_zip = $enmge_single->group_zip;
				$enmge_group_campus_name = $enmge_single->group_campus_name;
				$enmge_group_lat = $enmge_single->group_lat;
				$enmge_group_long = $enmge_single->group_long;

				$enmge_newgroup = array(
					'group_status' => $enmge_status,
					'group_title' => $enmge_title, 
					'group_description' => $enmge_description, 
					'group_photo' => $enmge_photo, 
					'group_leaders' => $enmge_leaders, 
					'group_leaders_email' => $enmge_leaders_email, 
					'group_day' => $enmge_day, 
					'group_begins' => $enmge_group_begins, 
					'group_ends' => $enmge_group_ends, 
					'group_noend' => $enmge_group_noend, 
					'group_starttime' => $enmge_group_starttime, 
					'group_endtime' => $enmge_group_endtime, 
					'group_address1' => $enmge_group_address1, 
					'group_address2' => $enmge_group_address2, 
					'group_city' => $enmge_group_city, 
					'group_state' => $enmge_group_state, 
					'group_zip' => $enmge_group_zip, 
					'group_lat' => $enmge_group_lat, 
					'group_long' => $enmge_group_long, 
					'group_location_privacy' => $enmge_location_privacy, 
					'group_location_label' => $enmge_group_location_label, 
					'group_onsite' => $enmge_group_onsite, 
					'group_campus_name' => $enmge_group_campus_name, 
					'group_startage' => $enmge_startage, 
					'group_endage' => $enmge_endage, 
					'group_childcare' => $enmge_childcare, 
					'group_childcare_details' => $enmge_childcare_details, 
					'group_privacy' => $enmge_privacy,
					'group_frequency' => $enmge_frequency
					); 
				$wpdb->insert( $wpdb->prefix . "ge_groups", $enmge_newgroup );
				$enmge_new_group_id = $wpdb->insert_id; 
				
				// Add group type matches in the DB
				if ( !empty($enmge_ggggtm) ) {
					foreach ($enmge_ggggtm as $gt) {
						$enmge_newggtm = array(
							'group_id' => $enmge_new_group_id, 
							'group_type_id' => $gt->group_type_id
							); 
						$wpdb->insert( $wpdb->prefix . "ge_group_group_type_matches", $enmge_newggtm );
					}
				}
				
				// Add topic matches in the DB
				if ( !empty($enmge_ggtm) ) {
					foreach ($enmge_ggtm as $t) {
						$enmge_newgtm = array(
							'group_id' => $enmge_new_group_id, 
							'topic_id' => $t->topic_id
							); 
						$wpdb->insert( $wpdb->prefix . "ge_group_topic_matches", $enmge_newgtm );
					}
				}
				
				// Add location matches in the DB
				if ( !empty($enmge_gglm) ) {
					foreach ($enmge_gglm as $l) {
						$enmge_newglm = array(
							'group_id' => $enmge_new_group_id, 
							'location_id' => $l->location_id
							); 
						$wpdb->insert( $wpdb->prefix . "ge_group_location_matches", $enmge_newglm );
					}
				}
				
				// FILES
				if ( !empty($enmge_files) ) {
					foreach ($enmge_files as $f) {
						$enmge_newf = array(
							'file_name' => $f->file_name, 
							'file_url' => $f->file_url,
							'file_username' => $enmge_userdetails->user_login,
							'sort_id' => $f->sort_id
							); 
						$wpdb->insert( $wpdb->prefix . "ge_files", $enmge_newf );
						$enmge_new_file_id = $wpdb->insert_id; 

						$enmge_newfm = array(
							'group_id' => $enmge_new_group_id, 
							'file_id' => $enmge_new_file_id
							); 
						$wpdb->insert( $wpdb->prefix . "ge_group_file_matches", $enmge_newfm );
					}
				}

				// LEADERS
				if ( !empty($enmge_dupleaders) ) {
					foreach ($enmge_dupleaders as $l) {
						$enmge_newle = array(
							'leader_name' => $l->leader_name, 
							'leader_email' => $l->leader_email,
							'leader_username' => $enmge_userdetails->user_login
							); 
						$wpdb->insert( $wpdb->prefix . "ge_leaders", $enmge_newle );
						$enmge_new_leader_id = $wpdb->insert_id; 

						$enmge_newlem = array(
							'group_id' => $enmge_new_group_id, 
							'leader_id' => $enmge_new_leader_id
							); 
						$wpdb->insert( $wpdb->prefix . "ge_group_leader_matches", $enmge_newlem );
					}
				}
				
				$enmge_messages[] = "You have successfully duplicated this " . stripslashes($enmge_grouptitle) . "!";
		}

		include ('paginated_groups.php'); // Get all groups

		if ( isset($_GET['enmge_gtid']) ) { // If results are sorted by Group Type
			$enmge_findthegrouptypesql = "SELECT group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " WHERE group_type_id = %d"; 
			$enmge_findthegrouptype = $wpdb->prepare( $enmge_findthegrouptypesql, $enmge_gtid );
			$enmge_group_type = $wpdb->get_row( $enmge_findthegrouptype, OBJECT );
		}

		if ( isset($_GET['enmge_tid']) ) { // If results are sorted by Group Type
			$enmge_findthetopicsql = "SELECT topic_name FROM " . $wpdb->prefix . "ge_topics" . " WHERE topic_id = %d"; 
			$enmge_findthetopic = $wpdb->prepare( $enmge_findthetopicsql, $enmge_tid );
			$enmge_topic = $wpdb->get_row( $enmge_findthetopic, OBJECT );
		}

		if ( isset($_GET['enmge_lid']) ) { // If results are sorted by Location
			$enmge_findthelocationsql = "SELECT location_name FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d"; 
			$enmge_findthelocation = $wpdb->prepare( $enmge_findthelocationsql, $enmge_lid );
			$enmge_location = $wpdb->get_row( $enmge_findthelocation, OBJECT );
		}

		// Get All Topics
		$enmge_preparredtsql = "SELECT topic_id, topic_name FROM " . $wpdb->prefix . "ge_topics" . " ORDER BY topic_name ASC"; 
		$enmge_t = $wpdb->get_results( $enmge_preparredtsql );

		// Get All Group Topic Matches
		$enmge_preparredgtmsql = "SELECT topic_id, group_id FROM " . $wpdb->prefix . "ge_group_topic_matches"; 
		$enmge_gtm = $wpdb->get_results( $enmge_preparredgtmsql );

		// Get All Group Types
		$enmge_preparredgtsql = "SELECT group_type_id, group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_title ASC"; 
		$enmge_gt = $wpdb->get_results( $enmge_preparredgtsql );

		// Get All Group Group Type Matches
		$enmge_preparredgggtmsql = "SELECT group_type_id, group_id FROM " . $wpdb->prefix . "ge_group_group_type_matches"; 
		$enmge_gggtm = $wpdb->get_results( $enmge_preparredgggtmsql );

		// Get All Locations
		$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " ORDER BY location_name ASC"; 	
		$enmge_locations = $wpdb->get_results( $enmge_lpreparredsql );

		// Get All Group Location Matches
		$enmge_preparredglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches"; 
		$enmge_glm = $wpdb->get_results( $enmge_preparredglmsql );
		

	} else {
		exit("Access Denied");
	}
	
?>

<div class="wrap"> 
<?php if ( isset($_GET['enmge_action']) && ( $enmge_single_created == null && !isset($_GET['enmge_did']) ) ) { if ( $_GET['enmge_action'] == 'new' ) { // If they're adding a new Group ?>
		<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
		<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/datepicker.js'; ?>" ></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#group_begins").datepicker({ dateFormat: 'yy-mm-dd' });
				jQuery("#group_ends").datepicker({ dateFormat: 'yy-mm-dd' });
				jQuery("#group_starttime1").on("change", function() {
					var hourval = jQuery(this).val();
					if (hourval == "n") {
						alert('Please select a valid hour');
					};
					if (hourval >= 12) {
						jQuery("#enmge_ampm1").html('pm');
					} else {
						jQuery("#enmge_ampm1").html('am');
					};
				});
				jQuery("#group_endtime1").on("change", function() {
					var hourval = jQuery(this).val();
					if (hourval == "n") {
						alert('Please select a valid hour');
					};
					if (hourval >= 12) {
						jQuery("#enmge_ampm2").html('pm');
					} else {
						jQuery("#enmge_ampm2").html('am');
					};
				});
				jQuery("#group_onsite").on("change", function() {
					var onsiteval = jQuery(this).val();
					if (onsiteval == 0) {
						jQuery("#enmgeaddressinfo").show();
					} else {
						jQuery("#enmgeaddressinfo").hide();
					};
				});
				jQuery("#group_manedit").on("change", function() {
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
		<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/group_options130.js'; ?>"></script>

		<h2 class="enmge">Add a New <?php echo stripslashes($enmge_grouptitle); ?></h2>
		<?php include ('errorbox.php'); ?>
		<p>Complete the form below to add a new <?php echo stripslashes($enmge_grouptitle); ?> to Groups Engine. Be sure to specify the appropriate Group Type and Location in "<?php echo stripslashes($enmge_grouptitle); ?> Details" section. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-groups"; ?>">User Guide</a>.</p>
		<?php /*if ( $_POST ) { 
			echo $enmge_g_url;
			 var_dump($enmge_g_data);
		}*/ ?>
		<ul id="enmge-group-options">
			<li class="selected"><a href="#" id="enmge-group-general">General Information</a></li>
			<li><a href="#" id="enmge-group-details"><?php echo stripslashes($enmge_grouptitle); ?> Details</a></li>
			<li><a href="#" id="enmge-group-location">Location</a></li>
			<li><a href="#" id="enmge-group-files">Attach Links/Downloads</a></li>
		</ul>
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Status:</th>
					<td>
						<select name="group_status" id="group_status" tabindex="1">
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_status'] == 1) { ?>selected="selected"<?php }} ?>>Open</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_status'] == 0) { ?>selected="selected"<?php }} ?>>Closed</option>
							<option value="2" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_status'] == 2) { ?>selected="selected"<?php }} ?>>Full</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Title:</strong></th>
					<td><input id='group_title' name='group_title' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_title']);} ?>" tabindex="2" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Description:
						<p class="ge-form-instructions">A brief description of the <?php echo stripslashes($enmge_grouptitle); ?>.</p>
					</th>
					<td>
						<textarea name="group_description" id="group_description" rows="4" cols="40" tabindex="3"><?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_description']);} ?></textarea><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Photo:</strong></th>
					<td><input id='group_photo' name='group_photo' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_photo']);} ?>" tabindex="4" />  &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=image&#038;TB_iframe=1', __FILE__ ); ?>" class="enmge-upload-image ge-upload-link" id="content-add_media" title="Add Image" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="ge-media-button" /> &nbsp;Upload Image</a><div id="group-image-load"><?php if ($_POST && !empty($enmge_errors) && !empty($_POST['group_photo'])) { ?><br /><img src="<?php echo $_POST['group_photo']; ?>" /><?php } ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Age Range:</strong></th>
					<td>
						<select name="group_startage" id="group_startage" tabindex="5">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 0) { echo 'selected="selected"';}} ?>>0</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 1) { echo 'selected="selected"';}} ?>>1</option>
							<option value="2" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 2) { echo 'selected="selected"';}} ?>>2</option>
							<option value="3" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 3) { echo 'selected="selected"';}} ?>>3</option>
							<option value="4" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 4) { echo 'selected="selected"';}} ?>>4</option>
							<option value="5" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 5) { echo 'selected="selected"';}} ?>>5</option>
							<option value="6" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 6) { echo 'selected="selected"';}} ?>>6</option>
							<option value="7" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 7) { echo 'selected="selected"';}} ?>>7</option>
							<option value="8" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 8) { echo 'selected="selected"';}} ?>>8</option>
							<option value="9" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 9) { echo 'selected="selected"';}} ?>>9</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 10) { echo 'selected="selected"';}} ?>>10</option>
							<option value="11" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 11) { echo 'selected="selected"';}} ?>>11</option>
							<option value="12" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 12) { echo 'selected="selected"';}} ?>>12</option>
							<option value="13" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 13) { echo 'selected="selected"';}} ?>>13</option>
							<option value="14" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 14) { echo 'selected="selected"';}} ?>>14</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 15) { echo 'selected="selected"';}} ?>>15</option>
							<option value="16" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 16) { echo 'selected="selected"';}} ?>>16</option>
							<option value="17" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 17) { echo 'selected="selected"';}} ?>>17</option>
							<option value="18" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 18) { echo 'selected="selected"';}} ?>>18</option>
							<option value="19" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 19) { echo 'selected="selected"';}} ?>>19</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 20) { echo 'selected="selected"';}} ?>>20</option>
							<option value="21" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 21) { echo 'selected="selected"';}} else {echo 'selected="selected"';} ?>>21</option>
							<option value="22" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 22) { echo 'selected="selected"';}} ?>>22</option>
							<option value="23" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 23) { echo 'selected="selected"';}} ?>>23</option>
							<option value="24" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 24) { echo 'selected="selected"';}} ?>>24</option>
							<option value="25" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 25) { echo 'selected="selected"';}} ?>>25</option>
							<option value="26" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 26) { echo 'selected="selected"';}} ?>>26</option>
							<option value="27" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 27) { echo 'selected="selected"';}} ?>>27</option>
							<option value="28" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 28) { echo 'selected="selected"';}} ?>>28</option>
							<option value="29" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 29) { echo 'selected="selected"';}} ?>>29</option>
							<option value="30" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 30) { echo 'selected="selected"';}} ?>>30</option>
							<option value="31" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 31) { echo 'selected="selected"';}} ?>>31</option>
							<option value="32" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 32) { echo 'selected="selected"';}} ?>>32</option>
							<option value="33" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 33) { echo 'selected="selected"';}} ?>>33</option>
							<option value="34" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 34) { echo 'selected="selected"';}} ?>>34</option>
							<option value="35" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 35) { echo 'selected="selected"';}} ?>>35</option>
							<option value="36" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 36) { echo 'selected="selected"';}} ?>>36</option>
							<option value="37" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 37) { echo 'selected="selected"';}} ?>>37</option>
							<option value="38" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 38) { echo 'selected="selected"';}} ?>>38</option>
							<option value="39" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 39) { echo 'selected="selected"';}} ?>>39</option>
							<option value="40" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 40) { echo 'selected="selected"';}} ?>>40</option>
							<option value="41" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 41) { echo 'selected="selected"';}} ?>>41</option>
							<option value="42" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 42) { echo 'selected="selected"';}} ?>>42</option>
							<option value="43" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 43) { echo 'selected="selected"';}} ?>>43</option>
							<option value="44" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 44) { echo 'selected="selected"';}} ?>>44</option>
							<option value="45" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 45) { echo 'selected="selected"';}} ?>>45</option>
							<option value="46" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 46) { echo 'selected="selected"';}} ?>>46</option>
							<option value="47" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 47) { echo 'selected="selected"';}} ?>>47</option>
							<option value="48" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 48) { echo 'selected="selected"';}} ?>>48</option>
							<option value="49" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 49) { echo 'selected="selected"';}} ?>>49</option>
							<option value="50" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 50) { echo 'selected="selected"';}} ?>>50</option>
							<option value="51" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 51) { echo 'selected="selected"';}} ?>>51</option>
							<option value="52" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 52) { echo 'selected="selected"';}} ?>>52</option>
							<option value="53" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 53) { echo 'selected="selected"';}} ?>>53</option>
							<option value="54" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 54) { echo 'selected="selected"';}} ?>>54</option>
							<option value="55" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 55) { echo 'selected="selected"';}} ?>>55</option>
							<option value="56" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 56) { echo 'selected="selected"';}} ?>>56</option>
							<option value="57" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 57) { echo 'selected="selected"';}} ?>>57</option>
							<option value="58" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 58) { echo 'selected="selected"';}} ?>>58</option>
							<option value="59" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 59) { echo 'selected="selected"';}} ?>>59</option>
							<option value="60" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 60) { echo 'selected="selected"';}} ?>>60</option>
							<option value="61" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 61) { echo 'selected="selected"';}} ?>>61</option>
							<option value="62" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 62) { echo 'selected="selected"';}} ?>>62</option>
							<option value="63" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 63) { echo 'selected="selected"';}} ?>>63</option>
							<option value="64" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 64) { echo 'selected="selected"';}} ?>>64</option>
							<option value="65" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 65) { echo 'selected="selected"';}} ?>>65</option>
							<option value="66" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 66) { echo 'selected="selected"';}} ?>>66</option>
							<option value="67" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 67) { echo 'selected="selected"';}} ?>>67</option>
							<option value="68" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 68) { echo 'selected="selected"';}} ?>>68</option>
							<option value="69" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 69) { echo 'selected="selected"';}} ?>>69</option>
							<option value="70" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 70) { echo 'selected="selected"';}} ?>>70</option>
							<option value="71" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 71) { echo 'selected="selected"';}} ?>>71</option>
							<option value="72" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 72) { echo 'selected="selected"';}} ?>>72</option>
							<option value="73" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 73) { echo 'selected="selected"';}} ?>>73</option>
							<option value="74" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 74) { echo 'selected="selected"';}} ?>>74</option>
							<option value="75" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 75) { echo 'selected="selected"';}} ?>>75</option>
							<option value="76" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 76) { echo 'selected="selected"';}} ?>>76</option>
							<option value="77" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 77) { echo 'selected="selected"';}} ?>>77</option>
							<option value="78" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 78) { echo 'selected="selected"';}} ?>>78</option>
							<option value="79" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 79) { echo 'selected="selected"';}} ?>>79</option>
							<option value="80" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 80) { echo 'selected="selected"';}} ?>>80</option>
							<option value="81" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 81) { echo 'selected="selected"';}} ?>>81</option>
							<option value="82" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 82) { echo 'selected="selected"';}} ?>>82</option>
							<option value="83" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 83) { echo 'selected="selected"';}} ?>>83</option>
							<option value="84" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 84) { echo 'selected="selected"';}} ?>>84</option>
							<option value="85" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 85) { echo 'selected="selected"';}} ?>>85</option>
							<option value="86" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 86) { echo 'selected="selected"';}} ?>>86</option>
							<option value="87" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 87) { echo 'selected="selected"';}} ?>>87</option>
							<option value="88" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 88) { echo 'selected="selected"';}} ?>>88</option>
							<option value="89" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 89) { echo 'selected="selected"';}} ?>>89</option>
							<option value="90" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 90) { echo 'selected="selected"';}} ?>>90</option>
							<option value="91" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 91) { echo 'selected="selected"';}} ?>>91</option>
							<option value="92" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 92) { echo 'selected="selected"';}} ?>>92</option>
							<option value="93" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 93) { echo 'selected="selected"';}} ?>>93</option>
							<option value="94" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 94) { echo 'selected="selected"';}} ?>>94</option>
							<option value="95" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 95) { echo 'selected="selected"';}} ?>>95</option>
							<option value="96" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 96) { echo 'selected="selected"';}} ?>>96</option>
							<option value="97" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 97) { echo 'selected="selected"';}} ?>>97</option>
							<option value="98" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 98) { echo 'selected="selected"';}} ?>>98</option>
							<option value="99" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 99) { echo 'selected="selected"';}} ?>>99</option>
						</select> - 
						<select name="group_endage" id="group_endage" tabindex="6">
							<option value="100" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 100) { echo 'selected="selected"';}} else {echo 'selected="selected"';} ?>>Any</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 0) { echo 'selected="selected"';}} ?>>0</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 1) { echo 'selected="selected"';}} ?>>1</option>
							<option value="2" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 2) { echo 'selected="selected"';}} ?>>2</option>
							<option value="3" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 3) { echo 'selected="selected"';}} ?>>3</option>
							<option value="4" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 4) { echo 'selected="selected"';}} ?>>4</option>
							<option value="5" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 5) { echo 'selected="selected"';}} ?>>5</option>
							<option value="6" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 6) { echo 'selected="selected"';}} ?>>6</option>
							<option value="7" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 7) { echo 'selected="selected"';}} ?>>7</option>
							<option value="8" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 8) { echo 'selected="selected"';}} ?>>8</option>
							<option value="9" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 9) { echo 'selected="selected"';}} ?>>9</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 10) { echo 'selected="selected"';}} ?>>10</option>
							<option value="11" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 11) { echo 'selected="selected"';}} ?>>11</option>
							<option value="12" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 12) { echo 'selected="selected"';}} ?>>12</option>
							<option value="13" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 13) { echo 'selected="selected"';}} ?>>13</option>
							<option value="14" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 14) { echo 'selected="selected"';}} ?>>14</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 15) { echo 'selected="selected"';}} ?>>15</option>
							<option value="16" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 16) { echo 'selected="selected"';}} ?>>16</option>
							<option value="17" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 17) { echo 'selected="selected"';}} ?>>17</option>
							<option value="18" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 18) { echo 'selected="selected"';}} ?>>18</option>
							<option value="19" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 19) { echo 'selected="selected"';}} ?>>19</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 20) { echo 'selected="selected"';}} ?>>20</option>
							<option value="21" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 21) { echo 'selected="selected"';}} ?>>21</option>
							<option value="22" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 22) { echo 'selected="selected"';}} ?>>22</option>
							<option value="23" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 23) { echo 'selected="selected"';}} ?>>23</option>
							<option value="24" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 24) { echo 'selected="selected"';}} ?>>24</option>
							<option value="25" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 25) { echo 'selected="selected"';}} ?>>25</option>
							<option value="26" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 26) { echo 'selected="selected"';}} ?>>26</option>
							<option value="27" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 27) { echo 'selected="selected"';}} ?>>27</option>
							<option value="28" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 28) { echo 'selected="selected"';}} ?>>28</option>
							<option value="29" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 29) { echo 'selected="selected"';}} ?>>29</option>
							<option value="30" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 30) { echo 'selected="selected"';}} ?>>30</option>
							<option value="31" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 31) { echo 'selected="selected"';}} ?>>31</option>
							<option value="32" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 32) { echo 'selected="selected"';}} ?>>32</option>
							<option value="33" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 33) { echo 'selected="selected"';}} ?>>33</option>
							<option value="34" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 34) { echo 'selected="selected"';}} ?>>34</option>
							<option value="35" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 35) { echo 'selected="selected"';}} ?>>35</option>
							<option value="36" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 36) { echo 'selected="selected"';}} ?>>36</option>
							<option value="37" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 37) { echo 'selected="selected"';}} ?>>37</option>
							<option value="38" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 38) { echo 'selected="selected"';}} ?>>38</option>
							<option value="39" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 39) { echo 'selected="selected"';}} ?>>39</option>
							<option value="40" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 40) { echo 'selected="selected"';}} ?>>40</option>
							<option value="41" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 41) { echo 'selected="selected"';}} ?>>41</option>
							<option value="42" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 42) { echo 'selected="selected"';}} ?>>42</option>
							<option value="43" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 43) { echo 'selected="selected"';}} ?>>43</option>
							<option value="44" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 44) { echo 'selected="selected"';}} ?>>44</option>
							<option value="45" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 45) { echo 'selected="selected"';}} ?>>45</option>
							<option value="46" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 46) { echo 'selected="selected"';}} ?>>46</option>
							<option value="47" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 47) { echo 'selected="selected"';}} ?>>47</option>
							<option value="48" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 48) { echo 'selected="selected"';}} ?>>48</option>
							<option value="49" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 49) { echo 'selected="selected"';}} ?>>49</option>
							<option value="50" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 50) { echo 'selected="selected"';}} ?>>50</option>
							<option value="51" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 51) { echo 'selected="selected"';}} ?>>51</option>
							<option value="52" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 52) { echo 'selected="selected"';}} ?>>52</option>
							<option value="53" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 53) { echo 'selected="selected"';}} ?>>53</option>
							<option value="54" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 54) { echo 'selected="selected"';}} ?>>54</option>
							<option value="55" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 55) { echo 'selected="selected"';}} ?>>55</option>
							<option value="56" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 56) { echo 'selected="selected"';}} ?>>56</option>
							<option value="57" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 57) { echo 'selected="selected"';}} ?>>57</option>
							<option value="58" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 58) { echo 'selected="selected"';}} ?>>58</option>
							<option value="59" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 59) { echo 'selected="selected"';}} ?>>59</option>
							<option value="60" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 60) { echo 'selected="selected"';}} ?>>60</option>
							<option value="61" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 61) { echo 'selected="selected"';}} ?>>61</option>
							<option value="62" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 62) { echo 'selected="selected"';}} ?>>62</option>
							<option value="63" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 63) { echo 'selected="selected"';}} ?>>63</option>
							<option value="64" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 64) { echo 'selected="selected"';}} ?>>64</option>
							<option value="65" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 65) { echo 'selected="selected"';}} ?>>65</option>
							<option value="66" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 66) { echo 'selected="selected"';}} ?>>66</option>
							<option value="67" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 67) { echo 'selected="selected"';}} ?>>67</option>
							<option value="68" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 68) { echo 'selected="selected"';}} ?>>68</option>
							<option value="69" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 69) { echo 'selected="selected"';}} ?>>69</option>
							<option value="70" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 70) { echo 'selected="selected"';}} ?>>70</option>
							<option value="71" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 71) { echo 'selected="selected"';}} ?>>71</option>
							<option value="72" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 72) { echo 'selected="selected"';}} ?>>72</option>
							<option value="73" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 73) { echo 'selected="selected"';}} ?>>73</option>
							<option value="74" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 74) { echo 'selected="selected"';}} ?>>74</option>
							<option value="75" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 75) { echo 'selected="selected"';}} ?>>75</option>
							<option value="76" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 76) { echo 'selected="selected"';}} ?>>76</option>
							<option value="77" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 77) { echo 'selected="selected"';}} ?>>77</option>
							<option value="78" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 78) { echo 'selected="selected"';}} ?>>78</option>
							<option value="79" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 79) { echo 'selected="selected"';}} ?>>79</option>
							<option value="80" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 80) { echo 'selected="selected"';}} ?>>80</option>
							<option value="81" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 81) { echo 'selected="selected"';}} ?>>81</option>
							<option value="82" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 82) { echo 'selected="selected"';}} ?>>82</option>
							<option value="83" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 83) { echo 'selected="selected"';}} ?>>83</option>
							<option value="84" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 84) { echo 'selected="selected"';}} ?>>84</option>
							<option value="85" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 85) { echo 'selected="selected"';}} ?>>85</option>
							<option value="86" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 86) { echo 'selected="selected"';}} ?>>86</option>
							<option value="87" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 87) { echo 'selected="selected"';}} ?>>87</option>
							<option value="88" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 88) { echo 'selected="selected"';}} ?>>88</option>
							<option value="89" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 89) { echo 'selected="selected"';}} ?>>89</option>
							<option value="90" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 90) { echo 'selected="selected"';}} ?>>90</option>
							<option value="91" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 91) { echo 'selected="selected"';}} ?>>91</option>
							<option value="92" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 92) { echo 'selected="selected"';}} ?>>92</option>
							<option value="93" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 93) { echo 'selected="selected"';}} ?>>93</option>
							<option value="94" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 94) { echo 'selected="selected"';}} ?>>94</option>
							<option value="95" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 95) { echo 'selected="selected"';}} ?>>95</option>
							<option value="96" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 96) { echo 'selected="selected"';}} ?>>96</option>
							<option value="97" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 97) { echo 'selected="selected"';}} ?>>97</option>
							<option value="98" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 98) { echo 'selected="selected"';}} ?>>98</option>
							<option value="99" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 99) { echo 'selected="selected"';}} ?>>99</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Add Leader(s):</strong></th>
					<td>
						<div id="leader_list">
							<?php if ( !empty($enmge_leaders) ) { ?>
							<table cellpadding="0" cellspacing="0" class="leadertable"> 
							<?php foreach ($enmge_leaders as $leader) {  ?>
								<tr id="lrow_<?php echo $leader->leader_id; ?>">
									<td><?php echo $leader->leader_name; ?></td>
									<td>(<em><?php echo $leader->leader_email; ?></em>)</td>
									<td class="enmge-delete"><a href="#" class="groupsengine_leaderdelete" name="<?php echo $leader->leader_id; ?>">(X)</a></td>				
								</tr>
							<?php } ?>
							</table>
							<?php } ?>
						</div>
						<div id="newleadersection">
							<input id='leader_name' name='leader_name' size='10' type='text' style="color: #cbcbcb" value='Name' />
							<input id='leader_email' name='leader_email' size='15' type='text' style="color: #cbcbcb" value='Email' />
							<a href="#" id="addnewleader" class="button">Add Leader</a>
						</div>
						<input type="hidden" name="leader_username" value="<?php echo $enmge_userdetails->user_login; ?>" id="leader_username" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Day of Week:</th>
					<td>
						<select name="group_frequency" id="group_frequency" tabindex="9">
							<option value="Every" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every") { echo 'selected="selected"';}} ?>>Every</option>
							<option value="Every other" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every other") { echo 'selected="selected"';}} ?>>Every other</option>
							<option value="Regularly on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Regularly on") { echo 'selected="selected"';}} ?>>Regularly on</option>
							<option value="Every 1st Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 1st Week on") { echo 'selected="selected"';}} ?>>Every 1st Week on</option>
							<option value="Every 2nd Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 2nd Week on") { echo 'selected="selected"';}} ?>>Every 2nd Week on</option>
							<option value="Every 3rd Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 3rd Week on") { echo 'selected="selected"';}} ?>>Every 3rd Week on</option>
							<option value="Every 4th Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 4th Week on") { echo 'selected="selected"';}} ?>>Every 4th Week on</option>
							<option value="Every 5th Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 5th Week on") { echo 'selected="selected"';}} ?>>Every 5th Week on</option>							
							<option value="Every 1st and 3rd Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 1st and 3rd Week on") { echo 'selected="selected"';}} ?>>Every 1st and 3rd Week on</option>
							<option value="Every 2nd and 4th Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 2nd and 4th Week on") { echo 'selected="selected"';}} ?>>Every 2nd and 4th Week on</option>
						</select>
						<select name="group_day" id="group_day" tabindex="10">
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 1) { echo 'selected="selected"';}} ?>>Sunday</option>
							<option value="2" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 2) { echo 'selected="selected"';}} ?>>Monday</option>
							<option value="3" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 3) { echo 'selected="selected"';}} ?>>Tuesday</option>
							<option value="4" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 4) { echo 'selected="selected"';}} ?>>Wednesday</option>
							<option value="5" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 5) { echo 'selected="selected"';}} ?>>Thursday</option>
							<option value="6" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 6) { echo 'selected="selected"';}} ?>>Friday</option>
							<option value="7" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 7) { echo 'selected="selected"';}} ?>>Saturday</option>
							<option value="8" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 8) { echo 'selected="selected"';}} ?>>Various Days</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Start Time:</strong></th>
					<td>
						<select name="group_starttime1" id="group_starttime1" tabindex="11">
							<option value="n">AM</option>
							<option value="n">---</option>
							<option value="00" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "00") { echo 'selected="selected"';}} ?>>12</option>
							<option value="01" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "01") { echo 'selected="selected"';}} ?>>1</option>
							<option value="02" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "02") { echo 'selected="selected"';}} ?>>2</option>
							<option value="03" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "03") { echo 'selected="selected"';}} ?>>3</option>
							<option value="04" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "04") { echo 'selected="selected"';}} ?>>4</option>
							<option value="05" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "05") { echo 'selected="selected"';}} ?>>5</option>
							<option value="06" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "06") { echo 'selected="selected"';}} ?>>6</option>
							<option value="07" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "07") { echo 'selected="selected"';}} ?>>7</option>
							<option value="08" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "08") { echo 'selected="selected"';}} ?>>8</option>
							<option value="09" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "09") { echo 'selected="selected"';}} else {echo 'selected="selected"';} ?>>9</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "10") { echo 'selected="selected"';}} ?>>10</option>
							<option value="11" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "11") { echo 'selected="selected"';}} ?>>11</option>
							<option value="n"></option>
							<option value="n">PM</option>
							<option value="n">---</option>
							<option value="12" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "12") { echo 'selected="selected"';}} ?>>12</option>
							<option value="13" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "13") { echo 'selected="selected"';}} ?>>1</option>
							<option value="14" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "14") { echo 'selected="selected"';}} ?>>2</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "15") { echo 'selected="selected"';}} ?>>3</option>
							<option value="16" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "16") { echo 'selected="selected"';}} ?>>4</option>
							<option value="17" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "17") { echo 'selected="selected"';}} ?>>5</option>
							<option value="18" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "18") { echo 'selected="selected"';}} ?>>6</option>
							<option value="19" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "19") { echo 'selected="selected"';}} ?>>7</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "20") { echo 'selected="selected"';}} ?>>8</option>
							<option value="21" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "21") { echo 'selected="selected"';}} ?>>9</option>
							<option value="22" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "22") { echo 'selected="selected"';}} ?>>10</option>
							<option value="23" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "23") { echo 'selected="selected"';}} ?>>11</option>
						</select>
						:
						<select name="group_starttime2" id="group_starttime2" tabindex="12">
							<option value="00" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "00") { echo 'selected="selected"';}} else {echo 'selected="selected"';} ?>>00</option>
							<option value="05" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "05") { echo 'selected="selected"';}} ?>>05</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "10") { echo 'selected="selected"';}} ?>>10</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "15") { echo 'selected="selected"';}} ?>>15</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "20") { echo 'selected="selected"';}} ?>>20</option>
							<option value="25" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "25") { echo 'selected="selected"';}} ?>>25</option>
							<option value="30" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "30") { echo 'selected="selected"';}} ?>>30</option>
							<option value="35" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "35") { echo 'selected="selected"';}} ?>>35</option>
							<option value="40" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "40") { echo 'selected="selected"';}} ?>>40</option>
							<option value="45" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "45") { echo 'selected="selected"';}} ?>>45</option>
							<option value="50" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "50") { echo 'selected="selected"';}} ?>>50</option>
							<option value="55" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "55") { echo 'selected="selected"';}} ?>>55</option>
						</select>
						<span id="enmge_ampm1"><?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) >= 12) { echo 'pm';} else { echo 'am';}} else { echo 'am';} ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>End Time:</strong></th>
					<td>
						<select name="group_endtime1" id="group_endtime1" tabindex="13">
							<option value="n">AM</option>
							<option value="n">---</option>
							<option value="00" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "00") { echo 'selected="selected"';}} ?>>12</option>
							<option value="01" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "01") { echo 'selected="selected"';}} ?>>1</option>
							<option value="02" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "02") { echo 'selected="selected"';}} ?>>2</option>
							<option value="03" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "03") { echo 'selected="selected"';}} ?>>3</option>
							<option value="04" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "04") { echo 'selected="selected"';}} ?>>4</option>
							<option value="05" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "05") { echo 'selected="selected"';}} ?>>5</option>
							<option value="06" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "06") { echo 'selected="selected"';}} ?>>6</option>
							<option value="07" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "07") { echo 'selected="selected"';}} ?>>7</option>
							<option value="08" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "08") { echo 'selected="selected"';}} ?>>8</option>
							<option value="09" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "09") { echo 'selected="selected"';}} ?>>9</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "10") { echo 'selected="selected"';}} else {echo 'selected="selected"';} ?>>10</option>
							<option value="11" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "11") { echo 'selected="selected"';}} ?>>11</option>
							<option value="n"></option>
							<option value="n">PM</option>
							<option value="n">---</option>
							<option value="12" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "12") { echo 'selected="selected"';}} ?>>12</option>
							<option value="13" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "13") { echo 'selected="selected"';}} ?>>1</option>
							<option value="14" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "14") { echo 'selected="selected"';}} ?>>2</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "15") { echo 'selected="selected"';}} ?>>3</option>
							<option value="16" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "16") { echo 'selected="selected"';}} ?>>4</option>
							<option value="17" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "17") { echo 'selected="selected"';}} ?>>5</option>
							<option value="18" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "18") { echo 'selected="selected"';}} ?>>6</option>
							<option value="19" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "19") { echo 'selected="selected"';}} ?>>7</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "20") { echo 'selected="selected"';}} ?>>8</option>
							<option value="21" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "21") { echo 'selected="selected"';}} ?>>9</option>
							<option value="22" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "22") { echo 'selected="selected"';}} ?>>10</option>
							<option value="23" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "23") { echo 'selected="selected"';}} ?>>11</option>
						</select>
						:
						<select name="group_endtime2" id="group_endtime2" tabindex="14">
							<option value="00" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "00") { echo 'selected="selected"';}} else {echo 'selected="selected"';} ?>>00</option>
							<option value="05" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "05") { echo 'selected="selected"';}} ?>>05</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "10") { echo 'selected="selected"';}} ?>>10</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "15") { echo 'selected="selected"';}} ?>>15</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "20") { echo 'selected="selected"';}} ?>>20</option>
							<option value="25" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "25") { echo 'selected="selected"';}} ?>>25</option>
							<option value="30" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "30") { echo 'selected="selected"';}} ?>>30</option>
							<option value="35" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "35") { echo 'selected="selected"';}} ?>>35</option>
							<option value="40" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "40") { echo 'selected="selected"';}} ?>>40</option>
							<option value="45" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "45") { echo 'selected="selected"';}} ?>>45</option>
							<option value="50" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "50") { echo 'selected="selected"';}} ?>>50</option>
							<option value="55" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "55") { echo 'selected="selected"';}} ?>>55</option>
						</select>
						<span id="enmge_ampm2"><?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) >= 12) { echo 'pm';} else { echo 'am';}} else { echo 'am';} ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong><?php echo stripslashes($enmge_grouptitle); ?> Begins:</strong></th>
					<td><input id='group_begins' name='group_begins' type='text' value='<?php if ($_POST && !empty($enmge_errors)) {echo $_POST['group_begins'];} else { echo date("Y-m-d", time()); } ?>' tabindex="15" /> <span class="ge-form-instructions">ex: 2012-01-01</span></td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong><?php echo stripslashes($enmge_grouptitle); ?> Ends:</strong></th>
					<td><input name="group_noend" type="checkbox" id="group_noend" value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_noend'] == 1) { ?>checked="checked"<?php }} else { ?>checked="checked"<?php } ?> class="check" /> <label for="group_noend" class="endcheck"> This <?php echo $enmge_grouptitle; ?> is Ongoing</label><br />
						<input id='group_ends' name='group_ends' type='text' value='<?php if ($_POST && !empty($enmge_errors)) {echo $_POST['group_ends'];} else { echo (date("Y", time())+1) . date("-m-d", time()); } ?>' tabindex="16" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_noend'] == 1) { ?>disabled="disabled"<?php }} else { ?>disabled="disabled"<?php } ?> /> <span class="ge-form-instructions">ex: 2012-01-01</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo $enmge_childcarelabel; ?>:</th>
					<td>
						<select name="group_childcare" id="group_childcare" tabindex="17">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_childcare'] == 0) { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_childcare'] == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Childcare Details:</strong></th>
					<td><input id='group_childcare_details' name='group_childcare_details' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_childcare_details']);} ?>" tabindex="18" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Privacy:</th>
					<td>
						<select name="group_privacy" id="group_privacy" tabindex="19">
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_privacy'] == 1) { ?>selected="selected"<?php }} ?>>Public</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_privacy'] == 0) { ?>selected="selected"<?php }} ?>>Hidden</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="enmge-details-area" style="display: none">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Belongs to <?php echo stripslashes($enmge_locationtitle); ?>:<p class="ge-form-instructions">Even if it meets offsite, select a "home" <?php echo stripslashes($enmge_locationtitle); ?> for this <?php echo stripslashes($enmge_grouptitle); ?>.</p></th>
					<td>
						<?php if ( !empty($enmge_gt) ) { ?>
						<ul id="enmge-locationlist" class="enmge-location">
						<?php foreach ($enmge_locations as $l) {  ?>
							<?php if ( $_POST && !empty($enmge_errors) ) { ?>
							<li><input name="locations[]" type="checkbox" value="<?php echo $l->location_id; ?>" <?php if ($_POST['locations'] != NULL) {foreach ($_POST['locations'] as $pl) { if ($pl == $l->location_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="locations[]"> <?php echo stripslashes($l->location_name); ?></label></li>
							<?php } else { ?>
							<li><input name="locations[]" type="checkbox" value="<?php echo $l->location_id; ?>" class="check" /> <label for="locations[]"> <?php echo stripslashes($l->location_name); ?></label></li>	
							<?php } ?>
						<?php }; ?>
						</ul>
						<?php } else { echo '<p>Add a ' . $enmge_locationtitle . ' in the "Edit ' . $enmge_locationptitle . '" menu.</p>'; } ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo stripslashes($enmge_grouptypetitle); ?>:<p class="ge-form-instructions">Select multiple if needed. How will your users search for this <?php echo stripslashes($enmge_grouptitle); ?>?</p></th>
					<td>
						<input id='group_type_name' name='group_type_name' type='text' value='' tabindex="20" />
						<a href="#" id="addnewgrouptype" class="button">Add New <?php echo stripslashes($enmge_grouptypetitle); ?></a>
						<?php if ( !empty($enmge_gt) ) { ?>
						<ul id="enmge-grouptypelist" class="enmge-group-type">
						<?php foreach ($enmge_gt as $gt) {  ?>
							<?php if ( $_POST && !empty($enmge_errors) ) { ?>
							<li><input name="grouptypes[]" type="checkbox" value="<?php echo $gt->group_type_id; ?>" <?php if ($_POST['grouptypes'] != NULL) {foreach ($_POST['grouptypes'] as $pgt) { if ($pgt == $gt->group_type_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="grouptypes[]"> <?php echo stripslashes($gt->group_type_title); ?></label></li>
							<?php } else { ?>
							<li><input name="grouptypes[]" type="checkbox" value="<?php echo $gt->group_type_id; ?>" class="check" /> <label for="grouptypes[]"> <?php echo stripslashes($gt->group_type_title); ?></label></li>	
							<?php } ?>
						<?php }; ?>
						</ul>
						<?php } else { echo '<p>Add a ' . $enmge_grouptype . ' above or in the "Edit ' . $enmge_grouptypeptitle . '" menu.</p>'; } ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Associate with <?php echo stripslashes($enmge_topictitle); ?>:<p class="ge-form-instructions">Add as many as you like.</p></th>
					<td>
						<input id='topic_name' name='topic_name' type='text' value='' tabindex="21" />
						<a href="#" id="addnewtopic" class="button">Add New <?php echo stripslashes($enmge_topictitle); ?></a>
						<?php if ( !empty($enmge_t) ) { ?>
						<ul id="enmge-topiclist" class="enmge-group-topic">
						<?php foreach ($enmge_t as $t) {  ?>
							<?php if ( $_POST && !empty($enmge_errors) ) { ?>
							<li><input name="topics[]" type="checkbox" value="<?php echo $t->topic_id; ?>" <?php if ($_POST['topics'] != NULL) {foreach ($_POST['topics'] as $pt) { if ($pt == $t->topic_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="topics[]"> <?php echo stripslashes($t->topic_name); ?></label></li>
							<?php } else { ?>
							<li><input name="topics[]" type="checkbox" value="<?php echo $t->topic_id; ?>" class="check" /> <label for="topics[]"> <?php echo stripslashes($t->topic_name); ?></label></li>	
							<?php } ?>
						<?php }; ?>
						</ul>
						<?php } else { echo '<p>Add a ' . $enmge_topictitle . ' above or in the "Edit ' . $enmge_topicptitle . '" menu.</p>'; } ?>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="enmge-location-area" style="display: none">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Location Label:</th>
					<td><input id='group_location_label' name='group_location_label' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_location_label']);} ?>" tabindex="22" /> <span class="ge-form-instructions">ex: Room 46, Downtown Starbucks, etc</span></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo stripslashes($enmge_grouptitle); ?> Meets At...<p class="ge-form-instructions">Does it meet at one of your <?php echo stripslashes($enmge_locationptitle); ?>, or somewhere else in the community?</p></th>
					<td>
						<select name="group_onsite" id="group_onsite" tabindex="23">
							<option value="n" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_onsite'] == "n") { echo 'selected="selected"';}} ?>>- Choose -</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_onsite'] == "0") { echo 'selected="selected"';}} ?>>Offsite</option>
							<?php foreach ( $enmge_locations as $enmge_location ) { ?>
							<option value="<?php echo $enmge_location->location_id ?>" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_onsite'] == $enmge_location->location_id) { echo 'selected="selected"';}} ?>><?php echo $enmge_location->location_name; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
			</table>
			<table class="form-table" id="enmgeaddressinfo" <?php if ( $_POST && !empty($enmge_errors) ) {if ($_POST['group_onsite'] == "0") { ?><?php } else { ?>style="display: none;"<?php }} else { ?>style="display: none;"<?php } ?>>
				<tr valign="top">
					<th scope="row">Address:<p class="ge-form-instructions">Consider street names without numbers, or even just city or postal code if your leader prefers more privacy.</p></th>
					<td><input id='group_address1' name='group_address1' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_address1']);} ?>" tabindex="24" /><br /><input id='group_address2' name='group_address2' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_address2']);} ?>" tabindex="25" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">City:</th>
					<td><input id='group_city' name='group_city' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_city']);} ?>" tabindex="26" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">State/Province:</th>
					<td><input id='group_state' name='group_state' type='text' size="3" value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_state']);} ?>" tabindex="27" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Postal Code:</th>
					<td><input id='group_zip' name='group_zip' type='text' size="5" value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_zip']);} ?>" tabindex="28" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Make Address Public?: <p class="ge-form-instructions">A pin will be displayed on the map, but the address will not be publicly shared.</p></th>
					<td>
						<select name="group_location_privacy" id="group_location_privacy" tabindex="29">
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_location_privacy'] == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_location_privacy'] == 0) { ?>selected="selected"<?php }} ?>>No</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Manually Edit Lat/Long?: <p class="ge-form-instructions">Overwrite the coordinates generated by the address above.</p></th>
					<td>
						<select name="group_manedit" id="group_manedit" tabindex="30">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_manedit'] == 0) { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_manedit'] == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_manedit'] == 0) { ?>style="display: none"<?php }} else { ?>style="display: none"<?php } ?> id="latrow">
					<th scope="row">Latitude:</th>
					<td><input id='group_lat' name='group_lat' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_lat']);} ?>" tabindex="31" /></td>
				</tr>
				<tr valign="top" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_manedit'] == 0) { ?>style="display: none"<?php }} else { ?>style="display: none"<?php } ?> id="longrow">
					<th scope="row">Longitude:</th>
					<td><input id='group_long' name='group_long' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_long']);} ?>" tabindex="32" /></td>
				</tr>
			</table>
		</div>
		
		<div id="enmge-related-files" style="display: none">
				<p>The items you provide below will appear on the <?php echo stripslashes($enmge_grouptitle); ?> details view in the "Related" section above the <?php echo stripslashes($enmge_grouptitle); ?> map.</p>
				
				<div id="enmgefileform">
					<h3>Attach a Link or Download</h3>		
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Name:</th>
							<td><input id='file_name' name='file_name' type='text' value="" tabindex="30" /></td>
						</tr>
						<tr valign="top">
							<th scope="row">Link/File URL:</th>
							<td><input id='file_url' name='file_url' type='text' value='' tabindex="31" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;TB_iframe=1', __FILE__ ); ?>" class="enmge-upload-group-file ge-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="ge-media-button" /> &nbsp;Upload File</a></td>
						</tr>
					</table>
					<br />
					<input type="hidden" name="file_username" value="<?php echo $enmge_userdetails->user_login; ?>" id="file_username" />
			
					<a href="#" id="addnewfile" class="button">Attach New Link/Download</a>
				</div>
				<br />
				<br />
				<div id="enmgefilearea">
					<?php if ( !empty($enmge_files) ) { ?>
						<script type="text/javascript">
						jQuery(document).ready(function(){
							var fixHelper = function(e, ui) {
								ui.children().each(function() {
									jQuery(this).width(jQuery(this).width());
								});
								return ui;
							};
							jQuery("#filestable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
								var order = jQuery(this).sortable("serialize"); 
								jQuery.ajax({
									method: "POST",
							        url: geajax.ajaxurl, 
							        data: {
							            'action': 'groupsengine_ajaxsortfiles',
							            'frow': order
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
					<h3>Links and Downloads Currently Associated with This <?php echo stripslashes($enmge_grouptitle); ?>...</h3>
					<table class="widefat" id="filestable"> 
						<thead> 
							<tr> 
								<th>Sort</th> 
								<th>Name</th> 
								<th>URL</th>
								<th>Delete?</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($enmge_files as $file) {  ?>
							<tr id="row_<?php echo $file->file_id; ?>">
								<td class="enmge-sort"></td>
								<td><a href="#" class="groupsengine_editfile" name="<?php echo $file->file_id; ?>"><?php echo $file->file_name; ?></a></td>
								<td><a href="<?php echo $file->file_url; ?>" target="_blank"><?php echo $file->file_url; ?></a></td>
								<td class="enmge-delete"><a href="#" class="groupsengine_filedelete" name="<?php echo $file->file_id; ?>">Delete</a></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
					<?php } ?>
				</div>
				<br />
				<br />
				<br />
				<br />
			</div>
			
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add New <?php echo stripslashes($enmge_grouptitle); ?>" tabindex="32" /></p>
		<input type="hidden" name="enmgeleaderurl" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/newleader.php" id="enmgeleaderurl" />
		<input type="hidden" name="enmgeleaderdelete" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/leaderdelete.php" id="enmgeleaderdelete" />
		<input type="hidden" name="enmgepluginurl" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/newtopiclist.php" id="enmgepluginurl" />
		<input type="hidden" name="enmgepluginurl2" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/newgrouptypelist.php" id="enmgepluginurl2" />
		<input type="hidden" name="enmgefileurl" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/newfile.php" id="enmgefileurl" />
		<input type="hidden" name="enmgefiledelete" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/filedelete.php" id="enmgefiledelete" />
		<input type="hidden" name="enmgefileedit" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/fileedit.php" id="enmgefileedit" />
		<input type="hidden" name="enmgeimage" value="<?php echo $enmge_imagewidth; ?>" id="enmgeimage" />
		<input type="hidden" name="xxge" value="<?php echo base64_encode(ABSPATH); ?>" id="xxge" />
		</form>		
		

		<p><a href="<?php if ( isset($_GET['enmge_p']) ) { if ( isset($_GET['enmge_gtid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_gtid=' . $enmge_gtid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_tid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_tid=' . $enmge_tid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_lid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_lid=' . $enmge_lid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_day']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_day . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ );} } else { if ( isset($_GET['enmge_gtid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_gtid=' . $enmge_gtid, __FILE__ ); } elseif ( isset($_GET['enmge_tid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_tid=' . $enmge_tid, __FILE__ ); } elseif ( isset($_GET['enmge_lid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_lid=' . $enmge_lid, __FILE__ ); } elseif ( isset($_GET['enmge_day']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_day, __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php', __FILE__ ); }} ?>">&laquo; All <?php echo stripslashes($enmge_groupptitle); ?></a></p>
		<?php include ('gecredits.php'); ?>
<?php } elseif ( ($_GET['enmge_action'] == 'edit') && ( $enmge_singlecount == 1 ) ) { // Edit Group ?>
	<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/datepicker.js'; ?>" ></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#group_begins").datepicker({ dateFormat: 'yy-mm-dd' });
			jQuery("#group_ends").datepicker({ dateFormat: 'yy-mm-dd' });
			jQuery("#group_starttime1").on("change", function() {
				var hourval = jQuery(this).val();
				if (hourval == "n") {
					alert('Please select a valid hour');
				};
				if (hourval >= 12) {
					jQuery("#enmge_ampm1").html('pm');
				} else {
					jQuery("#enmge_ampm1").html('am');
				};
			});
			jQuery("#group_endtime1").on("change", function() {
				var hourval = jQuery(this).val();
				if (hourval == "n") {
					alert('Please select a valid hour');
				};
				if (hourval >= 12) {
					jQuery("#enmge_ampm2").html('pm');
				} else {
					jQuery("#enmge_ampm2").html('am');
				};
			});
			jQuery("#group_onsite").on("change", function() {
				var onsiteval = jQuery(this).val();
				if (onsiteval == 0) {
					jQuery("#enmgeaddressinfo").show();
				} else {
					jQuery("#enmgeaddressinfo").hide();
				};
			});
			jQuery("#group_manedit").on("change", function() {
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
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/group_options130.js'; ?>"></script>
	<h2 class="enmge">Edit <?php echo stripslashes($enmge_grouptitle); ?> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&enmge_duplicate=1&amp;enmge_gid=' . $_GET['enmge_gid'], __FILE__ ) ?>" class="add-new-h2">Duplicate</a> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>Modify the information below to change how this <?php echo stripslashes($enmge_grouptitle); ?> appears in the Groups Engine browser. Be sure to select the appropriate <?php echo stripslashes($enmge_grouptypetitle); ?> and <?php echo $enmge_locationtitle; ?> under the "<?php echo stripslashes($enmge_grouptitle); ?> Details" section.  Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-groups"; ?>">User Guide</a>.</p>
	<?php //print_r($enmge_g_data); ?>
	<ul id="enmge-group-options">
		<li class="selected"><a href="#" id="enmge-group-general">General Information</a></li>
		<li><a href="#" id="enmge-group-details"><?php echo stripslashes($enmge_grouptitle); ?> Details</a></li>
		<li><a href="#" id="enmge-group-location">Location</a></li>
		<li><a href="#" id="enmge-group-files">Attach Links/Downloads</a></li>
	</ul>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Status:</th>
					<td>
						<select name="group_status" id="group_status" tabindex="1">
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_status'] == 1) { ?>selected="selected"<?php }} else {if ($enmge_single->group_status == 1) { ?>selected="selected"<?php }} ?>>Open</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_status'] == 0) { ?>selected="selected"<?php }} else {if ($enmge_single->group_status == 0) { ?>selected="selected"<?php }} ?>>Closed</option>
							<option value="2" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_status'] == 2) { ?>selected="selected"<?php }} else {if ($enmge_single->group_status == 2) { ?>selected="selected"<?php }} ?>>Full</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Title:</strong></th>
					<td><input id='group_title' name='group_title' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_title']);} else {echo stripslashes($enmge_single->group_title);} ?>" tabindex="2" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Description:
						<p class="ge-form-instructions">A brief description of the <?php echo stripslashes($enmge_grouptitle); ?>.</p>
					</th>
					<td>
						<textarea name="group_description" id="group_description" rows="4" cols="40" tabindex="3"><?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_description']);} else {echo stripslashes($enmge_single->group_description);} ?></textarea><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Photo:</strong></th>
					<td><input id='group_photo' name='group_photo' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_photo']);} else {echo stripslashes($enmge_single->group_photo);} ?>" tabindex="4" />  &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;type=image&#038;TB_iframe=1', __FILE__ ); ?>" class="enmge-upload-image ge-upload-link" id="content-add_media" title="Add Image" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="ge-media-button" /> &nbsp;Upload Image</a><div id="group-image-load"><?php if ($_POST && !empty($enmge_errors) && !empty($_POST['group_photo'])) { ?><br /><img src="<?php echo $_POST['group_photo']; ?>" /><?php } elseif ( $enmge_single->group_photo != NULL ) { ?><br /><img src="<?php echo $enmge_single->group_photo; ?>" /><?php }; ?></div></td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Age Range:</strong></th>
					<td>
						<select name="group_startage" id="group_startage" tabindex="5">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 0) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 0) {echo 'selected="selected"';}} ?>>0</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 1) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 1) {echo 'selected="selected"';}} ?>>1</option>
							<option value="2" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 2) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 2) {echo 'selected="selected"';}} ?>>2</option>
							<option value="3" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 3) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 3) {echo 'selected="selected"';}} ?>>3</option>
							<option value="4" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 4) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 4) {echo 'selected="selected"';}} ?>>4</option>
							<option value="5" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 5) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 5) {echo 'selected="selected"';}} ?>>5</option>
							<option value="6" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 6) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 6) {echo 'selected="selected"';}} ?>>6</option>
							<option value="7" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 7) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 7) {echo 'selected="selected"';}} ?>>7</option>
							<option value="8" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 8) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 8) {echo 'selected="selected"';}} ?>>8</option>
							<option value="9" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 9) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 9) {echo 'selected="selected"';}} ?>>9</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 10) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 10) {echo 'selected="selected"';}} ?>>10</option>
							<option value="11" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 11) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 11) {echo 'selected="selected"';}} ?>>11</option>
							<option value="12" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 12) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 12) {echo 'selected="selected"';}} ?>>12</option>
							<option value="13" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 13) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 13) {echo 'selected="selected"';}} ?>>13</option>
							<option value="14" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 14) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 14) {echo 'selected="selected"';}} ?>>14</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 15) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 15) {echo 'selected="selected"';}} ?>>15</option>
							<option value="16" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 16) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 16) {echo 'selected="selected"';}} ?>>16</option>
							<option value="17" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 17) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 17) {echo 'selected="selected"';}} ?>>17</option>
							<option value="18" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 18) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 18) {echo 'selected="selected"';}} ?>>18</option>
							<option value="19" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 19) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 19) {echo 'selected="selected"';}} ?>>19</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 20) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 20) {echo 'selected="selected"';}} ?>>20</option>
							<option value="21" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 21) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 21) {echo 'selected="selected"';}} ?>>21</option>
							<option value="22" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 22) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 22) {echo 'selected="selected"';}} ?>>22</option>
							<option value="23" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 23) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 23) {echo 'selected="selected"';}} ?>>23</option>
							<option value="24" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 24) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 24) {echo 'selected="selected"';}} ?>>24</option>
							<option value="25" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 25) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 25) {echo 'selected="selected"';}} ?>>25</option>
							<option value="26" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 26) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 26) {echo 'selected="selected"';}} ?>>26</option>
							<option value="27" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 27) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 27) {echo 'selected="selected"';}} ?>>27</option>
							<option value="28" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 28) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 28) {echo 'selected="selected"';}} ?>>28</option>
							<option value="29" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 29) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 29) {echo 'selected="selected"';}} ?>>29</option>
							<option value="30" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 30) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 30) {echo 'selected="selected"';}} ?>>30</option>
							<option value="31" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 31) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 31) {echo 'selected="selected"';}} ?>>31</option>
							<option value="32" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 32) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 32) {echo 'selected="selected"';}} ?>>32</option>
							<option value="33" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 33) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 33) {echo 'selected="selected"';}} ?>>33</option>
							<option value="34" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 34) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 34) {echo 'selected="selected"';}} ?>>34</option>
							<option value="35" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 35) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 35) {echo 'selected="selected"';}} ?>>35</option>
							<option value="36" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 36) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 36) {echo 'selected="selected"';}} ?>>36</option>
							<option value="37" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 37) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 37) {echo 'selected="selected"';}} ?>>37</option>
							<option value="38" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 38) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 38) {echo 'selected="selected"';}} ?>>38</option>
							<option value="39" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 39) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 39) {echo 'selected="selected"';}} ?>>39</option>
							<option value="40" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 40) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 40) {echo 'selected="selected"';}} ?>>40</option>
							<option value="41" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 41) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 41) {echo 'selected="selected"';}} ?>>41</option>
							<option value="42" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 42) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 42) {echo 'selected="selected"';}} ?>>42</option>
							<option value="43" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 43) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 43) {echo 'selected="selected"';}} ?>>43</option>
							<option value="44" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 44) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 44) {echo 'selected="selected"';}} ?>>44</option>
							<option value="45" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 45) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 45) {echo 'selected="selected"';}} ?>>45</option>
							<option value="46" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 46) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 46) {echo 'selected="selected"';}} ?>>46</option>
							<option value="47" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 47) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 47) {echo 'selected="selected"';}} ?>>47</option>
							<option value="48" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 48) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 48) {echo 'selected="selected"';}} ?>>48</option>
							<option value="49" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 49) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 49) {echo 'selected="selected"';}} ?>>49</option>
							<option value="50" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 50) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 50) {echo 'selected="selected"';}} ?>>50</option>
							<option value="51" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 51) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 51) {echo 'selected="selected"';}} ?>>51</option>
							<option value="52" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 52) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 52) {echo 'selected="selected"';}} ?>>52</option>
							<option value="53" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 53) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 53) {echo 'selected="selected"';}} ?>>53</option>
							<option value="54" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 54) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 54) {echo 'selected="selected"';}} ?>>54</option>
							<option value="55" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 55) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 55) {echo 'selected="selected"';}} ?>>55</option>
							<option value="56" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 56) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 56) {echo 'selected="selected"';}} ?>>56</option>
							<option value="57" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 57) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 57) {echo 'selected="selected"';}} ?>>57</option>
							<option value="58" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 58) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 58) {echo 'selected="selected"';}} ?>>58</option>
							<option value="59" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 59) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 59) {echo 'selected="selected"';}} ?>>59</option>
							<option value="60" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 60) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 60) {echo 'selected="selected"';}} ?>>60</option>
							<option value="61" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 61) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 61) {echo 'selected="selected"';}} ?>>61</option>
							<option value="62" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 62) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 62) {echo 'selected="selected"';}} ?>>62</option>
							<option value="63" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 63) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 63) {echo 'selected="selected"';}} ?>>63</option>
							<option value="64" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 64) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 64) {echo 'selected="selected"';}} ?>>64</option>
							<option value="65" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 65) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 65) {echo 'selected="selected"';}} ?>>65</option>
							<option value="66" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 66) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 66) {echo 'selected="selected"';}} ?>>66</option>
							<option value="67" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 67) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 67) {echo 'selected="selected"';}} ?>>67</option>
							<option value="68" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 68) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 68) {echo 'selected="selected"';}} ?>>68</option>
							<option value="69" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 69) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 69) {echo 'selected="selected"';}} ?>>69</option>
							<option value="70" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 70) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 70) {echo 'selected="selected"';}} ?>>70</option>
							<option value="71" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 71) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 71) {echo 'selected="selected"';}} ?>>71</option>
							<option value="72" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 72) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 72) {echo 'selected="selected"';}} ?>>72</option>
							<option value="73" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 73) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 73) {echo 'selected="selected"';}} ?>>73</option>
							<option value="74" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 74) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 74) {echo 'selected="selected"';}} ?>>74</option>
							<option value="75" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 75) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 75) {echo 'selected="selected"';}} ?>>75</option>
							<option value="76" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 76) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 76) {echo 'selected="selected"';}} ?>>76</option>
							<option value="77" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 77) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 77) {echo 'selected="selected"';}} ?>>77</option>
							<option value="78" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 78) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 78) {echo 'selected="selected"';}} ?>>78</option>
							<option value="79" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 79) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 79) {echo 'selected="selected"';}} ?>>79</option>
							<option value="80" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 80) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 80) {echo 'selected="selected"';}} ?>>80</option>
							<option value="81" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 81) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 81) {echo 'selected="selected"';}} ?>>81</option>
							<option value="82" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 82) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 82) {echo 'selected="selected"';}} ?>>82</option>
							<option value="83" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 83) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 83) {echo 'selected="selected"';}} ?>>83</option>
							<option value="84" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 84) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 84) {echo 'selected="selected"';}} ?>>84</option>
							<option value="85" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 85) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 85) {echo 'selected="selected"';}} ?>>85</option>
							<option value="86" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 86) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 86) {echo 'selected="selected"';}} ?>>86</option>
							<option value="87" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 87) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 87) {echo 'selected="selected"';}} ?>>87</option>
							<option value="88" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 88) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 88) {echo 'selected="selected"';}} ?>>88</option>
							<option value="89" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 89) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 89) {echo 'selected="selected"';}} ?>>89</option>
							<option value="90" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 90) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 90) {echo 'selected="selected"';}} ?>>90</option>
							<option value="91" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 91) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 91) {echo 'selected="selected"';}} ?>>91</option>
							<option value="92" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 92) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 92) {echo 'selected="selected"';}} ?>>92</option>
							<option value="93" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 93) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 93) {echo 'selected="selected"';}} ?>>93</option>
							<option value="94" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 94) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 94) {echo 'selected="selected"';}} ?>>94</option>
							<option value="95" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 95) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 95) {echo 'selected="selected"';}} ?>>95</option>
							<option value="96" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 96) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 96) {echo 'selected="selected"';}} ?>>96</option>
							<option value="97" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 97) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 97) {echo 'selected="selected"';}} ?>>97</option>
							<option value="98" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 98) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 98) {echo 'selected="selected"';}} ?>>98</option>
							<option value="99" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_startage'] == 99) { echo 'selected="selected"';}} else {if ($enmge_single->group_startage == 99) {echo 'selected="selected"';}} ?>>99</option>
						</select> - 
						<select name="group_endage" id="group_endage" tabindex="6">
							<option value="100" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 100) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 100) {echo 'selected="selected"';}} ?>>Any</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 0) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 0) {echo 'selected="selected"';}} ?>>0</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 1) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 1) {echo 'selected="selected"';}} ?>>1</option>
							<option value="2" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 2) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 2) {echo 'selected="selected"';}} ?>>2</option>
							<option value="3" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 3) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 3) {echo 'selected="selected"';}} ?>>3</option>
							<option value="4" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 4) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 4) {echo 'selected="selected"';}} ?>>4</option>
							<option value="5" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 5) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 5) {echo 'selected="selected"';}} ?>>5</option>
							<option value="6" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 6) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 6) {echo 'selected="selected"';}} ?>>6</option>
							<option value="7" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 7) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 7) {echo 'selected="selected"';}} ?>>7</option>
							<option value="8" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 8) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 8) {echo 'selected="selected"';}} ?>>8</option>
							<option value="9" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 9) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 9) {echo 'selected="selected"';}} ?>>9</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 10) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 10) {echo 'selected="selected"';}} ?>>10</option>
							<option value="11" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 11) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 11) {echo 'selected="selected"';}} ?>>11</option>
							<option value="12" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 12) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 12) {echo 'selected="selected"';}} ?>>12</option>
							<option value="13" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 13) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 13) {echo 'selected="selected"';}} ?>>13</option>
							<option value="14" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 14) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 14) {echo 'selected="selected"';}} ?>>14</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 15) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 15) {echo 'selected="selected"';}} ?>>15</option>
							<option value="16" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 16) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 16) {echo 'selected="selected"';}} ?>>16</option>
							<option value="17" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 17) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 17) {echo 'selected="selected"';}} ?>>17</option>
							<option value="18" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 18) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 18) {echo 'selected="selected"';}} ?>>18</option>
							<option value="19" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 19) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 19) {echo 'selected="selected"';}} ?>>19</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 20) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 20) {echo 'selected="selected"';}} ?>>20</option>
							<option value="21" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 21) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 21) {echo 'selected="selected"';}} ?>>21</option>
							<option value="22" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 22) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 22) {echo 'selected="selected"';}} ?>>22</option>
							<option value="23" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 23) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 23) {echo 'selected="selected"';}} ?>>23</option>
							<option value="24" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 24) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 24) {echo 'selected="selected"';}} ?>>24</option>
							<option value="25" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 25) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 25) {echo 'selected="selected"';}} ?>>25</option>
							<option value="26" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 26) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 26) {echo 'selected="selected"';}} ?>>26</option>
							<option value="27" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 27) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 27) {echo 'selected="selected"';}} ?>>27</option>
							<option value="28" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 28) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 28) {echo 'selected="selected"';}} ?>>28</option>
							<option value="29" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 29) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 29) {echo 'selected="selected"';}} ?>>29</option>
							<option value="30" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 30) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 30) {echo 'selected="selected"';}} ?>>30</option>
							<option value="31" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 31) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 31) {echo 'selected="selected"';}} ?>>31</option>
							<option value="32" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 32) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 32) {echo 'selected="selected"';}} ?>>32</option>
							<option value="33" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 33) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 33) {echo 'selected="selected"';}} ?>>33</option>
							<option value="34" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 34) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 34) {echo 'selected="selected"';}} ?>>34</option>
							<option value="35" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 35) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 35) {echo 'selected="selected"';}} ?>>35</option>
							<option value="36" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 36) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 36) {echo 'selected="selected"';}} ?>>36</option>
							<option value="37" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 37) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 37) {echo 'selected="selected"';}} ?>>37</option>
							<option value="38" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 38) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 38) {echo 'selected="selected"';}} ?>>38</option>
							<option value="39" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 39) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 39) {echo 'selected="selected"';}} ?>>39</option>
							<option value="40" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 40) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 40) {echo 'selected="selected"';}} ?>>40</option>
							<option value="41" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 41) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 41) {echo 'selected="selected"';}} ?>>41</option>
							<option value="42" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 42) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 42) {echo 'selected="selected"';}} ?>>42</option>
							<option value="43" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 43) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 43) {echo 'selected="selected"';}} ?>>43</option>
							<option value="44" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 44) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 44) {echo 'selected="selected"';}} ?>>44</option>
							<option value="45" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 45) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 45) {echo 'selected="selected"';}} ?>>45</option>
							<option value="46" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 46) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 46) {echo 'selected="selected"';}} ?>>46</option>
							<option value="47" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 47) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 47) {echo 'selected="selected"';}} ?>>47</option>
							<option value="48" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 48) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 48) {echo 'selected="selected"';}} ?>>48</option>
							<option value="49" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 49) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 49) {echo 'selected="selected"';}} ?>>49</option>
							<option value="50" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 50) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 50) {echo 'selected="selected"';}} ?>>50</option>
							<option value="51" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 51) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 51) {echo 'selected="selected"';}} ?>>51</option>
							<option value="52" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 52) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 52) {echo 'selected="selected"';}} ?>>52</option>
							<option value="53" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 53) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 53) {echo 'selected="selected"';}} ?>>53</option>
							<option value="54" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 54) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 54) {echo 'selected="selected"';}} ?>>54</option>
							<option value="55" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 55) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 55) {echo 'selected="selected"';}} ?>>55</option>
							<option value="56" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 56) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 56) {echo 'selected="selected"';}} ?>>56</option>
							<option value="57" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 57) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 57) {echo 'selected="selected"';}} ?>>57</option>
							<option value="58" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 58) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 58) {echo 'selected="selected"';}} ?>>58</option>
							<option value="59" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 59) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 59) {echo 'selected="selected"';}} ?>>59</option>
							<option value="60" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 60) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 60) {echo 'selected="selected"';}} ?>>60</option>
							<option value="61" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 61) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 61) {echo 'selected="selected"';}} ?>>61</option>
							<option value="62" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 62) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 62) {echo 'selected="selected"';}} ?>>62</option>
							<option value="63" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 63) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 63) {echo 'selected="selected"';}} ?>>63</option>
							<option value="64" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 64) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 64) {echo 'selected="selected"';}} ?>>64</option>
							<option value="65" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 65) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 65) {echo 'selected="selected"';}} ?>>65</option>
							<option value="66" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 66) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 66) {echo 'selected="selected"';}} ?>>66</option>
							<option value="67" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 67) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 67) {echo 'selected="selected"';}} ?>>67</option>
							<option value="68" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 68) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 68) {echo 'selected="selected"';}} ?>>68</option>
							<option value="69" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 69) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 69) {echo 'selected="selected"';}} ?>>69</option>
							<option value="70" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 70) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 70) {echo 'selected="selected"';}} ?>>70</option>
							<option value="71" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 71) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 71) {echo 'selected="selected"';}} ?>>71</option>
							<option value="72" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 72) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 72) {echo 'selected="selected"';}} ?>>72</option>
							<option value="73" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 73) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 73) {echo 'selected="selected"';}} ?>>73</option>
							<option value="74" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 74) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 74) {echo 'selected="selected"';}} ?>>74</option>
							<option value="75" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 75) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 75) {echo 'selected="selected"';}} ?>>75</option>
							<option value="76" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 76) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 76) {echo 'selected="selected"';}} ?>>76</option>
							<option value="77" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 77) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 77) {echo 'selected="selected"';}} ?>>77</option>
							<option value="78" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 78) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 78) {echo 'selected="selected"';}} ?>>78</option>
							<option value="79" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 79) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 79) {echo 'selected="selected"';}} ?>>79</option>
							<option value="80" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 80) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 80) {echo 'selected="selected"';}} ?>>80</option>
							<option value="81" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 81) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 81) {echo 'selected="selected"';}} ?>>81</option>
							<option value="82" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 82) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 82) {echo 'selected="selected"';}} ?>>82</option>
							<option value="83" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 83) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 83) {echo 'selected="selected"';}} ?>>83</option>
							<option value="84" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 84) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 84) {echo 'selected="selected"';}} ?>>84</option>
							<option value="85" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 85) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 85) {echo 'selected="selected"';}} ?>>85</option>
							<option value="86" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 86) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 86) {echo 'selected="selected"';}} ?>>86</option>
							<option value="87" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 87) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 87) {echo 'selected="selected"';}} ?>>87</option>
							<option value="88" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 88) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 88) {echo 'selected="selected"';}} ?>>88</option>
							<option value="89" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 89) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 89) {echo 'selected="selected"';}} ?>>89</option>
							<option value="90" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 90) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 90) {echo 'selected="selected"';}} ?>>90</option>
							<option value="91" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 91) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 91) {echo 'selected="selected"';}} ?>>91</option>
							<option value="92" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 92) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 92) {echo 'selected="selected"';}} ?>>92</option>
							<option value="93" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 93) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 93) {echo 'selected="selected"';}} ?>>93</option>
							<option value="94" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 94) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 94) {echo 'selected="selected"';}} ?>>94</option>
							<option value="95" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 95) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 95) {echo 'selected="selected"';}} ?>>95</option>
							<option value="96" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 96) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 96) {echo 'selected="selected"';}} ?>>96</option>
							<option value="97" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 97) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 97) {echo 'selected="selected"';}} ?>>97</option>
							<option value="98" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 98) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 98) {echo 'selected="selected"';}} ?>>98</option>
							<option value="99" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_endage'] == 99) { echo 'selected="selected"';}} else {if ($enmge_single->group_endage == 99) {echo 'selected="selected"';}} ?>>99</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Add Leader(s):</strong></th>
					<td>
						<div id="leader_list">
							<?php if ( !empty($enmge_leaders) ) { ?>
							<table cellpadding="0" cellspacing="0" class="leadertable"> 
							<?php foreach ($enmge_leaders as $leader) {  ?>
								<tr id="lrow_<?php echo $leader->leader_id; ?>">
									<td><?php echo $leader->leader_name; ?></td>
									<td>(<em><?php echo $leader->leader_email; ?></em>)</td>
									<td class="enmge-delete"><a href="#" class="groupsengine_leaderdelete" name="<?php echo $leader->leader_id; ?>">(X)</a></td>				
								</tr>
							<?php } ?>
							</table>
							<?php } ?>
						</div>
						<div id="newleadersection">
							<input id='leader_name' name='leader_name' size='10' type='text' style="color: #cbcbcb" value='Name' />
							<input id='leader_email' name='leader_email' size='15' type='text' style="color: #cbcbcb" value='Email' />
							<a href="#" id="addnewleader" class="button">Add Leader</a>
						</div>
						<input type="hidden" name="leader_username" value="<?php echo $enmge_userdetails->user_login; ?>" id="leader_username" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Day of Week:</th>
					<td>
						<select name="group_frequency" id="group_frequency" tabindex="9">
							<option value="Every" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every") {echo 'selected="selected"';}} ?>>Every</option>
							<option value="Every other" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every other") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every other") {echo 'selected="selected"';}} ?>>Every other</option>
							<option value="Regularly on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Regularly on") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Regularly on") {echo 'selected="selected"';}} ?>>Regularly on</option>
							<option value="Every 1st Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 1st Week on") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every 1st Week on") {echo 'selected="selected"';}} ?>>Every 1st Week on</option>
							<option value="Every 2nd Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 2nd Week on") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every 2nd Week on") {echo 'selected="selected"';}} ?>>Every 2nd Week on</option>
							<option value="Every 3rd Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 3rd Week on") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every 3rd Week on") {echo 'selected="selected"';}} ?>>Every 3rd Week on</option>
							<option value="Every 4th Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 4th Week on") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every 4th Week on") {echo 'selected="selected"';}} ?>>Every 4th Week on</option>
							<option value="Every 5th Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 5th Week on") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every 5th Week on") {echo 'selected="selected"';}} ?>>Every 5th Week on</option>
							<option value="Every 1st and 3rd Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 1st and 3rd Week on") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every 1st and 3rd Week on") {echo 'selected="selected"';}} ?>>Every 1st and 3rd Week on</option>
							<option value="Every 2nd and 4th Week on" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_frequency'] == "Every 2nd and 4th Week on") { echo 'selected="selected"';}} else {if ($enmge_single->group_frequency == "Every 2nd and 4th Week on") {echo 'selected="selected"';}} ?>>Every 2nd and 4th Week on</option>
						</select>
						<select name="group_day" id="group_day" tabindex="10">
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 1) { echo 'selected="selected"';}} else {if ($enmge_single->group_day == 1) {echo 'selected="selected"';}} ?>>Sunday</option>
							<option value="2" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 2) { echo 'selected="selected"';}} else {if ($enmge_single->group_day == 2) {echo 'selected="selected"';}} ?>>Monday</option>
							<option value="3" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 3) { echo 'selected="selected"';}} else {if ($enmge_single->group_day == 3) {echo 'selected="selected"';}} ?>>Tuesday</option>
							<option value="4" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 4) { echo 'selected="selected"';}} else {if ($enmge_single->group_day == 4) {echo 'selected="selected"';}} ?>>Wednesday</option>
							<option value="5" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 5) { echo 'selected="selected"';}} else {if ($enmge_single->group_day == 5) {echo 'selected="selected"';}} ?>>Thursday</option>
							<option value="6" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 6) { echo 'selected="selected"';}} else {if ($enmge_single->group_day == 6) {echo 'selected="selected"';}} ?>>Friday</option>
							<option value="7" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 7) { echo 'selected="selected"';}} else {if ($enmge_single->group_day == 7) {echo 'selected="selected"';}} ?>>Saturday</option>
							<option value="8" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_day'] == 8) { echo 'selected="selected"';}} else {if ($enmge_single->group_day == 8) {echo 'selected="selected"';}} ?>>Various Days</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Start Time:</strong></th>
					<td>
						<select name="group_starttime1" id="group_starttime1" tabindex="11">
							<option value="n">AM</option>
							<option value="n">---</option>
							<option value="00" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "00") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "00") {echo 'selected="selected"';}} ?>>12</option>
							<option value="01" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "01") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "01") {echo 'selected="selected"';}} ?>>1</option>
							<option value="02" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "02") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "02") {echo 'selected="selected"';}} ?>>2</option>
							<option value="03" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "03") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "03") {echo 'selected="selected"';}} ?>>3</option>
							<option value="04" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "04") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "04") {echo 'selected="selected"';}} ?>>4</option>
							<option value="05" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "05") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "05") {echo 'selected="selected"';}} ?>>5</option>
							<option value="06" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "06") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "06") {echo 'selected="selected"';}} ?>>6</option>
							<option value="07" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "07") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "07") {echo 'selected="selected"';}} ?>>7</option>
							<option value="08" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "08") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "08") {echo 'selected="selected"';}} ?>>8</option>
							<option value="09" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "09") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "09") {echo 'selected="selected"';}} ?>>9</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "10") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "10") {echo 'selected="selected"';}} ?>>10</option>
							<option value="11" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "11") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "11") {echo 'selected="selected"';}} ?>>11</option>
							<option value="n"></option>
							<option value="n">PM</option>
							<option value="n">---</option>
							<option value="12" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "12") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "12") {echo 'selected="selected"';}} ?>>12</option>
							<option value="13" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "13") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "13") {echo 'selected="selected"';}} ?>>1</option>
							<option value="14" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "14") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "14") {echo 'selected="selected"';}} ?>>2</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "15") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "15") {echo 'selected="selected"';}} ?>>3</option>
							<option value="16" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "16") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "16") {echo 'selected="selected"';}} ?>>4</option>
							<option value="17" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "17") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "17") {echo 'selected="selected"';}} ?>>5</option>
							<option value="18" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "18") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "18") {echo 'selected="selected"';}} ?>>6</option>
							<option value="19" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "19") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "19") {echo 'selected="selected"';}} ?>>7</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "20") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "20") {echo 'selected="selected"';}} ?>>8</option>
							<option value="21" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "21") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "21") {echo 'selected="selected"';}} ?>>9</option>
							<option value="22" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "22") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "22") {echo 'selected="selected"';}} ?>>10</option>
							<option value="23" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) == "23") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -8, 2) == "23") {echo 'selected="selected"';}} ?>>11</option>
						</select>
						:
						<select name="group_starttime2" id="group_starttime2" tabindex="12">
							<option value="00" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "00") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "00") {echo 'selected="selected"';}} ?>>00</option>
							<option value="05" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "05") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "05") {echo 'selected="selected"';}} ?>>05</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "10") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "10") {echo 'selected="selected"';}} ?>>10</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "15") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "15") {echo 'selected="selected"';}} ?>>15</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "20") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "20") {echo 'selected="selected"';}} ?>>20</option>
							<option value="25" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "25") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "25") {echo 'selected="selected"';}} ?>>25</option>
							<option value="30" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "30") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "30") {echo 'selected="selected"';}} ?>>30</option>
							<option value="35" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "35") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "35") {echo 'selected="selected"';}} ?>>35</option>
							<option value="40" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "40") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "40") {echo 'selected="selected"';}} ?>>40</option>
							<option value="45" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "45") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "45") {echo 'selected="selected"';}} ?>>45</option>
							<option value="50" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "50") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "50") {echo 'selected="selected"';}} ?>>50</option>
							<option value="55" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime2'], -5, 2) == "55") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_starttime, -5, 2) == "55") {echo 'selected="selected"';}} ?>>55</option>
						</select>
						<span id="enmge_ampm1"><?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_starttime1'], -8, 2) >= 12) { echo 'pm';} else { echo 'am';}} else {if (substr($enmge_single->group_starttime, -8, 2) >= 12) {echo 'pm';} else { echo 'am';}} ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>End Time:</strong></th>
					<td>
						<select name="group_endtime1" id="group_endtime1" tabindex="13">
							<option value="n">AM</option>
							<option value="n">---</option>
							<option value="00" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "00") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "00") {echo 'selected="selected"';}} ?>>12</option>
							<option value="01" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "01") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "01") {echo 'selected="selected"';}} ?>>1</option>
							<option value="02" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "02") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "02") {echo 'selected="selected"';}} ?>>2</option>
							<option value="03" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "03") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "03") {echo 'selected="selected"';}} ?>>3</option>
							<option value="04" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "04") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "04") {echo 'selected="selected"';}} ?>>4</option>
							<option value="05" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "05") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "05") {echo 'selected="selected"';}} ?>>5</option>
							<option value="06" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "06") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "06") {echo 'selected="selected"';}} ?>>6</option>
							<option value="07" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "07") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "07") {echo 'selected="selected"';}} ?>>7</option>
							<option value="08" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "08") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "08") {echo 'selected="selected"';}} ?>>8</option>
							<option value="09" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "09") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "09") {echo 'selected="selected"';}} ?>>9</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "10") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "10") {echo 'selected="selected"';}} ?>>10</option>
							<option value="11" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "11") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "11") {echo 'selected="selected"';}} ?>>11</option>
							<option value="n"></option>
							<option value="n">PM</option>
							<option value="n">---</option>
							<option value="12" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "12") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "12") {echo 'selected="selected"';}} ?>>12</option>
							<option value="13" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "13") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "13") {echo 'selected="selected"';}} ?>>1</option>
							<option value="14" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "14") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "14") {echo 'selected="selected"';}} ?>>2</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "15") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "15") {echo 'selected="selected"';}} ?>>3</option>
							<option value="16" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "16") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "16") {echo 'selected="selected"';}} ?>>4</option>
							<option value="17" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "17") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "17") {echo 'selected="selected"';}} ?>>5</option>
							<option value="18" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "18") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "18") {echo 'selected="selected"';}} ?>>6</option>
							<option value="19" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "19") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "19") {echo 'selected="selected"';}} ?>>7</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "20") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "20") {echo 'selected="selected"';}} ?>>8</option>
							<option value="21" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "21") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "21") {echo 'selected="selected"';}} ?>>9</option>
							<option value="22" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "22") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "22") {echo 'selected="selected"';}} ?>>10</option>
							<option value="23" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) == "23") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -8, 2) == "23") {echo 'selected="selected"';}} ?>>11</option>
						</select>
						:
						<select name="group_endtime2" id="group_endtime2" tabindex="14">
							<option value="00" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "00") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "00") {echo 'selected="selected"';}} ?>>00</option>
							<option value="05" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "05") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "05") {echo 'selected="selected"';}} ?>>05</option>
							<option value="10" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "10") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "10") {echo 'selected="selected"';}} ?>>10</option>
							<option value="15" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "15") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "15") {echo 'selected="selected"';}} ?>>15</option>
							<option value="20" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "20") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "20") {echo 'selected="selected"';}} ?>>20</option>
							<option value="25" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "25") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "25") {echo 'selected="selected"';}} ?>>25</option>
							<option value="30" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "30") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "30") {echo 'selected="selected"';}} ?>>30</option>
							<option value="35" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "35") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "35") {echo 'selected="selected"';}} ?>>35</option>
							<option value="40" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "40") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "40") {echo 'selected="selected"';}} ?>>40</option>
							<option value="45" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "45") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "45") {echo 'selected="selected"';}} ?>>45</option>
							<option value="50" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "50") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "50") {echo 'selected="selected"';}} ?>>50</option>
							<option value="55" <?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime2'], -5, 2) == "55") { echo 'selected="selected"';}} else {if (substr($enmge_single->group_endtime, -5, 2) == "55") {echo 'selected="selected"';}} ?>>55</option>
						</select>
						<span id="enmge_ampm2"><?php if ($_POST && !empty($enmge_errors)) {if (substr($_POST['group_endtime1'], -8, 2) >= 12) { echo 'pm';} else { echo 'am';}} else {if (substr($enmge_single->group_endtime, -8, 2) >= 12) {echo 'pm';} else { echo 'am';}} ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong><?php echo stripslashes($enmge_grouptitle); ?> Begins:</strong></th>
					<td><input id='group_begins' name='group_begins' type='text' value='<?php if ($_POST && !empty($enmge_errors)) {echo $_POST['group_begins'];} else {echo $enmge_single->group_begins;} ?>' tabindex="15" /> <span class="ge-form-instructions">ex: 2012-01-01</span></td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong><?php echo stripslashes($enmge_grouptitle); ?> Ends:</strong></th>
					<td>
						<input name="group_noend" type="checkbox" id="group_noend" value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_noend'] == 1) { ?>checked="checked"<?php }} else {if ($enmge_single->group_noend == 1) { ?>checked="checked"<?php }} ?> class="check" /> <label for="group_noend" class="endcheck"> This <?php echo $enmge_grouptitle; ?> is Ongoing</label><br />
						<input id='group_ends' name='group_ends' type='text' value='<?php if ($_POST && !empty($enmge_errors)) {echo $_POST['group_ends'];} else {echo $enmge_single->group_ends;} ?>' tabindex="16" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_noend'] == 1) { ?>disabled="disabled"<?php }} else {if ($enmge_single->group_noend == 1) { ?>disabled="disabled"<?php }} ?> /> <span class="ge-form-instructions">ex: 2012-01-01</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo $enmge_childcarelabel; ?>:</th>
					<td>
						<select name="group_childcare" id="group_childcare" tabindex="17">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_childcare'] == 0) { ?>selected="selected"<?php }} else {if ($enmge_single->group_childcare == 0) { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_childcare'] == 1) { ?>selected="selected"<?php }} else {if ($enmge_single->group_childcare == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Childcare Details:</strong></th>
					<td><input id='group_childcare_details' name='group_childcare_details' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_childcare_details']);} else {echo stripslashes($enmge_single->group_childcare_details);} ?>" tabindex="18" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Privacy:</th>
					<td>
						<select name="group_privacy" id="group_privacy" tabindex="19">
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_privacy'] == 1) { ?>selected="selected"<?php }} else {if ($enmge_single->group_privacy == 1) { ?>selected="selected"<?php }} ?>>Public</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_privacy'] == 0) { ?>selected="selected"<?php }} else {if ($enmge_single->group_privacy == 0) { ?>selected="selected"<?php }} ?>>Hidden</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="enmge-details-area" style="display: none">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Belongs to <?php echo stripslashes($enmge_locationtitle); ?>:<p class="ge-form-instructions">Even if it meets offsite, select a "home" <?php echo stripslashes($enmge_locationtitle); ?> for this <?php echo stripslashes($enmge_grouptitle); ?>.</p></th>
					<td>
						<?php if ( !empty($enmge_gt) ) { ?>
						<ul id="enmge-locationlist" class="enmge-location">
						<?php foreach ($enmge_locations as $l) {  ?>
							<?php if ( $_POST && !empty($enmge_errors) ) { ?>
							<li><input name="locations[]" type="checkbox" value="<?php echo $l->location_id; ?>" <?php if ($_POST['locations'] != NULL) {foreach ($_POST['locations'] as $pl) { if ($pl == $l->location_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="locations[]"> <?php echo stripslashes($l->location_name); ?></label></li>
							<?php } else { ?>
							<li><input name="locations[]" type="checkbox" value="<?php echo $l->location_id; ?>" <?php if ($enmge_gglm != NULL) {foreach ($enmge_gglm as $gglm) { if ($gglm->location_id == $l->location_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="locations[]"> <?php echo stripslashes($l->location_name); ?></label></li>	
							<?php } ?>
						<?php }; ?>
						</ul>
						<?php } else { echo '<p>Add a  '. $enmge_locationtitle . ' in the "Edit ' . $enmge_locationptitle . '" menu.</p>'; } ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo stripslashes($enmge_grouptypetitle); ?>:<p class="ge-form-instructions">Select multiple if needed. How will your users search for this <?php echo stripslashes($enmge_grouptitle); ?>?</p></th>
					<td>
						<input id='group_type_name' name='group_type_name' type='text' value='' tabindex="20" />
						<a href="#" id="addnewgrouptype" class="button">Add New <?php echo stripslashes($enmge_grouptypetitle); ?></a>
						<?php if ( !empty($enmge_gt) ) { ?>
						<ul id="enmge-grouptypelist" class="enmge-group-type">
						<?php foreach ($enmge_gt as $gt) {  ?>
							<?php if ( $_POST && !empty($enmge_errors) ) { ?>
							<li><input name="grouptypes[]" type="checkbox" value="<?php echo $gt->group_type_id; ?>" <?php if ($_POST['grouptypes'] != NULL) {foreach ($_POST['grouptypes'] as $pgt) { if ($pgt == $gt->group_type_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="grouptypes[]"> <?php echo stripslashes($gt->group_type_title); ?></label></li>
							<?php } else { ?>
							<li><input name="grouptypes[]" type="checkbox" value="<?php echo $gt->group_type_id; ?>" <?php if ($enmge_ggggtm != NULL) {foreach ($enmge_ggggtm as $ggggtm) { if ($ggggtm->group_type_id == $gt->group_type_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="grouptypes[]"> <?php echo stripslashes($gt->group_type_title); ?></label></li>	
							<?php } ?>
						<?php }; ?>
						</ul>
						<?php } else { echo '<p>Add a ' . $enmge_grouptypetitle . ' above or in the "Edit ' . $enmge_grouptypestitle . '" menu.</p>'; } ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Associate with <?php echo stripslashes($enmge_topictitle); ?>:<p class="ge-form-instructions">Add as many as you like.</p></th>
					<td>
						<input id='topic_name' name='topic_name' type='text' value='' tabindex="21" />
						<a href="#" id="addnewtopic" class="button">Add New <?php echo stripslashes($enmge_topictitle); ?></a>
						<?php if ( !empty($enmge_t) ) { ?>
						<ul id="enmge-topiclist" class="enmge-group-topic">
						<?php foreach ($enmge_t as $t) {  ?>
							<?php if ( $_POST && !empty($enmge_errors) ) { ?>
							<li><input name="topics[]" type="checkbox" value="<?php echo $t->topic_id; ?>" <?php if ($_POST['topics'] != NULL) {foreach ($_POST['topics'] as $pt) { if ($pt == $t->topic_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="topics[]"> <?php echo stripslashes($t->topic_name); ?></label></li>
							<?php } else { ?>
							<li><input name="topics[]" type="checkbox" value="<?php echo $t->topic_id; ?>" <?php if ($enmge_ggtm != NULL) {foreach ($enmge_ggtm as $ggtm) { if ($ggtm->topic_id == $t->topic_id) { ?>checked="checked"<?php }}} ?> class="check" /> <label for="topics[]"> <?php echo stripslashes($t->topic_name); ?></label></li>	
							<?php } ?>
						<?php }; ?>
						</ul>
						<?php } else { echo '<p>Add a ' . $enmge_topictitle . ' above or in the "Edit ' . $enmge_topicptitle . '" menu.</p>'; } ?>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="enmge-location-area" style="display: none">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Location Label:</th>
					<td><input id='group_location_label' name='group_location_label' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_location_label']);} else {echo stripslashes($enmge_single->group_location_label);} ?>" tabindex="22" /> <span class="ge-form-instructions">ex: Room 46, Downtown Starbucks, etc</span></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo stripslashes($enmge_grouptitle); ?> Meets At...<p class="ge-form-instructions">Does it meet at one of your <?php echo stripslashes($enmge_locationptitle); ?>, or somewhere else in the community?</p></th>
					<td>
						<select name="group_onsite" id="group_onsite" tabindex="23">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_onsite'] == 0) { echo 'selected="selected"';}} else {if ($enmge_single->group_onsite == 0) {echo 'selected="selected"';}} ?>>Offsite</option>
							<?php foreach ( $enmge_locations as $enmge_location ) { ?>
							<option value="<?php echo $enmge_location->location_id ?>" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_onsite'] == $enmge_location->location_id) { echo 'selected="selected"';}} else {if ($enmge_location->location_id == $enmge_single->group_onsite) {echo 'selected="selected"';}} ?>><?php echo $enmge_location->location_name; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
			</table>
			<table class="form-table" id="enmgeaddressinfo" <?php if ( $enmge_single->group_onsite > 0 ) { echo 'style="display: none"';} ?>>
				<tr valign="top">
					<th scope="row">Address:<p class="ge-form-instructions">Consider street names without numbers, or even just city or postal code if your leader prefers more privacy.</p></th>
					<td><input id='group_address1' name='group_address1' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_address1']);} else {echo stripslashes($enmge_single->group_address1);} ?>" tabindex="24" /><br /><input id='group_address2' name='group_address2' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_address2']);} else {echo stripslashes($enmge_single->group_address2);} ?>" tabindex="25" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">City:</th>
					<td><input id='group_city' name='group_city' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_city']);} else {echo stripslashes($enmge_single->group_city);} ?>" tabindex="26" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">State/Province:</th>
					<td><input id='group_state' name='group_state' type='text' size="3" value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_state']);} else {echo stripslashes($enmge_single->group_state);} ?>" tabindex="27" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Postal Code:</th>
					<td><input id='group_zip' name='group_zip' type='text' size="5" value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_zip']);} else {echo stripslashes($enmge_single->group_zip);} ?>" tabindex="28" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Make Address Public?: <p class="ge-form-instructions">A pin will be displayed on the map, but the address will not be publicly shared.</p></th>
					<td>
						<select name="group_location_privacy" id="group_location_privacy" tabindex="29">
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_location_privacy'] == 1) { ?>selected="selected"<?php }} else {if ($enmge_single->group_location_privacy == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_location_privacy'] == 0) { ?>selected="selected"<?php }} else {if ($enmge_single->group_location_privacy == 0) { ?>selected="selected"<?php }} ?>>No</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Manually Edit Lat/Long?: <p class="ge-form-instructions">Overwrite the coordinates generated by the address above.</p></th>
					<td>
						<select name="group_manedit" id="group_manedit" tabindex="30">
							<option value="0" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_manedit'] == 0) { ?>selected="selected"<?php }} else {if ($enmge_single->group_manedit == 0) { ?>selected="selected"<?php }} ?>>No</option>
							<option value="1" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_manedit'] == 1) { ?>selected="selected"<?php }} else {if ($enmge_single->group_manedit == 1) { ?>selected="selected"<?php }} ?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr valign="top" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_manedit'] == 0) { ?>style="display: none"<?php }} else {if ($enmge_single->group_manedit == 0) { ?>style="display: none"<?php }} ?> id="latrow">
					<th scope="row">Latitude:</th>
					<td><input id='group_lat' name='group_lat' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_lat']);} else {echo stripslashes($enmge_single->group_lat);} ?>" tabindex="31" /></td>
				</tr>
				<tr valign="top" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['group_manedit'] == 0) { ?>style="display: none"<?php }} else {if ($enmge_single->group_manedit == 0) { ?>style="display: none"<?php }} ?> id="longrow">
					<th scope="row">Longitude:</th>
					<td><input id='group_long' name='group_long' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['group_long']);} else {echo stripslashes($enmge_single->group_long);} ?>" tabindex="32" /></td>
				</tr>
			</table>
		</div>
		
		<div id="enmge-related-files" style="display: none">
				<p>The items you provide below will appear on the <?php echo stripslashes($enmge_grouptitle); ?> details view in the "Related" section above the <?php echo stripslashes($enmge_grouptitle); ?> map.</p>
				
				<div id="enmgefileform">
					<h3>Attach a Link or Download</h3>		
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Name:</th>
							<td><input id='file_name' name='file_name' type='text' value="" tabindex="30" /></td>
						</tr>
						<tr valign="top">
							<th scope="row">Link/File URL:</th>
							<td><input id='file_url' name='file_url' type='text' value='' tabindex="31" /> &nbsp;<a href="<?php echo admin_url( '/media-upload.php?post_id=0&#038;TB_iframe=1', __FILE__ ); ?>" class="enmge-upload-group-file ge-upload-link" id="content-add_media" title="Add Media" onclick="return false;"><img src="<?php echo admin_url(); ?>/images/media-button.png?ver=20111005" width="15" height="15" class="ge-media-button" /> &nbsp;Upload File</a></td>
						</tr>
					</table>
					<br />
					<input type="hidden" name="file_username" value="<?php echo $enmge_userdetails->user_login; ?>" id="file_username" />
			
					<a href="#" id="addnewfile" class="button">Attach New Link/Download</a>
				</div>
				<br />
				<br />
				<div id="enmgefilearea">
					<?php if ( !empty($enmge_files) ) { ?>
						<script type="text/javascript">
						jQuery(document).ready(function(){
							var fixHelper = function(e, ui) {
								ui.children().each(function() {
									jQuery(this).width(jQuery(this).width());
								});
								return ui;
							};
							jQuery("#filestable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
								var order = jQuery(this).sortable("serialize"); 
								jQuery.ajax({
									method: "POST",
							        url: geajax.ajaxurl, 
							        data: {
							            'action': 'groupsengine_ajaxsortfiles',
							            'frow': order
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
					<h3>Links and Downloads Currently Associated with This <?php echo stripslashes($enmge_grouptitle); ?>...</h3>
					<table class="widefat" id="filestable"> 
						<thead> 
							<tr> 
								<th>Sort</th> 
								<th>Name</th> 
								<th>URL</th>
								<th>Delete?</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($enmge_files as $file) {  ?>
							<tr id="row_<?php echo $file->file_id; ?>">
								<td class="enmge-sort"></td>
								<td><a href="#" class="groupsengine_editfile" name="<?php echo $file->file_id; ?>"><?php echo $file->file_name; ?></a></td>
								<td><a href="<?php echo $file->file_url; ?>" target="_blank"><?php echo $file->file_url; ?></a></td>
								<td class="enmge-delete"><a href="#" class="groupsengine_filedelete" name="<?php echo $file->file_id; ?>">Delete</a></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
					<?php } ?>
				</div>
				<br />
				<br />
				<br />
				<br />
			</div>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Update <?php echo stripslashes($enmge_grouptitle); ?>" tabindex="32" /></p>
		<input type="hidden" name="enmgegid" value="<?php echo $enmge_single->group_id; ?>" id="enmgegid" />
		<input type="hidden" name="enmgepluginurl" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/newtopiclist.php" id="enmgepluginurl" />
		<input type="hidden" name="enmgepluginurl2" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/newgrouptypelist.php" id="enmgepluginurl2" />
		<input type="hidden" name="enmgefileurl" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/newfile.php" id="enmgefileurl" />
		<input type="hidden" name="enmgefiledelete" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/filedelete.php" id="enmgefiledelete" />
		<input type="hidden" name="enmgefileedit" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/fileedit.php" id="enmgefileedit" />
		<input type="hidden" name="enmge_oldaddress1" value="<?php echo $enmge_single->group_address1; ?>" id="enmge_oldaddress1" />
		<input type="hidden" name="enmge_oldaddress2" value="<?php echo $enmge_single->group_address2; ?>" id="enmge_oldaddress2" />
		<input type="hidden" name="enmge_oldcity" value="<?php echo $enmge_single->group_city; ?>" id="enmge_oldcity" />
		<input type="hidden" name="enmge_oldstate" value="<?php echo $enmge_single->group_state; ?>" id="enmge_oldstate" />
		<input type="hidden" name="enmge_oldzip" value="<?php echo $enmge_single->group_zip; ?>" id="enmge_oldzip" />
		<input type="hidden" name="enmge_oldlat" value="<?php echo $enmge_single->group_lat; ?>" id="enmge_oldlat" />
		<input type="hidden" name="enmge_oldlong" value="<?php echo $enmge_single->group_long; ?>" id="enmge_oldlong" />
		<input type="hidden" name="enmgeimage" value="<?php echo $enmge_imagewidth; ?>" id="enmgeimage" />
		<input type="hidden" name="enmgeleaderurl" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/newleader.php" id="enmgeleaderurl" />
		<input type="hidden" name="enmgeleaderdelete" value="<?php echo plugins_url(); ?>/groupsengine_plugin/includes/admin/leaderdelete.php" id="enmgeleaderdelete" />
		<input type="hidden" name="xxge" value="<?php echo base64_encode(ABSPATH); ?>" id="xxge" />
	</form>
	

	<p><a href="<?php if ( isset($_GET['enmge_p']) ) { if ( isset($_GET['enmge_gtid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_gtid=' . $enmge_gtid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_tid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_tid=' . $enmge_tid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_lid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_lid=' . $enmge_lid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_day']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_day . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ );} } else { if ( isset($_GET['enmge_gtid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_gtid=' . $enmge_gtid, __FILE__ ); } elseif ( isset($_GET['enmge_tid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_tid=' . $enmge_tid, __FILE__ ); } elseif ( isset($_GET['enmge_lid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_lid=' . $enmge_lid, __FILE__ ); } elseif ( isset($_GET['enmge_day']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_day, __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php', __FILE__ ); }} ?>">&laquo; All Groups</a></p>
	<?php include ('gecredits.php'); ?>
<?php }} else { // Display the main listing of Messages ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/deletegroup.js'; ?>"></script>

	<h2 class="enmge">Create and Edit <?php echo stripslashes($enmge_groupptitle); ?> <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>

	<p>Click a <?php echo stripslashes($enmge_grouptitle); ?> title below to edit a <?php echo stripslashes($enmge_grouptitle); ?>. Click "Add New" above to add a new <?php echo stripslashes($enmge_grouptitle); ?> to the Groups Engine browser. Select a filter or click a detail below to make it easier to sort through a large number of <?php echo stripslashes($enmge_groupptitle); ?>. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-groups"; ?>">User Guide</a>.</p>

	<div id="contactfilter">
		<strong>Filter By:</strong>
		<select name="enmge_filter" id="enmge_filter">
			<option value="0">- No Filter -</option>
			<option value="1" <?php if ( isset($_GET['enmge_gtid']) ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmge_grouptypetitle); ?></option>
			<option value="2" <?php if ( isset($_GET['enmge_lid']) ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmge_locationtitle); ?></option>
			<option value="3" <?php if ( isset($_GET['enmge_tid']) ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($enmge_topictitle); ?></option>
			<option value="4" <?php if ( isset($_GET['enmge_day']) ) { ?>selected="selected"<?php } ?>>Day</option>
		</select>
		<select name="enmge_grouptype" id="enmge_grouptype" <?php if ( !isset($_GET['enmge_gtid']) ) { ?>style="display: none"<?php } ?>>
			<option value="0">- Select -</option>
			<?php foreach ( $enmge_gt as $gt) { ?>
			<option value="<?php echo $gt->group_type_id; ?>" <?php if ( isset($_GET['enmge_gtid']) && $_GET['enmge_gtid'] == $gt->group_type_id ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($gt->group_type_title); ?></option>
			<?php } ?>
		</select>
		<select name="enmge_location" id="enmge_location" <?php if ( !isset($_GET['enmge_lid']) ) { ?>style="display: none"<?php } ?>>
			<option value="0">- Select -</option>
			<?php foreach ( $enmge_locations as $l) { ?>
			<option value="<?php echo $l->location_id; ?>" <?php if ( isset($_GET['enmge_lid']) && $_GET['enmge_lid'] == $l->location_id ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($l->location_name); ?></option>
			<?php } ?>
		</select>
		<select name="enmge_topic" id="enmge_topic" <?php if ( !isset($_GET['enmge_tid']) ) { ?>style="display: none"<?php } ?>>
			<option value="0">- Select -</option>
			<?php foreach ( $enmge_t as $t) { ?>
			<option value="<?php echo $t->topic_id; ?>" <?php if ( isset($_GET['enmge_tid']) && $_GET['enmge_tid'] == $t->topic_id ) { ?>selected="selected"<?php } ?>><?php echo stripslashes($t->topic_name); ?></option>
			<?php } ?>
		</select>
		<select name="enmge_day" id="enmge_day" <?php if ( !isset($_GET['enmge_day']) ) { ?>style="display: none"<?php } ?>>
			<option value="0">- Select -</option>
			<option value="1" <?php if ( isset($_GET['enmge_day']) && $_GET['enmge_day'] == 1 ) { ?>selected="selected"<?php } ?>>Sunday</option>
			<option value="2" <?php if ( isset($_GET['enmge_day']) && $_GET['enmge_day'] == 2 ) { ?>selected="selected"<?php } ?>>Monday</option>
			<option value="3" <?php if ( isset($_GET['enmge_day']) && $_GET['enmge_day'] == 3 ) { ?>selected="selected"<?php } ?>>Tuesday</option>
			<option value="4" <?php if ( isset($_GET['enmge_day']) && $_GET['enmge_day'] == 4 ) { ?>selected="selected"<?php } ?>>Wednesday</option>
			<option value="5" <?php if ( isset($_GET['enmge_day']) && $_GET['enmge_day'] == 5 ) { ?>selected="selected"<?php } ?>>Thursday</option>
			<option value="6" <?php if ( isset($_GET['enmge_day']) && $_GET['enmge_day'] == 6 ) { ?>selected="selected"<?php } ?>>Friday</option>
			<option value="7" <?php if ( isset($_GET['enmge_day']) && $_GET['enmge_day'] == 7 ) { ?>selected="selected"<?php } ?>>Saturday</option>
			<option value="8" <?php if ( isset($_GET['enmge_day']) && $_GET['enmge_day'] == 8 ) { ?>selected="selected"<?php } ?>>Various</option>
		</select>
	</div>
	<?php include ('grouppagination.php'); ?>
	<table class="widefat"> 
		<thead> 
			<tr> 
				<th>Title</th> 
				<th>Day</th> 
				<th><?php echo stripslashes($enmge_locationtitle); ?></th>
				<th><?php echo stripslashes($enmge_grouptypetitle); ?></th> 
				<th><?php echo stripslashes($enmge_topictitle); ?></th> 
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmge_groups as $enmge_single ) { ?>
			<tr>
				<td><a href="<?php if ( isset($_GET['enmge_p']) ) { if ( isset($_GET['enmge_gtid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_gtid=' . $enmge_gtid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_tid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_tid=' . $enmge_tid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_day']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_day=' . $enmge_day . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } elseif ( isset($_GET['enmge_lid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_lid=' . $enmge_lid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ );} } else { if ( isset($_GET['enmge_gtid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_gtid=' . $enmge_gtid, __FILE__ ); } elseif ( isset($_GET['enmge_tid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_tid=' . $enmge_tid, __FILE__ ); } elseif ( isset($_GET['enmge_day']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_day=' . $enmge_day, __FILE__ ); } elseif ( isset($_GET['enmge_lid']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id . '&amp;enmge_lid=' . $enmge_lid, __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_action=edit&amp;enmge_gid=' . $enmge_single->group_id, __FILE__ ); }} ?>"><?php echo stripslashes($enmge_single->group_title) ?></a></td>
				<td><?php if ( $enmge_single->group_day == 8 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_single->group_day, __FILE__ ) . "\">Various</a>";  } ?><?php if ( $enmge_single->group_day == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_single->group_day, __FILE__ ) . "\">Sunday</a>";  } ?><?php if ( $enmge_single->group_day == 2 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_single->group_day, __FILE__ ) . "\">Monday</a>";  } ?><?php if ( $enmge_single->group_day == 3 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_single->group_day, __FILE__ ) . "\">Tuesday</a>";  } ?><?php if ( $enmge_single->group_day == 4 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_single->group_day, __FILE__ ) . "\">Wednesday</a>";  } ?><?php if ( $enmge_single->group_day == 5 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_single->group_day, __FILE__ ) . "\">Thursday</a>";  } ?><?php if ( $enmge_single->group_day == 6 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_single->group_day, __FILE__ ) . "\">Friday</a>";  } ?><?php if ( $enmge_single->group_day == 7 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_day=' . $enmge_single->group_day, __FILE__ ) . "\">Saturday</a>";  } ?></td>
				<td><?php $enmge_l_comma = 1; foreach ( $enmge_locations as $l) { ?><?php foreach ( $enmge_glm as $glm) { ?><?php if ( ($glm->group_id == $enmge_single->group_id) && ($glm->location_id == $l->location_id) ) { if ( $enmge_l_comma == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_lid=' . $l->location_id, __FILE__ ) . "\">" . stripslashes($l->location_name) . "</a>"; $enmge_l_comma = $enmge_l_comma+1; } else { echo ", <a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_lid=' . $l->location_id, __FILE__ ) . "\">" . stripslashes($l->location_name) . "</a>"; $enmge_l_comma = $enmge_l_comma+1; } } ?><?php } ?><?php } ?></td>				
				<td><?php $enmge_gt_comma = 1; foreach ( $enmge_gt as $gt) { ?><?php foreach ( $enmge_gggtm as $ggtm) { ?><?php if ( ($ggtm->group_id == $enmge_single->group_id) && ($ggtm->group_type_id == $gt->group_type_id) ) { if ( $enmge_gt_comma == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_gtid=' . $gt->group_type_id, __FILE__ ) . "\">" . stripslashes($gt->group_type_title) . "</a>"; $enmge_gt_comma = $enmge_gt_comma+1; } else { echo ", <a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_gtid=' . $gt->group_type_id, __FILE__ ) . "\">" . stripslashes($gt->group_type_title) . "</a>"; $enmge_gt_comma = $enmge_gt_comma+1; } } ?><?php } ?><?php } ?></td>				
				<td><?php $enmge_t_comma = 1; foreach ( $enmge_t as $t) { ?><?php foreach ( $enmge_gtm as $gtm) { ?><?php if ( ($gtm->group_id == $enmge_single->group_id) && ($gtm->topic_id == $t->topic_id) ) { if ( $enmge_t_comma == 1 ) { echo "<a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_tid=' . $t->topic_id, __FILE__ ) . "\">" . stripslashes($t->topic_name) . "</a>"; $enmge_t_comma = $enmge_t_comma+1; } else { echo ", <a href=\"" . admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php&amp;enmge_tid=' . $t->topic_id, __FILE__ ) . "\">" . stripslashes($t->topic_name) . "</a>"; $enmge_t_comma = $enmge_t_comma+1; } } ?><?php } ?><?php } ?></td>				
				<td class="enmge-delete"><form action="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php', __FILE__ ); ?>&amp;enmge_did=1" method="post" id="groupsengine-deleteform<?php echo $enmge_single->group_id ?>"><input type="hidden" name="group_delete" value="<?php echo $enmge_single->group_id ?>"></form><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php', __FILE__ ); ?>" class="groupsengine_delete" name="<?php echo $enmge_single->group_id ?>">Delete</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<input type="hidden" name="enmgepluginurl" value="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php', __FILE__ ); ?>" id="enmgepluginurl" />
	<input type="hidden" name="xxge" value="<?php echo base64_encode(ABSPATH); ?>" id="xxge" />
	<?php include ('gecredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
