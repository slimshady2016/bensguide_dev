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

require_once JPATH_PLUGINS."/editors/yeeditor/define.php";
require_once YEEDITOR_PATH."include/map.php";
require_once YEEDITOR_PATH."include/functions.php";

function get_yeeditor_translated_html($content){
	$yeecontent=displayYeeditorContent_frontend($content);
		
	$result = $content;	
	if($yeecontent[0]){
		$result = str_replace($yeecontent[0],$yeecontent[1],$content);

		$result ='<div class="yeeditor">'.$result.'</div>';
	}
	return $result;
}

function displayYeeditorContent_frontend($content){
	//load assets
	yeeditor_load_frontend_assets();

	global $yee_widget;
	$elements_arr=$yee_widget;
	$elements_arr_ex=yeeMap::map_ex();
	global $widget_num;
	$widget_num = 0;
	
	$preg_str="";
	
	foreach($elements_arr as $key=>$element_value_temp)
		  $preg_str = $preg_str?($preg_str.'|'.$key):($key);
	
	//row
	$rows_html=array();
	$row_html="";
	preg_match_all('/\[yee_row[\s\]][\s\S]+?\[\/yee_row]/i',$content,$rows); 
	
	$arr=array("1/12"=>1,"1/6"=>2,"2/12"=>2,"1/5"=>"2-4","1/4"=>3,"2/8"=>3,"3/12"=>3,"1/3"=>4,"2/6"=>4,"3/9"=>4,"4/12"=>4,"5/12"=>5,"1/2"=>6,"2/4"=>6,"3/6"=>6,"4/8"=>6,"6/12"=>6,"7/12"=>7,"2/3"=>8,"4/6"=>8,"6/9"=>8,"8/12"=>8,"3/4"=>9,"6/8"=>9,"9/12"=>9,"5/6"=>10,"10/12"=>10,"11/12"=>11,"1/1"=>12,"12/12"=>12);

	foreach($rows[0] as $row){
		$column_html="";
		$column_partition="";
		
		//get the row setting
		$row_setting = get_element_setting('yee_row',$row,$elements_arr);
		
		if($row_setting['visiable'] == 0){
			continue;
		}
		
		//column
		preg_match_all('/\[yee_column[\s\]][\s\S]*?\[\/yee_column]/i',$row,$columns);	
		$column_space_count = array("xs"=>0,"sm"=>0,"md"=>0,"lg"=>0);
		foreach($columns[0] as $column){
			//get the inner column setting
		    $column_setting = get_element_setting('yee_column',$column,$elements_arr_ex);
		
			//rows inner and elements
			$rows_inner_and_elements_html="";
			if(preg_match_all('/(\[\b('.$preg_str.')\b[\s\]][\s\S]*?\[\/\b\2\b[\s\]])/i',$column,$rows_inner_and_elements,PREG_PATTERN_ORDER)){
				if($column_setting['visiable'] != 0){
					//echo "<pre>";print_r($rows_inner_and_elements);echo "</pre>";
					foreach($rows_inner_and_elements[2] as $rows_inner_and_elements_num => $row_inner_and_element_key){
						
						//get row inner
						if($row_inner_and_element_key=="yee_row_inner"){
							$column_inner_partition="";
							$row_inner=$rows_inner_and_elements[1][$rows_inner_and_elements_num];
							$column_inner_html="";
							
							//get the inner row setting
							$row_inner_setting = get_element_setting('yee_row_inner',$row_inner,$elements_arr);
							
							if($row_inner_setting['visiable'] == 0){
								continue;
							}
							
							//columns inner
							preg_match_all('/\[yee_column_inner[\s\]][\s\S]*?\[\/yee_column_inner]/i',$row_inner,$columns_inner);
							$column_inner_space_count = array("xs"=>0,"sm"=>0,"md"=>0,"lg"=>0);
							foreach($columns_inner[0] as $column_inner){
							   //get the inner column setting
							   $column_inner_setting = get_element_setting('yee_column_inner',$column_inner,$elements_arr_ex);
								
							   //get the inner elements
							   $elements_inner_html="";
							   if($column_inner_setting['visiable'] != 0){
								   if(preg_match_all('/(\[\b('.$preg_str.')\b[\s\]][\s\S]*?\[\/\b\2\b[\s\]])/i',$column_inner,$elements_inner,PREG_PATTERN_ORDER)){
										$i=0;
										foreach( $elements_inner[2] as $element_inner_key){
												$element_shortcode=$elements_inner[1][$i];
												
												$element_setting = get_element_setting($element_inner_key,$element_shortcode,$elements_arr);
												
												if(isset($element_setting['visiable']) && $element_setting['visiable'] == 0){
													continue;
												}
												
												$elements_inner_html .= '                        '.get_element_frontend_html($element_inner_key,$element_setting,$element_shortcode);					
												$i++;
										}		
								   }
							   }
	
							   //get the inner column attribute
							   $column_inner_partition_single=$column_inner_setting['width'];
							   $column_inner_attrs['width']=$column_inner_setting['width']?($arr[$column_inner_setting['width']]):12;
							   $column_inner_partition = $column_inner_partition?$column_inner_partition." + ".$column_inner_partition_single:$column_inner_partition_single;
							   
							   $column_inner_size = $column_inner_setting['ors']=='yes'?$column_inner_setting['column-size']:$row_inner_setting['column-size'];
							   
							   //column_inner_class
							   $column_inner_class = '';
							   $column_inner_html_start = '';
							   $column_inner_html_end = '';
							   $column_inner_size_arr = array("xs","sm","md","lg");
							   
							   switch($column_inner_size){
									case 'xs-column':
										$column_inner_class = 'yee-col-xs-'.$column_inner_attrs['width'];
										break;
									case 'sm-column':
										$column_inner_class = 'yee-col-sm-'.$column_inner_attrs['width'];
										break;
									case 'md-column':
										$column_inner_class = 'yee-col-md-'.$column_inner_attrs['width'];
										break;
									case 'lg-column':
										$column_inner_class = 'yee-col-lg-'.$column_inner_attrs['width'];
										break;		
							   }
							   
							   foreach($column_inner_size_arr as $column_inner_prefix){
							   	   //clearfix
								   $column_inner_space = intval($column_inner_setting[$column_inner_prefix."-column"]);
								   if($column_inner_size == $column_inner_prefix."-column"){
										$column_inner_space = intval($column_inner_attrs['width']);
								   }
								   $column_inner_space = $column_inner_space==0?12:$column_inner_space;
								   $column_inner_space_count[$column_inner_prefix] += $column_inner_space; 
								   if($column_inner_space_count[$column_inner_prefix] > 12 ){
										$column_inner_html_start .= " visible-".$column_inner_prefix;
										$column_inner_space_count[$column_inner_prefix] = 0;
								   }
								   else if($column_inner_space_count[$column_inner_prefix] == 12 ){
								   		$column_inner_html_end .= " visible-".$column_inner_prefix;
										$column_inner_space_count[$column_inner_prefix] = 0;
								   }
								   //column class
								   if($column_inner_setting[$column_inner_prefix."-column"] && $column_inner_size != $column_inner_prefix."-column"){
										$column_inner_class .= " yee-col-".$column_inner_prefix."-".$column_inner_setting[$column_inner_prefix."-column"];
								   }
								   //column size hidden
								   if($column_inner_setting[$column_inner_prefix."-hidden"] == 'yes'){
										$column_inner_class .= " yee-hidden-".$column_inner_prefix;
								   } 
							   }
							   //clearfix
							   if($row_inner_setting['responsive_column_reset']=="yes"){
								   if($column_inner_html_start){
										$column_inner_html_start = "\n".'                      <div class="clearfix'.$column_inner_html_start.'"></div>';
								   }
								   if($column_inner_html_end){
										$column_inner_html_end = "\n".'                      <div class="clearfix'.$column_inner_html_end.'"></div>';
								   }
							   }
							   else{
							   		$column_inner_html_start = '';
									$column_inner_html_end = '';
							   }
							   
							   //print hidden
							   if($column_inner_setting['hidden-print'] == 'hidden'){
									$column_inner_class .= ' yee-hidden-print';
							   }
							   
							   $ex_class = ($column_inner_class?' ':'').$column_inner_setting['ex_class'];
							   $column_inner_class .= $ex_class;
							   //end column_inner_class
					
							   //column_inner_style
							   $column_inner_style = $column_inner_setting['background_image']?"background:url('".$column_inner_setting['background_image']."');":"";
							   $column_inner_style = $column_inner_setting['background_color']?"background-color:".$column_inner_setting['background_image'].";":"";
							   if($column_inner_style){
									$column_inner_style = ' style="'.$column_inner_style.'"';
							   }
							   //end column_inner_style
							   
							  					   
							   $column_inner_html .= $column_inner_html_start."\n".
											   '                      <div'.($column_inner_class?' class="'.$column_inner_class.'"':'').$column_inner_style.'>'."\n".
											   ($elements_inner_html?$elements_inner_html:'').
											   '                      </div>'.$column_inner_html_end;			   
							 	 	   
							}//end columns inner
							
							//row inner html
							$row_inner_start="";
							$row_inner_start_background="";
							$row_inner_end="";
							$row_inner_end_background="";
							$row_inner_class="";
							$section_style = "";
							$container_style = "";
							$none_style = "";
							$row_inner_id = $row_inner_setting['id']?' id="'.$row_inner_setting['id'].'"':'';
							
							//class
							if($row_inner_setting['padding_layout']){
								$row_inner_class .= ($row_inner_class?' ':'').$row_inner_setting['padding_layout'];
							}
							$row_inner_class .= ($row_inner_class?' ':'').$row_inner_setting['theme_options'];
							$ex_class = ($row_inner_class?' ':'').$row_inner_setting['ex_class'];
							$row_inner_class .= $ex_class;
							
							//styling
							$style_box = json_decode(base64_decode($row_inner_setting['style_detail']),true);
							//margin
							$margin_str = '';
							if($style_box['margin_linked']){
								if($style_box['margin_top'] != ""){
									$margin_str .=  $style_box['margin_top']."px";
								}
							}
							else{
								if($style_box['margin_top'] != ""){
									$margin_str .=  $style_box['margin_top']."px ";
								}
								if($style_box['margin_right'] != ""){
									$margin_str .=  $style_box['margin_right']."px ";
								}
								if($style_box['margin_bottom'] != ""){
									$margin_str .=  $style_box['margin_bottom']."px ";
								}
								if($style_box['margin_left'] != ""){
									$margin_str .=  $style_box['margin_left']."px";
								}
							}
							$margin_str = $margin_str?'margin:'.$margin_str.';':'';
							//padding
							$padding_str = '';
							if($style_box['padding_linked']){
								if($style_box['padding_top'] != ""){
									$padding_str .=  $style_box['padding_top']."px";
								}
							}
							else{
								if($style_box['padding_top'] != ""){
									$padding_str .=  $style_box['padding_top']."px ";
								}
								if($style_box['padding_right'] != ""){
									$padding_str .=  $style_box['padding_right']."px ";
								}
								if($style_box['padding_bottom'] != ""){
									$padding_str .=  $style_box['padding_bottom']."px ";
								}
								if($style_box['padding_left'] != ""){
									$padding_str .=  $style_box['padding_left']."px";
								}
							}
							$padding_str = $padding_str?'padding:'.$padding_str.';':'';
							//border
							$border_str = '';
							if($style_box['border_linked']){
								if($style_box['border_top'] != ""){
									$border_str .=  $style_box['border_top']."px ";
								}
							}
							else{
								if($style_box['border_top'] != ""){
									$border_str .=  $style_box['border_top']."px ";
								}
								if($style_box['border_right'] != ""){
									$border_str .=  $style_box['border_right']."px ";
								}
								if($style_box['border_bottom'] != ""){
									$border_str .=  $style_box['border_bottom']."px ";
								}
								if($style_box['border_left'] != ""){
									$border_str .=  $style_box['border_left']."px ";
								}
							}
							if($row_inner_setting['border'] && $row_inner_setting['border']!="none"){
								$border_str .= $row_inner_setting['border'].' ';
							}
							if($row_inner_setting['border_color']){
								$border_str .= $row_inner_setting['border_color'];
							}
							$border_str = $border_str?'border:'.$border_str.';':'';
							$section_style .= $margin_str.$padding_str.$border_str;
							
							//image
							$row_inner_image = $row_inner_setting['background_image']?"background:url('".$row_inner_setting['background_image']."');":"";
							switch($row_inner_setting['background_image_options']){
								case 'full':
									$section_style .= $row_inner_image;
									break;
								case 'fixed':
									$container_style .= $row_inner_image;
									break;
								default:
									break;		
							}
							//color
							$row_inner_color = $row_inner_setting['background_color']?"background-color:".$row_inner_setting['background_color'].";":"";
							switch($row_inner_setting['background_color_options']){
								case 'full':
									$section_style .= $row_inner_color;
									break;
								case 'fixed':
									$container_style .= $row_inner_color;
									break;
								default:
									break;		
							}
							
							$none_style = $section_style.$container_style;
							if($section_style){
								$section_style = ' style="'.$section_style.'"';
							}
							if($container_style){
								$container_style = ' style="'.$container_style.'"';
							}
							if($none_style){
								$none_style = ' style="'.$none_style.'"';
							}
							
							
							$row_inner_start .= $row_inner_start_background .
										'            <div'.($row_inner_class?' class="'.$row_inner_class.'"':'').$row_inner_id.$section_style.'>'."\n".
										'            	<div class="'.$row_inner_setting['boxed_layout'].'"'.$container_style.'>'."\n".
										'            		<div class="yee-row">';
													
							$row_inner_end .= "\n".
										'            		</div>'."\n".		
										'            	</div>'."\n".
										'            </div>'."\n".$row_inner_end_background;
							
							
							$rows_inner_and_elements_html .= $row_inner_start.$column_inner_html.$row_inner_end;
							
							//end row inner html								
						}//end row inner	
						else{
							//get element
							$element_shortcode=$rows_inner_and_elements[1][$rows_inner_and_elements_num]; //element shortcode
							
							$element_setting = get_element_setting($row_inner_and_element_key,$element_shortcode,$elements_arr);
							
							if(isset($element_setting['visiable']) && $element_setting['visiable'] == 0){
								continue;
							}
							
							$rows_inner_and_elements_html .= '            '.get_element_frontend_html($row_inner_and_element_key,$element_setting,$element_shortcode);
							
						}//end element			
					}
				}
			}//end rows inner and elements

		   //get the column attribute
		   $column_partition_single=$column_setting['width'];
		   $column_attrs['width']=$column_setting['width']?($arr[$column_setting['width']]):12;
		   $column_partition = $column_partition?$column_partition." + ".$column_partition_single:$column_partition_single;
		   
		   $column_size = $column_setting['ors']=='yes'?$column_setting['column-size']:$row_setting['column-size'];
		   
		   //column_class
		   $column_class = '';
		   $column_html_start = '';
		   $column_html_end = '';
		   $column_size_arr = array("xs","sm","md","lg");
		   
		   switch($column_size){
		   		case 'xs-column':
					$column_class = 'yee-col-xs-'.$column_attrs['width'];
					break;
				case 'sm-column':
					$column_class = 'yee-col-sm-'.$column_attrs['width'];
					break;
				case 'md-column':
					$column_class = 'yee-col-md-'.$column_attrs['width'];
					break;
				case 'lg-column':
					$column_class = 'yee-col-lg-'.$column_attrs['width'];
					break;		
		   }
		   
		   foreach($column_size_arr as $column_prefix){
		   	   //clearfix
			   $column_space = intval($column_setting[$column_prefix."-column"]);
			   if($column_size == $column_prefix."-column"){
			   		$column_space = intval($column_attrs['width']);
			   }

			   //$column_space = $column_space==0?12:$column_space;
			   $column_space_count[$column_prefix] += $column_space;
		   	   if($column_space_count[$column_prefix] > 12 ){
					$column_html_start .= " visible-".$column_prefix;
					$column_space_count[$column_prefix] = 0;	
			   }
			   else if($column_space_count[$column_prefix] == 12 ){
					$column_html_end .= " visible-".$column_prefix;
					$column_space_count[$column_prefix] = 0;
			   }
			   //column class				   
		   	   if($column_setting[$column_prefix."-column"] && $column_size != $column_prefix."-column"){
					$column_class .= " yee-col-".$column_prefix."-".$column_setting[$column_prefix."-column"];
			   }
			   //column size hidden
			   if($column_setting[$column_prefix."-hidden"] == 'yes'){
					$column_class .= " yee-hidden-".$column_prefix;
			   }
		   }
		   //clearfix
		   if($row_setting['responsive_column_reset']=="yes"){
			   if($column_html_start){
					$column_html_start = "\n".'          <div class="clearfix'.$column_html_start.'"></div>';
			   }
			   if($column_html_end){
					$column_html_end = "\n".'          <div class="clearfix'.$column_html_end.'"></div>';
			   }
		   }
		   else{
				$column_html_start = '';
				$column_html_end = '';
		   }
		   //print hidden
		   if($column_setting['hidden-print'] == 'hidden'){
				$column_class .= ' yee-hidden-print';
		   }
		   
		   $ex_class = ($column_class?' ':'').$column_setting['ex_class'];
		   $column_class .= $ex_class;
		   //end column_class

		   //column_style
		   $column_style = $column_setting['background_image']?"background:url('".$column_setting['background_image']."');":"";
		   $column_style = $column_setting['background_color']?"background-color:".$column_setting['background_image'].";":"";
		   if($column_style){
		   		$column_style = ' style="'.$column_style.'"';
		   }
		   //end column_style
		   
		   $column_html .= $column_html_start."\n".
						   '          <div'.($column_class?' class="'.$column_class.'"':'').$column_style.'>'."\n".
						   ($rows_inner_and_elements_html?$rows_inner_and_elements_html:'').
						   '          </div>'.$column_html_end;		   
		   		 
		}//end columns
		
		//row html
		$row_start = "";
		$row_start_background = "";
		$row_end = "";
		$row_end_background = "";
		$row_class = "";
		$section_style = "";
		$container_style = "";
		$none_style = "";
		$row_id = $row_setting['id']?' id="'.$row_setting['id'].'"':'';
		
		//row_class
		if($row_setting['padding_layout']){
			$row_class .= ($row_class?' ':'').$row_setting['padding_layout'];
		}
		$row_class .= ($row_class?' ':'').$row_setting['theme_options'];
		$ex_class = ($row_class?' ':'').$row_setting['ex_class'];
		$row_class .= $ex_class;
		
		//styling
		$style_box = json_decode(base64_decode($row_setting['style_detail']),true);
		//margin
		$margin_str = '';
		if($style_box['margin_linked']){
			if($style_box['margin_top'] != ""){
				$margin_str .=  $style_box['margin_top']."px";
			}
		}
		else{
			if($style_box['margin_top'] != ""){
				$margin_str .=  $style_box['margin_top']."px ";
			}
			if($style_box['margin_right'] != ""){
				$margin_str .=  $style_box['margin_right']."px ";
			}
			if($style_box['margin_bottom'] != ""){
				$margin_str .=  $style_box['margin_bottom']."px ";
			}
			if($style_box['margin_left'] != ""){
				$margin_str .=  $style_box['margin_left']."px";
			}
		}
		$margin_str = $margin_str?'margin:'.$margin_str.';':'';
		//padding
		$padding_str = '';
		if($style_box['padding_linked']){
			if($style_box['padding_top'] != ""){
				$padding_str .=  $style_box['padding_top']."px";
			}
		}
		else{
			if($style_box['padding_top'] != ""){
				$padding_str .=  $style_box['padding_top']."px ";
			}
			if($style_box['padding_right'] != ""){
				$padding_str .=  $style_box['padding_right']."px ";
			}
			if($style_box['padding_bottom'] != ""){
				$padding_str .=  $style_box['padding_bottom']."px ";
			}
			if($style_box['padding_left'] != ""){
				$padding_str .=  $style_box['padding_left']."px";
			}
		}
		$padding_str = $padding_str?'padding:'.$padding_str.';':'';
		//border
		$border_str = '';
		if($style_box['border_linked']){
			if($style_box['border_top'] != ""){
				$border_str .=  $style_box['border_top']."px ";
			}
		}
		else{
			if($style_box['border_top'] != ""){
				$border_str .=  $style_box['border_top']."px ";
			}
			if($style_box['border_right'] != ""){
				$border_str .=  $style_box['border_right']."px ";
			}
			if($style_box['border_bottom'] != ""){
				$border_str .=  $style_box['border_bottom']."px ";
			}
			if($style_box['border_left'] != ""){
				$border_str .=  $style_box['border_left']."px ";
			}
		}
		if($row_setting['border'] && $row_setting['border']!="none"){
			$border_str .= $row_setting['border'].' ';
		}
		if($row_setting['border_color']){
			$border_str .= $row_setting['border_color'];
		}
		$border_str = $border_str?'border:'.$border_str.';':'';
		$section_style .= $margin_str.$padding_str.$border_str;
		
		//image
		$row_image = $row_setting['background_image']?"background:url('".$row_setting['background_image']."');":"";
		switch($row_setting['background_image_options']){
			case 'full':
				$section_style .= $row_image;
				break;
			case 'fixed':
				$container_style .= $row_image;
				break;
			default:
				break;		
		}
		//color
		$row_color = $row_setting['background_color']?"background-color:".$row_setting['background_color'].";":"";
		switch($row_setting['background_color_options']){
			case 'full':
				$section_style .= $row_color;
				break;
			case 'fixed':
				$container_style .= $row_color;
				break;
			default:
				break;		
		}
		
		$none_style = $section_style.$container_style;
		if($section_style){
			$section_style = ' style="'.$section_style.'"';
		}
		if($container_style){
			$container_style = ' style="'.$container_style.'"';
		}
		if($none_style){
			$none_style = ' style="'.$none_style.'"';
		}
		

		$row_start .= $row_start_background .
'<div'.($row_class?' class="'.$row_class.'"':'').$row_id.$section_style.'>
    <div class="'.$row_setting['boxed_layout'].'"'.$container_style.'>
		<div class="yee-row">';
			
	  	$row_end .= '
		</div>		
	</div> 
</div>'.$row_end_background;
		
		$row_html = $row_start.$column_html.$row_end;
		//end row html
		
		$rows_html[]=$row_html;
	}//end rows
	
	$yeecontent[0]=$rows[0];
	$yeecontent[1]=$rows_html;

	return $yeecontent;
}
function get_element_frontend_html($element_key,$element_setting,$element_shortcode=""){
	global $widget_key_name,$widgets_ex_frontend_path,$widget_num;
	$widget_num++;
	//get widget style
	$widget_style=isset($element_setting['yee-widget-theme'])?($element_setting['yee-widget-theme']?$element_setting['yee-widget-theme']:"default"):"default";
	//get template name
	$joomla_template_name   = JFactory::getApplication()->getTemplate(true)->template;
	//widget name
	$widget_name=$widget_key_name[$element_key];
	
	$widget_url = YEEDITOR_COMPONENT_URL.'widgets_ex/'.$widget_name."/";
	$path = $widgets_ex_frontend_path.$widget_name."/frontend/".$widget_style."/html/".$widget_name.".php";
	if(file_exists(JPATH_ROOT."/templates/".$joomla_template_name."/html/com_yeeditor/widgets_ex/".$widget_name."/frontend/".$widget_style."/html/".$widget_name.".php")){
		$widget_url = JURI::root()."/templates/".$joomla_template_name."/html/com_yeeditor/widgets_ex/".$widget_name."/";
		$path = JPATH_ROOT."/templates/".$joomla_template_name."/html/com_yeeditor/widgets_ex/".$widget_name."/frontend/".$widget_style."/html/".$widget_name.".php";
	}
	
	$arg = array(
		"widget_num" => $widget_num,
		"widget_name" => $widget_name,
		"widget_url" => $widget_url
	);
	$item_params = array("element_setting"=>$element_setting,"element_shortcode"=>$element_shortcode,"arg"=>$arg);
	
	$element_html = get_element_html($path,$item_params);
    return $element_html;
}

function get_items_frontend_html($item_key,$content_shortcode){
	global $yee_widget,$yee_widget_extend;
	$elements_arr=$yee_widget;
	$return=array();
	$return_num=0;
	$preg_str="";
	$item_arr=$yee_widget_extend;
	$item_params=$item_arr[$item_key]['params'];
	
	foreach($elements_arr as $key=>$element_value_temp)
		  $preg_str = $preg_str?($preg_str.'|'.$key):($key);
	
	preg_match_all('/\['.$item_key.'[\s\]][\s\S]*?\[\/'.$item_key.']/i',$content_shortcode,$items_shortcodes);
	foreach($items_shortcodes[0] as $items_shortcode){
		$params_html="";
		
		$item_setting=get_element_setting($item_key,$items_shortcode,$item_arr);
		
		foreach($item_params as $param){
			$return[$return_num][$param['param_name']]=$item_setting[$param['param_name']];
		}	
	
		$item_html='';
		if(preg_match_all('/(\[\b('.$preg_str.')\b[\s\]][\s\S]*?\[\/\b\2\b[\s\]])/i',$items_shortcode,$element_shortcodes,PREG_PATTERN_ORDER)){
			$i=0;
			foreach( $element_shortcodes[2] as $element_key){		
					$item_html .= get_item_frontend_html($preg_str,$element_shortcodes[1][$i],$elements_arr);					
					$i++;
			}	
		}
		$item_html .= $params_html;
		$return[$return_num]['html']=$item_html;
		$return_num++;
	}
	
	return $return;
}

function get_item_frontend_html($preg_str,$item_shortcode,$elements_arr){
	global $widget_num;
	$arr=array("1/12"=>1,"1/6"=>2,"2/12"=>2,"1/5"=>"2-4","1/4"=>3,"2/8"=>3,"3/12"=>3,"1/3"=>4,"2/6"=>4,"3/9"=>4,"4/12"=>4,"5/12"=>5,"1/2"=>6,"2/4"=>6,"3/6"=>6,"4/8"=>6,"6/12"=>6,"7/12"=>7,"2/3"=>8,"4/6"=>8,"6/9"=>8,"8/12"=>8,"3/4"=>9,"6/8"=>9,"9/12"=>9,"5/6"=>10,"10/12"=>10,"11/12"=>11,"1/1"=>12,"12/12"=>12);
		
	//rows inner and elements
	$rows_inner_and_elements_html="";
	if(preg_match_all('/(\[\b('.$preg_str.')\b[\s\]][\s\S]*?\[\/\b\2\b[\s\]])/i',$item_shortcode,$rows_inner_and_elements,PREG_PATTERN_ORDER)){
		foreach($rows_inner_and_elements[2] as $rows_inner_and_elements_num => $row_inner_and_element_key){
		
			//get row inner
			if($row_inner_and_element_key=="yee_row_inner"){
				$column_inner_partition="";
				$row_inner=$rows_inner_and_elements[1][$rows_inner_and_elements_num];
				$column_inner_html="";
				//get the inner row attribute
				preg_match('/\[yee_row_inner\s.*?ex_class="(.*?)"[\s\S]*?]/',$row_inner,$row_inner_attr_value);
				$row_inner_attrs['ex_class']=$row_inner_attr_value?$row_inner_attr_value[1]:"";
				
				//column inner
				preg_match_all('/\[yee_column_inner[\s\]][\s\S]*?\[\/yee_column_inner]/i',$row_inner,$columns_inner);
				foreach($columns_inner[0] as $column_inner){
				   //get the inner column attribute
				   preg_match('/\[yee_column_inner\s.*?width="(.*?)"[\s\S]*?]/',$column_inner,$column_inner_attr_value);
				   $column_inner_partition_single=$column_inner_attr_value?$column_inner_attr_value[1]:'1/1';
				   $column_inner_attrs['width']=$column_inner_attr_value?($arr[trim($column_inner_partition_single)]):12;
				   $column_inner_partition = $column_inner_attr_value?($column_inner_partition?$column_inner_partition." + ".$column_inner_partition_single:$column_inner_partition_single):$column_inner_partition;
				   
				   preg_match('/\[yee_column_inner\s.*?ex_class="(.*?)"[\s\S]*?]/',$column_inner,$column_inner_attr_value);
				   $column_inner_attrs['ex_class']=$column_inner_attr_value?$column_inner_attr_value[1]:"";
				   //get the inner elements
				   $elements_inner_html="";
				   if(preg_match_all('/(\[\b('.$preg_str.')\b[\s\]][\s\S]*?\[\/\b\2\b[\s\]])/i',$column_inner,$elements_inner,PREG_PATTERN_ORDER)){
						$i=0;
						foreach( $elements_inner[2] as $element_inner_key){
								$element_shortcode=$elements_inner[1][$i];
								
								$element_setting = get_element_setting($element_inner_key,$element_shortcode,$elements_arr);
								
								if(isset($element_setting['visiable']) && $element_setting['visiable'] == 0){
									continue;
								}
								
								$elements_inner_html .= get_element_frontend_html($element_inner_key,$element_setting,$element_shortcode);					
								$i++;
						}		
				   }
				   
				   $column_inner_html .= '
						 <div class="yee-col-xs-'.$column_inner_attrs['width'].($column_inner_attrs['ex_class']?' '.$column_inner_attrs['ex_class']:'').'">'.
							   $elements_inner_html
					   .'</div>';
				}
				$rows_inner_and_elements_html .= '
						<div class="yee-row'.($row_inner_attrs['ex_class']?' '.$row_inner_attrs['ex_class']:'').'">
							'.
								$column_inner_html
						  .'
						</div>';
			}	
			else{
				//get element
				$element_shortcode=$rows_inner_and_elements[1][$rows_inner_and_elements_num]; //element shortcode
				
				$element_setting = get_element_setting($row_inner_and_element_key,$element_shortcode,$elements_arr);
				
				if(isset($element_setting['visiable']) && $element_setting['visiable'] == 0){
					continue;
				}
				
				$rows_inner_and_elements_html .= get_element_frontend_html($row_inner_and_element_key,$element_setting,$element_shortcode);	
			}			
		}
	}//end rows inner and elements
	
	return $rows_inner_and_elements_html;
}

function yeeditor_load_frontend_assets(){
	/***************** add assets start **************/
	//add css/js
	$yeedito_options['font_awesome'] = get_yeeditor_option('yeeditor_load_font_awesome');
	$yeedito_options['which_jquery_to_load'] = get_yeeditor_option('yeeditor_load_jquery_backend');
	
	$root=JURI::root();
	$document =JFactory::getDocument();
	//css
	if(JFactory::getApplication()->input->get('yee-bootstrap-css') == false){
		JFactory::getApplication()->input->set('yee-bootstrap-css', true);
		$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/yeeditor.frontend.css');
	}	

	if($yeedito_options['font_awesome']!=0){	
		//font-awesome 
		$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/font-awesome.min.css'); 
	}
	
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/css_animation.css');	
		
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/docs-row.css');	
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/docs-frontend.css');	
	
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/widgets.css');	
	
	//js
	JHtml::_('jquery.framework');
	JHTML::_('behavior.framework');
	//JHtml::_('bootstrap.framework');

	if(JFactory::getApplication()->input->get('bootstrap') == false) {
		JFactory::getApplication()->input->set('bootstrap', true);
		//bootstrap
		$document->addScript(YEEDITOR_ASSETS_URL.'js/bootstrap/yeeditor-bs-min.js');	
	}

	
	$document->addScript($root.'plugins/editors/yeeditor/assets/js/base64.js');
		
	/***************** add assets end **************/
}

//widgets function
function get_widget_frontend_style($element_setting){
	$style = ""; 
	if($element_setting && isset($element_setting['style_detail'])){
		$style_detail = json_decode(base64_decode($element_setting['style_detail']),true);
		$border_str = "";
		
		//margin
		if(isset($style_detail['margin-top']) && $style_detail['margin-top'] != ""){ $style .= 'margin-top:'.$style_detail['margin-top'].'px;'; }
		if(isset($style_detail['margin-bottom']) && $style_detail['margin-bottom'] != ""){ $style .= 'margin-bottom:'.$style_detail['margin-bottom'].'px;'; }
		if(isset($style_detail['margin-left']) && $style_detail['margin-left'] != ""){ $style .= 'margin-left:'.$style_detail['margin-left'].'px;'; }
		if(isset($style_detail['margin-right']) && $style_detail['margin-right'] != ""){ $style .= 'margin-right:'.$style_detail['margin-right'].'px;'; }
		//padding
		if(isset($style_detail['padding-top']) && $style_detail['padding-top'] != ""){ $style .= 'padding-top:'.$style_detail['padding-top'].'px;'; }
		if(isset($style_detail['padding-bottom']) && $style_detail['padding-bottom'] != ""){ $style .= 'padding-bottom:'.$style_detail['padding-bottom'].'px;'; }
		if(isset($style_detail['padding-left']) && $style_detail['padding-left'] != ""){ $style .= 'padding-left:'.$style_detail['padding-left'].'px;'; }
		if(isset($style_detail['padding-right']) && $style_detail['padding-right'] != ""){ $style .= 'padding-right:'.$style_detail['padding-right'].'px;'; }
		//border
		if(isset($style_detail['border-top']) && $style_detail['border-top'] != ""){ $border_str .= $style_detail['border-top'].'px '; }
		if(isset($style_detail['border-bottom']) && $style_detail['border-bottom'] != ""){ $border_str .= $style_detail['border-bottom'].'px '; }
		if(isset($style_detail['border-left']) && $style_detail['border-left'] != ""){ $border_str .= $style_detail['border-left'].'px '; }
		if(isset($style_detail['border-right']) && $style_detail['border-right'] != ""){ $border_str .= $style_detail['border-right'].'px '; }
		
		if($element_setting['border'] && $element_setting['border']!="none"){
			$border_str .= $element_setting['border'].' ';
		}
		if($element_setting['border_color']){
			$border_str .= $element_setting['border_color'];
		}
		if($border_str){
			$border_str = 'border:'.$border_str.';';
		}
		$style = $style.$border_str;
	}

	return $style;
}