<?php
/*------------------------------------------------------------------------
# mod_Ajax_quiz - Ajax Quiz 
# ------------------------------------------------------------------------
# author    WebKul
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.webkul.com
# Technical Support:  Forum - http://www.webkul.com/index.php?Itemid=86&option=com_kunena
-----------------------------------------------------------------------*/
defined('_JEXEC') or die;
class modAjaxquizHelper 
{
  static function getAnswer ($id) {
         $db = JFactory::getDBO();
                 $query = 'SELECT *'.
                                 ' FROM #__ajaxquiz_answer' .
                                 ' WHERE qid = '.$id.
                                 ' AND published = 1'.
                                 ' ORDER BY ordering';
                $db->setQuery($query);
          $answers = $db->loadObjectList();
                return $answers;
        }
  static function getQuestion($categoryid) {
           $db = JFactory::getDBO();
       
       $query = 'SELECT numques FROM #__ajaxquiz_category WHERE id = '.$categoryid;
      $db->setQuery($query);
      $limit = intval($db->loadResult());
      
      if($limit==0) {
        $query = 'SELECT a.*  '
        .'FROM #__ajaxquiz_question AS a'
        .' WHERE a.published = 1 AND a.cid='.$categoryid.' ORDER BY ordering';
      
      }
      else 
      {
      
      $query = 'SELECT a.*  '
        .'FROM #__ajaxquiz_question AS a'
        .' WHERE a.published = 1 AND a.cid='.$categoryid.' ORDER BY RAND() LIMIT '.$limit;
      
      } 
                 $db->setQuery($query);
             $questions = $db->loadObjectList();
                 return $questions;
  }
}
?>
