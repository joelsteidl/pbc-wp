<?php 
/*
Plugin Name: BE Portfolio Post
Plugin URI: http://www.brandexponents.com
Description: Plugin to create custom post type for Portfolios
Author: Brandexponents
Version: 1.1
Author URI: http://www.brandexponents.com
*/

require_once (plugin_dir_path(__FILE__).'custom-post-types/PostType.php');

/***********************************************
					PORTFOLIO
***********************************************/	

//Create Post Type

$portfolio = Create_Custom_Post_Type( 'portfolio' );

//Add Categories Style Taxonomy
$portfolio->Add_Categories_Style_Taxonomy( 'portfolio_categories' );

//Add Tags Style Taxonomy
$portfolio->Add_Tags_Style_Taxonomy( 'portfolio_tags' );

$portfolio->args['supports'] = array( 'title', 'editor','thumbnail','excerpt' );
?>