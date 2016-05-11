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
class AjaxquizModelTemplates extends JModelList
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
				//'state', 'a.state',
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

		// Select the required fields from the table.
		// $query = 'SELECT a.* '
				// .'FROM #__ajaxquiz_template AS a';
		$query->select(
			$this->getState(
			'list.select',
				'a.*'
				
			)
		);
		$query->from('#__ajaxquiz_template AS a');
					
				
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'title:') === 0) {
				$query->where('a.title = '.(int) substr($search, 3));
			}
			
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.title LIKE '.$search.')');
			}
		}
		// Filter by category.
                $categoryId = $this->getState('filter.category_id');
                if (is_numeric($categoryId)) {
                        $query->where('a.catid = '.(int) $categoryId);
                }
				 $orderCol       = $this->state->get('list.ordering', 'a.title');
                $orderDirn      = $this->state->get('list.direction', 'asc');
               
           $query->order($db->escape($orderCol.' '.$orderDirn));
				//echo $query;
		//echo nl2br(str_replace('#__','jos_',$query));
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
	public function getTable($type = 'Template', $prefix = 'AjaxquizTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function delete($cid) {

		if (count( $cid ))
                {
                        $cids = implode( ',', $cid );
                        $query = 'DELETE FROM #__ajaxquiz_template'
                                        . ' WHERE id IN ('. $cids .')';
                        $this->_db->setQuery( $query );
                        if(!$this->_db->query()) {
                                $this->setError($this->_db->getErrorMsg());
                                return false;
                        }
                }
                if (count( $err )) {
                        $cids   = implode( ', ', $err );
                $msg    = JText::sprintf( 'ANSWER ASSIGNED QUESTION', $cids );
                return $msg;
                } else {
                        $total  = count( $cid );
                        $msg    = $total.' '.JText::_('CATEGORY DELETED');
                        return $msg;
                }   

	}
	
	protected function populateState($ordering = null, $direction = null)
        {
                $app = JFactory::getApplication('administrator');

                // Load the filter state.
                $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
                $this->setState('filter.search', $search);

                // $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
                // $this->setState('filter.state', $state);

                $categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', '');
                $this->setState('filter.category_id', $categoryId);

                $language = $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
                $this->setState('filter.language', $language);

                // Load the parameters.
                $params = JComponentHelper::getParams('com_ajaxquiz');
                $this->setState('params', $params);

                // List state information.
                parent::populateState('a.title', 'asc');
        }

	

}
