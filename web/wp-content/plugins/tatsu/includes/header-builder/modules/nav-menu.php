<?php 

function tatsu_navigation_menu( $atts, $content ) {
    
    $atts = shortcode_atts( array(
        'menu_name' => '',
        'disable_in_mobile' => '',
        'links_margin' => '',
        'margin' => '',
        'menu_color' => '',
        'menu_hover_color' => '',
        'transparent_menu_hover_color' => '',
        'transparent_menu_hover_color_dark' => '',
        'menu_link' => '',
        'sub_menu_bg_color' => '',
        'sub_menu_text_color' => '',
        'sub_menu_hover_color' => '',
        'sub_menu_hover_bg_color' => '',
        'submenu_width' => '',
        'submenu_padding' => '',
        'sub_menu_shadow' => '',
        'sub_menu_border' => '',
        'mega_menu'     => '',
        'sub_menu_link' => '',
        // 'disable_in_mobile' => false, 
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts );
    
    extract( $atts );
    
    $unique_class = 'tatsu-'.$atts['key'];
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_navigation_menu', $key, 'Header' );
    // $mobile_visibility = ( isset( $disable_in_mobile ) && ( $disable_in_mobile ) ) ? 'hide-in-mobile' : '' ;
    
    $output = '';
    $visibility_classes = '';

    //check if menu_name actually exists in db, if not add fallback menu
    $menu_obj = wp_get_nav_menu_object( $menu_name );
    if( false === $menu_obj ) {
        $menu_name = '';
    }

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    if($menu_name != ''){
        $defaults = array (
            'menu'=> $menu_name,
            'depth'=> 3,
            'container_class'=>'tatsu-menu '.$unique_class,
            'menu_id' => 'menu-'.$key, 
            'menu_class' => 'clearfix ',
            'echo' => false,
            'walker' => new Tatsu_Walker_Nav_Menu()
        );
        
        $mobile_defaults = array (
            'menu'=> $menu_name,
            'depth'=> 3,
            'container_class'=>'tatsu-mobile-menu '.$unique_class,
            'menu_id' => 'menu-'.$key,
            'menu_class' => 'clearfix ',
            'echo' => false,
            'walker' => new Tatsu_Walker_Mobile_Nav_Menu()
        );
    
        $mega_menu_class = '';
        if( !empty( $mega_menu ) ) {
            $mega_menu_class = ' tatsu-header-navigation-mega-menu';
        }
        
        $output = '<nav class="tatsu-header-module tatsu-header-navigation clearfix '.$visibility_classes. $mega_menu_class .'">'.wp_nav_menu( $defaults ).$custom_style_tag.'</nav>';
        // $output .= ( $mobile_visibility === 'hide-in-mobile' ) ? '' : '<div class="tatsu-header-module tatsu-mobile-navigation '.$visibility_classes.'">'.wp_nav_menu( $mobile_defaults ).'<div class="tatsu-mobile-menu-icon"><div class="expand-click-area"></div><div class="line-wrapper"><span class="line-1"></span><span class="line-2"></span><span class="line-3"></span></div></div></div>' ;
        $output .= '<div class="tatsu-header-module tatsu-mobile-navigation '.$visibility_classes.'">'.wp_nav_menu( $mobile_defaults ).'<div class="tatsu-mobile-menu-icon"><div class="expand-click-area"></div><div class="line-wrapper"><span class="line-1"></span><span class="line-2"></span><span class="line-3"></span></div></div></div>' ;
    }else{
        if( current_user_can( 'edit_theme_options' ) ) {
            $output = '<span style="margin-right: 30px;"><a href="'.esc_url(admin_url('nav-menus.php')).'">'.esc_html__('CREATE OR SET A MENU', 'tatsu').'</a></span>';
        }
    }
    return $output;

}
add_shortcode( 'tatsu_navigation_menu', 'tatsu_navigation_menu' );

if ( !class_exists('Tatsu_Walker_Nav_Menu') ) {
    class Tatsu_Walker_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

            $output .="\n$indent<span class=\"sub-menu-indicator\">$sub_menu_indicator</span><ul class=\"tatsu-sub-menu clearfix\"><span class=\"tatsu-header-pointer\"></span>\n";
		}
	}
}

if ( !class_exists('Tatsu_Walker_Mobile_Nav_Menu') ) {
    class Tatsu_Walker_Mobile_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

            $output .= "\n$indent<span class=\"sub-menu-indicator\">$sub_menu_indicator</span><ul class=\"tatsu-sub-menu clearfix\">\n";
		}
	}
}

if( !function_exists( 'tatsu_navigation_menu_prevent_autop' ) ) {
    function tatsu_navigation_menu_prevent_autop( $content_filter, $tag ) {
        if( 'tatsu_navigation_menu' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'tatsu_navigation_menu_prevent_autop', 10, 2 );
}

?>