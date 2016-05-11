<?php
/**
 * ReDJ Enterprise component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package ReDJ
 * @copyright Copyright 2009 - 2014
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 1.7.8
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once JPATH_COMPONENT.'/helpers/redj.php';

/**
 * HTML View class for the ReDJ Errors component
 *
 * @package ReDJ
 *
 */
class ReDJViewErrors extends JViewLegacy
{
  protected $enabled;
  protected $items;
  protected $pagination;
  protected $state;

  public function display($tpl = null)
  {
    if ($this->getLayout() !== 'modal')
    {
      ReDJHelper::addSubmenu('errors');
    }

    // Initialise variables
    $this->enabled = ReDJHelper::isEnabled();
    $this->items = $this->get('Items');
    $this->pagination = $this->get('Pagination');
    $this->state = $this->get('State');
    $this->filterForm = $this->get('FilterForm');
    $this->activeFilters = $this->get('ActiveFilters');

    // Check for errors
    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode("\n", $errors));
      return false;
    }

    // We don't need toolbar in the modal window
    if ($this->getLayout() !== 'modal') {
      $this->addToolbar();
      $this->sidebar = JHtmlSidebar::render();
    }

    parent::display($tpl);
  }

  /**
   * Add the page title and toolbar
   *
   */
  protected function addToolbar()
  {
    JToolBarHelper::title(JText::_('COM_REDJ_MANAGER'), 'redj.png');

    $canDo = ReDJHelper::getActions();

    if ($canDo->get('core.delete')) {
      JToolBarHelper::custom('errors.purge', 'trash.png', 'trash.png', JText::_('COM_REDJ_TOOLBAR_PURGE'), false, false);
      JToolBarHelper::custom('errors.clean', 'trash.png', 'trash.png', JText::_('COM_REDJ_TOOLBAR_CLEAN'), false, false);
      JToolBarHelper::deleteList('', 'errors.delete');
      JToolBarHelper::divider();
      JToolBarHelper::custom('errors.resetstats', 'chart', '', 'COM_REDJ_TOOLBAR_RESET_STATS', false);
    }

    if ($canDo->get('core.admin')) {
      JToolBarHelper::divider();
      JToolBarHelper::preferences('com_redj');
    }

  }

  /**
   * Returns an array of fields the table can be sorted by
   *
   * @return  array  Array containing the field name to sort by as the key and display text as value
   *
   */
  protected function getSortFields()
  {
    return array(
      'e.id' => JText::_('COM_REDJ_HEADING_ERRORS_ID'),
      'e.visited_url' => JText::_('COM_REDJ_HEADING_ERRORS_VISITED_URL'),
      'e.error_code' => JText::_('COM_REDJ_HEADING_ERRORS_ERROR_CODE'),
      'e.redirect_url' => JText::_('COM_REDJ_HEADING_ERRORS_REDIRECT_URL'),
      'e.hits' => JText::_('COM_REDJ_HEADING_ERRORS_HITS'),
      'e.last_visit' => JText::_('COM_REDJ_HEADING_ERRORS_LAST_VISIT'),
      'e.last_referer' => JText::_('COM_REDJ_HEADING_ERRORS_LAST_REFERER')
    );
  }

}
