<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Page_Templates {

	private $templates;
	private static $instance;

	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->templates = array();
	}

	public function get_template( WP_REST_Request $request ) {
		$name = $request->get_param('name');
		$type = $request->get_param('type');
		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );

		if( !empty( $templates[$type][$name] ) ) {
			$parser = new Tatsu_Parser( $templates[$type][$name]['content'] );
			$template_content = json_decode( $parser->get_tatsu_page_content(), true )  ;
			return $template_content;
		} else {
			if( array_key_exists( $name, $this->templates ) ) {
				$template_content = file_get_contents( $this->templates[$name]['src'] );
				if( $template_content ) {
					$parser = new Tatsu_Parser( $template_content );
					$template_content = json_decode( $parser->get_tatsu_page_content(), true )  ;
					return $template_content;
				}
			} else {
				return false;
			}
		}
		return false;
	}

	public function ajax_get_template() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$name = $_POST['name'];
		$type = $_POST['type'];
		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );

		if( !empty( $templates[$type][$name] ) ) {
			$parser = new Tatsu_Parser( $templates[$type][$name]['content'] );
			$template_content = json_decode( $parser->get_tatsu_page_content(), true )  ;
			echo json_encode( $template_content );
			wp_die();
		} else {
			if( array_key_exists( $name, $this->templates ) ) {
				$template_content = file_get_contents( $this->templates[$name]['src'] );
				if( $template_content ) {
					$parser = new Tatsu_Parser( $template_content );
					$template_content = json_decode( $parser->get_tatsu_page_content(), true )  ;
					echo json_encode( $template_content );
					wp_die();
				}
			} else {
				echo 'false';
				wp_die();
			}
		}
		echo 'false';
		wp_die();
	}	

	public function save_template( WP_REST_Request $request ) {
		//delete_option( 'tatsu_templates' );
		$name = $request->get_param('name');
		$type = $request->get_param('type');
		$title = $request->get_param('title');
		$inner = json_decode( $request->get_param('template_content') , true );
		$inner = $inner['inner'];

		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );
		$templates[$type][$name]['content'] = tatsu_shortcodes_from_content( $inner ); 
		$templates[$type][$name]['title'] = $title;
		$templates = json_encode( $templates );

		return update_option( 'tatsu_templates',  $templates );
		
	}

	public function ajax_save_template() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$name = $_POST['name'];
		$type = $_POST['type'];
		$title = $_POST['title'];
		$inner = json_decode( stripslashes( $_POST['template_content'] ) , true );
		$inner = $inner['inner'];

		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );
		$templates[$type][$name]['content'] = tatsu_shortcodes_from_content( $inner ); 
		$templates[$type][$name]['title'] = $title;
		$templates = json_encode( $templates );

		if( update_option( 'tatsu_templates',  $templates ) ) {
			echo 'true';
			wp_die();
		} else {
			echo 'false';
			wp_die();
		}	
	}	

	public function delete_template( WP_REST_Request $request ) {
		$name = $request->get_param('name');
		$type = $request->get_param('type');
		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );
		unset( $templates[$type][$name] );
		$templates = json_encode( $templates );
		return update_option( 'tatsu_templates',  $templates );
	}

	public function ajax_delete_template() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$name = $_POST['name'];
		$type = $_POST['type'];
		$templates = get_option('tatsu_templates', '');
		$templates = json_decode( $templates, true );
		unset( $templates[$type][$name] );
		$templates = json_encode( $templates );
		if( update_option( 'tatsu_templates',  $templates ) ) {
			echo 'true';
			wp_die();
		} else {
			echo 'false';
			wp_die();			
		}
	}	

	public function register_template( $args ) {
		if( is_array( $args ) && !empty( $args['name'] ) && !empty( $args['src'] ) ) {
			$new_template = array(  
				$args['name'] => array(
					'title' => !empty( $args['title'] )? $args['title'] : $args['name'],
					'src' => $args['src'],
					'img' => !empty( $args['img'] )? $args['img'] : '',
				)
			);
			$this->templates = array_merge( $this->templates, $new_template );
		}

	}

	public function get_templates_list() {
		
		$saved_templates = json_decode( get_option( 'tatsu_templates', '' ), true );
		$templates_list = array();
		if( empty( $saved_templates ) ) {
			$templates_list['templates'] = array();
			$templates_list['sections'] = array();
		} else {
			foreach ( $saved_templates as $type => $templates ) {
				foreach( $templates as $name => $template ) {
					$templates_list[$type][] = array(
						'name' => $name,
						'title' => $template['title']
					); 
				}	
			}			
		}

		foreach ( $this->templates as $name => $template ) {
			$templates_list['pre_built'][] = array(
				'name' => $name,
				'title'=> $template['title']
			);
		}

		if( empty( $templates_list['pre_built'] ) ) {
			$templates_list['pre_built'] = array();
		}
		

		return $templates_list;			
		 
	}

	public function setup_hooks() {
		do_action( 'tatsu_register_templates' );	
	}	
}
?>