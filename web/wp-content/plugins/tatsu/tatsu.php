<?php
/**
 * Plugin Name:       Tatsu
 * Plugin URI:        http://www.brandexponents.com
 * Description:       A Powerful and Elegant Live Front End Page Builder for Wordpress.
 * Version:           3.2
 * Author:            Brand Exponents
 * Author URI:        http://www.brandexponents.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tatsu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( !defined( 'TATSU_PLUGIN_URL' ) ) {
	define( 'TATSU_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( !defined( 'TATSU_PLUGIN_DIR' ) ) {
	define( 'TATSU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if( !defined( 'TATSU_VERSION' ) ) {
	define( 'TATSU_VERSION', '3.2' );
}

function activate_tatsu() {
	require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-activator.php';
	Tatsu_Activator::activate();
}


function deactivate_tatsu() {
	require_once TATSU_PLUGIN_DIR. 'includes/class-tatsu-deactivator.php';
	Tatsu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tatsu' );
register_deactivation_hook( __FILE__, 'deactivate_tatsu' );


require TATSU_PLUGIN_DIR. 'plugin-update-checker/plugin-update-checker.php';
$tatsu_update_checker = new PluginUpdateChecker_3_1 (
    'https://brandexponents.com/be-plugins/tatsu.json',
    __FILE__,
    'tatsu'
);


require TATSU_PLUGIN_DIR. 'includes/class-tatsu.php';

function run_tatsu() {

	$plugin = new Tatsu();
	$plugin->run();

}
run_tatsu();