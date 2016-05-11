<?php  
/*------------------------------------------------------------------------
# YEEditor - independent
# ------------------------------------------------------------------------
# author    YEEDEEN
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
//joomla load language
function yee_load_language($extension="plg_editors_yeeditor",$base_dir=JPATH_ADMINISTRATOR){
	$language =& JFactory::getLanguage();
	$extension = $extension;
	$language_tag = $language->getTag(); // loads the current language-tag
	$language->load($extension, $base_dir, $language_tag, true);
}

//Get yeeditor option
function get_yeeditor_option($key){
	$db = JFactory::getDbo();

	$db->setQuery(
		'SELECT option_value from #__yeeditor_option' .
		' WHERE option_name="'.$key.'"'
	);
	if (!$result = $db->query()) {
		echo $db->stderr();
		return false;
	}
	$result=$db->loadObjectList(); 
	if(isset($result[0])){
		return $result[0]->option_value;
	}else{
		return false;
	}	
}