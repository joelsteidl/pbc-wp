<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Typehub_Store {

    private $store;
    private $data;
    
    public function __construct() {
        $this->store = array();
        $this->data = get_option( 'typehub_data', array(
            'font_schemes' => array(),
            'values' => array(),
            'settings' => array()
        ));	
    }

    public function get_store() {
         
        $this->store['fontSchemes'] = $this->get_fonts();
        $this->store['optionConfig'] = $this->get_options();
        $this->store['savedValues'] = $this->data['values'];
        $this->store['settings'] = !empty( $this->data['settings'] ) ? $this->data['settings'] : array();

        return $this->store;

    }

    public function get_fonts() {
        return Typehub_Font_Schemes::getInstance()->get_schemes();
    }

    public function get_options() {
        $predefined_options = Typehub_Options::getInstance()->get_options();
        // CUSTOM OPTIONS feature moved to a later update.
        // if( empty( $this->data['options'] ) ) {
        //     $this->data['options'] = array();
        // }
        // return array_merge( $predefined_options, $this->data['options'] );
        return $predefined_options;
    }
    
    public function ajax_save() {
        check_ajax_referer( 'typehub-security', 'security' );

        if( !array_key_exists( 'store', $_POST ) ) {
            echo 'failure';
            wp_die();
        }

        $store = json_decode( stripslashes( $_POST['store'] ), true );
        $data['fontSchemes'] = ( array_key_exists( 'fontSchemes', $store ) ) ? $store['fontSchemes'] : array();
        $data['savedValues'] = ( is_array( $store['initConfig']['savedValues'] ) ) ? $store['initConfig']['savedValues'] : array();
        $data['settings'] = is_array( $store['settings']) ? $store['settings'] : array();
        $save_store = $this->save_store( $data );
        if( $save_store ) {
            echo 'success';
        } else {
            echo 'failure';
        }
        wp_die();
    }
    
    public function ajax_get_typekit_fonts() {

        check_ajax_referer( 'typehub-security', 'security' );

        if( !array_key_exists( 'typekitId', $_POST ) ) {
            echo 'failure';
            wp_die();
        }
        echo json_encode(get_typekit_data($_POST['typekitId']));
        wp_die();
    }

    public function ajax_get_local_font_details(){

        check_ajax_referer( 'typehub-security', 'security' );
        
        $local_fonts = get_saved_fonts();

        echo json_encode($local_fonts);
        wp_die(); 
    }

    public function ajax_download_font(){

        check_ajax_referer( 'typehub-security', 'security' );
        
        if( !array_key_exists( 'fontName', $_POST ) ) {
            echo 'failure';
            wp_die();
        }
        $result = download_font_from_google( $_POST['fontName'] );
        echo $result;
        wp_die();
    }
    public function ajax_refresh_changes(){

        delete_unused_fonts();
        $saved_fonts = get_saved_fonts();
        foreach( $saved_fonts as $saved_font => $value ){
            write_css_link_to_file( $value );
        }
        echo 'success';
        wp_die();

    }

    public function save_store( $data ) {
        
        $this->data['font_schemes'] = $data['fontSchemes'];
        $this->data['values'] = $data['savedValues'];
        $this->data['settings'] = $data['settings'];

        return update_option( 'typehub_data', $this->data );
    }
    
}