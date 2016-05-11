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

//You can find the setting and value in the '$element_param' varible. 

$type_attrbute="";
$output="";

if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];
	
$database = JFactory::getDbo();
$sqlquery =  "SELECT id, module, title FROM #__modules WHERE  `client_id`=0 AND ( `published` !=-2 AND `published` !=0 ) ORDER BY title ASC";
$database->setQuery( $sqlquery );
$database->query();
if (!$result = $database->query()) {
   //echo $database->stderr();
   return false;
}
$modules_arr=$database->loadObjectList(); 	

$setting_value = $element_setting[$element_param['param_name']];		
?>

<select class="yee-form-control" name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?>>
<?php if(is_array($modules_arr) && $modules_arr){?>
	<?php foreach($modules_arr as $module){?>
			 <option value="<?php echo $module->id;?>" <?php echo ($setting_value==$module->id?'selected="selected"':'');?>><?php echo $module->title;?></option>
	<?php }?>
<?php }?>
</select>
