<?php /* ----- Groups Engine - Pagination for admin contacts ----- */
		if ( $wpdb != null ) { // Verify that user is allowed to access this page
			
		function enmge_curpagename() {
			return admin_url( '/admin.php?page=groupsengine_plugin/groupsengine_plugin.php_contacts', __FILE__ );
		}
		
		if ( isset($_GET['enmge_cs']) ) { // If they're viewing groups by group type
			if ($enmge_pages > 1) {
				$enmge_thispage = enmge_curpagename();
				$enmge_current_page = ($enmge_start/$enmge_display) + 1;
				echo '<div class="tablenav groupsengine"><div class="tablenav-pages">';
				if (!isset($_GET['enmge_c']) && ($enmge_current_page != $enmge_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmge_start - $enmge_display) . ' of ' . $enmge_messagecount . '</span>&nbsp;&nbsp;&nbsp;'; 
				} elseif ($enmge_current_page == $enmge_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmge_start+1) . '-' . $enmge_messagecount . ' of ' . $enmge_messagecount . '</span>&nbsp;&nbsp;&nbsp;';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmge_start+1) . '-' . ($enmge_start+$enmge_display) . ' of ' . $enmge_messagecount . '</span>&nbsp;&nbsp;&nbsp;';
				}


				if ($enmge_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . ($enmge_start - $enmge_display) . '&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="previous page-numbers">&laquo;</a> ';
				}

				if ($enmge_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmge_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmge_current_page) {
								echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_display * ($i - 1))) . '&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="page-numbers">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_pages - 1) * $enmge_display) . '&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="page-numbers">&hellip;' . $enmge_pages . '</a>';
					} else {

						if ($enmge_pages - $enmge_current_page <= 5) {
							echo '<a href="' . $enmge_thispage . '&amp;enmge_c=0&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="page-numbers">1&hellip;</a>';
							$enmge_startpoint = $enmge_pages - 10;
							for ($i = $enmge_startpoint; $i <= $enmge_pages; $i++) { 
								if ($i != $enmge_current_page) {
									echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_display * ($i - 1))) . '&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="page-numbers">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmge_current_page != 6) {
								echo '<a href="' . $enmge_thispage . '&amp;enmge_c=0&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="page-numbers">1&hellip;</a>';
							}					
							$enmge_startpoint = $enmge_current_page - 5;
							$enmge_endpoint = $enmge_current_page + 5;
							for ($i = $enmge_startpoint; $i <= $enmge_endpoint; $i++) { 
								if ($i != $enmge_current_page) {
									echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_display * ($i - 1))) . '&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="page-numbers">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_pages - 1) * $enmge_display) . '&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="page-numbers">&hellip;' . $enmge_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmge_pages; $i++) { 
						if ($i != $enmge_current_page) {
							echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_display * ($i - 1))) . '&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="page-numbers">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmge_current_page != $enmge_pages) { // make next button if not the last page
					echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . ($enmge_start + $enmge_display) . '&amp;enmge_p=' . $enmge_pages . '&amp;enmge_cs=' . $enmge_cs . '" class="next page-numbers">&raquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div></div>\n"; 	
			} else {
				echo "<div class=\"nothing\"></div>";
			}
			
		} else {
			if ($enmge_pages > 1) {
				$enmge_thispage = enmge_curpagename();
				$enmge_current_page = ($enmge_start/$enmge_display) + 1;
				echo '<div class="tablenav groupsengine"><div class="tablenav-pages">';
				if (!isset($_GET['enmge_c']) && ($enmge_current_page != $enmge_pages)) {
					echo '<span class="displaying-num">Displaying 1' . ($enmge_start - $enmge_display) . ' of ' . $enmge_messagecount . '</span>&nbsp;&nbsp;&nbsp;'; 
				} elseif ($enmge_current_page == $enmge_pages) {
					echo '<span class="displaying-num">Displaying ' . ($enmge_start+1) . '-' . $enmge_messagecount . ' of ' . $enmge_messagecount . '</span>&nbsp;&nbsp;&nbsp;';
				} else {
					echo '<span class="displaying-num">Displaying ' . ($enmge_start+1) . '-' . ($enmge_start+$enmge_display) . ' of ' . $enmge_messagecount . '</span>&nbsp;&nbsp;&nbsp;';
				}


				if ($enmge_current_page != 1) { // make previous button if not first page
					echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . ($enmge_start - $enmge_display) . '&amp;enmge_p=' . $enmge_pages . '" class="previous page-numbers">&laquo;</a> ';
				}

				if ($enmge_pages > 11) { // Make no more than 10 links to other pages at a time.
					if ($enmge_current_page < 6) {
						for ($i = 1; $i <= 11; $i++) { 
							if ($i != $enmge_current_page) {
								echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_display * ($i - 1))) . '&amp;enmge_p=' . $enmge_pages . '" class="page-numbers">' . $i . '</a> ';
							} else {
								echo '<span class="page-numbers current">' . $i . '</span> ';
							}
						} 
						echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_pages - 1) * $enmge_display) . '&amp;enmge_p=' . $enmge_pages . '" class="page-numbers">&hellip;' . $enmge_pages . '</a>';
					} else {

						if ($enmge_pages - $enmge_current_page <= 5) {
							echo '<a href="' . $enmge_thispage . '&amp;enmge_c=0&amp;enmge_p=' . $enmge_pages . '" class="page-numbers">1&hellip;</a>';
							$enmge_startpoint = $enmge_pages - 10;
							for ($i = $enmge_startpoint; $i <= $enmge_pages; $i++) { 
								if ($i != $enmge_current_page) {
									echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_display * ($i - 1))) . '&amp;enmge_p=' . $enmge_pages . '" class="page-numbers">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 

						} else {
							if ($enmge_current_page != 6) {
								echo '<a href="' . $enmge_thispage . '&amp;enmge_c=0&amp;enmge_p=' . $enmge_pages . '" class="page-numbers">1&hellip;</a>';
							}					
							$enmge_startpoint = $enmge_current_page - 5;
							$enmge_endpoint = $enmge_current_page + 5;
							for ($i = $enmge_startpoint; $i <= $enmge_endpoint; $i++) { 
								if ($i != $enmge_current_page) {
									echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_display * ($i - 1))) . '&amp;enmge_p=' . $enmge_pages . '" class="page-numbers">' . $i . '</a> ';
								} else {
									echo '<span class="page-numbers current">' . $i . '</span> ';
								}
							} 
							echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_pages - 1) * $enmge_display) . '&amp;enmge_p=' . $enmge_pages . '" class="page-numbers">&hellip;' . $enmge_pages . '</a>';	
						}
					}
				} else {
					for ($i = 1; $i <= $enmge_pages; $i++) { 
						if ($i != $enmge_current_page) {
							echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . (($enmge_display * ($i - 1))) . '&amp;enmge_p=' . $enmge_pages . '" class="page-numbers">' . $i . '</a> ';
						} else {
							echo '<span class="page-numbers current">' . $i . '</span> ';
						}
					} 
				}

				if ($enmge_current_page != $enmge_pages) { // make next button if not the last page
					echo '<a href="' . $enmge_thispage . '&amp;enmge_c=' . ($enmge_start + $enmge_display) . '&amp;enmge_p=' . $enmge_pages . '" class="next page-numbers">&raquo;</a>';
				}

				echo "<div style=\"clear: both;\"></div></div></div>\n"; 	
			} else {
				echo "<div class=\"nothing\"></div>";
			}
		}
		
		// Deny access to sneaky people!
		} else {
			exit("Access Denied");
		}
?>