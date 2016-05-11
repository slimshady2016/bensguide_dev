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
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * Ola Form Field class for the Ola component
 */
class JFormFieldQuestions extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Questions';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
/*		$query = new JDatabaseQuery;
		$query = $db->getQuery(true);
		$query->select('#__ola.id as id,bemvindo,#__categories.title as category,catid');
		$query->from('#__ola');
		$query->leftJoin('#__categories on catid=#__categories.id');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		$options = array();
		if ($messages)
		{
			foreach($messages as $message) 
			{
				$options[] = JHtml::_('select.option', $message->id, $message->bemvindo . ($message->catid ? ' (' . $message->category . ')' : ''));
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options; */
	}
}
