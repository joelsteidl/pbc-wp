<?php
if ( ! function_exists( 'tatsu_dropcap' ) ) {
	function tatsu_dropcap( $atts, $content ) {
		$atts = shortcode_atts( array(
	        'type'=>'circle',
	        'bg_color' => '',
	        'color'=>'',
	        'size' =>'small',
	        'letter'=>'',
	        'icon'=>'none',
			'animate'=>0,
	        'animation_type'=>'fadeIn',
			'margin' => '',
			'key' => be_uniqid_base36(true),
		), $atts );
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_dropcap', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = "";
		$output .= '<div class="tatsu-module tatsu-clearfix tatsu-dropcap-wrap '.$unique_class_name.'">';
		$letter = ( $icon != '' ) ? '<i class="tatsu-icon '.$icon.'"></i>' : '<span>'.$letter.'</span>';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '' ; 
		
	 	if( 'rounded' == $type || 'circle' == $type ) {
	 		$output .= '<span class="tatsu-dropcap tatsu-dropcap-'.$type.' '.$size.$animate.'" data-animation="'.$animation_type.'">'.$letter.'</span>'.do_shortcode( $content );
	 	}
	 	if( 'letter' == $type) {
	 		$output .= '<span class="tatsu-dropcap tatsu-dropcap-'.$type.' '.$size.' data-animation="'.$animation_type.'">'.$letter.'</span>'.do_shortcode( $content );
		}
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_dropcap', 'tatsu_dropcap' );
	add_shortcode( 'dropcap', 'tatsu_dropcap' );
}

?>