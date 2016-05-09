<?php
//Add image to 'Add' screen
function add_image_to_portfolio_categories( $taxonomy ){ ?>
  <div class="form-field term-image-wrap">
    <label for="image">Image</label>
    <input type="text" name="image" id="image" value="">
    <input
        type="button"
        name="upload-btn-image"
        id="upload-btn-image"
        data-input="image"
        class="button-secondary upload-btn"
        value="Upload">
  </div>
  <?php
  add_upload_button_js();
}
add_action( 'portfolio_category_add_form_fields', 'add_image_to_portfolio_categories', 10, 2 );

//Add image to 'Edit' screen
function edit_image_for_portfolio_categories( $term, $taxonomy ) {
  $image_url = '';
  $image = get_term_meta( $term->term_id, 'image', true );
  if ( ! empty( $image ) ) {
    $image_url = wp_get_attachment_image_src( $image, 'thumbnail' );
    $image_url = $image_url[0];
  }

  ?>
  <tr class="form-field term-image-wrap">
			<th scope="row"><label for="image">Image</label></th>
			<td>
        <img id="image-thumb" src="<?php echo $image_url; ?>" width="150"><br />
        <input type="hidden" name="image" id="image" value="<?php echo $image; ?>">
        <input
          type="button"
          name="upload-btn-image"
          id="upload-btn-image"
          data-input="image"
          class="button-secondary upload-btn"
          value="Upload">
  			<p class="description">The image is shown on the gallery pages.</p>
      </td>
		</tr>
  <?php
  add_upload_button_js();
}
add_action('portfolio_category_edit_form_fields', 'edit_image_for_portfolio_categories', 10, 2 );

//Save!
function save_portfolio_category_image( $term_id, $tt_id ){
  //$tt_id is term taxonomy ID
  if( isset( $_POST['image'] ) && '' !== $_POST['image'] ){
    $image = sanitize_title( $_POST['image'] );
    add_term_meta( $term_id, 'image', $image, true );
  }
}
add_action( 'create_portfolio_category', 'save_portfolio_category_image', 10, 2 );

//Update!
function update_portfolio_category_image( $term_id, $tt_id ){
  //$tt_id is term taxonomy ID
  if( isset( $_POST['image'] ) && '' !== $_POST['image'] ){
    $image = sanitize_title( $_POST['image'] );
    update_term_meta( $term_id, 'image', $image, true );
  }
}
add_action( 'edit_portfolio_category', 'save_portfolio_category_image', 10, 2 );

function add_upload_button_js() { ?>

<script type="text/javascript">
  jQuery(document).ready(function($){
    jQuery(".upload-btn").click(function(e) {
      e.preventDefault();

      //Get the id of the input to return a value to
      var input = $(this).attr("data-input");

      var image = wp.media({
        title: "Upload Image",
        // mutiple: true if you want to upload multiple files at once
        multiple: false
      }).open()
      .on("select", function(e){
        // This will return the selected image from the Media Uploader, the result is an object
        var uploaded_image = image.state().get("selection").first();
        // We convert uploaded_image to a JSON object to make accessing it easier
        // Output to the console uploaded_image
        //console.log(uploaded_image);
        var image_id = uploaded_image.toJSON().id;
        var image_url = uploaded_image.toJSON().url;
        // Let\'s assign the Image ID value to the input field
        jQuery("#"+input).val(image_id);
        jQuery("#"+input+"-thumb").attr( "src", image_url);
      });
    });
  });
</script>
<?php
  return;
} //end add_upload_button_js()
