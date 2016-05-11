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

//get variables by less (bootstrap variable less format)
function get_variables_by_less($path){
	$less_content = file_get_contents($path);
	$less_arr = array();
		
	preg_match('/\/\/==[\s\S]*/',$less_content,$result);
	$content = $result?$result[0]:'';
	if($content){
		$results = preg_split('/(\/\/==)\s|(\/\/--)\s/',$content,-1,PREG_SPLIT_DELIM_CAPTURE);
		
		if($results){
			$i = 0;
			foreach($results as $content){
				if($content){
					if($content == '//==' || $content == '//--'){
						$less_arr[$i]['type'] = $content;
					}
					else{
						//title
						preg_match('/.*/',$content,$result);
						$less_arr[$i]['title'] = $result?$result[0]:'';
						
						
						//separate header and variables str
						preg_match('/([\s\S]*?)((@|\/\/\*\*|\/\/\s*[A-Za-z0-9]|\/\/\s*@)[\s\S]*)/',$content,$result);
						$header_str = $result?$result[1]:'';
						$variables_content = $result?$result[2]:'';
						$less_arr[$i]['header_str'] = $header_str;
						
						//description
						preg_match('/.*?\n\/\/.*?\n\/\/.*?##\s(.*)/',$header_str,$result);
						$less_arr[$i]['description'] = $result?$result[1]:'';
						
						//description extend
						preg_match('/\/\/===\s(.*)/',$header_str,$result);
						$less_arr[$i]['description_ex'] = $result?$result[1]:'';
						
						//variables
						$less_arr[$i]['variables'] = array();
						preg_match_all('/([\s\S]*?)(\/\/\s*)*?(@.+?):(.*?);(.*)\n/',$variables_content,$result);
						if($result){
							foreach($result[0] as $key => $value){
								//variable description, setting type
								$variable_description_str = $result[1][$key];
								$less_arr[$i]['variables'][$key]['variable_description_str'] = $variable_description_str;
								
								preg_match('/\/\/[\s]*?\*\*(.*)/',$variable_description_str,$variable_description_result);
								$variable_description_str2 = $variable_description_result?$variable_description_result[1]:'';
								$variable_description_str2 = preg_replace_callback('/`(.*?)`/',
																					function ($matches){
																						return '<code>'.htmlspecialchars($matches[1]).'</code>';
																					},
																					$variable_description_str2);
								preg_match('/(.*?)\[(.*?)\]/',$variable_description_str2,$variable_setting_type_result);
								if($variable_setting_type_result){
									$less_arr[$i]['variables'][$key]['setting_type'] = $variable_setting_type_result[2];
									$less_arr[$i]['variables'][$key]['description'] = $variable_setting_type_result[1];
								}
								else{
									$less_arr[$i]['variables'][$key]['setting_type'] = '';
									$less_arr[$i]['variables'][$key]['description'] = $variable_description_str2;
								}
								
								//variable visiable
								$less_arr[$i]['variables'][$key]['visiable'] = trim($result[2][$key])=='//'?0:1;
								
								//variable name
								$less_arr[$i]['variables'][$key]['name'] = $result[3][$key];
								
								//variable value
								$variable_value_str = $result[4][$key];
								preg_match('/([\s]*?)([\S].*)/',$variable_value_str,$variable_value_result);
								$less_arr[$i]['variables'][$key]['value_blank'] = $variable_value_result?$variable_value_result[1]:'';
								$less_arr[$i]['variables'][$key]['value'] = $variable_value_result?$variable_value_result[2]:'';
								
								//variable note
								$variable_note_str = $result[5][$key];
								$less_arr[$i]['variables'][$key]['note'] = $variable_note_str;
								
								//variable constant
								if($result[5][$key]){
									preg_match('/\/\/{(.*?)}/',$variable_note_str,$variable_constant_result);
									$less_arr[$i]['variables'][$key]['constant'] = isset($variable_constant_result[1])?1:0;
								}
								else{
									$less_arr[$i]['variables'][$key]['constant'] = 0;
								}
							}
						}
						
						$i++;
					}
				}
			}
		}
	}
	
	return $less_arr;
}

//get setting filed
function get_setting_filed($name , $value , $sign = '' , $type = 'text', $arg = array()){
	$html = "";
	$sign_html = "";
	
	if(!$type){
		$type = 'text';
	}
	
	if($sign){
		$sign_html = ' data-keys="'.$sign.'"';
	}
	
	switch($type){
		case 'text':
			$placeholder_html = "";
			if($arg['placeholder']){
				$placeholder_html = ' placeholder="'.$arg['placeholder'].'"';
			}
			$value = htmlspecialchars($value);
			$html .= '<input class="yee-form-control"'.$sign_html.$placeholder_html.' type="text" value="'.$value.'" name="'.$name.'">';
			break;
			
		case 'textarea':
			$value = htmlspecialchars($value);
			$html .= '<textarea name="'.$name.'"'.$sign_html.' class="yee-form-control" rows="3" >'.$value.'</textarea>';
			break;	
			
		case 'checkbox':
			$checked_html = "";
			if($value == true){
				$checked_html = ' checked="checked"';
			}
			$html .= '<input type="checkbox"'.$sign_html.' name="'.$name.'" yet-data-type="switch"'.$checked_html.'>';
			break;	
			
		case 'checkbox-group':
			$value_arr = explode(',',$value);
			$html .= '<div data-yee-toggle="buttons" class="yee-btn-group">';
			foreach($arg['options'] as $option_key => $option_title){
				$html .= '<label class="yee-btn yee-btn-primary'.(in_array($option_key,$value_arr)?' active':'').'">
							<input type="checkbox" '.$sign_html.' name="'.$name.'"'.(in_array($option_key,$value_arr)?' checked="checked"':'').' value="'.$option_key.'" yet-data-type="checkbox-group"> '.$option_title.'
						  </label>';
			}
			$html .= '</div>';			  
			break;	
		
		case 'select':
			$html .= '<select class="yee-form-control"'.$sign_html.' name="'.$name.'">';
			foreach($arg['options'] as $option_key => $option_title){
				$html .= '<option value="'.$option_key.'"'.($option_key==$value?' selected="selected"':'').'>'.$option_title.'</option>';
			}
			$html .= '</select>';
			break;
		
		case 'fonts-select':
			$yetpl_fonts=array(
				"Verdana, Geneva, sans-serif",
				"Georgia, 'Times New Roman', Times, serif",
				"'Courier New', Courier, monospace",
				"Arial, Helvetica, sans-serif",
				"Tahoma, Geneva, sans-serif",
				"'Trebuchet MS', Arial, Helvetica, sans-serif",
				"'Arial Black', Gadget, sans-serif",
				"'Times New Roman', Times, serif",
				"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
				"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
				"'MS Serif', 'New York', serif",
				"'Lucida Console', Monaco, monospace",
				"'Comic Sans MS', cursive"
			);
			$html .= '<select class="yee-form-control"'.$sign_html.' name="'.$name.'">';
			foreach($yetpl_fonts as $option_key => $option_title){
				$html .= '<option value="'.$option_title.'"'.($option_title==$value?' selected="selected"':'').'>'.$option_title.'</option>';
			}
			$html .= '</select>';
			break;	
			
		case 'color-picker':
			$html .= '<div class="yee-input-group colorpicker-element" yet-data-type="color-picker">
						<input class="yee-form-control"'.$sign_html.' type="text" value="'.$value.'" name="'.$name.'">
						<span class="yee-input-group-addon">
							<i style="background-color: rgb(0, 0, 0);"></i>
						</span>
					  </div>';
			break;
		
		case 'color-picker-rgba':
			$html .= '<div class="yee-input-group colorpicker-element" yet-data-type="color-picker" data-format="rgba">
						<input class="yee-form-control"'.$sign_html.' type="text" value="'.$value.'" name="'.$name.'">
						<span class="yee-input-group-addon">
							<i style="background-color: rgb(0, 0, 0);"></i>
						</span>
					  </div>';
			break;	
		
		case 'select-image':
			$html .= '<input class="yee-form-control"'.$sign_html.' type="text" value="'.$value.'" name="'.$name.'">';
			$html .= '<button class="yee-btn yee-btn-info" type="button" onclick="theme_field_select_image(\''.$name.'\');"> Browse</button></div>';	  
			break;
		
		case 'upload-image':
			$html .= '<div class="fileinput fileinput-new" data-provides="fileinput">
						  <div class="fileinput-new yee-thumbnail '.$name.'-thumbnail">
							<img'.($value?' src="'.$value.'"':' data-src="holder.js/100%x100%"').'>
						  </div>
						  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
						  <div>
							<span class="yee-btn yee-btn-default yee-btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file"'.$sign_html.' name="'.$name.'" value="'.$value.'"></span>
							<a href="#" class="yee-btn yee-btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
						  </div>
					  </div>
					  <input type="button" class="yee-btn yee-btn-default" name="'.$name.'-upload" value="upload"/>';		  
			break;	
	}
	
	return $html;
}
//get less content by less array
function get_updated_less_content($less_arr, $title = ''){
	$less_content = '//
// '.$title.'
// --------------------------------------------------


';

	foreach($less_arr as $less_category){
		$less_content .= $less_category['type'].' '.$less_category['header_str'];
		foreach($less_category['variables'] as $variable){
			
			$less_content .= $variable['variable_description_str'];
			
			if($variable['visiable'] == 0){
				$less_content .= "//";
			}
			$less_content .= $variable['name'].":".$variable['value_blank'].$variable['value'].";".$variable['note']."\n";
		}
		$less_content .= "\n\n";
	}
	
	return $less_content;
}
//combine less to css file
function combine_less(){
	require_once YEEDITOR_COMPONENT_ADMIN_PATH.'helpers/less.php/Less.php';
	
	$less_path = YEEDITOR_PATH.'assets/less/yeeditor.frontend.less';
	$css_path = YEEDITOR_PATH.'assets/css/yeeditor.frontend.css';
	
	$options = array( 'compress'=>true );
	$parser = new Less_Parser($options);
	$parser->parseFile( $less_path );
	$css = $parser->getCss();
	
	return file_put_contents($css_path, $css);
}