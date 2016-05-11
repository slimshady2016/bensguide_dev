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

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');


class AjaxquizViewImport extends JViewLegacy {  

    function display($tpl = null) {	
   		global $mainframe, $option;        
		$db		=& JFactory::getDBO();
		$uri	=& JFactory::getURI();
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		AjaxquizHelper::addSubmenu('import');
                $this->sidebar = JHtmlSidebar::render();
 
		// Set the toolbar
		$this->addToolBar();
		$this->sidebar = JHtmlSidebar::render();
		
                //JToolBarHelper::title(JText::_('Import CSV'), 'generic.png');	
        	parent::display($tpl);

		
    }
	
	protected function addToolBar() 
	{
		$canDo = AjaxquizHelper::getActions();
		JToolBarHelper::title(JText::_('COM_AJAXQUIZ_CSV'), 'ajaxquiz');
		
             
       JToolbarHelper::trash('result.remove');
               
	
		
		if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_ajaxquiz');
		}
		JHtmlSidebar::setAction('index.php?option=com_ajaxquiz&view=import');
      
	}
	
	protected function getSortFields()
	{
		return array(
			'ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.state' => JText::_('JSTATUS'),
			'a.score' => JText::_('Score'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
?>
