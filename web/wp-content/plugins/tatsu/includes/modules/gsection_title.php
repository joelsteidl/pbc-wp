<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_gsection_title' ) ) {
	function tatsu_gsection_title( $atts ) {
		$atts = shortcode_atts( array(
			'alignment' => 'center',
			'title_font' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gsection_title', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];


		extract( $atts );
		$output = '';
		
		global $post;

		$output .= '<div class="tatsu-module tatsu-gsection_title ' . $custom_class_name . ' align-'.$alignment.'">';
		$output .= '<div class="'. $title_font .'" >'. get_the_title( $post->ID ) . '</div>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_gsection_title', 'tatsu_gsection_title' );
}

?>