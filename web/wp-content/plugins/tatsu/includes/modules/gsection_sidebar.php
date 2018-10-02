<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_gsection_sidebar' ) ) {
	function tatsu_gsection_sidebar( $atts ) {

		$atts = shortcode_atts( array(
			'sidebar_id' => '',
            'key' => be_uniqid_base36( true )
            ),$atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gsection_meta', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];



		extract( $atts );
		$output = '';
        $output .= '<div class="tatsu-module tatsu-gsection-sidebar ' . $custom_class_name .'">';
        ob_start();
        dynamic_sidebar( $sidebar_id );
        $output .= ob_get_clean();
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_gsection_sidebar', 'tatsu_gsection_sidebar' );
}

?>