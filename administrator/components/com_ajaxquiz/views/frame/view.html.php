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
// jimport('joomla.application.component.view');

// jimport( 'joomla.html.html' );

JHtml::stylesheet(JURI::root().'components/com_ajaxquiz/assets/css/frame.css');



class AjaxquizViewFrame extends JViewLegacy
{



	protected $items;


	/**
	 * Ola view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
	
	
		$this->items		= $this->get('Items');
	
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

 
		// Display the template
		parent::display($tpl);
 
	}
 
	
}
