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
?> 
<input type="text" class="yee-form-control" name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?> value="<?php echo $setting_value;?>"/>
<input class="yee-btn yee-btn-default yee-btn-info" type="button" value="<?php echo JText::_('YEEDITOR_WIDGET_SETTING_SELECT_IMAGE');?>" onclick="select_image('<?php echo $element_param['param_name'];?>');"/>
<img data-yee-name="<?php echo $element_param['param_name'];?>" src="<?php echo $setting_value?JURI::root().$setting_value:YEEDITOR_URL.'assets/img/please-select-media.jpg';?>" class="img-thumbnail"/>

<script type="text/javascript" charset="utf-8">
	(function($){
		$(function(){
			$('.yeeditor').delegate('input[name="<?php echo $element_param['param_name'];?>"]',"change",function(e){
				var image_url = $(this).val();
				if(image_url.indexOf("http://") == -1 && image_url.indexOf("https://") == -1){
					image_url = yee_frontend + image_url;
				}
				$('img[data-yee-name="<?php echo $element_param['param_name'];?>"]').attr("src",image_url);
			});
		})
	
	if(!window.select_image){
		window.select_image = function(param_name,callBackFunction){
			if(typeof(callBackFunction)=="undefined"){
				callBackFunction = "";	
			}
			window.open (yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&yee-type=select_image&yee-callback="+callBackFunction+"&yee-name="+param_name,"newwindow","height=500,width=1100,top=" + (window.screen.availHeight-30-500)/2 +",left=" + (window.screen.availWidth-10-1100)/2 +",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no") ;
		}
	}
	//select image callback return the file url
	if(!window.trans_image_data){ 
		window.trans_image_data = function(file,name){   
			var name = name;
			$('#widgetModal [name="' + name+'"]').val(file);
			$('#widgetModal img[data-yee-name="' + name + '"]').attr("src",yee_frontend + file).show();
		}
	}
	})(window.jQuery);
</script>