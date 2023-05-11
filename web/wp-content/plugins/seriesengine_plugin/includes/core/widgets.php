<?php 

// Series Engine Lists Widget
class enmse_seriesengine_widget_lists extends WP_Widget {

    //process the new widget
    function __construct() {
    	$se_options = get_option( 'enm_seriesengine_options' );

		if ( isset($se_options['seriest']) ) { // Find Series Title
			$enmseseriest = $se_options['seriest'];
		} else {
			$enmseseriest = "Series";
		}

		if ( isset($se_options['seriestp']) ) { // Find Series Title
			$enmseseriestp = $se_options['seriestp'];
		} else {
			$enmseseriestp = "Series";
		}

		if ( isset($se_options['topict']) ) { // Find Topic Title
			$enmsetopict = $se_options['topict'];
		} else {
			$enmsetopict = "Topic";
		}

		if ( isset($se_options['topictp']) ) { // Find Topic Title
			$enmsetopictp = $se_options['topictp'];
		} else {
			$enmsetopictp = "Topics";
		}

		if ( isset($se_options['speakert']) ) { // Find Speaker Title
			$enmsespeakert = $se_options['speakert'];
		} else {
			$enmsespeakert = "Speaker";
		}

		if ( isset($se_options['speakertp']) ) { // Find Speaker Title
			$enmsespeakertp = $se_options['speakertp'];
		} else {
			$enmsespeakertp = "Speakers";
		}

		if ( isset($se_options['messaget']) ) { // Find Message Title
			$enmsemessaget = $se_options['messaget'];
		} else {
			$enmsemessaget = "Message";
		}

		if ( isset($se_options['messagetp']) ) { // Find Message Title
			$enmsemessagetp = $se_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		}

		if ( isset($se_options['language']) ) { // Find the Language
			$enmse_language = $se_options['language'];
		} else {
			$enmse_language = 1;
		}

		if ( $enmse_language == 10 ) { // French
			$enmse_from =  "de";
		} elseif ( $enmse_language == 9 ) { // Russian
			$enmse_from =  "когда";
		} elseif ( $enmse_language == 8 ) { // Japanese
			$enmse_from =  "いつ";
		} elseif ( $enmse_language == 7 ) { // Dutch
			$enmse_from =  "wanneer";
		} elseif ( $enmse_language == 6 ) { // Traditional Chinese
			$enmse_from =  "來自";
		} elseif ( $enmse_language == 5 ) { // Simplified Chinese
			$enmse_from =  "什么时候";
		} elseif ( $enmse_language == 4 ) { // Turkish
			$enmse_from =  "itibaren";
		} elseif ( $enmse_language == 3 ) { // German
			$enmse_from =  "von";
		} elseif ( $enmse_language == 2 ) { // Spanish
			$enmse_from =  "de";
		} else { // English
			$enmse_from =  "from";
		}

        $widget_ops = array( 
			'classname' => 'enmse_seriesengine_widget_class', 
			'description' => 'Display a list of ' . $enmsemessagetp . ', ' . $enmseseriestp . ', ' . $enmsetopictp . ' or ' . $enmsespeakertp . ' from the Series Engine plugin.' 
			); 
        parent::__construct( 'enmse_seriesengine_widget_info', 'Series Engine', $widget_ops );
    }
 
     //build the widget settings form
    function form($instance) {		
		$se_options = get_option( 'enm_seriesengine_options' );

				if ( isset($se_options['seriest']) ) { // Find Series Title
			$enmseseriest = $se_options['seriest'];
		} else {
			$enmseseriest = "Series";
		}

		if ( isset($se_options['seriestp']) ) { // Find Series Title
			$enmseseriestp = $se_options['seriestp'];
		} else {
			$enmseseriestp = "Series";
		}

		if ( isset($se_options['topict']) ) { // Find Topic Title
			$enmsetopict = $se_options['topict'];
		} else {
			$enmsetopict = "Topic";
		}

		if ( isset($se_options['topictp']) ) { // Find Topic Title
			$enmsetopictp = $se_options['topictp'];
		} else {
			$enmsetopictp = "Topics";
		}

		if ( isset($se_options['speakert']) ) { // Find Speaker Title
			$enmsespeakert = $se_options['speakert'];
		} else {
			$enmsespeakert = "Speaker";
		}

		if ( isset($se_options['speakertp']) ) { // Find Speaker Title
			$enmsespeakertp = $se_options['speakertp'];
		} else {
			$enmsespeakertp = "Speakers";
		}

		if ( isset($se_options['messaget']) ) { // Find Message Title
			$enmsemessaget = $se_options['messaget'];
		} else {
			$enmsemessaget = "Message";
		}

		if ( isset($se_options['messagetp']) ) { // Find Message Title
			$enmsemessagetp = $se_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		}


		$primaryst = $se_options['primaryst'];
        $defaults = array( 'title' => 'Series Engine', 'what_to_display' => '', 'series_type' => $primaryst, 'display_number' => '5', 'series_archives' => '0', 'extra_details' => '0', 'link_page' => '' ); 
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
		$what_to_display = $instance['what_to_display'];
		$series_type = $instance['series_type'];
		$series_archives = $instance['series_archives'];
		$extra_details = $instance['extra_details'];
		$display_number = $instance['display_number'];
		$link_page = $instance['link_page'];
		
		global $wpdb;
		// Get All Series Types
		$enmse_preparredsql = "SELECT * FROM " . $wpdb->prefix . "se_series_types" . " ORDER BY sort_id ASC"; 
		$enmse_types = $wpdb->get_results( $enmse_preparredsql );
        ?>
            <p>Title: <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
			<p>What to Display: <select class="widefat enmse_wtd" name='<?php echo $this->get_field_name( 'what_to_display' ); ?>'>
				<option value='series' <?php if ( esc_attr( $what_to_display ) == 'series' ) { echo "selected='selected'";} ?>>Recent <?php echo $enmseseriest; ?> (by Start Date)</option>
				<option value='messages' <?php if ( esc_attr( $what_to_display ) == 'messages' ) { echo "selected='selected'";} ?>>Recent <?php echo $enmsemessagetp; ?> (by Date)</option>
				<option value='topics' <?php if ( esc_attr( $what_to_display ) == 'topics' ) { echo "selected='selected'";} ?>>List of <?php echo $enmsetopictp; ?></option>
				<option value='speakers' <?php if ( esc_attr( $what_to_display ) == 'speakers' ) { echo "selected='selected'";} ?>>List of Recent <?php echo $enmsespeakertp; ?></option>
				<option value='mostrecent' <?php if ( esc_attr( $what_to_display ) == 'mostrecent' ) { echo "selected='selected'";} ?>>Most Recent <?php echo $enmsemessaget; ?> (Beta)</option>
			</select></p>
			<p>From What <?php echo $enmseseriest; ?> Type? <select class="widefat" name='<?php echo $this->get_field_name( 'series_type' ); ?>'>
				<option value='0' <?php if ( esc_attr( $series_type ) == 0 ) { echo "selected='selected'";} ?>>All <?php echo $enmseseriest; ?> Types</option>
			<?php foreach ( $enmse_types as $enmse_single ) { ?>
				<option value='<?php echo $enmse_single->series_type_id ?>' <?php if ( esc_attr( $series_type ) == $enmse_single->series_type_id ) { echo "selected='selected'";} ?>><?php echo stripslashes($enmse_single->name) ?><?php if ( $primaryst == $enmse_single->series_type_id ) { echo " (Primary Series Type)";} ?></option>
			<?php } ?>
			</select></p>
			<p class="enmse_se" <?php if ( esc_attr( $what_to_display ) == 'mostrecent' ) { echo "style=\"display:none;\"";} ?>>Show extra details? <select class="widefat" name='<?php echo $this->get_field_name( 'extra_details' ); ?>'>
				<option value='0' <?php if ( esc_attr( $extra_details ) == 0 ) { echo "selected='selected'";} ?>>No, just simple links.</option>
				<option value='1' <?php if ( esc_attr( $extra_details ) == 1 ) { echo "selected='selected'";} ?>>Yes, include dates, descriptions and more.</option>
			</select></p>
			<p class="enmse_al" <?php if ( esc_attr( $what_to_display ) == 'mostrecent' ) { echo "style=\"display:none;\"";} ?>><?php echo $enmseseriest; ?> Archives Link? (if applicable) <select class="widefat" name='<?php echo $this->get_field_name( 'series_archives' ); ?>'>
				<option value='0' <?php if ( esc_attr( $series_archives ) == 0 ) { echo "selected='selected'";} ?>>No</option>
				<option value='1' <?php if ( esc_attr( $series_archives ) == 1 ) { echo "selected='selected'";} ?>>Yes</option>
			</select></p>
			<p>Link to What URL?: <input class="widefat" name="<?php echo $this->get_field_name( 'link_page' ); ?>" type="text" value="<?php echo esc_attr( $link_page ); ?>" /></p>
			<p class="enmse_num" <?php if ( esc_attr( $what_to_display ) == 'mostrecent' ) { echo "style=\"display:none;\"";} ?>>Number of Items to Display: <input name="<?php echo $this->get_field_name( 'display_number' ); ?>" type="text" value="<?php echo esc_attr( $display_number ); ?>" size="3" /></p>
        <?php
    }
 
    //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
		$instance['what_to_display'] = strip_tags( $new_instance['what_to_display'] );
 		$instance['series_type'] = strip_tags( $new_instance['series_type'] );
		$instance['series_archives'] = strip_tags( $new_instance['series_archives'] );
		$instance['extra_details'] = strip_tags( $new_instance['extra_details'] );
		$instance['display_number'] = strip_tags( $new_instance['display_number'] );
		$instance['link_page'] = strip_tags( $new_instance['link_page'] );
        return $instance;
    }
 
    //display the widget
    function widget($args, $instance) {
        extract($args);
 		
		global $wpdb;
        echo $before_widget;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $what_to_display = $instance['what_to_display'];
		$series_type = $instance['series_type'];
		$series_archives = $instance['series_archives'];
		$extra_details = $instance['extra_details'];

		$se_options = get_option( 'enm_seriesengine_options' );

		if ( isset($se_options['seriest']) ) { // Find Series Title
			$enmseseriest = $se_options['seriest'];
		} else {
			$enmseseriest = "Series";
		}

		if ( isset($se_options['seriestp']) ) { // Find Series Title
			$enmseseriestp = $se_options['seriestp'];
		} else {
			$enmseseriestp = "Series";
		}

		if ( isset($se_options['topict']) ) { // Find Topic Title
			$enmsetopict = $se_options['topict'];
		} else {
			$enmsetopict = "Topic";
		}

		if ( isset($se_options['topictp']) ) { // Find Topic Title
			$enmsetopictp = $se_options['topictp'];
		} else {
			$enmsetopictp = "Topics";
		}

		if ( isset($se_options['speakert']) ) { // Find Speaker Title
			$enmsespeakert = $se_options['speakert'];
		} else {
			$enmsespeakert = "Speaker";
		}

		if ( isset($se_options['speakertp']) ) { // Find Speaker Title
			$enmsespeakertp = $se_options['speakertp'];
		} else {
			$enmsespeakertp = "Speakers";
		}

		if ( isset($se_options['messaget']) ) { // Find Message Title
			$enmsemessaget = $se_options['messaget'];
		} else {
			$enmsemessaget = "Message";
		}

		if ( isset($se_options['messagetp']) ) { // Find Message Title
			$enmsemessagetp = $se_options['messagetp'];
		} else {
			$enmsemessagetp = "Messages";
		}

		if ( isset($se_options['language']) ) { // Find the Language
			$enmse_language = $se_options['language'];
		} else {
			$enmse_language = 1;
		}

		if ( $enmse_language == 10 ) { // French
			$enmse_from =  "de";
		} elseif ( $enmse_language == 9 ) { // Russian
			$enmse_from =  "когда";
		} elseif ( $enmse_language == 8 ) { // Japanese
			$enmse_from =  "いつ";
		} elseif ( $enmse_language == 7 ) { // Dutch
			$enmse_from =  "wanneer";
		} elseif ( $enmse_language == 6 ) { // Traditional Chinese
			$enmse_from =  "來自";
		} elseif ( $enmse_language == 5 ) { // Simplified Chinese
			$enmse_from =  "什么时候";
		} elseif ( $enmse_language == 4 ) { // Turkish
			$enmse_from =  "itibaren";
		} elseif ( $enmse_language == 3 ) { // German
			$enmse_from =  "von";
		} elseif ( $enmse_language == 2 ) { // Spanish
			$enmse_from =  "de";
		} else { // English
			$enmse_from =  "from";
		}
		
		/*$enmse_get_url = parse_url( strtok( $instance['link_page'], '&' ) );
		if ( $enmse_get_url['query'] == null ) {
			$link_page = strtok( $instance['link_page'], '&' ) . "?enmse=1";
		} else {
			$link_page = strtok( $instance['link_page'], '&' );
		}*/

		$enmse_get_url = parse_url( strtok( $instance['link_page'], '&' ) );
		if ( !isset($enmse_get_url['query']) ) {
			$link_page = strtok( $instance['link_page'], '&' ) . "?enmse=1";
		} else {
			$link_page = strtok( $instance['link_page'], '&' );
		}
		
		if ( $instance['display_number'] == NULL ) {
			$display_number = 5;
		} else {
			$display_number = $instance['display_number'];
		}

		$enmse_dateformat = get_option( 'date_format' ); 
		
		if ( $what_to_display == 'series' ) { // SERIES
			if ( $series_type > 0 ) { // Display all with Specific Series Type
				$enmse_spreparredsql = "SELECT widget_thumb, series_id, s_title, s_description, date FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL AND archived = 0 GROUP BY s_title ORDER BY start_date DESC LIMIT %d"; 	
				$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $series_type, $display_number );
				$enmse_series = $wpdb->get_results( $enmse_ssql );
				
				if ( $extra_details == 1 ) {
					// Get All Series Message Matches for Number of Messages
					$enmse_preparredsmmsql = "SELECT message_id, series_id FROM " . $wpdb->prefix . "se_series_message_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL"; 
					$enmse_smm = $wpdb->get_results( $enmse_preparredsmmsql );

				}
			} else { // Display Series of Every Series Type
				$enmse_spreparredsql = "SELECT widget_thumb, series_id, s_title, s_description, date FROM " . $wpdb->prefix . "se_series" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (series_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL AND archived = 0 GROUP BY s_title ORDER BY start_date DESC LIMIT %d"; 	
				$enmse_ssql = $wpdb->prepare( $enmse_spreparredsql, $display_number );
				$enmse_series = $wpdb->get_results( $enmse_ssql );
				
				if ( $extra_details == 1 ) {
					// Get All Series Message Matches for Number of Messages
					$enmse_preparredsmmsql = "SELECT message_id, series_id FROM " . $wpdb->prefix . "se_series_message_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL"; 
					$enmse_smm = $wpdb->get_results( $enmse_preparredsmmsql );
				}
			}
		} elseif ( $what_to_display == 'messages' ) { // MESSAGES
			if ( $series_type > 0 ) { 
				$enmse_sempreparredsql = "SELECT message_id, title, speaker, date, description FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY title ORDER BY date DESC LIMIT %d"; 	
				$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $series_type, $display_number );
				$enmse_messages = $wpdb->get_results( $enmse_semsql );
			} else { 
				$enmse_sempreparredsql = "SELECT message_id, title, speaker, date, description FROM " . $wpdb->prefix . "se_messages" . " WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() ORDER BY date DESC LIMIT %d"; 	
				$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $display_number );
				$enmse_messages = $wpdb->get_results( $enmse_semsql );
			}
		} elseif ( $what_to_display == 'topics' ) { // TOPICS
			if ( $series_type > 0 ) { // Display all with Specific Series Type
				$enmse_tpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY name ORDER BY sort_id ASC LIMIT %d"; 	
				$enmse_tsql = $wpdb->prepare( $enmse_tpreparredsql, $series_type, $display_number );
				$enmse_topics = $wpdb->get_results( $enmse_tsql );
				
				if ( $extra_details == 1 ) {
					// Get All Series Topic Matches for Number of Messages
					$enmse_preparredstmsql = "SELECT message_id, topic_id FROM " . $wpdb->prefix . "se_message_topic_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY message_id"; 
					$enmse_stmsql = $wpdb->prepare( $enmse_preparredstmsql, $series_type );
					$enmse_stm = $wpdb->get_results( $enmse_stmsql );
				}
			} else { // Display Topics of Every Series Type	
				$enmse_tpreparredsql = "SELECT topic_id, name FROM " . $wpdb->prefix . "se_topics" . " LEFT JOIN " . $wpdb->prefix . "se_message_topic_matches" . " USING (topic_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL GROUP BY name ORDER BY sort_id ASC LIMIT %d"; 	
				$enmse_tsql = $wpdb->prepare( $enmse_tpreparredsql, $display_number );
				$enmse_topics = $wpdb->get_results( $enmse_tsql );
				
				if ( $extra_details == 1 ) {
					// Get All Series Topic Matches for Number of Messages
					$enmse_preparredstmsql = "SELECT message_id, topic_id FROM " . $wpdb->prefix . "se_message_topic_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_id IS NOT NULL AND message_id IS NOT NULL GROUP BY message_id"; 
					$enmse_stm = $wpdb->get_results( $enmse_preparredstmsql );
				}
			}
		} elseif ( $what_to_display == 'speakers' ) { // SPEAKERS
			if ( $series_type > 0 ) { // Display all with Specific Series Type
				$enmse_sppreparredsql = "SELECT speaker_id, first_name, last_name FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY speaker_id ORDER BY date DESC LIMIT %d"; 	
				$enmse_spsql = $wpdb->prepare( $enmse_sppreparredsql, $series_type, $display_number );
				$enmse_speakers = $wpdb->get_results( $enmse_spsql );
				
				if ( $extra_details == 1 ) {
					// Get All Speaker Message Matches for Number of Messages
					$enmse_preparredmspmsql = "SELECT speaker_id, message_id FROM " . $wpdb->prefix . "se_message_speaker_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY message_id"; 
					$enmse_mspmsql = $wpdb->prepare( $enmse_preparredmspmsql, $series_type );
					$enmse_mspm = $wpdb->get_results( $enmse_mspmsql );
				}
			} else { // Display Speakers of Every Series Type	
				$enmse_sppreparredsql = "SELECT speaker_id, first_name, last_name FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches" . " USING (speaker_id) LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND message_id IS NOT NULL GROUP BY speaker_id ORDER BY date DESC LIMIT %d"; 	
				$enmse_spsql = $wpdb->prepare( $enmse_sppreparredsql, $display_number );
				$enmse_speakers = $wpdb->get_results( $enmse_spsql );
				
				if ( $extra_details == 1 ) {
					// Get All Speaker Message Matches for Number of Messages
					$enmse_preparredmspmsql = "SELECT speaker_id, message_id FROM " . $wpdb->prefix . "se_message_speaker_matches LEFT JOIN " . $wpdb->prefix . "se_messages" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_id IS NOT NULL AND message_id IS NOT NULL GROUP BY message_id"; 
					$enmse_mspm = $wpdb->get_results( $enmse_preparredmspmsql );
				}
			}
		} else { // Most Recent Message (Beta)
			if ( $series_type > 0 ) { 
				$enmse_sempreparredsql = "SELECT message_id, title, date, description, series_id FROM " . $wpdb->prefix . "se_messages" . " LEFT JOIN " . $wpdb->prefix . "se_series_message_matches" . " USING (message_id) LEFT JOIN " . $wpdb->prefix . "se_series_type_matches" . " USING (series_id) WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() AND series_type_id = %d AND message_id IS NOT NULL GROUP BY title ORDER BY date DESC LIMIT 1"; 	
				$enmse_semsql = $wpdb->prepare( $enmse_sempreparredsql, $series_type );
				$enmse_messages = $wpdb->get_row( $enmse_semsql, OBJECT );

				if ( !empty($enmse_messages) ) {
					// Get the Speaker
					$enmse_findthespeakersql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches USING (speaker_id) WHERE message_id = %d GROUP BY speaker_id LIMIT 1"; 
					$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_messages->message_id );
					$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );

					$enmse_sspreparredsql = "SELECT widget_thumb FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 		
					$enmse_findtheseries = $wpdb->prepare( $enmse_sspreparredsql, $enmse_messages->series_id );
					$enmse_singleseries = $wpdb->get_row( $enmse_findtheseries, OBJECT );
				}
			} else { 
				$enmse_sempreparredsql = "SELECT message_id, title, speaker, date, description, series_id FROM " . $wpdb->prefix . "se_messages" . " WHERE (embed_code != '0' OR video_embed_url != '0' OR audio_url != '0' OR (alternate_toggle = 'Yes' AND ( alternate_embed != '0' OR additional_video_embed_url != '0' ))) AND date <= CURDATE() ORDER BY date DESC LIMIT 1"; 	
				$enmse_messages = $wpdb->get_row( $enmse_sempreparredsql, OBJECT );

				if ( !empty($enmse_messages) ) {
					// Get the Speaker
					$enmse_findthespeakersql = "SELECT * FROM " . $wpdb->prefix . "se_speakers" . " LEFT JOIN " . $wpdb->prefix . "se_message_speaker_matches USING (speaker_id) WHERE message_id = %d GROUP BY speaker_id LIMIT 1"; 
					$enmse_findthespeaker = $wpdb->prepare( $enmse_findthespeakersql, $enmse_messages->message_id );
					$enmse_speaker = $wpdb->get_row( $enmse_findthespeaker, OBJECT );

					$enmse_sspreparredsql = "SELECT widget_thumb FROM " . $wpdb->prefix . "se_series" . " WHERE series_id = %d"; 		
					$enmse_findtheseries = $wpdb->prepare( $enmse_sspreparredsql, $enmse_messages->series_id );
					$enmse_singleseries = $wpdb->get_row( $enmse_findtheseries, OBJECT );
				}
			}
		}

 
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
        if ( $what_to_display != 'mostrecent' ) { echo '<ul class="enmse-widget-list">'; }
		if ( $what_to_display == 'series' ) { // SERIES
			if ( !empty($enmse_series) ) {
				if ( $extra_details == 1 ) {
					foreach ($enmse_series as $enmse_s) {
						$enmse_smm_count = 0; 
						foreach ( $enmse_smm as $smm ) { 
							if ( $smm->series_id == $enmse_s->series_id ) { 
								$enmse_smm_count = $enmse_smm_count+1; 
							} 
						} 
						if ( $enmse_smm_count == 1 ) { 
							$messagecount = "1 " . $enmsemessaget;
						} elseif ( $enmse_smm_count > 1 ) { 
							$messagecount = $enmse_smm_count . " " . $enmsemessagetp; 
						}
						if ( $enmse_s->s_description != NULL ) {
							$description = '<p>' . stripslashes($enmse_s->s_description) . '</p>';
						} else {
							$description = null;
						}
						if ( $enmse_s->widget_thumb != NULL ) {
							$thumbnail = '<img src="' . $enmse_s->widget_thumb . '" class="enmse-widget-series-thumb" />';
						} else {
							$thumbnail = null;
						}
						echo '<li class="enmse-widgetseries">' . $thumbnail . '<h5>'. date_i18n($enmse_dateformat, strtotime($enmse_s->date)) .'</h5><a href="' . $link_page . '&amp;enmse_sid=' . $enmse_s->series_id . '">' . stripslashes($enmse_s->s_title) . '</a><h4>' . $messagecount . '</h4>' . $description . '</li>';
					};
					if ( $series_archives == 1 ) {
						echo '<li class="enmse-widgetseries"><a href="' . $link_page . '&amp;enmse_archives=1' . '">View ' . $enmseseriest . ' Archives...</a></li>';
					}
				} else {
					foreach ($enmse_series as $enmse_s) {
						echo '<li class="enmse-widgetseries"><a href="' . $link_page . '&amp;enmse_sid=' . $enmse_s->series_id . '">' . stripslashes($enmse_s->s_title) . '</a></li>';
					};
					if ( $series_archives == 1 ) {
						echo '<li class="enmse-widgetseries"><a href="' . $link_page . '&amp;enmse_archives=1' . '">View ' . $enmseseriest . ' Archives...</a></li>';
					}
				}
			}
		} elseif ( $what_to_display == 'messages' ) { // MESSAGES
			if ( !empty($enmse_messages) ) {
				if ( $extra_details == 1 ) {
					foreach ($enmse_messages as $enmse_m) {
						if ( $enmse_m->description != NULL ) {
							$description = '<p>' . stripslashes($enmse_m->description) . '</p>';
						} else {
							$description = null;
						}
						echo '<li class="enmse-widgetmessage"><h5>' . date_i18n($enmse_dateformat, strtotime($enmse_m->date)) . '</h5><a href="' . $link_page . '&amp;enmse_mid=' . $enmse_m->message_id . '">' . stripslashes($enmse_m->title) . '</a><h4>' . $enmse_from . ' ' . stripslashes($enmse_m->speaker) . '</h4>' . $description . '</li>';
					};
				} else {
					foreach ($enmse_messages as $enmse_m) {
						echo '<li class="enmse-widgetmessage"><a href="' . $link_page . '&amp;enmse_mid=' . $enmse_m->message_id . '">' . stripslashes($enmse_m->title) . '</a></li>';
					};
				}
			}
		} elseif ( $what_to_display == 'topics' ) { // TOPICS
			if ( !empty($enmse_topics) ) {
				if ( $extra_details == 1 ) {
					foreach ($enmse_topics as $enmse_t) {
						$enmse_stm_count = 0; 
						foreach ( $enmse_stm as $stm ) { 
							if ( $stm->topic_id == $enmse_t->topic_id ) { 
								$enmse_stm_count = $enmse_stm_count+1; 
							} 
						} 
						if ( $enmse_stm_count == 1 ) { 
							$messagecount = "1 " . $enmsemessaget;
						} elseif ( $enmse_stm_count > 1 ) { 
							$messagecount = $enmse_stm_count . " " . $enmsemessagetp; 
						} 
						echo '<li class="enmse-widgettopic"><a href="' . $link_page . '&amp;enmse_tid=' . $enmse_t->topic_id . '">' . stripslashes($enmse_t->name) . '</a><h4>' . $messagecount . '</h4></li>';
					};
				} else {
					foreach ($enmse_topics as $enmse_t) {
						echo '<li class="enmse-widgettopic"><a href="' . $link_page . '&amp;enmse_tid=' . $enmse_t->topic_id . '">' . stripslashes($enmse_t->name) . '</a></li>';
					};
				};
			}
		} elseif ( $what_to_display == 'speakers' ) { // SPEAKERS
			if ( !empty($enmse_speakers) ) {
				if ( $extra_details == 1 ) {
					foreach ($enmse_speakers as $enmse_sp) {
						$enmse_mspm_count = 0; 
						foreach ( $enmse_mspm as $mspm ) { 
							if ( $mspm->speaker_id == $enmse_sp->speaker_id ) { 
								$enmse_mspm_count = $enmse_mspm_count+1; 
							} 
						} 
						if ( $enmse_mspm_count == 1 ) { 
							$messagecount = "1 " . $enmsemessaget;
						} elseif ( $enmse_mspm_count > 1 ) { 
							$messagecount = $enmse_mspm_count . " " . $enmsemessagetp; 
						} 
						echo '<li class="enmse-widgetspeaker"><a href="' . $link_page . '&amp;enmse_spid=' . $enmse_sp->speaker_id . '">' . stripslashes($enmse_sp->first_name) . ' ' . stripslashes($enmse_sp->last_name) . '</a><h4>' . $messagecount . '</h4></li>';
					};
				} else {
					foreach ($enmse_speakers as $enmse_sp) {
						echo '<li class="enmse-widgetspeaker"><a href="' . $link_page . '&amp;enmse_spid=' . $enmse_sp->speaker_id . '">' . stripslashes($enmse_sp->first_name) . ' ' . stripslashes($enmse_sp->last_name) . '</a></li>';
					};
				};
			}
		} else { // Most Recent
			if ( !empty($enmse_messages) ) {
				echo '<a href="' . $link_page . '&amp;enmse_mid=' . $enmse_messages->message_id . '"><img src="' . $enmse_singleseries->widget_thumb . '" alt="' . stripslashes($enmse_messages->title) . '"></a>';
				echo '<h4><a href="' . $link_page . '&amp;enmse_mid=' . $enmse_messages->message_id . '">' . stripslashes($enmse_messages->title) . '</a></h4>';
				echo '<h5><a href="' . $link_page . '&amp;enmse_mid=' . $enmse_messages->message_id . '">' . stripslashes($enmse_speaker->first_name) . " " . stripslashes($enmse_speaker->last_name) . ' - <em>' . date('F j', strtotime($enmse_messages->date)) . '</em></a></h5>';	
			}
		}
		if ( $what_to_display != 'mostrecent' ) { echo '</ul>'; }
        echo $after_widget;
    }

}
 ?>