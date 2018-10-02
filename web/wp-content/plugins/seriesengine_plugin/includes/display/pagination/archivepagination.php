<?php /* ----- Series Engine - Pagination for Related Messages ----- */
		if ( $wpdb != null ) { // Verify that user is allowed to access this page
		
			if ( is_numeric($enmse_dsst) && $enmse_dsst > 0 ) { // Is a series type specified?

				if ($enmse_apages > 1) {
					$enmse_acurrent_page = ($enmse_astart/$enmse_adisplay) + 1;
					echo '<div class="se-pagination">';
					if (!isset($_GET['enmse_ac']) && ($enmse_acurrent_page != $enmse_apages)) {
						echo '<span class="displaying-num">Displaying 1' . ($enmse_astart - $enmse_adisplay) . ' of ' . $enmse_archivecount . '</span>'; 
					} elseif ($enmse_acurrent_page == $enmse_apages) {
						echo '<span class="displaying-num">Displaying ' . ($enmse_astart+1) . '-' . $enmse_archivecount . ' of ' . $enmse_archivecount . '</span>';
					} else {
						echo '<span class="displaying-num">Displaying ' . ($enmse_astart+1) . '-' . ($enmse_astart+$enmse_adisplay) . ' of ' . $enmse_archivecount . '</span>';
					}


					if ($enmse_acurrent_page != 1) { // make previous button if not first page
						echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . ($enmse_astart - $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="previous page-numbers enmse-ajax-apage" name="&amp;enmse_ac=' . ($enmse_astart - $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">&laquo;<span> Back</span></a> ';
					}

					if ($enmse_apages > 11) { // Make no more than 10 links to other pages at a time.
						if ($enmse_acurrent_page < 6) {
							for ($i = 1; $i <= 11; $i++) { 
								if ($i != $enmse_acurrent_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="page-numbers number enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_apages - 1) * $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="page-numbers wide enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_apages - 1) * $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">&hellip;' . $enmse_apages . '</a>';
						} else {

							if ($enmse_apages - $enmse_acurrent_page <= 5) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="page-numbers wide enmse-ajax-apage" name="&amp;enmse_c=0&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">1&hellip;</a>';
								$enmse_astartpoint = $enmse_apages - 10;
								for ($i = $enmse_astartpoint; $i <= $enmse_apages; $i++) { 
									if ($i != $enmse_acurrent_page) {
										echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="page-numbers number enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">' . $i . '</a> ';
									} else {
										echo '<span class="page-numbers current">' . $i . '</span> ';
									}
								} 

							} else {
								if ($enmse_acurrent_page != 6) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="page-numbers wide enmse-ajax-apage" name="&amp;enmse_c=0&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">1&hellip;</a>';
								}					
								$enmse_astartpoint = $enmse_acurrent_page - 5;
								$enmse_endpoint = $enmse_acurrent_page + 5;
								for ($i = $enmse_astartpoint; $i <= $enmse_endpoint; $i++) { 
									if ($i != $enmse_acurrent_page) {
										echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="page-numbers number enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">' . $i . '</a> ';
									} else {
										echo '<span class="page-numbers current">' . $i . '</span> ';
									}
								} 
								echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_apages - 1) * $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="page-numbers wide enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_apages - 1) * $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">&hellip;' . $enmse_apages . '</a>';	
							}
						}
					} else {
						for ($i = 1; $i <= $enmse_apages; $i++) { 
							if ($i != $enmse_acurrent_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="page-numbers number enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
					}

					if ($enmse_acurrent_page != $enmse_apages) { // make next button if not the last page
						echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . ($enmse_astart + $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '" class="next page-numbers enmse-ajax-apage" name="&amp;enmse_ac=' . ($enmse_astart + $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '&amp;enmse_dsst=' . $enmse_dsst . '"><span>More </span>&raquo;</a>';
					}

					echo "<div style=\"clear: both;\"></div></div>\n"; 	
				}
				
			} else {

				if ($enmse_apages > 1) {
					$enmse_acurrent_page = ($enmse_astart/$enmse_adisplay) + 1;
					echo '<div class="se-pagination">';
					if (!isset($_GET['enmse_ac']) && ($enmse_acurrent_page != $enmse_apages)) {
						echo '<span class="displaying-num">Displaying 1' . ($enmse_astart - $enmse_adisplay) . ' of ' . $enmse_archivecount . '</span>'; 
					} elseif ($enmse_acurrent_page == $enmse_apages) {
						echo '<span class="displaying-num">Displaying ' . ($enmse_astart+1) . '-' . $enmse_archivecount . ' of ' . $enmse_archivecount . '</span>';
					} else {
						echo '<span class="displaying-num">Displaying ' . ($enmse_astart+1) . '-' . ($enmse_astart+$enmse_adisplay) . ' of ' . $enmse_archivecount . '</span>';
					}


					if ($enmse_acurrent_page != 1) { // make previous button if not first page
						echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . ($enmse_astart - $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '" class="previous page-numbers enmse-ajax-apage" name="&amp;enmse_ac=' . ($enmse_astart - $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '">&laquo;<span> Back</span></a> ';
					}

					if ($enmse_apages > 11) { // Make no more than 10 links to other pages at a time.
						if ($enmse_acurrent_page < 6) {
							for ($i = 1; $i <= 11; $i++) { 
								if ($i != $enmse_acurrent_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '" class="page-numbers number enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_apages - 1) * $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '" class="page-numbers wide enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_apages - 1) * $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '">&hellip;' . $enmse_apages . '</a>';
						} else {

							if ($enmse_apages - $enmse_acurrent_page <= 5) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_ap=' . $enmse_apages . '" class="page-numbers wide enmse-ajax-apage" name="&amp;enmse_c=0&amp;enmse_ap=' . $enmse_apages . '">1&hellip;</a>';
								$enmse_astartpoint = $enmse_apages - 10;
								for ($i = $enmse_astartpoint; $i <= $enmse_apages; $i++) { 
									if ($i != $enmse_acurrent_page) {
										echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '" class="page-numbers number enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '">' . $i . '</a> ';
									} else {
										echo '<span class="page-numbers current">' . $i . '</span> ';
									}
								} 

							} else {
								if ($enmse_acurrent_page != 6) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_c=0&amp;enmse_ap=' . $enmse_apages . '" class="page-numbers wide enmse-ajax-apage" name="&amp;enmse_c=0&amp;enmse_ap=' . $enmse_apages . '">1&hellip;</a>';
								}					
								$enmse_astartpoint = $enmse_acurrent_page - 5;
								$enmse_endpoint = $enmse_acurrent_page + 5;
								for ($i = $enmse_astartpoint; $i <= $enmse_endpoint; $i++) { 
									if ($i != $enmse_acurrent_page) {
										echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '" class="page-numbers number enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '">' . $i . '</a> ';
									} else {
										echo '<span class="page-numbers current">' . $i . '</span> ';
									}
								} 
								echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_apages - 1) * $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '" class="page-numbers wide enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_apages - 1) * $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '">&hellip;' . $enmse_apages . '</a>';	
							}
						}
					} else {
						for ($i = 1; $i <= $enmse_apages; $i++) { 
							if ($i != $enmse_acurrent_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '" class="page-numbers number enmse-ajax-apage" name="&amp;enmse_ac=' . (($enmse_adisplay * ($i - 1))) . '&amp;enmse_ap=' . $enmse_apages . '">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
					}

					if ($enmse_acurrent_page != $enmse_apages) { // make next button if not the last page
						echo '<a href="' . $enmse_thispage . '&amp;enmse_archives=1&amp;enmse_o=1&amp;enmse_ac=' . ($enmse_astart + $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '" class="next page-numbers enmse-ajax-apage" name="&amp;enmse_ac=' . ($enmse_astart + $enmse_adisplay) . '&amp;enmse_ap=' . $enmse_apages . '"><span>More </span>&raquo;</a>';
					}

					echo "<div style=\"clear: both;\"></div></div>\n"; 	
				}
				
			}
		
		// Deny access to sneaky people!
		} else {
			exit("Access Denied");
		}
?>