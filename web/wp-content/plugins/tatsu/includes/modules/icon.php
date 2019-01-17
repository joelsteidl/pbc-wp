<?php
if (!function_exists('tatsu_icon')) {
	function tatsu_icon( $atts, $content ) {
		$atts = shortcode_atts(array(
			'name' => '',
			'size'=> 'medium',
			'custom_bg_size' => '',
			'custom_icon_size' => '',
			'style'=> 'circle',
			'bg_color'=> '',
			'hover_bg_color'=> '',
			'color'=> '',
			'hover_color'=> '',
			'border_width' => 1,
			'border_color'=> '#323232',
			'hover_border_color'=> '#323232',
			'href'=> '#',
			'alignment' => 'none',
			'lightbox' => 0,
			'image' => '',
			'video_url' => '',
			'new_tab' => 0,
			'animate' => 0,
			'animation_type'=>'fadeIn',
			'animation_delay' => 0,
			'box_shadow' => '',
			'margin' => '',
			'hover_effect' => '',
			'hover_box_shadow' => '',
			'builder_mode' => '',
			'light_color' => '#f5f5f5',
			'light_bg_color' => 'rgba(255,255,255,0.2)',
			'light_border_color' => '#f5f5f5',
			'light_hover_color' => '',
			'light_hover_bg_color' => '',
			'light_hover_border_color' => '',
			'dark_color' => '#232425',
			'dark_bg_color' => 'rgba(255,255,255,0.2)',
			'dark_border_color' => '#232425',
			'dark_hover_color' => '',
			'dark_hover_bg_color' => '',
			'dark_hover_border_color' => '',
			'hide_in' => '',
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_icon', $key, $builder_mode );
		$custom_class_name = 'tatsu-'.$key;
				
		$mfp_class = '';
		$output = '';
		$visibility_classes = '';
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '' ;
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
		$href = ( empty( $href ) ) ? '#' : $href ;
		$hover_effect_parent = $alignment === 'none' && 'none' !== $hover_effect ? $hover_effect : '';
		$hover_effect_child = $alignment !== 'none' && 'none' !== $hover_effect ? $hover_effect : '';




		if( isset( $lightbox ) && 1 == $lightbox ) {
			if( !empty( $video_url ) ) {
				$mfp_class = 'mfp-iframe';
				$href = $video_url;
			} elseif ( !empty($image) ) {
				$mfp_class = 'mfp-image';
				$href = $image;
			}
		}

		//GDPR Privacy preference popup logic
		$gdpr_atts = '{}';
		$gdpr_concern_selector = '';
		if( $mfp_class === 'mfp-iframe' ){
			if( function_exists( 'be_gdpr_privacy_ok' ) ){
				$video_details =  be_get_video_details($video_url);
				if( !empty( $_COOKIE ) ){
					if( !be_gdpr_privacy_ok($video_details['source'] ) ){
						$mfp_class = 'mfp-popup';
						$href = '#gdpr-alt-lightbox-'.$key;
						$output .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
					}
				} else {
					$gdpr_atts = array(
						'concern' => $video_details[ 'source' ],
						'add' => array( 
							'class' => array( 'mfp-popup' ),
							'atts'	=> array( 'href' => '#gdpr-alt-lightbox-'.$key ),
						),
						'remove' => array( 
							'class' => array( $mfp_class )
						)
					);
					$gdpr_concern_selector = 'be-gdpr-consent-required';
					$gdpr_atts = json_encode( $gdpr_atts );
					$output .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
				}
			}
		}
		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
			}
		}

		$output .= '<div class="tatsu-module tatsu-normal-icon tatsu-icon-shortcode align-'.$alignment.' '.$custom_class_name.' '.$hover_effect_parent.' '.$visibility_classes.'">';
		$output .= $custom_style_tag; 
		$output .= '<a href="'.$href.'" class="tatsu-icon-wrap '.$style.' '.$animate.' '.$mfp_class.' '.$hover_effect_child.' '.$gdpr_concern_selector.'" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'" data-gdpr-atts='.$gdpr_atts.' '.$new_tab.'>';
		$output .= ( $style == 'plain' ) ? '<i class="tatsu-icon tatsu-custom-icon tatsu-custom-icon-class '.$name.' '.$size.' '.$style.'"></i></a>' : '<i class="tatsu-icon tatsu-custom-icon tatsu-custom-icon-class '.$name.' '.$size.' '.$style.'"  data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'"></i></a>' ;
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'tatsu_icon', 'tatsu_icon' );
	add_shortcode( 'icon', 'tatsu_icon' );
}

if( !function_exists( 'tatsu_icon_header_atts' ) ) {
	function tatsu_icon_header_atts( $atts, $tag ) {
		if( 'tatsu_icon' === $tag ) {
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
				// Light Scheme Colors
			$atts['light_color'] = array (
				'type' => 'color',
				'label' => __( 'Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['light_bg_color'] = array (
				'type' => 'color',
				'label' => __( 'BG Color', 'tatsu' ),
				'default' => 'rgba(255,255,255,0.2)', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'background-color',
						'when' => array( 
							array( 'style', '!=', 'plain' ),
							array( 'bg_color', '!=', '' )
						),
						'relation' => 'and',
					),
				),
			);
			
			$atts['light_border_color'] = array (
				'type' => 'color',
				'label' => __( 'Border Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'border-color',
						'when' => array(
							array( 'border_width', '!=', '0' ),
							array( 'style', '!=', 'plain' ),
						),
						'relation' => 'and',
					),
				),
			);
			
			$atts['light_hover_color'] = array (
				'type' => 'color',
				'label' => __( 'Hover Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['light_hover_bg_color'] = array (
				'type' => 'color',
				'label' => __( 'Hover BG Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'background-color',
						'when' => array( 'style', '!=', 'plain' ),
					),
				),
			);
			
			$atts['light_hover_border_color'] = array (
				'type' => 'color',
				'label' => __( 'Hover Border Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'border-color',
						'when' => array(
							array( 'border_width', '!=', '0' ),
							array( 'style', '!=', 'plain' ),
						),
						'relation' => 'and',
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
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['dark_bg_color'] = array (
				'type' => 'color',
				'label' => __( 'BG Color', 'tatsu' ),
				'default' => 'rgba(255,255,255,0.2)', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'background-color',
						'when' => array( 
							array( 'style', '!=', 'plain' ),
							array( 'bg_color', '!=', '' )
						),
						'relation' => 'and',
					),
				),
			);
			
			$atts['dark_border_color'] = array (
				'type' => 'color',
				'label' => __( 'Border Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon' => array(
						'property' => 'border-color',
						'when' => array(
							array( 'border_width', '!=', '0' ),
							array( 'style', '!=', 'plain' ),
						),
						'relation' => 'and',
					),
				),
			);
			
			$atts['dark_hover_color'] = array (
				'type' => 'color',
				'label' => __( 'Hover Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['dark_hover_bg_color'] = array (
				'type' => 'color',
				'label' => __( 'Hover BG Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'background-color',
						'when' => array( 'style', '!=', 'plain' ),
					),
				),
			);
			
			$atts['dark_hover_border_color'] = array (
				'type' => 'color',
				'label' => __( 'Hover Border Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-icon:hover' => array(
						'property' => 'border-color',
						'when' => array(
							array( 'border_width', '!=', '0' ),
							array( 'style', '!=', 'plain' ),
						),
						'relation' => 'and',
					),
				),
			);
			// Modify Atts
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 15px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-normal-icon' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts
			unset( $atts['alignment'] );
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_icon_header_atts', 10, 2 );
}

?>