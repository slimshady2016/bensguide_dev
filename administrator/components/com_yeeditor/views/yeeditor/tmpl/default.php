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

$plugin1 = JPluginHelper::getPlugin('system', 'yeeditor_content');
$plugin2 = JPluginHelper::getPlugin('search', 'yeeditor_content');
$plugin3 = JPluginHelper::getPlugin('search', 'content');
$plugin4 = JPluginHelper::getPlugin('search', 'k2');
$plugin5 = JPluginHelper::getPlugin('search', 'k2_yeeditor_content');

$publish_html = '<i class="icon-publish"></i>';

$unpublish_html = '<i class="icon-unpublish"></i>';
?>
<div style="text-align:center"><h1>YEEditor</h1></div>
<div style="text-align:center"><img src="../images/joomla_logo_black.jpg" /></div>
<br />

<div class="yeeditor-info">
    <p>
    <strong>Install</strong>:
    <br />1.Our plugins default is unpublish. So you should publish our plugins in <a href="./index.php?option=com_plugins&view=plugins" target="_blank"><em>here</em></a>:
    </p>
    <ul>
        <li>  <?php echo $plugin1?$publish_html:$unpublish_html;?>  <strong>System - YEEditor-Content</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Translating the yeeditor shortcode in the frontend article content.)</li>
        <li>  <?php echo $plugin2?$publish_html:$unpublish_html;?>  <strong>Search - YEEditor content</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  (Take the place of joomla search plugin function.Search the content that after been translated.)</li>
    </ul>
    <p>2.To take the place of joomla search plugin,you should unpublish the joomla search plugin:</p>
    <ul>
        <li>  <?php echo $plugin3?$publish_html:$unpublish_html;?>  <strong>Search - Content</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  (Joomla search plugin.)</li>
    </ul>
    <p>3.If you using K2 editor, you should publish our "Search - K2 YEEditor Content" plugin to take the place of "Search - K2".</p>
    <ul>
        <li>  <?php echo $plugin4?$publish_html:$unpublish_html;?>  <strong>Search - K2</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  (K2 editor search plugin)</li>
        <li>  <?php echo $plugin5?$publish_html:$unpublish_html;?>  <strong>Search - K2 YEEditor Content</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  (Take the place of K2 editor search pluginn function.Search the content that after been translated.)</li>
    </ul>
    <p>
    <br />
    <br />
    <strong>Uninstall</strong>:<br />Search YEEditor in the <a href="./index.php?option=com_installer&view=manage" target="_blank"><em>Extension Manager</em></a> and uninstall the "YEEditor" name and "Package" type item. </p>
    <br />
    <br />
    <p><strong>Install widget:</strong>
    <br />
    You should combine css to the widget.css file in the <a href="./index.php?option=com_yeeditor&view=option" target="_blank"><em>page</em></a> after install a new widget.
    </p>
</div>
<br />
<div style="text-align:center"><?php echo JText::_('COM_YEEDITOR_FIELD_YEEDITOR_GET_MORE');?> <a href="http://yeedeen.com/extensions/yeeditor" target="_blank">http://yeedeen.com/extensions/yeeditor</a></div>