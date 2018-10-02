<?php 
if ( !function_exists( 'simple_text' ) ) {
	function simple_text( $atts, $content ) {
		extract( shortcode_atts( array (
            'margin' => '0',
            'tag_to_use' => '',
            'style' => '',
            'font_size' => '',
            'letter_spacing' => '',
            'line_height' => '',
            'text_transform' => '',
            //'margin' => '',
            'text_color' => '',
			'animate' => '0',
			'animation_type' => 'none',
			'animation_delay' => '0',
			//'max_width' => 100,
			'wrap_alignment' => 'center',
			//'border_radius' => '',
			'enable_box_shadow' => '',
			'box_shadow_custom' => '',
			'padding' =>'',
            'bg_color' => '',
            'border_width' => '',
            'border_color' => '',
			'key' => be_uniqid_base36(true),  
		),$atts ) );
		

		extract($atts);
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'simple_text', $key );
		$custom_class_name = 'tatsu-'.$key;


		$animate = ( isset( $animate ) && !empty( $animate ) ) ? 1 : 0;
		$animation_delay = ( isset( $animation_delay ) && !empty( $animation_delay ) && 1 == $animate ) ? $animation_delay : '';
		$animation_type = ( isset( $animation_type ) && !empty( $animation_type ) && 1 == $animate ) ? $animation_type : '';
		
		$output = '';
		$output .= '<div class="tatsu-module simple-text clearfix '. $custom_class_name . ( ( 1 == $animate ) ? ' tatsu-animate' : '' )  . '" ' . ( ( '' != $animation_type ) ? ( ' data-animation="'. $animation_type .'"' ) : '' ) . ( ( '' != $animation_delay ) ? ( ' data-animation-delay="'. $animation_delay .'"' ) : '' )  . ' >';
            $output .= $custom_style_tag;
            $output .= '<div class="simple-text-inner background-switcher-class">';
                $output .= '<'.$tag_to_use.' class="simple-text-tag">';
                $output .= do_shortcode( $content );
                $output .= '</'.$tag_to_use.'>';
            $output .= '</div>';
        $output .= '</div>';
        
        //background-switcher-class used coz in real page it is not taking effect
        // if not used, is not visible in tatsu
	    return $output;
	}
	add_shortcode( 'simple_text', 'simple_text' );
}
?>