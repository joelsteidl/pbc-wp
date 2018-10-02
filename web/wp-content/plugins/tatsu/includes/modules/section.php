<?php
if (!function_exists('tatsu_section')) {
	function tatsu_section( $atts, $content ) {
		$atts = shortcode_atts( array(
	        'bg_color' => '',
	        'bg_image' => '',
	        'bg_repeat' => 'repeat',
	        'bg_attachment' => 'scroll',
	        'bg_position' => 'left top',
	        'bg_size' => 'initial',
	        'bg_animation' => 'none',
	        'border' => '0px 0px 0px 0px',
	        'border_color' => '',
	        'padding' => '0px 0px 0px 0px',
	        'margin' => '0px 0px 0px 0px',
	        'offset_section' => 0,
			'offset_value' => '',
			'top_divider'				=> 'none',
			'bottom_divider'			=> 'none',
			'top_divider_height'		=> '100',
			'bottom_divider_height'		=> '100',
			'top_divider_color'			=> '#000',
			'bottom_divider_color'		=> '#000',
			'invert_top_divider'		=> '0',
			'invert_bottom_divider' 	=> '0',
			'flip_top_divider'			=> '0',
			'flip_bottom_divider'		=> '0',
			'top_divider_position'		=> 'over',
			'bottom_divider_position'	=> 'over',
	        'bg_video' => 0,
	        'bg_video_mp4_src' => '',
	        'bg_video_ogg_src' => '',
	        'bg_video_webm_src' => '',
			'bg_overlay' => 0,
			'overlay_color' => '',
			'overlay_opacity' => '',
			'section_id' => '',
			'section_class' => '',
			'section_title' => '',
			'full_screen' => 0,
			'full_screen_header_scheme' => 'background--dark',
			'hide_in' => '',
			'key' => be_uniqid_base36(true),
		),$atts);
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts($atts, 'tatsu_section', $key);
		$custom_class_name = 'tatsu-'.$key;

	//    $background = '';
	    $bg_video_markup = '';
	    $bg_video_class = '';
	    $bg_overlay_class = '';
	    $bg_overlay_markup = '';
	    $fullscreen_wrap_start = '';
	    $fullscreen_wrap_end = '';
	    $fullscreen_class = '';
		$offset_section_class = '';
	    $offset_wrapper_start = '';
	    $offset_wrapper_end = '';
	    $parallax_markup = '';
	    $hover_3d_wrap_start = '';
		$hover_3d_wrap_end = '';
		$padding_top = ''; 
	    $classes = '';	    
		$output = '';
		

	    //$hide_mobile = (isset($hide_mobile) && $hide_mobile == 1) ? 'hide-mobile' : '';

	    if( !isset($bg_animation) || empty($bg_animation) || $bg_animation == 'none' ) {
	    	$bg_animation = '';
	    } else {
	    	$classes .= ' '.$bg_animation;
	    }

		if( 'tatsu-parallax' == $bg_animation ) {
			$bg_repeat = 'no-repeat';
			$bg_size = 'cover';
			$bg_attachment = 'scroll';
			$bg_position = 'center center';
		}  
		$padding_values = json_decode( $padding, true );
		if( is_array( $padding_values ) ) {
			$padding = !empty( $padding_values['m'] ) ? explode(' ', $padding_values['m'] ) : explode(' ', $padding_values['d'] );
		} else {
			$padding = explode( ' ', $padding );
		} 
		if( isset( $padding[0] ) ) {
			$padding_top = $padding[0];
		} 

		//Handle Parallax
	    if( 'tatsu-parallax' == $bg_animation ) {
	    	//$classes .= ' tatsu-parallax';
	    	$parallax_markup = '<div class="tatsu-parallax-element-wrap"><div class="tatsu-parallax-element" ></div></div>';
	    	$background = '';
		}
		
		//Handle Full Screen Section
		if( ( isset( $full_screen ) && 1 == $full_screen ) ) {
			$classes .= ' tatsu-fullscreen';
			$fullscreen_wrap_start = '<div class="tatsu-fullscreen-wrap">';
			$fullscreen_wrap_end = '</div>';
		}

	    // Handle Section Offset
	    if( isset($offset_section) && 1 == $offset_section && !empty( $offset_value ) ) {
	    	$classes .= ' tatsu-section-offset';
	    	$offset_wrapper_start = '<div class="tatsu-section-offset-wrap">';
	    	$offset_wrapper_end = '</div>';
	    }


	    // Handle BG Video
		if( isset( $bg_video ) && 1 == $bg_video ) {
			$classes .= ' tatsu-video-section';
			$bg_video_markup .= '<video class="tatsu-bg-video" autoplay="autoplay" loop="loop" muted="muted" preload="auto">';
			$bg_video_markup .=  ($bg_video_mp4_src) ? '<source src="'.$bg_video_mp4_src.'" type="video/mp4">' : '' ;
			$bg_video_markup .=  ($bg_video_ogg_src) ? '<source src="'.$bg_video_ogg_src.'" type="video/ogg">' : '' ;
			$bg_video_markup .=  ($bg_video_webm_src) ? '<source src="'.$bg_video_webm_src.'" type="video/webm">' : '' ;
			$bg_video_markup .= '</video>';
		}

		//Handle BG Overlay
		if( isset( $bg_overlay ) && 1 == $bg_overlay ) {
			$classes .= ' tatsu-bg-overlay';
			$bg_overlay_markup .= '<div class="tatsu-overlay tatsu-section-overlay"></div>';
		}

		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$classes .= ' tatsu-hide-'.$device;
			}
		}

		//top shape divider
		$top_divider_html = '';
		if( !empty( $top_divider ) && 'none' !== $top_divider ) {
			//$classes .= ' tatsu-divider-section';
			$top_divider_location = TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/top/' . $top_divider .'.svg';
			$top_divider_svg = @file_get_contents( $top_divider_location );
			if( !empty( $top_divider_svg ) ) {
				$top_divider_classes = array( 'tatsu-shape-divider', 'tatsu-top-divider' );
				if( !empty( $invert_top_divider ) ) {
					$top_divider_classes[] = 'tatsu-invert-divider';
				}
				if( !empty( $flip_top_divider ) ) {
					$top_divider_classes[] = 'tatsu-flip-divider';
				}
				if( !empty( $top_divider_position ) && 'over' === $top_divider_position ) {
					$top_divider_classes[] = 'tatsu-shape-over';
				}
				$top_divider_classes = implode( ' ', $top_divider_classes );
				$top_divider_html =  '<div class = "' . $top_divider_classes . '">';
				$top_divider_html .= $top_divider_svg;
				$top_divider_html .= '</div>';
			}
		}

		//bottom shape divider
		$bottom_divider_html = '';
		if( !empty( $bottom_divider ) && 'none' !== $bottom_divider ) {
			// if( false === strpos( $classes, 'tatsu-divider-section' ) ) {
			// 	$classes .= ' tatsu-divider-section';
			// }
			$bottom_divider_location = TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/bottom/' . $bottom_divider .'.svg';
			$bottom_divider_svg = file_get_contents( $bottom_divider_location );
			if( !empty( $bottom_divider_svg ) ) {
				$bottom_divider_classes = array( 'tatsu-shape-divider', 'tatsu-bottom-divider' );
				if( !empty( $invert_bottom_divider ) ) {
					$bottom_divider_classes[] = 'tatsu-invert-divider';
				}
				if( !empty( $flip_bottom_divider ) ) {
					$bottom_divider_classes[] = 'tatsu-flip-divider';
				}
				if( !empty( $bottom_divider_position ) && 'over' == $bottom_divider_position ) {
					$bottom_divider_classes[] = 'tatsu-shape-over';
				}
				$bottom_divider_classes = implode( ' ', $bottom_divider_classes );
				$bottom_divider_html = '<div class = "' . $bottom_divider_classes . '">';
				$bottom_divider_html .= $bottom_divider_svg;
				$bottom_divider_html .= '</div>';
			}
		}
					
		// getModuleStyles($atts);
		//Append to custom classes 
		$section_class = !empty($section_class) ? str_replace(',', ' ', $section_class) : '' ;
		$section_class = $classes.' '.$section_class;

		if( !empty( $section_id ) ) {
			$section_id = 'id="'.$section_id.'"';
		}

	//	$output .= $hover_3d_wrap_start;
	    
	    $output .= '<div '.$section_id.' class="'.$custom_class_name.' tatsu-section '.$section_class.' tatsu-clearfix" data-title="'.$section_title.'" data-headerscheme="'.$full_screen_header_scheme.'">';
		$output .= $top_divider_html;
		$output .= $fullscreen_wrap_start; 
		$output .= '<div class="tatsu-section-pad clearfix" data-padding-top="'.$padding_top.'">';  
	    $output .= $offset_wrapper_start;	
	    $output .= do_shortcode( $content );
		$output .= $offset_wrapper_end;
		$output .= '</div>';
		$output .= $parallax_markup;
		$output .= $bg_video_markup;				
		$output .= $bg_overlay_markup;		
		$output .= $fullscreen_wrap_end;
		$output .= $bottom_divider_html;

		$output .= $custom_style_tag;

	    $output .= '</div>';
	//	$output .= $hover_3d_wrap_end;
		
		return $output;
	}
	add_shortcode( 'tatsu_section', 'tatsu_section' );
	add_shortcode( 'section', 'tatsu_section' );
}
?>