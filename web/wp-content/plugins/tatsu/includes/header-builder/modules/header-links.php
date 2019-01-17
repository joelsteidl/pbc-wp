<?php 

function tatsu_header_links( $atts, $content ) {

    $atts = shortcode_atts( array(
        'link_text' => '',
        'url' => '',
        'new_tab' => false,
        'color' => '',
        'hover_color' => '',
        'margin' => '',
        'hide_in' => '',
        'link_typography' => '',
        'key' => be_uniqid_base36(true)
    ), $atts );

    extract( $atts );

    $output = '';
    $visibility_classes = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_header_links', $key, 'Header' );
    $unique_class = 'tatsu-'.$key;

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $output =  '<div class="tatsu-header-module tatsu-link '.$unique_class.' '.$visibility_classes.'">   
                    <a href="'.$url.'" target='.( $new_tab ? '_blank' : '' ).'>'.$link_text.'</a>
                    '.$custom_style_tag.'
                </div>';

    return $output;
}

add_shortcode( 'tatsu_header_links', 'tatsu_header_links' );

?>