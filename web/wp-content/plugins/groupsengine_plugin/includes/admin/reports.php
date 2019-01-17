<?php /* Groups Engine - Printable Reports */
global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
if ( current_user_can( 'edit_posts' ) ) {
	global $wpdb;

	$enmge_options = get_option( 'enm_groupsengine_options' ); 
	$enmge_grouptitle = $enmge_options['grouptitle'];
	$enmge_groupptitle = $enmge_options['groupptitle']; 
	$enmge_grouptypetitle = $enmge_options['grouptypetitle'];
	$enmge_grouptypeptitle = $enmge_options['grouptypeptitle'];
	$enmge_locationtitle = $enmge_options['locationtitle'];
	$enmge_locationptitle = $enmge_options['locationptitle'];
	$enmge_topictitle = $enmge_options['topictitle'];
	$enmge_topicptitle = $enmge_options['topicptitle'];

	// Get All Group Types
	$enmge_preparredgtsql = "SELECT group_type_id, group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_title ASC"; 
	$enmge_gts = $wpdb->get_results( $enmge_preparredgtsql );

	// Get All Topics
	$enmge_preparredtsql = "SELECT topic_id, topic_name FROM " . $wpdb->prefix . "ge_topics" . " ORDER BY topic_name ASC"; 
	$enmge_ts = $wpdb->get_results( $enmge_preparredtsql );

	// Get All Locations
	$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " ORDER BY location_id DESC"; 	
	$enmge_locations = $wpdb->get_results( $enmge_lpreparredsql );
 ?>
<div class="wrap"> 
	<link rel='stylesheet' href='<?php echo plugins_url() .'/groupsengine_plugin/css/jqueryui.css'; ?>' type='text/css' media='all' />
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/datepicker.js'; ?>" ></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#enmge_contactrange").datepicker({ dateFormat: 'yy-mm-dd' });
			jQuery("#enmge_sd").datepicker({ dateFormat: 'yy-mm-dd' });
			jQuery("#enmge_ed").datepicker({ dateFormat: 'yy-mm-dd' });
			jQuery("#enmge_leadersd").datepicker({ dateFormat: 'yy-mm-dd' });
			jQuery("#enmge_leadered").datepicker({ dateFormat: 'yy-mm-dd' });
			jQuery('#enmge_reportselect').change(function() {
				var findvalue = jQuery(this).val();
				var exportval = jQuery("#enmge_exportformat").val();
				if ( findvalue == "groups" ) {
					if (exportval == "browser") {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/groups.php?xxge=' . base64_encode(ABSPATH); ?>");
					} else {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/groupscsv.php?xxge=' . base64_encode(ABSPATH); ?>");
					};
				} else if( findvalue == "leaders" ) {
					if (exportval == "browser") {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/leaders.php?xxge=' . base64_encode(ABSPATH); ?>");
					} else {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/leaderscsv.php?xxge=' . base64_encode(ABSPATH); ?>");
					};
				} else {
					if (exportval == "browser") {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/contacts.php?xxge=' . base64_encode(ABSPATH); ?>");
					} else {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/contactscsv.php?xxge=' . base64_encode(ABSPATH); ?>");
					};	
				};
				if ( findvalue != "empty" && exportval != "empty" ) {
					if (findvalue == "groups") {
						jQuery("#groupoptions").show();
						jQuery("#submitarea").show();
						jQuery("#instructions").show();
						jQuery("#leaderoptions").hide();
						jQuery("#contactoptions").hide();
					} else if (findvalue == "leaders") {
						jQuery("#leaderoptions").show();
						jQuery("#submitarea").show();
						jQuery("#instructions").show();
						jQuery("#contactoptions").hide();
						jQuery("#groupoptions").hide();
					} else {
						jQuery("#contactoptions").show();
						jQuery("#submitarea").show();
						jQuery("#instructions").show();
						jQuery("#leaderoptions").hide();
						jQuery("#groupoptions").hide();
					};
				} else {
					jQuery("#contactoptions").hide();
					jQuery("#submitarea").hide();
					jQuery("#instructions").hide();
					jQuery("#leaderoptions").hide();
					jQuery("#groupoptions").hide();
				};
			});
			jQuery('#enmge_exportformat').change(function() {
				var findvalue = jQuery("#enmge_reportselect").val();
				var exportval = jQuery(this).val();
				if ( findvalue == "groups" ) {
					if (exportval == "browser") {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/groups.php?xxge=' . base64_encode(ABSPATH); ?>");
					} else {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/groupscsv.php?xxge=' . base64_encode(ABSPATH); ?>");
					};
				} else if( findvalue == "leaders" ) {
					if (exportval == "browser") {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/leaders.php?xxge=' . base64_encode(ABSPATH); ?>");
					} else {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/leaderscsv.php?xxge=' . base64_encode(ABSPATH); ?>");
					};
				} else {
					if (exportval == "browser") {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/contacts.php?xxge=' . base64_encode(ABSPATH); ?>");
					} else {
						jQuery('#reportform').attr("action","<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/contactscsv.php?xxge=' . base64_encode(ABSPATH); ?>");
					};	
				};
				if ( findvalue != "empty" && exportval != "empty" ) {
					if (findvalue == "groups") {
						jQuery("#groupoptions").show();
						jQuery("#submitarea").show();
						jQuery("#instructions").show();
						jQuery("#leaderoptions").hide();
						jQuery("#contactoptions").hide();
					} else if (findvalue == "leaders") {
						jQuery("#leaderoptions").show();
						jQuery("#submitarea").show();
						jQuery("#instructions").show();
						jQuery("#contactoptions").hide();
						jQuery("#groupoptions").hide();
					} else {
						jQuery("#contactoptions").show();
						jQuery("#submitarea").show();
						jQuery("#instructions").show();
						jQuery("#leaderoptions").hide();
						jQuery("#groupoptions").hide();
					};
				} else {
					jQuery("#contactoptions").hide();
					jQuery("#submitarea").hide();
					jQuery("#instructions").hide();
					jQuery("#leaderoptions").hide();
					jQuery("#groupoptions").hide();
				};
			});
			jQuery('#enmge_meeting').change(function() {
				var findvalue = jQuery(this).val();
				if ( findvalue == 2 ) {
					jQuery("#startingrow").show();
					jQuery("#endingrow").show();
				} else {
					jQuery("#startingrow").hide();
					jQuery("#endingrow").hide();
					jQuery("#enmge_sd").val('');
					jQuery("#enmge_ed").val('');
				};
			});
			jQuery('#enmge_leadermeeting').change(function() {
				var findvalue = jQuery(this).val();
				if ( findvalue == 2 ) {
					jQuery("#leaderstartingrow").show();
					jQuery("#leaderendingrow").show();
				} else {
					jQuery("#leaderstartingrow").hide();
					jQuery("#leaderendingrow").hide();
					jQuery("#enmge_leadersd").val('');
					jQuery("#enmge_leadered").val('');
				};
			});
		});
	</script>
	<h2 class="enmge" style="padding-bottom: 5px">Generate and Print Reports</h2>
	<p>Groups Engine can generate a wide variety of reports that you can view immediately or save as a .CSV (for use as a spreadsheet or in other applications). Get started by choosing an option below. Learn more in the <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#ge-reports"; ?>">User Guide</a>.</p>
	
	<form action="<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/reports/groups.php'; ?>" method="post" id="reportform" target="_blank">
	<h2><strong>Step 1:</strong> Choose What to Display...</h2>
	<table class="form-table">
			<tr valign="top">
				<th scope="row">Type of Report:</th>
				<td><select id="enmge_reportselect" name="enmge_reportselect" tabindex="1">
					<option value="empty">-- Choose an option --</option>
					<option value="groups"><?php echo stripslashes($enmge_grouptitle); ?> List</option>
					<option value="contacts">Recent Contacts</option>
					<option value="leaders"><?php echo stripslashes($enmge_grouptitle); ?> Leader Emails</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Export Format:</th>
				<td><select id="enmge_exportformat" name="enmge_exportformat" tabindex="2">
					<option value="empty">-- Choose an option --</option>
					<option value="browser">Browser</option>
					<option value="csv">Save as CSV (Excel/Numbers/Spreadsheet)</option>
					</select>
				</td>
			</tr>
	</table>
	<h2 id="instructions" style="display: none;"><strong>Step 2:</strong> Choose Your Options...</h2>
	<table class="form-table" id="leaderoptions" style="display: none">
			<tr valign="top">
				<th scope="row"><?php echo stripslashes($enmge_grouptypetitle); ?>:</th>
				<td><select id="enmge_leadergrouptype" name="enmge_leadergrouptype" tabindex="3">
					<option value="0">- Any -</option>
					<?php foreach ($enmge_gts as $gt) {  ?>
					<option value="<?php echo $gt->group_type_id; ?>"><?php echo stripslashes($gt->group_type_title); ?></option>
					<?php } ?>
					</select></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo stripslashes($enmge_topictitle); ?>:</th>
				<td><select id="enmge_leadertopic" name="enmge_leadertopic" tabindex="4">
					<option value="0">- Any -</option>
					<?php foreach ($enmge_ts as $t) {  ?>
					<option value="<?php echo $t->topic_id; ?>"><?php echo stripslashes($t->topic_name); ?></option>
					<?php } ?>
					</select></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo stripslashes($enmge_locationtitle); ?>:</th>
				<td><select id="enmge_leaderlocation" name="enmge_leaderlocation" tabindex="5">
					<option value="0">- Any -</option>
					<?php foreach ($enmge_locations as $l) {  ?>
					<option value="<?php echo $l->location_id; ?>"><?php echo stripslashes($l->location_name); ?></option>
					<?php } ?>
					</select></td>
			</tr>
			<tr valign="top">
				<th scope="row">Day:</th>
				<td><select id="enmge_leaderday" name="enmge_leaderday" tabindex="6">
					<option value="0">- Any -</option>
					<option value="1">Sunday</option>
					<option value="2">Monday</option>
					<option value="3">Tuesday</option>
					<option value="4">Wednesday</option>
					<option value="5">Thursday</option>
					<option value="6">Friday</option>
					<option value="7">Saturday</option>
					</select></td>
			</tr>
			<tr valign="top">
				<th scope="row">Time:</th>
				<td><select id="enmge_leaderst" name="enmge_leaderst" tabindex="7">
					<option value="24">- Any -</option>
					<option value="00">12:00am</option>
					<option value="01">1:00am</option>
					<option value="02">2:00am</option>
					<option value="03">3:00am</option>
					<option value="04">4:00am</option>
					<option value="05">5:00am</option>
					<option value="06">6:00am</option>
					<option value="07">7:00am</option>
					<option value="08">8:00am</option>
					<option value="09">9:00am</option>
					<option value="10">10:00am</option>
					<option value="11">11:00am</option>
					<option value="12">12:00pm</option>
					<option value="13">1:00pm</option>
					<option value="14">2:00pm</option>
					<option value="15">3:00pm</option>
					<option value="16">4:00pm</option>
					<option value="17">5:00pm</option>
					<option value="18">6:00pm</option>
					<option value="19">7:00pm</option>
					<option value="20">8:00pm</option>
					<option value="21">9:00pm</option>
					<option value="22">10:00pm</option>
					<option value="23">11:00pm</option>
				</select> - 
				<select id="enmge_leaderet" name="enmge_leaderet" tabindex="8">
					<option value="24">- Any -</option>
					<option value="00">12:00am</option>
					<option value="01">1:00am</option>
					<option value="02">2:00am</option>
					<option value="03">3:00am</option>
					<option value="04">4:00am</option>
					<option value="05">5:00am</option>
					<option value="06">6:00am</option>
					<option value="07">7:00am</option>
					<option value="08">8:00am</option>
					<option value="09">9:00am</option>
					<option value="10">10:00am</option>
					<option value="11">11:00am</option>
					<option value="12">12:00pm</option>
					<option value="13">1:00pm</option>
					<option value="14">2:00pm</option>
					<option value="15">3:00pm</option>
					<option value="16">4:00pm</option>
					<option value="17">5:00pm</option>
					<option value="18">6:00pm</option>
					<option value="19">7:00pm</option>
					<option value="20">8:00pm</option>
					<option value="21">9:00pm</option>
					<option value="22">10:00pm</option>
					<option value="23">11:00pm</option>
				</select></td>
			</tr>
			<tr valign="top">
				<th scope="row">Age Range:</th>
				<td><select name="enmge_leadersa" id="enmge_leadersa" tabindex="9">
					<option value="101"1>- Any -</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
					<option value="32">32</option>
					<option value="33">33</option>
					<option value="34">34</option>
					<option value="35">35</option>
					<option value="36">36</option>
					<option value="37">37</option>
					<option value="38">38</option>
					<option value="39">39</option>
					<option value="40">40</option>
					<option value="41">41</option>
					<option value="42">42</option>
					<option value="43">43</option>
					<option value="44">44</option>
					<option value="45">45</option>
					<option value="46">46</option>
					<option value="47">47</option>
					<option value="48">48</option>
					<option value="49">49</option>
					<option value="50">50</option>
					<option value="51">51</option>
					<option value="52">52</option>
					<option value="53">53</option>
					<option value="54">54</option>
					<option value="55">55</option>
					<option value="56">56</option>
					<option value="57">57</option>
					<option value="58">58</option>
					<option value="59">59</option>
					<option value="60">60</option>
					<option value="61">61</option>
					<option value="62">62</option>
					<option value="63">63</option>
					<option value="64">64</option>
					<option value="65">65</option>
					<option value="66">66</option>
					<option value="67">67</option>
					<option value="68">68</option>
					<option value="69">69</option>
					<option value="70">70</option>
					<option value="71">71</option>
					<option value="72">72</option>
					<option value="73">73</option>
					<option value="74">74</option>
					<option value="75">75</option>
					<option value="76">76</option>
					<option value="77">77</option>
					<option value="78">78</option>
					<option value="79">79</option>
					<option value="80">80</option>
					<option value="81">81</option>
					<option value="82">82</option>
					<option value="83">83</option>
					<option value="84">84</option>
					<option value="85">85</option>
					<option value="86">86</option>
					<option value="87">87</option>
					<option value="88">88</option>
					<option value="89">89</option>
					<option value="90">90</option>
					<option value="91">91</option>
					<option value="92">92</option>
					<option value="93">93</option>
					<option value="94">94</option>
					<option value="95">95</option>
					<option value="96">96</option>
					<option value="97">97</option>
					<option value="98">98</option>
					<option value="99">99</option>
					<option value="100">100</option>
				</select> - 
				<select name="enmge_leaderea" id="enmge_leaderea" tabindex="10">
					<option value="101"1>- Any -</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
					<option value="32">32</option>
					<option value="33">33</option>
					<option value="34">34</option>
					<option value="35">35</option>
					<option value="36">36</option>
					<option value="37">37</option>
					<option value="38">38</option>
					<option value="39">39</option>
					<option value="40">40</option>
					<option value="41">41</option>
					<option value="42">42</option>
					<option value="43">43</option>
					<option value="44">44</option>
					<option value="45">45</option>
					<option value="46">46</option>
					<option value="47">47</option>
					<option value="48">48</option>
					<option value="49">49</option>
					<option value="50">50</option>
					<option value="51">51</option>
					<option value="52">52</option>
					<option value="53">53</option>
					<option value="54">54</option>
					<option value="55">55</option>
					<option value="56">56</option>
					<option value="57">57</option>
					<option value="58">58</option>
					<option value="59">59</option>
					<option value="60">60</option>
					<option value="61">61</option>
					<option value="62">62</option>
					<option value="63">63</option>
					<option value="64">64</option>
					<option value="65">65</option>
					<option value="66">66</option>
					<option value="67">67</option>
					<option value="68">68</option>
					<option value="69">69</option>
					<option value="70">70</option>
					<option value="71">71</option>
					<option value="72">72</option>
					<option value="73">73</option>
					<option value="74">74</option>
					<option value="75">75</option>
					<option value="76">76</option>
					<option value="77">77</option>
					<option value="78">78</option>
					<option value="79">79</option>
					<option value="80">80</option>
					<option value="81">81</option>
					<option value="82">82</option>
					<option value="83">83</option>
					<option value="84">84</option>
					<option value="85">85</option>
					<option value="86">86</option>
					<option value="87">87</option>
					<option value="88">88</option>
					<option value="89">89</option>
					<option value="90">90</option>
					<option value="91">91</option>
					<option value="92">92</option>
					<option value="93">93</option>
					<option value="94">94</option>
					<option value="95">95</option>
					<option value="96">96</option>
					<option value="97">97</option>
					<option value="98">98</option>
					<option value="99">99</option>
					<option value="100">100</option>
				</select></td>
			</tr>
			<tr valign="top">
				<th scope="row">Postal Code:</th>
				<td><input type="text" id="enmge_leaderzip" name="enmge_leaderzip" value="" tabindex="11" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Status:</th>
				<td><select id="enmge_leaderstatus" name="enmge_leaderstatus" tabindex="12">
					<option value="n">- All -</option>
					<option value="1">Open</option>
					<option value="0">Closed</option>
					<option value="2">Full</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Include Leaders of Private <?php echo stripslashes($enmge_groupptitle); ?>?:</th>
				<td><select id="enmge_leaderprivate" name="enmge_leaderprivate" tabindex="13">
					<option value="0">No</option>
					<option value="1">Yes</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Meeting Status:</th>
				<td><select id="enmge_leadermeeting" name="enmge_leadermeeting" tabindex="14">
					<option value="0">Only <?php echo stripslashes($enmge_groupptitle); ?> Currently Meeting</option>
					<option value="1">Include <?php echo stripslashes($enmge_groupptitle); ?> Who Aren't Meeting</option>
					<option value="2">Specify Custom Range</option>
					</select>
				</td>
			</tr>
			<tr valign="top" id="leaderstartingrow" style="display: none">
				<th scope="row">Starting On/After:</th>
				<td><input type="text" id="enmge_leadersd" name="enmge_leadersd" value="" tabindex="15" /></td>
			</tr>
			<tr valign="top" id="leaderendingrow" style="display: none">
				<th scope="row">Ending On/Before:</th>
				<td><input type="text" id="enmge_leadered" name="enmge_leadered" value="" tabindex="16" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Meeting Location:</th>
				<td><select id="enmge_leaderonsite" name="enmge_leaderonsite" tabindex="17">
					<option value="0">Onsite and Offsite</option>
					<option value="1">Onsite Only</option>
					<option value="2">Offsite Only</option>
					</select>
				</td>
			</tr>
	</table>
	<table class="form-table" id="contactoptions" style="display: none">
			<tr valign="top">
				<th scope="row">Which Contacts?:</th>
				<td><select id="enmge_contactoptions" name="enmge_contactoptions" tabindex="18">
					<option value="0">All</option>
					<option value="Initial Followup Needed">Initial Followup Needed</option>
					<option value="Additional Followup Needed">Additional Followup Needed</option>
					<option value="Closed">Closed</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					Contact Range:
					<p class="ge-form-instructions">Display contacts received or updated since this date.</p>
				</th>
				<td valign="top"><input type="text" id="enmge_contactrange" name="enmge_contactrange" value="<?php $past_stamp = time() - 7*24*60*60; echo date('Y-m-d', $past_stamp); ?>" tabindex="19" /></td>
			</tr>
	</table>
	<table class="form-table" id="groupoptions" style="display: none">
			<tr valign="top">
				<th scope="row"><?php echo stripslashes($enmge_grouptypetitle); ?>:</th>
				<td><select id="enmge_grouptype" name="enmge_grouptype" tabindex="20">
					<option value="0">- Any -</option>
					<?php foreach ($enmge_gts as $gt) {  ?>
					<option value="<?php echo $gt->group_type_id; ?>"><?php echo stripslashes($gt->group_type_title); ?></option>
					<?php } ?>
					</select></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo stripslashes($enmge_topictitle); ?>:</th>
				<td><select id="enmge_topic" name="enmge_topic" tabindex="21">
					<option value="0">- Any -</option>
					<?php foreach ($enmge_ts as $t) {  ?>
					<option value="<?php echo $t->topic_id; ?>"><?php echo stripslashes($t->topic_name); ?></option>
					<?php } ?>
					</select></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo stripslashes($enmge_locationtitle); ?>:</th>
				<td><select id="enmge_location" name="enmge_location" tabindex="22">
					<option value="0">- Any -</option>
					<?php foreach ($enmge_locations as $l) {  ?>
					<option value="<?php echo $l->location_id; ?>"><?php echo stripslashes($l->location_name); ?></option>
					<?php } ?>
					</select></td>
			</tr>
			<tr valign="top">
				<th scope="row">Day:</th>
				<td><select id="enmge_day" name="enmge_day" tabindex="23">
					<option value="0">- Any -</option>
					<option value="1">Sunday</option>
					<option value="2">Monday</option>
					<option value="3">Tuesday</option>
					<option value="4">Wednesday</option>
					<option value="5">Thursday</option>
					<option value="6">Friday</option>
					<option value="7">Saturday</option>
					<option value="8">Various</option>
					</select></td>
			</tr>
			<tr valign="top">
				<th scope="row">Time:</th>
				<td><select id="enmge_st" name="enmge_st" tabindex="24">
					<option value="24">- Any -</option>
					<option value="00">12:00am</option>
					<option value="01">1:00am</option>
					<option value="02">2:00am</option>
					<option value="03">3:00am</option>
					<option value="04">4:00am</option>
					<option value="05">5:00am</option>
					<option value="06">6:00am</option>
					<option value="07">7:00am</option>
					<option value="08">8:00am</option>
					<option value="09">9:00am</option>
					<option value="10">10:00am</option>
					<option value="11">11:00am</option>
					<option value="12">12:00pm</option>
					<option value="13">1:00pm</option>
					<option value="14">2:00pm</option>
					<option value="15">3:00pm</option>
					<option value="16">4:00pm</option>
					<option value="17">5:00pm</option>
					<option value="18">6:00pm</option>
					<option value="19">7:00pm</option>
					<option value="20">8:00pm</option>
					<option value="21">9:00pm</option>
					<option value="22">10:00pm</option>
					<option value="23">11:00pm</option>
				</select> - 
				<select id="enmge_et" name="enmge_et" tabindex="25">
					<option value="24">- Any -</option>
					<option value="00">12:00am</option>
					<option value="01">1:00am</option>
					<option value="02">2:00am</option>
					<option value="03">3:00am</option>
					<option value="04">4:00am</option>
					<option value="05">5:00am</option>
					<option value="06">6:00am</option>
					<option value="07">7:00am</option>
					<option value="08">8:00am</option>
					<option value="09">9:00am</option>
					<option value="10">10:00am</option>
					<option value="11">11:00am</option>
					<option value="12">12:00pm</option>
					<option value="13">1:00pm</option>
					<option value="14">2:00pm</option>
					<option value="15">3:00pm</option>
					<option value="16">4:00pm</option>
					<option value="17">5:00pm</option>
					<option value="18">6:00pm</option>
					<option value="19">7:00pm</option>
					<option value="20">8:00pm</option>
					<option value="21">9:00pm</option>
					<option value="22">10:00pm</option>
					<option value="23">11:00pm</option>
				</select></td>
			</tr>
			<tr valign="top">
				<th scope="row">Age Range:</th>
				<td><select name="enmge_sa" id="enmge_sa" tabindex="26">
					<option value="101"1>- Any -</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
					<option value="32">32</option>
					<option value="33">33</option>
					<option value="34">34</option>
					<option value="35">35</option>
					<option value="36">36</option>
					<option value="37">37</option>
					<option value="38">38</option>
					<option value="39">39</option>
					<option value="40">40</option>
					<option value="41">41</option>
					<option value="42">42</option>
					<option value="43">43</option>
					<option value="44">44</option>
					<option value="45">45</option>
					<option value="46">46</option>
					<option value="47">47</option>
					<option value="48">48</option>
					<option value="49">49</option>
					<option value="50">50</option>
					<option value="51">51</option>
					<option value="52">52</option>
					<option value="53">53</option>
					<option value="54">54</option>
					<option value="55">55</option>
					<option value="56">56</option>
					<option value="57">57</option>
					<option value="58">58</option>
					<option value="59">59</option>
					<option value="60">60</option>
					<option value="61">61</option>
					<option value="62">62</option>
					<option value="63">63</option>
					<option value="64">64</option>
					<option value="65">65</option>
					<option value="66">66</option>
					<option value="67">67</option>
					<option value="68">68</option>
					<option value="69">69</option>
					<option value="70">70</option>
					<option value="71">71</option>
					<option value="72">72</option>
					<option value="73">73</option>
					<option value="74">74</option>
					<option value="75">75</option>
					<option value="76">76</option>
					<option value="77">77</option>
					<option value="78">78</option>
					<option value="79">79</option>
					<option value="80">80</option>
					<option value="81">81</option>
					<option value="82">82</option>
					<option value="83">83</option>
					<option value="84">84</option>
					<option value="85">85</option>
					<option value="86">86</option>
					<option value="87">87</option>
					<option value="88">88</option>
					<option value="89">89</option>
					<option value="90">90</option>
					<option value="91">91</option>
					<option value="92">92</option>
					<option value="93">93</option>
					<option value="94">94</option>
					<option value="95">95</option>
					<option value="96">96</option>
					<option value="97">97</option>
					<option value="98">98</option>
					<option value="99">99</option>
					<option value="100">100</option>
				</select> - 
				<select name="enmge_ea" id="enmge_ea" tabindex="27">
					<option value="101"1>- Any -</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
					<option value="32">32</option>
					<option value="33">33</option>
					<option value="34">34</option>
					<option value="35">35</option>
					<option value="36">36</option>
					<option value="37">37</option>
					<option value="38">38</option>
					<option value="39">39</option>
					<option value="40">40</option>
					<option value="41">41</option>
					<option value="42">42</option>
					<option value="43">43</option>
					<option value="44">44</option>
					<option value="45">45</option>
					<option value="46">46</option>
					<option value="47">47</option>
					<option value="48">48</option>
					<option value="49">49</option>
					<option value="50">50</option>
					<option value="51">51</option>
					<option value="52">52</option>
					<option value="53">53</option>
					<option value="54">54</option>
					<option value="55">55</option>
					<option value="56">56</option>
					<option value="57">57</option>
					<option value="58">58</option>
					<option value="59">59</option>
					<option value="60">60</option>
					<option value="61">61</option>
					<option value="62">62</option>
					<option value="63">63</option>
					<option value="64">64</option>
					<option value="65">65</option>
					<option value="66">66</option>
					<option value="67">67</option>
					<option value="68">68</option>
					<option value="69">69</option>
					<option value="70">70</option>
					<option value="71">71</option>
					<option value="72">72</option>
					<option value="73">73</option>
					<option value="74">74</option>
					<option value="75">75</option>
					<option value="76">76</option>
					<option value="77">77</option>
					<option value="78">78</option>
					<option value="79">79</option>
					<option value="80">80</option>
					<option value="81">81</option>
					<option value="82">82</option>
					<option value="83">83</option>
					<option value="84">84</option>
					<option value="85">85</option>
					<option value="86">86</option>
					<option value="87">87</option>
					<option value="88">88</option>
					<option value="89">89</option>
					<option value="90">90</option>
					<option value="91">91</option>
					<option value="92">92</option>
					<option value="93">93</option>
					<option value="94">94</option>
					<option value="95">95</option>
					<option value="96">96</option>
					<option value="97">97</option>
					<option value="98">98</option>
					<option value="99">99</option>
					<option value="100">100</option>
				</select></td>
			</tr>
			<tr valign="top">
				<th scope="row">Postal Code:</th>
				<td><input type="text" id="enmge_zip" name="enmge_zip" value="" tabindex="28" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Status:</th>
				<td><select id="enmge_status" name="enmge_status" tabindex="29">
					<option value="n">- All -</option>
					<option value="1">Open</option>
					<option value="0">Closed</option>
					<option value="2">Full</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Include Private?:</th>
				<td><select id="enmge_private" name="enmge_private" tabindex="30">
					<option value="0">No</option>
					<option value="1">Yes</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Meeting Status:</th>
				<td><select id="enmge_meeting" name="enmge_meeting" tabindex="31">
					<option value="0">Only <?php echo stripslashes($enmge_groupptitle); ?> Currently Meeting</option>
					<option value="1">Include <?php echo stripslashes($enmge_groupptitle); ?> Who Aren't Meeting</option>
					<option value="2">Specify Custom Range</option>
					</select>
				</td>
			</tr>
			<tr valign="top" id="startingrow" style="display: none">
				<th scope="row">Starting On/After:</th>
				<td><input type="text" id="enmge_sd" name="enmge_sd" value="" tabindex="32" /></td>
			</tr>
			<tr valign="top" id="endingrow" style="display: none">
				<th scope="row">Ending On/Before:</th>
				<td><input type="text" id="enmge_ed" name="enmge_ed" value="" tabindex="33" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Meeting Location:</th>
				<td><select id="enmge_onsite" name="enmge_onsite" tabindex="34">
					<option value="0">Onsite and Offsite</option>
					<option value="1">Onsite Only</option>
					<option value="2">Offsite Only</option>
					</select>
				</td>
			</tr>
		</table><br /><br />
		<div id="submitarea" style="display: none"><input name="Submit" type="submit" class="button-primary" value="Run Report" tabindex="35" /></div>
	</form>
	<?php include ('gecredits.php'); ?>	
</div>
<?php } // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>