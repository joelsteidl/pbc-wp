<?php
if (!function_exists('tatsu_button')) {
	function tatsu_button( $atts, $content, $module_name = '' ) {
		$atts = ( shortcode_atts( array (
			'button_text' => '',
			'icon' => 'none',
			'icon_alignment' => '',
			'url' => '',
			'new_tab'=> 'no',
			'type' => 'small',
			'alignment' => '',							 
			'bg_color' => '',
			'hover_bg_color' => '',
			'color'=> '',
			'hover_color'=> '',
			'border_width' => 0,			
			'border_color'=> '',
			'hover_border_color'=> '',
			'button_style' => 'none',
			'lightbox' => 0,	
			'image' => '',
			'video_url' => '',
			'background_animation' => 'none',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'enable_box_shadow' => 0,
			'box_shadow' => '',
			'typography' => '',
			'enable_margin' => '',
			'margin' => '',
			// 'custom_button_height' => '',
			// 'custom_button_width' => '',
			// 'custom_text_size' => '',
			// 'custom_text_letter_spacing' => '',
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
		), $atts ) );
		
		extract( $atts );

		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_button', $key , $builder_mode );
		$custom_class_name = 'tatsu-'.$key;
		
		$mfp_class = '';
		$output = '';
		$visibility_classes = '';
		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
		
		$background_animation = ( !empty( $background_animation ) && 'none' != $background_animation ) ? $background_animation : 'bg-animation-none';

		$alignment = ( "block" === $type ) ? 'center' : $alignment;
		if( isset( $alignment ) ){
			if( $alignment != 'none' ){
				$alignment = 'align-block block-'.$alignment;
			} else {
				$alignment = '';
			}
		}
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : ''; 
		$button_style = ( isset( $button_style ) && !empty( $button_style ) ) ? $button_style : '';

		$hover_effect = !empty( $hover_effect ) && 'none' !== $hover_effect ? $hover_effect : '';
		
		$url = ( empty( $url ) ) ? '#' : $url ;

		$image_wrap_class = '';

		if( $lightbox && 1 == $lightbox ) {
			if( !empty( $video_url ) ) {
				$mfp_class = 'mfp-iframe';
				$url = $video_url;
			} elseif ( !empty($image) ) {
				$mfp_class = 'mfp-image';
				$url = $image;
			}
		}
		
		if( 'none' === $button_style ) {
			$button_style = '';
		}

		$bg_color = !empty( $bg_color[1] )? be_compute_color( $bg_color )[1] : 'transparent';

		$hover_bg_color = be_compute_color( $hover_bg_color );
		$hover_bg_color = !empty( $hover_bg_color[1] )? $hover_bg_color[1] : 'transparent';

		$bg_animation_css = '';
		if($background_animation != 'bg-animation-none') {
			if($background_animation == 'bg-animation-slide-top' || $background_animation == 'bg-animation-slide-bottom') {
				$bg_animation_css = 'background-image: linear-gradient(to bottom, '.$bg_color.' 50%, '.$hover_bg_color.' 50%);';
			}
			if($background_animation == 'bg-animation-slide-left' || $background_animation == 'bg-animation-slide-right') {
				$bg_animation_css = 'background-image: linear-gradient(to right, '.$bg_color.' 50%, '.$hover_bg_color.' 50%);';
			}
		}

		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
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
						$url = '#gdpr-alt-lightbox-'.$key;
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
		
		$icon = ( isset($icon) && !empty($icon) && ($icon != 'none') ) ? '<i class="tatsu-icon '.$icon.'"></i>' : '' ;
		$icon_alignment = ( isset($icon_alignment) && !empty($icon_alignment) ) ? $icon_alignment : 'left' ;
		$button_text = ( $icon_alignment == 'right' ) ? $button_text.$icon : $icon.$button_text ;

		$output .= '<div class="tatsu-module tatsu-normal-button tatsu-button-wrap '.$alignment.' '.$image_wrap_class.' '.$custom_class_name.' '.$hover_effect.' '.$visibility_classes.'">';
		$output .= '<a class="tatsu-shortcode '.$type.'btn tatsu-button '.$icon_alignment.'-icon '.$button_style.' '.$animate.' '.$mfp_class.' '.$background_animation.' ' . $gdpr_concern_selector .' " href="'.$url.'" style= "'.$bg_animation_css.'" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'" data-gdpr-atts='.$gdpr_atts.' '.$new_tab.'>'.$button_text.'</a>' ; 
		$output .= $custom_style_tag;
		$output .= '</div>'; 
		return $output;
	}
	add_shortcode( 'tatsu_button', 'tatsu_button' );
	add_shortcode( 'button', 'tatsu_button' );
}


if( !function_exists( 'tatsu_button_header_atts' ) ) {
	function tatsu_button_header_atts( $atts, $tag ) {
		if( 'tatsu_button' === $tag ) {
			// New Atts
			$atts['builder_mode'] = 	array (
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
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
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
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'background-color',
						'when' => array( 'bg_color', '!=', '' )
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
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
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
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
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
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'background-color',
						'when' => array( 'bg_color', '!=', '' )
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
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
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
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
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
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'background-color',
						'when' => array( 'bg_color', '!=', '' )
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
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
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
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
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
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'background-color',
						'when' => array( 'bg_color', '!=', '' )
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
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
					),
				),
			);
			// Modify Atts
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-normal-button' => array(
						'property' => 'margin',
					)
				),
			);
			// Remove Atts
			unset( $atts['enable_margin'] );
			unset( $atts['alignment'] );
			unset( $atts['background_animation'] );
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_button_header_atts', 10, 2 );
}


?>