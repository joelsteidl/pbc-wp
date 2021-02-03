<?php /* ----- Series Engine - Admin Embed Code Page ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {

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

		if ( isset($enmse_options['bibleoption']) ) { // Is Scripture Enabled?
			$bibleoption = $enmse_options['bibleoption'];
		} else {
			$bibleoption = 0;
		}

		if ( isset($enmse_options['playerstyle']) ) { // Style of media player and details section
			$enmseplayerstyle = $enmse_options['playerstyle'];
		} else {
			$enmseplayerstyle = 1;
		}

		global $wpdb;
		
?>
<div class="wrap">
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/embed_code283.js'; ?>"></script>

	
	<h2 class="enmse">Embed Into a Page or Post</h2>
	<p id="enmse-get-plugin-link" title="<?php echo plugins_url() .'/seriesengine_plugin/includes/admin/'; ?>"></p>
	
	<ul id="enmse-message-options">
		<li class="selected"><a href="#" id="enmse-simple-embed">Simple Shortcode</a></li>
		<li><a href="#" id="enmse-custom-embed">Generate Custom Shortcode</a></li>
	</ul>

	<div id="enmse-simple">
		<h3>Using the Simple Shortcode Code</h3>
		
		<p>Series Engine includes <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-customizing"; ?>">a simple shortcode</a> that allows you to add a media page to your site in a matter of seconds. The Series Engine media browser can be easily embedded within any page or post on your WordPress site by entering the following shortcode into the visual editor (or into the "Shortcode" block in Gutenberg):</p>
		<blockquote><strong>[seriesengine]</strong></blockquote>
		<p>You can place content above and below the shortcode to flesh out the page however you wish (just make sure the shortcode is on its own line if you're using visual editor). See the example below:</p>
		<p style="text-align: center"><img src="<?php echo plugins_url() .'/seriesengine_plugin/images/newexamplescreen.jpg'; ?>" width="633" height="399" alt="Example of using the Series Engine shortcode" style="border: 5px solid #ECECEC" /></p>
		
	</div>

	<div id="enmse-custom" style="display: none">
		
		<h2><strong>Start Here:</strong> Choose What to Display...</h2>
		<p>This will be the first content that displays when the page loads.</p>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Choose an Option:</th>
				<td><select name="enmse-embed-start" id="enmse-embed-start" size="1">
					<option value="0">-- Select What You Would Like to Display --</option>
					<option value="1">Display the Most Recent <?php echo $enmsemessaget; ?></option>
					<option value="7">Display all <?php echo $enmsemessagetp; ?> (regardless of <?php echo $enmseseriest; ?>)</option>
					<option value="2">Display a Specific <?php echo $enmseseriest; ?></option>
					<option value="3">Display a Specific <?php echo $enmsetopict; ?></option>
					<option value="4">Display a Specific <?php echo $enmsemessaget; ?></option>
					<option value="6">Display a Specific <?php echo $enmsespeakert; ?></option>
					<?php if ( $bibleoption == 1 ) { ?><option value="8">Display a Specific <?php echo $enmsebookt; ?></option><?php }; ?>
					<option value="5">Display <?php echo $enmseseriest; ?> Archives</option>
				</select></td>
			</tr>
		</table><br />
		

		<div id="enmse-embed-one">

		</div>


		<div id="enmse-embed-two">

		</div>

		<div id="enmse-embed-three">

		</div>

		<div id="enmse-embed-four">

		</div>

		<div id="enmse-embed-code">

		</div>
		
	</div>

	<input type="hidden" name="xxse" value="<?php echo base64_encode(ABSPATH); ?>" id="xxse" />
	<?php include ('secredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>

