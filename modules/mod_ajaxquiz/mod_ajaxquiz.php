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
defined('_JEXEC') or die('Restricted access'); 
require_once dirname(__FILE__).'/helper.php';
$config = JFactory::getConfig();
$userParams     = JComponentHelper::getParams('com_ajaxquiz');

$document =& JFactory::getDocument();

$loadjquery = $params->get( 'loadjquery' , 'None' );


if($loadjquery == "Head")
{
$document->addScript("https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js");
}
else if($loadjquery == "Inline")
{?>

<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script>
<?php }
?>

<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_ajaxquiz/assets/js/jquery.jquizzy-min.js"></script>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_ajaxquiz/assets/js/jquery.countdown.js"></script>
<link type="text/css" href="<?php echo JURI::root(); ?>components/com_ajaxquiz/assets/css/styles.css" rel="stylesheet">
<link type="text/css" href="<?php echo JURI::root(); ?>components/com_ajaxquiz/assets/css/jquery.countdown.css" rel="stylesheet">

<?php
$categoryid   = trim ( $params->get( 'categoryid' ) );
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));  
$root = JURI::root();
$db = JFactory::getDBO();
$user = JFactory::getUser();
$userid   = $user->get('id');
?>
<style type="text/css">
.social_body<?php echo $moduleclass_sfx;  ?> {
    clear: both;
    display: block;
    margin: 0 auto;
	height: 70px;
    width: 84%;
}
.social_tab<?php echo $moduleclass_sfx;  ?> {
    display: block;
    float: left;
	margin: 0 20px;
}
.main-quiz-holder { 
  margin: 0 auto;
  position: relative;background: #FCFCFC;
      border:1px solid #dedede;
  behavior:url(<?php echo $root ?>components/com_ajaxquiz/assets/css/PIE.htc);
  box-shadow:0 1px 5px #D9D9D9,inset 0 10px 20px #F1F1F1;
  -o-box-shadow:0 1px 5px #D9D9D9,inset 0 10px 20px #F1F1F1;
  -webkit-box-shadow:0 1px 5px #D9D9D9,inset 0 10px 20px #F1F1F1;
  -moz-box-shadow:0 1px 5px #D9D9D9,inset 0 10px 20px #F1F1F1;
  border-radius: 10px 10px 10px 10px;
  position: relative;
  width: 85%;<!---600px-->
  clear:both;
}
</style>
<?php

$query = 'SELECT title FROM #__ajaxquiz_category WHERE id = '.$categoryid. ' AND published = 1';
$db->setQuery($query);
$catname = $db->loadResult();
$query = 'SELECT duration FROM #__ajaxquiz_category WHERE id = '.$categoryid . ' AND published = 1';
$db->setQuery($query);
$result = $db->loadResult();
 $hr = explode(":",$result);

$min = explode(":",$result);

$sec = explode(":",$result);

if($hr[0]=="" && $min[0]=="" && $sec[0]=="")
{
$total="0";
}
else
{
$total = ($hr[0]*60*60)+($min[1]*60)+($sec[2]);
}

$time = "00:00:00";
if($result == $time){$time = 0;}else{$time = 1;}    
$HeadScript = "<script type='text/javascript'>
var init = { 'questions': [ ";
  $questions = modAjaxquizHelper::getQuestion($categoryid);
  $TotalQuestions =  count($questions);
  $question = 0;
  foreach ($questions as $row) {
      $question++;
      $skip = 0;
      $db = JFactory::getDBO(); 
      $query = 'SELECT c.* FROM #__ajaxquiz_answer AS c where c.published=1 AND c.qid='.$row->id;
      $db->setQuery($query);
      $number = $db->loadObjectList();
      if(!count($number) > 1 ) {
        $skip = 1;  
      }
      $query_forrightans = 'SELECT c.* FROM #__ajaxquiz_answer AS c where c.right_answer=1 AND c.published=1 AND c.qid='.$row->id;
      $db->setQuery($query_forrightans);
      $rightans = $db->loadObjectList();
      if(count($rightans) == 0  OR  count($rightans) > 1) {
            $skip = 1;
      } 
      if($skip ==0) {
      $config = JFactory::getConfig();
      $userParams     = JComponentHelper::getParams('com_ajaxquiz');
      $questiontitle = $userParams->get('questiontitle',1);
      if($questiontitle){
      $title= str_replace("'","\'",$row->title);
      }
      else{
      $title= '';
      } 
          $HeadScript .=" {'question': '<p>".$title."</p>".str_replace("'","\'",preg_replace('/\s\s+/','',$row->description))."',";
      $answers = modAjaxquizHelper::getAnswer ($row->id);
      $HeadScript .="'answers': [";
      $right =0;
      $TotalAnswer = count($answers);
      foreach ( $answers as $answer ) {    
        $right++;  
      if($answer->right_answer) {
          $correctAnswer ="],'correctAnswer': $right }";
         }
      $answer->title = str_replace("'","\'",$answer->title);
       if($right == $TotalAnswer ) {
         $HeadScript .="'$answer->title'".$correctAnswer;
       } else {
        $HeadScript .="'$answer->title',"; 
       }
       }
      if($TotalQuestions == $question) {  
      } else {
        $HeadScript .=" , "; 
       }
       }
  }
      $HeadScript .=
     "]
 };
 </script>";
$document = JFactory::getDocument();
$document->addCustomTag($HeadScript);
 ?>
<div id='quiz-container<?php echo $moduleclass_sfx;  ?>'></div> 
<?php
$config = JFactory::getConfig();
$userParams     = JComponentHelper::getParams('com_ajaxquiz');
$startimg = $userParams->get('startimg','components/com_ajaxquiz/assets/images/start.png');
$tweetimg = $userParams->get('tweetimg','components/com_ajaxquiz/assets/images/share.png');
$twittertxt = $userParams->get('twittertxt','Woo! I got {score} on the quiz. Try it!');
$twitterlink = $userParams->get('twitterlink','http://bit.ly/linky');
$twitteruser = $userParams->get('twitteruser','virginsoft');
$twittershow = $userParams->get('twittershow',1);
$fbshow = $userParams->get('fbshow',1);
$gplusshow = $userParams->get('gplusshow',1);
$linkedshow = $userParams->get('linkedshow',1);
$starttxt = $userParams->get('starttxt','Lets get starjkkljkjkted!');
$endtxt = $userParams->get('endtxt','Finished!');
$perfecttxt = $userParams->get('perfecttxt','Perfect!');
$excelltxt = $userParams->get('excelltxt','Excellent!');
$goodtxt = $userParams->get('goodtxt','Good!');
$acctxt = $userParams->get('acctxt','Acceptable!');
$distxt = $userParams->get('distxt','Disappointing!');
$poortxt = $userParams->get('poortxt','Poor!');
$nadatxt = $userParams->get('nadatxt','Nada!');
$mailenable = $userParams->get('mailenable',0);
$userenable = $userParams->get('userenable',0);
$resultshow = $userParams->get('resultshow',1);
$user = JFactory::getUser();
if(!$user->get('guest')){
$userenable=1;
$guest=0;
} else {
$guest=1;
}
if ($userenable && $user->get('guest') == 1) {
echo JText::_('Please Login First....');
} 
else {
$query = 'SELECT userid FROM #__ajaxquiz_category WHERE id = '.$categoryid. ' AND published = 1';
$db->setQuery($query);
$result = $db->loadResult();
if($userid == $result){
$query = "SELECT count(id) FROM #__ajaxquiz_result where userid = '".$userid."'";
$db->setQuery($query);
$count = $db->loadResult();
$attempt = "SELECT attempt FROM #__ajaxquiz_category where userid = '".$userid."'";
$db->setQuery($attempt);
$att = $db->loadResult();
if(($count < $att) || ($att == '0') ){
?>

<script type='text/javascript'> 
var webkul;
 jQuery('#quiz-container<?php echo $moduleclass_sfx;  ?>').jquizzy({
 
      categoryid: <?php echo $categoryid; ?>,
	  wkpath: '<?php echo juri::root();?>',
 
      catname: '<?php echo $catname; ?>', 
      questions: init.questions, 
      splashImage:'<?php echo JURI::root().$startimg; ?>',
      twitterImage: '<?php echo JURI::root().$tweetimg; ?>',
      twitterStatus: '<?php echo $twittertxt; ?> <?php echo $twitterlink; ?>',
      twittershow: <?php echo $twittershow; ?>,
      
      fbshow: <?php echo $fbshow; ?>, 
      gplusshow: <?php echo $gplusshow; ?>,
      linkedshow: <?php echo $linkedshow; ?>,
      twitterUsername: '<?php echo $twitteruser; ?>',
      startText: '<?php echo $starttxt; ?>',
      endText: '<?php echo $endtxt; ?>',
      email: <?php echo $mailenable; ?>,
        user: <?php echo $userenable; ?>,
      guest: <?php echo $guest; ?>,
	  
      
      resultshow: <?php echo $resultshow; ?>,
      total: <?php echo $total; ?>,
      langQuestion: '<?php echo JText::_('QUSETION'); ?>',
                        langCorrect: '<?php echo JText::_('CORRECT'); ?>',
                        langIncorrect: '<?php echo JText::_('INCORRECT'); ?>',
                        langYouscored: '<?php echo JText::_('YOUSCORED'); ?>',
                        langNext: '<?php echo JText::_('NEXT'); ?>',
                        langPrev: '<?php echo JText::_('PREV'); ?>',
                        langFinish: '<?php echo JText::_('FINISH'); ?>',
                        langNotattempted: '<?php echo JText::_('NOTATTEMPTED'); ?>',
                        langTimeout: '<?php echo JText::_('TIMEOUT'); ?>',
                        langResultEmailed: '<?php echo JText::_('RESULTEMAILED'); ?>',
                        langName: '<?php echo JText::_('NAME'); ?>',
                        langEmail: '<?php echo JText::_('EMAIL'); ?>',
                        langSubmitdetails: '<?php echo JText::_('SUBMIT_DETAILS'); ?>',
                        langEntername: '<?php echo JText::_('ENTER_NAME'); ?>',
                        langEnteremail: '<?php echo JText::_('ENTER_EMAIL'); ?>',
                        langEntervalidemail: '<?php echo JText::_('ENTER_VALID_EMAIL'); ?>',
      langSelectOption: '<?php echo JText::_('SELECT_OPTION'); ?>',   
      
                
            langparseques: '<?php echo JText::_('PARSE_QUES'); ?>',
            
            langrightans: '<?php echo JText::_('RIGHT_ANS'); ?>',
            
            langwrongans: '<?php echo JText::_('WRONG_ANS'); ?>',
            
            languserans: '<?php echo JText::_('USER_ANS'); ?>',
      time: <?php echo $time; ?>,   
      modclasssfx: '<?php echo $moduleclass_sfx;  ?>',
      resultComments : 
          {
            perfect: '<?php echo $perfecttxt; ?>',
          excellent: '<?php echo $excelltxt; ?>',
          good: '<?php echo $goodtxt; ?>',
          average: '<?php echo $acctxt; ?>',
          bad: '<?php echo $distxt; ?>',
          poor: '<?php echo $poortxt; ?>',
          worst: '<?php echo $nadatxt; ?>'
          }
    });   
 </script> 
 
 <?php 
 }
else
{
echo JText::_('USER_ATTEMPT');
}
}
else if($result == '0') {
?> 
<script type='text/javascript'> 
 jQuery.noConflict();
 jQuery('#quiz-container<?php echo $moduleclass_sfx;  ?>').jquizzy({
 
      categoryid: <?php echo $categoryid; ?>,
 
      catname: '<?php echo $catname; ?>', 
      questions: init.questions, 
      splashImage:'<?php echo JURI::root().$startimg; ?>',
      twitterImage: '<?php echo JURI::root().$tweetimg; ?>',
      twitterStatus: '<?php echo $twittertxt; ?> <?php echo $twitterlink; ?>',
      twitterUsername: '<?php echo $twitteruser; ?>',
      startText: '<?php echo $starttxt; ?>',
      endText: '<?php echo $endtxt; ?>',
      email: <?php echo $mailenable; ?>,
            user: <?php echo $userenable; ?>,
      guest: <?php echo $guest; ?>,
      
      
      resultshow: <?php echo $resultshow; ?>, 
      total: <?php echo $total; ?>,
      langQuestion: '<?php echo JText::_('QUSETION'); ?>',
                        langCorrect: '<?php echo JText::_('CORRECT'); ?>',
                        langIncorrect: '<?php echo JText::_('INCORRECT'); ?>',
                        langYouscored: '<?php echo JText::_('YOUSCORED'); ?>',
                        langNext: '<?php echo JText::_('NEXT'); ?>',
                        langPrev: '<?php echo JText::_('PREV'); ?>',
                        langFinish: '<?php echo JText::_('FINISH'); ?>',
                        langNotattempted: '<?php echo JText::_('NOTATTEMPTED'); ?>',
                        langTimeout: '<?php echo JText::_('TIMEOUT'); ?>',
                        langResultEmailed: '<?php echo JText::_('RESULTEMAILED'); ?>',
                        langName: '<?php echo JText::_('NAME'); ?>',
                        langEmail: '<?php echo JText::_('EMAIL'); ?>',
                        langSubmitdetails: '<?php echo JText::_('SUBMIT_DETAILS'); ?>',
                        langEntername: '<?php echo JText::_('ENTER_NAME'); ?>',
                        langEnteremail: '<?php echo JText::_('ENTER_EMAIL'); ?>',
                        langEntervalidemail: '<?php echo JText::_('ENTER_VALID_EMAIL'); ?>',
                        langSelectOption: '<?php echo JText::_('SELECT_OPTION'); ?>',
            
            
            
                      
            langparseques: '<?php echo JText::_('PARSE_QUES'); ?>',
            
            langrightans: '<?php echo JText::_('RIGHT_ANS'); ?>',
            
            langwrongans: '<?php echo JText::_('WRONG_ANS'); ?>',
            
            languserans: '<?php echo JText::_('USER_ANS'); ?>',
      time: <?php echo $time; ?>,   
      modclasssfx: '<?php echo $moduleclass_sfx;  ?>',  
      resultComments :  
          {
            perfect: '<?php echo $perfecttxt; ?>',
          excellent: '<?php echo $excelltxt; ?>',
          good: '<?php echo $goodtxt; ?>',
          average: '<?php echo $acctxt; ?>',
          bad: '<?php echo $distxt; ?>',
          poor: '<?php echo $poortxt; ?>',
          worst: '<?php echo $nadatxt; ?>'
          }
    });   
 </script>
 <?php 
 }    
else {    
echo JText::_('ACCESS_PER');    
}
} 
 ?>

 