<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tatsu
 * @subpackage Tatsu/includes
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Tatsu {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tatsu_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'tatsu';
		$this->version = '2.6.9';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_builder_hooks();
		$this->define_rest_api_init();
		$this->define_ajax_hooks();
		$this->define_custom_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tatsu_Loader. Orchestrates the hooks of the plugin.
	 * - Tatsu_i18n. Defines internationalization functionality.
	 * - Tatsu_Admin. Defines all hooks for the admin area.
	 * - Tatsu_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-loader.php';

		/**
		 * The class that loads global configurations used across the plugin
		 */		

		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-config.php';

		/**
		 * The class that loads icon kits used by the plugin and also contains hooks for including additional icon kits
		 */			

		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-icons.php';

		/**
		 * The class that loads SVGs used by the plugin and also contains hooks for including additional SVGs
		 */			

		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-svgs.php';

		/**
		 * The class that loads global color settings used by the plugin and also contains hooks for including additional colors
		 */			

		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-colors.php';

		/**
		 * The class responsible for handling global section metas
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-global-section-meta.php';	

					/**
		 * The class responsible for registering metas
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/global-section-metas.php';
		
		/**
		 *  Helper functions used internally in different classes
		 */		

		require_once TATSU_PLUGIN_DIR.'includes/helpers/helpers.php';


		/**
		 *  Include the shortcodes and  options for all the modules included with the plugin
		 */		

		foreach( glob( TATSU_PLUGIN_DIR. 'includes/modules/*.php' ) as $module ) {
			require_once $module;
		}

		/**
		 *  Register the default font icon kit included with the plugin
		 */				

		require_once TATSU_PLUGIN_DIR. 'includes/icons/font-awesome.php';	

		/**
		 *  Register the default Linea svg kit included with the plugin
		 */				

		require_once TATSU_PLUGIN_DIR. 'includes/icons/linea.php';	

		/**
		 *  Register Section Concepts included with Tatsu
		 */				

		require_once TATSU_PLUGIN_DIR. 'includes/concepts/section-concepts.php';			

		/**
		 *  Public API functions exposed by plugin
		 */		

		require_once TATSU_PLUGIN_DIR. 'includes/helpers/api.php';
		
		/**
		 *  Helper functions used internally in different classes
		 */		

		require_once TATSU_PLUGIN_DIR.'includes/helpers/be-helpers.php';

	
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once TATSU_PLUGIN_DIR. 'admin/class-tatsu-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once TATSU_PLUGIN_DIR. 'public/class-tatsu-public.php';


		/**
		 * The class responsible for redirecting to the live page builder and loading all its assets.  
		 */		
		require_once TATSU_PLUGIN_DIR. 'builder/class-tatsu-builder.php';

		/**
		 * The class responsible for loading the page in the builder iframe.  
		 */		
		require_once TATSU_PLUGIN_DIR. 'builder/class-tatsu-frame.php';	

		/**
		 * The class responsible for registering REST API routes.  
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-rest-api.php';					

		/**
		 * The class responsible for getting the output of a shortcode & for building shortcode from atts & content
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-module.php';				

		/**
		 * The class responsible for parsing content from the old page builder and building Tatsu Page Content for the store
		 */		
		require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-content-parser.php';		

		/**
		 * The class that loads icon kits used by the plugin and also contains hooks for including additional icon kits
		 */			

		require_once TATSU_PLUGIN_DIR. 'admin/partials/tatsu-admin-display.php';

		/**
		 * The classes responsible for sending initial store data for the javascript builder and also for saving the page builder content.  
		 */
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-module-options.php';
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-page-content.php';
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-page-templates.php';					
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-store.php';
		require_once TATSU_PLUGIN_DIR. 'includes/rest_api/class-tatsu-section-concepts.php';

		$this->loader = new Tatsu_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tatsu_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tatsu_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Tatsu_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'save_post', $this, 'after_save_post' );
	//	$this->loader->add_action( 'wp_restore_post_revision', $this, 'restore_revision' );

		$this->loader->add_action( 'edit_form_after_title', $plugin_admin, 'edit_with_tatsu_button' );
		$this->loader->add_filter( 'admin_body_class', $plugin_admin, 'add_body_class' );	
		
		$this->loader->add_action( 'init', $plugin_admin, 'tatsu_global_section_post_type' );

		$this->loader->add_action( 'admin_init', $plugin_admin , 'tatsu_add_global_section_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_admin , 'tatsu_global_section_settings' );

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'tatsu_add_gsection_meta_box_to_posts' );

		$this->loader->add_action( 'save_post', $plugin_admin ,'tatsu_save_global_section_settings_on_posts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Tatsu_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_filter( 'the_content', $this, 'content_filter' );
		$this->loader->add_action( 'admin_bar_menu', $this, 'admin_bar_edit_link', 99 );

		$this->loader->add_action( 'tatsu_head', $plugin_public , 'tatsu_add_global_sections');

		$this->loader->add_action( 'tatsu_footer', $plugin_public , 'tatsu_add_global_sections' );
	}

	/**
	 * Register all of the hooks related to the page builder
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_builder_hooks() {

		$plugin_builder = new Tatsu_Builder( $this->get_plugin_name(), $this->get_version() );
		$plugin_iframe_loader = new Tatsu_Frame( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'template_redirect', $plugin_builder, 'init', 999999 );
		$this->loader->add_action( 'template_redirect', $plugin_iframe_loader, 'init',9999999 );

	}	


	/**
	 * Register all of the hooks related to the handling AJAX & REST API Requests
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	private function define_ajax_hooks() {
		$plugin_store = new Tatsu_Store();
		$this->loader->add_action( 'wp_ajax_tatsu_save_store', $plugin_store, 'ajax_save_store' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_save_store', $plugin_store, 'ajax_save_store' );

		$plugin_module = new Tatsu_Module();
		$this->loader->add_action( 'wp_ajax_tatsu_module', $plugin_module, 'ajax_get_module_shorcode_output' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_module', $plugin_module, 'ajax_get_module_shorcode_output' );

		$this->loader->add_action( 'wp_ajax_tatsu_paste_shortcode', $plugin_store, 'ajax_paste_shortcode' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_paste_shortcode', $plugin_store, 'ajax_paste_shortcode' );		


		$this->loader->add_action( 'wp_ajax_tatsu_get_images_from_id', $this, 'ajax_get_images_from_id' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_get_images_from_id', $this, 'ajax_get_images_from_id' );

		$this->loader->add_action( 'wp_ajax_tatsu_get_image', $this, 'ajax_get_image' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_get_image', $this, 'ajax_get_image' );

		$plugin_templates = Tatsu_Page_Templates::getInstance();
		$this->loader->add_action( 'wp_ajax_tatsu_get_template', $plugin_templates, 'ajax_get_template' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_get_template', $plugin_templates, 'ajax_get_template' );

		$this->loader->add_action( 'wp_ajax_tatsu_save_template', $plugin_templates, 'ajax_save_template' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_save_template', $plugin_templates, 'ajax_save_template' );

		$this->loader->add_action( 'wp_ajax_tatsu_delete_template', $plugin_templates, 'ajax_delete_template' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_delete_template', $plugin_templates, 'ajax_delete_template' );	

		$plugin_concepts =  Tatsu_Section_Concepts::getInstance();	
		$this->loader->add_action( 'wp_ajax_tatsu_get_concepts', $plugin_concepts, 'ajax_get_section_concepts' );
		$this->loader->add_action( 'wp_ajax_nopriv_tatsu_get_concepts', $plugin_concepts, 'ajax_get_section_concepts' );
	}


	/**
	 * Register all of the hooks related to the handling AJAX & REST API Requests
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	private function define_rest_api_init() {
		$plugin_rest_api = Tatsu_Rest_Api::getInstance();
		$this->loader->add_action( 'rest_api_init', $plugin_rest_api, 'register_rest_routes' );
	}

	/**
	 * Register custom hooks that can be used by themes for including their icon kits, colors and custom shortcode modules
	 *
	 * @since    1.0.0
	 * @access   private
	 */


	private function define_custom_hooks() {
		$this->loader->add_action( 'wp_loaded', Tatsu_Module_Options::getInstance() , 'setup_hooks', 11 );
		$this->loader->add_action( 'wp_loaded', Tatsu_Icons::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Colors::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Page_Templates::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Section_Concepts::getInstance() , 'setup_hooks' );
		$this->loader->add_action( 'wp_loaded', Tatsu_Svgs::getInstance() , 'setup_hooks' );
		if( get_theme_support('tatsu_global_sections') ){
			$this->loader->add_action( 'wp_loaded', Tatsu_Global_Section_Meta::getInstance(), 'setup_hooks' );
		}
	}

	/**
	 * Remove empty p and br tags added by wordpress only for shortcodes registered with tatsu
	 * @since    1.0.0
	 * @access   private
	 */

	public function content_filter( $content ) {
		// array of custom shortcodes requiring the fix 
		$all_modules = Tatsu_Module_Options::getInstance()->get_registered_modules();

		$block = join("|", $all_modules ); 
		// opening tag
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
			
		// closing tag
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
		return $rep;
	}

	/**
	 * Get Images From ID's via Admin Ajax
	 * @since    1.0.1
	 * @access   public
	 */

	public function ajax_get_images_from_id(){
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$images =  stripslashes( $_POST['images'] );
		$size =  $_POST['size'];
		if( $images ) {
			$images = json_decode( $images, true );
		}
		$image_url = array();
		foreach ($images as $id) {
			$image = wp_get_attachment_image_src( $id, $size );
			if( $image ) {
				$image_url[$id] = $image[0];
			} else {
				$image_url[$id] = '';
			}
		}

		echo json_encode($image_url);
		wp_die();
	}

	/**
	 * Get Image Url of a particular size
	 * @since    2.0
	 * @access   public
	 */

	 public function ajax_get_image() {
		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			echo 'false';
			wp_die();
		}

		$id = $_POST['id'];
		$size = $_POST['size'];
		$image = $_POST['image'];
		$upload_dir_paths = wp_upload_dir();
		if ( false !== strpos( $image, $upload_dir_paths['baseurl'] ) ) {
			$image_details = wp_get_attachment_image_src( $id, $size ); 
			if( $image_details ){
				echo $image_details[0];
			} else {
				echo $image;
			}
		} else {
			echo $image;
		}
		
		wp_die();
	 }



	/**
	 * Add an Edit with Tatsu link to the admin bar.
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	public function admin_bar_edit_link( WP_Admin_Bar $wp_admin_bar ) {
		global $post_id;
		if( !is_archive() && !is_admin() ) {
			$wp_admin_bar->add_node( array(
				'id'    => 'tatsu_edit_page',
				'title' => __( 'Edit with Tatsu', 'tatsu' ),
				'href'  => tatsu_edit_url( $post_id ),
			));	
		}
	}

	/**
	 * Save Tatsu Page Content meta in json format along with Revisions.
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	public function after_save_post( $post_id ) {
		if( array_key_exists( '_edited_with', $_POST ) ) {
			update_post_meta( $post_id, '_edited_with', $_POST['_edited_with'] );
		}

		$parent_id = wp_is_post_revision( $post_id );

		if ( $parent_id ) {

			$parent  = get_post( $parent_id );
			$tatsu_content = get_post_meta( $parent->ID, '_tatsu_page_content', true );

			if ( false !== $tatsu_content )
				add_metadata( 'post', $post_id, '_tatsu_page_content', $tatsu_content );

		}
	}

	/**
	 * Restore Tatsu Page Content meta in json format when a post revision is restored 
	 *
	 * @since    1.0.0
	 * @access   private
	 */	

	public function restore_revision( $post_id, $revision_id ) {

		$post     = get_post( $post_id );
		$revision = get_post( $revision_id );
		$tatsu_content  = get_metadata( 'post', $revision->ID, '_tatsu_page_content', true );

		if ( false !== $tatsu_content ) {
			update_post_meta( $post_id, '_tatsu_page_content', $tatsu_content );
		}
	}	


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tatsu_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}