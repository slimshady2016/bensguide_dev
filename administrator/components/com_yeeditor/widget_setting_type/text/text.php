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

//You can find the setting and value in the '$element_setting' varible. 

$type_attrbute="";

if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];
	
$setting_value = $element_setting[$element_param['param_name']];	
?>
<input class="yee-form-control" type="text"<?php echo isset($element_param['placeholder'])?' placeholder="'.$element_param['placeholder'].'"':'';?> name="<?php echo $element_param['param_name'];?>" value="<?php echo $setting_value;?>" <?php echo $type_attrbute;?>/>
