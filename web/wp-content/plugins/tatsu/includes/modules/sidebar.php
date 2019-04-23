<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_sidebar' ) ) {
	function tatsu_sidebar( $atts ) {

		$atts = shortcode_atts( array(
			'sidebar_id' => '',
            'key' => be_uniqid_base36( true )
            ),$atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_sidebar', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];



		extract( $atts );
		$output = '';
        $output .= '<div class="tatsu-module tatsu-sidebar ' . $custom_class_name .'">';
        ob_start();
        dynamic_sidebar( $sidebar_id );
        $output .= ob_get_clean();
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_sidebar', 'tatsu_sidebar' );
	add_shortcode( 'tatsu_gsection_sidebar', 'tatsu_sidebar' );
}

if( !function_exists( 'tatsu_sidebar_prevent_autop' ) ) {
	function tatsu_sidebar_prevent_autop( $content_filter, $tag ) {
		if( 'tatsu_sidebar' === $tag || 'tatsu_gsection_sidebar' === $tag ) {
			return false;
		}
		return $content_filter;
	}
}

?>