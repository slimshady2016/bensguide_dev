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
 

 
class AjaxquizModelCategories extends JModelList
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
				'title', 'a.title',
				'alias', 'a.alias',
				'state', 'a.published',
				'ordering', 'a.ordering',
				'language', 'a.language',
				'catid', 'a.catid', 'category_title',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'created', 'a.created',
				'impmade', 'a.impmade',
				'imptotal', 'a.imptotal',
				'clicks', 'a.clicks',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'state', 'sticky', 'a.sticky',
			);
		}

		parent::__construct($config);
	}
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.extension');
		$id	.= ':'.$this->getState('filter.published');
		$id	.= ':'.$this->getState('filter.language');

		return parent::getStoreId($id);
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
		$user	= JFactory::getUser();

		// Select the required fields from the table.
		$query->select(
			$this->getState(
			'list.select',
				'a.*'
				
			)
		);
		$query->from('#__ajaxquiz_category AS a');
	
		
		
		// $db		= $this->getDbo();
		// $query	= $db->getQuery(true);

		// Select the required fields from the table.
		// $query = 'SELECT a.* '
				// .'FROM #__ajaxquiz_category AS a';
				
		//echo nl2br(str_replace('#__','jos_',$query));
		
		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}

		// Filter by search in cat_name
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.title LIKE '.$search.')');
			}
		}

		// Filter on the language.
		
		// Add the list ordering clause.
                $orderCol       = $this->state->get('list.ordering', 'a.title');
                $orderDirn      = $this->state->get('list.direction', 'asc');
                if ($orderCol == 'a.ordering' || $orderCol == 'a.id') {
                        $orderCol = 'a.title '.$orderDirn.', a.ordering';
                }
           $query->order($db->escape($orderCol.' '.$orderDirn));
		

		//Add the list ordering clause
		// $listOrdering = $this->getState('list.ordering', 'a.lft');
		// $listDirn = $db->escape($this->getState('list.direction', 'ASC'));
		// if ($listOrdering == 'a.access') {
			// $query->order('a.access '.$listDirn.', a.lft '.$listDirn);
		// } else {
			// $query->order($db->escape($listOrdering).' '.$listDirn);
		// }
		//echo $query;
		

		//echo nl2br(str_replace('#__','jos_',$query));
		//echo $query;
		
		return $query;
	}



	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Categories', $prefix = 'AjaxquizTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	protected function populateState($ordering = null, $direction = null)
        {
                $app = JFactory::getApplication('administrator');

                // Load the filter state.
                $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
                $this->setState('filter.search', $search);

                $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
                $this->setState('filter.state', $state);


                $language = $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
                $this->setState('filter.language', $language);

                // Load the parameters.
                $params = JComponentHelper::getParams('com_ajaxquiz');
                $this->setState('params', $params);

                // List state information.
                parent::populateState('a.title', 'asc');
        }

	

}
