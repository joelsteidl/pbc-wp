<?php
/**************************************
			SPECIAL TITLE 4
**************************************/
if (!function_exists('be_special_heading4')) {
	function be_special_heading4( $atts, $content ) {
		$atts = shortcode_atts( array(
			'title_content' => '',
			'h_tag' => 'h3',
	        'title_color' => '',
	        'caption_content' => '',
	        'caption_font' => '',
	        'caption_color' => '',
	        'divider_style' => 'both',
	        'divider_color' => '',
			'scroll_to_animate'=> 0,
			'animate'=>0,
	        'animation_type'=>'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts );
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_heading4', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$output ='';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;
		$divider_style = ( ! empty( $divider_style ) ) ? $divider_style : 'both' ;
		$caption_tag = 'div';
		
		if ('body' == $caption_font){
			$caption_font_style = 'body-font';
		} elseif ('special' == $caption_font){
			$caption_font_style = 'special-subtitle';
		} else {
			$caption_font_style = '';
			$caption_tag = $caption_font;
		}

		$output .='<div class="special-heading-wrap style4 '. $custom_class_name.' oshine-module '.$animate.'" data-animation="'.$animation_type.'">';
		$output .= ($divider_style == 'bottom') ? '' : '<div class="vertical-divider top"></div>' ;
		$output .= ($caption_content) ? '<'.$caption_tag.'  class="caption '. $caption_font_style .'">'.$caption_content.'</'.$caption_tag.'>' : '' ;
		$output .='<div class="special-heading "><'.$h_tag.' class="special-h-tag" >'.$title_content.'</'.$h_tag.'></div>';
		$output .= ($divider_style == 'top') ? '' : '<div class="vertical-divider bottom" ></div>' ;
		$output .= $custom_style_tag;
		$output .='</div>';
		return $output;
	}
	add_shortcode( 'special_heading4', 'be_special_heading4' );
}
?>