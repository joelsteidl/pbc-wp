<?php 

add_action( 'init', 'enmse_seriesengine_permalinks' ); 
add_action( 'wp_head', 'enmse_seriesengine_ogtags' ); 

/* Registers post types */ 

function enmse_seriesengine_permalinks() { 

	$se_options = get_option( 'enm_seriesengine_options' );

	if ( isset($se_options['permalinkslug']) ) { 
		$enmseslug = $se_options['permalinkslug'];
	} else {
		$enmseslug = 'messages';
	}

	if ( isset($se_options['permalink_show_post_type']) ) { 
		if ( $se_options['permalink_show_post_type'] == "true" ) {
			$enmse_showposts = true;
		} else {
			$enmse_showposts = false;
		}
	} else {
		$enmse_showposts = false;
	}

	/* Messages */ 
	$messages_args = array( 
		'public' => true, 
		'query_var' => $enmseslug, 
		'show_ui' => $enmse_showposts,
		'rewrite' => array( 
			'slug' => $enmseslug, 
			'with_front' => false, ), 
		'supports' => array( 
			'title', 'thumbnail', 'editor', 'excerpt' ), 
		'labels' => array( 'name' => 'Messages',
			'singular_name' => 'Message', 
			'add_new' => 'Add Message', 
			'add_new_item' => 'Add Message', 
			'edit_item' => 'Edit Message', 
			'new_item' => 'New Message', 
			'view_item' => 'View Message', 
			'search_items' => 'Search Messages', 
			'not_found' => 'No Messages Found', 
			'not_found_in_trash' => 'No Messages Found In Trash' 
		), 
		'has_archive' => true,
    'capabilities'        => array(
      'publish_posts'       => 'edit_pages',
      'edit_others_posts'   => 'edit_pages',
      'delete_posts'        => 'edit_pages',
      'delete_others_posts' => 'edit_pages',
      'read_private_posts'  => 'edit_pages',
      'edit_post'           => 'edit_pages',
      'delete_post'         => 'edit_pages',
      'read_post'           => 'edit_pages')
	); 
	
	register_post_type( 'enmse_message', $messages_args );
}

add_filter( 'the_content', 'add_seriesengine_content' );

function add_seriesengine_content( $content ) {
	if ( 'enmse_message' == get_post_type() && in_the_loop() == true ) {
		if ( ! is_feed() && ( is_archive() || is_search() ) ) {
			$new_content = seriesengine_message_excerpt();
		} elseif ( is_singular() && is_main_query() ) {
			$new_content = seriesengine_message_single();
		}
		$content = $new_content;
	}

	return $content;
}

// single sermon action
function seriesengine_message_single() {
	global $post; 
	global $wpdb;

	$se_options = get_option( 'enm_seriesengine_options' );

	if ( isset($se_options['permalink_single_seriestype']) ) { 
		$enmse_seriestype = $se_options['permalink_single_seriestype'];
	} else {
		$enmse_seriestype = 0;
	}

	if ( isset($se_options['permalink_single_explorer']) ) { 
		$enmse_explorer = $se_options['permalink_single_explorer'];
	} else {
		$enmse_explorer = 0;
	}

	if ( isset($se_options['permalink_single_explorer_series']) ) { 
		$enmse_explorer_series = $se_options['permalink_single_explorer_series'];
	} else {
		$enmse_explorer_series = 1;
	}

	if ( isset($se_options['permalink_single_explorer_speaker']) ) { 
		$enmse_explorer_speaker = $se_options['permalink_single_explorer_speaker'];
	} else {
		$enmse_explorer_speaker = 1;
	}

	if ( isset($se_options['permalink_single_explorer_topics']) ) { 
		$enmse_explorer_topics = $se_options['permalink_single_explorer_topics'];
	} else {
		$enmse_explorer_topics = 1;
	}

	if ( isset($se_options['permalink_single_explorer_books']) ) { 
		$enmse_explorer_books = $se_options['permalink_single_explorer_books'];
	} else {
		$enmse_explorer_books = 1;
	}

	if ( isset($se_options['permalink_single_related']) ) { 
		$enmse_related = $se_options['permalink_single_related'];
	} else {
		$enmse_related = 1;
	}

	if ( isset($se_options['permalink_single_related_cardview']) ) { 
		$enmse_related_cardview = $se_options['permalink_single_related_cardview'];
	} else {
		$enmse_related_cardview = 0;
	}

	if ( isset($se_options['permalink_single_pag']) ) { 
		$enmse_pag = $se_options['permalink_single_pag'];
	} else {
		$enmse_pag = 10;
	}

	if ( isset($se_options['permalink_single_apag']) ) { 
		$enmse_apag = $se_options['permalink_single_apag'];
	} else {
		$enmse_apag = 12;
	}

	if ( isset($se_options['permalink_single_blurb']) ) { 
		$enmse_blurb = $se_options['permalink_single_blurb'];
	} else {
		$enmse_blurb = null;
	}

	
	$enmse_seriestypev = "";


	if ( $enmse_explorer == 0 ) {
		$enmse_explorerv = "";
	} else {
		$enmse_explorerv = " enmse_e=1";
	}

	if ( $enmse_explorer_series == 0 ) {
		$enmse_explorer_seriesv = " enmse_hsd=1";
	} else {
		$enmse_explorer_seriesv = "";
	}

	if ( $enmse_explorer_speaker == 0 ) {
		$enmse_explorer_speakerv = " enmse_hspd=1";
	} else {
		$enmse_explorer_speakerv = "";
	}

	if ( $enmse_explorer_topics == 0 ) {
		$enmse_explorer_topicsv = " enmse_htd=1";
	} else {
		$enmse_explorer_topicsv = "";
	}

	if ( $enmse_explorer_books == 0 ) {
		$enmse_explorer_booksv = " enmse_hbd=1";
	} else {
		$enmse_explorer_booksv = "";
	}

	if ( $enmse_explorer_books == 0 ) {
		$enmse_explorer_booksv = " enmse_hbd=1";
	} else {
		$enmse_explorer_booksv = "";
	}

	if ( $enmse_related == 1 ) {
		$enmse_relatedv = " enmse_r=1";
	} else {
		$enmse_relatedv = "";
	}

	if ( $enmse_related_cardview == 0 ) {
		$enmse_cardviewv = "";
	} else {
		$enmse_cardviewv = " enmse_cv=" . $enmse_related_cardview;
	}

	$enmse_pagv = " enmse_pag=" . $enmse_pag;
	$enmse_apagv = " enmse_apag=" . $enmse_apag;

	$mid = get_post_meta($post->ID, 'enmse_mid', true);
	$enmse_mv = " enmse_dsm=" . $mid;

	$enmse_shortcode = "[seriesengine_wo" . $enmse_seriestypev . $enmse_explorerv . $enmse_explorer_seriesv . $enmse_explorer_speakerv . $enmse_explorer_topicsv . $enmse_explorer_booksv . $enmse_relatedv . $enmse_cardviewv . $enmse_pagv . $enmse_apagv . $enmse_mv . "]";
	
	if ( $enmse_blurb != null ) {
		echo wpautop($enmse_blurb);
	}
	echo do_shortcode($enmse_shortcode);

} 

function seriesengine_message_excerpt() {

}

/* Adds Facebook OG Tags */

function enmse_seriesengine_ogtags() { 

	$se_options = get_option( 'enm_seriesengine_options' );

	if ( isset($se_options['permalink_ogtags']) ) { 
		$permalinks_ogtags = $se_options['permalink_ogtags'];
	} else {
		$permalinks_ogtags = 1;
	}

	if ( isset($se_options['permaclicktoview']) ) { 
		$enmse_permaclicktoview = $se_options['permaclicktoview'];
	} else {
		$enmse_permaclicktoview = "Click to view more.";
	}

	if ( $permalinks_ogtags == 1 ) {
		if ( is_singular('enmse_message') ) {
			if (have_posts()) : while (have_posts()) : the_post();
				global $post;
				global $wpdb;
				
				$mid = get_post_meta($post->ID, 'enmse_mid', true);

				//Image for Facebook OG Tags
				$enmse_findthemessagesql = "SELECT series_image, message_thumbnail FROM " . $wpdb->prefix . "se_messages" . " WHERE message_id = %d"; 
				$enmse_findthemessage = $wpdb->prepare( $enmse_findthemessagesql, $mid );
				$enmse_single = $wpdb->get_row( $enmse_findthemessage, OBJECT );

				echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '" />';
				if ( has_excerpt() ) {
					echo '<meta property="og:description" content="' . htmlspecialchars(get_the_excerpt()) . '" />';
				} else {
					echo '<meta property="og:description" content="' . $enmse_permaclicktoview . '" />';
				}
				echo '<meta property="og:title" content="' . get_the_title() . '" />';
				if ( $enmse_single->message_thumbnail != null || $enmse_single->message_thumbnail != ""  ) {
					echo '<meta property="og:image" content="' . $enmse_single->message_thumbnail . '" />';
				} elseif ( $enmse_single->series_image != null || $enmse_single->series_image != ""  ) {
					echo '<meta property="og:image" content="' . $enmse_single->series_image . '" />';
				}
				echo '<meta property="og:url" content=\'' . get_the_permalink() . '\' />';

			endwhile; endif;
			rewind_posts();
		}
	}

}


 ?>