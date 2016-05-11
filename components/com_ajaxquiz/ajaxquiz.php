<?php

/*------------------------------------------------------------------------

# component_ajaxquiz - The Name of Your Awesome Component

# ------------------------------------------------------------------------

# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://webkul.com

# Technical Support:  Forum - http://webkul.com/index.php?Itemid=86&option=com_kunena

-------------------------------------------------------------------------*/
// no direct access

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.utilities.utility' );

// Require the base controller

require_once JPATH_COMPONENT.'/controller.php';

$user = JFactory::getUser();

$userid 	= $user->get('id');

$username 	= $user->get('name');

$email		= $user->get('email');

$task = JRequest::getCmd('task');

$userParams     = JComponentHelper::getParams('com_ajaxquiz');

$userenable = $userParams->get('userenable',0);

$mailenable = $userParams->get('mailenable',0);

$custom_email = $userParams->get('custom_email',0);
$custom_email_add = $userParams->get('cus_email');


if ($userenable && $user->get('guest') == 1) {

echo JText::_('LOGIN_FIRST');

}

else if ( JRequest::getCmd('task') == "storedata")

	{
		require_once (JPATH_COMPONENT.'/views/storedata.php');

	}
	

else if ( JRequest::getCmd('task') == "mailresult")
	{

	

		require_once (JPATH_COMPONENT.'/views/mailresult.php');

	}

else {

// Initialize the controller

$controller = new AjaxquizController();
$controller->execute( null );
// Redirect if set by the controller
$controller->redirect();
}

?>