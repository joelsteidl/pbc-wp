<?php
/**************************************
	        CODE
**************************************/
if (!function_exists('tatsu_code')) {
    function tatsu_code( $atts, $content ) {
        extract( shortcode_atts( array (
                        'id' => '',
                        'class' => '',
                ), $atts ) );

        $output = '';
        $output .= '<div id = "'. $id .'" class="tatsu-code tatsu-module '. $class .'">'; 
        $output .= shortcode_unautop( $content );
        $output .= '</div>';
        return $output;
    }
	add_shortcode( 'tatsu_code', 'tatsu_code' );
}
?>