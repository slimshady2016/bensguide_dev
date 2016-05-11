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
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('behavior.modal');
JHtml::_('formbehavior.chosen', 'select');
$user   = JFactory::getUser();
$userId   = $user->get('id');
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$canOrder = $user->authorise('core.edit.state', 'com_ajaxquiz.result');
$archived = $this->state->get('filter.published') == 2 ? true : false;
$trashed  = $this->state->get('filter.published') == -2 ? true : false;
$params   = (isset($this->state->params)) ? $this->state->params : new JObject;
$saveOrder  = $listOrder == 'ordering';
if ($saveOrder)
{
  $saveOrderingUrl = 'index.php?option=com_ajaxquiz&task=ajaxquiz.saveOrderAjax&tmpl=component';
  JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
        Joomla.orderTable = function() {
                table = document.getElementById("sortTable");
                direction = document.getElementById("directionTable");
                order = table.options[table.selectedIndex].value;
                if (order != '<?php echo $listOrder; ?>') {
                        dirn = 'asc';
                } else {
                        dirn = direction.options[direction.selectedIndex].value;
                }
                Joomla.tableOrdering(order, dirn, '');
        }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_ajaxquiz&view=result'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
  <div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
  </div>
  <div id="j-main-container" class="span10">
<?php else : ?>
  <div id="j-main-container">
<?php endif;?>
    <div id="filter-bar" class="btn-toolbar">
      <div class="filter-search btn-group pull-left">
        <label for="filter_search" class="element-invisible"><?php echo JText::_('Search');?></label>
        <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('Search'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('Search'); ?>" />
      </div>
      <div class="btn-group pull-left">
        <button type="submit" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
        <button type="button" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
      </div>
      <div class="btn-group pull-right hidden-phone">
        <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
        <?php echo $this->pagination->getLimitBox(); ?>
      </div>
      
      <div class="btn-group pull-right hidden-phone">
        <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
        <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
          <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
          <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
          <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
        </select>
      </div>
      <div class="btn-group pull-right">
        <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
        <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
          <option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
          <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
        </select>
      </div>
      
      
    </div>
    <div class="clearfix"> </div>
    <table class="table table-striped" id="articleList">
      <thead>
        <tr>
          <th width="1%" class="hidden-phone">
            <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
          </th>
          <th width="10%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'Name', 'a.name', $listDirn, $listOrder); ?>
          </th>
          <th width="10%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'Category', 'a.catname', $listDirn, $listOrder); ?>
          </th>
          <th width="10%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'Email', 'a.email', $listDirn, $listOrder); ?>
          </th>
          <th width="30%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'Summery', 'a.summery', $listDirn, $listOrder); ?>
          </th>
          <th width="10%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'Score', 'a.score', $listDirn, $listOrder); ?>
          </th>
          
          <th width="10%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'Total Time', 'a.totaltime', $listDirn, $listOrder); ?>
          </th>
          
          <th width="10%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'Remaining Time', 'a.remaintime', $listDirn, $listOrder); ?>
          </th>
          <th width="1%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
          </th>
        </tr>
      </thead>
      
      <tbody>
      <?php foreach ($this->items as $i => $item) :
        $ordering  = ($listOrder == 'a.ordering');
        $item->cat_link = JRoute::_('index.php?option=com_ajaxquiz&view=categories&task=edit&type=other&cid[]='. $item->id);
        $canCreate  = $user->authorise('core.create',     'com_ajaxquiz.result.' . $item->id);
        $canEdit    = $user->authorise('core.edit',       'com_ajaxquiz.result.' . $item->id);
        $canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
        $canChange  = $user->authorise('core.edit.state', 'com_ajaxquiz.result.' . $item->id);
      $link     = 'index.php?option=com_ajaxquiz&amp;component=com_ajaxquiz&amp;view=frame&amp;id='.$item->id.'&amp;tmpl=component';
        ?>
        <tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->id?>">        
          <td class="center hidden-phone">
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
          </td>
          <td class="nowrap has-context">
            <div class="pull-left">
            <a href="<?php echo $link; ?>" class="modal" rel="{handler: 'iframe', size: {x: 670, y: 400}}"> 
                  <?php echo $this->escape($item->name); ?>
            </a>      
            </div>
          </td>
          <td class="center hidden-phone">
            <?php echo $item->catname; ?>
          </td>
          <td class="center hidden-phone">
            <?php echo $item->email; ?>
          </td>
          <td class="center hidden-phone">
            <?php echo $item->summery; ?>
          </td>
          <td class="center hidden-phone">
            <?php echo $item->score; ?>%
          </td>
          
          <td class="center hidden-phone">
            <?php if($item->totaltime=='0:0:0'){ echo 'NIL'; } else { echo $item->totaltime; } ?>
          </td>
          
          <td class="center hidden-phone">
            <?php if($item->remaintime=='0:0:0'){ echo 'NIL'; } else { echo $item->remaintime; } ?>
          </td>
          <td class="center hidden-phone">
            <?php echo $item->id; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      
    </table>
    <?php echo $this->pagination->getListFooter(); ?>
    <?php //Load the batch processing form. ?>
    
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?>
  </div>
</form>
