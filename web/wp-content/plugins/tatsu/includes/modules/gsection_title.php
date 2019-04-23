<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_gsection_title' ) ) {
	function tatsu_gsection_title( $atts ) {
		$atts = shortcode_atts( array(
			'alignment' => 'center',
			'title_font' => '',
			'margin'	 => '0 0 30px 0',
			'key' => be_uniqid_base36(true),
		),$atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gsection_title', $atts['key'], 'Global' );
		$custom_class_name = 'tatsu-'.$atts['key'];


		extract( $atts );
		$output = '';
		global $post;
		$post_title = '';
		$is_others_page = tatsu_is_others_page_type();
		if( is_archive() || $is_others_page[0] ){
			if( is_search() ){
				$post_title = esc_html__( 'Search', 'tatsu' );
			} else if( is_404() ){
				$post_title = esc_html__( '404', 'tatsu' );
			} else {
				$post_title = get_the_archive_title();
			}
		} elseif( is_home() ) {
			$post_title = esc_html__('BLOG','tatsu');
		} else {
			$post_title = $post->post_title;
		}
		
		$output .= '<div class="tatsu-module tatsu-gsection-title ' . $custom_class_name . ' align-'.$alignment.'">';
		$output .= '<div class="'. $title_font .'" >'. $post_title . '</div>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_gsection_title', 'tatsu_gsection_title' );
}

?>