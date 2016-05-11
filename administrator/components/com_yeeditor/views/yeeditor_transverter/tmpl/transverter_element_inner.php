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

$ajax_return="";
$ajax_return=display_element_inner_backend($_POST['element_key'],$_POST['element_shortcode']);

echo json_encode($ajax_return);

function display_element_inner_backend($element_key,$element_shortcode){
    $element_inner_html="";
	
	$element_inner_html=get_items_html($element_key,$element_shortcode);
	
	return isset($element_inner_html[0])?$element_inner_html[0]:"";
}
