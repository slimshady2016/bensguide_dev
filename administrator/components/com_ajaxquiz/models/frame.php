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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

 
class AjaxquizModelFrame extends JModelList
{
	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'cid', 'a.cid', 'client_name',
				'name', 'a.name',
				'alias', 'a.alias',
				'state', 'a.state',
				'ordering', 'a.ordering',
				'language', 'a.language',
				'catid', 'a.catid', 'category_title',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
			);
		}

		parent::__construct($config);
	}


	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$id = JRequest::getVar('id');

		// Select the required fields from the table.
		$query = 'SELECT a.* '
				.'FROM #__ajaxquiz_result AS a WHERE id = '.$id;
				
		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}



	

}
