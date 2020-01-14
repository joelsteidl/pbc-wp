<?php
/**************************************
	        SINGLE IMAGE
**************************************/
if (!function_exists('tatsu_image')) {
	function tatsu_image( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'enable_margin'     => 'null',
            'margin'            => '0 0 0 0',
            'alignment'         => '',
            'border_width'      => 0,
            'border_color'      => 'transparent',
            'image'             => '',
            'id'                => '',
            'size'              => '',
            'adaptive_image'    => 0,
            'max_width'         => '100',
            'rebel'             => 0,
            'lazy_load'         => '',
            'placeholder_bg'    => '',
            'shadow'            => 'none',
            'custom_shadow'     => '',
            'drop_shadow'       => '',
            'width'             => '100%',
            'lightbox'          => 0,
            'link'              => '',
            'new_tab'           => 0,
            'animate'           => 0,
			'animation_type'    =>'none',
			'animation_delay'   => 0,
            //'margin'            => '',
            'border_radius'     => '',
            'image_offset'      => 'null',
            'offset'            => '',
            'builder_mode'      => '',
			'key'               => be_uniqid_base36(true),
        ), $atts, $tag );

        
        extract( $atts );
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'], $builder_mode );
        $unique_class_name = ' tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );
        $id = ( isset( $id ) ) ? $id : '';
        //$border_width = ( isset( $border_width ) && !empty( $border_width ) ) ? $border_width : '0';
        //$border_color = ( isset( $border_color ) && !empty( $border_color ) ) ? $border_color : 'transparent';
        $alignment = ( isset( $alignment ) && !empty( $alignment ) ) ? $alignment : 'none';
        $size = ( isset( $size ) && !empty( $size ) ) ? $size : 'full';
        $rebel = ( isset( $rebel ) && !empty( $rebel ) && 'full' == $size ) ? 1 : 0;
        $width = ( isset( $width ) && !empty( $width ) && 1 == $rebel ) ? (int)$width : 0;
        $lazy_load = ( isset($lazy_load)  && !empty($lazy_load) ) ? $lazy_load : 0 ;
        if( 1 == $lazy_load ) {
            $lazy_load_class = ' tatsu-image-lazyload';
        }else{
            $lazy_load_class = '';
        }        
        if( 1 == $lazy_load && !empty( $placeholder_bg ) ){
            $placeholder_bg = be_compute_color( $placeholder_bg );
            $placeholder_bg = 'background : '. $placeholder_bg[0] .';';
        }else{
            $placeholder_bg = '';
        }   

        if( 'none' != $alignment ) {
            $alignment_class = ' align-' . $alignment;
        }else{
            $alignment_class = '';
        } 

        $id = (int)$id;
        $img_srcset = '';
        $image_src = '';
        $image_atts = array();
        $image_full_src = '';
        $is_external_image = true;
        $image_width = 0;
        $image_height = 0;
        $padding = '';
        $overflow_image_class = '';
        $external_image_class = '';
        $maxWidth = '';
        $alt_text = '';        
        //$image = wp_get_attachment_image_src( $id, $size );
		$upload_dir_paths = wp_upload_dir();
		if ( false !== strpos( $image, $upload_dir_paths['baseurl'] ) ) {
            $image_details = wp_get_attachment_image_src( $id, $size );
            if( $image_details ) {
                if( 0 == $image_details[2] || 0 ==  $image_details[1] ) {
                    $image_src = $image_details[0];
                    $image_atts[] = sprintf( 'alt = "%s"', get_post_meta( $id, '_wp_attachment_image_alt', true) );
                    $image_atts[] = sprintf( 'src = "%s"', $image_src );
                    $lazy_load_class = '';
                    $lazy_load = 0;
                    $maxWidth = 'width : 100%;';
                }else {
                    $image_src = $image_details[0];
                    $image_width = $image_details[1];
                    $image_height = $image_details[2];
                    $image_atts[] = sprintf( 'alt = "%s"', get_post_meta( $id, '_wp_attachment_image_alt', true) );
                    $padding = 'padding-bottom : '.( ( $image_height / $image_width ) * 100 ).'%;';
                    if( isset( $adaptive_image ) && $adaptive_image == 1 ) {
                        $img_srcset = wp_get_attachment_image_srcset( $id, $size );
                        $sizes = wp_calculate_image_sizes( $size, null, null, $id );
                        if( !empty( $img_srcset ) ) {
                             $image_atts[] = !empty( $lazy_load ) ? sprintf( 'data-srcset = "%s"', $img_srcset ) : sprintf( 'srcset = "%s"', $img_srcset );
                        }
                        if( !empty( $sizes ) ) {
                            $image_atts[] = sprintf( 'sizes = "%s"', $sizes );
                        }
                    }else {
                        $image_atts[] = !empty( $lazy_load ) ? sprintf( 'data-src = "%s"', $image_src ) : sprintf( 'src = "%s"', $image_src );
                    }
                    $is_external_image = false;
                }       
            }else {
                $image_atts[] = !empty( $lazy_load ) ? sprintf( 'data-src = "%s"', $image ) : sprintf( 'src = "%s"', $image );
            }         
            $image_full_size_details = wp_get_attachment_image_src( $id, 'full' );
            if( !empty( $image_full_size_details ) && is_array( $image_full_size_details ) ) {
                $image_full_src = $image_full_size_details[0];
            }
        } else {
            $image_atts[] = !empty( $lazy_load ) ? sprintf( 'data-src = "%s"', $image ) : sprintf( 'src = "%s"', $image );
            $image_full_src = $image;
        }

        if( $is_external_image ) {
            $external_image_class = ' tatsu-external-image';
        }

        // if( !empty( $id ) ) {
        //     $image_id = tatsu_get_image_id_from_url( $image ); 
        //     if( $image_id ) {
        //         $image_details = wp_get_attachment_image_src( $image_id, $size );
        //         if( $image_details ) {
        //             $image_src = $image_details[0];
        //             $image_width = $image_details[1];
        //             $image_height = $image_details[2];
        //             $alt_text = get_post_meta( $image_id, '_wp_attachment_image_alt', true);
        //             $padding = 'padding-bottom : '.( ( $image_height / $image_width ) * 100 ).'%;';
        //             if( isset( $adaptive_image ) && $adaptive_image == 1 ){
        //                 $img_srcset = wp_get_attachment_image_srcset( $image_id, $size );
        //                 $sizes = wp_calculate_image_sizes( $size, null, null, $image_id );
        //                 if( isset( $img_srcset ) && !empty( $img_srcset ) ) {
        //                     // if( 1 == $lazy_load ){
        //                     //     $img_srcset = ' data-srcset = "'.$img_srcset.'" sizes = "'. $sizes .'"';
        //                     // } else {
        //                         $img_srcset = ' srcset = "'.$img_srcset.'" sizes = "'. $sizes .'"';
        //                     //}
        //                 }
        //             }                
        //         }
        //         $is_external_image = false;
        //     }
        //     if( $is_external_image ) {
        //         $image_src = $image;
        //     }            
        // }


        if( 'none' != $shadow ) {
            if( 'light' == $shadow ) {
                $box_shadow_class = ' be-shadow-light';
            }else if( 'regular' == $shadow ) {
                $box_shadow_class = ' be-shadow-medium';
            }else if( 'strong' == $shadow ) {
                $box_shadow_class = ' be-shadow-dark';
            }else {
                $box_shadow_class = ' be-shadow-custom';
            }
        }else{
            $box_shadow_class = '';
        }


        $lightbox = isset( $lightbox ) && !empty( $lightbox ) ? 1 : 0;
        $new_tab = isset( $new_tab ) && !empty( $new_tab ) ? 1 : 0;
        $new_tab_attribute = '';
        if( 1 == $lightbox ) {
            $link = ' href = "' . $image_full_src . '"';
            $new_tab_attribute = '';
        }else {
            if( isset( $link ) && !empty( $link ) ) {
                $link = ' href = "' . $link . '"';
                if( isset( $new_tab ) && !empty( $new_tab ) ) {
                    $new_tab_attribute = ' target = "_blank"';
                }
            }
        }

        if( 1 == $rebel ) {
            $maxWidth = '';
            $overflow_image_class = ' tatsu-image-overflow ';
        } else{
            if( !$is_external_image ) {
                $maxWidth = 'width : '.$image_width. 'px;';
            } 
        }


        $output = '';
        if( !empty( $image_atts ) ) {
            $output .= '<div '.$css_id.' class="tatsu-single-image tatsu-module'. $alignment_class . $box_shadow_class . $animate . $lazy_load_class . $overflow_image_class . $external_image_class . $unique_class_name . ' '.$css_classes.' '. $visibility_classes.'" '.$data_animations.'>'; 
            $output .= '<div class="tatsu-single-image-inner " style="' . $placeholder_bg . $maxWidth . '" >';
            $output .= '<div class = "tatsu-single-image-padding-wrap" style = "' . $padding . '" ></div>';
            if( '' != $link ) {
                $output .= '<a' . ( 1 == $lightbox ? ' class = "mfp-image"' : '' )  . $link . $new_tab_attribute . ' >';
            }
            $output .= '<img class = "tatsu-gradient-border" ' . implode(  ' ', $image_atts ) . ' />';
            if( '' != $link ) {
                $output .= '</a>';
            }
            $output .= '</div>';
            $output .= $custom_style_tag;
            $output .= '</div>';
        }

        return $output;
	}
	add_shortcode( 'tatsu_image', 'tatsu_image' );
}

if( !function_exists( 'tatsu_image_header_atts' ) ) {
	function tatsu_image_header_atts( $atts, $tag ) {
		if( 'tatsu_image' === $tag ) {
			// New Atts
			$atts['builder_mode'] = array (
				'type' => '',
				'default' => 'Header',
			);
            // Modify Atts
            $atts['image'] = array (
				'type' => 'single_image_picker',
				'post_frame' => true,
                'label' => __( 'Image', 'tatsu' ),
                'default' => TATSU_PLUGIN_URL.'/img/exponent-dark-logo.svg',
				'tooltip' => ''
			);
            $atts['size'] = array(
                'type' => 'select',
                'target_attribute' => 'image_varying_size_src',
                'label' => __( 'Image Size', 'tatsu' ),
                'options' => array(
                    'thumbnail' => 'Thumbnail',
                    'medium' => 'Medium',
                    'large' => 'Large'
                ),
                'default' => 'thumbnail',
                'tooltip' => '',
				// 'visible'	=> array ( 'image', '!=', '' ),
            );
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-single-image' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts
            unset( $atts['alignment'] );
            unset( $atts['adaptive_image'] );
            unset( $atts['lazy_load'] );
            unset( $atts['rebel'] );
            unset( $atts['image_offset'] );
            unset( $atts['enable_margin'] );

		}
		return $atts;
	}
    add_filter( 'tatsu_header_modify_atts', 'tatsu_image_header_atts', 10, 2 );
}
function single_image_overflow_callback( $width ) {

    $width = floatval( $width );
    if( $width ) {
        return ( ( $width - 100 )/$width ) * 100; 
    }
    return '0';

}

if( !function_exists( 'tatsu_image_remove_atts' ) ){
	function tatsu_image_remove_atts( $atts ){
        if( array_key_exists( 'enable_margin',$atts) && $atts['enable_margin'] == '0' ){
            $atts['margin'] = '';
        }
        if( array_key_exists( 'image_offset',$atts) && $atts['image_offset'] == '0' ){
            $atts['offset'] = '0px 0px';
        }
		return $atts;
	}

	add_filter('tatsu_image_before_css_generation', 'tatsu_image_remove_atts');
}

add_action('tatsu_register_modules', 'tatsu_register_image', 2);
add_action('tatsu_register_header_modules', 'tatsu_register_image', 9);

function tatsu_register_image()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#image',
		'title' => __('Single Image', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => true,
		'drag_handle' => false,

		//Tab1
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					array(
						'type' => 'tab',
						'title' => __('Content', 'tatsu'),
						'group'	=> array(
							'image',
							'image_varying_size_src',
							'link',
							'new_tab',
							'lightbox',
							'adaptive_image',
							'lazy_load',
							'placeholder_bg',
						),
					),

					//Tab2
					array(
						'type' => 'tab',
						'title' => __('Style', 'tatsu'),
						'group'	=> array(
							'alignment',
							'size',
							'max_width',
							'rebel',
							'width',
							'image_offset',
							'offset',
						)
					),

					array( //Tab3
						'type' => 'tab',
						'title' => __('Advanced', 'tatsu'),
						'group'	=> array(
							array(
								'type' => 'accordion',
								'active' => array(0),
								'group' => array(
									array( //Shape and Size Accordion
										'type' => 'panel',
										'title' => __('Spacing', 'tatsu'),
										'group'		=> array(
											'margin',
										),
									),
									array( //Shape and Size Accordion
										'type' => 'panel',
										'title' => __('Shadow', 'tatsu'),
										'group'		=> array(
											'shadow',
											'custom_shadow',
											'drop_shadow',
										),
									),
									array( //Shape and Size Accordion
										'type' => 'panel',
										'title' => __('Border', 'tatsu'),
										'group'		=> array(
											'border_width',
											'border_color',
											'border_radius',
										),
									),
								)
							),
						)
					)
				)
			)
		),

		'atts' => array(
			array(
				'att_name' => 'image',
				'type' => 'single_image_picker',
				'post_frame' => true,
				'label' => __('Image', 'tatsu'),
				'tooltip' => '',
				'default' => TATSU_PLUGIN_URL . '/img/image-placeholder.jpg'
			),
			array(
				'att_name' => 'image_varying_size_src',
				'type'	   => 'text',
				'label'	   => __('', 'tatsu'),
				'tooltip'  => '',
				'visible'  => array('1', '>', '100'),
				'default'  => '',
			),
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => __('Align', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'default' => 'none',
				'tooltip' => ''
			),
			array(
				'att_name' => 'border_width',
				'type' => 'number',
				'label' => __('Border Size', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '0',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property' => 'border-width',
						'append' => 'px',
					),
				),
			),
			array(
				'att_name' => 'border_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => __('Border Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('border_width', '>', '0'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property' => 'border-color',
						'when' => array('border_width', '!=', '0'),
					),
				),
			),
			array(
				'att_name' => 'id',
				'type' => 'number',
				'label' => __('Id', 'tatsu'),
				'visible' => array('border_width', '=', '-1000')
			),
			array(
				'att_name' => 'size',
				'type' => 'select',
				'target_attribute' => 'image_varying_size_src',
				'label' => __('Image Size', 'tatsu'),
				'options' => array(
					'full' => 'Full',
					'thumbnail' => 'Thumbnail',
					'medium' => 'Medium',
					'large' => 'Large'
				),
				'default' => 'full',
				'tooltip' => '',
				'visible'	=> array('image', '!=', ''),
			),
			array(
				'att_name' => 'adaptive_image',
				'type' => 'switch',
				'label' => __('Use Adaptive Image sizes', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'max_width',
				'type' => 'slider',
				'label' => __('Width', 'tatsu'),
				'options' => array(
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'unit' => '%',
				),
				'visible'	=> array(
					'condition'	=> array(
						array('rebel', '!=', '1'),
						array('size', '==', 'full'),
					),
					'relation'	=> 'and',
				),
				'css'		=> true,
				'responsive' => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-single-image-inner'	=> array(
						'property'	=> 'max-width',
						'when'		=> array(
							array('rebel', '!=', '1'),
							array('size', '=', 'full')
						),
						'relation'	=> 'and',
						'append'	=> '%',
					)
				),
				'default' => '100%',
			),
			array(
				'att_name'	=> 'rebel',
				'type' 		=> 'switch',
				'label'		=> __('Enable Image Overflow', 'tatsu'),
				'default'	=> 0,
				'tooltip'	=> '',
				'visible'	=> array('size', '==', 'full')
			),
			array(
				'att_name' => 'width',
				'type' => 'slider',
				'label' => __('Overflow Width', 'tatsu'),
				'options' => array(
					'min' => 100,
					'max' => 250,
					'step' => 1,
					'unit' => '%',
					// 'add_unit_to_value' => true
				),
				'default' => '100%',
				'visible' => array('rebel', '==', '1'),
				'tooltip' => 'Use this to achieve images which overflows its enclosing parent column',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property' => 'width',
						'when' => array('rebel', '=', '1'),
						'append' => '%',
					),
					'.tatsu-{UUID} .tatsu-single-image-inner ' => array( //added white space after the selector to make 'Key' of array unique
						'property' => 'transformX',
						'when' => array(
							array('rebel', '=', '1'),
							array('alignment', '=', 'right'),
						),
						'relation' => 'and',
						'prepend' => '-',
						'append' => '%',
						'callback' => 'single_image_overflow_callback',
					),

				),
			),
			array(
				'att_name' => 'shadow',
				'type' => 'select',
				'is_inline' => true,
				'label' => __('Shadow Type', 'tatsu'),
				'options' => array(
					'none' => 'None',
					'light' => 'Light',
					'regular' => 'Regular',
					'strong' => 'Strong',
					'custom' => 'Custom',
					'drop' => 'Drop Shadow',
				),
				'default' => 'none',
				'tooltip' => 'Box Shadow for your image'
			),
			array(
				'att_name'	=> 'custom_shadow',
				'type'	=> 'input_box_shadow',
				'label'	=> __('Custom Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'visible'	=> array('shadow', '=', 'custom'),
				'tooltip'	=> '',
				'css' => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property'	=> 'box-shadow',
						'when'	=> array('shadow', '=', 'custom')
					)
				)
			),
			array(
				'att_name'	=> 'drop_shadow',
				'type'	=> 'input_drop_shadow',
				'label'	=> __('Custom Drop Shadow', 'tatsu'),
				'default' => 'drop-shadow(0px 0px 0px rgba(0,0,0,0))',
				'visible'	=> array('shadow', '=', 'drop'),
				'tooltip'	=> '',
				'css' => true,
				'selectors'	=> array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property'	=> 'filter',
						'when'	=> array('shadow', '=', 'drop')
					)
				)
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'is_inline' => true,
				'label' => __('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => array( 'px', '%' ),
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
				),
				'tooltip' => 'Use this to give border radius',
			),
			array(
				'att_name' => 'lazy_load',
				'type' => 'switch',
				'label' => __('Lazy Load', 'tatsu'),
				'default' => '1',
				'tooltip' => ''
			),
			array(
				'att_name' => 'placeholder_bg',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => __('Placeholder Background', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('lazy_load', '=', '1'),
				'css' => true, //starts
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property' => 'background-color',
						'when' => array('lazy_load', '=', '1'),
					),
				),
			),
			array(
				'att_name'	=> 'offset',
				'type'		=> 'negative_number',
				'label'		=> __('Offset', 'tatsu'),
				'default'	=> '0px 0px',
				'options' => array(
					'labels' => array('X-axis', 'Y-axis'),
					'unit' => array('px')
				),
				'tooltip'	=> '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-single-image' => array(
						'property' => 'transform',
					),
				),
			),
			array(
				'att_name' => 'lightbox',
				'type' => 'switch',
				'label' => __('Open In Lightbox', 'tatsu'),
				'default' => 0,
				'tooltip' => ''
			),
			array(
				'att_name' => 'link',
				'type' => 'text',
				'is_inline' => false,
				'label' => __('Link URL', 'tatsu'),
				'options' => array(
					'placeholder' => 'https://example.com',
				),
				'default' => '',
				'tooltip' => '',
				'visible' => array('lightbox', '=', '0')
			),
			array(
				'att_name' => 'new_tab',
				'type' => 'switch',
				'label' => __('Open in New tab', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
				'visible' => array('lightbox', '=', '0')
			),
		),		
	);
	tatsu_register_module('tatsu_image', $controls);
	tatsu_register_header_module('tatsu_image', $controls, 'tatsu_image');
}

?>