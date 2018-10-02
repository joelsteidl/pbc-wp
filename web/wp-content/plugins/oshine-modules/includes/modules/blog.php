<?php
/**************************************
		BLOG MASONRY
**************************************/
if (!function_exists('be_blog')) {
	function be_blog( $atts ) {
		global $be_themes_data;
		extract( shortcode_atts( array (
			'col' => 'three',
			'number_of_posts' => '-1',
			'masonry_style' => 'style3',
			'filter_by' => 'category',
			'categories' => '',
			'tags' => '',
			'gutter_style' => 'style1',
			'gutter_width' => 40,
		) , $atts ) );
		$output = '';
		global $paged, $blog_attr;
		$col = ((!isset($col)) || empty($col)) ? 'three' : $col;
		$blog_attr['gutter_style'] = ((!isset($gutter_style)) || empty($gutter_style)) ? 'style1' : $gutter_style;
		$blog_attr['gutter_width'] = ((!isset($gutter_width)) || empty($gutter_width)) ? intval(40) : intval( $gutter_width );
		$blog_attr['style'] = 'shortcodes';

		if( empty( $masonry_style ) || $masonry_style == 'style3' ){
			$masonry_style = 'style3';
			$template = 'shortcodes';
			$template_class = '';
			$animation = '';
			$enable_masonry = '';
		} else {
			$masonry_style = 'style8';
			$template = 'style8';
			$template_class = 'portfolio-delay-load portfolio-lazy-load';
			$animation = 'data-animation="fadeInUp"';
			$enable_masonry = 'data-enable-masonry = 1';
		}

		$filter_by = !empty( $filter_by ) ? $filter_by : 'category';
		$categories = !empty( $categories ) ? explode( ',', $categories ) : '';
		$tags = !empty( $tags ) ? explode( ',', $tags ) : '';
		$terms = '';
		$terms = 'post_tag' == $filter_by ? $tags : $categories; 
		$posts_per_page = !empty($number_of_posts) ? $number_of_posts : get_option( 'posts_per_page' );;

		if($blog_attr['gutter_style'] == 'style2') {
			$portfolio_wrap_style = 'style="margin-left: -'.$blog_attr['gutter_width'].'px;"';
		} else {
			$portfolio_wrap_style = 'style="margin-right: '.$blog_attr['gutter_width'].'px;"';
		}
		$output .= '<div class="portfolio-all-wrap">';
		$output .= '<div class="portfolio full-screen full-screen-gutter '.$gutter_style.'-gutter '.$col.'-col '.$template_class.'" data-gutter-width="'.$blog_attr['gutter_width'].'" '.$portfolio_wrap_style.' data-col="'.$col.'" '.$animation.' '.$enable_masonry.' >';
		$output .= '<div class="'.$masonry_style.'-blog portfolio-container clickable clearfix">';
		$blog_attr['gutter_width'] = $gutter_width;

		if( !empty( $terms[0] ) ){
			$args = array( 
				'post_type' => 'post', 
				'paged' => $paged,
				'posts_per_page' => $posts_per_page,
				'tax_query' => array (
					array (
						'taxonomy' => $filter_by,
						'field' => 'slug',
						'terms' => $terms,
						'operator' => 'IN',
					)
				)
			);
		}else{
			$args = array ( 
				'post_type' => 'post', 
				'paged' => $paged,
				'posts_per_page' => $posts_per_page,
			);
		}

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) : 
			while ( $the_query->have_posts() ) : $the_query->the_post();
				ob_start();  
				get_template_part( 'blog/loop', $template );
				$output .= ob_get_contents();  
				ob_end_clean();
			endwhile;
		else:
			$output .= '<p class="inner-content">'.__( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'oshine-modules' ).'</p>';
		endif;
		$output .= '</div>'; //end portfolio-container
		$output .= ( $the_query->max_num_pages > 1 && empty( $number_of_posts ) ) ? '<div class="pagination_parent" style="margin-left: '.$blog_attr['gutter_width'].'px">'.get_be_themes_pagination($the_query->max_num_pages).'</div>' : '' ;
		$output .= '</div>';
		$output .= '</div>'; //end portfolio
		wp_reset_postdata();
		return $output;
	}
	add_shortcode( 'blog' , 'be_blog' );
}
?>