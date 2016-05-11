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
	<?php foreach($row as $column){?>
		<?php foreach($column['items'] as $item){?>
				<?php if($item['heading']){?>
				<label for="exampleInputFile"<?php echo (isset($item['display'])?($item['display']=="none"?' style="display:none;"':''):'');?>><?php echo $item['heading'];?></label>
				<?php }?>
		        <?php get_element_child_setting_html($widget_name,$item,$element_setting);?>
				<?php if($item['description']){?> 
				<p class="yee-help-block small"><?php echo $item['description'];?></p>
				<?php }?>
		<?php } ?>	 
	<?php }?>
<?php }?>