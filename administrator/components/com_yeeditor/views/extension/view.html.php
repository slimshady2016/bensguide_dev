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

jimport( 'joomla.application.component.view');

class YeeditorViewExtension extends JViewLegacy
{
	protected $item;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');
        
		$widgets_ex_path = JPATH_ROOT."/administrator/components/com_yeeditor/widgets_ex/";
		
		$xmlfile=$widgets_ex_path.$this->item->widget_name."/".$this->item->widget_name.".xml";
		$xml = JFactory::getXML($xmlfile);
		
		$this->info=array();
		$this->info['id']=$this->item->id;
		$this->info['widget_name']=$this->item->widget_name;
		$this->info['install_time']=$this->item->install_time;
		$this->info['last_update']=$this->item->last_update;
		$this->info['published']=$this->item->published;
        $widget_info_str=$this->item->widget_info;
		$widget_info=json_decode($widget_info_str);
		$index='0';
		$this->info['title']=$widget_info[0]->$index;
		$this->info['version']=$xml->version;
		$this->info['creationDate']=$widget_info[2]->$index;
		$this->info['author']=$xml->author;
		$this->info['authorEmail']=$xml->authorEmail;
		$this->info['authorUrl']=$xml->authorUrl;
		$this->info['copyright']=$xml->copyright;
		$this->info['license']=$xml->license;
		$this->info['description']=$xml->description;
		
		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		if ($this->item->id) {
			JToolBarHelper::title(JText::_('COM_YEEDITOR_EDIT_EXTENSION_TITLE'));
		} else {
			JToolBarHelper::title(JText::_('COM_YEEDITOR_ADD_EXTENSION_TITLE'));
		}

		if (empty($this->item->id))  {
			JToolbarHelper::cancel('extension.cancel');
		}
		else {
			JToolbarHelper::cancel('extension.cancel', 'JTOOLBAR_CLOSE');
		}

		//JToolBarHelper::cancel('extension.cancel');
	}
}