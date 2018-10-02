<?php
/**************************************
			SPECIAL TITLE 6
**************************************/
if (!function_exists('be_special_heading6')) {
	function be_special_heading6( $atts, $content ) { 

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
			'key' => be_uniqid_base36(true),
        ), $atts );


        extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'be_special_heading6', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];


        $border_style = ( isset($border_style) && !empty($border_style) ) ? $border_style : 'style1';
        $expand_border = ( isset($expand_border) && !empty($expand_border) ) ? 1 : 0;
        $output ='';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate"' : '"' ; 
        $animation_type = ( isset($animation_type) && !empty($animation_type) && !empty($animate) ) ? $animation_type : 'none';
        $output .= '<div class = "oshine-module special-heading-wrap '.$custom_class_name.' style6' . $animate . ' data-animation="' . $animation_type . '">';
        $output .= $custom_style_tag;
        $output .= '<div class = "special-heading-inner-wrap be-border-' . $border_style .  ( ( 1 == $expand_border ) ? ' be-expand"' : '"' ) . ' >';
        $output .= '<div class = "be-border" >';
        $output .= '</div>'; //End be-border
        $output .= '<h6 class = "be-title">';
        $output .= $title_content;
        $output .= '</h6>';//End be-title 
        $output .= '</div>'; // End special-heading-inner-wrap
        $output .= '</div>'; //End special-heading-wrap
        return $output;
    }
    add_shortcode( 'be_special_heading6','be_special_heading6' );
}
?>