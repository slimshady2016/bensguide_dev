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
echo "<h2>".JText::_('LIST_OF_QUIZZES')."</h2>";

echo '<ul id="ajaxquiz-cat-list">';

foreach($this->category as $cat) {

    echo '<li><a href="index.php?option=com_ajaxquiz&view=ajaxquiz&cid='.$cat->id.'&Itemid='.JRequest::getCmd('Itemid').'">'.$cat->title.'</a></li>';

}

echo '</ul>';
?>



