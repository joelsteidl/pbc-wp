<?php 

if ( $enmge_spamprotection == 1 ) { // Optional reCAPTCHA spam protection
	require_once 'autoload.php';
	$enmge_siteKey = '6Le4MycTAAAAADzLHCoic0WLlNPqKPMJwjojvWbK';
	$enmge_secret = '6Le4MycTAAAAAGLrf7C-gWAQGlMNSvVPXzsr8lll';
	$recaptcha = new \ReCaptcha\ReCaptcha($enmge_secret, new \ReCaptcha\RequestMethod\SocketPost());
	$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
			
	if (!$resp->isSuccess()) {
		$enmge_errors[] = 'Please prove you\'re not a spam robot.';
	}
}

 ?>
