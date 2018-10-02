<?php
/**************************************
			SERVICES
**************************************/
if ( ! function_exists( 'be_services' ) ) {
	function be_services( $atts, $content ) {
		$atts = shortcode_atts( array (
			'line_color' => '',
			'key' => be_uniqid_base36(true)
		),$atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'services', $key );
		$unique_class_name = 'tatsu-'.$key;

		return '<div class="services-outer-wrap oshine-module '.$unique_class_name.'"><ul class="be-services">'.do_shortcode( $content ).'</ul><span class="timeline" ></span>'.$custom_style_tag.'</div>';
	}
	add_shortcode( 'services', 'be_services' );
}

add_filter( 'services_before_css_generation', 'services_css' );
function services_css( $atts ) {
		$atts[ 'line_color' ] = (empty($atts[ 'line_color' ])) ? '#000' : $atts[ 'line_color' ] ; 
	return $atts;
}

if ( ! function_exists( 'be_service' ) ) {
	function be_service( $atts, $content ) {
		$atts = shortcode_atts( array (
			'icon' => '',
			'icon_size' => 'small',
			'icon_bg_color' => '',
			'icon_hover_bg_color' => '',
			'icon_color' => '',
			'icon_hover_color' => '',
			'content_bg_color' => '',
			'key' => be_uniqid_base36(true)
		),$atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'service', $key );
		$unique_class_name = 'tatsu-'.$key;
		

	    // $icon_bg_color = (empty($icon_bg_color)) ? '#000' : $icon_bg_color ; 
		// $icon_hover_bg_color = (empty($icon_hover_bg_color)) ? $icon_bg_color : $icon_hover_bg_color ; 
		// $icon_color = (empty($icon_color)) ? '#fff' : $icon_color ; 
		// $icon_hover_color = (empty($icon_hover_color)) ? $icon_color : $icon_hover_color ; 
		
		return '<li class="be-service '.$unique_class_name.'"><div class="service-wrap" ><i class="service-icon font-icon '.$icon.' icon-size-'.$icon_size.'" ></i><div class="service-content" >'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>'.$custom_style_tag.'</div></li>';
	}
	add_shortcode( 'service', 'be_service' );
}

add_filter( 'service_before_css_generation', 'service_css' );
function service_css( $atts ) {
		$atts[ 'icon_bg_color' ] = (empty($atts[ 'icon_bg_color' ])) ? '#000' : $atts[ 'icon_bg_color' ] ; 
		$atts[ 'icon_hover_bg_color' ] = (empty($atts[ 'icon_hover_bg_color' ])) ? $atts[ 'icon_bg_color' ] : $atts[ 'icon_hover_bg_color' ] ; 
		$atts[ 'icon_color' ] = (empty($atts[ 'icon_color' ])) ? '#fff' : $atts[ 'icon_color' ] ; 
		$atts[ 'icon_hover_color' ] = (empty($atts[ 'icon_hover_color' ])) ? $atts[ 'icon_color' ] : $atts[ 'icon_hover_color' ] ; 
	return $atts;
}

?>