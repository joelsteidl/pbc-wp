<?php /* ----- Series Engine - Edit a scripture straight from the Messages admin page ----- */

	require '../../../../../wp-blog-header.php'; // ADJUST THIS PATH if using a non-standard WordPress install
	header('HTTP/1.1 200 OK');

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

		if ( isset($_GET['update']) && $_GET['update'] == 1 ) {
			$enmse_start_book = strip_tags($_GET['start_book']);
			$enmse_start_chapter = strip_tags($_GET['start_chapter']);
			$enmse_start_verse = strip_tags($_GET['start_verse']);
			$enmse_end_verse = strip_tags($_GET['end_verse']);
			$enmse_trans = strip_tags($_GET['trans']);
			$enmse_focus = strip_tags($_GET['focus']);
			$enmse_scripture_username = strip_tags($_GET['username']);
			$enmse_message_id = strip_tags($_GET['message_id']);
			$enmse_scripture_id = strip_tags($_GET['scripture_id']);

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
			}

			$enmse_findthescripturesql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " WHERE scripture_id = %d"; 
			$enmse_findthescripture = $wpdb->prepare( $enmse_findthescripturesql, $enmse_scripture_id );
			$enmse_scripture = $wpdb->get_row( $enmse_findthescripture, OBJECT );	
		} else {
			$enmse_scripture_id = strip_tags($_GET['scripture_id']);

			$enmse_findthescripturesql = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " WHERE scripture_id = %d"; 
			$enmse_findthescripture = $wpdb->prepare( $enmse_findthescripturesql, $enmse_scripture_id );
			$enmse_scripture = $wpdb->get_row( $enmse_findthescripture, OBJECT );
		}

?>
<?php if ($_POST) { ?>
<?php } else { ?>
	<?php if ( isset($_GET['done']) ) { ?>
		<h3>Add a New Scripture Reference</h3>		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Start Verse:</th>
				<td>
					<select name="scripture_start_book" id="scripture_start_book" tabindex="3">
						<option value="1">Genesis</option>
						<option value="2">Exodus</option>
						<option value="3">Leviticus</option>
						<option value="4">Numbers</option>
						<option value="5">Deuteronomy</option>
						<option value="6">Joshua</option>
						<option value="7">Judges</option>
						<option value="8">Ruth</option>
						<option value="9">1 Samuel</option>
						<option value="10">2 Samuel</option>
						<option value="11">1 Kings</option>
						<option value="12">2 Kings</option>
						<option value="13">1 Chronicles</option>
						<option value="14">2 Chronicles</option>
						<option value="15">Ezra</option>
						<option value="16">Nehemiah</option>
						<option value="17">Esther</option>
						<option value="18">Job</option>
						<option value="19">Psalms</option>
						<option value="20">Proverbs</option>
						<option value="21">Ecclesiastes</option>
						<option value="22">Song of Solomon</option>
						<option value="23">Isaiah</option>
						<option value="24">Jeremiah</option>
						<option value="25">Lamentations</option>
						<option value="26">Ezekiel</option>
						<option value="27">Daniel</option>
						<option value="28">Hosea</option>
						<option value="29">Joel</option>
						<option value="30">Amos</option>
						<option value="31">Obadiah</option>
						<option value="32">Jonah</option>
						<option value="33">Micah</option>
						<option value="34">Nahum</option>
						<option value="35">Habakkuk</option>
						<option value="36">Zephaniah</option>
						<option value="37">Haggai</option>
						<option value="38">Zechariah</option>
						<option value="39">Malachi</option>
						<option value="40">Matthew</option>
						<option value="41">Mark</option>
						<option value="42">Luke</option>
						<option value="43">John</option>
						<option value="44">Acts</option>
						<option value="45">Romans</option>
						<option value="46">1 Corinthians</option>
						<option value="47">2 Corinthians</option>
						<option value="48">Galatians</option>
						<option value="49">Ephesians</option>
						<option value="50">Philippians</option>
						<option value="51">Colossians</option>
						<option value="52">1 Thessalonians</option>
						<option value="53">2 Thessalonians</option>
						<option value="54">1 Timothy</option>
						<option value="55">2 Timothy</option>
						<option value="56">Titus</option>
						<option value="57">Philemon</option>
						<option value="58">Hebrews</option>
						<option value="59">James</option>
						<option value="60">1 Peter</option>
						<option value="61">2 Peter</option>
						<option value="62">1 John</option>
						<option value="63">2 John</option>
						<option value="64">3 John</option>
						<option value="65">Jude</option>
						<option value="66">Revelation</option>
					</select>
					<input id='scripture_start_chapter' name='scripture_start_chapter' type='text' value='Chapter' tabindex="2" size="10" /> :
					<input id='scripture_start_verse' name='scripture_start_verse' type='text' value='Verse' tabindex="2" size="10" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">End Verse:</th>
				<td>
					<select name="scripture_end_book" id="scripture_end_book" tabindex="3" class="enmse-disabled" disabled>
						<option value="1">Genesis</option>
						<option value="2">Exodus</option>
						<option value="3">Leviticus</option>
						<option value="4">Numbers</option>
						<option value="5">Deuteronomy</option>
						<option value="6">Joshua</option>
						<option value="7">Judges</option>
						<option value="8">Ruth</option>
						<option value="9">1 Samuel</option>
						<option value="10">2 Samuel</option>
						<option value="11">1 Kings</option>
						<option value="12">2 Kings</option>
						<option value="13">1 Chronicles</option>
						<option value="14">2 Chronicles</option>
						<option value="15">Ezra</option>
						<option value="16">Nehemiah</option>
						<option value="17">Esther</option>
						<option value="18">Job</option>
						<option value="19">Psalms</option>
						<option value="20">Proverbs</option>
						<option value="21">Ecclesiastes</option>
						<option value="22">Song of Solomon</option>
						<option value="23">Isaiah</option>
						<option value="24">Jeremiah</option>
						<option value="25">Lamentations</option>
						<option value="26">Ezekiel</option>
						<option value="27">Daniel</option>
						<option value="28">Hosea</option>
						<option value="29">Joel</option>
						<option value="30">Amos</option>
						<option value="31">Obadiah</option>
						<option value="32">Jonah</option>
						<option value="33">Micah</option>
						<option value="34">Nahum</option>
						<option value="35">Habakkuk</option>
						<option value="36">Zephaniah</option>
						<option value="37">Haggai</option>
						<option value="38">Zechariah</option>
						<option value="39">Malachi</option>
						<option value="40">Matthew</option>
						<option value="41">Mark</option>
						<option value="42">Luke</option>
						<option value="43">John</option>
						<option value="44">Acts</option>
						<option value="45">Romans</option>
						<option value="46">1 Corinthians</option>
						<option value="47">2 Corinthians</option>
						<option value="48">Galatians</option>
						<option value="49">Ephesians</option>
						<option value="50">Philippians</option>
						<option value="51">Colossians</option>
						<option value="52">1 Thessalonians</option>
						<option value="53">2 Thessalonians</option>
						<option value="54">1 Timothy</option>
						<option value="55">2 Timothy</option>
						<option value="56">Titus</option>
						<option value="57">Philemon</option>
						<option value="58">Hebrews</option>
						<option value="59">James</option>
						<option value="60">1 Peter</option>
						<option value="61">2 Peter</option>
						<option value="62">1 John</option>
						<option value="63">2 John</option>
						<option value="64">3 John</option>
						<option value="65">Jude</option>
						<option value="66">Revelation</option>
					</select>
					<input id='scripture_end_chapter' name='scripture_end_chapter' type='text' value='Chapter' tabindex="2" size="10" class="enmse-disabled" disabled /> :
					<input id='scripture_end_verse' name='scripture_end_verse' type='text' value='Verse' tabindex="2" size="10" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Translation:</th>
				<td>
					<select name="scripture_trans" id="scripture_trans" tabindex="3">
						<option value="1588"<?php if ( $deftrans == 1588 ) { echo " selected=\"selected\""; } ?>>AMP - Amplified Bible</option>
						<option value="12"<?php if ( $deftrans == 12 ) { echo " selected=\"selected\""; } ?>>ASV - American Standard Version</option>
						<option value="1713"<?php if ( $deftrans == 1713 ) { echo " selected=\"selected\""; } ?>>CSB - Christian Standard Bible</option>
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
						<option value="<?php echo $deftrans; ?>">-------------</option>
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
		<input type="hidden" name="scripture_username" value="<?php echo $_GET['username']; ?>" id="scripture_username" />
		<a href="#" id="addnewscripture" class="button">Attach New Scripture Reference</a>
	<?php } else { ?>
		<h3>Edit Scripture Reference</h3>	
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Start Verse:</th>
				<td>
					<select name="scripture_start_book" id="scripture_start_book" tabindex="3">
						<option value="1" <?php if ($enmse_scripture->start_book == 1) { ?>selected="selected"<?php } ?>>Genesis</option>
						<option value="2" <?php if ($enmse_scripture->start_book == 2) { ?>selected="selected"<?php } ?>>Exodus</option>
						<option value="3" <?php if ($enmse_scripture->start_book == 3) { ?>selected="selected"<?php } ?>>Leviticus</option>
						<option value="4" <?php if ($enmse_scripture->start_book == 4) { ?>selected="selected"<?php } ?>>Numbers</option>
						<option value="5" <?php if ($enmse_scripture->start_book == 5) { ?>selected="selected"<?php } ?>>Deuteronomy</option>
						<option value="6" <?php if ($enmse_scripture->start_book == 6) { ?>selected="selected"<?php } ?>>Joshua</option>
						<option value="7" <?php if ($enmse_scripture->start_book == 7) { ?>selected="selected"<?php } ?>>Judges</option>
						<option value="8" <?php if ($enmse_scripture->start_book == 8) { ?>selected="selected"<?php } ?>>Ruth</option>
						<option value="9" <?php if ($enmse_scripture->start_book == 9) { ?>selected="selected"<?php } ?>>1 Samuel</option>
						<option value="10" <?php if ($enmse_scripture->start_book == 10) { ?>selected="selected"<?php } ?>>2 Samuel</option>
						<option value="11" <?php if ($enmse_scripture->start_book == 11) { ?>selected="selected"<?php } ?>>1 Kings</option>
						<option value="12" <?php if ($enmse_scripture->start_book == 12) { ?>selected="selected"<?php } ?>>2 Kings</option>
						<option value="13" <?php if ($enmse_scripture->start_book == 13) { ?>selected="selected"<?php } ?>>1 Chronicles</option>
						<option value="14" <?php if ($enmse_scripture->start_book == 14) { ?>selected="selected"<?php } ?>>2 Chronicles</option>
						<option value="15" <?php if ($enmse_scripture->start_book == 15) { ?>selected="selected"<?php } ?>>Ezra</option>
						<option value="16" <?php if ($enmse_scripture->start_book == 16) { ?>selected="selected"<?php } ?>>Nehemiah</option>
						<option value="17" <?php if ($enmse_scripture->start_book == 17) { ?>selected="selected"<?php } ?>>Esther</option>
						<option value="18" <?php if ($enmse_scripture->start_book == 18) { ?>selected="selected"<?php } ?>>Job</option>
						<option value="19" <?php if ($enmse_scripture->start_book == 19) { ?>selected="selected"<?php } ?>>Psalms</option>
						<option value="20" <?php if ($enmse_scripture->start_book == 20) { ?>selected="selected"<?php } ?>>Proverbs</option>
						<option value="21" <?php if ($enmse_scripture->start_book == 21) { ?>selected="selected"<?php } ?>>Ecclesiastes</option>
						<option value="22" <?php if ($enmse_scripture->start_book == 22) { ?>selected="selected"<?php } ?>>Song of Solomon</option>
						<option value="23" <?php if ($enmse_scripture->start_book == 23) { ?>selected="selected"<?php } ?>>Isaiah</option>
						<option value="24" <?php if ($enmse_scripture->start_book == 24) { ?>selected="selected"<?php } ?>>Jeremiah</option>
						<option value="25" <?php if ($enmse_scripture->start_book == 25) { ?>selected="selected"<?php } ?>>Lamentations</option>
						<option value="26" <?php if ($enmse_scripture->start_book == 26) { ?>selected="selected"<?php } ?>>Ezekiel</option>
						<option value="27" <?php if ($enmse_scripture->start_book == 27) { ?>selected="selected"<?php } ?>>Daniel</option>
						<option value="28" <?php if ($enmse_scripture->start_book == 28) { ?>selected="selected"<?php } ?>>Hosea</option>
						<option value="29" <?php if ($enmse_scripture->start_book == 29) { ?>selected="selected"<?php } ?>>Joel</option>
						<option value="30" <?php if ($enmse_scripture->start_book == 30) { ?>selected="selected"<?php } ?>>Amos</option>
						<option value="31" <?php if ($enmse_scripture->start_book == 31) { ?>selected="selected"<?php } ?>>Obadiah</option>
						<option value="32" <?php if ($enmse_scripture->start_book == 32) { ?>selected="selected"<?php } ?>>Jonah</option>
						<option value="33" <?php if ($enmse_scripture->start_book == 33) { ?>selected="selected"<?php } ?>>Micah</option>
						<option value="34" <?php if ($enmse_scripture->start_book == 34) { ?>selected="selected"<?php } ?>>Nahum</option>
						<option value="35" <?php if ($enmse_scripture->start_book == 35) { ?>selected="selected"<?php } ?>>Habakkuk</option>
						<option value="36" <?php if ($enmse_scripture->start_book == 36) { ?>selected="selected"<?php } ?>>Zephaniah</option>
						<option value="37" <?php if ($enmse_scripture->start_book == 37) { ?>selected="selected"<?php } ?>>Haggai</option>
						<option value="38" <?php if ($enmse_scripture->start_book == 38) { ?>selected="selected"<?php } ?>>Zechariah</option>
						<option value="39" <?php if ($enmse_scripture->start_book == 39) { ?>selected="selected"<?php } ?>>Malachi</option>
						<option value="40" <?php if ($enmse_scripture->start_book == 40) { ?>selected="selected"<?php } ?>>Matthew</option>
						<option value="41" <?php if ($enmse_scripture->start_book == 41) { ?>selected="selected"<?php } ?>>Mark</option>
						<option value="42" <?php if ($enmse_scripture->start_book == 42) { ?>selected="selected"<?php } ?>>Luke</option>
						<option value="43" <?php if ($enmse_scripture->start_book == 43) { ?>selected="selected"<?php } ?>>John</option>
						<option value="44" <?php if ($enmse_scripture->start_book == 44) { ?>selected="selected"<?php } ?>>Acts</option>
						<option value="45" <?php if ($enmse_scripture->start_book == 45) { ?>selected="selected"<?php } ?>>Romans</option>
						<option value="46" <?php if ($enmse_scripture->start_book == 46) { ?>selected="selected"<?php } ?>>1 Corinthians</option>
						<option value="47" <?php if ($enmse_scripture->start_book == 47) { ?>selected="selected"<?php } ?>>2 Corinthians</option>
						<option value="48" <?php if ($enmse_scripture->start_book == 48) { ?>selected="selected"<?php } ?>>Galatians</option>
						<option value="49" <?php if ($enmse_scripture->start_book == 49) { ?>selected="selected"<?php } ?>>Ephesians</option>
						<option value="50" <?php if ($enmse_scripture->start_book == 50) { ?>selected="selected"<?php } ?>>Philippians</option>
						<option value="51" <?php if ($enmse_scripture->start_book == 51) { ?>selected="selected"<?php } ?>>Colossians</option>
						<option value="52" <?php if ($enmse_scripture->start_book == 52) { ?>selected="selected"<?php } ?>>1 Thessalonians</option>
						<option value="53" <?php if ($enmse_scripture->start_book == 53) { ?>selected="selected"<?php } ?>>2 Thessalonians</option>
						<option value="54" <?php if ($enmse_scripture->start_book == 54) { ?>selected="selected"<?php } ?>>1 Timothy</option>
						<option value="55" <?php if ($enmse_scripture->start_book == 55) { ?>selected="selected"<?php } ?>>2 Timothy</option>
						<option value="56" <?php if ($enmse_scripture->start_book == 56) { ?>selected="selected"<?php } ?>>Titus</option>
						<option value="57" <?php if ($enmse_scripture->start_book == 57) { ?>selected="selected"<?php } ?>>Philemon</option>
						<option value="58" <?php if ($enmse_scripture->start_book == 58) { ?>selected="selected"<?php } ?>>Hebrews</option>
						<option value="59" <?php if ($enmse_scripture->start_book == 59) { ?>selected="selected"<?php } ?>>James</option>
						<option value="60" <?php if ($enmse_scripture->start_book == 60) { ?>selected="selected"<?php } ?>>1 Peter</option>
						<option value="61" <?php if ($enmse_scripture->start_book == 61) { ?>selected="selected"<?php } ?>>2 Peter</option>
						<option value="62" <?php if ($enmse_scripture->start_book == 62) { ?>selected="selected"<?php } ?>>1 John</option>
						<option value="63" <?php if ($enmse_scripture->start_book == 63) { ?>selected="selected"<?php } ?>>2 John</option>
						<option value="64" <?php if ($enmse_scripture->start_book == 64) { ?>selected="selected"<?php } ?>>3 John</option>
						<option value="65" <?php if ($enmse_scripture->start_book == 65) { ?>selected="selected"<?php } ?>>Jude</option>
						<option value="66" <?php if ($enmse_scripture->start_book == 66) { ?>selected="selected"<?php } ?>>Revelation</option>
					</select>
					<input id='scripture_start_chapter' name='scripture_start_chapter' type='text' value='<?php echo $enmse_scripture->start_chapter; ?>' tabindex="2" size="10" style="color: #000" /> :
					<input id='scripture_start_verse' name='scripture_start_verse' type='text' value='<?php echo $enmse_scripture->start_verse; ?>' tabindex="2" size="10" style="color: #000" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">End Verse:</th>
				<td>
					<select name="scripture_end_book" id="scripture_end_book" tabindex="3" class="enmse-disabled" disabled>
						<option value="1" <?php if ($enmse_scripture->start_book == 1) { ?>selected="selected"<?php } ?>>Genesis</option>
						<option value="2" <?php if ($enmse_scripture->start_book == 2) { ?>selected="selected"<?php } ?>>Exodus</option>
						<option value="3" <?php if ($enmse_scripture->start_book == 3) { ?>selected="selected"<?php } ?>>Leviticus</option>
						<option value="4" <?php if ($enmse_scripture->start_book == 4) { ?>selected="selected"<?php } ?>>Numbers</option>
						<option value="5" <?php if ($enmse_scripture->start_book == 5) { ?>selected="selected"<?php } ?>>Deuteronomy</option>
						<option value="6" <?php if ($enmse_scripture->start_book == 6) { ?>selected="selected"<?php } ?>>Joshua</option>
						<option value="7" <?php if ($enmse_scripture->start_book == 7) { ?>selected="selected"<?php } ?>>Judges</option>
						<option value="8" <?php if ($enmse_scripture->start_book == 8) { ?>selected="selected"<?php } ?>>Ruth</option>
						<option value="9" <?php if ($enmse_scripture->start_book == 9) { ?>selected="selected"<?php } ?>>1 Samuel</option>
						<option value="10" <?php if ($enmse_scripture->start_book == 10) { ?>selected="selected"<?php } ?>>2 Samuel</option>
						<option value="11" <?php if ($enmse_scripture->start_book == 11) { ?>selected="selected"<?php } ?>>1 Kings</option>
						<option value="12" <?php if ($enmse_scripture->start_book == 12) { ?>selected="selected"<?php } ?>>2 Kings</option>
						<option value="13" <?php if ($enmse_scripture->start_book == 13) { ?>selected="selected"<?php } ?>>1 Chronicles</option>
						<option value="14" <?php if ($enmse_scripture->start_book == 14) { ?>selected="selected"<?php } ?>>2 Chronicles</option>
						<option value="15" <?php if ($enmse_scripture->start_book == 15) { ?>selected="selected"<?php } ?>>Ezra</option>
						<option value="16" <?php if ($enmse_scripture->start_book == 16) { ?>selected="selected"<?php } ?>>Nehemiah</option>
						<option value="17" <?php if ($enmse_scripture->start_book == 17) { ?>selected="selected"<?php } ?>>Esther</option>
						<option value="18" <?php if ($enmse_scripture->start_book == 18) { ?>selected="selected"<?php } ?>>Job</option>
						<option value="19" <?php if ($enmse_scripture->start_book == 19) { ?>selected="selected"<?php } ?>>Psalms</option>
						<option value="20" <?php if ($enmse_scripture->start_book == 20) { ?>selected="selected"<?php } ?>>Proverbs</option>
						<option value="21" <?php if ($enmse_scripture->start_book == 21) { ?>selected="selected"<?php } ?>>Ecclesiastes</option>
						<option value="22" <?php if ($enmse_scripture->start_book == 22) { ?>selected="selected"<?php } ?>>Song of Solomon</option>
						<option value="23" <?php if ($enmse_scripture->start_book == 23) { ?>selected="selected"<?php } ?>>Isaiah</option>
						<option value="24" <?php if ($enmse_scripture->start_book == 24) { ?>selected="selected"<?php } ?>>Jeremiah</option>
						<option value="25" <?php if ($enmse_scripture->start_book == 25) { ?>selected="selected"<?php } ?>>Lamentations</option>
						<option value="26" <?php if ($enmse_scripture->start_book == 26) { ?>selected="selected"<?php } ?>>Ezekiel</option>
						<option value="27" <?php if ($enmse_scripture->start_book == 27) { ?>selected="selected"<?php } ?>>Daniel</option>
						<option value="28" <?php if ($enmse_scripture->start_book == 28) { ?>selected="selected"<?php } ?>>Hosea</option>
						<option value="29" <?php if ($enmse_scripture->start_book == 29) { ?>selected="selected"<?php } ?>>Joel</option>
						<option value="30" <?php if ($enmse_scripture->start_book == 30) { ?>selected="selected"<?php } ?>>Amos</option>
						<option value="31" <?php if ($enmse_scripture->start_book == 31) { ?>selected="selected"<?php } ?>>Obadiah</option>
						<option value="32" <?php if ($enmse_scripture->start_book == 32) { ?>selected="selected"<?php } ?>>Jonah</option>
						<option value="33" <?php if ($enmse_scripture->start_book == 33) { ?>selected="selected"<?php } ?>>Micah</option>
						<option value="34" <?php if ($enmse_scripture->start_book == 34) { ?>selected="selected"<?php } ?>>Nahum</option>
						<option value="35" <?php if ($enmse_scripture->start_book == 35) { ?>selected="selected"<?php } ?>>Habakkuk</option>
						<option value="36" <?php if ($enmse_scripture->start_book == 36) { ?>selected="selected"<?php } ?>>Zephaniah</option>
						<option value="37" <?php if ($enmse_scripture->start_book == 37) { ?>selected="selected"<?php } ?>>Haggai</option>
						<option value="38" <?php if ($enmse_scripture->start_book == 38) { ?>selected="selected"<?php } ?>>Zechariah</option>
						<option value="39" <?php if ($enmse_scripture->start_book == 39) { ?>selected="selected"<?php } ?>>Malachi</option>
						<option value="40" <?php if ($enmse_scripture->start_book == 40) { ?>selected="selected"<?php } ?>>Matthew</option>
						<option value="41" <?php if ($enmse_scripture->start_book == 41) { ?>selected="selected"<?php } ?>>Mark</option>
						<option value="42" <?php if ($enmse_scripture->start_book == 42) { ?>selected="selected"<?php } ?>>Luke</option>
						<option value="43" <?php if ($enmse_scripture->start_book == 43) { ?>selected="selected"<?php } ?>>John</option>
						<option value="44" <?php if ($enmse_scripture->start_book == 44) { ?>selected="selected"<?php } ?>>Acts</option>
						<option value="45" <?php if ($enmse_scripture->start_book == 45) { ?>selected="selected"<?php } ?>>Romans</option>
						<option value="46" <?php if ($enmse_scripture->start_book == 46) { ?>selected="selected"<?php } ?>>1 Corinthians</option>
						<option value="47" <?php if ($enmse_scripture->start_book == 47) { ?>selected="selected"<?php } ?>>2 Corinthians</option>
						<option value="48" <?php if ($enmse_scripture->start_book == 48) { ?>selected="selected"<?php } ?>>Galatians</option>
						<option value="49" <?php if ($enmse_scripture->start_book == 49) { ?>selected="selected"<?php } ?>>Ephesians</option>
						<option value="50" <?php if ($enmse_scripture->start_book == 50) { ?>selected="selected"<?php } ?>>Philippians</option>
						<option value="51" <?php if ($enmse_scripture->start_book == 51) { ?>selected="selected"<?php } ?>>Colossians</option>
						<option value="52" <?php if ($enmse_scripture->start_book == 52) { ?>selected="selected"<?php } ?>>1 Thessalonians</option>
						<option value="53" <?php if ($enmse_scripture->start_book == 53) { ?>selected="selected"<?php } ?>>2 Thessalonians</option>
						<option value="54" <?php if ($enmse_scripture->start_book == 54) { ?>selected="selected"<?php } ?>>1 Timothy</option>
						<option value="55" <?php if ($enmse_scripture->start_book == 55) { ?>selected="selected"<?php } ?>>2 Timothy</option>
						<option value="56" <?php if ($enmse_scripture->start_book == 56) { ?>selected="selected"<?php } ?>>Titus</option>
						<option value="57" <?php if ($enmse_scripture->start_book == 57) { ?>selected="selected"<?php } ?>>Philemon</option>
						<option value="58" <?php if ($enmse_scripture->start_book == 58) { ?>selected="selected"<?php } ?>>Hebrews</option>
						<option value="59" <?php if ($enmse_scripture->start_book == 59) { ?>selected="selected"<?php } ?>>James</option>
						<option value="60" <?php if ($enmse_scripture->start_book == 60) { ?>selected="selected"<?php } ?>>1 Peter</option>
						<option value="61" <?php if ($enmse_scripture->start_book == 61) { ?>selected="selected"<?php } ?>>2 Peter</option>
						<option value="62" <?php if ($enmse_scripture->start_book == 62) { ?>selected="selected"<?php } ?>>1 John</option>
						<option value="63" <?php if ($enmse_scripture->start_book == 63) { ?>selected="selected"<?php } ?>>2 John</option>
						<option value="64" <?php if ($enmse_scripture->start_book == 64) { ?>selected="selected"<?php } ?>>3 John</option>
						<option value="65" <?php if ($enmse_scripture->start_book == 65) { ?>selected="selected"<?php } ?>>Jude</option>
						<option value="66" <?php if ($enmse_scripture->start_book == 66) { ?>selected="selected"<?php } ?>>Revelation</option>					</select>
					<input id='scripture_end_chapter' name='scripture_end_chapter' type='text' value='<?php echo $enmse_scripture->start_chapter; ?>' tabindex="2" size="10" class="enmse-disabled" disabled /> :
					<input id='scripture_end_verse' name='scripture_end_verse' type='text' value='<?php echo $enmse_scripture->end_verse; ?>' tabindex="2" size="10" style="color: #000" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Translation:</th>
				<td>
					<select name="scripture_trans" id="scripture_trans" tabindex="3">
						<option value="1588" <?php if ($enmse_scripture->trans == 1588) { ?>selected="selected"<?php } ?>>AMP - Amplified Bible</option>
						<option value="12" <?php if ($enmse_scripture->trans == 12) { ?>selected="selected"<?php } ?>>ASV - American Standard Version</option>
						<option value="1713" <?php if ($enmse_scripture->trans == 1713) { ?>selected="selected"<?php } ?>>CSB - Christian Standard Bible</option>
						<option value="59" <?php if ($enmse_scripture->trans == 59) { ?>selected="selected"<?php } ?>>ESV - English Standard Version</option>
						<option value="72" <?php if ($enmse_scripture->trans == 72) { ?>selected="selected"<?php } ?>>HCSB - Holman Christian Standard Bible</option>
						<option value="1359" <?php if ($enmse_scripture->trans == 1359) { ?>selected="selected"<?php } ?>>ICB - International Childrens Bible</option>
						<option value="1" <?php if ($enmse_scripture->trans == 1) { ?>selected="selected"<?php } ?>>KJV - King James Version</option>
						<option value="1171" <?php if ($enmse_scripture->trans == 1171) { ?>selected="selected"<?php } ?>>MEV - Modern English Version</option>
						<option value="97" <?php if ($enmse_scripture->trans == 97) { ?>selected="selected"<?php } ?>>MSG - The Message</option>
						<option value="100" <?php if ($enmse_scripture->trans == 100) { ?>selected="selected"<?php } ?>>NASB - New American Standard Bible</option>
						<option value="111" <?php if ($enmse_scripture->trans == 111) { ?>selected="selected"<?php } ?>>NIV - New International Version</option>
						<option value="114" <?php if ($enmse_scripture->trans == 114) { ?>selected="selected"<?php } ?>>NKJV - New King James Version</option>
						<option value="116" <?php if ($enmse_scripture->trans == 116) { ?>selected="selected"<?php } ?>>NLT - New Living Translation</option>
						<option value="<?php echo $deftrans; ?>">-------------</option>
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
		<input type="hidden" name="scripture_username" value="<?php echo $_GET['username']; ?>" id="scripture_username" />
		<input type="hidden" name="scripture_id" value="<?php echo $enmse_scripture->scripture_id; ?>" id="scripture_id" />
		<a href="#" id="editscripture" class="button">Save Changes</a>
	<?php } ?>
<?php } ?>
<?php } else {
	exit("Access Denied");
} ?>