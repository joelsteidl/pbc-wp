<?php 

			
			// Make Sermon Browser Series Types
			$enmse_newst = array(
				'series_type_id' => '500', 
				'name' => 'Sermon Browser Content', 
				'description' => 'Content imported from the Sermon Browser plugin on this site.'
			);
			$wpdb->get_results("SELECT series_type_id FROM " . $wpdb->prefix . "se_series_types WHERE series_type_id = 500");
			if($wpdb->num_rows == 0) {
				$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newst ); 
			}
			$enmse_newsttwo = array(
				'series_type_id' => '501', 
				'name' => 'Sermon Browser Services', 
				'description' => 'Messages imported from Sermon Browser according to service time.'
			);

			$wpdb->get_results("SELECT series_type_id FROM " . $wpdb->prefix . "se_series_types WHERE series_type_id = 501");
			if($wpdb->num_rows == 0) { 
				$wpdb->insert( $wpdb->prefix . "se_series_types", $enmse_newsttwo );
			}

			// Import Sermon Browser Series
			$enmse_findsbseriessql = "SELECT * FROM " . $wpdb->prefix . "sb_series"; 
			$enmse_sbseries = $wpdb->get_results( $enmse_findsbseriessql );

			$sbscount = 0;
			if ( !empty($enmse_sbseries) ) {
				foreach ( $enmse_sbseries as $s ) {
					$id = $s->id+$poffset;
					$title = $s->name;
					$enmse_newsbs = array(
						'series_id' => $id, 
						's_title' => $title,
						'archived' => 0
					);
					$wpdb->get_results("SELECT series_id FROM " . $wpdb->prefix . "se_series WHERE series_id = " . $id);
					if($wpdb->num_rows == 0) {  
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newsbs );

						$enmse_newsbst = array(
							'series_id' => $id, 
							'series_type_id' => '500'
						); 

						$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newsbst );
						$sbscount = $sbscount+1;

					}
					
				}
			}

			if ( $sbscount == 1 ) {
				$enmse_messages[] = "<strong>" . $sbscount . " Sermon Browser Series</strong> was imported.";
			} elseif ( $sbscount > 1 ) {
				$enmse_messages[] = "<strong>" . $sbscount . " Sermon Browser Series</strong> were imported.";
			}



			// Import Sermon Browser Tags (Topics)
			$enmse_findsbtagssql = "SELECT * FROM " . $wpdb->prefix . "sb_tags"; 
			$enmse_sbtags = $wpdb->get_results( $enmse_findsbtagssql );

			$sbtcount = 0;
			if ( !empty($enmse_sbtags) ) {
				foreach ( $enmse_sbtags as $t ) {
					$id = $t->id+$poffset;
					$name = $t->name;
					$enmse_newsbt = array(
						'topic_id' => $id, 
						'name' => $name
					); 
					$wpdb->get_results("SELECT topic_id FROM " . $wpdb->prefix . "se_topics WHERE topic_id = " . $id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_topics", $enmse_newsbt );
						$sbtcount = $sbtcount+1;
					}
				}
			}

			if ( $sbtcount == 1 ) {
				$enmse_messages[] = "<strong>" . $sbtcount . " Sermon Browser Tag</strong> was imported (as a Topic).";
			} elseif ( $sbtcount > 1 ) {
				$enmse_messages[] = "<strong>" . $sbtcount . " Sermon Browser Tags</strong> were imported (as Topics).";
			}



			// Import Sermon Browser Message Tag Matches (Topics)
			$enmse_findsbtagsmsql = "SELECT * FROM " . $wpdb->prefix . "sb_sermons_tags"; 
			$enmse_sbtagsm = $wpdb->get_results( $enmse_findsbtagsmsql );

			if ( !empty($enmse_sbtagsm) ) {
				foreach ( $enmse_sbtagsm as $t ) {
					$topic_id = $t->tag_id+$poffset;
					$message_id = $t->sermon_id+$poffset;

					$enmse_newsbtm = array(
						'topic_id' => $topic_id, 
						'message_id' => $message_id
					); 
					$wpdb->get_results("SELECT topic_id FROM " . $wpdb->prefix . "se_message_topic_matches WHERE topic_id = " . $topic_id . " AND message_id = " . $message_id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_message_topic_matches", $enmse_newsbtm );
					}
				}
			}

			// Import Sermon Browser Preachers (Speakers)
			$enmse_findsbspeakerssql = "SELECT * FROM " . $wpdb->prefix . "sb_preachers"; 
			$enmse_sbspeakers = $wpdb->get_results( $enmse_findsbspeakerssql );

			$sbpcount = 0;
			if ( !empty($enmse_sbspeakers) ) {
				foreach ( $enmse_sbspeakers as $p ) {
					$id = $p->id+$poffset;
					$name = $p->name;
					$enmse_newsbp = array(
						'speaker_id' => $id, 
						'last_name' => $name
					); 
					$wpdb->get_results("SELECT speaker_id FROM " . $wpdb->prefix . "se_speakers WHERE speaker_id = " . $id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_speakers", $enmse_newsbp );
						$sbpcount = $sbpcount+1;
					}
				}
			}

			if ( $sbpcount == 1 ) {
				$enmse_messages[] = "<strong>" . $sbpcount . " Sermon Browser Preacher</strong> was imported (as a Speaker).";
			} elseif ( $sbpcount > 1 ) {
				$enmse_messages[] = "<strong>" . $sbpcount . " Sermon Browser Preachers</strong> were imported (as Speakers).";
			}



			// Import Sermon Browser Services
			$enmse_findsbservicesql = "SELECT * FROM " . $wpdb->prefix . "sb_services"; 
			$enmse_sbservices = $wpdb->get_results( $enmse_findsbservicesql );

			$sbservcount = 0;
			if ( !empty($enmse_sbservices) ) {
				foreach ( $enmse_sbservices as $sv ) {
					$id = $sv->id+$poffset+200;
					$title = $sv->name . " - " . $sv->time;
					$enmse_newsbsv = array(
						'series_id' => $id, 
						's_title' => $title,
						'archived' => 0
					); 
					$wpdb->get_results("SELECT series_id FROM " . $wpdb->prefix . "se_series WHERE series_id = " . $id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_series", $enmse_newsbsv );

						$enmse_newsbst = array(
							'series_id' => $id, 
							'series_type_id' => '501'
						); 

						$wpdb->insert( $wpdb->prefix . "se_series_type_matches", $enmse_newsbst );
						$sbservcount = $sbservcount+1;

					}
					
				}
			}

			if ( $sbservcount == 1 ) {
				$enmse_messages[] = "<strong>" . $sbservcount . " Sermon Browser Service</strong> was imported (as a Series).";
			} elseif ( $sbservcount > 1 ) {
				$enmse_messages[] = "<strong>" . $sbservcount . " Sermon Browser Services</strong> were imported (as Series).";
			}



			// Import Sermon Browser Scriptures
			$enmse_findsbscripturesql = "SELECT * FROM " . $wpdb->prefix . "sb_books_sermons"; 
			$enmse_sbscripture = $wpdb->get_results( $enmse_findsbscripturesql );

			$sbsccount = 0;
			if ( !empty($enmse_sbscripture) ) {
				foreach ( $enmse_sbscripture as $sc ) {
					if ( $sc->type == "start" ) {
						$id = $sc->id+$poffset;
						$sermon_id = $sc->sermon_id+$poffset;
						$start_chapter = $sc->chapter;
						$start_verse = $sc->verse;

						$findm = $sc->sermon_id;
						$findorder = $sc->order;

						$enmse_findotherpartsql = "SELECT * FROM " . $wpdb->prefix . "sb_books_sermons" . " WHERE type='end' AND sermon_id = %d AND `order` = %d"; 
						$enmse_findtheverse = $wpdb->prepare( $enmse_findotherpartsql, $findm, $findorder );
						$otherpart = $wpdb->get_row( $enmse_findtheverse, OBJECT );

						$end_verse = $otherpart->verse;
						$trans = $deftrans;

						if ( $sc->book_name == "Genesis" ) {
							$start_book = 1;
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
							$bookcode = "GEN";
						} elseif ( $sc->book_name == "Exodus" ) {
							$start_book = 2;
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
							$bookcode = "EXO";
						} elseif ( $sc->book_name == "Leviticus" ) {
							$start_book = 3;
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
							$bookcode = "LEV";
						} elseif ( $sc->book_name == "Numbers" ) {
							$start_book = 4;
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
							$bookcode = "NUM";
						} elseif ( $sc->book_name == "Deuteronomy" ) {
							$start_book = 5;
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
							$bookcode = "DEU";
						} elseif ( $sc->book_name == "Joshua" ) {
							$start_book = 6;
							$bookcode = "JOS";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Judges" ) {
							$start_book = 7;
							$bookcode = "JDG";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Ruth" ) {
							$start_book = 8;
							$bookcode = "RUT";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "1 Samuel" ) {
							$start_book = 9;
							$bookcode = "1SA";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "2 Samuel" ) {
							$start_book = 10;
							$bookcode = "2SA";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "1 Kings" ) {
							$start_book = 11;
							$bookcode = "1KI";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "2 Kings" ) {
							$start_book = 12;
							$bookcode = "2KI";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "1 Chronicles" ) {
							$start_book = 13;
							$bookcode = "1CH";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "2 Chronicles" ) {
							$start_book = 14;
							$bookcode = "2CH";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Ezra" ) {
							$start_book = 15;
							$bookcode = "EZR";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Nehemiah" ) {
							$start_book = 16;
							$bookcode = "NEH";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Esther" ) {
							$start_book = 17;
							$bookcode = "EST";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Job" ) {
							$start_book = 18;
							$bookcode = "JOB";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Psalms" ) {
							$start_book = 19;
							$bookcode = "PSA";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Proverbs" ) {
							$start_book = 20;
							$bookcode = "PRO";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Ecclesiastes" ) {
							$start_book = 21;
							$bookcode = "ECC";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Song of Solomon" ) {
							$start_book = 22;
							$bookcode = "SNG";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Isaiah" ) {
							$start_book = 23;
							$bookcode = "ISA";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Jeremiah" ) {
							$start_book = 24;
							$bookcode = "JER";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Lamentations" ) {
							$start_book = 25;
							$bookcode = "LAM";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Ezekiel" ) {
							$start_book = 26;
							$bookcode = "EZK";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Daniel" ) {
							$start_book = 27;
							$bookcode = "DAN";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Hosea" ) {
							$start_book = 28;
							$bookcode = "HOS";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Joel" ) {
							$start_book = 29;
							$bookcode = "JOL";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Amos" ) {
							$start_book = 30;
							$bookcode = "AMO";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Obadiah" ) {
							$start_book = 31;
							$bookcode = "OBA";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Jonah" ) {
							$start_book = 32;
							$bookcode = "JON";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Micah" ) {
							$start_book = 33;
							$bookcode = "MIC";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Nahum" ) {
							$start_book = 34;
							$bookcode = "NAM";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Habakkuk" ) {
							$start_book = 35;
							$bookcode = "HAB";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Zephaniah" ) {
							$start_book = 36;
							$bookcode = "ZEP";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Haggai" ) {
							$start_book = 37;
							$bookcode = "HAG";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Zechariah" ) {
							$start_book = 38;
							$bookcode = "ZEC";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Malachi" ) {
							$start_book = 39;
							$bookcode = "MAL";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name =="Matthew") {
							$start_book = 40;
							$bookcode = "MAT";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Mark" ) {
							$start_book = 41;
							$bookcode = "MRK";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Luke" ) {
							$start_book = 42;
							$bookcode = "LUK";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "John" ) {
							$start_book = 43;
							$bookcode = "JHN";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Acts" ) {
							$start_book = 44;
							$bookcode = "ACT";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Romans" ) {
							$start_book = 45;
							$bookcode = "ROM";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "1 Corinthians" ) {
							$start_book = 46;
							$bookcode = "1CO";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "2 Corinthians") {
							$start_book = 47;
							$bookcode = "2CO";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Galatians" ) {
							$start_book = 48;
							$bookcode = "GAL";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Ephesians" ) {
							$start_book = 49;
							$bookcode = "EPH";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Philippians" ) {
							$start_book = 50;
							$bookcode = "PHP";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Colossians" ) {
							$start_book = 51;
							$bookcode = "COL";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "1 Thessalonians" ) {
							$start_book = 52;
							$bookcode = "1TH";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "2 Thessalonians" ) {
							$start_book = 53;
							$bookcode = "2TH";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "1 Timothy" ) {
							$start_book = 54;
							$bookcode = "1TI";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "2 Timothy" ) {
							$start_book = 55;
							$bookcode = "2TI";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Titus" ) {
							$start_book = 56;
							$bookcode = "TIT";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Philemon" ) {
							$start_book = 57;
							$bookcode = "PHM";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Hebrews" ) {
							$start_book = 58;
							$bookcode = "HEB";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "James" ) {
							$start_book = 59;
							$bookcode = "JAS";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "1 Peter" ) {
							$start_book = 60;
							$bookcode = "1PE";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "2 Peter" ) {
							$start_book = 61;
							$bookcode = "2PE";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "1 John" ) {
							$start_book = 62;
							$bookcode = "1JN";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "2 John" ) {
							$start_book = 63;
							$bookcode = "2JN";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "3 John" ) {
							$start_book = 64;
							$bookcode = "3JN";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} elseif ( $sc->book_name == "Jude" ) {
							$start_book = 65;
							$bookcode = "JUD";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];;
						} elseif ( $sc->book_name == "Revelation" ) {
							$start_book = 66;
							$bookcode = "REV";
							$sb_bookname = $enmse_booknames[$start_book];
							$shortbookname = $enmse_bookabr[$start_book];
						} 

						if ( $start_verse != $end_verse ) {
							$text = $sb_bookname . " " . $start_chapter . ":" . $start_verse . "-" . $end_verse;
							$short_text = $shortbookname . " " . $start_chapter . ":" . $start_verse . "-" . $end_verse;
							$link = "https://bible.com/bible/" . $trans . "/" . $bookcode . "." . $start_chapter . "." . $start_verse . "-" . $end_verse;
						} else {
							$text = $sb_bookname . " " . $start_chapter . ":" . $start_verse;
							$short_text = $shortbookname . " " . $start_chapter . ":" . $start_verse;
							$link = "https://bible.com/bible/" . $trans . "/" . $bookcode . "." . $start_chapter . "." . $start_verse;
						}                                       
						
						$enmse_scripture = array(
							'scripture_id' => $id,
							'start_book' => $start_book, 
							'start_chapter' => $start_chapter,
							'start_verse' => $start_verse,
							'end_verse' => $end_verse,
							'trans' => $trans,
							'focus' => '1',
							'text' => $text,
							'short_text' => $short_text,
							'link' => $link
							); 
						$wpdb->get_results("SELECT scripture_id FROM " . $wpdb->prefix . "se_scriptures WHERE scripture_id = " . $id);
						if($wpdb->num_rows == 0) { 
							$wpdb->insert( $wpdb->prefix . "se_scriptures", $enmse_scripture );
							$sbsccount = $sbsccount + 1;
						}
				
						// Add file relation in the DB
						$enmse_newsbscmm = array(
							'message_id' => $sermon_id, 
							'scripture_id' => $id
						); 
						$wpdb->get_results("SELECT scripture_id FROM " . $wpdb->prefix . "se_scripture_message_matches WHERE scripture_id = " . $id);
						if($wpdb->num_rows == 0) { 
							$wpdb->insert( $wpdb->prefix . "se_scripture_message_matches", $enmse_newsbscmm );
						}


						$enmse_preparreddscmsql = "SELECT bm_match_id FROM " . $wpdb->prefix . "se_book_message_matches" . " WHERE message_id = %d AND book_id = %d GROUP BY bm_match_id ORDER BY bm_match_id ASC"; 
						$enmse_dscmsql = $wpdb->prepare( $enmse_preparreddscmsql, $sermon_id, $start_book );
						$enmse_dmscriptures = $wpdb->get_results( $enmse_dscmsql );
						$enmse_countrec = $wpdb->num_rows;

						if ( $enmse_countrec > 1 || empty($enmse_dmscriptures) ) {
							$enmse_newbmm = array(
								'message_id' => $sermon_id, 
								'book_id' => $start_book
							); 
							$wpdb->insert( $wpdb->prefix . "se_book_message_matches", $enmse_newbmm );
						}	

					}
				}
			}

			if ( $sbsccount == 1 ) {
				$enmse_messages[] = "<strong>" . $sbsccount . " Sermon Browser Scripture</strong> was imported.";
			} elseif ( $sbsccount > 1 ) {
				$enmse_messages[] = "<strong>" . $sbsccount . " Sermon Browser Scriptures</strong> were imported.";
			}




			// Import Sermon Browser Messages
			$enmse_findsbsermonssql = "SELECT * FROM " . $wpdb->prefix . "sb_sermons"; 
			$enmse_sbsermons = $wpdb->get_results( $enmse_findsbsermonssql );

			$sbsncount = 0;
			if ( !empty($enmse_sbsermons) ) {
				foreach ( $enmse_sbsermons as $sn ) {
					$id = $sn->id+$poffset;
					$title = $sn->title;
					$speaker = $sn->preacher_id+$poffset;
					$date = $sn->datetime;
					$service_id = $sn->service_id+$poffset+200;
					$series_id = $sn->series_id+$poffset;
					$description = $sn->description;

					$enmse_findthespeakersql = "SELECT last_name FROM " . $wpdb->prefix . "se_speakers" . " WHERE speaker_id = %d"; 
					$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $speaker );
					$enmse_preacher = $wpdb->get_row( $enmse_findthespeaker, OBJECT );

					$enmse_message = array(
						'message_id' => $id,
						'title' => $title, 
						'speaker' => $enmse_preacher->last_name,
						'date' => $date,
						'alternate_date' => '0000-00-00',
						'embed_code' => 0,
						'audio_url' => 0,
						'video_url' => 0,
						'alternate_embed' => 0,
						'video_embed_url' => 0,
						'additional_video_embed_url' => 0,
						'primary_series' => $series_id,
						'description' => $description
						); 
					$wpdb->get_results("SELECT message_id FROM " . $wpdb->prefix . "se_messages WHERE message_id = " . $id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_messages", $enmse_message );
						$sbsncount = $sbsncount+1;
					}

					$enmse_newsbspmm = array(
						'message_id' => $id, 
						'speaker_id' => $speaker
					); 
					$wpdb->get_results("SELECT message_id FROM " . $wpdb->prefix . "se_message_speaker_matches WHERE message_id = " . $id . " AND speaker_id = " . $speaker);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_message_speaker_matches", $enmse_newsbspmm );
					}

					$enmse_newsbsmm = array(
						'message_id' => $id, 
						'series_id' => $series_id
					); 
					$wpdb->get_results("SELECT message_id FROM " . $wpdb->prefix . "se_series_message_matches WHERE message_id = " . $id . " AND series_id = " . $series_id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newsbsmm );
					}

					$enmse_newsbsvmm = array(
						'message_id' => $id, 
						'series_id' => $service_id
					); 
					$wpdb->get_results("SELECT message_id FROM " . $wpdb->prefix . "se_series_message_matches WHERE message_id = " . $id . " AND series_id = " . $service_id);
					if($wpdb->num_rows == 0) { 
						$wpdb->insert( $wpdb->prefix . "se_series_message_matches", $enmse_newsbsvmm );
					}
				}
			}

			if ( $sbsncount == 1 ) {
				$enmse_messages[] = "<strong>" . $sbsncount . " Sermon Browser Sermon</strong> was imported (as a Message).";
			} elseif ( $sbsncount > 1 ) {
				$enmse_messages[] = "<strong>" . $sbsncount . " Sermon Browser Sermons</strong> were imported (as Messages).";
			} 



			// Import Sermon Browser Stuff
			$enmse_findsbstuffsql = "SELECT * FROM " . $wpdb->prefix . "sb_stuff ORDER BY count ASC"; 
			$enmse_sbstuff = $wpdb->get_results( $enmse_findsbstuffsql );
			$sb_options = unserialize(base64_decode(get_option('sermonbrowser_options'))); 

			if ( !empty($enmse_sbstuff) ) {
				foreach ( $enmse_sbstuff as $stuff ) {
					$id = $stuff->id+$poffset;
					$type = $stuff->type;
					$content = $stuff->name;
					$sermon_id = $stuff->sermon_id+$poffset;
					$count = $stuff->count;
					$duration = $stuff->duration;
					$directory = $sb_options['upload_url'];

					/* Correct for MP3 */
					if ( $type == "file" ) { // Is it a Download? 
						if (preg_match('/(\.mp3|\.aac|\.m4a|\.wma)$/i', $content)) { // audio
							$fullcontent = $directory . $content;

							$enmse_new_mvalues = array( 'audio_url' => $fullcontent, 'audio_count' => $count, 'message_length' => $duration ); 
							$enmse_mwhere = array( 'message_id' => $sermon_id ); 
							$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

						} elseif (preg_match('/(\.mp4|\.m4v|\.mov|\.wmv)$/i', $content)) { // video
							$fullcontent = $directory . $content;

							$enmse_new_mvalues = array( 'video_embed_url' => $fullcontent, 'video_count' => $count, 'message_video_length' => $duration ); 
							$enmse_mwhere = array( 'message_id' => $sermon_id ); 
							$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

						} else {
							$enmse_file = array(
							'file_id' => $id,
							'file_name' => 'Related File',
							'file_url' => $directory . $content, 
							'file_new_window' => '1'
							); 
							$wpdb->get_results("SELECT file_id FROM " . $wpdb->prefix . "se_files WHERE file_id = " . $id);
							if($wpdb->num_rows == 0) { 
								$wpdb->insert( $wpdb->prefix . "se_files", $enmse_file );
							}
							$enmse_newsbmfm = array(
								'file_id' => $id, 
								'message_id' => $sermon_id
							); 
							$wpdb->get_results("SELECT file_id FROM " . $wpdb->prefix . "se_message_file_matches WHERE file_id = " . $id);
							if($wpdb->num_rows == 0) { 
								$wpdb->insert( $wpdb->prefix . "se_message_file_matches", $enmse_newsbmfm );	
							}	
						}
								
					} elseif ( $type == "url" ) { // Is it a Link? 
						if (preg_match('/(\.mp3|\.aac|\.m4a|\.mp4|\.m4v|\.flv|\.mov|\.wma|\.wmv)$/i', $content)) { // media

							if (preg_match('/(\.mp3|\.aac|\.m4a|\.wma)$/i', $content)) { // audio

								$enmse_new_mvalues = array( 'audio_url' => $content, 'audio_count' => $count, 'message_length' => $duration ); 
								$enmse_mwhere = array( 'message_id' => $sermon_id ); 
								$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

							} elseif (preg_match('/(\.mp4|\.m4v|\.mov|\.wmv)$/i', $content)) { // video

								$enmse_new_mvalues = array( 'video_embed_url' => $content, 'video_count' => $count, 'message_video_length' => $duration ); 
								$enmse_mwhere = array( 'message_id' => $sermon_id ); 
								$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

							}

						} else { // just a link

						   $enmse_file = array(
								'file_id' => $id,
								'file_name' => 'Related Link',
								'file_url' => $content, 
								'file_new_window' => '1'
								); 
						   $wpdb->get_results("SELECT file_id FROM " . $wpdb->prefix . "se_files WHERE file_id = " . $id);
							if($wpdb->num_rows == 0) { 
								$wpdb->insert( $wpdb->prefix . "se_files", $enmse_file );
							}
							$enmse_newsbmfm = array(
								'file_id' => $id, 
								'message_id' => $sermon_id
							); 
							$wpdb->get_results("SELECT file_id FROM " . $wpdb->prefix . "se_message_file_matches WHERE file_id = " . $id);
							if($wpdb->num_rows == 0) { 
								$wpdb->insert( $wpdb->prefix . "se_message_file_matches", $enmse_newsbmfm );
							}
						}
					/* Check for [vimeo] and [youtube] */
					} elseif ( $type == "code" ) { // Is it an embed? 
						$decoded = base64_decode($content);

						if (preg_match('/(\iframe)+/i', $decoded)) {

							$enmse_new_mvalues = array( 'embed_code' => addslashes($decoded) ); 
							$enmse_mwhere = array( 'message_id' => $sermon_id ); 
							$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

						} elseif (preg_match('/(\.mp3|\.aac|\.m4a|\.wma)+/i', $decoded)) { // audio

							preg_match('/=["\']?([^"\'>]+)["\']?/', $decoded, $match);
							$finalurl = parse_url($match[1]);
							$finalaudio = $finalurl['scheme'].'://'.$finalurl['host'] . $finalurl["path"];

							$enmse_new_mvalues = array( 'audio_url' => $finalaudio, 'audio_count' => $count, 'message_length' => $duration ); 
							$enmse_mwhere = array( 'message_id' => $sermon_id ); 
							$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

						} elseif (preg_match('/(\.mp4|\.m4v|\.mov|\.wmv)+/i', $decoded)) { // video 

							preg_match('/=["\']?([^"\'>]+)["\']?/', $decoded, $match);
							$finalurl = parse_url($match[1]);
							$finalvideo = $finalurl['scheme'].'://'.$finalurl['host'] . $finalurl["path"];

							$enmse_new_mvalues = array( 'video_embed_url' => $finalvideo, 'video_count' => $count ); 
							$enmse_mwhere = array( 'message_id' => $sermon_id ); 
							$wpdb->update( $wpdb->prefix . "se_messages", $enmse_new_mvalues, $enmse_mwhere );

						}

					}

				}
			}

			// Correct Series Dates 

			$enmse_findseriessql = "SELECT * FROM " . $wpdb->prefix . "sb_series"; 
			$enmse_series = $wpdb->get_results( $enmse_findseriessql );

			if ( !empty($enmse_series) ) {
				foreach ($enmse_series as $s) {

					$enmse_smpreparredsql = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d GROUP BY title ORDER BY date ASC LIMIT 1"; 		
					$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $s->id+$poffset );
					$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );

					if ( !empty($enmse_singlemessage) ) {
						$enmse_new_mvalues = array( 'start_date' => $enmse_singlemessage->date ); 
						$enmse_mwhere = array( 'series_id' => $s->id+$poffset ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_mvalues, $enmse_mwhere );
					} else {
						$enmse_new_mvalues = array( 'start_date' => current_time( 'mysql' ) ); 
						$enmse_mwhere = array( 'series_id' => $s->id+$poffset ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_mvalues, $enmse_mwhere );
					}

				}
			}

			$enmse_findservicessql = "SELECT * FROM " . $wpdb->prefix . "sb_services"; 
			$enmse_services = $wpdb->get_results( $enmse_findservicessql );

			if ( !empty($enmse_services) ) {
				foreach ($enmse_services as $s) {

					$enmse_smpreparredsql = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d GROUP BY title ORDER BY date ASC LIMIT 1"; 		
					$enmse_findthemessage = $wpdb->prepare( $enmse_smpreparredsql, $s->id+$poffset );
					$enmse_singlemessage = $wpdb->get_row( $enmse_findthemessage, OBJECT );

					if ( !empty($enmse_singlemessage) ) {
						$enmse_new_mvalues = array( 'start_date' => $enmse_singlemessage->date ); 
						$enmse_mwhere = array( 'series_id' => $s->id+$poffset+200 ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_mvalues, $enmse_mwhere );
					} else {
						$enmse_new_mvalues = array( 'start_date' => current_time( 'mysql' ) ); 
						$enmse_mwhere = array( 'series_id' => $s->id+$poffset+200 ); 
						$wpdb->update( $wpdb->prefix . "se_series", $enmse_new_mvalues, $enmse_mwhere );
					}

				}
			}

			if ( empty($enmse_messages) ) {
				$enmse_messages[] = "The importer ran sucessfully, but it looks like you've already imported everything from Sermon Browser before. Good job!";
			}

 ?>