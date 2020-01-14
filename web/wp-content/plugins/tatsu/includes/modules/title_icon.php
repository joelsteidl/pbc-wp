<?php
if ( ! function_exists( 'tatsu_title_icon' ) ){
	function tatsu_title_icon( $atts, $content, $tag ) {
		$atts = shortcode_atts( array(
			'icon'=>'none',
			'size' => 'small',
			'alignment'=>'left',	
			'style'=>'circled',
			'icon_bg'=> '',
			'icon_color'=> '',
			'box_shadow' => '',	
			'icon_border_color'=> '',
			'animate'=> 0,
			'animation_type'=>'none',
			'animation_delay' => 0,
			'margin' => '',
			'custom_space_enabler' => '',
			'custom_space' => '',
			'key' => be_uniqid_base36(true),
			'outer_box_shadow' => '',
		),$atts, $tag );

		$output ='';
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-'.$key;
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;
		$data_animations = be_get_animation_data_atts( $atts );
		$output .= '<div '.$css_id.' class="tatsu-module tatsu-title-icon '.$animate.' '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.'" '.$data_animations.'>';
		$output .= '<span class="tatsu-ti-wrap tatsu-ti '.$size.' '.$style.' align-'.$alignment.'" ><i class="'.$icon.' tatsu-ti tatsu-ti-icon"></i></span>';
		$output .= '<div class="tatsu-tc tatsu-tc-custom-space align-'.$alignment.' '.$size.' '.$style.'">'.do_shortcode( $content ).'</div>'; 
		$output .= $custom_style_tag;  
		$output .= '</div>';
 		
		return $output; 
	}
	add_shortcode('tatsu_title_icon','tatsu_title_icon');
	add_shortcode('title_icon','tatsu_title_icon');
}


add_action('tatsu_register_modules', 'tatsu_register_title_icon', 9);
function tatsu_register_title_icon()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#title_icon',
		'title' => __('Title with Icon', 'tatsu'),
		'is_js_dependant' => true,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'content',
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					//Tab1
					array(
						'type' => 'tab',
						'title' => __('Content', 'tatsu'),
						'group'	=> array(
							'icon',
							'content',
						),
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => __('Style', 'tatsu'),
						'group'	=> array(
							array( //Styling Details
								'type' => 'accordion',
								'active' => 'all',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => __('Style and Alignment', 'tatsu'),
										'group' => array(
											'alignment',
											'size',
											'style',
										)
									),
									array(
										'type' => 'panel',
										'title' => __('Colors', 'tatsu'),
										'group' => array(
											'icon_color',
											'icon_bg',
											'icon_border_color',
											'box_shadow',
										)
									),
								),
							),
						),
					),
					//Tab3
					array(
						'type' => 'tab',
						'title' => __('Advanced', 'tatsu'),
						'group'	=> array(
							array( //accordion
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
									array(
										'type' => 'panel',
										'title' => __('Shadow', 'tatsu'),
										'group' => array(
											'outer_box_shadow',
										)
									),
								),
							),
						),
					),
				),
			),
		),
		'atts' => array(
			array(
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => __('Icon', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'size',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => __('Icon Size', 'tatsu'),
				'options' => array(
					'small' => 'Small',
					'medium' => 'Medium',
					'large' => 'Large',
				),
				'default' => 'small',
				'tooltip' => ''
			),
			array(
				'att_name' => 'alignment',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => __('Align', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'right' => 'Right'
				),
				'default' => 'left',
				'tooltip' => ''
			),
			
			array(
				'att_name' => 'style',
				'type' => 'button_group',
				'is_inline' => true,
				'label' => __('Icon Style', 'tatsu'),
				'options' => array(
					'plain' => 'Plain',
					'circled' => 'Circled'
				),
				'default' => 'circled',
				'tooltip' => ''
			),
			array(
				'att_name' => 'icon_bg',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => __('Icon Background', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('style', '=', 'circled'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-ti-wrap.circled' => array(
						'property' => 'background',
						'when' => array('style', '=', 'circled'),
					),
				),
			),
			array(
				'att_name' => 'icon_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true
				),
				'label' => __('Icon Color', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-ti-icon' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'box_shadow', // Icons Shadow
				'type' => 'input_box_shadow',
				'label' => __('Icon Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'visible'	=> array('style', '=', 'circled'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-ti-wrap.circled' => array(
						'property' => 'box-shadow',
						'when' => array('style', '=', 'circled'),
					),
				),
			),
			array(
				'att_name' => 'outer_box_shadow',
				'type' => 'input_box_shadow',
				'label' => __('Box Shadow', 'tatsu'),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'box-shadow',
						'when' => array( 'outer_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)' ),
					),
				),
			),
			array(
				'att_name' => 'icon_border_color',
				'type' => 'color',
				'label' => __('Icon Border', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'visible' => array('style', '=', 'circled'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-ti-wrap.circled' => array(
						'property' => 'border-color',
						'when' => array('style', '=', 'circled'),
					),
				),
			),
			array(
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => __('Content', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			// array(
			// 	'att_name' => 'margin',
			// 	'type' => 'input_group',
			// 	'label' => __('Margin', 'tatsu'),
			// 	'default' => '0px 0px 60px 0px',
			// 	'tooltip' => '',
			// 	'responsive' => true,
			// 	'css' => true,
			// 	'selectors' => array(
			// 		'.tatsu-{UUID}.tatsu-title-icon' => array(
			// 			'property' => 'margin',
			// 			'when' => array('margin', '!=', array('d' => '0px 0px 60px 0px')),
			// 		),
			// 	),
			// ),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'icon' => 'icon-icon_desktop',
					'icon_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'icon_border_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
					'size' => 'medium',
					'style' => 'plain',
					'content' => '<h6>Title Goes Here</h6><p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt.</p>'
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_title_icon', 'title_icon'), $controls, 'tatsu_title_icon');
}

?>