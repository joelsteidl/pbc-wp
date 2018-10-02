<?php

function tatsu_register_module( $tag, $options ) {
	// if( 'tatsu_gsection_title' == $tag ) {
	// }
	if( !shortcode_exists( $tag ) || !is_array( $options ) ) {
		trigger_error( "Either the Tag $tag is not a registered shortcode or options is not an array", E_USER_NOTICE );
	}
	if( tatsu_validate_module_options( $options ) ) {
		Tatsu_Module_Options::getInstance()->register_module( $tag, $options );
	}
}

function tatsu_deregister_module( $tag ) {
	$core_modules = Tatsu_Config::getInstance()->get_core_modules();
	if( array_key_exists( $tag, $core_modules ) ) {
		trigger_error( __( 'You cannot deregister core modules such as Section, Row or Columns', 'tatsu' ), E_USER_NOTICE );
	}
	Tatsu_Module_Options::getInstance()->deregister_module( $tag );
}

function tatsu_register_icon_kit( $kit, $title, $icons, $stylesheet_url ) {
	if( empty($kit) || !is_array( $icons ) || !( !filter_var( $stylesheet_url, FILTER_VALIDATE_URL ) === false ) ) {
		trigger_error( __( 'Unable to register icon kit, either the kit name is missing or the icons array and stylesheet url are not in the correct format', 'tatsu' ), E_USER_NOTICE );
	}
	Tatsu_Icons::getInstance()->register_icons( $kit, $title, $icons, $stylesheet_url ); 
}

function tatsu_deregister_icon_kit( $kit ) {
	Tatsu_Icons::getInstance()->deregister_icons( $kit );
}

function tatsu_register_section_concept( $name, $options ) {
	if( !is_array( $options ) || !array_key_exists( 'shortcode', $options ) ) {
		trigger_error( __( 'You cannot register a Section Concept without entering its shortcode content', 'tatsu' ), E_USER_NOTICE );
	}
	Tatsu_Section_Concepts::getInstance()->register_concept( $name, $options );
}

function tatsu_deregister_section_concept( $name ) {
	Tatsu_Section_Concepts::getInstance()->deregister_concept( $name );
}

function tatsu_css_animations() {
	return Tatsu_Config::getInstance()->get_css_animations();
}

function tatsu_register_template( $args ) {
	if( !is_array( $args ) ) {
		trigger_error( __( 'Arguments for registering a template should be an array', 'tatsu' ), E_USER_NOTICE );
	}
	Tatsu_Page_Templates::getInstance()->register_template( $args );
}

function tatsu_register_color( $slug, $title, $color ) {
	if( empty( $slug ) || empty( $color ) || !tatsu_validate_color( $color ) ) {
		return false;
		trigger_error( __( 'Unable to register the color, either the slug is missing or the color is not in a valid hex or rgb or rgba format', 'tatsu' ), E_USER_NOTICE );
	}
	Tatsu_Colors::getInstance()->register_color( $slug, $title, $color );
}

function tatsu_deregister_color( $slug ) {
	Tatsu_Colors::getInstance()->deregister_icons( $slug );
}


function tatsu_register_color_picker_default( $colors ) {
	if( !is_array( $colors ) ) {
		return false;
	}
	foreach ( $colors as $color ) {
		if( !tatsu_validate_color( $color ) ) {
			trigger_error( 'Unable to register the color as color is not in a valid hex or rgb or rgba format', E_USER_NOTICE );
			return false;
		}		
	}
	Tatsu_Colors::getInstance()->register_color_picker_defaults( $colors );
}

function tatsu_deregister_color_picker_default( $colors ) {
	if( !is_array( $colors ) ) {
		return false;
	}
	foreach ( $colors as $color ) {
		if( !tatsu_validate_color( $color ) ) {
			trigger_error( 'Unable to register the color as color is not in a valid hex or rgb or rgba format', E_USER_NOTICE );
			return false;
		}		
	}
	Tatsu_Colors::getInstance()->deregister_color_picker_defaults( $colors );
}



function tatsu_get_color( $color, $default = '' ) {

	if( empty( $color ) ) {
		return $default;
	}

	$tatsu_global_colors = Tatsu_Colors::getInstance()->get_colors();

	if( tatsu_validate_color( $color ) ) {
		return $color;
	} elseif( !empty( $tatsu_global_colors[$color] ) ) {
		$color = $tatsu_global_colors[$color]['value'];
		if( tatsu_validate_color( $color ) ) {
			return $color;
		} else {
			return $default;
		}
	}

	return $default;
}

function is_edited_with_tatsu( $post_id ) {
	$edited_with = get_post_meta( $post_id, '_edited_with', true );
	if( 'tatsu' !== $edited_with && !isset( $_GET['tatsu-frame'] ) ) {
		return false;
	} else {
		return true;
	}
}


function tatsu_validate_module_options( $options ) {
	return true;
	if( !is_array( $options ) || empty( $options ) || !array_key_exists( 'type', $options ) || empty( $options['type'] ) || ( 'core' === $options['type'] ) ) {
		return false;
	}
	if( !( 'single' === $options['type'] || 'multi' === $options['type'] || 'submodule' === $options['type'] ) ) {
		return false;
	}
	if( !array_key_exists( 'atts', $options ) || !is_array( $options['atts'] ) ) {
		return false;
	}

}

function tatsu_register_svg( $kit, $title, $icons, $abspath ) {
	if( empty($kit) || !is_array( $icons ) || !( !filter_var( $abspath, FILTER_VALIDATE_URL ) === false ) ) {
		trigger_error( __( 'Unable to register svgs, either the kit name is missing or the icons array is not in the correct format', 'tatsu' ), E_USER_NOTICE );
	}
	Tatsu_Svgs::getInstance()->register_svgs( $kit, $title, $icons, $abspath ); 
}

function tatsu_deregister_svg( $kit ) {
	Tatsu_Svgs::getInstance()->deregister_svgs( $kit );
}

?>