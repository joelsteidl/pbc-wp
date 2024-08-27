<?php

//BE GDPR Privacy content
if ( ! function_exists( 'be_gdpr_get_cookie_privacy_content' ) ){
    function be_gdpr_get_cookie_privacy_content( $name='' ){
        $cookie_privacy_content = array(	
			'be_gdpr_cookie_privacy_content' =>  esc_html__( 'We use cookies to enhance your experience while using our website. To learn more about the cookies we use and the data we collect, please check our ', 'be-gdpr' ).'[be_gdpr_privacy_popup].',
			'be_gdpr_accept_btn_text' => esc_html__( 'I Accept', 'be-gdpr' ),
			'be_gdpr_popup_title_text' => esc_html__( 'Privacy Settings', 'be-gdpr' ),
			'be_gdpr_popup_intro_content' =>  esc_html__( 'We use cookies to enhance your experience while using our website. If you are using our Services via a browser you can restrict, block or remove cookies through your web browser settings. We also use content and scripts from third parties that may use tracking technologies. You can selectively provide your consent below to allow such third party embeds. For complete information about the cookies we use, data we collect and how we process them, please check our ', 'be-gdpr' ).'[be_gdpr_privacy_policy_page]',
			'be_gdpr_privacy_policy_link_text' => esc_html__( 'Privacy Policy', 'be-gdpr' ),
			'be_gdpr_popup_save_btn_text' => esc_html__( 'Save', 'be-gdpr' ),
			'be_gdpr_consent_desc' => esc_html__(  'Consent to display content from ', 'be-gdpr' ).'- [be_gdpr_api_name]',
			'be_gdpr_text_on_overlay' =>  esc_html__( 'Your consent is required to display this content from ', 'be-gdpr' ).' [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ,
		);

        if ( empty( $name ) ) {
            return $cookie_privacy_content;   
        } else if ( empty( $cookie_privacy_content[ $name ] ) ) {
            return $cookie_privacy_content[ 'be_gdpr_cookie_privacy_content' ];
        }

        $name = sanitize_key( $name );
        //if translation is ON then send tranalatable string
        return wp_kses_post( empty( $GLOBALS['be_gdpr_multi_language_translation'] ) ? get_option( $name, $cookie_privacy_content[ $name ] ): $cookie_privacy_content[ $name ] );
    }
}

if ( !function_exists( 'be_gdpr_privacy_ok' ) ){
    function be_gdpr_privacy_ok($name){
        $privacyPref = array_key_exists( 'be_gdpr_privacy',$_COOKIE ) ?  json_decode(stripslashes($_COOKIE['be_gdpr_privacy'])) : array() ;

        $options = Be_Gdpr_Options::getInstance()->get_options();
        
        if( array_key_exists( $name, $options ) ){
            return in_array($name, $privacyPref);
        } else {
            return true;
        }

		
    }
}

if( !function_exists( 'be_gdpr_register_option' ) ){
    function be_gdpr_register_option( $id, $args ){
        if( empty( $id ) || empty( $args ) || !is_array( $args ) ) {
            trigger_error( __( 'Incorrect Arguments to register a consent condition', 'be-gdpr' ), E_USER_NOTICE );
        }
        Be_Gdpr_Options::getInstance()->register_option($id,$args);
    }
}

if( !function_exists( 'be_gdpr_deregister_option' ) ){
    function be_gdpr_deregister_option( $id ){
        if( empty( $id ) ) {
            trigger_error( __( 'Incorrect Arguments to de-register a consent condition', 'be-gdpr' ), E_USER_NOTICE );
        }
        Be_Gdpr_Options::getInstance()->deregister_option($id);
    }
}

/******* GDPR Audio *******/
if( !function_exists( 'be_gdpr_embed_audio' ) ){
	function be_gdpr_embed_audio( $url ){
		if( strpos( $url, 'spotify' ) !== false ){
            if( !be_gdpr_privacy_ok( 'spotify' ) ){
                return '<div class="gdpr-alt-image"><img style="opacity:1;width:100%;" src="'. plugin_dir_url(__FILE__) .'/assets/spotify.jpg"/><div class="gdpr-video-alternate-image-content" >'. do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="spotify" ]', be_gdpr_get_cookie_privacy_content( 'be_gdpr_text_on_overlay' ) )  ) .'</div></div>';
            } else {
                return wp_oembed_get( $url );
            }
        } else if ( strpos( $url, 'soundcloud' ) !== false ){
            if( !be_gdpr_privacy_ok( 'soundcloud' ) ){
                return '<div class="gdpr-alt-image"><img style="opacity:1;width:100%;" src="'. plugin_dir_url(__FILE__) .'/assets/soundcloud.jpg"/><div class="gdpr-video-alternate-image-content" >'. do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="soundcloud" ]', be_gdpr_get_cookie_privacy_content( 'be_gdpr_text_on_overlay' ) )  ) .'</div></div>';
            } else {
                return wp_oembed_get( $url );
            }
        }
	}
}