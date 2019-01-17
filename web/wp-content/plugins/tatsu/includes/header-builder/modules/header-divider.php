<?php 

function tatsu_header_divider( $atts, $content ) {

    $atts = shortcode_atts( array(
        'width' => '',
        'height' => '',
        'color' => '',
        'margin' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts );

    extract( $atts );
    $output = '';
    $visibility_classes = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_header_divider', $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    
    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $output =  '<div class="tatsu-header-module tatsu-header-divider-wrap '.$unique_class.' '.$visibility_classes.'">   
                    '.$custom_style_tag.'
                </div>';

    return $output;
}

add_shortcode( 'tatsu_header_divider', 'tatsu_header_divider' );

?>