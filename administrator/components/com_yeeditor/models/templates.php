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

jimport('joomla.application.component.modellist');

class YeeditorModelTemplates extends JModelList
{
    public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'name',
				'create_date',
				'published'
			);
		}

		parent::__construct($config);
	}

	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as &$item) {
			$item->url = 'index.php?option=com_yeeditor&amp;task=template.edit&amp;id=' . $item->id;
		}

		return $items;
	}

	public function getListQuery()
	{
		$query = parent::getListQuery();

		$query->select('*');
		$query->from('#__yeeditor');
		
		$published = $this->state->get('filter.published');
		
		if ($published == '') {
			$query->where('(published = 1 OR published = 0 )');
		} else if ($published != '*') {
			$published = (int) $published;
			$query->where("published = '{$published}'");
		}
		
		$search = $this->state->get('filter.search');

		$db = $this->getDbo();

		if (!empty($search)) {
			$search = '%' . $db->escape($search, true) . '%';

			$field_searches =
				"(name LIKE '{$search}')";

			$query->where($field_searches);
		}
		
		// Column ordering
		$orderCol = $this->state->get('list.ordering')?$this->state->get('list.ordering'):'name';
		$orderDirn = $this->state->get('list.direction')?$this->state->get('list.direction'):'asc';

		if ($orderCol != '') {
			$query->order($db->escape($orderCol.' '.$orderDirn));
		}

		return $query;
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->state->get('filter.search', $search);
	
		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published');
		$this->state->get('filter.published', $published);

		parent::populateState($ordering, $direction);
	}
}