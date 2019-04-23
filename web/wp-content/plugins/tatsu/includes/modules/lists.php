<?php
if ( !function_exists('tatsu_lists') ) {
	function tatsu_lists( $atts, $content ) {
		$atts = shortcode_atts( array (
			'margin'				=> '',
			'style'					=> 'icon',
			'timeline'				=> '',
			'timeline_color'		=> '',
			'list_item_margin'		=> '',
			'vertical_alignment' 	=> 'none',
		//	'reverse_list'			=> '',
			'custom_border'			=> '0',
			'circled'				=> '',
			'icon_bg'				=> '',
			'icon_color'			=> '',
			'border'				=> '',
			'border_color'			=> '',
			'key'					=> be_uniqid_base36(true),
		), $atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_lists', $key );
		$unique_class_name = 'tatsu-'.$key;

		$classes = array( 'tatsu-module', 'tatsu-list', $unique_class_name );

		global $tatsu_lists_style;
		if( !empty( $style ) ) {
			$tatsu_lists_style = $style;
		}else {
			$tatsu_lists_style =  '';
		}

		$lists_tag = 'number' === $style ? 'ol' : 'ul' ;

		if( !empty( $vertical_alignment ) && 'none' !== $vertical_alignment ) {
			$classes[] = 'tatsu-list-vertical-align-' . $vertical_alignment;
		}
		if( !empty( $custom_border ) ) {
			$classes[] = 'tatsu-list-bordered';
		}
		if( !empty( $style ) ) {
			$classes[] = 'tatsu-lists-' . $style;
		}
		if( !empty( $circled ) && !empty( $timeline ) ) {
			$classes[] = 'tatsu-lists-timeline';
		}
		if( !empty( $circled ) ) {
			$classes[] = 'tatsu-lists-circled';
		}

		$timeline_html = '';
		if( !empty( $circled ) && !empty( $timeline ) ) {
			$timeline_html = '<span class = "tatsu-lists-timeline-element"></span>';
		}

		$classes = implode(' ', $classes);

		return '<' . $lists_tag . ' class="' . $classes . '">'. $custom_style_tag . do_shortcode( $content ). $timeline_html . '</' . $lists_tag . '>';
	}
	add_shortcode( 'tatsu_lists', 'tatsu_lists' );
	add_shortcode( 'lists', 'tatsu_lists' );
}
if ( !function_exists( 'tatsu_list' ) ) {
	function tatsu_list( $atts, $content ) {
		global $be_themes_data;
		$atts = shortcode_atts( array( 
			'icon' => '',
			'circled' => '',
			'icon_bg' => '', 
			'icon_color' => '',
			'border_color'	=> '',
			'key' => be_uniqid_base36(true),
		), $atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_list', $key );
		$unique_class_name = 'tatsu-'.$key;
		$output = '';

		global $tatsu_lists_style;

		if( 'icon' === $tatsu_lists_style && $icon != 'none' ) { 
		 	if( 1 == $circled ) {
				 $circled = 'circled';
				 $icon_markup  = '<i class="tatsu-list-icon tatsu-icon '.$icon.' '.$circled.'"></i>'; 
		 	} else {
		 		$circled = '';
		 		$icon_markup  = '<i class="tatsu-icon '.$icon.' '.$circled.'"></i>';		
		 	}
		} 
		$output .= '<li class="tatsu-list-content '.$unique_class_name.'">';
		if( 'icon' === $tatsu_lists_style ) {
			$output .= '<span class="tatsu-list-icon-wrap" >'.$icon_markup.'</span>';
		}
		$output .= '<span class="tatsu-list-inner">'.$content.'</span>'.$custom_style_tag.'</li>';
		return $output;
	}
	add_shortcode( 'tatsu_list', 'tatsu_list' );
	add_shortcode( 'list', 'tatsu_list' );
	
}

?>