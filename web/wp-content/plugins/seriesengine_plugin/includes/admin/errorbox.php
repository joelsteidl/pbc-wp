<?php /* ----- Series Engine - Display error messages ----- */

if(!empty($enmse_errors)) { ?>
	<div id="message" class="error">
		<p>Your changes could not be saved due to the following errors...</p>
		<ul>
		<?php foreach ($enmse_errors as $error) {
			echo "<li>$error</li>";
		}; ?>
		</ul>
	</div> 
<?php } ?>