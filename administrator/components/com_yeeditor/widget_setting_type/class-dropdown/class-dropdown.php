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
?>
<select class="yee-form-control" name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?>>
<?php if(is_array($element_param['option-value']) && $element_param['option-value']){ ?>
	<?php foreach($element_param['option-value'] as $key=>$value){?>
			 <option class="<?php echo $key;?>" value="<?php echo $key;?>" <?php echo ($setting_value==$key?'selected="selected"':'');?>><?php echo $value;?></option>
	<?php }?>
<?php }?>
</select>

