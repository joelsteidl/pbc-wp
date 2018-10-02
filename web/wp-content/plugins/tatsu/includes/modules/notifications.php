<?php
if (!function_exists('tatsu_notifications')) {
	function tatsu_notifications( $atts, $content ) {
		$atts = shortcode_atts( array(
			'bg_color'=>'',
			'margin' => '',
			'animate'=>0,
			'animation_type'=>'fadeIn',
			'key' => be_uniqid_base36(true),
		), $atts );
		
		extract($atts);
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_notifications', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = '';
	    $animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '' ;

		$output .= '<div class="tatsu-module tatsu-notification '.$unique_class_name.' '.$animate.'" data-animation="'.$animation_type.'">'.$custom_style_tag.'<span class="close"><i class="tatsu-icon icon-icon_close"></i></span>'.do_shortcode( $content ).'</div>';
		
		return $output;
	}
	add_shortcode( 'tatsu_notifications', 'tatsu_notifications' );
	add_shortcode( 'notifications', 'tatsu_notifications' );
}

?>