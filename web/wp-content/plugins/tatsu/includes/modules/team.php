<?php

/**************************************
			TATSU - TEAM
**************************************/
if ( ! function_exists( 'tatsu_team' ) ) {
	function tatsu_team( $atts, $content, $tag ) {
		$atts = shortcode_atts( array( 
			'style'						=> 'style1',
			'title'						=> '',
			'name_font'	 				=> 'h6',
			'title_color'				=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
			'name_hover_color'			=> '',
			'image' 	 				=> '',
			'designation'				=> '',
			'designation_color'			=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
			'designation_hover_color'	=> '',
			'designation_font'			=> 'h9',
			'facebook'					=> '',
			'twitter'					=> '',
			'google_plus'				=> '',
			'instagram'					=> '',
			'linkedin'					=> '',
			'email'						=> '',
			'icon_color'				=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
            'icon_hover_color'			=> '',
            'title_alignment_static' 	=> 'center',
            'vertical_alignment' 		=> 'center',
			'overlay_color' 			=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' )),
			'lazy_load'					=> '0',
			'lazy_load_bg'				=> '',
			'key' 						=> be_uniqid_base36(true),
		),$atts, $tag );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key );
		$unique_class_name = 'tatsu-' . $key;

		//oshine to exponent
		$name = $title;
		$name_color = $title_color;
		$horizontal_alignment = $title_alignment_static;
        
        $css_id = be_get_id_from_atts( $atts );
        $visibility_classes = be_get_visibility_classes_from_atts( $atts );

        $classes = array( 'tatsu-team', 'tatsu-module', $unique_class_name );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( !empty( $atts['css_classes'] ) ) {
            $classes[] = $atts['css_classes'];
        }
		$image_classes = array();
		$image_atts = array();
		$padding = 100;
		$classes[] = !empty( $style ) ? 'tatsu-team-' . $style : 'tatsu-team-style1';
		$classes[] = !empty( $horizontal_alignment ) ? 'tatsu-team-align-' . $horizontal_alignment : 'tatsu-team-align-center';
		if( !empty( $facebook ) || !empty( $twitter ) || !empty( $google_plus ) || !empty( $instagram ) ) {
			$classes[] = 'tatsu-team-has-icons';
		}

		if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        $data_attrs = be_get_animation_data_atts( $atts );


		$has_social_icons = !empty( $facebook ) || !empty( $twitter ) || !empty( $google_plus ) || !empty( $instagram ) || !empty( $linkedin ) || !empty( $email );

		if( !empty( $lazy_load ) ) {
			$image_classes[] = 'be-lazy-load';
			$image_atts[] = 'data-src = "' . $image . '"';
			$image_id = tatsu_get_image_id_from_url( $image );
			$padding = be_get_placeholder_padding( $image_id );	
		}else {
			$image_atts[] = 'src = "' . $image . '"';
		}

		$classes = implode( ' ', $classes );
		$image_classes = implode( ' ', $image_classes );
		$image_atts = implode( ' ', $image_atts );
		ob_start();
		?>
			<div <?php echo $css_id; ?> class = "<?php echo $classes; ?>" <?php echo $data_attrs; ?>>
				<?php echo $custom_style_tag; ?>
				<?php if( !empty( $image ) ) : ?>
					<div class = "tatsu-team-image">
						<?php if( !empty( $lazy_load ) ) : ?>
							<div class = "tatsu-lazy-load-placeholder" style = "padding-bottom : <?php echo $padding; ?>%">
							</div>
						<?php endif; ?>
						<img class = "<?php echo $image_classes; ?>" <?php echo $image_atts; ?> />
					</div>
				<?php endif; ?>
				<?php if( !empty( $name ) || !empty( $designation ) || $has_social_icons ) : ?>
					<div class = "tatsu-team-overlay">
						<div class = "tatsu-team-member-details">
							<?php if( !empty( $name ) || !empty( $designation ) ) : ?>
								<div class = "tatsu-team-member-name-designation">
									<?php if( '' !== $name ) : ?>
										<div class = "tatsu-team-member-name <?php echo !empty( $name_font ) ? $name_font : ''; ?>">
											<?php echo $name; ?>
										</div>
									<?php endif; ?>
									<?php if( '' !== $designation ) : ?>
										<div class = "tatsu-team-member-designation <?php echo !empty( $designation_font ) ? $designation_font : ''; ?>">
											<?php echo $designation; ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<?php if( $has_social_icons ) : ?>
								<div class = "tatsu-team-member-social-details">
									<?php if( !empty( $facebook ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $facebook; ?>" target = "_blank">
											<i class = "tatsu-icon-facebook"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $twitter ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $twitter; ?>" target = "_blank">
											<i class = "tatsu-icon-twitter"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $google_plus ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $google_plus; ?>" target = "_blank">
											<i class = "tatsu-icon-gplus"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $instagram ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $instagram; ?>" target = "_blank">
											<i class = "tatsu-icon-instagram"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $linkedin ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $linkedin; ?>" target = "_blank">
											<i class = "tatsu-icon-linkedin"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $email ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $email; ?>" target = "_blank">
											<i class = "tatsu-icon-mail2"></i>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php
			return ob_get_clean();
	}
}


add_action('tatsu_register_modules', 'tatsu_register_team');
function tatsu_register_team() {
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#team',
		'title' => __('Team', 'tatsu'),
		'is_js_dependant' => false,
		'child_module' => '',
		'type' => 'single',
		'is_built_in' => true,
		'hint' => 'title',
        'group_atts' => array (
            array (
                'type'  => 'tabs',
                'group' => array (
                    array (
                        'type'  => 'tab',
                        'title' => __( 'Content', 'tatsu' ),
                        'group' => array (
                            'title',
                            'designation',
                            'image',
                            'lazy_load',
                            'lazy_load_bg',
                            array (
                                'type'  => 'accordion',
                                'active' => 'none',
                                'group' => array (
                                    array(
                                        'type' => 'panel',
                                        'title' => __('Social Icons', 'tatsu'),
                                        'group'	=> array(
                                            'facebook',
                                            'twitter',
                                            'google_plus',
                                            'instagram',
                                            'linkedin',
                                            'email'
                                        ),
                                    ),
                                )
                            )
                        )
                    ),
                    array (
                        'type'  => 'tab',
                        'title' => __( 'Style', 'tatsu' ),
                        'group' => array (
                            'style',
                            array(
                                'type'  => 'accordion',
                                'active' => array(0),
                                'group' => array (
                                    array (
                                        'type'  => 'panel',
                                        'title' => __( 'Colors', 'tatsu' ),
                                        'group' => array (
                                            array(
                                                'type'  => 'tabs',
                                                'group' => array (
                                                    array (
                                                        'type'  => 'tab',
                                                        'title' => __( 'Normal', 'tatsu' ),
                                                        'group' => array (
                                                            'title_color',
                                                            'designation_color',                                                            
                                                            'icon_color',                                                            
                                                            'overlay_color',
                                                        )
                                                    ),
                                                    array (
                                                        'type'  => 'tab',
                                                        'title' => __( 'Hover', 'tatsu' ),
                                                        'group' => array (
                                                            'name_hover_color',
                                                            'designation_hover_color',
                                                            'icon_hover_color',
                                                        )
                                                    )
                                                )
                                            ),
                                        )
                                    ),
                                    array (
                                        'type'  => 'panel',
                                        'title' => __( 'Typography', 'tatsu' ),
                                        'group' => array (
                                            'name_font',
                                            'designation_font',
                                        )
                                    ),
                                    array (
                                        'type'  => 'panel',
                                        'title' => __( 'Alignment', 'tatsu' ),
                                        'group' => array (
                                            'vertical_alignment',
                                            'title_alignment_static',
                                        )
                                    ),
                                )
                            )
                        )
                    ),
                    array (
                        'type'  => 'tab',
                        'title' => __( 'Advanced', 'tatsu' ),
                        'group' => array (
                            array(
                                'type'  => 'accordion',
                                'active' => 'none',
                                'group' => array (
                                )
                            ),
                        )
                    ),
                )
            )
        ),
		'atts' => array_values(array_filter(array(
			array(
				'att_name'	=> 'style',
                'type'	=> 'button_group',
                'is_inline' => true,
				'label'	=> __('Style', 'tatsu'),
				'options'	=> array(
					'style1'	=> 'Style 1',
					'style2'	=> 'Style 2'
				),
				'default'	=> 'style1'
			),
			array(
				'att_name' => 'title',
				'type' => 'text',
				'label' => __('Name', 'tatsu'),
				'default' => '',
				'tooltip' => 'Name or Title for the Team Member'
			),
			array(
				'att_name' => 'designation',
				'type' => 'text',
				'label' => __('Designation', 'tatsu'),
				'default' => '',
				'tooltip' => 'Designation of the Team Member'
			),
			array(
				'att_name' => 'image',
				'type' => 'single_image_picker',
				'label' => __('Image', 'tatsu'),
				'tooltip' => '',
			),
			array(
				'att_name' => 'title_color',
				'type' => 'color',
				'options' => array(
					'gradient' => false,
				),
				'label' => __('Name', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-team-member-name' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'name_hover_color',
				'type' => 'color',
				'options' => array(
					'gradient' => false,
				),
				'label' => __('Name', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-team-member-name:hover' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'designation_color',
				'type' => 'color',
				'options' => array(
					'gradient' => false,
				),
				'label' => __('Designation', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-team-member-designation' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'designation_hover_color',
				'type' => 'color',
				'options' => array(
					'gradient' => false,
				),
				'label' => __('Designation', 'tatsu'),
				'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-team-member-designation:hover' => array(
						'property' => 'color',
					),
				),
			),
			array(
				'att_name' => 'facebook',
				'type' => 'text',
				'label' => __('Facebook', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'twitter',
				'type' => 'text',
				'label' => __('Twitter', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'google_plus',
				'type' => 'text',
				'label' => __('Google Plus', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'instagram',
				'type' => 'text',
				'label' => __('Instagram', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'linkedin',
				'type' => 'text',
				'label' => __('LinkedIn', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'email',
				'type' => 'text',
				'label' => __('Email', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'icon_color',
				'type' => 'color',
				'label' => __('Icon', 'tatsu'),
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
			array(
				'att_name' => 'icon_hover_color',
				'type' => 'color',
				'label' => __('Icon', 'tatsu'),
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
			array(
				'att_name' => 'vertical_alignment',
                'type' => 'button_group',
                'is_inline' => true,
				'label' => __('Vertical', 'tatsu'),
				'options' => array(
					'flex-start' => 'Top',
					'center' => 'Center',
					'flex-end' => 'Bottom'
				),
				'default' => 'center',
				'tooltip' => '',
				'css' => true,
				'hidden' => array('style', '=', 'style2'),
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-team-overlay' => array(
						'property' => 'align-items',
					),
				),
			),
			array(
				'att_name' => 'title_alignment_static',
                'type' => 'button_group',
                'is_inline' => true,
				'label' => __('Horizontal', 'tatsu'),
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'default' => 'center',
				'tooltip' => '',
			),
			array(
				'att_name' => 'overlay_color',
				'type' => 'color',
				'options' => array(
					'gradient' => true,
				),
				'label' => __('Overlay', 'tatsu'),
				'default' => '',	//color_scheme
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-team-overlay' => array(
						'property' => 'background',
					),
				),
			),
			array(
				'att_name' => 'lazy_load',
				'type' => 'switch',
				'label' => __('Lazy Load', 'tatsu'),
				'default' => 0,
				'tooltip' => '',
			),
			array(
				'att_name' => 'lazy_load_bg',
				'type' => 'color',
				'options' => array(
					'gradient' => false,
				),
				'label' => __('Placeholder Background', 'tatsu'),
				'default' => '',
                'tooltip' => '',
                'visible'  => array ( 'lazy_load', '=', '1' ),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .tatsu-lazy-load-placeholder' => array(
                        'property' => 'background',
                        'when'  => array( 'lazy_load', '=', '1' ),
					),
				),
			),
			function_exists('typehub_get_exposed_selectors') ?  array(
				'type'	=> 'select',
				'att_name'	=> 'name_font',
				'options'	=> typehub_get_exposed_selectors(),
				'label'		=> __('Name', 'tatsu'),
				'default'	=> 'h6',
				'tooltip'	=> ''
			) : false,
			function_exists('typehub_get_exposed_selectors') ? array(
				'type'	=> 'select',
				'att_name'	=> 'designation_font',
				'options'	=> typehub_get_exposed_selectors(),
				'label'		=> __('Designation', 'tatsu'),
				'default'	=> 'h9',
				'tooltip'	=> ''
			) : false,
		))),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'title' => 'John Doe',
					'title_color'	=> array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'designation' => 'Designer',
					'designation_color'	=> array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'image' => 'http://placehold.it/400x400',
					'facebook' => '#',
					'twitter' => '#',
					'linkedin' => '#',
					'email' => '#',
					'icon_color' => array('id' => 'palette:1', 'color' => tatsu_get_color('tatsu_accent_twin_color')),
					'overlay_color' => array('id' => 'palette:0', 'color' => tatsu_get_color('tatsu_accent_color')),
				)
			),
		),
	);
	tatsu_remap_modules(array('tatsu_team', 'team'), $controls, 'tatsu_team');
}

?>