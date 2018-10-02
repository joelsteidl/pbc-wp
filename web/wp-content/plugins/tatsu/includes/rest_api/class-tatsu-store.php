<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Store {

	private $post_id;
	private $core_modules;
	private $store;

	public function __construct() {
		$this->store = array();	
	}


	public function get_store( WP_REST_Request $request ) {
		$this->post_id = $request->get_param('post_id');
		$this->store = array_merge( $this->get_module_options() , $this->get_page_content(), $this->get_page_templates() );
		$response = new WP_REST_Response( $this->store );
		if( ob_get_length() ) {
			ob_clean();
		}
		$response->header('Content-Type', 'application/json' );
		//return $this->store;
		return $response;
	}	


	private function get_module_options() {
		return Tatsu_Module_Options::getInstance()->get_module_options(); 
	}


	private function get_page_content() {
		$tatsu_page_content = new Tatsu_Page_Content( $this->post_id );
		return array(
			'tatsu_page_content' => array(
				'inner' => $tatsu_page_content->get_tatsu_content(),
			    'name' => 'home',
			    'title' => 'home',
			    'builderLayout' => 'list',
			    'childModule' => 'section' ,
			)
		);
	}

	private function get_page_templates() {
		return array(
			'tatsu_templates' => Tatsu_Page_Templates::getInstance()->get_templates_list()
		);
	}


	public function save_store( WP_REST_Request $request ) {
		$this->post_id = $request->get_param('post_id');
		if( $this->save_page_content( $request->get_param('page_content') ) ) {
			return true;
		}
		return false;		
	}

	public function ajax_save_store() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
				
		$this->post_id = $_POST['post_id'];
		if( $this->save_page_content( $_POST['page_content'] ) ) {
			echo 'true';
			wp_die();
		}
		echo 'false';
		wp_die();
	}

	private function save_page_content( $content ) {
		$content = stripslashes( $content);  // added for admin-ajax requests
		if( $this->isJson( $content ) ) {
			$tatsu_page_content = new Tatsu_Page_Content( $this->post_id );
			return $tatsu_page_content->set_page_content( $content );
		}

		return false;		
	}

	public function ajax_paste_shortcode() {
		
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}
		
		$this->content = stripslashes( urldecode($_POST['shortocde']) );
		$parser = new Tatsu_Parser( $this->content, false );
		$tatsu_content = $parser->parse( $this->content );
		header('Content-Type: application/json');
		echo json_encode( $tatsu_content );
		wp_die();
	}


	private function isJson($string) {
 		json_decode($string);
 		return ( json_last_error() == JSON_ERROR_NONE );
	}

}