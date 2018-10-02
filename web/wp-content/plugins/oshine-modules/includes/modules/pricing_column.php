<?php
/**************************************
			PRICING TABLE
**************************************/
if ( ! function_exists( 'be_pricing_column' ) ) {
	function be_pricing_column( $atts, $content ) {
		global $be_themes_data;
		$atts = shortcode_atts( array(
			'title'=>'',
			'h_tag'=>'h5',
			'price'=>'',
			'duration'=>'',
			'currency'=>'$',
			'button_text'=>'',
			'button_color'=> '',
			'button_hover_color' => '',
			'button_bg_color' => '',
			'button_bg_hover_color' => '',
			'button_border_color' => '',
			'button_border_hover_color' => '',
			'button_link' => '',
			'highlight' => 'no',
			'style'=> 'style-1',
			'header_bg_color' => '',
			'header_color' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts );		


		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'pricing_column', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = '';
		$header_bg_color_cb='';
		$animate = ( isset( $animate ) && 1 == $animate ) ? 'be-animate' : '' ;
		

		$output .= '<ul class="pricing-table sec-border highlight-'.$highlight.' oshine-module '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'">';
	    if( ! empty( $title ) ) {
	    	$output .= ( $style == 'style-1' ) ? '<li class="pricing-title" ><'.$h_tag.' class="sec-color">'.$title.'</'.$h_tag.'></li>' : '<li class="pricing-title" ><'.$h_tag.' class="pricing-title-head-tag" >'.$title.'</'.$h_tag.'></li>' ;
	    }
	    $output .= ( ! empty( $price ) ) ? '<li class="pricing-price"><h2 class="price"><span class="currency">'.$currency.'</span>'.$price.'</h2><span class="pricing-duration special-subtitle">'.$duration.'</span></li>' : '' ; 
	    $output .= do_shortcode( $content );
		// $output .= 	( !empty( $button_text ) && !empty( $button_link ) ) ? '<li class="pricing-button">'.do_shortcode('[tatsu_button button_text= "'.$button_text.'" type= "medium" rounded= "1" icon= "" bg_color ="'.$button_bg_color.'" hover_bg_color = "'.$button_bg_hover_color.'"  border_width= "1" border_color = "'.$button_border_color.'" hover_border_color = "'.$button_border_hover_color.'" color= "'.$button_color.'" hover_color= "'.$button_hover_color.'" url="'.$button_link.'" ]'.$button_text.'[/tatsu_button]').'</li>' : '' ;
		$output .= 	( !empty( $button_text ) && !empty( $button_link ) ) ? '<li class="pricing-button">'.do_shortcode("[tatsu_button button_text= '".$button_text."' type= 'medium' rounded= '1' icon= '' bg_color ='".$button_bg_color."' hover_bg_color = '".$button_bg_hover_color."'  border_width= '1' border_color = '".$button_border_color."' hover_border_color = '".$button_border_hover_color."' color= '".$button_color."' hover_color= '".$button_hover_color."' url='".$button_link."' ]".$button_text."[/tatsu_button]").'</li>' : '' ;
	    $output .= $custom_style_tag.'</ul>';

	    return $output;

	}
	add_shortcode( 'pricing_column', 'be_pricing_column' );
}


if ( ! function_exists( 'be_pricing_feature' ) ) {
	function be_pricing_feature( $atts, $column ) {
		$atts = shortcode_atts( array(
			'feature' => '',
			'highlight' => '',
			'highlight_color' => '',
			'highlight_text_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'pricing_feature', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = '';
		if( ! empty( $feature ) ) {
			if($highlight) {
				$highlight_section = 'highlight';
			} else {
				$highlight_section = 'no-highlight';
			}
			$output .='<li class="pricing-feature '.$highlight_section.' '.$unique_class_name.'" ><span class="pricing-feature-container" >'.$feature.'</span>'.$custom_style_tag.'</li>';
		}
		return $output;
	}
	add_shortcode( 'pricing_feature', 'be_pricing_feature' );
}

?>