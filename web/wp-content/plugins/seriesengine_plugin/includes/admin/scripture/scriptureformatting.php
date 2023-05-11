<?php // For formatting scripture links in various parts of the plugin

	if ( $enmse_language == 10 ) { 
		include(ENMSE_PLUGIN_PATH . 'includes/lang/fre_bible_books.php');
	} elseif ( $enmse_language == 9 ) { 
		include(ENMSE_PLUGIN_PATH . 'includes/lang/rus_bible_books.php');
	} elseif ( $enmse_language == 8 ) { 
		include(ENMSE_PLUGIN_PATH . 'includes/lang/jap_bible_books.php');
	} elseif ( $enmse_language == 7 ) { 
		include(ENMSE_PLUGIN_PATH  . 'includes/lang/dut_bible_books.php');
	} elseif ( $enmse_language == 6 ) { 
		include(ENMSE_PLUGIN_PATH  . 'includes/lang/chint_bible_books.php');
	} elseif ( $enmse_language == 5 ) { 
		include(ENMSE_PLUGIN_PATH  . 'includes/lang/chins_bible_books.php');
	} elseif ( $enmse_language == 4 ) { 
		include(ENMSE_PLUGIN_PATH  . 'includes/lang/turk_bible_books.php');
	} elseif ( $enmse_language == 3 ) { 
		include(ENMSE_PLUGIN_PATH  . 'includes/lang/ger_bible_books.php');
	} elseif ( $enmse_language == 2 ) { 
		include(ENMSE_PLUGIN_PATH  . 'includes/lang/spa_bible_books.php');
	} else {
		include(ENMSE_PLUGIN_PATH  . 'includes/lang/eng_bible_books.php');
	}

	if ( $enmse_start_book == 1 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$shortbookname = $enmse_bookabr[$enmse_start_book];
		$bookcode = "GEN";
	} elseif ( $enmse_start_book == 2 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$shortbookname = $enmse_bookabr[$enmse_start_book];
		$bookcode = "EXO";
	} elseif ( $enmse_start_book == 3 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$shortbookname = $enmse_bookabr[$enmse_start_book];
		$bookcode = "LEV";
	} elseif ( $enmse_start_book == 4 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$shortbookname = $enmse_bookabr[$enmse_start_book];
		$bookcode = "NUM";
	} elseif ( $enmse_start_book == 5 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$shortbookname = $enmse_bookabr[$enmse_start_book];
		$bookcode = "DEU";
	} elseif ( $enmse_start_book == 6 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JOS";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 7 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JDG";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 8 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "RUT";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 9 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "1SA";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 10 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "2SA";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 11 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "1KI";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 12 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "2KI";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 13 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "1CH";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 14 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "2CH";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 15 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "EZR";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 16 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "NEH";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 17 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "EST";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 18 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JOB";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 19 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "PSA";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 20 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "PRO";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 21 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "ECC";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 22 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "SNG";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 23 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "ISA";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 24 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JER";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 25 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "LAM";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 26 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "EZK";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 27 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "DAN";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 28 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "HOS";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 29 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JOL";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 30 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "AMO";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 31 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "OBA";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 32 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JON";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 33 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "MIC";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 34 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "NAM";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 35 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "HAB";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 36 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "ZEP";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 37 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "HAG";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 38 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "ZEC";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 39 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "MAL";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 40 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "MAT";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 41 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "MRK";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 42 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "LUK";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 43 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JHN";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 44 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "ACT";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 45 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "ROM";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 46 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "1CO";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 47 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "2CO";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 48 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "GAL";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 49 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "EPH";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 50 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "PHP";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 51 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "COL";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 52 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "1TH";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 53 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "2TH";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 54 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "1TI";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 55 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "2TI";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 56 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "TIT";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 57 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "PHM";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 58 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "HEB";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 59 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JAS";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 60 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "1PE";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 61 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "2PE";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 62 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "1JN";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 63 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "2JN";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 64 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "3JN";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 65 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "JUD";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
	} elseif ( $enmse_start_book == 66 ) {
		$bookname = $enmse_booknames[$enmse_start_book];
		$bookcode = "REV";
		$shortbookname = $enmse_bookabr[$enmse_start_book];
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
		$trans = " (AFR83)";//
	} elseif ( $enmse_trans == 157 ) {
		$trans = " (SCH2000)";
	} elseif ( $enmse_trans == 57 ) {
		$trans = " (ELB)";
	} elseif ( $enmse_trans == 108 ) {
		$trans = " (NGU2011)";
	} elseif ( $enmse_trans == 149 ) {
		$trans = " (RVR1960)";
	} elseif ( $enmse_trans == 128 ) {
		$trans = " (NVI)";
	} elseif ( $enmse_trans == 170 ) {
		$trans = " (TCL02)";
	} elseif ( $enmse_trans == 48 ) {
		$trans = "";
	} elseif ( $enmse_trans == 414 ) {
		$trans = "";
	} elseif ( $enmse_trans == 165 ) {
		$trans = " (SV-RJ)";
	} elseif ( $enmse_trans == 51 ) {
		$trans = " (DELUT)";
	} elseif ( $enmse_trans == 73 ) {
		$trans = " (HFA)";
	} elseif ( $enmse_trans == 877 ) {
		$trans = " (NBH)";
	} elseif ( $enmse_trans == 2016 ) {
		$trans = " (NRSV)";
	} elseif ( $enmse_trans == 37 ) {
		$trans = " (CEB)";
	} elseif ( $enmse_trans == 83 ) {
		$trans = " (JCB)";
	} elseif ( $enmse_trans == 1819 ) {
		$trans = "";
	} elseif ( $enmse_trans == 1820 ) {
		$trans = "";
	} elseif ( $enmse_trans == 15 ) {
		$trans = " (B21)";
	} elseif ( $enmse_trans == 162 ) {
		$trans = " (BCZ)";
	} elseif ( $enmse_trans == 44 ) {
		$trans = " (BKR)";
	} elseif ( $enmse_trans == 509 ) {
		$trans = " (CSP)";
	} elseif ( $enmse_trans == 2367 ) {
		$trans = " (NFC)";
	} elseif ( $enmse_trans == 400 ) {
		$trans = " (SYNO)";
	} elseif ( $enmse_trans == 143 ) {
		$trans = " (НРП)";
	} elseif ( $enmse_trans == 1999 ) {
		$trans = " (СРП-2)";
	} elseif ( $enmse_trans == 1276 ) {
		$trans = " (BB)";
	} elseif ( $enmse_trans == 1990 ) {
		$trans = " (HSV)";
	} elseif ( $enmse_trans == 75 ) {
		$trans = " (HTB)";
	} elseif ( $enmse_trans == 328 ) {
		$trans = " (NBG51)";
	}

 ?>