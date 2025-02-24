<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Tatsu Integrations.
 *
 * Tatsu Integrations class is responsible for compatibility with
 * external plugins. The class resolves different issues with non-compatible
 * plugins.
 *
 * @since 2.6.9
 */
class Tatsu_Integrations {
    public function add_tatsu_to_addnew_dropdown() {
        global $typenow;
		?>
		<script type="text/javascript">
			document.addEventListener( 'DOMContentLoaded', function() {
				var dropdown = document.querySelector( '#split-page-title-action .dropdown' ),
                    url;
				if ( null == dropdown ) {
					return;
				}
				url = '<?php echo esc_url( tatsu_create_new_post_url( $typenow ) ); ?>';
				dropdown.insertAdjacentHTML( 'afterbegin', '<a href="' + url + '">Tatsu</a>' );
			} );
		</script>
		<?php
	}

	public function print_admin_js_template() {
        $post_id = get_the_ID();
        if( !tatsu_is_post_editable_by_current_user( $post_id ) ) {
            return;
        }
		$edited_with_tatsu = is_edited_with_tatsu($post_id);
		$change_builder_url = add_query_arg(
			array(
				'post'	=> $post_id,
				'action'	=> 'tatsu_change_builder',
				'builder'	=> $edited_with_tatsu ? 'editor' : 'tatsu'
			),
			admin_url('post.php')
		);
		$gutenberg_builder_url = add_query_arg(
			array(
				'post'	=> $post_id,
				'action'	=> 'tatsu_change_builder',
				'builder'	=>  'editor'
			),
			admin_url('post.php')
		);
		?>
		<script type = "text/html" id = "tatsu-gutenberg-switch-button">
			<a href = "<?php echo $change_builder_url; ?>" class = "button button-large <?php echo (!$edited_with_tatsu ? 'button-primary' : ''); ?>" id = "tatsu-switch-builder-button">
				<span class = "tatsu-switch-builder-gutenburg"><?php esc_html_e('Edit with Gutenberg' , 'tatsu');?></span>
				<span class = "tatsu-switch-builder-tatsu"><?php esc_html_e('Edit with Tatsu' , 'tatsu');?></span>
			</a>
		</script>
		<script type = "text/html" id = "tatsu-gutenberg-editor-panel">
			<div id="tatsu_edit_post_wrap">
				<a href="<?php echo tatsu_edit_url( $post_id ); ?>">
					<span id="tatsu_edit_dragon_wrap">
                        <svg width="120px" height="35px" viewBox="0 0 233 68" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <!-- Generator: Sketch 48.1 (47250) - http://www.bohemiancoding.com/sketch -->
                            <title>Tatsu</title>
                            <desc><?php esc_html_e('Created with Sketch.' , 'tatsu');?></desc>
                            <defs></defs>
                            <g id="Artboard" stroke="none" stroke-width="1" fill-rule="evenodd" transform="translate(-484.000000, -295.000000)">
                                <g id="Tatsu" transform="translate(483.000000, 267.000000)" >
                                    <path d="M1.953125,28.8378906 L58.4472656,28.8378906 L58.984375,45.8300781 L56.5917969,45.8300781 C55.419916,40.4915098 53.9306731,37.0166096 52.1240234,35.4052734 C50.3173738,33.7939373 46.5169561,32.9882812 40.7226562,32.9882812 L35.15625,32.9882812 L35.15625,84.1601562 C35.15625,88.0338735 35.7584575,90.4345657 36.9628906,91.3623047 C38.1673237,92.2900437 40.8040161,92.9003892 44.8730469,93.1933594 L44.8730469,95 L15.7226562,95 L15.7226562,93.1933594 C19.9544482,92.8678369 22.5911406,92.1679741 23.6328125,91.09375 C24.6744844,90.0195259 25.1953125,87.31773 25.1953125,82.9882812 L25.1953125,32.9882812 L19.6289062,32.9882812 C14.0950244,32.9882812 10.3271584,33.7857993 8.32519531,35.3808594 C6.32323218,36.9759194 4.81771338,40.4589575 3.80859375,45.8300781 L1.3671875,45.8300781 L1.953125,28.8378906 Z M87.7636719,67.9492188 C84.0201636,69.1862041 80.9277466,70.5533779 78.4863281,72.0507812 C73.7988047,74.9479312 71.4550781,78.2356587 71.4550781,81.9140625 C71.4550781,84.8763169 72.4316309,87.0572847 74.3847656,88.4570312 C75.6543032,89.3684941 77.0703047,89.8242188 78.6328125,89.8242188 C80.7812607,89.8242188 82.8401594,89.2220112 84.8095703,88.0175781 C86.7789812,86.813145 87.7636719,85.2832124 87.7636719,83.4277344 L87.7636719,67.9492188 Z M62.7636719,85.2832031 C62.7636719,80.5631274 65.1236743,76.6243647 69.84375,73.4667969 C72.8385566,71.5136621 78.8118042,68.8606938 87.7636719,65.5078125 L87.7636719,61.3574219 C87.7636719,58.0370928 87.4381543,55.725918 86.7871094,54.4238281 C85.680333,52.2428276 83.3854341,51.1523438 79.9023438,51.1523438 C78.2421792,51.1523438 76.6634189,51.5755166 75.1660156,52.421875 C73.6686123,53.3007856 72.9199219,54.5052007 72.9199219,56.0351562 C72.9199219,56.4257832 73.0013013,57.0849563 73.1640625,58.0126953 C73.3268237,58.9404343 73.4082031,59.5345039 73.4082031,59.7949219 C73.4082031,61.6178477 72.8059956,62.8873662 71.6015625,63.6035156 C70.9179653,64.0266948 70.1041714,64.2382812 69.1601562,64.2382812 C67.6953052,64.2382812 66.5722695,63.7581428 65.7910156,62.7978516 C65.0097617,61.8375603 64.6191406,60.7714902 64.6191406,59.5996094 C64.6191406,57.3209521 66.0270042,54.9365359 68.8427734,52.4462891 C71.6585427,49.9560422 75.784478,48.7109375 81.2207031,48.7109375 C87.5358389,48.7109375 91.816395,50.7616982 94.0625,54.8632812 C95.2669331,57.1093862 95.8691406,60.3808379 95.8691406,64.6777344 L95.8691406,84.2578125 C95.8691406,86.1458428 95.9993477,87.4479131 96.2597656,88.1640625 C96.6829448,89.4336001 97.5618423,90.0683594 98.8964844,90.0683594 C99.645186,90.0683594 100.263669,89.9544282 100.751953,89.7265625 C101.240237,89.4986968 102.086583,88.9453169 103.291016,88.0664062 L103.291016,90.6054688 C102.249344,91.8750063 101.126308,92.9166626 99.921875,93.7304688 C98.0989492,94.9674541 96.243499,95.5859375 94.3554688,95.5859375 C92.141916,95.5859375 90.5387419,94.8697988 89.5458984,93.4375 C88.5530549,92.0052012 88.007813,90.2962339 87.9101562,88.3105469 C85.4361855,90.4589951 83.3203213,92.0540313 81.5625,93.0957031 C78.6002456,94.8535244 75.7845186,95.7324219 73.1152344,95.7324219 C70.3157412,95.7324219 67.8906353,94.7477312 65.8398438,92.7783203 C63.7890522,90.8089094 62.7636719,88.310562 62.7636719,85.2832031 Z M133.925781,49.9804688 L133.925781,53.4960938 L123.964844,53.4960938 L123.867188,81.6210938 C123.867188,84.0950645 124.078774,85.9667905 124.501953,87.2363281 C125.283207,89.4824331 126.81314,90.6054688 129.091797,90.6054688 C130.263678,90.6054688 131.28092,90.3287788 132.143555,89.7753906 C133.006189,89.2220024 133.99088,88.343105 135.097656,87.1386719 L136.367188,88.2128906 L135.292969,89.6777344 C133.600252,91.9563916 131.809905,93.5677036 129.921875,94.5117188 C128.033845,95.4557339 126.210946,95.9277344 124.453125,95.9277344 C120.61196,95.9277344 118.007819,94.2187671 116.640625,90.8007812 C115.891923,88.9453032 115.517578,86.3737144 115.517578,83.0859375 L115.517578,53.4960938 L110.195312,53.4960938 C110.032551,53.398437 109.910482,53.3007817 109.829102,53.203125 C109.747721,53.1054683 109.707031,52.9752612 109.707031,52.8125 C109.707031,52.4869775 109.780273,52.2347014 109.926758,52.0556641 C110.073243,51.8766267 110.537105,51.4615918 111.318359,50.8105469 C113.564464,48.9550688 115.183914,47.44955 116.176758,46.2939453 C117.169601,45.1383406 119.50519,42.0866133 123.183594,37.1386719 C123.606773,37.1386719 123.859049,37.1712236 123.94043,37.2363281 C124.02181,37.3014326 124.0625,37.5455708 124.0625,37.96875 L124.0625,49.9804688 L133.925781,49.9804688 Z M146.445313,79.6191406 L148.056641,79.6191406 C148.805342,83.3300967 149.814447,86.1783755 151.083984,88.1640625 C153.362642,91.8099141 156.699197,93.6328125 161.09375,93.6328125 C163.535168,93.6328125 165.46386,92.9573635 166.879883,91.6064453 C168.295906,90.2555271 169.003906,88.5058701 169.003906,86.3574219 C169.003906,84.9902275 168.597009,83.6718813 167.783203,82.4023438 C166.969397,81.1328062 165.53712,79.8958394 163.486328,78.6914062 L158.017578,75.5664062 C154.013652,73.417958 151.067718,71.2532661 149.179688,69.0722656 C147.291657,66.8912651 146.347656,64.3196763 146.347656,61.3574219 C146.347656,57.7115703 147.649727,54.7168086 150.253906,52.3730469 C152.858086,50.0292852 156.129538,48.8574219 160.068359,48.8574219 C161.793628,48.8574219 163.689768,49.1829395 165.756836,49.8339844 C167.823904,50.4850293 168.987629,50.8105469 169.248047,50.8105469 C169.833987,50.8105469 170.25716,50.7291675 170.517578,50.5664062 C170.777996,50.403645 171.005858,50.143231 171.201172,49.7851562 L172.373047,49.7851562 L172.714844,63.4082031 L171.201172,63.4082031 C170.550127,60.2506353 169.671229,57.7929775 168.564453,56.0351562 C166.546214,52.7799316 163.632832,51.1523438 159.824219,51.1523438 C157.545562,51.1523438 155.755215,51.8522065 154.453125,53.2519531 C153.151035,54.6516997 152.5,56.2955635 152.5,58.1835938 C152.5,61.1784004 154.746071,63.8476445 159.238281,66.1914062 L165.683594,69.6582031 C172.617222,73.4342637 176.083984,77.828751 176.083984,82.8417969 C176.083984,86.6829619 174.643569,89.8242065 171.762695,92.265625 C168.881822,94.7070435 165.113956,95.9277344 160.458984,95.9277344 C158.50585,95.9277344 156.29233,95.6022168 153.818359,94.9511719 C151.344389,94.300127 149.87956,93.9746094 149.423828,93.9746094 C149.033201,93.9746094 148.691408,94.1129543 148.398438,94.3896484 C148.105467,94.6663425 147.877605,94.999998 147.714844,95.390625 L146.445313,95.390625 L146.445313,79.6191406 Z M200.664062,49.7851562 L200.664062,81.0351562 C200.664062,83.248709 200.973304,85.0227798 201.591797,86.3574219 C202.79623,88.8313926 205.00975,90.0683594 208.232422,90.0683594 C210.445975,90.0683594 212.610667,89.3359448 214.726562,87.8710938 C215.930996,87.0572876 217.151687,85.934252 218.388672,84.5019531 L218.388672,57.7441406 C218.388672,55.2376177 217.900396,53.5937539 216.923828,52.8125 C215.947261,52.0312461 213.994155,51.5592456 211.064453,51.3964844 L211.064453,49.7851562 L226.835938,49.7851562 L226.835938,84.1601562 C226.835938,86.373709 227.234697,87.8955037 228.032227,88.7255859 C228.829757,89.5556682 230.51431,89.9218755 233.085938,89.8242188 L233.085938,91.1914062 C231.295564,91.6796899 229.977218,92.0458972 229.130859,92.2900391 C228.284501,92.5341809 226.8685,92.9817676 224.882812,93.6328125 C224.036454,93.9257827 222.181004,94.6256455 219.316406,95.7324219 C219.153645,95.7324219 219.05599,95.6591804 219.023438,95.5126953 C218.990885,95.3662102 218.974609,95.1953135 218.974609,95 L218.974609,87.1386719 C216.761057,89.7754038 214.742848,91.7285093 212.919922,92.9980469 C210.152981,94.9511816 207.223323,95.9277344 204.130859,95.9277344 C201.298814,95.9277344 198.62957,94.9186299 196.123047,92.9003906 C193.583972,90.9147036 192.314453,87.5781484 192.314453,82.890625 L192.314453,57.5488281 C192.314453,54.9446484 191.761073,53.2031294 190.654297,52.3242188 C189.938147,51.7708306 188.408215,51.3802095 186.064453,51.1523438 L186.064453,49.7851562 L200.664062,49.7851562 Z"></path>
                                </g>
                            </g>
                        </svg>
						<span><?php echo esc_html__('Edit With Tatsu' , 'tatsu'); ?></span>
					</span>
				</a>			
			</div>	
		</script>
		<script type = "text/html" id = "tatsu-switch-to-gutenberg">
			<div id = "tatsu-switch-to-gutenberg-modal" class = "notification-dialog-wrap">
				<div class = "notification-dialog-background">
				</div>
				<div class = "notification-dialog">
					<p class = "message">
						<?php echo esc_html__( 'This post was previously edited in Tatsu. You can continue in Gutenberg, but you may lose data and formatting.', 'tatsu'); ?>
					</p>
					<div class = "buttons">
						<a href = "<?php echo tatsu_edit_url( $post_id ); ?>" class = "button button-primary close-modal">
							<?php echo esc_html__( 'Continue with Tatsu', 'tatsu'); ?>
						</a>
						<a href = "<?php echo $gutenberg_builder_url; ?>" class = "button">
							<?php echo esc_html__( 'Edit in Gutenberg', 'tatsu'); ?>
						</a>
					</div>
				</div>
			</div>
		</script>
		<?php
	}
	
	public function enqueue_assets() {
		$post_id = get_the_ID();
		wp_enqueue_script( 'tatsu-gutenberg', TATSU_PLUGIN_URL . '/admin/js/tatsu-gutenberg.js', array( 'jquery' ), TATSU_VERSION, true );
		$tatsu_settings = array (
			'editedWithTatsu' => is_edited_with_tatsu($post_id),
		);
		wp_localize_script( 'tatsu-gutenberg', 'TatsuGutenbergSettings', $tatsu_settings );
	}
	
	public function change_builder_mode() {
		if(empty($_GET['builder']) || empty($_GET['post'])) {
			return;
		}
		$builder_mode = $_GET['builder'];
		$post_id = be_sanitize_text_field($_GET['post']);
		$redirect_url = '';
		if( 'editor' === $builder_mode ) {
			update_post_meta( $post_id, '_edited_with', 'editor' );
			$redirect_url = add_query_arg( array(
				'post'	=> $post_id,
				'action'=> 'edit',
			), admin_url('post.php') );
		}else if('tatsu' === $builder_mode) {
			$post_status = get_post_status( $post_id );
			if( 'auto-draft' === $post_status ) {
				$post_type = get_post_type($post_id);
				$args = array(
					'post_status'	=> 'draft',
					'ID'			=> $post_id,
					'post_title'	=> 'Tatsu'
				);
				if( 'post' !== $post_type ) {
					$post_type_obj = get_post_type_object($post_type);
					$args['post_title'] .= ' ' . $post_type_obj->labels->singular_name;
				}
				$args['post_title'] .= ' #' . $post_id;
				wp_update_post( $args );
			}
			$redirect_url = tatsu_edit_url($post_id);
		}
		wp_redirect($redirect_url);
		die();
	}

    public function init() {
        // Gutenberg
        if ( function_exists( 'register_block_type' ) ) {
			add_action( 'admin_print_scripts-edit.php', array( $this, 'add_tatsu_to_addnew_dropdown' ), 11 );
			add_action( 'enqueue_block_editor_assets', array($this, 'enqueue_assets') );
			add_action( 'admin_footer', array($this, 'print_admin_js_template' ) );
			add_action( 'admin_action_tatsu_change_builder', array($this, 'change_builder_mode') );
        }
    }

	//Wordpress editor js: works with both classic and gutenberg editor 
	public function editor_scripts() {
		if ( empty( $_GET['post'] ) || ! is_numeric( $_GET['post'] ) || empty( $_GET['action'] ) || 'edit' !== sanitize_key( wp_unslash( $_GET['action'] ) ) ) {
			return;
		}
		
		$post = sanitize_key( wp_unslash( $_GET['post'] ) );
		$post = intval( $post );
		//For Rank math Content Analysis API
		if ( 0 < $post && class_exists( 'RankMath' ) && function_exists('do_shortcode') && function_exists('is_edited_with_tatsu') && is_edited_with_tatsu( $post ) ) {
			$post = get_post( $post );
			if ( empty( $post ) ) {
				return;
			}
			$post_content = $post->post_content;
			if ( ! empty( $post_content ) ) {
				$post_content = do_shortcode( $post_content );
			}
			wp_enqueue_script( 'tatsu-wordpress-editor', TATSU_PLUGIN_URL . '/admin/js/tatsu-wordpress-editor.js', array( 'wp-hooks' ), TATSU_VERSION, true );
			wp_localize_script( 
				'tatsu-wordpress-editor', 
				'TatsuWordpressEditor', 
				array (
					'post_content'	=>  $post_content
				)
			);
		}
	}
}