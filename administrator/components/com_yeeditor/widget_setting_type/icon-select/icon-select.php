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
defined('_JEXEC') or die;

//You can find the setting and value in the '$element_param' varible. 

$type_attrbute="";
$output="";

if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];

$setting_value = $element_setting[$element_param['param_name']];	

$option_value=array (
  '' => 'None',
  'fa-automobile' => 'fa-automobile',
  'fa-bank' => 'fa-bank'
);
?>

<input class="yee-form-control" name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?> value="<?php echo $setting_value;?>" />

<div class="yee-btn-group">
	<button class="yee-btn yee-btn-default" type="button" data-yee-name="<?php echo $element_param['param_name'];?>"><?php echo $setting_value?'&nbsp;<i class="'.$setting_value.'"></i>&nbsp;':'None';?></button>
	<div class="yee-btn-group">
		<button class="yee-btn yee-btn-default yee-btn-info" type="button" onclick="select_icon()">
			Select
		</button>
	</div>
</div>

<script type="text/javascript" charset="utf-8">
	(function($){
		$(function(){
			$('.yeeditor').delegate('#widgetModal input[name="<?php echo $element_param['param_name'];?>"]',"change",function(e){
				e.preventDefault();
				if($(this).val()){
					$('#widgetModal button[data-yee-name="<?php echo $element_param['param_name'];?>"]').html('<i class="'+$(this).val()+'"></i>');
				}
				else{
					$('#widgetModal button[data-yee-name="<?php echo $element_param['param_name'];?>"]').html('None');
				}
			});
		})
	
	if(!window.select_icon){
		window.select_icon = function(){
			window.open ("<?php echo YEEDITOR_COMPONENT_ADMIN_URL;?>widget_setting_type/icon-select/font-awesome.php?yee-name=<?php echo $element_param['param_name'];?>","newwindow","height=500,width=1200,top=" + (window.screen.availHeight-30-500)/2 +",left=" + (window.screen.availWidth-10-1100)/2 +",toolbar=no,menubar=no,scrollbars=yes, resizable=no,location=no, status=no") ;
		}
	}
	//select image callback return the file url
	if(!window.select_icon_callback){ 
		window.select_icon_callback = function(icon,name){  
			var name = name;
			$('#widgetModal input[name="' + name+'"]').val(icon);
			$('#widgetModal button[data-yee-name="' + name + '"]').html('&nbsp;<i class="'+icon+'"></i>&nbsp;');
		}
	}
	})(window.jQuery);
</script>