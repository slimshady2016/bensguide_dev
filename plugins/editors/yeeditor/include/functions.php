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

/****************** layout backend function **********/
/*
The setting of yeeditor element convert into html
*/
function get_element_setting_html($widget_name,$element_param,$element_setting){
	$yeeditor_setting_type_path = YEEDITOR_COMPONENT_ADMIN_PATH."widgets_ex/".$widget_name."/backend/setting_type/".$element_param['type']."/".$element_param['type'].".php";
	if(!file_exists($yeeditor_setting_type_path)){
		$yeeditor_setting_type_path = YEEDITOR_COMPONENT_ADMIN_PATH."widget_setting_type/".$element_param['type']."/".$element_param['type'].".php";
	}
	
	if(file_exists($yeeditor_setting_type_path)){
		$hide_class = "";
		$setting_relation = "";
		$setting_parent = "";
		if(isset($element_param['setting-relation'])){
			if(!in_array($element_setting[$element_param['setting-relation']['parent']],$element_param['setting-relation']['group'])){
				$hide_class = " hide";
			}
			$setting_relation = ' data-setting-relation="'.implode(',',$element_param['setting-relation']['group']).'"';
		}
		if(isset($element_param['display']) && $element_param['display']=="none"){
			$hide_class = " hide";
		}
		if(isset($element_param['setting-parent']) && $element_param['setting-parent']==true){
			$setting_parent = ' data-setting-parent="true"';
		}
	
		echo '<div class="form-group'.$hide_class.'"'.$setting_relation.$setting_parent.'>
			  <h4>'.$element_param['heading'].($element_param['description']?'<small><a href="#"><span class="toggle-help-block glyphicon glyphicon-question-sign pull-right"></span></a></small>':'').'</h4>';
	
		include $yeeditor_setting_type_path;
			
		if($element_param['description']){
			echo '<div class="yee-help-block'.(isset($element_param['description_show_default'])&&$element_param['description_show_default']==true?'':' hide').'">
					<div class="yee-well">
						'.$element_param['description'].'
					</div>
				  </div>';
		}
		
		echo '<hr>';
		echo '</div><div class="clearfix"></div>';
    }
}
/*
The child setting of yeeditor element setting convert into html
*/
function get_element_child_setting_html($widget_name,$element_param,$element_setting){
	$yeeditor_setting_type_path = YEEDITOR_COMPONENT_ADMIN_PATH."widgets_ex/".$widget_name."/backend/setting_type/".$element_param['type']."/".$element_param['type'].".php";
	if(!file_exists($yeeditor_setting_type_path)){
		$yeeditor_setting_type_path = YEEDITOR_COMPONENT_ADMIN_PATH."widget_setting_type/".$element_param['type']."/".$element_param['type'].".php";
	}
	
	if($element_param && file_exists($yeeditor_setting_type_path)){
		include $yeeditor_setting_type_path;
    }
}
/*
Get the settings from element shortcode
*/
function get_element_setting($element_key,$element_shortcode,$elements_arr){
	$element_setting=array();

	$element_setting = get_element_setting_value($elements_arr[$element_key]['params'],$element_key,$element_shortcode);
	
	return $element_setting;
}
/*
Get the settings value
*/
function get_element_setting_value($params,$element_key,$element_shortcode){
	$element_setting=array();
	foreach($params as $param){
		if(isset($param['child_params'])){
			foreach($param['child_params'] as $row){
				foreach($row as $column){
					$element_setting_ex = get_element_setting_value($column['items'],$element_key,$element_shortcode);
					$element_setting = array_merge($element_setting,$element_setting_ex);
				}	
			}
		}
		else{
			$setting_value="";
			if(isset($param['main_content']) && $param['main_content']==true){
				preg_match('/\['.$element_key.'\s[^\]]*?[\s\S]*?][\s\S]*?{'.$param['param_name'].'}([\s\S]*?){\/'.$param['param_name'].'}[\s\S]*?\[\/'.$element_key.']/i',$element_shortcode,$value);
				if($value){
					$setting_value = htmlspecialchars_decode($value[1]);
				}
				else{
					$setting_value = $param['value'];
				}	
			}
			else{
				preg_match('/\['.$element_key.'\s[^\]]*?'.$param['param_name'].'="(.*?)"[\s\S]*?]/i',$element_shortcode,$value);
				if($value){
					$setting_value=$value[1];
				}
				else{
					$setting_value=$param['value'];
				}	
			}	
			
			$setting_value = $setting_value!=""?$setting_value:"";
			$element_setting[$param['param_name']]=$setting_value;
		}	
	}
	
	return $element_setting;
}
/*
Get the settings params hidden field html
*/
function get_params_html($params,$element_setting=array()){
	$params_html="";

	foreach($params as $param){
		if(isset($param['child_params'])){
			foreach($param['child_params'] as $row){
				foreach($row as $column){
					$params_html .= get_params_html($column['items'],$element_setting);
				}	
			}
		}
		else{
			if(isset($param['main_content']) && $param['main_content']==true){				
				
				switch($param['type']){
					case 'content-editor':
						$setting_type_class = " ck-editor";
						break;
					case 'code_mirror':
						$setting_type_class = " code-mirror";
						break;
					case 'tinymce-editor':
						$setting_type_class = " tinymce-editor";
						break;
					case 'jce-editor':
						$setting_type_class = " jce-editor";
						break;
					case 'jck-editor':
						$setting_type_class = " jck-editor";
						break;	
					default:
						$setting_type_class = "";
						break;			
				}
				
				$params_html .= '<textarea class="yee_element_param_value main_content'.$setting_type_class.'" style="display:none;" yee-name="'.$param['param_name'].'">'.(isset($element_setting[$param['param_name']])?htmlspecialchars(ContentImageUrlRelativeToAbsolute($element_setting[$param['param_name']])):$param['value']).'</textarea>';
			}	
			else{
				$params_html .= '<input class="yee_element_param_value" type="hidden" value="'.(isset($element_setting[$param['param_name']])?$element_setting[$param['param_name']]:$param['value']).'" yee-name="'.$param['param_name'].'"/>';
			}
		}
	}	
	
	return $params_html;
}
/*
The html content of yeeditor element show in backend
*/
function get_element_backend_html($element_key,$element_setting,$elements_arr,$element_shortcode=""){
    //load element backend html file
	global $widgets_ex,$widgets_ex_path,$widget_key_name,$yee_widget_parent_extend,$yee_widget_extend;
	global $widget_num;
	$element_parent_extend_arr=$yee_widget_parent_extend;
	$elements_extend_arr = $yee_widget_extend;
	$widget_num++;
	
	$return = "";
	
	$params_html = "";
	
	$params_html = get_params_html($elements_arr[$element_key]['params'],$element_setting);	
	
	$element_extend_class="";
	if(isset($element_parent_extend_arr[$element_key]) && (!isset($elements_extend_arr[$element_parent_extend_arr[$element_key]]['box_html']) || $elements_extend_arr[$element_parent_extend_arr[$element_key]]['box_html']==true)){
		$element_extend_class=" yee_not_inner_widget";
	}	
	
	$visiable_class = isset($element_setting['visiable'])?($element_setting['visiable']?'fa-eye':'fa-eye-slash'):'';
	
	$element_html_before='
				<div class="yee-panel yee-panel-default wrapper '.$element_extend_class.'">
					<div class="yee-panel-body">
					    <input class="yee_element_base" type="hidden" value="'.$element_key.'" name="element_name-'.$element_key.'">
						'.$params_html.'
						<div class="yee-widget-content">
							<div class="pull-right yee-btn-group yee-pull-right yee-btn-group-xs yee-wgt-setting">
							'.($visiable_class?'<a href="#" class="yee-btn yee-btn-link yee_ele_visiable"><i class="fa '.$visiable_class.'"></i></a>':'').'
							<a href="#" class="yee-btn yee-btn-link yee_ele_edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="yee-btn yee-btn-link yee_ele_clone"><i class="fa fa-copy"></i></a>
							<a href="#" class="yee-btn yee-btn-link yee_ele_delete"><i class="fa fa-times"></i></a>
							</div>';
	$element_html_behind='
	                    </div>
					    <input class="yee_element_base" type="hidden" value="'.$element_key.'_end">
					</div>
				</div>';
	
	switch($element_key){
	    case 'yee_row':
			$return .= '';
			break;
	
	    case 'yee_row_inner':
			$elements_arr_ex=yeeMap::map_ex();
			$column_inner_params_html="";
			$column_inner_params_html = get_params_html($elements_arr_ex['yee_column_inner']['params']);	
			
			$return .= '
				  <div class="yee-row wrapper yee_inner_row">
					   <div class="yee-col-xs-12">
					        <input class="yee_element_base" type="hidden" value="'.$element_key.'" name="">'.
							$params_html
						  .'<div class="yee-panel yee-panel-default">
								<div class="yee-panel-heading clearfix">
									<h4 class="yee-panel-title pull-left"><span class="fw-title">'.JText::_('YEEDITOR_WRAPPER_ROW').'</span> <small>1/1</small> </h4>
									<div class="text-center">
										<div class="pull-right yee-btn-group yee-pull-right">
											<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_visiable"><i class="fa '.$visiable_class.'"></i></a>
											<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_edit"><i class="fa fa-edit"></i></a>
											<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_clone"><i class="fa fa-copy"></i></a>
											<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_delete"><i class="fa fa-times"></i></a>
										</div>
										<div class="yee-btn-group">
											<button type="button" class="yee-btn yee-btn-default yee-btn-xs custom_column">'.JText::_('YEEDITOR_WRAPPER_CUSTOM_COLUMN').'</button>
											<button type="button" class="yee-btn yee-btn-default yee-btn-xs yee-dropdown-toggle" data-yee-toggle="dropdown">
												<span class="yee-caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="yee-dropdown-menu text-left yee_columnTypes" role="menu">
												<li class="active"><a href="#" title="1/1"><i class="yee_icon-grid01"></i> <span class="nav-text">1/1</span></a> </li>
												<li><a href="#" title="1/2 + 1/2"><i class="yee_icon-grid02"></i> <span class="nav-text">1/2 + 1/2</span></a> </li>
												<li><a href="#" title="2/3 + 1/3"><i class="yee_icon-grid03"></i> <span class="nav-text">2/3 + 1/3</span></a> </li>
												<li><a href="#" title="1/3 + 1/3 + 1/3"><i class="yee_icon-grid04"></i> <span class="nav-text">1/3 + 1/3 + 1/3</span></a> </li>
												<li><a href="#" title="1/4 + 1/4 + 1/4 + 1/4"><i class="yee_icon-grid05"></i> <span class="nav-text">1/4 + 1/4 + 1/4 + 1/4</span></a> </li>
												<li><a href="#" title="1/4 + 3/4"><i class="yee_icon-grid06"></i> <span class="nav-text">1/4 + 3/4</span></a> </li>
												<li><a href="#" title="1/4 + 1/2 + 1/4"><i class="yee_icon-grid07"></i> <span class="nav-text">1/4 + 1/2 + 1/4</span></a> </li>
												<li><a href="#" title="5/6 + 1/6"><i class="yee_icon-grid08"></i> <span class="nav-text">5/6 + 1/6</span></a> </li>
												<li><a href="#" title="1/5 + 1/5 + 1/5 + 1/5 + 1/5"><i class="yee_icon-grid09"></i> <span class="nav-text">1/5 + 1/5 + 1/5 + 1/5 + 1/5</span></a> </li>
												<li><a href="#" title="1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6"><i class="yee_icon-grid10"></i> <span class="nav-text">1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6</span></a> </li>
											</ul>
											<input type="hidden" class="column_group" value="1/1"/>
										</div>
									</div>
								</div>
								<div class="yee_group_4 yee-panel-body">
									<div class="yee-row">
										<div class="yee-col-xs-12">
										  <div class="yee-well yee-well-sm wrapper">
											<input class="yee_element_base" type="hidden" name="" value="yee_column_inner" >
											'.$column_inner_params_html.'
											<div class="yee_group_5 yee-wgt">		
											</div>
											<div class="text-center yee-col-settings">
												<div class="yee-btn-group">
													<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_visiable"><i class="fa '.$visiable_class.'"></i>&nbsp</a>
													<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_add_ele_btn"><i class="fa fa-plus"></i> '.JText::_('YEEDITOR_WRAPPER_WIDGET').'</a>
													<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_edit"><i class="fa fa-edit"></i> '.JText::_('YEEDITOR_WRAPPER_EDIT').'</a>
												</div>
											</div>
											<input class="yee_element_base" type="hidden" value="yee_column_inner_end" name=""/>
										  </div>	
										</div>
									</div>	
							   </div>
							   <input class="yee_element_base" type="hidden" value="'.$element_key.'_end" name="">
						   </div>
					  </div>
				  </div>
			';
			break;		
			
		default :
			$widget_name=$widget_key_name[$element_key];
			
			$item_params=array("element_key"=>$element_key,"element_setting"=>$element_setting,"element_attribute"=>$elements_arr[$element_key],"element_shortcode"=>$element_shortcode);
			$path=$widgets_ex_path.$widget_name."/backend/html/".$widget_name.".php";
			$widget_backend_html=get_element_html($path,$item_params);
			
			$return .= $element_html_before.$widget_backend_html.$element_html_behind;
			
			break;	
	}
    return $return;
}
function get_element_html($path,$item_params=array()){
	// Start capturing output into a buffer
	ob_start();
	
	// Include the requested template filename in the local scope
	// (this will execute the view logic).
	include $path;
	
	// Done with the requested template; get the buffer and
	// clear it.
	$widget_content = ob_get_contents();
	
	ob_end_clean();
	
	return $widget_content;
}

function get_insert_plugin_html($filter_keys=array(),$elements_arr,$widget_group,$widget_key_name){
	$yeeditor_widgets_url = YEEDITOR_COMPONENT_ADMIN_URL."widgets_ex/";
	$widgets_ex_path = JPATH_ROOT."/administrator/components/com_yeeditor/widgets_ex/";
	
	//get all widgets folder
	jimport( 'joomla.filesystem.file' );
	$xmlfile = JPATH_ROOT."/plugins/editors/yeeditor/include/widgets.xml";
	if(JFile::exists($xmlfile)){
		$xml = JFactory::getXML($xmlfile);
		$pro_widget = json_decode(json_encode($xml),true);
	}

	$html = '<button type="button" class="yee-close" data-yee-dismiss="modal" aria-hidden="true">&times;</button>';
	
	$html .= '<div class="yee-btn-group yee-widget-group">';
	$html .= '	<a class="yee-btn yee-btn-default yee-btn-xs active" data-yee-toggle="tab" href="#All">All</a>';
	$html .= '	<a class="yee-btn yee-btn-default yee-btn-xs" data-yee-toggle="tab" href="#Content">Content</a>';
	$html .= '	<a class="yee-btn yee-btn-default yee-btn-xs" data-yee-toggle="tab" href="#Structure">Structure</a>';
	$html .= '	<a class="yee-btn yee-btn-default yee-btn-xs" data-yee-toggle="tab" href="#Editor">Editor</a>';
	$html .= '	<a class="yee-btn yee-btn-default yee-btn-xs" data-yee-toggle="tab" href="#Social">Social</a>';
	$html .= '</div>';
	$html .= '<div class="clearfix"><br /></div>';
	$html .= '<div class="yee-tab-content">';

	
	$element_sections=array(
						"All"=>'<div id="All" class="yee-row yee-widget-panel yee-tab-pane active">',
						"Content"=>'<div id="Content" class="yee-row yee-widget-panel yee-tab-pane">',
						"Structure"=>'<div id="Structure" class="yee-row yee-widget-panel yee-tab-pane">',
						"Editor"=> '<div id="Editor" class="yee-row yee-widget-panel yee-tab-pane">',
						"Social"=>'<div id="Social" class="yee-row yee-widget-panel yee-tab-pane">'
						);
						
	if($filter_keys){
		foreach($filter_keys as $filter_key){
			unset($elements_arr[$filter_key]);
		}
	}

	$element_sections_count=array(
						"All"=>1,
						"Content"=>1,
						"Structure"=>1,
						"Editor"=>1,
						"Social"=>1
						);
						
	$all_widgets = array_merge($elements_arr,$pro_widget['widget']);
	$new_install_widgets = array();					
	foreach($all_widgets as $element_key => $element_detail){
		$description="";
		$name="";
		if(is_array($element_detail)){
			if($element_key=="yee_row" || $element_key=="yee_row_inner"){
				$icon = $element_detail['icon'];
				$section_name="Structure";
			}
			else{
				
				$widget_name = $widget_key_name[$element_key];
				if(isset($widget_key_name[$element_key])){
					$icon = $yeeditor_widgets_url.$widget_name.'/backend/'.$element_detail['icon'];
				}
				else{
					$icon = YEEDITOR_URL."assets/img/wgt-icon-na.png"; 
				}
				
				$xmlfile=$widgets_ex_path.$widget_name."/".$widget_name.".xml";
				$xml = JFactory::getXML($xmlfile);
				$description=$xml->description;
				$name=$xml->title;
				
				$section_name = trim($xml['group'])?trim($xml['group']):"Social";	
			}
			
			$section_name = isset($element_sections[$section_name])?$section_name:"Social";
		
			$element_sections[$section_name] .= '<div class="yee-col-xs-6 yee-col-sm-4 yee-col-md-3 yee-col-lg-2 element_item" data-yee-key="'.$element_key.'"><a class="yee-thumbnail" href="#"><img src="'.$icon.'"><div class="caption"><h4>'.$name.'</h4><p>'.$description.'</p></div></a></div>';
			
			$element_sections["All"] .= '<div class="yee-col-xs-6 yee-col-sm-4 yee-col-md-3 yee-col-lg-2 element_item" data-yee-key="'.$element_key.'"><a class="yee-thumbnail" href="#"><img src="'.$icon.'"><div class="caption"><h4>'.$name.'</h4><p>'.$description.'</p></div></a></div>';
		}
		else{
			$name_icon = explode('|',$element_detail);
			$widget_name = 	$name_icon[0];
			$icon = $yeeditor_widgets_url.$widget_name.'/backend/'.$name_icon[1];
			
			$xmlfile=$widgets_ex_path.$widget_name."/".$widget_name.".xml";
			$xml = JFactory::getXML($xmlfile);
			$description=$xml->description;
			$name=$xml->title;
			
			$section_name = trim($xml['group'])?trim($xml['group']):"Social";	
			
			$section_name = isset($element_sections[$section_name])?$section_name:"Social";
		
			$element_sections[$section_name] .= '<div class="yee-col-xs-6 yee-col-sm-4 yee-col-md-3 yee-col-lg-2" style="position: relative;"><a class="yee-thumbnail" href="http://www.yeedeen.com/extensions/yeeditor" target="_blank"><img src="'.$icon.'" style="opacity:0.2;"/><small style="position: absolute;top: 57px;left: 62px;display: block; color: #FF0000;">Subscription Required</small><h4>'.$name.'</h4><p>'.$description.'</p></a></div>';
			
			$element_sections["All"] .= '<div class="yee-col-xs-6 yee-col-sm-4 yee-col-md-3 yee-col-lg-2" style="position: relative;"><a class="yee-thumbnail" href="http://www.yeedeen.com/extensions/yeeditor" target="_blank"><img src="'.$icon.'" style="opacity:0.2;"/><small style="position: absolute;top: 57px;left: 62px;display: block; color: #FF0000;">Subscription Required</small><div class="caption"><h4>'.$name.'</h4><p>'.$description.'</p></div></a></div>';
		}
		
		
		
		$clearfix = '';
		//section
		if($element_sections_count[$section_name]%6==0){
			$clearfix = '<div class="clearfix visible-lg"></div>';
		}
		else if($element_sections_count[$section_name]%4==0){
			$clearfix = '<div class="clearfix visible-md"></div>';
		}
		else if($element_sections_count[$section_name]%3==0){
			$clearfix = '<div class="clearfix visible-sm"></div>';
		}
		else if($element_sections_count[$section_name]%2==0){
			$clearfix = '<div class="clearfix visible-xs"></div>';
		}
		$element_sections[$section_name] .= $clearfix;
		$element_sections_count[$section_name]++;
		
		//all
		$clearfix = '';
		if($element_sections_count['All']%6==0){
			$clearfix = '<div class="clearfix visible-lg"></div>';
		}
		else if($element_sections_count['All']%4==0){
			$clearfix = '<div class="clearfix visible-md"></div>';
		}
		else if($element_sections_count['All']%3==0){
			$clearfix = '<div class="clearfix visible-sm"></div>';
		}
		else if($element_sections_count['All']%2==0){
			$clearfix = '<div class="clearfix visible-xs"></div>';
		}
		$element_sections["All"] .= $clearfix;
		$element_sections_count['All']++;
	}
	
	foreach($element_sections as $element_section){
		$html = $html.$element_section.'</div>';
	}
	
	$html .= '</div>';
	return $html;
}
function get_items_html($item_key,$content_shortcode){
	global $yee_widget,$yee_widget_extend;
	$elements_arr=$yee_widget;
	$return=array();
	$return_num=0;
	$preg_str="";
	$item_arr=$yee_widget_extend;
	$item_params=$item_arr[$item_key]['params'];
	
	$returnBoxHtml = true;
	$setting_buttons = array("add","edit","clone","delete");
	if(isset($yee_widget_extend[$item_key]['setting_buttons'])){
		$setting_buttons = $yee_widget_extend[$item_key]['setting_buttons'];
	}
	if(isset($yee_widget_extend[$item_key]['box_html'])){
		$returnBoxHtml = $yee_widget_extend[$item_key]['box_html'];
	}
	
	foreach($elements_arr as $key=>$element_value_temp)
		  $preg_str = $preg_str?($preg_str.'|'.$key):($key);
	
	preg_match_all('/\['.$item_key.'[\s\]][\s\S]*?\[\/'.$item_key.']/i',$content_shortcode,$items_shortcodes);
	foreach($items_shortcodes[0] as $items_shortcode){
		$params_html="";
		$item_setting=get_element_setting($item_key,$items_shortcode,$item_arr);
		
		$params_html = get_params_html($item_params,$item_setting);	
		foreach($item_params as $param){
			$return[$return_num][$param['param_name']]=$item_setting[$param['param_name']];
		}	
		
		if($returnBoxHtml == true){
			//rows inner and elements
			$rows_inner_and_elements_html="";
			if(preg_match_all('/(\[\b('.$preg_str.')\b[\s\]][\s\S]*?\[\/\b\2\b[\s\]])/i',$items_shortcode,$rows_inner_and_elements,PREG_PATTERN_ORDER)){
				$rows_inner_and_elements_count=0;
				foreach($rows_inner_and_elements[2] as $row_inner_and_element_key){
					//get row inner
					if($row_inner_and_element_key=="yee_row_inner"){
						$row_inner=$rows_inner_and_elements[1][$rows_inner_and_elements_count];
						$rows_inner_and_elements_html .= get_backend_inner_row_html($row_inner);
					}	
					else{
						//get element
						$element_shortcode=$rows_inner_and_elements[1][$rows_inner_and_elements_count]; //element shortcode
						
						$element_setting = get_element_setting($row_inner_and_element_key,$element_shortcode,$elements_arr);
						
						$rows_inner_and_elements_html .= get_element_backend_html($row_inner_and_element_key,$element_setting,$elements_arr,$element_shortcode);
					}
					$rows_inner_and_elements_count++;				
				}
			}//end rows inner and elements
			
			$visiable_class = isset($item_setting['visiable'])?($item_setting['visiable']?'fa-eye':'fa-eye-slash'):'';
			
			$return[$return_num]['html']='
							   <div class="yee-well yee-well-sm">
								  <input class="yee_element_base" type="hidden" value="'.$item_key.'" name="element_name-'.$item_key.'">
								  '.$params_html.'
								  <div class="yee_group_6 yee-wgt ui-sortable">
									'.$rows_inner_and_elements_html.'			
								  </div>
								  <div class="text-center yee-col-settings">
											<div class="yee-btn-group">
										'.($visiable_class?'<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_visiable"><i class="fa '.$visiable_class.'"></i>&nbsp</a>':'');
			if(in_array("add",$setting_buttons)){	$return[$return_num]['html'] .= '<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_add_ele_inner_btn"><i class="fa fa-plus"></i> '.JText::_('YEEDITOR_WRAPPER_WIDGET').'</a>';}
			if(in_array("edit",$setting_buttons)){	$return[$return_num]['html'] .= '<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_edit"><i class="fa fa-edit"></i> '.JText::_('YEEDITOR_WRAPPER_EDIT').'</a>';}
			if(in_array("clone",$setting_buttons)){	$return[$return_num]['html'] .= '<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_clone"><i class="fa fa-copy"></i> '.JText::_('YEEDITOR_WRAPPER_COPY').'</a>';}
			if(in_array("delete",$setting_buttons)){	$return[$return_num]['html'] .= '<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_delete"><i class="fa fa-times"></i> '.JText::_('YEEDITOR_WRAPPER_DELETE').'</a>';}
			
			$return[$return_num]['html'] .= '</div>
								  </div>
								  <input class="yee_element_base" type="hidden" value="'.$item_key.'_end">
							   </div>';
		}//end $returnBoxHtml					   
		
		$return_num++;
	}
	
	return $return;
}
//get backend row html
function get_backend_row_html($content){
	global $yee_widget;
	$elements_arr=$yee_widget;
	$elements_arr_ex=yeeMap::map_ex();
	global $widget_num;
	$widget_num = 0;
	
	$preg_str="";
	
	foreach($elements_arr as $key=>$element_value_temp){
		  $preg_str = $preg_str?($preg_str.'|'.$key):($key);
	}	  
		 
	//intro text	 
	if(!preg_match('/<hr[\s\S]+?id="system-readmore"[\s\S]*?>/',$content)){
		$content = '<hr id="system-readmore" />'.$content;
	}
	$content_temp = preg_split('/<hr[\s\S]+?id="system-readmore"[\s\S]*?>/',$content);
	$intro_text = $content_temp[0];
	$content = $content_temp[1];
		  
	//row
	$rows_html=array();
	$row_html="";
	preg_match_all('/\[yee_row[\s\]][\s\S]+?\[\/yee_row]/i',$content,$rows); 
	
	if(!$rows[0] && $content){
		$content = '[yee_row ex_class=""][yee_column width="1/1" ex_class=""][yee_text_block ex_class=""]{textblock_content}<p>'.$content.'</p>{/textblock_content}
[/yee_text_block][/yee_column][/yee_row]';
		preg_match_all('/\[yee_row[\s\]][\s\S]+?\[\/yee_row]/i',$content,$rows); 
	}
	
	$arr=array("1/12"=>1,"1/6"=>2,"2/12"=>2,"1/5"=>"2-4","1/4"=>3,"2/8"=>3,"3/12"=>3,"1/3"=>4,"2/6"=>4,"3/9"=>4,"4/12"=>4,"5/12"=>5,"1/2"=>6,"2/4"=>6,"3/6"=>6,"4/8"=>6,"6/12"=>6,"7/12"=>7,"2/3"=>8,"4/6"=>8,"6/9"=>8,"8/12"=>8,"3/4"=>9,"6/8"=>9,"9/12"=>9,"5/6"=>10,"10/12"=>10,"11/12"=>11,"1/1"=>12,"12/12"=>12);
	
	foreach($rows[0] as $row){
		$column_html="";
		$column_partition="";
		
		//get the row setting
		$row_setting = get_element_setting('yee_row',$row,$elements_arr);
		
		//get the row params html
		$row_params_html = get_params_html($elements_arr['yee_row']['params'],$row_setting);
		
		//column
		preg_match_all('/\[yee_column[\s\]][\s\S]*?\[\/yee_column]/i',$row,$columns);	
		foreach($columns[0] as $column){
		 
			//rows inner and elements
			$rows_inner_and_elements_html="";
			if(preg_match_all('/(\[\b('.$preg_str.')\b[\s\]][\s\S]*?\[\/\b\2\b[\s\]])/i',$column,$rows_inner_and_elements,PREG_PATTERN_ORDER)){
				$rows_inner_and_elements_count=0;
				foreach($rows_inner_and_elements[2] as $row_inner_and_element_key){
					//get row inner
					if($row_inner_and_element_key=="yee_row_inner"){
						$row_inner=$rows_inner_and_elements[1][$rows_inner_and_elements_count];
						$rows_inner_and_elements_html .= get_backend_inner_row_html($row_inner);
					}	
					else{
						//get element
						$element_shortcode=$rows_inner_and_elements[1][$rows_inner_and_elements_count]; //element shortcode

						$element_setting = get_element_setting($row_inner_and_element_key,$element_shortcode,$elements_arr);
					
						$rows_inner_and_elements_html .= get_element_backend_html($row_inner_and_element_key,$element_setting,$elements_arr,$element_shortcode);
					}
					$rows_inner_and_elements_count++;				
				}
			}//end rows inner and elements
		
		   //get the inner column setting
		   $column_setting = get_element_setting('yee_column',$column,$elements_arr_ex);
		
		   //get the inner column params html
		   $column_params_html = get_params_html($elements_arr_ex['yee_column']['params'],$column_setting);
		
		   //get the column attribute
		   preg_match('/\[yee_column\s.*?width="(.*?)"[\s\S]*?]/',$column,$column_attr_value);
		   $column_partition_single=$column_attr_value?$column_attr_value[1]:'1/1';
		   $column_attrs['width']=$column_attr_value?($arr[$column_partition_single]):12;
		   $column_partition = $column_attr_value?($column_partition?$column_partition." + ".$column_partition_single:$column_partition_single):$column_partition;
		   
		   $visiable_class = $column_setting['visiable']?'fa-eye':'fa-eye-slash';
		   
		   $column_html .= '
						  <div class="yee-col-xs-'.$column_attrs['width'].'">
						  <div class="yee-well yee-well-sm wrapper">
								<input class="yee_element_base" type="hidden" value="yee_column" yee-name="" />
								'.$column_params_html.'
								<div class="yee_group_3 yee-wgt">'.
								$rows_inner_and_elements_html
							  .'</div>
								<div class="text-center yee-col-settings">
									<div class="yee-btn-group">
										<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_visiable"><i class="fa '.$visiable_class.'"></i>&nbsp</a>
										<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_add_row_ele_btn"><i class="fa fa-plus"></i> '.JText::_('YEEDITOR_WRAPPER_WIDGET').'</a>
										<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_edit"><i class="fa fa-edit"></i> '.JText::_('YEEDITOR_WRAPPER_EDIT').'</a>
									</div>
								</div>
								<input class="yee_element_base" type="hidden" value="yee_column_end" name=""/>
						  </div>		
						  </div>';
		}
		
		$visiable_class = $row_setting['visiable']?'fa-eye':'fa-eye-slash';
		
		$row_html = ' 
				<div class="yee-row wrapper">
					<div class="yee-col-xs-12">
						<input class="yee_element_base" type="hidden" value="yee_row" name=""/>
						'.$row_params_html.'
						<div class="yee-panel yee-panel-default">
							<div class="yee-panel-heading clearfix">
								<h4 class="yee-panel-title pull-left"><span class="fw-title">'.JText::_('YEEDITOR_WRAPPER_ROW').'</span> <small>'.$column_partition.'</small> </h4>
								<div class="text-center">
									<div class="pull-right yee-btn-group yee-pull-right">
										<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_visiable"><i class="fa '.$visiable_class.'"></i></a>
										<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_edit"><i class="fa fa-edit"></i></a>
										<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_clone"><i class="fa fa-copy"></i></a>
										<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_delete"><i class="fa fa-times"></i></a>
									</div>
									<div class="yee-btn-group">
										<button type="button" class="yee-btn yee-btn-default yee-btn-xs custom_column">'.JText::_('YEEDITOR_WRAPPER_CUSTOM_COLUMN').'</button>
										<button type="button" class="yee-btn yee-btn-default yee-btn-xs yee-dropdown-toggle" data-yee-toggle="dropdown">
											<span class="yee-caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="yee-dropdown-menu text-left yee_columnTypes" role="menu">
											<li'.($column_partition?($column_partition=='1/1'?' class="active"':''):' class="active"').'><a href="#" title="1/1"><i class="yee_icon-grid01"></i> <span class="nav-text">1/1</span></a> </li>
											<li'.($column_partition=='1/2 + 1/2'?' class="active"':'').'><a href="#" title="1/2 + 1/2"><i class="yee_icon-grid02"></i> <span class="nav-text">1/2 + 1/2</span></a> </li>
											<li'.($column_partition=='2/3 + 1/3'?' class="active"':'').'><a href="#" title="2/3 + 1/3"><i class="yee_icon-grid03"></i> <span class="nav-text">2/3 + 1/3</span></a> </li>
											<li'.($column_partition=='1/3 + 1/3 + 1/3'?' class="active"':'').'><a href="#" title="1/3 + 1/3 + 1/3"><i class="yee_icon-grid04"></i> <span class="nav-text">1/3 + 1/3 + 1/3</span></a> </li>
											<li'.($column_partition=='1/4 + 1/4 + 1/4 + 1/4'?' class="active"':'').'><a href="#" title="1/4 + 1/4 + 1/4 + 1/4"><i class="yee_icon-grid05"></i> <span class="nav-text">1/4 + 1/4 + 1/4 + 1/4</span></a> </li>
											<li'.($column_partition=='1/4 + 3/4'?' class="active"':'').'><a href="#" title="1/4 + 3/4"><i class="yee_icon-grid06"></i> <span class="nav-text">1/4 + 3/4</span></a> </li>
											<li'.($column_partition=='1/4 + 1/2 + 1/4'?' class="active"':'').'><a href="#" title="1/4 + 1/2 + 1/4"><i class="yee_icon-grid07"></i> <span class="nav-text">1/4 + 1/2 + 1/4</span></a> </li>
											<li'.($column_partition=='5/6 + 1/6'?' class="active"':'').'><a href="#" title="5/6 + 1/6"><i class="yee_icon-grid08"></i> <span class="nav-text">5/6 + 1/6</span></a> </li>
											<li'.($column_partition=='1/5 + 1/5 + 1/5 + 1/5 + 1/5'?' class="active"':'').'><a href="#" title="1/5 + 1/5 + 1/5 + 1/5 + 1/5"><i class="yee_icon-grid09"></i> <span class="nav-text">1/5 + 1/5 + 1/5 + 1/5 + 1/5</span></a> </li>
											<li'.($column_partition=='1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6'?' class="active"':'').'><a href="#" title="1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6"><i class="yee_icon-grid10"></i> <span class="nav-text">1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6</span></a> </li>
										</ul>
										<input type="hidden" class="column_group" value="'.$column_partition.'"/>
									</div>
								</div>
							</div>
					   
							<div class="yee_group_2 yee-panel-body">
								<div class="yee-row">'.
								$column_html
							  .'</div>
							</div>
							<input class="yee_element_base" type="hidden" value="yee_row_end" name=""/>
					 </div>
				</div>	
			</div>';
				
		$rows_html[]=$row_html;
	}
	
	$yeecontent=str_replace($rows[0],$rows_html,$content);
	if(isset($_POST['set_intro_text']) && $_POST['set_intro_text']=="active"){
		$yeecontent = '
			<div class="yee-row yee_intro_text">
				<div class="yee-col-md-12 ">
					<div class="yee-widget yee-wgt-faq">
						<div class="yee-panel-group">
							<div class="yee-panel yee-panel-default">
								<div class="yee-panel-heading text-center">
								  <h4 class="yee-panel-title">
									<a href="#intro-text-0" data-yee-toggle="collapse">'.JText::_('YEEDITOR_WRAPPER_INTRO_TEXT').'</a>
								  </h4>
								</div>
								<div class="yee-panel-collapse yee-collapse" id="intro-text-0">
								  <div class="yee-panel-body">
									<textarea id="yee_intro_text" style="width:100%;height:80px;">'.$intro_text.'</textarea>
								  </div>
								</div>
							</div>
						</div>
					</div>			
				</div>
			</div>
			'.$yeecontent;
	}
	if($rows[0]){
		$yeecontent .= '<input type="text" style="display:none;" id="widget_num" value="'.$widget_num.'"/>';
	}
	
	return $yeecontent;
}
//get backend inner row html
function get_backend_inner_row_html($content){
	global $yee_widget;
	$elements_arr=$yee_widget;
	$elements_arr_ex=yeeMap::map_ex();
	
	$arr=array("1/12"=>1,"1/6"=>2,"2/12"=>2,"1/5"=>"2-4","1/4"=>3,"2/8"=>3,"3/12"=>3,"1/3"=>4,"2/6"=>4,"3/9"=>4,"4/12"=>4,"5/12"=>5,"1/2"=>6,"2/4"=>6,"3/6"=>6,"4/8"=>6,"6/12"=>6,"7/12"=>7,"2/3"=>8,"4/6"=>8,"6/9"=>8,"8/12"=>8,"3/4"=>9,"6/8"=>9,"9/12"=>9,"5/6"=>10,"10/12"=>10,"11/12"=>11,"1/1"=>12,"12/12"=>12);
	
	$column_inner_html="";
	$column_inner_partition="";
	$row_inner_html="";
	
	//get the inner row setting
	$row_inner_setting = get_element_setting('yee_row_inner',$content,$elements_arr);
	
	//get the inner row params html
	$row_inner_params_html = get_params_html($elements_arr['yee_row_inner']['params'],$row_inner_setting);
	
	//column inner
	preg_match_all('/\[yee_column_inner[\s\]][\s\S]*?\[\/yee_column_inner]/i',$content,$columns_inner);
	foreach($columns_inner[0] as $column_inner){
		//get the inner column setting
		$column_inner_setting = get_element_setting('yee_column_inner',$column_inner,$elements_arr_ex);
		
		//get the inner column params html
		$column_inner_params_html = get_params_html($elements_arr_ex['yee_column_inner']['params'],$column_inner_setting);
	
	   //get the inner column attribute
	   preg_match('/\[yee_column_inner\s.*?width="(.*?)"[\s\S]*?]/',$column_inner,$column_inner_attr_value);
	   $column_inner_partition_single=$column_inner_attr_value?$column_inner_attr_value[1]:'1/1';
	   $column_inner_attrs['width']=$column_inner_attr_value?($arr[$column_inner_partition_single]):12; 
	   $column_inner_partition = $column_inner_attr_value?($column_inner_partition?$column_inner_partition." + ".$column_inner_partition_single:$column_inner_partition_single):$column_inner_partition;
	   
	   //get the inner elements
	   $elements_inner_html = get_backend_widgets_html($column_inner);
	   
	   $visiable_class = $column_inner_setting['visiable']?'fa-eye':'fa-eye-slash';
	   
	   $column_inner_html .= '
			<div class="yee-col-xs-'.$column_inner_attrs['width'].'">
				<div class="yee-well yee-well-sm wrapper">
					<input class="yee_element_base" type="hidden" value="yee_column_inner" yee-name="" />
					'.$column_inner_params_html.'
					<div class="yee_group_5 yee-wgt">'.
						   $elements_inner_html
				  .'</div>
				   <div class="text-center yee-col-settings">
						<div class="yee-btn-group">
							<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_visiable"><i class="fa '.$visiable_class.'"></i>&nbsp</a>
							<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_add_ele_btn"><i class="fa fa-plus"></i> '.JText::_('YEEDITOR_WRAPPER_WIDGET').'</a>
							<a href="#" class="yee-btn yee-btn-info yee-btn-xs tooltip-test yee_ele_edit"><i class="fa fa-edit"></i> '.JText::_('YEEDITOR_WRAPPER_EDIT').'</a>
						</div>
					</div>
					<input class="yee_element_base" type="hidden" value="yee_column_inner_end" name=""/>  
				</div>		               
			</div>';
	}
	
	$visiable_class = $row_inner_setting['visiable']?'fa-eye':'fa-eye-slash';
	
	$row_inner_html .= '
				 <div class="yee-row wrapper yee_inner_row">
					<div class="yee-col-xs-12">
							<input class="yee_element_base" type="hidden" value="yee_row_inner" name=""/>
							'.$row_inner_params_html.'
							<div class="yee-panel yee-panel-default">
								<div class="yee-panel-heading clearfix">
									
									<h4 class="yee-panel-title pull-left"><span class="fw-title">'.JText::_('YEEDITOR_WRAPPER_ROW').'</span> <small>'.$column_inner_partition.'</small> </h4>
									<div class="text-center">
										<div class="pull-right yee-btn-group yee-pull-right">
											<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_visiable"><i class="fa '.$visiable_class.'"></i></a>
											<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_edit"><i class="fa fa-edit"></i></a>
											<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_clone"><i class="fa fa-copy"></i></a>
											<a href="#" class="yee-btn yee-btn-link yee-btn-xs yee_ele_delete"><i class="fa fa-times"></i></a>
										</div>
										<div class="yee-btn-group">
											<button type="button" class="yee-btn yee-btn-default yee-btn-xs custom_column">'.JText::_('YEEDITOR_WRAPPER_CUSTOM_COLUMN').'</button>
											<button type="button" class="yee-btn yee-btn-default yee-btn-xs yee-dropdown-toggle" data-yee-toggle="dropdown">
												<span class="yee-caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="yee-dropdown-menu text-left yee_columnTypes" role="menu">
												<li'.($column_inner_partition?($column_inner_partition=='1/1'?' class="active"':''):' class="active"').'><a href="#" title="1/1"><i class="yee_icon-grid01"></i> <span class="nav-text">1/1</span></a> </li>
												<li'.($column_inner_partition=='1/2 + 1/2'?' class="active"':'').'><a href="#" title="1/2 + 1/2"><i class="yee_icon-grid02"></i> <span class="nav-text">1/2 + 1/2</span></a> </li>
												<li'.($column_inner_partition=='2/3 + 1/3'?' class="active"':'').'><a href="#" title="2/3 + 1/3"><i class="yee_icon-grid03"></i> <span class="nav-text">2/3 + 1/3</span></a> </li>
												<li'.($column_inner_partition=='1/3 + 1/3 + 1/3'?' class="active"':'').'><a href="#" title="1/3 + 1/3 + 1/3"><i class="yee_icon-grid04"></i> <span class="nav-text">1/3 + 1/3 + 1/3</span></a> </li>
												<li'.($column_inner_partition=='1/4 + 1/4 + 1/4 + 1/4'?' class="active"':'').'><a href="#" title="1/4 + 1/4 + 1/4 + 1/4"><i class="yee_icon-grid05"></i> <span class="nav-text">1/4 + 1/4 + 1/4 + 1/4</span></a> </li>
												<li'.($column_inner_partition=='1/4 + 3/4'?' class="active"':'').'><a href="#" title="1/4 + 3/4"><i class="yee_icon-grid06"></i> <span class="nav-text">1/4 + 3/4</span></a> </li>
												<li'.($column_inner_partition=='1/4 + 1/2 + 1/4'?' class="active"':'').'><a href="#" title="1/4 + 1/2 + 1/4"><i class="yee_icon-grid07"></i> <span class="nav-text">1/4 + 1/2 + 1/4</span></a> </li>
												<li'.($column_inner_partition=='5/6 + 1/6'?' class="active"':'').'><a href="#" title="5/6 + 1/6"><i class="yee_icon-grid08"></i> <span class="nav-text">5/6 + 1/6</span></a> </li>
												<li'.($column_inner_partition=='1/5 + 1/5 + 1/5 + 1/5 + 1/5'?' class="active"':'').'><a href="#" title="1/5 + 1/5 + 1/5 + 1/5 + 1/5"><i class="yee_icon-grid09"></i> <span class="nav-text">1/5 + 1/5 + 1/5 + 1/5 + 1/5</span></a> </li>
												<li'.($column_inner_partition=='1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6'?' class="active"':'').'><a href="#" title="1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6"><i class="yee_icon-grid10"></i> <span class="nav-text">1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6</span></a> </li>
										   </ul>
										   <input type="hidden" class="column_group" value="'.$column_inner_partition.'"/>
										</div>
									</div>
								</div>
						
								<div class="yee_group_4 yee-panel-body">
									<div class="yee-row">'.
										$column_inner_html
							  	  .'</div>
							  	</div>
								<input class="yee_element_base" type="hidden" value="yee_row_inner_end" name=""/>
							</div>
					  </div>
				  </div>';
				  
	return $row_inner_html;			  
}
//get backend widgets html
function get_backend_widgets_html($shortcode){
	global $yee_widget;
	$elements_arr=$yee_widget;
	$elements_html="";
	$preg_str="";
	
	foreach($elements_arr as $key=>$element_value_temp){
		  $preg_str = $preg_str?($preg_str.'|'.$key):($key);
	}	  
	
	if(preg_match_all('/(\[\b('.$preg_str.')\b[\s\]][\s\S]*?\[\/\b\2\b[\s\]])/i',$shortcode,$elements,PREG_PATTERN_ORDER)){
		$i=0;
		foreach( $elements[2] as $element_key){
				$element_shortcode=$elements[1][$i];
				
				$element_setting = get_element_setting($element_key,$element_shortcode,$elements_arr);
				
				$elements_html .= get_element_backend_html($element_key,$element_setting,$elements_arr,$element_shortcode);					
	
				$i++;
		}		
	}
	return $elements_html;
}

function get_element_backend($element_key,$element_shortcode){
    $elements_html="";
	global $yee_widget;
	$elements_arr=$yee_widget;
	
	$element_setting = get_element_setting($element_key,$element_shortcode,$elements_arr);	

	$elements_html = get_element_backend_html($element_key,$element_setting,$elements_arr,$element_shortcode);				

	return $elements_html;
}
/****************** layout backend function end **********/

function get_image_url($old_url){
	$single_image_url = $old_url;
	if($old_url){
		$single_image_url = "";
		$root=JURI::root();
		if(!strstr($old_url,"http://") && !strstr($old_url,"https://")){
			$single_image_url = $root.$old_url;
		}
		else{
			$single_image_url = $old_url;
		}
	}
	return $single_image_url;
}

function ContentImageUrlRelativeToAbsolute($oldCotnet){
	$root = JURI::root();
	$handledContent = preg_replace('/[\s]src="images\//',' src="'.$root.'images/',$oldCotnet);
	return $handledContent;
}

function yee_image_resize($srcPath,$resize_params=array()){
	$width = isset($resize_params['width'])?$resize_params['width']:'';
	$height = isset($resize_params['height'])?$resize_params['height']:'';
	$root = JURI::root();
	$app = JFactory::getApplication();
	if ($app->isAdmin()) { 
		$root .= "administrator/";
	}
	$url = get_image_url($srcPath);
	
	if(($width == '' && $height == '') || !$url){
		return $url;
	}
	else{
		$url = $root.'index.php?option=com_yeeditor&task=yeeditor_action&layout=timthumb&format=raw&src='.$url.'&amp;q=100&amp;w='.$width.'&amp;h='.$height;
		return $url;
	}
}

function yeeditor_load_backend_assets(){
	//add yourself css/js
	$document =JFactory::getDocument();
	//jquery
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/jquery-ui-1.10.4.custom.min.css'); 
	//bootstrap
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/yeeditor.admin.css'); 
	//color picker
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/bootstrap-colorpicker.css');
	//color picker
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/bootstrap-datetimepicker.min.css');
	//font-awesome 
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/font-awesome.min.css'); 
	//codemirror	
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/codemirror.css');
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/style-box.css');
	$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/docs-backend.css');
			
	//jquery					
	JHtml::_('jquery.framework');
	JHtml::_('bootstrap.framework');
	JHtml::_('jquery.ui', array('core', 'sortable'));
		
	//$document->addScript(YEEDITOR_ASSETS_URL.'js/jquery-ui-1.10.2.custom.min.js');
	//base64
	$document->addScript(YEEDITOR_ASSETS_URL.'js/base64.js');	
	//json
	//$document->addScript(YEEDITOR_ASSETS_URL.'js/json2.js');
	//bootstrap
	$document->addScript(YEEDITOR_ASSETS_URL.'js/bootstrap/yeeditor-bs-min.js');
	//ckeditor	
	$document->addScript(YEEDITOR_ASSETS_URL.'js/ckeditor/ckeditor.js');	
	//tinymce	
	$document->addScript(YEEDITOR_ASSETS_URL.'js/tinymce/jquery.tinymce.min.js');
	$document->addScript(YEEDITOR_ASSETS_URL.'js/tinymce/tinymce.min.js');	
	//codemirror	
	$document->addScript(YEEDITOR_ASSETS_URL.'js/codemirror.js');
	$document->addScript(YEEDITOR_ASSETS_URL.'js/mode/xml.js');	
	$document->addScript(YEEDITOR_ASSETS_URL.'js/mode/javascript.js');
	$document->addScript(YEEDITOR_ASSETS_URL.'js/mode/css.js');
	$document->addScript(YEEDITOR_ASSETS_URL.'js/mode/htmlmixed.js');
	//color picker
	$document->addScript(YEEDITOR_ASSETS_URL.'js/bootstrap-colorpicker.js');
	//date picker
	$document->addScript(YEEDITOR_ASSETS_URL.'js/bootstrap-datetimepicker.min.js');
	//custom
	$document->addScript(YEEDITOR_ASSETS_URL.'js/yeeditor.js');
	
	$widget_ex_path=JPATH_ROOT."/administrator/components/com_yeeditor/widgets_ex/";
	$widget_ex_url=JURI::root()."administrator/components/com_yeeditor/widgets_ex/";
	$folders=JFolder::folders($widget_ex_path);
	//include widgets backend css/js
	foreach($folders as $folder){
		$css_path=$widget_ex_path.$folder."/backend/assets/css/".$folder.".css";
		$css_url=$widget_ex_url.$folder."/backend/assets/css/".$folder.".css";
		$js_path=$widget_ex_path.$folder."/backend/assets/js/".$folder.".js";
		$js_url=$widget_ex_url.$folder."/backend/assets/js/".$folder.".js";
		if(is_file($css_path)){
			$document->addStyleSheet($css_url);
		}
		if(is_file($js_path)){
			$document->addScript($js_url);	
		}
	}
}

