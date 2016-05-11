<?php 
/*------------------------------------------------------------------------
# YETemplate
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

require_once JPATH_PLUGINS."/editors/yeeditor/define.php"; 
require_once YEEDITOR_COMPONENT_ADMIN_PATH.'helpers/theme.php';

$action=$_POST['action'];

if($action=="save"){
	$bootstrap_variables_arr = json_decode($_POST['bootstrap_variables_arr'],true);
	$bootstrap_variables = get_updated_less_content($bootstrap_variables_arr, 'Variables');
	file_put_contents(YEEDITOR_PATH.'assets/less/variables.less', $bootstrap_variables);
	
	$theme_variables_arr = json_decode($_POST['theme_variables_arr'],true);
	$theme_variables = get_updated_less_content($theme_variables_arr, 'YEEditor Theme');
	file_put_contents(YEEDITOR_PATH.'assets/less/yeeditor.theme.less', $theme_variables);
	
	echo true;
}
else if($action=="combine"){
	combine_less();
	echo true;
}

