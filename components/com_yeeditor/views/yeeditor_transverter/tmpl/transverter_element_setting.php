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

$ajax_return="";

display_element_setting_edit($_POST['element_key'],$_POST['element_shortcode']);

//echo $ajax_return;

function display_element_setting_edit($element_key,$element_shortcode){
	$output=""; 

	if($element_key){
		$setting_types_folders = JFolder::folders(YEEDITOR_COMPONENT_ADMIN_PATH."widget_setting_type/");

	    global $yee_widget,$yee_widget_extend,$widget_key_name;
		$elements_arr=$yee_widget;
		$elements_extend_arr=$yee_widget_extend;
		$elements_arr_ex=yeeMap::map_ex();
	    $elements_arr=array_merge($elements_arr,$elements_arr_ex);
		$elements_arr=array_merge($elements_arr,$elements_extend_arr);
		$widget_name = isset($widget_key_name[$element_key])?$widget_key_name[$element_key]:$element_key;
		
		$element_setting = get_element_setting($element_key,$element_shortcode,$elements_arr);
		$element_params = $elements_arr[$element_key]['params'];
		$visiable = isset($element_setting['visiable'])?$element_setting['visiable']:'';

		echo '<div class="yee-modal-header">';
				if($visiable != ''){
				echo '<div class="yee-btn-group pull-right">
						<label class="yee-btn yee-btn-default yee-btn-xs'.($visiable==1?' active':'').' yetpl-visiable">
							<span class="glyphicon glyphicon-eye-open"></span> '.JText::_('YEEDITOR_WRAPPER_SHOW').'
						</label>
						<label class="yee-btn yee-btn-default yee-btn-xs'.($visiable==0?' active':'').' yetpl-visiable">
							<span class="glyphicon glyphicon-eye-close"></span> '.JText::_('YEEDITOR_WRAPPER_HIDDEN').' 
						</label>
					  </div>';
				}	  
				echo  '<h4 class="yee-modal-title">'.$elements_arr[$element_key]['name'].'</h4>
				    </div>';
		echo '<div class="yee-modal-body yee_widget_setting_body">';			
		
		//tabs
		$tabs_header = "";
		$tabs_footer = "";
		$tabs = isset($elements_arr[$element_key]['tabs'])?$elements_arr[$element_key]['tabs']:array();
		if($tabs){
			$tabs_param = array();
			$tab_default = "";
		
			$tabs_header .= '<ul class="yee-nav yee-nav-tabs">';
			$i = 0;
			foreach($tabs as $tab_key => $tab_value){
				if($i == 0){
					$tab_default = $tab_key;
				}
				$tabs_param[$tab_key] = array();
				
				$tabs_header .=  '<li'.($tab_key==$tab_default?' class="active"':'').'>
									<a data-yee-toggle="tab" href="#'.$tab_key.'">'.($tab_key=="setting-about"?$tab_value['title']:$tab_value).'</a>
								  </li>';
				$i++;	  
			}
			$tabs_header .= '</ul>';
			$tabs_header .= '<div class="yee-tab-content">';
			$tabs_footer .= '</div>';	
			
			foreach($element_params as $element_param){
				$tab = isset($element_param['tab'])?$element_param['tab']:$tab_default;
				$tabs_param[$tab][] = $element_param;
			}
			
			//output
			echo $tabs_header;
			foreach($tabs_param as $tab_key => $tab_param){
				echo '<div id="'.$tab_key.'" class="yee-tab-pane'.($tab_key==$tab_default?' active':'').'">';
				if($tab_key=="setting-about"){
					echo get_element_html($tabs['setting-about']['information']);
				}
				else{
					foreach($tab_param as $element_param){
						get_element_setting_html($widget_name,$element_param,$element_setting);
					}
				}
				echo '</div>';
			}
			echo $tabs_footer;
		}
		else{
			foreach($element_params as $element_param){
				get_element_setting_html($widget_name,$element_param,$element_setting);
			}
		}
		
		echo '</div>';	
		
		echo '<div class="yee-modal-footer">
				<button data-yee-dismiss="modal" class="yee-btn yee-btn-default" type="button">'.JText::_('YEEDITOR_WRAPPER_CLOSE').'</button>
				<button id="yee_widget_edit_save" class="yee-btn yee-btn-primary" type="button">'.JText::_('YEEDITOR_WRAPPER_SAVE').'</button>
			  </div>';
	}	
	
}

?>
