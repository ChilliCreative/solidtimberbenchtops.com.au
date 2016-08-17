<?php
add_action('admin_menu', '_set_admin_view');
function _set_admin_view()
{
	add_menu_page('Mobile Links', 'Mobile Links', 0, 'tbst_mobile_links-settings', 'tbst_mobile_links_settings_page',  'dashicons-admin-links');
	add_submenu_page('tbst_mobile_links-settings','Preview', 'Preview', 0, 'tbst_mobile_links-preview', 'tbst_mobile_links_preview_page');
	add_submenu_page('tbst_mobile_links-settings','Analytics', 'Analytics', 0, 'tbst_mobile_links-analytics', 'tbst_mobile_links_analytics_page');
}

function tbst_mobile_links_settings_page()
{
	global $wpdb;

	$settings = get_mlinks_settings();
	$scripts = get_script_settings();
	$settings = check_updates($settings, $scripts);
	$settings = unserialize($settings);
	$scripts = unserialize(get_script_settings());

	require_once( plugin_dir_path( __FILE__ ) . "template/settings_form.php");
}

function get_mlinks_settings()
{
	return get_option('mlinks_settings') == "" ? get_default() : get_option('mlinks_settings');
}
function get_script_settings()
{
	return get_option('mlinks_scripts') == "" ? get_default("scripts") : get_option('mlinks_scripts');
}
function get_default($type = "links")
{
	return $type == "links" ? serialize(array("maps"=>array("ipath"=>plugins_url('assets/images/maps.png', __FILE__ ), "label"=>"open in maps", "fclr"=>"#d3d3d3", "bclr"=>"#1a1a1a", "link"=>"", "border_clr"=>"#000000"),
						"mobile"=>array("ipath"=>plugins_url('assets/images/mobile.png', __FILE__ ), "label"=>"click to call", "fclr"=>"#d3d3d3", "bclr"=>"#1a1a1a", "link"=>"", "border_clr"=>"#000000"),
						"email"=>array("ipath"=>plugins_url('assets/images/email.png', __FILE__ ), "label"=>"send email", "fclr"=>"#d3d3d3", "bclr"=>"#1a1a1a", "link"=>"", "border_clr"=>"#000000"))) : serialize (array("maps"=> array("track_code" => "ga('send', 'event', { eventCategory: 'IMExpert Leads', eventAction:'Map', eventLabel: 'Mapped', eventValue: 1})"), "mobile"=> array("track_code" => "ga('send', 'event', { eventCategory: 'IMExpert Leads', eventAction:'Call', eventLabel: 'Called', eventValue: 1})"), "email"=> array("track_code" => "ga('send', 'event', { eventCategory: 'IMExpert Leads', eventAction:'Email', eventLabel: 'Emailed', eventValue: 1})")));
}

function check_updates($settings, $scripts)
{
	global $wpdb;
	if(isset($_POST["settings_of"]))
	{
		$set = $_POST["settings_of"];
		$settings = unserialize($settings);
		$scripts = unserialize($scripts);
		$settings[$set]["ipath"] = $_POST["icon_path"];
		$settings[$set]["label"] = $_POST["title"];
		$settings[$set]["fclr"] = $_POST["ft_color"];
		$settings[$set]["bclr"] = $_POST["bg_color"];
		$settings[$set]["link"] = $_POST["link_path"];
		$settings[$set]["border_clr"] = $_POST["br_color"];
		$scripts[$set]["track_code"] = str_replace('"', "'", $_POST["script_track_code"]);

		update_option('mlinks_settings', serialize($settings));
		update_option('mlinks_scripts', serialize($scripts));
	}

	return get_mlinks_settings();
}

function tbst_mobile_links_preview_page()
{
	echo "
	<div class='wrap'>
	<h2>Mobile Links Preview</h2><hr/>
		<div id='wrap-menu-settings-body'>
			".view_button()."
		</div>
	</div>
		";
}
function tbst_mobile_links_analytics_page()
{
	if(isset($_POST["mlinks_analytics_submit"])){
		update_option('mlinks_analytics', ($_POST["UA_number"]));
	}
	$ua_number = get_option('mlinks_analytics');
	echo "
	<div class='wrap'>
	<h2>Mobile Links Analytics Setup</h2><hr/>
		<div id='wrap-menu-settings-body'>
			 <form class='mobile_links_form' method='post' action='#'>
			 	 <p class='mobile_links_label_t'>Analytics UA number:</p><input type='text' name='UA_number' class='link_label' value='".$ua_number."' placeholder='UA-XXXXXXXX-1' /><br/>
			 	 <p class='description'>This will only apply if there are no analytics setup previously, empty the field to disable.</p><br/>
				 <input type='submit' name='mlinks_analytics_submit' class='save_path button-primary' id='submit_button' value='Save Setting'>
			 </form>
		</div>
	</div>
		";
}
function view_button()
{
	$settings = get_mlinks_settings();
	$settings = unserialize($settings);

	$scripts = get_script_settings();
	$scripts = unserialize($scripts);

	if(is_array($settings["mobile"]["link"]) && count($settings["mobile"]["link"]) >1){
		$set_mob = "<a target='' href='#tbst_mob_content' class='fancybox mlinks_a'>
					<div class='mlinks_item' style='color:".$settings["mobile"]["fclr"]."; border-color:".$settings["mobile"]["border_clr"]."; background-image:url(".$settings["mobile"]["ipath"]."); background-color:".$settings["mobile"]["bclr"].";'>".$settings["mobile"]["label"]."</div>
				</a>
			<div id='tbst_mob_content' class='mlinks_h_val'>";

		foreach($settings["mobile"]["link"] as $stl)
		{
			$stl_l = "tel:". str_replace("tel:", "", $stl);
			$set_mob.="<a class='mlinks_array' target='' href='".$stl_l."' onClick=\"".stripslashes($scripts["mobile"]["track_code"])."\">".$stl."</a>";
		}
		$set_mob.="</div>";
	} else if(is_array($settings["mobile"]["link"]) && count($settings["mobile"]["link"]) > 0) {
		$settings["mobile"]["link"][0] = "tel:". str_replace("tel:", "", $settings["mobile"]["link"][0]);
		$set_mob =($settings["mobile"]["link"][0] != "tel:" ? "<a class='mlinks_a' target='' href='".$settings["mobile"]["link"][0]."' onClick=\"".stripslashes($scripts["mobile"]["track_code"])."\">
					<div class='mlinks_item' style='color:".$settings["mobile"]["fclr"]."; border-color:".$settings["mobile"]["border_clr"]."; background-image:url(".$settings["mobile"]["ipath"]."); background-color:".$settings["mobile"]["bclr"].";'>".$settings["mobile"]["label"]."</div>
				</a>" : "");
	} else {
		$settings["mobile"]["link"] = "tel:". str_replace("tel:", "", $settings["mobile"]["link"]);
		$set_mob =($settings["mobile"]["link"] != "tel:" ? "<a class='mlinks_a' target='' href='".$settings["mobile"]["link"]."' onClick=\"".stripslashes($scripts["mobile"]["track_code"])."\">
					<div class='mlinks_item' style='color:".$settings["mobile"]["fclr"]."; border-color:".$settings["mobile"]["border_clr"]."; background-image:url(".$settings["mobile"]["ipath"]."); background-color:".$settings["mobile"]["bclr"].";'>".$settings["mobile"]["label"]."</div>
				</a>" : "");
	}
	if(is_array($settings["email"]["link"]) && count($settings["email"]["link"]) > 1){
		$set_mail = "<a target='' href='#tbst_email_content' class='fancybox mlinks_a'>
					<div class='mlinks_item' style='color:".$settings["email"]["fclr"]."; border-color:".$settings["email"]["border_clr"]."; background-image:url(".$settings["email"]["ipath"]."); background-color:".$settings["email"]["bclr"].";'>".$settings["email"]["label"]."</div>
				</a>
			<div id='tbst_email_content' class='mlinks_h_val'>";

		foreach($settings["email"]["link"] as $stl)
		{
			$stl_l =  "mailto:". str_replace("mailto:", "", $stl);
			$set_mail.="<a class='mlinks_array' target='' href='".$stl_l."' onClick=\"".stripslashes($scripts["email"]["track_code"])."\">".$stl."</a>";
		}
		$set_mail.="</div>";

	} else if(is_array($settings["email"]["link"]) && count($settings["email"]["link"]) > 0) {
		$settings["email"]["link"][0] = "mailto:". str_replace("mailto:", "", $settings["email"]["link"][0]);
		$set_mail =($settings["email"]["link"][0] != "tel:" ? "<a class='mlinks_a' target='' href='".$settings["email"]["link"][0]."' onClick=\"".stripslashes($scripts["email"]["track_code"])."\">
					<div class='mlinks_item' style='color:".$settings["email"]["fclr"]."; border-color:".$settings["email"]["border_clr"]."; background-image:url(".$settings["email"]["ipath"]."); background-color:".$settings["email"]["bclr"].";'>".$settings["email"]["label"]."</div>
				</a>" : "");
	} else {
		$settings["email"]["link"] = "mailto:". str_replace("mailto:", "", $settings["email"]["link"]);
		$set_mail = ($settings["email"]["link"] != "mailto:" ? "<a class='mlinks_a' target='' href='".$settings["email"]["link"]."' onClick=\"".stripslashes($scripts["email"]["track_code"])."\">
					<div class='mlinks_item' style='color:".$settings["email"]["fclr"]."; border-color:".$settings["email"]["border_clr"]."; background-image:url(".$settings["email"]["ipath"]."); background-color:".$settings["email"]["bclr"].";'>".$settings["email"]["label"]."</div>
				</a>" : "" );
	}
	if(is_array($settings["maps"]["link"]) && count($settings["maps"]["link"]) > 1){
		$set_map = "<a target='' href='#tbst_maps_content' class='fancybox mlinks_a'>
					<div class='mlinks_item' style='color:".$settings["maps"]["fclr"]."; border-color:".$settings["maps"]["border_clr"]."; background-image:url(".$settings["maps"]["ipath"]."); background-color:".$settings["maps"]["bclr"].";'>".$settings["maps"]["label"]."</div>
				</a>
				<div id='tbst_maps_content' class='mlinks_h_val'>";

		foreach($settings["maps"]["link"] as $stl)
		{
			$stl_l= "http://maps.apple.com/?q=". str_replace("http://maps.google.com/?q=", "",str_replace("http://maps.apple.com/?q=", "", $stl));
			$set_map.="<a class='mlinks_array' target='_blank' href='".$stl_l."' onClick=\"".stripslashes($scripts["maps"]["track_code"])."\">".$stl."</a>";
		}
		$set_map.="</div>";

	} else if(is_array($settings["maps"]["link"]) && count($settings["maps"]["link"]) > 0) {
		$settings["maps"]["link"][0] = "http://maps.apple.com/?q=". str_replace("http://maps.google.com/?q=", "",str_replace("http://maps.apple.com/?q=", "", $settings["maps"]["link"][0]));
		$set_map =($settings["maps"]["link"][0] != "tel:" ? "<a class='mlinks_a' target='_blank' href='".$settings["maps"]["link"][0]."' onClick=\"".stripslashes($scripts["maps"]["track_code"])."\">
					<div class='mlinks_item' style='color:".$settings["maps"]["fclr"]."; border-color:".$settings["maps"]["border_clr"]."; background-image:url(".$settings["maps"]["ipath"]."); background-color:".$settings["maps"]["bclr"].";'>".$settings["maps"]["label"]."</div>
				</a>" : "");
	} else {
		$settings["maps"]["link"] = "http://maps.apple.com/?q=". str_replace("http://maps.google.com/?q=", "",str_replace("http://maps.apple.com/?q=", "", $settings["maps"]["link"]));
		$set_map = ($settings["maps"]["link"] != "http://maps.apple.com/?q=" ? "<a class='mlinks_a' target='_blank' href='".$settings["maps"]["link"]."' onClick=\"".stripslashes($scripts["maps"]["track_code"])."\">
					<div class='mlinks_item' style='color:".$settings["maps"]["fclr"]."; border-color:".$settings["maps"]["border_clr"]."; background-image:url(".$settings["maps"]["ipath"]."); background-color:".$settings["maps"]["bclr"].";'>".$settings["maps"]["label"]."</div>
				</a>" :"");
	}


	return "<div id='mlinks_preview_container'>".$set_map.$set_mob.$set_mail."</div>"
			;
}

function return_footer()
{
	echo view_button()."<div id='mlinks_hollow'></div>".add_mobile_style();
	$track_id = get_option('mlinks_analytics') ;
	if($track_id != ""){
		echo "
		<script>
		  if (typeof ga === 'undefined') {
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			  ga('create', '".$track_id."', 'auto');
			  ga('send', 'pageview');
		  }
		</script>";
	}
}
function add_mobile_style()
{
	return '<style type="text/css">
				#mlinks_preview_container
				{	position:fixed; bottom: 0; z-index:9999; }
			</style>';
}
function mytheme_setup() {
	// Set default values for the upload media box
	update_option('image_default_align', 'center' );
	update_option('image_default_link_type', 'file' );
	update_option('image_default_size', 'large' );

}
add_action('after_setup_theme', 'mytheme_setup');
if ( wp_is_mobile() ) {
	 add_action( 'wp_footer', 'return_footer', 100 );
}
