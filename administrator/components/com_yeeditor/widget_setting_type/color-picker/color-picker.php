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

//You can find the setting and value in the '$element_param' varible. 

$type_attrbute="";
$output="";

if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];
	
$setting_value = $element_setting[$element_param['param_name']];	

//hex,rgb,rgba
$color_format = isset($element_param['format'])?' data-format="'.($element_param['format']?$element_param['format']:'rgba').'"':'data-format="rgba"';	
?>
<div class="yee-input-group yee-col-xs-6" data-yee-type="color-picker"<?php echo $color_format;?>>
	<input type="text" class="yee-form-control"<?php echo isset($element_param['placeholder'])?' placeholder="'.$element_param['placeholder'].'"':'';?> name="<?php echo $element_param['param_name'];?>" value="<?php echo $setting_value;?>" <?php echo $type_attrbute;?> yet-attr="text-decoration"/>
	<span class="yee-input-group-addon"><i></i></span>
</div>

