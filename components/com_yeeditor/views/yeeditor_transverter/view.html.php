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

defined('_JEXEC') or die;

$user		= JFactory::getUser(); 
if(!($user->authorise('core.create', 'com_content') || $user->authorise('core.eidt', 'com_content'))){
	JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	exit;
}

jimport( 'joomla.application.component.view');

class YeeditorViewYeeditor_transverter extends JViewLegacy
{
    function display($tpl = null)
    {
        parent::display($tpl);
    }
}