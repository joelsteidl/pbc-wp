<?php


add_action( 'tatsu_register_modules', 'tatsu_register_section' );
function tatsu_register_section() {

		$divider_options = tatsu_get_shape_dividers();
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Section', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'tatsu_row',
	        'type' => 'core',
			'label' => 'Section',
			'initial_children' => 1,
			'is_built_in' => true,
			'group_atts' => array(
				array (
					'type' => 'accordion' ,
					'active' => array(0),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Background', 'tatsu' ),
							'group' => array (
								'bg_color',
								'bg_image',
								'bg_repeat',
								'bg_attachment',
								'bg_position',
								'bg_size',
								'bg_animation',
								'bg_video', 
								'bg_video_mp4_src', 
								'bg_video_ogg_src', 
								'bg_video_webm_src',
								'bg_overlay', 
								'overlay_color'
							)
						),
					)
				),
				'padding',
				array (
					'type' => 'accordion' ,
					'active' => 'none',
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Section Height', 'tatsu' ),
							'group' => array (
								'full_screen', 
								'enable_custom_height',
								'custom_height',
								'full_screen_header_scheme',
								'vertical_align'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'margin',
								'border',
								'border_color' 
							)
						),	
						array (
							'type'		=> 'panel',
							'title'		=> __( 'Shape Divider', 'tatsu' ),
							'group'		=> array (
								array (
									'type'  	=> 'tabs',
									'group'		=> array (
										array (
											'type'		=> 'tab',
											'title'		=> __( 'Top', 'tatsu' ),
											'group'		=> array (
												'top_divider',
												'top_divider_color',
												'top_divider_height',
												'top_divider_position',
												'invert_top_divider',
												'flip_top_divider',
												'top_divider_zindex',
											),	
										),
										array (
											'type'		=> 'tab',
											'title'		=> __( 'Bottom', 'tatsu' ),
											'group'		=> array (
												'bottom_divider',
												'bottom_divider_color',
												'bottom_divider_height',
												'bottom_divider_position',
												'invert_bottom_divider',
												'flip_bottom_divider',
												'bottom_divider_zindex',
											),
										),
									),
								),
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Advanced', 'tatsu' ),
							'group' => array (
								'offset_section', 
								'offset_value',
								'z_index',
								'overflow',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Identifiers', 'tatsu' ),
							'group' => array (
								'section_id', 
								'section_class', 
								'section_title'
							)
						)
					) 
				),									
				'hide_in'
			),
	        'atts' => array (
	             array (
					'att_name' => 'bg_color',
					'type' => 'color',
					'options' => array (
							'gradient' => true
					),
					'label' => __( 'Background Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'background-color',
						),
					)
	            ),
	             array (
					'att_name' => 'bg_image',
					'type' => 'single_image_picker',
					'label' => 'Background Image',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-section-background' => array(
							'property'		=> 'background-image',
						)
					)
	            ),
	             array (
	              'att_name' => 'bg_repeat',
	              'type' => 'select',
	              'label' => __( 'Background Repeat', 'tatsu'),
	              'options' => array (
	                'repeat' => 'Repeat Horizontally & Vertically',
	                'repeat-x' => 'Repeat Horizontally',
	                'repeat-y' => 'Repeat Vertically',
	                'no-repeat' => 'Don\'t Repeat',
	              ),
	              'default' => 'no-repeat',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu-section-background' => array(
							'property' => 'background-repeat',
							'when' => array('bg_image', 'notempty'),
						),
						'.tatsu-{UUID} .tatsu-bg-blur' => array(
							'property' => 'background-repeat',
							'when' => array('bg_image', 'notempty'),
						)
					)
				),
				// array (
				// 	'att_name' => 'set_featured_image_as_bg',
				// 	'type' => 'switch',
				// 	'label' => __( 'Set Featured Image as Background', 'tatsu' ),
				// 	'default' => 0,
				// 	'tooltip' => '',
				//   ),
	             array (
	              'att_name' => 'bg_attachment',
	              'type' => 'button_group',
	              'label' => __( 'Background Attachment', 'tatsu' ),
	              'options' => array (
	                'scroll' => 'Scroll',
	                'fixed' => 'Fixed'
	              ),
	              'default' => 'scroll',
	              'tooltip' => '',
				  'hidden' => array( 'bg_image', '=', '' ),
				  'responsive' => true,
				  'css' => true,
				  'selectors' => array(
						'.tatsu-{UUID} .tatsu-section-background' => array(
							'property' => 'background-attachment',
							'when' => array('bg_image', 'notempty'),
						),
						'.tatsu-{UUID} .tatsu-bg-blur' => array(
							'property' => 'background-attachment',
							'when' => array('bg_image', 'notempty'),
						)
				   )
	            ),
	             array (
	              'att_name' => 'bg_position',
	              'type' => 'select',
	              'label' => __( 'Background Position', 'tatsu' ),
	              'options' => array (
	                'top left' => 'Top Left',
	                'top right' => 'Top Right',
	                'top center' => 'Top Center', 
	                'center left' => 'Center Left', 
	                'center right' => 'Center Right', 
	                'center center' => 'Center Center',
	                'bottom left' => 'Bottom Left',
	                'bottom right' => 'Bottom Right',
	                'bottom center' => 'Bottom Center'
	              ),
	              'default' => 'top left',
	              'tooltip' => '',
				  'hidden' => array( 'bg_image', '=', '' ),
				  'responsive' => true,
				  'css' => true,
				  'selectors' => array(
						'.tatsu-{UUID} .tatsu-section-background' => array(
							'property' => 'background-position',
							'when' => array('bg_image', 'notempty'),
						), 
						'.tatsu-{UUID} .tatsu-bg-blur' => array(
							'property' => 'background-position',
							'when' => array('bg_image', 'notempty'),
						)
				   )
	            ),
	            array (
	              'att_name' => 'bg_size',
	              'type' => 'select',
	              'label' => __( 'Background Size', 'tatsu' ),
	              'options' => array (
	              	'cover' => 'Cover',
	              	'contain' => 'Contain',
	              	'initial' => 'Initial',
	              	'inherit' => 'Inherit'
	              ),
	              'default' => 'cover',
	              'tooltip' => '',
				  'hidden' => array( 'bg_image', '=', '' ),
				  'responsive' => true,
				  'css' => true,
				  'selectors' => array(
						'.tatsu-{UUID} .tatsu-section-background' => array(
							'property' => 'background-size',
							'when' => array('bg_image', 'notempty'),
						),
						'.tatsu-{UUID} .tatsu-bg-blur' => array(
							'property' => 'background-size',
							'when' => array('bg_image', 'notempty'),
						),
					)
	            ),
	             array (
	              'att_name' => 'bg_animation',
	              'type' => 'select',
	              'label' => __( 'Background Image Animation', 'tatsu' ),
	              'options' => array (
	                'none' => 'None',
					'tatsu-parallax' => 'Parallax',
					//'tatsu-3d-rotate' => '3D Hover',
					'tatsu-bg-horizontal-animation' => 'Horizontal Loop Animation',
					'tatsu-bg-vertical-animation' => 'Vertical Loop Animation',
	              ),
	              'default' => 'none',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
				),
	            array (
	              'att_name' => 'padding',
	              'type' => 'input_group',
	              'label' => __( 'Padding', 'tatsu' ),
	              'default' => '90px 0px 90px 0px',
				  'tooltip' => '',
				  'css' => true,
				  'responsive' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu-section-pad' => array(
							'property' => 'padding',
							'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
						),
					)
	            ),
	            array (
	              'att_name' => 'margin',
	              'type' => 'input_group',
	              'label' => __( 'Margin', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
	              'tooltip' => '',
				  'css' => true,
				  'responsive' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
						),
					),
	            ),		            	             
	            array (
	              'att_name' => 'border',
	              'type' => 'input_group',
	              'label' => __( 'Border Thickness', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
	              'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'border-width',
							'when' => array('border_color', 'notempty'),
						),
					)
	            ),
	            array (
	              'att_name' => 'border_color',
				  'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
	              'label' => __( 'Border Color', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'border-color',
							'when' => array('border_color', 'notempty'),
						),
					)
	            ),	             
	            array (
	              'att_name' => 'bg_video',
	              'type' => 'switch',
	              'label' => __( 'Enable Background Video', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	             	'att_name' => 'bg_video_mp4_src',
	             	'type' => 'text',
	             	'label' => __( '.MP4 Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),
	             ),
	             array (
	             	'att_name' => 'bg_video_ogg_src',
	             	'type' => 'text',
	             	'label' => __( '.OGG Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),             	
	             ),
	             array (
	             	'att_name' => 'bg_video_webm_src',
	             	'type' => 'text',
	             	'label' => __( '.WEBM Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),             	
	             ),
	             array (
	              'att_name' => 'bg_overlay',
	              'type' => 'switch',
	              'label' => __( 'Enable Background Overlay', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'overlay_color',
				  'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
	              'label' => __( 'Section Overlay', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	              'visible' => array( 'bg_overlay', '=', '1' ),
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu-section-overlay' => array(
							'property' => 'background',
							'when' => array('bg_overlay', '=', '1'),
						),
					)
	            ),
	             array (
	              'att_name' => 'full_screen',
	              'type' => 'switch',
	              'label' => __( 'Enable Full Screen Section', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
				),
				array (
					'att_name'		=> 'enable_custom_height',
					'type'			=> 'switch',
					'label'			=> __( 'Enable Custom Height', 'tatsu' ),
					'default'		=> '',
					'visible'		=> array( 'full_screen', '==', '0' ),
					'tooltip'		=> '',
				),
				array (
					'att_name'		=> 'custom_height',
					'type'			=> 'number',
					'label'			=> __( 'Custom Height', 'tatsu' ),
					'default'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'options'		=> array (
						'unit'		=> array( 'vh', 'px' ),
					),
					'visible'		=> array(
						'condition'	=> array (
							array( 'full_screen', '==', '0' ),
							array( 'enable_custom_height', '==', '1' )
						),
						'relation'	=> 'and',
					),
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-custom-height-wrap'	=> array (
							'property'		=> 'min-height',
							'when'			=> array (
								array ( 'full_screen', 'empty' ),
								array ( 'enable_custom_height', '=', '1' )
							),
							'relation'		=> 'and'
						),
					),
					'tooltip'		=> '',
				),
				array (
					'att_name' => 'vertical_align',
					'type' => 'button_group',
					'label' => __( 'Vertical Alignment', 'tatsu' ),
					'options' => array (
						'flex-start' => 'Top', 
						'center' => 'Middle', 
						'flex-end' => 'Bottom',
					),
					'default' => 'center',
					'tooltip' => '',
					'visible'	=> array (
							'condition'	=> array (
								 array ( 'full_screen', '=', '1' ),
								 array ( 'enable_custom_height', '=', '1' )
							),
							'relation'	=> 'or'
					),
					'css'	=> true,
					'selectors'	=> array (
							'.tatsu-{UUID} .tatsu-fullscreen-wrap' => array (
									'property'	=> 'align-items',
									'when'	=> array ( 'full_screen', '=', '1' )
							),
							'.tatsu-{UUID} .tatsu-custom-height-wrap' => array (
								'property'	=> 'align-items',
								'when'	=> array ( 'enable_custom_height', '=', '1' )
						  )
					)
				),
				array (
					'att_name'		=> 'top_divider',
					'type'			=> 'select',
					'label'			=> __( 'Separator', 'tatsu' ),
					'options'		=> !empty( $divider_options ) ? $divider_options[ 'top' ] : array(),
					'default'		=> 'none'
				),     
				array (
					'att_name' => 'top_divider_zindex',
					'type'	=> 'number',
					'label'	=> __( 'Stack Order', 'tatsu' ),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'selectors'	=> array (
							'.tatsu-{UUID} > .tatsu-top-divider'	=> array (
								 'property'	=> 'z-index',
							),
					)
				),
				array (
					'att_name' => 'bottom_divider_zindex',
					'type'	=> 'number',
					'label'	=> __( 'Stack Order', 'tatsu' ),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'selectors'	=> array (
							'.tatsu-{UUID} > .tatsu-bottom-divider'	=> array (
								 'property'	=> 'z-index',
							),
					),
				),
				array (
					'att_name'		=> 'bottom_divider',
					'type'			=> 'select',
					'label'			=> __( 'Separator', 'tatsu' ),
					'options'		=> !empty( $divider_options ) ? $divider_options[ 'bottom' ] : array(),
					'default'		=> 'none'
				),
				array (
					'att_name'		=> 'top_divider_height',
					'type'			=> 'slider',
					'label'			=> __( 'Height', 'tatsu' ),
					'options'		=> array (
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> 'px',
						'step'		=> 1
					),
					'default'		=> 100,
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'selectors' => array (
					    '.tatsu-{UUID} > .tatsu-top-divider' => array(
							'property' => 'height',
							'when' => array('top_divider', '!=', 'none'),
							'append' => 'px'
						),
					)
				),
				array (
					'att_name'		=> 'top_divider_position',
					'type'			=> 'select',
					'label'			=> __( 'Position', 'tatsu' ),
					'options'		=> array (
						'above'		=> 'Above Section Content',
						'over'		=> 'Over Section Content'
					),
					'default'		=> 'above',
					'visible'		=> array (
						'full_screen', '!=', '1'
					)
				),
				array (
					'att_name'		=> 'bottom_divider_height',
					'type'			=> 'slider',
					'label'			=> __( 'Height', 'tatsu' ),
					'options'		=> array (
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> 'px',
						'step'		=> 1
					),
					'default'		=> 100,
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'selectors' => array (
					    '.tatsu-{UUID} > .tatsu-bottom-divider' => array(
							'property' => 'height',
							'when' => array('bottom_divider', '!=', 'none'),
							'append' => 'px'
						),
					)
				),
				array (
					'att_name'		=> 'bottom_divider_position',
					'type'			=> 'select',
					'label'			=> __( 'Position', 'tatsu' ),
					'options'		=> array (
						'below'		=> 'Below Section Content',
						'over'		=> 'Over Section Content'
					),
					'default' 		=> 'below',
					'visible'		=> array (
						'full_screen', '!=', '1'
					),
				),
				array (
					'att_name'		=> 'top_divider_color',
					'type'			=> 'color',
					'label'			=> __( 'Color', 'tatsu' ),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} > .tatsu-top-divider' => array (
							'property'			=> 'color',
							'when'				=> array ( 'top_divider', '!=', 'none' ),
						),
					),
				),
				array (
					'att_name'		=> 'bottom_divider_color',
					'type'			=> 'color',
					'label'			=> __( 'Color', 'tatsu' ),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} > .tatsu-bottom-divider' => array (
							'property'			=> 'color',
							'when'				=> array ( 'bottom_divider', '!=', 'none' ),
						),
					),
				),
				array (
					'att_name'		=> 'invert_top_divider',
					'type'			=> 'switch',
					'label'			=> __( 'Invert', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array (
					'att_name'		=> 'invert_bottom_divider',
					'type'			=> 'switch',
					'label'			=> __( 'Invert', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array (
					'att_name'		=> 'flip_top_divider',
					'type'			=> 'switch',
					'label'			=> __( 'Flip', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array (
					'att_name'		=> 'flip_bottom_divider',
					'type'			=> 'switch',
					'label'			=> __( 'Flip', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> ''
				),
	             array (
	              'att_name' => 'section_id',
	              'type' => 'text',
	              'label' => __( 'Section Id', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'section_class',
	              'type' => 'text',
	              'label' => __( 'Section Class', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'section_title',
	              'type' => 'text',
	              'label' => __( 'Section Title', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'offset_section',
	              'type' => 'switch',
	              'label' => __( 'Offset Section', 'tatsu' ),
	              'default' => false,
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'offset_value',
	              'type' => 'number',
	              'label' => __( 'Offset Top By', 'tatsu' ),
	              'options' => array(
	              	'unit' => 'px',
	              	'add_unit_to_value' => true,
	              ),
	              'default' => '0',
	              'tooltip' => '',
	              'visible' => array( 'offset_section', '=', '1' ),
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu-section-offset-wrap' => array(
							'property' => 'transformY',
							'when' => array('offset_section', '=', true),
							'prepend' => '-'
						),
					)
	            ),		             
	             array (
	              'att_name' => 'full_screen_header_scheme',
	              'type' => 'button_group',
	              'label' => __( 'Header Color Scheme', 'tatsu' ),
	              'options' => array (
	                'background--light' => 'Dark',
					'background--dark' => 'Light', 
	              ),
	              'default' => 'background--dark',
	              'tooltip' => '',
	              //'visible' => array( 'full_screen', '=', '1' ),
				),
				array (
					'att_name'	=> 'z_index',
					'type'		=> 'slider',
					'label'		=> __( 'Stack Order', 'tatsu' ),
					'options'	=> array (
						'min'	=> 0,
						'max'	=> 10,
						'step'	=> 1,
						'unit'	=> '',
					),
					'default'	=> 0,
					'tooltip'	=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'z-index',
							'when' => array('z_index', 'notempty'),
						),
					),
				),
				array (
					'att_name' => 'overflow',
					'type' => 'switch',
					'label' => __( 'Disable Section Overflow', 'tatsu' ),
					'default' => false,
					'tooltip' => '',
				),
	            array (
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	        ),
	    );
	tatsu_register_module( 'tatsu_section', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_row' );
function tatsu_register_row() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Row', 'tatsu' ),
	        'is_js_dependant' => true,
			'child_module' => 'tatsu_column',
			'label' => 'Row',
			'initial_children' => 1,
	        'type' => 'core',
	        'builder_layout' => 'column',
			'is_built_in' => true,
			'group_atts' => array(
				'full_width',
				'padding',
				'margin',
				array (
					'type' => 'accordion' ,
					'active' => array( 0 ),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Column Structure', 'tatsu' ),
							'group' => array (
								'gutter',
								'equal_height_columns',
								'no_margin_bottom',
								'column_spacing',
								'fullscreen_cols',
								'swap_cols',
							)
						),	
						array (
							'type' => 'panel',
							'title' => __( 'Styling', 'tatsu' ),
							'group' => array (
								'bg_color',
								'border',
								'border_color',
								'border_radius',
								'box_shadow',
								
							)
						),	
						array (
							'type' => 'panel',
							'title' => __( 'Identifiers', 'tatsu' ),
							'group' => array (
								'row_id',
								'row_class',
							)
						)
					) 
				),									
				'hide_in'
			),
	        'atts' => array (
	            array (
	              'att_name' => 'full_width',
	              'type' => 'switch',
	              'label' => __( 'Full Width Row', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
				),
				// array (
	        	// 	'att_name' => 'max_width',
	        	// 	'type' => 'slider',
	        	// 	'label' => __( 'Content Width', 'tatsu' ),
	        	// 	'options' => array(
	        	// 		'min' => '0',
	        	// 		'max' => '1920',
	        	// 		'step' => '1',
	        	// 		'unit' => 'px',
	        	// 	),		        		
	        	// 	'default' => '1160',
				// 	'tooltip' => '',
				// 	'visible' => array('full_width', '!=', '1'),
				// 	'responsive' => true,
				// 	'css'=>true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID}.tatsu-row-wrap' => array(
				// 			'property' => 'max-width',
				// 			'when' => array('full_width', '!=', '1'),
				// 			'append' => 'px',
				// 		),
				// 	),
	        	// ),
				array (
					'att_name' => 'bg_color',
					'type' => 'color',
					'options' => array (
						'gradient' => true
					),
					'label' => __( 'Background Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
							'property' => 'background-color',
						),
					),
				),
				array (
	              'att_name' => 'border',
	              'type' => 'input_group',
	              'label' => __( 'Border Thickness', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
				  'tooltip' => '',
				  'responsive' => true,
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-row-wrap' => array(
							'property' => 'border-width',
							'when' => array('border', '!=', '0px 0px 0px 0px' ),
						),
					),
	            ),
	            array (
	              'att_name' => 'border_color',
	              'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
	              'label' => __( 'Border Color', 'tatsu' ),
	              'default' => '',
				  'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-row-wrap' => array(
							'property' => 'border-color',
							'when' => array('border', '!=', '0px 0px 0px 0px'),
						),
					),
				),
				array (
				'att_name' => 'no_margin_bottom',
				'type' => 'switch',
				'label' => __( 'Set margin bottom of all columns to zero', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'equal_height_columns',
	              'type' => 'switch',
	              'label' => __( 'Set all columns to be of equal height', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'gutter',
	        		'type' => 'select',
	        		'label' => __( 'Spacing between columns', 'tatsu' ),
	        		'options' => array(
	        			'tiny' => 'Tiny',
	        			'small' => 'Small',
	        			'medium' => 'Medium',
	        			'large' => 'Large',
	        			'no' => 'Zero',
	        			'custom' => 'Custom',
	        		),
	        		'default' => 'medium',
					'tooltip' => '',
	        	),	             
	             array (
	              'att_name' => 'column_spacing',
	              'type' => 'number',
	              'label' => __( 'Column Spacing', 'tatsu' ),
	              'options' => array(
	              	'unit' => 'px',
	              	'add_unit_to_value' => true,
	              ),
	              'default' => '',
				  'tooltip' => '',
	              'visible' => array( 'gutter', '=', 'custom' ),
	            ),
	             array (
	             	'att_name'	=> 'fullscreen_cols',
	             	'type'		=> 'switch',
	             	'label'		=> __( 'FullScreen Columns', 'tatsu' ),
	             	'default'	=> 0,
	             	'tooltip'	=> ''
	             ),
				 array (
					'att_name'		=> 'swap_cols',
					'type'			=> 'switch',
					'label'			=> __( 'Swap Columns in Mobile', 'tatsu' ),
					'default'		=> 0,
					'tooltip'		=> ''	
				 ),
				 array (
				   'att_name' => 'padding',
				   'type' => 'input_group',
				   'label' => __( 'Padding', 'tatsu' ),
				   'default' => '0px 0px 0px 0px',
				   'tooltip' => '',
				   'css' => true,
				   'responsive' => true,
				   'selectors' => array(
						 '.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
							 'property' => 'padding',
							 'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
						 ),
					 ),
				 ),//markk
				array (
					'att_name' => 'margin',
					'type' => 'negative_number',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px',
					'option_labels' => array('Top','Bottom'),
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
							'.tatsu-{UUID} > .tatsu-row' => array(
								'property' => 'margin-top',
								'when' => array('margin', '!=', array( 'd' => '0px 0px' ) ),
								'callback' => 'tatsu_row_margin_top_callback',
							),
							'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
								'property' => 'margin-bottom',
								'when' => array('margin', '!=', array( 'd' => '0px 0px' ) ),
								'callback' => 'tatsu_row_margin_bottom_callback',
							),
						),
				),
				 array (
	              'att_name' => 'row_id',
	              'type' => 'text',
	              'label' => __( 'Row Id', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'row_class',
	              'type' => 'text',
	              'label' => __( 'Row Class', 'tatsu' ),
	              'default' => '',
	              'tooltip' => 'Use this to add a css class identifier to this Row. Separate multiple classes using Comma',
	            ),
	             array (
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
				),
				 array (
					 'att_name' => 'box_shadow',
					 'type' => 'input_box_shadow',
					 'label' => __( 'Shadow Value', 'tatsu' ),
					 'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					 'tooltip' => '',
					 'css' => true,
					'selectors' => array(
							'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
								'property' => 'box-shadow',
								'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
							),
						),
				 ),
				 array(
					'att_name' => 'border_radius',
					'type' => 'number',
					'label' => __('Border Radius', 'tatsu'),
					'options' => array(
						'unit' => 'px',
						'add_unit_to_value' => true,
					),
					'default' => '0',
					'css' => true,
					'selectors' => array(
					   '.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
							'property' => 'border-radius',
							'when' => array('border_radius', '!=', '0px'),
						),
					),
					'tooltip' => 'Use this to give border radius',
				),
	        ),
	    );
	tatsu_register_module( 'tatsu_row', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_column' );
function tatsu_register_column() {

		$column_divider_options = tatsu_get_shape_dividers();
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Column', 'tatsu' ),
	        'is_js_dependant' => true,
	        'type' => 'core',
			'is_built_in' => true,
			'child_module' => 'module',
			'initial_children' => 0,
			'group_atts' => array(
				array (
					'type' => 'accordion' ,
					'active' => array(0),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Background', 'tatsu' ),
							'group' => array (
								'bg_color',
								'bg_image',
								'bg_repeat',
								'bg_attachment',
								'bg_position',
								'bg_size',
								'bg_video',
								'bg_video_mp4_src',
								'bg_video_ogg_src',
								'bg_video_webm_src'
							)
						)
					)
				),
				'padding',	
				array (
					'type' => 'accordion' ,
					'active' => array(0),
					'group' => array (		
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'column_width',
								'column_mobile_spacing',
								'vertical_align',
								'custom_margin',
								'margin',
								'border',
								'border_color',
								'border_radius',
								'enable_box_shadow',
								'box_shadow_custom',
								'hover_box_shadow',
							)
						),	
						array (
							'type' => 'panel',
							'title' => __( 'Overlay', 'tatsu' ),
							'group' => array (
								'bg_overlay',
								'overlay_color',
								'animate_overlay',
								'link_overlay'
							)
						),
						array (
							'type'		=> 'panel',
							'title'		=> __( 'Shape Divider', 'tatsu' ),
							'group'		=> array (
								array (
									'type'  	=> 'tabs',
									'group'		=> array (
										array (
											'type'		=> 'tab',
											'title'		=> __( 'Top', 'tatsu' ),
											'group'		=> array (
												'top_divider',
												'top_divider_color',
												'top_divider_height',
												'flip_top_divider',
												'top_divider_zindex',
											),
										),
										array (
											'type'		=> 'tab',
											'title'		=> __( 'Bottom', 'tatsu' ),
											'group'		=> array (
												'bottom_divider',
												'bottom_divider_color',
												'bottom_divider_height',
												'flip_bottom_divider',
												'bottom_divider_zindex',
											),
										),
										array (
											'type'		=> 'tab',
											'title'		=> __( 'Left', 'tatsu' ),
											'group'		=> array (
												'left_divider',
												'left_divider_color',
												'left_divider_width',
												'invert_left_divider',
												'left_divider_zindex',
											),	
										),
										array (
											'type'		=> 'tab',
											'title'		=> __( 'Right', 'tatsu' ),
											'group'		=> array (
												'right_divider',
												'right_divider_color',
												'right_divider_width',
												'invert_right_divider',
												'right_divider_zindex',
											),
										),
									),
								),
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Advanced', 'tatsu' ),
							'group' => array (
								'sticky',
								'column_offset',
								'offset',
								'z_index',
								'column_parallax',
								'image_hover_effect',
								'column_hover_effect',
								'overflow',
							)
						),	
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Identifiers', 'tatsu' ),
							'group' => array (
								'col_id',
								'column_class'
							)
						)
					) 
				),
				'hide_in'
			),
	        'atts' => array (
	             array (
	              'att_name' => 'bg_color',
				  'type' => 'color',
				  'options' => array (
							'gradient' => true
				  ),
	              'label' => __( 'Background Color', 'tatsu' ),
	              'default' => '',
				  'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
					  '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						  'property' => 'background-color',
					  ),
					),
	            ),
	             array (
	              'att_name' => 'bg_image',
	              'type' => 'single_image_picker',
	              'label' => __( 'Background Image', 'tatsu' ),
	              'default' => '',
				  'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
							'property' => 'background-image',
							'when' => array('bg_image', 'notempty'),
						),
					),
	            ),
	             array (
	              'att_name' => 'bg_repeat',
	              'type' => 'select',
	              'label' => __( 'Background Repeat', 'tatsu' ),
	              'options' => array (
	                'repeat' => 'Repeat Horizontally & Vertically',
	                'repeat-x' => 'Repeat Horizontally',
	                'repeat-y' => 'Repeat Vertically',
	                'no-repeat' => 'Don\'t Repeat',
	              ),
	              'default' => 'no-repeat',
	              'tooltip' => '',
				  'hidden' => array( 'bg_image', '=', '' ),
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
							'property' => 'background-repeat',
							'when' => array('bg_image', 'notempty'),
						),
						'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-bg-blur' => array(
							'property' => 'background-repeat',
							'when' => array('bg_image', 'notempty'),
						),
					),
	            ),
	             array (
	              'att_name' => 'bg_attachment',
	              'type' => 'select',
	              'label' => __( 'Background Attachment', 'tatsu' ),
	              'options' => array (
	                'scroll' => 'Scroll',
	                'fixed' => 'Fixed'
	              ),
	              'default' => 'scroll',
	              'tooltip' => '',
				  'hidden' => array( 'bg_image', '=', '' ),
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
							'property' => 'background-attachment',
							'when' => array('bg_image', 'notempty'),
						),
						'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-bg-blur' => array(
							'property' => 'background-attachment',
							'when' => array('bg_image', 'notempty'),
						),
					),
	            ),
	             array (
	              'att_name' => 'bg_position',
	              'type' => 'select',
	              'label' => __( 'Background Position', 'tatsu' ),
	              'options' => array (
	                'top left' => 'Top Left',
	                'top right' => 'Top Right',
	                'top center' => 'Top Center', 
	                'center left' => 'Center Left', 
	                'center right' => 'Center Right', 
	                'center center' => 'Center Center',
	                'bottom left' => 'Bottom Left',
	                'bottom right' => 'Bottom Right',
	                'bottom center' => 'Bottom Center'
	              ),
	              'default' => 'top left',
	              'tooltip' => '',
				  'hidden' => array( 'bg_image', '=', '' ),
				  'responsive' => true,
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
							'property' => 'background-position',
							'when' => array('bg_image', 'notempty'),
						),
						'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-bg-blur' => array(
							'property' => 'background-position',
							'when' => array('bg_image', 'notempty'),
						),
					),
	            ),
	             array (
	              'att_name' => 'bg_size',
	              'type' => 'select',
	              'label' => __( 'Background Size', 'tatsu' ),
	              'options' => array (
	              	'cover' => 'Cover',
	              	'contain' => 'Contain',
	              	'initial' => 'Initial',
	              	'inherit' => 'Inherit'
	              ),
	              'default' => 'cover',
	              'tooltip' => '',
				  'hidden' => array( 'bg_image', '=', '' ),
				  'responsive' => true,
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
							'property' => 'background-size',
							'when' => array('bg_image', 'notempty'),
						),
						'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-bg-blur' => array(
							'property' => 'background-size',
							'when' => array('bg_image', 'notempty'),
						),
					),
				),
	            array (
	              'att_name' => 'padding',
	              'type' => 'input_group',
	              'label' => __( 'Padding', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
				  'tooltip' => '',
				  'css' => true,
				  'responsive' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-pad-wrap > .tatsu-column-pad' => array(
							'property' => 'padding',
							'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
						),
					),
				),
				array (
	              'att_name' => 'custom_margin',
	              'type' => 'switch',
	              'label' => __( 'Custom Margin ?', 'tatsu' ),
	              'default' => '0',
				  'tooltip' => '',				  
	            ),	            
	             array (
	              'att_name' => 'margin',
	              'type' => 'input_group',
	              'label' => __( 'Margin', 'tatsu' ),
	              'default' => '0px 0px 50px 0px',
	              'tooltip' => '',
				  'visible' => array( 'custom_margin', '=', '1' ),
				  'css' => true,
				  'responsive' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column' => array(
							'property' => 'margin',
							'when' => array(
								array( 'custom_margin', '=', '1'),
								array( 'margin', '!=', array( 'd' => '0px 0px 50px 0px' ) ),
							),
							'relation' => 'and',
							'append' => ' !important',
						),
					),
	            ),
				array (
	              'att_name' => 'border',
	              'type' => 'input_group',
	              'label' => __( 'Border Thickness', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
				  'tooltip' => '',
				  'responsive' => true,
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
							'property' => 'border-width',
							'when' => array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
						),
					),
	            ),
	            array (
	              'att_name' => 'border_color',
	              'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
	              'label' => __( 'Border Color', 'tatsu' ),
	              'default' => '',
				  'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
							'property' => 'border-color',
							'when' => array('border', '!=', '0px 0px 0px 0px'),
						),
					),
				),
				array(
					'att_name' => 'border_radius',
					'type' => 'number',
					'label' => __('Border Radius', 'tatsu'),
					'options' => array(
						'unit' => 'px',
						'add_unit_to_value' => true,
					),
					'default' => '0',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
							'property' => 'border-radius',
							'when' => array('border_radius', '!=', '0px'),
						),
						'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
							'property' => 'border-radius',
							'when' => array('border_radius', '!=', '0px'),
						),
						'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-overlay'  => array(
							'property' => 'border-radius',
							'when' => array('border_radius', '!=', '0px'),
						),
					),
					'tooltip' => 'Use this to give border radius',
				),
	            array (
					'att_name' => 'enable_box_shadow',
					'type' => 'switch',
					'label' => __( 'Enable Column Shadow', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
				), 
				array (
					'att_name' => 'box_shadow_custom',
					'type' => 'input_box_shadow',
					'label' => __( 'Column Shadow Values', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'visible' => array( 'enable_box_shadow', '=', '1' ),
					'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
							'property' => 'box-shadow',
							'when' => array(
								array('enable_box_shadow', '=', '1'),
								array( 'box_shadow_custom', '!=', '0px 0px 0px 0px rgba(0,0,0,0)' ),
							),
							'relation' => 'and',
						),
					),
	            ), 
				array (
					'att_name' => 'bg_video',
					'type' => 'switch',
					'label' => __( 'Enable Background Video', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
	            ),
	             array (
	             	'att_name' => 'bg_video_mp4_src',
	             	'type' => 'text',
	             	'label' => __( '.MP4 Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),
	             ),
	             array (
	             	'att_name' => 'bg_video_ogg_src',
	             	'type' => 'text',
	             	'label' => __( '.OGG Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),             	
	             ),
	             array (
	             	'att_name' => 'bg_video_webm_src',
	             	'type' => 'text',
	             	'label' => __( '.WEBM Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),             	
	             ),
	             array (
	              'att_name' => 'bg_overlay',
	              'type' => 'switch',
	              'label' => __( 'Enable Background Overlay', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'overlay_color',
	              'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
	              'label' => __( 'Column Overlay', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
				  'visible' => array( 'bg_overlay', '=', '1' ),
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-overlay' => array(
							'property' => 'background',
							'when' => array('bg_overlay', '=', '1'),
						),
					),
	            ),
	             array (
	              'att_name' => 'animate_overlay',
	              'type' => 'select',
	              'label' => __( 'Animate Column Overlay', 'tatsu' ),
	              'options' => array (
	                'none' => 'None', 
	                'hide' => 'Hidden by default and Show on Hover', 
	                'show' => 'Shown by default and Hide on Hover', 
	              ),
	              'default' => 'none',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'link_overlay',
	              'type' => 'text',
	              'label' => __( 'Link Overlay/Column URL', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
				  'visible' => array( 'bg_overlay', '=', '1' ),
	            ),
	             array (
	              'att_name' => 'vertical_align',
	              'type' => 'button_group',
	              'label' => __( 'Vertical Alignment', 'tatsu' ),
	              'options' => array (
	                'none' => 'None',
	                'top' => 'Top', 
	                'middle' => 'Middle', 
	                'bottom' => 'Bottom',
	                // 'baseline' => 'Baseline',
	                // 'stretch' => 'Stretch',
	              ),
	              'default' => 'none',
	              'tooltip' => '',
	            ),
	            array (
	            	'att_name' 	=> 'column_offset',
	            	'type'  	=> 'switch',
	            	'label'		=> __( 'Enable Column Offset', 'tatsu' ),
	            	'default'	=> 0,
	            	'tooltip'	=> ''
				),
				array (
					'att_name' => 'sticky',
					'type' => 'switch',
					'label' => __( 'Sticky Column ?', 'tatsu' ),
					'default' => '0',
					'tooltip' => '',
					'visible' => array('column_offset', '=' ,0)			  
				),
	            array (
	            	'att_name'	=> 'offset',
	            	'type'		=> 'negative_number',
	            	'label'		=> __( 'Column Horizontal Offset', 'tatsu' ),
	            	'default'	=> '0px 0px',
					'option_labels' => array('X-axis','Y-axis'),
	            	'tooltip'	=> '',
					'visible'	=> array( 'column_offset', '==', 1 ),
					'responsive' => true,
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column' => array(
							'property' => 'transform',
							'when' => array('column_offset', '=', '1'),
						),
					),
	            ),
				array (
					'att_name'	=> 'z_index',
					'type'		=> 'slider',
					'label'		=> __( 'Stack Order', 'tatsu' ),
					'options'	=> array (
						'min'	=> 0,
						'max'	=> 10,
						'step'	=> 1,
						'unit'	=> '',
						'add_unit_to_value' => false
					),
					'default'	=> 0,
					'tooltip'	=> '',
					'visible'	=> array( 'column_offset', '==', 1 ),
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column' => array(
							'property' => 'z-index',
							'when' => array(
								array('z_index', 'notempty'),
								array('column_offset', '=', '1')
							),
							'relation' => 'or',
						),
					),
				),


				array (
					'att_name'		=> 'top_divider',
					'type'			=> 'select',
					'label'			=> __( 'Separator', 'tatsu' ),
					'options'		=> !empty( $column_divider_options ) ? $column_divider_options[ 'top' ] : array(),
					'default'		=> 'none'
				),     
				array (
					'att_name'		=> 'bottom_divider',
					'type'			=> 'select',
					'label'			=> __( 'Separator', 'tatsu' ),
					'options'		=> !empty( $column_divider_options ) ? $column_divider_options[ 'bottom' ] : array(),
					'default'		=> 'none'
				),
				array (
					'att_name'		=> 'top_divider_height',
					'type'			=> 'slider',
					'label'			=> __( 'Height', 'tatsu' ),
					'options'		=> array (
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> 'px',
						'step'		=> 1
					),
					'default'		=> array ( 'd' => '100', 'm'	=> '0' ),
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'selectors' => array (
					    '.tatsu-{UUID} .tatsu-top-divider' => array(
							'property' => 'height',
							'when' => array('top_divider', '!=', 'none'),
							'append' => 'px'
						),
					)
				),
				array (
					'att_name'		=> 'bottom_divider_height',
					'type'			=> 'slider',
					'label'			=> __( 'Height', 'tatsu' ),
					'options'		=> array (
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> 'px',
						'step'		=> 1
					),
					'default'		=> array ( 'd' => '100', 'm'	=> '0' ),
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'selectors' => array (
					    '.tatsu-{UUID} .tatsu-bottom-divider' => array(
							'property' => 'height',
							'when' => array('bottom_divider', '!=', 'none'),
							'append' => 'px'
						),
					)
				),
				array (
					'att_name'		=> 'top_divider_color',
					'type'			=> 'color',
					'label'			=> __( 'Color', 'tatsu' ),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-top-divider' => array (
							'property'			=> 'color',
							'when'				=> array ( 'top_divider', '!=', 'none' ),
						),
					),
				),
				array (
					'att_name'		=> 'bottom_divider_color',
					'type'			=> 'color',
					'label'			=> __( 'Color', 'tatsu' ),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-bottom-divider' => array (
							'property'			=> 'color',
							'when'				=> array ( 'bottom_divider', '!=', 'none' ),
						),
					),
				),
				array (
					'att_name'		=> 'flip_top_divider',
					'type'			=> 'switch',
					'label'			=> __( 'Flip', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array (
					'att_name'		=> 'flip_bottom_divider',
					'type'			=> 'switch',
					'label'			=> __( 'Flip', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> ''
				),

				// Left shape divider
				array (
					'att_name'		=> 'left_divider',
					'type'			=> 'select',
					'label'			=> __( 'Separator', 'tatsu' ),
					'options'		=> !empty( $column_divider_options ) ? $column_divider_options[ 'left' ] : array(),
					'default'		=> 'none'
					
				),    
				array (
					'att_name'		=> 'left_divider_width',
					'type'			=> 'slider',
					'label'			=> __( 'Width', 'tatsu' ),
					'options'		=> array (
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> 'px',
						'step'		=> 1
					),
					'default'		=> array ( 'd' => '50', 'm'	=> '0' ),
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'selectors' => array (
						'.tatsu-{UUID} .tatsu-left-divider' => array(
							'property' => 'width',
							'when' => array('left_divider', '!=', 'none'),
							'append' => 'px',
						)
					)
				),
				array (
					'att_name'		=> 'left_divider_color',
					'type'			=> 'color',
					'label'			=> __( 'Color', 'tatsu' ),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-left-divider' => array (
							'property'			=> 'color',
							'when'				=> array ( 'left_divider', '!=', 'none' ),
						),
					),
				),
				array (
					'att_name'		=> 'invert_left_divider',
					'type'			=> 'switch',
					'label'			=> __( 'Invert', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> ''
				),

				// Right shape divider
				array (
					'att_name'		=> 'right_divider',
					'type'			=> 'select',
					'label'			=> __( 'Separator', 'tatsu' ),
					'options'		=> !empty( $column_divider_options ) ? $column_divider_options[ 'right' ] : array(),
					'default'		=> 'none'
				),     
				array (
					'att_name'		=> 'right_divider_width',
					'type'			=> 'slider',
					'label'			=> __( 'Width', 'tatsu' ),
					'options'		=> array (
						'min'		=> 0,
						'max'		=> 500,
						'unit'		=> 'px',
						'step'		=> 1
					),
					'default'		=> array ( 'd' => '50', 'm'	=> '0' ),
					'tooltip'		=> '',
					'responsive'	=> true,
					'css'			=> true,
					'selectors' => array (
					    '.tatsu-{UUID} .tatsu-right-divider' => array(
							'property' => 'width',
							'when' => array('right_divider', '!=', 'none'),
							'append' => 'px',
						),
					)
				),
				array (
					'att_name'		=> 'right_divider_color',
					'type'			=> 'color',
					'label'			=> __( 'Color', 'tatsu' ),
					'default'		=> '#ffffff',
					'tooltip'		=> '',
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-right-divider' => array (
							'property'			=> 'color',
							'when'				=> array ( 'right_divider', '!=', 'none' ),
						),
					),
				),
				array (
					'att_name'		=> 'invert_right_divider',
					'type'			=> 'switch',
					'label'			=> __( 'Invert', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> ''
				),
				array (
	        		'att_name' => 'column_parallax',
	        		'type' => 'slider',
	        		'label' => __( 'Column Parallax', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '10',
	        			'step' => '1',
	        			'unit' => '',
	        		),		        		
	        		'default' => '0',
	        		'tooltip' => ''
				),
				array (
					'att_name' => 'top_divider_zindex',
					'type'	=> 'number',
					'label'	=> __( 'Stack Order', 'tatsu' ),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'selectors'	=> array (
							'.tatsu-{UUID} > .tatsu-column-inner > .tatsu-top-divider'	=> array (
								 'property'	=> 'z-index',
							),
					)
				),
				array (
					'att_name' => 'bottom_divider_zindex',
					'type'	=> 'number',
					'label'	=> __( 'Stack Order', 'tatsu' ),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'selectors'	=> array (
							'.tatsu-{UUID} > .tatsu-column-inner > .tatsu-bottom-divider'	=> array (
								 'property'	=> 'z-index',
							),
					)
				),
				array (
					'att_name' => 'right_divider_zindex',
					'type'	=> 'number',
					'label'	=> __( 'Stack Order', 'tatsu' ),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'selectors'	=> array (
							'.tatsu-{UUID} > .tatsu-column-inner > .tatsu-right-divider'	=> array (
								 'property'	=> 'z-index',
							),
					)
				),
				array (
					'att_name' => 'left_divider_zindex',
					'type'	=> 'number',
					'label'	=> __( 'Stack Order', 'tatsu' ),
					'default' => '9999',
					'tooltip'	=> '',
					'css'	=> true,
					'selectors'	=> array (
							'.tatsu-{UUID} > .tatsu-column-inner > .tatsu-left-divider'	=> array (
								 'property'	=> 'z-index',
							),
					)
				),
				array (
					'att_name' => 'column_width',
					'type' => 'slider',
					'label' => __( 'Column Width', 'tatsu' ),
					'options' => array(
						'min' => '0',
						'max' => '100',
						'step' => '.01',
						'unit' => '%',
					),		        		
					'default' => '',
					'tooltip' => '',
					'responsive' => true,
					'multiselect' => false, //Field disabled for editing on Multi Select
					'css' => true,
					'selectors' => array(
						'.tatsu-row > .tatsu-{UUID}.tatsu-column' => array(
							'property' => 'width',
							'append' => '%'
						)
					),
				),
				array (
					'att_name' => 'overflow',
					'type' => 'switch',
					'label' => __( 'Disable Column Overflow', 'tatsu' ),
					'default' => false,
					'tooltip' => '',
				),
				array(
					'att_name' => 'column_mobile_spacing',
 					'type' => 'number',
					'label' => __( 'Column Spacing (In Mobile)', 'tatsu' ),
					'visible' => array( 'column_width', '<', '100' ),
					'device_visibility' => 'mobile',
 					'options' => array(
 						'unit' => 'px',
 						'add_unit_to_value' => false,
 					),
 					'default' => '0',
					'tooltip' => ''
				),
	             array (
	              'att_name' => 'animate',
	              'type' => 'switch',
	              'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              'default' => '0',
	              'tooltip' => '',
				),
	             array (
	              'att_name' => 'animation_type',
	              'type' => 'select',
	              'label' => __( 'Animation Type', 'tatsu' ),
	              'options' => tatsu_css_animations(),
	              'default' => 'fadeIn',
	              'tooltip' => '',
	              'visible' => array( 'animate', '=', '1' ),
	            ),
				array(
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'tatsu' ),
	        		'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
				array (
                    'att_name' => 'image_hover_effect',
                    'type' => 'select',
                    'label' => __( 'Image Hover Effect', 'tatsu' ),
                    'options' => array(
                        'none' => 'None',
                        'zoom' => 'Zoom',
                        'slow-zoom' => 'Slow Zoom'
                    ),
                    'default' => 'none',
                    'tooltip' => '',
                    'visible' => array( 'bg_image', '!=', '' ),
				  ),
				  array (
                    'att_name' => 'column_hover_effect',
                    'type' => 'select',
                    'label' => __( 'Column Hover Effect', 'tatsu' ),
                    'options' => array(
                        'slideup' => 'Slide Up',
                        'scale' => 'Scale',
						'tilt' => 'Tilt Effect',
						'none' => 'None',
                    ),
                    'default' => 'none',
                    'tooltip' => '',
					'visible'	=> array( 'column_offset', '!=', 1 ),
				  ),
				// array (
				// 	'att_name' => 'enable_hover_box_shadow',
				// 	'type' => 'switch',
				// 	'label' => __( 'Enable Hover Shadow', 'tatsu' ),
				// 	'default' => 0,
				// 	'tooltip' => '',
				// ), 
				array (
					'att_name' => 'hover_box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Hover Shadow Value', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner:hover' => array(
							'property' => 'box-shadow',
							'when' => array('hover_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
	            ), 
	             array (
	              'att_name' => 'col_id',
	              'type' => 'text',
	              'label' => __( 'Column Id', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'column_class',
	              'type' => 'text',
	              'label' => __( 'Column Class', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	        ),
	    );
	tatsu_register_module( 'tatsu_column', $controls );
}

add_action( 'tatsu_register_header_modules', 'tatsu_register_text', 9 );
add_action( 'tatsu_register_modules', 'tatsu_register_text', 9 );
function tatsu_register_text() {
		$controls =  array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#text',
	        'title' => __( 'Text Block', 'tatsu' ),
	        'is_js_dependant' => true,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
			'group_atts' => array(
				'content',
				'max_width',
				'wrap_alignment',
				'text_alignment',
				array (
					'type' => 'accordion' ,
					'active' => array(0),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'margin',
								'padding',
								'color',
								'bg_color',
								'border_radius',
								'box_shadow'
							)
						),		
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Typography', 'tatsu' ),
							'group' => array (
								'text_typography'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Light Scheme Colors', 'tatsu' ),
							'group' => array (
								'light_color'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Dark Scheme Colors', 'tatsu' ),
							'group' => array (
								'dark_color'
							)
						),
						'hide_in'
					) 
				)
			),
	        'atts' => array (
	        	array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),
				 array (
					 'att_name' => 'bg_color',
					 'type' => 'color',
					 'options' => array (
						 'gradient' => true
					 ),
					 'label' => __( 'Background Color', 'tatsu' ),
					 'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
							'property' => 'background-color',
						),
					), 
				 ),
	        	array (
	        		'att_name' => 'max_width',
	        		'type' => 'slider',
	        		'label' => __( 'Content Width', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),		        		
	        		'default' => '100',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
							'property' => 'width',
							'append' => '%'
						)
					),

	        	),
				array (
	        		'att_name' => 'wrap_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Wrap Alignment', 'tatsu' ),
	        		'options' => array (
	        			'left' => 'Left',
	        			'center' => 'Center',	        			
	        			'right' => 'Right',
	        		),
	        		'default' => 'center',
	        		'tooltip' => '',
	        	),
				array (
	        		'att_name' => 'text_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Text Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
					),
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
							'property' => 'text-align',
						),
					),
	        		'default' => 'left',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'animate',
	        		'type' => 'switch',
	        		'label' => __( 'Enable CSS Animation', 'tatsu' ),
	        		'default Value' => 0,
	        		'tooltip' => ''
	        	),
	             array (
	              'att_name' => 'animation_type',
	              'type' => 'select',
	              'label' => __( 'Animation Type', 'tatsu' ),
	              'options' => tatsu_css_animations(),
	              'default' => 'fadeIn',
	              'tooltip' => '',
	              'visible' => array( 'animate', '=', '1' ),
	            ),
				array(
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'tatsu' ),
	        		'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 30px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-text-block-wrap' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 30px 0px' ) ),
						),
					),
				),
				array (
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
							'property' => 'box-shadow',
							'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
				),
				array (
					'att_name' => 'padding',
					'type' => 'input_group',
					'label' => __( 'Padding', 'tatsu' ),
					'default' => '0px 0px 0px 0px',
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
							'property' => 'padding',
							'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
						),
					),
				),
				array(
					'att_name' => 'border_radius',
					'type' => 'number',
					'label' => __('Border Radius', 'tatsu'),
					'options' => array(
						'unit' => 'px',
						'add_unit_to_value' => true,
					),
					'default' => '0',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-text-block-wrap .tatsu-text-inner' => array(
							'property' => 'border-radius',
							'when' => array('border_radius', '!=', '0px'),
						),
					),
					'tooltip' => 'Use this to give border radius',
				),
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
	        		),
	        	)
	        ),
		);
	tatsu_register_module( 'tatsu_text', $controls );
	tatsu_register_header_module( 'tatsu_text', $controls, 'tatsu_text' );

}

// add_action( 'tatsu_register_header_modules', 'tatsu_register_inline_text', 9 );
add_action( 'tatsu_register_modules', 'tatsu_register_inline_text', 9 );
function tatsu_register_inline_text() {
	$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#inline_text',
	        'title' => __( 'Inline Text', 'tatsu' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
			'drag_handle' => false,
			'group_atts' => array(
				'max_width',
				'wrap_alignment',
				'text_alignment',
				array (
					'type' => 'accordion' ,
					'active' => array(0),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'margin',
								'padding',
								'bg_color',
								'border_radius',
								'box_shadow'
							)
						),		
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay'
							)
						)
					) 
				),	
			),
			'atts' => array (
	            array (
	        		'att_name' => 'max_width',
	        		'type' => 'slider',
	        		'label' => __( 'Content Width', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
						'unit' => '%',
	        		),		        		
	        		'default' => '100',
					'tooltip' => '',
					'responsive' => true,
					'css'=>true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
							'property' => 'width',
							'append' => '%'
						)
					),
	        	),
				array (
					'att_name' => 'content',
					'type' => 'text',
					'label' => 'Content',
					'default' => "",
					'tooltip' => '',
					'visible' => array( 'margin', '==', '-100' )
				),
				array (
                    'att_name' => 'wrap_alignment',
                    'type' => 'button_group',
                    'label' => __( 'Wrap Alignment', 'tatsu' ),
                    'options' => array (
                        'left' => 'Left',
                        'center' => 'Center',                        
                        'right' => 'Right',
                    ),
                    'default' => 'center',
                    'tooltip' => '',
                    //'visible' => array( 'max_width', '<', '100' ),
				),
				array (
	        		'att_name' => 'text_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Text Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
					),
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
							'property' => 'text-align',
						),
					),
	        		'default' => 'left',
	        		'tooltip' => ''
	        	),
				array (
	        		'att_name' => 'animate',
	        		'type' => 'switch',
	        		'label' => __( 'Enable CSS Animation', 'tatsu' ),
	        		'default Value' => 0,
	        		'tooltip' => ''
	        	),
	             array (
	              'att_name' => 'animation_type',
	              'type' => 'select',
	              'label' => __( 'Animation Type', 'tatsu' ),
	              'options' => tatsu_css_animations(),
	              'default' => 'fadeIn',
	              'tooltip' => '',
	              'visible' => array( 'animate', '=', '1' ),
	            ),
				array (
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'tatsu' ),
	        		'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
	        	),				
				array (
	        		'att_name' => 'margin',
	        		'type' => 'input_group',
	        		'label' => __( 'Margin', 'tatsu' ),
	              	'default' => '0px 0px 30px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors'=> array(
						'.tatsu-{UUID}.tatsu-inline-text' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 30px 0px' ) ),
						),
					),
	        	),
				array (
					'att_name' => 'bg_color',
					'type' => 'color',
					'options' => array (
						'gradient' => true
					),
					'label' => __( 'Background Color', 'tatsu' ),
					'default' => '',
				   'tooltip' => '',
				   'css' => true,
				   'selectors' => array(
					   '.tatsu-{UUID} .tatsu-inline-text-inner' => array(
						   'property' => 'background-color',
					   ),
				   ), 
				),
				array (
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow Value', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu-inline-text-inner' => array(
							'property' => 'box-shadow',
							'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
	            ),
	            array (
	              'att_name' => 'padding',
	              'type' => 'input_group',
	              'label' => __( 'Padding', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
				  'tooltip' => '',
				  'css' => true,
				  'responsive' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu-inline-text-inner' => array(
							'property' => 'padding',
							'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
						),
					),
	            ),
				array(
					'att_name' => 'border_radius',
					'type' => 'number',
					'label' => __('Border Radius', 'tatsu'),
					'options' => array(
						'unit' => 'px',
						'add_unit_to_value' => true,
					),
					'default' => '0',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
							'property' => 'border-radius',
							'when' => array('border_radius', '!=', '0px'),
						),
					),
					'tooltip' => 'Use this to give border radius',
				),	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
						'max_width'	=> array ( 'd' => '100', 'm'	=> '100' ),
	        		),
	        	)
	        ),					
	);
	tatsu_register_module( 'tatsu_inline_text', $controls );
	// tatsu_register_header_module( 'tatsu_inline_text', $controls, 'tatsu_header_inline_text' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_button', 9 );
add_action( 'tatsu_register_header_modules', 'tatsu_register_button', 9 );
function tatsu_register_button() {

		$controls = array (
			'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#button',
	        'title' => __( 'Button', 'tatsu' ),
			'is_js_dependant' => false,
			'child_module' => '',
			'inline' => true,
			'type' => 'single',
			'is_built_in' => true,
			'group_atts' => array(
				'button_text',
				'url',
				'new_tab',
				array (
					'type' => 'accordion' ,
					'active' => array(0, 1),
					'group' => array (	
						array (
							'type' => 'panel',
							'title' => __( 'Shape and Size', 'tatsu' ),
							'group' => array (
								'type',
								'button_style',
								'alignment',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Colors', 'tatsu' ),
							'group' => array (
								'bg_color',
								'hover_bg_color',
								'color',
								'hover_color',
								'border_width',
								'border_color',
								'hover_border_color',
							)
						),				
						array (
							'type' => 'panel',
							'title' => __( 'Advanced', 'tatsu' ),
							'group' => array (
								'icon',
								'lightbox',
								'image',
								'video_url',
								'hover_effect',
								'box_shadow',
								'hover_box_shadow',
								'background_animation',
								'enable_margin',
								'margin',
								'hide_id'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Light Scheme Colors', 'tatsu' ),
							'group' => array (
								'light_color',
								'light_bg_color',
								'light_border_color',
								'light_hover_color',
								'light_hover_bg_color',
								'light_hover_border_color'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Dark Scheme Colors', 'tatsu' ),
							'group' => array (
								'dark_color',
								'dark_bg_color',
								'dark_border_color',
								'dark_hover_color',
								'dark_hover_bg_color',
								'dark_hover_border_color'
							)
						),
						'hide_in'
					) 
				)
			),
			'atts' => array (
				array (
					'att_name' => 'button_text',
					'type' => 'text',
					'label' => __( 'Button Text', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'url',
					'type' => 'text',
					'label' => __( 'URL to be linked', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'new_tab',
 					'type' => 'switch',
 					'label' => __( 'Open in a new tab', 'tatsu' ),
 					'default' => '0',
 					'tooltip' => '',
 					'visible' => array( 'url', '!=', '' ),
 				),
 				array (
 					'att_name' => 'type',
 					'type' => 'button_group',
 					'label' => __( 'Button Size', 'tatsu' ),
 					'options' => array (
 						'small' => 'Small',
 						'medium' => 'Medium',
						'large' => 'Large',
						'x-large' => 'X Large',
						'block' => 'Block',
						//'custom' => 'Custom',
 					),
 					'default' => 'medium',
 					'tooltip' => ''
				 ),
				//  array( // abandon this  custom button size
				// 	'att_name' => 'custom_button_height',
				// 	'type' => 'slider',
				// 	'label' => __('Button Height', 'tatsu'),
				// 	'options' => array(
				// 		'min' => 5,
				// 		'max' => 250,
				// 		'step' => 1,
				// 		'unit' => 'px',
				// 		'add_unit_to_value' => true
				// 	),
				// 	'visible' => array( 'type', '=', 'custom' ),
				// 	'default' => '25',
				// 	'css' => true,
				// 	//'responsive' => true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID} .tatsu-shortcode' => array(
				// 			'property' => 'padding-top',
				// 			'when' => array('type', '=', 'custom'),
				// 		),
				// 		'.tatsu-{UUID} .tatsu-button' => array(
				// 			'property' => 'padding-bottom',
				// 			'when' => array('type', '=', 'custom'),
				// 		),
				// 	),
				// ),
				// array( // abandon this
				// 	'att_name' => 'custom_button_width',
				// 	'type' => 'slider',
				// 	'label' => __('Button Width', 'tatsu'),
				// 	'options' => array(
				// 		'min' => 5,
				// 		'max' => 500,
				// 		'step' => 1,
				// 		'unit' => 'px',
				// 		'add_unit_to_value' => true
				// 	),
				// 	'visible' => array( 'type', '=', 'custom' ),
				// 	'default' => '50',
				// 	'css' => true,
				// 	//'responsive' => true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID} .tatsu-shortcode' => array(
				// 			'property' => 'padding-right',
				// 			'when' => array('type', '=', 'custom'),
				// 		),
				// 		'.tatsu-{UUID} .tatsu-button' => array(
				// 			'property' => 'padding-left',
				// 			'when' => array('type', '=', 'custom'),
				// 		),
				// 	),
				// ),
				// array( // abandon this
				// 	'att_name' => 'custom_text_size',
				// 	'type' => 'slider',
				// 	'label' => __('Button Text size', 'tatsu'),
				// 	'options' => array(
				// 		'min' => 5,
				// 		'max' => 50,
				// 		'step' => 1,
				// 		'unit' => 'px',
				// 		'add_unit_to_value' => true
				// 	),
				// 	'visible' => array( 'type', '=', 'custom' ),
				// 	'default' => '18',
				// 	'css' => true,
				// 	//'responsive' => true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID} .tatsu-button' => array(
				// 			'property' => 'font-size',
				// 			'when' => array('type', '=', 'custom'),
				// 		),
				// 	),
				// ),
				// array( // abandon this
				// 	'att_name' => 'custom_text_letter_spacing',
				// 	'type' => 'slider',
				// 	'label' => __('Button Letter Spacing', 'tatsu'),
				// 	'options' => array(
				// 		'min' => 0,
				// 		'max' => 25,
				// 		'step' => 1,
				// 		'unit' => 'px',
				// 		'add_unit_to_value' => true
				// 	),
				// 	'visible' => array( 'type', '=', 'custom' ),
				// 	'default' => '0',
				// 	'css' => true,
				// 	//'responsive' => true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID} .tatsu-button' => array(
				// 			'property' => 'letter-spacing',
				// 			'when' => array('type', '=', 'custom'),
				// 		),
				// 	),
				// ),
 				array (
 					'att_name' => 'button_style',
 					'type' => 'button_group',
 					'label' => __( 'Button Shape', 'tatsu' ),
 					'options' => array (
 						'none' => 'Rectangular',
 						'rounded' => 'Rounded',
 						'circular' => 'Pill'
 					),
 					'default' => 'none',
 					'tooltip' => ''
				 ),       	 								
 				array (
 					'att_name' => 'alignment',
 					'type' => 'button_group',
 					'label' => __( 'Button Alignment', 'tatsu' ),
 					'options' => array (
 						'none' => 'None',
 						'left' => array(
 							'icon' => '',
 							'title' => 'Left',
 						),
 						'center' => array(
 							'icon' => '',
 							'title' => 'Center',
 						),
 						'right' => array(
 							'icon' => '',
 							'title' => 'Right',
 						),
 					),
 					'default' => 'none',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'bg_color',
 					'type' => 'color',
 					'label' => __( 'Background Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button' => array(
							'property' => 'background-color',
							'when' => array(
								array( 'background_animation', '!=', 'bg-animation-slide-left' ), // set this way to overcome a wierd issue where the bg animation value of none was set differently for some buttons
								array( 'background_animation', '!=', 'bg-animation-slide-right' ),
								array( 'background_animation', '!=', 'bg-animation-slide-top' ),
								array( 'background_animation', '!=', 'bg-animation-slide-bottom' ),
							),
							'relation' => 'and'
						),
					), 
 				),
 				array (
 					'att_name' => 'hover_bg_color',
 					'type' => 'color',
 					'label' => __( 'Hover Background Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button:hover' => array(
							'property' => 'background-color',
							'when' => array(
								array( 'background_animation', '!=', 'bg-animation-slide-left' ),
								array( 'background_animation', '!=', 'bg-animation-slide-right' ),
								array( 'background_animation', '!=', 'bg-animation-slide-top' ),
								array( 'background_animation', '!=', 'bg-animation-slide-bottom' ),
							),
							'relation' => 'and'
						),
					),					 
 				),
 				array (
 					'att_name' => 'color',
					// 'type' => 'color',
					'type' => 'color',
 					'label' => __( 'Text Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button' => array(
							'property' => 'color',
						),
					),
 				),
  				array (
 					'att_name' => 'hover_color',
 					'type' => 'color',
 					'label' => __( 'Hover Text Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button:hover' => array(
							'property' => 'color',
						),
					), 
 				),
 				array (
 					'att_name' => 'border_width',
 					'type' => 'number',
 					'label' => __( 'Border Size', 'tatsu' ),
 					'options' => array(
 						'unit' => 'px',
 						'add_unit_to_value' => false,
 					),
 					'default' => '0',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button' => array(
							'property' => 'border-width',
							'when' => array( 'border_width', '!=', '0px' ),
							'append' => 'px',
						),
					), 
 				),
 				array (
 					'att_name' => 'border_color',
 					'type' => 'color',
 					'label' => __( 'Border Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button' => array(
							'property' => 'border-color',
							'when' => array( 'border_width', '!=', '0px' ),
						),
					), 
 				),
 				array ( 
 					'att_name' => 'hover_border_color',
 					'type' => 'color',
 					'label' => __( 'Hover Border Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button:hover' => array(
							'property' => 'border-color',
							'when' => array( 'border_width', '!=', '0px' ),
						),
					), 
 				),
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
 				array (
 					'att_name' => 'icon_alignment',
 					'type' => 'button_group',
 					'label' => __( 'Icon Alignment', 'tatsu' ),
 					'options' => array (
 						'left' => 'Left',
 						'right' => 'Right',
 					),
 					'default' => 'left',
 					'tooltip' => '',
 					'visible' => array( 'icon', '!=', '' ),
 				), 				
 				array (
 					'att_name' => 'lightbox',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Lightbox Image / Video', 'tatsu' ),
 					'tooltip' => ''
 				),  				
 				array (
 					'att_name' => 'image',
 					'type' => 'single_image_picker',
 					'label' => __( 'Background Image', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
 					'visible' => array( 'lightbox', '=', '1' ),
 				),
	        	array (
	        		'att_name' => 'video_url',
	        		'type' => 'text',
	        		'label' => __( 'Youtube / Vimeo Url in lightbox', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'visible' => array( 'lightbox', '=', '1' ),
				),
				array (
	        		'att_name' => 'hover_effect',
	        		'type' => 'button_group',
	        		'label' => __( 'Hover Effect', 'tatsu' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'button-transform' => 'Transform',
	        			'button-scale' => 'Scale'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
				),				
 				array (
 					'att_name' => 'background_animation',
 					'type' => 'button_group',
 					'label' => __( 'Background Animation', 'tatsu' ),
 					'options' => array (
 						'none' => 'None',
 						'bg-animation-slide-left' => 'Slide Left',
 						'bg-animation-slide-right' => 'Slide Right',
 						'bg-animation-slide-top' => 'Slide Top',
 						'bg-animation-slide-bottom' => 'Slide Bottom',
 					),
 					'default' => 'none',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'animate',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Css Animations', 'tatsu' ),
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'animation_type',
 					'type' => 'select',
 					'options' => tatsu_css_animations(),
 					'label' => __( 'Animation Type', 'tatsu' ),
 					'default' => 'fadeIn',
 					'tooltip' => '',
 					'visible' => array( 'animate', '=', '1' ),
 				),
				 array(
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'tatsu' ),
	        		'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
				array (
					'att_name' => 'enable_margin',
					'type' => 'switch',
					'label' => __( 'Custom Margin', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 40px 0px',
					'tooltip' => '',
					'css' => true,
					'visible' => array( 'enable_margin', '=', '1' ),
					//'responsive' => true,   // in js attsfromdisplay device is empty
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-button-wrap' => array(
							'property' => 'margin',
							'when' => array(
								array('enable_margin', '=', '1' ),
								array('alignment', '=', 'none' ),
								array('margin', '!=', '0px 0px 10px 0px' ),
							),
							'relation' => 'and',
						),
						'.tatsu-{UUID}.tatsu-normal-button' => array(
							'property' => 'margin',
							'when' => array(
								array('enable_margin', '=', '1' ),
								array('alignment', '!=', 'none' ),
								array('margin', '!=', '0px 0px 40px 0px' ),
							),
							'relation' => 'and',
						)
					),
				),
			    array (
				   'att_name' => 'box_shadow',
				   'type' => 'input_box_shadow',
				   'label' => __( 'Shadow', 'tatsu' ),
				   'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				   'tooltip' => '',
				   'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button' => array(
							'property' => 'box-shadow',
							'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
				),
				array (
					'att_name' => 'hover_box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow on hover', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button:hover' => array(
							'property' => 'box-shadow',
							'when' => array('hover_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
	            ),
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'button_text' => 'Click Here',
						'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'button_style' => 'circular',	        			
	        		),
	        	)
	        ),
		);
	tatsu_register_module( 'tatsu_button', $controls );
	tatsu_register_header_module( 'tatsu_button', $controls, 'tatsu_header_button' );
}

add_action( 'tatsu_register_header_modules', 'tatsu_register_gradient_button', 9 );
add_action( 'tatsu_register_modules', 'tatsu_register_gradient_button', 9 );
function tatsu_register_gradient_button() {

		$controls = array (
			'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#button',
	        'title' => __( 'Gradient Button', 'tatsu' ),
			'is_js_dependant' => false,
			'child_module' => '',
			'inline' => true,
			'type' => 'single',
			'is_built_in' => true,
			'group_atts' => array(
				'button_text',
				'url',
				'new_tab',
				array (
					'type' => 'accordion',
					'active' => array(0,1),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Shape and Size', 'tatsu' ),
							'group' => array (
								'type',
								'alignment',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Colors', 'tatsu' ),
							'group' => array (
								'bg_color',
								'hover_bg_color',
								'color',
								'hover_color',
								'border_width',
								'border_color',
								'hover_border_color'
							)
						),	
						array (
							'type' => 'panel',
							'title' => __( 'Advanced', 'tatsu' ),
							'group' => array (
								'lightbox',
								'image',
								'video_url',
								'hover_effect',
								'enable_margin',
								'margin'
							)
						),			
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Light Scheme Colors', 'tatsu' ),
							'group' => array (
								'light_color',
								'light_bg_color',
								'light_border_color',
								'light_hover_color',
								'light_hover_bg_color',
								'light_hover_border_color'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Dark Scheme Colors', 'tatsu' ),
							'group' => array (
								'dark_color',
								'dark_bg_color',
								'dark_border_color',
								'dark_hover_color',
								'dark_hover_bg_color',
								'dark_hover_border_color'
							)
						),
						'hide_in'
					) 
				)
			),
			'atts' => array (
				array (
					'att_name' => 'button_text',
					'type' => 'text',
					'label' => __( 'Button Text', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'url',
					'type' => 'text',
					'label' => __( 'URL to be linked', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'new_tab',
 					'type' => 'switch',
 					'label' => __( 'Open in a new tab', 'tatsu' ),
 					'default' => '0',
 					'tooltip' => '',
 					'visible' => array( 'url', '!=', '' ),
 				),
 				array (
 					'att_name' => 'type',
 					'type' => 'button_group',
 					'label' => __( 'Button Size', 'tatsu' ),
 					'options' => array (
 						'small' => 'Small',
 						'medium' => 'Medium',
						 'large' => 'Large',
						 'x-large' => 'X Large',
						 'block' => 'Block',
						 //'custom' => 'Custom',
 					),
 					'default' => 'medium',
 					'tooltip' => ''
				),
			// 	array(
			// 	   'att_name' => 'custom_button_height',
			// 	   'type' => 'slider',
			// 	   'label' => __('Button Height', 'tatsu'),
			// 	   'options' => array(
			// 		   'min' => 5,
			// 		   'max' => 250,
			// 		   'step' => 1,
			// 		   'unit' => 'px',
			// 		   'add_unit_to_value' => true
			// 	   ),
			// 	   'visible' => array( 'type', '=', 'custom' ),
			// 	   'default' => '25',
			// 	   'css' => true,
			// 	   'responsive' => true,
			// 	   'selectors' => array(
			// 		   '.tatsu-{UUID} .tatsu-custom-button-size' => array(
			// 			   'property' => 'padding-top',
			// 			   'when' => array('type', '=', 'custom'),
			// 		   ),
			// 		   '.tatsu-{UUID} .tatsu-button' => array(
			// 			   'property' => 'padding-bottom',
			// 			   'when' => array('type', '=', 'custom'),
			// 		   ),
			// 	   ),
			//    ),
			//    array(
			// 	   'att_name' => 'custom_button_width',
			// 	   'type' => 'slider',
			// 	   'label' => __('Button Width', 'tatsu'),
			// 	   'options' => array(
			// 		   'min' => 5,
			// 		   'max' => 500,
			// 		   'step' => 1,
			// 		   'unit' => 'px',
			// 		   'add_unit_to_value' => true
			// 	   ),
			// 	   'visible' => array( 'type', '=', 'custom' ),
			// 	   'default' => '50',
			// 	   'css' => true,
			// 	   'responsive' => true,
			// 	   'selectors' => array(
			// 		   '.tatsu-{UUID} .tatsu-custom-button-size' => array(
			// 			   'property' => 'padding-right',
			// 			   'when' => array('type', '=', 'custom'),
			// 		   ),
			// 		   '.tatsu-{UUID} .tatsu-button' => array(
			// 			   'property' => 'padding-left',
			// 			   'when' => array('type', '=', 'custom'),
			// 		   ),
			// 	   ),
			//    ),
			//    array(
			// 	   'att_name' => 'custom_text_size',
			// 	   'type' => 'slider',
			// 	   'label' => __('Button Text size', 'tatsu'),
			// 	   'options' => array(
			// 		   'min' => 5,
			// 		   'max' => 50,
			// 		   'step' => 1,
			// 		   'unit' => 'px',
			// 		   'add_unit_to_value' => true
			// 	   ),
			// 	   'visible' => array( 'type', '=', 'custom' ),
			// 	   'default' => '18',
			// 	   'css' => true,
			// 	   'responsive' => true,
			// 	   'selectors' => array(
			// 		   '.tatsu-{UUID} .tatsu-button-text' => array(
			// 			   'property' => 'font-size',
			// 			   'when' => array('type', '=', 'custom'),
			// 		   ),
			// 	   ),
			//    ),
			//    array(
			// 	   'att_name' => 'custom_text_letter_spacing',
			// 	   'type' => 'slider',
			// 	   'label' => __('Button Letter Spacing', 'tatsu'),
			// 	   'options' => array(
			// 		   'min' => 0,
			// 		   'max' => 25,
			// 		   'step' => 1,
			// 		   'unit' => 'px',
			// 		   'add_unit_to_value' => true
			// 	   ),
			// 	   'visible' => array( 'type', '=', 'custom' ),
			// 	   'default' => '0',
			// 	   'css' => true,
			// 	   'responsive' => true,
			// 	   'selectors' => array(
			// 		   '.tatsu-{UUID} .tatsu-button-text' => array(
			// 			   'property' => 'letter-spacing',
			// 			   'when' => array('type', '=', 'custom'),
			// 		   ),
			// 	   ),
			//    ),
				array (
 					'att_name' => 'alignment',
 					'type' => 'button_group',
 					'label' => __( 'Button Alignment', 'tatsu' ),
 					'options' => array (
 						'none' => 'None',
 						'left' => array(
 							'icon' => '',
 							'title' => 'Left',
 						),
 						'center' => array(
 							'icon' => '',
 							'title' => 'Center',
 						),
 						'right' => array(
 							'icon' => '',
 							'title' => 'Right',
 						),
 					),
 					'default' => 'none',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'bg_color',
 					'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
 					'label' => __( 'Background Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button:after' => array(
							'property' => 'background-color',
						),
					), 
 				),
 				array (
 					'att_name' => 'hover_bg_color',
 					'type' => 'color',
					'options' => array (
							'gradient' => true
					),
 					'label' => __( 'Hover Background Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button:before' => array(
							'property' => 'background-color',
						),
					),					 
 				),
 				array (
 					'att_name' => 'color',
					// 'type' => 'color',
					'type' => 'color',
					'options' => array (
							'gradient' => true
					),
 					'label' => __( 'Text Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button-text span' => array(
							'property' => 'color',
						),
					),
 				),
  				array (
 					'att_name' => 'hover_color',
 					'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
 					'label' => __( 'Hover Text Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button-text:after' => array(
							'property' => 'color',
						),
					), 
 				),
 				array (
 					'att_name' => 'border_width',
 					'type' => 'number',
 					'label' => __( 'Border Size', 'tatsu' ),
 					'options' => array(
 						'unit' => 'px',
 						'add_unit_to_value' => false,
 					),
 					'default' => '0',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button-wrap' => array(
							'property' => 'padding',
							'when' => array( 'border_width', '!=', '0px' ),
							'append' => 'px',
						),
						'.tatsu-{UUID} .tatsu-button-wrap:before, .tatsu-{UUID} .tatsu-button-wrap:after' => array(
							'property' => 'border-width',
							'when' => array( 'border_width', '!=', '0px' ),
							'append' => 'px',
						),
					), 
 				),
 				array (
 					'att_name' => 'border_color',
 					'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
 					'label' => __( 'Border Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button-wrap:after' => array(
							'property' => 'border-color',
							'when' => array( 'border_width', '!=', '0px' ),
						),
					), 
 				),
 				array ( 
 					'att_name' => 'hover_border_color',
 					'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
 					'label' => __( 'Hover Border Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-button-wrap:before' => array(
							'property' => 'border-color',
							'when' => array( 'border_width', '!=', '0px' ),
						),
					), 
 				),			
 				array (
 					'att_name' => 'lightbox',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Lightbox Image / Video', 'tatsu' ),
 					'tooltip' => ''
 				),  				
 				array (
 					'att_name' => 'image',
 					'type' => 'single_image_picker',
 					'label' => __( 'Background Image', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
 					'visible' => array( 'lightbox', '=', '1' ),
 				),
	        	array (
	        		'att_name' => 'video_url',
	        		'type' => 'text',
	        		'label' => __( 'Youtube / Vimeo Url in lightbox', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'visible' => array( 'lightbox', '=', '1' ),
	        	),
				array (
	        		'att_name' => 'hover_effect',
	        		'type' => 'button_group',
	        		'label' => __( 'Hover Effect', 'tatsu' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'button-transform' => 'Transform',
	        			'button-scale' => 'Scale'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
				),
				// array (
				// 	'att_name' => 'hover_button_shadow',
				// 	'type' => 'input_box_shadow',
				// 	'label' => __( 'Icon Hover Shadow Values', 'tatsu' ),
				// 	'default' => '0 0 15px 0 rgba(198,202,202,0.8)',
				// 	'tooltip' => '',
				// 	'visible' => array( 'hover_effect', '!=', 'none' ),
				// 	'css' => true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID}.tatsu-button-wrap .tatsu-button:hover' => array(
				// 			'property' => 'box-shadow',
				// 			'when' => array(
				// 				array('hover_effect', '!=', 'none'),
				// 				array('hover_button_shadow', '!=', '0 0 15px 0 rgba(198,202,202,0.8)'),
				// 			),
				// 			'relation' => 'and',
				// 		),
				// 	),
	            // ),					
 				array (
 					'att_name' => 'animate',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Css Animations', 'tatsu' ),
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'animation_type',
 					'type' => 'select',
 					'options' => tatsu_css_animations(),
 					'label' => __( 'Animation Type', 'tatsu' ),
 					'default' => 'fadeIn',
 					'tooltip' => '',
 					'visible' => array( 'animate', '=', '1' ),
 				),
				 array(
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'tatsu' ),
	        		'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
				array (
					'att_name' => 'enable_margin',
					'type' => 'switch',
					'label' => __( 'Custom Margin', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 10px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'visible' => array( 'enable_margin', '=', '1' ),
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-gradient-button' => array(
							'property' => 'margin',
							'when' => array(
								array( 'enable_margin', '=', '1' ),
								array( 'alignment', '=', 'none' ),
								array( 'margin', '!=', '0px 0px 10px 0px' ),
							),
							'relation' => 'and'
						),
						'.tatsu-{UUID}.tatsu-button-container' => array(
							'property' => 'margin',
							'when' => array(
								array( 'enable_margin', '=', '1' ),
								array( 'alignment', '!=', 'none' ),
								array( 'margin', '!=', '0px 0px 40px 0px' ),
							),
							'relation' => 'and'
						),
					),
				),     	 								
 				
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'button_text' => 'Click Here',
						'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) )
	        		),
	        	)
	        ),
		);
	tatsu_register_module( 'tatsu_gradient_button', $controls );
	tatsu_register_header_module( 'tatsu_gradient_button', $controls, 'tatsu_gradient_header_button' );

}

add_action( 'tatsu_register_modules', 'tatsu_register_button_group', 9 );
function tatsu_register_button_group() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#button_group',
	        'title' => __( 'Button Group', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'tatsu_button',
	        'allowed_sub_modules' => array( 'tatsu_button' ),
	        'type' => 'multi',
	        'initial_children' => 2,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array (
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 20px 0px',
					'tooltip' => '',
					'css' => true,
					//'responsive' => true,    in js attsfromdisplay device is empty
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-button-group' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', '0px 0px 20px 0px'),
						),
					),
				),
	        ),	        
	    );
	tatsu_register_module( 'tatsu_button_group', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_icon_module', 9 );
add_action( 'tatsu_register_header_modules', 'tatsu_register_icon_module', 9 );
function tatsu_register_icon_module() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#icon',
	        'title' => __( 'Icon', 'tatsu' ),
	        'is_js_dependant' => false,
	        'inline' => true,
	        'type' => 'single',
			'is_built_in' => true,
			'group_atts' => array(
				'name',
				'href',
				'new_tab',
				array (
					'type' => 'accordion' ,
					'active' => array(0, 1),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Shape and Size', 'tatsu' ),
							'group' => array (
								'size',
								'style',
								// 'custom_bg_size',
								// 'custom_icon_size',
								'alignment',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Colors', 'tatsu' ),
							'group' => array (
								'bg_color',
								'hover_bg_color',
								'color',
								'hover_color',
								'border_width',
								'border_color',
								'hover_border_color'
							)
						),	
						array (
							'type' => 'panel',
							'title' => __( 'Advanced', 'tatsu' ),
							'group' => array (
								'lightbox',
								'image',
								'video_url',
								'hover_effect',
								'box_shadow',
								'hover_box_shadow',
								'margin',
							)
						),		
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'ripple_effect',
								'ripple_color',
								'animate',
								'animation_type',
								'animation_delay'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Light Scheme Colors', 'tatsu' ),
							'group' => array (
								'light_color',
								'light_bg_color',
								'light_border_color',
								'light_hover_color',
								'light_hover_bg_color',
								'light_hover_border_color'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Dark Scheme Colors', 'tatsu' ),
							'group' => array (
								'dark_color',
								'dark_bg_color',
								'dark_border_color',
								'dark_hover_color',
								'dark_hover_bg_color',
								'dark_hover_border_color'
							)
						),
						'hide_in'
					) 
				)
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'name',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'tatsu' ),
	        		'options' => array (
						'tiny' => 'XS',
						'small' => 'S',
						'medium' => 'M',
						'large' => 'L',
						'xlarge' =>'XL',
						// 'custom' => 'Custom',
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'tatsu' ),
	        		'options' => array (
						'circle' => 'Circle',
						'plain' => 'Plain',
						'square' => 'Square',
						'diamond' => 'Diamond'
					),
	        		'default' => 'circle',
	        		'tooltip' => ''
	        	),
				// array(
				// 	'att_name' => 'custom_bg_size',
				// 	'type' => 'slider',
				// 	'label' => __('Background Size', 'tatsu'),
				// 	'options' => array(
				// 		'min' => 20,
				// 		'max' => 500,
				// 		'step' => 1,
				// 		'unit' => 'px',
				// 		'add_unit_to_value' => true
				// 	),
				// 	'visible' => array( 'style', '!=', 'plain' ),
				// 	'default' => '200',
				// 	'css' => true,
				// 	'responsive' => true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID} .tatsu-icon' => array(
				// 			'property' => 'height',
				// 			'when' => array(
				// 				array('size', '=', 'custom'),
				// 				array( 'style', '!=', 'plain' ),
				// 			),
				// 			'relation' => 'and'
				// 		),
				// 		'.tatsu-{UUID} .tatsu-custom-icon' => array(
				// 			'property' => 'width',
				// 			'when' => array(
				// 				array('size', '=', 'custom'),
				// 				array( 'style', '!=', 'plain' ),
				// 			),
				// 			'relation' => 'and'
				// 		),
				// 	),
				// ),
				// array(
				// 	'att_name' => 'custom_icon_size',
				// 	'type' => 'slider',
				// 	'label' => __('Icon Size', 'tatsu'),
				// 	'options' => array(
				// 		'min' => 5,
				// 		'max' => 500,
				// 		'step' => 1,
				// 		'unit' => 'px',
				// 		'add_unit_to_value' => true
				// 	),
				// 	'visible' => array( 'size', '=', 'custom' ),
				// 	'default' => '100',
				// 	'css' => true,
				// 	'responsive' => true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID} .tatsu-icon' => array(
				// 			'property' => 'font-size',
				// 			'when' => array('size', '=', 'custom'),
				// 		),
				// 		'.tatsu-{UUID} .tatsu-custom-icon-class' => array(
				// 			'property' => 'height',
				// 			'when' => array(
				// 				array('size', '=', 'custom'),
				// 				array( 'style', '=', 'plain' ),
				// 			),
				// 			'relation' => 'and'
				// 		),
				// 		'.tatsu-{UUID} .tatsu-custom-icon' => array(
				// 			'property' => 'width',
				// 			'when' => array(
				// 				array('size', '=', 'custom'),
				// 				array( 'style', '=', 'plain' ),
				// 			),
				// 			'relation' => 'and'
				// 		),
				// 	),
				// ),
	        	array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'visible' => array( 'style', '!=', 'plain' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon' => array(
							'property' => 'background-color',
							'when' => array( 'style', '!=', 'plain' ),
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Hover Background Color', 'tatsu' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'visible' => array( 'style', '!=', 'plain' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon:hover' => array(
							'property' => 'background-color',
							'when' => array( 'style', '!=', 'plain' ),
						),
					),
	            ),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'Icon Color', 'tatsu' ),
		            'default' => '', 
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_color',
		            'type' => 'color',
		            'label' => __( 'Hover Icon Color', 'tatsu' ),
		            'default' => '', //alt_bg_text_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon:hover' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'border_width',
	        		'type' => 'number',
	        		'label' => __( 'Border Width', 'tatsu' ),
	        		'options' => array (
	        			'unit' => 'px',
	        		),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon' => array(
							'property' => 'border-width',
							'when' => array( 'style', '!=', 'plain' ),
							'append' => 'px'
						),
					),
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon' => array(
							'property' => 'border-color',
							'when' => array(
								array( 'border_width', '!=', '0' ),
								array( 'style', '!=', 'plain' ),
							),
							'relation' => 'and',
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_border_color',
		            'type' => 'color',
		            'label' => __( 'Hover Border Color', 'tatsu' ),
		            'default' => '', //color_scheme
		            'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon:hover' => array(
							'property' => 'border-color',
							'when' => array(
								array( 'border_width', '!=', '0' ),
								array( 'style', '!=', 'plain' ),
							),
							'relation' => 'and',
						),
					),					
	            ),
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
				),
				array (
					'att_name'		=> 'ripple_effect',
					'type'			=> 'switch',
					'label'			=> __( 'Enable Ripple Effect', 'tatsu' ),
					'default'		=> '0',
					'tooltip'		=> '',
					'visible'		=> array( 'style', '=', 'circle' ),
				),
				array (
		            'att_name' => 'ripple_color',
		            'type' => 'color',
		            'label' => __( 'Ripple Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array(
						'condition'	=> array(
							array( 'style', '=', 'circle' ),
							array( 'ripple_effect', '=', '1' )
						),
						'relation'	=> 'and',
					),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-ripple::before, .tatsu-{UUID} .tatsu-icon-ripple::after' => array(
							'property' => 'border-color',
							'when' => array(
								array( 'style', '=', 'circle' ),
								array( 'ripple_effect', '=', '1' )
							),
							'relation'	=> 'and'
						),
					),
	            ),
	        	array (
	        		'att_name' => 'href',
	        		'type' => 'text',
	        		'label' => __( 'URL to be linked to the Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'new_tab',
	              	'type' => 'switch',
	              	'label' => __( 'Open as new tab', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	              	'visible' => array( 'href', '!=', '' ),
	            ),
 				array (
 					'att_name' => 'lightbox',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Lightbox Image / Video', 'tatsu' ),
 					'tooltip' => ''
 				), 	            
	        	array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Select Lightbox image / video', 'tatsu' ),
	              	'tooltip' => '',
	              	'visible' => array( 'lightbox', '=', '1' ),
	            ),
	        	array (
	        		'att_name' => 'video_url',
	        		'type' => 'text',
	        		'label' => __( 'Youtube / Vimeo Url in lightbox', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'visible' => array( 'lightbox', '=', '1' ),
	        	),
	            array (
	        		'att_name' => 'hover_effect',
	        		'type' => 'button_group',
	        		'label' => __( 'Hover Effect', 'tatsu' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'icon-transform' => 'Transform',
	        			'icon-scale' => 'Scale'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
				),            	            
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
				),
				array(
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'tatsu' ),
	        		'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
	        	),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 20px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-normal-icon' => array(
							'property' => 'margin',
							// 'when' => array('margin', '!=', array( 'd' => '0px 0px 20px' ) ),
							'when' => array('margin', '!=',  '0px 0px 20px 0px' ),
						),
					),
				),
				array (
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'visible' => array( 'style', '!=', 'plain' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon' => array(
							'property' => 'box-shadow',
							'when' => array(
								array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
								array( 'style', '!=', 'plain' ),
							),
							'relation' => 'and',
						),
					),
				),
				array (
					'att_name' => 'hover_box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow on hover', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'visible' => array( 'style', '!=', 'plain' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon:hover' => array(
							'property' => 'box-shadow',
							'when' => array(
								array('hover_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
								array( 'style', '!=', 'plain' ),
							),
							'relation' => 'and',
						),
					),
	            ),	

	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'name' => 'icon-icon_desktop',
	        			'size' => 'small',
	        			'style' => 'plain',
	        			'color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_icon', $controls );
	tatsu_register_header_module( 'tatsu_icon', $controls, 'tatsu_header_icon' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_gradient_icon_module', 9 );
function tatsu_register_gradient_icon_module() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#icon',
	        'title' => __( 'Gradient Icon', 'tatsu' ),
	        'is_js_dependant' => false,
	        'inline' => true,
	        'type' => 'single',
			'is_built_in' => true,
			'group_atts' => array(
				'name',
				'href',
				'new_tab',
				array (
					'type' => 'accordion' ,
					'active' => array( 0, 1 ),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Shape and Size', 'tatsu' ),
							'group' => array (
								'size',
								'style',
								// 'custom_bg_size',
								// 'custom_icon_size',
								'alignment',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Colors', 'tatsu' ),
							'group' => array (
								'bg_color',
								'color',
								'hover_bg_color',
								'hover_color',
								'border_width',
								'border_color',
								'hover_border_color'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Advanced', 'tatsu' ),
							'group' => array (
								'lightbox',
								'image',
								'video_url',
								'hover_effect',
								'box_shadow',
								'hover_box_shadow',
								'margin',
							)
						),				
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay'
							)
						),
					) 
				)
			),
	        'atts' => array (
	            array (
	        		'att_name' => 'name',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'tatsu' ),
	        		'options' => array (
						'tiny' => 'Tiny',
						'small' => 'Small',
						'medium' => 'Med',
						'large' => 'Large',
						'xlarge' =>'XL',
						'custom' => 'Custom',
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
				array(
					'att_name' => 'custom_bg_size',
					'type' => 'slider',
					'label' => __('Icon Wrapper Size', 'tatsu'),
					'options' => array(
						'min' => 20,
						'max' => 500,
						'step' => 1,
						'unit' => 'px',
						'add_unit_to_value' => true
					),
					'visible' => array( 'style', '!=', 'plain' ),
					'default' => '200',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-bg' => array(
							'property' => 'height',
							'when' => array(
								array('size', '=', 'custom'),
								array( 'style', '!=', 'plain' ),
							),
							'relation' => 'and',
						),
						'.tatsu-{UUID} .tatsu-custom-icon-bg' => array(
							'property' => 'width',
							'when' => array(
								array('size', '=', 'custom'),
								array( 'style', '!=', 'plain' ),
							),
							'relation' => 'and',
						),
					),
				),
				array(
					'att_name' => 'custom_icon_size',
					'type' => 'slider',
					'label' => __('Icon Size', 'tatsu'),
					'options' => array(
						'min' => 5,
						'max' => 500,
						'step' => 1,
						'unit' => 'px',
						'add_unit_to_value' => true
					),
					'visible' => array( 'size', '=', 'custom' ),
					'default' => '100',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon.hover' => array(
							'property' => 'font-size',
							'when' => array('size', '=', 'custom'),
						),
						'.tatsu-{UUID} .tatsu-icon.default' => array(
							'property' => 'font-size',
							'when' => array('size', '=', 'custom'),
						),
						'.tatsu-{UUID} .tatsu-icon-bg' => array(
							'property' => 'height',
							'when' => array(
								array('size', '=', 'custom'),
								array( 'style', '=', 'plain' ),
							),
							'relation' => 'and',
						),
						'.tatsu-{UUID} .tatsu-custom-icon-bg' => array(
							'property' => 'width',
							'when' => array(
								array('size', '=', 'custom'),
								array( 'style', '=', 'plain' ),
							),
							'relation' => 'and',
						),
						
					),
				),
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'tatsu' ),
	        		'options' => array (
						'plain' => 'Plain',
						'square' => 'Square',
					),
	        		'default' => 'square',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-bg:after' => array(
							'property' => 'background-color',
							'when' => array( 'style', '!=', 'plain' ),
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Hover Background Color', 'tatsu' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-bg:before' => array(
							'property' => 'background-color',
							'when' => array( 'style', '!=', 'plain' ),
						),
					),
	            ),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Icon Color', 'tatsu' ),
		            'default' => '', 
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon.default' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Hover Icon Color', 'tatsu' ),
		            'default' => '', //alt_bg_text_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon.hover' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'border_width',
	        		'type' => 'number',
	        		'label' => __( 'Border Width', 'tatsu' ),
	        		'options' => array (
	        			'unit' => 'px',
	        		),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-bg:after, .tatsu-{UUID} .tatsu-icon-bg:before' => array(
							'property' => 'border-width',
							'when' => array( 'style', '!=', 'plain' ),
							'append' => 'px',
						),
						// '.tatsu-{UUID} .tatsu-icon-wrap:before, .tatsu-{UUID} .tatsu-icon-wrap:after' => array(
						// 	'property' => array( 'top', 'right', 'bottom', 'left' ), 
						// 	'prepend' => '-',
						// 	'append' => 'px',
						// ),
					),
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-bg:after' => array(
							'property' => 'border-color',
							'when' => array( 'border_width', '!=', '0px' ),
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_border_color',
		            'type' => 'color',
					'options' => array (
							'gradient' => true
					),
		            'label' => __( 'Hover Border Color', 'tatsu' ),
		            'default' => '', //color_scheme
		            'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-bg:before' => array(
							'property' => 'border-color',
							'when' => array( 'border_width', '!=', '0px' ),
						),
					),					
	            ),
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'href',
	        		'type' => 'text',
	        		'label' => __( 'URL to be linked to the Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'new_tab',
	              	'type' => 'switch',
	              	'label' => __( 'Open as new tab', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	              	'visible' => array( 'href', '!=', '' ),
	            ),
 				array (
 					'att_name' => 'lightbox',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Lightbox Image / Video', 'tatsu' ),
 					'tooltip' => ''
 				), 	            
	        	array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Select Lightbox image / video', 'tatsu' ),
	              	'tooltip' => '',
	              	'visible' => array( 'lightbox', '=', '1' ),
	            ),
	        	array (
	        		'att_name' => 'video_url',
	        		'type' => 'text',
	        		'label' => __( 'Youtube / Vimeo Url in lightbox', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'visible' => array( 'lightbox', '=', '1' ),
	        	),
	            array (
	        		'att_name' => 'hover_effect',
	        		'type' => 'button_group',
	        		'label' => __( 'Hover Effect', 'tatsu' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'icon-transform' => 'Transform',
	        			'icon-scale' => 'Scale'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
				),		            	            
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
				array(
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'tatsu' ),
	        		'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
	        	),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 20px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-gradient-icon' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 20px 0px' ) ),
						),
					),
				),
				array (
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'visible' => array( 'style', '!=', 'plain' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-bg' => array(
							'property' => 'box-shadow',
							'when' => array(
								array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
								array( 'style', '!=', 'plain' ),
							),
							'relation' => 'and',
						),
					),
				),
				array (
					'att_name' => 'hover_box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow on hover', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'visible' => array( 'style', '!=', 'plain' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-icon-bg:hover' => array(
							'property' => 'box-shadow',
							'when' => array(
								array('hover_box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
								array( 'style', '!=', 'plain' ),
							),
							'relation' => 'and',
						),
					),
	            ),	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'name' => 'icon-icon_desktop',
	        			'size' => 'medium',
	        			'style' => 'plain',
	        			'color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_gradient_icon', $controls );
}

add_action( 'tatsu_register_header_modules', 'tatsu_register_icon_group', 9 );
add_action( 'tatsu_register_modules', 'tatsu_register_icon_group', 9 );

function tatsu_register_icon_group() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#icon_group',
	        'title' => __( 'Icon Group', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'tatsu_icon',
	        'type' => 'multi',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
					),
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-icon-group' => array(
							'property' => 'text-align',
						),
					),
	        		'default' => 'left',
	        		'tooltip' => ''
	        	),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 20px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-icon-group' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 20px 0px' ) ),
						),
					),
				),
	        ),
	    );
	tatsu_register_module( 'tatsu_icon_group', $controls );
	tatsu_register_header_module( 'tatsu_icon_group', $controls , 'tatsu_icon_group' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_title_icon', 9 );
function tatsu_register_title_icon() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#title_icon',
	        'title' => __( 'Title with Icon', 'tatsu' ),
	        'is_js_dependant' => true,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'tatsu' ),
	        		'options' => array (
						'small' => 'Small',
						'medium' => 'Medium',
						'large' => 'Large',
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array (
						'left' => 'Left',
						'right' => 'Right'
					),
	        		'default' => 'left',
	        		'tooltip' => ''
				),
				// array (
				// 	'att_name' => 'custom_space_enabler',
				// 	'type' => 'switch',
				// 	'label' => __( 'Enable Custom Space', 'tatsu' ),
				// 	'default' => 0,
				// 	'tooltip' => '',
			  	// ),
				// array(
				// 	'att_name' => 'custom_space',   // hav to override some styles to get this
				// 	'type' => 'slider',
				// 	'label' => __('Space Between', 'tatsu'),
				// 	'options' => array(
				// 		'min' => 0,
				// 		'max' => 250,
				// 		'step' => 1,
				// 		'unit' => 'px',
				// 		'add_unit_to_value' => true
				// 	),
				// 	'visible' => array( 'custom_space_enabler', '=', '1' ),
				// 	'default' => '50',
				// 	'css' => true,
				// 	'selectors' => array(
				// 		'.tatsu-{UUID} .tatsu-tc' => array(
				// 			'property' => 'margin-left',
				// 			'when' => array(
				// 				array('alignment', '=', 'left'),
				// 				array('custom_space_enabler', '=', '1'),
				// 			),
				// 			'relation' => 'and',
				// 			//'append' => ' !important',
				// 		),
				// 		'.tatsu-{UUID} .tatsu-tc-custom-space' => array(
				// 			'property' => 'margin-right',
				// 			'when' => array(
				// 				array('alignment', '=', 'right'),
				// 				array('custom_space_enabler', '=', '1'),
				// 			),
				// 			'relation' => 'and',
				// 			//'append' => ' !important',
				// 		),
				// 	),
				// ),
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'tatsu' ),
	        		'options' => array (
						'circled' => 'Circled',
						'plain' => 'Plain'
					),
	        		'default' => 'circled',
	        		'tooltip' => ''
				),
	        	array (
		            'att_name' => 'icon_bg',
		            'type' => 'color',
					'options' => array (
						'gradient' => true
					),
		            'label' => __( 'Background Color of Icon if circled', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'style', '=', 'circled' ),
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-ti-wrap.circled' => array(
							'property' => 'background',
							'when' => array('style', '=', 'circled'),
						),
					),
				),
	        	array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
					'options' => array (
						'gradient' => true
					),
		            'label' => __( 'Icon Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-ti-icon' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Icon Shadow', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'visible'	=> array ( 'style', '=', 'circled' ),
					'css' => true,
				    'selectors' => array(
					    '.tatsu-{UUID} .tatsu-ti-wrap.circled' => array(
							'property' => 'box-shadow',
							'when' => array( 'style', '=', 'circled' ),
						),
					),
				),
	        	array (
		            'att_name' => 'icon_border_color',
		            'type' => 'color',
		            'label' => __( 'Icon Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'style', '=', 'circled' ),
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-ti-wrap.circled' => array(
							'property' => 'border-color',
							'when' => array('style', '=', 'circled'),
						),
					),
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
				array(
	        		'att_name' => 'animation_delay',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '2000',
	        			'step' => '50',
						'unit' => 'ms',
	        		),
					'default' => '0',	        		
	        		'label' => __( 'Animation Delay', 'tatsu' ),
	        		'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
	        	),
				array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 0px 60px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-title-icon' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
						),
					),
				),				
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'icon' => 'icon-icon_desktop',
	        			'icon_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'icon_border_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'size' => 'medium',
	        			'style' => 'plain',
	        			'content' => '<h6>Title Goes Here</h6><p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt.</p>'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_title_icon', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_video', 9 );
function tatsu_register_video() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#video',
	        'title' => __( 'Video', 'tatsu' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => true,
	        'drag_handle' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'source',
	        		'type' => 'select',
	        		'label' => __( 'Choose Video Source', 'tatsu' ),
	        		'options' => array (
						'youtube' => 'Youtube',
						'vimeo' => 'Vimeo',
						'selfhosted' => 'Self Hosted',
					),
	        		'default' => 'youtube',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'url',
	        		'type' => 'text',
	        		'label' => __( 'Enter the video url', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				),
	            array (
					'att_name' => 'placeholder',
					'type' => 'single_image_picker',
					'label' => __( 'Place Holder Image', 'tatsu' ),
					'tooltip' => '',
					'visible' => array( 'source', '=', 'selfhosted' ),
				),
				array (
					'att_name' => 'autoplay',
					'type' => 'switch',
					'label' => __( 'Autoplay', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
			    ),
			    array (
					'att_name' => 'loop_video',
					'type' => 'switch',
					'label' => __( 'Loop', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
	        	),
	        	array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
				array (
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
				    'selectors' => array(
					    '.tatsu-{UUID}.tatsu-video' => array(
							'property' => 'box-shadow',
							'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 60px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-video' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
						),
					),
				),
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'source' => 'youtube',
						'url' => 'https://www.youtube.com/watch?v=8z4FSMLtWoQ' ,
					)
				),
			),
	    );
	tatsu_register_module( 'tatsu_video', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_gmaps', 9 );
function tatsu_register_gmaps() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#gmaps',
	        'title' => __( 'Google Maps', 'tatsu' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'address',
	        		'type' => 'text',
	        		'label' => __( 'Address', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'latitude',
	        		'type' => 'text',
	        		'label' => __( 'Latitude', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'longitude',
	        		'type' => 'text',
	        		'label' => __( 'Longitude', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'tatsu' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '300',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-gmap-wrapper' => array(
							'property' => 'height',
							'append' => 'px'
						)
					),
	        	),
	        	array (
	        		'att_name' => 'zoom',
	        		'type' => 'slider',
	        		'label' => __( 'Zoom Value', 'tatsu' ),
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '25',
	        			'step' => '1',
	        		),
	        		'default' => '14',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'select',
	        		'label' => __( 'Style', 'tatsu' ),
	        		'options' => array (
						'standard' => 'Standard',
						'greyscale' => 'Greyscale', 
						'bluewater' => 'Bluewater', 
						'midnight' => 'Midnight',
						'black' => 'Black',
						'lightdream' => 'Light Dream',
						'wy' => 'Pale Green',
						'blueessence' => 'Blue Essence',
					),
	        		'default' => 'standard',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'marker',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Custom Marker Pin', 'tatsu' ),
	              	'tooltip' => '',
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 60px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-gmap-wrapper' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
						),
					),
				),
	            array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'latitude' => '13.043442',
	        			'longitude' => '80.273681'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_gmaps', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_divider', 9 );
function tatsu_register_divider() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#divider',
	        'title' => __( 'Divider', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'height',
	        		'type' => 'slider',
	        		'label' => __( 'Divider Thickness', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '50',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),
	        		'default' => '',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-divider' => array(
							'property' => 'height',
							'when' => array('height', 'notempty'),
							'append' => 'px',
						),
					),
	        	),
	        	array (
	        		'att_name' => 'width',
	        		'type' => 'number',
	        		'label' => __( 'Divider Width', 'tatsu' ),
	        		'options' => array(
						'unit' => array('%','px'),
						'add_unit_to_value' => false,
	        		),	        		
	        		'default' => '',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-divider' => array(
							'property' => 'width',
							'when' => array('width', 'notempty'),
							'append' => '%',
						),
					),
				),
				array (
					'att_name' => 'alignment',
					'type' => 'button_group',
					'label' => __( 'Alignment', 'tatsu' ),
					'options' => array (
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right',
					),
					'default' => 'left',
					//'visible' => array ( 'width', '<', '100' ),
					'css' => true,
					'selectors' => array (
						'.tatsu-{UUID}.tatsu-divider-wrap' => array(
							'property' => 'text-align'
						)
					)
				),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Divider Color', 'tatsu' ),
		            'default' => '', //sec_border
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-divider' => array(
							'property' => 'background',
						),
					),
	            ),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 20px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-divider-wrap' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 20px 0px' ) ),
						),
					),
				),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'height' => '1',
	        			'width' => '100',
	        			'color' => '#efefef'
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_divider', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_empty_space', 9 );
function tatsu_register_empty_space() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#empty_space',
	        'title' => __( 'Extra Spacing', 'tatsu' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
	        'drag_handle' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'tatsu' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-empty-space' => array(
							'property' => 'height',
							'append' => 'px'
						),
					),
	        	),
	            array (
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'height' => '30'
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_empty_space', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_call_to_action', 9 );
function tatsu_register_call_to_action() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#call_to_action',
	        'title' => __( 'Call to Action', 'tatsu' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID}.tatsu-call-to-action' => array(
							'property' => 'background-color',
						),
					),
					
	            ),
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'button_group',
	        		'label' => __( 'Heading tag to use for Title', 'tatsu' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h5',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Title Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-action-content' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'button_text',
	        		'type' => 'text',
	        		'label' => __( 'Button Text', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				),							
 				array (
	        		'att_name' => 'button_link',
	        		'type' => 'text',
	        		'label' => __( 'URL to be linked to the button', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'new_tab',
	        		'type' => 'switch',
	        		'label' => __( 'Open Link in New Tab', 'tatsu' ),
	        		'default' => 0,
	        		'tooltip' => '',
	        		'visible' => array( 'button_link', '!=', '' ),
	        	),
	        	array (
		            'att_name' => 'button_bg_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Button Background Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-action-button' => array(
							'property' => 'background',
							'when' => array(
								array('button_bg_color', 'notempty'),
								array('button_link', 'notempty')
							),
							'relation' => 'and',
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Button Hover Background Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-action-button:hover' => array(
							'property' => 'background',
							'when' => array(
								array('hover_bg_color', 'notempty'),
								array('button_link', 'notempty')
							),
							'relation' => 'and',
						),
					),
	            ),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Button Text Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-action-button span' => array(
							'property' => 'color',
							'when' => array(
								array('color', 'notempty'),
								array('button_link', 'notempty')
							),
							'relation' => 'and',
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Button Hover Text Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-action-button:hover span' => array(
							'property' => 'color',
							'when' => array(
								array('hover_color', 'notempty'),
								array('button_link', 'notempty')
							),
							'relation' => 'and',
						),
					),
	            ),
	            array (
	        		'att_name' => 'border_width',
	        		'type' => 'number',
	        		'label' => __( 'Button Border Size', 'tatsu' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '1',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-action-button' => array(
							'property' => 'border-width',
							'when' => array(
								array('border_width', 'notempty'),
								array('button_link', 'notempty')
							),
							'relation' => 'and',
							'append' => 'px'
						),
					),
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Button Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-action-button' => array(
							'property' => 'border-color',
							'when' => array(
								array('border_color', 'notempty'),
								array('button_link', 'notempty')
							),
							'relation' => 'and',
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_border_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Button Hover Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-action-button:hover' => array(
							'property' => 'border-color',
							'when' => array(
								array('hover_border_color', 'notempty'),
								array('button_link', 'notempty')
							),
							'relation' => 'and',
						),
					),

	            ),
 				array (
 					'att_name' => 'lightbox',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Lightbox Image / Video', 'tatsu' ),
 					'tooltip' => ''
 				), 
	            array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Select Lightbox image / video', 'tatsu' ),
	              	'tooltip' => '',
	              	'visible' => array( 'lightbox', '=', '1' ),
	            ),
	        	array (
	        		'att_name' => 'video_url',
	        		'type' => 'text',
	        		'label' => __( 'Youtube / Vimeo Url in lightbox', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'visible' => array( 'lightbox', '=', '1' ),
	        	),		            
	            array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
				array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 0px 60px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-call-to-action' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
						),
					),
				),
				array (
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-call-to-action' => array(
							'property' => 'box-shadow',
							'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
	            ),       	 	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ) ,
	        			'title' => 'Have a project ? Call us Now ',
	        			'h_tag' => 'h5',
	        			'title_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ) ,
	        			'button_text' => 'Get In Touch',
	        			'hover_bg_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'hover_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'border_width' => '1',
	        			'border_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'hover_border_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_call_to_action', $controls );
}

add_action( 'tatsu_register_header_modules', 'tatsu_register_text_with_shortcodes', 9 );
add_action( 'tatsu_register_modules', 'tatsu_register_text_with_shortcodes', 9 );
function tatsu_register_text_with_shortcodes() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#text',
	        'title' => __( 'Shortcode Editor', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Shortcode', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Add your Shortcode here',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_text_with_shortcodes', $controls );
	tatsu_register_header_module( 'tatsu_text_with_shortcodes', $controls, 'tatsu_text_with_shortcodes' );

}

add_action( 'tatsu_register_modules', 'tatsu_register_animated_numbers', 9 );
function tatsu_register_animated_numbers() {	
		$controls =  array(
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#animated_numbers',
	        'title' => __( 'Animated Numbers', 'tatsu' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => true,
	        'should_destroy' => true,
	        'atts' => array(
	        	array(
	        		'att_name' => 'number',
	        		'type' => 'text',
	        		'label' => __( 'Number', 'tatsu' ),
	        		'tooltip' => ''
				),
	        	array(
	        		'att_name' => 'caption',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'tatsu' ),
	        		'tooltip' => ''
 	        	),	
				array(
					'att_name' => 'prefix',
					'type' => 'text',
					'label' => __( 'Prefix', 'tatsu' ),
					'tooltip' => ''
				),
				array(
					'att_name' => 'suffix',
					'type' => 'text',
					'label' => __( 'Suffix', 'tatsu' ),
					'tooltip' => ''
				),
	        	array(
	        		'att_name' => 'number_size',
	        		'type' => 'number',
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'label' => __( 'Font Size of Number', 'tatsu' ),
					'tooltip' => '',
					'css' => true,
				 	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-an' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),
	        	),
	        	array(
	        		'att_name' => 'caption_size',
	        		'type' => 'number',
	        		'options' => array(
	        			'unit' => 'px',
	        		),	        		
	        		'label' => __( 'Font Size of Caption', 'tatsu' ),
					'tooltip' => '',
					'css' => true,
				 	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-an-caption' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),
	        	),		 
				array (
					'att_name'	=> 'prefix_size',
					'type' => 'number',
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'label' => __( 'Font Size of Prefix', 'tatsu' ),
					'tooltip' => '',
					'css'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID} .tatsu-an-prefix' => array (
							'property'		=> 'font-size',
							'append'		=> 'px',
						)
					)
				),   
				array (
					'att_name'	=> 'suffix_size',
					'type' => 'number',
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'label' => __( 'Font Size of Suffix', 'tatsu' ),
					'tooltip' => '',
					'css'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID} .tatsu-an-suffix' => array (
							'property'		=> 'font-size',
							'append'		=> 'px',
						)
					)
				),
				array(
					'att_name' => 'number_color',
					'type' => 'color',
					'options' => array (
							'gradient' => true
					),
					'label' => __( 'Number Color', 'tatsu' ),
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-an' => array(
							'property' => 'color',
						),
					),
	            ),
	             array(
					'att_name' => 'caption_color',
					'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
					'label' => __( 'Caption Color', 'tatsu' ),
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-an-caption' => array(
							'property' => 'color',
						),
					),
				),   
				array(
					'att_name' => 'prefix_color',
					'type' => 'color',
					'options' => array (
						'gradient' => true
					),
					'label' => __( 'Prefix Color', 'tatsu' ),
					'tooltip' => '',
					'css'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID} .tatsu-an-prefix' => array (
							'property'		=> 'color',
						),
					),
				),
				array(
					'att_name' => 'suffix_color',
					'type' => 'color',
					'options' => array (
							'gradient' => true
					),
					'label' => __( 'Suffix Color', 'tatsu' ),
					'tooltip' => '',
					'css'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID} .tatsu-an-suffix' => array (
							'property'		=> 'color',
						),
					),
	            ),	
	        	array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',	        			
	        			'right' => 'Right',
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 60px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-an-wrap' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
						),
					),
				),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'number' => '27',
						'caption' => 'Demos',
						'number_size' => '45',
						'caption_size' => '13',
						'prefix_size' => '15',
						'suffix_size' => '15',
						'number_color' => '#141414',
						'caption_color' => '#141414',
	        		),
	        	)
	        ),
		);
	tatsu_register_module( 'tatsu_animated_numbers', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_testimonial', 9 );
function tatsu_register_testimonial() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#bubble_testimonial',
	        'title' => __( 'Bubble Testimonial', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'description',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'content_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Testimonial Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .icon-quote, .tatsu-{UUID} .tatsu_testimonial_description' => array(
							'property' => 'color',
							'when' => array('content_color', 'notempty'),
						),
					),
	            ),
	            array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu_testimonial_inner_wrap' => array(
							'property' => 'border-color',
							'when' => array('bg_color', 'notempty'),
						),
						// '.tatsu-{UUID} .tatsu_testimonial_inner_wrap::after' => array(
						// 	'property' => array('border-top-color', 'border-left-color'),
						// 	'when' => array('bg_color', 'notempty'),
						// ),
						'.tatsu-{UUID} .tatsu_testimonial_content' => array(
							'property' => 'background-color',
							'when' => array('bg_color', 'notempty'),
						),
					),
	            ), 
	            array (
	              	'att_name' => 'author_image',
	              	'type' => 'single_image_picker',
	              	'options' => array(
	              		'size' => 'thumbnail',
	              	),					  
	              	'label' => __( 'Testimonial Author Image', 'tatsu' ),
	              	'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'author',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Author', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'author_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Testimonial Author Text Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu_testimonial_author' => array(
							'property' => 'color',
							'when' => array('author_color', 'notempty'),
						),
					),
	            ),
	            array (
	        		'att_name' => 'author_role',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Author Role', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'author_role_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Testimonial Author Role Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu_testimonial_role' => array(
							'property' => 'color',
							'when' => array('author_role_color', 'notempty'),
						),
					),
	            ),
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'left',
	        		'tooltip' => ''
	        	),
				array (
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Shadow', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => '',
					'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu_testimonial_wrap' => array(
							'property' => 'box-shadow',
							'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'description' => 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt.',
	        			'author' => 'Swami',
	        			'author_role' => 'Designer',
	        			'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'content_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_testimonial', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_notifications', 9 );
function tatsu_register_notifications() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#notifications',
	        'title' => __( 'Notifications', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
					'options' => array (
							'gradient' => true
					),
		            'label' => __( 'Background Color of Notification box', 'tatsu' ),
		            'default' => '', //sec_bg
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID}.tatsu-notification' => array(
							'property' => 'background-color',
							'when' => array('bg_color', 'notempty'),
						),
					)
				),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Notification Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				),
				 array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 20px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-notification' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 20px 0px' ) ),
						),
					),
				), 
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __('Animation Type','tatsu'),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => '<span style="color: #fff">This is a Cool Notice</span>',
	        			'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_notifications', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_lists', 9 );
function tatsu_register_lists() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#lists',
	        'title' => __( 'Lists', 'tatsu' ),
	        'is_js_dependant' => true,
	        'child_module' => 'tatsu_list',
	        'initial_children' => 5,
	        'type' => 'multi',
	        'is_built_in' => true,
	        'atts' => array (
				array (
					'att_name'		=> 'margin',
					'label'			=> __( 'Margin', 'tatsu' ),
					'type'			=> 'input_group',
					'default'		=> '0 0 60px 0',
					'css'			=> true,
					'responsive'	=> true,
					'selectors'		=> array (
						'.tatsu-{UUID}.tatsu-list'	=> array (
							'property'	=> 'margin'
						)
					)	
				),
				array (
					'att_name'		=> 'style',
					'label'			=> __( 'Lists Type', 'tatsu' ),
					'type'			=> 'button_group',
					'options'		=>  array (
						'number'	=> 'Number',
						'icon'		=> 'Icon'
					),
					'default'		=> 'icon',
					'tooltip'		=> ''
				),
				array (
					'att_name' => 'circled',
					'type' => 'switch',
					'label' => __( 'Circle the Icon/Number', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
				),
				array (
					'att_name' => 'icon_bg',
					'type' => 'color',
					'options' => array (
						'gradient' => true
					),
					'label' => __( 'Background Color if circled', 'tatsu' ),
					'default' => '', //color_scheme
					'tooltip' => '',
					'visible' => array( 'circled', '=', '1' ),
					'css'	  => true,
					'selectors'	=> array (
						'.tatsu-{UUID} .tatsu-list-content::before, .tatsu-{UUID} .tatsu-list-icon-wrap' => array(
							'property'		=> 'background',
							'when'			=> array( 'circled', '=', '1' ),
						)
					)
				),
				array (
					'att_name' => 'icon_color',
					'type' => 'color',
					'options' => array (
						'gradient' => true
					),
					'label' => __( 'Icon/Number Color','tatsu' ),
					'default' => 'rgba(34,147,215,1)',
					'tooltip' => '',
					'css'	  => true,
					'selectors'	=> array (
						'.tatsu-{UUID} .tatsu-list-content::before, .tatsu-{UUID} .tatsu-icon' => array (
							'property'	=> 'color'
						)
					)
				),
				array (
					'att_name'		=> 'timeline',
					'label'			=> __( 'Enable Timeline', 'tatsu' ),
					'type'			=> 'switch',
					'default'		=> '0',
					'visible'		=> array (
						'condition'	=> array (
							array ( 'circled', '=', '1' ),
							array ( 'icon_bg', '!=', '' )
						),
						'relation'	=> 'and',
					),
				),
				array (
					'att_name'		=> 'timeline_color',
					'label'			=> __( 'Timeline Color', 'tatsu' ),
					'type'			=> 'color',
					'default'		=> '',
					'tooltip'		=> '',
					'visible'		=> array (
						'condition'	=> array (
							array ( 'circled', '=', '1' ),
							array ( 'icon_bg', '!=', '' ),
							array ( 'timeline', '=', '1' ),
						),
						'relation'	=> 'and',
					),
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-lists-timeline-element' => array (
							'property'	=> 'background',
							'when'		=> array (
								array ( 'circled', '=', '1' ),
								array ( 'timeline', '=', '1' ),
								array ( 'timeline', '=', '1' ),
							),
							'relation'	=> 'and' 
						)
					)
				),
				array (
					'att_name'		=> 'list_item_margin',
					'label'			=> __( 'List Item Bottom Margin', 'tatsu' ),
					'type'			=> 'number',
					'options'		=> array (
						'unit'		=> 'px'
					),
					'default'		=> '12',
					'css'			=> true,
					'responsive'	=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-list-content'		=> array (
							'property'		=> 'margin-bottom',
							'append'		=> 'px',
							'when'			=> array ( 'custom_border', 'empty' )
						),
						'.tatsu-{UUID}.tatsu-list-bordered .tatsu-list-content'		=> array (
							'property'		=> 'padding',
							'append'		=> 'px 0',
							'when'			=> array ( 'custom_border', 'notempty' )
						)
					)
				),
				array (	
					'att_name'		=> 'vertical_alignment',
					'label'			=> __( 'Vertical Alignment', 'tatsu' ),
					'type'			=> 'button_group',
					'options'		=> array (
						'none'			=> 'None', 
						'top'			=> 'Top',
						'center'		=> 'Center',
						'bottom'		=> 'Bottom'
					),
					'default'		=> 'none'	
				),
				array (
					'att_name'		=> 'custom_border',
					'label'			=> __( 'Enable Border', 'tatsu' ),
					'type'			=> 'switch',
					'default'		=> '0',
				),
				array (
					'att_name'		=> 'border',
					'label'			=> __( 'Border', 'tatsu' ),
					'type'			=> 'number',
					'default'		=> '0',
					'options'		=> array (
						'unit'		=> 'px'
					),
					'visible'		=> array ( 'custom_border', '=', '1' ),
					'responsive'	=> true,
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-list-content' => array (
							'property'	=> 'border-bottom',
							'append'	=> 'px solid',	
							'when'		=> array ( 'custom_border', '=', '1' )
						)
					)
				),
				array (
					'att_name'		=> 'border_color',
					'label'			=> __( 'Border Color', 'tatsu' ),
					'type'			=> 'color',
					'default'		=> '',
					'visible'		=> array ( 'custom_border', '=', '1' ),
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-list-content' => array (
							'property'	=> 'border-bottom-color',
							'when'		=> array ( 'custom_border', '=', '1' )
						)
					)
				)
			),
	    );
	tatsu_register_module( 'tatsu_lists', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_list', 9 );
function tatsu_register_list() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'List', 'tatsu' ),
	        'is_js_dependant' => false,
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'circled',
	              	'type' => 'switch',
	              	'label' => __( 'Circle the Icon', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
		            'att_name' => 'icon_bg',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Background Color if circled', 'tatsu' ),
		            'default' => '', //color_scheme
		            'tooltip' => '',
					'visible' => array( 'circled', '=', '1' ),
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-list-icon-wrap,.tatsu-{UUID}.tatsu-list-content::before' => array(
							'property' => 'background',
							'when' => array(
								array('circled', '=', '1'),
								array('icon', 'notempty'),
							),
							'relation' => 'and',
						),
					),
	            ),
	            array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Icon/Number Color','tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-icon, .tatsu-{UUID}.tatsu-list-content::before' => array(
							'property' => 'color',
							'when' => array('icon', 'notempty'),
						),
					),
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				 ),	
				 array (
					 'att_name'		=> 'border_color',
					 'type'			=> 'color',
					 'label'		=> __( 'Border Color', 'tatsu' ),
					 'default'		=> '',
					 'tooltip'		=> '',
					 'css'			=> true,
					 'selectors'	=> array (
						 '.tatsu-{UUID}.tatsu-list-content'		=> array (
							 'property'			=> 'border-bottom-color'
						 )
					 )	
				 )
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text.',
	        			'icon' => 'icon-icon_check',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_list', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_dropcap', 9 );
function tatsu_register_dropcap() {

		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#dropcap',
	        'title' => __('Dropcap','tatsu'),
	        'is_js_dependant' => false,
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'letter',
	        		'type' => 'text',
	        		'label' => __('Letter to be Dropcapped', 'tatsu'),
	        		'default' => '',
	        		'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __('Icon to be Dropcapped', 'tatsu'),
	        		'default' => '',
	        		'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'type',
	        		'type' => 'button_group',
	        		'label' => __( 'Dropcap Style', 'tatsu' ),
	        		'options' => array (
						'circle' => 'Circle',
						'rounded' => 'Square',
						'letter' => 'Plain',
					),
	        		'default' => 'circle',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Dropcap Size', '' ),
	        		'options' => array (
						'small' => 'Small',
						'big' => 'Big',
					),
	        		'default' => 'small',
					'tooltip' => ''
	        	),
	        	array (
	              'att_name' => 'color',
	              'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
	              'label' => 'Dropcap Color',
	              'default' => '',	//color_scheme
				  'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu-icon' => array(
							'property' => 'color',
							'when' => array('icon', 'notempty'),
						),
						'.tatsu-{UUID} .tatsu-dropcap span' => array(
							'property' => 'color',
							'when' => array('icon', 'empty'),
						),
					),
	            ),
	        	array (
	              'att_name' => 'bg_color',
	              'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
	              'label' => 'Dropcap Background Color',
	              'default' => '',	//color_scheme
	              'tooltip' => '',
				  'hidden' => array( 'type', '=', 'letter' ),
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID} .tatsu-dropcap' => array(
							'property' => 'background-color',
							'when' => array('type', '!=', 'letter'),
						),
					),
	            ),	            
	        	array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => 'Dropcap Content',
	        		'default' => '',
	        		'tooltip' => 'Add/Edit content'
 	        	),	
	        	array (
	              'att_name' => 'animate',
	              'type' => 'switch',
	              'label' => 'Enable CSS Animation',
	              'default' => 0,
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'animation_type',
	              'type' => 'select',
	              'label' => 'Animation Type',
	              'options' => tatsu_css_animations(),
	              'default' => 'fadeIn',
	              'visible' => array( 'animate', '=', '1' ),
	            ),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 60px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-dropcap-wrap' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
						),
					),
				),
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
						'letter' => 'T',
						'color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'type' => 'letter',
					)
				),
			),
	    );
	tatsu_register_module( 'tatsu_dropcap', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_dropcap2', 9 );
function tatsu_register_dropcap2() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#dropcap',
	        'title' => __('Dropcap - 2','tatsu'),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'letter',
	        		'type' => 'text',
	        		'label' => __('Letter to be Dropcapped', 'tatsu'),
	        		'default' => '',
	        		'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => 'Icon to be Dropcapped',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'slider',
	        		'label' => 'Dropcap Size',
	        		'options' => array (
						'unit' => 'px',
						'min' => '10',
						'max' => '200',
						'step' => '1'
					),
	        		'default' => '60',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-icon' => array(
							'property' => 'font-size',
							'when' => array('icon', 'notempty'),
							'append' => 'px',
						),
						'.tatsu-{UUID} .tatsu-dropcap' => array(
							'property' => 'font-size',
							'when' => array('icon', 'empty'),
							'append' => 'px',
						),
					),
	        	),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => 'Dropcap Color',
		            'default' => '',	//color_scheme
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-icon' => array(
							'property' => 'color',
							'when' => array('icon', 'notempty'),
						),
						'.tatsu-{UUID} .tatsu-dropcap' => array(
							'property' => 'color',
							'when' => array('icon', 'empty'),
						),
					),
	            ),
	            array (
	        		'att_name' => 'dropcap_title',
	        		'type' => 'text',
	        		'label' => __('Dropcap Title','tatsu'),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_font',
	        		'type' => 'select',
	        		'label' => __('Font for Title','tatsu'),
	        		'options' => array (
	        			'body'=> 'Body', 
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h6',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
		            'label' => __( 'Title Color', 'tatsu' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-dropcap-title-color' => array(
							'property' => 'color',
							'when' => array('dropcap_title', 'notempty'),
						),
					),
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 60px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-dropcap-wrap' => array(
							'property' => 'margin',
							'when' => array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
						),
					),
				),
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'letter' => 'T',
						'color' => 'rgba(0,0,0,0.1)',
						'dropcap_title' => 'TATSU IS AWESOME',
						'title_color' => '#000',
						'size' => '100',
					)
				),
			),
	    );
	tatsu_register_module( 'tatsu_dropcap2', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_code', 9);
function tatsu_register_code() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#code',
	        'title' => __( 'Code', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
			'should_autop' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'content',
	        		'type' => 'text_area',
	        		'label' => __( 'Code Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),
				array (
					'att_name' => 'id',
					'type' => 'text',
					'label' => __( 'Id', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
				),
				array (
					'att_name' => 'class',
					'type' => 'text',
					'label' => __( 'Class', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
				),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => '<p>Insert your code here!</p>',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_code', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_image', 9 );
add_action( 'tatsu_register_header_modules', 'tatsu_register_image', 9 );

function tatsu_register_image() {
	$controls = array(
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#image',
        'title' => __( 'Single Image', 'tatsu' ),
        'is_js_dependant' => false,
        'type' => 'single',
        'is_built_in' => true,
        'drag_handle' => false,
				'atts' => array (
			array (
				'att_name' => 'image',
				'type' => 'single_image_picker',
				'post_frame' => true,
				'label' => __( 'Image', 'tatsu' ),
				'tooltip' => '',
				'default' => TATSU_PLUGIN_URL.'/img/image-placeholder.jpg'
			),
			array (
				'att_name' => 'image_varying_size_src',
				'type'	   => 'text',
				'label'	   => __( '', 'tatsu' ),
				'tooltip'  => '',
				'visible'  => array ( '1', '>', '100' ),
				'default'  => '',
			),
        	array (
        		'att_name' => 'alignment',
        		'type' => 'button_group',
        		'label' => __( 'Alignment', 'tatsu' ),
        		'options' => array (
        			'left' => 'Left',
        			'center' => 'Center',	        			
        			'right' => 'Right',
        			'none' => 'None'
        		),
        		'default' => 'none',
        		'tooltip' => ''
            ),
            array(
        		'att_name' => 'border_width',
        		'type' => 'number',
        		'label' => __( 'Border Size', 'tatsu' ),
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
				  'options' => array (
						'gradient' => true
				  ),
	            'label' => __( 'Border Color', 'tatsu' ),
	            'default' => '',
	            'tooltip' => '',
				'visible' => array( 'border_width', '>', '0' ),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property' => 'border-color',
						'when' => array( 'border_width', '!=', '0' ),
					),
				),
            ),
			array(
				'att_name' => 'id',
				'type' => 'number',
				'label' => __( 'Id', 'tatsu' ),
				'visible' => array( 'border_width', '=', '-1000' )
			),			
			array(
                'att_name' => 'size',
                'type' => 'select',
                'target_attribute' => 'image_varying_size_src',
                'label' => __( 'Image Size', 'tatsu' ),
                'options' => array(
                    'full' => 'Full',
                    'thumbnail' => 'Thumbnail',
                    'medium' => 'Medium',
                    'large' => 'Large'
                ),
                'default' => 'full',
                'tooltip' => '',
				'visible'	=> array ( 'image', '!=', '' ),
            ),
			array(
				'att_name' => 'adaptive_image',
				'type' => 'switch',
				'label' => __( 'Use Adaptive Image', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			),
			array (
				'att_name' => 'max_width',
				'type' => 'slider',
				'label' => __('Width', 'tatsu'),
				'options' => array(
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'unit' => '%',
				),
				'visible'	=> array (
					'condition'	=> array (
						array( 'rebel', '!=', '1' ),
						array( 'size', '==', 'full' ),
					),
					'relation'	=> 'and',
				),
				'css'		=> true,
				'responsive'=> true,	
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-single-image-inner'	=> array (
						'property'	=> 'max-width',
						'when'		=> array (
							array ( 'rebel', '!=', '1' ),
							array ( 'size', '=', 'full' )
						),
						'relation'	=> 'and',
						'append'	=> '%',
					)
				),
				'default' => '100%',
			),
			array (
				'att_name'	=> 'rebel',
				'type' 		=> 'switch',
				'label'		=> __( 'Enable Image Overflow', 'tatsu' ),
				'default'	=> 0,
				'tooltip'	=> '',
				'visible'	=> array ( 'size', '==', 'full' )
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
				'visible' => array ( 'rebel', '==', '1' ),
				'tooltip' => 'Use this to achieve images which overflows its enclosing parent column',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property' => 'width',
						'when' => array( 'rebel', '=', '1' ),
						'append' => '%',
					),
					'.tatsu-{UUID} .tatsu-single-image-inner ' => array( //added white space after the selector to make 'Key' of array unique
						'property' => 'transformX',
						'when' => array(
							array( 'rebel', '=', '1' ),
							array( 'alignment', '=','right' ),
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
				'type' => 'button_group',
				'label' => __( 'Box Shadow', 'tatsu' ),
				'options' => array(
					'light' => 'Light',
					'regular' => 'Regular',
					'strong' => 'Strong',
					'custom' => 'Custom',
					'drop' => 'Drop',
					'none' => 'None',
				),
				'default' => 'none',
				'tooltip' => 'Box Shadow for your image'
			),
			array (
				'att_name'	=> 'custom_shadow',
				'type'	=> 'input_box_shadow',
				'label'	=> __( 'Custom Box Shadow', 'tatsu' ),
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'visible'	=> array ( 'shadow', '=', 'custom' ),
				'tooltip'	=> '',
				'css' => true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-single-image-inner' => array (
						'property'	=> 'box-shadow',
						'when'	=> array( 'shadow', '=', 'custom' )
					)
				)
			),
			array (
				'att_name'	=> 'drop_shadow',
				'type'	=> 'input_box_shadow',
				'options'	=> array (
					'type'	=> 'drop-shadow',
				),
				'label'	=> __( 'Custom Drop Shadow', 'tatsu' ),
				'default' => 'drop-shadow(0px 0px 0px rgba(0,0,0,0))',
				'visible'	=> array ( 'shadow', '=', 'drop' ),
				'tooltip'	=> '',
				'css' => true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-single-image-inner' => array (
						'property'	=> 'filter',
						'when'	=> array( 'shadow', '=', 'drop' )
					)
				)
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'label' => __('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => 'px',
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
				'label' => __( 'Enable Lazy Load', 'tatsu' ),
				'default' => '1',
				'tooltip' => ''
			),
			array(
                'att_name' => 'placeholder_bg',
                'type' => 'color',
				  'options' => array (
						'gradient' => true
				  ),
                'label' => __( 'Placeholder background color', 'tatsu' ),
                'default' => '',
                'tooltip' => '',
				'visible' => array( 'lazy_load', '=', '1' ),
				 'css' => true, //starts
				 'selectors' => array(
				 	'.tatsu-{UUID} .tatsu-single-image-inner' => array(
						'property' => 'background-color',
				 		'when' => array( 'lazy_load', '=', '1' ),
				 	),
				 ),
			),
			array (
				'att_name' 	=> 'image_offset',
				'type'  	=> 'switch',
				'label'		=> __( 'Enable Image Offset', 'tatsu' ),
				'default'	=> 0,
				'tooltip'	=> ''
			),
			array (
				'att_name'	=> 'offset',
				'type'		=> 'negative_number',
				'label'		=> __( 'Image Horizontal Offset', 'tatsu' ),
				'default'	=> '0px 0px',
				'option_labels' => array('X-axis','Y-axis'),
				'tooltip'	=> '',
				'visible'	=> array( 'image_offset', '==', 1 ),
				'responsive' => true,
				'css' => true,
				  'selectors' => array(
					'.tatsu-{UUID}.tatsu-single-image' => array(
						'property' => 'transform',
						'when' => array('image_offset', '=', '1'),
					),
				),
			),
			array (
				'att_name' => 'lightbox',
				'type' => 'switch',
				'label' => __( 'Open In Lightbox', 'tatsu' ),
				'default'=> 0,
				'tooltip' => ''
			),
			array (
				'att_name' => 'link',
				'type' => 'text',
				'label' => __( 'Url to link', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'visible' => array( 'lightbox', '=', '0' )
			),
			array (
				'att_name' => 'new_tab',
				'type' => 'switch',
				'label' => __( 'Open in New tab', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
				'visible' => array( 'lightbox', '=', '0' )
			),
			array (
				'att_name' => 'animate',
				'type' => 'switch',
				'label' => __( 'Enable CSS Animation', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			),
			array (
				'att_name' => 'animation_type',
				'type' => 'select',
				'label' => __( 'Animation Type', 'tatsu' ),
				'options' => tatsu_css_animations(),
				'default' => 'fadeIn',
				'tooltip' => '',
				'visible' => array( 'animate', '=', '1' ),
			),
			array(
				'att_name' => 'animation_delay',
				'type' => 'slider',
				'options' => array(
					'min' => '0',
					'max' => '2000',
					'step' => '50',
					'unit' => 'ms',
				),
				'default' => '0',	        		
				'label' => __( 'Animation Delay', 'tatsu' ),
				'tooltip' => '',
				'visible' => array( 'animate', '=', '1' ),
			),
			array(
				'att_name'	=> 'enable_margin',
				'type'		=> 'switch',
				'label'		=> __('Enable Margin', 'tatsu'),
				'default'	=> '0',
				'tooltip'	=> '' 
			),
			array(
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
                'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'visible' => array( 'enable_margin', '=', '1' ),
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-single-image' => array(
						'property' => 'margin',
						'when' => array(
							array('enable_margin', '=', '1'),
							array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
						),
						'relation' => 'and',
					),
				),
 			),
		),
		// 'presets' => array(
		// 	'default' => array(
		// 		'title' => '',
		// 		'image' => '',
		// 		'preset' => array(
		// 			'image' => TATSU_PLUGIN_URL.'/img/image-placeholder.jpg',
		// 		),
		// 	)
		// ),			
	);
	tatsu_register_module( 'tatsu_image', $controls );
	tatsu_register_header_module( 'tatsu_image', $controls, 'tatsu_image' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_inner_row', 9 );
function tatsu_register_inner_row() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#inner_row',
		'title' => __( 'Inner Row', 'tatsu' ),
		'is_js_dependant' => false,
		'child_module' => 'tatsu_inner_column',
		'allowed_sub_modules' => array( 'tatsu_inner_column' ),
		'type' => 'multi',
		'initial_children' => 1,
		'is_built_in' => true,
		'builder_layout' => 'column',
		'group_atts' => array(
			'no_margin_bottom',
			'equal_height_columns',
			'gutter',
			'column_spacing',
			'swap_cols',
			array (
				'type' => 'accordion' ,
				'group' => array (
					array (
						'type' => 'panel',
						'title' => __( 'Spacing and Styling', 'tatsu' ),
						'group' => array (
							'bg_color',
							'border_radius',
							'padding',
							'box_shadow',
							'margin',
							'border',
							'border_color',
						)
					),
					array (
						'type' => 'panel',
						'title' => __( 'Identifiers', 'tatsu' ),
						'group' => array (
							'row_id',
							'row_class'
						)
					)
				)
			),
			'hide_in'
		),
		'atts' => array (
			 array (
			  'att_name' => 'no_margin_bottom',
			  'type' => 'switch',
			  'label' => __( 'Set margin bottom of all columns to zero', 'tatsu' ),
			  'default' => 0,
			  'tooltip' => '',
			),
			 array (
			  'att_name' => 'equal_height_columns',
			  'type' => 'switch',
			  'label' => __( 'Set all columns to be of equal height', 'tatsu' ),
			  'default' => 0,
			  'tooltip' => '',
			),
			array (
				'att_name' => 'gutter',
				'type' => 'select',
				'label' => __( 'Spacing between columns', 'tatsu' ),
				'options' => array(
					'tiny' => 'Tiny',
					'small' => 'Small',
					'medium' => 'Medium',
					'large' => 'Large',
					'no' => 'Zero',
					'custom' => 'Custom',
				),
				'default' => 'medium',
				'tooltip' => ''
			),	             
			 array (
			  'att_name' => 'column_spacing',
			  'type' => 'number',
			  'label' => __( 'Column Spacing', 'tatsu' ),
			  'options' => array(
				  'unit' => 'px',
				  'add_unit_to_value' => true,
			  ),
			  'default' => '',
			  'tooltip' => '',
			  'visible' => array( 'gutter', '=', 'custom' ),
			),
			 array (
				'att_name'		=> 'swap_cols',
				'type'			=> 'switch',
				'label'			=> __( 'Swap Columns in Mobile', 'tatsu' ),
				'default'		=> 0,
				'tooltip'		=> ''	
			 ),
			 array (
				'att_name' => 'bg_color',
				'type' => 'color',
				'options' => array (
					'gradient' => true
				),
				'label' => __( 'Background Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'background-color',
					),
				),
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'label' => __('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'css' => true,
				'selectors' => array(
				   '.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
				),
				'tooltip' => 'Use this to give border radius',
			),
			 array (
				 'att_name' => 'box_shadow',
				 'type' => 'input_box_shadow',
				 'label' => __( 'Shadow Value', 'tatsu' ),
				 'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				 'tooltip' => '',
				 'css' => true,
				'selectors' => array(
						'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
							'property' => 'box-shadow',
							'when' => array('box_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)'),
						),
					),
			 ),
			array (
				'att_name' => 'margin',
				'type' => 'negative_number',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 0px',
				'option_labels' => array('Top','Bottom'),
				'tooltip' => '',
				'css' => true,
				'responsive' => true,
				'selectors' => array(
						'.tatsu-{UUID} > .tatsu-row' => array(
							'property' => 'margin-top',
							'when' => array('margin', '!=', array( 'd' => '0px 0px' ) ),
							'callback' => 'tatsu_row_margin_top_callback',
						),
						'.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
							'property' => 'margin-bottom',
							'when' => array('margin', '!=', array( 'd' => '0px 0px' ) ),
							'callback' => 'tatsu_row_margin_bottom_callback',
						),
					),
			),
			 array (
			   'att_name' => 'padding',
			   'type' => 'input_group',
			   'label' => __( 'Padding', 'tatsu' ),
			   'default' => '0px 0px 0px 0px',
			   'tooltip' => '',
			   'css' => true,
			   'responsive' => true,
			   'selectors' => array(
					 '.tatsu-{UUID}.tatsu-row-wrap > .tatsu-row' => array(
						 'property' => 'padding',
						 'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					 ),
				 ),
			 ),
			 array (
				'att_name' => 'border',
				'type' => 'input_group',
				'label' => __( 'Border Thickness', 'tatsu' ),
				'default' => '0px 0px 0px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					  '.tatsu-{UUID}.tatsu-row-wrap' => array(
						  'property' => 'border-width',
						  'when' => array('border', '!=', '0px 0px 0px 0px' ),
					  ),
				  ),
			  ),
			  array (
				'att_name' => 'border_color',
				'type' => 'color',
				'options' => array (
					  'gradient' => true
				),
				'label' => __( 'Border Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					  '.tatsu-{UUID}.tatsu-row-wrap' => array(
						  'property' => 'border-color',
						  'when' => array('border', '!=', '0px 0px 0px 0px'),
					  ),
				  ),
			  ),
			 array (
			  'att_name' => 'row_id',
			  'type' => 'text',
			  'label' => __( 'Row Id', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			),
			 array (
			  'att_name' => 'row_class',
			  'type' => 'text',
			  'label' => __( 'Row Class', 'tatsu' ),
			  'default' => '',
			  'tooltip' => 'Use this to add a css class identifier to this Row. Separate multiple classes using Comma',
			),
			 array (
			  'att_name' => 'hide_in',
			  'type' => 'screen_visibility',
			  'label' => __( 'Hide in', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			),
		),
	);
	tatsu_register_module( 'tatsu_inner_row', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_inner_column' );
function tatsu_register_inner_column() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Inner Column', 'tatsu' ),
		'is_js_dependant' => false,
		'child_module' => 'module',
		'initial_children' => 0,
		'type' => 'core',
		'builder_layout'=> 'list',
		'is_built_in' => true,
		'group_atts' => array(
			array (
				'type' => 'accordion' ,
				'active' => array(0),
				'group' => array (
					array (
						'type' => 'panel',
						'title' => __( 'Background', 'tatsu' ),
						'group' => array (
							'bg_color',
							'bg_image',
							'bg_repeat',
							'bg_attachment',
							'bg_position',
							'bg_size',
							'bg_video',
							'bg_video_mp4_src',
							'bg_video_ogg_src',
							'bg_video_webm_src'
						)
					),			
					array (
						'type' => 'panel',
						'title' => __( 'Spacing and Styling', 'tatsu' ),
						'group' => array (
							'column_width',
							'column_mobile_spacing',
							'padding',
							'custom_margin',
							'margin',
							'border_radius',
							'border',
							'border_color',
							'enable_box_shadow',
							'box_shadow_custom'
						)
					),	
					array (
						'type' => 'panel',
						'title' => __( 'Overlay', 'tatsu' ),
						'group' => array (
							'bg_overlay',
							'overlay_color',
							'animate_overlay',
							'link_overlay'
						)
					),
					array (
						'type' => 'panel',
						'title' => __( 'Offset Column', 'tatsu' ),
						'group' => array (
							'column_offset',
							'offset',
							'z_index'
						)
					),	
					array (
						'type' => 'panel',
						'title' => __( 'Animation', 'tatsu' ),
						'group' => array (
							'column_parallax',
							'animate',
							'animation_type',
							'animation_delay'
						)
					),
					array (
						'type' => 'panel',
						'title' => __( 'Identifiers', 'tatsu' ),
						'group' => array (
							'col_id',
							'column_class'
						)
					)
				) 
			),	
			'vertical_align',								
			'hide_in'
		),
		'atts' => array (
			 array (
			  'att_name' => 'bg_color',
			  'type' => 'color',
			  'label' => __( 'Background Color', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			  'css' => true,
			  'selectors' => array(
				  '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
					  'property' => 'background-color',
				  ),
				),
			),
			 array (
			  'att_name' => 'bg_image',
			  'type' => 'single_image_picker',
			  'label' => __( 'Background Image', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			  'css' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-image',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			 array (
			  'att_name' => 'bg_repeat',
			  'type' => 'select',
			  'label' => __( 'Background Repeat', 'tatsu' ),
			  'options' => array (
				'repeat' => 'Repeat Horizontally & Vertically',
				'repeat-x' => 'Repeat Horizontally',
				'repeat-y' => 'Repeat Vertically',
				'no-repeat' => 'Don\'t Repeat',
			  ),
			  'default' => 'no-repeat',
			  'tooltip' => '',
			  'hidden' => array( 'bg_image', '=', '' ),
			  'css' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-repeat',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			 array (
			  'att_name' => 'bg_attachment',
			  'type' => 'select',
			  'label' => __( 'Background Attachment', 'tatsu' ),
			  'options' => array (
				'scroll' => 'Scroll',
				'fixed' => 'Fixed'
			  ),
			  'default' => 'scroll',
			  'tooltip' => '',
			  'hidden' => array( 'bg_image', '=', '' ),
			  'css' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-attachment',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			 array (
			  'att_name' => 'bg_position',
			  'type' => 'select',
			  'label' => __( 'Background Position', 'tatsu' ),
			  'options' => array (
				'top left' => 'Top Left',
				'top right' => 'Top Right',
				'top center' => 'Top Center', 
				'center left' => 'Center Left', 
				'center right' => 'Center Right', 
				'center center' => 'Center Center',
				'bottom left' => 'Bottom Left',
				'bottom right' => 'Bottom Right',
				'bottom center' => 'Bottom Center'
			  ),
			  'default' => 'top left',
			  'tooltip' => '',
			  'hidden' => array( 'bg_image', '=', '' ),
			  'css' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-position',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			 array (
			  'att_name' => 'bg_size',
			  'type' => 'select',
			  'label' => __( 'Background Size', 'tatsu' ),
			  'options' => array (
				  'cover' => 'Cover',
				  'contain' => 'Contain',
				  'initial' => 'Initial',
				  'inherit' => 'Inherit'
			  ),
			  'default' => 'cover',
			  'tooltip' => '',
			  'hidden' => array( 'bg_image', '=', '' ),
			  'css' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'background-size',
						'when' => array('bg_image', 'notempty'),
					),
				),
			),
			array (
			  'att_name' => 'padding',
			  'type' => 'input_group',
			  'label' => __( 'Padding', 'tatsu' ),
			  'default' => '0px 0px 0px 0px',
			  'tooltip' => '',
			  'css' => true,
			  'responsive' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-pad-wrap > .tatsu-column-pad' => array(
						'property' => 'padding',
						'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),
			array (
				'att_name' => 'custom_margin',
				'type' => 'switch',
				'label' => __( 'Custom Margin ?', 'tatsu' ),
				'default' => '0',
				'tooltip' => '',				  
			),	            
			array (
			  'att_name' => 'margin',
			  'type' => 'input_group',
			  'label' => __( 'Margin', 'tatsu' ),
			  'default' => '0px 0px 60px 0px',
			  'tooltip' => '',
			  'visible' => array( 'custom_margin', '=', '1' ),
			  'css' => true,
			  'responsive' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column' => array(
						'property' => 'margin',
						'when' => array(
							array('margin', '!=', array( 'd' => '0px 0px 60px 0px' ) ),
							array( 'custom_margin', '!=', '0'),
						),
						'relation' => 'and',
						'append' => ' !important',
					),
				),
			),
			array(
				'att_name' => 'border_radius',
				'type' => 'number',
				'label' => __('Border Radius', 'tatsu'),
				'options' => array(
					'unit' => 'px',
					'add_unit_to_value' => true,
				),
				'default' => '0',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image-wrap > .tatsu-column-bg-image' => array(
						'property' => 'border-radius',
						'when' => array('border_radius', '!=', '0px'),
					),
				),
				'tooltip' => 'Use this to give border radius',
			),
			array (
			  'att_name' => 'border',
			  'type' => 'input_group',
			  'label' => __( 'Border Thickness', 'tatsu' ),
			  'default' => '0px 0px 0px 0px',
			  'tooltip' => '',
			  'responsive' => true,
			  'css' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-width',
						'when' => array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
					),
				),
			),
			array (
			  'att_name' => 'border_color',
			  'type' => 'color',
			  'label' => __( 'Border Color', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			  'css' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						'property' => 'border-color',
						'when' => array('border', '!=', '0px 0px 0px 0px'),
					),
				),
			),
			 array (
			  'att_name' => 'bg_video',
			  'type' => 'switch',
			  'label' => __( 'Enable Background Video', 'tatsu' ),
			  'default' => 0,
			  'tooltip' => '',
			),
			 array (
				 'att_name' => 'bg_video_mp4_src',
				 'type' => 'text',
				 'label' => __( '.MP4 Source', 'tatsu' ),
				 'default' => '',
				 'visible' => array( 'bg_video', '=', '1' ),
			 ),
			 array (
				 'att_name' => 'bg_video_ogg_src',
				 'type' => 'text',
				 'label' => __( '.OGG Source', 'tatsu' ),
				 'default' => '',
				 'visible' => array( 'bg_video', '=', '1' ),             	
			 ),
			 array (
				 'att_name' => 'bg_video_webm_src',
				 'type' => 'text',
				 'label' => __( '.WEBM Source', 'tatsu' ),
				 'default' => '',
				 'visible' => array( 'bg_video', '=', '1' ),             	
			 ),
			 array (
			  'att_name' => 'bg_overlay',
			  'type' => 'switch',
			  'label' => __( 'Enable Background Overlay', 'tatsu' ),
			  'default' => 0,
			  'tooltip' => '',
			),
			 array (
			  'att_name' => 'overlay_color',
			  'type' => 'color',
			  'label' => __( 'Column Overlay', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			  'visible' => array( 'bg_overlay', '=', '1' ),
			  'css' => true,
			  'selectors' => array(
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-overlay' => array(
						'property' => 'background',
						'when' => array('bg_overlay', '=', '1'),
					),
				),
			),
			 array (
			  'att_name' => 'animate_overlay',
			  'type' => 'select',
			  'label' => __( 'Animate Column Overlay', 'tatsu' ),
			  'options' => array (
				'none' => 'None', 
				'hide' => 'Hidden by default and Show on Hover', 
				'show' => 'Shown by default and Hide on Hover', 
			  ),
			  'default' => 'none',
			  'tooltip' => '',
			),
			 array (
			  'att_name' => 'link_overlay',
			  'type' => 'text',
			  'label' => __( 'Link Overlay/Column URL', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			  'visible' => array( 'bg_overlay', '=', '1' ),
			),
			 array (
			  'att_name' => 'vertical_align',
			  'type' => 'button_group',
			  'label' => __( 'Vertical Alignment', 'tatsu' ),
			  'options' => array (
				'none' => 'None',
				'top' => 'Top', 
				'middle' => 'Middle', 
				'bottom' => 'Bottom',
				// 'baseline' => 'Baseline',
				// 'stretch' => 'Stretch',
			  ),
			  'default' => 'none',
			  'tooltip' => '',
			),
			array (
				'att_name' 	=> 'column_offset',
				'type'  	=> 'switch',
				'label'		=> __( 'Enable Column Offset', 'tatsu' ),
				'default'	=> 0,
				'tooltip'	=> ''
			),
			array (
				'att_name'	=> 'offset',
				'type'		=> 'negative_number',
				'label'		=> __( 'Column Horizontal Offset', 'tatsu' ),
				'default'	=> '0px 0px',
				'option_labels' => array('X-axis','Y-axis'),
				'tooltip'	=> '',
				'visible'	=> array( 'column_offset', '==', 1 ),
				'responsive' => true,
				'css' => true,
				'selectors' => array(
				  '.tatsu-{UUID}.tatsu-column' => array(
					  'property' => 'transform',
					  'when' => array('column_offset', '=', '1'),
				  	),
			  	),
			),
			array (
				'att_name'	=> 'z_index',
				'type'		=> 'slider',
				'label'		=> __( 'Stack Order', 'tatsu' ),
				'options'	=> array (
					'min'	=> 0,
					'max'	=> 10,
					'step'	=> 1,
					'unit'	=> '',
					'add_unit_to_value' => false
				),
				'default'	=> 0,
				'tooltip'	=> '',
				'visible'	=> array( 'column_offset', '==', 1 ),
				'css' => true,
				'selectors' => array(
				  	'.tatsu-{UUID}.tatsu-column' => array(
					  	'property' => 'z-index',
					  	'when' => array(
						  array('z_index', 'notempty'),
						  array('column_offset', '=', '1')
					  	),
					  	'relation' => 'or',
				  	),
			  	),
			),
			array (
				'att_name' => 'column_parallax',
				'type' => 'slider',
				'label' => __( 'Column Parallax', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '10',
					'step' => '1',
					'unit' => '',
				),		        		
				'default' => '0',
				'tooltip' => ''

			),
			array (
				'att_name' => 'column_width',
				'type' => 'slider',
				'label' => __( 'Column Width', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '100',
					'step' => '.01',
					'unit' => '',
				),		        		
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-row > .tatsu-{UUID}.tatsu-column' => array(
						'property' => 'width',
						'append' => '%'
					)
				),
			),
			array(
				'att_name' => 'column_mobile_spacing',
				 'type' => 'number',
				'label' => __( 'Column Spacing (In Mobile)', 'tatsu' ),
				'visible' => array( 'column_width', '<', '100' ),
				'device_visibility' => 'mobile',
				 'options' => array(
					 'unit' => 'px',
					 'add_unit_to_value' => false,
				 ),
				 'default' => '0',
				'tooltip' => ''
			),
			 array (
			  'att_name' => 'animate',
			  'type' => 'switch',
			  'label' => __( 'Enable CSS Animation', 'tatsu' ),
			  'default' => '0',
			  'tooltip' => '',
			),
			 array (
			  'att_name' => 'animation_type',
			  'type' => 'select',
			  'label' => __( 'Animation Type', 'tatsu' ),
			  'options' => tatsu_css_animations(),
			  'default' => 'fadeIn',
			  'tooltip' => '',
			  'visible' => array( 'animate', '=', '1' ),
			),
			array(
				'att_name' => 'animation_delay',
				'type' => 'slider',
				'options' => array(
					'min' => '0',
					'max' => '2000',
					'step' => '50',
					'unit' => 'ms',
				),
				'default' => '0',	        		
				'label' => __( 'Animation Delay', 'tatsu' ),
				'tooltip' => '',
				'visible' => array( 'animate', '=', '1' ),
			),
			 array (
			  'att_name' => 'col_id',
			  'type' => 'text',
			  'label' => __( 'Column Id', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			),
			 array (
			  'att_name' => 'column_class',
			  'type' => 'text',
			  'label' => __( 'Column Class', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			),	   
			array (
				'att_name' => 'enable_box_shadow',
				'type' => 'switch',
				'label' => __( 'Enable Column Shadow', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			), 
			array (
				'att_name' => 'box_shadow_custom',
				'type' => 'input_box_shadow',
				'label' => __( 'Column Shadow Value', 'tatsu' ),
				'default' => '0 0 15px 0 rgba(198,202,202,0.4)',
				'tooltip' => '',
				'visible' => array( 'enable_box_shadow', '=', '1' ),
				'css' => true,
				'selectors' => array(
					  '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner' => array(
						  'property' => 'box-shadow',
						  'when' => array('enable_box_shadow', '=', '1'),
					  ),
				  ),
			), 
			 array (
			  'att_name' => 'hide_in',
			  'type' => 'screen_visibility',
			  'label' => __( 'Hide in', 'tatsu' ),
			  'default' => '',
			  'tooltip' => '',
			),
		),
	);
	tatsu_register_module( 'tatsu_inner_column', $controls );
}


add_action( 'tatsu_register_global_section', 'tatsu_register_gsection_title' );
function tatsu_register_gsection_title() {
		$controls = array (
	        'icon' =>'',
	        'title' => __( 'Global Section Title', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array_values(array_filter(array (
				array(
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',	        			
	        			'right' => 'Right',
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
				),
				( function_exists( 'typehub_get_exposed_selectors' ) ? array (
					'att_name' => 'title_font',
					'type' => 'select',
					'label' => __('Font for Title','tatsu'),
					'options' => typehub_get_exposed_selectors(),
					'default' => '',
					'tooltip' => ''
				) : false  ),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 30px 0px',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors'=> array(
						'.tatsu-{UUID}.tatsu-module' => array(
							'property' => 'margin',
						),
					),
				),
				))),
	        'presets' => array(
	        	'default' => array(
	        		'preset' => array(
	        			'height' => '1',
	        		),
	        	)
	        ),	        
	    );
		tatsu_register_global_module( 'tatsu_gsection_title', $controls );
}

add_action( 'tatsu_register_global_section', 'tatsu_register_gsection_meta' );
function tatsu_register_gsection_meta() {	
		$controls = array (
	        'icon' =>'',
	        'title' => __( 'Global Section Meta', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
			'atts' => array_merge( array(	
				array (
					'att_name' => 'post_type',
					'type' => 'select',
					'label' => __('Post Type','tatsu'),
					'options' => tatsu_get_custom_post_types(),
					'default' => 'post',
					'tooltip' => ''
				),),
				tatsu_global_section_meta_values(), 
				array_values(array_filter(array (
					array (
						'att_name' => 'meta_prefix',
						'type' => 'text',
						'label' => __( 'Meta Prefix', 'tatsu' ),
						'default' => '',
						'tooltip' => '',
					),
					array(
						'att_name' => 'alignment',
						'type' => 'button_group',
						'label' => __( 'Alignment', 'tatsu' ),
						'options' => array(
							'left' => 'Left',
							'center' => 'Center',	        			
							'right' => 'Right',
						),
						'default' => 'center',
						'tooltip' => ''
					),
					( function_exists( 'typehub_get_exposed_selectors' ) ? array (
						'att_name' => 'title_font',
						'type' => 'select',
						'label' => __('Font for Meta','tatsu'),
						'options' => typehub_get_exposed_selectors(),
						'default' => '',
						'tooltip' => ''
					) : false  ),
					array (
						'att_name' => 'margin',
						'type' => 'input_group',
						'label' => __( 'Margin', 'tatsu' ),
						'default' => '0px 0px 30px 0px',
						'tooltip' => '',
						'responsive' => true,
						'css' => true,
						'selectors'=> array(
							'.tatsu-{UUID}.tatsu-module' => array(
								'property' => 'margin',
							),
						),
					),
				)))
			),
	        'presets' => array(
	        	'default' => array(
	        		'preset' => array(
	        			'height' => '1',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_global_module( 'tatsu_gsection_meta', $controls );
}

add_action( 'tatsu_register_global_section', 'tatsu_register_sidebar' );
add_action( 'tatsu_register_modules', 'tatsu_register_sidebar' );
function tatsu_register_sidebar() {
	$sidebar_list = tatsu_get_sidebar_list();
	$controls = array (
		'icon' =>'',
		'title' => __( 'Sidebar', 'tatsu' ),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => false,
		'atts' => array (
			array (
				'att_name' => 'sidebar_id',
				'type' => 'select',
				'label' => __('Sidebar','tatsu'),
				'options' => $sidebar_list,
				'default' => key($sidebar_list),
				'tooltip' => ''
			),
		),
		'presets' => array(
			'default' => array(
				'preset' => array(
				),
			)
		),	        
	);
	tatsu_register_global_module( 'tatsu_gsection_sidebar', $controls );
	tatsu_register_module( 'tatsu_sidebar', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_skills');
function tatsu_register_skills() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#skills',
		'title' => __( 'Skills', 'tatsu' ),
		'is_js_dependant' => true,
		'child_module' => 'tatsu_skill',
		'type' => 'multi',
		'initial_children' => 4,
		'is_built_in' => true,
		'atts' => array (
			array (
				'att_name' => 'direction',
				'type' => 'button_group',
				'label' => __( 'Direction', 'tatsu' ),
				'options' => array (
					'horizontal' => 'Horizontal', 
					'vertical' => 'Vertical'
				),
				'default' => 'horizontal',
				'tooltip' => ''
			),
			array (
				'att_name'		=> 'style',
				'type'			=> 'button_group',
				'label'			=> __( 'Style', 'tatsu' ),
				'options'		=> array (
					'rect'		=> 'Rectangular',
					'pill'		=> 'Pill',
				),
				'default'		=> 'rect',
				'tooltip'		=> ''
			),
			array (
				'att_name' => 'height',
				'type' => 'number',
				'label' => __( 'Skill Height', 'tatsu' ),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '400',
				'visible'	=> array( 'direction', '=', 'vertical' ),
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .skill-bar' => array(
						'property' => 'height',
						'append' => 'px',
						'when'	=> array( 'direction', '=', 'vertical' ),
					),
				),
			),
			array (
				'att_name' => 'title_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true,
				),
				'label' => __( 'Title Color', 'tatsu' ),
				'default' => '', //sec_color
				'tooltip' => '',
				'css' => true,
				  'selectors' => array(
					'.tatsu-{UUID} .skill_name' => array(
						'property' => 'color',
					),
				),
			),
			array (
				'att_name' => 'fill_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true,
				),
				'label' => __( 'Fill Color', 'tatsu' ),
				'default' => '', //color_scheme
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .be-skill' => array(
						'property' => 'background',
					),
				),
			),
			array (
				'att_name' => 'bg_color',
				'type' => 'color',
				'label' => __( 'Background Color', 'tatsu' ),
				'default' => '', //sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .skill-bar' => array(
						'property' => 'background',
					),
			    ),
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 0px 60px 0px',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-module' => array(
						'property' => 'margin',
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'fill_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					'bg_color' => '#f2f5f8',
				),
			)
		),
	);
	tatsu_remap_modules( array( 'tatsu_skills', 'skills') , $controls, 'tatsu_skills' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_skill');
function tatsu_register_skill() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Skill', 'tatsu' ),
	        'is_js_dependant' => true,
			'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Skill Name', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Title Color', 'tatsu' ),
		            'default' => '', //sec_color
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID}.skill-wrap .skill_name' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'value',
	        		'type' => 'slider',
	        		'label' => __( 'Skill Score', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'fill_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Fill Color', 'tatsu' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID}.skill-wrap .be-skill' => array(
							'property' => 'background',
						),
					),
	            ),
	        	array (
		            'att_name' => 'bg_color',
					'type' => 'color',
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '', //sec_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID}.skill-wrap .skill-bar' => array(
						  'property' => 'background',
					  ),
				  ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title' => 'Skill',
	        			'value' => '70',
	        		),
	        	)
	        ),
	    );
		tatsu_remap_modules( array( 'tatsu_skill', 'skill') , $controls, 'tatsu_skill' );
}

if( !function_exists( 'tatsu_register_star_rating' ) ) {
	add_action( 'tatsu_register_modules', 'tatsu_register_star_rating' );
	function tatsu_register_star_rating() {
		$controls = array (
			'icon' 				=> TATSU_PLUGIN_URL . '/builder/svg/modules.svg#star_rating',
			'title' 			=> __( 'Star Rating', 'tatsu' ),
			'is_js_dependant' 	=> false,
			'type' 				=> 'single',
			'is_built_in' 		=> true,
			'group_atts' => array(
				'rating',
				array (
					'type' => 'accordion' ,
					'active' => array(0, 1),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Colors', 'tatsu' ),
							'group' => array (
								'range_color',
								'fill_color',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Alignments', 'tatsu' ),
							'group' => array (
								'alignment',
								'margin',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay',
							)
						),	
					),
				),
			),
			'atts' 				=> array (
				array (
					'att_name'		=> 'rating',
					'type'			=> 'slider',
					'label'			=> __( 'Rating', 'tatsu' ),
					'options'		=> array (
						'min'		=> '0.5',
						'max'		=> '5',
						'step'		=> '0.5'
					),
					'default'		=> '5',
					'tooltip'		=> '',
				),
				array (
					'att_name'		=> 'alignment',
					'type'			=> 'button_group',
					'label'			=> __( 'Alignment', 'tatsu' ),
					'options'		=> array (
						'none'		=> 'None',
						'left'		=> 'Left',
						'center'	=> 'Center',
						'right'		=> 'Right',	
					),
					'default'		=> 'none',
					'tooltip'		=> '',
				),
				array (
					'att_name'		=> 'range_color',
					'type'			=> 'color',
					'label'			=> __( 'Range Color', 'tatsu' ),
					'default'		=> '',
					'tooltip'		=> '',
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-star-rating-range'	 => array (
							'property'		=> 'color'
						)
					)
				),
				array (
					'att_name'		=> 'fill_color',
					'type'			=> 'color',
					'label'			=> __( 'Fill Color', 'tatsu' ),
					'default'		=> '#F5C74D',
					'tooltip'		=> '',
					'options'		=> array (
						'gradient'	=> true,
					),
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-star-rating-filled'	 => array (
							'property'		=> 'color'
						)
					)
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0 0 10px 0',
					'tooltip' => '',
					'css'	  => true,
					'responsive'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID}.tatsu-module'	=> array (
							'property'		=> 'margin',
						)
					)
				),
				array (
					'att_name' => 'animate',
					'type' => 'switch',
					'default' => 0,
					'label' => __( 'Enable Css Animations', 'tatsu' ),
					'tooltip' => ''
				),
				array (
					'att_name' => 'animation_type',
					'type' => 'select',
					'options' => tatsu_css_animations(),
					'label' => __( 'Animation Type', 'tatsu' ),
					'default' => 'fadeIn',
					'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
				array(
				   'att_name' => 'animation_delay',
				   'type' => 'slider',
				   'options' => array(
					   'min' => '0',
					   'max' => '2000',
					   'step' => '50',
					   'unit' => 'ms',
				   ),
				   'default' => '0',	        		
				   'label' => __( 'Animation Delay', 'tatsu' ),
				   'tooltip' => '',
				   'visible' => array( 'animate', '=', '1' ),
			   ),
			),
		);
		tatsu_register_module( 'tatsu_star_rating', $controls );
	}
}

/**
 * Image Carousel
 */
add_action( 'tatsu_register_modules', 'tatsu_register_image_carousel');
function tatsu_register_image_carousel() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#image_carousel',
		'title' => __( 'Image Carousel','tatsu' ),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'group_atts'	=> array (
			'type',
			'images',
			'slides_to_show',
			array (
				'type'		=> 'accordion',
				'active'	=> 'none',
				'group'		=> array (
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Gutter and Slider Height', 'tatsu' ),
						'group'		=> array (
							'slide_gutter',
							'height',
							'full_screen',
							'full_screen_offset',
						)
					),
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Slider Settings', 'tatsu' ),
						'group'		=> array (
							'arrows',
							'pagination',
							'dots_color',
							'slide_show',
							'slide_show_speed',
							'swipe_to_slide',
							'infinite'
						)
					),
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Advanced', 'tatsu' ),
						'group'		=> array (
							'lazy_load',
							'adaptive_images',
							'slide_bg_color',
							'center_scale',
							'border_radius',
							'margin',
							'destroy_in_mobile',
						)
					),
				)	
			),
		),
		'atts' => array (
			array (
				'att_name'		=> 'type',
				'type'			=> 'select',
				'label'			=> __( 'Carousel Style', 'tatsu' ),
				'options'		=> array (
					'ribbon'	=> 'Ribbon Carosuel',
					'centered_ribbon'	=> 'Ribbon - Centered Carousel',
					'fixed'		=> 'Fixed Width Carousel Slider',
					'client_carousel'	=> 'Client Carousel',
				),
				'default' => 'client_carousel'
			),
			array (
				'att_name'	=> 'images',
				'type'		=> 'multi_image_picker',
				'label'		=> __( 'Images', 'tatsu' ),
				'default'	=> '',
				'options'	=> array (
					'type'	=> 'both',
					'size'	=> 'full'
				)
			),
			array (
				'att_name'	=> 'center_scale',
				'type'		=> 'switch',
				'label'		=> __( 'Center Scale Images', 'tatsu' ),
				'default'	=> '0',
				'visible'	=> array ( 'type', '=', 'fixed' ),
			),
			array (
				'att_name'	=> 'lazy_load',
				'type'		=> 'switch',
				'label'		=> __( 'Enable Lazy Load', 'tatsu' ),
				'default'	=> '0',
			),
			array (
				'att_name'		=> 'adaptive_images',
				'type'			=> 'switch',
				'label'			=> __( 'Enable Adaptive Images', 'tatsu' ),
				'default'		=> '0',
			),
			array (
				'att_name'	 => 'slide_gutter',
				'type'		 => 'number',
				'options' => array(
					'unit' => 'px',
				),
				'label'		 => __( 'Spacing Between Images', 'tatsu' ),
				'default'	 => '0',
				'css'		 => true,
				'selectors'	 => array(
					'.tatsu-{UUID} .tatsu-carousel-col' => array (
						'property'	=> 'padding',
						'prepend'	=> '0 ',
						'append'	=> 'px',
						'operation'	=> array( '/', 2 )
					),
					'.tatsu-{UUID} .tatsu-carousel'		=> array (
						'property'		=> 'margin',
						'prepend'		=> '0 -',
						'append'		=> 'px',
						'operation'		=> array( '/', 2 ),
					),
				),
			),
			array (
				'att_name'	 => 'height',
				'type'		 => 'number',
				'options' => array(
					'unit' => 'px',
				),
				'label'		=> __( 'Slider Height', 'tatsu' ),
				'default'	=> '500',
				'responsive'=> true,
				'css' 		=> true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-carousel-col-inner' => array (
						'property'	=> 'height',
						'append'	=> 'px',
						'when'		=> array ( 'full_screen', '!=', '1' )
					),
				),
				'visible'	=> array ( 'full_screen', '=', '0' ),
			),
			array (
				'att_name'		=> 'full_screen',
				'type'			=> 'switch',
				'label'			=> __( 'Enable Full Screen Slider', 'tatsu' ),
				'default'		=> '0',
			),
			array (
				'att_name'		=> 'full_screen_offset',
				'type'			=> 'text',
				'label'			=> __( 'Full Screen Slider Offset', 'tatsu' ),
				'default'		=> '',
				'visible'	=> array ( 'full_screen', '==', '1' ),
			),
			array (
				'att_name'	=> 'slides_to_show',
				'type'		=> 'slider',
				'options'	=> array (
					'min'	=> '1',
					'max'	=> '6'
				),
				'label'		=> __( 'Slides Per Row', 'tatsu' ),
				'default'	=> '3',
				'visible'	=> array(
					'condition' => array (
						array ( 'type', '==', 'fixed' ),
						array ( 'type', '==', 'client_carousel' )
					),
					'relation'	=> 'or'
				)
			),
			array (
				'att_name'	=> 'border_radius',
				'type'		=> 'number',
				'label'		=> __( 'Border Radius', 'tatsu' ),
				'options' 	=> array (
					'unit'	=> 'px'
				),
				'default'	=> '0',
				'css'		=> true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-carousel-col-inner'		=>  array (
						'property'			=> 'border-radius',
						'append'			=> 'px'
					)
				)
			),
			array (
				'att_name'			=> 'slide_bg_color',
				'type'				=> 'color',
				'label'				=> __( 'Slide Background Color', 'tatsu' ),
				'default'			=> '#e5e5e5',
				'css'				=> true,
				'selectors'			=> array (
					'.tatsu-{UUID} .tatsu-carousel-col-inner' => array (
						'property'	=> 'background'
					)
				)
			),
			array (
				'att_name'	=> 'arrows',
				'type'		=> 'switch',
				'label'		=> __( 'Enable Arrows', 'tatsu' ),
				'default'	=> '0',
				'tooltip'	=> ''
			),
			array (
				'att_name' => 'pagination',
				'type' => 'switch',
				'label' => __( ' Enable Dots', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			),
			array (
				'att_name' => 'dots_color',
				'type' => 'color',
				'label' => __( 'Slider Dots Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'visible'	  => array( 'pagination', '=', '1' ),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .flickity-page-dots .is-selected' => array(
						'property' => 'background',
						'when'	   => array ( 'pagination', '=', '1' ),
					),
				),
			),
			array (
				'att_name' => 'infinite',
				'type' => 'switch',
				'label' => __( ' Enable Infinite Carousel', 'tatsu' ),
				'default' => 1,
				'tooltip' => '',
			),
			array (
				'att_name' => 'slide_show',
				'type' => 'switch',
				'label' => __( 'Enable Slide Show', 'tatsu' ),
				'default' => 0,
				'tooltip' => ''
			),
			array (
				'att_name' => 'slide_show_speed',
				'type' => 'slider',
				'visible' => array('slide_show', '=', '1'),
				'label' => __( 'Slide Show Speed', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '5000',
					'step' => '1000',
					'unit' => 'ms',
				),
				'default' => '2000',
				'tooltip' => ''
			),
			array (
				'att_name'	=> 'swipe_to_slide',
				'type'		=> 'switch',
				'label'		=> __( 'Enable Free Scroll', 'tatsu' ),
				'default'	=> '1',
				'tooltip'	=> ''
			),
			array (
				'att_name' => 'destroy_in_mobile',
				'type' => 'switch',
				'label' => __( 'Stack Images in Mobile view', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			),
			array (
				'att_name'		=> 'margin',
				'type'			=> 'input_group',
				'label'			=> __( 'Margin', 'tatsu' ),
				'default'		=> '0 0 60px 0',
				'tooltip'		=> '',
				'css'			=> true,
				'responsive'	=> true,
				'selectors'		=> array (
					'.tatsu-{UUID}.tatsu-module' => array (
						'property'	=> 'margin',
					)
				)	
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'images'			=> '::http://placehold.it/220x150,::http://placehold.it/220x150,::http://placehold.it/220x150,::http://placehold.it/220x150,::http://placehold.it/220x150,::http://placehold.it/220x150,::http://placehold.it/220x150',
					'height'			=> '150',
					'style'				=> 'client_carousel',
					'slide_gutter'		=> '20',
					'dots_color'		=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					'slides_to_show'	=> '5',
				),
			)
		),
	);
	tatsu_register_module( 'tatsu_image_carousel', $controls );
}
add_action( 'tatsu_register_modules', 'tatsu_register_svg_icon');
function tatsu_register_svg_icon() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#svg_icon',
	        'title' => __( 'SVG Icon', 'tatsu' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
			'is_built_in' => true,
			'group_atts'	=> array (
				'custom_icon',
				'svg_url',
				'svg_icon',
				array (
					'type'	=> 'accordion',
					'active' => 'none',
					'group'	=> array (
						array (
							'type'	=> 'panel',
							'title'	=> __( 'Spacing and Styling', 'tatsu' ),
							'group'	=> array (
								'style',
								'size',
								'width',
								'height',
								'stroke_width',
								'bg_color',
								'color',
								'alignment',
								'margin',
							),
						),
						array (
							'type'	=> 'panel',
							'title'	=> __( 'Animation', 'tatsu' ),
							'group'	=> array (
								'line_animate',
								'path_animation_type',
								'svg_animation_type',
								'animation_duration',
								'animate',
								'animation_type',
								'animation_delay',
							),
						),
					),
				),	
			),
	        'atts' => array (
				array (
					'att_name'	=> 'svg_icon',
					'type'		=> 'svg_icon_picker',
					'label'		=> __( 'Svg Icon', 'tatsu' ),
					'default'	=> 'linea:basic_paperplane',
					'tooltip'	=> '',
					'visible'	=> array ( 'custom_icon', '=', '0' ),
				),
				array (
					'att_name'		=> 'custom_icon',
					'type'			=> 'switch',
					'default'		=> '0',
					'label'			=> __( 'Enable Custom Icon', 'tatsu' ),
					'tooltip'		=> '',
				),
				array (
	        		'att_name' => 'svg_url',
					'type' => 'single_image_picker',
					'options' => array (
						'modal_title'	=> 'Select a Svg',
						'button_text'	=> 'Add Svg',
						'mime_type'		=> 'image/svg+xml',	
					),
	        		'label' => 'SVG Icon File URL',
	        		'default' => '',
					'tooltip' => 'Paste SVG Icon',
					'visible'	=> array ( 'custom_icon', '=', '1' ),
				),
				array (
					'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'tatsu' ),
	        		'options' => array (
						'circled'	=> 'Circled',
						'plain'		=> 'Plain',
					),
	        		'default' => 'plain',
	        		'tooltip' => ''
				),
	            array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'tatsu' ),
	        		'options' => array (
						'small' => 'Small',
						'medium' => 'Medium',
						'large' => 'Large',
						'xlarge' =>'XL',
						'custom' =>'Custom',
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
				array (
	        		'att_name' => 'width',
	        		'type' => 'number',
	        		'label' => __( 'Width', 'tatsu' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '200',
	        		'tooltip' => '',
					'visible' => array( 'size', '=', 'custom' ),
					'css'	  => true,
					'selectors'	=> array (
						'.tatsu-{UUID} svg'	=> array (
							'property'	=> 'width',
							'when'		=> array( 'size', '=', 'custom' ),
							'append'	=> 'px',
						),
						'.tatsu-{UUID} .tatsu-svg-icon-inner'		=> array (
							'property'		=> 'padding',
							'when'			=> array (
								array ( 'style', '=', 'circled' ),
								array ( 'size', '=', 'custom' ),
							),
							'relation'	=> 'and',
							'operation'		=> array( '/', 2 ),
							'append'		=> 'px',
						),
					),
				),
				array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'tatsu' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '200',
	        		'tooltip' => '',
					'visible' => array( 'size', '=', 'custom' ),
					'css'	  => true,
					'selectors'	=> array (
						'.tatsu-{UUID} svg'	=> array (
							'property'	=> 'height',
							'when'		=> array( 'size', '=', 'custom' ),
							'append'	=> 'px',
						),
					),
				),
				array (
					'att_name'		=> 'stroke_width',
					'type'			=> 'number',
					'label'			=> __( 'Stroke Width', 'tatsu' ),
					'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '2',
					'tooltip' => '',
					'css'	  => true,
					'visible'	=> array ( 'line_animate', '=', '1' ),
					'selectors'	=> array (
						'.tatsu-{UUID} svg'		=> array (
							'property'		=> 'stroke-width',
							'append'		=> 'px',
							'when'			=> array( 'line_animate', '=', '1' ),
						),
					),
				),
				array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'SVG Background Color', 'tatsu' ),
		            'default' => '', 
		            'tooltip' => '',
					'css' => true,
					'visible'	=> array ( 'style', '=', 'circled' ),
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-svg-icon-inner' => array(
							'property' => 'background',
							'when'	   => array (
								'style', '=', 'circled'
							)
						),
					),
	            ),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'SVG Color', 'tatsu' ),
		            'default' => '', 
		            'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} svg' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
				array (
	              	'att_name' => 'line_animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable SVG Line Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',     			
				),
				array (
					'att_name' => 'path_animation_type',
					'type' => 'select',
					'label' => __( 'Path Animation', 'tatsu' ),
					'options' => array( 
						'LINEAR' => 'Linear',
						'EASE' => 'Ease',
						'EASE_IN' => 'Ease In',
						'EASE_OUT' => 'Ease Out',
						'EASE_OUT_BOUNCE' => 'Ease Out Bounce'
					 ),
					'default' => 'EASE',
					'tooltip' => '',
				  'visible' => array( 'line_animate', '=', '1' ),
			  ),
			  array (
					'att_name' => 'svg_animation_type',
					'type' => 'select',
					'label' => __( 'SVG Animation', 'tatsu' ),
					'options' => array( 
						'LINEAR' => 'Linear',
						'EASE' => 'Ease',
						'EASE_IN' => 'Ease In',
						'EASE_OUT' => 'Ease Out',
						'EASE_OUT_BOUNCE' => 'Ease Out Bounce'
					 ),
					'default' => 'EASE_IN',
					'tooltip' => '',
				  'visible' => array( 'line_animate', '=', '1' ),
			  ),
			  array(
					'att_name' => 'animation_duration',
					'type' => 'slider',
					'options' => array(
						'min' => '10',
						'max' => '500',
						'step' => '1',
						'unit' => '',
					),
					'default' => '100',	        		
					'label' => __( 'Animation Duration', 'tatsu' ),
					'tooltip' => '',
					'visible' => array( 'line_animate', '=', '1' ),
			  	),
			  	array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0 0 30px 0',
					'tooltip' => '',
					'css'	  => true,
					'responsive'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID}.tatsu-module'	=> array (
							'property'		=> 'margin',
						)
					)
				),
				array (
					'att_name' => 'animate',
					'type' => 'switch',
					'label' => __( 'Enable Css Animation', 'tatsu' ),
					'default' => '0',
					'tooltip' => '',
				),
				array (
					'att_name'	=> 'animation_type',
					'type'		=> 'select',
					'label'		=> __( 'Enable Css Animation', 'tatsu' ),
					'default'	=> 'fadeIn',
					'tooltip'	=> '',
					'options'	=> tatsu_css_animations(),
					'visible'	=> array ( 'animate', '=', '1' )
				),
				array(
					'att_name' => 'animation_delay',
					'type' => 'slider',
					'options' => array(
						'min' => '0',
						'max' => '2000',
						'step' => '50',
						'unit' => 'ms',
					),
					'default' => '0',	        		
					'label' => __( 'Animation Delay', 'tatsu' ),
					'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'svg_icon'  => 'linea:basic_paperplane',
						'color'		=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_svg_icon', $controls );
}

add_action( 'tatsu_register_header_modules', 'tatsu_register_icon_card', 9 );
add_action( 'tatsu_register_modules', 'tatsu_register_icon_card');
function tatsu_register_icon_card() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#icon_card',
		'title' => __( 'Multi Purpose Card', 'tatsu' ),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'group_atts'	=> array (
			'title',
			'url',
			'content',
			'icon_type',
			'icon',
			'svg_icon',
			'image',
			'bg_size',
			array (
				'type'	=> 'accordion',
				'active' => 'none',
				'group'	=> array (
					array (
						'type'	=> 'panel',
						'title'	=> __( 'Style', 'tatsu' ),
						'group'	=> array (
							'style',
							'icon_style',
							'size',
							'line_animate',
							'horizontal_alignment',
							'vertical_alignment',
							'box_shadow',
							'title_font',
							'caption_font',
						),
					),
					array (
						'type'	=> 'panel',
						'title'	=> __( 'Colors and Spacing', 'tatsu' ),
						'group'	=> array (
							'icon_color',
							'icon_bg',
							'svg_icon_color',
							'title_color',
							'caption_color',
							'margin',
						),
					),
					array (
						'type'	=> 'panel',
						'title'	=> __( 'Animation', 'tatsu' ),
						'group'	=> array (
							'animate',
							'animation_type',
							'animation_delay',
						),
					)
				),
			),	
			'hide_in'
		),
		'atts' => array_values( array_filter( array (
			array (
				'att_name' => 'style',
				'type' => 'button_group',
				'label' => __( 'Style', 'tatsu' ),
				'options' => array (
					'style1'	=> 'Style 1',
					'style2'	=> 'Style 2'
				),
				'default' => 'style1',
				'tooltip' => ''
			),
			array (
				'att_name' => 'horizontal_alignment',
				'type' => 'button_group',
				'label' => __( 'Alignment', 'tatsu' ),
				'options' => array (
					'left'		=> 'Left',
					'center'	=> 'Center',
					'right'		=> 'Right'
				),
				'default' => 'center',
				'tooltip' => ''
			),
			array (
				'att_name' 		=> 'vertical_alignment',
				'type' 			=> 'button_group',
				'label' 		=> __( 'Vertical Alignment', 'tatsu' ),
				'options' 		=> array (
					'top'		=> 'Top',
					'center'	=> 'Center',
					'bottom'	=> 'Bottom',
					'baseline'	=> 'Baseline',
				),
				'default' => 'top',
				'visible'	=> array( 'style', '==', 'style1' ),
				'tooltip' => ''
			),
			array (
				'att_name' => 'icon_type',
				'type' => 'button_group',
				'label' => __( 'Icon Type', 'tatsu' ),
				'options' => array (
					'icon'=> 'Icon', 
					'svg'=> 'SVG',
					'image' => 'Image',
				),
				'default' => 'icon',
				'tooltip' => ''
			),
			array (
				'att_name' => 'icon',
				'type' => 'icon_picker',
				'label' => __( 'Icon', 'tatsu' ),
				'default' => 'icon-monitor',
				'visible' => array('icon_type','=','icon'),
				'tooltip' => ''
			),
			array (
				'att_name' => 'svg_icon',
				'type' => 'svg_icon_picker',
				'label' => __( 'Icon', 'tatsu' ),
				'default' => 'linea:basic_mail',
				'visible' => array('icon_type','=','svg'),
				'tooltip' => ''
			),
			array (
				'att_name' => 'image',
				'type' => 'single_image_picker',
				'label' => __( 'Background Image', 'tatsu' ),
				'visible' => array('icon_type','=','image'),
				'tooltip' => '',
				'default'	=> 'http://placehold.it/150x150',
				'options' => array(
					'size' => 'thumbnail',
				),
				'css'		=> true,
				'selectors' => array (
					'.tatsu-{UUID} .tatsu-icon_card-icon'	=> array(
						'property'	=> 'background',
						'prepend'	=> 'url(',
						'append'	=> ') center scroll no-repeat',
						'when'	=> array ( 'icon_type', '=', 'image' )
					)	
				)
			),
			array (
				'att_name' => 'bg_size',
				'type' => 'select',
				'label' => __( 'Background Size', 'tatsu' ),
				'visible' => array (
					'condition' => array (
						array('icon_type','=','image'),
						array('image','!=',''),
					),
					'relation'	=> 'and',
				),
				'options' => array (
					'cover' => 'Cover',
					'contain' => 'Contain',
					'initial' => 'Initial',
				),
				'default' => 'cover',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-icon_card-icon' => array(
						'property' => 'background-size',
						'when' => array (
							array('icon_type','=','image'),
							array('image','!=',''),
						),
						'relation' => 'and',
					),
				)
			),
			array (
				'att_name' => 'size',
				'type' => 'button_group',
				'label' => __( 'Icon Size', 'tatsu' ),
				'options' => array (
					'tiny'		=> 'Tiny',
					'small'		=> 'Small', 
					'medium'	=> 'Medium',
					'large'		=> 'Large',
					'x-large'	=> 'X Large'
				),
				'default' => 'medium',
				'tooltip' => ''
			),
			array (
				'att_name' => 'icon_style',
				'type' => 'button_group',
				'label' => __( 'Icon Style', 'tatsu' ),
				'options' => array (
					'circled'=> 'Circled', 
					'plain'=> 'Plain'
				),
				'default' => 'plain',
				'tooltip' => ''
			),
			array (
				'att_name' => 'icon_bg',
				'type' => 'color',
				'visible'	=> array (
					'relation'	=> 'and',
					'condition'	=> array (
						array ( 'icon_type', '!=', 'image' ),
						array ( 'icon_style', '=', 'circled' ),
					)
				),
				'options' => array(
					'gradient' => true,
				),
				'label' => __( 'Background Color of Icon if circled', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-icon_bg'	=> array (
						'property'		=> 'background',
						'when'			=> array (
							array ( 'icon_style', '=', 'circled' ),
							array ( 'icon_type', '!=', 'image' )
						),
						'relation'		=> 'and'
					)
				)
			),
			array (
				'att_name' => 'icon_color',
				'type' => 'color',
				'visible'	=> array ( 'icon_type', '=', 'icon' ),
				'options' => array(
					'gradient' => true,
				),
				'label' => __( 'Icon Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-icon'	=> array (
						'property'		=> 'color',
						'when'			=> array ( 'icon_type', '=', 'icon' )
					)
				)
			),
			array (
				'att_name'	=> 'svg_icon_color',
				'type' => 'color',
				'visible'	=> array ( 'icon_type', '=', 'svg' ),
				'label' => __( 'Icon Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css'	  => true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-icon_card-icon svg' => array (
						'property'		=> 'color',
						'when'			=> array ( 'icon_type', '=', 'svg' )
					)
				)	
			),
			array (
				'att_name'	=> 'line_animate',
				'type' => 'switch',
				'visible'	=> array ( 'icon_type', '=', 'svg' ),
				'label' => __( 'Enable Line Animation', 'tatsu' ),
				'default' => '0',
				'tooltip' => '',
			),
			array (
				'att_name'			=> 'box_shadow',
				'label'				=> __( 'Box Shadow', 'tatsu' ),
				'type'				=> 'input_box_shadow',
				'visible'			=> array (
					'relation'		=> 'or',
					'condition'		=> array (
						array ( 'icon_type', '=', 'image' ),
						array ( 'icon_style', '=', 'circled' )
					)	
				),
				'default'			=> '0px 0px 0px 0px rgba(0,0,0,0)',
				'css'				=> true,
				'selectors'			=> array (
					'.tatsu-{UUID} .tatsu-icon_card-icon' => array (
						'property'	=> 'box-shadow',
						'when'		=> array (
							array ( 'icon_type', '=', 'image' ),
							array ( 'icon_style', '=', 'circled' )
						),
						'relation'	=> 'or'
					)
				)

			),
			array (
				'att_name' => 'title',
				'type' => 'text',
				'label' => __( 'Title', 'tatsu' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name'	 => 'url',
				'type' => 'text',
				'label' => __( 'Url', 'tatsu' ),
				'default' => '',
				'tooltip' => ''
			),
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'	=> 'title_font',
				'type'		=> 'select',
				'label'		=> __( 'Title Font', 'tatsu' ),
				'default'	=> 'h6',
				'options'	=> typehub_get_exposed_selectors()
			) : false,
			array (
				'att_name' => 'title_color',
				'type' => 'color',
				'label' => __( 'Title Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'options'	=> array (
					'gradient'	=> true
				),
				'css'	=> true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-icon_card-title' => array (
						'property'		=> 'color',
					)
				)
			),
			array (
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => __( 'Caption', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
			),
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'	=> 'caption_font',
				'type'		=> 'select',
				'label'		=> __( 'Caption Font', 'tatsu' ),
				'default'	=> 'body',
				'options'	=> typehub_get_exposed_selectors()
			) : false,
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0 0 30px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array (
					'.tatsu-{UUID}.tatsu-module'	=> array (
						'property'		=> 'margin',
					)
				)
			),
			array (
				'att_name' => 'caption_color',
				'type' => 'color',
				'options'	=> array (
					'gradient'	=> true
				),
				'label' => __( 'Caption Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css'	 => true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-icon_card-caption' => array (
						'property'		=> 'color',
					)
				)
			),
			array (
				'att_name' => 'animate',
				'type' => 'switch',
				'label' => __( 'Enable Css Animation', 'tatsu' ),
				'default' => '0',
				'tooltip' => '',
			),
			array (
				'att_name'	=> 'animation_type',
				'type'		=> 'select',
				'label'		=> __( 'Enable Css Animation', 'tatsu' ),
				'default'	=> 'fadeIn',
				'tooltip'	=> '',
				'options'	=> tatsu_css_animations(),
				'visible'	=> array ( 'animate', '=', '1' )
			),
			array(
				'att_name' => 'animation_delay',
				'type' => 'slider',
				'options' => array(
					'min' => '0',
					'max' => '2000',
					'step' => '50',
					'unit' => 'ms',
				),
				'default' => '0',	        		
				'label' => __( 'Animation Delay', 'tatsu' ),
				'tooltip' => '',
				'visible' => array( 'animate', '=', '1' ),
			),
		) ) ),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'icon' => 'tatsu-icon-user', //need to replace this with a font loaded from tatsu
					'size' => 'medium',
					'url' => '#',
					'icon_color' 		=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					'svg_icon_color'	=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					'title' => 'John Doe',
					'title_font' => 'h6',
					'content' => 'Developer',
					'caption_font'	=> 'body',
					'horizontal_alignment'	=> 'left',
				)
			),
		),
	);
	tatsu_register_module( 'tatsu_icon_card', $controls );
	if( function_exists( 'tatsu_register_header_module' ) ) {
	tatsu_register_header_module( 'tatsu_icon_card', $controls, 'tatsu_icon_card' );
	}

}

add_action( 'tatsu_register_modules', 'tatsu_register_animated_link' );
function tatsu_register_animated_link() {
	$controls  =  array (
		'icon' => '',
		'title' => __( 'Animated Link', 'tatsu' ),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => true,
		'group_atts'	=> array (
			'link_text',
			'url',
			'new_tab',
			'link_style',
			array (
				'type' => 'accordion' ,
				'active' => array(0),
				'group' => array (
					array (
						'type'  => 'panel',
						'title' => __( 'Style', 'tatsu' ),
						'group'	=> array (
							'color',
							'hover_color',
							'line_color',
							'line_hover_color',
							'custom_font_size',
							'font_size',
							'alignment',
						)
					),
					array (
						'type'  => 'panel',
						'title' => __( 'Spacing and Alignment', 'tatsu' ),
						'group'	=> array (
							'margin',
						)
					),
					array (
						'type'  => 'panel',
						'title' => __( 'Animation', 'tatsu' ),
						'group'	=> array (
							'animate',
							'animation_type',
							'animation_delay',
						)
					)
				)
			),
		),
		'atts' => array_values( array_filter ( array (
			array (
				'att_name' => 'link_text',
				'type' => 'text',
				'label' => __( 'Animated Link Text', 'tatsu' ),
				'default' => 'Learn More',
				'tooltip' => ''
			),
			array (
				'att_name' => 'link_style',
				'type' => 'button_group',
				'label' => __( 'Link Style', 'tatsu' ),
				'options' => array (
				   'style1' => 'Style 1',
				   'style2' => 'Style 2',
				   'style3' => 'Style 3',
				   'style4' => 'Style 4',
				),
				'default' => 'style4',
				'tooltip' => ''
			),
			array (
				'att_name' => 'url',
				'type' => 'text',
				'label' => __( 'URL to be linked', 'tatsu' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name' => 'new_tab',
				'type' => 'switch',
				'label' => __( 'Open in a new tab', 'tatsu' ),
				'default' => '0',
				'tooltip' => '',
				'visible' => array( 'url', '!=', '' ),
			),
			array (
				'att_name' => 'custom_font_size',
				'type' => 'switch',
				'label' => __( 'Custom Font Size', 'tatsu' ),
				'default' => '0',
				'tooltip' => ''
			),
			array (
				'att_name' => 'font_size',
				'type' => 'number',
				'label' => __( 'Font Size', 'tatsu' ),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '13',
				'tooltip' => '',
				'css' => true,
				'visible'	=> array ( 'custom_font_size', '=', '1' ),
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-inner' => array(
						'property' => 'font-size',
						'append' => 'px',
						'when'	 => array ( 'custom_font_size', '=', '1' )
					),
				),
			), 	        	 								
			array (
				 'att_name' => 'alignment',
				 'type' => 'button_group',
				 'label' => __( 'Alignment', 'tatsu' ),
				 'options' => array (
					 'none' 	=> 'None',
					 'left' 	=> 'Left',
					 'center' 	=> 'Center',
					 'right' 	=> 'Right'
				 ),
				 'default' => 'none',
				 'tooltip' => ''
			 ),
			 array (
				'att_name' => 'color',
				'type' => 'color',
				'label' => __( 'Text Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-inner' => array(
						'property' => 'color'
					),
				),
			 ),
			  array (
				 'att_name' => 'hover_color',
				 'type' => 'color',
				 'label' => __( 'Hover Text Color', 'tatsu' ),
				 'default' => '',
				 'tooltip' => '',
				 'css' => true,
				 'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-inner:hover' => array(
						'property' => 'color',
						'when'	   => array( 'link_style', '!=', 'style2' )
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner::after' => array (
						'property'	=> 'color',
						'when'		=> array ( 'link_style', '=', 'style2' )
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner:hover .tatsu-animated-link-text' => array (
						'property'	=> 'color',
						'when'		=> array ( 'link_style', '=', 'style2' )
					)
				),
			 ),
			array (
				 'att_name' => 'line_color',
				 'type' => 'color',
				 'label' => __( 'Line/Arrow Color', 'tatsu' ),
				 'default' => '',
				 'tooltip' => '',
				 'css' => true,
				 'selectors' => array(
					'.tatsu-{UUID} .tatsu-animated-link-arrow' => array(
						'property' => 'color',
						'when'	  => array ( 'link_style', '=', 'style4' )	
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner::before' => array (
						'property'	=> 'color',
						'when'	  => array ( 'link_style', '!=', 'style4' )	
					),
				),
			 ),
			  array (
				 'att_name' => 'line_hover_color',
				 'type' => 'color',
				 'label' => __( 'Line/Arrow Hover Color', 'tatsu' ),
				 'default' => '',
				 'tooltip' => '',
				 'css' => true,
				 'selectors' => array (
					'.tatsu-{UUID} .tatsu-animated-link-inner:hover .tatsu-animated-link-arrow' => array(
						'property' => 'color',
						'when'	  => array ( 'link_style', '=', 'style4' )	
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner:hover::before' => array (
						'property'	=> 'color',
						'when'	  => array (
							array ( 'link_style', '=', 'style3' ),
							array( 'link_style', '=', 'style1' )
						),
						'relation'	=> 'or',
					),
					'.tatsu-{UUID} .tatsu-animated-link-inner::after' => array (
						'property'	=> 'color',
						'when'		=> array ( 'link_style', '=', 'style2' )
					)
				),
			 ),
			 array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0px 0px 40px 0px',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array (
					'.tatsu-{UUID}.tatsu-module'	=> array (
						'property'		=> 'margin',
					)
				)
			),
			 array (
				 'att_name' => 'animate',
				 'type' => 'switch',
				 'default' => 0,
				 'label' => __( 'Enable Css Animations', 'tatsu' ),
				 'tooltip' => ''
			 ),
			 array (
				 'att_name' => 'animation_type',
				 'type' => 'select',
				 'options' => tatsu_css_animations(),
				 'label' => __( 'Animation Type', 'tatsu' ),
				 'default' => 'fadeIn',
				 'tooltip' => '',
				 'visible' => array( 'animate', '=', '1' ),
			 ),
			 array(
				'att_name' => 'animation_delay',
				'type' => 'slider',
				'options' => array(
					'min' => '0',
					'max' => '2000',
					'step' => '50',
					'unit' => 'ms',
				),
				'default' => '0',	        		
				'label' => __( 'Animation Delay', 'tatsu' ),
				'tooltip' => '',
				'visible' => array( 'animate', '=', '1' ),
			),
		) ) ),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'link_text' => 'Learn More',
					'color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					'hover_color' => array( 'id' => 'palette:2', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
					'line_hover_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),       			
				),
			)
		),
	);
	tatsu_remap_modules( array( 'tatsu_animated_link', 'oshine_animated_link' ), $controls, 'tatsu_animated_link' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_gallery', 9);
function tatsu_register_gallery() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#gallery',
		'title' => __( 'Gallery', 'tatsu' ),
		'is_js_dependant' => true,
		'type' => 'single',
		'should_autop' => false,
		'is_built_in' => false,
		'group_atts' => array(
			'image_source',
			'ids',
			'account_name',
			'count',
			array (
				'type' => 'accordion' ,
				'active' => array(0),
				'group' => array (
					array (
						'type' => 'panel',
						'title' => __( 'Layout Controls', 'tatsu' ),
						'group' => array (
							'columns',
							'gutter_style',
							'gutter_width',
							'masonry',
							'margin'
						)
                    ),	
                    array (
						'type' => 'panel',
						'title' => __( 'Loading Options', 'tatsu' ),
						'group' => array (
							'lazy_load',
							'delay_load',
							'placeholder_color',
                            'items_per_load',
                            'initial_load_style'
						)
                    ),
                    array (
						'type' => 'panel',
						'title' => __( 'Styles & Colors', 'tatsu' ),
						'group' => array (
							'hover_show_title',
							'hover_content_color',
							'overlay_color',
						)
                    ),
                ),
            ),
            'cat_hide',
        ),
		'atts' => array (
			array (
				'att_name' => 'image_source',
				'type' => 'select',
				'label' => __( 'Image Source', 'tatsu' ),
				'options' => array (
					'selected' => 'Selected Images',
					'instagram' => 'Instagram',
					'flickr' => 'Flickr', 
				),
				'default'=> 'selected',
				'tooltip' => ''
			),
			array (
				'att_name' => 'ids',
				'type' => 'multi_image_picker',
				'label' => __( 'Upload / Select Gallery Images', 'tatsu' ),
				'tooltip' => '',
				'visible' => array( 'image_source', '=', 'selected' ),
			),
			array (
				'att_name' => 'account_name',
				'type' => 'text',
				'label' => __( 'Account Name', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'hidden' => array( 'image_source', '=', 'selected' ),
			),
			array (
				'att_name' => 'count',
				'type' => 'slider',
				'label' => __( 'Images Count', 'tatsu' ),
				'options' => array(
					'min' => '1',
					'max' => '20',
					'step' => '1',
				),
				'default' => '10',
				'tooltip' => '',
				'hidden' => array( 'image_source', '=', 'selected' ),
			),		        	
			array (
				'att_name' => 'columns',
				'type' => 'button_group',
				'label' => __( 'Number of Columns', 'tatsu' ),
				'options'=> array (
					'1' => 'One',
					'2' => 'Two',
					'3' => 'Three',
					'4' => 'Four',
					'5' => 'Five', 
				),
				'default' => '3',
				'tooltip' => ''
			),
			array (
				'att_name' => 'lazy_load',
				'type' => 'switch',
				'label' => __( 'Enable Lazy Load', 'tatsu' ),
				'default' => 0,
				'tooltip' => 'Lazy Load'
			),
			array (
				'att_name' => 'delay_load',
				'type' => 'switch',
				'label' => __( 'Reveal items only on scroll', 'tatsu' ),
				'default' => 1,
				'tooltip' => 'Delay Load Grid'
			),
			array (
				'att_name' => 'placeholder_color',
				'type' => 'color',
				'label' => __( 'Grid Placeholder Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-gallery-module .gallery-thumb-img-wrap' =>array(
						'property' => 'background-color',
					),
				), 
			),	
			array (
				'att_name' => 'items_per_load',
				'type' => 'text',
				'label' => __( 'Items To Load', 'tatsu' ),
				'default' => '9',
				'tooltip' => ''
			),
			array (
				'att_name' => 'gutter_style',
				'type' => 'select',
				'label' => __( 'Gutter Style', 'tatsu' ),
				'options' => array (
					'style1' => 'With Margin',
					'style2' => 'Without Margin',
				),
				'default' => 'style2',
				'tooltip' => ''
			),
			array (
				'att_name' => 'gutter_width',
				'type' => 'number',
				'label' => __('Gutter Width','tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '40',
				'tooltip' => '',
				'css' => true,
                'selectors' => array(
                    '.tatsu-{UUID} .gallery-container' => array(
                        'property' => 'margin',
                        'prepend' => '0 -',
                        'append' => 'px',
                        'operation' => array( '/', 2 ),
                        'when' => array( 'gutter_style','=','style2' ),
                    ),
                    '.tatsu-{UUID}.tatsu-gallery-wrap .gallery-container ' => array(
                        'property' => 'padding',
                        'prepend' => '0 ',
                        'append' => 'px',
                        'operation' => array( '/', 2 ),
                        'when' => array( 'gutter_style','=','style1' ),
                    ),
                    '.tatsu-{UUID} .gallery-container .gallery-cell.be-col' => array(
                        'property' => 'margin-bottom',
                        'append' => 'px'
                    ),
                    '.tatsu-{UUID} .gallery-container .gallery-cell.be-col ' => array(
                        'property' => 'padding',
                        'prepend' => '0 ',
                        'append' => 'px',
                        'operation' => array( '/', 2 ),
					),
					'.tatsu-{UUID}.tatsu-gallery-module .gallery-container ' => array(
						'property' => 'margin-bottom',
						'prepend' => '-',
                        'append' => 'px !important'
                    ),
                ),
			),
			array (
				'att_name' => 'masonry',
				'type' => 'switch',
				'label' => __( 'Enable Masonry Layout', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			),
			array (
				'att_name' => 'initial_load_style',
				'type' => 'select',
				'label' => __( 'Image Load Animation', 'tatsu' ),
				'options' => array (
					'init-slide-left' => 'Slide Left',
					'init-slide-right' => 'Slide Right',
					'init-slide-top' => 'Slide Top',
					'init-slide-bottom' => 'Slide Bottom',
					'init-scale' => 'Scale',
					'fadeIn' => 'Fade In',
					'none' => 'None',
				),
				'default' => 'fadeIn',
				'tooltip' => ''
			),
			array (
				'att_name' => 'hover_show_title',
				'type' => 'switch',
				'label' => __( 'Show Title On Hover', 'tatsu' ),
				'default' => '0',
				'tooltip' => ''
			),	        	
			array (
				'att_name' => 'hover_content_color',
				'type' => 'color',
				'label' => __( 'Title Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'visible' => array('hover_show_title', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-gallery-module .thumb-title' =>array(
						'property' => 'color',
					),
				), 
			),
			array (
				'att_name' => 'overlay_color',
				'type' => 'color',
				'label' => __( 'Thumbnail Overlay Color', 'tatsu' ),
				'options'		=> array (
					'gradient'	=> true
				),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-gallery-module .thumb-bg' =>array(
						'property' => 'background-color',
					),
				),
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0 0 60px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-module'	=> array (
						'property'		=> 'margin',
					)
				)
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'initial_load_style' => 'fadeIn',
					'overlay_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					'hover_content_color' => '#fff',
				),
			)
		),
	);
	tatsu_register_module( 'gallery', $controls, 'tatsu_gallery' );
	tatsu_remap_modules( array('tatsu_gallery', 'gallery', 'oshine_gallery' ), $controls, 'tatsu_gallery' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_wp_menu_links' );
function tatsu_register_wp_menu_links() {

	$controls = array (
        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#vertical_nav_menu',
        'title' => __( 'Navigation Menu', 'tatsu' ),
        'is_js_dependant' => false,
        'type' => 'single',
		'is_built_in' => false,
		'inline' => false,
		'builder_layout' => 'column',
		'atts' => array (
			array (
				'att_name' => 'menu_name',
				'type' => 'select',
				'label' => __( 'Menu Name', 'oshine-modules' ),
				'options' => tatsu_header_get_menu_list()[0],
				'tooltip' => '',
				'default' =>  tatsu_header_get_menu_list()[1]
			), 
			array (
				'att_name' => 'menu_style',
				'type' => 'select',
				'label' => __( 'Menu Name', 'oshine-modules' ),
				'options' => array(
					'vertical' => 'Vertical',
					'horizontal' => 'Horizontal'
				),
				'tooltip' => '',
				'default' =>  'vertical'
			), 
			array (
				'att_name' => 'wrap_alignment',
				'type' => 'button_group',
				'label' => __( 'Alignment', 'tatsu' ),
				'options' => array (
					'left' => 'Left',
					'center' => 'Center',	        			
					'right' => 'Right',
				),
				'css' => true,
				'responsive' => true,
				'selectors' => array(
						'.tatsu-{UUID} .tatsu-menu-widget' => array(
							'property' => 'text-align'
						),
					),
				'default' => 'left',
				'tooltip' => '',
			),  
			array (
				'att_name' => 'menu_color',
				'type' => 'color',
				'label' => __( 'Menu Color', 'tatsu' ),
				'default' => 'rgba(34,147,215,1)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-menu-widget a' => array(
						'property' => 'color',
					),
				),	
			),
			array (
				'att_name' => 'menu_hover_color',
				'type' => 'color',
				'label' => __( 'Menu Hover Color', 'tatsu' ),
				'default' => 'rgba(34,147,215,1)',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-menu-widget a:hover' => array(
						'property' => 'color',
					),
				)
			),	
			array (
				'att_name' => 'show_arrow',
				'type' => 'switch',
				'default' => 1,
				'label' => __( 'Show Arrow', 'tatsu' ),
				'tooltip' => ''
			),
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'	=> 'link_font',
				'type'		=> 'select',
				'label'		=> __( 'Title Font', 'tatsu' ),
				'default'	=> 'body',
				'options'	=> typehub_get_exposed_selectors()
			) : false,
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0 0 30px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array (
					'.tatsu-{UUID}.tatsu-module'	=> array (
						'property'		=> 'margin',
					)
				)
			),
			array (
				'att_name' => 'hide_in',
				'type' => 'screen_visibility',
				'label' => __( 'Hide in', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
			),
		),
	);
	tatsu_register_module( 'tatsu_wp_menu_links', $controls );
}

/*------------------------------------------------------
						Tatsu - Team
------------------------------------------------------*/
add_action( 'tatsu_register_modules', 'tatsu_register_team');
function tatsu_register_team() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#team',
	        'title' => __( 'Team','tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
			'group_atts'	=> array (
				'title',
				'designation',
				'style',
				'image',
				array (
					'type' => 'accordion' ,
					'active' => 'none',
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'title_color',
								'name_hover_color',
								'designation_color',
								'designation_hover_color',
								'icon_color',
								'icon_hover_color',
								'overlay_color',
								'name_font',
								'designation_font',
								'margin',
							),
						),
						array (
							'type'		=> 'panel',
							'title'		=> __( 'Social Icons', 'tatsu' ),
							'group'		=> array (
								'facebook',
								'twitter',
								'google_plus',
								'instagram',
								'linkedin',
								'email'
							),
						),
						array (
							'type'		=> 'panel',
							'title'		=> __( 'Advanced', 'tatsu' ),
							'group'		=> array (
								'vertical_alignment',
								'title_alignment_static',
								'lazy_load',
								'lazy_load_bg',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay'
							)
						),
					)
				),
			),
	        'atts' => array_values( array_filter( array (
				array (
					'att_name'	=> 'style',
					'type'	=> 'button_group',
					'label'	=> __( 'Style', 'tatsu' ),
					'options'	=> array (
						'style1'	=> 'Style 1',
						'style2'	=> 'Style 2' 
					),
					'default'	=> 'style1'
				),
				array (
					'att_name' => 'title',
					'type' => 'text',
					'label' => __( 'Name', 'tatsu' ),
					'default' => '',
					'tooltip' => 'Name or Title for the Team Member'
				),
				array (
					'att_name' => 'designation',
					'type' => 'text',
					'label' => __( 'Designation', 'tatsu' ),
					'default' => '',
					'tooltip' => 'Designation of the Team Member'
				),
				array (
					'att_name' => 'image',
					'type' => 'single_image_picker',
					'label' => __( 'Image', 'tatsu' ),
					'tooltip' => '',
				),
				array (
					'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
					'label' => __( 'Name Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-team-member-name' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'name_hover_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
					'label' => __( 'Name Hover Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-team-member-name:hover' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'designation_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
					'label' => __( 'Designation Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-team-member-designation' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'designation_hover_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
					'label' => __( 'Designation Hover Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-team-member-designation:hover' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'facebook',
					'type' => 'text',
					'label' => __( 'Facebook', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'twitter',
					'type' => 'text',
					'label' => __( 'Twitter', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'google_plus',
					'type' => 'text',
					'label' => __( 'Google Plus', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'instagram',
					'type' => 'text',
					'label' => __( 'Instagram', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'linkedin',
					'type' => 'text',
					'label' => __( 'LinkedIn', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'email',
					'type' => 'text',
					'label' => __( 'Email', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'icon_color',
					'type' => 'color',
					'label' => __( 'Icon Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-team-member-social-icon i' => array(
							'property' => 'color',
							'when' => array('icon_color', 'notempty'),
						),
					),
				),
				array (
					'att_name' => 'icon_hover_color',
					'type' => 'color',
					'label' => __( 'Icon Hover Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-team-member-social-icon:hover i' => array(
							'property' => 'color',
							'when' => array('icon_hover_color', 'notempty'),
						),
					),
				),
				array (
					'att_name' => 'vertical_alignment',
					'type' => 'button_group',
					'label' => __( 'Vertical alignment', 'tatsu' ),
					'options' => array(
						'flex-start' => 'Top',
						'center' => 'Center',
						'flex-end' => 'Bottom'
					),
					'default' => 'center',
					'tooltip' => '',
					'css' => true,
					'hidden' => array( 'style', '=', 'style2' ),
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-team-overlay' => array(
							'property' => 'align-items',
						),
					),
				),
				array (
					'att_name' => 'title_alignment_static',
					'type' => 'button_group',
					'label' => __( 'Horizontal alignment', 'tatsu' ),
					'options' => array(
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right'
					),
					'default' => 'center',
					'tooltip' => '',
				),
				array (
					'att_name' => 'overlay_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
					'label' => __( 'Overlay Color', 'tatsu' ),
					'default' => '',	//color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-team-overlay' => array(
							'property' => 'background',
						),
					),
				),
				array (
					'att_name' => 'animate',
					'type' => 'switch',
					'label' => __( 'Enable CSS Animation', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
				),
				array (
					'att_name' => 'lazy_load',
					'type' => 'switch',
					'label' => __( 'Enable Lazy Load', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
				),
				array (
					'att_name' => 'lazy_load_bg',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
					'label' => __( 'Lazy Load Background', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-lazy-load-placeholder' => array(
							'property' => 'background',
						),
					),
				),
				array (
					'att_name' => 'animation_type',
					'type' => 'select',
					'label' => __( 'Animation Type', 'tatsu' ),
					'options' => tatsu_css_animations(),
					'default' => 'fadeIn',
				),
				array (
					'att_name' => 'animation_delay',
					'type' => 'slider',
					'options' => array(
						'min' => '0',
						'max' => '2000',
						'step' => '50',
						'unit' => 'ms',
					),
					'default' => '0',	        		
					'label' => __( 'Animation Delay', 'tatsu' ),
					'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
				function_exists( 'typehub_get_exposed_selectors' ) ?  array (
					'type'	=> 'select',
					'att_name'	=> 'name_font',
					'options'	=> typehub_get_exposed_selectors(),
					'label'		=> __( 'Name Font', 'tatsu' ),
					'default'	=> 'h6',
					'tooltip'	=> ''
				) : false,
				function_exists( 'typehub_get_exposed_selectors' ) ? array (
					'type'	=> 'select',
					'att_name'	=> 'designation_font',
					'options'	=> typehub_get_exposed_selectors(),
					'label'		=> __( 'Designation Font', 'tatsu' ),
					'default'	=> 'h9',
					'tooltip'	=> ''
				) : false,
				array (
					'att_name'		=> 'margin',
					'type'			=> 'input_group',
					'label'			=> __( 'Margin', 'tatsu' ),
					'default'		=> '0 0 20px 0',
					'tooltip'		=> '',
					'css'			=> true,
					'responsive'	=> true,
					'selectors'		=> array (
						'.tatsu-{UUID}.tatsu-module' => array (
							'property'	=> 'margin',
						)
					)	
				),
			) ) ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'title' => 'John Doe',
						'title_color'	=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'designation' => 'Designer',
						'designation_color'	=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'image' => 'http://placehold.it/400x400',
						'facebook' => '#',
						'twitter' => '#',
						'linkedin' => '#',
						'email' => '#',
						'icon_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'overlay_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' )),
					)
				),
			),
	);
	tatsu_remap_modules( array( 'tatsu_team', 'team' ), $controls, 'tatsu_team' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_tabs');
function tatsu_register_tabs() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#tabs',
	        'title' => __( 'Tabs', 'tatsu' ),
	        'is_js_dependant' => true,
	        'child_module' => 'tatsu_tab',
	        'type' => 'multi',
	        'initial_children' => 2,
			'is_built_in' => true,
			'group_atts' => array(
				'style',
				'margin',
				array (
					'type' => 'accordion' ,
					'active' => array(0),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Colors', 'tatsu' ),
							'group' => array (
								'title_color',
								'background_color',
								'active_title_color',
								'active_background_color',
								'border_color'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay',
							)
						),	
					),
				),
			),
	        'atts' => array_values( array_filter( array (
				array (
                    'att_name' => 'style',
                    'type' => 'button_group',
                    'label' => __( 'Tab Style', 'tatsu' ),
                    'options' => array (
                        'style1' 	=> 'Style 1',
                        'style2' 	=> 'Style 2',
                        'style3' 	=> 'Style 3',
                        'style4' 	=> 'Style 4',
                    ),
                    'default' => 'style1',
                    'tooltip' => ''
				),	
				array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __('Title Color','tatsu'),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID} .ui-state-default' => array(
						  'property' => 'color',
					  ),
				  ),
				),
				array (
		            'att_name' => 'background_color',
		            'type' => 'color',
		            'label' => __('Background Color','tatsu'),
		            'default' => '',
					'tooltip' => '',
					'visible' => array (
						'condition' => array(
							array( 'style', '!=', 'style1' ),
							array( 'style', '!=', 'style3' )
						),
						'relation'	=> 'and',
					),
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID} .ui-state-default' => array(
						  'property' => 'background',
						  'when' => array(
							array( 'style', '=', 'style2' ),
							array( 'style', '=', 'style4' ),
						  ),
						  'relation' => 'or',
					  )
				  ),
				),
				array (
		            'att_name' => 'active_title_color',
		            'type' => 'color',
		            'label' => __('Active Title Color','tatsu'),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID} .ui-state-default.ui-tabs-active' => array(
						  'property' => 'color',
					  ),
				  ),
				),
				array (
		            'att_name' => 'active_background_color',
		            'type' => 'color',
		            'label' => __('Active Background Color','tatsu'),
		            'default' => '',
					'tooltip' => '',
					'visible' => array( 'style', '!=', 'style1' ),
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID} .ui-state-default.ui-tabs-active' => array(
						  'property' => 'background',
						  'when' => array( 'style', '!=', 'style1' )
					  	),
				  	),
				),
				array (
					'att_name' => 'border_color',
					'type'	   => 'color',
					'label'		=> __( 'Border Color', 'tatsu' ),
					'default'	=> '#d8d8d8',
					'tooltip'	=> '',
					'visible'	=> array ( 
						'style', '=' , 'style1'
					),
					'css'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID} .ui-tabs .ui-tabs-nav' => array (
							'property'	=> 'border-color',
							'when'		=> array (
								'style', '=', 'style1'
							),
						),
					),
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0 0 60px 0',
					'tooltip' => '',
					'css'	  => true,
					'responsive'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID}.tatsu-module'	=> array (
							'property'		=> 'margin',
						)
					)
				),
				 array (
					 'att_name' => 'animate',
					 'type' => 'switch',
					 'default' => 0,
					 'label' => __( 'Enable Css Animations', 'tatsu' ),
					 'tooltip' => ''
				 ),
				 array (
					 'att_name' => 'animation_type',
					 'type' => 'select',
					 'options' => tatsu_css_animations(),
					 'label' => __( 'Animation Type', 'tatsu' ),
					 'default' => 'fadeIn',
					 'tooltip' => '',
					 'visible' => array( 'animate', '=', '1' ),
				 ),
				 array(
					'att_name' => 'animation_delay',
					'type' => 'slider',
					'options' => array(
						'min' => '0',
						'max' => '2000',
						'step' => '50',
						'unit' => 'ms',
					),
					'default' => '0',	        		
					'label' => __( 'Animation Delay', 'tatsu' ),
					'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
			) ) ),
			'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'style'		=> 'style2',
						'title_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'background_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'active_title_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'active_background_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),


	    );
		tatsu_remap_modules( array( 'tatsu_tabs', 'tabs' ), $controls, 'tatsu_tabs' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_tab');
function tatsu_register_tab() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Tab', 'tatsu' ),
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	        		array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Tab Title', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Choose icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Tab Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title' => 'Tab Title',
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.'
	        		),
	        	)
	        ),
	    );
		tatsu_remap_modules( array( 'tatsu_tab', 'tab' ), $controls, 'tatsu_tab' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_accordion');
function tatsu_register_accordion() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#accordion',
		'title' => __( 'Accordion Toggles', 'tatsu' ),
		'is_js_dependant' => true,
		'child_module' => 'tatsu_toggle',
		'allowed_sub_modules' => array( 'tatsu_toggle' ),
		'type' => 'multi',
		'initial_children' => 3,
		'is_built_in' => true,
		'group_atts' => array(
			'style',
			'collapsed',
			'margin',
			array (
				'type' => 'accordion' ,
				'active' => array(0),
				'group' => array (
					array (
						'type' => 'panel',
						'title' => __( 'Colors', 'tatsu' ),
						'group' => array (
							'title_color',
							'title_hover_color',
							'content_bg_color',
							'border_color',
						)
					),
					array (
						'type' => 'panel',
						'title' => __( 'Fonts', 'tatsu' ),
						'group' => array (
							'title_font',
							'content_font',
						)
					),
					array (
						'type' => 'panel',
						'title' => __( 'Animation', 'tatsu' ),
						'group' => array (
							'animate',
							'animation_type',
							'animation_delay',
						)
					),	
				),
			),
		),
		'atts' => array_values( array_filter( array (
			array (
				'att_name' => 'style',
				'type' => 'button_group',
				'label' => __( 'Accordion Style', 'tatsu' ),
				'options'	=> array (
					'style1' => 'Style1',
					'style2' => 'Style 2',
				),
				'default' => 'style1',
				'tooltip' => '',
			),
			array (
				'att_name' => 'collapsed',
				'type' => 'switch',
				'label' => __( 'Collapse content', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			),
			array (
				'att_name' => 'title_color',
				'type' => 'color',
				'label' => __( 'Title Color', 'tatsu' ),
				'default' => '',//sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .accordion-head' => array(
						'property' => 'color',
					),
				),	
			),
			array (
				'att_name' => 'title_hover_color',
				'type' => 'color',
				'label' => __( 'Title Hover Color', 'tatsu' ),
				'default' => '',//sec_color
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .accordion-head:hover' => array(
						'property' => 'color',
					),
				),	
			),
			array (
				'att_name' => 'content_bg_color',
				'type' => 'color',
				'label' => __( 'Content Background Color', 'tatsu' ),
				'default' => '',//sec_bg
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .accordion-content-inner' => array(
						'property' => 'background',
					),
				),
			),
			array (
				'att_name' => 'border_color',
				'type' => 'color',
				'label' => __( 'Border Color', 'tatsu' ),
				'default' => '',//sec_bg
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .accordion-content.ui-accordion-content' => array(
						'property' => 'border-color'
					),
					'.tatsu-{UUID} .accordion-head.ui-accordion-header'	=> array (
						'property'	=> 'border-color'
					)
				),
			),
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'	=> 'title_font',
				'type'		=> 'select',
				'label'		=> __( 'Title Font', 'tatsu' ),
				'options'	=> typehub_get_exposed_selectors(),
				'default'	=> 'h6',
				'tooltip'	=> ''
			) : false,
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'	=> 'content_font',
				'type'		=> 'select',
				'label'		=> __( 'Content Font', 'tatsu' ),
				'options'	=> typehub_get_exposed_selectors(),
				'default'	=> 'body',
				'tooltip'	=> ''
			) : false,
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0 0 60px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array (
					'.tatsu-{UUID}.tatsu-module'	=> array (
						'property'		=> 'margin',
					)
				)
			),
			array (
				'att_name' => 'animate',
				'type' => 'switch',
				'default' => 0,
				'label' => __( 'Enable Css Animations', 'tatsu' ),
				'tooltip' => ''
			),
			array (
				'att_name' => 'animation_type',
				'type' => 'select',
				'options' => tatsu_css_animations(),
				'label' => __( 'Animation Type', 'tatsu' ),
				'default' => 'fadeIn',
				'tooltip' => '',
				'visible' => array( 'animate', '=', '1' ),
			),
			array(
			   'att_name' => 'animation_delay',
			   'type' => 'slider',
			   'options' => array(
				   'min' => '0',
				   'max' => '2000',
				   'step' => '50',
				   'unit' => 'ms',
			   ),
			   'default' => '0',	        		
			   'label' => __( 'Animation Delay', 'tatsu' ),
			   'tooltip' => '',
			   'visible' => array( 'animate', '=', '1' ),
		   ),
		) ) ),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'border_color'	=> '#CACACA'
				),
			)
		),  
	);
	tatsu_remap_modules( array( 'tatsu_accordion', 'accordion' ), $controls, 'tatsu_accordion' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_toggle');
function tatsu_register_toggle() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Toggle', 'tatsu' ),
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => false,
		'atts' => array (
			array (
				'att_name' => 'title',
				'type' => 'text',
				'label' => __( 'Accordian Title', 'tatsu' ),
				'default' => '',
				'tooltip' => ''
			),
			array (
				'att_name' => 'content',
				'type' => 'tinymce',
				'label' => __( 'Accordian Content', 'tatsu' ),
				'default' => '',
				'tooltip' => ''
			),	
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'title' => 'Here goes your title',
					'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.'
				),
			)
		),  
	);
	tatsu_remap_modules( array( 'tatsu_toggle', 'toggle' ), $controls, 'tatsu_toggle' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_special_heading' );
if( !function_exists( 'tatsu_register_special_heading' ) ) {
	function tatsu_register_special_heading() {
		$controls = array(
			'icon' 				=> TATSU_PLUGIN_URL . '/builder/svg/modules.svg#special_title',
			'title' 			=> __( 'Special Title', 'tatsu' ),
			'is_js_dependant' 	=> false,
			'type' 				=> 'single',
			'is_built_in' 		=> true,
			'group_atts' => array(
				array (
					'type' => 'accordion' ,
					'active' => array(0),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Title Settings', 'tatsu' ),
							'group' => array (
								'title_content',
								'font_size',
								'letter_spacing',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Colors', 'tatsu' ),
							'group' => array (
								'title_color',
								'border_color',
								'title_hover_color'
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Header Options', 'tatsu' ),
							'group' => array (
								'border_style',
								'expand_border',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Alignments', 'tatsu' ),
							'group' => array (
								'alignment',
								'margin',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Animation', 'tatsu' ),
							'group' => array (
								'animate',
								'animation_type',
								'animation_delay',
							)
						),	
					),
				),
			),
			'atts' 				=> array(
				array(
					'att_name'		=> 'title_content',
					'type'			=> 'text',
					'label'			=> __( 'Title', 'tatsu' ),
					'default'		=> '',
					'tooltip'		=> ''
				),
				array(
					'att_name'		=> 'border_style',
					'type' 			=> 'button_group',
					'label'			=> __('Style', 'tatsu'),
					'options'		=> array(
						'style1'		=> 'Style 1',
						'style2'		=> 'Style 2',
						'style3'		=> 'Style 3',
						'style4'		=> 'Style 4',
					),
					'default'		=> 'style1',
					'tooltip'		=> ''		
				),
				array(
					'att_name' 		=> 'font_size',
					'type'			=> 'slider',
					'label'			=> __( 'Font Size', 'tatsu' ),
					'options'		=> array(
						'min'				=> 8,
						'max'				=> 100,
						'unit'				=> 'px',
						'add_unit_to_value'	=> true,
						'step'				=> 1
					),
					'default'		=> 13,
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap' => array(
							'property' => 'font-size',	
						),
					),
				),
				array(
					'att_name'		=> 'letter_spacing',
					'type'			=> 'slider',
					'label'			=> __('Letter Spacing', 'tatsu'),
					'options'		=> array (
						'min'				=> 0,
						'max'				=> 10,
						'unit'				=> 'px',
						'add_unit_to_value'	=> true,
						'step'				=> 1
					),
					'default'		=> '2px',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap .tatsu-title' =>array(
							'property' => 'letter-spacing',
						),
					),
				),
				array(
					'att_name'		=> 'margin',
					'type'			=> 'input_group',
					'label'			=> __( 'Margin', 'tatsu' ),
					'default'		=> '0px 0px 20px 0px',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap' =>array(
							'property' => 'margin'
						),
					),
				),
				array(
					'att_name'		=> 'title_color',
					'type' 			=> 'color',
					'label'			=> __( 'Title Color', 'tatsu' ),
					'default'		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap .tatsu-title' =>array(
							'property' => 'color'
						),
					),

				),
				array(
					'att_name'		=> 'border_color',
					'type'			=> 'color',
					'label'			=> __( 'Border/Label Color', 'tatsu' ),
					'default' 		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap .tatsu-border' =>array(
							'property' => 'background',
						),
					),
				),
				array(
					'att_name'		=> 'expand_border',
					'type'			=> 'switch',
					'label'			=> __('Expand on Hover', 'tatsu'),
					'default'		=> 0,
					'tooltip'		=> ''
				),
				array(
					'att_name'		=> 'title_hover_color',
					'type'			=> 'color',
					'label'			=> __( 'Title Hover Color', 'tatsu' ),
					'default'		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap .special-heading-inner-wrap:hover .tatsu-title' =>array(
							'property' => 'color'
						),
					),
				),
				array(
					'att_name'		=> 'alignment',
					'type'			=> 'button_group',
					'label'			=> __( 'Alignment', 'tatsu' ),
					'options'		=> array(
						'left'		=> 'Left',
						'center'	=> 'Center',
						'right'		=> 'Right'
					),
					'default'		=> 'left',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-special-heading-wrap' =>array(
							'property' => 'text-align',
						),
					),
				),
				 array (
					 'att_name' => 'animate',
					 'type' => 'switch',
					 'default' => 0,
					 'label' => __( 'Enable Css Animations', 'tatsu' ),
					 'tooltip' => ''
				 ),
				 array (
					 'att_name' => 'animation_type',
					 'type' => 'select',
					 'options' => tatsu_css_animations(),
					 'label' => __( 'Animation Type', 'tatsu' ),
					 'default' => 'fadeIn',
					 'tooltip' => '',
					 'visible' => array( 'animate', '=', '1' ),
				 ),
				 array(
					'att_name' => 'animation_delay',
					'type' => 'slider',
					'options' => array(
						'min' => '0',
						'max' => '2000',
						'step' => '50',
						'unit' => 'ms',
					),
					'default' => '0',	        		
					'label' => __( 'Animation Delay', 'tatsu' ),
					'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),	
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'title_content' => __('HEADING', 'tatsu' ),
						'border_style' => 'style2',
						'border_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'expand_border' => '1',
						'letter_spacing' => '2px',
						'font_size' => '13',	        			
	        		),
	        	)
	        ),			
		);
		tatsu_remap_modules( array( 'tatsu_special_heading', 'be_special_heading6' ), $controls, 'tatsu_special_heading');
	} 
}
add_action( 'tatsu_register_modules', 'tatsu_register_interactive_box');
function tatsu_register_interactive_box() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#interactive_box',
	        'title' => __( 'Interactive Box', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
			'is_built_in' => true,
			'type'	=> 'single',
			'group_atts'	=> array (
				'title',
				'url',
				'new_tab',
				'content',
				'icon',
				'svg_icon',
				'style',
				array (
					'type'		=> 'accordion',
					'active'	=> 'none',
					'group'		=> array (
						array (
							'type'		=> 'panel',
							'title'		=> __( 'Colors', 'tatsu' ),
							'group'		=> array (
								'title_color',
								'title_hover_color',
								'icon_color',
								'icon_hover_color',
								'content_color',
								'content_hover_color',
								'arrow_color',
							),
						),
						array (
							'type'		=> 'panel',
							'title'		=> __( 'Background', 'tatsu' ),
							'group'		=> array (
								'bg_color',
								'hover_bg_color',
								'bg_image',
								'overlay',
								'overlay_color',
							),
						),
						array (
							'type'		=> 'panel',
							'title'		=> __( 'Spacing and Other Styles', 'tatsu' ),
							'group'		=> array (
								'icon_size',
								'alignment',
								'custom_height',
								'height',
								'vertical_alignment',
								'border_radius',
								'box_shadow',
								'title_font',
								'margin'
							),
						),
						array (
							'type'		=> 'panel',
							'title'		=> __( 'Animation', 'tatsu' ),
							'group'		=> array (
								'animate',
								'animation_type',
								'animation_delay',
							)
						),
					)
				)
			),
	        'atts' => array_values( array_filter( array (
                array (
                    'att_name' => 'style',
                    'type' => 'button_group',
                    'label' => __( 'Box Style', 'tatsu' ),
                    'options' => array (
                        'flip' 		=> '3D Flip',
						'stacked' 	=> 'Stacked',
						'transform'	=> 'Offset'	
                    ),
                    'default' => 'stacked',
                    'tooltip' => ''
				),
                array (
                    'att_name' => 'alignment',
                    'type' => 'button_group',
                    'label' => __( 'Alignment', 'tatsu' ),
                    'options' => array (
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    ),
                    'default' => 'center',
                    'tooltip' => ''
				),
	            array (
	        		'att_name' => 'url',
	        		'type' => 'text',
	        		'label' => __( 'URL to be linked', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				),
				array (
					'att_name' => 'bg_image',
					'type' => 'single_image_picker',
					'label' => __( 'Background Image', 'tatsu' ),
					'tooltip' => '',
					'css' => true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-interactive-box-front' 		=> array (
							'property'	=> 'background-image',
							'when'		=> array ( 'style', '=', 'flip' )
						),
						'.tatsu-{UUID} .tatsu-interactive-box-back'  		=> array (
							'property'	=> 'background-image',
							'when'		=> array ( 'style', '=', 'flip' )
						),
						'.tatsu-{UUID} .tatsu-interactive-box-image-holder' => array (
							'property'	=> 'background',
							'when'		=> array ( 'style', '=', 'stacked' ),
							'prepend'	=> 'url(',
							'append' 	=> ') center/cover scroll'
						),
						'.tatsu-{UUID} .tatsu-interactive-box-stacks::before' => array (
							'property'	=> 'background',
							'when'		=> array ( 'style', '=', 'stacked' ),
							'prepend'	=> 'url(',
							'append' 	=> ') center/cover scroll'
						),
						'.tatsu-{UUID} .tatsu-interactive-box-stacks::after' => array (
							'property'	=> 'background',
							'when'		=> array ( 'style', '=', 'stacked' ),
							'prepend'	=> 'url(',
							'append' 	=> ') center/cover scroll'
						),
						'.tatsu-{UUID}.tatsu-interactive-box-transform'		=> array (
							'property'	=> 'background',
							'when'		=> array ( 'style', '=', 'transform' ),
							'prepend'	=> 'url(',
							'append' 	=> ') center/cover scroll'
						)
					)
				),
				array (
					'att_name'		=> 'overlay',
					'type'			=> 'switch',
					'label'			=> __( 'Enable Overlay', 'tatsu' ),
					'hidden'		=> array ( 'bg_image', '=', '' ),
					'default'		=> '0'
				),
				array (
					'att_name'		=> 'new_tab',
					'type'			=> 'switch',
					'label'			=> __( 'Open in new tab', 'tatsu' ),
					'default'		=> '0'
				),
				array( 
					'att_name'		=> 'overlay_color',
					'type'			=> 'color',
					'options'		=> array (
						'gradient'	=> true
					),
					'label'			=> __( 'Overlay Color', 'tatsu' ),
					'hidden'		=> array ( 'bg_image', '=', '' ),
					'css'			=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-interactive-box-overlay::before' => array (
							'property'	=> 'background',
							'when'		=> array (
								array ( 'bg_image', 'notempty' ),
								array ( 'overlay', '=', '1' )
							),
							'relation'	=> 'and'
						),
						'.tatsu-{UUID} .tatsu-interactive-box-overlay::before'  => array (
							'property'	=> 'background',
							'when'		=> array (
								array ( 'bg_image', 'notempty' ),
								array ( 'overlay', '=', '1' )
							),
							'relation'	=> 'and'
						),
						'.tatsu-{UUID}.tatsu-interactive-box-overlay::before'  => array (
							'property'	=> 'background',
							'when'		=> array (
								array ( 'bg_image', 'notempty' ),
								array ( 'overlay', '=', '1' ),
								array ( 'style', '!=', 'flip' )
							),
							'relation'	=> 'and'
						)
					),
					'default'		=> 'rgba(0, 0, 0, 0.5)'
				),
                array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'options' => array (
						'gradient'	=> true
					),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-interactive-box-stacked' => array (
							'property'		=> 'background',
							'when'			=> array (
								array ( 'style', '=', 'stacked' ),
								array ( 'bg_image', 'empty' )
							),
							'relation'		=> 'and',
						),
						'.tatsu-{UUID} .tatsu-interactive-box-front' 	=> array (
							'property'		=> 'background',
							'when'			=> array (
								array ( 'style', '=', 'flip' ),
								array ( 'bg_image', 'empty' )
							),
							'relation'		=> 'and'
						),
						'.tatsu-{UUID} .tatsu-interactive-box-back'	=> array (
							'property'		=> 'background',
							'when'			=> array (
								array ( 'style', '=', 'flip' ),
								array ( 'bg_image', 'empty' )
							),
							'relation'		=> 'and'
						),
						'.tatsu-{UUID}.tatsu-interactive-box-transform'	=> array (
							'property'		=> 'background',
							'when'			=> array (
								array ( 'style', '=', 'transform' ),
								array ( 'bg_image', 'empty' )
							),
							'relation'		=> 'and'
						),
					)
				),
                array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Hover Background Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'options'	=> array (
						'gradient'	=> true
					),
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-interactive-box-stacks' => array (
							'property'		=> 'background',
							'when'			=> array (
								array ( 'style', '=', 'stacked' ),
								array ( 'bg_image', 'empty' )
							),
							'relation'		=> 'and',
						),
						'.tatsu-{UUID} .tatsu-interactive-box-back'	=> array (
							'property'		=> 'background',
							'when'			=> array (
								array ( 'style', '=', 'flip' ),
								array ( 'bg_image', 'empty' )
							),
							'relation'		=> 'and'
						),
						'.tatsu-{UUID}.tatsu-interactive-box-transform::after' => array (
							'property'		=> 'background',
							'when'			=> array (
								array ( 'style', '=', 'transform' ),
								array ( 'bg_image', 'empty' )
							),
							'relation'		=> 'and'
						)
				    ),
                ),
                array (
	        		'att_name' => 'border_radius',
	        		'type' => 'number',
	        		'label' => __('Border Radius','tatsu'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '4',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-interactive-box' => array (
							'property'	=> 'border-radius',
							'when'		=> array ( 'style', '!=', 'flip' ),
							'append'	=> 'px'
						),
						'.tatsu-{UUID} .tatsu-interactive-box-front' => array (
							'property'	=> 'border-radius',
							'when'		=> array ( 'style', '=', 'flip' ),
							'append'	=> 'px'
						),
						'.tatsu-{UUID} .tatsu-interactive-box-back' => array (
							'property'	=> 'border-radius',
							'when'		=> array ( 'style', '=', 'flip' ),
							'append'	=> 'px'
						),
					)
				),
				array (
					'att_name' => 'custom_height',
					'type' => 'switch',
					'label' => __( 'Enable Custom Height', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
			 	),
				array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __('Height','tatsu'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '500',
					'tooltip' => '',
					'visible' => array( 'custom_height', '=', '1' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-interactive-box-back'   => array (
							'property'		=> 'min-height',
							'append'		=> 'px',
							'when'			=> array ( 
								array ( 'custom_height', '=', '1' ),
								array ( 'style', '=', 'flip' )
							),
							'relation'	=> 'and'
						),
						'.tatsu-{UUID}.tatsu-interactive-box-custom-height' => array (
							'property'		=> 'min-height',
							'append'		=> 'px',
							'when'			=> array ( 
								array ( 'custom_height', '=', '1' ),
								array ( 'style', '!=', 'flip' )
							),
							'relation'	=> 'and'
						),
					),
				),
				array (
					'att_name'		=> 'vertical_alignment',
					'type'			=> 'button_group',
					'label'			=> __( 'Vertical Alignment', 'tatsu' ),
					'default'		=> 'center',
					'visible'		=> array ( 'custom_height', '=', '1' ),
					'options'		=> array (
						'flex-start'=> 'Top',
						'center'	=> 'Center',
						'flex-end'	=> 'Bottom'
					),
					'tooltip'		=> '',
					'css'			=> true,
					'responsive'	=> true,
					'selectors'		=> array (
						'.tatsu-{UUID} .tatsu-interactive-box-front'	=> array (
							'property'		=> 'align-items',
							'when'			=> array ( 
								array ( 'custom_height', '=', '1' ),
								array ( 'style', '=', 'flip' )
							),
							'relation'	=> 'and'
						),
						'.tatsu-{UUID} .tatsu-interactive-box-back'	=> array (
							'property'		=> 'align-items',
							'when'			=> array ( 
								array ( 'custom_height', '=', '1' ),
								array ( 'style', '=', 'flip' )
							),
							'relation'	=> 'and'
						),
						'.tatsu-{UUID}.tatsu-interactive-box-custom-height'	=> array (
							'property'		=> 'align-items',
							'when'			=> array ( 
								array ( 'custom_height', '=', '1' ),
								array ( 'style', '!=', 'flip' )
							),
							'relation'	=> 'and'
						),
					)
				),
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
					'default' => '',
					'visible'	=> array( 'style', '!=', 'transform' ),
	        		'tooltip' => ''
				),
				array (
					'att_name'		=> 'svg_icon',
					'type'			=> 'svg_icon_picker',
					'label'			=> __( 'Icon', 'tatsu' ),
					'default'		=> 'linea:basic_paperplane',
					'visible'		=> array ( 'style', '=', 'transform' ),
					'tooltip'		=> '',
				),
	        	array (
	        		'att_name' => 'icon_size',
	        		'type' => 'slider',
	        		'label' => __( 'Icon Size', 'tatsu' ),
	        		'options'	=> array (
						'min'	=> '0',
						'max'	=> '100',
						'step'	=> '1'
					),
					'default'	=> '42',
					'tooltip' => '',
					'css'	  => true,
					'selectors'	=> array (
						'.tatsu-{UUID} .tatsu-interactive-box-icon' => array (
							'property'		=> 'font-size',
							'append'		=> 'px',
							'when'			=> array( 'style', '!=', 'transform' )
						),
						'.tatsu-{UUID} .tatsu-interactive-box-icon svg' => array (
							'property'		=> array ( 'width', 'height' ),
							'append'		=> 'px',
							'when'			=> array( 'style', '=', 'transform' )
						),
						'.tatsu-{UUID}:hover .tatsu-interactive-box-icon-content' => array (
							'property'		=> 'transformY',
							'operation'		=> array( '+', 20 ),
							'prepend'		=> '-',
							'append'		=> 'px',
							'when'			=> array( 'style', '=', 'transform' )
						),
						'.tatsu-{UUID} .tatsu-interactive-box-arrow' => array (
							'property'		=> 'height',
							'append'		=> 'px',
							'when'			=> array( 'style', '=', 'transform' )
						)
					)
	        	),
                array (
		            'att_name' => 'icon_color',
					'type' => 'color',
		            'label' => __( 'Icon Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-interactive-box-icon' 		=> array (
							'property'		=> 'color',
							'when'			=> array( 'style', '!=', 'transform' )
						),
						'.tatsu-{UUID} .tatsu-interactive-box-icon svg' 	=> array (
							'property'		=> 'color',
							'when'			=> array( 'style', '=', 'transform' )
						)
					),
				),
				array (
					'att_name'	=> 'icon_hover_color',
					'type'		=> 'color',
					'label'		=> __( 'Icon Hover Color', 'tatsu' ),
					'default'	=> '',
					'tooltip'	=> '',
					'visible'	=> array ( 'style', '=', 'stacked' ),
					'css'		=> true,
					'selectors' => array (
						'.tatsu-{UUID}:hover .tatsu-interactive-box-icon'	=> array (
							'property'		=> 'color',
							'when'			=> array ( 'style', '=', 'stacked' ),
						)
					)
				),
	        	array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				),
				function_exists( 'typehub_get_exposed_selectors' ) ? array (
					'att_name'	=> 'title_font',
					'type'		=> 'select',
					'label'		=> __( 'Title Font', 'tatsu' ),
					'default'	=> 'h5',
					'options'	=> typehub_get_exposed_selectors()
				) : false,
                array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-interactive-box-title'	=> array (
							'property'		=> 'color'
						)
					),
				),
				array (
					'att_name'	=> 'title_hover_color',
					'type'		=> 'color',
					'label'		=> __( 'Title Hover Color', 'tatsu' ),
					'default'	=> '',
					'tooltip'	=> '',
					'visible'	=> array ( 'style', '!=', 'flip' ),
					'css'		=> true,
					'selectors' => array (
						'.tatsu-{UUID}:hover .tatsu-interactive-box-title'	=> array (
							'property'		=> 'color',
							'when'			=> array( 'style', '!=', 'flip' ),
						),
					)
				),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				),
                array (
		            'att_name' => 'content_color',
		            'type' => 'color',
		            'label' => __( 'Content Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-interactive-box-content' => array(
							'property' => 'color',
						),
					),
				),
				array (
		            'att_name' => 'content_hover_color',
		            'type' => 'color',
		            'label' => __( 'Content Hover Color', 'tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'visible'	=> array( 'style', '!=', 'flip' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}:hover .tatsu-interactive-box-content' => array(
							'property' => 'color',
							'when'	   => array( 'style', '!=', 'flip' ),
						),
					),
                ),
				array (
		            'att_name' => 'arrow_color',
					'type' => 'color',
		            'label' => __( 'Link Arrow Color', 'tatsu' ),
		            'default' => '#fff',
					'tooltip' => '',
					'visible' => array ( 'style', '=', 'transform' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-interactive-box-arrow svg' => array(
							'property' => 'stroke',
							'when'	   => array ( 'style', '=', 'transform' ),
						),
					),
				),
				array (
					'att_name'		=> 'box_shadow',
					'type' 			=> 'input_box_shadow',
					'label' 		=> __( 'Box Shadow', 'tatsu' ),
					'tooltip' 		=> '',
					'default' 		=> '0 1px 6px 0 rgba(0,0,0,0.1)',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-interactive-box' => array(
							'property' => 'box-shadow',
							'when'	   => array ( 'style', '!=', 'flip' )
						),
						'.tatsu-{UUID} .tatsu-interactive-box-front' => array(
							'property' => 'box-shadow',
							'when'	   => array ( 'style', '=', 'flip' )
						),
					),
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0 0 60px 0',
					'tooltip' => '',
					'css'	  => true,
					'responsive'	=> true,
					'selectors'	=> array (
						'.tatsu-{UUID}.tatsu-module'	=> array (
							'property'		=> 'margin',
						)
					)
				),
				array (
					'att_name' => 'animate',
					'type' => 'switch',
					'label' => __( 'Enable CSS Animation', 'tatsu' ),
					'default' => 0,
					'tooltip' => '',
				),
				array (
					'att_name' => 'animation_type',
					'type' => 'select',
					'visible' => array('animate', '=', '1'),
					'label' => __( 'Animation Type', 'tatsu' ),
					'options' => tatsu_css_animations(),
					'default' => 'fadeIn',
				),
				array (
					'att_name' => 'animation_delay',
					'type' => 'slider',
					'options' => array(
						'min' => '0',
						'max' => '2000',
						'step' => '50',
						'unit' => 'ms',
					),
					'default' => '0',	        		
					'label' => __( 'Animation Delay', 'tatsu' ),
					'tooltip' => '',
					'visible' => array( 'animate', '=', '1' ),
				),
			) ) ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'style'	 => 'stacked',
						'hover_bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'title' => 'Title Goes Here',
	        			'content' => '<p >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</p>',
						'icon_color'  => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'icon_hover_color'	=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'icon'		  => 'tatsu-icon-user',
						'icon_size'	  => '30',	
						'title_hover_color'	=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'content_hover_color'	=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'svg_icon_color'	=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_interactive_box', $controls, 'tatsu_interactive_box' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_testimonials_carousel');
function tatsu_register_testimonials_carousel() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#testimonial',
		'title' => __( 'Testimonials Slider', 'tatsu' ),
		'is_js_dependant' => false, //custom js implementation
		'child_module' => 'tatsu_testimonial_carousel',
		'type' => 'multi',
		'initial_children' => 2,
		'is_built_in' => true,
		'group_atts'		=> array (
			array (
				'type'		=> 'accordion',
				'active'	=> 'none',
				'group'		=> array (
					'style',
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Alignment and Content Styles', 'tatsu' ),
						'group'		=> array (
							'font_size',
							'content_width',
							'alignment',
							'author_role_font',
							'author_font',
						)
					),
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Colors and Other Styles', 'tatsu' ),
						'group'		=> array (
							'author_color',
							'author_role_color',
							'dots_color',
							'author_image_shadow',
							'margin',
						)
					),
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Slider Settings', 'tatsu' ),
						'group'		=> array (
							'pagination',
							'arrows',
							'slide_show',
							'slide_show_speed',
						)
					),
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Animation', 'tatsu' ),
						'group'		=> array (
							'animate',
							'animation_type',
							'animation_delay',
						)
					),
				)	
			),
		),
		'atts' => array_values( array_filter( array (
			array (
				'att_name' => 'style',
				'type' => 'button_group',
				'label' => __( 'Style', 'tatsu' ),
				'options' => array(
					'style1' => 'Style 1',
					'style2' => 'Style 2',
					'style3' => 'Style 3'
				),
				'default' => 'style1',
				'tooltip' => ''
			),
			array (
				'att_name' => 'font_size',
				'type' => 'slider',
				'label' => __( 'Content Font Size', 'tatsu' ),
				'options' => array(
					'unit' => 'px',
				),
				'default' => 20,
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-content' => array(
						'property' => 'font-size',
						'append' => 'px',
					),
				),
			),	
			array (
				'att_name' => 'content_width',
				'type' => 'slider',
				'label' => __( 'Content Width', 'tatsu' ),
				'options' => array(
					'unit' => '%',
					'min'  => '0',
					'max'  => '100'
				),
				'default' => '70',
				'tooltip' => '',
				'responsive'	=> true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-content' => array(
						'property' => 'max-width',
						'append' => '%',
					),
				),
			),		
			array (
				'att_name' => 'author_color',
				'type' => 'color',
				'label' => __( 'Testimonial Author Text Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-author' => array(
						'property' => 'color',
					),
				),
			),		
			array (
				'att_name' => 'author_role_color',
				'type' => 'color',
				'label' => __( 'Testimonial Author Role Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-author-role' => array(
						'property' => 'color',
					),
				),
			),
			array (
				'att_name' => 'dots_color',
				'type' => 'color',
				'label' => __( 'Slider Dots Color', 'tatsu' ),
				'default' => '',
				'tooltip' => '',
				'visible'	  => array( 'pagination', '=', '1' ),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .flickity-page-dots .is-selected' => array(
						'property' => 'background',
						'when'	   => array ( 'pagination', '=', '1' ),
					),
				),
			),		
			array (
				'att_name' => 'author_image_shadow',
				'type' => 'input_box_shadow',
				'label' => __( 'Author Image Box Shadow', 'tatsu' ),
				'tooltip' => '',
				'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
				'css' => true,
					'selectors' => array(
					'.tatsu-{UUID} .tatsu-testimonial-author-image img' => array(
						'property' => 'box-shadow',
						'when' => array('author_image_shadow', '!=', '0px 0px 0px 0px rgba(0,0,0,0)' ),
					),
				),
			),
			array (
				'att_name' => 'alignment',
				'type' => 'button_group',
				'label' => __( 'Alignment', 'tatsu' ),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'default' => 'center',
				'tooltip' => '',
			),
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'	=> 'author_font',
				'type'		=> 'select',
				'label'		=> __( 'Author Font', 'tatsu' ),
				'options'	=> typehub_get_exposed_selectors(),
				'default'	=> 'h6',
				'tooltip'	=> ''
			) : false,
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'	=> 'author_role_font',
				'type'		=> 'select',
				'label'		=> __( 'Author Role Font', 'tatsu' ),
				'options'	=> typehub_get_exposed_selectors(),
				'default'	=> 'h9',
				'tooltip'	=> ''
			) : false,
			array (
				'att_name' => 'pagination',
				'type' => 'switch',
				'label' => __( ' Enable Dots', 'tatsu' ),
				'default' => 1,
				'tooltip' => '',
			),
			array (
				'att_name'		=> 'arrows',
				'type'			=> 'switch',
				'label'			=> __( 'Enable Arrows', 'tatsu' ),
				'default'		=> '1',
				'tooltip'		=> '',
			),
			array (
				'att_name' => 'slide_show',
				'type' => 'switch',
				'label' => __( 'Enable Slide Show', 'tatsu' ),
				'default' => 0,
				'tooltip' => ''
			),
			array (
				'att_name' => 'slide_show_speed',
				'type' => 'slider',
				'visible' => array('slide_show', '=', '1'),
				'label' => __( 'Slide Show Speed', 'tatsu' ),
				'options' => array(
					'min' => '0',
					'max' => '5000',
					'step' => '1000',
					'unit' => 'ms',
				),
				'visible'	=> array (
					'slide_show', '=', '1'
				),
				'default' => '2000',
				'tooltip' => ''
			),
			array (
				'att_name' => 'animate',
				'type' => 'switch',
				'label' => __( 'Enable CSS Animation', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			),
			array (
				'att_name' => 'animation_type',
				'type' => 'select',
				'visible' => array('animate', '=', '1'),
				'label' => __( 'Animation Type', 'tatsu' ),
				'options' => tatsu_css_animations(),
				'default' => 'fadeIn',
			),
			array (
				'att_name' => 'animation_delay',
				'type' => 'slider',
				'options' => array(
					'min' => '0',
					'max' => '2000',
					'step' => '50',
					'unit' => 'ms',
				),
				'default' => '0',	        		
				'label' => __( 'Animation Delay', 'tatsu' ),
				'tooltip' => '',
				'visible' => array( 'animate', '=', '1' ),
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0 0 60px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array (
					'.tatsu-{UUID}.tatsu-module'	=> array (
						'property'		=> 'margin',
					)
				)
			),
		) ) ),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'content_width'		=> array ( 'd' => '70', 'm'	=> '100' ),
					'dots_color'		=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
				),
			)
		),
	);
	tatsu_remap_modules( array( 'tatsu_testimonials_carousel', 'testimonials' ), $controls, 'tatsu_testimonials_carousel' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_testimonial_carousel');
function tatsu_register_testimonial_carousel() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Testimonial', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Testimonial Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				 ),
				 array (
	        		'att_name' => 'author',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Author', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
				),
				
 	        	array (
	              	'att_name' => 'author_image',
	              	'type' => 'single_image_picker',
	              	'options' => array(
	              		'size' => 'thumbnail',
	              	),
	              	'label' => __( 'Testimonial Author Image', 'tatsu' ),
	              	'tooltip' => '',
				),
				array (
	        		'att_name' => 'author_role',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Author Role', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
	        			'author_image' => 'http://placehold.it/100x100',
	        			'author' => 'Swami',
	        			'author_role' => 'Designer',
	        		),
	        	)
	        ),
	    );
		tatsu_remap_modules( array( 'tatsu_testimonial_carousel', 'testimonial' ), $controls, 'tatsu_testimonial_carousel');
}

add_action( 'tatsu_register_modules', 'tatsu_register_process' );
function tatsu_register_process() {
	$controls = array (
		'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#process',
		'title' => __( 'Process','tatsu' ),
		'is_js_dependant' => false,
		'child_module' => 'tatsu_process_col',
		'type' => 'multi',
		'initial_children' => 3,
		'is_built_in' => true,
		'group_atts'	=> array (
			array (
				'type'		=> 'accordion',
				'active'	=> 'all',
				'group'		=> array (
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Size and Colors', 'tatsu' ),
						'group'		=> array (
							'icon_size',
							'icon_color',
							'icon_hover_color',
							'title_color',
							'title_hover_color',
							'content_color',
							'divider_color',
						)
					),
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Spacing and Fonts', 'tatsu' ),
						'group'		=> array (
							'title_font',
							'content_font',
							'margin'
						)
					),
					array (
						'type'		=> 'panel',
						'title'		=> __( 'Animation', 'tatsu' ),
						'group'		=> array (
							'animate',
							'animation_type',
							'animation_delay',
						)
					),
				)	
			),
		),
		'atts' => array_values( array_filter( array (
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'		=> 'title_font',
				'type'			=> 'select',
				'label'			=> __( 'Title Font', 'tatsu' ),
				'default'		=> 'h5',
				'options'		=> typehub_get_exposed_selectors()
			) : false,
			function_exists( 'typehub_get_exposed_selectors' ) ? array (
				'att_name'		=> 'content_font',
				'type'			=> 'select',
				'label'			=> __( 'Content Font', 'tatsu' ),
				'default'		=> 'body',
				'options'		=> typehub_get_exposed_selectors()
			) : false,
			array (
				'att_name'		=> 'divider_color',
				'label'			=> __( 'Divider Color', 'tatsu' ),
				'default'		=> '#D8D8D8',
				'type'			=> 'color',
				'css'			=> true,
				'selectors'		=> array (
					'.tatsu-{UUID} .tatsu-process-sep'  => array (
						'property'		=> 'background'
					)
				)
			),
			array (
				'att_name'		=> 'icon_size',
				'type'			=> 'slider',
				'label'			=> __( 'Icon Size', 'tatsu' ),
				'default'		=> '30',
				'options'		=> array (
					'min'		=> '10',
					'max'		=> '100',
					'step'		=> '1'
				),
				'css'			=> true,
				'responsive'	=> true,
				'selectors'		=> array (
					'.tatsu-{UUID} .tatsu-process-icon' => array (
						'property'	=> 'font-size',
						'append'	=> 'px',	
					),
					'.tatsu-{UUID} .tatsu-process-icon svg' => array (
						'property'	=> array ( 'width', 'height' ),
						'append'	=> 'px',	
					),
					'.tatsu-{UUID} .tatsu-process-sep' => array (
						'property'	=> 'top',
						'append'	=> 'px',	
						'operation'	=> array ( '/', 2 ),
					)
				)
			),
			array (
				'att_name' => 'icon_color',
				'type' 	   => 'color',
				'label'    => __( 'Icon Color', 'tatsu' ),
				'default'   => '',
				'tooltip'   => '',
				'css'		=> true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-process-icon i, .tatsu-{UUID} .tatsu-process-icon svg'	=> array (
						'property'		=> 'color',
					)
				)	
			),
			array (
				'att_name' => 'icon_hover_color',
				'type' 	   => 'color',
				'label'    => __( 'Icon Hover Color', 'tatsu' ),
				'default'   => '',
				'tooltip'   => '',
				'css'		=> true,
				'selectors'	=> array (
					'.tatsu-{UUID} .tatsu-process-icon i:hover, .tatsu-{UUID} .tatsu-process-icon svg:hover'	=> array (
						'property'		=> 'color',
					)
				)	
			),
			array (
				'att_name'		=> 'title_color',
				'type'			=> 'color',
				'label'			=> __( 'Title Color', 'tatsu' ),
				'default'		=> '',
				'css'			=> true,
				'selectors'		=> array (
					'.tatsu-{UUID} .tatsu-process-title'	=> array (
						'property'		=> 'color'
					)
				)
			),
			array (
				'att_name'		=> 'title_hover_color',
				'type'			=> 'color',
				'label'			=> __( 'Title Hover Color', 'tatsu' ),
				'default'		=> '',
				'css'			=> true,
				'selectors'		=> array (
					'.tatsu-{UUID} .tatsu-process-title:hover'	=> array (
						'property'		=> 'color'
					)
				)
			),
			array (
				'att_name'		=> 'content_color',
				'type'			=> 'color',
				'label'			=> __( 'Content Color', 'tatsu' ),
				'default'		=> '',
				'css'			=> true,
				'selectors'		=> array (
					'.tatsu-{UUID} .tatsu-process-content'	=> array (
						'property'		=> 'color'
					)
				)
			),
			array (
				'att_name' => 'margin',
				'type' => 'input_group',
				'label' => __( 'Margin', 'tatsu' ),
				'default' => '0 0 60px 0',
				'tooltip' => '',
				'css'	  => true,
				'responsive'	=> true,
				'selectors'	=> array (
					'.tatsu-{UUID}.tatsu-module'	=> array (
						'property'		=> 'margin',
					)
				)
			),
			array (
				'att_name' => 'animate',
				'type' => 'switch',
				'label' => __( 'Enable CSS Animation', 'tatsu' ),
				'default' => 0,
				'tooltip' => '',
			),
			array (
				'att_name' => 'animation_type',
				'type' => 'select',
				'visible' => array('animate', '=', '1'),
				'label' => __( 'Animation Type', 'tatsu' ),
				'options' => tatsu_css_animations(),
				'default' => 'fadeIn',
			),
			array (
				'att_name' => 'animation_delay',
				'type' => 'slider',
				'options' => array(
					'min' => '0',
					'max' => '2000',
					'step' => '50',
					'unit' => 'ms',
				),
				'default' => '0',	        		
				'label' => __( 'Animation Delay', 'tatsu' ),
				'tooltip' => '',
				'visible' => array( 'animate', '=', '1' ),
			),
		) ) ),
		'presets'		=> array (
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'icon_color'			=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					'icon_size'				=> '32',
				)
			)
		)
	);
	tatsu_remap_modules( array( 'tatsu_process', 'process_style1' ), $controls, 'tatsu_process' );
}

add_action( 'tatsu_register_modules', 'tatsu_register_process_col' );
function tatsu_register_process_col() {
	$controls = array (
		'icon' => '',
		'title' => __( 'Process Col','tatsu' ),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'sub_module',
		'is_built_in' => true,
		'atts' => array (
			array (
				'att_name'	    => 'icon_type',
				'type'			=> 'button_group',
				'label'			=> __( 'Icon Type', 'tatsu' ),
				'default'		=> 'icon',
				'options'		=> array (
					'svg'		=> 'Svg',
					'icon'		=> 'Icon'
				)	
			),
			array (
				'att_name'		=> 'icon',
				'type'			=> 'icon_picker',
				'label'			=> __( 'Icon', 'tatsu' ),
				'default'		=> '',
				'tooltip'		=> '',
				'visible'		=> array ( 'icon_type', '=', 'icon' )
			),
			array (
				'att_name'		=> 'svg_icon',
				'type'			=> 'svg_icon_picker',
				'label'			=> __( 'Svg Icon', 'tatsu' ),
				'default'		=> 'linea:basic_paperplane',
				'visible'		=> array ( 'icon_type', '=', 'svg' ),
				'tooltip'		=> ''
			),
			array (
				'att_name'		=> 'line_animate',
				'type'			=> 'switch',
				'label'			=> __( 'Enable Line Animate', 'tatsu' ),
				'default'		=> '',
				'visible'		=> array ( 'icon_type', '=', 'svg' ),
				'tooltip'		=> ''
			),
			array (
				'att_name'		=> 'title',
				'type'			=> 'text',
				'label'			=> __( 'Title', 'tatsu' ),
				'default'		=> ''
			),
			
			array (
				'att_name'		=> 'content',
				'type'			=> 'tinymce',
				'label'			=> __( 'Content', 'tatsu' ),
				'default'		=> ''
			),
		),
		'presets'		=> array (
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'icon' => 'tatsu-icon-user',
					'title' => 'Title Goes Here',
					'content' => '<p >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</p>',
				),
			)
		)
	);
	tatsu_remap_modules( array( 'tatsu_process_col', 'process_col' ), $controls, 'tatsu_process_col' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_simple_text', 9 );
// function tatsu_register_simple_text() {
// 	$controls = array (
// 	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#inline_text',
// 	        'title' => __( 'Simple Text', 'tatsu' ),
// 	        'is_js_dependant' => false,
// 	        'type' => 'single',
// 	        'is_built_in' => true,
// 	        'drag_handle' => false,
// 			'atts' => array (
// 	            // array (
// 	        	// 	'att_name' => 'max_width',
// 	        	// 	'type' => 'slider',
// 	        	// 	'label' => __( 'Content Width', 'tatsu' ),
// 	        	// 	'options' => array(
// 	        	// 		'min' => '0',
// 	        	// 		'max' => '100',
// 	        	// 		'step' => '1',
// 	        	// 		'unit' => '%',
// 	        	// 	),		        		
// 	        	// 	'default' => '100',
// 				// 	'tooltip' => '',
// 				// 	'responsive' => true,
// 				// 	'css'=>true,
// 				// 	'selectors' => array(
// 				// 		'.tatsu-{UUID} .tatsu-inline-text-inner' => array(
// 				// 			'property' => 'width',
// 				// 			'append' => '%'
// 				// 		)
// 				// 	),
// 				// ),
// 				array (
// 					'att_name' => 'content',
// 					'type' => 'text_area',
// 					'label' => 'Content',
// 					'default' => "",
// 					'tooltip' => '',
// 				),
// 	        	array (
// 	        		'att_name' => 'tag_to_use',
// 	        		'type' => 'select',
// 	        		'label' => __( 'Tag to use for Text', 'tatsu' ),
// 	        		'options' => array (
// 						'h1' => 'h1',
// 						'h2' => 'h2',
// 						'h3' => 'h3',
// 						'h4' => 'h4',
// 						'h5' => 'h5',
// 						'h6' => 'h6',
// 						'p' => 'p',
// 						'span' => 'span',
// 						'div' => 'div',						
// 					),
// 	        		'default' => 'div',
// 	        		'tooltip' => '',
        			
// 				),
// 				array (
// 					'att_name' => 'text_color',
// 					'type' => 'color',
// 					'options' => array (
// 						'gradient' => true
// 					),
// 					'label' => __( 'Text Color', 'tatsu' ),
// 					'default' => '',
// 				   'tooltip' => '',
// 				   'css' => true,
// 				   'selectors' => array(
// 					   '.tatsu-{UUID} .background-switcher-class' => array(
// 						   'property' => 'color',
// 					//   	'when' => array(
// 					// 		   array('tag_to_use', 'h1' ),
// 					// 		   array('tag_to_use', 'h2' ),
// 					// 		   array('tag_to_use', 'h3' ),
// 					// 		   array('tag_to_use', 'h4' ),
// 					// 		   array('tag_to_use', 'h5' ),
// 					// 		   array('tag_to_use', 'h6' ),
// 					// 	   ),
// 					// 	   'relation' => 'or',
// 					//    ),
// 					//    '.tatsu-{UUID} .simple-text-tag' => array(
// 					// 		'property' => 'color',
// 					// 		'when' => array(
// 					// 			array('tag_to_use', 'p' ),
// 					// 			array('tag_to_use', 'span' ),
// 					// 			array('tag_to_use', 'div' ),
// 					// 		),
// 					// 		'relation' => 'or',
// 						),
// 					), 
// 				), 
// 				array (
// 					'att_name' => 'style',
// 					'type' => 'button_group',
// 					'label' => __( 'Text Properties',  'tatsu'  ),
// 					'options' => array (
// 						'default' => 'Default',
// 						'custom' => 'Custom',
// 					),
// 					'default' => 'default',
// 					'tooltip' => '',
// 				),
// 	            array (
// 	        		'att_name' => 'font_size',
// 	        		'type' => 'number',
// 	        		'label' => __( 'Font Size', 'tatsu' ),
// 	        		'options' => array(
// 	        			'unit' => 'px',
// 	        		),
// 	        		'default' => '14',
// 					'tooltip' => '',
// 					'visible' => array( 'style', '=', 'custom' ),
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .simple-text-tag' => array(
// 							'property' => 'font-size',
// 							'when' => array('style', '=', 'custom'),
// 							'append' => 'px'
// 						),
// 					),
//         		),
// 				array (
// 	        		'att_name' => 'line-height',
// 	        		'type' => 'number',
// 	        		'label' => __( 'Line Height', 'tatsu' ),
// 	        		'options' => array(
// 	        			'unit' => 'px',
// 	        		),
// 	        		'default' => '5',
// 					'tooltip' => '',
// 					'visible' => array( 'style', '=', 'custom' ),
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .simple-text-tag' => array(
// 							'property' => 'line-height',
// 							'when' => array('style', '=', 'custom'),
// 							'append' => 'px'
// 						),
// 					),
        			
// 				),
// 				array(
// 					'att_name' => 'letter_spacing',
// 					'type' => 'slider',
// 					'label' => __('Letter Spacing', 'tatsu'),
// 					'options' => array(
// 						'min' => 0,
// 						'max' => 25,
// 						'step' => 1,
// 						'unit' => 'px',
// 						'add_unit_to_value' => true
// 					),
// 					'visible' => array( 'style', '=', 'custom' ),
// 					'default' => '0',
// 					'css' => true,
// 					'responsive' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .simple-text-tag' => array(
// 							'property' => 'letter-spacing',
// 							'when' => array('style', '=', 'custom'),
// 						),
// 					),
// 				),
// 				array (
// 	        		'att_name' => 'text_transform',
// 	        		'type' => 'select',
// 	        		'label' => __( 'Text Transform', 'tatsu' ),
// 	        		'options' => array (
// 						'uppercase' => 'Uppercase',
// 						'lowercase' => 'Lowercase',
// 						'capitalize' => 'Capitalize',
// 						'inherit' => 'Inhertit',
// 						'none' => 'None',
// 					),
// 					'visible' => array( 'style', '=', 'custom' ),
// 					'css' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID} .simple-text-tag' => array(
// 							'property' => 'text-transform',
// 							'when' => array('style', '=', 'custom'),
// 						),
// 					),
// 	        		'default' => 'div',
// 	        		'tooltip' => '',
        			
// 				),
// 				array (
//                     'att_name' => 'wrap_alignment',
//                     'type' => 'button_group',
//                     'label' => __( 'Text Alignment', 'tatsu' ),
//                     'options' => array (
//                         'left' => 'Left',
//                         'center' => 'Center',                        
//                         'right' => 'Right',
//                     ),
//                     'default' => 'center',
// 					'tooltip' => '',
// 					'css' => true,
// 					'selectors'=> array(
// 						'.tatsu-{UUID} .simple-text-inner' => array(
// 							'property' => 'text-align',
// 						),
// 					),
//                     //'visible' => array( 'max_width', '<', '100' ),  // coz it has become responsive
//                 ),				
// 				array (
// 	        		'att_name' => 'margin',
// 	        		'type' => 'input_group',
// 	        		'label' => __( 'Margin', 'tatsu' ),
// 	              	'default' => '0px 0px 0px 0px',
// 					'tooltip' => '',
// 					'responsive' => true,
// 					'css' => true,
// 					'selectors'=> array(
// 						'.tatsu-{UUID}.simple-text' => array(
// 							'property' => 'margin',
// 							'when' => array('margin', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
// 						),
// 					),
// 	        	),
// 	            array (
// 	              'att_name' => 'padding',
// 	              'type' => 'input_group',
// 	              'label' => __( 'Padding', 'tatsu' ),
// 	              'default' => '0px 0px 0px 0px',
// 				  'tooltip' => '',
// 				  'css' => true,
// 				  'responsive' => true,
// 				  'selectors' => array(
// 					    '.tatsu-{UUID}.simple-text' => array(
// 							'property' => 'padding',
// 							'when' => array('padding', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
// 						),
// 					),
// 	            ),
// 	            array (
// 	        		'att_name' => 'border_thickness',
// 	        		'type' => 'number',
// 	        		'label' => __( 'Border Thickness', 'tatsu' ),
// 	        		'options' => array(
// 	        			'unit' => 'px',
// 	        		),
// 	        		'default' => '0',
// 					'tooltip' => '',
// 					'css' => true,
// 					'responsive' => true,
// 					'selectors' => array(
// 						'.tatsu-{UUID}.simple-text' => array(
// 							'property' => 'border-width',
// 							'append' => 'px'
// 						),
// 					),
        			
// 				),
// 				array (
// 					'att_name' => 'border_color',
// 					'type' => 'color',
// 					'options' => array (
// 						'gradient' => true
// 					),
// 					'label' => __( 'Border Color', 'tatsu' ),
// 					'default' => '',
// 				   'tooltip' => '',
// 				   'css' => true,
// 				   'selectors' => array(
// 					   '.tatsu-{UUID}.simple-text' => array(
// 						   'property' => 'border-color',
// 						   'when' => array('border_thickness', '!=', '0')
// 					   ),
// 				   ), 
// 				),
// 				// array(
// 				// 	'att_name' => 'border_radius',
// 				// 	'type' => 'slider',
// 				// 	'label' => __('Border Radius', 'tatsu'),
// 				// 	'options' => array(
// 				// 		'min' => 0,
// 				// 		'max' => 1000,
// 				// 		'step' => 1,
// 				// 		'unit' => 'px',
// 				// 		'add_unit_to_value' => true
// 				// 	),
// 				// 	'default' => '0',
// 				// 	'css' => true,
// 				// 	'selectors' => array(
// 				// 		'.tatsu-{UUID}.simple-text' => array(
// 				// 			'property' => 'border-radius',
// 				// 			'when' => array('border_radius', '!=', '0px'),
// 				// 		),
// 				// 	),
// 				// 	'tooltip' => 'Use this to give border radius',
// 				// ), 
// 				array (
// 					'att_name' => 'bg_color',
// 					'type' => 'color',
// 					'options' => array (
// 						'gradient' => true
// 					),
// 					'label' => __( 'Background Color', 'tatsu' ),
// 					'default' => '',
// 				   'tooltip' => '',
// 				   'css' => true,
// 				   'selectors' => array(
// 					   '.tatsu-{UUID}.simple-text' => array(
// 						   'property' => 'background-color',
// 					   ),
// 				   ), 
// 				), 
// 				array (
// 					'att_name' => 'enable_box_shadow',
// 					'type' => 'switch',
// 					'label' => __( 'Enable Box Shadow', 'tatsu' ),
// 					'default' => 0,
// 					'tooltip' => '',
// 				), 
// 				array (
// 					'att_name' => 'box_shadow_custom',
// 					'type' => 'input_box_shadow',
// 					'label' => __( 'Box Shadow Values', 'tatsu' ),
// 					'default' => '0 0 15px 0 rgba(198,202,202,0.4)',
// 					'tooltip' => '',
// 					'visible' => array( 'enable_box_shadow', '=', '1' ),
// 					'css' => true,
// 				  'selectors' => array(
// 					    '.tatsu-{UUID}.simple-text' => array(
// 							'property' => 'box-shadow',
// 							'when' => array('enable_box_shadow', '=', '1'),
// 						),
// 					),
// 	            ),
// 				array (
// 	        		'att_name' => 'animate',
// 	        		'type' => 'switch',
// 	        		'label' => __( 'Enable CSS Animation', 'tatsu' ),
// 	        		'default Value' => 0,
// 	        		'tooltip' => ''
// 	        	),
// 	             array (
// 	              'att_name' => 'animation_type',
// 	              'type' => 'select',
// 	              'label' => __( 'Animation Type', 'tatsu' ),
// 	              'options' => tatsu_css_animations(),
// 	              'default' => 'fadeIn',
// 	              'tooltip' => '',
// 	              'visible' => array( 'animate', '=', '1' ),
// 	            ),
// 				array (
// 	        		'att_name' => 'animation_delay',
// 	        		'type' => 'slider',
// 	        		'options' => array(
// 	        			'min' => '0',
// 	        			'max' => '2000',
// 	        			'step' => '50',
// 						'unit' => 'ms',
// 	        		),
// 					'default' => '0',	        		
// 	        		'label' => __( 'Animation Delay', 'tatsu' ),
// 	        		'tooltip' => '',
// 					'visible' => array( 'animate', '=', '1' ),
// 	        	),	
// 	        ),
// 	        'presets' => array(
// 	        	'default' => array(
// 	        		'title' => '',
// 	        		'image' => '',
// 	        		'preset' => array(
// 	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
// 						'margin' => '0px 0px 30px 0px',
// 	        		),
// 	        	)
// 	        ),					
// 	);
// 	tatsu_register_module( 'simple_text', $controls );
// }

if( !function_exists( 'tatsu_register_multi_layer_images' ) ) {
	add_action( 'tatsu_register_modules', 'tatsu_register_multi_layer_images', 9 );
	function tatsu_register_multi_layer_images() {
		$controls = array (
			'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#image',
			'title' => __( 'Multi Layer Images', 'tatsu' ),
			'is_js_dependant' => false,
			'child_module' => 'tatsu_multi_layer_image',
			'type' => 'multi',
			'should_autop' => false,
			'is_built_in' => true,
			'initial_children' => 2,		
			'atts' => array(
				array(
					'att_name' => 'lazy_load',
					'type' => 'switch',
					'label' => __( 'Enable Lazy Load', 'tatsu' ),
					'default' => '0',
					'tooltip' => ''
				),
				array(
					'att_name' => 'placeholder_bg',
					'type' => 'color',
					'label' => __( 'Placeholder background color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'visible' => array( 'lazy_load', '=', '1' ),
					'css' => true, 
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-multi-layer-image' => array(
							'property' => 'background-color',
							'when' => array( 'lazy_load', '=', '1' ),
						),
					),
				),	
			),
		);
		tatsu_register_module( 'tatsu_multi_layer_images', $controls );
	}
}

if( !function_exists( 'tatsu_register_multi_layer_image' ) ) {
	add_action( 'tatsu_register_modules', 'tatsu_register_multi_layer_image', 9 );
	function tatsu_register_multi_layer_image() {
		$controls = array(
			'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#image',
			'title' => __( 'Multi Layer Image ', 'tatsu' ),
			'is_js_dependant' => false,
			'type' => 'sub_module',
			'is_built_in' => true,
			'atts' => array (
				array (
					'att_name' => 'image',
					'type' => 'single_image_picker',
					'label' => __( 'Image', 'tatsu' ),
					'tooltip' => '',
					'default' => TATSU_PLUGIN_URL.'/img/image-placeholder.jpg',
				),
				array (
					'att_name'	=> 'shadow_type',
					'type'	=> 'button_group',
					'label'	=> __( 'Shadow Type', 'tatsu' ),
					'tooltip'	=> '',
					'options'	=> array (
						'box' => 'Box Shadow',
						'drop'	=> 'Drop Shadow',
					),
					'default'	=> 'box',
				),
				array(
					'att_name' => 'box_shadow',
					'type' => 'input_box_shadow',
					'label' => __( 'Box Shadow', 'tatsu' ),
					'default' => '0px 0px 0px 0px rgba(0,0,0,0)',
					'tooltip' => 'Box Shadow for your image',
					'visible' => array( 'shadow_type', '=', 'box' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} img' => array(
							'property' => 'box-shadow',
							'when' => array( 'shadow_type', '=', 'box' ),
						),
					)
				),
				array(
					'att_name' => 'drop_shadow',
					'type' => 'input_box_shadow',
					'options'	=> array (
						'type'	=> 'drop-shadow',
					),
					'label' => __( 'Drop Shadow', 'tatsu' ),
					'default' => 'drop-shadow(0px 0px 0px rgba(0,0,0,0))',
					'tooltip' => 'Box Shadow for your image',
					'visible' => array( 'shadow_type', '=', 'drop' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} img' => array(
							'property' => 'filter',
							'when' => array( 'shadow_type', '=', 'drop' ),
						),
					)
				),
				array (
					'att_name'	=> 'offset',
					'type'		=> 'negative_number',
					'label'		=> __( 'Image Horizontal Offset', 'tatsu' ),
					'default'	=> '0px 0px',
					'option_labels' => array('X-axis','Y-axis'),
					'tooltip'	=> '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-multi-layer-image' => array(
							'property' => 'transform',
						),
					),
				),
				array (
					'att_name' => 'max_width',
					'type' => 'slider',
					'label' => __( 'Width', 'tatsu' ),
					'options' => array(
						'min' => '0',
						'max' => '100',
						'step' => '1',
						'unit' => '%',
					),		        		
					'default' => '50',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-multi-layer-image' => array(
							'property' => 'max-width',
							'append' => '%'
						)
					),
				),
				array (
					'att_name' => 'stack_order',
					'type' => 'slider',
					'label' => __( 'Stack Order', 'tatsu' ),
					'options' => array(
						'min' => '1',
						'max' => '20',
						'step' => '1',
						'unit' => '',
					),		        		
					'default' => '1',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-multi-layer-image' => array(
							'property' => 'z-index',
						)
					),
				),
				array(
					'att_name' => 'id',
					'type' => 'number',
					'label' => __( 'Id', 'tatsu' ),
					'visible' => array( 'max_width', '=', '-1000' )
				),
			),		
		);
		tatsu_register_module( 'tatsu_multi_layer_image', $controls );
	}
}

if( !function_exists( 'tatsu_register_rev_slider' ) ) {
	add_action( 'tatsu_register_modules', 'tatsu_register_rev_slider' );
	function tatsu_register_rev_slider() {
		if( class_exists( 'RevSlider' ) ) {
			global $wpdb;
			$query = sprintf('select alias, title from %srevslider_sliders r',$wpdb->prefix);
			$sliders = $wpdb->get_results($query);
			$sliders_option = array();
			if( is_array( $sliders ) ) {
				foreach( $sliders as $slider ) {
					if( is_object( $slider ) ) {
						$sliders_option[ $slider->alias ] = $slider->title;
					}
				}
			}
			$controls = array(
				'icon' => '',
				'title' => __( 'Slider Revolution', 'tatsu' ),
				'is_js_dependant' => false,
				'type' => 'single',
				'is_built_in' => false,
				'atts' => array (
					array (
						'att_name' => 'rev_slider_alias',
						'type' => 'select',
						'label' => __( 'Slider Name', 'tatsu' ),
						'options' => $sliders_option,
						'tooltip'	=> '',
					),
				)
			);
			tatsu_register_module( 'tatsu_rev_slider', $controls, 'tatsu_rev_slider' );
		}
	}
}

if( !function_exists( 'tatsu_register_typed_text' ) ) {
	add_action( 'tatsu_register_modules', 'tatsu_register_typed_text' );
	function tatsu_register_typed_text() {
		$controls = array (
			'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#',
			'title' => __( 'Typed text', 'tatsu' ),
			'is_js_dependant' => false,
			'child_module' => '',
			'type' => 'single',
			'is_built_in' => true,
			'group_atts' => array (
				'rotated_text',
				array (
					'type' => 'accordion' ,
					'active' => array( 0 ),
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Content', 'tatsu' ),
							'group' => array (
								'prefix_text',
								'suffix_text',
								'tag_to_use',
								'typed_text_font',
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Colors and Spacing', 'tatsu' ),
							'group' => array (
								'rotated_text_color',
								'prefix_suffix_color',
								'cursor_color',
								'margin'
							)
						)
					)
				),
			),
			'atts' => array_values( array_filter( array (
				array (
					'att_name' => 'prefix_text',
					'type' => 'text_area',
					'label' => __( 'Prefix Text', 'tatsu' ),
					'default' => 'Prefix text',
					'tooltip' => ''
					),
					array (
					'att_name' => 'rotated_text',
					'type' => 'text',
					'label' => __( 'Text To Be Rotated', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
					),
					array (
					'att_name' => 'suffix_text',
					'type' => 'text_area',
					'label' => __( 'Suffix Text', 'tatsu' ),
					'default' => '',
					'tooltip' => ''	
					),

					array (
					'att_name' => 'tag_to_use',
					'type' => 'select',
					'label' => __( 'Tag to use for Text', 'tatsu' ),
					'options' => array (
						'h1' => 'h1',
						'h2' => 'h2',
						'h3' => 'h3',
						'h4' => 'h4',
						'h5' => 'h5',
						'h6' => 'h6',
						'p' => 'p',
						'span' => 'span',
						'div' => 'div',						
					),
					'default' => 'div',
					'tooltip' => '',
				),
				
					function_exists( 'typehub_get_exposed_selectors' ) ? array (
					'att_name'	=> 'typed_text_font',
					'type'		=> 'select',
					'label'		=> __( 'Text size', 'tatsu' ),
					'default'	=> 'h1',
					'options'	=> typehub_get_exposed_selectors()
				) : false,
				array (
					'att_name' => 'rotated_text_color',
					'type' => 'color',
					'options' => array (
						'gradient' => true
					),
					'label' => __( 'Rotated Text Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-typed-rotated-text' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'prefix_suffix_color',
					'type' => 'color',
					'options' => array (
						'gradient' => true
					),
					'label' => __( 'Prefix and Suffix Text Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-typed-text-wrap' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'cursor_color',
					'type' => 'color',
					'options' => array (
						'gradient' => true
					),
					'label' => __( 'Cursor Color', 'tatsu' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tatsu-typed-text-cursor' => array(
							'property' => 'color',
						),
					),
				),
				array (
					'att_name' => 'margin',
					'type' => 'input_group',
					'label' => __( 'Margin', 'tatsu' ),
					'default' => '0px 0px 30px 0px',
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID}.tatsu-typed-text-wrap' => array(
							'property' => 'margin',
						),
					),
				),
			) ) ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
							'prefix_text'	=> 'Tatsu is a',
							'rotated_text'	=> 'Simple, Powerful, Intuitive, Fully Visual',
							'suffix_text'	=> 'Builder',
							'rotated_text_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
					),
				)
			),
		);
		tatsu_register_module( 'tatsu_typed_text', $controls );
	}
}