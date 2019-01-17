<?php
/**************************************
			SKILlS
**************************************/
if ( ! function_exists( 'tatsu_skills' ) ) {
	function tatsu_skills( $atts, $content ) {
		$atts = shortcode_atts( array( 
			'direction' => 'horizontal',
			'style'		=> 'rect',
            'height' => 400,
            'title_color'   => '',
            'fill_color'    => '',
            'bg_color'      => '',
            'margin'        => '0 0 60px 0',
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_skills', $key );
		$custom_class_name = ' tatsu-'.$key;

		$style = !empty( $style ) ? 'tatsu-skill-' . $style : '';

		global $direction_global;
		$direction = ( isset($direction) && !empty($direction) ) ? $direction : 'horizontal' ;
		$direction_global = $direction;

		return '<div class="skill_container tatsu-module skill-'.$direction.' '.$custom_class_name.' ' . $style . '"><div class="skill clearfix">'.do_shortcode( $content ).'</div>'.$custom_style_tag.'</div>';
	}
}

if ( ! function_exists( 'tatsu_skill' ) ) {
	function tatsu_skill( $atts, $content ) {
		$atts =  shortcode_atts( array( 
			'title' => '',
			'value' => '',
			'fill_color' => '',
			'bg_color' => '',
			'title_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts  );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_skill', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		global $direction_global;
		$output = '<div class="skill-wrap ' . $custom_class_name . ' ">';
		if('horizontal' == $direction_global){
			$output .= '<h6 class="skill_name" >'.$title.'</h6>';
			$output .= '<div class="skill-bar"><span class="be-skill expand alt-bg alt-bg-text-color" data-skill-value="'.$value.'%" ></span></div>';
		}
		if('vertical' == $direction_global){
			$output .= '<div class="skill-bar"><span class="be-skill expand alt-bg alt-bg-text-color" data-skill-value="'.$value.'%" ></span></div>';
			$output .= '<h6 class="skill_name" >'.$title.'</h6>';
		}
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
}
?>