<?php 
/*------------------------------------------------------------------------
# yeeditor - YEEditor
# ------------------------------------------------------------------------
# author    Yeedeen
# copyright Copyright (C) 2013 yeedeen.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://yeedeen.com
# Technical Support: Support - http://yeedeen.com/support/
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
jimport( 'joomla.factory' );
jimport('joomla.filesystem.folder');
require_once JPATH_PLUGINS."/editors/yeeditor/define.php";

/**
 * TinyMCE Editor Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	Editors.yeeditor
 * @since		1.5
 */
class plgEditorYeeditor extends JPlugin
{
	/**
	 * Method to handle the onInitEditor event.
	 *  - Initialises the Editor
	 *
	 * @return	string	JavaScript Initialization string
	 * @since 1.5
	 */
	public function onInit()
	{
	    $root=JURI::root();
		$txt =	"<script type=\"text/javascript\">
					function insertAtCursor(myField, myValue) {
						if (document.selection) {
							// IE support
							myField.focus();
							sel = document.selection.createRange();
							sel.text = myValue;
						} else if (myField.selectionStart || myField.selectionStart == '0') {
							// MOZILLA/NETSCAPE support
							var startPos = myField.selectionStart;
							var endPos = myField.selectionEnd;
							myField.value = myField.value.substring(0, startPos)
								+ myValue
								+ myField.value.substring(endPos, myField.value.length);
						} else {
							myField.value += myValue;
						}
					}
				</script>";
		
		return $txt;
	}
	/**
	 * Copy editor content to form field.
	 *
	 * Not applicable in this editor.
	 *
	 * @return	void
	 */
	function onSave()
	{
		return;
	}
	/**
	 * Get the editor content.
	 *
	 * @param	string	$id		The id of the editor field.
	 *
	 * @return	string
	 */
	function onGetContent($id)
	{
		return "document.getElementById('$id').value;\n";
	}
	/**
	 * Set the editor content.
	 *
	 * @param	string	$id		The id of the editor field.
	 * @param	string	$html	The content to set.
	 *
	 * @return	string
	 */
	function onSetContent($id, $html)
	{
		return "document.getElementById('$id').value = $html;\n";
	}
	/**
	 * @param	string	$id
	 *
	 * @return	string
	 */
	function onGetInsertMethod($id)
	{
		static $done = false;
		// Do this only once.
		if (!$done) {
			$doc = JFactory::getDocument();
			$js = "\tfunction jInsertEditorText(text, editor) {
				insertAtCursor(document.getElementById(editor), text);
			}";
			$doc->addScriptDeclaration($js);
		}
		return true;
	}
	/**
	 * Display the editor area.
	 *
	 * @param	string	$name		The control name.
	 * @param	string	$html		The contents of the text area.
	 * @param	string	$width		The width of the text area (px or %).
	 * @param	string	$height		The height of the text area (px or %).
	 * @param	int		$col		The number of columns for the textarea.
	 * @param	int		$row		The number of rows for the textarea.
	 * @param	boolean	$buttons	True and the editor buttons will be displayed.
	 * @param	string	$id			An optional ID for the textarea (note: since 1.6). If not supplied the name is used.
	 * @param	string	$asset
	 * @param	object	$author
	 * @param	array	$params		Associative array of editor parameters.
	 *
	 * @return	string
	 */
	function onDisplay($name, $content, $width, $height, $col, $row, $buttons = true, $id = null, $asset = null, $author = null, $params = array())
	{
		require_once YEEDITOR_PATH."include/map.php";
		require_once YEEDITOR_PATH."include/functions.php";
		
		$root=JURI::root();
		$location = 'isAdmin';
		
		$app = JFactory::getApplication();
		if ($app->isAdmin()) { 
			$root .= "administrator/";
			$location = 'isAdmin';
		}
		else{
			$location = 'isFront';
		}
		
		if (empty($id)) {
			$id = $name;
		}
		// Only add "px" to width and height if they are not given as a percentage
		if (is_numeric($width)) {
			$width .= 'px';
		}
		if (is_numeric($height)) {
			$height .= 'px';
		}

		$otherEditorToogleJS = $this->otherEditorToogleJS();
		$this->yeeditorExCss();
		
		//get yeeditor statu
		$editor_status = get_yeeditor_option('yeeditor_editor_status');
		
		if( $editor_status == 0 ){
			JHtml::_('jquery.framework');
			$otherEditorToogleButton = '<div class="control-group"><div class="control-label"><label id="otherEditorToogleButton" data-status="'.$editor_status.'" class="btn btn-warning">'.JText::_('YEEDITOR_WRAPPER_YEEDITOR').'</label></div></div>';
			$other_editor = get_yeeditor_option('yeeditor_other_editor');
			$editor=new JEditor($other_editor);
			return $otherEditorToogleJS.$otherEditorToogleButton.$editor->display($id,$content,"100%","300px",100,5,array(""));
		}	
		else{
			$yeecontent = "";
			// get yeeditor wrapper
			ob_start();	
			include JPATH_ROOT."/plugins/editors/yeeditor/blocks/yeeditor_wrapper.php";
			$yeecontent = ob_get_contents();
			ob_end_clean();
			
			$editor = $otherEditorToogleJS.$yeecontent."<textarea class='hide' name=\"$name\" id=\"$id\" cols=\"$col\" rows=\"$row\" style=\"width: $width; height: $height;\">$content</textarea>" ;
			return $editor;
		}	
	}
	
	private function yeeditorExCss(){
		$document =JFactory::getDocument();
		$document->addStyleDeclaration( '/* modify joomla 3.x backend theme */
					.form-horizontal.mod_yeeditor .controls {
						margin-left: 10px;
					}');		
	}
	
	private function otherEditorToogleJS(){
	    $root=JURI::root();
	    $return='
		<script type="text/javascript">
		!(function($){
			$(function(){
				if($("#jform_module").val()=="mod_yeeditor"){
					$(".form-horizontal").addClass("mod_yeeditor");
				}
				$("#otherEditorToogleButton").click(function(e){
					e.preventDefault();
					if(confirm("'.JText::_('YEEDITOR_WRAPPER_LOAD_OTHER_EDITOR_WARNING').'")){
						var yeeditor_editor_status = $(this).attr("data-status");	
						yeeditor_editor_status = yeeditor_editor_status==1?0:1;
	
						$.ajax({
								type: "POST",
								url: "index.php?option=com_yeeditor&task=yeeditor_action&layout=save_option&format=raw", 
								dataType : "html",
								data: {
									   action  : "yeeditor_editor_status",
									   value   : yeeditor_editor_status
								},
								success: function (data) {
									location.reload();
								}
						})	
					}	
				})
			})	
		})(window.jQuery);
		</script>			
		';
		return $return;
	}
	
}
