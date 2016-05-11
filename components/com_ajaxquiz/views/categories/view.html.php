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
jimport( 'joomla.application.component.view');

/**
 * HTML View class for the ajaxquiz component
 */

class AjaxquizViewCategories extends JViewLegacy {

	function display($tpl = null) {

 		$db = JFactory::getDBO();

                $query = 'SELECT id,title'.

                                 ' FROM #__ajaxquiz_category' .

                                 ' WHERE published = 1'.

                                 ' ORDER BY ordering';

                $db->setQuery($query);

                $category = $db->loadObjectList();

                $this->assignRef('category',  $category);

        parent::display($tpl);
    }
}

?>