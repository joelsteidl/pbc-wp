<?php
/**************************************
			SVG ICON
**************************************/
if (!function_exists('tatsu_svg_icon')) {
    function tatsu_svg_icon( $atts, $content ) {
        $atts = shortcode_atts( array (
            'svg_icon'              => '',
            'custom_icon'           => '',
            'svg_url'               => '',
            'style'                 => 'plain',
            'size'                  => 'medium',
            'width'                 => 200,
            'height'                => 200,
            'stroke_width'          => '',
            'alignment'             => '',
            'color'                 => '',
            'bg_color'              => '',
            'margin'                => '0 0 60px 0',
            'line_animate'          => 0,
            'path_animation_type'   => 'LINEAR',
            'svg_animation_type'    => 'LINEAR',
            'animation_duration'    => 0,
            'animate'               => '',
            'animation_type'        => '',
            'animation_delay'       => 0,
        	'key' => be_uniqid_base36(true),
		),$atts );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_svg_icon', $key );
		$unique_class_name = 'tatsu-' . $key;

        $line_animate_class = ( !empty( $line_animate ) ) ? 'tatsu-line-animate' : '' ;

        $svg_icon_style = !empty( $style ) ? ( 'tatsu-svg-icon-' . $style ) : '';

        $css_animate_class = !empty( $animate ) ? 'be-animate' : '';
        $data_animation_type = '';
        if( !empty( $animation_type ) ) {
            $data_animation_type = 'data-animation = "' . $animation_type . '"';
        }
        $data_animation_delay = '';
        if( !empty( $animation_delay ) ) {
            $data_animation_delay = 'data-animation-delay = "' . $animation_delay . '"';
        }

        $icon_type_class = '';
        if( !empty( $custom_icon ) ) {
            $icon_type_class = 'tatsu-svg-icon-custom';
        }else {
            $icon_type_class = 'tatsu-svg-icon-default';
        }

        $output = '';
        if( !empty($svg_url) || !empty( $svg_icon ) ) {
            $output .= '<div class="tatsu-svg-icon tatsu-module align-'. $alignment . ' ' . $css_animate_class . ' '. $line_animate_class.' '.$size.' '.$unique_class_name . ' ' . $icon_type_class . ' ' . $svg_icon_style . ' " data-path-animation="'.$path_animation_type.'" data-svg-animation="'.$svg_animation_type.'" data-animation-duration="'.$animation_duration.'" ' . $data_animation_type . ' ' . $data_animation_delay . '>';
            $output .= '<div class = "tatsu-svg-icon-inner">';
            if( empty( $custom_icon ) ) {
                $svg_icon_html = function_exists( 'tatsu_get_svg_icon' ) ? tatsu_get_svg_icon( $svg_icon ) : '';
                if( !empty( $svg_icon_html ) ) {
                    $output .= $svg_icon_html;
                }
            }else {
                $site_url = get_site_url();
                if( strpos( $svg_url, $site_url ) !== false ) { 
                    $output .=  file_get_contents( $svg_url );
                } else {
                    $output .= '<div class="tatsu-notification tatsu-error">Cross Domain Access of SVG is not allowed. Please upload the SVG file to your site.</div>';
                }
            }
            $output .= '</div>';
            $output .= $custom_style_tag;
            $output .= '</div>';
        }
        return $output;
	}
	add_shortcode( 'tatsu_svg_icon', 'tatsu_svg_icon' );
}
?>