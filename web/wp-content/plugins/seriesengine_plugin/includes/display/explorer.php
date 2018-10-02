<?php if ( $enmse_de == 1 ) { // SHOW EXPLORER? ?>
<div class="enmse-selector <?php echo $enmse_ddval ?>">
	<?php if ( $enmse_hsd == 0 ) {  ?>
	<select name="enmse_series" class="enmse_series">
		<option value="0">- <?php echo $enmse_explorerbrowseseries; ?> -</option>
		<option value="0" dir="0">-------------</option>
		<option value="<?php echo '&amp;enmse_archives=1'; ?>" dir="<?php echo '&amp;enmse_archives=1'; ?>"><?php echo $enmse_explorerarchives; ?></option>
		<?php if ( isset($enmse_lo) && $enmse_lo == 1) { ?><option value="<?php echo '&amp;enmse_am=1'; ?>" dir="<?php echo '&amp;enmse_am=1'; ?>"><?php echo $enmse_explorermessages; ?></option><?php } ?>
		<option value="0" dir="0">-------------</option>
		<?php foreach ($enmse_series as $enmse_s) {  ?>
		<option value="<?php echo '&amp;enmse_sid=' .  $enmse_s->series_id; ?>"><?php echo stripslashes($enmse_s->s_title); ?></option>
		<?php }; ?>

	</select>
	<?php } ?>
	<?php if ( $enmse_hspd == 0 ) {  ?>
	<select name="enmse_speakers" class="enmse_speakers">
		<option value="0">- <?php echo $enmse_explorerbrowsespeakers; ?> -</option>
		<?php foreach ($enmse_speakers as $enmse_sp) {  ?>
		<option value="<?php echo '&amp;enmse_spid=' .  $enmse_sp->speaker_id; ?>"><?php echo stripslashes($enmse_sp->first_name) . " " . stripslashes($enmse_sp->last_name); ?></option>
		<?php }; ?>
	</select>
	<?php } ?>
	<?php if ( $enmse_htd == 0 ) {  ?>
	<select name="enmse_topics" class="enmse_topics">
		<option value="0">- <?php echo $enmse_explorerbrowsetopics; ?> -</option>
		<?php foreach ($enmse_topics as $enmse_t) {  ?>
		<option value="<?php echo '&amp;enmse_tid=' .  $enmse_t->topic_id; ?>"><?php echo stripslashes($enmse_t->name); ?></option>
		<?php }; ?>
	</select>
	<?php } ?>
	<?php if ( $enmse_hbd == 0 ) {  ?>
	<select name="enmse_books" class="enmse_books">
		<option value="0">- <?php echo $enmse_explorerbrowsebooks; ?> -</option>
		<?php foreach ($enmse_books as $enmse_b) {  ?>
		<option value="<?php echo '&amp;enmse_bid=' .  $enmse_b->book_id; ?>"><?php echo $enmse_booknames[$enmse_b->book_id]; ?></option>
		<?php }; ?>
	</select>
	<?php } ?>
</div>
<?php } ?>