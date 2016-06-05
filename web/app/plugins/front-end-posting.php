<?php
/*
Plugin Name: ATL Front end Post
Plugin URI: http://thetallone.co.uk
Description: Post from front end
Version: 1.0
Author: Richard Beno
*/

// register post type for custom posts
function post_type_init() {
  $labels = array(
    'name' => _x('Gallery/Portfolio', 'the gallery/portfolio posts', 'your_text_domain'),
    'singular_name' => _x('Gallery/Portfolio Post', 'the gallery-portfolio post', 'your_text_domain'),
    'add_new' => _x('Add New', 'gallery-portfolio', 'your_text_domain'),
    'add_new_item' => __('Add New Gallery/Portfolio Post', 'your_text_domain'),
    'edit_item' => __('Edit Gallery/Portfolio Post', 'your_text_domain'),
    'new_item' => __('New Gallery/Portfolio Post', 'your_text_domain'),
    'all_items' => __('All Gallery/Portfolio Posts', 'your_text_domain'),
    'view_item' => __('View Gallery/Portfolio Post', 'your_text_domain'),
    'search_items' => __('Search Gallery/Portfolio Post', 'your_text_domain'),
    'not_found' =>  __('No Gallery / Portfolio posts found', 'your_text_domain'),
    'not_found_in_trash' => __('No Gallery/Portfolio posts found in Trash', 'your_text_domain'),
    'parent_item_colon' => '',
    'menu_name' => __('Gallery/Portfolio', 'your_text_domain')

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => _x( 'gallery-portfolio', 'URL slug', 'your_text_domain' ) ),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => 4,
	'supports' => array('author', 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments')
  );
  register_post_type('gallery-portfolio', $args);
}
add_action( 'init', 'post_type_init' );


add_filter( 'rwmb_meta_boxes', 'atl_gallery_meta_boxes' );
function atl_gallery_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => __( 'ATL Gallery/Portfolio - Additional Fields', 'textdomain' ),
        'post_types' => 'gallery-portfolio',
        'fields'     => array(
									array(
										'name'             => __( 'Gallery Images', 'gallery-images' ),
										'id'               => "gallery-images",
										'type'             => 'image_advanced',
										'max_file_uploads' => 9,
									),
									array(
										'id'   => 'first-name',
										'name' => __( 'First Name', 'textdomain' ),
										'type' => 'text',
									),
									array(
										'id'   => 'last-name',
										'name' => __( 'Last Name', 'textdomain' ),
										'type' => 'text',
									),
									array(
										'id'   => 'email',
										'name' => __( 'E-mail', 'textdomain' ),
										'type' => 'text',
									),
									array(
										'id'   => 'company-name',
										'name' => __( 'Company Name', 'textdomain' ),
										'type' => 'text',
									),
									array(
										'id'   => 'company-email',
										'name' => __( 'Company Email', 'textdomain' ),
										'type' => 'email',
									),
									array(
										'id'   => 'company-url',
										'name' => __( 'Company URL', 'textdomain' ),
										'type' => 'text',
									),
									array(
										'id'   => 'company-phone',
										'name' => __( 'Company Phone', 'textdomain' ),
										'type' => 'text',
									),
							 ),
    );
    return $meta_boxes;
}





function atl_gallery_upload_frontend() {

	?>
	<form id="custom-post-type" name="custom-post-type" method="post" class="uploadForm" action="" enctype="multipart/form-data">

        <input type="text" name="first-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" required aria-invalid="false" placeholder="FIRST NAME" />
        <input type="text" name="last-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" required aria-invalid="false" placeholder="LAST NAME" />
        <input type="email" name="your-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" required aria-invalid="false" placeholder="E-MAIL" />
        <input type="text" name="your-company" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" required aria-invalid="false" placeholder="COMPANY NAME" />
        <input type="text" name="your-company-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" required aria-invalid="false" placeholder="COMPANY EMAIL" />
        <input type="text" name="your-company-url" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" required aria-invalid="false" placeholder="COMPANY WEBSITE" />
            <div class="uploadImagesFormWrap">
                <input type="number" name="your-company-tel" value="" class="wpcf7-form-control wpcf7-number wpcf7-validates-as-required wpcf7-validates-as-number" required aria-invalid="false" placeholder="COMPANY TELEPHONE" />
                    <div class="uploadImagesForm">
                        <input type="file" id="files" name="file[]" size="40" class="wpcf7-form-control wpcf7-file" aria-invalid="false" multiple accept="image/*" />
                        <img src="/app/themes/ATL/img/uploadImage.png" alt="Upload Images">
                    </div>
            </div>

            <div class="uploadDescription">
            <textarea name="your-message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required" aria-required="true" aria-invalid="false" placeholder="DESCRIPTION"></textarea></span>
            </div>


		<input type="submit" value="Upload for Confirmation" id="submit" name="submit" />

		<input type="hidden" name="post-type" id="post-type" value="custom_posts" />

		<input type="hidden" name="action" value="custom_posts" />

	<?php wp_nonce_field( 'name_of_my_action','name_of_nonce_field' ); ?>

	</form>

    <div class="confirmation">Success! Your request has been sent.</div>



	<?php

	if($_POST){
		save_and_send_post_data();
	}



}
add_shortcode('atl-gallery-upload','atl_gallery_upload_frontend');

function save_and_send_post_data() {

	if ( empty($_POST) || !wp_verify_nonce($_POST['name_of_nonce_field'],'name_of_my_action') )
	{
	   print 'Sorry, your nonce did not verify.';
	   exit;

	}else{

		echo "<style>#loadingOverlay{opacity:1; display:block}</style>";


		// Do some minor form validation to make sure there is content
		if (isset ($_POST['first-name'])) {
			$firstname =  $_POST['first-name'];
		} else {
			echo 'Please enter a title';
			exit;
		}
		if (isset ($_POST['your-message'])) {
			$description = $_POST['your-message'];
		} else {
			echo 'Please enter the content';
			exit;
		}

		if(isset($_POST['post_tags'])){
		$tags = $_POST['post_tags'];
		}else{
		$tags = "";
		}

		$lastname = $_POST['last-name'];
		$company = $_POST['your-company'];
		$company_email = $_POST['your-company-email'];
		$company_url = $_POST['your-company-url'];
		$company_tel = $_POST['your-company-tel'];
		$email = $_POST['your-email'];


			// Create username

			if( null == username_exists( $email ) ) {

				$password = wp_generate_password( 12, true );
				$user_id = wp_create_user ( $company, $password, $email );

				$user = new WP_User( $user_id );
				$user->set_role( 'contributor' );

			} else {

				$user_id = $email;

			}



			// Add the content of the form to $post as an array
			$post = array(
				'post_title' => wp_strip_all_tags( $company ),
				'post_content' => $description,
				'tags_input' => $tags,
				'post_author' => $user_id,
				'post_status' => 'pending',			// Choose: publish, preview, future, etc.
				'post_type' => 'gallery-portfolio'  // Use a custom post type if you want to
			);

			// Assign Post Author



			// Update post with metabox - Upload Images & Create Featured Image
			if ( $_FILES ) {
				$pid = wp_insert_post($post);
				$files = $_FILES["file"];
					foreach ($files['name'] as $key => $value) {
					if ($files['name'][$key]) {
						$file = array(
							'name' => $files['name'][$key],
							'type' => $files['type'][$key],
							'tmp_name' => $files['tmp_name'][$key],
							'error' => $files['error'][$key],
							'size' => $files['size'][$key]
						);
						$_FILES = array ("file" => $file);
						foreach ($_FILES as $file => $array) {
							$newupload = atl_handle_attachment($file,$pid);
						}
					}

				update_post_meta( $pid, 'first-name', $firstname);
				update_post_meta( $pid, 'last-name', $lastname);
				update_post_meta( $pid, 'email', $email);
				update_post_meta( $pid, 'company-name', $company);
				update_post_meta( $pid, 'company-email', $company_email);
				update_post_meta( $pid, 'company-url', $company_url);
				update_post_meta( $pid, 'company-phone', $company_tel);
				}

				// EMAIL TEMPLATE
				$strTo = array ('richard@thetallone.co.uk');
				$headers = "Reply-To: ". wp_strip_all_tags( $email ) ."\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

				$strSubject = 'ATL Website Upload Submission from: ' . wp_strip_all_tags( $firstname ) . ' ' . wp_strip_all_tags( $lastname ) . ' at ' . wp_strip_all_tags( $company ) . '. Please Review';
				$strMessage = '<br><br>User Details: <br>Name: ' . wp_strip_all_tags( $firstname ) . ' ' . wp_strip_all_tags( $lastname ) . '<br>Email: ' . wp_strip_all_tags( $email ) . '<br><br>Company Details: <br>Email: ' . wp_strip_all_tags( $company_email ) . '<br>Website: ' . wp_strip_all_tags( $company_url ) . '<br>Phone: ' . wp_strip_all_tags( $company_tel ) . ' <br><br>Description:<br> ' . wp_strip_all_tags( $description ) . '<br><br>  Please use the following link to review and publish: <br> ' . admin_url( 'post.php?post=' . $pid .'&action=edit') . '.';

				wp_mail( $strTo, $strSubject, $strMessage, $headers);

				$location = site_url('/success/'); // redirect location, should be login page

				echo "<meta http-equiv='refresh' content='0;url=$location' />";

				exit;

			}


		}





}



?>
