<?php
/**************************************
			CLIENTS
**************************************/
if ( ! function_exists( 'be_clients' ) ) {
	function be_clients($atts, $content) {
		global $be_themes_data;
		extract( shortcode_atts( array(
			'slide_show' => '1',
			'slide_show_speed' => 4000,
	    ), $atts ) );
	    $slide_show = ( !empty( $slide_show ) ) ? 1 : 0 ;
		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;
		$output = '<div class="carousel-wrap oshine-module clearfix">';
		// $output .='<ul class="be-carousel client-carousel" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'">';
		$output .= '<ul class="be-owl-carousel client-carousel-module" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'">';
		$output .= do_shortcode($content);
		$output .= '</ul>';
		// $output .='<a class="prev be-carousel-nav" href="#"><i class="font-icon icon-arrow_carrot-left"></i></a><a class="next be-carousel-nav" href="#"><i class="font-icon icon-arrow_carrot-right"></i></a>';
		$output .='</div>';
		return $output;
	}
	add_shortcode('clients','be_clients');
}

if ( ! function_exists( 'be_client' ) ) {
	function be_client( $atts, $content ) {
		extract( shortcode_atts( array(
			'image' => '',
			'link' => '',
			'new_tab'=> 1,
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
	    ), $atts ) );

	    $output =  '';
	    if($default_image_style == 'black_white') {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'bw_to_bw';
			} else {
				$img_grayscale = 'bw_to_c';
			}
		} else {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'c_to_bw';
			} else {
				$img_grayscale = 'c_to_c';
			}
		}

		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
	    $link = ( !empty( $link ) ) ? $link : '#' ; 
	   // $attachment = wp_get_attachment_image_src( $image , 'full');
	   // $url = $attachment[0];
	    $output .= ( !empty( $image ) ) ? '<li class="carousel-item client-carousel-item '.$img_grayscale.'"><a href="'.$link.'" '.$new_tab.'><img src="'.$image.'" alt="" /></a></li>' : '' ;
	   // $output .= ( $url ) ? '<li class="carousel-item client-carousel-item '.$img_grayscale.'"><img src="'.$url.'" alt="" /></li>' : '' ;
	    return $output;
	}
	add_shortcode( 'client', 'be_client' );
}
?>