<?php
/**************************************
			SKILlS
**************************************/
if ( ! function_exists( 'be_skills' ) ) {
	function be_skills( $atts, $content ) {
		$atts = shortcode_atts( array( 
			'direction' => 'horizontal',
			'height' => 400,
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'skills', $key );
		$custom_class_name = ' tatsu-'.$key;

		global $direction_global;
		$direction = ( isset($direction) && !empty($direction) ) ? $direction : 'horizontal' ;
		$direction_global = $direction;

		return '<div class="skill_container oshine-module skill-'.$direction.' '.$custom_class_name.'"><div class="skill clearfix">'.do_shortcode( $content ).'</div>'.$custom_style_tag.'</div>';
	}
	add_shortcode( 'skills', 'be_skills' );
}

if ( ! function_exists( 'be_skill' ) ) {
	function be_skill( $atts, $content ) {
		global $be_themes_data;
		$atts =  shortcode_atts( array( 
			'title' => '',
			'value' => '',
			'fill_color' => '',
			'bg_color' => '',
			'title_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts  );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'skill', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		global $direction_global;
		$output = '<div class="skill-wrap ' . $custom_class_name . ' ">';
		if('horizontal' == $direction_global){
			$output .= '<span class="skill_name" >'.$title.'</span>';
			$output .= '<div class="skill-bar"><span class="be-skill expand alt-bg alt-bg-text-color" data-skill-value="'.$value.'%" ></span></div>';
		}
		if('vertical' == $direction_global){
			$output .= '<div class="skill-bar"><span class="be-skill expand alt-bg alt-bg-text-color" data-skill-value="'.$value.'%" ></span></div>';
			$output .= '<span class="skill_name" >'.$title.'</span>';
		}
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'skill', 'be_skill' );
}
?>