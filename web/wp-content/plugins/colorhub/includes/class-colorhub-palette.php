<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Colorhub_Palette {

    private $palettes;
    private $data;

	public function __construct() {
        $this->data = get_option( 'colorhub_data', array(
            'palettes' => array(
                'currentPalette' => 'default',
                'allPalettes' => array()
            )
        ));
        $this->palettes = $this->data['palettes'];
    }

    public function get_palette_color( $id ) {
        $palettes = $this->get_palettes();
        $current_palette_colors = $palettes['allPalettes'][$palettes['currentPalette']];
        return $current_palette_colors[$id];
    }


    public function get_palettes() {  
        $current_palette = ( !empty( $this->palettes['currentPalette'] ) ) ? $this->palettes['currentPalette'] : 'default';
        $predefined_palettes = Colorhub_Palette_Config::getInstance()->get_palettes();
        $all_palettes = array_merge( $predefined_palettes, $this->palettes['allPalettes'] );
        return array( 
            'currentPalette' => $current_palette, 
            'allPalettes' => $all_palettes  
        );
    }
    
    
}