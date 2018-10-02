<?php
/*****************************************************
		GALLERY
*****************************************************/
if (!function_exists('be_justified_gallery')) {
	function be_justified_gallery( $atts ) {
		global $be_themes_data;
		$atts = shortcode_atts( array (
			'gutter_width' => 40,
			'image_height' => 200,
			'initial_load_style' => 'none',
			'hover_style' => 'style1-hover',
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
			'image_effect' => 'none',
			'disable_overlay' => 0,
			'overlay_color' => '',
			'gradient' => '0',
			'gradient_color' => '',
			'gradient_direction' => 'bottom',
			'overlay_opacity' => '85',
			'items_per_load' => '12',
			'gallery_paginate' => 0,
			'like_button' => 0,
			'images' => '',
		) , $atts );

		extract( $atts  );

		$output = $thumb_overlay_color = $gradient_style_color = '';
		$gutter_width = (isset($gutter_width) || $gutter_width == 0 || !empty($gutter_width)) ? intval( $gutter_width ) : intval(40);
		$image_height = (isset($image_height) || $image_height == 0 || !empty($image_height)) ? intval( $image_height ) : intval(200);
		$images = ((!isset($images)) || empty($images)) ? '' : $images;
		$initial_load_style = ((!isset($initial_load_style)) || empty($initial_load_style)) ? 'none' : $initial_load_style;
		$hover_style = ((!isset($hover_style)) || empty($hover_style)) ? 'style1-hover' : $hover_style;
		$disable_hover_icon = ((!isset($disable_hover_icon)) || empty($disable_hover_icon)) ? '' : 'hover-icon-no-show';
		$default_image_style = ((!isset($default_image_style)) || empty($default_image_style)) ? 'color' : $default_image_style;
		$hover_image_style = ((!isset($hover_image_style)) || empty($hover_image_style)) ? 'color' : $hover_image_style;
		$image_effect = ((!isset($image_effect)) || empty($image_effect)) ? 'none' : $image_effect;
		$gradient_direction = ((!isset($gradient_direction)) || empty($gradient_direction)) ? 'bottom' : $gradient_direction;
		$disable_overlay = (isset($disable_overlay) && !empty($disable_overlay) && $disable_overlay == 1) ? 1 : 0;
		$items_per_load = ((!isset($items_per_load)) || empty($items_per_load)) ? '' : $items_per_load;
		$gallery_paginate =  ((isset($gallery_paginate)) && !empty($gallery_paginate) && $gallery_paginate == 1) ? 1 : 0;
		



		if($default_image_style == 'black_white') {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'bw_to_bw';
			} else {
				$img_grayscale = 'bw_to_c';
			}
		} else {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'c_to_bw';
			} else {
				$img_grayscale = 'c_to_c';
			}
		}


		
		$overlay_color = be_compute_color( $overlay_color );
		$overlay_color = $overlay_color[1];


		$overlay_opacity = ((!isset($overlay_opacity)) || empty($overlay_opacity)) ? 85 : $overlay_opacity;
		if(isset($overlay_color) && !empty($overlay_color)) {
			//$overlay_color = be_themes_hexa_to_rgb( $overlay_color );
			$thumb_overlay_color = $overlay_color;  //'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';
			if($gradient) {
				if( empty( $gradient_color ) ) {
					$gradient_color = $overlay_color;
				} else {
					//$gradient_color = be_themes_hexa_to_rgb( $gradient_color );
				}
				//$thumb_gradient_overlay_color = 'rgba('.$gradient_color[0].','.$gradient_color[1].','.$gradient_color[2].','.(intval($overlay_opacity) / 100 ).')';
				$thumb_gradient_overlay_color = $gradient_color;
				$gradient_style_color = 'background-image: -o-linear-gradient('.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);background-image: -moz-linear-gradient('.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);background-image: -webkit-linear-gradient('.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);background-image: -ms-linear-gradient('.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);background-image: linear-gradient(to '.$gradient_direction.', '.$thumb_overlay_color.' 0%, '.$thumb_gradient_overlay_color.' 100%);';
			}
		}



		$source = array (
			'source' => 'selected',
			'account_name' => '', 
			'count' => '',
			'col' => 'two',
			'masonry' => 1,
		);


		$paged  = '0';
		$images_offset = '0';

		$images_arr = $images;	
		$data_total_items = count(explode(',',$images_arr)) - $items_per_load;
		
		if(1 == $gallery_paginate && '' != $items_per_load){
			$images_subset = array_slice(explode(',', $images), $images_offset, $items_per_load);
		}else{
			$images_subset = explode(',', $images);
		}

		$images = get_gallery_image_from_source($source, implode(",",$images_subset), 'photoswipe');
		

		// $images = get_gallery_image_from_source($source, $images, 'photoswipe');
		
		if($images && is_array($images) && !isset($images['error']) && empty($images['error'])) {
			$output .= '<div class="justified-gallery-outer-wrap oshine-module '.$disable_hover_icon.'">';
			$output .= '<div class=" justified-gallery-inner-wrap " data-action="get_be_justified_gallery_with_pagination" data-paged="1" data-source=\''.json_encode($source).'\' data-images-array="'.$images_arr.'" data-items-per-load="'.$items_per_load.'" data-hover-style="'.$hover_style.'" data-image-grayscale="'.$img_grayscale.'" data-image-effect="'.$image_effect.'" data-thumb-overlay-color="'.$thumb_overlay_color.'" data-grad-style-color="'.$gradient_style_color.'" data-like-button="'.$like_button.'" data-disable-overlay="'.$disable_overlay.'" >';
			$output .= '<div class=" justified-gallery clickable clearfix be-photoswipe-gallery '.$initial_load_style.'" data-gutter-width="'.$gutter_width.'" data-image-height="'.$image_height.'">';
			$output .= get_be_justified_gallery_shortcode($images, $hover_style, $img_grayscale, $image_effect, $thumb_overlay_color, $gradient_style_color, $like_button, $disable_overlay);
			$output .= '</div>'; //end justified-gallery
			if('' != $items_per_load && (1 == $gallery_paginate) ) {
				$output .='<div class="trigger_infinite_scroll justified_gallery_infinite_scroll"></div>';  
			}
			$output .= '</div>'; //end justified-gallery-inner-wrap
			$output .= '</div>'; //end justified-gallery-outer-wrap
		} else {
			if(is_array($images) && !empty($images['error'])) {
				$output .= '<p class="element-empty-message">'.$images['error'].'</p>';
			} else {
				$output .= '<p class="element-empty-message"><b>'.__('Gallery Notice : ', 'oshine-modules').'</b>'.__('Images have either not been selected or couldn\'t be found', 'oshine-modules').'</p>';
			}
		}
		return $output;
	}
	add_shortcode( 'justified_gallery' , 'be_justified_gallery' );
}
?>