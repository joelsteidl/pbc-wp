<?php
/**************************************
			Process Style
**************************************/ 
if (!function_exists('be_process_style1')) {
	function be_process_style1( $atts, $content ) {
		$atts = shortcode_atts( array (
			'column' => 1,
			'border_color' => '',
			'key' => be_uniqid_base36(true),
		), $atts  );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'process_style1', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		if(empty( $column )) {
			$column = 2;
		}
	    $output = "";
		$output .= '<div class="process-style1 oshine-module '.$custom_class_name.' " data-col="'.$column.'" >';
		$output .= $custom_style_tag;
		$output .= do_shortcode( $content );
	    $output .= '</div>';
	    return $output;
	}
	add_shortcode( 'process_style1', 'be_process_style1' );
}

if (!function_exists('be_process_col')) {
	function be_process_col( $atts, $content ){
			$atts = shortcode_atts( array (
				'icon' => '',
				'icon_color' => '',
				'icon_size'	=> '60',
		        'animate' => 0,
				'animation_type'=>'fadeIn',
				'key' => be_uniqid_base36(true),
			), $atts );
			
			extract( $atts );
			$custom_style_tag = be_generate_css_from_atts( $atts, 'process_col', $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];

	    	$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : 0 ;
			$output = '';
	    	$output .= '<div class="process-col '.$animate. $custom_class_name.' align-center" data-animation="'.$animation_type.'">';
			$output .= '<i class="font-icon '.$icon.'" ></i>';
			$output .= '<div class="process-info">'.do_shortcode( $content ).'</div>';
	        //$output .= '</div><div class="process-divider" style="height: '.intval($icon_size/2).'px;"></div>';
	        $output .= '<div class="process-sep" style="top: '.intval($icon_size/2).'px;"></div>';
			$output .= $custom_style_tag;
			$output .= '</div>';
	        return $output;
	}
	add_shortcode( 'process_col', 'be_process_col' );
}
?>