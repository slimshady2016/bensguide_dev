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

defined( '_JEXEC' ) or die;

class YeeditorModelTemplate extends JModelAdmin
{
	public function getTable($type = 'Template', $prefix = 'YeeditorTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
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
		$data = JFactory::getApplication()->getUserState('com_yeeditor.edit.template.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			if ($this->state->get('template.id') == 0)
			{
				$app = JFactory::getApplication();
				//$data->set('catid', JRequest::getInt('catid', $app->getUserState('com_banners.banners.filter.category_id')));
			}
		}

		return $data;
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_yeeditor.template', 'template', array('control' => 'jform', 'load_data' => $loadData));
		
		return $form;
	}
}
