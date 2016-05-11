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

class YeeditorTableExtension extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__yeeditor_extensions', 'id', $db);
	}
}
