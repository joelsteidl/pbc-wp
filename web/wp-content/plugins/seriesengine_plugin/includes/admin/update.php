<?php /* ----- Series Engine - Update Check Page ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {						
		
		$url = "http://pluginupdates.seriesengine.com/version.php";
		$enmsefindresponse = wp_remote_post( $url, array('method' => 'POST' ));
		$enmseresponse = unserialize( wp_remote_retrieve_body( $enmsefindresponse ) );

?>
<div class="wrap">
	<div id="seriesengine_icon" class="icon32"></div>
	<h2 class="enmse">Check for Updates</h2>
		
		<?php 

		if ( is_wp_error( $enmseresponse ) ) {
   				echo '<h3 style="color: #afca44; font-size: 1.6em">I\'m Having Trouble Checking the Version Status...</h3>';
   				echo '<p>...but you may still see an update available on the <a href="' . admin_url( '/plugins.php', __FILE__ ) . '">Plugins page</a>.</p>';   			
		} else {
			$enmseversionnumber = $enmseresponse->version;
   			if ( $enmseversionnumber > ENMSE_CURRENT_VERSION ) {
   				echo '<h3 style="color: #afca44; font-size: 1.6em">An Update is Available! (Version ' . $enmseversionnumber . ')</h3>';
   			} else {
   				echo '<h3 style="font-size: 1.6em">It Looks Like You\'re Up to Date!</h3>';
   				echo '<p>Keep an eye on our <a href="http://twitter.com/SeriesEngine">Twitter page</a> for the latest news and updates.</p>';
   			}
		}

		?>

		<p>Series Engine is frequently updated with new features and bug fixes.</p>
		<p>If you're not seeing Series Engine updates in the WordPress updater, <a href="<?php echo admin_url( '/index.php?action=series_engine_update', __FILE__ ); ?>">click here</a>, then check again (you may need to refresh the plugins page once or twice too). Some WordPress installs don't check our servers very often, so <a href="<?php echo admin_url( '/index.php?action=series_engine_update', __FILE__ ); ?>">this link</a> forces WordPress to check for the latest version.</p>
		<p><a href="http://seriesengine.com/changelog.php" target="_blank">Click here</a> to view the changelog for previous updates.</p>

		
		
		<?php include ('secredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>

