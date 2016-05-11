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
    // Helper function to get parameters from the query string.
    function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
        var match = window.location.search.match(reParam) ;
        
        return (match && match.length > 1) ? match[1] : '' ;
    }

    $().ready(function() {
        var funcNum = getUrlParam('CKEditorFuncNum');

        var elf = $('#elfinder').elfinder({
            url : window.opener.yee_root+"index.php?option=com_yeeditor&task=yeeditor_action&layout=elfinder&format=raw&data=1",
            getFileCallback : function(file) {
				file = file.replace(window.opener.yee_frontend,'');
                window.opener.CKEDITOR.tools.callFunction(funcNum, window.opener.yee_frontend + file);
                window.close();
            },
            resizable: false
        }).elfinder('instance');
    });
</script>
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>
