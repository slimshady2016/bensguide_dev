<?php
/**
 * @module		com_ajaxquiz
 * @script		ajaxquiz.php
 * @author-name Webkul
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}

$db =& JFactory::getDBO();
	
$query = $db->getQuery(true);
$query = $db->getQuery(true);
 
$query = "SELECT * FROM `#__extensions`  WHERE name='plg_system_ajaxfbsystem'";	
$db->setQuery($query);
$plg_system_ajaxfbsystem = $db->loadResult();

if($plg_system_ajaxfbsystem=="")
{
	$file_destination_php = JPATH_PLUGINS.'/system/ajaxfbsystem/ajaxfbsystem.php';
	$file_destination_xml = JPATH_PLUGINS.'/system/ajaxfbsystem/ajaxfbsystem.xml';
	

	$file_original_php = JPATH_ADMINISTRATOR.'/components/com_ajaxquiz/install/ajaxfbsystem.php';
	$file_original_xml = JPATH_ADMINISTRATOR.'/components/com_ajaxquiz/install/ajaxfbsystem.xml';

	mkdir(JPATH_PLUGINS.'/system/ajaxfbsystem');
	@copy ($file_original_php, $file_destination_php );
	@copy ($file_original_xml, $file_destination_xml );
	

	// Initialize the database
	
	// Modify the admin icons
	// publish plugin 
	$db	=& JFactory::getDBO(); 	
	$query = "INSERT INTO `#__extensions` VALUES ('', 'plg_system_ajaxfbsystem', 'plugin', 'ajaxfbsystem', 'system', 0, 1, 1, 0,'','','','', 0, '0000-00-00 00:00:00',1,'')";
	$db->setQuery( $query );
	$db->query();
}




// $file_destination_php = JPATH_PLUGINS.DS.'system'.DS.'ajaxfbsystem'.DS.'ajaxfbsystem.php';
// $file_destination_xml = JPATH_PLUGINS.DS.'system'.DS.'ajaxfbsystem'.DS.'ajaxfbsystem.xml';
// $file_original_php = JPATH_ADMINISTRATOR.'/components/com_ajaxquiz/ajaxfbsystem/ajaxregistration.php';
// $file_original_xml = JPATH_ADMINISTRATOR.'/components/com_ajaxquiz/ajaxfbsystem/ajaxregistration.xml';
// mkdir(JPATH_PLUGINS.DS.'system'.DS.'ajaxfbsystem');
// copy ($file_original_php, $file_destination_php );
// copy ($file_original_xml, $file_destination_xml );


// $db =& JFactory::getDBO();
// $query = $db->getQuery(true);
// $query = $db->getQuery(true);
 
// $query = "SELECT * FROM `#__extensions`  WHERE name='plg_system_ajaxfbsystem'";	
// $db->setQuery($query);
// $plg_system_ajaxfbsystem = $db->loadResult();

// if($plg_system_ajaxfbsystem=="")
// {
	// $file_destination_php = JPATH_PLUGINS.DS.'system'.DS.'ajaxfbsystem'.DS.'ajaxfbsystem.php';
	// $file_destination_xml = JPATH_PLUGINS.DS.'system'.DS.'ajaxfbsystem'.DS.'ajaxfbsystem.xml';
	// $file_original_php = JPATH_ADMINISTRATOR.'/components/com_ajaxquiz/ajaxfbsystem/ajaxregistration.php';
	// $file_original_xml = JPATH_ADMINISTRATOR.'/components/com_ajaxquiz/ajaxfbsystem/ajaxregistration.xml';
	// mkdir(JPATH_PLUGINS.DS.'system'.DS.'ajaxfbsystem');
	// @copy ($file_original_php, $file_destination_php );
	// @copy ($file_original_xml, $file_destination_xml );

	// Initialize the database

	// $db =& JFactory::getDBO();

	// $query = "INSERT INTO `#__extensions` VALUES ('', 'plg_system_ajaxfbsystem', 'plugin', 'ajaxfbsystem', 'system', 0, 1, 1, 0,'','','','', 0, '0000-00-00 00:00:00',1,'')";
	// $db->setQuery( $query );
	// $db->query();
// }



 
// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_ajaxquiz')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}




// Execute the task.
 $controller     = JControllerLegacy::getInstance('Ajaxquiz');

 $controller->execute(JFactory::getApplication()->input->get('task'));
 $controller->redirect();

 
 
