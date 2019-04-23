<?php 
function tatsu_header_row( $atts, $content ) {
    $atts = shortcode_atts( array(
        'full_width' => 0,
        'bg_color' => '',
        'transparent_row_bg' => 0,
        'transparent_row_border' => '',
        'padding' => '',
        'sticky_padding' => '',
        'border' => '',
        'border_color' => '',
        'sticky_header' => 0,
        'default_visibility' => 'visible',
        'sticky_visibility' => 'visible',
        'hide_in' => '',
        'id' => '',
        'class' => '',
        'box_shadow' => '',
        'disable_color_scheme' => '',
        'key' => be_uniqid_base36(true),
    ), $atts );
    
    extract( $atts );

    $output = '';
    $visibility_classes = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_header_row', $key, 'Header' );

    

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $unique_class = 'tatsu-'.$key;
    $id = !empty( $id ) ? 'id="'.$id.'"' : '';
    $class .= !empty( $sticky_header ) ? ' tatsu-sticky-header' : '';
    $class .= !empty( $default_visibility ) && $default_visibility === 'visible' ? ' default ' : 'default-hidden ';
    $class .= !empty( $sticky_visibility ) && $sticky_visibility === 'visible' ? ' sticky ' : 'sticky-hidden ';
    $class .= isset( $disable_color_scheme ) && !empty( $disable_color_scheme ) && ( $disable_color_scheme ) ? '' : 'apply-color-scheme' ;
    $row_wrap = empty( $full_width ) ? 'tatsu-wrap' : '';
    $output .= '<div class="tatsu-header '.$class.' '.$unique_class.' '.$visibility_classes.'" '.$id.' data-padding=\''.$padding.'\' data-sticky-padding=\''.$sticky_padding.'\' >';
    $output .= '<div class="tatsu-header-row '.$row_wrap.'">';
    $output .= do_shortcode( $content ); 
    $output .= '</div>';  // end tatsu-header
    $output .= $custom_style_tag;
    $output .= '</div>';  // end tatsu-header-row

    return $output;

}

add_shortcode( 'tatsu_header_row', 'tatsu_header_row' );

?>