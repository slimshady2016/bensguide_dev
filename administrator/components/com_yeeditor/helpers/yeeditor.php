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

defined('_JEXEC') or die;

class YeeditorHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
			JSubMenuHelper::addEntry(
				JText::_('COM_YEEDITOR_FIELD_YEEDITOR'),
				'index.php?option=com_yeeditor&view=yeeditor',
				$vName == 'yeeditor'
			);
			
			JSubMenuHelper::addEntry(
				JText::_('COM_YEEDITOR_FIELD_OPTION'),
				'index.php?option=com_yeeditor&view=option',
				$vName == 'option'
			);
			
			JSubMenuHelper::addEntry(
				JText::_('COM_YEEDITOR_FIELD_THEME'),
				'index.php?option=com_yeeditor&view=theme',
				$vName == 'theme'
			);
			
			JSubMenuHelper::addEntry(
				JText::_('COM_YEEDITOR_FIELD_TEMPLATES'),
				'index.php?option=com_yeeditor&view=templates',
				$vName == 'templates'
			);
	
			JSubMenuHelper::addEntry(
				JText::_('COM_YEEDITOR_FIELD_INSTALL'),
				'index.php?option=com_yeeditor&view=install',
				$vName == 'install'
			);
			
			JSubMenuHelper::addEntry(
				JText::_('COM_YEEDITOR_FIELD_EXTENSIONS'),
				'index.php?option=com_yeeditor&view=extensions',
				$vName == 'extensions'
			);
	}
	
/*	public static function get_widget_extensions($published=1){
		$database = JFactory::getDbo();
		$sqlquery="";
		$sqlquery = "select * from #__yeeditor_extensions where published='".$published."'";
		$database->setQuery( $sqlquery );
		if (!$result = $database->query()) {
			echo $database->stderr();
			return false;
		}
		$result=$database->loadObjectList();
		return $result;
	}*/
}
