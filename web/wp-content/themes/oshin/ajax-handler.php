<?php
/*
 * Ajax Request handler
 */

/* ---------------------------------------------  */
// Function for processing Blog Pagination
/* ---------------------------------------------  */
add_action( 'wp_ajax_nopriv_get_blog', 'be_themes_get_blog' );
add_action( 'wp_ajax_get_blog', 'be_themes_get_blog' );
function be_themes_get_blog() {
	extract($_POST);
	global $blog_attr;
	$blog_attr['gutter_width'] = ((!isset($_POST['gutter_width'])) || empty($_POST['gutter_width'])) ? intval(40) : intval( $_POST['gutter_width'] );
	$blog_attr['style'] = ( isset( $blog_style ) && !empty( $blog_style ) ) ? $blog_style : 'style3';
		global $wp_query;
	// alert($showposts * ( $paged - 1 ));
	// if( ( $showposts * ( $paged - 1 ) ) > $total_items ) {
	// 	return 0;
	// 	die();
	// } else {
		if(!(is_category() || is_archive() || is_tag() || is_search())) {
			// var_dump($wp_query);
			$args = array (
				'paged' => $paged,
				'post_status'=> 'publish',
				'ignore_sticky_posts'=> true
			);
			query_posts($args);
		}
		if( have_posts() ) :
			while ( have_posts() ) : the_post();
				$blog_style = be_get_blog_loop_style( $blog_attr['style'] );
				get_template_part( 'blog/loop', $blog_style );
			endwhile;
		else :
			return 0;
		endif;
		wp_reset_postdata();
		wp_reset_query();
		die();
	// }
}

?>