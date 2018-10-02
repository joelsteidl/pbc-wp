<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Module_Options {

	private static $instance;
	private $modules;
	private $module_options;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->modules = array();
		$this->module_options = array();
	}


	public function deregister_module( $tag ) {
		if( 'core' === $this->get_module_type( $tag ) ) {
			return;
		} else if( array_key_exists($tag, $this->modules) ) {
			unset( $this->modules[$tag] );
		}
	}

	public function register_module( $tag, $options ) {
		$new_module = array( $tag => $options );
		$this->modules = array_merge( $this->modules, $new_module );
	}

	public function get_modules() {
		return $this->modules;
	}

	public function get_module_options() {
		$this->module_options['tatsu_module_options'] = $this->modules;
		return $this->module_options;
	}

	public function setup_hooks() {
		do_action( 'tatsu_register_modules' );
		do_action( 'tatsu_deregister_modules' );	
		if( !empty( $_GET[ 'tatsu-global' ] ) || tatsu_check_if_global() ) {
			do_action( 'tatsu_register_global_section' );
		}
	}

	public function get_module_type( $tag ){
		if( array_key_exists( $tag, $this->modules ) ){
			return $this->modules[$tag]['type'];
		} else {
			return false;
		}
	}

	public function get_core_modules(){
		$core_modules = array();
		foreach ( $this->modules as $tag => $options ) {
			if( 'core' === $options['type'] ) {
				$core_modules[] = $tag;
			}
		}
		return $core_modules;
	}

	public function get_registered_modules() {
		return array_keys( $this->modules );
	}
 
}

?>