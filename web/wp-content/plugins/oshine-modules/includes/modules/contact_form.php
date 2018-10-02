<?php
/**************************************
		Contact Form
**************************************/
if ( ! function_exists( 'be_contact_form' ) ) {
	function be_contact_form($atts,$content) {
		$atts = shortcode_atts( array (
			'form_style' => 'style1',
			'input_bg_color' => '',
			'input_color' => '',
		    'input_border_color' => '',
		    'border_width' => '',
		    'input_height' => '',
		    'input_style' => 'style1',
		    'input_button_style' => 'medium',
		    'bg_color' => '',
		    'color' => '',
			'key' => be_uniqid_base36(true),
		),$atts );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'contact_form', $key );
		$unique_class_name = 'tatsu-'.$key;
		global $be_themes_data;

		$output = '';
	//	$styles_height = ( isset( $input_height ) && !empty( $input_height) ) ? 'height: '.$input_height.'px;' : '';
		$border_width = 'style="border-width:'.$border_width.'px"';
		$form_style =  ( isset( $form_style ) && !empty( $form_style) ) ? $form_style : 'style1';
		$input_style = ( isset( $input_style ) && !empty( $input_style) ) ? $input_style : 'style1';
		$input_button_style = ( isset( $input_button_style ) && !empty( $input_button_style) ) ? $input_button_style : 'medium';
		$privacy_policy_link = ( function_exists( 'get_privacy_policy_url' ) ) ? get_privacy_policy_url() : '#';
		$output .= '<div class="contact_form contact_form_module oshine-module '.$form_style.' '.$input_style.'-input '.$unique_class_name.'" data-consent-error = "'.__('Please check the consent box, in order for us to process this form', 'oshine-modules').'">
						<form method="post" class="contact">
							<fieldset class="field_name contact_fieldset">
								<input type="text" name="contact_name" class="txt autoclear" placeholder="'.__('Name','oshine-modules').'" '.$border_width.' />
							</fieldset>
							<fieldset class="field_email contact_fieldset">
								<input type="text" name="contact_email" class="txt autoclear" placeholder="'.__('Email','oshine-modules').'" '.$border_width.' />
							</fieldset>';
		if($form_style != 'style2'){
			$output .= '<fieldset class="field_subject contact_fieldset">
								<input type="text" name="contact_subject" class="txt autoclear" placeholder="'.__('Subject','oshine-modules').'" '.$border_width.' />
						</fieldset>';
		}							
		$output .= '<fieldset class="field_comment contact_fieldset">
								<textarea name="contact_comment" class="txt_area autoclear" placeholder="'.__('Message','oshine-modules').'" '.$border_width.' ></textarea>
							</fieldset>';
		if( !empty( $be_themes_data['consent_checkboxes'] ) ) {
			$output .= '<fieldset class="field_consent contact_fieldset">
							<input type="checkbox" name="contact_consent" class="consent-checkbox" placeholder="'.__('Subject','oshine-modules').'" '.$border_width.' />
							<span class="consent-message">'.sprintf( __('By checking this box, you consent to sending your details to us over email. For more info check our <a href="%s" target="_blank">privacy policy</a> where you will get more info on where, how and why we store your data.', 'oshine-modules'), esc_url( $privacy_policy_link) ).'</span>
							</fieldset>';
		}

		$output .= '<fieldset class="contact_fieldset submit-fieldset">
								<input type = "hidden" name = "contact_style" value = "'. $form_style .'"/> 
								<input type="submit" name="contact_submit" value="'.__('Submit','oshine-modules').'" class="contact_submit tatsu-button rounded '.$input_button_style.'btn" />
								<div class="contact_loader"><div class="font-icon loader-style4-wrap loader-icon"></div></div>
							</fieldset>';
				
		$output	.=		'<div class="contact_status tatsu-notification"></div>
						</form>'.$custom_style_tag.'
					</div>';


		return $output; 
	}
	add_shortcode('contact_form','be_contact_form');
}

add_filter( 'contact_form_before_css_generation', 'contact_form_css' );
function contact_form_css( $atts ) {
	$atts['input_bg_color'] = ( !empty($atts['input_bg_color']) ? $atts['input_bg_color'] : 'transparent' );
	$atts['input_color'] = ( !empty($atts['input_color']) ? $atts['input_color'] : 'input_color' );
	return $atts;
}

?>