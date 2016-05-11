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

// no direct access
defined('_JEXEC') or die;

jimport('joomla.filesystem.archive');

//widget extension install
$install_file="";
if(isset($_FILES["widget_upload"])){
    $app = JFactory::getApplication();
	$widget_install = JPATH_COMPONENT."/widgets_ex/";
	$temp_path = JPATH_COMPONENT."/views/install/tmpl/temp/";
	$widgets_frontend_path=JPATH_ROOT."/components/com_yeeditor/widgets_ex/";
	if(!is_dir($temp_path)){
		JFolder::create($temp_path);
	}

	move_uploaded_file($_FILES["widget_upload"]["tmp_name"],$temp_path.$_FILES["widget_upload"]["name"]);
	$install_file=$_FILES["widget_upload"]["name"];
	$install_path_temp=$temp_path.$install_file;
	$install_path_to=$temp_path;

     /*$zip = new ZipArchive;
     $res = $zip->open($install_path_temp);
     if ($res === TRUE) {
         $zip->extractTo($install_path_to);
         $zip->close();
     } */
	 JArchive::extract($install_path_temp, $install_path_to);
	 
	 unlink($install_path_temp);
	 
	 $install_dir=$temp_path.basename($install_file,".zip");
	 $xmlfiles=JFolder::files($install_dir, $filter = '\.xml$',false,true);
	 if($xmlfiles){
		 $xmlfile=$xmlfiles[0];
		 $xmlfile_name=basename($xmlfile,".xml");
		 
		 $database = JFactory::getDbo();
		 
		 $xml = JFactory::getXML($xmlfile);
		 $xml_info[]=$xml->title;
		 $xml_info[]=$xml->version;
		 $xml_info[]=$xml->creationDate;
		 $xml_info[]=$xml->author;
		 $xml_info[]=$xml->authorEmail;
		 $xml_info[]=$xml->authorUrl;
		 $xml_info[]=$xml->copyright;
		 $xml_info[]=$xml->license;
		 $xml_info[]=$xml->description;
		 $xml_info_str=json_encode($xml_info);
		 $setting_type=isset($xml->setting_type)?$xml->setting_type:'';
		 
		 $widget_group=$xml['group']?$xml['group']:"Social";
		 if($xml['method']=="upgrade"){
		 	JFolder::delete($widget_install.$xmlfile_name);
			$sqlquery="";
			$sqlquery = "update #__yeeditor_extensions set widget_group='".$widget_group."',author='".$xml->author."',setting_type='".$setting_type."',widget_info='".$xml_info_str."',last_update=now() where widget_name='".$xmlfile_name."'";
			$database->setQuery( $sqlquery );
			if (!$result = $database->query()) {
				JError::raiseWarning(500, JText::_('Database operation error'));
				$install_file="";
				echo $database->stderr();
				return false;
			}
			
			JFolder::move($temp_path.$xmlfile_name,$widget_install.$xmlfile_name);
			$widget_frontend_path=$widgets_frontend_path.$xmlfile_name;
			JFolder::create($widget_frontend_path);
			JFolder::move($widget_install.$xmlfile_name."/frontend",$widget_frontend_path."/frontend");
			/*if($setting_type){
				$setting_types=explode(';',$setting_type);
				foreach($setting_types as $value){
					if(trim($value)){
						JFolder::copy($widget_install.$xmlfile_name."/backend/setting_type/".$value,JPATH_COMPONENT."/widget_setting_type/".$value);
					}
				}
			}*/
			$app->enqueueMessage(JText::_('Update success'));
		 }
		 else{
			 $sqlquery="";
			 $sqlquery = "select id from #__yeeditor_extensions where widget_name='".$xmlfile_name."'";
			 $database->setQuery( $sqlquery );
			 if (!$result = $database->query()) {
				JError::raiseWarning(500, JText::_('Database operation error'));
				$install_file="";
				echo $database->stderr();
				return false;
			 }
			 $result=$database->loadObjectList();
			 
			 if(!$result){
				 $sqlquery="";
				 $sqlquery = "insert into #__yeeditor_extensions (widget_name,widget_group,author,setting_type,widget_info,install_time,last_update) value ('".$xmlfile_name."','".$widget_group."','".$xml->author."','".$setting_type."','".$xml_info_str."',now(),now())";
				 $database->setQuery( $sqlquery );
				 if (!$result = $database->query()) {
					JError::raiseWarning(500, JText::_('Database operation error'));
					$install_file="";
					echo $database->stderr();
					return false;
				 }
				 
				 JFolder::delete($widget_install.$xmlfile_name);
				 JFolder::move($temp_path.$xmlfile_name,$widget_install.$xmlfile_name);
				 $widget_frontend_path=$widgets_frontend_path.$xmlfile_name;
				 JFolder::create($widget_frontend_path);
				 JFolder::move($widget_install.$xmlfile_name."/frontend",$widget_frontend_path."/frontend");
				 /*if($setting_type){
				 	$setting_types=explode(';',$setting_type);
					foreach($setting_types as $value){
						if(trim($value)){
							JFolder::copy($widget_install.$xmlfile_name."/backend/setting_type/".$value,JPATH_COMPONENT."/widget_setting_type/".$value);
						}	
					}
				 }*/
				 $app->enqueueMessage(JText::_('Install success'));
			 }
			 else{
				 JError::raiseWarning(500, JText::_('Widget name have exist'));
				 $install_file="";
			 }
		 }
	 }
	 else{
	 	 JError::raiseWarning(500, JText::_('Can not find a xml file'));
		 $install_file="";
	 }
	 JFolder::delete($temp_path);
}

?>

<form id="install_form" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
<div class="tab-content">
	<fieldset class="uploadform">
		<legend><?php echo JText::_('COM_YEEDITOR_FIELD_INSTALL_UPLOAD'); ?></legend>
		<div class="control-group">
			<label for="install_package" class="control-label"><?php echo JText::_('COM_YEEDITOR_FIELD_INSTALL_WIDGET_PACKAGE'); ?></label>
			<div class="controls">
				<input class="input_box" id="widget_upload" name="widget_upload" type="file" size="57" />
			</div>
		</div>
		<div class="form-actions">
			<input class="btn btn-primary" id="ex_upload" name="ex_upload" type="submit" value="Upload &amp; Install" onclick="return checkfilepath('widget_upload','widget');" />
		</div>
		<label><?php echo $install_file?"<strong>".JText::_('COM_YEEDITOR_FIELD_INSTALL_INSTALL_WIDGET')."</strong>:<br><span style='color:#F92F18;margin-left: 20px;'>".$install_file."</span>":"";?></label>
	</fieldset>
</div>
</form>

<script type="text/javascript">
function checkfilepath(fileid,type){
	if(!document.getElementById(fileid).value){
	    alert("Please select a "+type+" zip file.");
		return false;
	}
	return true;
}
</script>

<?php
function deldir($dir) {
  //delete files£º
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
 
  closedir($dh);
  //delete itself dir£º
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}
