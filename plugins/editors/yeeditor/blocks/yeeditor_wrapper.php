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

global $yee_widget,$widget_key_name,$yee_widget_extend,$widget_group,$yee_widget_parent_extend;
$elements_arr=$yee_widget;	
$elements_arr_ex=yeeMap::map_ex();
$elements_extend_arr=$yee_widget_extend;
$element_parent_extend_arr=$yee_widget_parent_extend;

$intro_text_option_allow = array("com_content","com_content","com_k2");
$intro_text_view_allow = array("article","form","item");
$set_intro_text = "";
foreach($intro_text_option_allow as $key=>$option_temp){
	if(JRequest::getVar('option')==$option_temp && JRequest::getVar('view')==$intro_text_view_allow[$key] ){
		$set_intro_text = "active";
	}
}

$widget_arr=array();
if(JFactory::getApplication()->input->get('yeeditor_template')&&JFactory::getApplication()->input->get('yeeditor_template')!="all"){
	foreach($elements_arr as $key=>$element_arr){
		if(isset($element_arr['model'])){
			if($element_arr['model']==JFactory::getApplication()->input->get('yeeditor_template') || $element_arr['model']=="all"){
				$widget_arr[$key]=$element_arr;
			}
		}
	}
	JFactory::getApplication()->input->set('yeeditor_template', false);
}
else if(JFactory::getApplication()->input->get('yeeditor_template')=="all"){
	$widget_arr=$elements_arr;
	JFactory::getApplication()->input->set('yeeditor_template', false);
}	
else{
	foreach($elements_arr as $key=>$element_arr){
		if(isset($element_arr['model'])){
			if($element_arr['model']=="all"){
				$widget_arr[$key]=$element_arr;
			}
		}
		else{
			$widget_arr[$key]=$element_arr;
		}
	}
	JFactory::getApplication()->input->set('yeeditor_template', false);
}

//get templates
$database = JFactory::getDbo();
$sqlquery =  "select id,name from #__yeeditor where published=1";
$database->setQuery( $sqlquery );
if (!$result = $database->query()) {
   echo $database->stderr();
   return false;
}
$templates=$database->loadObjectList(); 

//get yeeditor statu
$statu=get_yeeditor_option('yeeditor_status');

//row insert plugin 
$row_insert_plugin = get_insert_plugin_html(array("yee_row"),$elements_arr,$widget_group,$widget_key_name);
//global insert plugin 
$global_insert_plugin = get_insert_plugin_html(array("yee_row_inner"),$elements_arr,$widget_group,$widget_key_name);
//row inner insert plugin 
$filter=array();
foreach($element_parent_extend_arr as $key=>$value){
	if(!isset($elements_extend_arr[$value]['box_html']) || $elements_extend_arr[$value]['box_html']==true){
		$filter[]=$key;
	}	
} 
$row_inner_insert_plugin = get_insert_plugin_html(array_merge($filter,array("yee_row","yee_row_inner")),$elements_arr,$widget_group,$widget_key_name);
//widget insert plugin 
$widget_insert_plugin = get_insert_plugin_html(array_merge($filter,array("yee_row")),$elements_arr,$widget_group,$widget_key_name);
		
//Load yeeditor assets		
yeeditor_load_backend_assets();				

$arr=array("1/12"=>1,"1/6"=>2,"2/12"=>2,"1/5"=>"2-4","1/4"=>3,"2/8"=>3,"3/12"=>3,"1/3"=>4,"2/6"=>4,"3/9"=>4,"4/12"=>4,"5/12"=>5,"1/2"=>6,"2/4"=>6,"3/6"=>6,"4/8"=>6,"6/12"=>6,"7/12"=>7,"2/3"=>8,"4/6"=>8,"6/9"=>8,"8/12"=>8,"3/4"=>9,"6/8"=>9,"9/12"=>9,"5/6"=>10,"10/12"=>10,"11/12"=>11,"1/1"=>12,"12/12"=>12);

$jsMessage = array(
	"YEEDITOR_WRAPPER_CUSTOM_COLUMN_WANRING" => JText::_('YEEDITOR_WRAPPER_CUSTOM_COLUMN_WANRING'),
	"YEEDITOR_WRAPPER_SAVE_TEMPLATE" => JText::_('YEEDITOR_WRAPPER_SAVE_TEMPLATE'),
	"YEEDITOR_WRAPPER_MANAGE_TEMPLATE" => JText::_('YEEDITOR_WRAPPER_MANAGE_TEMPLATE'),
	"YEEDITOR_SHORTCODE_CONVERT" => JText::_('YEEDITOR_SHORTCODE_CONVERT'),
	"YEEDITOR_WRAPPER_YEEDITOR" => JText::_('YEEDITOR_WRAPPER_YEEDITOR'),
	"YEEDITOR_WRAPPER_SOURCE_EDITOR" => JText::_('YEEDITOR_WRAPPER_SOURCE_EDITOR')
);

$magic_quotes_gpc_warning='';
if (get_magic_quotes_gpc()==1){
	$magic_quotes_gpc_warning='
<div class="yee-message-warning"><button data-dismiss="alert" class="close" type="button">&times;</button><div class="alert alert-error">
<h4 class="alert-heading">Error</h4>
<p>Your host needs to disable magic_quotes_gpc to run this version of YEEditor!</p>
</div>
</div>
';
}
?>

<?php echo $magic_quotes_gpc_warning;?>
<script type="text/javascript">
	var yee_sc_area_id = "<?php echo $id;?>"; 
	var yee_root = "<?php echo $root;?>";
	var yee_frontend = "<?php echo JURI::root();?>";
	var yee_location = "<?php echo $location;?>";
	var set_intro_text = "<?php echo $set_intro_text;?>";
	
	var elements_arr_ex=<?php echo $elements_arr_ex?json_encode($elements_arr_ex):"[]";?>;
	var elements_arr=<?php echo $elements_arr?json_encode($elements_arr):"[]";?>;
	var element_extend_arr=<?php echo $elements_extend_arr?json_encode($elements_extend_arr):"[]";?>;
	var yee_widget_parent_extend=<?php echo $yee_widget_parent_extend?json_encode($yee_widget_parent_extend):"[]";?>;

	var base64 = new Base64()
	var row_insert_plugin=base64.decode("<?php echo base64_encode($row_insert_plugin);?>");
	var global_insert_plugin=base64.decode("<?php echo base64_encode($global_insert_plugin);?>");
	var row_inner_insert_plugin=base64.decode("<?php echo base64_encode($row_inner_insert_plugin);?>");
	var widget_insert_plugin=base64.decode("<?php echo base64_encode($widget_insert_plugin);?>");
	
	var yeeditor_status = "<?php echo $statu?$statu:0;?>";
	
	var percent_arr=<?php echo json_encode($arr);?>;
	
	//message
	var jsMessage = <?php echo $jsMessage?json_encode($jsMessage):"[]";?>;
</script>	

<div class="yeeditor">
	<div class="yeeditor-toogle">
		<button class="yee-btn yee-btn-default yee-btn-primary" id="yeeditorToogleButton"><?php echo JText::_('YEEDITOR_WRAPPER_YEEDITOR');?></button>
		<button class="yee-btn yee-btn-default yee-btn-warning" id="otherEditorToogleButton" data-status="<?php echo $editor_status;?>"><?php echo JText::_('YEEDITOR_WRAPPER_OTHER_EDITOR');?></button>
	</div>
	
	<div id="yeeditor" class="yeeditor-content">
		<div class="yee_outter_header">
		  <nav role="navigation" class="yee-navbar yee-navbar-default yee-navbar-inverse">
			  <div class="yee-container-fluid">
			  	<div class="yeeditor-backdrop"></div>
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="yee-navbar-header">
				  <a href="#" class="yee-navbar-brand"><?php echo JText::_('YEEDITOR_WRAPPER_YEEDITOR'); ?><small> <?php echo JText::_('YEEDITOR_WRAPPER_YEEDITOR_DESC'); ?></small></a>
				</div>
			
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div id="bs-example-navbar-collapse-1" class="yee-collapse yee-navbar-collapse">
				  <ul class="yee-nav yee-navbar-nav">
					<li><a id="yee_add_row" href="#"><i class="fa fa-plus"></i> <?php echo JText::_('YEEDITOR_WRAPPER_NEW_ROW'); ?></a></li>
					<li><a id="insert_plugin" href="#"><i class="fa fa-briefcase"></i> <?php echo JText::_('YEEDITOR_WRAPPER_INSERT_PLUGIN'); ?></a></li>
					<li>
						<a data-yee-toggle="dropdown" id="yee_add_template" class="yee-btn yee-btn-small yee-dropdown-toggle"><i class="fa fa-list-alt"></i> Templates <span class="yee-caret"></span></a>
						<ul class="yee-dropdown-menu template_action">
							<li><a id="save_template" href="#"><i class="fa fa-save"></i> <?php echo JText::_('YEEDITOR_WRAPPER_SAVE_TEMPLATE'); ?></a></li>
							<li class="divider"></li>
							<li><a href="<?php echo JURI::root().'administrator/index.php?option=com_yeeditor&view=templates';?>" target="_blank"><i class="fa fa-list-alt"></i> <?php echo JText::_('YEEDITOR_WRAPPER_MANAGE_TEMPLATE'); ?></a></li>
							<li class="divider"></li>
							<?php foreach($templates as $template){?>
							<li><a class="load_template" data-yee-id="<?php echo $template->id;?>"><?php echo $template->name;?></a></li>
							<?php }?>
						</ul>
					</li>
					<li id="save_button"><a href="#"><i class="fa fa-save"></i> <?php echo JText::_('YEEDITOR_WRAPPER_SAVE_ARTICLE'); ?> </a></li>
				  </ul>
				</div>
			  </div>
			</nav>
		</div>
		
		<!-- main content -->
		<main class="main-yee-layout yee-container-fluid">
		  <div class="yee-container-fluid">
			<div class="yee_group_1"></div>
		  </div>
		</main>  
		
		<!-- modal start-->
		<!--insert plugin-->
		<div aria-hidden="true" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="-1" class="yee-modal fade bs-example-modal-lg" id="pluginModal">
		<div class="yee-modal-dialog yee-modal-lg">
			<div class="yee-modal-content">
				<div class="yee-modal-body">
					<?php echo $global_insert_plugin;?>
				</div>
			</div>
		</div>
		</div>
		<!--widget setting-->
		<div aria-hidden="true" aria-labelledby="widgetModalLabel" role="dialog" tabindex="-1" class="yee-modal fade" id="widgetModal">
		<div class="yee-modal-dialog yee-modal-lg">
			<div class="yee-modal-content"></div>
		</div>
		</div>
		<!--delete confirm-->
		<div aria-hidden="true" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="-1" class="yee-modal fade bs-example-modal-lg" id="deleteModal">
			<div class="yee-modal-dialog">
				<div class="yee-modal-content">
					<div class="yee-modal-header">
						<button aria-hidden="true" data-yee-dismiss="modal" class="yee-close" type="button">&times;</button>
						<h4 class="yee-modal-title"><?php echo JText::_('YEEDITOR_WRAPPER_DELETE'); ?></h4>
					</div>
					<div class="yee-modal-body">
						<p><?php echo JText::_('YEEDITOR_WRAPPER_DELETE_WARNING'); ?></p>
					</div>
					<div class="yee-modal-footer">
						<div class="text-center">
							<button data-yee-dismiss="modal" class="yee-btn yee-btn-primary delete_yes" type="button"><?php echo JText::_('JYES'); ?></button>
							<button class="yee-btn yee-btn-default delete_no" type="button"><?php echo JText::_('JNO'); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<!--custom columns-->
		<div aria-hidden="true" aria-labelledby="customColumnModalLabel" role="dialog" tabindex="-1" class="yee-modal fade" id="customColumnModal">
			<div class="yee-modal-dialog">
				<div class="yee-modal-content">
					<div class="yee-modal-header">
						<button aria-hidden="true" data-yee-dismiss="modal" class="yee-close" type="button">&times;</button>
						<h4 id="customColumnModalLabel" class="yee-modal-title"><?php echo JText::_('YEEDITOR_WRAPPER_CUSTOM_COLUMN'); ?></h4>
					</div>
					<div class="yee-modal-body">
						<div class="form-group">
							<input type="text" class="yee-form-control" id="custom_column_value">
						</div>
					</div>
					<div class="yee-modal-footer">
						<button data-yee-dismiss="modal" class="yee-btn yee-btn-default" type="button"><?php echo JText::_('YEEDITOR_WRAPPER_CLOSE'); ?></button>
						<button class="yee-btn yee-btn-primary save_custom_column_value" type="button"><?php echo JText::_('YEEDITOR_WRAPPER_SAVE'); ?></button>
					</div>
				</div>
			</div>
		</div>
		<!--template name-->
		<div aria-hidden="true" aria-labelledby="templateNameModalLabel" role="dialog" tabindex="-1" class="yee-modal fade" id="templateNameModal">
			<div class="yee-modal-dialog">
				<div class="yee-modal-content">
					<div class="yee-modal-header">
						<button aria-hidden="true" data-yee-dismiss="modal" class="yee-close" type="button">&times;</button>
						<h4 id="templateNameModalLabel" class="yee-modal-title"><?php echo JText::_('YEEDITOR_WRAPPER_TEMPLATE_NAME'); ?></h4>
					</div>
					<div class="yee-modal-body">
						<div class="form-group">
							<input type="text" class="yee-form-control" id="template_name">
						</div>
					</div>
					<div class="yee-modal-footer">
						<button data-yee-dismiss="modal" class="yee-btn yee-btn-default" type="button"><?php echo JText::_('YEEDITOR_WRAPPER_CLOSE'); ?></button>
						<button class="yee-btn yee-btn-primary submit_template_name" type="button"><?php echo JText::_('YEEDITOR_WRAPPER_SAVE'); ?></button>
					</div>
				</div>
			</div>
		</div>
		<!--message box-->
		<div aria-hidden="true" aria-labelledby="messageModalLabel" role="dialog" tabindex="-1" class="yee-modal fade bs-example-modal-lg" id="messageModal">
			<div class="yee-modal-dialog">
				<div class="yee-modal-content">
					<div class="yee-modal-header">
						<button aria-hidden="true" data-yee-dismiss="modal" class="yee-close" type="button">&times;</button>
						<h4 class="yee-modal-title"><?php echo JText::_('YEEDITOR_WRAPPER_WARNING'); ?></h4>
					</div>
					<div class="yee-modal-body">
					</div>
					<div class="yee-modal-footer">
						<button data-yee-dismiss="modal" class="yee-btn yee-btn-default" type="button"><?php echo JText::_('YEEDITOR_WRAPPER_CLOSE'); ?></button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal end-->
		
		<div class="hide" id="yee_html_holder"></div>
	</div>
</div>