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

defined( '_JEXEC' ) or die;
error_reporting(0); // Set E_ALL for debuging

include_once JPATH_ROOT.'/plugins/editors/yeeditor/assets/js/ckeditor/elfinder/php/'.'elFinderConnector.class.php';
include_once JPATH_ROOT.'/plugins/editors/yeeditor/assets/js/ckeditor/elfinder/php/'.'elFinder.class.php';
include_once JPATH_ROOT.'/plugins/editors/yeeditor/assets/js/ckeditor/elfinder/php/'.'elFinderVolumeDriver.class.php';
include_once JPATH_ROOT.'/plugins/editors/yeeditor/assets/js/ckeditor/elfinder/php/'.'elFinderVolumeLocalFileSystem.class.php';
// Required for MySQL storage connector
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';
// Required for FTP connector support
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from  '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}

$opts = array(
	// 'debug' => true,
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			'path'          => JPATH_ROOT.'/images/',         // '../files/',         // path to files (REQUIRED)
			'URL'           => JURI::root().'images/',        //dirname($_SERVER['PHP_SELF']) . '/../files/',  // URL to files (REQUIRED)
			'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
		)
	)
);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

