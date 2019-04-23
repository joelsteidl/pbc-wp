<?php
function tatsu_wpml_language_switcher( $atts, $content ) {
    $atts = shortcode_atts( array(
        'current_lang_color' => '',
        'flag_visibility' => '' ,
        // 'native_language_visibility' => '',
        'language_name' => '',
        'lang_typography' => '',
        'margin' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true),
    ), $atts );
    
    extract( $atts );

    $output = '';
    $visibility_classes = '';
    $unique_class = 'tatsu-'.$key;
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_wpml_language_switcher', $key, 'Header' );

    $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
    $my_current_lang = apply_filters( 'wpml_current_language', NULL );
    $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    if( !empty( $languages ) ){
        $output .= '<div class = "tatsu-header-module tatsu-wpml-lang-switcher '.$unique_class.' '.$visibility_classes.' "><span class="current-language">'.$my_current_lang.'</span><span class="sub-menu-indicator">'.$sub_menu_indicator.'</span>';
        $output .= '<ul class = "language-list" ><span class="tatsu-header-pointer"></span>';
        foreach( $languages as $l ){
            if( !$l['active'] ){
                $translated_name = isset( $language_name ) && $language_name ? $l['translated_name'] : '';
                $output .= '<li>';
                if( $l['country_flag_url'] && isset( $flag_visibility ) && $flag_visibility ){
                    $output .= '<a href="'.$l['url'].'" class = "language-flag" >';
                    $output .= '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                    $output .= '</a>';
                }
                $output .= '<a href="'.$l['url'].'" class = "language-name" >';
                $output .= apply_filters( 'wpml_display_language_names', NULL, $l['native_name'], $translated_name );
                $output .= '</a>';
                $output .= '</li>';
            }
        }
        $output .= '</ul>'.$custom_style_tag.'</div>';
    }

    return $output;
}

add_shortcode( 'tatsu_wpml_language_switcher', 'tatsu_wpml_language_switcher' );

?>