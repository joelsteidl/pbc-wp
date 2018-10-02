<?php
/**************************************
			DROP CAPS - STYLE 2
**************************************/
if ( ! function_exists( 'tatsu_dropcap2' ) ) {
	function tatsu_dropcap2( $atts ) {
		$atts = shortcode_atts( array(
	        'letter'=>'',
	        'icon'=>'',
	        'size' =>'60',
	        'color'=>'',
	        'dropcap_title'=>'',
	        'title_color' => '',
	        'title_font' => '',
			'animate'=>0,
	        'animation_type'=>'fadeIn',
			'margin' => '',
			'key' => be_uniqid_base36(true),
		), $atts );
		
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_dropcap2', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output="";
		if( !empty( $icon ) ) {
			$letter = '<span class="tatsu-dropcap" ><i class="tatsu-icon '.$icon.'" ></i></span>';
		}else{
			$letter = '<h6 class="tatsu-dropcap" >'.$letter.'</h6>';
		}

		$animate = ( isset( $animate ) && 1 == $animate ) ? 'tatsu-animate' : '' ;

		$title_tag = 'div';
		if ('body' == $title_font){
			$title_font_style = 'body-font';
		} elseif ('special' == $title_font){
			$title_font_style = 'special-subtitle';
		} else {
			$title_font_style = '';
			$title_tag = $title_font;
		}

		$output .= '<div class="tatsu-dropcap-wrap tatsu-module style2 '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'">';
		$output .= $letter;
		$output .= !empty($dropcap_title) ? '<'.$title_tag.' class= "tatsu-dropcap-title '.$title_font_style.'" ><span class="tatsu-dropcap-title-color">'.$dropcap_title.'</span></'.$title_tag.'>' : '' ;
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;	
	}
	add_shortcode( 'tatsu_dropcap2', 'tatsu_dropcap2' );
}
?>