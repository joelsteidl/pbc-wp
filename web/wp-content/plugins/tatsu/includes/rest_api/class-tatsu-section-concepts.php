<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Section_Concepts {

	private static $instance;
	private $concepts;


	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->concepts = array();
	}


	public function deregister_concept( $name ) {
		if( array_key_exists( $name, $this->concepts ) ) {
			unset( $this->concepts[$name] );
		}
	}

	public function register_concept( $name, $options ) {
		$new_concept = array( $name => $options );
		$this->concepts = array_merge( $this->concepts, $new_concept );
	}


	public function ajax_get_section_concepts() {

		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}		

		$concepts = array();
		
		foreach ( $this->concepts as $concept => $options ) {
			$new_concept = array();
			$new_concept['name'] = $concept;
			$new_concept['title'] = $options['title'];
			$new_concept['img'] = $options['img'];
			$parser = new Tatsu_Parser( $options['shortcode'], false );
			$new_concept['content'] = $parser->parse( $options['shortcode'] );
			$concepts[] = $new_concept;
		}
		$concepts = apply_filters( 'tatsu_get_section_concepts', $concepts );
		header('Content-Type: application/json');
		echo json_encode( $concepts );
		wp_die();

	}

	public function setup_hooks() {
		do_action( 'tatsu_register_section_concepts' );
		do_action( 'tatsu_deregister_section_concepts' );		
	}

}

?>