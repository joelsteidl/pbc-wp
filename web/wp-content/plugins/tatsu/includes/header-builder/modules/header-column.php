<?php 
function tatsu_header_column($atts, $content ) {
    $atts = shortcode_atts( array(
        'column_width' => '',
        'horizontal_alignment' => '',
        'vertical_alignment' => '',
        'padding' => '',
        'sidebar_vertical_alignment' => '',
        'sidebar_horizontal_alignment' => '',
        'hide_in' => '',
        'id' => '',
        'class' => '',
        'key' => be_uniqid_base36(true),
    ), $atts );

    extract( $atts );
    $output = '';
    $visibility_classes = '';
   
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_header_column', $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $id = !empty( $id ) ? 'id="'.$id.'"' : '';

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $output .= '<div class="tatsu-header-col '.$unique_class.' '.$visibility_classes.'" '.$id.'>';
    $output .= $custom_style_tag;
    $output .= do_shortcode( $content );
    $output .= '</div>';  

    return $output;
}

add_shortcode( 'tatsu_header_column', 'tatsu_header_column' );

?>