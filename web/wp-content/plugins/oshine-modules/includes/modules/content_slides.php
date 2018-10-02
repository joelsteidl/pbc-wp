<?php
/**************************************
			CONTENT SLIDER
**************************************/
if (!function_exists('be_content_slides')) {	
	function be_content_slides( $atts, $content ){
		global $be_themes_data;
		extract( shortcode_atts( array (
			'slide_animation_type' => 'slide',
			'slide_show' => '0',
			'slide_show_speed' => 4000,
			'content_max_width' => 100,
			'bullets_color' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
		), $atts ) );
		$GLOBALS['content_max_width'] = $content_max_width ;
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;
		$slide_animation_type = ( isset( $slide_animation_type ) && !empty($slide_animation_type) ) ? $slide_animation_type : 'slide' ;
		$slide_show = ( !empty( $slide_show ) ) ? 1 : 0 ;
		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;
		$bullets_color = ( isset( $bullets_color ) && !empty($bullets_color) ) ? $bullets_color : '#000' ;
		$return = '<div class="oshine-module '.$animate.' content-slide-wrap" data-animation="'.$animation_type.'" ><div class=" content-slider clearfix"><ul class="clearfix slides content_slider_module clearfix" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'" data-slide-animation-type="'.$slide_animation_type.'">'.do_shortcode( $content ).'</ul></div></div>';
		return $return;	
	}	
	add_shortcode( 'content_slides', 'be_content_slides' );
}

if (!function_exists('be_content_slide')) {	
	function be_content_slide( $atts, $content ) {
		$content = do_shortcode($content);
		$content_max_width = ( isset( $GLOBALS['content_max_width'] ) && !empty( $GLOBALS['content_max_width'] ) ) ? $GLOBALS['content_max_width'] : 100;
		$output = '';
		$output .= '<li class="content_slide slide clearfix"><div class="content_slide_inner" style="width: '.$content_max_width.'%">';
		$output .= '<div class="content-slide-content">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>';
		$output .= '</div></li>';
		return $output;
	}	
	add_shortcode( 'content_slide', 'be_content_slide' );
}
?>