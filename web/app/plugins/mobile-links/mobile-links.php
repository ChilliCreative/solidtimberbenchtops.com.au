<?php
/**
 * Plugin Name: IMExpert Mobile Links
 * Plugin URI: http://www.tbst.biz
 * Description: This plugin add 3 links at the bottom of each page in mobile device
 * Version: 1.1.0
 * Author: Joseph Gutierrez
 * Author URI: http://www.tbst.biz
 * License: GPL2
 */
/* 
 Copyright 2016 TBST (email : info@successteam.com.au)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_action('admin_enqueue_scripts', 'add_mlinks_stylesheet'); 
add_action('admin_enqueue_scripts', 'enqueue_mlinks_admin_js'); 
add_action('wp_enqueue_scripts', 'enqueue_front'); 

function enqueue_mlinks_admin_js() {
	wp_enqueue_script('media-upload');  
	wp_enqueue_script('thickbox'); 
	wp_enqueue_script('fancybox_mlinks', plugins_url("assets/js/jquery.fancybox.js", __FILE__), array('jquery'), '', true);  
	wp_enqueue_script('mlinks_main_js', plugins_url("assets/js/mlinks_main_js.js", __FILE__), array('jquery', 'wp-color-picker' ), '', true);  
	wp_enqueue_script('jquery-ui-datepicker'); 
}
 
function add_mlinks_stylesheet(){
	wp_enqueue_style( 'wp-color-picker' );  
	wp_enqueue_style('fancybox'); 
	wp_enqueue_style('thickbox');   
	wp_register_style('main_stylesheet', plugins_url('assets/css/main_stylesheet.css', __FILE__ ));
	wp_enqueue_style('main_stylesheet');
	wp_register_style('jquery_fancybox_mlinks', plugins_url('assets/css/jquery.fancybox.css', __FILE__ ));
	wp_enqueue_style('jquery_fancybox_mlinks');
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
}

function enqueue_front()
{
	wp_register_style('main_stylesheet', plugins_url('assets/css/main_stylesheet.css', __FILE__ ));
	wp_enqueue_style('main_stylesheet');
	wp_register_style('jquery_fancybox_mlinks', plugins_url('assets/css/jquery.fancybox.css', __FILE__ ));
	wp_enqueue_style('jquery_fancybox_mlinks');
	wp_enqueue_script('fancybox_mlinks', plugins_url("assets/js/jquery.fancybox.js", __FILE__), array('jquery'), '', true);  
	
	wp_enqueue_script('mlinks_front_js', plugins_url("assets/js/mlinks_front_js_sc.js", __FILE__), array('jquery'), '', true);  
}

require_once( plugin_dir_path( __FILE__ ) . 'mobile-links-init.php' );