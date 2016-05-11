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
class map_wgt_wysiwyg
{
	public function setting(){
		$return = 
		array( 
			"main"=>array(
			"yee_text_block"=>array(    
								"name"		=> "Text block",
								"base"		=> "yee_text_block",
								"group"     => "Editor",
								"icon"      => "yee-icon-text-block.jpg",
								"tabs"      => array(
												"setting-home"=>JText::_('YEEDITOR_WIDGET_TAB_HOME'),
												"setting-profile"=>JText::_('YEEDITOR_WIDGET_TAB_PROFILE')
								),
								"params"    => array(
												  array(
													"type"        => "content-editor",
													"main_content"=> true,
													"heading"     => "Content text",
													"param_name"  => "textblock_content",
													"value"       => "",
													"description" => ""
												  ),
												  array(
													"type"        => "dropdown",
													"heading"     => JText::_('YEEDITOR_WIDGET_CSS_ANIMATION'),
													"param_name"  => "css_animation",
													"value"       => "no",
													"option-value"=> array("no"=>"No","yee-top-to-bottom"=>"Top to bottom","yee-bottom-to-top"=>"Bottom to top","yee-left-to-right"=>"Left to right","yee-right-to-left"=>"Right to left","yee-appear"=>"Appear from center"),
													"description" => ""
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
													"type"        => "setting-wrapper",
													"tab"         => "setting-profile",
													"heading"     => JText::_('YEEDITOR_WIDGET_STYLING'),
													"child_params" => array(//rows
																	  "row1" => array(//columns
																				"columns1" => array(
																							  "width" => "1/2",
																							  "items" => array(//child params
																											array(
																												"type"        => "style-box",
																												"heading"     => "",
																												"param_name"  => "style_detail",
																												"value"       => "",
																												"description" => ''
																											)
																							  )
																				),
																				"columns2" => array(
																							  "width" => "1/2",
																							  "items" => array(//child params
																											array(
																												"type"        => "dropdown",
																												"heading"     => JText::_('YEEDITOR_WIDGET_THEME_OPTIONS'),
																												"param_name"  => "yee-widget-theme",
																												"value"       => "default",
																												"option-value"=> array("default"=>"Default Theme"),
																												"description" => JText::_('YEEDITOR_WIDGET_THEME_OPTIONS_DESC')
																											),
																											array(
																												"type"        => "color-picker",
																												"heading"     => JText::_('YEEDITOR_WIDGET_BORDER_COLOR'),
																												"param_name"  => "border_color",
																												"value"       => "",
																												"placeholder" => JText::_('YEEDITOR_WIDGET_BORDER_COLOR_PLACEHOLDER'),
																												"description" => ""
																											),
																											array(
																												"type"        => "radio",
																												"heading"     => "",
																												"param_name"  => "border",
																												"value"       => "none",
																												"option-value" => array("none"=>"none","dotted"=>"dotted","solid"=>"solid","bouble"=>"bouble","groove"=>"groove","ridge"=>"ridge","inset"=>"inset","outset"=>"outset","hidden"=>"hidden"),
																												"description" => ""
																											)
																							  )
																				 )
																	  )
													),
													"description" => ''	  
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