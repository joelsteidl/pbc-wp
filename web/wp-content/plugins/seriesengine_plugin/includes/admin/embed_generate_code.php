<?php /* ----- Series Engine - Generate embed code based on user input ----- */
	
	if ( current_user_can( 'edit_pages' ) ) { 

		global $wpdb;
		
		$enmse_stid = strip_tags($_REQUEST['enmse_stid']);
		$enmse_sid = strip_tags($_REQUEST['enmse_sid']);
		$enmse_tid = strip_tags($_REQUEST['enmse_tid']);
		$enmse_spid = strip_tags($_REQUEST['enmse_spid']);
		$enmse_mid = strip_tags($_REQUEST['enmse_mid']);
		$enmse_bid = strip_tags($_REQUEST['enmse_bid']);
		$enmse_explorer = strip_tags($_REQUEST['enmse_explorer']);
		$enmse_details = strip_tags($_REQUEST['enmse_details']);
		$enmse_related = strip_tags($_REQUEST['enmse_related']);
		$enmse_related_sort = strip_tags($_REQUEST['enmse_sort']);
		$enmse_initial = strip_tags($_REQUEST['enmse_sim']);
		$enmse_a = strip_tags($_REQUEST['enmse_a']);
		$enmse_am = strip_tags($_REQUEST['enmse_am']);
		$enmse_pag = strip_tags($_REQUEST['enmse_pag']);
		$enmse_apag = strip_tags($_REQUEST['enmse_apag']);
		$enmse_cardview = strip_tags($_REQUEST['enmse_cardview']);
		$enmse_seriesmenu = strip_tags($_REQUEST['enmse_seriesmenu']);
		$enmse_speakermenu = strip_tags($_REQUEST['enmse_speakermenu']);
		$enmse_topicmenu = strip_tags($_REQUEST['enmse_topicmenu']);
		$enmse_bookmenu = strip_tags($_REQUEST['enmse_bookmenu']);
		$enmse_sharinglinks = strip_tags($_REQUEST['enmse_sharinglinks']);
		$enmse_seriesinfo = strip_tags($_REQUEST['enmse_seriesinfo']);
		$enmse_download = strip_tags($_REQUEST['enmse_download']);
	
?>

<br />
<h2>Your Custom Shortcode:</h2>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><p class="se-form-instructions">Copy the code to the right and insert it within a page/post on its own line in the editor (or into the "Shortcode" block in Gutenberg).</p></th>
		<td>
			<textarea name="Name" rows="5" cols="40">[seriesengine_wo<?php if ( $enmse_download == 0 ) { echo " enmse_had=1"; }; if ( $enmse_seriesinfo == 0 ) { echo " enmse_hs=1"; }; if ( $enmse_sharinglinks == 0 ) { echo " enmse_hsh=1"; }; if ( $enmse_cardview > 0 ) { echo " enmse_cv=" . $enmse_cardview; }; if ( $enmse_stid > 0 ) { echo " enmse_dsst=" . $enmse_stid; }; if ( $enmse_sid > 0 ) { echo " enmse_dss=" . $enmse_sid; }; if ( $enmse_tid > 0 ) { echo " enmse_dst=" . $enmse_tid; }; if ( $enmse_bid > 0 ) { echo " enmse_dsb=" . $enmse_bid; }; if ( $enmse_spid > 0 ) { echo " enmse_dssp=" . $enmse_spid; }; if ( $enmse_pag != 0 ) { echo " enmse_pag=" . $enmse_pag; }; if ( $enmse_apag != 0 ) { echo " enmse_apag=" . $enmse_apag; };  if ( $enmse_mid > 0 ) { echo " enmse_dsm=" . $enmse_mid; }; if ( $enmse_explorer == 1 ) { echo " enmse_e=1"; }; if ( $enmse_details == 2 ) { echo " enmse_d=1"; } elseif ( $enmse_details == 3 ) { echo " enmse_sh=1";  } elseif ( $enmse_details == 4 ) { echo " enmse_ex=1";  }; if ( $enmse_related == 1 ) { echo " enmse_r=1"; }; if ( $enmse_related_sort == 1 ) { echo " enmse_sort=1"; }; if ( $enmse_initial == 0 ) { echo " enmse_sim=0"; };  if ( $enmse_a == 1 ) { echo " enmse_a=1"; }; if ( $enmse_am == 1 ) { echo " enmse_am=1"; }; if ( $enmse_explorer == 1 && $enmse_seriesmenu == 0 ) { echo " enmse_hsd=1"; }; if ( $enmse_explorer == 1 && $enmse_speakermenu == 0 ) { echo " enmse_hspd=1"; }; if ( $enmse_explorer == 1 && $enmse_topicmenu == 0 ) { echo " enmse_htd=1"; }; if ( $enmse_explorer == 1 && $enmse_bookmenu == 0 ) { echo " enmse_hbd=1"; }; ?>]
			</textarea>
		</td>
	</tr>
</table>

<?php } else {
	exit("Access Denied");
} die(); ?>