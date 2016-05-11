<?php 
// No direct access.
defined('_JEXEC') or die;

$root = JURI::root();

$user		= JFactory::getUser(); 
if(!($user->authorise('core.create', 'com_content') || $user->authorise('core.eidt', 'com_content'))){
	JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>elFinder 2.0</title>

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $root;?>plugins/editors/yeeditor/assets/js/ckeditor/elfinder/css/jquery-ui.css">
		<script type="text/javascript" src="<?php echo $root;?>plugins/editors/yeeditor/assets/js/ckeditor/elfinder/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $root;?>plugins/editors/yeeditor/assets/js/ckeditor/elfinder/js/jquery-ui.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $root;?>plugins/editors/yeeditor/assets/js/ckeditor/elfinder/css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $root;?>plugins/editors/yeeditor/assets/js/ckeditor/elfinder/css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="<?php echo $root;?>plugins/editors/yeeditor/assets/js/ckeditor/elfinder/js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="<?php echo $root;?>plugins/editors/yeeditor/assets/js/ckeditor/elfinder/js/i18n/elfinder.ru.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				var elf = $('#elfinder').elfinder({
					url : window.opener.yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&data=1",  // connector URL (REQUIRED)
					// lang: 'ru',             // language (OPTIONAL)
					getFileCallback : function(file) {
						file = file.replace(window.opener.yee_frontend,'');
					 	var Request = new QueryString();
						var type = Request["yee-type"];
						var name = Request["yee-name"];
						if(typeof(Request["yee-callback"])=="undefined" || !Request["yee-callback"]){
							switch(type){
								case 'select_image':
								window.opener.trans_image_data(file,name);
								break;
								case 'select_images':
								window.opener.trans_images_data(file,name);
							}
						}
						else{
							eval("window.opener."+Request["yee-callback"]+"('"+file+"','"+name+"')");
						}
						window.close();
		            },
		            handlers : {
	                    select : function(event, elfinderInstance) {
	                        var selected = event.data.selected;

	                        if (selected.length) {
	                            //console.log(elfinderInstance.file(selected[0]))
	                        }

	                    }
	                }
				}).elfinder('instance');

			});
			
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
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>
