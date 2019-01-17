<?php
if (!function_exists('tatsu_gradient_button')) {
	function tatsu_gradient_button( $atts, $content, $module_name = '' ) {
		
		$atts = shortcode_atts( array (
			'button_text' => '',
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
			'lightbox' => 0,	
			'image' => '',
			'video_url' => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			// 'enable_box_shadow' => 0,
			// 'box_shadow_custom' => '',
			'enable_margin' => '',
			'margin' => '',
			// 'custom_button_height' => '',
			// 'custom_button_width' => '',
			// 'custom_text_size' => '',
			// 'custom_text_letter_spacing' => '',
			'hover_effect' => '',
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
		), $atts ) ;
		
		extract( $atts );

		//$custom_style_tag = !empty( $module_name ) ? be_generate_css_from_atts( $atts, 'tatsu_gradient_button', $key ) : '';
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gradient_button', $key, $builder_mode );
		$custom_class_name = 'tatsu-'.$key;
	
		$mfp_class = '';
		$output = '';
		$visibility_classes = '';

		$alignment = ( "block" === $type ) ? 'center' : $alignment;
		if( isset( $alignment ) ){
			if( $alignment != 'none' ){
				$alignment = 'align-block block-'.$alignment;
			} else {
				$alignment = '';
			}
		}

		$new_tab = ( isset( $new_tab ) && 1 == $new_tab ) ? 'target="_blank"' : '' ;
		
		$hover_bg_class =  empty( $hover_bg_color ) ? 'transparent_hover_bg' : '';

		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : ''; 

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

		$hover_effect = !empty( $hover_effect ) && 'none' !== $hover_effect ? $hover_effect : '';

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

		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
			}
		}
		$output .= '
		<div class="tatsu-module tatsu-gradient-button tatsu-button-container '.$alignment.' '.$custom_class_name.' '.$hover_bg_class.' '.$hover_effect.' '.$visibility_classes.'">
			<div class="tatsu-button-wrap ' . $animate . '" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'">
				<a class="tatsu-button tatsu-custom-button-size ' .$mfp_class.' '.$type.'btn '. $gdpr_concern_selector .'" href="'.$url.'" data-gdpr-atts='.$gdpr_atts.' '.$new_tab.'>
					<span class="tatsu-button-text " data-text="'.$button_text.'"><span class="default">'.$button_text.'</span></span>
				</a> 
			</div>
			'.$custom_style_tag.'
		</div>';
		//$output .= $custom_style_tag;
		return $output;
	}
	add_shortcode( 'tatsu_gradient_button', 'tatsu_gradient_button' );
}

if( !function_exists( 'tatsu_gradient_button_header_atts' ) ) {
	function tatsu_gradient_button_header_atts( $atts, $tag ) {
		if( 'tatsu_gradient_button' === $tag ) {
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
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button-text span' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['light_bg_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'BG Color', 'tatsu' ),
				'default' => 'rgba(255,255,255,0.2)', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:after' => array(
						'property' => 'background',
						'when' => array( 'bg_color', '!=', '' )
					),
				),
			);
			
			$atts['light_border_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Border Color', 'tatsu' ),
				'default' => '#f5f5f5', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button-wrap:after' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
					),
				),
			);
			
			$atts['light_hover_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Hover Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button-text:after' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['light_hover_bg_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Hover BG Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:before' => array(
						'property' => 'background',
						'when' => array( 'bg_color', '!=', '' )
					),
				),
			);
			
			$atts['light_hover_border_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Hover Border Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.light:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button-wrap:before' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
					),
				),
			);
				// Dark Scheme Colors
			$atts['dark_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button-text span' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['dark_bg_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'BG Color', 'tatsu' ),
				'default' => 'rgba(255,255,255,0.2)', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:after' => array(
						'property' => 'background',
						'when' => array( 'bg_color', '!=', '' )
					),
				),
			);
			
			$atts['dark_border_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Border Color', 'tatsu' ),
				'default' => '#232425', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button-wrap:after' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0px' ),
					),
				),
			);
			
			$atts['dark_hover_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Hover Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button-text:after' => array(
						'property' => 'color',
					),
				),
			);
			
			$atts['dark_hover_bg_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Hover BG Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button:hover' => array(
						'property' => 'background',
						'when' => array( 'bg_color', '!=', '' )
					),
				),
			);
			
			$atts['dark_hover_border_color'] = array (
				'type' => 'color',
				'options' => array ( 'gradient' => true ),
				'label' => __( 'Hover Border Color', 'tatsu' ),
				'default' => '', 
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'#tatsu-header-wrap.transparent.dark:not(.stuck) .tatsu-header.apply-color-scheme .tatsu-{UUID} .tatsu-button-wrap:before' => array(
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
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-button-container' => array(
						'property' => 'margin',
					),
					'.tatsu-{UUID}.tatsu-gradient-button' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts
			unset( $atts['enable_margin'] );
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_gradient_button_header_atts', 10, 2 );
}

?>