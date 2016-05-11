<?php 
/*------------------------------------------------------------------------
# com_yeeditor - YEEditor
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.html.editor');
$document =JFactory::getDocument();
$root=JURI::root();
$document->addScript($root.'plugins/editors/yeeditor/assets/js/jquery-1.9.1.min.js');
// Add styles
$style = '.mceEditor .mceButton.mce_readmore{display:none;}'; 
$document->addStyleDeclaration($style);

$input_name = JRequest::getVar('input_name','');
$content = JRequest::getVar('content','','POST','STRING',JREQUEST_ALLOWHTML);

$editor=new JEditor("jce");
echo $editor->display($input_name,$content,"100%","300px",100,5,array("readmore"));

