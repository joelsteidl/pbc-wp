<?php
/**************************************
	        SINGLE IMAGE
**************************************/
if (!function_exists('tatsu_image')) {
	function tatsu_image( $atts, $content ) {
        $atts = shortcode_atts( array (
            'enable_margin'     => 0,
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
			'animation_type'    =>'fadeIn',
			'animation_delay'   => 0,
            //'margin'            => '',
            'border_radius'     => '',
            'image_offset'      => '',
            'offset'            => '',
            'builder_mode'      => '',
            'hide_in' => '',
			'key'               => be_uniqid_base36(true),
        ), $atts );

        
        extract( $atts );
        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_image', $atts['key'], $builder_mode );
        $custom_class_name = ' tatsu-'.$atts['key'];
		$visibility_classes = '';
        

        $id = ( isset( $id ) ) ? $id : '';
        //$border_width = ( isset( $border_width ) && !empty( $border_width ) ) ? $border_width : '0';
        //$border_color = ( isset( $border_color ) && !empty( $border_color ) ) ? $border_color : 'transparent';
        $alignment = ( isset( $alignment ) && !empty( $alignment ) ) ? $alignment : 'none';
        $size = ( isset( $size ) && !empty( $size ) ) ? $size : 'full';
        $rebel = ( isset( $rebel ) && !empty( $rebel ) && 'full' == $size ) ? 1 : 0;
        $width = ( isset( $width ) && !empty( $width ) && 1 == $rebel ) ? (int)$width : 0;

       
        // if( !empty( $border_width ) ) {
        //     $image_style = ' style = "border:'. $border_width . 'px solid ' . $border_color . ';"'; 
        // }else{
        //     $image_style = '';
        // }
        if( isset( $animate ) && 1 == $animate ) {
            $animate_class = ' tatsu-animate';
            $data_animations = ' data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'"';
        } else {
            $animate_class = '';
            $data_animations = '';
        }
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
        //Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
			}
        }
        
        if( !empty( $image_atts ) ) {
            $output .= '<div class="tatsu-single-image tatsu-module'. $alignment_class . $box_shadow_class . $animate_class . $lazy_load_class . $overflow_image_class . $external_image_class . $custom_class_name . ' '.$visibility_classes.'" '. $data_animations . '>'; 
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
			$atts['hide_in'] = array (
				'type' => 'screen_visibility',
				'label' => __( 'Hide in', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
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

?>