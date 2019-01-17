<?php 
function tatsu_header_logo( $atts, $content ) {
    $atts = shortcode_atts( array(
        'default' => '',
        'light' => '',
        'dark' => '',      
        'height' => '',
        'sticky_height' => '',
        'margin' => '',
        'hide_in' => '',
        'id' => '',
        'class' => '',
        'key' => be_uniqid_base36(true),
    ), $atts );

    extract( $atts );
    $output = '';
    $visibility_classes = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_header_logo', $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $id = !empty( $id ) ? 'id="'.$id.'"' : '';

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $output .= '<div class="tatsu-header-logo tatsu-header-module '.$unique_class.' '.$class.' '.$visibility_classes.'" '.$id.'>';
    $output .= '<a href="'.esc_url( home_url() ).'">';
    $output .= '<img src="'.esc_url( $default ).'" class="logo-img default-logo" />';
    $output .= '<img src="'.esc_url( $dark ).'" class="logo-img dark-logo" />';
    $output .= '<img src="'.esc_url( $light ).'" class="logo-img light-logo" />';
    $output .= '</a>';
    $output .= $custom_style_tag;
    $output .= '</div>';  // end tatsu-header-logo

    return $output;
}
add_shortcode( 'tatsu_header_logo', 'tatsu_header_logo' );
?>