<?php
/*****************************************************
		Portfolio Navigation
*****************************************************/
if (!function_exists('portfolio_navigation_module')) {
	function portfolio_navigation_module( $atts, $content ) {
		$atts = shortcode_atts( array (
			'style' => 'style1',
			'title_align' => 'center',
		    'nav_links_color' => '',
		    'animate' => 0,
			'animation_type'=>'fadeIn',
			'key' => be_uniqid_base36(true),
		),$atts );		

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'portfolio_navigation_module', $key );
		$unique_class_name = 'tatsu-'.$key;
		
		global $be_themes_data;
		$portfolio_home_page = get_post_meta( get_the_ID(), 'be_themes_portfolio_home_page', true); //Get link from Meta Options
		$portfolio_home_page = ($portfolio_home_page == '' ? $be_themes_data['portfolio_home_page'] : $portfolio_home_page) ; //Get link from Options panel link is not present in Meta Options
		$portfolio_catg_traversal = (1 == get_post_meta( get_the_ID(), 'be_themes_traverse_catg', true) ? true : false);
	    $output = "";
	    $style = ((!isset($style)) || empty($style)) ? 'style1' : $style;
	    $animate = ( isset( $animate ) && 1 == $animate ) ? 'be-animate' : '' ;
	    $grid_icon_background = '';
	    //$nav_links_color = '';
        if ( is_singular( 'portfolio' ) ) {
            
            if(!empty($portfolio_home_page)) {
                $url = $portfolio_home_page;
            } else {
                $url = site_url();
            }
        } else {
            $url = be_get_posts_page_url();
        }
		if((!is_page_template( 'gallery.php' )) || (!is_page_template( 'portfolio.php' ))) {
			if($style == 'style1') {
				$output .= '<div class="portfolio-nav-wrap style1-navigation oshine-module '.$animate.' align-'.$title_align.' '.$unique_class_name.'" data-animation="'.$animation_type.'" '.$nav_links_color.'>';
				// ob_start();  
				// get_template_part( 'single', 'navigation' ); 
				// $output .= ob_get_contents();  
				// ob_end_clean();
				    $output .= '<div id="nav-below" class="single-page-nav">';
				    $output .=  get_next_post_link( '%link', '<i class="font-icon icon-arrow_left" title="%title"></i>' , $portfolio_catg_traversal , '' , 'portfolio_categories');				    
				    $output .= '<a href="'.$url.'">
				    				<div class="home-grid-icon"><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span></div>
				    			</a>';
				    $output .= get_previous_post_link( '%link', '<i class="font-icon icon-arrow_right" title="%title"></i>' , $portfolio_catg_traversal , '' , 'portfolio_categories' );
				    $output .= '</div>';
					$output .= $custom_style_tag;
				$output .= '</div>';
			} else {
				$output .= '<div class="portfolio-nav-wrap oshine-module '.$animate.' '.$unique_class_name.'" data-animation="'.$animation_type.'" '.$nav_links_color.'>';
	    		$output .= '<div id="nav-below" class="single-page-nav style2-navigation">';
	    		$next_post = get_previous_post($portfolio_catg_traversal, ' ', 'portfolio_categories');
				$prev_post = get_next_post($portfolio_catg_traversal, ' ', 'portfolio_categories');
				if($prev_post) {
					$output .= '<a href="'.get_permalink($prev_post->ID).'" title="'.str_replace('"', '\'', $prev_post->post_title).'" class="previous-post-link" >
									<i class="font-icon icon-arrow-left7"></i>
									<h6>'.str_replace('"', '\'', $prev_post->post_title).'</h6>
								</a>';
				}
	        	$output .= '<a href="'.$url.'" class="portfolio-url">
	        					<div class="home-grid-icon">
	        						<span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span><span'.$grid_icon_background.'></span>
	        					</div>
	        				</a>';
	        	if($next_post) {
	        		$output .= '<a href="'.get_permalink($next_post->ID).'" title="'.str_replace('"', '\'', $next_post->post_title).'" class="next-post-link" >
	        						<h6>'.str_replace('"', '\'', $next_post->post_title).'</h6>
	        						<i class="font-icon icon-arrow-left7"></i>
	        					</a>';
	        	}
				$output .= '</div>';
				$output .= $custom_style_tag;
	    		$output .= '</div>';
			}
		}
	    return $output;
	}
	add_shortcode( 'portfolio_navigation_module', 'portfolio_navigation_module' );
}
?>