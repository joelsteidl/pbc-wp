<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Store {

	private $post_id;
	private $core_modules;
	private $store;

	public function __construct( $post_id = null ) {
        $this->store = array();	
        if( !empty( $post_id ) ) {
            $this->post_id = $post_id;
        }
    }


	public function get_store( WP_REST_Request $request ) {
		$this->post_id = $request->get_param('post_id');
		$this->store = array_merge( $this->get_module_options(), $this->get_page_content() );
		if( tatsu_check_if_global() && array_key_exists( 'tatsu_module_options', $this->store ) ) {
			$this->store[ 'tatsu_module_options' ] = array_merge( $this->store[ 'tatsu_module_options' ], $this->get_gsection_modules() );
		}
	//	$header_store = new Tatsu_Header_Store();
	//	$this->store = $header_store->get_store();
		$response = new WP_REST_Response( $this->store );
		if( ob_get_length() ) {
			ob_clean();
		}
		$response->header('Content-Type', 'application/json' );
		//return $this->store;
		return $response;
	}	

	private function get_gsection_modules() {
		return Tatsu_Global_Module_Options::getInstance()->get_modules();
	}

	public function get_module_options() {
		return Tatsu_Module_Options::getInstance()->get_module_options(); 
	}


	public function get_page_content() {
		$tatsu_page_content = new Tatsu_Page_Content( $this->post_id );
		return array(
            'inner' => $tatsu_page_content->get_tatsu_content(),
            'name' => 'home',
            'title' => 'home',
            'builderLayout' => 'list',
            'childModule' => 'section' ,
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

		$body_fonts = !empty( $_POST['tatsu_body_fonts'] ) ? json_decode( stripslashes( $_POST['tatsu_body_fonts'] ), true ) : array();

		$this->post_id = $_POST['post_id'];

		if( !empty( $_POST['post_name'] ) && !empty( $_POST['post_status'] ) ){
			$post_data = array(
				'ID'           => $this->post_id,
				'post_title'   => $_POST['post_name'],
				'post_status' => $_POST['post_status'],
			);
		  
			wp_update_post( $post_data );
        }
        
        tatsu_update_custom_css_js( $this->post_id, $_POST['custom_css'], $_POST['custom_js'] );

		if( !empty( $body_fonts ) ){
			update_post_meta( $this->post_id, 'tatsu_body_fonts', $body_fonts );
		}

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
		if( ob_get_length() ) {
			ob_clean();
		}
		header('Content-Type: application/json');
		echo json_encode( $tatsu_content );
		wp_die();
	}


	private function isJson($string) {
 		json_decode($string);
 		return ( json_last_error() == JSON_ERROR_NONE );
	}

	public function ajax_get_revision_content(  ){

		$revision_id = $_POST['revision_id'];
		$post_id = $_POST['post_id'];
		$selected_revision = wp_get_post_revision( $revision_id);

		$parser = new Tatsu_Parser();

		$revision_content = $parser->parse( $selected_revision->post_content );

		echo json_encode($revision_content);
		wp_die();
	}

	public function ajax_get_revision_data(){
		echo json_encode( tatsu_revision_data( $_POST['post_id'], $_POST['offset'] ) );
		wp_die();
	}

}