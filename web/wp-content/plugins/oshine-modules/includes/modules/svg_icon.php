<?php
/**************************************
			SVG ICON
**************************************/
if (!function_exists('oshine_svg_icon')) {
    function oshine_svg_icon( $atts, $content ) {
        $atts = shortcode_atts( array (
            'size'                  => 'medium',
            'width'                 => 200,
            'height'                => 200,
            'alignment'             => '',
            'color'                 => '',
            'line_animate'          => 0,
            'path_animation_type'   => 'LINEAR',
            'svg_animation_type'    => 'LINEAR',
            'animation_duration'    => 0,
            'animation_delay'       => 0,
        	'key' => be_uniqid_base36(true),
		),$atts );		


		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'oshine_svg_icon', $key );
		$unique_class_name = 'tatsu-'.$key;

       
        $style = 'style = "';
        if( !empty( $color ) ){
            $style .= 'color : '. $color .';';
        }
        $line_animate_class = ( isset( $line_animate ) && 1 == $line_animate ) ? 'svg-line-animate' : '' ;
        if( 'custom' == $size ){
            $style .= 'width : '. $width .'px; height : '. $height .'px;';
        } else {
            $style .= '"'; //Close the style tag
        }
        $output = '';
        if( !empty($content) ) {
            $output .= '<div class="oshine-svg-icon  oshine-module align-'. $alignment .' '.$line_animate_class.' '.$size.' '.$unique_class_name .' " data-path-animation="'.$path_animation_type.'" data-svg-animation="'.$svg_animation_type.'" data-animation-delay="'.$animation_delay.'" data-animation-duration="'.$animation_duration.'" >';
        //    $output .= '<object id="oshine-svg-'.$key.'" type="image/svg+xml" class = "oshine-svg-object" data="'. shortcode_unautop( $content ) .'"></object>';
            $site_url = get_site_url();
            if( strpos( $content, $site_url ) !== false ) { 
                $output .=  file_get_contents( $content );
            } else {
                $output .= '<div class="tatsu-notification tatsu-error">Cross Domain Access of SVG is not allowed. Please upload the SVG file to your site.</div>';
            }
            $output .= $custom_style_tag;
            $output .= '</div>';
            
        }
        return $output;
	}
	add_shortcode( 'oshine_svg_icon', 'oshine_svg_icon' );
}
?>