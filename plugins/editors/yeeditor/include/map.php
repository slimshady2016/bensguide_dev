<?php  
/*------------------------------------------------------------------------
# YEEditor - independent
# ------------------------------------------------------------------------
# author    YEEDEEN
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;

require_once YEEDITOR_PATH."include/functions_general.php";

class yeeMap
{  
   protected $yee_widget_extend=array();
   protected $yee_widget_parent_extend=array();
	 
   public function get_weidget($widgets_ex,&$widget_key_name){
      $return=array(
		"yee_row"=>array(    
					"name"		=> "Row",
					"base"		=> "yee_row",
					"model"		=> "all",
					"group"     => "Structure",
					"icon"      => YEEDITOR_URL."assets/img/wgt-icon-row.jpg",
					"tabs"      => array(
									"setting-home"=>JText::_('YEEDITOR_WIDGET_TAB_HOME'),
									"setting-profile"=>JText::_('YEEDITOR_WIDGET_TAB_PROFILE')
					),
					"params"    => array(
									  array(
											"type"        => "setting-wrapper_btn-group",
											"tab"         => "setting-home",
											"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_1_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "column-size",
																										"value"       => "md-column",
																										"option-value" => array("xs-column"=>"Extra Small Devices","sm-column"=>"Small Devices","md-column"=>"Medium Devices","lg-column"=>"Large Devices"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)
																					  )
																		)
															  )
															  
											 ),
											 "description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_1_DESC')				  
									  ),
									  array(
										"type"        => "radio",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_2_HEADING'),
										"param_name"  => "boxed_layout",
										"value"       => "yee-container-fluid",
										"option-value"=> array("yee-container-fluid"=>"Full Width <small>(Fluid)</small>","yee-container"=>"Fixed Width <small>(Boxed)</small>"),
										"description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_2_DESC')
									  ),
									  array(
										"type"        => "radio",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_3_HEADING'),
										"param_name"  => "padding_layout",
										"value"       => "",
										"option-value"=> array(""=>"Normal","yet-pad"=>"Extra Padding","yet-nopad"=>"No Padding"),
										"description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_3_DESC')
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
																									"param_name"  => "theme_options",
																									"value"       => "flattern",
																									"option-value"=> array("flattern"=>"Theme flattern","yetemplate"=>"YETemplate"),
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
										"type"        => "setting-wrapper",
										"tab"         => "setting-profile",
										"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND'),
										"child_params" => array(//rows
												 		  "row1" => array(//columns
																	"columns1" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "radio",
																									"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND_IMAGE_OPTIONS'),
																									"param_name"  => "background_image_options",
																									"value"       => "none",
																									"option-value"=> array("none"=>"None","full"=>"Full Width","fixed"=>"Fixed Width"),
																									"description" => ''
																								)
																				  )
																	),
																	"columns2" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "select_image",
																									"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND_IMAGE'),
																									"param_name"  => "background_image",
																									"value"       => "",
																									"description" => ""
																								)
																				  )
																	 )
														  ),
														  "row2" => array(//columns
																	"columns1" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "radio",
																									"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND_COLOR_OPTIONS'),
																									"param_name"  => "background_color_options",
																									"value"       => "none",
																									"option-value"=> array("none"=>"None","full"=>"Full Width","fixed"=>"Fixed Width"),
																									"description" => ''
																								)
																				   )
																	 ),
																	 "columns2" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "color-picker",
																									"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND_COLOR'),
																									"param_name"  => "background_color",
																									"value"       => "",
																									"placeholder" => JText::_('YEEDITOR_WIDGET_BACKGROUND_COLOR_PLACEHOLDER'),
																									"description" => ''
																								)
																				  )
																	 )
														  )
										),
										"description" => JText::_('YEEDITOR_WIDGET_BACKGROUND_DESC')	  
									  ),
									  array(
										"type"        => "radio",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_4_HEADING'),
										"param_name"  => "responsive_column_reset",
										"value"       => "no",
										"option-value"=> array("yes"=>"Yes","no"=>"No"),
										"description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_4_DESC')
									  ),
									  array(
										"type"        => "setting-wrapper",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_5_HEADING'),
										"child_params" => array(//rows
												 		  "row1" => array(//columns
																	"columns1" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "text",
																									"heading"     => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS'),
																									"param_name"  => "ex_class",
																									"value"       => "",
																									"placeholder" => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS_PLACEHOLDER'),
																									"description" => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS_DESC')
																								)
																				  )
																	),
																	"columns2" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "text",
																									"heading"     => JText::_('YEEDITOR_WIDGET_ID'),
																									"param_name"  => "id",
																									"value"       => "",
																									"description" => JText::_('YEEDITOR_WIDGET_ID_DESC')
																								)	
																				  )
																	 )
														  )
										),
										"description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_5_DESC')			  
									  ),
									  array(
										"type"        => "radio",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_VISIABLE'),
										"param_name"  => "visiable",
										"value"       => "1",
										"display"     => "none",
										"option-value"=> array("1"=>"show","0"=>"hide"),
										"description" => JText::_('YEEDITOR_WIDGET_VISIABLE_DESC')
									  )   
					)
		),			
		
		"yee_row_inner"=>array(    
					"name"		=> "Row inner",
					"base"		=> "yee_row_inner",
					"model"		=> "all",
					"group"     => "Structure",
					"icon"      => YEEDITOR_URL."assets/img/wgt-icon-row.jpg",
					"tabs"      => array(
									"setting-home"=>JText::_('YEEDITOR_WIDGET_TAB_HOME'),
									"setting-profile"=>JText::_('YEEDITOR_WIDGET_TAB_PROFILE')
					),
					"params"    => array(
									  array(
											"type"        => "setting-wrapper_btn-group",
											"tab"         => "setting-home",
											"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_1_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "column-size",
																										"value"       => "md-column",
																										"option-value" => array("xs-column"=>"Extra Small Devices","sm-column"=>"Small Devices","md-column"=>"Medium Devices","lg-column"=>"Large Devices"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)
																					  )
																		)
															  )
															  
											 ),
											 "description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_1_DESC')				  
									  ),
									  array(
										"type"        => "radio",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_2_HEADING'),
										"param_name"  => "boxed_layout",
										"value"       => "yee-container-fluid",
										"option-value"=> array("yee-container-fluid"=>"Full Width <small>(Fluid)</small>","yee-container"=>"Fixed Width <small>(Boxed)</small>"),
										"description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_2_DESC')
									  ),
									  array(
										"type"        => "radio",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_3_HEADING'),
										"param_name"  => "padding_layout",
										"value"       => "",
										"option-value"=> array(""=>"Normal","yet-pad"=>"Extra Padding","yet-nopad"=>"No Padding"),
										"description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_3_DESC')
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
																									"param_name"  => "theme_options",
																									"value"       => "flattern",
																									"option-value"=> array("flattern"=>"Theme flattern","yetemplate"=>"YETemplate"),
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
										"type"        => "setting-wrapper",
										"tab"         => "setting-profile",
										"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND'),
										"child_params" => array(//rows
												 		  "row1" => array(//columns
																	"columns1" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "radio",
																									"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND_IMAGE_OPTIONS'),
																									"param_name"  => "background_image_options",
																									"value"       => "none",
																									"option-value"=> array("none"=>"None","full"=>"Full Width","fixed"=>"Fixed Width"),
																									"description" => ''
																								)
																				  )
																	),
																	"columns2" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "select_image",
																									"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND_IMAGE'),
																									"param_name"  => "background_image",
																									"value"       => "",
																									"description" => ""
																								)
																				  )
																	 )
														  ),
														  "row2" => array(//columns
																	"columns1" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "radio",
																									"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND_COLOR_OPTIONS'),
																									"param_name"  => "background_color_options",
																									"value"       => "none",
																									"option-value"=> array("none"=>"None","full"=>"Full Width","fixed"=>"Fixed Width"),
																									"description" => ''
																								)
																				   )
																	 ),
																	 "columns2" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "color-picker",
																									"heading"     => JText::_('YEEDITOR_WIDGET_BACKGROUND_COLOR'),
																									"param_name"  => "background_color",
																									"value"       => "",
																									"placeholder" => JText::_('YEEDITOR_WIDGET_BACKGROUND_COLOR_PLACEHOLDER'),
																									"description" => ''
																								)
																				  )
																	 )
														  )
										),
										"description" => JText::_('YEEDITOR_WIDGET_BACKGROUND_DESC')	  
									  ),
									  array(
										"type"        => "radio",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_4_HEADING'),
										"param_name"  => "responsive_column_reset",
										"value"       => "no",
										"option-value"=> array("yes"=>"Yes","no"=>"No"),
										"description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_4_DESC')
									  ),
									  array(
										"type"        => "setting-wrapper",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_5_HEADING'),
										"child_params" => array(//rows
												 		  "row1" => array(//columns
																	"columns1" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "text",
																									"heading"     => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS'),
																									"param_name"  => "ex_class",
																									"value"       => "",
																									"placeholder" => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS_PLACEHOLDER'),
																									"description" => JText::_('YEEDITOR_WIDGET_EXTRA_CLASS_DESC')
																								)
																				  )
																	),
																	"columns2" => array(
																				  "width" => "1/2",
																				  "items" => array(//child params
																				  			 	array(
																									"type"        => "text",
																									"heading"     => JText::_('YEEDITOR_WIDGET_ID'),
																									"param_name"  => "id",
																									"value"       => "",
																									"description" => JText::_('YEEDITOR_WIDGET_ID_DESC')
																								)	
																				  )
																	 )
														  )
										),
										"description" => JText::_('YEEDITOR_WIDGET_ROW_OR_ROW_INNER_SEETING_5_DESC')			  
									  ),
									  array(
										"type"        => "radio",
										"tab"         => "setting-home",
										"heading"     => JText::_('YEEDITOR_WIDGET_VISIABLE'),
										"param_name"  => "visiable",
										"value"       => "1",
										"display"     => "none",
										"option-value"=> array("1"=>"show","0"=>"hide"),
										"description" => JText::_('YEEDITOR_WIDGET_VISIABLE_DESC')
									  )   
					)
		)
	);
	  
	  $yee_widget_ex=array();		  		
   	  foreach($widgets_ex as $widget_ex){
	      $class_name='map_'.$widget_ex;
	      $widget_class_ex=new $class_name;
		  $widget_setting=$widget_class_ex->setting();
		  $widget_key_name[key($widget_setting['main'])]=$widget_ex;
		  $return=array_merge($return,$widget_setting['main']);
		 
		  if(isset($widget_setting['extend'])){
			$this->yee_widget_parent_extend[key($widget_setting['main'])]=key($widget_setting['extend']);
			$this->yee_widget_extend=array_merge($this->yee_widget_extend,$widget_setting['extend']);
		  }	
	  }
	  
	  return $return;
   }
   
   public function get_widget_setting_extend(){
   	  return $this->yee_widget_extend;
   }
   
   public function get_widget_setting_parent_extend(){
   	  return $this->yee_widget_parent_extend;
   }
   
   public static function map_ex(){
		$return_ex=array(
			"yee_column"=>array(    
						"name"		=> "Column",
						"base"		=> "yee_column",
						"model"		=> "all",
						"group"     => "Structure",
						"icon"      => "",
						"params"    => array(
										  array(
												"type"        => "text",
												"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_1_HEADING'),
												"param_name"  => "width",
												"value"       => "1/1",
												"type_attrbute" => 'readonly="readonly"',
												"description" => ""
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_2_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																					  				array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "ors",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Override Row Setting"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									),
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "column-size",
																										"value"       => "md-column",
																										"option-value" => array("xs-column"=>"Extra Small Devices","sm-column"=>"Small Devices","md-column"=>"Medium Devices","lg-column"=>"Large Devices"),
																										"class"       => "yee-btn-xs column-size",
																										"description" => ""
																									)
																					  )
																		)
															  )
															  
											 ),
											 "description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_2_DESC')				  
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_3_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "xs-column",
																										"value"       => "0",
																										"option-value" => array("0"=>"Empty","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12"),
																										"class"       => "yee-btn-xs xs-column column-size-relate",
																										"description" => ""
																									),
																									array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "xs-hidden",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Hidden"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)	
																					  )
																		)
															  )
											 ),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_3_DESC')				  
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_4_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "sm-column",
																										"value"       => "0",
																										"option-value" => array("0"=>"Empty","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12"),
																										"class"       => "yee-btn-xs sm-column column-size-relate",
																										"description" => ""
																									),
																									array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "sm-hidden",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Hidden"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)
																					  )
																		)
															  )
											 ),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_4_DESC')				  
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_5_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "md-column",
																										"value"       => "0",
																										"option-value" => array("0"=>"Empty","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12"),
																										"class"       => "yee-btn-xs md-column column-size-relate",
																										"description" => ""
																									),
																									array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "md-hidden",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Hidden"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)
																					  )
																		)
															  )
											 ),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_5_DESC')				  
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_6_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "lg-column",
																										"value"       => "0",
																										"option-value" => array("0"=>"Empty","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12"),
																										"class"       => "yee-btn-xs lg-column column-size-relate",
																										"description" => ""
																									),
																									array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "lg-hidden",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Hidden"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)
																					  )
																		)
															  )
											 ),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_6_DESC')				  
										  ),
										  array(
											"type"        => "radio",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_7_HEADING'),
											"param_name"  => "hidden-print",
											"value"       => "visiable",
											"option-value" => array("visiable"=>"Visible Print","hidden"=>"Hidden Print"),
											"class"       => "yee-btn-xs",
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_7_DESC')
										  ),
										  array(
											"type"        => "setting-wrapper",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_8_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/2",
																					  "items" => array(//child params
																									array(
																										"type"        => "select_image",
																										"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_9_HEADING'),
																										"param_name"  => "background_image",
																										"value"       => "",
																										"description" => ""
																									)
																					  )
																		),
																		"columns2" => array(
																					  "width" => "1/2",
																					  "items" => array(//child params
																									array(
																										"type"        => "color-picker",
																										"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_10_HEADING'),
																										"param_name"  => "background_color",
																										"value"       => "",
																										"placeholder" => "Click here to select background color",
																										"description" => ''
																									)
																					  )
																		 )
															  )
											),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_8_DESC')	  
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
			),				
			
			"yee_column_inner"=>array(    
						"name"		=> "Column inner",
						"base"		=> "yee_column_inner",
						"model"		=> "all",
						"group"     => "Structure",
						"icon"      => "",
						"params"    => array(
										  array(
												"type"        => "text",
												"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_1_HEADING'),
												"param_name"  => "width",
												"value"       => "1/1",
												"type_attrbute" => 'readonly="readonly"',
												"description" => ""
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_2_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																					  				array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "ors",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Override Row Setting"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									),
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "column-size",
																										"value"       => "md-column",
																										"option-value" => array("xs-column"=>"Extra Small Devices","sm-column"=>"Small Devices","md-column"=>"Medium Devices","lg-column"=>"Large Devices"),
																										"class"       => "yee-btn-xs column-size",
																										"description" => ""
																									)
																					  )
																		)
															  )
															  
											 ),
											 "description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_2_DESC')				  
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_3_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "xs-column",
																										"value"       => "0",
																										"option-value" => array("0"=>"Empty","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12"),
																										"class"       => "yee-btn-xs xs-column column-size-relate",
																										"description" => ""
																									),
																									array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "xs-hidden",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Hidden"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)	
																					  )
																		)
															  )
											 ),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_3_DESC')				  
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_4_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "sm-column",
																										"value"       => "0",
																										"option-value" => array("0"=>"Empty","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12"),
																										"class"       => "yee-btn-xs sm-column column-size-relate",
																										"description" => ""
																									),
																									array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "sm-hidden",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Hidden"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)
																					  )
																		)
															  )
											 ),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_4_DESC')				  
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_5_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "md-column",
																										"value"       => "0",
																										"option-value" => array("0"=>"Empty","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12"),
																										"class"       => "yee-btn-xs md-column column-size-relate",
																										"description" => ""
																									),
																									array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "md-hidden",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Hidden"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)
																					  )
																		)
															  )
											 ),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_5_DESC')				  
										  ),
										  array(
											"type"        => "setting-wrapper_btn-group",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_6_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/1",
																					  "items" => array(//child params
																									array(
																										"type"        => "radio",
																										"heading"     => "",
																										"param_name"  => "lg-column",
																										"value"       => "0",
																										"option-value" => array("0"=>"Empty","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12"),
																										"class"       => "yee-btn-xs lg-column column-size-relate",
																										"description" => ""
																									),
																									array(
																										"type"        => "checkbox",
																										"heading"     => "",
																										"param_name"  => "lg-hidden",
																										"value"       => "",
																										"option-value" => array("value"=>"yes","title"=>"Hidden"),
																										"class"       => "yee-btn-xs",
																										"description" => ""
																									)
																					  )
																		)
															  )
											 ),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_6_DESC')				  
										  ),
										  array(
											"type"        => "radio",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_7_HEADING'),
											"param_name"  => "hidden-print",
											"value"       => "visiable",
											"option-value" => array("visiable"=>"Visible Print","hidden"=>"Hidden Print"),
											"class"       => "yee-btn-xs",
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_7_DESC')
										  ),
										  array(
											"type"        => "setting-wrapper",
											"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_8_HEADING'),
											"child_params" => array(//rows
															  "row1" => array(//columns
																		"columns1" => array(
																					  "width" => "1/2",
																					  "items" => array(//child params
																									array(
																										"type"        => "select_image",
																										"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_9_HEADING'),
																										"param_name"  => "background_image",
																										"value"       => "",
																										"description" => ""
																									)
																					  )
																		),
																		"columns2" => array(
																					  "width" => "1/2",
																					  "items" => array(//child params
																									array(
																										"type"        => "color-picker",
																										"heading"     => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_10_HEADING'),
																										"param_name"  => "background_color",
																										"value"       => "",
																										"placeholder" => "Click here to select background color",
																										"description" => ''
																									)
																					  )
																		 )
															  )
											),
											"description" => JText::_('YEEDITOR_WIDGET_COLUMN_OR_COLUMN_INNER_SEETING_8_DESC')	  
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
	  );
	  
	  return $return_ex;
   }
}	

//init widgets information
global $widgets_ex,$widget_group,$yee_widget,$yee_widget_extend,$widget_key_name,$yee_widget_parent_extend,$widgets_ex_path,$widgets_ex_frontend_path;
$widgets_ex_path = JPATH_ROOT."/administrator/components/com_yeeditor/widgets_ex/";
$widgets_ex_frontend_path = JPATH_ROOT."/components/com_yeeditor/widgets_ex/";

$database = JFactory::getDbo();
$sqlquery =  "select widget_name,widget_group from #__yeeditor_extensions where published=1 order by widget_name asc";
$database->setQuery( $sqlquery );
if (!$result = $database->query()) {
   echo $database->stderr();
   return false;
}
$result=$database->loadObjectList(); 

$widgets_ex=array();
foreach($result as $resultobj){
	if(is_dir($widgets_ex_path.$resultobj->widget_name)){
		$widget_setting_file = $widgets_ex_path.$resultobj->widget_name."/backend/setting/".$resultobj->widget_name.".php";
		if(file_exists($widget_setting_file)){
			$widgets_ex[]=$resultobj->widget_name;
			$widget_group[$resultobj->widget_name]=$resultobj->widget_group;
	
			//load widget language
			yee_load_language($resultobj->widget_name,YEEDITOR_COMPONENT_ADMIN_PATH."widgets_ex/".$resultobj->widget_name);
			
			require_once $widget_setting_file;
		}
	}
}	

//Load yeeditor plugin language
yee_load_language();

$map=new yeeMap;
$yee_widget=$map->get_weidget($widgets_ex,$widget_key_name);
$yee_widget_extend=$map->get_widget_setting_extend();
$yee_widget_parent_extend=$map->get_widget_setting_parent_extend();
