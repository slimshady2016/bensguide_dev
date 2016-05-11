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

jimport('joomla.application.component.controlleradmin');

class YeeditorControllerExtensions extends JControllerAdmin
{
	protected $text_prefix = 'COM_YEEDITOR_FIELD_EXTENSIONS';

	public function getModel($name = 'Extension', $prefix = 'YeeditorModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
	
	public function remove()
	{
	   $post = JRequest::get('post');
	   //print_r($post['cid']);
	   foreach($post['cid'] as $id){
			$database = JFactory::getDbo();
			$sqlquery = "select widget_name,setting_type from #__yeeditor_extensions where id=".$id;
			$database->setQuery( $sqlquery );
			if (!$result = $database->query()) {
				echo $database->stderr();
				return false;
			}
			$result=$database->loadObjectList();
			$widget_name=$result[0]->widget_name;
			$setting_type=$result[0]->setting_type;
			
			$sqlquery="";
			$sqlquery = "delete from #__yeeditor_extensions where id=".$id;
			$database->setQuery( $sqlquery );
			if (!$result = $database->query()) {
				echo $database->stderr();
				return false;
			}
			
			JFolder::delete(JPATH_COMPONENT."/widgets_ex/".$widget_name);
			JFolder::delete(JPATH_ROOT."/components/com_yeeditor/widgets_ex/".$widget_name);
			if($setting_type){
				$setting_types=explode(';',$setting_type);
				foreach($setting_types as $value){
					if(trim($value)){
						JFolder::delete(JPATH_COMPONENT."/widget_setting_type/".$value);
					}	
				}
			}
	   }
	   $app = JFactory::getApplication();
	   $app->enqueueMessage(JText::_('Delete success'));
	   
	   $this->setRedirect('index.php?option=com_yeeditor&view=extensions&layout=default&task=remove');
	}
}