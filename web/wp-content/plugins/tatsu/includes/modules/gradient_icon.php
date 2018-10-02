<?php
if (!function_exists('tatsu_gradient_icon')) {
	function tatsu_gradient_icon( $atts, $content ) {
		$atts = (shortcode_atts(array(
			'name' => '',
			'size'=> 'medium',
			'custom_bg_size' => '',
			'custom_icon_size' => '',
			'style'=> 'square',
			'bg_color'=> '',
			'hover_bg_color'=> '',
			'color'=> '',
			'hover_color'=> '',
			'border_width' => 1,
			'border_color'=> '#323232',
			'hover_border_color'=> '#323232',
			'href'=> '#',
			'alignment' => 'none',
			'lightbox' => 0,
			'image' => '',
			'video_url' => '',
			'new_tab' => 0,
			'animate' => 0,
			'animation_type'=>'fadeIn',
			'animation_delay' => 0,
			//'enable_box_shadow' => 0,
			'box_shadow' => '',
			'margin' => '',
			'hover_effect' => '',
			'hover_box_shadow' => '',
			'key' => be_uniqid_base36(true),
		),$atts));
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gradient_icon', $key );
		$custom_class_name = 'tatsu-'.$key;
		
	
        $mfp_class = '';
        $transparent_bg = '';
		$output = '';
		$hover_effect_parent = $alignment === 'none' && 'none' !== $hover_effect ? $hover_effect : '';
		$hover_effect_child = $alignment !== 'none' && 'none' !== $hover_effect ? $hover_effect : '';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
		$href = ( empty( $href ) ) ? '#' : $href ;

		if( isset( $lightbox ) && 1 == $lightbox ) {
			if( !empty( $video_url ) ) {
				$mfp_class = 'mfp-iframe';
				$href = $video_url;
			} elseif ( !empty($image) ) {
				$mfp_class = 'mfp-image';
				$href = $image;
			}
        }
        
        if( empty( $bg_color ) || empty( $hover_bg_color ) ) {
            $transparent_bg = 'transparent-bg';
		}
		

		//GDPR Privacy preference popup logic
		$video_details =  be_get_video_details($video_url);
		if( $mfp_class === 'mfp-iframe' ){
			if( function_exists( 'be_gdpr_privacy_ok' ) ? !be_gdpr_privacy_ok($video_details['source']) : false ){
				$mfp_class = 'mfp-popup';
				$href = '#gdpr-alt-lightbox-'.$key;
				$output .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
			}
		}
        
		$output .= 
		'<div class="tatsu-module tatsu-gradient-icon tatsu-icon-shortcode align-'.$alignment.' '.$custom_class_name.' '. $transparent_bg.' '.$hover_effect_parent.'">
				<a href="'.$href.'" class="tatsu-icon-bg tatsu-custom-icon-bg '.$size.' '.$style.' '.$animate.' '.$mfp_class.' '.$hover_effect_child.'" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'" '.$new_tab.'>
					<i class="tatsu-icon '.$name.' default"></i>
					<i class="tatsu-icon '.$name.' hover"></i>
				</a>
            '.$custom_style_tag.'
		</div>';    
		return $output;
	}
	add_shortcode( 'tatsu_gradient_icon', 'tatsu_gradient_icon' );
}
add_filter( 'tatsu_gradient_icon_before_css_generation', 'tatsu_gradient_icon_css' );
function tatsu_gradient_icon_css( $atts ) {
	if( empty( $atts['hover_color'] ) ) {
		$atts['hover_color'] = $atts['color'];
	}
	return $atts;
}

?>