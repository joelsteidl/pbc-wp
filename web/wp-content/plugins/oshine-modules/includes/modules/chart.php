<?php
/**************************************
			ANIMATED CHARTS
**************************************/
if (!function_exists('be_chart')) {
	function be_chart( $atts, $content ) {
		$atts = shortcode_atts( array (
			'percentage' => '70',
			'caption' => '',
			'caption_size' => '',
			'percentage_color' => '',
			'percentage_font_size' => '',
			'caption_color' => '',
			'percentage_bar_color' => '',
			'percentage_track_color' => '',
			'percentage_scale_color' => '',
			'size' => 120,
			'linewidth' => 5,
			'icon' => 'none',
			'key' => be_uniqid_base36(true),
		),$atts );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'chart', $key );
		$unique_class_name = 'tatsu-'.$key;
		$output = '';

		$style = '';
		$style = ($size) ? 'style="width: '.$size.'px;height: '.$size.'px;line-height: '.$size.'px;"' : $style ;
		if(isset($icon) && !empty($icon) && $icon != 'none') {
			$icon = '<icon class="font-icon '.$icon.'"></i>';
		} else {
			$icon = '<span class="percentage">0</span>%';
		}
		$output .= '<div class="chart-wrap oshine-module '.$unique_class_name.'">';
		$percentage_bar_color = be_compute_color($percentage_bar_color);
		$percentage_bar_color = $percentage_bar_color[1];
		$percentage_scale_color = be_compute_color($percentage_scale_color);
		$percentage_scale_color = $percentage_scale_color[1];
		$percentage_track_color = be_compute_color($percentage_track_color);
		$percentage_track_color = $percentage_track_color[1];
		$output .= '<div class="chart" data-percent="'.$percentage.'" data-bar-color="'.$percentage_bar_color.'" data-track-color="'.$percentage_track_color.'" data-scale-color="'.$percentage_scale_color.'" data-size="'.$size.'" data-line-width="'.$linewidth.'" '.$style.'>';
		$output .= '<span class="be-chart-percent" >';
		$output .= $icon;
		$output .= '</span>';
		$output .= '</div>';
		$output .= '<div><span class="be-chart-caption" >'.$caption.'</span></div>';
		$output .= $custom_style_tag;
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'chart', 'be_chart' );
}

?>