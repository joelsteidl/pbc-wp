<?php /* ----- Series Engine - Add a new file straight from the Messages admin page ----- */

	if ( current_user_can( 'edit_pages' ) ) { 

		// ***** Get Labels
		$enmse_options = get_option( 'enm_seriesengine_options' ); 

		if ( isset($enmse_options['messaget']) ) { // Find Message Title
			$enmsemessaget = $enmse_options['messaget'];
		} else {
			$enmsemessaget = "Message";
		}

		if ( isset($enmse_options['messagetp']) ) { // Find Message Title (plural)
			$enmsemessagetp = $enmse_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		}

		if ( isset($enmse_options['deftrans']) ) { // Default Translation
			$deftrans = $enmse_options['deftrans'];
		} else {
			$deftrans = 59;
		}

		if ( isset($enmse_options['messagetp']) ) { // Find Message Title (plural)
			$enmsemessagetp = $enmse_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		}

		if ( isset($enmse_options['language']) ) { // Find the Language
			$enmse_language = $enmse_options['language'];
		} else {
			$enmse_language = 1;
		}

		global $wpdb;

		if ( isset($_REQUEST['new']) && $_REQUEST['new'] == 1 ) {
			$enmse_start_book = strip_tags($_REQUEST['start_book']);
			$enmse_start_chapter = strip_tags($_REQUEST['start_chapter']);
			$enmse_start_verse = strip_tags($_REQUEST['start_verse']);
			$enmse_end_verse = strip_tags($_REQUEST['end_verse']);
			$enmse_trans = strip_tags($_REQUEST['trans']);
			$enmse_focus = strip_tags($_REQUEST['focus']);
			$enmse_scripture_username = strip_tags($_REQUEST['username']);
			$enmse_message_id = strip_tags($_REQUEST['message_id']);

			include('scripture/scriptureformatting.php');

			if ( $enmse_start_verse != $enmse_end_verse ) {
				$enmse_text = $bookname . " " . $enmse_start_chapter . ":" . $enmse_start_verse . "-" . $enmse_end_verse;
				$enmse_short_text = $shortbookname . " " . $enmse_start_chapter . ":" . $enmse_start_verse . "-" . $enmse_end_verse;
				$enmse_link = "https://bible.com/bible/" . $enmse_trans . "/" . $bookcode . "." . $enmse_start_chapter . "." . $enmse_start_verse . "-" . $enmse_end_verse;
			} else {
				$enmse_text = $bookname . " " . $enmse_start_chapter . ":" . $enmse_start_verse;
				$enmse_short_text = $shortbookname . " " . $enmse_start_chapter . ":" . $enmse_start_verse;
				$enmse_link = "https://bible.com/bible/" . $enmse_trans . "/" . $bookcode . "." . $enmse_start_chapter . "." . $enmse_start_verse;
			}                                        

			$enmse_scripture = array(
				'start_book' => $enmse_start_book, 
				'start_chapter' => $enmse_start_chapter,
				'start_verse' => $enmse_start_verse,
				'end_verse' => $enmse_end_verse,
				'trans' => $enmse_trans,
				'transtext' => $trans,
				'focus' => $enmse_focus,
				'text' => $enmse_text,
				'short_text' => $enmse_short_text,
				'link' => $enmse_link,
				'scripture_username' => $enmse_scripture_username
				); 
			$wpdb->insert( $wpdb->prefix . "se_scriptures", $enmse_scripture );
			$enmse_new_scripture_id = $wpdb->insert_id; 
			
			// Add file relation in the DB
			$enmse_newscmm = array(
				'message_id' => $enmse_message_id, 
				'scripture_id' => $enmse_new_scripture_id
			); 
			$wpdb->insert( $wpdb->prefix . "se_scripture_message_matches", $enmse_newscmm );

			if ( $enmse_focus == 1 && $enmse_message_id > 0 ) {
				$enmse_preparredscmsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND focus = 1 GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_scmsql = $wpdb->prepare( $enmse_preparredscmsql, $enmse_message_id );
				$enmse_mscriptures = $wpdb->get_results( $enmse_scmsql );

				$scomma = 0;
				foreach ( $enmse_mscriptures as $s ) {
					if ( $scomma == 0 ) {
						$scripturetext = $s->text;
					} else {
						$scripturetext = $scripturetext . ", " . $s->text;
					}
					$scomma = $scomma + 1;
				}

				$enmse_new_mvalues = array( 'focus_scripture' => $scripturetext ); 
				$enmse_mwhere = array( 'message_id' => $enmse_message_id ); 
				$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

				$enmse_preparreddscmsql = "SELECT bm_match_id FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id = %d AND book_id = %d GROUP BY bm_match_id ORDER BY bm_match_id ASC"; 
				$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $enmse_message_id, $enmse_start_book );
				$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
				$enmse_countrec = $wpdb->num_rows;

				if ( $enmse_countrec > 1 || empty($enmse_dmscriptures) ) {
					$enmse_newbmm = array(
						'message_id' => $enmse_message_id, 
						'book_id' => $enmse_start_book
					); 
					$wpdb->insert( $wpdb->prefix . "se_book_message_matches", $enmse_newbmm );
				}

			}

			if ( $enmse_message_id > 0 ) {
				// Get All Scriptures
				$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_message_id );
				$enmse_scriptures = $wpdb->get_results( $enmse_scsql );
			} else {
				// Get All Files
				$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND scripture_username = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_message_id, $enmse_scripture_username );
				$enmse_scriptures = $wpdb->get_results( $enmse_scsql );
			}
		} else {
			$enmse_message_id = strip_tags($_REQUEST['message_id']);
			$enmse_scripture_username = strip_tags($_REQUEST['username']);
			
			if ( $enmse_message_id > 0 ) {
				// Get All Scriptures
				$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_message_id );
				$enmse_scriptures = $wpdb->get_results( $enmse_scsql );
			} else {
				// Get All Scriptures
				$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND scripture_username = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_message_id, $enmse_scripture_username );
				$enmse_scriptures = $wpdb->get_results( $enmse_scsql );
			}
			
		}

?>
	<?php if ( isset($_REQUEST['done']) ) { ?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#enmsescmessage").delay(4000).slideUp();
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					jQuery(this).width(jQuery(this).width());
				});
				return ui;
			};
			jQuery("#scripturetable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
				var order = jQuery(this).sortable("serialize");
				jQuery.ajax({
					method: "POST",
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxsortscripture',
			            'row': order
			        },
			        success:function(data) {
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}});
		});
		</script>
		<br />
		<h3>References Currently Associated with This <?php echo $enmsemessaget; ?>...</h3>
		<p id="enmsescmessage"><em>Your scripture reference was sucessfully edited.</em></p>
		<table class="widefat" id="scripturetable"> 
		<thead> 
			<tr> 
				<th>Sort</th> 
				<th>Reference</th> 
				<th>URL</th>
				<th>Focus Passage?</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($enmse_scriptures as $scripture) {  ?>
			<tr id="row_<?php echo $scripture->scripture_id; ?>">
				<td class="enmse-sort"></td>
				<td><a href="#" class="seriesengine_editscripture" name="<?php echo $scripture->scripture_id; ?>"><?php echo stripslashes($scripture->text . $scripture->transtext); ?></a></td>
				<td><a href="<?php echo $scripture->link; ?>" target="_blank">Preview on <em>bible.com</a></td>
				<td><?php if ( $scripture->focus == 1 ) { echo "Yes"; }; ?></td>
				<td class="enmse-delete"><a href="#" class="seriesengine_scripturedelete" name="<?php echo $scripture->scripture_id; ?>" rel="<?php echo $scripture->focus; ?>">Delete</a></td>				
			</tr>
		<?php } ?>
		</tbody>
		</table>
		<br />
		<br />
	<?php } else { ?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#enmsescmessage").delay(4000).slideUp();
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					jQuery(this).width(jQuery(this).width());
				});
				return ui;
			};
			jQuery("#scripturetable tbody").sortable({ helper: fixHelper, opacity: 0.6, cursor: 'move', update: function() {
				var order = jQuery(this).sortable("serialize");
				jQuery.ajax({
					method: "POST",
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxsortscripture',
			            'row': order
			        },
			        success:function(data) {
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			}});
		});
		</script>
		<br />
		<h3>References Currently Associated with This <?php echo $enmsemessaget; ?>...</h3>
		<p id="enmsescmessage"><em>Your scripture reference was sucessfully added.</em></p>
		<table class="widefat" id="scripturetable"> 
		<thead> 
			<tr> 
				<th>Sort</th> 
				<th>Reference</th> 
				<th>URL</th>
				<th>Focus Passage?</th>
				<th>Delete?</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($enmse_scriptures as $scripture) {  ?>
			<tr id="row_<?php echo $scripture->scripture_id; ?>">
				<td class="enmse-sort"></td>
				<td><a href="#" class="seriesengine_editscripture" name="<?php echo $scripture->scripture_id; ?>"><?php echo stripslashes($scripture->text . $scripture->transtext); ?></a></td>
				<td><a href="<?php echo $scripture->link; ?>" target="_blank">Preview on <em>bible.com</a></td>
				<td><?php if ( $scripture->focus == 1 ) { echo "Yes"; }; ?></td>
				<td class="enmse-delete"><a href="#" class="seriesengine_scripturedelete" name="<?php echo $scripture->scripture_id; ?>" rel="<?php echo $scripture->focus; ?>">Delete</a></td>				
			</tr>
		<?php } ?>
		</tbody>
		</table>
		<br />
		<br />
	<?php } ?>
<?php } else {
	exit("Access Denied");
} die(); ?>