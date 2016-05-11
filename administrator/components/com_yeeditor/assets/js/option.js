!function($){
	$(function(){
		$('#option-form').delegate('#jform_combine_widgets_css','click',function(e){
			e.preventDefault();
			$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=combine_css&format=raw", 
					dataType : "text",
					data: {
						action : "combine_css"
					},
					success: function (data) {
						alert(jsMessage.COM_YEEDITOR_FIELD_OPTION_COMBINE_CSS_SUCCESS);
					}
			});
		});
	
	});
}(window.jQuery);
