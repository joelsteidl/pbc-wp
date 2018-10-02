<?php 

if (!function_exists('tatsu_text')) {
	function tatsu_text( $atts, $content ) {
		$atts = shortcode_atts( array (
			'max_width' => 100,
			'wrap_alignment' => 'center',
	        'scroll_to_animate' => 0,
			'animate' => 0,
	        'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'margin' => '',
			'bg_color' => '',
			'border_radius' => '',
			'box_shadow' => '',
			'padding' =>'',
			'key' => be_uniqid_base36(true),
		),$atts);
		
		extract($atts);
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_text', $key );
		$custom_class_name = 'tatsu-'.$key;

	    $output = '';
	    $bool = false;
		if( isset( $animate ) && 1 == $animate ) {
			$animate = 'tatsu-animate';
			$bool = true;
		} else {
			$animate = '';
		}
		if( isset( $scroll_to_animate ) && 1 == $scroll_to_animate ) {
	    	$scroll_to_animate = 'scrollToFade';
	    	$bool = true;
	    } else {
			$scroll_to_animate = '';
		}
		
		if($max_width < 100){
			if($wrap_alignment == 'left'){
				//$margin = 'margin-right: 0; margin-left:0;';
				$margin = '';
			}
			if($wrap_alignment == 'center'){
				//$margin = 'margin-right:auto; margin-left:auto;';
				$margin = 'tatsu-align-center';
			}
			if($wrap_alignment == 'right'){
				$margin = 'tatsu-align-right';
			}
		}
		else{
			$margin = ''; 
		}

		$output .= '<div class="tatsu-module tatsu-text-block-wrap '.$custom_class_name.'"><div class="tatsu-text-inner '.$margin.' '.$animate.' '.$scroll_to_animate.' clearfix" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'">';
		$output .= $custom_style_tag;
		$output .= do_shortcode(  $content );
		$output .= '</div></div>';
		
	    return $output;
	}
	add_shortcode( 'tatsu_text', 'tatsu_text' );
	add_shortcode( 'text', 'tatsu_text' );
}

?>