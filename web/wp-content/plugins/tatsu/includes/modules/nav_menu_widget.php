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
        'key' => be_uniqid_base36(true)
    ), $atts );
    
    extract( $atts );
    $unique_class = 'tatsu-'.$atts['key'];
    $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_wp_menu_links', $key, '' );

    $output = '';
    $arrow_class = isset( $show_arrow ) && ( $show_arrow ) ? 'show-arrow' : '' ;
    $menu_style = isset( $menu_style ) && ( $menu_style === 'horizontal' ) ? 'horizontal-menu' : '' ;
    $defaults = array (
        'menu'=> $menu_name,
        'depth'=> 3,
        'container_class'=>'tatsu-menu-widget '.$unique_class,
        'menu_id' => 'menu-'.$key, 
        'menu_class' => 'clearfix ',
        'echo' => false,
        'walker' => new Tatsu_Walker_Menu_Widget()
    );
    
    if($menu_name != ''){
        $output = '<nav class="tatsu-menu-widget-wrap clearfix '.$link_font.' '.$arrow_class.' '.$menu_style.'">'.wp_nav_menu( $defaults ).$custom_style_tag.'</nav>';
    }else{
        $output = 'CHOOSE THE MENU';
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