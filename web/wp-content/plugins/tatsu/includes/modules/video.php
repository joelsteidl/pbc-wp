<?php
if ( !function_exists('tatsu_video') ) {
	function tatsu_video( $atts, $content ) {
		$atts = shortcode_atts( array(
			'source'=>'youtube',
			'url'=>'',
			'placeholder' => '',
			'autoplay' => 0,
			'loop_video' => 0,
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
	    
				$output .= '<div class="tatsu-module tatsu-video tatsu-youtube-wrap '.$unique_class_name.'">'.$custom_style_tag;
				$output .= tatsu_youtube( $url, $autoplay, $loop_video );
				$output .= '</div>';
				$output .= ( isset( $animate ) && 1 == $animate ) ? '</div>' : '' ;
				return $output;
				break;
			case 'vimeo':
			
				$output .= '<div class="tatsu-module tatsu-video tatsu-vimeo-wrap '.$unique_class_name.'">'.$custom_style_tag;
				$output .= tatsu_vimeo( $url, $autoplay, $loop_video );
				$output .= '</div>';
				$output .= ( isset( $animate ) && 1 == $animate ) ? '</div>' : '' ;
				return $output;
				break;
			default:
				$output .= ( isset( $animate ) && 1 == $animate ) ? '<div class="tatsu-animate" data-animation="'.$animation_type.'">' : '' ; 
				$output .= '<div class="tatsu-module tatsu-video tatsu-hosted-wrap '.$unique_class_name.'">'.$custom_style_tag.'<video  width = "100%" controls controlsList="nodownload" poster = "'.$placeholder.'" '.( $loop_video ? "loop" : "") .' '. ($autoplay ? "autoplay muted" : "") .' ><source src="'.$url.'" type="video/mp4"></video></div>';
				$output .= ( isset( $animate ) && 1 == $animate ) ? '</div>' : '' ;
				
				return $output;
				break;
		}
	}
	add_shortcode( 'tatsu_video', 'tatsu_video' );
}
if ( !function_exists('tatsu_youtube') ) {
	function tatsu_youtube( $url, $autoplay, $loop_video ) {
		$video_details = be_get_video_details($url);
		$video_id = '';
		$result = '';
		if( ! empty( $url ) ) {
			$video_id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) ? $match[1] : '' ;
			if( !function_exists( 'be_gdpr_privacy_ok' ) ){
				$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-youtube-embed" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '"></div></div>';
			} else {
				if ( !empty( $_COOKIE ) ) {
					if( !( be_gdpr_privacy_ok( 'youtube' ) )  ){
						$result .= be_gdpr_get_video_alt_content( $video_details['thumb_url'], 'youtube', false );
					} else {
						$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-youtube-embed" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '"></div></div>';
					}
				} else {
					$result .= '<div class = "be-video-embed be-embed-placeholder be-gdpr-consent-replace"><div class = "be-youtube-embed" data-gdpr-concern="youtube" data-video-id = "' . $video_id . '"></div></div>';

					$result .= be_gdpr_get_video_alt_content( $video_details['thumb_url'], 'youtube', true );
				}
			}
		} else {
			return '';
		}
		return $result;
	}
}

/**************************************
			VIDEO - VIMEO
**************************************/
if ( !function_exists( 'tatsu_vimeo' ) ) {
	function tatsu_vimeo( $url, $autoplay, $loop_video ) {
		$video_details = be_get_video_details($url);
		$video_id = '';
		$result = '';
		if( ! empty( $url ) ) {
			sscanf(parse_url($url, PHP_URL_PATH), '/%d', $video_id);
			if( !function_exists( 'be_gdpr_privacy_ok' ) ){
				$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-vimeo-embed" data-video-id = "' . $video_id . '"></div></div>';
			} else {
				if( !empty( $_COOKIE ) ){
					if( !( be_gdpr_privacy_ok( 'vimeo' ) )  ){
						$result .= be_gdpr_get_video_alt_content( $video_details['thumb_url'], 'vimeo', false );
					} else {
						$result .= '<div class = "be-video-embed be-embed-placeholder"><div class = "be-vimeo-embed" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '"></div></div>';
					}
				} else {
					$result .= '<div class = "be-video-embed be-embed-placeholder  be-gdpr-consent-replace"><div class = "be-vimeo-embed" data-gdpr-concern="vimeo" data-video-id = "' . $video_id . '" data-autoplay = "' . $autoplay . '" data-loop = "' . $loop_video . '"></div></div>';
					
					$result .= be_gdpr_get_video_alt_content( $video_details['thumb_url'], 'vimeo', true );
				}
			}
		} else {
			$result = '';
		}
		return $result;
	}
}

?>