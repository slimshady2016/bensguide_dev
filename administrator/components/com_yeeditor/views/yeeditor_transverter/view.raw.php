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

defined('_JEXEC') or die;

require_once JPATH_PLUGINS."/editors/yeeditor/define.php";
require_once YEEDITOR_PATH."include/map.php";
require_once YEEDITOR_PATH."include/functions.php";

jimport( 'joomla.application.component.view');

class YeeditorViewYeeditor_transverter extends JViewLegacy
{
    function display($tpl = null)
    {
        parent::display($tpl);
    }
}