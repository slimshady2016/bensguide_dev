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

JLoader::register('AjaxquizHelper', JPATH_COMPONENT.'/helpers/ajaxquiz.php');
/**
 * HTML View class for the Categories component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 * @since       1.6
 */

 
class AjaxquizViewQuestion extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');


		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId = $user->id;
		$isNew = $this->item->id == 0;
		$checkedOut     = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		// Since we don't track these assets at the item level, use the category id.
		$canDo = AjaxquizHelper::getActions();

		JToolBarHelper::title($isNew ? JText::_('COM_AJAXQUIZ_NEW') : JText::_('COM_AJAXQUIZ_EDIT'), 'ajaxquiz');

		// If not checked out, can save the item.
                if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_questions', 'core.create')) > 0)) {
                        JToolbarHelper::apply('question.apply');
                        JToolbarHelper::save('question.save');

                        if ($canDo->get('core.create')) {
                                JToolbarHelper::save2new('question.save2new');
                        }
                }

                // If an existing item, can save to a copy.
                if (!$isNew && $canDo->get('core.create')) {
                        JToolbarHelper::save2copy('question.save2copy');
                }

                if (empty($this->item->id))  {
                        JToolbarHelper::cancel('question.cancel');
                }
                else {
                        JToolbarHelper::cancel('question.cancel', 'JTOOLBAR_CLOSE');
                }

                JToolbarHelper::divider();
                JToolbarHelper::help('JHELP_COMPONENTS_AJAXQUIZ_QUESTIONS_EDIT');



	}
	
	
	
}
