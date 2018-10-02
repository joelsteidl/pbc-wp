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
							'title' => __( 'Full Screen Section', 'tatsu' ),
							'group' => array (
								'full_screen', 
								'full_screen_header_scheme'
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
												'flip_top_divider'
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
												'flip_bottom_divider'
											),
										),
									),
								)
							)
						),
						array (
							'type' => 'panel',
							'title' => __( 'Advanced', 'tatsu' ),
							'group' => array (
								'offset_section', 
								'offset_value'
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
							'when' => array('bg_animation', '!=', 'tatsu-parallax'),
						),
						'.tatsu-{UUID} .tatsu-parallax-element' => array(
							'property' => 'background-color',
							'when' => array('bg_animation', '!=', 'tatsu-parallax'),
						),
					)
	            ),
	             array (
	              'att_name' => 'bg_image',
	              'type' => 'single_image_picker',
				  'label' => 'Background Image',
				//  'hidden' => array('set_featured_image_as_bg','=','1'),
	              'tooltip' => '',
				  'css' => true,
				  'selectors' => array(
					    '.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'background-image',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '!=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
						'.tatsu-{UUID} .tatsu-parallax-element' => array(
							'property' => 'background-image',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
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
					    '.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'background-repeat',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '!=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
						'.tatsu-{UUID} .tatsu-parallax-element' => array(
							'property' => 'background-repeat',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
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
					    '.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'background-attachment',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '!=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
						'.tatsu-{UUID} .tatsu-parallax-element' => array(
							'property' => 'background-attachment',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
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
					    '.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'background-position',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '!=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
						'.tatsu-{UUID} .tatsu-parallax-element' => array(
							'property' => 'background-position',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
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
					    '.tatsu-{UUID}.tatsu-section' => array(
							'property' => 'background-size',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '!=', 'tatsu-parallax')
							),
							'relation' => 'and'
						),
						'.tatsu-{UUID} .tatsu-parallax-element' => array(
							'property' => 'background-size',
							'when' => array(
								array('bg_image', 'notempty'),
								array('bg_animation', '=', 'tatsu-parallax')
							),
							'relation' => 'and'
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
					'att_name'		=> 'top_divider',
					'type'			=> 'select',
					'label'			=> __( 'Separator', 'tatsu' ),
					'options'		=> !empty( $divider_options ) ? $divider_options[ 'top' ] : array(),
					'default'		=> 'none'
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
					    '.tatsu-{UUID} .tatsu-top-divider' => array(
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
					    '.tatsu-{UUID} .tatsu-bottom-divider' => array(
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
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => 0,
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
	        'is_js_dependant' => false,
			'child_module' => 'tatsu_column',
			'label' => 'Row',
			'initial_children' => 1,
	        'type' => 'core',
	        'builder_layout' => 'column',
			'is_built_in' => true,
			'group_atts' => array(
				'full_width',
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
								'swap_cols'
							)
						),	
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'bg_color',
								'border_radius',
								'padding',
								'box_shadow',
								'margin'
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
	              'default' => 0,
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
					'active' => 'none',
					'group' => array (		
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'vertical_align',
								'custom_margin',
								'margin',
								'border',
								'border_color',
								'border_radius',
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
							'title' => __( 'Advanced', 'tatsu' ),
							'group' => array (
								'column_width',
								'column_mobile_spacing',
								'column_offset',
								'offset',
								'z_index',
								'column_parallax',
								'enable_box_shadow',
								'box_shadow_custom',
								'hover_box_shadow',
								'image_hover_effect',
								'column_hover_effect',
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
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
					    '.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
						'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
				// array (
				// 	'att_name' => 'sticky',
				// 	'type' => 'switch',
				// 	'label' => __( 'Sticky Column ?', 'tatsu' ),
				// 	'default' => '0',
				// 	'tooltip' => '',
				// 	'visible' => array('column_offset', '=' ,0)			  
				// ),
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
	              'default' => 0,
	              'tooltip' => '',
	            ),
	        ),
	    );
	tatsu_register_module( 'tatsu_column', $controls );
}

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
				array (
					'type' => 'accordion' ,
					'active' => 'none',
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'bg_color',
								'margin',
								'padding',
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
}

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
				array (
					'type' => 'accordion' ,
					'active' => 'none',
					'group' => array (
						array (
							'type' => 'panel',
							'title' => __( 'Spacing and Styling', 'tatsu' ),
							'group' => array (
								'bg_color',
								'margin',
								'padding',
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
						'margin' => '0px 0px 30px 0px',
	        		),
	        	)
	        ),					
	);
	tatsu_register_module( 'tatsu_inline_text', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_button', 9 );
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
}

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
	        			'size' => 'medium',
	        			'style' => 'plain',
	        			'color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_icon', $controls );
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
	        		'default' => 'center',
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
						'black' => 'Black'
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
	        		'type' => 'slider',
	        		'label' => __( 'Divider Width', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
						'unit' => '%', //array('%','px'),
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
					'visible' => array ( 'width', '<', '100' ),
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
	              'default' => 0,
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
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_text_with_shortcodes', $controls );
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
	        'is_js_dependant' => false,
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
					    '.tatsu-{UUID} .tatsu-list-icon-wrap' => array(
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
		            'label' => __( 'Icon Color','tatsu' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .tatsu-icon' => array(
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
	        			'icon_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
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
				'tooltip' => ''
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
				'label' => __('Width', 'tatsu'),
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
					'none' => 'None'
				),
				'default' => 'none',
				'tooltip' => 'Box Shadow for your image'
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
				'default' => '0',
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
				// 'css' => true,
				// 'selectors' => array(
				// 	'.tatsu-{UUID} .tatsu-single-image-inner' => array(
				// 		'property' => 'background-color',
				// 		'when' => array( 'lazy_load', '=', '1' ),
				// 	),
				// ),
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
							array('margin', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
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
					'image' => TATSU_PLUGIN_URL.'/img/image-placeholder.jpg',
				),
			)
		),			
	);
	tatsu_register_module( 'tatsu_image', $controls );
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
			  'default' => 0,
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
					'.tatsu-{UUID}.tatsu-column > .tatsu-column-inner > .tatsu-column-bg-image' => array(
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
			  'default' => 0,
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
				))),
	        'presets' => array(
	        	'default' => array(
	        		'preset' => array(
	        			'height' => '1',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_gsection_title', $controls );
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
	tatsu_register_module( 'tatsu_gsection_meta', $controls );
}
add_action( 'tatsu_register_global_section', 'tatsu_register_gsection_sidebar' );
function tatsu_register_gsection_sidebar() {

	$sidebar_list = tatsu_get_sidebar_list();

		$controls = array (
	        'icon' =>'',
	        'title' => __( 'Global Section Sidebar', 'tatsu' ),
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
	tatsu_register_module( 'tatsu_gsection_sidebar', $controls );
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

?>