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



$cid = $_GET['cid'];

$catname = $_GET['catname'];

$user = JFactory::getUser();

$usrnme 	= $user->get('name');

$usremail	= $user->get('email');

$userParams     = JComponentHelper::getParams('com_ajaxquiz');

$mailenable = $userParams->get('mailenable',0);



if($user->get('guest')){

	$usrnme = "guest";

	$usremail = "- - -";

	if($mailenable) {

        	$usrnme = $_GET['username'];

        	$usremail = $_GET['useremail'];

        }

}



$store = $_POST['store'];

$score = $_POST['score'];

$result = $_POST['result'];

$totaltime = $_POST['totaltime'];

$remaintime = $_POST['remaintime'];

$totaltime = $totaltime[4].":".$totaltime[5].":".$totaltime[6];

$remaintime = $remaintime[4].":".$remaintime[5].":".$remaintime[6];

$resultContent = preg_replace("'","&#39;",$result);


$db = JFactory::getDBO();



$query = "INSERT INTO #__ajaxquiz_result (id, catid, catname, name, email, summery, score, result, totaltime, remaintime) VALUES (' ', '".$cid."', '".$catname."', '".$usrnme."', '".$usremail."', '".$store."', '".$score."', '".$resultContent."', '".$totaltime."', '".$remaintime."')";



$db->setQuery( $query );



$db->query();

?>