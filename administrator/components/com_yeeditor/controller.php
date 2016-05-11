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

jimport('joomla.application.component.controller');

class YeeditorController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = false)
	{
        require_once JPATH_COMPONENT.'/helpers/yeeditor.php';
		// Load the submenu.
		YeeditorHelper::addSubmenu(JRequest::getCmd('view', 'yeeditor'));
		
		parent::display();

		return $this;
	}

    public function yeeditor_transverter() 
		{
			// Set view
			JRequest::setVar('view', 'Yeeditor_transverter');
			parent::display();
		}
		
	public function yeeditor_action() 
		{
			// Set view
			JRequest::setVar('view', 'Yeeditor_action');
			parent::display();
		}	
}