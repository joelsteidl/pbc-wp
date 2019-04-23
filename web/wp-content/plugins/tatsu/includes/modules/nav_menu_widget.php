<?php 

function tatsu_wp_menu_links( $atts, $content ) {
    
    $atts = shortcode_atts( array(
        'menu_name' => '',
        'menu_style' => '',
        'wrap_alignment' => '',
        'menu_spacing' => '',
        'menu_color' => '',
        'menu_hover_color' => '',
        'show_arrow' => '',
        'link_font' => '',
        'margin'    => '0 0 30px 0',
        'hide_in' => '',
        'key' => be_uniqid_base36(true)
    ), $atts );
    
    extract( $atts );
    $unique_class = 'tatsu-'.$atts['key'];
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_wp_menu_links', $key, '' );

    $output = '';
    $visibility_classes = '';

    //Handle Resposive Visibility controls
    if( !empty( $hide_in ) ) {
        $hide_in = explode(',', $hide_in);
        foreach ( $hide_in as $device ) {
            $visibility_classes .= ' tatsu-hide-'.$device;
        }
    }

    //check if menu_name actually exists in db, if not add fallback menu
    $menu_obj = wp_get_nav_menu_object( $menu_name );
    if( false === $menu_obj ) {
        $menu_name = '';
    }

    $arrow_class = isset( $show_arrow ) && ( $show_arrow ) ? 'show-arrow' : '' ;
    $menu_style = isset( $menu_style ) && ( $menu_style === 'horizontal' ) ? 'horizontal-menu' : '' ;
    
    if($menu_name != ''){
        $defaults = array (
            'menu'=> $menu_name,
            'depth'=> 3,
            'container_class'=>'tatsu-menu-widget ',
            'menu_id' => 'menu-'.$key, 
            'menu_class' => 'clearfix ',
            'echo' => false,
            'walker' => new Tatsu_Walker_Menu_Widget()
        );
        $output = '<nav class="tatsu-menu-widget-wrap tatsu-module clearfix '.$visibility_classes.' '.$unique_class.' '.$link_font.' '.$arrow_class.' '.$menu_style.'">'.wp_nav_menu( $defaults ).$custom_style_tag.'</nav>';
    }else{
        if( current_user_can( 'edit_theme_options' ) ) {
            $output = '<a href="' . esc_url(admin_url('nav-menus.php')).'">'.esc_html__('CREATE OR SET A MENU', 'tatsu').'</a>';
        }
    }
    return $output;

}
add_shortcode( 'tatsu_wp_menu_links', 'tatsu_wp_menu_links' );

if ( !class_exists('Tatsu_Walker_Menu_Widget') ) {
    class Tatsu_Walker_Menu_Widget extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = file_get_contents( TATSU_PLUGIN_DIR . 'includes/header-builder/img/tatsu_header_arrow.svg' );

            $output .= "<ul class=\"tatsu-sub-menu clearfix\">";

        }
        
	}
}
?>