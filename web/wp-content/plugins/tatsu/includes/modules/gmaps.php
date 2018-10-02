<?php
if ( ! function_exists( 'tatsu_gmaps' ) ) {
	function tatsu_gmaps( $atts, $content ) {
		$atts =  shortcode_atts( array(
			//'api_key' =>'',
			'address'=>'',
			'latitude'=>'',
			'longitude'=>'',
			'height'=>'300',
			'zoom'=>'14',
			'style'=>'default',
			'marker' => '',
			'animate'=>0,
			'animation_type'=>'fadeIn',
			'key' => be_uniqid_base36(true),
		), $atts  );


		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gmaps', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];

		extract( $atts );

		$output = '';
		
		$animate = ( isset( $animate ) && 1 == $animate ) ? 'be-animate' : '' ;
		$maps_api_key = Tatsu_Config::getInstance()->get_google_maps_api_key();
		if( !empty( $maps_api_key ) ) {
			if(!empty($latitude) && !empty($longitude)) {
				$map_error = false;
			} 
			else if( ! empty( $address ) ) { //&& !empty($api_key) ) {
				$map_error = false;
				$transient_var = generateSlug($address, 10);
				$transient_result = get_transient( $transient_var );
				if(!$transient_result ) {
					//$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true');
					$response = wp_remote_get('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) );//. '&key='.urlencode( $api_key ) );
					if ( is_wp_error( $response ) ) {
						$map_error = true;
						delete_transient( $transient_var );
					} else {
						$coordinates = wp_remote_retrieve_body( $response );
						if ( is_wp_error( $coordinates ) ) {
							$map_error = true;
							delete_transient( $transient_var );
						} else {
							$coordinates_check = json_decode($coordinates);
							if( $coordinates_check->status == 'OK' ) {					
								$latitude = $coordinates_check->results[0]->geometry->location->lat;
								$longitude = $coordinates_check->results[0]->geometry->location->lng;
								set_transient( $transient_var, $coordinates, 24 * HOUR_IN_SECONDS );
								
							} else {
								$map_error = true;
								delete_transient( $transient_var );
							}
						}
					}
				} else {
					$coordinates_check = json_decode($transient_result);
					$latitude = $coordinates_check->results[0]->geometry->location->lat;
					$longitude = $coordinates_check->results[0]->geometry->location->lng;
				}
				
			} else {
				$map_error = true;
			}

			if(  true === $map_error ) {
				$output .= '<div class="tatsu-module tatsu-notification error">'.__('Your Server is Unable to connect to the Google Geocoding API, kindly visit <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">THIS LINK </a>, find out the latitude and longitude of your address and enter it manually in the Google Maps Module of the Page Builder ', 'tatsu').'</div>';
			} else {
				if( (function_exists( 'be_gdpr_privacy_ok' ) ? be_gdpr_privacy_ok('gmaps') : true) || (defined( 'REST_REQUEST' ) && REST_REQUEST) || (function_exists('wp_doing_ajax') && wp_doing_ajax() ) ){
					
					$output .= '<div class="tatsu-module tatsu-gmap-wrapper '.$custom_class_name.' '.$animate.'" data-animation="'.$animation_type.'"><div class="tatsu-gmap map_960" data-address="'.$address.'" data-zoom="'.$zoom.'" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'" data-marker="'.$marker.'" data-style="'.$style.'"></div>'.$custom_style_tag.'</div>';
				
				}else{

					$api_url = 'https://maps.googleapis.com/maps/api/staticmap?markers=size:mid%7C'.$latitude.','.$longitude.'&zoom=13&size=600x300&apikey='.$maps_api_key;

					$response = wp_remote_get( $api_url ,
						array( 'timeout' => 10,
						'headers' => array( 'Content-Type' => 'image/png') 
						));
					if( !is_wp_error( $response ) ){
							$output .= '<div class="tatsu-module tatsu-gmap-wrapper '.$custom_class_name.' '.$animate.'" data-animation="'.$animation_type.'" style="background-size:cover;background-image:url(data:image/png;base64,'.base64_encode( $response['body']).');" >  
							'.$custom_style_tag.'
							<div class="static-map-overlay">
							<div class="static-map-content">' . do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="google maps"]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup] ' ))) .'</div>
							</div>
							</div>';
					} else {
						$output .= do_shortcode( str_replace( '[be_gdpr_api_name]','[be_gdpr_api_name api="google maps"]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup] ' ) ) );
					}
				}
			}
		} else {
			$output = '<div class="tatsu-module tatsu-notification tatsu-error">'.__( 'Google Maps API KEY is missing', 'tatsu' ).'</div>';
		}
		return $output;
	}
	add_shortcode( 'tatsu_gmaps', 'tatsu_gmaps' );
}

?>