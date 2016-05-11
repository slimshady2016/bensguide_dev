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

                if (task == 'category.cancel' || document.formvalidator.isValid(document.id('item-form'))) {

                        Joomla.submitform(task, document.getElementById('item-form'));

                } else {

                        alert('<?php echo $this->escape(JText::_('AJAXQUIZ_VALIDATION_CAT_TITLE_FAILED'));?>');

                }

        }

</script>





<form action="<?php echo JRoute::_('index.php?option=com_ajaxquiz&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate form-horizontal" id="item-form">

	<fieldset>

		<div class="tab-content">

			<div class="tab-pane active" id="details">

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

						<?php echo $this->form->getLabel('timer'); ?>

					</div>

					<div class="controls">

						<?php echo $this->form->getInput('timer'); ?>

					</div>

				</div>

				<div class="control-group">

					<div class="control-label">

						<?php echo $this->form->getLabel('duration'); ?>

					</div>

					<div class="controls">

						<?php echo $this->form->getInput('duration'); ?>

					</div>

				</div>

				<div class="control-group">

					<div class="control-label">

						<?php echo $this->form->getLabel('userid'); ?>

					</div>

					<div class="controls">

						<?php echo $this->form->getInput('userid'); ?>

					</div>

				</div>

					<div class="control-group">

					<div class="control-label">

						<?php echo $this->form->getLabel('attempt'); ?>

					</div>

					<div class="controls">

						<?php echo $this->form->getInput('attempt'); ?>

					</div>

				</div>

				<div class="control-group">

					<div class="control-label">

						<?php echo $this->form->getLabel('numques'); ?>

					</div>

					<div class="controls">

						<?php echo $this->form->getInput('numques'); ?>

					</div>

				</div>

				<div class="control-group">

						<div class="control-label">

							<?php echo $this->form->getLabel('published'); ?>

						</div>

						<div class="controls">

							<?php echo $this->form->getInput('published'); ?>

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

	</fieldset>



	<input type="hidden" name="task" value="" />

	<?php echo JHtml::_('form.token'); ?>

</form>

