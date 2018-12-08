<?php /* ----- Groups Engine - Settings page ----- */
global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
if ( current_user_can( 'edit_posts' ) ) { 

	if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] == "true") {
		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		generate_ge_options_css($enmge_options);
	}
		

	?>
<div class="wrap"> 
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo plugins_url() .'/groupsengine_plugin/css/colorpicker.css'; ?>" />
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/colorpicker.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/adminsettings.js'; ?>"></script>
	
	<h2 class="enmge" style="padding-bottom: 5px">Groups Engine Settings</h2> 
	<ul id="enmge-group-options">
		<li class="selected"><a href="#" id="enmge-settings-general">General Settings</a></li>
		<li><a href="#" id="enmge-settings-styles">Styles and Colors</a></li>
		<li><a href="#" id="enmge-settings-labels">Labels</a></li>
		<li><a href="#" id="enmge-settings-archivesection">Advanced</a></li>
	</ul>
	<form action="options.php" method="post"> 
		<?php settings_fields('enm_groupsengine_options'); do_settings_sections('groupsengine_plugin'); ?> 
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="Save Changes" /></p>
	</form>
	<?php include ('gecredits.php'); ?>	
</div>
<?php } // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>

