<?php

function tatsu_add_shortcode_content( $inner ) {
	  $new_content = array();
	  if( !is_array( $inner ) ) {
	  	return $new_content;
	  }
	  foreach ( $inner as $module ) {
	  	$type = Tatsu_Module_Options::getInstance()->get_module_type( $module['name'] );
	    if( $type == 'single' || $type == 'multi'  ) {
    		$tatsu_module = new Tatsu_Module( $module['name'], $module['atts'], $module['atts']['content'] );
	    	$module['shortcode_output'] = $tatsu_module->do_shortcode();
	    }
	    if( array_key_exists('inner', $module) && is_array( $module['inner'] ) ) {
	      $new_inner = tatsu_add_shortcode_content( $module['inner'] );
	      $module['inner'] = $new_inner;
	    }
	    array_push( $new_content, $module );
	  }
	  return $new_content;
}


function tatsu_shortcodes_from_content( $inner ) {
	$new_content = '';	
	if( !is_array( $inner ) ) {
		return $new_content;
	}
	foreach ( $inner as $module ) {
		$new_content .= '['.$module['name'];
		if( is_array( $module['atts'] ) ) {
			if( !array_key_exists( 'key', $module['atts'] ) || empty( $module['atts']['key'] )  ) {
				$module['atts']['key'] = be_uniqid_base36(true);
			}
			foreach ($module['atts'] as $att => $value) {
				if( 'content' !== $att ) {
					if( is_array( $value ) ) {
						$new_content .= " ".$att."= '".json_encode($value)."'";
					} else {
						$new_content .= ' '.$att.'= "'.$value.'"';
					}
				}
			}
		}
		$new_content .= ']';
		if( array_key_exists('inner', $module) && is_array( $module['inner'] ) && !empty( $module['inner'] ) ) {
			$new_content .= tatsu_shortcodes_from_content( $module['inner'] );
		} else {
			if( array_key_exists('content', $module['atts']) ) {
				$new_content .=	shortcode_unautop( stripslashes_deep( $module['atts']['content'] ) );
			}
		}
		$new_content .= '[/'.$module["name"].']';
	}
	return $new_content;		
}


function tatsu_validate_color( $color ) {
	if( is_array( $color ) && array_key_exists( 'colorPositions', $color ) ) {
		$validate_color_positions = array_map( 'tatsu_validate_color', $color['colorPositions'] );
		if( in_array( false, $validate_color_positions ) ) {
			return false;
		} else {
			return true;
		}
	} else if( preg_match( '/^(#(?:[A-Fa-f0-9]{3}){1,2}|(rgb[(](?:\s*0*(?:\d\d?(?:\.\d+)?(?:\s*%)?|\.\d+\s*%|100(?:\.0*)?\s*%|(?:1\d\d|2[0-4]\d|25[0-5])(?:\.\d+)?)\s*(?:,(?![)])|(?=[)]))){3}[)])|(rgba[(](?:\s*0*(?:\d\d?(?:\.\d+)?(?:\s*%)?|\.\d+\s*%|100(?:\.0*)?\s*%|(?:1\d\d|2[0-4]\d|25[0-5])(?:\.\d+)?)\s*,){3}\s*0*(?:\.\d+|1(?:\.0*)?)\s*[)]))$/i', $color ) ) {
		return true;
	} 
	return false;
}


// function tatsu_edit_url( $post_id ) {
// 	return esc_url( add_query_arg( array( 'tatsu' => '1', 'id' => $post_id  ), get_permalink( $post_id ) ) );
// }

function tatsu_edit_url( $post_id ) {
	$tatsu_edit_url = add_query_arg( array( 'tatsu' => '1', 'id' => $post_id  ), get_permalink( $post_id ) );
	if ( defined( 'NGG_PLUGIN_VERSION' ) ) {
		$tatsu_edit_url = add_query_arg( 'display_gallery_iframe', '', $tatsu_edit_url );
	}
	$post_type = get_post_type( $post_id );
	if( $post_type === 'global_sections' ){
		$tatsu_edit_url = add_query_arg( array( 'tatsu-global' => '1', ), $tatsu_edit_url );
	}
	$tatsu_edit_url = tatsu_protocol_based_urls( $tatsu_edit_url );
	return esc_url( $tatsu_edit_url );
}

function tatsu_check_if_global() {
	if( array_key_exists( 'post_id', $_POST ) ) {
		$post_type = get_post_type( $_POST[ 'post_id' ] );
		if( 'global_sections' === $post_type ) {
			return true;
		}
	}
	return false;
}


// function tatsu_get_image_from_url( $image_url, $size = 'full' ) {
// 	global $wpdb;
// 	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts  WHERE guid = '%s';", $image_url ) );
// 	if( !empty( $attachment[0] ) ) {
// 		$image_thumb = wp_get_attachment_image_src( $attachment[0], $size );
// 		if( $image_thumb ) {
// 			return $image_thumb[0];
// 		} else {
// 			return $image_url;
// 		}
// 	} else {
// 		return $image_url;
// 	}
// }

function tatsu_get_image_id_from_url( $attachment_url = '', $size = 'full' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url ) {
		return;
	}
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		//$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

function tatsu_protocol_based_urls( $url ) {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
	return $protocol. str_replace( array( 'http:', 'https:' ), '', $url );
}

if( !function_exists( 'be_uniqid_base36' ) ) {
	function be_uniqid_base36($more_entropy=false) {
		$s = uniqid('', $more_entropy);
		if (!$more_entropy)
			return base_convert($s, 16, 36);
			
		$hex = substr($s, 0, 13);
		$dec = $s[13] . substr($s, 15); // skip the dot
		return base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
	}
}

function format_option_key_to_value( $key ) {
	if( false !== strpos( $key, '-' ) ) {
		$words_array = explode( '-', $key );
		$key = implode( ' ', $words_array );
	}
	if( false !== strpos( $key, '_' ) ) {
		$words_array = explode( '_', $key );
		$key = implode( ' ', $words_array );
	}
	return $key;
}

function tatsu_get_shape_dividers() {
	$top_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/top/*.svg' );
	$bottom_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/bottom/*.svg' );
	$divider_option = array();
	if( !empty( $top_shape_dividers ) ) {
		$divider_option[ 'top' ] = array( 'none' => 'None' );
		foreach( $top_shape_dividers as $top_shape_divider ) {
			$divider_name = basename( $top_shape_divider, '.svg' );
			$divider_value = format_option_key_to_value( $divider_name );
			$divider_option[ 'top' ][ $divider_name ] = ucwords( $divider_value );
		} 
	}
	if( !empty( $bottom_shape_dividers ) ) {
		$divider_option[ 'bottom' ] = array( 'none' => 'None' );
		foreach( $bottom_shape_dividers as $bottom_shape_divider ) {
			$divider_name = basename( $bottom_shape_divider, '.svg' );
			$divider_value = format_option_key_to_value( $divider_name );
			$divider_option[ 'bottom' ][ $divider_name ] = ucwords( $divider_value );
		} 
	}
	return !empty( $divider_option ) ? $divider_option : false;
}

function tatsu_get_slider_icons() {
	$slider_icons_path = glob( TATSU_PLUGIN_DIR . 'includes/icons/slider/*.svg' );
	$slider_icons = array();
	if( !empty( $slider_icons_path ) ) {
		foreach( $slider_icons_path as $slider_icon_path ) {
			$slider_icon_html = file_get_contents( $slider_icon_path );
			if( false !== $slider_icon_html ) {
				$slider_icon_name = basename( $slider_icon_path, '.svg' );
				$slider_icons[ $slider_icon_name ] = $slider_icon_html;
			}
		}
	}
	return $slider_icons;
}

if( !function_exists( 'tatsu_get_global_sections' ) ) {
	function tatsu_get_global_sections() {
		$global_section_array = array();

		$global_sections_posts = get_posts(array( 'post_type' => 'global_sections') );
		if( $global_sections_posts ) {
			foreach( $global_sections_posts as $section ) {
				$global_section_array[ (string) $section->ID ] =  $section->post_title;
			}
			wp_reset_postdata();
		}

		return $global_section_array;
	}
}

if( !function_exists('tatsu_capitalize_post_name') ) {
	function tatsu_capitalize_post_name( $post_name ) {
		$post_name_array = explode( '_',$post_name );
		$capd_name = '';
		foreach( $post_name_array as $name ) {
			$capd_name .= ucfirst( $name ) . " ";
		}
		return trim($capd_name);
	}
}

if( !function_exists( 'tatsu_get_global_sections_localize_data' ) ) {

	function tatsu_get_global_sections_localize_data() {

		$global_section_array = tatsu_get_global_sections();

		$post_types = tatsu_get_custom_post_types();

		$post_type_options = apply_filters( 'tatsu_global_section_post_types', $post_types );
		
		$global_section_data = get_option( 'tatsu_global_section_data', null );

		return array( 'global_section_list' => $global_section_array,
					  'global_section_data' => $global_section_data,
					  'all_post_types' => $post_type_options,
					);
	}
}

if( !function_exists( 'tatsu_get_custom_post_types' ) ) {
	function tatsu_get_custom_post_types() {
		$post_types = array();

		$args = array (
			'public' => true,
			'_builtin' => false
		);
		$default_post_types=  array (
			'page'		=> 'page',
			'post'		=> 'post'
		);
		$custom_post_types = get_post_types( $args, 'names', 'and' );
		unset( $custom_post_types[ 'global_sections' ] );
		$post_types = array_merge( $default_post_types, $custom_post_types );
		foreach( $post_types as $type => $value ){
			$post_types[ $type ] = tatsu_capitalize_post_name( $value );
		}
		return $post_types;
	}
}

if ( !function_exists( 'tatsu_global_section_meta_values' ) ) {
	function tatsu_global_section_meta_values() {

		$module_option_atts_items = array();

		
		$metas_from_all_types = Tatsu_Global_Section_Meta::getInstance()-> get_metas();
	

		foreach ( $metas_from_all_types as $type => $value ) {
			$temp_options_array = array();
			foreach( $value as $meta_key => $meta_value ) {
				$temp_options_array[ $meta_key ] =  $meta_value;
			}

			$temp_array = array(
				array(
					'att_name' => $type,
					'type' => 'select',
					'label' => __( 'Post Meta', 'tatsu' ),
					'visible' => array( 'post_type','=',$type ),
					'options' => $temp_options_array,
					'default' => key($temp_options_array),
					'tooltip' => '',
				),
				array(
					'att_name' => $type.'date',
					'type' => 'text',
					'label' => __( 'Date Format', 'tatsu' ),
					'visible' => array( $type,'=','date' ),
					'default' => 'F j, Y',
					'tooltip' => '',
				),
			);
			$module_option_atts_items = array_merge( $module_option_atts_items,$temp_array ); 
		}
		return $module_option_atts_items;

	}
}

if( !function_exists( 'tatsu_register_global_section_meta' ) ){
    function tatsu_register_global_section_meta( $id, $args ){
        if( empty( $id ) || empty( $args ) || !is_array( $args ) ) {
            trigger_error( __( 'Incorrect Arguments to register a consent condition', 'be-gdpr' ), E_USER_NOTICE );
		}
		if( get_theme_support('tatsu_global_sections') ){
			Tatsu_Global_Section_Meta::getInstance()->register_meta($id,$args);
		}
    }
}

if ( !function_exists( 'tatsu_get_sidebar_list' ) ) {
	function tatsu_get_sidebar_list(){

		$temp_sidebar_list = array();
		foreach (  $GLOBALS['wp_registered_sidebars'] as $sidebar ){

			$temp_sidebar_list[ $sidebar['id'] ] = $sidebar['name'];

		}
		return $temp_sidebar_list;

	}
}

?>