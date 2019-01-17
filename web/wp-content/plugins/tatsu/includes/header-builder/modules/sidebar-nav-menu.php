<?php 

function tatsu_sidebar_navigation_menu( $atts, $content ) {
    
    $atts = shortcode_atts( array(
        'menu_name' => '',
        'margin' => '',
        'menu_color' => '',
        'menu_hover_color' => '',
        'menu_link' => '',
        'sub_menu_text_color' => '',
        'sub_menu_hover_color' => '',
        'sub_menu_hover_bg_color' => '',
        'sub_menu_link' => '',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts );
    
    extract( $atts );
    $unique_class = 'tatsu-'.$atts['key'];
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_sidebar_navigation_menu', $key, 'Header' );

    $output = '';
    $visibility_classes = '';

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    $defaults = array (
        'menu'=> $menu_name,
        'depth'=> 3,
        'container_class'=>'tatsu-sidebar-menu '.$unique_class,
        'menu_id' => 'menu-'.$key, 
        'menu_class' => 'clearfix ',
        'echo' => false,
        'walker' => new Tatsu_Walker_Nav_Menu()
    );
    
    if($menu_name != ''){
        $output = '<nav class="tatsu-header-module tatsu-sidebar-navigation clearfix '.$visibility_classes.'">'.wp_nav_menu( $defaults ).$custom_style_tag.'</nav>';
    }else{
        $output = 'CHOOSE THE MENU';
    }
    return $output;

}
add_shortcode( 'tatsu_sidebar_navigation_menu', 'tatsu_sidebar_navigation_menu' );

if ( !class_exists('Tatsu_Walker_Nav_Menu') ) {
    class Tatsu_Walker_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

            $output .= "<span class=\"sub-menu-indicator\">$sub_menu_indicator</span><ul class=\"tatsu-sub-menu clearfix\">";

        }
        
	}
}
?>