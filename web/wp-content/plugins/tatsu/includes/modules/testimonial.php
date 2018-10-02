<?php
/**************************************
			BUBBLE TESTIMONIAL
**************************************/
if (!function_exists('tatsu_testimonial')) {	
	function tatsu_testimonial( $atts ) {
		$atts = shortcode_atts( array (
			'description' => '',
			'content_color' => '',
			'bg_color' => '',
			'author_image' => '',
			'author' => '',
			'author_color'=> '',
			'author_role' => '',
			'author_role_color' => '',
			'alignment' => 'center',
			'box_shadow' => '',
			'key' => be_uniqid_base36(true),
		), $atts );
		
		extract($atts);
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_testimonial', $key );
		$unique_class_name = 'tatsu-'.$key;

		$output = '';
		
		$alt_text = $author;
		$author = (isset( $author ) && !empty( $author )) ? '<h6 class="tatsu_testimonial_author">'.$author.'</h6>' : '';
		
		$author_role = (isset( $author_role ) && !empty( $author_role )) ? '<div class="tatsu_testimonial_role">'.$author_role.'</div>' : '';
		$alignment = (isset($alignment) && !empty($alignment)) ? $alignment : 'center';

		if ( !empty( $author_image ) ) {
			//$author_image = tatsu_get_image_from_url( $author_image, 'thumbnail' );
			$author_image =  '<div class="tatsu_testimonial_img"><img src="'.$author_image.'" alt="'.$alt_text.'" /></div>';
		}
		$output .= '<div class="tatsu_testimonial_wrap '.$unique_class_name.' clearfix bubble_'.$alignment.'"><div class="tatsu_testimonial_wrap"><div class="tatsu_testimonial_inner_wrap">';
		$output .= '<i class="tatsu-icon icon-quote"></i>';
		$output .= '<div class="tatsu_testimonial_content"><div class="tatsu_testimonial_description">'.$description.'</div></div>';
		$output .= '</div></div>';
		$output .= '<div class="tatsu_testimonial_info_wrap clearfix">';
		$output .= $author_image;
		$output .= '<div class="tatsu_testimonial_info">';
		$output .= $author;
		$output .= $author_role;
		$output .= '</div>';
		$output .= '</div>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		
		return $output;
	}	
	add_shortcode( 'tatsu_testimonial', 'tatsu_testimonial' );
}
?>