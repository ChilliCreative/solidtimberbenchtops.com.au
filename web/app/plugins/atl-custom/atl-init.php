<?php
/*
Plugin Name: ATL Custom Features
Version: 1.0
Plugin URI: https://the.tall.one
Description: Custom keyboard bashing for ATL
Author: Richard Beno
Author URI: https://the.tall.one
textdomain: atl-custom
*/

//Define constants
define( 'ATL_PLUGIN_FILE', __FILE__ );
define( 'ATL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'ATL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

//Load Post Types
include_once('inc/post-types/post-type-portfolio.php');

//Load Taxonomies - here for future use
//include_once('inc/post-types/taxonomies/portfolio-categories.php');

//Load Plugin Functions
include_once('inc/functions.php');
