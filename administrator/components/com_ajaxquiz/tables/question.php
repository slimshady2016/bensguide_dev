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
 
// import Joomla table library
//jimport('joomla.database.table');
 
/**
 * Hello Table class
 */
class AjaxquizTableQuestion extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	 
	 var $id = null;
	 
	 var $cid = null;
	 
	 var $title = null;
	 
	 var $description = null;
	 
	 var $published = null;
	 
	 var $checked_out = null;
	 
	  var $checked_out_time = null;
	  
	  var $ordering = null;
	  
	  var $access = null;
	 
	 
	function __construct(&$_db) 
	{
		parent::__construct('#__ajaxquiz_question', 'id', $_db);
		
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
			$oldrow = JTable::getInstance('Question', 'AjaxquizTable');
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}


			// Store the new row
			parent::store($updateNulls);

		}
		return count($this->getErrors()) == 0;
	}


	 /**
         * Method to set the publishing state for a row or list of rows in the database
         * table.  The method respects checked out rows by other users and will attempt
         * to checkin rows that it can after adjustments are made.
         *
         * @param       mixed   An optional array of primary key values to update.  If not
         *                                      set the instance property value is used.
         * @param       integer The publishing state. eg. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
         * @param       integer The user id of the user performing the operation.
         * @return      boolean True on success.
         * @since       1.6
         */
        public function publish($pks = null, $state = 1, $userId = 0)
        {
		$k = $this->_tbl_key;

                // Sanitize input.
                JArrayHelper::toInteger($pks);
                $userId = (int) $userId;
                $state  = (int) $state;

                // If there are no primary keys set check to see if the instance key is set.
                if (empty($pks))
                {
                        if ($this->$k) {
                                $pks = array($this->$k);
                        }
                        // Nothing to set publishing state on, return false.
                        else {
                                $this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
                                return false;
                        }
                }

                // Get an instance of the table
                $table = JTable::getInstance('Question', 'AjaxquizTable');
		
		// For all keys
                foreach ($pks as $pk)
                {
                        // Load the banner
                        if(!$table->load($pk))
                        {
                                $this->setError($table->getError());
                        }

                        // Verify checkout
                        if ($table->checked_out == 0 || $table->checked_out == $userId)
                        {
                                // Change the state
                                $table->published = $state;
                                $table->checked_out = 0;
                                $table->checked_out_time = $this->_db->getNullDate();

                                // Check the row
                                $table->check();

                                // Store the row
                                if (!$table->store())
                                {
                                        $this->setError($table->getError());
                                }
                        }
                }
                return count($this->getErrors()) == 0;


	}



}
