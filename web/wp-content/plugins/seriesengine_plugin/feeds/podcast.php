<?php
/**
 * Generate Podcasts for Series Engine
 *
 * @package WordPress
 */

global $wpdb;

if ( isset($_GET['enmse_pid']) ) {
	$enmse_pid = strip_tags($_GET['enmse_pid']);
} else {
	$enmse_pid = 1;
}
 // Find the Requested Podcast
$enmse_findthepodcastsql = "SELECT * FROM " . $wpdb->prefix . "se_podcasts" . " WHERE se_podcast_id = %d"; 
$enmse_findthepodcast = $wpdb->prepare( $enmse_findthepodcastsql, $enmse_pid );
$enmse_podcast = $wpdb->get_row( $enmse_findthepodcast, OBJECT );

if ( $enmse_podcast->redirect_podcast == 1 ) {
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: " . $enmse_podcast->redirect_url);
} else {
	header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
}

$more = 1;

$enmse_sid = $enmse_podcast->series_id;
$enmse_tid = $enmse_podcast->topic_id;
$enmse_spid = $enmse_podcast->speaker_id;
$enmse_stid = $enmse_podcast->series_type_id;

// Language Settings

$enmse_options = get_option( 'enm_seriesengine_options' ); 
$enmse_dateformat = get_option( 'date_format' ); 

if ( isset($enmse_options['messaget']) ) { // Find Message Title
	$enmsemessaget = $enmse_options['messaget'];
} else {
	$enmsemessaget = "Message";
}

// Message from
if ( isset($enmse_options['lang_podcastmessagefrom']) ) { 
	$lang_podcastmessagefrom = $enmse_options['lang_podcastmessagefrom'];
	$enmse_podcastmessagefrom =  str_replace("MESSAGE_LABEL", $enmsemessaget, $lang_podcastmessagefrom);
} else {
	$lang_podcastmessagefrom = "MESSAGE_LABEL from";
	$enmse_podcastmessagefrom =  str_replace("MESSAGE_LABEL", $enmsemessaget, $lang_podcastmessagefrom);
}

// Podcast language
if ( $enmse_podcast->custom_lang == NULL ) {
	if ( isset($enmse_options['language']) ) { 
		$langval = $enmse_options['language'];
		if ( $langval == 10 ) { // French
			$enmse_podcastlanguage =  "fr";
		} elseif ( $langval == 9 ) { // Russian
			$enmse_podcastlanguage =  "ru";
		} elseif ( $langval == 8 ) { // Dutch
			$enmse_podcastlanguage =  "ja";
		} elseif ( $langval == 7 ) { // Dutch
			$enmse_podcastlanguage =  "nl";
		} elseif ( $langval == 6 ) { // Traditional Chinese
			$enmse_podcastlanguage =  "zh-tw";
		} elseif ( $langval == 5 ) { // Simplified Chinese
			$enmse_podcastlanguage =  "zh-cn";
		} elseif ( $langval == 4 ) { // Turkish
			$enmse_podcastlanguage =  "tr";
		} elseif ( $langval == 3 ) { // German
			$enmse_podcastlanguage =  "de";
		} elseif ( $langval == 2 ) { // Spanish
			$enmse_podcastlanguage =  "es";
		} else { // English
			$enmse_podcastlanguage =  "en";
		}
	} else {
		$enmse_podcastlanguage =  "en";
	}
} else {
	$enmse_podcastlanguage =  htmlspecialchars(stripslashes($enmse_podcast->custom_lang));
}

if ( $enmse_podcastlanguage == "tr" ) {
	$enmse_langswitch = 1;
} elseif ( $enmse_podcastlanguage == "ja" ) { 
	$enmse_langswitch = 2;
} else {
	$enmse_langswitch = 0;
}

// Shorten Message Descriptions
function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}

// Find Messages

if ( $enmse_podcast->audio_video == "Audio" ) { // Audio Podcast?
	if ( $enmse_sid > 0 ) { // Did they specify a series?
		if ( $enmse_stid > 0 ) { // Series type?
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_id = %d AND series_type_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d"; 
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_sid, $enmse_stid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_id = %d AND series_type_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_sid, $enmse_stid );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		} else {
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d"; 
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_sid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_sid );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		}
	} elseif ( $enmse_tid > 0 ) { // Did they specify a topic?
		if ( $enmse_stid > 0 ) { // Series type?
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND topic_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d"; 
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid, $enmse_tid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND topic_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_stid, $enmse_tid  );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		} else {
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE topic_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_tid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE topic_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_tid );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		}
	} elseif ( $enmse_spid > 0 ) { // Did they specify a speaker?
	 	if ( $enmse_stid > 0 ) { // Series type?
	 		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND speaker_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d"; 
	 		$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid, $enmse_spid, $enmse_podcast->podcast_display );
	 		$enmse_messages = $wpdb->get_results( $enmse_sql );
	 		
	 		$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND speaker_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
	 		$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_stid, $enmse_spid );
	 		$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
	 		$enmse_datecount = $wpdb->num_rows;
	 	} else {
	 		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE speaker_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d";  
	 		$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_spid, $enmse_podcast->podcast_display );
	 		$enmse_messages = $wpdb->get_results( $enmse_sql );
	 		
	 		$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE speaker_id = %d AND audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
	 		$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_spid );
	 		$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
	 		$enmse_datecount = $wpdb->num_rows;
	 	}
	 } else {
		if ( $enmse_stid > 0 ) { // Series type?
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND  audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND  audio_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_stid  );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		} else {
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " WHERE audio_url != '0' AND date <= CURDATE() ORDER BY date DESC LIMIT %d";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " WHERE audio_url != '0' AND date <= CURDATE() ORDER BY date DESC LIMIT 1"; 
			$enmse_getdate = $wpdb->get_row( $enmse_preparredsqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		}
	}
} elseif ( $enmse_podcast->audio_video == "Video" ) { // Video Podcast?
	if ( $enmse_sid > 0 ) { // Did they specify a series?
		if ( $enmse_stid > 0 ) { // Series type?
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_id = %d AND series_type_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_sid, $enmse_stid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_id = %d AND series_type_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_sid, $enmse_stid );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		} else {
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d"; 
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_sid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) WHERE series_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_sid );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		}
	} elseif ( $enmse_tid > 0 ) { // Did they specify a topic?
		if ( $enmse_stid > 0 ) { // Series type?
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND topic_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid, $enmse_tid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND topic_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_stid, $enmse_tid );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		} else {
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE topic_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_tid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (message_id) WHERE topic_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_tid );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		}
	} elseif ( $enmse_spid > 0 ) { // Did they specify a speaker?
	 	if ( $enmse_stid > 0 ) { // Series type?
	 		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND speaker_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d";  
	 		$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid, $enmse_spid, $enmse_podcast->podcast_display );
	 		$enmse_messages = $wpdb->get_results( $enmse_sql );
	 		
	 		$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND speaker_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
	 		$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_stid, $enmse_spid );
	 		$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
	 		$enmse_datecount = $wpdb->num_rows;
	 	} else {
	 		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE speaker_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d";  
	 		$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_spid, $enmse_podcast->podcast_display );
	 		$enmse_messages = $wpdb->get_results( $enmse_sql );
	 		
	 		$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (message_id) WHERE speaker_id = %d AND video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
	 		$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_spid );
	 		$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
	 		$enmse_datecount = $wpdb->num_rows;
	 	}
	 } else {
		if ( $enmse_stid > 0 ) { // Series type?
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND  video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT %d"; 
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_stid, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE series_type_id = %d AND  video_url != '0' AND date <= CURDATE() GROUP BY message_id ORDER BY date DESC LIMIT 1"; 
			$enmse_sqltwo = $wpdb->prepare( $enmse_preparredsqltwo, $enmse_stid );
			$enmse_getdate = $wpdb->get_row( $enmse_sqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;
		} else {
			$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_messages" . " WHERE video_url != '0' AND date <= CURDATE() ORDER BY date DESC LIMIT %d";  
			$enmse_sql = $wpdb->prepare( $enmse_preparredsql, $enmse_podcast->podcast_display );
			$enmse_messages = $wpdb->get_results( $enmse_sql );
			
			$enmse_preparredsqltwo = "SELECT date FROM " . $wpdb->prefix . "se_messages" . " WHERE video_url != '0' AND date <= CURDATE() ORDER BY date DESC LIMIT 1"; 
			$enmse_getdate = $wpdb->get_row( $enmse_preparredsqltwo, OBJECT );
			$enmse_datecount = $wpdb->num_rows;	
		}
	}	
}
	// Get All Series
	$enmse_preparredssql = "SELECT series_id, s_title FROM " . $wpdb->prefix . "se_series" . " WHERE archived = 0 ORDER BY start_date DESC"; 
	$enmse_s = $wpdb->get_results( $enmse_preparredssql );
	
	// Get All Series Message Matches
	$enmse_preparredsmmsql = "SELECT series_id, message_id FROM " . $wpdb->prefix . "se_series_message_matches"; 
	$enmse_smm = $wpdb->get_results( $enmse_preparredsmmsql );
	
	// Get All Speakers
	$enmse_preparredssql = "SELECT * FROM " . $wpdb->prefix . "se_speakers"; 
	$enmse_sp = $wpdb->get_results( $enmse_preparredssql );
	
	// Get All Message Speaker Matches
	$enmse_preparredmspmsql = "SELECT speaker_id, message_id FROM " . $wpdb->prefix . "se_message_speaker_matches"; 
	$enmse_mspm = $wpdb->get_results( $enmse_preparredmspmsql );
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
<channel>
    <title><?php echo htmlspecialchars(stripslashes($enmse_podcast->title)); ?></title>
    <link><?php echo home_url(); ?></link>
    <description><?php echo htmlspecialchars(stripslashes($enmse_podcast->description)); ?></description>
    <copyright><?php echo htmlspecialchars(stripslashes($enmse_podcast->author)); ?> <?php echo date('Y'); ?></copyright>
    <language><?php echo $enmse_podcastlanguage; ?></language>
    <?php if ( $enmse_podcast->redirect_podcast == 2 ) { ?><itunes:new-feed-url><?php echo $enmse_podcast->redirect_url; ?></itunes:new-feed-url><?php }; ?>
    <itunes:subtitle><?php echo htmlspecialchars(stripslashes($enmse_podcast->description)); ?></itunes:subtitle>
    <itunes:author><?php echo htmlspecialchars(stripslashes($enmse_podcast->author)); ?></itunes:author>
    <itunes:summary><?php echo htmlspecialchars(stripslashes($enmse_podcast->description)); ?></itunes:summary>
    <itunes:owner>
                  <itunes:name><?php echo htmlspecialchars(stripslashes($enmse_podcast->author)); ?></itunes:name>
                  <itunes:email><?php echo htmlspecialchars(stripslashes($enmse_podcast->email)); ?></itunes:email>
    </itunes:owner>
    <itunes:explicit><?php if ( !isset($enmse_podcast->explicit) || $enmse_podcast->explicit == 0 ) { echo "no"; } else { echo "yes"; }; ?></itunes:explicit>
    <itunes:image href="<?php echo $enmse_podcast->logo_url; ?>" />
    <itunes:category text="<?php echo htmlspecialchars(stripslashes($enmse_podcast->category)); ?>">
                  <itunes:category text="<?php echo htmlspecialchars(stripslashes($enmse_podcast->subcategory)); ?>" />
    </itunes:category>
    <lastBuildDate><?php if ( !empty($enmse_datecount) && $enmse_datecount > 0 ) { echo date('D, d M Y ', strtotime($enmse_getdate->date)) . '12:00:00' . date(' O', strtotime($enmse_getdate->date)); } else { echo date(DATE_RFC2822); }; ?></lastBuildDate>
    <pubDate><?php if ( !empty($enmse_datecount) && $enmse_datecount > 0 ) { echo date('D, d M Y ', strtotime($enmse_getdate->date)) . '12:00:00' . date(' O', strtotime($enmse_getdate->date)); } else { echo date(DATE_RFC2822); }; ?></pubDate>
    <webMaster><?php echo htmlspecialchars(stripslashes($enmse_podcast->email)); ?> (<?php echo htmlspecialchars(stripslashes($enmse_podcast->author)); ?>)</webMaster>
	<?php if ( $enmse_podcast->audio_video == "Audio" ) { ?>
	<?php if ( !empty($enmse_messages) ) { foreach ( $enmse_messages as $enmse_message ) { ?>
	<?php $enmse_sp_comma = 1; foreach ( $enmse_sp as $sp) { ?><?php foreach ( $enmse_mspm as $mspm) { ?><?php if ( ($mspm->message_id == $enmse_message->message_id) && ($mspm->speaker_id == $sp->speaker_id) ) { if ( $enmse_sp_comma == 1 ) { if ( $enmse_langswitch == 0) { $enmse_thisspeaker =  htmlspecialchars(stripslashes($sp->first_name)) . " " . htmlspecialchars(stripslashes($sp->last_name)) . " on "; } elseif ( $enmse_langswitch == 2 ) { $enmse_thisspeaker =  htmlspecialchars(stripslashes($sp->last_name) . " " . htmlspecialchars(stripslashes($sp->first_name))) . " オン "; } else { $enmse_thisspeaker =  htmlspecialchars(stripslashes($sp->first_name)) . " " . htmlspecialchars(stripslashes($sp->last_name)) . " "; } $enmse_sp_comma = $enmse_sp_comma+1; } } ?><?php } ?><?php } ?>
	<?php if (preg_match('/(.mp3)/', $enmse_message->audio_url)) { // Find correct MIME type
			$enmse_mime = 'audio/mpeg';
		} elseif (preg_match('/(.m4a)/', $enmse_message->audio_url) || preg_match('/(.aac)/', $enmse_message->audio_url) || preg_match('/(.m4p)/', $enmse_message->audio_url)) {
			$enmse_mime = 'audio/mp4a-latm';
		} elseif (preg_match('/(.ogg)/', $enmse_message->audio_url)) {
			$enmse_mime = 'application/ogg';
		} else {
			$enmse_mime = null;
		} 
	?>
	<item>
        <title><?php echo htmlspecialchars(stripslashes($enmse_message->title)); ?><?php if ( $enmse_message->podcast_series == 1 || $enmse_message->podcast_series == NULL  ) { ?><?php $enmse_s_comma = 1; foreach ( $enmse_s as $s) { ?><?php foreach ( $enmse_smm as $smm) { ?><?php if ( ($smm->message_id == $enmse_message->message_id) && ($smm->series_id == $s->series_id) ) { if ( $enmse_s_comma == 1 ) { echo " - " . htmlspecialchars(stripslashes($s->s_title)); $enmse_s_comma = $enmse_s_comma+1; } } ?><?php } ?><?php } ?><?php } ?></title>	      
		<link><?php if ($enmse_podcast->link_url != null) { echo $enmse_podcast->link_url . "?enmse_mid=" . $enmse_message->message_id;} else { echo home_url() . "?enmse_mid=" . $enmse_message->message_id;} ?></link>
	    <description><?php if ($enmse_message->description == null) { ?><?php if ( $enmse_langswitch == 0 || $enmse_langswitch == 2 ) { ?><?php echo $enmse_podcastmessagefrom; ?> <?php echo $enmse_thisspeaker; ?><?php echo date_i18n($enmse_dateformat, strtotime($enmse_message->date)); ?><?php } else { ?><?php echo $enmse_thisspeaker; ?> <?php echo $enmse_podcastmessagefrom; ?><?php } ?><?php } else { echo htmlspecialchars(stripslashes($enmse_message->description)); } ?></description>
	    <?php if ( $enmse_message->podcast_image != null ) { ?><itunes:image href="<?php echo $enmse_message->podcast_image; ?>" /><?php } elseif ( $enmse_message->series_podcast_image != null ) { ?><itunes:image href="<?php echo $enmse_message->series_podcast_image; ?>" /><?php } ?>
	    <itunes:author><?php echo htmlspecialchars(stripslashes($enmse_podcast->author)); ?></itunes:author>
	    <itunes:subtitle><?php if ($enmse_message->description == null) { ?><?php if ( $enmse_langswitch == 0 || $enmse_langswitch == 2 ) { ?><?php echo $enmse_podcastmessagefrom; ?> <?php echo $enmse_thisspeaker; ?><?php echo date_i18n($enmse_dateformat, strtotime($enmse_message->date)); ?><?php } else { ?><?php echo $enmse_thisspeaker; ?> <?php echo $enmse_podcastmessagefrom; ?><?php } ?><?php } else { echo htmlspecialchars(stripslashes(substrwords($enmse_message->description,250))); } ?></itunes:subtitle>      
		<itunes:summary><?php if ($enmse_message->description == null) { ?><?php if ( $enmse_langswitch == 0 || $enmse_langswitch == 2 ) { ?><?php echo $enmse_podcastmessagefrom; ?> <?php echo $enmse_thisspeaker; ?><?php echo date_i18n($enmse_dateformat, strtotime($enmse_message->date)); ?><?php } else { ?><?php echo $enmse_thisspeaker; ?> <?php echo $enmse_podcastmessagefrom; ?><?php } ?><?php } else { echo htmlspecialchars(stripslashes($enmse_message->description)); } ?></itunes:summary>
	    <?php if ($enmse_message->message_length != null) { ?><itunes:duration><?php echo $enmse_message->message_length; ?></itunes:duration><?php } ?>
	    <pubDate><?php echo date('D, d M Y ', strtotime($enmse_message->date)) . '12:00:00' . date(' O', strtotime($enmse_message->date)); ?></pubDate>      
		<guid><?php if ($enmse_podcast->link_url != null) { echo $enmse_podcast->link_url . "?enmse_mid=" . $enmse_message->message_id;} else { echo home_url() . "?enmse_mid=" . $enmse_message->message_id;} ?></guid>
	    <enclosure type="<?php echo $enmse_mime; ?>" <?php if ($enmse_message->audio_file_size > 1) {echo 'length="' . $enmse_message->audio_file_size . '"';}; ?> url="<?php echo stripslashes($enmse_message->audio_url); ?>"/>	</item>	
	<?php }} ?>
	<?php } elseif ( $enmse_podcast->audio_video == "Video" ) { ?>
	<?php if ( !empty($enmse_messages) ) { foreach ( $enmse_messages as $enmse_message ) { ?>
	<?php $enmse_sp_comma = 1; foreach ( $enmse_sp as $sp) { ?><?php foreach ( $enmse_mspm as $mspm) { ?><?php if ( ($mspm->message_id == $enmse_message->message_id) && ($mspm->speaker_id == $sp->speaker_id) ) { if ( $enmse_sp_comma == 1 ) { if ( $enmse_langswitch == 0) { $enmse_thisspeaker =  htmlspecialchars(stripslashes($sp->first_name)) . " " . htmlspecialchars(stripslashes($sp->last_name)) . " on "; } elseif ( $enmse_langswitch == 2 ) { $enmse_thisspeaker =  htmlspecialchars(stripslashes($sp->last_name) . " " . htmlspecialchars(stripslashes($sp->first_name))) . " オン "; }  else { $enmse_thisspeaker =  htmlspecialchars(stripslashes($sp->first_name)) . " " . htmlspecialchars(stripslashes($sp->last_name)) . " "; } $enmse_sp_comma = $enmse_sp_comma+1; } } ?><?php } ?><?php } ?>
		<?php if (preg_match('/(.mp4)/', $enmse_message->video_url)) { // Find correct MIME type
			$enmse_mime = 'video/mp4';
		} elseif (preg_match('/(.m4v)/', $enmse_message->video_url)) {
			$enmse_mime = 'video/x-m4v';
		} else {
			$enmse_mime = null;
		} 
	?>
	<item>
        <title><?php echo htmlspecialchars(stripslashes($enmse_message->title)); ?><?php if ( $enmse_message->podcast_series == 1 || $enmse_message->podcast_series == NULL  ) { ?><?php $enmse_s_comma = 1; foreach ( $enmse_s as $s) { ?><?php foreach ( $enmse_smm as $smm) { ?><?php if ( ($smm->message_id == $enmse_message->message_id) && ($smm->series_id == $s->series_id) ) { if ( $enmse_s_comma == 1 ) { echo " - " . htmlspecialchars(stripslashes($s->s_title)); $enmse_s_comma = $enmse_s_comma+1; } } ?><?php } ?><?php } ?><?php } ?></title>	      
		<link><?php if ($enmse_podcast->link_url != null) { echo $enmse_podcast->link_url . "?enmse_mid=" . $enmse_message->message_id;} else { echo home_url() . "?enmse_mid=" . $enmse_message->message_id;} ?></link>
	    <description><?php if ($enmse_message->description == null) { ?><?php if ( $enmse_langswitch == 0 || $enmse_langswitch == 2 ) { ?><?php echo $enmse_podcastmessagefrom; ?> <?php echo $enmse_thisspeaker; ?><?php echo date_i18n($enmse_dateformat, strtotime($enmse_message->date)); ?><?php } else { ?><?php echo $enmse_thisspeaker; ?> <?php echo $enmse_podcastmessagefrom; ?><?php } ?><?php } else { echo htmlspecialchars(stripslashes($enmse_message->description)); } ?></description>
	    <?php if ( $enmse_message->podcast_image != null ) { ?><itunes:image href="<?php echo $enmse_message->podcast_image; ?>" /><?php } elseif ( $enmse_message->series_podcast_image != null ) { ?><itunes:image href="<?php echo $enmse_message->series_podcast_image; ?>" /><?php } ?>
	    <itunes:author><?php echo htmlspecialchars(stripslashes($enmse_podcast->author)); ?></itunes:author>		   
	    <itunes:subtitle><?php if ($enmse_message->description == null) { ?><?php if ( $enmse_langswitch == 0 || $enmse_langswitch == 2 ) { ?><?php echo $enmse_podcastmessagefrom; ?> <?php echo $enmse_thisspeaker; ?><?php echo date_i18n($enmse_dateformat, strtotime($enmse_message->date)); ?><?php } else { ?><?php echo $enmse_thisspeaker; ?> <?php echo $enmse_podcastmessagefrom; ?><?php } ?><?php } else { echo htmlspecialchars(stripslashes(substrwords($enmse_message->description,250))); } ?></itunes:subtitle>      
		<itunes:summary><?php if ($enmse_message->description == null) { ?><?php if ( $enmse_langswitch == 0 || $enmse_langswitch == 2 ) { ?><?php echo $enmse_podcastmessagefrom; ?> <?php echo $enmse_thisspeaker; ?><?php echo date_i18n($enmse_dateformat, strtotime($enmse_message->date)); ?><?php } else { ?><?php echo $enmse_thisspeaker; ?> <?php echo $enmse_podcastmessagefrom; ?><?php } ?><?php } else { echo htmlspecialchars(stripslashes($enmse_message->description)); } ?></itunes:summary>		  
	    <?php if ($enmse_message->message_video_length != null) { ?><itunes:duration><?php echo $enmse_message->message_video_length; ?></itunes:duration><?php } ?>
	    <pubDate><?php echo date('D, d M Y ', strtotime($enmse_message->date)) . '12:00:00' . date(' O', strtotime($enmse_message->date)); ?></pubDate>      	
		<guid><?php if ($enmse_podcast->link_url != null) { echo $enmse_podcast->link_url . "?enmse_mid=" . $enmse_message->message_id;} else { echo home_url() . "?enmse_mid=" . $enmse_message->message_id;} ?></guid>		 
	    <enclosure type="<?php echo $enmse_mime; ?>" <?php if ($enmse_message->video_file_size > 1) {echo 'length="' . $enmse_message->video_file_size . '"';}; ?> url="<?php echo stripslashes($enmse_message->video_url); ?>"/>
	</item>			
	<?php }} ?>
	<?php } ?>
</channel>
</rss>