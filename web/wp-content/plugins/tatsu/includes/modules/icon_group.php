<?php
if ( !function_exists( 'tatsu_icon_group' ) ) {	
	function tatsu_icon_group( $atts, $content ){
		$atts = shortcode_atts( array (
			'alignment' => 'center',
			'margin' => '',
			'builder_mode' => '',
			'hide_in' => '',
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_icon_group', $key, $builder_mode );
		$custom_class_name = 'tatsu-'.$key;
		$visibility_classes = '';
		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
			}
		}
		// $output = '<div class="tatsu-module tatsu-icon-group align-'.$alignment.' '.$custom_class_name.' '.$visibility_classes.'" >'.do_shortcode( $content ).'</div>'.$custom_style_tag;		
		$output = '<div class="tatsu-module tatsu-icon-group '.$custom_class_name.' '.$visibility_classes.'" >'.do_shortcode( $content ).'</div>'.$custom_style_tag;		
		return $output;	
	}	
	add_shortcode( 'tatsu_icon_group', 'tatsu_icon_group' );
	add_shortcode( 'icon_group', 'tatsu_icon_group' );
}

if( !function_exists( 'tatsu_icon_group_header_atts' ) ) {
	function tatsu_icon_group_header_atts( $atts, $tag ) {
		if( 'tatsu_icon_group' === $tag ) {
			// New Atts
			$atts['hide_in'] = array (
				'type' => 'screen_visibility',
				'label' => __( 'Hide in', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
			);
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
					'.tatsu-{UUID}.tatsu-icon-group' => array(
						'property' => 'margin',
					),
				),
			);
			// Remove Atts
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_icon_group_header_atts', 10, 2 );
}

?>