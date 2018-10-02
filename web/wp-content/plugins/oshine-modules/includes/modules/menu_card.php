<?php
/**************************************
			MENU CARD 
**************************************/
if (!function_exists('be_menu_cards')) {
	function be_menu_cards( $atts, $content ) {
			$atts = shortcode_atts( array (
				'title' => '',
				'ingredients' => '',
				'price' => '',
				'title_color' => '',
				'ingredients_color' => '',
				'price_color' => '',
				'highlight' => '',
				'highlight_color' => '',
				'star' => '',
				'star_color' => '',
				'border_color' => '',
		        'animate' => 0,
				'animation_type'=>'fadeIn',
				'key' => be_uniqid_base36(true),
			), $atts );
			
			extract( $atts );
			$custom_style_tag = be_generate_css_from_atts( $atts, 'menu_card', $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];

	    	$highlight = ( isset( $highlight ) && 1 == $highlight ) ? 'highlight-menu-item' : '' ;

	    	$animate = ( isset( $animate ) && 1 == $animate ) ? 'be-animate' : 0 ;
			$output = '';
	    	$output .= '<div class="menu-card-item '. $custom_class_name .' oshine-module '.$animate.' clearfix '.$highlight.'" data-animation="'.$animation_type.'" >';
			$output .= '<div class="menu-card-item-info">';
			$output .= '<span class="h6-font menu-card-title" >'.$title.'</span>';
			$output .= '<span class="menu-card-ingredients special-subtitle" >'.$ingredients.'</span>';
			$output .= '<span class="menu-card-item-price" >'.$price.'</span>';
			if( isset( $star ) && 1 == $star ) {
				$output .= '<i class="icon-icon_star menu-card-item-stared alt-color" ></i>';
			}
			$output .= '</div>';
			$output .= $custom_style_tag;
	        $output .= '</div>';
	        return $output;
	}
	add_shortcode( 'menu_card', 'be_menu_cards' );
}
?>