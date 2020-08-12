<?php /* ----- Series Engine - Choose embed options ----- */
	
	if ( current_user_can( 'edit_pages' ) ) { 	

		// ***** Get Labels
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

		if ( isset($enmse_options['topict']) ) { // Find Topic Title
			$enmsetopict = $enmse_options['topict'];
		} else {
			$enmsetopict = "Topic";
		}

		if ( isset($enmse_options['topictp']) ) { // Find Topic Title (plural)
			$enmsetopictp = $enmse_options['topictp'];
		} else {
			$enmsetopictp = "Topics";
		}

		if ( isset($enmse_options['speakert']) ) { // Find Speaker Title
			$enmsespeakert = $enmse_options['speakert'];
		} else {
			$enmsespeakert = "Speaker";
		}

		if ( isset($enmse_options['speakertp']) ) { // Find Speakers Title (plural)
			$enmsespeakertp = $enmse_options['speakertp'];
		} else {
			$enmsespeakertp = "Speakers";
		}

		if ( isset($enmse_options['messaget']) ) { // Find Message Title
			$enmsemessaget = $enmse_options['messaget'];
		} else {
			$enmsemessaget = "Message";
		}

		if ( isset($enmse_options['messagetp']) ) { // Find Message Title (plural)
			$enmsemessagetp = $enmse_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		}

		if ( isset($enmse_options['bookt']) ) { // Find Message Title
			$enmsebookt = $enmse_options['bookt'];
		} else {
			$enmsebookt = "Book";
		}

		if ( isset($enmse_options['booktp']) ) { // Find Message Title (plural)
			$enmsebooktp = $enmse_options['booktp'];
		} else {
			$enmsebooktp = "Books";
		}

		if ( isset($enmse_options['cardview']) ) { // Default cardview
			$enmse_cardview = $enmse_options['cardview'];
		} else {
			$enmse_cardview = 0;
		}

		if ( isset($enmse_options['playerstyle']) ) { // Style of media player and details section
			$enmseplayerstyle = $enmse_options['playerstyle'];
		} else {
			$enmseplayerstyle = 1;
		}
	
?>

<h2>...and Choose Your Options:</h2>
<p>You can fine tune what is displayed by changing any of the options below. This will allow you to hide and modify the search menus, control sort order, and much more.</p>
<table class="form-table">
	<tr valign="top">
		<th scope="row">Show <?php echo $enmsemessaget; ?> Explorer Search Menus?:</th>
		<td><select name="enmse-embed-explorer" id="enmse-embed-explorer" size="1">
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		</td>
	</tr>
	<tr valign="top" id="dropdownoptions">
		<th scope="row"></th>
		<td>
			<input name="enmse-embed-seriesmenu" id="enmse-embed-seriesmenu" type="checkbox" class="check" checked="checked" /> <label for="enmse-embed-seriesmenu">Show "Browse <?php echo $enmseseriest; ?>" Menu</label><br />
			<input name="enmse-embed-speakermenu" id="enmse-embed-speakermenu" type="checkbox" class="check" checked="checked" /> <label for="enmse-embed-speakermenu">Show "Browse <?php echo $enmsespeakert; ?>" Menu</label><br />
			<input name="enmse-embed-topicmenu" id="enmse-embed-topicmenu" type="checkbox" class="check" checked="checked" /> <label for="enmse-embed-topicmenu">Show "Browse <?php echo $enmsetopict; ?>" Menu</label><br />
			<input name="enmse-embed-bookmenu" id="enmse-embed-bookmenu" type="checkbox" class="check" checked="checked" /> <label for="enmse-embed-bookmenu">Show "Browse <?php echo $enmsebookt; ?>" Menu</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Show Initial <?php echo $enmsemessaget; ?>?:</th>
		<td><select name="enmse-embed-initial" id="enmse-embed-initial" size="1">
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		</td>
	</tr>
	<tr valign="top" <?php if ( $enmseplayerstyle == 0 ) {  echo "style=\"display: none;\"";} ?>>
		<th scope="row">Show <?php echo $enmseseriest; ?> Details Below Player?:</th>
		<td><select name="enmse-embed-seriesinfo" id="enmse-embed-seriesinfo" size="1">
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		</td>
	</tr>
	<tr valign="top" <?php if ( $enmseplayerstyle == 0 ) {  echo "style=\"display: none;\"";} ?>>
		<th scope="row">Show Sharing Links Below Player?:</th>
		<td><select name="enmse-embed-sharinglinks" id="enmse-embed-sharinglinks" size="1">
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Show Audio Download Link?:</th>
		<td><select name="enmse-embed-download" id="enmse-embed-download" size="1">
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		</td>
	</tr>
	<tr valign="top" <?php if ( $enmseplayerstyle == 1 ) {  echo "style=\"display: none;\"";} ?>>
		<th scope="row"><?php echo $enmsemessaget; ?> Details/Sharing:</th>
		<td><select name="enmse-embed-details" id="enmse-embed-details">
			<option value="1">Hide Details and Sharing by Default</option>
			<option value="2">Show Expanded Details by Default</option>
			<option value="3">Show Sharing by Default</option>
		</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Show Related <?php echo $enmsemessagetp; ?>?:</th>
		<td><select name="enmse-embed-related" id="enmse-embed-related" size="1">
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Style of Related <?php echo $enmsemessagetp; ?>:</th>
		<td><select name="enmse-embed-cardview" id="enmse-embed-cardview" size="1">
			<option value="0" <?php if ( $enmse_cardview == 0 ) { echo "selected=\"selected\""; } ?>>Classic List View</option>
			<option value="1" <?php if ( $enmse_cardview == 0 ) { echo "selected=\"selected\""; } ?>>Grid View</option>
			<option value="2" <?php if ( $enmse_cardview == 0 ) { echo "selected=\"selected\""; } ?>>Row View</option>
		</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Related <?php echo $enmsemessagetp; ?> Sort Order:</th>
		<td><select name="enmse-embed-related-sort" id="enmse-embed-related-sort" size="1">
			<option value="0">Oldest First</option>
			<option value="1">Newest First</option>
		</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Number of Related <?php echo $enmsemessagetp; ?> Per Page?:</th>
		<td><input name="enmse-embed-pag" id="enmse-embed-pag" size="3" value="10" /></td>
	</tr>
	<tr valign="top">
		<th scope="row">Number of <?php echo $enmseseriestp; ?> Per Page in Archives?:</th>
		<td><input name="enmse-embed-apag" id="enmse-embed-apag" size="3" value="12" /></td>
		</td>
	</tr>
</table><br /><br />

<a href="#" id="enmse-generate-embed-code" class="button-primary">Generate Code</a><br /><br />

<?php } else {
	exit("Access Denied");
} die(); ?>