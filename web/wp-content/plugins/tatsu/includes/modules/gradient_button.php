<?php
if (!function_exists('tatsu_gradient_button')) {
	function tatsu_gradient_button( $atts, $content ) {

		$atts = shortcode_atts( array (
			'button_text' => '',
			'url' => '',
			'new_tab'=> 'no',
			'type' => 'small',
			'alignment' => '',							 
			'bg_color' => '',
			'hover_bg_color' => '',
			'color'=> '',
			'hover_color'=> '',
			'border_width' => 0,			
			'border_color'=> '',
			'hover_border_color'=> '',
			'lightbox' => 0,	
			'image' => '',
			'video_url' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			// 'enable_box_shadow' => 0,
			// 'box_shadow_custom' => '',
			'enable_margin' => '',
			'margin' => '',
			// 'custom_button_height' => '',
			// 'custom_button_width' => '',
			// 'custom_text_size' => '',
			// 'custom_text_letter_spacing' => '',
			'hover_effect' => '',
			'key' => be_uniqid_base36(true),
		), $atts ) ;
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gradient_button', $key );
		$custom_class_name = 'tatsu-'.$key;


	
		$mfp_class = '';
		$output = '';

		$alignment = ( "block" === $type ) ? 'center' : $alignment;
		if( isset( $alignment ) ){
			if( $alignment != 'none' ){
				$alignment = 'align-block block-'.$alignment;
			} else {
				$alignment = '';
			}
		}

		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
		
		$hover_bg_class =  empty( $hover_bg_color ) ? 'transparent_hover_bg' : '';

		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : ''; 

		$url = ( empty( $url ) ) ? '#' : $url ;

		$image_wrap_class = '';

		if( $lightbox && 1 == $lightbox ) {
			if( !empty( $video_url ) ) {
				$mfp_class = 'mfp-iframe';
				$url = $video_url;
			} elseif ( !empty($image) ) {
				$mfp_class = 'mfp-image';
				$url = $image;
			}
		}

		$hover_effect = !empty( $hover_effect ) && 'none' !== $hover_effect ? $hover_effect : '';

		//GDPR Privacy preference popup logic
		$video_details =  be_get_video_details($video_url);
		if( $mfp_class === 'mfp-iframe' ){
			if(  function_exists( 'be_gdpr_privacy_ok' ) ? !be_gdpr_privacy_ok($video_details['source']) : false ){
				$mfp_class = 'mfp-popup';
				$url = '#gdpr-alt-lightbox-'.$key;
				$output .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
			}
		}

		$output .= '
		<div class="tatsu-module tatsu-gradient-button tatsu-button-container '.$alignment.' '.$custom_class_name.' '.$hover_bg_class.' '.$hover_effect.'">
			<div class="tatsu-button-wrap ' . $animate . '" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'">
				<a class="tatsu-button tatsu-custom-button-size ' .$mfp_class.' '.$type.'btn" href="'.$url.'" '.$new_tab.'>
					<span class="tatsu-button-text " data-text="'.$button_text.'"><span class="default">'.$button_text.'</span></span>
				</a> 
			</div>
			'.$custom_style_tag.'
		</div>';
		//$output .= $custom_style_tag;
		return $output;
	}
	add_shortcode( 'tatsu_gradient_button', 'tatsu_gradient_button' );
}
?>