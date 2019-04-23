<?php /* ----- Groups Engine - Admin User Guide ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {
		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		$enmge_size = wp_max_upload_size();
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

		$enmge_filesize = ByteSize($enmge_size);
	} else {
		exit("Access Denied");
	}
	
?>
<div class="wrap"> 
    <div id="seriesengine_icon" class="icon32"></div>
    <div></div>
	<h2 class="enmge">Using the Groups Engine Plugin</h2>
	
	<p>&nbsp;</p>
	
	<blockquote>
	<ul>
		<li><a href="#ge-gettingstarted">Getting Started</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-embed">- Embedding Groups Engine into a Page/Post</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-settings">- Changing Groups Engine Settings</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-styles">- Choosing Styles and Colors</a></li>
		<li><a href="#ge-customizing">Customizing Groups Engine Pages</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-simpleembed">- Simple Embed Code</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-advancedembed">- Advanced Embed Code Generator</a></li>
		<li><a href="#ge-managing">Managing Groups Engine Content</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-grouptypes">- Group Types</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-topics">- Topics</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-locations">- Locations</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-groups">- Groups</a></li>
		<li>&nbsp;&nbsp;&nbsp;<a href="#ge-contacts">- Contacts</a></li>
		<li><a href="#ge-reports">Generating Reports</a></li>
		<li><a href="#ge-users">Managing Groups Engine Users</a></li>
		<li><a href="#ge-updates">Updating the Groups Engine Plugin</a></li>
		<li><a href="#ge-troubleshooting">Troubleshooting</a></li>
		<li><a href="#ge-usage">Acceptable Usage and Legal</a></li>
	</ul>
	</blockquote>
	<p>&nbsp;</p>
	<div id="enmge-ge-logo"></div>
	
	<div id="enmge-user-guide">
	<h1 id="ge-gettingstarted">Getting Started</h1>
	
	<p>Congratulations! If you're reading this, you have successfully installed the Groups Engine plugin on your WordPress site. You're only seconds away from creating your first Groups Engine page. Getting started is as easy as 1-2-3:</p>

	<h3 id="ge-embed">1) Embed Groups Engine into a Page/Post</h3>

	<p>Adding Groups Engine to a Page/Post on your site couldn't be easier. Simply edit the Page/Post where you want to include a Groups Engine browser, and place the <strong>[groupsengine]</strong> shortcode on its own line anywhere you like in the Page/Post.</p>
	<p>Save your changes, and you should now see the Groups Engine browser among the other content in your Page/Post.</p>
	<p>Want to customize the content that's displayed? Jump ahead to <a href="#ge-customizing">Customizing Your Groups Engine Pages</a></p>

	<h3 id="ge-settings">2) Change Groups Engine Settings</h3>

	<p>Before you begin using Groups Engine throughout your site, you may want to customize a few of the Groups Engine plugin settings. To do this, simply navigate to <a href="<?php echo admin_url() . "options-general.php?page=enm_groupsengine"; ?>">Settings > Groups Engine</a>.</p>
	<p>From this page, you'll be able to change the default settings of the Groups Engine browser, choose what columns to display in search, customize labels, and more. You'll also want to setup a Google Maps API key and set up the default map view. When you're done, simply choose "Save Changes" at the bottom of the page.</p>
	<p><em>Please note: You can adjust Groups Engine settings at any time, and all changes will be preserved when you update the plugin to the newest version. Uninstalling the plugin will permanently delete any changes that you've made.</em></p>

	<h3 id="ge-styles">3) Choose Styles and Colors for Your Embed</h3>

	<p>Groups Engine was built to fit right into your site; with a few quick tweaks to your style and color settings, you can style Groups Engine to complement just about any theme.</p>
	<p>Navigate to <a href="<?php echo admin_url() . "options-general.php?page=enm_groupsengine"; ?>">Settings > Groups Engine</a>. Near the top of the page, choose the "Styles and Colors" option.</p>
	<p>To adjust the color of various Groups Engine elements, simply click the input field of the item you want to change, and select a new color using the color picker.</p>
	<p>When you've made all of the changes you want, click " Save Changes" at the bottom of the page. Your style changes will now be reflected on all Groups Engine browsers throughout your site.</p>
	
	
	
	<h1 id="ge-customizing">Customizing Your Groups Engine Pages</h1>

	<p>Groups Engine is great for creating a quick group search page on your website, but it can do so much more than that! You can embed Groups Engine an unlimited number of times throughout your site to accomplish a variety of goals.</p>
	<p>Look over the two ways to embed Groups Engine into your Pages/Posts:</p>

	<h3 id="ge-simpleembed">Simple Embed Code</h3>

	<p>Want to get something up and running quickly? Include the simple shortcode on any Page/Post to include a Groups Engine browser featuring all Groups from every Group Type. The simple shortcode displays Groups as a list by default, allows Group search in all categories and lets users contact Group leaders.</p>

	<h3 id="ge-advancedembed">Generating a Custom Embed Code</h3>

	<p>Need to embed a variety of content throughout your site? The Custom Embed Code Generator is where the magic happens!</p>
	<p>For example, a church using Groups Engine on their site might use this tool too:</p>
	<ul>
		<li>Embed a simple list of all Women's Groups into a blog post.</li>
		<li>Embed a map of all offsite Groups that meet at the downtown location.</li>
		<li>Embed a detailed view of a single Men's Group on the Men's section of the site.</li>
		<li>Embed a list of financial study Groups on the Giving page.</li>
		<li>...and much more!</li>
	</ul>
	<p>To get started, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_embed"; ?>">Groups Engine > Get Embed Code</a>. At the top of the page, select "Custom Embed Code." </p>
	<p>Start at the top of the page, and simply select what you want to display from the drop-down menus. Once you've made your selections, click the "Generate Code" button at the bottom of the page to create a custom shortcode that includes your chosen options.</p>
	<p>To use the shortcode, simply copy the text out of the textarea at the bottom of the page and place it on its own line in the editor for any Page/Post. </p>
	<p>Remember, you can create as many custom embeds as you like! Your Groups are no longer confined to a single page of your website.</p>



	<h1 id="ge-managing">Managing Groups Engine Content</h1>

	<h2 id="ge-grouptypes">Managing Groups Types</h2>

	<h3>What is a Groups Type?</h3>

	<p>The "Groups Type" field is an organizational value that will help you control how content is displayed throughout your site. Some users will need to create many, and some users will only need one. You can build your Groups Engine plugin to be as simple or robust as you like!</p>
	<p>How about a quick example based on a church using Groups Engine... </p>
	<p>On their main Small Groups page, the church wants to display all available Small Groups. To accomplish this, they've created the Groups Type "Small Groups" and have assigned a number of Groups to this Groups Type. The custom embed code they placed on their main media page is set to show all Groups from every Group Type.</p>
	<p>Later on, their Women's ministry decides that they want to have a Women's Small Groups page on their section of the website. To accomplish this with Groups Engine, the church simply creates a new Group Type ("Women's Groups") and associates all women's Small Groups with this Group Type as well. The main Small Groups page will continue to display all Groups, but the Women's Ministry page is set up to display only Groups with the "Women's Group" Group Type. </p>

	<h3>Creating a New Group Type</h3>

	<p>To create a new Group Type, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_grouptypes"; ?>">Groups Engine > Edit Group Types</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to give your Group Type a title. When you're done, click "Add New Group Type" to add the Group Type to Groups Engine.</p>

	<h3>Editing an Existing Group Type</h3>

	<p>To edit an existing Group Type, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_grouptypes"; ?>">Groups Engine > Edit Group Types</a>. Click on the title of the Group Type that you would like to edit.</p>
	<p>Use the provided form to edit the title. When you're done, click "Save Changes" at the bottom of the page.</p>

	<h3>Deleting a Group Type</h3>

	<p>To delete a Group Type, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_grouptypes"; ?>">Groups Engine > Edit Group Types</a>. From this list, find the Group Type you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p><em>Please note: Deleting a Group Type will not remove associated Groups, but it will likely interfere with any custom Group Engine embeds that you have previously set up. You may need to generate new embed codes for those pages.</em></p>





	<h2 id="ge-topics">Managing Topics</h2>

	<h3>What is a Topic?</h3>

	<p>A Topic in Groups Engine works similarly to topics/tags/keywords in many other platforms; it gives your users a way to browse your Groups by category, interest, etc. Your Groups may have one Topic, no Topics or many Topics! Use this feature as often or as little as you like.</p>
	<p>Using a church for an example, the staff may want to associate an couples Group with the Topics of "Relationships" and "Marriage."</p>

	<h3>Creating a New Topic</h3>

	<p>You can create a new Topic in two ways: as you're creating/editing a Group, or directly from the admin portal.</p>
	<p>To create a new Topic from the admin portal, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_topics"; ?>">Groups Engine > Edit Topics</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to give your Topic a name and click "Add New Topic" to add the Topic to Groups Engine.</p>
	<p>You can also create a new Topic while you're actively creating/editing a Group. In 'Group Details > Associate with Topics" section of the page, simply enter a title into the input area and click the "Add New Topic" button. </p>

	<h3>Editing an Existing Topic</h3>

	<p>To edit an existing Topic, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_topics"; ?>">Groups Engine > Edit Topics</a>. Click on the title of the Topic that you would like to edit.</p>
	<p>Use the provided form to edit the name, and click "Save Changes" at the bottom of the page.</p>

	<h3>Deleting a Topic</h3>

	<p>To delete a Topic, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_topics"; ?>">Groups Engine > Edit Topics</a>. From this list, find the Topic you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p><em>Please note: Deleting a Topic will not remove associated Groups, but it might interfere with any custom Groups Engine embeds that you have previously set up. You may need to generate new embed codes for those pages.</em></p>




	<h2 id="ge-locations">Managing Locations</h2>
	
	<h3>What is a Location?</h3>
	
	<p>Locations in Groups Engine are the main places where your ministry gathers. Whether you have a building, multiple sites, or campuses, you can use the Locations option to help sort your Groups in a different way. Each Group must be associated with a Location.</p>
	
	<h3>Creating a New Location</h3>
	
	<p>To create a new Location, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_locations"; ?>">Groups Engine > Edit Locations</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to give your Location a name and address, and click "Add New Location" to add the Location to Groups Engine. Please be as specific as possible with the address, as Groups Engine will use it to generate coordinates for maps throughout the Groups Engine browser.</p>
	
	<h3>Editing an Existing Location</h3>
	
	<p>To edit an existing Location, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_locations"; ?>">Groups Engine > Edit Locations</a>. Click on the name of the Location that you would like to edit.</p>
	<p>Use the provided form to edit the name and address, and click "Save Changes" at the bottom of the page. Please be as specific as possible with the address, as Groups Engine will use it to generate coordinates for maps throughout the Groups Engine browser.</p>
	
	<h3>Deleting a Location</h3>
	
	<p>To delete a Location, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_locations"; ?>">Groups Engine > Edit Locations</a>. From this list, find the Location you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p><em>Please note: Deleting a Location will not remove associated Groups, but it might interfere with any custom Groups Engine embeds that you have previously set up. You may need to generate new embed codes for those pages.</em></p>

	



	<h2 id="ge-groups">Managing Groups</h2>

	<h3>What is a Group?</h3>

	<p>Groups are the cornerstone of Groups Engine, and the main attraction for users visiting your Groups Engine pages. Groups can represent a wide range of things such as "Small Groups, Life Groups, Sunday School Classes, Studies," and more.</p>
	<p>Keep in mind that you can change the label for Groups at any time in <a href="<?php echo admin_url() . "options-general.php?page=enm_groupsengine"; ?>">Settings > Groups Engine</a>.</p>

	<h3>Creating a New Group</h3>

	<p>To create a new Group, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php"; ?>">Groups Engine > Groups Engine</a>. At the top of the page, select "Add New" to the right of the page title.</p>
	<p>Use the provided form to input the details of your new Group:</p>

	<h4>General Information</h4>
	<ul>
		<li><strong>Status</strong> - Is your Group open, closed, or full?</li>
		<li><strong>Title</strong> (required) - How do you want to label your Group?</li>
		<li><strong>Description</strong> - An optional description of the Group. This will be displayed in the single Group view in the Groups Engine browser.</li>
		<li><strong>Photo</strong> - Upload an image to be displayed in the single Group view in the Groups Engine browser.</li>
		<li><strong>Age Range</strong> - Set an accurate age range for the group. This will be used in Group search and displayed throughout the Groups Engine browser.</li>
		<li><strong>Leader(s)</strong> (required) - Specify one or several leaders for the Group. If Contacts are enabled in your embed code, leaders will receive email notification when a new Group Contact is received.</li>
		<li><strong>Day of the Week</strong> - Specify when a Group meets and with what frequency.</li>
		<li><strong>Start Time</strong> - When does the Group begin?</li>
		<li><strong>End Time</strong> - When does the Group end?</li>
		<li><strong>Start Date</strong> - When does the Group begin? Groups can be filtered by this value with embed codes and reporting.</li>
		<li><strong>End Date</strong> - When does the Group end? Groups can be filtered by this value with embed codes and reporting. Groups will no longer show up in the Groups Engine browser after the end date has passed.</li>
		<li><strong>Childcare Provided?</strong> - Help people know what to do with their kids.</li>
		<li><strong>Childcare Details</strong> - Provide additional childcare instructions, babysitter fees, etc.</li>
		<li><strong>Privacy</strong> - A quick toggle to hide or show a Group in the Groups Engine browser. Useful when you don't have all of the details available for a Group yet.</li>
	</ul>

	<h4>Group Details</h4>
	<ul>
		<li><strong>Belongs to Location</strong> - Select the Location that the Group is related to, even if it meets offsite.</li>
		<li><strong>Group Type</strong> - A way to categorize your Groups. Select one or many.</li>
		<li><strong>Topic</strong> - Another way to help users navigate your Groups; select as many as you like.</li>
	</ul>

	<h4>Location</h4>
	<ul>
		<li><strong>Location Label</strong> - Enter something descriptive to help people find the Group when they arrive.</li>
		<li><strong>Group Meets At...</strong> - Where does the Group actually meet? Select one of your locations, or select "Offsite" and enter the address. Please be as specific as possible, as this information will be used throughout Groups Engine to plot points on a map.</li>
		<li><strong>Address Fields</strong> - Please be as specific as possible, as this information will be used throughout Groups Engine to plot points on a map. For general approximations, feel free to leave numbers out of street names, or even just enter a City, State/Province, or Postal Code.</li>
		<li><strong>Make Address Public?</strong> - If hidden, the map pin will be displayed accordingly, but the actual address will not be available. Useful for Groups meeting in homes where the leader wants their address to remain private.</li>
		<li><strong>Manually Edit Lat/Long?</strong> - If the map pin generated from your address is wrong, you can manually edit the latitude and longitude values to correctly position your map pins.</li>
	</ul>
	
	<h4>Attach Link/Download</h4>
	<p>Groups Engine allows you to attach an unlimited number of related links or downloads to each of your Groups (ex: links for event registration, study guide downloads, etc). If a Groups has links or downloads associated with it, links to these items will be visible in a new area above the Group map in the single Group view.</p>
	<ul>
		<li><strong>Name</strong> - Give your link/download a title. If you're posting a download, its a good idea to include the file type in parenthesis. <em>Ex: Study Guide (PDF)</em></li>
		<li><strong>Link/File URL</strong> - Provide a URL for your link or file download. You can also upload files and insert a link using WordPress's file upload tool (depending on your WordPress upload limit). If you need to link to large downloads like audio or video, you'll need to upload the files elsewhere and manually enter the URL.</li>
		<li><strong>Editing, Reordering and Deleting Items</strong> - Use the sort column to drag-and-drop your links and downloads in the desired order. Click on the name of the link/download to edit its details. Click the red "Delete" link to permanently remove the link/download from the Message (this will NOT delete the file itself from WordPress or another server).</li>
	</ul>
	
	<p>When you're finished, click "Add New Group" at the bottom of the page.</p>

	<h3>Editing an Existing Group</h3>

	<p>To edit an existing Group, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php"; ?>">Groups Engine > Groups Engine</a>. Find the title of the Group you would like to edit, and click on it to be taken to the edit screen.</p>
	<p>Use the provided form to update the details of your Group:</p>

	<h4>General Information</h4>
	<ul>
		<li><strong>Status</strong> - Is your Group open, closed, or full?</li>
		<li><strong>Title</strong> (required) - How do you want to label your Group?</li>
		<li><strong>Description</strong> - An optional description of the Group. This will be displayed in the single Group view in the Groups Engine browser.</li>
		<li><strong>Photo</strong> - Upload an image to be displayed in the single Group view in the Groups Engine browser.</li>
		<li><strong>Age Range</strong> - Set an accurate age range for the group. This will be used in Group search and displayed throughout the Groups Engine browser.</li>
		<li><strong>Leader(s)</strong> (required) - Specify one or several leaders for the Group. If Contacts are enabled in your embed code, leaders will receive email notification when a new Group Contact is received.</li>
		<li><strong>Day of the Week</strong> - Specify when a Group meets and with what frequency.</li>
		<li><strong>Start Time</strong> - When does the Group begin?</li>
		<li><strong>End Time</strong> - When does the Group end?</li>
		<li><strong>Start Date</strong> - When does the Group begin? Groups can be filtered by this value with embed codes and reporting.</li>
		<li><strong>End Date</strong> - When does the Group end? Groups can be filtered by this value with embed codes and reporting. Groups will no longer show up in the Groups Engine browser after the end date has passed.</li>
		<li><strong>Childcare Provided?</strong> - Help people know what to do with their kids.</li>
		<li><strong>Childcare Details</strong> - Provide additional childcare instructions, babysitter fees, etc.</li>
		<li><strong>Privacy</strong> - A quick toggle to hide or show a Group in the Groups Engine browser. Useful when you don't have all of the details available for a Group yet.</li>
	</ul>

	<h4>Group Details</h4>
	<ul>
		<li><strong>Belongs to Location</strong> - Select the Location that the Group is related to, even if it meets offsite.</li>
		<li><strong>Group Type</strong> - A way to categorize your Groups. Select one or many.</li>
		<li><strong>Topic</strong> - Another way to help users navigate your Groups; select as many as you like.</li>
	</ul>

	<h4>Location</h4>
	<ul>
		<li><strong>Location Label</strong> - Enter something descriptive to help people find the Group when they arrive.</li>
		<li><strong>Group Meets At...</strong> - Where does the Group actually meet? Select one of your locations, or select "Offsite" and enter the address. Please be as specific as possible, as this information will be used throughout Groups Engine to plot points on a map.</li>
		<li><strong>Address Fields</strong> - Please be as specific as possible, as this information will be used throughout Groups Engine to plot points on a map. For general approximations, feel free to leave numbers out of street names, or even just enter a City, State/Province, or Postal Code.</li>
		<li><strong>Make Address Public?</strong> - If hidden, the map pin will be displayed accordingly, but the actual address will not be available. Useful for Groups meeting in homes where the leader wants their address to remain private.</li>
		<li><strong>Manually Edit Lat/Long?</strong> - If the map pin generated from your address is wrong, you can manually edit the latitude and longitude values to correctly position your map pins.</li>
	</ul>
	
	<h4>Attach Link/Download</h4>
	<p>Groups Engine allows you to attach an unlimited number of related links or downloads to each of your Groups (ex: links for event registration, study guide downloads, etc). If a Groups has links or downloads associated with it, links to these items will be visible in a new area above the Group map in the single Group view.</p>
	<ul>
		<li><strong>Name</strong> - Give your link/download a title. If you're posting a download, its a good idea to include the file type in parenthesis. <em>Ex: Study Guide (PDF)</em></li>
		<li><strong>Link/File URL</strong> - Provide a URL for your link or file download. You can also upload files and insert a link using WordPress's file upload tool (depending on your WordPress upload limit). If you need to link to large downloads like audio or video, you'll need to upload the files elsewhere and manually enter the URL.</li>
		<li><strong>Editing, Reordering and Deleting Items</strong> - Use the sort column to drag-and-drop your links and downloads in the desired order. Click on the name of the link/download to edit its details. Click the red "Delete" link to permanently remove the link/download from the Message (this will NOT delete the file itself from WordPress or another server).</li>
	</ul>

	<p>When you're finished, click "Save Changes" at the bottom of the page.</p>

	<h3>Duplicating a Group</h3>
	<p>To save time when entering Groups into the system, you may find it easier to duplicate/edit an existing Group than manually entering similar data into the system.</p>

	<p>To duplicate a Group, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php"; ?>">Groups Engine > Groups Engine</a>. From this list, click on the title of the Group you want to duplicate. From the Edit screen, simply select "Duplicate" at the top of the page. You'll return to the list of all Groups where an identical copy of the Group has been created. Simply click on the duplicated Groups' title to edit as needed.</p>

	<h3>Deleting a Group</h3>

	<p>To delete a Group, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php"; ?>">Groups Engine > Groups Engine</a>. From this list, find the Group you would like to delete, and click the red "Delete" link on the right side of the row. </p>
	<p><em>Please note: Deleting a Group will not delete the associated Topics, Group Types, or Locations, nor will it remove any supporting media you uploaded through WordPress (images, files etc). If you need to remove those files from your WordPress install, you'll need to manually remove them using WordPress's media browser.</em></p>



	<h1 id="ge-contacts">Managing Contacts</h1>

	<h3>What is a Contact?</h3>

	<p>Contacts are the messages received when a user fills out the form to contact a group leader. All Group leaders are notified via email, as are WordPress users who have elected to receive email notifications from that Group Type.</p>

	<h3>Creating a New Contact</h3>

	<p>Most contacts will come from visitors exploring the Groups Engine browser, but you can also manually add a contact into the system by navigating to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts"; ?>">Groups Engine > View Contacts</a> and clicking "Add New" at the top of the page.</p>
	<p>Use the provided form to enter the details of your Contact:</p>
	<ul>
		<li><strong>Name</strong> - The name of the person inquiring about the Group. </li>
		<li><strong>Email</strong> - The email address for the person above.</li>
		<li><strong>Phone</strong> - A phone number for the person above.</li>
		<li><strong>Message</strong> (required) - The message the contact wants to send to the Group leader.</li>
		<li><strong>For Group</strong> - Select a Group Type, and then the Group that you want to associate the Contact with. You can only associate a Contact with one Group.</li>
		<li><strong>Status</strong> - Select how the contact should be handled.</li>
		<li><strong>Note</strong> - Add an additional note to the Contact. Notes can be seen by all admins and Group leaders.</li>
	</ul>
	<p>When you're done, click "Add New Contact" to add the Contact to Groups Engine. The leaders of the specified Group will receive an email notification with all of the Contact details, along with links to quickly update the Contact.</p>

	<h3>Editing an Existing Contact</h3>

	<h4>For WordPress Admins</h4>

	<p>To edit an existing Contact, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts"; ?>">Groups Engine > View Contacts</a>. Click on the name of the Contact you would like to edit.</p>
	<p>Use the provided form to change the status and add a note to a Contact:</p>
	<ul>
		<li><strong>Status</strong> - Does the Contact still need follow up?</li>
		<li><strong>Note</strong> (required) - Add an additional note to the Contact. Notes can be seen by all admins and Group leaders.</li>
	</ul>
	<p>When you're done, click "Save Changes" at the bottom of the page. The Group leaders will be notified by email of your update.</p>

	<h4>For Group Leaders</h4>

	<p>When a new contact is received, all Group leaders for that Group will receive an email notification including all of the Contact details, along with several links they can use to update the Contact.</p>

	<p>One of the most popular features of Groups Engine is the ability for a Group leader to update a contact with just one click (no log in required!). It takes the busy work out of the follow up process, and makes it a lot more likey for a Group leader to keep you in the loop. Group leaders can choose from the following options:</p>

	<ul>
		<li>They're joining our Group!</li>
		<li>I answered their question... No additional followup needed.</li>
		<li>I couldn't answer their question... More followup needed.</li>
		<li>I couldn't get in touch with them.</li>
	</ul>

	<p>Group leaders also have access to a unique link where they can view the full contact history, change the status, and add additional notes of their own.</p>

	<h3>Contact Email Notifications</h3>

	<p>Groups Engine makes it easy to receive an email notification whenever a new Contact is received or updated. To ensure you receive the notifications that are relevant to you, edit your User Profile in WordPress and check the boxes for the Group Types you want to keep up with under the Groups Engine section of the page.</p>

	<h3>Sending a Reminder to the Group Leader</h3>

	<p>If the Group leader hasn't responded to the contact after a few days, you'll probably want to send an email reminder. Simple click the Contact name to edit the contact, and select "Send Reminder" at the top of the page.</p>

	<h3>Deleting a Contact</h3>

	<p>To delete a Contact, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts"; ?>">Groups Engine > View Contacts</a>. Find the Contact you would like to Delete, and select "Delete" on the right side of its row.</p>





	<h1 id="ge-reports">Generating Reports</h1>

	<p>You've entered a lot of information into Groups Engine, so we want to make it easy to access your data in a variety of formats. Our custom reports may quickly become one of your favorite features!</p>

	<p>To generate a new report, navigate to <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_reports"; ?>">Groups Engine > Reports Library</a> and follow the prompts from the dropdown menus throughout the page. When the correct options have been selected, click "Run Report" at the bottom of the page.</p>

	<h3>Types of Reports</h3>

	<p>Groups Engine currently includes three types of reports:</p>

	<ul>
		<li><strong>Group Lists</strong> - Generate a comprehensive list of Groups according to the criteria you specify. This may be useful to have in your visitor center, meeting, etc.</li>
		<li><strong>Recent Contacts</strong> - Generate a list of all Contacts received over a certain length of time. This may be helpful for physically distributing Contact followup sheets, keeping track of assimilation, etc.</li>
		<li><strong>Group Leader Emails</strong> - Generate a quick list of all Group leaders according to the criteria you specify. Leaders will be grouped by their email address and will not be duplicated. Useful for email blasts.</li>
	</ul>	

	<h3>Report Formats</h3>

	<p>Groups Engine can generate the reports above in two formats:</p>

	<ul>
		<li><strong>Browser</strong> - Results will be displayed in the browser for quick access to the information and quick printing (if needed).</li>
		<li><strong>Save as CSV</strong> - Results will be saved as a .CSV file that can be customized and edited as a spreadsheet in apps like Excel, Numbers, Google Docs, etc.</li>
	</ul>





	<h1 id="ge-users">Managing Groups Engine Users</h1>

	<p>The Groups Engine menu and most sections are available to any WordPress User with the role of "Contributor" or higher. The Groups Engine Settings menu is only available to WordPress Users with the role of "Administrator."</p>

	<h1 id="ge-updates">Updating the Groups Engine Plugin</h1>

	<p>From time to time, we plan to issue updates to the Groups Engine plugin that may include bug fixes, performance improvements, and even new features! Updates are made available via the WordPress Plugins page.</p>
	<p>Updates will maintain your changes in <a href="<?php echo admin_url() . "options-general.php?page=enm_groupsengine"; ?>">Settings > Groups Engine</a>, but will overwrite any changes you have made to the core plugin code and stylesheets. Be sure to back up your changes before updating, and reapply your modifications when the update is complete.</p>



	<h1 id="ge-troubleshooting">Troubleshooting</h1>

	<h3>The Groups Engine browser looks crazy on my site!</h3>

	<p>Two things could be the culprit here. The first one is some overzealous CSS formatting from your chosen Theme. You may need to tinker around in your Theme's stylesheet to make it more friendly to Groups Engine and other plugins you may have installed.</p>
	<p>The second issue could be the way your Theme is set up to render the content of Pages/Posts; sometimes a Theme will scrub user-entered content and enter extra HTML tags as it sees fit. As you can imagine, this can wreak havoc on certain plugins, (Groups Engine included).</p>
	<p>To remedy this, we recommend that your web developer disable wpautop/texturize on the relevant pages. There are several free plugins to accomplish this in the WordPress Plugin Directory.</p>


	<h3>The Groups Engine browser is unresponsive when I click links.</h3>
	
	<p>Groups Engine uses the <a href="http://jquery.com" target="_blank">jQuery JavaScript library</a> to provide much of the functionality you see in its browser. If you're seeing issues like links not loading, search not working, etc, there is likely an issue loading the jQuery library on your page due to a setting in another Theme or Plugin. You may need to ask your web developer for help troubleshooting the JavaScript on your page.</p>
	<p>In cases of extreme incompatibility, you might consider disabling the AJAX loading of Groups Engine content in <a href="<?php echo admin_url() . "options-general.php?page=enm_groupsengine"; ?>">Settings > Groups Engine</a>.</p>

	<h3>Certain Groups aren't showing up in the Groups Engine browser</h3>

	<p>It's probably because it's before its specified start date or after its end date. It could also be because the Group doesn't meet the criteria for your chosen embed code. You may need to change those settings with the Custom Embed Code Generator found at <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_embed"; ?>">Groups Engine > Get Embed Code</a>.</p>

	<h3>Certain Group Types/Locations/Topics aren't showing up in the Groups Engine browser</h3>

	<p>It's because they don't have any Groups associated with them, or at least any that match the criteria set up for your embed code.</p>

	<h3 id="ge-google">I'm Having Trouble with Maps in Groups Engine (or the rest of the site)</h3>
	<p>Groups Engine uses the Google Maps JavaScript API to display maps throughout the plugin. If these aren't being displayed, or you're seeing errors with other maps loading on your page outside of the Groups Engine browser, it could be that you have conflicting code installed. Have your web developer look at the JavaScript console in your browser for troubleshooting diagnostics.</p>

	<p><em>Note: It's also in your best interest to sign up for a Google Maps API key (and it may actually be required depending on your server). You'll find the link and the place to enter it in <a href="<?php echo admin_url() . "options-general.php?page=enm_groupsengine"; ?>">Settings > Groups Engine</a>.</em></p>

	<h3 id="ge-server">I'm Unable to Save Address Information with Groups Engine</h3>

	<p>Groups Engine uses the Google Maps Geocoding API to look up latitude and longitude information for your Groups and Locations. If you frequently see errors when you're updating a Group or Location related to the location itself, your hosting server has probably reached its API limit for address lookups.</p>
	<p>Thankfully, there's a fix for this that just involves generating an API key with Geocoding enabled for your install of Groups Engine. Simply visit <a href="https://developers.google.com/maps/documentation/geocoding/start#get-a-key" target="_blank">https://console.developers.google.com</a> and create or choose to edit your existing API key. Then...</p>
	<ol style="padding: 0 0 0 30px">
		<li>Under "APIs," look at the ENABLED APIs section for your API key and make sure the Geocoding API is ON.</li>
		<li>If you don't see the Geocoding API in the ENABLED APIs list, click that option in the ADDITIONAL APIs list below, and click ENABLE on the next screen.</li>
		<li>Visit <a href="<?php echo admin_url() . "options-general.php?page=enm_groupsengine"; ?>">Settings > Groups Engine</a> and paste the key under "Google Geocoding API Key."</li>
	</ol>
	<p>Your location information should begin saving correctly <strong>within 24 hours</strong> of making these changes.</p>
	<p><em>Note: It's fine to use the same key for "Google Maps API Key" and "Google Geocoding API Key" in the Groups Engine settings panel.</em></p>

	<h1 id="ge-usage">Acceptable Usage</h1>
	<ul class="legal">
		<li>You <strong>MAY</strong> use one licensed copy of the Groups Engine an all sites that are directly affiliated with you, or your organization.</li>
		<li>You <strong>MAY NOT</strong> use the same license to install the Groups Engine on client sites or sites that you are not directly affiliated with. Every individual/client/organization needs their own license.</li>
	</ul>
	
	<ul class="legal">
		<li>You <strong>MAY</strong> purchase and resell a licensed copy of the Groups Engine to a client as part of a web project (ie: offering Groups Engine as an installed component of a client's WordPress site). Each project requires its own individual licensed copy of Groups Engine.</li>
		<li>You <strong>MAY NOT</strong> resell one or any number of copies of the Groups Engine on its own.</li>
	</ul>
	
	<ul class="legal">
		<li>You <strong>MAY</strong> alter the style and adjust the code/functionality of your licensed copy of the Groups Engine however you see fit.</li>
		<li>You <strong>MAY NOT</strong> reuse unique components of the Groups Engine in any commercial product without prior written consent from Volacious.</li>
	</ul>
	
	<ul class="legal">
		<li>You <strong>MAY</strong> use your licensed copy of the Groups Engine to distribute multimedia content to your audience.</li>
		<li>You <strong>MAY NOT</strong> use your licensed copy of the Groups Engine for nefarious purposes such as obstructing the privacy of its users.</li>
	</ul>
	
	<ul class="legal">
		<li>You <strong>MAY</strong> remove brand logos from your licensed copy of the Groups Engine.</li>
		<li>You <strong>MAY NOT</strong> remove all Groups Engine credits or label components of the Groups Engine under a different name or copyright.</li>
	</ul>
	<h3>Legal</h3>
	<p>This software is provided by the copyright holder "as is" and any express or implied warranties, including, but not limited to, the implied warranties of merchantability and fitness for a particular purpose are disclaimed. In no event shall the copyright owner be liable for any direct, indirect, incidental, special, exemplary, or consequential damages (including, but not limited to, procurement of substitute goods or services; loss of use, data, or profits; or business interruption) however caused and on any theory of liability, whether in contract, strict liability, or tort (including negligence or otherwise) arising in any way out of the use of this software, even if advised of the possibility of such damage.</p>
	
	</div>
</div>
<?php  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>