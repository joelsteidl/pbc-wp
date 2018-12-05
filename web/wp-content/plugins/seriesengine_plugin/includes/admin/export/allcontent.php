<?php /* Series Engine - Export Series Engine Content */
	require_once( '../../loadwpfiles.php' );

	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8', true, 200);
	header('Content-Disposition: attachment; filename=series_engine_archive.csv');

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');

	// output the column headings
	//fputcsv($output, array('Name', 'Email Address'));

// loop over the rows, outputting them

	
	if ( current_user_can( 'edit_posts' ) ) { 
		
		if ( $_POST ) {
			global $wpdb;
			$enmseoffset = $_POST['enmseoffset'];

			$enmse_sql3 = "SELECT * FROM " . $wpdb->prefix . "se_files" . " ORDER BY file_id ASC"; 	
			$enmse_files = $wpdb->get_results( $enmse_sql3 );

			$enmse_sql4 = "SELECT * FROM " . $wpdb->prefix . "se_message_file_matches" . " ORDER BY mf_match_id ASC"; 	
			$enmse_mfm = $wpdb->get_results( $enmse_sql4 );

			$enmse_sql5 = "SELECT * FROM " . $wpdb->prefix . "se_message_speaker_matches" . " ORDER BY msp_match_id ASC"; 	
			$enmse_msp = $wpdb->get_results( $enmse_sql5 );

			$enmse_sql6 = "SELECT * FROM " . $wpdb->prefix . "se_message_topic_matches" . " ORDER BY mt_match_id ASC"; 	
			$enmse_mtm = $wpdb->get_results( $enmse_sql6 );

			$enmse_sql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " ORDER BY message_id ASC"; 	
			$enmse_message = $wpdb->get_results( $enmse_sql );	

			$enmse_sql7 = "SELECT * FROM " . $wpdb->prefix . "se_podcasts" . " ORDER BY se_podcast_id ASC"; 	
			$enmse_podcast = $wpdb->get_results( $enmse_sql7 );

			$enmse_sql2 = "SELECT * FROM " . $wpdb->prefix . "se_series" . " ORDER BY series_id ASC"; 	
			$enmse_series = $wpdb->get_results( $enmse_sql2 );

			$enmse_sql8 = "SELECT * FROM " . $wpdb->prefix . "se_series_message_matches" . " ORDER BY sm_match_id ASC"; 	
			$enmse_smm = $wpdb->get_results( $enmse_sql8 );

			$enmse_sql9 = "SELECT * FROM " . $wpdb->prefix . "se_series_type_matches" . " ORDER BY st_match_id ASC"; 	
			$enmse_stm = $wpdb->get_results( $enmse_sql9 );

			$enmse_sql10 = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY series_type_id ASC"; 	
			$enmse_seriestype = $wpdb->get_results( $enmse_sql10 );

			$enmse_sql11 = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " ORDER BY speaker_id ASC"; 	
			$enmse_speaker = $wpdb->get_results( $enmse_sql11 );

			$enmse_sql12 = "SELECT * FROM " . $wpdb->prefix . "se_topics" . " ORDER BY topic_id ASC"; 	
			$enmse_topic = $wpdb->get_results( $enmse_sql12 );

			$enmse_sql13 = "SELECT * FROM " . $wpdb->prefix . "se_scriptures" . " ORDER BY scripture_id ASC"; 	
			$enmse_scriptures = $wpdb->get_results( $enmse_sql13 );

			$enmse_sql14 = "SELECT * FROM " . $wpdb->prefix . "se_scripture_message_matches" . " ORDER BY scm_match_id ASC"; 	
			$enmse_scm = $wpdb->get_results( $enmse_sql14 );

			$enmse_sql16 = "SELECT * FROM " . $wpdb->prefix . "se_book_message_matches" . " ORDER BY bm_match_id ASC"; 	
			$enmse_bmm = $wpdb->get_results( $enmse_sql16 );

			foreach ($enmse_files as $f) { // Export Files
				$filerow[] = "file";
				$filerow[] = $f->file_id+$enmseoffset;
				$filerow[] = $f->file_name;
				$filerow[] = $f->file_url;
				$filerow[] = '';
				$filerow[] = $f->sort_id;
				$filerow[] = $f->file_new_window;
				$filerow[] = $f->featured;
				fputcsv($output, $filerow);
				unset($filerow);
			}

			foreach ($enmse_mfm as $mfm) { // Export Message File Matches
				$mfmrow[] = "mfm";
				$mfmrow[] = $mfm->mf_match_id+$enmseoffset;
				$mfmrow[] = $mfm->message_id+$enmseoffset;
				$mfmrow[] = $mfm->file_id+$enmseoffset;
				fputcsv($output, $mfmrow);
				unset($mfmrow);
			}

			foreach ($enmse_msp as $msp) { // Export Message Speaker Matches
				$msprow[] = "msp";
				$msprow[] = $msp->msp_match_id+$enmseoffset;
				$msprow[] = $msp->message_id+$enmseoffset;
				$msprow[] = $msp->speaker_id+$enmseoffset;
				fputcsv($output, $msprow);
				unset($msprow);
			}

			foreach ($enmse_mtm as $mtm) { // Export Message Topic Matches
				$mtmrow[] = "mtm";
				$mtmrow[] = $mtm->mt_match_id+$enmseoffset;
				$mtmrow[] = $mtm->message_id+$enmseoffset;
				$mtmrow[] = $mtm->topic_id+$enmseoffset;
				fputcsv($output, $mtmrow);
				unset($mtmrow);
			}
				
			foreach ($enmse_message as $m) { // Export Messages
				$messagerow[] = "message";
				$messagerow[] = $m->message_id+$enmseoffset;
				$messagerow[] = $m->title;
				$messagerow[] = $m->speaker;
				$messagerow[] = $m->date;
				$messagerow[] = $m->alternate_date;
				$messagerow[] = $m->description;
				$messagerow[] = $m->message_length;
				$messagerow[] = $m->message_thumbnail;
				$messagerow[] = $m->audio_url;
				$messagerow[] = $m->message_video_length;
				$messagerow[] = $m->video_url;
				$messagerow[] = $m->embed_code;
				$messagerow[] = $m->alternate_toggle;
				$messagerow[] = $m->alternate_embed;
				$messagerow[] = $m->alternate_label;
				$messagerow[] = $m->audio_file_size;
				$messagerow[] = $m->video_file_size;
				$messagerow[] = $m->video_embed_url;
				$messagerow[] = $m->additional_video_embed_url;
				$messagerow[] = $m->audio_count;
				$messagerow[] = $m->video_count;
				$messagerow[] = $m->alternate_count;
				if ( $m->primary_series != null && $m->primary_series != "" && $m->primary_series != 0 ) {
					$messagerow[] = $m->primary_series+$enmseoffset;
				} else {
					$messagerow[] = $m->primary_series;
				}
				$messagerow[] = $m->series_thumbnail;
				$messagerow[] = $m->series_image;
				$messagerow[] = $m->series_podcast_image;
				$messagerow[] = $m->file_name;
				$messagerow[] = $m->file_url;
				$messagerow[] = $m->file_new_window;
				$messagerow[] = $m->podcast_image;
				$messagerow[] = $m->focus_scripture;
				$messagerow[] = $m->permalink_prefix;
				$messagerow[] = $m->permalink_speaker;
				$messagerow[] = $m->podcast_series;
				fputcsv($output, $messagerow);
				unset($messagerow);
			}

			foreach ($enmse_podcast as $p) { // Export Podcasts
				$podcastrow[] = "podcast";
				$podcastrow[] = $p->se_podcast_id+$enmseoffset;
				if ( $p->series_id >= 1 ) {
					$podcastrow[] = $p->series_id+$enmseoffset;
				} else {
					$podcastrow[] = $p->series_id;
				}
				if ( $p->topic_id >= 1) {
					$podcastrow[] = $p->topic_id+$enmseoffset;
				} else {
					$podcastrow[] = $p->topic_id;
				}
				if ( $p->speaker_id >= 1 ) {
					$podcastrow[] = $p->speaker_id+$enmseoffset;
				} else {
					$podcastrow[] = $p->speaker_id;
				}
				if ( $p->series_type_id >= 1 ) {
					$podcastrow[] = $p->series_type_id+$enmseoffset;
				} else {
					$podcastrow[] = $p->series_type_id;
				}
				$podcastrow[] = $p->title;
				$podcastrow[] = $p->description;
				$podcastrow[] = $p->author;
				$podcastrow[] = $p->email;
				$podcastrow[] = $p->logo_url;
				$podcastrow[] = $p->category;
				$podcastrow[] = $p->subcategory;
				$podcastrow[] = $p->audio_video;
				$podcastrow[] = $p->podcast_display;
				$podcastrow[] = $p->link_url;
				$podcastrow[] = $p->explicit;
				$podcastrow[] = $p->redirect_podcast;
				$podcastrow[] = $p->redirect_url;
				if ( $p->book_id >= 1 ) {
					$podcastrow[] = $p->book_id+$enmseoffset;
				} else {
					$podcastrow[] = $p->book_id;
				}
				fputcsv($output, $podcastrow);
				unset($podcastrow);
			}

			foreach ($enmse_series as $s) { // Export Series
				$seriesrow[] = "series";
				$seriesrow[] = $s->series_id+$enmseoffset;
				$seriesrow[] = $s->s_title;
				$seriesrow[] = $s->s_description;
				$seriesrow[] = $s->thumbnail_url;
				$seriesrow[] = $s->archived;
				$seriesrow[] = $s->start_date;
				$seriesrow[] = $s->graphic_thumb;
				$seriesrow[] = $s->widget_thumb;
				$seriesrow[] = $s->podcast_image;
				fputcsv($output, $seriesrow);
				unset($seriesrow);
			}

			foreach ($enmse_smm as $smm) { // Export Series Message Matches
				$smmrow[] = "smm";
				$smmrow[] = $smm->sm_match_id+$enmseoffset;
				$smmrow[] = $smm->message_id+$enmseoffset;
				$smmrow[] = $smm->series_id+$enmseoffset;
				fputcsv($output, $smmrow);
				unset($smmrow);
			}

			foreach ($enmse_stm as $stm) { // Export Series Topic Matches
				$stmrow[] = "stm";
				$stmrow[] = $stm->st_match_id+$enmseoffset;
				$stmrow[] = $stm->series_id+$enmseoffset;
				$stmrow[] = $stm->series_type_id+$enmseoffset;
				fputcsv($output, $stmrow);
				unset($stmrow);
			}

			foreach ($enmse_seriestype as $st) { // Export Series Types
				$seriestyperow[] = "seriestype";
				$seriestyperow[] = $st->series_type_id+$enmseoffset;
				$seriestyperow[] = $st->name;
				$seriestyperow[] = $st->description;
				$seriestyperow[] = $st->sort_id;
				fputcsv($output, $seriestyperow);
				unset($seriestyperow);
			}

			foreach ($enmse_speaker as $sp) { // Export Speakers
				$speakerrow[] = "speaker";
				$speakerrow[] = $sp->speaker_id+$enmseoffset;
				$speakerrow[] = $sp->first_name;
				$speakerrow[] = $sp->last_name;
				fputcsv($output, $speakerrow);
				unset($speakerrow);
			}

			foreach ($enmse_topic as $t) { // Export Topics
				$topicrow[] = "topic";
				$topicrow[] = $t->topic_id+$enmseoffset;
				$topicrow[] = $t->name;
				$topicrow[] = $t->sort_id;
				fputcsv($output, $topicrow);
				unset($topicrow);
			}

			foreach ($enmse_scriptures as $sc) { // Export Scriptures
				$scripturerow[] = "scripture";
				$scripturerow[] = $sc->scripture_id+$enmseoffset;
				$scripturerow[] = $sc->start_book;
				$scripturerow[] = $sc->start_chapter;
				$scripturerow[] = $sc->start_verse;
				$scripturerow[] = $sc->end_verse;
				$scripturerow[] = $sc->trans;
				$scripturerow[] = $sc->transtext;
				$scripturerow[] = $sc->focus;
				$scripturerow[] = $sc->sort_id;
				$scripturerow[] = $sc->link;
				$scripturerow[] = $sc->text;
				$scripturerow[] = $sc->short_text;
				$scripturerow[] = $sc->scripture_username;
				fputcsv($output, $scripturerow);
				unset($scripturerow);
			}

			foreach ($enmse_scm as $scm) { // Export Scripture Message Matches
				$scmrow[] = "scm";
				$scmrow[] = $scm->scm_match_id+$enmseoffset;
				$scmrow[] = $scm->scripture_id+$enmseoffset;
				$scmrow[] = $scm->message_id+$enmseoffset;
				fputcsv($output, $scmrow);
				unset($scmrow);
			}

			foreach ($enmse_bmm as $bmm) { // Export Book Message Matches
				$bmmrow[] = "bmm";
				$bmmrow[] = $bmm->bm_match_id+$enmseoffset;
				$bmmrow[] = $bmm->book_id+$enmseoffset;
				$bmmrow[] = $bmm->message_id+$enmseoffset;
				fputcsv($output, $bmmrow);
				unset($bmmrow);
			}
			
		}

	} else {
		exit("Access Denied");
	} 
?>