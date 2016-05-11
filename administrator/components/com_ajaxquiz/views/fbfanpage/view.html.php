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
if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}

// Import Joomla! libraries
jimport( 'joomla.application.component.view');



class AjaxquizViewFbfanpage extends JViewLegacy {

    function display($tpl = null) {
	
	require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'assets' . DS . 'src' . DS . 'facebook.php');
        
		global $mainframe, $option;
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		AjaxquizHelper::addSubmenu('fbfanpage');
                //$this->sidebar = JHtmlSidebar::render();
 
		// Set the toolbar
		$this->addToolBar();
		$this->sidebar = JHtmlSidebar::render();
		
		//$application = JFactory::getApplication();
		//create the toolbar
		JToolBarHelper::title(JText::_('Facebook Fanpage'), 'generic.png');
		//JToolBarHelper::preferences('com_ajaxquiz',500);

		
		
		$config = JFactory::getConfig();		
		$userParams     = JComponentHelper::getParams('com_ajaxquiz');
		$fbappid = $userParams->get( 'fbappid','' );
		$fbappkey = $userParams->get( 'fbappkey','' );
		$articleid = $userParams->get( 'articleid','' );
		
		
		if($fbappid==''){
		JFactory::getApplication()->enqueueMessage(JText::_('FANPAGE_ERROR'));
		return false;
		}
		
		if($fbappkey==''){
		JFactory::getApplication()->enqueueMessage(JText::_('FANPAGE_ERROR'));
		return false;
		}
		
		
	//	echo $fbappid;
		
		$facebook = new Facebook(array(
		  'appId'  => '264096206944960',
		  'secret' => '987771c8717292efdbfba77b65ae1898',
		  'cookie' => true,
		));



           $ap = $fbappid.'?fields=canvas_url,secure_canvas_url,page_tab_default_name,page_tab_url,secure_page_tab_url,namespace,website_url,canvas_fluid_height,canvas_fluid_width,logo_url,name,app_domains';
            $params['access_token'] = $fbappid . '|' . $fbappkey;
            $appProps = $facebook->api($ap, 'GET', $params);
			
	
			
			if (!array_key_exists('app_domains', $appProps)){			
			$appProps['app_domains'] = '';
			}

		$this->assignRef('appProps',	$appProps);
		
		parent::display($tpl);

    }
	
	protected function addToolBar() 
	{
		$canDo = AjaxquizHelper::getActions();
		JToolBarHelper::title(JText::_('COM_AJAXQUIZ'), 'ajaxquiz');
		
             
       JToolbarHelper::trash('result.remove');
               
	
		
		if ($canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_ajaxquiz');
		}
		JHtmlSidebar::setAction('index.php?option=com_ajaxquiz&view=fbfanpage');
      
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
