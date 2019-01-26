<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
    <?php
    	if ( is_singular() ) {
    		wp_enqueue_script( 'comment-reply' );
    	}
    	wp_head();
    ?>
</head>
<body <?php body_class(); ?> data-be-site-layout='<?php echo $be_themes_data['layout']; ?>' data-be-page-template = '<?php echo basename(get_page_template(),".php"); ?>' >
	<?php
		do_action( 'after_body' );
		$widget_style = (isset($be_themes_data['seach_widget_style']) && !empty($be_themes_data['seach_widget_style'])) ? $be_themes_data['seach_widget_style'] : 'style1-header-search-widget';
		if($widget_style == 'style2-header-search-widget') {
			be_themes_get_header_search_form_widget( false, true);
		}
		if ( ('left' == $be_themes_data['opt-header-type'] ) && isset($be_themes_data['left-header-style']) ){
			$opt_header_type = 'left';
		} else if( ('top' == $be_themes_data['opt-header-type'] ) && isset($be_themes_data['opt-header-type']) ){
			$opt_header_type = 'top';
		}
		// based on the choice of header style call its header-default.php
		get_template_part('headers/'.$opt_header_type.'/header', 'default');
		do_action( 'tatsu_head' );
