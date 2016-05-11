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
		defined('_JEXEC') or die('Restricted access'); 
		jimport('joomla.utilities.utility');
		
		
		$root = JURI::root();	
		$root = 'src="'.$root;
		$usrnme = $_GET['username'];
		$usremail = $_GET['useremail'];
		$categorytitle = $_GET['categorytitle'];		
        global $mainframe;
		$mainframe = JFactory::getApplication();	
		$db = JFactory::getDBO();		
		$query2 = "Select description FROM #__ajaxquiz_template where home = 1 and assignuser = 'User'";
		$db->setQuery( $query2 );	
		$result = $db->loadResult();	
		$result = str_replace('src="', $root, $result);
		
		$query3 = "Select description FROM #__ajaxquiz_template where home = 1 and assignuser = 'Administrator'";
		$db->setQuery( $query3 );
		$admin_des = $db->loadResult();	
		$admin_des = str_replace('src="', $root, $admin_des);	
		
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		
		$fromname 		= $mainframe->getCfg( 'fromname' );
		//get all super administrator
		$query = 'SELECT name, email, sendEmail' .  ' FROM #__users' .  ' WHERE sendEmail=1';
        $db = JFactory::getDBO();
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if ( ! $mailfrom  || ! $fromname ) {
			$fromname = $rows[0]->name;				
			$mailfrom = $rows[0]->email;
			
		}
	
        if($user->get('guest') == 1){
		$username = $usrnme;
		$email = $usremail;
		}
		
		$subject=JText::_('MAIL_SUBJECT');	
		$result = str_replace('{name}', $username, $result);
		$result = str_replace('{emailid}', $email, $result);
		$result = str_replace('{quizname}', $categorytitle, $result);
		$admin_des = str_replace('{name}', $username, $admin_des);
		$admin_des = str_replace('{emailid}', $email, $admin_des);
		$admin_des = str_replace('{quizname}', $categorytitle, $admin_des);
		
		$ques = '';
		$rightans = '';
		$userans = '';
		$message ='';
		$arr = array();
		$arr = $_POST['mydata'];
		$score = $_POST['score'];
		$result = str_replace('{score}', $score, $result);
		$admin_des = str_replace('{score}', $score, $admin_des);
		
		$totaltime = $_POST['totaltime'];
		$totaltime = $totaltime[4].":".$totaltime[5].":".$totaltime[6];
		$result = str_replace('{time}', $totaltime, $result);
		$admin_des = str_replace('{time}', $totaltime, $admin_des);
		
		
		$remaintime = $_POST['remaintime'];
		$remaintime = $remaintime[4].":".$remaintime[5].":".$remaintime[6];
		$result = str_replace('{remaintime}', $remaintime, $result);
		$admin_des = str_replace('{remaintime}', $remaintime, $admin_des);
		foreach($arr as $list)
			{
				$ques = $list[0]."<br >";	
				$rightans = JText::_('RIGHT_ANS').$list[1]."<br >";	
				$userans = JText::_('USER_ANS'). $list[2]."<br >";	
				$message .= $ques.$rightans.$userans;
			}
		$result = str_replace('{resultdata}', $message, $result);	
		$admin_des = str_replace('{resultdata}', $message, $admin_des);
		$check = JFactory::getMailer()->sendMail($mailfrom, $fromname, $email, $subject, $result, $mode = true, $cc = null, $bcc = null, $attachment = null, $replyTo = null, $replyToName = null);
			if (!($check instanceof Exception)) {
				$msg = JText::_('ESS');
				echo $msg;
			} else {
				$msg = JText::_('ESF');
				echo $msg;
			}
		foreach($rows as $row) {
		if($custom_email=="1")
		{
		$email=$custom_email_add;
		}
		else
		{
		$email = $row->email;
		}
			
			
			$admin_username = $row->name;
			// $message=JText::sprintf('MAIL_MESSAGE_ADMIN',$admin_username,$username, $mailresult);
			$check = JFactory::getMailer()->sendMail($mailfrom, $fromname, $email, $subject, $admin_des, $mode = true, $cc = null, $bcc = null, $attachment = null, $replyTo = null, $replyToName = null);
			if (!($check instanceof Exception)) {
				$msg = JText::_('ESS');
				echo $msg;
			} else {
				$msg = JText::_('ESF');
				echo $msg;
			}
		}
?>