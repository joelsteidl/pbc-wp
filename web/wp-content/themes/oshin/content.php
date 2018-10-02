<?php 
global $be_themes_data, $blog_attr;
$url = '';
if( has_post_thumbnail() ) :
	$blog_image_size = 'blog-image';
    if( $blog_attr['style'] == 'style3' ) {
    	$blog_image_size = 'portfolio-masonry';
    }
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $blog_image_size );
    $thumb_full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );    
	$url = $thumb['0'];
	$attachment_full_url = $thumb_full[0];
	$link = $attachment_full_url;
endif;
$is_wide_single = ( isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) ? true : false;
$class = '';
if((isset($be_themes_data['open_to_lightbox']) && 1 == $be_themes_data['open_to_lightbox']) ) { //|| is_single()
	$class = 'image-popup-vertical-fit mfp-image';
} else {
	if(!is_single()){
		$link = get_permalink();	
	}else{
		$link = '#';
	}
}
if( !empty( $url ) && ( !is_single() || !$is_wide_single ) ) : ?>
<div class="post-thumb">	
	<div class="">        	
		<a href="<?php echo esc_url( $link ) ?>" class="<?php echo $class; ?> thumb-wrap"><?php the_post_thumbnail( $blog_image_size ); ?>
			<div class="thumb-overlay">
				<div class="thumb-bg">
					<div class="thumb-title fadeIn animated">
						<i class="portfolio-ovelay-icon"></i>
					</div>
				</div>
			</div>
		</a>
	</div>			
</div>
<?php endif; ?>