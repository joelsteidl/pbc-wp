<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Builder {

	private $plugin_name;

	private $version;

	private $post_id;

	private $builder_mode;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	
	public function init() {
		if ( is_admin() || ! $this->is_edit_mode() ) {
			return;
		}

		if ( isset( $_GET['id'] ) ) {
			$this->post_id = $_GET['id'];
		} else {
	 		$queried_object = get_queried_object();
			$this->post_id = $queried_object->ID;
		}		

		add_filter( 'show_admin_bar', '__return_false' );

		// Remove all WordPress actions
		remove_all_actions( 'wp_head' );
		remove_all_actions( 'wp_print_styles' );
		remove_all_actions( 'wp_print_head_scripts' );
		remove_all_actions( 'wp_footer' );

		// Handle `wp_head`
		add_action( 'wp_head', 'wp_enqueue_scripts', 1 );
		add_action( 'wp_head', 'wp_print_styles', 8 );
		add_action( 'wp_head', 'wp_print_head_scripts', 9 );
		add_action( 'wp_head', array( $this, 'builder_head' ), 30 );

		// Handle `wp_footer`
		add_action( 'wp_footer', 'wp_print_footer_scripts', 20 );
		add_action( 'wp_footer', 'wp_print_media_templates' );
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );

		// Handle `wp_enqueue_scripts`
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 999999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 999999 );

		add_filter( 'body_class', array( $this, 'body_class' ) );



		// Set the headers to prevent caching for the different browsers
		nocache_headers();

		// Tell to WP Cache plugins do not cache this request.
		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}

		// Load Tatsu Index Page
		$this->builder_html_index();
		die;
	}

	private function is_edit_mode() {

		if ( ( current_user_can( 'administrator' ) || current_user_can( 'editor' ) ) && isset( $_GET['tatsu'] ) ) {
			$this->builder_mode = 'tatsu-page-builder';
			return true;
		}

		// Header Builder
		if( current_user_can( 'manage_options' ) && isset( $_GET['tatsu-header'] ) && current_theme_supports('tatsu-header-builder') ) {
			$this->builder_mode = 'tatsu-header-builder';
			return true;
		}

		return false;
	}


	private function builder_html_index() {
		include plugin_dir_path( dirname( __FILE__ ) ).'builder/tatsu-index.php' ;
	}

	private function get_shape_dividers() {
		$top_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/top/*.svg' );
		$bottom_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/bottom/*.svg' );
		$named_dividers = array();
		if( !empty( $top_shape_dividers ) ) {
			$named_dividers[ 'top' ] = array();
			foreach( $top_shape_dividers as $top_shape_divider ) {
				$svg_html = file_get_contents( $top_shape_divider );
				if( false !== $svg_html ) {
					$svg_name = basename( $top_shape_divider, '.svg' );
					$named_dividers[ 'top' ][ $svg_name ] = $svg_html;
				}
			}
		}
		if( !empty( $bottom_shape_dividers ) ) {
			$named_dividers[ 'bottom' ] = array();
			foreach( $bottom_shape_dividers as $bottom_shape_divider ) {
				$svg_html = file_get_contents( $bottom_shape_divider );
				if( false !== $svg_html ) {
					$svg_name = basename( $bottom_shape_divider, '.svg' );
					$named_dividers[ 'bottom' ][ $svg_name ] = $svg_html;
				}
			}
		}
		return !empty( $named_dividers ) ? $named_dividers : false;
	}

	public function enqueue_scripts() {
		global $wp_styles, $wp_scripts;
		$wp_styles = new \WP_Styles();
		$wp_scripts = new \WP_Scripts();

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';


		//$post_id = get_the_ID();

		wp_register_script(
			'tatsu',
			plugins_url( 'builder/js/bundle'.$suffix.'.js', dirname(__FILE__) ),
			array(),
			$this->version,
			true
		);
		wp_enqueue_script( 'tatsu' );	
		wp_enqueue_script( 'webfont-loader', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',array(),$this->version );
		wp_localize_script(
			'tatsu',
			'tatsuConfig',
			array(
				'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'shape_dividers' => $this->get_shape_dividers(), 
				'slider_icons'	=> tatsu_get_slider_icons(),
				'restapiurl' => esc_url( get_rest_url(null, '/tatsu/v1/') ),
				'wp_editor' => $this->get_wp_editor_config(),
				'post_id' => $this->post_id,
				'post_permalink' => esc_url( get_the_permalink( $this->post_id ) ),
				'post_dashboard_link' => esc_url( get_edit_post_link( $this->post_id ) ),
				'documentation_link' => esc_url( 'http://brandexponents.com/oshine-knowledgebase' ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
				'svgs' => esc_url( TATSU_PLUGIN_URL.'/builder/svg/tatsu.svg' ),
				'global_colors' => Tatsu_Colors::getInstance()->get_colors(),
				'plugin_url' => esc_url( TATSU_PLUGIN_URL ),
			)
		);

		wp_enqueue_media();

		wp_localize_script (
			'tatsu',
			'tatsuIcons',
			Tatsu_Icons::getInstance()->get_icons()
		);
		wp_localize_script (
			'tatsu',
			'tatsuSvgs',
			Tatsu_Svgs::getInstance()->get_svgs()
		);

		do_action( 'load_typehub_exposed_selectors' );

	}

	public function enqueue_styles() {
		wp_register_style(
			'tatsu_wp_editor',
			plugins_url( 'builder/css/editor-style.css', dirname(__FILE__) )
		);
		wp_enqueue_style( 'tatsu_wp_editor' );		
		wp_register_style(
			'tatsu_css',
			plugins_url( 'builder/css/master.css', dirname(__FILE__) )
		);
		wp_enqueue_style(
			'tatsu_css',
			array(),
			$this->version
		);
		wp_enqueue_style( 'tatsu-roboto-font', '//fonts.googleapis.com/css?family=Roboto:400,700|Montserrat:400', array(), null );
		Tatsu_Icons::getInstance()->enqueue_styles();
	}

	private function get_wp_editor_config() {
		remove_all_actions('before_wp_tiny_mce');
		remove_all_filters('mce_external_plugins');
		remove_all_filters('mce_buttons');
		remove_all_filters('tiny_mce_before_init');
		ob_start();
		wp_editor(
			'',
			'tatsu_editor',
			array(
				'editor_class' => 'tatsu_wp_editor',
				'quicktags' => true,
				'media_buttons' => true,
				'height' => 200,
				'textarea_rows' => 15,
				'drag_drop_upload' => true,
				'tinymce' => array(
					'content_css' => plugins_url( 'builder/css/editor-content.css', dirname(__FILE__) ),
				)
			)
		);
		return ob_get_clean();
	}

	public function builder_head() {
		do_action( 'tatsu_builder_head' );
	}

	public function wp_footer() {
		do_action( 'tatsu_builder_footer' );
	}

	public function body_class( $classes ) {
		$classes[] = $this->builder_mode;
		return $classes;
	}

}