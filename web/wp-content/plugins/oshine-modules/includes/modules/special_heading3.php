<?php
/**************************************
			SPECIAL TITLE 3
**************************************/
if (!function_exists('be_special_heading3')) {
	function be_special_heading3( $atts, $content ) {
		$atts = shortcode_atts( array(
			'title_content' => '',
			'h_tag' => 'h3',
	        'title_color' => '',
	        'sub_title1' => '',
	        'sub_title2' => '',
	        'top_caption_color' => '',
	        'bottom_caption_color' => '',
	        'top_caption_size' => '14',
	        'bottom_caption_size' => '14',
	        'top_caption_font' => 'h6',
	        'bottom_caption_font' => 'h6',
	        'top_caption_separator_color' => '',
	        'bottom_caption_separator_color' => '',
			'scroll_to_animate'=> 0,
			'animate'=>0,
	        'animation_type'=>'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_heading3', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$output ='';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;
		if ('body' == $top_caption_font){
			$top_caption_font_style = 'body-font';
		} elseif ('special' == $top_caption_font){
			$top_caption_font_style = 'special-subtitle';
		} else {
			$top_caption_font_style = '';
		}
		if ('body' == $bottom_caption_font) {
			$bottom_caption_font_style = 'body-font';
		} elseif ('special' == $bottom_caption_font){
			$bottom_caption_font_style = 'special-subtitle';
		} else {
			$bottom_caption_font_style = '';
		}

		$output .='<div class="special-heading-wrap style3 '.$custom_class_name.' oshine-module '.$animate.'" data-animation="'.$animation_type.'">';
		$output .= ($sub_title1) ? '<div class="caption-wrap top-caption"><h6 class="caption '. $top_caption_font_style .'">'.$sub_title1.'<span class="caption-inner"></span></h6></div>' : '' ;
		$output .='<div class="special-heading align-center"><'.$h_tag.' class="special-h-tag">'.$title_content.'</'.$h_tag.'></div>';
		$output .= ($sub_title2) ? '<div class="caption-wrap bottom-caption"><h6 class="caption '. $bottom_caption_font_style .'">'.$sub_title2.'<span class="caption-inner"></span></h6></div>' : '' ;
		$output .= $custom_style_tag;
		$output .='</div>';
		return $output;
	}
	add_shortcode( 'special_heading3', 'be_special_heading3' );
}
?>