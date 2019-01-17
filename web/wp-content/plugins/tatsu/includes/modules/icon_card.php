<?php
if( !function_exists( 'tatsu_icon_card' ) ) {
    function tatsu_icon_card( $atts, $content ) {

        $atts = shortcode_atts( array (
            'style'             => 'style1',
            'icon_type'         => 'icon',
            'horizontal_alignment' => 'center',
            'vertical_alignment'   => 'center',
            'icon'              => '',
            'svg_icon'          => '',
            'image'             => '',
            'icon_style'        => '',
            'icon_bg'           => '',
            'icon_color'        => '',
            'size'              => 'medium',
            'line_animate'      => '0',
            'svg_icon_color'    => '',
            'box_shadow'        => '',
            'title'             => '',
            'url'               => '',
            'title_font'        => '',
            'title_color'       => '',
            'caption_font'      => '',
            'caption_color'     => '',
            'margin'            => '0 0 60px 0',
            'animate'           => '',
            'animation_type'    => '',
            'animation_delay'   => 0,
            'builder_mode'      => '',
            'hide_in'           => '',
            'key'               => be_uniqid_base36(true),
        ), $atts );

        extract($atts);


        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_icon_card', $atts['key'], $builder_mode );
        $unique_class_name = ' tatsu-'.$atts['key'];
        $visibility_classes = '';
        $classes = array( 'tatsu-module', 'tatsu-icon_card', $unique_class_name );
        //Handle Resposive Visibility controls
        if( !empty( $hide_in ) ) {
            $hide_in = explode(',', $hide_in);
            foreach ( $hide_in as $device ) {
                $visibility_classes .= ' tatsu-hide-'.$device;
            }
        }
        $icon_type = !empty($icon_type) ? $icon_type : 'icon';

        if(!empty($icon_type)) {
            $classes[] = 'tatsu-icon_card-type-' . $icon_type;
        }
        if( !empty($style) ) {
            $classes[] = 'tatsu-icon_card-' . $style;
        }else {
            $classes[] = 'tatsu-icon_card-style1';
        }
        if( !empty($horizontal_alignment) ) {
            $classes[] ='tatsu-icon_card-align-' . $horizontal_alignment;
        }
        if( 'style1' === $style && !empty($vertical_alignment) ) {
            $classes[] = 'tatsu-icon_card-vertical-align-' . $vertical_alignment;
        }
        if( 'image' !== $icon_type && 'circled' === $icon_style ) {
            $classes[] = 'tatsu-icon_circled';
        }
        if( !empty($size) ) {
            $classes[] = 'tatsu-icon_' . $size;
        }else {
            $classes[] = 'tatsu-icon_medium';
        }
        if( !empty($animate) ) {
            $classes[] = 'be-animate';
            if( !empty($animation_type) && 'none' != $animation_type ) {
                $animation_type = 'data-animation = "' . $animation_type . '"';
            }
            $animation_delay = 'data-animation-delay = "' . $animation_delay . '"';
        }
    
        $svg_icon_html = '';
        if( 'svg' === $icon_type ) {
            if( !empty($line_animate) ) {
                $classes[] = 'tatsu-line-animate';
            }
            $svg_icon_html = function_exists( 'tatsu_get_svg_icon' ) ? tatsu_get_svg_icon( $svg_icon ) : '';
        }

        $icon = !empty($icon) ? $icon : '';
        $url = !empty($url) ? $url : '';

        $classes = implode( ' ', $classes );
        ob_start();
    ?>
            <div class = "<?php echo $classes; echo $visibility_classes; ?>" <?php echo $animation_type; ?> <?php echo $animation_delay; ?> >
                <?php echo $custom_style_tag; ?>
                <?php if( ( 'icon' === $icon_type && !empty( $icon ) ) || ( 'svg' === $icon_type && !empty( $svg_icon_html ) ) || ( 'image' === $icon_type && !empty( $image ) ) ) : ?>
                    <div class = "tatsu-icon_card-icon <?php echo 'circled' === $icon_style && 'image' !== $icon_type ? 'tatsu-icon_bg' : ( ( 'plain' === $icon_style && 'image' === $icon_type ) ? 'tatsu-img-plain' : '' ); ?>">
                        <?php if( 'icon' === $icon_type ) : ?>
                            <i class = "tatsu-icon <?php echo $icon; ?>">
                            </i>
                        <?php elseif( 'svg' === $icon_type ) : ?>
                            <?php echo $svg_icon_html; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if( !empty( $title ) || !empty( $content ) ) : ?>
                    <div class = "tatsu-icon_card-title-caption">
                        <?php if( !empty( $title ) ) : ?>
                            <div class = "tatsu-icon_card-title <?php echo !empty($title_font) ? $title_font : ''; ?>">
                                <a href = "<?php echo $url; ?>">
                                    <?php echo $title; ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $content ) ) : ?>
                            <div class = "tatsu-icon_card-caption <?php echo !empty($caption_font) ? $caption_font : ''; ?>">
                                <?php echo $content; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
    <?php
        return ob_get_clean();
    }
    add_shortcode( 'tatsu_icon_card', 'tatsu_icon_card' );
}


if( !function_exists( 'tatsu_icon_card_header_atts' ) ) {
	function tatsu_icon_card_header_atts( $atts, $tag ) {
		if( 'tatsu_icon_card' === $tag ) {
			// New Atts
			$atts['hide_in'] = array (
				'type' => 'screen_visibility',
				'label' => __( 'Hide in', 'tatsu' ),
				'default' => 0,
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
					'.tatsu-{UUID}.tatsu-module' => array(
						'property' => 'margin',
					),
				),
            );
            $atts['vertical_alignment']['default'] = 'center';
		}
		return $atts;
	}
	add_filter( 'tatsu_header_modify_atts', 'tatsu_icon_card_header_atts', 10, 2 );
}

?>