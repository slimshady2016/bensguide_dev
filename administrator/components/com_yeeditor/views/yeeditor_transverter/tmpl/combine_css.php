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

if($_POST['action']=="combine_css"){
	$widget_ex_fpath=JPATH_ROOT."/components/com_yeeditor/widgets_ex/";
	$widget_css_path=JPATH_ROOT."/plugins/editors/yeeditor/assets/css/widgets.css";
	
	jimport('joomla.filesystem.folder');
	$folders=JFolder::folders($widget_ex_fpath);
	
	$css_content = "";

	foreach($folders as $folder){
		$styles = JFolder::folders($widget_ex_fpath.$folder."/frontend/");
		foreach($styles as $style){
			$css_path = $widget_ex_fpath.$folder."/frontend/".$style."/assets/css/".$folder.".css";
			if(is_file($css_path)){
				ob_start();
				header('Content-type: text/css');
				//$css_content .= "\n\n/*=== ".$folder." - ".$style." ===*/"."\n";
				include($css_path);
				$temp_content = compress(ob_get_contents());
				$temp_content = str_replace("../images/", "../../../../../components/com_yeeditor/widgets_ex/".$folder."/frontend/".$style."/assets/images/", $temp_content);
				$css_content .= $temp_content;
				ob_end_clean();
			}
		}
	}
	
	jimport('joomla.filesystem.file');
	JFile::write($widget_css_path,$css_content);
	//file_put_contents($widget_css_path,$css_content);
}
else if($_POST['action']=="update_widget_margin_bottom"){
	$docs_css_path=JPATH_ROOT."/plugins/editors/yeeditor/assets/css/yee-docs-frontend.css";
	$margin_bottom=$_POST['margin_bottom'];
	$replace_str='/* widget margin bottom */'."\n".'div.yee .widget{margin-bottom:'.$margin_bottom.';}';
	$css_content=file_get_contents($docs_css_path);
	$css_new_content=preg_replace('/\/\* widget margin bottom \*\/[\s\S]*?div.yee .widget{margin-bottom:.*?;}/',$replace_str,$css_content);
	file_put_contents($docs_css_path,$css_new_content);
}
