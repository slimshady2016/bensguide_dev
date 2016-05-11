<?php
/*------------------------------------------------------------------------
# yeeditor - YEEditor
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
//faq widget setting
class map_wgt_additional_js
{
	public function setting(){
		$return = 
		array( 
			"main"=>array(
			"yee_additional_js"=>array(    
								"name"		=> "Additional JS",
								"base"		=> "yee_additional_js",
								"group"     => "Social",
								"icon"      => "yee-icon-additional-js.jpg",
								"tabs"      => array(
												"setting-home"=>JText::_('YEEDITOR_WIDGET_TAB_HOME'),
												"setting-profile"=>JText::_('YEEDITOR_WIDGET_TAB_PROFILE')
								),
								"params"    => array(
												  array(
													"type"        => "code_mirror",
													"main_content"=> true,
													"inner_type"  => "text/javascript",
													"heading"     => JText::_('YEEDITOR_WIDGET_ADDITIONAL_JS_SEETING_1_HEADING'),
													"param_name"  => "js_code",
													"value"       => "",
													"description" => JText::_('YEEDITOR_WIDGET_ADDITIONAL_JS_SEETING_1_DESC')
												  ),
												  array(
													"type"        => "text",
													"heading"     => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS'),
													"param_name"  => "ex_class",
													"value"       => "",
													"placeholder" => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS_PLACEHOLDER'),
													"description" => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS_DESC')
												  ),
												  array(
													"type"        => "radio",
													"heading"     => JText::_('YEEDITOR_WIDGET_VISIABLE'),
													"param_name"  => "visiable",
													"value"       => "1",
													"display"     => "none",
													"option-value"=> array("1"=>"show","0"=>"hide"),
													"description" => JText::_('YEEDITOR_WIDGET_VISIABLE_DESC')
												  )
											  )
					           )
					)
		);		
		return $return;				
	}							
}					