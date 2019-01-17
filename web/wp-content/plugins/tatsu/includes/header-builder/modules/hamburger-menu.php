<?php 
function tatsu_hamburger_menu( $atts, $content ) {

    $atts = shortcode_atts( array(
        'menu_icon_color' => '',
        'menu_icon_hover_color' => '',
        'icon_width' => '',
        'icon_thickness' => '',
        'icon_spacing' => '',
        'panel_background_color' => '',
        'margin' => '',
        'panel_width' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true),
    ), $atts );

    extract( $atts );
    $output = '';
    $visibility_classes = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_hamburger_menu', $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $id = !empty( $id ) ? 'id="'.$id.'"' : '';

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $output .= '<div class="tatsu-header-module tatsu-hamburger '.$unique_class.' '.$visibility_classes.'" data-slide-menu="'.$unique_class.'">   
                    '.$custom_style_tag.'
                    <div class="line-wrapper">
                        <span class="line-1"></span>
                        <span class="line-2"></span>
                        <span class="line-3"></span>   
                    </div>
                </div>';

    return $output;
}

add_shortcode( 'tatsu_hamburger_menu', 'tatsu_hamburger_menu' );

?>