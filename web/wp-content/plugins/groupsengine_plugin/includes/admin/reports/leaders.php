<?php /* Groups Engine - Browser Report for Emails of Group Leaders */
	require_once 'report_header.php';
	
	if ( current_user_can( 'edit_posts' ) ) { 
		
		if ( $_POST ) {
			global $wpdb;

			if ($_POST['enmge_leadergrouptype'] != 0) { // Are they viewing groups by group type?
				$enmge_gt = strip_tags($_POST['enmge_leadergrouptype']);
			} else {
				$enmge_gt = 0;
			}

			if ($_POST['enmge_leadertopic'] != 0) { // Are they viewing groups by topic?
				$enmge_t = strip_tags($_POST['enmge_leadertopic']);
			} else {
				$enmge_t = 0;
			}

			if ($_POST['enmge_leaderlocation'] != 0) { // Are they viewing groups by location?
				$enmge_l = strip_tags($_POST['enmge_leaderlocation']);
			}  else {
				$enmge_l = 0;
			}

			if ($_POST['enmge_leaderday'] != 0) { // Are they viewing groups by day?
				$enmge_d = strip_tags($_POST['enmge_leaderday']);
			}  else {
				$enmge_d = 0;
			}

			if ($_POST['enmge_leaderst'] != 24) { // Did they specify a start time?
				$enmge_ust = strip_tags($_POST['enmge_leaderst']);
				$enmge_st = $enmge_ust . ":00:00";
			}  else {
				$enmge_st = 24;
			}

			if ($_POST['enmge_leaderet'] != 24) { // Did they specify an end time?
				$enmge_uet = strip_tags($_POST['enmge_leaderet']);
				$enmge_et = $enmge_uet . ":00:00";
			} else {
				$enmge_et = 24;
			}

			if ($_POST['enmge_leadersa'] != 101) { // Did they specify a start age?
				$enmge_sa = strip_tags($_POST['enmge_leadersa']);
			} else {
				$enmge_sa = 101;
			}

			if ($_POST['enmge_leaderea'] != 101) { // Did they specify an end age?
				$enmge_ea = strip_tags($_POST['enmge_leaderea']);
			} else {
				$enmge_ea = 101;
			}

			if ($_POST['enmge_leadersd'] != null) { // Start Date
				$enmge_sd = strip_tags($_POST['enmge_leadersd']);
			} else {
				$enmge_sd = 0;
			}

			if ($_POST['enmge_leadered'] != null) { // End Date
				$enmge_ed = strip_tags($_POST['enmge_leadered']);
			} else {
				$enmge_ed = 0;
			}

			if ($_POST['enmge_leaderstatus'] != 'n') { // Group Status
				$enmge_status = strip_tags($_POST['enmge_leaderstatus']);
			} else {
				$enmge_status = 'n';
			}

			if ($_POST['enmge_leaderzip'] != null) { // Did they specify a zip?
				$enmge_z = strip_tags($_POST['enmge_leaderzip']);
			} else {
				$enmge_z = 0;
			}

			if ($_POST['enmge_leaderprivate'] != null) { // Public and private?
				$enmge_pr = strip_tags($_POST['enmge_leaderprivate']);
			} else {
				$enmge_pr = 0;
			}

			if ($_POST['enmge_leadermeeting'] != null) { // Currently meeting?
				$enmge_cu = strip_tags($_POST['enmge_leadermeeting']);
			} else {
				$enmge_cu = 0;
			}

			if ($_POST['enmge_leaderonsite'] != null) { // Onsite?
				$enmge_onsite = strip_tags($_POST['enmge_leaderonsite']);
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
			$enmge_preparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (group_id) LEFT JOIN " . $wpdb->prefix . "ge_leaders USING (leader_id)";
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
			$enmge_preparredsql .= " GROUP BY leader_email";
			$enmge_groups = $wpdb->get_results( $enmge_preparredsql  );
			
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Groups Engine - Leader Report</title>
	<link rel="stylesheet" href="../../../css/ge_backend.css" type="text/css" />
</head>
<body id="ge-report">

<h1>Leader Report</h1>
	
<table id="groupreporttable" cellpadding="0" cellspacing="0">
	<tr>
		<th>Name</th>
		<th>Email</th>
	</tr>
<?php $tableodd = 0; foreach ($enmge_groups as $g) { ?>
	<tr<?php if ( $tableodd == 1 ) { echo " class=\"odd\""; }?>>
		<td><?php echo stripslashes($g->leader_name); ?></td>
		<td><a href="mailto:<?php echo stripslashes($g->leader_email); ?>"><?php echo stripslashes($g->leader_email); ?></a></td>
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