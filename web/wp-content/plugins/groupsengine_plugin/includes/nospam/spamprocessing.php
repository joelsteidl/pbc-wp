<?php 

if ( $enmge_spamprotection == 1 ) { // Optional reCAPTCHA spam protection
	if(isset($_POST['g-recaptcha-response'])){
      $enmge_captcha = $_POST['g-recaptcha-response'];
    }

    function peurl_get_contents ($url) {
	    if (!function_exists('curl_init')){ 
	        $enmge_errors[] = 'There is a server configuration error that will not allow spam filtering. Please let the web developer know.';
	    }
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $output = curl_exec($ch);
	    curl_close($ch);
	    return $output;
	}

	$enmge_secretKey = "6Le4MycTAAAAAGLrf7C-gWAQGlMNSvVPXzsr8lll";
    $enmge_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($enmge_secretKey) .  '&response=' . urlencode($enmge_captcha);
   	if (!ini_get('allow_url_fopen')){
   		$response = peurl_get_contents($enmge_url);
   	} else {
   		$response = file_get_contents($enmge_url);
   	}
    $responseKeys = json_decode($response,true);

    // should return JSON with success as true
    if($responseKeys["success"]) {
    } else {
            $enmge_errors[] = 'Please prove you\'re not a spam robot.';
    }
}

 ?>
