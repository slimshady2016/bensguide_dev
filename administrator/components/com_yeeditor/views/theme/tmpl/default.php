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

// no direct access
defined('_JEXEC') or die;

require_once JPATH_PLUGINS."/editors/yeeditor/define.php"; 
require_once YEEDITOR_COMPONENT_ADMIN_PATH.'helpers/theme.php';

$root = JURI::root();

$document =JFactory::getDocument();
//bootstrap
$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/yeeditor.admin.css'); 
//color picker
$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/bootstrap-colorpicker.css');
//font-awesome 
$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/font-awesome.min.css');
//messenger
$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/messenger.css'); 
$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/messenger-theme-future.css');
//custom
$document->addStyleSheet(YEEDITOR_ASSETS_URL.'css/yet-theme.css'); 

//jquery
$document->addScript(YEEDITOR_ASSETS_URL.'/js/jquery-1.9.1.min.js');
//json
$document->addScript(YEEDITOR_ASSETS_URL.'js/json2.js');
//messenger
$document->addScript(YEEDITOR_ASSETS_URL.'js/messenger.min.js');	
$document->addScript(YEEDITOR_ASSETS_URL.'js/messenger-theme-future.js'); 
//base64
$document->addScript(YEEDITOR_ASSETS_URL.'js/base64.js');	
//bootstrap
$document->addScript(YEEDITOR_ASSETS_URL.'js/bootstrap/yeeditor-bs-min.js');
//color picker
$document->addScript(YEEDITOR_ASSETS_URL.'js/bootstrap-colorpicker.js');
//custom
$document->addScript($root.'administrator/components/com_yeeditor/assets/js/theme.js');		

$bootstrap_variable_less_path = YEEDITOR_PATH.'assets/less/variables.less';
$theme_variable_less_path = YEEDITOR_PATH.'assets/less/yeeditor.theme.less';

$less_arr = get_variables_by_less($bootstrap_variable_less_path);
$theme_less_arr = get_variables_by_less($theme_variable_less_path);

$main_categories = array(
						"bootstrapVar"=>array(
												"title" => 'Bootstrap Customization',
												"categories" => $less_arr
						),
						"themeVar"=>array(
									"title" => 'YEEditor',
									"categories" => $theme_less_arr
						)
				   );

$jsMessage = array(
	"COM_YEEDITOR_FIELD_THEME_SUCCESS_PARSE" => JText::_('COM_YEEDITOR_FIELD_THEME_SUCCESS_PARSE'),
	"COM_YEEDITOR_FIELD_THEME_ERROR_PARSE" => JText::_('COM_YEEDITOR_FIELD_THEME_ERROR_PARSE'),
	"COM_YEEDITOR_FIELD_THEME_SUCCESS_SAVE" => JText::_('COM_YEEDITOR_FIELD_THEME_SUCCESS_SAVE'),
	"COM_YEEDITOR_FIELD_THEME_ERROR_SAVE" => JText::_('COM_YEEDITOR_FIELD_THEME_ERROR_SAVE'),
);				   
				   	
?>
<script type="text/javascript">
var less_arr = <?php echo json_encode($less_arr);?>;
var theme_less_arr = <?php echo json_encode($theme_less_arr);?>;
var admin_url = "<?php echo $root."administrator/"?>";
var yee_root = admin_url;
var yee_frontend = '<?php echo $root?>';
var filed_name = "";
var theme = "";

//message
var jsMessage = <?php echo $jsMessage?json_encode($jsMessage):"[]";?>;
</script>

<div class="yeeditor">
	<div class="yetpl_style_header">
	  
	  <nav class="yee-navbar yee-navbar-default yee-navbar-inverse" role="navigation">
		  <div class="yee-container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="yee-navbar-header">
			  <a class="yee-navbar-brand" href="#"><?php echo JText::_('COM_YEEDITOR_FIELD_THEME_CONTENT_TITLE'); ?> <small> <?php echo JText::_('COM_YEEDITOR_FIELD_THEME_CONTENT_TITLE_DESC'); ?></small></a>
			</div>
		
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="yee-collapse yee-navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="yee-nav yee-navbar-nav yee-navbar-right">
				<li>
					<div class="yee-btn-group yee-navbar-btn">
						<button class="yee-btn yee-btn-primary" id="combine_css" type="button"><i class="fa fa-gears"></i> <?php echo JText::_('COM_YEEDITOR_FIELD_THEME_PARSE'); ?></button>
					</div>
					<div class="yee-btn-group yee-navbar-btn">
					  <button type="button" class="yee-btn yee-btn-primary" id="yet_save_style"><i class="fa fa-save"></i> <?php echo JText::_('COM_YEEDITOR_FIELD_THEME_SAVE'); ?></button>
					</div>
					
				</li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	  
	</div>
	
	<section class="yet-theme">
		<div class="page-container">
	
			<div class="page-sidebar-wrapper">
				<div class="page-sidebar">
					<ul id="yet-theme-menu" class="page-sidebar-menu">
						<?php $i = 0;?>
						<?php foreach($main_categories as $key => $categories){?>
						<li class="yee-panel<?php echo $i==0?' active':'';?>">
							<a data-yee-toggle="collapse" data-yee-parent="#yet-theme-menu" href="#yet-theme-submenu-<?php echo $key;?>">
								<span class="title">
									<?php echo $categories['title'];?>
								</span>
								<span class="arrow ">
								</span>
							</a>
							<ul id="yet-theme-submenu-<?php echo $key;?>" class="sub-menu yee-collapse<?php echo $i==0?' in':'';?>">
							<?php $k = 0;?>
							<?php foreach($categories['categories'] as $key1 => $category){?>
							<?php if($category['type'] != '//--'){?>
								<li<?php echo $k==0 && $i==0?' class="active"':'';?>>
									<a href="#<?php echo $key;?>-category-<?php echo $key1;?>">
										<?php echo $category['title'];?>
									</a>
								</li>
							<?php $k++;?>	
							<?php }?>		
							<?php }?>	
							</ul>
						</li>
						<?php $i++;?>
						<?php }?>
					</ul>
				</div>
			</div>
			
			<?php $i = 0;?>
			<?php foreach($main_categories as $key => $categories){?>
				<?php foreach($categories['categories'] as $key1 => $category){?>
				<?php if($category['type'] != '//--'){?>
				<div class="page-content-wrapper<?php echo $i!=0?' hide':'';?>" id="<?php echo $key;?>-category-<?php echo $key1;?>">
					<div class="page-content">
						<div class="yee-row">
							<div class="yee-col-md-12">
								<!-- BEGIN PAGE TITLE -->
								<h3 class="page-title">
								<?php echo $category['title'];?>
								</h3>
								<p><?php echo $category['description'].$category['description_ex'];?></p>
								<!-- END PAGE TITLE -->
		
								<hr>
		
								<?php foreach($category['variables'] as $key2 => $variables){?>
									<table class="yee-table yee-table-bordered">
										<tbody>
											<tr>
												<td rowspan="2" class="column1">
													<div class="yee-btn-group yee-btn-link" data-toggle="buttons"<?php echo $variables['constant']==1?'':' data-keys="'.$key.'-'.$key1.'-'.$key2.'"';?>>
														<label class="yee-btn yee-btn-primary<?php echo $variables['constant']==1?' disabled':'';?>">
															<span class="fa <?php echo $variables['visiable']==1?'fa-eye':'fa-eye-slash';?>"></span>
														</label>
													</div>
												</td>
												<th class="column2"><?php echo $variables['name'];?></th>
												<th class="column3">Description</th>
											</tr>
											<tr>
												<td>
													<?php 
														$arg = array("placeholder" => trim($variables['name']));
														echo get_setting_filed($key.'-'.$key1.'-'.$key2, $variables['value'], $key.'-'.$key1.'-'.$key2, $variables['setting_type'], $arg);
													?>
												</td>
												<td><?php echo $variables['description']." ".$variables['note'];?></td>
											</tr>
										</tbody>
									</table>
								<?php }?>
								
							</div>
						</div>
					</div>
				</div>
				<?php $i++;?>
				<?php }?>	
				<?php }?>	
			<?php }?>
	
		</div>
	</section>	
	
</div>		