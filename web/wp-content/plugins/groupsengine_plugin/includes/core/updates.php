<?php 

if ( get_option('enmge_db_version') == "1.0" ) { // First Update for beta users

	function enmge_zeroone() {
		global $wpdb;
		$groupcheck = $wpdb->prefix . "ge_groups";
	
			if( $wpdb->get_var("SHOW TABLES LIKE '$groupcheck'") == $groupcheck ) {
			
				$sql = "ALTER TABLE " . $groupcheck .
					" ADD group_noend int(1) DEFAULT NULL,
					 ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$groupcheck = $wpdb->prefix . "ge_groups";
	
			if( $wpdb->get_var("SHOW TABLES LIKE '$groupcheck'") == $groupcheck ) {
			
				$sql = "ALTER TABLE " . $groupcheck .
					" ADD group_noend int(1) DEFAULT NULL,
					 ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeroone();
	}

} elseif ( get_option('enmge_db_version') == "1.01" ) { // First Update for beta users
	function enmge_zerotwo() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerotwo();
	}
} elseif ( get_option('enmge_db_version') == "1.02" ) { // First Update
	function enmge_zerothree() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerothree();
	}
} elseif ( get_option('enmge_db_version') == "1.03" ) { // 1.0.2
	function enmge_zerothree() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerothree();
	}
} elseif ( get_option('enmge_db_version') == "1.04" ) { // 1.0.3
	function enmge_zerofour() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerofour();
	}
} elseif ( get_option('enmge_db_version') == "1.05" ) { // 1.0.4
	function enmge_zerofive() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerofive();
	}
} elseif ( get_option('enmge_db_version') == "1.06" ) { // 1.0.5
	function enmge_zerosix() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zerosix();
	}
} elseif ( get_option('enmge_db_version') == "1.07" ) { // 1.0.6
	function enmge_zeroseven() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeroseven();
	}
} elseif ( get_option('enmge_db_version') == "1.08" ) { // 1.0.7
	function enmge_zeroeight() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeroeight();
	}
} elseif ( get_option('enmge_db_version') == "1.09" ) { // 1.0.8
	function enmge_zeronine() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeronine();
	}
} elseif ( get_option('enmge_db_version') == "1.10" ) { // 1.0.9
	function enmge_zeroten() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_zeroten();
	}
} elseif ( get_option('enmge_db_version') == "1.11" ) { // 1.1
	function enmge_one() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		$gcheck = $wpdb->prefix . "ge_groups";
		if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

			$sql = "ALTER TABLE " . $gcheck .
				" ADD group_manedit int(2) DEFAULT NULL";
			$wpdb->query($sql);
		}
		$lcheck = $wpdb->prefix . "ge_locations";
		if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

			$sqltwo = "ALTER TABLE " . $lcheck .
				" ADD location_manedit int(2) DEFAULT NULL";
			$wpdb->query($sqltwo);
		}

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			$gcheck = $wpdb->prefix . "ge_groups";
			if( $wpdb->get_var("SHOW TABLES LIKE '$gcheck'") == $gcheck ) {

				$sql = "ALTER TABLE " . $gcheck .
					" ADD group_manedit int(2) DEFAULT NULL";
				$wpdb->query($sql);
			}
			$lcheck = $wpdb->prefix . "ge_locations";
			if( $wpdb->get_var("SHOW TABLES LIKE '$lcheck'") == $lcheck ) {

				$sqltwo = "ALTER TABLE " . $lcheck .
					" ADD location_manedit int(2) DEFAULT NULL";
				$wpdb->query($sqltwo);
			}

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_one();
	}
} elseif ( get_option('enmge_db_version') == "1.12" ) { // 1.1.1
	function enmge_oneone() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_oneone();
	}
} elseif ( get_option('enmge_db_version') == "1.13" || get_option('enmge_db_version') == "1.14" || get_option('enmge_db_version') == "1.15" || get_option('enmge_db_version') == "1.16" || get_option('enmge_db_version') == "1.17" || get_option('enmge_db_version') == "1.18" || get_option('enmge_db_version') == "1.19" || get_option('enmge_db_version') == "1.20" || get_option('enmge_db_version') == "1.21" || get_option('enmge_db_version') == "1.22" || get_option('enmge_db_version') == "1.23" || get_option('enmge_db_version') == "1.3.0" || get_option('enmge_db_version') == "1.3.0.1" || get_option('enmge_db_version') == "1.3.1" || get_option('enmge_db_version') == "1.3.2" || get_option('enmge_db_version') == "1.3.3" ) { // 1.2.1
	function enmge_oneonetwo() {
		global $wpdb;

		$ge_options = get_option( 'enm_groupsengine_options' );
		generate_ge_options_css($ge_options);

		// Define DB version
		global $enmge_db_version;
		$enmge_db_version = "1.3.4";
		update_option("enmge_db_version", $enmge_db_version);
	}

	if (function_exists('is_multisite') && is_multisite()) { // Check for Multisite
		global $wpdb;
		$blog_list = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs",""));
		foreach ($blog_list as $blog) {
			switch_to_blog($blog);
			$data = get_option( 'enm_groupsengine_options' ); ;	
			$css_dir = plugin_dir_path( __FILE__ ) . 'css/'; // Shorten code, save 1 call
			ob_start(); // Capture all output (output buffering)
			include($css_dir . 'ge_styles_generate.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			file_put_contents($css_dir . 'ge_' . $blog . '_styles.css', $css, LOCK_EX); // Save it

			// Define DB version
			global $enmge_db_version;
			$enmge_db_version = "1.3.4";
			update_option("enmge_db_version", $enmge_db_version);
		}
		switch_to_blog($wpdb->blogid);
	} else {
		 enmge_oneonetwo();
	}
}

 ?>