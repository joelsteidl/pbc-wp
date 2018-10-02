<?php
/**************************************
			Animated Box Style1
**************************************/
if ( ! function_exists( 'be_animate_icons_style1' ) ) {
	function be_animate_icons_style1( $atts, $content ) {
		$atts = shortcode_atts( array (
			'height' => '300',
			'gutter' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		extract( $atts );
		$height = ( isset( $height ) && !empty( $height ) ) ? $height : 300 ;
		$custom_style_tag = be_generate_css_from_atts( $atts, 'animate_icons_style1', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

	//    $GLOBALS['be_animate_icon_style1_gutter']  = $gutter = ( isset( $gutter ) && !empty( $gutter ) && $gutter != '0' ) ? $gutter : '0' ;
		$output = '';
		$output .= '<div class="oshine-module oshine-am-fh display-block '.$custom_class_name.'">'.$custom_style_tag.'<div class="animate-icon-module-style1-wrap-container"><div class="animate-icon-module-style1-wrap clearfix" data-gutter-width="'.$gutter.'">'.do_shortcode($content).'</div></div></div>';
		return $output;
	}
	add_shortcode( 'animate_icons_style1', 'be_animate_icons_style1' );
}

if ( ! function_exists( 'be_animate_icon_style1' ) ) {
	function be_animate_icon_style1( $atts, $content ) {
		$atts =  shortcode_atts( array (
			'icon' => 'none',
			'title' => '',
			'title_font' => 'h6',
			'size' => 30,
			'icon_color' => '',
			'link_to_url' => '',
			'height' => '',
			'bg_image' => '',
			'bg_color' => '',
			'hover_bg_color' => '',
			'bg_overlay' => 0,
			'overlay_color' => '',
			//'overlay_opacity' => '',
			'hover_overlay_color' => '',
			'hover_overlay_opacity' => '',
			'animate_direction' => 'top',
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'animate_icon_style1', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];


		$link_to_url = ( isset( $link_to_url ) && !empty( $link_to_url ) ) ? $link_to_url : '#' ;
	    $animate_direction = ( isset( $animate_direction ) && !empty( $animate_direction ) ) ? $animate_direction : 'top';
	    $bg_overlay_class = ( isset( $bg_overlay ) && 1 == $bg_overlay ) ? 'ai-has-overlay' : '' ;
	    $title_font = ( isset( $title_font ) && !empty($title_font) ) ? $title_font : 'h6' ;
	//    $margin_bottom = $GLOBALS['be_animate_icon_style1_gutter'];
	    if( !empty( $bg_image ) ) {
	    	//$attachment_info = wp_get_attachment_image_src( $bg_image, 'full' );
			//$attachment_url = $attachment_info[0];
	    	$bg_image = 'background: url('.$bg_image.');';
	    } 
	    $output = '';
		$output .= '<a href="'.$link_to_url.'" class="animate-icon-module-style1 be-bg-cover animate-icon-module '.$bg_overlay_class.' '.$animate_direction.'-animate '.$custom_class_name.'">';
		$output .= $custom_style_tag;
		$output .= '<div class="animate-icon-module-normal-content"><div class="display-table"><div class="display-table-cell vertical-align-middle"><i class="font-icon '.$icon.'" ></i>';
		$output .= !empty($title) ? '<'.$title_font.'  class="title_content" >'.$title.'</'.$title_font.'>' : '';
		$output .= '</div></div></div>'; //closing tags for Normal Content
		$output .= '<div class="animate-icon-module-hover-content"><div class="display-table"><div class="display-table-cell vertical-align-middle">'.$content.'</div></div></div>';
		if( isset( $bg_overlay ) && 1 == $bg_overlay && !empty( $bg_image ) ) {
			$output .= '<div class="ai-overlay" ></div>';
		}
		$output .= '</a>';
		return $output;
	}
	add_shortcode( 'animate_icon_style1', 'be_animate_icon_style1' );
}
?>