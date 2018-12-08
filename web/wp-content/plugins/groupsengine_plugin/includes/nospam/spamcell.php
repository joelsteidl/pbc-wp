<?php if ( $enmge_spamprotection == 1 ) { // Optional reCAPTCHA spam protection ?>
	<?php 
		require_once 'autoload.php';
		$enmge_siteKey = '6Le4MycTAAAAADzLHCoic0WLlNPqKPMJwjojvWbK';
		$enmge_secret = '6Le4MycTAAAAAGLrf7C-gWAQGlMNSvVPXzsr8lll';
		$lang = 'en';
		$recaptcha = new \ReCaptcha\ReCaptcha($enmge_secret);
	?>
	<tr>
		<td class="ge-contact-label" id="enmge-spam-label"><label for="contact_spam">Spam Check</label></td>
		<td class="ge-contact-input spamcell">
			<div class="g-recaptcha" data-sitekey="<?php echo $enmge_siteKey; ?>"></div>
				<script type="text/javascript"
					src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
				</script>
		</td>
	</tr>
<?php } ?>