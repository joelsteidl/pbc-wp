<?php
/**
 * Plugin Name: MB Tabs
 * Plugin URI:  https://metabox.io/plugins/meta-box-tabs/
 * Description: Create tabs for meta boxes easily. Support 3 WordPress-native tab styles.
 * Version:     1.2.0
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 *
 * Copyright (C) 2010-2025 Tran Ngoc Tuan Anh. All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// Prevent loading this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! class_exists( 'MB_Tabs' ) ) {
	class MB_Tabs {
		/**
		 * Indicate that the instance of the class is working on a meta box that has tabs or not.
		 * It will be set 'true' BEFORE meta box is display and 'false' AFTER.
		 *
		 * @var bool
		 */
		protected $active = false;

		/**
		 * Store all output of fields.
		 * This is used to put fields in correct <div> for tabs.
		 * The fields' output will be get via filter 'rwmb_outer_html'.
		 *
		 * @var array
		 */
		protected $fields_output = [];

		public function __construct() {
			add_action( 'rwmb_enqueue_scripts', [ $this, 'enqueue' ] );

			add_action( 'rwmb_before', [ $this, 'opening_div' ], 1 ); // 1 = display first, before tab nav.
			add_action( 'rwmb_after', [ $this, 'closing_div' ], 100 ); // 100 = display last, after tab panels.

			// Change the title position of metabox
			add_action( 'rwmb_after', [ $this, 'show_nav' ], 20 );
			add_action( 'rwmb_after', [ $this, 'show_panels' ], 30 );

			add_filter( 'rwmb_outer_html', [ $this, 'capture_fields' ], 20, 2 );
		}

		public function enqueue( RW_Meta_Box $obj ) {
			list( , $url ) = RWMB_Loader::get_path( __DIR__ );
			wp_enqueue_style( 'rwmb-tabs', $url . 'tabs.css', [], '1.2.0' );
			wp_enqueue_script( 'rwmb-tabs', $url . 'tabs.js', [ 'jquery' ], '1.2.0', true );

			if ( empty( $obj->meta_box['tabs'] ) ) {
				return;
			}

			$tabs = (array) $obj->meta_box['tabs'];
			foreach ( $tabs as $tab_data ) {
				if ( is_string( $tab_data ) ) {
					$tab_data = [ 'label' => $tab_data ];
				}
				$tab_data = wp_parse_args( $tab_data, [
					'icon' => '',
					'label' => '',
				] );
				$strpos   = [ 'fa', 'fas', 'fa-solid', 'fab', 'fa-brand', 'far', 'fa-regular' ];
				foreach ( $strpos as $value ) {
					if ( strpos( $tab_data['icon'], $value ) !== false ) {
						wp_enqueue_style( 'font-awesome', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/all.min.css', [], ' 6.2.1' );
						return;
					}
				}
			}
		}

		/**
		 * Display opening div for tabs for meta box.
		 *
		 * @param RW_Meta_Box $obj Meta Box object.
		 */
		public function opening_div( RW_Meta_Box $obj ) {
			if ( empty( $obj->meta_box['tabs'] ) ) {
				return;
			}

			$class = 'rwmb-tabs';
			if ( isset( $obj->meta_box['tab_style'] ) && 'default' !== $obj->meta_box['tab_style'] ) {
				$class .= ' rwmb-tabs-' . $obj->meta_box['tab_style'];
			}

			if ( isset( $obj->meta_box['tab_wrapper'] ) && false === $obj->meta_box['tab_wrapper'] ) {
				$class .= ' rwmb-tabs-no-wrapper';
			}

			$tab_remember = isset( $obj->meta_box['tab_remember'] ) && $obj->meta_box['tab_remember'] ? $obj->meta_box['id'] : '';
			echo '<div class="' . esc_attr( $class ) . '" data-tab-remember="' . esc_attr( $tab_remember ) . '">';

			// Set 'true' to let us know that we're working on a meta box that has tabs.
			$this->active = true;
		}

		/**
		 * Display closing div for tabs for meta box.
		 */
		public function closing_div() {
			if ( ! $this->active ) {
				return;
			}

			echo '</div>';

			// Reset to initial state to be ready for other meta boxes.
			$this->active        = false;
			$this->fields_output = [];
		}

		/**
		 * Display tab navigation.
		 *
		 * @param RW_Meta_Box $obj Meta Box object.
		 */
		public function show_nav( RW_Meta_Box $obj ) {
			if ( ! $this->active ) {
				return;
			}

			$tabs           = $obj->meta_box['tabs'];
			$default_active = isset( $obj->tab_default_active ) ? $obj->tab_default_active : null;

			echo '<ul class="rwmb-tab-nav">';

			$i = 0;
			foreach ( $tabs as $key => $tab_data ) {
				if ( is_string( $tab_data ) ) {
					$tab_data = [ 'label' => $tab_data ];
				}
				$tab_data = wp_parse_args( $tab_data, [
					'icon' => '',
					'label' => '',
				] );

				if ( filter_var( $tab_data['icon'], FILTER_VALIDATE_URL ) ) { // If icon is an URL.
					$icon = '<img src="' . esc_url( $tab_data['icon'] ) . '">';
				} else { // If icon is icon font.
					// If icon is dashicons, auto add class 'dashicons' for users.
					if ( false !== strpos( $tab_data['icon'], 'dashicons' ) ) {
						$tab_data['icon'] .= ' dashicons';
					}
					// Remove duplicate classes.
					$tab_data['icon'] = array_filter( array_map( 'trim', explode( ' ', $tab_data['icon'] ) ) );
					$tab_data['icon'] = implode( ' ', array_unique( $tab_data['icon'] ) );

					$icon = $tab_data['icon'] ? '<i class="' . esc_attr( $tab_data['icon'] ) . '"></i>' : '';
				}

				$class = "rwmb-tab-$key";
				if ( ( $default_active && $default_active === $key ) || ( ! $default_active && ! $i ) ) {
					$class .= ' rwmb-tab-active';
				}

				printf(
					'<li class="%s" data-panel="%s"><a href="#">%s%s</a></li>',
					esc_attr( $class ),
					esc_attr( $key ),
					$icon,
					esc_html( $tab_data['label'] )
				);
				$i++;
			}

			echo '</ul>';
		}

		/**
		 * Display tab panels.
		 * Note that: this public function is hooked to 'rwmb_after', when all fields are outputted.
		 * (and captured by 'capture_fields' public function).
		 *
		 * @param RW_Meta_Box $obj Meta Box object.
		 */
		public function show_panels( RW_Meta_Box $obj ) {
			if ( ! $this->active ) {
				return;
			}

			// Store all tabs.
			$tabs = $obj->meta_box['tabs'];

			echo '<div class="rwmb-tab-panels">';
			foreach ( $this->fields_output as $tab => $fields ) {
				// Remove rendered tab.
				if ( isset( $tabs[ $tab ] ) ) {
					unset( $tabs[ $tab ] );
				}

				echo '<div class="rwmb-tab-panel rwmb-tab-panel-' . esc_attr( $tab ) . '" data-panel="' . esc_attr( $tab ) . '">';
				echo implode( '', $fields );
				echo '</div>';
			}

			// Print unrendered tabs.
			foreach ( $tabs as $tab_id => $tab_data ) {
				echo '<div class="rwmb-tab-panel rwmb-tab-panel-' . esc_attr( $tab_id ) . '">';
				echo '</div>';
			}

			echo '</div>';
		}

		/**
		 * Save field output into class variable to output later.
		 *
		 * @param string $output Field output.
		 * @param array  $field  Field configuration.
		 *
		 * @return string
		 */
		public function capture_fields( $output, $field ) {
			// If meta box doesn't have tabs, do nothing.
			if ( ! $this->active || ! isset( $field['tab'] ) ) {
				return $output;
			}

			$tab = $field['tab'];

			if ( ! isset( $this->fields_output[ $tab ] ) ) {
				$this->fields_output[ $tab ] = [];
			}
			$this->fields_output[ $tab ][] = $output;

			// Return empty string to let Meta Box plugin echoes nothing.
			return '';
		}
	}

	new MB_Tabs();
}
