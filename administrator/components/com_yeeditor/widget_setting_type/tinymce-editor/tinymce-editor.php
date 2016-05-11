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
$root=JURI::root();

if(isset($element_param['type_attrbute']))
	$type_attrbute=$element_param['type_attrbute'];
	
$setting_value = $element_setting[$element_param['param_name']];	
?>

<textarea name="<?php echo $element_param['param_name'];?>" <?php echo $type_attrbute;?>><?php echo $setting_value;?></textarea>
<iframe id="<?php echo $element_param['param_name'];?>_iframe" name="<?php echo $element_param['param_name'];?>_iframe" width="100%" height="520" src=""></iframe>
	

<script type="text/javascript">
(function($){
	$(function() {
		IframePost = function() {
			var 
				setFrame = function(oFrm) {
					if (!oFrm.name || oFrm.name == "")
						oFrm.name = oFrm.id;
				},
				createForm = function(obj) {
					var oForm = document.createElement("form");
					oForm.id = "forPost";
					oForm.method = "post";
					oForm.action = obj.Url;
					oForm.target = obj.Target.name;
					var oIpt, arrParams;
					arrParams = obj.PostParams;
					for (var tmpName in arrParams) {
						oIpt = document.createElement("input");
						oIpt.type = "hidden";
						oIpt.name = tmpName;
						oIpt.value = arrParams[tmpName];
						oForm.appendChild(oIpt);
					}
					return oForm;
				},
				deleteForm = function() {
					var oOldFrm = document.getElementById("forPost");
					if (oOldFrm) {
						document.body.removeChild(oOldFrm);
					}
				}
		
			return {
				doPost: function(obj) {
					setFrame(obj.Target);
					deleteForm();
					var oForm = createForm(obj);
					document.body.appendChild(oForm);
					oForm.submit();
					deleteForm();
				}
			}
		} ();
	
		IframePost.doPost({ Url: yee_root+"index.php?option=com_yeeditor&view=yeeditor_transverter&tmpl=component&layout=tinymce-editor", Target:{name:"<?php echo $element_param['param_name'];?>_iframe"}, PostParams: { input_name:'<?php echo $element_param['param_name'];?>', content:$('textarea[name="<?php echo $element_param['param_name'];?>"]').val() } });
		
		
		
	})
})(window.jQuery);	

</script>
