<?php 
/* Plugin Name: Groups Engine 
Plugin URI: http://groupsengine.com
Description: Groups Engine is powerful group search that actually works. To get started, activate the plugin and open the new "Groups Engine" menu. Follow the instructions on the <a href="admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide">User Guide page</a> to embed a groups page, change the color scheme and more.
Version: 1.3.4
Author: Eric Murrell (Volacious) 
Author URI: http://groupsengine.com */ 



global $wp_version;
/* ----- Plugin Updates ----- */
require 'plugin-updates/plugin-update-checker.php';
$ENMGEUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'http://pluginupdates.groupsengine.com/newupdater.json',
	__FILE__,
	'groupsengine_plugin'
);
/* ----- Install the Plugin ----- */
define ( 'ENMGE_CURRENT_VERSION', '1.3.4' );

$enmge_options = get_option( 'enm_groupsengine_options' );

register_activation_hook( __FILE__, 'enm_groupsengine_install_ms' ); 

function enm_groupsengine_install_ms( $network_wide ) { // Check for multisite

	global $wpdb;
	if ( $network_wide ) {
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			enm_groupsengine_install();

			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it
		}
		switch_to_blog($wpdb->blogid);
	} else {
		enm_groupsengine_install();
	}	

}

add_action( 'wpmu_new_blog', 'enmge_new_blog', 10, 6); // Multisite - If a new site is added		
 
function enmge_new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;
 
	if (is_plugin_active_for_network('groupsengine_plugin/groupsengine_plugin.php')) {
		$old_blog = $wpdb->blogid;
		switch_to_blog($blog_id);
		enm_groupsengine_install();

		$data = get_option( 'enm_groupsengine_options' ); ;	
		$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
		ob_start(); // Capture all output (output buffering)
		include($css_dir . 'ge_styles_generate.php'); // Generate CSS
		$css = ob_get_clean(); // Get generated CSS (output buffering)
		file_put_contents($css_dir . 'ge_' . $blog_id . '_styles.css', $css, LOCK_EX); // Save it
		switch_to_blog($old_blog);
	}
}

function enm_groupsengine_install() { 
	include('includes/core/install.php');
}

/* ----- Uninstall the Plugin ----- */

function enm_groupsengine_uninstall_ms() { // Check for multisite

	global $wpdb;
	if (function_exists('is_multisite') && is_multisite()) {
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			enm_groupsengine_uninstall();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		enm_groupsengine_uninstall();
	}	

}

function enm_groupsengine_uninstall() { 
	delete_option('enm_groupsengine_options'); 
	delete_option('enmge_db_version');
	global $wpdb;
	$dcnmatches = $wpdb->prefix . "ge_contact_notes";
	$dcontacts = $wpdb->prefix . "ge_contacts";
	$dfiles = $wpdb->prefix . "ge_files";
	$dgfmatches = $wpdb->prefix . "ge_group_file_matches";
	$dggtmatches = $wpdb->prefix . "ge_group_group_type_matches";
	$dglmatches = $wpdb->prefix . "ge_group_location_matches";
	$dgtmatches = $wpdb->prefix . "ge_group_topic_matches";
	$dgrouptypes = $wpdb->prefix . "ge_group_types";
	$dgroups = $wpdb->prefix . "ge_groups";
	$dlocations = $wpdb->prefix . "ge_locations";
	$dtopics = $wpdb->prefix . "ge_topics";
	$dleaders = $wpdb->prefix . "ge_leaders";
	$dlematches = $wpdb->prefix . "ge_group_leader_matches";
	$wpdb->query("DROP TABLE IF EXISTS $dcnmatches, $dcontacts, $dfiles, $dgfmatches, $dggtmatches, $dglmatches, $dgtmatches, $dgrouptypes, $dgroups, $dlocations, $dtopics, $dleaders, $dlematches");
}; 

/* ----- Create the Admin Menus ----- */

add_action( 'admin_menu', 'enm_groupsengine_create_menu' );

function enm_groupsengine_create_menu() { 

	$ge_options = get_option( 'enm_groupsengine_options' );

	$locationptitle = $ge_options['locationptitle'];

	$topicptitle = $ge_options['topicptitle'];

	$grouptypeptitle = $ge_options['grouptypeptitle'];

	add_menu_page( 
		'Add and Edit Groups', 
		'Groups Engine', 
		'edit_posts', 
		__FILE__, 
		'enm_groupsengine_groups_page', 
		plugins_url( '/images/blank.png', __FILE__ )
	); 

	add_submenu_page( __FILE__, 'Add and Edit ' . $locationptitle, 'Edit ' . $locationptitle, 'edit_posts', __FILE__ . '_locations', 'enm_groupsengine_locations_page'); 
	add_submenu_page( __FILE__, 'Add and Edit ' . $topicptitle, 'Edit ' . $topicptitle, 'edit_posts', __FILE__ . '_topics', 'enm_groupsengine_topics_page'); 
	add_submenu_page( __FILE__, 'Add and Edit ' . $grouptypeptitle, 'Edit ' . $grouptypeptitle, 'edit_posts', __FILE__ . '_grouptypes', 'enm_groupsengine_grouptypes_page'); 
	add_submenu_page( __FILE__, 'View and Update Contacts', 'View Contacts', 'edit_posts', __FILE__ . '_contacts', 'enm_groupsengine_contacts_page'); 
	add_submenu_page( __FILE__, 'Embed Groups Engine on a Page', 'Get Shortcodes', 'edit_pages', __FILE__ . '_embed', 'enm_groupsengine_embedcode_page'); 
	add_submenu_page( __FILE__, 'Report Library', 'Report Library', 'edit_posts', __FILE__ . '_reports', 'enm_groupsengine_reportlibrary_page'); 
	add_submenu_page( __FILE__, 'User Guide', 'User Guide', 'edit_posts', __FILE__ . '_userguide', 'enm_groupsengine_userguide_page'); 
	//add_submenu_page( __FILE__, 'Check for Updates to the Groups Engine Plugin', 'Check for Updates', 'edit_pages', __FILE__ . '_updates', 'enm_groupsengine_update_page'); 
}

/* Admin Menu - Groups Page */

function enm_groupsengine_groups_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/groups.php'); 
}

/* Admin Menu - Locations Page */

function enm_groupsengine_locations_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/locations.php'); 
}

/* Admin Menu - Topics Page */

function enm_groupsengine_topics_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/topics.php'); 
}

/* Admin Menu - Group Types Page */

function enm_groupsengine_grouptypes_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/grouptypes.php'); 
}

/* Admin Menu - Contacts Page */

function enm_groupsengine_contacts_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/contacts.php'); 
}

/* Admin Menu - Embed Code */

function enm_groupsengine_embedcode_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed.php'); 
}

/* Admin Menu - Report Library */

function enm_groupsengine_reportlibrary_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/reports.php'); 
}

/* Admin Menu - User Guide */

function enm_groupsengine_userguide_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/userguide.php'); 
}

/* Admin Menu - Check for Updates */

function enm_groupsengine_update_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/update.php'); 
}



/* Setup admin panel */

add_action('admin_enqueue_scripts', 'enm_groupsengine_admin_enqueue');

function enm_groupsengine_admin_enqueue() {
	wp_enqueue_media();
	// Add stylesheet
	global $wp_version;

	wp_register_style( 'GroupsengineAdminStylesheet', plugins_url('/css/ge_backend.css', __FILE__) );
	wp_enqueue_style( 'GroupsengineAdminStylesheet' );

	wp_register_script( 'GroupsEngineBackendJavascript', plugins_url('/js/backend.js', __FILE__) );
	wp_enqueue_script( 'GroupsEngineBackendJavascript' );
	wp_localize_script( 'GroupsEngineBackendJavascript', 'geajax',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-ui-droppable' );

}

add_action('init', 'enm_groupsengine_add_jquery'); 

function enm_groupsengine_add_jquery() {
	wp_enqueue_script( 'jquery' );
}

/* ----- Generate Static Stylesheet ----- */

function generate_ge_options_css($newdata) {

	$data = $newdata;	
	$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
	ob_start(); // Capture all output (output buffering)

	include($css_dir . 'ge_styles_generate.php'); // Generate CSS

	$css = ob_get_clean(); // Get generated CSS (output buffering)

	if(is_multisite()) { 
		global $current_blog;
		file_put_contents($css_dir . 'ge_' . $current_blog->blog_id . '_styles.css', $css, LOCK_EX); // Save it
	} else {
		file_put_contents($css_dir . 'ge_styles.css', $css, LOCK_EX); // Save it
	}
	
}

/* ----- Modify User Theme to Add Stylesheets and JavaScript ----- */

add_action('template_redirect', 'enm_groupsengine_frontend_styles'); 

function enm_groupsengine_frontend_styles() {
	$ge_options = get_option( 'enm_groupsengine_options' );
	if ( isset($ge_options['ajax']) ) {
		$ge_noajax = $ge_options['ajax'];
	} else {
		$ge_noajax = 0;
	}
	if ( $ge_noajax == 0 ) {
		wp_register_script( 'GroupsEngineFrontendJavascript', plugins_url('/js/groupsenginefrontendnoajax.js', __FILE__) );
		wp_enqueue_script( 'GroupsEngineFrontendJavascript' );
		wp_localize_script( 'GroupsEngineFrontendJavascript', 'geajax',
            array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	} else {
		wp_register_script( 'GroupsEngineFrontendJavascript', plugins_url('/js/groupsenginefrontend130.js', __FILE__) );
		wp_enqueue_script( 'GroupsEngineFrontendJavascript' );
		wp_localize_script( 'GroupsEngineFrontendJavascript', 'geajax',
            array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	if(is_multisite()) { 
		global $current_blog;
		wp_register_style( 'GroupsEngineFrontendStyles', plugins_url('/css/ge_' . $current_blog->blog_id . '_styles.css', __FILE__) );
		wp_enqueue_style( 'GroupsEngineFrontendStyles' );
	} else {
		wp_register_style( 'GroupsEngineFrontendStyles', plugins_url('/css/ge_styles.css', __FILE__) );
		wp_enqueue_style( 'GroupsEngineFrontendStyles' );
	}
	

}

/* ----- Add IE Code to Header ----- */

add_action ( 'wp_head', 'enmge_ie_compatibility' );

function enmge_ie_compatibility()
{
    echo '<!-- Display fixes for Internet Explorer -->
	<!--[if IE 8]>
	<link href="' . plugins_url() .'/groupsengine_plugin/css/ie8_fix.css' . '" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!-- end display fixes for Internet Explorer -->';
}

/* ----- Additional Image Sizes ----- */

$ge_options = get_option( 'enm_groupsengine_options' );
$ge_image_width = $ge_options['imagewidth'];

add_image_size('Groups Engine Image', $ge_image_width);
/*update_option('image_default_link_type' , '');
*/

function enmge_insert_custom_image_sizes( $sizes ) {
    // get the custom image sizes
    global $_wp_additional_image_sizes;
    // if there are none, just return the built-in sizes
    if ( empty( $_wp_additional_image_sizes ) )
        return $sizes;

    // add all the custom sizes to the built-in sizes
    foreach ( $_wp_additional_image_sizes as $id => $data ) {
        // take the size ID (e.g., 'my-name'), replace hyphens with spaces,
        // and capitalise the first letter of each word
        if ( !isset($sizes[$id]) )
            $sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
    }

    return $sizes;
}

add_filter( 'image_size_names_choose', 'enmge_insert_custom_image_sizes' );


/* ----- Register Group Shortcodes ----- */

// Register a new shortcode: [groupsengine] 
add_shortcode( 'groupsengine', 'enm_groupsengine_embedgroups' ); // The callback function that will replace [groupsengine] 

function enm_groupsengine_embedgroups() {
	ob_start(); // do it this way to render within page content
	$enmge_lo = 0;
	$enmge_a = 0;
	$enmge_de = 0;
	$enmge_xd = 0;
	include(plugin_dir_path( __FILE__ ) . 'includes/displaygroups.php'); 
	$content = ob_get_clean();
	return $content; 
}

// Register a new shortcode: [groupsengine_wo] 
add_shortcode( 'groupsengine_wo', 'enm_groupsengine_embedgroups_options' ); // The callback function that will replace [groupsengine_wo] 

function enm_groupsengine_embedgroups_options( $attr ) {
	ob_start(); // do it this way to render within page content
	$enmge_lo = 1;

	if ( isset($attr['enmge_gid']) ) { 
		$enmge_fgid = $attr['enmge_gid'];
	} else {
		$enmge_fgid = 0;
	}
	
	if ( isset($attr['enmge_gtid']) ) { 
		$enmge_fgtid = $attr['enmge_gtid'];
	} else {
		$enmge_fgtid = 0;
	}

	if ( isset($attr['enmge_tid']) ) { 
		$enmge_ftid = $attr['enmge_tid'];
	} else {
		$enmge_ftid = 0;
	}

	if ( isset($attr['enmge_lid']) ) { 
		$enmge_flid = $attr['enmge_lid'];
	} else {
		$enmge_flid = 0;
	}

	if ( isset($attr['enmge_m']) ) { 
		$enmge_fm = $attr['enmge_m'];
	} else {
		$enmge_fm = 2;
	}

	if ( isset($attr['enmge_d']) ) { 
		$enmge_fd = $attr['enmge_d'];
	} else {
		$enmge_fd = 0;
	}

	if ( isset($attr['enmge_st']) ) { 
		$enmge_fst = $attr['enmge_st'];
	} else {
		$enmge_fst = 0;
	}

	if ( isset($attr['enmge_et']) ) { 
		$enmge_fet = $attr['enmge_et'];
	} else {
		$enmge_fet = 0;
	}

	if ( isset($attr['enmge_sa']) ) { 
		$enmge_fsa = $attr['enmge_sa'];
	} else {
		$enmge_fsa = 0;
	}

	if ( isset($attr['enmge_ea']) ) { 
		$enmge_fea = $attr['enmge_ea'];
	} else {
		$enmge_fea = 0;
	}

	if ( isset($attr['enmge_z']) ) { 
		$enmge_fz = $attr['enmge_z'];
	} else {
		$enmge_fz = 0;
	}

	if ( isset($attr['enmge_v']) ) { 
		$enmge_fv = $attr['enmge_v'];
	} else {
		$enmge_fv = 0;
	}

	// Center zoom

	if ( isset($attr['enmge_cz']) ) { 
		$enmge_fcz = $attr['enmge_cz'];
	} else {
		$enmge_fcz = 0;
	}

	if ( isset($attr['enmge_zl']) ) { 
		$enmge_fzl = $attr['enmge_zl'];
	} else {
		$enmge_fzl = 0;
	}

	// Disable options

	if ( isset($attr['enmge_vo']) ) { // view toggle
		$enmge_fvo = 0;
	} else {
		$enmge_fvo = 1;
	}

	if ( isset($attr['enmge_cl']) ) { // contact group leader
		$enmge_fcl = 0;
	} else {
		$enmge_fcl = 1;
	}

	if ( isset($attr['enmge_gl']) ) { // group list from single group
		$enmge_fgl = 0;
	} else {
		$enmge_fgl = 1;
	}

	if ( isset($attr['enmge_fo']) ) { // search
		$enmge_ffo = 2;
	} else {
		$enmge_ffo = 0;
	}

	if ( isset($attr['enmge_sm']) ) { // show individual maps
		$enmge_fsm = 0;
	} else {
		$enmge_fsm = 1;
	}

	if ( isset($attr['enmge_pag']) ) { // number of groups per page
		$enmge_fpag = $attr['enmge_pag'];
	} else {
		$enmge_fpag = 0;
	}

	if ( isset($attr['enmge_start']) ) { // limit search depending on group start date.
		$enmge_fstart = $attr['enmge_start'];
	} else {
		$enmge_fstart = 0;
	}

	if ( isset($attr['enmge_sort']) ) { // group list sorting
		$enmge_fsort = $attr['enmge_sort'];
	} else {
		$enmge_fsort = 0;
	}

	if ( isset($attr['enmge_status']) ) { // group status
		$enmge_fstatus = $attr['enmge_status'];
	} else {
		$enmge_fstatus = 'n';
	}

	if ( isset($attr['enmge_xgt']) ) { // limit group type search
		$enmge_fxgt = 1;
	} else {
		$enmge_fxgt = 0;
	}

	if ( isset($attr['enmge_xt']) ) { // limit topic search
		$enmge_fxt = 1;
	} else {
		$enmge_fxt = 0;
	}

	if ( isset($attr['enmge_xl']) ) { // limit location search
		$enmge_fxl = 1;
	} else {
		$enmge_fxl = 0;
	}

	if ( isset($attr['enmge_xm']) ) { // limit meeting search
		$enmge_fxm = 1;
	} else {
		$enmge_fxm = 0;
	}

	if ( isset($attr['enmge_xd']) ) { // limit day search
		$enmge_fxd = 1;
	} else {
		$enmge_fxd = 0;
	}

	if ( isset($attr['enmge_xst']) ) { // limit time search
		$enmge_fxst = 1;
	} else {
		$enmge_fxst = 0;
	}

	if ( isset($attr['enmge_xsa']) ) { // limit age search
		$enmge_fxsa = 1;
	} else {
		$enmge_fxsa = 0;
	}

	if ( isset($attr['enmge_xz']) ) { // limit zip search
		$enmge_fxz = 1;
	} else {
		$enmge_fxz = 0;
	}
	
	include(plugin_dir_path( __FILE__ ) . 'includes/displaygroups.php'); 
	$content = ob_get_clean();
	return $content; 
}

/* ----- Add Groups Engine Settings to User Page ----- */

add_action( 'show_user_profile', 'enm_groupsengine_user_settings' ); 
add_action( 'edit_user_profile', 'enm_groupsengine_user_settings' ); 

function enm_groupsengine_user_settings( $user ) { // show prayer engine form on admin
	global $wp_version;

	// Get All Group Types
	global $wpdb;
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_id ASC"; 
	$enmge_grouptypes = $wpdb->get_results( $enmge_preparredsql );
	foreach ($enmge_grouptypes as $grouptype) {
		${'enmge_gtvalue' . $grouptype->group_type_id} = get_user_meta( $user->ID, 'groupsengine_admin_grouptype' . $grouptype->group_type_id, true ); 
	}
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/admin_user_settings.php'); 
}

add_action( 'personal_options_update', 'enm_groupsengine_update_user_settings' ); 
add_action( 'edit_user_profile_update', 'enm_groupsengine_update_user_settings' ); 

function enm_groupsengine_update_user_settings( $user_id ) { // show groups engine form on admin
	if ( !current_user_can( 'edit_user', $user_id ) ) 
	return false; 
	// Get All Group Types
	global $wpdb;
	$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_id ASC"; 
	$enmge_grouptypes = $wpdb->get_results( $enmge_preparredsql );
	foreach ($enmge_grouptypes as $grouptype) {
		if ( isset($_POST['groupsengine_admin_grouptype' . $grouptype->group_type_id]) ) {
			$enmge_savevalue = $_POST['groupsengine_admin_grouptype' . $grouptype->group_type_id];
		} else {
			$enmge_savevalue = 0;
		}
		global $wp_version;
		update_user_meta( $user_id, 'groupsengine_admin_grouptype' . $grouptype->group_type_id, $enmge_savevalue ); 
	}
}

/* ----- Pointer Image ----- */

add_image_size('Groups Engine Pointer', 48, 48);

/* ----- Groups Engine Settings Page ----- */

add_action('admin_menu', 'enm_groupsengine_add_page'); 

function enm_groupsengine_add_page() { 
	add_options_page( 'Groups Engine', 'Groups Engine', 'manage_options', 'enm_groupsengine', 'enm_groupsengine_options_page' ); 
} 

function enm_groupsengine_options_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/settings.php'); 
}

add_action('admin_init', 'enm_groupsengine_admin_init'); 

function enm_groupsengine_admin_init() {
	include('includes/core/settings.php');
};

/* New AJAX Stuff */

function groupsengine_ajaxlinks() { // Main AJAX
    include(plugin_dir_path( __FILE__ ) . 'includes/displaygroupsajax.php'); 
}
 
add_action( 'wp_ajax_nopriv_groupsengine_ajaxlinks', 'groupsengine_ajaxlinks' );
add_action( 'wp_ajax_groupsengine_ajaxlinks', 'groupsengine_ajaxlinks' );

function groupsengine_ajaxembedfindgroup() { // Embed Code Find Group
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_find_group.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxembedfindgroup', 'groupsengine_ajaxembedfindgroup' );

function groupsengine_ajaxembedgencode() { // Embed Code Gen Code
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_generate_code.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxembedgencode', 'groupsengine_ajaxembedgencode' );

function groupsengine_ajaxgroupnewfile() { // Group Add New File
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/newfile.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxgroupnewfile', 'groupsengine_ajaxgroupnewfile' );

function groupsengine_ajaxgroupeditfile() { // Group Edit File
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/fileedit.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxgroupeditfile', 'groupsengine_ajaxgroupeditfile' );

function groupsengine_ajaxgroupdeletefile() { // Group Delete File
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/filedelete.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxgroupdeletefile', 'groupsengine_ajaxgroupdeletefile' );

function groupsengine_ajaxgroupnewtopic() { // Group New Topic
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/newtopiclist.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxgroupnewtopic', 'groupsengine_ajaxgroupnewtopic' );

function groupsengine_ajaxgroupnewgrouptype() { // Group New Group Type
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/newgrouptypelist.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxgroupnewgrouptype', 'groupsengine_ajaxgroupnewgrouptype' );

function groupsengine_ajaxgroupnewleader() { // Group New Leader
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/newleader.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxgroupnewleader', 'groupsengine_ajaxgroupnewleader' );

function groupsengine_ajaxgroupdeleteleader() { // Group Delete Leader
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/leaderdelete.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxgroupdeleteleader', 'groupsengine_ajaxgroupdeleteleader' );

function groupsengine_ajaxsortfiles() { // Sort Files
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/sortfiles.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxsortfiles', 'groupsengine_ajaxsortfiles' );

function groupsengine_ajaxcontactfindgroup() { // Sort Files
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/contactfindgroup.php'); 
}
 
add_action( 'wp_ajax_groupsengine_ajaxcontactfindgroup', 'groupsengine_ajaxcontactfindgroup' );

/* Refresh styles and options on plugin update */
if ( get_option( 'enmge_db_version' ) && get_option( 'enmge_db_version' ) < "1.3.4" ) {
	include('includes/core/updates.php');
}



 ?>