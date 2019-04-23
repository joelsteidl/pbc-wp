<?php

/**************************************
			TATSU - TEAM
**************************************/
if ( ! function_exists( 'tatsu_team' ) ) {
	function tatsu_team( $atts, $content ) {
		$atts = shortcode_atts( array( 
			'style'						=> 'style1',
			'title'						=> '',
			'name_font'	 				=> 'h6',
			'title_color'				=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
			'name_hover_color'			=> '',
			'image' 	 				=> '',
			'designation'				=> '',
			'designation_color'			=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
			'designation_hover_color'	=> '',
			'designation_font'			=> 'h9',
			'facebook'					=> '',
			'twitter'					=> '',
			'google_plus'				=> '',
			'instagram'					=> '',
			'linkedin'					=> '',
			'email'						=> '',
			'icon_color'				=> array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
            'icon_hover_color'			=> '',
            'title_alignment_static' 	=> 'center',
            'vertical_alignment' 		=> 'center',
			'overlay_color' 			=> array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' )),
			'animate'					=> '0',
			'animation_type'			=> 'none',
			'lazy_load'					=> '0',
			'lazy_load_bg'				=> '',
			'animation_delay'			=> '',
			'margin'					=> '0 0 20px 0',
			'key' 						=> be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_team', $key );
		$unique_class_name = 'tatsu-' . $key;

		//oshine to exponent
		$name = $title;
		$name_color = $title_color;
		$horizontal_alignment = $title_alignment_static;
		
		$classes = array( 'tatsu-team', 'tatsu-module', $unique_class_name );
		$image_classes = array();
		$image_atts = array();
		$padding = 100;
		$classes[] = !empty( $style ) ? 'tatsu-team-' . $style : 'tatsu-team-style1';
		$classes[] = !empty( $animate ) && !empty( $animation_type ) && 'none' != $animation_type ? 'be-animate' : '';
		$classes[] = !empty( $horizontal_alignment ) ? 'tatsu-team-align-' . $horizontal_alignment : 'tatsu-team-align-center';
		if( !empty( $facebook ) || !empty( $twitter ) || !empty( $google_plus ) || !empty( $instagram ) ) {
			$classes[] = 'tatsu-team-has-icons';
		}

		$data_attrs = array();
		if( !empty( $animate ) && !empty( $animation_type ) && 'none' != $animation_type ) {
			$data_attrs[] = sprintf( 'data-animation = "%s"', $animation_type );
		}

		if( !empty( $animate ) ) {
			$data_attrs[] = sprintf( 'data-animation-delay = "%d"', $animation_delay );
		}

		$has_social_icons = !empty( $facebook ) || !empty( $twitter ) || !empty( $google_plus ) || !empty( $instagram ) || !empty( $linkedin ) || !empty( $email );

		if( !empty( $lazy_load ) ) {
			$image_classes[] = 'be-lazy-load';
			$image_atts[] = 'data-src = "' . $image . '"';
			$image_id = tatsu_get_image_id_from_url( $image );
			$padding = be_get_placeholder_padding( $image_id );	
		}else {
			$image_atts[] = 'src = "' . $image . '"';
		}

		$classes = implode( ' ', $classes );
		$image_classes = implode( ' ', $image_classes );
		$image_atts = implode( ' ', $image_atts );
		ob_start();
		?>
			<div class = "<?php echo $classes; ?>" <?php echo implode( ' ', $data_attrs ); ?>>
				<?php echo $custom_style_tag; ?>
				<?php if( !empty( $image ) ) : ?>
					<div class = "tatsu-team-image">
						<?php if( !empty( $lazy_load ) ) : ?>
							<div class = "tatsu-lazy-load-placeholder" style = "padding-bottom : <?php echo $padding; ?>%">
							</div>
						<?php endif; ?>
						<img class = "<?php echo $image_classes; ?>" <?php echo $image_atts; ?> />
					</div>
				<?php endif; ?>
				<?php if( !empty( $name ) || !empty( $designation ) || $has_social_icons ) : ?>
					<div class = "tatsu-team-overlay">
						<div class = "tatsu-team-member-details">
							<?php if( !empty( $name ) || !empty( $designation ) ) : ?>
								<div class = "tatsu-team-member-name-designation">
									<?php if( '' !== $name ) : ?>
										<div class = "tatsu-team-member-name <?php echo !empty( $name_font ) ? $name_font : ''; ?>">
											<?php echo $name; ?>
										</div>
									<?php endif; ?>
									<?php if( '' !== $designation ) : ?>
										<div class = "tatsu-team-member-designation <?php echo !empty( $designation_font ) ? $designation_font : ''; ?>">
											<?php echo $designation; ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<?php if( $has_social_icons ) : ?>
								<div class = "tatsu-team-member-social-details">
									<?php if( !empty( $facebook ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $facebook; ?>" target = "_blank">
											<i class = "tatsu-icon-facebook"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $twitter ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $twitter; ?>" target = "_blank">
											<i class = "tatsu-icon-twitter"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $google_plus ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $google_plus; ?>" target = "_blank">
											<i class = "tatsu-icon-gplus"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $instagram ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $instagram; ?>" target = "_blank">
											<i class = "tatsu-icon-instagram"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $linkedin ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $linkedin; ?>" target = "_blank">
											<i class = "tatsu-icon-linkedin"></i>
										</a>
									<?php endif; ?>
									<?php if( !empty( $email ) ) : ?>
										<a class = "tatsu-team-member-social-icon" href = "<?php echo $email; ?>" target = "_blank">
											<i class = "tatsu-icon-mail2"></i>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php
			return ob_get_clean();
	}
}
?>