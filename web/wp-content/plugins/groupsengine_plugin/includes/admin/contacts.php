<?php /* ----- Groups Engine - View and Edit Contacts ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		global $wpdb;
		
		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		$enmge_dateformat = get_option( 'date_format' ); 
		$enmge_grouptitle = $enmge_options['grouptitle'];
		$enmge_grouptypetitle = $enmge_options['grouptypetitle'];
		$enmge_grouptypeptitle = $enmge_options['grouptypeptitle']; 
		$enmge_groupptitle = $enmge_options['groupptitle']; 
		$enmge_emailname = $enmge_options['emailname'];
		$enmge_emailaddress = $enmge_options['emailaddress'];
		
		$enmge_errors = array(); //Set up errors array
		$enmge_messages = array(); //Set up messages array

		function nl2p($text) {
			return "<p>" . str_replace("\n", "</p><p>", $text) . "</p>";
		}
		
		if ( $_POST && isset($_GET['enmge_did']) ) { // If deleting a group type
			$enmge_deleted_id = strip_tags($_POST['contact_delete']);
			$enmge_delete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_id=%d";
			$enmge_delete_query = $wpdb->prepare( $enmge_delete_query_preparred, $enmge_deleted_id ); 
			$enmge_deleted = $wpdb->query( $enmge_delete_query ); 
			
			$enmge_notesdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "ge_contact_notes" . " WHERE contact_id=%d";
			$enmge_notesdelete_query = $wpdb->prepare( $enmge_notesdelete_query_preparred, $enmge_deleted_id ); 
			$enmge_notesdeleted = $wpdb->query( $enmge_notesdelete_query );
			
			$enmge_messages[] = "The contact was successfully deleted.";
		}
		
		if ( isset($_GET['enmge_action']) ) {
			$enmge_single_created = null;

			if ( $_GET['enmge_action'] == 'edit' ) { // Edit Contact
				$enmge_userdetails = wp_get_current_user(); 

				if ( $_POST ) {

					
					$enmge_status = strip_tags($_POST['contact_status']);
					$enmge_note = strip_tags($_POST['contact_note']);
					$enmge_last_update = $enmge_userdetails->display_name;
					$enmge_last_update_day = date("Y-m-d", time());
					
					
						if ( isset($_GET['enmge_cid']) && is_numeric($_GET['enmge_cid']) ) {
							$enmge_cid = strip_tags($_GET['enmge_cid']);
						}
						
						$enmge_new_values = array( 'contact_status' => $enmge_status, 'contact_last_update' => $enmge_last_update, 'contact_last_update_day' =>  $enmge_last_update_day ); 
						$enmge_where = array( 'contact_id' => $enmge_cid ); 
						$wpdb->update( $wpdb->prefix . "ge_contacts", $enmge_new_values, $enmge_where ); 
						$enmge_messages[] = "Contact successfully updated!";

						$enmge_findthecontactsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_id = %d"; 
						$enmge_findthecontact = $wpdb->prepare( $enmge_findthecontactsql, $enmge_cid );
						$enmge_single = $wpdb->get_row( $enmge_findthecontact, OBJECT );
						$enmge_singlecount = $wpdb->num_rows;

						if ( $enmge_note != null ) {
							$enmge_note_date = date("Y-m-d H:i:s", time());
							$enmge_user = $enmge_userdetails->display_name;
							$enmge_newnote = array(
								'contact_note_date' => $enmge_note_date,
								'contact_id' => $enmge_cid,
								'contact_note_user' => $enmge_user,
								'contact_note' => $enmge_note
							); 
							$wpdb->insert( $wpdb->prefix . "ge_contact_notes", $enmge_newnote );
						}

						$enmge_preparrednotessql = "SELECT * FROM " . $wpdb->prefix . "ge_contact_notes" . " WHERE contact_id = %d ORDER BY contact_note_id ASC"; 
						$enmge_notessql = $wpdb->prepare( $enmge_preparrednotessql, $enmge_single->contact_id );
						$enmge_notes = $wpdb->get_results( $enmge_notessql );

						// Get All Leaders
						$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
						$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_single->contact_group_id );
						$enmge_groupleaders = $wpdb->get_results( $enmge_lesql );
						
						include('emailcontactupdate.php');

				} else {
					if ( isset($_GET['enmge_cid']) && is_numeric($_GET['enmge_cid']) ) {
						$enmge_cid = strip_tags($_GET['enmge_cid']);
					}

					$enmge_findthecontactsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_id = %d"; 
					$enmge_findthecontact = $wpdb->prepare( $enmge_findthecontactsql, $enmge_cid );
					$enmge_single = $wpdb->get_row( $enmge_findthecontact, OBJECT );
					$enmge_singlecount = $wpdb->num_rows;

					$enmge_preparrednotessql = "SELECT * FROM " . $wpdb->prefix . "ge_contact_notes" . " WHERE contact_id = %d ORDER BY contact_note_id ASC"; 
					$enmge_notessql = $wpdb->prepare( $enmge_preparrednotessql, $enmge_single->contact_id );
					$enmge_notes = $wpdb->get_results( $enmge_notessql );

					// Get All Leaders
					$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id"; 
					$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_single->contact_group_id );
					$enmge_groupleaders = $wpdb->get_results( $enmge_lesql );

					if ( isset($_GET['enmge_r']) ) {
						include('emailsendreminder.php');
						$enmge_messages[] = "The leader just received a reminder email! (Please don't refresh this page, or another email will be sent.)";
					}
					
				}	
			}
			
			if ( $_GET['enmge_action'] == 'new' && !isset($_GET['enmge_did']) ) { // New Contact
				
				$enmge_userdetails = wp_get_current_user(); 

				$enmge_preparredsql = "SELECT group_id, group_title FROM " . $wpdb->prefix . "ge_groups WHERE group_begins <= CURDATE() AND group_ends >= CURDATE() GROUP BY group_id ORDER BY group_day, group_starttime ASC";
				$enmge_groups = $wpdb->get_results( $enmge_preparredsql );

				// Get All Group Types
				$enmge_preparredgtsql = "SELECT group_type_id, group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_title ASC"; 
				$enmge_gts = $wpdb->get_results( $enmge_preparredgtsql );
				
				if ( $_POST ) {
					
					if (empty($_POST['contact_name'])) { //validate presence of name
						$enmge_errors[] = 'A name is required.';
					} else {
						$enmge_name = strip_tags($_POST['contact_name']);
					};

					if (empty($_POST['contact_email'])) { //validate presence and format of email
						$enmge_errors[] = 'An email address is required.';
					} else {
						if (preg_match('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$^', $_POST['contact_email'])) { 
							$enmge_email = $_POST['contact_email'];
						} else {
							$enmge_errors[] = 'You must provide a valid email address.';
						};
					};

					$enmge_phone = strip_tags($_POST['contact_phone']);
					
					if (empty($_POST['contact_message']) || strlen($_POST['contact_message']) < 10) { //validate presence and length of message
						$enmge_errors[] = 'Please enter a message.';
					} else {
						if (preg_match('/(href=)/', $_POST['contact_message']) || preg_match('/(HREF=)/', $_POST['contact_message'])) { // Simple check for spam hyperlinks
							$enmge_errors[] = 'Sorry, no HTML is allowed in your message.';
						} else {
							$enmge_message = strip_tags($_POST['contact_message']);
						}
					};

					$enmge_mc = md5(uniqid(rand(), true));
					$enmge_date = date("Y-m-d H:i:s", time());
					$enmge_status = strip_tags($_POST['contact_status']);
					
					if ( $_POST['contact_group_id'] > 0 ) {
						$enmge_group_id = $_POST['contact_group_id'];
						$enmge_findthegroupsql = "SELECT group_title, group_leaders, group_leaders_email FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_id = %d"; 
						$enmge_findthemessage = $wpdb->prepare( $enmge_findthegroupsql, $enmge_group_id );
						$enmge_group = $wpdb->get_row( $enmge_findthemessage, OBJECT );
						$enmge_group_title = $enmge_group->group_title;
						$enmge_group_leader = $enmge_group->group_leaders;
						$enmge_group_leader_email = $enmge_group->group_leaders_email;	
					} else {
						$enmge_errors[] = 'Please select a ' . stripslashes($enmge_grouptitle) . '.';
					}
					
					$enmge_note = strip_tags($_POST['contact_note']);			
							
					if (empty($enmge_errors)) {

						$enmge_single_created = "yes";

						$enmge_newcontact = array(
							'contact_name' => $enmge_name, 
							'contact_email' => $enmge_email, 
							'contact_phone' => $enmge_phone, 
							'contact_message' => $enmge_message, 
							'contact_modcode' => $enmge_mc,
							'contact_date' => $enmge_date,
							'contact_status' => $enmge_status,
							'contact_group_id' => $enmge_group_id,
							'contact_group_title' => $enmge_group_title,
							'contact_group_leader' => $enmge_group_leader,
							'contact_group_leader_email' => $enmge_group_leader_email
						); 
						$wpdb->insert( $wpdb->prefix . "ge_contacts", $enmge_newcontact );
						$enmge_new_contact_id = $wpdb->insert_id; 
						
						$enmge_messages[] = "You have successfully added a new contact to Groups Engine!";

						if ( $enmge_note != null ) {
							$enmge_note_date = date("Y-m-d H:i:s", time());
							$enmge_user = $enmge_userdetails->display_name;
							$enmge_newnote = array(
								'contact_note_date' => $enmge_note_date,
								'contact_id' => $enmge_new_contact_id,
								'contact_note_user' => $enmge_user,
								'contact_note' => $enmge_note
							); 
							$wpdb->insert( $wpdb->prefix . "ge_contact_notes", $enmge_newnote );
						}

						$enmge_preparrednotessql = "SELECT * FROM " . $wpdb->prefix . "ge_contact_notes" . " WHERE contact_id = %d ORDER BY contact_note_id ASC"; 
						$enmge_notessql = $wpdb->prepare( $enmge_preparrednotessql, $enmge_new_contact_id );
						$enmge_notes = $wpdb->get_results( $enmge_notessql );

						include('emailnotifyleader.php');

					} else {
						
					}
				}

			}
		}
		
		include ('paginated_contacts.php'); // Get all groups

		// Get All Group Group Type Matches
		$enmge_preparredggtmsql = "SELECT group_id, group_type_id FROM " . $wpdb->prefix . "ge_group_group_type_matches"; 
		$enmge_ggtm = $wpdb->get_results( $enmge_preparredggtmsql );
		

	} else {
		exit("Access Denied");
	}
	
?>

<div class="wrap"> 
<?php if ( isset($_GET['enmge_action']) && ( $enmge_single_created == null && !isset($_GET['enmge_did']) ) ) { if ( $_GET['enmge_action'] == 'new' ) { // If they're adding a new Contact ?>
		<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#contact_group_type').live("change", function() {
					var pluginurl = jQuery('#enmge-get-plugin-link').attr("title");
					var gerandom = Math.floor(Math.random()*1001);
					var gtvalue = jQuery(this).val();
					var xxge = "<?php echo base64_encode(ABSPATH); ?>";
					if ( gtvalue != "n" ) {
						jQuery('#groupsfield').load(pluginurl+"contactfindgroup.php?enmge_gtid="+gtvalue+"&xxge="+xxge+"&enmge_random="+gerandom, function() {
							jQuery("#groupsfield").show();
						});
					} else {
						jQuery("#groupsfield").hide();
					};
				});
			});
		</script>

		<h2 class="enmge">Add a New Contact</h2>
		<?php include ('errorbox.php'); ?>
		<p>Complete the fields below to manage a new Contact in Groups Engine. The <?php echo stripslashes($enmge_grouptitle); ?> leader you specify below will receive an email notification and all contact information. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-contacts"; ?>">User Guide</a>.</p>
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
			<div id="enmge-basic-information">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><strong>Name:</strong></th>
						<td><input id='contact_name' name='contact_name' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['contact_name']);} ?>" tabindex="1" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><strong>Email:</strong></th>
						<td><input id='contact_email' name='contact_email' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['contact_email']);} ?>" tabindex="2" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><strong>Phone:</strong></th>
						<td><input id='contact_phone' name='contact_phone' type='text' value="<?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['contact_phone']);} ?>" tabindex="3" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Message:
							<p class="ge-form-instructions">Instructions here.</p>
						</th>
						<td>
							<textarea name="contact_message" id="contact_message" rows="4" cols="40" tabindex="4"><?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['contact_message']);} ?></textarea><br />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><strong>For <?php echo stripslashes($enmge_grouptitle); ?>:</strong></th>
						<td><select id='contact_group_type' name='contact_group_type' tabindex="5">
							<option value="n">- Choose a <?php echo stripslashes($enmge_grouptypetitle); ?> -</option>
							<option value="0">All <?php echo stripslashes($enmge_grouptypeptitle); ?></option>
							<?php foreach ( $enmge_gts as $gt ) { ?>
							<option value="<?php echo $gt->group_type_id; ?>"><?php echo stripslashes($gt->group_type_title); ?></option>
							<?php } ?>
						</select>
							<div id="groupsfield" style="display: none"><br /><select id='contact_group_id' name='contact_group_id' tabindex="6">
							<option value="0">- Choose a <?php echo stripslashes($enmge_grouptitle); ?> -</option>
						</select></div></td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><strong>Status:</strong></th>
						<td>
							<select name="contact_status" id="contact_status" tabindex="7">
								<option value="Initial Followup Needed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Initial Followup Needed") { ?>selected="selected"<?php }} ?>>Initial Followup Needed</option>
								<option value="Additional Followup Needed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Additional Followup Needed") { ?>selected="selected"<?php }} ?>>Additional Followup Needed</option>
								<option value="Closed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Closed") { ?>selected="selected"<?php }} ?>>Closed</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							Note:
							<p class="ge-form-instructions">Add a note to this contact's history.</p>
						</th>
						<td>
							<textarea name="contact_note" id="contact_note" rows="4" cols="40" tabindex="8"><?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['contact_note']);} ?></textarea><br />
						</td>
					</tr>
				</table>
			</div>
		
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Add New Contact" tabindex="9" /></p>
			<input type="hidden" name="enmgegtid" value="<?php echo $enmge_single->group_type_id; ?>" id="enmgegtid" />
		</form>	

		<p><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts', __FILE__ ); ?>">&laquo; All Contacts</a></p>
		<p id="enmge-get-plugin-link" title="<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/'; ?>"></p>
		<?php include ('gecredits.php'); ?>
<?php } elseif ( ($_GET['enmge_action'] == 'edit') && ( $enmge_singlecount == 1 ) ) { // Edit Contact ?>
	<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#enmge-reminder-link').click(function() {
				var answer = confirm("Are you sure you want to send the leader a reminder email?")
				if (answer){
				} else {
					return false;
				};
			});
		});
	</script>
	<h2 class="enmge">Edit Contact <a href="<?php if ( isset($_GET['enmge_p']) ) { if ( isset($_GET['enmge_cs']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_action=edit&amp;enmge_r=1&amp;enmge_cid=' . $enmge_cid . '&amp;enmge_cs=' . $_GET['enmge_cs'] . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_action=edit&amp;enmge_r=1&amp;enmge_cid=' . $enmge_cid . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ );} } else { if ( isset($_GET['enmge_cs']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_action=edit&amp;enmge_r=1&amp;enmge_cid=' . $enmge_cid . '&amp;enmge_cs=' . $_GET['enmge_cs'], __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_action=edit&amp;enmge_r=1&amp;enmge_cid=' . $enmge_cid, __FILE__ ); }} ?>" class="add-new-h2" id="enmge-reminder-link">Send Reminder</a><a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('errorbox.php'); ?>
	<?php include ('messagebox.php'); ?>
	<p>You can add a note or change the status of this Contact by filling out the form below. The <?php echo stripslashes($enmge_grouptitle); ?> leader will be notified by email if you add a note. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-contacts"; ?>">User Guide</a>.</p>

	<table class="widefat"> 
		<thead> 
			<tr> 
				<th>From</th> 
				<th><?php echo stripslashes($enmge_grouptitle); ?></th> 
				<th>Email</th> 
				<th>Phone</th>
				<th>Date Received</th>
				<th>Last Update By</th>
				<th>Current Status</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo stripslashes($enmge_single->contact_name); ?></td>
				<td><?php echo stripslashes($enmge_single->contact_group_title); ?></td>
				<td><a href="mailto:<?php echo $enmge_single->contact_email; ?>"><?php echo $enmge_single->contact_email ?></a></td>
				<td><?php echo stripslashes($enmge_single->contact_phone); ?></td>
				<td><?php echo date_i18n($enmge_dateformat, strtotime($enmge_single->contact_date)) ?> at <?php echo date('g:i A', strtotime($enmge_single->contact_date)) ?></td>
				<td><?php echo stripslashes($enmge_single->contact_last_update); ?></td>
				<td><strong><?php echo $enmge_single->contact_status; ?></strong></td>
			</tr>
		</tbody>
	</table>

	<h3>Original Message:</h3>
	<?php echo nl2p(stripslashes('&quot;' . $enmge_single->contact_message . '&quot;')) ?>

	<h3>Group Leaders:</h3>
	<?php foreach ($enmge_groupleaders as $leader) { ?>
	<p><?php echo stripslashes($leader->leader_name); ?> (<a href="mailto:<?php echo $leader->leader_email; ?>"><?php echo $leader->leader_email; ?></a>)</p>
	<?php } ?>

	<?php if(!empty($enmge_notes)) { ?><h3>Notes:</h3><?php } ?>
	<?php foreach ($enmge_notes as $note) { ?>
		<div class="ge-note-box">
			<h4><?php echo stripslashes($note->contact_note_user); ?> on <?php echo date('F j', strtotime($note->contact_note_date)) ?> at <?php echo date('g:i A', strtotime($note->contact_note_date)) ?>:</h4>
			<?php echo nl2p(stripslashes('&quot;' . $note->contact_note . '&quot;')) ?>
		</div>
	<?php } ?>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
		<div id="enmge-basic-information">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Update Status:</strong></th>
					<td>
						<select name="contact_status" id="contact_status" tabindex="1">
							<option value="Initial Followup Needed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Initial Followup Needed") { ?>selected="selected"<?php }} else { if ( $enmge_single->contact_status == "Initial Followup Needed" ) { ?>selected="selected"<?php }} ?>>Initial Followup Needed</option>
							<option value="Additional Followup Needed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Additional Followup Needed") { ?>selected="selected"<?php }} else { if ( $enmge_single->contact_status == "Additional Followup Needed" ) { ?>selected="selected"<?php }} ?>>Additional Followup Needed</option>
							<option value="Closed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Closed") { ?>selected="selected"<?php }} else { if ( $enmge_single->contact_status == "Closed" ) { ?>selected="selected"<?php }} ?>>Closed</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Note:
						<p class="ge-form-instructions">Add a note to this contact's history.</p>
					</th>
					<td>
						<textarea name="contact_note" id="contact_note" rows="4" cols="40" tabindex="2"><?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['contact_note']);} ?></textarea><br />
					</td>
				</tr>
			</table>
		</div>
		
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Update Contact" tabindex="3" /></p>
		<input type="hidden" name="enmgegtid" value="<?php echo $enmge_single->group_type_id; ?>" id="enmgegtid" />
	</form>
	

	<p><a href="<?php if ( isset($_GET['enmge_p']) ) { 
						if ( isset($_GET['enmge_cs']) ) { 
							echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_cs=' . $enmge_cs . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); 
						} else { 
							echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ );
						} 
					} else { 
						if ( isset($_GET['enmge_cs']) ) { 
							echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_cs=' . $enmge_cs, __FILE__ ); 
						} else { 
							echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts', __FILE__ ); 
						}
					} ?>">&laquo; All Contacts</a></p>
	<?php include ('gecredits.php'); ?>
<?php }} else { // Display the main listing of Locations ?>
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/deletecontacts.js'; ?>"></script>

	<h2 class="enmge">View and Edit Contacts <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&enmge_action=new', __FILE__ ) ?>" class="add-new-h2">Add New</a></h2>
	<?php include ('messagebox.php'); ?>

	<p>Click a Contact name below to view and update the Contact. Click "Add New" above to manage a new Contact. Use the "Display" filter below to manage Contacts by their status. You can generate a report of recent Contacts at any time using the <a href="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_reports', __FILE__ ) ?>">Groups Engine Report Library</a>. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-contacts"; ?>">User Guide</a>.</p>

	<div id="contactfilter">
		<strong>Display:</strong>
		<select name="enmge_cs" id="enmge_cs">
			<option value="0" <?php if ( isset($_GET['enmge_cs']) && $_GET['enmge_cs'] == 0 ) { echo "selected=\"selected\""; } ?>>All Contacts</option>
			<option value="1" <?php if ( isset($_GET['enmge_cs']) && $_GET['enmge_cs'] == 1 ) { echo "selected=\"selected\""; } ?>>Initial Followup Needed</option>
			<option value="2" <?php if ( isset($_GET['enmge_cs']) && $_GET['enmge_cs'] == 2 ) { echo "selected=\"selected\""; } ?>>Additional Followup Needed</option>
			<option value="3" <?php if ( isset($_GET['enmge_cs']) && $_GET['enmge_cs'] == 3 ) { echo "selected=\"selected\""; } ?>>Closed</option>
		</select>
	</div>
	
	
	<?php include ('contactpagination.php'); ?>
	<table class="widefat"> 
		<thead> 
			<tr> 
				<th>Name</th> 
				<th><?php echo stripslashes($enmge_grouptitle); ?></th> 
				<th>Received</th>
				<th>Status</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $enmge_contacts as $enmge_single ) { ?>
			<tr>
				<td><a href="<?php if ( isset($_GET['enmge_p']) ) { if ( isset($_GET['enmge_cs']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_action=edit&amp;enmge_cid=' . $enmge_single->contact_id . '&amp;enmge_cs=' . $_GET['enmge_cs'] . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_action=edit&amp;enmge_cid=' . $enmge_single->contact_id . '&amp;enmge_p=' . $_GET['enmge_p'] . '&amp;enmge_c=' . $_GET['enmge_c'], __FILE__ );} } else { if ( isset($_GET['enmge_cs']) ) { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_action=edit&amp;enmge_cid=' . $enmge_single->contact_id . '&amp;enmge_cs=' . $_GET['enmge_cs'], __FILE__ ); } else { echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts&amp;enmge_action=edit&amp;enmge_cid=' . $enmge_single->contact_id, __FILE__ ); }} ?>"><?php echo stripslashes($enmge_single->contact_name); ?></a></td>
				<td><?php echo stripslashes($enmge_single->contact_group_title) ?></td>
				<td><?php echo date_i18n($enmge_dateformat, strtotime($enmge_single->contact_date)); ?></td>	
				<td><?php if ( $enmge_single->contact_status == "Additional Followup Needed" ) { ?><strong><?php echo $enmge_single->contact_status; ?></strong><?php } elseif ( $enmge_single->contact_status == "Initial Followup Needed" ) { ?><strong><span class="new"><?php echo $enmge_single->contact_status; ?></span></strong><?php } else { ?><?php echo $enmge_single->contact_status; ?><?php } ?></td>			
				<td class="enmge-delete"><form action="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;enmge_did=1" method="post" id="groupsengine-deleteform<?php echo $enmge_single->contact_id ?>"><input type="hidden" name="contact_delete" value="<?php echo $enmge_single->contact_id ?>"></form><a href="#" class="groupsengine_delete" name="<?php echo $enmge_single->contact_id ?>">Delete</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<input type="hidden" name="enmgepluginurl" value="<?php echo admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts', __FILE__ ); ?>" id="enmgepluginurl" />
	<?php include ('gecredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
