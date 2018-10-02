<?php
/**************************************
			COUNTDOWN
**************************************/
if (!function_exists('be_countdown')) {
	function be_countdown( $atts, $content ) {
			 $atts = shortcode_atts( array (
				'date_time' => '',
				'text_color' =>'',
		        'animate' => 0,
				'animation_type'=>'fadeIn',
				'key' => be_uniqid_base36(true),
			), $atts);
			
			extract( $atts );
			$custom_style_tag = be_generate_css_from_atts( $atts, 'be_countdown', $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];


	    	$animate = ( isset( $animate ) && 1 == $animate ) ? 'be-animate' : 0 ;
			$output = '';
	    	$output .= '<div class="be-countdown-wrap '.$custom_class_name.' oshine-module '.$animate.' clearfix"  data-animation="'.$animation_type.'">';
	    	$output .= '<div class="be-countdown clearfix" data-time="'.$date_time.'"></div>';
			$output .= $custom_style_tag;
			$output .= '</div>';
	        return $output;
	}
	add_shortcode( 'be_countdown', 'be_countdown' );
}
?>