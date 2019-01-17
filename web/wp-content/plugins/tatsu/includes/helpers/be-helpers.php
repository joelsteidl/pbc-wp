<?php

/* ---------------------------------------------  */
// Filter to generate slug for custom sidebars
/* ---------------------------------------------  */
if ( ! function_exists( 'be_generate_slug' ) ) {
	function be_generate_slug( $phrase, $maxLength ) {
		$result = strtolower($phrase);
		$result = preg_replace( "/[^a-z0-9\s-]/", "", $result );
		$result = trim( preg_replace( "/[\s-]+/", " ", $result ) );
		$result = trim( substr( $result, 0, $maxLength ) );
		$result = preg_replace( "/\s/", "-", $result );
		return $result;
	}
}

if( !function_exists( 'be_is_json' ) ) {
	function be_is_json( $string ) {
		json_decode($string);
		return ( json_last_error() == JSON_ERROR_NONE );
	}
}

if( !function_exists( 'be_solid_color' ) ) {
	function be_solid_color( $color ){
		return array($color,$color,'solid');
	}
}

if( !function_exists( 'be_gradient_color' ) ) {
	function be_gradient_color( $color_arr ){
		$color_value = ''; 
		$first_color_stop = '';
		$i = 0;
		$color_value = 'linear-gradient(';
		$color_value .= $color_arr['angle'].'deg';
		$colorPositions = $color_arr['colorPositions'];
		foreach( $colorPositions as $colorPos => $colorCode ){
			$color_value .= ', '. $colorCode .' '. $colorPos.'%';
			if( $i == 0 ){
				$first_color_stop = $colorCode;
			}
			$i++;
		}
		$color_value .= ')';
		return array( $color_value, $first_color_stop, 'gradient' );
	}
}

if( !function_exists( 'be_compute_color' ) ) {
	function be_compute_color( $color ){
		$color_value = ''; 
		$first_color_stop = '';
		$colorHubColor = '';
		$i = 0;
		if(! empty( $color)){
			if( be_is_json( $color ) ){
				$color_arr = json_decode( $color, true );
				if( array_key_exists( 'id', $color_arr ) ) {
					$id_array = explode( ':', $color_arr['id'] );
					$color_data = $color_arr['color'];
					if( $id_array[0] == 'swatch' && function_exists( 'colorhub_get_swatch' ) ){
						$swatch = colorhub_get_swatch( $id_array[1] );
						$color_data = $swatch['color'];
					}
					if( $id_array[0] == 'palette' && function_exists( 'colorhub_get_palette' ) ){
						$color_data = colorhub_get_palette( $id_array[1] );
					}
					if( is_array( $color_data ) ){
						return be_gradient_color( $color_data );
					} else{
						return be_solid_color( $color_data );
					}
				} 
				else {
					return be_gradient_color( $color_arr );
				}
			} else {
				return be_solid_color( $color );
			}
		}
		return array( $color_value, $first_color_stop, 'solid' );
	}
}

// for CSS Generation for each module 
// get atts(after combining default and atts) & module name (section or row or column)
if( !function_exists( 'be_reformat_module_options' ) ) {
	function be_reformat_module_options( $arr ){
		$new_arr = array();
		foreach($arr as $key => $value){
			$new_arr[$value['att_name']] = $value;
		}
		return $new_arr;
	}
}

if( !function_exists( 'be_reverse_reformat_atts' ) ) {
	function be_reverse_reformat_atts( $arr ){
		$new_arr = array();
		foreach($arr as $key => $value){
			$value['att_name'] = $key;
			$new_arr[] = $value;
		}
		return $new_arr;
	}
}

if( !function_exists( 'be_should_compute_css' ) ) {
	function be_should_compute_css( $atts, $condition , $device, $val ){
		//var_dump($val);
		extract($atts);
		$check_flag = array();
		$relation = !empty($condition['relation'])? $condition['relation'] : '';
		$condition_array = !empty( $condition['when'] ) ? $condition['when'] : array() ;

		if( empty( $condition_array ) ) {
			return true;
		}
		//$iterator = is_array( $condition_array[0] ) && is_string( $condition_array[0][0] ) ? $condition_array[0]: $condition_array;
		
		foreach( $condition_array as $each_key => $each_value ){// when array of array
			//$condition_count = count( $condition_array );
			$checking = is_array($each_value) && array_key_exists( 0, $each_value ) && is_string( $each_value[0] ) ? $each_value : $condition_array ;
			//$temp = !empty( $isResponsive ) && json_decode( ${$checking[0]}, true ) != null ? json_decode( ${$checking[0]}, true ) : null ;
			//$checking_0 = !empty( $isResponsive ) ? $temp['d'] : ${$checking[0]} ;

			// Instead of two checking one if is enough
			//$checking_0 = !empty( $device ) && !empty( $val ) ? $val : ${$checking[0]} ;
			//$checking_2 = !empty( $device ) && !empty( $val ) ? $checking[2][$device] : $checking[2];

			//if data format changes like key changes in checking_0 vil lead to undefined index error
			if( !empty( $device ) && !empty( $val ) && !empty($checking[2]) && is_array($checking[2]) && array_key_exists( $device, $checking[2] ) ){
				$checking_0 = $val;
				$checking_2 = $checking[2][$device];
			} else {
				$checking_0 = ${$checking[0]};
				$checking_2 = !empty($checking[2]) ? $checking[2] : null ;
			}
			$checking_0 = trim( $checking_0 );   // trim coz responsive values vil have space in last
			//if( is_array ( $checking ) ){
				switch( $checking[1] ){
					case 'empty':
						if( empty( $checking_0 ) ){
							$check_flag[] = true;
						}else if( 'and' != $relation ){
							$check_flag[] = false;
						}else{
							return false;
						}
						break;
					case 'notempty':
						if( !empty( $checking_0 ) ){
							$check_flag[] = true;
						}else if( 'and' != $relation ){
							$check_flag[] = false;
						}else{
							return false;
						}
						break;
					case '=':
						if( $checking_0 == $checking_2){
							$check_flag[] = true;
						}else if( 'and' != $relation ){
							$check_flag[] = false;
						}else{
							return false;
						}
						break;
					case '!=':
						if( $checking_0 != $checking_2){
							$check_flag[] = true;
						}else if( 'and' != $relation ){
							$check_flag[] = false;
						}else{
							return false;
						}
						break;
					default:
						$check_flag[] = null;
						if( 'and' == $relation ){
							return false;
						}
						break;
				}
			//}
		}
		if( in_array( true, $check_flag ) ){
			if( ( 'and' == $relation && !in_array( false, $check_flag ) ) || ( 'and' != $relation ) ){
				return true;
			}
		}
		return false;
	}
}

if( !function_exists( 'be_compute_css' ) ) {
	function be_compute_css( $config_att, $condition, $val, $property ){
		$css_output = '';
		if( is_array( $val ) && $property === 'typography' ){
			foreach( $val as $prop => $value ){
				if( $prop === 'font-variant' ){
					$style = preg_replace("/[^a-zA-Z]+/", "", $value);
					$css_output .= 'font-weight : '. intval($value).';';
					if( $style !== '' ){
						$css_output .= 'font-style : '. $style .';';
					}
				} else if( $prop === 'font-family' ) {
					$family = function_exists( 'be_get_font_family' ) ? be_get_font_family( $value ) : "-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif";
					$css_output .= $prop.' : '.$family.';';
				}else{
					$css_output .= $prop.' : '.$value.';';
				}
			}
			return $css_output;
		}

		if( !empty( $condition['callback'] ) && function_exists( $condition['callback']) && !empty($val)){
			$val = call_user_func($condition['callback'],$val);
		}

		if( is_array( $property ) ){
			$css = '';
			foreach($property as $element){
				$css .= be_compute_css( $config_att, $condition, $val, $element );
			}
			return $css;
		}

	
		if( $config_att['type'] == 'color'){
			$value = be_compute_color($val);
			$val = $value[0];
			$output = '';
			if( ( 'border' === $property || 'border-color' === $property ) && 'gradient' === $value[2] ) {
				return 'border-image: '.$value[0].';border-image-slice: 1;';
			} else if( ( 'background' === $property || 'background-color' === $property ) && 'gradient' === $value[2] ) {
				return 'background: '.$value[0].';';
			} else if( 'color' === $property ) {
				if( 'gradient' === $value[2] ) {
					$output .= 'background: '.$value[0].'; -webkit-background-clip:text; -webkit-text-fill-color:transparent;';
					
				} else {
					$output .= 'color: '.$value[0].' ';
					$output .= !empty( $condition['append'] ) ? $condition['append'] : '';
					$output .= ';';
				}
				return $output;
			} else if( 'border-color' === $property){
				return 'border-color: '.$value[0].'; ';
			} 
		}

		$prepend = !empty( $condition['prepend'] ) ? $condition['prepend'] : '';
		$append = !empty( $condition['append'] ) ? $condition['append'] : '';
		
		$unit_of_val = preg_replace('/[0-9]|\./','',$val);

		if( ( $config_att['type'] === 'slider' || $config_att['type'] === 'number' ) && $unit_of_val !== '' ){
			$append = '';
		}

		if( !empty( $condition['operation'] ) && is_array( $condition['operation'] ) ){
			$operation = $condition['operation'];
			//extract($operation);
			switch($operation[0]){
				case '/':
					$val /=  $operation[1];
					break;
				case '*':
					$val *=  $operation[1];
					break;
				case '+':
					$val +=  $operation[1];
					break;
				case '-':
					$val -=  $operation[1];
					break;
				default:
					$val = $val;
					break;
			}
		}


		if( $property == 'background-image' ) {
			return $property.': url('.$val.');';
		} else if( $property == 'transform' ) {
			$value = explode(' ', $val);
			return $property.': translate3d('.($value[0]).','.($value[1]).', 0);';
		} else if( 'transformX' == $property  ) {
			return 'transform: translateX('.$prepend.$val.$append.');';
		} else if( 'transformY' == $property  ) {
			
			return 'transform: translateY('.$prepend.$val.$append.');';
		} else {
			//if( !empty( $prepend ) || !empty( $append )){
				// if( !empty( $condition['append'] ) && !empty( $condition['prepend'] ) ){
				// 	return $property.': '.$condition['prepend'].$val.$condition['append'].';';
				// } elseif( !empty( $condition['prepend'] ) ){
				// 	return $property.': '.$condition['prepend'].$val.';';
				// }
				return $property.': '.$prepend.$val.$append.';';
			// }
			// return $property.': '.$val.';';		
		}
	}
}

if( !function_exists( 'be_generate_css_from_atts' ) ) {
	function be_generate_css_from_atts( $atts, $module, $uuid, $module_options = '' ){
		$module_options_class = empty( $module_options ) ? 'Tatsu_Module_Options' : 'Tatsu_'.$module_options.'_Module_Options';
		$tatsu_registered_modules = $module_options_class::getInstance()->get_modules();
		$atts = apply_filters( $module.'_before_css_generation', $atts );
		$css_props = array();
		if( !empty( $tatsu_registered_modules[$module] ) ){
			$config = be_reformat_module_options($tatsu_registered_modules[$module]['atts']);
		}
		
		if( is_array( $atts ) ) {
			foreach( $atts as $att => $value ){
				if( !empty( $config[$att]['css'] )  ){
					$responsive = !empty( $config[$att]['responsive'] ) ? $config[$att]['responsive'] : null ;
					if( !empty( $responsive ) ) {
						$temp_value = is_array( $value ) ? $value : json_decode( $value, true );
						if( $temp_value ) {
							$value = $temp_value;
						}
					}
					
					$selectors = $config[$att]['selectors'];
					
					foreach( $selectors as $selector => $condition ){
						$index = str_replace('{UUID}', $uuid, $selector);

						if( !empty( $value ) ) {
							if( is_array( $value ) ) {	
								foreach( $value as $device => $val ) {
									be_should_compute_css( $atts, $condition, $device, $val ) ? $css_props[$device][$index][] = be_compute_css( $config[$att], $condition, $val, $condition['property'] ) : null ;
								}
							} else {
								be_should_compute_css( $atts, $condition, false, false, $module ) ? $css_props['d'][$index][] = be_compute_css( $config[$att], $condition, $value, $condition['property'] ) : null ;
							}
						}
					}
				}
			}
		}

		$css = array();
		foreach($css_props as $device => $selectors){
			$css[$device] = '';
			foreach ( $selectors as $selector => $css_atts ) {
				if( !empty ( $css_atts ) ){
					$css[$device] .= $selector. '{'.implode('' ,$css_atts). '}';
				}
			}
			$css[$device] = trim( $css[$device] );
		}

		$output = '';

	//	$output .= '<style>';
		if( !empty( $css['d'] ) ) {
			$output .= $css['d'];
		}
		//$output .= array_key_exists('d', $css) ? $css['d'] : '' ;
		if( !empty( $css['l'] ) ) {
			$output .= '@media only screen and (max-width:1377px) {';
			$output .= $css['l'];
			$output .= '}';
		}
		if( !empty( $css['t'] ) ) {
			$output .= '@media only screen and (min-width:768px) and (max-width: 1024px) {';
			$output .= $css['t'];
			$output .= '}';
		}
		if( !empty( $css['m'] ) ) {
			$output .= '@media only screen and (max-width: 767px) {';
			$output .= $css['m'];
			$output .= '}';
		}
	//	$output .= '</style>';
		
		if( !empty( $output ) ) {
			$output = '<style>'.$output.'</style>';
		}

		//return be_minify_css( $output );
		return $output;
	}
}

if( !function_exists( 'be_minify_css' ) ) {
	function be_minify_css( $css ) {

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove spaces before and after comment
		$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

		// Remove comment blocks, everything between /* and */, unless
		// preserved with /*! ... */ or /** ... */
		$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { } ) > 
		$css = preg_replace( '/ (,|;|\{|}|\)|>)/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Converts all zeros value into short-hand
		$css = preg_replace( '/0 0 0 0/', '0', $css );

		// Shortern 6-character hex color codes to 3-character where possible
		$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

		return trim( $css );

	}
}

if( !function_exists( 'be_get_video_details' ) ){
	function be_get_video_details($url,$size = 'large'){
		$pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
		$details = array();

		if( $result = preg_match($pattern, $url, $matches) ){
			
			if( $size  === 'small'){
				$size = 'mqdefault';
			}elseif( $size === 'large' ){
				$size = 'maxresdefault';
			}
	
			$video_id = $matches[1];
			$youtube_url = "https://img.youtube.com/vi/".$video_id."/".$size.".jpg";

			return array(
				'source' => 'youtube',
				'thumb_url' => $youtube_url,
				'video_id' => $video_id
			);

		}else if( strpos( $url,'vimeo' ) !== false ) {

			$vimeo_id = substr(parse_url($url, PHP_URL_PATH), 1); 
			$response = wp_remote_get( "http://vimeo.com/api/v2/video/$vimeo_id.php" );

			if( $size  === 'small'){
				$size = '_320x180';
			}elseif( $size === 'large' ){
				$size = '_1280x720';
			}

			if( !is_wp_error( $response ) ){
				if( $response['response']['code'] === 200){
					$hash = unserialize( $response['body']);
					$vimeo_url = $hash[0]['thumbnail_large'];
					$vimeo_url = str_replace( '_640',$size,$vimeo_url );
					return array(
						'source' => 'vimeo',
						'thumb_url' => $vimeo_url,
						'video_id' => $vimeo_id
					);
				} else {
					return array(
						'source' => 'vimeo',
						'thumb_url' => 'https://placehold.it/1280x720',
						'video_id' => $vimeo_id
					);
				}
				
			}else{
				return array(
					'source' => 'vimeo',
					'thumb_url' => 'https://placehold.it/1280x720',
					'video_id' => ''
				);
			}
		}
	}
}

/* ---------------------------------------------  */
// Function to get attachment image from ID 
/* ---------------------------------------------  */

if ( ! function_exists( 'be_wp_get_attachment' ) ) :
	function be_wp_get_attachment( $attachment_id ) {
		$attachment = get_post( $attachment_id );
		if(isset($attachment) && !empty($attachment)) {
			$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'full' );
			return array (
				'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
				'caption' => $attachment->post_excerpt,
				'description' => $attachment->post_content,
				'href' => get_permalink( $attachment->ID ),
				'src' => $attachment->guid,
				'title' => $attachment->post_title,
				//Changed for Photo Swipe Gallery
				'width' => $image_attributes[1],
				'height' => $image_attributes[2] 
				//End
			);
		}
	}
	endif;

if( !function_exists( 'be_gdpr_lightbox_for_video' ) ){
	function be_gdpr_lightbox_for_video( $key,$url,$src ){

		return '<div id="gdpr-alt-lightbox-'.$key.'" class=" white-popup mfp-hide" ><div class="gdpr-alt-image"><img style="opacity:1;width:100%;" src="'.$url.'"/><div class="gdpr-video-alternate-image-content" >'.do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api='.$src.' ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup] ' ))).'</div></div>'.'</div>';

	}
}

if ( ! function_exists( 'be_gdpr_options' ) ) {
    function be_gdpr_options(){
        $options = array(
            'youtube' => array(
                'label' => "Youtube",
                'description' => __( "Consent to display content from YouTube.", 'oshin' ),
                'required' => false
            ),
            'vimeo' => array(
                'label' => "Vimeo",
                'description' => __( "Consent to display content from Vimeo.", 'oshin' ),
                'required' => false
            ), 
            'gmaps' => array(
                'label' => "Google Maps",
                'description' => __( "Consent to display content from Google Maps.", 'oshin' ),
                'required' => false
            ),
        );
        foreach( $options as $option => $value ){
            be_gdpr_register_option($option,$value);
        }
    }
}
add_action('be_gdpr_register_options','be_gdpr_options');

if( !function_exists( 'be_gdpr_get_video_alt_content' ) ){
	function be_gdpr_get_video_alt_content( $img_src, $concern, $hidden_by_default ){

		$hide_class = '';
		if( $hidden_by_default ){
			$hide_class = ' be-gdpr-message-hide ';
		}

		return '<div class="gdpr-alt-image '.$hide_class.' be-gdpr-consent-message"><img style="opacity:1;" src="'.$img_src.'"/><div class="gdpr-video-alternate-image-content" >'. do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="'.$concern.'" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ))  ) .'</div></div>';
	}
}
?>