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

<textarea class="yee-CodeMirror" code-mirror-type="<?php echo $element_param['inner_type']?>" name="<?php echo $element_param['param_name']?>" style="width:98%; min-height:60px;" <?php echo $type_attrbute;?>><?php echo $setting_value;?></textarea>

				