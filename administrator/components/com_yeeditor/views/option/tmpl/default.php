<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_PLUGINS."/editors/yeeditor/define.php";

JHtml::_('jquery.framework');
JHtml::_('bootstrap.framework');
$root=JURI::root();
$document =JFactory::getDocument();
$document->addScript($root.'administrator/components/com_yeeditor/assets/js/option.js');

// Load tooltips behavior
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
JHtml::_('formbehavior.chosen', 'select');

$jsMessage = array(
	"COM_YEEDITOR_FIELD_OPTION_COMBINE_CSS_SUCCESS" => JText::_('COM_YEEDITOR_FIELD_OPTION_COMBINE_CSS_SUCCESS')
);
?>
<script type="text/javascript">
	var yee_root='<?php echo $root."administrator/";?>';
	//message
	var jsMessage = <?php echo $jsMessage?json_encode($jsMessage):"[]";?>;
</script>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'option.cancel' || document.formvalidator.isValid(document.id('option-form'))) {
			Joomla.submitform(task, document.getElementById('option-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_yeeditor');?>" id="option-form" method="post" name="adminForm" class="form-validate">
	<div class="form-horizontal">
	<legend><?php echo JText::_('COM_YEEDITOR_FIELD_OPTION'); ?></legend>
	<?php
	foreach ($this->form->getFieldset('params') as $field):
	?>
		<div class="control-group">
			<div class="control-label"><?php echo $field->label; ?></div>
			<div class="controls"><?php echo $field->input; ?></div>
		</div>
	<?php
	endforeach;
	?>
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
