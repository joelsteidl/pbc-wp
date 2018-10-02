<?php /* ----- Series Engine - Add a new file straight from the Messages admin page ----- */

	require '../../../../../wp-blog-header.php'; // ADJUST THIS PATH if using a non-standard WordPress install
	header('HTTP/1.1 200 OK');

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

		global $wpdb;

		if ( isset($_GET['new']) && $_GET['new'] == 1 ) {
			$enmse_start_book = strip_tags($_GET['start_book']);
			$enmse_start_chapter = strip_tags($_GET['start_chapter']);
			$enmse_start_verse = strip_tags($_GET['start_verse']);
			$enmse_end_verse = strip_tags($_GET['end_verse']);
			$enmse_trans = strip_tags($_GET['trans']);
			$enmse_focus = strip_tags($_GET['focus']);
			$enmse_scripture_username = strip_tags($_GET['username']);
			$enmse_message_id = strip_tags($_GET['message_id']);

			if ( $enmse_start_book == 1 ) {
				$bookname = "Genesis";
				$shortbookname = "Gen";
				$bookcode = "GEN";
			} elseif ( $enmse_start_book == 2 ) {
				$bookname = "Exodus";
				$shortbookname = "Exo";
				$bookcode = "EXO";
			} elseif ( $enmse_start_book == 3 ) {
				$bookname = "Leviticus";
				$shortbookname = "Lev";
				$bookcode = "LEV";
			} elseif ( $enmse_start_book == 4 ) {
				$bookname = "Numbers";
				$shortbookname = "Num";
				$bookcode = "NUM";
			} elseif ( $enmse_start_book == 5 ) {
				$bookname = "Deuteronomy";
				$shortbookname = "Deut";
				$bookcode = "DEU";
			} elseif ( $enmse_start_book == 6 ) {
				$bookname = "Joshua";
				$bookcode = "JOS";
				$shortbookname = "Josh";
			} elseif ( $enmse_start_book == 7 ) {
				$bookname = "Judges";
				$bookcode = "JDG";
				$shortbookname = "Judg";
			} elseif ( $enmse_start_book == 8 ) {
				$bookname = "Ruth";
				$bookcode = "RUT";
				$shortbookname = "Ruth";
			} elseif ( $enmse_start_book == 9 ) {
				$bookname = "1 Samuel";
				$bookcode = "1SA";
				$shortbookname = "1 Sam";
			} elseif ( $enmse_start_book == 10 ) {
				$bookname = "2 Samuel";
				$bookcode = "2SA";
				$shortbookname = "2 Sam";
			} elseif ( $enmse_start_book == 11 ) {
				$bookname = "1 Kings";
				$bookcode = "1KI";
				$shortbookname = "1 Kings";
			} elseif ( $enmse_start_book == 12 ) {
				$bookname = "2 Kings";
				$bookcode = "2KI";
				$shortbookname = "2 Kings";
			} elseif ( $enmse_start_book == 13 ) {
				$bookname = "1 Chronicles";
				$bookcode = "1CH";
				$shortbookname = "1 Chr";
			} elseif ( $enmse_start_book == 14 ) {
				$bookname = "2 Chronicles";
				$bookcode = "2CH";
				$shortbookname = "2 Chr";
			} elseif ( $enmse_start_book == 15 ) {
				$bookname = "Ezra";
				$bookcode = "EZR";
				$shortbookname = "Ezra";
			} elseif ( $enmse_start_book == 16 ) {
				$bookname = "Nehemiah";
				$bookcode = "NEH";
				$shortbookname = "Neh";
			} elseif ( $enmse_start_book == 17 ) {
				$bookname = "Esther";
				$bookcode = "EST";
				$shortbookname = "Esth";
			} elseif ( $enmse_start_book == 18 ) {
				$bookname = "Job";
				$bookcode = "JOB";
				$shortbookname = "Job";
			} elseif ( $enmse_start_book == 19 ) {
				$bookname = "Psalms";
				$bookcode = "PSA";
				$shortbookname = "Ps";
			} elseif ( $enmse_start_book == 20 ) {
				$bookname = "Proverbs";
				$bookcode = "PRO";
				$shortbookname = "Prov";
			} elseif ( $enmse_start_book == 21 ) {
				$bookname = "Ecclesiastes";
				$bookcode = "ECC";
				$shortbookname = "Ecc";
			} elseif ( $enmse_start_book == 22 ) {
				$bookname = "Song of Solomon";
				$bookcode = "SNG";
				$shortbookname = "Song";
			} elseif ( $enmse_start_book == 23 ) {
				$bookname = "Isaiah";
				$bookcode = "ISA";
				$shortbookname = "Isa";
			} elseif ( $enmse_start_book == 24 ) {
				$bookname = "Jeremiah";
				$bookcode = "JER";
				$shortbookname = "Jer";
			} elseif ( $enmse_start_book == 25 ) {
				$bookname = "Lamentations";
				$bookcode = "LAM";
				$shortbookname = "Lam";
			} elseif ( $enmse_start_book == 26 ) {
				$bookname = "Ezekiel";
				$bookcode = "EZK";
				$shortbookname = "Ezek";
			} elseif ( $enmse_start_book == 27 ) {
				$bookname = "Daniel";
				$bookcode = "DAN";
				$shortbookname = "Dan";
			} elseif ( $enmse_start_book == 28 ) {
				$bookname = "Hosea";
				$bookcode = "HOS";
				$shortbookname = "Hos";
			} elseif ( $enmse_start_book == 29 ) {
				$bookname = "Joel";
				$bookcode = "JOL";
				$shortbookname = "Joel";
			} elseif ( $enmse_start_book == 30 ) {
				$bookname = "Amos";
				$bookcode = "AMO";
				$shortbookname = "Amos";
			} elseif ( $enmse_start_book == 31 ) {
				$bookname = "Obadiah";
				$bookcode = "OBA";
				$shortbookname = "Obad";
			} elseif ( $enmse_start_book == 32 ) {
				$bookname = "Jonah";
				$bookcode = "JON";
				$shortbookname = "Jon";
			} elseif ( $enmse_start_book == 33 ) {
				$bookname = "Micah";
				$bookcode = "MIC";
				$shortbookname = "Mic";
			} elseif ( $enmse_start_book == 34 ) {
				$bookname = "Nahum";
				$bookcode = "NAM";
				$shortbookname = "Nah";
			} elseif ( $enmse_start_book == 35 ) {
				$bookname = "Habakkuk";
				$bookcode = "HAB";
				$shortbookname = "Hab";
			} elseif ( $enmse_start_book == 36 ) {
				$bookname = "Zephaniah";
				$bookcode = "ZEP";
				$shortbookname = "Zeph";
			} elseif ( $enmse_start_book == 37 ) {
				$bookname = "Haggai";
				$bookcode = "HAG";
				$shortbookname = "Hag";
			} elseif ( $enmse_start_book == 38 ) {
				$bookname = "Zechariah";
				$bookcode = "ZEC";
				$shortbookname = "Zech";
			} elseif ( $enmse_start_book == 39 ) {
				$bookname = "Malachi";
				$bookcode = "MAL";
				$shortbookname = "Mal";
			} elseif ( $enmse_start_book == 40 ) {
				$bookname = "Matthew";
				$bookcode = "MAT";
				$shortbookname = "Mt";
			} elseif ( $enmse_start_book == 41 ) {
				$bookname = "Mark";
				$bookcode = "MRK";
				$shortbookname = "Mk";
			} elseif ( $enmse_start_book == 42 ) {
				$bookname = "Luke";
				$bookcode = "LUK";
				$shortbookname = "Lk";
			} elseif ( $enmse_start_book == 43 ) {
				$bookname = "John";
				$bookcode = "JHN";
				$shortbookname = "Jn";
			} elseif ( $enmse_start_book == 44 ) {
				$bookname = "Acts";
				$bookcode = "ACT";
				$shortbookname = "Acts";
			} elseif ( $enmse_start_book == 45 ) {
				$bookname = "Romans";
				$bookcode = "ROM";
				$shortbookname = "Rom";
			} elseif ( $enmse_start_book == 46 ) {
				$bookname = "1 Corinthians";
				$bookcode = "1CO";
				$shortbookname = "1 Cor";
			} elseif ( $enmse_start_book == 47 ) {
				$bookname = "2 Corinthians";
				$bookcode = "2CO";
				$shortbookname = "2 Cor";
			} elseif ( $enmse_start_book == 48 ) {
				$bookname = "Galatians";
				$bookcode = "GAL";
				$shortbookname = "Gal";
			} elseif ( $enmse_start_book == 49 ) {
				$bookname = "Ephesians";
				$bookcode = "EPH";
				$shortbookname = "Eph";
			} elseif ( $enmse_start_book == 50 ) {
				$bookname = "Philippians";
				$bookcode = "PHP";
				$shortbookname = "Phil";
			} elseif ( $enmse_start_book == 51 ) {
				$bookname = "Colossians";
				$bookcode = "COL";
				$shortbookname = "Col";
			} elseif ( $enmse_start_book == 52 ) {
				$bookname = "1 Thessalonians";
				$bookcode = "1TH";
				$shortbookname = "1 Thess";
			} elseif ( $enmse_start_book == 53 ) {
				$bookname = "2 Thessalonians";
				$bookcode = "2TH";
				$shortbookname = "2 Thess";
			} elseif ( $enmse_start_book == 54 ) {
				$bookname = "1 Timothy";
				$bookcode = "1TI";
				$shortbookname = "1 Tim";
			} elseif ( $enmse_start_book == 55 ) {
				$bookname = "2 Timothy";
				$bookcode = "2TI";
				$shortbookname = "2 Tim";
			} elseif ( $enmse_start_book == 56 ) {
				$bookname = "Titus";
				$bookcode = "TIT";
				$shortbookname = "Titus";
			} elseif ( $enmse_start_book == 57 ) {
				$bookname = "Philemon";
				$bookcode = "PHM";
				$shortbookname = "Philemon";
			} elseif ( $enmse_start_book == 58 ) {
				$bookname = "Hebrews";
				$bookcode = "HEB";
				$shortbookname = "Heb";
			} elseif ( $enmse_start_book == 59 ) {
				$bookname = "James";
				$bookcode = "JAS";
				$shortbookname = "Jas";
			} elseif ( $enmse_start_book == 60 ) {
				$bookname = "1 Peter";
				$bookcode = "1PE";
				$shortbookname = "1 Pet";
			} elseif ( $enmse_start_book == 61 ) {
				$bookname = "2 Peter";
				$bookcode = "2PE";
				$shortbookname = "2 Pet";
			} elseif ( $enmse_start_book == 62 ) {
				$bookname = "1 John";
				$bookcode = "1JN";
				$shortbookname = "1 Jn";
			} elseif ( $enmse_start_book == 63 ) {
				$bookname = "2 John";
				$bookcode = "2JN";
				$shortbookname = "2 Jn";
			} elseif ( $enmse_start_book == 64 ) {
				$bookname = "3 John";
				$bookcode = "3JN";
				$shortbookname = "3 Jn";
			} elseif ( $enmse_start_book == 65 ) {
				$bookname = "Jude";
				$bookcode = "JUD";
				$shortbookname = "Jude";
			} elseif ( $enmse_start_book == 66 ) {
				$bookname = "Revelation";
				$bookcode = "REV";
				$shortbookname = "Rev";
			} 

			if ( $enmse_trans == 1588 ) {
				$trans = " (AMP)";
			} elseif ( $enmse_trans == 12 ) {
				$trans = " (ASV)";
			} elseif ( $enmse_trans == 1713 ) {
				$trans = " (CSB)";
			} elseif ( $enmse_trans == 59 ) {
				$trans = " (ESV)";
			} elseif ( $enmse_trans == 72 ) {
				$trans = " (HCSB)";
			} elseif ( $enmse_trans == 1359 ) {
				$trans = " (ICB)";
			} elseif ( $enmse_trans == 1 ) {
				$trans = " (KJV)";
			} elseif ( $enmse_trans == 1171 ) {
				$trans = " (MEV)";
			} elseif ( $enmse_trans == 97 ) {
				$trans = " (MSG)";
			} elseif ( $enmse_trans == 100 ) {
				$trans = " (NASB)";
			} elseif ( $enmse_trans == 111 ) {
				$trans = " (NIV)";
			} elseif ( $enmse_trans == 114 ) {
				$trans = " (NKJV)";
			} elseif ( $enmse_trans == 116 ) {
				$trans = " (NLT)";
			} elseif ( $enmse_trans == 6 ) {
				$trans = " (AFR83)";
			}

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
				$enmse_scriptures = $wpdb->get_results( $enmse_fsql );
			} else {
				// Get All Files
				$enmse_preparredscsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND scripture_username = %d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_scsql = $wpdb->prepare( $enmse_preparredscsql, $enmse_message_id, $enmse_scripture_username );
				$enmse_scriptures = $wpdb->get_results( $enmse_scsql );
			}
		} else {
			$enmse_message_id = strip_tags($_GET['message_id']);
			$enmse_scripture_username = strip_tags($_GET['username']);
			
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
<?php if ($_POST) { ?>
<?php } else { ?>
	<?php if ( isset($_GET['done']) ) { ?>
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
				jQuery.post("<?php echo plugins_url() .'/seriesengine_plugin/includes/admin/sortscriptures.php'; ?>", order, function(){}); 
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
				jQuery.post("<?php echo plugins_url() .'/seriesengine_plugin/includes/admin/sortscriptures.php'; ?>", order, function(){}); 
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
	<?php } ?>
<?php } ?>
<?php } else {
	exit("Access Denied");
} ?>