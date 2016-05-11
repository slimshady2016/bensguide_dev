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
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Ola View
 */
class AjaxquizViewCategories extends JViewLegacy
{



	protected $items;

	protected $pagination;

	protected $state;


	/**
	 * Ola view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
	

		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		AjaxquizHelper::addSubmenu('categories');

                $this->sidebar = JHtmlSidebar::render();
 
		// Set the toolbar
		$this->addToolBar();

		$this->sidebar = JHtmlSidebar::render();
 
		// Display the template
		parent::display($tpl);
 
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$canDo = AjaxquizHelper::getActions();
		JToolBarHelper::title(JText::_('COM_AJAXQUIZ_CATEGORY'), 'ajaxquiz');
		if ($canDo->get('core.create')) 
		{
			JToolBarHelper::addNew('category.add', 'JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) 
		{
			JToolBarHelper::editList('category.edit', 'JTOOLBAR_EDIT');
		}
	
		if ($canDo->get('core.edit.state'))
                {
                        if ($this->state->get('filter.state') != 2)
                        {
                                JToolbarHelper::publish('categories.publish', 'JTOOLBAR_PUBLISH', true);
                                JToolbarHelper::unpublish('categories.unpublish', 'JTOOLBAR_UNPUBLISH', true);
                        }

                        if ($this->state->get('filter.state') != -1)
                        {
                                if ($this->state->get('filter.state') != 2)
                                {
                                        JToolbarHelper::archiveList('categories.archive');
                                }
                                elseif ($this->state->get('filter.state') == 2)
                                {
                                        JToolbarHelper::unarchiveList('categories.publish');
                                }
                        }
                }

                if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
                {
                        JToolbarHelper::deleteList('', 'categories.delete', 'JTOOLBAR_EMPTY_TRASH');
                }
                elseif ($canDo->get('core.edit.state'))
                {
                        JToolbarHelper::trash('categories.trash');
                }

	
		
		if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_ajaxquiz');
		}

		JHtmlSidebar::setAction('index.php?option=com_ajaxquiz&view=categories');

                JHtmlSidebar::addFilter(
                        JText::_('JOPTION_SELECT_PUBLISHED'),
                        'filter_state',
                        JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
                );

	}
	
	protected function getSortFields()
	{
		return array(
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),			
			'a.title' => JText::_('Title'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
