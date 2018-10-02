<?php
/**************************************
			CUSTOM SLIDER
**************************************/
if (!function_exists('be_custom_slider')) {
	function be_custom_slider( $atts, $content ) {
		extract( shortcode_atts( array (
				'animation_type' => 'fxSoftScale',
				'slider_height' => '',
				'slider_mobile_height' => '',
				'load' => 'yes',
	    	), $atts ) );
		$load = ( isset( $load ) && !empty( $load ) && $load == 'no' ) ? 'no-load' : 'loaded';
		$slider_height_style = ( isset( $slider_height ) && !empty( $slider_height ) ) ? 'style="height: '.$slider_height.'px;"' : 'style="height: 100%;"';
		$slider_height = ( isset( $slider_height ) && !empty( $slider_height ) ) ? $slider_height : '100%';
		$slider_mobile_height = ( isset( $slider_mobile_height ) && !empty( $slider_mobile_height ) ) ? $slider_mobile_height : $slider_height;
	    $output = "";
	    $output .= '<div class="component component-fullwidth '.$load.' '.$animation_type.'" data-height="'.$slider_height.'" data-mobile-height="'.$slider_mobile_height.'" data-current="0" '.$slider_height_style.'>';
	    $output .= '<ul class="itemwrap">';
		$output .= do_shortcode( $content );
	    $output .= '</ul>';
	    $output .= '<nav class="component-nav">';
		$output .= '<a class="prev be-slider-prev" href="#"><i class="font-icon icon-arrow_carrot-left"></i></a>';
		$output .= '<a class="next be-slider-next" href="#"><i class="font-icon icon-arrow_carrot-right"></i></a>';
		$output .= '</nav>';
	    $output .= '</div>';
	    return $output;
	}
	add_shortcode( 'be_slider', 'be_custom_slider' );
}

if (!function_exists('be_custom_slide')) {
	function be_custom_slide( $atts, $content ){
			extract( shortcode_atts( array (
				'image' => '',
				'bg_video' => 0,
		        'bg_video_mp4_src' => '',
		        'bg_video_mp4_src_ogg' => '',
		        'bg_video_mp4_src_webm' => '',
		        'content_width' => '',
		        'left' => '',
		        'right' => '',
		        'top' => '',
		        'bottom' => '',
	        	'content_animation_type'=>'fadeIn',
	    	), $atts ) );
	    	$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : 0 ;
	    	$bg_video_slide = ( isset( $bg_video ) && 1 == $bg_video ) ? ' be-slider-video' : '' ;
			$output = '';
	    	$output .= '<li>';
			if ( !empty( $image ) || $bg_video ) {
				//$attachment_info = wp_get_attachment_image_src( $image, 'full' );
				$attachment_url = $image; //$attachment_info[0];
				$output .=  '<div class="be-slide-bg-holder">
								<div class="be-slide-bg be-bg-cover be-bg-parallax '.$bg_video_slide.'" data-image="'.$attachment_url.'">';
									if( isset( $bg_video ) && 1 == $bg_video ) {
										$output .= '<video class="be-bg-video" autoplay="autoplay" loop="loop" muted="muted" preload="auto">';
										$output .=  ($bg_video_mp4_src) ? '<source src="'.$bg_video_mp4_src.'" type="video/mp4">' : '' ;
										$output .=  ($bg_video_mp4_src_ogg) ? '<source src="'.$bg_video_mp4_src_ogg.'" type="video/ogg">' : '' ;
										$output .=  ($bg_video_mp4_src_webm) ? '<source src="'.$bg_video_mp4_src_webm.'" type="video/webm">' : '' ;
										$output .= '</video>';
									} else {
										$output .= '<i class="font-icon loader-style4-wrap loader-icon"></i>';
									}
									if(!empty($left) || ($left == '0') || !empty($right) || ($right == '0') || !empty($top) || ($top == '0') || !empty($bottom) || ($bottom == '0')) {
										$style = 'margin: 0px;';
										if(!empty($left) || ($left == '0')) {
											$style .= 'left: '.$left.'%;';
										}
										if(!empty($right) || ($right == '0')) {
											$style .= 'right: '.$right.'%;';
										}
										if(!empty($top) || ($top == '0')) {
											$style .= 'top: '.$top.'%;';
										}
										if(!empty($bottom) || ($bottom == '0')) {
											$style .= 'bottom: '.$bottom.'%;';
										}
										if(!empty($top) || ($top == '0') || !empty($bottom) || ($bottom == '0')) {
											$style .= 'position: absolute;';
										} else {
											$style .= 'position: relative;';
											if(!empty($right) || ($right == '0')) {
												$style .= 'float: right;';
											} else {
												$style .= 'float: none;';
											}
										}
									} else {
										$style = '';
									}
								$output .=  '</div>
								<div class="be-wrap">
									<div class="be-slider-content-wrap">
										<div class="be-slider-content clearfix">
											<div class="be-slider-content-inner-wrap" style="width: '.$content_width.'%;'.$style.'">';
											if( $content ) {
												$output .=  '<div class="be-animate '.$content_animation_type.' animated be-slider-content-inner">'.do_shortcode( $content ).'</div>';
											}
											$output .=  '</div>
										</div>
									</div>
								</div>
							</div>';
			}
	        $output .='</li>';
	        return $output;
	}
	add_shortcode( 'be_slide', 'be_custom_slide' );
}
?>