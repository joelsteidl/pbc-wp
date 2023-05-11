		<div class="enmse-archive-container" id="enmse-archive<?php echo $enmse_randomval; ?>">
			<?php if ( $enmse_archivetype == 1 ) { // Display Image Grid Style Archive ?>
			<div id="enmse-archive-thumbnails">
			<?php $enmse_middlecount = 0; $enmse_oddcount = 0;
			foreach ($enmse_series as $enmse_s) { 
				if ( $enmse_middlecount < 3 ) {$enmse_middlecount = $enmse_middlecount+1;} else {$enmse_middlecount = 1;};
				if ( $enmse_oddcount == 2 ) {
				 	$enmse_oddcount = 1;
				 } else {
				 	$enmse_oddcount = $enmse_oddcount+1;
				 }
			?>
				<div class="enmse-archive-thumb<?php if ( $enmse_middlecount == 2 ) { echo " middle"; } ?><?php if ( $enmse_oddcount == 1 ) { echo " odd"; } ?>">
					<?php if ( $enmse_s->graphic_thumb != null ) { ?><a href="<?php echo $enmse_thispage . '&amp;enmse_sid=' .  $enmse_s->series_id; ?>" title="&amp;enmse_sid=<?php echo $enmse_s->series_id; ?>" class="enmse-imgarchive-ajax"><img src="<?php echo $enmse_s->graphic_thumb; ?>" alt="<?php echo stripslashes($enmse_s->s_title); ?>" border="0" /></a><?php } else { ?><a href="<?php echo $enmse_thispage . '&amp;enmse_sid=' .  $enmse_s->series_id; ?>" title="&amp;enmse_sid=<?php echo $enmse_s->series_id; ?>" class="enmse-imgarchive-ajax"><img src="<?php echo $enmse_placeholderimage; ?>" alt="<?php echo stripslashes($enmse_s->s_title); ?>" border="0" /></a><?php } ?>
					<h4><?php echo stripslashes($enmse_s->s_title); ?></h4>
					<h5><?php echo date_i18n($enmse_dateformat, strtotime($enmse_s->start_date)); ?></h5>
					<p><?php $enmse_smm_count = 0; foreach ( $enmse_smm as $smm ) { ?><?php if ( $smm->series_id == $enmse_s->series_id ) { $enmse_smm_count = $enmse_smm_count+1; } ?><?php } ?><?php if ( $enmse_smm_count == 1 ) { echo "1 " . $enmsemessaget; } elseif ( $enmse_smm_count > 1 ) { echo $enmse_smm_count . " " . $enmsemessagetp; } ?></p>
					<p class="enmse-archive-link"><a href="<?php echo $enmse_thispage . '&amp;enmse_sid=' .  $enmse_s->series_id; ?>" title="&amp;enmse_sid=<?php echo $enmse_s->series_id; ?>" class="enmse-imgarchivetext-ajax"><?php echo $enmse_archiveexplore; ?></a></p>
				</div>
			<?php }; ?>
				<div style="clear: both"></div>
			</div>
			<?php } else { // Display Classic List Style Archive ?>
			<table class="enmse-archive-table" cellpadding="0" cellspacing="0">
			<?php $rowcycle = 'even'; $enmse_middlecount = 0; 
			foreach ($enmse_series as $enmse_s) { 
				if ( $enmse_middlecount < 3 ) {$enmse_middlecount = $enmse_middlecount+1;} else {$enmse_middlecount = 1;};
				if ($rowcycle == 'odd') {
					$rowcycle = 'even';
				} else {
					$rowcycle = 'odd';	
				} ?>
				<tr class="enmse-archive-<?php echo $rowcycle; ?>">
					<td class="enmse-archive-title-cell"><?php echo stripslashes($enmse_s->s_title); ?></td>
					<td class="enmse-archive-date-cell"><?php echo date_i18n($enmse_dateformat, strtotime($enmse_s->start_date)); ?></td>
					<td class="enmse-archive-count-cell"><?php $enmse_smm_count = 0; foreach ( $enmse_smm as $smm ) { ?><?php if ( $smm->series_id == $enmse_s->series_id ) { $enmse_smm_count = $enmse_smm_count+1; } ?><?php } ?><?php if ( $enmse_smm_count == 1 ) { echo "1 " . $enmsemessaget; } elseif ( $enmse_smm_count > 1 ) { echo $enmse_smm_count . " " . $enmsemessagetp; } ?></td>
					<td class="enmse-explore-cell"><a href="<?php echo $enmse_thispage . '&amp;enmse_sid=' .  $enmse_s->series_id; ?>" title="&amp;enmse_sid=<?php echo $enmse_s->series_id; ?>" class="enmse-archive-ajax"><?php echo $enmse_archiveexplore; ?></a></td>
				</tr>
			<?php }; ?>
			</table>
			<?php }; ?>
			<?php include('pagination/archivepagination.php'); ?>
		</div>
	<?php if ( $enmse_lo == 1 ) { ?>
		<input type="hidden" name="enmse-embed-options" value="&amp;enmse_lo=1&amp;enmse_a=0&amp;enmse_de=<?php echo $enmse_de; ?>&amp;enmse_d=<?php echo $enmse_d; ?>&amp;enmse_sh=<?php echo $enmse_sh; ?>&amp;enmse_ex=<?php echo $enmse_ex; ?>&amp;enmse_dss=<?php echo $enmse_dss; ?>&amp;enmse_dst=<?php echo $enmse_dst; ?>&amp;enmse_dsb=<?php echo $enmse_dsb; ?>&amp;enmse_dssp=<?php echo $enmse_dssp; ?>&amp;enmse_scm=<?php echo $enmse_scm; ?>&amp;enmse_dsst=<?php echo $enmse_dsst; ?>&amp;enmse_dam=<?php echo $enmse_dam; ?>&amp;enmse_sort=<?php echo $enmse_sort; ?>&amp;enmse_pag=<?php echo $enmse_pag; ?>&amp;enmse_apag=<?php echo $enmse_apag; ?>&amp;enmse_cv=<?php echo $enmse_cardview; ?>&amp;enmse_ddval=<?php echo $enmse_ddval; ?>&amp;enmse_hsd=<?php echo $enmse_hsd; ?>&amp;enmse_hspd=<?php echo $enmse_hspd; ?>&amp;enmse_htd=<?php echo $enmse_htd; ?>&amp;enmse_hbd=<?php echo $enmse_hbd; ?>&enmse_hs=<?php echo $enmse_hs; ?>&enmse_hsh=<?php echo $enmse_hsh; ?>&enmse_had=<?php echo $enmse_had; ?>" class="enmse-embed-options">
	<?php } else { ?>
	<input type="hidden" name="enmse-embed-options" value="&amp;enmse_lo=0&amp;enmse_a=0&amp;enmse_cv=<?php echo $enmse_cardview; ?>" class="enmse-embed-options">
	<?php } ?>
	<input type="hidden" name="enmse-plugin-url" value="<?php echo plugins_url() . "/seriesengine_plugin"; ?>" class="enmse-plugin-url">
	<input type="hidden" name="enmse-permalink" value="<?php echo rawurlencode($enmse_thispage); ?>" class="enmse-permalink">
	<input type="hidden" name="xxse" value="<?php echo base64_encode(ABSPATH); ?>" class="xxse" />