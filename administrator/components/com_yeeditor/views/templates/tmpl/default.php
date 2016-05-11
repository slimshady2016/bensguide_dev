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

// no direct access
defined('_JEXEC') or die;
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

$widgets_ex_path = JPATH_ROOT."/administrator/components/com_yeeditor/widgets_ex/";
?>
<form action="index.php?option=com_yeeditor&amp;view=templates" method="post" name="adminForm" id="adminForm">
	<div id="filter-bar" class="btn-toolbar">
		<div class="filter-search btn-group pull-left">
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="Search" />
		</div>	
		<div class="btn-group pull-left">
			<button type="submit" class="btn hasTooltip"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" class="btn hasTooltip" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
	</div>
	<div>
		<div class="filter-select fltrt">

			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', array("1"=>"Published","0"=>"Unpublished"), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
		</div>
	</div>


	<table class="table table-striped">
		<thead>
			<tr>
				<th width="1%" class="center">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
				<th class="center"><?php echo JText::_('ID');?></th>
				<th class="center"><?php echo JHtml::_('grid.sort', 'COM_YEEDITOR_FIELD_TEMPLATES_NAME_LABEL', 'name', $listDirn, $listOrder)?></th>
				<th class="center"><?php echo JHtml::_('grid.sort', 'JSTATUS', 'published', $listDirn, $listOrder)?></th>
				<th class="center"><?php echo JHtml::_('grid.sort', 'COM_YEEDITOR_FIELD_TEMPLATES_CREATE_DATE_LABEL', 'create_date', $listDirn, $listOrder)?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($this->items as $i => $item): ?>
				<tr class="row<?php echo $i % 2 ?>">
					<td class="center">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="center"><?php echo $this->escape($item->id) ?></td>
					<td class="center">
						<a href="<?php echo $item->url; ?>">
							<?php echo $this->escape($item->name) ?>
						</a>
					</td>
					<td class="center">
						<?php echo JHtml::_('jgrid.published',
						$item->published, $i, 'templates.', true, 'cb'); ?>
					</td>
					<td class="center"><?php echo $this->escape($item->create_date) ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />		
	<?php echo JHtml::_('form.token'); ?>
</form>