<?php
/**
* Plugin Name: ATL Latest Posts For Portfolio
* Description: Latest posts widget for Portfolio CPT.
* Version: 1.0
* Author: Richard Beno
* Author URI: http://the.tall.one
*/
function atlwp_latest_cpt_init() {
if ( !function_exists( 'register_sidebar_widget' ))
return;

function atlwp_latest_cpt($args) {
global $post;
extract($args);

// These are our own options
$options = get_option( 'atlwp_latest_cpt' );
$title = $options['title']; // Widget title
$phead = $options['phead']; // Heading format
$ptype = $options['ptype']; // Post type
$pshow = $options['pshow']; // Number of Tweets

$beforetitle = '';
$aftertitle = '';

// Output
echo $before_widget;
?>
 <h5><?php if ($title) echo $beforetitle . $title . $aftertitle; ?></h5>
 
 <ul>
<ul>
 <?php

$pq = new WP_Query(array( 'post_type' => $ptype, 'showposts' => $pshow ));
if( $pq->have_posts() ) :
?>
	<?php while($pq->have_posts()) : $pq->the_post(); ?>
    <li><?php the_post_thumbnail( array(200,200)); ?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></li>

<?php wp_reset_query();
endwhile; ?>

<?php endif; ?>
</ul>
</ul>
<!-- NEEDS FIX: to display link to full list of posts page
<?php $obj = get_post_type_object($ptype); ?>
<div class="latest_cpt_icon"><a href="<?php site_url('/'.$obj->query_var); ?>" rel="bookmark"><?php _e( 'View all ' . $obj->labels->name . ' posts' ); ?>&rarr;</a></div>
//-->

<?php
// echo widget closing tag
echo $after_widget;
}

/**
* Widget settings form function
*/
function atlwp_latest_cpt_control() {

// Get options
$options = get_option( 'atlwp_latest_cpt' );
// options exist? if not set defaults
if ( !is_array( $options ))
$options = array(
'title' => 'Latest Portfolio Posts',
'phead' => 'h2',
'ptype' => 'portfolio',
'pshow' => '5'
);
// form posted?
if ( $_POST['latest-cpt-submit'] ) {
$options['title'] = strip_tags( $_POST['latest-cpt-title'] );
$options['phead'] = $_POST['latest-cpt-phead'];
$options['ptype'] = $_POST['latest-cpt-ptype'];
$options['pshow'] = $_POST['latest-cpt-pshow'];
update_option( 'atlwp_latest_cpt', $options );
}
// Get options for form fields to show
$title = $options['title'];
$phead = $options['phead'];
$ptype = $options['ptype'];
$pshow = $options['pshow'];

// The widget form fields
?>

<label for="latest-cpt-title"><?php echo __( 'Widget Title' ); ?>
<input id="latest-cpt-title" type="text" name="latest-cpt-title" size="30" value="<?php echo $title; ?>" />
</label>

<label for="latest-cpt-phead"><?php echo __( 'Widget Heading Format' ); ?></label>

<select name="latest-cpt-phead"><option selected="selected" value="h2">H2 - <h2></h2></option><option selected="selected" value="h3">H3 - <h3></h3></option><option selected="selected" value="h4">H4 - <h4></h4></option><option selected="selected" value="strong">Bold - <strong></strong></option></select><select name="latest-cpt-ptype"><option value="">- <?php echo __( 'Select Post Type' ); ?> -</option></select><?php $args = array( 'public' => true );
$post_types = get_post_types( $args, 'names' );
foreach ($post_types as $post_type ) { ?>

<select name="latest-cpt-ptype"><option selected="selected" value="<?php echo $post_type; ?>"><?php echo $post_type;?></option></select><?php } ?>

<label for="latest-cpt-pshow"><?php echo __( 'Number of posts to show' ); ?>
<input id="latest-cpt-pshow" type="text" name="latest-cpt-pshow" size="2" value="<?php echo $pshow; ?>" />
</label>

<input id="latest-cpt-submit" type="hidden" name="latest-cpt-submit" value="1" />
<?php
}

wp_register_sidebar_widget( 'widget_latest_cpt', __('Latest Custom Posts'), 'atlwp_latest_cpt' );
wp_register_widget_control( 'widget_latest_cpt', __('Latest Custom Posts'), 'atlwp_latest_cpt_control', 300, 200 );

}
add_action( 'widgets_init', 'atlwp_latest_cpt_init' );

?>