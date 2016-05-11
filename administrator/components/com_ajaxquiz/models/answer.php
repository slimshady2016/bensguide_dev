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


 jimport('joomla.application.component.modeladmin');
 
class AjaxquizModelAnswer extends JModelAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_AJAXQUIZ_ANSWER';
	
	
	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 *
	 * @since	1.6
	 */
	protected function canDelete($record)
	{
	

		if (!empty($record->id))
		{
			if ($record->published != -2)
			{
				return;
			}
			$user = JFactory::getUser();

			return $user->authorise('core.delete', $record->extension . '.answer.' . (int) $record->id);
		}
	}

	/**
	 * Method to test whether a record can have its state changed.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();
	

		// Check for existing category.
		if (!empty($record->id))
		{
			return $user->authorise('core.edit.state', 'com_ajaxquiz.answer.' . (int) $record->id);
		}
		// New category, so check against the parent.
		elseif (!empty($record->parent_id))
		{
			return $user->authorise('core.edit.state', 'com_ajaxquiz.answer.' . (int) $record->parent_id);
		}
		// Default to component settings if neither category nor parent known.
		else
		{
			return $user->authorise('core.edit.state', 'com_ajaxquiz');
		}
	}

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	*/
	public function getTable($type = 'Answer', $prefix = 'AjaxquizTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	

	

	/**
	 * Method to get the row form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
	
		// Get the form.
		$form = $this->loadForm('com_ajaxquiz.answer','answer', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		
		return $form;
	}

	

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_ajaxquiz.edit.answer.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	


}
