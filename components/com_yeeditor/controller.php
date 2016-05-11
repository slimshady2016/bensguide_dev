<?php
defined( '_JEXEC' ) or die;

class YeeditorController extends JControllerLegacy
{
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