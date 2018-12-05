<?php
/*****************************************************
		GALLERY
*****************************************************/
if (!function_exists('be_gallery')) {
	function be_gallery( $atts ) {
		global $be_themes_data;
		$atts = shortcode_atts( array (
			'col' => 'three',
			'lightbox_type' => 'photoswipe',
			'gutter_style' => 'style1',
			'items_per_load' => '',
			'gallery_paginate' => 'none',
			'gutter_width' => 40,
			'masonry'=> '0',
			'maintain_order' => '0',
			'initial_load_style' => 'none',
			'item_parallax' => 0,
			'hover_content_option' => 'icon',
			'disable_hover_icon' => '0',
			'hover_content_color' => '',
			'hover_style' => 'style1-hover',
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
			'image_effect' => 'none',
			'overlay_color' => '',
			'gradient_color' => '',
			'gradient' => '0',
			'gradient_direction' => 'bottom',
			'overlay_opacity' => '85',
			'placeholder_color' => '',
			'like_button' => 0,
			'image_source' => 'selected',
			'images' => '',
			'account_name' => 'themeforest',
			'count' => 10,
			'lazy_load' => 0,
			'delay_load' => 0,
			'ids'	=> '',
			'columns' => 'three',
			'link' => 'none',
			'key' => be_uniqid_base36(true),
		),$atts );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'be_gallery', $key );
		$unique_class_name = 'tatsu-'.$key;



		$lazy_load = (isset($lazy_load) && !empty($lazy_load) && intval($lazy_load) != 0) ? $lazy_load : 0;
		$delay_load = (isset($delay_load) && !empty($delay_load) && intval($delay_load) != 0) ? $delay_load : 0;
		$aspect_ratio = !empty( $be_themes_data['portfolio_aspect_ratio'] ) ? $be_themes_data['portfolio_aspect_ratio'] : '1.6';
	    $delay_load_class = ( !empty( $delay_load ) ) ? 'portfolio-delay-load' : '';
		$init_image_load = '';
	    $lazy_load_class = ( !empty( $lazy_load ) ) ? 'portfolio-lazy-load' : '';
		$enable_data_src = ( !( wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) ) && $lazy_load ) ? 1 : 0;
		$output = $thumb_overlay_color = $gradient_style_color = '';
		$col = ((!isset($col)) || empty($col)) ? 'three' : $col;
		$columns = ((!isset($columns)) || empty($columns)) ? 0 : $columns;
		$placeholder_color = ( ( isset( $placeholder_color ) ) && (!empty( $placeholder_color ) ) ) ? $placeholder_color : '';
		$link = ((!isset($link)) || empty($link)) ? '' : $link;
		$items_per_load = ((!isset($items_per_load)) || empty($items_per_load)) ? '' : $items_per_load;
		$gallery_paginate =  ((!isset($gallery_paginate)) || empty($gallery_paginate)) ? 'none' : $gallery_paginate;
		$gutter_style = ((!isset($gutter_style)) || empty($gutter_style)) ? 'style1' : $gutter_style;
		$gutter_width = (isset($gutter_width) || $gutter_width == 0 || !empty($gutter_width)) ? intval( $gutter_width ) : intval(40);
		$images = ((!isset($images)) || empty($images)) ? '' : $images;
		if( 'instagram' == $image_source ) {
			$aspect_ratio = 1;
		}
		//Conditions if default WP gallery is used
		if($columns != 0 || (!empty($ids) && $images == '') ) {
			// $masonry = 1;
			//$lightbox_type = 'photoswipe';
			
			if($columns > 5){
				$columns = 'three';
			}elseif($columns == 1){
				$columns = 'one';
			}elseif($columns == 2){
				$columns = 'two';
			}elseif($columns == 3){
				$columns = 'three';
			}elseif($columns == 4){
				$columns = 'four';
			}elseif($columns == 5){
				$columns = 'five';
			}
			$col = $columns;
		}

		//Condition if default WP gallery is used
		$images = (isset($ids) && $images == '') ? $ids : $images;
		$masonry = ((!isset($masonry)) || empty($masonry)) ? 0 : $masonry;
		$maintain_order = ( isset( $maintain_order ) && !empty( $maintain_order ) ) ? 1 : 0;
		$initial_load_style = ((!isset($initial_load_style)) || empty($initial_load_style)) ? 'none' : $initial_load_style;
		if( '' != $delay_load_class && 'none' != $initial_load_style ) {
			if( 'init-slide-left' == $initial_load_style ) {
				$init_image_load = 'fadeInLeft';
			}else if( 'init-slide-right' == $initial_load_style ) {
				$init_image_load = 'fadeInRight';
			}else if( 'init-slide-top' == $initial_load_style ) {
				$init_image_load = 'fadeInDown';
			}else if( 'init-slide-bottom'== $initial_load_style ) {
				$init_image_load = 'fadeInUp';
			}else if( 'init-scale' == $initial_load_style ){	
				$init_image_load = 'zoomIn';
			}else{
				$init_image_load = $initial_load_style;
			}
		}else if( '' != $delay_load_class && 'none' == $initial_load_style ) {
			$init_image_load = 'fadeIn';
			$initial_load_style = 'fadeIn';
		}
		$hover_style = ((!isset($hover_style)) || empty($hover_style)) ? 'style1-hover' : $hover_style;
		$hover_content_color = ((!isset($hover_content_color)) || empty($hover_content_color)) ? '' : $hover_content_color;
		$default_image_style = ((!isset($default_image_style)) || empty($default_image_style)) ? 'color' : $default_image_style;
		$hover_image_style = ((!isset($hover_image_style)) || empty($hover_image_style)) ? 'color' : $hover_image_style;
		$image_effect = ((!isset($image_effect)) || empty($image_effect)) ? 'none' : $image_effect;
		$gradient_direction = ((!isset($gradient_direction)) || empty($gradient_direction)) ? 'bottom' : $gradient_direction;
		$image_source = ((!isset($image_source)) || empty($image_source)) ? 'selected' : $image_source;
		$account_name = ((!isset($account_name)) || empty($account_name)) ? 'themeforest' : $account_name;
		$item_parallax = (isset($item_parallax) && !empty($item_parallax) && intval($item_parallax) != 0) ? 'portfolio-item-parallax' : '';
		$count = ((!isset($count)) || empty($count)) ? 10 : $count;

		if( ( (!isset($hover_content_option)) || empty($hover_content_option))){
			$hover_content_option = 'icon';
		}elseif($hover_content_option == 'none'){
			$disable_hover_icon = 'hover-icon-no-show';
		} 

		
		// Changes for PhotoSwipe Gallery
		$element_class = ('photoswipe' == $lightbox_type) ? 'be-photoswipe-gallery' : '' ;
		//End 
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
		$thumb_overlay_color = $overlay_color;
		
		$gradient_color = be_compute_color( $gradient_color );
		$gradient_color = $gradient_color[1];

		$hover_content_color = be_compute_color( $hover_content_color );
		$hover_content_color = $hover_content_color[1];

		$placeholder_color = be_compute_color( $placeholder_color );
		$placeholder_color = $placeholder_color[1];


		if(isset($overlay_color) && !empty($overlay_color)) {
			if($gradient) {
				if(!isset($gradient_color) && empty($gradient_color)) {
					$gradient_color = $overlay_color;
				} 
				$gradient_style_color = 'background-image: -o-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -moz-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -webkit-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -ms-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: linear-gradient(to '.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);';
			} else {
				$gradient_style_color = 'background:'.$overlay_color;
			}
		}
		if($gutter_style == 'style2') {
			$portfolio_wrap_style = 'style="margin-left: -'.$gutter_width.'px;"';
		} else {
			$portfolio_wrap_style = 'style="margin-right: '.$gutter_width.'px;"';
		}
		$source = array (
			'source' => $image_source,
			'account_name' => $account_name, 
			'count' => $count,
			'col' => $col,
			'masonry' => $masonry
		);

		$paged  = '0';
		$images_offset = '0';

		$images_arr = $images;	
		$data_total_items = count(explode(',',$images_arr)) - $items_per_load;
		if( $lazy_load_class && 'none' != $gallery_paginate ) {
			$gallery_paginate = 'none';
		}
		if('none' != $gallery_paginate && '' != $items_per_load){
			$images_subset = array_slice(explode(',', $images), $images_offset, $items_per_load);
		}else{
			$images_subset = explode(',', $images);
		}
		$images = get_gallery_image_from_source($source, implode(",",$images_subset), $lightbox_type);
		
		if($images && is_array($images) && !isset($images['error']) && empty($images['error'])) {
			$output .= '<div class="portfolio-all-wrap  oshine-gallery-module '.$disable_hover_icon.' '.$unique_class_name.'">';
			$output .= '<div class="portfolio '. $delay_load_class .' full-screen ' . $lazy_load_class . ' full-screen-gutter '.$gutter_style.'-gutter '.$col.'-col ' . ( 0 != $masonry ? 'masonry_enable ' : '' ) . '" '.$portfolio_wrap_style.' '. ( ( $lazy_load || $delay_load ) ? ( 'data-placeholder-color="'.$placeholder_color.'"' ) : '' ) .' data-action="get_be_gallery_with_pagination" ' . ( '' != $init_image_load ? 'data-animation = "'.$init_image_load.'"' : '' ) . ' data-paged="1" data-enable-masonry="'.$masonry.'" ' . ( $maintain_order ? 'data-maintain-order = "1" ' : '' ) . 'data-aspect-ratio = "'.$aspect_ratio.'" data-source=\''.json_encode($source).'\' data-gutter-width="'.$gutter_width.'" data-images-array="'.$images_arr.'" data-col="'.$col.'" data-items-per-load="'.$items_per_load.'" data-hover-style="'.$hover_style.'" data-image-grayscale="'.$img_grayscale.'" data-lightbox-type="'.$lightbox_type.'" data-image-source="'.$image_source.'" data-image-effect="'.$image_effect.'" data-thumb-overlay-color="'.$thumb_overlay_color.'" data-grad-style-color="'.$gradient_style_color.'" data-like-button="'.$like_button.'" data-hover-content="'.$hover_content_option.'" data-hover-content-color="'.$hover_content_color.'" >';
			$output .= '<div class="portfolio-container clickable clearfix portfolio-shortcode '.$element_class.' '.$initial_load_style.' '.$item_parallax.'">';
			$output .= get_be_gallery_shortcode($images, $col, $masonry, $hover_style, $img_grayscale, $gutter_width, $lightbox_type, $image_source, $image_effect, $thumb_overlay_color, $gradient_style_color, $like_button, $hover_content_option, $hover_content_color,$enable_data_src,$delay_load,$placeholder_color); //1.9
			$output .= '</div>'; //end portfolio-container
			if('' != $items_per_load && (isset($gallery_paginate)) && 'selected' == $image_source) {
				if( $gallery_paginate == 'infinite' ) {
					$output .='<div class="trigger_infinite_scroll gallery_infinite_scroll" data-type="gallery"></div>';
				} elseif( $gallery_paginate == 'loadmore' ) {
					$output .='<div class="trigger_load_more gallery_load_more " data-total-items="'.$data_total_items.'" data-type="gallery"><a class="be-shortcode mediumbtn be-button tatsu-button rounded" href="#">'.__( 'Load More', 'oshine-modules' ).'</a></div>';
				}
			}
			$output .= '</div>'; //end portfolio
			$output .= '</div>'.$custom_style_tag; //end portfolio-all-wrap
		} else {
			if(is_array($images) && !empty($images['error'])) {
				$output .= '<p class="element-empty-message">'.$images['error'].'</p>';
			} else {
				$output .= '<p class="element-empty-message"><b>'.__('Gallery Notice : ', 'oshine-modules').'</b>'.__('Images have either not been selected or couldn\'t be found', 'oshine-modules').'</p>';
			}
		}
		return $output;
	}
	add_shortcode( 'oshine_gallery' , 'be_gallery' );
	add_shortcode( 'gallery' , 'be_gallery' );
}
if( !function_exists( 'oshine_prevent_gallery_autop' ) ) {
	function oshine_prevent_gallery_autop( $should_filter, $tag ) {
		if( 'oshine_gallery' === $tag ) {
			$should_filter = false;
		}
		return $should_filter;
	}
	add_filter( 'tatsu_shortcode_output_content_filter', 'oshine_prevent_gallery_autop', 10, 2 );
}
?>