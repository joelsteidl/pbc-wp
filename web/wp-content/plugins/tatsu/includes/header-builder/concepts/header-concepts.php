<?php

add_action( 'tatsu_register_header_concepts', 'tatsu_register_header_concepts' );
function tatsu_register_header_concepts() {

	tatsu_register_header_concept( 'agency-intro', array(
			'title' => 'Style 1',
			'img' => TATSU_PLUGIN_URL.'/includes/header-builder/concepts/img/tatsu_header_concepts_1.png',
			'is_built_in' => true,
			'width' => '520',
			'height' => '258',
			'shortcode' => "[tatsu_header_row full_width = \"\" bg_color = \"rgba(255,255,255,0.34)\" default_visibility = \"visible\" sticky_visibility = \"hidden\" padding = \'{\"d\":\"30px 0px 30px 0px\"}\' sticky_padding = \"30\" border = \"0px 0px 0px 0px\" border_color = \"\" row_title = \"\" hide_in = \"0\" id = \"\" class = \"\" layout = \"1/2+1/2\" ][tatsu_header_column column_width = \'{\"d\":19}\' horizontal_alignment = \"flex-start\" vertical_alignment = \"center\" padding = \"0px 0px 0px 0px\" sidebar_vertical_alignment = \"center\" sidebar_horizontal_alignment = \"flex-start\" hide_in = \"0\" id = \"\" class = \"\" layout = \"1/2\" ][tatsu_header_logo height = \'{\"d\":\"34\"}\' sticky_height = \'{\"d\":\"30\"}\' default = \"http://localhost:8888/exponent/wp-content/uploads/2018/09/oshine-new-logo-1-2.png\" dark = \"http://localhost:8888/exponent/wp-content/plugins/tatsu/img/exponent-dark-logo.svg\" light = \"http://localhost:8888/exponent/wp-content/plugins/tatsu/img/oshine-light-logo.png\" margin = \'{\"d\":\"0px 30px 0px 0px\"}\' hide_in = \"0\" id = \"\" class = \"\" ][/tatsu_header_logo][/tatsu_header_column][tatsu_header_column column_width = \'{\"d\":81}\' horizontal_alignment = \"flex-end\" vertical_alignment = \"center\" padding = \"0px 0px 0px 0px\" sidebar_vertical_alignment = \"center\" sidebar_horizontal_alignment = \"flex-start\" hide_in = \"0\" id = \"\" class = \"\" layout = \"1/2\" ][tatsu_navigation_menu menu_name = \"2\" disable_in_mobile = \"\" margin = \'{\"d\":\"0px 30px 0px 0px\"}\' links_margin = \'{\"d\":\"0px 10px 0px 0px\"}\' menu_color = \"rgba(74,74,74,1)\" menu_hover_color = \"\" sub_menu_bg_color = \"#ffffff\" sub_menu_text_color = \"#1c1c1c\" sub_menu_hover_color = \"\" sub_menu_hover_bg_color = \"\" submenu_width = \'{\"d\":\"200\"}\' submenu_padding = \'{\"d\":\"10\"}\' sub_menu_shadow = \"0px 0px 24px 2px rgba(45,62,80,0.12)\" sub_menu_border = \"\" menu_position = \"top_header\" ][/tatsu_navigation_menu][/tatsu_header_column][/tatsu_header_row]",  
		)
	);
}
?>