<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Config {

	private static $instance;
	private $google_maps_api_key = '';

 	private static $css_animations = array(
			'flipInX' => 'flipInX', 
			'flipInY' => 'flipInY', 
			'fadeIn' => 'fadeIn', 
			'fadeInDown' => 'fadeInDown', 
			'fadeInLeft' => 'fadeInLeft', 
			'fadeInRight' => 'fadeInRight', 
			'fadeInUp' => 'fadeInUp', 
			'slideInDown' => 'slideInDown', 
			'slideInLeft' => 'slideInLeft', 
			'slideInRight' => 'slideInRight', 
			'rollIn' => 'rollIn', 
			'rollOut' => 'rollOut',
			'bounce' => 'bounce',
			'bounceIn' => 'bounceIn',
			'bounceInUp' => 'bounceInUp',
			'bounceInDown' => 'bounceInDown',
			'bounceInLeft' => 'bounceInLeft',
			'bounceInRight' => 'bounceInRight',
			'fadeInUpBig' => 'fadeInUpBig',
			'fadeInDownBig' => 'fadeInDownBig',
			'fadeInLeftBig' => 'fadeInLeftBig',
			'fadeInRightBig' => 'fadeInRightBig',
			'flash' => 'flash',
			'flip' => 'flip',
			'lightSpeedIn' => 'lightSpeedIn',
			'pulse' => 'pulse',
			'rotateIn' => 'rotateIn',
			'rotateInUpLeft' => 'rotateInUpLeft',
			'rotateInDownLeft' => 'rotateInDownLeft',
			'rotateInUpRight' => 'rotateInUpRight',
			'rotateInDownRight' => 'rotateInDownRight',
			'shake' => 'shake',
			'swing' => 'swing',
			'tada' => 'tada',
			'wiggle' => 'wiggle',
			'wobble' => 'wobble',
			'infiniteJump' => 'infiniteJump',
			'zoomIn' => 'zoomIn',
			'none' => 'none'
		);

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->google_maps_api_key = get_option( 'tatsu_google_map_id' );
	}

	public function get_css_animations() {
		return self::$css_animations;
	}

	public function get_google_maps_api_key() {
		return apply_filters( 'tatsu_gmaps_api_key', $this->google_maps_api_key );
	}

	public function get_core_modules() {
		return apply_filters( 'tatsu_core_modules', array( 'tatsu_section', 'tatsu_row', 'tatsu_column', 'tatsu_inner_row', 'tatsu_inner_column', 'tatsu_header_row', 'tatsu_header_column' , 'tatsu_slide_menu_column' ) );
	}

}