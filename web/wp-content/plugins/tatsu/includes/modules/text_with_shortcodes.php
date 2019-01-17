<?php
if ( !function_exists( 'tatsu_text_with_shortcodes' ) ) {
	function tatsu_text_with_shortcodes( $atts, $content ) {
		extract( shortcode_atts( array(
			'builder_mode' => '',
	        'animate'=>0,
			'animation_type'=>'fadeIn',
			'hide_in' => '',
			'key' => be_uniqid_base36(true),
	    ),$atts ) );
		$output = '';
		$visibility_classes = '';
		$class = 'tatsu-module';
		$data = '';
		if( isset( $animate ) && 1 == $animate ) {
			$class .= ' tatsu-animate';
			$data = 'data-animation="'.$animation_type.'"';
		}
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_text_with_shortcodes', $key, $builder_mode );
		$custom_class_name = 'tatsu-'.$key;
		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
			}
		}
		$output .= '<div class="tatsu-shortcode-module '.$class.' '.$custom_class_name.' '.$visibility_classes.'" '.$data.'>';
		$output .= do_shortcode( shortcode_unautop( $content ) );
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_text_with_shortcodes', 'tatsu_text_with_shortcodes' );
}

if( !function_exists( 'tatsu_text_with_shortcodes_header_atts' ) ) {
	function tatsu_text_with_shortcodes_header_atts( $atts, $tag ) {
		if( 'tatsu_text_with_shortcodes' === $tag ) {
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
			$atts['margin'] = 	array (
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 30px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-shortcode-module' => array(
						'property' => 'margin',
					),
				),
			);
			// Modify Atts
			// Remove Atts
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_text_with_shortcodes_header_atts', 10, 2 );
}
?>