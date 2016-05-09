<?php
$id = get_the_ID();

$sidebar = "";

if(get_post_meta(get_the_ID(), "qode_portfolio_show_sidebar", true) != "" && get_post_meta(get_the_ID(), "qode_portfolio_show_sidebar", true) !== "default"){
	$sidebar = get_post_meta(get_the_ID(), "qode_portfolio_show_sidebar", true);
}else{
	if(isset($qode_options_proya['portfolio_single_sidebar'])){
		$sidebar = $qode_options_proya['portfolio_single_sidebar'];
	}
}

$portfolio_qode_like = "on";
if (isset($qode_options_proya['portfolio_qode_like'])) {
	$portfolio_qode_like = $qode_options_proya['portfolio_qode_like'];
}

$lightbox_single_project = "no";
if (isset($qode_options_proya['lightbox_single_project']))
	$lightbox_single_project = $qode_options_proya['lightbox_single_project'];

if(get_post_meta($id, "qode_page_background_color", true) != ""){
	$background_color = get_post_meta($id, "qode_page_background_color", true);
}else{
	$background_color = "";
}

$porftolio_template = 1;
if(get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true) != ""){
	if(get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true) == 1){
		$porftolio_template = 1;
	}elseif(get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true) == 2){
		$porftolio_template = 2;
	}elseif(get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true) == 3){
		$porftolio_template = 3;
	}elseif(get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true) == 4){
		$porftolio_template = 4;
	}elseif(get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true) == 5){
		$porftolio_template = 5;
	}elseif(get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true) == 6){
		$porftolio_template = 6;
	}elseif(get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true) == 7){
		$porftolio_template = 7;
	}
}elseif(isset($qode_options_proya['portfolio_style'])){
	if($qode_options_proya['portfolio_style'] == 1){
		$porftolio_template = 1;
	}elseif($qode_options_proya['portfolio_style'] == 2){
		$porftolio_template = 2;
	}elseif($qode_options_proya['portfolio_style'] == 3){
		$porftolio_template = 3;
	}elseif($qode_options_proya['portfolio_style'] == 4){
		$porftolio_template = 4;
	}elseif($qode_options_proya['portfolio_style'] == 5){
		$porftolio_template = 5;
	}elseif($qode_options_proya['portfolio_style'] == 6){
		$porftolio_template = 6;
	}elseif($qode_options_proya['portfolio_style'] == 7){
		$porftolio_template = 7;
	}
}

$porftolio_single_template = get_post_meta(get_the_ID(), "qode_choose-portfolio-single-view", true);

$columns_number = "v4";
if(get_post_meta(get_the_ID(), "qode_choose-number-of-portfolio-columns", true) != ""){
	if(get_post_meta(get_the_ID(), "qode_choose-number-of-portfolio-columns", true) == 2){
		$columns_number = "v2";
	} else if(get_post_meta(get_the_ID(), "qode_choose-number-of-portfolio-columns", true) == 3){
		$columns_number = "v3";
	} else if(get_post_meta(get_the_ID(), "qode_choose-number-of-portfolio-columns", true) == 4){
		$columns_number = "v4";
	}
}else{
	if(isset($qode_options_proya['portfolio_columns_number'])){
		if($qode_options_proya['portfolio_columns_number'] == 2){
			$columns_number = "v2";
		} else if($qode_options_proya['portfolio_columns_number'] == 3) {
			$columns_number = "v3";
		} else if($qode_options_proya['portfolio_columns_number'] == 4) {
			$columns_number = "v4";
		}
	}
}

$content_style_spacing = "";
if(get_post_meta($id, "qode_margin_after_title", true) != ""){
	if(get_post_meta($id, "qode_margin_after_title_mobile", true) == 'yes'){
		$content_style_spacing = "padding-top:".esc_attr(get_post_meta($id, "qode_margin_after_title", true))."px !important";
	}else{
		$content_style_spacing = "padding-top:".esc_attr(get_post_meta($id, "qode_margin_after_title", true))."px";
	}
}

?>

<?php get_header(); ?>
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php if(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)) { ?>
				<script>
				var page_scroll_amount_for_sticky = <?php echo get_post_meta($id, "qode_page_scroll_amount_for_sticky", true); ?>;
				</script>
			<?php } ?>
				<?php get_template_part( 'title' ); ?>
			<?php
			$revslider = get_post_meta($id, "qode_revolution-slider", true);
			if (!empty($revslider)){ ?>
				<div class="q_slider"><div class="q_slider_inner">
				<?php echo do_shortcode($revslider); ?>
				</div></div>
			<?php
			}
			?>
			<?php if($porftolio_template != "7"){ ?>
				<div class="container"<?php if($background_color != "") { echo " style='background-color:". $background_color ."'";} ?>>
                    <?php if(isset($qode_options_proya['overlapping_content']) && $qode_options_proya['overlapping_content'] == 'yes') {?>
                        <div class="overlapping_content"><div class="overlapping_content_inner">
                    <?php } ?>
					<div class="container_inner default_template_holder clearfix" <?php qode_inline_style($content_style_spacing); ?>>
						<?php if(($sidebar == "default")||($sidebar == "")) : ?>
							<?php get_template_part('templates/portfolio', 'loop'); ?>
						<?php elseif($sidebar == "1" || $sidebar == "2"): ?>
							<?php if($sidebar == "1") : ?>
							<div class="two_columns_66_33 background_color_sidebar grid2 clearfix">
								<?php elseif($sidebar == "2") : ?>
								<div class="two_columns_75_25 background_color_sidebar grid2 clearfix">
									<?php endif; ?>
									<div class="column1">
										<div class="column_inner">
											<?php get_template_part('templates/portfolio', 'loop'); ?>
										</div>
									</div>
									<div class="column2">
										<?php get_sidebar(); ?>
									</div>
								</div>
								<?php elseif($sidebar == "3" || $sidebar == "4"): ?>
								<?php if($sidebar == "3") : ?>
								<div class="two_columns_33_66 background_color_sidebar grid2 clearfix">
									<?php elseif($sidebar == "4") : ?>
									<div class="two_columns_25_75 background_color_sidebar grid2 clearfix">
										<?php endif; ?>
										<div class="column1">
											<?php get_sidebar(); ?>
										</div>
										<div class="column2">
											<div class="column_inner">
												<?php get_template_part('templates/portfolio', 'loop'); ?>
											</div>
										</div>
									</div>
								<?php endif; ?>

						<?php get_template_part('templates/portfolio-comments'); ?>
					</div>
                    <?php if(isset($qode_options_proya['overlapping_content']) && $qode_options_proya['overlapping_content'] == 'yes') {?>
                        </div></div>
                    <?php } ?>
				</div>
			<?php }  else {
				get_template_part('templates/portfolio', 'loop');
			?>



				<div class="container_inner" <?php qode_inline_style($content_style_spacing); ?>>

                    <?php get_template_part('templates/portfolio-comments'); ?>
				</div>

			<?php } ?>
		<?php endwhile; ?>
	<?php endif; ?>

	<?php get_template_part('templates/portfolio', 'related'); ?>

	<?php $upload_link = site_url('/upload-form/'); ?>

	<?php echo do_shortcode('[vc_row row_type="row" use_row_as_full_screen_section="no" type="full_width" angled_section="no" text_align="center" background_image_as_pattern="without_pattern" css_animation="" css=".vc_custom_1461080248033{margin-top: 0px !important;border-top-width: 0px !important;padding-top: 0px !important;background-color: #ffffff !important;}" el_id="generalUploadSection" el_class="generalUploadSection-Single"][vc_column width="1/2" css=".vc_custom_1461079395844{padding-top: 100px !important;padding-bottom: 100px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" offset="vc_col-lg-offset-0 vc_col-lg-6 vc_col-md-offset-0 vc_col-md-6 vc_col-sm-offset-3 vc_col-xs-12"][vc_single_image image="57" img_size="110x85" alignment="center" qode_css_animation=""][vc_column_text css=".vc_custom_146063390280944{padding-top: 40px !important;padding-bottom: 40px !important;}"]<h2>Showcase your home</h2>[/vc_column_text][vc_row_inner row_type="row" type="full_width" text_align="left" css_animation=""][vc_column_inner width="1/4" offset="vc_col-lg-3 vc_col-md-3 vc_hidden-sm vc_hidden-xs"][/vc_column_inner][vc_column_inner offset="vc_col-lg-6 vc_col-md-6 vc_col-xs-12"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4" offset="vc_col-lg-3 vc_col-md-3 vc_hidden-sm vc_hidden-xs"][/vc_column_inner][/vc_row_inner][button size="medium" icon="" target="_self" hover_type="default" font_style="normal" font_weight="600" text_align="center" text="Upload your images" link="'.$upload_link.'" color="#ffffff" hover_color="#000000" background_color="#f28e1f" hover_background_color="#f28e1f" border_radius="0" margin="40px auto 40px auto" border_color="#f28e1f" hover_border_color="#f28e1f"][/vc_column][vc_column width="1/2" offset="vc_col-sm-offset-0 vc_hidden-sm vc_hidden-xs" css=".vc_custom_146114513987544{padding-top: 0px !important;padding-right: 0px !important;padding-bottom: 0px !important;padding-left: 0px !important;background-image: url('.get_stylesheet_directory_uri().'/img/DummyImage.jpg) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" el_class="generalUploadSection-Image"][/vc_column][/vc_row][vc_row row_type="row" use_row_as_full_screen_section="no" el_class="singlePort-CTA" type="full_width" angled_section="no" text_align="left" background_image_as_pattern="without_pattern" css_animation=""][vc_column][action full_width="yes" content_in_grid="yes" type="normal" text_font_weight="600" show_button="yes" button_target="_self" background_color="#ffffff" padding_top="40" padding_bottom="40" text_letter_spacing="1px" button_text="CONTACT US" button_link="'.site_url('/contact/').'" button_text_color="#ffffff" button_hover_text_color="#0a0a0a" button_background_color="#f28e1f" button_hover_background_color="#f28e1f" button_border_color="#f28e1f" button_hover_border_color="#f28e1f"]GET IN TOUCH.<br /> CONTACT US FOR MORE INFORMATION[/action][/vc_column][/vc_row]'); ?>


<?php get_footer(); ?>
