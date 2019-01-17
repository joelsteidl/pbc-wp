<?php
/**************************************
			ACCORDION
**************************************/
if ( !function_exists('tatsu_accordion') ) {
	function tatsu_accordion( $atts, $content ) {
		extract (
			shortcode_atts ( array ( 
                'style'     => 'style1',
                'collapsed' => 0,
                'title_color'   => '',
                'title_hover_color' => '',
                'content_bg_color' => '',
                'border_color'  => '#CACACA',
                'title_font'    => 'h6',
                'content_font' => '',
                'margin'        => '',
                'animate' => 0,
                'animation_type' => 'fadeIn',
                'animation_delay' => 0,
                'key' => be_uniqid_base36(true),
			), $atts)
        );
        global $tatsu_accordion_title_font, $tatsu_accordion_content_font, $tatsu_accordion_content_bg;
        if( !empty( $title_font ) ) {
            $tatsu_accordion_title_font = $title_font;
        }else {
            $tatsu_accordion_title_font = '';
        }
        if( !empty( $content_font ) ) {
            $tatsu_accordion_content_font = $content_font;
        }else {
            $tatsu_accordion_content_font = '';
        }
        if( !empty( $content_bg_color ) ) {
            $tatsu_accordion_content_bg = $content_bg_color;
        }else {
            $tatsu_accordion_content_bg = '';
        }
        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_accordion', $key );
        $unique_class_name = 'tatsu-' . $key;

        $animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '';

        $style = !empty( $style ) ? $style : 'style1';
        $classes = array( 'tatsu-module', 'tatsu-accordion', 'tatsu-accordion-' . $style, $unique_class_name, $animate );
		return '<div class="' . implode( ' ', $classes ) . '" data-animation="'. $animation_type .'" data-animation-delay="'.$animation_delay.'" >'. $custom_style_tag . '<div data-collapsed="'.$collapsed.'" class = "tatsu-accordion-inner">'. do_shortcode($content).'</div></div>';
	}
	add_shortcode( 'tatsu_accordion', 'tatsu_accordion' );
}

if ( !function_exists('tatsu_toggle') ) {
	function tatsu_toggle( $atts, $content ){
		$atts = shortcode_atts ( array ( 
				'title' => '',
			), $atts	
		);
        extract ( $atts );
        global $tatsu_accordion_title_font, $tatsu_accordion_content_font, $tatsu_accordion_content_bg;
		return '<h3 class="accordion-head ' . ( !empty( $tatsu_accordion_title_font ) ? $tatsu_accordion_title_font : '' ) . '">'.$title.'<span class = "tatsu-accordion-expand"></span></h3><div class = "accordion-content ' . ( !empty( $tatsu_accordion_content_font ) ? $tatsu_accordion_content_font : '' ) . '" ><div class = "accordion-content-inner ' . ( !empty( $tatsu_accordion_content_bg ) ? 'accordion-with-bg' : '' ) . '">'.do_shortcode($content) . '</div></div>';
	}
	add_shortcode( 'tatsu_toggle', 'tatsu_toggle' );
}

?>