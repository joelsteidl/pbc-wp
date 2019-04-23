<?php
if( !function_exists( 'tatsu_img_slider' ) ) {
    function tatsu_img_slider($atts,$content) {
        
        $atts =  shortcode_atts( array (
            'type'             => 'ribbon',
            'images'            => '',
            'slide_gutter'      => '0',
            'height'            => '500',
            'full_screen'       => '',
            'full_screen_offset'=> '',
            'center_scale'      => '',
            'border_radius'     => '',
            'destroy_slider'    => '',
            'lazy_load'         => '0',
            'adaptive_images'   => '0',
            'slides_to_show'    => '1',
            'vertical_alignment'=> 'center',
            'slide_bg_color'    => '#e5e5e5',
            'arrows'            => '0',
            'pagination'        => '0',
            'dots_color'        => '',
            'slide_show'        => '0',
            'slide_show_speed'  => '2000', 
            'infinite'          => '1',
            'swipe_to_slide'    => '0',
            'destroy_in_mobile' => '1',  
            'margin'            => '',
			'key' => be_uniqid_base36(true),
		),$atts );

        extract( $atts );


        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_image_carousel', $atts['key'] );

        $custom_class_name = ' tatsu-'.$atts['key'];

        $slider_type = !empty( $type ) ? $type : 'fixed';

        //wrapper classes
        $wrapper_classes = array( 'tatsu-media-carousel', 'tatsu-module', 'clearfix', $custom_class_name );

        //classes
        $classes = array( 'tatsu-media-carousel-inner', 'tatsu-carousel' );
        if( 'fixed' === $slider_type ) {
            $classes[] = 'tatsu-fixed-carousel';
            if( !empty( $center_scale ) ) {
                $classes[] = 'tatsu-image-center-scale';
            }
        }else if( 'client_carousel' === $slider_type ) {
            $classes[] = 'tatsu-client-carousel';
        }else {
            $classes[] = 'tatsu-variable-carousel';
        }
        if( !empty( $full_screen ) ) {
            $classes[] = 'tatsu-full-screen-carousel';
        }
        if( !empty( $destroy_in_mobile ) ) {
            $classes[] = 'tatsu-carousel-destroy-in-mobile';
        }
        if( 'client_carousel' === $slider_type || 'fixed' === $slider_type ) {
            if( !empty( $slides_to_show ) ) {
                $classes[] = 'tatsu-carousel-cols-' . $slides_to_show;
            }
        }
        if( !empty( $adaptive_images ) ) {
            $classes[] = 'tatsu-carousel-adaptive-image';
        }
        
        //data-atts
        $data_attrs = array();
        if( ( 'ribbon' === $slider_type || 'centered_ribbon' === $slider_type ) ) {
            $data_attrs[] = 'data-variable-width = "1"';
            if( 'centered_ribbon' === $slider_type ) {
                $data_attrs[] = 'data-center-mode = "1"';
            }
        }
        if( !empty( $full_screen ) ) {
            $data_attrs[] = 'data-fullscreen = "1"';
            if( !empty( $full_screen_offset ) ) {
                $data_attrs[] = sprintf( 'data-fullscreen-offset = "%s"', $full_screen_offset );
            }
        }
        if( !empty( $swipe_to_slide ) ) {
            $data_attrs[] = sprintf( 'data-free-scroll = "%s"', $swipe_to_slide ); 
        }
        if( !empty( $arrows ) ) {
            $data_attrs[] = 'data-arrows = "1"';
            $data_attrs[] = 'data-outer-arrows = "1"';
        }
        if( !empty($infinite) ) {
            $data_attrs[] = 'data-infinite = "1"';
        }
        if( !empty( $pagination ) ) {
            $data_attrs[] = 'data-dots = "1"';
        }
        if( !empty( $slide_show ) ) {
            $data_attrs[] = 'data-autoplay = "1"';
        }
        if( !empty( $destroy_in_mobile ) ) {
            $data_attrs[] = 'data-destroy-in-mobile = "1"';
        }
        if( !empty( $slide_show_speed ) ) {
            $data_attrs[] = sprintf( 'data-autoplay-speed = "%s"', $slide_show_speed );
        }
        if( !empty( $lazy_load ) ) {
            $data_attrs[] = 'data-lazy-load = "1"';
        }

        $wrapper_classes = implode( ' ', $wrapper_classes );
        $classes = implode( ' ', $classes );
        $data_attrs = implode( ' ', $data_attrs );
        $images_array = !empty( $images ) ? explode( ',', $images ) : array(); 
        ob_start();
        ?>
            <div class = "<?php echo $wrapper_classes; ?>" >
                <?php echo $custom_style_tag; ?>
                <div class = "<?php echo $classes; ?>" <?php echo $data_attrs; ?> >
                    <?php if( !empty( $images_array ) ) : ?>
                        <?php foreach( $images_array as $id_and_url ) : ?>
                            <?php 
                                $id_and_url_array = explode( '::', $id_and_url );
                                $id = !empty( $id_and_url_array[0] ) ? $id_and_url_array[0] : '';
                                $url = !empty( $id_and_url_array[1] ) ? $id_and_url_array[1] : '';
                                if( $id_and_url === $id ) {
                                    continue;
                                }
                                $img_attr = array();
                                $img_class = array( 'tatsu-carousel-img' );
                                if( !empty( $lazy_load ) ) {
                                    $img_class[] = 'tatsu-carousel-img-lazy-load';
                                }
                                if( !empty( $id ) ) {
                                    $attachment_details = be_wp_get_attachment( $id );
                                    if( !empty( $attachment_details ) ) {
                                        $url = $attachment_details[ 'src' ];
                                        if( 'centered_ribbon' === $slider_type || 'ribbon' === $slider_type || !empty( $destroy_in_mobile ) ) {
                                            $img_height = $attachment_details[ 'height' ];
                                            $img_width = $attachment_details[ 'width' ];
                                            $aspect_ratio = ( !empty( $img_width ) && !empty( $img_height ) ) ? $img_width/$img_height : '1';
                                            $img_attr[] = sprintf( 'data-aspect-ratio = "%s"', $aspect_ratio );
                                        }
                                    }
                                }
                                if( !empty( $adaptive_images ) ) {
                                    $img_srcset = wp_get_attachment_image_srcset( $id, 'full' );
                                    $sizes = wp_calculate_image_sizes( 'full', null, null, $id );
                                    if( !empty( $lazy_load ) ) {
                                        $img_attr[] = sprintf( 'data-srcset = "%s"', $img_srcset );
                                    }else {
                                        $img_attr[] = sprintf( 'srcset = "%s"', $img_srcset );
                                    }
                                    $img_attr[] = sprintf( 'sizes = "%s"', $sizes );
                                }else {
                                    if( !empty( $lazy_load ) ) {
                                        $img_attr[] = sprintf( 'data-src = "%s"', $url );
                                    }else {
                                        $img_attr[] = sprintf( 'src = "%s"', $url );
                                    }
                                }
                            ?>
                                <div class = "tatsu-media-slide tatsu-carousel-col">
                                    <div class = "tatsu-media-slide-inner tatsu-carousel-col-inner">
                                        <img class = "<?php echo implode( ' ', $img_class ) ?>" <?php echo implode( ' ', $img_attr ); ?> />
                                    </div>
                                </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php
        return ob_get_clean();
    }
    add_shortcode( 'tatsu_image_carousel', 'tatsu_img_slider' );
}