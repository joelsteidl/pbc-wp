<?php
/**************************************
			MULTI LAYER IMAGE
**************************************/
if ( !function_exists('tatsu_multi_layer_images') ) {
    function tatsu_multi_layer_images( $atts, $content ) {
            $atts = shortcode_atts ( array ( 
                'lazy_load' => 0,
                'placeholder_bg' => '',
                'key' => be_uniqid_base36(true),
            ), $atts);
            
            extract($atts);

            global $tatsu_multi_layer_image_lazy_load;
            if( !empty( $lazy_load ) ) {
                $tatsu_multi_layer_image_lazy_load = true;
            }else {
                $tatsu_multi_layer_image_lazy_load = false;
            }

            $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_multi_layer_images', $atts['key'] );
            $custom_class_name = ' tatsu-'.$atts['key'];
            $output = '';
            $output .= '<div class = "tatsu-module tatsu-multi-layer-images tatsu-'.$key.'">'.do_shortcode( $content ).$custom_style_tag . '</div>';
            return $output;
        }
        add_shortcode( 'tatsu_multi_layer_images', 'tatsu_multi_layer_images' );
}

if ( !function_exists('tatsu_multi_layer_image') ) {
	function tatsu_multi_layer_image( $atts, $content ){
		$atts = shortcode_atts ( array ( 
                    'image' => '',
                    'id' => '',
                    'offset' => '0px 0px',
                    'shadow_type' => 'box',
                    'box_shadow' => '',
                    'drop_shadow' => '',
                    'max_width'=> '50',
                    'stack_order' => '1',
                    'key' => be_uniqid_base36(true),	
            ), $atts );

        extract ( $atts );
        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_multi_layer_image', $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];
	
        global $tatsu_multi_layer_image_lazy_load;
        $id = ( isset( $id ) ) ? $id : '';
        $lazy_load = !( wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) ) && !empty($tatsu_multi_layer_image_lazy_load) ? true : false ;
        if( $lazy_load ) {
            $lazy_load_class = ' tatsu-image-lazyload';
        }else{
            $lazy_load_class = '';
        } 

        $id = (int)$id;
        $size = 'full';
        $image_atts = array();
        $image_src = '';
        $alt_text = '';
        $image_width;
        $inner_width_style = '';
        $is_external_image = true;
        $external_image_class='';
                         
          
        $upload_dir_paths = wp_upload_dir(); //upload current directory and its path
        if ( false !== strpos( $image, $upload_dir_paths['baseurl'] ) ) {
                $image_details = wp_get_attachment_image_src( $id, $size );
                if( $image_details ) {
                    if( 0 == $image_details[2] || 0 ==  $image_details[1] ) {
                        $image_src = $image_details[0];
                        $image_atts[] = sprintf( 'src = "%s"', $image_src );
                    }else {
                        $image_src = $image_details[0]; 
                        $image_width = $image_details[1];                       
                        $image_atts[] = sprintf( 'alt = "%s"', get_post_meta( $id, '_wp_attachment_image_alt', true) );
                        $padding = 'padding-bottom : '. be_get_placeholder_padding( $id ) .'%;'; //set padding value                            
                        $image_atts[] = $lazy_load ? sprintf( 'data-src = "%s"', $image_src ) : sprintf( 'src = "%s"', $image_src );
                        $is_external_image = false;
                    } 
                }else {
                    $image_atts[] = $lazy_load ? sprintf( 'data-src = "%s"', $image ) : sprintf( 'src = "%s"', $image );       
                }
        }else {
            $image_atts[] = $lazy_load ? sprintf( 'data-src = "%s"', $image ) : sprintf( 'src = "%s"', $image );       
        }
        if( $is_external_image ) {
            $external_image_class = ' tatsu-external-image';
        }else if( !empty( $image_width ) ) {
            $inner_width_style = "width : {$image_width}px;";
        }

        $output = '';
        if( !empty( $image_atts ) ) {
           $output = '<div class = "tatsu-multi-layer-image tatsu-'. $key .' '. $lazy_load_class .' '.$external_image_class . ' ' . $custom_class_name . '" style = "' . $inner_width_style . '">';
           if( !empty( $padding ) ) {
            $output .= '<div class = "tatsu-multi-image-padding" style = "' . $padding . '"></div>';
           }
           $output .= '<img class = "img-class" ' . implode(  ' ', $image_atts ) . ' />';
           $output .= $custom_style_tag;
           $output .=  '</div>'; 
        }
        return $output;
    }
    add_shortcode( 'tatsu_multi_layer_image', 'tatsu_multi_layer_image' );
    
	function tatsu_multi_layer_image_prevent_autop( $content_filter, $tag ) { //Discard unnecessary br/p tag in WP

        if( 'tatsu_multi_layer_images' === $tag || 'tatsu_multi_layer_image' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'tatsu_multi_layer_image_prevent_autop', 9, 2 );


}
