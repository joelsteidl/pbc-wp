<?php 

if (!function_exists('tatsu_text')) {
	function tatsu_text( $atts, $content ) {
		$atts = shortcode_atts( array (
			'typography' => '',
			'max_width' => 100,
			'wrap_alignment' => 'center',
			'text_alignment' => '',
	        'scroll_to_animate' => 0,
			'animate' => 0,
	        'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'margin' => '',
			'bg_color' => '',
			'border_radius' => '',
			'box_shadow' => '',
			'padding' =>'',
			'builder_mode' => '',
			'color' => '',
			'light_color' => '',
			'dark_color' => '',
			'hide_in' => '',
			'text_typography' => '',
			'key' => be_uniqid_base36(true),
		),$atts);
		
		extract($atts);
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_text', $key, $builder_mode );
		$custom_class_name = 'tatsu-'.$key;

	    $output = '';
		$visibility_classes = '';
	    $bool = false;
		if( isset( $animate ) && 1 == $animate ) {
			$animate = 'tatsu-animate';
			$bool = true;
		} else {
			$animate = '';
		}
		if( isset( $scroll_to_animate ) && 1 == $scroll_to_animate ) {
	    	$scroll_to_animate = 'scrollToFade';
	    	$bool = true;
	    } else {
			$scroll_to_animate = '';
		}
		
		if($max_width < 100){
			if($wrap_alignment == 'left'){
				//$margin = 'margin-right: 0; margin-left:0;';
				$margin = '';
			}
			if($wrap_alignment == 'center'){
				//$margin = 'margin-right:auto; margin-left:auto;';
				$margin = 'tatsu-align-center';
			}
			if($wrap_alignment == 'right'){
				$margin = 'tatsu-align-right';
			}
		}
		else{
			$margin = ''; 
		}

		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
			}
		}

		$output .= '<div class="tatsu-module tatsu-text-block-wrap '.$custom_class_name.' '.$visibility_classes.'"><div class="tatsu-text-inner '.$margin.' '.$animate.' '.$scroll_to_animate.' clearfix" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'">';
		$output .= $custom_style_tag;
		$output .= do_shortcode(  $content );
		$output .= '</div></div>';
		
	    return $output;
	}
	add_shortcode( 'tatsu_text', 'tatsu_text' );
	add_shortcode( 'text', 'tatsu_text' );
}

if( !function_exists( 'tatsu_text_header_atts' ) ) {
	function tatsu_text_header_atts( $atts, $tag ) {
		if( 'tatsu_text' === $tag ) {
			// New Atts
			$atts['builder_mode'] = array (
				'type' => '',
				'default' => 'Header',
			);
			$atts['hide_in'] = array (
				'type' => 'screen_visibility',
				'label' => __( 'Hide in', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
			);
			$atts['text_typography'] = array(
				'type' => 'typography',
				'label' => __( 'Typography', 'tatsu' ),
				'responsive' => true,
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
						'property' => 'typography',
					)
				),
			);
			$atts['color'] = array (
				'type' => 'color',
				'label' => __( 'Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-text-inner *' => array(
						'property' => 'color'
					),
				),
			);
			// Light Scheme Colors
			$atts['light_color'] = array (
				'type' => 'color',
				'label' => __( 'Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-text-inner' => array(
						'property' => 'color',
						'append' => ' !important'
					),
				),
			);
			// Dark Scheme Colors
			$atts['dark_color'] = array (
				'type' => 'color',
				'label' => __( 'Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-text-inner' => array(
						'property' => 'color',
						'append' => ' !important'
					),
				),
			);
			// Modify Atts
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-text-block-wrap' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_text_header_atts', 10, 2 );
}

?>