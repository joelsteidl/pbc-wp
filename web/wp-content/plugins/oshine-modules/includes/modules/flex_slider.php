<?php
/**************************************
			BE IMAGE SLIDER
**************************************/
if (!function_exists('be_flex_slider')) {
	function be_flex_slider( $atts, $content ) {
		extract( shortcode_atts( array(
	        'animation'=> 'fade',
			'slide_show' => '0',
			'slide_show_speed' => 1000,
	    ), $atts ) );
	    global $be_themes_data;
		if(!isset($be_themes_data['slider_navigation_style']) || empty($be_themes_data['slider_navigation_style'])) {
			$arrow_style = 'style1-arrow';
		} else {
			$arrow_style = $be_themes_data['slider_navigation_style'];
		}
	    $slide_show = ( !empty( $slide_show ) ) ? 1 : 0 ;
		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;
		
	    $output = "";
	    $output .= '<div class="be_image_slider oshine-module '.$arrow_style.'"><div class="image_slider_module slides" data-animation="'.$animation.'" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'">';
		$output .= do_shortcode( $content );
	    // $output .= '</ul><div class="font-icon loader-style4-wrap loader-icon"></div>';
	    $output .= '</div></div>';
	    return $output;
	}
	add_shortcode( 'flex_slider', 'be_flex_slider' );
}

if (!function_exists('be_flex_slide')) {
	function be_flex_slide( $atts, $content ){
			extract( shortcode_atts( array(
				'image'=>'',
				'video'=>'',
	        	'size'=>'full',
	    	), $atts ) );

			$output = '';
	    	$output .= '<div class="be_image_slide">';
			if( ! empty( $video ) ) {	
				$videoType = be_themes_video_type( $video );
				if( $videoType == "youtube" ) {
					$video_id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video, $match ) ) ? $match[1] : $video_id ; 
					$output.='<iframe width="940" height="450" src="https://www.youtube.com/embed/'.$video_id.'" allowfullscreen></iframe>';
				}
				elseif( $videoType == "vimeo" ) {
					sscanf( parse_url( $video, PHP_URL_PATH ), '/%d', $video_id );
					$output.='<iframe src="https://player.vimeo.com/video/'.$video_id.'" width="500" height="281" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
				}
			} else {
				if ( !empty( $image ) ) { // check if the post has a Post Thumbnail assigned to it.
					//$attachment_info = wp_get_attachment_image_src( $image, $size );
					//$attachment_url = $attachment_info[0];
					$output .=  '<img src="'.$image.'" alt="" />';
				}
			}
	        $output .='</div>';

	        return $output;
	}
	add_shortcode( 'flex_slide', 'be_flex_slide' );
}
?>