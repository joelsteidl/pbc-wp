<?php /* Groups Engine - Groups Report */
	require_once 'report_header.php';
	
	if ( current_user_can( 'edit_posts' ) ) {  
		
		if ( $_POST ) {
			global $wpdb;
		
			if ($_POST['enmge_grouptype'] != 0) { // Are they viewing groups by group type?
				$enmge_gt = strip_tags($_POST['enmge_grouptype']);
			} else {
				$enmge_gt = 0;
			}

			if ($_POST['enmge_topic'] != 0) { // Are they viewing groups by topic?
				$enmge_t = strip_tags($_POST['enmge_topic']);
			} else {
				$enmge_t = 0;
			}

			if ($_POST['enmge_location'] != 0) { // Are they viewing groups by location?
				$enmge_l = strip_tags($_POST['enmge_location']);
			}  else {
				$enmge_l = 0;
			}

			if ($_POST['enmge_day'] != 0) { // Are they viewing groups by day?
				$enmge_d = strip_tags($_POST['enmge_day']);
			}  else {
				$enmge_d = 0;
			}

			if ($_POST['enmge_st'] != 24) { // Did they specify a start time?
				$enmge_ust = strip_tags($_POST['enmge_st']);
				$enmge_st = $enmge_ust . ":00:00";
			}  else {
				$enmge_st = 24;
			}

			if ($_POST['enmge_et'] != 24) { // Did they specify an end time?
				$enmge_uet = strip_tags($_POST['enmge_et']);
				$enmge_et = $enmge_uet . ":00:00";
			} else {
				$enmge_et = 24;
			}

			if ($_POST['enmge_sa'] != 101) { // Did they specify a start age?
				$enmge_sa = strip_tags($_POST['enmge_sa']);
			} else {
				$enmge_sa = 101;
			}

			if ($_POST['enmge_ea'] != 101) { // Did they specify an end age?
				$enmge_ea = strip_tags($_POST['enmge_ea']);
			} else {
				$enmge_ea = 101;
			}

			if ($_POST['enmge_zip'] != null) { // Did they specify a zip?
				$enmge_z = strip_tags($_POST['enmge_zip']);
			} else {
				$enmge_z = 0;
			}

			if ($_POST['enmge_sd'] != null) { // Start Date
				$enmge_sd = strip_tags($_POST['enmge_sd']);
			} else {
				$enmge_sd = 0;
			}

			if ($_POST['enmge_ed'] != null) { // End Date
				$enmge_ed = strip_tags($_POST['enmge_ed']);
			} else {
				$enmge_ed = 0;
			}

			if ($_POST['enmge_status'] != 'n') { // Group Status
				$enmge_status = strip_tags($_POST['enmge_status']);
			} else {
				$enmge_status = 'n';
			}

			if ($_POST['enmge_private'] != null) { // Public and private?
				$enmge_pr = strip_tags($_POST['enmge_private']);
			} else {
				$enmge_pr = 0;
			}

			if ($_POST['enmge_meeting'] != null) { // Currently meeting?
				$enmge_cu = strip_tags($_POST['enmge_meeting']);
			} else {
				$enmge_cu = 0;
			}

			if ($_POST['enmge_onsite'] != null) { // Onsite?
				$enmge_onsite = strip_tags($_POST['enmge_onsite']);
			} else {
				$enmge_onsite = 0;
			}

			$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_groups";  
			if ( $enmge_gt != 0 ) { // grouptype
				$enmge_preparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_id)";
			}
			if ( $enmge_t != NULL ) { // topic
				$enmge_preparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (group_id)";
			}
			if ( $enmge_l != NULL ) { // location
				$enmge_preparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (group_id)";
			}
			if ( $enmge_sd != NULL || $enmge_ed != NULL ) { 
				$enmge_preparredsql .= " WHERE group_id > 0";
				if ( $enmge_sd != NULL ) {
					$enmge_preparredsql .= " AND group_begins >= '" . $enmge_sd . "'";
				}
				if ( $enmge_ed != NULL ) {
					$enmge_preparredsql .= " AND group_ends <= '" . $enmge_ed . "'";
				}
			} elseif ( $enmge_cu == 0 ) { // currently meeting
				$enmge_preparredsql .= " WHERE ((group_begins <= CURDATE() AND group_ends >= CURDATE()) OR (group_begins <= CURDATE() AND group_noend = 1))";
			} else {
				$enmge_preparredsql .= " WHERE group_id > 0";
			}
			if ( $enmge_status != 'n' ) {
				$enmge_preparredsql .= " AND group_status = " . $enmge_status;
			}
			if ( $enmge_d != NULL ) { // day
				$enmge_preparredsql .= " AND group_day = " . $enmge_d;
			}
			if ( $enmge_st < 24 && $enmge_et < 24 ) { 
				$enmge_preparredsql .= " AND (((group_starttime >= \"" . $enmge_st . "\" AND group_starttime <= \"" . $enmge_et . "\") OR (group_endtime <= \"" . $enmge_et . "\" AND group_endtime >= \"" . $enmge_st . "\")) OR (group_starttime <= \"" . $enmge_st . "\" AND group_endtime >= \"" . $enmge_et . "\"))";
			} elseif ( $enmge_st < 24 ) {
				$enmge_preparredsql .= " AND (group_starttime >= \"" . $enmge_st . "\" OR group_endtime >= \"" . $enmge_st . "\")";
			} elseif ( $enmge_et < 24 ) {
				$enmge_preparredsql .= " AND (group_starttime <= \"" . $enmge_et . "\" OR group_endtime <= \"" . $enmge_et . "\")";
			}
			if ( $enmge_sa < 101 && $enmge_ea < 101 ) { // start age
				$enmge_preparredsql .= " AND (((group_startage >= " . $enmge_sa . " AND group_startage <= " . $enmge_ea . ") OR (group_endage <= " . $enmge_ea . " AND group_endage >= " . $enmge_sa . ")) OR (group_startage <= " . $enmge_sa . " AND group_endage >= " . $enmge_ea . "))";
			} elseif ( $enmge_sa < 101 ) {
				$enmge_preparredsql .= " AND (group_startage >= " . $enmge_sa . " OR group_endage >= " . $enmge_sa . ")";
			} elseif ( $enmge_ea < 101 ) {
				$enmge_preparredsql .= " AND (group_startage <= " . $enmge_ea . " OR group_endage <= " . $enmge_ea . ")";
			}
			if ( $enmge_z != NULL ) { // end age
				$enmge_preparredsql .= " AND group_zip = " . $enmge_z ;
			}
			if ( $enmge_gt != NULL ) { // grouptype
				$enmge_preparredsql .= " AND group_type_id = " . $enmge_gt;
			}
			if ( $enmge_t != NULL ) { // topic
				$enmge_preparredsql .= " AND topic_id = " . $enmge_t;
			}
			if ( $enmge_l != NULL ) { // location
				$enmge_preparredsql .= " AND location_id = " . $enmge_l;
			}
			if ( $enmge_pr == 0 ) { // privacy
				$enmge_preparredsql .= " AND group_privacy = 1";
			} 
			if ( $enmge_onsite == 1 ) { // onsite/offsite
				$enmge_preparredsql .= " AND group_onsite > 0";
			} elseif ( $enmge_onsite == 2 ) {
				$enmge_preparredsql .= " AND group_onsite = 0";
			}
			$enmge_preparredsql .= " GROUP BY group_id ORDER BY group_day, group_starttime ASC";
			$enmge_groups = $wpdb->get_results( $enmge_preparredsql  );
			$enmge_gcount = $wpdb->num_rows;

			// Get All Topics
			$enmge_preparredtsql = "SELECT topic_id, topic_name FROM " . $wpdb->prefix . "ge_topics" . " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_id IS NOT NULL GROUP BY topic_id ORDER BY topic_name ASC"; 
			$enmge_ts = $wpdb->get_results( $enmge_preparredtsql );

			// Get All Group Topic Matches
			$enmge_preparredgtmsql = "SELECT topic_id, group_id FROM " . $wpdb->prefix . "ge_group_topic_matches"; 
			$enmge_gtm = $wpdb->get_results( $enmge_preparredgtmsql );

			// Get All Locations
			$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (location_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_id IS NOT NULL GROUP BY location_id ORDER BY location_id DESC"; 	
			$enmge_locations = $wpdb->get_results( $enmge_lpreparredsql );

			// Get All Group Location Matches
			$enmge_preparredglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches"; 
			$enmge_glm = $wpdb->get_results( $enmge_preparredglmsql );

			// Get All Group Types
			$enmge_preparredgtsql = "SELECT group_type_id, group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_type_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_id IS NOT NULL GROUP BY group_type_id ORDER BY group_type_title ASC"; 
			$enmge_gts = $wpdb->get_results( $enmge_preparredgtsql );

			// Get All Group Group Type Matches
			$enmge_preparredggtmmsql = "SELECT group_type_id, group_id FROM " . $wpdb->prefix . "ge_group_group_type_matches"; 
			$enmge_ggtm = $wpdb->get_results( $enmge_preparredggtmmsql );

			// Get All Leaders
			$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " GROUP BY leader_id ORDER BY leader_name ASC"; 
			$enmge_les = $wpdb->get_results( $enmge_preparredlesql );

			// Get All Group Leader Matches
			$enmge_preparredlemsql = "SELECT leader_id, group_id FROM " . $wpdb->prefix . "ge_group_leader_matches"; 
			$enmge_glem = $wpdb->get_results( $enmge_preparredlemsql );

		}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Groups Engine - <?php echo stripslashes($enmge_groupptitle); ?> Report</title>
	<link rel="stylesheet" href="../../../css/ge_backend.css" type="text/css" />
</head>
<body id="ge-report">
<p class="reportcount"><em><?php echo $enmge_gcount; ?> <?php echo stripslashes($enmge_groupptitle); ?> Found</em></p>
<h1><?php echo stripslashes($enmge_grouptitle); ?> Report</h1>

<table id="groupreporttable" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo stripslashes($enmge_grouptitle); ?></th>
		<th>Day</th>
		<th>Time</th>
		<th>Ages</th>
		<th>Leader(s)</th>
		<th><?php echo stripslashes($enmge_locationtitle); ?></th>
		<th>Meets at</th>
		<th><?php echo stripslashes($enmge_grouptypetitle); ?></th>
		<th><?php echo stripslashes($enmge_topictitle); ?></th>
		<th>Childcare?</th>
		<th>Status</th>
	</tr>
<?php $tableodd = 0; foreach ($enmge_groups as $g) { ?>
	<tr<?php if ( $tableodd == 1 ) { echo " class=\"odd\""; }?>>
		<td><?php echo stripslashes($g->group_title); ?></td>
		<td><?php if ( $g->group_day == 1 ) { echo "Sun";  } ?><?php if ( $g->group_day == 2 ) { echo "Mon";  } ?><?php if ( $g->group_day == 3 ) { echo "Tue";  } ?><?php if ( $g->group_day == 4 ) { echo "Wed";  } ?><?php if ( $g->group_day == 5 ) { echo "Thu";  } ?><?php if ( $g->group_day == 6 ) { echo "Fri";  } ?><?php if ( $g->group_day == 7 ) { echo "Sat";  } ?></td>
		<td><?php if ( date('a', strtotime($g->group_starttime)) == date('a', strtotime($g->group_endtime)) ) { echo date('g:i', strtotime($g->group_starttime)); } else { echo date('g:ia', strtotime($g->group_starttime)); }; ?>-<?php echo date('g:ia', strtotime($g->group_endtime)); ?></td>
		<td><?php echo $g->group_startage; ?><?php if ( $g->group_endage == 100 ) { echo "+"; } else { echo "-" . $g->group_endage; } ?></td>
		<td><?php $le_comma = 1; foreach ( $enmge_les as $le) { ?><?php foreach ( $enmge_glem as $glem) { ?><?php if ( ($glem->group_id == $g->group_id) && ($glem->leader_id == $le->leader_id) ) { if ( $le_comma == 1 ) { echo "<a href=\"mailto:" . $le->leader_email . "\">" . stripslashes($le->leader_name) . "</a>"; $le_comma = $le_comma+1; } else { echo ", <a href=\"mailto:" . $le->leader_email . "\">" . stripslashes($le->leader_name) . "</a>"; $le_comma = $le_comma+1; } } ?><?php } ?><?php } ?></td>
		<td><?php $l_comma = 1; foreach ( $enmge_locations as $l) { ?><?php foreach ( $enmge_glm as $glm) { ?><?php if ( ($glm->group_id == $g->group_id) && ($glm->location_id == $l->location_id) ) { if ( $l_comma == 1 ) { echo stripslashes($l->location_name); $l_comma = $l_comma+1; } else { echo ", " . stripslashes($l->location_name); $l_comma = $l_comma+1; } } ?><?php } ?><?php } ?></td>
		<td><?php if ( $g->group_onsite > 0 ) { echo stripslashes($g->group_campus_name) . " - " . stripslashes($g->group_location_label); } else { if ($enmge_offsitelabel == 1) {echo "(" . $enmge_offsite . ") " . stripslashes($g->group_location_label);} else {echo stripslashes($g->group_location_label);} } ?></td>
		
		<td><?php $gt_comma = 1; foreach ( $enmge_gts as $gt) { ?><?php foreach ( $enmge_ggtm as $ggtm) { ?><?php if ( ($ggtm->group_id == $g->group_id) && ($ggtm->group_type_id == $gt->group_type_id) ) { if ( $gt_comma == 1 ) { echo stripslashes($gt->group_type_title); $gt_comma = $gt_comma+1; } else { echo ", " . stripslashes($gt->group_type_title); $gt_comma = $gt_comma+1; } } ?><?php } ?><?php } ?></td>	
		
		<td><?php $t_comma = 1; foreach ( $enmge_ts as $t) { ?><?php foreach ( $enmge_gtm as $gtm) { ?><?php if ( ($gtm->group_id == $g->group_id) && ($gtm->topic_id == $t->topic_id) ) { if ( $t_comma == 1 ) { echo stripslashes($t->topic_name); $t_comma = $t_comma+1; } else { echo ", " . stripslashes($t->topic_name); $t_comma = $t_comma+1; } } ?><?php } ?><?php } ?></td>				
		<td class="center"><?php if ( $g->group_childcare == 0 ) { echo 'No';} else { echo 'Yes';} ?></td>
		<td class="center"><?php if ( $g->group_status == 1 ) { echo "Open"; } elseif ( $g->group_status == 0 ) { echo "Closed"; } else { echo "Full"; } ?></td>
	</tr>
<?php if ( $tableodd == 0 ) { $tableodd = 1; } else { $tableodd = 0; }} ?>
</table>

<h5 class="footer">Report generated by <strong>Groups Engine</strong> for <em><?php echo $enmge_options['ministryname']; ?></em> on <?php echo date('F j, Y'); ?></h5>
</body>
</html>
<?php } else {
	$enmge_redirecturl = home_url();
	header("Location: $enmge_redirecturl");
} ?>