<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Page_Content {

	private $post_id;
	private $content;
	private $tatsu_content;

	public function __construct( $post_id ) {
		$this->post_id = $post_id;
		$this->content = '';
	}


	public function get_tatsu_content() {
		$parser = new Tatsu_Parser( $this->get_content(), $this->post_id );
		$this->tatsu_content = json_decode( $parser->get_tatsu_page_content(), true );
		return $this->tatsu_content;
	}


	public function get_content() {
		$post = get_post( $this->post_id, 'ARRAY_A' );
		if( $post ) {
			$this->content = $post['post_content'];
		}
		return $this->content;
	}


	public function set_page_content( $tatsu_content ) {
		$this->tatsu_content = $tatsu_content;
		$this->content = tatsu_shortcodes_from_content( json_decode( $this->tatsu_content, true ) );
		$this->set_tatsu_content();
		if( $this->set_the_content() ) {
			update_post_meta( $this->post_id, '_edited_with', 'tatsu' );
			return true;
		} 
		return false;
	}
	

	private function set_tatsu_content() {
		return update_post_meta( $this->post_id, '_tatsu_page_content', wp_slash( $this->tatsu_content ) );
	}


	private function set_the_content() {
		$my_post = array(
	    	'ID' => $this->post_id,
	    	'post_content' => $this->content,
		);
		// Update the post into the database
		return wp_update_post( $my_post );
	}

}