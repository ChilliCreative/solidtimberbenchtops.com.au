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

// Add IMExpert tracking script
function imexpert_tracking() { ?>


	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NXMLC8"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-NXMLC8');</script>
	<!-- End Google Tag Manager -->
	<?php
}
//High number to place code immediately before closing body tag
add_action('wp_head', 'imexpert_tracking', 9999);
