<?php
/*------------------------------------------------------------------------
# yeeditor_content - YEEditor
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
defined( '_JEXEC' ) or die;

class plgSystemYeeditor_content extends JPlugin
{
	public function onBeforeRender()
	{
		$app = JFactory::getApplication();
		if ($app->isAdmin()) {
			return;
		}
		
	}	
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
	    $app = JFactory::getApplication();
		if ($app->isAdmin()) {
			return;
		}
		
		require_once JPATH_PLUGINS."/editors/yeeditor/include/functions_frontend.php";

		if(JRequest::getVar('yeepreview',0)==1 && $context=='com_content.article'){
			$form_post = JRequest::get('post');
			$article->text = isset($form_post['jform']['articletext'])?$form_post['jform']['articletext']:'';
		}
		
		$article->text = get_yeeditor_translated_html($article->text);
	}
	
}
