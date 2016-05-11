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

$input_number=2;	
if(isset($element_param['input_number']))
	$input_number=$element_param['input_number'];	
?>
<div class="row-fluid " <?php echo (isset($element_param['display'])?($element_param['display']=="none"?'style="display:none;"':''):'');?>>
	<div class="yee-setting-heading"><strong><?php echo $element_param['heading'];?></strong></div>
	<div class="yee-setting-value">
		<textarea name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?>><?php echo $element_param['value'];?></textarea>
	</div>
	<div class="yee-setting-item-list" data-name="<?php echo $element_param['param_name'];?>">
		<ul class="items-list">
			<li class="add_new_item single-item" data-name='<?php echo $element_param['param_name'];?>' data-number='<?php echo $input_number?>'><i class="icon-plus"></i></li>
		</ul>
	</div>
	<div class="yee-setting-description"><?php echo $element_param['description'];?></div>
</div>	
<style>
.items-list li{
	font-size: 1.4em;
    height: 30px;
    margin: 0 3px 3px;
    padding: 0.4em 0.4em 0.4em 1.5em;
	background-color: wheat;
	list-style: none outside none;
}
.single-item{
	border: 1px solid #D3D3D3;
    color: #555555;
    font-weight: normal;
}

div#yee .single-item input{ margin-bottom:0;margin-left: 16px;}
div#yee .items-list .icon-resize-vertical{ float:left;margin: 7px 0 0 10px;}
div#yee .items-list .icon-plus{ margin: 7px 0 0 50%;}
div#yee .items-list .icon-remove{float: right;margin: 8px 10px 0 0;}
</style>

<script type="text/javascript">
(function($){
	$(function(){
		$('.yee-setting-item-list .add_new_item').click(function(){
				var element = $(this),
					name = $(this).attr('data-name'),
					number = $(this).attr('data-number');

				add_item(element,name,number);
			});
		$('div[data-name="<?php echo $element_param['param_name'];?>"] .items-list').sortable({
			items: "li:not(.add_new_item)",
			stop: function(){
				get_data('<?php echo $element_param['param_name'];?>');
			},
			placeholder: "ui-state-highlight",
			helper: "clone",
			tolerance: "pointer"
		});
			
		function add_item(element,name,number){
			var html_str='<li class="single-item"><i class="icon-resize-vertical"></i>';
			
			for(var i = 0; i < number; i ++){
				html_str = html_str + '<input type="text" style="width:'+(1/number*75)+'%" class="item_data" value="" onchange="get_data(\''+name+'\')"/>';
			}
			
			html_str = html_str + '<i class="icon-remove" onclick="remove_item($(this),\''+name+'\')"></i></li>';

			$(html_str).insertBefore(element);
			get_data(name);
		}

		function get_data(name){
			var base64 = new Base64();
			var data_arr=[];
			var i=0;
			$('div[data-name="'+name+'"] ul li:not(.add_new_item)').each(function(){
				var k=0;
				data_arr[i]=[];
				$($(this).find('.item_data')).each(function(e){
					data_arr[i].push($(this).val());
				})
				i++;
			})
			$('div[data-name="'+name+'"]').parent().find('textarea[name="'+name+'"]').val(base64.encode(JSON.encode(data_arr)));
		}

		function remove_item(element,name){
			element.parent().remove();
			get_data(name);
		}

		function init_data(name,number){
			var base64 = new Base64();
			var data_arr=JSON.decode(base64.decode($('textarea[name="'+name+'"]').val()));
			if(data_arr){
				var html_str='';
				for(var i = 0; i < data_arr.length; i ++){
					html_str = html_str + '<li class="single-item"><i class="icon-resize-vertical"></i>';
					
					for(var k = 0; k < data_arr[i].length; k ++){
						html_str = html_str + '<input type="text" style="width:'+(1/number*75)+'%" class="item_data" value="'+data_arr[i][k]+'" onchange="get_data(\''+name+'\')"/>';
					}
					
					html_str = html_str + '<i class="icon-remove" onclick="remove_item($(this),\''+name+'\')"></i></li>';
				}
				$(html_str).insertBefore('div[data-name="'+name+'"] .add_new_item');
			}
		}
		init_data('<?php echo $element_param['param_name'];?>','<?php echo $input_number?>');
	})
})(window.jQuery);
</script>
