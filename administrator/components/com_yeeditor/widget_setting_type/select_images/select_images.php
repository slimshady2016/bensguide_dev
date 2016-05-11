<?php 
/*------------------------------------------------------------------------
# YEEditor - independent
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
//You can find the setting and value in the '$element_param' varible. 
defined('_JEXEC') or die;
$type_attrbute="";
$output="";

if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];
	
$setting_value = $element_setting[$element_param['param_name']];

$item_settings = array("title"=>"","link"=>"","description"=>"");
if(isset($element_param['item-settings']) && is_array($element_param['item-settings'])){
	if(!in_array("title",$element_param['item-settings'])){
		$item_settings['title'] = ' class="hide"';
	}
	if(!in_array("link",$element_param['item-settings'])){
		$item_settings['link'] = ' class="hide"';
	}
	if(!in_array("description",$element_param['item-settings'])){
		$item_settings['description'] = ' class="hide"';
	}
}
?>
<style>
/*== select images ==*/
div.yeeditor .images_holder li{
  width: 80px;
  height: 80px;
  border: 1px solid #ccc;
  float: left;
  margin-right: 20px;
  margin-bottom: 10px;
  position: relative;
  list-style:none ;
  
}
div.yeeditor .images_holder li img {
    border: 0 none;
    height: auto;
    max-width: 100%;
    vertical-align: middle;
}
div.yeeditor .images_holder li img{
  max-height: 60px;
}
div.yeeditor .images_holder li a.fa-times-circle-o{
  position: absolute;
  right: -8px;
  top: -8px;
  cursor: pointer;
}
div.yeeditor .images_holder li a.fa-edit{
  position: absolute;
  right: 2px;
  bottom: 2px;
  cursor: pointer;
}
div.yeeditor .images_holder li.add_new_image i{
  position: relative;
  top: 31px;
  left: 31px;
}
div.yeeditor .images_holder li.add_new_image{
  cursor: pointer;
}
div.yeeditor .images_edit_info{
  display: none;
}
div.yeeditor .images_holder li.highlight{
  border: 1px solid #006DCC;
}
</style>
<div class="yee-select-images" data-yeeSettingName="<?php echo $element_param['param_name'];?>">
	<textarea name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?>><?php echo $setting_value;?></textarea>

	
	<ul class="yee-row images_holder yee-setting-images" >
		<li class="add_new_image" onclick="select_images('<?php echo $element_param['param_name'];?>');"><i class="fa fa-plus"></i></li>
	</ul>
	
	<div class="images_edit_info">
    	<div><label for="images_item_src"><?php echo JText::_('YEEDITOR_WIDGET_SETTING_IMAGE_SRC');?></label><div class="yee-row"><div class="yee-col-md-8"><input class="yee-form-control" type="text" name="images_item_src" readonly="readonly"/></div><div class="yee-col-md-4"><a href="#" class="yee-btn yee-btn-info yee-setting-images-changeImage"><?php echo JText::_('YEEDITOR_WIDGET_SETTING_SELECT_IMAGE');?></a></div></div></div>
		<div<?php echo $item_settings['title'];?>><label for="images_item_title"><?php echo JText::_('YEEDITOR_WIDGET_SETTING_TITLE');?></label><input class="yee-form-control" type="text" name="images_item_title" /></div>
		<div<?php echo $item_settings['link'];?>><label for="images_item_url"><?php echo JText::_('YEEDITOR_WIDGET_SETTING_LINK');?></label><input class="yee-form-control" type="text" name="images_item_url" /></div>
		<div<?php echo $item_settings['description'];?>><label for="images_item_description"><?php echo JText::_('YEEDITOR_WIDGET_SETTING_DESCRIPTION');?></label><textarea class="yee-form-control" name="images_item_description" ></textarea></div>
	</div>
</div>	
<script type="text/javascript" charset="utf-8">
(function($){
	if(!window.select_images){
		window.select_images = function(name){
			window.open (yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&yee-type=select_images&yee-name="+name,"newwindow","height=500,width=1100,top=" + (window.screen.availHeight-30-500)/2 +",left=" + (window.screen.availWidth-10-1100)/2 +",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no") ;
		}
	}
	
	if(!window.trans_images_data){
		window.trans_images_data = function(url ,name){
			var images_area = $(document).find('.yee-select-images textarea[name="'+name+'"]');
			var arr = images_area.text() ? JSON.decode( images_area.text()) : [],
				newObj = {};
			newObj.src = url;
			newObj.description = "";
			newObj.title = "";
			newObj.url = "";
			arr.push(newObj);

			images_area.text(JSON.encode(arr));
			$("<li data-yee-title='' data-yee-url='' data-yee-description='' data-yee-src='" + url + "'><img src='"+ yee_frontend + url+"'/><a class='fa fa-times-circle-o'></a><a class='fa fa-edit'></a></li>").insertBefore("#widgetModal div[data-yeeSettingName='"+name+"'] .add_new_image");
			$("#widgetModal .images_holder").sortable({
				items: "li:not(.add_new_image)",
				stop: function(){
					get_images_data(name);
				},
				placeholder: "ui-state-highlight",
				helper: "clone",
				tolerance: "pointer"
			});
			get_images_data(name);
		}
	}
	if(!window.get_images_data){
		function get_images_data(name){
			var arr = [];
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .images_holder li:not(.add_new_image)").each(function(){
				var newObj = {};
				newObj.src = $(this).attr("data-yee-src");
				newObj.description = $(this).attr("data-yee-description");
				newObj.title = $(this).attr("data-yee-title");
				newObj.url = $(this).attr("data-yee-url");
				arr.push(newObj);
			});

			$(document).find(".yee-select-images textarea[name='"+name+"']").text(JSON.encode(arr));
		}
	}
	if(!window.init_images_data){
		function init_images_data(name){
			images_area = $(document).find(".yee-select-images textarea[name='"+name+"']");
			arr = images_area.text() ? JSON.decode(images_area.text()) : [];

			for(var i = 0; i < arr.length; i ++){
				var image_url = arr[i].src;
				if(image_url.indexOf("http://") == -1 && image_url.indexOf("https://") == -1){
					image_url = yee_frontend + image_url;
				}
				$("<li data-yee-title='"+arr[i].title +"' data-yee-url='" + arr[i].url + "' data-yee-description='" + arr[i].description +"' data-yee-src='" + arr[i].src + "'><img src='"+ image_url + "'/><a class='fa fa-times-circle-o'></a><a class='fa fa-edit'></a></li>").insertBefore("#widgetModal div[data-yeeSettingName='"+name+"'] .add_new_image");
			}
		}
	}
	//select image
	if(!window.select_image){
		window.select_image = function(param_name,callBackFunction){
			if(typeof(callBackFunction)=="undefined"){
				callBackFunction = "";	
			}
			window.open (yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&yee-type=select_image&yee-callback="+callBackFunction+"&yee-name="+param_name,"newwindow","height=500,width=1100,top=" + (window.screen.availHeight-30-500)/2 +",left=" + (window.screen.availWidth-10-1100)/2 +",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no") ;
		}
	}
	//select image callback return the file url
	if(!window.trans_images_image_data){ 
		window.trans_images_image_data = function(file,name){   
			var name = name;
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .images_holder .highlight").attr("data-yee-src",file);
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .images_holder .highlight img").attr("src",yee_frontend + file);
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .images_edit_info input[name='images_item_src']").val(file);
			get_images_data(name);
		}
	}

	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] .images_holder").delegate("a.fa-times-circle-o", "click", function(e){
		e.preventDefault();
		var name = $(this).parents(".yee-select-images").eq(0).attr("data-yeeSettingName");
		$(this).parent().remove();
		get_images_data(name);
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] .images_holder").delegate("a.fa-edit", "click", function(e){
		e.preventDefault();
		var current_wrapper = $(this).parents(".yee-select-images").eq(0);
		$("#widgetModal .images_edit_info").hide();
		current_wrapper.find("input[name='images_item_src']").val($(this).parent().attr("data-yee-src"));
		current_wrapper.find("input[name='images_item_title']").val($(this).parent().attr("data-yee-title"));
		current_wrapper.find("input[name='images_item_url']").val($(this).parent().attr("data-yee-url"));
		current_wrapper.find("textarea[name='images_item_description']").val($(this).parent().attr("data-yee-description"));
		current_wrapper.find(".images_edit_info").fadeIn();
		$(this).parent().siblings().removeClass("highlight");
		$(this).parent().addClass("highlight");
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>']").delegate(".yee-setting-images-changeImage", "click", function(e){
		e.preventDefault();
		var name = $(this).parents(".yee-select-images").eq(0).attr("data-yeeSettingName");
		select_image(name,"trans_images_image_data");
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] input[name='images_item_title']").keyup(function(){
		$(this).parents(".yee-select-images").eq(0).find(".images_holder .highlight").attr("data-yee-title", $(this).val());
		var name = $(this).parents(".yee-select-images").eq(0).attr("data-yeeSettingName");
		get_images_data(name);
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] input[name='images_item_url']").keyup(function(){
		$(this).parents(".yee-select-images").eq(0).find(".images_holder .highlight").attr("data-yee-url", $(this).val());
		var name = $(this).parents(".yee-select-images").eq(0).attr("data-yeeSettingName");
		get_images_data(name);
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] textarea[name='images_item_description']").keyup(function(){
		$(this).parents(".yee-select-images").eq(0).find(".images_holder .highlight").attr("data-yee-description", $(this).val());
		var name = $(this).parents(".yee-select-images").eq(0).attr("data-yeeSettingName");
		get_images_data(name);
	});
		
	init_images_data('<?php echo $element_param['param_name'];?>');
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] .images_holder").sortable({
		items: "li:not(.add_new_image)",
		stop: function(){
			get_images_data('<?php echo $element_param['param_name'];?>');
		},
		placeholder: "ui-state-highlight",
		helper: "clone",
		tolerance: "pointer"
	});
})(window.jQuery);


</script>