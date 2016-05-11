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
defined('_JEXEC') or die;
// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$input = JFactory::getApplication()->input;
// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
        Joomla.submitbutton = function(task)
        {
                if (task == 'template.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
                        Joomla.submitform(task, document.getElementById('item-form'));
                } else {
                        alert('<?php echo $this->escape(JText::_('AJAXQUIZ_VALIDATION_TEMPLATE_TITLE_FAILED'));?>');
                }
        }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_ajaxquiz&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate form-horizontal" id="item-form">
	<fieldset>
		<div class="tab-content">
			<div class="tab-pane active" id="details" style="float:left;width:80%;">
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title'); ?>
					</div>
					
					<div class="controls">
						<?php echo $this->form->getInput('title'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('assignuser'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('assignuser'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('description'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('description'); ?>
					</div>
				</div>				
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('id'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('id'); ?>
					</div>
				</div>				
		</div>
			
		<div class="right_content" style="float:right;margin-top:6%;margin-right:3%;">
				<?php echo JText::_( 'USE_PARAM' ) ?> <br /><br />
				<?php echo JText::_( 'USERNAME' ) ?> {name} <br />
				<?php echo JText::_( 'SCORE' ) ?> {score} <br />
				
				<?php echo JText::_( 'RESULTDATA' ) ?> {resultdata} <br/>				
				<?php echo JText::_( 'EMAILID' ) ?> {emailid} <br/>
				
				<?php echo JText::_( 'QUIZNAME' ) ?> {quizname} <br/>
				
				
				<?php echo JText::_( 'TIME' ) ?> {time} <br/>
				
				
				<?php echo JText::_( 'REMAINTIME' ) ?> {remaintime} <br/>
		</div>
	</div>
	</fieldset>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
