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

// No direct access.
defined('_JEXEC') or die;

$database = JFactory::getDbo();
$content=$_POST['value'];
$sqlquery="";
$sqlquery =  "update #__yeeditor_option set option_value='".$content."' where option_name='".$_POST['action']."'";
$database->setQuery( $sqlquery );
if (!$result = $database->query()) {
   echo $database->stderr();
   return false;
}