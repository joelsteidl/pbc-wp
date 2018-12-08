<?php /* ----- Groups Engine - Display error messages ----- */

if(!empty($enmge_errors)) { ?>
	<div id="message" class="error">
		<p>Your changes could not be saved due to the following errors...</p>
		<ul>
		<?php foreach ($enmge_errors as $error) {
			echo "<li>$error</li>";
		}; ?>
		</ul>
	</div> 
<?php } ?>