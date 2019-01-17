<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Header_Store {

//	private $post_id;
	private $store;

	public function __construct() {
		$this->store = array();
	}


	public function ajax_get_store() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}        
	//	$this->store = array_merge( $this->get_module_options(), $this->get_header_store(), $this->get_header_templates() );
		$this->store = $this->get_store();
		if( ob_get_length() ) {
			ob_clean();
		}
		header('Content-Type', 'application/json' );
        echo json_encode( $this->store );
        wp_die();
	}	

	public function rest_get_store( WP_REST_Request $request ) {
		$this->store = $this->get_store();
		$response = new WP_REST_Response( $this->store );
		if( ob_get_length() ) {
			ob_clean();
		}
		$response->header('Content-Type', 'application/json' );
		//return $this->store;
		return $response;
	}	

	public function get_store() {
		return array_merge( $this->get_module_options(), $this->get_header_store(), $this->get_header_templates() );
	}


	private function get_module_options() {
		return Tatsu_Header_Module_Options::getInstance()->get_module_options(); 
	}


	public function get_header_store() {
		
		$header_store = get_option( 'tatsu_header_store', '' );
		
		$parser = new Tatsu_Parser( $header_store, false, 'header' );
		$header_store = json_decode( $parser->get_tatsu_page_content(), true );
		
		$header_settings = get_option('settings', '{}' );
		$header_settings = json_decode( $header_settings, true );	
		// $header_settings = '';
		if( empty( $header_settings ) ){
			$header_settings = array(
				'sticky' =>  false,
				'smart' => false,
				'transparent' => false,
				'scheme' => 'dark',
				'archive' => array('post', 'product'),
				'single' => array( 'page', 'post', 'product'),
				'taxonomy' => array('category','tag','product_cat'),
				'other' => array('author')
			);
		}
		
		return array(
			'tatsu_page_content' => array(
				'inner' => $header_store,
				'settings' => $header_settings,
			    'name' => 'home',
			    'title' => 'home',
			    'builderLayout' => 'list',
			    'childModule' => 'tatsu_header_row' ,
			)
		);
	}

	private function get_header_templates() {
		return array(
			'tatsu_header_templates' => array()  //Tatsu_Header_Templates::getInstance()->get_templates_list()
		);
	}

	public function ajax_save_store() {

		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
		
		if( !empty( $_POST['tatsu_header_fonts'] ) && $this->save_header_fonts( $_POST['tatsu_header_fonts'] ) ) {
			echo 'true';
		}
		if( !empty( $_POST['page_content'] ) && $this->save_store( $_POST['page_content'] ) ) {
			echo 'true';
		}	
		if( !empty( $_POST['settings'] ) && $this->save_settings( $_POST['settings'] ) ) {
			echo 'true';
			wp_die();
		}	

		echo 'false';
		wp_die();
	}

	private function save_header_fonts( $fonts ) {
		$fonts = stripslashes( $fonts );  // added for admin-ajax requests
        
        if( $this->isJson( $fonts ) ) {
			return update_option( 'tatsu_header_fonts' , $fonts );	
		}

		return false;		
	}

	private function save_store( $store ) {
        
		$store = stripslashes( $store );  // added for admin-ajax requests
        
        if( $this->isJson( $store ) ) {
			$header_content = tatsu_shortcodes_from_content( json_decode( $store, true ) );
			return update_option( 'tatsu_header_store' , $header_content );
		}

		return false;		
	}

	private function save_settings( $settings ) {
		
		$settings = stripslashes( $settings );
		
		if( $this->isJson( $settings ) ) {

			return update_option( 'settings' , $settings );
		}
		
		return false;
	}

	private function isJson($string) {
 		json_decode($string);
 		return ( json_last_error() == JSON_ERROR_NONE );
	}

}