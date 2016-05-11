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
<?php foreach($element_param['option-value'] as $key=>$value){?>
	<label class="yee-btn yee-btn-default<?php echo $setting_value==$key?' active':''?><?php echo isset($element_param['class'])?' '.$element_param['class']:'';?>">
		<input type="radio" class="yee-form-control" name="<?php echo $element_param['param_name'];?>" value="<?php echo $key;?>"<?php echo $setting_value==$key?' checked="checked"':''?>> <?php echo $value;?>
	</label>
<?php }?>
</div>