<?php

// enqueue the child theme stylesheet

Function wp_schools_enqueue_scripts() {
wp_register_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css'  );
wp_enqueue_style( 'childstyle' );

wp_register_script( 'customjs', get_stylesheet_directory_uri() . '/js/custom.js'  );
wp_enqueue_script( 'customjs' );
}
add_action( 'wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);


// Allow image uploads from front end..

function atl_handle_attachment($file_handler,$post_id,$set_thu=true,$set_gal=true) {
	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
 
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
 
	$attach_id = media_handle_upload( $file_handler, $post_id );
 
    // If you want to set a featured image frmo your uploads. 
	if ($set_thu) set_post_thumbnail($post_id, $attach_id);
	
	if ( is_numeric( $attach_id ) ) {
		update_post_meta( $post_id, 'gallery-images', $attach_id );
	}
	
	return $attach_id;
}

// Sort out Post Type

