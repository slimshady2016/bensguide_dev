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

// Import Joomla! libraries
jimport('joomla.application.component.model');


class AjaxquizModelExport extends JModelList {	 
    function __construct() {
		parent::__construct();				
    }	
	function cat_export()
	{	
		$db		=& JFactory::getDBO();		
		$sql = "SELECT * FROM #__ajaxquiz_category";
		$db->setQuery($sql);
		$result = $db->loadAssocList();		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=category_data.csv');
		ob_clean(); 		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');		
		//fputcsv($output, array('id', 'title', 'duration', 'attempt', 'numques', 'userid', 'published', 'checked_out', 'checked_out_time', 'ordering', 'access'));		
	   foreach($result as $row){
	 	  fputcsv($output, $row); 
	   }	   
	   exit();	  		
	}	
	function ques_export()
	{	
		$db		=& JFactory::getDBO();		
		$sql = "SELECT * FROM #__ajaxquiz_question";
		$db->setQuery($sql);
		$result = $db->loadAssocList();		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=question_data.csv');
		ob_clean(); 		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');		
		//fputcsv($output, array('id', 'cid', 'title', 'description', 'published', 'checked_out', 'checked_out_time', 'ordering', 'access'));		
	   foreach($result as $row){
	 	  fputcsv($output, $row); 
	   }	
	   
	   exit();
	  		
	}
	
	
	function ans_export()
	{	
		$db		=& JFactory::getDBO();		
		$sql = "SELECT * FROM #__ajaxquiz_answer";
		$db->setQuery($sql);
		$result = $db->loadAssocList();			
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=answer_data.csv');
		ob_clean(); 		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');		
		//fputcsv($output, array('id', 'qid', 'title', 'right_answer', 'checked_out', 'checked_out_time', 'ordering', 'access'));		
	   foreach($result as $row){
	 	  fputcsv($output, $row); 
	   }	   
	   exit();	  		
	}		
	
	function rst_export()
	{
	
		$db		=& JFactory::getDBO();		
		$sql = "SELECT * FROM #__ajaxquiz_result";
		$db->setQuery($sql);	
		$result = $db->loadAssocList();			
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=result_data.csv');
		ob_clean();		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');		
		//fputcsv($output, array('id', 'qid', 'title', 'right_answer', 'checked_out', 'checked_out_time', 'ordering', 'access'));		
	   foreach($result as $row){
	 	  fputcsv($output, $row);
	   }		   
	   exit();	  		
	}		
	function delete(){	
	$db		=& JFactory::getDBO();	
	$query = "DELETE FROM `#__ajaxquiz_category`";	
	$db->setQuery( $query );	
	$db->query();	
	$query1 = "DELETE FROM `#__ajaxquiz_question`";	
	$db->setQuery( $query1 );	
	$db->query();	
	$query2 = "DELETE FROM `#__ajaxquiz_answer`";
	$db->setQuery( $query2 );	
	$db->query();	
	$query3 = "DELETE FROM `#__ajaxquiz_result`";
	$db->setQuery( $query3 );	
	$db->query();	
	//$this->setRedirect( 'index.php?option=com_ajaxquiz&view=backup', 'All Data Deleted' );		
	//JFactory::getApplication()->enqueueMessage(JText::_('All Data Deleted'));	
	return true;	
	}
}
?>