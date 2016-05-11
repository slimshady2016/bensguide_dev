<?php 
/*------------------------------------------------------------------------
# YEEditor - independent
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;

/*
YEEditor 1 shortcode to YEEditor 2 shortcode
*/

$ajax_return = convert_shortcode($_POST['content']);

echo $ajax_return;


function convert_shortcode($content){
	//other
	$content = unit_replace('btn-large btn-block','yee-btn-lg yee-btn-block',$content);
	$content = unit_replace('btn-large','yee-btn-lg',$content);
	$content = unit_replace('btn-small','yee-btn-sm',$content);
	$content = unit_replace('btn-mini','yee-btn-xs',$content);
	$content = unit_replace("btn-(.+?)","yee-btn-$2",$content);
	$content = unit_replace('in','open',$content);
	$content = unit_replace('img-polaroid','img-thumbnail',$content);
	//message box
	$content = unit_replace('alert-info','yee-alert-info',$content);
	$content = unit_replace('alert','yee-alert-warning',$content);
	$content = unit_replace('alert-success','yee-alert-success',$content);
	$content = unit_replace('alert-error','yee-alert-danger',$content);
	//CSS Animation
	$content = unit_replace('yee_top-to-bottom','yee-top-to-bottom',$content);
	$content = unit_replace('yee_bottom-to-top','yee-bottom-to-top',$content);
	$content = unit_replace('yee_left-to-right','yee-left-to-right',$content);
	$content = unit_replace('yee_right-to-left','yee-right-to-left',$content);
	$content = unit_replace('yee_appear','yee-appear',$content);
	//font awesome
	$content = unit_replace('icon-bell','fa fa-bell-o',$content);
	$content = unit_replace('icon-check','fa fa-check-square-o',$content);
	$content = unit_replace('icon-circle-arrow-down','fa fa-arrow-circle-down',$content);
	$content = unit_replace('icon-circle-arrow-left','fa fa-arrow-circle-left',$content);
	$content = unit_replace('icon-circle-arrow-right','fa fa-arrow-circle-right',$content);
	$content = unit_replace('icon-circle-arrow-up','fa fa-arrow-circle-up',$content);
	$content = unit_replace('icon-eye-open','fa fa-eye',$content);
	$content = unit_replace('icon-eye-close','fa fa-eye-slash',$content);
	$content = unit_replace('icon-edit','fa fa-pencil-square-o',$content);
	$content = unit_replace('icon-facetime-video','fa fa-video-camera',$content);
	$content = unit_replace('icon-folder-close','fa fa-folder',$content);
	$content = unit_replace('icon-fullscreen','fa fa-arrows-alt',$content);
	$content = unit_replace('icon-hand-down','fa fa-hand-o-down',$content);
	$content = unit_replace('icon-hand-left','fa fa-hand-o-left',$content);
	$content = unit_replace('icon-hand-right','fa fa-hand-o-right',$content);
	$content = unit_replace('icon-hand-up','fa fa-hand-o-up',$content);
	$content = unit_replace('icon-minus-sign','fa fa-minus-circle',$content);
	$content = unit_replace('icon-move','fa fa-arrows',$content);
	$content = unit_replace('icon-off','fa fa-power-off',$content);
	$content = unit_replace('icon-ok-sign','fa fa-check-circle',$content);
	$content = unit_replace('icon-ok','fa fa-check',$content);
	$content = unit_replace('icon-ok-circle','fa fa-check-circle-o',$content);
	$content = unit_replace('icon-picture','fa fa-picture-o',$content);
	$content = unit_replace('icon-play-circle','fa fa-play-circle-o',$content);
	$content = unit_replace('icon-plus-sign','fa fa-plus-circle',$content);
	$content = unit_replace('icon-question-sign','fa fa-question-circle',$content);
	$content = unit_replace('icon-remove-circle','fa fa-times-circle-o',$content);
	$content = unit_replace('icon-remove-sign','fa fa-times-circle',$content);
	$content = unit_replace('icon-remove','fa fa-arrows',$content);
	$content = unit_replace('icon-resize-full','fa fa-expand',$content);
	$content = unit_replace('icon-resize-horizontal','fa fa-arrows-h',$content);
	$content = unit_replace('icon-resize-small','fa fa-compress',$content);
	$content = unit_replace('icon-resize-vertical','fa fa-arrows-v',$content);
	$content = unit_replace('icon-screenshot','fa fa-crosshairs',$content);
	$content = unit_replace('icon-share-alt','fa fa-share',$content);
	$content = unit_replace('icon-share','fa fa-share-square-o',$content);
	$content = unit_replace('icon-time','fa fa-clock-o',$content);
	$content = unit_replace('icon-trash','fa fa-trash-o',$content);
	$content = unit_replace('icon-upload','fa fa-arrow-circle-o-up',$content);
	$content = unit_replace('icon-warning-sign','fa fa-exclamation-triangle',$content);
	$content = unit_replace('icon-zoom-in','fa fa-search-plus',$content);
	$content = unit_replace('icon-zoom-out','fa fa-search-minus',$content);
	$content = unit_replace('icon-(.+?)','fa fa-$2',$content);
	
	//widget setting
	global $yee_widget;
	global $widget_main_content_setting_arr;
	$elements_arr=$yee_widget;
	$preg_str="";
	foreach($elements_arr as $key=>$element_value_temp){
		if($key!='yee_row' && $key!='yee_row_inner' && $key!='yee_accordion' && $key!='yee_tabs'){
			$preg_str = $preg_str?($preg_str.'|'.$key):($key);
			foreach($element_value_temp['params'] as $param){
				if(isset($param['main_content']) && $param['main_content']==true){
					$widget_main_content_setting_arr[$key] = $param;
				}
			}
		}  
	}
	$content = preg_replace_callback('/(\[\b('.$preg_str.')\b[\s\S]*?]([\s\S]*?)\[\/\b\2\b[\s\]])/i',
											function ($matches) {
												global $widget_main_content_setting_arr;
												$result = $matches[0];

												if(isset($widget_main_content_setting_arr[$matches[2]]) && strstr($result,'widget_padding="')){
													if($matches[3]){
														$value = $matches[3];
														if($widget_main_content_setting_arr[$matches[2]]['type']=="textarea" || $widget_main_content_setting_arr[$matches[2]]['type']=="code_mirror"){
															$value = base64_decode($matches[3]);
														}
														else if($widget_main_content_setting_arr[$matches[2]]['type']=="select_images"){
															preg_match('/'.$widget_main_content_setting_arr[$matches[2]]['param_name'].'="([\s\S]*?)"/i',$result,$child_matches);
															$value = base64_decode($child_matches[1]);
															$result = str_replace($child_matches[0],'',$result);
														}
														$result = str_replace($matches[3],'{'.$widget_main_content_setting_arr[$matches[2]]['param_name'].'}'.$value.'{/'.$widget_main_content_setting_arr[$matches[2]]['param_name'].'}',$result);
													}
													else{
														$value = $matches[3];
														if($widget_main_content_setting_arr[$matches[2]]['type']=="select_images"){
															preg_match('/'.$widget_main_content_setting_arr[$matches[2]]['param_name'].'="([\s\S]*?)"/i',$result,$child_matches);
															$value = base64_decode($child_matches[1]);
															$result = str_replace($child_matches[0],'',$result);
														}
														$result = str_replace('][/'.$matches[2].']',']{'.$widget_main_content_setting_arr[$matches[2]]['param_name'].'}'.$value.'{/'.$widget_main_content_setting_arr[$matches[2]]['param_name'].'}[/'.$matches[2].']',$result);
													}
												}
												return $result;
											}
											,$content);	
	
	//padding margin
	$content = preg_replace_callback('/[\s]widget_padding="(.+?)" widget_margin="(.+?)"/',
											function ($matches) {
												$padding_data = json_decode(base64_decode($matches[1]),true);
												$margin_data = json_decode(base64_decode($matches[2]),true);
												
												$style_box = array(
													"margin-top" => $margin_data['margin-top']?$margin_data['margin-top']:'',
													"margin-right" => $margin_data['margin-right']?$margin_data['margin-right']:'',
													"margin-bottom" => $margin_data['margin-bottom']!='30'?$margin_data['margin-bottom']:'',
													"margin-left" => $margin_data['margin-left']?$margin_data['margin-left']:'',
													"margin-linked" => false,
													
													"border-top" => "",
													"border-right" => "",
													"border-bottom" => "",
													"border-left" => "",
													"border-linked" => false,
													
													"padding-top" => $padding_data['padding-top']?$padding_data['padding-top']:'',
													"padding-right" => $padding_data['padding-right']?$padding_data['padding-right']:'',
													"padding-bottom" => $padding_data['padding-bottom']?$padding_data['padding-bottom']:'',
													"padding-left" => $padding_data['padding-left']?$padding_data['padding-left']:'',
													"padding-linked" => false
												);
												
												$new_data = base64_encode(json_encode($style_box));
											
												return ' style_detail="'.$new_data.'"';
											}
											,$content);								
																																	
	return $content;
}

function unit_replace($src,$target,$content){
	return preg_replace('/([\s][A-Za-z0-9_-]+?)="'.$src.'"/','$1="'.$target.'"',$content);
}

