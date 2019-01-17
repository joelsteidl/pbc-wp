<?php
if (!function_exists('tatsu_testimonials_carousel')) {	
	function tatsu_testimonials_carousel( $atts, $content ){
		$atts = shortcode_atts( array (
			'style'				=> 'style1',
			'font_size'			=> '20',
			'content_width'		=> '70',
			'alignment'	 		=> 'center',
			'author_font'		=> function_exists( 'typehub_get_exposed_selectors' ) ? 'h6' : false,
			'author_role_font'	=> function_exists( 'typehub_get_exposed_selectors' ) ? 'h9' : false,
			'author_color'		=> '',
			'author_role_color'	=> '',
			'dots_color'		=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
			'author_image_shadow' => '',	
			'pagination'		=> '1',
			'slide_show' 		=> '0',
			'slide_show_speed' 	=> '2000',
			'arrows'			=> '',
			'animate'			=> '0',
			'animation_type'	=> 'none',
			'animation_delay'	=> '',
			'margin'			=> '',
			'key' => be_uniqid_base36(true),
		), $atts );
		extract( $atts );

		global $tatsu_testimonial_author_font, $tatsu_testimonial_author_role_font, $tatsu_testimonial_style;

		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_testimonials_carousel', $atts['key'] );
		$unique_class_name = 'tatsu-'.$atts['key'];
		$classes = array( 'tatsu-testimonials', 'be-slider' );

		if( !empty( $style ) ) {
			$classes[] = 'tatsu-testimonial-' . $style;
		}
		if( !empty( $alignment ) ) {
			$classes[] = 'tatsu-testimonial-align-' . $alignment; 
		}else {
			$classes[] = 'tatsu-testimonial-align-center';
		}

		$tatsu_testimonial_style = $style;
		$tatsu_testimonial_author_font = !empty( $author_font ) ? $author_font : '';
		$tatsu_testimonial_author_role_font = !empty( $author_role_font ) ? $author_role_font : '';

		$adaptive_height = 'data-adaptive-height = "1"';
		$infinite = 'data-infinite = "1"';
		$pagination = !empty( $pagination ) ? 'data-dots = "1"' : '';
		$slide_show = !empty( $slide_show ) && !empty( $slide_show_speed ) ? 'data-auto-play = "'. $slide_show_speed .'"' : '';
		$arrows = !empty( $arrows ) ? 'data-arrows = "1" data-outer-arrows = "1"' : '';
		$animation_type = !empty( $animate ) && !empty( $animation_type ) && 'none' != $animation_type ? 'data-animation = "' . $animation_type . '"' : '';
		$animation_delay = !empty( $animate ) && !empty( $animation_type ) && 'none' != $animation_type ? 'data-animation-delay = "' . $animation_delay . '"' : '';
		$animate_class = !empty( $animation_type ) && 'none' != $animation_type ? ' tatsu-animate' : '';
		
		$classes = implode( ' ', $classes );

		ob_start();
		?>
			<div class = "<?php echo 'tatsu-testimonials-wrap tatsu-module clearfix ' . $unique_class_name . $animate_class;  ?>" <?php echo $animation_type . ' ' . $animation_delay; ?>> <!-- Clearfix to prevent collapsing margins -->
				<?php echo $custom_style_tag; ?>
				<div class = "<?php echo $classes; ?>" <?php echo $infinite . $adaptive_height . ' ' . $pagination . ' ' . $slide_show . ' ' . $arrows; ?> >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
		<?php
		return ob_get_clean();
	}	
}

if (!function_exists('tatsu_testimonial_carousel')) {	
	function tatsu_testimonial_carousel( $atts, $content ) {
		$atts = shortcode_atts( array (
			'author' 				=> '',
			'author_image'			=> '', 
			'author_role'			=> '',
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );

		global $tatsu_testimonial_author_font, $tatsu_testimonial_author_role_font, $tatsu_testimonial_style;

		$custom_style_tag = be_generate_css_from_atts( $atts, 'testimonial', $key );
		$unique_class_name = 'tatsu-'.$key;

		$classes = "tatsu-testimonial be-slide " . $unique_class_name;

		ob_start();
		?>
			<div class = "<?php echo $classes; ?>">
				<?php echo $custom_style_tag; ?>
				<?php if( 'style2' === $tatsu_testimonial_style ) : ?>
					<div class = "tatsu-testimonial-content">
						<?php echo do_shortcode( $content ); ?>
					</div>
					<div class = "tatsu-testimonial-author-details-wrap">
						<?php if( !empty( $author_image ) ) : ?>
							<div class = "tatsu-testimonial-author-image">
								<img src = <?php echo $author_image; ?> />
							</div>
						<?php endif; ?>
						<div class = "tatsu-testimonial-author-wrap">
							<?php if( !empty( $author ) ) : ?>
								<h6 class = "tatsu-testimonial-author <?php echo !empty( $tatsu_testimonial_author_font ) ? $tatsu_testimonial_author_font : ''; ?>">
									<?php echo $author; ?>
								</h6>
							<?php endif; ?>
							<?php if( !empty( $author_role ) ) : ?>
								<div class = "tatsu-testimonial-author-role <?php echo !empty( $tatsu_testimonial_author_role_font ) ? $tatsu_testimonial_author_role_font : ''; ?>">
									<?php echo $author_role; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php else: ?>
					<div class = "tatsu-testimonial-content-image-wrap">
						<?php if( !empty( $author_image ) ) : ?>
							<div class = "tatsu-testimonial-author-image">
								<img src = <?php echo $author_image; ?> />
							</div>
						<?php endif; ?>
						<div class = "tatsu-testimonial-content">
							<?php echo do_shortcode( $content ); ?>
						</div>
					</div>
					<div class = "tatsu-testimonial-author-details-wrap">
						<?php if( !empty( $author ) ) : ?>
							<div class = "tatsu-testimonial-author <?php echo !empty( $tatsu_testimonial_author_font ) ? $tatsu_testimonial_author_font : ''; ?>">
								<?php echo $author; ?>
							</div>
						<?php endif; ?>
						<?php if( !empty( $author_role ) ) : ?>
							<div class = "tatsu-testimonial-author-role <?php echo !empty( $tatsu_testimonial_author_role_font ) ? $tatsu_testimonial_author_role_font : ''; ?>">
								<?php echo $author_role; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php
			return ob_get_clean();
	}	
}

?>