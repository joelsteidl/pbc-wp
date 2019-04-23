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
				<span class = "tatsu-switch-builder-gutenburg">Edit with Gutenberg</span>
				<span class = "tatsu-switch-builder-tatsu">Edit with Tatsu</span>
			</a>
		</script>
		<script type = "text/html" id = "tatsu-gutenberg-editor-panel">
			<div id="tatsu_edit_post_wrap">
				<a href="<?php echo tatsu_edit_url( $post_id ); ?>">
					<span id="tatsu_edit_dragon_wrap">
						<svg class="tatsu-dragon" role="img">
							<use xlink:href="<?php echo esc_url( TATSU_PLUGIN_URL.'/builder/svg/tatsu.svg#icon-dragon' ); ?>"></use>
						</svg>
						<span>
							<?php echo esc_html__(  'Edit With Tatsu' , 'tatsu' ); ?>
						</span>
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
						<?php echo esc_html__( 'This post was previously edited in Tatsu. You can continue in Gutenberg, but you may lose data and formatting.', 'tatsu' ); ?>
					</p>
					<div class = "buttons">
						<a href = "<?php echo tatsu_edit_url( $post_id ); ?>" class = "button button-primary close-modal">
							<?php echo esc_html__( 'Continue with Tatsu', 'tatsu' ); ?>
						</a>
						<a href = "<?php echo $gutenberg_builder_url; ?>" class = "button">
							<?php echo esc_html__( 'Edit in Gutenberg', 'tatsu' ); ?>
						</a>
					</div>
				</div>
			</div>
		</script>
		<?php
	}
	
	public function enqueue_assets() {
		$post_id = get_the_ID();
		wp_enqueue_script( 'tatsu-gutenberg', TATSU_PLUGIN_URL . '/admin/js/tatsu-gutenberg.js', array( 'jquery' ), '1.0', true );
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
		$post_id = $_GET['post'];
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
}