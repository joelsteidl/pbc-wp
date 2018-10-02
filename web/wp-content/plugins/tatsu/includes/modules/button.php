<?php
if (!function_exists('tatsu_button')) {
	function tatsu_button( $atts, $content ) {
		$atts = ( shortcode_atts( array (
			'button_text' => '',
			'icon' => 'none',
			'icon_alignment' => '',
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
			'button_style' => 'none',
			'lightbox' => 0,	
			'image' => '',
			'video_url' => '',
			'background_animation' => 'none',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'enable_box_shadow' => 0,
			'box_shadow' => '',
			'enable_margin' => '',
			'margin' => '',
			// 'custom_button_height' => '',
			// 'custom_button_width' => '',
			// 'custom_text_size' => '',
			// 'custom_text_letter_spacing' => '',
			'hover_effect' => '',
			'hover_box_shadow' => '',
			'key' => be_uniqid_base36(true),
		), $atts ) );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_button', $key );
		$custom_class_name = 'tatsu-'.$key;

		$mfp_class = '';
		$output = '';
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
		// if( !empty( $bg_color ) ) {
		// 	$data_bg_color = 'data-bg-color="'.$bg_color.'"';
		// } else {
		// 	$data_bg_color = 'data-bg-color="transparent"';
		// 	$bg_color = 'transparent';
		// }
		// $data_hover_bg_color = ( !empty( $hover_bg_color ) ) ? 'data-hover-bg-color="'.$hover_bg_color.'"' : 'data-hover-bg-color="'.$bg_color.'"';
		// if( !empty( $color ) ) {
		// 	$data_color = 'data-color="'.$color.'"';
		// } else {
		// 	$data_color = 'data-color="inherit"';
		// 	$color = 'inherit';
		// }
		// $data_hover_color = ( !empty( $hover_color ) ) ? 'data-hover-color="'.$hover_color.'"' : 'data-hover-color="'.$color.'"' ;
		// if( !empty( $border_color ) ) {
		// 	$data_border_color = 'data-border-color="'.$border_color.'"';
		// } else {
		// 	$data_border_color = 'data-border-color="transparent"';
		// 	$border_color = 'transparent';
		// }	
	//	$data_hover_border_color = ( !empty( $hover_border_color ) ) ? 'data-hover-border-color="'.$hover_border_color.'"' : 'data-hover-border-color="'.$border_color.'"';
		$background_animation = ( !empty( $background_animation ) && 'none' != $background_animation ) ? $background_animation : 'bg-animation-none';
	//	$border_width = ( empty( $border_width ) ) ? '0' : $border_width;
	//	$border_style = 'border-style: solid; border-width:'.$border_width.'px; border-color: '.$border_color;

		$alignment = ( "block" === $type ) ? 'center' : $alignment;
		if( isset( $alignment ) ){
			if( $alignment != 'none' ){
				$alignment = 'align-block block-'.$alignment;
			} else {
				$alignment = '';
			}
		}
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : ''; 
		// $rounded = ( $rounded == "1" && "block" != $type) ? "rounded" : '' ; 
		$button_style = ( isset( $button_style ) && !empty( $button_style ) ) ? $button_style : '';

		$hover_effect = !empty( $hover_effect ) && 'none' !== $hover_effect ? $hover_effect : '';
		
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

		//GDPR Privacy preference popup logic
		$video_details =  be_get_video_details($video_url);
		if( $mfp_class === 'mfp-iframe' ){
			if( function_exists( 'be_gdpr_privacy_ok' ) ? !be_gdpr_privacy_ok($video_details['source']) : false ){
				$mfp_class = 'mfp-popup';
				$url = '#gdpr-alt-lightbox-'.$key;
				$output .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
		}
		}
		
		if( 'none' === $button_style ) {
			$button_style = '';
		}

		// $bg_color = be_compute_color( $bg_color );
		$bg_color = !empty( $bg_color[1] )? be_compute_color( $bg_color )[1] : 'transparent';

		$hover_bg_color = be_compute_color( $hover_bg_color );
		$hover_bg_color = !empty( $hover_bg_color[1] )? $hover_bg_color[1] : 'transparent';

		$bg_animation_css = '';
		if($background_animation != 'bg-animation-none') {
			if($background_animation == 'bg-animation-slide-top' || $background_animation == 'bg-animation-slide-bottom') {
				$bg_animation_css = 'background-image: linear-gradient(to bottom, '.$bg_color.' 50%, '.$hover_bg_color.' 50%);';
			}
			if($background_animation == 'bg-animation-slide-left' || $background_animation == 'bg-animation-slide-right') {
				$bg_animation_css = 'background-image: linear-gradient(to right, '.$bg_color.' 50%, '.$hover_bg_color.' 50%);';
			}
		}
		
		$icon = ( isset($icon) && !empty($icon) && ($icon != 'none') ) ? '<i class="tatsu-icon '.$icon.'"></i>' : '' ;
		$icon_alignment = ( isset($icon_alignment) && !empty($icon_alignment) ) ? $icon_alignment : 'left' ;
		$button_text = ( $icon_alignment == 'right' ) ? $button_text.$icon : $icon.$button_text ;
		$output .= '<div class="tatsu-module tatsu-normal-button tatsu-button-wrap '.$alignment.' '.$image_wrap_class.' '.$custom_class_name.' '.$hover_effect.'">';
		$output .= '<a class="tatsu-shortcode '.$type.'btn tatsu-button '.$icon_alignment.'-icon '.$button_style.' '.$animate.' '.$mfp_class.' '.$background_animation.'" href="'.$url.'" style= "'.$bg_animation_css.'" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'" '.$new_tab.'>'.$button_text.'</a>' ; 
		$output .= $custom_style_tag;
		$output .= '</div>'; 
		return $output;
	}
	add_shortcode( 'tatsu_button', 'tatsu_button' );
	add_shortcode( 'button', 'tatsu_button' );
}
?>