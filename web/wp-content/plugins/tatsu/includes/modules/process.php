<?php
if( !function_exists( 'tatsu_process' ) ) {
    function tatsu_process( $atts, $content ) {
        $atts = shortcode_atts( array (
            'title_font'             => 'h5',
            'content_font'            => 'body',
            'icon_size'              => '32',
            'divider_color'          => '#D8D8D8',
            'title_color'            => '',
            'title_hover_color'      => '',
            'icon_hover_color'       => '',   
            'icon_color'             => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
            'content_color'          => '',
            'content_hover_color'    => '',
            'margin'                 => '0 0 60px 0',
            'animate'                => '',
            'animation_type'         => '',
            'animation_delay'        => '',   
            'key'                    => be_uniqid_base36(true),
        ), $atts );
        extract( $atts );
        
        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_process', $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];

        $data_animation = '';
        $data_animation_delay = '';
        $classes = 'tatsu-process tatsu-module ' . $custom_class_name;
        if( !empty( $animate ) && !empty( $animation_type ) && 'none' !== $animation_type ) {
            $classes .= ' tatsu-animate';
            $data_animation = 'data-animation = "' . $animation_type . '"';
            $data_animation_delay = 'data-animation-delay = "' . $animation_delay . '"';
        }

        global $tatsu_process_title_font, $tatsu_process_content_font;
        if( !empty( $title_font ) ) {
            $tatsu_process_title_font = $title_font;
        }else {
            $tatsu_process_title_font = '';
        }

        if( !empty( $content_font ) ) {
            $tatsu_process_content_font = $content_font;
        }else {
            $tatsu_process_content_font = '';
        }

        ob_start();
        ?>
            <div class = "<?php echo $classes; ?>" <?php echo $data_animation; ?> <?php echo $data_animation_delay; ?>>
                <?php echo $custom_style_tag; ?>
                <?php echo do_shortcode( $content ); ?>
            </div>
        <?php
        return ob_get_clean();
    }
}

if( !function_exists( 'tatsu_process_col' ) ) {
    function tatsu_process_col( $atts, $content ) {
        $atts = shortcode_atts( array (
            'icon_type'              => 'icon',
            'icon'                   => 'tatsu-icon-user',
            'svg_icon'               => '',
            'line_animate'           => '',
            'title'                  => '',
            'icon'                   => '',
            'key'                    => be_uniqid_base36(true),
        ), $atts );

        extract( $atts );

        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_process_col', $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];

        $classes = array ( 'tatsu-process-col', $custom_class_name );

        $icon_type = !empty( $icon_type ) ? $icon_type : 'icon';

        global $tatsu_process_title_font, $tatsu_process_content_font;
        $title_font = !empty( $tatsu_process_title_font ) ? $tatsu_process_title_font : '';
        $content_font = !empty( $tatsu_process_content_font ) ? $tatsu_process_content_font : '';

        $svg_icon_html = '';
        if( 'svg' == $icon_type ) {
            $classes[] = 'tatsu-process-icon-type-svg';
            if( !empty( $line_animate ) ) {
                $classes[] = 'tatsu-line-animate';
            }
            if( !empty( $svg_icon ) ) {
                $svg_icon_html = function_exists( 'tatsu_get_svg_icon' ) ? tatsu_get_svg_icon( $svg_icon ) : '';
            }
        }

        $classes = implode( ' ', $classes );
        ob_start();
        ?>
            <div class = "<?php echo $classes; ?>">
                <?php echo $custom_style_tag; ?>
                <div class = "tatsu-process-header">
                    <div class = "tatsu-process-icon">
                        <?php if( 'icon' == $icon_type ) : ?>
                            <i class = "tatsu-icon <?php echo $icon;?>">
                            </i>
                        <?php else: ?>
                            <?php echo $svg_icon_html; ?>
                        <?php endif; ?>
                    </div>
                    <div class = "tatsu-process-title <?php echo $title_font; ?>">
                        <?php echo $title; ?>
                    </div>
                </div>
                <div class = "tatsu-process-content <?php echo $content_font; ?>">
                    <?php echo do_shortcode( $content ); ?>
                </div>
                <div class = "tatsu-process-sep">
                </div>
            </div>
        <?php
        return ob_get_clean();
    }
}