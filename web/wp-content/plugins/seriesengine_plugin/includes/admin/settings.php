<?php /* ----- Series Engine - Settings page ----- */
global $wp_version;
wp_enqueue_media();
if ( $wp_version != null ) { // Verify that user is allowed to access this page
if ( current_user_can( 'edit_posts' ) ) { 

	if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] == "true") {
		$enmse_options = get_option( 'enm_seriesengine_options' ); 
		generate_se_options_css($enmse_options);
	}
	?>
<div class="wrap"> 
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo plugins_url() .'/seriesengine_plugin/css/colorpicker.css'; ?>" />
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/colorpicker.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugins_url() .'/seriesengine_plugin/js/adminsettings.js'; ?>"></script>
	
	<h2 class="enmse">Series Engine Settings</h2> 
	<ul id="enmse-message-options">
		<li class="selected"><a href="#" id="enmse-settings-general">General Settings</a></li>
		<li><a href="#" id="enmse-settings-styles">Fonts and Colors</a></li>
		<li><a href="#" id="enmse-settings-labels">Labels and Language</a></li>
		<li><a href="#" id="enmse-settings-archivesection">Advanced</a></li>
	</ul>
	<form action="options.php" method="post"> 
		<?php settings_fields('enm_seriesengine_options'); do_settings_sections('seriesengine_plugin'); ?> 
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Save Changes" /></p>
	</form>
	<?php include ('secredits.php'); ?>	
</div>
<?php } // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>

