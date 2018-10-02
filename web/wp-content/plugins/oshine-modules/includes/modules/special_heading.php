<?php
/**************************************
			SPECIAL TITLE 1
**************************************/
if (!function_exists('be_special_heading')) {
	function be_special_heading( $atts, $content ) {
		global $be_themes_data;
		$atts = shortcode_atts( array (
			'title_align' => 'center',
			'title_content' => '',
			'h_tag' => 'h3',
			'title_color' => '',
			'subtitle_spl_font' => '',
			'disable_separator' => 0,
			'separator_style' => '1',
			'icon_name' => '',
			'default_icon' => 0,
			'icon_color' => '' ,
			'separator_thickness' => '2' ,
			'separator_width' => '40' ,
			'separator_pos' => '0' ,
	        'separator_color' => '#323232',
			'scroll_to_animate'=> 0,
			'animate'=> 0,
	        'animation_type'=> 'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'special_heading', $key );
		$unique_class_name = 'tatsu-'.$key;

	    $output ='';
	    $animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;
	    $subtitle_spl_font = ( isset( $subtitle_spl_font ) && 1 == $subtitle_spl_font ) ? ' special-subtitle' : '';
	    $title_align = ( isset( $title_align ) && !empty($title_align) ) ? $title_align : 'center';
		$seperator_color = '';
		if( !( $disable_separator ) ){
			if( !empty( $separator_style ) ){
				$sep_output = '<div class="sep-with-icon-wrap margin-bottom"><span class="sep-with-icon" ></span><i class="sep-icon font-icon '.$icon_name.'"></i><span class="sep-with-icon" ></span></div>';
			} else {
				$sep_output = '<hr class="separator margin-bottom" />';
			}
		}
		else{
			$sep_output = '';
		}
		
		$output .='<div class="special-heading-wrap style1 oshine-module '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'"><div class="special-heading align-'.$title_align.'">';
		$output .= ($title_content) ? '<'.$h_tag.' class="special-h-tag" >'.$title_content.'</'.$h_tag.'>' : '' ;
		if (isset($separator_pos) && 1 == $separator_pos) { //Place Divider Above Header
			$output .= $sep_output;
			$output .= ($content) ? '<div class="sub-title margin-bottom '.$subtitle_spl_font.'">'.$content.'</div>' : '' ;
		}
		else {
			$output .= ($content) ? '<div class="sub-title margin-bottom '.$subtitle_spl_font.'">'.$content.'</div>' : '' ;
			$output .= $sep_output;
		}
		$output .='</div>'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'special_heading', 'be_special_heading' );
}

add_filter( 'special_heading_before_css_generation', 'special_heading_css' );
function special_heading_css( $atts ) {
	$atts['separator_width'] = $atts['separator_style'] == '1' ? $atts['separator_width'] / 2 : $atts['separator_width'] ;
	return $atts;
}

?>