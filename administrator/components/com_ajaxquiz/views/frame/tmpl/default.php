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
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior


?>


<form method="post" name="adminForm" id="adminForm">

<div class="main-quiz-holder">

<?php
			
if($this->items)	

	foreach ($this->items as $item)
			{		

			echo $item->result;		

			}
				 
 ?>	
		

		<input type="hidden" name="task" value="" />
	
	</div>	
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
