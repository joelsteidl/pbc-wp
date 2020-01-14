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
		$module_name = $module['name'];
		$remapped_modules = Tatsu_Module_Options::getInstance()->get_remapped_modules();
		if( is_array( $remapped_modules ) && array_key_exists( $module_name, $remapped_modules ) ) {
			$module_name = $remapped_modules[$module_name];
		}
		$new_content .= '['. $module_name;
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
		$new_content .= '[/'.$module_name.']';
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
    $admin_load = get_option( 'tatsu_admin_load', false );
    $post_type = get_post_type( $post_id );
    if( !empty( $admin_load ) ) {
        if( $post_type === 'tatsu_gsections' ){
            $tatsu_edit_url = add_query_arg( array( 'action' => 'tatsu-global', 'post' => $post_id ), admin_url( 'post.php' ) );
        }else if( TATSU_HEADER_CPT_NAME === $post_type ) {
            $tatsu_edit_url = add_query_arg( array( 'action' => 'tatsu-header', 'post' => $post_id  ), admin_url( 'post.php' ) );
        }else if( TATSU_FOOTER_CPT_NAME === $post_type ) {
            $tatsu_edit_url = add_query_arg( array( 'action' => 'tatsu-footer', 'post' => $post_id  ), admin_url( 'post.php' ) );
        }else {
            $tatsu_edit_url = add_query_arg( array( 'action' => 'tatsu', 'post' => $post_id  ), admin_url( 'post.php' ) );
        }
    }else {
        if( $post_type === 'tatsu_gsections' ){
            $tatsu_edit_url = add_query_arg( array( 'tatsu-global' => '1', 'id' => $post_id  ), get_permalink( $post_id ) );
        }else if( TATSU_HEADER_CPT_NAME === $post_type ) {
            $tatsu_edit_url = add_query_arg( array( 'tatsu-header' => '1', 'id' => $post_id  ), get_permalink( $post_id ) );
        }else if( TATSU_FOOTER_CPT_NAME === $post_type ) {
            $tatsu_edit_url = add_query_arg( array( 'tatsu-footer' => '1', 'id' => $post_id  ), get_permalink( $post_id ) );
        }else {
            $tatsu_edit_url = add_query_arg( array( 'tatsu' => '1', 'id' => $post_id  ), get_permalink( $post_id ) );
        }
    }
    if ( defined( 'NGG_PLUGIN_VERSION' ) ) {
        $tatsu_edit_url = add_query_arg( 'display_gallery_iframe', '', $tatsu_edit_url );
    }
    $tatsu_edit_url = tatsu_protocol_based_urls( $tatsu_edit_url );
    return esc_url_raw( $tatsu_edit_url );
}


if( !function_exists( 'tatsu_get_headers_list' ) ) {
    function tatsu_get_headers_list() {
        $headers = get_posts(array (
            'post_type' => TATSU_HEADER_CPT_NAME,
            'post_status' => 'publish',
            'numberposts' => -1
        ));
        $headers_list = array();
        foreach($headers as $header) {
            $headers_list[$header->post_name] = $header->post_title;
        }
        return $headers_list;
    }
}

if( !function_exists( 'tatsu_get_active_header_id' ) ) {
	function tatsu_get_active_header_id() {
        $active_header_name = get_option( 'tatsu_active_header', '' );
        $post_id = tatsu_get_page_id();
        $header_meta = get_post_meta( $post_id, '_tatsu_header_options' , true );
        if( !empty( $header_meta ) && !empty( $header_meta['tatsu_active_header_override'] ) && 'inherit' !== $header_meta['tatsu_active_header_override'] ) {
            $active_header_name = $header_meta['tatsu_active_header_override'];
        }
		if( empty( $active_header_name ) || 'none' === $active_header_name ) {
			return false;
		} 
		$headers = get_posts( array (
			'post_type'			=> TATSU_HEADER_CPT_NAME,
			'name'				=> $active_header_name
		) );
		if( !count( $headers ) ) {
			return false;
		}else {
			$active_header = $headers[0];
			$id = $active_header->ID; //to prevent any php errors
			return $id;
		}
	}
}

if( !function_exists( 'tatsu_get_id_from_atts' ) ) {
    function tatsu_get_id_from_atts( $atts ) {
        $id_attr = '';
        if( !empty( $atts['custom_id'] ) ) {
            $id_attr = sprintf( 'id = "%s"', $atts['custom_id'] );
        }
        return $id_attr;
    }
}

if( !function_exists( 'tatsu_get_visibility_classes_from_atts' ) ) {
    function tatsu_get_visibility_classes_from_atts( $atts ) {
        $visibility_classes = '';
        if( !empty( $atts['hide_in'] ) ) {
			$hide_in = explode(',', $atts['hide_in']);
			foreach ( $hide_in as $device ) {
				$visibility_classes .= ' tatsu-hide-'.$device;
            }
        }
        return $visibility_classes;
    }
}

if( !function_exists( 'tatsu_get_active_footer_id' ) ) {
	function tatsu_get_active_footer_id() {
		$active_footer_name = get_option( 'tatsu_active_footer', '' );
		if( empty( $active_footer_name ) || 'none' === $active_footer_name ) {
			return false;
		} 
		$footers = get_posts( array (
			'post_type'			=> TATSU_FOOTER_CPT_NAME,
			'name'				=> $active_footer_name
		) );
		if( !count( $footers ) ) {
			return false;
		}else {
			$active_footer = $footers[0];
			$id = $active_footer->ID; //to prevent any php errors
			return $id;
		}
	}
}


function tatsu_create_new_post_url( $post_type = 'page' ) {
	$new_post_url = add_query_arg( [
		'action' => 'tatsu_new_post',
		'post_type' => $post_type,
	], admin_url( 'edit.php' ) );
	return $new_post_url;
}

function tatsu_header_builder_url() {
    $active_header_id = tatsu_get_active_header_id();
    $admin_load = get_option( 'tatsu_admin_load', false );
	if( !empty( $active_header_id ) ) {
        if( !empty( $admin_load ) ) {
            $tatsu_header_builder_url = add_query_arg( array( 'action' => 'tatsu-header', 'post' => $active_header_id ), admin_url( 'post.php' ) );
        }else {
            $tatsu_header_builder_url = add_query_arg( array( 'tatsu-header' => '1' ), get_permalink($active_header_id) );
        }
        if ( defined( 'NGG_PLUGIN_VERSION' ) ) {
            $tatsu_header_builder_url = add_query_arg( 'display_gallery_iframe', '', $tatsu_header_builder_url );
        }
        $tatsu_header_builder_url = tatsu_protocol_based_urls( $tatsu_header_builder_url );
        return esc_url( $tatsu_header_builder_url );	
	}
	return tatsu_create_new_post_url( TATSU_HEADER_CPT_NAME );
}

function tatsu_footer_builder_url() {
    $active_footer_id = tatsu_get_active_footer_id();
    $admin_load = get_option( 'tatsu_admin_load', false );
	if( !empty( $active_footer_id ) ) {
        if( !empty( $admin_load ) ) {
            $tatsu_footer_builder_url = add_query_arg( array( 'action' => 'tatsu-footer', 'post' => $active_footer_id ), admin_url( 'post.php' ) );
        }else {
            $tatsu_footer_builder_url = add_query_arg( array( 'tatsu-footer' => '1' ), get_permalink($active_footer_id) );
        }
		if ( defined( 'NGG_PLUGIN_VERSION' ) ) {
			$tatsu_footer_builder_url = add_query_arg( 'display_gallery_iframe', '', $tatsu_footer_builder_url );
		}
		$tatsu_footer_builder_url = tatsu_protocol_based_urls( $tatsu_footer_builder_url );
		return esc_url( $tatsu_footer_builder_url );	
	}
	return tatsu_create_new_post_url( TATSU_FOOTER_CPT_NAME );
}

function tatsu_check_if_global() {
	global $post;
	if( is_object( $post ) ) {
		$post_type = $post->post_type;
		if( 'tatsu_gsections' === $post_type ) {
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

if( !function_exists( 'tatsu_global_section_add_penultimate_class' ) ) {
	function tatsu_global_section_add_penultimate_class( $classes = '' ) {
		return $classes .= ' tatsu-global-section tatsu-global-section-penultimate';
	}
}

if( !function_exists( 'tatsu_global_section_add_bottom_class' ) ) {
	function tatsu_global_section_add_bottom_class( $classes = '' ) {
		return $classes .= ' tatsu-global-section tatsu-global-section-bottom';
	}
}

if( !function_exists( 'tatsu_global_section_add_top_class' ) ) {
	function tatsu_global_section_add_top_class( $classes = '' ) {
		return $classes .= ' tatsu-global-section tatsu-global-section-top';
	}
}

function tatsu_header_print( $inner ) {
	$output = '';
	foreach( $inner as $module ) {
		if( !empty( $module['name'] ) && !empty( $module['id'] ) ) {
			$module_options = Tatsu_Header_Module_Options::getInstance()->get_module( $module['name'] );
			if( $module_options && function_exists( $module_options['output'] ) ) {
				$id = $module['id'];
				$atts = !empty( $module['atts'] ) ? $module['atts'] : array();
				$inner = !empty( $module['inner'] ) ? $module['inner'] : array();
				$output .= call_user_func( $module_options['output'], $id, $atts, $inner );
			}
		}	
	}
	return $output;
}

function tatsu_header_css_print( $inner ) {
	$output = '';
	$atts = array();
	foreach( $inner as $module ) {
		if( !empty( $module['atts'] ) && !empty( $module['name'] ) && !empty( $module['id'] ) ) {
			foreach( $module['atts'] as $att => $value ) {
				if( is_array( $value ) ) {
					$value = json_encode( $value );
				}
				$atts[$att] = $value;
			}
			$output .= be_generate_css_from_atts( $atts, $module['name'], $module['id'], 'header' );
		}
		if( !empty( $module['inner'] ) ) {
			$output .= tatsu_header_css_print( $module['inner'] );
		}
	}
	return $output;
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
	$left_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/left/*.svg' );
	$right_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/right/*.svg' );
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
	if( !empty( $left_shape_dividers ) ) {
		$divider_option[ 'left' ] = array( 'none' => 'None' );
		foreach( $left_shape_dividers as $left_shape_divider ) {
			$divider_name = basename( $left_shape_divider, '.svg' );
			$divider_value = format_option_key_to_value( $divider_name );
			$divider_option[ 'left' ][ $divider_name ] = ucwords( $divider_value );
		} 
	}
	if( !empty( $right_shape_dividers ) ) {
		$divider_option[ 'right' ] = array( 'none' => 'None' );
		foreach( $right_shape_dividers as $right_shape_divider ) {
			$divider_name = basename( $right_shape_divider, '.svg' );
			$divider_value = format_option_key_to_value( $divider_name );
			$divider_option[ 'right' ][ $divider_name ] = ucwords( $divider_value );
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

		$global_sections_posts = get_posts(array( 'post_type' => 'tatsu_gsections') );
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
		foreach( $post_types as $post_type_slug => $post_type_label ){
			$post_type_object = get_post_type_object( $post_type_slug );
			$items = array( 'single-'.$post_type_slug => 'Single ' . $post_type_label );
			if( $post_type_object->has_archive !== false || $post_type_slug === 'post' ){
				$items = array_merge( 
								$items, 
								array( 
									'archive-'.$post_type_slug => 'Archive ' . $post_type_label 
								) 
							);
			}
			$post_types[ $post_type_slug ] = array(
												'label' => $post_type_label,
												'items' => $items
											);
		}
		$post_types[ 'others' ] = array(
									'label' => 'Others',
									'items' => array(
										'404' => '404 Page',
										'search' => 'Search',
									)
								);

		$post_type_options = apply_filters( 'tatsu_global_section_post_types', $post_types );
		
		$global_section_data = get_option( 'tatsu_global_section_data', null );

		return array( 'global_section_list' => $global_section_array,
					  'global_section_data' => $global_section_data,
					  'all_post_types' => $post_type_options,
					);
	}
}

if( !function_exists( 'tatsu_admin_get_post_type' ) ) {
	function tatsu_admin_get_post_type() {
        global $post, $typenow, $current_screen;
        if ($post && $post->post_type) {
            return $post->post_type;
		}elseif ($typenow) {
            return $typenow;
		} elseif ($current_screen && $current_screen->post_type) {
            return $current_screen->post_type;
		} elseif (isset($_REQUEST['post_type'])) {
            return sanitize_key($_REQUEST['post_type']);
		}
        return null;
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
		unset( $custom_post_types[ 'tatsu_gsections' ] );
		$post_types = array_merge( $default_post_types, $custom_post_types );
		foreach( $post_types as $type => $value ){
			$post_types[ $type ] = tatsu_capitalize_post_name( $value );
		}
		return apply_filters( 'tatsu_supported_post_types', $post_types );
	}
}

if( !function_exists( 'tatsu_is_others_page_type' ) ){
	function tatsu_is_others_page_type(){
		$others_type_array = array(
			'search',
			'404'
		);
		$is_others_type = false;
		$page_type = '';
		foreach( $others_type_array as $type ){
			if( function_exists( 'is_'.$type ) ){
				if( call_user_func( 'is_'.$type ) ){
					$is_others_type = true;
					$page_type = $type;
				}
			}	
		}

		return array(
			$is_others_type,
			$page_type
		);

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
					'label' => esc_html__( 'Post Meta', 'tatsu' ),
					'visible' => array( 'post_type','=',$type ),
					'options' => $temp_options_array,
					'default' => key($temp_options_array),
					'tooltip' => '',
				),
				array(
					'att_name' => $type.'date',
					'type' => 'text',
					'label' => esc_html__( 'Date Format', 'tatsu' ),
					'visible' => array(
						'condition' => array(
							array( $type, '=','date' ),
							array( 'post_type','=',$type )
						),
						'relation'	=> 'and',
					),
					'default' => 'F j, Y',
					'tooltip' => '',
				),
			);
			$module_option_atts_items = array_merge( $module_option_atts_items,$temp_array ); 
		}
		return $module_option_atts_items;

	}
}

if( !function_exists( 'tatsu_escape_group_atts' ) ) {
	function tatsu_escape_group_atts( $group_atts ) {
		if( is_array( $group_atts ) ) {
			foreach( $group_atts as $index => $att_group_or_name ) {
				if( is_array( $att_group_or_name ) ) {
					foreach( $att_group_or_name as $att_group_key => $att_group_value ) {
						if( 'title' === $att_group_key ) {
							$group_atts[ $index ][ $att_group_key ] = esc_html( $att_group_or_name[ $att_group_key ] );
						}
						if( 'group' === $att_group_key ) {
							$group_atts[ $index ][ $att_group_key ] = tatsu_escape_group_atts( $att_group_or_name[ $att_group_key ] );
						}
					}
				}
			}
		}
		return $group_atts;
	}
}

if( !function_exists( 'tatsu_parse_module_options' ) ) {
	function tatsu_parse_module_options( $options ) {

		//Replace invalid icons
		if( array_key_exists( 'atts', $options ) && is_array( $options['atts'] ) ) {
			foreach( $options['atts'] as $index => $att ) {
				if( !empty($att) && is_array( $att ) && 'icon_picker' === $att['type'] ) {
					if( !empty( $att['default'] ) && !Tatsu_Icons::getInstance()->valid_icon( $att['default'] ) ) {
						$options['atts'][$index]['default'] = Tatsu_Icons::getInstance()->get_random_icon();
					}
				}
			}
		}

		//check presets
		if( array_key_exists( 'presets', $options ) && is_array( $options['presets'] ) ) {
			foreach( $options['presets'] as $preset_name => $preset_options ) {
				if( is_array( $preset_options ) && is_array( $preset_options['preset'] ) ) {
					foreach( $preset_options['preset'] as $att_name => $att_value ) {
						$att_type = '';
						if( array_key_exists( 'atts', $options ) && is_array( $options['atts'] ) ) {
							foreach( $options['atts'] as $index => $att ) {
								if( !empty($att) && is_array( $att ) && $att['att_name'] === $att_name ) {
									$att_type = $att['type'];
								}
							}
						}
						if( !empty( $att_type ) && 'icon_picker' === $att_type && !Tatsu_Icons::getInstance()->valid_icon( $att_value ) ) {
							$options['presets'][$preset_name]['preset'][$att_name] = Tatsu_Icons::getInstance()->get_random_icon();
						}
					}
				}
			}
		}

		//escape translatable string
		// if( array_key_exists( 'group_atts', $options ) && is_array( $options['group_atts'] ) ) {
		// 	$options[ 'group_atts' ] = tatsu_escape_group_atts( $options[ 'group_atts' ] );
		// }
		// if( array_key_exists( 'atts', $options ) && is_array( $options['atts'] ) ) {
		// 	foreach( $options[ 'atts' ] as $index => $att ) {
		// 		if( !empty( $att ) && is_array( $att ) && array_key_exists( 'label', $att ) ) {
		// 			$options['atts'][$index]['label'] = esc_html( $options['atts'][$index]['label'] );
		// 		}
		// 	}
        // }
        
        //parse group atts
        if( array_key_exists( 'group_atts', $options ) && is_array( $options['group_atts'] ) ) {
            tatsu_remove_empty_group_att_structures( $options['group_atts'] );
        }

		return $options;
		
	}
}

if( !function_exists( 'tatsu_register_global_section_meta' ) ){
    function tatsu_register_global_section_meta( $id, $args ){
        if( empty( $id ) || empty( $args ) || !is_array( $args ) ) {
            trigger_error( esc_html__( 'Incorrect Arguments to register a consent condition', 'be-gdpr' ), E_USER_NOTICE );
		}
		Tatsu_Global_Section_Meta::getInstance()->register_meta($id,$args);
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

if( !function_exists( 'tatsu_gsection_get_archive_title' ) ){
	function tatsu_gsection_get_archive_title( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} elseif ( is_year() ) {
			/* translators: Yearly archive title. 1: Year */
			$title = get_the_date( _x( 'Y', 'yearly archives date format' ) ) ;
		} elseif ( is_month() ) {
			/* translators: Monthly archive title. 1: Month name and year */
			$title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
		} elseif ( is_day() ) {
			/* translators: Daily archive title. 1: Date */
			$title =  get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
		}
		return $title;
	}
	add_filter( 'get_the_archive_title', 'tatsu_gsection_get_archive_title' );
}

if ( ! function_exists( 'tatsu_get_gallery_image_from_source' ) ){
	function tatsu_get_gallery_image_from_source($source, $images = false) {
		$media = $return = array();
		global $be_themes_data; 
		switch ($source['source']) {
			case 'instagram':
				$transient_var = 'transient_instagram_user_data_'.$source['account_name'].'_'.$source['count'];
				delete_transient( $transient_var );
				$transient_media = get_transient( $transient_var );
				if($transient_media && isset($transient_media) && !empty($transient_media)) {
					$media = unserialize($transient_media);
				} else {
					if ( get_theme_mod('instagram_token', false) ){
						$instagram_access_token = get_theme_mod('instagram_token', '');
						$instagram_media = wp_remote_get( 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$instagram_access_token.'&count='.$source['count'] );
						if(isset($instagram_media->error_message) || !empty($instagram_media->error_message)) {
							delete_transient( $transient_var );
							$return['error'] = '<b>'.esc_html__('Instagram Error : ', 'oshine-modules').'</b>'.$instagram_media->error_message;
							return $return;
						}
						if($instagram_media && isset($instagram_media) && !empty($instagram_media)) {
							set_transient( $transient_var , serialize($instagram_media), 60 * 60 * 24 * 2 );
							$media = $instagram_media;
						}
					}else{
						delete_transient( $transient_var );
						$return['error'] = '<div class="be-notification error">'.esc_html__('Instagram Error : Access Token is not entered under Cutomizer > GLOBAL SITE SETTINGS. Access Token for your account can be generated from http://instagram.pixelunion.net/', 'exponent-modules').'</div>';
						return $return;
					}					
				}

				if($media && isset($media) && !empty($media)) {
					$images = json_decode($media["body"]);
					$images = $images->data;
					foreach ($images as $key => $value) {
						$temp_image_array = array();
						$temp_image_array = array (
							'thumbnail' => $value->images->standard_resolution->url,
							'full_image_url' => $value->images->standard_resolution->url,
							'caption' => !empty($value->caption->text) ? $value->caption->text : '',
							'description' => !empty($value->caption->text) ? $value->caption->text : '',
							'width' => $value->images->standard_resolution->width,
							'height' => $value->images->standard_resolution->height,
							'id' => '',
							'has_video' => false,
							
						);
						array_push($return, $temp_image_array);
					}
				}
				return $return;
				break;
			case 'flickr':
				delete_transient( 'transient_flickr_user_data_'.$source['account_name'].'_'.$source['count'] );
				delete_transient( 'transient_flickr_user_data_'.$source['account_name'].'_'.$source['count'] );
				$transient_media = get_transient( 'transient_flickr_user_data_'.$source['account_name'].'_'.$source['count'] );
				if($transient_media && isset($transient_media) && !empty($transient_media)) {
					$media = unserialize($transient_media);
				} else {
					$user_data = wp_remote_get( 'https://api.flickr.com/services/rest/?method=flickr.people.findByUsername&username='.$source['account_name'].'&format=php_serial&api_key=85145f20ba1864d8ff559a3971a0a033' );
					$user_data = unserialize($user_data["body"]);
					if(isset($user_data['stat']) && $user_data['stat'] == 'ok') {
						if(isset($user_data["user"]["nsid"]) && !empty($user_data["user"]["nsid"]) && $user_data["user"]["nsid"]) {
							$flickr_media = wp_remote_get( 'https://api.flickr.com/services/rest/?method=flickr.photos.search&user_id='.$user_data["user"]["nsid"].'&format=php_serial&api_key=85145f20ba1864d8ff559a3971a0a033&per_page='.$source['count'].'&page=1&extras=url_z,url_o' );
							$flickr_media = unserialize($flickr_media["body"]);
							if(isset($flickr_media['stat']) && $flickr_media['stat'] == 'ok') {
								set_transient( 'transient_flickr_user_data_'.$source['account_name'].'_'.$source['count'], serialize($flickr_media), 60 * 60 * 1 );
								$media = $flickr_media;
							} else {
								$return['error'] = '<b>'.esc_html__('Flickr Error : ', 'oshine-modules').'</b>'.esc_html__("Unknown Error", "be-themes");
								return $return;
							}
						}
					} else {
						$return['error'] = '<b>'.esc_html__('Flickr Error : ', 'oshine-modules').'</b>'.$user_data["message"];
						return $return;
					}
				}
				if($media && isset($media) && !empty($media)) {
					$images = $media['photos']['photo'];
					foreach ($images as $key => $value) {
						$temp_image_array = array();
						$temp_image_array = array (
							'thumbnail' => (isset($value["url_z"]) && !empty($value["url_z"])) ? $value["url_z"] : $value["url_o"],
							'full_image_url' => (isset($value["url_z"]) && !empty($value["url_z"])) ? $value["url_z"] : $value["url_o"],
							'caption' => !empty($value["title"]) ? $value["title"] : '',
							'description' => !empty($value["title"]) ? $value["title"] : '',
							'width' => (isset($value["width_z"]) && !empty($value["width_z"])) ? $value["width_z"] : $value["width_o"],
							'height' => (isset($value["height_z"]) && !empty($value["height_z"])) ? $value["height_z"] : $value["height_o"],
							'id' => '',
							'has_video' => false
						);
						array_push($return, $temp_image_array);
					}
				}
				return $return;
			default:
				if($images) {
					$images = explode(",", $images);
					foreach ($images as $image) {
						$temp_image_array = array();
						$image_atts = be_get_gallery_image($image, $source['col'], $source['masonry']);
						$attachment_thumb = wp_get_attachment_image_src( $image, $image_atts['size']);
						$attachment_full = wp_get_attachment_image_src( $image, 'full');
						$attachment_thumb_url = $attachment_thumb[0];
						$attachment_full_url = $attachment_full[0];
						$video_url = get_post_meta( $image, 'be_themes_featured_video_url', true );
						//var_dump( $video_url );
						$attachment_info = be_wp_get_attachment($image);
						$has_video = false;
						if( (! empty( $video_url ))  ) {
							$attachment_full_url = $video_url;
							$has_video = true;
						}
						$temp_image_array = array (
							'thumbnail' => $attachment_thumb_url,
							'full_image_url' => $attachment_full_url,
							'caption' => $attachment_info['title'],
							'description' => $attachment_info['description'],
							'width' => $attachment_info['width'],
							'height' => $attachment_info['height'],
							'id' => $image,
							'thumb_width' => $attachment_thumb[ 1 ],
							'thumb_height' => $attachment_thumb[ 2 ],
							'has_video' => $has_video,
						);
						array_push($return, $temp_image_array);
					}
					return $return;
				}
				break;
		}
    }
}
if (!function_exists('be_get_gallery_image')) {
	function be_get_gallery_image($id, $column, $masonry) {
		$image = array();
		$width_wide = get_post_meta( $id, 'be_themes_width_wide', true );
		$height_wide = get_post_meta( $id, 'be_themes_height_wide', true );
		if($column == 'three' || $column == 'four' || $column == 'five') {
			if($masonry) {
				$image['size'] = 'gallery-masonry';
			} else {
				if($width_wide && $height_wide) {
					$image['size'] = '3col-gallery-wide-width-height';
				} else if($width_wide) {
					$image['size'] = '3col-gallery-wide-width';
				} else if($height_wide) {
					$image['size'] = '3col-gallery-wide-height';
				} else {
					$image['size'] = 'gallery';
				}
			}
		} elseif($column == 'two') {
			if($masonry) {
				$image['size'] = '2col-gallery-masonry';
			} else {
				$image['size'] = '2col-gallery';
			}
		} elseif($column == 'one') { 
			$image['size'] = 'full';
		} else {
			$image['size'] = 'gallery';
		}
		if($column != 'one'){
			if($width_wide) {
				$image['class'] = 'wide';
			} else {
				$image['class'] = 'not-wide';
			}
			if($width_wide && $height_wide) {
				$image['alt_class'] = 'wide-width-height';
			} else if($width_wide) {
				$image['alt_class'] = 'wide-width';
			} else if($height_wide) {
				$image['alt_class'] = 'wide-height';
			} else {
				$image['alt_class'] = 'no-wide-width-height';
			}
		}else{
			$image['class'] = 'not-wide';
			$image['alt_class'] = 'no-wide-width-height';
		}
		return $image;
	}
}

add_action('after_setup_theme', 'tatsu_crop_gallery_images');

if ( !function_exists( 'tatsu_crop_gallery_images' ) ) {
	function tatsu_crop_gallery_images(){
		if( function_exists( 'add_image_size' ) ){
		$aspect_ratio = false;
		$aspect_ratio = apply_filters('gallery_aspect_ratio', $aspect_ratio);
		
		$gallery_image_height = $aspect_ratio ? round(650 / floatval($aspect_ratio)) : 385;
		$gallery_2_col = $aspect_ratio ? round(1000 / floatval($aspect_ratio)) : 592;
		$gallery_3_col_wide_width_height_image_height = $aspect_ratio ? round(1250 / floatval($aspect_ratio)) : 766;
		$gallery_3_col_wide_width_image_height = $aspect_ratio ? round(1250 / floatval($aspect_ratio)) : 350;
		$gallery_3_col_wide_height_image_height = $aspect_ratio ? 2*round(650 / floatval($aspect_ratio)) : 770;
		// Gallery
		add_image_size( 'gallery', 650, $gallery_image_height, true );
		add_image_size( 'gallery-masonry', 650 );
		add_image_size( '2col-gallery', 1000, $gallery_2_col, true );
		add_image_size( '2col-gallery-masonry', 1000 );
		add_image_size( '3col-gallery-wide-width-height', 1250, $gallery_3_col_wide_width_height_image_height, true );
		add_image_size( '3col-gallery-wide-width', 1250, $gallery_3_col_wide_width_image_height, true );
		add_image_size( '3col-gallery-wide-height', 650, $gallery_3_col_wide_height_image_height, true );
		}
	}
}

if( !function_exists( 'get_colorhub_palette_color' ) ){
	function get_colorhub_palette_color( $palette_id ){
		if( function_exists( 'colorhub_get_palette' ) ){
			// return array(
			// 		"id" => "palette:".$palette_id,
			// 		"color" => colorhub_get_palette( $palette_id )
			// );
			return colorhub_get_palette( $palette_id );
		}
		return '#338ffa';
	}
}

if ( !function_exists( 'tatsu_header_get_menu_list' ) ){
	function tatsu_header_get_menu_list(){
		$menus = wp_get_nav_menus();
		$menu_details = array();
		$menu_index = 0;
		$default_menu = '';
		if(!empty($menus)){
			foreach($menus as $menu){
				$menu_details[ $menu->term_id ] = $menu->name ;
				if($menu_index == 0){
					$default_menu = $menu->term_id;
				}
				$menu_index++; 
			}
		}
		return array( $menu_details, $default_menu );
	}
}

if ( !function_exists( 'tatsu_get_transparent_header_list' ) ){
	function tatsu_get_transparent_header_list() {

		$single_post_list = array( 'page', 'post' );
		$archive_list = array( 'post' );

		if( post_type_exists( 'portfolio' ) ){
			array_push( $single_post_list , 'portfolio');
			array_push( $archive_list , 'portfolio');
		}
		if( post_type_exists( 'product' ) ){
			array_push( $archive_list , 'product');
		}

		$header_settings = array(

			'archive' => $archive_list,
			'single' => $single_post_list,
			'taxonomy' => array( 'category' ),
			'other' => array( 'author','search' )
			
		);

		return $header_settings;
	}
}

/**
 * Get page id
 */
if (!function_exists( 'tatsu_get_page_id' )) {
	function tatsu_get_page_id() {
		global $post;
		if( !is_object($post) ) {
	        return;
	    }			
		if( be_themes_is_woocommerce_activated() && function_exists('is_shop') && is_shop() ) {
			$post_id = get_option('woocommerce_shop_page_id');
		} else if(is_home()) {
			$post_id = get_option( 'page_for_posts' );
		} else if(is_search() || is_tag() || is_archive() || is_category()) {
			$post_id = 0;
		} else {
			$post_id = get_the_ID();
		} 
		return $post_id;
	}
}

if ( ! function_exists( 'tatsu_gdpr_options' ) ) {
    function tatsu_gdpr_options(){
        $options = array(
            'youtube' => array(
                'label' => "Youtube",
                'description' => esc_html__( "Consent to display content from YouTube.", 'tatsu' ),
                'required' => false
            ),
            'vimeo' => array(
                'label' => "Vimeo",
                'description' => esc_html__( "Consent to display content from Vimeo.", 'tatsu' ),
                'required' => false
            ), 
            'gmaps' => array(
                'label' => "Google Maps",
                'description' => esc_html__( "Consent to display content from Google Maps.", 'tatsu' ),
                'required' => false
            ),
        );
        foreach( $options as $option => $value ){
            be_gdpr_register_option($option,$value);
        }
	}
	add_action('be_gdpr_register_options','tatsu_gdpr_options');
}

if( !function_exists( 'tatsu_revision_data' ) ){
	function tatsu_revision_data( $post_id, $offset = 0 ) {

		if( !wp_revisions_enabled( get_post( $post_id ) ) ){
			return false;
		}

		$revisions = wp_get_post_revisions( $post_id, array('numberposts' => 21, 'offset' => $offset));

		if( empty( $revisions ) ){
			return false;
		}

		$revision_data = array();
		$author_data = array();
		$more_items = false;
		if( count( $revisions ) === 21 ){
			$more_items = true;
			array_pop( $revisions );
		}

		foreach ($revisions as $key => $value) {
			$modified = strtotime( $value->post_modified );
			$revision_data[] = array(
				'key' => $value->ID,
				'post_date' => human_time_diff(  strtotime(  $value->post_date_gmt ), current_time( 'timestamp', 1 ) ) . ' ago',
				'short_date' =>  date_i18n( _x( 'j M @ H:i', 'revision date short format' ), $modified ),
				'author' => $value->post_author
			);
			if( !array_key_exists( $value->post_author, $author_data ) ){
				$author_name = get_the_author_meta('display_name',  $value->post_author);
				$author_avatar = get_avatar_url( $value->post_author);
				$author_data[ $value->post_author] = array(
					$author_name,
					$author_avatar
				);
			}
		}
		return array(
			'revisions' => $revision_data,
			'authors' => $author_data,
			'more_items' => $more_items
		);
	}
}

if( !function_exists ('tatsu_get_blend_modes') ){
	function tatsu_get_blend_modes(){
		return array (
			'none' => 'None',
			'normal' => 'Normal',
			'multiply' => 'Multiply',
			'screen' => 'Screen',
			'overlay' => 'Overlay',
			'darken' => 'Darken',
			'lighten' => 'Lighten',
			'color_dodge' => 'Color Dodge',
			'color_burn' => 'Color Burn',
			'difference' => 'Difference',
			'exclusion' => 'Exclusion',
			'hue' => 'Hue',
			'saturation' => 'Saturation',
			'color' => 'Color',
			'luminosity' => 'Luminosity',
		);
	}
}

if( !function_exists( 'tatsu_check_if_att_present' ) ) {
	function tatsu_check_if_att_present( $att_name, $atts ) {
        if( !is_array( $atts ) ) {
            return false;
        }
        foreach( $atts as $att ) {
            if( $att['att_name'] === $att_name ) {
                return true;
            }
        }
        return false;
    }
}

//merge module's existing atts grouping with common atts grouping
if( !function_exists( 'tatsu_smart_merge_group_atts_recursive' ) ) {
    function tatsu_smart_merge_group_atts_recursive( &$merge_into, &$merge_from, $invert = false, $tag ) {
        foreach( $merge_from as &$att_or_att_group_in_merge_from ) {
            if( is_array( $att_or_att_group_in_merge_from ) ) {
                foreach( $att_or_att_group_in_merge_from['group'] as $merge_from_index => &$att_group_in_merge_from ) {
                    foreach( $merge_into as &$att_or_att_group_in_merge_into ) {
                        if( is_array( $att_or_att_group_in_merge_into ) && $att_or_att_group_in_merge_from['type'] === $att_or_att_group_in_merge_into['type'] ) {
                            foreach( $att_or_att_group_in_merge_into['group'] as $merge_into_index => &$att_group_in_merge_into ) {
                                if( is_array( $att_group_in_merge_into ) && $att_group_in_merge_into['title'] === $att_group_in_merge_from['title'] ) {
                                    if( $invert ) {
                                        tatsu_smart_merge_group_atts_recursive( $att_group_in_merge_from['group'], $att_group_in_merge_into['group'], false, $tag );
                                        unset( $att_or_att_group_in_merge_into['group'][$merge_into_index] );
                                        $att_or_att_group_in_merge_into['group'] = array_values( $att_or_att_group_in_merge_into['group'] );
                                    }else {
                                        tatsu_smart_merge_group_atts_recursive( $att_group_in_merge_into['group'], $att_group_in_merge_from['group'], false, $tag );
                                        unset( $att_or_att_group_in_merge_from['group'][$merge_from_index] );
                                        $att_or_att_group_in_merge_from['group'] = array_values( $att_or_att_group_in_merge_from['group'] );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if( $invert ) {
            $merge_into = array_merge( $merge_into, $merge_from );
        }else {
            $merge_into = array_merge( $merge_from, $merge_into );
        }
    }
}
if( !function_exists( 'tatsu_smart_merge_group_atts' ) ) {
    function tatsu_smart_merge_group_atts( &$group_atts_from_module_options, $group_atts_from_common_atts, $tag ) {
        if( !is_array( $group_atts_from_common_atts ) || !is_array( $group_atts_from_module_options ) ) {
            return;
        }
        if( is_array( $group_atts_from_common_atts ) && is_array( $group_atts_from_common_atts[0] ) && 'tabs' === $group_atts_from_common_atts[0]['type'] ) {
            $tabs_from_common_atts = $group_atts_from_common_atts[0];
            if( is_array( $group_atts_from_module_options ) && is_array( $group_atts_from_module_options[0] ) && 'tabs' === $group_atts_from_module_options[0]['type'] ) {
                $tabs_from_module_options = &$group_atts_from_module_options[0];
                foreach( $tabs_from_module_options['group'] as &$tab_from_module_options ) {
                    foreach( $tabs_from_common_atts['group'] as $tab_from_common_atts ) {
                        if( strtolower( $tab_from_module_options['title'] ) === strtolower( $tab_from_common_atts['title'] ) ) {
                            tatsu_smart_merge_group_atts_recursive( $tab_from_module_options['group'], $tab_from_common_atts['group'], true, $tag );
                            break;
                        }
                    }
                }
            }else {
                $atts_collection_from_common_atts_tabs = array();
                foreach( $tabs_from_common_atts['group'] as $tab_from_common_atts ) {
                    if( is_array( $tab_from_common_atts ) && !empty( $tab_from_common_atts['group'] ) ) {
                        $atts_collection_from_common_atts_tabs = array_merge( $atts_collection_from_common_atts_tabs, $tab_from_common_atts['group'] );
                    }
                }
                tatsu_smart_merge_group_atts_recursive( $group_atts_from_module_options, $atts_collection_from_common_atts_tabs, true, $tag );
            }
        }
        return $group_atts_from_module_options;
    }
}

//remove duplicate atts from atts grouping in common atts
if( !function_exists( 'tatsu_remove_duplicate_atts_from_group_atts' ) ) {
    function tatsu_remove_duplicate_atts_from_group_atts( &$group_atts_from_common_atts, $atts_from_module_options ) {
        if( is_array( $group_atts_from_common_atts ) ) {
            foreach( $group_atts_from_common_atts as $index => &$att_or_att_group ) {
                if( is_array( $att_or_att_group ) ) {
                    tatsu_remove_duplicate_atts_from_group_atts( $att_or_att_group[ 'group' ], $atts_from_module_options );
                }else if( tatsu_check_if_att_present( $att_or_att_group, $atts_from_module_options ) ) {
                    unset( $group_atts_from_common_atts[ $index ] );
                }
            }
            $group_atts_from_common_atts = array_values($group_atts_from_common_atts);
        }
    }
}

//remove excludes from atts grouping in common atts
if( !function_exists( 'tatsu_check_if_att_is_excluded' ) ) {
    function tatsu_check_if_att_is_excluded( $att, $common_att_config, $tag ) {
        $excludes_array = array();
        foreach( $common_att_config['atts'] as $cur_common_att ) {
            if( $cur_common_att['att_name'] === $att && array_key_exists( 'exclude', $cur_common_att ) && is_array( $cur_common_att['exclude'] ) ) {
                $excludes_array = $cur_common_att['exclude'];
                break;
            }
        }
        $global_excludes_array = !empty( $common_att_config['exclude'] ) && is_array( $common_att_config['exclude'] ) ? $common_att_config['exclude'] : array();
        if( in_array( $tag, $excludes_array ) || in_array( $tag, $global_excludes_array ) ) {
            return true;
        }else {
            return false;
        }
    }
}

//remove empty accordion/tabs from group atts
if( !function_exists( 'tatsu_remove_empty_group_att_structures' ) ) {
    function tatsu_remove_empty_group_att_structures( &$group_atts ) {
        if(is_array($group_atts)) {
            foreach( $group_atts as $index => &$att_or_att_group ) {
                if( is_array($att_or_att_group) ) {
                    tatsu_remove_empty_group_att_structures( $att_or_att_group['group'] );
                    if( empty( $att_or_att_group['group'] ) ) {
                        unset( $group_atts[$index] );
                    }
                }
            }
            $group_atts = array_values( $group_atts );    
        }
    }
}

if( !function_exists( 'tatsu_remove_excluded_atts_from_group_atts' ) ) {
    function tatsu_remove_excluded_atts_from_group_atts( &$group_atts_from_common_atts, $common_att_config, $tag ) {
        if( is_array( $group_atts_from_common_atts ) ) {
            foreach( $group_atts_from_common_atts as $index => &$att_or_att_group ) {
                if( is_array( $att_or_att_group ) ) {
                    tatsu_remove_excluded_atts_from_group_atts( $att_or_att_group['group'], $common_att_config, $tag );
                }else if( tatsu_check_if_att_is_excluded( $att_or_att_group, $common_att_config, $tag ) ) {
                    unset( $group_atts_from_common_atts[$index] );
                }
            }
            $group_atts_from_common_atts = array_values( $group_atts_from_common_atts );
        }
    }
}

if( !function_exists( 'tatsu_is_valid_edit_action' ) ) {
    function tatsu_is_valid_edit_action( $action = 'tatsu' ) {
        $admin_load = get_option( 'tatsu_admin_load', false );
        if( !empty( $admin_load ) ) {
            switch( $action ) {
                case 'tatsu' :
                    return isset( $_REQUEST['action'] ) && 'tatsu' === $_REQUEST['action'];
                case 'tatsu-header' : 
                    return isset( $_REQUEST['action'] ) && 'tatsu-header' === $_REQUEST['action'];
                case 'tatsu-footer' :
                    return isset( $_REQUEST['action'] ) && 'tatsu-footer' === $_REQUEST['action'];
                case 'tatsu-global' : 
                    return isset( $_REQUEST['action'] ) && 'tatsu-global' === $_REQUEST['action'];
                default : 
                    return false;
            }
        }else {
            if( is_admin() ) {
                return false;
            }
            switch( $action ) {
                case 'tatsu' :
                    return isset( $_GET['tatsu'] );
                case 'tatsu-header' : 
                    return isset( $_GET['tatsu-header'] );
                case 'tatsu-footer' :
                    return isset( $_GET['tatsu-footer'] );
                case 'tatsu-global' : 
                    return isset( $_GET['tatsu-global'] );
                default : 
                    return false;
            }
        }
    }
}

if( !function_exists( 'tatsu_is_user_blacklisted' ) ) {
    function tatsu_is_user_blacklisted() {
        if( !is_user_logged_in() ) {
            return true;
        }
        $user = wp_get_current_user();
        $included_roles = get_option( 'tatsu_provide_access', '' );
        $included_roles = explode( ',', $included_roles );
        $included_roles[] = 'administrator';
		$result = array_intersect( $user->roles, $included_roles );
		if ( empty( $result ) ) {
			return true;
		}
		return false;
    }
}

if( !function_exists( 'tatsu_is_post_editable_by_current_user' ) ) {
    function tatsu_is_post_editable_by_current_user( $post_id ) {
        if( empty( $post_id ) ) {
            return false;
        }
        $post = get_post( $post_id );
        if ( ! $post ) {
			return false;
		}

		if ( 'trash' === get_post_status( $post_id ) ) {
			return false;
        }
        
        $post_type_object = get_post_type_object( $post->post_type );

		if ( ! isset( $post_type_object->cap->edit_post ) ) {
			return false;
		}
		$edit_cap = $post_type_object->cap->edit_post;
		if ( ! current_user_can( $edit_cap, $post_id ) ) {
			return false;
        }
        
        if( tatsu_is_user_blacklisted() ) {
            return false;
        }

        return true;
    }
}

if( !function_exists( 'tatsu_is_post_type_editable_by_current_user' ) ) {
    function tatsu_is_post_type_editable_by_current_user( $post_type ) {
        if( empty( $post_type ) ) {
            return false;
        }
        
        $post_type_object = get_post_type_object( $post_type );
		if ( ! isset( $post_type_object->cap->edit_posts ) ) {
			return false;
		}
		if ( ! current_user_can( $post_type_object->cap->edit_posts ) ) {
			return false;
        }
        
        if( tatsu_is_user_blacklisted() ) {
            return false;
        }

        return true;
    }
}

if( !function_exists( 'tatsu_parse_group_atts' ) ) {
    function tatsu_parse_group_atts( &$group_atts, $atts ) {
        if( is_array( $group_atts ) ) {
            foreach( $group_atts as $index => &$att_or_att_group ) {
                if( is_array( $att_or_att_group ) ) {
                    tatsu_parse_group_atts( $att_or_att_group[ 'group' ], $atts );
                }else if( !tatsu_check_if_att_present( $att_or_att_group, $atts ) ) {
                    unset( $group_atts[ $index ] );
                }
            }
        }
    }
}

if( !function_exists( 'tatsu_update_custom_css_js' ) ) {
    function tatsu_update_custom_css_js( $post_id, $css, $js ) {
        if( !empty( $post_id ) ) {
            update_post_meta( $post_id, 'tatsu_custom_css', $css );
            update_post_meta( $post_id, 'tatsu_custom_js', $js );
        }
    }
}

if( !function_exists( 'tatsu_print_custom_css' ) ) {
    function tatsu_print_custom_css( $css_array ) {
        foreach( $css_array as $id => $css ) {
            if( !empty( $css ) ) : ?>
                <style id = "<?php echo $id; ?>">
                    <?php echo $css; ?>
                </style>
            <?php endif;
        }
    }
}

if( !function_exists( 'tatsu_print_custom_js' ) ) {
    function tatsu_print_custom_js( $js_array ) {
        foreach( $js_array as $id => $js ) {
            if( !empty( $js ) ) : ?>
                <script id = "<?php echo $id; ?>">
                    <?php echo $js; ?>
                </script>
            <?php endif;
        }
    }
}

?>