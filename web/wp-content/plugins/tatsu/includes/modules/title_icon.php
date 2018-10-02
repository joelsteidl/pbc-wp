<?php
if ( ! function_exists( 'tatsu_title_icon' ) ){
	function tatsu_title_icon( $atts, $content ) {
		$atts = shortcode_atts( array(
			'icon'=>'none',
			'size' => 'small',
			'alignment'=>'left',	
			'style'=>'circled',
			'icon_bg'=> '',
			'icon_color'=> '',
			'box_shadow' => '',	
			'icon_border_color'=> '',
			'animate'=> 0,
			'animation_type'=>'fadeIn',
			'animation_delay' => 0,
			'margin' => '',
			'custom_space_enabler' => '',
			'custom_space' => '',
			'key' => be_uniqid_base36(true),
		),$atts );

		$output ='';
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_title_icon', $key );
		$unique_class_name = 'tatsu-'.$key;

	

		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '' ;
		$output .= '<div class="tatsu-module tatsu-title-icon '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'">';
		$output .= '<span class="tatsu-ti-wrap tatsu-ti '.$size.' '.$style.' align-'.$alignment.'" ><i class="'.$icon.' tatsu-ti tatsu-ti-icon"></i></span>';
		$output .= '<div class="tatsu-tc tatsu-tc-custom-space align-'.$alignment.' '.$size.' '.$style.'">'.do_shortcode( $content ).'</div>'; 
		$output .= $custom_style_tag;  
		$output .= '</div>';
 		
		return $output; 
	}
	add_shortcode('tatsu_title_icon','tatsu_title_icon');
	add_shortcode('title_icon','tatsu_title_icon');
}

?>