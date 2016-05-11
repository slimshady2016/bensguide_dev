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

$type_attrbute="";
$output="";
defined('_JEXEC') or die;
if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];

$setting_value = $element_setting[$element_param['param_name']];

$value_arr=(array)json_decode(base64_decode($setting_value));
$columns=count($value_arr);
	
?>
<div class="yee-row" <?php echo (isset($element_param['display'])?($element_param['display']=="none"?'style="display:none;"':''):'');?>>
	<div class="yee-setting-heading"><strong><?php echo $element_param['heading'];?></strong></div>
	<div class="yee-setting-value">
	<?php if(is_array($value_arr)){?>
		<?php foreach($value_arr as $key=>$value){?>
		<div class="col-xs-<?php echo ceil(12/$columns)?>">
			<div><?php echo $key;?></div>
			<div>
				<input class="yee_input_group_item" data-yee-h="<?php echo $element_param['param_name'];?>" style="width:98%" type="text" name="<?php echo $key;?>" value="<?php echo $value!=""?$value:'';?>" <?php echo in_array($key,$element_param['readonly'])?'readonly="readonly"':''?> />
			</div>
		</div>
		<?php }?>
	<?php }?>
	</div>
	<input class="yee_input_group" style="width:98%" type="hidden" name="<?php echo $element_param['param_name'];?>" value="<?php echo $setting_value;?>"/>
	<div class="yee-setting-description"><?php echo $element_param['description'];?></div>
</div>	
