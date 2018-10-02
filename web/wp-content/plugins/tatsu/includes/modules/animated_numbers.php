<?php
if (!function_exists('tatsu_animated_numbers')) {
	function tatsu_animated_numbers( $atts, $content ) {
		$atts = shortcode_atts( array(
			'number' => '',
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
		$output .= '<div class="tatsu-an animate" data-number="'.$number.'" style="line-height:1.3"></div>';
		$output .= '<h6><span class="tatsu-an-caption" >'.$caption.'</span></h6>';
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'tatsu_animated_numbers', 'tatsu_animated_numbers' );
	add_shortcode( 'animated_numbers', 'tatsu_animated_numbers' );
}

?>