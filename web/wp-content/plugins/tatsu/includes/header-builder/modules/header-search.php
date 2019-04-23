<?php 

function tatsu_search( $atts, $content ) {

    $atts = shortcode_atts( array(
        'icon_color' => '',
        'margin' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts );

    extract( $atts );

    $output = '';
    $visibility_classes = '';
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_search', $key, 'Header' );
    $unique_class = 'tatsu-'.$key;
    $search_icon = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_search.svg' );
    
    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $output =  '<div class="tatsu-header-module tatsu-search '.$unique_class.' '.$visibility_classes.' ">   
                    '.$search_icon
                    .$custom_style_tag.'
                    <div class = "search-bar">
                        <span class="tatsu-header-pointer"></span>
                        <form role="search" method="get" class="tatsu-search-form" action="' . home_url( '/' ) . '" >
                            <input type="text" placeholder="'.esc_attr__( 'Search ...' , 'tatsu-header' ).'" value="' . get_search_query() . '" name="s" />
                        </form>
                    </div>
                    <div class = "tatsu-search-bar-overlay">
                    </div>
                </div>';

    return $output;
}

add_shortcode( 'tatsu_search', 'tatsu_search' );

?>