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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
//the name of the class must be the name of your component + InstallerScript
//for example: com_contentInstallerScript for com_content.
class pkg_YeeditorInstallerScript
{
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * preflight runs before anything else and while the extracted files are in the uploaded temp folder.
	 * If preflight returns false, Joomla will abort the update and undo everything already done.
	 */
	public function preflight( $type, $parent ) {
		$jversion = new JVersion();

			// this component does not work with Joomla releases prior to 3.0, The possible operators are: <, lt, <=, le, >, gt, >=, ge, ==, =, eq, !=, <>, ne
			if( version_compare( $jversion->getShortVersion(), '3.0', 'lt' ) ) {
 				Jerror::raiseWarning(null, 'Cannot install this version of YEEditor in a Joomla release prior to 3.0.');
 			
 				return false;
 			
 			}
			else{
				echo '<div class="install" style="color:#f71405"><b>Install success. <br>Please refer to <a href="./index.php?option=com_yeeditor" target="_blank"><em>here</em></a> before you use YEEditor.</b></div>';	
				return true;
			}
		
	}
	
	public function postflight($type, $parent)  {
        /*if($this->checkTableExist("#__yeeditor_extensions")){
			$new_widgets = array(
				"wgt_tinymce_editor",
				"wgt_jce_editor",
				"wgt_jck_editor",
				"wgt_flexslider",
				"wgt_hover_effect",
				"wgt_iframe",
				"wgt_nivo_slider",
				"wgt_progressbar",
				"wgt_teaser_grid",
				"wgt_elevatezoom",
				"wgt_jPlayer",
				"wgt_twentytwenty",
				"wgt_VerticalTimeline"
			);
			foreach($new_widgets as $new_widget){
				if(!$this->checkWidgetExist($new_widget)){
					if(!$this->InsertWidget($new_widget)){
						Jerror::raiseWarning(null, 'Cannot add the new widget "'.$new_widget.'". Please install the widget by manual operation');
					}
				}
			}
			
			//delete widgets
			$delete_widgets = array(
				"wgt_icon_list",
				"wgt_message_list"
			);
			foreach($delete_widgets as $widget){
				$this->deleteWidget($widget);
			}
		}*/
		
		if(!$this->checkOptionExist('yeeditor_status')){
			$this->insertOptions();
			$this->changeTable();
		}

    }
	
	public function checkTableExist($table) {
        $db = JFactory::getDBO();

        $tables = $db->getTableList();

        if (!empty($tables)) {
            // swap array values with keys, convert to lowercase and return array keys as values
            $tables = array_keys(array_change_key_case(array_flip($tables)));
            $app = JFactory::getApplication();
            $match = str_replace('#__', strtolower($app->getCfg('dbprefix', '')), $table);

            return in_array($match, $tables);
        }
		else{
			return '';
		}
		
	}
	
	//widget
	public function checkWidgetExist($widget) {
		$db = JFactory::getDBO();
		$query = "select id from #__yeeditor_extensions where widget_name='".$widget."'";
        $db->setQuery($query);
		return $db->loadResult();
	}
	
	public function InsertWidget($widget) {
		$widget_dir = JPATH_ADMINISTRATOR.'/components/com_yeeditor/widgets_ex/'.$widget;
		$xmlfiles=JFolder::files($widget_dir, $filter = '\.xml$',false,true);
		if($xmlfiles){
			$xmlfile=$xmlfiles[0];
			$xmlfile_name=basename($xmlfile,".xml");
			
			$xml = JFactory::getXML($xmlfile);
			$xml_info[]=$xml->title;
			$xml_info[]=$xml->version;
			$xml_info[]=$xml->creationDate;
			$xml_info[]=$xml->author;
			$xml_info[]=$xml->authorEmail;
			$xml_info[]=$xml->authorUrl;
			$xml_info[]=$xml->copyright;
			$xml_info[]=$xml->license;
			$xml_info[]=$xml->description;
			$xml_info_str=json_encode($xml_info);
			$setting_type=isset($xml->setting_type)?$xml->setting_type:'';
			$widget_group=$xml['group']?$xml['group']:"Other";
			
			$db = JFactory::getDBO();
			$query = "insert into #__yeeditor_extensions (widget_name,widget_group,author,setting_type,widget_info,install_time,last_update) value ('".$xmlfile_name."','".$widget_group."','".$xml->author."','".$setting_type."','".$xml_info_str."',now(),now())";
			$db->setQuery($query);
			$db->query();
			return true;
		}
		else{
			return false;
		}
	}
	
	public function deleteWidget($widget) {
		$widget_dir = JPATH_ADMINISTRATOR.'/components/com_yeeditor/widgets_ex/'.$widget;
		$widget_fronted_dir = JPATH_ROOT.'/components/com_yeeditor/widgets_ex/'.$widget;
		if(file_exists($widget_dir)){
			JFolder::delete($widget_dir);
		}
		if(file_exists($widget_dir)){
			JFolder::delete($widget_fronted_dir);
		}
		
		$db = JFactory::getDBO();
		$query = "delete from #__yeeditor_extensions where widget_name='".$widget."'";
		$db->setQuery($query);
		$db->query();
			
	}
	
	//option
	public function insertOptions() {
		$db = JFactory::getDBO();
		$query = "insert into #__yeeditor_option (option_name,option_value) values 
				('yeeditor_status', '1'),
				('yeeditor_load_font_awesome', '1'),
				('yeeditor_load_jquery', 'local'),
				('yeeditor_load_jquery_backend', 'local'),
				('yeeditor_editor_status', '1'),
				('yeeditor_other_editor', 'tinymce')";
        $db->setQuery($query);
		$db->query();
	}
	
	public function checkOptionExist($option_name) {
		$db = JFactory::getDBO();
		$query = "select id from #__yeeditor_option where option_name='".$option_name."'";
        $db->setQuery($query);
		return $db->loadResult();
	}
	
	public function changeTable() {
		$db = JFactory::getDBO();
		//published
		$query = "ALTER TABLE `#__yeeditor` ADD `published` INT( 2 ) NOT NULL DEFAULT '1' AFTER `isactive`";
        $db->setQuery($query);
		$db->query();
		
		$query = "update #__yeeditor set published=1";
        $db->setQuery($query);
		$db->query();
		
		//create_date
		$query = "ALTER TABLE `#__yeeditor` ADD `create_date` DATETIME NOT NULL AFTER `content` ";
        $db->setQuery($query);
		$db->query();
		
		$query = "update #__yeeditor set create_date=now()";
        $db->setQuery($query);
		$db->query();
		
		//update templates data
		$query =  "select id,content from #__yeeditor where published=1";
		$db->setQuery($query);
		$db->query();
		$templates=$db->loadObjectList(); 
		foreach($templates as $template){
			$query = "update #__yeeditor set content='".base64_decode($template->content)."' where id=".$template->id."";
			$db->setQuery($query);
			$db->query();	
		}
				
	}
	
	 
}
