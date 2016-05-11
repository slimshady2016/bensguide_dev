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
$sqlquery="";

if($_POST['action']=="save_template"){
	$content=$_POST['content'];
	if (get_magic_quotes_gpc()==1){
		 $content=stripcslashes($content);       
	}else{
		 $content=$content;
	}
	//$content=base64_encode($content);
	$sqlquery =  'insert into #__yeeditor (name,content,create_date) value ("'.$_POST['name'].'","'.JFactory::getDbo()->escape($content).'",now())';
	$database->setQuery( $sqlquery );
	if (!$result = $database->query()) {
	   echo $database->stderr();
	   return false;
	}
	
	$sqlquery =  "select id,name from #__yeeditor where published=1";
	$database->setQuery( $sqlquery );
	if (!$result = $database->query()) {
	   echo $database->stderr();
	   return false;
	}
	$templates=$database->loadObjectList();
	echo json_encode($templates);
}
else if($_POST['action']=="load_template"){
	$sqlquery =  "select name,content from #__yeeditor where id=".$_POST['id']." and published=1";
	$database->setQuery( $sqlquery );
	if (!$result = $database->query()) {
	   echo $database->stderr();
	   return false;
	}
	$template_content=$database->loadObjectList(); 
	echo $template_content[0]->content;
}	
else if($_POST['action']=="delete_template"){
	$sqlquery =  "delete from #__yeeditor where id=".$_POST['id'];
	$database->setQuery( $sqlquery );
	if (!$result = $database->query()) {
	   echo $database->stderr();
	   return false;
	}
	
	$sqlquery =  "select id,name from #__yeeditor where published=1";
	$database->setQuery( $sqlquery );
	if (!$result = $database->query()) {
	   echo $database->stderr();
	   return false;
	}
	$templates=$database->loadObjectList();
	echo json_encode($templates);
}

