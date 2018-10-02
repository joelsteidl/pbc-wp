<?php /* ----- Series Engine - Display some success messages ----- */

if(!empty($enmse_messages)) { ?>
	<div id="message" class="updated">
		<?php foreach ($enmse_messages as $message) {
			echo "<p>$message</p>";
		}; ?>
	</div> 
<?php } elseif (empty($enmse_errors)) { ?>
<br />
<?php } ?>