<?php
/**************************************
			SPECIAL HEADING
**************************************/
if (!function_exists('tatsu_special_heading')) {
	function tatsu_special_heading( $atts, $content ) { 

        $atts = shortcode_atts( array(
            'title_content'        => '',
            'border_style'         => 'style1',
            'font_size'            => '14px',
            'letter_spacing'       => '0em',
            'margin'               => '0px 0px 0px 0px',
            'title_color'          => '',
            'border_color'         => '',
            'title_hover_color'    => '',
            'alignment'            => 'left',
            'expand_border'        => 0,
            'animate'              => 0,
            'animation_type'       => 'none',
			'animation_delay' => 0,
			'key' => be_uniqid_base36(true),
        ), $atts );


        extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_special_heading', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];


        $border_style = ( isset($border_style) && !empty($border_style) ) ? $border_style : 'style1';
        $expand_border = ( isset($expand_border) && !empty($expand_border) ) ? 1 : 0;
        $output ='';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate"' : '"' ; 
        $animation_type = ( isset($animation_type) && !empty($animation_type) && !empty($animate) ) ? $animation_type : 'none';
        $output .= '<div class = "tatsu-special-heading-wrap '.$custom_class_name.' ' . $animate . ' data-animation="' . $animation_type . '" data-animation-delay="'.$animation_delay.'"  >';
        $output .= $custom_style_tag;
        $output .= '<div class = "special-heading-inner-wrap tatsu-border-' . $border_style .  ( ( 1 == $expand_border ) ? ' tatsu-expand"' : '"' ) . ' >';
        $output .= '<div class = "tatsu-border" >';
        $output .= '</div>'; //End be-border
        $output .= '<h6 class = "tatsu-title">';
        $output .= $title_content;
        $output .= '</h6>';//End be-title 
        $output .= '</div>'; // End special-heading-inner-wrap
        $output .= '</div>'; //End special-heading-wrap
        return $output;
    }
}
?>