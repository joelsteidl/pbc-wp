<?php /* ----- Series Engine - Pagination for admin messages ----- */
		if ( $wpdb != null ) { // Verify that user is allowed to access this page
			
		function enmse_curpagename() {
			return admin_url( '/admin.php?page=seriesengine_plugin/seriesengine_plugin.php', __FILE__ );
		}
		
		if ( isset($_GET['enmse_sid']) ) { // If they're viewing messages by series
			if ($enmse_pages > 1) {
				$enmse_thispage = enmse_curpagename();
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="tablenav seriesengine"><div class="tablenav-pages"><div class="pagination-links">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="previous-page button">&lsaquo;</a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="page-numbers button">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="page-numbers button">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_sid=' . $enmse_sid . '" class="next-page button">&rsaquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div></div></div>\n"; 	
			}
			
		} elseif ( isset($_GET['enmse_tid']) ) { // If they're viewing messages by topic
			if ($enmse_pages > 1) {
				$enmse_thispage = enmse_curpagename();
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="tablenav seriesengine"><div class="tablenav-pages"><div class="pagination-links">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="previous-page button">&lsaquo;</a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="page-numbers button">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="page-numbers button">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_tid=' . $enmse_tid . '" class="next-page button">&rsaquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div></div></div>\n"; 	
			}
		} elseif ( isset($_GET['enmse_bid']) ) { // If they're viewing messages by book
			if ($enmse_pages > 1) {
				$enmse_thispage = enmse_curpagename();
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="tablenav seriesengine"><div class="tablenav-pages"><div class="pagination-links">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="previous-page button">&lsaquo;</a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="page-numbers button">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="page-numbers button">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_bid=' . $enmse_bid . '" class="next-page button">&rsaquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div></div></div>\n"; 	
			}
		} elseif ( isset($_GET['enmse_spid']) ) { // If they're viewing messages by speaker
			if ($enmse_pages > 1) {
				$enmse_thispage = enmse_curpagename();
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="tablenav seriesengine"><div class="tablenav-pages"><div class="pagination-links">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}
		
		
				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="previous-page button">&lsaquo;</a> ';
				}
		
				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="page-numbers button">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';
					} else {
		
						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
		
						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="page-numbers button">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}
		
				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '&amp;enmse_spid=' . $enmse_spid . '" class="next-page button">&rsaquo;</a>';
				}
		
				echo "<div style=\"clear: both;\"></div></div></div></div>\n"; 	
			}
		} else {
			if ($enmse_pages > 1) {
				$enmse_thispage = enmse_curpagename();
				$enmse_current_page = ($enmse_start/$enmse_display) + 1;
				echo '<div class="tablenav seriesengine"><div class="tablenav-pages"><div class="pagination-links">';
				if (!isset($_GET['enmse_c']) && ($enmse_current_page != $enmse_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmse_start - $enmse_display) . ' of ' . $enmse_messagecount . '</span>'; 
				} elseif ($enmse_current_page == $enmse_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . $enmse_messagecount . ' of ' . $enmse_messagecount . '</span>';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmse_start+1) . '-' . ($enmse_start+$enmse_display) . ' of ' . $enmse_messagecount . '</span>';
				}


				if ($enmse_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start - $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '" class="previous-page button">&lsaquo;</a> ';
				}

				if ($enmse_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmse_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmse_current_page) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '" class="page-numbers button">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';
					} else {

						if ($enmse_pages - $enmse_current_page <= 5) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							$enmse_startpoint = $enmse_pages - 10;
							for ($i = $enmse_startpoint; $i <= $enmse_pages; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmse_current_page != 6) {
								echo '<a href="' . $enmse_thispage . '&amp;enmse_c=0&amp;enmse_p=' . $enmse_pages . '" class="page-numbers button" style="margin-right: 4px">1&hellip;</a>';
							}					
							$enmse_startpoint = $enmse_current_page - 5;
							$enmse_endpoint = $enmse_current_page + 5;
							for ($i = $enmse_startpoint; $i <= $enmse_endpoint; $i++) { 
								if ($i != $enmse_current_page) {
									echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '" class="page-numbers button">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_pages - 1) * $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '" class="page-numbers button" style="margin-right: 4px">&hellip;' . $enmse_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmse_pages; $i++) { 
						if ($i != $enmse_current_page) {
							echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . (($enmse_display * ($i - 1))) . '&amp;enmse_p=' . $enmse_pages . '" class="page-numbers button">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmse_current_page != $enmse_pages) { // make next button if not the last page
					echo '<a href="' . $enmse_thispage . '&amp;enmse_c=' . ($enmse_start + $enmse_display) . '&amp;enmse_p=' . $enmse_pages . '" class="next-page button">&rsaquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div></div></div>\n"; 	
			}
		}
		
		// Deny access to sneaky people!
		} else {
			exit("Access Denied");
		}
?>