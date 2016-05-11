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

<textarea name="yee_setting_<?php echo $element_param['param_name'];?>" style="width:100%" <?php echo $type_attrbute;?>><?php echo $setting_value;?></textarea>

<script type="text/javascript">
	CKEDITOR.replace( "yee_setting_<?php echo $element_param['param_name'];?>", {
		 filebrowserBrowseUrl : yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&action=CKEditor",
		 language: "en"
	});
	
</script>