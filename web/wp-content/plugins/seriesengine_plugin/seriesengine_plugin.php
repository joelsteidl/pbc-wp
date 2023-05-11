<?php 
/* Plugin Name: Series Engine 
Plugin URI: http://seriesengine.com
Description: Series Engine is the best way to share audio and video with WordPress. To get started, activate the plugin and open the new "Series Engine" menu. Follow the instructions on the <a href="admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide">User Guide page</a> to embed a media browser, change the color scheme and more.
Version: 2.8.7
Author: Eric Murrell (Volacious) 
Author URI: http://seriesengine.com */ 


global $wp_version;
/* ----- Plugin Updates ----- */
require 'plugin-updates/plugin-update-checker.php';
$ENMSEUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'http://pluginupdates.seriesengine.com/newupdater.json',
	__FILE__,
	'seriesengine_plugin'
);

/* ----- Install the Plugin ----- */

define ( 'ENMSE_CURRENT_VERSION', '2.8.7' );
define( 'ENMSE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

$enmse_options = get_option( 'enm_seriesengine_options' ); 

if ( version_compare( get_bloginfo( 'version' ), '5.3', '<' ) ) { // Fix timezone issues if WordPress is less than 5.3
	if ( isset($enmse_options['timely']) ) { 
		if ( $enmse_options['timely'] == 0 ) {
			$enmse_timezone = get_option('timezone_string'); // Set Correct Timezone
			if ( $enmse_timezone != null ) {
				date_default_timezone_set(get_option('timezone_string')); 
			}
		}
	} else {
		$enmse_timezone = get_option('timezone_string'); // Set Correct Timezone
		if ( $enmse_timezone != null ) {
			date_default_timezone_set(get_option('timezone_string')); 
		}
	}
}

/*add_action('activated_plugin','save_error'); // Generate Error Messages for Activation hooks
function save_error(){
    update_option('plugin_error',  ob_get_contents());
}*/

register_activation_hook( __FILE__, 'enm_seriesengine_install_ms' ); 

function enm_seriesengine_install_ms( $network_wide ) { // Check for multisite

	global $wpdb;
	if ( $network_wide ) {
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			enm_seriesengine_install();

			$data = $enmse_options = get_option( 'enm_seriesengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'se_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'se_' . $blog . '_styles.css', $css, LOCK_EX); // Save it
		}
		switch_to_blog($wpdb->blogid);
	} else {
		enm_seriesengine_install();
	}	

}

add_action( 'wpmu_new_blog', 'enmse_new_blog', 10, 6); // Multisite - If a new site is added		
 
function enmse_new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;
 
	if (is_plugin_active_for_network('seriesengine_plugin/seriesengine_plugin.php')) {
		$old_blog = $wpdb->blogid;
		switch_to_blog($blog_id);
		enm_seriesengine_install();

		$data = $enmse_options = get_option( 'enm_seriesengine_options' ); ;	
		$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
		ob_start(); // Capture all output (output buffering)
		include($css_dir . 'se_styles_generate.php'); // Generate CSS
		$css = ob_get_clean(); // Get generated CSS (output buffering)
		file_put_contents($css_dir . 'se_' . $blog_id . '_styles.css', $css, LOCK_EX); // Save it
		switch_to_blog($old_blog);
	}
}

function enm_seriesengine_install() { 
	include('includes/core/install.php');
};


/* ----- Uninstall the Plugin ----- */

function enm_seriesengine_uninstall_ms() { // Check for multisite

	global $wpdb;
	if (function_exists('is_multisite') && is_multisite()) {
		$blog_list = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			enm_seriesengine_uninstall();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		enm_seriesengine_uninstall();
	}	

}

function enm_seriesengine_uninstall() { 
	delete_option( 'enm_seriesengine_options' ); 
	delete_option('enmse_db_version');
	global $wpdb;
	$dmtmatches = $wpdb->prefix . "se_message_topic_matches";
	$dmessages = $wpdb->prefix . "se_messages";
	$dpodcasts = $wpdb->prefix . "se_podcasts";
	$dseries = $wpdb->prefix . "se_series";
	$dsmmatches = $wpdb->prefix . "se_series_message_matches";
	$dstmatches = $wpdb->prefix . "se_series_type_matches";
	$dseriestypes = $wpdb->prefix . "se_series_types";
	$dtopics = $wpdb->prefix . "se_topics";
	$dspeakers = $wpdb->prefix . "se_speakers";
	$dmspmatches = $wpdb->prefix . "se_message_speaker_matches";
	$dmfmatches = $wpdb->prefix . "se_message_file_matches";
	$dfiles = $wpdb->prefix . "se_files";
	$dbooks = $wpdb->prefix . "se_books";
	$dbmmatches = $wpdb->prefix . "se_book_message_matches";
	$dscriptures = $wpdb->prefix . "se_scriptures";
	$dscmmatches = $wpdb->prefix . "se_scripture_message_matches";
	$wpdb->query("DROP TABLE IF EXISTS $dbooks, $dbmmatches, $dscriptures, $dscmmatches, $dmtmatches, $dmessages, $dpodcasts, $dseries, $dsmmatches, $dstmatches, $dseriestypes, $dtopics, $dspeakers, $dmspmatches, $dfiles, $dmfmatches");

	$enmse_cptdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "posts" . " WHERE post_type = 'enmse_message'";
	$enmse_cptdeleted = $wpdb->query( $enmse_cptdelete_query_preparred );

	$enmse_ctpmdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "postmeta" . " WHERE meta_key = 'enmse_mid'"; 
	$enmse_ctpmdeleted = $wpdb->query( $enmse_ctpmdelete_query );}; 


/* ----- Create the Admin Menus ----- */

add_action( 'admin_menu', 'enm_seriesengine_create_menu' );

function enm_seriesengine_create_menu() { 
	add_menu_page( 
		'Add and Edit Messages', 
		'Series Engine', 
		'edit_posts', 
		__FILE__, 
		'enm_seriesengine_messages_page', 
		plugins_url( '/images/blank.png', __FILE__ )
	); 

	$se_options = get_option( 'enm_seriesengine_options' );

	if ( isset($se_options['seriest']) ) { // Find Series Title
		$enmseseriest = $se_options['seriest'];
	} else {
		$enmseseriest = "Series";
	}

	if ( isset($se_options['seriestp']) ) { // Find Series Title
		$enmseseriestp = $se_options['seriestp'];
	} else {
		$enmseseriestp = "Series";
	}

	if ( isset($se_options['topict']) ) { // Find Topic Title
		$enmsetopict = $se_options['topict'];
	} else {
		$enmsetopict = "Topic";
	}

	if ( isset($se_options['topictp']) ) { // Find Topic Title
		$enmsetopictp = $se_options['topictp'];
	} else {
		$enmsetopictp = "Topics";
	}

	if ( isset($se_options['speakert']) ) { // Find Speaker Title
		$enmsespeakert = $se_options['speakert'];
	} else {
		$enmsespeakert = "Speaker";
	}

	if ( isset($se_options['speakertp']) ) { // Find Speaker Title
		$enmsespeakertp = $se_options['speakertp'];
	} else {
		$enmsespeakertp = "Speakers";
	}

	if ( isset($se_options['messaget']) ) { // Find Message Title
		$enmsemessaget = $se_options['messaget'];
	} else {
		$enmsemessaget = "Message";
	}

	if ( isset($se_options['messagetp']) ) { // Find Message Title
		$enmsemessagetp = $se_options['messagetp'];
	} else {
		$enmsemessagetp = "Messages";
	}
	
	add_submenu_page( __FILE__, 'Add and Edit ' . $enmseseriestp, 'Edit ' . $enmseseriestp, 'edit_pages', __FILE__ . '_series', 'enm_seriesengine_series_page'); 
	
	add_submenu_page( __FILE__, 'Add and Edit '  . $enmseseriest . ' Types', 'Edit '  . $enmseseriest . ' Types', 'edit_pages', __FILE__ . '_seriestypes', 'enm_seriesengine_seriestypes_page'); 
	
	add_submenu_page( __FILE__, 'Add and Edit ' . $enmsetopictp, 'Edit ' . $enmsetopictp, 'edit_pages', __FILE__ . '_topics', 'enm_seriesengine_topics_page'); 
	
	add_submenu_page( __FILE__, 'Add and Edit ' . $enmsespeakertp, 'Edit ' . $enmsespeakertp, 'edit_pages', __FILE__ . '_speakers', 'enm_seriesengine_speakers_page'); 

	add_submenu_page( __FILE__, 'Embed The Series Engine on a Page or Post', 'Get Shortcodes', 'edit_pages', __FILE__ . '_embed', 'enm_seriesengine_embed_page'); 
	
	add_submenu_page( __FILE__, 'Generate a Podcast', 'Generate Podcasts', 'edit_pages', __FILE__ . '_podcasts', 'enm_seriesengine_podcast_page'); 	
	
	add_submenu_page( __FILE__, 'Export and Import Series Engine Data', 'Import and Export', 'edit_pages', __FILE__ . '_export', 'enm_seriesengine_export_page'); 

	add_submenu_page( __FILE__, 'User Guide for the Series Engine Plugin', 'User Guide', 'edit_pages', __FILE__ . '_userguide', 'enm_seriesengine_userguide_page'); 

	/*add_submenu_page( __FILE__, 'Check for Updates to the Series Engine Plugin', 'Check for Updates', 'edit_pages', __FILE__ . '_updates', 'enm_seriesengine_update_page'); */
}

/* Admin Menu - Messages Page */

function enm_seriesengine_messages_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/messages.php'); 
}

/* Admin Menu - Series Page */

function enm_seriesengine_series_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/series.php'); 
}

/* Admin Menu - Series Types Page */

function enm_seriesengine_seriestypes_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/seriestypes.php'); 
}

/* Admin Menu - Topics Page */

function enm_seriesengine_topics_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/topics.php'); 
}

/* Admin Menu - Speakers Page */

function enm_seriesengine_speakers_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/speakers.php'); 
}

/* Admin Menu - Embed Code Generator Page */

function enm_seriesengine_embed_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed.php'); 
}

/* Admin Menu - Podcast Page */

function enm_seriesengine_podcast_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/podcasts.php'); 
}

/* Admin Menu - User Guide Page */

function enm_seriesengine_userguide_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/userguide.php'); 
}

/* Admin Menu - Export Page */

function enm_seriesengine_export_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/export.php'); 
}

/* Admin Menu - Check for Updates */

function enm_seriesengine_update_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/update.php');
}


/* ----- Generate Static Stylesheet ----- */

function generate_se_options_css($newdata) {

	$data = $newdata;	
	$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
	ob_start(); // Capture all output (output buffering)

	include($css_dir . 'se_styles_generate.php'); // Generate CSS

	$css = ob_get_clean(); // Get generated CSS (output buffering)

	if(is_multisite()) { 
		global $current_blog;
		file_put_contents($css_dir . 'se_' . $current_blog->blog_id . '_styles.css', $css, LOCK_EX); // Save it
	} else {
		file_put_contents($css_dir . 'se_styles.css', $css, LOCK_EX); // Save it
	}
	
}

/* Set Up Permalinks */

include('includes/core/permalinks.php');

/* Set Up Admin Panel and Series Engine Settings */

add_action('admin_menu', 'enm_seriesengine_add_page'); 

function enm_seriesengine_add_page() { 
	add_options_page( 'Series Engine', 'Series Engine', 'manage_options', 'enm_seriesengine', 'enm_seriesengine_options_page' ); 
} 

function enm_seriesengine_options_page() {
	include(plugin_dir_path( __FILE__ ) . 'includes/admin/settings.php'); 
}

add_action('admin_enqueue_scripts', 'enm_seriesengine_admin_enqueue');

function enm_seriesengine_admin_enqueue() {
	wp_enqueue_media();

	$se_options = get_option( 'enm_seriesengine_options' );
	if ( isset($se_options['nofonta']) ) {
		$se_nofonta = $se_options['nofonta'];
	} else {
		$se_nofonta = 0;
	}

	// Add stylesheet
	global $wp_version;
	if( version_compare( $wp_version, '3.8', '>=') ) {
		wp_register_style( 'seriesengineAdminStylesheet', plugins_url('/css/se_backend.css', __FILE__) );
		wp_enqueue_style( 'seriesengineAdminStylesheet' );
	} else {
		wp_register_style( 'seriesengineAdminStylesheet', plugins_url('/css/se_backend_old.css', __FILE__) );
		wp_enqueue_style( 'seriesengineAdminStylesheet' );
	}
	
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-ui-droppable' );
	wp_enqueue_script('jquery-ui-datepicker');

	wp_register_script( 'seriesengineAdminWidget', plugins_url('/js/se_widget.js', __FILE__) );
	wp_enqueue_script( 'seriesengineAdminWidget' );
	wp_localize_script( 'seriesengineAdminWidget', 'seajax',
            array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	if ( $se_nofonta == 0 ) {
		wp_register_style( 'seriesenginefontawesome', plugins_url('/css/font-awesome/css/font-awesome.min.css', __FILE__) );
		wp_enqueue_style( 'seriesenginefontawesome' );
	}
	
}

add_action('admin_init', 'enm_seriesengine_admin_init'); 

function enm_seriesengine_admin_init() {
	include('includes/core/settings.php');
};

/* ----- Modify User Theme to Add Stylesheets and JavaScript ----- */

add_action('template_redirect', 'enm_seriesengine_frontend_styles'); 

function enm_seriesengine_frontend_styles() {
	$se_options = get_option( 'enm_seriesengine_options' );
	if ( isset($se_options['noajax']) ) {
		$se_noajax = $se_options['noajax'];
	} else {
		$se_noajax = 0;
	}
	if ( isset($se_options['nofonta']) ) {
		$se_nofonta = $se_options['nofonta'];
	} else {
		$se_nofonta = 0;
	}
	if ( $se_noajax == 1 ) {
		wp_register_script( 'SeriesEngineFrontendJavascript', plugins_url('/js/seriesenginefrontendnoajax281.js', __FILE__) );
		wp_enqueue_script( 'SeriesEngineFrontendJavascript' );
		wp_localize_script( 'SeriesEngineFrontendJavascript', 'seajax',
            array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	} else {
		wp_register_script( 'SeriesEngineFrontendJavascript', plugins_url('/js/seriesenginefrontend281.js', __FILE__) );
		wp_enqueue_script( 'SeriesEngineFrontendJavascript' );
		wp_localize_script( 'SeriesEngineFrontendJavascript', 'seajax',
            array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	if(is_multisite()) { 
		global $current_blog;
		wp_register_style( 'SeriesEngineFrontendStyles', plugins_url('/css/se_' . $current_blog->blog_id . '_styles.css', __FILE__) );
		wp_enqueue_style( 'SeriesEngineFrontendStyles' );
	} else {
		wp_register_style( 'SeriesEngineFrontendStyles', plugins_url('/css/se_styles.css', __FILE__) );
		wp_enqueue_style( 'SeriesEngineFrontendStyles' );
	}
	wp_enqueue_style( 'wp-mediaelement' );
	wp_enqueue_script( 'wp-mediaelement' );

	if ( $se_nofonta == 0 ) {
		wp_register_style( 'seriesenginefontawesome', plugins_url('/css/font-awesome/css/font-awesome.min.css', __FILE__) );
		wp_enqueue_style( 'seriesenginefontawesome' );
	}
}

/* ----- Modify User Theme to Add jQuery ----- */

add_action('init', 'enm_seriesengine_add_jquery'); 

function enm_seriesengine_add_jquery() {
	wp_enqueue_script( 'jquery' );
}

/* ----- Set up the Series Engine Shortcodes ----- */

// Register a new shortcode: [seriesengine] 
add_shortcode( 'seriesengine', 'enm_seriesengine_embedwall' ); // The callback function that will replace [seriesengine] 

function enm_seriesengine_embedwall() {
	ob_start(); // do it this way to render within page content
	$enmse_lo = 0;
	$enmse_a = 0;
	$enmse_de = 0;
	$enmse_sort = "ASC";
	include(plugin_dir_path( __FILE__ ) . 'includes/serieslistings.php'); 
	$content = ob_get_clean();
	return $content; 
}

// Register a new shortcode: [seriesengine_wo] 
add_shortcode( 'seriesengine_wo', 'enm_seriesengine_embedwall_options' ); // The callback function that will replace [seriesengine_wo] 

function enm_seriesengine_embedwall_options( $attr ) {
	ob_start(); // do it this way to render within page content
	$enmse_lo = 1;
	
	if ( isset($attr['enmse_a']) ) { // Display Archives?
		$enmse_a = 1;
	} else {
		$enmse_a = 0;
	}
	
	if ( isset($attr['enmse_e']) ) { // Display Series/Topic Explorer?
		$enmse_de = 1;
	} else {
		$enmse_de = 0;
	}
	
	if ( isset($attr['enmse_d']) ) { // Display Expanded Details?
		$enmse_d = 1;
	} else {
		$enmse_d = 0;
	}
	
	if ( isset($attr['enmse_sh']) ) { // Display Sharing?
		$enmse_sh = 1;
	} else {
		$enmse_sh = 0;
	}
	
	if ( isset($attr['enmse_ex']) ) { // Display Extras?
		$enmse_ex = 1;
	} else {
		$enmse_ex = 0;
	}
	
	if ( isset($attr['enmse_dsm']) ) { // Display Specific Message?
		$enmse_dsm = $attr['enmse_dsm'];
	} else {
		$enmse_dsm = 0;
	}
	
	if ( isset($attr['enmse_dss']) ) { // Display Specific Series?
		$enmse_dss = $attr['enmse_dss'];
	} else {
		$enmse_dss = 0;
	}
	
	if ( isset($attr['enmse_dst']) ) { // Display Specific Topic?
		$enmse_dst = $attr['enmse_dst'];
	} else {
		$enmse_dst = 0;
	}

	if ( isset($attr['enmse_dsb']) ) { // Display Specific Book?
		$enmse_dsb = $attr['enmse_dsb'];
	} else {
		$enmse_dsb = 0;
	}
	
	if ( isset($attr['enmse_dssp']) ) { // Display Specific Speaker?
		$enmse_dssp = $attr['enmse_dssp'];
	} else {
		$enmse_dssp = 0;
	}
	
	if ( isset($attr['enmse_r']) ) { // Show Complimentary Messages?
		$enmse_scm = 1;
	} else {
		$enmse_scm = 0;
	}
	
	if ( isset($attr['enmse_sort']) ) { // Show Complimentary Messages?
		$enmse_sort = "DESC";
	} else {
		$enmse_sort = "ASC";
	}
	
	if ( isset($attr['enmse_sim']) ) { // Show Initial Message?
		$enmse_sim = 0;
	} else {
		$enmse_sim = 1;
	}
	
	if ( isset($attr['enmse_dsst']) ) { // Display Specific Series Type?
		$enmse_dsst = $attr['enmse_dsst'];
	} else {
		$enmse_dsst = "n";
	}

	if ( isset($attr['enmse_pag']) ) { // number of related messages per page
		$enmse_fpag = $attr['enmse_pag'];
	} else {
		$enmse_fpag = 0;
	}

	if ( isset($attr['enmse_apag']) ) { // number of archived series per page
		$enmse_fapag = $attr['enmse_apag'];
	} else {
		$enmse_fapag = 0;
	}

	if ( isset($attr['enmse_am']) ) { // Display All Messages
		$enmse_dam = 1;
	} else {
		$enmse_dam = 0;
	}

	if ( isset($attr['enmse_cv']) ) { // Related Message View
		$enmse_cardview = $attr['enmse_cv'];
	} else {
		$enmse_cardview = 0;
	}

	if ( isset($attr['enmse_hsd']) ) { // Hide Series Dropdown?
		$enmse_hsd = 1;
	} else {
		$enmse_hsd = 0;
	}

	if ( isset($attr['enmse_hspd']) ) { // Hide Speaker Dropdown?
		$enmse_hspd = 1;
	} else {
		$enmse_hspd = 0;
	}

	if ( isset($attr['enmse_htd']) ) { // Hide Topic Dropdown?
		$enmse_htd = 1;
	} else {
		$enmse_htd = 0;
	}

	if ( isset($attr['enmse_hbd']) ) { // Hide Book Dropdown?
		$enmse_hbd = 1;
	} else {
		$enmse_hbd = 0;
	}

	if ( isset($attr['enmse_hs']) ) { // Hide Series Info?
		$enmse_hs = 1;
	} else {
		$enmse_hs = 0;
	}

	if ( isset($attr['enmse_hsh']) ) { // Hide Sharing?
		$enmse_hsh = 1;
	} else {
		$enmse_hsh = 0;
	}

	if ( isset($attr['enmse_had']) ) { // Hide Sharing?
		$enmse_had = 1;
	} else {
		$enmse_had = 0;
	}
	
	include(plugin_dir_path( __FILE__ ) . 'includes/serieslistings.php'); 
	$content = ob_get_clean();
	return $content; 
}

/* ----- Custom RSS Feeds ----- */

// Main RSS Feed of Recent Message Audio

function enm_seriesengine_podcast_feed() {
	load_template( plugin_dir_path( __FILE__ ) . 'feeds/podcast.php' ); 
}

add_action('do_feed_seriesengine', 'enm_seriesengine_podcast_feed', 10, 1);

/* ----- Additional Image Sizes ----- */

$se_options = get_option( 'enm_seriesengine_options' );

if ( isset($se_options['newarchiveswidth']) ) { 
	$se_archive_width = $se_options['newarchiveswidth'];
} else {
	$se_archive_width = 600;
}

if ( isset($se_options['widgetwidth']) ) { 
	$se_widget_width = $se_options['widgetwidth'];
} else {
	$se_widget_width = 200;
}

if ( isset($se_options['newgraphicwidth']) ) { 
	$se_embed_width = $se_options['newgraphicwidth'];
} else {
	$se_embed_width = 1000;
}

add_image_size('Series Engine Graphic', $se_embed_width);
add_image_size('Series Engine Graphic Thumb', $se_archive_width);
add_image_size('Series Engine Widget Thumb', $se_widget_width);
add_image_size('Series Engine Podcast Graphic', 1400, 1400, true);

function enmse_insert_custom_image_sizes( $sizes ) {
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

add_filter( 'image_size_names_choose', 'enmse_insert_custom_image_sizes' );

/* ----- Add IE Code to Header ----- */

add_action ( 'wp_head', 'enmse_ie_compatibility' );

function enmse_ie_compatibility()
{
    echo '<!-- Display fixes for Internet Explorer -->
	<!--[if IE 9]>
	<link href="' . plugins_url() .'/seriesengine_plugin/css/ie9_fix.css' . '" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--[if IE 8]>
	<link href="' . plugins_url() .'/seriesengine_plugin/css/ie8_fix.css' . '" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--[if lte IE 7]>
	<link href="' . plugins_url() .'/seriesengine_plugin/css/ie7_fix.css' . '" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!-- end display fixes for Internet Explorer -->';
}

/* ----- Widget Code ----- */

// Add Series Engine Widgets to WordPress
add_action( 'widgets_init', 'enmse_seriesengine_widgets' );

// Register Series Engine Widgets
function enmse_seriesengine_widgets() {
	register_widget( 'enmse_seriesengine_widget_lists' );
}

include('includes/core/widgets.php');


/* ----- Find MP3 File Sizes ----- */

class mp3file
{
	protected $block;
	protected $blockpos;
	protected $blockmax;
	protected $blocksize;
	protected $fd;
	protected $bitpos;
	protected $mp3data;
	public function __construct($filename)
	{
		$this->powarr  = array(0=>1,1=>2,2=>4,3=>8,4=>16,5=>32,6=>64,7=>128);
		$this->blockmax= 1024;

		$this->mp3data = array();
		
		$parts=parse_url($filename);
		
		if (ini_get('open_basedir') == '' && isset($parts['host'])){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $filename);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$this->mp3data['Filesize'] = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
			
			if (ini_get('allow_url_fopen')) {
				$this->fd = fopen($filename,'rb');
				$this->prefetchblock();
				$this->readmp3frame();
			}
		}
	}
	public function __destruct()
	{
		if (ini_get('open_basedir') == '' && isset($parts['host']) && ini_get('allow_url_fopen')){
			fclose($this->fd);
		}
	}
	//-------------------
	public function get_metadata()
	{
		return $this->mp3data;
	}
	protected function readmp3frame()
	{
		$iscbrmp3=true;
		if ($this->startswithid3())
			$this->skipid3tag();
		else if ($this->containsvbrxing())
		{
			$this->mp3data['Encoding'] = 'VBR';
			$iscbrmp3=false;
		}
		else if ($this->startswithpk())
		{
			$this->mp3data['Encoding'] = 'Unknown';
			$iscbrmp3=false;
		}

		if ($iscbrmp3)
		{
			$i = 0;
			$max=5000;
			//look in 5000 bytes... 
			//the largest framesize is 4609bytes(256kbps@8000Hz  mp3)
			for($i=0; $i<$max; $i++)
			{
				//looking for 1111 1111 111 (frame synchronization bits)                
				if ($this->getnextbyte()==0xFF)
					if ($this->getnextbit() && $this->getnextbit() && $this->getnextbit())
						break;
			}
			if ($i==$max)
				$iscbrmp3=false;
		}

		if ($iscbrmp3)
		{
			$this->mp3data['Encoding'         ] = 'CBR';
			$this->mp3data['MPEG version'     ] = $this->getnextbits(2);
			$this->mp3data['Layer Description'] = $this->getnextbits(2);
			$this->mp3data['Protection Bit'   ] = $this->getnextbits(1);
			$this->mp3data['Bitrate Index'    ] = $this->getnextbits(4);
			$this->mp3data['Sampling Freq Idx'] = $this->getnextbits(2);
			$this->mp3data['Padding Bit'      ] = $this->getnextbits(1);
			$this->mp3data['Private Bit'      ] = $this->getnextbits(1);
			$this->mp3data['Channel Mode'     ] = $this->getnextbits(2);
			$this->mp3data['Mode Extension'   ] = $this->getnextbits(2);
			$this->mp3data['Copyright'        ] = $this->getnextbits(1);
			$this->mp3data['Original Media'   ] = $this->getnextbits(1);
			$this->mp3data['Emphasis'         ] = $this->getnextbits(1);
			$this->mp3data['Bitrate'          ] = mp3file::bitratelookup($this->mp3data);
			$this->mp3data['Sampling Rate'    ] = mp3file::samplelookup($this->mp3data);
			$this->mp3data['Frame Size'       ] = mp3file::getframesize($this->mp3data);
			$this->mp3data['Length'           ] = mp3file::getduration($this->mp3data,$this->tell2());
			$this->mp3data['Length mm:ss'     ] = mp3file::seconds_to_mmss($this->mp3data['Length']);

			if ($this->mp3data['Bitrate'      ]=='bad'     ||
				$this->mp3data['Bitrate'      ]=='free'    ||
				$this->mp3data['Sampling Rate']=='unknown' ||
				$this->mp3data['Frame Size'   ]=='unknown' ||
				$this->mp3data['Length'     ]=='unknown')
			$this->mp3data = array('Filesize'=>$this->mp3data['Filesize'], 'Encoding'=>'Unknown');
		}
		else
		{
			if(!isset($this->mp3data['Encoding']))
				$this->mp3data['Encoding'] = 'Unknown';
		}
	}
	protected function tell()
	{
		return ftell($this->fd);
	}
	protected function tell2()
	{
		return ftell($this->fd)-$this->blockmax +$this->blockpos-1;
	}
	protected function startswithid3()
	{
		return ($this->block[1]==73 && //I
				$this->block[2]==68 && //D
				$this->block[3]==51);  //3
	}
	protected function startswithpk()
	{
		return ($this->block[1]==80 && //P
				$this->block[2]==75);  //K
	}
	protected function containsvbrxing()
	{
		//echo "<!--".$this->block[37]." ".$this->block[38]."-->";
		//echo "<!--".$this->block[39]." ".$this->block[40]."-->";
		return(
			   ($this->block[37]==88  && //X 0x58
				$this->block[38]==105 && //i 0x69
				$this->block[39]==110 && //n 0x6E
				$this->block[40]==103)   //g 0x67
/*               || 
			   ($this->block[21]==88  && //X 0x58
				$this->block[22]==105 && //i 0x69
				$this->block[23]==110 && //n 0x6E
				$this->block[24]==103)   //g 0x67*/
			  );   

	} 
	protected function debugbytes()
	{
		for($j=0; $j<10; $j++)
		{
			for($i=0; $i<8; $i++)
			{
				if ($i==4) echo " ";
				echo $this->getnextbit();
			}
			echo "<BR>";
		}
	}
	protected function prefetchblock()
	{
		$block = fread($this->fd, $this->blockmax);
		$this->blocksize = strlen($block);
		$this->block = unpack("C*", $block);
		$this->blockpos=0;
	}
	protected function skipid3tag()
	{
		$bits=$this->getnextbits(24);//ID3
		$bits.=$this->getnextbits(24);//v.v flags

		//3 bytes 1 version byte 2 byte flags
		$arr = array();
		$arr['ID3v2 Major version'] = bindec(substr($bits,24,8));
		$arr['ID3v2 Minor version'] = bindec(substr($bits,32,8));
		$arr['ID3v2 flags'        ] = bindec(substr($bits,40,8));
		if (substr($bits,40,1)) $arr['Unsynchronisation']=true;
		if (substr($bits,41,1)) $arr['Extended header']=true;
		if (substr($bits,42,1)) $arr['Experimental indicator']=true;
		if (substr($bits,43,1)) $arr['Footer present']=true;

		$size = "";
		for($i=0; $i<4; $i++)
		{
			$this->getnextbit();//skip this bit, should be 0
			$size.= $this->getnextbits(7);
		}

		$arr['ID3v2 Tags Size']=bindec($size);//now the size is in bytes;
		if ($arr['ID3v2 Tags Size'] - $this->blockmax>0)
		{
			fseek($this->fd, $arr['ID3v2 Tags Size']+10 );
			$this->prefetchblock();
			if (isset($arr['Footer present']) && $arr['Footer present'])
			{
				for($i=0; $i<10; $i++)
					$this->getnextbyte();//10 footer bytes
			}
		}
		else
		{
			for($i=0; $i<$arr['ID3v2 Tags Size']; $i++)
				$this->getnextbyte();
		}
	}

	protected function getnextbit()
	{
		if ($this->bitpos==8)
			return false;

		$b=0;
		$whichbit = 7-$this->bitpos;
		$mult = $this->powarr[$whichbit]; //$mult = pow(2,7-$this->pos);
		$b = $this->block[$this->blockpos+1] & $mult;
		$b = $b >> $whichbit;
		$this->bitpos++;

		if ($this->bitpos==8)
		{
			$this->blockpos++;

			if ($this->blockpos==$this->blockmax) //end of block reached
			{
				$this->prefetchblock();
			}
			else if ($this->blockpos==$this->blocksize) 
			{//end of short block reached (shorter than blockmax)
				return;//eof 
			}

			$this->bitpos=0;
		}
		return $b;
	}
	protected function getnextbits($n=1)
	{
		$b="";
		for($i=0; $i<$n; $i++)
			$b.=$this->getnextbit();
		return $b;
	}
	protected function getnextbyte()
	{
		if ($this->blockpos>=$this->blocksize)
			return;

		$this->bitpos=0;
		$b=$this->block[$this->blockpos+1];
		$this->blockpos++;
		return $b;
	}
	//-----------------------------------------------------------------------------
	public static function is_layer1(&$mp3) { return ($mp3['Layer Description']=='11'); }
	public static function is_layer2(&$mp3) { return ($mp3['Layer Description']=='10'); }
	public static function is_layer3(&$mp3) { return ($mp3['Layer Description']=='01'); }
	public static function is_mpeg10(&$mp3)  { return ($mp3['MPEG version']=='11'); }
	public static function is_mpeg20(&$mp3)  { return ($mp3['MPEG version']=='10'); }
	public static function is_mpeg25(&$mp3)  { return ($mp3['MPEG version']=='00'); }
	public static function is_mpeg20or25(&$mp3)  { return ($mp3['MPEG version'][1]=='0'); }
	//-----------------------------------------------------------------------------
	public static function bitratelookup(&$mp3)
	{
		//bits               V1,L1  V1,L2  V1,L3  V2,L1  V2,L2&L3
		$array = array();
		$array['0000']=array('free','free','free','free','free');
		$array['0001']=array(  '32',  '32',  '32',  '32',   '8');
		$array['0010']=array(  '64',  '48',  '40',  '48',  '16');
		$array['0011']=array(  '96',  '56',  '48',  '56',  '24');
		$array['0100']=array( '128',  '64',  '56',  '64',  '32');
		$array['0101']=array( '160',  '80',  '64',  '80',  '40');
		$array['0110']=array( '192',  '96',  '80',  '96',  '48');
		$array['0111']=array( '224', '112',  '96', '112',  '56');
		$array['1000']=array( '256', '128', '112', '128',  '64');
		$array['1001']=array( '288', '160', '128', '144',  '80');
		$array['1010']=array( '320', '192', '160', '160',  '96');
		$array['1011']=array( '352', '224', '192', '176', '112');
		$array['1100']=array( '384', '256', '224', '192', '128');
		$array['1101']=array( '416', '320', '256', '224', '144');
		$array['1110']=array( '448', '384', '320', '256', '160');
		$array['1111']=array( 'bad', 'bad', 'bad', 'bad', 'bad');

		$whichcolumn=-1;
		if      (mp3file::is_mpeg10($mp3) && mp3file::is_layer1($mp3) )//V1,L1
			$whichcolumn=0;
		else if (mp3file::is_mpeg10($mp3) && mp3file::is_layer2($mp3) )//V1,L2
			$whichcolumn=1;
		else if (mp3file::is_mpeg10($mp3) && mp3file::is_layer3($mp3) )//V1,L3
			$whichcolumn=2;
		else if (mp3file::is_mpeg20or25($mp3) && mp3file::is_layer1($mp3) )//V2,L1
			$whichcolumn=3;
		else if (mp3file::is_mpeg20or25($mp3) && (mp3file::is_layer2($mp3) || mp3file::is_layer3($mp3)) )
			$whichcolumn=4;//V2,   L2||L3 

		if (isset($array[$mp3['Bitrate Index']][$whichcolumn]))
			return $array[$mp3['Bitrate Index']][$whichcolumn];
		else 
			return "bad";
	}
	//-----------------------------------------------------------------------------
	public static function samplelookup(&$mp3)
	{
		//bits               MPEG1   MPEG2   MPEG2.5
		$array = array();
		$array['00'] =array('44100','22050','11025');
		$array['01'] =array('48000','24000','12000');
		$array['10'] =array('32000','16000','8000');
		$array['11'] =array('res','res','res');

		$whichcolumn=-1;
		if      (mp3file::is_mpeg10($mp3))
			$whichcolumn=0;
		else if (mp3file::is_mpeg20($mp3))
			$whichcolumn=1;
		else if (mp3file::is_mpeg25($mp3))
			$whichcolumn=2;

		if (isset($array[$mp3['Sampling Freq Idx']][$whichcolumn]))
			return $array[$mp3['Sampling Freq Idx']][$whichcolumn];
		else 
			return 'unknown';
	}
	//-----------------------------------------------------------------------------
	public static function getframesize(&$mp3)
	{
		if ($mp3['Sampling Rate']>0)
		{
			return  ceil((144 * $mp3['Bitrate']*1000)/$mp3['Sampling Rate']) + $mp3['Padding Bit'];
		}
		return 'unknown';
	}
	//-----------------------------------------------------------------------------
	public static function getduration(&$mp3,$startat)
	{
		if ($mp3['Bitrate']>0)
		{
			$KBps = ($mp3['Bitrate']*1000)/8;
			$datasize = ($mp3['Filesize'] - ($startat/8));
			$length = $datasize / $KBps;
			return sprintf("%d", $length);
		}
		return "unknown";
	}
	//-----------------------------------------------------------------------------
	public static function seconds_to_mmss($duration)
	{
		return sprintf("%d:%02d", ($duration /60), $duration %60 );
	}
}

/* ----- Support for Page Builders ----- */

/* Beaver Builder */

define( 'FL_MODULE_SE_DIR', plugin_dir_path( __FILE__ ) . '/pagebuilders/' );
define( 'FL_MODULE_SE_URL', plugins_url( '/', __FILE__ ) . '/pagebuilders/' );

function fl_load_se_module() {
	if ( class_exists( 'FLBuilder' ) ) {
	    require_once 'pagebuilders/bb-seriesengine/bb-seriesengine.php';
	}
}
add_action( 'init', 'fl_load_se_module' );

/* Divi Builder */

if ( ! function_exists( 'enmse_initialize_divi_extension' ) ):

function enmse_initialize_divi_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'pagebuilders/divi-seriesengine/includes/SeriesEngine.php';
}
add_action( 'divi_extensions_init', 'enmse_initialize_divi_extension' );
endif;

/* Elementor */

if ( did_action( 'elementor/loaded' ) ) {

require_once 'pagebuilders/elementor-seriesengine/elementor-init.php';

}

/* New AJAX Stuff */

function seriesengine_ajaxlinks() { // Main AJAX
    include(plugin_dir_path( __FILE__ ) . 'includes/ajaxlinks.php'); 
}
 
add_action( 'wp_ajax_nopriv_seriesengine_ajaxlinks', 'seriesengine_ajaxlinks' );
add_action( 'wp_ajax_seriesengine_ajaxlinks', 'seriesengine_ajaxlinks' );

function seriesengine_ajaxpag() { // Pagination AJAX
    include(plugin_dir_path( __FILE__ ) . 'includes/display/pagination/newrelated.php'); 
}
 
add_action( 'wp_ajax_nopriv_seriesengine_ajaxpag', 'seriesengine_ajaxpag' );
add_action( 'wp_ajax_seriesengine_ajaxpag', 'seriesengine_ajaxpag' );

function seriesengine_ajaxapag() { // Archive Pagination AJAX
    include(plugin_dir_path( __FILE__ ) . 'includes/display/pagination/newarchives.php'); 
}
 
add_action( 'wp_ajax_nopriv_seriesengine_ajaxapag', 'seriesengine_ajaxapag' );
add_action( 'wp_ajax_seriesengine_ajaxapag', 'seriesengine_ajaxapag' );

function seriesengine_ajaxviewcount() { // View Count AJAX
    include(plugin_dir_path( __FILE__ ) . 'includes/viewcount.php'); 
}
 
add_action( 'wp_ajax_nopriv_seriesengine_ajaxviewcount', 'seriesengine_ajaxviewcount' );
add_action( 'wp_ajax_seriesengine_ajaxviewcount', 'seriesengine_ajaxviewcount' );

function seriesengine_ajaxembedseriestypes() { // Gen Embed Code Series Types
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_seriestypes.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxembedseriestypes', 'seriesengine_ajaxembedseriestypes' );

function seriesengine_ajaxembedoptions() { // Gen Embed Code Options
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_options.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxembedoptions', 'seriesengine_ajaxembedoptions' );

function seriesengine_ajaxembedseries() { // Gen Embed Code Series
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_series.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxembedseries', 'seriesengine_ajaxembedseries' );

function seriesengine_ajaxembedtopic() { // Gen Embed Code Topic
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_topic.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxembedtopic', 'seriesengine_ajaxembedtopic' );

function seriesengine_ajaxembedspeaker() { // Gen Embed Code Speaker
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_speaker.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxembedspeaker', 'seriesengine_ajaxembedspeaker' );

function seriesengine_ajaxembedbook() { // Gen Embed Code Book
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_book.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxembedbook', 'seriesengine_ajaxembedbook' );

function seriesengine_ajaxembedmessage() { // Gen Embed Code Message
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_message.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxembedmessage', 'seriesengine_ajaxembedmessage' );

function seriesengine_ajaxembedcode() { // Gen Embed Code Code
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/embed_generate_code.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxembedcode', 'seriesengine_ajaxembedcode' );

function seriesengine_ajaxmessagenewtopic() { // Messages add new topic
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/newtopicslist.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxmessagenewtopic', 'seriesengine_ajaxmessagenewtopic' );

function seriesengine_ajaxmessagenewspeaker() { // Messages add new speaker
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/newspeakerslist.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxmessagenewspeaker', 'seriesengine_ajaxmessagenewspeaker' );

function seriesengine_ajaxmessagenewfile() { // Messages add new file
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/newfile.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxmessagenewfile', 'seriesengine_ajaxmessagenewfile' );

function seriesengine_ajaxmessageeditfileform() { // Messages edit file
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/fileedit.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxmessageeditfileform', 'seriesengine_ajaxmessageeditfileform' );

function seriesengine_ajaxmessagedeletefile() { // Messages delete file
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/filedelete.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxmessagedeletefile', 'seriesengine_ajaxmessagedeletefile' );

function seriesengine_ajaxsortfiles() { // Messages Sort Files
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/sortfiles.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxsortfiles', 'seriesengine_ajaxsortfiles' );

function seriesengine_ajaxmessagenewscripture() { // Messages add new scripture
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/newscripture.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxmessagenewscripture', 'seriesengine_ajaxmessagenewscripture' );

function seriesengine_ajaxmessageeditscripture() { // Messages edit scripture
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/scriptureedit.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxmessageeditscripture', 'seriesengine_ajaxmessageeditscripture' );

function seriesengine_ajaxmessagedeletescripture() { // Messages delete scripture
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/scripturedelete.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxmessagedeletescripture', 'seriesengine_ajaxmessagedeletescripture' );

function seriesengine_ajaxsortscripture() { // Messages Sort Scripture
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/sortscriptures.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxsortscripture', 'seriesengine_ajaxsortscripture' );

function seriesengine_ajaxsortseriestypes() { // Sort Series Types
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/sortseriestypes.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxsortseriestypes', 'seriesengine_ajaxsortseriestypes' );

function seriesengine_ajaxsorttopics() { // Sort Series Types
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/sorttopics.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxsorttopics', 'seriesengine_ajaxsorttopics' );

function seriesengine_ajaxpodcastloadseries() { // Podcast Load Series
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/podcast_series.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxpodcastloadseries', 'seriesengine_ajaxpodcastloadseries' );

function seriesengine_ajaxpodcastloadspeaker() { // Podcast Load Speaker
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/podcast_speaker.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxpodcastloadspeaker', 'seriesengine_ajaxpodcastloadspeaker' );

function seriesengine_ajaxpodcastloadtopic() { // Podcast Load Topic
    include(plugin_dir_path( __FILE__ ) . 'includes/admin/podcast_topic.php'); 
}

add_action( 'wp_ajax_seriesengine_ajaxpodcastloadtopic', 'seriesengine_ajaxpodcastloadtopic' );


/* Refresh styles and options on plugin update */
if ( get_option( 'enmse_db_version' ) && get_option( 'enmse_db_version' ) < "2.8.7" ) {
	include('includes/core/updates.php');
}



?>