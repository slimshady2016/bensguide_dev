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
if(JRequest::getVar('action','')=='CKEditor'){
	include JPATH_ROOT.'/plugins/editors/yeeditor/assets/js/ckeditor/elfinder/elfinder.php';
}
else{
	if(JRequest::getVar('data',0)==1){
		include JPATH_ROOT.'/plugins/editors/yeeditor/assets/js/ckeditor/elfinder/php/connector.php';
	}
	else{
		include JPATH_ROOT.'/plugins/editors/yeeditor/assets/js/ckeditor/elfinder/elfinder_select_image.php';
	}
}

