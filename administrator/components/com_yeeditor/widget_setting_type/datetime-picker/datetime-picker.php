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

//You can find the setting and value in the '$element_param' varible. 

$type_attrbute="";
$output="";

if(isset($element_param['type_attrbute'])){
	$type_attrbute=$element_param['type_attrbute'];
}	
	
$setting_value = $element_setting[$element_param['param_name']];	

$data_format = "MM/dd/yyyy hh:mm:ss";
if(isset($element_param['data-format'])){
	$data_format = $element_param['data-format'];
}

$date_time = array("date","time");
if(isset($element_param['date-time'])){
	$date_time = $element_param['date-time'];
}

?>

<div class="yee-input-group yee-col-xs-3">
	<input type="text" class="yee-form-control"<?php echo isset($element_param['placeholder'])?' placeholder="'.$element_param['placeholder'].'"':'';?> name="<?php echo $element_param['param_name'];?>" value="<?php echo $setting_value;?>" <?php echo $type_attrbute;?> data-format="<?php echo $data_format;?>"/>
	<span class="yee-input-group-addon add-on">
	  <i data-date-icon="glyphicon glyphicon-calendar">
	  </i>
	</span>
</div>
				
<script type="text/javascript" charset="utf-8">
(function($){
	$(function(){
		
		$('#widgetModal input[name="<?php echo $element_param['param_name'];?>"]').parent().datetimepicker({
			pickDate:<?php echo in_array("date",$date_time)?1:0;?>,
			pickTime:<?php echo in_array("time",$date_time)?1:0;?>
		}).on('changeDate', function(ev){
			
		});
		
	})
})(window.jQuery);
</script>				
