!function($){
	$(function(){
		yee = {
			scHolder: $('#' + yee_sc_area_id),
			htmlHolder: $('.yeeditor .yee_group_1'),
			replaceHolder: $("#yee_html_holder"),
			pluginModalIsRow: true,
			custom_colum_e: '',
			element_count: parseInt(1000000*Math.random()),
			global_wgt_num: $('#widget_num').val(),
			global_param:new Array(),
			column_width : {"1/12":1,"1/6":2,"2/12":2,"1/5":"2_4","1/4":3,"2/8":3,"3/12":3,"1/3":4,"2/6":4,"3/9":4,"4/12":4,"5/12":5,"1/2":6,"2/4":6,"3/6":6,"4/8":6,"6/12":6,"7/12":7,"2/3":8,"4/6":8,"6/9":8,"8/12":8,"3/4":9,"6/8":9,"9/12":9,"5/6":10,"10/12":10,"11/12":11,"1/1":12,"12/12":12},
			addNewRow: function(){
				$("#yee_add_row").click(function(e){
					e.preventDefault();
					var element_key = 'yee_row',
						textarea_content = '',
						element_shortcode = '',
						element_shortcode_column = '';					  
											  
					yee.htmlHolder = $('.yeeditor .yee_group_1');
													 
					element_shortcode_column = yee.addNewShortcode('yee_column','');
					
					element_shortcode = yee.addNewShortcode('yee_row',element_shortcode_column);
						
						
					$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_setting&format=raw",
							dataType : "html",
							data: {
								   element_key : element_key,
								   element_shortcode : element_shortcode
							},
							success: function (data) {
								$("#pluginModal").yeeModal("hide");
								$("#widgetModal .yee-modal-content").html(data);
								$("#widgetModal").yeeModal({
									yeeBackdrop: 'static', //prevent click outside of modal and close modal
									yeeKeyboard: false
								});
								yee.settingTypeCallback();	
								$.ajax({
										type: "POST",
										url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element&format=raw",
										dataType : "html",
										data: {
											action            : "yee_get_row_element_backend_html",
											element_key       : element_key,
											element_shortcode : element_shortcode
										},
										success: function (data) {
											yee.replaceHolder.html(data);
											var base = yee.replaceHolder.find('.yee_element_base').eq(0);
											yee_global_wgtContainer = base.parent();
											yee_global_params = yee.replaceHolder.find('.yee_element_base').eq(0).nextAll('.yee_element_param_value');
											if(!yee_global_params.length){
												yee_global_params = yee.replaceHolder.find('.yee_element_param_value');
											}
											yee.htmlHolder.append(yee.replaceHolder.children());
											yee_global_isWgt = false;
											yee.transSc();
											yee.do_sortable();
										}
								});
								
							}
					});		
				});
			},
			settingAction: function(){
				$('#widgetModal').delegate('.yetpl-visiable', 'click', function(e){
					e.preventDefault();
					if($(this).find("span").hasClass("glyphicon-eye-open")){
						$('#widgetModal input[name="visiable"]').removeAttr("checked");
						$('#widgetModal input[name="visiable"][value=1]').attr("checked",true);
						$('#widgetModal input[name="visiable"]').parent().removeClass("active");
						$('#widgetModal input[name="visiable"][value=1]').parent().addClass("active");
						$('#widgetModal .yetpl-visiable').removeClass("active");
						$(this).addClass("active");
					}
					else if($(this).find("span").hasClass("glyphicon-eye-close")){
						$('#widgetModal input[name="visiable"]').removeAttr("checked");
						$('#widgetModal input[name="visiable"][value=0]').attr("checked",true);
						$('#widgetModal input[name="visiable"]').parent().removeClass("active");
						$('#widgetModal input[name="visiable"][value=0]').parent().addClass("active");
						$('#widgetModal .yetpl-visiable').removeClass("active");
						$(this).addClass("active");
					}
				})
				
				$('#widgetModal').delegate('.column-size', 'click', function(e){
					e.preventDefault();
					var column_size = $(this).find('input[name="column-size"]').val()
					yee.updateColumnSizeType(column_size);
				
				})
				
				$('.yeeditor').delegate('.yee_ele_visiable', 'click', function(e){
					e.preventDefault();
					if($(this).find("i").hasClass("fa-eye")){
						$(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
						$(this).parents(".wrapper").eq(0).find('input[yee-name="visiable"].yee_element_param_value').eq(0).val(0);
					}
					else if($(this).find("i").hasClass("fa-eye-slash")){
						$(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
						$(this).parents(".wrapper").eq(0).find('input[yee-name="visiable"].yee_element_param_value').eq(0).val(1);
					}
					yee.transSc();
				})
				
				$('#widgetModal').delegate('.form-group[data-setting-parent="true"] .yee-form-control', 'change', function(e){
					e.preventDefault();
					var setting_parent = $(this).val();
					$('#widgetModal .form-group').each(function(i, obj){
						var setting_relation = $(this).attr("data-setting-relation");
						if(setting_relation){
							var setting_group = setting_relation.split(',');
							if(in_array(setting_parent,setting_group)){
								$(this).removeClass("hide");
							}
							else{
								$(this).addClass("hide");
							}
						}
					})
				})
				
				function in_array(stringToSearch, arrayToSearch) {
					for (var s = 0; s < arrayToSearch.length; s++) {
						thisEntry = arrayToSearch[s].toString();
						if (thisEntry == stringToSearch) {
							return true;
						}
					}
					return false;
				}
			},
			updateColumnSizeType: function(column_size){
				if(!column_size){
					column_size = $('#widgetModal input[name="column-size"]').parent().parent().find('.active input[name="column-size"]').val();
				}
				$('#widgetModal .column-size-relate').removeClass("disabled");
				$('#widgetModal .' + column_size).removeClass("active").addClass("disabled");
				$('#widgetModal input[name="' + column_size + '"][value="' + (yee.column_width[$('#widgetModal input[name="width"]').val()]) + '"]').parent().removeClass("disabled").addClass("active");
			},
			saveSetting: function(){
				$('.yeeditor').delegate('#yee_widget_edit_save', 'click', function(e){										  
					e.preventDefault();
					
					var el_key = yee_global_wgtContainer.find('.yee_element_base').eq(0).val(),
						_url = yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element&format=raw";
				
					var $wrapper =  $('#widgetModal');
					$(yee_global_params).each(function(i, obj){
						var $obj = $(obj),
							name = $obj.attr('yee-name'),
							type = $wrapper.find('[name =' + name + ']').attr('type');

						if($obj.hasClass('ck-editor')){
							$obj.html(CKEDITOR.instances['yee_setting_'+ name].getData());
						}else if($obj.hasClass('code-mirror')){
							$obj.html(editor_code_mirror_global.getValue());
						}else if($obj.hasClass('tinymce-editor')){
							$obj.html(document.getElementById(name+'_iframe').contentWindow.tinyMCE.get(name).getContent());
						}else if($obj.hasClass('jce-editor')){
							$obj.html(document.getElementById(name+'_iframe').contentWindow.WFEditor.getContent(name));	
						}else if($obj.hasClass('jck-editor')){
							$obj.html(document.getElementById(name+'_iframe').contentWindow.CKEDITOR.instances[name].getData());
						}else if($obj.hasClass('main_content')){
							$obj.html($wrapper.find('[name =' + name + ']').val());
						}else if(type == 'checkbox'){
							if($wrapper.find('[name =' + name + ']').parent().hasClass('active')){
								$obj.val($wrapper.find('[name =' + name + ']').val());
							}else{
								$obj.val('');
							}
						}else if(type == 'radio'){
							$wrapper.find('[name =' + name + ']').each(function(i, o){
								if($(o).parent().hasClass('active')){
									$obj.val($(o).val());
								}
							})
						}else{
							$obj.val($wrapper.find('[name =' + name + ']').val());
						}
					});
					
					if(element_extend_arr[el_key]){ 
						_url = yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_inner&format=raw";
					}
					$('#widgetModal').yeeModal('hide');

					if(yee_global_isWgt){
						var sc = yee.transSc(yee_global_wgtContainer);
						$.ajax({
								type: "POST",
								url: _url, 
								dataType : "html",
								data: {
									action            : "yee_get_element_backend_html",
									element_key       : el_key,
									element_shortcode : sc
								},
								success: function (data) {
									if(element_extend_arr[el_key]){
										var data_obj = JSON.decode(data);
										yee.replaceHolder.html(data_obj.html);
									
										yee_global_wgtContainer.html(data_obj.html);  
										if(function_is_Exist(el_key+"_edit_callback")){ 
											eval(el_key + "_edit_callback" + "(" + JSON.encode(data_obj)+")");
										}
									}else{
										yee.replaceHolder.html(data);
										yee.replaceHolder.children().insertAfter(yee_global_wgtContainer);	
										yee_global_wgtContainer.remove();							
									}
												
									yee.transSc();
									yee.do_sortable();
								}
						});
					}else{ 
						
						var visiable_class="fa-eye";
						$('#widgetModal').find('input[name ="visiable"]').each(function(i, o){
							if($(o).parent().hasClass('active')){
								if($(o).val() != 1){
									visiable_class="fa-eye-slash";
								}
							}
						})
						yee_global_wgtContainer.find('.yee_ele_visiable i').eq(0).removeClass("fa-eye").removeClass("fa-eye-slash").addClass(visiable_class);
						
						yee.transSc();
					}
				});
			},
			addNewShortcode: function(element_key,includeShortcode){
				var textarea_content = "",
					element_shortcode = "[" + element_key,
					setting_arr = [],
					params_arr = [];

				if(element_key == 'yee_column' || element_key == 'yee_column_inner'){
					setting_arr = elements_arr_ex;
				}
				else{
					setting_arr = elements_arr;
				}	
	
				params_arr = yee.getDefaultParams(setting_arr[element_key]["params"]);

				$.each(params_arr, function(key, val){ 
					if(typeof(val.main_content) != 'undefined' && val.main_content == true){
					   textarea_content = val.value;
					}else{
					   element_shortcode = element_shortcode+" "+val.param_name+"=\""+val.value+"\"";
					}
				});
				
				if(yee_widget_parent_extend[element_key]){
					var element_extend_shortcode = "";
					var element_extend_key = yee_widget_parent_extend[element_key];
					yee.element_count ++;
					var max_i = typeof(element_extend_arr[element_extend_key]['default_item_number'])!=='undefined'?element_extend_arr[element_extend_key]['default_item_number']:2;
					for(var i=1; i<=max_i;i++){	 //default to show two items
						element_extend_shortcode= element_extend_shortcode+"["+element_extend_key;	
						$.each(element_extend_arr[element_extend_key]["params"],function(key,val){		
							if(val.param_number == 'unique'){
								element_extend_shortcode = element_extend_shortcode + " " + val.param_name + "=\"" + val.value + "-" + yee.element_count + "-" + i+ "\"";
							}else{
								element_extend_shortcode = element_extend_shortcode + " " + val.param_name + "=\"" + val.value + "\"";
							}							                   
							
						});
						element_extend_shortcode=element_extend_shortcode+"][/"+element_extend_key+"]";
					}
				
					element_shortcode = element_shortcode+"]" + textarea_content + element_extend_shortcode + "[/"+element_key+"]";
				}else{
					element_shortcode = element_shortcode+"]" + textarea_content + includeShortcode + "[/"+element_key+"]";
				}

				return element_shortcode;
			},
			getDefaultParams: function(params_arr){
				var result = new Array();
				
				$.each(params_arr, function(key, val){ 
					if(typeof(val.child_params) === 'undefined'){ 	
						result.push(val);
					}
					else{
						$.each(val.child_params, function(key2, val2){
							$.each(val2, function(key3, val3){  
								result = result.concat(yee.getDefaultParams(val3.items));
							})
					   })
					}
				});
				
				return result;
			},
			addNewWidget: function(){
				$('.yeeditor').delegate("#insert_plugin","click",function(e){
					e.preventDefault();
					yee.pluginModalIsRow = true;
					yee.htmlHolder = $('.yeeditor .yee_group_1');
					$('#pluginModal').yeeModal();
				})
				
				$('.yeeditor').delegate(".yee-widget-group a","click",function(e){
					e.preventDefault();
					$(".yee-widget-group a").removeClass("active");
					$(this).addClass("active");
				})
				
				
				$('#pluginModal').delegate(".element_item","click",function(e){
					e.preventDefault();
					var element_key=$(this).attr("data-yee-key");
					var textarea_content="";
					var element_shortcode="";
			
					element_shortcode = yee.addNewShortcode(element_key,'');
					
					$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_setting&format=raw", 
							dataType : "html",
							data: {
								   element_key : element_key,
								   element_shortcode : element_shortcode
							},
							success: function (data) {
								$("#pluginModal").yeeModal("hide");
								$("#widgetModal .yee-modal-content").html(data);
								$("#widgetModal").yeeModal({
									yeeBackdrop: 'static', //prevent click outside of modal and close modal
									yeeKeyboard: false
								})
								yee.settingTypeCallback();						
													
								var obj = {};
								if(yee.pluginModalIsRow){
									textarea_content = "";
									var element_shortcode_row = '';
									var element_shortcode_column = '';
											
									if(element_key == 'yee_row'){		
										element_shortcode = '';
									}
									
									element_shortcode_column = yee.addNewShortcode('yee_column',element_shortcode);
									element_shortcode_row = yee.addNewShortcode('yee_row',element_shortcode_column);
									
									obj = {
										action            : "yee_get_row_element_backend_html",
									   element_key       : element_key,
									   element_shortcode : element_shortcode_row
									}
								}else{
									obj = {
										action            : "yee_get_element_backend_html",
									   element_key       : element_key,
									   element_shortcode : element_shortcode
									}
								}
								$.ajax({
										type: "POST",
										url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element&format=raw",
										dataType : "html",
										data: obj,
										success: function (data) {
											yee.replaceHolder.html(data); 
											var base = yee.replaceHolder.find('.yee_element_base').eq(0);
											yee_global_params = base.nextAll('.yee_element_param_value');
											if(!yee_global_params.length){
												yee_global_params = yee.replaceHolder.find('.yee_element_param_value');
											}
											var holder_child = yee.replaceHolder.children();
											if(yee.pos =='first'){
												yee.htmlHolder.prepend(holder_child);
											}else{
												yee.htmlHolder.append(holder_child);
											}
											
											if(element_key !='yee_row' && element_key !='yee_row_inner'){ 
												yee_global_isWgt = true;
												if(yee.pluginModalIsRow){	
													yee_global_wgtContainer = holder_child.find('input[value="' + element_key + '"].yee_element_base').parents('.wrapper').eq(0);
												}else{ 
													yee_global_wgtContainer = holder_child;
												}
												if(yee_widget_parent_extend[element_key]){ // == 'yee_tabs'){
													yee_global_isWgt = false;
													yee_global_params = yee_global_wgtContainer.find('.yee_element_base').eq(0).nextAll('.yee_element_param_value');
												}else{
													yee_global_params = yee_global_wgtContainer.find('.yee_element_param_value');
												}
												
											}else{
												yee_global_isWgt = false;
												yee_global_wgtContainer = base.parent();
											}
											
											yee.transSc();
											yee.do_sortable();
										}
								});
							}
					});		
				});
				$('.yeeditor').delegate('.yee_add_row_ele_btn','click',function(e){
					e.preventDefault();
					yee.pluginModalIsRow = false;
					var insert_plugin_html = row_insert_plugin;
					if($(e.target).hasClass('yee_add_level_one')){
						yee.pluginModalIsRow = true;
						insert_plugin_html = row_inner_insert_plugin;
					}
					if($(e.target).hasClass('first')){
						yee.pos = 'first';
					}
					if($(e.target).hasClass('last')){
						yee.pos = 'last';
					}
					$('#pluginModal .yee-modal-body').html(insert_plugin_html);
					$('#pluginModal').yeeModal();
					
					yee.htmlHolder = $(e.target).parent().parent().prev();
				});
				$('.yeeditor').delegate('.yee_add_ele_btn','click', function(e){
					e.preventDefault();
					yee.pluginModalIsRow = false;
					$('#pluginModal .yee-modal-body').html(row_inner_insert_plugin);
					$('#pluginModal').yeeModal();
					
					yee.htmlHolder = $(e.target).parent().parent().prev();
				});
				$('.yeeditor').delegate('.yee_add_ele_inner_btn','click', function(e){
					e.preventDefault();
					yee.pluginModalIsRow = false;
					$('#pluginModal .yee-modal-body').html(widget_insert_plugin);
					$('#pluginModal').yeeModal();
					
					yee.htmlHolder = $(e.target).parent().parent().prev();
				});
			},
			editWidget: function(){
				$('.yeeditor').delegate(".yee_ele_edit", "click", function(e){
					e.preventDefault();
					var wgtContainer;
					
					wgtContainer = $(e.target).parents('.wrapper').eq(0);
					

					var base = wgtContainer.find('.yee_element_base').eq(0).val(),
						params = wgtContainer.find('.yee_element_param_value'),
						sc_str = '[' + base ,
						sc_str2;
					
					if(base == 'yee_row' || base =='yee_row_inner' || base =='yee_column' || base =='yee_column_inner' ){
						yee_global_isWgt = false;
						params =  wgtContainer.find('.yee_element_base').eq(0).nextAll('.yee_element_param_value');
					}else{
						if(yee.checkIsExtend(base)){
							params =  wgtContainer.find('.yee_element_base').eq(0).nextAll('.yee_element_param_value');
						}
						yee_global_isWgt = true;
					}
			
					yee_global_params = params;
					yee_global_wgtContainer = wgtContainer;
					
					sc_str = yee.transSc(wgtContainer,true);
					
					$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_setting&format=raw",
							dataType : "html",
							data: {
								   element_key : base,
								   element_shortcode : sc_str
							},
							success: function (data) {
								$("#pluginModal").yeeModal("hide");
								$("#widgetModal .yee-modal-content").html(data);
								if(base=='yee_column' || base=='yee_column_inner'){
									var parent_column_size = $(e.target).parents('.panel').eq(0).parent().find('> input[yee-name="column-size"].yee_element_param_value').val();
									$('#widgetModal .yee-modal-content input[name="column-size"][value="'+parent_column_size+'"]').parent().addClass("btn-success");
								}
								
								$("#widgetModal").yeeModal({
									yeeBackdrop: 'static', //prevent click outside of modal and close modal
									yeeKeyboard: false
								})
								
								yee.settingTypeCallback();
								yee.updateColumnSizeType();
							}
					});
					
				});
						
				$("#widgetModal").on("shown.bs.yeeModal", function () {
					load_CodeMirror();
					
					/*YEEditor setting footer Scroll bottom Bar*/	
					var yeeFooterBar = $('#widgetModal .yee-modal-footer');
					var	modal_padding_top_height = parseInt($("#widgetModal .yee-modal-dialog").css('margin-top'));
					//ini modal footer bar
					var	yeeFooterBarBottom = $('#widgetModal .yee-modal-content').height()-$('#widgetModal .yee-modal-footer').height()+modal_padding_top_height;	
					var scrolls = 0;
					var windows_height = $(window).height();
					
					if ((windows_height+scrolls) < (yeeFooterBarBottom)) {
						if (window.XMLHttpRequest) { 
							yeeFooterBar.css({
								"position": "fixed",
								"top": windows_height+scrolls-modal_padding_top_height-55,
								"left":0,
								"width":"100%",
								"background-color": "#ffffff",
								"z-index": 1051
							}); 
							
						} else {
							yeeFooterBar.removeAttr("style")
						}
					}else {
						yeeFooterBar.removeAttr("style")
					}
					
					$("#widgetModal").scroll(function() {
						var	yeeFooterBarBottom = $('#widgetModal .yee-modal-content').height()-$('#widgetModal .yee-modal-footer').height()+modal_padding_top_height;	
						var scrolls = $(this).scrollTop();
						var windows_height = $(window).height();
						
						if ((windows_height+scrolls) < (yeeFooterBarBottom)) {
							if (window.XMLHttpRequest) { 
								yeeFooterBar.css({
									"position": "fixed",
									"top": windows_height+scrolls-modal_padding_top_height-55,
									"left":0,
									"width":"100%",
									"background-color": "#ffffff",
									"z-index": 1051
								}); 
								
							} else {
								yeeFooterBar.removeAttr("style")
							}
						}else {
							yeeFooterBar.removeAttr("style")
						}
					});
					/*YEEditor setting footer Scroll bottom Bar end*/
				});
				
				$("#widgetModal").on("hide.bs.yeeModal", function () {
					$("#widgetModal .yee-modal-content").html('');
				});
				
			    $('#widgetModal').on('shown.bs.yeeTab',function(){
					/*YEEditor setting footer Scroll bottom Bar*/	
					var yeeFooterBar = $('#widgetModal .yee-modal-footer');
					yeeFooterBar.removeAttr("style");
					var	modal_padding_top_height = parseInt($("#widgetModal .yee-modal-dialog").css('margin-top'));
					var	yeeFooterBarBottom = $('#widgetModal .yee-modal-content').height()-$('#widgetModal .yee-modal-footer').height()+modal_padding_top_height;	
					var scrolls = $("#widgetModal").scrollTop();;
					var windows_height = $(window).height();

					if ((windows_height+scrolls) < (yeeFooterBarBottom)) {
						if (window.XMLHttpRequest) { 
							yeeFooterBar.css({
								"position": "fixed",
								"top": windows_height+scrolls-modal_padding_top_height-55,
								"left":0,
								"width":"100%",
								"background-color": "#ffffff",
								"z-index": 1051
							}); 
							
						} else {
							yeeFooterBar.removeAttr("style");
						}
					}else {
						yeeFooterBar.removeAttr("style");
					}
					/*YEEditor setting footer Scroll bottom Bar end*/
				});
			},
			cloneWidget: function(){
				$('.yeeditor').delegate('.yee_ele_clone', 'click', function(e){
					e.preventDefault();
					if($(e.target).parents('.wrapper').eq(0).hasClass('yee_sub')){
						var el_key = $(e.target).parents('.wrapper').eq(0).find('.yee_element_base').val(),
							funName = el_key + "_clone_callback";
						window.yee_global_clone_item = $(e.target);
						
						window[funName]();
						
					}else{
						yee.replaceHolder.html($(e.target).parents('.wrapper').eq(0).clone());
						
						if($("#yee_html_holder .widget_extend_class")){
							if(!yee.global_wgt_num){
								yee.global_wgt_num = $('#widget_num').val();
							}
							yee.global_wgt_num ++;
			
							$("#yee_html_holder .widget_extend_class").each(function(i, value){
								$(value).val($(value).val() + '-c' + yee.global_wgt_num);
							});
							var sc = yee.transSc(yee.replaceHolder),
								el_key =yee.replaceHolder.find('.yee_element_base').eq(0).val();
								
							var url = yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element&format=raw";
							if(el_key == "yee_row_inner" || el_key == "yee_row"){
								url = yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_column_partition&format=raw";
							}
							
							$.ajax({
									type: "POST",
									url: url, 
									dataType : "html",
									data: {
										action            : "yee_get_element_backend_html",
										element_key       : el_key,
										element_shortcode : sc
									},
									success: function (data) {
										
										yee.replaceHolder.html(data);
										yee.replaceHolder.children().insertAfter($(e.target).parents('.wrapper').eq(0));
										yee.do_sortable();
										yee.transSc();
									}
							});
						}else{
							yee.replaceHolder.children().insertAfter($(e.target).parents('.wrapper').eq(0));
							yee.do_sortable();
							yee.transSc();
						}	
					}
				});
			},
			deleteWidget: function(){
				$('.yeeditor').delegate('.yee_ele_delete', 'click', function(e){
					e.preventDefault();
					yee_global_box = $(e.target).parents('.wrapper').eq(0);
					var el_key = yee_global_box.find(".yee_element_base").val();
					
					$('#deleteModal').yeeModal();		
				});
				$('.delete_yes').click(function(e){
					e.preventDefault();
					var el_key = yee_global_box.find(".yee_element_base").val();
					if(element_extend_arr[el_key]){
						if(function_is_Exist(el_key+"_delete_callback")){
							eval(el_key+"_delete_callback()");
						}
					}
					else{
						yee_delete(yee_global_box);
					}
					$('#deleteModal').yeeModal('hide');
				}); 
				
				$('.delete_no').click(function(e){
					e.preventDefault();
					$('#deleteModal').yeeModal('hide');
				});
				function yee_delete(box){
					box.remove();
					if(!box.parent().children().length){
						box.parent().next().remove();
					}
					yee.transSc();
				}
			},
			changeColumn: function(){
				$('.yeeditor').delegate('.yee_columnTypes li a','click', function(e){
					e.preventDefault();
				
					$(e.target).parents('.yee-btn-group').eq(0).find(".column_group").val($(this).attr('title'));

					var new_column_value = $(this).attr('title').trim(),
						types = new_column_value.split('+');
					
					for(var i = 0; i < types.length; i++){
						types[i] = types[i].trim();
						if(!percent_arr[types[i]]){
							return false;
						}
					}
					
					var container = $(e.target).parents('.wrapper').eq(0);
					var	columnSc = yee.transColumnSc(container, types);
					$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_column_partition&format=raw",
							dataType : "html",
							data: {
								element_key : columnSc.type,
								element_shortcode : columnSc.sc
							},
							success: function (data) {
								yee.replaceHolder.html(data);
								$(e.target).parents('.wrapper').eq(0).html(yee.replaceHolder.find('.wrapper').html());
								yee.do_sortable();
								yee.replaceHolder.html('');
								yee.transSc();
							}
					});
				});
				
				//custom columns
				$('.yeeditor').delegate(".custom_column","click",function(e){	
					e.preventDefault(); 
					yee.custom_colum_e=e;
					$("#customColumnModal #custom_column_value").val($(this).parents(".yee-btn-group").find(".column_group").val());												 
					$("#customColumnModal").yeeModal('show');											 
				})
				
				$('.yeeditor').delegate(".save_custom_column_value","click",function(e){	
					e.preventDefault();
					var new_column_value=$("#customColumnModal #custom_column_value").val();
					e=yee.custom_colum_e;
					new_column_value=new_column_value.trim();
					var types = new_column_value.split('+');
					var column_count=0;
					var column_counts=new Array();
			
					for(var i = 0; i < types.length; i++){
						types[i]=types[i].trim();
			
						column_counts=types[i].split('/');
						column_count = parseInt(column_count) + parseInt(12*parseInt(column_counts[0])/parseInt(column_counts[1]));
					}
			
					if(parseInt(column_count) != 12){
						$("#messageModal .yee-modal-body").html(jsMessage.YEEDITOR_WRAPPER_CUSTOM_COLUMN_WANRING);
						$("#messageModal").yeeModal('show');
						return false;	
					}
					
					var container = $(e.target).parents('.wrapper').eq(0);
					var	columnSc = yee.transColumnSc(container, types);
					$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_column_partition&format=raw",
							dataType : "html",
							data: {
								element_key : columnSc.type,
								element_shortcode : columnSc.sc
							},
							success: function (data) {
								yee.replaceHolder.html(data);
								$(e.target).parents('.wrapper').eq(0).html(yee.replaceHolder.find('.wrapper').html());
								yee.do_sortable();
								yee.replaceHolder.html('');
								yee.transSc();
								$("#customColumnModal").yeeModal('hide');	
							}
					});
				})
			},
			do_sortable: function(){
				$( ".yee_group_3,.yee_group_5,.yee_group_6" ).sortable({
					connectWith: ".yee_group_3,.yee_group_5,.yee_group_6",
					tolerance: "pointer",
			    	opacity: 0.5,
			    	cursor: "move",
			    	//cursorAt: { left: 30, top:20 },
					over:function (event, ui) {
						ui.placeholder.removeClass('hide');
						if($(event.target).parent().find("> div.yee_group_5").length){
							if(ui.item.attr("class").indexOf("yee_not_inner_widget") != -1 || ui.item.attr("class").indexOf("yee_inner_row") != -1){
								ui.placeholder.addClass('hide');	
							}
						}
						if($(event.target).parent().find("> div.yee_group_6").length){
							if(ui.item.attr("class").indexOf("yee_not_inner_widget") != -1){
								ui.placeholder.addClass('hide');	
							}
						}
					},
					receive: function(event, ui) {
						if($(event.target).parent().find("> div.yee_group_5").length){
							if(ui.item.attr("class").indexOf("yee_not_inner_widget") != -1 || ui.item.attr("class").indexOf("yee_inner_row") != -1){
								ui.sender.sortable('cancel');
							}
						}
						if($(event.target).parent().find("> div.yee_group_6").length){
							if(ui.item.attr("class").indexOf("yee_not_inner_widget") != -1){
								ui.sender.sortable('cancel');
							}
						}
					},
			    	stop: function(event, ui){
			    		yee.transSc();
			    	},
			    	start: function(){
			    		sortOver();
			    	}

			    	
				});
				
				
				$( ".yee_group_1,.yee_group_2 > .yee-row,.yee_group_4 > .yee-row" ).sortable({ 
					items: "> div:not(.yee_intro_text)",
			    	tolerance: "pointer",
			    	opacity: 0.5,
			    	cursor: "move",
			    	//cursorAt: { left: 30, top:20 },
			    	stop: function(){
			    		yee.transSc();
			    	},
			    	over: function(){
			    		sortOver(true);
			    	},
			    	start: function(){
			    		sortOver(true);
			    	}
			    });

			    function sortOver(height){
			    	var $holder = $('.ui-sortable-placeholder');
					if(height){
						height = $('.ui-sortable-helper').height();
					}
					else{
						height = 60;	
					}
					
			    	$holder.css({
			    		height: height,
			    		visibility: 'visible',
			    		marginBottom: '7px'
			    	});
					$holder.removeClass('row').addClass('ui-state-highlight');
			    }
			},
			transSc: function(container,NoHandleImageUrl){
				var sc_data,
					str = '';

				if(container){
					sc_data = container.find('.yee_element_base');
				}else{
					sc_data = $('.yee_group_1 .yee_element_base');
				}
			
				$.each(sc_data, function(i, obj){
					var _value = $(obj).val();
					var strr = '',
						strr2 = '';
					if(_value.indexOf('_end') > 0){
						strr = '[/' + _value.split('_end')[0] + ']';
					}else{
						var params = $(obj).nextAll('.yee_element_param_value');
						if(!params.length){
							params = $(obj).parent().find('.yee_element_param_value');
						}
						
						strr = '[' + _value;
			
						for(var i = 0; i < params.length; i ++){
							if($(params[i]).hasClass('main_content')){
								var handledContent;
								if(NoHandleImageUrl){
									handledContent = $(params[i]).html();
								}
								else{
									var tempContent = $(params[i]).html();
									handledContent = tempContent.replaceAll(yee_frontend + "images/","images/");
								}
								strr2 = strr2 + '{'+$(params[i]).attr('yee-name')+'}'+ handledContent + '{/'+$(params[i]).attr('yee-name')+'}'; 
							}else{
								strr += ' ' + $(params[i]).attr('yee-name') + '="' + $(params[i]).val() + '"';					
							}
						} 
						strr += ']' + strr2;
					}
					str += strr;
				});
							
				if(!container){
					if(set_intro_text=="active"){
						//intro text
						var intro_text = $("#yee_intro_text").val();
						if(intro_text){
							str = intro_text + '<hr id="system-readmore" />' + str;
						}
					}
					$('#' + yee_sc_area_id).val(str);
				}
				
				//yee.scHolder.val(str);
				
				return str;
			},
			transColumnSc: function(container, types){ 
				var columns = container.find('.yee_element_base'),
					columns_arr = [],
					returnobj = {};
					returnobj.type = container.find('.yee_element_base').eq(0).val();
				var column_type =  returnobj.type=='yee_row_inner' ? 'yee_column_inner' :'yee_column';
	
				for(var i = 0; i < columns.length; i++){ 
					if((returnobj.type =='yee_row' && $(columns[i]).val() == 'yee_column') || (returnobj.type =='yee_row_inner' && $(columns[i]).val() == 'yee_column_inner')){
						var obj = {};
						var column_params = {}; 
						$(columns[i]).nextAll('.yee_element_param_value').each(function(i, obj){	
							column_params[$(obj).attr('yee-name')] = $(obj).val();
						})
						
						obj.params = column_params;
						obj.sc = yee.transSc($(columns[i]).parent().find('.ui-sortable').eq(0));
						columns_arr.push(obj);
					}
				}
				
				//columns_arr.length = 4;
				var str = ''; 
				for(var i = 0; i < types.length; i++){
					var params_arr = {};
					str +='[' + column_type;
					if(i <= columns_arr.length - 1){		
						params_arr = columns_arr[i].params;
						$.each(params_arr,function(key, val){	 
							if(key == 'width'){
								val = types[i];
							}
							str += ' ' + key + '="' + val + '"';
						})
					}
					else{
						params_arr = yee.getDefaultParams(elements_arr_ex[column_type]["params"]); 
						$.each(params_arr,function(key, obj){
							var val = obj.value;
							if(obj.param_name == 'width'){
								val = types[i];
							}
							str += ' ' + obj.param_name + '="' + val + '"';
						})
					}
					

					str += ']';
					if(i == types.length - 1){
							for(var x = i; x < columns_arr.length; x ++ ){
								str += columns_arr[x].sc;
							}
					}else{
						if(columns_arr[i]){
							str += columns_arr[i].sc;
						}
					}
					
					str += '[/' + (returnobj.type == 'yee_row_inner' ? 'yee_column_inner' :'yee_column') + ']';
				}
				
				if(returnobj.type == "yee_row" || returnobj.type == "yee_row_inner"){
					var _str = '['+ returnobj.type;
					container.find('.yee_element_base').eq(0).nextAll('.yee_element_param_value').each(function(i, obj){
						_str += ' ' + $(obj).attr('yee-name') + '="' + $(obj).val() + '"';
					});
					str = _str + ']' + str + '[/' + returnobj.type + ']';					
				}
				
				returnobj.sc = str;
				return returnobj;
			},
			get_new_item_content: function(element_extend_key, params){
				var element_extend_shortcode="";
				var return_html="";
				element_extend_shortcode= element_extend_shortcode+"["+element_extend_key;	
				$.each(params,function(key,val){														 
					element_extend_shortcode = element_extend_shortcode+" "+val.param_name+'="'+val.value+'"';
				});
				element_extend_shortcode=element_extend_shortcode+"][/"+element_extend_key+"]";	
				
				$.ajax({
						type: "POST",
						url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_inner&format=raw", 
						dataType : "html",
						async:false,
						data: {
							   element_key       : element_extend_key,
							   element_shortcode : element_extend_shortcode
						},
						success: function (data) {
							var data_obj=JSON.decode(data);
							return_html=data_obj.html;
						}
				});	
				return return_html;	
			},
			editAreaSetting: function(){
				$('.width-60').eq(0).append('<div class="btnOptionPanel"></div>');
				if($('.width-60').length > 1){
					$('.width-40').addClass('yeModule fltlft');
					$('.width-60').eq(1).insertAfter($('.width-60').eq(0)).addClass('width-40 fltrt').removeClass('width-60 fltlft');
					$('.yeModule').addClass('width-60').removeClass('width-40 fltrt');
				}
				$('.btnOptionPanel').click(function(){
					if($(this).hasClass('show')){
						$(this).removeClass('show');
						$('.width-40').show();
						$('.width-60').removeClass('width-100');
					}else{
						$(this).addClass('show');
						$('.width-40').hide();
						$('.width-60').addClass('width-100');
					}
					
				});
			},
			templatesOperation: function(){
				//save template
				$('#yeeditor').delegate("#save_template","click",function(e){
					$("#templateNameModal").yeeModal({
						backdrop: 'static',
						keyboard: false
					});
				});
				$('#templateNameModal').delegate(".submit_template_name","click",function(e){
					var name=$("#templateNameModal #template_name").val();								  
					if(name){									  
						$.ajax({
								type: "POST",
								url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=template_action&format=raw", 
								dataType : "html",
								data: {
									   action  : "save_template",
									   name    : name,
									   content : yee.scHolder.val()
								},
								success: function (data) {
									var dataobj=JSON.decode(data);
									var template_list='<li><a id="save_template" href="#"><i class="fa fa-save"></i> '+jsMessage.YEEDITOR_WRAPPER_SAVE_TEMPLATE+'</a></li><li class="divider"></li><li><a href="'+yee_frontend+'administrator/index.php?option=com_yeeditor&view=templates" target="_blank"><i class="fa fa-list-alt"></i>'+jsMessage.YEEDITOR_WRAPPER_MANAGE_TEMPLATE+'</a></li><li class="divider"></li>';
									$.each(dataobj,function(key,val){
										template_list = template_list+'<li><a class="load_template" data-yee-id="'+val.id+'">'+val.name+'</a></li>';
									});
									$(".template_action").html(template_list);
									
									$("#templateNameModal").yeeModal("hide");
								}
						});	
					}
					else{
						alert("Please enter templates name");	
					}
				});
				
				//load template
				$('#yeeditor').delegate(".load_template","click",function(e){				   
					$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=template_action&format=raw",  
							dataType : "html",
							data: {
								   action  : "load_template",
								   id      : $(this).attr("data-yee-id")
							},
							success: function (data) {
								var content = yee.scHolder.val();
								content += data;
								
								if(content.indexOf('widget_padding="') != -1){ 
									if(confirm(jsMessage.YEEDITOR_SHORTCODE_CONVERT)){
										$.ajax({
											type: "POST",
											url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=convert_shortcode&format=raw", 
											dataType : "text",
											async:false,
											data: {
												   content : content
											},
											success: function (data) {
												content = data;
											}
										});
									}
								}
								
								yee.scHolder.val(content);
								$.ajax({
										type: "POST",
										url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_all&format=raw", 
										dataType : "html",
										data: {
											   content : content
										},
										success: function (data) {
											$("#yeeditor .yee_group_1").html(data);
											yee.do_sortable();
										}
								});
							}
					});								 
				});
				
				//delete template
				$('#yeeditor').delegate(".delete_template","click",function(e){	
					$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=template_action&format=raw", 
							dataType : "html",
							data: {
								   action  : "delete_template",
								   name    : $(this).attr("data-yee-name")
							},
							success: function (data) {
								var dataobj=JSON.decode(data);
								var template_list='<li><a id="save_template" href="#"><i class="fa fa-save"></i> Save Template</a></li><li class="divider"></li>';
								$.each(dataobj,function(key,val){
									template_list = template_list+'<li class="remove"><a class="load_template" data-yee-name="'+val+'">'+val+'</a><a class="pull-right-icon delete_template" data-yee-name="'+val+'"><i class="fa fa-times"></i></a></li>';
								});
								$(".template_action").html(template_list);
								
								$("#templateNameModal").yeeModal("hide");
							}
					});														  
				});														  
			},
			previewButton: function(){
				if($("#jform_id").val()!=0 && getUrlParam("option")=="com_content" && getUrlParam("view")=="article"){
					$("#toolbar").prepend("<div id='toolbar-preview' class='btn-group'><a class='btn btn-small' href='"+yee_frontend+"index.php?option=com_content&view=article&id="+$("#jform_id").val()+"&yeepreview=1' target='yee-preview'><i class='icon-picture'></i>Preview</a></div>");
					
					if($("#toolbar-popup-preview"))
						$("#toolbar-popup-preview").attr("style","display:none;");
				}
				
				function getUrlParam(name){
					var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
					
					var r = window.location.search.substr(1).match(reg);
					
					if (r!=null) return unescape(r[2]); return null;
				}
				$("#toolbar-preview").click(function(e){
					e.preventDefault();
					var action = $('form#item-form').attr('action');
					$('form#item-form').attr('action',$(this).find("a").attr("href"));
					$('form#item-form').attr('target', 'yee-preview').submit().attr('target', '');
					$('form#item-form').attr('action',action);
					return false;
				});
				
				//for preview in frontend and edit article
				var Request = new QueryString();
				var base64 =new Base64();
				if(Request["return"]){
					var return_str=base64.decode(Request["return"]);
					if(return_str.indexOf("&yeepreview=1")>=0){
						$("#adminForm .btn-toolbar .btn-group button").eq(0).removeAttr("onclick");
						$("#adminForm .btn-toolbar .btn-group button").eq(0).click(function(){
							var re=new RegExp("&yeepreview=1","i");
							var new_return_str=base64.encode(return_str.replace(re,""));
							$("#adminForm").find('input[name="return"]').val(new_return_str);
							Joomla.submitbutton('article.save')	;									  
						});
					}
				}
				
			},
			scrollTopBar: function(){
				/*YEEditor header Scroll Top Bar*/		
				var yeeTopBar = $('.yee_outter_header'),
					yeeTopBarTop = yeeTopBar.offset().top;
				
				$('#save_button').hide();
				
				$(window).scroll(function() {
					var scrolls = $(this).scrollTop();
		
					if (scrolls > yeeTopBarTop) {
						if (window.XMLHttpRequest) {
							var _top;
							switch(window.yee_location){
								case 'isFront':
									_top = 0;
									break;
								case 'isAdmin':
									_top = 72;
									break;
							}
							yeeTopBar.css({
								"position": "fixed",
								"top": _top,
								"left":0,
								"width":"100%",
								"padding":0,
								"z-index": 1001
							});  
							
						} else {
							yeeTopBar.css({
								top: scrolls
							});    
						}
						$('#save_button').show();
					}else {
						yeeTopBar.css({
							position: "relative",
							top: 0,
							width:"auto"
						}); 
						$('#save_button').hide();
					}
				});
				/*YEEditor header Scroll Top Bar end*/
				
				
					
				$('#save_button').click(function(e){
					e.preventDefault();
					if(yee_location == 'isAdmin'){
						Joomla.submitbutton('article.apply');
					}
					else if(yee_location == 'isFront'){ 
						Joomla.submitbutton('article.save')
					}
				});
			},
			checkIsExtend: function(base){
				var isExtend = false;
				if(yee_widget_parent_extend[base]){
					isExtend = true;
				}
				$.each(yee_widget_parent_extend,function(i, o){
					if(base == o){
						isExtend = true;
					}
				});
				return isExtend;
			},
			bindEvent: function(){
				yee.addNewRow();
				yee.saveSetting();
				yee.addNewWidget();
				yee.editWidget();
				yee.cloneWidget();
				yee.deleteWidget();
				yee.changeColumn();
				yee.settingAction();
				yee.editAreaSetting();
				yee.templatesOperation();
				yee.previewButton();
				yee.scrollTopBar();
			},
			init: function(){
				//init yeeditor
				if(yeeditor_status==1){
					yee.scHolder.addClass("hide");
					$("#yeeditor").removeClass("hide");
					
					$("#yeeditorToogleButton").text(jsMessage.YEEDITOR_WRAPPER_SOURCE_EDITOR);
				
					var content=$("#"+yee_sc_area_id).val();
					if(content.indexOf('widget_padding="') != -1){ 
						if(confirm(jsMessage.YEEDITOR_SHORTCODE_CONVERT)){
							$.ajax({
								type: "POST",
								url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=convert_shortcode&format=raw", 
								dataType : "text",
								async:false,
								data: {
									   content : content
								},
								success: function (data) {
									content = data;
									$("#"+yee_sc_area_id).val(data);
								}
							});
						}
					}
					
					$("#yeeditor .yee_group_1").html("");
					$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_all&format=raw", 
							dataType : "html",
							data: {
								   set_intro_text : set_intro_text,
								   content : content
							},
							success: function (data) {
								$("#yeeditor .yee_group_1").html(data);
								$(".yeeditor-backdrop").addClass("hide");
								yee.do_sortable();
							}
					});
				}
				else{
					yee.scHolder.removeClass("hide");
					$("#yeeditor").addClass("hide");
					
					$("#yeeditorToogleButton").text(jsMessage.YEEDITOR_WRAPPER_YEEDITOR);
				}
				
				//yee intro text change
				$('.yeeditor').delegate('#yee_intro_text','change', function(e){
					yee.transSc();								   
				})
				
				$("#yeeditorToogleButton").click(function(e){
					e.preventDefault();
					yeeditor_status = yeeditor_status==1?0:1;	
					
					$.ajax({
						type: "POST",
						url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=save_option&format=raw", 
						dataType : "html",
						data: {
							   action  : "yeeditor_status",
							   value   : yeeditor_status
						},
						success: function (data) {
							//editor toogle
							if(!$("#"+yee_sc_area_id).hasClass("hide")){
								$("#"+yee_sc_area_id).addClass("hide");
								$("#yeeditor").removeClass("hide");
								
								$("#yeeditorToogleButton").text(jsMessage.YEEDITOR_WRAPPER_SOURCE_EDITOR);
								
								var content=$("#"+yee_sc_area_id).val();
								if(content.indexOf('widget_padding="') != -1){ 
									if(confirm(jsMessage.YEEDITOR_SHORTCODE_CONVERT)){
										$.ajax({
											type: "POST",
											url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=convert_shortcode&format=raw", 
											dataType : "text",
											async:false,
											data: {
												   content : content
											},
											success: function (data) {
												content = data;
												$("#"+yee_sc_area_id).val(data);
											}
										});
									}
								}
								
								$("#yeeditor .yee_group_1").html("");
								$.ajax({
										type: "POST",
										url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_all&format=raw", 
										dataType : "html",
										data: {
											   set_intro_text : set_intro_text,
											   content : content
										},
										success: function (data) {
											$("#yeeditor .yee_group_1").html(data);
											$(".yeeditor-backdrop").addClass("hide");
											yee.do_sortable();
										}
								});
							}
							else{
								$("#"+yee_sc_area_id).removeClass("hide");
								$("#yeeditor").addClass("hide");
								$(".yeeditor-backdrop").removeClass("hide");
								$("#yeeditorToogleButton").text(jsMessage.YEEDITOR_WRAPPER_YEEDITOR);
							}	
						}
					});
					
				});
				
				yee.bindEvent();
				
			},
			settingTypeCallback: function(){
				$('[data-yee-type="color-picker"]').colorpicker();
				$('.toggle-help-block').click(function(e){
					e.preventDefault();
					$(this).parents('.form-group').eq(0).children('.yee-help-block').toggleClass('hide');
				})
			}
		}
		
		if($("#jform_module").val()!="mod_custom"){
			yee.init();
		}
		else{
			$("#yeeditorToogleButton").remove();	
			yee.scHolder.removeClass("hide");
			$("#yeeditor").addClass("hide");
		}
		
		//functions
		function_is_Exist = function (fnName) {  
			//return fnName in this && eval(fnName) instanceof Function;  
			return fnName in this && typeof (eval(fnName)) == "function";  
		}
		
		load_CodeMirror = function(){
			var $target = $("#widgetModal .yee-CodeMirror"),
				 mode = $target.attr("code-mirror-type");
			
			if($target.length > 0){ 
				editor_code_mirror_global = CodeMirror.fromTextArea($target.get(0), {
					lineNumbers: true,
					mode: mode,
					matchBrackets: true
				});
			}
		}
		
		String.prototype.replaceAll = function(reallyDo, replaceWith, ignoreCase) { 
			if (!RegExp.prototype.isPrototypeOf(reallyDo)) { 
				return this.replace(new RegExp(reallyDo, (ignoreCase ? "gi": "g")), replaceWith); 
			} else { 
				return this.replace(reallyDo, replaceWith); 
			} 
		}
		
		function QueryString(){
			var name,value,i;
			var str=location.href;
			var num=str.indexOf("?")
			str=str.substr(num+1);
			var arrtmp=str.split("&");
			for(i=0;i < arrtmp.length;i++){
				num=arrtmp[i].indexOf("=");
				if(num>0){
					name=arrtmp[i].substring(0,num);
					value=arrtmp[i].substr(num+1);
					this[name]=value;
				}
			}
		}
	});
}(window.jQuery);

