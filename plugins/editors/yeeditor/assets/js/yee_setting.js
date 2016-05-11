(function($){
	$(function() {
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
		
		do_sortable();
		$(".icon-question-sign").parent("a").popover({
			placement : "left",
			title: "ss",
			content:"ssssssssss",
			trigger: "click" //click | hover | focus | manual
		});
		var yee_set = {
			pluginModalIsRow : true,
			scHolder : $("#yeeditor .yee_group_1")
		};
		var yee_global_wgt_num = $('[name = "widget_totle"]').val();

		$('#yee').delegate(".element_item","click",function(e){
			e.preventDefault();
		    var element_key=$(this).attr("data-key");
			var textarea_content="";
			var element_shortcode="["+element_key;

			$.each(elements_arr[element_key]["params"],function(key,val){
			    if(val.type!="textarea" && val.type!="content-editor" && val.type!="code_mirror"){
				   element_shortcode = element_shortcode+" "+val.param_name+"=\""+val.value+"\"";
				}else{
				   textarea_content = val.value;
				}
			});
			
			var element_extend_shortcode="";
			
			if(yee_widget_parent_extend[element_key]){
				var element_extend_key=yee_widget_parent_extend[element_key];
				element_count++;
				for(var i=1;i<=2;i++){	 //default to show two items
					element_extend_shortcode= element_extend_shortcode+"["+element_extend_key;	
					$.each(element_extend_arr[element_extend_key]["params"],function(key,val){		
						if(val.param_number == 'unique'){
							element_extend_shortcode = element_extend_shortcode + " " + val.param_name + "=\"" + val.value + "-" + element_count + "-" + i+ "\"";
						}else{
							element_extend_shortcode = element_extend_shortcode + " " + val.param_name + "=\"" + val.value + "\"";
						}							                   
						
					});
					element_extend_shortcode=element_extend_shortcode+"][/"+element_extend_key+"]";
				}
			
				element_shortcode = element_shortcode+"]" + textarea_content + element_extend_shortcode + "[/"+element_key+"]";
			}else{
				element_shortcode = element_shortcode+"]"+textarea_content+"[/"+element_key+"]";
			}
			
		    $.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_setting&format=raw", 
					dataType : "html",
					data: {
						   element_key : element_key,
						   element_shortcode : element_shortcode
					},
					success: function (data) {
					    $("#myModal").modal("hide");
						$("#widgetModal").html(data).modal();
											
						load_CodeMirror();
											
						var obj = {};
						if(yee_set.pluginModalIsRow){
							obj = {
								action            : "yee_get_row_element_backend_html",
						       element_key       : element_key,
							   element_shortcode : element_shortcode
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
									$("#yee_html_holder").html(data);
									var base = $("#yee_html_holder").find('.yee_element_base').eq(0);
									yee_global_params = base.nextAll('.yee_element_param_value');
									if(!yee_global_params.length){
										yee_global_params = $("#yee_html_holder").find('.yee_element_param_value');
									}
									var holder_child = $("#yee_html_holder").children();
									if(yee_set.pos =='first'){
										yee_set.scHolder.prepend(holder_child);
									}else{
										yee_set.scHolder.append(holder_child);
									}
									if(element_key !='yee_row' && element_key !='yee_row_inner'){// && !yee_widget_parent_extend[element_key]
										yee_global_isWgt = true;
										if(yee_set.pluginModalIsRow){
											window.yee_global_wgtContainer = holder_child.find('.yee_widget');
										}else{
											window.yee_global_wgtContainer = holder_child;
										}
										if(yee_widget_parent_extend[element_key]){ // == 'yee_tabs'){
											yee_global_isWgt = false;
											yee_global_params = window.yee_global_wgtContainer.find('.yee_element_base').eq(0).nextAll('.yee_element_param_value');
										}else{
											yee_global_params = window.yee_global_wgtContainer.find('.yee_element_param_value');
										}
										
									}else{
										yee_global_isWgt = false;
										window.yee_global_wgtContainer = base.parent();
									}
									
									if(!yee_set.scHolder.next().is('p')){
										if(yee_set.scHolder.hasClass('yee_group_1')){
											$('<p class="text-center"><button type="button" class="btn btn-mini yee_float_assign yee_add_row_ele_btn yee_add_level_one last"><i class="icon-plus"></i> Widget</button></p>').insertAfter(yee_set.scHolder);
										}else if(yee_set.scHolder.hasClass('yee_group_5')){
											$('<p class="text-center"><button type="button" class="btn btn-mini yee_float_assign yee_add_ele_btn last"><i class="icon-plus"></i> Widget</button></p>').insertAfter(yee_set.scHolder);
										}else if(yee_set.scHolder.hasClass('yee_group_6')){
											$('<p class="text-center"><button type="button" class="btn btn-mini yee_float_assign yee_add_ele_inner_btn last"><i class="icon-plus"></i> Widget</button></p>').insertAfter(yee_set.scHolder);
										}else{
											$('<p class="text-center"><button type="button" class="btn btn-mini yee_float_assign yee_add_row_ele_btn last"><i class="icon-plus"></i> Widget</button></p>').insertAfter(yee_set.scHolder);
										}
									}			
									transSc();
									do_sortable();
								}
						});
					}
			});		
		});
		
		$("#yee_add_row").click(function(e){
			e.preventDefault();
			//var yee_sc_row = '[yee_row ex_class=""] [yee_column  width="1/1" ex_class=""][/yee_column][/yee_row]';	
			//$("#"+ yee_sc_area_id).val($("#"+ yee_sc_area_id).val() + yee_sc_row);	
			yee_set.scHolder = $("#yeeditor .yee_group_1");
			var element_key = 'yee_row';
			var textarea_content="";
			var element_shortcode="["+element_key;
			$.each(elements_arr[element_key]["params"],function(key,val){
			    if(val.type!="textarea" && val.type!="content-editor" && val.type!="code_mirror"){
				   element_shortcode = element_shortcode+" "+val.param_name+"=\""+val.value+"\"";
				}
				else{
				   textarea_content = val.value;
				}
			});
			element_shortcode = element_shortcode+"]"+textarea_content+"[/"+element_key+"]";
			$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_setting&format=raw", 
					dataType : "html",
					data: {
						   element_key : element_key,
						   element_shortcode : element_shortcode
					},
					success: function (data) {
					    $("#myModal").modal("hide");
					    
						$("#widgetModal").html(data).modal();
						//$("#yeeditor .yee_group_1").html(data);

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
									$("#yee_html_holder").html(data);
									var base = $("#yee_html_holder").find('.yee_element_base').eq(0);
									window.yee_global_wgtContainer = base.parent();
									yee_global_params = $("#yee_html_holder").find('.yee_element_base').eq(0).nextAll('.yee_element_param_value');
									if(!yee_global_params.length){
										yee_global_params = $("#yee_html_holder").find('.yee_element_param_value');
									}
									yee_set.scHolder.append($("#yee_html_holder").children());
									yee_global_isWgt = false;
									transSc();
									do_sortable();
								}
						});
						
					}
			});		
		});
		
		$('#yee_add_element').click(function(e){
			e.preventDefault();
			yee_set.pluginModalIsRow = true;
			if($(e.target).hasClass('first')){
				yee_set.pos = 'first';
			}
			if($(e.target).hasClass('last')){
				yee_set.pos = 'last';
			}
			$('#myModal .modal-body').html(row_inner_insert_plugin);
			$('#myModal').modal();
			yee_set.scHolder = $("#yeeditor .yee_group_1");
		});
		$('#yee').delegate('.yee_add_row_ele_btn','click',function(e){
			e.preventDefault();
			yee_set.pluginModalIsRow = false;
			var insert_plugin_html=row_insert_plugin;
			if($(e.target).hasClass('yee_add_level_one')){
				yee_set.pluginModalIsRow = true;
				insert_plugin_html=row_inner_insert_plugin;
			}
			if($(e.target).hasClass('first')){
				yee_set.pos = 'first';
			}
			if($(e.target).hasClass('last')){
				yee_set.pos = 'last';
			}
			$('#myModal .modal-body').html(insert_plugin_html);
			$('#myModal').modal();
			if($(e.target).is('button')){
				if(yee_set.pos =='first'){
					yee_set.scHolder = $(e.target).parent().next();
				}else{
					yee_set.scHolder = $(e.target).parent().prev();
				}
				
			}
			if($(e.target).is('i')){
				yee_set.scHolder = $(e.target).parents('.yee_header').eq(0).next().next();
			}
		});
		$('#yee').delegate('.yee_add_ele_btn','click', function(e){
			e.preventDefault();
			yee_set.pluginModalIsRow = false;
			$('#myModal .modal-body').html(element_insert_plugin);
			$('#myModal').modal();
			if($(e.target).is('button')){
				if($(e.target).hasClass('first')){
					yee_set.pos = 'first';
					yee_set.scHolder = $(e.target).parent().next();
				}else{
					yee_set.pos = 'last';
					yee_set.scHolder = $(e.target).parent().prev();
				}
				
			}
			if($(e.target).is('i')){
				if($(e.target).parent().hasClass('first')){
					yee_set.pos = 'first';
					yee_set.scHolder = $(e.target).parent().parent().next();
				}else{
					yee_set.pos = 'last';
					yee_set.scHolder = $(e.target).parent().parent().prev();
				}
				
			}
		});
		$('#yee').delegate('.yee_add_ele_inner_btn','click', function(e){
			e.preventDefault();
			yee_set.pluginModalIsRow = false;
			$('#myModal .modal-body').html(element_inner_insert_plugin);
			$('#myModal').modal();
			if($(e.target).is('button')){
				if($(e.target).hasClass('first')){
					yee_set.pos = 'first';
					yee_set.scHolder = $(e.target).parent().next();
				}else{
					yee_set.pos = 'last';
					yee_set.scHolder = $(e.target).parent().prev();
				}
				
			}
			if($(e.target).is('i')){
				if($(e.target).parent().hasClass('first')){
					yee_set.pos = 'first';
					yee_set.scHolder = $(e.target).parent().parent().next();
				}else{
					yee_set.pos = 'last';
					yee_set.scHolder = $(e.target).parent().parent().prev();
				}
				
			}
		});
		$('#yee').delegate('.yee_ele_delete', 'click', function(e){
			e.preventDefault();
			yee_global_box = $(e.target).parents('.yee_box').eq(0);
			var el_key=yee_global_box.find(".yee_element_base").val();
			
			if(element_extend_arr[el_key]){
				yee_global_box = $(e.target).parents('.data-id').eq(0);
			}
			
			$('#deleteModal').modal();		
		});
		function yee_delete(box){
			
			box.remove();
			if(!box.parent().children().length){
				box.parent().next().remove();
			}
			transSc();
		}
		$('.delete_yes').click(function(e){
			e.preventDefault();
			var el_key=yee_global_box.find(".yee_element_base").val();
			if(element_extend_arr[el_key]){
				var _id=yee_global_box.attr('id')
				
				
				if(function_is_Exist(el_key+"_delete_callback")){
					eval(el_key+"_delete_callback"+"('"+_id+"')");
				}
			}
			else{
				yee_delete(yee_global_box);
			}
			$('#deleteModal').modal('hide');
		});
		
		function function_is_Exist(fnName) {  
			//return fnName in this && eval(fnName) instanceof Function;  
			return fnName in this && typeof (eval(fnName)) == "function";  
		} 
		
		$('.delete_no').click(function(e){
			e.preventDefault();
			$('#deleteModal').modal('hide');
		})
		$('#yee').delegate('.yee_columnTypes','click', function(e){
			e.preventDefault();
			var target;
			if($(e.target).parent().is('a')){
				target = $(e.target).parent();
			}
			if($(e.target).parent().is('li')){
				target = $(e.target);
			}	
			$(e.target).parents('.yee_header').find(".column_group").val(target.attr('title'));
			var new_column_value=$(e.target).parents('.yee_header').find(".column_group").val();
			new_column_value.trim();
			var types = new_column_value.split('+');
			for(var i = 0; i < types.length; i++){
				types[i]=types[i].trim();
				if(!isset(percent_arr[types[i]])){
					return false;
				}
			}
			var container = $(e.target).parents('.yee_header').eq(0).next();
			var columnSc = transColumnSc(container, types);
			$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_column_partition&format=raw", 
					dataType : "html",
					data: {
							element_key : columnSc.type,
						   element_shortcode : columnSc.sc
					},
					success: function (data) {
						
						//$("#yee_html_holder").html(data);
						//$(e.target).parents('.yee_box').eq(0).html($("#yee_html_holder").find('.yee_box').html());
						$(e.target).parents('.yee_box').eq(0).replaceWith(data);
						do_sortable();
						$("#yee_html_holder").html('');
						transSc();
					}
			});
		});
		
		$('#yee').delegate('.yee_ele_clone', 'click', function(e){
			e.preventDefault();
			if($(e.target).parents('.yee_box').eq(0).hasClass('yee_sub')){
				var el_key = $(e.target).parents('.yee_box').eq(0).find('.yee_element_base').val(),
					funName = el_key + "_clone_callback";
				window.yee_global_clone_item = $(e.target);
				
				window[funName]();
				
			}else{
				$("#yee_html_holder").html($(e.target).parents('.yee_box').eq(0).clone());
				if($("#yee_html_holder .widget_extend_class")){
					if(!yee_global_wgt_num){
						yee_global_wgt_num = $('[name = "widget_totle"]').val();
					}
					yee_global_wgt_num ++;

					$("#yee_html_holder .widget_extend_class").each(function(i, value){
						$(value).val($(value).val() + '-c' + yee_global_wgt_num);
					});
					var sc = transSc($("#yee_html_holder")),
						el_key =$("#yee_html_holder").find('.yee_element_base').eq(0).val();
						
					var url=yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element&format=raw";
					if(el_key=="yee_row_inner" || el_key=="yee_row"){
						url=yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_column_partition&format=raw";
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
								
								$("#yee_html_holder").html(data);
								$("#yee_html_holder").children().insertAfter($(e.target).parents('.yee_box').eq(0));
								do_sortable();
								transSc();
							}
					});
				}else{
					$("#yee_html_holder").children().insertAfter($(e.target).parents('.yee_box').eq(0));
					do_sortable();
					transSc();
				}						
			}				
		});
		$('#yee').delegate(".yee_ele_edit", "click", function(e){
			e.preventDefault();
			var wgtContainer = $(e.target).parents('.yee_box').eq(0),
				base = wgtContainer.find('.yee_element_base').eq(0).val(),
				params = wgtContainer.find('.yee_element_param_value'),
				sc_str = '[' + base ,
				sc_str2;
			
			if(base == 'yee_row' || base =='yee_row_inner' || base =='yee_column' || base =='yee_column_inner' ){
				yee_global_isWgt = false;
				params =  wgtContainer.find('.yee_element_base').eq(0).nextAll('.yee_element_param_value');
			}else{
				if(checkIsExtend(base)){
					params =  wgtContainer.find('.yee_element_base').eq(0).nextAll('.yee_element_param_value');
				}
				yee_global_isWgt = true;
			}
			yee_global_params = params;
			window.yee_global_wgtContainer = wgtContainer;
			/*for(var i = 0; i < params.length; i++){
				if ($(params[i]).attr('name') == 'text_content'){
					sc_str2 = $(params[i]).html();
				}else{
					if($(params[i]).val()){
						sc_str += ' ' + $(params[i]).attr('name') + '="' + $(params[i]).val() + '"';
					}
				}
				
			}
			sc_str +=']' + sc_str2 + '[/' + base + ']';*/
			sc_str = transSc(wgtContainer);
			
			$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_setting&format=raw", 
					dataType : "html",
					data: {
						   element_key : base,
						   element_shortcode : sc_str
					},
					success: function (data) {
					    $("#myModal").modal("hide");
						$("#widgetModal").html(data).modal();
											
						load_CodeMirror();
						
						//$("#yeeditor .yee_group_1").html(data);
					}
			});
		});
		$('#yee').delegate('#widgetModal #yee_widget_edit_save', 'click',function(e){
			e.preventDefault();
			
			var el_key = window.yee_global_wgtContainer.find('.yee_element_base').eq(0).val(),
				_url=yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element&format=raw";

			$('#widgetModal').find('.yee_input_group').each(function(i, o){
				var base64 = new Base64(),
					name = $(o).attr('name');
				var obj = {};
				$('#widgetModal').find('.yee_input_group_item[data-h="'+ name +'"]').each(function(i, o){			
					obj[$(o).attr('name')] = $(o).val();			
				});

				$(o).val(base64.encode(JSON.encode(obj)));
			});
			
			for(var i = 0; i < yee_global_params.length; i++){
				
				var name = $(yee_global_params[i]).attr('yee-name');
				if($(yee_global_params[i]).hasClass('ck_editor')){
					$(yee_global_params[i]).html(CKEDITOR.instances['yee_'+ name].getData());
				}else if($(yee_global_params[i]).hasClass('code_mirror')){
					var base64 = new Base64();
					$(yee_global_params[i]).html(base64.encode(editor_code_mirror_global.getValue()));
				}else{			
					if($(yee_global_params[i]).hasClass('textareafield')){
						var base64 = new Base64();
						$(yee_global_params[i]).html(base64.encode($('#widgetModal').find('[name =' + name + ']').val()));
					}else{

						$(yee_global_params[i]).val($('#widgetModal').find('[name =' + name + ']').val());
					}
					
				}
			} 
			if(element_extend_arr[el_key]){
				_url=yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_element_inner&format=raw";
				//$('a[href="#' + yee_global_params.filter('[name="item_id"]').val()+'"]').html(yee_global_params.filter('[name="title"]').val());
			}
			$('#widgetModal').modal('hide');
			
			if(yee_global_isWgt){
				var sc = transSc(window.yee_global_wgtContainer);
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
								var data_obj=JSON.decode(data);
								$("#yee_html_holder").html(data_obj.html);
							
								window.yee_global_wgtContainer.html(data_obj.html);
								if(function_is_Exist(el_key+"_edit_callback")){
									eval(el_key+"_edit_callback"+"("+JSON.encode(data_obj)+")");
								}
							}else{
								$("#yee_html_holder").html(data);
								$("#yee_html_holder").children().insertAfter(window.yee_global_wgtContainer);	
								window.yee_global_wgtContainer.remove();							
							}
										
							transSc();
							do_sortable();
						}
				});
			}else{
				transSc();
			}
			
		});
		CKEDITOR.bootstrapModalFix( $('#widgetModal'), $);
		$('#widgetModal').on('hidden', function(e){
			$(e.target).html('');
		});
		//save template
		$('#yee').delegate("#save_template","click",function(e){
			$("#template_name_dialog").modal();
		});
		$('#yee').delegate("#submit_template_name","click",function(e){
			var name=$("#template_name").val();								  
			if(name){									  
				$.ajax({
						type: "POST",
						url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=template_action&format=raw", 
						dataType : "html",
						data: {
							   action  : "save_template",
							   name    : name,
							   content : $("#"+yee_sc_area_id).val()
						},
						success: function (data) {
							var dataobj=JSON.decode(data);
							var template_list='<li><a id="save_template" ><i class="yee_icon-grid01"></i>Save Template</a></li><li class="divider"></li>';
							$.each(dataobj,function(key,val){
								template_list = template_list+'<li class="remove"><a class="load_template" data-id="'+val.id+'">'+val.name+'</a><a class="pull-right-icon delete_template" data-id="'+val.id+'"><i class="icon-remove"></i></a></li>';
							});
							$(".template_action").html(template_list);
							
							$("#template_name_dialog").modal("hide");
						}
				});	
			}
			else{
				alert("Please enter templates name");	
			}
	    });
		
		//yee intro text change
		$('#yee').delegate('#yee_intro_text','change', function(e){
			transSc();								   
		})
		
		//load template
		$('#yee').delegate(".load_template","click",function(e){				   
			$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=template_action&format=raw", 
					dataType : "html",
					data: {
						   action  : "load_template",
						   id      : $(this).attr("data-id")
					},
					success: function (data) {
						var content=$("#"+yee_sc_area_id).val();
						content += data;
						$("#"+yee_sc_area_id).val(content);
						$.ajax({
							type: "POST",
							url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_all&format=raw", 
							dataType : "html",
							data: {
								   content : content,
								   set_intro_text : set_intro_text
							},
							success: function (data) {
								$("#yeeditor .yee_group_1").html(data);
								do_sortable();
							}
					    });
					}
			});								 
		});
		
		//delete template
		$('#yee').delegate(".delete_template","click",function(e){				   
			$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=template_action&format=raw", 
					dataType : "html",
					data: {
						   action  : "delete_template",
						   id      : $(this).attr("data-id")
					},
					success: function (data) {
						var dataobj=JSON.decode(data);
						var template_list='<li><a id="save_template" ><i class="yee_icon-grid01"></i>Save Template</a></li><li class="divider"></li>';
							$.each(dataobj,function(key,val){
								template_list = template_list+'<li class="remove"><a class="load_template" data-id="'+val.id+'">'+val.name+'</a><a class="pull-right-icon delete_template" data-id="'+val.id+'"><i class="icon-remove"></i></a></li>';
							});
							$(".template_action").html(template_list);
					}
			});								 
		});
		
		if($("#jform_id").val()!=0 && getUrlParam("option")=="com_content" && getUrlParam("view")=="article"){
			$("#toolbar").prepend('<div id="toolbar-preview" class="btn-group"><button class="btn btn-small" href="#"><i class="icon-picture"></i>Preview</button></div>' );
			
			if($("#toolbar-popup-preview"))
				$("#toolbar-popup-preview").attr("style","display:none;");
		}
		
		function getUrlParam(name){
			var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
			
			var r = window.location.search.substr(1).match(reg);
			
			if (r!=null) return unescape(r[2]); return null;
		}

		$("#toolbar-preview").click(function(){
			var content=$("#"+yee_sc_area_id).val();
			$.ajax({
				type: "POST",
				url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=save_option&format=raw", 
				dataType : "html",
				data: {
					   action  : "yeeditor_preview",
					   value : content
				},
				success: function (data) {
					var article_id=$("#jform_id").val();
					window.open("../index.php?option=com_content&view=article&id="+article_id+"&yeepreview=1","yee-preview-3x");
				}
			});
	    });
		
		//init yeeditor
		if($("#jform_module").val()!="mod_custom"){
			if(yeeditor_statu==1){
				document.getElementById(yee_sc_area_id).style.display="none";
				document.getElementById("yeeditor").style.display="block";
				
				$("#yeeditorToogleButton").text("Source editor");
			
				var content=$("#"+yee_sc_area_id).val();
				$("#yeeditor .yee_group_1").html("");
				$.ajax({
						type: "POST",
						url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_all&format=raw",
						dataType : "html",
						data: {
							   content : content,
							   set_intro_text : set_intro_text
						},
						success: function (data) {
							$("#yeeditor .yee_group_1").html(data);
							do_sortable();
						}
				});
			}
			else{
				document.getElementById(yee_sc_area_id).style.display="block";
				document.getElementById("yeeditor").style.display="none";
				
				$("#yeeditorToogleButton").text("YEEditor");
			}
				
			$("#yeeditorToogleButton").click(function(){
				yeeditor_statu = yeeditor_statu==1?0:1;									  
				$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=save_option&format=raw", 
					dataType : "html",
					data: {
						   action  : "yeeditor_statu",
						   value   : yeeditor_statu
					},
					success: function (data) {
						yeeditorToogle();
					}
				});
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
		}
		else{
			$("#yeeditorToogleButton").remove();	
		}
		
		$('#yee').delegate(".custom_column a","click",function(e){	
			e.preventDefault(); 
			custom_colum_e=e;
			$("#myModal_custom_column #myModal_custom_column_value").val($(this).parents(".yee_header").find(".column_group").val());												 
			$("#myModal_custom_column").modal('show');											 
		})
		$('#yee').delegate(".save_custom_column_value","click",function(e){	
			e.preventDefault();
			var new_column_value=$("#myModal_custom_column #myModal_custom_column_value").val();
			e=custom_colum_e;
			new_column_value=new_column_value.trim();
			var types = new_column_value.split('+');
			var column_count=0;
			var column_counts=new Array();

			for(var i = 0; i < types.length; i++){
				types[i]=types[i].trim();
				if(isset(span_arr[types[i]])){
					types[i]=span_arr[types[i]];
				}
				column_counts=types[i].split('/');
				column_count = parseInt(column_count) + parseInt(12*parseInt(column_counts[0])/parseInt(column_counts[1]));
			}
			
			if(parseInt(column_count) != 12){
				alert("Wrong row layout format! Example: 1/2 + 1/2 or span6 + span6.");
				return false;	
			}
			
			$(e.target).parents(".yee_header").find(".column_group").val(new_column_value);
			var target=$(e.target);
			var container = $(e.target).parents('.yee_header').eq(0).next();
			var columnSc = transColumnSc(container,types);
			$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_transverter&layout=transverter_editor_column_partition&format=raw", 
					dataType : "html",
					data: {
							element_key : columnSc.type,
						   element_shortcode : columnSc.sc
					},
					success: function (data) {						
						$(e.target).parents('.yee_box').eq(0).replaceWith(data);
						do_sortable();
						$("#yee_html_holder").html('');
						transSc();
					}
			});
		});
	});
			
	
	function transColumnSc(container,types){
		var columns = container.find('.yee_element_base'),
			columns_arr = [],
			row_class = container.parent().find('.yee_element_base').eq(0).next().val(),
			returnobj = {};
			returnobj.type = container.parent().find('.yee_element_base').eq(0).val().indexOf('inner') > 0 ? 'yee_row_inner' : 'yee_row';
			
		for(var i = 0; i < columns.length; i++){
			if(returnobj.type =='yee_row' && $(columns[i]).val() == 'yee_column'){
				var obj = {};
				obj.ex_class = $(columns[i]).next().val();
				obj.sc = transSc($(columns[i]).parent().find('.ui-sortable').eq(0));
				columns_arr.push(obj);
			}else if(returnobj.type =='yee_row_inner' && $(columns[i]).val() == 'yee_column_inner'){
				var obj = {};
				obj.ex_class = $(columns[i]).next().val();
				obj.sc = transSc($(columns[i]).parent().find('.ui-sortable').eq(0));
				columns_arr.push(obj);
			}
		}
		//columns_arr.length = 4;
		var str = '';
		for(var i = 0; i < types.length; i++){
			str +='[' + (returnobj.type == 'yee_row_inner' ? 'yee_column_inner' :'yee_column') + ' width="' + types[i] + '"';

			if(columns_arr[i]){
				str += ' ex_class="' + columns_arr[i].ex_class + '"';
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
			
			str +='[/' + (returnobj.type == 'yee_row_inner' ? 'yee_column_inner' :'yee_column') + ']';
		}
		
		
		str = '['+ returnobj.type + ' ex_class="'+ row_class + '"]'+ str + '[/' +returnobj.type + ']';
		returnobj.sc = str;
		return returnobj;
	}
	function checkIsExtend(base){
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
	}
	function isset(a) {
	    if ((typeof (a) === 'undefined') || (a === null))
	        return false;
	    else
	        return true;
	};
	function load_CodeMirror(){
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
	CKEDITOR.bootstrapModalFix = function (modal, $) {
	  modal.on('shown', function () {
	    var that = $(this).data('modal');
	    $(document)
	      .off('focusin.modal')
	      .on('focusin.modal', function (e) {
	        // Add this line
	        if( e.target.className && e.target.className.indexOf('cke_') == 0 ) return;

	        // Original
	        if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
	          that.$element.focus()
	        }
	      });
	  });
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
	if(!window.get_new_item_content){
		window.get_new_item_content = function(element_extend_key, params){
			var element_extend_shortcode="";
			var return_html="";
			element_extend_shortcode= element_extend_shortcode+"["+element_extend_key;	
			$.each(params,function(key,val){														 
				element_extend_shortcode = element_extend_shortcode+" "+key+'="'+val+'"';
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
		}
	}
	if(!window.get_new_item_content){
		window.get_new_item_content = function(element_extend_key, params){
			var element_extend_shortcode="";
			var return_html="";
			element_extend_shortcode= element_extend_shortcode+"["+element_extend_key;	
			$.each(params,function(key,val){														 
				element_extend_shortcode = element_extend_shortcode+" "+key+'="'+val+'"';
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
		}
	}
	if(!window.transSc){
		window.transSc = function(container){

			var sc_data = $('#yeeditor .yee_element_base');
			if(container){
				sc_data = container.find('.yee_element_base');
			}
			var str = '';

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
					if($(obj).attr('data-width')){
						strr = '[' + _value +' width="' + $(obj).attr('data-width') + '"';
					}else{
						strr = '[' + _value;
					}

					for(var i = 0; i < params.length; i ++){
						if($(params[i]).hasClass('textareafield')){
							strr2 = $(params[i]).html(); 
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
					//yee intro text
					var intro_text = $("#yee_intro_text").val();
					str = intro_text + '<hr id="system-readmore" />' + str;
				}
				$('#' + yee_sc_area_id).val(str);
			}
			
			return str;	
		}
	}
	if(!window.do_sortable){
		window.do_sortable = function(){
			
			$( ".yee_group_1" ).sortable();
			$( ".yee_group_2" ).sortable();
			$( ".yee_group_3" ).sortable({
				connectWith: ".yee_group_3,.wgt"
			});
			$( ".yee_group_4" ).sortable();
			$( ".yee_group_5" ).sortable({
				connectWith: ".yee_group_3,.yee_group_5,.yee_group_6"
			});
			$( ".yee_group_6" ).sortable({
		            connectWith: ".yee_group_3,.yee_group_5,.yee_group_6"
		        });
			$( ".wgt" ).sortable({
				connectWith: ".wgt",
				over:function (event, ui) {
		            //ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
		            
		            if(ui.item.hasClass('yee_not_inner_widget') && ui.item.parent().hasClass('yee_group_6')) {
		               
		            }

		        },
				stop:function (event, ui) {
		           if(ui.item.hasClass('yee_not_inner_widget') && ui.item.parent().hasClass('yee_group_6')) {
		           	ui.placeholder;
		           	return false;
		           }
		        }
			});
			//$( ".yee_group_1,.yee_group_2,.yee_group_3,.yee_group_4,.yee_group_5" ).disableSelection();
			var tolerance = $( ".yee_group_1,.yee_group_2,.yee_group_3,.yee_group_4,.yee_group_5,.yee_group_6" ).sortable( "option", "tolerance" );
			$( ".yee_group_1,.yee_group_2,.yee_group_3,.yee_group_4,.yee_group_5,.yee_group_6" ).sortable( "option", "tolerance", "pointer" );
			
			$( ".yee_group_1,.yee_group_2,.yee_group_3,.yee_group_4,.yee_group_5,.yee_group_6" ).sortable({ 
				items: "> div:not(.yeeAccordion_intro_text)",
		    	tolerance: "pointer",
		    	opacity: 0.5,
		    	cursor: "move",
		    	cursorAt: { left: 30, top:20 },
		    	stop: function(){
		    		transSc();
		    	}
		    });
			
		}
	}
	
})(window.jQuery);





