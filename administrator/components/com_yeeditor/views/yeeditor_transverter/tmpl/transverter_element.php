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
if($_POST['action']=="yee_get_row_element_backend_html" ){
    $ajax_return = get_backend_row_html($_POST['element_shortcode']);
}
else{
	$ajax_return = get_element_backend($_POST['element_key'],$_POST['element_shortcode']);
}

echo $ajax_return;
