<?php

#-----------------------------------------------------------------
# Custom Post Type Extension
# Adds Procedures as a post type.
#-----------------------------------------------------------------
function register_procedure_post_type() {

	$labels = array(
		'name'                => _x( 'Procedures', 'Post Type General Name', 'guy-watts' ),
		'singular_name'       => _x( 'Procedure', 'Post Type Singular Name', 'guy-watts' ),
		'menu_name'           => __( 'Procedures', 'guy-watts' ),
		'name_admin_bar'      => __( 'Procedures', 'guy-watts' ),
		'parent_item_colon'   => __( 'Parent Item:', 'guy-watts' ),
		'all_items'           => __( 'All Procedures', 'guy-watts' ),
		'add_new_item'        => __( 'Add New Procedure', 'guy-watts' ),
		'add_new'             => __( 'Add New', 'guy-watts' ),
		'new_item'            => __( 'New Procedure', 'guy-watts' ),
		'edit_item'           => __( 'Edit Procedure', 'guy-watts' ),
		'update_item'         => __( 'Update Procedure', 'guy-watts' ),
		'view_item'           => __( 'View Procedure', 'guy-watts' ),
		'search_items'        => __( 'Search Procedure', 'guy-watts' ),
		'not_found'           => __( 'No procedures found', 'guy-watts' ),
		'not_found_in_trash'  => __( 'No procedures found in Trash', 'guy-watts' ),
	);
	$args = array(
		'label'               => __( 'Procedure', 'guy-watts' ),
		'description'         => __( 'Procedure Post Type added by Unique Media in the Guy Watts plugin', 'guy-watts' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-sos',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => 'procedure',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
    'taxonomies'					=> array('categories')
	);
	register_post_type( 'procedure', $args );

}

function register_procedure_category_taxonomy() {
  register_taxonomy( 'procedure_cat',
    array( 'procedure' ),
    array(
      'hierarchical'          => true,
      'label'                 => __( 'Categories', 'hba_learning' ),
      'labels'                => array(
          'name'                       => __( 'Categories', 'hba_learning' ),
          'singular_name'              => __( 'Category', 'hba_learning' ),
          'menu_name'                  => _x( 'Categories', 'Admin menu name', 'hba_learning' ),
          'search_items'               => __( 'Search Categories', 'hba_learning' ),
          'all_items'                  => __( 'All Categories', 'hba_learning' ),
          'edit_item'                  => __( 'Edit Category', 'hba_learning' ),
          'update_item'                => __( 'Update Category', 'hba_learning' ),
          'add_new_item'               => __( 'Add New Category', 'hba_learning' ),
          'new_item_name'              => __( 'New Category Name', 'hba_learning' ),
          'popular_items'              => __( 'Popular Categories', 'hba_learning' ),
          'separate_items_with_commas' => __( 'Separate Categories with commas', 'hba_learning'  ),
          'add_or_remove_items'        => __( 'Add or remove Categories', 'hba_learning' ),
          'choose_from_most_used'      => __( 'Choose from the most used Categories', 'hba_learning' ),
          'not_found'                  => __( 'No Categories found', 'hba_learning' ),
        ),
      'show_ui'               => true,
      'query_var'             => true,
      'capabilities'          => array(
        'manage_terms' => 'edit_pages',
        'edit_terms'   => 'edit_pages',
        'delete_terms' => 'edit_pages',
        'assign_terms' => 'edit_pages',
      ),
      'rewrite'               => array(
        'slug'       => 'procedure_cat',
        'with_front' => false,
        'hierarchical' => true,
      ),
    )
  );
}
add_action( 'init', 'register_procedure_post_type', 0 );
add_action( 'init', 'register_procedure_category_taxonomy', 0 );

function procedure_single_template( $single_template ) {
   global $post;

   if ($post->post_type == 'procedure') {
        $single_template = get_template_directory() . '/page.php';
   }
   return $single_template;
}
add_filter( 'single_template', 'procedure_single_template' );

function procedure_archive_template( $archive_template ) {
	global $post;

	if ($post->post_type == 'procedure' ) {
		if ( is_tax() ) {
			$archive_template = GW_PLUGIN_PATH . 'inc/templates/tax-procedures.php';
		} else {
			$archive_template = GW_PLUGIN_PATH . 'inc/templates/archive-procedures.php';
		}
	}
	return $archive_template;
}
add_filter( 'archive_template', 'procedure_archive_template' );

function procedure_archive_title( $title ) {

	//Check if we're in a Procedures Category Archive page
   if ( is_tax( 'procedure_cat' ) ) {
		 	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
      $title = $term->name;
   }
   return $title;
}
add_filter( 'qode_title_text', 'procedure_archive_title' );

//Add meta box
add_action('init', 'procedure_meta_boxes_map_init');
function procedure_meta_boxes_map_init() {
	global $qode_options_proya;
	global $qodeFramework;
	global $options_fontstyle;
	global $options_fontweight;
	global $options_texttransform;
	global $options_fontdecoration;
  global $qodeIconCollections;
	require_once(GW_PLUGIN_PATH . 'inc/meta-boxes/procedures.php');
}

function procedure_meta_box_save( $post_id, $post ) {
	global $qodeFramework;

	$postTypes = array( "procedure" );
    if ( !isset( $_POST[ '_wpnonce' ] ))
        return;
    if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	if ( ! in_array( $post->post_type, $postTypes ) )
		return;
	foreach ($qodeFramework->qodeMetaBoxes->options as $key=>$box ) {

		if ( isset( $_POST[ $key ] ) && trim( $_POST[ $key ] !== '') ) {

			$value = $_POST[ $key ];
			// Auto-paragraphs for any WYSIWYG
			update_post_meta( $post_id, $key, $value );
		} else {
			delete_post_meta( $post_id, $key );
		}
	}
}

add_action( 'save_post', 'procedure_meta_box_save', 1, 2 );
