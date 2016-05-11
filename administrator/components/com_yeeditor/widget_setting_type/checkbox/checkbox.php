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
?>
<div data-yee-toggle="buttons" class="yee-btn-group">
<label class="yee-btn yee-btn-default<?php echo $setting_value?' active':'';?><?php echo isset($element_param['class'])?' '.$element_param['class']:'';?>">
<input type="checkbox" name="<?php echo $element_param['param_name'];?>"<?php echo $setting_value?' checked="checked"':'';?> value="<?php echo $element_param['option-value']['value'];?>" /><?php echo $element_param['option-value']['title'];?>
</label>
</div>