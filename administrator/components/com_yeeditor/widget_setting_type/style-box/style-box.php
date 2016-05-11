<?php 
/*------------------------------------------------------------------------
# YETemplate
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;

//You can find the setting and value in the '$element_setting' varible. 

$type_attrbute="";

if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];
	
$setting_value = $element_setting[$element_param['param_name']];
$style_box = array(
	"margin-top" => "",
	"margin-right" => "",
	"margin-bottom" => "",
	"margin-left" => "",
	"margin-linked" => false,
	
	"border-top" => "",
	"border-right" => "",
	"border-bottom" => "",
	"border-left" => "",
	"border-linked" => false,
	
	"padding-top" => "",
	"padding-right" => "",
	"padding-bottom" => "",
	"padding-left" => "",
	"padding-linked" => false
);
if($setting_value){	
	$style_box = json_decode(base64_decode($setting_value),true);
}
?>
<input class="yee_style_box" type="hidden" name="<?php echo $element_param['param_name'];?>" value="<?php echo $setting_value;?>"/>
<div class="style-box">
	<div class="ye-margin">
		<label>margin</label>
		<input type="text" name="margin-top" data-yee-name="margin-top" class="ye-top" placeholder="-" data-yee-attribute="margin" value="<?php echo $style_box['margin-top'];?>">
		<input type="text" name="margin-right" data-yee-name="margin-right" class="ye-right" placeholder="-" data-yee-attribute="margin" value="<?php echo $style_box['margin-linked']==true?$style_box['margin-top']:$style_box['margin-right'];?>"<?php echo $style_box['margin-linked']==true?' readonly="readonly"':'';?>>
		<input type="text" name="margin-bottom" data-yee-name="margin-bottom" class="ye-bottom" placeholder="-" data-yee-attribute="margin" value="<?php echo $style_box['margin-linked']==true?$style_box['margin-top']:$style_box['margin-bottom'];?>"<?php echo $style_box['margin-linked']==true?' readonly="readonly"':'';?>>
		<input type="text" name="margin-left" data-yee-name="margin-left" class="ye-left" placeholder="-" data-yee-attribute="margin" value="<?php echo $style_box['margin-linked']==true?$style_box['margin-top']:$style_box['margin-left'];?>"<?php echo $style_box['margin-linked']==true?' readonly="readonly"':'';?>>
		<input type="checkbox" class="yee-checkbox" name="margin-linked" value="margin"<?php echo $style_box['margin-linked']==true?' checked="checked"':'';?>><span class="ye-linked">linked</span>
		<div class="ye-border">
			<label>border</label>
			<input type="text" name="border-top" data-yee-name="border-top" class="ye-top" placeholder="-" data-yee-attribute="border" value="<?php echo $style_box['border-top'];?>">
			<input type="text" name="border-right" data-yee-name="border-right" class="ye-right" placeholder="-" data-yee-attribute="border" value="<?php echo $style_box['border-linked']==true?$style_box['border-top']:$style_box['border-right'];?>"<?php echo $style_box['border-linked']==true?' readonly="readonly"':'';?>>
			<input type="text" name="border-bottom" data-yee-name="border-bottom" class="ye-bottom" placeholder="-" data-yee-attribute="border" value="<?php echo $style_box['border-linked']==true?$style_box['border-top']:$style_box['border-bottom'];?>"<?php echo $style_box['border-linked']==true?' readonly="readonly"':'';?>>
			<input type="text" name="border-left" data-yee-name="border-left" class="ye-left" placeholder="-" data-yee-attribute="border" value="<?php echo $style_box['border-linked']==true?$style_box['border-top']:$style_box['border-left'];?>"<?php echo $style_box['border-linked']==true?' readonly="readonly"':'';?>>
			<input type="checkbox" class="yee-checkbox" name="border-linked" value="border"<?php echo $style_box['border-linked']==true?' checked="checked"':'';?>><span class="ye-linked">linked</span>
			<div class="ye-padding">
				<label>padding</label>
				<input type="text" name="padding-top" data-yee-name="padding-top" class="ye-top" placeholder="-" data-yee-attribute="padding" value="<?php echo $style_box['padding-top'];?>">
				<input type="text" name="padding-right" data-yee-name="padding-right" class="ye-right" placeholder="-" data-yee-attribute="padding" value="<?php echo $style_box['padding-linked']==true?$style_box['padding-top']:$style_box['padding-right'];?>"<?php echo $style_box['padding-linked']==true?' readonly="readonly"':'';?>>
				<input type="text" name="padding-bottom" data-yee-name="padding-bottom" class="ye-bottom" placeholder="-" data-yee-attribute="padding" value="<?php echo $style_box['padding-linked']==true?$style_box['padding-top']:$style_box['padding-bottom'];?>"<?php echo $style_box['padding-linked']==true?' readonly="readonly"':'';?>>
				<input type="text" name="padding-left" data-yee-name="padding-left" class="ye-left" placeholder="-" data-yee-attribute="padding" value="<?php echo $style_box['padding-linked']==true?$style_box['padding-top']:$style_box['padding-left'];?>"<?php echo $style_box['padding-linked']==true?' readonly="readonly"':'';?>>
				<input type="checkbox" class="yee-checkbox" name="padding-linked" value="padding"<?php echo $style_box['padding-linked']==true?' checked="checked"':'';?>><span class="ye-linked">linked</span>
				<div class="ye-content"><i></i>
				</div>
			</div>
		</div>    
	</div>
</div>
<script type="text/javascript">
!function($){
	$(function(){
		$('.style-box input').change(function(){
			if($(this).attr("type") == "checkbox"){
				var attribute_name = $(this).val();
				if($(this).is(':checked')){
					$('.style-box input[data-yee-attribute="' + attribute_name + '"]').val($('.style-box input[data-yee-name="' + attribute_name + '-top"]').val());
					$('.style-box input[data-yee-attribute="' + attribute_name + '"]').attr("readonly","readonly");
					$('.style-box input[data-yee-name="' + attribute_name + '-top"]').removeAttr("readonly");
				}
				else{
					$('.style-box input[data-yee-attribute="' + attribute_name + '"]').removeAttr("readonly");
				}
			}
			else{
				var attribute_name = $(this).attr("data-yee-attribute");
				if($('.style-box input[name="' + attribute_name + '_linked"]').is(':checked')){
					$('.style-box input[data-yee-attribute="' + attribute_name + '"]').val($('.style-box input[data-yee-name="' + attribute_name + '-top"]').val());
				}
			}
		
			var style_box = {};
			$('.style-box').find('input').each(function(i, obj){
				if($(obj).attr("type") == "text"){
					style_box[$(obj).attr("name")] = $(obj).val();
				}
				else if($(obj).attr("type") == "checkbox"){
					if($(obj).is(':checked')){
						style_box[$(obj).attr("name")] = true;
					}
					else{
						style_box[$(obj).attr("name")] = false;
					}
				}
			});
			$(".yee_style_box").val(base64.encode(JSON.encode(style_box)));
		});
		
	});
}(window.jQuery);
</script>









