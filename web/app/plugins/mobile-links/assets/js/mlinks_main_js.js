// JavaScript Document
$j = jQuery.noConflict();
var ctr_d = 0; 
$j(document).ready(function() { 
	var current_l = 1;
	var mlinks_send_to_editor = window.send_to_editor;
	var myOptions = {
    // you can declare a default color here,
    // or in the data-default-color attribute on the input
    defaultColor: false,
    // a callback to fire whenever the color changes to a valid color
    change: function(event, ui){},
    // a callback to fire when the input is emptied or an invalid color
    clear: function() {},
    // hide the color picker controls on load
    hide: true,
    // show a group of common colors beneath the square
    // or, supply an array of colors to customize further
    palettes: true
};
$j(".fancybox").fancybox({ closeBtn	: true });
$j('.my-color-field').wpColorPicker(myOptions);
$j('.mlink_upload_button').click(function() {
	current_l = $j(this).attr("rel");
	tb_show('Upload your selected icon', 'media-upload.php?referer=media_page&type=image&TB_iframe=true&post_id=0', false);
	
	window.send_to_editor = function(html_l) { 
		 console.log(html_l);
		var image_url = $j('img', html_l).attr('src');
		 
		console.log(image_url );
		$j('#ipath_'+current_l).val(image_url);
		$j('#mlinks_'+current_l).attr('src',image_url);
		tb_remove();  
		window.send_to_editor = mlinks_send_to_editor;
	}

	return false;
});
$j('.mbst_value_con input[type="text"]').each(function () { 
		ctr_d = ctr_d +1;
});
	
$j('.add_me').click(function() {
	ctr_d = ctr_d + 1;
	var div_n = $j(this).attr("rel");
	var complete = true;
	$j("#"+div_n+'_value_con input[type="text"]').each(function () { 
		if($j(this).val() == ""){ alert("Please complete the list first before adding new one!"); complete = false;}
	});
	if(complete){
		$j("#"+div_n+"_value_con").append("<input type='text' name='link_path[]' value='' id='"+div_n+"_"+ctr_d+"' class='link_url'/><span class='remove_me' rel='"+div_n+"_"+ctr_d+"'></span>");
		
		$j('.remove_me').click(function() {
			var div_n = $j(this).attr("rel"); 
			$j("#"+div_n).remove();
			$j(this).remove(); 
			
		}); 
	}
}); 

$j('.remove_me').click(function() {
	var div_n = $j(this).attr("rel"); 
	$j("#"+div_n).remove();
	$j(this).remove(); 
	
}); 
$j('#MyDate').datepicker({
	dateFormat : 'dd-mm-yy',
	minDate: 1 
});
	


});