<?php /* ----- Groups Engine - Display some success messages ----- */

if(!empty($enmge_messages)) { ?>
	<div id="message" class="updated">
		<?php foreach ($enmge_messages as $message) {
			echo "<p>$message</p>";
		}; ?>
	</div> 
<?php } elseif (empty($enmge_errors)) { ?>
<?php } ?>