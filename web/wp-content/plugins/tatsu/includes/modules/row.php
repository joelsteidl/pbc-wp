<?php

if (!function_exists('tatsu_row')) {
	function tatsu_row( $atts, $content, $tag = '' ) {
		$atts = shortcode_atts( array(
	        'full_width'=>0,
	        'no_margin_bottom'=>0,
	        'equal_height_columns'=>0,
	        'gutter'=> 'medium',
	        'column_spacing'=> '25px',
	        'row_id' => '',
	        'row_class' => '',
			'fullscreen_cols' => 0,
			'swap_cols'	=> 0,		
	        'hide_in' => '',
			'layout' => '1/1',
			//'max_width' => '',
			'box_shadow' => '',
			'border_radius' => '',
			'padding' => '',
			'custom_margin' => '',
			'margin' => '',
			'bg_color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );
		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_row', $key );
		$unique_class_name = 'tatsu-'.$key;
	    $row_wrap_flag = 0;
	    $class = '';
	    $row_style = '';

		//if(isset( $column_spacing ) && isset( $no_space_columns ) && $column_spacing != '' && $column_spacing != 0 ){
			//$row_wrapper_start = '';
			//$row_wrapper_end = '</div>';
		//}
		$row_layout = !empty( $layout ) ? preg_replace( '/\s+/', '', $layout ) : '';
		if( 'tatsu_row' == $tag ) {
			if( empty( $full_width ) ){
				$class .= ' tatsu-wrap';
			} else {
				$class .= ' tatsu-row-full-width';
			}
		}


		$columns = explode( '+', $layout );

		if( is_array( $columns ) && in_array( '1/1', $columns ) ) {
			$class .= ' tatsu-row-one-col';
		} elseif ( is_array( $columns ) && in_array( '1/2', $columns ) ) {
			$class .= ' tatsu-row-has-one-half';
		} 

		$no_of_cols = count( $columns );
		$cols_in_words = array( '0' => 'zero', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine' ) ;
		$no_of_cols = $cols_in_words[$no_of_cols];
		
		$class .= ' tatsu-row-has-'.$no_of_cols.'-cols';

		if( 'custom' === $gutter ) {
			$column_spacing =  !empty( $column_spacing ) ? intval( $column_spacing ) : 0;
			$column_spacing = intval( $column_spacing / 2 );
			if( !empty( $full_width ) ) {
				$row_style = 'style="margin-left:'.$column_spacing.'px;margin-right:'.$column_spacing.'px;"';
			} else {
				$row_style = 'style="margin-left:-'.$column_spacing.'px;margin-right:-'.$column_spacing.'px;"';
			}
		}

	    $class .= ( isset( $no_margin_bottom ) &&  1 == $no_margin_bottom ) ? ' tatsu-zero-margin' : '' ;
	    $class .= ( isset( $gutter ) ) ? ' tatsu-'.$gutter.'-gutter' : ' tatsu-medium-gutter' ;
	    $class .= ( isset( $equal_height_columns ) &&  1 == $equal_height_columns ) ? ' tatsu-eq-cols' : ' tatsu-reg-cols' ;
		$class .= ( isset( $fullscreen_cols ) && 1 == $fullscreen_cols && 'tatsu_row' == $tag ) ? ' tatsu-fullscreen-cols' : '';
		$class .= ( 'tatsu_inner_row' == $tag ) ? ' tatsu-inner-row-wrap' : ''; 
		if( !empty( $swap_cols ) ) {
			$exploded_layout = explode( '+', $row_layout );
			$layout_size = count( $exploded_layout );
			if( 2 == $layout_size ) {
				$class .= ' tatsu-swap-cols';
			}
		}
		
		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$class .= ' tatsu-hide-'.$device;
			}
		}	    
		
		$row_id = !empty($row_id) ? 'id = "'.$row_id.'"' : '';
		$row_class = !empty($row_class) ? str_replace(',', ' ', $row_class) : '' ;
		
		$output = '<div class="tatsu-row-wrap '.$class.' tatsu-clearfix '.$unique_class_name.'">';
		$output .= $custom_style_tag;
		$output .= '<div '.$row_id.' class="tatsu-row '.$row_class.'" '.$row_style.'>';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		$output .= '</div>';
		

		return $output;
	}
	add_shortcode( 'row','tatsu_row' );
	add_shortcode( 'tatsu_row','tatsu_row' );
	add_shortcode( 'tatsu_row1','tatsu_row' );
	add_shortcode( 'tatsu_inner_row', 'tatsu_row' );
}

if( !function_exists( 'tatsu_row_margin_top_callback' ) ) {
	function tatsu_row_margin_top_callback( $margin ){
		
		$value_array = explode( ' ', $margin );
		return $value_array[0];
	}
}
if( !function_exists( 'tatsu_row_margin_bottom_callback' ) ) {
	function tatsu_row_margin_bottom_callback( $margin ){
		
		$value_array = explode( ' ', $margin );
		if( isset( $value_array[1] ) ) {
			return $value_array[1];
		} else {
			return $value_array[0];
		}
	}
}

?>