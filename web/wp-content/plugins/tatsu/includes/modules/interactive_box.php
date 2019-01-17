<?php
if( !function_exists( 'tatsu_interactive_box' ) ) {
    function tatsu_interactive_box($atts,$content) {
        
        $atts =  shortcode_atts( array (
            'style'                 => 'style1',
            'flip_type'             => 'horizontal',
            'alignment'             => 'center',
            'overlay'               => '0',
            'overlay_color'         => '',
            'title'                 => '',
            'title_font'            => '',
            'title_color'           => '',
            'title_hover_color'     => '',
            'icon'                  => 'none',
            'svg_icon'              => '',
            'icon_size'             => '',
            'icon_color'            => '',
            'icon_hover_color'      => '',
            'border_color'          => '',
            'border_radius'         => '',
            'content_color'         => '',
            'content_hover_color'   => '',
			'url'                   => '',
            'bg_image'              => '',
            'custom_height'         => '',
            'height'                => '500',
            'vertical_alignment'    => 'center',
			'bg_color'              => '',
            'hover_bg_color'        => '',
            'strip_bg_color'        => '',
            'arrow_color'           => '',
            'box_shadow'            => '',
            'margin'                => '0 0 60px 0',
            'animate'               => '',
            'animation_type'        => 'none',
            'animation_delay'       => 0,
			'key'                   => be_uniqid_base36(true),
		),$atts );

        extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_interactive_box', $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];

        $style = !empty( $style ) ? $style : 'stacked';
        $bg_image = !empty( $bg_image ) ? $bg_image : '';

        $icon = !empty( $icon ) ? $icon : '';
        $classes = array( 'tatsu-interactive-box', 'tatsu-module', $custom_class_name );
        $data_attrs = array();

        //classes
        $classes[] = 'tatsu-interactive-box-' . $style;
        if( 'flip' == $style && !empty( $flip_type ) ) {
            $classes[] = 'tatsu-interactive-box-flip-' . $flip_type;
        }
        if( !empty($alignment) ) {
            $classes[] = 'tatsu-interactive-box-align-' . $alignment;
        }
        if( !empty( $bg_image ) ) {
            $classes[] = 'tatsu-interactive-box-with-bg-image';
        }
        if( 'flip' !== $style ) {
            if( !empty($overlay) ) {
            $classes[] = 'tatsu-interactive-box-overlay';
            }
            if( !empty( $custom_height ) ) {
                $classes[] = 'tatsu-interactive-box-custom-height';
            }
        }
        if( !empty( $animate ) && !empty( $animation_type ) && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        $overlay_class = 'flip' === $style && !empty( $overlay ) ? 'tatsu-interactive-box-overlay' : '';

        //attrs
        if( !empty( $animate ) ) {
            if( !empty( $animation_type ) && 'none' !== $animation_type ) {
                $data_attrs[] = sprintf( 'data-animation = "%s"', $animation_type );
            }
            $data_attrs[] = sprintf( 'data-animation-delay = "%d"', $animation_delay );
        }
        $url = !empty( $url ) ? $url : '';

        if( 'transform' === $style ) {
            $svg_icon_html = tatsu_get_svg_icon( $svg_icon );
            if( empty( $svg_icon_html ) ) {
                $classes[] = 'tatsu-interactive-box-allow-overflow';
            }
        }

        $classes = implode( ' ', $classes );
        $data_attrs = implode( ' ', $data_attrs );
        ob_start();
        ?>
            <div class = "<?php echo $classes; ?>" <?php echo $data_attrs; ?>>
                <?php echo $custom_style_tag; ?>
                <?php if( !empty( $url ) ) : ?>
                    <a class = "tatsu-interactive-box-link" href = "<?php echo $url; ?>">
                    </a>
                <?php endif; ?>
                <?php if( 'flip' === $style ) : ?>
                    <div class = "tatsu-interactive-box-flip-wrap">
                        <div class = "tatsu-interactive-box-front <?php echo $overlay_class; ?>">
                            <div class = "tatsu-interactive-box-header">
                                <div class = "tatsu-interactive-box-icon">
                                    <i class = "tatsu-icon <?php echo $icon; ?>">
                                    </i>
                                </div>
                                <div class = "tatsu-interactive-box-title <?php echo $title_font; ?>">
                                    <?php echo $title; ?>
                                </div>
                            </div>
                        </div>
                        <div class = "tatsu-interactive-box-back <?php echo $overlay_class; ?>">
                            <div class = "tatsu-interactive-box-content">
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <?php if( 'stacked' === $style ) : ?>
                    <div class = "tatsu-interactive-box-stacks">
                        <?php if( !empty( $bg_image ) ) : ?>
                            <div class = "tatsu-interactive-box-image-holder">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class = "tatsu-interactive-box-inner">
                        <div class = "tatsu-interactive-box-header">
                            <div class = "tatsu-interactive-box-icon">
                                <i class = "tatsu-icon <?php echo $icon; ?>">
                                </i>
                            </div>
                            <div class = "tatsu-interactive-box-title <?php echo $title_font; ?>">
                                <?php echo $title; ?>
                            </div>
                        </div>
                        <div class = "tatsu-interactive-box-content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if( 'transform' === $style ) : ?>
                    <?php  ?>
                    <div class = "tatsu-interactive-box-inner">
                        <div class = "tatsu-interactive-box-icon-content">
                            <?php if( !empty( $svg_icon_html ) ) : ?>
                                <div class = "tatsu-interactive-box-icon tatsu-line-animate">
                                    <?php echo $svg_icon_html; ?>
                                </div>
                            <?php endif; ?>
                            <div class = "tatsu-interactive-box-title <?php echo $title_font; ?>">
                                <?php echo $title; ?>
                            </div>
                            <div class = "tatsu-interactive-box-content">
                                <?php echo $content; ?>
                            </div>
                        </div>
                        <div class = "tatsu-interactive-box-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 43 29">
                                <g fill="none" stroke-linecap="round" stroke-width="3" transform="translate(2 2)">
                                    <path d="M0.106550075,12.6101838 L38.2937419,12.6101838"/>
                                    <polyline stroke-linejoin="round" points="27.042 0 39.31 12.581 27.042 25.161"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php 
            return ob_get_clean();        
    }
}