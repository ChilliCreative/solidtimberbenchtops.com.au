<?php

//Allow contributors to upload files
function contributor_upload_files() {
    $role = get_role( 'contributor' );
    $role->add_cap( 'upload_files' );
}
add_action( 'admin_init', 'contributor_upload_files');

//Send email to admin once a contributor submits a post
function submit_send_email ($post) {
	if ( current_user_can('contributor') ) {
		$user_info = get_userdata ($post->post_author);
		$strTo = array ('person1@example.com', 'person2@example.com');
		$strSubject = 'Your website name: ' . $user_info->user_nicename .
        ' submitted a post';
		$strMessage = 'A post "' . $post->post_title . '" by
        ' . $user_info->user_nicename . ' was submitted for review at ' .
        wp_get_shortlink ($post->ID) . '&preview=true. Please proof.';
		wp_mail( $strTo, $strSubject, $strMessage );
	}
}
add_action( 'draft_to_pending', 'submit_send_email' );
add_action( 'auto-draft_to_pending', 'submit_send_email' );
