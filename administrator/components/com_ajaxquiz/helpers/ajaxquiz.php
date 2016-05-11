<?php
/*------------------------------------------------------------------------
# component_Ajax_quiz - Ajax Quiz 
# ------------------------------------------------------------------------
# author    WebKul
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.webkul.com
# Technical Support:  Forum - http://www.webkul.com/index.php?Itemid=86&option=com_kunena
-----------------------------------------------------------------------*/

defined('_JEXEC') or die;

/**
 * Banners component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       1.6
 */
class AjaxquizHelper
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

		JHtmlSidebar::addEntry(
			JText::_('COM_AJAXQUIZ_SUBMENU_CATEGORIES'),
			'index.php?option=com_ajaxquiz&view=categories',
			$vName == 'categories'
		);

		JHtmlSidebar::addEntry(
                        JText::_('COM_AJAXQUIZ_SUBMENU_QUESTIONS'),
                        'index.php?option=com_ajaxquiz&view=questions',
                        $vName == 'questions'
                );

		JHtmlSidebar::addEntry(
			JText::_('COM_AJAXQUIZ_SUBMENU_ANSWERS'),
			'index.php?option=com_ajaxquiz&view=answers',
			$vName == 'answers'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_AJAXQUIZ_SUBMENU_RESULTS'),
			'index.php?option=com_ajaxquiz&view=result',
			$vName == 'result'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_AJAXQUIZ_IMPORT'),
			'index.php?option=com_ajaxquiz&view=import',
			$vName == 'import'
		);
				
		
		
		JHtmlSidebar::addEntry(
			JText::_('COM_AJAXQUIZ_FBFANPAGE'),
			'index.php?option=com_ajaxquiz&view=fbfanpage',
			$vName == 'fbfanpage'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_AJAXQUIZ_SUBMENU_TEMPLATES'),
			'index.php?option=com_ajaxquiz&view=templates',
			$vName == 'templates'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_AJAXQUIZ_BACKUP'),
			'index.php?option=com_ajaxquiz&view=backup',
			$vName == 'backup'
		);
		
		

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_ajaxquiz';
			$level = 'component';
		} else {
			$assetName = 'com_ajaxquiz.category.'.(int) $categoryId;
			$level = 'category';
		}

		$actions = JAccess::getActions('com_ajaxquiz', $level);
	
		foreach ($actions as $action) {
			 $result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}


	public static function getCategoryOptions()
	{
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('id As value, title As text');
		$query->from('#__ajaxquiz_category AS a');
		$query->order('a.title');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		// Merge any additional options in the XML definition.
		//$options = array_merge(parent::getOptions(), $options);


		return $options;
	}
}
