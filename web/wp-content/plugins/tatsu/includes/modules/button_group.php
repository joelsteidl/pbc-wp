<?php
if ( !function_exists('tatsu_button_group') ) {	
	function tatsu_button_group( $atts, $content ){
		$atts = shortcode_atts( array (
			'alignment' => 'center',
			'margin' => '',
			'key' => be_uniqid_base36(true),
		), $atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_button_group', $key );
		$custom_class_name = 'tatsu-'.$key;

		$output = '<div class="tatsu-module tatsu-button-group align-'.$alignment.' '.$custom_class_name.'" >'.do_shortcode( $content ).'</div>'.$custom_style_tag;	
			
		return $output;	
	}	
	add_shortcode( 'tatsu_button_group', 'tatsu_button_group' );
}

?>