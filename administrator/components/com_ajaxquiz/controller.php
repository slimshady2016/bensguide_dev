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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
class AjaxquizController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	 
	function display($cachable = false, $urlparams = false) 
	{
		require_once JPATH_COMPONENT.'/helpers/ajaxquiz.php';

		$view   = $this->input->get('view', 'questions');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
		


		// Check for edit form.
		if ($view == 'question' && $layout == 'edit' && !$this->checkEditId('com_ajaxquiz.edit.question', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_ajaxquiz&view=questions', false));
				
			return false;
		}
		$Emptyview = JRequest::getCmd('view');
                if(empty($Emptyview)) {
								
                        JRequest::setVar('view', 'questions');
                }		
		
	  	parent::display();

                return $this;
 
	}
	
	function import() {
	$db = & JFactory::getDBO();
	$fileName = JPATH_COMPONENT.'/views/import/tmpl/files/'.JRequest::getVar('file');
	ini_set('auto_detect_line_endings',TRUE);
	echo JText::_("IMPORT_START")."<br />";
	$count = 0;
	$cat_count = 0;
	$ques_count = 0;
	$handle = fopen($fileName, 'r');

	

	 
	while (($xls_row = fgetcsv($handle)) !== false) {
             if($count !=0) {
		if($xls_row[0] !="") {
			$cat_count++;
			$Query_Category = 'INSERT INTO #__ajaxquiz_category (title,duration,published,ordering) values ("'.$xls_row[0].'","'.$xls_row[5].'","1","'.$cat_count.'")';
			$db->setQuery( $Query_Category );
			$db->query();
			$cat_id = $db->insertid();
			if($xls_row[1] !="") {
				$ques_count++;
					
				$Query_Question ='INSERT INTO #__ajaxquiz_question (cid,title,description,published,ordering) values ("'.$cat_id.'","'.$xls_row[1].'","'.$xls_row[2].'","1","'.$ques_count.'")';
				$db->setQuery( $Query_Question );
                        	$db->query();
                        	$ques_id = $db->insertid();
						
				$xls = $db->Quote($xls_row[3]);
				$Query_Answer = 'INSERT INTO #__ajaxquiz_answer (qid,title,right_answer,published,ordering) values ("'.$ques_id.'",'.$xls.',"'.$xls_row[4].'","1","'.$count.'")';
 				$db->setQuery( $Query_Answer );
                                $db->query();
			}
		} else {
			if($xls_row[1] !="") {
				$ques_count++;
				
                                $Query_Question ='INSERT INTO #__ajaxquiz_question (cid,title,description,published,ordering) values ("'.$cat_id.'","'.$xls_row[1].'","'.$xls_row[2].'","1","'.$ques_count.'")';
						
                                $db->setQuery( $Query_Question );
                                $db->query();
                                $ques_id = $db->insertid();
                        } 
				$xls = $db->Quote($xls_row[3]);
				
				$Query_Answer = 'INSERT INTO #__ajaxquiz_answer (qid,title,right_answer,published,ordering) values ("'.$ques_id.'",'.$xls.',"'.$xls_row[4].'","1","'.$count.'")';
 				$db->setQuery( $Query_Answer );
                                $db->query();
		}
   	echo $count." ".JText::_("RECORD_PROCESSED")."<br />";
	}
	$count++;
	}
	fclose($handle);
	echo JText::_("IMPORT_FINISHED");
	unlink($fileName);
	}
	
	
	function backup() {	
	$db = & JFactory::getDBO();		
	$filename = JRequest::getVar('file');
	$filepath = JPATH_COMPONENT.'/views/backup/tmpl/files/'.JRequest::getVar('file');
	ini_set('auto_detect_line_endings',TRUE);
	
	$handle = fopen($filepath, 'r');
	while (($xls_row = fgetcsv($handle)) !== false) {	
           if($filename == 'category_data.csv'){   		   
		   	$Query_Category = 'INSERT INTO #__ajaxquiz_category (id,title,duration,attempt,numques,userid,published,ordering) values ("'.$xls_row[0].'","'.$xls_row[1].'","'.$xls_row[2].'","'.$xls_row[3].'","'.$xls_row[4].'","'.$xls_row[5].'","'.$xls_row[6].'","'.$xls_row[9].'")';
			$db->setQuery( $Query_Category );
			$db->query();			   
		   }		   
		   elseif($filename == 'question_data.csv'){		   
		    $xls = $db->Quote($xls_row[2]);  		   
		   	$Query_Question = 'INSERT INTO #__ajaxquiz_question (id,cid,title,description,published,ordering) values ("'.$xls_row[0].'","'.$xls_row[1].'","'.$xls.'","'.$xls_row[3].'","'.$xls_row[4].'","'.$xls_row[7].'")';
			$db->setQuery( $Query_Question );
			$db->query();			   
		   }		   
		   elseif($filename == 'answer_data.csv'){  		   
		   $xls = $db->Quote($xls_row[2]);		   
		   	$Query_Data = 'INSERT INTO #__ajaxquiz_answer (id,qid,title,right_answer,published,ordering) values ("'.$xls_row[0].'","'.$xls_row[1].'","'.$xls.'","'.$xls_row[3].'","'.$xls_row[6].'","'.$xls_row[7].'")';
			$db->setQuery( $Query_Data );
			$db->query();		   
		   }		   
		   elseif($filename == 'result_data.csv'){  		   
		   $xls_row[4] = $db->Quote($xls_row[4]);		   
		   $xls_row[6] = $db->Quote($xls_row[6]);		   
		   	$Query_Data = 'INSERT INTO #__ajaxquiz_result (id,catid,name,email,summery,score,result) values ("'.$xls_row[0].'","'.$xls_row[1].'","'.$xls_row[2].'","'.$xls_row[3].'","'.$xls_row[4].'","'.$xls_row[5].'","'.$xls_row[6].'")';
			$db->setQuery( $Query_Data );
			$db->query();			   
		   }		   
		   else {		   
		   echo JText::_("PLEASE_CHECK_FILENAME");
			return false;		   
		   }			
		}		
	fclose($handle);
	echo JText::_("IMPORT_FINISHED");
	unlink($filepath);		
	}
}
