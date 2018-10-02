<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tatsu
 * @subpackage Tatsu/admin
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Tatsu_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tatsu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tatsu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tatsu-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'semantic-dropdown', plugin_dir_url( __FILE__ ) . 'css/semantic-dropdown.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tatsu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tatsu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tatsu-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'semantic-dropdown', plugin_dir_url( __FILE__ ) . 'js/semantic-dropdown.js', array( 'jquery' ), $this->version, false );

		$temp_localized_array = tatsu_get_global_sections_localize_data(); 
		wp_localize_script( $this->plugin_name, 'tatsu_global_section_data', $temp_localized_array  );
	
	}

	public function add_body_class( $classes ) {
		global $post_id;
		$edited_with = get_post_meta( $post_id, '_edited_with', true );
		if( empty( $edited_with ) ) {
			$edited_with = 'editor';
		}
		$classes .= ' edited_with_'.$edited_with;
		return $classes;
	}

	public function edit_with_tatsu_button() {
		global $post_id;
		$edited_with = get_post_meta( $post_id, '_edited_with', true );
		if( empty( $edited_with ) ) {
			$edited_with = 'editor';	
		}?>
		<input type="hidden" id="tatsu_edited_with" name="_edited_with" value="<?php echo $edited_with; ?>" /> 
		<div id="tatsu_buttons">
			<a href="<?php echo tatsu_edit_url( $post_id ); ?>" id="edit_with_tatsu_button" class="tatsu_edit_button">
				<svg class="tatsu-dragon" role="img">
					<use xlink:href="<?php echo esc_url( TATSU_PLUGIN_URL.'/builder/svg/tatsu.svg#icon-dragon' ); ?>"></use>
				</svg>
				Edit With Tatsu
			</a>
			<a href="#" id="edit_with_wordpress_editor" class="tatsu_edit_button">
				Switch To Wordpress Editor
			</a>
		</div>
		<div id="tatsu_edit_post_wrap">
			<a href="<?php echo tatsu_edit_url( $post_id ); ?>">
				<span id="tatsu_edit_dragon_wrap">
					<svg class="tatsu-dragon" role="img">
						<use xlink:href="<?php echo esc_url( TATSU_PLUGIN_URL.'/builder/svg/tatsu.svg#icon-dragon' ); ?>"></use>
					</svg>
					<span>Edit With Tatsu</span>
				</span>
			</a>			
		</div>	
	<?php	
	}

	public function tatsu_global_section_post_type(){
		$labels = array( 
			'name' => 'Global Sections',
			'singular_name' => 'Global Section',
			'add_new' => 'Add Section',
			'all_items' => 'All Section',
			'add_new_item' => 'Add New Section',
			'edit_item' => 'Edit Section',
			'new_item' => 'New Section',
			'view_item' => 'View Section',
			'search_item' => 'Search Section',
			'not_found' => 'No Sections Found',
			'no_item_found_in_trash' => 'No Section Found In Trash',
			'parent_item_colon' => 'Parent Section Colon',
	
		 );
		$args = array( 
			'labels' => $labels,
			'public' => true,
			'has_achive' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array( 
				'title',
				'editor',
				'thumbnail',
			),
			'taxonomies' => array( 'category', 'post_tag' ),
			'menu_position' => 5,
			'exclude_from_search' =>  false,
		 );
		if( get_theme_support('tatsu_global_sections') ){
			register_post_type( 'global_sections',$args );
		}
}

	public function tatsu_global_section_settings(){

		if( get_theme_support('tatsu_global_sections') ){
			add_submenu_page("options-general.php", 'Global Sections', 'Global Sections', 'manage_options', 'tatsu_global_section_settings' , 'tatsu_global_section_settings_options' );
		}
	}

	public function tatsu_add_global_section_settings() {
		if( get_theme_support('tatsu_global_sections') ){
			register_setting( 'tatsu_global_section_settings', 'tatsu_global_section_data' );
		}
    }

	public function tatsu_add_gsection_meta_box_to_posts(){

		$global_section_data = get_option( 'tatsu_global_section_data', array() );
		if( empty( $global_section_data ) ){
			$global_section_data = array();
		}else if( gettype( $global_section_data ) === 'string' ){
			$global_section_data = json_decode( $global_section_data,true );
		}
		$post_type_array =  array_key_exists( 'post_settings',$global_section_data ) ? $global_section_data['post_settings'] : array();

		if( empty( $post_type_array ) ){
            $post_type_array = array();
        }	

		foreach( $post_type_array as $post_type => $value ){

			add_meta_box( 
				'tatsu_global_section_on_posts',
				'Global Section Settings',
				'tatsu_global_section_settings_on_posts_callback',
				$post_type
			);

		}

		function tatsu_global_section_settings_on_posts_callback( $post ){

			    // Add a nonce field so we can check for it later.
				wp_nonce_field( 'tatsu_global_settings_on_post_nonce', 'tatsu_global_settings_on_post_nonce' );

				$position_values = get_post_meta(get_the_ID() , '_tatsu_global_section_on_post', true );

				$global_section_array = tatsu_get_global_sections();

				if( empty( $position_values ) ){
					$position_values = array();
				}
				$section_value_top = array_key_exists( 'top', $position_values ) ? $position_values[ 'top' ] : '';								
				$global_section_list_for_top = tatsu_get_select_box_content_post( $global_section_array, $section_value_top );

				$section_value_penultimate = array_key_exists( 'penultimate', $position_values ) ? $position_values[ 'penultimate' ] : '';			

				$global_section_list_for_penultimate = tatsu_get_select_box_content_post( $global_section_array, $section_value_penultimate );

		
				$section_value_bottom = array_key_exists( 'bottom', $position_values ) ? $position_values[ 'bottom' ] : '';	
				$global_section_list_for_bottom = tatsu_get_select_box_content_post( $global_section_array, $section_value_bottom );
	
		
		
				$title_content = '<h1> Global Section Settings </h1>';
				
				$top_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Top</label><select name="position_top"  >'.$global_section_list_for_top.'</select></div>';
				$penultimate_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Penultimate</label><select  name="position_penultimate"  >'.$global_section_list_for_penultimate.'</select></div>';
				$bottom_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Bottom</label><select name="position_bottom"  >'.$global_section_list_for_bottom.'</select></div>';
		
				echo $top_content . $penultimate_content . $bottom_content;
			}

		function tatsu_get_select_box_content_post( $global_section_array, $position_val ){

			$temp_content = '<option value="inherit" '.( $position_val === 'inherit' ? "selected" : " "  ) .'   >Inherit</option>';
			$temp_content .= '<option value="none" '.( $position_val === 'none' ? "selected" : " "  ) .'  >None</option>';
			foreach ($global_section_array as $key => $value) {
				$temp_content .= '<option value="'.$key.'" '. ( $position_val === (string) $key ? "selected" : " "  ) .' >'.$value.'</option>';
			}
			return $temp_content;
		}
	}
	


	public function tatsu_save_global_section_settings_on_posts( $post_id ) {
		
		// Check if our nonce is set.
		if ( ! isset( $_POST['tatsu_global_settings_on_post_nonce'] ) ) {
			return;
		}
	
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['tatsu_global_settings_on_post_nonce'], 'tatsu_global_settings_on_post_nonce' ) ) {
			return;
		}
	
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
	
		}
		else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
	
	

		// Sanitize user input.
		$my_data = array();
		$my_data['top'] = sanitize_text_field( $_POST['position_top'] );
		$my_data['penultimate'] = sanitize_text_field( $_POST['position_penultimate'] );
		$my_data['bottom'] = sanitize_text_field( $_POST['position_bottom'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_tatsu_global_section_on_post', $my_data );
	}
}