!function($){
	$(function(){
		//menu control
		$('#yet-theme-menu').on('show.bs.collapse', function(e){
			$(e.target).parent().addClass('active');
			
			$(e.target).children().first().addClass('active').children().click();
		}).on('hide.bs.collapse', function(e){
			$(e.target).parent().removeClass('active');
		});
		$('[href^="#bootstrapVar-category-"]').click(function(e){
			e.preventDefault();
			$(e.target).parent().siblings().removeClass('active');
			$(e.target).parent().addClass('active');
			var targetId = $(e.target).attr('href');
			$('.page-content-wrapper').addClass('hide');
			$(targetId).removeClass('hide');
		});
		$('[href^="#themeVar-category-"]').click(function(e){
			e.preventDefault();
			$(e.target).parent().siblings().removeClass('active');
			$(e.target).parent().addClass('active');
			var targetId = $(e.target).attr('href');
			$('.page-content-wrapper').addClass('hide');
			$(targetId).removeClass('hide');
		});

		//init colorpicker type
		$('[yet-data-type="color-picker"]').colorpicker().on('changeColor',function(ev){
			var $target = $(ev.target).find('input[data-keys]'),
				keyBegin = $target.attr('data-keys').split('-')[0];
			varUpdateData($target, keyBegin, ev.color.toHex());
		});

		//variable change update data arr
		$('[data-keys^="bootstrapVar"]').change(function(e){
			var $target = $(e.target),
				keyBegin = 'bootstrapVar';

			varUpdateData($target, keyBegin);
		});
		$('[data-keys^="themeVar"]').change(function(e){
			var $target = $(e.target),
				keyBegin = 'themeVar';

			varUpdateData($target, keyBegin);
		});

		//variable visible update data arr
		$('[data-toggle="buttons"][data-keys]').click(function(e){
			var $target, keyBegin,
				$trigger = $(e.target);
				
			if($trigger.is('span')){
				$target = $trigger.parent().parent();
				$trigger.toggleClass('fa-eye fa-eye-slash');
			}else if($trigger.is('label')){
				$target = $trigger.parent();
				$trigger.children().toggleClass('fa-eye fa-eye-slash');
			}else{
				return;
			}
			keyBegin = $target.attr('data-keys').split('-')[0];
			varUpdateData($target, keyBegin, false, true);
		});
		
		//save theme less
		$('#yet_save_style').click(function(e){
			e.preventDefault();
			$.ajax({
					type: "POST",
					url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=theme_action&format=raw",
					dataType : "json",
					data: {
						   action : "save",
						   bootstrap_variables_arr: JSON.encode(less_arr),
						   theme_variables_arr: JSON.encode(theme_less_arr)
					},
					success: function (data) {
						Messenger().post({
							message: jsMessage.COM_YEEDITOR_FIELD_THEME_SUCCESS_SAVE,
							id: '4'
						});
					},
					error: function(){
						Messenger().post(jsMessage.COM_YEEDITOR_FIELD_THEME_ERROR_SAVE);
					}
			});
		});
		
		$("#combine_css").click(function(){
			if(!$("#combine_css").hasClass("disabled")){
				$("#combine_css").addClass("disabled");
				$.ajax({
						type: "POST",
						url: yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=theme_action&format=raw",
						dataType : "text",
						data: {
							  action : "combine"
						},
						success: function (data) {
							Messenger().post({
								message: jsMessage.COM_YEEDITOR_FIELD_THEME_SUCCESS_PARSE
							});
							$('#saveThemeModal').yeeModal('hide');
							$("#combine_css").removeClass("disabled");
						},
						error: function(){
							Messenger().post(jsMessage.COM_YEEDITOR_FIELD_THEME_ERROR_PARSE);
							$("#combine_css").removeClass("disabled");
						}
				});
			}
		});
		
		function varUpdateData($target, keyBegin, dataValue, ifVisiable){
			var dataKey = $target.attr('data-keys').split(keyBegin + '-')[1],
				firstLevelNum = dataKey.split('-')[0],
				secondLevelNum = dataKey.split('-')[1],
				value = $target.val();

			if(dataValue){
				value = dataValue;
			}
			switch(keyBegin){
				case 'bootstrapVar':
					var $obj = less_arr[firstLevelNum].variables[secondLevelNum];
					if(ifVisiable){
						$obj.visiable = $obj.visiable == '1' ? '0' : '1';
					}else{
						$obj.value = value;
					}
					
					break;
				case 'themeVar':
					var $obj = theme_less_arr[firstLevelNum].variables[secondLevelNum];
					if(ifVisiable){
						$obj.visiable = $obj.visiable == '1' ? '0' : '1';
					}else{
						$obj.value = value;
					}
					break;
			}
			
		}
		
		window.theme_field_select_image = function(name){
				window.open (yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&yee-type=select_image&yee-name="+name,"newwindow","height=500,width=1100,top=" + (window.screen.availHeight-30-500)/2 +",left=" + (window.screen.availWidth-10-1100)/2 +",toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no") ;
		}
		
		window.trans_image_data = function(file,name){ 
			var filed_name = name;
			var $target = $('input[name="' + filed_name+'"]'),
				keyBegin = 'themeVar';
				
			$target.val("url('../../../../../"+file+"')");

			varUpdateData($target, keyBegin);
		}

	});
}(window.jQuery);
