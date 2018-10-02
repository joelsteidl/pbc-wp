<?php

/**************************************
			SPECIAL TITLE 2
**************************************/
if (!function_exists('be_special_heading2')) {
	function be_special_heading2( $atts, $content ) {

		//$padding = $atts['padding'];
		$atts = shortcode_atts( array(
			'title_content' => '',
			'h_tag' => 'h3',
			'title_color' => '',
	        'border_color' => '',
	        'border_thickness' => '2',
	        'title_padding_vertical' => '20px',
			'title_padding_horizontal' => '20px',
			'padding' => '20px 30px 20px 30px',
	        'padding_value' => 'px',
	        'title_alignment' => 'center',
			'scroll_to_animate'=> 0,
			'animate'=> 0,
			'animation_type'=> 'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts );		


		extract( $atts );
		//$atts['padding'] = $padding;
		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_heading2', $key );
		$unique_class_name = 'tatsu-'.$key;

	    $output ='';
	    $animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;
		$output .='<div class="special-heading-wrap style2 oshine-module align-'.$title_alignment.' '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'"><div class="special-heading" >';
		$output .= ($title_content) ? '<'.$h_tag.' class="special-h-tag" >'.$title_content.'</'.$h_tag.'>' : '' ;
		$output .='</div>'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'special_heading2', 'be_special_heading2' );
}

?>