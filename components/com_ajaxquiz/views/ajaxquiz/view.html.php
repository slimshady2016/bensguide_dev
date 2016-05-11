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

class AjaxquizViewAjaxquiz extends JViewLegacy {

	protected $questions;



	public function display($tpl = null) {	

	    	$this->questions = $this->get( 'Data' );
		// Create a shortcut for $item.
		// $this->assignRef('questions',$questions);
		$questions = &$this->questions;	
		$cid = $_REQUEST['cid'];
		$db = JFactory::getDBO();
		$query = 'SELECT userid FROM #__ajaxquiz_category WHERE id = '.$cid. ' AND published = 1';
		$db->setQuery($query);
		$result = $db->loadResult();
		$user = JFactory::getUser();
		$userid 	= $user->get('id');
		$this->state = $this->get('State');
		$app            = JFactory::getApplication();
		// Merge article params. If this is single-article view, menu params override article params
                // Otherwise, article params override menu item params
                $this->params   = $this->state->get('params');
                $active = $app->getMenu()->getActive();
                $temp   = clone ($this->params);

                // Check to see which parameters should take priority
                if ($active) {
                        $currentLink = $active->link;
                        // If the current view is the active item and an article view for this article, then the menu item params take priority
                        if (strpos($currentLink, 'view=ajaxquiz') && (strpos($currentLink, '&cid='.(string) $item->id)) && isset($questions[0])) {
                                // $item->params are the article params, $temp are the menu item params
                                // Merge so that the menu item params take priority
                                $questions[0]->params->merge($temp);
                                // Load layout from active query (in case it is an alternative menu item)
                                if (isset($active->query['layout'])) {
                                        $this->setLayout($active->query['layout']);
                                }
                        }
                        else {
                                // Current view is not a single article, so the article params take priority here
                                // Merge the menu item params with the article params so that the article params take priority
                                $temp->merge($questions[0]->params);
                                $questions[0]->params = $temp;

                                // Check for alternative layouts (since we are not in a single-article menu item)
                                // Single-article menu item layout takes priority over alt layout for an article
                                // if ($layout = $item->params->get('article_layout')) {
                                //        $this->setLayout($layout);
                                // }
                        }
                }
                else {
                        // Merge so that article params take priority
                        $temp->merge($questions[0]->params);
                        $questions[0]->params = $temp;
                        // Check for alternative layouts (since we are not in a single-article menu item)
                        // Single-article menu item layout takes priority over alt layout for an article
                        // if ($layout = $item->params->get('article_layout')) {
                        //        $this->setLayout($layout);
                        // }
                }







		if($userid == $result){
		
	        	parent::display($tpl);
			

		}
		else if($result == '0') {	
			parent::display($tpl);

		}

		else {
		echo JText::_('ACCESS_PER');
		}

    }

}
?>
