<?php

if ( ! function_exists( 'tatsu_typed_text' ) ) {
	function tatsu_typed_text( $atts ) {
		$atts = shortcode_atts( array(
	        'prefix_text' => '',
            'rotated_text' => '',
            'suffix_text' => '',
            'rotated_text_color' => '#dedede',
			'prefix_suffix_color' => '#dedede',
			'cursor_color'	=> '',
			'tag_to_use' => '',
			'typed_text_font' => '',
			'margin'	=> '0 0 30px 0',
			'key' => be_uniqid_base36(true),
		),$atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_typed_text', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];
		extract($atts);
		if( !empty( $prefix_text ) ) {
			$prefix_text = "$prefix_text ";
		}
		if( !empty( $suffix_text ) )  {
			$suffix_text = " $suffix_text";
		}
		$text_to_use_class = '';
		if( !empty( $typed_text_font ) ) {
			$text_to_use_class = ' ' . $typed_text_font;
		}
		$output = '';
		$output .= '<'. $tag_to_use .' class=" tatsu-module tatsu-typed-text-wrap ' . $custom_class_name . $text_to_use_class . '" data-rotate-text="'.$rotated_text.'" data-typed-text-id="tatsu-typed-text'.$key.'" >';
		$output .= $custom_style_tag;
        $output .= $prefix_text; 
		$output .= '<span id="tatsu-typed-text'.$key.'" class ="tatsu-typed-rotated-text"></span>';
		$output .= '<span class = "tatsu-typed-text-cursor">|</span>';
        $output .= $suffix_text; 
		$output .= '</'. $tag_to_use .'>';
		return $output;
	}
	add_shortcode( 'tatsu_typed_text', 'tatsu_typed_text' );
}

?>