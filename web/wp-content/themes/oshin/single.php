<?php
/*
 *  The template for displaying a Blog Post.
 * 
 *
*/
get_header();
global $be_themes_data; 
$single_blog_style = ( isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) ? true : false;
$sidebar_flag = (array_key_exists('blog_single_sidebar', $be_themes_data) ) ?  $be_themes_data['blog_single_sidebar'] : '1' ;
$blog_style = ((!isset($be_themes_data['blog_style'])) || empty($be_themes_data['blog_style'])) ? 'style1' : $be_themes_data['blog_style'];
$sidebar = 'right';
$sidebar = ( isset($sidebar_flag) && '1' != $sidebar_flag) ? 'no' : $sidebar;
$content_single_sidebar = ( isset($sidebar_flag) && '1' != $sidebar_flag) ? '' : 'content-single-sidebar';
$enable_breadcrumb = ( isset($be_themes_data['enable_breadcrumb']) && 1 == $be_themes_data['enable_breadcrumb']) ? 1 : 0;
while ( have_posts() ) : the_post(); ?>
	<?php 
	if( $single_blog_style ) {
		get_template_part( 'blog/wide', 'single' );
	}	
	if($enable_breadcrumb){
		get_template_part( 'page-blogpost-breadcrumb' );
	}
	?>
	<section id="content" class="<?php echo esc_attr( $sidebar ); ?>-sidebar-page">
		<div id="content-wrap" class="be-wrap clearfix">
			<section id="page-content" class=" <?php echo $content_single_sidebar; ?> ">
				<div class="clearfix <?php echo esc_attr( $blog_style ); ?>-blog">
					<?php
						$blog_style = be_get_blog_loop_style( $blog_style );
						get_template_part( 'blog/loop', $blog_style );
					?>
				</div> <!--  End Page Content -->
				<div class="be-themes-comments">
					<?php comments_template( '', true ); ?>
				</div> <!--  End Optional Page Comments -->
			</section>
			<?php if ('no' != $sidebar ){?>
				<section id="<?php echo esc_attr( $sidebar ); ?>-sidebar" class="sidebar-widgets">
					<?php get_sidebar( $sidebar ); ?>
				</section>
			<?php } ?>
		</div>
	</section> <?php 
endwhile;
get_footer(); 
?>