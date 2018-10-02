<?php
if ( !function_exists('tatsu_video') ) {
	function tatsu_video( $atts, $content ) {
		$atts = shortcode_atts( array(
			'source'=>'youtube',
			'url'=>'',
			'placeholder' => '',
			'animate'=>0,
	        'animation_type'=>'fadeIn',
			'box_shadow' => '',
			'margin' => '',
			'key' => be_uniqid_base36(true),
		), $atts );
		
		extract($atts);
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_video', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output ='';
		$output .= ( isset( $animate ) && 1 == $animate ) ? '<div class="tatsu-animate" data-animation="'.$animation_type.'">' : '' ;

		$video_details = be_get_video_details($url);

	    switch ( $source ) {
			case 'youtube':
	    		$output .= ( isset( $animate ) && 1 == $animate ) ? '<div class="tatsu-animate" data-animation="'.$animation_type.'">' : '' ;
				$output .= '<div class="tatsu-module tatsu-video tatsu-youtube-wrap '.$unique_class_name.'">'.$custom_style_tag.
				( ( function_exists( 'be_gdpr_privacy_ok' ) ? be_gdpr_privacy_ok('youtube') : true ) ? tatsu_youtube( $url ) : '<div class="gdpr-alt-image"><img style="opacity:1;width:100%;" src="'.$video_details['thumb_url'].'"/><div class="gdpr-video-alternate-image-content" >'. do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="youtube" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ))  ) .'</div></div>' ).'</div>';
				$output .= ( isset( $animate ) && 1 == $animate ) ? '</div>' : '' ;
				return $output;
				break;
			case 'vimeo':	
				$output .= ( isset( $animate ) && 1 == $animate ) ? '<div class="tatsu-animate" data-animation="'.$animation_type.'">' : '' ; 
				$output .= '<div class="tatsu-module tatsu-video tatsu-vimeo-wrap '.$unique_class_name.'">'.$custom_style_tag.
				( ( function_exists( 'be_gdpr_privacy_ok' ) ? be_gdpr_privacy_ok('vimeo') : true ) ? tatsu_vimeo( $url ) : '<div class="gdpr-alt-image"><img style="opacity:1;width:100%;" src="'.$video_details['thumb_url'].'"/><div class="gdpr-video-alternate-image-content" >'. do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="vimeo"]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' )) ).'</div></div>' ).'</div>';
				$output .= ( isset( $animate ) && 1 == $animate ) ? '</div>' : '' ;
				
				return $output;
	    		break;
			default:
				$output .= ( isset( $animate ) && 1 == $animate ) ? '<div class="tatsu-animate" data-animation="'.$animation_type.'">' : '' ; 
				$output .= '<div class="tatsu-module tatsu-video tatsu-hosted-wrap '.$unique_class_name.'">'.$custom_style_tag.'<video width = "100%" controls controlsList="nodownload" poster = "'.$placeholder.'"><source src="'.$url.'" type="video/mp4"></video></div>';
				$output .= ( isset( $animate ) && 1 == $animate ) ? '</div>' : '' ;
				
				return $output;
				break;
	    }
	}
	add_shortcode( 'tatsu_video', 'tatsu_video' );
}
if ( !function_exists('tatsu_youtube') ) {
	function tatsu_youtube( $url ) {
		$video_id = '';
		if( ! empty( $url ) ) {
			$video_id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) ? $match[1] : '' ;		
			return '<iframe class="youtube" id="tatsu-youtube-'.$video_id.'" src="https://youtube.com/embed/'.$video_id.'?rel=0&wmode=transparent" allowfullscreen></iframe>';		
		} else {
			return '';
		}

	}
}

/**************************************
			VIDEO - VIMEO
**************************************/
if ( !function_exists( 'tatsu_vimeo' ) ) {
	function tatsu_vimeo( $url ) {
		$video_id = '';
		if( ! empty( $url ) ) {
			sscanf(parse_url($url, PHP_URL_PATH), '/%d', $video_id);
			return '<iframe src="https://player.vimeo.com/video/'.$video_id.'?api=1" id="tatsu-vimeo-'.$video_id.'" class="tatsu-vimeo-video" allowfullscreen></iframe>';
		} else {
			return '';
		}
	}
}

?>