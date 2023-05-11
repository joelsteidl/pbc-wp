<?php /* ----- Series Engine - Edit a scripture straight from the Messages admin page ----- */

	if ( current_user_can( 'edit_pages' ) ) { 

		global $wpdb;

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

		if ( isset($enmse_options['language']) ) { // Find the Language
			$enmse_language = $enmse_options['language'];
		} else {
			$enmse_language = 1;
		}

		if ( $enmse_language == 10 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/fre_bible_books.php');
		}  elseif ( $enmse_language == 9 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/rus_bible_books.php');
		} elseif ( $enmse_language == 8 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/jap_bible_books.php');
		} elseif ( $enmse_language == 7 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/dut_bible_books.php');
		} elseif ( $enmse_language == 6 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/chint_bible_books.php');
		} elseif ( $enmse_language == 5 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/chins_bible_books.php');
		} elseif ( $enmse_language == 4 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/turk_bible_books.php');
		} elseif ( $enmse_language == 3 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/ger_bible_books.php');
		} elseif ( $enmse_language == 2 ) { 
			include(ENMSE_PLUGIN_PATH . 'includes/lang/spa_bible_books.php');
		} else {
			include(ENMSE_PLUGIN_PATH . 'includes/lang/eng_bible_books.php');
		}

		if ( isset($_REQUEST['update']) && $_REQUEST['update'] == 1 ) {
			$enmse_start_book = strip_tags($_REQUEST['start_book']);
			$enmse_start_chapter = strip_tags($_REQUEST['start_chapter']);
			$enmse_start_verse = strip_tags($_REQUEST['start_verse']);
			$enmse_end_verse = strip_tags($_REQUEST['end_verse']);
			$enmse_trans = strip_tags($_REQUEST['trans']);
			$enmse_focus = strip_tags($_REQUEST['focus']);
			$enmse_scripture_username = strip_tags($_REQUEST['username']);
			$enmse_message_id = strip_tags($_REQUEST['message_id']);
			$enmse_scripture_id = strip_tags($_REQUEST['scripture_id']);

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
			
			$enmse_new_values = array( 'start_book' => $enmse_start_book, 'start_chapter' => $enmse_start_chapter, 'start_verse' => $enmse_start_verse, 'end_verse' => $enmse_end_verse, 'trans' => $enmse_trans, 'focus' => $enmse_focus, 'text' => $enmse_text, 'short_text' => $enmse_short_text, 'link' => $enmse_link, 'scripture_username' => $enmse_scripture_username, 'transtext' => $trans); 
			$enmse_where = array( 'scripture_id' => $enmse_scripture_id ); 
			$wpdb->update( $wpdb->prefix . "se_scriptures", $enmse_new_values, $enmse_where ); 

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
			} else {
				$enmse_preparreddscmsql = "SELECT scm_match_id FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND focus = 1 AND start_book=%d GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $enmse_message_id, $enmse_start_book  );
				$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
				$enmse_countrec = $wpdb->num_rows;

				if ( empty($enmse_dmscriptures) ) {
					$enmse_bdelete_query_preparred = "DELETE FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id=%d AND book_id=%d";
					$enmse_bdelete_query = $wpdb->prepare( $enmse_bdelete_query_preparred, $enmse_message_id, $enmse_start_book  ); 
					$enmse_bdeleted = $wpdb->query( $enmse_bdelete_query );
				}

				$enmse_preparredscmsql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " LEFT JOIN " . $wpdb->prefix . "se_scripture_message_matches" . " USING (scripture_id) WHERE message_id = %d AND focus = 1 GROUP BY scm_match_id ORDER BY sort_id ASC"; 
				$enmse_scmsql = $wpdb->prepare( $enmse_preparredscmsql, $enmse_message_id );
				$enmse_mscriptures = $wpdb->get_results( $enmse_scmsql );

				$scomma = 0;
				$scripturetext = "";
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
			}

			$enmse_findthescripturesql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " WHERE scripture_id = %d"; 
			$enmse_findthescripture = $wpdb->prepare( $enmse_findthescripturesql, $enmse_scripture_id );
			$enmse_scripture = $wpdb->get_row( $enmse_findthescripture, OBJECT );	
		} else {
			$enmse_scripture_id = strip_tags($_REQUEST['scripture_id']);

			$enmse_findthescripturesql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " WHERE scripture_id = %d"; 
			$enmse_findthescripture = $wpdb->prepare( $enmse_findthescripturesql, $enmse_scripture_id );
			$enmse_scripture = $wpdb->get_row( $enmse_findthescripture, OBJECT );
		}

?>
	<?php if ( isset($_REQUEST['done']) ) { ?>
		<h3>Add a New Scripture Reference</h3>		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Start Verse:</th>
				<td>
					<select name="scripture_start_book" id="scripture_start_book" tabindex="3">
						<option value="1"><?php echo $enmse_booknames[1]; ?></option>
						<option value="2"><?php echo $enmse_booknames[2]; ?></option>
						<option value="3"><?php echo $enmse_booknames[3]; ?></option>
						<option value="4"><?php echo $enmse_booknames[4]; ?></option>
						<option value="5"><?php echo $enmse_booknames[5]; ?></option>
						<option value="6"><?php echo $enmse_booknames[6]; ?></option>
						<option value="7"><?php echo $enmse_booknames[7]; ?></option>
						<option value="8"><?php echo $enmse_booknames[8]; ?></option>
						<option value="9"><?php echo $enmse_booknames[9]; ?></option>
						<option value="10"><?php echo $enmse_booknames[10]; ?></option>
						<option value="11"><?php echo $enmse_booknames[11]; ?></option>
						<option value="12"><?php echo $enmse_booknames[12]; ?></option>
						<option value="13"><?php echo $enmse_booknames[13]; ?></option>
						<option value="14"><?php echo $enmse_booknames[14]; ?></option>
						<option value="15"><?php echo $enmse_booknames[15]; ?></option>
						<option value="16"><?php echo $enmse_booknames[16]; ?></option>
						<option value="17"><?php echo $enmse_booknames[17]; ?></option>
						<option value="18"><?php echo $enmse_booknames[18]; ?></option>
						<option value="19"><?php echo $enmse_booknames[19]; ?></option>
						<option value="20"><?php echo $enmse_booknames[20]; ?></option>
						<option value="21"><?php echo $enmse_booknames[21]; ?></option>
						<option value="22"><?php echo $enmse_booknames[22]; ?></option>
						<option value="23"><?php echo $enmse_booknames[23]; ?></option>
						<option value="24"><?php echo $enmse_booknames[24]; ?></option>
						<option value="25"><?php echo $enmse_booknames[25]; ?></option>
						<option value="26"><?php echo $enmse_booknames[26]; ?></option>
						<option value="27"><?php echo $enmse_booknames[27]; ?></option>
						<option value="28"><?php echo $enmse_booknames[28]; ?></option>
						<option value="29"><?php echo $enmse_booknames[29]; ?></option>
						<option value="30"><?php echo $enmse_booknames[30]; ?></option>
						<option value="31"><?php echo $enmse_booknames[31]; ?></option>
						<option value="32"><?php echo $enmse_booknames[32]; ?></option>
						<option value="33"><?php echo $enmse_booknames[33]; ?></option>
						<option value="34"><?php echo $enmse_booknames[34]; ?></option>
						<option value="35"><?php echo $enmse_booknames[35]; ?></option>
						<option value="36"><?php echo $enmse_booknames[36]; ?></option>
						<option value="37"><?php echo $enmse_booknames[37]; ?></option>
						<option value="38"><?php echo $enmse_booknames[38]; ?></option>
						<option value="39"><?php echo $enmse_booknames[39]; ?></option>
						<option value="40"><?php echo $enmse_booknames[40]; ?></option>
						<option value="41"><?php echo $enmse_booknames[41]; ?></option>
						<option value="42"><?php echo $enmse_booknames[42]; ?></option>
						<option value="43"><?php echo $enmse_booknames[43]; ?></option>
						<option value="44"><?php echo $enmse_booknames[44]; ?></option>
						<option value="45"><?php echo $enmse_booknames[45]; ?></option>
						<option value="46"><?php echo $enmse_booknames[46]; ?></option>
						<option value="47"><?php echo $enmse_booknames[47]; ?></option>
						<option value="48"><?php echo $enmse_booknames[48]; ?></option>
						<option value="49"><?php echo $enmse_booknames[49]; ?></option>
						<option value="50"><?php echo $enmse_booknames[50]; ?></option>
						<option value="51"><?php echo $enmse_booknames[51]; ?></option>
						<option value="52"><?php echo $enmse_booknames[52]; ?></option>
						<option value="53"><?php echo $enmse_booknames[53]; ?></option>
						<option value="54"><?php echo $enmse_booknames[54]; ?></option>
						<option value="55"><?php echo $enmse_booknames[55]; ?></option>
						<option value="56"><?php echo $enmse_booknames[56]; ?></option>
						<option value="57"><?php echo $enmse_booknames[57]; ?></option>
						<option value="58"><?php echo $enmse_booknames[58]; ?></option>
						<option value="59"><?php echo $enmse_booknames[59]; ?></option>
						<option value="60"><?php echo $enmse_booknames[60]; ?></option>
						<option value="61"><?php echo $enmse_booknames[61]; ?></option>
						<option value="62"><?php echo $enmse_booknames[62]; ?></option>
						<option value="63"><?php echo $enmse_booknames[63]; ?></option>
						<option value="64"><?php echo $enmse_booknames[64]; ?></option>
						<option value="65"><?php echo $enmse_booknames[65]; ?></option>
						<option value="66"><?php echo $enmse_booknames[66]; ?></option>
					</select>
					<input id='scripture_start_chapter' name='scripture_start_chapter' type='text' value='Chapter' tabindex="2" size="10" /> :
					<input id='scripture_start_verse' name='scripture_start_verse' type='text' value='Verse' tabindex="2" size="10" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">End Verse:</th>
				<td>
					<select name="scripture_end_book" id="scripture_end_book" tabindex="3" class="enmse-disabled" disabled>
						<option value="1"><?php echo $enmse_booknames[1]; ?></option>
						<option value="2"><?php echo $enmse_booknames[2]; ?></option>
						<option value="3"><?php echo $enmse_booknames[3]; ?></option>
						<option value="4"><?php echo $enmse_booknames[4]; ?></option>
						<option value="5"><?php echo $enmse_booknames[5]; ?></option>
						<option value="6"><?php echo $enmse_booknames[6]; ?></option>
						<option value="7"><?php echo $enmse_booknames[7]; ?></option>
						<option value="8"><?php echo $enmse_booknames[8]; ?></option>
						<option value="9"><?php echo $enmse_booknames[9]; ?></option>
						<option value="10"><?php echo $enmse_booknames[10]; ?></option>
						<option value="11"><?php echo $enmse_booknames[11]; ?></option>
						<option value="12"><?php echo $enmse_booknames[12]; ?></option>
						<option value="13"><?php echo $enmse_booknames[13]; ?></option>
						<option value="14"><?php echo $enmse_booknames[14]; ?></option>
						<option value="15"><?php echo $enmse_booknames[15]; ?></option>
						<option value="16"><?php echo $enmse_booknames[16]; ?></option>
						<option value="17"><?php echo $enmse_booknames[17]; ?></option>
						<option value="18"><?php echo $enmse_booknames[18]; ?></option>
						<option value="19"><?php echo $enmse_booknames[19]; ?></option>
						<option value="20"><?php echo $enmse_booknames[20]; ?></option>
						<option value="21"><?php echo $enmse_booknames[21]; ?></option>
						<option value="22"><?php echo $enmse_booknames[22]; ?></option>
						<option value="23"><?php echo $enmse_booknames[23]; ?></option>
						<option value="24"><?php echo $enmse_booknames[24]; ?></option>
						<option value="25"><?php echo $enmse_booknames[25]; ?></option>
						<option value="26"><?php echo $enmse_booknames[26]; ?></option>
						<option value="27"><?php echo $enmse_booknames[27]; ?></option>
						<option value="28"><?php echo $enmse_booknames[28]; ?></option>
						<option value="29"><?php echo $enmse_booknames[29]; ?></option>
						<option value="30"><?php echo $enmse_booknames[30]; ?></option>
						<option value="31"><?php echo $enmse_booknames[31]; ?></option>
						<option value="32"><?php echo $enmse_booknames[32]; ?></option>
						<option value="33"><?php echo $enmse_booknames[33]; ?></option>
						<option value="34"><?php echo $enmse_booknames[34]; ?></option>
						<option value="35"><?php echo $enmse_booknames[35]; ?></option>
						<option value="36"><?php echo $enmse_booknames[36]; ?></option>
						<option value="37"><?php echo $enmse_booknames[37]; ?></option>
						<option value="38"><?php echo $enmse_booknames[38]; ?></option>
						<option value="39"><?php echo $enmse_booknames[39]; ?></option>
						<option value="40"><?php echo $enmse_booknames[40]; ?></option>
						<option value="41"><?php echo $enmse_booknames[41]; ?></option>
						<option value="42"><?php echo $enmse_booknames[42]; ?></option>
						<option value="43"><?php echo $enmse_booknames[43]; ?></option>
						<option value="44"><?php echo $enmse_booknames[44]; ?></option>
						<option value="45"><?php echo $enmse_booknames[45]; ?></option>
						<option value="46"><?php echo $enmse_booknames[46]; ?></option>
						<option value="47"><?php echo $enmse_booknames[47]; ?></option>
						<option value="48"><?php echo $enmse_booknames[48]; ?></option>
						<option value="49"><?php echo $enmse_booknames[49]; ?></option>
						<option value="50"><?php echo $enmse_booknames[50]; ?></option>
						<option value="51"><?php echo $enmse_booknames[51]; ?></option>
						<option value="52"><?php echo $enmse_booknames[52]; ?></option>
						<option value="53"><?php echo $enmse_booknames[53]; ?></option>
						<option value="54"><?php echo $enmse_booknames[54]; ?></option>
						<option value="55"><?php echo $enmse_booknames[55]; ?></option>
						<option value="56"><?php echo $enmse_booknames[56]; ?></option>
						<option value="57"><?php echo $enmse_booknames[57]; ?></option>
						<option value="58"><?php echo $enmse_booknames[58]; ?></option>
						<option value="59"><?php echo $enmse_booknames[59]; ?></option>
						<option value="60"><?php echo $enmse_booknames[60]; ?></option>
						<option value="61"><?php echo $enmse_booknames[61]; ?></option>
						<option value="62"><?php echo $enmse_booknames[62]; ?></option>
						<option value="63"><?php echo $enmse_booknames[63]; ?></option>
						<option value="64"><?php echo $enmse_booknames[64]; ?></option>
						<option value="65"><?php echo $enmse_booknames[65]; ?></option>
						<option value="66"><?php echo $enmse_booknames[66]; ?></option>
					</select>
					<input id='scripture_end_chapter' name='scripture_end_chapter' type='text' value='Chapter' tabindex="2" size="10" class="enmse-disabled" disabled /> :
					<input id='scripture_end_verse' name='scripture_end_verse' type='text' value='Verse' tabindex="2" size="10" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Translation:</th>
				<td>
					<select name="scripture_trans" id="scripture_trans" tabindex="3">
						<option value="<?php echo $deftrans; ?>">------ ENGLISH ------</option>
						<option value="1588"<?php if ( $deftrans == 1588 ) { echo " selected=\"selected\""; } ?>>AMP - Amplified Bible</option>
						<option value="12"<?php if ( $deftrans == 12 ) { echo " selected=\"selected\""; } ?>>ASV - American Standard Version</option>
						<option value="1713"<?php if ( $deftrans == 1713 ) { echo " selected=\"selected\""; } ?>>CSB - Christian Standard Bible</option>
						<option value="37"<?php if ( $deftrans == 37 ) { echo " selected=\"selected\""; } ?>>CEB - Common English Bible</option>
						<option value="59"<?php if ( $deftrans == 59 ) { echo " selected=\"selected\""; } ?>>ESV - English Standard Version</option>
						<option value="72"<?php if ( $deftrans == 72 ) { echo " selected=\"selected\""; } ?>>HCSB - Holman Christian Standard Bible</option>
						<option value="1359"<?php if ( $deftrans == 1359 ) { echo " selected=\"selected\""; } ?>>ICB - International Childrens Bible</option>
						<option value="1"<?php if ( $deftrans == 1 ) { echo " selected=\"selected\""; } ?>>KJV - King James Version</option>
						<option value="1171"<?php if ( $deftrans == 1171 ) { echo " selected=\"selected\""; } ?>>MEV - Modern English Version</option>
						<option value="97"<?php if ( $deftrans == 97 ) { echo " selected=\"selected\""; } ?>>MSG - The Message</option>
						<option value="100"<?php if ( $deftrans == 100 ) { echo " selected=\"selected\""; } ?>>NASB - New American Standard Bible</option>
						<option value="111"<?php if ( $deftrans == 111 ) { echo " selected=\"selected\""; } ?>>NIV - New International Version</option>
						<option value="114"<?php if ( $deftrans == 114 ) { echo " selected=\"selected\""; } ?>>NKJV - New King James Version</option>
						<option value="116"<?php if ( $deftrans == 116 ) { echo " selected=\"selected\""; } ?>>NLT - New Living Translation</option>
						<option value="2016"<?php if ( $deftrans == 2016 ) { echo " selected=\"selected\""; } ?>>NRSV - New Revised Standard Version</option>
						<option value="<?php echo $deftrans; ?>">------ CHINESE ------</option>
						<option value="48"<?php if ( $deftrans == 48 ) { echo " selected=\"selected\""; } ?>>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value="414"<?php if ( $deftrans == 414 ) { echo " selected=\"selected\""; } ?>>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value="<?php echo $deftrans; ?>">------ CZECH ------</option>
						<option value="15"<?php if ( $deftrans == 15 ) { echo " selected=\"selected\""; } ?>>B21 - Bible 21</option>
						<option value="162"<?php if ( $deftrans == 162 ) { echo " selected=\"selected\""; } ?>>BCZ - Slovo na cestu</option>
						<option value="44"<?php if ( $deftrans == 44 ) { echo " selected=\"selected\""; } ?>>BKR - Bible Kralica 1613</option>
						<option value="509"<?php if ( $deftrans == 509 ) { echo " selected=\"selected\""; } ?>>CSP - Cesky studijni preklad</option>
						<option value="<?php echo $deftrans; ?>">------ DUTCH ------</option>
						<option value="1276"<?php if ( $deftrans == 1276 ) { echo " selected=\"selected\""; } ?>>BB - BasisBijbel</option>
						<option value="1990"<?php if ( $deftrans == 1990 ) { echo " selected=\"selected\""; } ?>>HSV - Herziene Statenvertaling</option>
						<option value="75"<?php if ( $deftrans == 75 ) { echo " selected=\"selected\""; } ?>>HTB - Het Boek</option>
						<option value="328"<?php if ( $deftrans == 328 ) { echo " selected=\"selected\""; } ?>>NBG51 - NBG-vertaling 1951</option>
						<option value="165"<?php if ( $deftrans == 165 ) { echo " selected=\"selected\""; } ?>>SV-RJ - Statenvertaling</option>
						<option value="<?php echo $deftrans; ?>">------ FRENCH ------</option>
						<option value="2367"<?php if ( $deftrans == 2367 ) { echo " selected=\"selected\""; } ?>>NFC - Nouvelle Français Courant</option>
						<option value="133"<?php if ( $deftrans == 133 ) { echo " selected=\"selected\""; } ?>>PDV2017 - Parole de Vie 2017</option>
						<option value="<?php echo $deftrans; ?>">------ GERMAN ------</option>
						<option value="57"<?php if ( $deftrans == 57 ) { echo " selected=\"selected\""; } ?>>ELB - Elberfelder 1905</option>
						<option value="51"<?php if ( $deftrans == 51 ) { echo " selected=\"selected\""; } ?>>DELUT - Lutherbibel 1912</option>
						<option value="73"<?php if ( $deftrans == 73 ) { echo " selected=\"selected\""; } ?>>HFA - Hoffnung für alle</option>
						<option value="877"<?php if ( $deftrans == 877 ) { echo " selected=\"selected\""; } ?>>NBH - NeÜ Bibel.heute</option>
						<option value="108"<?php if ( $deftrans == 108 ) { echo " selected=\"selected\""; } ?>>NGU2011 - Neue Genfer Übersetzung</option>
						<option value="157"<?php if ( $deftrans == 157 ) { echo " selected=\"selected\""; } ?>>SCH2000 - Schlachter 2000</option>
						<option value="<?php echo $deftrans; ?>">------ JAPANESE ------</option>
						<option value="83"<?php if ( $deftrans == 83 ) { echo " selected=\"selected\""; } ?>>JCB - リビングバイブル</option>
						<option value="1819"<?php if ( $deftrans == 1819 ) { echo " selected=\"selected\""; } ?>>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value="1820"<?php if ( $deftrans == 1820 ) { echo " selected=\"selected\""; } ?>>口語訳 Japanese: 聖書　口語訳</option>
						<option value="<?php echo $deftrans; ?>">------ RUSSIAN ------</option>
						<option value="400"<?php if ( $deftrans == 400 ) { echo " selected=\"selected\""; } ?>>SYNO - Синодальный Перевод</option>
						<option value="143"<?php if ( $deftrans == 143 ) { echo " selected=\"selected\""; } ?>>НРП - Новый Русский Перевод</option>
						<option value="1999"<?php if ( $deftrans == 1999 ) { echo " selected=\"selected\""; } ?>>СРП-2 - Современный Русский Перевод</option>
						<option value="<?php echo $deftrans; ?>">------ SPANISH ------</option>
						<option value="149"<?php if ( $deftrans == 149 ) { echo " selected=\"selected\""; } ?>>RVR1960 - Biblia Reina Valera 1960</option>
						<option value="128"<?php if ( $deftrans == 128 ) { echo " selected=\"selected\""; } ?>>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value="<?php echo $deftrans; ?>">------ TURKISH ------</option>
						<option value="170"<?php if ( $deftrans == 170 ) { echo " selected=\"selected\""; } ?>>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value="<?php echo $deftrans; ?>">------ OTHER ------</option>
						<option value="6"<?php if ( $deftrans == 6 ) { echo " selected=\"selected\""; } ?>>AFR83 - Afrikaans 1983</option>
					</select>
				</td>
			</tr>
				<tr valign="top">
				<th scope="row">Focus Passage?:
					<p class="se-form-instructions">Is this the main (or one of the main) passages for this <?php echo $enmsemessaget; ?>?</p>
				</th>
				<td>
					<input name="scripture_focus" id="scripture_focus" type="checkbox" class="check" tabindex="4" />
				</td>
			</tr>
		</table>
		<br />
		<input type="hidden" name="scripture_username" value="<?php echo $_REQUEST['username']; ?>" id="scripture_username" />
		<a href="#" id="addnewscripture" class="button">Attach New Scripture Reference</a>
	<?php } else { ?>
		<h3>Edit Scripture Reference</h3>	
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Start Verse:</th>
				<td>
					<select name="scripture_start_book" id="scripture_start_book" tabindex="3">
						<option value="1" <?php if ($enmse_scripture->start_book == 1) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[1]; ?></option>
						<option value="2" <?php if ($enmse_scripture->start_book == 2) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[2]; ?></option>
						<option value="3" <?php if ($enmse_scripture->start_book == 3) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[3]; ?></option>
						<option value="4" <?php if ($enmse_scripture->start_book == 4) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[4]; ?></option>
						<option value="5" <?php if ($enmse_scripture->start_book == 5) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[5]; ?></option>
						<option value="6" <?php if ($enmse_scripture->start_book == 6) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[6]; ?></option>
						<option value="7" <?php if ($enmse_scripture->start_book == 7) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[7]; ?></option>
						<option value="8" <?php if ($enmse_scripture->start_book == 8) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[8]; ?></option>
						<option value="9" <?php if ($enmse_scripture->start_book == 9) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[9]; ?></option>
						<option value="10" <?php if ($enmse_scripture->start_book == 10) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[10]; ?></option>
						<option value="11" <?php if ($enmse_scripture->start_book == 11) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[11]; ?></option>
						<option value="12" <?php if ($enmse_scripture->start_book == 12) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[12]; ?></option>
						<option value="13" <?php if ($enmse_scripture->start_book == 13) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[13]; ?></option>
						<option value="14" <?php if ($enmse_scripture->start_book == 14) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[14]; ?></option>
						<option value="15" <?php if ($enmse_scripture->start_book == 15) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[15]; ?></option>
						<option value="16" <?php if ($enmse_scripture->start_book == 16) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[16]; ?></option>
						<option value="17" <?php if ($enmse_scripture->start_book == 17) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[17]; ?></option>
						<option value="18" <?php if ($enmse_scripture->start_book == 18) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[18]; ?></option>
						<option value="19" <?php if ($enmse_scripture->start_book == 19) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[19]; ?></option>
						<option value="20" <?php if ($enmse_scripture->start_book == 20) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[20]; ?></option>
						<option value="21" <?php if ($enmse_scripture->start_book == 21) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[21]; ?></option>
						<option value="22" <?php if ($enmse_scripture->start_book == 22) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[22]; ?></option>
						<option value="23" <?php if ($enmse_scripture->start_book == 23) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[23]; ?></option>
						<option value="24" <?php if ($enmse_scripture->start_book == 24) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[24]; ?></option>
						<option value="25" <?php if ($enmse_scripture->start_book == 25) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[25]; ?></option>
						<option value="26" <?php if ($enmse_scripture->start_book == 26) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[26]; ?></option>
						<option value="27" <?php if ($enmse_scripture->start_book == 27) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[27]; ?></option>
						<option value="28" <?php if ($enmse_scripture->start_book == 28) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[28]; ?></option>
						<option value="29" <?php if ($enmse_scripture->start_book == 29) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[29]; ?></option>
						<option value="30" <?php if ($enmse_scripture->start_book == 30) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[30]; ?></option>
						<option value="31" <?php if ($enmse_scripture->start_book == 31) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[31]; ?></option>
						<option value="32" <?php if ($enmse_scripture->start_book == 32) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[32]; ?></option>
						<option value="33" <?php if ($enmse_scripture->start_book == 33) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[33]; ?></option>
						<option value="34" <?php if ($enmse_scripture->start_book == 34) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[34]; ?></option>
						<option value="35" <?php if ($enmse_scripture->start_book == 35) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[35]; ?></option>
						<option value="36" <?php if ($enmse_scripture->start_book == 36) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[36]; ?></option>
						<option value="37" <?php if ($enmse_scripture->start_book == 37) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[37]; ?></option>
						<option value="38" <?php if ($enmse_scripture->start_book == 38) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[38]; ?></option>
						<option value="39" <?php if ($enmse_scripture->start_book == 39) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[39]; ?></option>
						<option value="40" <?php if ($enmse_scripture->start_book == 40) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[40]; ?></option>
						<option value="41" <?php if ($enmse_scripture->start_book == 41) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[41]; ?></option>
						<option value="42" <?php if ($enmse_scripture->start_book == 42) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[42]; ?></option>
						<option value="43" <?php if ($enmse_scripture->start_book == 43) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[43]; ?></option>
						<option value="44" <?php if ($enmse_scripture->start_book == 44) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[44]; ?></option>
						<option value="45" <?php if ($enmse_scripture->start_book == 45) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[45]; ?></option>
						<option value="46" <?php if ($enmse_scripture->start_book == 46) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[46]; ?></option>
						<option value="47" <?php if ($enmse_scripture->start_book == 47) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[47]; ?></option>
						<option value="48" <?php if ($enmse_scripture->start_book == 48) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[48]; ?></option>
						<option value="49" <?php if ($enmse_scripture->start_book == 49) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[49]; ?></option>
						<option value="50" <?php if ($enmse_scripture->start_book == 50) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[50]; ?></option>
						<option value="51" <?php if ($enmse_scripture->start_book == 51) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[51]; ?></option>
						<option value="52" <?php if ($enmse_scripture->start_book == 52) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[52]; ?></option>
						<option value="53" <?php if ($enmse_scripture->start_book == 53) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[53]; ?></option>
						<option value="54" <?php if ($enmse_scripture->start_book == 54) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[54]; ?></option>
						<option value="55" <?php if ($enmse_scripture->start_book == 55) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[55]; ?></option>
						<option value="56" <?php if ($enmse_scripture->start_book == 56) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[56]; ?></option>
						<option value="57" <?php if ($enmse_scripture->start_book == 57) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[57]; ?></option>
						<option value="58" <?php if ($enmse_scripture->start_book == 58) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[58]; ?></option>
						<option value="59" <?php if ($enmse_scripture->start_book == 59) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[59]; ?></option>
						<option value="60" <?php if ($enmse_scripture->start_book == 60) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[60]; ?></option>
						<option value="61" <?php if ($enmse_scripture->start_book == 61) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[61]; ?></option>
						<option value="62" <?php if ($enmse_scripture->start_book == 62) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[62]; ?>/option>
						<option value="63" <?php if ($enmse_scripture->start_book == 63) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[63]; ?></option>
						<option value="64" <?php if ($enmse_scripture->start_book == 64) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[64]; ?></option>
						<option value="65" <?php if ($enmse_scripture->start_book == 65) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[65]; ?></option>
						<option value="66" <?php if ($enmse_scripture->start_book == 66) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[66]; ?></option>
					</select>
					<input id='scripture_start_chapter' name='scripture_start_chapter' type='text' value='<?php echo $enmse_scripture->start_chapter; ?>' tabindex="2" size="10" style="color: #000" /> :
					<input id='scripture_start_verse' name='scripture_start_verse' type='text' value='<?php echo $enmse_scripture->start_verse; ?>' tabindex="2" size="10" style="color: #000" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">End Verse:</th>
				<td>
					<select name="scripture_end_book" id="scripture_end_book" tabindex="3" class="enmse-disabled" disabled>
						<option value="1" <?php if ($enmse_scripture->start_book == 1) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[1]; ?></option>
						<option value="2" <?php if ($enmse_scripture->start_book == 2) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[2]; ?></option>
						<option value="3" <?php if ($enmse_scripture->start_book == 3) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[3]; ?></option>
						<option value="4" <?php if ($enmse_scripture->start_book == 4) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[4]; ?></option>
						<option value="5" <?php if ($enmse_scripture->start_book == 5) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[5]; ?></option>
						<option value="6" <?php if ($enmse_scripture->start_book == 6) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[6]; ?></option>
						<option value="7" <?php if ($enmse_scripture->start_book == 7) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[7]; ?></option>
						<option value="8" <?php if ($enmse_scripture->start_book == 8) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[8]; ?></option>
						<option value="9" <?php if ($enmse_scripture->start_book == 9) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[9]; ?></option>
						<option value="10" <?php if ($enmse_scripture->start_book == 10) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[10]; ?></option>
						<option value="11" <?php if ($enmse_scripture->start_book == 11) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[11]; ?></option>
						<option value="12" <?php if ($enmse_scripture->start_book == 12) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[12]; ?></option>
						<option value="13" <?php if ($enmse_scripture->start_book == 13) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[13]; ?></option>
						<option value="14" <?php if ($enmse_scripture->start_book == 14) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[14]; ?></option>
						<option value="15" <?php if ($enmse_scripture->start_book == 15) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[15]; ?></option>
						<option value="16" <?php if ($enmse_scripture->start_book == 16) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[16]; ?></option>
						<option value="17" <?php if ($enmse_scripture->start_book == 17) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[17]; ?></option>
						<option value="18" <?php if ($enmse_scripture->start_book == 18) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[18]; ?></option>
						<option value="19" <?php if ($enmse_scripture->start_book == 19) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[19]; ?></option>
						<option value="20" <?php if ($enmse_scripture->start_book == 20) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[20]; ?></option>
						<option value="21" <?php if ($enmse_scripture->start_book == 21) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[21]; ?></option>
						<option value="22" <?php if ($enmse_scripture->start_book == 22) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[22]; ?></option>
						<option value="23" <?php if ($enmse_scripture->start_book == 23) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[23]; ?></option>
						<option value="24" <?php if ($enmse_scripture->start_book == 24) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[24]; ?></option>
						<option value="25" <?php if ($enmse_scripture->start_book == 25) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[25]; ?></option>
						<option value="26" <?php if ($enmse_scripture->start_book == 26) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[26]; ?></option>
						<option value="27" <?php if ($enmse_scripture->start_book == 27) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[27]; ?></option>
						<option value="28" <?php if ($enmse_scripture->start_book == 28) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[28]; ?></option>
						<option value="29" <?php if ($enmse_scripture->start_book == 29) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[29]; ?></option>
						<option value="30" <?php if ($enmse_scripture->start_book == 30) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[30]; ?></option>
						<option value="31" <?php if ($enmse_scripture->start_book == 31) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[31]; ?></option>
						<option value="32" <?php if ($enmse_scripture->start_book == 32) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[32]; ?></option>
						<option value="33" <?php if ($enmse_scripture->start_book == 33) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[33]; ?></option>
						<option value="34" <?php if ($enmse_scripture->start_book == 34) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[34]; ?></option>
						<option value="35" <?php if ($enmse_scripture->start_book == 35) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[35]; ?></option>
						<option value="36" <?php if ($enmse_scripture->start_book == 36) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[36]; ?></option>
						<option value="37" <?php if ($enmse_scripture->start_book == 37) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[37]; ?></option>
						<option value="38" <?php if ($enmse_scripture->start_book == 38) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[38]; ?></option>
						<option value="39" <?php if ($enmse_scripture->start_book == 39) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[39]; ?></option>
						<option value="40" <?php if ($enmse_scripture->start_book == 40) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[40]; ?></option>
						<option value="41" <?php if ($enmse_scripture->start_book == 41) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[41]; ?></option>
						<option value="42" <?php if ($enmse_scripture->start_book == 42) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[42]; ?></option>
						<option value="43" <?php if ($enmse_scripture->start_book == 43) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[43]; ?></option>
						<option value="44" <?php if ($enmse_scripture->start_book == 44) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[44]; ?></option>
						<option value="45" <?php if ($enmse_scripture->start_book == 45) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[45]; ?></option>
						<option value="46" <?php if ($enmse_scripture->start_book == 46) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[46]; ?></option>
						<option value="47" <?php if ($enmse_scripture->start_book == 47) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[47]; ?></option>
						<option value="48" <?php if ($enmse_scripture->start_book == 48) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[48]; ?></option>
						<option value="49" <?php if ($enmse_scripture->start_book == 49) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[49]; ?></option>
						<option value="50" <?php if ($enmse_scripture->start_book == 50) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[50]; ?></option>
						<option value="51" <?php if ($enmse_scripture->start_book == 51) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[51]; ?></option>
						<option value="52" <?php if ($enmse_scripture->start_book == 52) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[52]; ?></option>
						<option value="53" <?php if ($enmse_scripture->start_book == 53) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[53]; ?></option>
						<option value="54" <?php if ($enmse_scripture->start_book == 54) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[54]; ?></option>
						<option value="55" <?php if ($enmse_scripture->start_book == 55) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[55]; ?></option>
						<option value="56" <?php if ($enmse_scripture->start_book == 56) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[56]; ?></option>
						<option value="57" <?php if ($enmse_scripture->start_book == 57) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[57]; ?></option>
						<option value="58" <?php if ($enmse_scripture->start_book == 58) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[58]; ?></option>
						<option value="59" <?php if ($enmse_scripture->start_book == 59) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[59]; ?></option>
						<option value="60" <?php if ($enmse_scripture->start_book == 60) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[60]; ?></option>
						<option value="61" <?php if ($enmse_scripture->start_book == 61) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[61]; ?></option>
						<option value="62" <?php if ($enmse_scripture->start_book == 62) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[62]; ?>/option>
						<option value="63" <?php if ($enmse_scripture->start_book == 63) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[63]; ?></option>
						<option value="64" <?php if ($enmse_scripture->start_book == 64) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[64]; ?></option>
						<option value="65" <?php if ($enmse_scripture->start_book == 65) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[65]; ?></option>
						<option value="66" <?php if ($enmse_scripture->start_book == 66) { ?>selected="selected"<?php } ?>><?php echo $enmse_booknames[66]; ?></option>				
					</select>
					<input id='scripture_end_chapter' name='scripture_end_chapter' type='text' value='<?php echo $enmse_scripture->start_chapter; ?>' tabindex="2" size="10" class="enmse-disabled" disabled /> :
					<input id='scripture_end_verse' name='scripture_end_verse' type='text' value='<?php echo $enmse_scripture->end_verse; ?>' tabindex="2" size="10" style="color: #000" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Translation:</th>
				<td>
					<select name="scripture_trans" id="scripture_trans" tabindex="3">
						<option value="<?php echo $enmse_scripture->trans; ?>">------ ENGLISH ------</option>
						<option value="1588"<?php if ( $enmse_scripture->trans == 1588 ) { echo " selected=\"selected\""; } ?>>AMP - Amplified Bible</option>
						<option value="12"<?php if ( $enmse_scripture->trans == 12 ) { echo " selected=\"selected\""; } ?>>ASV - American Standard Version</option>
						<option value="1713"<?php if ( $enmse_scripture->trans == 1713 ) { echo " selected=\"selected\""; } ?>>CSB - Christian Standard Bible</option>
						<option value="37"<?php if ( $enmse_scripture->trans == 37 ) { echo " selected=\"selected\""; } ?>>CEB - Common English Bible</option>
						<option value="59"<?php if ( $enmse_scripture->trans == 59 ) { echo " selected=\"selected\""; } ?>>ESV - English Standard Version</option>
						<option value="72"<?php if ( $enmse_scripture->trans == 72 ) { echo " selected=\"selected\""; } ?>>HCSB - Holman Christian Standard Bible</option>
						<option value="1359"<?php if ( $enmse_scripture->trans == 1359 ) { echo " selected=\"selected\""; } ?>>ICB - International Childrens Bible</option>
						<option value="1"<?php if ( $enmse_scripture->trans == 1 ) { echo " selected=\"selected\""; } ?>>KJV - King James Version</option>
						<option value="1171"<?php if ( $enmse_scripture->trans == 1171 ) { echo " selected=\"selected\""; } ?>>MEV - Modern English Version</option>
						<option value="97"<?php if ( $enmse_scripture->trans == 97 ) { echo " selected=\"selected\""; } ?>>MSG - The Message</option>
						<option value="100"<?php if ( $enmse_scripture->trans == 100 ) { echo " selected=\"selected\""; } ?>>NASB - New American Standard Bible</option>
						<option value="111"<?php if ( $enmse_scripture->trans == 111 ) { echo " selected=\"selected\""; } ?>>NIV - New International Version</option>
						<option value="114"<?php if ( $enmse_scripture->trans == 114 ) { echo " selected=\"selected\""; } ?>>NKJV - New King James Version</option>
						<option value="116"<?php if ( $enmse_scripture->trans == 116 ) { echo " selected=\"selected\""; } ?>>NLT - New Living Translation</option>
						<option value="2016"<?php if ( $enmse_scripture->trans == 2016 ) { echo " selected=\"selected\""; } ?>>NRSV - New Revised Standard Version</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ CHINESE ------</option>
						<option value="48"<?php if ( $enmse_scripture->trans == 48 ) { echo " selected=\"selected\""; } ?>>CUNPSS-神 - 新标点和合本, 神版</option>
						<option value="414"<?php if ( $enmse_scripture->trans == 414 ) { echo " selected=\"selected\""; }  ?>>CUNP-上帝 - 新標點和合本, 神版</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ CZECH ------</option>
						<option value="15"<?php if ( $enmse_scripture->trans == 15 ) { echo " selected=\"selected\""; } ?>>B21 - Bible 21</option>
						<option value="162"<?php if ( $enmse_scripture->trans == 162 ) { echo " selected=\"selected\""; } ?>>BCZ - Slovo na cestu</option>
						<option value="44"<?php if ( $enmse_scripture->trans == 44 ) { echo " selected=\"selected\""; } ?>>BKR - Bible Kralica 1613</option>
						<option value="509"<?php if ( $enmse_scripture->trans == 509 ) { echo " selected=\"selected\""; } ?>>CSP - Cesky studijni preklad</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ DUTCH ------</option>
						<option value="1276"<?php if ( $enmse_scripture->trans == 1276 ) { echo " selected=\"selected\""; } ?>>BB - BasisBijbel</option>
						<option value="1990"<?php if ( $enmse_scripture->trans == 1990 ) { echo " selected=\"selected\""; } ?>>HSV - Herziene Statenvertaling</option>
						<option value="75"<?php if ( $enmse_scripture->trans == 75 ) { echo " selected=\"selected\""; } ?>>HTB - Het Boek</option>
						<option value="328"<?php if ( $enmse_scripture->trans == 328 ) { echo " selected=\"selected\""; } ?>>NBG51 - NBG-vertaling 1951</option>
						<option value="165"<?php if ( $enmse_scripture->trans == 165 ) { echo " selected=\"selected\""; } ?>>SV-RJ - Statenvertaling</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ FRENCH ------</option>
						<option value="2367"<?php if ( $enmse_scripture->trans == 2367 ) { echo " selected=\"selected\""; } ?>>NFC - Nouvelle Français Courant</option>
						<option value="133"<?php if ( $enmse_scripture->trans == 133 ) { echo " selected=\"selected\""; } ?>>PDV2017 - Parole de Vie 2017</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ GERMAN ------</option>
						<option value="57"<?php if ( $enmse_scripture->trans == 57 ) { echo " selected=\"selected\""; } ?>>ELB - Elberfelder 1905</option>
						<option value="51"<?php if ( $enmse_scripture->trans == 51 ) { echo " selected=\"selected\""; } ?>>DELUT - Lutherbibel 1912</option>
						<option value="73"<?php if ( $enmse_scripture->trans == 73 ) { echo " selected=\"selected\""; } ?>>HFA - Hoffnung für alle</option>
						<option value="877"<?php if ( $enmse_scripture->trans == 877 ) { echo " selected=\"selected\""; } ?>>NBH - NeÜ Bibel.heute</option>
						<option value="108"<?php if ( $enmse_scripture->trans == 108 ) { echo " selected=\"selected\""; } ?>>NGU2011 - Neue Genfer Übersetzung</option>
						<option value="157"<?php if ( $enmse_scripture->trans == 157 ) { echo " selected=\"selected\""; } ?>>SCH2000 - Schlachter 2000</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ JAPANESE ------</option>
						<option value="83"<?php if ( $enmse_scripture->trans == 83 ) { echo " selected=\"selected\""; } ?>>JCB - リビングバイブル</option>
						<option value="1819"<?php if ( $enmse_scripture->trans == 1819 ) { echo " selected=\"selected\""; } ?>>新共同訳 Seisho Shinkyoudoyaku 聖書 新共同訳</option>
						<option value="1820"<?php if ( $enmse_scripture->trans == 1820 ) { echo " selected=\"selected\""; } ?>>口語訳 Japanese: 聖書　口語訳</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ RUSSIAN ------</option>
						<option value="400"<?php if ( $enmse_scripture->trans == 400 ) { echo " selected=\"selected\""; } ?>>SYNO - Синодальный Перевод</option>
						<option value="143"<?php if ( $enmse_scripture->trans == 143 ) { echo " selected=\"selected\""; } ?>>НРП - Новый Русский Перевод</option>
						<option value="1999"<?php if ( $enmse_scripture->trans == 1999 ) { echo " selected=\"selected\""; } ?>>СРП-2 - Современный Русский Перевод</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ SPANISH ------</option>
						<option value="149"<?php if ( $enmse_scripture->trans == 149 ) { echo " selected=\"selected\""; } ?>>RVR1960 - Biblia Reina Valera 1960</option>
						<option value="128"<?php if ( $enmse_scripture->trans == 128 ) { echo " selected=\"selected\""; } ?>>NVI - La Santa Biblia, Nueva Version Internacional</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ TURKISH ------</option>
						<option value="170"<?php if ( $enmse_scripture->trans == 170 ) { echo " selected=\"selected\""; } ?>>TCL02 - Kutsal Kitap Yeni Ceviri</option>
						<option value="<?php echo $enmse_scripture->trans; ?>">------ OTHER ------</option>
						<option value="6"<?php if ( $enmse_scripture->trans == 6 ) { echo " selected=\"selected\""; } ?>>AFR83 - Afrikaans 1983</option>
					</select>
				</td>
			</tr>
				<tr valign="top">
				<th scope="row">Focus Passage?:
					<p class="se-form-instructions">Is this the main (or one of the main) passages for this <?php echo $enmsemessaget; ?>?</p>
				</th>
				<td>
					<input name="scripture_focus" id="scripture_focus" type="checkbox" class="check" tabindex="4" <?php if ( $enmse_scripture->focus == 1 ) { echo "checked=\"checked\""; }; ?> />
				</td>
			</tr>
		</table>
		<br />
		<input type="hidden" name="scripture_username" value="<?php echo $_REQUEST['username']; ?>" id="scripture_username" />
		<input type="hidden" name="scripture_id" value="<?php echo $enmse_scripture->scripture_id; ?>" id="scripture_id" />
		<a href="#" id="editscripture" class="button">Save Changes</a>
	<?php } ?>
<?php } else {
	exit("Access Denied");
} die(); ?>