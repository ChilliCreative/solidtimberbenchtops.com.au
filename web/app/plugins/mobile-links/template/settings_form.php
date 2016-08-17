<div class="wrap">
<h2>Mobile Links Settings</h2>
<hr />
<?php
	$lbl_arr = array("maps" => array("link_url" => "Address"),
					"mobile" => array("link_url" => "Phone number"),
					"email" => array("link_url" => "Mail To"),);
	$ctr_d = 0;				
	foreach($settings as $ky_set => $sett) {
?>
<div class="mlinks_title_div"><b><?php echo ucfirst($ky_set);?> Settings</b></div>
<div id="wrap-menu-settings-body">
    <form class="mobile_links_form" method="post" action="#"> 
    	<input type="hidden" name="settings_of" value="<?php echo $ky_set; ?>"/>
        <p class="mobile_links_label_t">Link Label:</p><input type="text" name="title" class="link_label" value="<?php echo $sett["label"]; ?>" /><br/>
        <p class="mobile_links_label_t"><?php echo $lbl_arr[$ky_set]["link_url"]; ?>:</p> <span class='add_me' title="Add New Record" rel="<?php echo $ky_set; ?>">Add New</span>
        <br/>
        <div id="<?php echo $ky_set; ?>_value_con" class="mbst_value_con">
        	<?php
				if(is_array($sett["link"]))
				{
					foreach($sett["link"] as $stl)
					{
						echo '<input type="text" name="link_path[]" class="link_url" id="'.$ky_set.'_'.$ctr_d.'" value="'.stripslashes($stl).'"><span class="remove_me" rel="'.$ky_set.'_'.$ctr_d.'"></span>';
						$ctr_d++;
					}
				} else if($sett["link"] != "") {
					echo '<input type="text" name="link_path[]" class="link_url" id="'.$ky_set.'_'.$ctr_d.'" value="'.stripslashes($sett["link"]).'"><span class="remove_me" rel="'.$ky_set.'_'.$ctr_d.'"></span>';
					$ctr_d++;
				}
			?>
        </div>
        <br/>
        <p class="mobile_links_label_t">Icon URL:</p><input type="text" name="icon_path" class="icon_link_url" value="<?php echo $sett["ipath"]; ?>" id="ipath_<?php echo $ky_set; ?>">
        <input type="button" value="Upload/Browse Icon" class="button-primary mlink_upload_button" id="upload_icon" rel="<?php echo $ky_set; ?>"/> Upload your icon from here.
        <a href="<?php echo $sett["ipath"]; ?>" target="_blank">
        	<img class="thumbnail" src="<?php echo $sett["ipath"]; ?>" alt="Click to view" title="Click to view" width="26" style="background:<?php echo $sett["bclr"]; ?> " id="mlinks_<?php echo $ky_set; ?>"/>
        </a> 
        <br/> 
		<p class="mobile_links_label_t">Background color:</p><input type="text" name="bg_color" value="<?php echo $sett["bclr"]; ?>" class="my-color-field" /> <br/>
        <p class="mobile_links_label_t">Font color:</p><input type="text" name="ft_color" value="<?php echo $sett["fclr"]; ?>" class="my-color-field" /> <br/>
        <p class="mobile_links_label_t">Border color:</p><input type="text" name="br_color" value="<?php echo $sett["border_clr"]; ?>" class="my-color-field" /> <br/>
        <br/><hr/>
        <p class="mobile_links_label_t">Tracking code:</p><input type="text" name="script_track_code" class="link_url" value="<?php echo stripslashes($scripts[$ky_set]["track_code"]); ?>" /><br/>
        <p class='description'>Please use single quote, on your tracking code</p><br/><br/>
        <input type="submit" name="mlinks_submit" class="save_path button-primary" id="submit_button" value="Save Setting">
    	
    </form>
</div><br/>
<?php } ?>
</div>