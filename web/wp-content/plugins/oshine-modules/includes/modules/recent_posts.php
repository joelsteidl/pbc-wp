<?php
/**************************************
			RECENT POSTS
**************************************/
if ( ! function_exists( 'be_recent_posts' ) ) {
	function be_recent_posts( $atts, $content ) {
		extract( shortcode_atts( array (
			'number'=>'three',
			'filter_by' => 'category',
			'categories' => '',
			'tags' => '',
			'hide_excerpt' => '',
	    ), $atts ) );
		if( $number == 'three' ) {
			$posts_per_page = 3;
			$column = 'third';
		} else {
			$posts_per_page = 4;
			$column = 'fourth';
		}
		$filter_by_possible_values = array( 'post_tag', 'category' );
		$filter_by = !empty( $filter_by ) && in_array( $filter_by, $filter_by_possible_values ) ? $filter_by : 'category';
		$categories = !empty( $categories ) ? explode( ',', $categories ) : '';
		$tags = !empty( $tags ) ? explode( ',', $tags ) : '';
		$hide_excerpt = (isset($hide_excerpt) && ($hide_excerpt)) ? 'hide-excerpt' : '' ;
		$terms = 'post_tag' == $filter_by ? $tags : $categories; 
		
		$tax_query = array (
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-quote' ),
				'operator' => 'NOT IN',
			),
		);
		if( !empty( $terms[0] ) ) {
			$tax_query[ 'relation' ] = 'AND';
			$tax_query[] = array (
				'taxonomy' => $filter_by,
				'field' => 'slug',
				'terms' => $terms,
				'operator' => 'IN',
			);
		}

		$args=array (
			'post_type' => 'post',
			'posts_per_page'=> $posts_per_page,
			'orderby'=>'date',
			'ignore_sticky_posts'=>1,
			'tax_query' => $tax_query
		);

		$output = '';
		global $meta_sep, $blog_attr;
		$my_query = new WP_Query( $args  );
		if( $my_query->have_posts() ) {
			$output .= '<div class="related-items oshine-recent-posts style3-blog '.$hide_excerpt.' oshine-module clearfix">';
			$blog_attr['style'] = 'shortcodes';
			$blog_attr['gutter_width'] = 0;
			while ( $my_query->have_posts() ) : $my_query->the_post(); 
				$output .= '<div class="'.$column.'-col recent-posts-col be-hoverlay">';
				ob_start();
				get_template_part( 'blog/loop', $blog_attr['style'] );
				$post_format_content = ob_get_clean();
				$output .= $post_format_content;
				$output .= '</div>'; // end column block
			endwhile;
			$output .= '</div>';
		}
		wp_reset_query();
		return $output;
	}
	add_shortcode( 'recent_posts', 'be_recent_posts' );
}
?>