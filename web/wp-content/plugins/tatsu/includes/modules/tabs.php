<?php
/**************************************
			TABS
**************************************/
if (!function_exists('tatsu_tabs')) {
	function tatsu_tabs( $atts, $content ) {
        $atts = shortcode_atts( array (
            'title_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
            'background_color'=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
            'active_title_color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
            'active_background_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
			'style' => 'style1',
			'border_color'	=> '',
            'margin'        => '',
			'animate' => 0,
			'animation_type' => 'fadeIn',
			'animation_delay' => 0,
        	'key' => be_uniqid_base36(true),
        ),$atts );
        
        extract( $atts );

		$GLOBALS['tabs_cnt'] = 0;
		$tabs_cnt=0;
        $GLOBALS['tabs'] = array();
		$rand = rand();
        $content=do_shortcode( $content );
        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_tabs', $key );
		$custom_class_name = 'tatsu-'.$atts['key'];
		
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' be-animate' : '';

		if( is_array( $GLOBALS['tabs'] ) ) {
			foreach( $GLOBALS['tabs'] as $tab ) {
				$tabs_cnt++;
				$icon_tag = ( ! empty($tab['icon']) && $tab['icon'] != 'none' ) ? '<i class="tab-icon '.$tab['icon'].'"></i>' : "" ;
				$tabs[] = '<li><a class="h6" id="'.$tab['class_name'].'" href="#fragment-'.$tabs_cnt.'-'.$rand.'">'.  $icon_tag . $tab['title'].'</a> '. $tab['custom_style_tag'] .' </li>';
				$panes[] = '<div id="fragment-'.$tabs_cnt.'-'.$rand.'" class="clearfix be-tab-content">'.$tab['content'].'</div>';
			}
			$return = ($panes || $tabs) ? "\n".'<div class="tatsu-tabs '.$animate.' tatsu-module tatsu-tabs-'. $style . ' ' . $custom_class_name .'"  data-animation="'. $animation_type .'" data-animation-delay="'.$animation_delay.'" ><div class="tatsu-tabs-inner '.$custom_class_name.' "><ul class="clearfix be-tab-header">'.implode( "\n", $tabs ).'</ul>'.implode( $panes ) .''. $custom_style_tag .'</div></div>'."\n" : '' ; 
		}
		return $return;
	}
}

if (!function_exists('tatsu_tab')) {
	function tatsu_tab( $atts, $content ){
		$atts = shortcode_atts( array(
	        'icon' => '',
	        'title' => '',
			'title_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_tab', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];

		extract( $atts );

		$content= do_shortcode($content);
		$x = $GLOBALS['tabs_cnt'];
		$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tabs_cnt'] ), 'content' =>  $content, 'icon'=> $icon, 'class_name' => $custom_class_name, 'custom_style_tag' => $custom_style_tag );
		$GLOBALS['tabs_cnt']++;
	}
}
?>