<?php
if ( !function_exists( 'tatsu_text_with_shortcodes' ) ) {
	function tatsu_text_with_shortcodes( $atts, $content ) {
		extract( shortcode_atts( array(
	        'animate'=>0,
	        'animation_type'=>'fadeIn',
	    ),$atts ) );
		$output = '';
		$class = 'tatsu-module';
		$data = '';
		if( isset( $animate ) && 1 == $animate ) {
			$class .= ' tatsu-animate';
			$data = 'data-animation="'.$animation_type.'"';
		}

		$output .= '<div class="tatsu-shortcode-module '.$class.'" '.$data.'>';
		$output .= do_shortcode( shortcode_unautop( $content ) );
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_text_with_shortcodes', 'tatsu_text_with_shortcodes' );
}

?>