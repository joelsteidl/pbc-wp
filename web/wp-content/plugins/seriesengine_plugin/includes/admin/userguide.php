<?php /* ----- Series Engine - Admin User Guide ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		$enmse_options = get_option( 'enm_seriesengine_options' ); 
		if ( isset($enmse_options['newgraphicwidth']) ) { // Find the width of the series graphics
			$enmse_embedwidth = $enmse_options['newgraphicwidth'];
		} else {
			$enmse_embedwidth = 1000;
		}
		if ( isset($enmse_options['newarchiveswidth']) ) { // Find the width of the archives graphic
			$enmse_archivewidth = $enmse_options['newarchiveswidth'];
		} else {
			$enmse_archivewidth = 600;
		}
		$enmse_widgetwidth = $enmse_options['widgetwidth'];
		$enmse_size = wp_max_upload_size();
		function ByteSize($bytes)  
		    { 
		    $size = $bytes / 1024; 
		    if($size < 1024) 
		        { 
		        $size = number_format($size, 2); 
		        $size .= ' KB'; 
		        }  
		    else  
		        { 
		        if($size / 1024 < 1024)  
		            { 
		            $size = number_format($size / 1024, 2); 
		            $size .= ' MB'; 
		            }  
		        else if ($size / 1024 / 1024 < 1024)   
		            { 
		            $size = number_format($size / 1024 / 1024, 2); 
		            $size .= ' GB'; 
		            }  
		        } 
		    return $size; 
		    } 

		$enmse_filesize = ByteSize($enmse_size);
	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap"> 
    <div></div>
	<h2 class="enmse">Using the Series Engine Plugin</h2>
	
	<p>&nbsp;</p>
	
	<blockquote>
	<ul>
		<li style="font-size: 1.2em; margin-bottom: 16px;"><strong><a href="#se-videoguides">NEW: Video Guides!</a></strong></li>
		<li><a href="#se-gettingstarted">Getting Started</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-embed">- Embedding Series Engine into a Page/Post</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-settings">- Changing Series Engine Settings</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-language">- Choose Your Language Settings</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-styles">- Choosing Fonts and Colors</a></li>
		<li><a href="#se-customizing">Customizing Series Engine Pages</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-simpleembed">- Simple Shortcode</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-advancedembed">- Advanced Shortcode Generator</a></li>
		<li><a href="#se-permalinks">About Permalinks in Series Engine</a></li>
		<li><a href="#se-aboutav">About Audio/Video in Series Engine</a></li>
		<li><a href="#se-import">Importing Content from a Previous Series Engine Install</a></li>
		<li><a href="#se-bulk">Bulk Uploading Content</a></li>
		<li><a href="#se-managing">Managing Series Engine Content</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-seriestypes">- Series Types</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-series">- Series</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-topics">- Topics</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-speakers">- Speakers</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#se-messages">- Messages</a></li>
		<li><a href="#se-podcasts">Managing Podcasts</a></li>
		<li><a href="#se-widgets">Managing Series Engine Widgets</a></li>
		<li><a href="#se-users">Managing Series Engine Users</a></li>
		<li><a href="#se-updates">Updating the Series Engine Plugin</a></li>
		<li><a href="#se-troubleshooting">FAQ/Troubleshooting</a></li>
		<li><strong><a href="#se-twozero">Updating to Version 2.7</a></strong></li>
		<li><strong><a href="#se-otherplugins">Importing from Other Plugins</a></strong></li>
		<li><a href="#se-usage">Acceptable Usage and Legal</a></li>
	</ul>
	</blockquote>
	<p>&nbsp;</p>
	<div id="enmse-se-logo"></div>
	
	<div id="enmse-user-guide">
	<h1 id="se-videoguides">NEW: Check Out Our Video Guides!</h1>
	<p>In addition to the thourough user guide below, we also recently published a large library of visual guides that makes it easier than ever to get started with Series Engine.</p>
	<p>You can check those out <a href="https://seriesengine.com/tutorials/install.php" target="_blank">on the "Guides" page of seriesengine.com</a>.</p>
	
	<h1 id="se-gettingstarted">Getting Started</h1>
	
	<p>Congratulations! If you're reading this, you have successfully installed the Series Engine plugin on your WordPress site. You're only seconds away from creating your first Series Engine media page. Getting started is easy:</p>

	<h3 id="se-embed">1) Embed Series Engine into a Page/Post</h3>

	<p>Adding Series Engine to a Page/Post on your site couldn't be easier. Simply edit the Page/Post where you want to include a Series Engine media browser, and place the <strong>[seriesengine]</strong> shortcode on its own line anywhere you like in the Page/Post.</p>
	<p>Save your changes, and you should now see the Series Engine media browser among the other content in your Page/Post.</p>
	<p>Want to customize the content that's displayed? Jump ahead to <a href="#se-customizing">Customizing Your Series Engine Pages</a></p>

	<h3 id="se-settings">2) Change Series Engine Settings</h3>

	<p>Before you begin using Series Engine throughout your site, you may want to customize a few of the Series Engine plugin settings. To do this, simply navigate to <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a>.</p>
	<p>From this page, you'll be able to change the width of the images used throughout the plugin, customize labels, set the permalink slug you want to use for Messages, and more. You'll also want to choose the type of Series Archives to display. When you're done, simply choose "Save Changes" at the bottom of the page.</p>
	<p><em>Please note: You can adjust Series Engine settings at any time, and all changes will be preserved when you update the plugin to the newest version. Uninstalling the plugin will permanently delete any changes that you've made.</em></p>

	<h3 id="se-language">3) Choose Your Language</h3>

	<p>Series Engine offers official translations for English, German, and Spanish, with more translations on the way in the coming months. To change your language settings, visit <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a> and select the "Labels and Language" tab at the top of the page.</p>
	<p>If your ministry uses a language that isn't officially supported yet, this screen also gives you complete control over every piece of text that your users will see. Modify the labels as you fit, and your changes will be immediately reflected on the site. If you want us to work on an official translation for you, submit a request using the form <a href="http://seriesengine.com/questions.php">at the top of the Questions page at seriesengine.com</a>.</p>
	<p><em>Please note that official translations only effect the front-end Series Engine content (your embedded shortcodes, podcasts, Bible references, widgets, etc). New Bible references will reflect the change, but previous references will not. Language customizations only effect the modern layout released in v2.5. All admin functions will remain in English.</em></p>

	<h3 id="se-styles">4) Choose Fonts and Colors for Your Embed</h3>

	<p>Series Engine was built to fit right into your site; with a few quick tweaks to your font and color settings, you can style Series Engine to complement just about any theme.</p>
	<p>Navigate to <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a>. Near the top of the page, choose the "Fonts and Colors" option.</p>
	<p>To change the font of your Series Engine media browser, simply check the box next to the font family you would like to use.</p>
	<p>To adjust the color of various Series Engine elements, simply click the input field of the item you want to change, and select a new color using the color picker.</p>
	<p>When you've made all of the changes you want, click " Save Changes" at the bottom of the page. Your style changes will now be reflected on all Series Engine media browsers throughout your site.</p>
	
	<h3>5) Go Update Your Permalinks</h3>

	<p>To make sure Series Engine's permalinks are working correctly, stop by Settings > Permalinks and just click save at the bottom of the page (no need to change any settings here unless you want to). Sometimes it can take WordPress a while to recognize a new permalink schema, and this will address that right away.</p>
	
	<h1 id="se-customizing">Customizing Your Series Engine Pages</h1>

	<p>Series Engine is great for creating a quick media page on your website, but it can do so much more than that! You can embed Series Engine an unlimited number of times throughout your site to accomplish a variety of goals.</p>
	<p>Look over the two ways to embed Series Engine into your Pages/Posts:</p>

	<h3 id="se-simpleembed">Simple Shortcode</h3>

	<p>Want to get something up and running quickly? Include the simple shortcode on any Page/Post to include the most recent message from your Primary Series Type. The simple shortcode also includes the Message Explorer and a list of Related Messages.</p>

	<h3 id="se-advancedembed">Generating a Custom Shortcode</h3>

	<p>Need to embed a variety of content throughout your site? The Custom Custom Shortcode Generator is where the magic happens!</p>
	<p>For example, a church using Series Engine on their site might use this tool too:</p>
	<ul>
		<li>Embed every message on the Topic of "Hope" into the pastor's most recent blog post.</li>
		<li>Embed a media page on the Women's Ministry section of the website that only contains media from women's Series.</li>
		<li>Embed a specific message about Marriage (without any other browsing options) onto a counseling page.</li>
		<li>Embed only a recent giving Series onto a "Give Online" page</li>
		<li>Embed all Messages from the book of Acts into a blog post about the early church</li>
		<li>...and much more!</li>
	</ul>
	<p>To get started, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_embed"; ?>">Series Engine > Get Shortcode</a>. At the top of the page, select "Custom Shortcode." </p>
	<p>Start at the top of the page, and simply select what you want to display from the drop-down menus. Once you've made your selections, click the "Generate Code" button at the bottom of the page to create a custom shortcode that includes your chosen options.</p>
	<p>To use the shortcode, simply copy the text out of the textarea at the bottom of the page and place it on its own line in the editor for any Page/Post. </p>
	<p>Remember, you can create as many custom embeds as you like! Your media is no longer confined to a single page of your website.</p>
	
	<h1 id="se-permalinks">About Permalinks in Series Engine</h1>

	<p>Series Engine automatically generates pretty, SEO-friendly permalinks for each Message. Permalinks can be accessed from the Share menu of every Message, where you'll find one-click options for sharing on Facebook, Twitter, Email, or by copying a link.</p>
	<p>A wealth of permalink settings can be found in <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine > Advanced</a>, where you can change the slug used with Series Engine permalinks and change the options for what is displayed on each permalinked Message page.</p>

	<h3>Changing the Permalink Slug</h3>

	<p>By default, your permalinks will resemble:</p>
	<p><em>http://yoursite.com/<strong>messages</strong>/the-message-title-here</em></p>
	<p>You can easily change the permalink slug structure (highlighted above) in <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine > Advanced</a>.</p>
	<p>If you change your slug, your previously shared Series Engine permalinks will no longer work. You'll also need to head over to Settings > Permalinks and save the page there so the new permalink slug structure will kick in.</p>
	<p>If you just want to adjust the message title as seen in the permalink, you can do this in each Message's "Advanced Settings" tab (when you're editing the Message).</p>
	
	<h3>Customizing Permalink Pages</h3>

	<p>By default, your permalinks are shown in your theme's single.php and archives.php templates. If you would like to customize these pages in your theme, you can create single page and archive templates specifically for Series Engine permalink pages by placing files named "single-enmse_message.php" and "archive-enmse_message.php" in your theme's main directory. Customize these as you see fit, but please note that we do not provide support of any kind for theme customization of this nature.</p>
	<p>If you want to add additional content to your permalink pages on a case-by-case basis, you can turn on the Custom Post Type view in <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine > Advanced</a> and edit the permalink pages in the new "Messages" menu in the WordPress dashboard. This is for advanced users only, as it can get confusing to see Series Engine content in two places (and deleting these pages can permenantly break your permalinks).</p>
	
	<h3>About Permalink Search Results</h3>
	<p>Permalink pages also show up when someone searches for a Message using the native search function on your site. The title and excerpt are automatically generated from your Message details, and will resemble the format below:</p>
	<p><em>Message Label: "The Message Title Here" from Speaker Name</em></p>
	<p><em>A message from the series "The Primary Series Title Here." The message description follows here.</em></p>

	<h1 id="se-aboutav">About Audio/Video in Series Engine</h1>

	<p>The Series Engine plugin is the best way to mange your video and audio files from across the web in one simple interface.</p>

	<h3>Video Content</h3>

	<p>Most Series Engine users approach video content from a BYOV (Bring Your Own Video!) perspective. Series Engine allows you to import video content from the great services you already use: Vimeo, YouTube, etc. If you can generate an embed code with the video service, you can use it with Series Engine.</p>
	<p>Previous versions of the plugin <em>required</em> video content to be hosted with outside sites, but Series Engine can now display self-hosted video content in its native (MediaElement-based) video player. You'll find more details on this in the User Guide below.</p>
	<p><em>Please note: video podcasts are a little more advanced and require you to upload a properly formatted video file to your web host and supply Series Engine with a link to that file. More details in the <a href="#se-podcasts">Podcasting section</a> of this guide.</em></p>

	<h3>Audio Content</h3>

	<p>To display audio on your pages, Series Engine includes the awesome <a href="http://mediaelementjs.com/" target="_blank">MediaElement.js</a> framework to allow your visitors to listen to an MP3 on your site directly within their web browser.</p>
	<p>To accomplish this, you'll need to upload an MP3 using WordPress (if your <a href="#se-audio-troubleshooting">upload file-size limit</a> allows this), or upload the MP3 to your web host and supply Series Engine with a link to that file. Series Engine will use the same MP3 file to create your audio podcasts as well.</p>

	<h1 id="se-import">Importing Content from a Previous Series Engine Install</h1>

	<p>Whether you're changing web hosts or just starting fresh with a new site, it's easy to move your Series Engine content and settings from one site to another.</p>
	<p>Please follow the instructions on <a href="http://seriesengine.com/importexport.php" target="_blank">this support document on our website</a>.</p>

	<h1 id="se-bulk">Bulk Uploading Content</h1>

	<p>Even if you're not a previous Series Engine user, it is now possible to bulk upload large message libraries into Series Engine with a single .CSV file. Bulk imports are only recommended for advanced users who are comfortable with data entry and a text editor.</p>
	<p>Please follow the instructions on <a href="http://seriesengine.com/importexport.php#bulk" target="_blank">this support document on our website</a>.</p>

	<h1 id="se-managing">Managing Series Engine Content</h1>

	<h2 id="se-seriestypes">Managing Series Types</h2>

	<h3>What is a Series Type?</h3>

	<p>The "Series Type" field is an organizational value (invisible to your visitors) that will help you control how content is displayed throughout your site. Some users will need to create many, and some users will only need one. You can build your Series Engine plugin to be as simple or robust as you like!</p>
	<p>How about a quick example based on a church using Series Engine... </p>
	<p>On their main media page, the church wants to display all Sunday Morning Series. To accomplish this, they've created the Series Type "Sunday Morning Series" and have assigned a number of Series to this Series Type. The custom embed code they placed on their main media page is set to show the most recent message from any Series with the Series Type of "Sunday Morning Series."</p>
	<p>Later on, their Women's ministry decides that they want to have a Women's Media page on their section of the website. To accomplish this with the Series Engine, the church simply creates a new Series Type ("Women's Series") and associates all women's Series with this Series Type. With all of this set up, the church can now create Series and Messages that will only be displayed on the Women's Media page. </p>

	<h3>Setting a Primary Series Type</h3>

	<p>Series Engine requires that you set a Primary Series Type to use throughout the plugin. Series Engine will make this the default value when creating a new Series, using the Simple Embed Code and more. If you're using only one Series Type in your setup, the Primary Series Type is set to this Series Type by default.</p>
	<p>To change the Primary Series Type, navigate to <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a>. On the "General Settings" tab, select your preferred Primary Series Type from the drop-down menu at the top of the page, and select "Save Changes" at the bottom of the page when you're finished.</p>
	<p><em>Please note: the Series Type currently selected as the Primary Series Type cannot be deleted. If you want to delete that Series Type, you'll need to first choose another Series Type to be Primary.</em></p>

	<h3>Creating a New Series Type</h3>

	<p>To create a new Series Type, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes"; ?>">Series Engine > Edit Series Types</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to give your Series Type a Name (required) and a description (optional). When you're done, click "Add New Series Type" to add the Series Type to Series Engine.</p>

	<h3>Editing an Existing Series Type</h3>

	<p>To edit an existing Series Type, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes"; ?>">Series Engine > Edit Series Types</a>. Click on the title of the Series Type that you would like to edit.</p>
	<p>Use the provided form to edit the name (required) and the description (optional). When you're done, click "Save Changes" at the bottom of the page.</p>
	<p>If you would like to edit the order in which your Series Types appear throughout the admin interface, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes"; ?>">Series Engine > Edit Series Types</a>,  click the sort icon beside a Series Type's title and drag the entire row to another position in the list.</p>

	<h3>Deleting a Series Type</h3>

	<p>To delete a Series Type, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_seriestypes"; ?>">Series Engine > Edit Series Types</a>. From this list, find the Series Type you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p>Remember, a Series Type cannot be deleted while it is set as the Primary Series Type.</p>
	<p><em>Please note: Deleting a Series Type will not remove associated Series/Messages, but it will likely interfere with any custom Series Engine embeds that you have previously set up. You may need to generate new embed codes for those pages.</em></p>





	<h2 id="se-topics">Managing Topics</h2>

	<h3>What is a Topic?</h3>

	<p>A Topic in Series Engine works similarly to topics/tags/keywords in many other platforms; it gives your users a way to browse your messages beyond the context of a group of Series. Your messages may have one Topic, no Topics or many Topics! Use this feature as often or as little as you like.</p>
	<p>Using a church for an example, the staff may want to associate an Easter message with the Topics of "Hope" and "Salvation."</p>

	<h3>Creating a New Topic</h3>

	<p>You can create a new Topic in two ways: as you're creating/editing a Message, or directly from the admin portal.</p>
	<p>To create a new Topic from the admin portal, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_topics"; ?>">Series Engine > Edit Topics</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to give your Topic a name and click "Add New Topic" to add the Topic to Series Engine.</p>
	<p>You can also create a new Topic while you're actively creating/editing a Message. In the "Associate with Topics" section of the page, simply enter a title into the input area and click the "Add New Topic" button. </p>

	<h3>Editing an Existing Topic</h3>

	<p>To edit an existing Topic, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_topics"; ?>">Series Engine > Edit Topics</a>. Click on the title of the Topic that you would like to edit.</p>
	<p>Use the provided form to edit the name, and click "Save Changes" at the bottom of the page.</p>
	<p>If you would like to edit the order in which your Topics appear throughout Series Engine, navigate to the "Edit Topics" page, click the sort icon beside a Topic's title and drag the entire row to another position in the list.</p>

	<h3>Deleting a Topic</h3>

	<p>To delete a Topic, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_topics"; ?>">Series Engine > Edit Topics</a>. From this list, find the Topic you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p><em>Please note: Deleting a Series Type will not remove associated Series/Messages, but it might interfere with any custom Series Engine embeds that you have previously set up. You may need to generate new embed codes for those pages.</em></p>




	<h2 id="se-speakers">Managing Speakers</h2>
	
	<h3>What is a Speaker?</h3>
	
	<p>A Speaker in Series Engine is essentially the author of a Message; it gives your users another way to browse your Messages beyond the context of a group of Series. Each Message must be associated with a Speaker.</p>
	
	<h3>Creating a New Speaker</h3>
	
	<p>You can create a new Speaker in two ways: as you're creating/editing a Message, or directly from the admin portal.</p>
	<p>To create a new Speaker from the admin portal, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers"; ?>">Series Engine > Edit Speakers</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to give your Speaker a first and last name and click "Add New Speaker" to add the Speaker to Series Engine.</p>
	<p>You can also create a new Speaker while you're actively creating/editing a Message. In the "Speaker" section of the page, select "Add a New Speaker" from the dropdown menu and complete the quick form to add a new Speaker to your Message. </p>
	
	<h3>Editing an Existing Speaker</h3>
	
	<p>To edit an existing Speaker, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers"; ?>">Series Engine > Edit Speakers</a>. Click on the name of the Speaker that you would like to edit.</p>
	<p>Use the provided form to edit the name, and click "Save Changes" at the bottom of the page.</p>
	
	<h3>Deleting a Speaker</h3>
	
	<p>To delete a Speaker, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_speakers"; ?>">Series Engine > Edit Speakers</a>. From this list, find the Speaker you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p><em>Please note: A speaker cannot be deleted while it is associated with any number of Messages. Choose alternative Speakers for those Messages first, and then you will be able to delete the Speaker from Series Engine.</em></p>

	<h3>Did you upgrade from an older version of the plugin?</h3>
	<p>Older versions of the Series Engine plugin handled Speakers in a different fashion than the current release. Series Engine will maintain your previously entered Speakers for simple public display, but you will need to re-enter your Speakers with the new system in order to be able to sort by Speaker in the media browser, widgets and podcasts.</p>

	
	
	
	
	<h2 id="se-series">Managing Series</h2>

	<h3>What is a Series?</h3>

	<p>Simply put, a Series is a group of Messages. When users visit one of your Series Engine pages, they can view a specific Message and a chronological list of other Messages within its Series. A Series can contain unlimited Messages, and a Message can be associated with an unlimited number of Series.</p>
	<p>Using a church as an example, the staff might organize their 8-week study of the Song of Solomon into a Series called "Love Song." They may also associate one of those Messages with an ongoing Series on marriage called "From Two to One." The Message would appear under both Series lists when users browse their Series Engine pages.</p>

	<h3>Creating a New Series</h3>

	<p>To create a new Series, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series"; ?>">Series Engine > Edit Series</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to provide details about your new Series:</p>
	
	<ul>
		<li><strong>Name</strong> (required) - The title of your new series.</li>
		<li><strong>Description</strong> - An optional description of the Series. This will be displayed in the "Details" section of your public Series Engine media browser.</li>
		<li><strong>Start Date</strong> (required) - Series are organized chronologically in your public Series Engine media browser.</li>
		<li><strong>URL to Series Graphic</strong> (recommended) - Provide the URL to (or upload) a graphic to be displayed alongside of the audio version of your Messages. According to your current settings, the graphic should be sized to <strong><?php echo $enmse_embedwidth; ?>px wide</strong>.</li>
		<li><strong>URL to Series Archive Graphic</strong> (recommended) - Provide the URL to (or upload) a graphic to be displayed in the Series Archives if you're using the image-based archive browser (an option found in Settings). According to your current settings, the graphic should be sized to <strong><?php echo $enmse_archivewidth; ?>px wide</strong>. If you upload a Series Engine Graphic, an Archive graphic will be created for you automatically.</li>
		<li><strong>URL to Widget Graphic</strong> (recommended) - Provide the URL to (or upload) a graphic to be displayed in Series Engine widgets (if selected during widget creation). According to your current settings, the graphic should be sized to <strong><?php echo $enmse_widgetwidth; ?>px wide</strong>. If you upload a Series Engine Graphic, a Widget graphic will be created for you automatically.</li>
		<li><strong>URL to Podcast Graphic</strong> (recommended) - Provide the URL to (or upload) a graphic to be displayed for Messages from this Series in various podcast feeds. Podcast images should be at least 1400x1400 and no greater than 3000x3000.</li>
		<li><strong>Series Type(s)</strong> (required) - Every Series must be associated with at least one Series Type. You can learn more about <a href="#se-seriestypes">Series Types here</a>.</li>
	</ul>
	<p>When you're finished, click "Add New Series" at the bottom of the page.</p>

	<h3>Editing an Existing Series</h3>

	<p>To edit an existing Series, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series"; ?>">Series Engine > Edit Series</a>. Find the title of the Series you would like to edit, and click on it to be taken to the edit screen.</p>
	<p>Use the provided form to update the details of your Series:</p>
	<ul>
		<li><strong>Name</strong> (required) - The title of your series.</li>
		<li><strong>Description</strong> - An optional description of the Series. This will be displayed in the "Details" section of your public Series Engine media browser.</li>
		<li><strong>Start Date</strong> (required) - Series are organized chronologically in your public Series Engine media browser.</li>
		<li><strong>URL to Series Graphic</strong> (recommended) - Provide the URL to (or upload) a graphic to be displayed alongside of the audio version of your Messages. According to your current settings, the graphic should be sized to <strong><?php echo $enmse_embedwidth; ?>px wide</strong>.</li>
		<li><strong>URL to Series Archive Graphic</strong> (recommended) - Provide the URL to (or upload) a graphic to be displayed in the Series Archives if you're using the image-based archive browser (an option found in Settings). According to your current settings, the graphic should be sized to <strong><?php echo $enmse_archivewidth; ?>px wide</strong>. If you upload a Series Engine Graphic, an Archive graphic will be created for you automatically.</li>
		<li><strong>URL to Widget Graphic</strong> (recommended) - Provide the URL to (or upload) a graphic to be displayed in Series Engine widgets (if selected during widget creation). According to your current settings, the graphic should be sized to <strong><?php echo $enmse_widgetwidth; ?>px wide</strong>. If you upload a Series Engine Graphic, a Widget graphic will be created for you automatically.</li>
		<li><strong>URL to Podcast Graphic</strong> (recommended) - Provide the URL to (or upload) a graphic to be displayed for Messages from this Series in various podcast feeds. Podcast images should be at least 1400x1400 and no greater than 3000x3000.</li>
		<li><strong>Series Type(s)</strong> (required) - Every Series must be associated with at least one Series Type. You can learn more about <a href="#se-seriestypes">Series Types here</a>.</li>
		<li><strong>Series Archived?</strong> - You can archive a Series to clean up the Series explorer and move a Series out of the main media browser pages. Archived Series will only be displayed as part of a Message's details, and on the Series Archives page.</li>
	</ul>
	<p>When you're finished, click "Save Changes" at the bottom of the page.</p>

	<h3>Deleting a Series</h3>

	<p>To delete a Series, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_series"; ?>">Series Engine > Edit Series</a>. From this list, find the Series you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p><em>Please note: Deleting a Series will not remove associated Messages from Series Engine, but it might interfere with any custom Series Engine embeds that you have previously set up. You may need to generate new embed codes for those pages.</em></p>


	<h2 id="se-messages">Managing Messages</h2>

	<h3>What is a Message?</h3>

	<p>Messages are the cornerstone of Series Engine, and the main attraction for users visiting your media pages. Each Message can contain both video and audio content. </p>
	<p>Using a church for an example, the staff might post a new Message to a Series every week containing a video version of the Message, an audio recording of the Message, and a video clip of the worship service that's displayed in the "Alternate Media" tab.</p>

	<h3>Creating a New Message</h3>

	<p>To create a new Message, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php"; ?>">Series Engine > Series Engine</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to input the details of your new Message:</p>

	<h4>General Information</h4>
	<ul>
		<li><strong>Title</strong> (required) - The title of your Message.</li>
		<li><strong>Speaker</strong> (required) - The speaker/author/performer of your Message.</li>
		<li><strong>Date</strong> (required) - The date your message was first publicly available.</li>
		<li><strong>Description</strong> - An optional description of the Message. This will be displayed in the "Details" section of your public Series Engine media browser.</li>
		<li><strong>Audio URL</strong> - The URL to the MP3 file for an audio version of your Message. Depending on your WordPress upload limit (currently <strong><?php echo $enmse_filesize; ?></strong>), you may be able to upload the file directly with the WordPress media browser. The same MP3 is used for the Series Engine media browser and any podcasts you create.</li>
		<li><strong>Video Embed Code</strong> - The iframe embed code from Vimeo, YouTube or another video hosting company will go here. If you use YouTube, Vimeo, or Facebook, you can also simply paste the video URL in this field and Series Engine will automatically create the appropriate embed code when you save the Message. Choose a large size for your embeds by default; Series Engine will automatically adjust the size for different devices with its responsive stylesheet.</li>
		<li><strong>Video URL</strong> - If you would like to use a self-hosted video, enter the full file path to a video file here. For best results across a wide range of devices, use .mp4 files. If your PHP upload limit is high enough (set by your web host), you may be able to upload and use video clips from WordPress's native media browser. <em>Note: If both a video embed code and video url are present, the video embed code will be displayed instead of the self-hosted clip.</em></li>
		<li><strong>Add to Series</strong> - For best results, each Message should be associated with at least one Series. You can learn more about <a href="#se-series">Series here</a>.</li>
		<li><strong>Primary Series</strong> - If a Message is associated with multiple Series, choose the primary one here. In instances where only one Series association in shown (like podcasts), Series Engine will pull in info for the primary Series.</li>		
		<li><strong>Associate with Topics</strong> - You can associate your Message with as few or as many Topics as you like. You can read more about <a href="#se-topics">Topics here</a>.</li>
	</ul>
	<h4>Advanced Settings</h4>
	<ul>
		<li><strong>Alternate Date</strong> - If your Message was made available at another time or venue, you can list the alternate date here. It will show up beside the original date in the related messages list of the Series Engine media browser.</li>
		<li><strong>Message Thumbnail</strong> - Provide the URL to (or upload) a graphic to be displayed alongside of the audio version of your Messages. This will override any graphic you may have assigned to the Series the Message is associated with. According to your current settings, the graphic should be sized to <strong><?php echo $enmse_embedwidth; ?>px wide</strong> wide. You can also select the "Series Engine Graphic" Size during the upload process to have the image automatically resized for you.</li>
		<li><strong>Additional Video</strong> - Some users may have an additional video clip that supports the main video media for the Message (think trailers, announcements, supplemental materials, etc). Change this setting to "Yes" to pull in an additional video clip using the settings below.</li>
		<li><strong>Label</strong> - The title of the tab displaying the alternate video clip in the Series Engine media browser.</li>
		<li><strong>Additional Embed Code</strong> - The iframe embed code from Vimeo, YouTube or another video hosting company will go here. If you use YouTube, Vimeo, or Facebook, you can also simply paste the video URL in this field and Series Engine will automatically create the appropriate embed code when you save the Message. Choose a large size for your embeds by default; Series Engine will automatically adjust the size for different devices with its responsive stylesheet.</li>
		<li><strong>Additional Video URL</strong> - If you would like to use a self-hosted video for the additional video clip, enter the full file path to a video file here. For best results across a wide range of devices, use .mp4 files. If your PHP upload limit is high enough (set by your web host), you may be able to upload and use video clips from WordPress's native media browser. <em>Note: If both an additional video embed code and additional video url are present, the additional video embed code will be displayed instead of the self-hosted clip.</em></li>
		<li><strong>Permalink Comments</strong> - Enable or disable comments on your permalink Message pages. Comments will not appear in other views throughout Series Engine.</li>
	</ul>
	<h4>Scripture References</h4>
	<p>Series Engine allows you to attach an unlimited number of scripture references to each Message. If a Message has scripture messsages associated with it, Bible.com links to these references will be visible in the Message's "Details" section in the Series Engine media browser. If a scripture reference is marked as a "focus passage," the reference will also be shown alongside of the Message information in Related Message lists, and the Message will be associated with the chosen Book of the Bible for search in the "Browse Books" search menu.</p>
	<ul>
		<li><strong>Start Verse</strong> - Choose the book of the bible, the chapter, and the starting verse.</li>
		<li><strong>End Verse</strong> - Choose the ending verse. If left the same as the starting verse, your reference will link to just one verse. If different than the starting verse, your reference will link to the chosen passage. Please note that all scripture references must be from the same chapter (it's a limitation of bible.com links!).</li>
		<li><strong>Translation</strong> - Choose from a list of supported Bible translations. Each scripture reference can have a different translation if you wish.</li>
		<li><strong>Focus Passage?</strong> - If a scriptured reference is marked as a "focus passage," the reference will also be shown alongside of the message information in related message lists, and the message will be associated with the chosen book of the bible for search in the "Browse Books" search menu. You can have as many focus passages as you like.</li>
		<li><strong>Editing, Reordering and Deleting References</strong> - Use the sort column to drag-and-drop your scripture references in the desired order. Click on the title of the scripture reference to edit its details. Click the red "Delete" link to permanently remove the scripture reference from the Message.</li>
	</ul>
	<h4>Podcast Settings</h4>
	<ul>
		<li><strong>Audio Length</strong> - The length of the audio message in minutes and seconds. Series Engine will automatically generate this value for you for most MP3s. (ex: 31:22)</li>
		<li><strong>Audio URL</strong> - The URL to the MP3 file for an audio version of your Message. Depending on your WordPress upload limit (currently <strong><?php echo $enmse_filesize; ?></strong>), you may be able to upload the file directly with the WordPress media browser. The same MP3 is used for the Series Engine media browser and any podcasts you create.</li>
		<li><strong>Audio File Size</strong> - The length of the MP3 file (specified above) in bytes. Series Engine will automatically generate this value for you for most MP3s. You can also find this by right clicking and choosing "Get Info" on a Mac, or choosing "Properties" in Windows.</li>
		<li><strong>Video Length</strong> - The length of the video message in minutes and seconds. (ex: 31:22)</li>
		<li><strong>Video URL</strong> - The URL to the video file you're supplying for any video podcasts. Since these files are far too large to upload with WordPress, you'll need to manually upload the video file into a publicly available location on your web server. You can find information on formatting your video files <a href="http://www.apple.com/itunes/podcasts/specs.html#formattingvideo" target="_blank">on Apple's site</a>.</li>
		<li><strong>Video File Size</strong> - The length of the video file (specified above) in bytes. Series Engine will automatically generate this value for you for most files. You can also find this by right clicking and choosing "Get Info" on a Mac, or choosing "Properties" in Windows.</li>
		<li><strong>Podcast Image</strong> - If you would like a unique image to be displayed with this Message in your podcast feeds (overriding the Series image, if the Message is associated with one), you can provide the image here. Podcast images must be at least 1400x1400 and no greater than 3000x3000.</li>
	</ul>
	
	<h4>Attach Link/Download</h4>
	<p>Series Engine allows you to attach an unlimited number of related links or downloads to each of your Messages (ex: links for event registration, study guide downloads, etc). If a Message has links or downloads associated with it, links to these items will be visible in a new box at the top of the Message's "Details" section in the Series Engine media browser.</p>
	<ul>
		<li><strong>Name</strong> - Give your link/download a title. If you're posting a download, its a good idea to include the file type in parenthesis. <em>Ex: Study Guide (PDF)</em></li>
		<li><strong>Link/File URL</strong> - Provide a URL for your link or file download. You can also upload files and insert a link using WordPress's file upload tool (depending on your WordPress upload limit). If you need to link to large downloads like audio or video, you'll need to upload the files elsewhere and manually enter the URL.</li>
		<li><strong>Open File in New Window?</strong> - Choose whether you want the file link to open in the same window, or a new one.</li>
		<li><strong>Featured?</strong> - If you would like a file to be displayed in your Related Messages lists throughout the plugin, you can set it as "Featured." Only one file can be featured per message. Featured files will still be displayed alongside of other Message files in the Message "details" section.</li>
		<li><strong>Editing, Reordering and Deleting Items</strong> - Use the sort column to drag-and-drop your links and downloads in the desired order. Click on the name of the link/download to edit its details. Click the red "Delete" link to permanently remove the link/download from the Message (this will NOT delete the file itself from WordPress or another server).</li>
	</ul>
	
	<p>When you're finished, click "Add New Message" at the bottom of the page.

	<h3>Editing an Existing Message</h3>

	<p>To edit an existing Message, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php"; ?>">Series Engine > Series Engine</a>. Find the title of the Message you would like to edit, and click on it to be taken to the edit screen.</p>
	<p>Use the provided form to update the details of your Message:</p>

	<h4>General Information</h4>
	<ul>
		<li><strong>Title</strong> (required) - The title of your Message.</li>
		<li><strong>Speaker</strong> (required) - The speaker/author/performer of your Message.</li>
		<li><strong>Date</strong> (required) - The date your message was first publicly available.</li>
		<li><strong>Description</strong> - An optional description of the Message. This will be displayed in the "Details" section of your public Series Engine media browser.</li>
		<li><strong>Audio URL</strong> - The URL to the MP3 file for an audio version of your Message. Depending on your WordPress upload limit (currently <strong><?php echo $enmse_filesize; ?></strong>), you may be able to upload the file directly with the WordPress media browser. The same MP3 is used for the Series Engine media browser and any podcasts you create.</li>
		<li><strong>Video Embed Code</strong> - The iframe embed code from Vimeo, YouTube or another video hosting company will go here. If you use YouTube, Vimeo, or Facebook, you can also simply paste the video URL in this field and Series Engine will automatically create the appropriate embed code when you save the Message. Choose a large size for your embeds by default; Series Engine will automatically adjust the size for different devices with its responsive stylesheet.</li>
		<li><strong>Video URL</strong> - If you would like to use a self-hosted video, enter the full file path to a video file here. For best results across a wide range of devices, use .mp4 files. If your PHP upload limit is high enough (set by your web host), you may be able to upload and use video clips from WordPress's native media browser. <em>Note: If both a video embed code and video url are present, the video embed code will be displayed instead of the self-hosted clip.</em></li>
		<li><strong>Add to Series</strong> - For best results, each Message should be associated with at least one Series. You can learn more about <a href="#se-series">Series here</a>.</li>
		<li><strong>Primary Series</strong> - If a Message is associated with multiple Series, choose the primary one here. In instances where only one Series association in shown (like podcasts), Series Engine will pull in info for the primary Series.</li>				
		<li><strong>Associate with Topics</strong> - You can associate your Message with as few or as many Topics as you like. You can read more about <a href="#se-topics">Topics here</a>.</li>
	</ul>
	<h4>Advanced Settings</h4>
	<ul>
		<li><strong>Alternate Date</strong> - If your Message was made available at another time or venue, you can list the alternate date here. It will show up beside the original date in the related messages list of the Series Engine media browser.</li>
		<li><strong>Message Thumbnail</strong> - Provide the URL to (or upload) a graphic to be displayed alongside of the audio version of your Messages. This will override any graphic you may have assigned to the Series the Message is associated with. According to your current settings, the graphic should be sized to <strong><?php echo $enmse_embedwidth; ?>px wide</strong> wide. You can also select the "Series Engine Graphic" Size during the upload process to have the image automatically resized for you.</li>
		<li><strong>Additional Video</strong> - Some users may have an additional video clip that supports the main video media for the Message (think trailers, announcements, supplemental materials, etc). Change this setting to "Yes" to pull in an additional video clip using the settings below.</li>
		<li><strong>Label</strong> - The title of the tab displaying the alternate video clip in the Series Engine media browser.</li>
		<li><strong>Alternate Embed Code</strong> - The iframe embed code from Vimeo, YouTube or another video hosting company will go here. If you use YouTube, Vimeo, or Facebook, you can also simply paste the video URL in this field and Series Engine will automatically create the appropriate embed code when you save the Message. Choose a large size for your embeds by default; Series Engine will automatically adjust the size for different devices with its responsive stylesheet.</li>
		<li><strong>Additional Video URL</strong> - If you would like to use a self-hosted video for the additional video clip, enter the full file path to a video file here. For best results across a wide range of devices, use .mp4 files. If your PHP upload limit is high enough (set by your web host), you may be able to upload and use video clips from WordPress's native media browser. <em>Note: If both an additional video embed code and additional video url are present, the additional video embed code will be displayed instead of the self-hosted clip.</em></li>
		<li><strong>Adjust Permalink</strong> - Adjust the way your title appears in the permalink for this Message. If you change the permalink, the previous permalink will stop working immediately.</li>
		<li><strong>Permalink Comments</strong> - Enable or disable comments on your permalink Message pages. Comments will not appear in other views throughout Series Engine.</li>
	</ul>
	<h4 id="se-scripture">Scripture References</h4>
	<p>Series Engine allows you to attach an unlimited number of scripture references to each Message. If a Message has scripture messsages associated with it, Bible.com links to these references will be visible in the Message's "Details" section in the Series Engine media browser. If a scripture reference is marked as a "focus passage," the reference will also be shown alongside of the Message information in Related Message lists, and the Message will be associated with the chosen Book of the Bible for search in the "Browse Books" search menu.</p>
	<ul>
		<li><strong>Start Verse</strong> - Choose the book of the bible, the chapter, and the starting verse.</li>
		<li><strong>End Verse</strong> - Choose the ending verse. If left the same as the starting verse, your reference will link to just one verse. If different than the starting verse, your reference will link to the chosen passage. Please note that all scripture references must be from the same chapter (it's a limitation of bible.com links!).</li>
		<li><strong>Translation</strong> - Choose from a list of supported Bible translations. Each scripture reference can have a different translation if you wish.</li>
		<li><strong>Focus Passage?</strong> - If a scriptured reference is marked as a "focus passage," the reference will also be shown alongside of the message information in related message lists, and the message will be associated with the chosen book of the bible for search in the "Browse Books" search menu. You can have as many focus passages as you like.</li>
		<li><strong>Editing, Reordering and Deleting References</strong> - Use the sort column to drag-and-drop your scripture references in the desired order. Click on the title of the scripture reference to edit its details. Click the red "Delete" link to permanently remove the scripture reference from the Message.</li>
	</ul>
	<h4>Podcast Settings</h4>
	<ul>
		<li><strong>Audio Length</strong> - The length of the audio message in minutes and seconds. Series Engine will automatically generate this value for you for most MP3s. (ex: 31:22)
		<li><strong>Audio URL</strong> - The URL to the MP3 file for an audio version of your Message. Depending on your WordPress upload limit (currently <strong><?php echo $enmse_filesize; ?></strong>), you may be able to upload the file directly with the WordPress media browser. The same MP3 is used for the Series Engine media browser and any podcasts you create.</li>
		<li><strong>Audio File Size</strong> - The length of the MP3 file (specified above) in bytes.  Series Engine will automatically generate this value for you for most MP3s. You can also find this by right clicking and choosing "Get Info" on a Mac, or choosing "Properties" in Windows.</li>
		<li><strong>Video Length</strong> - The length of the video message in minutes and seconds. (ex: 31:22)</li>
		<li><strong>Video URL</strong> - The URL to the video file you're supplying for any video podcasts. Since these files are far too large to upload with WordPress, you'll need to manually upload the video file into a publicly available location on your web server. You can find information on formatting your video files <a href="http://www.apple.com/itunes/podcasts/specs.html#formattingvideo" target="_blank">on Apple's site</a>.</li>
		<li><strong>Video File Size</strong> - The length of the video file (specified above) in bytes. Series Engine will automatically generate this value for you for most files. You can also find this by right clicking and choosing "Get Info" on a Mac, or choosing "Properties" in Windows.</li>
		<li><strong>Podcast Image</strong> - If you would like a unique image to be displayed with this Message in your podcast feeds (overriding the Series image, if the Message is associated with one), you can provide the image here. Podcast images must be at least 1400x1400 and no greater than 3000x3000.</li>
	</ul>
	
	<h4 id="se-uploadfiles">Attach Link/Download</h4>
	<p>Series Engine allows you to attach an unlimited number of related links or downloads to each of your Messages (ex: links for event registration, study guide downloads, etc). If a Message has links or downloads associated with it, links to these items will be visible in a new box at the top of the Message's "Details" section in the Series Engine media browser.</p>
	<ul>
		<li><strong>Name</strong> - Give your link/download a title. If you're posting a download, its a good idea to include the file type in parenthesis. <em>Ex: Study Guide (PDF)</em></li>
		<li><strong>Link/File URL</strong> - Provide a URL for your link or file download. You can also upload files and insert a link using WordPress's file upload tool (depending on your WordPress upload limit). If you need to link to large downloads like audio or video, you'll need to upload the files elsewhere and manually enter the URL.</li>
		<li><strong>Open File in New Window?</strong> - Choose whether you want the file link to open in the same window, or a new one.</li>
		<li><strong>Featured?</strong> - If you would like a file to be displayed in your Related Messages lists throughout the plugin, you can set it as "Featured." Only one file can be featured per message. Featured files will still be displayed alongside of other Message files in the Message "details" section.</li>
		<li><strong>Editing, Reordering and Deleting Items</strong> - Use the sort column to drag-and-drop your links and downloads in the desired order. Click on the name of the link/download to edit its details. Click the red "Delete" link to permanently remove the link/download from the Message (this will NOT delete the file itself from WordPress or another server).</li>
	</ul>
	<p>When you're finished, click "Save Changes" at the bottom of the page.</p>

	<h3>Tracking Message View Counts</h3>
	<p>If you have provied self-hosted audio and/or video for your Message, Series Engine will track view counts for each type of media. You'll see the current view count alongside of the Message on the admin Messages page. Hover your mouse over the view count number to view a breakdown of views by media type. <em>Please note: alternate video views are not included in the main view count.</em></p>
	<p>If you host your video files with another provider and use embed codes with Series Engine, please visit your video provider's website for stats.</p>
	<p>The stats above also don't include tracking of views from your podcast. If you would like view counts from those sources, considering pairing your Series Engine podcast feeds with a service like Feedburner.</p>

	<h3>Deleting a Message</h3>

	<p>To delete a Message, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php"; ?>">Series Engine > Series Engine</a>. From this list, find the Message you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p><em>Please note: Deleting a Message will not delete the associated Topics or Series, nor will it removed any supporting media you uploaded through WordPress (images, MP3's etc). If you need to remove those files from your WordPress install, you'll need to manually remove them using WordPress's media browser.</em></p>



	<h1 id="se-podcasts">Managing Podcasts</h1>

	<h3>What is a Podcast?</h3>

	<p>Podcasting is a technology that allows your audience to subscribe to a frequently updated list of downloadable messages. The most popular Podcast directory these days is found in Apple's iTunes, but there are several other podcasting services out there as well. Podcasts are usually free and are available in both audio and video formats.</p> 
	<p>Podcasts in iTunes are available on both Macs and PCs, and they can play on almost all of the popular tablet and smartphone platforms. You can learn more about <a href="http://www.apple.com/itunes/how-to/#video-podcasts" target="_blank">iTunes podcasts here</a>.</p>

	<h3>Your Default Podcast</h3>

	<p>Series Engine includes a default audio Podcast feed for you right out of the box. You can access this Podcast feed using this URL:</p>
	<p>http://yourwordpressinstall.com/?feed=seriesengine</p>
	<p>This feed pulls any Message (that has an MP3 specified) from any Series that's associated with your <a href="#se-seriestypes">Primary Series Type</a>. To edit your default podcast, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts"; ?>">Series Engine > Generate Podcasts</a>. Choose the default podcast at the top of the list and edit its options as you see fit.</p>
	<p><em>The default Podcast cannot be deleted.</em></p>

	<h3>Creating a New Podcast</h3>

	<p>Want to move beyond the simple default Podcast that Series Engine provides? No problem! Series Engine allows you to create an unlimited number of podcasts using the Series and Messages you've already created.</p>
	<p>Please note: For a Message to appear in your podcasts, it must have an audio or video file associated with it (under the Message's "Podcast Settings"). You'll also want to provide the corresponding file's length and file size for maximum compatibility.</p>
	<p>To create a new Podcast, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts"; ?>">Series Engine > Generate Podcasts</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to enter the details of your Podcast:</p>
	<ul>
		<li><strong>Type of Podcast</strong> - Specify whether the Podcast is for audio only or video only. </li>
		<li><strong>Title</strong> (required) - The title of your Podcast that people can search for in iTunes.</li>
		<li><strong>Description</strong> (required) - A description of your podcast that will be shown alongside of your Podcast in iTunes.</li>
		<li><strong>Author</strong> (required) - Who should iTunes list as the author of your Podcast? This is typically the name of an individual or organization.</li>
		<li><strong>Author Email</strong> (required) - The email address to list for the Podcast author. (FYI, users rarely ever see this)</li>
		<li><strong>Logo URL</strong> (required) - Provide the URL to (or upload) a graphic to be displayed with your Podcast. Apple requires that every Podcast has a logo that's 1400x1400px square. If you upload an image with WordPress, choose the "Series Engine Podcast Graphic" Size during the upload process to have the image automatically sized for you.</li>
		<li><strong>Link URL</strong> - An optional URL to a page on your site. The podcast will generate a unique URL for every Message as part of its XML. If you supply a link to a page on your site where Series Engine is embedded (ie: http;//yousite.com/messages/), users will be able to view the Message on your site as well (assuming they're seeing your podcast in a place where this link is visible). If left blank, Series Engine will simply generate a dummy URL based off of your homepage.</li>
		<li><strong>Category</strong> (required) - Provide one of the categories specified by <a href="http://www.apple.com/itunes/podcasts/specs.html#categories" target="_blank">Apple's guidelines</a>.</li>
		<li><strong>Subcategory</strong> (required) - Provide one of the subcategories specified by <a href="http://www.apple.com/itunes/podcasts/specs.html#categories" target="_blank">Apple's guidelines</a>.</li>
		<li><strong>How Many Messages?</strong> (required) - How many messages should the Podcast display to your visitors?</li>
		<li><strong>Display Settings</strong> (required) - Specify what Messages you want this Podcast to pull. You can choose to pull in the most recent Messages from a certain Series Type, the most recent Messages from a specific Series, the most recent Messages from a specific Topic or the most recent Messages from a specific Speaker.</li>
		<li><strong>Explicit Content?</strong> - This will mark the podcast as being clean, or containing profanity.</li>
		<li><strong>Redirect This Podcast?</strong> - Do you need to redirect this podcast feed to a new feed (either generated through SE or with another service)? Select a 301 redirect or the iTunes tag and provide the full URL to the new feed in the field below.</li>
		<li><strong>Redirect URL:</strong> - Provide a new URL to your updated podcast feed.</li>
	</ul>
	<p>When you're done, click "Add New Podcast" to add the Podcast to Series Engine. To begin using the Podcast, simply copy the new Podcast Link listed on the main "Generate Podcasts" page. </p>

	<h3>Editing an Existing Podcast</h3>

	<p>To edit an existing Podcast, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts"; ?>">Series Engine > Generate Podcasts</a>. Click on the title of the Podcast that you would like to edit.</p>
	<p>Use the provided form to update the details of your Podcast:</p>
	<ul>
		<li><strong>Type of Podcast</strong> - Specify whether the Podcast is for audio only or video only. </li>
		<li><strong>Title</strong> (required) - The title of your Podcast that people can search for in iTunes.</li>
		<li><strong>Description</strong> (required) - A description of your podcast that will be shown alongside of your Podcast in iTunes.</li>
		<li><strong>Author</strong> (required) - Who should iTunes list as the author of your Podcast? This is typically the name of an individual or organization.</li>
		<li><strong>Author Email</strong> (required) - The email address to list for the Podcast author. (FYI, users rarely ever see this)</li>
		<li><strong>Logo URL</strong> (required) - Provide the URL to (or upload) a graphic to be displayed with your Podcast. Apple requires that every Podcast has a logo that's 1400x1400px square. If you upload an image with WordPress, choose the "Series Engine Podcast Graphic" Size during the upload process to have the image automatically sized for you.</li>
		<li><strong>Link URL</strong> - An optional URL to a page on your site. The podcast will generate a unique URL for every Message as part of its XML. If you supply a link to a page on your site where Series Engine is embedded (ie: http;//yousite.com/messages/), users will be able to view the Message on your site as well (assuming they're seeing your podcast in a place where this link is visible). If left blank, Series Engine will simply generate a dummy URL based off of your homepage.</li>
		<li><strong>Category</strong> (required) - Provide one of the categories specified by <a href="http://www.apple.com/itunes/podcasts/specs.html#categories" target="_blank">Apple's guidelines</a>.</li>
		<li><strong>Subcategory</strong> (required) - Provide one of the subcategories specified by <a href="http://www.apple.com/itunes/podcasts/specs.html#categories" target="_blank">Apple's guidelines</a>.</li>
		<li><strong>How Many Messages?</strong> (required) - How many messages should the Podcast display to your visitors?</li>
		<li><strong>Display Settings </strong>(required) - Specify what Messages you want this Podcast to pull. You can choose to pull in the most recent Messages from a certain Series Type, the most recent Messages from a specific Series, the most recent Messages from a specific Topic or the most recent Messages from a specific Speaker.</li>
		<li><strong>Explicit Content?</strong> - This will mark the podcast as being clean, or containing profanity.</li>
		<li><strong>Redirect This Podcast?</strong> - Do you need to redirect this podcast feed to a new feed (either generated through SE or with another service)? Select a 301 redirect or the iTunes tag and provide the full URL to the new feed in the field below.</li>
		<li><strong>Redirect URL:</strong> - Provide a new URL to your updated podcast feed.</li>
	</ul>
	<p>When you're done, click "Save Changes" at the bottom of the page.</p>

	<h3>Moving Subscribers to a Different Podcast Feed</h3>

	<p>If you need to move your podcast subscribers to a different podcast feed, simply edit the Series Engine podcast and update the redirect options at the bottom of the podcast details. Subscribers will then be gracefully switched to the new podcast feed. No need to ask anyone to jump through hoops to resubscribe.</p>

	<h3>Deleting a Podcast</h3>

	<p>Before you delete your Podcast, you will likely want to remove it from the iTunes Podcast Directory first. You can find <a href="http://support.apple.com/kb/HT1818" target="_blank">instructions for this here</a>.</p>
	<p>To delete a Podcast, navigate to <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_podcasts"; ?>">Series Engine > Generate Podcasts</a>. Find the Podcast you would like to Delete, and select "Delete" on the right side of its row.</p>

	<h3>Monitoring Podcast Subscribers and Other Analytics</h3>

	<p>As you generate your podcasts, you might want to keep track of how many folks have subscribed to your podcast over a period of time. You can do this by combining your Podcast Link with a free service like <a href="http://feedburner.com" target="_blank">Feedburner</a>.</p>
	<p><em>Please note: Series Engine staff does not provide ANY support for Feedburner integration.</em></p>

	<h3>Fixing Podcast Errors</h3>

	<p>At times, you may receive feed validation errors when setting up a particular Podcast with other services. This is almost always due to a typo or improper character in one of your Podcast's options. Use the excellent <a href="http://feedvalidator.org" target="_blank">FeedValidator service</a> to help you troubleshoot any errors.</p>




	<h1 id="se-widgets">Managing Series Engine Widgets</h1>

	<h3>What is a Widget?</h3>

	<p>Widgets are a core component of WordPress that allow you to quickly and easily add small pieces of functionality to any widgetized section of your website. Simply drag and drop the widget where you want it, choose and few quick settings, and you've added a great new feature to your website!</p>
	<p>Series Engine currently includes one widget called "Series Engine - Lists." This widget will allow you to place a list of Series Engine Messages, Series, Topics or Speakers on any widgetized area within your site. You can use as many or as few Series Engine widgets as you like!</p>

	<h3>Customizing the "Series Engine - Lists" Widget</h3>

	<p>To get started, simply navigate to <a href="<?php echo admin_url() . "widgets.php"; ?>">Appearance > Widgets</a>. Find the "Series Engine - Lists" widget in the "Available Widgets" box, and drag an instance of it to any of the widget areas listed on the right side of the page.</p>
	<p>Next, use the provided form to enter the following options:</p>
	<ul>
		<li><strong>Title</strong> - What title do you want displayed alongside of the widget in your sidebar?</li>
		<li><strong>What to Display</strong> - Choose the type of list you want the widget to display.</li>
		<li><strong>From What Series Type?</strong> - Choose the Series Type you want the widget to display items from.</li>
		<li><strong>Show extra details?</strong> - By default, the widget will display only a list of links according to your chosen criteria. If you choose to display extra details, the widget will include several other pieces of information about each item. This feature is great if you're using Series Engine to flesh out a theme, as these items are intentionally easy to style and customize with CSS.</li>
		<li><strong>Link to What URL?</strong> - Choose the URL where the widget will link its items to. You'll want to choose a page/post that has Series Engine installed on it.</li>
		<li><strong>Number of Items to Display</strong> - How many items do you want to display in the list?</li>
	</ul>
	<p>Choose "Save" to finish setting up your widget. You can edit these settings at any time by expanding the widget's details and following the same process.</p>

	<h3>Removing the "Series Engine - Lists" Widget</h3>

	<p>To remove a Series Engine widget from your site, simply drag it out of the chosen widget area, or expand the widget's details and choose "Delete."</p>






	<h1 id="se-users">Managing Series Engine Users</h1>

	<p>The Series Engine menu and all sections are available to any WordPress User with the role of "Editor" or higher. The Series Engine Settings menu is only available to WordPress Users with the role of "Administrator."</p>

	<h1 id="se-updates">Updating the Series Engine Plugin</h1>

	<p>From time to time, we plan to issue updates to the Series Engine plugin that may include bug fixes, performance improvements, and even new features! Have your site administrator keep an eye on <a href="<?php echo admin_url() . "plugins.php"; ?>">WordPress's Plugin Updates</a> page.</p>
	<p>Updates will maintain your changes in <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a>, but will overwrite any changes you have made to the core plugin code and stylesheets. Be sure to back up your changes before updating, and reapply your modifications when the update is complete.


	<h1 id="se-troubleshooting">FAQ/Troubleshooting</h1>

	<h3>Can I move Series Engine content to a new site?</h3>

	<p>Yes! Whether you're changing web hosts or just starting fresh with a new site, it's easy to move your Series Engine content and settings from one site to another.</p>
	<p>Please follow the instructions on <a href="http://seriesengine.com/importexport.php" target="_blank">this support document on our website</a>.</p>

	<h3>Is there a way to bulk upload content into Series Engine?</h3>

	<p>Yes! Even if you're not a previous Series Engine user, it is now possible to bulk upload large message libraries into Series Engine with a single .CSV file. Bulk imports are only recommended for advanced users who are comfortable with data entry and a text editor.</p>
	<p>Please follow the instructions on <a href="http://seriesengine.com/importexport.php#bulk" target="_blank">this support document on our website</a>.</p>

	<h3>Do I have to host my videos somewhere else?</h3>

	<p>Not anymore! Previous versions of the plugin required video content to be hosted with outside sites like Vimeo or YouTube, but Series Engine can now display self-hosted video content in its native video player.</p>
	<p>To set this up, when you're adding or editing a Message, simply supply a Video URL instead of an embed code. The URL should be a direct URL path to the video file itself, and we recommend using the .mp4 format for the best results.</p>
	<p>You'll want to have your web developer figure out the best way to help you upload these video files, as they can be quite large, and most servers/WordPress installs won't allow you to upload the files to the WordPress media browser. Uploading files via FTP is typically the best route.</p>
	
	<h3>Can I use media hosted on a file sharing service?</h3> 

	<p>Probably not. Most file sharing services (Dropbox/One Drive/Google Drive/etc) won't allow you to stream audio or video from their servers.</p>
	<p>We recommending uploading audio or self-hosted video files via FTP or with a file hosting service (like Amazon S3 and others), and then providing Series Engine with the direct URL to the file itself.</p>

	<h3>How do I know if people are watching my Messages?</h3>

	<p>If you have provied self-hosted audio and/or video for your Message, Series Engine will track view counts for each type of media. You'll see the current view count alongside of the Message on the admin Messages page. Hover your mouse over the view count number to view a breakdown of views by media type. <em>Please note: alternate video views are not included in the main view count.</em></p>
	<p>If you host your video files with another provider and use embed codes with Series Engine, please visit your video provider's website for stats.</p>
	<p>The stats above also don't include tracking of views from your podcast. If you would like view counts from those sources, considering pairing your Series Engine podcast feeds with a service like Feedburner.</p>

	<h3>What if I don't use Series?</h3>

	<p>Series Engine was designed with Series in mind, but a recent update (1.8.5) now allows you to display all messages regardless of Series (either for a specific Series Type, or for all Series Types).</p>
	<p>To use Series Engine this way, simply visit <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_embed"; ?>">Series Engine > Get Embed Code</a>, click "Generate Custom Embed" at the top of the page, and select "Display all Messages (regardless of Series)" in the first step. You can then choose whether to filter the messages by a Series Type, or to display messages from all Series Types.</p>
	<p>With this view, the most recent message (according to your settings) will be displayed, along with a list of other messages below it. The "All Messages" view is also available when using any custom embed code; just click/tap "Browse Series" in the Series Explorer dropdown menu and select "View All Messages."</p>
	<p>If you use this view on your site, you can skip adding your Messages to Series entirely, but we still recommend the use of Series to help people navigate your content.</p>

	<h3>Series Engine looks crazy on my site!</h3>

	<p>Three things could be the culprit here. The first one is some overzealous CSS formatting from your chosen Theme. You may need to tinker around in your Theme's stylesheet to make it more friendly to Series Engine and other plugins you may have installed.</p>
	<p>The second issue could be the way your Theme is set up to render the content of Pages/Posts; sometimes a Theme will scrub user-entered content and enter extra HTML tags as it sees fit. As you can imagine, this can wreak havoc on certain plugins, (Series Engine included).</p>
	<p>To fix this, first try wrapping the Series Engine shortcodes in the "raw" tag (something many developers code into their themes):</p>
	<p>Ex: <strong>[raw][seriesengine][/raw]</strong></p>
	<p>If that doesn't appear to fix the issue, you may need to explore disabling the <strong>wpautop()</strong> function on that page or post. The theme developer should be able to help you with that.</p>
	<p>The third issue could be that your Series Engine embed is contained in a narrow column instead of the typical wider page view. To help things look better in this scenario, you may want to adjust Series Engine's responsive style breakpoints (found in <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine > Advanced</a>) to make the more condensed mobile styles appear at a higher pixel width.</p>

	<h3>The Series Engine embed is too wide on my page!</h3>

	<p>Series Engine is fully responsive, and will display according to either the width of its container, or the max-width value found in Settings > Series Engine. If you want it to display in a more narrow column on your full site view, change the max width value there to a smaller number.</p>

	<h3>The Series Engine embed is too big in my column!</h3>

	<p>Out of the box, Series Engine's responsive styles are designed for a full-width page view. If you're using Series Engine inside of a smaller column on a page, you may want to adjust its "condensed view" responsive breakpoint to kick in at a higher width. You can do this in Settings > Series Engine > Advanced.</p>

	<h3>The Series Engine media browser is unresponsive when I click links.</h3>
	
	<p>Series Engine uses the <a href="http://jquery.com" target="_blank">jQuery JavaScript library</a> to provide much of the functionality you see in its media browser. If you're seeing issues like links not loading, message details not expanding, etc, there is likely an issue loading the jQuery library on your page due to a setting in another Theme or Plugin. You may need to ask your web developer for help troubleshooting the JavaScript on your page.</p>
	<p>In cases of extreme incompatibility, you might consider disabling the JavaScript loading of Series Engine content in <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a>.</p>
	<p>If the steps outlined above don't help, it could also be that a security setting on your server (sometimes mod_security) or a security plugin installed on your site is preventing Series Engine from loading its files. You might want to have your web developer help you investigate the culprit in this scenario.</p>

	<h3 id="se-audio-troubleshooting">I can't upload audio within Series Engine</h3>

	<p>First, take a look at WordPress's upload file size limit. This will likely impede your ability to upload an MP3 to use with Series Engine (many MP3's are 30MB or larger). Although Series Engine doesn't provide support for this, you might find <a href="http://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/" target="_blank">this blog post</a> helpful.</p>
	<p>Your Current WordPress Upload Limit: <strong><?php echo $enmse_filesize; ?></strong></p>
	<p>If your MP3 is too large to upload through WordPress, you'll need to upload it to another public location using an FTP client, and then supply Series Engine with the URL to the MP3 file.</p>
	<p><em>Upload limit not the problem? In the WordPress media browser, make sure the file URL to the MP3 is displayed before you click "Insert into Post." Series Engine won't correctly populate the Audio URL field if "None" or "Attachment Post URL" is selected.</em></p>

	<h3>Nothing is showing up on pages with Series Engine embedded</h3>

	<p>Nothing to worry about... You likely don't have any Messages available (with either video, audio or alternate video assigned) within the search criteria you set up with your embed code. When you add Messages to your library that meet the set criteria, they will automatically begin populating your Series Engine page.</p>
	<p>In rare instances some issues can also arise because a Primary Series Type has not been set; simply visit <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a> and ensure that a Primary Series Type has been selected.</p></p>
	<h3>Certain Messages aren't showing up in the Series Engine media browser</h3>

	<p>It's probably because they don't have any media assigned to them. If a Message doesn't have a video file, audio file or alternate video file assigned to it, it won't show up in the Series Engine media browser or related messages lists.</p>
	<p>If that doesn't seem to be the culprit, you'll also want to make sure that all of your Messages have unique titles. Duplicate titles can occationally cause some odd display issues.</p>
	<p>Finally, in rare instances some issues can also arise because a Primary Series Type has not been set; simply visit <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a> and ensure that a Primary Series Type has been selected.</p>

	<h3>Certain Topics/Series/Speakers/Books aren't showing up in the Series Engine media browser</h3>

	<p>It's because they don't have any Messages assigned to them, or the Messages assigned to them don't have any media (see above).</p>
	<p>Additionally, Series will not show up in the Series Explorer if they've been archived. Archived Series will only be displayed in Message Details and in the Series Archives page.</p>
		
	<h3>Speakers aren't showing up for searching, custom embeds, etc!</h3>
	<p>Older versions of the Series Engine plugin handled Speakers in a different fashion than the current release. If you started out with a version less than v1.1, Series Engine will maintain your previously entered Speakers for simple public display, but you will need to re-enter your Speakers with the new system in order to be able to sort by Speaker in media browsers, widgets and podcasts.</p>

	<h3 id="se-mediaelement">Series Engine is Messing Up Time Zones/My Calendar/Time.ly Plugin!</h3>
	<p>Series Engine includes a timezone fix that sets the correct date and time for all podcasts. Unfortunately, it looks like something in the Time.ly plugin conflicts with the Series Engine code, which causes times to be off when you're using both plugins at the same time.</p>
	<p>To fix this issue, visit <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a> and enable "Time.ly Plugin Compatibility." This will tell Series Engine not to reset the timezone, and both plugins should happily run together side-by-side from now on.</p>

	<h3>My Series Engine Podcast is returning a 404 error!</h3>
	<p>You have WordPress to thank for this one!</p>
	<p>Thanks to a random internal WordPress bug, if you don't have a post/page in the system (even if you don't use them with your site) WordPress will oddly cause all RSS feeds on your site to return a 404 error.</p>
	<p>Thankfully, its an easy fix. Just add a post in the system (it doesn't even have to be public anywhere), and the bug should be fixed. You can use <a href="http://feedvalidator.org" target="_blank">feedvalidator.org</a> to confirm that your feeds are working correctly.</p>
	
	<h3>My Series Engine Permalinks aren't working!</h3>
	<p>First, make sure no other post types on your site are trying to use the "messages" slug, which Series Engine uses by default. If so, you can easily edit the Series Engine slug in Settings > Series Engine > Advanced.</p>
	<p>Next, visit Settings > Permalinks and click save a the bottom of the page (even if you didn't change anything). This will make sure WordPress sees the Series Engine slug and sets up permalinks properly.</p>
	<p>Finally, if you upgraded to v2.2+ from a previous version of Series Engine, make sure you run the data cleanup script at the bottom of the Import and Export page. It will create permalinks for all of your existing Messages.</p>


	<h3>My Color and Style Changes in Settings Aren't Taking Effect</h3>
	<p>There's a permissions issue on your server.</p>
	<p>Every time you make a change to the styles in Series Engine's Settings menu, Series Engine overwrites its stylesheet (css/se_styles.css) with a new one. In rare instances, server settings won't allow this.</p>
	<p>Thankfully, it's normally an easy fix. Have your web developer log in to your site's plugins directory with an FTP client, and ensure that the permissions on the "css" folder are 755, and the permissions on se_styles.css in that folder are 644.</p>
	<p>If the steps outlined above don't help, it could also be that a security setting on your server (sometimes mod_security) or a security plugin installed on your site is preventing Series Engine from loading and editing its files. You might want to have your web developer help you investigate the culprit in this scenario.</p>

	<h3>How can I back up my data?</h3>
	<p>There's a lot of valuable content in your Series Engine archives, so it's probably a good idea to back up your data periodically. The easiest way to do this is to visit <a href="<?php echo admin_url() . "admin.php?page=seriesengine_plugin/seriesengine_plugin.php_export"; ?>">Series Engine > Import and Export</a>, and export your content, settings, and styles. It only takes a few seconds, and will give you some peace of mind in case disaster ever strikes.</p>

	<h3>How can I change the plugin's wording/language?</h3>
	<p>As of Version 2.7, Series Engine now officially supports English, Spanish, and German translations, and offers complete control over every front-end label and phrase. To change your language settings, visit <a href="<?php echo admin_url() . "options-general.php?page=enm_seriesengine"; ?>">Settings > Series Engine</a> and select the "Labels and Language" tab at the top of the page.</p>
	<p>If your ministry uses a language that isn't officially supported yet (or you just want to alter some labels as you see fit), this screen gives you complete control over every label and piece of text that your users will see. Modify the labels as you fit, and your changes will be immediately reflected on the site. If you want us to work on an official translation for you, submit a request using the form <a href="http://seriesengine.com/questions.php">at the top of the Questions page at seriesengine.com</a>.</p>
	<p><em>Please note that official translations only effect the front-end Series Engine content (your embedded shortcodes, podcasts, Bible references, widgets, etc). New Bible references will reflect the change, but previous references will not. Language customizations only effect the modern layout released in v2.5.  All admin functions will remain in English.</em></p>

	<h1 id="se-twozero">Housekeeping After Upgrading to Version 2.0-2.7</h1>
	<p>If you're upgrading to v2.0-2.7 from a previous version of Series Engine, there's a little bit of data cleanup you'll want to do for the best results. Thankfully, this will only take you a few clicks.</p>
	<p>Simply visit the "Import and Export" page and follow the directions under "Update Series Engine Data" at the bottom of the page.</p>

	<h1 id="se-otherplugins">Switching to Series Engine from Other Plugins</h1>
	<p>Ready to start using Series Engine, but have a wealth of sermon content tied to another plugin? Series Engine includes a one-click importer that brings all of your content over with none of the stress. Easy imports from <a href="http://seriesengine.com/sermonbrowser.php" target="_blank">Sermon Browser</a> and <a href="http://seriesengine.com/sermonmanager.php" target="_blank">Sermon Manager</a> are currently supported, with import for more plugins coming soon. Visit Series Engine > Import and Export, and scroll to the bottom of the page to get started.</p>


	<h1 id="se-usage">Acceptable Usage</h1>
	<ul class="legal">
		<li>You <strong>MAY</strong> use one licensed copy of the Series Engine an all sites that are directly affiliated with you, or your organization.</li>
		<li>You <strong>MAY NOT</strong> use the same license to install the Series Engine on client sites or sites that you are not directly affiliated with. Every individual/client/organization needs their own license.</li>
	</ul>
	
	<ul class="legal">
		<li>You <strong>MAY</strong> purchase and resell a licensed copy of the Series Engine to a client as part of a web project (ie: offering Series Engine as an installed component of a client's WordPress site). Each project requires its own individual licensed copy of Series Engine.</li>
		<li>You <strong>MAY NOT</strong> resell one or any number of copies of the Series Engine on its own.</li>
	</ul>
	
	<ul class="legal">
		<li>You <strong>MAY</strong> alter the style and adjust the code/functionality of your licensed copy of the Series Engine however you see fit.</li>
		<li>You <strong>MAY NOT</strong> reuse unique components of the Series Engine in any commercial product without prior written consent from Volacious.</li>
	</ul>
	
	<ul class="legal">
		<li>You <strong>MAY</strong> use your licensed copy of the Series Engine to distribute multimedia content to your audience.</li>
		<li>You <strong>MAY NOT</strong> use your licensed copy of the Series Engine for nefarious purposes such as obstructing the privacy of its users.</li>
	</ul>
	
	<ul class="legal">
		<li>You <strong>MAY</strong> remove brand logos from your licensed copy of the Series Engine.</li>
		<li>You <strong>MAY NOT</strong> remove all Series Engine credits or label components of the Series Engine under a different name or copyright.</li>
	</ul>
	<h3>Legal</h3>
	<p>This software is provided by the copyright holder "as is" and any express or implied warranties, including, but not limited to, the implied warranties of merchantability and fitness for a particular purpose are disclaimed. In no event shall the copyright owner be liable for any direct, indirect, incidental, special, exemplary, or consequential damages (including, but not limited to, procurement of substitute goods or services; loss of use, data, or profits; or business interruption) however caused and on any theory of liability, whether in contract, strict liability, or tort (including negligence or otherwise) arising in any way out of the use of this software, even if advised of the possibility of such damage.</p>
	
	</div>
</div>
<?php  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>