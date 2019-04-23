<?php
if( !function_exists( 'tatsu_rev_slider' ) ) {
    function tatsu_rev_slider( $atts, $content ) {
        $atts = shortcode_atts( array(
            'rev_slider_alias' => '',
            'key'  => be_uniqid_base36(true),
        ), $atts );
        extract( $atts );

        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_rev_slider', $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];
        $shortcode_str = sprintf( '[rev_slider alias = "%s"]', $rev_slider_alias );
        ob_start();
?>
            <div class = "tatsu-rev-slider-wrap tatsu-module <?php echo $custom_class_name; ?>">
                <?php echo do_shortcode( $shortcode_str ); ?>
            </div>
<?php
        return ob_get_clean();
    }
}


if( !function_exists( 'tatsu_rev_slider_output_filter' ) ) {
    add_filter( 'tatsu_tatsu_rev_slider_shortcode_output_filter', 'tatsu_rev_slider_output_filter', 10, 3 );
    function tatsu_rev_slider_output_filter($content, $tag, $atts ) {
        $output = sprintf( '<div class="tatsu-module tatsu-notification tatsu-rev-slider-placeholder tatsu-error">Slider Revolution Module - %s - Preview Not Available, Please check the output in the front end</div>', array_key_exists( 'rev_slider_alias', $atts ) ? $atts[ 'rev_slider_alias' ] : '' );
        return $output;
    }
}
