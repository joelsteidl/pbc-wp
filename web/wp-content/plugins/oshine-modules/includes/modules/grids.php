<?php
/**************************************
			GRID
**************************************/ 
if (!function_exists('be_grids')) {
	function be_grids( $atts, $content ) {
		$atts = shortcode_atts( array (
			'column' => 1,
			'border_color' => '',
			'alignment' => 'center',
			'key' => be_uniqid_base36(true),
		), $atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'grids', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];


		if(empty( $column )) {
			$column = 2;
		}
		$GLOBALS['be_grid_alignment'] = isset($alignment) ? 'align-'.$alignment : 'align-center';
	    $output = "";
		$output .= '<div class="grid-wrap '.$custom_class_name.' align-'.$alignment.' oshine-module" data-col="'.$column.'">';
		$output .= $custom_style_tag;
		$output .= do_shortcode( $content );
	    $output .= '</div>';
	    return $output;
	}
	add_shortcode( 'grids', 'be_grids' );
}

if (!function_exists('be_grid_content')) {
	function be_grid_content( $atts, $content ){
			$atts = shortcode_atts( array (
				'icon' => '',
				'icon_size' => 'medium',
				'icon_color' => '',
		        'animate' => 0,
				'animation_type'=>'fadeIn',
				'key' => be_uniqid_base36(true),
			), $atts );
			
			extract( $atts );
			$custom_style_tag = be_generate_css_from_atts( $atts, 'grid_content', $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];

	    	$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : 0 ;
			$output = '';
	    	$output .= '<div class="'.$custom_class_name.' grid-col '.$animate.' '.$GLOBALS['be_grid_alignment'].'" data-animation="'.$animation_type.'">';
			$output .= ($icon != '') ? '<i class="font-icon '.$icon.' '.$icon_size.' "></i>' : '' ;
			$output .= ($content != '') ? '<div class="grid-info">'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) ).'</div>' : '';
			$output .= $custom_style_tag;
			$output .= '</div>';
	        return $output;
	}
	add_shortcode( 'grid_content', 'be_grid_content' );
}
?>