<?php
/**************************************
			ACCORDION
**************************************/
if (!function_exists('be_accordion')) {
	function be_accordion( $atts, $content ) {
		extract (
			shortcode_atts ( array ( 
				'collapsed' => 0
			), $atts)
		);
		return '<div class="accordion oshine-module" data-collapsed="'.$collapsed.'">'.do_shortcode($content).'</div>';
	}
	add_shortcode( 'accordion', 'be_accordion' );
}

if (!function_exists('be_toggle')) {
	function be_toggle( $atts, $content ){
		$atts = shortcode_atts ( array ( 
				'title' => '',
				'title_color' => '',
				'title_bg_color' => '',
				'key' => be_uniqid_base36(true)
			), $atts	
		);

		extract ( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'toggle', $atts['key'] );
		$custom_class_name = ' tatsu-'.$atts['key'];

		$style = 'no-bg';
		$background_color = '';
		$title_padding = '';
		if (isset($title_bg_color) && !empty($title_bg_color) && '' != $title_bg_color){
			$background_color = 'background-color:'.$title_bg_color ;
			$title_padding = 'padding: 12px;';
			$style = 'with-bg';
		}
		return '<h3 class="accordion-head '.$style. $custom_class_name.'" style="'.$title_padding.'">'.$title. $custom_style_tag.'</h3><div>'.do_shortcode($content) . '</div>';
	}
	add_shortcode( 'toggle', 'be_toggle' );
}

?>