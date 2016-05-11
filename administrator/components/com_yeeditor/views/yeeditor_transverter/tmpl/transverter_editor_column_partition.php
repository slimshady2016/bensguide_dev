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

$ajax_return=displayYeeditor_row_or_innerrow($_POST['element_key'],$_POST['element_shortcode']);
echo $ajax_return;

function displayYeeditor_row_or_innerrow($type,$content){
	$return="";
	if($type=="yee_row"){
		$return = get_backend_row_html($content);
	}
	else if($type=="yee_row_inner"){
		$row_inner_html = get_backend_inner_row_html($content);
	
		$return = str_replace($content,$row_inner_html,$content);
	}

	return $return;
}


