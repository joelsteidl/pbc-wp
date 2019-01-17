<?php /* ----- Groups Engine - Admin Embed Code Page ----- */

global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
	if ( current_user_can( 'edit_posts' ) ) {

		// ***** Get Labels
		$enmge_options = get_option( 'enm_groupsengine_options' ); 
		$enmge_grouptitle = $enmge_options['grouptitle'];
		$enmge_groupptitle = $enmge_options['groupptitle']; 
		$enmge_grouptypetitle = $enmge_options['grouptypetitle'];
		$enmge_grouptypeptitle = $enmge_options['grouptypeptitle'];
		$enmge_locationtitle = $enmge_options['locationtitle'];
		$enmge_locationptitle = $enmge_options['locationptitle'];
		$enmge_topictitle = $enmge_options['topictitle'];
		$enmge_topicptitle = $enmge_options['topicptitle'];

		global $wpdb;

		// Get All Group Types
		$enmge_preparredgtsql = "SELECT group_type_id, group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_title ASC"; 
		$enmge_gts = $wpdb->get_results( $enmge_preparredgtsql );

		// Get All Topics
		$enmge_preparredtsql = "SELECT topic_id, topic_name FROM " . $wpdb->prefix . "ge_topics" . " ORDER BY topic_name ASC"; 
		$enmge_ts = $wpdb->get_results( $enmge_preparredtsql );

		// Get All Locations
		$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " ORDER BY location_name ASC"; 	
		$enmge_locations = $wpdb->get_results( $enmge_lpreparredsql );
		
?>
<div class="wrap">
	<script type="text/javascript" src="<?php echo plugins_url() .'/groupsengine_plugin/js/embed_code.js'; ?>"></script>

	<h2 class="enmge" style="padding-bottom: 5px">Embed Into a Page or Post</h2>
	<p id="enmge-get-plugin-link" title="<?php echo plugins_url() .'/groupsengine_plugin/includes/admin/'; ?>"></p>
	<p id="xxge" title="<?php echo base64_encode(ABSPATH); ?>"></p>
	
	<ul id="enmge-group-options">
		<li class="selected"><a href="#" id="enmge-simple-embed">Simple Shortcode</a></li>
		<li><a href="#" id="enmge-custom-embed">Generate Custom Shortcode</a></li>
	</ul>

	<div id="enmge-simple">
		<h3>Using the Simple Shortcode</h3>
		
		<p>Groups Engine includes <a href="<?php echo admin_url() . "admin.php?page=groupsengine_plugin/groupsengine_plugin.php_userguide#se-customizing"; ?>">a simple shortcode</a> that allows you to add a <?php echo $enmge_grouptitle; ?> search page to your site in a matter of seconds. The Groups Engine browser can be easily embedded within any page or post on your WordPress site by entering the following shortcode into the visual editor (or into the Shortcode block if you're using Gutenberg):</p>
		<blockquote><strong>[groupsengine]</strong></blockquote>
		<p>In the visual editor, you can place content above and below the shortcode to flesh out the page however you wish (just make sure the shortcode is on its own line). See the example below:</p>
		<p style="text-align: center"><img src="<?php echo plugins_url() .'/groupsengine_plugin/images/embed_example.jpg'; ?>" width="633" height="482" alt="Example of using the Groups Engine shortcode" style="border: 5px solid #ECECEC" /></p>
		
	</div>

	<div id="enmge-custom" style="display: none">

		<p>Use the tool below to create a shortcode that will embed exactly what you want on any given page. Use Groups Engine to embed different subsets of your content all throughout your site. Only one shortcode per page is recommended.</p>
		
		<h2><strong>Start Here:</strong> Choose What to Display...</h2>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">What to Embed:</th>
				<td><select id="enmge_embedtype" name="enmge_embedtype" tabindex="1">
					<option value="0">- Choose an Option -</option>
					<option value="1">Embed a <?php echo stripslashes($enmge_grouptitle); ?> List</option>
					<option value="2">Embed a Single <?php echo stripslashes($enmge_grouptitle); ?></option>
					</select>
				</td>
			</tr>
		</table>

		<div id="findgrouparea" style="display: none">
			<h2>Find a <?php echo stripslashes($enmge_grouptitle); ?>...</h2>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">From <?php echo stripslashes($enmge_grouptypetitle); ?>:</th>
					<td><select id="enmge_findgrouptype" name="enmge_findgrouptype" tabindex="2">
						<option value="n">- Choose an Option -</option>
						<option value="0">All <?php echo stripslashes($enmge_grouptypeptitle); ?></option>
						<?php foreach ($enmge_gts as $gt) {  ?>
						<option value="<?php echo $gt->group_type_id; ?>"><?php echo stripslashes($gt->group_type_title); ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
			</table>
			<div id="choosegroup">
			</div>
		</div>

		<div id="groupoptions" style="display: none">
			<h2>Choose Your Options...</h2>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Enable Contact Leader:</th>
					<td>
						<select id="enmge_cl" name="enmge_cl" tabindex="3">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Show Individual Map:</th>
					<td>
						<select id="enmge_sm" name="enmge_sm" tabindex="4">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Enable <?php echo stripslashes($enmge_grouptitle); ?> List:</th>
					<td>
						<select id="enmge_gl" name="enmge_gl" tabindex="5">
							<option value="1">Yes</option>
							<option value="0" selected="selected">No</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="grouplistarea" style="display: none">
			<h2>Set Up the <?php echo stripslashes($enmge_grouptitle); ?> List...</h2>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo stripslashes($enmge_grouptypetitle); ?>:</th>
					<td><select id="enmge_grouptype" name="enmge_grouptype" tabindex="6">
						<option value="0">- Any -</option>
						<?php foreach ($enmge_gts as $gt) {  ?>
						<option value="<?php echo $gt->group_type_id; ?>"><?php echo stripslashes($gt->group_type_title); ?></option>
						<?php } ?>
						</select></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo stripslashes($enmge_topictitle); ?>:</th>
					<td><select id="enmge_topic" name="enmge_topic" tabindex="7">
						<option value="0">- Any -</option>
						<?php foreach ($enmge_ts as $t) {  ?>
						<option value="<?php echo $t->topic_id; ?>"><?php echo stripslashes($t->topic_name); ?></option>
						<?php } ?>
						</select></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo stripslashes($enmge_locationtitle); ?>:</th>
					<td><select id="enmge_location" name="enmge_location" tabindex="8">
						<option value="0">- Any -</option>
						<?php foreach ($enmge_locations as $l) {  ?>
						<option value="<?php echo $l->location_id; ?>"><?php echo stripslashes($l->location_name); ?></option>
						<?php } ?>
						</select></td>
				</tr>
				<tr valign="top">
					<th scope="row">Meeting:</th>
					<td><select id="enmge_meeting" name="enmge_meeting" tabindex="9">
						<option value="2">Onsite and Offsite</option>
						<option value="1">Onsite Only</option>
						<option value="0">Offsite Only</option>
						</select></td>
				</tr>
				<tr valign="top">
					<th scope="row">Day:</th>
					<td><select id="enmge_day" name="enmge_day" tabindex="10">
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
					<td><select id="enmge_st" name="enmge_st" tabindex="11">
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
					<select id="enmge_et" name="enmge_et" tabindex="12">
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
					<td><select name="enmge_sa" id="enmge_sa" tabindex="13">
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
					<select name="enmge_ea" id="enmge_ea" tabindex="14">
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
					<td><input type="text" id="enmge_zip" name="enmge_zip" value="" tabindex="15" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Status:</th>
					<td><select id="enmge_status" name="enmge_status" tabindex="16">
						<option value="n">- All -</option>
						<option value="1">Open</option>
						<option value="0">Closed</option>
						<option value="2">Full</option>
						</select></td>
				</tr>
				<tr valign="top">
					<th scope="row"></th>
					<td><strong><a href="#" id="advancedlink">Show Advanced Options</a></strong></td>
				</tr>
			</table><br />
			

			<div id="advanced" style="display: none">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Start Date:</th>
						<td><select id="enmge_start" name="enmge_start" tabindex="16">
							<option value="0">Only <?php echo stripslashes($enmge_groupptitle); ?> starting on or before today</option>
							<option value="1">Display all <?php echo stripslashes($enmge_groupptitle); ?></option>
						</select></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo stripslashes($enmge_grouptitle); ?> List Map Center: <p class="ge-form-instructions">Enter a postal code.</p></th>
						<td><input type="text" id="enmge_cz" name="enmge_cz" value="" tabindex="17" size="5" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Map Zoom Level: <p class="ge-form-instructions">Enter a number 1-15</p></th>
						<td><input type="text" id="enmge_zl" name="enmge_zl" value="" tabindex="18" size="5" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo stripslashes($enmge_grouptitle); ?> List Initial Display:</th>
						<td><select id="enmge_v" name="enmge_v" tabindex="19">
							<option value="0">as list</option>
							<option value="1">as map</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Display View Toggle:</th>
						<td>
							<select id="enmge_vo" name="enmge_vo" tabindex="20">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</td>
					</tr>
					<tr valign="top" id="indmap">
						<th scope="row">Show Individual <?php echo stripslashes($enmge_grouptitle); ?> Map:</th>
						<td>
							<select id="enmge_glsm" name="enmge_glsm" tabindex="21">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</td>
					</tr>
					<tr valign="top" id="contactleader">
						<th scope="row">Enable Contact Leader:</th>
						<td>
							<select id="enmge_glcl" name="enmge_glcl" tabindex="22">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo stripslashes($enmge_groupptitle); ?> Per Page: <p class="ge-form-instructions">Enter a number to override the default set in Settings > Groups Engine.</p></th>
						<td><input type="text" id="enmge_pag" name="enmge_pag" value="" tabindex="23" size="5" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Sort <?php echo stripslashes($enmge_groupptitle); ?> By:</th>
						<td>
							<select id="enmge_sort" name="enmge_sort" tabindex="24">
								<option value="0">Day/Time</option>
								<option value="1"><?php echo stripslashes($enmge_grouptitle); ?> Title (A-Z)</option>
								<option value="2"><?php echo stripslashes($enmge_grouptitle); ?> Title (Z-A)</option>
								<option value="3">Start Age</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Search Options:</th>
						<td>
							<select id="enmge_fo" name="enmge_fo" tabindex="25">
								<option value="0">Enable <?php echo stripslashes($enmge_grouptitle); ?> Search</option>
								<option value="1">Limit <?php echo stripslashes($enmge_grouptitle); ?> Search</option>
								<option value="2">Disable <?php echo stripslashes($enmge_grouptitle); ?> Search</option>
							</select>
						</td>
					</tr>
					<tr valign="top" id="filterrow" style="display: none">
						<th scope="row">Limit Search: <p class="ge-form-instructions">Unchecked categories will be limited to the options set in the search criteria above.</p></th>
						<td>
							<ul>
								<li><input name="enmge_xgt" id="enmge_xgt" type="checkbox" value="1" class="check" checked="checked" tabindex="26" /> <label for="enmge_xgt">Allow <?php echo stripslashes($enmge_grouptypetitle); ?> Filter</label></li>
								<li><input name="enmge_xt" id="enmge_xt" type="checkbox" value="1" class="check" checked="checked" tabindex="27" /> <label for="enmge_xt">Allow <?php echo stripslashes($enmge_topictitle); ?> Filter</label></li>
								<li><input name="enmge_xl" id="enmge_xl" type="checkbox" value="1" class="check" checked="checked" tabindex="28" /> <label for="enmge_xl">Allow <?php echo stripslashes($enmge_locationtitle); ?> Filter</label></li>
								<li><input name="enmge_xm" id="enmge_xm" type="checkbox" value="1" class="check" checked="checked" tabindex="29" /> <label for="enmge_xm">Allow Meeting Filter</label></li>
								<li><input name="enmge_xd" id="enmge_xd" type="checkbox" value="1" class="check" checked="checked" tabindex="30" /> <label for="enmge_xd">Allow Day Filter</label></li>
								<li><input name="enmge_xst" id="enmge_xst" type="checkbox" value="1" class="check" checked="checked" tabindex="31" /> <label for="enmge_xst">Allow Time Filter</label></li>
								<li><input name="enmge_xsa" id="enmge_xsa" type="checkbox" value="1" class="check" checked="checked" tabindex="32" /> <label for="enmge_xsa">Allow Age Filter</label></li>
								<li><input name="enmge_xz" id="enmge_xz" type="checkbox" value="1" class="check" checked="checked" tabindex="33" /> <label for="enmge_xz">Allow Postal Code Filter</label></li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
		</div>
		

		<a href="#" id="enmge-generate-embed-code" class="button-primary" style="display: none" tabindex="34">Generate Code</a><br /><br />

		<div id="enmge-embed-code">

		</div>
		
	</div>
	
	<?php include ('gecredits.php'); ?>	
</div>
<?php }  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>

