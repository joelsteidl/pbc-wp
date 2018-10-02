<?php
/**************************************
		PORTFOLIO CAROUSEL
**************************************/
if (!function_exists('be_portfolio_carousel')) {
	function be_portfolio_carousel( $atts ) {
		global $be_themes_data;
		extract( shortcode_atts( array (
	        'category'=> '',
	        'items_per_page'=> '-1',
	        'hover_style' => 'style1-hover',
			'overlay_color' => '',
			'gradient_color' => '',
			'gradient' => '0',
			'gradient_direction' => 'bottom',
			'overlay_opacity' => '85',
			'title_style' => 'style1',
			'title_color' => '',
			'cat_color' => '',
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
			'title_animation_type' => 'none',
			'cat_animation_type' => 'none',
			'image_effect' => 'none',
			'cat_hide' => '0',
			'like_button' => 0,
			'slide_show' => '0',
			'slide_show_speed' => 4000,			
	    ) , $atts ) );
		$output = $global_thumb_overlay_color = $thumb_overlay_color = $global_gradient_style_color = $gradient_style_color = '';
		$category = explode(',', $category);
		$hover_image_style = ((!isset($hover_image_style)) || empty($hover_image_style)) ? 'color' : $hover_image_style;
		$title_animation_type = ((!isset($title_animation_type)) || empty($title_animation_type)) ? 'none' : $title_animation_type;
		$cat_animation_type = ((!isset($cat_animation_type)) || empty($cat_animation_type)) ? 'none' : $cat_animation_type;
		$image_effect = ((!isset($image_effect)) || empty($image_effect)) ? 'none' : $image_effect;
		$hover_style = ((!isset($hover_style)) || empty($hover_style)) ? 'style1-hover' : $hover_style;
		$gradient_direction = ((!isset($gradient_direction)) || empty($gradient_direction)) ? 'bottom' : $gradient_direction;

		$title_color = be_compute_color( $title_color );
		$title_color = $title_color[1];
		$cat_color = be_compute_color( $cat_color );
		$cat_color = $cat_color[1];
		$overlay_color = be_compute_color( $overlay_color );
		$overlay_color = $overlay_color[1];
		$gradient_color = be_compute_color( $gradient_color );
		$gradient_color = $gradient_color[1];

		$global_title_color = $title_color = (isset($title_color) && !empty($title_color)) ? $title_color : '';
		$global_cat_color = $cat_color = (isset($cat_color) && !empty($cat_color)) ? $cat_color : '';
		$slide_show = ( !empty( $slide_show ) ) ? 1 : 0;
		$slide_show_speed = ( !empty( $slide_show_speed ) ) ? $slide_show_speed : 4000 ;
		$global_gradient_style_color = '';

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
		if(isset($overlay_opacity) && !empty($overlay_opacity)) {
			$global_overlay_opacity = $overlay_opacity = $overlay_opacity;
		} else {
			$global_overlay_opacity = $overlay_opacity = 85;
		}
		if( isset($overlay_color) && !empty($overlay_color) ) {
			//$overlay_color = be_themes_hexa_to_rgb( $overlay_color );
			//$global_thumb_overlay_color = $thumb_overlay_color = 'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].','.(intval($global_overlay_opacity) / 100 ).')';
			if($gradient) {
				if(!isset($gradient_color) && empty($gradient_color)) {
					$gradient_color = $overlay_color;
				} 
				//$global_thumb_gradient_overlay_color = $thumb_gradient_overlay_color = 'rgba('.$gradient_color[0].','.$gradient_color[1].','.$gradient_color[2].','.(intval($global_overlay_opacity) / 100 ).')';
				$global_gradient_style_color = $gradient_style_color = 'background-image: -o-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -moz-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -webkit-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -ms-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: linear-gradient(to '.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);';
			} else {
				$global_gradient_style_color = $gradient_style_color = 'background:'.$overlay_color;
			}
			
		}
		$output .= '<div class="carousel-wrap portfolio-carousel oshine-module">';
		// $output .= '<div class="caroufredsel_wrapper clearfix"><ul class="be-carousel portfolios-carousel">';
		$output .= '<ul class="be-owl-carousel portfolio-carousel-module" data-slide-show="'.$slide_show.'" data-slide-show-speed="'.$slide_show_speed.'">';
		$items_per_page = (empty($items_per_page)) ? -1 : $items_per_page ; 
		if( empty( $category[0] ) ) {
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'orderby'=>'date',				
			);
		} else {
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'tax_query' => array(
					array(
						'taxonomy' => 'portfolio_categories',
						'field' => 'slug',
						'terms' => $category,
						'operator' => 'IN',
					)
				),
				'orderby'=>'date',
			);	
		}
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$mfp_class = '';
				$post_terms = get_the_terms( get_the_ID(), 'portfolio_categories' );
				$attachment_id = get_post_thumbnail_id(get_the_ID());
				$attachment_thumb=wp_get_attachment_image_src( $attachment_id, 'portfolio');
				$attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
				$attachment_thumb_url = $attachment_thumb[0];
				$attachment_full_url = $attachment_full[0];
				$video_url = get_post_meta( $attachment_id, 'be_themes_featured_video_url', true );
				$visit_site_url = get_post_meta( get_the_ID(), 'be_themes_portfolio_external_url', true );
				$link_to = get_post_meta( get_the_ID(), 'be_themes_portfolio_link_to', true );
				$open_with = get_post_meta( get_the_ID(), 'be_themes_portfolio_single_page_style', true );
				$single_overlay_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color', true );
				$single_overlay_opacity = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color_opacity', true );
				$single_title_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_title_color', true );
				$single_cat_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_cat_color', true );
				$attachment_info = be_wp_get_attachment($attachment_id);
				if(!isset($visit_site_url) || empty($visit_site_url)) {
					$visit_site_url = '#';
				}
				$permalink = ( $link_to == 'external_url' ) ? $visit_site_url : get_permalink();
				if(isset($single_overlay_opacity) && !empty($single_overlay_opacity)) {
					$overlay_opacity = $single_overlay_opacity;
				} else {
					$overlay_opacity = 85;
				}
				if(isset($single_overlay_color) && !empty($single_overlay_color)) {
					$single_overlay_color = be_themes_hexa_to_rgb( $single_overlay_color );
					$thumb_overlay_color = 'rgba('.$single_overlay_color[0].','.$single_overlay_color[1].','.$single_overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';
					$gradient_style_color = '';
				} else {
					$thumb_overlay_color = $global_thumb_overlay_color;
					$gradient_style_color = $global_gradient_style_color;
				}
				if(isset($single_title_color) && !empty($single_title_color)) {
					$title_color = $single_title_color;
				} else {
					$title_color = $global_title_color;
				}
				if(isset($single_cat_color) && !empty($single_cat_color)) {
					$cat_color = $single_cat_color;
				} else {
					$cat_color = $global_cat_color;
				}

				if(!empty( $video_url ) ) {
					$attachment_full_url = $video_url;
					$mfp_class = 'mfp-iframe';
				}
				if(isset($open_with) && $open_with == 'lightbox-gallery') {
					$thumb_class = 'be-lightbox-gallery mfp-image';
				} else if(isset($open_with) && $open_with == 'lightbox') {
					$thumb_class = 'mfp-image';
				} else if(isset($open_with) && $open_with == 'none') {
					$thumb_class = 'no-link';
					$attachment_full_url = '#';
				} else {
					$thumb_class = '';
					$attachment_full_url = $permalink;
				}
				if( !empty( $thumb_overlay_color ) || !empty( $gradient_style_color ) ) {
					$thumb_bg_style = 'style="background-color:'.$thumb_overlay_color.';'.$gradient_style_color.'"';
				} else {
					$thumb_bg_style = '';
				}

				$tempModalContents = '';
				if( $mfp_class === 'mfp-iframe' ){
					$video_details =  be_get_video_details($attachment_full_url);
					if(  function_exists( 'be_gdpr_privacy_ok' ) ? !be_gdpr_privacy_ok($video_details['source']) : false ){
						$mfp_class = 'mfp-popup';
						$thumb_class = '';
						$key = be_uniqid_base36(true);
						$attachment_full_url = '#gdpr-alt-lightbox-'.$key;
						$tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
					}
				}

				$trigger_animation = ($hover_style == 'style9-hover' || $hover_style == 'style10-hover') ? '' : 'animation-trigger';
				$output .='<li class="carousel-item element be-hoverlay '.$hover_style.' '.$img_grayscale.' '.$title_style.'-title"><div class="element-inner">';
				$output .= '<a href="'.$attachment_full_url.'" class="thumb-wrap '.$thumb_class.' '.$mfp_class.'" title="'.$attachment_info['title'].'">';
				$output .= '<div class="flip-wrap"><div class="flip-img-wrap '.$image_effect.'-effect"><img src="'.$attachment_thumb_url.'" alt="'.$attachment_info['alt'].'" /></div></div>';
				$output .= '<div class="thumb-overlay"><div class="thumb-bg" '.$thumb_bg_style.'>';
				$output .= '<div class="thumb-title-wrap ">';
				$output .= '<div class="thumb-title be-animate animated '.$trigger_animation.'" data-animation-type="'.$title_animation_type.'" '.( !empty( $title_color ) ? 'style="color: '.$title_color.';"' : '').'>'.get_the_title().'</div>';
				$terms = be_themes_get_taxonomies_by_id(get_the_ID(), 'portfolio_categories');
				if(!empty($terms) && empty( $cat_hide ) ) {	
					$output .= '<div class="portfolio-item-cats be-animate animated '.$trigger_animation.'" data-animation-type="'.$cat_animation_type.'" '.( !empty( $cat_color ) ? 'style="color: '.$cat_color.';"' : '').'>';
					$length = 1;
					foreach ($terms as $term) {
						$output .= '<span>'.$term->name.'</span>';
						if(count($terms) != $length) {
							$output .= '<span>&middot; </span>';
						}
						$length++;
					}
					$output .= '</div>';
				}
				$output .= '</div>';
				$output .= '</div></div>'; //End Thumb Bg & Thumb Overlay
				$output .= '</a>'; //End Thumb Wrap
				$output .= $tempModalContents;
				if(isset($open_with) && $open_with == 'lightbox-gallery') :
					$output .='<div class="popup-gallery">';
					$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
					if(!empty($attachments)) {
						foreach ( $attachments as $attachment_id ) {
							$attach_img = wp_get_attachment_image_src($attachment_id, 'full');
							$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
							$attachment_info = be_wp_get_attachment($attachment_id);
							if($video_url) {
								$url = $video_url;
								$mfp_class = 'mfp-iframe';
							} else {
								$url = $attach_img[0];
								$mfp_class ='mfp-image';
							}
							$output .='<a href="'.$url.'" class="'.$mfp_class.'" title="'.$attachment_info['title'].'"></a>';
						}
					}
					$output .= '</div>'; //End Gallery
				endif;
				$output .= '</div>';
				$output .= ($like_button != 1) ? '<div class="like-button-wrap">'.be_get_like_button(get_the_ID()).'</div>' : '';
				$output .= '</li>';
			endwhile;
		endif;
		wp_reset_postdata();
		$output .='</ul>';
		// $output .='<a class="prev be-carousel-nav" href="#"><i class="font-icon icon-arrow_carrot-left"></i></a><a class="next be-carousel-nav" href="#"><i class="font-icon icon-arrow_carrot-right"></i></a>';
		// $output .='</div>'; 'Caroufredsel Wrapper Close'
		$output .='</div>';
		return $output;
	}
	add_shortcode( 'portfolio_carousel' , 'be_portfolio_carousel' );
}
?>