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

//You can find the setting and value in the '$element_param' varible. 
defined( '_JEXEC' ) or die;
$type_attrbute="";
$output="";

if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];

$textarea_number = 1;	
if(isset($element_param['textarea_number']))
	$textarea_number=$element_param['textarea_number'];	
?>
<div class="row-fluid" <?php echo (isset($element_param['display'])?($element_param['display']=="none"?'style="display:none;"':''):'');?>>
	<div><strong><?php echo $element_param['heading'];?></strong></div>
	<div>
		<textarea name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?>><?php echo $element_param['value'];?></textarea>
	</div>
	<div class="items-list">		
		<div class="item-single">
			<textarea class="item-change"></textarea>
			<input class="item-change"/>	
			<input class="item-change"/>						
			<a class="icon-remove"></a>
		</div>
		
	</div>
	<a class="add_new_item"><i class="icon-plus"></i></a>		
	<div><?php echo $element_param['description'];?></div>
</div>	
<style type="text/css">
	.item-single{
		background-color: #e4edf9;
		padding: 10px 20px;
		margin-bottom: 4px;
		position: relative;
	}
	.item-change{
		float: none;
		width: 70%;
		display: block;
	}
	.item-single .icon-remove{
		position: absolute;
		top: 10px;
		right: 10px;
		cursor: pointer;
	}
	.add_new_item{
		background: #b9d4f6;
		text-align: center;
		display: block;
		cursor: pointer;
	}
</style>

<script type="text/javascript">
$(function(){
	var base64 = new Base64();	
	(function(){
		var data = JSON.decode(base64.decode($('textarea[name="'+'<?php echo $element_param['param_name'];?>'+'"]').val()));
		if(data){
			$('.items-list').html('');
			$.each(data,function(key, value){
				var $obj = $('<div class="item-single"><textarea class="item-change"></textarea><input class="item-change"/><input class="item-change"/><a class="icon-remove"></a></div>').appendTo($('.items-list'));
				
				$obj.find('.item-change').eq(0).val(value[0]);
				$obj.find('.item-change').eq(1).val(value[1]);
				$obj.find('.item-change').eq(2).val(value[2]);
			})
		}				
		
		function dataChange(){
			var data_arr = [];
			$('.item-single').each(function(i, o){
				var arr = [],
					obj = $(this).find('.item-change');
				arr.push(obj.eq(0).val());
				arr.push(obj.eq(1).val());
				arr.push(obj.eq(2).val());
				data_arr.push(arr);
			});
			
			$('textarea[name="'+'<?php echo $element_param['param_name'];?>'+'"]').val(base64.encode(JSON.encode(data_arr)));
		}	
		$('.add_new_item').click(function(){
			$('<div class="item-single"><textarea class="item-change"></textarea><input class="item-change"/><input class="item-change"/><a class="icon-remove"></a></div>').appendTo($(this).prev());
			dataChange();
			$('.item-change').change(function(){
				dataChange();
			});
			$('.item-single .icon-remove').click(function(){
				$(this).parent().remove();
				dataChange();
			});
		});
		$('.item-change').change(function(){
			dataChange();
		});
		$('.item-single .icon-remove').click(function(){
			$(this).parent().remove();
			dataChange();
		});
	})()
})
</script>
