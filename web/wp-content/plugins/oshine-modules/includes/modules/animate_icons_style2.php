<?php
/**************************************
			Animated Box Style2
**************************************/
if ( ! function_exists( 'be_animate_icons_style2' ) ) {
	function be_animate_icons_style2( $atts, $content ) {
		$output = '';
		$output .= '<div class="oshine-module oshine-am-vh animate-icon-module-style2-wrap clearfix">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>';
		return $output;
	}
	add_shortcode( 'animate_icons_style2', 'be_animate_icons_style2' );
}

if ( ! function_exists( 'be_animate_icon_style2' ) ) {
	function be_animate_icon_style2( $atts, $content ) {
		$atts = shortcode_atts( array (
			'icon' => 'none',
			'size' => 30,
			'icon_color' => '',
			'icon_color_hover_state' => '',
			'title' => '',
			'h_tag' => 'h6',
			'title_color' => '',
			'title_color_hover_state' => '',
			'bg_color' => '',
			'hover_bg_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'animate_icon_style2', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];

		extract( $atts );

	    $h_tag = ( isset( $h_tag ) && !empty( $h_tag ) ) ? $h_tag : 'h6';
	    $title = ( isset( $title ) && !empty( $title ) ) ? '<'.$h_tag.' class="animate-icon-title" >'.$title.'</'.$h_tag.'>' : '';
	    $output = '';
	    $output .= '<div class="animate-icon-module-style2 '.$custom_class_name.'"  >';
	    $output .= '<div class="animate-icon-module-style2-inner-wrap">';
		$output .= '<div class="animate-icon-module-style2-normal-content clearfix"><i class="animate-icon-icon font-icon '.$icon.'" ></i>'.$title.'</div>';
		$output .= '<div class="animate-icon-module-style2-hover-content clearfix">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>';
		$output .= '</div>'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'animate_icon_style2', 'be_animate_icon_style2' );
}
?>