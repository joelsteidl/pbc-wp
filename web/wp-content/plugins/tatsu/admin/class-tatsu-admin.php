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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tatsu-admin.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'semantic-dropdown', plugin_dir_url( __FILE__ ) . 'js/semantic-dropdown.js', array( 'jquery' ), $this->version, true );

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

	public function add_edit_in_dashboard( $post_actions, $post ) {
		if( is_edited_with_tatsu($post->ID) ) {
			$post_actions['edit_with_tatsu'] = sprintf(
				'<a href="%1$s">%2$s</a>',
				tatsu_edit_url( $post->ID ),
				esc_html__( 'Edit with Tatsu', 'tatsu' )
			);
		}
		return $post_actions;
	}

	public function add_tatsu_post_state( $post_states, $post ) {
		if( is_edited_with_tatsu($post->ID) ) {
			$post_states['tatsu'] = 'Tatsu';
		}
		if( TATSU_HEADER_CPT_NAME === $post->post_type ) {
			$active_header_id = tatsu_get_active_header_id();
			if( !empty( $active_header_id ) && $active_header_id === $post->ID ) {
				$post_states['tatsu_active_header'] = 'Tatsu Header';
			}
		}else if( TATSU_FOOTER_CPT_NAME === $post->post_type ) {
			$active_footer_id = tatsu_get_active_footer_id();
			if( !empty( $active_footer_id ) && $active_footer_id === $post->ID ) {
				$post_states['tatsu_active_footer'] = 'Tatsu Footer';
			}
		}
		return $post_states;
	}

	public function tatsu_create_new_post( $type ) {
		if ( empty( $_GET['post_type'] ) ) {
			$post_type = 'post';
		} else {
			$post_type = $_GET['post_type'];
		}
		if( post_type_exists( $post_type ) ) {
			$post_data = array(
				'post_type'		=> $post_type,
				'post_status'	=> 'publish',
			);
			if( TATSU_HEADER_CPT_NAME === $post_type ) {
				$post_data['post_title'] = 'Tatsu Header';
			}else if( TATSU_FOOTER_CPT_NAME === $post_type ) {
				$post_data['post_title'] = 'Tatsu Footer';
			}else  if( 'post' === $post_type ) {
				$post_data['post_title'] = 'Tatsu';
			}else{
				$post_type_obj = get_post_type_object($post_type);
				$post_data['post_title'] = sprintf(
					'Tatsu %s', $post_type_obj->labels->singular_name
				);
			}

			$post_id = wp_insert_post($post_data);
			if( !empty( $post_id ) ) {
				$post_data['ID'] = $post_id;
				$post_data['post_title'] .= ' #' . $post_id;
				wp_update_post($post_data);
				wp_redirect( tatsu_edit_url( $post_id ) );
			}
			die;
		}else {
			wp_die( sprintf( 'Type %s does not exist.', $post_type ) );
		}
	}

	public function tatsu_global_section_post_type(){
		if( current_theme_supports('tatsu-global-sections') ){
			$labels = array( 
				'name' => esc_html__( 'Tatsu Global Sections', 'tatsu' ),
				'singular_name' => esc_html__( 'Tatsu Global Section', 'tatsu' ),
				'add_new' => _x( 'Add Section', 'Tatsu Global Section', 'tatsu' ),
				'all_items' => esc_html__( 'All Section', 'tatsu' ),
				'add_new_item' => esc_html__( 'Add New Section', 'tatsu' ),
				'edit_item' => esc_html__( 'Edit Section', 'tatsu' ),
				'new_item' => esc_html__( 'New Section', 'tatsu' ),
				'view_item' => esc_html__( 'View Section', 'tatsu' ),
				'search_item' => esc_html__( 'Search Section', 'tatsu' ),
				'not_found' => esc_html__( 'No Sections Found', 'tatsu' ),
				'no_item_found_in_trash' => esc_html__( 'No Section Found In Trash', 'tatsu' ),
				'parent_item_colon' => esc_html__( 'Parent Section:', 'tatsu' ),
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
					'revisions'
				),
				'taxonomies' => array( 'category', 'post_tag' ),
				'menu_position' => 5,
				'exclude_from_search' =>  false,
			);
			register_post_type( 'tatsu_gsections',$args );
		}
	}

	public function tatsu_header_register_post_type() {
		if( current_theme_supports( 'tatsu-header-builder' ) ) {
			$labels = array( 
				'name' => esc_html__( 'Tatsu Headers', 'tatsu' ),
				'singular_name' => esc_html__( 'Tatsu Header', 'tatsu' ),
				'add_new' => _x( 'Add Header', 'Tatsu Header', 'tatsu' ),
				'all_items' => esc_html__( 'All Headers', 'tatsu' ),
				'add_new_item' => esc_html__( 'Add New Header', 'tatsu' ),
				'edit_item' => esc_html__( 'Edit Header', 'tatsu' ),
				'new_item' => esc_html__( 'New Header', 'tatsu' ),
				'view_item' => esc_html__( 'View Header', 'tatsu' ),
				'search_item' => esc_html__( 'Search Header', 'tatsu' ),
				'no_item_found_in_trash' => esc_html__( 'No Headers Found In Trash','tatsu' ),
			);
			$args = array( 
				'labels' => $labels,
				'public' => true,
				'has_achive' => false,
				'publicly_queryable' => true,
				'query_var' => TATSU_HEADER_CPT_NAME,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array( 
					'title',
					'editor',
					'thumbnail',
					'revisions'
				),
				'taxonomies' => array( 'category', 'post_tag' ),
				'menu_position' => 4,
				'exclude_from_search' =>  true,
			);
			register_post_type( TATSU_HEADER_CPT_NAME, $args );
		}
	}

	public function tatsu_footer_register_post_type() {
		if( current_theme_supports( 'tatsu-footer-builder' ) ) {
			$labels = array( 
				'name' => esc_html__( 'Tatsu Footers', 'tatsu' ),
				'singular_name' => esc_html__( 'Tatsu Footer', 'tatsu' ),
				'add_new' => _x( 'Add Footer', 'Tatsu Footer', 'tatsu' ),
				'all_items' => esc_html__( 'All Footers', 'tatsu' ),
				'add_new_item' => esc_html__( 'Add New Footer', 'tatsu' ),
				'edit_item' => esc_html__( 'Edit Footer', 'tatsu' ),
				'new_item' => esc_html__( 'New Footer', 'tatsu' ),
				'view_item' => esc_html__( 'View Footer', 'tatsu' ),
				'search_item' => esc_html__( 'Search Footer', 'tatsu' ),
				'no_item_found_in_trash' => esc_html__( 'No Footers Found In Trash','tatsu' ),
			);
			$args = array( 
				'labels' => $labels,
				'public' => true,
				'has_achive' => false,
				'publicly_queryable' => true,
				'query_var' => TATSU_FOOTER_CPT_NAME,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array( 
					'title',
					'editor',
					'thumbnail',
					'revisions'
				),
				'taxonomies' => array( 'category', 'post_tag' ),
				'menu_position' => 5,
				'exclude_from_search' =>  true,
			);
			register_post_type( TATSU_FOOTER_CPT_NAME, $args );
		}
	}

	public function redirect_tatsu_header_footer_builder() {
		$screen = get_current_screen();
		if ( TATSU_HEADER_CPT_NAME == $screen->id || TATSU_FOOTER_CPT_NAME == $screen->id ) {
			global $post;
			$post_id = $_GET[ 'post' ];
			if( !empty( $post_id ) ) {
				wp_redirect( tatsu_edit_url( $post_id ) );
			}
		}
	}
	
	public function add_media_edit_options($form_fields, $post) {
		$height_checked = ("1" == get_post_meta( $post->ID, 'be_themes_height_wide', true )) ? 'checked="checked"' : '';
		$width_checked = ("1" == get_post_meta( $post->ID, 'be_themes_width_wide', true )) ? 'checked="checked"' : '';
		$form_fields['be-themes-double-height'] = array(
			'label' => 'Double Height',
			'input' => 'html',
			'html'  => "<input type=\"checkbox\"
						name=\"attachments[{$post->ID}][be-themes-double-height]\"
						id=\"attachments[{$post->ID}][be-themes-double-height]\"
						value=\"1\" {$height_checked}/>",            
			'helps' => '',
		);
		$form_fields['be-themes-double-width'] = array(
			'label' => 'Double Width',
			'input' => 'html',
			'html'  => "<input type=\"checkbox\"
						name=\"attachments[{$post->ID}][be-themes-double-width]\"
						id=\"attachments[{$post->ID}][be-themes-double-width]\"
						value=\"1\" {$width_checked}/>",            
			'helps' => '',
		);
		return $form_fields;
	}

	public function add_media_save_options($post, $attachment) {
		if( isset( $attachment['be-themes-double-height'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_height_wide', 1 );
		}else {
			update_post_meta( $post['ID'], 'be_themes_height_wide', 0 );
		}

		if( isset( $attachment['be-themes-double-width'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_width_wide', 1 );
		}else {
			update_post_meta( $post['ID'], 'be_themes_width_wide', 0 );
		}

		return $post;
	}

	public function tatsu_add_customizer_options( $wp_customize ) {
		$section_name = apply_filters( 'tatsu_global_options_section', '' );
		$section = $wp_customize->get_section( $section_name );
		if( empty( $section ) ) {
			$section_name = 'tatsu_global_options';
			$wp_customize->add_section( $section_name, array(
				'title' => esc_html__( 'Global Tatsu Settings', 'tatsu' ),
			) );
		}
		do_action( 'tatsu_register_customizer_controls', $wp_customize );
		$wp_customize->add_setting( 'tatsu_google_map_id', array (
			'type'				=> 'option',
			'capability'		=> 'manage_options',
			'default' 			=> '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'tatsu_google_map_id', array (
			'type'				=> 'text',
			'section'			=> $section_name,
			'label'				=> esc_html__( 'Google Map API Key', 'tatsu' ),
			'description'		=> esc_html__( 'Please enter your Google Maps API Key', 'tatsu' ),
		) );
		$wp_customize->add_setting( 'tatsu_lazyload_bg', array (
			'type'				=> 'option',
			'capability'		=> 'manage_options',
			'default' 			=> '',
		) );
		$wp_customize->add_control( 'tatsu_lazyload_bg', array (
			'type'				=> 'checkbox',
			'section'			=> $section_name,
			'label'				=> esc_html__( 'Lazy Load Section and Column Background Images', 'tatsu' ),
		) );
		
		$wp_customize->add_setting( 'tatsu_lazyload_bg_color', array (
			'type'				=> 'option',
			'capability'		=> 'manage_options',
			'default' 			=> '#323232',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 
			'tatsu_lazyload_bg_color', 
			array(
				'label'      => esc_html__( 'Lazy Load Section/Column Placeholder Color', 'tatsu' ),
				'section'    => $section_name,
				'settings'   => 'tatsu_lazyload_bg_color',
			) ) 
		);
		if( current_theme_supports('tatsu-header-builder') ) {
			$headers = get_posts(array (
				'post_type' => TATSU_HEADER_CPT_NAME,
				'post_status' => 'publish',
				'numberposts' => -1
			));
			$headers_list[ 'none' ] = esc_html__( 'None', 'tatsu' );
			foreach($headers as $header) {
				$headers_list[$header->post_name] = $header->post_title;
			}
			$wp_customize->add_setting( 'tatsu_active_header', array (
				'type'				=> 'option',
				'capability'		=> 'manage_options',
				'default' 			=> '',
			) );
			$wp_customize->add_control( 'tatsu_active_header', array(
				'label'    => esc_html__( 'Active Header', 'tatsu' ),
				'type'     => 'select',
				'section'  => $section_name,
				'choices'  => $headers_list,
			));
		}
		if( current_theme_supports('tatsu-footer-builder') ) {
			$footers = get_posts(array (
				'post_type' => TATSU_FOOTER_CPT_NAME,
				'post_status' => 'publish',
				'numberposts' => -1
			));
			$footers_list[ 'none' ] = esc_html__( 'None', 'tatsu' );
			foreach($footers as $footer) {
				$footers_list[$footer->post_name] = $footer->post_title;
			}
			$wp_customize->add_setting( 'tatsu_active_footer', array (
				'type'				=> 'option',
				'capability'		=> 'manage_options',
				'default' 			=> '',
			) );
			$wp_customize->add_control( 'tatsu_active_footer', array(
				'label'    => esc_html__( 'Active Footer', 'tatsu' ),
				'type'     => 'select',
				'section'  => $section_name,
				'choices'  => $footers_list,
			));
		}
	}

	public function tatsu_global_section_settings(){

		if( current_theme_supports('tatsu-global-sections') ){
			add_submenu_page("options-general.php", 'Tatsu Global Sections', 'Tatsu Global Sections', 'manage_options', 'tatsu_global_section_settings' , 'tatsu_global_section_settings_options' );
		}
	}

	public function tatsu_add_global_section_settings() {
		if( current_theme_supports('tatsu-global-sections') ){
			register_setting( 'tatsu_global_section_settings', 'tatsu_global_section_data' );
		}
    }

	public function tatsu_add_gsection_meta_box_to_posts(){

		if( current_theme_supports('tatsu-global-sections') ){
			
			$post_type_array = tatsu_get_custom_post_types();

			foreach( $post_type_array as $post_type => $value ){

				add_meta_box( 
					'tatsu_global_section_on_posts',
					'Tatsu Global Section Settings',
					'tatsu_global_section_settings_on_posts_callback',
					$post_type
				);

			}
		}

	}
	


	public function tatsu_save_global_section_settings_on_posts( $post_id ) {
		
		if( current_theme_supports('tatsu-global-sections') ){
		
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

	//For Header Builder
	public function tatsu_header_options_metabox() {
		if( current_theme_supports('tatsu-header-builder') ) {
			add_meta_box(
				'tatsu_header_options', // $id
				'Header Options', // $title
				'tatsu_print_header_options' //$callback
			);
			if( !function_exists( 'tatsu_print_header_options' ) ){
				function tatsu_print_header_options(){
					global $post;  
					$meta = get_post_meta( $post->ID, '_tatsu_header_options' , true ); 
					$header_style = ( $meta && array_key_exists( 'tatsu_page_header_style' , $meta ) ) ? $meta['tatsu_page_header_style'] : '';
					$header_scheme = ( $meta && array_key_exists( 'tatsu_page_header_scheme' , $meta ) ) ? $meta['tatsu_page_header_scheme'] : '';
					$header_sticky = ( $meta && array_key_exists( 'tatsu_page_header_sticky' , $meta ) ) ? $meta['tatsu_page_header_sticky'] : '';
					$header_smart_sticky = ( $meta && array_key_exists( 'tatsu_page_header_smart' , $meta ) ) ? $meta['tatsu_page_header_smart'] : '';
					$header_auto_pad = ( $meta && array_key_exists( 'tatsu_header_auto_pad' , $meta ) ) ? $meta['tatsu_header_auto_pad'] : '';
					$header_single_page_site = ( $meta && array_key_exists( 'tatsu_header_single_page_site' , $meta ) ) ? $meta['tatsu_header_single_page_site'] : 0;
					
					?>

						<input type="hidden" name="tatsu_header_options" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
						
						<p class = "tatsu-header-metabox" >
							<label for="tatsu_page_header_style"><strong>Select Header Style:</strong></label>
							
							<select name="tatsu_page_header_style" id="tatsu_page_header_style">
									<option value="inherit" <?php selected( $header_style, 'inherit' ); ?>>Inherit Global Setting</option>
									<option value="default" <?php selected( $header_style, 'default' ); ?>>Solid</option>
									<option value="transparent" <?php selected( $header_style, 'transparent' ); ?>>Transparent</option>
							</select>
						</p>
						<p>
							<label for="tatsu_page_header_scheme"><strong>Select Scheme:</strong></label>
							
							<select name="tatsu_page_header_scheme" id="tatsu_page_header_scheme">
									<option value="inherit" <?php selected( $header_scheme, 'inherit' ); ?>>Inherit Global Setting</option>
									<option value="light" <?php selected( $header_scheme, 'light' ); ?>>Light</option>
									<option value="dark" <?php selected( $header_scheme, 'dark' ); ?>>Dark</option>
							</select>
						</p>
						<p>
							<label for="tatsu_header_auto_pad"><strong>Transparent Padding:</strong></label>
							<select name="tatsu_header_auto_pad" id="tatsu_header_auto_pad">
									<option value="yes" <?php selected( $header_auto_pad, 'yes' ); ?>>Yes</option>
									<option value="no" <?php selected( $header_auto_pad, 'no' ); ?>>No</option>
							</select>
							<div class = "description"> This setting works only when transparent header is used</div>
						</p>
						<p>
							<label for="tatsu_header_single_page_site"><strong>Single Page Site:</strong>  <input type="checkbox" name="tatsu_header_single_page_site" id="tatsu_header_single_page_site" value="1" <?php checked( $header_single_page_site, 1 ); ?> /></label>
							<div class = "description"> Turn this on if the menu has links that all point to different sections of the same page.</div>
						</p>						
				<?php
				}
			}
		}

	}

	public function tatsu_save_header_options( $post_id ) {   
		// verify nonce
		if ( !array_key_exists( 'tatsu_header_options', $_POST ) || !wp_verify_nonce( $_POST['tatsu_header_options'], basename(__FILE__) ) ) {
			return $post_id; 
		}
		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// check permissions
		if ( 'page' === $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}  
		}

		$my_data = array();
		$my_data['tatsu_page_header_style'] = $_POST['tatsu_page_header_style'];
		$my_data['tatsu_page_header_scheme'] = $_POST['tatsu_page_header_scheme'];
		$my_data[ 'tatsu_header_auto_pad' ] = $_POST['tatsu_header_auto_pad'];
		$my_data[ 'tatsu_header_single_page_site' ] = $_POST['tatsu_header_single_page_site'];

		update_post_meta( $post_id, '_tatsu_header_options', $my_data );
	}

}