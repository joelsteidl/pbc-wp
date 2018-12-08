<?php /* Groups Engine - Update Contact From Group Leaders */
	require '../../../../wp-blog-header.php'; // ADJUST THIS PATH if using a non-standard WordPress install

	$enmge_redirecturl = home_url();
	$enmge_options = get_option( 'enm_groupsengine_options' ); 
	$ministryname = $enmge_options['ministryname'];

	$updatebg = $enmge_options['updatebg'];
	$updatetext = $enmge_options['updatetext'];
	$updatestatustext = $enmge_options['updatestatustext'];
	$updatelink = $enmge_options['updatelink'];
	$updatenotebg = $enmge_options['updatenotebg'];
	$updatenotetext = $enmge_options['updatenotetext'];
	$updateformfieldbg = $enmge_options['updateformfieldbg'];
	$updateformfieldtext = $enmge_options['updateformfieldtext'];
	$updateformsubmitbg = $enmge_options['updateformsubmitbg'];
	$updateformsubmittext = $enmge_options['updateformsubmittext'];
	$credits = $enmge_options['credits'];
	$grouptitle = $enmge_options['grouptitle'];
	$groupptitle = $enmge_options['groupptitle'];
	$emailaddress = $enmge_options['emailaddress'];
	$emailname = $enmge_options['emailname'];
	$creditstext = $enmge_options['creditstext'];

	function nl2p($text) {
		return "<p>" . str_replace("\n", "</p><p>", $text) . "</p>";
	}

	
	if ( isset($_GET['enmge_mc']) && strlen($_GET['enmge_mc']) == 32 ) { 

		$enmge_mc = strip_tags($_GET['enmge_mc']);
		if ( isset($_GET['enmge_qc']) ) {
			$enmge_qc = strip_tags($_GET['enmge_qc']);
		} else {
			$enmge_qc = 0;
		}
		
		if ( $_POST ) {
			global $wpdb;

			$enmge_qc = 0;
		
			$enmge_status = strip_tags($_POST['contact_status']);
			$enmge_note = strip_tags($_POST['contact_note']);
			$enmge_cid = strip_tags($_POST['contact_id']);
			$enmge_group_leader = strip_tags(urldecode($_GET['enmge_n']));
			$enmge_last_update_day = date("Y-m-d", time());
			$enmge_uqc = strip_tags($_POST['qc']);
			
			if ( $enmge_uqc != 1 ) {
				$enmge_new_values = array( 'contact_status' => $enmge_status, 'contact_last_update' => $enmge_group_leader, 'contact_last_update_day' => $enmge_last_update_day  ); 
				$enmge_where = array( 'contact_id' => $enmge_cid ); 
				$wpdb->update( $wpdb->prefix . "ge_contacts", $enmge_new_values, $enmge_where ); 
				$enmge_messages[] = "Contact successfully updated!";

				if ( $enmge_note != null ) {
					$enmge_note_date = date("Y-m-d H:i:s", time());
					$enmge_user = $enmge_group_leader;
					$enmge_newnote = array(
						'contact_note_date' => $enmge_note_date,
						'contact_id' => $enmge_cid,
						'contact_note_user' => $enmge_user,
						'contact_note' => $enmge_note
					); 
					$wpdb->insert( $wpdb->prefix . "ge_contact_notes", $enmge_newnote );
				}
			} else {
				$enmge_new_values = array( 'contact_last_update' => $enmge_group_leader, 'contact_last_update_day' => $enmge_last_update_day  ); 
				$enmge_where = array( 'contact_id' => $enmge_cid ); 
				$wpdb->update( $wpdb->prefix . "ge_contacts", $enmge_new_values, $enmge_where ); 
				$enmge_messages[] = "Contact successfully updated!";

				if ( $enmge_note != null ) {
					$enmge_note_date = date("Y-m-d H:i:s", time());
					$enmge_user = $enmge_group_leader;
					$enmge_newnote = array(
						'contact_note_date' => $enmge_note_date,
						'contact_id' => $enmge_cid,
						'contact_note_user' => $enmge_user,
						'contact_note' => $enmge_note
					); 
					$wpdb->insert( $wpdb->prefix . "ge_contact_notes", $enmge_newnote );
				}
			}			
				
		}


		$enmge_findthecontactsql = "SELECT * FROM " . $wpdb->prefix . "ge_contacts" . " WHERE contact_modcode = %s"; 
		$enmge_findthecontact = $wpdb->prepare( $enmge_findthecontactsql, $enmge_mc );
		$enmge_single = $wpdb->get_row( $enmge_findthecontact, OBJECT );
		$enmge_singlecount = $wpdb->num_rows;

		if ( $enmge_singlecount == 1 ) {
			$enmge_preparrednotessql = "SELECT * FROM " . $wpdb->prefix . "ge_contact_notes" . " WHERE contact_id = %d ORDER BY contact_note_id ASC"; 
			$enmge_notessql = $wpdb->prepare( $enmge_preparrednotessql, $enmge_single->contact_id );
			$enmge_notes = $wpdb->get_results( $enmge_notessql );

			if ( $enmge_qc != 0 ) { // Quick Contacts
				if ( $enmge_qc == 1 ) { // They're Joining Our Group!
					$enmge_status = "Closed";
					$enmge_cid = $enmge_single->contact_id;
					$enmge_group_leader = strip_tags(urldecode($_GET['enmge_n']));
					$enmge_last_update_day = date("Y-m-d", time());
					$enmge_note = "They're joining our " .  stripslashes($grouptitle) . "!";
								
					$enmge_new_values = array( 'contact_status' => $enmge_status, 'contact_last_update' => $enmge_group_leader, 'contact_last_update_day' => $enmge_last_update_day  ); 
					$enmge_where = array( 'contact_id' => $enmge_cid ); 
					$wpdb->update( $wpdb->prefix . "ge_contacts", $enmge_new_values, $enmge_where ); 

					$enmge_note_date = date("Y-m-d H:i:s", time());
					$enmge_user = $enmge_group_leader;
					$enmge_newnote = array(
						'contact_note_date' => $enmge_note_date,
						'contact_id' => $enmge_cid,
						'contact_note_user' => $enmge_user,
						'contact_note' => $enmge_note
					); 
					$wpdb->insert( $wpdb->prefix . "ge_contact_notes", $enmge_newnote );
				}
				if ( $enmge_qc == 2 ) { // I answered their question... No additional followup needed.
					$enmge_status = "Closed";
					$enmge_cid = $enmge_single->contact_id;
					$enmge_group_leader = strip_tags(urldecode($_GET['enmge_n']));
					$enmge_last_update_day = date("Y-m-d", time());
					$enmge_note = "I answered their question... No additional followup needed.";
								
					$enmge_new_values = array( 'contact_status' => $enmge_status, 'contact_last_update' => $enmge_group_leader, 'contact_last_update_day' => $enmge_last_update_day  ); 
					$enmge_where = array( 'contact_id' => $enmge_cid ); 
					$wpdb->update( $wpdb->prefix . "ge_contacts", $enmge_new_values, $enmge_where ); 

					$enmge_note_date = date("Y-m-d H:i:s", time());
					$enmge_user = $enmge_group_leader;
					$enmge_newnote = array(
						'contact_note_date' => $enmge_note_date,
						'contact_id' => $enmge_cid,
						'contact_note_user' => $enmge_user,
						'contact_note' => $enmge_note
					); 
					$wpdb->insert( $wpdb->prefix . "ge_contact_notes", $enmge_newnote );
				}
				if ( $enmge_qc == 3 ) { // I couldn't answer their question... More followup needed.
					$enmge_status = "Additional Followup Needed";
					$enmge_cid = $enmge_single->contact_id;
					$enmge_group_leader = strip_tags(urldecode($_GET['enmge_n']));
					$enmge_last_update_day = date("Y-m-d", time());
					$enmge_note = "I couldn't answer their question... More followup needed.";
								
					$enmge_new_values = array( 'contact_status' => $enmge_status, 'contact_last_update' => $enmge_group_leader, 'contact_last_update_day' => $enmge_last_update_day  ); 
					$enmge_where = array( 'contact_id' => $enmge_cid ); 
					$wpdb->update( $wpdb->prefix . "ge_contacts", $enmge_new_values, $enmge_where ); 

					$enmge_note_date = date("Y-m-d H:i:s", time());
					$enmge_user = $enmge_group_leader;
					$enmge_newnote = array(
						'contact_note_date' => $enmge_note_date,
						'contact_id' => $enmge_cid,
						'contact_note_user' => $enmge_user,
						'contact_note' => $enmge_note
					); 
					$wpdb->insert( $wpdb->prefix . "ge_contact_notes", $enmge_newnote );
				}
				if ( $enmge_qc == 4 ) { // I couldn't get in touch with them.
					$enmge_status = "Closed";
					$enmge_cid = $enmge_single->contact_id;
					$enmge_group_leader = strip_tags(urldecode($_GET['enmge_n']));
					$enmge_last_update_day = date("Y-m-d", time());
					$enmge_note = "I couldn't get in touch with them.";
								
					$enmge_new_values = array( 'contact_status' => $enmge_status, 'contact_last_update' => $enmge_group_leader, 'contact_last_update_day' => $enmge_last_update_day  ); 
					$enmge_where = array( 'contact_id' => $enmge_cid ); 
					$wpdb->update( $wpdb->prefix . "ge_contacts", $enmge_new_values, $enmge_where ); 

					$enmge_note_date = date("Y-m-d H:i:s", time());
					$enmge_user = $enmge_group_leader;
					$enmge_newnote = array(
						'contact_note_date' => $enmge_note_date,
						'contact_id' => $enmge_cid,
						'contact_note_user' => $enmge_user,
						'contact_note' => $enmge_note
					); 
					$wpdb->insert( $wpdb->prefix . "ge_contact_notes", $enmge_newnote );
				}
			}

			if ( $_POST ) { 
				include('emailadminupdate.php');
			}
			
		} else {
			header("Location: $enmge_redirecturl");
		}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width" />
	<title>Update Contact - Groups Engine</title>
</head>
<style type="text/css">
	body {
		padding: 20px;
		font-family: Arial, Helvetica, San-serif;
		background-color: #<?php echo $updatebg; ?>;
		color: #<?php echo $updatetext; ?>;
	}

	h1, h2, h3, h4, h5, h6, p, form, ul, ol, li, ol li, ul li, blockquote, input, input[type="submit"], textarea, select, select:focus, label, table, table tr, table tr td, iframe, object, embed, img { /* resets most browser styles to enhance cross-browser compatibility */
		margin: 0;
		padding: 0;
		font-size: 1em;
		text-transform: none;
		letter-spacing: 0;
		line-height: 1;
		clear: none;
		font-weight: 300;
		font-family: Arial, Helvetica, sans-serif;
		font-variant: normal;
		float: none;
		border: none;
		-moz-border-radius: 0;
		-webkit-border-radius: 0;
		border-radius: 0;
		background: none;
		min-height: 0;
		text-align: left;
		max-width: 100%;
		text-indent: 0;
		box-shadow: none
	}

	a {
		color: #<?php echo $updatelink; ?>;
	}

	#groupsengine {
		max-width: 900px;
		margin: 0 auto;
	}

	h1 {
		font-size: 2em;
		font-weight: 700;
		padding: 0 0 15px 0;
		text-align: center;
	}

	h2 {
		text-align: center;
		font-size: 1.4em;
		font-weight: 300;
		padding: 0 0 10px 0;
		color: #84cac8;
		text-transform: uppercase;
		color: #<?php echo $updatestatustext; ?>;
	}

	h3	{
		font-size: 1.6em;
		font-weight: 700;
		padding: 0 0 15px 0;
	}

	h4 {
		font-weight: 300;
		font-size: 1.2em;
		color: #000;
		text-align: center;
	}

	h5 {
		padding: 20px 0 0 0;
		text-align: center;
	}

	table.contactinfo {
		margin: 40px 0 20px 0;
	}
	table.contactinfo tr td {
		padding: 5px;
	}

	table.contactinfo tr td.labelcell {
		text-align: right;
		vertical-align: top;
	}

	table.contactinfo tr td.labelcell label {
		font-weight: 700;
	}

	.message {
		padding: 0 0 40px 0;
	}

	.message p {
		line-height: 130%;
	}

	.ge-note-area {
		padding: 0 0 40px 0;
		margin: 0;
	}

	.ge-note-box {
		padding: 10px 10px 0 10px;
		margin:  0 0 10px 0;
		background-color: #<?php echo $updatenotebg; ?>;
	}

	.ge-note-box h4 {
		text-align: left;
		font-weight: 300;
		font-style: italic;
		font-size: 1em;
		margin: 0;
		padding: 0 0 10px 0;
		color: #<?php echo $updatenotetext; ?>;
	}

	.ge-note-box h4 strong {
		font-style: normal;
	}

	.ge-note-box p {
		text-align: left;
		margin: 0;
		padding: 0 0 10px 0;
		color: #<?php echo $updatenotetext; ?>;
	}

	table.update {
		margin: 0 0 20px 0;
		width: 100%;
	}
	table.update tr td {
		padding: 5px;
		width: 80%;
	}

	table.update tr td.labelcell {
		text-align: right;
		vertical-align: top;
		width: 20%;
	}

	table.update tr td.labelcell label {
		font-weight: 700;
		font-size: 0.9em;
	}

	textarea {
		background-color: #<?php echo $updateformfieldbg; ?>;
		font-size: 1em;
		padding: 10px;
		height: 150px;
		width: 97%;
		color: #<?php echo $updateformfieldtext; ?>;
		border: none;
	}

	textarea:focus { 
		outline: none; 
	}

	select {
		border: 1px solid #<?php echo $updateformfieldbg; ?>;
		background-color: #<?php echo $updateformfieldbg; ?>;
		color: #<?php echo $updateformfieldtext; ?>;
	}

	input.ge-submit {
		display: block;
		width: 180px;
		height: 40px;
		line-height: 40px;
		font-size: 0.95em;
		background-color: #<?php echo $updateformsubmitbg; ?>;
		color: #<?php echo $updateformsubmittext; ?>;
		text-align: center;
		text-transform: uppercase;
		margin: 0;
		border-radius: 20px;
		-webkit-appearance: none;
	}

	p.qc {
		margin: 20px 0 30px 0;
		text-align: center;
	}

	#groupsengine h3.enmge-poweredby {
		margin: 5px auto 0 auto !important;
		text-indent: -9000px;
		width: 148px;
		height: 40px;
		<?php if ( $credits == "light" ) { ?>
		background: url('../images/interface/ge_light_poweredby.png') no-repeat;	
		<?php } elseif ( $credits == "dark" ) { ?>
		background: url('../images/interface/ge_dark_poweredby.png') no-repeat;
		<?php } ?>
		padding: 0;
	}

	#groupsengine h3.enmge-poweredby a {
		display: block;
		width: 148px;
		height: 40px;
	}

	#groupsengine p.enmge-poweredbytext {
		margin: 5px 0 10px 0;
		text-align: right;
		font-size: 13px !important;
		color: #<?php echo $creditstext; ?>;
	}

	#groupsengine p.enmge-poweredbytext a:link, #groupsengine p.enmge-poweredbytext a:visited, #groupsengine p.enmge-poweredbytext a:hover, #groupsengine p.enmge-poweredbytext a:active {
		color: #<?php echo $creditstext; ?>;
	}

	/* ----- Responsive Mobile ----- */

@media (max-width:714px) { 
	body {
		padding: 10px;
		font-family: Arial, Helvetica, San-serif;
	}

	select {
		width: 100%;
	}

	textarea {
		width: 90%;
	}
}

@media (-webkit-min-device-pixel-ratio: 2) { 
	#groupsengine h3.enmge-poweredby {
		<?php if ( $credits == "light" ) { ?>
		background: url('../images/interface/ge_light_poweredby2x.png') no-repeat;	
		<?php } elseif ( $credits == "dark" ) { ?>
		background: url('../images/interface/ge_dark_poweredby2x.png') no-repeat;
		<?php } ?>
		background-size: 148px 40px;
	}
}
</style>
<body id="ge-report">
<div id="groupsengine">
	<div <?php if ( $enmge_qc != 0 ) { ?>style="display: none"<?php } ?>>
	<h1>Contact from <?php echo stripslashes($enmge_single->contact_name); ?></h1>

	<h2><?php echo stripslashes($enmge_single->contact_status); ?></h2>
	<?php if ( $enmge_single->contact_last_update != null ) { ?><h4>Last update by <strong><?php echo stripslashes($enmge_single->contact_last_update); ?></strong></h4><?php } ?>
	<table cellpadding="0" cellspacing="0" class="contactinfo">
	<tr>
		<td class="labelcell"><label>Name:</label></td>
		<td><?php echo stripslashes($enmge_single->contact_name); ?></td>
	</tr>
	<tr>
		<td class="labelcell"><label>Email:</label></td>
		<td><a href="mailto:<?php echo $enmge_single->contact_email; ?>"><?php echo $enmge_single->contact_email; ?></a></td>
	</tr>
	<tr>
		<td class="labelcell"><label>Phone:</label></td>
		<td><?php echo stripslashes($enmge_single->contact_phone); ?></td>
	</tr>
	<tr>
		<td class="labelcell"><label>Received:</label></td>
		<td><?php echo date('F j, Y', strtotime($enmge_single->contact_date)) ?> at <?php echo date('g:i A', strtotime($enmge_single->contact_date)) ?></td>
	</tr>
	<tr>
		<td class="labelcell"><label><?php echo stripslashes($grouptitle); ?>:</label></td>
		<td><?php echo stripslashes($enmge_single->contact_group_title); ?></td>
	</tr>
	</table>

	<div class="message">
	<?php echo nl2p(stripslashes('&quot;' . $enmge_single->contact_message . '&quot;')) ?>
	</div>

	<?php if(!empty($enmge_notes)) { ?><h3>Updates:</h3><?php } ?>
	<?php if(!empty($enmge_notes)) { ?><div class="ge-note-area"><?php } ?>
	<?php foreach ($enmge_notes as $note) { ?>
	<div class="ge-note-box">
		<h4><strong><?php echo stripslashes($note->contact_note_user); ?></strong> on <?php echo date('F j', strtotime($note->contact_note_date)) ?> at <?php echo date('g:i A', strtotime($note->contact_note_date)) ?>:</h4>
		<?php echo nl2p(stripslashes('&quot;' . $note->contact_note . '&quot;')) ?>
	</div>
	<?php } ?>
	<?php if(!empty($enmge_notes)) { ?></div><?php } ?>

	<h3>Add an Update:</h3>
	</div>
	<div <?php if ( $enmge_qc == 0  ) { ?>style="display: none"<?php } ?>>
		<h1>Thanks for letting us know!</h1>
		<p class="qc">We've saved your update. You can view the full history for <a href="<?php echo plugins_url() . "/groupsengine_plugin/contacts/edit.php?enmge_mc=" . $enmge_mc; ?>">this contact here</a>. If you have more notes, please enter them below.</p>
	</div>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="enmgeform">
	<table class="update">
		<tr <?php if ( $enmge_qc != 0 ) { ?>style="display: none"<?php } ?>>
			<td class="labelcell"><label for="contact_status">Update Status:</label></td>
			<td>
				<select name="contact_status" id="contact_status" tabindex="1">
					<option value="Initial Followup Needed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Initial Followup Needed") { ?>selected="selected"<?php }} else { if ( $enmge_single->contact_status == "Initial Followup Needed" ) { ?>selected="selected"<?php }} ?>>Initial Followup Needed</option>
					<option value="Additional Followup Needed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Additional Followup Needed") { ?>selected="selected"<?php }} else { if ( $enmge_single->contact_status == "Additional Followup Needed" ) { ?>selected="selected"<?php }} ?>>Additional Followup Needed</option>
					<option value="Closed" <?php if ($_POST && !empty($enmge_errors)) {if ($_POST['contact_status'] == "Closed") { ?>selected="selected"<?php }} else { if ( $enmge_single->contact_status == "Closed" ) { ?>selected="selected"<?php }} ?>>Closed</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="labelcell"><label for="contact_note">Note:</label></td>
			<td>
				<textarea name="contact_note" id="contact_note" rows="4" cols="40" tabindex="2"><?php if ($_POST && !empty($enmge_errors)) {echo stripslashes($_POST['contact_note']);} ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="labelcell"></td>
			<td>
				<input type="hidden" name="contact_id" id="contact_id" value="<?php echo $enmge_single->contact_id; ?>">
				<input type="hidden" name="contact_group_leader" id="contact_group_leader" value="<?php echo strip_tags(urldecode($_GET['enmge_n'])); ?>">
				<input name="Submit" type="submit" class="ge-submit" value="Update Contact" tabindex="3" />
				<input type="hidden" name="qc" id="qc" value="<?php if ( $enmge_qc != 0 ) { echo "1"; } ?>" />
			</td>
		</tr>
	</table>
	</form>

	<?php if ( $credits != "text" ) { ?>
	<h3 class="enmge-poweredby"><a href="http://groupsengine.com" target="_blank">Powered by Groups Engine</a></h3>	
	<?php } else { ?>
	<p class="enmge-poweredbytext">Powered by <a href="http://groupsengine.com" target="_blank">Groups Engine</a></p>
	<?php } ?>
</div>

</body>
</html>
<?php } else {
	header("Location: $enmge_redirecturl");
} ?>