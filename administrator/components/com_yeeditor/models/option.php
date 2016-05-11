<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');

require_once JPATH_PLUGINS."/editors/yeeditor/define.php";
require_once YEEDITOR_PATH."include/functions_general.php";

/**
 * @package		Joomla.Administrator
 * @subpackage	com_config
 */
class YeeditorModelOption extends JModelForm
{
	/**
	 * Method to get a form object.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JForm object on success, false on failure
	 *
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_yeeditor.option', 'option', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the configuration data.
	 *
	 * This method will load the global configuration data straight from
	 * JConfig. If configuration data has been saved in the session, that
	 * data will be merged into the original data, overwriting it.
	 *
	 * @return	array		An array containg all global config data.
	 *
	 * @since	1.6
	 */
	public function getData()
	{
		$data = array();
		$data['font_awesome'] = get_yeeditor_option('yeeditor_load_font_awesome');
		$data['which_jquery_to_load'] = get_yeeditor_option('yeeditor_load_jquery');
		$data['which_jquery_to_load_backend'] = get_yeeditor_option('yeeditor_load_jquery_backend');
		$data['other_editor'] = get_yeeditor_option('yeeditor_other_editor');

		return $data;
	}

	/**
	 * Method to save the configuration data.
	 *
	 * @param	array	An array containing all global config data.
	 *
	 * @return	bool	True on success, false on failure.
	 *
	 * @since	1.6
	 */
	public function save($data)
	{
		$result = true;
		
		if(!$this->update_yeeditor_option('yeeditor_load_font_awesome',$data['font_awesome'])){
			$result = false;
		}
		if(!$this->update_yeeditor_option('yeeditor_load_jquery',$data['which_jquery_to_load'])){
			$result = false;
		}
		if(!$this->update_yeeditor_option('yeeditor_load_jquery_backend',$data['which_jquery_to_load_backend'])){
			$result = false;
		}
		if(!$this->update_yeeditor_option('yeeditor_other_editor',$data['other_editor'])){
			$result = false;
		}
		
		return $result;
	}
	
	public function update_yeeditor_option($key,$value){
		if(get_yeeditor_option($key)===false){
			$db = $this->getDbo();

			$db->setQuery(
				'insert into #__yeeditor_option' .
				" (option_name,option_value) values ('".$key."','".$value."')"
			);
			if (!$db->query()) {
				return false;
			}
		}
		else{
			$db = $this->getDbo();
			
			$db->setQuery(
				'UPDATE #__yeeditor_option' .
				' SET option_value = "'.$value.'"'.
				' WHERE option_name="'.$key.'"'
			);
			if (!$db->query()) {
				return false;
			}
		}
		return true;
	}
	
}
