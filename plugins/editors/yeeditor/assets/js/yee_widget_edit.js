function GetContents() {
// Get the editor instance that you want to interact with.
var editor = CKEDITOR.instances.editor_content;
// Get editor contents
// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-getData
//console.log(editor.getData() );
} 
$('#yee_widget_edit_save').click(function(e){
	e.preventDefault();
	
	var el_key = yee_global_wgtContainer.find('.yee_element_base').eq(0).val(),
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
		var sc = transSc(yee_global_wgtContainer);
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
					
						yee_global_wgtContainer.html(data_obj.html);
						if(function_is_Exist(el_key+"_edit_callback")){
							eval(el_key+"_edit_callback"+"("+JSON.encode(data_obj)+")");
						}
					}else{
						$("#yee_html_holder").html(data);
						$("#yee_html_holder").children().insertAfter(yee_global_wgtContainer);	
						yee_global_wgtContainer.remove();							
					}
								
					transSc();
					do_sortable();
				}
		});
	}else{
		transSc();
	}
	
});

function function_is_Exist(fnName) {  
	//return fnName in this && eval(fnName) instanceof Function;  
	return fnName in this && typeof (eval(fnName)) == "function";  
} 