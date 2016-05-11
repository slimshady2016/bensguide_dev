<?php
/*------------------------------------------------------------------------
# yeeditor - YEEditor
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
$element_setting=$item_params['element_setting'];
$element_attribute=$item_params['element_attribute'];
	   
$content = htmlspecialchars($element_setting['css_code']);
if(strlen($content)>600){
	$content = substr($content,0,600)."...";
}		   
?>
<h5><?php echo $element_attribute['name'];?></h5>
<div style="color:slateblue;"><?php echo $content;?></div>