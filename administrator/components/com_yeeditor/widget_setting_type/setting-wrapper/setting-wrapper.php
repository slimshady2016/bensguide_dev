<?php 
/*------------------------------------------------------------------------
# YETemplate
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;

//You can find the setting and value in the '$element_setting' varible. 
$arr=array("1/12"=>1,"1/6"=>2,"2/12"=>2,"1/5"=>"2_4","1/4"=>3,"2/8"=>3,"3/12"=>3,"1/3"=>4,"2/6"=>4,"3/9"=>4,"4/12"=>4,"5/12"=>5,"1/2"=>6,"2/4"=>6,"3/6"=>6,"4/8"=>6,"6/12"=>6,"7/12"=>7,"2/3"=>8,"4/6"=>8,"6/9"=>8,"8/12"=>8,"3/4"=>9,"6/8"=>9,"9/12"=>9,"5/6"=>10,"10/12"=>10,"11/12"=>11,"1/1"=>12,"12/12"=>12);
?>
<?php foreach($element_param['child_params'] as $row){?>
<div class="yee-row">
	<?php foreach($row as $column){?>
	<div class="yee-col-xs-<?php echo $arr[$column['width']];?>">
		<?php foreach($column['items'] as $item){?>
		<?php 
			   $hide_class = "";
			   $setting_relation = "";
			   $setting_parent = "";
			   if(isset($item['setting-relation']) && !in_array($element_setting[$item['setting-relation']['parent']],$item['setting-relation']['group'])){
					$hide_class = " hide";
					$setting_relation = ' data-setting-relation="'.implode(',',$item['setting-relation']['group']).'"';
			   }
			   if(isset($item['display']) && $item['display']=="none"){
					$hide_class = " hide";
			   }
			   if(isset($item['setting-parent']) && $item['setting-parent']==true){
					$setting_parent = ' data-setting-parent="true"';
			   }
		?>
				<div class="form-group<?php echo (isset($item['display'])?($item['display']=="none"?' hide':''):'');?>"<?php echo $setting_relation.$setting_parent;?>>
					<?php if($item['heading']){?>
					<label for="exampleInputFile"><?php echo $item['heading'];?></label>
					<?php }?>
					<?php get_element_child_setting_html($widget_name,$item,$element_setting);?>
					<?php if($item['description']){?> 
					<div class="yee-help-block small"><?php echo $item['description'];?></div>
					<?php }?>
					<hr>
				</div>
				<div class="clearfix"></div>
		<?php } ?>	 
	</div>
	<?php }?>
</div>
<?php }?>