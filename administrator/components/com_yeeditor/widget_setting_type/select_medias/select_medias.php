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

$item_settings = array("title"=>"","artist"=>"","poster"=>"","description"=>"");
if(isset($element_param['item-settings']) && is_array($element_param['item-settings'])){
	if(!in_array("title",$element_param['item-settings'])){
		$item_settings['title'] = ' class="hide"';
	}
	if(!in_array("artist",$element_param['item-settings'])){
		$item_settings['artist'] = ' class="hide"';
	}
	if(!in_array("poster",$element_param['item-settings'])){
		$item_settings['poster'] = ' class="hide"';
	}
	if(!in_array("description",$element_param['item-settings'])){
		$item_settings['description'] = ' class="hide"';
	}
}

$setting_html = '<div class="edit_info"><div><label for="item_src">'.JText::_('YEEDITOR_WIDGET_SETTING_MEDIA_SRC').'</label><div class="yee-row"><div class="yee-col-md-8"><input class="yee-form-control" type="text" name="item_src"/></div><div class="yee-col-md-4"><a href="#" class="yee-btn yee-btn-info yee-setting-images-changeMedia">'.JText::_('YEEDITOR_WIDGET_SETTING_SELECT_IMAGE').'</a></div></div></div><div'.$item_settings['poster'].'><label for="item_poster">'.JText::_('YEEDITOR_WIDGET_SETTING_POSTER').'</label><div class="yee-row"><div class="yee-col-md-8"><input class="yee-form-control" type="text" name="item_poster" /></div><div class="yee-col-md-4"><a href="#" class="yee-btn yee-btn-info yee-setting-images-changeImage">'.JText::_('YEEDITOR_WIDGET_SETTING_SELECT_IMAGE').'</a></div></div></div><div'.$item_settings['title'].'><label for="item_title">'.JText::_('YEEDITOR_WIDGET_SETTING_TITLE').'</label><input class="yee-form-control" type="text" name="item_title" /></div><div'.$item_settings['artist'].'><label for="item_artist">'.JText::_('YEEDITOR_WIDGET_SETTING_ARTIST').'</label><input class="yee-form-control" type="text" name="item_artist" /></div><div'.$item_settings['description'].'><label for="item_description">'.JText::_('YEEDITOR_WIDGET_SETTING_DESCRIPTION').'</label><textarea class="yee-form-control" name="item_description" ></textarea></div></div>';
?>
<style>
/*== select images ==*/
div.yeeditor .yee-select-medias {
	background-color:#FFF;
}
div.yeeditor .yee-select-medias .holder li{
  height: 35px;
  border: 1px solid #ccc;
  margin-bottom: 5px;
  position: relative;
  list-style:none ;
}
div.yeeditor .yee-select-medias .holder li:first-child{
	margin-top:10px;
}
div.yeeditor .yee-select-medias .holder li:last-child{
	/*margin-bottom:0;*/
}
div.yeeditor .yee-select-medias .holder li img {
    border: 0 none;
    height: 30px;
    width: 40px;
	padding: 5px;
    vertical-align: middle;
}
div.yeeditor .yee-select-medias .holder li img{
  max-height: 60px;
}
div.yeeditor .yee-select-medias .holder li a.fa-times-circle-o{
  cursor: pointer;
  float: right;
  margin-left: 15px;
  margin-right: 5px;
  margin-top: 10px;
}
div.yeeditor .yee-select-medias .holder li a.fa-edit{
  cursor: pointer;
  float: right;
  margin-top: 10px;
}
div.yeeditor .yee-select-medias .holder li.add_new_image i{
	margin-top: 10px;
}
div.yeeditor .yee-select-medias .holder li.add_new_image{
  cursor: pointer;
  width:150px;
  text-align:center;
}
div.yeeditor .yee-select-medias .edit_info{
  display: none;
  clear: both;
  padding: 5px;
  margin-bottom: 20px;
}
div.yeeditor .yee-select-medias .holder li.highlight{
  border: 1px solid #006DCC;
}
</style>
<div class="yee-select-medias yee-row" data-yeeSettingName="<?php echo $element_param['param_name'];?>">
	<textarea name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?>><?php echo $setting_value;?></textarea>

	
	<ul class="holder yee-setting-images yee-col-md-5" >
		<li class="add_new_image yee-btn-info" onclick="select_medias('<?php echo $element_param['param_name'];?>','trans_medias_data');"><i class="fa fa-plus"></i></li>
	</ul>
	
</div>	
<script type="text/javascript" charset="utf-8">
(function($){

	if(!window.select_medias){
		window.select_medias = function(name,callback){
			window.open (yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&yee-type=select_images&yee-callback="+callback+"&yee-name="+name,"newwindow","height=500,width=1100,top=" + (window.screen.availHeight-30-500)/2 +",left=" + (window.screen.availWidth-10-1100)/2 +",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no") ;
		}
	}
	
	if(!window.trans_medias_data){
		window.trans_medias_data = function(url ,name){
			var area = $(document).find('.yee-select-medias textarea[name="'+name+'"]');
			var arr = area.text() ? JSON.decode( area.text()) : [],
				newObj = {};
			var fileEx = url.replace(/.+[\/\.]/g,"");	
				
			newObj.src = url;
			newObj.description = "";
			newObj.title = "";
			newObj.artist = "";
			newObj.poster = "";
			arr.push(newObj);

			area.text(JSON.encode(arr));
			$("<li data-yee-title='' data-yee-artist='' data-yee-poster='' data-yee-description='' data-yee-src='" + url + "' data-yee-poster=''><img src='"+ yee_frontend + "plugins/editors/yeeditor/assets/img/please-select-media.jpg'/><span class='yee-select-medias-item-title'></span> - <span class='file-format'>"+fileEx+"</span><a class='fa fa-times-circle-o'></a><a class='fa fa-edit'></a></li>").insertBefore("#widgetModal div[data-yeeSettingName='"+name+"'] .add_new_image");
			$("#widgetModal .holder").sortable({
				items: "li:not(.add_new_image)",
				stop: function(){
					get_medias_data(name);
				},
				placeholder: "ui-state-highlight",
				helper: "clone",
				tolerance: "pointer"
			});
			get_medias_data(name);
		}
	}
	if(!window.get_medias_data){
		function get_medias_data(name){
			var arr = [];
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .holder li:not(.add_new_image)").each(function(){
				var newObj = {};
				newObj.src = $(this).attr("data-yee-src");
				newObj.description = $(this).attr("data-yee-description");
				newObj.title = $(this).attr("data-yee-title");
				newObj.artist = $(this).attr("data-yee-artist");
				newObj.poster = $(this).attr("data-yee-poster");
				arr.push(newObj);
			});

			$(document).find(".yee-select-medias textarea[name='"+name+"']").text(JSON.encode(arr));
		}
	}
	if(!window.init_data){
		function init_data(name){
			area = $(document).find(".yee-select-medias textarea[name='"+name+"']");
			arr = area.text() ? JSON.decode(area.text()) : [];

			for(var i = 0; i < arr.length; i ++){
				var image_url = arr[i].poster;
				if(image_url){
					if(image_url.indexOf("http://") == -1 && image_url.indexOf("https://") == -1){
						image_url = yee_frontend + image_url;
					}
				}
				else{
					image_url = yee_frontend + "plugins/editors/yeeditor/assets/img/please-select-media.jpg";
				}
				
				var fileEx = arr[i].src.replace(/.+[\/\.]/g,"");
				
				$("<li data-yee-title='"+arr[i].title +"' data-yee-artist='"+arr[i].artist +"' data-yee-poster='" + arr[i].poster + "' data-yee-description='" + arr[i].description +"' data-yee-src='" + arr[i].src + "'><img src='"+ image_url + "'/><span class='yee-select-medias-item-title'>"+arr[i].title +"</span> - <span class='file-format'>"+fileEx+"</span><a class='fa fa-times-circle-o'></a><a class='fa fa-edit'></a></li>").insertBefore("#widgetModal div[data-yeeSettingName='"+name+"'] .add_new_image");
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
	if(!window.trans_medias_image_data){ 
		window.trans_medias_image_data = function(file,name){   
			var name = name;
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .holder .highlight").attr("data-yee-poster",file);
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .holder .highlight img").attr("src",yee_frontend + file);
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .edit_info input[name='item_poster']").val(file);
			get_medias_data(name);
		}
	}
	//select media
	if(!window.select_media){
		window.select_media = function(param_name,callBackFunction){
			if(typeof(callBackFunction)=="undefined"){
				callBackFunction = "";	
			}
			window.open (yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&yee-type=select_image&yee-callback="+callBackFunction+"&yee-name="+param_name,"newwindow","height=500,width=1100,top=" + (window.screen.availHeight-30-500)/2 +",left=" + (window.screen.availWidth-10-1100)/2 +",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no") ;
		}
	}
	//select image callback return the file url
	if(!window.trans_medias_media_data){ 
		window.trans_medias_media_data = function(file,name){   
			var name = name;
			var fileEx = file.replace(/.+[\/\.]/g,"");
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .holder .highlight .file-format").text(fileEx);
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .holder .highlight").attr("data-yee-src",file);
			$("#widgetModal div[data-yeeSettingName='"+name+"'] .edit_info input[name='item_src']").val(file);
			get_medias_data(name);
		}
	}

	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] .holder").delegate("a.fa-times-circle-o", "click", function(e){
		e.preventDefault();
		$("#widgetModal  .edit_info").remove();
		var name = $(this).parents(".yee-select-medias").eq(0).attr("data-yeeSettingName");
		$(this).parent().remove();
		get_medias_data(name);
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] .holder").delegate("a.fa-edit", "click", function(e){
		e.preventDefault();
		$("#widgetModal  .edit_info").remove();
		$('<?php echo $setting_html;?>').insertAfter($(this).parents(".highlight").eq(0));
		
		var current_wrapper = $(this).parents(".yee-select-medias").eq(0);
		$("#widgetModal .edit_info").hide();
		current_wrapper.find("input[name='item_src']").val($(this).parent().attr("data-yee-src"));
		current_wrapper.find("input[name='item_title']").val($(this).parent().attr("data-yee-title"));
		current_wrapper.find("input[name='item_artist']").val($(this).parent().attr("data-yee-artist"));
		current_wrapper.find("input[name='item_poster']").val($(this).parent().attr("data-yee-poster"));
		current_wrapper.find("textarea[name='item_description']").val($(this).parent().attr("data-yee-description"));
		current_wrapper.find(".edit_info").fadeIn();
		$(this).parent().siblings().removeClass("highlight");
		$(this).parent().addClass("highlight");
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>']").delegate(".yee-setting-images-changeMedia", "click", function(e){
		e.preventDefault();
		var name = $(this).parents(".yee-select-medias").eq(0).attr("data-yeeSettingName");
		select_media(name,"trans_medias_media_data");
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>']").delegate("input[name='item_title']", "keyup", function(e){
		e.preventDefault();
		$(this).parents(".yee-select-medias").eq(0).find(".holder .highlight").attr("data-yee-title", $(this).val());
		$(this).parents(".yee-select-medias").eq(0).find(".holder .highlight .yee-select-medias-item-title").text($(this).val());
		var name = $(this).parents(".yee-select-medias").eq(0).attr("data-yeeSettingName");
		get_medias_data(name);
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>']").delegate("input[name='item_artist']", "keyup", function(e){
		e.preventDefault();
		$(this).parents(".yee-select-medias").eq(0).find(".holder .highlight").attr("data-yee-artist", $(this).val());
		var name = $(this).parents(".yee-select-medias").eq(0).attr("data-yeeSettingName");
		get_medias_data(name);
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>']").delegate("input[name='item_src']", "keyup", function(e){
		e.preventDefault();
		$(this).parents(".yee-select-medias").eq(0).find(".holder .highlight").attr("data-yee-src", $(this).val());
		var name = $(this).parents(".yee-select-medias").eq(0).attr("data-yeeSettingName");
		get_medias_data(name);
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>']").delegate("input[name='item_poster']", "keyup", function(e){
		e.preventDefault();
		$(this).parents(".yee-select-medias").eq(0).find(".holder .highlight").attr("data-yee-poster", $(this).val());
		var name = $(this).parents(".yee-select-medias").eq(0).attr("data-yeeSettingName");
		get_medias_data(name);
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>']").delegate(".yee-setting-images-changeImage", "click", function(e){
		e.preventDefault();
		$(this).parents(".yee-select-medias").eq(0).find(".holder .highlight").attr("data-yee-poster", $(this).val());
		var name = $(this).parents(".yee-select-medias").eq(0).attr("data-yeeSettingName");
		select_image(name,"trans_medias_image_data");
	});
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>']").delegate("textarea[name='item_description']", "keyup", function(e){
		e.preventDefault();
		$(this).parents(".yee-select-medias").eq(0).find(".holder .highlight").attr("data-yee-description", $(this).val());
		var name = $(this).parents(".yee-select-medias").eq(0).attr("data-yeeSettingName");
		get_medias_data(name);
	});
		
	init_data('<?php echo $element_param['param_name'];?>');
	$("#widgetModal div[data-yeeSettingName='<?php echo $element_param['param_name'];?>'] .holder").sortable({
		items: "li:not(.add_new_image)",
		start: function(){
			$("#widgetModal  .edit_info").remove();
		},
		stop: function(){
			get_medias_data('<?php echo $element_param['param_name'];?>');
		},
		placeholder: "ui-state-highlight",
		helper: "clone",
		tolerance: "pointer"
	});
})(window.jQuery);


</script>