<?php
if ( ! function_exists( 'tatsu_call_to_action' ) ) {
	function tatsu_call_to_action( $atts, $content ) {
		$atts = shortcode_atts( array(
			'bg_color'=> '',
			'title' => '',
			'h_tag' => 'h5',
			'title_color' => '',
			'button_text'=>'Click Here',
			'button_link'=> '',			
			'new_tab'=> 'no',
			'button_bg_color'=> '',
			'hover_bg_color'=> '',
			'color'=> '',
			'hover_color'=> '',
			'border_width' => 0,			
			'border_color'=> '',
			'hover_border_color'=> '',
			'lightbox' => 0,
			'image' => '',
			'video_url' => '',
			'animate'=> 0,
			'animation_type'=> 'fadeIn',
			'box_shadow' => '',
			'margin' => '',
			'key' => be_uniqid_base36(true),
	    ), $atts );


		$output = '';
		$mfp_class = '';

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_call_to_action', $key );
		$unique_class_name = 'tatsu-'.$key;

		// if($button_bg_color) {
		// 	$data_bg_color = 'data-bg-color="'.$button_bg_color.'"';
		// } else {
		// 	$data_bg_color = 'data-bg-color="inherit"';
		// 	$button_bg_color = 'inherit';
		// }

	//	$data_hover_bg_color = ($hover_bg_color) ? 'data-hover-bg-color="'.$hover_bg_color.'"' : 'data-hover-bg-color="'.$button_bg_color.'"' ; 
		
		// if($color) {
		// 	$data_color = 'data-color="'.$color.'"';
		// } else {
		// 	$data_color = 'data-color=""';
		// 	$color = '';
		// }
		// $data_hover_color = ($hover_color) ? 'data-hover-color="'.$hover_color.'"' : 'data-hover-color="'.$color.'"' ; 
		
		// if($border_color) {
		// 	$data_border_color = 'data-border-color="'.$border_color.'"';
		// } else {
		// 	$data_border_color = 'data-border-color="transparent"';
		// 	$border_color = 'transparent';
		// }
		// $data_hover_border_color = ($hover_border_color) ? 'data-hover-border-color="'.$hover_border_color.'"' : 'data-hover-border-color="'.$border_color.'"' ;
		//$button_link = ( empty( $button_link ) ) ? '#' : $button_link ; 
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;

		if( $lightbox && 1 == $lightbox ) {
			if( !empty( $video_url ) ) {
				$mfp_class = 'mfp-iframe';
				$button_link = $video_url;
			} elseif ( !empty($image) ) {
				$mfp_class = 'mfp-image';
				$button_link = $image;
			}
		}


		//GDPR Privacy preference popup logic
		$video_details =  be_get_video_details($video_url);
		if( $mfp_class === 'mfp-iframe' ){
			if(  function_exists( 'be_gdpr_privacy_ok' ) ? !be_gdpr_privacy_ok($video_details['source']) : false ){
				$mfp_class = 'mfp-popup';
				$button_link = '#gdpr-alt-lightbox-'.$key;
				$output .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
			}
		}
		

		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '' ; 
		$output .= '<div class="tatsu-module tatsu-call-to-action tatsu-clearfix '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'">';
		$output .= '<'.$h_tag.' class="tatsu-action-content" >'.$title.'</'.$h_tag.'>';
		$output .= ( !empty( $button_link )  ) ? '<a class="mediumbtn tatsu-button rounded tatsu-action-button '.$mfp_class.'" href="'.$button_link.'" '.$new_tab.'><span>'.$button_text.'</span></a>' : '' ;
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;	
	}
	add_shortcode( 'tatsu_call_to_action', 'tatsu_call_to_action' );
	add_shortcode( 'call_to_action', 'tatsu_call_to_action' );
}

add_filter( 'tatsu_call_to_action_before_css_generation', 'tatsu_call_to_action_css' );
function tatsu_call_to_action_css( $atts ) {
	if( empty( $atts['border_color'] ) ) {
		$atts['border_color'] = 'transparent';
	}
	return $atts;
}

?>