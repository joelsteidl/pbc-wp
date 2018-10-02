<?php /* ----- Series Engine - Pagination for Related Messages (with shortcode options) ----- */
		if ( $wpdb != null ) { // Verify that user is allowed to access this page
		if ( isset($_GET['enmse_av']) ) {
			$enmse_mval = "&amp;enmse_av=1";
		} elseif ( isset($_GET['enmse_xv']) ) {
			$enmse_mval = "&amp;enmse_xv=1";
		} else {
			$enmse_mval = "";
		}
		
		if ( (isset($_GET['enmse_tid']) && is_numeric($_GET['enmse_tid'])) || ($enmse_dst > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a topic specified?

			if ($enmse_pages > 1) {
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="se-pagination">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="previous page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">&laquo;<span> ' . $enmse_pageback . '</span></a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="next page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_tid=' . $enmse_singletopic->topic_id . $enmse_mval . '"><span>' . $enmse_pagemore . ' </span>&raquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div>\n"; 	
			}
			
		} elseif ( (isset($_GET['enmse_bid']) && is_numeric($_GET['enmse_bid'])) || ($enmse_dsb > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_spid'])) ) { // Is a book specified?

			if ($enmse_pages > 1) {
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="se-pagination">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="previous page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">&laquo;<span> ' . $enmse_pageback . '</span></a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="next page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_bid=' . $enmse_singlebook->book_id . $enmse_mval . '"><span>' . $enmse_pagemore . ' </span>&raquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div>\n"; 	
			}
			
		} elseif ( (isset($_GET['enmse_sid']) && is_numeric($_GET['enmse_sid'])) || ($enmse_dss > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid']) && !isset($_GET['enmse_spid'])) ) { // Is a series specified?

			if ($enmse_pages > 1) {
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="se-pagination">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="previous page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">&laquo;<span> ' . $enmse_pageback . '</span></a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="next page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '"><span>' . $enmse_pagemore . ' </span>&raquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div>\n"; 	
			}

		} elseif ( (isset($_GET['enmse_spid']) && is_numeric($_GET['enmse_spid'])) || ($enmse_dssp > 0 && !isset($_GET['enmse_am']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid'])) ) { // Is a speaker specified?

			if ($enmse_pages > 1) {
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="se-pagination">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="previous page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">&laquo;<span> ' . $enmse_pageback . '</span></a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="next page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_spid=' . $enmse_singlespeaker->speaker_id . $enmse_mval . '"><span>' . $enmse_pagemore . ' </span>&raquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div>\n"; 	
			}

		} elseif ( isset($_GET['enmse_am']) && is_numeric($_GET['enmse_am']) || ($enmse_dam > 0 && !isset($_GET['enmse_spid']) && !isset($_GET['enmse_sid']) && !isset($_GET['enmse_tid']) && !isset($_GET['enmse_bid'])) ) { /* Display all messages */

			if ($enmse_pages > 1) {
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="se-pagination">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="previous page-numbers enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">&laquo;<span> ' . $enmse_pageback . '</span></a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_am=1&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="next page-numbers enmse-ajax-page" name="&amp;enmse_am=1&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . $enmse_mval . '"><span>' . $enmse_pagemore . ' </span>&raquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div>\n"; 	
			}
			
		} else {

			if ($enmse_pages > 1) {
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="se-pagination">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="previous page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">&laquo;<span> ' . $enmse_pageback . '</span></a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers wide enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="page-numbers number enmse-ajax-page" name="&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_o=1&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '&amp;enmse_sds=' . $enmse_sds . '" class="next page-numbers enmse-ajax-page" name="&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_mid=' . $enmse_singlemessage->message_id . '&amp;enmse_sid=' . $enmse_singleseries->series_id . $enmse_mval . '"><span>' . $enmse_pagemore . ' </span>&raquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div>\n"; 	
			}
			
		}
		
		// Deny access to sneaky people!
		} else {
			exit("Access Denied");
		}
?>