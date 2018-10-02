<?php
/**
 * This class will make connection with Envato market API and checks the given information from the user
 *
 * @since 1.0
 *
 * @package be
 * @subpackage be-functions
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

class BEUpdater {
	private static $option_group_slug = 'be_register';

	private static $option_name = 'be_register';

	private static $option_section = 'be_start';

	private static $token;

	private static $theme_found = false;

	protected $core;

	function __construct($core)
	{
		$this->core = $core;
	}

	public function run() {
		
	   // envato_market();
		add_action('admin_init',array($this,'settings_field'));
		//add_action('wp_ajax_be_token_check',array($this, 'ajax_check'));
		add_action('wp_ajax_be_save_purchase_code',array($this, 'save_purchase_code'));

		add_action( 'wp_ajax_BS_set_memory', array($this, 'ajax_set_memory_limit'), 10, 1 );
	}

	public function settings_field() {
		register_setting(self::$option_group_slug, self::$option_name,
			array($this, 'check_token')
		);

		add_settings_field('token',
			esc_html__( 'Token', 'oshin' ),
			array($this, 'render_token_field'),
			self::$option_group_slug
		);

	}

	// public static function check_token($val) {
	// 	$old_val = get_option(self::$option_group_slug)['token'];
	// 	self::$token = $val['token'];
	// 	return $val;
	// }

	// public static function theme_found() {
	// 	global $BECore;
	// 	$themes = envato_market()->api()->themes( 'purchased' );
	// 	$theme_name = $BECore['themeName'];
	// 	foreach ($themes as $slug => $theme) {
	// 		if($theme['name'] == $theme_name) {
	// 			self::$theme_found = true;
	// 		}
	// 	}
	// 	return self::$theme_found;
	// }

	public static function options_group_name() {
		return self::$option_group_slug;
	}

	public static function set_token($val) {
		self::$token = $val;
	}

	public static function get_token() {
		return self::$token;
	}
	// public static function ajax_check() {
	// 	global $beCore;
		
	// 	$token = $_POST['token'];
	// 	update_option( self::options_group_name(), array('token'=>$token ));
	// 	echo self::matched_token();
	// 	wp_die();
	// }

	public static function save_purchase_code() {
		if ( ! check_ajax_referer( 'be_save_purchase_code', 'security' ) || empty( $_POST['token'] ) ) {
			echo '<div class="notic notic-warning ">Invalid Nonce / Empty Purchase Code</div>';
			wp_die();
		}		
		$purchase_code_data = array(
			'theme_purchase_code' => $_POST['token']
		);
		if( update_option('be_themes_purchase_data', $purchase_code_data ) ) {
			echo '<div class="notic notic-success ">Purchase Code Saved Successfully</div>';
		} else {
			echo '<div class="notic notic-warning ">Unable to Purchase Code / No Changes have been made</div>';
		}
		wp_die();
	}	

	/*public function render_token_field() {
		?>
		<input type="text" name="<?php echo esc_attr(self::$option_name); ?>[token]" class="widefat" value="<?php echo esc_html(self::$token); ?>">
		<?php
	}
	public static function matched_token() {
		global $BECore;
		$themes = envato_market()->api()->themes( 'purchased' );
		$theme_name = $BECore['themeName'];
		$plugins = envato_market()->api()->plugins();
		wp_enqueue_style('jquery-ui-core');
		if(self::$token === '' || !isset(self::$token)) {
			self::$theme_found = flase;
			echo '<div class="notic notic-warning "><p>';

			printf(esc_html__( 'Token filed is empty please enter vaild token', 'oshin' ),$theme_name);
			

			echo '</p></div>';
			return;
		}
		if(empty($themes)) {
			self::$theme_found = true;
			echo '<div class="notic notic-warning "><p>';

			printf(esc_html__( 'Token must be generated from the same themeforest account that purchassed %s', 'oshin' ),$theme_name);
			

			echo '</p></div>';
		} else {
			foreach ($themes as $slug => $theme) {
				if($theme['name'] == $theme_name) {
					echo '<div class="notic notic-success "><p>';printf(esc_html__( 'Thank you for purchasing %s', 'oshin' ),$theme_name);
					
					echo '</p></div>';
					echo envato_market_themes_column('installed');
					
				} else {
					echo '<div class="notic notic-warning "><p>';printf(esc_html__( '%s is not found in your purchase list', 'oshin' ),$theme_name);
					echo '</p></div>';

				}
			}
		}
	}*/

}
?>