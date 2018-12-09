<?php /* ----- Groups Engine - Display Groups ----- */

global $wpdb;
global $wp_version;

if ( $wp_version != null ) {

$enmge_options = get_option( 'enm_groupsengine_options' );
$enmge_spamprotection = $enmge_options['spamprotection'];
$enmge_apikey = $enmge_options['apikey'];
$enmge_mapcenter = $enmge_options['mapcenter'];
$enmge_contactinstructions = $enmge_options['contactinstructions'];
$enmge_contactsuccess = $enmge_options['contactsuccess'];
$enmge_credits = $enmge_options['credits'];
$enmge_pointer = $enmge_options['pointer'];
$enmge_dpag = $enmge_options['pag'];
$enmge_grouptitle = $enmge_options['grouptitle'];
$enmge_groupptitle = $enmge_options['groupptitle'];
$enmge_grouptypetitle = $enmge_options['grouptypetitle'];
$enmge_grouptypeptitle = $enmge_options['grouptypeptitle'];
$enmge_locationtitle = $enmge_options['locationtitle'];
$enmge_locationptitle = $enmge_options['locationptitle'];
$enmge_topictitle = $enmge_options['topictitle'];
$enmge_emailname = $enmge_options['emailname'];
$enmge_emailaddress = $enmge_options['emailaddress'];
if ( isset($enmge_options['offsite']) ) {
	$enmge_offsite = $enmge_options['offsite'];
} else {
	$enmge_offsite = "Offsite";
}
if ( isset($enmge_options['childcare']) ) {
	$enmge_childcare = stripslashes($enmge_options['childcare']);
} else {
	$enmge_childcare = "Childcare Available?";
}
if ( isset($enmge_options['offsitelabel']) ) {
	$enmge_offsitelabel = $enmge_options['offsitelabel'];
} else {
	$enmge_offsitelabel = 1;
}
if ( isset($enmge_options['showstart']) ) {
	$enmge_showstart = $enmge_options['showstart'];
} else {
	$enmge_showstart = 1;
}
if ( isset($enmge_options['searchbuttonlabel']) ) {
	$enmge_searchbuttonlabel = $enmge_options['searchbuttonlabel'];
} else {
	$enmge_searchbuttonlabel = "Available " . $enmge_groupptitle;
}
if ( isset($enmge_options['contactbuttonlabel']) ) {
	$enmge_contactbuttonlabel = $enmge_options['contactbuttonlabel'];
} else {
	$enmge_contactbuttonlabel = $enmge_grouptitle . " Leader";
}

// ***** Get Labels

if ( !defined('enmge_FIND_PAGE') ) { // Find current page for building URLs
	function enmge_find_page() {
		define('enmge_FIND_PAGE', 'yes');
		$enmge_get_url = parse_url( strtok( get_permalink(), '&' ) );
		if ( !isset($enmge_get_url['query']) ) {
			return strtok( get_permalink(), '&' ) . "?enmge=1";
		} else {
			return strtok( get_permalink(), '&' );
		}
	}
}

$enmge_thispage = enmge_find_page();


if ( isset($_GET['enmge_f']) || ($_POST && isset($_POST['enmge_sf']) && isset($_POST['enmge_f'])) ) { // Are they filtering the group list?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_f = strip_tags($_POST['enmge_f']);
	} else {
		$enmge_f = strip_tags($_GET['enmge_f']);
	}
	if ( $enmge_lo == 1 ) {
		$enmge_sortoptions = "&enmge_f=1&enmge_lof=1";
		$enmge_mapoptions = "&enmge_f=1&enmge_lof=1";
		$enmge_ajaxoptions = null;
	} else {
		$enmge_sortoptions = "&enmge_f=1";
		$enmge_mapoptions = "&enmge_f=1";
		$enmge_ajaxoptions = null;
	}
} elseif ( $enmge_lo == 1 ) {
	$enmge_f = 1;
	$enmge_sortoptions = "&enmge_f=1&enmge_lof=1";
	$enmge_mapoptions = "&enmge_f=1&enmge_lof=1";
	$enmge_ajaxoptions = null;
} else {
	$enmge_f = 0;
	$enmge_sortoptions = null;
	$enmge_mapoptions = null;
	$enmge_ajaxoptions = null;
}

if ( isset($_GET['enmge_gtid']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_grouptype'] != 0) ) { // Are they viewing groups by group type?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_gt = strip_tags($_POST['enmge_grouptype']);
	} else {
		$enmge_gt = strip_tags($_GET['enmge_gtid']);
	}
	$enmge_sortoptions .= "&enmge_gtid=" . $enmge_gt;
	$enmge_mapoptions .= "&enmge_gtid=" . $enmge_gt;
} elseif ( $enmge_lo == 1 && $enmge_fgtid != 0 ) {
	$enmge_gt = $enmge_fgtid;
	$enmge_sortoptions .= "&enmge_gtid=" . $enmge_gt;
	$enmge_mapoptions .= "&enmge_gtid=" . $enmge_gt;
} else {
	$enmge_gt = 0;
}

if ( isset($_GET['enmge_tid']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_topic'] != 0) ) { // Are they viewing groups by topic?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_t = strip_tags($_POST['enmge_topic']);
	} else {
		$enmge_t = strip_tags($_GET['enmge_tid']);
	}
	$enmge_sortoptions .= "&enmge_tid=" . $enmge_t;
	$enmge_mapoptions .= "&enmge_tid=" . $enmge_t;
} elseif ( $enmge_lo == 1 && $enmge_ftid != 0 ) {
	$enmge_t = $enmge_ftid;
	$enmge_sortoptions .= "&enmge_tid=" . $enmge_t;
	$enmge_mapoptions .= "&enmge_tid=" . $enmge_t;
} else {
	$enmge_t = 0;
}

if ( isset($_GET['enmge_m']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_meeting'] != 2) ) { // Are they viewing groups by onsite/offsite?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_m = strip_tags($_POST['enmge_meeting']);
	} else {
		$enmge_m = strip_tags($_GET['enmge_m']);
	}
	$enmge_sortoptions .= "&enmge_m=" . $enmge_m;
	$enmge_mapoptions .= "&enmge_m=" . $enmge_m;
} elseif ( $enmge_lo == 1 && $enmge_fm != 2 ) {
	$enmge_m = $enmge_fm;
	$enmge_sortoptions .= "&enmge_m=" . $enmge_m;
	$enmge_mapoptions .= "&enmge_m=" . $enmge_m;
}  else {
	$enmge_m = 2;
}

/* if ( isset($_GET['enmge_m']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_meeting'] != 0) ) { // Are they viewing groups by onsite/offsite?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		if ( strip_tags($_POST['enmge_m']) == 1 ) {
			$enmge_m = 1;
		} else {
			$enmge_m = 0;
		}
		$enmge_m = strip_tags($_POST['enmge_m']);
	} else {
		$enmge_m = strip_tags($_GET['enmge_m']);
	}
	$enmge_sortoptions .= "&enmge_m=" . $enmge_m;
	$enmge_mapoptions .= "&enmge_m=" . $enmge_m;
} elseif ( $enmge_lo == 1 && $enmge_fm != 0 ) {
	if ( $enmge_fm == 1 ) {
		$enmge_m = 1;
	} else {
		$enmge_m = 0;
	}
	$enmge_sortoptions .= "&enmge_m=" . $enmge_m;
	$enmge_mapoptions .= "&enmge_m=" . $enmge_m;
}  else {
	$enmge_m = 2;
} */

//CHANGE?
if ( isset($_GET['enmge_day']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_day'] != 0) ) { // Are they viewing groups by day?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_d = strip_tags($_POST['enmge_day']);
	} else {
		$enmge_d = strip_tags($_GET['enmge_day']);
	}
	$enmge_sortoptions .= "&enmge_day=" . $enmge_d;
	$enmge_mapoptions .= "&enmge_day=" . $enmge_d;
} elseif ( $enmge_lo == 1 && $enmge_fd != 0 && (!isset($_GET['enmge_lof']) && !isset($_POST['enmge_lof'])) ) {
	$enmge_d = $enmge_fd;
	$enmge_sortoptions .= "&enmge_day=" . $enmge_d;
	$enmge_mapoptions .= "&enmge_day=" . $enmge_d;
}  else {
	$enmge_d = 0;
}

if ( isset($_GET['enmge_st']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_st'] != 24) ) { // Did they specify a start time?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_ust = strip_tags($_POST['enmge_st']);
		$enmge_st = $enmge_ust . ":00:00";
	} else {
		$enmge_ust = strip_tags($_GET['enmge_st']);
		$enmge_st = $enmge_ust . ":00:00";
	}
	$enmge_sortoptions .= "&enmge_st=" . $enmge_ust;
	$enmge_mapoptions .= "&enmge_st=" . $enmge_ust;
} elseif ( $enmge_lo == 1 && $enmge_fst != 0 ) {
	$enmge_ust = $enmge_fst;
	$enmge_st = $enmge_ust . ":00:00";
	$enmge_sortoptions .= "&enmge_st=" . $enmge_st;
	$enmge_mapoptions .= "&enmge_st=" . $enmge_st;
}  else {
	$enmge_st = 24;
}

if ( isset($_GET['enmge_et']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_et'] != 24) ) { // Did they specify an end time?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_uet = strip_tags($_POST['enmge_et']);
		$enmge_et = $enmge_uet . ":00:00";
	} else {
		$enmge_uet = strip_tags($_GET['enmge_et']);
		$enmge_et = $enmge_uet . ":00:00";
	}
	$enmge_sortoptions .= "&enmge_et=" . $enmge_uet;
	$enmge_mapoptions .= "&enmge_et=" . $enmge_uet;
} elseif ( $enmge_lo == 1 && $enmge_fet != 0 ) {
	$enmge_uet = $enmge_fet;
	$enmge_et = $enmge_uet . ":00:00";
	$enmge_sortoptions .= "&enmge_et=" . $enmge_et;
	$enmge_mapoptions .= "&enmge_et=" . $enmge_et;
} else {
	$enmge_et = 24;
}

if ( isset($_GET['enmge_sa']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_sa'] != 101) ) { // Did they specify a start age?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_sa = strip_tags($_POST['enmge_sa']);
	} else {
		$enmge_sa = strip_tags($_GET['enmge_sa']);
	}
	$enmge_sortoptions .= "&enmge_sa=" . $enmge_sa;
	$enmge_mapoptions .= "&enmge_sa=" . $enmge_sa;
} elseif ( $enmge_lo == 1 && $enmge_fsa != 0 ) {
	$enmge_sa = $enmge_fsa;
	$enmge_sortoptions .= "&enmge_sa=" . $enmge_sa;
	$enmge_mapoptions .= "&enmge_sa=" . $enmge_sa;
} else {
	$enmge_sa = 101;
}

if ( isset($_GET['enmge_ea']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_ea'] != 101) ) { // Did they specify an end age?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_ea = strip_tags($_POST['enmge_ea']);
	} else {
		$enmge_ea = strip_tags($_GET['enmge_ea']);
	}
	$enmge_sortoptions .= "&enmge_ea=" . $enmge_ea;
	$enmge_mapoptions .= "&enmge_ea=" . $enmge_ea;
} elseif ( $enmge_lo == 1 && $enmge_fea != 0 ) {
	$enmge_ea = $enmge_fea;
	$enmge_sortoptions .= "&enmge_ea=" . $enmge_ea;
	$enmge_mapoptions .= "&enmge_ea=" . $enmge_ea;
} else {
	$enmge_ea = 101;
}

if ( isset($_GET['enmge_zip']) || ($_POST && isset($_POST['enmge_sf']) && isset($_POST['enmge_zip'])) ) { // ZIP through parameter or form (even blank)
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_z = strip_tags($_POST['enmge_zip']);
	} else {
		$enmge_z = strip_tags($_GET['enmge_zip']);
	}

	if ( $enmge_z != null ) {
		$enmge_sortoptions .= "&enmge_zip=" . $enmge_z;
		$enmge_mapoptions .= "&enmge_zip=" . $enmge_z;

		$enmge_g_addr_str = $enmge_z;
		$enmge_g_url = "http://maps.google.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false";

		$enmgech = curl_init();
		curl_setopt($enmgech, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($enmgech, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($enmgech, CURLOPT_URL,$enmge_g_url);
		$enmge_g_jsonData=curl_exec($enmgech);
		curl_close($enmgech);

		$enmge_g_data = json_decode($enmge_g_jsonData);

		if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ) {
			$enmge_maplat = $enmge_options['maplat'];
			$enmge_maplong = $enmge_options['maplong'];
		} else {
			$enmge_maplat = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		}

		if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ) {
		} else {
			$enmge_maplong = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		}
	} else {
		$enmge_z = 0;
		$enmge_maplat = $enmge_options['maplat'];
		$enmge_maplong = $enmge_options['maplong'];
	}

} elseif ( $enmge_lo == 1 && $enmge_fz != 0 ) { // ZIP through options
	$enmge_z = $enmge_fz;
	$enmge_sortoptions .= "&enmge_zip=" . $enmge_z;
	$enmge_mapoptions .= "&enmge_zip=" . $enmge_z;

	$enmge_g_addr_str = $enmge_z;
	$enmge_g_url = "http://maps.google.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false";

	$enmgech = curl_init();
	curl_setopt($enmgech, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($enmgech, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($enmgech, CURLOPT_URL,$enmge_g_url);
	$enmge_g_jsonData=curl_exec($enmgech);
	curl_close($enmgech);

	$enmge_g_data = json_decode($enmge_g_jsonData);

	if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ) {
		$enmge_maplat = $enmge_options['maplat'];
		$enmge_maplong = $enmge_options['maplong'];
	} else {
		$enmge_maplat = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	}

	if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ) {
	} else {
		$enmge_maplong = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	}
} elseif ( isset($_GET['enmge_cz']) || ($enmge_lo == 1 && $enmge_fcz != 0) ) { // Centered zoom through options
	$enmge_z = 0;
	if ( isset($_GET['enmge_cz']) ) {
		$enmge_g_addr_str = strip_tags($_GET['enmge_cz']);
	} else {
		$enmge_g_addr_str = $enmge_fcz;
	}

	$enmge_sortoptions .= "&enmge_cz=" . $enmge_g_addr_str;
	$enmge_mapoptions .= "&enmge_cz=" . $enmge_g_addr_str;

	$enmge_g_url = "http://maps.google.com/maps/api/geocode/json?address=$enmge_g_addr_str&sensor=false";

	$enmgech = curl_init();
	curl_setopt($enmgech, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($enmgech, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($enmgech, CURLOPT_URL,$enmge_g_url);
	$enmge_g_jsonData=curl_exec($enmgech);
	curl_close($enmgech);

	$enmge_g_data = json_decode($enmge_g_jsonData);

	if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ) {
		$enmge_maplat = $enmge_options['maplat'];
		$enmge_maplong = $enmge_options['maplong'];
	} else {
		$enmge_maplat = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	}

	if ( empty($enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ) {
	} else {
		$enmge_maplong = $enmge_g_data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	}
} else { // Nothing specified, use default coordinates from settings
	$enmge_z = 0;
	$enmge_maplat = $enmge_options['maplat'];
	$enmge_maplong = $enmge_options['maplong'];
}

if ( isset($_GET['enmge_lid']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_location'] != 0) ) { // Are they viewing groups by location?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_l = strip_tags($_POST['enmge_location']);
	} else {
		$enmge_l = strip_tags($_GET['enmge_lid']);
	}
	$enmge_sortoptions .= "&enmge_lid=" . $enmge_l;
	$enmge_mapoptions .= "&enmge_lid=" . $enmge_l;
	if ( $enmge_z == 0 ) {
		$enmge_findthelatlocationsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d";
		$enmge_findthelatlocation = $wpdb->prepare( $enmge_findthelatlocationsql, $enmge_l );
		$enmge_latloc = $wpdb->get_row( $enmge_findthelatlocation, OBJECT );
		$enmge_maplat = $enmge_latloc->location_lat;
		$enmge_maplong = $enmge_latloc->location_long;
	}
} elseif ( $enmge_lo == 1 && $enmge_flid != 0 ) {
	$enmge_l = $enmge_flid;
	$enmge_sortoptions .= "&enmge_lid=" . $enmge_l;
	$enmge_mapoptions .= "&enmge_lid=" . $enmge_l;
	if ( $enmge_z == 0 ) {
		$enmge_findthelatlocationsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d";
		$enmge_findthelatlocation = $wpdb->prepare( $enmge_findthelatlocationsql, $enmge_l );
		$enmge_latloc = $wpdb->get_row( $enmge_findthelatlocation, OBJECT );
		$enmge_maplat = $enmge_latloc->location_lat;
		$enmge_maplong = $enmge_latloc->location_long;
	}
}  else {
	$enmge_l = 0;
}

/*if ( isset($_GET['enmge_v']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_v'] != 0) ) { // Do they want it on a map?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_v = strip_tags($_POST['enmge_v']);
	} else {
		$enmge_v = strip_tags($_GET['enmge_v']);
	}
	$enmge_sortoptions .= "&enmge_v=1";
	$enmge_ajaxoptions .= "&enmge_v=1";
} elseif ( $enmge_lo == 1 && $enmge_fv != 0 ) {
	$enmge_v = $enmge_fv;
	$enmge_sortoptions .= "&enmge_v=" . $enmge_v;
	$enmge_ajaxoptions .= "&enmge_v=1";
} else {
	$enmge_v = 0;
}*/

if ( isset($_GET['enmge_zl']) )  { // map zoom level
	$enmge_zl = strip_tags($_GET['enmge_zl']);
	$enmge_sortoptions .= "&enmge_zl=" . $enmge_zl;
	$enmge_zoom = $enmge_zl;
} elseif ( $enmge_lo == 1 && $enmge_fzl != 0 ) {
	$enmge_zl = $enmge_fzl;
	$enmge_ajaxoptions .= "&enmge_zl=" . $enmge_zl;
	$enmge_zoom = $enmge_zl;
} else {
	$enmge_zl = 0;
	$enmge_zoom = $enmge_options['zoom'];
}

if ( isset($_GET['enmge_vo']) )  { // View toggle
	$enmge_vo = strip_tags($_GET['enmge_vo']);
	$enmge_sortoptions .= "&enmge_vo=" . $enmge_vo;
} elseif ( $enmge_lo == 1 && $enmge_fvo != 1 ) {
	$enmge_vo = $enmge_fvo;
	$enmge_ajaxoptions .= "&enmge_vo=" . $enmge_vo;
} else {
	$enmge_vo = 1;
}

if ( isset($_GET['enmge_cgl']) )  { // Contact Leader
	$enmge_cgl = strip_tags($_GET['enmge_cgl']);
	$enmge_sortoptions .= "&enmge_cgl=" . $enmge_cgl;
} elseif ( $enmge_lo == 1 && $enmge_fcl != 1 ) {
	$enmge_cgl = $enmge_fcl;
	$enmge_ajaxoptions .= "&enmge_cgl=" . $enmge_cgl;
} else {
	$enmge_cgl = 1;
}

if ( isset($_GET['enmge_gl']) )  { // Group List from Single
	$enmge_gl = strip_tags($_GET['enmge_gl']);
	$enmge_sortoptions .= "&enmge_gl=" . $enmge_gl;
} elseif ( $enmge_lo == 1 && $enmge_fgl != 1 ) {
	$enmge_gl = $enmge_fgl;
	$enmge_ajaxoptions .= "&enmge_gl=" . $enmge_gl;
} else {
	$enmge_gl = 1;
}

if ( isset($_GET['enmge_fo']) )  { // search toggle
	$enmge_fo = strip_tags($_GET['enmge_fo']);
	$enmge_sortoptions .= "&enmge_fo=2";
} elseif ( $enmge_lo == 1 && $enmge_ffo != 0 ) {
	$enmge_fo = $enmge_ffo;
	$enmge_ajaxoptions .= "&enmge_fo=" . $enmge_fo;
} else {
	$enmge_fo = 0;
}

if ( isset($_GET['enmge_sm']) )  { // show individual maps
	$enmge_sm = strip_tags($_GET['enmge_sm']);
	$enmge_sortoptions .= "&enmge_sm=0";
} elseif ( $enmge_lo == 1 && $enmge_fsm != 1 ) {
	$enmge_sm = $enmge_fsm;
	$enmge_ajaxoptions .= "&enmge_sm=" . $enmge_sm;
} else {
	$enmge_sm = 1;
}

if ( isset($_GET['enmge_pag']) )  { // number of groups per page
	$enmge_pag = strip_tags($_GET['enmge_pag']);
	$enmge_sortoptions .= "&enmge_pag=0";
} elseif ( $enmge_lo == 1 && $enmge_fpag != 0 ) {
	$enmge_pag = $enmge_fpag;
	$enmge_ajaxoptions .= "&enmge_pag=" . $enmge_pag;
} else {
	$enmge_pag = 0;
}

if ( isset($_GET['enmge_sort']) )  { // sort order for group lists
	$enmge_sort = strip_tags($_GET['enmge_sort']);
	$enmge_sortoptions .= "&enmge_sort=" . $enmge_sort;
} elseif ( $enmge_lo == 1 && $enmge_fsort != 0 ) {
	$enmge_sort = $enmge_fsort;
	$enmge_ajaxoptions .= "&enmge_sort=" . $enmge_sort;
} else {
	$enmge_sort = 0;
}

if ( isset($_GET['enmge_gstart']) )  { // limit search by start date
	$enmge_gstart = strip_tags($_GET['enmge_gstart']);
	$enmge_sortoptions .= "&enmge_gstart=1";
} elseif ( $enmge_lo == 1 && $enmge_fstart != 0 ) {
	$enmge_gstart = $enmge_fstart;
	$enmge_ajaxoptions .= "&enmge_gstart=1";
} else {
	$enmge_gstart = 0;
}

if ( isset($_GET['enmge_status']) )  { // group status
	$enmge_status = strip_tags($_GET['enmge_status']);
	$enmge_sortoptions .= "&enmge_status=" . $enmge_status;
} elseif ( $enmge_lo == 1 && $enmge_fstatus != 'n' ) {
	$enmge_status = $enmge_fstatus;
	$enmge_ajaxoptions .= "&enmge_status=" . $enmge_status;
} else {
	$enmge_status = 'n';
}

if ( isset($_GET['enmge_xgt']) )  { // limit group type search
	$enmge_xgt = strip_tags($_GET['enmge_xgt']);
	$enmge_sortoptions .= "&enmge_xgt=1";
} elseif ( $enmge_lo == 1 && $enmge_fxgt != 0 ) {
	$enmge_xgt = $enmge_fxgt;
	$enmge_ajaxoptions .= "&enmge_xgt=" . $enmge_xgt;
} else {
	$enmge_xgt = 0;
}

if ( isset($_GET['enmge_xt']) )  { // limit topic search
	$enmge_xt = strip_tags($_GET['enmge_xt']);
	$enmge_sortoptions .= "&enmge_xt=1";
} elseif ( $enmge_lo == 1 && $enmge_fxt != 0 ) {
	$enmge_xt = $enmge_fxt;
	$enmge_ajaxoptions .= "&enmge_xt=" . $enmge_xt;
} else {
	$enmge_xt = 0;
}

if ( isset($_GET['enmge_xl']) )  { // limit location search
	$enmge_xl = strip_tags($_GET['enmge_xl']);
	$enmge_sortoptions .= "&enmge_xl=1";
} elseif ( $enmge_lo == 1 && $enmge_fxl != 0 ) {
	$enmge_xl = $enmge_fxl;
	$enmge_ajaxoptions .= "&enmge_xl=" . $enmge_xl;
} else {
	$enmge_xl = 0;
}

if ( isset($_GET['enmge_xm']) )  { // limit meeting search
	$enmge_xm = strip_tags($_GET['enmge_xm']);
	$enmge_sortoptions .= "&enmge_xm=1";
} elseif ( $enmge_lo == 1 && $enmge_fxm != 0 ) {
	$enmge_xm = $enmge_fxm;
	$enmge_ajaxoptions .= "&enmge_xm=" . $enmge_xm;
} else {
	$enmge_xm = 0;
}

if ( isset($_GET['enmge_xd']) )  { // limit day search
	$enmge_xd = strip_tags($_GET['enmge_xd']);
	$enmge_sortoptions .= "&enmge_xd=1";
} elseif ( $enmge_lo == 1 && $enmge_fxd != 0 ) {
	$enmge_xd = $enmge_fxd;
	$enmge_ajaxoptions .= "&enmge_xd=" . $enmge_xd;
} else {
	$enmge_xd = 0;
}

if ( isset($_GET['enmge_xst']) )  { // limit time search
	$enmge_xst = strip_tags($_GET['enmge_xst']);
	$enmge_sortoptions .= "&enmge_xst=1";
} elseif ( $enmge_lo == 1 && $enmge_fxst != 0 ) {
	$enmge_xst = $enmge_fxst;
	$enmge_ajaxoptions .= "&enmge_xst=" . $enmge_xst;
} else {
	$enmge_xst = 0;
}

if ( isset($_GET['enmge_xsa']) )  { // limit age search
	$enmge_xsa = strip_tags($_GET['enmge_xsa']);
	$enmge_sortoptions .= "&enmge_xsa=1";
} elseif ( $enmge_lo == 1 && $enmge_fxsa != 0 ) {
	$enmge_xsa = $enmge_fxsa;
	$enmge_ajaxoptions .= "&enmge_xsa=" . $enmge_xsa;
} else {
	$enmge_xsa = 0;
}

if ( isset($_GET['enmge_xz']) )  { // limit zip search
	$enmge_xz = strip_tags($_GET['enmge_xz']);
	$enmge_sortoptions .= "&enmge_xz=1";
} elseif ( $enmge_lo == 1 && $enmge_fxz != 0 ) {
	$enmge_xz = $enmge_fxz;
	$enmge_ajaxoptions .= "&enmge_xz=" . $enmge_xz;
} else {
	$enmge_xz = 0;
}


if ( isset($_GET['enmge_p']) ) { // if results are paginated
	$enmge_pageoptions = "&enmge_p=" . strip_tags($_GET['enmge_p']) . "&enmge_c=" . strip_tags($_GET['enmge_c']);
} else {
	$enmge_pageoptions = null;
}

if ( isset($_GET['enmge_v']) || ($_POST && isset($_POST['enmge_sf']) && $_POST['enmge_v'] != 0) ) { // Do they want it on a map?
	if ( $_POST && isset($_POST['enmge_sf']) ) {
		$enmge_v = strip_tags($_POST['enmge_v']);
	} else {
		$enmge_v = strip_tags($_GET['enmge_v']);
	}
	$enmge_sortoptions .= "&enmge_v=1";
} elseif ( $enmge_lo == 1 && $enmge_fv != 0 ) {
	$enmge_v = $enmge_fv;
	$enmge_sortoptions .= "&enmge_v=" . $enmge_v;
} else {
	$enmge_v = 0;
}


$enmge_scl = 0;

	if ( isset($_GET['enmge_cl']) && isset($_GET['enmge_gid']) ) { /* Contact Group Leader */
		if ( $_POST ) {
			if ( isset($_GET['enmge_gid']) && is_numeric($_GET['enmge_gid']) ) {
				$enmge_gid = strip_tags($_GET['enmge_gid']);
			}

			$enmge_findthemessagesql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_id = %d";
			$enmge_findthemessage = $wpdb->prepare( $enmge_findthemessagesql, $enmge_gid );
			$enmge_single = $wpdb->get_row( $enmge_findthemessage, OBJECT );
			$enmge_singlecount = $wpdb->num_rows;

			$enmge_errors = array();

			if ( phpversion() >= '5.3' ) {
				include 'nospam/spamprocessing.php';
			}


			if (empty($_POST['contact_name'])) { //validate presence of name
				$enmge_errors[] = 'A name is required to contact a ' . stripslashes($enmge_grouptitle) . ' leader.';
			} else {
				$enmge_name = strip_tags($_POST['contact_name']);
			};

			if (empty($_POST['contact_email'])) { //validate presence and format of email
				$enmge_errors[] = 'An email address is required to contact a ' . stripslashes($enmge_grouptitle) . ' leader.';
			} else {
				if (preg_match('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$^', $_POST['contact_email'])) {
					$enmge_email = $_POST['contact_email'];
				} else {
					$enmge_errors[] = 'You must provide a valid email address.';
				};
			};

			$enmge_phone = strip_tags($_POST['contact_phone']);

			if (empty($_POST['contact_message']) || strlen($_POST['contact_message']) < 10) { //validate presence and length of message
				$enmge_errors[] = 'Please enter a message for the ' . stripslashes($enmge_grouptitle) . ' leader.';
			} else {
				if (preg_match('/(href=)/', $_POST['contact_message']) || preg_match('/(HREF=)/', $_POST['contact_message'])) { // Simple check for spam hyperlinks
					$enmge_errors[] = 'Sorry, no HTML is allowed in your message.';
				} else {
					$enmge_message = strip_tags($_POST['contact_message']);
				}
			};

			$enmge_mc = md5(uniqid(rand(), true));
			$enmge_date = date("Y-m-d H:i:s", time());
			$enmge_status = "Initial Followup Needed";
			$enmge_group_title = $enmge_single->group_title;
			$enmge_group_leader = $enmge_single->group_leaders;
			$enmge_group_leader_email = $enmge_single->group_leaders_email;

			if (empty($enmge_errors)) {
				$enmge_newcontact = array(
					'contact_name' => $enmge_name,
					'contact_email' => $enmge_email,
					'contact_phone' => $enmge_phone,
					'contact_message' => $enmge_message,
					'contact_modcode' => $enmge_mc,
					'contact_date' => $enmge_date,
					'contact_status' => $enmge_status,
					'contact_group_id' => $enmge_gid,
					'contact_group_title' => $enmge_group_title,
					'contact_group_leader' => $enmge_group_leader,
					'contact_group_leader_email' => $enmge_group_leader_email
				);
				$wpdb->insert( $wpdb->prefix . "ge_contacts", $enmge_newcontact );
				$enmge_scl = 1;

				// Display Group Info

				if ( !empty($enmge_single) ) {
					// Get All Files
					$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_id ORDER BY sort_id ASC";
					$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_single->group_id );
					$enmge_files = $wpdb->get_results( $enmge_fsql );

					// Get All Leaders
					$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id";
					$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_single->group_id );
					$enmge_groupleaders = $wpdb->get_results( $enmge_lesql );
				}

				if ( (!empty($enmge_single)) && ($enmge_single->group_onsite > 0) ) { // Find info for map link
					// Get Campus Info
					$enmge_preparredlsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d";
					$enmge_lsql = $wpdb->prepare( $enmge_preparredlsql, $enmge_single->group_onsite );
					$enmge_location = $wpdb->get_row( $enmge_lsql, OBJECT );
					$enmge_locationcount = $wpdb->num_rows;

					if ( $enmge_locationcount == 1) {
						$enmge_g_address1 = str_replace(' ', '+', trim($enmge_location->location_address1)).",";
						$enmge_g_address2 = str_replace(' ', '+', trim($enmge_location->location_address2)).",";
						$enmge_g_city    = '+'.str_replace(' ', '+', trim($enmge_location->location_city)).",";
					    $enmge_g_state   = '+'.str_replace(' ', '+', trim($enmge_location->location_state));
					    $enmge_g_zip     = isset($enmge_location->location_zip)? '+'.str_replace(' ', '', trim($enmge_location->location_zip)) : '';

						$enmge_searchaddress = $enmge_g_address1.$enmge_g_address2.$enmge_g_city.$enmge_g_state.$enmge_g_zip;
					} else {
						$enmge_searchaddress = null;
					}

				} elseif ( (!empty($enmge_single)) && ($enmge_single->group_onsite == 0) ) {
					$enmge_g_address1 = str_replace(' ', '+', trim($enmge_single->group_address1)).",";
					$enmge_g_address2 = str_replace(' ', '+', trim($enmge_single->group_address2)).",";
					$enmge_g_city    = '+'.str_replace(' ', '+', trim($enmge_single->group_city)).",";
				    $enmge_g_state   = '+'.str_replace(' ', '+', trim($enmge_single->group_state));
				    $enmge_g_zip     = isset($enmge_single->group_zip)? '+'.str_replace(' ', '', trim($enmge_single->group_zip)) : '';

					$enmge_searchaddress = $enmge_g_address1.$enmge_g_address2.$enmge_g_city.$enmge_g_state.$enmge_g_zip;
				}

				// Get All Group Topic Matches
				$enmge_gtpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_topics" . " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (topic_id) WHERE group_id = %d GROUP BY topic_id ORDER BY topic_name ASC";
				$enmge_gtsql = $wpdb->prepare( $enmge_gtpreparredsql, $enmge_single->group_id );
				$enmge_grouptopics = $wpdb->get_results( $enmge_gtsql );

				// Get All Group Group Type Matches
				$enmge_ggtpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_type_id) WHERE group_id = %d GROUP BY group_type_id ORDER BY group_type_title ASC";
				$enmge_ggtsql = $wpdb->prepare( $enmge_ggtpreparredsql, $enmge_single->group_id );
				$enmge_groupgrouptypes = $wpdb->get_results( $enmge_ggtsql );
				$enmge_gtcount = $wpdb->num_rows;

				// Get All Group Location Matches
				$enmge_preparredgglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE group_id = %d";
				$enmge_gglmsql = $wpdb->prepare( $enmge_preparredgglmsql, $enmge_single->group_id );
				$enmge_gglm = $wpdb->get_results( $enmge_gglmsql );

				include('emailleader.php');
				include('emailadmins.php');
			}
		}
	} elseif ( isset($_GET['enmge_gid']) || ( (isset($enmge_fgid) && $enmge_fgid > 0) && !isset($_GET['enmge_o']) && !isset($_POST['enmge_o']) ) ) { /* SINGLE GROUP */

		if ( isset($_GET['enmge_gid']) && is_numeric($_GET['enmge_gid']) ) {
			$enmge_gid = strip_tags($_GET['enmge_gid']);
		} else {
			$enmge_gid = $enmge_fgid;
		}

		$enmge_findthemessagesql = "SELECT * FROM " . $wpdb->prefix . "ge_groups" . " WHERE group_id = %d";
		$enmge_findthemessage = $wpdb->prepare( $enmge_findthemessagesql, $enmge_gid );
		$enmge_single = $wpdb->get_row( $enmge_findthemessage, OBJECT );
		$enmge_singlecount = $wpdb->num_rows;

		if ( !empty($enmge_single) ) {
			// Get All Files
			$enmge_preparredfsql = "SELECT * FROM " . $wpdb->prefix . "ge_files" . " LEFT JOIN " . $wpdb->prefix . "ge_group_file_matches" . " USING (file_id) WHERE group_id = %d GROUP BY file_id ORDER BY sort_id ASC";
			$enmge_fsql = $wpdb->prepare( $enmge_preparredfsql, $enmge_single->group_id );
			$enmge_files = $wpdb->get_results( $enmge_fsql );

			// Get All Leaders
			$enmge_preparredlesql = "SELECT * FROM " . $wpdb->prefix . "ge_leaders" . " LEFT JOIN " . $wpdb->prefix . "ge_group_leader_matches" . " USING (leader_id) WHERE group_id = %d GROUP BY leader_id";
			$enmge_lesql = $wpdb->prepare( $enmge_preparredlesql, $enmge_single->group_id );
			$enmge_groupleaders = $wpdb->get_results( $enmge_lesql );
		}

		if ( (!empty($enmge_single)) && ($enmge_single->group_onsite > 0) ) { // Find info for map link
			// Get Campus Info
			$enmge_preparredlsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " WHERE location_id = %d";
			$enmge_lsql = $wpdb->prepare( $enmge_preparredlsql, $enmge_single->group_onsite );
			$enmge_location = $wpdb->get_row( $enmge_lsql, OBJECT );
			$enmge_locationcount = $wpdb->num_rows;

			if ( $enmge_locationcount == 1) {
				$enmge_g_address1 = str_replace(' ', '+', trim($enmge_location->location_address1)).",";
				$enmge_g_address2 = str_replace(' ', '+', trim($enmge_location->location_address2)).",";
				$enmge_g_city    = '+'.str_replace(' ', '+', trim($enmge_location->location_city)).",";
			    $enmge_g_state   = '+'.str_replace(' ', '+', trim($enmge_location->location_state));
			    $enmge_g_zip     = isset($enmge_location->location_zip)? '+'.str_replace(' ', '', trim($enmge_location->location_zip)) : '';

				$enmge_searchaddress = $enmge_g_address1.$enmge_g_address2.$enmge_g_city.$enmge_g_state.$enmge_g_zip;
			} else {
				$enmge_searchaddress = null;
			}

		} elseif ( (!empty($enmge_single)) && ($enmge_single->group_onsite == 0) ) {
			$enmge_g_address1 = str_replace(' ', '+', trim($enmge_single->group_address1)).",";
			$enmge_g_address2 = str_replace(' ', '+', trim($enmge_single->group_address2)).",";
			$enmge_g_city    = '+'.str_replace(' ', '+', trim($enmge_single->group_city)).",";
		    $enmge_g_state   = '+'.str_replace(' ', '+', trim($enmge_single->group_state));
		    $enmge_g_zip     = isset($enmge_single->group_zip)? '+'.str_replace(' ', '', trim($enmge_single->group_zip)) : '';

			$enmge_searchaddress = $enmge_g_address1.$enmge_g_address2.$enmge_g_city.$enmge_g_state.$enmge_g_zip;
		}

		// Get All Group Topic Matches
		$enmge_gtpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_topics" . " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (topic_id) WHERE group_id = %d GROUP BY topic_id ORDER BY topic_name ASC";
		$enmge_gtsql = $wpdb->prepare( $enmge_gtpreparredsql, $enmge_single->group_id );
		$enmge_grouptopics = $wpdb->get_results( $enmge_gtsql );

		// Get All Group Group Type Matches
		$enmge_ggtpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_type_id) WHERE group_id = %d GROUP BY group_type_id ORDER BY group_type_title ASC";
		$enmge_ggtsql = $wpdb->prepare( $enmge_ggtpreparredsql, $enmge_single->group_id );
		$enmge_groupgrouptypes = $wpdb->get_results( $enmge_ggtsql );
		$enmge_gtcount = $wpdb->num_rows;

		// Get All Group Location Matches
		$enmge_preparredgglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches" . " WHERE group_id = %d";
		$enmge_gglmsql = $wpdb->prepare( $enmge_preparredgglmsql, $enmge_single->group_id );
		$enmge_gglm = $wpdb->get_results( $enmge_gglmsql );

	} else { /* SORTABLE LIST OF GROUPS */

		include ('paginated_groups.php'); // Get all groups

		// Get All Topics
		//$enmge_preparredtsql = "SELECT topic_id, topic_name FROM " . $wpdb->prefix . "ge_topics" . " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_privacy = 1 AND group_begins <= CURDATE() AND group_ends >= CURDATE() AND group_id IS NOT NULL GROUP BY topic_id ORDER BY topic_name ASC";
		$enmge_preparredtsql = "SELECT topic_id, topic_name FROM " . $wpdb->prefix . "ge_topics" . " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id)";
		if ( $enmge_xl == 1 && $enmge_l > 0 ) {
			$enmge_preparredtsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (group_id)";
		}
		if ( $enmge_xgt == 1 && $enmge_gt > 0 ) {
			$enmge_preparredtsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_id)";
		}
		$enmge_preparredtsql .= " WHERE group_privacy = 1";
		if ( $enmge_xl == 1 && $enmge_l > 0 ) {
			$enmge_preparredtsql .= " AND location_id = " . $enmge_l;
		}
		if ( $enmge_xgt == 1 && $enmge_gt > 0 ) {
			$enmge_preparredtsql .=  " AND group_type_id = " . $enmge_gt;
		}
		if ( $enmge_lo == 0 || ($enmge_gstart == 1 && $enmge_lo == 1) ) {
			$enmge_preparredtsql .= " AND (group_ends >= CURDATE() OR group_noend = 1) AND group_id IS NOT NULL GROUP BY topic_id ORDER BY topic_name ASC";
		} else {
			$enmge_preparredtsql .= " AND ((group_begins <= CURDATE() AND group_ends >= CURDATE()) OR (group_begins <= CURDATE() AND group_noend = 1)) AND group_id IS NOT NULL GROUP BY topic_id ORDER BY topic_name ASC";
		}
		$enmge_ts = $wpdb->get_results( $enmge_preparredtsql );

		// Get All Group Topic Matches
		$enmge_preparredgtmsql = "SELECT topic_id, group_id FROM " . $wpdb->prefix . "ge_group_topic_matches";
		$enmge_gtm = $wpdb->get_results( $enmge_preparredgtmsql );

		// Get All Locations
		//$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (location_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_privacy = 1 AND group_begins <= CURDATE() AND group_ends >= CURDATE() AND group_id IS NOT NULL GROUP BY location_id ORDER BY location_id DESC";
		$enmge_lpreparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_locations" . " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (location_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id)";
		if ( $enmge_xgt == 1 && $enmge_gt > 0 ) {
			$enmge_lpreparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_id)";
		}
		if ( $enmge_xt == 1 && $enmge_t > 0 ) {
			$enmge_lpreparredsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (group_id)";
		}
		$enmge_lpreparredsql .= " WHERE group_privacy = 1";
		if ( $enmge_xgt == 1 && $enmge_gt > 0 ) {
			$enmge_lpreparredsql .= " AND group_type_id = " . $enmge_gt;
		}
		if ( $enmge_xt == 1 && $enmge_t > 0 ) {
			$enmge_lpreparredsql .= " AND topic_id = " . $enmge_t;
		}
		if ( $enmge_lo == 0 || ($enmge_gstart == 1 && $enmge_lo == 1) ) {
		$enmge_lpreparredsql .= " AND (group_ends >= CURDATE() OR group_noend = 1) AND group_id IS NOT NULL GROUP BY location_id ORDER BY location_name ASC";
		} else {
		$enmge_lpreparredsql .= " AND ((group_begins <= CURDATE() AND group_ends >= CURDATE()) OR (group_begins <= CURDATE() AND group_noend = 1)) AND group_id IS NOT NULL GROUP BY location_id ORDER BY location_name ASC";
		}
		$enmge_locations = $wpdb->get_results( $enmge_lpreparredsql );

		// Get All Group Location Matches
		$enmge_preparredglmsql = "SELECT location_id, group_id FROM " . $wpdb->prefix . "ge_group_location_matches";
		$enmge_glm = $wpdb->get_results( $enmge_preparredglmsql );


		// Get All Group Types
		//$enmge_preparredgtsql = "SELECT group_type_id, group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_type_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id) WHERE group_privacy = 1 AND group_begins <= CURDATE() AND group_ends >= CURDATE() AND group_id IS NOT NULL GROUP BY group_type_id ORDER BY group_type_title ASC";
		$enmge_preparredgtsql = "SELECT group_type_id, group_type_title FROM " . $wpdb->prefix . "ge_group_types" . " LEFT JOIN " . $wpdb->prefix . "ge_group_group_type_matches" . " USING (group_type_id) LEFT JOIN " . $wpdb->prefix . "ge_groups" . " USING (group_id)";
		if ( $enmge_xl == 1 && $enmge_l > 0 ) {
			$enmge_preparredgtsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_location_matches" . " USING (group_id)";
		}
		if ( $enmge_xt == 1 && $enmge_t > 0 ) {
			$enmge_preparredgtsql .= " LEFT JOIN " . $wpdb->prefix . "ge_group_topic_matches" . " USING (group_id)";
		}
		$enmge_preparredgtsql .= " WHERE group_privacy = 1";
		if ( $enmge_xl == 1 && $enmge_l > 0 ) {
			$enmge_preparredgtsql .= " AND location_id = " . $enmge_l;
		}
		if ( $enmge_xt == 1 && $enmge_t > 0 ) {
			$enmge_preparredgtsql .= " AND topic_id = " . $enmge_t;
		}
		if ( $enmge_lo == 0 || ($enmge_gstart == 1 && $enmge_lo == 1) ) {
		$enmge_preparredgtsql .= " AND (group_ends >= CURDATE() OR group_noend = 1) AND group_id IS NOT NULL GROUP BY group_type_id ORDER BY group_type_title ASC";
		} else {
		$enmge_preparredgtsql .= " AND ((group_begins <= CURDATE() AND group_ends >= CURDATE()) OR (group_begins <= CURDATE() AND group_noend = 1)) AND group_id IS NOT NULL GROUP BY group_type_id ORDER BY group_type_title ASC";
		}
		$enmge_gts = $wpdb->get_results( $enmge_preparredgtsql );


	} /* END SINGLE GROUP */
	$enmge_randomval = rand();


?>
<div id="groupsengine">
	<?php if ( is_ssl() ) { ?>
		<script type="text/javascript" src="https://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
	<?php } else { ?>
		<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
	<?php } ?>
	<input type="hidden" name="enmge-random" value="<?php echo $enmge_randomval; ?>" class="enmge-random">
	<div class="enmge-loading-icon" style="display: none;">
		<p>Loading Content...</p>
	</div>
	<div class="enmge-copy-link-box" style="display: none;">
		<h4>Copy and share the link below:</h4>
		<p></p>
		<a href="#" class="enmge-copy-link-done">Okay, I'm Done</a>
	</div>
	<div class="enmge-content-container" id="enmge-top<?php echo $enmge_randomval; ?>">
		<?php if ( $enmge_scl == 0 && (isset($_GET['enmge_cl']) && isset($_GET['enmge_gid'])) ) { /* Contact Group Leader */ ?>
		<div class="ge-explore-bar">
			<h4 class="ge-explore-contact-back"><a href="<?php echo $enmge_thispage . '&amp;enmge_gid=' . $_GET['enmge_gid'] . $enmge_sortoptions . $enmge_pageoptions; ?>" class="enmge-ajax-contact-back" name="<?php echo '&amp;enmge_gid=' . $_GET['enmge_gid']; ?>">Back<span class="mobhide"> to <?php echo stripslashes($enmge_grouptitle); ?></span></a></h4>
		</div>
		<div class="ge-leader-contact">
			<h3>Contact <?php echo stripslashes($enmge_contactbuttonlabel); ?></h3>
			<div class="ge-instructions">
				<p><?php echo stripslashes($enmge_contactinstructions); ?></p>
			</div>
			<?php if (!empty($enmge_errors)) { ?>
			<div class="ge-error-message">
				<p>Please fix the following errors:</p>
				<ul>
					<?php foreach ($enmge_errors as $error) {
						echo "<li>$error</li>";
					}; ?>
				</ul>
			</div>
			<?php } ?>
			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="ge-contact-form enmge-ajax-contact-form">
				<table cellpadding="0" cellspacing="0" class="ge-leader-contact-form">
					<tr>
						<td class="ge-contact-label"><label for="contact_name">Your Name</label></td>
						<td class="ge-contact-input"><input name="contact_name" type="text" class="contact_name ge" tabindex="1" value="<?php if ($_POST && !empty($enmge_errors)) {echo $_POST['contact_name'];}; ?>" /></td>
					</tr>
					<tr>
						<td class="ge-contact-label"><label for="contact_email">Your Email</label></td>
						<td class="ge-contact-input"><input name="contact_email" type="text" class="contact_email ge" tabindex="2" value="<?php if ($_POST && !empty($enmge_errors)) {echo $_POST['contact_email'];}; ?>" /></td>
					</tr>
					<tr>
						<td class="ge-contact-label"><label for="contact_phone">Your Phone</label></td>
						<td class="ge-contact-input"><input name="contact_phone" type="text" class="contact_phone ge" tabindex="3" value="<?php if ($_POST && !empty($enmge_errors)) {echo $_POST['contact_phone'];}; ?>" /></td>
					</tr>
					<tr>
						<td class="ge-contact-label"><label for="contact_message">Message</label></td>
						<td class="ge-contact-input"><textarea class="contact_message" name="contact_message" tabindex="4"><?php if ($_POST && !empty($enmge_errors)) {echo $_POST['contact_message'];}; ?></textarea></td>
					</tr>
					<?php if ( phpversion() >= '5.3' ) { include 'nospam/spamcell.php'; } ?>
					<tr>
						<td class="ge-contact-label"></td>
						<td class="ge-contact-input"><input type="submit" value="Contact Leader" class="ge-leader-contact-submit" tabindex="5" /></td>
					</tr>
				</table>
			</form>
		</div>
		<?php } elseif ( isset($_GET['enmge_gid']) || ( (isset($enmge_fgid) && $enmge_fgid > 0) && !isset($_GET['enmge_o']) && !isset($_POST['enmge_o']) ) ) { /* SINGLE GROUP */ ?>
		<?php if ( $enmge_gl == 1 || $enmge_cgl == 1 ) { ?>
		<div class="ge-explore-bar">
			<?php if ( $enmge_gl == 1 ) { ?><h4 class="ge-explore-back"><a href="<?php echo $enmge_thispage . $enmge_sortoptions . $enmge_pageoptions . "&enmge_o=1"; ?>" class="enmge-first-ajax-back">Search<span class="mobhide"> <?php echo stripslashes($enmge_groupptitle); ?></span></a></h4><?php } ?>
			<?php if ( $enmge_cgl == 1 ) { ?><h4 class="ge-contact-leader"><a href="<?php echo $enmge_thispage . '&amp;enmge_cl=1&amp;enmge_gid=' . $enmge_single->group_id . $enmge_sortoptions . $enmge_pageoptions; ?>" class="enmge-ajax-contact" name="<?php echo '&amp;enmge_cl=1&amp;enmge_gid=' . $enmge_single->group_id; ?>">Contact <span class="mobhide"><?php echo stripslashes($enmge_contactbuttonlabel); ?></span></a></h4><?php } ?>
		</div>
		<?php } ?>
		<?php if ($enmge_sm != 0) { ?>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?<?php if ( $enmge_apikey != null) { ?>key=<?php echo $enmge_apikey; ?>&<?php } ?>sensor=false"></script>
	    <script type="text/javascript">
	    	function initialize() { // Initialize map and add options

	    		<?php if ( $enmge_pointer != null ) { ?>
				var gepointer = new google.maps.MarkerImage('<?php echo $enmge_pointer; ?>',
				    // second line defines the dimensions of the image
				    new google.maps.Size(48, 48),
				    // third line defines the origin of the custom icon
				    new google.maps.Point(0,0),
				    // and the last line defines the offset for the image
				    new google.maps.Point(24, 48)
				);
				<?php } ?>

	      		var myLatlng = new google.maps.LatLng(<?php echo $enmge_single->group_lat; ?>, <?php echo $enmge_single->group_long; ?>);

	        	var mapOptions = { // centered location and zoom
	          		center: myLatlng,
	          		zoom: 15
	        	};

	        	var map = new google.maps.Map(document.getElementById("ge-map-canvas"), mapOptions);

	        	var marker = new google.maps.Marker({ // marker
			    	position: myLatlng,
			    	map: map,
			    	title:"<?php echo $enmge_single->group_title; ?>"<?php if ( $enmge_pointer != null ) { ?>,icon: gepointer<?php } ?>
				});

	        	var contentString = '<div class="enmge-individual-marker">'+// popup window above marker
					      '<p class="title"><?php if ( $enmge_single->group_onsite > 0 ) { echo $enmge_single->group_location_label . " - " . $enmge_single->group_campus_name; } else { echo $enmge_single->group_location_label; } ?></p>'+
					      '<p class="address"><?php if ( isset($enmge_location) && $enmge_location->location_address1 != null ) { echo $enmge_location->location_address1; } if ( isset($enmge_location) && $enmge_location->location_address1 != null && $enmge_location->location_address2 != null ) { echo "<br />"; } if ( isset($enmge_location) && $enmge_location->location_address2 != null ) { echo $enmge_location->location_address2; } if ( isset($enmge_location) && $enmge_location->location_address1 != null || isset($enmge_location) && $enmge_location->location_address2 != null ) { echo "<br />"; } if ( isset($enmge_location) && $enmge_location->location_city != null ) { echo $enmge_location->location_city; } if ( isset($enmge_location) && $enmge_location->location_city != null && $enmge_location->location_state != null ) { echo ", "; } if ( isset($enmge_location) && $enmge_location->location_state != null ) { echo $enmge_location->location_state; } ?><?php if ( $enmge_single->group_location_privacy == 1 ) { ?><?php if ( $enmge_single->group_address1 != null ) { echo $enmge_single->group_address1; } if ( $enmge_single->group_address1 != null && $enmge_single->group_address2 != null ) { echo "<br />"; } if ( $enmge_single->group_address2 != null ) { echo $enmge_single->group_address2; } if ( $enmge_single->group_address1 != null || $enmge_single->group_address2 != null ) { echo "<br />"; } if ( $enmge_single->group_city != null ) { echo $enmge_single->group_city; } if ( $enmge_single->group_city != null && $enmge_single->group_state != null ) { echo ", "; } if ( $enmge_single->group_state != null ) { echo $enmge_single->group_state; } ?><?php } ?></p>'+
					      '<p class="links"><?php if ( $enmge_single->group_location_privacy == 1 ) { ?><a href="https://www.google.com/maps/place/<?php echo $enmge_searchaddress; ?>" target="_blank">Directions</a><?php } ?><?php if ( $enmge_single->group_location_privacy == 1 && $enmge_cgl == 1 ) { ?> | <?php } ?><?php if ( $enmge_cgl == 1 ) { ?><a href="<?php echo $enmge_thispage . "&amp;enmge_cl=1&amp;enmge_gid=" . $enmge_single->group_id . $enmge_sortoptions . $enmge_pageoptions; ?>" class="enmge-ajax-pointer-contact" name="<?php echo "&amp;enmge_cl=1&amp;enmge_gid=" . $enmge_single->group_id; ?>">Contact Leader</a><?php } ?></p>'+
					      '</div>';

				var infowindow = new google.maps.InfoWindow({
		     	    content: contentString,
				    maxWidth: 200
				});

				google.maps.event.addListener(marker, 'click', function() {
    				infowindow.open(map,marker);
  				});
	      	}

	      	google.maps.event.addDomListener(window, 'load', initialize); // Load map
	    </script>
	    <?php } ?>
	    <div class="ge-single-group">
	    	<h3><?php echo stripslashes($enmge_single->group_title); ?></h3>
	    	<?php if ( $enmge_scl == 1 ) { ?>
	    	<div class="ge-success-message">
				<p><?php echo stripslashes($enmge_contactsuccess); ?></p>
			</div>
			<?php }; ?>
	    	<div class="ge-group-description"><?php if ( $enmge_single->group_photo != null ) { ?><div class="ge-imagecontainer"><img src="<?php echo $enmge_single->group_photo; ?>" class="ge-image" alt="Photo of <?php echo stripslashes($enmge_single->group_title); ?>" /></div><?php } ?><p><?php echo stripslashes($enmge_single->group_description); ?></p></div>
	    	<div class="ge-social">
	    		<?php $enmge_sharelink = urlencode($enmge_thispage . '&enmge_gid=' . $enmge_gid); ?>
	    		<ul>
	    			<li class="ge-facebook"><a href="http://www.facebook.com/sharer.php?u=<?php echo $enmge_sharelink; ?>">Facebook</a></li>
	    			<li class="ge-twitter"><a href="http://twitter.com/home/?status=%22<?php echo stripslashes($enmge_single->group_title); ?>%22%20on%20<?php echo urlencode(bloginfo('name')); ?>:%20<?php echo $enmge_sharelink; ?>">Twitter</a></li>
	    			<li class="ge-share"><a href="<?php echo rawurldecode($enmge_sharelink); ?>" class="enmge-copy-link">Copy Link</a></li>
	    			<li class="ge-email"><a href="mailto:TypeEmailHere@address.com?subject=Check%20out%20%22<?php echo stripslashes($enmge_single->group_title); ?>%22%20on%20<?php echo urlencode(bloginfo('name')); ?>&body=Check%20out%20%22<?php echo stripslashes($enmge_single->group_title); ?>%22%20on%20<?php echo urlencode(bloginfo('name')); ?>%20at%20the%20link%20below:%0A%0A<?php echo $enmge_sharelink; ?>">Email Link</a></li>
	    		</ul>
	    	</div>
	    	<table class="ge-detailstable" cellpadding="0" cellspacing="0">
		    	<tr class="ge-top">
		    		<td class="ge-group-details leader left"><span class="ge-label">Led by:</span> <?php if ( $enmge_cgl == 1 ) { ?><a href="<?php echo $enmge_thispage . '&amp;enmge_cl=1&amp;enmge_gid=' . $enmge_single->group_id . $enmge_sortoptions . $enmge_pageoptions; ?>" class="enmge-ajax-details-contact" name="<?php echo '&amp;enmge_cl=1&amp;enmge_gid=' . $enmge_single->group_id; ?>"><?php $enmge_le_comma = 1; foreach ( $enmge_groupleaders as $enmge_l) { if ( $enmge_le_comma == 1 ) { echo stripslashes($enmge_l->leader_name); $enmge_le_comma = $enmge_le_comma+1; } else { echo ', ' . stripslashes($enmge_l->leader_name); $enmge_le_comma = $enmge_le_comma+1; } } ?></a><?php } else { ?><?php $enmge_le_comma = 1; foreach ( $enmge_groupleaders as $enmge_l) { if ( $enmge_le_comma == 1 ) { echo stripslashes($enmge_l->leader_name); $enmge_le_comma = $enmge_le_comma+1; } else { echo ', ' . stripslashes($enmge_l->leader_name); $enmge_le_comma = $enmge_le_comma+1; } } } ?></td>
		    		<td class="ge-group-details ages"><span class="ge-label">For Ages:</span> <?php echo $enmge_single->group_startage; ?><?php if ( $enmge_single->group_endage == 100 ) { echo "+"; } else { echo "-" . $enmge_single->group_endage; } ?></td>
		    		<td class="ge-group-details meets right"><span class="ge-label">Meets:</span> <?php echo $enmge_single->group_frequency; ?> <?php if ( $enmge_single->group_day == 1 ) { echo "Sunday";  } ?><?php if ( $enmge_single->group_day == 2 ) { echo "Monday";  } ?><?php if ( $enmge_single->group_day == 3 ) { echo "Tuesday";  } ?><?php if ( $enmge_single->group_day == 4 ) { echo "Wednesday";  } ?><?php if ( $enmge_single->group_day == 5 ) { echo "Thursday";  } ?><?php if ( $enmge_single->group_day == 6 ) { echo "Friday";  } ?><?php if ( $enmge_single->group_day == 7 ) { echo "Saturday";  } ?> from <?php echo date('g:ia', strtotime($enmge_single->group_starttime)); ?>-<?php echo date('g:ia', strtotime($enmge_single->group_endtime)); ?></td>
		    	</tr>
		    	<tr>
		    		<td class="ge-group-details childcare left"><span class="ge-label"><?php echo $enmge_childcare; ?></span> <?php if ( $enmge_single->group_childcare == 0 ) { echo "No"; } else { echo "Yes"; } ?> <?php if ( $enmge_single->group_childcare_details != null ) { echo "- " . stripslashes($enmge_single->group_childcare_details); } ?></td>
		    		<td class="ge-group-details topics"><span class="ge-label"><?php echo stripslashes($enmge_topictitle); ?>:</span> <?php $enmge_t_comma = 1; foreach ( $enmge_grouptopics as $enmge_gt ) { if ( $enmge_t_comma == 1 ) { echo stripslashes($enmge_gt->topic_name); $enmge_t_comma = $enmge_t_comma+1; } else { echo ', ' . stripslashes($enmge_gt->topic_name); $enmge_t_comma = $enmge_t_comma+1; }} ?></td>
		    		<td class="ge-group-details types right"><span class="ge-label"><?php echo stripslashes($enmge_grouptypetitle); ?>:</span> <?php $enmge_gt_comma = 1; foreach ( $enmge_groupgrouptypes as $enmge_ggt ) { if ( $enmge_gt_comma == 1 ) { echo stripslashes($enmge_ggt->group_type_title); $enmge_gt_comma = $enmge_gt_comma+1; } else { echo ', ' . stripslashes($enmge_ggt->group_type_title); $enmge_gt_comma = $enmge_gt_comma+1; }} ?></td>
		    	</tr>
		    	<tr class="ge-bottom">
		    		<td class="ge-group-details location left"><span class="ge-label">Location:</span> <?php if ( $enmge_single->group_onsite > 0 ) { echo stripslashes($enmge_single->group_location_label) . " - " . "<a href=\"https://www.google.com/maps/place/" . $enmge_searchaddress . "\" target=\"_blank\">" . stripslashes($enmge_single->group_campus_name) . "</a>"; } else { if ( $enmge_single->group_location_privacy == 1 ) { echo "<a href=\"https://www.google.com/maps/place/" . $enmge_searchaddress . "\" target=\"_blank\">" . stripslashes($enmge_single->group_location_label) . "</a>"; } else { echo stripslashes($enmge_single->group_location_label); } } ?></td>
		    		<?php if ($enmge_showstart == 1) { ?><td class="ge-group-details begins"><span class="ge-label">Begins:</span> <?php echo date('F j, Y', strtotime($enmge_single->group_begins)); ?></td><?php } ?>
		    		<td class="ge-group-details status right"><span class="ge-label">Status:</span> <?php if ( $enmge_single->group_status == 1 ) { echo "Open"; } elseif ( $enmge_single->group_status == 0 ) { echo "Closed"; } else { echo "Full"; } ?></td>
		    	</tr>
	    	</table>
			<?php if ( !empty($enmge_files) ) { ?><div class="ge-group-related"><p><span class="ge-label">Related:</span> <?php $enmge_f_comma = 1; foreach ( $enmge_files as $enmge_f) { if ( $enmge_f_comma == 1 ) { echo '<a href="' . $enmge_f->file_url . '">' . stripslashes($enmge_f->file_name) . '</a>'; $enmge_f_comma = $enmge_f_comma+1; } else { echo ' &nbsp;|&nbsp; <a href="' . $enmge_f->file_url . '">' . stripslashes($enmge_f->file_name) . '</a>'; $enmge_f_comma = $enmge_f_comma+1; } } ?></p></div><?php } ?>
	    	<?php if ($enmge_sm != 0) { ?><div id="ge-map-canvas" style=""></div><?php } ?>
	    </div>
		<?php } else { /* Listing of Groups With Search */ ?>
		<?php if ( $enmge_fo == 0 || $enmge_vo == 1 ) { ?>
		<div class="ge-explore-bar">
			<?php if ( $enmge_fo == 0 ) { ?><h4 class="ge-explore-toggle"><a href="#" class="ge-search-toggle enmge-show-filter">Search<span class="mobhide"> <?php echo stripslashes($enmge_searchbuttonlabel); ?></span></a></h4><?php } ?>
			<?php if ( $enmge_vo == 1 ) { ?><h4 class="ge-view-toggle"><?php if ( $enmge_v == 1 ) { ?><a href="<?php echo $enmge_thispage . $enmge_mapoptions . "&enmge_o=1"; ?>" class="ge-list-toggle enmge-ajax-view" name="<?php echo $enmge_ajaxoptions; ?>"><span class="mobhide">View as </span>List</a><?php } else { ?><a href="<?php echo $enmge_thispage . $enmge_sortoptions . "&enmge_v=1&enmge_o=1"; ?>" class="ge-map-toggle enmge-ajax-view" name="<?php echo $enmge_ajaxoptions . "&enmge_v=1"; ?>"><span class="mobhide">View as </span>Map</a><?php } ?></h4><?php } ?>
		</div>
		<?php } ?>
		<?php if ( $enmge_fo == 0 ) { ?>
		<div class="ge-explore-options" style="display: none;">
		<form action="<?php echo $enmge_thispage; ?>" method="post" class="enmge-ajax-form">
    <input type="hidden" class="enmge_location" name="enmge_grouptype" value="0" />
      <?php /*
			<div class="ge-option-container">
				<span class="ge-filter-label"><?php echo stripslashes($enmge_grouptypetitle); ?>:</span>
				<select class="enmge_grouptype" name="enmge_grouptype" tabindex="1">
					<?php if ( $enmge_xgt == 1 ) { ?>
						<?php if ( $enmge_gt > 0 ) { ?>
							<?php foreach ($enmge_gts as $gt) {  ?>
							<?php if ( $gt->group_type_id == $enmge_gt ) { ?><option value="<?php echo $gt->group_type_id; ?>" <?php if ( $gt->group_type_id == $enmge_gt ) { echo 'selected="selected"'; }; ?>><?php echo stripslashes($gt->group_type_title); ?></option><?php } ?>
							<?php } ?>
						<?php } else { ?>
						<option value="0">All</option>
						<?php } ?>
					<?php } else { ?>
						<option value="0">All</option>
						<?php foreach ($enmge_gts as $gt) {  ?>
						<option value="<?php echo $gt->group_type_id; ?>" <?php if ( $gt->group_type_id == $enmge_gt ) { echo 'selected="selected"'; }; ?>><?php echo stripslashes($gt->group_type_title); ?></option>
						<?php } ?>
					<?php } ?>
				</select>
      </div>
      */?>
			<div class="ge-option-container">
				<span class="ge-filter-label"><?php echo stripslashes($enmge_topictitle); ?>:</span>
				<select class="enmge_topic" name="enmge_topic" tabindex="2">
					<?php if ( $enmge_xt == 1 ) { ?>
						<?php if ( $enmge_t > 0 ) { ?>
							<?php foreach ($enmge_ts as $t) {  ?>
							<?php if ( $t->topic_id == $enmge_t ) { ?><option value="<?php echo $t->topic_id; ?>" <?php if ( $t->topic_id == $enmge_t ) { echo 'selected="selected"'; }; ?>><?php echo stripslashes($t->topic_name); ?></option><?php } ?>
							<?php } ?>
						<?php } else { ?>
						<option value="0">All</option>
						<?php } ?>
					<?php } else { ?>
						<option value="0">All</option>
						<?php foreach ($enmge_ts as $t) {  ?>
						<option value="<?php echo $t->topic_id; ?>" <?php if ( $t->topic_id == $enmge_t ) { echo 'selected="selected"'; }; ?>><?php echo stripslashes($t->topic_name); ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
      <input type="hidden" class="enmge_location" name="enmge_location" value="0" />
      <?php /*
			<div class="ge-option-container">
				<span class="ge-filter-label"><?php echo stripslashes($enmge_locationtitle); ?>:</span>
				<select class="enmge_location" name="enmge_location" tabindex="3">
					<?php if ( $enmge_xl == 1 ) { ?>
						<?php if ( $enmge_l > 0 ) { ?>
							<?php foreach ($enmge_locations as $l) {  ?>
							<?php if ( $l->location_id == $enmge_l ) { ?><option value="<?php echo $l->location_id; ?>" <?php if ( $l->location_id == $enmge_l ) { echo 'selected="selected"'; }; ?>><?php echo stripslashes($l->location_name); ?></option><?php } ?>
							<?php } ?>
						<?php } else { ?>
						<option value="0">All</option>
						<?php } ?>
					<?php } else { ?>
						<option value="0">All</option>
						<?php foreach ($enmge_locations as $l) {  ?>
						<option value="<?php echo $l->location_id; ?>" <?php if ( $l->location_id == $enmge_l ) { echo 'selected="selected"'; }; ?>><?php echo stripslashes($l->location_name); ?></option>
						<?php } ?>
					<?php } ?>
				</select>
      </div>
      */?>
      <input type="hidden" class="enmge_meeting" name="enmge_meeting" value="2" />
      <?php /*
			<div class="ge-option-container">
				<span class="ge-filter-label">Meeting:</span>
				<select class="enmge_meeting" name="enmge_meeting" tabindex="4">
					<?php if ( $enmge_xm == 1 ) { ?>
						<?php if ( $enmge_m == 2 ) { ?><option value="2">Onsite and Offsite</option><?php } ?>
						<?php if ( $enmge_m == 1 ) { ?><option value="1">Onsite Only</option><?php } ?>
						<?php if ( $enmge_m == 0 ) { ?><option value="0">Offsite Only</option><?php } ?>
					<?php } else { ?>
						<option value="2" <?php if ( $enmge_m == 2 ) { echo 'selected="selected"'; }; ?>>Onsite and Offsite</option>
						<option value="1" <?php if ( $enmge_m == 1 ) { echo 'selected="selected"'; }; ?>>Onsite Only</option>
						<option value="0" <?php if ( $enmge_m == 0 ) { echo 'selected="selected"'; }; ?>>Offsite Only</option>
					<?php } ?>
				</select>
      </div>
      */?>
			<div class="ge-option-container">
				<span class="ge-filter-label">Day:</span>
				<select class="enmge_day" name="enmge_day" tabindex="5">
					<?php if ( $enmge_xd == 1 ) { ?>
						<?php if ( $enmge_d > 0 ) { ?>
							<?php if ( $enmge_d == 1 ) { ?><option value="1">Sunday</option><?php } ?>
							<?php if ( $enmge_d == 2 ) { ?><option value="2">Monday</option><?php } ?>
							<?php if ( $enmge_d == 3 ) { ?><option value="3">Tuesday</option><?php } ?>
							<?php if ( $enmge_d == 4 ) { ?><option value="4">Wednesday</option><?php } ?>
							<?php if ( $enmge_d == 5 ) { ?><option value="5">Thursday</option><?php } ?>
							<?php if ( $enmge_d == 6 ) { ?><option value="6">Friday</option><?php } ?>
							<?php if ( $enmge_d == 7 ) { ?><option value="7">Saturday</option><?php } ?>
						<?php } else { ?>
						<option value="0">Any</option>
						<?php } ?>
					<?php } else { ?>
						<option value="0">Any</option>
						<option value="1" <?php if ( $enmge_d == 1 ) { echo 'selected="selected"'; }; ?>>Sunday</option>
						<option value="2" <?php if ( $enmge_d == 2 ) { echo 'selected="selected"'; }; ?>>Monday</option>
						<option value="3" <?php if ( $enmge_d == 3 ) { echo 'selected="selected"'; }; ?>>Tuesday</option>
						<option value="4" <?php if ( $enmge_d == 4 ) { echo 'selected="selected"'; }; ?>>Wednesday</option>
						<option value="5" <?php if ( $enmge_d == 5 ) { echo 'selected="selected"'; }; ?>>Thursday</option>
						<option value="6" <?php if ( $enmge_d == 6 ) { echo 'selected="selected"'; }; ?>>Friday</option>
						<option value="7" <?php if ( $enmge_d == 7 ) { echo 'selected="selected"'; }; ?>>Saturday</option>
					<?php } ?>
				</select>
			</div>
			<div class="ge-option-container">
				<span class="ge-filter-label">Time:</span>
				<?php if ( $enmge_xst == 1 ) { ?>
					<?php if ( $enmge_st != 24 ) { ?>
						<select name="enmge_st" class="enmge_st time" tabindex="6">
							<?php if ( $enmge_st == 0 ) { ?><option value="00">12:00am</option><?php } ?>
							<?php if ( $enmge_st == 1 ) { ?><option value="01">1:00am</option><?php } ?>
							<?php if ( $enmge_st == 2 ) { ?><option value="02">2:00am</option><?php } ?>
							<?php if ( $enmge_st == 3 ) { ?><option value="03">3:00am</option><?php } ?>
							<?php if ( $enmge_st == 4 ) { ?><option value="04">4:00am</option><?php } ?>
							<?php if ( $enmge_st == 5 ) { ?><option value="05">5:00am</option><?php } ?>
							<?php if ( $enmge_st == 6 ) { ?><option value="06">6:00am</option><?php } ?>
							<?php if ( $enmge_st == 7 ) { ?><option value="07">7:00am</option><?php } ?>
							<?php if ( $enmge_st == 8 ) { ?><option value="08">8:00am</option><?php } ?>
							<?php if ( $enmge_st == 9 ) { ?><option value="09">9:00am</option><?php } ?>
							<?php if ( $enmge_st == 10 ) { ?><option value="10">10:00am</option><?php } ?>
							<?php if ( $enmge_st == 11 ) { ?><option value="11">11:00am</option><?php } ?>
							<?php if ( $enmge_st == 12 ) { ?><option value="12">12:00pm</option><?php } ?>
							<?php if ( $enmge_st == 13 ) { ?><option value="13">1:00pm</option><?php } ?>
							<?php if ( $enmge_st == 14 ) { ?><option value="14">2:00pm</option><?php } ?>
							<?php if ( $enmge_st == 15 ) { ?><option value="15">3:00pm</option><?php } ?>
							<?php if ( $enmge_st == 16 ) { ?><option value="16">4:00pm</option><?php } ?>
							<?php if ( $enmge_st == 17 ) { ?><option value="17">5:00pm</option><?php } ?>
							<?php if ( $enmge_st == 18 ) { ?><option value="18">6:00pm</option><?php } ?>
							<?php if ( $enmge_st == 19 ) { ?><option value="19">7:00pm</option><?php } ?>
							<?php if ( $enmge_st == 20 ) { ?><option value="20">8:00pm</option><?php } ?>
							<?php if ( $enmge_st == 21 ) { ?><option value="21">9:00pm</option><?php } ?>
							<?php if ( $enmge_st == 22 ) { ?><option value="22">10:00pm</option><?php } ?>
							<?php if ( $enmge_st == 23 ) { ?><option value="23">11:00pm</option><?php } ?>
						</select> -
					<?php } else { ?>
					<select name="enmge_st" class="enmge_st time" tabindex="6">
						<option value="24">Any</option>
					</select> -
					<?php } ?>
					<?php if ( $enmge_et != 24 ) { ?>
						<select name="enmge_et" class="enmge_et time" tabindex="7">
							<?php if ( $enmge_et == 0 ) { ?><option value="00">12:00am</option><?php } ?>
							<?php if ( $enmge_et == 1 ) { ?><option value="01">1:00am</option><?php } ?>
							<?php if ( $enmge_et == 2 ) { ?><option value="02">2:00am</option><?php } ?>
							<?php if ( $enmge_et == 3 ) { ?><option value="03">3:00am</option><?php } ?>
							<?php if ( $enmge_et == 4 ) { ?><option value="04">4:00am</option><?php } ?>
							<?php if ( $enmge_et == 5 ) { ?><option value="05">5:00am</option><?php } ?>
							<?php if ( $enmge_et == 6 ) { ?><option value="06">6:00am</option><?php } ?>
							<?php if ( $enmge_et == 7 ) { ?><option value="07">7:00am</option><?php } ?>
							<?php if ( $enmge_et == 8 ) { ?><option value="08">8:00am</option><?php } ?>
							<?php if ( $enmge_et == 9 ) { ?><option value="09">9:00am</option><?php } ?>
							<?php if ( $enmge_et == 10 ) { ?><option value="10">10:00am</option><?php } ?>
							<?php if ( $enmge_et == 11 ) { ?><option value="11">11:00am</option><?php } ?>
							<?php if ( $enmge_et == 12 ) { ?><option value="12">12:00pm</option><?php } ?>
							<?php if ( $enmge_et == 13 ) { ?><option value="13">1:00pm</option><?php } ?>
							<?php if ( $enmge_et == 14 ) { ?><option value="14">2:00pm</option><?php } ?>
							<?php if ( $enmge_et == 15 ) { ?><option value="15">3:00pm</option><?php } ?>
							<?php if ( $enmge_et == 16 ) { ?><option value="16">4:00pm</option><?php } ?>
							<?php if ( $enmge_et == 17 ) { ?><option value="17">5:00pm</option><?php } ?>
							<?php if ( $enmge_et == 18 ) { ?><option value="18">6:00pm</option><?php } ?>
							<?php if ( $enmge_et == 19 ) { ?><option value="19">7:00pm</option><?php } ?>
							<?php if ( $enmge_et == 20 ) { ?><option value="20">8:00pm</option><?php } ?>
							<?php if ( $enmge_et == 21 ) { ?><option value="21">9:00pm</option><?php } ?>
							<?php if ( $enmge_et == 22 ) { ?><option value="22">10:00pm</option><?php } ?>
							<?php if ( $enmge_et == 23 ) { ?><option value="23">11:00pm</option><?php } ?>
						</select>
					<?php } else { ?>
					<select name="enmge_et" class="enmge_et time" tabindex="7">
						<option value="24">Any</option>
					</select>
					<?php } ?>
				<?php } else { ?>
				<select name="enmge_st" class="enmge_st time" tabindex="6">
					<option value="24" <?php if ( $enmge_st == 24 ) { echo 'selected="selected"'; }; ?>>Any</option>
					<option value="00" <?php if ( $enmge_st == 0 ) { echo 'selected="selected"'; }; ?>>12:00am</option>
					<option value="01" <?php if ( $enmge_st == 1 ) { echo 'selected="selected"'; }; ?>>1:00am</option>
					<option value="02" <?php if ( $enmge_st == 2 ) { echo 'selected="selected"'; }; ?>>2:00am</option>
					<option value="03" <?php if ( $enmge_st == 3 ) { echo 'selected="selected"'; }; ?>>3:00am</option>
					<option value="04" <?php if ( $enmge_st == 4 ) { echo 'selected="selected"'; }; ?>>4:00am</option>
					<option value="05" <?php if ( $enmge_st == 5 ) { echo 'selected="selected"'; }; ?>>5:00am</option>
					<option value="06" <?php if ( $enmge_st == 6 ) { echo 'selected="selected"'; }; ?>>6:00am</option>
					<option value="07" <?php if ( $enmge_st == 7 ) { echo 'selected="selected"'; }; ?>>7:00am</option>
					<option value="08" <?php if ( $enmge_st == 8 ) { echo 'selected="selected"'; }; ?>>8:00am</option>
					<option value="09" <?php if ( $enmge_st == 9 ) { echo 'selected="selected"'; }; ?>>9:00am</option>
					<option value="10" <?php if ( $enmge_st == 10 ) { echo 'selected="selected"'; }; ?>>10:00am</option>
					<option value="11" <?php if ( $enmge_st == 11 ) { echo 'selected="selected"'; }; ?>>11:00am</option>
					<option value="12" <?php if ( $enmge_st == 12 ) { echo 'selected="selected"'; }; ?>>12:00pm</option>
					<option value="13" <?php if ( $enmge_st == 13 ) { echo 'selected="selected"'; }; ?>>1:00pm</option>
					<option value="14" <?php if ( $enmge_st == 14 ) { echo 'selected="selected"'; }; ?>>2:00pm</option>
					<option value="15" <?php if ( $enmge_st == 15 ) { echo 'selected="selected"'; }; ?>>3:00pm</option>
					<option value="16" <?php if ( $enmge_st == 16 ) { echo 'selected="selected"'; }; ?>>4:00pm</option>
					<option value="17" <?php if ( $enmge_st == 17 ) { echo 'selected="selected"'; }; ?>>5:00pm</option>
					<option value="18" <?php if ( $enmge_st == 18 ) { echo 'selected="selected"'; }; ?>>6:00pm</option>
					<option value="19" <?php if ( $enmge_st == 19 ) { echo 'selected="selected"'; }; ?>>7:00pm</option>
					<option value="20" <?php if ( $enmge_st == 20 ) { echo 'selected="selected"'; }; ?>>8:00pm</option>
					<option value="21" <?php if ( $enmge_st == 21 ) { echo 'selected="selected"'; }; ?>>9:00pm</option>
					<option value="22" <?php if ( $enmge_st == 22 ) { echo 'selected="selected"'; }; ?>>10:00pm</option>
					<option value="23" <?php if ( $enmge_st == 23 ) { echo 'selected="selected"'; }; ?>>11:00pm</option>
				</select> -
				<select name="enmge_et" class="enmge_et time" tabindex="7">
					<option value="24" <?php if ( $enmge_et == 24 ) { echo 'selected="selected"'; }; ?>>Any</option>
					<option value="00" <?php if ( $enmge_et == 0 ) { echo 'selected="selected"'; }; ?>>12:00am</option>
					<option value="01" <?php if ( $enmge_et == 1 ) { echo 'selected="selected"'; }; ?>>1:00am</option>
					<option value="02" <?php if ( $enmge_et == 2 ) { echo 'selected="selected"'; }; ?>>2:00am</option>
					<option value="03" <?php if ( $enmge_et == 3 ) { echo 'selected="selected"'; }; ?>>3:00am</option>
					<option value="04" <?php if ( $enmge_et == 4 ) { echo 'selected="selected"'; }; ?>>4:00am</option>
					<option value="05" <?php if ( $enmge_et == 5 ) { echo 'selected="selected"'; }; ?>>5:00am</option>
					<option value="06" <?php if ( $enmge_et == 6 ) { echo 'selected="selected"'; }; ?>>6:00am</option>
					<option value="07" <?php if ( $enmge_et == 7 ) { echo 'selected="selected"'; }; ?>>7:00am</option>
					<option value="08" <?php if ( $enmge_et == 8 ) { echo 'selected="selected"'; }; ?>>8:00am</option>
					<option value="09" <?php if ( $enmge_et == 9 ) { echo 'selected="selected"'; }; ?>>9:00am</option>
					<option value="10" <?php if ( $enmge_et == 10 ) { echo 'selected="selected"'; }; ?>>10:00am</option>
					<option value="11" <?php if ( $enmge_et == 11 ) { echo 'selected="selected"'; }; ?>>11:00am</option>
					<option value="12" <?php if ( $enmge_et == 12 ) { echo 'selected="selected"'; }; ?>>12:00pm</option>
					<option value="13" <?php if ( $enmge_et == 13 ) { echo 'selected="selected"'; }; ?>>1:00pm</option>
					<option value="14" <?php if ( $enmge_et == 14 ) { echo 'selected="selected"'; }; ?>>2:00pm</option>
					<option value="15" <?php if ( $enmge_et == 15 ) { echo 'selected="selected"'; }; ?>>3:00pm</option>
					<option value="16" <?php if ( $enmge_et == 16 ) { echo 'selected="selected"'; }; ?>>4:00pm</option>
					<option value="17" <?php if ( $enmge_et == 17 ) { echo 'selected="selected"'; }; ?>>5:00pm</option>
					<option value="18" <?php if ( $enmge_et == 18 ) { echo 'selected="selected"'; }; ?>>6:00pm</option>
					<option value="19" <?php if ( $enmge_et == 19 ) { echo 'selected="selected"'; }; ?>>7:00pm</option>
					<option value="20" <?php if ( $enmge_et == 20 ) { echo 'selected="selected"'; }; ?>>8:00pm</option>
					<option value="21" <?php if ( $enmge_et == 21 ) { echo 'selected="selected"'; }; ?>>9:00pm</option>
					<option value="22" <?php if ( $enmge_et == 22 ) { echo 'selected="selected"'; }; ?>>10:00pm</option>
					<option value="23" <?php if ( $enmge_et == 23 ) { echo 'selected="selected"'; }; ?>>11:00pm</option>
				</select>
				<?php } ?>
			</div>
      <input type="hidden" class="enmge_sa" name="enmge_sa" value="101" />
      <input type="hidden" class="enmge_ea" name="enmge_ea" value="101" />
      <?php /*
			<div class="ge-option-container">
				<span class="ge-filter-label">Age Range:</span>
				<?php if ( $enmge_xsa == 1 ) { ?>
					<?php if ( $enmge_sa != 101 ) { ?>
					<select name="enmge_sa" class="enmge_sa time" tabindex="8">
						<option value="<?php echo $enmge_sa; ?>"><?php echo $enmge_sa; ?></option>
					</select> -
					<?php } else { ?>
					<select name="enmge_sa" class="enmge_sa time" tabindex="8">
						<option value="101">Any</option>
					</select> -
					<?php } ?>
					<?php if ( $enmge_ea != 101 ) { ?>
					<select name="enmge_ea" class="enmge_ea time" tabindex="9">
						<option value="<?php echo $enmge_ea; ?>"><?php echo $enmge_ea; ?></option>
					</select>
					<?php } else { ?>
					<select name="enmge_ea" class="enmge_ea time" tabindex="9">
						<option value="101">Any</option>
					</select>
					<?php } ?>
				<?php } else { ?>
				<select name="enmge_sa" class="enmge_sa time" tabindex="8">
					<option value="101" <?php if ($enmge_sa == 101) { echo 'selected="selected"';} ?>>Any</option>
					<option value="0" <?php if ($enmge_sa == 0) { echo 'selected="selected"';} ?>>0</option>
					<option value="1" <?php if ($enmge_sa == 1) { echo 'selected="selected"';} ?>>1</option>
					<option value="2" <?php if ($enmge_sa == 2) { echo 'selected="selected"';} ?>>2</option>
					<option value="3" <?php if ($enmge_sa == 3) { echo 'selected="selected"';} ?>>3</option>
					<option value="4" <?php if ($enmge_sa == 4) { echo 'selected="selected"';} ?>>4</option>
					<option value="5" <?php if ($enmge_sa == 5) { echo 'selected="selected"';} ?>>5</option>
					<option value="6" <?php if ($enmge_sa == 6) { echo 'selected="selected"';} ?>>6</option>
					<option value="7" <?php if ($enmge_sa == 7) { echo 'selected="selected"';} ?>>7</option>
					<option value="8" <?php if ($enmge_sa == 8) { echo 'selected="selected"';} ?>>8</option>
					<option value="9" <?php if ($enmge_sa == 9) { echo 'selected="selected"';} ?>>9</option>
					<option value="10" <?php if ($enmge_sa == 10) { echo 'selected="selected"';} ?>>10</option>
					<option value="11" <?php if ($enmge_sa == 11) { echo 'selected="selected"';} ?>>11</option>
					<option value="12" <?php if ($enmge_sa == 12) { echo 'selected="selected"';} ?>>12</option>
					<option value="13" <?php if ($enmge_sa == 13) { echo 'selected="selected"';} ?>>13</option>
					<option value="14" <?php if ($enmge_sa == 14) { echo 'selected="selected"';} ?>>14</option>
					<option value="15" <?php if ($enmge_sa == 15) { echo 'selected="selected"';} ?>>15</option>
					<option value="16" <?php if ($enmge_sa == 16) { echo 'selected="selected"';} ?>>16</option>
					<option value="17" <?php if ($enmge_sa == 17) { echo 'selected="selected"';} ?>>17</option>
					<option value="18" <?php if ($enmge_sa == 18) { echo 'selected="selected"';} ?>>18</option>
					<option value="19" <?php if ($enmge_sa == 19) { echo 'selected="selected"';} ?>>19</option>
					<option value="20" <?php if ($enmge_sa == 20) { echo 'selected="selected"';} ?>>20</option>
					<option value="21" <?php if ($enmge_sa == 21) { echo 'selected="selected"';} ?>>21</option>
					<option value="22" <?php if ($enmge_sa == 22) { echo 'selected="selected"';} ?>>22</option>
					<option value="23" <?php if ($enmge_sa == 23) { echo 'selected="selected"';} ?>>23</option>
					<option value="24" <?php if ($enmge_sa == 24) { echo 'selected="selected"';} ?>>24</option>
					<option value="25" <?php if ($enmge_sa == 25) { echo 'selected="selected"';} ?>>25</option>
					<option value="26" <?php if ($enmge_sa == 26) { echo 'selected="selected"';} ?>>26</option>
					<option value="27" <?php if ($enmge_sa == 27) { echo 'selected="selected"';} ?>>27</option>
					<option value="28" <?php if ($enmge_sa == 28) { echo 'selected="selected"';} ?>>28</option>
					<option value="29" <?php if ($enmge_sa == 29) { echo 'selected="selected"';} ?>>29</option>
					<option value="30" <?php if ($enmge_sa == 30) { echo 'selected="selected"';} ?>>30</option>
					<option value="31" <?php if ($enmge_sa == 31) { echo 'selected="selected"';} ?>>31</option>
					<option value="32" <?php if ($enmge_sa == 32) { echo 'selected="selected"';} ?>>32</option>
					<option value="33" <?php if ($enmge_sa == 33) { echo 'selected="selected"';} ?>>33</option>
					<option value="34" <?php if ($enmge_sa == 34) { echo 'selected="selected"';} ?>>34</option>
					<option value="35" <?php if ($enmge_sa == 35) { echo 'selected="selected"';} ?>>35</option>
					<option value="36" <?php if ($enmge_sa == 36) { echo 'selected="selected"';} ?>>36</option>
					<option value="37" <?php if ($enmge_sa == 37) { echo 'selected="selected"';} ?>>37</option>
					<option value="38" <?php if ($enmge_sa == 38) { echo 'selected="selected"';} ?>>38</option>
					<option value="39" <?php if ($enmge_sa == 39) { echo 'selected="selected"';} ?>>39</option>
					<option value="40" <?php if ($enmge_sa == 40) { echo 'selected="selected"';} ?>>40</option>
					<option value="41" <?php if ($enmge_sa == 41) { echo 'selected="selected"';} ?>>41</option>
					<option value="42" <?php if ($enmge_sa == 42) { echo 'selected="selected"';} ?>>42</option>
					<option value="43" <?php if ($enmge_sa == 43) { echo 'selected="selected"';} ?>>43</option>
					<option value="44" <?php if ($enmge_sa == 44) { echo 'selected="selected"';} ?>>44</option>
					<option value="45" <?php if ($enmge_sa == 45) { echo 'selected="selected"';} ?>>45</option>
					<option value="46" <?php if ($enmge_sa == 46) { echo 'selected="selected"';} ?>>46</option>
					<option value="47" <?php if ($enmge_sa == 47) { echo 'selected="selected"';} ?>>47</option>
					<option value="48" <?php if ($enmge_sa == 48) { echo 'selected="selected"';} ?>>48</option>
					<option value="49" <?php if ($enmge_sa == 49) { echo 'selected="selected"';} ?>>49</option>
					<option value="50" <?php if ($enmge_sa == 50) { echo 'selected="selected"';} ?>>50</option>
					<option value="51" <?php if ($enmge_sa == 51) { echo 'selected="selected"';} ?>>51</option>
					<option value="52" <?php if ($enmge_sa == 52) { echo 'selected="selected"';} ?>>52</option>
					<option value="53" <?php if ($enmge_sa == 53) { echo 'selected="selected"';} ?>>53</option>
					<option value="54" <?php if ($enmge_sa == 54) { echo 'selected="selected"';} ?>>54</option>
					<option value="55" <?php if ($enmge_sa == 55) { echo 'selected="selected"';} ?>>55</option>
					<option value="56" <?php if ($enmge_sa == 56) { echo 'selected="selected"';} ?>>56</option>
					<option value="57" <?php if ($enmge_sa == 57) { echo 'selected="selected"';} ?>>57</option>
					<option value="58" <?php if ($enmge_sa == 58) { echo 'selected="selected"';} ?>>58</option>
					<option value="59" <?php if ($enmge_sa == 59) { echo 'selected="selected"';} ?>>59</option>
					<option value="60" <?php if ($enmge_sa == 60) { echo 'selected="selected"';} ?>>60</option>
					<option value="61" <?php if ($enmge_sa == 61) { echo 'selected="selected"';} ?>>61</option>
					<option value="62" <?php if ($enmge_sa == 62) { echo 'selected="selected"';} ?>>62</option>
					<option value="63" <?php if ($enmge_sa == 63) { echo 'selected="selected"';} ?>>63</option>
					<option value="64" <?php if ($enmge_sa == 64) { echo 'selected="selected"';} ?>>64</option>
					<option value="65" <?php if ($enmge_sa == 65) { echo 'selected="selected"';} ?>>65</option>
					<option value="66" <?php if ($enmge_sa == 66) { echo 'selected="selected"';} ?>>66</option>
					<option value="67" <?php if ($enmge_sa == 67) { echo 'selected="selected"';} ?>>67</option>
					<option value="68" <?php if ($enmge_sa == 68) { echo 'selected="selected"';} ?>>68</option>
					<option value="69" <?php if ($enmge_sa == 69) { echo 'selected="selected"';} ?>>69</option>
					<option value="70" <?php if ($enmge_sa == 70) { echo 'selected="selected"';} ?>>70</option>
					<option value="71" <?php if ($enmge_sa == 71) { echo 'selected="selected"';} ?>>71</option>
					<option value="72" <?php if ($enmge_sa == 72) { echo 'selected="selected"';} ?>>72</option>
					<option value="73" <?php if ($enmge_sa == 73) { echo 'selected="selected"';} ?>>73</option>
					<option value="74" <?php if ($enmge_sa == 74) { echo 'selected="selected"';} ?>>74</option>
					<option value="75" <?php if ($enmge_sa == 75) { echo 'selected="selected"';} ?>>75</option>
					<option value="76" <?php if ($enmge_sa == 76) { echo 'selected="selected"';} ?>>76</option>
					<option value="77" <?php if ($enmge_sa == 77) { echo 'selected="selected"';} ?>>77</option>
					<option value="78" <?php if ($enmge_sa == 78) { echo 'selected="selected"';} ?>>78</option>
					<option value="79" <?php if ($enmge_sa == 79) { echo 'selected="selected"';} ?>>79</option>
					<option value="80" <?php if ($enmge_sa == 80) { echo 'selected="selected"';} ?>>80</option>
					<option value="81" <?php if ($enmge_sa == 81) { echo 'selected="selected"';} ?>>81</option>
					<option value="82" <?php if ($enmge_sa == 82) { echo 'selected="selected"';} ?>>82</option>
					<option value="83" <?php if ($enmge_sa == 83) { echo 'selected="selected"';} ?>>83</option>
					<option value="84" <?php if ($enmge_sa == 84) { echo 'selected="selected"';} ?>>84</option>
					<option value="85" <?php if ($enmge_sa == 85) { echo 'selected="selected"';} ?>>85</option>
					<option value="86" <?php if ($enmge_sa == 86) { echo 'selected="selected"';} ?>>86</option>
					<option value="87" <?php if ($enmge_sa == 87) { echo 'selected="selected"';} ?>>87</option>
					<option value="88" <?php if ($enmge_sa == 88) { echo 'selected="selected"';} ?>>88</option>
					<option value="89" <?php if ($enmge_sa == 89) { echo 'selected="selected"';} ?>>89</option>
					<option value="90" <?php if ($enmge_sa == 90) { echo 'selected="selected"';} ?>>90</option>
					<option value="91" <?php if ($enmge_sa == 91) { echo 'selected="selected"';} ?>>91</option>
					<option value="92" <?php if ($enmge_sa == 92) { echo 'selected="selected"';} ?>>92</option>
					<option value="93" <?php if ($enmge_sa == 93) { echo 'selected="selected"';} ?>>93</option>
					<option value="94" <?php if ($enmge_sa == 94) { echo 'selected="selected"';} ?>>94</option>
					<option value="95" <?php if ($enmge_sa == 95) { echo 'selected="selected"';} ?>>95</option>
					<option value="96" <?php if ($enmge_sa == 96) { echo 'selected="selected"';} ?>>96</option>
					<option value="97" <?php if ($enmge_sa == 97) { echo 'selected="selected"';} ?>>97</option>
					<option value="98" <?php if ($enmge_sa == 98) { echo 'selected="selected"';} ?>>98</option>
					<option value="99" <?php if ($enmge_sa == 99) { echo 'selected="selected"';} ?>>99</option>
				</select> -
				<select name="enmge_ea" class="enmge_ea time" tabindex="9">
					<option value="101" <?php if ($enmge_ea == 101) { echo 'selected="selected"';} ?>>Any</option>
					<option value="0" <?php if ($enmge_ea == 0) { echo 'selected="selected"';} ?>>0</option>
					<option value="1" <?php if ($enmge_ea == 1) { echo 'selected="selected"';} ?>>1</option>
					<option value="2" <?php if ($enmge_ea == 2) { echo 'selected="selected"';} ?>>2</option>
					<option value="3" <?php if ($enmge_ea == 3) { echo 'selected="selected"';} ?>>3</option>
					<option value="4" <?php if ($enmge_ea == 4) { echo 'selected="selected"';} ?>>4</option>
					<option value="5" <?php if ($enmge_ea == 5) { echo 'selected="selected"';} ?>>5</option>
					<option value="6" <?php if ($enmge_ea == 6) { echo 'selected="selected"';} ?>>6</option>
					<option value="7" <?php if ($enmge_ea == 7) { echo 'selected="selected"';} ?>>7</option>
					<option value="8" <?php if ($enmge_ea == 8) { echo 'selected="selected"';} ?>>8</option>
					<option value="9" <?php if ($enmge_ea == 9) { echo 'selected="selected"';} ?>>9</option>
					<option value="10" <?php if ($enmge_ea == 10) { echo 'selected="selected"';} ?>>10</option>
					<option value="11" <?php if ($enmge_ea == 11) { echo 'selected="selected"';} ?>>11</option>
					<option value="12" <?php if ($enmge_ea == 12) { echo 'selected="selected"';} ?>>12</option>
					<option value="13" <?php if ($enmge_ea == 13) { echo 'selected="selected"';} ?>>13</option>
					<option value="14" <?php if ($enmge_ea == 14) { echo 'selected="selected"';} ?>>14</option>
					<option value="15" <?php if ($enmge_ea == 15) { echo 'selected="selected"';} ?>>15</option>
					<option value="16" <?php if ($enmge_ea == 16) { echo 'selected="selected"';} ?>>16</option>
					<option value="17" <?php if ($enmge_ea == 17) { echo 'selected="selected"';} ?>>17</option>
					<option value="18" <?php if ($enmge_ea == 18) { echo 'selected="selected"';} ?>>18</option>
					<option value="19" <?php if ($enmge_ea == 19) { echo 'selected="selected"';} ?>>19</option>
					<option value="20" <?php if ($enmge_ea == 20) { echo 'selected="selected"';} ?>>20</option>
					<option value="21" <?php if ($enmge_ea == 21) { echo 'selected="selected"';} ?>>21</option>
					<option value="22" <?php if ($enmge_ea == 22) { echo 'selected="selected"';} ?>>22</option>
					<option value="23" <?php if ($enmge_ea == 23) { echo 'selected="selected"';} ?>>23</option>
					<option value="24" <?php if ($enmge_ea == 24) { echo 'selected="selected"';} ?>>24</option>
					<option value="25" <?php if ($enmge_ea == 25) { echo 'selected="selected"';} ?>>25</option>
					<option value="26" <?php if ($enmge_ea == 26) { echo 'selected="selected"';} ?>>26</option>
					<option value="27" <?php if ($enmge_ea == 27) { echo 'selected="selected"';} ?>>27</option>
					<option value="28" <?php if ($enmge_ea == 28) { echo 'selected="selected"';} ?>>28</option>
					<option value="29" <?php if ($enmge_ea == 29) { echo 'selected="selected"';} ?>>29</option>
					<option value="30" <?php if ($enmge_ea == 30) { echo 'selected="selected"';} ?>>30</option>
					<option value="31" <?php if ($enmge_ea == 31) { echo 'selected="selected"';} ?>>31</option>
					<option value="32" <?php if ($enmge_ea == 32) { echo 'selected="selected"';} ?>>32</option>
					<option value="33" <?php if ($enmge_ea == 33) { echo 'selected="selected"';} ?>>33</option>
					<option value="34" <?php if ($enmge_ea == 34) { echo 'selected="selected"';} ?>>34</option>
					<option value="35" <?php if ($enmge_ea == 35) { echo 'selected="selected"';} ?>>35</option>
					<option value="36" <?php if ($enmge_ea == 36) { echo 'selected="selected"';} ?>>36</option>
					<option value="37" <?php if ($enmge_ea == 37) { echo 'selected="selected"';} ?>>37</option>
					<option value="38" <?php if ($enmge_ea == 38) { echo 'selected="selected"';} ?>>38</option>
					<option value="39" <?php if ($enmge_ea == 39) { echo 'selected="selected"';} ?>>39</option>
					<option value="40" <?php if ($enmge_ea == 40) { echo 'selected="selected"';} ?>>40</option>
					<option value="41" <?php if ($enmge_ea == 41) { echo 'selected="selected"';} ?>>41</option>
					<option value="42" <?php if ($enmge_ea == 42) { echo 'selected="selected"';} ?>>42</option>
					<option value="43" <?php if ($enmge_ea == 43) { echo 'selected="selected"';} ?>>43</option>
					<option value="44" <?php if ($enmge_ea == 44) { echo 'selected="selected"';} ?>>44</option>
					<option value="45" <?php if ($enmge_ea == 45) { echo 'selected="selected"';} ?>>45</option>
					<option value="46" <?php if ($enmge_ea == 46) { echo 'selected="selected"';} ?>>46</option>
					<option value="47" <?php if ($enmge_ea == 47) { echo 'selected="selected"';} ?>>47</option>
					<option value="48" <?php if ($enmge_ea == 48) { echo 'selected="selected"';} ?>>48</option>
					<option value="49" <?php if ($enmge_ea == 49) { echo 'selected="selected"';} ?>>49</option>
					<option value="50" <?php if ($enmge_ea == 50) { echo 'selected="selected"';} ?>>50</option>
					<option value="51" <?php if ($enmge_ea == 51) { echo 'selected="selected"';} ?>>51</option>
					<option value="52" <?php if ($enmge_ea == 52) { echo 'selected="selected"';} ?>>52</option>
					<option value="53" <?php if ($enmge_ea == 53) { echo 'selected="selected"';} ?>>53</option>
					<option value="54" <?php if ($enmge_ea == 54) { echo 'selected="selected"';} ?>>54</option>
					<option value="55" <?php if ($enmge_ea == 55) { echo 'selected="selected"';} ?>>55</option>
					<option value="56" <?php if ($enmge_ea == 56) { echo 'selected="selected"';} ?>>56</option>
					<option value="57" <?php if ($enmge_ea == 57) { echo 'selected="selected"';} ?>>57</option>
					<option value="58" <?php if ($enmge_ea == 58) { echo 'selected="selected"';} ?>>58</option>
					<option value="59" <?php if ($enmge_ea == 59) { echo 'selected="selected"';} ?>>59</option>
					<option value="60" <?php if ($enmge_ea == 60) { echo 'selected="selected"';} ?>>60</option>
					<option value="61" <?php if ($enmge_ea == 61) { echo 'selected="selected"';} ?>>61</option>
					<option value="62" <?php if ($enmge_ea == 62) { echo 'selected="selected"';} ?>>62</option>
					<option value="63" <?php if ($enmge_ea == 63) { echo 'selected="selected"';} ?>>63</option>
					<option value="64" <?php if ($enmge_ea == 64) { echo 'selected="selected"';} ?>>64</option>
					<option value="65" <?php if ($enmge_ea == 65) { echo 'selected="selected"';} ?>>65</option>
					<option value="66" <?php if ($enmge_ea == 66) { echo 'selected="selected"';} ?>>66</option>
					<option value="67" <?php if ($enmge_ea == 67) { echo 'selected="selected"';} ?>>67</option>
					<option value="68" <?php if ($enmge_ea == 68) { echo 'selected="selected"';} ?>>68</option>
					<option value="69" <?php if ($enmge_ea == 69) { echo 'selected="selected"';} ?>>69</option>
					<option value="70" <?php if ($enmge_ea == 70) { echo 'selected="selected"';} ?>>70</option>
					<option value="71" <?php if ($enmge_ea == 71) { echo 'selected="selected"';} ?>>71</option>
					<option value="72" <?php if ($enmge_ea == 72) { echo 'selected="selected"';} ?>>72</option>
					<option value="73" <?php if ($enmge_ea == 73) { echo 'selected="selected"';} ?>>73</option>
					<option value="74" <?php if ($enmge_ea == 74) { echo 'selected="selected"';} ?>>74</option>
					<option value="75" <?php if ($enmge_ea == 75) { echo 'selected="selected"';} ?>>75</option>
					<option value="76" <?php if ($enmge_ea == 76) { echo 'selected="selected"';} ?>>76</option>
					<option value="77" <?php if ($enmge_ea == 77) { echo 'selected="selected"';} ?>>77</option>
					<option value="78" <?php if ($enmge_ea == 78) { echo 'selected="selected"';} ?>>78</option>
					<option value="79" <?php if ($enmge_ea == 79) { echo 'selected="selected"';} ?>>79</option>
					<option value="80" <?php if ($enmge_ea == 80) { echo 'selected="selected"';} ?>>80</option>
					<option value="81" <?php if ($enmge_ea == 81) { echo 'selected="selected"';} ?>>81</option>
					<option value="82" <?php if ($enmge_ea == 82) { echo 'selected="selected"';} ?>>82</option>
					<option value="83" <?php if ($enmge_ea == 83) { echo 'selected="selected"';} ?>>83</option>
					<option value="84" <?php if ($enmge_ea == 84) { echo 'selected="selected"';} ?>>84</option>
					<option value="85" <?php if ($enmge_ea == 85) { echo 'selected="selected"';} ?>>85</option>
					<option value="86" <?php if ($enmge_ea == 86) { echo 'selected="selected"';} ?>>86</option>
					<option value="87" <?php if ($enmge_ea == 87) { echo 'selected="selected"';} ?>>87</option>
					<option value="88" <?php if ($enmge_ea == 88) { echo 'selected="selected"';} ?>>88</option>
					<option value="89" <?php if ($enmge_ea == 89) { echo 'selected="selected"';} ?>>89</option>
					<option value="90" <?php if ($enmge_ea == 90) { echo 'selected="selected"';} ?>>90</option>
					<option value="91" <?php if ($enmge_ea == 91) { echo 'selected="selected"';} ?>>91</option>
					<option value="92" <?php if ($enmge_ea == 92) { echo 'selected="selected"';} ?>>92</option>
					<option value="93" <?php if ($enmge_ea == 93) { echo 'selected="selected"';} ?>>93</option>
					<option value="94" <?php if ($enmge_ea == 94) { echo 'selected="selected"';} ?>>94</option>
					<option value="95" <?php if ($enmge_ea == 95) { echo 'selected="selected"';} ?>>95</option>
					<option value="96" <?php if ($enmge_ea == 96) { echo 'selected="selected"';} ?>>96</option>
					<option value="97" <?php if ($enmge_ea == 97) { echo 'selected="selected"';} ?>>97</option>
					<option value="98" <?php if ($enmge_ea == 98) { echo 'selected="selected"';} ?>>98</option>
					<option value="99" <?php if ($enmge_ea == 99) { echo 'selected="selected"';} ?>>99</option>
				</select>
				<?php } ?>
      </div>
      */ ?>
			<div class="ge-option-container">
				<?php if ( $enmge_xz == 1 ) { ?>
				<span class="ge-filter-label">Postal Code:</span> <input type="text" name="enmge_zip" value="<?php if ($enmge_z != 0) { echo $enmge_z;} ?>" class="enmge_zip ge-zip" disabled="disabled" tabindex="10" />
				<?php } else { ?>
				<span class="ge-filter-label">Postal Code:</span> <input type="text" name="enmge_zip" value="<?php if ($enmge_z != 0) { echo $enmge_z;} ?>" class="enmge_zip ge-zip" tabindex="10" />
				<?php } ?>
			</div>
			<input type="hidden" class="enmge_f" name="enmge_f" value="1" />
			<input type="hidden" class="enmge_sf" name="enmge_sf" value="1" />
			<input type="hidden" class="enmge_o" name="enmge_o" value="1" />
			<input type="hidden" class="enmge_v" name="enmge_v" value="<?php if ( isset($_GET['enmge_v']) || ($_POST && $_POST['enmge_v'] != 0) ) {echo "1";} else { echo "0";}; ?>" />
			<?php if ( $enmge_lo == 1 ) { ?><input type="hidden" class="enmge_lof" name="enmge_lof" value="1" /><?php } ?>
			<div class="ge-submit-padding">
				<input type="submit" value="Search" class="ge-filter-submit enmge-ajax-search" tabindex="11" />
			</div>
		</form>
		</div>
		<?php } ?>
		<?php if ( $enmge_v == 1 ) { ?>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?<?php if ( $enmge_apikey != null) { ?>key=<?php echo $enmge_apikey; ?>&<?php } ?>sensor=false"></script>
	    <script type="text/javascript">
	    	function initialize() { // Initialize map and add options

	    		<?php if ( $enmge_pointer != null ) { ?>
				var gepointer = new google.maps.MarkerImage('<?php echo $enmge_pointer; ?>',
				    // second line defines the dimensions of the image
				    new google.maps.Size(48, 48),
				    // third line defines the origin of the custom icon
				    new google.maps.Point(0,0),
				    // and the last line defines the offset for the image
				    new google.maps.Point(24, 48)
				);
				<?php } ?>

	    		var centerzoom = new google.maps.LatLng(<?php echo $enmge_maplat; ?>, <?php echo $enmge_maplong; ?>);
	    		var mapOptions = { // centered location and zoom
	          		center: centerzoom,
	          		zoom: <?php echo $enmge_zoom; ?>
	        	};

	        	var map = new google.maps.Map(document.getElementById("ge-big-map-canvas"), mapOptions);
	        	var oms = new OverlappingMarkerSpiderfier(map);

	        	var iw = new google.maps.InfoWindow({maxWidth: 200});
				oms.addListener('click', function(marker, event) {
					iw.setContent(marker.desc);
					iw.open(map, marker);
				});

				oms.addListener('spiderfy', function(markers) {
					iw.close();
				});

				<?php foreach ( $enmge_groups as $enmge_g ) {
					$groupurl = $enmge_thispage . '&amp;enmge_gid=' . $enmge_g->group_id . $enmge_sortoptions . $enmge_pageoptions; ?>
					var loc = new google.maps.LatLng(<?php echo $enmge_g->group_lat; ?>, <?php echo $enmge_g->group_long; ?>);
					var marker = new google.maps.Marker({
				    	position: loc,
				    	title: "<?php echo $enmge_g->group_title; ?>",
				    	map: map<?php if ( $enmge_pointer != null ) { ?>,icon: gepointer<?php } ?>
				  	});
				  	marker.desc = '<div class="enmge-marker"><p class="enmge-marker-title"><a href="<?php echo $groupurl; ?>" class="enmge-ajax-pointer" name="<?php if ($enmge_v != 0) {echo "&amp;enmge_gid=" . $enmge_g->group_id . "&amp;enmge_v=1";} else {echo "&amp;enmge_gid=" . $enmge_g->group_id;} ?>"><?php echo $enmge_g->group_title; ?></a></p><p class="enmge-marker-ages"><strong>Ages:</strong> <?php echo $enmge_g->group_startage; ?><?php if ( $enmge_g->group_endage == 100 ) { echo "+"; } else { echo "-" . $enmge_g->group_endage; } ?></p><p class="enmge-marker-location"><strong>Location:</strong> <?php if ( $enmge_g->group_onsite > 0 ) { echo $enmge_g->group_campus_name . " - " . $enmge_g->group_location_label; } else { if ($enmge_offsitelabel == 1) {echo "(" . $enmge_offsite . ") " . $enmge_g->group_location_label;} else {echo $enmge_g->group_location_label;} } ?></p><p class="enmge-marker-topics"><strong><?php echo $enmge_topictitle; ?>:</strong> <?php $enmge_t_comma = 1; foreach ( $enmge_ts as $t) { ?><?php foreach ( $enmge_gtm as $gtm) { ?><?php if ( ($gtm->group_id == $enmge_g->group_id) && ($gtm->topic_id == $t->topic_id) ) { if ( $enmge_t_comma == 1 ) { echo $t->topic_name; $enmge_t_comma = $enmge_t_comma+1; } else { echo ", " . $t->topic_name; $enmge_t_comma = $enmge_t_comma+1; } } ?><?php } ?><?php } ?></p><p class="enmge-marker-status"><strong>Status:</strong> <?php if ( $enmge_g->group_status == 1 ) { echo "Open"; } elseif ( $enmge_g->group_status == 0 ) { echo "Closed"; } else { echo "Full"; } ?></p><p class="enmge-marker-meets">Meets <?php echo strtolower($enmge_g->group_frequency); ?> <?php if ( $enmge_g->group_day == 1 ) { echo "Sunday";  } ?><?php if ( $enmge_g->group_day == 2 ) { echo "Monday";  } ?><?php if ( $enmge_g->group_day == 3 ) { echo "Tuesday";  } ?><?php if ( $enmge_g->group_day == 4 ) { echo "Wednesday";  } ?><?php if ( $enmge_g->group_day == 5 ) { echo "Thursday";  } ?><?php if ( $enmge_g->group_day == 6 ) { echo "Friday";  } ?><?php if ( $enmge_g->group_day == 7 ) { echo "Saturday";  } ?> from <?php if ( date("a", strtotime($enmge_g->group_starttime)) == date("a", strtotime($enmge_g->group_endtime)) ) { echo date("g:i", strtotime($enmge_g->group_starttime)); } else { echo date("g:ia", strtotime($enmge_g->group_starttime)); }; ?>-<?php echo date("g:ia", strtotime($enmge_g->group_endtime)); ?></p></div>';
				  	oms.addMarker(marker);  // <-- here
				<?php } ?>

	      	}

	      	google.maps.event.addDomListener(window, 'load', initialize); // Load map
	    </script>
	    <script type="text/javascript" src="<?php echo plugins_url() . "/groupsengine_plugin/js/oms.min.js"; ?>"></script>
	    <div id="ge-big-map-canvas"></div>
	    <?php } else { ?>
		<table class="ge-groups-table" cellpadding="0" cellspacing="0">
			<tr class="ge-title-row">
				<th class="ge-group-title"><?php echo stripslashes($enmge_grouptitle); ?></th>
				<th class="ge-group-day">Day</th>
				<th class="ge-group-time">Time</th>
				<th class="ge-group-ages">Ages</th>
				<th class="ge-group-locations"><?php echo stripslashes($enmge_locationptitle); ?></th>
				<th class="ge-group-location">Location</th>
				<th class="ge-group-topic"><?php echo stripslashes($enmge_topictitle); ?></th>
				<th class="ge-group-childcare">Childcare?</th>
				<th class="ge-group-status">Status</th>
			</tr>
		<?php $tableodd = 0; foreach ( $enmge_groups as $enmge_g ) {
			$groupurl = $enmge_thispage . '&amp;enmge_gid=' . $enmge_g->group_id . $enmge_sortoptions . $enmge_pageoptions ;?>
			<tr<?php if ( $tableodd == 1 ) { echo " class=\"ge-odd\""; }?>>
				<td class="ge-group-title"><?php echo '<a href="' . $enmge_thispage . '&amp;enmge_gid=' . $enmge_g->group_id . $enmge_sortoptions . $enmge_pageoptions . '" class="enmge-ajax-link">' . stripslashes($enmge_g->group_title) . '</a>'; ?><input type="hidden" name="enmge-ajax-values" value="<?php echo '&amp;enmge_gid=' . $enmge_g->group_id; ?>" class="enmge-ajax-values"></td>
				<td class="ge-group-day"><?php if ( $enmge_g->group_day == 1 ) { echo "Sun<span class=\"deskhide\">day</span>";  } ?><?php if ( $enmge_g->group_day == 2 ) { echo "Mon<span class=\"deskhide\">day</span>";  } ?><?php if ( $enmge_g->group_day == 3 ) { echo "Tue<span class=\"deskhide\">sday</span>";  } ?><?php if ( $enmge_g->group_day == 4 ) { echo "Wed<span class=\"deskhide\">nesday</span>";  } ?><?php if ( $enmge_g->group_day == 5 ) { echo "Thu<span class=\"deskhide\">rsday</span>";  } ?><?php if ( $enmge_g->group_day == 6 ) { echo "Fri<span class=\"deskhide\">day</span>";  } ?><?php if ( $enmge_g->group_day == 7 ) { echo "Sat<span class=\"deskhide\">urday</span>";  } ?></td>
				<td class="ge-group-time"><?php if ( date('a', strtotime($enmge_g->group_starttime)) == date('a', strtotime($enmge_g->group_endtime)) ) { echo date('g:i', strtotime($enmge_g->group_starttime)); } else { echo date('g:ia', strtotime($enmge_g->group_starttime)); }; ?>-<?php echo date('g:ia', strtotime($enmge_g->group_endtime)); ?></td>
				<td class="ge-group-ages"><?php echo $enmge_g->group_startage; ?><?php if ( $enmge_g->group_endage == 100 ) { echo "+"; } else { echo "-" . $enmge_g->group_endage; } ?></td>
				<td class="ge-group-locations"><?php $enmge_l_comma = 1; foreach ( $enmge_locations as $l) { ?><?php foreach ( $enmge_glm as $glm) { ?><?php if ( ($glm->group_id == $enmge_g->group_id) && ($glm->location_id == $l->location_id) ) { if ( $enmge_l_comma == 1 ) { echo stripslashes($l->location_name); $enmge_l_comma = $enmge_l_comma+1; } else { echo ", " . stripslashes($l->location_name); $enmge_l_comma = $enmge_l_comma+1; } } ?><?php } ?><?php } ?></td>
				<td class="ge-group-location"><?php if ( $enmge_g->group_onsite > 0 ) { echo stripslashes($enmge_g->group_campus_name) . " - " . stripslashes($enmge_g->group_location_label); } else { if ($enmge_offsitelabel == 1) {echo "(" . $enmge_offsite . ") " . stripslashes($enmge_g->group_location_label); } else {echo stripslashes($enmge_g->group_location_label);} } ?></td>
				<td class="ge-group-topic"><?php $enmge_t_comma = 1; foreach ( $enmge_ts as $t) { ?><?php foreach ( $enmge_gtm as $gtm) { ?><?php if ( ($gtm->group_id == $enmge_g->group_id) && ($gtm->topic_id == $t->topic_id) ) { if ( $enmge_t_comma == 1 ) { echo stripslashes($t->topic_name); $enmge_t_comma = $enmge_t_comma+1; } else { echo ", " . stripslashes($t->topic_name); $enmge_t_comma = $enmge_t_comma+1; } } ?><?php } ?><?php } ?></td>
				<td class="ge-group-childcare"><?php if ( $enmge_g->group_childcare == 0 ) { echo 'No';} else { echo 'Yes';} ?></td>
				<td class="ge-group-status"><?php if ( $enmge_g->group_status == 1 ) { echo "Open"; } elseif ( $enmge_g->group_status == 0 ) { echo "Closed"; } else { echo "Full"; } ?></td>
			</tr>
		<?php if ( $tableodd == 0 ) { $tableodd = 1; } else { $tableodd = 0; }} ?>
		</table>
		<?php include('pagination.php'); ?>
		<?php } ?>
		<?php } ?>
	<input type="hidden" name="enmge-sort-options" value="<?php echo $enmge_pageoptions; ?>" class="enmge-sort-options">
	<input type="hidden" name="enmge-ajax-options" value="<?php echo $enmge_ajaxoptions; ?>" class="enmge-ajax-options">
	<input type="hidden" name="enmge-embed-options" value="<?php echo $enmge_mapoptions; ?>" class="enmge-embed-options">
	<input type="hidden" name="enmge-group-id" value="<?php if ( isset($_GET['enmge_gid']) ) { echo $_GET['enmge_gid']; } ?>" class="enmge-group-id">
	<input type="hidden" name="enmge-plugin-url" value="<?php echo plugins_url() . "/groupsengine_plugin"; ?>" class="enmge-plugin-url">
	<input type="hidden" name="enmge-permalink" value="<?php echo rawurlencode($enmge_thispage); ?>" class="enmge-permalink">
	<input type="hidden" name="enmge-permalinknoajax" value="<?php echo $enmge_thispage; ?>" class="enmge-permalinknoajax">
	<?php if ( $enmge_credits != "text" ) { ?>
	<h3 class="enmge-poweredby"><a href="http://groupsengine.com" target="_blank">Powered by Groups Engine</a></h3>
	<?php } else { ?>
	<p class="enmge-poweredbytext">Powered by <a href="http://groupsengine.com" target="_blank">Groups Engine</a></p>
	<?php } ?>
	<div style="clear: right"></div>
	<!-- v1.2 031118 -->
	</div>
</div>
<?php // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>
