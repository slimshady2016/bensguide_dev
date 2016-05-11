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

jimport( 'joomla.application.component.view');

class YeeditorViewTemplate extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	public function display($tpl = null)
	{
		$this->form		= $this->get('Form'); 
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		
		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		$isNew		= ($this->item->id == 0);
		
		JToolBarHelper::title($isNew ? JText::_('COM_YEEDITOR_ADD_TEMPLATE_TITLE') : JText::_('COM_YEEDITOR_EDIT_TEMPLATE_TITLE'), 'banners.png');
		
		JToolBarHelper::apply('template.apply');
		JToolBarHelper::save('template.save');
		JToolBarHelper::save2copy('template.save2copy');
		JToolBarHelper::cancel('template.cancel');
	}
}