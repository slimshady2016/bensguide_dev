<?php
/*------------------------------------------------------------------------
# component_Ajax_quiz - Ajax Quiz 
# ------------------------------------------------------------------------
# author    WebKul
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.webkul.com
# Technical Support:  Forum - http://www.webkul.com/index.php?Itemid=86&option=com_kunena
-----------------------------------------------------------------------*/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
jimport('joomla.environment.uri' );
$host = JURI::root();
$document =& JFactory::getDocument();
$document->addScriptDeclaration('
    var restore_text = "'.JText::_("RESTORE").'";
	var te = "'.JText::_("TE_1").'";
	var tee = "'.JText::_("TE_2").'";
	var se = "'.JText::_("SE").'";
	var me = "'.JText::_("ME").'";
	var ee = "'.JText::_("EE").'";
	var ol = "'.JText::_("OL").'";
	var drop = "'.JText::_("DROP").'";
	var Cancel = "'.JText::_("CANCEL").'";
	var failed = "'.JText::_("FAILED").'";
	
');
$document->addStyleSheet($host.'administrator/components/com_ajaxquiz/assets/fileuploader.css');
$document->addScript($host.'administrator/components/com_ajaxquiz/assets/jquery-1.4.2.min.js');
$document->addScript($host.'administrator/components/com_ajaxquiz/assets/noconflict.js');
$document->addScriptDeclaration('
    var upload_text = "'.JText::_("UPLOAD").'";
	');
$document->addScript($host.'administrator/components/com_ajaxquiz/assets/fileuploader.js');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('behavior.modal');
JHtml::_('formbehavior.chosen', 'select');
?> 
<form action="<?php echo JRoute::_($host.'index.php?option=com_ajaxquiz&view=import'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<div id="file-uploader">       
    <noscript>          
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
    </noscript>         
</div>
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>			
		</div>					
		</table>		
	</div>	
</form>
<?php 
$document->addScriptDeclaration('
var not_writable = "'.JText::_("NOT_WRITABLE").'";
var no_files = "'.JText::_("NO_FILES").'";
var file_empty = "'.JText::_("FILE_EMPTY").'";
var file_large = "'.JText::_("FILE_LARGE").'";
var invalid_file = "'.JText::_("INVALID_FILE").'";

var save_upload = "'.JText::_("SAVE_UPLOAD").'";
var upload_cancelled = "'.JText::_("UPLOAD_CANCELLED").'";
var content_length = "'.JText::_("CONTENT_LENGTH").'";
');
?>
   <script type="text/javascript">        
        function createUploader(){   			
            var uploader = new qq.FileUploader({			
                element: document.getElementById('file-uploader'),
                action: 'components/com_ajaxquiz/views/import/upload.php?not_writable='+not_writable+'&no_files'+no_files+'&file_empty'+file_empty+'&file_large'+file_large+'&invalid_file'+invalid_file+'&save_upload'+save_upload+'&upload_cancelled'+upload_cancelled+'&content_length'+content_length+'',        
            
				
				
		// validation    
		// ex. ['jpg', 'jpeg', 'png', 'gif'] or []
		allowedExtensions: ['csv'],        
		// each file size limit in bytes
		// this option isn't supported in all browsers
		sizeLimit: 0, // max size   
		minSizeLimit: 0, // min size
                debug: true,
		onProgress: function(id, fileName, loaded, total){ },
		onComplete: function(id, fileName, responseJSON){
			//alert("file");
			jQuery.ajax({
				async:true,
				type: "POST",
  				url: 'index.php?option=com_ajaxquiz&task=import&tmpl=component',
				data:'file='+fileName,
				success: function(data) {
    						jQuery('.qq-upload-list').html('<li>'+data+'</li>');
							//alert(data);
  					}
			});	
		 }
            });           
        }
        
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
        window.onload = createUploader;     
    </script>    
