<?php 

	if ( version_compare( get_bloginfo( 'version' ), '4.7', '<' ) ) {
		register_setting( 
			'enm_seriesengine_options', 
			'enm_seriesengine_options',
			'enm_seriesengine_validate_options' 
		); 
	} else {
		register_setting( 
			'enm_seriesengine_options', 
			'enm_seriesengine_options',
			array( 'sanitize_callback' => 'enm_seriesengine_validate_options') 
		); 
	};
	
	// General Settings
	add_settings_section( 
		'enm_seriesengine_settings', 
		'', 
		'enm_seriesengine_settings_text', 
		'seriesengine_plugin' 
	); 
	
	// Font Settings
	add_settings_section( 
		'enm_seriesengine_font_settings', 
		'', 
		'enm_seriesengine_font_text', 
		'seriesengine_plugin' 
	);
	
	// Style Settings
	add_settings_section( 
		'enm_seriesengine_style_settings', 
		'', 
		'enm_seriesengine_style_text', 
		'seriesengine_plugin' 
	);
	
	// Player Box
	add_settings_section( 
		'enm_seriesengine_playerbox_settings', 
		'', 
		'enm_seriesengine_playerbox_text', 
		'seriesengine_plugin' 
	);
	
	// Message Details
	add_settings_section( 
		'enm_seriesengine_messagedetails_settings', 
		'', 
		'enm_seriesengine_messagedetails_text', 
		'seriesengine_plugin' 
	);
	
	// Sharing
	add_settings_section( 
		'enm_seriesengine_sharing_settings', 
		'', 
		'enm_seriesengine_sharing_text', 
		'seriesengine_plugin' 
	);
	
	// Complimentary
	add_settings_section( 
		'enm_seriesengine_complimentary_settings', 
		'', 
		'enm_seriesengine_complimentary_text', 
		'seriesengine_plugin' 
	);

	// Grid/Row View
	add_settings_section( 
		'enm_seriesengine_gridrow_settings', 
		'', 
		'enm_seriesengine_gridrow_text', 
		'seriesengine_plugin' 
	);
	
	// Loading
	add_settings_section( 
		'enm_seriesengine_loading_settings', 
		'', 
		'enm_seriesengine_loading_text', 
		'seriesengine_plugin' 
	);
	
	// Series Archives
	add_settings_section( 
		'enm_seriesengine_archives_settings', 
		'', 
		'enm_seriesengine_archives_text', 
		'seriesengine_plugin' 
	);

	// Pagination
	add_settings_section( 
		'enm_seriesengine_pagination_settings', 
		'', 
		'enm_seriesengine_pagination_text', 
		'seriesengine_plugin' 
	);
	
	// Powered By
	add_settings_section( 
		'enm_seriesengine_poweredby_settings', 
		'', 
		'enm_seriesengine_poweredby_text', 
		'seriesengine_plugin' 
	);

	// Label Settings
	add_settings_section( 
		'enm_seriesengine_labels_settings', 
		'', 
		'enm_seriesengine_labels_text', 
		'seriesengine_plugin' 
	);

	// Language Settings
	add_settings_section( 
		'enm_seriesengine_language_settings', 
		'', 
		'enm_seriesengine_language_text', 
		'seriesengine_plugin' 
	);

	// Archive Settings
	add_settings_section( 
		'enm_seriesengine_archivesection_settings', 
		'', 
		'enm_seriesengine_archivesection_text', 
		'seriesengine_plugin' 
	);

	// Responsive Settings
	add_settings_section( 
		'enm_seriesengine_responsivesection_settings', 
		'', 
		'enm_seriesengine_responsivesection_text', 
		'seriesengine_plugin' 
	);

	// Permalink Settings
	add_settings_section( 
		'enm_seriesengine_permalinksection_settings', 
		'', 
		'enm_seriesengine_permalinksection_text', 
		'seriesengine_plugin' 
	);
	
	// Blank
	add_settings_section( 
		'enm_seriesengine_blank_settings', 
		'', 
		'enm_seriesengine_blank_text', 
		'seriesengine_plugin' 
	);
	
	function enm_seriesengine_settings_text() {
		echo '<div id="enmse-general-settings"><h3 class="enmse-settings-title">General Settings</h3><p class="enmse-settings-instructions">Use the fields below to modify the core settings of the Series Engine.</p>';
	};
	
	function enm_seriesengine_font_text() {
		echo '</div><div id="enmse-style-settings" style="display: none"><h3 class="enmse-settings-title">Series Engine Font</h3><p class="enmse-settings-instructions">Choose a font for the Series Engine media browser. You can specify a custom font if it\'s already included in your theme or another plugin. Some fonts are larger/smaller than others, so you may see some rendering issues if you choose something unusual.</p>';
	};
	
	function enm_seriesengine_style_text() {
		echo '<h3 class="enmse-settings-title">Message Explorer</h3><p class="enmse-settings-instructions">Modify the colors of the optional Message Explorer bar (with the dropdown menus) at the top of the Series Engine media browser.</p>';
	};
	
	function enm_seriesengine_playerbox_text() {
		echo '<h3 class="enmse-settings-title">Media Player</h3><p class="enmse-settings-instructions">Modify the colors of the main media player(s) and the related button/tab controls.</p>';
	};
	
	function enm_seriesengine_messagedetails_text() {
		echo '<h3 class="enmse-settings-title">Message Details</h3><p class="enmse-settings-instructions">Modify the text and link colors in the Message\'s details section immediately below the media player(s).</p>';
	};
	
	function enm_seriesengine_sharing_text() {
		echo '<h3 class="enmse-settings-title">Sharing</h3><p class="enmse-settings-instructions">Modify the colors of the buttons and popover windows for sharing a Message.</p>';
	};
	
	function enm_seriesengine_complimentary_text() {
		echo '<h3 class="enmse-settings-title">Related Messages (Classic List View)</h3><p class="enmse-settings-instructions">Modify the colors of the classic list view of optional related Messages below the Video/Audio player.</p>';
	};

	function enm_seriesengine_gridrow_text() {
		echo '<h3 class="enmse-settings-title">Related Messages (Grid/Row View)</h3><p class="enmse-settings-instructions">Modify the colors of the grid/row views of optional related Messages below the Video/Audio player.</p>';
	};
	
	function enm_seriesengine_loading_text() {
		echo '<h3 class="enmse-settings-title">Loading Popover</h3><p class="enmse-settings-instructions">Modify the loading graphic that appears in the Series Engine media browser.</p>';
	};
	
	function enm_seriesengine_archives_text() {
		echo '<h3 class="enmse-settings-title">Series Archives</h3><p class="enmse-settings-instructions">Modify the colors for Series Engine\'s Series archives.</p>';
	};

	function enm_seriesengine_pagination_text() {
		echo '<h3 class="enmse-settings-title">Pagination</h3><p class="enmse-settings-instructions">Modify the colors for Series Engine\'s pagination below related messages and series.</p>';
	};
	
	function enm_seriesengine_poweredby_text() {
		echo '<h3 class="enmse-settings-title">Series Engine Branding</h3><p class="enmse-settings-instructions">The tiny Series Engine credits at the bottom of each Series Engine embed.</p>';
	};

	function enm_seriesengine_labels_text() {
		echo '</div><div id="enmse-label-settings" style="display: none"><h3 class="enmse-settings-title">Customize Series Engine Labels</h3><p class="enmse-settings-instructions">By default, Series Engine uses labels like "Messages, Series, Topics" and more throughout the plugin. When you change those labels below, they will change everywhere they\'re found in the plugin, from the media browser your visitors see to the Series Engine admin interface. It\'s a simple way to make Series Engine match your naming conventions.</p>';
	};

	function enm_seriesengine_language_text() {
		echo '<h3 class="enmse-settings-title">Language Settings and Detailed Labels</h3><p class="enmse-settings-instructions">Whether you want to quickly change the language of all public-facing Series Engine components, or you manually want to tweak every label and text snippet in the plugin, the fields below give you full control over what Series Engine displays. <em>Uppercase variable names LIKE_THIS should not be modified.</em></p><p class="enmse-settings-instructions"><strong>Warning:</strong> Changing the display language below will <em>reset all labels</em> on this page to their language defaults. You can customize every label further after you first save the language change.</p>';
	};

	function enm_seriesengine_archivesection_text() {
		echo '</div><div id="enmse-archivesection-settings" style="display: none"><h3 class="enmse-settings-title">Customize the Series Archive Page</h3><p class="enmse-settings-instructions">Choose between a list and grid of images. When using the image-based archives, we recommend uploading all images at a 16x9 ratio with a width of at least 600px for the best results.</p>';
	};

	function enm_seriesengine_responsivesection_text() {
		echo '<h3 class="enmse-settings-title">Customize Responsive Breakpoints</h3><p class="enmse-settings-instructions">Series Engine is designed with full-width pages in mind. If you\'re embedding onto a page with sidebars, or would just like more control over the different views, adjust the values below to reflect where you want each set of styles to kick in. For instance, you may want the mobile view (designed for narrow screens) to kick in at a higher pixel width if there are columns on one or both sides of your Series Engine media player.</p>';
	};

	function enm_seriesengine_permalinksection_text() {
		echo '<h3 class="enmse-settings-title">Customize Series Engine Permalinks</h3><p class="enmse-settings-instructions">Series Engine automatically creates pretty, SEO-friendly permalinks that are great for sharing. The options below give you control over the permalink slug/url structure, and the content displayed along with a message on every permalink page. <strong>Reading through the permalink section of the User Guide is strongly</strong> encouraged if you tweak any of the settings below.</p>';
	};
	
	function enm_seriesengine_blank_text() {
		echo '</div>';
	};

	add_settings_field(
		'enm_prayerengine_archiveliststyle', 
		'Type of Series Archives: <p class="se-form-instructions">What type of Series archives do you want to display to your visitors?</p>', 
		'enm_seriesengine_archiveliststyle_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_archivesection_settings' 
	);
	
	function enm_seriesengine_archiveliststyle_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$archiveliststyle = $se_options['archiveliststyle'];
		if ($archiveliststyle == "1") {
			echo "<select id='archiveliststyle' name='enm_seriesengine_options[archiveliststyle]'><option value='1' selected='selected'>Image Grid of Series Graphics</option><option value='0'>Simple Text List</option></select>";
		} elseif ($archiveliststyle == "0" ) {
			echo "<select id='archiveliststyle' name='enm_seriesengine_options[archiveliststyle]'><option value='1'>Image Grid of Series Graphics</option><option value='0' selected='selected'>Simple Text List</option></select>";
		} else {
			echo "<select id='archiveliststyle' name='enm_seriesengine_options[archiveliststyle]'><option value='1'>Image Grid of Series Graphics</option><option value='0' selected='selected'>Simple Text List</option></select>";
		}
	};

	add_settings_field( //Video Tab Label
		'enm_seriesengine_placeholderimage', 
		'Series Graphic Placeholder: <p class="se-form-instructions">If you\'re using the image based archives, choose an image to use for Series that don\'t have graphics assigned to them.</p>', 
		'enm_seriesengine_placeholderimage_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_archivesection_settings' 
	);
	
	function enm_seriesengine_placeholderimage_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$placeholderimage = $se_options['placeholderimage'];
		if ( isset($se_options['newarchiveswidth']) ) {
			$enmsearchivewidth = $se_options['newarchiveswidth'];
		} else {
			$enmsearchivewidth = 600;
		}
		if ( $placeholderimage != null ) {
			echo "<input id='placeholderimage' name='enm_seriesengine_options[placeholderimage]' type='text' value='" . $se_options['placeholderimage'] . "' size='20' /> &nbsp;<a href='#'' class='enmse-upload-series-placeholder se-upload-link' id='content-add_media' title='Add Media'><img src='" .  admin_url() . "/images/media-button.png?ver=20111005' width='15' height='15' class='se-media-button' /> &nbsp;Upload Image</a><input type='hidden' name='enmsearchivethumb' value='" .  $enmsearchivewidth . "' id='enmsearchivethumb' /> <div id='placeholderimage-thumb-load'><br /><img src='" . $placeholderimage . "' alt='placeholder image' /></div>";
		} else {
			echo "<input id='placeholderimage' name='enm_seriesengine_options[placeholderimage]' type='text' value='" . $se_options['placeholderimage'] . "' size='20' /> &nbsp;<a href='#'' class='enmse-upload-series-placeholder se-upload-link' id='content-add_media' title='Add Media'><img src='" .  admin_url() . "/images/media-button.png?ver=20111005' width='15' height='15' class='se-media-button' /> &nbsp;Upload Image</a><input type='hidden' name='enmsearchivethumb' value='" .  $enmsearchivewidth . "' id='enmsearchivethumb' /> <div id='placeholderimage-thumb-load'><br /><img src='" . plugins_url() . "/seriesengine_plugin/images/series_thumb_placeholder.jpg' alt='placeholder image' /></div>";
		};
	};

	add_settings_field(
		'enm_prayerengine_imagearchivetext', 
		'Show Text in Image-based Archives?: <p class="se-form-instructions">Do you want to display the supporting text below the images?</p>', 
		'enm_seriesengine_imagearchivetext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_archivesection_settings' 
	);
	
	function enm_seriesengine_imagearchivetext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$imagearchivetext = $se_options['imagearchivetext'];
		if ($imagearchivetext == "1") {
			echo "<select id='imagearchivetext' name='enm_seriesengine_options[imagearchivetext]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($imagearchivetext == "0" ) {
			echo "<select id='imagearchivetext' name='enm_seriesengine_options[imagearchivetext]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='imagearchivetext' name='enm_seriesengine_options[imagearchivetext]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( //Responsive Large
		'enm_seriesengine_responsivefull', 
		'Large View: <p class="se-form-instructions">Intended for the largest full-width views. Features larger fonts and controls throughout the full view of the plugin.</p>', 
		'enm_seriesengine_responsivefull_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_responsivesection_settings' 
	);
	
	function enm_seriesengine_responsivefull_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$responsivefull = $se_options['responsivefull'];
		if ( $responsivefull != null ) {
			echo "<input id='responsivefull' name='enm_seriesengine_options[responsivefull]' type='text' value='{$se_options['responsivefull']}' size='5' /> px and above";
		} else {
			echo "<input id='responsivefull' name='enm_seriesengine_options[responsivefull]' type='text' value='900' size='5' /> px and above";
		}
	};

	add_settings_field( //Responsive Large
		'enm_seriesengine_responsivenormal', 
		'Normal View: <p class="se-form-instructions">The standard, full-width view seen on tablets and computers.</p>', 
		'enm_seriesengine_responsivenormal_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_responsivesection_settings' 
	);
	
	function enm_seriesengine_responsivenormal_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$responsivefull = $se_options['responsivefull'];
		$responsivemobile = $se_options['responsivemobile'];
		if ( $responsivefull != null ) {
			echo "Between <span id=\"mobilenumber\">" . $responsivemobile . "</span>px and <span id=\"fullnumber\">" . $responsivefull . "</span>px";
		} else {
			echo "Between <span id=\"mobilenumber\">700</span>px and <span id=\"fullnumber\">900</span>px";
		}
	};

	add_settings_field( //Responsive Large Mobile
		'enm_seriesengine_responsivemobile', 
		'Mobile View (Large): <p class="se-form-instructions">Intended for large-screened phones/small tablets. Stacked series explorer, rearranged tabs and controls, but list-view additional messages.</p>', 
		'enm_seriesengine_responsivemobile_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_responsivesection_settings' 
	);
	
	function enm_seriesengine_responsivemobile_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$responsivemobile = $se_options['responsivemobile'];
		if ( $responsivemobile != null ) {
			echo "<input id='responsivemobile' name='enm_seriesengine_options[responsivemobile]' type='text' value='{$se_options['responsivemobile']}' size='5' /> px and below (to the condensed breakpoint)";
		} else {
			echo "<input id='responsivemobile' name='enm_seriesengine_options[responsivemobile]' type='text' value='700' size='5' /> px and below (to the condensed breakpoint)";
		}
	};

	add_settings_field( //Responsive Small Mobile
		'enm_seriesengine_responsivecondensed', 
		'Mobile View (Condensed): <p class="se-form-instructions">Intended for smart phones. Like the larger mobile view, but with paragraph-style additional messages (instead of a list-view).</p>', 
		'enm_seriesengine_responsivecondensed_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_responsivesection_settings' 
	);
	
	function enm_seriesengine_responsivecondensed_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$responsivecondensed = $se_options['responsivecondensed'];
		if ( $responsivecondensed != null ) {
			echo "<input id='responsivecondensed' name='enm_seriesengine_options[responsivecondensed]' type='text' value='{$se_options['responsivecondensed']}' size='5' /> px and below";
		} else {
			echo "<input id='responsivecondensed' name='enm_seriesengine_options[responsivecondensed]' type='text' value='600' size='5' /> px and below";
		}
	};

	add_settings_field( //Maximum Width
		'enm_seriesengine_maxwidth', 
		'Maximum Width of Media Browser: <p class="se-form-instructions">The max width a Series Engine embed will display on a full page view. If you change this to something smaller, you\'ll probably want to adjust the responsive breakpoints in the "Advanced" section too.</p>', 
		'enm_seriesengine_maxwidth_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_maxwidth_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$maxwidth = $se_options['maxwidth'];
		if ( $maxwidth != null ) {
			echo "<input id='maxwidth' name='enm_seriesengine_options[maxwidth]' type='text' value='{$se_options['maxwidth']}' size='5' /> px";
		} else {
			echo "<input id='maxwidth' name='enm_seriesengine_options[maxwidth]' type='text' value='1000' size='5' /> px";
		}
	};

	add_settings_field(
		'enm_seriesengine_usepermalinks_style', 
		'Use WordPress Permalinks?: <p class="se-form-instructions">If no, Series Engine will revert its sharing links to classic mode with URL parameters instead.</p>', 
		'enm_seriesengine_usepermalinks_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_usepermalinks_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$usepermalinks = $se_options['usepermalinks'];
		if ($usepermalinks == "1") {
			echo "<select id='usepermalinks' name='enm_seriesengine_options[usepermalinks]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($usepermalinks == "0" ) {
			echo "<select id='usepermalinks' name='enm_seriesengine_options[usepermalinks]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='usepermalinks' name='enm_seriesengine_options[usepermalinks]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalinkslug', 
		'Permalink Slug: <p class="se-form-instructions">What verbage do you want in your Series Engine permalinks? It\'s /<span style="color: #000">messages</span>/message-title by default.</p>', 
		'enm_seriesengine_permalinkslug_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalinkslug_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalinkslug = $se_options['permalinkslug'];

		if ( isset($se_options['permalinkslug']) ) {
			$enmsepermalinkslug = $se_options['permalinkslug'];
		} else {
			$enmsepermalinkslug = "messages";
		};

		echo "<input id='permalinkslug' name='enm_seriesengine_options[permalinkslug]' type='text' value=" . $enmsepermalinkslug . " size='10' />";
	};

	add_settings_field(
		'enm_seriesengine_permalink_show_post_type', 
		'Show the "Messages" Custom Post Type in the WP Admin?: <p class="se-form-instructions">Advanced: You should keep this hidden unless you want to make advanced edits to the permalink pages. It\'s easy to break stuff.</p>', 
		'enm_seriesengine_permalink_show_post_type_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_show_post_type_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_show_post_type = $se_options['permalink_show_post_type'];
		if ($permalink_show_post_type == "true") {
			echo "<select id='permalink_show_post_type' name='enm_seriesengine_options[permalink_show_post_type]'><option value='true' selected='selected'>Yes</option><option value='false'>No</option></select>";
		} elseif ($permalink_show_post_type == "false" ) {
			echo "<select id='permalink_show_post_type' name='enm_seriesengine_options[permalink_show_post_type]'><option value='true'>Yes</option><option value='false' selected='selected'>No</option></select>";
		} else {
			echo "<select id='permalink_show_post_type' name='enm_seriesengine_options[permalink_show_post_type]'><option value='true'>Yes</option><option value='false' selected='selected'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalink_ogtags', 
		'Permalink Page - Generate OG Tags?: <p class="se-form-instructions">Do you want Series Engine to automatically generate OG tags for sharing on Facebook and other networks? This could conflict with SEO optimizers or other social plugins.</p>', 
		'enm_seriesengine_permalink_ogtags_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_ogtags_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_ogtags = $se_options['permalink_ogtags'];
		if ($permalink_ogtags == "1") {
			echo "<select id='permalink_ogtags' name='enm_seriesengine_options[permalink_ogtags]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($permalink_ogtags == "0" ) {
			echo "<select id='permalink_ogtags' name='enm_seriesengine_options[permalink_ogtags]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='permalink_ogtags' name='enm_seriesengine_options[permalink_ogtags]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	/*add_settings_field( // Primary Series Type
		'enm_seriesengine_permalink_single_seriestype', 
		'Permalink Page - Series Type: <p class="se-form-instructions">If you have the explorer dropdowns enabled, what Series Type do you want to limit their search options to?.</p>', 
		'enm_seriesengine_permalink_single_seriestype_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_seriestype_input() {
		global $wpdb;
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
		$enmse_series_types = $wpdb->get_results( $enmse_preparredsql );
		
		$se_options = get_option( 'enm_seriesengine_options' );
		if ( isset($se_options['permalink_single_seriestype']) ) {
			$permalink_single_seriestype = $se_options['permalink_single_seriestype'];
		} else {
			$permalink_single_seriestype = 0;
		};
		
		echo "<select name='enm_seriesengine_options[permalink_single_seriestype]' id='permalink_single_seriestype'>";
		if ( $permalink_single_seriestype == 0) {
			echo "<option value='0' selected='selected'>All Series Types</option>";
		} else {
			echo "<option value='0'>All Series Types</option>";
		}
		foreach ( $enmse_series_types as $enmse_single ) {
			if ( $permalink_single_seriestype == $enmse_single->series_type_id ) {
				echo "<option value='" . $enmse_single->series_type_id . "' selected='selected'>" . $enmse_single->name . " (Currently Primary)</option>";
			} else {
				echo "<option value='" . $enmse_single->series_type_id . "'>" . $enmse_single->name . "</option>";
			}
		};
		echo "</select>";
	};*/

	add_settings_field(
		'enm_seriesengine_permalink_single_explorer', 
		'Permalink Page - Show Explorer?: <p class="se-form-instructions">Do you want to display the explorer bar with search dropdowns on your permalink pages?</p>', 
		'enm_seriesengine_permalink_single_explorer_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_explorer_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_explorer = $se_options['permalink_single_explorer'];
		if ($permalink_single_explorer == "1") {
			echo "<select id='permalink_single_explorer' name='enm_seriesengine_options[permalink_single_explorer]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($permalink_single_explorer == "0" ) {
			echo "<select id='permalink_single_explorer' name='enm_seriesengine_options[permalink_single_explorer]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='permalink_single_explorer' name='enm_seriesengine_options[permalink_single_explorer]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalink_single_explorer_series', 
		'Permalink Page - Show Explorer "Series" Menu?: <p class="se-form-instructions">(Only if the explorer bar is set to display above.)</p>', 
		'enm_seriesengine_permalink_single_explorer_series_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_explorer_series_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_explorer_series = $se_options['permalink_single_explorer_series'];
		if ($permalink_single_explorer_series == "1") {
			echo "<select id='permalink_single_explorer_series' name='enm_seriesengine_options[permalink_single_explorer_series]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($permalink_single_explorer_series == "0" ) {
			echo "<select id='permalink_single_explorer_series' name='enm_seriesengine_options[permalink_single_explorer_series]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='permalink_single_explorer_series' name='enm_seriesengine_options[permalink_single_explorer_series]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalink_single_explorer_speaker', 
		'Permalink Page - Show Explorer "Speakers" Menu?: <p class="se-form-instructions">(Only if the explorer bar is set to display above.)</p>', 
		'enm_seriesengine_permalink_single_explorer_speaker_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_explorer_speaker_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_explorer_speaker = $se_options['permalink_single_explorer_speaker'];
		if ($permalink_single_explorer_speaker == "1") {
			echo "<select id='permalink_single_explorer_speaker' name='enm_seriesengine_options[permalink_single_explorer_speaker]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($permalink_single_explorer_speaker == "0" ) {
			echo "<select id='permalink_single_explorer_speaker' name='enm_seriesengine_options[permalink_single_explorer_speaker]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='permalink_single_explorer_speaker' name='enm_seriesengine_options[permalink_single_explorer_speaker]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalink_single_explorer_topics', 
		'Permalink Page - Show Explorer "Topics" Menu?: <p class="se-form-instructions">(Only if the explorer bar is set to display above.)</p>', 
		'enm_seriesengine_permalink_single_explorer_topics_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_explorer_topics_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_explorer_topics = $se_options['permalink_single_explorer_topics'];
		if ($permalink_single_explorer_topics == "1") {
			echo "<select id='permalink_single_explorer_topics' name='enm_seriesengine_options[permalink_single_explorer_topics]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($permalink_single_explorer_topics == "0" ) {
			echo "<select id='permalink_single_explorer_topics' name='enm_seriesengine_options[permalink_single_explorer_topics]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='permalink_single_explorer_topics' name='enm_seriesengine_options[permalink_single_explorer_topics]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalink_single_explorer_books', 
		'Permalink Page - Show Explorer "Books" Menu?: <p class="se-form-instructions">(Only if the explorer bar is set to display above.)</p>', 
		'enm_seriesengine_permalink_single_explorer_books_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_explorer_books_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_explorer_books = $se_options['permalink_single_explorer_books'];
		if ($permalink_single_explorer_books == "1") {
			echo "<select id='permalink_single_explorer_books' name='enm_seriesengine_options[permalink_single_explorer_books]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($permalink_single_explorer_books == "0" ) {
			echo "<select id='permalink_single_explorer_books' name='enm_seriesengine_options[permalink_single_explorer_books]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='permalink_single_explorer_books' name='enm_seriesengine_options[permalink_single_explorer_books]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalink_single_related', 
		'Permalink Page - Show Related Messages?: <p class="se-form-instructions">Do you want to display the list of Related Messages below the player?</p>', 
		'enm_seriesengine_permalink_single_related_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_related_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_related = $se_options['permalink_single_related'];
		if ($permalink_single_related == "1") {
			echo "<select id='permalink_single_related' name='enm_seriesengine_options[permalink_single_related]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($permalink_single_related == "0" ) {
			echo "<select id='permalink_single_related' name='enm_seriesengine_options[permalink_single_related]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='permalink_single_related' name='enm_seriesengine_options[permalink_single_related]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalink_single_related_cardview', 
		'Permalink Page - Style of Related Messages: <p class="se-form-instructions">(If Related Messages are enabled above.)</p>', 
		'enm_seriesengine_permalink_single_related_cardview_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_related_cardview_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_related_cardview = $se_options['permalink_single_related_cardview'];
		if ($permalink_single_related_cardview == "1") {
			echo "<select id='permalink_single_related_cardview' name='enm_seriesengine_options[permalink_single_related_cardview]'><option value='2'>Row View</option><option value='1' selected='selected'>Grid View</option><option value='0'>Classic List View</option></select><br /><br />";
		} elseif ($permalink_single_related_cardview == "2" ) {
			echo "<select id='permalink_single_related_cardview' name='enm_seriesengine_options[permalink_single_related_cardview]'><option value='2' selected='selected'>Row View</option><option value='1'>Grid View</option><option value='0'>Classic List View</option></select><br /><br />";
		} else {
			echo "<select id='permalink_single_related_cardview' name='enm_seriesengine_options[permalink_single_related_cardview]'><option value='2'>Row View</option><option value='1'>Grid View</option><option value='0' selected='selected'>Classic List View</option></select><br /><br />";
		}
	};

	add_settings_field( 
		'enm_seriesengine_permalink_single_pag', 
		'Permalink Page - Pagination of Related Messages: <p class="se-form-instructions">If enabled, how many related messages do you want to display on each page?</p>', 
		'enm_seriesengine_permalink_single_pag_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_pag_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_pag = $se_options['permalink_single_pag'];
		if ( $permalink_single_pag != null ) {
			echo "<input id='permalink_single_pag' name='enm_seriesengine_options[permalink_single_pag]' type='text' value='{$se_options['permalink_single_pag']}' size='3' /> ";
		} else {
			echo "<input id='permalink_single_pag' name='enm_seriesengine_options[permalink_single_pag]' type='text' value='10' size='3' />";
		}
	};

	add_settings_field( 
		'enm_seriesengine_permalink_single_apag', 
		'Permalink Page - Pagination of Series Archives: <p class="se-form-instructions">If enabled, how many series do you want to show on each archives page?</p>', 
		'enm_seriesengine_permalink_single_apag_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_permalink_single_apag_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$pag = $se_options['permalink_single_apag'];
		if ( $pag != null ) {
			echo "<input id='permalink_single_apag' name='enm_seriesengine_options[permalink_single_apag]' type='text' value='{$se_options['permalink_single_apag']}' size='3' /> ";
		} else {
			echo "<input id='permalink_single_apag' name='enm_seriesengine_options[permalink_single_apag]' type='text' value='12' size='3' />";
		}
	};

	add_settings_field(
		'enm_seriesengine_permalink_single_blurb', 
		'Permalink Page - Introductory Content: <p class="se-form-instructions">Add optional text that will display above each Message on your permalink pages. Many people use this to push people to their full Sermons page elseware on the site.</p>', 
		'enm_seriesengine_permalink_single_blurb_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);

	function enm_seriesengine_permalink_single_blurb_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$permalink_single_blurb = $se_options['permalink_single_blurb'];
		echo "<textarea name=\"enm_seriesengine_options[permalink_single_blurb]\" rows=\"5\" cols=\"40\">{$permalink_single_blurb}</textarea>";
	};

	add_settings_field(
		'enm_seriesengine_default_permalink_prefix', 
		'Show the Prefix by Default in Titles?: <p class="se-form-instructions">Do you want to display the "Message:" prefix by default in permalink titles? (You can adjust this in each Message\'s settings.)</p>', 
		'enm_seriesengine_default_permalink_prefix_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_default_permalink_prefix_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$default_permalink_prefix = $se_options['default_permalink_prefix'];
		if ($default_permalink_prefix == "1") {
			echo "<select id='default_permalink_prefix' name='enm_seriesengine_options[default_permalink_prefix]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($default_permalink_prefix == "0" ) {
			echo "<select id='default_permalink_prefix' name='enm_seriesengine_options[default_permalink_prefix]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='default_permalink_prefix' name='enm_seriesengine_options[default_permalink_prefix]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_default_permalink_speaker', 
		'Show the Speaker by Default in Titles?: <p class="se-form-instructions">Do you want to append "by Speaker Name" to the end of permalink titles by default? (You can adjust this in each Message\'s settings.)</p>', 
		'enm_seriesengine_default_permalink_speaker_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_permalinksection_settings' 
	);
	
	function enm_seriesengine_default_permalink_speaker_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$default_permalink_speaker = $se_options['default_permalink_speaker'];
		if ($default_permalink_speaker == "1") {
			echo "<select id='default_permalink_speaker' name='enm_seriesengine_options[default_permalink_speaker]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($default_permalink_speaker == "0" ) {
			echo "<select id='default_permalink_speaker' name='enm_seriesengine_options[default_permalink_speaker]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='default_permalink_speaker' name='enm_seriesengine_options[default_permalink_speaker]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field( //Series Graphic Width
		'enm_seriesengine_newgraphicwidth', 
		'Series/Message Image Width: <p class="se-form-instructions">The width of the series or individual graphic shown with the audio player for a message.</p>', 
		'enm_seriesengine_newgraphicwidth_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_newgraphicwidth_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$newgraphicwidth = $se_options['newgraphicwidth'];
		if ( $newgraphicwidth != null ) {
			echo "<input id='newgraphicwidth' name='enm_seriesengine_options[newgraphicwidth]' type='text' value='{$se_options['newgraphicwidth']}' size='5' /> px";
		} else {
			echo "<input id='newgraphicwidth' name='enm_seriesengine_options[newgraphicwidth]' type='text' value='1000' size='5' /> px";
		}
	};

	add_settings_field( //Series Archives Graphic Width
		'enm_seriesengine_newarchiveswidth', 
		'Series Archives Image Width: <p class="se-form-instructions">The width of each graphic shown in the Series archives.</p>', 
		'enm_seriesengine_newarchiveswidth_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_newarchiveswidth_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$newarchiveswidth = $se_options['newarchiveswidth'];
		if ( $newarchiveswidth != null ) {
			echo "<input id='newarchiveswidth' name='enm_seriesengine_options[newarchiveswidth]' type='text' value='{$se_options['newarchiveswidth']}' size='5' /> px";
		} else {
			echo "<input id='newarchiveswidth' name='enm_seriesengine_options[newarchiveswidth]' type='text' value='600' size='5' /> px";
		}
	};

	add_settings_field( //Widget Width
		'enm_seriesengine_widgetwidth', 
		'Widget Graphic Width: <p class="se-form-instructions">The width of the Series graphic in widgets.</p>', 
		'enm_seriesengine_widgetwidth_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_widgetwidth_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$widgetwidth = $se_options['widgetwidth'];
		if ( $widgetwidth != null ) {
			echo "<input id='widgetwidth' name='enm_seriesengine_options[widgetwidth]' type='text' value='{$se_options['widgetwidth']}' size='3' /> px";
		} else {
			echo "<input id='widgetwidth' name='enm_seriesengine_options[widgetwidth]' type='text' value='200' size='3' /> px";
		}
	};

	add_settings_field( //Pagination
		'enm_seriesengine_pag', 
		'Pagination of Related Messages: <p class="se-form-instructions">How many related messages do you want to display on each page?</p>', 
		'enm_seriesengine_pag_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_pag_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$pag = $se_options['pag'];
		if ( $pag != null ) {
			echo "<input id='pag' name='enm_seriesengine_options[pag]' type='text' value='{$se_options['pag']}' size='3' /> ";
		} else {
			echo "<input id='pag' name='enm_seriesengine_options[pag]' type='text' value='10' size='3' />";
		}
	};

	add_settings_field( //Series Pagination
		'enm_seriesengine_apag', 
		'Pagination of Series Archives: <p class="se-form-instructions">How many series do you want to show on each archives page?</p>', 
		'enm_seriesengine_apag_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_apag_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$pag = $se_options['apag'];
		if ( $pag != null ) {
			echo "<input id='apag' name='enm_seriesengine_options[apag]' type='text' value='{$se_options['apag']}' size='3' /> ";
		} else {
			echo "<input id='apag' name='enm_seriesengine_options[apag]' type='text' value='12' size='3' />";
		}
	};
	
	add_settings_field( // Primary Series Type
		'enm_seriesengine_primaryst', 
		'Primary Series Type:', 
		'enm_seriesengine_primaryst_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_primaryst_input() {
		// Get All Series Types
		global $wpdb;
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
		$enmse_series_types = $wpdb->get_results( $enmse_preparredsql );
		
		$se_options = get_option( 'enm_seriesengine_options' );
		$primaryst = $se_options['primaryst'];
		
		echo "<select name='enm_seriesengine_options[primaryst]' id='primaryst'>";
		foreach ( $enmse_series_types as $enmse_single ) {
			if ( $primaryst == $enmse_single->series_type_id ) {
				echo "<option value='" . $enmse_single->series_type_id . "' selected='selected'>" . $enmse_single->name . " (Currently Primary)</option>";
			} else {
				echo "<option value='" . $enmse_single->series_type_id . "'>" . $enmse_single->name . "</option>";
			}
		};
		echo "</select>";
	};
	
	/*add_settings_field(
		'enm_seriesengine_enableseraw_style', 
		'Enable Theme Style Override?: <p class="se-form-instructions">Enable the <a href="' . admin_url() . 'admin.php?page=seriesengine_plugin/seriesengine_plugin.php_userguide#se-troubleshooting' . '">[seraw] shortcode</a> if your theme styles are breaking Series Engine media browsers.</p>', 
		'enm_seriesengine_enableseraw_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_enableseraw_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$enableseraw = $se_options['enableseraw'];
		if ($enableseraw == "1") {
			echo "<select id='enableseraw' name='enm_seriesengine_options[enableseraw]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($enableseraw == "0" ) {
			echo "<select id='enableseraw' name='enm_seriesengine_options[enableseraw]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='enableseraw' name='enm_seriesengine_options[enableseraw]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		}
	};*/

	add_settings_field(
		'enm_seriesengine_cardview_style', 
		'Default Style of Related Messages: <p class="se-form-instructions">If you use the basic shortcode, how do you want related messages to be displayed?</p>', 
		'enm_seriesengine_cardview_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_cardview_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$cardview = $se_options['cardview'];
		if ($cardview == "1") {
			echo "<select id='cardview' name='enm_seriesengine_options[cardview]'><option value='2'>Row View</option><option value='1' selected='selected'>Grid View</option><option value='0'>Classic List View</option></select><br /><br />";
		} elseif ($cardview == "2" ) {
			echo "<select id='cardview' name='enm_seriesengine_options[cardview]'><option value='2' selected='selected'>Row View</option><option value='1'>Grid View</option><option value='0'>Classic List View</option></select><br /><br />";
		} else {
			echo "<select id='cardview' name='enm_seriesengine_options[cardview]'><option value='2'>Row View</option><option value='1'>Grid View</option><option value='0' selected='selected'>Classic List View</option></select><br /><br />";
		}
	};

	add_settings_field(
		'enm_seriesengine_playerstyle_style', 
		'Style of Media/Details Section: <p class="se-form-instructions">Display media content and message details with the new modern layout (recommended), or the classic tab layout.</p>', 
		'enm_seriesengine_playerstyle_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_playerstyle_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$playerstyle = $se_options['playerstyle'];
		if ($playerstyle == "0") {
			echo "<select id='playerstyle' name='enm_seriesengine_options[playerstyle]'><option value='1'>Modern layout with buttons/icons</option><option value='0' selected='selected'>Classic layout with tabs</option></select><br /><br />";
		} else {
			echo "<select id='playerstyle' name='enm_seriesengine_options[playerstyle]'><option value='1' selected='selected'>Modern layout with buttons/icons</option><option value='0'>Classic layout with tabs</option></select><br /><br />";
		}
	};

	add_settings_field(
		'enm_seriesengine_bibleoption_style', 
		'Display Bible/Scripture Options?: <p class="se-form-instructions">You may want to set this to "no" if you\'re using Series Engine for something other than sermons.</p>', 
		'enm_seriesengine_bibleoption_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_bibleoption_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$bibleoption = $se_options['bibleoption'];
		if ($bibleoption == "1") {
			echo "<select id='bibleoption' name='enm_seriesengine_options[bibleoption]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select><br /><br />";
		} else {
			echo "<select id='bibleoption' name='enm_seriesengine_options[bibleoption]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		}
	};

	add_settings_field(
		'enm_seriesengine_deftrans_style', 
		'Default Bible Translation: <p class="se-form-instructions">What translation do you want to default to when you\'re adding scripture links?</p>', 
		'enm_seriesengine_deftrans_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_deftrans_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$deftrans = $se_options['deftrans'];
		if ($deftrans == "1999") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999' selected='selected'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "143") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143' selected='selected'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "400") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400' selected='selected'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "165") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165' selected='selected'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1276") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276' selected='selected'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1990") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990' selected='selected'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "75") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75' selected='selected'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "328") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328' selected='selected'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "48") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48' selected='selected'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1588") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588' selected='selected'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "12" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12' selected='selected'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1713" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713' selected='selected'>CSB - Christian Standard Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "59" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59' selected='selected'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "72" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72' selected='selected'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1359" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359' selected='selected'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1' selected='selected'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1171" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171' selected='selected'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "97" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97' selected='selected'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "100" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100' selected='selected'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "111" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111' selected='selected'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "114" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114' selected='selected'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "116" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116' selected='selected'>NLT - New Living Translation</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "6" ) {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6' selected='selected'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "157") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157' selected='selected'>SCH2000 - Schl
						achter 2000</option><option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "57") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57' selected='selected'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "108") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108' selected='selected'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "149") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149' selected='selected'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "128") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128' selected='selected'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "170") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170' selected='selected'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "414") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414' selected='selected'>CUNP-上帝 - 新標點和合
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>本, 神版</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "51") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51' selected='selected'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "73") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73' selected='selected'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "877") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877' selected='selected'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "2016") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016' selected='selected'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "37") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37' selected='selected'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "83") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83' selected='selected'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1819") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819' selected='selected'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "1820") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820' selected='selected'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "15") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15' selected='selected'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "162") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162' selected='selected'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "44") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44' selected='selected'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "509") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509' selected='selected'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "2367") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367' selected='selected'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} elseif ($deftrans == "133") {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133' selected='selected'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		} else {
			echo "<select id='deftrans' name='enm_seriesengine_options[deftrans]'>
						<option value='" . $deftrans . "'>------- ENGLISH ------</option>
						<option value='1588'>AMP - Amplified Bible</option>
						<option value='12'>ASV - American Standard Version</option>
						<option value='1713'>CSB - Christian Standard Bible</option>
						<option value='37'>CEB - Common English Bible</option>
						<option value='59' selected='selected'>ESV - English Standard Version</option>
						<option value='72'>HCSB - Holman Christian Standard Bible</option>
						<option value='1359'>ICB - International Childrens Bible</option>
						<option value='1'>KJV - King James Version</option>
						<option value='1171'>MEV - Modern English Version</option>
						<option value='97'>MSG - The Message</option>
						<option value='100'>NASB - New American Standard Bible</option>
						<option value='111'>NIV - New International Version</option>
						<option value='114'>NKJV - New King James Version</option>
						<option value='116'>NLT - New Living Translation</option>
						<option value='2016'>NRSV - New Revised Standard Version</option>
						<option value='" . $deftrans . "'>------- CHINESE ------</option>
						<option value='48'>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value='414'>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value='" . $deftrans . "'>------- CZECH ------</option>
						<option value='15'>B21 - Bible 21</option>
						<option value='162'>BCZ - Slovo na cestu</option>
						<option value='44'>BKR - Bible Kralica 1613</option>
						<option value='509'>CSP - Cesky studijni preklad</option>
						<option value='" . $deftrans . "'>------- DUTCH ------</option>
						<option value='1276'>BB - BasisBijbel</option>
						<option value='1990'>HSV - Herziene Statenvertaling</option>
						<option value='75'>HTB - Het Boek</option>
						<option value='328'>NBG51 - NBG-vertaling 1951</option>
						<option value='165'>SV-RJ - Statenvertaling</option>
						<option value='" . $deftrans . "'>------ FRENCH ------</option>
						<option value='2367'>NFC - Nouvelle Français Courant</option>
						<option value='133'>PDV2017 - Parole de Vie 2017</option>
						<option value='" . $deftrans . "'>------- GERMAN ------</option>
						<option value='57'>ELB - Elberfelder 1905</option>
						<option value='51'>DELUT - Lutherbibel 1912</option>
						<option value='73'>HFA - Hoffnung für alle</option>
						<option value='877'>NBH - NeÜ Bibel.heute</option>
						<option value='108'>NGU2011 - Neue Genfer Übersetzung</option>
						<option value='157'>SCH2000 - Schlachter 2000</option>
						<option value='" . $deftrans . "'>------- JAPANESE ------</option>
						<option value='83'>JCB - リビングバイブル</option>
						<option value='1819'>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value='1820'>口語訳 Japanese: 聖書　口語訳</option>
						<option value='" . $deftrans . "'>------- RUSSIAN ------</option>
						<option value='400'>SYNO - Синодальный Перевод</option>
						<option value='143'>НРП - Новый Русский Перевод</option>
						<option value='1999'>СРП-2 - Современный Русский Перевод</option>
						<option value='" . $deftrans . "'>------- SPANISH ------</option>
						<option value='149'>RVR1960 - Biblia Reina Valera 1960</option>
						<option value='128'>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value='" . $deftrans . "'>------- TURKISH ------</option>
						<option value='170'>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value='" . $deftrans . "'>------- OTHER ------</option>
						<option value='6'>AFR83 - Afrikaans 1983</option>
					</select><br /><br />";
		}
	};

	add_settings_field(
		'enm_seriesengine_noajax_style', 
		'Disable JavaScript Loading?: <p class="se-form-instructions">If disabled, Series Engine content will load/reload the entire window any time a new option is selected.</p>', 
		'enm_seriesengine_noajax_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_noajax_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$noajax = $se_options['noajax'];
		if ($noajax == "1") {
			echo "<select id='noajax' name='enm_seriesengine_options[noajax]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select><br /><br />";
		} elseif ($noajax == "0" ) {
			echo "<select id='noajax' name='enm_seriesengine_options[noajax]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		} else {
			echo "<select id='noajax' name='enm_seriesengine_options[noajax]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		}
	};

	add_settings_field(
		'enm_seriesengine_force_style', 
		'Force Browser to Download Audio?: <p class="se-form-instructions">Experimental; if enabled, it will force the user\'s browser to download an audio file when the "Download" link is clicked. Finicky with some servers.</p>', 
		'enm_seriesengine_force_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_force_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$forcedownload = $se_options['forcedownload'];
		if ($forcedownload == "1") {
			echo "<select id='forcedownload' name='enm_seriesengine_options[forcedownload]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select><br /><br />";
		} elseif ($forcedownload == "0" ) {
			echo "<select id='forcedownload' name='enm_seriesengine_options[forcedownload]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		} else {
			echo "<select id='forcedownload' name='enm_seriesengine_options[forcedownload]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		}
	};

	add_settings_field(
		'enm_seriesengine_timely', 
		'Calendar/Event Plugin Compatibility?: <p class="se-form-instructions">Fixes timezone issues for those using certain calendar and event plugins in older versions of WordPress. Don\'t enable otherwise.</p>', 
		'enm_seriesengine_timely', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_timely() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$se_timely = $se_options['timely'];
		if ($se_timely == "1") {
			echo "<select id='timely' name='enm_seriesengine_options[timely]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select><br /><br />";
		} elseif ($se_timely == "0" ) {
			echo "<select id='timely' name='enm_seriesengine_options[timely]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		} else {
			echo "<select id='timely' name='enm_seriesengine_options[timely]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		}
	};

	add_settings_field(
		'enm_seriesengine_nofonta', 
		'Disable Font Awesome?: <p class="se-form-instructions">Developers: Turn off Series Engine\'s instance of Font Awesome if you want to use your own.</p>', 
		'enm_seriesengine_nofonta', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_nofonta() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$se_nofonta = $se_options['nofonta'];
		if ($se_nofonta == "1") {
			echo "<select id='nofonta' name='enm_seriesengine_options[nofonta]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select><br /><br />";
		} elseif ($se_nofonta == "0" ) {
			echo "<select id='nofonta' name='enm_seriesengine_options[nofonta]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		} else {
			echo "<select id='nofonta' name='enm_seriesengine_options[nofonta]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		}
	};

	add_settings_field(
		'enm_seriesengine_id3_style', 
		'Try to Get File Size/Duration from Files?: <p class="se-form-instructions">If enabled, Series Engine will try to automatically populate the lenth and file size fields for your podcast files. Some servers have trouble with this.</p>', 
		'enm_seriesengine_id3_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_id3_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$id3 = $se_options['id3'];
		if ($id3 == "1") {
			echo "<select id='id3' name='enm_seriesengine_options[id3]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($id3 == "0" ) {
			echo "<select id='id3' name='enm_seriesengine_options[id3]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='id3' name='enm_seriesengine_options[id3]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_topicsort_style', 
		'Manually Sort Topics?: <p class="se-form-instructions">They\'ll be alphabetized otherwise.</p>', 
		'enm_seriesengine_topicsort_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_topicsort_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$topicsort = $se_options['topicsort'];
		if ($topicsort == "1") {
			echo "<select id='topicsort' name='enm_seriesengine_options[topicsort]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($topicsort == "0" ) {
			echo "<select id='topicsort' name='enm_seriesengine_options[topicsort]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='topicsort' name='enm_seriesengine_options[topicsort]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		}
	};

	add_settings_field(
		'enm_seriesengine_default_podcast_series_style', 
		'Show Series Info in Podcast Titles by Default?: <p class="se-form-instructions">You can toggle this on a case-by-case basis in each Message\'s "Podcast Details" tab.</p>', 
		'enm_seriesengine_default_podcast_series_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_settings' 
	);
	
	function enm_seriesengine_default_podcast_series_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$default_podcast_series = $se_options['default_podcast_series'];
		if ($default_podcast_series == "1") {
			echo "<select id='default_podcast_series' name='enm_seriesengine_options[default_podcast_series]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		} elseif ($default_podcast_series == "0" ) {
			echo "<select id='default_podcast_series' name='enm_seriesengine_options[default_podcast_series]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select>";
		} else {
			echo "<select id='default_podcast_series' name='enm_seriesengine_options[default_podcast_series]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select>";
		}
	};

	// ***** Series Engine Labels

	add_settings_field(
		'enm_seriesengine_seriest', 
		'Label for Series: <p class="se-form-instructions">What would you like to call "Series" throughout Series Engine?</p>', 
		'enm_seriesengine_seriest_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_seriest_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$seriest = $se_options['seriest'];

		if ( isset($se_options['seriest']) ) {
			$enmseseriest = $se_options['seriest'];
		} else {
			$enmseseriest = "Series";
		};

		echo "<input id='seriest' name='enm_seriesengine_options[seriest]' type='text' value=" . $enmseseriest . " size='10' />";
	};

	add_settings_field(
		'enm_seriesengine_seriestp', 
		'Label for Series (plural): <p class="se-form-instructions">The plural version of the "Series" label above.</p>', 
		'enm_seriesengine_seriestp_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_seriestp_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$seriestp = $se_options['seriestp'];

		if ( isset($se_options['seriestp']) ) {
			$enmseseriestp = $se_options['seriestp'];
		} else {
			$enmseseriestp = "Series";
		};

		echo "<input id='seriestp' name='enm_seriesengine_options[seriestp]' type='text' value=" . $enmseseriestp . " size='10' />";
	};

		/* */

	add_settings_field(
		'enm_seriesengine_topict', 
		'Label for Topics: <p class="se-form-instructions">What would you like to call "Topics" throughout Series Engine?</p>', 
		'enm_seriesengine_topict_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_topict_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$topict = $se_options['topict'];

		if ( isset($se_options['topict']) ) {
			$enmsetopict = $se_options['topict'];
		} else {
			$enmsetopict = "Topic";
		};

		echo "<input id='topict' name='enm_seriesengine_options[topict]' type='text' value=" . $enmsetopict . " size='10' />";
	};

	add_settings_field(
		'enm_seriesengine_topictp', 
		'Label for Topics (plural): <p class="se-form-instructions">The plural version of the "Topics" label above.</p>', 
		'enm_seriesengine_topictp_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_topictp_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$topictp = $se_options['topictp'];

		if ( isset($se_options['topictp']) ) {
			$enmsetopictp = $se_options['topictp'];
		} else {
			$enmsetopictp = "Topics";
		};

		echo "<input id='topictp' name='enm_seriesengine_options[topictp]' type='text' value=" . $enmsetopictp . " size='10' />";
	};
	
	/* */

	add_settings_field(
		'enm_seriesengine_speakert', 
		'Label for Speakers: <p class="se-form-instructions">What would you like to call "Speakers" throughout Series Engine?</p>', 
		'enm_seriesengine_speakert_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_speakert_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$speakert = $se_options['speakert'];

		if ( isset($se_options['speakert']) ) {
			$enmsespeakert = $se_options['speakert'];
		} else {
			$enmsespeakert = "Speaker";
		};

		echo "<input id='speakert' name='enm_seriesengine_options[speakert]' type='text' value=" . $enmsespeakert . " size='10' />";
	};

	add_settings_field(
		'enm_seriesengine_speakertp', 
		'Label for Speakers (plural): <p class="se-form-instructions">The plural version of the "Speakers" label above.</p>', 
		'enm_seriesengine_speakertp_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_speakertp_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$speakertp = $se_options['speakertp'];

		if ( isset($se_options['speakertp']) ) {
			$enmsespeakertp = $se_options['speakertp'];
		} else {
			$enmsespeakertp = "Speakers";
		};

		echo "<input id='speakertp' name='enm_seriesengine_options[speakertp]' type='text' value=" . $enmsespeakertp . " size='10' />";
	};

		/* */

	add_settings_field(
		'enm_seriesengine_messaget', 
		'Label for Messages: <p class="se-form-instructions">What would you like to call "Messages" throughout Series Engine?</p>', 
		'enm_seriesengine_messaget_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_messaget_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$messaget = $se_options['messaget'];

		if ( isset($se_options['messaget']) ) {
			$enmsemessaget = $se_options['messaget'];
		} else {
			$enmsemessaget = "Message";
		};

		echo "<input id='messaget' name='enm_seriesengine_options[messaget]' type='text' value=" . $enmsemessaget . " size='10' />";
	};

	add_settings_field(
		'enm_seriesengine_messagetp', 
		'Label for Messages (plural): <p class="se-form-instructions">The plural version of the "Messages" label above.</p>', 
		'enm_seriesengine_messagetp_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_messagetp_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$messagetp = $se_options['messagetp'];

		if ( isset($se_options['messagetp']) ) {
			$enmsemessagetp = $se_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		};

		echo "<input id='messagetp' name='enm_seriesengine_options[messagetp]' type='text' value=" . $enmsemessagetp . " size='10' />";
	};

	add_settings_field(
		'enm_seriesengine_bookt', 
		'Label for Books: <p class="se-form-instructions">What would you like to call Bible Books in Series Engine?</p>', 
		'enm_seriesengine_bookt_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_bookt_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$bookt = $se_options['bookt'];

		if ( isset($se_options['bookt']) ) {
			$enmsebookt = $se_options['bookt'];
		} else {
			$enmsebookt = "Book";
		};

		echo "<input id='bookt' name='enm_seriesengine_options[bookt]' type='text' value=" . $enmsebookt . " size='10' />";
	};

	add_settings_field(
		'enm_seriesengine_booktp', 
		'Label for Books (plural): <p class="se-form-instructions">The plural version of the "Book" label above.</p>', 
		'enm_seriesengine_booktp_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_booktp_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$booktp = $se_options['booktp'];

		if ( isset($se_options['booktp']) ) {
			$enmsebooktp = $se_options['booktp'];
		} else {
			$enmsebooktp = "Books";
		};

		echo "<input id='booktp' name='enm_seriesengine_options[booktp]' type='text' value=" . $enmsebooktp . " size='10' />";
	};

	add_settings_field( //Video Tab Label
		'enm_seriesengine_videotablabel', 
		'Player Video Tab Label: <p class="se-form-instructions">The title of the video tab in the Series Engine media browser.</p>', 
		'enm_seriesengine_videotablabel_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_videotablabel_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$videotablabel = $se_options['videotablabel'];
		echo "<input id='videotablabel' name='enm_seriesengine_options[videotablabel]' type='text' value=" . $se_options['videotablabel'] . " size='10' />";
	};
	
	add_settings_field( //Audio Tab Label
		'enm_seriesengine_audiotablabel', 
		'Player Audio Tab Label: <p class="se-form-instructions">The title of the audio tab in the Series Engine media browser.</p>', 
		'enm_seriesengine_audiotablabel_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_labels_settings' 
	);
	
	function enm_seriesengine_audiotablabel_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$audiotablabel = $se_options['audiotablabel'];
		echo "<input id='audiotablabel' name='enm_seriesengine_options[audiotablabel]' type='text' value=" . $se_options['audiotablabel'] . " size='10' />";
	};



	/* TEST -------------
	-----------------------
	---------------------
	----------------------
	----------------------
	----------------------- */

	add_settings_field(
		'enm_seriesengine_language', 
		'Display Language: <p class="se-form-instructions">Choose the language for the front-end display of all Series Engine content.</p>', 
		'enm_seriesengine_language_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_language_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$language = $se_options['language'];
		if ($language == "10") { //French
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\" selected='selected'>Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\">English</option><option value=\"10\" selected='selected'>French</option><option value=\"3\">German</option><option value=\"8\">Japanese</option><option value=\"9\">Russian</option><option value=\"2\">Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} elseif ($language == "9") { //Russian
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\" selected='selected'>Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\">English</option><option value=\"10\">French</option><option value=\"3\">German</option><option value=\"8\">Japanese</option><option value=\"9\" selected='selected'>Russian</option><option value=\"2\">Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} elseif ($language == "8") { //Japanese
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\" selected='selected'>Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\">English</option><option value=\"10\">French</option><option value=\"3\">German</option><option value=\"8\" selected='selected'>Japanese</option><option value=\"9\">Russian</option><option value=\"2\">Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} elseif ($language == "7") { //Dutch
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\" selected='selected'>Chinese (Traditional)</option><option value=\"7\" selected='selected'>Dutch</option><option value=\"1\">English</option><option value=\"10\">French</option><option value=\"3\">German</option><option value=\"8\">Japanese</option><option value=\"9\">Russian</option><option value=\"2\">Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} elseif ($language == "6") { //Traditional Chinese
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\" selected='selected'>Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\">English</option><option value=\"10\">French</option><option value=\"3\">German</option><option value=\"8\">Japanese</option><option value=\"9\">Russian</option><option value=\"2\">Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} elseif ($language == "5") { //Simplified Chinese
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\" selected='selected'>Chinese (Simplified)</option><option value=\"6\">Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\">English</option><option value=\"10\">French</option><option value=\"3\">German</option><option value=\"8\">Japanese</option><option value=\"9\">Russian</option><option value=\"2\">Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} elseif ($language == "4") { //Turkish
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\">Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\">English</option><option value=\"10\">French</option><option value=\"3\">German</option><option value=\"8\">Japanese</option><option value=\"9\">Russian</option><option value=\"2\">Spanish</option><option value=\"4\" selected='selected'>Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} elseif ($language == "3") { //German
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\">Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\">English</option><option value=\"10\">French</option><option value=\"3\" selected='selected'>German</option><option value=\"8\">Japanese</option><option value=\"9\">Russian</option><option value=\"2\">Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} elseif ($language == "2") { //Spanish
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\">Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\">English</option><option value=\"10\">French</option><option value=\"3\">German</option><option value=\"8\">Japanese</option><option value=\"9\">Russian</option><option value=\"2\" selected='selected'>Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		} else { // English
			echo "<select id='language' name='enm_seriesengine_options[language]'><option value=\"5\">Chinese (Simplified)</option><option value=\"6\">Chinese (Traditional)</option><option value=\"7\">Dutch</option><option value=\"1\" selected='selected'>English</option><option value=\"10\">French</option><option value=\"3\">German</option><option value=\"8\">Japanese</option><option value=\"9\">Russian</option><option value=\"2\">Spanish</option><option value=\"4\">Turkish</option></select><br /><br /> <input id='languageprev' name='enm_seriesengine_options[languageprev]' type='hidden' value=\"" . $se_options['language'] . "\" />";
		}
	};

	add_settings_field( // Loading Content...
		'enm_seriesengine_lang_loading', 
		'Loading Popover Text: <p class="se-form-instructions">The text below the loading icon.</p>', 
		'enm_seriesengine_lang_loading_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_loading_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_loading = $se_options['lang_loading'];
		if ( !isset($se_options['lang_loading']) ) {
			echo "<input id='lang_loading' name='enm_seriesengine_options[lang_loading]' type='text' value='Loading Content...' size='30' />";
		} else {
			echo "<input id='lang_loading' name='enm_seriesengine_options[lang_loading]' type='text' value='" . $se_options['lang_loading'] . "' size='30' />";
		}
	};

	add_settings_field( // Share Link Title
		'enm_seriesengine_lang_sharelinktitle', 
		'Share Popover Title: <p class="se-form-instructions">The title of the Share Link popover message.</p>', 
		'enm_seriesengine_lang_sharelinktitle_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_sharelinktitle_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_sharelinktitle = $se_options['lang_sharelinktitle'];
		if ( !isset($se_options['lang_sharelinktitle']) ) {
			echo "<input id='lang_sharelinktitle' name='enm_seriesengine_options[lang_sharelinktitle]' type='text' value='Share a Link to this MESSAGE_LABEL' size='40' />";
		} else {
			echo "<input id='lang_sharelinktitle' name='enm_seriesengine_options[lang_sharelinktitle]' type='text' value='" . $se_options['lang_sharelinktitle'] . "' size='40' />";
		}
	};

	add_settings_field( // Share Link Instructions
		'enm_seriesengine_lang_sharelinkinstructions', 
		'Share Popover Instructions: <p class="se-form-instructions">The instructions found in the Share Link popover view.</p>', 
		'enm_seriesengine_lang_sharelinkinstructions_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_sharelinkinstructions_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_sharelinkinstructions = $se_options['lang_sharelinkinstructions'];
		if ( !isset($se_options['lang_sharelinkinstructions']) ) {
			echo "<input id='lang_sharelinkinstructions' name='enm_seriesengine_options[lang_sharelinkinstructions]' type='text' value='The link has been copied to your clipboard; paste it anywhere you would like to share it.' size='40' />";
		} else {
			echo "<input id='lang_sharelinkinstructions' name='enm_seriesengine_options[lang_sharelinkinstructions]' type='text' value='" . $se_options['lang_sharelinkinstructions'] . "' size='40' />";
		}
	};

	add_settings_field( // Share Link Close Button
		'enm_seriesengine_lang_sharelinkclosebutton', 
		'Share Popover Button: <p class="se-form-instructions">The text on the close button in the Share Link popover.</p>', 
		'enm_seriesengine_lang_sharelinkclosebutton_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_sharelinkclosebutton_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_sharelinkclosebutton = $se_options['lang_sharelinkclosebutton'];
		if ( !isset($se_options['lang_sharelinkclosebutton']) ) {
			echo "<input id='lang_sharelinkclosebutton' name='enm_seriesengine_options[lang_sharelinkclosebutton]' type='text' value='Close' size='10' />";
		} else {
			echo "<input id='lang_sharelinkclosebutton' name='enm_seriesengine_options[lang_sharelinkclosebutton]' type='text' value='" . $se_options['lang_sharelinkclosebutton'] . "' size='10' />";
		}
	};

	add_settings_field( // Archives Explore Text
		'enm_seriesengine_lang_archiveexplore', 
		'Series Archives Explore Text: <p class="se-form-instructions">The text links in the Series Archives view.</p>', 
		'enm_seriesengine_lang_archiveexplore_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_archiveexplore_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_archiveexplore = $se_options['lang_archiveexplore'];
		if ( !isset($se_options['lang_archiveexplore']) ) {
			echo "<input id='lang_archiveexplore' name='enm_seriesengine_options[lang_archiveexplore]' type='text' value='Explore This SERIES_LABEL' size='30' />";
		} else {
			echo "<input id='lang_archiveexplore' name='enm_seriesengine_options[lang_archiveexplore]' type='text' value='" . $se_options['lang_archiveexplore'] . "' size='30' />";
		}
	};

	add_settings_field( // Explorer Browse Series
		'enm_seriesengine_lang_explorerbrowseseries', 
		'Browse Series Dropdown: <p class="se-form-instructions">The text in the Browse Series dropdown menu.</p>', 
		'enm_seriesengine_lang_explorerbrowseseries_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_explorerbrowseseries_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_explorerbrowseseries = $se_options['lang_explorerbrowseseries'];
		if ( !isset($se_options['lang_explorerbrowseseries']) ) {
			echo "<input id='lang_explorerbrowseseries' name='enm_seriesengine_options[lang_explorerbrowseseries]' type='text' value='Browse PLURAL_SERIES_LABEL' size='30' />";
		} else {
			echo "<input id='lang_explorerbrowseseries' name='enm_seriesengine_options[lang_explorerbrowseseries]' type='text' value='" . $se_options['lang_explorerbrowseseries'] . "' size='30' />";
		}
	};

	add_settings_field( // Explorer Browse Speakers
		'enm_seriesengine_lang_explorerbrowsespeakers', 
		'Browse Speakers Dropdown: <p class="se-form-instructions">The text in the Browse Speakers dropdown menu.</p>', 
		'enm_seriesengine_lang_explorerbrowsespeakers_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_explorerbrowsespeakers_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_explorerbrowsespeakers = $se_options['lang_explorerbrowsespeakers'];
		if ( !isset($se_options['lang_explorerbrowsespeakers']) ) {
			echo "<input id='lang_explorerbrowsespeakers' name='enm_seriesengine_options[lang_explorerbrowsespeakers]' type='text' value='Browse PLURAL_SPEAKERS_LABEL' size='30' />";
		} else {
			echo "<input id='lang_explorerbrowsespeakers' name='enm_seriesengine_options[lang_explorerbrowsespeakers]' type='text' value='" . $se_options['lang_explorerbrowsespeakers'] . "' size='30' />";
		}
	};

	add_settings_field( // Explorer Browse Topics
		'enm_seriesengine_lang_explorerbrowsetopics', 
		'Browse Topics Dropdown: <p class="se-form-instructions">The text in the Browse Topics dropdown menu.</p>', 
		'enm_seriesengine_lang_explorerbrowsetopics_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_explorerbrowsetopics_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_explorerbrowsetopics = $se_options['lang_explorerbrowsetopics'];
		if ( !isset($se_options['lang_explorerbrowsetopics']) ) {
			echo "<input id='lang_explorerbrowsetopics' name='enm_seriesengine_options[lang_explorerbrowsetopics]' type='text' value='Browse PLURAL_TOPICS_LABEL' size='30' />";
		} else {
			echo "<input id='lang_explorerbrowsetopics' name='enm_seriesengine_options[lang_explorerbrowsetopics]' type='text' value='" . $se_options['lang_explorerbrowsetopics'] . "' size='30' />";
		}
	};

	add_settings_field( // Explorer Browse Books
		'enm_seriesengine_lang_explorerbrowsebooks', 
		'Browse Books Dropdown: <p class="se-form-instructions">The text in the Browse Books dropdown menu.</p>', 
		'enm_seriesengine_lang_explorerbrowsebooks_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_explorerbrowsebooks_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_explorerbrowsebooks = $se_options['lang_explorerbrowsebooks'];
		if ( !isset($se_options['lang_explorerbrowsebooks']) ) {
			echo "<input id='lang_explorerbrowsebooks' name='enm_seriesengine_options[lang_explorerbrowsebooks]' type='text' value='Browse PLURAL_BOOKS_LABEL' size='30' />";
		} else {
			echo "<input id='lang_explorerbrowsebooks' name='enm_seriesengine_options[lang_explorerbrowsebooks]' type='text' value='" . $se_options['lang_explorerbrowsebooks'] . "' size='30' />";
		}
	};

	add_settings_field( // Explorer View Series Archives
		'enm_seriesengine_lang_explorerarchives', 
		'View Series Archives: <p class="se-form-instructions">The option to view Series Archives from the Browse Series dropdown.</p>', 
		'enm_seriesengine_lang_explorerarchives_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_explorerarchives_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_explorerarchives = $se_options['lang_explorerarchives'];
		if ( !isset($se_options['lang_explorerarchives']) ) {
			echo "<input id='lang_explorerarchives' name='enm_seriesengine_options[lang_explorerarchives]' type='text' value='View SERIES_LABEL Archives' size='30' />";
		} else {
			echo "<input id='lang_explorerarchives' name='enm_seriesengine_options[lang_explorerarchives]' type='text' value='" . $se_options['lang_explorerarchives'] . "' size='30' />";
		}
	};

	add_settings_field( // Explorer View All Messages
		'enm_seriesengine_lang_explorermessages', 
		'View All Messages: <p class="se-form-instructions">The option to View All Messages from the Browse Series dropdown.</p>', 
		'enm_seriesengine_lang_explorermessages_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_explorermessages_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_explorermessages = $se_options['lang_explorermessages'];
		if ( !isset($se_options['lang_explorermessages']) ) {
			echo "<input id='lang_explorermessages' name='enm_seriesengine_options[lang_explorermessages]' type='text' value='View All PLURAL_MESSAGES_LABEL' size='30' />";
		} else {
			echo "<input id='lang_explorermessages' name='enm_seriesengine_options[lang_explorermessages]' type='text' value='" . $se_options['lang_explorermessages'] . "' size='30' />";
		}
	};

	add_settings_field( //Scripture Reference Label
		'enm_seriesengine_scripturelabel', 
		'Scripture Reference Label: <p class="se-form-instructions">The title of the scripture link section in the details section of a Message.</p>', 
		'enm_seriesengine_scripturelabel_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_scripturelabel_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		if ( isset($se_options['scripturelabel']) ) {
			$enmsescripturelabel = $se_options['scripturelabel'];
		} else {
			$enmsescripturelabel = "Scripture References";
		};
		echo "<input id='scripturelabel' name='enm_seriesengine_options[scripturelabel]' type='text' value=\"{$enmsescripturelabel}\" size='20' />";
	};

	add_settings_field( // Related Topics
		'enm_seriesengine_lang_relatedtopics', 
		'Related Topics: <p class="se-form-instructions">The title of the Related Topics section in the details section of a Message.</p>', 
		'enm_seriesengine_lang_relatedtopics_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_relatedtopics_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_relatedtopics = $se_options['lang_relatedtopics'];
		if ( !isset($se_options['lang_relatedtopics']) ) {
			echo "<input id='lang_relatedtopics' name='enm_seriesengine_options[lang_relatedtopics]' type='text' value='Related PLURAL_TOPICS_LABEL:' size='30' />";
		} else {
			echo "<input id='lang_relatedtopics' name='enm_seriesengine_options[lang_relatedtopics]' type='text' value='" . $se_options['lang_relatedtopics'] . "' size='30' />";
		}
	};

	add_settings_field( // More Messages from
		'enm_seriesengine_lang_moremessagesfrom', 
		'More Messages From: <p class="se-form-instructions">The link to view more Messages from a certain Speaker in the details section of a Message.</p>', 
		'enm_seriesengine_lang_moremessagesfrom_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_moremessagesfrom_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_moremessagesfrom = $se_options['lang_moremessagesfrom'];
		if ( !isset($se_options['lang_moremessagesfrom']) ) {
			echo "<input id='lang_moremessagesfrom' name='enm_seriesengine_options[lang_moremessagesfrom]' type='text' value='More PLURAL_MESSAGES_LABEL from' size='30' />";
		} else {
			echo "<input id='lang_moremessagesfrom' name='enm_seriesengine_options[lang_moremessagesfrom]' type='text' value='" . $se_options['lang_moremessagesfrom'] . "' size='30' />";
		}
	};

	add_settings_field( // Download Audio
		'enm_seriesengine_lang_downloadaudio', 
		'Download Audio: <p class="se-form-instructions">The link to download audio in the details section of a Message.</p>', 
		'enm_seriesengine_lang_downloadaudio_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_downloadaudio_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_downloadaudio = $se_options['lang_downloadaudio'];
		if ( !isset($se_options['lang_downloadaudio']) ) {
			echo "<input id='lang_downloadaudio' name='enm_seriesengine_options[lang_downloadaudio]' type='text' value='Download Audio' size='30' />";
		} else {
			echo "<input id='lang_downloadaudio' name='enm_seriesengine_options[lang_downloadaudio]' type='text' value='" . $se_options['lang_downloadaudio'] . "' size='30' />";
		}
	};

	add_settings_field( // From Series:
		'enm_seriesengine_lang_fromseries', 
		'From Series: <p class="se-form-instructions">The heading for the Series details in the details section of a Message.</p>', 
		'enm_seriesengine_lang_fromseries_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_fromseries_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_fromseries = $se_options['lang_fromseries'];
		if ( !isset($se_options['lang_fromseries']) ) {
			echo "<input id='lang_fromseries' name='enm_seriesengine_options[lang_fromseries]' type='text' value='From SERIES_LABEL:' size='30' />";
		} else {
			echo "<input id='lang_fromseries' name='enm_seriesengine_options[lang_fromseries]' type='text' value='" . $se_options['lang_fromseries'] . "' size='30' />";
		}
	};

	add_settings_field( // Facebook
		'enm_seriesengine_lang_sharefb', 
		'Facebook: <p class="se-form-instructions">The (hidden) text title of the Facebook share button.</p>', 
		'enm_seriesengine_lang_sharefb_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_sharefb_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_sharefb = $se_options['lang_sharefb'];
		if ( !isset($se_options['lang_sharefb']) ) {
			echo "<input id='lang_sharefb' name='enm_seriesengine_options[lang_sharefb]' type='text' value='Facebook' size='30' />";
		} else {
			echo "<input id='lang_sharefb' name='enm_seriesengine_options[lang_sharefb]' type='text' value='" . $se_options['lang_sharefb'] . "' size='30' />";
		}
	};

	add_settings_field( // Twitter
		'enm_seriesengine_lang_sharetw', 
		'Twitter: <p class="se-form-instructions">The (hidden) text title of the Twitter share button.</p>', 
		'enm_seriesengine_lang_sharetw_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_sharetw_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_sharetw = $se_options['lang_sharetw'];
		if ( !isset($se_options['lang_sharetw']) ) {
			echo "<input id='lang_sharetw' name='enm_seriesengine_options[lang_sharetw]' type='text' value='Tweet Link' size='30' />";
		} else {
			echo "<input id='lang_sharetw' name='enm_seriesengine_options[lang_sharetw]' type='text' value='" . $se_options['lang_sharetw'] . "' size='30' />";
		}
	};

	add_settings_field( // Share Link
		'enm_seriesengine_lang_sharepop', 
		'Share Link: <p class="se-form-instructions">The (hidden) text title of the share a link share button.</p>', 
		'enm_seriesengine_lang_sharepop_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_sharepop_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_sharepop = $se_options['lang_sharepop'];
		if ( !isset($se_options['lang_sharepop']) ) {
			echo "<input id='lang_sharepop' name='enm_seriesengine_options[lang_sharepop]' type='text' value='Share Link' size='30' />";
		} else {
			echo "<input id='lang_sharepop' name='enm_seriesengine_options[lang_sharepop]' type='text' value='" . $se_options['lang_sharepop'] . "' size='30' />";
		}
	};

	add_settings_field( // Share Email
		'enm_seriesengine_lang_shareemail', 
		'Email Link: <p class="se-form-instructions">The (hidden) text title of the Email share button.</p>', 
		'enm_seriesengine_lang_shareemail_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_shareemail_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_shareemail = $se_options['lang_shareemail'];
		if ( !isset($se_options['lang_shareemail']) ) {
			echo "<input id='lang_shareemail' name='enm_seriesengine_options[lang_shareemail]' type='text' value='Send Email' size='30' />";
		} else {
			echo "<input id='lang_shareemail' name='enm_seriesengine_options[lang_shareemail]' type='text' value='" . $se_options['lang_shareemail'] . "' size='30' />";
		}
	};

	add_settings_field( // More Topics Associated with
		'enm_seriesengine_lang_morefromtopics', 
		'More Messages Associated with: <p class="se-form-instructions">The title above a list of related Messages when a Topic has been chosen.</p>', 
		'enm_seriesengine_lang_morefromtopics_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_morefromtopics_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_morefromtopics = $se_options['lang_morefromtopics'];
		if ( !isset($se_options['lang_morefromtopics']) ) {
			echo "<input id='lang_morefromtopics' name='enm_seriesengine_options[lang_morefromtopics]' type='text' value='More PLURAL_MESSAGES_LABEL Associated With' size='40' />";
		} else {
			echo "<input id='lang_morefromtopics' name='enm_seriesengine_options[lang_morefromtopics]' type='text' value='" . $se_options['lang_morefromtopics'] . "' size='40' />";
		}
	};

	add_settings_field( // More From the Book of
		'enm_seriesengine_lang_morefrombooks', 
		'More From the Book of: <p class="se-form-instructions">The title above a list of related Messages when a Book has been chosen.</p>', 
		'enm_seriesengine_lang_morefrombooks_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_morefrombooks_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_morefrombooks = $se_options['lang_morefrombooks'];
		if ( !isset($se_options['lang_morefrombooks']) ) {
			echo "<input id='lang_morefrombooks' name='enm_seriesengine_options[lang_morefrombooks]' type='text' value='More From the BOOK_LABEL of' size='40' />";
		} else {
			echo "<input id='lang_morefrombooks' name='enm_seriesengine_options[lang_morefrombooks]' type='text' value='" . $se_options['lang_morefrombooks'] . "' size='40' />";
		}
	};

	add_settings_field( // More Messages from
		'enm_seriesengine_lang_morefromspeakers', 
		'More Messages from: <p class="se-form-instructions">The title above a list of related Messages when a Speaker has been chosen.</p>', 
		'enm_seriesengine_lang_morefromspeakers_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_morefromspeakers_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_morefromspeakers = $se_options['lang_morefromspeakers'];
		if ( !isset($se_options['lang_morefromspeakers']) ) {
			echo "<input id='lang_morefromspeakers' name='enm_seriesengine_options[lang_morefromspeakers]' type='text' value='More PLURAL_MESSAGES_LABEL from' size='40' />";
		} else {
			echo "<input id='lang_morefromspeakers' name='enm_seriesengine_options[lang_morefromspeakers]' type='text' value='" . $se_options['lang_morefromspeakers'] . "' size='40' />";
		}
	};

	add_settings_field( // More Messages
		'enm_seriesengine_lang_morefromgeneric', 
		'More Messages: <p class="se-form-instructions">The title above a list of related Messages when viewing Messages from all Series.</p>', 
		'enm_seriesengine_lang_morefromgeneric_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_morefromgeneric_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_morefromgeneric = $se_options['lang_morefromgeneric'];
		if ( !isset($se_options['lang_morefromgeneric']) ) {
			echo "<input id='lang_morefromgeneric' name='enm_seriesengine_options[lang_morefromgeneric]' type='text' value='More PLURAL_MESSAGES_LABEL' size='40' />";
		} else {
			echo "<input id='lang_morefromgeneric' name='enm_seriesengine_options[lang_morefromgeneric]' type='text' value='" . $se_options['lang_morefromgeneric'] . "' size='40' />";
		}
	};

	add_settings_field( // More From
		'enm_seriesengine_lang_morefromseries', 
		'More From: <p class="se-form-instructions">The title above a list of related Messages when a Series has been chosen..</p>', 
		'enm_seriesengine_lang_morefromseries_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_morefromseries_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_morefromseries = $se_options['lang_morefromseries'];
		if ( !isset($se_options['lang_morefromseries']) ) {
			echo "<input id='lang_morefromseries' name='enm_seriesengine_options[lang_morefromseries]' type='text' value='More From' size='40' />";
		} else {
			echo "<input id='lang_morefromseries' name='enm_seriesengine_options[lang_morefromseries]' type='text' value='" . $se_options['lang_morefromseries'] . "' size='40' />";
		}
	};

	add_settings_field( // Pagination More Button
		'enm_seriesengine_lang_pagemore', 
		'Pagination More Button: <p class="se-form-instructions">The label for the More button in pagination links.</p>', 
		'enm_seriesengine_lang_pagemore_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_pagemore_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_pagemore = $se_options['lang_pagemore'];
		if ( !isset($se_options['lang_pagemore']) ) {
			echo "<input id='lang_pagemore' name='enm_seriesengine_options[lang_pagemore]' type='text' value='More' size='20' />";
		} else {
			echo "<input id='lang_pagemore' name='enm_seriesengine_options[lang_pagemore]' type='text' value='" . $se_options['lang_pagemore'] . "' size='20' />";
		}
	};

	add_settings_field( // Pagination Back Button
		'enm_seriesengine_lang_pageback', 
		'Pagination Back Button: <p class="se-form-instructions">The label for the Back button in pagination links.</p>', 
		'enm_seriesengine_lang_pageback_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_pageback_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_pageback = $se_options['lang_pageback'];
		if ( !isset($se_options['lang_pageback']) ) {
			echo "<input id='lang_pageback' name='enm_seriesengine_options[lang_pageback]' type='text' value='Back' size='20' />";
		} else {
			echo "<input id='lang_pageback' name='enm_seriesengine_options[lang_pageback]' type='text' value='" . $se_options['lang_pageback'] . "' size='20' />";
		}
	};

	add_settings_field( // Podcast "Message from"
		'enm_seriesengine_lang_podcastmessagefrom', 
		'"Message from" in Podcasts: <p class="se-form-instructions">Text found in Messages without descriptions in thier podcast feeds.</p>', 
		'enm_seriesengine_lang_podcastmessagefrom_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_podcastmessagefrom_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_podcastmessagefrom = $se_options['lang_podcastmessagefrom'];
		if ( !isset($se_options['lang_podcastmessagefrom']) ) {
			echo "<input id='lang_podcastmessagefrom' name='enm_seriesengine_options[lang_podcastmessagefrom]' type='text' value='MESSAGE_LABEL from' size='30' />";
		} else {
			echo "<input id='lang_podcastmessagefrom' name='enm_seriesengine_options[lang_podcastmessagefrom]' type='text' value='" . $se_options['lang_podcastmessagefrom'] . "' size='30' />";
		}
	};

	add_settings_field( // Permalink "Click to view more."
		'enm_seriesengine_lang_permaclicktoview', 
		'"Click to view more" in Permalinks: <p class="se-form-instructions">Filler text in OG tags on permalink pages.</p>', 
		'enm_seriesengine_lang_permaclicktoview_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_permaclicktoview_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_permaclicktoview = $se_options['lang_permaclicktoview'];
		if ( !isset($se_options['lang_permaclicktoview']) ) {
			echo "<input id='lang_permaclicktoview' name='enm_seriesengine_options[lang_permaclicktoview]' type='text' value='Click to view more.' size='40' />";
		} else {
			echo "<input id='lang_permaclicktoview' name='enm_seriesengine_options[lang_permaclicktoview]' type='text' value='" . $se_options['lang_permaclicktoview'] . "' size='40' />";
		}
	};

	add_settings_field( // Permalink Excerpt
		'enm_seriesengine_lang_permalinkblankexcerpt', 
		'Permalink Blank Excerpt Description: <p class="se-form-instructions">More filler text in OG tags on permalink pages.</p>', 
		'enm_seriesengine_lang_permalinkblankexcerpt_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_language_settings' 
	);
	
	function enm_seriesengine_lang_permalinkblankexcerpt_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$lang_permalinkblankexcerpt = $se_options['lang_permalinkblankexcerpt'];
		if ( !isset($se_options['lang_permalinkblankexcerpt']) ) {
			echo "<input id='lang_permalinkblankexcerpt' name='enm_seriesengine_options[lang_permalinkblankexcerpt]' type='text' value='A MESSAGE_LABEL from the SERIES_LABEL' size='40' />";
		} else {
			echo "<input id='lang_permalinkblankexcerpt' name='enm_seriesengine_options[lang_permalinkblankexcerpt]' type='text' value='" . $se_options['lang_permalinkblankexcerpt'] . "' size='40' />";
		}
	};

	/* TEST */


	// BEGIN CSS Colors
	
	add_settings_field( 
		'enm_prayerengine_font_style', 
		'Font for Series Engine Embed:', 
		'enm_seriesengine_font_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_font_settings' 
	);
	
	function enm_seriesengine_font_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$font = stripslashes($se_options['font']);
		if ($font == "arial") {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial' checked> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times'> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia'> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana'> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida'> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma'> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet'> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom'> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		} elseif ($font == "times" ) {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial'> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times' checked> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia'> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana'> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida'> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma'> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet'> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom'> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		} elseif ($font == "georgia" ) {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial'> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times'> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia' checked> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana'> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida'> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma'> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet'> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom'> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		} elseif ($font == "verdana" ) {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial'> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times'> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia'> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana' checked> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida'> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma'> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet'> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom'> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		} elseif ($font == "lucida" ) {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial'> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times'> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia'> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana'> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida' checked> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma'> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet'> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom'> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		} elseif ($font == "tahoma" ) {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial'> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times'> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia'> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana'> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida'> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma' checked> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet'> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom'> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		} elseif ($font == "trebuchet" ) {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial'> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times'> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia'> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana'> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida'> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma'> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet' checked> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom'> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		} elseif ($font == "custom" ) {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial'> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times'> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia'> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana'> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida'> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma'> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet'> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom' checked> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		} else {
			echo "<input type='radio' name='enm_seriesengine_options[font]' value='arial'> <span style='font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 1em'>Arial/Helvetica</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='times'> <span style='font-family: Times New Roman, Times New Roman, serif; font-weight: 700; font-size: 1em'>Times New Roman</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='georgia'> <span style='font-family: Georgia, Georgia, serif; font-weight: 700; font-size: 1em'>Georgia</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='verdana'> <span style='font-family: Verdana, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Verdana</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='lucida'> <span style='font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-weight: 700; font-size: 1em'>Lucida Grande</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='tahoma'> <span style='font-family: Tahoma, Geneva, sans-serif; font-weight: 700; font-size: 1em'>Tahoma</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='trebuchet'> <span style='font-family: Trebuchet MS, Trebuchet MS, sans-serif; font-weight: 700; font-size: 1em'>Trebuchet MS</span><br /><input type='radio' name='enm_seriesengine_options[font]' value='custom'> <span style='font-size: 1em'>Use the Custom Font Below</span>";
		}	
	};

	add_settings_field(
		'enm_seriesengine_customfont', 
		'<p class="se-form-instructions">If a custom font is selected, list the CSS font-family value here.</p>', 
		'enm_seriesengine_customfont_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_font_settings' 
	);
	
	function enm_seriesengine_customfont_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$customfont = $se_options['customfont'];

		if ( isset($se_options['customfont']) ) {
			echo "<input id='customfont' name='enm_seriesengine_options[customfont]' type='text' value='" . $customfont . "' size='20' />";
		} else {
			echo "<input id='customfont' name='enm_seriesengine_options[customfont]' type='text' value='' size='20' />";
		};

	};
	
	
	add_settings_field( 
		'enm_prayerengine_explorerbackground_style', 
		'Message Explorer Background:', 
		'enm_seriesengine_explorerbackground_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_style_settings' 
	);
	
	function enm_seriesengine_explorerbackground_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$explorerbackground = stripslashes($se_options['explorerbackground']);
		echo "<div id='c-explorerbackground' class='se-colorpicker' style='background-color: #{$explorerbackground}'></div>#<input id='explorerbackground' name='enm_seriesengine_options[explorerbackground]' type='text' value=\"{$explorerbackground}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_explorerselectborder_style', 
		'Dropdown Field Border:', 
		'enm_seriesengine_explorerselectborder_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_style_settings' 
	);
	
	function enm_seriesengine_explorerselectborder_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$explorerselectborder = stripslashes($se_options['explorerselectborder']);
		echo "<div id='c-explorerselectborder' class='se-colorpicker' style='background-color: #{$explorerselectborder}'></div>#<input id='explorerselectborder' name='enm_seriesengine_options[explorerselectborder]' type='text' value=\"{$explorerselectborder}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_explorerselect_style', 
		'Dropdown Field Background:', 
		'enm_seriesengine_explorerselect_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_style_settings' 
	);
	
	function enm_seriesengine_explorerselect_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$explorerselect = stripslashes($se_options['explorerselect']);
		echo "<div id='c-explorerselect' class='se-colorpicker' style='background-color: #{$explorerselect}'></div>#<input id='explorerselect' name='enm_seriesengine_options[explorerselect]' type='text' value=\"{$explorerselect}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_explorerselecttext_style', 
		'Dropdown Field Text:', 
		'enm_seriesengine_explorerselecttext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_style_settings' 
	);
	
	function enm_seriesengine_explorerselecttext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$explorerselecttext = stripslashes($se_options['explorerselecttext']);
		echo "<div id='c-explorerselecttext' class='se-colorpicker' style='background-color: #{$explorerselecttext}'></div>#<input id='explorerselecttext' name='enm_seriesengine_options[explorerselecttext]' type='text' value=\"{$explorerselecttext}\" size='10' class='se-colorfield' />";
	};
	
	/*add_settings_field( 
		'enm_prayerengine_explorerbutton_style', 
		'Series/Topic Explorer Button Background:', 
		'enm_seriesengine_explorerbutton_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_style_settings' 
	);
	
	function enm_seriesengine_explorerbutton_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$explorerbutton = stripslashes($se_options['explorerbutton']);
		echo "<div id='c-explorerbutton' class='se-colorpicker' style='background-color: #{$explorerbutton}'></div>#<input id='explorerbutton' name='enm_seriesengine_options[explorerbutton]' type='text' value=\"{$explorerbutton}\" size='10' class='se-colorfield' />";
	};*/
	
	/*add_settings_field( 
		'enm_prayerengine_explorerbuttontext_style', 
		'Series/Topic Explorer Button Text:', 
		'enm_seriesengine_explorerbuttontext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_style_settings' 
	);
	
	function enm_seriesengine_explorerbuttontext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$explorerbuttontext = stripslashes($se_options['explorerbuttontext']);
		echo "<div id='c-explorerbuttontext' class='se-colorpicker' style='background-color: #{$explorerbuttontext}'></div>#<input id='explorerbuttontext' name='enm_seriesengine_options[explorerbuttontext]' type='text' value=\"{$explorerbuttontext}\" size='10' class='se-colorfield' /><br /><br />";
	};*/
	
	//
	add_settings_field( 
		'enm_prayerengine_mstitletext_style', 
		'Message Title:', 
		'enm_seriesengine_mstitletext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_mstitletext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$mstitletext = stripslashes($se_options['mstitletext']);
		echo "<div id='c-mstitletext' class='se-colorpicker' style='background-color: #{$mstitletext}'></div>#<input id='mstitletext' name='enm_seriesengine_options[mstitletext]' type='text' value=\"{$mstitletext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_msdatetext_style', 
		'Speaker and Date:', 
		'enm_seriesengine_msdatetext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_msdatetext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$msdatetext = stripslashes($se_options['msdatetext']);
		echo "<div id='c-msdatetext' class='se-colorpicker' style='background-color: #{$msdatetext}'></div>#<input id='msdatetext' name='enm_seriesengine_options[msdatetext]' type='text' value=\"{$msdatetext}\" size='10' class='se-colorfield' />";
	};

	add_settings_field(
		'enm_seriesengine_borderoption_style', 
		'Display Border Around Audio/Video Player?: <p class="se-form-instructions">This will only effect the modern player layout.</p>', 
		'enm_seriesengine_borderoption_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_borderoption_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$borderoption = $se_options['borderoption'];
		if ($borderoption == "1" || $borderoption == null) {
			echo "<select id='borderoption' name='enm_seriesengine_options[borderoption]'><option value='1' selected='selected'>Yes</option><option value='0'>No</option></select><br /><br />";
		} else {
			echo "<select id='borderoption' name='enm_seriesengine_options[borderoption]'><option value='1'>Yes</option><option value='0' selected='selected'>No</option></select><br /><br />";
		}
	};

	add_settings_field( 
		'enm_prayerengine_playerbordercolor_style', 
		'Player Border Color:', 
		'enm_seriesengine_playerbordercolor_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_playerbordercolor_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$playerbordercolor = stripslashes($se_options['playerbordercolor']);
		if ( $playerbordercolor == null ) {
			echo "<div id='c-playerbordercolor' class='se-colorpicker' style='background-color: #b6b5b5'></div>#<input id='playerbordercolor' name='enm_seriesengine_options[playerbordercolor]' type='text' value=\"b6b5b5\" size='10' class='se-colorfield' />";
		} else {
			echo "<div id='c-playerbordercolor' class='se-colorpicker' style='background-color: #{$playerbordercolor}'></div>#<input id='playerbordercolor' name='enm_seriesengine_options[playerbordercolor]' type='text' value=\"{$playerbordercolor}\" size='10' class='se-colorfield' />";
		}
	};
	
	//
    add_settings_field( 
		'enm_prayerengine_playertabbackground_style', 
		'Regular Button/Tab Background:', 
		'enm_seriesengine_playertabbackground_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_playertabbackground_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$playertabbackground = stripslashes($se_options['playertabbackground']);
		echo "<div id='c-playertabbackground' class='se-colorpicker' style='background-color: #{$playertabbackground}'></div>#<input id='playertabbackground' name='enm_seriesengine_options[playertabbackground]' type='text' value=\"{$playertabbackground}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_playertabtext_style', 
		'Regular Button/Tab Text:', 
		'enm_seriesengine_playertabtext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_playertabtext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$playertabtext = stripslashes($se_options['playertabtext']);
		echo "<div id='c-playertabtext' class='se-colorpicker' style='background-color: #{$playertabtext}'></div>#<input id='playertabtext' name='enm_seriesengine_options[playertabtext]' type='text' value=\"{$playertabtext}\" size='10' class='se-colorfield' />";
	};

	add_settings_field( 
		'enm_prayerengine_playerselectedtabbackground_style', 
		'Selected Button/Tab Background:', 
		'enm_seriesengine_playerselectedtabbackground_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_playerselectedtabbackground_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$playerselectedtabbackground = stripslashes($se_options['playerselectedtabbackground']);
		echo "<div id='c-playerselectedtabbackground' class='se-colorpicker' style='background-color: #{$playerselectedtabbackground}'></div>#<input id='playerselectedtabbackground' name='enm_seriesengine_options[playerselectedtabbackground]' type='text' value=\"{$playerselectedtabbackground}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_playerselectedtabtext_style', 
		'Selected Button/Tab Text:', 
		'enm_seriesengine_playerselectedtabtext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_playerselectedtabtext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$playerselectedtabtext = stripslashes($se_options['playerselectedtabtext']);
		echo "<div id='c-playerselectedtabtext' class='se-colorpicker' style='background-color: #{$playerselectedtabtext}'></div>#<input id='playerselectedtabtext' name='enm_seriesengine_options[playerselectedtabtext]' type='text' value=\"{$playerselectedtabtext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field(
		'enm_prayerengine_playeroptions_style', 
		'Classic Player Details/Share Toggles:', 
		'enm_seriesengine_playeroptions_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_playeroptions_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$playeroptions = $se_options['playeroptions'];
		if ($playeroptions == "light") {
			echo "<select id='playeroptions' name='enm_seriesengine_options[playeroptions]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option></select>";
		} elseif ($playeroptions == "dark" ) {
			echo "<select id='playeroptions' name='enm_seriesengine_options[playeroptions]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option></select>";
		} else {
			echo "<select id='playeroptions' name='enm_seriesengine_options[playeroptions]'><option value='light'>Light</option><option value='dark'>Dark</option></select>";
		}
	};

	add_settings_field( 
		'enm_prayerengine_audiobg_style', 
		'Audio Player Background:', 
		'enm_seriesengine_audiobg_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_audiobg_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		if ( isset($se_options['audiobg']) ) {
			$audiobg = stripslashes($se_options['audiobg']);
		} else {
			$audiobg = '000000';
		}
		echo "<div id='c-audiobg' class='se-colorpicker' style='background-color: #{$audiobg}'></div>#<input id='audiobg' name='enm_seriesengine_options[audiobg]' type='text' value=\"{$audiobg}\" size='10' class='se-colorfield' />";
	};

	add_settings_field( 
		'enm_prayerengine_audioprog_style', 
		'Audio Player Progress Bar:', 
		'enm_seriesengine_audioprog_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_playerbox_settings' 
	);
	
	function enm_seriesengine_audioprog_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		if ( isset($se_options['audioprog']) ) {
			$audioprog = stripslashes($se_options['audioprog']);
		} else {
			$audioprog = 'cccccc';
		}
		echo "<div id='c-audioprog' class='se-colorpicker' style='background-color: #{$audioprog}'></div>#<input id='audioprog' name='enm_seriesengine_options[audioprog]' type='text' value=\"{$audioprog}\" size='10' class='se-colorfield' /><br /><br />";
	};

	add_settings_field( 
		'enm_prayerengine_playerdetailsbackground_style', 
		'Message Details Background:', 
		'enm_seriesengine_playerdetailsbackground_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_messagedetails_settings' 
	);
	
	function enm_seriesengine_playerdetailsbackground_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$playerdetailsbackground = stripslashes($se_options['playerdetailsbackground']);
		echo "<div id='c-playerdetailsbackground' class='se-colorpicker' style='background-color: #{$playerdetailsbackground}'></div>#<input id='playerdetailsbackground' name='enm_seriesengine_options[playerdetailsbackground]' type='text' value=\"{$playerdetailsbackground}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_detailstext_style', 
		'Text:', 
		'enm_seriesengine_detailstext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_messagedetails_settings' 
	);
	
	function enm_seriesengine_detailstext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$detailstext = stripslashes($se_options['detailstext']);
		echo "<div id='c-detailstext' class='se-colorpicker' style='background-color: #{$detailstext}'></div>#<input id='detailstext' name='enm_seriesengine_options[detailstext]' type='text' value=\"{$detailstext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_detailstitletext_style', 
		'Headings:', 
		'enm_seriesengine_detailstitletext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_messagedetails_settings' 
	);
	
	function enm_seriesengine_detailstitletext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$detailstitletext = stripslashes($se_options['detailstitletext']);
		echo "<div id='c-detailstitletext' class='se-colorpicker' style='background-color: #{$detailstitletext}'></div>#<input id='detailstitletext' name='enm_seriesengine_options[detailstitletext]' type='text' value=\"{$detailstitletext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_detailsrelatedtext_style', 
		'Labels for Scripture, Topics, and Series:', 
		'enm_seriesengine_detailsrelatedtext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_messagedetails_settings' 
	);
	
	function enm_seriesengine_detailsrelatedtext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$detailsrelatedtext = stripslashes($se_options['detailsrelatedtext']);
		echo "<div id='c-detailsrelatedtext' class='se-colorpicker' style='background-color: #{$detailsrelatedtext}'></div>#<input id='detailsrelatedtext' name='enm_seriesengine_options[detailsrelatedtext]' type='text' value=\"{$detailsrelatedtext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_detailslinks_style', 
		'Links:', 
		'enm_seriesengine_detailslinks_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_messagedetails_settings' 
	);
	
	function enm_seriesengine_detailslinks_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$detailslinks = stripslashes($se_options['detailslinks']);
		echo "<div id='c-detailslinks' class='se-colorpicker' style='background-color: #{$detailslinks}'></div>#<input id='detailslinks' name='enm_seriesengine_options[detailslinks]' type='text' value=\"{$detailslinks}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_downloadsbg_style', 
		'Files/Attachments Background:', 
		'enm_seriesengine_downloadsbg_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_messagedetails_settings' 
	);
	
	function enm_seriesengine_downloadsbg_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$downloadsbg = stripslashes($se_options['downloadsbg']);
		echo "<div id='c-downloadsbg' class='se-colorpicker' style='background-color: #{$downloadsbg}'></div>#<input id='downloadsbg' name='enm_seriesengine_options[downloadsbg]' type='text' value=\"{$downloadsbg}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_downloadlinks_style', 
		'Files/Attachments Links:', 
		'enm_seriesengine_downloadlinks_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_messagedetails_settings' 
	);
	
	function enm_seriesengine_downloadlinks_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$downloadlinks = stripslashes($se_options['downloadlinks']);
		echo "<div id='c-downloadlinks' class='se-colorpicker' style='background-color: #{$downloadlinks}'></div>#<input id='downloadlinks' name='enm_seriesengine_options[downloadlinks]' type='text' value=\"{$downloadlinks}\" size='10' class='se-colorfield' /><br /><br />";
	};
	
	//
	add_settings_field( 
		'enm_prayerengine_shareoptions_style', 
		'Classic Share Button Icons:', 
		'enm_seriesengine_shareoptions_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_sharing_settings' 
	);
	
	function enm_seriesengine_shareoptions_input() { 
		$se_options = get_option( 'enm_seriesengine_options' );
		$shareoptions = $se_options['shareoptions'];
		if ($shareoptions == "light") {
			echo "<select id='shareoptions' name='enm_seriesengine_options[shareoptions]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option></select>";
		} elseif ($shareoptions == "dark" ) {
			echo "<select id='shareoptions' name='enm_seriesengine_options[shareoptions]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option></select>";
		} else {
			echo "<select id='shareoptions' name='enm_seriesengine_options[shareoptions]'><option value='light'>Light</option><option value='dark'>Dark</option></select>";
		}
	};
	
	add_settings_field( 
		'enm_prayerengine_sharebuttonbackground_style', 
		'Share Button Background:', 
		'enm_seriesengine_sharebuttonbackground_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_sharing_settings' 
	);
	
	function enm_seriesengine_sharebuttonbackground_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$sharebuttonbackground = stripslashes($se_options['sharebuttonbackground']);
		echo "<div id='c-sharebuttonbackground' class='se-colorpicker' style='background-color: #{$sharebuttonbackground}'></div>#<input id='sharebuttonbackground' name='enm_seriesengine_options[sharebuttonbackground]' type='text' value=\"{$sharebuttonbackground}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_sharebuttontext_style', 
		'Share Button Text/Modern Icons:', 
		'enm_seriesengine_sharebuttontext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_sharing_settings' 
	);
	
	function enm_seriesengine_sharebuttontext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$sharebuttontext = stripslashes($se_options['sharebuttontext']);
		echo "<div id='c-sharebuttontext' class='se-colorpicker' style='background-color: #{$sharebuttontext}'></div>#<input id='sharebuttontext' name='enm_seriesengine_options[sharebuttontext]' type='text' value=\"{$sharebuttontext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_sharelinkbackground_style', 
		'Share Link Popover Background:', 
		'enm_seriesengine_sharelinkbackground_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_sharing_settings' 
	);
	
	function enm_seriesengine_sharelinkbackground_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$sharelinkbackground = stripslashes($se_options['sharelinkbackground']);
		echo "<div id='c-sharelinkbackground' class='se-colorpicker' style='background-color: #{$sharelinkbackground}'></div>#<input id='sharelinkbackground' name='enm_seriesengine_options[sharelinkbackground]' type='text' value=\"{$sharelinkbackground}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_sharelinktext_style', 
		'Share Link Popover Text:', 
		'enm_seriesengine_sharelinktext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_sharing_settings' 
	);
	
	function enm_seriesengine_sharelinktext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$sharelinktext = stripslashes($se_options['sharelinktext']);
		echo "<div id='c-sharelinktext' class='se-colorpicker' style='background-color: #{$sharelinktext}'></div>#<input id='sharelinktext' name='enm_seriesengine_options[sharelinktext]' type='text' value=\"{$sharelinktext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_sharelinkbuttonbackground_style', 
		'Share Link Popover Button:', 
		'enm_seriesengine_sharelinkbuttonbackground_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_sharing_settings' 
	);
	
	function enm_seriesengine_sharelinkbuttonbackground_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$sharelinkbuttonbackground = stripslashes($se_options['sharelinkbuttonbackground']);
		echo "<div id='c-sharelinkbuttonbackground' class='se-colorpicker' style='background-color: #{$sharelinkbuttonbackground}'></div>#<input id='sharelinkbuttonbackground' name='enm_seriesengine_options[sharelinkbuttonbackground]' type='text' value=\"{$sharelinkbuttonbackground}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_sharelinkbuttontext_style', 
		'Share Link Popover Button Text:', 
		'enm_seriesengine_sharelinkbuttontext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_sharing_settings' 
	);
	
	function enm_seriesengine_sharelinkbuttontext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$sharelinkbuttontext = stripslashes($se_options['sharelinkbuttontext']);
		echo "<div id='c-sharelinkbuttontext' class='se-colorpicker' style='background-color: #{$sharelinkbuttontext}'></div>#<input id='sharelinkbuttontext' name='enm_seriesengine_options[sharelinkbuttontext]' type='text' value=\"{$sharelinkbuttontext}\" size='10' class='se-colorfield' /><br /><br />";
	};
	
	//
	add_settings_field( 
		'enm_prayerengine_comptitletext_style', 
		'Related Messages Headings:', 
		'enm_seriesengine_comptitletext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_complimentary_settings' 
	);
	
	function enm_seriesengine_comptitletext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$comptitletext = stripslashes($se_options['comptitletext']);
		echo "<div id='c-comptitletext' class='se-colorpicker' style='background-color: #{$comptitletext}'></div>#<input id='comptitletext' name='enm_seriesengine_options[comptitletext]' type='text' value=\"{$comptitletext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_compoddrow_style', 
		'Message Rows:', 
		'enm_seriesengine_compoddrow_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_complimentary_settings' 
	);
	
	function enm_seriesengine_compoddrow_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$compoddrow = stripslashes($se_options['compoddrow']);
		echo "<div id='c-compoddrow' class='se-colorpicker' style='background-color: #{$compoddrow}'></div>#<input id='compoddrow' name='enm_seriesengine_options[compoddrow]' type='text' value=\"{$compoddrow}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_comprowtitletext_style', 
		'Message Titles:', 
		'enm_seriesengine_comprowtitletext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_complimentary_settings' 
	);
	
	function enm_seriesengine_comprowtitletext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$comprowtitletext = stripslashes($se_options['comprowtitletext']);
		echo "<div id='c-comprowtitletext' class='se-colorpicker' style='background-color: #{$comprowtitletext}'></div>#<input id='comprowtitletext' name='enm_seriesengine_options[comprowtitletext]' type='text' value=\"{$comprowtitletext}\" size='10' class='se-colorfield' />";
	};

	add_settings_field( 
		'enm_prayerengine_compaltrowtitletext_style', 
		'Message Alternate Row Title:', 
		'enm_seriesengine_compaltrowtitletext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_complimentary_settings' 
	);
	
	function enm_seriesengine_compaltrowtitletext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$compaltrowtitletext = stripslashes($se_options['compaltrowtitletext']);
		echo "<div id='c-compaltrowtitletext' class='se-colorpicker' style='background-color: #{$compaltrowtitletext}'></div>#<input id='compaltrowtitletext' name='enm_seriesengine_options[compaltrowtitletext]' type='text' value=\"{$compaltrowtitletext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_comprowdatetext_style', 
		'Dates/Speakers:', 
		'enm_seriesengine_comprowdatetext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_complimentary_settings' 
	);
	
	function enm_seriesengine_comprowdatetext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$comprowdatetext = stripslashes($se_options['comprowdatetext']);
		echo "<div id='c-comprowdatetext' class='se-colorpicker' style='background-color: #{$comprowdatetext}'></div>#<input id='comprowdatetext' name='enm_seriesengine_options[comprowdatetext]' type='text' value=\"{$comprowdatetext}\" size='10' class='se-colorfield' />";
	};

	add_settings_field( 
		'enm_prayerengine_compaltrowdatetext_style', 
		'Alternate Row Dates/Speakers:', 
		'enm_seriesengine_compaltrowdatetext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_complimentary_settings' 
	);
	
	function enm_seriesengine_compaltrowdatetext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$compaltrowdatetext = stripslashes($se_options['compaltrowdatetext']);
		echo "<div id='c-compaltrowdatetext' class='se-colorpicker' style='background-color: #{$compaltrowdatetext}'></div>#<input id='compaltrowdatetext' name='enm_seriesengine_options[compaltrowdatetext]' type='text' value=\"{$compaltrowdatetext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_complinks_style', 
		'Links:', 
		'enm_seriesengine_complinks_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_complimentary_settings' 
	);
	
	function enm_seriesengine_complinks_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$complinks = stripslashes($se_options['complinks']);
		echo "<div id='c-complinks' class='se-colorpicker' style='background-color: #{$complinks}'></div>#<input id='complinks' name='enm_seriesengine_options[complinks]' type='text' value=\"{$complinks}\" size='10' class='se-colorfield' /><br /><br />";
	};

	//
	add_settings_field( 
		'enm_prayerengine_gridrowbg_style', 
		'Background Color:', 
		'enm_seriesengine_gridrowbg_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_gridrow_settings' 
	);
	
	function enm_seriesengine_gridrowbg_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$gridrowbg = stripslashes($se_options['gridrowbg']);
		if ( !isset($se_options['gridrowbg']) ) {
			echo "<div id='c-gridrowbg' class='se-colorpicker' style='background-color: #f1f1f1'></div>#<input id='gridrowbg' name='enm_seriesengine_options[gridrowbg]' type='text' value=\"f1f1f1\" size='10' class='se-colorfield' />";
		} else {
			echo "<div id='c-gridrowbg' class='se-colorpicker' style='background-color: #{$gridrowbg}'></div>#<input id='gridrowbg' name='enm_seriesengine_options[gridrowbg]' type='text' value=\"{$gridrowbg}\" size='10' class='se-colorfield' />";
		}
	};

	add_settings_field( 
		'enm_prayerengine_gridrowtitle_style', 
		'Title/Date/Speaker Text:', 
		'enm_seriesengine_gridrowtitle_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_gridrow_settings' 
	);
	
	function enm_seriesengine_gridrowtitle_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$gridrowtitle = stripslashes($se_options['gridrowtitle']);
		if ( !isset($se_options['gridrowtitle']) ) {
			echo "<div id='c-gridrowtitle' class='se-colorpicker' style='background-color: #000000'></div>#<input id='gridrowtitle' name='enm_seriesengine_options[gridrowtitle]' type='text' value=\"000000\" size='10' class='se-colorfield' />";
		} else {
			echo "<div id='c-gridrowtitle' class='se-colorpicker' style='background-color: #{$gridrowtitle}'></div>#<input id='gridrowtitle' name='enm_seriesengine_options[gridrowtitle]' type='text' value=\"{$gridrowtitle}\" size='10' class='se-colorfield' />";
		}
	};	

	add_settings_field( 
		'enm_prayerengine_gridrowbible_style', 
		'Scripture Text:', 
		'enm_seriesengine_gridrowbible_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_gridrow_settings' 
	);
	
	function enm_seriesengine_gridrowbible_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$gridrowbible = stripslashes($se_options['gridrowbible']);
		if ( !isset($se_options['gridrowbible']) ) {
			echo "<div id='c-gridrowbible' class='se-colorpicker' style='background-color: #000000'></div>#<input id='gridrowbible' name='enm_seriesengine_options[gridrowbible]' type='text' value=\"000000\" size='10' class='se-colorfield' />";
		} else {
			echo "<div id='c-gridrowbible' class='se-colorpicker' style='background-color: #{$gridrowbible}'></div>#<input id='gridrowbible' name='enm_seriesengine_options[gridrowbible]' type='text' value=\"{$gridrowbible}\" size='10' class='se-colorfield' />";
		}
	};	

	add_settings_field( 
		'enm_prayerengine_gridrowfile_style', 
		'Attachment Link:', 
		'enm_seriesengine_gridrowfile_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_gridrow_settings' 
	);
	
	function enm_seriesengine_gridrowfile_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$gridrowfile = stripslashes($se_options['gridrowfile']);
		if ( !isset($se_options['gridrowfile']) ) {
			echo "<div id='c-gridrowfile' class='se-colorpicker' style='background-color: #94B83D'></div>#<input id='gridrowfile' name='enm_seriesengine_options[gridrowfile]' type='text' value=\"94B83D\" size='10' class='se-colorfield' />";
		} else {
			echo "<div id='c-gridrowfile' class='se-colorpicker' style='background-color: #{$gridrowfile}'></div>#<input id='gridrowfile' name='enm_seriesengine_options[gridrowfile]' type='text' value=\"{$gridrowfile}\" size='10' class='se-colorfield' />";
		}
	};

	add_settings_field( 
		'enm_prayerengine_gridrowmediabg_style', 
		'Button Background:', 
		'enm_seriesengine_gridrowmediabg_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_gridrow_settings' 
	);
	
	function enm_seriesengine_gridrowmediabg_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$gridrowmediabg = stripslashes($se_options['gridrowmediabg']);
		if ( !isset($se_options['gridrowmediabg']) ) {
			echo "<div id='c-gridrowmediabg' class='se-colorpicker' style='background-color: #94B83D'></div>#<input id='gridrowmediabg' name='enm_seriesengine_options[gridrowmediabg]' type='text' value=\"94B83D\" size='10' class='se-colorfield' />";
		} else {
			echo "<div id='c-gridrowmediabg' class='se-colorpicker' style='background-color: #{$gridrowmediabg}'></div>#<input id='gridrowmediabg' name='enm_seriesengine_options[gridrowmediabg]' type='text' value=\"{$gridrowmediabg}\" size='10' class='se-colorfield' />";
		}
	};

	add_settings_field( 
		'enm_prayerengine_gridrowmediatext_style', 
		'Button Text:', 
		'enm_seriesengine_gridrowmediatext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_gridrow_settings' 
	);
	
	function enm_seriesengine_gridrowmediatext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$gridrowmediatext = stripslashes($se_options['gridrowmediatext']);
		if ( !isset($se_options['gridrowmediatext']) ) {
			echo "<div id='c-gridrowmediatext' class='se-colorpicker' style='background-color: #ffffff'></div>#<input id='gridrowmediatext' name='enm_seriesengine_options[gridrowmediatext]' type='text' value=\"ffffff\" size='10' class='se-colorfield' />";
		} else {
			echo "<div id='c-gridrowmediatext' class='se-colorpicker' style='background-color: #{$gridrowmediatext}'></div>#<input id='gridrowmediatext' name='enm_seriesengine_options[gridrowmediatext]' type='text' value=\"{$gridrowmediatext}\" size='10' class='se-colorfield' />";
		}
	};	
	
	//
	add_settings_field( 
		'enm_prayerengine_loadingbackground_style', 
		'Loading Popover Background:', 
		'enm_seriesengine_loadingbackground_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_loading_settings' 
	);
	
	function enm_seriesengine_loadingbackground_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$loadingbackground = stripslashes($se_options['loadingbackground']);
		echo "<div id='c-loadingbackground' class='se-colorpicker' style='background-color: #{$loadingbackground}'></div>#<input id='loadingbackground' name='enm_seriesengine_options[loadingbackground]' type='text' value=\"{$loadingbackground}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_loadingtext_style', 
		'Loading Popover Text:', 
		'enm_seriesengine_loadingtext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_loading_settings' 
	);
	
	function enm_seriesengine_loadingtext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$loadingtext = stripslashes($se_options['loadingtext']);
		echo "<div id='c-loadingtext' class='se-colorpicker' style='background-color: #{$loadingtext}'></div>#<input id='loadingtext' name='enm_seriesengine_options[loadingtext]' type='text' value=\"{$loadingtext}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_loadingicon_style', 
		'Loading Popover Graphic:', 
		'enm_seriesengine_loadingicon_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_loading_settings' 
	);
	
	function enm_seriesengine_loadingicon_input() { 
		$se_options = get_option( 'enm_seriesengine_options' );
		$loadingicon = $se_options['loadingicon'];
		if ($loadingicon == "light") {
			echo "<select id='loadingicon' name='enm_seriesengine_options[loadingicon]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option></select><br /><br />";
		} elseif ($loadingicon == "dark" ) {
			echo "<select id='loadingicon' name='enm_seriesengine_options[loadingicon]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option></select><br /><br />";
		} else {
			echo "<select id='loadingicon' name='enm_seriesengine_options[loadingicon]'><option value='light'>Light</option><option value='dark'>Dark</option></select><br /><br />";
		}
	};

	
	add_settings_field( 
		'enm_prayerengine_archiverow_style', 
		'Alternate Row Background:', 
		'enm_seriesengine_archiverow_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_archives_settings' 
	);
	
	function enm_seriesengine_archiverow_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$archiverow = stripslashes($se_options['archiverow']);
		echo "<div id='c-archiverow' class='se-colorpicker' style='background-color: #{$archiverow}'></div>#<input id='archiverow' name='enm_seriesengine_options[archiverow]' type='text' value=\"{$archiverow}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_archiveseriestitle_style', 
		'Series Title:', 
		'enm_seriesengine_archiveseriestitle_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_archives_settings' 
	);
	
	function enm_seriesengine_archiveseriestitle_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$archiveseriestitle = stripslashes($se_options['archiveseriestitle']);
		echo "<div id='c-archiveseriestitle' class='se-colorpicker' style='background-color: #{$archiveseriestitle}'></div>#<input id='archiveseriestitle' name='enm_seriesengine_options[archiveseriestitle]' type='text' value=\"{$archiveseriestitle}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_archivedatecount_style', 
		'Date and Message Count:', 
		'enm_seriesengine_archivedatecount_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_archives_settings' 
	);
	
	function enm_seriesengine_archivedatecount_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$archivedatecount = stripslashes($se_options['archivedatecount']);
		echo "<div id='c-archivedatecount' class='se-colorpicker' style='background-color: #{$archivedatecount}'></div>#<input id='archivedatecount' name='enm_seriesengine_options[archivedatecount]' type='text' value=\"{$archivedatecount}\" size='10' class='se-colorfield' />";
	};
	
	add_settings_field( 
		'enm_prayerengine_archivelinks_style', 
		'Explore Links:', 
		'enm_seriesengine_archivelinks_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_archives_settings' 
	);
	
	function enm_seriesengine_archivelinks_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$archivelinks = stripslashes($se_options['archivelinks']);
		echo "<div id='c-archivelinks' class='se-colorpicker' style='background-color: #{$archivelinks}'></div>#<input id='archivelinks' name='enm_seriesengine_options[archivelinks]' type='text' value=\"{$archivelinks}\" size='10' class='se-colorfield' /><br /><br />";
	};

	add_settings_field( // Pagination Styles
		'enm_seriesengine_pagebuttonbg_style', 
		'Next/Back Button Background:', 
		'enm_seriesengine_pagebuttonbg_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_pagination_settings' 
	);
	
	function enm_seriesengine_pagebuttonbg_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$pagebuttonbg = stripslashes($se_options['pagebuttonbg']);
		echo "<div id='c-pagebuttonbg' class='se-colorpicker' style='background-color: #{$pagebuttonbg}'></div>#<input id='pagebuttonbg' name='enm_seriesengine_options[pagebuttonbg]' type='text' value=\"{$pagebuttonbg}\" size='10' class='se-colorfield' />";
	};

	add_settings_field( 
		'enm_seriesengine_pagebuttontext_style', 
		'Next/Back Button Text:', 
		'enm_seriesengine_pagebuttontext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_pagination_settings' 
	);
	
	function enm_seriesengine_pagebuttontext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$pagebuttontext = stripslashes($se_options['pagebuttontext']);
		echo "<div id='c-pagebuttontext' class='se-colorpicker' style='background-color: #{$pagebuttontext}'></div>#<input id='pagebuttontext' name='enm_seriesengine_options[pagebuttontext]' type='text' value=\"{$pagebuttontext}\" size='10' class='se-colorfield' />";
	};

	add_settings_field( 
		'enm_seriesengine_pagenumber_style', 
		'Page Numbers:', 
		'enm_seriesengine_pagenumber_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_pagination_settings' 
	);
	
	function enm_seriesengine_pagenumber_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$pagenumber = stripslashes($se_options['pagenumber']);
		echo "<div id='c-pagenumber' class='se-colorpicker' style='background-color: #{$pagenumber}'></div>#<input id='pagenumber' name='enm_seriesengine_options[pagenumber]' type='text' value=\"{$pagenumber}\" size='10' class='se-colorfield' />";
	};

	add_settings_field( 
		'enm_seriesengine_pagenumberselectedbg_style', 
		'Current Page Number Background:', 
		'enm_seriesengine_pagenumberselectedbg_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_pagination_settings' 
	);
	
	function enm_seriesengine_pagenumberselectedbg_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$pagenumberselectedbg = stripslashes($se_options['pagenumberselectedbg']);
		echo "<div id='c-pagenumberselectedbg' class='se-colorpicker' style='background-color: #{$pagenumberselectedbg}'></div>#<input id='pagenumberselectedbg' name='enm_seriesengine_options[pagenumberselectedbg]' type='text' value=\"{$pagenumberselectedbg}\" size='10' class='se-colorfield' />";
	};

	add_settings_field( 
		'enm_seriesengine_pagenumberselectedtext_style', 
		'Current Page Number Text:', 
		'enm_seriesengine_pagenumberselectedtext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_pagination_settings' 
	);
	
	function enm_seriesengine_pagenumberselectedtext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$pagenumberselectedtext = stripslashes($se_options['pagenumberselectedtext']);
		echo "<div id='c-pagenumberselectedtext' class='se-colorpicker' style='background-color: #{$pagenumberselectedtext}'></div>#<input id='pagenumberselectedtext' name='enm_seriesengine_options[pagenumberselectedtext]' type='text' value=\"{$pagenumberselectedtext}\" size='10' class='se-colorfield' /><br /><br />";
	};
	
	add_settings_field(
		'enm_prayerengine_poweredby_style', 
		'"Powered By" Logo:', 
		'enm_seriesengine_poweredby_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_poweredby_settings' 
	);
	
	function enm_seriesengine_poweredby_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$poweredby = $se_options['poweredby'];
		if ($poweredby == "light") {
			echo "<select id='poweredby' name='enm_seriesengine_options[poweredby]'><option value='light' selected='selected'>Light</option><option value='dark'>Dark</option><option value='text'>Small Text Instead of Logo</option><option value='hide'>Hide Series Engine brand completely</option></select>";
		} elseif ($poweredby == "dark" ) {
			echo "<select id='poweredby' name='enm_seriesengine_options[poweredby]'><option value='light'>Light</option><option value='dark' selected='selected'>Dark</option><option value='text'>Small Text Instead of Logo</option><option value='hide'>Hide Series Engine brand completely</option></select>";
		} elseif ($poweredby == "hide" ) {
			echo "<select id='poweredby' name='enm_seriesengine_options[poweredby]'><option value='light'>Light</option><option value='dark'>Dark</option><option value='text'>Small Text Instead of Logo</option><option value='hide' selected='selected'>Hide Series Engine brand completely</option></select>";
		} else {
			echo "<select id='poweredby' name='enm_seriesengine_options[poweredby]'><option value='light'>Light</option><option value='dark'>Dark</option><option value='text' selected='selected'>Small Text Instead of Logo</option><option value='hide'>Hide Series Engine brand completely</option></select>";
		}
	};
	
	add_settings_field( 
		'enm_prayerengine_poweredbytext_style', 
		'"Powered By" Text:', 
		'enm_seriesengine_poweredbytext_input', 
		'seriesengine_plugin', 
		'enm_seriesengine_poweredby_settings' 
	);
	
	function enm_seriesengine_poweredbytext_input() {
		$se_options = get_option( 'enm_seriesengine_options' );
		$poweredbytext = stripslashes($se_options['poweredbytext']);
		echo "<div id='c-poweredbytext' class='se-colorpicker' style='background-color: #{$poweredbytext}'></div>#<input id='poweredbytext' name='enm_seriesengine_options[poweredbytext]' type='text' value=\"{$poweredbytext}\" size='10' class='se-colorfield' /><br /><br />";
	};
	
	
	// Validate Series Engine Settings
	function enm_seriesengine_validate_options($input) {
		$valid['responsivefull'] = $input['responsivefull'];
		$valid['responsivemobile'] = $input['responsivemobile'];
		$valid['responsivecondensed'] = $input['responsivecondensed'];
		$valid['pag'] = $input['pag'];
		$valid['apag'] = $input['apag'];
		$valid['placeholderimage'] = $input['placeholderimage'];
		$valid['imagearchivetext'] = $input['imagearchivetext'];
		$valid['widgetwidth'] = $input['widgetwidth'];
		$valid['newgraphicwidth'] = $input['newgraphicwidth'];
		$valid['maxwidth'] = $input['maxwidth'];
		$valid['newarchiveswidth'] = $input['newarchiveswidth'];
		$valid['archiveliststyle'] = $input['archiveliststyle'];
		$valid['primaryst'] = $input['primaryst'];
		$valid['videotablabel'] = $input['videotablabel'];
		$valid['audiotablabel'] = $input['audiotablabel'];
		//$valid['enableseraw'] = $input['enableseraw'];
		$valid['id3'] = $input['id3'];
		$valid['topicsort'] = $input['topicsort'];
		$valid['default_podcast_series'] = $input['default_podcast_series'];
		$valid['noajax'] = $input['noajax'];
		$valid['cardview'] = $input['cardview'];
		$valid['language'] = $input['language'];
		$valid['languageprev'] = $input['languageprev'];
		$valid['bibleoption'] = $input['bibleoption'];
		$valid['playerstyle'] = $input['playerstyle'];
		$valid['deftrans'] = $input['deftrans'];
		$valid['forcedownload'] = $input['forcedownload'];
		$valid['timely'] = $input['timely'];
		$valid['nofonta'] = $input['nofonta'];
		$valid['font'] = strip_tags( $input['font'] );
		$valid['customfont'] = strip_tags( $input['customfont'] );
		$valid['explorerbackground'] = strip_tags( $input['explorerbackground'] );
		$valid['explorerselectborder'] = strip_tags( $input['explorerselectborder'] );
		$valid['explorerselect'] = strip_tags( $input['explorerselect'] );
		$valid['explorerselecttext'] = strip_tags( $input['explorerselecttext'] );
		//$valid['explorerbutton'] = strip_tags( $input['explorerbutton'] );
		//$valid['explorerbuttontext'] = strip_tags( $input['explorerbuttontext'] );
		$valid['mstitletext'] = strip_tags( $input['mstitletext'] );
		$valid['msdatetext'] = strip_tags( $input['msdatetext'] );

		$valid['seriest'] = strip_tags( $input['seriest'] );
		$valid['seriestp'] = strip_tags( $input['seriestp'] );

		$valid['topict'] = strip_tags( $input['topict'] );
		$valid['topictp'] = strip_tags( $input['topictp'] );

		$valid['speakert'] = strip_tags( $input['speakert'] );
		$valid['speakertp'] = strip_tags( $input['speakertp'] );

		$valid['messaget'] = strip_tags( $input['messaget'] );
		$valid['messagetp'] = strip_tags( $input['messagetp'] );

		$valid['bookt'] = strip_tags( $input['bookt'] );
		$valid['booktp'] = strip_tags( $input['booktp'] );

		$valid['scripturelabel'] = strip_tags( $input['scripturelabel'] );

		$valid['borderoption'] = strip_tags( $input['borderoption'] );
		$valid['playerbordercolor'] = strip_tags( $input['playerbordercolor'] );
		$valid['playerselectedtabbackground'] = strip_tags( $input['playerselectedtabbackground'] );
		$valid['playerselectedtabtext'] = strip_tags( $input['playerselectedtabtext'] );
		$valid['playertabbackground'] = strip_tags( $input['playertabbackground'] );
		$valid['playertabtext'] = strip_tags( $input['playertabtext'] );
		$valid['playerdetailsbackground'] = strip_tags( $input['playerdetailsbackground'] );
		$valid['audiobg'] = strip_tags( $input['audiobg'] );
		$valid['audioprog'] = strip_tags( $input['audioprog'] );
		$valid['playeroptions'] = strip_tags( $input['playeroptions'] );
		$valid['detailstext'] = strip_tags( $input['detailstext'] );
		$valid['detailstitletext'] = strip_tags( $input['detailstitletext'] );
		$valid['detailsrelatedtext'] = strip_tags( $input['detailsrelatedtext'] );
		$valid['detailslinks'] = strip_tags( $input['detailslinks'] );
		$valid['downloadsbg'] = strip_tags( $input['downloadsbg'] );
		$valid['downloadlinks'] = strip_tags( $input['downloadlinks'] );
		$valid['shareoptions'] = strip_tags( $input['shareoptions'] );
		$valid['sharebuttonbackground'] = strip_tags( $input['sharebuttonbackground'] );
		$valid['sharebuttontext'] = strip_tags( $input['sharebuttontext'] );
		$valid['sharelinkbackground'] = strip_tags( $input['sharelinkbackground'] );
		$valid['sharelinktext'] = strip_tags( $input['sharelinktext'] );
		$valid['sharelinkbuttonbackground'] = strip_tags( $input['sharelinkbuttonbackground'] );
		$valid['sharelinkbuttontext'] = strip_tags( $input['sharelinkbuttontext'] );
		$valid['comptitletext'] = strip_tags( $input['comptitletext'] );
		$valid['compaltrowtitletext'] = strip_tags( $input['compaltrowtitletext'] );
		$valid['compoddrow'] = strip_tags( $input['compoddrow'] );
		$valid['comprowtitletext'] = strip_tags( $input['comprowtitletext'] );
		$valid['comprowdatetext'] = strip_tags( $input['comprowdatetext'] );
		$valid['compaltrowdatetext'] = strip_tags( $input['compaltrowdatetext'] );
		$valid['complinks'] = strip_tags( $input['complinks'] );
		$valid['gridrowbg'] = strip_tags( $input['gridrowbg'] );
		$valid['gridrowtitle'] = strip_tags( $input['gridrowtitle'] );
		$valid['gridrowbible'] = strip_tags( $input['gridrowbible'] );
		$valid['gridrowfile'] = strip_tags( $input['gridrowfile'] );
		$valid['gridrowmediabg'] = strip_tags( $input['gridrowmediabg'] );
		$valid['gridrowmediatext'] = strip_tags( $input['gridrowmediatext'] );
		$valid['loadingbackground'] = strip_tags( $input['loadingbackground'] );
		$valid['loadingtext'] = strip_tags( $input['loadingtext'] );
		$valid['loadingicon'] = strip_tags( $input['loadingicon'] );
		$valid['archiverow'] = strip_tags( $input['archiverow'] );
		$valid['archiveseriestitle'] = strip_tags( $input['archiveseriestitle'] );
		$valid['archivedatecount'] = strip_tags( $input['archivedatecount'] );
		$valid['archivelinks'] = strip_tags( $input['archivelinks'] );
		$valid['poweredby'] = strip_tags( $input['poweredby'] );
		$valid['poweredbytext'] = strip_tags( $input['poweredbytext'] );

		$valid['pagebuttonbg'] = strip_tags( $input['pagebuttonbg'] );
		$valid['pagebuttontext'] = strip_tags( $input['pagebuttontext'] );
		$valid['pagenumber'] = strip_tags( $input['pagenumber'] );
		$valid['pagenumberselectedbg'] = strip_tags( $input['pagenumberselectedbg'] );
		$valid['pagenumberselectedtext'] = strip_tags( $input['pagenumberselectedtext'] );

		$valid['usepermalinks'] = $input['usepermalinks'];
		$valid['permalinkslug'] = $input['permalinkslug'];
		$valid['permalink_ogtags'] = $input['permalink_ogtags'];
		$valid['permalink_show_post_type'] = $input['permalink_show_post_type'];
		//$valid['permalink_single_seriestype'] = $input['permalink_single_seriestype'];
		$valid['permalink_single_explorer'] = $input['permalink_single_explorer'];
		$valid['permalink_single_explorer_series'] = $input['permalink_single_explorer_series'];
		$valid['permalink_single_explorer_speaker'] = $input['permalink_single_explorer_speaker'];
		$valid['permalink_single_explorer_topics'] = $input['permalink_single_explorer_topics'];
		$valid['permalink_single_explorer_books'] = $input['permalink_single_explorer_books'];
		$valid['permalink_single_related'] = $input['permalink_single_related'];
		$valid['permalink_single_related_cardview'] = $input['permalink_single_related_cardview'];
		$valid['permalink_single_pag'] = $input['permalink_single_pag'];
		$valid['permalink_single_apag'] = $input['permalink_single_apag'];
		$valid['permalink_single_blurb'] = $input['permalink_single_blurb'];
		$valid['default_permalink_prefix'] = $input['default_permalink_prefix'];
		$valid['default_permalink_speaker'] = $input['default_permalink_speaker'];

		$valid['lang_fromseries'] = $input['lang_fromseries'];
		$valid['lang_sharelinktitle'] = $input['lang_sharelinktitle'];
		$valid['lang_sharelinkinstructions'] = $input['lang_sharelinkinstructions'];
		$valid['lang_sharelinkclosebutton'] = $input['lang_sharelinkclosebutton'];
		$valid['lang_archiveexplore'] = $input['lang_archiveexplore'];
		$valid['lang_explorerbrowseseries'] = $input['lang_explorerbrowseseries'];
		$valid['lang_explorerbrowsespeakers'] = $input['lang_explorerbrowsespeakers'];
		$valid['lang_explorerbrowsetopics'] = $input['lang_explorerbrowsetopics'];
		$valid['lang_explorerbrowsebooks'] = $input['lang_explorerbrowsebooks'];
		$valid['lang_explorerarchives'] = $input['lang_explorerarchives'];
		$valid['lang_explorermessages'] = $input['lang_explorermessages'];
		$valid['lang_relatedtopics'] = $input['lang_relatedtopics'];
		$valid['lang_moremessagesfrom'] = $input['lang_moremessagesfrom'];
		$valid['lang_downloadaudio'] = $input['lang_downloadaudio'];
		$valid['lang_sharefb'] = $input['lang_sharefb'];
		$valid['lang_sharetw'] = $input['lang_sharetw'];
		$valid['lang_sharepop'] = $input['lang_sharepop'];
		$valid['lang_shareemail'] = $input['lang_shareemail'];
		$valid['lang_morefromtopics'] = $input['lang_morefromtopics'];
		$valid['lang_morefrombooks'] = $input['lang_morefrombooks'];
		$valid['lang_morefromspeakers'] = $input['lang_morefromspeakers'];
		$valid['lang_morefromgeneric'] = $input['lang_morefromgeneric'];
		$valid['lang_morefromseries'] = $input['lang_morefromseries'];
		$valid['lang_pagemore'] = $input['lang_pagemore'];
		$valid['lang_pageback'] = $input['lang_pageback'];
		$valid['lang_loading'] = $input['lang_loading'];
		$valid['lang_podcastmessagefrom'] = $input['lang_podcastmessagefrom'];
		$valid['lang_permaclicktoview'] = $input['lang_permaclicktoview'];
		$valid['lang_permalinkblankexcerpt'] = $input['lang_permalinkblankexcerpt'];

		if ( empty( $input['permalinkslug'] ) ) { 
			$valid['permalinkslug'] = 'messages';
		}

		if ( empty( $input['permalink_single_pag'] ) ) { 
			$valid['permalink_single_pag'] = '10';
		}

		if ( empty( $input['permalink_single_apag'] ) ) { 
			$valid['permalink_single_apag'] = '12';
		}


		if ( !is_numeric($input['responsivefull']) ) {
			add_settings_error( 'enm_seriesengine_responsivefull_input', 'enm_seriesengine_texterror', 'You must enter a valid width for the full responsive view.', 'error' );
			$valid['responsivefull'] = '900';
		}

		if ( !is_numeric($input['responsivemobile']) ) {
			add_settings_error( 'enm_seriesengine_responsivemobile_input', 'enm_seriesengine_texterror', 'You must enter a valid width for the mobile responsive view.', 'error' );
			$valid['responsivemobile'] = '900';
		}

		if ( !is_numeric($input['responsivecondensed']) ) {
			add_settings_error( 'enm_seriesengine_responsivecondensed_input', 'enm_seriesengine_texterror', 'You must enter a valid width for the condensed mobile responsive view.', 'error' );
			$valid['responsivecondensed'] = '900';
		}

		if ( !is_numeric($input['pag']) ) {
			add_settings_error( 'enm_seriesengine_pag_input', 'enm_seriesengine_texterror', 'You must enter a valid number for the amount of related messages you want to display on a page.', 'error' );
			$valid['pag'] = '10';
		}

		if ( !is_numeric($input['apag']) ) {
			add_settings_error( 'enm_seriesengine_pag_input', 'enm_seriesengine_texterror', 'You must enter a valid number for the amount of series you want to display on an archive page.', 'error' );
			$valid['apag'] = '12';
		}

		if ( !is_numeric($input['newgraphicwidth']) ) {
			add_settings_error( 'enm_seriesengine_newgraphicwidth_input', 'enm_seriesengine_texterror', 'You must enter a valid width for your series graphics.', 'error' );
			$valid['newgraphicwidth'] = '1000';
		}

		if ( !is_numeric($input['maxwidth']) ) {
			add_settings_error( 'enm_seriesengine_maxwidth_input', 'enm_seriesengine_texterror', 'You must enter a valid maximum width for your Series Engine embeds.', 'error' );
			$valid['maxwidth'] = '1000';
		}

		if ( !is_numeric($input['newarchiveswidth']) ) {
			add_settings_error( 'enm_seriesengine_newarchiveswidth_input', 'enm_seriesengine_texterror', 'You must enter a valid width for your series archives graphics.', 'error' );
			$valid['newarchiveswidth'] = '600';
		}

		if ( !is_numeric($input['widgetwidth']) ) {
			add_settings_error( 'enm_seriesengine_widgetwidth_input', 'enm_seriesengine_texterror', 'You must enter a valid width for the size of the Series graphics used in your widgets.', 'error' );
			$valid['widgetwidth'] = '200';
		}
		
		/*if ( empty( $input['enableseraw'] ) ) {
			$valid['enableseraw'] = '0';
		}*/
		
		if ( empty( $input['font'] ) ) {
			$valid['font'] = 'arial';
		}
		
		if ( empty( $input['explorertitletext'] ) ) {
			$valid['explorertitletext'] = '000000';
		}
		
		if ( empty( $input['explorerbackground'] ) ) {
			$valid['explorerbackground'] = 'f1f1f1';
		}
		
		if ( empty( $input['explorerselectborder'] ) ) {
			$valid['explorerselectborder'] = 'd0d0d0';
		}
		
		if ( empty( $input['explorerselect'] ) ) {
			$valid['explorerselect'] = 'f1f1f1';
		}
		
		if ( empty( $input['explorerselecttext'] ) ) {
			$valid['explorerselecttext'] = '000000';
		}
		
		/*if ( empty( $input['explorerbutton'] ) ) {
			$valid['explorerbutton'] = '486d7d';
		}*/
		
		/*if ( empty( $input['explorerbuttontext'] ) ) {
			$valid['explorerbuttontext'] = 'ffffff';
		}*/
		
		if ( empty( $input['mstitletext'] ) ) {
			$valid['mstitletext'] = '000000';
		}
		
		if ( empty( $input['msdatetext'] ) ) {
			$valid['msdatetext'] = '000000';
		}
		
		if ( empty( $input['playerbordercolor'] ) ) {
			$valid['playerbordercolor'] = 'b6b5b5';
		}

		if ( empty( $input['playerselectedtabbackground'] ) ) {
			$valid['playerselectedtabbackground'] = 'b6b5b5';
		}
		
		if ( empty( $input['playerselectedtabtext'] ) ) {
			$valid['playerselectedtabtext'] = '000000';
		}
		
		if ( empty( $input['playertabbackground'] ) ) {
			$valid['playertabbackground'] = 'dcdbdb';
		}
		
		if ( empty( $input['playertabtext'] ) ) {
			$valid['playertabtext'] = '929292';
		}
		
		if ( empty( $input['playerdetailsbackground'] ) ) {
			$valid['playerdetailsbackground'] = 'f1f1f1';
		}

		if ( empty( $input['audiobg'] ) ) {
			$valid['audiobg'] = '000000';
		}

		if ( empty( $input['audioprog'] ) ) {
			$valid['audioprog'] = 'cccccc';
		}
		
		if ( empty( $input['playeroptions'] ) ) {
			$valid['playeroptions'] = 'dark';
		}
		
		if ( empty( $input['detailstext'] ) ) {
			$valid['detailstext'] = '000000';
		}
		
		if ( empty( $input['detailstitletext'] ) ) {
			$valid['detailstitletext'] = '000000';
		}
		
		if ( empty( $input['detailsrelatedtext'] ) ) {
			$valid['detailsrelatedtext'] = '000000';
		}
		
		if ( empty( $input['detailslinks'] ) ) {
			$valid['detailslinks'] = '486d7d';
		}
		
		if ( empty( $input['downloadsbg'] ) ) {
			$valid['downloadsbg'] = 'e6e6e6';
		}
		
		if ( empty( $input['downloadlinks'] ) ) {
			$valid['downloadlinks'] = '486d7d';
		}
		
		if ( empty( $input['shareoptions'] ) ) {
			$valid['shareoptions'] = 'light';
		}
		
		if ( empty( $input['sharebuttonbackground'] ) ) {
			$valid['sharebuttonbackground'] = '676767';
		}
		
		if ( empty( $input['sharebuttontext'] ) ) {
			$valid['sharebuttontext'] = 'ffffff';
		}
		
		if ( empty( $input['sharelinkbackground'] ) ) {
			$valid['sharelinkbackground'] = '373737';
		}
		
		if ( empty( $input['sharelinktext'] ) ) {
			$valid['sharelinktext'] = 'd9d9d9';
		}
		
		if ( empty( $input['sharelinkbuttonbackground'] ) ) {
			$valid['sharelinkbuttonbackground'] = '486d7d';
		}
		
		if ( empty( $input['sharelinkbuttontext'] ) ) {
			$valid['sharelinkbuttontext'] = 'ffffff';
		}
		
		if ( empty( $input['comptitletext'] ) ) {
			$valid['comptitletext'] = '000000';
		}

		if ( empty( $input['compaltrowtitletext'] ) ) {
			$valid['compaltrowtitletext'] = '000000';
		}
		
		if ( empty( $input['compoddrow'] ) ) {
			$valid['compoddrow'] = 'f1f1f1';
		}
		
		if ( empty( $input['comprowtitletext'] ) ) {
			$valid['comprowtitletext'] = '000000';
		}
		
		if ( empty( $input['comprowdatetext'] ) ) {
			$valid['comprowdatetext'] = '000000';
		}

		if ( empty( $input['compaltrowdatetext'] ) ) {
			$valid['compaltrowdatetext'] = '000000';
		}
		
		if ( empty( $input['complinks'] ) ) {
			$valid['complinks'] = '486d7d';
		}


		if ( empty( $input['gridrowbg'] ) ) {
			$valid['gridrowbg'] = 'f1f1f1';
		}
		if ( empty( $input['gridrowtitle'] ) ) {
			$valid['gridrowtitle'] = '000000';
		}
		if ( empty( $input['gridrowbible'] ) ) {
			$valid['gridrowbible'] = '000000';
		}
		if ( empty( $input['gridrowfile'] ) ) {
			$valid['gridrowfile'] = '94B83D';
		}
		if ( empty( $input['gridrowmediabg'] ) ) {
			$valid['gridrowmediabg'] = '94B83D';
		}
		if ( empty( $input['gridrowmediatext'] ) ) {
			$valid['gridrowmediatext'] = 'ffffff';
		}

		
		if ( empty( $input['loadingbackground'] ) ) {
			$valid['loadingbackground'] = '373737';
		}
		
		if ( empty( $input['loadingtext'] ) ) {
			$valid['loadingtext'] = 'd9d9d9';
		}
		
		if ( empty( $input['loadingicon'] ) ) {
			$valid['loadingicon'] = 'light';
		}
		
		if ( empty( $input['archiverow'] ) ) {
			$valid['archiverow'] = 'f1f1f1';
		}
		
		if ( empty( $input['archiveseriestitle'] ) ) {
			$valid['archiveseriestitle'] = '000000';
		}
		
		if ( empty( $input['archivedatecount'] ) ) {
			$valid['archivedatecount'] = '000000';
		}
		
		if ( empty( $input['archivelinks'] ) ) {
			$valid['archivelinks'] = '486d7d';
		}
		
		if ( empty( $input['poweredby'] ) ) {
			$valid['poweredby'] = 'light';
		}
		
		if ( empty( $input['poweredbytext'] ) ) {
			$valid['poweredbytext'] = 'd2d2d2';
		}


		if ( empty( $input['pagebuttonbg'] ) ) { 
			$valid['pagebuttonbg'] = '94B83D';
		}

		if ( empty( $input['pagebuttontext'] ) ) { 
			$valid['pagebuttontext'] = 'cee39a';
		}

		if ( empty( $input['pagenumber'] ) ) { 
			$valid['pagenumber'] = 'D4D4D4';
		}

		if ( empty( $input['pagenumberselectedbg'] ) ) { 
			$valid['pagenumberselectedbg'] = 'f1f1f1';
		}

		if ( empty( $input['pagenumberselectedtext'] ) ) { 
			$valid['pagenumberselectedtext'] = 'D4D4D4';
		}

		if ( $input['language'] == 10 ) { //French
			include(dirname(__FILE__) . '/../lang/fre_default_values.php');
		} elseif ( $input['language'] == 9 ) { //Russian
			include(dirname(__FILE__) . '/../lang/rus_default_values.php');
		} elseif ( $input['language'] == 8 ) { //Japanese
			include(dirname(__FILE__) . '/../lang/jap_default_values.php');
		} elseif ( $input['language'] == 7 ) { //Dutch
			include(dirname(__FILE__) . '/../lang/dut_default_values.php');
		} elseif ( $input['language'] == 6 ) { //Traditional Chinese
			include(dirname(__FILE__) . '/../lang/chint_default_values.php');
		} elseif ( $input['language'] == 5 ) { //Simplified Chinese
			include(dirname(__FILE__) . '/../lang/chins_default_values.php');
		} elseif ( $input['language'] == 4 ) { //Turkish
			include(dirname(__FILE__) . '/../lang/turk_default_values.php');
		} elseif ( $input['language'] == 3 ) { //German
			include(dirname(__FILE__) . '/../lang/ger_default_values.php');
		} elseif ( $input['language'] == 2 ) { // Spanish
			include(dirname(__FILE__) . '/../lang/spa_default_values.php');
		} else { // English
			include(dirname(__FILE__) . '/../lang/eng_default_values.php');
		}

		if ( $input['languageprev'] == "" || ( $input['languageprev'] >= 1 && ( $input['languageprev'] != $input['language'] ) ) ) {
			if ( $input['language'] == 10 ) { //French
				include(dirname(__FILE__) . '/../lang/fre_trans.php');
			} elseif ( $input['language'] == 9 ) { //Russian
				include(dirname(__FILE__) . '/../lang/rus_trans.php');
			} elseif ( $input['language'] == 8 ) { //Japanese
				include(dirname(__FILE__) . '/../lang/jap_trans.php');
			} elseif ( $input['language'] == 7 ) { //Dutch
				include(dirname(__FILE__) . '/../lang/dut_trans.php');
			} elseif ( $input['language'] == 6 ) { //Traditional Chinese
				include(dirname(__FILE__) . '/../lang/chint_trans.php');
			} elseif ( $input['language'] == 5 ) { //Simplified Chinese
				include(dirname(__FILE__) . '/../lang/chins_trans.php');
			} elseif ( $input['language'] == 4 ) { //Turkish
				include(dirname(__FILE__) . '/../lang/turk_trans.php');
			} elseif ( $input['language'] == 3 ) { //German
				include(dirname(__FILE__) . '/../lang/ger_trans.php');
			} elseif ( $input['language'] == 2 ) { // Spanish
				include(dirname(__FILE__) . '/../lang/spa_trans.php');
			} else { // English
				include(dirname(__FILE__) . '/../lang/eng_trans.php');
			}
		}
		
		return $valid; 
	};

 ?>