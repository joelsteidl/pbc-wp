<?php
/**************************************
			SPECIAL SUB TITLE 1
**************************************/
if (!function_exists('be_special_subtitle')) {
	function be_special_subtitle( $atts ) {
		global $be_themes_data;
		$atts = shortcode_atts( array(
			'title_content' => '',
			'font_size' => '18',
			'title_color' => '',
	        'title_alignment' => 'center',
			'scroll_to_animate'=> 0,
			'max_width' => 100,
			'margin_bottom' => 30,
			'animate'=> 0,
	        'animation_type'=> 'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts );		


		extract( $atts );
		//$atts['padding'] = $padding;
		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_sub_title', $key );
		$unique_class_name = 'tatsu-'.$key;

	    $output ='';
	    $animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;
	    $max_width = (isset($max_width) && !empty($max_width)) ? 'width: '.$max_width.'%' : '';
		$scroll_to_animate = ( isset( $scroll_to_animate ) && 1 == $scroll_to_animate ) ? 'scrollToFade' : $scroll_to_animate ;
		$output .='<div class="special-subtitle-wrap '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'"><div class="align-'.$title_alignment.'">';
		$output .= ($title_content) ? '<span class="special-subtitle" >'.$title_content.'</span>' : '' ;
		$output .='</div>'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'special_sub_title', 'be_special_subtitle' );
}
?>