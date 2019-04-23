<?php
if (!function_exists('tatsu_animated_numbers')) {
	function tatsu_animated_numbers( $atts, $content ) {
		$atts = shortcode_atts( array(
			'number' => '',
			'prefix' => '',
			'suffix' => '',
			'prefix_size' => '30',
			'suffix_size'  => '30',
			'prefix_color'	=> '#141414',
			'suffix_color'	=> '#141414',	
			'caption' => '',
	        'number_size' => '45',
	        'number_color' => '#141414',
	        'caption_size' => '13',
	        'caption_color' => '#141414',
	        'alignment' => 'center',
			'margin' => '',
			'key' => be_uniqid_base36(true),
		), $atts );
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_animated_numbers', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = '';
		$output = '<div class="tatsu-module tatsu-an-wrap align-'.$alignment.' '.$unique_class_name.'">';
		$output .= $custom_style_tag;
		$output .= '<div class = "tatsu-an-prefix-suffix-wrap">';
		if( '' !== $prefix ) {
			$output .= '<div class = "tatsu-an-prefix">';
			$output .= $prefix;
			$output .= '</div>';
		}
		$output .= '<div class="tatsu-an animate" data-number="'.$number.'"></div>';
		if( '' !== $suffix ) {
			$output .= '<div class = "tatsu-an-suffix">';
			$output .= $suffix;
			$output .= '</div>';
		}
		$output .= '</div>';
		if( '' !== $caption ) {
			$output .= '<h6><span class="tatsu-an-caption" >'.$caption.'</span></h6>';
		}
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'tatsu_animated_numbers', 'tatsu_animated_numbers' );
	add_shortcode( 'animated_numbers', 'tatsu_animated_numbers' );
}

?>