<?php /* ----- Groups Engine - Generate embed code based on user input ----- */
	
	if ( current_user_can( 'edit_pages' ) ) { 

		global $wpdb;
		
		$enmge_em = strip_tags($_REQUEST['enmge_em']);
		$enmge_gid = strip_tags($_REQUEST['enmge_gid']);
		$enmge_gt = strip_tags($_REQUEST['enmge_gtid']);
		$enmge_t = strip_tags($_REQUEST['enmge_tid']);
		$enmge_l = strip_tags($_REQUEST['enmge_lid']);
		$enmge_m = strip_tags($_REQUEST['enmge_m']);
		$enmge_d = strip_tags($_REQUEST['enmge_d']);
		$enmge_st = strip_tags($_REQUEST['enmge_st']);
		$enmge_et = strip_tags($_REQUEST['enmge_et']);
		$enmge_sa = strip_tags($_REQUEST['enmge_sa']);
		$enmge_ea = strip_tags($_REQUEST['enmge_ea']);
		$enmge_z = strip_tags($_REQUEST['enmge_zip']);
		$enmge_cz = strip_tags($_REQUEST['enmge_cz']);
		$enmge_zl = strip_tags($_REQUEST['enmge_zl']);
		$enmge_v = strip_tags($_REQUEST['enmge_v']);
		$enmge_vo = strip_tags($_REQUEST['enmge_vo']);
		$enmge_glcl = strip_tags($_REQUEST['enmge_glcl']);
		$enmge_cl = strip_tags($_REQUEST['enmge_cl']);
		$enmge_gl = strip_tags($_REQUEST['enmge_gl']);
		$enmge_fo = strip_tags($_REQUEST['enmge_fo']);
		$enmge_xgt = strip_tags($_REQUEST['enmge_xgt']);
		$enmge_xt = strip_tags($_REQUEST['enmge_xt']);
		$enmge_xl = strip_tags($_REQUEST['enmge_xl']);
		$enmge_xm = strip_tags($_REQUEST['enmge_xm']);
		$enmge_xd = strip_tags($_REQUEST['enmge_xd']);
		$enmge_xst = strip_tags($_REQUEST['enmge_xst']);
		$enmge_xsa = strip_tags($_REQUEST['enmge_xsa']);
		$enmge_xz = strip_tags($_REQUEST['enmge_xz']);
		$enmge_sm = strip_tags($_REQUEST['enmge_sm']);
		$enmge_glsm = strip_tags($_REQUEST['enmge_glsm']);
		$enmge_pag = strip_tags($_REQUEST['enmge_pag']);
		$enmge_sort = strip_tags($_REQUEST['enmge_sort']);
		$enmge_status = strip_tags($_REQUEST['enmge_status']);
		$enmge_start = strip_tags($_REQUEST['enmge_start']);
	
?>

<br />
<h2>Your Custom Shortcode:</h2>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><p class="se-form-instructions">Copy the code to the right and insert it within a page/post on its own line in the editor (or in a Shortcode block in Gutenberg).</p></th>
		<td>
			<textarea name="Name" rows="3" cols="40">[groupsengine_wo<?php if ( $enmge_start != 0 ) { echo " enmge_start=1"; }; if ( $enmge_status != 'n' ) { echo " enmge_status=" . $enmge_status; }; if ( $enmge_sort != 0 ) { echo " enmge_sort=" . $enmge_sort; }; if ( $enmge_pag != 0 ) { echo " enmge_pag=" . $enmge_pag; }; if ( $enmge_gid > 0 ) { echo " enmge_gid=" . $enmge_gid; }; if ( $enmge_gt > 0 ) { echo " enmge_gtid=" . $enmge_gt; }; if ( $enmge_t > 0 ) { echo " enmge_tid=" . $enmge_t; }; if ( $enmge_l > 0 ) { echo " enmge_lid=" . $enmge_l; }; if ( $enmge_m != 2 ) { echo " enmge_m=" . $enmge_m; }; if ( $enmge_d > 0 ) { echo " enmge_d=" . $enmge_d; }; if ( $enmge_st != 24 ) { echo " enmge_st=" . $enmge_st; }; if ( $enmge_et != 24 ) { echo " enmge_et=" . $enmge_et; }; if ( $enmge_sa != 101 ) { echo " enmge_sa=" . $enmge_sa; }; if ( $enmge_ea != 101 ) { echo " enmge_ea=" . $enmge_ea; }; if ( $enmge_cz != null ) { echo " enmge_cz=" . $enmge_cz; }; if ( $enmge_zl != null ) { echo " enmge_zl=" . $enmge_zl; }; if ( $enmge_z != null ) { echo " enmge_z=" . $enmge_z; }; if ( $enmge_v != 0 ) { echo " enmge_v=1"; }; if ( $enmge_vo != 1 ) { echo " enmge_vo=0"; }; if ( ($enmge_em == 2 && $enmge_sm != 1) || ($enmge_em == 1 && $enmge_glsm != 1) ) { echo " enmge_sm=0"; }; if ( ($enmge_em == 2 && $enmge_cl != 1) || ($enmge_em == 1 && $enmge_glcl != 1) ) { echo " enmge_cl=0"; }; if ( $enmge_em == 2 && $enmge_gl != 1 ) { echo " enmge_gl=0"; }; if ( $enmge_fo == 2 ) { echo " enmge_fo=2"; }; if ( $enmge_fo == 1 && $enmge_xgt == 0 ) { echo " enmge_xgt=1"; }; if ( $enmge_fo == 1 && $enmge_xt == 0 ) { echo " enmge_xt=1"; }; if ( $enmge_fo == 1 && $enmge_xl == 0 ) { echo " enmge_xl=1"; }; if ( $enmge_fo == 1 && $enmge_xm == 0 ) { echo " enmge_xm=1"; }; if ( $enmge_fo == 1 && $enmge_xd == 0 ) { echo " enmge_xd=1"; }; if ( $enmge_fo == 1 && $enmge_xst == 0 ) { echo " enmge_xst=1"; }; if ( $enmge_fo == 1 && $enmge_xsa == 0 ) { echo " enmge_xsa=1"; }; if ( $enmge_fo == 1 && $enmge_xz == 0 ) { echo " enmge_xz=1"; }; ?>]
			</textarea>
		</td>
	</tr>
</table>

<?php } else {
	exit("Access Denied");
} die(); ?>