<?php
if (!function_exists('tatsu_animated_link')) {
    function tatsu_animated_link( $atts, $content ) {
        $atts = shortcode_atts( array (
            'link_text' => '',
			'url' => '',
			'new_tab' => '',
            'custom_font_size'  => '0',
            'font_size' => '13',
            'link_style' => 'style1',
			'alignment' => '',
			'color'=> '',
			'hover_color'=> '',
			'line_color'=> '',
            'line_hover_color' => '',
            'margin'        => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'key' => be_uniqid_base36(true),
		), $atts );
        
		extract( $atts );

		$custom_style_tag  = be_generate_css_from_atts( $atts, 'tatsu_animated_link', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

        $link_text_font = !empty( $link_text_font ) ? ( ' ' . $link_text_font ) : '';

		$output = '';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '';
		$new_tab = !empty( $new_tab ) ? 'target = "_blank"' : '';
		
		$output .= '<div class="tatsu-animated-link tatsu-animated-link-'. $link_style . ' ' .$custom_class_name. ' tatsu-module tatsu-animated-link-align-'. $alignment .'"><a class = "tatsu-animated-link-inner '. $animate . $link_text_font . '" href = "'. $url .'" ' . $new_tab . ' data-animation="'. $animation_type .'" data-animation-delay="'.$animation_delay.'" >';
		$output .= '<span class = "tatsu-animated-link-text"  >'.$link_text.'</span>';
        if( $link_style == 'style4' ){
            //$output .= '<div class = "next-arrow"><span class="arrow-line-one" ></span><span class="arrow-line-two" ></span><span class="arrow-line-three"></span></div>';
			$output .= '<span class = "tatsu-animated-link-arrow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="15px" viewBox="0 0 30 18" enable-background="new 0 0 30 18" xml:space="preserve">
			<path class="tatsu-svg-arrow-head" d="M20.305,16.212c-0.407,0.409-0.407,1.071,0,1.479s1.068,0.408,1.476,0l7.914-7.952c0.408-0.409,0.408-1.071,0-1.481
				l-7.914-7.952c-0.407-0.409-1.068-0.409-1.476,0s-0.407,1.071,0,1.48l7.185,7.221L20.305,16.212z"></path>
			<path class="tatsu-svg-arrow-bar" fill-rule="evenodd" clip-rule="evenodd" d="M1,8h28.001c0.551,0,1,0.448,1,1c0,0.553-0.449,1-1,1H1c-0.553,0-1-0.447-1-1
				C0,8.448,0.447,8,1,8z"></path>
			</svg></span>';
		}
		$output .= '</a>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		
		return $output;
	}
}

add_filter( 'exp_animated_link_before_css_generation', 'exp_animated_link_css1' );
function exp_animated_link_css1($atts) {
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