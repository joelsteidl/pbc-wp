<?php
/**************************************
			ANIMATED LINK
**************************************/
if (!function_exists('oshine_animated_link')) {
    function oshine_animated_link( $atts, $content ) {
        $atts = shortcode_atts( array (
			'link_text' => '',
			'url' => '',
            'font_size' => '13',
            'link_style' => 'style1',
			'alignment' => '',
			'color'=> '',
			'hover_color'=> '',
			'line_color'=> '',
			'line_hover_color' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'key' => be_uniqid_base36(true),
		), $atts );
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, 'oshine_animated_link', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];


		$output = '';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '';
		
		$output .= '<div class="oshine-animated-link '.$custom_class_name.' oshine-module align-'. $alignment .'"><a class = "animated-link animated-link-'. $link_style .' '. $animate .'" href = "'. $url .'" data-animation="'. $animation_type .'" data-animation-delay="'.$animation_delay.'" >';
		$output .= '<span class = "link-text"  >'.$link_text.'</span>';
        if( $link_style == 'style4' || $link_style == 'style5' ){
            $output .= '<div class = "next-arrow"><span class="arrow-line-one" ></span><span class="arrow-line-two" ></span><span class="arrow-line-three"></span></div>';
        }
		$output .= '</a>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'oshine_animated_link', 'oshine_animated_link' );
}
add_filter( 'oshine_animated_link_before_css_generation', 'oshine_animated_link_css'  );
function oshine_animated_link_css($atts) {
	if( empty( $atts['hover_color'] ) ) {
		$atts['hover_color'] = $atts['color'];
	}
	if( empty( $atts['line_color'] ) ) {
		$atts['line_color'] = $atts['color'];
	}
	if( empty( $atts['line_hover_color'] ) ) {
		$atts['line_hover_color'] = $atts['hover_color'];
	}
	return $atts;
}

?>