<?php

add_action( 'tatsu_register_modules', 'oshine_register_blog');
function oshine_register_blog() {
		$post_categories = get_categories();
		$post_tags = get_tags();
		$category_options = array();
		$tag_options = array();
		foreach( $post_categories as $category ) {
			if( is_object( $category ) ) {
				$category_options[ $category->slug ] = $category->name;
			}
		}
		foreach( $post_tags as $tag ) {
			if( is_object( $tag ) ) {
				$tag_options[ $tag->slug ] = $tag->name;
			}
		}
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#blog',
	        'title' => __('Blog','oshine-modules'),
	        'is_js_dependant' => true,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'col',
	        		'type' => 'button_group',
	        		'label' => __('Blog Masonry Columns','oshine-modules'),
	        		'options'=> array (
						'three' => __( 'Three', 'oshine-modules' ),
						'four' => __( 'Four', 'oshine-modules' ),
						'five' => __( 'Five', 'oshine-modules' ),
					),
	        		'default' => 'three',
	        		'tooltip' => ''
				),
				array (
	        		'att_name' => 'number_of_posts',
	        		'type' => 'text',
	        		'label' => __( 'Number of Posts', 'oshine-modules' ),
	        		'default' => '',
					'tooltip' => '',
	        	),
				array (
					'att_name' => 'filter_by',
					'type' => 'button_group',
					'label' => __( 'Filter By', 'oshine-modules' ),
					'options' => array (
						'category' => 'Categories',
						'post_tag' => 'Tags',
					),
					'default' => 'category',
					'tooltip' => ''
				),
				array (
					'att_name' => 'categories',
					'type' => 'grouped_checkbox',
					'label' => __( 'Categories', 'oshine-modules' ),
					'options' => $category_options,
					'tooltip' => '',
					'visible' => array ( 'filter_by', '=', 'category' )
				),
				array (
					'att_name' => 'tags',
					'type' => 'grouped_checkbox',
					'label' => 'Tags',
					'options' => $tag_options,
					'tooltip' => '',
					'visible' => array ( 'filter_by', '=', 'post_tag' )
				),
				// array (
	        	// 	'att_name' => 'masonry_style',
	        	// 	'type' => 'button_group',
	        	// 	'label' => __('Grid Style','oshine-modules'),
	        	// 	'options' => array (
				// 		'style3' => 'Style 1',
				// 		'style8' => 'Style 2',
				// 	),
	        	// 	'default' => 'style3',
	        	// 	'tooltip' => ''
	        	// ),
	        	array (
	        		'att_name' => 'gutter_style',
	        		'type' => 'button_group',
	        		'label' => __('Gutter Style','oshine-modules'),
	        		'options' => array (
						'style1' => 'Without Margin',
						'style2' => 'With Margin',
					),
	        		'default' => 'style1',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'gutter_width',
	        		'type' => 'slider',
	        		'label' => __('Gutter Width','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        			'max' => '200',
	        		),
	        		'default' => '40',
	        		'tooltip' => ''
				),
	        ),
	    );
	tatsu_register_module( 'blog', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_team');
function oshine_register_team() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#team',
	        'title' => __( 'Team','oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	        	array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => 'Title',
	        		'default' => '',
	        		'tooltip' => 'Name or Title for the Team Member'
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'button_group',
	        		'label' => __('Heading tag to use for Title','oshine-modules'),
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
	        		'att_name' => 'designation',
	        		'type' => 'text',
	        		'label' => 'Designation',
	        		'default' => '',
	        		'tooltip' => 'Designation of the Team Member'
	        	),
	        	array (
	        		'att_name' => 'description',
	        		'type' => 'text',
	        		'label' => 'Description',
	        		'default' => '',
	        		'tooltip' => 'A brief Description about the Team Member'
	        	),
	        	array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => 'Upload Team Member Image',
	              	'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
		            'label' => 'Title Color',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team-title' => array(
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
		            'label' => 'Designation Color',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .designation' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'description_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
		            'label' => 'Description Color',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team-description' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
	        		'att_name' => 'facebook',
	        		'type' => 'text',
	        		'label' => 'Facebook Profile Url',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'twitter',
	        		'type' => 'text',
	        		'label' => 'Twitter Profile Url',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'google_plus',
	        		'type' => 'text',
	        		'label' => 'Google Plus Profile Url',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'linkedin',
	        		'type' => 'text',
	        		'label' => 'LinkedIn Profile Url',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'youtube',
	        		'type' => 'text',
	        		'label' => 'Youtube Profile Url',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'vimeo',
	        		'type' => 'text',
	        		'label' => 'Vimeo Profile Url',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'dribbble',
	        		'type' => 'text',
	        		'label' => 'Dribbble Profile Url',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'email',
	        		'type' => 'text',
	        		'label' => 'Email ID',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
		            'label' => 'Icon Color',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} i' => array(
							'property' => 'color',
							'when' => array('icon_color', 'notempty'),
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_hover_color',
		            'type' => 'color',
		            'label' => 'Icon Hover Color',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} i:hover' => array(
							'property' => 'color',
							'when' => array('icon_hover_color', 'notempty'),
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_bg_color',
		            'type' => 'color',
		            'label' => 'Icon Background Color',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team_icons' => array(
							'property' => 'background-color',
							'when' => array('icon_bg_color', 'notempty'),
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_hover_bg_color',
		            'type' => 'color',
		            'label' => 'Icon Hover Background Color',
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team_icons:hover' => array(
							'property' => 'background-color',
							'when' => array('icon_hover_bg_color', 'notempty'),
						),
					),
	            ),
	            array (
	        		'att_name' => 'hover_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Style', 'oshine-modules' ),
	        		'options' => array (
						'style1-hover' => 'Style1 - FadeToggle',
						'style2-hover' => 'Style2 - 3D FLIP Horizontal',
						'style3-hover' => 'Style3 - Direction Aware',
						'style4-hover' => 'Style4 - Direction Aware Inverse',
						'style5-hover' => 'Style5 - FadeIn & Scale',
						'style6-hover' => 'Style6 - Fall',
						'style7-hover' => 'Style7 - 3D FLIP Vertical',
						'style8-hover' => 'Style8 - 3D Rotate',
					),
	        		'default' => 'style1-hover',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_style',
	        		'type' => 'button_group',
	        		'label' => __( 'Title & Meta Style', 'oshine-modules' ),
	        		'options' => array (
						'style3' => 'Over Image',
						'style5' => 'Below Image',
					),
	        		'default' => 'style3',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'smedia_icon_position',
	        		'type' => 'button_group',
	        		'label' => __( 'Social Media Icons Position', 'oshine-modules' ),
	        		'options' => array (
	        			'none' => 'None',
						'over' => 'Over Image',
						'below' => 'Below Image'
					),
	        		'default' => 'none',
	        		'visible' => array( 'title_style', '=', 'style5' ),
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_alignment_static',
	        		'type' => 'button_group',
	        		'label' => __( 'Title alignment for "Below Thumbnail" type', 'oshine-modules' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'none',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .team-wrap' => array(
							'property' => 'text-align',
							'when' => array('title_style', '=', 'style5'),
						),
					),
	        	),
	            array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'button_group',
	        		'label' => 'Default Image Style',
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	            array (
	        		'att_name' => 'hover_image_style',
	        		'type' => 'button_group',
	        		'label' => 'Hover Image Style',
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'image_effect',
	        		'type' => 'select',
	        		'label' => 'Image Effects',
	        		'options' => array (
						'zoom-in' => 'Zoom In',
						'zoom-out' => 'Zoom Out',
						'zoom-in-rotate' => 'Zoom In Rotate',
						'zoom-out-rotate' => 'Zoom Out Rotate',
						'none' => 'None'
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'overlay_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => 'Thumbnail Overlay Color',
		            'default' => '',	//color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .thumb-bg' => array(
							'property' => 'background',
							'when' => array('title_style', '=', 'style3'),
						),
						'.tatsu-{UUID} .team-social' => array(
							'property' => 'background',
							'when' => array(
								array('title_style', '!=', 'style3'),
								array('smedia_icon_position', '=', 'over'),
							),
							'relation' => 'and',
						),
					),
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
	            )
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'title' => 'Swami',
						'h_tag' => 'h6',
						'designation' => 'Designer',
						'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque.',
						'image' => 'http://placehold.it/400x400',
						'title_style' => 'style5',
						'smedia_icon_position' => 'over',
						'title_alignment_static' => 'left',
						'facebook' => '#',
						'twitter' => '#',
						'google_plus' => '#',
						'linkedin' => '#',
						'overlay_color' => 'rgba( 255, 255, 255, 0.8 )',

					)
				),
			),
	    );
	tatsu_register_module( 'team', $controls );
}

add_action( 'tatsu_register_modules', 'oshine_register_icon_card');
function oshine_register_icon_card() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#icon_card',
	        'title' => __( 'Icon Card', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'oshine-modules' ),
	        		'options' => array (
						'small'=> 'Small', 
						'large'=> 'Large'
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'oshine-modules' ),
	        		'options' => array (
						'circled'=> 'Circled', 
						'plain'=> 'Plain'
					),
	        		'default' => 'circled',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'icon_bg',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Background Color of Icon if circled', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'background',
							'when' => array('style','=','circled')
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_color',
					'type' => 'color',
		            'label' => __( 'Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_border_color',
		            'type' => 'color',
		            'label' => __( 'Icon Border Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'border',
							'prepend' => '1px solid ',
							'when' => array('style','=','circled')
						),
					),
	            ),
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_font',
	        		'type' => 'select',
	        		'label' => __( 'Font for Title', 'oshine-modules' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h3',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .title' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'caption',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'oshine-modules' ),
	        		'default' => '',
					'tooltip' => '',
				
	        	),
	        	array (
	        		'att_name' => 'caption_font',
	        		'type' => 'select',
	        		'label' => __( 'Font for Caption', 'oshine-modules' ),
	        		'options' => array (
	        			'body'=> 'Body', 
	        			'special' => 'Special Title Font',
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'special',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'caption_color',
		            'type' => 'color',
		            'label' => __( 'Caption Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .caption' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __('Animation Type','oshine-modules'),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	            ),
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'icon' => 'icon-icon_phone',
						'size' => 'small',
						'icon_bg' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'icon_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
						'title' => 'Call Us',
						'title_font' => 'h6',
						'caption' => '+001-987-654-3210'
					)
				),
			),
	    );
	tatsu_register_module( 'icon_card', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_tabs');
function oshine_register_tabs() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#tabs',
	        'title' => __( 'Tabs', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'tab',
	        'type' => 'multi',
	        'initial_children' => 2,
	        'is_built_in' => true,
	        'atts' => array (),
	    );
	tatsu_register_module( 'tabs', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_tab');
function oshine_register_tab() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Tab', 'oshine-modules' ),
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	        		array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Tab Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Choose icon', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Tab Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
 	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __('Title Color','oshine-modules'),
		            'default' => '',//sec_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '#tatsu-{UUID}' => array(
						  'property' => 'color',
					  ),
				  ),
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
	tatsu_register_module( 'tab', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_accordion');
function oshine_register_accordion() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#accordion',
	        'title' => __( 'Accordion Toggles', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'toggle',
	        'allowed_sub_modules' => array( 'toggle' ),
	        'type' => 'multi',
	        'initial_children' => 2,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	              	'att_name' => 'collapsed',
	              	'type' => 'switch',
	              	'label' => __( 'Collapse content', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	        ),
	    );
	tatsu_register_module( 'accordion', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_toggle');
function oshine_register_toggle() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Toggle', 'oshine-modules' ),
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Accordian Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Accordian Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
 	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'oshine-modules' ),
		            'default' => '',//sec_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID}.accordion-head' => array(
						  'property' => 'color',
					  ),
				  ),
					
	            ),
	            array (
		            'att_name' => 'title_bg_color',
		            'type' => 'color',
		            'label' => __( 'Title Background Color', 'oshine-modules' ),
		            'default' => '',//sec_bg
					'tooltip' => '',
					'css' => true,
 					'selectors' => array(
						'.tatsu-{UUID}.accordion-head' => array(
 							'property' => 'background'
 						),
					),
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
	tatsu_register_module( 'toggle', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_flex_slider');
function oshine_register_flex_slider() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#image_slider',
	        'title' => __( 'Image Slider', 'oshine-modules' ),
	        'is_js_dependant' => false, //implements custom css trigger using lifecycle hooks
	        'child_module' => 'flex_slide',
	        'type' => 'multi',
	        'initial_children' => 3,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'slide_show',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Slideshow', 'oshine-modules' ),
	        		'default' => '1',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'slide_show_speed',
	        		'type' => 'slider',
	        		'label' => __( 'Slide Interval if auto slide is enabled', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '10000',
	        			'step' => '1000',
	        			'unit' => 'ms',
	        		),	        		
	        		'default' => '2000',
	        		'tooltip' => ''
	        	),
	        ),
	    );
	tatsu_register_module( 'flex_slider', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_flex_slide');
function oshine_register_flex_slide() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Slide', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Slider image', 'oshine-modules' ),
	              	'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'video',
	        		'type' => 'text',
	        		'label' => __( 'Youtube/ Vimeo url', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),

	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'image' => 'http://placehold.it/1160x600',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'flex_slide', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_testimonials');
function oshine_register_testimonials() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#testimonials',
	        'title' => __( 'Testimonials', 'oshine-modules' ),
	        'is_js_dependant' => false, //custom js implementation
	        'child_module' => 'testimonial',
	        'type' => 'multi',
	        'initial_children' => 2,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'testimonial_font_size',
	        		'type' => 'slider',
	        		'label' => __( 'Testimonial Font Size', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '14',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .testimonial-content' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),
	        	),
	        	array (
	        		'att_name' => 'author_role_font',
	        		'type' => 'select',
	        		'label' => __( 'Author Role - Font Type', 'oshine-modules' ),
	        		'options' => array (
						'body'=> 'Body', 
						'special' => 'Special Title Font', 
						'h6' => 'Heading 6'
					),
	        		'default' => 'h6',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'pagination',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Pagination', 'oshine-modules' ),
	              	'default' => false,
	              	'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'slide_show',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Slide Show', 'oshine-modules' ),
	        		'default' => 'no',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'slide_show_speed',
	        		'type' => 'slider',
	        		'label' => __( 'Slide Show Speed', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '10000',
	        			'step' => '1000',
	        			'unit' => 'ms',
	        		),
	        		'default' => '4000',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'testimonial_font_size' => '22',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'testimonials', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_testimonial');
function oshine_register_testimonial() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Testimonial', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Testimonial Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),
 	        	array (
	              	'att_name' => 'author_image',
	              	'type' => 'single_image_picker',
	              	'options' => array(
	              		'size' => 'thumbnail',
	              	),
	              	'label' => __( 'Testimonial Author Image', 'oshine-modules' ),
	              	'tooltip' => '',
	            ),
	            array (
		            'att_name' => 'quote_color',
					'type' => 'color',
		            'label' => __( 'Quote Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .icon-quote' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'author',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Author', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'author_color',
					'type' => 'color',
		            'label' => __( 'Testimonial Author Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .testimonial-author' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'author_role',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Author Role', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'author_role_color',
					'type' => 'color',
		            'label' => __( 'Testimonial Author Role Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .testimonial-author-role' => array(
							'property' => 'color',
						),
					),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
	        			'author_image' => 'http://placehold.it/100x100',
	        			'author' => 'Swami',
	        			'author_role' => 'Designer',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'testimonial', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_content_slides');
function oshine_register_content_slides() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#content_slider',
	        'title' => __( 'Content Slider', 'oshine-modules' ),
	        'is_js_dependant' => false, //custom implementation
	        'child_module' => 'content_slide',
	        'type' => 'multi',
	        'initial_children' => 3,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'slide_show',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Slide Show', 'oshine-modules' ),
	        		'default' => 0,
	        		'tooltip' => ''
	        	),
	            array (
	        		'att_name' => 'slide_show_speed',
	        		'type' => 'slider',
	        		'label' => __( 'Slide Show Speed', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '10000',
	        			'step' => '1000',
	        			'unit' => 'ms',
	        		),	        		
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'content_max_width',
	        		'type' => 'slider',
	        		'label' => __( 'Content Max Width', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	 	        		
	        		'default' => '100',
	        		'tooltip' => ''
	        	),
	        	// array (
		        //     'att_name' => 'bullets_color',
		        //     'type' => 'color',
		        //     'label' => __( 'Navigation Color', 'oshine-modules' ),
		        //     'default' => '',
		        //     'tooltip' => '',
	         //    ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content_max_width' => '70',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'content_slides', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_content_slide');
function oshine_register_content_slide() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Content Slide', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'content_slide', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_recent_posts');
function oshine_register_recent_posts() {
		$post_categories = get_categories();
		$post_tags = get_tags();
		$category_options = array();
		$tag_options = array();
		foreach( $post_categories as $category ) {
			if( is_object( $category ) ) {
				$category_options[ $category->slug ] = $category->name;
			}
		}
		foreach( $post_tags as $tag ) {
			if( is_object( $tag ) ) {
				$tag_options[ $tag->slug ] = $tag->name;
			}
		}
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#recent_posts',
	        'title' => __( 'Recent - Blog Posts Masonry Style', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'number',
	        		'type' => 'button_group',
	        		'label' => __( 'Number of Items', 'oshine-modules' ),
	        		'options' => array (
						'three' => 'Three',
						'four' => 'Four',
					),
	        		'default' => 'three',
	        		'tooltip' => ''
				),
				array (
					'att_name' => 'filter_by',
					'type' => 'button_group',
					'label' => __( 'Filter By', 'oshine-modules' ),
					'options' => array (
						'category' => 'Categories',
						'post_tag' => 'Tags',
					),
					'default' => 'category',
					'tooltip' => ''
				),
				array (
					'att_name' => 'categories',
					'type' => 'grouped_checkbox',
					'label' => __( 'Categories', 'oshine-modules' ),
					'options' => $category_options,
					'tooltip' => '',
					'visible' => array ( 'filter_by', '=', 'category' )
				),
				array (
					'att_name' => 'tags',
					'type' => 'grouped_checkbox',
					'label' => 'Tags',
					'options' => $tag_options,
					'tooltip' => '',
					'visible' => array ( 'filter_by', '=', 'post_tag' )
				),
	        	array (
	              	'att_name' => 'hide_excerpt',
	              	'type' => 'switch',
	              	'label' => __( 'Hide Excerpt', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	        ),
	    );
	tatsu_register_module( 'recent_posts', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_grids');
function oshine_register_grids() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#grids',
	        'title' => __( 'Icon/Image Grid', 'oshine-modules' ),
			'is_js_dependant' => true,
			'child_module' => 'grid_content',
	        'type' => 'multi',
	        'initial_children' => 4,
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'column',
	        		'type' => 'slider',
	        		'label' => __( 'Columns', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '12',
	        			'step' => '1'
	        		),
	        		'default' => '1',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Border Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .grid-col' => array(
							'property' => 'border-color'
						)
					)
	            ),
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'column' => '2',
	        			'border_color' => '#efefef',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'grids', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_grid_content');
function oshine_register_grid_content() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Grid Content', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'sub_module',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'icon_size',
	        		'type' => 'button_group',
	        		'label' => __( 'Icon Size', 'oshine-modules' ),
	        		'options' => array (
						'tiny' => 'Tiny',
						'small' => 'Small',
						'medium' => 'Medium', 
						'large' => 'Large',
						'xlarge' => 'XL'
					),
	        		'default' => 'medium',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
		            'label' => __( 'Icon Color', 'oshine-modules' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'color'
						)
					)
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'icon' => 'icon-icon_desktop',
	        			'icon_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'content' => '<h6>Title goes here</h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',

	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'grid_content', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_pricing_column');
function oshine_register_pricing_column() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#pricing_table',
	        'title' => __( 'Pricing Table', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => 'pricing_feature',
	        'type' => 'multi',
	        'initial_children' => 5,
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style Options', 'oshine-modules' ),
	        		'options' => array (
						'style-1' => 'Normal Header', 
						'style-2' => 'Colored Header', 
					),
	        		'default' => 'style-1',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'header_bg_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Header Background Color (Applied on Colored Header)', 'oshine-modules' ),
		            'default' => '',//color_scheme global theme data
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .pricing-title' => array(
							'property' => 'background-color',
							'when' => array( 'style', '=', 'style-2' ),
						),
					),
	            ),
	        	array (
		            'att_name' => 'header_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Header Text Color (Applied on Colored Header)', 'oshine-modules' ),
		            'default' => '',//alt_bg_text_color global theme data
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .pricing-title-head-tag' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'select',
	        		'label' => __( 'Title Heading Tag', 'oshine-modules' ),
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
	        		'att_name' => 'price',
	        		'type' => 'text',
	        		'label' => __( 'Price', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'duration',
	        		'type' => 'text',
	        		'label' => __( 'Duration', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'currency',
	        		'type' => 'text',
	        		'label' => __( 'Currency', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'button_text',
	        		'type' => 'text',
	        		'label' => __( 'Button Text', 'oshine-modules' ),
	        		'default' => __( 'Click Here', 'oshine-modules' ),
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'button_link',
	        		'type' => 'text',
	        		'label' => __( 'Url to be linked to the button', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'button_color',
		            'type' => 'color',
		            'label' => __( 'Button Text Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_hover_color',
		            'type' => 'color',
		            'label' => __( 'Button Text Hover Color', 'oshine-modules' ),
		            'default' => '',//alt_bg_text_color
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_bg_color',
		            'type' => 'color',
		            'label' => __( 'Button Background Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_bg_hover_color',
		            'type' => 'color',
		            'label' => __( 'Button Background Hover Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_border_color',
		            'type' => 'color',
		            'label' => __( 'Button Border Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'button_border_hover_color',
		            'type' => 'color',
		            'label' => __( 'Button Border Hover Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'highlight',
	        		'type' => 'button_group',
	        		'label' => __( 'Highlight Column', 'oshine-modules' ),
	        		'options' => array (
						'yes' => 'Yes',
						'no' => 'No',
					),
	        		'default' => 'yes',
	        		'tooltip' => ''
	        	),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'style' => 'style-2', 
	        			'header_bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'header_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'title' => 'GOLD',
	        			'price' => '25',
	        			'duration' => 'per month',
	        			'currency' => '$',
	        			'button_bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'button_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),	        			
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'pricing_column', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_pricing_feature');
function oshine_register_pricing_feature() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Pricing Feature', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'feature',
	        		'type' => 'text',
	        		'label' => __( 'Feature', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'highlight',
	              	'type' => 'switch',
	              	'label' => __( 'Highlight this section ?', 'oshine-modules') ,
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
		            'att_name' => 'highlight_color',
		            'type' => 'color',
		            'label' => __( 'Highlight Color', 'oshine-modules' ),
		            'default' => '',//sec_bg
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.pricing-feature' => array(
							'property' => 'background-color',
							'when' => array( 'highlight', '=', '1' ),
						),
					),
	            ),
	            array (
		            'att_name' => 'highlight_text_color',
		            'type' => 'color',
		            'label' => __( 'Highlight Text Color', 'oshine-modules' ),
		            'default' => '',//sec_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .pricing-feature-container' => array(
							'property' => 'color',
							'when' => array( 'highlight', '=', '1' ),
						),
					),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'feature' => 'Cool Feature Here',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'pricing_feature', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_skills');
function oshine_register_skills() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#skills',
	        'title' => __( 'Skills', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'skill',
	        'type' => 'multi',
	        'initial_children' => 4,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'direction',
	        		'type' => 'button_group',
	        		'label' => __( 'Direction', 'oshine-modules' ),
	        		'options' => array (
						'horizontal' => 'Horizontal', 
						'vertical' => 'Vertical'
					),
	        		'default' => 'horizontal',
	        		'tooltip' => ''
	        	),
				array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Skill Height if Vertical Direction', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '400',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.skill-vertical .skill-bar' => array(
							'property' => 'height',
							'append' => 'px',
						),
					),
	        	),
	        ),
	    );
	tatsu_register_module( 'skills', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_skill');
function oshine_register_skill() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Skill', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Skill Name', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Title Color', 'oshine-modules' ),
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
	        		'att_name' => 'value',
	        		'type' => 'slider',
	        		'label' => __( 'Skill Score', 'oshine-modules' ),
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
		            'label' => __( 'Fill Color', 'oshine-modules' ),
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
		            'label' => __( 'Background Color', 'oshine-modules' ),
		            'default' => '', //sec_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID} .skill-bar' => array(
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
	        			'fill_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'bg_color' => '#f2f5f8',
	        			'value' => '70',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'skill', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_clients');
function oshine_register_clients() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#clients',
	        'title' => __( 'Clients', 'oshine-modules' ),
	        'is_js_dependant' => false, //custom implementation
	        'child_module' => 'client',
	        'type' => 'multi',
	        'initial_children' => 5,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'slide_show',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Slide Show', 'oshine-modules' ),
	        		'default' => '0',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'slide_show_speed',
	        		'type' => 'slider',
	        		'label' => __( 'Slide Show Speed', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '10000',
	        			'step' => '1000',
	        			'unit' => 'ms',
	        		),		        		
	        		'default' => '4000',
	        		'tooltip' => ''
	        	),
	        ),
	    );
	tatsu_register_module( 'clients', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_client');
function oshine_register_client() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Client', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Choose a Client image', 'oshine-modules' ),
	              	'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'link',
	        		'type' => 'text',
	        		'label' => __( 'URL to be linked to Client Website', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	            array (
	        		'att_name' => 'new_tab',
	        		'type' => 'switch',
	        		'label' => __( 'Open Link in New tab', 'oshine-modules' ),
	        		'default' => '1',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'button_group',
	        		'label' => __( 'Default Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White', 
						'color' => 'Color',
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_image_style',
	        		'type' => 'button_group',
	        		'label' => __( 'Hover Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White', 
						'color' => 'Color',
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'image' => 'http://placehold.it/300x100',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'client', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_services');
function oshine_register_services() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#services',
	        'title' => __( 'Services', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => 'service',
	        'type' => 'multi',
	        'initial_children' => 3,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
		            'att_name' => 'line_color',
		            'type' => 'color',
		            'label' => __( 'Timeline Color', 'oshine-modules' ),
		            'default' => '',//sec_border
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .timeline' => array(
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
	        			'line_color' => '#efefef',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'services', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_service');
function oshine_register_service() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Service', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Service Icon', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'icon_size',
	        		'type' => 'button_group',
	        		'label' => __( 'Service Icon Size', 'oshine-modules' ),
	        		'options' => array (
						'small'	=>	'Small',
						'medium' => 'Medium',
						'large' => 'Large'
					),
	        		'default' => 'medium',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'icon_bg_color',
		            'type' => 'color',
		            'label' => __( 'Service Icon Background Color', 'oshine-modules' ),
		            'default' => '',//sec_bg
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .service-icon' => array(
							'property' => 'background-color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
		            'label' => __( 'Service Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .service-icon' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Service Icon Hover Background Color', 'oshine-modules' ),
		            'default' => '',//color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .service-wrap:hover .service-icon' => array(
							'property' => 'background-color',
						),
					),
	            ),
	        	array (
		            'att_name' => 'icon_hover_color',
		            'type' => 'color',
		            'label' => __( 'Service Icon Hover Color', 'oshine-modules'),
		            'default' => '',//alt_bg_text_color
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .service-wrap:hover .service-icon' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Servies Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
 	        	array (
		            'att_name' => 'content_bg_color',
		            'type' => 'color',
		            'label' => __( 'Services content BG color', 'oshine-modules' ),
		            'default' => '',//sec_bg
					'tooltip' => '',
					'css' => true,
				  	'selectors' => array(
					    '.tatsu-{UUID} .service-content' => array(
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
	        			'icon' => 'icon-icon_desktop',
	        			'icon_bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'icon_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',	        			
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'service', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_animate_icons_style1');
function oshine_register_animate_icons_style1() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#animated_module',
	        'title' => __( 'Fixed Height Animated Module', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'animate_icon_style1',
	        'type' => 'multi',
	        'initial_children' => 3,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '300',
					'tooltip' => '',
					'responsive' => true,
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-module-style1-wrap' => array(
							'property' => 'height',
							'append' => 'px',
						),
					),
	        	),
	        	array (
	        		'att_name' => 'gutter',
	        		'type' => 'number',
	        		'label' => __( 'Gutter Width', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),	        		
	        		'default' => '40',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-module-style1' => array(
							'property' => 'margin-bottom',
							'append' => 'px',
						),
					),
	        	),
	        ),
	    );
	tatsu_register_module( 'animate_icons_style1', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_animate_icon_style1');
function oshine_register_animate_icon_style1() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Animate Module Element', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'link_to_url',
	        		'type' => 'text',
	        		'label' => __( 'URL to be linked', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'bg_image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Background Image', 'oshine-modules' ),
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}' => array(
							'property'=> 'background-image',
						),
					),
	            ),
	            array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID}' => array(
						  'property' => 'background-color',
					  ),
				  ),
	            ),
	            array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color - Hover State', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID}:hover' => array(
						  'property' => 'background-color',
					  ),
				  ),
	            ),
	            array (
	              	'att_name' => 'bg_overlay',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Overlay', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
		            'att_name' => 'overlay_color',
		            'type' => 'color',
		            'label' => __( 'Overlay Background Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID} .ai-overlay' => array(
						  'property' => 'background-color',
					  ),
				  ),
	            ),
	            array (
		            'att_name' => 'hover_overlay_color',
		            'type' => 'color',
		            'label' => __( 'Hover Overlay Background Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
					  '.tatsu-{UUID}:hover .ai-overlay' => array(
						  'property' => 'background-color',
					  ),
				  ),
	            ),
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'slider',
	        		'label' => __( 'Icon Size', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '30',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'font-size',
							'append' => 'px'
						),
					),
	        	),
	        	array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_font',
	        		'type' => 'button_group',
	        		'label' => __( 'Title Tag', 'oshine-modules' ),
	        		'options' => array (
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
		            'att_name' => 'icon_color',
					'type' => 'color',
		            'label' => __( 'Icon and Title Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .font-icon' => array(
							'property' => 'color',
						),
						'.tatsu-{UUID} .title_content' =>  array(
							'property' => 'color',
						)
					),
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content on Hover', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),
 	        	array (
	        		'att_name' => 'animate_direction',
	        		'type' => 'select',
	        		'label' => __( 'Animation', 'oshine-modules' ),
	        		'options' => array (
						'top' => 'Slide Top', 
						'left' => 'Slide Left', 
						'right' => 'Slide Right', 
						'bottom' => 'Slide Bottom', 
						'fade' => 'Fade'
					),
	        		'default' => 'top',
	        		'tooltip' => ''
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'bg_color' => '#000',
	        			'hover_bg_color' => '#232323',
	        			'icon' => 'icon-icon_desktop',
	        			'title' => 'Title Goes Here',
	        			'content' => '<span style="color:#fff;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</span>',
	        			'icon_color' => '#ffffff',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'animate_icon_style1', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_special_sub_title');
function oshine_register_special_sub_title() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_subtitle',
	        'title' => __( 'Sub Title Module', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'title_content',
	        		'type' => 'text',
	        		'label' => __( 'Sub Title Text', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'font_size',
	        		'type' => 'number',
	        		'label' => __( 'Font Size', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '18',
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-subtitle' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),					
	        	),
	        	array (
		            'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Title Color', 'oshine-modules' ),
		            'default' => '',	//color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-subtitle' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'title_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Title Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'max_width',
	        		'type' => 'slider',
	        		'label' => __( 'Maximum Width', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	
	        		'default' => '60',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-subtitle' => array(
							'property' => 'width',
							'append' => '%',
						),
					),
					
	        	),
	        	array (
	        		'att_name' => 'margin_bottom',
	        		'type' => 'number',
	        		'label' => __( 'Margin Bottom', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '30',
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-subtitle-wrap' => array(
							'property' => 'margin-bottom',
							'append' => 'px',
						),
					),
	        	),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'This is a cool subtitle',
	        			'title_alignment' => 'left',
	        			'margin_bottom' => '10',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_sub_title', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_newsletter');
function oshine_register_newsletter() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#newsletter',
	        'title' => __( 'Newsletter', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'api_key',
	        		'type' => 'text',
	        		'label' => __( 'Mailchimp.com Api key', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'id',
	        		'type' => 'text',
	        		'label' => __( 'Mailchimp.com List ID', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'width',
	        		'type' => 'slider',
	        		'label' => __( 'Width', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	
	        		'default' => '100',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'left',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'button_text',
	        		'type' => 'text',
	        		'label' => __( 'Button Text', 'oshine-modules' ),
	        		'default' => __( 'Submit', 'oshine-modules' ),
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Button Background Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit' =>  array(
							'property' => 'background'
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Button Hover Background Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit:hover' =>  array(
							'property' => 'background'
						),
					),
	            ),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'Button Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit' =>  array(
							'property' => 'color'
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_color',
		            'type' => 'color',
		            'label' => __( 'Button Hover Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit:hover' =>  array(
							'property' => 'color'
						),
					),
	            ),
	            array (
	        		'att_name' => 'border_width',
	        		'type' => 'number',
	        		'label' => __( 'Button Border Width', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit' =>  array(
							'property' => 'border-width',
							'append' => 'px',
						),
					),
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Button Border Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit' =>  array(
							'property' => 'border-color'
						),
					),
	            ),
	        	array (
		            'att_name' => 'hover_border_color',
		            'type' => 'color',
		            'label' => __( 'Button Hover Border Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'border_width', '>', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .oshine-mc-submit:hover' =>  array(
							'property' => 'border-color'
						),
					),
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'newsletter', $controls );
}



// add_action( 'tatsu_register_modules', 'oshine_register_rotates');
// function oshine_register_rotates() {
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __( 'Rotates', 'oshine-modules' ),
// 	        'is_js_dependant' => true,
// 	        'child_module' => '',
// 	        'type' => 'single',
// 	        'is_built_in' => false,
// 	        'atts' => array (
// 	            array (
// 	              	'att_name' => 'animation',
// 	              	'type' => 'select',
// 	              	'label' => __( 'Animation Type', 'oshine-modules' ),
// 	              	'options' => array(
// 	              		'fade' => 'Fade',
// 	              	),
// 	              	'default' => 'fade',
// 	              	'tooltip' => '',
// 	              	'dependantField' => 'animate'
// 	            ),
// 	            array (
// 	        		'att_name' => 'speed',
// 	        		'type' => 'slider',
// 	        		'label' => __( 'Animation Speed', 'oshine-modules' ),
// 	        		'options' => array(
// 	        			'min' => '0',
// 	        			'max' => '10000',
// 	        			'unit' => 'ms',
// 	        			'step' => '10000',
// 	        		),
// 	        		'default' => '1000',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'content',
// 	        		'type' => 'tinymce',
// 	        		'label' => __( 'Content Editor', 'oshine-modules' ),
// 	        		'default' => '',
// 	        		'tooltip' => ''
//  	        	),
// 	        ),
// 	        'presets' => array(
// 	        	'default' => array(
// 	        		'title' => '',
// 	        		'image' => '',
// 	        		'preset' => array(
// 	        			'content' => 'Tatsu is [rotate]Simple[/rotate][rotate]Powerful[/rotate][rotate]Elegant[/rotate]'
// 	        		),
// 	        	)
// 	        ),	     
// 	    );
// 	tatsu_register_module( 'rotates', $controls );
// }



// add_action( 'tatsu_register_modules', 'oshine_register_typed');
// function oshine_register_typed() {
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __( 'Typed', 'oshine-modules' ),
// 	        'is_js_dependant' => false,
// 	        'child_module' => '',
// 	        'type' => 'single',
// 	        'is_built_in' => false,
// 	        'atts' => array (
// 	        	array (
// 	        		'att_name' => 'content',
// 	        		'type' => 'tinymce',
// 	        		'label' => __( 'Content Editor', 'oshine-modules' ),
// 	        		'default' => '',
// 	        		'tooltip' => ''
//  	        	),
// 	        ),
// 	    );
// 	tatsu_register_module( 'typed', $controls );
// }


add_action( 'tatsu_register_modules', 'oshine_register_contact_form');
function oshine_register_contact_form() {
	$controls = array (
        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#contact_form',
        'title' => __( 'Contact Form', 'oshine-modules' ),
        'is_js_dependant' => false,
        'child_module' => '',
        'type' => 'single',
        'is_built_in' => false,
        'atts' => array (
        	array (
        		'att_name' => 'form_style',
        		'type' => 'button_group',
        		'label' => __( 'Form Style', 'oshine-modules' ),
        		'options' => array(
        			'style1' => 'One Column',
        			'style2' => 'Two Column'
        		),
        		'default' => 'style1',
        		'tooltip' => ''
        	), 
			array (
	            'att_name' => 'input_bg_color',
	            'type' => 'color',
	            'label' => __( 'Input Background Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} input[type="text"], .tatsu-{UUID} textarea' => array(
						'property' => 'background-color',
					),
				),
            ),
			array (
	            'att_name' => 'input_color',
	            'type' => 'color',
	            'label' => __( 'Input Text Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} input[type="text"], .tatsu-{UUID} textarea' => array(
						'property' => 'color',
					),
				),
            ),
        	array (
        		'att_name' => 'border_width',
        		'type' => 'number',
        		'options' => array(
        			'unit' => 'px',
        		),
        		'label' => __( 'Border Size', 'oshine-modules' ),
        		'default' => '',
				'tooltip' => '',
				// 'css' => true,
				// 'selectors' => array(
				// 	'.tatsu-{UUID} input[type="text"], .tatsu-{UUID} textarea' => array(
				// 		'property' => 'border-width',
				// 		'append' => 'px',
				// 	),
				// ),
        	),            
			array (
	            'att_name' => 'input_border_color',
	            'type' => 'color',
	            'label' => __( 'Input Border Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} input[type="text"], .tatsu-{UUID} textarea' => array(
						'property' => 'border-color',
					),
				),
            ),
        	array (
        		'att_name' => 'input_height',
        		'type' => 'number',
        		'options' => array(
        			'unit' => 'px',
        		),        		
        		'label' => __( 'Input Box Height', 'oshine-modules' ),
        		'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} input[type="text"]' => array(
						'property' => 'height',
						'append' => 'px',
					),
				),
        	),
        	array (
        		'att_name' => 'input_style',
        		'type' => 'button_group',
        		'label' => __( 'Input Box Style', 'oshine-modules' ),
        		'options' => array(
        			'style1' => 'Boxed', 
        			'style2' => 'Underline'
        		),
        		'default' => 'style1',
        		'tooltip' => ''
        	),
        	array (
        		'att_name' => 'input_button_style',
        		'type' => 'button_group',
        		'label' => __( 'Button Style', 'oshine-modules' ),
        		'options' => array(
        			'small' => 'Small', 
        			'medium' => 'Medium', 
        			'large' => 'Large', 
        			'block' => 'Block'
        		),
        		'default' => 'medium',
        		'tooltip' => ''
        	),
			array (
	            'att_name' => 'bg_color',
	            'type' => 'color',
	            'label' => __( 'Button Background Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .contact_submit' => array(
						'property' => 'background-color',
					),
				),
            ),
			array (
	            'att_name' => 'color',
	            'type' => 'color',
	            'label' => __( 'Button Text Color', 'oshine-modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .contact_submit' => array(
						'property' => 'color',
					),
				),
            ),                   		        		        	       	                   	
        ),
        'presets' => array(
        	'default' => array(
        		'title' => '',
        		'image' => '',
        		'preset' => array(
        			'border_width' => '2',
        			'input_border_color' => 'rgba(0,0,0,0.4)',
        			'input_style' => 'boxed',
        		),
        	)
        ), 
    );

	tatsu_register_module( 'contact_form', $controls );	
}



add_action( 'tatsu_register_modules', 'oshine_register_tweets');
function oshine_register_tweets() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#tweets',
	        'title' => __( 'Tweets', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	        	array (
	        		'att_name' => 'account_name',
	        		'type' => 'text',
	        		'label' => __( 'Twitter Account Name', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'count',
	        		'type' => 'slider',
	        		'label' => __( 'Number of tweets', 'oshine-modules' ),
	        		'options' => array(
	        			'max' => '10',
	        			'min' => '1',
	        			'step' => '1',
	        		),
	        		'default' => '3',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'content_size',
	        		'type' => 'number',
	        		'label' => __( 'Tweet Font Size', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '12',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tweet-content' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),
	        	),
				array (
		            'att_name' => 'tweet_bird_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Tweet Bird Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .icon-twitter' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
		            'att_name' => 'color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .tweet-content' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
	            array (
	        		'att_name' => 'slide_show',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Slide Show', 'oshine-modules' ),
	        		'default' => '0',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'slide_show_speed',
	        		'type' => 'slider',
	        		'label' => __( 'Slide Show Speed', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '10000',
	        			'step' => '1000',
	        			'unit' => 'ms',
	        		),		        		
	        		'default' => '4000',
					'tooltip' => '',
					'visible' => array('slide_show', '=', '1'),
	        	),	        	
	            array (
	              	'att_name' => 'pagination',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Pagination', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ),        		        		        		            	            	        		        		        	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'account_name' => 'envato',
	        			'content_size' => '20',
	        			'tweet_bird_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tweets', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_be_slider');
function oshine_register_be_slider() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#be_slider',
	        'title' => __( 'BE Slider', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'be_slide',
	        'type' => 'multi',
	        'initial_children' => 3,
	        'is_built_in' => false,
	        'atts' => array (
	        	array (
	        		'att_name' => 'animation_type',
	        		'type' => 'select',
	        		'label' => __('Slider Transition','oshine-modules'),
	        		'options' => array(
	        			'fxSoftScale' => 'Soft Scale', 
	        			'fxPressAway' => 'Press Away', 
	        			'fxSideSwing' => 'Side Swing', 
	        			'fxFortuneWheel' => 'Fortune Wheel', 
	        			'fxSwipe' => 'Swipe', 
	        			'fxPushReveal' => 'Push Reveal', 
	        			'fxSnapIn' => 'Snap In', 
	        			'fxLetMeIn' => 'Let Me In', 
	        			'fxStickIt' => 'Stick It', 
	        			'fxArchiveMe' => 'Archive Me', 
	        			'fxVGrowth' => 'VGrowth', 
	        			'fxSlideBehind' => 'Slide Behind', 
	        			'fxSoftPulse' => 'Soft Pulse', 
	        			'fxEarthquake' => 'Earthquake', 
	        			'fxCliffDiving' => 'Cliff Diving',
	        		),
	        		'default' => 'fxSoftScale',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'slider_height',
	        		'type' => 'number',
	        		'label' => __('Slider Height','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '360',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'slider_mobile_height',
	        		'type' => 'number',
	        		'label' => __('Slider Height in Mobile Devices','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '360',
	        		'tooltip' => ''
	        	),	        		        
	        ),
	    );
	tatsu_register_module( 'be_slider', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_be_slide');
function oshine_register_be_slide() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'BE Slide', 'oshine-modules' ),
	        'type' => 'sub_module',
	        'is_built_in' => false,
	        'atts' => array (
				array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Slider image', 'oshine-modules' ),
	              	'default' => '',
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'bg_video',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Background Video', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'bg_video_mp4_src',
	        		'type' => 'text',
	        		'label' => __( '.MP4 Video File', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'bg_video_ogg_src',
	        		'type' => 'text',
	        		'label' => __( '.OGG Video File', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'bg_video_webm_src',
	        		'type' => 'text',
	        		'label' => __( '.Webm Video File', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	        	
	        	array (
	        		'att_name' => 'content_width',
	        		'type' => 'slider',
	        		'label' => __( 'Content Width', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => '%',
	        			'min' => '1',
	        			'max' => '100',
	        			'step' => '1',
	        		),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	            array (
	              'att_name' => 'position',
	              'type' => 'input_group',
	              'label' => __( 'Content Position', 'oshine-modules' ),
	              'default' => '10% 10% 10% 10%',
	              'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'content_animation_type',
	              	'type' => 'select',
	              	'label' => __('Content Animation','oshine-modules'),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	            ), 	        			        		        		        		        		        		        		        		        		           
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'image' => 'http://placehold.it/1160x600',
	        			'content' => '<h5>Here is a Title</h5>Proin facilisis varius nunc. Curabitur eros risus, ultrices et dui ut, luctus accumsan nibh.',
	        			'content_width' => '80'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'be_slide', $controls );
}

//Change Module to process , instead of process_style1

add_action( 'tatsu_register_modules', 'oshine_register_process');
function oshine_register_process() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#process',
	        'title' => __( 'Process', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => 'process_col',
	        'initial_children' => 4,
	        'type' => 'multi',
	        'is_built_in' => true,
	        'atts' => array (
				array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Border Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .process-sep' => array(
							'property' => 'background'
						)
					)
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'border_color' => '#efefef', //sec_border
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'process_style1', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_process_col');
function oshine_register_process_col() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Process Item', 'oshine-modules' ),
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
 	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => '',
	        	),
				array (
		            'att_name' => 'icon_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true
					),
		            'label' => __( 'Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.process-col .font-icon' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
	        		'att_name' => 'icon_size',
	        		'type' => 'slider',
	        		'label' => __( 'Icon Size', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '120',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),		        		
	        		'default' => '60',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.process-col .font-icon' => array(
							'property' => 'font-size',
							 'append' => 'px'
						),
					),
	        	),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ), 	        	        		            	        	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'icon' => 'icon-icon_desktop',
	        			'icon_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'icon_size' => '45',
	        			'content' => '<h6>Here is a Title</h6><p>Proin facilisis varius nunc. Curabitur eros risus, ultrices et dui ut, luctus accumsan nibh.</p>',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'process_col', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_menu_card');
function oshine_register_menu_card() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#menu_card',
	        'title' => __( 'Card', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	        	array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'ingredients',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'price',
	        		'type' => 'text',
	        		'label' => __( 'Price', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
				array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .menu-card-title' => array(
							'property' => 'color'
						),
					),
	            ),
				array (
		            'att_name' => 'ingredients_color',
		            'type' => 'color',
		            'label' => __( 'Caption Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .menu-card-ingredients' => array(
							'property' => 'color'
						),
					),
	            ),
				array (
		            'att_name' => 'price_color',
		            'type' => 'color',
		            'label' => __( 'Price Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .menu-card-item-price' => array(
							'property' => 'color'
						),
					),
					
	            ),
	            array (
	              	'att_name' => 'highlight',
	              	'type' => 'switch',
	              	'label' => __( 'Highlight this item', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	            
				array (
		            'att_name' => 'highlight_color',
		            'type' => 'color',
		            'label' => __( 'Highlight Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.menu-card-item' => array(
							'property' => 'background',
							'when' => array('highlight','=','1')
						),
					),
	            ),	
	            array (
	              	'att_name' => 'star',
	              	'type' => 'switch',
	              	'label' => __( 'Mark item with a Star', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
		            'att_name' => 'star_color',
		            'type' => 'color',
		            'label' => __( 'Star Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .menu-card-item-stared' => array(
							'property' => 'color'
						),
					),
	            ),
				array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Border Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
					'visible' => array( 'highlight', '==', '0' ),
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.menu-card-item' => array(
							'property' => 'border-color'
						),
					),
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ),	            	            	            	                        	            	            	        		        		        	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title' => 'Pasta Primavera',
	        			'ingredients' => 'Penne, Tomatoes, Onions, Capsicum, Cream, Garlic',
	        			'price' => '$12',
	        			'border_color' => '#efefef',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'menu_card', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_be_countdown');
function oshine_register_be_countdown() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#countdown',
	        'title' => __( 'Countdown', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	        	array (
	        		'att_name' => 'date_time',
	        		'type' => 'text',
	        		'label' => __( 'Countdown End Date & Time in YYYY-MM-DD HH:MM:SS format', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),	        	
				array (
		            'att_name' => 'text_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Text Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .countdown-section' => array(
							'property' => 'color'
						)
					),
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'date_time' => '2018-01-01 00:00:00',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'be_countdown', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_portfolio');
function oshine_register_portfolio() {

		$portfolio_categories = get_terms('portfolio_categories');
		$options = array();
		foreach ( $portfolio_categories as $category ) {
			if( is_object( $category ) ) {
				$options[$category->slug] = $category->name;
			}
		}

		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#portfolio',
	        'title' => __( 'Portfolio', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	        	array (
	        		'att_name' => 'col',
	        		'type' => 'button_group',
	        		'label' => __( 'Number of Columns', 'oshine-modules' ),
					'options'=> array (
						'one' => 'One',
						'two' => 'Two',
						'three' => 'Three',
						'four' => 'Four',
						'five' => 'Five', 
					),
	        		'default' => 'three',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'gutter_style',
	        		'type' => 'select',
	        		'label' => __( 'Gutter Style', 'oshine-modules' ),
					'options' => array (
						'style1' => 'With Margin',
						'style2' => 'Without Margin',
					),
	        		'default' => 'style1',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'gutter_width',
	        		'type' => 'number',
	        		'label' => __('Gutter Width','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '40',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'masonry',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Masonry Layout', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
				),
				array (
					'att_name' => 'maintain_order',
					'type'	=> 'switch',
					'label' => __( 'Maintain Order', 'oshine-modules' ),
					'default' => 0,
					'tooltip' => '',
				),		        	
				array (
					'att_name' => 'show_filters',
					'type' => 'switch',
					'label' => __( 'Filterable Portfolio', 'oshine-modules' ),
					'default' => 1,
				),
	        	array (
	        		'att_name' => 'filter',
	        		'type' => 'button_group',
	        		'label' => __( 'Filter To Use', 'oshine-modules' ),
					'options'=> array(
						'portfolio_categories' => 'Categories', 
						'portfolio_tags' => 'Tags', 
					),
	        		'default' => 'portfolio_categories',
	        		'tooltip' => ''
	        	),	
	        	array (
	        		'att_name' => 'category',
	        		'type' => 'grouped_checkbox',
	        		'label' => __( 'Portfolio Categories', 'oshine-modules' ),
	        		'options' => $options,
	        	),	        	
	        	array (
	        		'att_name' => 'lazy_load',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Lazy Load', 'oshine_modules' ),
	        		'default' => 0,
	        		'tooltip' => 'Lazy Load'
	        	),
	        	array (
	        		'att_name' => 'delay_load',
	        		'type' => 'switch',
	        		'label' => __( 'Reveal items only on scroll', 'oshine_modules' ),
	        		'default' => 0,
	        		'tooltip' => 'Delay Load Grid'
	        	),
				array (
					'att_name' => 'placeholder_color',
					'type' => 'color',
					'label' => __( 'Grid Placeholder Color', 'oshine_modules' ),
					'default' => '',
					'tooltip' => ''
				),		
				array (
	        		'att_name' => 'pagination',
	        		'type' => 'select',
	        		'label' => __( 'Pagination Style', 'oshine-modules' ),
					'options' => array (
						'none'	=> 'None',
						'infinite' => 'Infinite Scrolling',
						'loadmore' => 'Load More',
					),
	        		'default' => 'none',
					'hidden' => array(
						'lazy_load', '=', '1'
					),
	        		'tooltip' => ''
	        	),		
	        	array (
	        		'att_name' => 'items_per_page',
	        		'type' => 'text',
	        		'label' => __( 'Number of Items Per Load', 'oshine-modules' ),
	        		'default' => '9',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'initial_load_style',
	        		'type' => 'select',
	        		'label' => __( 'Image Load Animation', 'oshine-modules' ),
					'options' => array (
						'init-slide-left' => 'Slide Left',
						'init-slide-right' => 'Slide Right',
						'init-slide-top' => 'Slide Top',
						'init-slide-bottom' => 'Slide Bottom',
						'init-scale' => 'Scale',
						'fadeIn' => 'Fade In',
						'none' => 'None',
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'item_parallax',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Parallax Effect to Portfolio Items', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
					'att_name' => 'prebuilt_hover',
					'type' 	   => 'switch',
					'label'    => __( 'Use Prebuilt Hover Styles', 'oshine-modules' ),
					'default'  => 0,
					'tooltip'  => '',
				),
				array (
					'att_name'	=> 'prebuilt_hover_style',
					'type'		=> 'select',
					'label'		=> __('Prebuilt Hover Styles', 'oshine-modules'),
					'options'	=> array (
						'style1'	=> 'Style 1',
						'style2'	=> 'Style 2',
						'style3'	=> 'Style 3',
						'style4'	=> 'Style 4'
					),
					'default'	=> 'style1',
					'tooltip'	=> 'none',
					'visible'	=> array(
						'prebuilt_hover',
						'==',
						'1'
					)				 
				),
	        	array (
	        		'att_name' => 'hover_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Style', 'oshine-modules' ),
					'options' => array (
						'style1-hover' => 'Style1 - Fade Toggle',
						'style2-hover' => 'Style2 - 3D FLIP Horizontal',
						'style3-hover' => 'Style3 - Direction Aware',
						'style4-hover' => 'Style4 - Direction Aware Inverse',
						'style5-hover' => 'Style5 - FadeIn & Scale',
						'style6-hover' => 'Style6 - Fall',
						'style7-hover' => 'Style7 - 3D FLIP Vertical',
						'style8-hover' => 'Style8 - 3D Rotate',
					),
	        		'default' => 'style1-hover',
	        		'tooltip' => '',
					'visible' => array(
						'prebuilt_hover',
						'==',
						'0'
					)
	        	),
	        	array (
	        		'att_name' => 'title_style',
	        		'type' => 'select',
	        		'label' => __( 'Title Style', 'oshine-modules' ),
					'options' => array (
						'style1' => 'Boxed Title and Meta - Middle',
						'style2' => 'Title and Meta - Top',
						'style3' => 'Title and Meta - Middle',
						'style4' => 'Title and Meta - Bottom',
						'style5' => 'Title and Meta - Below Thumbnail',
						'style6' => 'Title and Meta - Below Thumbnail with no Margin',
						'style7' => 'Title and Meta - Slide Up from Bottom',
					),
					'default'=> 'style1',
	        		'tooltip' => '',
					'visible' => array(
						'prebuilt_hover',
						'==',
						'0'
					)					
	        	),
				array (
					'att_name' => 'title_animation_type',
					'type' => 'select',	
					'label' => __('Portfolio Title Animation','oshine-modules'),
					'options' => tatsu_css_animations(),
					'default' => 'none',
					'visible' => array(
						'prebuilt_hover',
						'==',
						'0'
					)				
				),
				array (
					'att_name' => 'cat_animation_type',
					'type' => 'select',	
					'label' => __('Portfolio Categories Animation','oshine-modules'),
					'options' => tatsu_css_animations(),
					'default' => 'none',	
					'visible' => array(
						'prebuilt_hover',
						'==',
						'0'
					)					
				),
	        	array (
	        		'att_name' => 'image_effect',
	        		'type' => 'select',
	        		'label' => __( 'Image Effects', 'oshine-modules' ),
					'options' => array (
						'zoom-in' => 'Zoom In',
						'zoom-out' => 'Zoom Out',
						'zoom-in-rotate' => 'Zoom In Rotate',
						'zoom-out-rotate' => 'Zoom Out Rotate',
						'none' => 'None'
					),
	        		'default' => 'none',
	        		'tooltip' => '',
					'visible' => array(
						'prebuilt_hover',
						'==',
						'0'
					)	
	        	),				
	        	array (
	        		'att_name' => 'title_alignment_static',
	        		'type' => 'button_group',
	        		'label' => __( 'Title alignment - for Title Below Thumbnail styles', 'oshine-modules' ),
	        		'options' => array (
	        			'left' => 'Left',
	        			'center' => 'Center',	        			
	        			'right' => 'Right',
	        		),
	        		'default' => 'left',
	        		'tooltip' => '',
					'visible' => array(
						'prebuilt_hover',
						'==',
						'0'
					)
	        	),	        		        	
				array (
		            'att_name' => 'overlay_color',
		            'type' => 'color',
		            'label' => __( 'Thumbnail Overlay Color / Gradient Start Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'show_overlay',
	              	'type' => 'switch',
	              	'label' => __( 'Force Show Overlay and Title ?', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	            	            
	            array (
	              	'att_name' => 'gradient',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Gradient Overlay', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	            
				array (
					'att_name' => 'gradient_color',
					'type' => 'color',
		            'label' => __( 'Thumbnail Overlay Gradient End Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'gradient_direction',
	        		'type' => 'button_group',
	        		'label' => __( 'Gradient Direction', 'oshine-modules' ),
					'options' => array (
						'right' => 'Horizontal',
						'bottom' => 'Vertical', 
					),
	        		'default' => 'right',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'title_color',
	              	'type' => 'color',
	              	'label' => __( 'Title Color', 'oshine-modules' ),
	              	'default' => '',
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'cat_color',
	              	'type' => 'color',
	              	'label' => __( 'Categories Color', 'oshine-modules' ),
	              	'default' => '',
	              	'tooltip' => '',
	            ),	
	            array (
	              	'att_name' => 'cat_hide',
	              	'type' => 'switch',
	              	'label' => __( 'Hide Categories ?', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	                    	
	            array (
	              	'att_name' => 'like_button',
	              	'type' => 'switch',
	              	'label' => __( 'Disable Like Button', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Default Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	)										        		                    		            	        		            	            	        		        		        	            	        		            	        		            	        		        		        		        		        		        	
	        ),			
	    );
	tatsu_register_module( 'portfolio', $controls );
}

add_action( 'tatsu_register_modules', 'oshine_register_gallery');
function oshine_register_gallery() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#gallery',
	        'title' => __( 'Gallery', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	        	array (
	        		'att_name' => 'image_source',
	        		'type' => 'select',
	        		'label' => __( 'Image Source', 'oshine-modules' ),
					'options' => array (
						'selected' => 'Selected Images',
						'instagram' => 'Instagram',
						//'pintrest' => 'Pintrest',
						//'dribble' => 'Dribble',
						'flickr' => 'Flickr', 
					),
					'default'=> 'selected',
	        		'tooltip' => ''
	        	),
				array (
	              	'att_name' => 'ids',
	              	'type' => 'multi_image_picker',
	              	'label' => __( 'Upload / Select Gallery Images', 'oshine-modules' ),
	              	'tooltip' => '',
	              	'visible' => array( 'image_source', '=', 'selected' ),
	            ),
	        	array (
	        		'att_name' => 'account_name',
	        		'type' => 'text',
	        		'label' => __( 'Account Name', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'hidden' => array( 'image_source', '=', 'selected' ),
	        	),
	        	array (
	        		'att_name' => 'count',
	        		'type' => 'slider',
	        		'label' => __( 'Images Count', 'oshine-modules' ),
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
	        		'label' => __( 'Number of Columns', 'oshine-modules' ),
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
	        		'att_name' => 'lightbox_type',
	        		'type' => 'select',
	        		'label' => __( 'Lightbox Style', 'oshine-modules' ),
					'options' => array(
						'photoswipe' => 'Photo Swipe',
						'magnific' => 'Magnific Popup (Supports Video)',
					),
	        		'default' => 'photoswipe',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'lazy_load',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Lazy Load', 'oshine_modules' ),
	        		'default' => 0,
	        		'tooltip' => 'Lazy Load'
	        	),
	        	array (
	        		'att_name' => 'delay_load',
	        		'type' => 'switch',
	        		'label' => __( 'Reveal items only on scroll', 'oshine_modules' ),
	        		'default' => 0,
	        		'tooltip' => 'Delay Load Grid'
	        	),
				array (
					'att_name' => 'placeholder_color',
					'type' => 'color',
					'label' => __( 'Grid Placeholder Color', 'oshine_modules' ),
					'default' => '',
					'tooltip' => ''
				),
	        	array (
	        		'att_name' => 'gallery_paginate',
	        		'type' => 'select',
	        		'label' => __( 'Gallery Pagination Style', 'oshine-modules' ),
					'options' => array (
						'none'	=> 'None',
						'infinite' => 'Infinite Scrolling',
						'loadmore' => 'Load More',
					),
	        		'default' => 'none',
	        		'tooltip' => '',
	        		'visible' => array( 'image_source', '=', 'selected' ),
	        	),	
	        	array (
	        		'att_name' => 'items_per_load',
	        		'type' => 'text',
	        		'label' => __( 'Items Per Load', 'oshine-modules' ),
	        		'default' => '9',
	        		'tooltip' => '',
	        		'hidden' => array( 'gallery_paginate', '=', 'none' ),
	        	),
	        	array (
	        		'att_name' => 'gutter_style',
	        		'type' => 'select',
	        		'label' => __( 'Gutter Style', 'oshine-modules' ),
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
	        		'label' => __('Gutter Width','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '40',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'masonry',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Masonry Layout', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
				),
				array (
					'att_name' => 'maintain_order',
					'type' => 'switch',
					'label' => __( 'Maintain Order', 'oshine-modules' ),
					'default' => 0,
					'tooltip' => '',
				),
	        	array (
	        		'att_name' => 'initial_load_style',
	        		'type' => 'select',
	        		'label' => __( 'Image Load Animation', 'oshine-modules' ),
					'options' => array (
						'init-slide-left' => 'Slide Left',
						'init-slide-right' => 'Slide Right',
						'init-slide-top' => 'Slide Top',
						'init-slide-bottom' => 'Slide Bottom',
						'init-scale' => 'Scale',
						'fadeIn' => 'Fade In',
						'none' => 'None',
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'item_parallax',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Parallax Effect to Portfolio Items', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'hover_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Style', 'oshine-modules' ),
					'options' => array (
						'style1-hover' => 'Style1 - Fade Toggle',
						'style2-hover' => 'Style2 - 3D FLIP Horizontal',
						'style3-hover' => 'Style3 - Direction Aware',
						'style4-hover' => 'Style4 - Direction Aware Inverse',
						'style5-hover' => 'Style5 - FadeIn & Scale',
						'style6-hover' => 'Style6 - Fall',
						'style7-hover' => 'Style7 - 3D FLIP Vertical',
						'style8-hover' => 'Style8 - 3D Rotate',
					),
	        		'default' => 'style1-hover',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_content_option',
	        		'type' => 'button_group',
	        		'label' => __( 'On Image Hover', 'oshine-modules' ),
					'options'=> array(
						'none' => 'None', 
						'icon' => 'Show Icon', 
						'title' => 'Show Title', 
					),
	        		'default' => 'icon',
	        		'tooltip' => ''
	        	),	        	
				array (
		            'att_name' => 'hover_content_color',
		            'type' => 'color',
		            'label' => __( 'Hover Content Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Default Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'image_effect',
	        		'type' => 'select',
	        		'label' => __( 'Image Effects', 'oshine-modules' ),
					'options' => array (
						'zoom-in' => 'Zoom In',
						'zoom-out' => 'Zoom Out',
						'zoom-in-rotate' => 'Zoom In Rotate',
						'zoom-out-rotate' => 'Zoom Out Rotate',
						'none' => 'None'
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
				array (
		            'att_name' => 'overlay_color',
		            'type' => 'color',
		            'label' => __( 'Thumbnail Overlay Color / Gradient Start Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'gradient',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Gradient Overlay', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	            
				array (
					'att_name' => 'gradient_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Thumbnail Overlay Gradient End Color', 'oshine-modules' ),
					'default' => '',
					'visible' => array('gradient', '=', '1'),
		            'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'gradient_direction',
	        		'type' => 'button_group',
	        		'label' => __( 'Gradient Direction', 'oshine-modules' ),
					'options' => array (
						'right' => 'Horizontal',
						'bottom' => 'Vertical', 
					),
	        		'default' => 'right',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'like_button',
	              	'type' => 'switch',
	              	'label' => __( 'Disable Like Button', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),

	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'overlay_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'hover_content_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'initial_load_style' => 'scale',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'oshine_gallery', $controls );
	tatsu_register_module( 'gallery', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_justified_gallery');
function oshine_register_justified_gallery() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#justified_gallery',
	        'title' => __( 'Justified Gallery', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
				array (
	              	'att_name' => 'images',
	              	'type' => 'multi_image_picker',
	              	'label' => __( 'Upload / Select Gallery Images', 'oshine-modules' ),
	              	'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'gallery_paginate',
	        		'type' => 'switch',
	        		'label' => __( 'Enable Infinite Scroll', 'oshine-modules' ),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),	            	        	
	        	array (
	        		'att_name' => 'items_per_load',
	        		'type' => 'text',
	        		'label' => __( 'Items Per Load', 'oshine-modules' ),
	        		'default' => '9',
	        		'tooltip' => '',
	        		'hidden' => array( 'gallery_paginate', '=', '0' ),
	        	),

	        	array (
	        		'att_name' => 'gutter_width',
	        		'type' => 'number',
	        		'label' => __('Gutter Width','oshine-modules'),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '40',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'image_height',
	        		'type' => 'number',
	        		'label' => __( 'Image Height', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),	        		
	        		'default' => '200',
	        		'tooltip' => ''
	        	),	        	
	        	array (
	        		'att_name' => 'initial_load_style',
	        		'type' => 'select',
	        		'label' => __( 'Image Load Animation', 'oshine-modules' ),
					'options' => array (
						'init-slide-left' => 'Slide Left',
						'init-slide-right' => 'Slide Right',
						'init-slide-top' => 'Slide Top',
						'init-slide-bottom' => 'Slide Bottom',
						'init-scale' => 'Scale',
						'none' => 'None',
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Style', 'oshine-modules' ),
					'options' => array (
						'style1-hover' => 'Style1 - Fade Toggle',
						'style2-hover' => 'Style2 - 3D FLIP Horizontal',
						'style3-hover' => 'Style3 - Direction Aware',
						'style4-hover' => 'Style4 - Direction Aware Inverse',
						'style5-hover' => 'Style5 - FadeIn & Scale',
						'style6-hover' => 'Style6 - Fall',
						'style7-hover' => 'Style7 - 3D FLIP Vertical',
						'style8-hover' => 'Style8 - 3D Rotate',
					),
	        		'default' => 'style1-hover',
	        		'tooltip' => ''
	        	),	        	
	        	array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Default Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'image_effect',
	        		'type' => 'select',
	        		'label' => __( 'Image Effects', 'oshine-modules' ),
					'options' => array (
						'zoom-in' => 'Zoom In',
						'zoom-out' => 'Zoom Out',
						'zoom-in-rotate' => 'Zoom In Rotate',
						'zoom-out-rotate' => 'Zoom Out Rotate',
						'none' => 'None'
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'disable_overlay',
	              	'type' => 'switch',
	              	'label' => __( 'Disable Overlay', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	        	
				array (
		            'att_name' => 'overlay_color',
		            'type' => 'color',
		            'label' => __( 'Thumbnail Overlay Color / Gradient Start Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'visible' => array( 'disable_overlay', '!=', '1' ),
	            ),
	            array (
	              	'att_name' => 'gradient',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Gradient Overlay', 'oshine-modules' ),
	              	'default' => 0,
					'tooltip' => '',
					'visible' => array( 'disable_overlay', '!=', '1' ),
	            ),	            
				array (
					'att_name' => 'gradient_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Thumbnail Overlay Gradient End Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'visible' => array( 'disable_overlay', '!=', '1' ),
	            ),
	        	array (
	        		'att_name' => 'gradient_direction',
	        		'type' => 'button_group',
	        		'label' => __( 'Gradient Direction', 'oshine-modules' ),
					'options' => array (
						'right' => 'Horizontal',
						'bottom' => 'Vertical', 
					),
	        		'default' => 'right',
					'tooltip' => '',
					'visible' => array( 'disable_overlay', '!=', '1' ),
	        	),
	            array (
	              	'att_name' => 'like_button',
	              	'type' => 'switch',
	              	'label' => __( 'Disable Like Button', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	                    		                    		            	        		            	            	        		        		        	            	        		            	        		            	        		        		        		        		        		        	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'gutter_width' => '20',
	        			'overlay_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'justified_gallery', $controls );
}

add_action( 'tatsu_register_modules', 'oshine_register_portfolio_carousel');
function oshine_register_portfolio_carousel() {

		$portfolio_categories = get_terms('portfolio_categories');
		$options = array();
		foreach ( $portfolio_categories as $category ) {
			if( is_object( $category ) ) {
				$options[$category->slug] = $category->name;
			}
		}

		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#portfolio',
	        'title' => __( 'Portfolio Carousel', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (	        	
	        	array (
	        		'att_name' => 'category',
	        		'type' => 'grouped_checkbox',
	        		'label' => __( 'Portfolio Categories', 'oshine-modules' ),
	        		'options' => $options,
	        	),	        	
	        	array (
	        		'att_name' => 'items_per_page',
	        		'type' => 'number',
	        		'label' => __( 'Number of Items Per Page', 'oshine-modules' ),
	        		'default' => '8',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Style', 'oshine-modules' ),
					'options' => array (
						'style1-hover' => 'Style1 - Fade Toggle',
						'style2-hover' => 'Style2 - 3D FLIP Horizontal',
						'style3-hover' => 'Style3 - Direction Aware',
						'style4-hover' => 'Style4 - Direction Aware Inverse',
						'style5-hover' => 'Style5 - FadeIn & Scale',
						'style6-hover' => 'Style6 - Fall',
						'style7-hover' => 'Style7 - 3D FLIP Vertical',
						'style8-hover' => 'Style8 - 3D Rotate',
					),
	        		'default' => 'style1-hover',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_style',
	        		'type' => 'select',
	        		'label' => __( 'Title Style', 'oshine-modules' ),
					'options' => array (
						'style1' => 'Boxed Title and Meta - Middle',
						'style2' => 'Title and Meta - Top',
						'style3' => 'Title and Meta - Middle',
						'style4' => 'Title and Meta - Bottom',
						'style5' => 'Title and Meta - Below Thumbnail',
						'style6' => 'Title and Meta - Below Thumbnail with no Margin',
						'style7' => 'Title and Meta - Slide Up from Bottom',
					),
					'default'=> 'style1',
	        		'tooltip' => ''
	        	),	        		        	
	        	array (
	        		'att_name' => 'default_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Default Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'hover_image_style',
	        		'type' => 'select',
	        		'label' => __( 'Hover Image Style', 'oshine-modules' ),
	        		'options' => array (
						'black_white' => 'Black And White',
						'color' => 'Color'
					),
	        		'default' => 'color',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'image_effect',
	        		'type' => 'select',
	        		'label' => __( 'Image Effects', 'oshine-modules' ),
					'options' => array (
						'zoom-in' => 'Zoom In',
						'zoom-out' => 'Zoom Out',
						'zoom-in-rotate' => 'Zoom In Rotate',
						'zoom-out-rotate' => 'Zoom Out Rotate',
						'none' => 'None'
					),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
				array (
		            'att_name' => 'overlay_color',
					'type' => 'color',
					'options' => array(
						'gradient' => false,
					),
		            'label' => __( 'Thumbnail Overlay Color / Gradient Start Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
	            ),	            
	            array (
	              	'att_name' => 'gradient',
	              	'type' => 'switch',
	              	'label' => __( 'Enable Gradient Overlay', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	            
				array (
					'att_name' => 'gradient_color',
		            'type' => 'color',
		            'label' => __( 'Thumbnail Overlay Gradient End Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'gradient_direction',
	        		'type' => 'button_group',
	        		'label' => __( 'Gradient Direction', 'oshine-modules' ),
					'options' => array (
						'right' => 'Horizontal',
						'bottom' => 'Vertical', 
					),
	        		'default' => 'right',
	        		'tooltip' => ''
	        	),
	            array (
	              	'att_name' => 'title_color',
	              	'type' => 'color',
	              	'label' => __( 'Title Color', 'oshine-modules' ),
	              	'default' => '',
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'cat_color',
	              	'type' => 'color',
	              	'label' => __( 'Categories Color', 'oshine-modules' ),
	              	'default' => '',
	              	'tooltip' => '',
	            ),	
	            array (
	              	'att_name' => 'cat_hide',
	              	'type' => 'switch',
	              	'label' => __( 'Hide Categories ?', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),	                    	
	            array (
	              	'att_name' => 'like_button',
	              	'type' => 'switch',
	              	'label' => __( 'Disable Like Button', 'oshine-modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
				array (
					'att_name' => 'title_animation_type',
					'type' => 'select',	
					'label' => __('Portfolio Title Animation','oshine-modules'),
					'options' => tatsu_css_animations(),
					'default' => 'none',	
				),
				array (
					'att_name' => 'cat_animation_type',
					'type' => 'select',	
					'label' => __('Portfolio Categories Animation','oshine-modules'),
					'options' => tatsu_css_animations(),
					'default' => 'none',	
				),						        		                    		            	        		            	            	        		        		        	            	        		            	        		            	        		        		        		        		        		        	
	        ),			
	    );
	tatsu_register_module( 'portfolio_carousel', $controls );
}

add_action( 'tatsu_register_modules', 'oshine_register_portfolio_navigation_module' );
function oshine_register_portfolio_navigation_module() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#portfolio_navigation',
	        'title' => __( 'Portfolio Navigation', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'oshine-modules' ),
					'options'=> array(
						'style1' => 'Style 1', 
						'style2' => 'Style 2'
					),
					'default'=> 'style1',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_align',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),	        		        	
	            array (
					'att_name' => 'nav_links_color',
					'type' => 'color',
					'label' => __( 'Next and Previous Page Navigation Color', 'oshine-modules' ),
					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .home-grid-icon span' => array(
							'property' => 'background',
						),
						'.tatsu-{UUID} h6' => array(
							'property' => 'color',
							'when' => array('style', '!=', 'style1'),
						),
						'.tatsu-{UUID}.portfolio-nav-wrap' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine-modules' ),
	              	'default' => 0,
					'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine-modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	            ),

	        ),
	    );
	tatsu_register_module( 'portfolio_navigation_module', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_project_details');
function oshine_register_project_details() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#portfolio_details',
	        'title' => __( 'Portfolio Details', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'oshine-modules' ),
					'options'=> array(
						'style1' => 'Style 1', 
						'style2' => 'Style 2',
						'style3' => 'Style 3'	 
					),
					'default'=> 'style1',
	        		'tooltip' => ''
	        	),	        	
	        	array (
	        		'att_name' => 'title_align',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'left',
	        		'tooltip' => '',
					'hidden'  => array ( 'style', '==', 'style3' )
	        	)
	        ),
	    );
	tatsu_register_module( 'project_details', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_chart');
function oshine_register_chart() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#chart',
	        'title' => __('Animated Charts','oshine-modules'),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	        	array (
	        		'att_name' => 'percentage',
	        		'type' => 'slider',
	        		'label' => __( 'Percentage', 'oshine-modules' ),
	        		'default' => '70',
	        		'tooltip' => ''
	        	),
 	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'percentage_font_size',
	        		'type' => 'slider',
	        		'label' => __( 'Percentage / Icon - Font Size', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '200',
	        			'step' => '1',
	        			'unit' => 'px',
	        			'add_unit_to_value' => false,
	        		),
	        		'default' => '14',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .be-chart-percent' => array(
							'property' => 'font-size',
							'when' => array(
								array('percentage', 'notempty'),
								array('icon', 'notempty')
							),
							'relation' => 'or',
							'append' => 'px',
						),
					),
	        	),
				array (
		            'att_name' => 'percentage_color',
					'type' => 'color',
					'options' => array (
							'gradient' => true
					),
		            'label' => __( 'Percentage / Icon - Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .be-chart-percent' => array(
							'property' => 'color',
							'when' => array(
								array('percentage', 'notempty'),
								array('icon', 'notempty')
							),
							'relation' => 'or',
						),
					),
	            ),
	        	array (
	        		'att_name' => 'caption',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),	
	        	array (
	        		'att_name' => 'caption_size',
	        		'type' => 'slider',
	        		'label' => __( 'Caption Font Size', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '200',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),	        		
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .be-chart-caption' => array(
							'property' => 'font-size',
							'when' => array('caption', 'notempty'),
							'append' => 'px',
						),
					),
	        	),	
				array (
		            'att_name' => 'caption_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Caption Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .be-chart-caption' => array(
							'property' => 'color',
							'when' => array('caption', 'notempty'),
						),
					),
	            ),
				array (
		            'att_name' => 'percentage_bar_color',
					'type' => 'color',
		            'label' => __( 'Percentage Bar Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
				array (
		            'att_name' => 'percentage_track_color',
					'type' => 'color',
		            'label' => __( 'Percentage Track Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
				array (
		            'att_name' => 'percentage_scale_color',
					'type' => 'color',
		            'label' => __( 'Percentage Scale Color', 'oshine-modules' ),
		            'default' => '',
		            'tooltip' => '',
	            ),	
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'number',
	        		'label' => __( 'Chart Size ( Height & Width )', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '100',
					'tooltip' => '',

	        	),
	        	array (
	        		'att_name' => 'linewidth',
	        		'type' => 'slider',
	        		'label' => __( 'Bar Width', 'oshine-modules' ),
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '50',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),
	        		'default' => '5',
	        		'tooltip' => ''
	        	),	        		                        	            	            	        		        	        		        	
	        ),
	    );
	tatsu_register_module( 'chart', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_animate_icons_style2');
function oshine_register_animate_icons_style2() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#animated_module',
	        'title' => __( 'Variable Height Animated Module', 'oshine-modules' ),
	        'is_js_dependant' => true,
	        'child_module' => 'animate_icon_style2',
	        'type' => 'multi',
	        'initial_children' => 3,
	        'is_built_in' => true,
	        'atts' => array(),
	    );
	tatsu_register_module( 'animate_icons_style2', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_animate_icon_style2');
function oshine_register_animate_icon_style2() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Animated Module Element', 'oshine-modules' ),
	        'is_js_dependant' => false,
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
				array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.animate-icon-module-style2' => array(
							'property' => 'background'
						),
					),
	            ),
				array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color - Hover State', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.animate-icon-module-style2:hover' => array(
							'property' => 'background'
						),
					),
	            ),
 	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'oshine-modules' ),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'slider',        		
	        		'label' => __( 'Icon Size', 'oshine-modules' ),
					'options' => array(
						'min' => '0',
						'max' => '200',
						'step' => '1',
						'unit' => 'px',
					),		        		
	        		'default' => '100',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-icon' => array(
							'property' => 'font-size',
							'append' => 'px',
						),
					),
	        	),
				array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Icon Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-icon' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
		            'att_name' => 'icon_color_hover_state',
		            'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Icon Color on Mouse over', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.animate-icon-module-style2:hover .animate-icon-icon' => array(
							'property' => 'color',
						),
					),
	            ),
	        	array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'button_group',
	        		'label' => __( 'Heading tag to use for Title', 'oshine-modules' ),
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
		            'label' => __( 'Title Color', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .animate-icon-title' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
		            'att_name' => 'title_color_hover_state',
		            'type' => 'color',
		            'label' => __( 'Title Color - Hover State', 'oshine-modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.animate-icon-module-style2:hover .animate-icon-title' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content on Mouse Over', 'oshine-modules' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	            	            	    	        		            	            	        		        		            	            
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'bg_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'hover_bg_color' => '#232323',
	        			'icon' => 'icon-icon_desktop',
	        			'size' => '40',
	        			'title' => 'Title Goes Here',
	        			'h_tag' => 'h6',
	        			'icon_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'title_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
	        			'icon_color_hover_state' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'title_color_hover_state' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
	        			'content' => '<span style="color:#fff;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</span>'


	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'animate_icon_style2', $controls );
}

add_action( 'tatsu_register_modules', 'oshine_register_special_heading' );
function oshine_register_special_heading() {
	$controls = array (
        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading',
        'title' => __( 'Special Title - Style 1',  'oshine_modules'  ),
        'is_js_dependant' => false,
        'type' => 'single',
        'is_built_in' => true,
        'atts' => array (
        	array (
        		'att_name' => 'title_content',
        		'type' => 'text',
        		'label' => __( 'Title', 'oshine_modules' ),
        		'default' => '',
        		'tooltip' => '',
        		
        	),
        	array (
	            'att_name' => 'title_color',
	            'type' => 'color',
	            'label' => __( 'Title Color', 'oshine_modules' ),
	            'default' => '',
				'tooltip' => '',
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .special-h-tag' => array(
						'property' => 'color',
					),
				),
        		
            ), 
        	array (
        		'att_name' => 'h_tag',
        		'type' => 'button_group',
        		'label' => __( 'Heading tag to use for Title',  'oshine_modules'  ),
        		'options' => array (
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6'
				),
        		'default' => 'h5',
        		'tooltip' => '',
        		
        	),                   	        	
            array (
        		'att_name' => 'content',
        		'type' => 'tinymce',
        		'label' => __( 'Description', 'oshine_modules' ),
        		'default' => '',
        		'tooltip' => '',
        		
	        	),	
	        array (
              	'att_name' => 'subtitle_spl_font',
              	'type' => 'switch',
              	'label' => __( 'Apply "Special-Subtitle" font to Description', 'oshine_modules' ),
              	'default' => 0, 
              	'tooltip' => '',		
            ),
            array (
              	'att_name' => 'disable_separator',
              	'type' => 'switch',
				'label' => __( 'Disable Divider', 'oshine_modules' ),
				'default' => '0',
              	'tooltip' => '',        		
            ),
            array (
        		'att_name' => 'separator_style',
        		'type' => 'switch',
        		'label' => __( 'Enable icon in divider ?', 'oshine_modules' ),
        		'default' => '1',
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),  
        		
        	),
        	array (
        		'att_name' => 'icon_name',
        		'type' => 'icon_picker',
        		'label' => __( 'Icon in Separator', 'oshine_modules' ),
        		'default' => '',
				  'tooltip' => '',
				  'hidden' => array('disable_separator', '=', '1'),
        		
        	),
            array (
	            'att_name' => 'icon_color',
	            'type' => 'color',
	            'label' => __( 'Icon Color', 'oshine_modules' ),
	            'default' => '', 
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .sep-icon.oshine_diamond' => array(
						'property' => 'background',
						'when' => array(
							array('icon_name', '=', 'oshine_diamond'),
							array('disable_separator', 'empty'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'or',
					),
					'.tatsu-{UUID} .sep-icon' => array(
						'property' => 'color',
						'when' => array(
							array('icon_name', '!=', 'oshine_diamond'),
							array('disable_separator', '!=', '1'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'and',
					),
				),
        		
            ),
            array (
	            'att_name' => 'separator_color',
	            'type' => 'color',
	            'label' => __( 'Divider Color', 'oshine_modules' ),
	            'default' => '', 
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .sep-with-icon' => array(
						'property' => 'background',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'and',
					),
					'.tatsu-{UUID} .separator' => array(
						'property' => 'background',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '!=', '1'),
						),
						'relation' => 'and',
					),
				),
        		
            ),
            array (
        		'att_name' => 'separator_thickness',
        		'type' => 'slider',
        		'label' => __( 'Separator Thickness', 'oshine_modules' ),
        		'options' => array(
        			'min' => '1',
        			'max' => '20',
        			'step' => '1',
        			'unit' => 'px',
        		),
        		'default' => '2',
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .sep-with-icon' => array(
						'property' => 'height',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'and',
						'append' => 'px',
					),
					'.tatsu-{UUID} .separator' => array(
						'property' => 'height',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '!=', '1'),
						),
						'relation' => 'and',
						'append' => 'px',
					),
				),
        		
        	),
        	array (
        		'att_name' => 'separator_width',
        		'type' => 'number',
        		'label' => __( 'Separator Width', 'oshine_modules' ),
        		'options' => array(
        			'unit' => 'px',
        		),
        		'default' => '40',
				'tooltip' => '',
				'hidden' => array('disable_separator', '=', '1'),
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID} .sep-with-icon' => array(
						'property' => 'width',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '=', '1'),
						),
						'relation' => 'and',
						'append' => 'px',
						//'operation' => array('/', 2),
					),
					'.tatsu-{UUID} .separator' => array(
						'property' => 'width',
						'when' => array(
							array('disable_separator', '!=', '1'),
							array('separator_style', '!=', '1'),
						),
						'relation' => 'and',
						'append' => 'px',
					),
				),
        		
        	),
        	array (
              	'att_name' => 'separator_pos',
              	'type' => 'switch',
              	'label' => __( 'Place Divider above Sub Title', 'oshine_modules' ),
              	'default' => 0,
				  'tooltip' => '',
				  'hidden' => array('disable_separator', '=', '1'),
        		
            ),
            array (
        		'att_name' => 'title_align',
        		'type' => 'button_group',
        		'label' => __( 'Alignment', 'oshine_modules' ),
        		'options' => array(
        			'left' => 'Left',
        			'center' => 'Center',
        			'right' => 'Right'
        		),
        		'default' => 'center',
        		'tooltip' => '',
        		
        	),            
            array (
              	'att_name' => 'animate',
              	'type' => 'switch',
              	'label' => __( 'Enable CSS Animation', 'oshine_modules' ),
              	'default' => 0,
              	'tooltip' => '',
        		
            ),
            array (
        		'att_name' => 'animation_type',
        		'type' => 'select',
        		'label' => __( 'Animation Type', 'oshine_modules' ),
        		'options' => tatsu_css_animations(),
        		'default' => 'fadeIn',
              	'tooltip' => '',
        		
        	),
        ),
        'presets' => array(
        	'default' => array(
        		'title' => '',
        		'image' => '',
        		'preset' => array(
        			'title_content' => 'TATSU IS AWESOME',
        			'h_tag' => 'h3',
        			'content' => 'A Powerful and Elegant Front End Page Builder for Wordpress',
        			'subtitle_spl_font' => '1',
        			'icon_name' => 'oshine_diamond',
        			'icon_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
        			'separator_thickness' => '1',
        			'separator_color' => '#efefef'
        		),
        	)
        ),
    );
	tatsu_register_module( 'special_heading', $controls );
}


add_action( 'tatsu_register_modules', 'oshine_register_special_heading2');
function oshine_register_special_heading2() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading2',
	        'title' => __( 'Special Title - Style 2', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'title_content',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'select',
	        		'label' => __( 'Heading tag to use for Title', 'oshine_modules' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h5',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'title_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Title Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-h-tag' => array(
							'property' => 'color',
						),
					),
        			
	            ),
	        	array (
		            'att_name' => 'border_color',
					'type' => 'color',
					'options' => array(
						'gradient' => true,
					),
		            'label' => __( 'Border Color', 'oshine_modules' ),
		            'default' => '', //color_scheme
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-heading' => array(
							'property' => 'border-color',
							'when' => array( 'border_thickness', '!=', '0' ),
						),
					),
        			
	            ),
	            array (
	        		'att_name' => 'border_thickness',
	        		'type' => 'number',
	        		'label' => __( 'Border Thickness', 'oshine_modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '2',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-heading' => array(
							'property' => 'border-width',
							'append' => 'px'
						),
					),
        			
	        	),
	        	array (
	        		'att_name' => 'padding',
	        		'type' => 'input_group',
	        		'label' => __( 'Padding', 'oshine_modules' ),
	        		'default' => '20px 30px 20px 30px',
					'tooltip' => '',
					'css' => true,
					'responsive' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-heading' => array(
							'property' => 'padding',
						),
					),
        			
	        	),
	        	array (
	        		'att_name' => 'title_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Title Alignment', 'oshine_modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => '',
        			
	        	),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine_modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
        			
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine_modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'TATSU IS AWESOME',
	        			'h_tag' => 'h3',
	        			'separator_thickness' => '1',
	        			'border_thickness' => '5',
	        			'border_color' => '#232323',
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_heading2', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_special_heading3' );
function oshine_register_special_heading3() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading3',
	        'title' => __( 'Special Title - Style 3', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'title_content',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'button_group',
	        		'label' => __( 'Heading tag to use for Title', 'oshine_modules' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h3',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-h-tag' => array(
							'property' => 'color',
						),
					),
        			
	            ),
	            array (
	        		'att_name' => 'sub_title1',
	        		'type' => 'text',
	        		'label' => __( 'Top Caption', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	            array (
	        		'att_name' => 'sub_title2',
	        		'type' => 'text',
	        		'label' => __( 'Bottom Caption', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'top_caption_color',
		            'type' => 'color',
		            'label' => __( 'Top Caption Color', 'oshine_modules' ),
		            'default' => '',
		            'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .top-caption h6' =>array(
							'property' => 'color'
						)
					),
	            ),
	        	array (
		            'att_name' => 'bottom_caption_color',
		            'type' => 'color',
		            'label' => __( 'Bottom Caption Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .bottom-caption h6' =>array(
							'property' => 'color'
						)
					),
        			
	            ),
	            array (
	        		'att_name' => 'top_caption_size',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),	        		
	        		'label' => __( 'Top Caption Font Size', 'oshine_modules' ),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .top-caption h6' =>array(
							'property' => 'font-size',
							'append' => 'px'
						)
					),
        			
	        	),
	            array (
	        		'att_name' => 'bottom_caption_size',
	        		'type' => 'slider',
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),		        		
	        		'label' => __( 'Bottom Caption Font Size', 'oshine_modules' ),
	        		'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .bottom-caption h6' =>array(
							'property' => 'font-size',
							'append' => 'px'
						)
					),
        			
	        	),
	        	array (
	        		'att_name' => 'top_caption_font',
	        		'type' => 'button_group',
	        		'label' => __( 'Font for Top Caption', 'oshine_modules' ),
	        		'options' => array(
	        			'body'=> 'Body', 
	        			'special' => 'Special Title Font', 
	        			'h6' => 'H6'
	        		),
	        		'default' => 'h6',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'bottom_caption_font',
	        		'type' => 'button_group',
	        		'label' => __( 'Font for Bottom Caption', 'oshine_modules' ),
	        		'options' => array(
	        			'body'=> 'Body', 
	        			'special' => 'Special Title Font', 
	        			'h6' => 'H6'
	        		),
	        		'default' => 'h6',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'top_caption_separator_color',
		            'type' => 'color',
		            'label' => __( 'Top Caption Separator Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style3 .top-caption .caption .caption-inner' =>array(
							'property' => 'background',
						)
					),
        			
	            ),
	        	array (
		            'att_name' => 'bottom_caption_separator_color',
		            'type' => 'color',
		            'label' => __( 'Bottom Caption Separator Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style3 .bottom-caption .caption .caption-inner' =>array(
							'property' => 'background',
						)
					),
        			
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine_modules' ),
	              	'default' => 0,
	              	'tooltip' => '',
        			
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine_modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'TATSU IS AWESOME',
	        			'h_tag' => 'h3',
	        			'sub_title1' => 'POWERFUL & ELEGANT',
	        			'sub_title2' => 'A Live Front End Page Builder for Wordpress',
	        			'top_caption_color' => '#757575',
	        			'bottom_caption_color' => '#757575',
	        			'bottom_caption_font' => 'special',
	        			'top_caption_separator_color' => '#efefef',
	        			'bottom_caption_separator_color' => '#efefef',
	        			'bottom_caption_size' => '18'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_heading3', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_special_heading4' );
function oshine_register_special_heading4() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading4',
	        'title' => __( 'Special Title - Style 4', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'title_content',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'button_group',
	        		'label' => __( 'Heading tag to use for Title', 'oshine_modules' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h5',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-h-tag' => array(
							'property' => 'color',
						),
					),
	            ),
	            array (
	        		'att_name' => 'caption_content',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'caption_font',
	        		'type' => 'select',
	        		'label' => __( 'Font Family to apply for caption', 'oshine_modules' ),
	        		'options' => array (
						'body'=> 'Body', 
						'special' => 'Special Title Font', 
						'h6' => 'H6', 
						'h5' => 'H5', 
						'h4' => 'H4', 
						'h3' => 'H3', 
						'h2' => 'H2', 
						'h1' => 'H1'
					),
	        		'default' => 'h6',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'caption_color',
		            'type' => 'color',
		            'label' => __( 'Caption Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .caption' => array(
							'property' => 'color'
						)
					)	
	            ),
	            array (
	        		'att_name' => 'divider_style',
	        		'type' => 'button_group',
	        		'label' => __( 'Divider Style', 'oshine_modules' ),
	        		'options' => array(
	        			'bottom'=> 'Bottom', 
	        			'both' => ' Top and Bottom', 
	        			'top' => 'Top'
	        		),
	        		'default' => 'both',
	        		'tooltip' => '',	
	        	),
	        	array (
		            'att_name' => 'divider_color',
		            'type' => 'color',
		            'label' => __( 'Divider Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap .vertical-divider' => array(
							'property' => 'background'
						)
					),
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine_modules' ),
	              	'default' => false,
	              	'tooltip' => '',		
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine_modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'TATSU IS AWESOME',
	        			'h_tag' => 'h3',
	        			'caption_content' => 'A Live Front End Page Builder for Wordpress',
	        			'caption_font' => 'special',
	        			'divider_color' => '#efefef',
	        			'divider_style' => 'both'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_heading4', $controls );
}



add_action( 'tatsu_register_modules', 'oshine_register_special_heading5');
function oshine_register_special_heading5() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading5',
	        'title' => __( 'Special Title - Style 5', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'title_content',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'select',
	        		'label' => __( 'Heading tag for Title', 'oshine_modules' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h3',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .special-h-tag' => array(
							'property' => 'color'
						)
					),
	            ),
	        	array (
	        		'att_name' => 'caption_content',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'oshine_modules' ),
	        		'default' => '',
	        		'tooltip' => '',
        			
	        	),
	        	array (
	        		'att_name' => 'caption_font',
	        		'type' => 'select',
	        		'label' => __( 'Font for Caption', 'oshine_modules' ),
	        		'options' => array (
						'body'=> 'Body', 
						'special' => 'Special Title Font', 
						'h6' => 'H6', 
						'h5' => 'H5', 
						'h4' => 'H4', 
						'h3' => 'H3', 
						'h2' => 'H2', 
						'h1' => 'H1'
					),
	        		'default' => 'h6',
	        		'tooltip' => '',
        			
	        	),
	        	array (
		            'att_name' => 'caption_color',
		            'type' => 'color',
		            'label' => __( 'Caption Color', 'oshine_modules' ),
		            'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .caption' => array(
							'property' => 'color'
						),
					),
        			
	            ),
	            array (
	        		'att_name' => 'title_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine_modules' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => '',
        			
	        	),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine_modules' ),
	              	'default' => 0,
	              	'tooltip' => '',     			
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine_modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'title_content' => 'TATSU',
	        			'h_tag' => 'h1',
	        			'title_color' => 'rgba(0,0,0,0.1)',
	        			'caption_content' => 'A Live Front End Page Builder for Wordpress',
	        			'caption_font' => 'special',
	        			'divider_color' => '#efefef',
	        			'divider_style' => 'both'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'special_heading5', $controls );
}
add_action( 'tatsu_register_modules', 'oshine_register_special_heading6' );
if( !function_exists( 'oshine_register_special_heading6' ) ) {
	function oshine_register_special_heading6() {
		
		$controls = array(
			'icon' 				=> OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#special_heading3',
			'title' 			=> __( 'Special Title - Style 6', 'oshine_modules' ),
			'is_js_dependant' 	=> false,
			'type' 				=> 'single',
			'is_built_in' 		=> true,
			'atts' 				=> array(
				array(
					'att_name'		=> 'title_content',
					'type'			=> 'text',
					'label'			=> __( 'Title', 'oshine_modules' ),
					'default'		=> '',
					'tooltip'		=> ''
				),
				array(
					'att_name'		=> 'border_style',
					'type' 			=> 'button_group',
					'label'			=> __('Border Style', 'oshine_modules'),
					'options'		=> array(
						'style1'		=> 'Style 1',
						'style2'		=> 'Style 2'
					),
					'default'		=> 'style1',
					'tooltip'		=> ''		
				),
				array(
					'att_name' 		=> 'font_size',
					'type'			=> 'slider',
					'label'			=> __( 'Font Size', 'oshine_modules' ),
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
						'.tatsu-{UUID}.special-heading-wrap.style6' => array(
							'property' => 'font-size',	
						),
					),
				),
				array(
					'att_name'		=> 'letter_spacing',
					'type'			=> 'slider',
					'label'			=> __('Letter Spacing', 'oshine_modules'),
					'options'		=> array (
						'min'				=> 0,
						'max'				=> 10,
						'unit'				=> 'px',
						'add_unit_to_value'	=> true,
						'step'				=> 1
					),
					'default'		=> 2,
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6 .be-title' =>array(
							'property' => 'letter-spacing',
						),
					),
				),
				array(
					'att_name'		=> 'margin',
					'type'			=> 'input_group',
					'label'			=> __( 'Margin', 'oshine_modules' ),
					'default'		=> '0px 0px 20px 0px',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6' =>array(
							'property' => 'margin'
						),
					),
				),
				array(
					'att_name'		=> 'title_color',
					'type' 			=> 'color',
					'label'			=> __( 'Title Color', 'oshine_modules' ),
					'default'		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6 .be-title' =>array(
							'property' => 'color'
						),
					),

				),
				array(
					'att_name'		=> 'border_color',
					'type'			=> 'color',
					'label'			=> __( 'Border Color', 'oshine_modules' ),
					'default' 		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6 .be-border ' =>array(
							'property' => 'background'
						),
					),
				),
				array(
					'att_name'		=> 'expand_border',
					'type'			=> 'switch',
					'label'			=> __('Expand Border on Hover', 'oshine_modules'),
					'default'		=> 0,
					'tooltip'		=> ''
				),
				array(
					'att_name'		=> 'title_hover_color',
					'type'			=> 'color',
					'label'			=> __( 'Title Hover Color', 'oshine_modules' ),
					'default'		=> '',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.style6 .special-heading-inner-wrap:hover .be-title' =>array(
							'property' => 'color'
						),
					),
				),
				array(
					'att_name'		=> 'alignment',
					'type'			=> 'button_group',
					'label'			=> __( 'Alignment', 'oshine_modules' ),
					'options'		=> array(
						'left'		=> 'Left',
						'center'	=> 'Center',
						'right'		=> 'Right'
					),
					'default'		=> 'left',
					'tooltip'		=> '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.special-heading-wrap.style6' =>array(
							'property' => 'text-align',
						),
					),
				),	
				array(
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'oshine_modules' ),
	              	'default' => false,
	              	'tooltip' => '',		
	            ),
	            array(
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'oshine_modules' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	            )	
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'title_content' => __('HEADING', 'oshine_modules' ),
						'border_style' => 'style2',
						'border_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'expand_border' => '1',
						'letter_spacing' => '2',
						'font_size' => '13',	        			
	        		),
	        	)
	        ),			
		);
		tatsu_register_module( 'be_special_heading6', $controls );
	} 
}

add_action( 'tatsu_register_modules', 'oshine_register_svg_icon');
function oshine_register_svg_icon() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#svg_icon',
	        'title' => __( 'SVG Icon', 'oshine_modules' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => true,
			'should_autop' => false,
	        'atts' => array (
				array (
	        		'att_name' => 'content',
	        		'type' => 'text',
	        		'label' => 'SVG Icon File URL',
	        		'default' => '',
	        		'tooltip' => 'Paste SVG Icon'
	        	),
	            array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'oshine-modules' ),
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
	        		'label' => __( 'Width', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '200',
	        		'tooltip' => '',
					'visible' => array( 'size', '=', 'custom' ),
	        	),
				array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'oshine-modules' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '200',
	        		'tooltip' => '',
					'visible' => array( 'size', '=', 'custom' ),
	        	),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'SVG Color', 'oshine-modules' ),
		            'default' => '', 
		            'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID}.oshine-svg-icon svg, .tatsu-{UUID}.oshine-svg-icon svg path' => array(
							'property' => 'color',
						),
					),
	            ),
				array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'oshine-modules' ),
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
	              	'label' => __( 'Enable SVG Line Animation', 'oshine_modules' ),
	              	'default' => 0,
	              	'tooltip' => '',     			
	            ),
	            array (
	              	'att_name' => 'path_animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Path Animation', 'oshine_modules' ),
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
	              	'label' => __( 'SVG Animation', 'oshine_modules' ),
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
	        		'label' => __( 'Animation Duration', 'oshine-modules' ),
	        		'tooltip' => '',
					'visible' => array( 'line_animate', '=', '1' ),
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
	        		'label' => __( 'Animation Delay', 'oshine-modules' ),
	        		'tooltip' => '',
					'visible' => array( 'line_animate', '=', '1' ),
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'oshine_svg_icon', $controls );
}

add_action( 'tatsu_register_modules', 'oshine_register_animated_link');
function oshine_register_animated_link() {
		$controls = array (
	        'icon' => OSHINE_MODULES_PLUGIN_URL.'/img/modules.svg#svg_icon',
	        'title' => __( 'Animated Link', 'oshine_modules' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
			'should_autop' => false,
			'atts' => array (
				array (
					'att_name' => 'link_text',
					'type' => 'text',
					'label' => __( 'Animated Link Text', 'tatsu' ),
					'default' => 'Link Text',
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
					'att_name' => 'font_size',
					'type' => 'number',
					'label' => __( 'Font Size', 'tatsu' ),
					'options' => array(
	        			'unit' => 'px',
	        		),
					'default' => '13',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} a' => array(
							'property' => 'font-size',
							'append' => 'px'
						),
					),

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
						//'style5' => 'Style 5'
 					),
 					'default' => 'style1',
 					'tooltip' => ''
 				), 	        	 								
 				array (
 					'att_name' => 'alignment',
 					'type' => 'button_group',
 					'label' => __( 'Alignment', 'tatsu' ),
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
 					'att_name' => 'color',
 					'type' => 'color',
 					'label' => __( 'Text Color', 'tatsu' ),
 					'default' => '',
					'tooltip' => '',
					'css' => true,
					'selectors' => array(
						'.tatsu-{UUID} .link-text, .tatsu-{UUID} .animated-link' => array(
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
						'.tatsu-{UUID} .animated-link:hover .link-text, .tatsu-{UUID} .animated-link:hover' => array(
							'property' => 'color'
						),
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
						'.tatsu-{UUID} .animated-link:before' => array(
							'property' => 'color'
						),
						'.tatsu-{UUID} .animated-link .next-arrow span' => array(
							'property' => 'background'
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
					'selectors' => array(
						'.tatsu-{UUID} .animated-link:hover:before' => array(
							'property' => 'color'
						),
						'.tatsu-{UUID} .animated-link:hover .next-arrow span' => array(
							'property' => 'background'
						),
					),
 				),
 				// array (
 				// 	'att_name' => 'border_width',
 				// 	'type' => 'number',
 				// 	'label' => __( 'Border Size', 'tatsu' ),
 				// 	'options' => array(
 				// 		'unit' => 'px',
 				// 		'add_unit_to_value' => false,
 				// 	),
 				// 	'default' => '0',
 				// 	'tooltip' => ''
 				// ),
 				// array (
 				// 	'att_name' => 'border_color',
 				// 	'type' => 'color',
 				// 	'label' => __( 'Border Color', 'tatsu' ),
 				// 	'default' => '',
 				// 	'tooltip' => '',
 				// 	'visible' => array( 'border_width', '>', '0' ),
 				// ),
 				// array ( 
 				// 	'att_name' => 'hover_border_color',
 				// 	'type' => 'color',
 				// 	'label' => __( 'Hover Border Color', 'tatsu' ),
 				// 	'default' => '',
 				// 	'tooltip' => '',
 				// 	'visible' => array( 'border_width', '>', '0' ),
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
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'link_text' => 'Click Here',
						'hover_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
						'line_hover_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),       			
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'oshine_animated_link', $controls );
}
?>