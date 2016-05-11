<?php
/**
 * @package        JFBConnect
 * @copyright (C) 2009-2012 by Source Coast - All rights reserved
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.application' );
jimport( 'joomla.plugin.plugin' );
jimport('joomla.event.plugin');
class plgSystemAjaxfbsystem extends JPlugin
{
    var $jfbcLibrary;
    var $jfbcCanvas;    
   
    function __construct(& $subject, $config)
    {
        jimport('joomla.filesystem.file');
        $app = JFactory::getApplication();
        if (!$app->isAdmin())
        {
		
	        $canvasFile = JPATH_SITE . '/administrator/components/com_ajaxquiz/assets/src/facebook.php';
            if (!JFile::exists($canvasFile))
                JError::raiseError(0, "File missing: " . $canvasFile . "<br/>Please re-install JFBConnect or disable the JFBCSystem Plugin");
            require_once($canvasFile);
        }
        parent::__construct($subject, $config);
    }
    function onAfterInitialise()
    {
        $app = JFactory::getApplication();
        if (!$app->isAdmin())
        {
        		$arg_params = $app->getParams('com_ajaxquiz');
				$fbappid = $arg_params->get('fbappid');
				$fbappkey = $arg_params->get('fbappkey');
				$facebook = new Facebook(array(
						'appId'  => $fbappid,
						'secret' => $fbappkey,
						'cookie' => true,
				));
			
				$request = JRequest::getString('signed_request', null, 'POST');	
				$revealPage = $arg_params->get('articleid');
				$catid = $arg_params->get('catid');
				if($request) {
				$sigreq =  $facebook->getSignedRequest($request);
				$pageInfo = $sigreq['page'];
				if ($revealPage && !$pageInfo['liked'] && ((JRequest::getCmd('option') != 'com_content') || (JRequest::getCmd('view') != 'article') ||	(JRequest::getInt('id') != $revealPage)))
					{
						$app->redirect('index.php?option=com_content&view=article&tmpl=component&id=' . $revealPage);
					}
					else {
							if(JRequest::getCmd('option') != 'com_content') {      
					JRequest::setVar('option','com_ajaxquiz');
					JRequest::setVar('view','ajaxquiz');
					JRequest::setVar('cid',$catid);
					JRequest::setVar('tmpl','component');
					}
				}
			}
        }
    }
   
}
