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


// No direct access
defined('_JEXEC') or die('Restricted access');
 
 
/**
 * Hello Table class
 */
class AjaxquizTableTemplate extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	 
	 
	 
	function __construct(&$_db) 
	{
		parent::__construct('#__ajaxquiz_template', 'id', $_db);
		
	}
	
	
	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param	array		Named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error
	 * @see		JTable:bind
	 * @since	1.5
	 */
	public function bind($array, $ignore = '')
	{
		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry;
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		return parent::bind($array, $ignore);
	}
	
	
	
	public function store($updateNulls = false)
	{

		if (empty($this->id))
		{
			// Store the row
			parent::store($updateNulls);
		}
		else
		{
			// Get the old row
			$oldrow = JTable::getInstance('Template', 'AjaxquizTable');
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}
		

			// Store the new row
			parent::store($updateNulls);

		}
		return count($this->getErrors()) == 0;
	}

}
