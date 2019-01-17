<?php 
if ( !function_exists( 'tatsu_inline_text' ) ) {
	function tatsu_inline_text( $atts, $content ) {
		extract( shortcode_atts( array (
            'margin' => '0',
			'animate' => '0',
			'animation_type' => 'none',
			'animation_delay' => '0',
			'max_width' => 100,
			'wrap_alignment' => 'center',
			'text_alignment' => '',
			'border_radius' => '',
			'box_shadow' => '',
			'padding' =>'',
			'bg_color' => '',
			'builder_mode' => '',
			'key' => be_uniqid_base36(true),  
		),$atts ) );
		

		extract($atts);
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_inline_text', $key, $builder_mode );
		$custom_class_name = 'tatsu-'.$key;

		$animate = ( isset( $animate ) && !empty( $animate ) ) ? 1 : 0;
		$animation_delay = ( isset( $animation_delay ) && !empty( $animation_delay ) && 1 == $animate ) ? $animation_delay : '';
		$animation_type = ( isset( $animation_type ) && !empty( $animation_type ) && 1 == $animate ) ? $animation_type : '';
		if( $max_width < 100 ){
			if( $wrap_alignment == 'left' ){
				$inner_margin = '';
			}
			if( $wrap_alignment == 'center' ){
				$inner_margin = 'tatsu-align-center';
			}
			if( $wrap_alignment == 'right' ){
				$inner_margin = 'tatsu-align-right';
			}
		}
		else{
			$inner_margin = ''; //'margin-right:auto; margin-left:auto;';
		}	    

	    $output = '';
		$output .= '<div class="tatsu-module tatsu-inline-text clearfix '. $custom_class_name . ( ( 1 == $animate ) ? ' tatsu-animate' : '' )  . '" ' . ( ( '' != $animation_type ) ? ( ' data-animation="'. $animation_type .'"' ) : '' ) . ( ( '' != $animation_delay ) ? ( ' data-animation-delay="'. $animation_delay .'"' ) : '' )  . ' >';
		$output .= $custom_style_tag;
		$output .= '<div class="tatsu-inline-text-inner '.$inner_margin.'">';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		$output .= '</div>';
	    return $output;
	}
	add_shortcode( 'tatsu_inline_text', 'tatsu_inline_text' );
}

if( !function_exists( 'tatsu_inline_text_header_atts' ) ) {
	function tatsu_inline_text_header_atts( $atts, $tag ) {
		if( 'tatsu_inline_text' === $tag ) {
			// New Atts
			$atts['builder_mode'] = array (
				'type' => '',
				'default' => 'Header',
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
					'.tatsu-{UUID}.tatsu-inline-text' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts

		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_inline_text_header_atts', 10, 2 );
}

?>