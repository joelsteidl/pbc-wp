<?php
if (!function_exists('tatsu_column')) {
	function tatsu_column( $atts, $content ) {
		//$column_atts = columns_extract($atts, $content);

		$atts = shortcode_atts( array (
			'column_width' => '',
			'column_mobile_spacing' => '',
			'bg_color' => '',
			'bg_image' => '',
			'layout' =>'1/1',
			'gutter' => 'medium',
			'column_spacing' => '25px',
			'bg_repeat' => 'repeat',
			'bg_attachment' => 'scroll',
			'bg_position' => 'left top',
			'bg_size' => 'initial',
			'sticky' => '0',
			'padding' => '0px 0px 0px 0px',
			'custom_margin' => '0',
			'margin' => '',		
			'border'	=> '0 0 0 0',
			'border_color'	=> '',
			'enable_box_shadow' => 0,
			'box_shadow_custom' => '',	
			'bg_video' => 0,
	        'bg_video_mp4_src' => '',
	        'bg_video_ogg_src' => '',
	        'bg_video_webm_src' => '',
	        'bg_overlay' => 0,
			'overlay_color' => '',
			'animate_overlay' => 'none',
			'link_overlay' => '',
			'vertical_align' => 'none',
			'column_offset' => 0,
			'offset' 	=> '0px 0px',
			'z_index'	=> 0,
			'col_id' => '',
			'column_class' => '',
			'hide_in' => '',
			'image_hover_effect' => '',
			'column_hover_effect' => '',
			'hover_box_shadow' => '',
			'animate' => 0,
	        'animation_type' => 'fadeIn',
			'animation_delay' => 0,
			'column_parallax' => 0,
			'border_radius' => '',
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		$atts['z_index'] = !empty( $atts['z_index'] )? $atts['z_index'] + 2 : 2;
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_column', $key );
		$addl_style_tag = '';
		$unique_class_name = 'tatsu-'.$key;
		
		$column_layouts = array(
			'1/1' => 'tatsu-one-col',
			'1/2' => 'tatsu-one-half',
			'1/3' => 'tatsu-one-third',
			'1/4' => 'tatsu-one-fourth',
			'1/5' => 'tatsu-one-fifth',
			'2/3' => 'tatsu-two-third',
			'3/4' => 'tatsu-three-fourth',
		);	

		$background = '';
	    $bg_video_markup = '';
	    $bg_video_class = '';
	    $bg_overlay_class = '';
	    $bg_overlay_markup = '';
		$bg_overlay_data = '';
		$column_shadow_value = '';
		$custom_gutter = '';
		$column_id = '';
	    $classes = '';
	    $output = '';

		// Handle Custom Gutter

		if( 'custom' === $gutter ) {
			$column_spacing =  !empty( $column_spacing ) ? intval( $column_spacing ) : 0;
			$column_spacing = intval( $column_spacing / 2 );
			$custom_gutter = ' padding:0 '.$column_spacing.'px;';
		}	

		// Handle Custom Gutter in Mobile

		$column_width_arr = !empty( $column_width ) ? json_decode( $column_width ,true ) : '' ;
		if( is_array( $column_width_arr ) && array_key_exists( 'm', $column_width_arr ) && $column_width_arr['m'] < 100 && ( !empty( $column_mobile_spacing ) && $column_mobile_spacing != 0 ) ){
			$addl_style_tag = '<style>@media only screen and (max-width: 767px) {.'.$unique_class_name.'.tatsu-column{ padding:0 '.intval( $column_mobile_spacing / 2).'px !important} }</style>';
		}
		
	    // Handle BG Video
		if( isset( $bg_video ) && 1 == $bg_video ) {
			$classes .= ' tatsu-video-section';
			$bg_video_markup .= '<video class="tatsu-bg-video" autoplay="autoplay" loop="loop" muted="muted" preload="auto">';
			$bg_video_markup .=  ( !empty( $bg_video_mp4_src ) ) ? '<source src="'.$bg_video_mp4_src.'" type="video/mp4">' : '' ;
			$bg_video_markup .=  ( !empty( $bg_video_ogg_src ) ) ? '<source src="'.$bg_video_ogg_src.'" type="video/ogg">' : '' ;
			$bg_video_markup .=  ( !empty( $bg_video_webm_src ) ) ? '<source src="'.$bg_video_webm_src.'" type="video/webm">' : '' ;
			$bg_video_markup .= '</video>';
		}

		//Handle BG Overlay
		if( isset( $bg_overlay ) && 1 == $bg_overlay ) {
			$classes .= ' tatsu-bg-overlay';
			if( !empty( $animate_overlay ) ) {
				$animate_overlay = 'tatsu-animate-'.$animate_overlay;
			}
			if( empty( $overlay_color ) ) {
				$overlay_color = 'transparent';
			}
			$bg_overlay_markup .= '<div class="tatsu-overlay tatsu-column-overlay '.$animate_overlay.'" ></div>';
			$bg_overlay_markup .= !empty( $link_overlay ) ? '<a href="'.$link_overlay.'" class="tatsu-col-overlay-link"></a>': ''; 
		}

		// Background Indicator

		if( empty( $bg_image  ) ) {
	    	if( ! empty( $bg_color ) ) {
	    		$background = true;
	    	}	
	    } else {
    		$background = true;    	
	    }

		if( empty( $background ) && ( empty( $bg_overlay ) || 'transparent' === $overlay_color ) ) {
			$classes .= ' tatsu-column-no-bg';
		}

		if( empty( $content ) ) {
			$classes .= ' tatsu-column-empty';
		}

		if( array_key_exists( $layout , $column_layouts ) ) {
			$classes .= ' '.$column_layouts[$layout];
		}

		//Column Animation 

		if( isset( $animate ) && 1 == $animate ) {
			$classes .= ' tatsu-animate';
		}

		//Column Alignment

		if( isset( $vertical_align ) && 'none' !== $vertical_align ) {
			$classes .= ' tatsu-column-align-'.$vertical_align;
		}

		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$classes .= ' tatsu-hide-'.$device;
			}
		}		
		
		//Column Parallax
		if( isset( $column_parallax ) && 0 != $column_parallax ){
			$classes .= ' tatsu-column-parallax';
		}
		//column image hover effect
        if( isset( $image_hover_effect ) ){
            $classes .= ' tatsu-column-image-'.$image_hover_effect;
		}
		//column hover effect
		if( isset( $column_hover_effect ) ){
			$classes .= ' tatsu-column-effect-'.$column_hover_effect;
		}

		//sticky column
		// if(isset($sticky) && 0 != $sticky){
		// 	$classes .= ' tatsu-column-sticky';
		// }

		//Append to custom classes 
		$column_class = !empty( $column_class ) ? str_replace(',', ' ', $column_class ) : '' ;
		$column_class = $classes.' '.$column_class;

		//Column ID
		if( !empty( $col_id ) ) {
			$column_id = 'id="'.$col_id.'"';
		}


		$output .= '<div '.$column_id.' class="tatsu-column '.$column_class.' '.$unique_class_name.'" data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'" data-parallax-speed="'.$column_parallax.'" style="'.$custom_gutter.'">';
		$output .= '<div class="tatsu-column-inner" >';
		$output .= '<div class="tatsu-column-pad-wrap">';
		$output .= '<div class="tatsu-column-pad" >';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="tatsu-column-bg-image"></div>'; 
		$output .= $bg_video_markup.$bg_overlay_markup;			
		$output .= '</div>';
		$output .= $custom_style_tag;
		$output .= $addl_style_tag;	
		$output .= '</div>';
		
		return $output;
	}


	add_shortcode( 'one_col', 'tatsu_column' );
	add_shortcode( 'tatsu_column', 'tatsu_column' );
	add_shortcode( 'tatsu_column1', 'tatsu_column' );

	add_shortcode( 'one_half', 'tatsu_column' );
	add_shortcode( 'one_third', 'tatsu_column' );
	add_shortcode( 'one_fourth', 'tatsu_column' );
	add_shortcode( 'one_fifth', 'tatsu_column' );
	add_shortcode( 'two_third', 'tatsu_column' );
	add_shortcode( 'three_fourth', 'tatsu_column' );
	add_shortcode( 'tatsu_inner_column', 'tatsu_column' );

}

// add_filter( 'tatsu_column_before_css_generation', 'tatsu_column_css' );
// function tatsu_column_css($atts) {
// 	$atts['column_spacing'] =  !empty( $atts['column_spacing'] ) ? intval( $atts['column_spacing'] ) / 2 : 0;
// 	return $atts;
// }

?>