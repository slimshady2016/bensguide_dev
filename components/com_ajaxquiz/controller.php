<?php

/*------------------------------------------------------------------------

# component_ajaxquiz - The Name of Your Awesome Component

# ------------------------------------------------------------------------

# author    Prakash Sahu Webkul
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://webkul.com
# Technical Support:  Forum - http://webkul.com/index.php?Itemid=86&option=com_kunena
-------------------------------------------------------------------------*/
// no direct access

defined('_JEXEC') or die('Restricted access');


/**

 * ajaxquiz Component Controller
 */

class AjaxquizController extends JControllerLegacy {

	public function display($cachable = false, $urlparams = false) 
	{

        // Make sure we have a default view

        if( !JRequest::getVar( 'view' )) {

		    JRequest::setVar('view', 'ajaxquiz' );
        }

		parent::display($cachable, $urlparams);

		return $this;

	}
	
}

?>