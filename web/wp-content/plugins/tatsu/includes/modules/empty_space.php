<?php
// Change linebreak to tatsu_empty_space in parser
if (!function_exists('tatsu_empty_space')) {
	function tatsu_empty_space( $atts ) {
		$atts = shortcode_atts( array(
	        'height'=>'50',
	        'hide_in' => 0,
			'key' => be_uniqid_base36(true),
	    ),$atts);

		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_empty_space', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];



		extract($atts);
	    $class = '';
		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$class .= ' tatsu-hide-'.$device;
			}
		}	
		$output = '';
		$output .= '<div class="tatsu-empty-space '.$class." ". $custom_class_name .' " >'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'tatsu_empty_space', 'tatsu_empty_space' );
	add_shortcode( 'linebreak', 'tatsu_empty_space' );
}

?>