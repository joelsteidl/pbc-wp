<?php

/**************************************
			ICON CARD
**************************************/
if ( ! function_exists( 'be_icon_card' ) ) {
	function be_icon_card($atts,$content) {
		global $be_themes_data;
		$atts = shortcode_atts(array(
			'icon'=>'none',
			'size' => 'small',	
			'style'=>'circled',
			'icon_bg'=> '',
			'icon_color'=> '',
			'icon_border_color'=> '',
			'title' => '',
			'title_font' => '',
			'title_color' => '',
			'caption' => '',
			'caption_font' => '',
			'caption_color' => '',
			'animate'=> 0,
			'animation_type'=>'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts);

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'icon_card', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$output = '';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;

		$caption_tag = 'div';
		if ('body' == $caption_font){
			$caption_font_style = 'body-font';
		} elseif ('special' == $caption_font){
			$caption_font_style = 'special-subtitle';
		} else {
			$caption_font_style = '';
			$caption_tag = $caption_font;
		}
		$output .= '<div class="be_icon_card_wrap oshine-module '.$custom_class_name.' '.$size.' '.$style.' '.$animate.'" data-animation="'.$animation_type.'">';
		$output .= '<i class="font-icon '.$icon.'  " ></i>';
		$output .= '<div class="title-with-icon-card" >';
		$output .= !empty($title) ? '<'.$title_font.' class="title" >'.$title.'</'.$title_font.'>' : '';
		$output .= !empty($caption) ? '<'.$caption_tag.' class="caption '.$caption_font_style.'" >'.$caption.'</'.$caption_tag.'>' : '';
		$output .= '</div>';    		
		$output .= '</div>';
		$output .= $custom_style_tag;
		return $output; 
	}
	add_shortcode('icon_card','be_icon_card');
}
?>