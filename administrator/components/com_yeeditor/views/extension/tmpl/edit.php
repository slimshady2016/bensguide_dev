<?php 
/*------------------------------------------------------------------------
# com_yeeditor - YEEditor
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die; 

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'banner.cancel' || document.formvalidator.isValid(document.id('extension-form'))) {
			Joomla.submitform(task, document.getElementById('extension-form'));
		}
	}
</script>
<form action="index.php?option=com_yeeditor&amp;id=<?php echo $this->item->id ?>"
	method="post" name="adminForm" id="extension-form" class="form-validate form-horizontal">
<div class="span10 form-horizontal yee_extension">
		<fieldset >
			<ul class="nav nav-tabs">
				<li class="active"><a href="#details" data-toggle="tab"><?php echo "Details";?></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="details">
					<div class="control-group">
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_TITLE'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['title'];?>" aria-invalid="false">
						</div>
					</div>	
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_NAME'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['widget_name'];?>" aria-invalid="false">
						</div>
					</div>	
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_STATUS'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['published'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_AUTHOR'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['author'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_VERSION'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['version'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_CREATION_DATE'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['creationDate'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_AUTHOR_EMAIL'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['authorEmail'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_AUTHOR_URL'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['authorUrl'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_COPYRIGHT'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['copyright'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_LICENSE'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['license'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_ID'); ?></label>
						</div>
						<div class="controls">
							<input class="inputbox" type="text" readonly="readonly" value="<?php echo $this->info['id'];?>" aria-invalid="false">
						</div>
					</div>
					<div class="control-group">	
						<div class="control-label">
							<label title="" class="hasTip"  aria-invalid="false"><?php echo JText::_('COM_YEEDITOR_EXTENSION_DESCRIPTION'); ?></label>
						</div>
						<div class="controls">
							<textarea readonly="readonly" cols="20" rows="10"><?php echo $this->info['description'];?></textarea>
						</div>
					</div>
				</div>	
			</div>		
		</fieldset>
</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<style>
.yee_extension input,.yee_extension textarea{ width:500px}
</style>