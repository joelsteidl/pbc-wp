<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_divider' ) ) {
	function tatsu_divider( $atts ) {
		$atts = shortcode_atts( array(
	        'height' => '1',
	        'width' => '20',
	        'units' => '%',
	        'alignment' => '',
	        'color' => '#dedede',
			'margin' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_divider', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];


		extract($atts);
		$output = '';
		
		$class = ( !empty( $alignment ) ) ? 'align-'.$alignment: '';
		
		$output .= '<div class="tatsu-module tatsu-divider-wrap ' . $custom_class_name . '">';
		$output .= $custom_style_tag;
		$output .= '<hr class="tatsu-divider"/>'; 
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_divider', 'tatsu_divider' );
}

?>