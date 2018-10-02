<?php 
if (!function_exists('oshine_newsletter')) {
	function oshine_newsletter( $atts, $content ) {
			$atts = shortcode_atts( array (
				'api_key' => '',
				'id' => '',
				'width' => '50',
				'alignment' => 'left',			
				'button_text'=>'Submit',
				'bg_color'=> '',
				'hover_bg_color'=> '',
				'color'=> '',
				'hover_color'=> '',
				'border_width' => 0,			
				'border_color'=> '',
				'hover_border_color'=> '',
		        'animate' => 0,
				'animation_type'=>'fadeIn',
				'key' => be_uniqid_base36(true),
			), $atts);
			
			extract($atts);
			$custom_style_tag = be_generate_css_from_atts( $atts, 'newsletter', $atts['key'] );
			$custom_class_name = ' tatsu-'.$atts['key'];


			global $be_themes_data;
	    	$api_key = ( isset( $api_key ) && !empty( $api_key ) ) ? $api_key : '' ;
	    	$width  = (isset($width ) && !empty( $width ) ) ? $width : '100';
	    	$alignment  = (isset($alignment ) && !empty( $alignment ) ) ? $alignment : 'left';	
			
			$border_width = (!isset($border_width) || empty($border_width) || $border_width == '0') ? 0 : $border_width;
			$border_style = $border_width != 0 ? 'border-style: solid;' : '' ;

	    	$id = ( isset( $id ) && !empty( $id ) ) ? $id : '' ;
			$animate = ( isset( $animate ) && 1 == $animate ) ? 'tatsu-animate' : 0 ;
			$privacy_policy_link = ( function_exists( 'get_privacy_policy_url' ) ) ? get_privacy_policy_url() : '#';
			$output = '';
	    	$output .= '<div class="oshine-mc-wrap '.$custom_class_name.' oshine-module align-'.$alignment.' '.$animate.' clearfix" data-animation="'.$animation_type.'" data-consent-error = "'.__('Please check the consent box, in order for us to process this form', 'oshine-modules').'">';
	    	$output .= '<form method="POST" class="oshine-mc-form">';
	    	$output .= '<div class="clearfix">';
	    	$output .= '<input type="hidden" name="api_key" value="'.$api_key.'" /><input type="hidden" name="list_id" value="'.$id.'" />';
			$output .= '<fieldset class="contact_fieldset oshine-mc-field" style="width: '.$width.'%;"><input type="text" name="email" placeholder="'.__('Email','oshine-module').'" /><div class="clear"></div></fieldset>';
			$output .= '<fieldset class="contact_fieldset oshine-mc-submit-wrap"><input type="submit" name="submit" value="'.$button_text.'" class="oshine-mc-submit oshine-module tatsu-button" style= "'.$border_style.'" /><div class="subscribe_loader"><div class="tatsu-icon loader-style4-wrap loader-icon"></div></div></fieldset>';
			if( !empty( $be_themes_data['consent_checkboxes'] ) ) {
				$output .= '<fieldset classs="contact_consent">	<input type="checkbox" name="contact_consent" class="consent-checkbox" placeholder="'.__('Subject','oshine-modules').'" '.$border_width.' /><span class="consent-message">'.sprintf( __('By checking this box, you consent and confirm your subscription to our newsletter. For more info check our <a href="%s" target="_blank">privacy policy</a> where you will get more info on where, how and why we store your data.', 'oshine-modules'), esc_url( $privacy_policy_link) ).'</span></fieldset>';
			}
			$output .= '</div>';
			$output .= '<div class="subscribe_status tatsu-notification"></div>';
			$output .= '</form>';
			$output .= $custom_style_tag;
	        $output .= '</div>';
	        return $output;
	}
	add_shortcode( 'newsletter', 'oshine_newsletter' );
}

?>